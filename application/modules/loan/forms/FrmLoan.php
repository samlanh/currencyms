<?php

class Loan_Form_FrmLoan extends Zend_Form
{
	protected $tr;
    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
    }
    function addLoan($data=null)
    {
//     	$name_borrower = new Zend_Dojo_Form_Element_FilteringSelect('name_borrower');
//     	$name_borrower->setAttribs(array(
//     			'dojoType'=>'diji.form.FilteringSelect',
//     			'class'=>'fullside'
//     			));
    	
    	$name_borrower=new Zend_Dojo_Form_Element_FilteringSelect('borrower');
    	$name_borrower->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	$opt=array(1=>'គុណ ឧត្តម',2=>'ខុម​ សុវ៉ុន',3=>'សាន ផានិត',4=>'ចាន់ សុរ៉ាវី',5=>'គឹម សុហេង',6=>'ដទៃទៀត...');
    	$name_borrower->setMultiOptions($opt);
    	
    	$acc_number=new Zend_Dojo_Form_Element_NumberTextBox('acc_number');
    	$acc_number->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	
    	$date_borrow=new Zend_Dojo_Form_Element_DateTextBox('date_borrow');
    	$date_borrow->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	$date_borrow ->setValue(date('Y-m-d'));
    	
    	$borrow_number=new Zend_Dojo_Form_Element_NumberTextBox('borrow_number');
    	$borrow_number->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	
    	$date_out=new Zend_Dojo_Form_Element_DateTextBox('date_out');
    	$date_out->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	$date_out ->setValue(date('Y-m-d'));
    	
    	$date_end=new Zend_Dojo_Form_Element_DateTextBox('date_end');
    	$date_end->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	$date_end ->setValue(date('Y-m-d'));
    	
    	$long_time=new Zend_Dojo_Form_Element_FilteringSelect('long_time');
    	$long_time->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	$opt=array(1=>'ថ្ងៃ',2=>'ចុងសប្តាហ៏',3=>'ខែ');
    	$long_time->setMultiOptions($opt);
    	
    	$long_borrow=new Zend_Dojo_Form_Element_NumberTextBox('long_borrow');
    	$long_borrow->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	
    	$salary_type=new Zend_Dojo_Form_Element_FilteringSelect('salary_type');
    	$salary_type->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	$opt=array(1=>'ដុល្លា',2=>'បាត',3=>'រៀល');
    	$salary_type->setMultiOptions($opt);
    	
    	$rate=new Zend_Dojo_Form_Element_NumberTextBox('rate');
    	$rate->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	
    	$note=new Zend_Dojo_Form_Element_TextBox('note');
    	$note->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	
    	$amount=new Zend_Dojo_Form_Element_NumberTextBox('amount');
    	$amount->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	
    	$_status=  new Zend_Dojo_Form_Element_FilteringSelect('status');
    	$_status->setAttribs(array('dojoType'=>'dijit.form.FilteringSelect','class'=>'fullside',));
    	$_status_opt = array(
    			1=>$this->tr->translate("ACTIVE"),
    			0=>$this->tr->translate("DACTIVE"));
    	$_status->setMultiOptions($_status_opt);
    	$_id = new Zend_Form_Element_Hidden('id');
    	
    	$period=new Zend_Dojo_Form_Element_FilteringSelect('Period');
    	$period->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	$opt=array(1=>'ថ្ងៃ',2=>'ចុងសប្តាហ៏',3=>'ខែ');
    	$period->setMultiOptions($opt);
    	
    	$payment=new Zend_Dojo_Form_Element_NumberTextBox('payment');
    	$payment->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'required' =>'true'
    	));
    	
    	if($data!=null){
    		$name_borrower->setValue($data['client_id']);
    		$date_borrow->setValue($data['date']);
//     		$acc_number->setValue($data['acc_number']);
    		$borrow_number->setValue($data['loan_number']);
    		$date_out->setValue($data['date_release']);
    		$date_end->setValue($data['date_line']);
    		$long_time->setValue($data['term']);
    		$long_borrow->setValue($data['amount_borrow']);
    		$salary_type->setValue($data['currency_type']);
    		$rate->setValue($data['amount_loan']);
    		$note->setValue($data['note']);
    		$amount->setValue($data['interest']);
    		$_status->setValue($data['status']);
    		$period->setValue($data['period']);
    		$payment->setValue($data['payment']);
    		$_id->setValue($data['id']);
    	}
    	
    	$this->addElements(array($_status,$_id,$name_borrower,$acc_number,$date_borrow,$borrow_number,$date_out,$date_end,$long_time,$long_borrow,$salary_type,$rate,$note,$amount,$period,$payment));
    	return $this;

	}
}
