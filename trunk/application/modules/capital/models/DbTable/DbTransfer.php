<?php 
	class Capital_Model_DbTable_DbTransfer extends zend_db_Table_Abstract
	{
	protected $_name="cms_current_capital";
	
	function getCapitalByName($id=null,$option=null){
			$db=$this->getAdapter();
			$sql = " 
			        SELECT id ,
						(SELECT first_name FROM cs_users WHERE id = userid) AS first_name
			             from  cms_current_capital where status=1 ";
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