<?php 
	class Keeping_Model_DbTable_DbKeeping extends zend_db_Table_Abstract
	{
	protected $_name="cms_keeping";
		function insertKeeping($data){
// 		$db = $this->getAdapter();//ស្ពានភ្ជាប់ទៅកាន់Data Base
// 		$db->beginTransaction();//ទប់ស្កាត់មើលការErrore , មានErrore វាមិនអោយចូល
// 			try{
			$arr=array(
						'client_id'=>$data['send_name'],
						'payment_term'=>$data['pay_term'],
						'date_keeping'=>$data['date'],
						'amount_keeping'=>$data['amount_month'],
						'exp_date'=>$data['epx_date'],
						'invoice_number'=>$data['report'],
						
	// 					'status'=>$data['withdraw_dollar'],
	// 					'date'=>$data['withdraw_bath'],
	// 					'user_id'=>$data['withdraw_riel'],
				);
// 			print_r($arr);exit();
			$id=$this->insert($arr);
			
				$this->_name='cms_keepingdetail';
				$ids = explode(',',$data['record_row']);
				foreach ($ids as $i){
					$arr = array(
							'keeping_id'=>$id,
							'currency_type'=>$data['type_money'.$i],
							'money_inacc'=>$data['money_inacc'.$i],
							'cut_money'=>empty($data['is_spacial'.$i])?0:1,
							'commission'=>$data['commission'.$i],
							'total_amount'=>$data['total_amount'.$i],
							'recieve_amount'=>$data['recieve_amount'.$i],
							'lbltotal_return'=>$data['lbltotal_return'.$i],
							//'recieve_amount'=>$data['amount_exchanged'.$i],
							'note'=>$data['note'.$i],
				
					);
					
					$this->insert($arr);
				}
// 				$db->commit();//if not errore it do....
// 			}catch (Exception $e){
// 				$db->rollBack();//អោយវាវិលត្រលប់ទៅដើមវីញពេលណាវាជួបErrore
				
// 			}
		
		}
		public function CurruncyTypeOption(){
			$db = $this->getAdapter();
			$rows=array(1=>"ដុល្លា",2=>"បាត",3=>"រៀល");
			$option='';
			if(!empty($rows))foreach($rows as $key=>$value){
				$option .= '<option value="'.$key.'" >'.htmlspecialchars($value, ENT_QUOTES).'</option>';
			}
			return $option;
		}
		function getAllKeeping(){
			$db=$this->getAdapter();
			$sql = "SELECT id ,
						(SELECT client_name FROM cms_client WHERE id = client_id) AS client_name
						,(SELECT name_en FROM cms_view WHERE id = payment_term and type=1) AS name_en,date_keeping,amount_keeping,exp_date,invoice_number ,status  FROM $this->_name ";
			
			return $db->fetchAll($sql);
		}
		function updateKeeping($data){
				$arr=array(
						'client_id'=>$data['send_name'],
						'payment_term'=>$data['pay_term'],
						'date_keeping'=>$data['date'],
						'amount_keeping'=>$data['amount_month'],
						'exp_date'=>$data['epx_date'],
						'invoice_number'=>$data['report'],
	
				);
		//	print_r($arr);exit();
		 
			$where=" id =".$data['id'];
// 			print_r($where);exit();
		$this->update($arr, $where);
// 		print_r($db);exit();

		
		$where = " keeping_id = ".$data['id'];
// 			print_r($where);exit();
			$_arr = array('status'=>0);
			$this->_name='cms_keepingdetail';
		$this->update($_arr,$where);
		$ids = explode(',',$data['record_row']);
			foreach ($ids as $i){
				$arr = array(
						'keeping_id'=>$data['id'],
						'currency_type'=>$data['type_money'.$i],
						'money_inacc'=>$data['money_inacc'.$i],
						'cut_money'=>empty($data['is_spacial'.$i])?0:1,
						'commission'=>$data['commission'.$i],
						'total_amount'=>$data['total_amount'.$i],
						'recieve_amount'=>$data['recieve_amount'.$i],
						'lbltotal_return'=>$data['lbltotal_return'.$i],
						//'recieve_amount'=>$data['amount_exchanged'.$i],
						'note'=>$data['note'.$i],
			
				);
					
				$this->insert($arr);
			}
		}
		function getKeepingbyid($id){
			$db = $this->getAdapter();
			$sql=" SELECT id,client_id,payment_term,date_keeping,amount_keeping,
			exp_date,invoice_number FROM $this->_name where id=$id ";
			
			return $db->fetchRow($sql);
		}
		public function getKeepingdetail($id){
			$db = $this->getAdapter();
			$sql = "SELECT * FROM cms_keepingdetail WHERE keeping_id = ".$db->quote($id)." AND status=1";
			//echo $sql;exit();
			$row=$db->fetchAll($sql);
			return $row;
		}
		function getNameKeeping($id=null,$option=null){
			$db=$this->getAdapter();
			$sql = " select id,client_name from cms_client where status=1 ";
			if($id!=null){
				$sql.=" AND id = $id";
			}
			$rows = $db->fetchAll($sql);
			if($option!=null){
				$opt = '';
				foreach ($rows as $rs){
					$opt[$rs['id']]=$rs['client_name'];
				}
				return $opt;
		
			}else{
				return $rows;
			}
			 
			 
		}
		
		function getNameView($id=null,$option=null){
			$db=$this->getAdapter();
			$sql = " select id,name_en from cms_view where status=1 ";
			if($id!=null){
				$sql.=" AND id = $id";
			}
			$rows = $db->fetchAll($sql);
			if($option!=null){
				$opt = '';
				foreach ($rows as $rs){
					$opt[$rs['id']]=$rs['name_en'];
				}
				return $opt;
		
			}else{
				return $rows;
			}
		
		
		}
	}
?>