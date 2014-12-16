<?php 
Class Other_Form_FrmZone extends Zend_Dojo_Form {
	protected $tr;
	protected $tvalidate ;//text validate
	protected $filter;
	protected $text;
	public function init()
	{
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
		$this->tvalidate = 'dijit.form.ValidationTextBox';
		$this->filter = 'dijit.form.FilteringSelect';
		$this->text = 'dijit.form.TextBox';
	}
	public function FrmAddZone($_data=null){
	
		$_zone= new Zend_Dojo_Form_Element_TextBox('zone_name');
		$_zone->setAttribs(array('dojoType'=>$this->tvalidate,'required'=>'true','class'=>'fullside',));
// 		$_stu= new Zend_Dojo_Form_Element_TextBox('zone_student');
// 		$_stu->setAttribs(array('dojoType'=>$this->tvalidate,'required'=>'true','class'=>'fullside',));
		
		$_zone_number= new Zend_Dojo_Form_Element_TextBox('zone_number');
		$_zone_number->setAttribs(array('dojoType'=>$this->tvalidate,'required'=>'true','class'=>'fullside',));
		
		$_status=  new Zend_Dojo_Form_Element_FilteringSelect('status');
		$_status->setAttribs(array('dojoType'=>$this->filter,'class'=>'fullside',));
		$_status_opt = array(
				1=>$this->tr->translate("ACTIVE"),
				0=>$this->tr->translate("DACTIVE"));
		$_status->setMultiOptions($_status_opt);
		
		$_id = new Zend_Form_Element_Hidden('id');
		
		if(!empty($_data)){
			$_id->setValue($_data['zone_id']);
			$_zone->setValue($_data['zone_name']);
			$_zone_number->setValue($_data['zone_num']);
			$_status->setValue($_data['status']);
		}
		$this->addElements(array($_id,$_zone,$_status,$_id,$_zone_number));
		return $this;
		
	}
	
}