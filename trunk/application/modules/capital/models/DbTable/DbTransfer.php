<?php 
	class Capital_Model_DbTable_DbTransfer extends zend_db_Table_Abstract
	{
	protected $_name="cms_current_capital";
	
	function getCapitalByName($id=null,$option=null){
	$db=$this->getAdapter();
			$sql = " SELECT id , first_name FROM cs_users WHERE STATUS=1 ";
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
		function  getCapitalInfo($id){
			$db=$this->getAdapter();
			$sql="SELECT cp.amount,cp.currency_id FROM cms_current_capital AS cp,cs_users AS cu 
			WHERE cp.status=1 AND cp.userid=cu.id AND cp.userid=$id";
			return $db->fetchAll($sql);
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