<?php

class Other_Model_DbTable_DbCommune extends Zend_Db_Table_Abstract
{

    protected $_name = 'ln_commune';
    public function getUserId(){
    	$session_user=new Zend_Session_Namespace('auth');
    	return $session_user->user_id;
    	 
    }
	public function addCommune($_data){
		$_arr=array(
				'district_id' => $_data['district_name'],
				'commune_namekh'=> $_data['commune_namekh'],
				'commune_name'=> $_data['commune_name'],
				'displayby'=> $_data['display'],
				'status'	  => $_data['status'],
				'modify_date' => Zend_Date::now(),
				'user_id'	  => $this->getUserId()
		);
		if(!empty($_data['id'])){
			$where = 'com_id = '.$_data['id'];
			return  $this->update($_arr, $where);
		}else{
			return  $this->insert($_arr);
		}
	}
	public function getCommuneById($id){
		$db = $this->getAdapter();
		$sql=" SELECT c.com_id,c.district_id,c.commune_name,commune_namekh,displayby,c.modify_date,c.status,c.user_id,
				(SELECT pro_id FROM `ln_district` WHERE dis_id =c.district_id LIMIT 1 ) as pro_id
				FROM ln_commune AS c WHERE c.com_id = $id  LIMIT 1";
		$row=$db->fetchRow($sql);
		return $row;
	}
	function getAllCommune($search=null){
		$db = $this->getAdapter();
		$sql = " SELECT com_id,
					commune_namekh,commune_name,
					(SELECT district_name FROM `ln_district` WHERE district_id = dis_id) AS district_name,
					modify_date,status,
       				(SELECT first_name FROM rms_users WHERE id=user_id LIMIT 1) AS user_name
				FROM $this->_name ";
		$where = ' WHERE 1 ';
		
		if(!empty($search['adv_search'])){
			$s_where = array();
// 			$search = $search['adv_search'];
			$s_where[] = " commune_name LIKE '%{$search['adv_search']}%'";
// 			$s_where[] = "co_khname LIKE '%{$search}%'";
// 			$s_where[] = " co_firstname LIKE '%{$search}%'";
// 			$s_where[] = "co_lastname LIKE '%{$search}%'";
// 			$s_where[] = " tel LIKE '%{$search}%'";
// 			$s_where[] = "email LIKE '%{$search}%'";
// 			$s_where[] = "address LIKE '%{$search}%'";
			$where .=' AND ('.implode(' OR ',$s_where).')';
		}
		if($search['status']>-1){
			$where.= " AND status = ".$search['status'];
		}
		return $db->fetchAll($sql.$where);	
	}	
}

