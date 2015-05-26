<?php 
Class Keeping_Model_DbTable_DbCustomer extends zend_db_Table_Abstract
	{
		protected $_name="cms_partner";
	function insertPartner($data){
		$db = $this->getAdapter();
		$db->beginTransaction();
		try{
			$photoname = str_replace(" ", "_", $data['partner_name']) . '.jpg';
			$upload = new Zend_File_Transfer();
			$upload->addFilter('Rename',
					array('target' => PUBLIC_PATH . '/images/'. $photoname, 'overwrite' => true) ,'photo');
			$receive = $upload->receive();
			//echo $receive; exit();	
			if($receive)
			{
				$data['photo'] = $photoname;
			}
			else{
				$data['photo']="";
			}
			unset($data['MAX_FILE_SIZE']);
			$arr=array(
// 					'parent'=>$data['main_branch'],
// 					'partner_brand'=>$data['branch_name'],
					'partner_name'=>$data['partner_name'],
					'nation_id'=>$data['cade_number'],
					'account_no'=>$data['account_number'],
					'nation_id'=>$data['cade_number'],
					'house_no'=>$data['home_number'],
					'group_no'=>$data['group_number'],
					'street'=>$data['street_number'],
					'commune'=>$data['commune'],
					'district'=>$data['district'],
					'village'=>$data['village'],
					'province'=>$data['province_name'],
					'tel'=>$data['fax_number'],
					'mobile'=>$data['sele_phone'],
					'note'=>$data['note'],
					'photo' =>$data['photo'],
					'cash_riel'=>$data['money_riel'],
					'cash_dollar'=>$data['money_usa'],
					'cash_bath'=>$data['money_bath'],
					'date'=>$data['date'],
					//'address'=>$data['address'],
					'is_cashoperation'=>$data['tran_type'],
					'status'=>$data['status']
				
			);
			$this->insert($arr);
			$db->commit();
			}catch (Exception $e){	
				echo $e->getMessage();	
				$db->rollBack();
			}		
		}
		Function getupdatePartner($data){
			$db = $this->getAdapter();
			$photoname = str_replace(" ", "_", $data['partner_name']) . '.jpg';
			$upload = new Zend_File_Transfer();
			$upload->addFilter('Rename',
					array('target' => PUBLIC_PATH . '/images/'. $photoname, 'overwrite' => true) ,'photo');
			$receive = $upload->receive();
			if($receive !="")
			{
				$data['photo'] = $photoname;
			}
			elseif($receive ==""){
				$dbs = $this->getAdapter();
				$sql = "SELECT photo FROM cms_partner WHERE id =".$data["id"];
				$old_photo = $db->fetchRow($sql);
				foreach ($old_photo as $old_photos){
					$data['photo'] = $old_photos;
				}
			}
			$arr=array(
// 					'parent'=>$data['main_branch'],
// 					'partner_brand'=>$data['branch_name'],
					'partner_name'=>$data['partner_name'],
					'nation_id'=>$data['cade_number'],
					'account_no'=>$data['account_number'],
					'nation_id'=>$data['cade_number'],
					'house_no'=>$data['home_number'],
					'group_no'=>$data['group_number'],
					'street'=>$data['street_number'],
					'commune'=>$data['commune'],
					'district'=>$data['district'],
					'province'=>$data['province_name'],
					'tel'=>$data['fax_number'],
					'mobile'=>$data['sele_phone'],
					'note'=>$data['note'],
					'photo' =>$data['photo'],
					'cash_riel'=>$data['money_riel'],
					'cash_dollar'=>$data['money_usa'],
					'cash_bath'=>$data['money_bath'],
					'date'=>$data['date'],
					'village'=>$data['village'],
				//	'address'=>$data['address'],
					'is_cashoperation'=>$data['tran_type'],
					'status'=>$data['status']
		
			);
				$where="id=".$data['id'];
				//print_r($where);exit();
			$this->update($arr,$where);
		   
				
		}
		function getPartnerById($id){
			$db = $this->getAdapter();
			$sql = "SELECT * FROM $this->_name WHERE id = ".$db->quote($id);
			$sql.=" LIMIT 1 ";
			$row=$db->fetchRow($sql);
			//print_r($row);
			return $row;
		}
        function getAllPartner($search=null){
        	$db=$this->getAdapter();
        	$from_date =(empty($search['start_date']))? '1': "date >= '".$search['start_date']." 00:00:00'";
			$to_date = (empty($search['end_date']))? '1': "date <= '".$search['end_date']." 23:59:59'";
			$where = " WHERE ".$from_date." AND ".$to_date;
        	$sql="SELECT p.id,
        	(SELECT s.partner_name FROM cms_partner AS s WHERE s.id=p.parent LIMIT 1 ) AS parent
        	,p.partner_name,p.partner_brand,p.account_no,
        	p.nation_id,(SELECT name FROM cs_provinces WHERE id = p.province LIMIT 1) AS name,p.tel,p.mobile,p.cash_riel,
        	p.cash_dollar,p.cash_bath,p.date,p.status  FROM cms_partner AS p ";
        	
        	if(!empty($search['adv_search'])){
        		$s_where = array();
        		$s_search = $search['adv_search'];
        		$s_where[] = "partner_name LIKE '%{$s_search}%'";
        		$s_where[]="partner_brand LIKE '%{$s_search}%'";
        		$s_where[]="account_no LIKE '%{$s_search}%'";
        		$s_where[]="tel LIKE '%{$s_search}%'";
        		$s_where[]="mobile LIKE '%{$s_search}%'";
        		$s_where[]="nation_id LIKE '%{$s_search}%'";
        		$s_where[]="province LIKE '%{$s_search}%'";
        		$s_where[]="cash_riel LIKE '%{$s_search}%'";
        		$s_where[]="cash_bath LIKE '%{$s_search}%'";
        		$s_where[]="cash_dollar LIKE '%{$s_search}%'";
        		$where .=' AND ('.implode(' OR ',$s_where).')';
        	}
        	if($search['status']>-1){
        		$where.= " AND status = ".$search['status'];
        	}
        	if($search['province_id']>0){
        		$where.=" AND province = ".$search['province_id'];
        	}
        	if(!empty($search['district_id'])){
        		$where.=" AND district= ".$search['district_id'];
        	}
        	if(!empty($search['comm_id'])){
        		$where.=" AND commune = ".$search['comm_id'];
        	}
        	if(!empty($search['village'])){
        		$where.=" AND village = ".$search['village'];
        	}
        	if(!empty($search['main_branch'])){
        		$where.=" AND id =".$search['main_branch'];
        	}
        	$order = " AND is_cashoperation = 2 ORDER BY id DESC ";
        	//echo $sql.$where.$order;
        	return $db->fetchAll($sql.$where.$order);
        }
        function getNamePartner($id=null,$option=null){
        	$db=$this->getAdapter();
        	$sql = " select id,name from cs_provinces ";
        	if($id!=null){
        		$sql.=" AND id = $id";
        	}
        	$rows = $db->fetchAll($sql);
        	if($option!=null){
        		$opt = '';
        		foreach ($rows as $rs){
        			$opt[$rs['id']]=$rs['name'];
        		}
        		return $opt;
        
        	}else{
        		return $rows;
        	}
        
        
        }
        function getNameDis($id=null,$option=null){
        	$db=$this->getAdapter();
        	$sql = " select dis_id,district_name from cms_district ";
        	if($id!=null){
        		$sql.=" AND dis_id = $id";
        	}
        	$rows = $db->fetchAll($sql);
        	if($option!=null){
        		$opt = '';
        		foreach ($rows as $rs){
        			$opt[$rs['dis_id']]=$rs['district_name'];
        		}
        		return $opt;
        
        	}else{
        		return $rows;
        	}
        
        
        }
        function getNamePartnerparent($id=null,$option=null){
        	$db=$this->getAdapter();
        	$sql = " select id,partner_name from cms_partner ";
        	if($id!=null){
        		$sql.=" AND id = $id";
        	}
        	$rows = $db->fetchAll($sql);
        	if($option!=null){
        		$opt = array(''=>"-----ជ្រើសរើស----");
        		foreach ($rows as $rs){
        			$opt[$rs['id']]=$rs['partner_name'];
        		}
        		return $opt;
        
        	}else{
        		return $rows;
        	}
        }
        function getNameProvice($id=null,$option=null){
        	$this->_name ='cs_provinces';
        	$db=$this->getAdapter();
        	$sql = " SELECT id,`name` FROM $this->_name WHERE `name`!=''";
        	if($id!=null){
        		$sql.=" AND id = $id";
        	}
        	$rows = $db->fetchAll($sql);
        	if($option!=null){
        		$opt = array(''=>"-----ជ្រើសរើស----");
        		foreach ($rows as $rs){
        			$opt[$rs['id']]=$rs['name'];
        		}
        		return $opt;
        
        	}else{
        		return $rows;
        	}
        
        
        }
        function getNameDisticts($id=null,$option=null){
        $db=$this->getAdapter();
        $this->_name ='cms_district';
    		$sql = "SELECT dis_id,pro_id,district_name FROM $this->_name WHERE status =1  AND district_name!=''";
        	$rows = $db->fetchAll($sql);
        	if($option!=null){
        		$opt = array(''=>"-----ជ្រើសរើស----");
        		foreach ($rows as $rs){
        			$opt[$rs['dis_id']]=$rs['district_name'];
        		}
        		return $opt;
        
        	}else{
        		return $rows;
        	}
        }
        function getNameDistict($id,$option=NULL){
        	$db=$this->getAdapter();
    		$sql = "SELECT d.dis_id,d.district_name FROM `cms_district` AS d,`cs_provinces` AS p WHERE d.pro_id = p.id AND d.pro_id =".$id;
        	$rows = $db->fetchAll($sql);
        	if($option!=null){
        		$opt = array(''=>"-----ជ្រើសរើស----");
        		foreach ($rows as $rs){
        			$opt[$rs['dis_id']]=$rs['district_name'];
        		}
        		return $opt;
        
        	}else{
        		return $rows;
        	}
        }
        function getNameCommune($id=null,$option=null){
        	$db=$this->getAdapter();
        	$this->_name='cms_commune';
    	$sql = " SELECT com_id,com_id AS id,commune_name,commune_name AS name,district_id FROM $this->_name WHERE status=1 AND commune_name!='' ";
        	if($id!=null){
        		$sql.=" AND id = $id";
        	}
        	$rows = $db->fetchAll($sql);
        	if($option!=null){
        		$opt = array(''=>"-----ជ្រើសរើស----");
        		foreach ($rows as $rs){
        			$opt[$rs['com_id']]=$rs['commune_name'];
        		}
        		return $opt;
        
        	}else{
        		return $rows;
        	}
        
        
        }
        function getEditetePartner($id){
        	$db=$this->getAdapter();
        	$sql="SELECT id,parent,partner_brand,partner_name,account_no,
        	nation_id,house_no,photo,group_no,street,commune,district,province,tel,mobile,note,is_cashoperation,cash_riel,
        	cash_dollar,cash_bath,date,status,address  FROM cms_partner where id = '$id'";
        	return $db->fetchRow($sql);
        }
        function getProvinceOption(){
        	$db = $this->getAdapter();
        	$sql = 'SELECT * FROM `cs_provinces`';
        	$row_province = $db->fetchAll($sql);
        	$option="";
        		//$option .= '<option value="" label="Select Faculty Teacher">Select Faculty Teacher</option>';
        	foreach($row_province as $province){
        		$option .= '<option  value="'.$province['id'].'" label="'.htmlspecialchars($province['name'], ENT_QUOTES).'">'.htmlspecialchars($province['name'], ENT_QUOTES).
        		"</option>";
        	}
        	return $option;
        }
        public function getNewAccountNumber($type){
        	$this->_name='cms_partner';
        	$db = $this->getAdapter();
        	$sql=" SELECT id ,account_no FROM $this->_name WHERE is_cashoperation = $type ORDER BY id DESC LIMIT 1 ";
        	$acc_no = $db->fetchOne($sql);
        	$new_acc_no= (int)$acc_no+1;
        	$acc_no= strlen((int)$acc_no+1);
        	$pre = ($type==1)?'P':'K';
        	
        	for($i = $acc_no;$i<5;$i++){
        		$pre.='0';
        	}
        	
        	return $pre.$new_acc_no;
        }
	}
?>