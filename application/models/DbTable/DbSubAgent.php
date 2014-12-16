<?php

class Application_Model_DbTable_DbSubAgent extends Zend_Db_Table_Abstract
{

    protected $_name = 'cs_sub_agents';
    
	private function _buildQuery($search = ''){
		$sql = "SELECT sa.`id`,  sa.`name`, sa.`tel`, sa.`khan`, sa.`sangkat`, sa.`block`, p.`name` AS proname,a.`name` AS agent_name
				FROM `cs_sub_agents` as sa
				     INNER JOIN `cs_provinces` AS p ON (sa.`province` = p.`id`)
				     INNER JOIN `cs_agents` AS a ON (sa.`agent_id` = a.`id`)
				WHERE 1 ";
		
		$orderby = " ORDER BY sa.`id`";
		
		if(empty($search)){
			return $sql.$orderby;
		}
		
		$where ='';
		
		if ($search['active'] >= 0){
			$where = ' AND sa.`active` = '.$search['active'];			
		}
		
		
		if (!empty($search['txtsearch'])){
			$fields = array('sa.name', 'sa.tel', 'sa.fax', 'sa.hp', 'sa.code');	
			$s_where = array();	
	        foreach($fields as $field)
	    	{
	    		$s_where[] = $field." LIKE '%{$search['txtsearch']}%'";
	    	}	    	
	        $where .= ' AND ('.implode(' OR ',$s_where).')';
		}
		
		/*if ($search['province'] > 0){
			$where .= ' AND sa.`province` = '. $search['province'];
		}*/
		
		if ($search['agent'] > 0){
			$where .= ' AND a.`id` = '. $search['agent'];
		}
				
		return $sql.$where.$orderby;
	}
	
	function getSubAgentList($start, $limit){
		$db = $this->getAdapter();
		$sql = $this->_buildQuery()." LIMIT ".$start.", ".$limit;
		if ($limit == 'All') {
			$sql = $this->_buildQuery();
		}	
		//print ($sql); exit();
		return $db->fetchAll($sql);
	}
	
	function getSubAgentListBy($search, $start, $limit){        
		$db = $this->getAdapter();		
		$sql = $this->_buildQuery($search)." LIMIT ".$start.", ".$limit;
		if ($limit == 'All') {
			$sql = $this->_buildQuery($search);
		}		
		return $db->fetchAll($sql);
	}
	
	function getSubAgentListTotal($search=''){        
		$db = $this->getAdapter();
		$sql = $this->_buildQuery();
		if(!empty($search)){
			$sql = $this->_buildQuery($search);
		}
		$_result = $db->fetchAll($sql); 
		return count($_result);
	}
    
	function getSubAgentEditedById($id){
		$db = $this->getAdapter();
		$sql = "SELECT 	sa.`id`,  
						sa.`name`, 
						sa.`tel`,
						sa.`code`, 
						sa.`fax`, 
						sa.`hp`, 
						sa.`block`,
						sa.`house_no`,
						sa.`group_no`,
						sa.`street_no`, 
						sa.`khan`, 
						sa.`sangkat`,
						sa.`province`,
						sa.`active`,
						sa.`agent_id`
						
				FROM `cs_sub_agents` as sa
				     
				WHERE sa.`id` = ".$id;	
		//print ($sql); exit();	
		return $db->fetchRow($sql);
	}
	
	function getSubAgentListSelect(){
		$db = $this->getAdapter();
		$sql = "SELECT id, name, province, agent_id
				FROM `cs_sub_agents`
				WHERE active = 1";		
		return $db->fetchAll($sql);
	}
	
	function getSubAgentListSelectTrns(){
		$db = $this->getAdapter();
		$sql = "SELECT sa.id, sa.name, p.name AS province, sa.agent_id, sa.`house_no`, sa.`street_no`, sa.`block`, sa.`tel` 
				FROM `cs_sub_agents` AS sa
					 INNER JOIN `cs_provinces` AS p ON (sa.province = p.id)
				WHERE active = 1";		
		return $db->fetchAll($sql);
	}
	
	function insertSubAgent($data){    	

    	$_sub_agent_data=array(
    					'name'=>$data['sub_agent_name'],
						'code'=>$data['code'],
						'tel'=>$data['tel'],
						'fax'=>$data['fax'],
						'hp'=>$data['hp'],
						'block'=>$data['block'],
						'house_no'=>$data['house_no'],
						'group_no'=>$data['group_no'],
						'street_no'=>$data['street_no'],
						'sangkat'=>$data['sangkat'],
						'khan'=>$data['khan'],						
						'province'=>$data['province'],
    					'agent_id'=>$data['agent_id'],						
						'active'=> 1			
    	           );    

			return $this->insert($_sub_agent_data);		
	}
	
	function updateSubAgent($data){    	
    	$_sub_agent_data=array(
    					'name'=>$data['sub_agent_name'],
						'code'=>$data['code'],
						'tel'=>$data['tel'],
						'fax'=>$data['fax'],
						'hp'=>$data['hp'],
						'block'=>$data['block'],
						'house_no'=>$data['house_no'],
						'group_no'=>$data['group_no'],
						'street_no'=>$data['street_no'],
						'sangkat'=>$data['sangkat'],
						'khan'=>$data['khan'],						
						'province'=>$data['province'],
    					'agent_id'=>$data['agent_id'],						
						'active'=> 1			
    	           );    
    	           
			$where=$this->getAdapter()->quoteInto('id=?', $data['id']);
			
			return $this->update( $_sub_agent_data, $where);		
	}


}

