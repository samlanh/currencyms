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
//    	echo $sql; exit();
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
    		return  $db->commit();
    	} catch (Exception $e) {
    		$db->rollBack();
    		echo $e->getMessage();exit();
    		
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
    	
    	$db = $this->getAdapter();
    	try {
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
    		     );
    		$where=$this->getAdapter()->quoteInto('id=?', $data['id']);
    		$this->update($_data, $where);
    	} catch (Exception $e) {
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
    	e.`recieptNo`,
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
    	//echo $sql;
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


