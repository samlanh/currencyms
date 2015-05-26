<?php 
Class Keeping_Model_DbTable_DbOutmoney extends zend_db_Table_Abstract
	{
	protected $_name="cms_withdraw_keeping";
	function insertWithdrawKeeping($data){
		    // print_r($data);exit();
		    $db=$this->getAdapter();
		    $db->beginTransaction();
		    try{
			$arr=array(
					'client_id'=>$data['namesend'],
					'create_date'=>$data['daydakmoney'],
					'account_number'=>$data['account_number'],
					'phone'=>$data['phone'],
// 					'money_type'=>$data[''],
					'note'=>$data['note'],
					'dollar_before'=>$data['curr_dollar'],
					'bath_before'=>$data['curr_bath'],
					'riel_before'=>$data['curr_riel'],
					'wd_amountdollar'=>$data['withdraw_dollar'],
					'wd_amountbath'=>$data['withdraw_bath'],
					'wd_amountriel'=>$data['withdraw_riel'],
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

			$db->commit();
			}catch (Exception $e){
				$db->rollBack();
				echo $e->getMessage();exit();
			}
		}
		function getAllwithdrawKeeping($search=null){
			$db=$this->getAdapter();
			$from_date =(empty($search['start_date']))? '1': "create_date >= '".$search['start_date']." 00:00:00'";
			$to_date = (empty($search['end_date']))? '1': "create_date <= '".$search['end_date']." 23:59:59'";
			$where = " WHERE ".$from_date." AND ".$to_date;
			$sql="SELECT id,account_number,
			create_date,note,phone,dollar_before,bath_before,riel_before,wd_amountdollar,
			wd_amountbath,wd_amountriel FROM cms_withdraw_keeping";
			if(!empty($search['adv_search'])){
				$s_where = array();
				$s_search = $search['adv_search'];
				$s_where[] = "create_date LIKE '%{$s_search}%'";
				$s_where[]="  note LIKE '%{$s_search}%'";
				$s_where[]="  account_number LIKE '%{$s_search}%'";
				$s_where[]="  phone LIKE '%{$s_search}%'";
				$s_where[]="  wd_amountdollar LIKE '%{$s_search}%'";
				$where.=' AND ('.implode(' OR ',$s_where).')';
			}
			if($search['status_search']>-1){
				$where.= " AND status = ".$search['status_search'];
			}
			if(!empty($search['namesend'])){
				$where.=" AND client_id= ".$search['namesend'];
				
			}
			$order = " ORDER BY ID DESC ";
			//echo $sql.$where.$order;
			return $db->fetchAll($sql.$where.$order);
		}
		
		function getAllPartnerKeeping($id=null,$option=null){
			$order = "ORDER BY partner_brand DESC ";
			$db=$this->getAdapter();
			$sql = " select id,partner_brand,partner_name from cms_partner where status=1 AND is_cashoperation=2 ";
			if($id!=null){
				$sql.=" AND id = $id";
			}
			$rows = $db->fetchAll($sql);
			if($option!=null){
				$opt= (array("" =>"ជ្រើសរើស ឈ្មោះដៃគូ ----"));
				foreach ($rows as $rs){
					 
					$opt[$rs['id']]=$rs['partner_name'];
				}
				return $opt;
		
			}else{
				return $rows.$order;
			}
			 
			 
		}
		function updateWithdrawKeeping($data){
			$db=$this->getAdapter();
			$db->beginTransaction();
			try{
			$arr=array(
					'client_id'=>$data['namesend'],
					'create_date'=>$data['daydakmoney'],
					'account_number'=>$data['account_number'],
					'phone'=>$data['phone'],
					'note'=>$data['note'],
					'dollar_before'=>$data['curr_dollar'],
					'bath_before'=>$data['curr_bath'],
					'riel_before'=>$data['curr_riel'],
					'wd_amountdollar'=>$data['withdraw_dollar'],
					'wd_amountbath'=>$data['withdraw_bath'],
					'wd_amountriel'=>$data['withdraw_riel'],
			);
			$where="client_id=".$data['namesend'];
			$this->update($arr,$where);
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
			$db->commit();
			}catch (Exception $e){
				$db->rollBack();
			 echo $e->getMessage();exit();
			}
		}
		 function getWithdrawKeepingById($id){
			$db = $this->getAdapter();
			$sql = "SELECT *,(SELECT `account_no` FROM cms_partner WHERE id = client_id) AS `account_no`
			FROM cms_withdraw_keeping WHERE id = ".$db->quote($id);
			$sql.=" LIMIT 1 ";
			$row=$db->fetchRow($sql);
			return $row;
		}
	}
?>