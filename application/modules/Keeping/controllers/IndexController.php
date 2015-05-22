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
    	if($this->getRequest()->isPost()){
    		$data=$this->getRequest()->getPost();
    		$search= array (
    				'adv_search'=>$data['adv_search'],
    				'send_name_id'=>$data['send_name'],
    				'status_search'=>$data['status_search'],
    				'start_date'=>$data['start_date'],
    				'end_date'=>$data['end_date']
    				);
    		
    	}
    	else 
    	{
    		$search=array(
    				'status_search'=>-1,
    				'start_date'=>date('Y-m-01'),
    				'end_date'=>date('Y-m-d')
    				);
    	}
    try{
			$db = new Keeping_Model_DbTable_DbKeeping();
			$rs_rows= $db->getAllKeeping($search);//call frome model
			$arr = array();
			foreach($rs_rows as $index =>$rs){
				$arr[$index]=array(
						'id'=>$rs['id'],
						'invoice_number'=>$rs['invoice_number'],
						'client_name'=>$rs['client_name'],
						'date_keeping'=>$rs['date_keeping'],
						'amount_keeping'=>$rs['amount_keeping'].' '.$rs['name_en'],
						'exp_date'=>$rs['exp_date'],
						'amount_dollar'=>0,
						'amount_riel'=>0,
						'amount_bath'=>0,
						'status'=>$rs['status'],
				);
			
				$rs_detail = $db->getGroupKeepingdetail($rs['id']);
				foreach ($rs_detail as $key =>$r){
					if($r['currency_type']==3){
						$arr[$index]['amount_riel']=$r['amount'];
					}elseif($r['currency_type']==1){
						$arr[$index]['amount_dollar']=$r['amount'];
					}elseif($r['currency_type']==2){
						$arr[$index]['amount_bath']=$r['amount'];
					}
				}
			}
			
			
			$glClass = new Application_Model_GlobalClass();
			$arr = $glClass->getImgActive($arr, BASE_URL, true);
			$list = new Application_Form_Frmtable();
			$collumns = array("វិក័យប័ត្រ","ឈ្មោះ​អ្នក​ផ្ញើរ ","កាល​បរិច្ឆេទ ផ្ញើរ","រយះពេលផ្ញើរ ","ផុតកំណត់​ត្រឹម​ថ្ងៃ","ចំនួនប្រាក់ដុល្លា","ចំនួនប្រាក់រៀល","ចំនួនប្រាក់បាត","status");
			$link=array(
					'module'=>'Keeping','controller'=>'index','action'=>'edit',
			);
			$this->view->list=$list->getCheckList(0, $collumns,$arr,array('client_name'=>$link,'date_keeping'=>$link,'invoice_numer'=>$link));
		}catch (Exception $e){
			Application_Form_FrmMessage::message("Application Error");
			echo $e->getMessage();
			Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
			 
		}
        $sendmoney=new Keeping_Form_FrmSendMoney();
    	//$db= new Keeping_Model_DbTable_DbKeeping();
    	$frm = $sendmoney->addSendMoney();
    	//echo $frm;exit();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    	
    }
    function addAction(){
    //insert table cms_keeping
    	if($this->getRequest()->isPost()){
    					$data=$this->getRequest()->getPost();
//     					print_r($data);exit();
    					$db_keeping = new Keeping_Model_DbTable_DbKeeping();
    					try {
    						if($this->getRequest()->getParam("btn_save")){
    						$db = $db_keeping->insertKeeping($data);
    						Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
    						}
    					} catch (Exception $e) {
    						echo $e->getMessage();exit();
    						$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    					}
    					$this->_redirect("Keeping/index/index");
    				}	
    				
   //form
    	$sendmoney=new Keeping_Form_FrmSendMoney();
    	$db= new Keeping_Model_DbTable_DbKeeping();
    	$frm = $sendmoney->addSendMoney();
    	//echo $frm;exit();
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







