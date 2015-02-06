<?php

class Capital_IndexController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/capital/index/add';
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
     try{
			$db = new Capital_Model_DbTable_DbCapital();
			$rs_rows= $db->getAllCapital();
		//	print_r($rs_rows);exit();
			$glClass = new Application_Model_GlobalClass();
			$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
			$list = new Application_Form_Frmtable();
			$collumns = array("ឈ្មោះបុគ្គលិក","លេខសំគាល់ខ្លួន ","កាល​បរិច្ឆេទ","ប្រភេទប្រាក់","ចំនួនប្រាក់","សំគាល់","Status");
			$link=array(
					'module'=>'capital','controller'=>'index','action'=>'edit',
			);
			$this->view->list=$list->getCheckList(0, $collumns,$rs_rows,array('first_name'=>$link,'date'=>$link,'amount_dolla'=>$link));
		}catch (Exception $e){
			Application_Form_FrmMessage::message("Application Error");
			echo $e->getMessage();
			Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
			 
		}
    	
       
    }
    public function addAction()
    {
	  if($this->getRequest()->isPost()){
    		$dataform=$this->getRequest()->getPost();
    		$db_capital = new Capital_Model_DbTable_DbCapital();
    		try {
    			$db = $db_capital->insertCapital($dataform);
    			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
    		} catch (Exception $e) {
    			$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    	}
        $from=new Capital_Form_FrmCapitale();
        $frm = $from->frmCapital();
        Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
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
    function editAction(){
    	
    	if($this->getRequest()->isPost()){
    		$dataform=$this->getRequest()->getPost();
    		$db_capital = new Capital_Model_DbTable_DbCapital();
    		try {
    			$db = $db_capital->getUpdateCapital($dataform);
    			Application_Form_FrmMessage::Sucessfull('ការ​កែប្រែបាន​​ជោគ​ជ័យ','/capital/index/index');
    		} catch (Exception $e) {
    			$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    	}
    	$id = $this->getRequest()->getParam("id");
    	$db = new Capital_Model_DbTable_DbCapital();
    	$row  = $db->getCapitalbyid($id);
    	$fm = new Capital_Form_FrmCapitale();
    	$frm = $fm->frmCapital($row);
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    	 
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











