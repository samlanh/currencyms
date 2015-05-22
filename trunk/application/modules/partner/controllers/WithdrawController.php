<?php
class Partner_WithdrawController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/partner/withdraw';
	public function init()
	{
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}
	public function indexAction(){
			try{
				$db = new Partner_Model_DbTable_DbWithdraw();
				if ($this->getRequest ()->isPost ()) {
					$search = $this->getRequest ()->getPost ();
					//print_r($search);exit();
				} else {
					$search = array (
							'adv_search' => '',
							'status_search' => - 1
					);
				}
				
				$rows= $db->getAllwithdraw($search);
				$list = new Application_Form_Frmtable();
				$collumns = array("លេខដៃគូ","ថ្ងៃ","សម្គាល់","ប្រាក់ជាដុល្លា","ប្រាក់ជាបាត","ប្រាក់ជារៀល","ប្រាក់ជាដុល្លា(-)","ប្រាក់ជាបាត(-)","ប្រាក់ជារៀល(-)");
				$link=array(
						'module'=>'partner','controller'=>'withdraw','action'=>'edit',
				);
				$this->view->list=$list->getCheckList(0,$collumns,$rows,array('partner_id'=>$link,'date'=>$link,'note'=>$link));
			}catch (Exception $e){
				Application_Form_FrmMessage::message("Application Error");
				echo $e->getMessage();
				//Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
			}
			$pructis = new Partner_Form_FrmPartner ();
			$frm = $pructis->addPartner ();
			Application_Model_Decorator::removeAllDecorator ( $frm );
			$form = $this->view->frm_partner = $frm;
			$with_draw=new Partner_Form_FrmWithdraw();
			$frm = $with_draw->dakMoney();
			Application_Model_Decorator::removeAllDecorator($frm);
			$this->view->frm=$frm;
		}
	 public function addAction(){
	    if($this->getRequest()->isPost()){
	    	$data=$this->getRequest()->getPost();
	    	$db = new Partner_Model_DbTable_DbWithdraw();
	    	try {
	    		if($this->getRequest()->getPost("btn_save")){
		    		$db = $db->insertWithdraw($data);
		    		Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
	    		}
	    		if($this->getRequest()->getPost("btn_save_close")){
	    			$db = $db->insertWithdraw($data);
	    			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
	    		}
	    		} catch (Exception $e) {
	    		$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
	    	}
	    }
	    $pructis=new Partner_Form_FrmWithdraw();
	    $frm = $pructis->dakMoney();
	    Application_Model_Decorator::removeAllDecorator($frm);
	    $this->view->frm=$frm;
    }
   
	function editAction(){
   		 if($this->getRequest()->isPost()){
	    	$data=$this->getRequest()->getPost();
	    	$db_wihtdraw = new Partner_Model_DbTable_DbWithdraw();
	    	try {
	    		if($this->getRequest()->getPost("btn_save_close")){
	    			$db_wihtdraw->updatewithdraw($data);
	    			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
	    		}
	    		} catch (Exception $e) {
	    		$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
	    	}
	    }
	    $db_wihtdraw = new Partner_Model_DbTable_DbWithdraw();
	    $id = $this->getRequest()->getParam("id");
	   	$row = $db_wihtdraw->getpartnerById($id);
	   	if(empty($row)){
	   	}
	     	$this->view->id = $row['id'];
		   	$withdraw=new Partner_Form_FrmWithdraw();
		    $frm = $withdraw->dakMoney($row);
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