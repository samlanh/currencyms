<?php

class Partner_Form_FrmPartner extends Zend_Dojo_Form
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
    public function addPartner($data=NULL)
    {
    	$_db = new Application_Model_DbTable_DbGlobal();
    	$id=new Zend_Form_Element_Hidden('id');
        /* Form Elements & Other Definitions Here ... */
    	$request=Zend_Controller_Front::getInstance()->getRequest();
    	$_title = new Zend_Dojo_Form_Element_TextBox('adv_search');
    	$_title->setAttribs(array(
    			'dojoType'=>$this->tvalidate,
    			'onkeyup'=>'this.submit()',
    			'placeholder'=>$this->tr->translate("SEARCH INFO")
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
    	
    	//////-------------------------------    	
    	$mainbranch=new Zend_Dojo_Form_Element_FilteringSelect('main_branch');
    	$mainbranch->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			));
    	$db = new Partner_Model_DbTable_DbPartner();
    	$opt = $db->getNamePartnerparent(null,1);
    	$mainbranch->setMultiOptions($opt);
    	$mainbranch->setValue($request->getParam('main_branch'));
    	$rows_provice = $_db->getAllProvince();
    	$opt_province = "";
    	$opt_province=array('-1'=>"------Select Province------");
    	if(!empty($rows_provice))foreach($rows_provice AS $row) $opt_province[$row['id']]=$row['name'];
    	$province_name = new Zend_Dojo_Form_Element_FilteringSelect('province_name');
    	$province_name->setAttribs(array('dojoType'=>'dijit.form.FilteringSelect',
//     			'class'=>'fullside',
    			'onchange'=>'filterDistrict();'
    	));
    	
    	$province_name->setMultiOptions($opt_province);
    	$province_name->setAttribs(array(
    			'dojoType'=>'dijit.form.FilteringSelect',
    			'required'=>'true',
//    			'class'=>'fullside',
    	));
    	
    	//------------------------------------------------------------------------
    	$branchname=new Zend_Dojo_Form_Element_ValidationTextBox('branch_name');	
    	$branchname->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox',
    			'required'=>true
    			));
    	
    	$cade_number=new Zend_Dojo_Form_Element_TextBox('cade_number');
    	$cade_number->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$partnername=new Zend_Dojo_Form_Element_TextBox('partner_name');
    	$partnername->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox',
    			'Required'=>true
    			));
    	$photo=new Zend_Form_Element_File('photo');
    	$photo->setAttribs(array(
    			));    	
    	$id_accournnumber = $db->getNewAccountNumber(1);
    	$accournnumber = new Zend_Dojo_Form_Element_TextBox('account_number');
    	$accournnumber->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'readonly'=>'readonly',
    			'style'=>'color:red;'
    	));
    	$accournnumber->setValue($id_accournnumber);

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
    	
    	$communnumber=new Zend_Dojo_Form_Element_ValidationTextBox('commun_number');
    	$communnumber->setAttribs(array(
    			'dojoType'=>'dijit.form.ValidationTextBox',
    			'required'=>true
    			));
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
    	$opt=array(1=>'ប្រើប្រាស់',0=>'មិនបានប្រើប្រាស់',);
    	$status->setMultiOptions($opt);
    	
    	
    	$note=new Zend_Dojo_Form_Element_SimpleTextarea('note');
    	$note->setAttribs(array(
    			'dojoType'=>'dijit.form.SimpleTextarea'));
    	
    	$money_usa=new Zend_Dojo_Form_Element_NumberTextBox('money_usa');
    	$money_usa->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'required'=>true,	
    			));
    	$money_usa->setValue(0);
    	
    	$money_bath=new Zend_Dojo_Form_Element_NumberTextBox('money_bath');
    	$money_bath->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'Required'=>true,	));
    	$money_bath->setValue(0);
    	$money_real=new Zend_Dojo_Form_Element_NumberTextBox('money_riel');
    	$money_real->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'Required'=>true,));
    	$money_real->setValue(0);
    	
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
    	$date =new Zend_Dojo_Form_Element_DateTextBox('date');
    	$date->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox'
    			));
    	 $date->setValue(date('Y-m-d'));
    	 
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
    	if($data!=null){
    		$mainbranch->setValue($data['parent']);
    		$branchname->setValue($data['partner_brand']);
    		//$sub_branch->setValue($data['partner_brand']);
    		$partnername->setValue($data['partner_name']);
    		
    		$accournnumber->setValue($data['account_no']);
    		$cade_number->setValue($data['nation_id']);
    		$homenumber->setValue($data['house_no']);
    		$groupnumber->setValue($data['group_no']);
    		$streetnumber->setValue($data['street']);
//    		$commune_name->setValue($data['commune']);
//     		$districtnumber->setValue($data['district']);
//     		$provicenumber->setValue($data['province']);
    		$province_name->setValue($data['province']);
//    		$district_name->setValue($data['district']);
    		
    		$faxnumber->setValue($data['tel']);
    		$salephone->setValue($data['mobile']);
    		$note->setValue($data['note']);
    		$money_usa->setValue($data['cash_dollar']);
    		$money_bath->setValue($data['cash_bath']);
    		$money_real->setValue($data['cash_riel']);
    		$status_tran->setValue($data['is_cashoperation']);
    		$Address->setValue($data['address']);
    		$date->setValue($data['date']);
    		$id->setValue($data['id']);
    	    $status->setValue($data['status']);
    	
    	}
    	
		$this->addElements(array($id,$_title,$_status_search,$_btn_search,$date,$to_date,$from_date,$branchname,$partnername,$photo,
				$Address,$accournnumber,$homenumber,$groupnumber,
				$streetnumber,$communnumber,
				//$districtnumber,$provicenumber,
				$phonenumber,$faxnumber,$salephone,$note,$status,$cade_number,
				$mainbranch,$money_usa,$money_bath,$money_real,$status_tran,$status_getmoney,$province_name));
		return $this;
    }


}

