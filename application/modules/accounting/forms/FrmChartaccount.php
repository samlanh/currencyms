<?php 
Class Accounting_Form_FrmChartaccount extends Zend_Dojo_Form {
	protected $tr;
	public function init()
	{
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
	}
	public function FrmChartaccount($data=null){
		
		$account_No = new Zend_Dojo_Form_Element_NumberTextBox('account_No');
		$account_No->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required'=>true
				));
		
		$account_Type = new Zend_Dojo_Form_Element_TextBox('account_Type');
		$account_Type->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
				'required'=>true
		));
		
		$account_Name = new Zend_Dojo_Form_Element_TextBox('account_Name');
		$account_Name->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
				'required'=>true
		));
		
		
		$None_operation = new Zend_Dojo_Form_Element_CheckBox('none');
		$None_operation->setAttribs(array(
				'dojoType'=>'dijit.form.CheckBox',
				'class'=>'fullside',
				'required'=>true
		));
		
		$parent = new Zend_Dojo_Form_Element_FilteringSelect('parent');
		$parent->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required'=>true
		));
		$opt=array(1=>'Asset',2=>'Liabilities',3=>'Equity');
		$parent->setMultiOptions($opt);
		
		$Category=new Zend_Dojo_Form_Element_RadioButton("category");
		$Category->setAttribs(array(
				'dojoType'=>'dijit.form.RadioButton',
				'class'=>'fullside',
				'required'=>true
		));
		$array=array(1=>'Creadit',2=>'Debit');
		$Category->setMultiOptions($array);
		
		
		
		
		$Date=new Zend_Dojo_Form_Element_DateTextBox('date');
		$Date->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox',
				'class'=>'fullside'
		));
		$Date->setValue(date('Y-m-d'));
		
		$Status = new Zend_Dojo_Form_Element_FilteringSelect('status');
		$Status->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required'=>true
		));
		$opt=array(1=>'Active',2=>'Deactive');
		$Status->setMultiOptions($opt);
		
		
		$Balance = new Zend_Dojo_Form_Element_FilteringSelect('Balance');
		$Balance->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required'=>true
		));
// 		$opt=array(1=>'Active',2=>'Deactive');
// 		$Status->setMultiOptions($opt);
		
		
		
		
		
// 		$_branch_id = new Zend_Dojo_Form_Element_FilteringSelect('branch_id');
// 		$_branch_id->setAttribs(array(
// 				'dojoType'=>'dijit.form.FilteringSelect',
// 				'class'=>'fullside',
// 				'required' =>'true'
// 		));
// 		$db = new Application_Model_DbTable_DbGlobal();
// 		$rows = $db->getAllBranchName();
// 		$options='';
// 		if(!empty($rows))foreach($rows AS $row){
// 			$options[$row['br_id']]=$row['branch_namekh'];
// 		}
// 		$_branch_id->setMultiOptions($options);
		 
// 		$_id = new Zend_Form_Element_Hidden('id');
		
		$this->addElements(array($account_No,$None_operation,$account_Type,$account_Name,$parent,$Category,$Date,$Status,$Balance));
		return $this;
		
	}	
}