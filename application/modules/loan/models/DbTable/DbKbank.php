<?php

class Application_Model_DbTable_DbKbank extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_deposit';
    public function AddDepositBySender($data){
    	$db = $this->getAdapter();
    	$db->beginTransaction();
    	try{
    	$session_user=new Zend_Session_Namespace('auth');
    	$user_id = $session_user->user_id;
    	$arr = array(
    			'invoice'=>$data['invoice_no'],
    			'sender_id'=>$data['sender'],
    			'pay_term'=>$data['pay_term'],
    			'start_date'=>$data['send_date'],
    			'end_date'=>$data['epx_date'],
    			'amount_month'=>$data['amount_month'],
    			'money_type'=>$data['type_money'],
    			'money_inaccount'=>$data['money_inacc'],
    			'money_inaccount_org'=>$data['money_inacc'],
    			'commission'=>$data['commission'],
    			'total_amount'=>$data['total_amount'],
    			'recieve_amount'=>$data['recieve_amount'],
    			'total_return'=>$data['total_amount'],
    			'recieve_province'=>$data['province'],
    			'agent_id'=>$data['agent_id'],
    			'sub_agent_id'=>$data['sub_agent_id'],
    			'status'=>1,
    			'user_id'=>$user_id
    			);
    	$record = $this->insert($arr);
    	
    	$_arr = array(
    			'tran_id' 	=>$record,
    			'tran_type' =>4,
    			'curr_type'	=>$data['type_money'],
    			'amount'	=>$data['total_amount'],
    			'user_id'	=>$user_id
    	);
    	$dbc = new Application_Model_DbTable_DbCapital();
    	$dbc->addMoneyToCapitalDetail($_arr);
    	
    	$rs = $dbc->DetechCapitalExist($user_id, $data['type_money'],null);
    	if(!empty($rs)){//update old user
    		$arr = array(
    				'amount'=>$rs['amount']+$data['total_amount']
    		);
    		$dbc->updateCurrentBalanceById($rs['id'],$arr);
    	}else{
    		$date = date("Y-m-d H:i:s");
    		$arr =array(
    				'amount'=>$data['total_amount'],
    				'currencyType'=>$data['type_money'],
    				'userid'=>$user_id,
    				'statusDate'=>$date
    		);
    		$dbc->AddCurrentBalanceById($arr);
    	}
    	$db->commit();
    	}catch(Exception $e){
    		$db->rollBack();
    	}
    }
    public function editDepositBySender($data){
    	$db = $this->getAdapter();
    	$db->beginTransaction();
    	try{
//     		$where = 'id = '.$data['tran_id'];
//     		$ss = $this->delete($where);
    		$session_user=new Zend_Session_Namespace('auth');
    		$user_id = $session_user->user_id;
    		$arr = array(
    				'invoice'=>$data['invoice_no'],
    				'sender_id'=>$data['sender'],
    				'pay_term'=>$data['pay_term'],
    				'start_date'=>$data['send_date'],
    				'end_date'=>$data['epx_date'],
    				'amount_month'=>$data['amount_month'],
    				'money_type'=>$data['type_money'],
    				'money_inaccount'=>$data['money_inacc'],
    				'money_inaccount_org'=>$data['money_inacc'],
    				'commission'=>$data['commission'],
    				'total_amount'=>$data['total_amount'],
    				'recieve_amount'=>$data['recieve_amount'],
    				'total_return'=>$data['total_amount'],
    				'recieve_province'=>$data['province'],
    				'agent_id'=>$data['agent_id'],
    				'sub_agent_id'=>$data['sub_agent_id'],
    				'status'=>1,
    				'user_id'=>$user_id
    		);
//     		$this->insert($arr);
    		$where = 'id = '.$data['tran_id'];
    		$this->update($arr, $where);
    		
    		$dbc = new Application_Model_DbTable_DbCapital();
    		$rs = $this->getCapitalDetailById($data['tran_id'],4);
    		if(!empty($rs)){
    			if(($rs['curr_type']==$data['type_money']) AND ($rs['amount']!=$data['total_amount'])){//if the same currency type
    				$amount = $data['total_amount']-$rs['amount'];
    				
    				$rs_cap = $dbc->DetechCapitalExist($user_id, $data['type_money'],null);
    				if(!empty($rs_cap)){//update new user
    					$arr = array(
    							'amount'=>$rs_cap['amount']+$amount
    					);
    					$dbc->updateCurrentBalanceById($rs_cap['id'],$arr);
    				}else{
    					$date = date("Y-m-d H:i:s");//change it to current edit
    					$arr =array(
    							'amount'=>$data['total_amount'],
    							'currencyType'=>$data['type_money'],
    							'userid'=>$user_id,
    							'statusDate'=>$date
    					);
    					$dbc->AddCurrentBalanceById($arr);
    				}
    				
    			}else{
    				if($rs['curr_type']!=$data['type_money']){//if edit change currency type
	    				$rs_cap = $dbc->DetechCapitalExist($user_id, $rs['curr_type'],null);//with old currency 
	    				$amount = $rs_cap['amount']-$rs['amount'];//ot trov pls check again
	    				$arr = array(
	    						'amount'=>$amount
	    				);
	    				$dbc->updateCurrentBalanceById($rs_cap['id'],$arr);//to reset old record
	    				
	    				$rs_cap = $dbc->DetechCapitalExist($user_id, $data['type_money'],null);//with new currency
	    				if(!empty($rs_cap)){//update old user
	    					$arr = array(
	    							'amount'=>$rs_cap['amount']+$data['total_amount']
	    					);
	    					$dbc->updateCurrentBalanceById($rs_cap['id'],$arr);
	    				}else{
	    					$date = date("Y-m-d H:i:s");
	    					$arr =array(
	    							'amount'=>$data['total_amount'],
	    							'currencyType'=>$data['type_money'],
	    							'userid'=>$user_id,
	    							'statusDate'=>$date
	    					);
	    					$dbc->AddCurrentBalanceById($arr);
	    				}
    				}
    			}
    			
    			$_arr = array(
    					'tran_type' =>4,
    					'curr_type'	=>$data['type_money'],
    					'amount'	=>$data['total_amount'],
    					'user_id'	=>$user_id
    			);
    			$dbc->updateCapitalDetailById($rs['id'],$_arr);
    		}
    		$db->commit();
    	}catch(Exception $e){
    		$db->rollBack();
    	}
    }
    function getCapitalDetailById($id,$tran_type){//for record capital detail by id
    	$db = $this->getAdapter();
    	$this->_name='cs_capital_detail';
    	$sql = " SELECT * FROM ". $this->_name ." WHERE tran_id = $id AND tran_type = $tran_type AND status=1 LIMIT 1 ";
    	return $db->fetchRow($sql);
    }
    
    public function extendDateByTran($data){
    	try{
    		$db = $this->getAdapter();
    		$db->beginTransaction();
    		
    		$where = 'id = '.$data['tran_id'];
    		$arr = array(
    				'is_expired'=>1,
    				);
    		$this->update($arr, $where);
    		$session_user=new Zend_Session_Namespace('auth');
    		$arr = array(
    				'invoice'=>$data['invoice_no'],
    				'extend_from'=>$data['tran_id'],
    				'sender_id'=>$data['sender'],
    				'pay_term'=>$data['pay_term'],
    				'start_date'=>$data['send_date'],
    				'end_date'=>$data['epx_date'],
    				'amount_month'=>$data['amount_month'],
    				'money_type'=>$data['type_money'],
    				'recieve_amount'=>$data['recieve_amount'],
    				'commission'=>$data['commission'],
    				'money_inaccount'=>$data['money_inacc'],
    				'recieve_province'=>$data['province'],
    				'agent_id'=>$data['agent_id'],
    				'sub_agent_id'=>$data['sub_agent_id'],
    				'status'=>1,
    				'is_extend'=>1,
    				'user_id'=>$session_user->user_id
    		);
    		$this->insert($arr);
    		$db->commit();
    	}catch(Exception $e){
    		echo $e->getMessage();exit();
    		$db->rollBack();
    	
    	}
    }
    private function _buildQuery($search = ''){
    	$session_user=new Zend_Session_Namespace('auth');
    	$current_date = date("Y-m-d");
     	$from_date =(empty($search['from_date']))? '1': "start_date >= '".$search['from_date']." 00:00:00'";
     	$to_date = (empty($search['to_date']))? '1': "start_date <= '".$search['to_date']." 23:59:59'";
     	
     	$where = " AND ( ".$from_date." AND ".$to_date." OR end_date <= "."'".$current_date."' )";

    	$sql = " SELECT 
		  id, invoice, pay_term, sender_name, tel, acc_no, start_date, end_date, amount_month, money_type, 
		  (SELECT symbol  FROM  `cs_currencies` WHERE id = d.`money_type`) AS symbol,
		   recieve_amount, money_inaccount,is_extend, d.status 
		   FROM  cs_deposit AS d, cs_sender AS s
			WHERE s.`sender_id` = d.`sender_id` AND is_expired != 1  ";
    
    	if(empty($search)){
    		return $sql." AND ".$where;
    	}
    //	$where='';
    	if(!empty($search['txt_search'])){
    		//$where=" , cs_sender AS s WHERE d.sender_id =s.sender_id ";
    		$s_where = array();
    		$s_where[] = " tel LIKE '%{$search['txt_search']}%'";
    		$s_where[] = "acc_no LIKE '%{$search['txt_search']}%'";
    		$where .=' AND ('.implode(' OR ',$s_where).')';
    	}else{
    	  // $where_date=" ".$where_date;
    	}
    
    	if ($search['type_money'] >= 0){
    		$where.= ' AND money_type = '. $search['type_money'];
    	}
    	if ($search['sender'] >= 0){
    		$where.= ' AND d.sender_id = '. $search['sender'];
    	}
//     	echo $sql.$where;//not yet complete query
    	return $sql.$where;
    }
    function getTransactionListBy($search, $start, $limit){
    	$db = $this->getAdapter();
    	$orderby = " ORDER BY id DESC";
    
    	$sql = $this->_buildQuery($search).$orderby." LIMIT ".$start.", ".$limit;
    	if ($limit == 'All') {
    		$sql = $this->_buildQuery($search).$orderby;
    	}
    	return $db->fetchAll($sql);
    }
    function getTransactionListTotal($search){
    	$db = $this->getAdapter();
    	$sql = $this->_buildQuery();
    	
    	if(!empty($search)){
    		$sql = $this->_buildQuery($search);
    	}
    	$_result = $db->fetchAll($sql);
    	return count($_result);
    }
    public function getAccountNumberForKBank(){
    	$db = $this->getAdapter();
    	$sql=" SELECT acc_no FROM cs_sender WHERE sender_type=1 ORDER BY sender_id DESC LIMIT 1 ";
    	$acc_no = $db->fetchOne($sql);
    	$new_acc_no= (int)$acc_no+1;
    	$acc_no= strlen((int)$acc_no+1);
    	$pre = "";
    	for($i = $acc_no;$i<6;$i++){
    		$pre.='0';
    	}
    	return $pre.$new_acc_no;
    }
    public function getTranKbankById($tr_id){
    	$db = $this->getAdapter();
    	$sql = "SELECT * FROM cs_deposit WHERE id = $tr_id limit 1";
    	return $db->fetchRow($sql);
    }
    public function getAllMoneyDebtbySender($sender_id){
    	$db = $this->getAdapter();
    	$sql = " SELECT 
				  id,money_type,
				  SUM(money_inaccount) AS money_debt 
				FROM
				  `cs_deposit` 
				WHERE is_expired != 1 
				  AND money_inaccount != 0 
				  AND sender_id =$sender_id 
				GROUP BY money_type  ORDER BY money_type LIMIT 3 ";
    	return $db->fetchAll($sql);
    }
    public function getAllMoneyDeposit($sender_name){
    	$db = $this->getAdapter();
    	$sql = " 
	    	SELECT
	    	d.id,d.money_type,
	    	SUM(money_inaccount) AS money
	    	FROM
	    	`cs_deposit` AS d,`cs_sender` AS s
	    	WHERE d.sender_id = s.sender_id AND is_expired != 1
	    	AND money_inaccount != 0
	    	AND s.sender_name ='".$sender_name."'
	    	GROUP BY money_type  ORDER BY money_type LIMIT 3 ";
    	return $db->fetchAll($sql);
    }
    public function addWithdrawBySender($data){
    	try{
	    	$db = $this->getAdapter();
	    	$db->beginTransaction();
	    	$this->_name='cs_withdraw';
	    	$session_user=new Zend_Session_Namespace('auth');
	    	$user_id = $session_user->user_id;
	    	if(empty($data['withdraw_dollar'])){	
	    		$w_dollar = 0;  	
	    	}else{ 
	    		$w_dollar =$data['withdraw_dollar'] ;
	    		$rs_dollar = $this->getMoneyInAccountBySender($data['sender'],1);
	    	    $this->updateOldDeposit($w_dollar,$rs_dollar);

	    	}
	    	if(empty($data['withdraw_bath'])){
	    		$w_bath = 0;
	    	}else{
	    		$w_bath =$data['withdraw_bath'];
	    		$rs_bath = $this->getMoneyInAccountBySender($data['sender'],2);
	    		$this->updateOldDeposit($w_bath,$rs_bath);
	    	}
	    	
	    	if(empty($data['withdraw_riel'])){
	    		$w_riel = 0;
	    	}else{
	    		$w_riel = $data['withdraw_riel'];
	    		$rs_riel = $this->getMoneyInAccountBySender($data['sender'],3);
	    		$this->updateOldDeposit($w_riel,$rs_riel);
	    	}
	    	$b_dollar=$data['debt_dollar'];
	    	$b_bath=$data['debt_bath'];
	    	$b_riel=$data['debt_riel'];
	    	$this->_name='cs_withdraw';
	    	$data = array(
	    			'sender_id'=>$data['sender'],
	    			'invoice'=>$data['invoice_no'],
	    			'wd_amountdollar'=>$w_dollar,
	    			'wd_amountbath'=>$w_bath,
	    			'wd_amountriel'=>$w_riel,
	    			'dollar_before'=>$b_dollar,
	    			'bath_before'=>$b_bath,
	    			'riel_before'=>$b_riel,
	    			'user_id'=>$user_id,
	    			'create_date'=>$data['send_date'],
	    			);
	    	$id = $this->insert($data);
	    	$process = 0;
	    	$amount = 0;
	    	$dbc = new Application_Model_DbTable_DbCapital();
	    	for($i=1; $i<4; $i++){//for add capital detail and update current capital by staff
	    		if(!empty($w_dollar) AND $i==1){
	    			$process = 1;
	    			$curr_type = 1;
	    			$amount = $w_dollar;
	    		}elseif(!empty($w_bath) AND $i==2){
	    			$process = 1;
	    			$curr_type = 2;
	    			$amount = $w_bath;
	    		}elseif(!empty($w_riel) AND $i==3){
	    			$process = 1;
	    			$curr_type = 3;
	    			$amount = $w_riel;
	    		}
	    		if($process==1){//with draw tran_type = 7
	    			$_arr = array(
	    					'tran_id' 	=>$id,
	    					'tran_type' =>7,
	    					'curr_type'	=>$curr_type,
	    					'amount'	=>-$amount,//cos withdraw money to customer
	    					'user_id'	=>$user_id
	    			);
	    			
	    			$dbc->addMoneyToCapitalDetail($_arr);
	    			 
	    			$rs = $dbc->DetechCapitalExist($user_id, $curr_type,null);
	    			if(!empty($rs)){//update old user
	    				$arr = array(
	    						'amount'=>$rs['amount']-$amount
	    				);
	    				$dbc->updateCurrentBalanceById($rs['id'],$arr);
	    			}else{
	    				$date = date("Y-m-d H:i:s");
	    				$arr =array(
	    						'amount'=>-$amount,
	    						'currencyType'=>$curr_type,
	    						'userid'=>$user_id,
	    						'statusDate'=>$date
	    				);
	    				$dbc->AddCurrentBalanceById($arr);
	    			}
	    			
	    		}
	    		
	    		$process = 0;
	    	}
	    	
    		$db->commit();
    	}catch(Exception $e){
    		$db->rollBack();
    	}
    }
    public function addWithdrawBySendName($data){
    	try{
    		$db = $this->getAdapter();
    		$this->_name='cs_withdraw';
    		$session_user=new Zend_Session_Namespace('auth');
    		if(empty($data['withdraw_dollar'])){
    			$w_dollar = 0;
    		}else{
    			$w_dollar =$data['withdraw_dollar'] ;
    			$rs_dollar = $this->getMoneyInAccountBySender($data['sender'],1);
    			$this->updateOldDeposit($w_dollar,$rs_dollar);
    		}
    		if(empty($data['withdraw_bath'])){
    			$w_bath = 0;
    		}else{
    			$w_bath =$data['withdraw_bath'];
    			$rs_bath = $this->getMoneyInAccountBySender($data['sender'],2);
    			$this->updateOldDeposit($w_bath,$rs_bath);
    		}
    
    		if(empty($data['withdraw_riel'])){
    			$w_riel = 0;
    		}else{
    			$w_riel = $data['withdraw_riel'];
    			$rs_riel = $this->getMoneyInAccountBySender($data['sender'],3);
    			$this->updateOldDeposit($w_riel,$rs_riel);
    		}
    		$b_dollar=$data['debt_dollar'];
    		$b_bath=$data['debt_bath'];
    		$b_riel=$data['debt_riel'];
    		$this->_name='cs_withdraw';
    		$data = array(
    				'sender_id'=>$data['sender'],
    				'invoice'=>$data['invoice_no'],
    				'wd_amountdollar'=>$w_dollar,
    				'wd_amountbath'=>$w_bath,
    				'wd_amountriel'=>$w_riel,
    				'dollar_before'=>$b_dollar,
    				'bath_before'=>$b_bath,
    				'riel_before'=>$b_riel,
    				'user_id'=>$session_user->user_id,
    				'create_date'=>$data['send_date'],
    		);
    		$this->insert($data);
    	}catch(Exception $e){
    	}
    }
    public function getMoneyInAccountBySender($sender_id,$money_type){
    	$db = $this->getAdapter();
    	$sql = "SELECT 
				  id,
				  money_inaccount 
				FROM
				  `cs_deposit` 
				WHERE sender_id = $sender_id 
				  AND money_type = $money_type 
				  AND is_expired != 1 ORDER BY id ";
    	return $db->fetchAll($sql);
    }
    public function updateOldDeposit($withdraw,$_rs){
    	$this->_name='cs_deposit';
    	$exit = 0;
    	foreach($_rs AS $key =>$row){
    		if($key==0){
    			if(($withdraw-$row['money_inaccount'])>=0){
    				$remain = $withdraw-$row['money_inaccount'];
    				$owe_remain=0;
    			}
    			else{
    				$remain = $row['money_inaccount']-$withdraw;
    				$owe_remain=$remain;
    				$exit = 1;
    			}
    		}
    		else{
    			if($exit!=0){
    				break;
    			}
    			if($remain>0){
    				if(($remain-$row['money_inaccount'])>=0){
    					$remain = $remain-$row['money_inaccount'];
    					$owe_remain=0;
    				}
    				else{
    					$status_loan = 0;
    					$exit = 1;
    					$owe_remain=$row['money_inaccount']-$remain;
    				}
    			}
    			else{
    				break;
    			}
    		}
    		$arr = array(
    				'money_inaccount'=>$owe_remain
    				);
    		$where = $this->getAdapter()->quoteInto('id=?', $row['id']);
    		$this->update($arr, $where);
    	}
    }
    
    
    
    ///
    private function _queryWithdraw($search =null){
    	$session_user=new Zend_Session_Namespace('auth');
    	$current_date = date("Y-m-d");
    	$from_date =(empty($search['from_date']))? '1': "create_date >= '".$search['from_date']." 00:00:00'";
    	$to_date = (empty($search['to_date']))? '1': "create_date <= '".$search['to_date']." 23:59:59'";
    	$where = "  AND ".$from_date." AND ".$to_date ;
    	$sql = " SELECT * ,
					sender_name,
					tel,acc_no
					FROM cs_withdraw AS wd,cs_sender AS s
					WHERE s.sender_id = wd.sender_id ";
    
    	if($search['sender']>0){
    		$where.=" AND wd.sender_id = ".$search['sender'];
    	}
    	if (!empty($search['txt_search'])){
    		$s_where = array();
    		$s_where[] = "tel LIKE '%{$search['txt_search']}%'";
    		$s_where[] = "acc_no LIKE '%{$search['txt_search']}%'";
    		$where .=' AND ('.implode(' OR ',$s_where).')';
    	}else{
    		//$where_date=" WHERE 1 ".$where_date;
    	}
    
    	if ($search['type_money'] > 0){
    		if($search['type_money']==1){
    			$where.= ' AND wd_amountdollar >0 ';
    		}
    		else if($search['type_money']==2){
    			$where.= ' AND wd_amountbath >0 ';
    		}
    		else{
    			$where.= ' AND wd_amountriel >0 ';
    		}
    	}
    	return $sql.$where;
    }
    function getTranWithDrawListBy($search, $start, $limit){
    	$db = $this->getAdapter();
    	$orderby = " ORDER BY id DESC";
    
    	$sql = $this->_queryWithdraw($search).$orderby." LIMIT ".$start.", ".$limit;
    	if ($limit == 'All') {
    		$sql = $this->_queryWithdraw($search).$orderby;
    	}
//     	echo $sql;
    	return $db->fetchAll($sql);
    }
    function getTranWithDrawListTotal($search=''){
    	$db = $this->getAdapter();
    	$sql = $this->_queryWithdraw();
    	 
    	if(!empty($search)){
    		$sql = $this->_queryWithdraw($search);
    	}
    	$_result = $db->fetchAll($sql);
    	return count($_result);
    }
    public function getTranWithDrawById($tran_id){
    	$db = $this->getAdapter();
    		$sql = "SELECT * FROM cs_withdraw WHERE id = $tran_id limit 1";
    		return $db->fetchRow($sql);
    }
    public function editWithDrawById($data){
    	try{
    		//print_r($data);exit();
    		$db = $this->getAdapter();
    		$db->beginTransaction();
    		$old_rs = $this->getTranWithDrawById($data['tran_id']);
    		if(!empty($old_rs['wd_amountdollar'])){
    			$rows =$this->getMoneyInAccountBySender($data['old_sender'],1);//get all transaction deposite
    			foreach ($rows AS $r=>$row){
    				$arr = array(
    						'money_inaccount'=>$row['money_inaccount']+$old_rs['wd_amountdollar']
    						);
    				$where = $db->quoteInto('id=?', $row['id']);
    				$this->update($arr, $where);
    				break;
    			}
    		}
    		if(!empty($old_rs['wd_amountbath'])){
    			$rows =$this->getMoneyInAccountBySender($data['old_sender'],2);
    			foreach ($rows AS $r=>$row){
    				$arr = array(
    						'money_inaccount'=>$row['money_inaccount']+$old_rs['wd_amountbath']
    				);
    				$where = $db->quoteInto('id=?', $row['id']);
    				$this->update($arr, $where);
    				break;
    			}
    		}
    		if(!empty($old_rs['wd_amountriel'])){
    			$rows =$this->getMoneyInAccountBySender($data['old_sender'],3);
    			foreach ($rows AS $r=>$row){
    				$arr = array(
    						'money_inaccount'=>$row['money_inaccount']+$old_rs['wd_amountriel']
    				);
    				$where = $db->quoteInto('id=?', $row['id']);
    				$this->update($arr, $where);
    				break;
    			}
    		}
    		$this->upDateCapitalDetailById($data['tran_id'],7);
    		
    		$this->_name='cs_withdraw';
    		$where = 'id = '.$data['tran_id'];
    		$this->delete($where);
    		$this->AddTransactionWithDraw($data);
    		
    		$db->commit();
    
    	}catch(Exception $e){
    		$db->rollBack();
    		echo $e->getMessage();exit();
    	}
    }
    function upDateCapitalDetailById($tran_id,$tran_type){//for record capital detail by id
    	$db = $this->getAdapter();
    	$this->_name='cs_capital_detail';
    	$sql = " SELECT * FROM ". $this->_name ." WHERE tran_id = $tran_id AND tran_type = $tran_type AND status=1 ";
    	$rs =  $db->fetchAll($sql);
    	$dbc = new Application_Model_DbTable_DbCapital();
    	if(!empty($rs)){
    		foreach ($rs as $key =>$row){
    			$rs_cap = $dbc->DetechCapitalExist($row['user_id'], $row['curr_type'],null);
    			if(!empty($rs_cap)){//update old user
    				$arr = array(
    						'amount'=>$rs_cap['amount']+$row['amount']
    				);
    				$dbc->updateCurrentBalanceById($rs_cap['id'],$arr);
    			}else{
    				$date = date("Y-m-d H:i:s");
    				$arr =array(
    						'amount'=>$row['amount'],
    						'currencyType'=>$row['type_money'],
    						'userid'=>$row['user_id'],
    						'statusDate'=>$date
    				);
    				$dbc->AddCurrentBalanceById($arr);
    			}
    			
    		}
    	$where = "tran_id = $tran_id AND tran_type = $tran_type ";
    	$this->delete($where);
    		
    	}
    }
    public function AddTransactionWithDraw($data){//after delete withdraw then after add withdraw
    	$this->_name='cs_withdraw';
    	$session_user=new Zend_Session_Namespace('auth');
    	$user_id = $session_user->user_id;
    	if(empty($data['withdraw_dollar'])){
    		$w_dollar = 0;
    	}else{
    		$w_dollar =$data['withdraw_dollar'] ;
    		$rs_dollar = $this->getMoneyInAccountBySender($data['sender'],1);
    		$this->updateOldDeposit($w_dollar,$rs_dollar);
    	}
    	if(empty($data['withdraw_bath'])){
    		$w_bath = 0;
    	}else{
    		$w_bath =$data['withdraw_bath'];
    		$rs_bath = $this->getMoneyInAccountBySender($data['sender'],2);
    		$this->updateOldDeposit($w_bath,$rs_bath);
    	}
    	if(empty($data['withdraw_riel'])){
    		$w_riel = 0;
    	}else{
    		$w_riel = $data['withdraw_riel'];
    		$rs_riel = $this->getMoneyInAccountBySender($data['sender'],3);
    		$this->updateOldDeposit($w_riel,$rs_riel);
    	}
    	$this->_name='cs_withdraw';
    	$data = array(
    			'sender_id'=>$data['sender'],
    			'invoice'=>$data['invoice_no'],
    			'wd_amountdollar'=>$w_dollar,
    			'wd_amountbath'=>$w_bath,
    			'wd_amountriel'=>$w_riel,
    			'user_id'=>$user_id,
    			'create_date'=>$data['send_date'],
    	);
    	$id = $this->insert($data);
    	
    	$process = 0;
    	$amount = 0;
    	$dbc = new Application_Model_DbTable_DbCapital();
    	for($i=1; $i<4; $i++){//for add capital detail and update current capital by staff
    		if(!empty($w_dollar) AND $i==1){
    			$process = 1;
    			$curr_type = 1;
    			$amount = $w_dollar;
    		}elseif(!empty($w_bath) AND $i==2){
    			$process = 1;
    			$curr_type = 2;
    			$amount = $w_bath;
    		}elseif(!empty($w_riel) AND $i==3){
    			$process = 1;
    			$curr_type = 3;
    			$amount = $w_riel;
    		}
    		if($process==1){//with draw tran_type = 7
    			$_arr = array(
    					'tran_id' 	=>$id,
    					'tran_type' =>7,
    					'curr_type'	=>$curr_type,
    					'amount'	=>-$amount,//cos withdraw money to customer
    					'user_id'	=>$user_id
    			);
    	
    			$dbc->addMoneyToCapitalDetail($_arr);
    			 
    			$rs = $dbc->DetechCapitalExist($user_id, $curr_type,null);
    			if(!empty($rs)){//update old user
    				$arr = array(
    						'amount'=>$rs['amount']-$amount
    				);
    				$dbc->updateCurrentBalanceById($rs['id'],$arr);
    			}else{
    				$date = date("Y-m-d H:i:s");
    				$arr =array(
    						'amount'=>-$amount,
    						'currencyType'=>$curr_type,
    						'userid'=>$user_id,
    						'statusDate'=>$date
    				);
    				$dbc->AddCurrentBalanceById($arr);
    			}
    	
    		}
    		 
    		$process = 0;
    	}
    }
    public function getRptDepositKbank($search=null){
    	
    	$session_user=new Zend_Session_Namespace('auth');
//     	$current_date = date("Y-m-d");
    	$from_date =(empty($search['from_date']))? '1': "start_date >= '".$search['from_date']." 00:00:00'";
    	$to_date = (empty($search['to_date']))? '1': "start_date <= '".$search['to_date']." 23:59:59'";
    	
    	$where = " AND (".$from_date." AND ".$to_date.") ";
    	 
    	$sql = " SELECT id, invoice, pay_term, sender_name, tel, acc_no,is_expired,is_extend, start_date, end_date,amount_month, money_type,
    	(SELECT symbol  FROM  `cs_currencies` WHERE id = d.`money_type`) AS symbol,
    	recieve_amount,commission,money_inaccount_org, money_inaccount, d.status
    	FROM  cs_deposit AS d, cs_sender AS s
    	WHERE s.`sender_id` = d.`sender_id` AND is_expired != 1 ";
    	$order = " ORDER BY d.`sender_id`";
    	
    	if (!empty($search['txt_search'])){
    		$s_where = array();
    		$s_where[] = " s.tel LIKE '%{$search['txt_search']}%'";
    		$s_where[] = " s.acc_no LIKE '%{$search['txt_search']}%'";
    		$where .=' AND ('.implode(' OR ',$s_where).')';
    	}

    	
    	if ($search['type_money'] >= 0){
    		$where.= ' AND money_type = '. $search['type_money'];
    	}
    	if ($search['sender_name'] >= 0){
    		$where.= ' AND d.sender_id = '. $search['sender_name'];
    	}
//     	    	echo $sql.$where.$order;
    	$db = $this->getAdapter();
    	return $db->fetchAll($sql.$where.$order);
    }
    public function getRptWithdrawKbank($search=null){
    	 
    $session_user=new Zend_Session_Namespace('auth');
    	$current_date = date("Y-m-d");
    	$from_date =(empty($search['from_date']))? '1': "create_date >= '".$search['from_date']." 00:00:00'";
    	$to_date = (empty($search['to_date']))? '1': "create_date <= '".$search['to_date']." 23:59:59'";
    	$where = "  AND ".$from_date." AND ".$to_date ;
    	$sql = " SELECT * ,
					sender_name,
					tel,acc_no
					FROM cs_withdraw AS wd,cs_sender AS s
					WHERE s.sender_id = wd.sender_id ";
    
    	if($search['sender_name']>0){
    		$where.=" AND wd.sender_id = ".$search['sender_name'];
    	}
    	if (!empty($search['txt_search'])){
    		$s_where = array();
    		$s_where[] = "tel LIKE '%{$search['txt_search']}%'";
    		$s_where[] = "acc_no LIKE '%{$search['txt_search']}%'";
    		$where .=' AND ('.implode(' OR ',$s_where).')';
    	}
//else{
//     		//$where_date=" WHERE 1 ".$where_date;
//     	}
    
    	if ($search['type_money'] > 0){
    		if($search['type_money']==1){
    			$where.= ' AND wd_amountdollar >0 ';
    		}
    		else if($search['type_money']==2){
    			$where.= ' AND wd_amountbath >0 ';
    		}
    		else{
    			$where.= ' AND wd_amountriel >0 ';
    		}
    	}
    	
    	$db = $this->getAdapter();
    	//echo $sql.$where;
    	return $db->fetchAll($sql.$where);
    }
    public function getSenderIdbyName($sender_name){
    	$db = $this->getAdapter();
    	$sql = "SELECT sender_id 
    		FROM `cs_sender` WHERE sender_name ='".$sender_name."' LIMIT 1";
    	return $db->fetchOne($sql);
    }

	
	
}


