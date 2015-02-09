<?php
class Accounting_Model_DbTable_DbIncome extends Zend_Db_Table_Abstract
{
	protected $_name = 'cms_income_expense';
	function addasset($data){
		$data = array(
				
				'account_name'=>$data['account_name'],
				'total_amount'=>$data['total_amount'],
				'currency_type'=>$data['currency_type'],
				'fordate'=>$data['for_date'],
				'disc'=>$data['Description'],
				'date'=>$data['Date'],
				'status'=>$data['Stutas'],
				'tran_type'=>2,
				
		);
		$this->insert($data);

}
function updatasset($data){
	$arr = array(
				
				'account_name'=>$data['account_name'],
				'total_amount'=>$data['total_amount'],
			    'currency_type'=>$data['currency_type'],
				'fordate'=>$data['for_date'],
				'disc'=>$data['Description'],
			    'date'=>$data['Date'],
				'status'=>$data['Stutas'],
			    'tran_type'=>2,
			   
				
		);
	$where=" id = ".$data['id'];
	//     	echo $where;exit();
	$this->update($arr, $where);
}
function getassetbyid($id){
	$db = $this->getAdapter();
	$sql=" SELECT id,account_name,total_amount,currency_type,fordate,disc,date,status FROM $this->_name WHERE id=$id ";
	return $db->fetchRow($sql);
}
function getAllasset($search=null){
	$db = $this->getAdapter();
	$sql=" SELECT id,account_name,total_amount,(SELECT name_kh FROM cms_view WHERE type=2 AND key_code=currency_type) AS currency_type,fordate,disc,date,status FROM $this->_name WHERE tran_type = 2 ";
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
	return $db->fetchAll($sql.$where);
}




}