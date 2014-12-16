<?php

class Resterand_Form_Frmresterand extends Zend_Dojo_Form
{

    public function addResterand()
    {
        /* Form Elements & Other Definitions Here ... */

    	$producid=new Zend_Dojo_Form_Element_NumberTextBox('producid');
    	$producid->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'
    			));
    	
    	
    	$produc_name=new Zend_Dojo_Form_Element_TextBox('produc_name');
    	$produc_name->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'
    	));
    	
    	
    	$oders=new Zend_Dojo_Form_Element_TextBox('oders');
    	$oders->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'
    	));
    	
    	
    	$qtys=new Zend_Dojo_Form_Element_TextBox('qtys');
    	$qtys->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'
    	));
    	
    	$prices=new Zend_Dojo_Form_Element_TextBox('prices');
    	$prices->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox'
    	));
    	
    	
    	$totals=new Zend_Dojo_Form_Element_NumberTextBox('totals');
    	$totals->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox'
    	));
    	
		$this->addElements(array($producid,$produc_name,$oders,$qtys,$prices,$totals));
		
		return $this;
    }


}

