<?php 
Class Partner_Model_DbTable_DbDeposite extends zend_db_Table_Abstract{
	protected $_name="cms_partner_deposit";
	public function getUserId(){
		$session_user=new Zend_Session_Namespace('auth');
		return $session_user->user_id;
	}
	function partnerDeposite($data){
		$arr=array(
				'partner_id'=>$data['name_partner'],
				'date'=>$data['creat_date'],
				'note'=>$data['moneyinaccount'],
				'invoice'=>$data['num_invoice'],
				'user_id'=>$this->getUserId(),
				
				);
		$id=$this->insert($arr);
		$this->_name='cms_partnerdeposit_detail';
		$ids = explode(',', $data['record_row']);
		foreach ($ids as $i){
			$arr = array(
					'pd_id'=>$id,
					'date'=>$data['date_'.$i],
					'currency_type'=>$data['currency_type_'.$i],
					'deposite_amount'=>$data['amount_'.$i],
					'receive_amount'=>$data['recieve_'.$i],
					'return_amount'=>$data['return_'.$i],
					'note'=>$data['note_'.$i],
			);
			$this->insert($arr);
		}
		}
	function getAllDeposite(){
	$db = $this->getAdapter();
	$sql=" SELECT id,invoice,
	(SELECT partner_brand FROM cms_partner WHERE id=partner_id) AS partner_name,
	date,
	note
	 FROM $this->_name ORDER BY id DESC";
	return $db->fetchAll($sql);
	}
	function updateDeposite($data){
	$_partner_data=array(
			'partner_id'=>$data['name_partner'],
			'date'=>$data['creat_date'],
			'note'=>$data['moneyinaccount'],
			'invoice'=>$data['num_invoice'],
	);
	return  $this->update($_partner_data);
	}
	public function getpartnerById($id){
		$db = $this->getAdapter();
		$sql = "SELECT * FROM cms_partner_deposit WHERE id = ".$db->quote($id);
		$sql.=" LIMIT 1 ";
		$row=$db->fetchRow($sql);
		return $row;
	}
	public function getdepositedetail($id){
		$db = $this->getAdapter();
		$sql = "SELECT * FROM cms_partnerdeposit_detail WHERE pd_id = ".$db->quote($id);
		$row=$db->fetchAll($sql);
		return $row;
	}
	public function getGroupDepositeDetail($id){ 
		$db = $this->getAdapter();
		$sql = "SELECT currency_type, sum(deposite_amount) AS amount
			 FROM cms_partnerdeposit_detail WHERE pd_id = ".$db->quote($id);
		$sql.=" GROUP BY currency_type ORDER BY date LIMIT 3";
		$row=$db->fetchAll($sql);
		return $row;
	}
}

?>