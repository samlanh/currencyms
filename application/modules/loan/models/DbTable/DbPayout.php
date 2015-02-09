<?php

class Application_Model_DbTable_DbPayout extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_borrow';
    
	public function addPayout($_data){
		$this->_name="cs_payout";

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

		$sender_id = $_data['sender_name'];
// 		print_r($_data);echo '<br/><br/>';
// 		exit;

		$br_id = 0;
		$session_user=new Zend_Session_Namespace('auth');
		
// 		$arr_remain=array(
// 				'sender_id'=>$sender_id,
// 				'invoice'=>$_data["invoice_no"],
// 				'laon_rate'=>$_data["remain_rate_perday"],
// 				'loan_date'=>date('Y-m-d'),
// 				'BD'=>$exchange_dollar,
// 				'RD'=>$exchange_bath,
// 				'RB'=>$exchange_riel,
// 				'status'=>'2',
// 				'user_id'=>$session_user->user_id,
// 		);
		
		$arr_borrow = array(
				'sender_id'=>$sender_id,
				'invoice'=>$_data["invoice_no"],
				'loan_date'=>date('Y-m-d'),
				'user_id'=>$session_user->user_id,
				'status'=>'2',
				'is_allinterest'=>'1'
		);
		$arr_borrow_detail=array(
				'BD'=>$exchange_dollar,
				'RD'=>$exchange_bath,
				'RB'=>$exchange_riel,
				'status'=>'2',
		);
		//print_r($arr_remain);echo '<br/><br/>';
			
		$arr_status_loan = array('status'=>3,);
		
		if(!empty($_data["refund_dollar"])){
			$this->_name="cs_payout";
			$_arr = array(
				"po_invoice_no"	=> $_data["invoice_no"],
				"sender_id"		=> $sender_id,
				"po_capital"	=> $capital_dollar,
				"po_refund"		=> $_refund_dollar,
				"exrate_db"		=> $exchange_dollar,
				"exrate_dr"		=> $exchange_bath,
				"exrate_rb"		=> $exchange_riel,
				"po_date"		=> date('Y-m-d'),
				"po_cur_type"	=> '1',
			);

			
			$po_id = $this->insert($_arr);
			$this->updateBorrow('br_id',$dollar_id,$arr_status_loan,$po_id,1);
			
			/*insert to capital*/
			$this->culToCapital($po_id,1,$_refund_dollar);
			
// 			print_r($_arr);echo '<br/><br/>';
			$remain = $capital_dollar-$_refund_dollar;
// 			echo $remain.'<br/><br/>';
			if($remain<=0){
				$remain=0;
			}
			
// 				if($br_id==0){
					$br_id = $this->addBorrow($arr_borrow);
// 				}
				$arr_borrow_detail['br_id'] = $br_id;
				$arr_borrow_detail['currency_type'] = 1;
				$arr_borrow_detail['loan_amount'] = $remain;
				$arr_borrow_detail['total_money'] = $remain;
				$arr_borrow_detail['laon_rate'] = $_data['remain_rate_perday'];
				$bd_id = $this->addBorrowDetail($arr_borrow_detail);			
			
		}
		if(!empty($_data["refund_bath"])){
			$this->_name="cs_payout";
			$_arr = array(
				"po_invoice_no"	=> $_data["invoice_no"],
				"sender_id"		=> $sender_id,
				"po_capital"	=> $capital_bath,
				"po_refund"		=> $_refund_bath,
				"exrate_db"		=> $exchange_dollar,
				"exrate_dr"		=> $exchange_bath,
				"exrate_rb"		=> $exchange_riel,
				"po_date"		=> date('Y-m-d'),
				"po_cur_type"	=> '2',
			);
			$po_id = $this->insert($_arr);
			$this->updateBorrow('br_id',$bath_id,$arr_status_loan,$po_id,2);
			
			/*insert to capital*/
			$this->culToCapital($po_id,2,$_refund_bath);
			
// 			print_r($_arr);echo '<br/><br/>';
			$remain =$capital_bath-$_refund_bath;//echo $remain.'<br/><br/>';
			if($remain<=0){
				$remain=0;
			}
				$br_id = $this->addBorrow($arr_borrow);
				$arr_borrow_detail['br_id'] = $br_id;
				$arr_borrow_detail['currency_type'] = 2;
				$arr_borrow_detail['loan_amount'] = $remain;
				$arr_borrow_detail['total_money']=$remain;
				$arr_borrow_detail['laon_rate'] = $_data['remain_rate_perday'];
				$bd_id = $this->addBorrowDetail($arr_borrow_detail);
// 				$arr_remain['loan_amount'] = $remain;
// 				$arr_remain['currency_type'] = 2;
// // 				print_r($arr_remain);echo 'arr_remain<br/><br/>';
// 				$br_id = $this->addBorrow($arr_remain);
// 			}
		}
		if(!empty($_data["refund_kh"])){
			$this->_name="cs_payout";
			$_arr = array(
				"po_invoice_no"	=> $_data["invoice_no"],
				"sender_id"		=> $sender_id,
				"po_capital"	=> $capital_reil,
				"po_refund"		=> $_refund_riel,
				"exrate_db"		=> $exchange_dollar,
				"exrate_dr"		=> $exchange_bath,
				"exrate_rb"		=> $exchange_riel,
				"po_date"		=> date('Y-m-d'),
				"po_cur_type"	=> '3',
			);
			$po_id = $this->insert($_arr);
			$this->updateBorrow('br_id',$riel_id,$arr_status_loan,$po_id,3);
			
			/*insert to capital*/
			$this->culToCapital($po_id,3,$_refund_riel);
			
// 			print_r($_arr);echo '<br/><br/>';
			$remain =$capital_reil-$_refund_riel;//echo $remain.'<br/><br/>';
			if($remain<=0){
				$remain=0;
			}
				$br_id = $this->addBorrow($arr_borrow);
				$arr_borrow_detail['br_id'] = $br_id;
				$arr_borrow_detail['currency_type'] = 3;
				$arr_borrow_detail['loan_amount'] = $remain;
				$arr_borrow_detail['total_money']=$remain;
				$arr_borrow_detail['laon_rate'] = $_data['remain_rate_perday'];
				$bd_id = $this->addBorrowDetail($arr_borrow_detail);
// 				$arr_remain['loan_amount'] = $remain;
// 				$arr_remain['currency_type'] = 3;
// // 				print_r($arr_remain);echo 'arr_remain<br/><br/>';
// 				$br_id = $this->addBorrow($arr_remain);
// 			}
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
				'tran_type'=>8,
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
		$cd = $db_cap->getCapitalDetailById($tran_id, 8, $currency_type);
		
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
	public function deletePayout($_data){
		$db=$this->getAdapter();
		$po_invoice_no = $_data['po_invoice_no'];
		$sql = "SELECT
				p.po_id,
				pd.cur_type,
				p.sender_id,
				pd.br_id,
				pd.ps_id,
				p.po_refund
				FROM
				cs_payout_detail AS pd
				INNER JOIN cs_payout AS p ON pd.cur_type = p.po_cur_type AND pd.po_id = p.po_id
				WHERE
				p.po_status = 0 AND
				p.po_invoice_no = '".$po_invoice_no."'
				ORDER BY
				pd.cur_type ASC ";
		$rows = $db->fetchAll($sql);
		
		$query = "SELECT * FROM cs_borrow WHERE invoice = '".$po_invoice_no."';";
		$rows_borrow = $db->fetchAll($query);
// 		print_r($rows);exit;
		
		$this->_name="cs_payout";
		//update payout to delete
		$where = $this->getAdapter()->quoteInto(" po_invoice_no=?", $po_invoice_no);
		$this->update(array('po_status'=>1), $where);
		
		//update status to delete by invoice (status=2)
		$this->_name = 'cs_borrow';
// 		$this->updateBorrow('invoice',$po_invoice_no,array('delete_status'=>1));
		$where = $this->getAdapter()->quoteInto(" invoice=?", $po_invoice_no);
		$this->update(array('delete_status'=>1), $where);

		if($rows){
			foreach ($rows as $val){
				$this->culToCapitalDelete($val['po_id'], $val['cur_type'], $val['po_refund']);
				$query = "SELECT * FROM cs_borrow_detail WHERE br_id = ".$val['br_id']." AND currency_type = ".$val['cur_type'].";";
				$row = $db->fetchRow($query);
				$id = $row['id'];
				unset($row['id']);
				$row['status']=1;
				
				$this->addBorrowDetail($row);
				
				$this->_name = 'cs_borrow_detail';
				$where = $this->getAdapter()->quoteInto(" id=?", $id);
				$this->update(array('delete_status'=>1),$where);
			}
		}
		
		if($rows_borrow){
			foreach ($rows_borrow as $bval){
				$this->_name = 'cs_borrow_detail';
				$where = $this->getAdapter()->quoteInto(" br_id=?", $bval['b_id']);
				$this->update(array('delete_status'=>1),$where);
			}
		}
	}
	public function getAddDebtSenderNameById($sender_id){
		$db = $this->getAdapter();
		$sql = "SELECT
				b.*,
				bd.*
				FROM
				cs_borrow AS b
				INNER JOIN cs_borrow_detail AS bd ON bd.br_id = b.b_id
				WHERE
				b.sender_id = $sender_id  AND
				b.`status` != 3 AND
				bd.`status` !=3 AND
				bd.delete_status = 0
				ORDER BY
				bd.currency_type ASC";
		return $db->fetchAll($sql);
	}

	public function updateBorrow($id_field,$ids,$arr,$po_id=0,$cur_type=1,$ps_id=0){
		$sub_where = array();
		$where = '';
	
		if($id_field == 'invoice'){
			$where = " ".$id_field." = '".$ids."'";
		}else{
			$this->_name="cs_payout_detail";
			$ids = explode(",",$ids);
			foreach ($ids as $key => $id) {
				$sub_where[] = " (".$id_field." = ".$id." AND currency_type = ".$cur_type.")";
				if($ps_id==0){
					$this->insert(array('po_id'=>$po_id,'br_id'=>$id,'cur_type'=>$cur_type));
				}else{
					$this->update(array('ps_status'=>1), ' ps_id='.$ps_id);
				}
			}
			$where .= implode(' OR ',$sub_where);
		}
		$this->_name="cs_borrow_detail";
		$this->update($arr, $where);
	}
	public function addBorrow($_data){
		$this->_name="cs_borrow";
		if($_data){
			return $this->insert($_data);
		}
	}
	public function addBorrowDetail($_data){
		$this->_name="cs_borrow_detail";
		if($_data){
			return $this->insert($_data);
		}
	}

	private function _buildQuery($search = ''){
		$session_user=new Zend_Session_Namespace('auth');
	
		//filter between date from ... to ...
		$from_date =(empty($search['from_date']))? '1': " po_date >= '".$search['from_date']." 00:00:00'";
		$to_date = (empty($search['to_date']))? '1': " po_date <= '".$search['to_date']." 23:59:59'";
		$where = "WHERE ".$from_date." AND ".$to_date;
	
		$sql = "SELECT
				p.po_id,
				p.po_invoice_no,
				s.sender_id,
				s.sender_name,
				p.po_refund,
				DATE_FORMAT(`po_date`, '%d/%m/%Y') AS date_refund,
				p.po_cur_type
				FROM
				cs_payout AS p
				INNER JOIN cs_sender AS s ON s.sender_id = p.sender_id ";
	
		if(empty($search)){
			return $sql.$where;
		}
		if(!empty($search['sender_name'])){
			$where.=" AND p.sender_id = ".$search['sender_name']."  ";
			//$where.=" AND sender_name LIKE '%".$search['sender_name']."%'  ";
	
		}
		//echo $sql.$where." ORDER BY f.found_id ASC";exit;
	
		return $sql.$where." AND p.po_status = 0 ";
	}
	function getPayoutList($search, $start, $limit){
		$db = $this->getAdapter();
	
		$orderby = " ORDER BY p.po_id ASC";
	
		$sql = $this->_buildQuery($search).$orderby." LIMIT ".$start.", ".$limit;
		if ($limit == 'All') {
			$sql = $this->_buildQuery($search).$orderby;
		}
		//echo $sql ;exit;
		return $db->fetchAll($sql);
	}
	function getPayoutListTotal($search=''){
		$db = $this->getAdapter();
		$sql = $this->_buildQuery();
		if(!empty($search)){
			$sql = $this->_buildQuery($search);
		}
		$_result = $db->fetchAll($sql);
		return count($_result);
	}
	public function getPayoutbyInvoice($invoice){//sopharat 03-09-2014
		$db=$this->getAdapter();
		$sql = "SELECT
				p.po_id,
				p.po_invoice_no,
				s.sender_id,
				s.sender_name,
				p.po_refund,
				DATE_FORMAT(`po_date`, '%d/%m/%Y') AS date_refund,
				p.po_cur_type,
				p.po_capital,
				p.exrate_db,
				p.exrate_dr,
				p.exrate_rb,
				p.po_date
				FROM cs_payout AS p INNER JOIN cs_sender AS s ON s.sender_id = p.sender_id
				WHERE
				p.po_invoice_no = '".$invoice."' AND
				p.po_status = 0
				ORDER BY p.po_id ASC ";
		$rows = $db->fetchAll($sql);
		$rate_perday = $this->getExrateBorrow($invoice);
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
				
				$amount = $rs["po_capital"];
// 				if($days!=0){
// 					if($rate_perday!=0){
// 						$rate = ($amount * ($rate_perday/100))/30;
// 						$rate = number_format($rate,2);
// 						$amount = number_format($amount+$rate,2);
// 					}
// 				}
				//echo $rs["capital"]."*".$rate." =".$amount."<br/><br/>";
				
				$txt = 'dollar';
				if($rs["po_cur_type"]==1){
					$refund_dollar = $rs["po_refund"];
					$capital_dollar = $amount;
				}
				else if($rs["po_cur_type"]==2){
					$refund_bath = $rs["po_refund"];
					$capital_bath = $amount;
					$txt = 'bath';
				}
				else {
					$refund_riel = $rs["po_refund"];
					$capital_riel = $amount;
					$txt = 'riel';
				}
				
				//echo $tra_id."=".$rs["invoice_found"]."<br/><br/>";
				if($i == 0){
					$result_row = array(
							"po_id" 	  		=> $rs["po_id"],
							"po_invoice_no"		=> $rs["po_invoice_no"],
							"sender_name" 		=> $rs["sender_name"],
							"capital_dollar"	=> $capital_dollar,
							"capital_bath"		=> $capital_bath,
							"capital_riel"		=> $capital_riel,
							"refund_dollar"		=> $refund_dollar,
							"refund_bath"		=> $refund_bath,
							"refund_riel"		=> $refund_riel,
							"date_refund" 		=>$rs["date_refund"],
							"exchange_rate_db" 	=> $rs["exrate_db"],
							"exchange_rate_dr"	=> $rs["exrate_dr"],
							"exchange_rate_rb" 	=> $rs["exrate_rb"],
							"rate_perday" 		=> $rate_perday,
					);
					//print_r($result_row);echo "<br/> ***New <br/>";
				}else{
					$result_row['refund_'.$txt] = $rs["po_refund"];
					$result_row['capital_'.$txt] = $amount;
					//print_r($result_row);echo "<br/>***old<br/>";
				}
		
			}
		}
		return $result_row;
		
	}
	
	public function getExrateBorrow($invoice){
		$db=$this->getAdapter();
		$sql = "SELECT DISTINCT
				bd.laon_rate
				FROM
				cs_borrow AS b
				INNER JOIN cs_borrow_detail AS bd ON b.b_id = bd.br_id
				WHERE
				b.invoice = '".$invoice."' AND
				b.delete_status = 0";
		$rows = $db->fetchOne($sql);
		$rat_perday = 0;
		if($rows){
			$rat_perday = $rows;
		}
		return $rat_perday;
	}
	
	public function getAllDebtLoanDetail($search=null){
		$db = $this->getAdapter();
		$from_date =(empty($search['from_date']))? '1': "b.loan_date >= '".$search['from_date']." 00:00:00'";
		$to_date = (empty($search['to_date']))? '1': "b.loan_date <= '".$search['to_date']." 23:59:59'";
		$where = " AND ".$from_date." AND ".$to_date;
		$sql=" SELECT b.b_id,b.`sender_id`,b.`invoice`,b.`loan_date`,b.`is_orgdebt`,
			bd.currency_type AS money_type, 
			bd.currency_type,bd.laon_rate,bd.total_money,bd.loan_amount,
			(SELECT tel FROM cs_sender AS c WHERE c.sender_id = b.sender_id LIMIT 1) AS tel, 
			(SELECT sender_name FROM cs_sender AS c WHERE c.sender_id = b.sender_id LIMIT 1) AS sender_name
			 FROM `cs_borrow` AS b,`cs_borrow_detail` AS bd WHERE b.b_id = bd.br_id ";
		if($search['sender_name']!=-1){
			$where.=" AND b.sender_id =".$search['sender_name'];
		}
		$order=" ORDER BY b.sender_id,bd.currency_type,bd.`id` ";
// 		$order=" ORDER BY sender_name,amount_type,send_date ";
// 		echo $sql.$where.$order;
		return $db->fetchAll($sql.$where.$order);
	}
	
	
	public function getFundByDebtLoan($invoice='',$curr_type=1){//get fund by id for debt rpt
		$db = $this->getAdapter();
		$sql =" SELECT * FROM `cs_payout`
				WHERE po_invoice_no  = '".$invoice."' AND po_cur_type=$curr_type limit 1";
		return $db->fetchAll($sql);
	}
}

