<?php
 
class Accounting_ExpenseController extends Zend_Controller_Action
{
	const REDIRECT_URL = '/accounting/expense';
	
    public function init()
    {
        /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	defined('BASE_URL')	|| define('BASE_URL', Zend_Controller_Front::getInstance()->getBaseUrl());
    }

    public function indexAction()
    {
    	try{
    		$db = new Accounting_Model_DbTable_DbExpense();
    		if($this->getRequest()->isPost()){
    			$search=$this->getRequest()->getPost();
    		}
    		else{
    			$search = array(
    					'adv_search' => '',
    					'status_search' => -1);
    		}
			$rs_rows= $db->getAllExpense($search);//call frome model
    		$glClass = new Application_Model_GlobalClass();
    		$rs_rows = $glClass->getImgActive($rs_rows, BASE_URL, true,1);
    		$list = new Application_Form_Frmtable();
    		$collumns = array("Account Name","Total Amount","Currency type","For Date","Note","Date","Status");
    		$link=array(
    				'module'=>'accounting','controller'=>'expense','action'=>'edit',
    		);
    		$this->view->list=$list->getCheckList(0, $collumns,$rs_rows,array('account_name'=>$link,'total_amount'=>$link));
    	}catch (Exception $e){
    		Application_Form_FrmMessage::message("Application Error");
    		echo $e->getMessage();
    		Application_Model_DbTable_DbUserLog::writeMessageError($e->getMessage());
    	}
    	$pructis=new Accounting_Form_Frmexpense();
    	$frm = $pructis->FrmAddExpense();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm_expense=$frm;
    }

 //djalv odigja oslfc kfsdalfij doflkdslkffkmaslcds fkds fklfasdj fldsa fadij fodslflsd jflsdf lsdj foal
    
    public function addAction()
    {
    	if($this->getRequest()->isPost()){
			$agentdata=$this->getRequest()->getPost();
			//print_r($agentdata);exit();
			$db_agent = new Accounting_Model_DbTable_DbExpense();				
			try {
				
				$db = $db_agent->addexpense($agentdata);
				if($this->getRequest()->getPost("save_close")){					
					Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
				}
				if($this->getRequest()->getPost("save")){
					Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ');
				}
				if($this->getRequest()->getPost("cancel")){
					Application_Form_FrmMessage::Sucessfull('', self::REDIRECT_URL);
				}
						
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
    	$pructis=new Accounting_Form_Frmexpense();
    	$frm = $pructis->FrmAddExpense();
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm_expense=$frm;
    }
   
    public function viewAction()
    {
        // action body
        $ag_id = $this->getRequest()->getParam('ag_id');
		
		$db_agent = new Application_Model_DbTable_DbAgents();
		$this->view->agent_view = $db_agent->getAgentViewById($ag_id);
    }
     
    
 
    public function editAction()
    {
        // action body
    	if($this->getRequest()->isPost()){
			$agentdata=$this->getRequest()->getPost();	
			$db_agent = new Accounting_Model_DbTable_DbExpense();				
			try {
				$db = $db_agent->updatexpense($agentdata);				
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);		
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
		$id = $this->getRequest()->getParam('id');
		//print_r($id);exit();
// 		if(empty($id)){
// 			Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
// 		}
		$db = new Accounting_Model_DbTable_DbExpense();
		$row  = $db->getexpensebyid($id);
    	$pructis=new Accounting_Form_Frmexpense();
    	$frm = $pructis->FrmAddExpense($row);
    	Application_Model_Decorator::removeAllDecorator($frm);
    	$this->view->frm_expense=$frm;
		
    	
    }


}







