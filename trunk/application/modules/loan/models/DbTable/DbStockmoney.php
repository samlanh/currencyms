<?php
class Application_Model_DbTable_DbStockmoney extends Zend_Db_Table_Abstract
{
    protected $_name = 'cs_stockmoney';
    
	function _querystock($search =null){
		$session_user=new Zend_Session_Namespace('auth');
		$current_date = date("Y-m-d");
		$from_date =(empty($search['from_date']))? '1': "date >= '".$search['from_date']." 00:00:00'";
		$to_date = (empty($search['to_date']))? '1': " date <= '".$search['to_date']." 23:59:59'";
		$where = "  AND ".$from_date." AND ".$to_date ;
		 
		$sql = "SELECT id,currency_type,amount,note,date 
			FROM `cs_stockmoney` WHERE status =1";
	
		if ($search['type_money'] > 0){
			$where.= ' AND currency_type ='.$search['type_money'];
		}
		if ($search['tran_type'] > 0){
			if($search['tran_type']==1){
				$where.= ' AND amount > 0';
			}else{
				$where.= ' AND amount < 0';
			}
			
		}
		
		return $sql.$where;
	}
	function getStockmoneyListBy($search, $start, $limit){
		$db = $this->getAdapter();
		$orderby = " ORDER BY id DESC";
	
		$sql = $this->_querystock($search).$orderby." LIMIT ".$start.", ".$limit;
		if ($limit == 'All') {
			$sql = $this->_querystock($search).$orderby;
		}
		return $db->fetchAll($sql);
	}
	function getAllStockmoneyList($search=''){
		$db = $this->getAdapter();
		$sql = $this->_querystock();
	
		if(!empty($search)){
			$sql = $this->_querystock($search);
		}
		$_result = $db->fetchAll($sql);
		return count($_result);
	}

    public function AddStockMoney($data){
    	$db=$this->getAdapter();
    	$db->beginTransaction();
    	try{
    		if($data['submit_tran']==1){
    			$ids = explode(',',$data['record_row']);
    			$s = 1;
    			$sign="";
    		}else{
    			$ids = explode(',',$data['sub_record_row']);
    			$s = 2;
    			$sign="-";
    		}
	    	foreach ($ids as $i){
	    				if(!empty($data["amount".$s."_".$i])){
	    					$arr =array(
	    							'currency_type'=>$data["currency_type".$s."_".$i],
	    							'amount'=>$sign.$data["amount".$s."_".$i],
	    							'note'=>$data["note".$s."_".$i],
	    							'date'=>$data['date'],
	    							'create_date'=>date('Y-m-d'),
	    					);
	    					$this->insert($arr);
	    				}
    	}
    	  return  $db->commit();
    	} catch (Exception $e) {
    		echo $e->getMessage();
    		$db->rollBack();
    		echo $e->getMessage();exit();
    	}
    }
    public function deleteRecord($id){
    	$where = 'id = '.$id;
    	return $this->delete($where);
    }


}


