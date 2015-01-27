<?php
class Accounting_Model_DbTable_DbAsset extends Zend_Db_Table_Abstract
{
	protected $_name = 'ln_fixed_asset';
	function addasset($data){
		$arr = array(
				'branch_id'=>$data['branch'],
				'fixed_assetname'=>$data['asset_name'],
				'fixed_asset_type'=>$data['asset_type'],
				'asset_cost'=>$data['asset_cost'],
				'asset_code'=>$data['asset_code'],
				'pay_type'=>$data['paid_type'],
				'status'=>$data['status'],
				'usefull_life'=>$data['usefull_life'],
				'salvagevalue'=>$data['salvage_value'],
				'payment_method'=>$data['payment_method'],
				'date'=>$data['date'],
				'depreciation_start'=>$data['start_date'],
				'some_payamount'=>$data['some_payamount'],
				'note'=>$data['note']
		);
		 $this->insert($arr);
}
function updatasset($data){
		$arr = array(
				'branch_id'=>$data['branch'],
				'fixed_assetname'=>$data['asset_name'],
				'fixed_asset_type'=>$data['asset_type'],
				'asset_cost'=>$data['asset_cost'],
				'asset_code'=>$data['asset_code'],
				'pay_type'=>$data['paid_type'],
				'status'=>$data['status'],
				'usefull_life'=>$data['usefull_life'],
				'salvagevalue'=>$data['salvage_value'],
				'payment_method'=>$data['payment_method'],
				'date'=>$data['date'],
				'depreciation_start'=>$data['start_date'],
				'some_payamount'=>$data['some_payamount'],
				'note'=>$data['note']
		);
	$where=" id = ".$data['id'];
	$this->update($arr, $where);
}
function getassetbyid($id){
	$db = $this->getAdapter();
	$sql=" SELECT id,
 	branch_id,fixed_assetname,fixed_asset_type,asset_cost,asset_code,pay_type,
	status,usefull_life,salvagevalue,payment_method,date,depreciation_start,some_payamount,note FROM $this->_name where id=$id ";
	return $db->fetchRow($sql);
}

function getAllAsset($search=null){
	$db = $this->getAdapter();
	$sql=" SELECT id,
	(SELECT branch_namekh FROM ln_branch WHERE br_id = branch_id limit 1)as branch_name,fixed_assetname,fixed_asset_type,asset_cost,usefull_life,salvagevalue,payment_method ,status,note FROM $this->_name ";
	return $db->fetchAll($sql);
}



}