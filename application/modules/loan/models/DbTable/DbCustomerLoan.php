<?php

class Application_Model_DbTable_DbCustomerLoan extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_borrow';
    
    public function getAllFund($search=""){
    	$db = $this->getAdapter();
    	
    }
    public function AddNewTranLoan($data){
    	try{
	    	$db = $this->getAdapter();
	    	$db->beginTransaction();
	    	$session_user=new Zend_Session_Namespace('auth');
	    	$user_id=$session_user->user_id;
	    	$is_allinterest = 0;
	    	if(!empty($data['all_interest'])){ 
	    		$is_allinterest=$data['all_interest'];}
	    	$arr = array(
	    			'sender_id'=>$data['sender'],
	    			'invoice'=>$data['invoice_no'],
	    			'loan_date'=>$data['loan_date'],
	    			'user_id'=>$user_id,
	    			'status'=>1,
	    			'is_allinterest'=>$is_allinterest,
	    			'is_orgdebt'=>1
	    			);
	   		 $id =  $this->insert($arr);
	   		 $process = 0;
	   		 $amount = 0;$new_debt=0;
	   		 $dbc = new Application_Model_DbTable_DbCapital();
	   		 $this->_name='cs_borrow_detail';
	   		 
	   		 for($i=1; $i<4; $i++){//for add capital detail and update current capital by staff
	   		 	if(!empty($data['borrow_dollar']) AND $i==1){
	   		 		$process = 1;
	   		 		$curr_type = 1;
	   		 		$amount = $data['borrow_dollar']+$data['debt_dollar'];
	   		 		$new_debt = $data['borrow_dollar'];
	   		 		$interest_rate = (empty($data['all_interest'])==0?$data['total_interest']:$data['interest_dollar']);
	   		 	}elseif(!empty($data['borrow_bath']) AND  $i==2){
	   		 			$process = 1;
	   		 			$curr_type = 2;
	   		 			$amount = $data['borrow_bath']+$data['debt_bath'];;
	   		 			$new_debt = $data['borrow_bath'];
	   		 			$interest_rate = (empty($data['all_interest'])==0?$data['total_interest']:$data['interest_bath']);
	   		 	}elseif(!empty($data['borrow_riel']) AND  $i==3){
	   		 		$process = 1;
	   		 		$curr_type = 3;
	   		 		$amount = $data['borrow_riel']+$data['debt_khmer'];
	   		 		$new_debt = $data['borrow_riel'];
	   		 		$interest_rate = (empty($data['all_interest'])==0?$data['total_interest']:$data['interest_riel']);
	   		 	}

	   		 	if($process==1){//with loan tran_type = 5
	   		 		$this->updateStatustoPaid($data['sender'], $curr_type);
	   		 		$arr = array(
		   		 	    'br_id'=>$id,
		   		 		'currency_type'=>$curr_type,
		   		 		'loan_amount'=>$amount,
	   		 			'total_money'=>$new_debt,
		   		 		'laon_rate'=>$interest_rate,
		   		 		'BD'=>$data['BD'],
		   		 		'RD'=>$data['RD'],
		   		 		'RB'=>$data['RB'],
		   		 		'status'=>1,
	   				 );
	   		 		$l_id = $this->insert($arr);
	   		 		$arr = array(
	   		 				'tran_id' 	=>$l_id,
	   		 				'tran_type' =>5,
	   		 				'curr_type'	=>$curr_type,
	   		 				'amount'	=>-$new_debt,//cos loan money to customer
	   		 				'user_id'	=>$user_id,
// 	   		 				'date'		=>$data['loan_date']
	   		 				);
	   		 		
	   		 		$dbc->addMoneyToCapitalDetail($arr);
	   		 		 
	   		 		$rs = $dbc->DetechCapitalExist($session_user->user_id, $curr_type,null);
	   		 		if(!empty($rs)){//update old user
	   		 			$arr = array(
	   		 					'amount'=>$rs['amount']-$new_debt
	   		 			);
	   		 			$dbc->updateCurrentBalanceById($rs['id'],$arr);
	   		 		}else{
	   		 			$date = date("Y-m-d H:i:s");
// 	   		 			$date = $data['loan_date'];
	   		 			$arr =array(
	   		 					'amount'=>-$new_debt,
	   		 					'currencyType'=>$curr_type,
	   		 					'userid'=>$user_id,
	   		 					'statusDate'=>$date
	   		 			);
	   		 			$dbc->AddCurrentBalanceById($arr);
	   		 		}
	   		 	}
	   		 	$process = 0;
	   		 }
   		 	$db->commit();
    	}catch(Exception $err){
    		$db->rollBack();
//     		echo $err->getMessage();exit();
    	}
   		 
    }
    public function updateStatustoPaid($sender_id,$curr_type){
    	$this->_name='cs_borrow_detail';
    	$sql =" SELECT id FROM `cs_borrow` AS b ,`cs_borrow_detail` AS bd
					WHERE bd.`currency_type` = $curr_type AND
					   b.sender_id=$sender_id AND bd.status != 3 GROUP BY id ";
    	$db = $this->getAdapter();
    	$rows = $db->fetchAll($sql);
    	if(!empty($rows)){
    		foreach($rows As $key =>$row){
    			$arr = array(
    					'status'=>3   //paid already
    			);
    			$where = $db->quoteInto('id=?', $row['id']);
    			$this->update($arr, $where);
    			 
    		}
    	}
    	 
    }
    public function updateTranLoanById($data){
    	try{
    	$db = $this->getAdapter();
    	$db->beginTransaction();
    	$session_user=new Zend_Session_Namespace('auth');
    	$user_id = $session_user->user_id;
    	$is_allinterest = 0;
    	
    	if(!empty($data['all_interest'])){
    		$is_allinterest=$data['all_interest'];
    	}
    	$arr = array(
    			'sender_id'=>$data['sender'],
    			'invoice'=>$data['invoice_no'],
    			'loan_date'=>$data['loan_date'],
    			'user_id'=>$user_id,
    			'status'=>1,
    			'is_allinterest'=>$is_allinterest
    	);
    	
    	$where = $db->quoteInto('b_id=?', $data['tran_id']);
   		$this->update($arr, $where);
   		
   		$db_tran=new Application_Model_DbTable_DbCustomerLoan();
   		$rows = $db_tran->getBorrowDetail($data['tran_id']);
   		$dbc = new Application_Model_DbTable_DbCapital();
   		$this->_name='cs_capital_detail';
   		
   		foreach ($rows as $key =>$rs){
   			$row = $dbc->DetechCapitalExist($user_id, $rs['currency_type'],null);
   			if(!empty($row)){
   				$arr = array(
   						'amount'=>$row['amount']+$rs['loan_amount']
   				);
   				$dbc->updateCurrentBalanceById($row['id'],$arr);
   				
   				$where = ' tran_id = '.$rs['id'].' AND tran_type = 5 ';
   				$this->delete($where);//for delete capital detail
   			}
   		}
   		
			$this->_name='cs_borrow_detail';
			$where = 'br_id = '.$data['tran_id'];
			$this->delete($where);
			
	   		$process = 0;
	   		$amount = 0;
   	
   		for($i=1; $i<4; $i++){//for add capital detail and update current capital by staff
   			if(!empty($data['borrow_dollar']) AND $i==1){
   				$process = 1;
   				$curr_type = 1;
   				$amount = $data['borrow_dollar']+($data['debt_dollar']-$data['old_dollar']);
   				if($data['sender']!=$data['old_sender']){
   					$amount = $data['borrow_dollar']+($data['debt_dollar']);
   				}
   				
   				$interest_rate = (empty($data['all_interest'])==0?$data['total_interest']:$data['interest_dollar']);
   			}elseif(!empty($data['borrow_bath']) AND  $i==2){
   				$process = 1;
   				$curr_type = 2;
   				$amount = $data['borrow_bath']+($data['debt_bath']-$data['old_bath']);
   				if($data['sender']!=$data['old_sender']){
   					$amount = $data['borrow_bath']+($data['debt_bath']);
   				}
   				
   				$interest_rate = (empty($data['all_interest'])==0?$data['total_interest']:$data['interest_bath']);
   			}elseif(!empty($data['borrow_riel']) AND  $i==3){
   				$process = 1;
   				$curr_type = 3;
   				$amount = $data['borrow_riel']+($data['debt_khmer']-$data['old_riel']);
   				if($data['sender']!=$data['old_sender']){
   					$amount = $data['borrow_riel']+($data['debt_khmer']);
   				}
   				$interest_rate = (empty($data['all_interest'])==0?$data['total_interest']:$data['interest_riel']);
   			}
   		
   			if($process==1){//with loan tran_type = 5
   				$arr = array(
   						'br_id'=>$data['tran_id'],
   						'currency_type'=>$curr_type,
   						'loan_amount'=>$amount,
   						'laon_rate'=>$interest_rate,
   						'BD'=>$data['BD'],
   						'RD'=>$data['RD'],
   						'RB'=>$data['RB'],
   						'status'=>1,
   				);
   				$l_id = $this->insert($arr);
   				$arr = array(
   						'tran_id' 	=>$l_id,
   						'tran_type' =>5,
   						'curr_type'	=>$curr_type,
   						'amount'	=>-$amount,//cos loan money to customer
   						'user_id'	=>$user_id);
   					
   				$dbc->addMoneyToCapitalDetail($arr);
   		
   				$rs = $dbc->DetechCapitalExist($session_user->user_id, $curr_type,null);
   				if(!empty($rs)){//update old user
   					$arr = array(
   							'amount'=>$rs['amount']-$amount
   					);
   					$dbc->updateCurrentBalanceById($rs['id'],$arr);
   				}else{
   					$date = date("Y-m-d H:i:s");
   					$arr =array(
   							'amount'=>-$amount,
   							'currencyType'=>$curr_type,
   							'userid'=>$user_id,
   							'statusDate'=>$date
   					);
   					$dbc->AddCurrentBalanceById($arr);
   				}
   			}
   			$process = 0;
   		}
   		$db->commit();
    	}catch (Exception $e){
    		$db->rollBack();
    	}
    }
    private function _queryloan($search =null){
    	$session_user=new Zend_Session_Namespace('auth');
    	$current_date = date("Y-m-d");
    	$from_date =(empty($search['from_date']))? '1': "loan_date >= '".$search['from_date']." 00:00:00'";
    	$to_date = (empty($search['to_date']))? '1': "loan_date <= '".$search['to_date']." 23:59:59'";
    	$where = "  AND ".$from_date." AND ".$to_date ;
			$sql = " SELECT 
						  br.b_id,
						  br.sender_id,
						  s.sender_name,
						  s.tel,
						  s.acc_no,
						  br.invoice,
						  br.loan_date,
						  br.user_id,
						  br. status,
						  br. is_allinterest 
						FROM
						  `cs_borrow` AS br,`cs_borrow_detail` AS bd,cs_sender AS s
						WHERE s.sender_id = br.sender_id AND br.b_id = bd.br_id AND br.status!=2 AND bd.status!=2 ";
    
    	if($search['sender']>0){
    		$where.=" AND br.sender_id = ".$search['sender'];
    	}
    	if (!empty($search['txt_search'])){
    		$where .= " AND s.tel LIKE '%{$search['txt_search']}%'";
    	}
    	$group = ' GROUP BY br.`b_id`';
//     	echo $sql.$where.$group;
    	return $sql.$where.$group;
    }
    function getTranLoanwListBy($search, $start, $limit){
    	$db = $this->getAdapter();
    	$orderby = " ORDER BY br.b_id DESC";
    
    	$sql = $this->_queryloan($search).$orderby." LIMIT ".$start.", ".$limit;
    	if ($limit == 'All') {
    		$sql = $this->_queryloan($search).$orderby;
    	}
//     	    	echo $sql;
    	return $db->fetchAll($sql);
    }
    function getTranLoanListTotal($search=''){
    	$db = $this->getAdapter();
    	$sql = $this->_queryloan();
    
    	if(!empty($search)){
    		$sql = $this->_queryloan($search);
    	}
    	$_result = $db->fetchAll($sql);
    	return count($_result);
    }
    public function getTranLaonById($tran_id){
    	$db = $this->getAdapter();
    	$sql = "SELECT * FROM
				  cs_borrow
				WHERE b_id = $tran_id limit 1";
    	return $db->fetchRow($sql);
    }
    public function getBorrowDetail($tran_id){
    	$db = $this->getAdapter();
    	$sql = "SELECT * FROM cs_borrow_detail WHERE br_id = $tran_id AND status!=2 AND delete_status!=1 ORDER BY currency_type LIMIT 3 ";
    	return $db->fetchAll($sql);
    }
    public function getAddLoanSenderNameById($sender_id){
    	$db = $this->getAdapter();
    	$sql = "SELECT
    	b.*,
    	bd.*
    	FROM
    	cs_borrow AS b
    	INNER JOIN cs_borrow_detail AS bd ON bd.br_id = b.b_id
    	WHERE
    	b.sender_id = $sender_id  AND
    	b.`status` != 3 AND
    	bd.`status` != 3 AND
    	bd.delete_status = 0
    	ORDER BY
    	bd.currency_type ASC,b.loan_date ";
    	return $db->fetchAll($sql);
    }
    

	
	
}


