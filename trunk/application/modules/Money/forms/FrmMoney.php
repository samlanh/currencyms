<?php

class Money_Form_FrmMoney extends Zend_Dojo_Form
{

    public function addMoney()
    {
        /* Form Elements & Other Definitions Here ... */
    	$nuber_account=new Zend_Dojo_Form_Element_NumberTextBox('nuber_account');
    	$nuber_account->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$namecustomer=new Zend_Dojo_Form_Element_TextBox('namecustomer');
    	$namecustomer->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside'));
    	
    	$phone=new Zend_Dojo_Form_Element_NumberTextBox('phone');
    	$phone->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$note=new Zend_Dojo_Form_Element_NumberTextBox('note');
    	$note->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$dola1=new Zend_Dojo_Form_Element_NumberTextBox('$dola1');
    	$dola1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$dola2=new Zend_Dojo_Form_Element_NumberTextBox('$dola2');
    	$dola2->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$dola3=new Zend_Dojo_Form_Element_NumberTextBox('$dola3');
    	$dola3->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$bath1=new Zend_Dojo_Form_Element_NumberTextBox('bath1');
    	$bath1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$bath2=new Zend_Dojo_Form_Element_NumberTextBox('bath2');
    	$bath2->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	$bath3=new Zend_Dojo_Form_Element_NumberTextBox('bath3');
    	$bath3->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$real1=new Zend_Dojo_Form_Element_NumberTextBox('real1');
    	$real1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$real2=new Zend_Dojo_Form_Element_NumberTextBox('real2');
    	$real2->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$real3=new Zend_Dojo_Form_Element_NumberTextBox('real3');
    	$real3->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	 
//         $typecash1=array(1=>"ដុល្លា",2=>"បាត",3=>"រៀល");
//         $typecash->setMultiOptions($typecash1);
    	
    	
    	
    	$this->addElements(array($nuber_account,$namecustomer,$phone,$note,$dola1,$dola2,$dola3,
    			$bath1,$bath2,$bath3,$real1,$real2,$real3));
		return $this;
    }


}

