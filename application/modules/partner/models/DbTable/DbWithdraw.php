<?php 
Class Partner_Model_DbTable_DbWithdraw extends zend_db_Table_Abstract{
	protected $_name="cms_withdraw";
	function insertWithdraw($data){
		 //   print_r($data['namesend']);exit();
			$arr=array(
					'partner_id'=>$data['namesend'],
					'date'=>$data['daydokmoney'],
					'note'=>$data['note'],
					'dollar_before'=>$data['curr_dollar'],
					'bath_before'=>$data['curr_bath'],
					'riel_before'=>$data['curr_riel'],
					'withdraw_dollar'=>$data['withdraw_dollar'],
					'withdraw_bat'=>$data['withdraw_bath'],
					'withdraw_riel'=>$data['withdraw_riel'],
			);
			$this->insert($arr);
			
			$arr_update=array(
					'cash_dollar'=>$data['remain_dollar'],
					'cash_bath'=>$data['remain_bath'],
					'cash_riel'=>$data['remain_riel'],					
			);
			$this->_name = "cms_partner";
			$where = $this->getAdapter()->quoteInto('id=?', $data['namesend']);
			$this->update($arr_update, $where);
		}
		function getAllwithdraw($search=null){
			$db=$this->getAdapter();
			$sql="SELECT id,(SELECT `account_no` FROM cms_partner WHERE id = partner_id) AS `account_no`,			
				date,note,dollar_before,bath_before,riel_before,withdraw_dollar,
				withdraw_bat,withdraw_riel FROM cms_withdraw ORDER By id";
			return $db->fetchAll($sql);
		}
		function updatewithdraw($data){
			$_partner_data=array(
					'partner_id'=>$data['namesend'],
					'date'=>$data['daydokmoney'],
					'note'=>$data['note'],
					'dollar_before'=>$data['curr_dollar'],
					'bath_before'=>$data['curr_bath'],
					'riel_before'=>$data['curr_riel'],
					'withdraw_dollar'=>$data['withdraw_dollar'],
					'withdraw_bat'=>$data['withdraw_bath'],
					'withdraw_riel'=>$data['withdraw_riel'],
			);
			$where="partner_id=".$data['namesend'];
			$this->update($_partner_data,$where);
		}
		public function getpartnerById($id){
			$db = $this->getAdapter();
			$sql = "SELECT *,(SELECT `account_no` FROM cms_partner WHERE id = partner_id) AS `account_no`
					FROM cms_withdraw WHERE id = ".$db->quote($id);
			$sql.=" LIMIT 1 ";
			$row=$db->fetchRow($sql);
			return $row;
		}
		public function getNewAccountNumber(){
			$this->_name='cms_partner';
			$db = $this->getAdapter();
			$sql=" SELECT id ,account_no FROM $this->_name ORDER BY id DESC LIMIT 1 ";
			$acc_no = $db->fetchOne($sql);
			$new_acc_no= (int)$acc_no+1;
			$acc_no= strlen((int)$acc_no+1);
			$pre = "";
			for($i = $acc_no;$i<5;$i++){
				$pre.='0';
			}
			return $pre.$new_acc_no;
		}
		public function getNameFillterParent($id){
			$db=$this->getAdapter();
			$sql="SELECT `account_no`,`mobile`,`cash_dollar`,`cash_bath`,`cash_riel` FROM cms_partner WHERE id = $id";
			return $db->fetchRow($sql);
		}
	}
?>