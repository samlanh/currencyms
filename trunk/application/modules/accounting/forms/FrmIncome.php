<?php

class Accounting_Form_FrmIncome extends Zend_Dojo_Form
{

    public function addIncome()
    {
        /* Form Elements & Other Definitions Here ... */

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
    	
    	
    	
		$this->addElements(array($Income_name,$statuss
				,$Dates,$Total_amounts,$Descriptions));
		return $this;
    }


}

