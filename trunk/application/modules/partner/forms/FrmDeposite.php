<?php

class Partner_Form_FrmDeposite extends Zend_Dojo_Form
{

    public function partnerinformation()
    {
        /* Form Elements & Other Definitions Here ... */
    	
    	$accourn_number=new Zend_Dojo_Form_Element_NumberTextBox('accourn_number');
    	$accourn_number->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
    	
    	$name_partner=new Zend_Dojo_Form_Element_TextBox('name_partner');
    	$name_partner->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	$moneyinaccount=new Zend_Dojo_Form_Element_TextBox('moneyinaccount');
    	$moneyinaccount->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$account=new Zend_Dojo_Form_Element_NumberTextBox('account');
    	$account->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
    	
    	$box1=new Zend_Dojo_Form_Element_NumberTextBox('box1');
    	$box1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
    	
    	$box2=new Zend_Dojo_Form_Element_NumberTextBox('box2');
    	$box2->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
    	
    	$box3=new Zend_Dojo_Form_Element_DateTextBox('box3');
    	$box3->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox'));
    	
    	$box4=new Zend_Dojo_Form_Element_NumberTextBox('box4');
    	$box4->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
    	
    	$usa=new Zend_Dojo_Form_Element_NumberTextBox('usa');
    	$usa->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
//     	$name=array(1=>'ដុល្លា');
//     	$usa->setMultiOptions($name);
    	
    	$bath=new Zend_Dojo_Form_Element_NumberTextBox('bath');
    	$bath->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
//      	$name=array(1=>'ដុល្លា');
//     	$bath->setMultiOptions($name);
    	
    	
    	
    	$rail=new Zend_Dojo_Form_Element_NumberTextBox('rail');
    	$rail->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
//     	$arr=array(1=>'រៀល');
//     	$rail->setMultiOptions($arr);
    	
    	
    	$creat_date=new Zend_Dojo_Form_Element_DateTextBox('creat_date');
    	$creat_date->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox'));
    	$creat_date->setValue(date('Y-m-d'));
    
    	
    	
    	
		$this->addElements(array($accourn_number,$name_partner,$moneyinaccount,$account,$box1,$box2,$box3,$box4,
				$bath,$usa,$creat_date,$rail));
		return $this;
    }


}

