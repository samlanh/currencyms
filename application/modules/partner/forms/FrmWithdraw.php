<?php

class Partner_Form_FrmWithdraw extends Zend_Dojo_Form
{

    public function dakMoney($data=null)
    {
        /* Form Elements & Other Definitions Here ... */
    	$request=Zend_Controller_Front::getInstance()->getRequest();
    	$nuber_account=new Zend_Dojo_Form_Element_TextBox('account_number');
    	$nuber_account->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside',
    			'readOnly'=>true));
//     	$db = new Partner_Model_DbTable_DbWithdraw();
//     	$id_accournnumber = $db->getNewAccountNumber();
//     	$accournnumber = new Zend_Dojo_Form_Element_TextBox('account_number');
//     	$accournnumber->setAttribs(array(
//     			'dojoType'=>'dijit.form.TextBox',
//     			'readonly'=>'readonly',
//     			'style'=>'color:red;'
//     	));
//    	$accournnumber->setValue($id_accournnumber);
    	$phone =new Zend_Dojo_Form_Element_TextBox('phone');
    	$phone->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside'));
    	 
    	$note=new Zend_Dojo_Form_Element_TextBox('note');
    	$note->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside'));
    	$namesend=new Zend_Dojo_Form_Element_FilteringSelect('namesend');
    	$namesend->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			'class'=>'fullside',
    			'Onchange'=>'getfillterById()'));
    	$db = new Application_Model_DbTable_DbGlobal();
    	$opt = $db->getAllPartner(null,1);
    	$namesend->setValue($request->getParam('namesend'));
    	$namesend->setMultiOptions($opt);
//     	$name=array(1=>"dara",2=>"Chenda",3=>"nemol");
//     	$namesend->setMultiOptions($name);
    	
    	$daydokmoney=new Zend_Dojo_Form_Element_DateTextBox('daydokmoney');
    	$daydokmoney->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox',
    			'class'=>'fullside'));
    	$daydokmoney->setValue(date('Y-m-d'));
    	
    	
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
    	 
    	$b1=new Zend_Dojo_Form_Element_NumberTextBox('curr_bath');
    	$b1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'readOnly'=>true));
    	
    	$b2=new Zend_Dojo_Form_Element_NumberTextBox('curr_riel');
    	$b2->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'readOnly'=>true));
    	
    	$b3=new Zend_Dojo_Form_Element_NumberTextBox('curr_dollar');
    	$b3->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'ReadOnly'=>true));
    	
    	$d1=new Zend_Dojo_Form_Element_NumberTextBox('withdraw_dollar');
    	$d1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'onkeyup'=>'CalculateWithdrawDollar(1);CalculateWithdraw_dollar()'
    			 
    	));    	 
    	$d2=new Zend_Dojo_Form_Element_NumberTextBox('withdraw_riel');
    	$d2->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'onkeyup'=>'CalculateWithdrawDollar(3);CalculateWithdraw_riel()'
    			
    			));    	 
    	$d3=new Zend_Dojo_Form_Element_NumberTextBox('withdraw_bath');
    	$d3->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'onkeyup'=>'CalculateWithdrawDollar(2);CalculateWithdraw_bath()'
    		));
    	$r1=new Zend_Dojo_Form_Element_NumberTextBox('remain_dollar');
    	$r1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'ReadOnly'=>true));
    	
    	$r2=new Zend_Dojo_Form_Element_NumberTextBox('remain_riel');
    	$r2->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'ReadOnly'=>true));
    	 
    	$r3=new Zend_Dojo_Form_Element_NumberTextBox('remain_bath');
    	$r3->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside',
    			'ReadOnly'=>true));
    	$id = new Zend_Form_Element_Hidden('id');
    	if($data!=null){
    		//print_r($data);exit();
    		$nuber_account->setValue($data['account_no']);
    		//$nuber_account->setValue($data['account_number']);
    		$namesend->setValue($data['partner_id']);
    		$daydokmoney->setValue($data['date']);
    		
    		$note->setValue($data['note']);
    		$b1->setValue($data['bath_before']);
    		$b2->setValue($data['riel_before']);
       		$b3->setValue($data['dollar_before']);
    		$d2->setValue($data['withdraw_riel']);
    		$d1->setValue($data['withdraw_dollar']);
    		$d3->setValue($data['withdraw_bat']);
    		$id->setValue($data['id']);
    		$phone->setValue($data['phone']);
    	}
    	
    	$this->addElements(array($nuber_account,$namesend,$daydokmoney,
    			$dola,$dola1,$bath,$bath1,$real,$real1,$phone,$note,$d1,
    			$d2,$d3,$b1,$r1,$b2,$b3,$r2,$r3,$id));
		return $this;
    }


}

