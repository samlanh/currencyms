<?php

class Capital_StockController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/capital';
	private $curr_type = array(
			'1'=>'ដុល្លា',
			'2'=>'បាត',
			'3'=>'រៀល',
	);
	private $tran_type = array(
			'-1'=>'គ្រប់ប្រតិបត្តិការ',
			'1'=>'ចំណូល',
			'2'=>'ចំណាយ'
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
			 
			$db_tran=new Application_Model_DbTable_DbStockmoney();
		
			//create sesesion
			$session_stock=new Zend_Session_Namespace('search_stock');
			if(empty($session_stock->limit)){
				$session_stock->limit =  Application_Form_FrmNavigation::getLimit();
				$session_stock->type_money = -1;
				$session_stock->tran_type_id=-1;
				$session_stock->from_date =  date('Y-m-d');
				$session_stock->to_date =  date('Y-m-d');
				$session_stock->lock();
			}
			//start page nevigation
		
			$limit = $session_stock->limit;
			$start = $this->getRequest()->getParam('limit_satrt',0);
		
			$this->view->from_date=$session_stock->from_date;
			$this->view->to_date=$session_stock->to_date;
			$cur = new Application_Model_DbTable_DbCurrencies();
			$this->view->currencylist = $cur->getCurrencyList();
			$this->view->type_money = $session_stock->type_money;
			$this->view->tran_type_id = $session_stock->tran_type_id;
		
			if($this->getRequest()->isPost()){
				$formdata=$this->getRequest()->getPost();
				$session_stock->unlock();
				$session_stock->limit =  $formdata['rows_per_page'];
				$session_stock->type_money = $formdata['type_money'];
				$session_stock->from_date =  $formdata['from_date'];
				$session_stock->to_date = $formdata['to_date'];
				$session_stock->tran_type_id = $formdata['tran_type'];
				
				$session_stock->lock();
		
				
				
				$this->view->from_date=$session_stock->from_date;
				$this->view->to_date=$session_stock->to_date;
				$this->view->tran_type_id = $session_stock->tran_type_id;
		
				$limit = $session_stock->limit;
			}
			else{
				$formdata = array(
						'from_date'=>$session_stock->from_date,
						'to_date'=>$session_stock->to_date,
						'type_money'=>$session_stock->type_money,
						'tran_type' => $session_stock->type_money_id
				);
				 
			}
			$trans= $db_tran->getStockmoneyListBy($formdata, $start, $limit);
			$record_count = $db_tran->getAllStockmoneyList($formdata);
			
			$result = array();
			$row_num = $start;
		
			if (!empty($trans)){
				foreach ($trans as $i => $tran) {
					$result[$i] = array(
							'num' => (++$row_num),
							'id' => $tran['id'],
							'currency_type'=>$this->curr_type[$tran['currency_type']],
							'total_amount' => number_format($tran['amount']).' '.$this->curr_type[$tran['currency_type']],
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

			$this->view->curr_type = $this->curr_typesimble;
			$this->view->tran_type = $this->tran_type;
			 
		} catch (Exception $e) {
		}
	}
    public function addAction()
	    {
	    	$db = new Application_Model_DbTable_DbStockmoney();
	    	if($this->getRequest()->isPost()){
	    		$formdata=$this->getRequest()->getPost();
	    		$db->AddStockMoney($formdata);
	    		Application_Form_FrmMessage::message('ការបញ្ចូលដោយជោគជ័យ');
	    	}
	    	$db = new Application_Model_DbTable_DbGlobal();
	    	$this->view->currency_type = $db->CurruncyTypeOption();
	    	$this->view->curr_dollaramountoption = $db->CurrencyAmountOption(1);
	    	$this->view->curr_bathamountoption = $db->CurrencyAmountOption(2);
	    	$this->view->curr_rielmountoption = $db->CurrencyAmountOption(3);
	    }
	    public function deleteAction(){
	    	if($this->getRequest()->isPost()){
	    		$data = $this->getRequest()->getPost();
	    		$id = $data['id'];
	    		$db_tran=new Application_Model_DbTable_DbStockmoney();
	    		$suc = $db_tran->deleteRecord($id);
	    		print_r(Zend_Json::encode($suc));
	    		exit();
	    		
	    	}
	    }
	    public function backupAction(){
	    	
	    }
	    function backAction(){
	    	
	    }
}