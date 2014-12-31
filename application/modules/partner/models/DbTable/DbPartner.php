<?php 
Class Partner_Model_DbTable_DbPartner extends zend_db_Table_Abstract
	{
		protected $_name="cms_partner";
		Function insertPartner($data){
			$arr=array(
					'parent'=>$data['main_branch'],
					'partner_brand'=>$data['branch_name'],
					'partner_name'=>$data['partner_name'],
					'nation_id'=>$data['cade_number'],
					'account_no'=>$data['accournt_number'],
					'nation_id'=>$data['nation_id'],
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
					'date'=>DATE('Y-m-d'),
					'is_cashoperation'=>$data['tran_type'],
				
			);
			
			$this->insert($arr);
				
			
		}
        function getAllPartner($search=null){
        	$db=$this->getAdapter();
        	$sql="SELECT id,parent,partner_brand,partner_name,account_no,
        	nation_id,house_no,group_no,street,commune,district,province,tel,mobile,note,is_cashoperation,cash_riel,
        	cash_dollar,cash_bath,DATE,STATUS  FROM cms_partner ";
        	return $db->fetchAll($sql);
        }
	}
?>