<?php
class Partner_DepositeController extends Zend_Controller_Action
{
	public function init()
	{
		header('content-type: text/html; charset=utf8');
		defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
	}
	public function indexAction(){
		try{
			$db = new Partner_Model_DbTable_DbDeposite();
			$rows= $db->getAllDeposite($search=null);
			$arr = array();
			foreach($rows as $index =>$rs){
				$arr[$index]=array(
						'id'=>$rs['id'],
						'invoice'=>$rs['invoice'],
						'partner_name'=>$rs['partner_name'],
						'date'=>$rs['date'],
						'note'=>$rs['note'],
 						'amount_dollar'=>0,
 						'amount_riel'=>0,
 						'amount_bath'=>0,
						);
				$rs_detail = $db->getGroupDepositeDetail($rs['id']);
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
			
// 				
			
			$list = new Application_Form_Frmtable();
			$collumns = array("លេខវិកាប័ត្ត","លេខដៃគូ","ថ្ងៃ","សម្គាល់","ចំនួនប្រាក់ដុល្លា","ចំនួនប្រាក់រៀល","ចំនួនប្រាក់បាត");
			
			$link=array(
					'module'=>'partner','controller'=>'deposite','action'=>'edit',
			);
			$this->view->list=$list->getCheckList(0,$collumns,$arr,array('partner_id'=>$link,'invoice'=>$link,'date'=>$link,'note'=>$link));
		}catch (Exception $e){
			Application_Form_FrmMessage::message("Application Error");
			echo $e->getMessage();
			//Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
		}
	}
	function viewAction(){
	}
	function editAction()
	{
		if($this->getRequest()->isPost()){
				$data=$this->getRequest()->getPost();
	    			$db = new Partner_Model_DbTable_DbDeposite();
	    			//print_r($data);
	    			try {
	    					$db = $db->updateDeposite($data);
	    					//Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ','/partner/deposite');
	    				} catch (Exception $e) {
	    					echo $e->getMessage();
	    					exit();
	    					$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
	    				}
	    			}
	   $db_deposite=new Partner_Model_DbTable_DbDeposite();
	   $id = $this->getRequest()->getParam("id");
		$row = $db_deposite->getpartnerById($id);
		$deposite=new Partner_Form_FrmDeposite();
		$frm = $deposite->partnerinformation($row);
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm=$frm;
		$db = new Application_Model_DbTable_DbGlobal();
		$this->view->currency_type = $db->CurruncyTypeOption();
		
		$this->view->rs_rows = $db_deposite->getdepositedetail($id);
	}
 	public function addAction()
	    {
			if($this->getRequest()->isPost()){
				$data=$this->getRequest()->getPost();
	    			$db = new Partner_Model_DbTable_DbDeposite();
	    			try {
	    					$db = $db->partnerDeposite($data);
	    					Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ','/partner/deposite');
	    				} catch (Exception $e) {
	    					echo $e->getMessage();
	    					exit();
	    					$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
	    				}
	    			}
	    	$pructis=new Partner_Form_FrmDeposite();
	    	$frm = $pructis->partnerinformation();
	    	Application_Model_Decorator::removeAllDecorator($frm);
	    	$this->view->frm=$frm;
	    	$db = new Application_Model_DbTable_DbGlobal();
	    	$this->view->currency_type = $db->CurruncyTypeOption();
    }
	public function getfillterdepositeAction(){
	if($this->getRequest()->isPost()){
			$post=$this->getRequest()->getPost();
			$ids = $post["partner"];
			$sql = "SELECT account_no,`cash_dollar`,`cash_bath`,cash_riel FROM cms_partner WHERE id=".$ids;
			$db = new Application_Model_DbTable_DbGlobal();
			$row=$db->getGlobalDbRow($sql);
			print_r(Zend_Json::encode($row));
			exit();
		}
	}
}
?>