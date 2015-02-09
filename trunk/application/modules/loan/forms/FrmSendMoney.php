<?php

class Keeping_Form_FrmSendMoney extends Zend_Dojo_Form
{

    public function addSendMoney($data=null)
    {
        /* Form Elements & Other Definitions Here ... */
    	$sendname=new Zend_Dojo_Form_Element_FilteringSelect('send_name');
    	$sendname->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			));
    	$db = new Keeping_Model_DbTable_DbKeeping();
    	$opt = $db->getNameKeeping(null,1);
    	$sendname->setMultiOptions($opt);
//     	$opt=array(1=>"បន្ថែមឈ្មោះអ្នកផ្ញើរ",2=>"B",3=>"C",);
//         $sendname->setMultiOptions($opt);
        
        $typemoney=new Zend_Dojo_Form_Element_FilteringSelect('type_money');
        $typemoney->setAttribs(array(
        		'dojoType'=>'dijit.form.FilteringSelect',
        		));
        $opt=array(1=>"dollar",2=>"riel",3=>"bart",);
        $typemoney->setMultiOptions($opt);
        
        $pay_term=new Zend_Dojo_Form_Element_FilteringSelect('pay_term');
        $pay_term->setAttribs(array(
        		'dojoType'=>'dijit.form.FilteringSelect',
        		'onchange'=>"calExpiredDate();"
        ));
        $db = new Keeping_Model_DbTable_DbKeeping();
        $opt = $db->getNameView(null,1);
        $pay_term->setMultiOptions($opt);
        
//         $opt=array(1=>"ថ្ងៃ",2=>"សប្ថាហ៍",3=>"ខែ",);
//         $pay_term->setMultiOptions($opt);
         
        $money_inacc=new Zend_Dojo_Form_Element_ValidationTextBox('money_inacc');
        $money_inacc->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
       
        $date =new Zend_Dojo_Form_Element_DateTextBox('date');
        $date->setAttribs(array(
        		'dojoType'=>'dijit.form.DateTextBox',
        		'onchange'=>'calExpiredDate();'
        		
        ));
        $date->setValue(date('Y-m-d'));
        $commission=new Zend_Dojo_Form_Element_ValidationTextBox('commission');
        $commission->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
        
        $amount_month=new Zend_Dojo_Form_Element_ValidationTextBox('amount_month');
        $amount_month->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true,
        		'onkeyup'=>"calExpiredDate();"
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
       $epx_date->setValue(date('Y-m-d'));
        
        $recieve_amount=new Zend_Dojo_Form_Element_ValidationTextBox('recieve_amount');
        $recieve_amount->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
        
        $report=new Zend_Dojo_Form_Element_NumberTextBox('report');
        $report->setAttribs(array(
        		'dojoType'=>'dijit.form.NumberTextBox',
        		'required'=>true
        ));
        $report->setValue(0);
        $lbltotal_return=new Zend_Dojo_Form_Element_ValidationTextBox('lbltotal_return');
        $lbltotal_return->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
    	
        $id = new Zend_Form_Element_Hidden("id");
        
        if($data!=null){
        
        	
        	$sendname->setValue($data['client_id']);
        	$pay_term->setValue($data['payment_term']);
        	$date->setValue($data['date_keeping']);
        	$amount_month->setValue($data['amount_keeping']);
        	$epx_date->setValue($data['exp_date']);
        	$report->setValue($data['invoice_number']);
        
        	$id->setValue($data['id']);
        
        }
    	$this->addElements(array($sendname,$typemoney,$pay_term,$money_inacc,$date,$commission,$amount_month,
    			$total_amount,$epx_date,$recieve_amount,$report,$lbltotal_return,$id
    			));
		return $this;
    }


}

