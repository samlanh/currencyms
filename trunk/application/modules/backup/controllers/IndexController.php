<?php

class Backup_IndexController extends Zend_Controller_Action
{
	function indexAction(){
		
	}
	function addAction(){
		$key = new Application_Model_DbTable_DbKeycode();
		$data=$key->getKeyCode();
		$this->view->data= $data;
	}
	function backupAction(){
		Application_Form_FrmMessage::Sucessfull('ទិន្នន័យត្រូវបានរក្សាទុកដោយជោគជ័យ ! សូមស្វែងរកនៅក្នុង Folder Public/backup','/transfer');
	}
	function pdfAction(){
// 		$fr=new Application_Form_FrmReportParameter();
// 		$form=$fr->getFormReport(array(
// 				'budget'=>-1,
// 				'division'=>-1,
// 				'fund_type'=>-1,
// 				'year'=>-1,
// 				'wa_type'=>-1,
// 				'fund_no'=>-1,
// 		),$this,true);
// 		$this->view->filter = $form;
		
		$file='/budget/budget.html';
// 		$head=$report->getHeadBudgetList('project',date('Y'));
// 		$content=$report->getContent($report->getContentBudgetList('project',$filter,date('Y')));
		$param=array(
				'division'=>1,
				'budget'=>1,
				'head'=>1,
				'content'=>1,
		);
		$db=new Application_Model_DbTable_DbGlobal();
		$new=$db->setReportParam($param, $file);
		$this->view->file=$new;
	}
	public function restoreAction(){
		if($this->getRequest()->isPost()){
			$data = $this->getRequest()->getPost();
			$db = new Application_Model_DbTable_Dbrestore();
			$rs =  $db->UploadFileDatabase($data);
			if($rs){
				Application_Form_FrmMessage::Sucessfull('ទិន្នន័យ​  Restore ដោយជោគជ័យ !','/transfer');
			}
			
		}		
	}
	public function iconAction(){
		
	}
}







