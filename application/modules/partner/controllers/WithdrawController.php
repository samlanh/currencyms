<?php

class Partner_WithdrawController extends Zend_Controller_Action
{
	public function indexAction(){
	
	}
	 public function addAction()
	    {
	    
	    
	    	//     	if($this->getRequest()->isPost()){
	    	// 			$agentdata=$this->getRequest()->getPost();
	    	// 			$db_agent = new Application_Model_DbTable_DbAgents();
	    	// 			try {
	    	// 				$db = $db_agent->insertAgent($agentdata);
	    	// 				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
	    	// 			} catch (Exception $e) {
	    	// 				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
	    	// 			}
	    	// 		}
	    	$pructis=new Partner_Form_FrmWithdraw();
	    	$frm = $pructis->dakMoney();
	    	Application_Model_Decorator::removeAllDecorator($frm);
	    	$this->view->frm=$frm;
    }
    function viewAction(){
    	
    }
}