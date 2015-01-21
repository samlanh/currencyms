<?php

class Tellerandexchange_Form_Frmxchange extends Zend_Dojo_Form
{

    public function xchange()
    {
        /* Form Elements & Other Definitions Here ... */
    	
    	$Onetomany=new Zend_Dojo_Form_Element_FilteringSelect('onetomany');
    	$Onetomany->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	$name=array(1=>'ពីមួយទៅច្រើន',2=>'ពីច្រើនទៅមួយ',3=>'ពីមួយទៅមួយ');
    	$Onetomany->setMultiOptions($name);
    	
    	$moneyinaccount=new Zend_Dojo_Form_Element_TextBox('moneyinaccount');
    	$moneyinaccount->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	$Date=new Zend_Dojo_Form_Element_DateTextBox('date');
    	$Date->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox'));
    	$Date->setValue(date('Y-m-d'));
    	$Cusomer=new Zend_Dojo_Form_Element_FilteringSelect('cusomer');
    	$Cusomer->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	$name=array(1=>'General Customer');
    	$Cusomer->setMultiOptions($name);
    	
    	$number_code=new Zend_Dojo_Form_Element_TextBox('number_code');
    	$number_code->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'readOnly'=>true,'style'=>'color:red'));
    	
    	$db = new Application_Model_DbTable_DbGlobal();
    	$iv_numbber = $db->getNewInvoiceExchange();
    	$number_code->setValue($iv_numbber);
    	
//     	$_branch_id = new Zend_Dojo_Form_Element_FilteringSelect('branch_id');
// 		$_branch_id->setAttribs(array(
// 				'dojoType'=>'dijit.form.FilteringSelect',
// // 				'class'=>'fullside',
// 				'required' =>'true'
// 		));
		
// 		$rows = $db->getAllBranchName();
// 		$options='';
// 			if(!empty($rows))foreach($rows AS $row){
// 				$options[$row['br_id']]=$row['branch_namekh'];
// 			}
// // 		$_branch_id->setMultiOptions($options);
		
		
    	$Payusa=new Zend_Dojo_Form_Element_TextBox('payusa');
    	$Payusa->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	$Payr=new Zend_Dojo_Form_Element_TextBox('payr');
    	$Payr->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	$Payb=new Zend_Dojo_Form_Element_TextBox('payb');
    	$Payb->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	$Getusa=new Zend_Dojo_Form_Element_TextBox('getusa');
    	$Getusa->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	$Getr=new Zend_Dojo_Form_Element_TextBox('getr');
    	$Getr->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	$Getb=new Zend_Dojo_Form_Element_TextBox('getb');
    	$Getb->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	$Returnb=new Zend_Dojo_Form_Element_TextBox('returnb');
    	$Returnb->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	$Returnusa=new Zend_Dojo_Form_Element_TextBox('returnusa');
    	$Returnusa->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	$Returnr=new Zend_Dojo_Form_Element_TextBox('returnr');
    	$Returnr->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
		$this->addElements(array($Cusomer,$Date,$Onetomany,$Payusa,$Payr,$Payb,$Getusa,$Getr,$Getb,$Returnusa,$Returnb,$Returnr,$number_code));
		return $this;
    }


}

