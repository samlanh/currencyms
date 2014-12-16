<?php

class NewTest_Form_FrmNewtes extends Zend_Dojo_Form
{

    public function addTest()
    {
        /* Form Elements & Other Definitions Here ... */
    	
    	
    	
    	$IdS=new Zend_Dojo_Form_Element_TextBox('IdS');
    	$IdS->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$Student_names=new Zend_Dojo_Form_Element_TextBox('Student_names');
    	$Student_names->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$Date_of_births=new Zend_Dojo_Form_Element_TextBox('Date_of_births');
    	$Date_of_births->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$Sexs=new Zend_Dojo_Form_Element_TextBox('Sexs');
    	$Sexs->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$phones=new Zend_Dojo_Form_Element_TextBox('phones');
    	$phones->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$titles=new Zend_Dojo_Form_Element_TextBox('titles');
    	$titles->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	
    	
		$this->addElements(array($IdS,$Student_names,$Date_of_births,$Sexs,$phones,$titles));
		return $this;
    }


}

