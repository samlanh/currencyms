<?php
class Accounting_Model_DbTable_DbExpense extends Zend_Db_Table_Abstract
{
	protected $_name = 'ln_income_expense';
	function addexpense($data){
		$data = array(
				
				'account_name'=>$data['account_name'],
				'total_amount'=>$data['total_amount'],
				'fordate'=>$data['for_date'],
				'disc'=>$data['Description'],
				'date'=>$data['Date'],
				'status'=>$data['Stutas'],
				'tran_type'=>1,
		);
		$this->insert($data);

}
function updatexpense($data){
	//echo $data['id'];exit();
	$arr = array(
				
				'account_name'=>$data['account_name'],
				'total_amount'=>$data['total_amount'],
				'fordate'=>$data['for_date'],
				'disc'=>$data['Description'],
			    'date'=>$data['Date'],
				'status'=>$data['Stutas'],
			    'tran_type'=>1,
			   
				
		);
	$where=" id = ".$data['id'];
	$this->update($arr, $where);
	
}
function getexpensebyid($id){
	$db = $this->getAdapter();
	$sql=" SELECT id,account_name,total_amount,fordate,disc,date,status FROM $this->_name where id=$id ";
	return $db->fetchRow($sql);
}

function getAllExpense($search=null){
	$db = $this->getAdapter();
	$sql=" SELECT id,account_name,total_amount,fordate,disc,date,status FROM $this->_name where tran_type = 1";
	return $db->fetchAll($sql);
}



}