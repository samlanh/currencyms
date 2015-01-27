<?php

class Keeping_IndexController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/Keeping/index/add';
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	
    public function init()
    {
        /* Initialize action controller here */
//     	header('content-type: text/html; charset=utf8');
    	header('content-type: text/html; charset=utf8');
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
    	//clear all other sessions
    	Application_Form_FrmSessionManager::clearSessionSearch();
    }

    public function indexAction()
    {
    try{
			$db = new Keeping_Model_DbTable_DbKeeping();
			$rs_rows= $db->getAllKeeping();//call frome model
// 			$glClass = new Application_Model_GlobalClass();
// 			$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
			$list = new Application_Form_Frmtable();
			$collumns = array("ឈ្មោះ​អ្នក​ផ្ញើរ "," 	រយះពេលគិតជា ","កាល​បរិច្ឆេទ ផ្ញើរ","រយះពេលផ្ញើរ(សប្តាហ៏)","ផុតកំណត់​ត្រឹម​ថ្ងៃ","វិក័យប័ត្រ","Status");
			$link=array(
					'module'=>'Keeping','controller'=>'index','action'=>'edit',
			);
			$this->view->list=$list->getCheckList(0, $collumns,$rs_rows,array('client_name'=>$link,'date_keeping'=>$link,'invoice_numer'=>$link));
		}catch (Exception $e){
			Application_Form_FrmMessage::message("Application Error");
			echo $e->getMessage();
			Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
			 
		}
    	
    	
    }
    function addAction(){
    //insert table cms_keeping
    	if($this->getRequest()->isPost()){
    					$data=$this->getRequest()->getPost();
//     					print_r($data);exit();
    					$db_keeping = new Keeping_Model_DbTable_DbKeeping();
    					try {
    						$db = $db_keeping->insertKeeping($data);
    						Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
    					} catch (Exception $e) {
    						echo $e->getMessage();exit();
    						$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    					}
    					$this->_redirect("Keeping/index/index");
    				}	
    				
   //form
    	$sendmoney=new Capital_Form_FrmCapitale();
    	$db= new Keeping_Model_DbTable_DbKeeping();
    	$frm = $sendmoney->addSendMoney();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    	$this->view->currency_type = $db->CurruncyTypeOption();
    }
    function editAction(){
    	$id = $this->getRequest()->getParam("id");
    	$db = new Keeping_Model_DbTable_DbKeeping();
    	$row  = $db->getKeepingbyid($id);
    	
    	$fm = new Keeping_Form_FrmSendMoney();
    	$frm = $fm->addSendMoney($row);
       
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm_putmoney= $frm;
    	$this->view->currency_type = $db->CurruncyTypeOption();
    	
    	$db_keeping = new Keeping_Model_DbTable_DbKeeping();
    	$this->view->rs_rows = $db_keeping->getKeepingdetail($id);
    	
    	if($this->getRequest()->isPost()){
    		$data=$this->getRequest()->getPost();
    	 //   print_r($data);exit();
    		$db_keeping = new Keeping_Model_DbTable_DbKeeping();
    		try {
    			$db = $db_keeping->updateKeeping($data);
    			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
    		} catch (Exception $e) {
    			echo $e->getMessage();exit();
    			$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    		$this->_redirect("Keeping/index/index");
    	}
    }
}







