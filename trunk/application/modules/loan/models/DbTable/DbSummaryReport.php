<?php
/**
 * @Date 19/06/2013
 * @author sovann
 * @version 1.0
 */
class Application_Model_DbTable_DbSummaryReport extends Zend_Db_Table_Abstract
{
   protected $_name = 'cs_capital_detail';
   
   public function getAllSummaryTransaction($search=null){
   	$db = $this->getAdapter();
   	
   	$session_user=new Zend_Session_Namespace('auth');
   	$user_id = $session_user->user_id;
   	 
   	$from_date =(empty($search['from_date']))? '1': " date  >= '".$search['from_date']." 00:00:00'";
   	$to_date = (empty($search['to_date']))? '1': "date  <= '".$search['to_date']." 23:59:59'";
   	$where = " AND ".$from_date." AND ".$to_date;
   	
   	if($session_user->level!=1){
   		$where.= " AND user_id = '".$user_id."' ";
   	}else{
   		if($search['user_id']>-1){
   			$where.= " AND user_id = '".$search['user_id']."' ";
   		}
   	}
   	if($search['tran_type']>-1){
   		$where.=' AND tran_type = '.$search['tran_type'];
   		
   	}
   	$sql = " SELECT 
			  id,
			  tran_id,
			  tran_type,
			  curr_type,
			  SUM(amount) As amount,
			  sign,
			  date,
			  status,
			  income,user_id,
			  (SELECT CONCAT(`last_name`,' ',`first_name`) AS name
				FROM `cs_users` WHERE id=user_id) AS staff_name,
			  (SELECT name FROM `cs_currencies` WHERE country_id=curr_type) AS currency_name
			FROM
			  `cs_capital_detail` 
			WHERE status = 1 $where
			GROUP BY tran_type,
			  curr_type,
			  sign,
			  income,
			  user_id 
			ORDER BY user_id,tran_type,
			  curr_type ,sign DESC ";
   	
//    	echo $sql;
   	return $db->fetchAll($sql);
   }
   public function getTransactionDetailBy($search=null){
   	$db = $this->getAdapter();
   
   	$session_user=new Zend_Session_Namespace('auth');
//    	$user_id = $session_user->user_id;
   	 
   	$from_date =(empty($search['from_date']))? '1': " date  >= '".$search['from_date']." 00:00:00'";
   	$to_date = (empty($search['to_date']))? '1': "date  <= '".$search['to_date']." 23:59:59'";
   	$where = " AND ".$from_date." AND ".$to_date;
   
   	if($session_user->level!=1){
   		$where.= " AND user_id = '".$search['user_id']."' ";
   	}else{
   		if($search['user_id']>-1){
   			$where.= " AND user_id = '".$search['user_id']."' ";
   		}
   	}if($search['tran_id']){
   		$where.= ' AND tran_type = '.$search['tran_id'];
   		
   	}
   	$sql = " SELECT
   	id,
   	tran_id,
   	tran_type,
   	curr_type,
   	amount,
   	sign,
   	date,
   	status,
   	income,user_id,
   	(SELECT CONCAT(`last_name`,' ',`first_name`) AS name
   	FROM `cs_users` WHERE id=user_id) AS staff_name,
   	(SELECT name FROM `cs_currencies` WHERE country_id=curr_type) AS currency_name
   	FROM
   	`cs_capital_detail`
   	WHERE status = 1 $where
   	ORDER BY tran_id ";
//    	   	echo $sql;
   	return $db->fetchAll($sql);
   }
   
}


