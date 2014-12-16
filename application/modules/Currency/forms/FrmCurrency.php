<?php

class Currency_Form_FrmCurrency extends Zend_Dojo_Form
{

    public function addCurrency()
    {
        /* Form Elements & Other Definitions Here ... */
    	
    	$id=new Zend_Dojo_Form_Element_TextBox('ids');
    	$id->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$search=new Zend_Dojo_Form_Element_TextBox('searchs');
    	$search->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	$add=new Zend_Dojo_Form_Element_TextBox('adds');
    	$add->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$exit=new Zend_Dojo_Form_Element_TextBox('exits');
    	$exit->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	
    	
    	
    	$start=new Zend_Dojo_Form_Element_TextBox('starts');
    	$start->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    	
    	$stop=new Zend_Dojo_Form_Element_TextBox('stops');
    	$stop->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'));
    	
    
    	
		$this->addElements(array($id,$search,$add,$exit,$start,$stop));
		return $this;
    }


}

