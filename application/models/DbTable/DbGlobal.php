<?php

class Application_Model_DbTable_DbGlobal extends Zend_Db_Table_Abstract
{
    // set name value
	public function setName($name){
		$this->_name=$name;
	}
	/**
	 * get selected record of $sql
	 * @param string $sql
	 * @return array $row;
	 */
	public function getGlobalDb($sql)
  	{
  	   // print $sql;exit;
  		$db=$this->getAdapter();
  		$row=$db->fetchAll($sql);  		
  		if(!$row) return NULL;
  		return $row;
  	}
  	
  	public function getGlobalDbRow($sql)
  	{
  		//print $sql;exit;
  		$db=$this->getAdapter();  		
  		$row=$db->fetchRow($sql);
  		if(!$row) return NULL;
  		return $row;
  	}
  	public function getGlobalDbOne($sql)
  	{
  		//print $sql;exit;
  		$db=$this->getAdapter();
  		$value=$db->fetchOne($sql);
  		if(!$value) return NULL;
  		return $value;
  	}
  	public static function getActionAccess($action)
    {
    	$arr=explode('-', $action);
    	return $arr[0];    	
    }     
    /**
     * get CSO options for select box
     * @return array $options
     */
    public function getOptionCSO(){
    	$options = array('Please select');
    	$sql = "SELECT id, name_en FROM fi_cso ORDER BY name_en";
    	$rows = $this->getGlobalDb($sql);
    	foreach($rows as $ele){
    		$options[$ele['id']] = $ele['name_en'];
    	}
    	return $options;
    }
    /**
     * boolean true mean record exist already
     * @param string $conditions
     * @param string $tbl_name
     * @return boolean
     */
    public function isRecordExist($conditions,$tbl_name){
		$db=$this->getAdapter();		
		$sql="SELECT * FROM ".$tbl_name." WHERE ".$conditions; 
		//echo $sql;exit;
		$stm = $db->query($sql);
		$row = $stm->fetchAll();
    	if(!$row) return false;
    	return true;    	
    }
    /**
     * insert record to table $tbl_name
     * @param array $data
     * @param string $tbl_name
     */
    public function addRecord($data,$tbl_name){
    	//print_r($data);exit;    	
    	$this->setName($tbl_name);
    	return $this->insert($data);
    }
    
    /**
     * update record to table $tbl_name
     * @param array $data
     * @param int $id
     * @param string $tbl_name
     */
    public function updateRecord($data,$id,$tbl_name){
    	//print_r($data);exit;
    	$this->setName($tbl_name);
    	$where=$this->getAdapter()->quoteInto('id=?',$id);
    	$this->update($data,$where);    	
    }
    
    public function DeleteRecord($tbl_name,$id){
    	$db = $this->getAdapter();
		$sql = "UPDATE ".$tbl_name." SET status=0 WHERE id=".$id;
		return $db->query($sql);
    } 

     public function DeleteData($tbl_name,$where){
    	$db = $this->getAdapter();
		$sql = "DELETE FROM ".$tbl_name.$where;
		return $db->query($sql);
    } 
    
    public function convertStringToDate($date, $format = "Y-m-d H:i:s")
    {
    	if(empty($date)) return NULL;
    	$time = strtotime($date);
    	return date($format, $time);
    }
    
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
    public function getAllTransactionName(){
    	 $tran_type=array(
    			1=>'ប្រើប្រាស់ដើមទុន',
    			2=>'វេរប្រាក់',
    			3=>'ប្តូរប្រាក់',
    			4=>'KBANK',
    			5=>'កម្ចី',
    			6=>'សងប្រាក់',
    			7=>'ដកប្រាក់(KBANK)',
    			//     		8=>'debt remain'
    	
    	);
    	 return $tran_type;
    }
    public function CurruncyTypeOption(){
    	$db = $this->getAdapter();
    	$rows=array(1=>"ដុល្លា",2=>"បាត",3=>"រៀល");
    	$option='';
    	if(!empty($rows))foreach($rows as $key=>$value){
    		$option .= '<option value="'.$key.'" >'.htmlspecialchars($value, ENT_QUOTES).'</option>';
    	}
    	return $option;
    }
    public function CurrencyAmountOption($curr_type=1){
    	$db = $this->getAdapter();
    	$row_dollar=array(1=>'100 $',2=>'50 $',3=>'20 $',4=>'10 $',5=>'5 $',6=>'1 $');
    	$row_bath=array(1=>'1,000 B',2=>'500 B',3=>'100 B',4=>'50 B',5=>'20 B',6=>'10 B',7=>'5 B',8=>'2 B',9=>'1 B');
    	$row_riel=array(1=>'50,000  ៛',2=>'20,000 ៛',3=>'10,000 ៛',4=>'5,000 ៛',5=>'2,000 ៛',6=>'1,000 ៛',7=>'500 ៛',8=>'100 ៛');
    	if($curr_type==null){
    		$rows=$row_dollar;
    		return $option='';
    	}else{
    		if($curr_type==1){
    			$rows=$row_dollar;
    		}elseif($curr_type==2){
    			$rows=$row_bath;
    		}else{ $rows=$row_riel; }
    		
    		$option='';
    		if(!empty($rows))foreach($rows as $key=>$value){
    			$option .= '<option value="'.$key.'" >'.htmlspecialchars($value, ENT_QUOTES).'</option>';
    		}
    	}
    	
    	return $option;
    }
    public static function CurrencyOption($curr_type=1,$key){
//     	$db = $this->getAdapter();
    	$row_dollar=array(1=>'100',2=>'50',3=>'20',4=>'10',5=>'5',6=>'1',
    			7=>'1000',8=>'500',9=>'100',10=>'50',11=>'20',12=>'10',13=>'5',14=>'2',15=>'1',
    			16=>'50000',17=>'20000',18=>'10000',19=>'5000',20=>'2000',21=>'1000',22=>'500',23=>'100');
    	$row_bath=array(1=>'1000',2=>'500',3=>'100',4=>'50',5=>'20',6=>'10',7=>'5',8=>'2',9=>'1');
    	$row_riel=array(1=>'50000',2=>'20000',3=>'10000',4=>'5000',5=>'2000',6=>'1000',7=>'500',8=>'100');
    	if($curr_type==1){
    		return $row_dollar[$key];
    		
    	}elseif($curr_type==2){
    		return $row_bath[$key];
    		
    	}elseif($curr_type==3){
    		return $row_riel[$key];
    	}

    }
    public function setReportParam($arr_param,$file)
    {
    	$contents = file_get_contents('.'.$file);
    	if($arr_param!=null){
    		foreach($arr_param as $key=>$read){
    			$contents=str_replace('@'.$key, $read, $contents);
    		}
    	}
    	//print $contents; exit();
    	$info=pathinfo($file);
    	
//     	echo $info['dirname'];exit();
//     	print_r($info);exit();
    	$newfile=$info['dirname'].'/_'.$info['basename'];
//     	echo $newfile;exit();
    	file_put_contents('.'.$newfile, $contents);
    	return $newfile;
    }
}
?>