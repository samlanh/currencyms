<?php
class RsvAcl_AclController extends Zend_Controller_Action
{

	const REDIRECT_URL = '/rsvAcl/acl';
	
	public function init()
    {
        /* Initialize action controller here */
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
    }

    public function indexAction()
    {
        // action body         
        try {
        	$db_tran=new Application_Model_DbTable_DbGlobal();
        	 
        	//create sesesion
        	$session_transfer=new Zend_Session_Namespace('search_acl');
        	if(empty($session_transfer->limit)){
        		$session_transfer->limit =  Application_Form_FrmNavigation::getLimit();
        		$session_transfer->lock();
        	}
        
        	$sql = "SELECT `acl_id`,`module`,`controller`,`action`,`status` FROM rsv_acl_acl";
        
        
        	if($this->getRequest()->isPost()){
        		$formdata=$this->getRequest()->getPost();
        		$session_transfer->unlock();
        		$session_transfer->limit =  $formdata['rows_per_page'];
        		$session_transfer->lock();
        	}
        
        
        	//start page nevigation
        	$limit = $session_transfer->limit;
        	$start = $this->getRequest()->getParam('limit_satrt',0);
        	$result = $db_tran->getGlobalDbListBy($sql, $start, $limit);
        	$record_count = $db_tran->getGlobalDbListTotal($sql);
        
        	$row_num = $start;
        	if (empty($result)){
        		$result = array('err'=>1, 'msg'=>'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!');
        	}
        	 //print_r($result); exit;
        	$this->view->list = Zend_Json::encode($result);
        	$page = new Application_Form_FrmNavigation(self::REDIRECT_URL, $start, $limit, $record_count);
        	$page->init(self::REDIRECT_URL, $start, $limit, $record_count);
        	$this->view->nevigation = $page->navigationPage();
        	$this->view->rows_per_page = $page->getRowsPerPage($limit, 'frmlist');
        	$this->view->result_row = $page->getResultRows();
        } catch (Exception $e) {}
    }
    
    public function viewAclAction()
    {   
    	/* Initialize action controller here */
    	if($this->getRequest()->getParam('id')){
    		$db = new RsvAcl_Model_DbTable_DbAcl();
    		$acl_id = $this->getRequest()->getParam('id');
    		//echo $acl_id; exit;
    		$rs=$db->getAcl($acl_id);
    		//print_r($rs); exit;
    		$this->view->acl_data=$rs;
    	}  	 
    	
    }
	public function addAclAction()
		{
			$form = new RsvAcl_Form_FrmAcl();	
			$this->view->form=$form;
			
			if($this->getRequest()->isPost())
			{
				$db=new RsvAcl_Model_DbTable_DbAcl();	
				$post=$this->getRequest()->getPost();
							
				//if(!$db->isActionExist($post['action'])){
					  
						$id=$db->insertAcl($post);
						 //write log file 
				             $userLog= new Application_Model_Log();
				    		 $userLog->writeUserLog($id);
				     	  //End write log file
				
						//Application_Form_FrmMessage::message('One row affected!');
						Application_Form_FrmMessage::redirector('/rsvAcl/acl/index');																			
				//}else {
					Application_Form_FrmMessage::message('Action had existed already');
				//}
			}
		}
    public function editAclAction()
    {	
    	$acl_id=$this->getRequest()->getParam('id');
    	if(!$acl_id)$acl_id=0;  
    	   	  
   		$form = new RsvAcl_Form_FrmAcl();
    	     	
    	$db = new RsvAcl_Model_DbTable_DbAcl();
        $rs = $db->getUserInfo('SELECT * FROM rsv_acl_acl where acl_id='.$acl_id);
       
// 		Application_Model_Decorator::setForm($form, $rs);
		
// 		if($this->getRequest()->getParam('id')){			
// 			$id = $this->getRequest()->getParam('id');			
// 			$this->view->usertype=$rs;
// 			$db1=new RsvAcl_Model_DbTable_DbAcl();
// 			$rs=$db1->getUserInfo('SELECT * FROM rsv_acl_acl where acl_id= '.$id);
// 		}
// 		else{
// 			Application_Form_FrmMessage::message('ACL had not existed');
// 		}
		
    	//$this->view->form = $form;
        $this->view->acl_data = $rs[0];
    	$this->view->acl_id = $acl_id;
    	
    	if($this->getRequest()->isPost())
		{
			$post=$this->getRequest()->getPost();
			if($rs[0]['action']==$post['action']){																			
					$db->updateAcl($post,$rs[0]['acl_id']);
					  //write log file 
				             $userLog= new Application_Model_Log();
				    		 $userLog->writeUserLog($acl_id);
				     	  //End write log file
					//Application_Form_FrmMessage::message('One row affected!');
					Application_Form_FrmMessage::redirector('/rsvAcl/acl/index');																																				
				
			}else{
				if(!$db->isActionExist($post['action'])){
					$db->updateAcl($post,$rs[0]['acl_id']);
					 //write log file 
				             $userLog= new Application_Model_Log();
				    		 $userLog->writeUserLog($acl_id);
				     	  //End write log file
					//Application_Form_FrmMessage::message('One row affected!');
					Application_Form_FrmMessage::redirector('/rsvAcl/acl/index');						
				}else {
					Application_Form_FrmMessage::message('Action had existed already');
				}
			}
		}
    }


}

