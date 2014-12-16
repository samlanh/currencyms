<?php

class RsvAcl_UserTypeController extends Zend_Controller_Action
{
	
	const REDIRECT_URL = '/rsvAcl/user-type';
	
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
    		$session_transfer=new Zend_Session_Namespace('search_user_type');
    		if(empty($session_transfer->limit)){
    			$session_transfer->limit =  Application_Form_FrmNavigation::getLimit();
    			$session_transfer->lock();
    		}
    		    	
    		 
    		
    		$sql = "SELECT u.user_type_id,u.user_type,(SELECT u1.user_type FROM `rsv_acl_user_type` u1 WHERE u1.user_type_id = u.parent_id LIMIT 1) parent_id, status FROM `rsv_acl_user_type` u";
    		
    		
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
    	
    		$this->view->tranlist = Zend_Json::encode($result);
    		$page = new Application_Form_FrmNavigation(self::REDIRECT_URL, $start, $limit, $record_count);
    		$page->init(self::REDIRECT_URL, $start, $limit, $record_count);
    		$this->view->nevigation = $page->navigationPage();
    		$this->view->rows_per_page = $page->getRowsPerPage($limit, 'frmlist');
    		$this->view->result_row = $page->getResultRows();
    	} catch (Exception $e) {}
    }
    
    public function viewUserTypeAction()
    {   
    	/* Initialize action controller here */
    	if($this->getRequest()->getParam('id')){
    		$db = new RsvAcl_Model_DbTable_DbUserType();
    		$user_type_id = $this->getRequest()->getParam('id');
    		$rs=$db->getUserType($user_type_id);
    		$this->view->rs=$rs;
    	}  	 
    	
    }
	public function addUserTypeAction()
		{
// 			$form=new RsvAcl_Form_FrmUserType();	
// 			$this->view->form=$form;
			
			if($this->getRequest()->isPost())
			{
				$db=new RsvAcl_Model_DbTable_DbUserType();	
				$post=$this->getRequest()->getPost();			
				if(!$db->isUserTypeExist($post['user_type'])){
						
						$id=$db->insertUserType($post);						
						 //write log file 
				             $userLog= new Application_Model_Log();
				    		 $userLog->writeUserLog($id);
				     	  //End write log file
				
						//Application_Form_FrmMessage::message('One row affected!');
						Application_Form_FrmMessage::redirector('/rsvAcl/user-type/index');																			
				}else {
					Application_Form_FrmMessage::message('User type had existed already');
				}
			}
			
			
			$db=new Application_Model_DbTable_DbGlobal();
			$rs=$db->getGlobalDb('SELECT user_type_id,user_type FROM rsv_acl_user_type WHERE status=1');
			$options=array(''=>'Please select');
			foreach($rs as $read) $options[$read['user_type_id']]=$read['user_type'];
			$this->view->usertype_list= $options;
				
			
	}
	
    public function editUserTypeAction()
    {	
    	if($this->getRequest()->getParam('id')){
    		$db = new RsvAcl_Model_DbTable_DbUserType();
    		$user_type_id = $this->getRequest()->getParam('id');
    		$rs=$db->getUserType($user_type_id);
    		$this->view->usertype=$rs;
    		$db1=new Application_Model_DbTable_DbGlobal();
    		$allusertype=$db1->getGlobalDb('SELECT user_type_id,user_type FROM rsv_acl_user_type WHERE status=1 AND user_type_id <> '.$user_type_id);
    		$options=array(''=>'Please select');
    		foreach($allusertype as $read) $options[$read['user_type_id']]=$read['user_type'];
    		$this->view->usertype_list= $options;
    	
    	}
    	else{
    		Application_Form_FrmMessage::message('User type had not existed');
    	}
    	
    	if($this->getRequest()->isPost())
		{
			$post=$this->getRequest()->getPost();
			//print_r($rs); exit;
			if($rs['user_type']==$post['user_type']){
																						
					$db->updateUserType($post,$rs['user_type_id']);
					
					  //write log file 
				             $userLog= new Application_Model_Log();
				    		 $userLog->writeUserLog($user_type_id);
				     	  //End write log file
					//Application_Form_FrmMessage::message('One row affected!');
					Application_Form_FrmMessage::redirector('/rsvAcl/user-type/index');																																				
				
			}else{
				if(!$db->isUserTypeExist($post['user_type'])){
					$db->updateUserType($post,$rs['user_type_id']);
					 //write log file 
				             $userLog= new Application_Model_Log();
				    		 $userLog->writeUserLog($user_type_id);
				     //End write log file
					//Application_Form_FrmMessage::message('One row affected!');
					Application_Form_FrmMessage::redirector('/rsvAcl/user-type/index');						
				}else {
					Application_Form_FrmMessage::message('User had existed already');
				}
			}
		}
    }
    
   


}

