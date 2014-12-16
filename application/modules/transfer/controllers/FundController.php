<?php

class Transfer_FundController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/agent';
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	
    public function init()
    {
        /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	
    	//clear all other sessions
    	Application_Form_FrmSessionManager::clearSessionSearch();
    }

    public function indexAction()
    {
        // action body
	    //create sesesion
        $session_search_agent=new Zend_Session_Namespace('search_agent');
        if(empty($session_search_agent->limit)){
        	$session_search_agent->limit =  Application_Form_FrmNavigation::getLimit();        	    	
        	$session_search_agent->active  = -1;
        	$session_search_agent->province  = -1;
        	$session_search_agent->txtsearch = '';      	
        	$session_search_agent->lock();
        }
        
    	//start page nevigation                	
        $limit = $session_search_agent->limit;
    	$start = $this->getRequest()->getParam('limit_satrt',0);
        
        $pro = new Application_Model_DbTable_DbProvinces();
		$this->view->provincelist = $pro->getProvinceList();
		$this->view->province = $session_search_agent->province;
		
		$db_agent=new Application_Model_DbTable_DbAgents();
    	
        $this->view->activelist =$this->activelist;       
        $this->view->active = $session_search_agent->active;
        
        if($this->getRequest()->isPost()){     	
        	$agent_seach_data=$this->getRequest()->getPost();  
        	
        	//set session when submit
        	$session_search_agent->unlock();
        	$session_search_agent->limit =  $agent_seach_data['rows_per_page'];        	    	
        	$session_search_agent->active  = $agent_seach_data['active'];
        	$session_search_agent->province  = $agent_seach_data['province'];
        	$session_search_agent->txtsearch = $agent_seach_data['txtsearch'];      	
        	$session_search_agent->lock();
        	
        	$this->view->province = $agent_seach_data['province'];  
        	$this->view->txtsearch  = $agent_seach_data['txtsearch'];        	
        	$this->view->active  = $agent_seach_data['active'];       
        	
        	$limit = $session_search_agent->limit;
        	  	     	 	
        	$agents= $db_agent->getAgentListBy($agent_seach_data, $start, $limit);  
        	$record_count = $db_agent->getAgentListTotal($agent_seach_data);        	      	
        }
        else{
        	if(!empty($session_search_agent->txtsearch ) || $session_search_agent->active > -1 || $session_search_agent->province > -1){
        		$agent_seach_data = array(
        								  	'active'=>$session_search_agent->active,
								        	'province'=>$session_search_agent->province,
								        	'txtsearch'=>$session_search_agent->txtsearch 
        								 );
        		$agents= $db_agent->getAgentListBy($agent_seach_data, $start, $limit);  
        		$record_count = $db_agent->getAgentListTotal($agent_seach_data);  
        	}
        	else{
	        	$agents = $db_agent->getAgentList($start, $limit);
	        	$record_count = $db_agent->getAgentListTotal();
        	}  
        }
        
	        $result = array();
	        $row_num = $start;
	        foreach ($agents as $i => $agent) {					
	        	$result[$i] = array(
	        				'num' => (++$row_num),
	        				'id' => $agent['id'],
	        				'tel' => $agent['tel'], 
	        				'name' => $agent['name'], 
	        				'proname' =>  $agent['proname'], 
	        				'khan'=> $agent['khan'], 
	        				'sangkat'=> $agent['sangkat'], 
	        				'block'=> $agent['block']
	        				);
	        }
	        
	        $this->view->agentlist = Zend_Json::encode($result);
	        $page = new Application_Form_FrmNavigation(self::REDIRECT_URL, $start, $limit, $record_count);	        
	        $page->init(self::REDIRECT_URL, $start, $limit, $record_count);
	        $this->view->nevigation = $page->navigationPage();
	        $this->view->rows_per_page = $page->getRowsPerPage($limit, 'frmlist_agent');
	        $this->view->result_row = $page->getResultRows();
        
    }

 public function addAction()
    {
       
		
//     	if($this->getRequest()->isPost()){
// 			$agentdata=$this->getRequest()->getPost();	
// 			$Fund = new Fund_Form_Frmfund();				
// 			try {
// 				$db = $Fund->payment($agentdata);				
// 				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);		
// 			} catch (Exception $e) {
// 				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
// 			}
// 		}
    	$frm=new Transfer_Form_Frmfund();
    	$from = $frm->addFund();
    	Application_Model_Decorator::removeAllDecorator($from);
    	$this->view->frm=$from;
    }


}







