<?php

class Payment_IndexController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/payment';
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	private $user_typelist = array();
	
// 	private $statuslist = array(
// 			'ផ្ញើរ',
// 			'ផ្ញើររួច',
// 			'ទទួល',
// 			'បើក​រួច',
// 			'មោឃៈ',
// 			'ផុត​កំណត់'
// 	);
	
	private $loanlist = array(
			'មិនជំពាក់',
			'ជំពាក់'
	);
	
	private $tran_typelist = array(
			'ផ្ញើរ',
			'ទទួល'
	);
    
     

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
    	//Get Session User
    
    	try {
    		$db_owe=new Application_Model_DbTable_DbPayment();
    		 
    		//create sesesion
    		$session_transfer=new Zend_Session_Namespace('search_transfer');
    		if(empty($session_transfer->limit)){
    			$session_transfer->limit =  Application_Form_FrmNavigation::getLimit();
    			$session_transfer->status =  -1;
    			$session_transfer->type_money = -1;
    			$session_transfer->sender_name="";
    			$session_transfer->loan =  -1;
    			$session_transfer->province =  -1;
    			$session_transfer->agent =  -1;
    			$session_transfer->from_date =  date('Y-m-d');
    			$session_transfer->to_date =  date('Y-m-d');
    			$session_transfer->lock();
    		}
    		//start page nevigation
    		 
    		$limit = $session_transfer->limit;
    		$start = $this->getRequest()->getParam('limit_satrt',0);
    
    		$this->view->from_date=$session_transfer->from_date;
    		$this->view->to_date=$session_transfer->to_date;
    		 
    		$this->view->status = $session_transfer->status;
    
    		 
    		$cur = new Application_Model_DbTable_DbCurrencies();
    		$this->view->currencylist = $cur->getCurrencyList();
    		$this->view->type_money = $session_transfer->type_money;
    		 
    		$this->view->sender_name  = $session_transfer->sender_name;
    		 
    		$pro = new Application_Model_DbTable_DbProvinces();
    		$this->view->provincelist = $pro->getProvinceList();
    		//$this->view->province = $session_transfer->province;
    			
    		$agent = new Application_Model_DbTable_DbAgents();
    		//$this->view->agentlist = $agent->getAgentListSelect();
    		//$this->view->agent = $session_transfer->agent;
    		 
    		if($this->getRequest()->isPost()){
    			$formdata=$this->getRequest()->getPost();
    			$session_transfer->unlock();
    			
    			$session_transfer->sender_name  = $formdata['sender_name'];
    			$session_transfer->limit =  $formdata['rows_per_page'];
    			$session_transfer->from_date =  $formdata['from_date'];
    			$session_transfer->to_date = $formdata['to_date'];
    			$session_transfer->lock();
    
    			$this->view->sender_name  = $formdata['sender_name'];
    			$this->view->from_date=$session_transfer->from_date;
    			$this->view->to_date=$session_transfer->to_date;
    
    			$limit = $session_transfer->limit;
    			$result= $db_owe->getTransactionOweList($formdata, $start, $limit);
    			$record_count = $db_owe->getTransactionOweListTotal($formdata);
    		}
    		else{
    			$formdata = array(
    					'sender_name'=>$session_transfer->sender_name,
    					'status'=>$session_transfer->status,
    					'status_loan'=>$session_transfer->loan,
    					'from_date'=>$session_transfer->from_date,
    					'to_date'=>$session_transfer->to_date,
    					'type_money'=>$session_transfer->type_money
    			);
    			//print_r($formdata); exit();
    			$result= $db_owe->getTransactionOweList($formdata, $start, $limit);
    			$record_count = $db_owe->getTransactionOweListTotal($formdata);
    		}
    		$row_num = $start;
    		 
    		//print_r($result);exit;
    		if (!empty($result)){
    			$tra_id = '';
    			foreach ($result as $i =>$rs) {
    				$refund_dollar = 0;
    				$refund_bath = 0;
    				$refund_riel = 0;
    				
    				$refund_txt = 'refund_dollar';
    				if($rs["curency_type"]==1){
    					$refund_dollar = $rs["refund"];
    				}
    				else if($rs["curency_type"]==2){
    					$refund_bath = $rs["refund"];
    					$refund_txt = 'refund_bath';
    				}
    				else {
    					$refund_riel = $rs["refund"];
    					$refund_txt = 'refund_riel';
    				}
    				//echo $tra_id."=".$rs["invoice_found"]."<br/><br/>";
    				if($tra_id != $rs["invoice_found"]){
    					$tra_id = $rs["invoice_found"];
    					$result_row[$tra_id] = array(
    							'num' => (++$row_num),
    							"found_id" 	  	=> $rs["invoice_found"],
    							"invoice_found"	=> $rs["invoice_found"],
    							"sender_name" 	=> $rs["sender_name"],
    							"refund_dollar"		=> $refund_dollar,
    							"refund_bath"		=> $refund_bath,
    							"refund_riel"		=> $refund_riel,
    							"date_refund" =>$rs["date_refund"],
    					);
    					//print_r($result_row);echo "<br/> ***New <br/>";
    				}else{
    					$result_row[$tra_id][$refund_txt] = $rs["refund"];
    					//print_r($result_row);echo "<br/>***old<br/>";
    				}
    				
    			}
    			$i = 0;
    			foreach($result_row as $val){
    				$result_rows[$i]=$val;
    				$i++;
    			}
     			//print_r($result_rows);
//     			exit;
//     				//format amount
//     				$amount = $tran['symbol'].' '.number_format($tran['amount']);
    					
//     				$sub_agent = (empty($tran['subname']))? "":"(".$tran['subname'].")";
//     				$inc_no = sprintf("%'010s",  $tran['invoice_no']);
    					
    					
//     				$result[$i] = array(
//     						'num' => (++$row_num),
//     						'id' => $tran['id'],
//     						'amount' => $amount,
//     						'agentname' => $tran['agentname'].$sub_agent,
//     						'reciever_tel' => $tran['reciever_tel'],
//     						'invoice_no'=> $inc_no,
//     						'send_date'=> date_format(date_create($tran['send_date']), "d/m/Y"),
//     						//'status'=> $this->statuslist[$tran['status']],
//     						//'status_loan'=> $this->loanlist[$tran['status_loan']],
//     						'sender_name'=>$tran['sender_name'],
//     						'reciever_name'=>$tran['reciever_name']
//     				);
//     			}
    		}
    		else{
    			$result_rows = array('err'=>1, 'msg'=>'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!');
    		}
    		
    		$this->view->tranlist = Zend_Json::encode($result_rows);
    		$sender = new Application_Model_DbTable_DbSender();
    		//$this->view->loanlist =($this->loanlist);
//     		$this->view->senderlist = $sender->getAllSenderNameOwe();
//     		print_r($sender->getAllSenderNameOwe());
    		$page = new Application_Form_FrmNavigation(self::REDIRECT_URL, $start, $limit, $record_count);
    		$page->init(self::REDIRECT_URL, $start, $limit, $record_count);
    		$this->view->nevigation = $page->navigationPage();
    		//print_r($limit);exit;
    		$this->view->rows_per_page = $page->getRowsPerPage($limit, 'frmlist_mt');
    		$this->view->result_row = $page->getResultRows();

    		$sender = new Application_Model_DbTable_DbSender();
    		$this->view->senderlist = $sender->getAllSenderNameFound();
    	} catch (Exception $e) {
    	}
    }
	
    public function addAction()
    {    	
 		
		if($this->getRequest()->isPost()){			
			$_data=$this->getRequest()->getPost();	
			//print_r($_data);exit();
			try {	
				$_dbmodel = new Application_Model_DbTable_DbPayment();
				$_dbmodel->addTransFound($_data);				
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', "/payment/index/index");
			} catch (Exception $e) {
				echo $e->getMessage();exit();
				$this->view->msg='ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';				
			}			
		}
		$this->view->invoice_no = Application_Model_GlobalClass::getInvoiceWithdraw(4);
		$sender = new Application_Model_DbTable_DbSender();
		$this->view->senderlist = $sender->getAllSenderNameOwe();
		$db_keycode = new Application_Model_DbTable_DbKeycode();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
		$session_user=new Zend_Session_Namespace('auth');
		$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
		$cur = new Application_Model_DbTable_DbCurrencies();
		$currency = $cur->getCurrencyList();
		$this->view->currency = $this->_helpfilteroption($currency);
		$curr = $this->_helpfilteroption($currency);
		array_unshift($curr, array ('id' => '-1',"name"=>"សងប្រភេទប្រាក់ផ្សេង",'symbol'=>'other') );
		$this->view->pay_currencytype = $curr;
	
		$db_rate=new Application_Model_DbTable_DbPayment();
		$this->view->rate = $db_rate->getRateAll();
    	
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
    		elseif($d['symbol'] === "฿"){
    			$dollar=1; $rail=1;
    		}
    		elseif($d['symbol'] === "៛"){
    			$bath=1; $dollar=1;
    		}
    		$tmp[$i]["dollar"] = $dollar;
    		$tmp[$i]["bath"] = $bath;
    		$tmp[$i]["rail"] = $rail;
    	}
    	return $tmp;
    }
    public function checkRateAction(){
    	//if($this->getRequest()->isPost()){
    		$_data = $this->getRequest()->getPost();
    		$from=$_data["from"];
    		$to=$_data["to"];
    		$db_rate=new Application_Model_DbTable_DbPayment();
    		echo $db_rate->getCurrentRateJson($from,$to);
    		exit();
    	//}
    	
    }
    public function updatePaymentAction()
    {
    	$id = $this->getRequest()->getParam("id");
    	if($this->getRequest()->isPost()){
    		$_data=$this->getRequest()->getPost();
    		try {
    			$_dbmodel = new Application_Model_DbTable_DbPayment();
//     			echo $id;
//     			print_r($_data);exit();
    			$_dbmodel->updateFundbyParams($_data);
    			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', "/payment/index/index");
    		} catch (Exception $e) {
    			echo $e->getMessage();
    			exit();
    			$this->view->msg='ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    	}
    	$sender = new Application_Model_DbTable_DbSender();
    	$this->view->senderlist = $sender->getAllSenderNameOweAll();
    	$_dbmodel = new Application_Model_DbTable_DbPayment();
    	$sender_id = $sender->getSenderIdbyInvoiceInFund($id);
    	//$row = $_dbmodel->getFoundbyId($id);
    	
    	$tran_row = $_dbmodel->getTransactionOweByInvoice($id,$sender_id);
    	$rat_perday = 0;
    	if($tran_row){
    		$rat_perday = $tran_row[0]['rate_perday'];
    	}
    	
    	$row = $_dbmodel->getFoundbyInvoice($id,$rat_perday);
    	//print_r($row);exit;
    	$this->view->old_sender = $row["sender_name"];
    	$this->view->edite_found=$row;
    	
    	$this->view->invoice_no = $row['invoice_found'];
    	
    	$db_keycode = new Application_Model_DbTable_DbKeycode();
    	$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
    	$session_user=new Zend_Session_Namespace('auth');
    	$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
    	
		$cur = new Application_Model_DbTable_DbCurrencies();
		$currency = $cur->getCurrencyList();
		$this->view->currency = $this->_helpfilteroption($currency);
    	//$this->view->id=$id;
    	 
    }
    public function viewAction()
    {
    	$id = $this->getRequest()->getParam("id");
    	if($this->getRequest()->isPost()){//if have post = delete
    		$_data=$this->getRequest()->getPost();
    		try {
    			//print_r($_data);	exit();
    			$_dbmodel = new Application_Model_DbTable_DbPayment();
    			$_data["id"]=$id;
//     			echo $id;
//     			print_r($_data);exit();
    			$_dbmodel->deleteFundbyParams($_data);
    			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', "/payment/index/index");
    		} catch (Exception $e) {
    			echo $e->getMessage();
    			exit();
    			$this->view->msg='ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    	}
    	$sender = new Application_Model_DbTable_DbSender();
    	$this->view->senderlist = $sender->getAllSenderNameOweAll();
    	$_dbmodel = new Application_Model_DbTable_DbPayment();
    	$tran_id = $sender->getTranIdbyInvoiceInFund($id);
    	$tran_row = $_dbmodel->getTransactionOweById($tran_id);
    	$rat_perday = 0;
    	if($tran_row){
    		$rat_perday = $tran_row[0]['rate_perday'];
    	}
    	$row = $_dbmodel->getFoundbyInvoice($id,$rat_perday);
    	$this->view->edite_found=$row;
    	
    	$this->view->invoice_no = $row['invoice_found'];
    	$db_keycode = new Application_Model_DbTable_DbKeycode();
    	$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
    	
    }
    public function getmoneybynameAction(){
    	if($this->getRequest()->isPost()){
    		$_data = $this->getRequest()->getPost();
    		$_db = new Application_Model_DbTable_DbPayment();
    		$moneys = $_db->getAmountBySenderName($_data);
    		print_r(Zend_Json::encode($moneys));
    		exit();
    	}
    }
    public function getDebtBysenderAction(){
    	if($this->getRequest()->isPost()){
    		$_data = $this->getRequest()->getPost();
    		$_db = new Application_Model_DbTable_DbPayment();
    		$db_sender = new Application_Model_DbTable_DbKbank();
    		$sender_id = $db_sender->getSenderIdbyName($_data['sender_name']);
    		$moneys = $_db->getAddDebtSenderNameById($sender_id);
    		print_r(Zend_Json::encode($moneys));
    		exit();
    	}
    }
    public function selectAction()
    {
    		
    	if($this->getRequest()->isPost()){
    		$_data=$this->getRequest()->getPost();
    		//print_r($_data);exit();
    		try {
    			$_dbmodel = new Application_Model_DbTable_DbPayment();
    			$_dbmodel->addTransFound($_data);
    			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', "/payment/index/index");
    		} catch (Exception $e) {
    			echo $e->getMessage();exit();
    			$this->view->msg='ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    	}
    	$this->view->invoice_no = Application_Model_GlobalClass::getInvoiceWithdraw(4);
    	$sender = new Application_Model_DbTable_DbSender();
    	$this->view->senderlist = $sender->getAllSenderNameOwe();
    	$db_keycode = new Application_Model_DbTable_DbKeycode();
    	$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
    	$session_user=new Zend_Session_Namespace('auth');
    	$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
    	$cur = new Application_Model_DbTable_DbCurrencies();
    	$currency = $cur->getCurrencyList();
    	$this->view->currency = $this->_helpfilteroption($currency);
    	$curr = $this->_helpfilteroption($currency);
    	array_unshift($curr, array ('id' => '-1',"name"=>"សងប្រភេទប្រាក់ផ្សេង",'symbol'=>'other') );
    	$this->view->pay_currencytype = $curr;
    
    	$db_rate=new Application_Model_DbTable_DbPayment();
    	$this->view->rate = $db_rate->getRateAll();
    	 
    }
}











