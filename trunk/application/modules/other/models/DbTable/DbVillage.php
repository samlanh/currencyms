<?php

class Other_Model_DbTable_DbVillage extends Zend_Db_Table_Abstract
{

    protected $_name = 'ln_village';
    public function getUserId(){
    	$session_user=new Zend_Session_Namespace('auth');
    	return $session_user->user_id;
    	 
    }
	public function addVillage($_data){
		$_arr=array(
				'commune_id'	  => $_data['commune_name'],
				'village_name'	  => $_data['village_name'],
				'village_namekh'	  => $_data['village_namekh'],
				'displayby'	  => $_data['display'],
				'status'	  => $_data['status'],
				'modify_date' => Zend_Date::now(),
				'user_id'	  => $this->getUserId()
		);
		if(!empty($_data['id'])){
			
			$where = 'vill_id = '.$_data['id'];
			return  $this->update($_arr, $where);
		}else{
			return  $this->insert($_arr);
		}
		
	}
	public function getVillageById($id){
		$db = $this->getAdapter();
		$sql=" SELECT v.vill_id,v.commune_id,v.village_name,v.village_namekh,v.displayby,v.modify_date,
					v.status,v.user_id,d.dis_id,d.pro_id FROM 
			   `ln_village` AS v,ln_commune AS c,ln_district AS d
			   WHERE v.commune_id=c.com_id AND v.vill_id AND c.district_id=d.dis_id AND
			  v.vill_id = ".$db->quote($id);
		$sql.=" LIMIT 1 ";
		$row=$db->fetchRow($sql);
		return $row;
	}
	function getAllVillage($search=null){
		$db = $this->getAdapter();
		$sql = "SELECT
					vill_id,village_namekh,village_name,displayby,
					(SELECT commune_name FROM ln_commune WHERE commune_id=com_id limit 1) As commune_name
					,modify_date,status,
				(SELECT first_name FROM rms_users WHERE id=user_id LIMIT 1) As user_name
				FROM $this->_name ";
		$where = ' WHERE 1 ';
		if($search['status']>-1){
			$where.= " AND status = ".$search['status'];
		}
		if(!empty($search['adv_search'])){
			$s_where = array();
			$search = $search['adv_search'];
			$s_where[] = " village_name LIKE '%{$search}%'";
// 			$s_where[] = "co_khname LIKE '%{$search}%'";
// 			$s_where[] = " co_firstname LIKE '%{$search}%'";
// 			$s_where[] = "co_lastname LIKE '%{$search}%'";
// 			$s_where[] = " tel LIKE '%{$search}%'";
// 			$s_where[] = "email LIKE '%{$search}%'";
// 			$s_where[] = "address LIKE '%{$search}%'";
			$where .=' AND ('.implode(' OR ',$s_where).')';
		}
		
		return $db->fetchAll($sql.$where);	
	}	
}

