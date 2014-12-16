<?php

class Test_Form_FrmTest extends Zend_Dojo_Form
{

    public function addTest()
    {
        /* Form Elements & Other Definitions Here ... */
    	$input=new Zend_Dojo_Form_Element_TextBox('input');
    	$input->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside'));
    	

    	$output=new Zend_Dojo_Form_Element_TextBox('output');
    	$output->setAttribs(array(
    			'dojoType'=>'dijit.form.NTextBox',
    			'class'=>'fullside'));
    	
    	$insert=new Zend_Dojo_Form_Element_TextBox('insert');
    	$insert->setAttribs(array(
    			'dojoType'=>'dijit.form.NTextBox',
    			'class'=>'fullside'));
    	
    	$delet=new Zend_Dojo_Form_Element_TextBox('delet');
    	$delet->setAttribs(array(
    			'dojoType'=>'dijit.form.NTextBox',
    			'class'=>'fullside'));
    	
    	
    	$updete=new Zend_Dojo_Form_Element_TextBox('updete');
    	$updete->setAttribs(array(
    			'dojoType'=>'dijit.form.NTextBox',
    			'class'=>'fullside'));
    	
    	$edit=new Zend_Dojo_Form_Element_TextBox('edit');
    	$edit->setAttribs(array(
    			'dojoType'=>'dijit.form.NTextBox',
    			'class'=>'fullside'));
    	
    	
    	
    	$this->addElements(array($input,$output,$insert,$delet,$updete,$edit));
		return $this;
    }


}

