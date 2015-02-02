<?php 
Class Accounting_Form_Frmincome extends Zend_Dojo_Form {
	protected $tr;
	public function init()
	{
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
	}
	public function FrmIncome($data=null){
		
		$account_name = new Zend_Dojo_Form_Element_TextBox('account_name');
		$account_name->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside'
				));
		$for_date = new Zend_Dojo_Form_Element_FilteringSelect('for_date');
		$for_date->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside'
				));
		$opt_month="";
		for($i=1;$i<=12;$i++){
			$opt_month[$i]=$i;
		}
		$for_date->setMultiOptions($opt_month);
		$for_date->setValue(date('m'));
		
		$_Date = new Zend_Dojo_Form_Element_DateTextBox('Date');
		$_Date->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox',
				'required'=>true,
				'class'=>'fullside'
		));
		$_Date->setValue(date('Y-m-d'));
		
	
		
		$_stutas = new Zend_Dojo_Form_Element_FilteringSelect('Stutas');
		$_stutas ->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',	
		));
		$options= array(1=>"ប្រើប្រាស់",2=>"មិនប្រើប្រាស់");
		$_stutas->setMultiOptions($options);
		
		
		$total_amount=new Zend_Dojo_Form_Element_NumberTextBox('total_amount');
		$total_amount->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				));
		
		
		$_Description = new Zend_Dojo_Form_Element_Textarea('Description');
		$_Description ->setAttribs(array(
				'dojoType'=>'dijit.form.SimpleTextarea',
				'class'=>'fullside',
				'style'=>'width:98%',
		));
		
		$id = new Zend_Form_Element_Hidden("id");
		
			if($data!=null){
					
			
				$account_name->setValue($data['account_name']);
				$total_amount->setValue($data['total_amount']);
				$for_date->setValue($data['fordate']);
				$_Description->setValue($data['disc']);
				$_Date->setValue($data['date']);
				$_stutas->setValue($data['status']);
				$id->setValue($data['id']);
		   }	
		$this->addElements(array($account_name,$_Date ,$_stutas,$total_amount,
				$_Description,$for_date,$id));
		return $this;
	}
}