<?php 
Class Accounting_Form_FrmGeneraljurnal extends Zend_Dojo_Form {
	protected $tr;
	public function init()
	{
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
	}
	public function FrmGeneraljurnal($data=null){
		
		$Brance = new Zend_Dojo_Form_Element_FilteringSelect('brance');
		$Brance->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required'=>true
		));
      		
      
		$db = new Application_Model_DbTable_DbGlobal();
		$rows = $db->getAllBranchName();
		$options='';
		if(!empty($rows))foreach($rows AS $row){
			$options[$row['br_id']]=$row['branch_namekh'];
		}
		$Brance->setMultiOptions($options);
		
		
		$Add_Date = new Zend_Dojo_Form_Element_DateTextBox('add_date');
		$Add_Date->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox',
				'class'=>'fullside',
				'required'=>true
		));
		$Add_Date->setValue(date('Y-m-d'));
		
		
		$Account_Number=new Zend_Dojo_Form_Element_FilteringSelect('account_number');
		$Account_Number->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required'=>'true'
		));
		$db= new Application_Model_DbTable_DbGlobal();
		$sql="SELECT id,account_name_en,account_code FROM ln_account_name WHERE status=1";
		$rows = $db->getGlobalDb($sql);
		$opt = '';
		if(!empty($rows)){
			foreach($rows as $row){
				$opt[$row['id']]=$row['account_code'];
			}
		}
		$Account_Number->setMultiOptions($opt);
		
		$Account_name = new Zend_Dojo_Form_Element_FilteringSelect('account_name');
		$Account_name->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside'
		));
		
		$opt = '';
		if(!empty($rows)){
			foreach($rows as $row){
				$opt[$row['id']]=$row['account_name_en'];
			}
		}
		$Account_name->setMultiOptions($opt);
		
		
		$Note = new Zend_Dojo_Form_Element_TextBox('note');
		$Note->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside'
		));
		
		$Debit = new Zend_Dojo_Form_Element_TextBox('debit');
		$Debit->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside'
		));
		$Debit->setValue(0);
		
		$Credit = new Zend_Dojo_Form_Element_TextBox('credit');
		$Credit->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside'
		));
		$Credit->setValue(0);
		
		$this->addElements(array($Add_Date,$Account_Number,$Account_name,$Note,$Debit,$Credit,$Brance));
		return $this;
		
	}	
}