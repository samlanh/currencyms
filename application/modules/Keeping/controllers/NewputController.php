<?php

class Keeping_NewputController extends Zend_Controller_Action
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
       
    }

    public function addAction()
    {
       
    	$pructis=new Money_Form_FrmMoney();
    	$frm = $pructis->addMoney();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    }
    public function putAction()
    {
    	 
    	$pructis=new Money_Form_FrmMoney();
    	$frm = $pructis->addMoney();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    }
    public function newmAction()
    {
    	$pructis=new Money_Form_FrmMoney();
    	$frm = $pructis->addMoney();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    }
    public function dakAction()
    {
    	$pructis=new Money_Form_OutMoney();
    	$frm = $pructis->dakMoney();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    }
    
    public function putmoneyAction()
    {
    
    	$pructis=new Money_Form_PutMoney();
    	$frm = $pructis->dakMoney();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    }
    
    public function put1Action()
    {
    
    	$pructis=new Money_Form_NewPut();
    	$frm = $pructis->dakMoney();
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

    public function editedAction()
    {
        // action body
        $ag_id = $this->getRequest()->getParam('ag_id');
    	$ag_id = (empty($ag_id))? 0 : $ag_id; 
    	
    	$pro = new Application_Model_DbTable_DbProvinces();
		$this->view->provinces = $pro->getProvinceListAll();
		
		$db_agent = new Application_Model_DbTable_DbAgents();
		$this->view->agent_edit = $db_agent->getAgentEditedById($ag_id);
		
    	if($this->getRequest()->isPost()){
			$agentdata=$this->getRequest()->getPost();	
							
			try {
				$db = $db_agent->updateAgent($agentdata);				
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);		
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
    }


}







