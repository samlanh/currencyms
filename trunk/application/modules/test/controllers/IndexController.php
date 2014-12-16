<?php

class Test_IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
	
	}
	
	public function addAction()
	{
	
	
		//     	if($this->getRequest()->isPost()){
		// 			$agentdata=$this->getRequest()->getPost();
		// 			$db_agent = new Application_Model_DbTable_DbAgents();
		// 			try {
		// 				$db = $db_agent->insertAgent($agentdata);
		// 				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
		// 			} catch (Exception $e) {
		// 				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
		// 			}
		// 		}
		$pructis=new Test_Form_FrmTest();
		$frm = $pructis->addTest();
		Application_Model_Decorator::removeAllDecorator($frm);
		$this->view->frm=$frm;
	}
	
	
	
	
	public function viewAction()
	{
		// action body
		$ag_id = $this->getRequest()->getParam('ag_id');
	
		$db_agent = new Application_Model_DbTable_DbAgents();
		$this->view->agent_view = $db_agent->getAgentViewById($ag_id);
	}
	
	public function editedAction()
	{
		// action body
		$ag_id = $this->getRequest()->getParam('ag_id');
		$ag_id = (empty($ag_id))? 0 : $ag_id;
		 
		$pro = new Application_Model_DbTable_DbProvinces();
		$this->view->provinces = $pro->getProvinceListAll();
	
		$db_agent = new Application_Model_DbTable_DbAgents();
		$this->view->agent_edit = $db_agent->getAgentEditedById($ag_id);
	
		if($this->getRequest()->isPost()){
			$agentdata=$this->getRequest()->getPost();
				
			try {
				$db = $db_agent->updateAgent($agentdata);
				Application_Form_FrmMessage::Sucessfull('ការ​បញ្ចូល​​ជោគ​ជ័យ', self::REDIRECT_URL);
			} catch (Exception $e) {
				$this->view->msg = 'ការ​បញ្ចូល​មិន​ជោគ​ជ័យ';
			}
		}
	}
	

}







