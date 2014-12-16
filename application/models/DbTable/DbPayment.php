<?php

class Application_Model_DbTable_DbPayment extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_transactions_owe';
    
	//function get user info from database
	
	public function getSenderNameById($data){
		$db = $this->getAdapter();
		$sql = "SELECT amount_type,SUM(total_money) AS money FROM ". $this->_name ."
		WHERE sender_name = '".$data['sender_name']."'
		AND status_loan=1 GROUP BY amount_type,sender_name ORDER BY amount_type LIMIT 3" ;
		return $db->fetchAll($sql);
	}
	//sopharat 27-08-14
	public function getAmountBySenderName($data){
		$db = $this->getAdapter();
		$sql = "SELECT amount_type, send_date, rate_perday, total_money_owe AS money FROM ". $this->_name ."
		WHERE sender_name = '".$data['sender_name']."'
		AND status_loan!=3 ORDER BY amount_type ASC" ;
		return $db->fetchAll($sql);
	}
	public function getAddDebtSenderNameById($sender_id){
		
		$db = $this->getAdapter();
// 		$sql = "SELECT invoice_no,`reciever_name`,reciever_tel,amount_type,total_money AS money,rate_perday,send_date FROM ". $this->_name ."
		$sql = "SELECT id,status_loan, invoice_no,`reciever_name`,reciever_tel,
		amount_type,total_money_owe AS money,rate_perday,send_date FROM ". $this->_name ."
		WHERE sender_name = $sender_id
		AND status_loan!=3 AND status!=1 ORDER BY amount_type,send_date " ;
		return $db->fetchAll($sql);
// 		$sql = "SELECT invoice_no,`reciever_name`,reciever_tel,amount_type,total_money AS money,rate_perday,send_date FROM ". $this->_name ."
// 		$sql = "SELECT status_loan, invoice_no,`reciever_name`,reciever_tel,amount_type,total_money_owe AS money,rate_perday,send_date FROM ". $this->_name ."
// 		WHERE sender_name = $sender_id
// 		AND status_loan!=2 ORDER BY amount_type " ;
// 		AND status_loan!=3 ORDER BY amount_type " ;
// 		return $db->fetchAll($sql);
	}
	public function getMoneyByName($sender_name,$money_type){
		$db = $this->getAdapter();
		$sql = "SELECT id,money_tran_id AS transac_id, total_money FROM ". $this->_name ."
		WHERE sender_name = '".$sender_name."' AND amount_type = $money_type AND status_loan=1 ORDER BY send_date " ;
		//echo $sql; exit();
		return $db->fetchAll($sql);
	}
	public function addCashFound($_data){
		
		$db = $this->getAdapter();
		$db->beginTransaction();
		//try{
			if($_data["curency_type"]==1){
				$_capital = $_data['money_dollar'];
				$_refound = $_data["refund_dollar"];
			}
			elseif($_data["curency_type"]==2){
				$_capital = $_data['money_bath'];
				$_refound = $_data["refund_bath"];
			}
			else{
				$_capital = $_data['money_kh'];
				$_refound = $_data["refund_kh"];
			}
			
			$this->_name="cs_transactions_owe";
			$rows = $this->getMoneyByName( $_data["sender_name"], $_data["curency_type"]);
			
			$exit = 0;
			foreach($rows As $key =>$row){
				if($key==0){
					if(($_refound-$row['total_money'])>=0){
						$remain = $_refound-$row['total_money'];
						$owe_remain=0;
						$pay_found = $row['total_money'];
						$status_loan = 0;
					}
					else{
						$remain = $row['total_money']-$_refound;
						$owe_remain=$remain;
						$pay_found = $_refound;
						$status_loan = 1;
						$exit = 1;
					}
					
			   }else{
			   		if($exit!=0){break;}
				   	if($remain>0){
				   		if(($remain-$row['total_money'])>=0){
				   			$remain = $remain-$row['total_money'];
				   			$owe_remain=0;
				   			$pay_found = $row['total_money'];
				   			$status_loan = 0;
				   		}
				   		else{
				   			$pay_found = $remain;//err here
				   			$status_loan = 1;// $_refound=$remain;
				   			$exit = 1;
				   			$owe_remain=$row['total_money']-$remain;
				   		}
				   	}
				   	else{
				   		break;
				   	}
			   }
			    $this->_name="cs_transactions_owe";
				$_arrowe = array(
						'status_loan'=>$status_loan,
						'total_money'=>$owe_remain
						);
				$where = $this->getAdapter()->quoteInto("id=?", $row["id"]);
				$this->update($_arrowe, $where);
				
				$_arrtran = array(
						'status_loan'=>$status_loan,
				);
				$wheretran = $this->getAdapter()->quoteInto("id=?", $row["transac_id"]);
				$db->update("cs_money_transactions", $_arrtran,$wheretran);
				
				$this->_name="cs_trancs_found_detail";
				$_arr = array(
						"found_id"=>$_data["found_id"],
						"owe_id"=>$row["id"],
						"money_found"=>$pay_found,
						);
				 $this->insert($_arr);//insert found_datail
				
			}
			$db->commit();
// 		}
// 		catch(Exeption $e){
// 			$db->rollBack();
// 		}
	}

	//sopharat 02/09/2014
	public function addTransFound($_data){
		$this->_name="cs_trans_found";
		$capital_dollar = (empty($_data['money_dollar']))? 0 : $_data['money_dollar'];
		$refund_dollar = (empty($_data['refund_dollar']))? 0 : $_data['refund_dollar'];
		$_data['refund_dollar'] = (($capital_dollar<$refund_dollar))? $capital_dollar : $refund_dollar;
		
		$capital_bath = (empty($_data['money_bath']))? 0 : $_data['money_bath'];
		$refund_bath = (empty($_data['refund_bath']))? 0 : $_data['refund_bath'];
		$_data['refund_bath'] = (($capital_bath<$refund_bath))? $capital_bath : $refund_bath ;
		
		$capital_reil = (empty($_data['money_kh']))? 0 : $_data['money_kh'];
		$refund_kh = (empty($_data['refund_kh']))? 0 : $_data['refund_kh'];
		$_data['refund_kh'] = (($capital_reil<$refund_kh))? $capital_reil : $refund_kh ;
		    
		$_refund_dollar = (empty($_data['refund_dollar']))? 0 : $_data['refund_dollar'];
		$_refund_bath = (empty($_data['refund_bath']))? 0 : $_data['refund_bath'];
		$_refund_riel = (empty($_data['refund_kh']))? 0 : $_data['refund_kh'];
		
		$exchange_dollar = (empty($_data['exchange_dollar']))? 0 : $_data['exchange_dollar'];
		$exchange_bath = (empty($_data['exchange_bath']))? 0 : $_data['exchange_bath'];
		$exchange_riel = (empty($_data['exchange_riel']))? 0 : $_data['exchange_riel'];
		
		$dollar_id = (empty($_data['money_dollar_id']))? 0 : $_data['money_dollar_id'];
		$bath_id = (empty($_data['money_bath_id']))? 0 : $_data['money_bath_id'];
		$riel_id = (empty($_data['money_kh_id']))? 0 : $_data['money_kh_id'];
		
		$db_sender = new Application_Model_DbTable_DbKbank();
		$sender_id = $db_sender->getSenderIdbyName($_data['sender_name']);

		$session_user=new Zend_Session_Namespace('auth');
		$db = $this->getAdapter();
		$db->beginTransaction();
		try {
			$arr_remain=array(
					'money_tran_id'=>'0',
					'sender_name'=>$sender_id,
					'invoice_no'=>$_data["invoice_no"],
					'rate_perday'=>$_data["remain_rate_perday"],
					'commission_agent'=>'0',
					'status'=>'0',
					'status_loan'=>'2',
					'cut_service'=>'0',
					'send_date'=>date('Y-m-d'),
					'exchange_rate_db'=>$exchange_dollar,
					'exchange_rate_dr'=>$exchange_bath,
					'exchange_rate_rb'=>$exchange_riel,
					'user_id'=>$session_user->user_id,
			);
		
		$arr_status_loan = array('status_loan'=>3,);
		if(!empty($_data["refund_dollar"])){
			$this->_name="cs_trans_found";
			$_arr = array(
				"invoice_found"		=> $_data["invoice_no"],
				"sender_id"			=> $sender_id,
				"capital"			=> $capital_dollar,
				"refund"			=> $_refund_dollar,
				"exchange_rate_db"	=> $exchange_dollar,
				"exchange_rate_dr"	=> $exchange_bath,
				"exchange_rate_rb"	=> $exchange_riel,
				//"date_refund"		=> $_data["refund_date"],
				"date_refund"		=> date('Y-m-d'),
				"curency_type"		=> '1',
				"tran_id"			=> $dollar_id,
			);

			$found_id = $this->insert($_arr);
			$this->updateOwe('id',$dollar_id,$arr_status_loan);
			
			/*insert to capital*/
			
			if(empty($_data['pay_all'])){//if pay sigle
				if($_data['pay_currencytype']>-1){
					$_ref_dollar_tocap = (empty($_data['rrconvertto_dollar']))? $_data['refund_dollar'] : $_data['rrconvertto_dollar'];
					$org_currtype = $_data['pay_currencytype'];
				}else{
					$org_currtype =1;
					$_ref_dollar_tocap = $_data['refund_dollar'] ;
				}
			}else{//if multy payment
				$org_currtype =  $_data['from_amount_type'];
				$_ref_dollar_tocap = (empty($_data['rrconvertto_dollar']))? $_data['refund_dollar'] : $_data['rrconvertto_dollar'];
				if($org_currtype==1){
					$_ref_dollar_tocap = $_data['refund_dollar'];
				}
			}
			$this->culToCapital($found_id,$org_currtype,$_ref_dollar_tocap);
			
			//print_r($_arr);echo '<br/><br/>';
			$remain = $capital_dollar-$_refund_dollar;
			//echo $remain.'<br/><br/>';
			if($remain<=0){
				$remain=0;
			}
			$arr_remain['amount'] = $remain;
			$arr_remain['total_money'] = $remain;
			$arr_remain['total_money_owe'] = $remain;
			$arr_remain['amount_type'] = 1;
			$this->addOwe($arr_remain);
			//$found_id = $this->insert($_arr);
			//$_data["curency_type"]=1; $this->addCashFound($_data);
		}
		if(!empty($_data["refund_bath"])){
			$this->_name="cs_trans_found";
			$_arr = array(
				"invoice_found"		=> $_data["invoice_no"],
				"sender_id"			=> $sender_id,
				"capital"			=> $capital_bath,
				"refund"			=> $_refund_bath,
				"exchange_rate_db"	=> $exchange_dollar,
				"exchange_rate_dr"	=> $exchange_bath,
				"exchange_rate_rb"	=> $exchange_riel,
				"date_refund"		=> date('Y-m-d'),
				"curency_type"		=> '2',
				"tran_id"			=> $bath_id,
			);
			$found_id = $this->insert($_arr);
			$this->updateOwe('id',$bath_id,$arr_status_loan);
			
			/*insert to capital*/
			if(empty($_data['pay_all'])){//if pay sigle
				if($_data['pay_currencytype']>-1){
					$_ref_bath_tocap = (empty($_data['rrconvertto_bath']))? $_data['refund_bath'] : $_data['rrconvertto_bath'];
					$org_currtype = $_data['pay_currencytype'];
				}else{
					$org_currtype=2;
					$_ref_bath_tocap = $_data['refund_bath'] ;
				}
			}else{//if multy payment
				$org_currtype =  $_data['from_amount_type'];
				$_ref_bath_tocap = (empty($_data['rrconvertto_bath']))? $_data['refund_bath'] : $_data['rrconvertto_bath'];
				if($org_currtype==1){
					$_ref_bath_tocap = $_data['refund_dollar'];
				}
			}
			$this->culToCapital($found_id,$org_currtype,$_ref_bath_tocap);
			
			//print_r($_arr);echo '<br/><br/>';
			
			$remain =$capital_bath-$_refund_bath;//echo $remain.'<br/><br/>';
			if($remain<=0){
				$remain=0;
			}
				$arr_remain['amount'] = $remain;
				$arr_remain['total_money'] = $remain;
				$arr_remain['total_money_owe'] = $remain;
				$arr_remain['amount_type'] = 2;

				$this->addOwe($arr_remain);
			//$found_id = $this->insert($_arr);
			//$_data["curency_type"]=2; $this->addCashFound($_data);
		}
		if(!empty($_data["refund_kh"])){
			$this->_name="cs_trans_found";
			$_arr = array(
				"invoice_found"		=> $_data["invoice_no"],
				"sender_id"			=> $sender_id,
				"capital"			=> $capital_reil,
				"refund"			=> $_refund_riel,
				"exchange_rate_db"	=> $exchange_dollar,
				"exchange_rate_dr"	=> $exchange_bath,
				"exchange_rate_rb"	=> $exchange_riel,
				"date_refund"		=> date('Y-m-d'),
				"curency_type"		=> '3',
				"tran_id"			=> $riel_id,
			);
			$found_id = $this->insert($_arr);
			$this->updateOwe('id',$riel_id,$arr_status_loan);
			
			/*insert to capital*/
			if(empty($_data['pay_all'])){//if pay sigle
				if($_data['pay_currencytype']>-1){
					$_ref_riel_tocap = (empty($_data['rrconvertto_riel']))? $_data['refund_kh'] : $_data['rrconvertto_riel'];
					$org_currtype = $_data['pay_currencytype'];
				}else{
					$org_currtype=3;
					$_ref_riel_tocap = $_data['refund_kh'] ;
				}
			}else{//if multy payment
				$org_currtype =  $_data['from_amount_type'];
				$_ref_riel_tocap = (empty($_data['rrconvertto_riel']))? $_data['refund_kh'] : $_data['rrconvertto_riel'];
				if($org_currtype==1){
					$_ref_riel_tocap = $_data['refund_kh'];
				}
			}
			$this->culToCapital($found_id,$org_currtype,$_ref_riel_tocap);
			
			//print_r($_arr);echo '<br/><br/>';
			$remain =$capital_reil-$_refund_riel;//echo $remain.'<br/><br/>';
			if($remain<=0){
				$remain=0;
			}
				$arr_remain['amount'] = $remain;
				$arr_remain['total_money'] = $remain;
				$arr_remain['total_money_owe'] = $remain;
				$arr_remain['amount_type'] = 3;
				//print_r($arr_remain);echo 'arr_remain<br/><br/>';
				$this->addOwe($arr_remain);
		}
		return  $db->commit();
    	} catch (Exception $e) {
    		$db->rollBack();
//     		echo $e->getMessage();exit();
    	}
	}
	public function culToCapital($found_id,$currency_type,$amount){
		/*start insert to capital*/
		$session_user=new Zend_Session_Namespace('auth');
		$user_id = $session_user->user_id;
			
		$db_cap = new Application_Model_DbTable_DbCapital();
		
		$rs = $db_cap->DetechCapitalExist($user_id,$currency_type,null);//check if add capital exist
		if(!empty($rs)){
			$arr = array(
					'amount'=>$rs['amount']+$amount
			);
			$db_cap->updateCurrentBalanceById($rs['id'],$arr);
		}else{
			$arr =array(
					'amount'=>$amount,
					'currencyType'=>$currency_type,
					'userid'=>$user_id,
					'statusDate'=>date("Y-m-d H:i:s")
			);
			$db_cap->AddCurrentBalanceById($arr);
		}

		//insert to capital_detail
		$arr_cd = array(
				'tran_id'=>$found_id,
				'tran_type'=>6,
				'curr_type'=>$currency_type,
				'amount'=>$amount,
				'date'=>date('Y-m-d'),
				'user_id'=>$user_id,
		);
		
		$db_cap->addMoneyToCapitalDetail($arr_cd);
		/*end intsert to capital*/
	}
	public function culToCapitalDelete($tran_id,$currency_type,$amount){
		/*start insert to capital*/
		$session_user=new Zend_Session_Namespace('auth');
		$user_id = $session_user->user_id;
			
		$db_cap = new Application_Model_DbTable_DbCapital();
		$cd = $db_cap->getCapitalDetailById($tran_id, 6, $currency_type);
		
		$date=date_create($cd['date']);
		$day = date_format($date,"d/m/Y");
		
		$rs = $db_cap->DetechCapitalExist($user_id,$currency_type,$day);//check if add capital exist
		if(!empty($rs)){
			$arr = array(
					'amount'=>$rs['amount']-$amount
			);
			$db_cap->updateCurrentBalanceById($rs['id'],$arr);
		}

		//update to capital_detail
		$db_cap->updateCapitalDetailById($cd['id'],array('status'=>'0'));
		/*end update to capital*/
	}
	public function updateOwe($id_field,$ids,$arr){
		$this->_name="cs_transactions_owe";
		
		$sub_where = array();
		$where = '';
// 		echo $ids;exit();
		if($id_field == 'invoice_no'){
			$where = " ".$id_field." = '".$ids."'";
		}else{
			$ids = explode(",",$ids);
			foreach ($ids as $key => $id) {
				$sub_where[] = " ".$id_field." = ".$id;
			}
			$where .= implode(' OR ',$sub_where);
		}
		
		$this->update($arr, $where);
	}
	public function addOwe($_data){
		$this->_name="cs_transactions_owe";
		if($_data){
			$this->insert($_data);
		}
	}
	
	public function addFoundbyParams($_data){
		$this->_name="cs_trans_found";
		$capital_dollar = (empty($_data['money_dollar']))? 0 : $_data['money_dollar'];
		$capital_bath = (empty($_data['money_bath']))? 0 : $_data['money_bath'];
		$capital_reil = (empty($_data['money_khmer']))? 0 : $_data['money_khmer'];
		
		$_refund_dollar = (empty($_data['refund_dollar']))? 0 : $_data['refund_dollar'];
		$_refund_bath = (empty($_data['refund_bath']))? 0 : $_data['refund_bath'];
		$_refund_riel = (empty($_data['refund_kh']))? 0 : $_data['refund_kh'];
		
	//	print_r($_data);
		
		$_arr = array(
				"invoice_found"		=> $_data["invoice_no"],
				"capital_dollar"	=> $capital_dollar,
				"capital_bath"		=> $capital_bath,
				"capital_reil"		=> $capital_reil,
				"sender_name"		=> $_data["sender_name"],
				"refund_dollar"		=> $_refund_dollar,
				"refund_bath"		=> $_refund_bath,
				"refund_riel"		=> $_refund_riel,
				"date_refund"		=> $_data["refund_date"],
		);
		$found_id = $this->insert($_arr);//using
		$_data["found_id"]=$found_id;
		
		if(!empty($_data["refund_dollar"])){
				$_data["curency_type"]=1; $this->addCashFound($_data);
		}
		if(!empty($_data["refund_bath"])){
			$_data["curency_type"]=2; $this->addCashFound($_data);
		}
		if(!empty($_data["refund_kh"])){
			$_data["curency_type"]=3; $this->addCashFound($_data);
		}
	}
	public function deleteFundbyParams($_data){
		$db=$this->getAdapter();
		$invoice_found = $_data['invoice_no'];
		$this->_name="cs_trans_found";
		$sql = "SELECT
				found_id,
				sender_id,
				tran_id,
				curency_type,
				refund
				FROM
				cs_trans_found
				WHERE `status` = 0 AND 
				invoice_found = '".$invoice_found."' ";
		$rows = $db->fetchAll($sql);
		
		//update cs_trans_found
		$_arr_tf = array(
				"status"	=> '1',
		);
// 		$db = $this->getAdapter();
// 		$db->beginTransaction();
// 		try {
			//update trans_found to delete
			$where = $this->getAdapter()->quoteInto("invoice_found=?", $invoice_found);
			$this->update($_arr_tf, $where);
			
			//update status to delete by invoice_no (status_loan=2)
			$this->updateOwe('invoice_no',$invoice_found,$_arr_tf);
			
			if($rows){
				foreach ($rows as $val){
					$this->culToCapitalDelete($val['found_id'], $val['curency_type'], $val['refund']);
					$ids = explode(",",$val['tran_id']);
					foreach ($ids as $key => $id) {
						$query = "SELECT * FROM cs_transactions_owe WHERE id = ".$id.";";
						$row = $db->fetchRow($query);
						unset($row['id']);
						$row['status_loan']=1;
						$this->addOwe($row);
					}	
					$this->updateOwe('id',$val['tran_id'],$_arr_tf);
				}
			}
// 			return  $db->commit();
// 		} catch (Exception $e) {
// 			$db->rollBack();
// 		}
	}
	public function updateFundbyParams($_data){
		
		$db=$this->getAdapter();
		//print_r($_data);exit();
		$this->_name="cs_trans_found";
		$capital_dollar = (empty($_data['money_dollar']))? 0 : $_data['money_dollar'];
		$capital_bath = (empty($_data['money_bath']))? 0 : $_data['money_bath'];
		$capital_reil = (empty($_data['money_khmer']))? 0 : $_data['money_khmer'];
		
		$_refund_dollar = (empty($_data['refund_dollar']))? 0 : $_data['refund_dollar'];
		$_refund_bath = (empty($_data['refund_bath']))? 0 : $_data['refund_bath'];
		$_refund_riel = (empty($_data['refund_kh']))? 0 : $_data['refund_kh'];
		
		$_arr = array(
				"capital_dollar"	=> $capital_dollar,
				"capital_bath"		=> $capital_bath,
				"capital_reil"		=> $capital_reil,
				"sender_name"		=> $_data["sender_name"],
				"refund_dollar"		=> $_refund_dollar,
				"refund_bath"		=> $_refund_bath,
				"refund_riel"		=> $_refund_riel,
				"date_refund"		=> $_data["refund_date"],
		);
		
		$where = $this->getAdapter()->quoteInto("found_id=?", $_data["id"]);
		$this->update($_arr, $where);
		
		$founds = $this->getFoundDetailById($_data["id"]);
		foreach($founds AS $key => $found){
			$this->_name="cs_transactions_owe";
			$_arr = array(
					"total_money"=>$found["money_found"]+$found["total_money"],
					'status_loan'=>1
			);
			$where = $this->getAdapter()->quoteInto("id=?", $found["owe_id"]);
			$this->update($_arr, $where);
		
			$_statuslaon=array("status_loan"=>1);
			$wheres = $this->getAdapter()->quoteInto("id=?", $found["train_id"]);
			$db->update("cs_money_transactions",$_statuslaon,$wheres);
		}
		$this->_name="cs_trancs_found_detail";
		$where = $this->getAdapter()->quoteInto("found_id=?", $_data["id"]);
		$this->delete($where);
		
		$_data["found_id"]=$_data["id"];
		if(!empty($_data["refund_dollar"])){
			$_data["curency_type"]=1; $this->addCashFound($_data);
		}
		if(!empty($_data["refund_bath"])){
			$_data["curency_type"]=2; $this->addCashFound($_data);
		}
		if(!empty($_data["refund_kh"])){
			$_data["curency_type"]=3; $this->addCashFound($_data);
		}
		
	}
// 	public function updateNewFound($_data){
	
// 		$db = $this->getAdapter();
// 		$db->beginTransaction();
// 		//try{
// 		if($_data["curency_type"]==1){
// 			$_capital = $_data['money_dollar'];
// 			$_refound = $_data["refund_dollar"];
// 		}
// 		elseif($_data["curency_type"]==2){
// 			$_capital = $_data['money_bath'];
// 			$_refound = $_data["refund_bath"];
// 		}
// 		else{
// 			$_capital = $_data['money_kh'];
// 			$_refound = $_data["refund_kh"];
// 		}
			
// 		$this->_name="cs_transactions_owe";
// 		$rows = $this->getMoneyByName($_data["sender_name"], $_data["curency_type"]);
			
// 		$exit = 0;
// 		foreach($rows As $key =>$row){
// 			if($key==0){
// 				if(($_refound-$row['total_money'])>=0){
// 					$remain = $_refound-$row['total_money'];
// 					$owe_remain=0;
// 					$pay_found = $row['total_money'];
// 					$status_loan = 0;
// 				}
// 				else{
// 					$remain = $row['total_money']-$_refound;
// 					$owe_remain=$remain;
// 					$pay_found = $_refound;
// 					$status_loan = 1;
// 				}
					
// 			}else{
// 				if($exit!=0){
// 					break;
// 				}
// 				if($remain>0){
// 					if(($remain-$row['total_money'])>=0){
// 						$remain = $remain-$row['total_money'];
// 						$owe_remain=0;
// 						$pay_found = $row['total_money'];
// 						$status_loan = 0;
// 					}
// 					else{
// 						$pay_found = $remain;//err here
// 						$status_loan = 1;// $_refound=$remain;
// 						$exit = 1;
// 						$owe_remain=$row['total_money']-$remain;
// 					}
// 				}
// 				else{
// 					break;
// 				}
// 			}
// 			$this->_name="cs_transactions_owe";
// 			$_arrowe = array(
// 					'status_loan'=>$status_loan,
// 					'total_money'=>$owe_remain
// 			);
// 			$where = $this->getAdapter()->quoteInto("id=?", $row["id"]);
// 			$this->update($_arrowe, $where);
	
// 			$_arrtran = array(
// 					'status_loan'=>$status_loan,
// 			);
// 			$wheretran = $this->getAdapter()->quoteInto("id=?", $row["transac_id"]);
// 			$db->update("cs_money_transactions", $_arrtran,$wheretran);
	
// 			$this->_name="cs_trancs_found_detail";
// 			$_arr = array(
// 					"found_id"=>$_data["found_id"],
// 					"owe_id"=>$row["id"],
// 					"money_found"=>$pay_found,
// 			);
// 			$this->insert($_arr);//insert found_datail
	
// 		}
// 		$db->commit();
// 		// 		}
// 		// 		catch(Exeption $e){
// 		// 			$db->rollBack();
// 		// 		}
// 	}
	
	public function getFoundDetailById($found_id){
		$db = $this->getAdapter();
		$sql = " SELECT f.found_id,f.owe_id,f.money_found,w.money_tran_id AS train_id,w.total_money FROM 
			cs_trancs_found_detail AS f ,cs_transactions_owe AS w WHERE w.`status`= 0 AND 
			f.`owe_id`=w.`id` AND f.found_id = ".$found_id;
		return $db->fetchAll($sql);
	}
	public function getFoundbyId($id){
		$db=$this->getAdapter();
		$sql = "SELECT
				f.found_id,
				f.invoice_found,
				f.capital,
				f.refund,
				f.curency_type,
				DATE_FORMAT(`date_refund`, '%d/%m/%Y') AS date_refund,
				s.sender_name,
				f.sender_id
				FROM cs_trans_found AS f
				INNER JOIN cs_sender AS s ON f.sender_id = s.sender_id
				WHERE f.`status` = 0 AND f.found_id = $id LIMIT 1";
		return $db->fetchRow($sql);
		
	}
	public function getFoundbyInvoice($invoice_found,$rate_perday=0){//sopharat 03-09-2014
		$db=$this->getAdapter();
		$sql = "SELECT
				f.found_id,
				f.invoice_found,
				f.capital,
				f.refund,
				f.curency_type,
				DATE_FORMAT(`date_refund`, '%Y-%m-%d') AS date_refund,
				s.sender_name,
				f.sender_id,
				f.exchange_rate_db,
				f.exchange_rate_dr,
				f.exchange_rate_rb
				FROM cs_trans_found AS f
				INNER JOIN cs_sender AS s ON f.sender_id = s.sender_id
				WHERE f.`status` = 0 AND f.invoice_found = '".$invoice_found."'";
		$rows = $db->fetchAll($sql);
// 		print_r($row);
		$result_row = array();
		if (!empty($rows)){
			foreach ($rows as $i =>$rs) {
				$refund_dollar = 0;
				$refund_bath = 0;
				$refund_riel = 0;
				
				$capital_dollar = 0;
				$capital_bath = 0;
				$capital_riel = 0;

				//count day
// 				$now = time(); // or your date as well
// 				$your_date = strtotime($rs["date_refund"]);
// 				$datediff = $now - $your_date;
// 				$days = floor($datediff/(60*60*24));
				
				$amount = $rs["capital"];
// 				if($days!=0){
// 					if($rate_perday!=0){
// 						$rate = ($amount * ($rate_perday/100))/30;
// 						$rate = number_format($rate,2);
// 						$amount = number_format($amount+$rate,2);
// 					}
// 				}
				//echo $rs["capital"]."*".$rate." =".$amount."<br/><br/>";
				
				$txt = 'dollar';
				if($rs["curency_type"]==1){
					$refund_dollar = $rs["refund"];
					$capital_dollar = $amount;
				}
				else if($rs["curency_type"]==2){
					$refund_bath = $rs["refund"];
					$capital_bath = $amount;
					$txt = 'bath';
				}
				else {
					$refund_riel = $rs["refund"];
					$capital_riel = $amount;
					$txt = 'riel';
				}
				
				//echo $tra_id."=".$rs["invoice_found"]."<br/><br/>";
				if($i == 0){
					$result_row = array(
							"found_id" 	  		=> $rs["found_id"],
							"invoice_found"		=> $rs["invoice_found"],
							"sender_name" 		=> $rs["sender_name"],
							"capital_dollar"	=> $capital_dollar,
							"capital_bath"		=> $capital_bath,
							"capital_riel"		=> $capital_riel,
							"refund_dollar"		=> $refund_dollar,
							"refund_bath"		=> $refund_bath,
							"refund_riel"		=> $refund_riel,
							"date_refund" 		=>$rs["date_refund"],
							"exchange_rate_db" 	=> $rs["exchange_rate_db"],
							"exchange_rate_dr"	=> $rs["exchange_rate_dr"],
							"exchange_rate_rb" 	=> $rs["exchange_rate_rb"],
							"rate_perday" 		=> $rate_perday,
					);
					//print_r($result_row);echo "<br/> ***New <br/>";
				}else{
					$result_row['refund_'.$txt] = $rs["refund"];
					$result_row['capital_'.$txt] = $amount;
					//print_r($result_row);echo "<br/>***old<br/>";
				}
		
			}
		}
		return $result_row;
		
	}
	function getTransactionOweByInvoice($invoice_found,$sender_id){
		$db=$this->getAdapter();
		$sql = "SELECT
				t.rate_perday,
				t.id,
				t.amount_type,
				t.status_loan
				FROM
				cs_transactions_owe AS t
				WHERE t.`status` = 0 AND 
				t.invoice_no = '".$invoice_found."' OR
				(t.status_loan = 1 AND t.sender_name = ".$sender_id.") ORDER BY t.id DESC";
		$rows = $db->fetchAll($sql);
		return $rows;
	}
	function getTransactionOweById($tran_id){
		$db=$this->getAdapter();
		$ids = explode(",",$tran_id);
		$sql = "SELECT
				t.rate_perday,
				t.id,
				t.amount_type,
				t.status_loan
				FROM
				cs_transactions_owe AS t
				WHERE t.`id` = '".$ids[0]."'";
		$rows = $db->fetchAll($sql);
		return $rows;
	}
	function getTransactionOweByIdForreport($tran_id){
		$db=$this->getAdapter();
		$ids = explode(",",$tran_id);
		$i = 0;
		$where = '';
		foreach ($ids as $id){
			$where = $i==0?'t.`id` ='.$id:$where.' OR t.`id` ='.$id;
			$i++;
		}
		$sql = "SELECT
				DATE_FORMAT(t.send_date, '%d/%m/%Y') AS send_date,
				t.invoice_no,
				t.id,
				t.amount_type,
    			t.total_money
				FROM
				cs_transactions_owe AS t
				WHERE ".$where;
		$rows = $db->fetchAll($sql);
		return $rows;
	}
	function getTransactionOweByIdBeforPayment($sender_id,$fromdate,$todate){
		$db=$this->getAdapter();
		//filter between date from ... to ...
		$date_from=date_create($fromdate);
		$date_to=date_create($todate);
		
    	$from_date =(empty($fromdate))? '1': " t.send_date >= '".date_format($date_from,"Y-m-d")." 00:00:00'";
    	$to_date = (empty($todate))? '1': " t.send_date <= '".date_format($date_to,"Y-m-d")." 23:59:59'";
    	
		$sql = "SELECT
				DATE_FORMAT(t.send_date, '%d/%m/%Y') AS send_date,
				t.invoice_no,
				t.id,
				t.amount_type,
    			t.total_money
				FROM
				cs_transactions_owe AS t
				WHERE t.sender_name = ".$sender_id."
				AND t.`status` = 0 AND t.status_loan = 1 AND $from_date AND $to_date
					";
		$rows = $db->fetchAll($sql);
		return $rows;
	}
	/*for using index select
	 * 
	 * 
	 */
	private function _buildQuery($search = ''){
		$session_user=new Zend_Session_Namespace('auth');
	
		//filter between date from ... to ...
		$from_date =(empty($search['from_date']))? '1': " date_refund >= '".$search['from_date']." 00:00:00'";
		$to_date = (empty($search['to_date']))? '1': " date_refund <= '".$search['to_date']." 23:59:59'";
		$where = "WHERE ".$from_date." AND ".$to_date;
	
		$sql = " SELECT
				f.found_id,
				f.invoice_found,
				f.refund,
				f.curency_type,
				DATE_FORMAT(`date_refund`, '%d/%m/%Y') AS date_refund,
				s.sender_name,
				f.sender_id
				FROM
				cs_trans_found AS f
				INNER JOIN cs_sender AS s ON f.sender_id = s.sender_id ";
	
		if(empty($search)){
			return $sql.$where;
		}
		if(!empty($search['sender_name'])){
			$where.=" AND f.sender_id = ".$search['sender_name']."  ";
			//$where.=" AND sender_name LIKE '%".$search['sender_name']."%'  ";
				
		}
		//echo $sql.$where." ORDER BY f.found_id ASC";exit;
	
		return $sql.$where." AND f.`status` = 0 ";
	}
	function getTransactionOweList($search, $start, $limit){
		$db = $this->getAdapter();
	
		$orderby = " ORDER BY found_id ASC";
	
		$sql = $this->_buildQuery($search).$orderby." LIMIT ".$start.", ".$limit;
		if ($limit == 'All') {
			$sql = $this->_buildQuery($search).$orderby;
		}
		//echo $sql;exit;
		return $db->fetchAll($sql);
	}
	function getTransactionOweListTotal($search=''){
		$db = $this->getAdapter();
		$sql = $this->_buildQuery();
		if(!empty($search)){
			$sql = $this->_buildQuery($search);
		}
		$_result = $db->fetchAll($sql);
		return count($_result);
	}
	function getCurrentRateJson($from,$to){
		$db = $this->getAdapter();
		$sql = "SELECT `rate_out`
		FROM `cs_rate` as r
		WHERE r.`active` = 1 AND (r.`in_cur_id`=$from AND r.`out_cur_id`=$to) OR 
		(r.`in_cur_id`=$to AND r.`out_cur_id`= $from )
		LIMIT 1 ";
		$rows = $db->fetchRow($sql);
	
		return Zend_Json::encode($rows);
	}
	function getRateAll(){
		$db = $this->getAdapter();
		$sql = "SELECT rate_out, in_cur_id, out_cur_id FROM cs_rate";
		$rows = $db->fetchAll($sql);
		return Zend_Json::encode($rows);
	}

}

