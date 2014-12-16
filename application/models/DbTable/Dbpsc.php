<?php

class Application_Model_DbTable_Dbpsc extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_pscamount';
	public function clearUserLogined($pc_name){
		$_pcname = md5($pc_name);
		$where = $this->getAdapter()->quoteInto('pc_name = ?', $_pcname);
		$this->delete($where);
	}
	function _querycapital($search =null){
		$session_user=new Zend_Session_Namespace('auth');
		$current_date = date("Y-m-d");
		$from_date =(empty($search['from_date']))? '1': "date >= '".$search['from_date']." 00:00:00'";
		$to_date = (empty($search['to_date']))? '1': " date <= '".$search['to_date']." 23:59:59'";
		$where = "  AND ".$from_date." AND ".$to_date ;
		 
		$sql = "
		
		SELECT id,
		(SELECT CONCAT(first_name,' ',last_name) FROM cs_users AS c WHERE c.id = user_id ) AS staff_name,
		currency_type,volum,psc_amount,note, date,user_id FROM `cs_pscamount` WHERE status =1";
	
		if($search['staff_name']>0){
			$where.=" AND user_id = ".$search['staff_name'];
		}
		if ($search['type_money'] > 0){
			$where.= ' AND currency_type ='.$search['type_money'];
		}
		return $sql.$where;
	}
	function getPscAmountListBy($search, $start, $limit){
		$db = $this->getAdapter();
		$orderby = " ORDER BY id DESC";
	
		$sql = $this->_querycapital($search).$orderby." LIMIT ".$start.", ".$limit;
		if ($limit == 'All') {
			$sql = $this->_querycapital($search).$orderby;
		}
		return $db->fetchAll($sql);
	}
	function getAllPscList($search=''){
		$db = $this->getAdapter();
		$sql = $this->_querycapital();
	
		if(!empty($search)){
			$sql = $this->_querycapital($search);
		}
		$_result = $db->fetchAll($sql);
		return count($_result);
	}
	public function deleteRecordpsc($id){
		$where = 'id = '.$id;
		return $this->delete($where);
		
	}
	public function countAllStaffpcsAmount($search){
		$db = $this->getAdapter();		
		$session_user=new Zend_Session_Namespace('auth');
		$current_date = date("Y-m-d");
		$from_date =(empty($search['from_date']))? '1': "date >= '".$search['from_date']." 00:00:00'";
		$to_date = (empty($search['to_date']))? '1': " date <= '".$search['to_date']." 23:59:59'";
		$where = "  AND ".$from_date." AND ".$to_date ;
		
		$sql = " SELECT currency_type,volum, user_id,SUM(psc_amount) AS psc_amount ,
		(SELECT CONCAT(first_name,' ',last_name) FROM cs_users AS c WHERE c.id = user_id ) AS staff_name
		FROM `cs_pscamount`
		  WHERE status=1 ";
		$order=" GROUP BY user_id,currency_type,volum,date 
				 ORDER BY user_id,currency_type,volum,date";
		if($search['staff_name']>0){
			if($session_user->level==1){
				$where.=" AND user_id = ".$search['staff_name'];
			}else{
				$where.=" AND user_id = ".$session_user->user_id;
			}
		}else{
			if($session_user->level!=1){
				$where.=" AND user_id = ".$session_user->user_id;
			}
			
		}
		if ($search['type_money'] > 0){
			$where.= ' AND currency_type ='.$search['type_money'];
		}
// 		echo $sql.$where.$order;
		return $db->fetchAll($sql.$where.$order);
	}

}

