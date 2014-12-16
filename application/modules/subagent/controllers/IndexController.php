<?php

class Subagent_IndexController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/subagent';
	private $subactivelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	
    public function init()
    {
        /* Initialize action controller here */
    	/* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	
    	//clear all other sessions
    	Application_Form_FrmSessionManager::clearSessionSearch();
    }

    public function indexAction()
    {
        // action body
        //create sesesion
        $session_search_subagent=new Zend_Session_Namespace('search_subagent');
        if(empty($session_search_subagent->limit)){
        	$session_search_subagent->limit =  Application_Form_FrmNavigation::getLimit();        	    	
        	$session_search_subagent->active  = -1;
        	$session_search_subagent->province  = -1;
        	$session_search_subagent->agent  = -1;
        	$session_search_subagent->txtsearch = '';      	
        	$session_search_subagent->lock();
        }
        
    	//start page nevigation                	
        $limit = $session_search_subagent->limit;
    	$start = $this->getRequest()->getParam('limit_satrt',0);
        
        $pro = new Application_Model_DbTable_DbProvinces();
		$this->view->provincelist = $pro->getProvinceList();
		$this->view->province = $session_search_subagent->province;
		
		$agent = new Application_Model_DbTable_DbAgents();
		$this->view->agentlist = $agent->getAgentListSelect();
		$this->view->agent = $session_search_subagent->agent;
		
		
		$db_sub_agent=new Application_Model_DbTable_DbSubAgent();
    	
        $this->view->activelist =$this->subactivelist;       
        $this->view->active = $session_search_subagent->active;
        
        if($this->getRequest()->isPost()){     	
        	$agent_seach_data=$this->getRequest()->getPost();  
        	
        	//set session when submit
        	$session_search_subagent->unlock();
        	$session_search_subagent->limit =  $agent_seach_data['rows_per_page'];        	    	
        	$session_search_subagent->active  = $agent_seach_data['active'];
        	$session_search_subagent->province  = $agent_seach_data['province'];
        	$session_search_subagent->agent = $agent_seach_data['agent'];
        	$session_search_subagent->txtsearch = $agent_seach_data['txtsearch'];      	
        	$session_search_subagent->lock();
        	
        	$this->view->province = $agent_seach_data['province'];  
        	$this->view->txtsearch  = $agent_seach_data['txtsearch'];        	
        	$this->view->active  = $agent_seach_data['active'];       
        	$this->view->agent  = $agent_seach_data['agent'];   
        	
        	$limit = $session_search_subagent->limit;
        	  	     	 	
        	$sub_agents= $db_sub_agent->getSubAgentListBy($agent_seach_data, $start, $limit);  
        	$record_count = $db_sub_agent->getSubAgentListTotal($agent_seach_data);        	      	
        }
        else{
        	if(!empty($session_search_subagent->txtsearch ) || $session_search_subagent->active > -1 
        	   || $session_search_subagent->province > -1 || $session_search_subagent->agent > -1){
        		$agent_seach_data = array(
        								  	'active'=>$session_search_subagent->active,
								        	'province'=>$session_search_subagent->province,
        									'agent'=>$session_search_subagent->agent,
								        	'txtsearch'=>$session_search_subagent->txtsearch 
        								 );
        		$sub_agents= $db_sub_agent->getSubAgentListBy($agent_seach_data, $start, $limit);  
        		$record_count = $db_sub_agent->getSubAgentListTotal($agent_seach_data);  
        	}
        	else{
	        	$sub_agents = $db_sub_agent->getSubAgentList($start, $limit);
	        	$record_count = $db_sub_agent->getSubAgentListTotal();
        	}  
        }
        
        $result = array();
        $row_num = $start;
        foreach ($sub_agents as $i => $sub_agent) {					
        	$result[$i] = array(
        				'num' => (++$row_num),
        				'id' => $sub_agent['id'],
        				'tel' => $sub_agent['tel'], 
        				'name' => $sub_agent['name'], 
        				'agent_name' => $sub_agent['agent_name'], 
        				'proname' =>  $sub_agent['proname'], 
        				'khan'=> $sub_agent['khan'], 
        				'sangkat'=> $sub_agent['sangkat'], 
        				'block'=> $sub_agent['block']
        				);
        }
        
        $this->view->subagentlist = Zend_Json::encode($result);
        $page = new Application_Form_FrmNavigation(self::REDIRECT_URL, $start, $limit, $record_count);	        
        $page->init(self::REDIRECT_URL, $start, $limit, $record_count);
        $this->view->nevigation = $page->navigationPage();
        $this->view->rows_per_page = $page->getRowsPerPage($limit, 'frmlist_subagent');
        $this->view->result_row = $page->getResultRows();
    }

    public function viewAction()
    {
        // action body
    }

    public function addAction()
    {
        // action body
        $pro = new Application_Model_DbTable_DbProvinces();
		$this->view->provinces = $pro->getProvinceListAll();
		
		$agent = new Application_Model_DbTable_DbAgents();
		$this->view->agentlist = $agent->getAgentListSelect();
		
    	if($this->getRequest()->isPost()){
			$subagentdata=$this->getRequest()->getPost();	
			$db_sub_agent = new Application_Model_DbTable_DbSubAgent();				
			try {
				$db = $db_sub_agent->insertSubAgent($subagentdata);				
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);		
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
    }

    public function editedAction()
    {
        // action body
        $subag_id = $this->getRequest()->getParam('subag_id');
        $subag_id = (empty($subag_id))? 0 : $subag_id; 
        
    	$pro = new Application_Model_DbTable_DbProvinces();
		$this->view->provinces = $pro->getProvinceListAll();
		
		$agent = new Application_Model_DbTable_DbAgents();
		$this->view->agentlist = $agent->getAgentListSelect();
		
		$db_subagent = new Application_Model_DbTable_DbSubAgent();
		$this->view->subagent_edit = $db_subagent->getSubAgentEditedById($subag_id);
		
    	if($this->getRequest()->isPost()){
			$subagentdata=$this->getRequest()->getPost();	
						
			try {
				$db = $db_subagent->updateSubAgent($subagentdata);				
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);		
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
    }


}







