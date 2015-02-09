<?php
/**
 * @Date 19/06/2013
 * @author sovann
 * @version 1.0
 */
class Application_Model_DbTable_DbCapitalAgent extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_current_capital_agent';
    
    /**
     * Get current balances 
     * @param int $user_id
     * @param int $currency_type
     * @return number amouont of current user and currency type
     */
    function getCurrentBalanceByUser($user_id, $currency_type){
    	$db = $this->getAdapter();
    	$sql = "SELECT amount FROM ". $this->_name ." WHERE agent_id=". $user_id . " AND currencyType=". $currency_type;
    	$amount = $db->fetchOne($sql);    	
    	if(!empty($amount)){
    		return $amount;
    	}
    	return 0;
    }
    
    /**
     * Get curent balance all currncy type by user
     * @param int $user_id
     * @return array <number, number, number>
     */
    function getCurrentBallancesByCurrentUser($user_id){
    	$cur = new Application_Model_DbTable_DbCurrencies();
    	$cur_type = $cur->getCurrencyList();
    	$balance = array();
    	foreach($cur_type AS $i => $t){
    		if($t['symbol'] == "$"){
    			$balance["dollar"] = $this->getCurrentBalanceByUser($user_id, $t['id']);
    		}
    		elseif($t['symbol'] == "B"){
    			$balance["bath"] = $this->getCurrentBalanceByUser($user_id, $t['id']);
    		}
    		elseif($t['symbol'] == "R"){
    			$balance["rail"] = $this->getCurrentBalanceByUser($user_id, $t['id']);
    		}
    	}
    	return $balance;
    }
    
    function addBalanceByUser($user_id, $data){
    	$db = $this->getAdapter();
    	$db_loan = new Application_Model_DbTable_DbLoanAgent();
    	$db->beginTransaction();
    	try {
    		foreach ($data as $k => $val){
    			if($k != "dollar" && $k != "bath" && $k != "rail") {
    				continue;
    			}
    			$currency_type = 0;
    			if($k == "dollar"){
    				$currency_type = 1;
    			}
    			elseif($k == "bath"){
    				$currency_type = 2;
    			}
    			elseif($k == "rail"){
    				$currency_type = 3;
    			}
    			$amount = floatval($this->getCurrentBalanceByUser($user_id, $currency_type)) +  floatval($val);
    			$this->updateBalanceByUserId($user_id, $currency_type, $amount);
    			$db_loan->saveLoanByUserId($user_id, $currency_type, $val);
    		}    		
    		return  $db->commit();
    	} catch (Exception $e) {
    		$db->rollBack();
//     		echo $e->getMessage(); exit;
    	}
    	
    }
    
    /**
     * Check recodre exits on not
     * @param int $user_id
     * @param int $currency_type
     * @return if exits recorde return id else return false
     */
    function checkExits($user_id, $currency_type){
    	$db = $this->getAdapter();
    	$sql = "SELECT id FROM ". $this->_name ." WHERE agent_id=". $user_id . " AND currencyType=". $currency_type;
    	$id = $db->fetchOne($sql);
    	if(!empty($id)){
    		return $id;
    	}
    	return false;
    }
    
    /**
     * For update balance of user for Transfer modules
     * @param int $user_id
     * @param int $currency_type
     * @param double $amount
     */
    function updateBalanceByUserId($user_id, $currency_type, $amount){
    	$id = $this->checkExits($user_id, $currency_type);
    	$date = date("Y-m-d H:i:s");
    	if(!empty($id)){
	    	$data=array(
	    			"amount"=>$amount,
	    			"statusDate"=>$date
	    	);
	    	$where = "agent_id=". $user_id . " AND currencyType=". $currency_type;
	    	$this->update($data, $where);
    	}
    	else{
    		$data=array(
    				"amount"=>$amount,
    				"agent_id"=>$user_id,
    				"currencyType"=>$currency_type,
    				"statusDate"=>$date
    				);
    		$this->insert($data);
    	}    	
    }
    
    /**
     * Update Balance for agent change or amonut type change or amount change
     * @param int $tran_type
     * @param int $old_agent
     * @param int $old_amount_type
     * @param double $old_amount
     * @param int $new_agent
     * @param int $new_amount_type
     * @param double $new_amount
     */
    function updateBalanceWithCondiction($tran_type, $old_agent, $old_amount_type, $old_amount, $new_agent, $new_amount_type, $new_amount){
    	
    	$old_balance = $this->getCurrentBalanceByUser($old_agent, $old_amount_type) - $old_amount;
    	$new_balance = $this->getCurrentBalanceByUser($new_agent, $new_amount_type) + $new_amount;
    	
    	if($tran_type == 1){
    		$old_balance = $this->getCurrentBalanceByUser($old_agent, $old_amount_type) + $old_amount;
    		$new_balance = $this->getCurrentBalanceByUser($new_agent, $new_amount_type) - $new_amount;
    	}
    	$this->updateBalanceByUserId($old_agent, $old_amount_type, $old_balance);
    	$this->updateBalanceByUserId($new_agent, $new_amount_type, $new_balance);
    }
}


