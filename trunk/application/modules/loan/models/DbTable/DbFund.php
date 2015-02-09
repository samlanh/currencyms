<?php

class Application_Model_DbTable_DbFund extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_trans_found';
    function getAllTransactionFund($search = ''){
    	$session_user=new Zend_Session_Namespace('auth');
    
    	//filter between date from ... to ...
    	$from_date =(empty($search['from_date']))? '1': " f.date_refund >= '".$search['from_date']." 00:00:00'";
    	$to_date = (empty($search['to_date']))? '1': " f.date_refund <= '".$search['to_date']." 23:59:59'";
    	$where = "WHERE ".$from_date." AND ".$to_date;
    
    	$sql = " SELECT
    	f.found_id,
    	f.tran_id,
    	f.invoice_found,
    	f.refund,f.capital,
    	f.curency_type,
    	DATE_FORMAT(`date_refund`, '%d/%m/%Y') AS date_refund,
    	s.sender_name,
    	f.sender_id
    	FROM
    	cs_trans_found AS f
    	INNER JOIN cs_sender AS s ON f.sender_id = s.sender_id  AND f.`status` = 0 ";
    
    	if(empty($search)){
    		return $sql.$where;
    	}
    	if(($search['sender_name']>-1)){
    		$where.=" AND f.sender_id = ".$search['sender_name']."  ";
    
    	}
    	$orderby = " ORDER BY s.sender_name,date_refund,f.curency_type, found_id";
    	$db= $this->getAdapter();
// echo $sql.$where.$orderby;exit;
    
    	return $db->fetchAll($sql.$where.$orderby);
    }
    
    public function getAllFund($search=""){
    	$db = $this->getAdapter();
    	$from_date =(empty($search['from_date']))? '1': "date_refund >= '".$search['from_date']." 00:00:00'";
    	$to_date = (empty($search['to_date']))? '1': "date_refund <= '".$search['to_date']." 23:59:59'";
    	
    	$where = "  WHERE ".$from_date." AND ".$to_date;
    	
    	$sql = " SELECT
    	found_id,
    	invoice_found,
    	sender_name,
    	refund_dollar,
    	refund_bath,
    	`refund_riel`,
    	date_refund
    	FROM
    	`cs_trans_found` ";
    	if (!empty($search['sender_name']) AND $search['sender_name']!=-1){
   		$where.= " AND sender_name = '".$search['sender_name']."'";
    	}
    	
    $where.=" ORDER BY sender_name ";
    	return $db->fetchAll($sql.$where);
    }
    public function getTotalmoneyOwe($ower,$curr_type,$from,$to){
    	$db = $this->getAdapter();
    	$from_date =(empty($from))? '1': "date_refund >= '".$from." 00:00:00'";
    	$to_date = (empty($to))? '1': "send_date <= '".$to." 23:59:59'";
    	
    	$sql_owe = " SELECT 
				  SUM(total_money_owe) AS total_owe 
				FROM
				  `cs_transactions_owe` 
				  WHERE $to_date AND sender_name= '".$ower."' AND amount_type=$curr_type 
				GROUP BY amount_type ";
    	$total_owe=$db->fetchOne($sql_owe);

    	$d = new DateTime($from);
		$d->modify( 'previous day' );
		$from =  $d->format( 'Y-m-d' );
		//echo $from;
    	
    	$from_date =(empty($from))? '1': "date_refund <= '".$from." 00:00:00'";
    	
    	$sql_fund = " SELECT 
					  sender_name,
					  refund_dollar,
					  refund_bath,
					  refund_riel 
					FROM
					  `cs_trans_found` 
					WHERE sender_name = '".$ower."' AND
					$from_date GROUP BY sender_name ";
    	//echo $sql_fund;exit();
    	$total_fund=$db->fetchRow($sql_fund);
    	if($curr_type==1){
    		$toal = $total_fund["refund_dollar"];
    	}
    	elseif($curr_type==2){
    		$toal = $total_fund["refund_bath"];
    	}
    	else{
    		$toal = $total_fund["refund_riel"];
    	}
        return $total_owe-$toal;
    }
	private function _buildQuery($search = ''){

		$from_date =(empty($search['from_date']))? '1': "mt.send_date >= '".$search['from_date']." 00:00:00'";
		$to_date = (empty($search['to_date']))? '1': "mt.send_date <= '".$search['to_date']." 23:59:59'";
		$where = "WHERE ".$from_date." AND ".$to_date;
		
		
		$sql = " SELECT 
			  found_id,
			  sender_name,
			  refund_dollar,
			  refund_bath,
			  `refund_riel`,
			  date_refund 
			FROM
			  `cs_trans_found` ";
		
		if(empty($search)){
			//echo $sql.$where; exit();
			return $sql.$where;
		}
		
		if (!empty($search['txt_search'])){
			
			$where.= "mt.sender_name LIKE '%{$search['txt_search']}%'";
		}
		
		return $sql.$where;
	}
	
	public function getAllTranOwe($search=''){
		$db = $this->getAdapter();
		
		//$from_date =(empty($search['from_date']))? '1': " send_date >= '".$search['from_date']." 00:00:00'";
		//$to_date = (empty($search['to_date']))? '1': " send_date <= '".$search['to_date']." 23:59:59'";
		
			$sql = "SELECT 
					  id,
					  money_tran_id,
					  sender_name,
					  `invoice_no`,
					  total_money AS amount_owe,
					  send_date,
					  amount_type 
					FROM
					  `cs_transactions_owe` 
					WHERE status_loan = 1 ";
			
			if($search['sender_name']!=-1){
				$sql.=" AND sender_name LIKE '%".$search['sender_name']."%'  ";
			}
			$sql.=" ORDER BY sender_name ";
			//echo $sql;
			
		return $db->fetchAll($sql);
		
	}
	public function getAllTranDebtWithRate($search=''){//NOT CLEAR USE WITH OTHER
		$db = $this->getAdapter();
		$from_date =(empty($search['from_date']))? '1': "send_date >= '".$search['from_date']." 00:00:00'";
		$to_date = (empty($search['to_date']))? '1': "send_date <= '".$search['to_date']." 23:59:59'";
		$where = " AND ".$from_date." AND ".$to_date;
		
		$sql = "SELECT
		id,
		(SELECT tel FROM cs_sender AS c WHERE c.sender_id = tr.sender_name LIMIT 1) AS tel,
		(SELECT sender_name FROM cs_sender AS c WHERE c.sender_id = tr.sender_name LIMIT 1) AS sender_name,
		money_tran_id,
		`invoice_no`,
		rate_perday,
		total_money_owe AS amount_owe,
		total_money ,
		send_date,
		amount_type AS money_type
		FROM
		`cs_transactions_owe` AS tr
		WHERE status_loan !=2 AND is_orgdebt=1 ";//used in rpt of debt 
// 		WHERE status_loan !=2 AND is_orgdebt=1 ";//used in rpt of debt
			
		if($search['sender_name']!=-1){
			$where.=" AND sender_name ='".$search['sender_name']."'";
		}
		$order=" ORDER BY sender_name,amount_type,send_date ";
		return $db->fetchAll($sql.$where.$order);
	
	}
	
	public function getAllTranDebt($search=''){//just update from above
		$db = $this->getAdapter();
		$from_date =(empty($search['from_date']))? '1': "send_date >= '".$search['from_date']." 00:00:00'";
		$to_date = (empty($search['to_date']))? '1': "send_date <= '".$search['to_date']." 23:59:59'";
		$where = " AND ".$from_date." AND ".$to_date;
	
		$sql = "SELECT
		id,
		(SELECT tel FROM cs_sender AS c WHERE c.sender_id = tr.sender_name LIMIT 1) AS tel,
		(SELECT sender_name FROM cs_sender AS c WHERE c.sender_id = tr.sender_name LIMIT 1) AS sender_name,
		money_tran_id,
		`invoice_no`,
		rate_perday,
		total_money_owe AS amount_owe,
		total_money ,
		send_date,
		amount_type AS money_type,
		is_orgdebt
		FROM
		`cs_transactions_owe` AS tr
		WHERE 1 ";//used in rpt of debt
		// 		WHERE status_loan !=2 AND is_orgdebt=1 ";//used in rpt of debt
			
		if($search['sender_name']!=-1){
			$where.=" AND sender_name ='".$search['sender_name']."'";
		}
		$order=" ORDER BY sender_name,amount_type,send_date ";
// 		echo $sql.$where.$order;
		return $db->fetchAll($sql.$where.$order);
	
	}
	public function getFundByDebtId($invoice='',$curr_type=1){//get fund by id for debt rpt
		$db = $this->getAdapter();
		$sql =" SELECT * FROM `cs_trans_found` WHERE `invoice_found` = '".$invoice."' AND curency_type=$curr_type limit 1";
		return $db->fetchAll($sql);
	}
	
	
	
	public function getMoneyRemainByName($ower){
		$db=$this->getAdapter();
		$sql = " SELECT	sender_name,SUM(total_money) AS amount_after
		FROM
		`cs_transactions_owe` WHERE sender_name='$ower'
		GROUP BY sender_name ";
		return $db->fetchRow($sql);
	
	
	}
	public function getOrgDebtByFundTran($debt_tran,$curr_type){
		$db=$this->getAdapter();
		
		$s_where = array();                    
		$where = '';
		$debt_tran = explode(',',$debt_tran);
		foreach ($debt_tran as $key => $tran) {
			$s_where[] = "`id` = ".$tran;	
		}
		$where .= implode(' OR ',$s_where);
// 		print_r($where);exit();
		$sql = " SELECT	*
		FROM
		`cs_transactions_owe` WHERE $where  AND amount_type = $curr_type AND is_orgdebt = 1";
		echo $sql;
		return $db->fetchAll($sql);
	
	
	}

	
	
}


