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
	$from_date =(empty($search['start_date']))? '1': "date >= '".$search['start_date']." 00:00:00'";
	$to_date = (empty($search['end_date']))? '1': "date <= '".$search['end_date']." 23:59:59'";
	$where = " WHERE ".$from_date." AND ".$to_date;
	$order='ORDER BY partner_name DESC ';
	$sql=" SELECT id,invoice,
	(SELECT partner_brand FROM cms_partner WHERE id = partner_id) AS partner_name,date,	note,status
	 FROM $this->_name ";
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
	//echo $sql.$where;
	return $db->fetchAll($sql.$where);
	//return $db->fetchAll($sql);
	}
	function updateDeposite($data){
		$db = $this->getAdapter();
		$db->beginTransaction();
		//update cms_partner_deposit
		$id = $data['id'];
		try{
	        $arr=array(
						'partner_id'=>$data['name_partner'],
						'date'=>$data['creat_date'],
						'note'=>$data['moneyinaccount'],
						'invoice'=>$data['num_invoice']
				);
	        $where=" id =".$data['id'];
	      //  print_r($where);exit();
	      // $db->getProfiler()->setEnabled(true);
			$this->update($arr, $where);
// 			Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQuery());
// 			Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
// 			$db->getProfiler()->setEnabled(false);
			
// 			$where = " pd_id = ".$data['id'];
// 			$_arr = array('status'=>0);
// 			$this->_name='cms_partnerdeposit_detail';
// 			$this->update($_arr,$where);
			$sql_partner = "SELECT * FROM cms_partner WHERE id=".$data['name_partner'];
			$rs_partner = $db->fetchRow($sql_partner);
			
			$sql ="SELECT * FROM cms_partnerdeposit_detail WHERE pd_id = $id";
			$rs = $db->fetchAll($sql);
			//print_r($rs);
			if($rs!=""){
				foreach ($rs as $row){
					if($row["currency_type"]==1){
						$arr_update = array(
								'cash_dollar' =>  $rs_partner["cash_dollar"]-$row["deposite_amount"] ,
							);
						
						$this->_name="cms_partner";
						$where = $db->quoteInto("id=?",$data['name_partner']);
						
// 						$db->getProfiler()->setEnabled(true);
						
						$this->update($arr_update, $where);
						
// 						Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQuery());
// 						Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
// 						$db->getProfiler()->setEnabled(false);
					}
					
					if($row["currency_type"]==2){
						$arr_update = array(
								'cash_bath' => $rs_partner["cash_bath"] - $row["deposite_amount"],
						);
					
						$this->_name="cms_partner";
						$where = $db->quoteInto("id=?",$data['name_partner']);
					
// 						$db->getProfiler()->setEnabled(true);
					
						$this->update($arr_update, $where);
					
// 						Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQuery());
// 						Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
// 						$db->getProfiler()->setEnabled(false);
					}
					if($row["currency_type"]==3){
						$arr_update = array(
								'cash_riel' => $rs_partner["cash_riel"] - $row["deposite_amount"],
						);
							
						$this->_name="cms_partner";
						$where = $db->quoteInto("id=?",$data['name_partner']);
							
// 						$db->getProfiler()->setEnabled(true);
							
						$this->update($arr_update, $where);
							
// 						Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQuery());
// 						Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
// 						$db->getProfiler()->setEnabled(false);
					}
					
				}
			}
			
// 			$db->getProfiler()->setEnabled(true);
			$sql ="DELETE FROM cms_partnerdeposit_detail WHERE pd_id = $id";
			$db->query($sql);
// 			Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQuery());
// 			Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
// 			$db->getProfiler()->setEnabled(false);
				
// 			$db->query($sql);
			
			$ids = explode(',',$data['record_row']);
			
			$sql_partners = "SELECT * FROM cms_partner WHERE id=".$data['name_partner'];
			$rs_partners = $db->fetchRow($sql_partners);
			//print_r($ids);exit();
			foreach ($ids as $i){
				$arr = array(
						'pd_id'=>$data['id'],
						'date'=>$data['date_'.$i],
						'currency_type'=>$data['currency_type_'.$i],
						'deposite_amount'=>$data['amount_'.$i],
						'receive_amount'=>$data['recieve_'.$i],
						'return_amount'=>$data['return_'.$i],
						'note'=>$data['note_'.$i],
				);
				$this->_name="cms_partnerdeposit_detail";
// 				$db->getProfiler()->setEnabled(true);
				$this->insert($arr);
// 				Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQuery());
//                 Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
//                 $db->getProfiler()->setEnabled(false);
				
				if($data['currency_type_'.$i]==3){
					
					$arr_partner = array(
							'cash_riel' => $rs_partners["cash_riel"] + $data["amount_".$i]
					);
				}
				if($data['currency_type_'.$i]==2){
					$arr_partner = array(
							'cash_bath' => $rs_partners["cash_bath"] + $data["amount_".$i]
					);
				}
				if($data['currency_type_'.$i]==1){
					$arr_partner = array(
							'cash_dollar' => $rs_partners["cash_dollar"] + $data["amount_".$i]
					);
				}
				$where = $db->quoteInto("id=?", $data['name_partner']);
				$this->_name = "cms_partner";
// 				$db->getProfiler()->setEnabled(true);
				$this->update($arr_partner, $where);
// 				Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQuery());
//                 Zend_Debug::dump($db->getProfiler()->getLastQueryProfile()->getQueryParams());
//                 $db->getProfiler()->setEnabled(false);
				
			}
			//exit();
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
			 FROM cms_partnerdeposit_detail WHERE pd_id = ".$db->quote($id).' AND status=1';
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