<?php 
Class Partner_Model_DbTable_DbWithdraw extends zend_db_Table_Abstract
	{
		protected $_name="cms_withdraw";
		function insertWithdraw($data){
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
		}
		function getAllwithdraw($search=null){
			$db=$this->getAdapter();
			$sql="SELECT id,(SELECT partner_brand FROM cms_partner WHERE id=partner_id) AS partner_id,date,note,dollar_before,bath_before,riel_before,withdraw_dollar,
			withdraw_bat,withdraw_riel FROM cms_withdraw ORDER By id";
			return $db->fetchAll($sql);
			
		}
		function updatepartner($data){
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
			//$where=$this->getAdapter()->quoteInto('id=?', $data['id']);
		
			return  $this->update($_partner_data);
		}
		public function getpartnerById($id){
			$db = $this->getAdapter();
			$sql = "SELECT * FROM cms_withdraw WHERE id = ".$db->quote($id);
			$sql.=" LIMIT 1 ";
			$row=$db->fetchRow($sql);
			return $row;
		}
		
	}
?>