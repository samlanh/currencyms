<?php

class Keeping_IndexController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/Keeping/index/add';
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	
    public function init()
    {
        /* Initialize action controller here */
//     	header('content-type: text/html; charset=utf8');
    	header('content-type: text/html; charset=utf8');
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
    	//clear all other sessions
    	Application_Form_FrmSessionManager::clearSessionSearch();
    }

    public function indexAction()
    {
    	$keeping=new Keeping_Model_DbTable_DbKeeping();
    	$db=$keeping->getAllKeeping();
    	
    }
    function addAction(){
    //insert table cms_keeping
    	if($this->getRequest()->isPost()){
    					$data=$this->getRequest()->getPost();
//     					print_r($data);exit();
    					$db_keeping = new Keeping_Model_DbTable_DbKeeping();
    					try {
    						$db = $db_keeping->insertKeeping($data);
    						Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
    					} catch (Exception $e) {
    						echo $e->getMessage();exit();
    						$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    					}
    					
    				}	
    				
   //form
    	$sendmoney=new Keeping_Form_FrmSendMoney();
    	$db= new Keeping_Model_DbTable_DbKeeping();
    	$frm = $sendmoney->addSendMoney();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    	$this->view->currency_type = $db->CurruncyTypeOption();
    }
    function addbAction(){
    	
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
    
    
    	//     	if($this->getRequest()->isPost()){
    	// 			$agentdata=$this->getRequest()->getPost();
    	// 			$db_agent = new Application_Model_DbTable_DbAgents();
    	// 			try {
    	// 				$db = $db_agent->insertAgent($agentdata);
    	// 				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
    	// 			} catch (Exception $e) {
    	// 				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    	// 			}
    	// 		}
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







