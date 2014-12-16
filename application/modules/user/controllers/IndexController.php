<?php

class User_IndexController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/user';
	const MAX_USER = 20;
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	private $user_typelist = array();
	
    public function init()
    {    	
        /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	
    	//clear all other sessions
    	Application_Form_FrmSessionManager::clearSessionSearch();
    	
    	$db=new Application_Model_DbTable_DbGlobal();
    	$sql = "SELECT u.user_type_id,u.user_type FROM `rsv_acl_user_type` u where u.`status`=1";
    	$results = $db->getGlobalDb($sql);
		foreach ($results as $key => $r){
			$this->user_typelist[$r['user_type_id']] = $r['user_type'];    
		}		
	}

    public function indexAction()
    {
        // action body
        //create sesesion
        $session_search_user=new Zend_Session_Namespace('search_user');
        if(empty($session_search_user->limit)){
        	$session_search_user->limit =  Application_Form_FrmNavigation::getLimit();        	    	
        	$session_search_user->active  = -1;
        	$session_search_user->user_type = -1;
        	$session_search_user->txtsearch = '';      	
        	$session_search_user->lock();
        }        
    	
        //start page nevigation                	
        $limit = $session_search_user->limit;
    	$start = $this->getRequest()->getParam('limit_satrt',0);
    	
        $db_user=new Application_Model_DbTable_DbUsers();
                
        $this->view->activelist =$this->activelist;       
        $this->view->active = $session_search_user->active;
        
        $this->view->user_typelist =$this->user_typelist;       
        $this->view->user_type = $session_search_user->user_type;
        
		
        if($this->getRequest()->isPost()){     	
        	$user_seach_data=$this->getRequest()->getPost();
        	//set session when submit  
        	$session_search_user->unlock();
        	$session_search_user->limit =  $user_seach_data['rows_per_page'];        	
        	$session_search_user->active  = $user_seach_data['active'];
        	$session_search_user->user_type = $user_seach_data['user_type'];
        	$session_search_user->txtsearch = $user_seach_data['txtsearch'];  	
        	$session_search_user->lock();
        	      	  
        	//set value for display
        	$this->view->txtsearch  = $user_seach_data['txtsearch'];
        	$this->view->active  = $user_seach_data['active'];
        	$this->view->user_type = $user_seach_data['user_type'];
        	$limit = $user_seach_data['rows_per_page'];        	        	     	 	
        	    
			$users= $db_user->getUserListBy($user_seach_data, $start, $limit);  
        	$record_count = $db_user->getUserListTotal($user_seach_data);
        }
        else{
        	if($session_search_user->active > -1 || $session_search_user->user_type > -1 ||
        		 !empty($session_search_user->txtsearch) ){
        			$user_seach_data = array(
        										'active'=>$session_search_user->active,
									        	'user_type'=>$session_search_user->user_type,
									        	'txtsearch'=>$session_search_user->txtsearch
        									);
        			$users= $db_user->getUserListBy($user_seach_data, $start, $limit);  
        			$record_count = $db_user->getUserListTotal($user_seach_data);
        	}
        	else{
	        	$users = $db_user->getUserList($start, $limit);
	        	$record_count = $db_user->getUserListTotal();
        	}
        }
        
            
        $result = array();
        $row_num = $start;
        foreach ($users as $i => $user) {					
        	$result[$i] = array(
        				'num' => (++$row_num),	        				
        				'name' => $user['name'],
        				'id' => $user['id'],  
        				'user_name' =>  $user['user_name'], 
        				'active' => $this->activelist[$user['active']] ,
        				'user_type'=> $this->user_typelist[$user['user_type']] 
        				);
        }
        
        
        $this->view->userlist = Zend_Json::encode($result);
        $page = new Application_Form_FrmNavigation(self::REDIRECT_URL, $start, $limit, $record_count);	        
        $page->init(self::REDIRECT_URL, $start, $limit, $record_count);
        $this->view->nevigation = $page->navigationPage();
        $this->view->rows_per_page = $page->getRowsPerPage($limit, 'frmlist_users');
        $this->view->result_row = $page->getResultRows();	        
        
    }

    public function viewAction()
    {
        // action body
        $us_id = $this->getRequest()->getParam('us_id');
    	$us_id = (empty($us_id))? 0 : $us_id;
    	
        $db_user=new Application_Model_DbTable_DbUsers();
        $this->view->user_view = $db_user->getUserView($us_id);
    }

    public function addAction()
    {
        // action body
    	$db_user=new Application_Model_DbTable_DbUsers();
    	
    	if ($db_user->getMaxUser() > self::MAX_USER) {
    		Application_Form_FrmMessage::Sucessfull('អ្នក​ប្រើ​ប្រាស់​របស់​អ្នក​បាន​ត្រឹម​តែ '.self::MAX_USER.' នាក់ ទេ!', self::REDIRECT_URL);    		
    	}
    	
        $this->view->user_typelist =$this->user_typelist;  
        
    	if($this->getRequest()->isPost()){
			$userdata=$this->getRequest()->getPost();	
			
			try {
				$db = $db_user->insertUser($userdata);				
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);		
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
    }

    public function editedAction()
    {
        // action body
        $us_id = $this->getRequest()->getParam('us_id');
    	$us_id = (empty($us_id))? 0 : $us_id;
    	
        $db_user=new Application_Model_DbTable_DbUsers();
        $this->view->user_edit = $db_user->getUserEdit($us_id);

        $this->view->user_typelist =$this->user_typelist;  
        
    	if($this->getRequest()->isPost()){
			$userdata=$this->getRequest()->getPost();	
			
			try {
				$db = $db_user->updateUser($userdata);				
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);		
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
    }


}







