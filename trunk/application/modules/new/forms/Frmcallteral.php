<?php 
Class New_Form_Frmcallteral extends Zend_Dojo_Form {
	protected $tr;
	public function init()
	{
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
	}
	public function FrmCallTeral($data=null){
		
		$co_name = new Zend_Dojo_Form_Element_ValidationTextBox('CO_name');
		$co_name->setAttribs(array(
				'dojoType'=>'dijit.form.ValidationTextBox',
				'class'=>'fullside',
				'required'=>true
				));
		$getter_name = new Zend_Dojo_Form_Element_ValidationTextBox('getter_name');
		$getter_name->setAttribs(array(
				'dojoType'=>'dijit.form.ValidationTextBox',
				'class'=>'fullside',
				'required'=>true
		));
		
// 		$getter_name=new Zend_Dojo_Form_Element_ValidationTextBox('getter_name');
// 		$getter_name->setAttribs(array(
// 				'dotoType'=>'dijit.form.ValidationTextBox',
// 				'class'=>'fullside',
// 				'required'=>true,
// 				));
		
		$giver_name = new Zend_Dojo_Form_Element_TextBox('giver_name');
		$giver_name->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
				'required'=>true
		));
		
		$Date=new Zend_Dojo_Form_Element_DateTextBox('Date');
		$Date->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox',
				'class'=>'fullside'
				));
		
		$customer_code = new Zend_Dojo_Form_Element_NumberTextBox('customer_code');
		$customer_code->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required'=>true
		));
		$contract_code = new Zend_Dojo_Form_Element_NumberTextBox('contract_code');
		$contract_code->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required'=>true
		));
		
		$_code = new Zend_Dojo_Form_Element_NumberTextBox('code');
		$_code ->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required'=>true
		));
		$belong_borrower=new Zend_Dojo_Form_Element_RadioButton('belong_borrower');
		$belong_borrower->setAttribs(array(
				'dojoType'=>'dijit.form.RadioButton',
				'class'=>'fullside'
				));
		$option=array(1=>'កម្មសិទ្ធិរបស់អ្នកខ្ចីប្រាក់',2=>'កម្មសិទិ្ធរបស់អ្នកធានា');
		$belong_borrower->setMultiOptions($option);
// 		$_representer=new Zend_Dojo_Form_Element_CheckBox('representer');
// 		$_representer->setAttribs(array(
// 				'dojoType'=>'dijit.form.CheckBox',
// 				'class'=>'fullside'
// 		));
		$borrower = new Zend_Dojo_Form_Element_TextBox('borrower');
		$borrower->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
		));
		$_name=new Zend_Dojo_Form_Element_ValidationTextBox('_name');
		$_name->setAttribs(array(
				'dojoType'=>'dijit.form.ValidationTextBox',
				'class'=>'fullside'
				));
		$_name_=new Zend_Dojo_Form_Element_ValidationTextBox('_name_');
		$_name_->setAttribs(array(
				'dojoType'=>'dijit.form.ValidationTextBox',
				'class'=>'fullside'
		));
		$owner=new Zend_Dojo_Form_Element_ValidationTextBox('owner');
		$owner->setAttribs(array(
				'dojoType'=>'dijit.form.ValidationTextBox',
				'class'=>'fullside'
		));
		$_And_name=new Zend_Dojo_Form_Element_ValidationTextBox('_And_name');
		$_And_name->setAttribs(array(
				'dojoType'=>'dijit.form.ValidationTextBox',
				'class'=>'fullside'
		));
		$_And_name_=new Zend_Dojo_Form_Element_ValidationTextBox('_And_name_');
		$_And_name_->setAttribs(array(
				'dojoType'=>'dijit.form.ValidationTextBox',
				'class'=>'fullside'
		));
		$_personal=new Zend_Dojo_Form_Element_RadioButton('personal');
		$_personal->setAttribs(array(
				'dojoType'=>'dijit.form.RadioButton',
				'class'=>'fullside'
				));
		$opt=array(1=>'ផ្ទាល់ខ្លួន',2=>'អ្នកធានាជំនួស');
		$_personal->setMultiOptions($opt);
// 		print_r($_personal);exit();
// 		$_bollow=new Zend_Dojo_Form_Element_CheckBox('bollow');
// 		$_bollow->setAttribs(array(
// 				'dojoType'=>'dijit.form.CheckBok',
// 				'class'=>'fullside'
// 				));
		$represent_property=new Zend_Dojo_Form_Element_FilteringSelect('represent_property');
		$represent_property->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside'
				));
		$opto=array(1=>'វិញ្ញាបនប័ត្រសម្គាល់អចលនវត្ថុ',2=>'លិខិតផ្ទេរកម្មសិទ្ធិដីធ្លី ',3=>'អត្តសញ្ញាណប័ណ្ណសញ្ជាតិខ្មែរ',4=>'សៀវភៅគ្រួសារ',5=>'លិខិតស្នាក់នៅ',6=>'សំបុត្របញ្ជាក់កំណើត',7=>'ប័ណ្ណបើកបរ',8=>'ប័ណ្ណសំគាល់យានយន្ត(កាតគ្រី)');
		$represent_property->setMultiOptions($opto);
		$estate_code=new Zend_Dojo_Form_Element_NumberTextBox('estate_code');
		$estate_code->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required'=>true
		));
		$Date_estate=new Zend_Dojo_Form_Element_DateTextBox('Date_estate');
		$Date_estate->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox',
				'class'=>'fullside'
		));
		$_id = new Zend_Form_Element_Hidden('id');
		
		$this->addElements(array($co_name,$getter_name,$giver_name,$Date,$customer_code,$contract_code,$_code,$belong_borrower,
				$borrower,$_name,$_name_,$owner,$_And_name,$_And_name_,$_personal,$represent_property,$estate_code,
				$Date_estate));
		return $this;
		
	}	
}