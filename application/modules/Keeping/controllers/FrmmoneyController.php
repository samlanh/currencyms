<?php

class Keeping_FrmmoneyController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/agent';
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	
    public function init()
    {
        /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	
    	//clear all other sessions
    	Application_Form_FrmSessionManager::clearSessionSearch();
    }

    public function indexAction()
    {
        // action body
	   
    }

    public function addAction()
    {
    	$pructis=new Keeping_Form_FrmMoney();
    	$frm = $pructis->addMoney();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    }
    public function putAction()
    {
    	$pructis=new Keeping_Form_FrmMoney();
    	$frm = $pructis->addMoney();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    }
  
   
    

   

}







