<?php

class Exchange_ExchangrateController extends Zend_Controller_Action
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
    		$db = new Application_Model_DbTable_DbRate();
    		$rs_rows= $db->getAllRate();
    		//	print_r($rs_rows);exit();
//     		$glClass = new Application_Model_GlobalClass();
//     		$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
    		$list = new Application_Form_Frmtable();
    		$collumns = array("និមិត្តសញ្ញា","អត្រា​ទិញចូល ","អត្រា​លក់ចេញ","create_date","active");
    		$link=array(
    				'module'=>'exchange','controller'=>'exchangrate','action'=>'edit',
    		);
    		$this->view->list=$list->getCheckList(0, $collumns,$rs_rows,array('rate_in'=>$link,'rate_out'=>$link,''=>$link));
    	}catch (Exception $e){
    		Application_Form_FrmMessage::message("Application Error");
    		echo $e->getMessage();
    		Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
    	
    	}
    }
    function addAction(){
    	$db_rate=new Application_Model_DbTable_DbRate();
    	
    	if($this->getRequest()->isPost()){
    		$formdata=$this->getRequest()->getPost();
    		try {
    		$db_rate->setNewRate($formdata);
    		Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ','/exchange/exchangrate');
    		}catch(Exception $e){
    			echo $e->getMessage();exit();
    			$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    		}	
    	$this->view->ratelist = $db_rate->getCurrentRate();
    	$db_keycode = new Application_Model_DbTable_DbKeycode();
    	$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
    	$session_user=new Zend_Session_Namespace('auth');
    	$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
    	
    	 
    }
    function editAction(){
    	
    	$db_rate=new Application_Model_DbTable_DbRate();
    	
    	if($this->getRequest()->isPost()){
    		$formdata=$this->getRequest()->getPost();
    		//$db_rate=new Application_Model_DbTable_DbRate();
    		try {
    		$db_rate->setNewRate($formdata);
    		Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ','/exchange/exchangrate');
    		}catch(Exception $e){
    			echo $e->getMessage();exit();
    			$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    		}	
    	
    	$this->view->ratelist = $db_rate->getCurrentRate();
    	$db_keycode = new Application_Model_DbTable_DbKeycode();
    	$this->view->keycode = $db_keycode->getKeyCodeMiniInv();
    	$session_user=new Zend_Session_Namespace('auth');
    	$this->view->user_name = $session_user->last_name .' '. $session_user->first_name;
    	 
    }

   

    
}











