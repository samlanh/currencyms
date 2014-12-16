<?php
class Other_DistrictController extends Zend_Controller_Action {
	public function init()
	{
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}
	public function indexAction(){
		try{
			$db = new Other_Model_DbTable_DbDistrict();
			if($this->getRequest()->isPost()){
				$search=$this->getRequest()->getPost();
			}
			else{
				$search = array(
						'adv_search' => '',
						'status' => -1);
			}
			$rs_rows= $db->getAllDistrict($search);
			$glClass = new Application_Model_GlobalClass();
			$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true,null,1);
			$list = new Application_Form_Frmtable();
			$collumns = array("District KH","District ENG","Display By","Province","Date","Status","By");
			$link=array(
					'module'=>'other','controller'=>'District','action'=>'edit',
			);
			$this->view->list=$list->getCheckList(0, $collumns, $rs_rows,array('district_name'=>$link,'district_namekh'=>$link));
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
				$db_district = new Other_Model_DbTable_DbDistrict();
				$db_district->addDistrict($_data);
				Application_Form_FrmMessage::Sucessfull("ការ​បញ្ចូល​ជោគ​ជ័យ !",'/other/District');
			}catch(Exception $e){
				Application_Form_FrmMessage::message("ការ​បញ្ចូល​មិន​ជោគ​ជ័យ");
				$err =$e->getMessage();
				Application_Model_DbTable_DbUserLog::writeMessageError($err);
			}
		}
		$fm = new Other_Form_FrmDistrict();
		$frm = $fm->FrmAddDistrict();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm_district = $frm;
	}
	public function editAction(){
		$db_district = new Other_Model_DbTable_DbDistrict();
		if($this->getRequest()->isPost()){
			$_data = $this->getRequest()->getPost();
			try{
				$db_district->addDistrict($_data);
				Application_Form_FrmMessage::Sucessfull("ការកែប្រែ​ជោគ​ជ័យ !",'/other/District');
			}catch(Exception $e){
				Application_Form_FrmMessage::message("ការកែប្រែ​​មិន​ជោគ​ជ័យ");
				$err =$e->getMessage();
				Application_Model_DbTable_DbUserLog::writeMessageError($err);
			}
		}
		$id = $this->getRequest()->getParam("id");
		$row = $db_district->getDistrictById($id);
		if(empty($row)){
			$this->_redirect('other/District');
		}
		$fm = new Other_Form_FrmDistrict();
		$frm = $fm->FrmAddDistrict($row);
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm_district = $frm;
	}
	public function addNewdistrictAction(){
		if($this->getRequest()->isPost()){
			$data = $this->getRequest()->getPost();
			$data['status']=1;
			$data['district_name']=$data['pop_district_name'];
			$db_district = new Other_Model_DbTable_DbDistrict();
			$id = $db_district->addDistrict($data);
			print_r(Zend_Json::encode($id));
			exit();
		}
	}
}
