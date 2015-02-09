<?php

class Application_Model_DbTable_DbAmountPC extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_pc';
	public function pcAccess($pc_name, $amount){
// 		$enutil = new Application_Model_EncryptionUtil();
		$db=$this->getAdapter();
		$sql = "SELECT pc_name FROM cs_pc";
		$row=$db->fetchAll($sql);
		$pc_access = count($row);
		//echo $pc_access;exit();
		$_pcname=md5($pc_name);
		if($pc_access<$amount){
			if(!empty($row))foreach ($row as $value){
				$get_pc=($value["pc_name"]);
				if($_pcname==$get_pc){//if user logined and amount avaliable
					return 1;
					break;
				}
			}//if doesn't login and amount avaliable
			$_arr = array("pc_name"=>(md5($pc_name)));
			$ddd = $this->insert($_arr);
			return 1;
		}
		else{
			foreach ($row as $value){
				$get_pc=($value["pc_name"]);
				if($_pcname==$get_pc){//if user logined and amount not avaliable
					return 1;
					break;
				}
			}
			return 0;
		}
	}
	public function clearUserLogined($pc_name){
		$_pcname = md5($pc_name);
		$where = $this->getAdapter()->quoteInto('pc_name = ?', $_pcname);
		$this->delete($where);
	}

}

