<?php

class Other_Model_DbTable_DbCreditOfficer extends Zend_Db_Table_Abstract
{

    protected $_name = 'ln_co';
    public function getUserId(){
    	$session_user=new Zend_Session_Namespace('auth');
    	return $session_user->user_id;
    	 
    }
	public function addCreditOfficer($_data){
		$_arr=array(
				'co_code'	  => $_data['co_id'],
				'co_khname'	  => $_data['name_kh'],
				'co_firstname'=> $_data['first_name'],
				'co_lastname' => '',//$_data['last_name'],
				'displayby'	  => $_data['display'],
				'sex'		  => $_data['co_sex'],
				'national_id'	  => $_data['national_id'],
				'address'	  => $_data['address'],
				'pob'	      => $_data['pob'],
				'degree'	      => $_data['degree'],
				'tel'	  	  => $_data['tel'],
				'email'	      => $_data['email'],
				'create_date' => Zend_Date::now(),
				'status'      => $_data['status'],
				'user_id'	  => $this->getUserId()
		);
		if(!empty($_data['id'])){
			$where = 'co_id = '.$_data['id'];
			return  $this->update($_arr, $where);
		}else{
			return  $this->insert($_arr);
		}
		
	}
	public function getCOById($id){
		$db = $this->getAdapter();
		$sql = "SELECT * FROM $this->_name WHERE co_id = ".$db->quote($id);
		$sql.=" LIMIT 1 ";
		$row=$db->fetchRow($sql);
		return $row;
	}
	function getAllCreditOfficer($search=null){
		$db = $this->getAdapter();
		$sql = "SELECT
					co_id,co_code,co_khname,CONCAT(co_firstname,co_lastname) AS co_engname,national_id,address,
					tel,email,address,degree,status
					
		 FROM $this->_name ";
// 		(SELECT first_name FROM rms_users WHERE id=user_id) As user_name
		$where = ' WHERE co_khname!="" ';
		
		if($search['status']>-1){
			$where.= " AND status = ".$search['status'];
		}
		if(!empty($search['adv_search'])){
			$s_where = array();
			$search = ($search['adv_search']);
			$s_where[] = " co_code LIKE '%{$search}%'";
			$s_where[] = "co_khname LIKE '%{$search}%'";
			$s_where[] = " co_firstname LIKE '%{$search}%'";
			$s_where[] = "co_lastname LIKE '%{$search}%'";
			$s_where[] = " tel LIKE '%{$search}%'";
			$s_where[] = "email LIKE '%{$search}%'";
			$s_where[] = "address LIKE '%{$search}%'";
			$where .=' AND ('.implode(' OR ',$s_where).')';
		}
		
// 		echo $sql.$where;
		return $db->fetchAll($sql.$where);	
	}	
}

