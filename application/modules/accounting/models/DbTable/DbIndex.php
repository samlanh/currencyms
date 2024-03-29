<?php
class Accounting_Model_DbTable_DbIndex extends Zend_Db_Table_Abstract
{

	function getAllIncomeAndExpense($search=null){
		$db = $this->getAdapter();
		$sql=" 	SELECT id,account_name,total_amount,(SELECT name_kh FROM cms_view WHERE type=2 AND key_code=currency_type limit 1) AS currency_type,
				(SELECT name_kh FROM `cms_moths` WHERE id=fordate) AS fordate,disc,date,status,tran_type FROM `cms_income_expense` 
				WHERE account_name!='' AND total_amount!=0 AND status=1 AND tran_type = 2
				ORDER BY tran_type DESC ,currency_type ASC ,date ";
	
		$where='';
		
		
	if($search['status_search']>-1){
			$where.= " AND status = ".$search['status_search'];
		}
		
		if(!empty($search['for_date_search'])){
			$where.= " AND fordate = ".$search['for_date_search'];
		}
		
		if(!empty($search['adv_search'])){
			$s_where = array();
			$s_search = $search['adv_search'];
			$s_where[] = " account_name LIKE '%{$s_search}%'";
			$s_where[] = " total_amount LIKE '%{$s_search}%'";
			$s_where[] = " currency_type LIKE '%{$s_search}%'";
			$where .=' AND ('.implode(' OR ',$s_where).')';
		}
		return $db->fetchAll($sql);
	}
	public function getTotalRiel(){
		$db = $this->getAdapter();
		$sql = "SELECT SUM(i.total_amount)AS total_amount FROM cms_income_expense AS i WHERE i.`currency_type` = 1 AND `tran_type` = 2";
		return $db->fetchAll($sql);
	}
	public function getTotalDollar(){
		$db = $this->getAdapter();
		$sql = "SELECT SUM(i.total_amount)AS total_amount FROM cms_income_expense AS i WHERE i.`currency_type` = 2 AND `tran_type` = 2";
		return $db->fetchAll($sql);
	}
	public function getTotalBat(){
		$db = $this->getAdapter();
		$sql = "SELECT SUM(i.total_amount)AS total_amount FROM cms_income_expense AS i WHERE i.`currency_type` = 3 AND `tran_type` = 2";
		return $db->fetchAll($sql);
	}
	
}