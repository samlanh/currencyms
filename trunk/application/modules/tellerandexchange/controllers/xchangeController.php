<?php

class Tellerandexchange_XchangeController extends Zend_Controller_Action
{
	const REDIRECT_URL='/tellerandexchange/xchange';
	public function init()
	{
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL') || define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}
	public function indexAction(){
		
	}
	public function addAction()
	{
		    	if($this->getRequest()->isPost()){
					$data=$this->getRequest()->getPost();
// 					print_r($data);exit();
					$db = new Tellerandexchange_Model_DbTable_Dbexchange();
					try {
						$db = $db->addXchange($data);
						Application_Form_FrmMessage::Sucessfull('', self::REDIRECT_URL);
					} catch (Exception $e) {
						Application_Form_FrmMessage::message("INSERT_FAIL");
						$err = $e->getMessage();
						Application_Model_DbTable_DbUserLog::writeMessageError($err);
					}
				}
		$pructis=new Tellerandexchange_Form_Frmxchange();
		$frm = $pructis->xchange();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm=$frm;
		$db = new Application_Model_DbTable_DbGlobal();
	    $this->view->currency_type = $db->CurruncyTypeOption();
	
// 		$db = new Application_Model_DbTable_DbGlobal();
// 		$this->view->currency_type = $db->CurruncyTypeOption();
	}
 	public function checkRateAction(){
    	$db_rate=new Application_Model_DbTable_DbRate();
    	echo $db_rate->getCurrentRateJson();
    	exit();
    }

}