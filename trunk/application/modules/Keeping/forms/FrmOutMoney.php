<?php

class Keeping_Form_FrmOutMoney extends Zend_Dojo_Form
{
	protected $tr=null;
	protected $tvalidate=null ;//text validate
	protected $filter=null;
	protected $text=null;
	protected $tarea=null;
	public function init(){
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
		$this->tvalidate = 'dijit.form.ValidationTextBox';
		$this->filter = 'dijit.form.FilteringSelect';
		$this->text = 'dijit.form.TextBox';
		$this->tarea = 'dijit.form.SimpleTextarea';
	}
    public function dokMoney($data=null)
    {
        /* Form Elements & Other Definitions Here ... */
    	$nuber_account=new Zend_Dojo_Form_Element_TextBox('account_number');
    	$nuber_account->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside',
    			'readOnly'=>true));
        $request=Zend_Controller_Front::getInstance()->getRequest();
    	$_title = new Zend_Dojo_Form_Element_TextBox('adv_search');
    	$_title->setAttribs(array(
    			'dojoType'=>$this->tvalidate,
    			'onkeyup'=>'this.submit()',
    			'placeholder'=>$this->tr->translate("Search withdraw keeping")
    	));
    	$_title->setValue($request->getParam("adv_search"));
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
    	$db = new Keeping_Model_DbTable_DbOutmoney();
    	$opt = $db->getAllPartnerKeeping(null,1);
    	$namesend->setMultiOptions($opt);
    	$namesend->setValue($request->getParam('namesend'));
//     	$name=array(1=>"dara",2=>"Chenda",3=>"nemol");
//     	$namesend->setMultiOptions($name);
    	
    	$daydakmoney=new Zend_Dojo_Form_Element_DateTextBox('daydakmoney');
    	$daydakmoney->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox',
    			'class'=>'fullside'));
    	$daydakmoney->setValue(date('Y-m-d'));
    	
    	
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
    	$from_date = new Zend_Dojo_Form_Element_DateTextBox('start_date');
    	$from_date->setAttribs(array('dojoType'=>'dijit.form.DateTextBox',
    			'required'=>'true',
    			'class'=>'fullside',
    			'onchange'=>'CalculateDate();'));
    	$_date = $request->getParam("start_date");
    	
    	if(empty($_date)){
    		$_date = date('Y-m-01');
    	}
    	$from_date->setValue( $_date);
    	
    	
    	$to_date = new Zend_Dojo_Form_Element_DateTextBox('end_date');
    	$to_date->setAttribs(array('dojoType'=>'dijit.form.DateTextBox',
    			'required'=>'true','class'=>'fullside',
    	));
    	$_date = $request->getParam("end_date");
    	
    	if(empty($_date)){
    		$_date = date("Y-m-d");
    	}
    	$to_date->setValue($_date);
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
    	 
    	if($data!=null){
    		//print_r($data);exit();
    		$nuber_account->setValue($data['account_no']);
    		//$nuber_account->setValue($data['account_number']);
    		$namesend->setValue($data['client_id']);
    		$daydakmoney->setValue($data['create_date']);
    		
    		$note->setValue($data['note']);
    		$b1->setValue($data['bath_before']);
    		$b2->setValue($data['riel_before']);
       		$b3->setValue($data['dollar_before']);
    		$d2->setValue($data['wd_amountriel']);
    		$d1->setValue($data['wd_amountdollar']);
    		$d3->setValue($data['wd_amountbath']);
    		$id->setValue($data['id']);
    		$phone->setValue($data['phone']);
    	}
    	
    	$this->addElements(array($_title,$from_date,$to_date,$_status_search,$_btn_search,$nuber_account,$namesend,$daydakmoney,
    			$dola,$dola1,$bath,$bath1,$real,$real1,$phone,$note,$d1,
    			$d2,$d3,$b1,$r1,$b2,$b3,$r2,$r3,$id));
		return $this;
    }


}

