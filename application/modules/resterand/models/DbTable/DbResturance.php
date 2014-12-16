<?php 
	class Resterand_Model_DbTable_DbResturance extends Zend_Db_Table_Abstract
	{
		protected  $_name ="resterand";
		function addProduct($data){
			$arr=array(
					
					'product_name'=>$data['produc_name'],
					'oder'=>$data['oders'],
					'Qty'=>$data['qtys'],
					'price'=>$data['prices'],
					'total'=>$data['totals'],
					);
			$this->insert($arr);
			
		}
	}
?>




