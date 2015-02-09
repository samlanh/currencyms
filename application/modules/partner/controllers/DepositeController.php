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
			$collumns = array("áž›áŸ�áž�ážœáž·áž€áž¶áž”áŸ�áž�áŸ’áž�","áž›áŸ�áž�ážŠáŸƒáž‚áž¼","áž�áŸ’áž„áŸƒ","ážŸáž˜áŸ’áž‚áž¶áž›áŸ‹","áž…áŸ†áž“áž½áž“áž”áŸ’ážšáž¶áž€áŸ‹ážŠáž»áž›áŸ’áž›áž¶","áž…áŸ†áž“áž½áž“áž”áŸ’ážšáž¶áž€áŸ‹ážšáŸ€áž›","áž…áŸ†áž“áž½áž“áž”áŸ’ážšáž¶áž€áŸ‹áž”áž¶áž�");
			
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
	function editAction(){
		$db_deposite = new Partner_Model_DbTable_DbDeposite();
		if($this->getRequest()->isPost()){
			$_data = $this->getRequest()->getPost();
			try{
				$db_deposite->updateDeposite($_data);
				Application_Form_FrmMessage::Sucessfull("áž€áž¶ážšâ€‹áž”áž‰áŸ’áž…áž¼áž›â€‹áž‡áŸ„áž‚â€‹áž‡áŸ�áž™ !",'/partner/deposite');
			}catch(Exception $e){
				Application_Form_FrmMessage::message("áž€áž¶ážšâ€‹áž”áž‰áŸ’áž…áž¼áž›â€‹áž˜áž·áž“â€‹áž‡áŸ„áž‚â€‹áž‡áŸ�áž™");
				$err =$e->getMessage();
				Application_Model_DbTable_DbUserLog::writeMessageError($err);
			}
		}
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
	    					//Application_Form_FrmMessage::Sucessfull('áž€áž¶ážšâ€‹áž”áž‰áŸ’áž…áž¼áž›â€‹â€‹áž‡áŸ„áž‚â€‹áž‡áŸ�áž™', self::REDIRECT_URL);
	    				} catch (Exception $e) {
	    					echo $e->getMessage();
	    					exit();
	    					$this->view->msg = 'áž€áž¶ážšâ€‹áž”áž‰áŸ’áž…áž¼áž›â€‹áž˜áž·áž“â€‹áž‡áŸ„áž‚â€‹áž‡áŸ�áž™';
	    				}
	    			}
	    	$pructis=new Partner_Form_FrmDeposite();
	    	$frm = $pructis->partnerinformation();
	    	Application_Model_Decorator::removeAllDecorator($frm);
	    	$this->view->frm=$frm;
	    	$db = new Application_Model_DbTable_DbGlobal();
	    	$this->view->currency_type = $db->CurruncyTypeOption();
    }
}
?>