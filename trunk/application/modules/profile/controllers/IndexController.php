<?php

class Profile_IndexController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/profile';
	
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

    	$key = new Application_Model_DbTable_DbKeycode();
    	$data=$key->getKeyCode();
    	$this->view->data= $data;
    	
     	if($this->getRequest()->isPost()){
     		$post=$this->getRequest()->getPost();
     		
     		try {
     			$db = $key->updateKeyCode($post, $data);
     			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
     		} catch (Exception $e) {
     			$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
     		}
     	}
    	
    	//with xml file
    // action body
    	/*$company_info = new Zend_Config_Xml(APPLICATION_PATH.'/configs/Config.xml');

    	$this->view->company_info = $company_info;
    	
    	$xml = simplexml_load_file(APPLICATION_PATH.'/configs/Config.xml');
    	//transforming the object in xml format
    	$xmlFormat = $xml->asXML();
    	if($this->getRequest()->isPost()){
    		$company_data=$this->getRequest()->getPost();
    		try {
    			//loop to get data update to xml file
    			foreach ($company_data as $key => $val){
    				$xml->$key = $val;
    			}
		    	$xml->saveXML(APPLICATION_PATH.'/configs/Config.xml');
    			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
    		} catch (Exception $e) {
    			$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    	}*/
    }

}







