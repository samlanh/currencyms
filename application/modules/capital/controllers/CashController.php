<?php

class Capital_CashController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/capital';
	private $curr_type = array(
			'1'=>'ដុល្លា',
			'2'=>'បាត',
			'3'=>'រៀល',
	);
	private $curr_typesimble = array(
			'1'=>'$',
			'2'=>'B',
			'3'=>'R',
	);
	
	
	
		public function init()
		{
			/* Initialize action controller here */
			header('content-type: text/html; charset=utf8');
			 
			//clear all other sessions
			Application_Form_FrmSessionManager::clearSessionSearch();
			 
			defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
		}
		
	public function indexAction(){
		try {
			 
			$db_tran=new Application_Model_DbTable_Dbpsc();
		
			//create sesesion
			$session_capital=new Zend_Session_Namespace('search_capital');
			if(empty($session_capital->limit)){
				$session_capital->limit =  Application_Form_FrmNavigation::getLimit();
				$session_capital->type_money = -1;
				$session_capital->staff_name= -1;
				$session_capital->from_date =  date('Y-m-d');
				$session_capital->to_date =  date('Y-m-d');
				$session_capital->lock();
			}
			//start page nevigation
		
			$limit = $session_capital->limit;
			$start = $this->getRequest()->getParam('limit_satrt',0);
		
			$this->view->from_date=$session_capital->from_date;
			$this->view->to_date=$session_capital->to_date;
			$this->view->staff=$session_capital->staff;
			$cur = new Application_Model_DbTable_DbCurrencies();
			$this->view->currencylist = $cur->getCurrencyList();
			$this->view->type_money = $session_capital->type_money;
		
			if($this->getRequest()->isPost()){
				$formdata=$this->getRequest()->getPost();
				$session_capital->unlock();
				$session_capital->limit =  $formdata['rows_per_page'];
				$session_capital->type_money = $formdata['type_money'];
				$session_capital->staff_name = $formdata['staff_name'];
				$session_capital->from_date =  $formdata['from_date'];
				$session_capital->to_date = $formdata['to_date'];
				$session_capital->lock();
		
				$this->view->type_money = $formdata['type_money'];
				$this->view->staff_name=$formdata['staff_name'];
		
				$this->view->from_date=$session_capital->from_date;
				$this->view->to_date=$session_capital->to_date;
		
				$limit = $session_capital->limit;
		
			}
			else{
				$formdata = array(
						'from_date'=>$session_capital->from_date,
						'to_date'=>$session_capital->to_date,
						'type_money'=>$session_capital->type_money,
						'staff_name'=>$session_capital->staff_name
				);
				 
			}
			$trans= $db_tran->getPscAmountListBy($formdata, $start, $limit);
			$record_count = $db_tran->getAllPscList($formdata);
			
			$result = array();
			$row_num = $start;
		
			if (!empty($trans)){
				foreach ($trans as $i => $tran) {
					$expired = '';$is_expired = 0;
					$volum = Application_Model_DbTable_DbGlobal::CurrencyOption($tran['currency_type'],$tran['volum']);
					$result[$i] = array(
							'num' => (++$row_num),
							'id' => $tran['id'],
							'staff_name' => $tran['staff_name'],
							'currency_type'=>$this->curr_type[$tran['currency_type']],
							'volum' => number_format($volum).' '.$this->curr_type[$tran['currency_type']],
							'psc_amount' => $tran['psc_amount']." សន្លឹក",
							'total_amount' => number_format($volum * $tran['psc_amount']).' '.$this->curr_type[$tran['currency_type']],
							'note' => $tran['note'],
							'date'=> date_format(date_create($tran['date']), "d/m/Y"),
							'img' => $tran['id'],
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
			 
		
			$usr_mod = new Application_Model_DbTable_DbUsers();
			$user_list = $usr_mod->getUserListSelect();
			array_unshift($user_list, array ('id' => '-1',"name"=>"ជ្រើសរើសឈ្មោះបុគ្គលិក") );
			$this->view->users = $user_list;
			
			$session_user=new Zend_Session_Namespace('auth');
			$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
			
			$db_keycode = new Application_Model_DbTable_DbKeycode();
			$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
			$this->view->rpt_list = $db_tran->countAllStaffpcsAmount($formdata);
			$this->view->curr_type = $this->curr_typesimble;
			 
		} catch (Exception $e) {
		}
	}
    public function addAction()
	    {
	    	$session_user=new Zend_Session_Namespace('auth');
	    	$b = new Application_Model_DbTable_DbCapital();
	    	$user_id = $session_user->user_id;
	    	if($this->getRequest()->isPost()){
	    		$formdata=$this->getRequest()->getPost();
	    		$user_id = $formdata['user_id'];
	    		if($formdata['actions'] == "add_capital"){
	    			if(!empty($formdata['record_row'])){
	    				$b->AddCSPCurrency($user_id, $formdata);
	    				Application_Form_FrmMessage::message('ការបញ្ចូលដោយជោគជ័យ');
	    			}
	    		}
	    	}
	    	$usr_mod = new Application_Model_DbTable_DbUsers();
	    	$this->view->users = $usr_mod->getUserListSelect();
	    	$this->view->balance = $b->getCurrentBallancesByCurrentUser($user_id);
	    	$this->view->user_id = $user_id;
	    	
	    	$db = new Application_Model_DbTable_DbGlobal();
	    	$this->view->curr_type = $db->CurruncyTypeOption();
// 	    	echo  $db->CurrencyAmountOption(1);exit();
	    	$this->view->curr_dollaramountoption = $db->CurrencyAmountOption(1);
	    	$this->view->curr_bathamountoption = $db->CurrencyAmountOption(2);
	    	$this->view->curr_rielmountoption = $db->CurrencyAmountOption(3);
	    }
	    public function deleteAction(){
	    	if($this->getRequest()->isPost()){
	    		$data = $this->getRequest()->getPost();
	    		$id = $data['id'];
	    		$db_tran=new Application_Model_DbTable_Dbpsc();
	    		$suc = $db_tran->deleteRecordpsc($id);
	    		print_r(Zend_Json::encode($suc));
	    		exit();
	    		
	    	}
	    }
}