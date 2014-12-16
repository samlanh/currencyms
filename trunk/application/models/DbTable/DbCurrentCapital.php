<?php
/**
 * @Date 19/06/2013
 * @author sovann
 * @version 1.0
 */
class Application_Model_DbTable_DbCurrentCapital extends Zend_Db_Table_Abstract
{
    protected $_name = 'cs_capital_detail';
    
//     function getCapitalDetailById($tran_id,$tran_type,$curr_type){//for record capital detail by id 
//     	$db = $this->getAdapter();
//     	$this->_name='cs_capital_detail';
//     	$sql = " SELECT * FROM ". $this->_name ." WHERE tran_id = $tran_id AND tran_type = $tran_type AND curr_type =1 ";
//     	return $db->fetchAll($sql);
//     }
    function _querycapital($search =null){
    	$session_user=new Zend_Session_Namespace('auth');
    	$current_date = date("Y-m-d");
    	$from_date =(empty($search['from_date']))? '1': "date >= '".$search['from_date']." 00:00:00'";
    	$to_date = (empty($search['to_date']))? '1': " date <= '".$search['to_date']." 23:59:59'";
    	$where = "  AND ".$from_date." AND ".$to_date ;
    	
    	$sql = "SELECT 
		    	cp.id,
		    	CONCAT(first_name,' ',last_name) AS agent_name,
		    	tran_id,
		    	tran_type,
		    	curr_type,
		    	amount,
		    	sign,
		    	date,
		    	status,
		    	income,
		    	user_id
		    FROM ". $this->_name ." AS cp ,`cs_users` AS c WHERE tran_type = 1 AND status = 1 AND c.id = cp.user_id  ";
    
    	if($search['staff_name']>0){
    		$where.=" AND cp.user_id = ".$search['staff_name'];
    	}
    	if ($search['type_money'] > 0){
    		$where.= ' AND curr_type ='.$search['type_money'];
    	}
    	return $sql.$where;
    }
    function getTranCapitalListBy($search, $start, $limit){
    	$db = $this->getAdapter();
    	$orderby = " ORDER BY id DESC";
    
    	$sql = $this->_querycapital($search).$orderby." LIMIT ".$start.", ".$limit;
    	if ($limit == 'All') {
    		$sql = $this->_querycapital($search).$orderby;
    	}
    	return $db->fetchAll($sql);
    }
    function getTranCapitalListTotal($search=''){
    	$db = $this->getAdapter();
    	$sql = $this->_querycapital();
    
    	if(!empty($search)){
    		$sql = $this->_querycapital($search);
    	}
    	$_result = $db->fetchAll($sql);
    	return count($_result);
    }
    function getCapitalDetailById($id,$tran_type){//for record capital detail by id
    	$db = $this->getAdapter();
    	$this->_name='cs_capital_detail';
    	$sql = " SELECT * FROM ". $this->_name ." WHERE id = $id AND tran_type = $tran_type AND status=1 limit 1";
    	return $db->fetchRow($sql);
    }
    function updateCapitalDetailById($data){
    	$this->_name='cs_capital_detail';
    	$db = $this->getAdapter();
    	$db->beginTransaction();
    	try{
	    	if(!empty($data['dollar'])){
	    		$amount = $data['dollar'];
	    		$currency_type = 1;
	    	}elseif(!empty($data['bath'])){
	    		$amount = $data['bath'];
	    		$currency_type = 2;
	    	}elseif(!empty($data['rail'])){
	    		$amount = $data['rail'];
	    		$currency_type = 3;
	    	}
	    	$sign = (($amount>=0)?1:0);
	    	$_arr = array(
	    			'amount'	=>$amount,
	    			'user_id'	=>$data['user_id'],
	    			'sign'		=>$sign,
	    			'date'		=> $data['date']
	    	);
	    	$where = $db->quoteInto('id = ?', $data['tran_id']);
	    	$this->update($_arr, $where);
	    	$dbdata = new Application_Model_DbTable_DbCapital();
	    	if($data['user_id']!=$data['old_user']){
	    		$rs = $dbdata->DetechCapitalExist($data['user_id'], $currency_type,$data['old_date']);
	    		if(!empty($rs)){//update new user
	    			$arr = array(
	    					'amount'=>$rs['amount']+$amount,
	    					'statusDate'=> $data['date']
	    			);
// 	    			print_r($arr);exit();
	    			$dbdata->updateCurrentBalanceById($rs['id'],$arr);
	    		}else{
	    		$date = date("Y-m-d H:i:s");//change it to current edit 
	    			$arr =array(
	    					'amount'=>$amount,
	    					'currencyType'=>$currency_type,
	    					'userid'=>$data['user_id'],
	    					'statusDate'=>$data['date']
	    			);
	    			$dbdata->AddCurrentBalanceById($arr);
	    		}
	    		$rs = $dbdata->DetechCapitalExist($data['old_user'], $currency_type,$data['old_date']);
	    		if(!empty($rs)){//update old user
	    			$arr = array(
	    					'amount'=>$rs['amount']-$data['old_amount'],
	    					'statusDate'=> $data['date']
	    			);
	    			$dbdata->updateCurrentBalanceById($rs['id'],$arr);
	    		}
	    	}else{//if the same user edite 
	    		$old_amount = (float) $data['old_amount'];//convert to float
	    		$new_amount = (float) $amount;
				if($old_amount!=$new_amount){
					$value = $new_amount-$old_amount;
					$rs = $dbdata->DetechCapitalExist($data['user_id'], $currency_type,$data['old_date']);
					if(!empty($rs)){
						$arr = array(
								'amount'=>$rs['amount']+$value,
								'statusDate'=> $data['date']
								
						);
						$dbdata->updateCurrentBalanceById($rs['id'],$arr);
					}else{
// 						$date = date("Y-m-d H:i:s");
						$arr =array(
								'amount'=>$amount,
								'currencyType'=>$currency_type,
								'userid'=>$data['user_id'],
								'statusDate'=>$data['date']
						);
						$dbdata->AddCurrentBalanceById($arr);
					}
				}else{
					$rs = $dbdata->DetechCapitalExist($data['user_id'], $currency_type,$data['old_date']);
					if(!empty($rs)){
						$arr = array(
								'statusDate'=> $data['date']
					
						);
						$dbdata->updateCurrentBalanceById($rs['id'],$arr);
					}else{
						// 						$date = date("Y-m-d H:i:s");
						$arr =array(
								'amount'=>$amount,
								'currencyType'=>$currency_type,
								'userid'=>$data['user_id'],
								'statusDate'=>$data['date']
						);
						$dbdata->AddCurrentBalanceById($arr);
					}
					
				}
	    	}
    	$db->commit();
    }catch (Exception $e) {
    	$db->rollBack();
    }
  }
  public function updateCapitalDetail(){
  	$this->_name='cs_capital_detail';
  	
  	
  }
    
}


