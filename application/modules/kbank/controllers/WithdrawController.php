<?php
class Kbank_WithdrawController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/kbank';
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	private $user_typelist = array();
	
	private $statuslist = array(
			'ផ្ញើរ',
			'ផ្ញើររួច',
			'ទទួល',
			'បើក​រួច',
			'មោឃៈ',
			'ផុត​កំណត់'
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
		 
		//clear all other sessions
		Application_Form_FrmSessionManager::clearSessionSearch();
	}
	public function indexAction()
	{
		try {
			$db_tran=new Application_Model_DbTable_DbKbank();
			 
			//create sesesion
			$session_withdraw=new Zend_Session_Namespace('search_withdraw');
			if(empty($session_withdraw->limit)){
				$session_withdraw->limit =  Application_Form_FrmNavigation::getLimit();
				$session_withdraw->type_money = -1;
				$session_withdraw->sender= -1;
				$session_withdraw->txtsearch="";
				$session_withdraw->from_date =  date('Y-m-d');
				$session_withdraw->to_date =  date('Y-m-d');
				$session_withdraw->lock();
			}
			//start page nevigation
			 
			$limit = $session_withdraw->limit;
			$start = $this->getRequest()->getParam('limit_satrt',0);
		
			$this->view->from_date=$session_withdraw->from_date;
			$this->view->to_date=$session_withdraw->to_date;
			$this->view->sender_id=$session_withdraw->sender;
			$cur = new Application_Model_DbTable_DbCurrencies();
			$this->view->currencylist = $cur->getCurrencyList();
			$this->view->type_money = $session_withdraw->type_money;
			 
			$this->view->txtsearch  = $session_withdraw->txtsearch;
			if($this->getRequest()->isPost()){
				$formdata=$this->getRequest()->getPost();
// 				print_r($formdata);
				$session_withdraw->unlock();
				$session_withdraw->txtsearch  = $formdata['txt_search'];
				$session_withdraw->limit =  $formdata['rows_per_page'];
				$session_withdraw->type_money = $formdata['type_money'];
				$session_withdraw->sender = $formdata['sender'];
				$session_withdraw->from_date =  $formdata['from_date'];
				$session_withdraw->to_date = $formdata['to_date'];
				$session_withdraw->lock();
		
				$this->view->txtsearch  = $formdata['txt_search'];
				$this->view->type_money = $formdata['type_money'];
				$this->view->sender_id=$formdata['sender'];
				
				$this->view->from_date=$session_withdraw->from_date;
				$this->view->to_date=$session_withdraw->to_date;
		
				$limit = $session_withdraw->limit;
		
				$trans= $db_tran->getTranWithDrawListBy($formdata, $start, $limit);
				$record_count = $db_tran->getTranWithDrawListTotal($formdata);
			}
			else{
				$formdata = array(
						'txt_search'=>$session_withdraw->txtsearch,
						'tran_type'=>$session_withdraw->tran_type,
						'from_date'=>$session_withdraw->from_date,
						'to_date'=>$session_withdraw->to_date,
						'type_money'=>$session_withdraw->type_money,
						'sender'=>$session_withdraw->sender
				);
				$trans= $db_tran->getTranWithDrawListBy($formdata, $start, $limit);
				$record_count = $db_tran->getTranWithDrawListTotal($formdata);
			}
			$result = array();
			$row_num = $start;
			 
			if (!empty($trans)){
				foreach ($trans as $i => $tran) {
					$expired = '';$is_expired = 0;
					$result[$i] = array(
							'num' => (++$row_num),
							'id' => $tran['id'],
							'sender_name' => $tran['sender_name'],
							'tel' => $tran['tel'],
							'account_no' => $tran['acc_no'],
							'invoice'=> $tran['invoice'],
							'amount_dollar' => $tran['wd_amountdollar']." $",
							'amount_bath' => $tran['wd_amountbath']." B",
							'amount_riel' => $tran['wd_amountriel']." R",
							'create_date'=> date_format(date_create($tran['create_date']), "d/m/Y"),
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
			array_unshift($_sender, array ('id' => '-1',"name"=>"បន្ថែមឈ្មោះអ្នកផ្ញើរ") );
			$this->view->sender = $_sender;
			
			$cur = new Application_Model_DbTable_DbCurrencies();
		} catch (Exception $e) {
		}
		
	}
	public function addAction()
	{
		if($this->getRequest()->isPost()){
			try {
			$data = $this->getRequest()->getPost();
			
			$db = new Application_Model_DbTable_DbKbank();
			$db->addWithdrawBySender($data);
			Application_Form_FrmMessage::message('ការដកប្រាក់ពីប្រតិបត្តិការនេះ​​ដោយជោគ​ជ័យ');
			}catch (Exception $e){
				Application_Form_FrmMessage::Sucessfull('ការដកប្រាក់ពីប្រតិបត្តិការនេះ​​បរា​ជ័យ', self::REDIRECT_URL . '/index/index');
			}
			
		}
		$session_user=new Zend_Session_Namespace('auth');
		$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
	
		$db_keycode = new Application_Model_DbTable_DbKeycode();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
		$sender = new Application_Model_DbTable_DbSender();
		$_sender = $sender->getAllSenderKbank();

		$this->view->sender = $_sender;
		$cur = new Application_Model_DbTable_DbCurrencies();
		
		$this->view->invoice_no = Application_Model_GlobalClass::getInvoiceWithdraw();
		
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
				$db->editWithDrawById($data);
				Application_Form_FrmMessage::Sucessfull('ការកែប្រែប្រតិបត្តិការនេះ​​ជោគ​ជ័យ', self::REDIRECT_URL .'/withdraw/index');
			}catch (Exception $e){
				Application_Form_FrmMessage::Sucessfull('ការកែប្រែប្រតិបត្តិការនេះបរាជ័យ', self::REDIRECT_URL .'/withdraw/index');
			}
		}
		$db = new Application_Model_DbTable_DbKbank();
		$rs = $db->getTranWithDrawById($tr_id);
		if(empty($rs)){
			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL . '/index/index');
		}
		$this->view->rs = $rs;
		
		$session_user=new Zend_Session_Namespace('auth');
		$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
	
		$db_keycode = new Application_Model_DbTable_DbKeycode();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
	
		$sender = new Application_Model_DbTable_DbSender();
		$_sender = $sender->getAllSenderKbank();
		$this->view->sender = $_sender;
	
	}
	function getAllmoneybysenderAction(){
	if($this->getRequest()->isPost()){
			$_data = $this->getRequest()->getPost();
			$_db = new Application_Model_DbTable_DbKbank();
			$moneys = $_db->getAllMoneyDebtbySender($_data['sender_id']);
			print_r(Zend_Json::encode($moneys));
			exit();
		}
	}
	function getMoneykbankAction(){
		if($this->getRequest()->isPost()){
			$_data = $this->getRequest()->getPost();
			$_db = new Application_Model_DbTable_DbKbank();
			$moneys = $_db->getAllMoneyDeposit($_data['sender_name']);
			//$moneys = 1;
			print_r(Zend_Json::encode($moneys));
			exit();
		}
	}
	

}
