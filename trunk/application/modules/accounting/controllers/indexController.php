<?php
 
class Accounting_IndexController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/accounting/index';
	
    public function init()
    {
        /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
    }

    public function indexAction()
    {
    	try{
    		$db = new Accounting_Model_DbTable_DbIndex();
    		if($this->getRequest()->isPost()){
    			$search=$this->getRequest()->getPost();
    		}
    		else{
    			$search = array(
    					'adv_search' => '',
    					'status_search' => -1);
    		}
			$rs_rows= $db->getAllIncomeAndExpense($search=null);//call frome model
			$this->view->tran_list =$rs_rows;
			$total_r = $db->getTotalRiel();
			foreach ($total_r as $reil){
				$this->view->total_reil = $reil['total_amount'];
			}
			$total_d = $db->getTotalDollar();
			foreach ($total_d as $dollar){ 
				$this->view->total_dollar = $dollar['total_amount'];
			}
			$total_b = $db->getTotalBat();
			foreach ($total_b as $bat){
				$this->view->total_bat = $bat['total_amount'];
			}
    		
    	}catch (Exception $e){
    		Application_Form_FrmMessage::message("Application Error");
    		echo $e->getMessage();
    		Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
    	}
//      	$pructis=new Accounting_Form_Frmindex();
//     	$frm = $pructis->FrmAddIndex();
//     	Application_Model_Decorator::removeAllDecorator($frm);
//      	$this->view->frm_info=$frm;
     }

}







