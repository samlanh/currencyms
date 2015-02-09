<?php
class Loan_LoanController extends Zend_Controller_Action
{
// 	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	public function init()
	{
		/* Initialize action controller here */
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL') || define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
		//clear all other sessions
		Application_Form_FrmSessionManager::clearSessionSearch();
	}
	public function indexAction()
	{
		try{
			$db = new Loan_Model_DbTable_DbLoanBorrow();
			 
			$rs_rows= $db->geteAllloan($search=null);//call frome model
			       $glClass = new Application_Model_GlobalClass();
			       $rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
			$list = new Application_Form_Frmtable();
			$collumns = array("client_id ","date ");
			$link=array(
					'module'=>'loan','controller'=>'loan','action'=>'edited',
			);
			$this->view->list=$list->getCheckList(0, $collumns,$rs_rows,array('client_id'=>$link,'date'=>$link));
		}catch (Exception $e){ 
			Application_Form_FrmMessage::message("Application Error");
			echo $e->getMessage();
			Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
		}
		
	
	
	}
	
	
   function addAction(){
			if($this->getRequest()->isPost()){
				$data=$this->getRequest()->getPost();
				$db = new Loan_Model_DbTable_DbLoanBorrow ();
				//print_r($db);exit();
				try {
					$db->addLoan($data);
					Application_Form_FrmMessage::message('ការ​បញ្ចូល​​ជោគ​ជ័យ');
				} catch (Exception $e) {
					Application_Form_FrmMessage::message("INSERT_FAIL");
					Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
				}
			}
			$fm = new Loan_Form_FrmLoan();
		    $frm=$fm->addLoan();
		    Application_Model_Decorator::removeAllDecorator($frm);
		    $this->view->frm_loan = $frm;
		}
		function editedAction(){
			if($this->getRequest()->isPost()){
				$data=$this->getRequest()->getPost();
				$db = new Loan_Model_DbTable_DbLoanBorrow ();
				//print_r($db);exit();
				try {
					$db->updateloan($data);
// 					Application_Form_FrmMessage::message('ការ​បញ្ចូល​​ជោគ​ជ័យ','/loan/loan');
					Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​ជោគ​ជ័យ !','/loan/loan');
				} catch (Exception $e) {
					Application_Form_FrmMessage::message("INSERT_FAIL");
					Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
				}
			}
			$id = $this->getRequest()->getParam('id');
			$db = new Loan_Model_DbTable_DbLoanBorrow();
			$row  = $db->geteloanbyid($id);
			$fm = new Loan_Form_FrmLoan();
			$frm=$fm->addLoan($row);
			Application_Model_Decorator::removeAllDecorator($frm);
			$this->view->frm_loan = $frm;
		}
  
}

