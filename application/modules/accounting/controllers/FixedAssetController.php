<?php
class accounting_FixedAssetController extends Zend_Controller_Action {
	const REDIRECT_URL = '/accounting/asset';
	public function init()
	{
		/* Initialize action controller here */
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}
	public function addAction(){
		
		if($this->getRequest()->isPost()){
			$data=$this->getRequest()->getPost();
			$db = new Accounting_Model_DbTable_DbAsset();
			try {
				$db->addasset($data);
				Application_Form_FrmMessage::message('ការ​បញ្ចូល​​ជោគ​ជ័យ');
			} catch (Exception $e) {
				Application_Form_FrmMessage::message("INSERT_FAIL");
				$err = $e->getMessage();
				Application_Model_DbTable_DbUserLog::writeMessageError($err);
			}
		}
		$fm = new Accounting_Form_Frmasset();
		$frm = $fm->FrmAsset();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm_fixedasset = $frm;
	}
	
	
// 	public function indexAction(){
// 		if($this->getRequest()->isPost()){
// 			$db = new Group_Model_DbTable_DbClient();
// 			$data = $this->getRequest()->getPost();
// 			$_data['status']=1;
// 			$id = $db->addClient($data);
// 			print_r(Zend_Json::encode($id));
// 			exit();
// 		}
// 	}
	
	public function indexAction()
	{
		try{
			$db = new Accounting_Model_DbTable_DbAsset();
			//     		if($this->getRequest()->isPost()){
			//     			$search=$this->getRequest()->getPost();
			//     		}
			//     		else{
			//     			$search = array(
			//     					'adv_search' => '',
			//     					'status' => -1);
			//     		}
			$rs_rows= $db->getAllAsset($search=null);//call frome model
			$glClass = new Application_Model_GlobalClass();
			$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
			$list = new Application_Form_Frmtable();
			$collumns = array("Branch_id ","Fixed_Assetname ","Fixed_Asset_Type","Asset_Cost","Usefull_Life","Salvagevalue","Payment_method","Status","Note");
			$link=array(
					'module'=>'accounting','controller'=>'FixedAsset','action'=>'edit',
			);
			$this->view->list=$list->getCheckList(0, $collumns,$rs_rows,array('fixed_assetname'=>$link,'fixed_asset_type'=>$link,'asset_cost'=>$link));
		}catch (Exception $e){
			Application_Form_FrmMessage::message("Application Error");
			echo $e->getMessage();
			Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
		}
	}
		public function editAction()
		{
		if($this->getRequest()->isPost()){
			$data=$this->getRequest()->getPost();
			$db = new Accounting_Model_DbTable_DbAsset();
			try {
				$db->updatasset($data);
				Application_Form_FrmMessage::message('ការ​បញ្ចូល​​ជោគ​ជ័យ');
			} catch (Exception $e) {
				Application_Form_FrmMessage::message("INSERT_FAIL");
				$err = $e->getMessage();
				Application_Model_DbTable_DbUserLog::writeMessageError($err);
			
			}
			}
			$id = $this->getRequest()->getParam('id');
			// 		if(empty($id)){
			// 			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
			// 		}
			$db = new Accounting_Model_DbTable_DbAsset();
			$row  = $db->getassetbyid($id);
			$pructis=new Accounting_Form_Frmasset();
			$frm = $pructis->FrmAsset($row);
			Application_Model_Decorator::removeAllDecorator($frm);
			$this->view->frm_fixedasset=$frm;
			
		
	}
}
