<?php

class Money_Form_NewPut extends Zend_Dojo_Form
{

    public function dakMoney()
    {
        /* Form Elements & Other Definitions Here ... */
    	$nuber_account=new Zend_Dojo_Form_Element_NumberTextBox('nuber_account');
    	$nuber_account->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	$phong=new Zend_Dojo_Form_Element_NumberTextBox('phong');
    	$phong->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	
    	$name=new Zend_Dojo_Form_Element_TextBox('name');
    	$name->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside'));
    	
    	
    	$dola=new Zend_Dojo_Form_Element_NumberTextBox('dola');
    	$dola->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$bath=new Zend_Dojo_Form_Element_NumberTextBox('bath');
    	$bath->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	
    	$real=new Zend_Dojo_Form_Element_NumberTextBox('real');
    	$real->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	
    	$dola1=new Zend_Dojo_Form_Element_NumberTextBox('dola1');
    	$dola1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$bath1=new Zend_Dojo_Form_Element_NumberTextBox('bath1');
    	$bath1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	$real1=new Zend_Dojo_Form_Element_NumberTextBox('real1');
    	$real1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	$type=new Zend_Dojo_Form_Element_FilteringSelect('type');
    	$type->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			'class'=>'fullside'));
    	 
    	$opt=array(1=>"ដុល្លា",2=>"បាត",3=>"រៀល");
    	$type->setMultiOptions($opt);
    	 
    	$number=new Zend_Dojo_Form_Element_NumberTextBox('number');
    	$number->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$serv=new Zend_Dojo_Form_Element_NumberTextBox('serv');
    	$serv->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	$get=new Zend_Dojo_Form_Element_NumberTextBox('get');
    	$get->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	$up=new Zend_Dojo_Form_Element_NumberTextBox('up');
    	$up->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	$note=new Zend_Dojo_Form_Element_NumberTextBox('_note');
    	$note->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	 
    	
    	$this->addElements(array($nuber_account,$phong,$name,$dola,$bath,$real
    			
    			,$dola1,$bath1,$real1,$type,$number,$serv,$get,$up,$note));
		return $this;
    }


}

