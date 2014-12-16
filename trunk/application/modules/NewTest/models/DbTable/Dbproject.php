<?php 
Class NewTest_Model_DbTable_Dbproject extends zend_db_Table_Abstract
	{
		protected $_name="currency";
		Function addStudent($data){
			$arr=array(
					
					'Student_name'=>$data['Student_names'],
					'Sex'=>$data['Sexs'],
					'Date of birth'=>$data['Date_of_births'],
					'phone'=>$data['phones'],
					'title'=>$data['titles']
					
			);
			$this->insert($arr);
			$where=" id = 9";
			$this->delete($where);
				
			
		}
		

function  getAllClient(){
	$db = $this->getAdapter();
	$sql = " SELECT toAmountType,sum(toAmount) as total FROM `cs_exchange` Group by toAmountType";
	return $db->fetchAll($sql);
	
}

	}
?>