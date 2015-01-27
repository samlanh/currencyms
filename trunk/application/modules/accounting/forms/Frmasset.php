<?php 
Class Accounting_Form_Frmasset extends Zend_Dojo_Form {
	protected $tr;
	public function init()
	{
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
	}
	public function FrmAsset($data=null){
		
		$asset_name = new Zend_Dojo_Form_Element_TextBox('asset_name');
		$asset_name->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
				'required'=>true
				));
		
		$asset_code = new Zend_Dojo_Form_Element_NumberTextBox('asset_code');
		$asset_code->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required'=>true
		));
		
		$db = new Application_Model_DbTable_DbGlobal();
		$paid_type = new Zend_Dojo_Form_Element_FilteringSelect('paid_type');
		$paid_type->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required'=>true
		));
		$opt= $db->getVewOptoinTypeByType(7,1);
		$paid_type->setMultiOptions($opt);
		$paid_type->setValue(1);
		
		$note = new Zend_Dojo_Form_Element_TextBox('note');
		$note->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
				'required'=>true
		));
		
		$_stutas = new Zend_Dojo_Form_Element_FilteringSelect('status');
		$_stutas ->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
			
		));
		$options= array(1=>"ប្រើប្រាស់",0=>"មិនប្រើប្រាស់");
		$_stutas->setMultiOptions($options);
		

		
		$some_payamount = new Zend_Dojo_Form_Element_TextBox('some_payamount');
		$some_payamount->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
				'required'=>true
		));
		
		
		
		$asset_type = new Zend_Dojo_Form_Element_FilteringSelect('asset_type');
		$asset_type->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required'=>true
		));
		$opt=array(1=>'Long Term',2=>'Short Term');
		$asset_type->setMultiOptions($opt);
		
		$asset_cost=new Zend_Dojo_Form_Element_NumberTextBox('asset_cost');
		$asset_cost->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required'=>'true'
				));
		
		$useful_life = new Zend_Dojo_Form_Element_NumberTextBox('usefull_life');
		$useful_life->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required'=>true
		));
		
		$salvage_value = new Zend_Dojo_Form_Element_NumberTextBox('salvage_value');
		$salvage_value->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required'=>'true'
				));
		
		$payment_method=new Zend_Dojo_Form_Element_FilteringSelect('payment_method');
		$payment_method->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside'
				));
		$option=array(1=>'Straight line',2=>'Double-declining banlance',3=>'Sum of the year');
		$payment_method->setMultiOptions($option);
		
		$Date=new Zend_Dojo_Form_Element_DateTextBox('date');
		$Date->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox',
				'class'=>'fullside'
				));
		$Date->setValue(date('Y-m-d'));
		
		$start_date = new Zend_Dojo_Form_Element_DateTextBox('start_date');
		$start_date->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox',
				'class'=>'fullside'
		));
		$start_date->setValue(date('Y-m-d'));
		
		
		$_branch_id=new Zend_Dojo_Form_Element_FilteringSelect('branch');
		$_branch_id->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required' =>'true'
				));
		
// 		$_branch_id = new Zend_Dojo_Form_Element_FilteringSelect('branch_id');
// 		$_branch_id->setAttribs(array(
// 				'dojoType'=>'dijit.form.FilteringSelect',
// 				'class'=>'fullside',
// 				'required' =>'true'
// 		));
		$db = new Application_Model_DbTable_DbGlobal();
		$rows = $db->getAllBranchName();
		$options='';
		if(!empty($rows))foreach($rows AS $row){
			$options[$row['br_id']]=$row['branch_namekh'];
		}
		$_branch_id->setMultiOptions($options);
		 
		$_id = new Zend_Form_Element_Hidden('id');
		
		if($data!=null){
			$_branch_id->setValue($data['branch_id']);
			$asset_name->setValue($data['fixed_assetname']);
			$asset_type->setValue($data['fixed_asset_type']);
			$asset_cost->setValue($data['asset_cost']);
			$useful_life->setValue($data['usefull_life']);
			$salvage_value->setValue($data['salvagevalue']);
			$payment_method->setValue($data['payment_method']);
			$Date->setValue($data['depreciation_start']);
			$start_date->setValue($data['date']);
			$asset_code->setValue($data['asset_code']);
			$paid_type->setValue($data['pay_type']);
			$some_payamount->setValue($data['some_payamount']);
			$note->setValue($data['note']);
			$_stutas->setValue($data['status']);
			$_id->setValue($data['id']);
			
		}
		
		$this->addElements(array($asset_name,$asset_type,$asset_cost,$start_date,$useful_life,$salvage_value,$payment_method,
				$Date,$_branch_id,$_id,$asset_code,$paid_type,$note,$_stutas,$some_payamount));
		return $this;
		
	}	
}