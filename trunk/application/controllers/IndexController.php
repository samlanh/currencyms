<?php

class IndexController extends Zend_Controller_Action
{

	const REDIRECT_URL = '/transfer';
	
    public function init()
    {
        /* Initialize action controller here */
    	header('content-type: text/html; charset=utf8');  
    	
    }

    public function indexAction()
    {
        // action body
    	
    	
        /* set this to login page to change the character charset of browsers to Utf-8  ...*/    	  	
		
    	$this->_helper->layout()->disableLayout();
		$form=new Application_Form_FrmLogin();				
		$form->setAction('index');		
		$form->setMethod('post');
		$form->setAttrib('accept-charset', 'utf-8');
		$this->view->form=$form;
		$key = new Application_Model_DbTable_DbKeycode();
		$this->view->data=$key->getKeyCodeMiniInv(TRUE);
			
		$session_user=new Zend_Session_Namespace('auth');
		//redirect page if web broswer still have session
		if(!empty($session_user->arr_module)){
			foreach ($session_user->arr_module AS $i => $d){
				if($d !== 'transfer'){
					$url = '/' . $session_user->arr_module[0];
				}
				else{
					$url = self::REDIRECT_URL;
					break;
				}
			}
			
			Application_Form_FrmMessage::redirectUrl($url);	
			exit();	
		}
		
		if($this->getRequest()->isPost())		
		{
			$formdata=$this->getRequest()->getPost();				
			if($form->isValid($formdata))
			{
				
				$db_user=new Application_Model_DbTable_DbUsers();
				$user_name=$form->getValue('txt_user_name');
				$password=$form->getValue('txt_password');
				if($db_user->userAuthenticate($user_name,$password)){	
					
					$db_access=new Application_Model_DbTable_DbAmountPC();
					$pc_name = strtolower(gethostname());
					$amount_pc = $db_access->pcAccess($pc_name, 4);// Validate number of user login,params 4 amount of pc limit login
					if($amount_pc==true){//for check user access of using system
						
						$user_id=$db_user->getUserID($user_name);
						$user_info = $db_user->getUserInfo($user_id);
						
						$arr_acl=$db_user->getArrAcl($user_info['user_type']);
						
						$session_user->user_id=$user_id;
						$session_user->user_name=$user_name;
						$session_user->pwd=$password;		
						$session_user->level= $user_info['user_type'];
						$session_user->last_name= $user_info['last_name'];
						$session_user->first_name= $user_info['first_name'];
						
						$a_i = 0;
						$arr_actin = array();					
						for($i=0; $i<count($arr_acl);$i++){
							$arr_module[$i]=$arr_acl[$i]['module'];
							if($arr_acl[$i]['module'] == 'exchange'){
								if($arr_acl[$i]['action'] == "index" || $arr_acl[$i]['action'] == "add" || $arr_acl[$i]['action'] == "edited" ) {
									continue;
								}
								$arr_actin[$a_i++] = $arr_acl[$i]['action'];
							}
						}					
						
						$arr_module=$this->sortMenu($arr_module);
						
						$session_user->arr_acl = $arr_acl;
						$session_user->arr_module = $arr_module;
						$session_user->arr_actin = $arr_actin;
							
						$session_user->lock();
						
						$log=new Application_Model_DbTable_DbUserLog();
						$log->insertLogin($user_id);					
						
						// Check expired date of transactions.
	// 					$db_mt = new Application_Model_DbTable_DbMoneyTransactions();
	// 					$db_mt->checkExpired();
						
						
						foreach ($arr_module AS $i => $d){
							if($d !== 'transfer'){
								$url = '/' . $arr_module[0];
							}
							else{
								$url = self::REDIRECT_URL;
								break;
							}
						}
						
						Application_Form_FrmMessage::redirectUrl($url);	
						exit();	
						
					}else{//if over amount of PC​
						$this->view->msg = 'ការប្រើប្រាស់លើសចំនួនកំណត់!';
					}										
				}
				else{					
					$this->view->msg = 'ឈ្មោះ​អ្នក​ប្រើ​ប្រាស់ និង ពាក្យ​​សំងាត់ មិន​ត្រឺម​ត្រូវ​ទេ';
				}
					
			}
			else{				
				$this->view->msg = 'សូម​ទំនាក់​ទំនង​ជាមួយ​នឹង​ អ្នក​គ្រប់​គ្រងរបស់អ្នក​អំពី​បញ្ហានេះ';
			}	 							
		}
				
    }
    
    protected function sortMenu($menus){
    	$menus_order = Array ( 'rsvAcl','user','subagent','agent','sender','transfer','payment','exchange','kbank','loan','capital','backup','reports');
//     	$menus_order = Array ( 'rsvAcl','user','subagent','agent','transfer','reports');
    	$temp_menu = Array();
    	$menus=array_unique($menus);
    	foreach ($menus_order as $i => $val){
    		foreach ($menus as $k => $v){
    			if($val == $v){
    				$temp_menu[] = $val;
    				unset($menus[$k]);
    				break;
    			}
    		}
    	}
    	return $temp_menu;    	
    }

    public function logoutAction()
    {
        // action body
        if($this->getRequest()->getParam('value')==1){
			
        	$db_access=new Application_Model_DbTable_DbAmountPC();
        	$pc_name = strtolower(gethostname());
        	$db_access->clearUserLogined($pc_name);

        	$aut=Zend_Auth::getInstance();
        	$aut->clearIdentity();        	
        	$session_user=new Zend_Session_Namespace('auth');
        	
        	$log=new Application_Model_DbTable_DbUserLog();
			$log->insertLogout($session_user->user_id);
			
        	$session_user->unsetAll();       	
	           	         	 
        	Application_Form_FrmMessage::redirectUrl("/");
        	exit();
        } 
    }

    public function changepasswordAction()
    {
        // action body
        if ($this->getRequest()->isPost()){ 
			$session_user=new Zend_Session_Namespace('auth');    		
    		$pass_data=$this->getRequest()->getPost();
    		if ($pass_data['password'] == $session_user->pwd){
    			    			 
				$db_user = new Application_Model_DbTable_DbUsers();				
				try {
					$db_user->changePassword($pass_data['new_password'], $session_user->user_id);
					$session_user->unlock();	
					$session_user->pwd=$pass_data['new_password'];
					$session_user->lock();
					Application_Form_FrmMessage::Sucessfull('ពាក្យ​សំងាត់​នា​ពេល​បច្ចុប្បន្ន ​កែប្រែ ជោគ​ជ័យ', self::REDIRECT_URL);
				} catch (Exception $e) {
					Application_Form_FrmMessage::message('ពាក្យ​សំងាត់​នា​ពេល​បច្ចុប្បន្ន ​កែប្រែ មិន ជោគ​ជ័យ');
				}				
    		}
    		else{
    			Application_Form_FrmMessage::message('ពាក្យ​សំងាត់​នា​ពេល​បច្ចុប្បន្ន ​មិន​ត្រឹម​ត្រូវ');
    		}
        }   
    }

    public function errorAction()
    {
        // action body
        
    }


}





