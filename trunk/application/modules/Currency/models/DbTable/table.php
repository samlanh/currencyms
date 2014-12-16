<?php 
Class Currency_Model_DbTable_table extends zend_db_Table_Abstract
	{
		protected $_name="table";
		Function addStudent($data){
			$arr=array(
					
					'search'=>$data['searchs'],
					'add'=>$data['adds'],
					'exit'=>$data['exits'],
					'start'=>$data['starts'],
					'stop'=>$data['stops']
					
			);
			$this->insert($arr);
				
			
		}

	}
?>