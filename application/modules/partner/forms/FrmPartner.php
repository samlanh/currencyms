<?php

class Partner_Form_FrmPartner extends Zend_Dojo_Form
{

    public function addPartner()
    {
        /* Form Elements & Other Definitions Here ... */
    	
    	$mainbranch=new Zend_Dojo_Form_Element_FilteringSelect('main_branch');
    	$mainbranch->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	$opt=array(1=>'មេ',2=>'កូន',);
    	$mainbranch->setMultiOptions($opt);
    	
    	
    	$branchname=new Zend_Dojo_Form_Element_TextBox('branch_name');	
    	$branchname->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$cade_number=new Zend_Dojo_Form_Element_TextBox('cade_number');
    	$cade_number->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$partnername=new Zend_Dojo_Form_Element_TextBox('partner_name');
    	$partnername->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox'));
    	$photo=new Zend_Form_Element_File('photo');
    	$photo->setAttribs(array(
    			));
    	$accournnumber=new Zend_Dojo_Form_Element_TextBox('accournt_number');
    	$accournnumber->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox'));

    	$Address=new Zend_Dojo_Form_Element_TextBox('address');
    	$Address->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox'));
    	
    	
    	
    	$homenumber=new Zend_Dojo_Form_Element_TextBox('home_number');
    	$homenumber->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox'));
    	
    	$groupnumber=new Zend_Dojo_Form_Element_TextBox('group_number');
    	$groupnumber->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$streetnumber=new Zend_Dojo_Form_Element_TextBox('street_number');
    	$streetnumber->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox'));
    	
    	$communnumber=new Zend_Dojo_Form_Element_TextBox('commun_number');
    	$communnumber->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox'));
    	
    	$districtnumber=new Zend_Dojo_Form_Element_TextBox('district_number');
    	$districtnumber->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox'));
    	
    	$provicenumber=new Zend_Dojo_Form_Element_FilteringSelect('province_number');
    	$provicenumber->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'
    			));
    	$opt=array(1=>'កំពង់ស្ពឺ',2=>'តាកែវ',3=>'កំពត',4=>'កែប',
    			5=>'កណ្តាល',6=>'ស្វាយរៀង',7=>'កំពង់ធំ',8=>'ព្រៃវែង',
    			9=>'ពោធិសាត',10=>'ក្រចេះ',11=>'កំពង់ឆ្នាំង',12=>'រតនគិរី',
    			13=>'ប់ោយប៉ែត',14=>'បន្ទាយមានជ័យ',15=>'សៀមរាប',16=>'ព្រះវិហារ',
    			17=>'មណ្ឌលគិរី',18=>'កំពង់សោម',19=>'ភ្នំពេញ',);
    	$provicenumber->setMultiOptions($opt);
    	
    	$phonenumber=new Zend_Dojo_Form_Element_TextBox('phone_number');
    	$phonenumber->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox'));
    	
    	$faxnumber=new Zend_Dojo_Form_Element_TextBox('fax_number');
    	$faxnumber->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox'));
    	
    	$salephone=new Zend_Dojo_Form_Element_TextBox('sele_phone');
    	$salephone->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox'));
    	
    	
    	$status=new Zend_Dojo_Form_Element_FilteringSelect('status');
    	$status->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'
    	));
    	$opt=array(1=>'status1',2=>'status2',);
    	$status->setMultiOptions($opt);
    	
    	
    	$note=new Zend_Dojo_Form_Element_SimpleTextarea('note');
    	$note->setAttribs(array(
    			'dojoType'=>'dijit.form.SimpleTextarea'));
    	
    	$money_usa=new Zend_Dojo_Form_Element_NumberTextBox('money_usa');
    	$money_usa->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
    	
    	
    	
    	$money_bath=new Zend_Dojo_Form_Element_NumberTextBox('money_bath');
    	$money_bath->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
    	
    	$money_real=new Zend_Dojo_Form_Element_NumberTextBox('money_riel');
    	$money_real->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'));
    	
    	
    	$status_getmoney=new Zend_Dojo_Form_Element_FilteringSelect('status_getmoney');
    	$status_getmoney->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	$opt_status=array(1=>'ដៃគូមេ',2=>'ដៃគូកូន');
    	$status_getmoney->setMultiOptions($opt_status);
    	
    	
    	$status_tran=new Zend_Dojo_Form_Element_FilteringSelect('tran_type');
    	$status_tran->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect'));
    	$status_option=array(1=>'ប្រើប្រាស់សាច់ប្រាក់',2=>'ទូទាត់ខាងក្រៅ');
    	$status_tran->setMultiOptions($status_option);
    	
    	
		$this->addElements(array($branchname,$partnername,$photo,
				$Address,$accournnumber,$homenumber,$groupnumber,
				$streetnumber,$communnumber,$districtnumber,$provicenumber,
				$phonenumber,$faxnumber,$salephone,$note,$status,$cade_number,
				$mainbranch,$money_usa,$money_bath,$money_real,$status_tran,$status_getmoney));
		return $this;
    }


}

