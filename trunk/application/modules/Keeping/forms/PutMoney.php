<?php

class Money_Form_PutMoney extends Zend_Dojo_Form
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
    	
    	$note1=new Zend_Dojo_Form_Element_TextBox('note1');
    	$note1->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside'));
    	 
    	
    	$namesend=new Zend_Dojo_Form_Element_TextBox('namesend');
    	$namesend->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside'));
    	
    	$daydokmoney=new Zend_Dojo_Form_Element_DateTextBox('daydokmoney');
    	$daydokmoney->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox',
    			'class'=>'fullside'));
    	$daydokmoney->setValue(date('y-m-d'));
    	
    	
    	$dola=new Zend_Dojo_Form_Element_NumberTextBox('dola');
    	$dola->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$dola1=new Zend_Dojo_Form_Element_NumberTextBox('dola1');
    	$dola1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	
    	$bath=new Zend_Dojo_Form_Element_NumberTextBox('bath');
    	$bath->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$bath1=new Zend_Dojo_Form_Element_NumberTextBox('bath1');
    	$bath1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$real=new Zend_Dojo_Form_Element_NumberTextBox('real');
    	$real->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	$real1=new Zend_Dojo_Form_Element_NumberTextBox('real1');
    	$real1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	
    	$dola1=new Zend_Dojo_Form_Element_NumberTextBox('$dola1');
    	$dola1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
//         $typecash1=array(1=>"ដុល្លា",2=>"បាត",3=>"រៀល");
//         $typecash->setMultiOptions($typecash1);
    
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
    	 
    
    	$this->addElements(array($nuber_account,$namesend,$daydokmoney,
    			$dola,$dola1,$bath,$bath1,$real,$real1,$phong,$type,$number
    			,$serv,$get,$up,$note,$note1));
		return $this;
    }

}

