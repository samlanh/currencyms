<?php

class Capital_IndexController extends Zend_Controller_Action
{

	const REDIRECT_URL = '/capital';
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
    	
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
    }

    public function indexAction()
    {
        // action body	
        try {
        	
    		$db_tran=new Application_Model_DbTable_DbCurrentCapital();
    		
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
    		$trans= $db_tran->getTranCapitalListBy($formdata, $start, $limit);
    		$record_count = $db_tran->getTranCapitalListTotal($formdata);
    		$result = array();
    		$row_num = $start;
    		
    		if (!empty($trans)){
    			foreach ($trans as $i => $tran) {
    				$expired = '';$is_expired = 0;
    				$result[$i] = array(
    						'num' => (++$row_num),
    						'id' => $tran['id'],
    						'agent_name' => $tran['agent_name'],
    						'curr_type'=>$this->curr_type[$tran['curr_type']],
    						'amount' => (($tran['sign']==1)?'':'-').''.$tran['amount'].' '.$this->curr_type[$tran['curr_type']],
    						'date'=> date_format(date_create($tran['date']), "d/m/Y"),
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
    			
    		$cur = new Application_Model_DbTable_DbCurrencies();
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
    			if($formdata['dollar']!=0 OR $formdata['bath']!=0 OR $formdata['rail']!=0 ){
    				$b->addBalanceByUser($user_id, $formdata);
    			}
    			if(!empty($formdata['record_row'])){
    				$b->AddCSPCurrency($user_id, $formdata);
    			}
    			Application_Form_FrmMessage::message('ការ​កែប្រែជោគ​ជ័យ');
    		}
    	}
    	$usr_mod = new Application_Model_DbTable_DbUsers();
    	$this->view->users = $usr_mod->getUserListSelect();
    	$this->view->balance = $b->getCurrentBallancesByCurrentUser($user_id);
    	$this->view->user_id = $user_id;
    	
    	
//     	$form->setFormDetail('','',$user_id);
//     	$this->view->form=$form;
    	
    	$db = new Application_Model_DbTable_DbGlobal();
    	$this->view->curr_type = $db->CurruncyTypeOption();
    	
	    $this->view->curr_dollaramountoption = $db->CurrencyAmountOption(1);
	    $this->view->curr_bathamountoption = $db->CurrencyAmountOption(2);
	    $this->view->curr_rielmountoption = $db->CurrencyAmountOption(3);
    }

    public function editedAction()
    {
        $id = $this->getRequest()->getParam('tran_id',0);
        $session_user=new Zend_Session_Namespace('auth');
        $b = new Application_Model_DbTable_DbCurrentCapital();
        $user_id = $session_user->user_id;
        if($this->getRequest()->isPost()){
        	$formdata=$this->getRequest()->getPost();
        	$user_id = $formdata['user_id'];
        	if($formdata['actions'] == "add_capital"){
        		if($formdata['dollar']!=0 OR $formdata['bath']!=0 OR $formdata['rail']!=0 ){
//         			print_R($formdata);exit();
        			$b->updateCapitalDetailById($formdata);
        			Application_Form_FrmMessage::Sucessfull('ការ​កែប្រែជោគ​ជ័យ', self::REDIRECT_URL . '/index/index');
        		}
        	}
        }
       	$db = new Application_Model_DbTable_DbCurrentCapital();
       	$rs = $db->getCapitalDetailById($id,1);
       	$this->view->rs = $rs;
        $usr_mod = new Application_Model_DbTable_DbUsers();
        $this->view->users = $usr_mod->getUserListSelect();
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
    }
    public function balanceAction(){
    	$session_user=new Zend_Session_Namespace('auth');
    	$b = new Application_Model_DbTable_DbCapital();
    	$user_id = $session_user->user_id;
    	if($this->getRequest()->isPost()){
    		$formdata=$this->getRequest()->getPost();
    		$user_id = $formdata['user_id'];
    		if($formdata['actions'] == "add_capital"){
    			//$b->addBalanceByUser($user_id, $formdata);
    		}
    	}
    	$cp_db = new Application_Model_DbTable_DbCapital();
    	$rs_d = $cp_db->DetechCapitalExist($user_id,1,null);//check if add capital exist
    	$rs_b = $cp_db->DetechCapitalExist($user_id,2,null);//check if add capital exist
    	$rs_r = $cp_db->DetechCapitalExist($user_id,3,null);//check if add capital exist
    	$total_balance = array(
    			'dollar'=>empty($rs_d)?0:$rs_d['amount'],
    			'baht'=>empty($rs_b)?0:$rs_b['amount'],
    			'riel'=>empty($rs_r)?0:$rs_r['amount'],
    	);
    	$balance = $b->getCurrentBallancesByCurrentUser($user_id);
    	 
    	$arr_img = array();
    	foreach ($balance as $key=>$val){
    		if($key=='dollar'){
    			$k = 'dollar';
    		}elseif ($key=='bath'){
    			$k = 'baht';
    		}else{
    			$k = 'riel';
    		}
    
    		if($total_balance[$k]>$val){
    			$arr_img[$k] = array('amount'=>$total_balance[$k]-$val,'img'=>'up');
    		}elseif($total_balance[$k]<$val){
    			$arr_img[$k] = array('amount'=>$val-$total_balance[$k],'img'=>'down');
    		}else{
    			$arr_img[$k] = array('amount'=>0,'img'=>'');
    		}
    	}
    	 
    	$usr_mod = new Application_Model_DbTable_DbUsers();
    	$this->view->users = $usr_mod->getUserListSelect();
    	$this->view->balance = $balance;
    	$this->view->total_balance = $total_balance;
    	$this->view->img = $arr_img;
    	$this->view->user_id = $user_id;
    }
}











