<?php
class Partner_WithdrawController extends Zend_Controller_Action
{
	public function init()
	{
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}
	public function indexAction(){
			try{
				$db = new Partner_Model_DbTable_DbWithdraw();
				$rows= $db->getAllwithdraw($search=null);
				$list = new Application_Form_Frmtable();
				$collumns = array("លេខដៃគូ","ថ្ងៃ","សម្គាល់","ប្រាក់ជាដុល្លា","ប្រាក់ជាបាត","ប្រាក់ជារៀល","ប្រាក់ជាដុល្លា","ប្រាក់ជាបាត","ប្រាក់ជារៀល");
				$link=array(
						'module'=>'partner','controller'=>'withdraw','action'=>'edit',
				);
				$this->view->list=$list->getCheckList(0,$collumns,$rows,array('partner_id'=>$link,'date'=>$link,'note'=>$link));
			}catch (Exception $e){
				Application_Form_FrmMessage::message("Application Error");
				echo $e->getMessage();
				//Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
			}
			}
	 public function addAction()
	    {
	    	    	if($this->getRequest()->isPost()){
	    				$data=$this->getRequest()->getPost();
	    				$db = new Partner_Model_DbTable_DbWithdraw();
	    				try {
	    					$db = $db->insertWithdraw($data);
	    					//Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
	    				} catch (Exception $e) {
	    					$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
	    				}
	    			}
	    	$pructis=new Partner_Form_FrmWithdraw();
	    	$frm = $pructis->dakMoney();
	    	Application_Model_Decorator::removeAllDecorator($frm);
	    	$this->view->frm=$frm;
    }
    function viewAction(){
    }
function editAction(){
   	$db_wihtdraw = new Partner_Model_DbTable_DbWithdraw();
   	if($this->getRequest()->isPost()){
   		$_data = $this->getRequest()->getPost();
   		try{
   			$db_wihtdraw->updatepartner($_data);
   			Application_Form_FrmMessage::Sucessfull("ការ​បញ្ចូល​ជោគ​ជ័យ !",'/partner/withdraw');
   		}catch(Exception $e){
   			Application_Form_FrmMessage::message("ការ​បញ្ចូល​មិន​ជោគ​ជ័យ");
   			$err =$e->getMessage();
   			Application_Model_DbTable_DbUserLog::writeMessageError($err);
   		}
   	}
   	$id = $this->getRequest()->getParam("id");
   	$row = $db_wihtdraw->getpartnerById($id);
   	if(empty($row)){
//    		$this->_redirect('partner/withdraw');
   	}
     	$this->view->id = $row['id'];
	   	$withdraw=new Partner_Form_FrmWithdraw();
	    $frm = $withdraw->dakMoney($row);
	    Application_Model_Decorator::removeAllDecorator($frm);
	    $this->view->frm=$frm;
	    
// 	    $this->view->salary_detail = $db_wihtdraw->getReceiptDetailById($id);
// 	    $this->view->salary_option = $db_wihtdraw->getTypeOption();
   }
}