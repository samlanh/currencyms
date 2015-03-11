<?php

class Exchange_IndexController extends Zend_Controller_Action
{

	const REDIRECT_URL = '/exchange';
	
    public function init()
    {
        /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	
    	//clear all other sessions
    	Application_Form_FrmSessionManager::clearSessionSearch();
    	
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
    }

    public function indexAction()
    {
    try{
    		$db = new Application_Model_DbTable_DbExchange();
    		$rs_rows=$db->getAllExchangeList();
//     		$glClass = new Application_Model_GlobalClass();
//     		$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
    		$list = new Application_Form_Frmtable();
    		$collumns = array("លេខវិក្ក័យប័ត្រ","ថ្ងៃប្រតិបត្តិ","ការប្តូរប្រាក់","ចំនួនទឹកប្រាក់","អត្រាប្តូរប្រាក់ ","ចំនួនទឹកប្រាក់បានប្តូររួច","ប្រាក់ទទួលបាន","ប្រាក់អាប់","ប្រភេទលុយបានប្ថូរ","ប្រភេទលុយទទួលបាន","ឈ្មោះបុគ្គលឹក");
    		$link=array(
    				'module'=>'exchange','controller'=>'index','action'=>'edit',
    		);
    		$this->view->list=$list->getCheckList(0, $collumns,$rs_rows,array('from_to'=>$link,'statusDate'=>$link,'fromAmount'=>$link,''=>$link,'recieptNo'=>$link));
    	}catch (Exception $e){
    		Application_Form_FrmMessage::message("Application Error");
    		echo $e->getMessage();
    		Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
    	
    	}
    }

    public function editAction()
    {
        // action body    
        //Get value from url
        $ex_id = $this->getRequest()->getParam('id',0);
     	$session_user=new Zend_Session_Namespace('auth');
        $this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
        
        $db_keycode = new Application_Model_DbTable_DbKeycode();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
		
		$cur = new Application_Model_DbTable_DbCurrencies();
		$currency = $cur->getCurrencyList();
		
		$this->view->currency = $this->_helpfilteroption($currency);
		
		$db_exc=new Application_Model_DbTable_DbExchange();
		$this->view->dataedit = $db_exc->getDataById($ex_id);
		
		if($this->getRequest()->isPost()){
			$formdata=$this->getRequest()->getPost();
// 			print_r($formdata);exit();	
			try {
				$formdata['id']=$ex_id;
				$result = $db_exc->getDataById($formdata['id']);
				$to_type = $db_exc->getCurrencyById("`name`, `symbol`,`country_id`", $formdata["to_amount_type"]);
				$from_type = $db_exc->getCurrencyById("`name`, `symbol`,`country_id`", $formdata["from_amount_type"]);
				
				if($result['fromAmountType']==$from_type['country_id'] && $result['toAmountType']==$to_type['country_id']){//if the edit not change the currency
					$id = $db_exc->updateData($formdata);
				}else{//if edit change the currency we need to add new record
					$formdata['inv_no'] = Application_Model_GlobalClass::getInvoiceNo();
					$id = $db_exc->save($formdata);
				}
				
			 Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
						
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
				echo $e->getMessage();exit();
			}
		}       
    }

    public function addAction()
    {
        // action body       
        //user name for report
        $session_user=new Zend_Session_Namespace('auth');
        $this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
        
        $db_keycode = new Application_Model_DbTable_DbKeycode();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
		
		$cur = new Application_Model_DbTable_DbCurrencies();
		$currency = $cur->getCurrencyList();
		
		$this->view->currency = $this->_helpfilteroption($currency);
		
		
		$this->view->inv_no = Application_Model_GlobalClass::getInvoiceNo();
		
		
		if($this->getRequest()->isPost()){
			$formdata=$this->getRequest()->getPost();	
			$db_exc=new Application_Model_DbTable_DbExchange();	
			try {
				$id = $db_exc->save($formdata);
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL . '/index/add');
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
        
    }
    public function exchangeAction()
    {
    	// action body
    	//user name for report
    	$session_user=new Zend_Session_Namespace('auth');
    	$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
    
    	$db_keycode = new Application_Model_DbTable_DbKeycode();
    	$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
    
    	$cur = new Application_Model_DbTable_DbCurrencies();
    	$currency = $cur->getCurrencyList();
    
    	$this->view->currency = $this->_helpfilteroption($currency);
    
    
    	$this->view->inv_no = Application_Model_GlobalClass::getInvoiceNo();
    
    
    	if($this->getRequest()->isPost()){
    		$formdata=$this->getRequest()->getPost();
    		$db_exc=new Application_Model_DbTable_DbExchange();
    		try {
    			$id = $db_exc->save($formdata);
    			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL . '/index/add');
    		} catch (Exception $e) {
    			$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    	}
    
    }
    
    public function checkRateAction(){
    	$db_rate=new Application_Model_DbTable_DbRate();
    	echo $db_rate->getCurrentRateJson();
    	exit();
    }
    
    protected function _helpfilteroption($data){
    	$tmp = array();
    	foreach ($data as $i =>$d){
    		foreach ($d as $key => $val){
    			$tmp[$i][$key] = $val;
    		}
    		$bath=0; $rail=0; $dollar=0;
    		if($d['symbol'] === "$"){
    			$bath=1; $rail=1;
    		}
    		elseif($d['symbol'] === "B"){
    			$dollar=1; $rail=1;
    		}
    		elseif($d['symbol'] === "R"){
    			$bath=1; $dollar=1;
    		}
    		$tmp[$i]["dollar"] = $dollar;
    		$tmp[$i]["bath"] = $bath;
    		$tmp[$i]["rail"] = $rail;
    	}
    	return $tmp;
    }
    
    public function rateAction(){
    	$db_rate=new Application_Model_DbTable_DbRate();
    	
    	if($this->getRequest()->isPost()){
    		$formdata=$this->getRequest()->getPost();
    		$db_rate->setNewRate($formdata);
    	}
    	
    	$this->view->ratelist = $db_rate->getCurrentRate();
    	$db_keycode = new Application_Model_DbTable_DbKeycode();
    	$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
    	$session_user=new Zend_Session_Namespace('auth');
    	$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
    }

    
}











