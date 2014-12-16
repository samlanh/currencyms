<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	function _initViewHelpers(){
		// Config view Zend_Dojo
		$view = new Zend_View();
	    $view->addHelperPath('Zend/Dojo/View/Helper/', 'Zend_Dojo_View_Helper');	
	    $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();	
	    $viewRenderer->setView($view);	
	    Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);    	      	
		// End Config view Zend_Dojo
		
	}
	
	//init Auth Plugin	
	protected function _initAuthPlugin()
	{		
		date_default_timezone_set("Asia/Bangkok");
// 		Zend_Controller_Front::getInstance()->registerPlugin(
// 		new Application_Model_CustomAuth(Zend_Auth::getInstance()));				
	}

}

