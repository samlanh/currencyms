<?php

class Other_Model_DbTable_DbDistrict extends Zend_Db_Table_Abstract
{

    protected $_name = 'ln_district';
    public function getUserId(){
    	$session_user=new Zend_Session_Namespace('auth');
    	return $session_user->user_id;
    	 
    }
	public function addDistrict($_data){
		$_arr=array(
				'pro_id'	  => $_data['province_name'],
				'district_name'	  => $_data['district_name'],
				'district_namekh'	  => $_data['district_namekh'],
				'displayby'	  => $_data['display'],
				'status'	  => $_data['status'],
				'modify_date' => Zend_Date::now(),
				'user_id'	  => $this->getUserId()
		);
		if(!empty($_data['id'])){
			$where = 'dis_id = '.$_data['id'];
			return  $this->update($_arr, $where);
		}else{
			return  $this->insert($_arr);
		}
	}
	public function getDistrictById($id){
		$db = $this->getAdapter();
		$sql = "SELECT * FROM $this->_name WHERE dis_id = ".$db->quote($id);
		$sql.=" LIMIT 1 ";
		$row=$db->fetchRow($sql);
		return $row;
	}
	function getAllDistrict($search=null){
		$db = $this->getAdapter();
		$sql = "SELECT
					dis_id,
					district_namekh,district_name,displayby,
				    (SELECT province_en_name FROM ln_province WHERE province_id=pro_id limit 1) As province_name
					,modify_date,status,
				(SELECT first_name FROM rms_users WHERE id=user_id LIMIT 1) As user_name
		 FROM $this->_name ";
		$where = ' WHERE 1 ';
		
		if($search['status']>-1){
			$where.= " AND status = ".$search['status'];
		}
		if(!empty($search['adv_search'])){
			$where.= " AND district_name LIKE '%{$search['adv_search']}%'";
		}
		return $db->fetchAll($sql.$where);	
	}	
}

