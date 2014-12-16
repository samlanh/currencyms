<?php

class Partner_Form_FrmWithdraw extends Zend_Dojo_Form
{

    public function dakMoney()
    {
        /* Form Elements & Other Definitions Here ... */
    	$nuber_account=new Zend_Dojo_Form_Element_NumberTextBox('nuber_account');
    	$nuber_account->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	$phong=new Zend_Dojo_Form_Element_NumberTextBox('phong');
    	$phong->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	$note=new Zend_Dojo_Form_Element_TextBox('note');
    	$note->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside'));
    	
    	$namesend=new Zend_Dojo_Form_Element_TextBox('namesend');
    	$namesend->setAttribs(array(
    			'dojoType'=>'dijit.form.TextBox',
    			'class'=>'fullside'));
    	
    	$daydokmoney=new Zend_Dojo_Form_Element_DateTextBox('daydokmoney');
    	$daydokmoney->setAttribs(array(
    			'dojoType'=>'dijit.form.DateTextBox',
    			'class'=>'fullside'));
    	$daydokmoney->setValue(date('y-m-d'));
    	
    	
    	$dola=new Zend_Dojo_Form_Element_NumberTextBox('dola');
    	$dola->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$dola1=new Zend_Dojo_Form_Element_NumberTextBox('dola1');
    	$dola1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	
    	$bath=new Zend_Dojo_Form_Element_NumberTextBox('bath');
    	$bath->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$bath1=new Zend_Dojo_Form_Element_NumberTextBox('bath1');
    	$bath1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$real=new Zend_Dojo_Form_Element_NumberTextBox('real');
    	$real->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	$real1=new Zend_Dojo_Form_Element_NumberTextBox('real1');
    	$real1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	
    	$dola1=new Zend_Dojo_Form_Element_NumberTextBox('$dola1');
    	$dola1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
//         $typecash1=array(1=>"ដុល្លា",2=>"បាត",3=>"រៀល");
//         $typecash->setMultiOptions($typecash1);
       
    	$d1=new Zend_Dojo_Form_Element_NumberTextBox('d1');
    	$d1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$d2=new Zend_Dojo_Form_Element_NumberTextBox('d2');
    	$d2->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$d3=new Zend_Dojo_Form_Element_NumberTextBox('d3');
    	$d3->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	$b1=new Zend_Dojo_Form_Element_NumberTextBox('b1');
    	$b1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$b2=new Zend_Dojo_Form_Element_NumberTextBox('b2');
    	$b2->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$b3=new Zend_Dojo_Form_Element_NumberTextBox('b3');
    	$b3->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	 
    	
    	$r1=new Zend_Dojo_Form_Element_NumberTextBox('r1');
    	$r1->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	
    	$r2=new Zend_Dojo_Form_Element_NumberTextBox('r2');
    	$r2->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	$r3=new Zend_Dojo_Form_Element_NumberTextBox('r3');
    	$r3->setAttribs(array(
    			'dojoType'=>'dijit.form.NumberTextBox',
    			'class'=>'fullside'));
    	 
    	
    	
    	$this->addElements(array($nuber_account,$namesend,$daydokmoney,
    			$dola,$dola1,$bath,$bath1,$real,$real1,$phong,$note,$d1,
    			$d2,$d3,$b1,$r1,$b2,$b3,$r2,$r3));
		return $this;
    }


}

