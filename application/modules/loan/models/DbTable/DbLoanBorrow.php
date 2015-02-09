<?php

class Loan_Model_DbTable_DbLoanBorrow extends Zend_Db_Table_Abstract
{
	protected $_name = 'cms_loan';
	function addLoan($data){
		$arr = array(
				'client_id'=>$data['borrower'],
				'date'=>$data['date_borrow'],
				'loan_number'=>$data['borrow_number'],
				'date_release'=>$data['date_out'],
				'date_line'=>$data['date_end'],
				'term'=>$data['long_time'],
				'amount_borrow'=>$data['long_borrow'],
				'currency_type'=>$data['salary_type'],
				'amount_loan'=>$data['rate'],
				'note'=>$data['note'],
				'interest'=>$data['amount'],
				'status'=>$data['status']
				
		);
		print_r($arr); exit();
		$this->insert($arr);
      	 
    }
    function updateloan($data){
    	$arr = array(
    			'client_id'=>$data['borrower'],
    			'date'=>$data['date_borrow'],
    			'loan_number'=>$data['borrow_number'],
    			'date_release'=>$data['date_out'],
    			'date_line'=>$data['date_end'],
    			'term'=>$data['long_time'],
    			'amount_borrow'=>$data['long_borrow'],
    			'currency_type'=>$data['salary_type'],
    			'amount_loan'=>$data['rate'],
    			'note'=>$data['note'],
    			'interest'=>$data['amount'],
    			'status'=>$data['status']	
    	);
    	$where=" id = ".$data['id'];
    	$this->update($arr, $where);
    }
   function geteloanbyid($id){
			$db = $this->getAdapter();
			$sql=" SELECT id,client_id,date,loan_number,date_release,date_line,
			term,amount_borrow,currency_type,interest,amount_loan,note,status FROM $this->_name where id=$id ";
			return $db->fetchRow($sql);
	}
	function geteAllloan($id){
		$db = $this->getAdapter();
		$sql=" SELECT id,client_id,date,loan_number,date_release,date_line,
		term,amount_borrow,currency_type,interest,amount_loan,note,status FROM $this->_name  ";
		return $db->fetchAll($sql);
	}
}



