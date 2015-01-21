<?php
class Tellerandexchange_Model_DbTable_Dbexchange extends Zend_Db_Table_Abstract
{

	protected $_name = 'ln_exchange';
	function addXchange($_data){
		$arr = array(
				'branch_id'=>$_data['branch_id'],
				'invoice_code'=>$_data['number_code'],
				'receive_amount'=>$_data['onetomany'],
				'date'=>$_data['date'],
				'user_id'=>$_data['cusomer'],
				
		);
		$id = $this->insert($arr);
		$this->_name='ln_exchange_detail';
		$ids = explode(',', $_data['record_row']);
		foreach ($ids as $i){
			$arr = array(
				'exchange_id'=>$id,
				'from_currency_type'=>$_data['from_type'.$i],
				'to_currency_type'=>$_data['to_type'.$i],
				'specail_customer'=>empty($_data['is_spacial'.$i])?0:1,
				'exchange_rate'=>$_data['exchange_rate'.$i],
				'changed_amount'=>$_data['exchange_amount'.$i],
				'recieved_amount'=>$_data['amount_exchanged'.$i],
				);
		$this->insert($arr);
		}
	}
	function updatexchange($_data){
		$arr = array(
				'branch_id'=>$_data['branch_id'],
				'invoice_code'=>$_data['number_code'],
				'receive_amount'=>$_data['onetomany'],
				'date'=>$_data['date'],
				'user_id'=>$_data['cusomer'],
				
		);
		$where=" id = ".$_data['id'];
		$this->update($arr, $where);
	}
	///for sigle exchange:
	function getAllExchangeList(){
		$db = $this->getAdapter();
		$sql = "SELECT id ,
		(SELECT name_en FROM `ln_client` WHERE client_id= customer_id LIMIT 1) AS client_name
		,date,invoice_code
		,(SELECT from_to FROM `ln_exchange_detail` WHERE exchange_id = id LIMIT 1) AS from_to
		,(SELECT from_amount FROM `ln_exchange_detail` WHERE exchange_id = id LIMIT 1) AS from_amount
		,(SELECT exchange_rate FROM `ln_exchange_detail` WHERE exchange_id = id LIMIT 1) AS exchange_rate
		,(SELECT to_amount FROM `ln_exchange_detail` WHERE exchange_id = id LIMIT 1) AS to_amount
		,receive_amount,return_amount
		,(SELECT name_en FROM `ln_view` WHERE TYPE=12 AND key_code=is_single LIMIT 1) as exchange_type
		,status 
		FROM `ln_exchange`";
		return $db->fetchAll($sql);
	}
	function saveExchange($data){//for save exchange sigle
		$session_user=new Zend_Session_Namespace('auth');
		$data["to_amount_type"] =$data['exchangeto'];
		$db = $this->getAdapter();
		$db->beginTransaction();
		try {
			$user_id = $session_user->user_id;
			$_data = array(
				//'branch_id'=>$data['branch_id'],
				'customer_id'=>0,
				'is_single'=>1,
				'receive_amount'=>$data['recieve_money'],
				'return_amount'=>$data['return_money'],
				'invoice_code'=>$data['inv_no'],
				'date'=>date("Y-m-d"),
				'user_id'=>$user_id,
				'status'=>1
			);
			$x_id = $this->insert($_data);
			$to_type = $this->getCurrencyById("`curr_nameen`, `symbol`", $data["to_amount_type"]);
			$from_type = $this->getCurrencyById("`curr_nameen`, `symbol`", $data["exchangefrom"]);
	
				$x_detail = array(
						'exchange_id'=>$x_id,//
						'changed_amount'=>$data['to_amount'],//
						'from_amount'=>$data['from_amount'],//
						'rate'=>0,
						'recieved_amount'=>$data['recieve_money'],//
						'status'=>1,//
						'date'=>date("Y-m-d"),//
						'to_amount'=>$data['to_amount'],//
						'to_currency_type'=>$data["to_amount_type"],//
						'from_currency_type'=>$data["exchangefrom"],//
						'from_to'=>$from_type['curr_nameen'] . " - " . $to_type["curr_nameen"],//
						'recieved_type'=>$from_type["symbol"],//
						'specail_customer'=>(empty($data['special_cus']))? 0 : 1//
				);
			$this->_name='ln_exchange_detail';
			$this->insert($x_detail);
			return  $db->commit();
		} catch (Exception $e) {
			$db->rollBack();
			echo $e->getMessage();
		}
	}
	function getCurrencyById($fieldname,$id){
		$db = $this->getAdapter();
		$sql = "SELECT ". $fieldname ."
		FROM `ln_currency`
		WHERE id = ". $id;
// 		    	echo $sql; exit();
		return $db->fetchRow($sql);
	}
function getexpensebyid($id){
	$db = $this->getAdapter();
	$sql=" SELECT id,branch_id,invoice_code,receive_amount,date,user_id FROM $this->_name where id=$id ";
	return $db->fetchRow($sql);
}
}
?>