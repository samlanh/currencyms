<?php

class Keeping_Form_FrmSendMoney extends Zend_Dojo_Form
{
	protected $tr=null;
	protected $tvalidate=null ;//text validate
	protected $filter=null;
	protected $text=null;
	protected $tarea=null;
	public function init()
	{
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
		$this->tvalidate = 'dijit.form.ValidationTextBox';
		$this->filter = 'dijit.form.FilteringSelect';
		$this->text = 'dijit.form.TextBox';
		$this->tarea = 'dijit.form.SimpleTextarea';
	}
	
     
    public function addSendMoney($data=null)
    {
        /* Form Elements & Other Definitions Here ... */
    	$request=Zend_Controller_Front::getInstance()->getRequest();
    	$_title = new Zend_Dojo_Form_Element_TextBox('adv_search');
    	$_title->setAttribs(array(
    			'dojoType'=>$this->tvalidate,
    			'onkeyup'=>'this.submit()',
    			'placeholder'=>$this->tr->translate("Keepping  INFO")
    	));
    	$_title->setValue($request->getParam("adv_search"));
    	
    	$_status_search=  new Zend_Dojo_Form_Element_FilteringSelect('status_search');
    	$_status_search->setAttribs(array('dojoType'=>$this->filter));
    	$_status_opt = array(
    			-1=>$this->tr->translate("ALL"),
    			1=>$this->tr->translate("ACTIVE"),
    			0=>$this->tr->translate("DACTIVE"));
    	$_status_search->setMultiOptions($_status_opt);
    	$_status_search->setValue($request->getParam("status_search"));
    	
    	$_btn_search = new Zend_Dojo_Form_Element_SubmitButton('btn_search');
    	$_btn_search->setAttribs(array(
    			'dojoType'=>'dijit.form.Button',
    			'iconclass'=>'dijitIconSearch'
    	));
    	$sendname=new Zend_Dojo_Form_Element_FilteringSelect('send_name');
    	$sendname->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			));
    	$db = new Keeping_Model_DbTable_DbKeeping();
    	$opt = $db->getNameKeeping(null,1);
    	$sendname->setMultiOptions($opt);
    	$sendname->setValue($request->getParam("send_name"));
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
        		'onchange'=>"calCulateFirstPayment();"
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
        		'onchange'=>'calCulateFirstPayment();'
        		
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
        		//'required'=>true,
//         		'onkeyup'=>"calCulatePeriod();",
//         		'onkeyup'=>"calExpiredDate();",
                 'onkeyup'=>"calCulateFirstPayment();",
        ));
        
        $total_amount=new Zend_Dojo_Form_Element_ValidationTextBox('total_amount');
        $total_amount->setAttribs(array(
        		'dojoType'=>'dijit.form.ValidationTextBox',
        		'required'=>true
        ));
        
        $epx_date =new Zend_Dojo_Form_Element_DateTextBox('epx_date');
        $epx_date->setAttribs(array(
        		'dojoType'=>'dijit.form.DateTextBox',
        		//'onchange'=>"calCulateFirstPayment();"
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
    	
        $from_date = new Zend_Dojo_Form_Element_DateTextBox('start_date');
        $from_date->setAttribs(array('dojoType'=>'dijit.form.DateTextBox',
        		'required'=>'true',
        		'class'=>'fullside',
        		//'onchange'=>'CalculateDate();'
        ));
        $_date = $request->getParam("start_date");
        
        if(empty($_date)){
        	$_date = date('Y-m-01');
        }
        $from_date->setValue( $_date);
        
        
        $to_date = new Zend_Dojo_Form_Element_DateTextBox('end_date');
        $to_date->setAttribs(array(
        		'dojoType'=>'dijit.form.DateTextBox',
        		'required'=>'true','class'=>'fullside',
        ));
        $_date = $request->getParam("end_date");
        
        if(empty($_date)){
        	$_date = date("Y-m-d");
        }
        $to_date->setValue($_date);
        
        
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
    	$this->addElements(array($from_date,$to_date,$sendname,$_title,$_status_search,$_btn_search,$typemoney,$pay_term,$money_inacc,$date,$commission,$amount_month,
    			$total_amount,$epx_date,$recieve_amount,$report,$lbltotal_return,$id
    			));
		return $this;
    }


}

