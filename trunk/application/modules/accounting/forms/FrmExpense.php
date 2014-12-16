<?php

class Accounting_Form_FrmExpense extends Zend_Dojo_Form
{

    public function addExpense()
    {
        /* Form Elements & Other Definitions Here ... */

    	$Expens_name=new Zend_Dojo_Form_Element_FilteringSelect('Expens_name');
    	$Expens_name->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'
    			));
    	
    	$status=new Zend_Dojo_Form_Element_FilteringSelect('status');
    	$status->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'
    	));
    	
    	
    	
    	$Date=new Zend_Dojo_Form_Element_TextBox('Date');
    	$Date->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$Total_amount=new Zend_Dojo_Form_Element_TextBox('Total_amount');
    	$Total_amount->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	
    	
    	$Description=new Zend_Dojo_Form_Element_SimpleTextarea('Description');
		$Description->setAttribs(array(
    			'dojoType'=>'dijit.form.SimpleTextarea'));
    	
    	
    	
		$this->addElements(array($Expens_name,$Date,$status,$Total_amount,$Description));
		return $this;
    }


}

