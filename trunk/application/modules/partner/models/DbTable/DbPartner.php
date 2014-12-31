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
					'nation_id'=>$data['cade_number'],
					'house_no'=>$data['home_number'],
					'group_no'=>$data['group_number'],
					'street'=>$data['street_number'],
					'commune'=>$data['commun_number'],
					'district'=>$data['district_number'],
					'province'=>$data['province_number'],
					'tel'=>$data['phone_number'],
					'mobile'=>$data['fax_number'],
					'note'=>$data['note'],
					'cash_riel'=>$data['money_riel'],
					'cash_dollar'=>$data['money_usa'],
					'cash_bath'=>$data['money_bath'],
					'date'=>$data['status_getmoney'],
				
			);
			print_r($arr);exit();
			$this->insert($arr);
				
			
		}
 
	}
?>