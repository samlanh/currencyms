<?php

class Accounting_expenseController extends Zend_Controller_Action
{
	function indexAction(){
		
	}
	public function addAction()
	{
		 
		$form=new Accounting_Form_FrmExpense();
		$frm = $form->addExpense();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm=$frm;
	}

}