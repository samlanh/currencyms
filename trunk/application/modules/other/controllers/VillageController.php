<?php
class Other_VillageController extends Zend_Controller_Action {
	public function init()
	{
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}
	public function indexAction(){
		try{
			$db = new Other_Model_DbTable_DbVillage();
			if($this->getRequest()->isPost()){
				$search=$this->getRequest()->getPost();
			}
			else{
				$search = array(
						'adv_search' => '',
						'status' => -1);
			}
			$rs_rows= $db->getAllVillage($search);
			$glClass = new Application_Model_GlobalClass();
			$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true,null,1);
			$list = new Application_Form_Frmtable();
			$collumns = array("Villagename Kh","Village Name","Display By","Commenu Name","Date","Status","By");
			$link=array(
					'module'=>'other','controller'=>'Village','action'=>'edit',
			);
			$this->view->list=$list->getCheckList(0, $collumns, $rs_rows,array('village_name'=>$link,'commune_name'=>$link));
		}catch (Exception $e){
			Application_Form_FrmMessage::message("Application Error");
			echo $e->getMessage();
			Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
		}
		$frm = new Application_Form_FrmAdvanceSearch();
		$frm = $frm->AdvanceSearch();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm_search = $frm;
	}
	public function addAction(){
		if($this->getRequest()->isPost()){
			$db = new Other_Model_DbTable_DbVillage();
			$_data = $this->getRequest()->getPost();
			try{
				$db->addVillage($_data);
				Application_Form_FrmMessage::Sucessfull("ការ​បញ្ចូល​ជោគ​ជ័យ !",'/other/Village/add ');
			}catch(Exception $e){
				$err = $e->getMessage();
				Application_Form_FrmMessage::message("ការ​បញ្ចូល​មិន​ជោគ​ជ័យ");
				Application_Model_DbTable_DbUserLog::writeMessageError($err);
			}
		}
		$fm = new Other_Form_FrmVillage();
		$frm = $fm->FrmAddVillage();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm_village = $frm;
		
		$db= new Application_Model_DbTable_DbGlobal();
		$this->view->district = $db->getAllDistricts();
		$this->view->commune_name = $db->getCommune();
	}
	public function editAction(){
		$db = new Other_Model_DbTable_DbVillage();
		if($this->getRequest()->isPost()){
			$_data = $this->getRequest()->getPost();
			try{
				$db->addVillage($_data);
				Application_Form_FrmMessage::Sucessfull("ការ​បញ្ចូល​ជោគ​ជ័យ !",'/other/Village');
			}catch(Exception $e){
				Application_Form_FrmMessage::message("ការ​បញ្ចូល​មិន​ជោគ​ជ័យ");
				$err =$e->getMessage();
				Application_Model_DbTable_DbUserLog::writeMessageError($err);
			}
		}
		$id = $this->getRequest()->getParam("id");
		$row = $db->getVillageById($id);
		$this->view->row=$row;
		if(empty($row)){
			$this->_redirect('other/Village');
		}		
		$fm = new Other_Form_FrmVillage();
		$frm = $fm->FrmAddVillage($row);
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm_village = $frm;
		
		$db= new Application_Model_DbTable_DbGlobal();
		$this->view->district = $db->getAllDistricts();
		$this->view->commune_name = $db->getCommune();
		
	}
	public function addNewvillageAction(){
		if($this->getRequest()->isPost()){
			$data = $this->getRequest()->getPost();
			$data['status']=1;
			$data['commune_name']=$data['popup_commune_name'];
			$db_vill = new Other_Model_DbTable_DbVillage();
			$id = $db_vill->addVillage($data);
			print_r(Zend_Json::encode($id));
			exit();
		}
	}
}
