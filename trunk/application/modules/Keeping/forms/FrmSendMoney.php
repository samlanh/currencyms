<?php

class Keeping_Form_FrmSendMoney extends Zend_Dojo_Form
{

    public function addSendMoney()
    {
        /* Form Elements & Other Definitions Here ... */
    	$sendname=new Zend_Dojo_Form_Element_FilteringSelect('send_name');
    	$sendname->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			));
    	$opt=array(1=>"បន្ថែមឈ្មោះអ្នកផ្ញើរ",2=>"B",3=>"C",);
        $sendname->setMultiOptions($opt);
        
        $typemoney=new Zend_Dojo_Form_Element_FilteringSelect('type_money');
        $typemoney->setAttribs(array(
        		'dojoType'=>'dijit.form.FilteringSelect',
        		));
        $opt=array(1=>"dollar",2=>"riel",3=>"bart",);
        $typemoney->setMultiOptions($opt);
        
        $pay_term=new Zend_Dojo_Form_Element_FilteringSelect('pay_term');
        $pay_term->setAttribs(array(
        		'dojoType'=>'dijit.form.FilteringSelect',
        ));
        $opt=array(1=>"សប្ថាហ៍",2=>"ខែ",3=>"ឆ្នាំ",);
        $pay_term->setMultiOptions($opt);
         
        $money_inacc=new Zend_Dojo_Form_Element_ValidationTextBox('money_inacc');
        $money_inacc->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
       
        $date =new Zend_Dojo_Form_Element_DateTextBox('date');
        $date->setAttribs(array(
        		'dojoType'=>'dijit.form.DateTextBox'
        ));
        
        $commission=new Zend_Dojo_Form_Element_ValidationTextBox('commission');
        $commission->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
        
        $amount_month=new Zend_Dojo_Form_Element_ValidationTextBox('amount_month');
        $amount_month->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
        
        $total_amount=new Zend_Dojo_Form_Element_ValidationTextBox('total_amount');
        $total_amount->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
        
        $epx_date =new Zend_Dojo_Form_Element_DateTextBox('epx_date');
        $epx_date->setAttribs(array(
        		'dojoType'=>'dijit.form.DateTextBox'
        ));
        
        $recieve_amount=new Zend_Dojo_Form_Element_ValidationTextBox('recieve_amount');
        $recieve_amount->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
        
        $report=new Zend_Dojo_Form_Element_ValidationTextBox('report');
        $report->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
        
        $lbltotal_return=new Zend_Dojo_Form_Element_ValidationTextBox('lbltotal_return');
        $lbltotal_return->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
    	
    	$this->addElements(array($sendname,$typemoney,$pay_term,$money_inacc,$date,$commission,$amount_month,
    			$total_amount,$epx_date,$recieve_amount,$report,$lbltotal_return
    			));
		return $this;
    }


}

