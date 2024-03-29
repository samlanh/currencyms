<?php

class Partner_Form_FrmDeposite extends Zend_Dojo_Form
{
    public function partnerinformation($data=null)
    {
    	$_db = new Application_Model_DbTable_DbGlobal();
    	$id=new Zend_Form_Element_Hidden('id');
    	/* Form Elements & Other Definitions Here ... */
    	$request=Zend_Controller_Front::getInstance()->getRequest();
    	
        /* Form Elements & Other Definitions Here ... */
    	$accourn_number=new Zend_Dojo_Form_Element_TextBox('accourn_number');
    	$accourn_number->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'readOnly'=>true));
    	$name_partner=new Zend_Dojo_Form_Element_FilteringSelect('name_partner');
    	$name_partner->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			'class'=>'fullside',
    			'Onchange'=>'getPartner()',
    			'Required'=>true));
    	$db = new Application_Model_DbTable_DbGlobal();
    	$opt = $db->getAllPartner(null,1);    	
    	$name_partner->setMultiOptions($opt);
    	$name_partner->setValue($request->getParam('name_partner'));
    	
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
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'readOnly'=>true,));
    	$bathe=new Zend_Dojo_Form_Element_NumberTextBox('bathe');
    	$bathe->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'readOnly'=>true));
    	$reil=new Zend_Dojo_Form_Element_NumberTextBox('reil');
    	$reil->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'readOnly'=>true,));
    	$creat_date=new Zend_Dojo_Form_Element_DateTextBox('creat_date');
    	$creat_date->setAttribs(array(
    	'dojoType'=>'dijit.form.DateTextBox'
    			));
    	$creat_date->setValue(date('Y-m-d'));
    	
    	$db_Deposite = new Partner_Model_DbTable_DbDeposite();
    	$invoices_num = $db_Deposite->getAutonumber();
    	$num_invoice=new Zend_Dojo_Form_Element_TextBox('num_invoice');
    	$num_invoice->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'readOnly'=>true,'style'=>'color:red'));
    	$num_invoice->setValue($invoices_num);
    	
    	$id = new Zend_Form_Element_Hidden('id');
    	if($data!=null){
    		
    		$name_partner->setValue($data['partner_id']);
    		$accourn_number->setValue($data['account_no']);
    		$creat_date->setValue($data['date']);
    		$moneyinaccount->setValue($data['note']);
    		$num_invoice->setValue($data['invoice']);
    		$id->setValue($data['id']);
    		$usa->setValue($data['cash_dollar']);
    		$reil->setValue($data['cash_riel']);
    		$bathe->setValue($data['cash_bath']);
    	}
		$this->addElements(array($accourn_number,$name_partner,$moneyinaccount,$account,$box1,$box2,$box3,$box4,
				$bathe,$usa,$creat_date,$reil,$id,$num_invoice));
		return $this;
    }
}

