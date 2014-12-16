<?php

class Borrow_Form_FrmBorrow extends Zend_Dojo_Form
{

    public function addBorrow()
    {
        /* Form Elements & Other Definitions Here ... */
    	
    	
    	
    	$borrower=new Zend_Dojo_Form_Element_FilteringSelect('borrower');
    	$borrower->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	
    	$borrow_dollar=new Zend_Dojo_Form_Element_TextBox('borrow_dollar');
    	$borrow_dollar->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$interest_dollar=new Zend_Dojo_Form_Element_TextBox('interest_dollar');
    	$interest_dollar->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	
    	
    	$phone_number=new Zend_Dojo_Form_Element_TextBox('phone_number');
    	$phone_number->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$borrow_bath=new Zend_Dojo_Form_Element_TextBox('Start_day');
    	$borrow_bath->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$interest_bath=new Zend_Dojo_Form_Element_TextBox('interest_bath');
    	$interest_bath->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	
    	$loan_date=new Zend_Dojo_Form_Element_DateTextBox('loan_date');
    	$loan_date->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox'));
    	
    	
    	
    	$borrow_rail=new Zend_Dojo_Form_Element_TextBox('borrow_rail');
    	$borrow_rail->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
     	$interest_rail=new Zend_Dojo_Form_Element_TextBox('interest_rail');
    	$interest_rail->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	 
    	
    	$total_interest=new Zend_Dojo_Form_Element_CheckBox('total_interest');
    	$total_interest->setAttribs(array(
    			'dojoType'=>'dijit.form.CheckBox'));
    	
    	$total_interested=new Zend_Dojo_Form_Element_TextBox('total_interested');
    	$total_interested->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
		$this->addElements(array($borrower,$borrow_dollar,$interest_dollar,$phone_number,$borrow_bath,
				$interest_bath,$loan_date,$borrow_rail,$interest_rail,$total_interested));
		return $this;
    }


}

