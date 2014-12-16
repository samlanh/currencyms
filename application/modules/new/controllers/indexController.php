<?php
class Group_indexController extends Zend_Controller_Action {
	
	public function init()
	{
		/* Initialize action controller here */
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}
	private $sex=array(1=>'M',2=>'F');
	public function indexAction(){
		try{
			$db = new Group_Model_DbTable_DbClient();
			if($this->getRequest()->isPost()){
				$search=$this->getRequest()->getPost();
			}
			else{
				$search = array(
						'adv_search' => '',
						'status' => -1);
			}
			$rs_rows= $db->getAllClients($search);
			$result = array();
			foreach ($rs_rows as $key =>$rs){
				$result[$key]=array(
						'client_id'=>$rs['client_id'],
						'client_number'=>$rs['client_number'],
						'name_kh'=>$rs['name_kh'],
						'name_en'=>$rs['name_en'],
						'sex'=>$this->sex[$rs['sex']],
						'phone'=>$rs['phone'],
						'house'=>$rs['house'],
						'street'=>$rs['street'],
						'village_name'=>$rs['village_name'],
						'spouse_name'=>$rs['spouse_name'],
						'user_name'=>$rs['user_name'],
						'status'=>$rs['status'],
				);
			}
			$glClass = new Application_Model_GlobalClass();
			$rs_rows = $glClass->getImgActive($result, BASE_URL, true);
			$list = new Application_Form_Frmtable();
			$collumns = array("Client N.","Name Khmer","Name Eng","Sex","Phone","House","Street","Village","Spouse Name",
					"By","status");
			$link=array(
					'module'=>'group','controller'=>'index','action'=>'edit',
			);
			$this->view->list=$list->getCheckList(0, $collumns, $rs_rows,array('client_number'=>$link,'name_kh'=>$link,'name_en'=>$link));
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
			try{
				$data = $this->getRequest()->getPost();
				$db = new Group_Model_DbTable_DbClient();
				$db->addClient($data);
				Application_Form_FrmMessage::message("ការ​បញ្ចូល​ជោគ​ជ័យ !");
			}catch (Exception $e){
				echo $e->getMessage();exit();
				Application_Form_FrmMessage::message("Application Error");
				echo $e->getMessage();
				Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
			}
		}
		$fm = new Group_Form_FrmClient();
		$frm = $fm->FrmAddClient();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm_client = $frm;
	}
	public function editAction(){
		$db = new Group_Model_DbTable_DbClient();
		if($this->getRequest()->isPost()){
			try{
				$data = $this->getRequest()->getPost();
				$db->addClient($data);
				Application_Form_FrmMessage::Sucessfull("ការកែប្រែដោយ​ជោគ​ជ័យ !","/group/Client");
			}catch (Exception $e){
				echo $e->getMessage();exit();
				Application_Form_FrmMessage::message("Application Error");
				echo $e->getMessage();
				Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
			}
		}
		$id = $this->getRequest()->getParam("id");
		$row = $db->getClientById($id);
		if(empty($row)){
			$this->_redirect("/group/Client");
		}
		$fm = new Group_Form_FrmClient();
		$frm = $fm->FrmAddClient($row);
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm_client = $frm;
	}
	public function addNewclientAction(){//ajax
		if($this->getRequest()->isPost()){
			$db = new Group_Model_DbTable_DbClient();
			$data = $this->getRequest()->getPost();
			$_data['status']=1;
			$id = $db->addClient($data);
			print_r(Zend_Json::encode($id));
			exit();
		}
	}
	function getgroupcodeAction(){
		if($this->getRequest()->isPost()){
			$db = new Group_Model_DbTable_DbClient();
			$data = $this->getRequest()->getPost();
			$code = $db->getGroupCode($data);
			print_r(Zend_Json::encode($code));
			exit();
		}
	}
}

