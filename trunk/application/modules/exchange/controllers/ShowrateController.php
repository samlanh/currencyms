<?php

class Exchange_ShowrateController extends Zend_Controller_Action
{

	const REDIRECT_URL = '/exchange';
	
    public function init()
    {
        /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	
    	//clear all other sessions
    	Application_Form_FrmSessionManager::clearSessionSearch();
    	
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
    }

    function indexAction()
    {
       
    }
    function addAction() {
     $this->_redirect("/exchange/showrate");
    }   
   

    
}











