<?php 
Class Partner_Model_DbTable_DbDeposite extends zend_db_Table_Abstract{
	protected $_name="cms_partner_deposit";
	public function getUserId(){
		$session_user=new Zend_Session_Namespace('auth');
		return $session_user->user_id;
	}
	function partnerDeposite($data){
		$db=$this->getAdapter();
		$arr=array(
				'partner_id'=>$data['name_partner'],
				'date'=>$data['creat_date'],
				'note'=>$data['moneyinaccount'],
				'invoice'=>$data['num_invoice'],
				'user_id'=>$this->getUserId(),
				);
		$id=$this->insert($arr);
		//print_r($id);exit();
		//print_r($id);exit();
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
	function getAllDeposite($search=null){
	$db = $this->getAdapter();
	$sql=" SELECT id,invoice,
	(SELECT partner_brand FROM cms_partner WHERE id = partner_id) AS partner_name,date,	note
	 FROM $this->_name  WHERE 1   ";
	$where = '';
	if(!empty($search['adv_search'])){
		$s_where = array();
		$s_search = $search['adv_search'];
		$s_where[] = "note LIKE '%{$s_search}%'";
		$s_where[]="  invoice LIKE '%{$s_search}%'";
		$s_where[]="id LIKE '%{$s_search}%'";
		$s_where[]="date LIKE '%{$s_search}%'";
		//$s_where[]="partner_brand LIKE '%{$s_search}%'";
		$where .=' AND ('.implode(' OR ',$s_where).')';
	}
	if($search['status_search']>-1){
		$where.= " AND status = ".$search['status_search'];
	}
	if(!empty($search['name_partner'])){
		//print_r($search['name_partner']);exit();
		$where.=" AND partner_id= ".$search['name_partner'];
	}
	echo $sql.$where;
	return $db->fetchAll($sql.$where);
	//return $db->fetchAll($sql);
	}
	function updateDeposite($data){
		$db = $this->getAdapter();
		$db->beginTransaction();
		//update cms_partner_deposit
		try{
	        $arr=array(
						'partner_id'=>$data['name_partner'],
						'date'=>$data['creat_date'],
						'note'=>$data['moneyinaccount'],
						'invoice'=>$data['num_invoice']
				);
	        $where=" id =".$data['id'];
				//print_r($where);exit();
	        $db->getProfiler()->setEnabled(true);
			$this->update($arr, $where);
			
			Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQuery());
			Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
			$db->getProfiler()->setEnabled(false);
		
			
			// Update cms_partnerdeposit_detail before new insert
			$where = " pd_id = ".$data['id'];
					//	print_r($where);exit();
			$_arr = array('status'=>0);
			$this->_name='cms_partnerdeposit_detail';
			$db->getProfiler()->setEnabled(true);
			$this->update($_arr,$where);
// 			Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQuery());
// 			Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
// 			$db->getProfiler()->setEnabled(false);
			
			// Insert new cms_partnerdeposit_detail
			$ids = explode(',',$data['record_row']);
			print_r($ids);
			foreach ($ids as $i){
				$arr = array(
						'pd_id'=>$data['id'],
						'date'=>$data['date_'.$i],
						'currency_type'=>$data['currency_type_'.$i],
						'deposite_amount'=>empty($data['amount_'.$i])?0:1,
						'receive_amount'=>$data['recieve_'.$i],
						'return_amount'=>$data['return_'.$i],
						'note'=>$data['note_'.$i],
				);
				$db->getProfiler()->setEnabled(true);
				
				$this->insert($arr);
				
// 				Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQuery());
// 				Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
// 				$db->getProfiler()->setEnabled(false);
			}
// 			exit();
			$db->commit();
		}catch (Exception $e){
			$db->rollBack();
			echo $e->getMessage();exit();
		}
	}
	public function getpartnerById($id){
		$db = $this->getAdapter();
		$sql = "SELECT *,(SELECT `account_no` FROM cms_partner WHERE id = partner_id) AS `account_no`,
		(SELECT `cash_riel` FROM cms_partner WHERE id = partner_id) AS `cash_riel`,
		(SELECT `cash_bath` FROM cms_partner WHERE id = partner_id) AS `cash_bath`,
		(SELECT `cash_dollar` FROM cms_partner WHERE id = partner_id) AS `cash_dollar`
		 FROM cms_partner_deposit WHERE id = ".$db->quote($id);
		$sql.=" LIMIT 1 ";
		$row=$db->fetchRow($sql);
		return $row;
	}
	
	public function getdepositedetail($id){
		$db = $this->getAdapter();
		$sql = "SELECT * FROM cms_partnerdeposit_detail WHERE pd_id = ".$db->quote($id) .' AND status=1';
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
	public function getAutonumber(){
		$this->_name='cms_partner_deposit';
		$db = $this->getAdapter();
		$sql=" SELECT id ,invoice FROM $this->_name ORDER BY id DESC LIMIT 1 ";
		$invoice = $db->fetchOne($sql);
		$new_invoice= (int)$invoice+1;
		$invoice= strlen((int)$invoice+1);
		$pre = "";
		for($i = $invoice;$i<7;$i++){
			$pre.='0';
		}
		return $pre.$new_invoice;
	}
}

?>