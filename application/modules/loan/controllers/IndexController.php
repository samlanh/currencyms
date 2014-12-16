<?php
class Loan_IndexController extends Zend_Controller_Action
{

const REDIRECT_URL = '/loan';
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	private $user_typelist = array();
	
	private $curr_type = array(
			'1'=>'ដុល្លា',
			'2'=>'បាត',
			'3'=>'រៀល',
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
			$db_tran=new Application_Model_DbTable_DbCustomerLoan();
			 
			//create sesesion
			$session_loan=new Zend_Session_Namespace('search_loan');
			if(empty($session_loan->limit)){
				$session_loan->limit =  Application_Form_FrmNavigation::getLimit();
// 				$session_loan->type_money = -1;
				$session_loan->sender= -1;
				$session_loan->txtsearch="";
				$session_loan->from_date =  date('Y-m-d');
				$session_loan->to_date =  date('Y-m-d');
				$session_loan->lock();
			}
			//start page nevigation
			 
			$limit = $session_loan->limit;
			$start = $this->getRequest()->getParam('limit_satrt',0);
		
			$this->view->from_date=$session_loan->from_date;
			$this->view->to_date=$session_loan->to_date;
			$this->view->sender_id=$session_loan->sender;
// 			$cur = new Application_Model_DbTable_DbCurrencies();
// 			$this->view->currencylist = $cur->getCurrencyList();
// 			$this->view->type_money = $session_loan->type_money;
			 
			$this->view->txtsearch  = $session_loan->txtsearch;
			if($this->getRequest()->isPost()){
				$formdata=$this->getRequest()->getPost();
// 				print_r($formdata);
				$session_loan->unlock();
				$session_loan->txtsearch  = $formdata['txt_search'];
				$session_loan->limit =  $formdata['rows_per_page'];
// 				$session_loan->type_money = $formdata['type_money'];
				$session_loan->sender = $formdata['sender'];
				$session_loan->from_date =  $formdata['from_date'];
				$session_loan->to_date = $formdata['to_date'];
				$session_loan->lock();
		
				$this->view->txtsearch  = $formdata['txt_search'];
// 				$this->view->type_money = $formdata['type_money'];
				$this->view->sender_id=$formdata['sender'];
				
				$this->view->from_date=$session_loan->from_date;
				$this->view->to_date=$session_loan->to_date;
		
				$limit = $session_loan->limit;
		
				$trans= $db_tran->getTranLoanwListBy($formdata, $start, $limit);
				$record_count = $db_tran->getTranLoanListTotal($formdata);
			}
			else{
				$formdata = array(
						'txt_search'=>$session_loan->txtsearch,
						'tran_type'=>$session_loan->tran_type,
						'from_date'=>$session_loan->from_date,
						'to_date'=>$session_loan->to_date,
// 						'type_money'=>$session_loan->type_money,
						'sender'=>$session_loan->sender
				);
				$trans= $db_tran->getTranLoanwListBy($formdata, $start, $limit);
				$record_count = $db_tran->getTranLoanListTotal($formdata);
			}
			$result = array();
			$row_num = $start;
			 
			if (!empty($trans)){
				foreach ($trans as $i => $tran) {
					$expired = '';$is_expired = 0;
					$result[$i] = array(
							'num' => (++$row_num),
							'id' => $tran['b_id'],
							'sender_name' => $tran['sender_name'],
							'tel' => $tran['tel'],
							'status'=>$tran['status'],
							'invoice'=> $tran['invoice'],
							'amount_dollar' =>0,
							'rate_dollar' =>0,
							'amount_bath' =>0,
							'rate_bath' =>0,
							'amount_riel' =>0,
							'rate_riel' =>0,
							'status_dollar'=>1,
							'status_bath'=>1,
							'status_riel'=>1,
							'loan_date'=> date_format(date_create($tran['loan_date']), "d/m/Y"),
					);
					$rows = $db_tran->getBorrowDetail($tran['b_id']);
					foreach ($rows as $key =>$rs){
						if($rs['currency_type']==1){
							$result[$i]['amount_dollar'] = $rs['loan_amount'];
							$result[$i]['rate_dollar'] = $rs['laon_rate'];
							$result[$i]['status_dollar'] = $rs['status'];
						}elseif($rs['currency_type']==2){
							$result[$i]['amount_bath'] = $rs['loan_amount'];
							$result[$i]['rate_bath'] = $rs['laon_rate'];
							$result[$i]['status_bath'] = $rs['status'];
						}else{
							$result[$i]['amount_riel'] = $rs['loan_amount'];
							$result[$i]['rate_riel'] = $rs['laon_rate'];
							$result[$i]['status_riel'] = $rs['status'];
						}
						
						
					}
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
			$_sender = $sender->getAllSenderKbank(2);
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
			$db = new Application_Model_DbTable_DbCustomerLoan();
			$db->AddNewTranLoan($data);
			Application_Form_FrmMessage::message('ការបញ្ចូលប្រតិបត្តិការ​ដោយជោគ​ជ័យ');
			}catch (Exception $e){
				echo $e->getMessage();exit();
				Application_Form_FrmMessage::Sucessfull('ការបញ្ចូលប្រតិបត្តិការ​ដោយជោគ​ជ័យ​​បរា​ជ័យ', self::REDIRECT_URL . '/index/index');
			}
			
		}
		$session_user=new Zend_Session_Namespace('auth');
		$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
	
		$db_keycode = new Application_Model_DbTable_DbKeycode();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
		$sender = new Application_Model_DbTable_DbSender();
		$_sender = $sender->getAllSenderKbank(2);
		array_unshift($_sender, array ('id' => '-1',"name"=>"បន្ថែមឈ្មោះអ្នកផ្ញើរ",'tel'=>'') );
		$this->view->sender = $_sender;
		$cur = new Application_Model_DbTable_DbCurrencies();
		
		$this->view->invoice_no = Application_Model_GlobalClass::getInvoiceWithdraw(5);
		
		$db_rate=new Application_Model_DbTable_DbRate();
		$this->view->rate =  $db_rate->getCurrentRate();
		
		$cur = new Application_Model_DbTable_DbCurrencies();
		$this->view->currency = $cur->getCurrencyList();
	}
	public function editedAction()
	{
		$tr_id = $this->getRequest()->getParam('tr_id');
		$tr_id = (empty($tr_id))? 0 : $tr_id;
		$db = new Application_Model_DbTable_DbCustomerLoan();
		if($this->getRequest()->isPost()){
			try {
				$data = $this->getRequest()->getPost();
				$db->updateTranLoanById($data);
				Application_Form_FrmMessage::Sucessfull('ការកែប្រែប្រតិបត្តិការនេះ​​ជោគ​ជ័យ', self::REDIRECT_URL);
			}catch (Exception $e){
				echo $e->getMessage();exit();
				Application_Form_FrmMessage::Sucessfull('ការកែប្រែប្រតិបត្តិការនេះបរាជ័យ', self::REDIRECT_URL);
			}
		}
		$rs = $db->getTranLaonById($tr_id);
		if(empty($rs)){
			Application_Form_FrmMessage::Sucessfull('មិនអាចទាញយកទិន្នន័យមកកែប្រែបានទេ ', self::REDIRECT_URL . '/index/index');
		}
		$this->view->rs = $rs;
		$result = array();
		$db_tran=new Application_Model_DbTable_DbCustomerLoan();
		$rows = $db_tran->getBorrowDetail($tr_id);
		$result =array(
				'amount_dollar'=>'',
				'rate_dollar'=>'',
				'amount_bath'=>'',
				'rate_bath'=>'',
				'amount_riel'=>'',
				'rate_riel'=>'',);
		foreach ($rows as $key =>$rs){
			if($rs['currency_type']==1){
				$result['amount_dollar'] = $rs['loan_amount'];
				$result['rate_dollar'] = $rs['laon_rate'];
			}elseif($rs['currency_type']==2){
				$result['amount_bath'] = $rs['loan_amount'];
				$result['rate_bath'] = $rs['laon_rate'];
			}else{
				$result['amount_riel'] = $rs['loan_amount'];
				$result['rate_riel'] = $rs['laon_rate'];
			}
		
		}
		$this->view->row = $result;
// 		print_r($result);
		
		$session_user=new Zend_Session_Namespace('auth');
		$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
	
		$db_keycode = new Application_Model_DbTable_DbKeycode();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
	
		$sender = new Application_Model_DbTable_DbSender();
		$_sender = $sender->getAllSenderKbank(2);
		$this->view->sender = $_sender;
		
		$db_rate=new Application_Model_DbTable_DbRate();
		$this->view->rate =  $db_rate->getCurrentRate();
		
		$cur = new Application_Model_DbTable_DbCurrencies();
		$this->view->currency = $cur->getCurrencyList();
	
	}
	public function getAmountAction(){
		if($this->getRequest()->isPost()){
			$_data = $this->getRequest()->getPost();
			$_db = new Application_Model_DbTable_DbCustomerLoan();
			$moneys = $_db->getAddLoanSenderNameById($_data['sender_id']);
			print_r(Zend_Json::encode($moneys));
			exit();
		}
	
	}
	
	

}
