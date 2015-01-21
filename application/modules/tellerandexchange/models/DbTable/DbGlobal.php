<?php

class Application_Model_DbTable_DbGlobal extends Zend_Db_Table_Abstract
{
	function getGlobalDbListBy($sql, $start, $limit){
		$db = $this->getAdapter();
		if ($limit != 'All') {
			$sql .= " LIMIT ".$start.", ".$limit;
		}
		$datas = $db->fetchAll($sql);
		if(!empty($datas))  {
			$result=array();
			foreach ($datas as $i => $d) {
				$result[$i]['num'] = $i + 1;
				foreach ($d as $key => $val){
					$result[$i][$key] = $val;
				}
			}
			//print_r($result); exit;
			return $result;
		}
		return $datas;
	}
	
	function getGlobalDbListTotal($sql){
		$db = $this->getAdapter();
		$_result = $db->fetchAll($sql);
		return count($_result);
	}
}
?>
