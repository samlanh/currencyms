<?php

class Reports_IndexController extends Zend_Controller_Action {
	
	private $statuslist = array ('ផ្ញើរ', 'ផ្ញើររួច', 'ទទួល', 'បើក​រួច', 'មោឃៈ', 'ផុត​កំណត់' );
	
	private $loanlist = array ('មិនជំពាក់', 'ជំពាក់' );
	private $money_type_khmerletter = array (1 => 'ដុល្លា', 2 => 'បាត', 3 => 'រៀល' );
	private $money_type = array (1 => '$', 2 => 'B', 3 => 'R' );
	private $tran_type = array (1 => 'ប្រើប្រាស់ដើមទុន', 2 => 'វេរប្រាក់', 3 => 'ប្តូរប្រាក់', 4 => 'KBANk', 5 => 'កម្ចី', 6 => 'សងប្រាក់', 7 => 'ដកប្រាក់(KBANK)', 8 => 'debt remain' )

	;
	
	const REDIRECT_URL = '/capital';
	private $curr_type = array ('1' => 'ដុល្លា', '2' => 'បាត', '3' => 'រៀល' );
	private $curr_typesimble = array ('1' => '$', '2' => 'B', '3' => 'R' );
	
	public function init() {
		/*
		 * Initialize action controller here
		 */
		header ( 'content-type: text/html; charset=utf8' );
		
		// clear all other sessions
		Application_Form_FrmSessionManager::clearSessionSearch ();
	}
	
	public function addAction() {
		// Get Session User
		try {
			$db_tran = new Application_Model_DbTable_DbMoneyTransactions ();
			
			$this->view->from_date = date ( 'Y-m-d' );
			$this->view->to_date = date ( 'Y-m-d' );
			
			$this->view->status = - 1;
			$this->view->statuslist = $this->statuslist;
			
			$cur = new Application_Model_DbTable_DbCurrencies ();
			$this->view->currencylist = $cur->getCurrencyList ();
			$this->view->type_money = - 1;
			
			$this->view->loan = - 1;
			$this->view->loanlist = $this->loanlist;
			
			/*
			 * $pro = new Application_Model_DbTable_DbProvinces();
			 * $this->view->provincelist = $pro->getProvinceList();
			 * $this->view->province = -1;
			 */
			
			$agent = new Application_Model_DbTable_DbAgents ();
			$this->view->agentlist = $agent->getAgentListSelect ();
			$this->view->agent = - 1;
			
			$this->view->sender_list = $agent->getSenderList ();
			$this->view->sender = - 1; // /
			
			$user = new Application_Model_DbTable_DbUsers ();
			$this->view->userlist = $user->getUserListSelect ();
			$this->view->user_id = - 1;
			
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				
				$this->view->user_id = $formdata ['user_id'];
				$this->view->status = $formdata ['status'];
				$this->view->type_money = $formdata ['type_money'];
				$this->view->agent = $formdata ['agent'];
				$this->view->sender = $formdata ['sender'];
				$this->view->loan = $formdata ['status_loan'];
				$this->view->from_date = $formdata ['from_date'];
				$this->view->to_date = $formdata ['to_date'];
				
				// print_r($formdata); exit();
				$trans = $db_tran->getTransactionReport ( $formdata );
			} else {
				$formdata = array ('user_id' => - 1, 'status' => - 1, 'status_loan' => - 1, 'sender' => "", 'agent' => - 1, 'from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ), 'type_money' => - 1 );
				$trans = $db_tran->getTransactionReport ( $formdata );
			}
			
			if (empty ( $trans )) {
				$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			
			$this->view->tranlist = $trans;
		
		} catch ( Exception $e ) {
		}
	}
	
	public function indexAction() {
		// Get Session User
	}
	
	public function rpttotalAction() {
		// Get Session User
		try {
			$db_tran = new Application_Model_DbTable_DbMoneyTransactions ();
			
			$this->view->from_date = date ( 'Y-m-d' );
			$this->view->to_date = date ( 'Y-m-d' );
			
			$this->view->status = - 1;
			$this->view->statuslist = $this->statuslist;
			
			$cur = new Application_Model_DbTable_DbCurrencies ();
			$this->view->currencylist = $cur->getCurrencyList ();
			$this->view->type_money = - 1;
			
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->keycode = $db_keycode->getKeyCodeMiniInv ();
			
			$this->view->loan = - 1;
			$this->view->loanlist = $this->loanlist;
			
			/*
			 * $pro = new Application_Model_DbTable_DbProvinces();
			 * $this->view->provincelist = $pro->getProvinceList();
			 * $this->view->province = -1;
			 */
			
			$agent = new Application_Model_DbTable_DbAgents ();
			$this->view->agentlist = $agent->getAgentListSelect ();
			$this->view->agent = - 1;
			
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				
				$this->view->status = $formdata ['status'];
				$this->view->type_money = $formdata ['type_money'];
				$this->view->agent = $formdata ['agent'];
				/*
				 * $this->view->province = $formdata['province'];
				 */
				$this->view->loan = $formdata ['status_loan'];
				$this->view->from_date = $formdata ['from_date'];
				$this->view->to_date = $formdata ['to_date'];
				
				$trans = $db_tran->getTransactionReportTotal ( $formdata );
			} else {
				$formdata = array ('status' => - 1, 'status_loan' => - 1,
						        	/*'province'=>-1,*/
						        	'agent' => - 1, 'from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ), 'type_money' => - 1 );
				$trans = $db_tran->getTransactionReportTotal ( $formdata );
			}
			// $balancesheet =
			// $db_tran->getBalanceForAgents($formdata['from_date']);
			if (empty ( $trans )) {
				$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			
			$this->view->tranlist = $trans;
			// $this->view->balancesheet = $balancesheet;
		
		} catch ( Exception $e ) {
		}
	}
	
	public function rpttotalonlyAction() {
		// Get Session User
		try {
			$db_tran = new Application_Model_DbTable_DbMoneyTransactions ();
			
			$this->view->from_date = date ( 'Y-m-d' );
			$this->view->to_date = date ( 'Y-m-d' );
			
			$this->view->status = - 1;
			$this->view->statuslist = $this->statuslist;
			
			$cur = new Application_Model_DbTable_DbCurrencies ();
			$this->view->currencylist = $cur->getCurrencyList ();
			$this->view->type_money = - 1;
			
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->keycode = $db_keycode->getKeyCodeMiniInv ();
			
			$this->view->loan = - 1;
			$this->view->loanlist = $this->loanlist;
			
			/*
			 * $pro = new Application_Model_DbTable_DbProvinces();
			 * $this->view->provincelist = $pro->getProvinceList();
			 * $this->view->province = -1;
			 */
			
			$agent = new Application_Model_DbTable_DbAgents ();
			$this->view->agentlist = $agent->getAgentListSelect ();
			$this->view->agent = - 1;
			
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				
				$this->view->status = $formdata ['status'];
				$this->view->type_money = $formdata ['type_money'];
				$this->view->agent = $formdata ['agent'];
				/*
				 * $this->view->province = $formdata['province'];
				 */
				$this->view->loan = $formdata ['status_loan'];
				$this->view->from_date = $formdata ['from_date'];
				$this->view->to_date = $formdata ['to_date'];
				
				// $trans= $db_tran->getTransactionReportTotalOnly($formdata);
				$trans = $db_tran->getTransactionReportTotal ( $formdata );
			} else {
				$formdata = array ('status' => - 1, 'status_loan' => - 1,
    					/*'province'=>-1,*/
    					'agent' => - 1, 'from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ), 'type_money' => - 1 );
				// $trans= $db_tran->getTransactionReportTotalOnly($formdata);
				$trans = $db_tran->getTransactionReportTotal ( $formdata );
			}
			if (empty ( $trans )) {
				$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			} else {
				$tmp = array (array (0, 0, 0 ), array (0, 0, 0 ) );
				foreach ( $trans as $i => $t ) {
					$tmp [$t ['tran_type']] [$t ['cus_id'] - 1] += $t ['transfer_money'] + $t ['commission_agent'];
				}
				$trans = $tmp;
			}
			
			$this->view->tranlist = $trans;
		
		} catch ( Exception $e ) {
		}
	}
	
	public function rptincomeAction() {
		// Get Session User
		try {
			$db_tran = new Application_Model_DbTable_DbMoneyTransactions ();
			
			$this->view->from_date = date ( 'Y-m-d' );
			$this->view->to_date = date ( 'Y-m-d' );
			
			$this->view->status = - 1;
			$this->view->statuslist = $this->statuslist;
			
			$cur = new Application_Model_DbTable_DbCurrencies ();
			$this->view->currencylist = $cur->getCurrencyList ();
			$this->view->type_money = - 1;
			
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->keycode = $db_keycode->getKeyCodeMiniInv ();
			
			$this->view->loan = - 1;
			$this->view->loanlist = $this->loanlist;
			
			$agent = new Application_Model_DbTable_DbAgents ();
			$this->view->agentlist = $agent->getAgentListSelect ();
			$this->view->agent = - 1;
			
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				
				$this->view->status = $formdata ['status'];
				$this->view->type_money = $formdata ['type_money'];
				$this->view->agent = $formdata ['agent'];
				$this->view->loan = $formdata ['status_loan'];
				$this->view->from_date = $formdata ['from_date'];
				$this->view->to_date = $formdata ['to_date'];
				
				$trans = $db_tran->getTransactionReportIncome ( $formdata );
			} else {
				$formdata = array ('status' => - 1, 'status_loan' => - 1, 'agent' => - 1, 'from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ), 'type_money' => - 1 );
				$trans = $db_tran->getTransactionReportIncome ( $formdata );
			}
			if (empty ( $trans )) {
				$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			
			$this->view->tranlist = $trans;
		
		} catch ( Exception $e ) {
		}
	}
	
	public function rptautoprintAction() {
		// action body
		try {
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->mainbranch = $db_keycode->getMainBranch ();
			
			$db_tran = new Application_Model_DbTable_DbMoneyTransactions ();
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				
				if (count ( $formdata ) > 0) {
					$db_tran->setTransactionReportAutoPrint ( $formdata );
					Application_Form_FrmMessage::redirectUrl ( '/reports/index/rptautoprint' );
					exit ();
				}
			}
			
			$trans = $db_tran->getTransactionReportAutoPrint ();
			
			if (empty ( $trans )) {
				$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			
			$this->view->tranlist = $trans;
		
		} catch ( Exception $e ) {
			$this->view->msg = "ការ​ផ្លាស់​ប្តូរ​មិន​​ជោគ​ជ័យ";
		}
	}
	
	public function rpttobranchAction() {
		// action body
		try {
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->mainbranch = $db_keycode->getMainBranch ();
			
			$db_tran = new Application_Model_DbTable_DbMoneyTransactions ();
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				if (count ( $formdata ) > 0) {
					$db_tran->updateStatusAfterPrint ( $formdata ); // after date by
					                                             // agent_id
					Application_Form_FrmMessage::redirectUrl ( '/reports/index/rpttobranch' );
					exit ();
				}
			}
			
			$trans = $db_tran->getTransactionToBranch ();
			
			if (empty ( $trans )) {
				$rs = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			} 

			else {
				$rs = array ();
				$key = 0;
				// $indextran=0;
				
				// for store money type
				$r = array ();
				$d = array ();
				$b = array ();
				// store comission
				$cmr = array ();
				$cmd = array ();
				$cmb = array ();
				$agent_id = "";
				foreach ( $trans as $index => $value ) {
					$rs [$key] = $this->addNewRecord ( $key, $value );
					$trans_money = $db_tran->getTransByTel ( $value ['reciever_tel'], $value ['agent_id'], $value ['subagent_id'] ); // for
					                                                                                                          // get
					                                                                                                          // money
					                                                                                                          // of
					                                                                                                          // receiver
					if (! empty ( $trans_money ))
						;
					$rindex = 0;
					$dindex = 0;
					$bindex = 0; // reset new index if other
					                               // receiver;
					foreach ( $trans_money as $i => $money ) {
						// $get_tranid[$indextran] =
						// $money["tran_id"];$indextran++;
						if ($money ["money_type"] == 1) { // if money type = 1 add to array
						                             // dollar
							$d [$dindex] = $money ['transfer_money'];
							$cmd [$dindex] = $money ['commission_agent'];
							$dindex ++;
						} elseif ($money ["money_type"] == 2) {
							$b [$bindex] = $money ['transfer_money'];
							$cmb [$bindex] = $money ['commission_agent'];
							$bindex ++;
						} else {
							$r [$rindex] = $money ['transfer_money'];
							$cmr [$rindex] = $money ['commission_agent'];
							$rindex ++;
						}
					}
					// print_r($get_tranid);exit();
					$curr = array ($r, $b, $d );
					$cmsrate = array ($cmr, $cmb, $cmd );
					if (! empty ( $r )) {
						unset ( $r, $cmr );
						$r = array ();
						$cmr = array ();
					}
					if (! empty ( $b )) {
						unset ( $b, $cmb );
						$b = array ();
						$cmb = array ();
					}
					if (! empty ( $d )) {
						unset ( $d, $cmd );
						$d = array ();
						$cmd = array ();
					}
					// print_r($curr);echo "<br />->rate";
					// print_r($cmsrate);echo "<br />->";
					$lenght = $this->maxArrayLength ( $curr );
					for($i = 0; $i < $lenght; $i ++) {
						for($j = 0; $j < 3; $j ++) { // for get value from new array that
						                       // store curr dollar, bat, reil
							if (! empty ( $curr [$j] [$i] )) {
								if ($j == 0) {
									if (empty ( $rs [$key] ['money_reil'] )) { // if money type
									                                    // the same for reciever
										$rs [$key] ['money_reil'] = $curr [$j] [$i];
										$rs [$key] ['comm_reil'] = $cmsrate [$j] [$i];
									} else {
										$key ++;
										$rs [$key] = $this->addNewRecord ( $key, $value ); // add
										                                             // new record if money
										                                             // type have in record
										                                             // exist
										$rs [$key] ['money_reil'] = $curr [$j] [$i];
										$rs [$key] ['comm_reil'] = $cmsrate [$j] [$i];
									}
								} elseif ($j == 1) {
									if (empty ( $rs [$key] ['money_bat'] )) { // if money type
									                                   // the same for reciever
										$rs [$key] ['money_bat'] = $curr [$j] [$i];
										$rs [$key] ['comm_bat'] = $cmsrate [$j] [$i];
									} else {
										$key ++;
										$rs [$key] = $this->addNewRecord ( $key, $value );
										$rs [$key] ['money_bat'] = $curr [$j] [$i];
										$rs [$key] ['comm_bat'] = $cmsrate [$j] [$i];
									}
								} else {
									if (empty ( $rs [$key] ['money_dollar'] )) { // if money
									                                      // type the same for reciever
										$rs [$key] ['money_dollar'] = $curr [$j] [$i];
										$rs [$key] ['comm_dollar'] = $cmsrate [$j] [$i];
									} else {
										$key ++;
										$rs [$key] = $this->addNewRecord ( $key, $value );
										$rs [$key] ['money_dollar'] = $curr [$j] [$i];
										$rs [$key] ['comm_dollar'] = $cmsrate [$j] [$i];
									
									}
								}
							}
						}
					}
					if (($agent_id != $value ['agent_id'])) { // check
						$get_trans [$value ['agent_id']] = $db_tran->getTransByAgent ( $value ['agent_id'] );
						$agent_id = $value ['agent_id'];
					}
					$key ++;
				}
			}
			if (! empty ( $get_trans ))
				$this->view->get_trans = $get_trans;
				// print_r($rs);
			$this->view->tranlist = $rs;
		} catch ( Exception $e ) {
			$this->view->msg = "ការ​ផ្លាស់​ប្តូរ​មិន​​ជោគ​ជ័យ";
		}
	}
	private function maxArrayLength($array) { // get length of max array for loop
		$max = count ( $array [0] );
		$arr1 = count ( $array [1] );
		$arr2 = count ( $array [2] );
		if ($arr1 > $max) {
			$max = $arr1;
		}
		if ($arr2 > $max) {
			$max = $arr2;
		}
		return $max;
	}
	private function addNewRecord($key, $value) {
		$rs [$key] = array ('reciever_tel' => $value ['reciever_tel'], 'agentname' => $value ['agentname'], 'agent_id' => $value ['agent_id'], 'sender_name' => $value ['sender_name'], 'reciever_name' => $value ['reciever_name'], 'subname' => $value ['subname'], 'amount_type' => $value ['amount_type'], 'money_type' => $value ['money_type'], 'tran_id' => $value ['tran_id'], 'subagent_id' => $value ['subagent_id'] );
		return $rs [$key];
	}
	
	// for report send owe
	public function rptoweAction() {
		// action body
		try {
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->mainbranch = $db_keycode->getMainBranch ();
			
			$this->view->from_date = date ( 'Y-m-d' );
			$this->view->to_date = date ( 'Y-m-d' );
			
			$agent = new Application_Model_DbTable_DbAgents ();
			$this->view->sender_list = $agent->getSenderOweList ();
			$this->view->sender = - 1;
			
			$db_tran = new Application_Model_DbTable_DbMoneyTransactions ();
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				$transowe = $db_tran->getTransactionOwe ( $formdata );
				$this->view->from_date = $formdata ['from_date'];
				$this->view->to_date = $formdata ['to_date'];
				
				$this->view->sender = $formdata ['sender'];
			} else {
				$formdata = array ('from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ), 'sender' => - 1 );
				
				$transowe = $db_tran->getTransactionOwe ( $formdata );
			}
			// for get sender name
			
			// $transowe= $db_tran->getTransactionOwe();
			
			if (empty ( $transowe )) {
				$rs = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			} 

			else {
				$rs = array ();
				$key = 0;
				// $indextran=0;
				
				// for store money type
				$_sender = "default@@"; // default sender cannot store blank
				$r = array ();
				$d = array ();
				$b = array ();
				// store comission
				$cmr = array ();
				$cmd = array ();
				$cmb = array ();
				foreach ( $transowe as $index => $value ) {
					$rs [$key] = $this->addNewOweRecord ( $key, $value );
					$trans_money = $db_tran->getTransBySender ( $value ['reciever_tel'], $value ['sender_name'] ); // for
					                                                                                        // get
					                                                                                        // money
					                                                                                        // of
					                                                                                        // receiver
					if (! empty ( $trans_money ))
						;
					$rindex = 0;
					$dindex = 0;
					$bindex = 0; // reset new index if other
					                               // receiver;
					foreach ( $trans_money as $i => $money ) {
						// $get_tranid[$indextran] =
						// $money["tran_id"];$indextran++;
						if ($money ["money_type"] == 1) { // if money type = 1 add to array
						                             // dollar
							$d [$dindex] = $money ['transfer_money'];
							$cmd [$dindex] = $money ['commission'];
							$dindex ++;
						} elseif ($money ["money_type"] == 2) {
							$b [$bindex] = $money ['transfer_money'];
							$cmb [$bindex] = $money ['commission'];
							$bindex ++;
						} else {
							$r [$rindex] = $money ['transfer_money'];
							$cmr [$rindex] = $money ['commission'];
							$rindex ++;
						}
					}
					// print_r($get_tranid);exit();
					$curr = array ($r, $b, $d );
					$cmsrate = array ($cmr, $cmb, $cmd );
					if (! empty ( $r )) {
						unset ( $r, $cmr );
						$r = array ();
						$cmr = array ();
					}
					if (! empty ( $b )) {
						unset ( $b, $cmb );
						$b = array ();
						$cmb = array ();
					}
					if (! empty ( $d )) {
						unset ( $d, $cmd );
						$d = array ();
						$cmd = array ();
					}
					// print_r($curr);echo "<br />->rate";
					// print_r($cmsrate);echo "<br />->";
					$lenght = $this->maxArrayLength ( $curr );
					for($i = 0; $i < $lenght; $i ++) {
						for($j = 0; $j < 3; $j ++) { // for get value from new array that
						                       // store curr dollar, bat, reil
							if (! empty ( $curr [$j] [$i] )) {
								if ($j == 0) {
									if (empty ( $rs [$key] ['money_reil'] )) { // if money type
									                                    // the same for reciever
										$rs [$key] ['money_reil'] = $curr [$j] [$i];
										$rs [$key] ['comm_reil'] = $cmsrate [$j] [$i];
									} else {
										$key ++;
										$rs [$key] = $this->addNewOweRecord ( $key, $value ); // add
										                                                // new record if money
										                                                // type have in record
										                                                // exist
										$rs [$key] ['money_reil'] = $curr [$j] [$i];
										$rs [$key] ['comm_reil'] = $cmsrate [$j] [$i];
									}
								} elseif ($j == 1) {
									if (empty ( $rs [$key] ['money_bat'] )) { // if money type
									                                   // the same for reciever
										$rs [$key] ['money_bat'] = $curr [$j] [$i];
										$rs [$key] ['comm_bat'] = $cmsrate [$j] [$i];
									} else {
										$key ++;
										$rs [$key] = $this->addNewOweRecord ( $key, $value );
										$rs [$key] ['money_bat'] = $curr [$j] [$i];
										$rs [$key] ['comm_bat'] = $cmsrate [$j] [$i];
									}
								} else {
									if (empty ( $rs [$key] ['money_dollar'] )) { // if money
									                                      // type the same for reciever
										$rs [$key] ['money_dollar'] = $curr [$j] [$i];
										$rs [$key] ['comm_dollar'] = $cmsrate [$j] [$i];
									} else {
										$key ++;
										$rs [$key] = $this->addNewOweRecord ( $key, $value );
										$rs [$key] ['money_dollar'] = $curr [$j] [$i];
										$rs [$key] ['comm_dollar'] = $cmsrate [$j] [$i];
									
									}
								}
							}
						}
					}
					if (($_sender != $value ['sender_name'])) { // for get transaction by
					                                        // ower
						$get_trans [$value ['sender_name']] = $db_tran->getTransByower ( $value ['sender_name'] );
						$_sender = $value ['sender_name'];
					}
					$key ++;
				}
			}
			if (! empty ( $get_trans ))
				$this->view->get_trans = $get_trans;
			$this->view->tranlist = $rs;
		} catch ( Exception $e ) {
			$this->view->msg = "ការ​ផ្លាស់​ប្តូរ​មិន​​ជោគ​ជ័យ";
		}
	}
	
	private function addNewOweRecord($key, $value) { // for get new record owe rpt
		$rs [$key] = array ('reciever_tel' => $value ['reciever_tel'], 'agentname' => $value ['agentname'], 'agent_id' => $value ['agent_id'], 'subagent_id' => $value ['subagent_id'], 'subname' => $value ['subname'], 'sender_name' => $value ['sender_name'], 'amount_type' => $value ['amount_type'], 'money_type' => $value ['money_type'], 'tran_id' => $value ['tran_id'] );
		return $rs [$key];
	}
	public function deleteoweAction() {
		if ($this->getRequest ()->isPost ()) {
			$_data = $this->getRequest ()->getPost ();
			$_db = new Application_Model_DbTable_DbMoneyTransactions ();
			$_db->updateOwerbyTran ( $_data );
			Application_Form_FrmMessage::redirectUrl ( '/reports/index/rptowe' );
			exit ();
		}
	
	}
	
	public function rptfundAction() 	// old
	{
		// action body
		try {
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->mainbranch = $db_keycode->getMainBranch ();
			
			$this->view->from_date = date ( 'Y-m-d' );
			$this->view->to_date = date ( 'Y-m-d' );
			
			$sender = new Application_Model_DbTable_DbSender ();
			$_sender = $sender->getAllSenderNameOwe ();
			array_unshift ( $_sender, array ('id' => '-1', "name" => "ជ្រើសរើសឈ្មោះអ្នកជំពាក់" ) );
			
			$this->view->senderlist = $_sender;
			
			$db_tran = new Application_Model_DbTable_DbMoneyTransactions ();
			$db_tran = new Application_Model_DbTable_DbFund ();
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				$rs = $db_tran->getAllFund ( $formdata );
				$this->view->from_date = $formdata ['from_date'];
				$this->view->to_date = $formdata ['to_date'];
				$this->view->selected = $formdata ['sender_name'];
				
				// $this->view->sender =$formdata['sender'];
			} else {
				$this->view->selected = - 1;
				$formdata = array ('from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ), 'sender' => - 1 );
				$rs = $db_tran->getAllFund ( $formdata );
			}
			
			if (empty ( $rs )) {
				$rs = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			$this->view->fundlist = $rs;
		
		} catch ( Exception $e ) {
			$this->view->msg = "ការ​ផ្លាស់​ប្តូរ​មិន​​ជោគ​ជ័យ";
		}
	}
	
	public function rptFundtranAction() 	//
	{
		// action body
		try {
			
			$db_payment = new Application_Model_DbTable_DbPayment ();
			
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->mainbranch = $db_keycode->getMainBranch ();
			
			$this->view->from_date = date ( 'Y-m-d' );
			$this->view->to_date = date ( 'Y-m-d' );
			
			$sender = new Application_Model_DbTable_DbSender ();
			$_sender = $sender->getAllSenderNameFound ();
			array_unshift ( $_sender, array ('id' => '-1', "name" => "ជ្រើសរើសឈ្មោះអ្នកជំពាក់" ) );
			
			$this->view->senderlist = $_sender;
			
			$db_tran = new Application_Model_DbTable_DbMoneyTransactions ();
			$db_tran = new Application_Model_DbTable_DbFund ();
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				
				$this->view->from_date = $formdata ['from_date'];
				$this->view->to_date = $formdata ['to_date'];
				$this->view->selected = $formdata ['sender_name'];
			
			} else {
				$this->view->selected = - 1;
				$formdata = array ('from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ), 'sender_name' => - 1 );
			
			}
			$row_num = 0;
			$result = $db_tran->getAllTransactionFund ( $formdata );
			if (! empty ( $result )) {
				// print_r($result);
				$tra_id = '';
				foreach ( $result as $i => $rs ) {
					$refund_dollar = 0;
					$refund_bath = 0;
					$refund_riel = 0;
					// capital
					$capital_dollar = 0;
					$capital_bath = 0;
					$capital_riel = 0;
					// fund for which debt tran?
					
					$trandebt_dollar = '';
					$trandebt_bath = '';
					$trandebt_riel = '';
					
					$refund_txt = 'refund_dollar';
					$txt_capital = 'capital_dollar';
					$txt_trandebt = 'trandebt_dollar';
					if ($rs ["curency_type"] == 1) {
						$refund_dollar = $rs ["refund"];
						$capital_dollar = $rs ["capital"];
						$trandebt_dollar = $rs ['tran_id'];
					} else if ($rs ["curency_type"] == 2) {
						$refund_bath = $rs ["refund"];
						$refund_txt = 'refund_bath';
						
						$txt_capital = 'capital_bath';
						$capital_bath = $rs ['capital'];
						
						$txt_trandebt = 'trandebt_bath';
						$trandebt_bath = $rs ['tran_id'];
					} else {
						$refund_riel = $rs ["refund"];
						$refund_txt = 'refund_riel';
						
						$txt_capital = 'capital_riel';
						$capital_riel = $rs ["capital"];
						
						$txt_trandebt = 'trandebt_riel';
						$trandebt_riel = $rs ['tran_id'];
					
					}
					// echo $tra_id."=".$rs["invoice_found"]."<br/><br/>";
					if ($tra_id != $rs ["invoice_found"]) {
						$tra_id = $rs ["invoice_found"];
						$result_row [$tra_id] = array ('num' => (++ $row_num), "sender_id" => $rs ["sender_id"], "found_id" => $rs ["invoice_found"], "invoice_found" => $rs ["invoice_found"], "sender_name" => $rs ["sender_name"], "curency_type" => $rs ["curency_type"], "refund_dollar" => $refund_dollar, "refund_bath" => $refund_bath, "refund_riel" => $refund_riel, "capital_dollar" => $capital_dollar, "capital_bath" => $capital_bath, "capital_riel" => $capital_riel, 

						"trandebt_dollar" => $trandebt_dollar, "trandebt_bath" => $trandebt_bath, "trandebt_riel" => $trandebt_riel, "date_refund" => $rs ["date_refund"] );
						// print_r($result_row);echo "<br/> ***New <br/>";
					} else {
						$result_row [$tra_id] [$refund_txt] = $rs ["refund"];
						$result_row [$tra_id] [$txt_capital] = $rs ["capital"];
						$result_row [$tra_id] [$txt_trandebt] = $rs ["tran_id"];
					}
				
				}
				
				$i = 0;
				foreach ( $result_row as $val ) {
					$result_rows [$i] = $val;
					$i ++;
					// $owe_d =
				// $db_payment->getTransactionOweByIdForreport($val['trandebt_dollar']);
					// $owe_b =
				// $db_payment->getTransactionOweByIdForreport($val['trandebt_dollar']);
					// $owe_r =
				// $db_payment->getTransactionOweByIdForreport($val['trandebt_dollar']);
					// $row_owe[$val['sender_id']] =
				// array($owe_d,$owe_b,$owe_r);
				
				}
				// $this->view->listowe=$row_owe;
			} else {
				$result_rows = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			// print_r($result_rows);
			// exit;
			$this->view->fundlist = $result_rows;
		
		} catch ( Exception $e ) {
			$this->view->msg = "ការ​ផ្លាស់​ប្តូរ​មិន​​ជោគ​ជ័យ";
		}
	}
	public function rptowesAction() {
		// action body
		try {
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->mainbranch = $db_keycode->getMainBranch ();
			
			$this->view->from_date = date ( 'Y-m-d' );
			$this->view->to_date = date ( 'Y-m-d' );
			
			$sender = new Application_Model_DbTable_DbSender ();
			$_sender = $sender->getAllSenderNameOwe ();
			array_unshift ( $_sender, array ('id' => '-1', "name" => "ជ្រើសរើសឈ្មោះអ្នកជំពាក់" ) );
			
			$this->view->senderlist = $_sender;
			
			$db_tran = new Application_Model_DbTable_DbMoneyTransactions ();
			$db_tran = new Application_Model_DbTable_DbFund ();
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				$rs = $db_tran->getAllTranOwe ( $formdata );
				$this->view->selected = $formdata ['sender_name'];
			} else {
				$this->view->selected = - 1;
				$formdata = array ('sender_name' => - 1 );
				$rs = $db_tran->getAllTranOwe ( $formdata );
			}
			
			if (empty ( $rs )) {
				$rs = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			$this->view->owerlist = $rs;
		
		} catch ( Exception $e ) {
			$this->view->msg = "ការ​ផ្លាស់​ប្តូរ​មិន​​ជោគ​ជ័យ";
		}
	}
	public function rptDebtAction() {
		try {
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->mainbranch = $db_keycode->getMainBranch ();
			$from_date = date ( 'Y-m-d' );
			$to_date = date ( 'Y-m-d' );
			
			$sender = new Application_Model_DbTable_DbSender ();
			$_sender = $sender->getAllSenderKbank ();
			array_unshift ( $_sender, array ('id' => '-1', "name" => "ជ្រើសរើសឈ្មោះអ្នកផ្ញើរ" ) );
			$this->view->senderlist = $_sender;
			
			$db_tran = new Application_Model_DbTable_DbFund ();
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				$this->view->selected = $formdata ['sender_name'];
				
				$from_date = $formdata ['from_date'];
				$to_date = $formdata ['to_date'];
			
			} else {
				$this->view->selected = - 1;
				$formdata = array ('sender_name' => - 1, 'from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ) );
			}
			$rs = $db_tran->getAllTranDebt ( $formdata );
			if (empty ( $rs )) {
				$rs = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			$this->view->owerlist = $rs;
			$this->view->curr_type = $this->money_type_khmerletter;
		
		} catch ( Exception $e ) {
			$this->view->msg = "ការ​ផ្លាស់​ប្តូរ​មិន​​ជោគ​ជ័យ";
		}
		
		$this->view->from_date = $from_date;
		$this->view->to_date = $to_date;
	}
	public function rptDebtloanAction() {
		try {
			$db_keycode = new Application_Model_DbTable_DbKeycode ();
			$this->view->mainbranch = $db_keycode->getMainBranch ();
			$from_date = date ( 'Y-m-d' );
			$to_date = date ( 'Y-m-d' );
			
			$sender = new Application_Model_DbTable_DbSender ();
			$_sender = $sender->getAllSenderKbank ();
			array_unshift ( $_sender, array ('id' => '-1', "name" => "ជ្រើសរើសឈ្មោះអ្នកផ្ញើរ" ) );
			$this->view->senderlist = $_sender;
			
			$db_tran = new Application_Model_DbTable_DbPayout ();
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				$this->view->selected = $formdata ['sender_name'];
				
				$from_date = $formdata ['from_date'];
				$to_date = $formdata ['to_date'];
			
			} else {
				$this->view->selected = - 1;
				$formdata = array ('sender_name' => - 1, 'from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ) );
			}
			$rs = $db_tran->getAllDebtLoanDetail ( $formdata );
			if (empty ( $rs )) {
				$rs = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			$this->view->owerlist = $rs;
			$this->view->curr_type = $this->money_type_khmerletter;
		
		} catch ( Exception $e ) {
			$this->view->msg = "ការ​ផ្លាស់​ប្តូរ​មិន​​ជោគ​ជ័យ";
		}
		
		$this->view->from_date = $from_date;
		$this->view->to_date = $to_date;
	}
	
	// public function getBorrowDetail($tran_id){
	// $db = $this->getAdapter();
	// $sql = "SELECT * FROM cs_borrow_detail WHERE br_id = $tran_id AND
	// status!=2 AND delete_status!=1 ORDER BY currency_type LIMIT 3 ";
	// return $db->fetchAll($sql);
	// }
	// public function getAddLoanSenderNameById($sender_id){
	// $db = $this->getAdapter();
	// $sql = "SELECT
	// b.*,
	// bd.*
	// FROM
	// cs_borrow AS b
	// INNER JOIN cs_borrow_detail AS bd ON bd.br_id = b.b_id
	// WHERE
	// b.sender_id = $sender_id AND
	// b.`status` != 3 AND
	// bd.`status` != 3 AND
	// bd.delete_status = 0
	// ORDER BY
	// bd.currency_type ASC,b.loan_date ";
	// return $db->fetchAll($sql);
	// }
	public function rptDepositAction() {
		// action body
		try {
			
			$this->view->from_date = date ( 'Y-m-d' );
			$this->view->to_date = date ( 'Y-m-d' );
			
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				$this->view->selected = $formdata ['sender_name'];
				$this->view->type_money = $formdata ['type_money'];
				$this->view->from_date = $formdata ['from_date'];
				$this->view->to_date = $formdata ['to_date'];
				$this->view->txtsearch = $formdata ['txt_search'];
			
			} else {
				$this->view->selected = - 1;
				$formdata = array ('sender_name' => - 1 );
				$formdata = array ('txtsearch' => '', 'tran_type' => - 1, 'from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ), 'type_money' => - 1, 'sender_name' => - 1 );
			}
			$db_tran = new Application_Model_DbTable_DbKbank ();
			$rs = $db_tran->getRptDepositKbank ( $formdata );
			$this->view->money_type = $this->money_type;
			
			$cur = new Application_Model_DbTable_DbCurrencies ();
			$this->view->currencylist = $cur->getCurrencyList ();
			$sender = new Application_Model_DbTable_DbSender ();
			$_sender = $sender->getAllSenderKbank ();
			array_unshift ( $_sender, array ('id' => '-1', "name" => "ជ្រើសរើសឈ្មោះអ្នកផ្ញើរ" ) );
			$this->view->senderlist = $_sender;
			
			if (empty ( $rs )) {
				$rs = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			$this->view->depositlist = $rs;
		
		} catch ( Exception $e ) {
			$this->view->msg = "ការ​ផ្លាស់​ប្តូរ​មិន​​ជោគ​ជ័យ";
		}
	}
	public function rptWithdrawAction() {
		// action body
		try {
			
			$this->view->from_date = date ( 'Y-m-d' );
			$this->view->to_date = date ( 'Y-m-d' );
			$money_type = - 1;
			
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				$this->view->selected = $formdata ['sender_name'];
				$this->view->type_money = $formdata ['type_money'];
				$this->view->from_date = $formdata ['from_date'];
				$this->view->to_date = $formdata ['to_date'];
				$this->view->txtsearch = $formdata ['txt_search'];
				$money_type = $formdata ['type_money'];
			
			} else {
				$this->view->selected = - 1;
				$formdata = array ('sender_name' => - 1 );
				$formdata = array ('txt_search' => '', 'tran_type' => - 1, 'from_date' => date ( 'Y-m-d' ), 'to_date' => date ( 'Y-m-d' ), 'type_money' => - 1, 'sender_name' => - 1 );
			}
			$db_tran = new Application_Model_DbTable_DbKbank ();
			$rows = $db_tran->getRptWithdrawKbank ( $formdata );
			$key = 0;
			foreach ( $rows as $index => $value ) {
				$dollar_exist = ( int ) $value ['wd_amountdollar'];
				$bath_exist = ( int ) $value ['wd_amountbath'];
				$riel_exist = ( int ) $value ['wd_amountriel'];
				
				if (! empty ( $dollar_exist ) and ($money_type == 1 or $money_type == - 1)) {
					$rs [$key] = $this->addWithDrawRecord ( $key, $value );
					$rs [$key] ['before_amount'] = $value ['dollar_before'];
					$rs [$key] ['w_amount'] = $value ['wd_amountdollar'];
					$rs [$key] ['money_type'] = 1;
					$key ++;
				}
				if (! empty ( $bath_exist ) and ($money_type == 2 or $money_type == - 1)) {
					$rs [$key] = $this->addWithDrawRecord ( $key, $value );
					$rs [$key] ['before_amount'] = $value ['bath_before'];
					$rs [$key] ['w_amount'] = $value ['wd_amountbath'];
					$rs [$key] ['money_type'] = 2;
					$key ++;
				}
				if (! empty ( $riel_exist ) and ($money_type == 3 or $money_type == - 1)) {
					$rs [$key] = $this->addWithDrawRecord ( $key, $value );
					$rs [$key] ['before_amount'] = $value ['riel_before'];
					$rs [$key] ['w_amount'] = $value ['wd_amountriel'];
					$rs [$key] ['money_type'] = 3;
					$key ++;
				}
			}
			
			$this->view->money_type = $this->money_type;
			
			$cur = new Application_Model_DbTable_DbCurrencies ();
			$this->view->currencylist = $cur->getCurrencyList ();
			$sender = new Application_Model_DbTable_DbSender ();
			$_sender = $sender->getAllSenderKbank ();
			array_unshift ( $_sender, array ('id' => '-1', "name" => "ជ្រើសរើសឈ្មោះអ្នកផ្ញើរ" ) );
			$this->view->senderlist = $_sender;
			
			if (empty ( $rs )) {
				$rs = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			$this->view->depositlist = $rs;
		
		} catch ( Exception $e ) {
			$this->view->msg = "ការ​ផ្លាស់​ប្តូរ​មិន​​ជោគ​ជ័យ";
		}
	}
	private function addWithDrawRecord($key, $value) { // for get new record owe
	                                                 // rpt
		$rs [$key] = array ('invoice' => $value ['invoice'], 'sender_name' => $value ['sender_name'], 'tel' => $value ['tel'], 'acc_no' => $value ['acc_no'], 'create_date' => $value ['create_date'] );
		return $rs [$key];
	}
	
	public function rptbalanceAction() {
		// Get Session User
		$session_user = new Zend_Session_Namespace ( 'auth' );
		$b = new Application_Model_DbTable_DbCapital ();
		$user_id = $session_user->user_id;
		$month = date ( "n" );
		if ($this->getRequest ()->isPost ()) {
			$formdata = $this->getRequest ()->getPost ();
			$user_id = $formdata ['user_id'];
			if ($formdata ['actions'] == "add_capital") {
				if ($formdata ['dollar'] != 0 or $formdata ['bath'] != 0 or $formdata ['rail'] != 0) {
					$b->addBalanceByUser ( $user_id, $formdata );
				}
			} else {
				$month = $formdata ['month'];
			}
		}
		$usr_mod = new Application_Model_DbTable_DbUsers ();
		$this->view->users = $usr_mod->getUserListSelect ();
		$this->view->balance = $b->getCurrentBallancesByCurrentUser ( $user_id );
		$this->view->user_id = $user_id;
		$this->view->month = $month;
		
		// For view
		$db_loan = new Application_Model_DbTable_DbLoan ();
		$trans = $db_loan->getLoanDataByUserId ( $user_id, $month );
		if (empty ( $trans )) {
			$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
		}
		
		$this->view->tranlist = $trans;
	}
	
	public function rptbalanceAgentAction() {
		// Get Session User
		$session_user = new Zend_Session_Namespace ( 'auth' );
		$b = new Application_Model_DbTable_DbCapitalAgent ();
		$usr_mod = new Application_Model_DbTable_DbAgents ();
		$agents_list = $usr_mod->getAgentListSelect ();
		$user_id = $agents_list [0] ['id'];
		$month = date ( "n" );
		if ($this->getRequest ()->isPost ()) {
			$formdata = $this->getRequest ()->getPost ();
			$user_id = $formdata ['user_id'];
			if ($formdata ['actions'] == "add_capital") {
				$b->addBalanceByUser ( $user_id, $formdata );
			} else {
				$month = $formdata ['month'];
			}
		}
		
		$this->view->users = $agents_list;
		$this->view->balance = $b->getCurrentBallancesByCurrentUser ( $user_id );
		$this->view->user_id = $user_id;
		$this->view->month = $month;
		
		// For view
		$db_loan = new Application_Model_DbTable_DbLoanAgent ();
		$trans = $db_loan->getLoanDataByUserId ( $user_id, $month );
		if (empty ( $trans )) {
			$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
		}
		
		$this->view->tranlist = $trans;
	}
	
	public function rptsummaryExchangeAction() {
		// Get Session User
		$user_id = - 1;
		$from_date = date ( 'Y-m-d' );
		$to_date = date ( 'Y-m-d' );
		if ($this->getRequest ()->isPost ()) {
			$search = $this->getRequest ()->getPost ();
			$user_id = $search ['user_id'];
			$from_date = $search ['from_date'];
			$to_date = $search ['to_date'];
		} else {
			$search = array ('from_date' => $from_date, 'to_date' => $to_date, 'user_id' => - 1 );
		}
		
		$usr_mod = new Application_Model_DbTable_DbUsers ();
		$this->view->users = $usr_mod->getUserListSelect ();
		$this->view->user_id = $user_id;
		$this->view->from_date = $from_date;
		$this->view->to_date = $to_date;
		
		// For view
		$db = new Application_Model_DbTable_DbExchange ();
		
		$rs = $db->getAllExchangeList ( $search );
		$this->view->rs_tran = $rs;
		$db_exc = new Application_Model_DbTable_DbExchange ();
		$trans = $db_exc->getDataAll ( $user_id, $from_date, $to_date );
		if (empty ( $rs )) {
			$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
		}
		
		$this->view->tranlist = $trans;
	}
	public function rptAllsummaryAction() {
		// Get Session User
		$user_id = - 1;
		$from_date = date ( 'Y-m-d' );
		$to_date = date ( 'Y-m-d' );
		
		// create filter for detail tran
		$session_filter_date = new Zend_Session_Namespace ( 'filter_date' );
		$session_filter_date->sesfrom_date = $from_date;
		$session_filter_date->sesto_date = $to_date;
		$tran_type = - 1;
		
		if ($this->getRequest ()->isPost ()) {
			$search = $this->getRequest ()->getPost ();
			$user_id = $search ['user_id'];
			$from_date = $search ['from_date'];
			$to_date = $search ['to_date'];
			$tran_type = $search ['tran_type'];
			
			$session_filter_date->sesfrom_date = $from_date;
			$session_filter_date->sesto_date = $to_date;
			// print_r($session_filter_date);
			
			// echo $from_date;
		
		} else {
			$search = array ('from_date' => $from_date, 'to_date' => $to_date, 'user_id' => - 1, 'tran_type' => - 1 )

			;
		}
		
		$usr_mod = new Application_Model_DbTable_DbUsers ();
		$this->view->users = $usr_mod->getUserListSelect ();
		$this->view->user_id = $user_id;
		$this->view->from_date = $from_date;
		$this->view->to_date = $to_date;
		
		$db = new Application_Model_DbTable_DbSummaryReport ();
		$rs_tran = $db->getAllSummaryTransaction ( $search );
		print_r ( $rs_tran );
		// exit();
		if (! empty ( $rs_tran )) {
			$index = 0;
			$true = 0;
			$tran = '';
			$true = 0;
			$set_in = 0;
			$set_out = 0;
			foreach ( $rs_tran as $key => $rs ) {
				$new_record = 0;
				if ($key > 0) {
					if ($result [$index] ['currency_name'] != $rs ['currency_name'] or $result [$index] ['tran_type'] != $rs ['tran_type'] or $result [$index] ['staff_name'] != $rs ['staff_name']) {
						$index ++;
						$true = 0;
						$set_in = 0;
						$set_out = 0;
						$new_record = 1;
					}
				}
				if ($rs ['sign'] == 1) {
					if ($rs ['income'] == 1) { // use cash in
						$result [$index] = $this->getHeadResult ( $rs, $index );
						$result [$index] ['amount_in'] = $rs ['amount'];
						$result [$index] ['noncash_in'] = 0;
						$set_in = 1;
					} else { // non cash in
						if ($new_record == 1 or $key == 0) {
							$result [$index] = $this->getHeadResult ( $rs, $index ); // for
							                                                     // add new record
						}
						if ($set_in != 1) {
							$result [$index] ['amount_in'] = 0;
						}
						$result [$index] ['noncash_in'] = $rs ['amount'];
					}
					$result [$index] ['amount_out'] = 0;
					$result [$index] ['noncash_out'] = 0;
					$true = 1;
				} else {
					if ($true != 1 or $key == 0) {
						$result [$index] = $this->getHeadResult ( $rs, $index ); // for
						                                                     // add new record
						$result [$index] ['amount_in'] = 0;
						$result [$index] ['noncash_in'] = 0;
					}
					if ($rs ['income'] == 1) { // using cash
						$result [$index] ['amount_out'] = $rs ['amount'];
						$result [$index] ['noncash_out'] = 0;
						$set_out = 1;
					} else { // non cash
						if ($set_out != 1) {
							$result [$index] ['amount_out'] = 0;
						}
						$result [$index] ['noncash_out'] = $rs ['amount'];
					}
					$true = 0;
				}
			}
		
		}
		
		if (empty ( $rs )) {
			$result = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
		}
		$this->view->rs_tran = $result;
		
		$this->view->tran_type = $this->tran_type;
		$db = new Application_Model_DbTable_DbGlobal ();
		$this->view->tran_name = $db->getAllTransactionName ();
		$this->view->tran_types = $tran_type;
	}
	public function rptTranDetailAction() {
		// Get Session User
		
		$param = $this->getRequest ()->getParams ();
		$session_filter_date = new Zend_Session_Namespace ( 'filter_date' );
		$from_date = $session_filter_date->sesfrom_date;
		$to_date = $session_filter_date->sesto_date;
		$tran_type = - 1;
		
		if ($this->getRequest ()->isPost ()) {
			$search = $this->getRequest ()->getPost ();
			$user_id = $search ['user_id'];
			$from_date = $search ['from_date'];
			$to_date = $search ['to_date'];
			$tran_type = $search ['tran_type'];
		} else {
			$search = array ('from_date' => $from_date, 'to_date' => $to_date, 'user_id' => $param ['ur'], 'tran_id' => $param ['tran'] );
		}
		
		$usr_mod = new Application_Model_DbTable_DbUsers ();
		$this->view->users = $usr_mod->getUserListSelect ();
		$this->view->user_id = $param ['ur'];
		$this->view->from_date = $from_date;
		$this->view->to_date = $to_date;
		$this->view->tran_id = $param ['tran'];
		
		$db = new Application_Model_DbTable_DbSummaryReport ();
		$result = $db->getTransactionDetailBy ( $search );
		
		if (empty ( $result )) {
			$result = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
		}
		$this->view->rs_tran = $result;
		
		$this->view->tran_type = $this->tran_type;
		$db = new Application_Model_DbTable_DbGlobal ();
		$this->view->tran_name = $db->getAllTransactionName ();
		$this->view->tran_types = $tran_type;
	
	}
	public function getHeadResult($rs, $key) {
		//$tran [$key] = array ('id' => $rs ['id'], 'user_id' => $rs ['user_id'], 'staff_name' => $rs ['staff_name'], 'tran_id' => $rs ['tran_id'], 'tran_type' => $rs ['tran_type'], 'curr_type' => $rs ['curr_type'], 'currency_name' => $rs ['currency_name']		

		// 'amount_in'=>0,
		// 'amount_out'=>0,
		// 'noncash_in'=>0,
		// 'noncash_out'=>0,
		// 'noncash_out'=>$rs['amount'],
		
		//'sign' => $rs ['sign'], 'date' => $rs ['date'], 'status' => $rs ['status'], 'income' => $rs ['income'] );
		//return ($tran [$key]);
	
	}
	
	public function rptsummaryTransferAction() {
		// Get Session User
		$user_id = - 1;
		$from_date = date ( 'Y-m-d' );
		$to_date = date ( 'Y-m-d' );
		if ($this->getRequest ()->isPost ()) {
			$formdata = $this->getRequest ()->getPost ();
			$user_id = $formdata ['user_id'];
			$from_date = $formdata ['from_date'];
			$to_date = $formdata ['to_date'];
		}
		
		$usr_mod = new Application_Model_DbTable_DbUsers ();
		$this->view->users = $usr_mod->getUserListSelect ();
		$this->view->user_id = $user_id;
		$this->view->from_date = $from_date;
		$this->view->to_date = $to_date;
		
		$db_keycode = new Application_Model_DbTable_DbKeycode ();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv ();
		
		// For view
		$db_exc = new Application_Model_DbTable_DbMoneyTransactions ();
		$trans = $db_exc->getTransactionSummaryReports ( $user_id, $from_date, $to_date );
		
		// print_r($trans); exit();
		if (empty ( $trans )) {
			$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
		}
		
		$this->view->tranlist = $trans;
	}
	
	public function rptsummaryTransferAlluserAction() {
		// Get Session User
		$from_date = date ( 'Y-m-d' );
		$to_date = date ( 'Y-m-d' );
		if ($this->getRequest ()->isPost ()) {
			$formdata = $this->getRequest ()->getPost ();
			$from_date = $formdata ['from_date'];
			$to_date = $formdata ['to_date'];
		}
		
		$this->view->from_date = $from_date;
		$this->view->to_date = $to_date;
		
		$db_keycode = new Application_Model_DbTable_DbKeycode ();
		$this->view->keycode = $db_keycode->getKeyCodeMiniInv ();
		
		// For view
		$db_exc = new Application_Model_DbTable_DbMoneyTransactions ();
		$trans = $db_exc->getTransactionSummaryReports ( - 1, $from_date, $to_date, true );
		// print_r($trans); exit();
		if (empty ( $trans )) {
			$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
		}
		
		$this->view->tranlist = $trans;
	}
	public function rptPcsAction() {
		try {
			
			$db_tran = new Application_Model_DbTable_Dbpsc ();
			
			// create sesesion
			$from_date = date ( "Y-m-d" );
			$to_date = date ( "Y-m-d" );
			$type_money = - 1;
			$staff_name = - 1;
			$this->view->from_date = $from_date;
			$this->view->to_date = $to_date;
			$this->view->staff = $staff_name;
			$cur = new Application_Model_DbTable_DbCurrencies ();
			$this->view->currencylist = $cur->getCurrencyList ();
			$this->view->type_money = $type_money;
			
			if ($this->getRequest ()->isPost ()) {
				$formdata = $this->getRequest ()->getPost ();
				$this->view->type_money = $formdata ['type_money'];
				$this->view->staff_name = $formdata ['staff_name'];
				$this->view->from_date = $formdata ['from_date'];
				$this->view->to_date = $formdata ['to_date'];
			} else {
				$formdata = array ('from_date' => $from_date, 'to_date' => $to_date, 'type_money' => $type_money, 'staff_name' => $staff_name );
			}
			$trans = $db_tran->countAllStaffpcsAmount ( $formdata );
			if (empty ( $trans )) {
				$trans = array ('err' => 1, 'msg' => 'មិន​ទាន់​មាន​ទន្និន័យ​នូវ​ឡើយ​ទេ!' );
			}
			
			$this->view->rpt_list = $trans;
			$this->view->curr_type = $this->curr_typesimble;
			
			$usr_mod = new Application_Model_DbTable_DbUsers ();
			$user_list = $usr_mod->getUserListSelect ();
			array_unshift ( $user_list, array ('id' => '-1', "name" => "ជ្រើសរើសឈ្មោះបុគ្គលិក" ) );
			$this->view->users = $user_list;
			
			$session_user = new Zend_Session_Namespace ( 'auth' );
			$this->view->user_name = $session_user->last_name . ' ' . $session_user->first_name;
		
		} catch ( Exception $e ) {
		}
		
	}
	public function testreportAction() {
		
	}

}




