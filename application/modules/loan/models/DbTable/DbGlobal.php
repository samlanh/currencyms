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
	public function getAllCOName(){
		$this->_name='ln_co';
		$sql = " SELECT co_id,co_khname FROM $this->_name WHERE status=1 AND co_khname!='' ";
		$db = $this->getAdapter();
		return $db->fetchAll($sql);
	}
	public function getAllDegree($id=null){
		$tr= Application_Form_FrmLanguages::getCurrentlanguage();
		$opt_degree = array(
				1=>$this->tr->translate("Diploma"),
				2=>$this->tr->translate("Associate"),
				3=>$this->tr->translate("Bechelor"),
				4=>$this->tr->translate("Master"),
				5=>$this->tr->translate("PhD")
		);
		if($id==null)return $opt_degree;
		else return $opt_degree[$id];
	}
	public function getAllBranchName($branch_id=null){
		$db = $this->getAdapter();
		$sql= "SELECT br_id,branch_namekh,
		branch_nameen,branch_address,branch_code,branch_tel,displayby
		FROM `ln_branch` WHERE (branch_namekh !='' OR branch_nameen!='') ";
		if($branch_id!=null){
			$sql.=" AND br_id=$branch_id LIMIT 1";
		}
		return $db->fetchAll($sql);
	}
	public function getGlobalDb($sql)
  	{
  	   // print $sql;exit;
  		$db=$this->getAdapter();
  		$row=$db->fetchAll($sql);  		
  		if(!$row) return NULL;
  		return $row;
  	}
  	public function getNewInvoiceExchange(){
  		$this->_name='ln_exchange';
  		$db = $this->getAdapter();
  		$sql=" SELECT id FROM $this->_name ORDER BY id DESC LIMIT 1 ";
  		$acc_no = $db->fetchOne($sql);
  		$new_acc_no= (int)$acc_no+1;
  		$acc_no= strlen((int)$acc_no+1);
  		$pre = "";
  		for($i = $acc_no;$i<6;$i++){
  			$pre.='0';
  		}
  		return $pre.$new_acc_no;
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
//     public function CurruncyTypeOption(){
//     	$db = $this->getAdapter();
//     	$rows=array(1=>"ដុល្លា",2=>"បាត",3=>"រៀល");
//     	$option='';
//     	if(!empty($rows))foreach($rows as $key=>$value){
//     		$option .= '<option value="'.$key.'" >'.htmlspecialchars($value, ENT_QUOTES).'</option>';
//     	}
//     	return $option;
//     }
    public function CurruncyTypeOption($type=null,$option = null,$limit =null){
    	$db = $this->getAdapter();
    	$sql="SELECT id,key_code,name_en,name_kh,displayby FROM `cms_view` WHERE status =1 ";
    	if($type!=null){
    		$sql.=" AND type = $type ";
    	}
    	if($limit!=null){
    		$sql.=" LIMIT $limit ";
    	}
    	$rows = $db->fetchAll($sql);
    	if($option!=null){
    		$options=array(''=>"---ជ្រើសរើស---");
    	}
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
    function getAllPartner($id=null,$option=null){
    	$db=$this->getAdapter();
    	$sql = " select id,partner_brand,partner_name from cms_partner where status=1 ";
    	if($id!=null){
    		$sql.=" AND id = $id";
    	}
    	$rows = $db->fetchAll($sql);
    	if($option!=null){
    		$opt = '';
    		foreach ($rows as $rs){
    			$opt[$rs['id']]=$rs['partner_brand'];
    		}
    		return $opt;
    		
    	}else{
    		return $rows;
    	}
    	
    	
    }
    public function getClientByType($type=null){
    	$this->_name='ln_client';
    	$where='';
    	if($type!=null){
    		$where=' AND is_group = 1';
    	}
    	$sql = " SELECT client_id,name_en,client_number,
    	(SELECT village_name FROM `ln_village` WHERE vill_id = village_id  LIMIT 1) AS village_name,
    	(SELECT commune_name FROM `ln_commune` WHERE com_id = com_id  LIMIT 1) AS commune_name,
    	(SELECT district_name FROM `ln_district` AS ds WHERE dis_id = ds.dis_id  LIMIT 1) AS district_name,
    	(SELECT province_en_name FROM `ln_province` WHERE province_id= pro_id  LIMIT 1) AS province_en_name
    
    	FROM $this->_name WHERE status=1 AND name_en!='' ";
    	$db = $this->getAdapter();
    	return $db->fetchAll($sql.$where);
    }
}
?>