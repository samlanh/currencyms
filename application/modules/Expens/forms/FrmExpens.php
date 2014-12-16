<?php

class Expens_Form_FrmExpens extends Zend_Dojo_Form
{

    public function addExpens()
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
		
		
		
		
		
		$Income_name=new Zend_Dojo_Form_Element_FilteringSelect('Income_name');
		$Income_name->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect'
		));
		 
		$statuss=new Zend_Dojo_Form_Element_FilteringSelect('statuss');
		$statuss->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect'
		));
		 
		 
		 
		$Dates=new Zend_Dojo_Form_Element_TextBox('Dates');
		$Dates->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox'));
		 
		$Total_amounts=new Zend_Dojo_Form_Element_TextBox('Total_amounts');
		$Total_amounts->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox'));
		 
		 
		 
		 
		$Descriptions=new Zend_Dojo_Form_Element_SimpleTextarea('Descriptions');
		$Descriptions->setAttribs(array(
				'dojoType'=>'dijit.form.SimpleTextarea'));
    	
    	
    	
		$this->addElements(array($Expens_name,$Date,$status,$Total_amount,$Description,$Income_name,$statuss
				,$Dates,$Total_amounts,$Descriptions));
		return $this;
    }


}

