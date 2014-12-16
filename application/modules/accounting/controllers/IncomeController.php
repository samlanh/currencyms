<?php

class Accounting_incomeController extends Zend_Controller_Action
{
	function indexAction(){
		
	}
	public function addAction()
	{
		 
		$form=new Accounting_Form_FrmIncome();
		$frm = $form->addIncome();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm=$frm;
	}
}