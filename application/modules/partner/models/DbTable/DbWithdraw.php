<?php 
Class Partner_Model_DbTable_DbWithdraw extends zend_db_Table_Abstract{
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
			if($data['remain_dollar']!=''){
				$arr_update = array(
						'cash_dollar'=>$data['remain_dollar'],
				);
			
				$this->_name="cms_partner";
				$where = $this->getAdapter()->quoteInto('id=?', $data['namesend']);
				$this->update($arr_update, $where);
			}
			if($data['remain_bath'] !=''){
				$arr_update = array(
						'cash_bath'=>$data['remain_bath'],
				);
					
				$this->_name="cms_partner";
				$where = $this->getAdapter()->quoteInto('id=?', $data['namesend']);
				$this->update($arr_update, $where);
			}
			if($data['remain_riel']!=''){
				$arr_update = array(
						'cash_riel'=>$data['remain_riel'],
				);
					
				$this->_name="cms_partner";
				$where = $this->getAdapter()->quoteInto('id=?', $data['namesend']);
				$this->update($arr_update, $where);
			}

		}
		function getAllwithdraw($search=null){
			$db=$this->getAdapter();
			$from_date =(empty($search['start_date']))? '1': "date >= '".$search['start_date']." 00:00:00'";
			$to_date = (empty($search['end_date']))? '1': "date <= '".$search['end_date']." 23:59:59'";
			$where = " WHERE ".$from_date." AND ".$to_date;
			$sql="SELECT id,(SELECT `account_no` FROM cms_partner WHERE id = partner_id) AS `account_no`,			
				date,note,dollar_before,bath_before,riel_before,withdraw_dollar,
				withdraw_bat,withdraw_riel FROM cms_withdraw";
			if(!empty($search['adv_search'])){
				$s_where = array();
				$s_search = $search['adv_search'];
				//print_r($s_search);exit();
				$s_where[] = "date LIKE '%{$s_search}%'";
				$s_where[]="  note LIKE '%{$s_search}%'";
				$s_where[]="id LIKE '%{$s_search}%'";
				$s_where[]="dollar_before LIKE '%{$s_search}%'";
				$s_where[]="bath_before LIKE '%{$s_search}%'";
				$where .=' AND ('.implode(' OR ',$s_where).')';
			}
			if($search['status_search']>-1){
				$where.= " AND status = ".$search['status_search'];
			}
			if(!empty($search['main_branch'])){
				$where.=" AND parent= ".$search['main_branch'];
			}
			//echo $sql.$where;
			$order = " ORDER BY ID DESC ";
			return $db->fetchAll($sql.$where.$order);
		//	return $db->fetchAll($sql);
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
			if($data['remain_dollar']!=''){
				$arr_update = array(
						'cash_dollar'=>$data['remain_dollar'],
				);
					
				$this->_name="cms_partner";
				$where = $this->getAdapter()->quoteInto('id=?', $data['namesend']);
				$this->update($arr_update, $where);
			}
			if($data['remain_bath'] !=''){
				$arr_update = array(
						'cash_bath'=>$data['remain_bath'],
				);
					
				$this->_name="cms_partner";
				$where = $this->getAdapter()->quoteInto('id=?', $data['namesend']);
				$this->update($arr_update, $where);
			}
			if($data['remain_riel']!=''){
				$arr_update = array(
						'cash_riel'=>$data['remain_riel'],
				);
					
				$this->_name="cms_partner";
				$where = $this->getAdapter()->quoteInto('id=?', $data['namesend']);
				$this->update($arr_update, $where);
			}
		}
		public function getpartnerById($id){
			$db = $this->getAdapter();
			$sql = "SELECT *,(SELECT `account_no` FROM cms_partner WHERE id = partner_id) AS `account_no`,
			        (SELECT `mobile` FROM cms_partner WHERE id = partner_id) AS `mobile`
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