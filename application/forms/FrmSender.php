<?php

class Application_Form_FrmSender extends Zend_Dojo_Form
{

    public function frmSender($data)
    {
    	
		$sender=new Zend_Dojo_Form_Element_ValidationTextBox('sender_name');
		$sender->setAttribs(array(
				"required"=>true,
				"class"=>"fullside",
				"dojoType"=>"dijit.form.ValidationTextBox"
				));
			   
		$sender_tel=new Zend_Dojo_Form_Element_NumberTextBox('tel');
		$sender_tel->setAttribs(array(
				"class"=>"fullside",
				"dojoType"=>"dijit.form.ValidationTextBox",
		));
		
		$email=new Zend_Dojo_Form_Element_TextBox('email');
		$email->setAttribs(array(
				"class"=>"fullside",
				"dojoType"=>"dijit.form.TextBox"
		));
		
		$address=new Zend_Dojo_Form_Element_TextBox('address');
		$address->setAttribs(array(
				"class"=>"fullside",
				"dojoType"=>"dijit.form.TextBox"
		));
		
		$status=new Zend_Dojo_Form_Element_FilteringSelect('status');
		$status->setAttribs(array(
				"class"=>"fullside",
				"dojoType"=>"dijit.form.FilteringSelect",
				"required"=>true));
		$_opt = array(1=>"ប្រើប្រាស់",0=>"មិនប្រើប្រាស់");
		$status->setMultiOptions($_opt);
		
		
		$sender_id=new Zend_Form_Element_Hidden('id');
		if(!empty($data)){
			$sender_id->setValue($data['sender_id']);
			$sender->setValue($data['sender_name']);
			$sender_tel->setValue($data['tel']);
			$email->setValue($data['email']);
			$address->setValue($data['address']);
			$status->setValue($data['status']);
			//print_r($data);
			
		}
				 	 
		$this->addElements(array($sender,$sender_tel,$email,$address,$sender_id,$status));
		return $this;
    }


}

