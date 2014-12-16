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
        // action body	
        try {
	        $db_tran=new Application_Model_DbTable_DbGlobal();
    		 
    		//create sesesion
    		$session_transfer=new Zend_Session_Namespace('search_exhcange');
    		$session_user=new Zend_Session_Namespace('auth');
    		$user_id = $session_user->user_id;
    		if(empty($session_transfer->limit)){
    			$session_transfer->unlock();
    			$session_transfer->limit =  Application_Form_FrmNavigation::getLimit();
    			$session_transfer->from_date =  date('Y-m-d');
    			$session_transfer->to_date =  date('Y-m-d');
    			$session_transfer->lock();
    		}

    		if($this->getRequest()->isPost()){
    			$formdata=$this->getRequest()->getPost();
    			$session_transfer->unlock();
    			$session_transfer->limit =  $formdata['rows_per_page'];
    			$session_transfer->from_date =  $formdata['from_date'];
    			$session_transfer->to_date = $formdata['to_date'];
    			$session_transfer->lock();
    			$user_id = $formdata['user_id'];
    		}
    		$user_query = $user_id==-1?"":"e.userid = '".$user_id."' AND ";
    		$where = "WHERE ".$user_query."(e.statusdate BETWEEN '".$session_transfer->from_date." 00:00:00' AND '".$session_transfer->to_date." 23:59:59') ";
    		
    		$sql = "SELECT
    				  e.`id`, 
					  DATE_FORMAT(e.`statusDate`,'%d/%m/%Y') as `statusDate`,
					  e.`from_to`,
					  e.`fromAmount`,
					  e.`rate`,    				  
    				  e.`toAmount`,
    				  e.`recievedAmount`,
    				  e.`changedAmount`,
    				  e.`toAmountType`,
    				  e.`fromAmountType`
					FROM
					  `cs_exchange` AS e 
    				". $where ."
    				ORDER BY e.`statusDate` DESC";

    		//start page nevigation
    		$limit = $session_transfer->limit;
    		$start = $this->getRequest()->getParam('limit_satrt',0);
    		$result = $db_tran->getGlobalDbListBy($sql, $start, $limit);
    		$record_count = $db_tran->getGlobalDbListTotal($sql);
    		    		
    		$row_num = $start;
    		 
    		if (empty($result)){
    			$result = array('err'=>1, 'msg'=>'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!');
    		}		

    		$usr_mod = new Application_Model_DbTable_DbUsers();
    		$this->view->users = $usr_mod->getUserListSelect();
    		$this->view->user_id = $user_id;
    		$this->view->from_date=$session_transfer->from_date;
    		$this->view->to_date=$session_transfer->to_date;
    		
    		$this->view->tranlist = Zend_Json::encode($result);
    		$page = new Application_Form_FrmNavigation(self::REDIRECT_URL, $start, $limit, $record_count);
    		$page->init(self::REDIRECT_URL, $start, $limit, $record_count);
    		$this->view->nevigation = $page->navigationPage();
    		$this->view->rows_per_page = $page->getRowsPerPage($limit, 'frmlist');
    		$this->view->result_row = $page->getResultRows();
        } catch (Exception $e) {
        }	
    }

    public function editedAction()
    {
        // action body    
        //Get value from url
        $ex_id = $this->getRequest()->getParam('ex_id',0);
        
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
			try {
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











