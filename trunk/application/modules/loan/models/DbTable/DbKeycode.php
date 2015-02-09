<?php

class Application_Model_DbTable_DbKeycode extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_keycode';
    

	function getKeyCodeMiniInv($loginonly = FALSE){
		$db = $this->getAdapter();
		$sql = 'SELECT `keyName`,`keyValue` FROM `cs_keycode`';
		if($loginonly){
			$sql .= " WHERE `code` > 10";
		}
		$_result = $db->fetchAll($sql);
		$_k = array(); 
		foreach ($_result as $key => $k) {
			$_k[$k['keyName']] = $k['keyValue'];
		}
		return $_k;
	}
	
	static function getHieghtRow(){
		return 29;		
	}
	
	function getMainBranch(){
		$db = $this->getAdapter();
		$sql = 'SELECT `keyValue` FROM `cs_keycode` WHERE `keyName`="mainbranch"';
		$_result = $db->fetchRow($sql);		
		return $_result['keyValue'];
	}
	
	static function getMonthNameKh($month){
		$_mkh = array(
					1=>'មករា',
					2=>'កុម្ភៈ',
					3=>'មីនា',
					4=>'មេសា',
					5=>'ឧសភា',
					6=>'មិថុនា',
					7=>'កក្កដា',
					8=>'សីហា',
					9=>'កញ្ញា',
					10=>'តុលា',
					11=>'វិច្ឆិកា',
					12=>'ធ្នូរ'
					);
		return $_mkh[$month];
	}
	
	function getKeyCode(){
		$db = $this->getAdapter();
		$sql = 'SELECT `keyName`,`keyValue` FROM `cs_keycode`';
		$_result = $db->fetchAll($sql);
		$_k = array();
		foreach ($_result as $key => $k) {
			$_k[$k['keyName']] = $k['keyValue'];
		}
		return $_k;
	}
	
	function updateKeyCode($post, $data){
		$_key_code_data=array();
		foreach ($post as $key => $val) {
			if($val != $data[$key]){
				$_key_code_data['keyValue'] = $val;
				
				$where=$this->getAdapter()->quoteInto('keyName=?', $key);
				$this->update( $_key_code_data, $where);
				
				if($key == 'rpt-transfer-title-kh'){
					$where=$this->getAdapter()->quoteInto('keyName=?', "mainbranch");
					$this->update( $_key_code_data, $where);
				}else if($key == 'rpt-transfer-location-adr-kh'){
					$_key_code_data['keyValue'] = 'ទីតាំង៖ '.$val;
					$where=$this->getAdapter()->quoteInto('keyName=?', "branch-add");
					$this->update( $_key_code_data, $where);
				}else if($key == 'bracnch-tel'){
					$_key_code_data['keyValue'] = 'Tel: '.$val;
					$where=$this->getAdapter()->quoteInto('keyName=?', "rpt-transfer-tel-eng");
					$this->update( $_key_code_data, $where);
				}else if($key == 'services'){
					$where=$this->getAdapter()->quoteInto('keyName=?', "mainbranch-subtitle");
					$this->update( $_key_code_data, $where);
				}else if($key == 'servername'){
					$where=$this->getAdapter()->quoteInto('keyName=?', "servername");
					$this->update( $_key_code_data, $where);
				}else if($key == 'dbuser'){
					$where=$this->getAdapter()->quoteInto('keyName=?', "dbuser");
					$this->update( $_key_code_data, $where);
				}else if($key == 'dbpassword'){
					$where=$this->getAdapter()->quoteInto('keyName=?', "dbpassword");
					$this->update( $_key_code_data, $where);
				}else if($key == 'dbname'){
					$where=$this->getAdapter()->quoteInto('keyName=?', "dbname");
					$this->update( $_key_code_data, $where);
				}
				
			}
			
		}
	}
}

