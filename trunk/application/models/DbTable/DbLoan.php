<?php

class Application_Model_DbTable_DbLoan extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_loan';
    
    /**
     * Check record exits on not
     * @param int $user_id
     * @param int $currency_type
     * @return if exits recorde return id else return false
     */
    function checkExits($user_id, $currency_type){
    	$db = $this->getAdapter();
    	$sql = "SELECT id FROM ". $this->_name ." WHERE userid=". $user_id . " AND currencyType=". $currency_type;
    	$id = $db->fetchOne($sql);
    	if(!empty($id)){
    		return $id;
    	}
    	return false;
    }
    
    /**
     * For save loan of user for exchange modules
     * @param int $user_id
     * @param int $currency_type
     * @param double $amount
     */
    function saveLoanByUserId($user_id, $currency_type, $amount){
    	$data=array(
    				"amount"=>$amount,
    				"userid"=>$user_id,
    				"currencyType"=>$currency_type,
    				"loanDate"=>date("Y-m-d H:i:s"),
    				"staus"=>"income"
    			);
    	$this->insert($data);
    }
 	
    /**
     * Get all transaction that user balance
     * @param init $user_id
     * @return Array()|NULL
     */
    function getLoanDataByUserId($user_id, $month=""){
    	$where = "userid = ". $user_id;
    	if($user_id<0){
    		$where = "1";
    	}
    	
    	if(!empty($month)){    	
    		$where .= " AND MONTH(loanDate) = " . $month;
    	}
    	
    	//`id``currencyType``loanDate``amount``userid``staus`
    	$db = $this->getAdapter();
    	$sql = "SELECT l.`id`,l.`currencyType`,l.`loanDate`,l.`amount`,CONCAT(u.`last_name`,' ', u.`first_name`) AS user_name  
    			FROM ". $this->_name ." AS l INNER JOIN
    					cs_users AS u ON(l.userid=u.id)  
    			WHERE ". $where . " ORDER BY id, userid";
    	
    	$tmp_amount = $db->fetchAll($sql);
    	$amount = array(); $k=0;
    	for($i=0; $i < sizeof($tmp_amount); $i=$i+3){
    		$amount[$k]['date'] = $tmp_amount[$i]['loanDate'];
    		$amount[$k]['name'] = $tmp_amount[$i]['user_name'];
    		for($j=$i; $j< $i+3; $j++){
    			if($tmp_amount[$j]['currencyType'] == 1){
	    			$amount[$k]['dollar'] = $tmp_amount[$j]['amount'];
    			}
    			elseif($tmp_amount[$j]['currencyType'] == 2){
	    			$amount[$k]['bath'] = $tmp_amount[$j]['amount'];
    			}
    			elseif($tmp_amount[$j]['currencyType'] == 3){
	    			$amount[$k]['rail'] = $tmp_amount[$j]['amount'];
    			}
    		}
    		$k++;
    	}
//     	print_r($amount); exit;
    	if(!empty($amount)){
    		return $amount;
    	}
    	return null;
    }
}


