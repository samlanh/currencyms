<?php

class Partner_IndexController extends Zend_Controller_Action
{
 	const REDIRECT_URL = '/partner/index/add';
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	
    public function init()
    {
        /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
    	
    	//clear all other sessions
    	Application_Form_FrmSessionManager::clearSessionSearch();
    }

    public function indexAction()
    {
    	try{
    		$db = new Partner_Model_DbTable_DbPartner();
//     		if($this->getRequest()->isPost()){
//     			$search=$this->getRequest()->getPost();
//     		}
//     		else{
//     			$search = array(
//     					'adv_search' => '',
//     					'status' => -1);
//     		}
    		$rs_rows= $db->getAllPartner($search=null);
    	    
//     		$glClass = new Application_Model_GlobalClass();
//     		$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true,null);
    		$list = new Application_Form_Frmtable();
    		$collumns = array("parent","partner_brand","partner_name","account_no",
    				"nation_id","house_no","group_no","street","commune","district","province","tel","mobile","note","is_cashoperation","cash_riel",
    				"cash_dollar","cash_bath","DATE","STATUS"
    			);
    		$link=array(
    				'module'=>'partner','controller'=>'index','action'=>'edited',
    		);
    		$this->view->list=$list->getCheckList(0, $collumns,$rs_rows,array(''=>$link,''=>$link));
         	}catch (Exception $e){
//     		Application_Form_FrmMessage::message("Application Error");
//     		echo $e->getMessage();
//     		Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
    	}
    	
    }

    public function addAction()
    {
       
		
    	if($this->getRequest()->isPost()){
			$data=$this->getRequest()->getPost();	
		    
			$db_partner = new Partner_Model_DbTable_DbPartner();				
 			try {
			$db = $db_partner->insertPartner($data);				
  				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
			$this->view->msgs = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
	}
    	$pructis=new Partner_Form_FrmPartner();
    	$frm = $pructis->addPartner();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    
    }
 

    public function viewAction()
    {
        // action body
        $ag_id = $this->getRequest()->getParam('ag_id');
		
		$db_agent = new Application_Model_DbTable_DbAgents();
		$this->view->agent_view = $db_agent->getAgentViewById($ag_id);
    }

    public function editeAction()
    {
    	if($this->getRequest()->isPost()){
    		$data=$this->getRequest()->getPost();
    	
    		$db_partner = new Partner_Model_DbTable_DbPartner();
    		try {
    			$db = $db_partner->insertPartner($data);
    			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
    			$this->view->msgs = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		} catch (Exception $e) {
    			$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    	}
    	$pructis=new Partner_Form_FrmPartner();
    	$frm = $pructis->addPartner();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    }
}







