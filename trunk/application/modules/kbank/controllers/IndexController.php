<?php
class Kbank_IndexController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/kbank';
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	private $user_typelist = array();
	
	private $statuslist = array(
			'បានផុតកំណត់',
			'បានពន្យាពេល',
			'ថ្មី'
	);
	private $pay_term = array(
			'សប្តាហ៏',
			'ខែ');
	
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
	    Application_Form_FrmSessionManager::clearSessionSearch();
	}
	public function indexAction()
	{
		try {
			$db_tran=new Application_Model_DbTable_DbKbank();
			 
			//create sesesion
			$search_kbank=new Zend_Session_Namespace('search_kbank');
			if(empty($search_kbank->limit)){
				$search_kbank->limit =  Application_Form_FrmNavigation::getLimit();
				$search_kbank->type_money = -1;
				$search_kbank->txtsearch="";
				$search_kbank->from_date = date('Y-m-d');
				$search_kbank->to_date = date('Y-m-d');
				$search_kbank->sender = -1;
				$search_kbank->lock();
			}
			//start page nevigation
			 
			$limit = $search_kbank->limit;
			$start = $this->getRequest()->getParam('limit_satrt',0);
		
			$this->view->from_date=$search_kbank->from_date;
			$this->view->to_date=$search_kbank->to_date;
			$this->view->sender_id=$search_kbank->sender;
			 
			$cur = new Application_Model_DbTable_DbCurrencies();
			$this->view->currencylist = $cur->getCurrencyList();
			$this->view->type_money = $search_kbank->type_money;
			$this->view->statuslist = $this->statuslist;
			 
			$this->view->txtsearch  = $search_kbank->txtsearch;
			if($this->getRequest()->isPost()){
				$formdata=$this->getRequest()->getPost();
// 				print_r($formdata);
				$search_kbank->unlock();
				$search_kbank->txtsearch  = $formdata['txt_search'];
				$search_kbank->limit =  $formdata['rows_per_page'];
				$search_kbank->type_money = $formdata['type_money'];
				$search_kbank->from_date =  $formdata['from_date'];
				$search_kbank->to_date = $formdata['to_date'];
				$search_kbank->sender = $formdata['sender'];
				$search_kbank->lock();
				
		
				$this->view->txtsearch  = $formdata['txt_search'];
				$this->view->type_money = $formdata['type_money'];
				$this->view->sender_id = $formdata['sender'];
				$this->view->from_date=$search_kbank->from_date;
				$this->view->to_date=$search_kbank->to_date;
		
				$limit = $search_kbank->limit;
		
				$trans= $db_tran->getTransactionListBy($formdata, $start, $limit);
				$record_count = $db_tran->getTransactionListTotal($formdata);
			}
			else{
				$formdata = array(
						'txt_search'=>$search_kbank->txtsearch,
						'tran_type'=>$search_kbank->tran_type,
						'from_date'=>$search_kbank->from_date,
						'to_date'=>$search_kbank->to_date,
						'type_money'=>$search_kbank->type_money,
						'sender'=>$search_kbank->sender
				);
				$trans= $db_tran->getTransactionListBy($formdata, $start, $limit);
				$record_count = $db_tran->getTransactionListTotal($formdata);
			}
			$result = array();
			$row_num = $start;
			 
			if (!empty($trans)){
		
				foreach ($trans as $i => $tran) {
					$expired = '';$is_expired = 0;
					$amount = $tran['symbol'].' '.number_format($tran['money_inaccount']);
					$sub_agent = (empty($tran['subname']))? "":"(".$tran['subname'].")";
					$inc_no = sprintf("%'010s",  $tran['invoice']);
					$current_date = $search_kbank->to_date;
					$current_date = date_format(date_create($current_date),"d/m/Y");
					if($current_date>=date_format(date_create($tran['end_date']), "d/m/Y")){
						$expired = $current_date-date_format(date_create($tran['end_date']), "d/m/Y");
						if($expired==0){
							$expired='ថ្ងៃនេះ';
						}else{
							$expired.=' ថ្ងៃ';
						}
						$is_expired = 1;
						
						
					}
					$result[$i] = array(
							'num' => (++$row_num),
							'id' => $tran['id'],
							'sender_name' => $tran['sender_name'],
							'tel' => $tran['tel'],
							'account_no' => $tran['acc_no'],
							'invoice'=> $tran['invoice'],
							'amount' => $amount,
							'start_date'=> date_format(date_create($tran['start_date']), "d/m/Y"),
							'expired_date'=> date_format(date_create($tran['end_date']), "d/m/Y"),
							'amount_month'=>$tran['amount_month'].' '.$this->pay_term[$tran['pay_term']],
							'amount_expired'=> $expired,
							'is_expired' =>$is_expired,
							'is_extend'=>($tran["is_extend"])==1?"ពន្យា":"ផ្ញើរ"
					);
				}
			}
			else{
				$result = array('err'=>1, 'msg'=>'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!');
			}
			$this->view->tranlist = Zend_Json::encode($result);
			$page = new Application_Form_FrmNavigation(self::REDIRECT_URL, $start, $limit, $record_count);
			$page->init(self::REDIRECT_URL, $start, $limit, $record_count);
			$this->view->nevigation = $page->navigationPage();
			$this->view->rows_per_page = $page->getRowsPerPage($limit, 'frmlist_mt');
			$this->view->result_row = $page->getResultRows();
			
			$sender = new Application_Model_DbTable_DbSender();
			$_sender = $sender->getAllSenderKbank();
			array_unshift($_sender, array ('id' => '-1',"name"=>"ជ្រើសរើសឈ្មោះអ្នកផ្ញើរ") );
			$this->view->sender = $_sender;
		} catch (Exception $e) {
		}
		
	}
	public function addAction()
	{
		if($this->getRequest()->isPost()){
			try {
			$data = $this->getRequest()->getPost();
			$db = new Application_Model_DbTable_DbKbank();
			$db->AddDepositBySender($data);
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL . '/index/add');
			}catch (Exception $e){
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​មិន​ជោគ​ជ័យ', self::REDIRECT_URL . '/index/add');
			}
			
		}
		$session_user=new Zend_Session_Namespace('auth');
		$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
	
		$db_keycode = new Application_Model_DbTable_DbKeycode();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
	
		$pro = new Application_Model_DbTable_DbProvinces();
		$provinces = $pro->getProvinceList();
		array_unshift($provinces, array ('id' => '0',"name"=>"ជ្រើសរើសខេត្តដកប្រាក់",'num'=>0) );
		$this->view->provinces = $provinces;
	
		$subagent = new Application_Model_DbTable_DbSubAgent();
		$this->view->subagent = $subagent->getSubAgentListSelectTrns();
	
		$agent = new Application_Model_DbTable_DbAgents();
		$this->view->agent = $agent->getAgentListSelectTrns();
	
		$sender = new Application_Model_DbTable_DbSender();
		$_sender = $sender->getAllSenderKbank(1);
		array_unshift($_sender, array ('id' => '-1',"name"=>"បន្ថែមឈ្មោះអ្នកផ្ញើរ",'tel'=>'') );
		$this->view->sender = $_sender;
		$cur = new Application_Model_DbTable_DbCurrencies();
		$this->view->currency = $cur->getCurrencyList();
		$this->view->pay_term = $this->pay_term;
		
		$this->view->invoice_no = Application_Model_GlobalClass::getInvoiceWithdraw(1);
		
		$db = new Application_Model_DbTable_DbKbank();
		$this->view->new_acc  = $acc_no = $db->getAccountNumberForKBank();
		
	}
	public function editedAction()
	{
		$tr_id = $this->getRequest()->getParam('tr_id');
		$tr_id = (empty($tr_id))? 0 : $tr_id;
		
		if($this->getRequest()->isPost()){
			try {
				$data = $this->getRequest()->getPost();
				$db = new Application_Model_DbTable_DbKbank();
				$db->editDepositBySender($data);
				Application_Form_FrmMessage::Sucessfull('ការកែប្រែប្រតិបត្តិការនេះ​​ជោគ​ជ័យ', self::REDIRECT_URL .'/index/index');
			}catch (Exception $e){
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូលកែប្រែជោគ​ជ័យ', self::REDIRECT_URL .'/index/index');
			}
		}
		
		if(empty($tr_id)){
			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL . '/index/index');
		}
		$db = new Application_Model_DbTable_DbKbank();
		$rs = $db->getTranKbankById($tr_id);
		if(empty($rs)){
			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL . '/index/index');
		}
		$this->view->rs = $rs;
		
		$session_user=new Zend_Session_Namespace('auth');
		$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
	
		$db_keycode = new Application_Model_DbTable_DbKeycode();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
	
		$pro = new Application_Model_DbTable_DbProvinces();
		$provinces = $pro->getProvinceList();
		array_unshift($provinces, array ('id' => '0',"name"=>"ជ្រើសរើសខេត្តដកប្រាក់",'num'=>0) );
		$this->view->provinces = $provinces;
	
		$subagent = new Application_Model_DbTable_DbSubAgent();
		$this->view->subagent = $subagent->getSubAgentListSelectTrns();
	
		$agent = new Application_Model_DbTable_DbAgents();
		$this->view->agent = $agent->getAgentListSelectTrns();
	
		$sender = new Application_Model_DbTable_DbSender();
		$_sender = $sender->getAllSenderKbank();
		array_unshift($_sender, array ('id' => '-1',"name"=>"បន្ថែមឈ្មោះអ្នកផ្ញើរ") );
		$this->view->sender = $_sender;
		$cur = new Application_Model_DbTable_DbCurrencies();
		$this->view->currency = $cur->getCurrencyList();
		$this->view->pay_term = $this->pay_term;
	
// 		$this->view->invoice_no = Application_Model_GlobalClass::getInvoiceNo();
	
		$db = new Application_Model_DbTable_DbKbank();
		$this->view->new_acc  = $acc_no = $db->getAccountNumberForKBank();
	
	}
	public function extendDateAction()
	{
		$tr_id = $this->getRequest()->getParam('tr_id');
		$tr_id = (empty($tr_id))? 0 : $tr_id;
		
		if($this->getRequest()->isPost()){
			try {
				$data = $this->getRequest()->getPost();
				$db = new Application_Model_DbTable_DbKbank();
				$db->extendDateByTran($data);
				Application_Form_FrmMessage::Sucessfull('ការពន្យាពេលប្រតិបត្តិការនេះ​​ជោគ​ជ័យ', self::REDIRECT_URL .'/index/index');
			}catch (Exception $e){
				Application_Form_FrmMessage::Sucessfull('ការពន្យាពេលប្រតិបត្តិការនេះ​​បរាជ័យ', self::REDIRECT_URL .'/index/index');
			}
		}
		
		if(empty($tr_id)){
			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL . '/index/index');
		}
		$db = new Application_Model_DbTable_DbKbank();
		$rs = $db->getTranKbankById($tr_id);
		if(empty($rs)){
			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL . '/index/index');
		}
		$this->view->rs = $rs;
	
		$session_user=new Zend_Session_Namespace('auth');
		$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
	
		$db_keycode = new Application_Model_DbTable_DbKeycode();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
	
		$pro = new Application_Model_DbTable_DbProvinces();
		$provinces = $pro->getProvinceList();
		array_unshift($provinces, array ('id' => '0',"name"=>"ជ្រើសរើសខេត្តដកប្រាក់",'num'=>0) );
		$this->view->provinces = $provinces;
	
		$subagent = new Application_Model_DbTable_DbSubAgent();
		$this->view->subagent = $subagent->getSubAgentListSelectTrns();
	
		$agent = new Application_Model_DbTable_DbAgents();
		$this->view->agent = $agent->getAgentListSelectTrns();
	
		$sender = new Application_Model_DbTable_DbSender();
		$_sender = $sender->getAllSenderKbank();
		array_unshift($_sender, array ('id' => '-1',"name"=>"បន្ថែមឈ្មោះអ្នកផ្ញើរ") );
		$this->view->sender = $_sender;
		$cur = new Application_Model_DbTable_DbCurrencies();
		$this->view->currency = $cur->getCurrencyList();
		$this->view->pay_term = $this->pay_term;
	
		$this->view->invoice_no = Application_Model_GlobalClass::getInvoiceWithdraw(2);
	
		$db = new Application_Model_DbTable_DbKbank();
		$this->view->new_acc  = $acc_no = $db->getAccountNumberForKBank();
	
	}
	public function getaccountcodeAction(){
			if($this->getRequest()->isPost()){
				$data=$this->getRequest()->getPost();
				$sender_id = $data['sender_id'];
		
				$db = new Application_Model_DbTable_DbGlobal();
				$sql = "SELECT acc_no FROM `cs_sender` WHERE sender_id = $sender_id LIMIT 1";
				$value = $db->getGlobalDbOne($sql);
				if(empty($value)){
					$value = '';
				}
				print_r(Zend_Json::encode($value));
				exit();
			}
	}

}
