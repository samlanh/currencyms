<?php 
Class Capital_Form_FrmTransfer extends Zend_Dojo_Form {
	
	public function FrmTransfer($_data=null)
	{
		/* Form Elements & Other Definitions Here ... */
// 		$db = new Application_Model_DbTable_DbGlobal();
// 		$rows = $db->getAllBranchName();
// 		$options=array(0=>'សូមជ្រើសរើស សាខា');
// 		if(!empty($rows))foreach($rows AS $row){
// 			$options[$row['br_id']]=$row['branch_namekh'];
// 		}
		
		$brance_from = new Zend_Dojo_Form_Element_FilteringSelect('user_from');
		$brance_from->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'required' =>'true',
				'OnChange'=>'getAmountFrom();',
				//'OnChange'	=> 'getAmountFrom();',
		));
		$db = new Capital_Model_DbTable_DbTransfer();
		$opt = $db->getCapitalByName(null,1);
		$brance_from->setMultiOptions($opt);
		
		$brance_to = new Zend_Dojo_Form_Element_FilteringSelect('user_to');
		$brance_to->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'required' =>'true',
				//'OnChange'	=> 'getAmountTo();',
		));
		$brance_to->setMultiOptions($opt);
		
		$date=new Zend_Dojo_Form_Element_DateTextBox('date');
		$date->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox'
		));
		$date->setValue(date('Y-m-d'));
		$date->setValue(date('Y-m-d'));
		$_stutas = new Zend_Dojo_Form_Element_FilteringSelect('status');
		$_stutas ->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
		));
		$options= array(1=>"ប្រើប្រាស់",0=>"មិនប្រើប្រាស់");
		$_stutas->setMultiOptions($options);
		$note=new Zend_Dojo_Form_Element_TextBox('note');
		$note->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				));
		$usa=new Zend_Dojo_Form_Element_NumberTextBox('usa');
		$usa->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'placeHolder'   =>  '0',
				'class'	=>	'td',
				'Onkeyup'	=>	'validateTransfer(1);',
		));
		$usa->setValue(0);
		$bath=new Zend_Dojo_Form_Element_NumberTextBox('bath');
		$bath->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'	=>	'td',
				'required'	=> true,
				'Onkeyup'	=>	'validateTransfer(2);'
		));
		$bath->setValue(0);
		$reil=new Zend_Dojo_Form_Element_NumberTextBox('reil');
		$reil->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'placeHolder'   =>  '0',
				'class'	=>	'td',
				'required'	=> true,
				'Onkeyup'	=>	'validateTransfer(3);'
		));
		$reil->setValue(0);
		$usa_from=new Zend_Dojo_Form_Element_NumberTextBox('usa_from');
		$usa_from->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'required'	=> true,
				'class'	=>	'td'
		));
		$usa_from->setValue(0);
		$bath_from=new Zend_Dojo_Form_Element_NumberTextBox('bath_from');
		$bath_from->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'placeHolder'   =>  '0',
				'required'	=> true,
				'class'	=>	'td'
		));
		$bath_from->setValue(0);
		$reil_from=new Zend_Dojo_Form_Element_NumberTextBox('reil_from');
		$reil_from->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'placeHolder'   =>  '0',
				'required'	=> true,
				'class'	=>	'td'
		));
		$reil_from->setValue(0);
		$usa_to=new Zend_Dojo_Form_Element_NumberTextBox('usa_to');
		$usa_to->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'placeHolder'   =>  '0',
				'required'	=> true,
				'class'	=>	'td'
		));
		$usa_to->setValue(0);
		$bath_to=new Zend_Dojo_Form_Element_NumberTextBox('bath_to');
		$bath_to->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'placeHolder'   =>  '0',
				'required'	=> true,
				'class'	=>	'td'
		));
		$bath_to->setValue(0);
		$reil_to=new Zend_Dojo_Form_Element_NumberTextBox('reil_to');
		$reil_to->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'placeHolder'   =>  '0',
				'required'	=> true,
				'class'	=>	'td'
		));
		$reil_to->setValue(0);
		$id = new Zend_Form_Element_Text('id');
		if($_data!=null){
			$brance_from->setValue($_data['from_branch']);
			$brance_to->setValue($_data['to_branch']);
// 			$bath_from->setValue($value);
// 			$bath_to->setValue($value);
// 			$reil_from->setValue($value);
// 			$reil_to->setValue($value);
// 			$usa_from->setValue($value);
// 			$usa_to->setValue($value);
			$date->setValue($_data['date']);
			$_stutas->setValue($_data['status']);
			$note->setValue($_data['note']);
			$usa->setValue($_data['amount_dollar']);
			$reil->setValue($_data['amount_riel']);
			$bath->setValue($_data['amount_bath']);
			$id->setValue($_data['id']);
	
		}
		$this->addElements(array($brance_from,$brance_to,$date,$_stutas,
				$note,$bath,$usa,$reil,$usa_from,$bath_from,$reil_from,$usa_to,$bath_to,$reil_to,$id));
		return $this;
	}
}
?>