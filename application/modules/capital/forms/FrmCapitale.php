<?php 
Class Capital_Form_FrmCapitale extends Zend_Dojo_Form {
	public function frmCapital($_data=null)
	{
		/* Form Elements & Other Definitions Here ... */
		$name_staff = new Zend_Dojo_Form_Element_FilteringSelect('name_staff');
		$name_staff ->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'onchange'=>'setId();'
				
		));
		$db = new Capital_Model_DbTable_DbCapital();
		$opt = $db->getNameCs_users(null,1);
		$name_staff->setMultiOptions($opt);
// 		$options= array(1=>"A",2=>"B");
// 		$name_staff->setMultiOptions($options);
		
		$ids = new Zend_Dojo_Form_Element_FilteringSelect('ids');
		$ids ->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'onchange'=>'setName();'
		));
		$db = new Capital_Model_DbTable_DbCapital();
		$opt = $db->getIdCs_users(null,1);
		$ids->setMultiOptions($opt);
		$brance = new Zend_Dojo_Form_Element_FilteringSelect('brance');
		$brance->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required' =>'true'
		));
// 		$db = new Application_Model_DbTable_DbGlobal();
// 		$rows = $db->getAllBranchName();
// 		$options='';
// 		if(!empty($rows))foreach($rows AS $row){
// 			$options[$row['br_id']]=$row['branch_namekh'];
// 		}
// 		$brance->setMultiOptions($options);
		
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
				'required'=>true
				));
		$usa=new Zend_Dojo_Form_Element_ValidationTextBox('usa');
		$usa->setAttribs(array(
				'dojoType'=>'dijit.form.ValidationTextBox',
				'required'=>true
				));
		$usa->setValue("0");
		$bath=new Zend_Dojo_Form_Element_ValidationTextBox('bath');
		$bath->setAttribs(array(
				'dojoType'=>'dijit.form.ValidationTextBox',
				'required'=>true
				));
		$bath->setValue("0");
		$reil=new Zend_Dojo_Form_Element_ValidationTextBox('reil');
		$reil->setAttribs(array(
				'dojoType'=>'dijit.form.ValidationTextBox',
				'required'=>true
				));
	    $reil->setValue('0');
		$id = new Zend_Form_Element_Hidden('id');
		if($_data!=null){
		    $usa->setAttrib('readonly', 1);
		    $reil->setAttrib('readonly', 1);
		    $bath->setAttrib('readonly', 1);
		    if($_data['currency_id']==1){
		    	$usa->setAttrib('readonly', 0);
		    	$usa->setValue($_data['amount']);
		    }elseif($_data['currency_id']==2){
		    	$bath->setAttrib('readonly', 0);
		    	$bath->setValue($_data['amount']);
		    }elseif($_data['currency_id']==3){
		    	$reil->setAttrib('readonly', 0);
		    	$reil->setValue($_data['amount']);
		    }
			$name_staff->setValue($_data['userid']);
			$ids->setValue($_data['userid']);
			$date->setValue($_data['date']);
			$note->setValue($_data['note']);
			$_stutas->setValue($_data['status']);
			$id->setValue($_data['id']);
		}
		$this->addElements(array($name_staff,$ids,$date,$_stutas,
				$note,$bath,$usa,$reil,$id));
		return $this;
	}
}
?>