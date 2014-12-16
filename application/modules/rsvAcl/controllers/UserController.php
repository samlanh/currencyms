<?php

class RsvAcl_UserController extends Zend_Controller_Action
{

	
    public function init()
    {
        /* Initialize action controller here */
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
    }

    public function indexAction()
    {
		$formfilter=new RsvAcl_Form_FrmUser();
		$this->view->formfilter=$formfilter;
    	$where = "";
		// action body
    	$tr = Application_Form_FrmLanguages::getCurrentlanguage();
        $getUser = new RsvAcl_Model_DbTable_DbUser();
              
        if($this->getRequest()->getParam('user_type_filter')){
			$user_type_id = $this->getRequest()->getParam('user_type_filter');
			$where=" where user_type_id=".$user_type_id;
		}
        $userQuery = "select 
        					u.`user_id`,
        					u.`username`,
        					u.`created_date`,
        					u.`modified_date`, 
        					(SELECT ut.`user_type` FROM `rsv_acl_user_type` AS ut WHERE ut.`user_type_id` = u.`user_type_id`) as u_type,
        					(SELECT c.`name_sh` FROM `fi_cso` AS c WHERE c.`id` = 
        						(SELECT i.`cso_id` FROM `fi_users_info` AS i WHERE i.`id` = u.`user_id`)
        					) as cso_name,
        					u.`status` 
        			  from rsv_acl_user as u";
        $userQuery = $userQuery.$where;
        
        $rows = $getUser->getUserInfo($userQuery);
        if($rows){
        	$imgnone='<img src="'.BASE_URL.'/images/icon/none.png"/>';
        	$imgtick='<img src="'.BASE_URL.'/images/icon/tick.png"/>';
        	        	        	
        	foreach ($rows as $i =>$row){
        		if($row['status'] == 1){
        			$rows[$i]['status'] = $imgtick;
        		}
        		else{
        			$rows[$i]['status'] = $imgnone;
        		}
        	}
        	
        	$link = array("rsvAcl","user","view-user");
        	$links = array('username'=>$link);
        	
        	$list=new Application_Form_Frmlist();
        	$columns=array('NAME','CREATED_DATE','MODIFIED_DATE','TYPE_OF','CSO', 'STATUS');
        	$this->view->form=$list->getCheckList('radio', $columns, $rows, $links);
        	
        }else $this->view->form = $tr->translate('NO_RECORD_FOUND');
        
        Application_Model_Decorator::removeAllDecorator($formfilter);
        
    }
    
    public function viewUserAction()
    {   
    	/* Initialize action controller here */
    	if($this->getRequest()->getParam('id')){
    		$db = new RsvAcl_Model_DbTable_DbUser();
    		$user_id = $this->getRequest()->getParam('id');
    		$rs=$db->getUser($user_id);
    		//print_r($rs); exit;
    		$this->view->rs=$rs;
    	}  	 
    	
    }
	public function addUserAction()
		{
			$form=new RsvAcl_Form_FrmUser();	
			$this->view->form=$form;
			
			if($this->getRequest()->isPost())
			{
				$db=new RsvAcl_Model_DbTable_DbUser();	
				$post=$this->getRequest()->getPost();			
				if(!$db->isUserExist($post['username'])){
					
						$id=$db->insertUser($post);
						  //write log file 
				             $userLog= new Application_Model_Log();
				    		 $userLog->writeUserLog($id);
				     	  //End write log file
				
						//Application_Form_FrmMessage::message('One row affected!');
						Application_Form_FrmMessage::redirector('/rsvAcl/user/index');																			
				}else {
					Application_Form_FrmMessage::message('User had existed already');
				}
			}
			Application_Model_Decorator::removeAllDecorator($form);
		}
    public function editUserAction()
    {	
    	$user_id=$this->getRequest()->getParam('id');
    	if(!$user_id)$user_id=0;  
    	   	  
   		$form = new RsvAcl_Form_FrmUser();
    	     	
    	$db = new RsvAcl_Model_DbTable_DbUser();
        //$rs = $db->getUserInfo('SELECT * FROM rsv_acl_user where user_id='.$user_id);
    	$rs = $db->getUserInfo('SELECT au.*, ui.name, ui.title, ui.cso_id FROM rsv_acl_user AS au, fi_users_info AS ui WHERE au.user_id='.$user_id.' AND ui.id='.$user_id);
       
		Application_Model_Decorator::setForm($form, $rs);
		
    	$this->view->form = $form;
    	$this->view->user_id = $user_id;
    	if($this->getRequest()->isPost())
		{
			$post=$this->getRequest()->getPost();
			if($rs[0]['username']==$post['username']){																			
					$db->updateUser($post,$rs[0]['user_id']);
					  //write log file 
				             $userLog= new Application_Model_Log();
				    		 $userLog->writeUserLog($user_id);
				     	  //End write log file
					//Application_Form_FrmMessage::message('One row affected!');
					Application_Form_FrmMessage::redirector('/rsvAcl/user/index');																																				
				
			}else{
				if(!$db->isUserExist($post['username'])){
					$db->updateUser($post,$rs[0]['user_id']);
					 //write log file 
				             $userLog= new Application_Model_Log();
				    		 $userLog->writeUserLog($user_id);
				     	  //End write log file
					//Application_Form_FrmMessage::message('One row affected!');
					Application_Form_FrmMessage::redirector('/rsvAcl/user/index');						
				}else {
					Application_Form_FrmMessage::message('User had existed already');
				}
			}
		}
		Application_Model_Decorator::removeAllDecorator($form);
    }
    
 
    public function changePasswordAction()
	{
		$session_user=new Zend_Session_Namespace('auth');
		
		if($session_user->user_id==$this->getRequest()->getParam('id') OR $session_user->level == 1){
			$form = new RsvAcl_Form_FrmChgpwd();	
			//echo $form->getElement('current_password'); exit;	
			$this->view->form=$form;
			//echo "Work"; exit; 
			
			if($this->getRequest()->isPost())
			{
				$db=new RsvAcl_Model_DbTable_DbUser();
				$user_id=$this->getRequest()->getParam('id');		
				if(!$user_id) $user_id=0;			
				$current_password=$this->getRequest()->getParam('current_password');
				$password=$this->getRequest()->getParam('password');
				if($db->isValidCurrentPassword($user_id,$current_password)){ 
					$db->changePassword($user_id, md5($password));	
					      //write log file 
					             $userLog= new Application_Model_Log();
					    		 $userLog->writeUserLog($user_id);
					     	  //End write log file		
					Application_Form_FrmMessage::message('Password has been changed');
					Application_Form_FrmMessage::redirector('/rsvAcl/user/view-user/id/'.$user_id);
				}else{
					Application_Form_FrmMessage::message('Invalid current password');
				}
			}		
		}else{ 
			   Application_Form_FrmMessage::message('Access Denied!');
		       Application_Form_FrmMessage::redirector('/rsvAcl');	
		}
		
	}

}

