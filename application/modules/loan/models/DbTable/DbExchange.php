<?php

class Application_Model_DbTable_DbExchange extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_exchange';
    
    function getDataById($id){
    	$sql ="SELECT
    				  e.`id`, 
					  e.`statusDate`,
    				  e.`specail_customer`,
					  e.`fromAmount`,    				  
					  e.`rate`,
    				  e.`toAmount`,    				  
    				  e.`recievedAmount`,
    				  e.`changedAmount`,
    				  e.`recieptNo`,
    				  e.`status`,
    				  (SELECT c.id FROM cs_currencies AS c WHERE c.symbol =  e.`fromAmountType`) as `fromAmountType`,
    				  (SELECT c.id FROM cs_currencies AS c WHERE c.symbol =  e.`toAmountType`) as `toAmountType`,
					  (SELECT c.`name` FROM cs_currencies AS c WHERE c.symbol = e.`fromAmountType`) AS fromTxtType,
					  (SELECT c.`name` FROM cs_currencies AS c WHERE c.symbol = e.`toAmountType`) AS toTxtType
					FROM
					  `cs_exchange` AS e 
    				WHERE `id` = ".$id;
    	$db = $this->getAdapter();
//     	echo $sql; exit();
    	return $db->fetchRow($sql);
    }
    
    function getCurrencyById($fieldname,$id){
    	$db = $this->getAdapter();
    	$sql = "SELECT ". $fieldname ."
				FROM `cs_currencies`
				WHERE id = ". $id;
//     	echo $sql; exit();
    	return $db->fetchRow($sql);
    } 
    
    function save($data){
    	$this->_name = 'cs_exchange';
    	$session_user=new Zend_Session_Namespace('auth');    	
    	$to_type = $this->getCurrencyById("`name`, `symbol`", $data["to_amount_type"]);
    	$from_type = $this->getCurrencyById("`name`, `symbol`", $data["from_amount_type"]);
    	$status = "in";
    	if(($data["from_amount_type"] == 2 && $data["to_amount_type"] == 1) || $data["from_amount_type"] == 3 ){
    		$status = "out";
    	}
    	$db = $this->getAdapter();
    	$db->beginTransaction();
    	try {
    		$user_id = $session_user->user_id;
    		$_data=array(
    				"changedAmount"=>$data["return_money"],
    				"recieptNo"=>$data["inv_no"],
    				"toAmount"=>$data["to_amount"],
    				"toAmountType"=>$to_type["symbol"],
    				"rate"=>$data["rate"],
    				"fromAmountType"=>$from_type["symbol"],
    				"fromAmount"=>$data["from_amount"],
    				"recievedType"=>$from_type["symbol"],
    				"recievedAmount"=>$data["recieve_money"],
    				"statusDate"=>date('Y-m-d H:i:s'),
    				"userid"=>$user_id,
    				"status"=>$status,
    				"specail_customer"=>(empty($data['special_cus']))? 0 : 1,
    				"from_to"=>$from_type['name'] . " - " . $to_type["name"]
    		);
    		$ex_id = $this->insert($_data);
    		
    		$arr_cd = array(
    				'tran_id'=>$ex_id,
    				'tran_type'=>3,
    				'date'=>date('Y-m-d'),
    				'user_id'=>$user_id,
    		);
    		
    		$db_cap = new Application_Model_DbTable_DbCapital();
    		//from amount 
    		$currency_type = $data["from_amount_type"];
    		$amount = ($data["from_amount"] - $data["return_money"]);
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
    		//end from amount
    		
    		//insert to capital_detail
    		$arr_cd['curr_type']=$currency_type;
    		$arr_cd['amount']=$data["from_amount"];
    		$db_cap->addMoneyToCapitalDetail($arr_cd);
    		
    		//to amount
    		$currency_type = $data["to_amount_type"];
    		$rs = $db_cap->DetechCapitalExist($user_id,$currency_type,null);//check if add capital exist
    		if(!empty($rs)){
    			$arr = array(
    					'amount'=>$rs['amount']-$data["to_amount"]
    			);
    			$db_cap->updateCurrentBalanceById($rs['id'],$arr);
    		}else{
    			$arr =array(
    					'amount'=>-$data["to_amount"],
    					'currencyType'=>$currency_type,
    					'userid'=>$user_id,
    					'statusDate'=>date("Y-m-d H:i:s")
    			);
    			$db_cap->AddCurrentBalanceById($arr);
    		}
    		//end to amount
    		//insert to capital_detail
    		$arr_cd['curr_type']=$currency_type;
    		$arr_cd['amount']=-$data["to_amount"];
    		$db_cap->addMoneyToCapitalDetail($arr_cd);
    		
    		return  $db->commit();
    	} catch (Exception $e) {
    		$db->rollBack();
    		
    	}
    }
    
    /**
     * Update For data exchange
     * @param Array $data
     * @return number
     */
    function updateData($data){
    	$db_cap = new Application_Model_DbTable_DbCapital();
    	$session_user=new Zend_Session_Namespace('auth');
    	$to_type = $this->getCurrencyById("`name`, `symbol`,`country_id`", $data["to_amount_type"]);
    	$from_type = $this->getCurrencyById("`name`, `symbol`,`country_id`", $data["from_amount_type"]);
    	$status = "in";
    	if(($data["from_amount_type"] == 2 && $data["to_amount_type"] == 1) || $data["from_amount_type"] == 3 ){
    		$status = "out";
    	}
    	$_data=array(
    			"changedAmount"=>$data["return_money"],
    			"specail_customer"=>(empty($data['special_cus']))? 0 : 1,
    			"toAmount"=>$data["to_amount"],
    			"toAmountType"=>$to_type["symbol"],
    			"rate"=>$data["rate"],
    			"fromAmountType"=>$from_type["symbol"],
    			"fromAmount"=>$data["from_amount"],
    			"recievedType"=>$from_type["symbol"],
    			"recievedAmount"=>$data["recieve_money"],
    			"statusDate"=>date('Y-m-d H:i:s'),
    			"userid"=>$session_user->user_id,
    			"status"=>$status,
    			"from_to"=>$from_type['name'] . " - " . $to_type["name"]
    	);
    	$result = $this->getDataById($data['id']);
    	$user_id = $session_user->user_id;
    	$db = $this->getAdapter();
    	$db->beginTransaction();
    	try {
	    	if($result){
		    		if($data['from_amount'] != $result['fromAmount']){//if amount has changed
			    		//update to capital_detail
		    			$arr_cdfrom = array(
		    					'curr_type'=>$data["from_amount_type"],
		    					'amount'=>$data["from_amount"],
	    						'date'=>date('Y-m-d'),
		    			);
		    			$capital_detail = $db_cap->getCapitalDetailById($data['id'],3,$data["from_amount_type"]);
		    			$db_cap->updateCapitalDetailById($capital_detail['id'],$arr_cdfrom);
		
		    			$arr_cdto = array(
		    					'curr_type'=>$data["to_amount_type"],
		    					'amount'=>$data["to_amount"],
	    						'date'=>date('Y-m-d'),
		    			);
		    			$capital_detail = $db_cap->getCapitalDetailById($data['id'],3,$data["to_amount_type"]);
		    			$db_cap->updateCapitalDetailById($capital_detail['id'],$arr_cdto);
		    			//*************************************************************
			    		//update to cs_current_capital
			    		$amount = $data["from_amount"] - $data["return_money"];
			    		$to = $data['to_amount']-$result['toAmount'];
			    		$from = $amount - $result['fromAmount'];
			    		$currency_type_from = $data["from_amount_type"];
			    		$currency_type_to = $data["to_amount_type"];
// 			    		print_r($_data);echo "**data<br/>";
// 			    		print_r($result);echo "**result<br/>";
// 			    		echo "to=".$to."<br/>from=".$from."<br/>amount=".$amount."<br/>";
	// 		    		echo $amount." *** ".$amount_to;
	// 		    		exit;
			    		//from amount
			    		$rs = $db_cap->DetechCapitalExist($user_id,$currency_type_from,null);//check if add capital exist
// 			    		print_r($rs);echo "***rs from<br/>";
			    		if(!empty($rs)){
			    			$balan = $rs['amount'] - abs($from);
			    			if($from>0){
			    				$balan = $rs['amount'] + abs($from);
			    			}
			    			$arr = array(
			    					'amount'=>$balan
			    			);
			    			$db_cap->updateCurrentBalanceById($rs['id'],$arr);
			    		}else{
			    			$arr =array(
			    					'amount'=>$data["from_amount"],
			    					'currencyType'=>$currency_type_from,
			    					'userid'=>$user_id,
			    					'statusDate'=>date("Y-m-d H:i:s")
			    			);
			    			$db_cap->AddCurrentBalanceById($arr);
			    		}
// 			    		print_r($arr);echo "**arr from<br/>";
			    		//end from amount
	
			    		//to amount
			    		$rs = $db_cap->DetechCapitalExist($user_id,$currency_type_to,null);//check if add capital exist
// 			    		print_r($rs);echo "***rs to<br/>";
			    		if(!empty($rs)){
			    			$balan = $rs['amount'] + abs($to);
			    			if($from>0){
			    				$balan = $rs['amount'] - abs($to);
			    			}
			    			$arr = array(
			    					'amount'=>$balan
			    			);
			    			$db_cap->updateCurrentBalanceById($rs['id'],$arr);
			    		}else{
			    			$arr =array(
			    					'amount'=>-$data['to_amount'],
			    					'currencyType'=>$currency_type_to,
			    					'userid'=>$user_id,
			    					'statusDate'=>date("Y-m-d H:i:s")
			    			);
			    			$db_cap->AddCurrentBalanceById($arr);
			    		}
// 			    		print_r($arr);echo "**arr to<br/>";exit;
			    		//end to amount
		    		}
				    $this->_name = 'cs_exchange';
			    	$where=$this->getAdapter()->quoteInto('id=?', $data['id']);
			    	$this->update($_data, $where);
	    	}
	//     	return  $this->update($_data, $where);
	    	return  $db->commit();
    	} catch (Exception $e) {
    		$db->rollBack();
    		
    	}
    }
    
    
    function getDataAll($user_id, $from_date, $to_date){
    	$cur_mod = new Application_Model_DbTable_DbCurrencies();
    	$usr_mod = new Application_Model_DbTable_DbUsers();
    	$rsCur = $cur_mod->getCurrencyList();
    	
    	$rsUser = null;
    	$tmp_summary = null;
    	$return_araray = array();
    	
    	if($user_id == -1){    		
    		$rsUser = $usr_mod->getUserListSelect();
    		if(!empty($rsCur)){
    			$tmp_summary = array();
    			foreach ($rsCur AS $k =>$rc){    				
    				$cur_type = $rc['symbol'];
    				$bought = $this->sumValue($cur_type, null, "in", $from_date, $to_date);
    				$sale   = $this->sumValue($cur_type, null, "out", $from_date, $to_date);
    				$tmp_summary[$k]['saleamount'] = $sale;
    				$tmp_summary[$k]['boughtamount'] = $bought;
    				$tmp_summary[$k]['currncytype'] = $rc['name'];
    				$tmp_summary[$k]['currncysymbol'] = $cur_type;
    			}    			
    			$return_araray['summary'] = $tmp_summary;
    		}
    	}
    	else{
    		$rsUser = $usr_mod->getUserInfoByfetchAll($user_id);
    	}
    	//print_r($return_araray); exit();
    	if(!empty($rsUser)){
    		$tmp_data = array();
    		$row_index = 0;
    		foreach ($rsUser as $i => $ru){
    			if(empty($rsCur)) break;    			
    			foreach ($rsCur as $k => $rc){
    				$cur_type = $rc['symbol'];
    				$bought = $this->sumValue($cur_type, $ru['id'], "in", $from_date, $to_date);
    				$sale   = $this->sumValue($cur_type, $ru['id'], "out", $from_date, $to_date);
    				if($bought != 0 ||$sale != 0 ){
	    				$tmp_data[$row_index]['username'] = $ru['name'];
	    				$tmp_data[$row_index]['userid'] = $ru['id'];
	    				$tmp_data[$row_index]['saleamount'] = $sale;
	    				$tmp_data[$row_index]['boughtamount'] = $bought;
	    				$tmp_data[$row_index]['currncytype'] = $rc['name'];
	    				$tmp_data[$row_index]['currncysymbol'] = $cur_type;
	    				$row_index++;
    				}
    			}
    		}
    		if(!empty($tmp_data)){
    			$return_araray['data'] = $tmp_data;
    		}
    	}
    	
    	return $return_araray;    	
    }
    public function getAllExchangeList($search = null){//for rpt exchange summery
    	$session_user=new Zend_Session_Namespace('auth');
    	$user_id = $session_user->user_id;
    	
    	$from_date =(empty($search['from_date']))? '1': " e.statusdate  >= '".$search['from_date']." 00:00:00'";
    	$to_date = (empty($search['to_date']))? '1': "e.statusdate  <= '".$search['to_date']." 23:59:59'";
    	$where = "WHERE ".$from_date." AND ".$to_date;
    	
    	if($session_user->level!=1){
    		$where.= " AND e.userid = '".$user_id."' ";
    	}else{
    		if($search['user_id']>-1){
    			$where.= " AND e.userid = '".$search['user_id']."' ";
    		}
    	}
 	
    	$sql = "SELECT
    	e.`id`,
    	DATE_FORMAT(e.`statusDate`,'%d/%m/%Y') as `statusDate`,
    	e.`from_to`,
    	e.`fromAmount`,
    	e.`rate`,
    	e.`toAmount`,
    	e.`recievedAmount`,
    	e.`changedAmount`,
    	e.`toAmountType`,
    	e.`fromAmountType`,
    	(SELECT CONCAT(`last_name`,' ',`first_name`) AS name
				FROM `cs_users` where id=e.userid) as staff_name
    	FROM
    	`cs_exchange` AS e
    	". $where ."
    	ORDER BY e.`userid` DESC ,e.`statusDate` DESC ";
//     	ORDER BY e.`statusDate` DESC";
    	$db = $this->getAdapter();
//     	echo $sql;
    	return ($db->fetchAll($sql));
    }
    /**
     * Sum amount of exchange money
     * @param stirng $cur_type
     * @param int $user_id
     * @param string $status
     * @param date $from_date
     * @param date $to_date
     * @return number
     */
    function sumValue($cur_type, $user_id, $status, $from_date, $to_date){
    	$sql = "SELECT SUM(";
    	if($status == "in"){
    		$sql .= " fromAmount ";
    	}
    	elseif($status == "out"){
    		$sql .= " toAmount ";
    	}
    	$sql .= ") FROM ". $this->_name;
    	$sql .= " WHERE ";

    	if(!empty($user_id)){
    		$sql .= " userid =". $user_id . " AND ";
    	}
    	
    	if($status == "in"){
    		$sql .= " fromAmountType = ";
    	}
    	elseif($status == "out"){
    		$sql .= " toAmountType = ";
    	}
    	
    	$sql .= " '".$cur_type."' ";
    	
    	if(!empty($from_date) && !empty($to_date)){
    		$sql .= " AND DATE(statusDate) BETWEEN DATE('". $from_date . "') AND DATE('". $to_date . "')";
    	}
    	$db = $this->getAdapter();    	
    	$value = $db->fetchOne($sql);
    	if(!empty($value)){
    		return floatval($value);
    	}
    	return 0;
    }
 	
}


