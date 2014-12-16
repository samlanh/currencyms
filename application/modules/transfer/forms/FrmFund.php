<?php

class Transfer_Form_FrmFund extends Zend_Dojo_Form
{

    public function addFund()
    {
        /* Form Elements & Other Definitions Here ... */
    	
    	$Fund_names=new Zend_Dojo_Form_Element_FilteringSelect('Fund_name');
    	$Fund_names->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	$opt=array(1=>'A');
    	$Fund_names->setMultiOptions($opt);
    	
    	$pay_days=new Zend_Dojo_Form_Element_DateTextBox('pay_day');
    	$pay_days->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox'));
    	$pay_days->setValue(date('Y-m-d'));
    	
    	
    	
    	$pay_moneys=new Zend_Dojo_Form_Element_FilteringSelect('pay_money');
    	$pay_moneys->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	$pay=array(1=>'សងប្រាក់', 2=>'ដុល្លា',3=>'រៀល',4=>'បាត');
    	$pay_moneys->setMultiOptions($pay);
    	
    	
    	$Fund_usas=new Zend_Dojo_Form_Element_TextBox('Fund_usa');
    	$Fund_usas->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$Fund_baths=new Zend_Dojo_Form_Element_TextBox('Fund_bath');
    	$Fund_baths->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$Fund_rials=new Zend_Dojo_Form_Element_TextBox('Fund_rial');
    	$Fund_rials->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	
    	$pay_usas=new Zend_Dojo_Form_Element_TextBox('pay_usa');
    	$pay_usas->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	
    	$pay_baths=new Zend_Dojo_Form_Element_TextBox('pay_bath');
    	$pay_baths->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	
    	$pay_rials=new Zend_Dojo_Form_Element_TextBox('pay_rial');
    	$pay_rials->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$pay_amounte=new Zend_Dojo_Form_Element_FilteringSelect('pay_amount');
    	$pay_amounte->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	$pay=array(1=>'bath', 2=>'USA',3=>'Rail');
    	$pay_amounte->setMultiOptions($pay);
    	
    	
    	$amounts=new Zend_Dojo_Form_Element_TextBox('amount');
    	$amounts->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$return_moneys=new Zend_Dojo_Form_Element_TextBox('return_money');
    	$return_moneys->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$pay_amounts=new Zend_Dojo_Form_Element_CheckBox('pay_amounts');
    	$pay_amounts->setAttribs(array(
    			'dojoType'=>'dijit.form.CheckBox'));
    	
    	
    	$persent_exchang=new Zend_Dojo_Form_Element_TextBox('persent_exchang');
    	$persent_exchang->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$usa_bath=new Zend_Dojo_Form_Element_TextBox('usa_bath');
    	$usa_bath->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$usa_rail=new Zend_Dojo_Form_Element_TextBox('usa_rail');
    	$usa_rail->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$rail_bath=new Zend_Dojo_Form_Element_TextBox('rail_bath');
    	$rail_bath->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$usa=new Zend_Dojo_Form_Element_TextBox('usa');
    	$usa->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$bath=new Zend_Dojo_Form_Element_TextBox('bath');
    	$bath->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$rail=new Zend_Dojo_Form_Element_TextBox('rail');
    	$rail->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	
		$this->addElements(array($Fund_names,$pay_days,$pay_moneys,$Fund_rials,$Fund_baths,$Fund_usas,
				$pay_usas,$pay_baths,$pay_rials,$pay_amounte,$amounts,$return_moneys,$pay_amounts,$persent_exchang
				,$usa_bath,$usa_rail,$rail_bath,$usa,$bath,$rail));
		return $this;
    }


}

