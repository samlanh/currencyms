<?php 
	class Capital_Model_DbTable_DbCapital extends zend_db_Table_Abstract
	{
	protected $_name="cms_current_capital";
	public function getUserId(){
		$session_user=new Zend_Session_Namespace('auth');
		return $session_user->user_id;
	
	}
		function insertCapital($data){
			try{
				$db = $this->getAdapter();//ស្ពានភ្ជាប់ទៅកាន់Data Base
				$db->beginTransaction();//ទប់ស្កាត់មើលការErrore , មានErrore វាមិនអោយចូល
				$date=$data['date'];
				if(!empty($data['usa'])){
					$tran_id = $this->getCapitalExist($data['name_staff'],1,$date,$data['usa']);
					$arr = array(
							'tran_id'=>$tran_id,
							'tran_type'=>1,
							'curr_type'=>1,
							'amount'=>$data['usa'],
							'date'=>$date,
							'income'=>1,
							'sign'=>($data['usa']>0)?1:0,
							'user_id'=>$this->getUserId()
							);
					
					$this->addCapitallDetail($arr);
				}if(!empty($data['bath'])){
					$tran_id = $this->getCapitalExist($data['name_staff'],2,$date,$data['bath']);
					
					$arr = array(
							'tran_id'=>$tran_id,
							'tran_type'=>1,
							'curr_type'=>2,
							'amount'=>$data['bath'],
							'date'=>$date,
							'income'=>1,
							'sign'=>($data['bath']>0)?1:0,
							'user_id'=>$this->getUserId()
					);
// 					print_r($data);exit();
					$this->addCapitallDetail($arr);
				}if(!empty($data['reil'])){
					$tran_id = $this->getCapitalExist($data['name_staff'],3,$date,$data['reil']);
					
					$arr = array(
							'tran_id'=>$tran_id,
							'tran_type'=>1,
							'curr_type'=>3,
							'amount'=>$data['reil'],
							'date'=>$date,
							'income'=>1,
							'sign'=>($data['reil']>0)?1:0,
							'user_id'=>$this->getUserId()
					);
					$this->addCapitallDetail($arr);
				}
				
			$db->commit();//if not errore it do....
			}catch (Exception $e){
				$db->rollBack();//អោយវាវិលត្រលប់ទៅដើមវីញពេលណាវាជួបErrore
// 				echo $e->getMessage();exit();
			}
		
		}
		function addCapitallDetail($data){
			$this->_name='cms_capital_detail';
			$this->insert($data);
		}
		function getCapitalExist($user_id,$curr_type,$date,$amount){
			$sql = " SELECT * FROM cms_current_capital WHERE 
			userid =$user_id AND date = '".$date."' AND status=1 AND currency_id =$curr_type  LIMIT 1";
			$db = $this->getAdapter();
			$row = $db->fetchRow($sql);
			$this->_name='cms_current_capital';
			if(!empty($row)){
					$arr = array(
							'amount'=>$amount+$row['amount']);
				$where = 'id ='.$row['id'];
				$this->update($arr, $where);
				return $row['id'];
			}else{
					$arr = array(
							'amount'=>$amount,
							'currency_id'=>$curr_type,
							'userid'=>$user_id,
							'date'=>$date,
							
							);
				return $this->insert($arr);
			}
			
			
		}
		function getUpdateCapital($data){
			$db = $this->getAdapter();
			$db->beginTransaction();
			try{
				$amount=0;
				if(!empty($data['usa'])){
					$amount=$data['usa'];
				}
				else if(!empty($data['riel'])){
					$amount=$data['riel'];
				}
				else if(!empty($data['bath'])){
					$amount=$data['bath'];
				}
				$arr=array(
						'date'=>$data['date'],
						'userid'=>$data['name_staff'],
						'amount'=>$amount,
						'note'=>$data['note'],
						'status'=>$data['status'],
		
				);
				$where=" id =".$data['id'];
	        	$this->update($arr, $where);
	        	$sql = " SELECT id FROM cms_capital_detail WHERE tran_type =1 AND tran_id = ".$data['id'];
	        	$id = $db->fetchOne($sql);
	        	$this->_name='cms_capital_detail';
	        	$data = array(
	        			'amount'=>$amount,
	        			'sign'=>($amount)>0?1:0,
	        			'status'=>$data['status'],
	        			'user_id'=>$this->getUserId()
	        			);
	        	$where = 'id ='.$id;
	        	$this->update($data, $where);
				$db->commit();
			}catch (Exception $e){
				$db->rollBack();
			}
		
		}
		function getAllCapital(){
			$db=$this->getAdapter();
			$sql = "SELECT id ,
						(SELECT first_name FROM cs_users WHERE id = userid) AS first_name,
						(SELECT staff_code FROM cs_users WHERE id = userid) AS staff_code,
						date,amount,			
					  (SELECT name_en FROM cms_view WHERE TYPE=2 AND key_code=currency_id limit 1) AS currency_name
			,note,status  FROM $this->_name order by currency_id,id DESC ";
			return $db->fetchAll($sql);
		}
		
	   function getCapitalbyid($id){
			$db = $this->getAdapter();
			$sql=" SELECT id,date, amount,note,
			userid,currency_id,status FROM $this->_name where id=$id ";
			return $db->fetchRow($sql);
			
		}
		
		function getNameCs_users($id=null,$option=null){
			$db=$this->getAdapter();
			$sql = " select id,first_name,staff_code,status from cs_users where status = 1 ";
			if($id!=null){
				$sql.=" AND id = $id";
			}
			$rows = $db->fetchAll($sql);
			if($option!=null){
				$opt = '';
				foreach ($rows as $rs){
					$opt[$rs['id']]=$rs['first_name'];
					
				}
				return $opt;
		
			}else{
				return $rows;
			}
		
		
		}
		function getIdCs_users($id=null,$option=null){
			$db=$this->getAdapter();
			$sql = " select id,first_name,staff_code,status from cs_users where status = 1 ";
			if($id!=null){
				$sql.=" AND id = $id";
			}
			$rows = $db->fetchAll($sql);
			if($option!=null){
				$opt = '';
				foreach ($rows as $rs){
					$opt[$rs['id']]=$rs['staff_code'];
				}
				return $opt;
		
			}else{
				return $rows;
			}
		
		
		}
	}
?>