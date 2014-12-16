<?php
class Transfer_IndexController extends Zend_Controller_Action
{

	const REDIRECT_URL = '/transfer';

	
    public function init()
    {
        /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');
    	
    	//clear all other sessions
    	Application_Form_FrmSessionManager::clearSessionSearch();
    }

    public function indexAction()
    {
        // action body	
        //Get Session User
       
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
    	$frm=new Transfer_Form_FrmIndex();
    	$from = $frm->addIndex();
    	Application_Model_Decorator::removeAllDecorator($from);
    	$this->view->frm=$from;
    
    
    }

}