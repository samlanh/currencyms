<?php
class Other_CommuneController extends Zend_Controller_Action {
	public function init()
	{
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}
	public function indexAction(){
		try{
			$db = new Other_Model_DbTable_DbCommune();
			if($this->getRequest()->isPost()){
				$search=$this->getRequest()->getPost();
			}
			else{
				$search = array(
						'adv_search' => '',
						'status' => -1);
			}
			$rs_rows= $db->getAllCommune($search);
			$glClass = new Application_Model_GlobalClass();
			$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true);
			$list = new Application_Form_Frmtable();
			$collumns = array("CommuneName Kh","CommuneName En","District Name","Date","Status","By");
			$link=array(
					'module'=>'other','controller'=>'Commune','action'=>'edit',
			);
			$this->view->list=$list->getCheckList(0, $collumns, $rs_rows,array('commune_namekh'=>$link,'district_name'=>$link,'commune_name'=>$link));
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
			$_data = $this->getRequest()->getPost();
			try{
				$db_district = new Other_Model_DbTable_DbCommune();
				$db_district->addCommune($_data);
				Application_Form_FrmMessage::Sucessfull("ការ​បញ្ចូល​ជោគ​ជ័យ !",'/other/Commune/add');
			}catch(Exception $e){
				Application_Form_FrmMessage::message("ការ​បញ្ចូល​មិន​ជោគ​ជ័យ");
				$err =$e->getMessage();
				Application_Model_DbTable_DbUserLog::writeMessageError($err);
			}
		}
		$fm = new Other_Form_FrmCommune();
		$frm = $fm->FrmAddCommune();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm_commune = $frm;
	 $db= new Application_Model_DbTable_DbGlobal();
	 $this->view->district = $db->getAllDistricts();	
	
	}
	public function editAction(){
		$db = new Other_Model_DbTable_DbCommune();
		if($this->getRequest()->isPost()){
			$_data = $this->getRequest()->getPost();
			try{
				$db->addCommune($_data);
				Application_Form_FrmMessage::Sucessfull("ការ​បញ្ចូល​ជោគ​ជ័យ !",'/other/Commune/add');
			}catch(Exception $e){
				Application_Form_FrmMessage::message("ការ​បញ្ចូល​មិន​ជោគ​ជ័យ");
				$err =$e->getMessage();
				Application_Model_DbTable_DbUserLog::writeMessageError($err);
			}
		}
		$id = $this->getRequest()->getParam('id');
		$row = $db->getCommuneById($id);
		$this->view->row=$row;
		$fm = new Other_Form_FrmCommune();
		$frm = $fm->FrmAddCommune($row);
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm_commune = $frm;
		
		$db= new Application_Model_DbTable_DbGlobal();
		$this->view->district = $db->getAllDistricts();
	}
	public function addNewcommuneAction(){
		if($this->getRequest()->isPost()){
			$data = $this->getRequest()->getPost();
			$data['status']=1;
			$db_com = new Other_Model_DbTable_DbCommune();
			$id = $db_com->addCommune($data);
			print_r(Zend_Json::encode($id));
			exit();
		}
	}
}
