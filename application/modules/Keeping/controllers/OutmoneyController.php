<?php 
class Keeping_OutmoneyController extends Zend_Controller_Action
{
	const REDIRECT_URL_ADD = '/Keeping/outmoney/add';
	const REDIRECT_URL_EXIT = '/Keeping/outmoney';
	private $activelist = array('មិនប្រើ​ប្រាស់', 'ប្រើ​ប្រាស់');
	
	public function init()
	{
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}
	function indexAction(){
		try{
			$db = new Keeping_Model_DbTable_DbOutmoney();
			if ($this->getRequest ()->isPost ()) {
				$search = $this->getRequest ()->getPost ();
				//print_r($search);exit();
			} else {
				$search = array (
						'adv_search' => '',
						'status_search' => - 1
				);
			}
		
			$rows= $db->getAllwithdrawKeeping($search);
			$list = new Application_Form_Frmtable();
			$collumns = array("លេខដៃគូ","ថ្ងៃ","សម្គាល់","ទូរស័ព្ទអតិថិជន","ប្រាក់ជាដុល្លា","ប្រាក់ជាបាត","ប្រាក់ជារៀល","ប្រាក់ជាដុល្លា(-)","ប្រាក់ជាបាត(-)","ប្រាក់ជារៀល(-)");
			$link=array(
					'module'=>'Keeping','controller'=>'outmoney','action'=>'edit',
			);
			$this->view->list=$list->getCheckList(0,$collumns,$rows,array('phone'=>$link,'create_date'=>$link,'note'=>$link));
		}catch (Exception $e){
			Application_Form_FrmMessage::message("Application Error");
			echo $e->getMessage();
			Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
		}
		$pructis = new Keeping_Form_FrmOutMoney ();
		$frm = $pructis->dokMoney ();
		Application_Model_Decorator::removeAllDecorator ( $frm );
		$form = $this->view->frm_partner = $frm;
		
	}
	function addAction(){
		if($this->getRequest()->isPost()){
			$data=$this->getRequest()->getPost();
			//print_r($data);exit();
			$db = new Keeping_Model_DbTable_DbOutmoney();
			try {
				if($this->getRequest()->getPost("btn_save")){
					$db = $db->insertWithdrawKeeping($data);
					Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ',self::REDIRECT_URL_ADD);
				}
				if($this->getRequest()->getPost("btn_save_close")){
					//print_r($data);exit();
					$db = $db->insertWithdrawKeeping($data);
					Application_Form_FrmMessage::message('ការ​បញ្ចូល​​ជោគ​ជ័យ');
					Application_Form_FrmMessage::redirector(self::REDIRECT_URL_EXIT);
				}
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
		$pructis=new Keeping_Form_FrmOutMoney();
		$frm = $pructis->dokMoney();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm=$frm;
	}
    function editAction(){
    	if($this->getRequest()->isPost()){
    		$data=$this->getRequest()->getPost();
    		$db_wihtdraw = new Keeping_Model_DbTable_DbOutmoney();
    		try {
    			if($this->getRequest()->getPost("btn_save_close")){
    				$db_wihtdraw->updateWithdrawKeeping($data);
    				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL_EXIT);
    			}
    		} catch (Exception $e) {
    			$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
    		}
    	}
    	$db_wihtdraw = new Keeping_Model_DbTable_DbOutmoney();
    	$id = $this->getRequest()->getParam("id");
//     	echo $id;exit();
    	$row = $db_wihtdraw->getWithdrawKeepingById($id);
    	if(empty($row)){
    	}
    	$this->view->id = $row['id'];
    	$withdraw_keeping=new Keeping_Form_FrmOutMoney();
    	$frm = $withdraw_keeping->dokMoney($row);
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm=$frm;
    }

    public function getfillterAction(){
    	if($this->getRequest()->isPost()){
    		$data = $this->getRequest()->getPost();
    		$id = $data["namesend"];
    		$db = new Partner_Model_DbTable_DbWithdraw();
    		$opt = $db->getNameFillterParent($id);
    		print_r(Zend_Json::encode($opt));
    		exit();
    	}
    }
	
	
}
?>





