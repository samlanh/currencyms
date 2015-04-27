<?php

class Transfer_Form_FrmIndex extends Zend_Dojo_Form
{

    public function addIndex()
    {
        /* Form Elements & Other Definitions Here ... */
    	
    	$list=new Zend_Dojo_Form_Element_Button('list');
    	$list->setAttribs(array(
    			'dojoType'=>'dijit.form.Button'));
    	
    	$usa=new Zend_Dojo_Form_Element_TextBox('$usa');
    	$usa->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$bath=new Zend_Dojo_Form_Element_TextBox('bath');
    	$bath->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$rial=new Zend_Dojo_Form_Element_TextBox('$rial');
    	$rial->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$usa_rial=new Zend_Dojo_Form_Element_TextBox('usa_rial');
    	$usa_rial->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$usa_bath=new Zend_Dojo_Form_Element_TextBox('usa_bath');
    	$usa_bath->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	 
    	 
    	$bath_rial=new Zend_Dojo_Form_Element_TextBox('bath_rial');
    	$bath_rial->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$money_bank=new Zend_Dojo_Form_Element_CheckBox('money_bank');
    	$money_bank->setAttribs(array(
    			'dojoType'=>'dijit.form.CheckBox'));
    	
    	$loan=new Zend_Dojo_Form_Element_CheckBox('loan');
    	$loan->setAttribs(array(
    			'dojoType'=>'dijit.form.CheckBox'));
    	
    	
    	
    	$cash=new Zend_Dojo_Form_Element_CheckBox('cash');
    	$cash->setAttribs(array(
    			'dojoType'=>'dijit.form.CheckBox'));
    	
    	
    	$currency_type=new Zend_Dojo_Form_Element_FilteringSelect('currency_type');
    	$currency_type->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'
    			));
    	$opt=array(1=>'ដុល្លា',2=>'រៀល',3=>'បាត');
    	$currency_type->setMultiOptions($opt);
    	
//     	$currency_type = new Zend_Dojo_Form_Element_FilteringSelect($spec);
    	
    	
    	
    	
    	$number_money=new Zend_Dojo_Form_Element_TextBox('number_money');
    	$number_money->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$rate_perday=new Zend_Dojo_Form_Element_TextBox('rate_perday');
    	$rate_perday->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$tran_type=new Zend_Dojo_Form_Element_FilteringSelect('tran_type');
    	$tran_type->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	$tran_opt=array(1=>'partner',2=>'client');
    	$tran_type->setMultiOptions($tran_opt);
    	$commission=new Zend_Dojo_Form_Element_TextBox('commission');
    	$commission->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$commission_agent=new Zend_Dojo_Form_Element_TextBox('commission_agent');
    	$commission_agent->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$provinc=new Zend_Dojo_Form_Element_FilteringSelect('provinc');
    	$provinc->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	$opt=array(1=>'កំពង់ធំ(1)',2=>'ប៉ៃលិន(1)',3=>'ពោធិសាត(1)',4=>'សៀមរាប(2)',5=>'ធនាគាថៃ(2)',6=>'កំពង់ចាម(3)',
    			7=>'ប៉ោយប៉ែត(4)',8=>'បន្ទាយមានជ័យ(5)',9=>'បាត់ដំបង់(5)',10=>'ភ្នំពេញ(7)');
    	$provinc->setMultiOptions($opt);
    	
    	
    	
    	$agent_id=new Zend_Dojo_Form_Element_FilteringSelect('agent_id');
    	$agent_id->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	
    	$sub_agant=new Zend_Dojo_Form_Element_FilteringSelect('sub_agant');
    	$sub_agant->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	
    	$sender=new Zend_Dojo_Form_Element_FilteringSelect('sender');
    	$sender->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	
    	$getter=new Zend_Dojo_Form_Element_TextBox('$getter');
    	$getter->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$phone_getter=new Zend_Dojo_Form_Element_TextBox('phone_getter');
    	$phone_getter->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$gave=new Zend_Dojo_Form_Element_TextBox('gave');
    	$gave->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$Total_amount=new Zend_Dojo_Form_Element_TextBox('Total_amount');
    	$Total_amount->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$money_gave=new Zend_Dojo_Form_Element_TextBox('money_gave');
    	$money_gave->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	
    	
    	$return_money=new Zend_Dojo_Form_Element_TextBox('return_money');
    	$return_money->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$send_date=new Zend_Dojo_Form_Element_DateTextBox('send_date');
    	$send_date->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox'));
    	
    	$send_date->setValue(date('Y-m-d'));
 
    	
    	
    	$epx_date=new Zend_Dojo_Form_Element_DateTextBox('epx_date');
    	$epx_date->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox'));
    	$epx_date->setValue(date('Y-m-d'));
    	
    	
		$this->addElements(array($list,$usa,$bath,$rial,$usa_rial,
				$bath_rial,$usa_bath,$money_bank,$cash,$loan,$currency_type,$number_money,
				$rate_perday,$tran_type,$commission,$commission_agent,
				$provinc,$agent_id,$sub_agant,$sender,$getter,$phone_getter,$gave,$Total_amount,
				$money_gave,$send_date,$return_money,$epx_date));
		return $this;
    }


}

