<?php
class Accounting_Model_DbTable_DbExpense extends Zend_Db_Table_Abstract
{
	protected $_name = 'ln_income_expense';
	function addexpense($data){
		$data = array(
				'branch_id'=>$data['branch_id'],
				'account_id'=>$data['account_id'],
				'total_amount'=>$data['total_amount'],
				'fordate'=>$data['for_date'],
				'tran_type'=>1,
				'disc'=>$data['Description'],
				'date'=>$data['Date'],
				'status'=>$data['Stutas'],
		);
		$this->insert($data);

}
function updatexpense($data){
	$arr = array(
				'branch_id'=>$data['branch_id'],
				'account_id'=>$data['account_id'],
				'total_amount'=>$data['total_amount'],
				'fordate'=>$data['for_date'],
				'disc'=>$data['Description'],
				'status'=>$data['Stutas'],
			   
				
		);
	$where=" id = ".$data['id'];
	$this->update($arr, $where);
}
function getexpensebyid($id){
	$db = $this->getAdapter();
	$sql=" SELECT id,branch_id,account_id,total_amount,fordate,disc,date,status FROM $this->_name where id=$id ";
	return $db->fetchRow($sql);
}

function getAllExpense($search=null){
	$db = $this->getAdapter();
	$sql=" SELECT id,branch_id,account_id,total_amount,fordate,disc,date,status FROM $this->_name ";
	return $db->fetchAll($sql);
}



}