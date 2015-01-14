<?php 
	class Keeping_Model_DbTable_DbKeeping extends zend_db_Table_Abstract
	{
	protected $_name="cms_keeping";
		function insertKeeping($data){
		$db = $this->getAdapter();//ស្ពានភ្ជាប់ទៅកាន់Data Base
		$db->beginTransaction();//ទប់ស្កាត់មើលការErrore , មានErrore វាមិនអោយចូល
			try{
			$arr=array(
						'client_name'=>$data['send_name'],
						'payment_term'=>$data['pay_term'],
						'date_keeping'=>$data['date'],
						'amount_keeping'=>$data['amount_month'],
						'epx_date'=>$data['epx_date'],
						'invoice_numer'=>$data['report'],
						
	// 					'status'=>$data['withdraw_dollar'],
	// 					'date'=>$data['withdraw_bath'],
	// 					'user_id'=>$data['withdraw_riel'],
				);
			
			$id=$this->insert($arr);
			
				$this->_name='cms_keepingdetail';
				$ids = explode(',',$data['record_row']);
				foreach ($ids as $i){
					$arr = array(
							'keeping_id'=>$id,
							'currency_type'=>$data['type_money'.$i],
							'money_inacc'=>$data['money_inacc'.$i],
							'cut_money'=>empty($data['is_spacial'.$i])?0:1,
							'commission'=>$data['commission'.$i],
							'total_amount'=>$data['total_amount'.$i],
							'recieve_amount'=>$data['recieve_amount'.$i],
							'lbltotal_return'=>$data['lbltotal_return'.$i],
							//'recieve_amount'=>$data['amount_exchanged'.$i],
							'note'=>$data['note'.$i],
				
					);
					
					$this->insert($arr);
				}
				$db->commit();//if not errore it do....
			}catch (Exception $e){
				$db->rollBack();//អោយវាវិលត្រលប់ទៅដើមវីញពេលណាវាជួបErrore
				
			}
		
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
		function getAllKeeping(){
			$db=$this->getAdapter();
			$sql = "SELECT * FROM cms_keeping ORDER BY client_name ";
			
			return $db->fetchAll($sql);
		}
	}
?>