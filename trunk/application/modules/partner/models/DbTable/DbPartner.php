<?php 
Class Partner_Model_DbTable_DbPartner extends zend_db_Table_Abstract
	{
		protected $_name="cms_partner";
	function insertPartner($data){
			$db = $this->getAdapter();
			$db->beginTransaction();
		try{
			$arr=array(
					'parent'=>$data['main_branch'],
					'partner_brand'=>$data['branch_name'],
					'partner_name'=>$data['partner_name'],
					'nation_id'=>$data['cade_number'],
					'account_no'=>$data['accournt_number'],
					'nation_id'=>$data['cade_number'],
					'house_no'=>$data['home_number'],
					'group_no'=>$data['group_number'],
					'street'=>$data['street_number'],
					'commune'=>$data['commun_number'],
					'district'=>$data['district_number'],
					'province'=>$data['province_number'],
					'tel'=>$data['fax_number'],
					'mobile'=>$data['sele_phone'],
					'note'=>$data['note'],
					'cash_riel'=>$data['money_riel'],
					'cash_dollar'=>$data['money_usa'],
					'cash_bath'=>$data['money_bath'],
					'date'=>$data['date'],
					'address'=>$data['address'],
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
			$arr=array(
					'parent'=>$data['main_branch'],
					'partner_brand'=>$data['branch_name'],
					'partner_name'=>$data['partner_name'],
					'nation_id'=>$data['cade_number'],
					'account_no'=>$data['accournt_number'],
					'nation_id'=>$data['cade_number'],
					'house_no'=>$data['home_number'],
					'group_no'=>$data['group_number'],
					'street'=>$data['street_number'],
					'commune'=>$data['commun_number'],
					'district'=>$data['district_number'],
					'province'=>$data['province_number'],
					'tel'=>$data['fax_number'],
					'mobile'=>$data['sele_phone'],
					'note'=>$data['note'],
					'cash_riel'=>$data['money_riel'],
					'cash_dollar'=>$data['money_usa'],
					'cash_bath'=>$data['money_bath'],
					'date'=>$data['date'],
					'address'=>$data['address'],
					'is_cashoperation'=>$data['tran_type'],
					'status'=>$data['status']
		
			);
				$where="id=".$data['id'];
				//print_r($where);exit();
			$d=$this->update($arr,$where);
		   
				
		}
        function getAllPartner($search=null){
        	$db=$this->getAdapter();
        	$sql="SELECT p.id,
        		(SELECT s.partner_name FROM cms_partner AS s WHERE s.id=p.parent ) AS parent_name
        	,p.partner_name,p.partner_brand,p.account_no,
        	p.nation_id,(SELECT name FROM cs_provinces WHERE id = p.province) AS name,p.tel,p.mobile,p.cash_riel,
        	p.cash_dollar,p.cash_bath,p.date,p.status  FROM cms_partner AS p ";
        	return $db->fetchAll($sql);
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
        function getNamePartnerparent($id=null,$option=null){
        	$db=$this->getAdapter();
        	$sql = " select id,partner_name from cms_partner ";
        	if($id!=null){
        		$sql.=" AND id = $id";
        	}
        	$rows = $db->fetchAll($sql);
        	if($option!=null){
        		$opt = '';
        		foreach ($rows as $rs){
        			$opt[$rs['id']]=$rs['partner_name'];
        		}
        		return $opt;
        
        	}else{
        		return $rows;
        	}
        
        
        }
        function getEditetePartner($id){
        	$db=$this->getAdapter();
        	$sql="SELECT id,parent,partner_brand,partner_name,account_no,
        	nation_id,house_no,group_no,street,commune,district,province,tel,mobile,note,is_cashoperation,cash_riel,
        	cash_dollar,cash_bath,date,status,address  FROM cms_partner where id = '$id'";
        	return $db->fetchRow($sql);
        }
	}
?>