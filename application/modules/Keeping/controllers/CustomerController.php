<?php


class Keeping_CustomerController extends Zend_Controller_Action {
	const REDIRECT_URL_ADD = '/Keeping/customer/add';
	const REDIRECT_URL = '/Keeping/customer/';
	const REDIRECT_URL_EDIT = '/Keeping/index/edit';
	private $activelist = array (
			'មិនប្រើ​ប្រាស់',
			'ប្រើ​ប្រាស់' 
	);
	public function init() {
		header ( 'content-type: text/html; charset=utf8' );
		defined ( 'BASE_URL' ) || define ( 'BASE_URL', Zend_Controller_Front::getInstance ()->getBaseUrl () );
		
		// clear all other sessions
		Application_Form_FrmSessionManager::clearSessionSearch ();
	}
	public function indexAction() {
		try {
			$db = new Partner_Model_DbTable_DbPartner ();
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				$search = array(
						'adv_search' => $formdata['adv_search'],
						'province_id'=>$formdata['province_name'],
						'comm_id'=>$formdata['commune'],
						'district_id'=>$formdata['district'],
						'village'=>$formdata['village'],
						'status'=>$formdata['status_search'],
						'main_branch'=>$formdata['main_branch'],
						'start_date'=>$formdata['start_date'],
						'end_date'=>$formdata['end_date']
				);
			} else {
				$search = array (
						'adv_search' => '',
						'status' => -1, 
						'province_id'=> -1,
						'district_id'=> '',
						'comm_id'=> '',
						'village'=> '',
						'main_branch'=> '',
						'start_date'=> date('Y-m-01'),
						'end_date'=>date('Y-m-d')
				);
				//print_r($search);exit();
			}
			$rs_rows = $db->getAllPartner ($search );
			// print_r($rs_rows);exit();
			
			$glClass = new Application_Model_GlobalClass ();
			$rs_rows = $glClass->getImgActive ( $rs_rows, BASE_URL, true, null );
			$list = new Application_Form_Frmtable ();
			$collumns = array (
					"ដៃគូមេ",
					"ឈ្មោះអ្នកគ្រប់គ្រង",
					"ឈ្មោះដៃគូរសហការណ៏",
					"លេខគណនេយ្យ",
					"លេខអត្តសញ្ញាណប័ណ្ណ",
					"ខេត្ត/ក្រុង",
					"លេខទូរស័ព្ទ ",
					"លេខទូរស័ព្ទដៃ",
					"​ប្រាក់រៀល",
					"ប្រាក់ដុល្លា",
					"ប្រាក់បាត",
					"ថ្ងៃ",
					"STATUS" 
			);
			$link = array (
					'module' => 'Keeping',
					'controller' => 'customer',
					'action' => 'edit' 
			);
			$this->view->list = $list->getCheckList ( 0, $collumns, $rs_rows, array (
					'main_branch'=>$link,
					'nation_id' => $link,
					'account_no' => $link,
					'partner_name' => $link,
					'partner_brand' => $link,
					'name' => $link,
					'address' => $link 
			) );
		} catch ( Exception $e ) {
			 Application_Form_FrmMessage::message("Application Error");
			 Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
		}
		$pructis = new Partner_Form_FrmPartner ();
		$frm = $pructis->addPartner ();
		Application_Model_Decorator::removeAllDecorator ( $frm );
		$form = $this->view->frm_partner = $frm;
		//echo $form;exit();
		
		$this->view->result=$search;
		
		$db= new Application_Model_DbTable_DbGlobal();
		$this->view->district = $db->getAllDistricts();
		$this->view->commune_name = $db->getCommune();
		$this->view->village_name = $db->getVillage();
		
		
	}
	public function addAction() {
		$db_partner = new Partner_Model_DbTable_DbPartner ();
		if ($this->getRequest ()->isPost ()) {
			$data = $this->getRequest ()->getPost();
			try {
				if($this->getRequest()->getParam("btn_save_close")){
					//print_r($data);exit();
					$db = $db_partner->insertPartner ( $data );
					Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ',self::REDIRECT_URL);
				}elseif($this->getRequest()->getParam("btn_save")){
					Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ',self::REDIRECT_URL_ADD);
					$db = $db_partner->insertPartner( $data );
					$this->view->msgs = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
				}
				 //Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ',
				// self::REDIRECT_URL);
			} catch ( Exception $e ) {
				// echo $e->getMessage();exit();
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
		$pructis = new Partner_Form_FrmPartner ();
		$frm = $pructis->addPartner ();
		Application_Model_Decorator::removeAllDecorator ( $frm );
		$form = $this->view->frm = $frm;
		
		$db= new Application_Model_DbTable_DbGlobal();
		$this->view->district = $db->getAllDistricts();
		$this->view->commune_name = $db->getCommune();
		$this->view->village_name = $db->getVillage();
	}
	public function viewAction() {
		// action body
		$ag_id = $this->getRequest ()->getParam ( 'ag_id' );
		
		$db_agent = new Application_Model_DbTable_DbAgents ();
		$this->view->agent_view = $db_agent->getAgentViewById ( $ag_id );
	}
	public function editAction() {
		
		if ($this->getRequest ()->isPost ()) {
			$data = $this->getRequest ()->getPost();
			$db_partner = new Partner_Model_DbTable_DbPartner ();
			try {
				if($this->getRequest()->getParam("btn_save_close")){
					//print_r($data);exit();
					$db = $db_partner->getupdatePartner ( $data );
					Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ','/Keeping/customer/');
				}
			} catch ( Exception $e ) {
				echo $e->getMessage();
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
		$db_partner = new Partner_Model_DbTable_DbPartner ();
		$id = $this->getRequest()->getParam ('id');
		$row = $db_partner->getPartnerById($id);
		$this->view->row= $row;
		$this->view->photo = $row['photo'];
		$pructis = new Partner_Form_FrmPartner ();
		$frm = $pructis->addPartner ($row);
		Application_Model_Decorator::removeAllDecorator ( $frm );
		$form = $this->view->frm = $frm;
		
		$db= new Application_Model_DbTable_DbGlobal();
		$this->view->district = $db->getAllDistricts();
		$this->view->commune_name = $db->getCommune();
		$this->view->village_name = $db->getVillage();
	
	}
	public function getDistrictFilterAction(){
		if($this->getRequest()->isPost()){
			$post=$this->getRequest()->getPost();
			$ids = $post["province_number"];
			$sql = "SELECT p.id,d.pro_id,d.district_name FROM cms_district AS d,cs_provinces AS p 
					WHERE d.pro_id = p.id AND d.pro_id = ".$ids;
			$db = new Application_Model_DbTable_DbGlobal();
			$row=$db->getGlobalDb($sql);
			echo Zend_Json::encode($row);
			exit();
		}
	}
	public function addfillterdistictAction(){
		if($this->getRequest()->isPost()){
			$id = $this->getRequest()->getParam("province_name");
			$db = new Partner_Model_DbTable_DbPartner();
			$opt = $db->getNameDistict($id);
			print_r(Zend_Json::encode($opt));
			exit();
		}
	}
}


?>



