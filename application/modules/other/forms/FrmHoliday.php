<?php 
Class Other_Form_FrmHoliday extends Zend_Dojo_Form {
	protected $tr;
	protected $tvalidate ;//text validate
	protected $filter;
	protected $text;
	protected $date;
	public function init()
	{
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
		$this->tvalidate = 'dijit.form.ValidationTextBox';
		$this->filter = 'dijit.form.FilteringSelect';
		$this->text = 'dijit.form.TextBox';
		$this->date = 'dijit.form.DateTextBox';
	}
	public function FrmAddHoliday($_data=null){
	
		$_holiday_name = new Zend_Dojo_Form_Element_TextBox('holiday_name');
		$_holiday_name->setAttribs(array('dojoType'=>$this->tvalidate,'required'=>'true','class'=>'fullside',));
		
		$_startdate = new Zend_Dojo_Form_Element_DateTextBox('start_date');
		$_startdate->setAttribs(array('dojoType'=>$this->date,'required'=>'true',
				'class'=>'fullside',
				'onchange'=>'CalculateDate();'));
		$date = date("Y-m-d");
		$_startdate->setValue($date);
		
		$_enddate = new Zend_Dojo_Form_Element_DateTextBox('end_date');
		$_enddate->setAttribs(array('dojoType'=>$this->date,'required'=>'true','class'=>'fullside',
				));
		$_date = date("Y-m-d");
		$_enddate->setValue($_date);
		
		$_amount_day = new Zend_Dojo_Form_Element_NumberTextBox('amount_day');
		$_amount_day->setAttribs(array('dojoType'=>'dijit.form.NumberTextBox','required'=>'true',
				'class'=>'fullside',
				'onkeyup'=>'CalculateDate();',
				));
		
		$_status=  new Zend_Dojo_Form_Element_FilteringSelect('status');
		$_status->setAttribs(array('dojoType'=>$this->filter,'class'=>'fullside',));
		$_status_opt = array(
				1=>$this->tr->translate("ACTIVE"),
				0=>$this->tr->translate("DACTIVE"));
		$_status->setMultiOptions($_status_opt);
		
		$_id = new Zend_Form_Element_Hidden('id');
		if(!empty($_data)){
			$_holiday_name->setValue($_data['holiday_name']);
			$_startdate->setValue($_data['start_date']);
			$_amount_day->setValue($_data['amount_day']);
			$_enddate->setValue($_data['end_date']);
			$_status->setValue($_data['status']);
			$_id->setValue($_data['id']);
		}
		$this->addElements(array($_id,$_holiday_name,$_startdate,$_enddate,$_amount_day,$_status));
		return $this;
	}
	
}