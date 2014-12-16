<?php

class Payroll_Form_FrmIndex extends Zend_Dojo_Form
{

    public function addIndex()
    {
        /* Form Elements & Other Definitions Here ... */
    	
    	$staff_name=new Zend_Dojo_Form_Element_TextBox('staff_name');
    	$staff_name->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$Sex=new Zend_Dojo_Form_Element_TextBox('Sex');
    	$Sex->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$position=new Zend_Dojo_Form_Element_TextBox('position');
    	$position->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$Basic_salary=new Zend_Dojo_Form_Element_NumberTextBox('Basic_salary');
    	$Basic_salary->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));

    	
    	$for_manth=new Zend_Dojo_Form_Element_DateTextBox('for_manth');
    	$for_manth->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox'));
    	$for_manth->setValue(date('Y-11-d'));
    	
    	
    	$Start_day=new Zend_Dojo_Form_Element_DateTextBox('Start_day');
    	$Start_day->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox'));
    	$Start_day->setValue(date('Y-m-d'));
    	
    	
    	
		$this->addElements(array($staff_name,$Sex,$position,$Basic_salary,$for_manth,$Start_day));
		return $this;
    }


}