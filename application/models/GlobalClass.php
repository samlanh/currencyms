<?php

class Application_Model_GlobalClass  extends Zend_Db_Table_Abstract
{
		
	/**
	 * create option for setMultiOption in select box
	 * @param string $value
	 * @param string $label
	 * @param string $sql
	 * @return array('id'=>'label')
	 */
	public function getOption($value,$label,$sql)
	{
		$db=new Application_Model_DbTable_DbGlobal();
		$rs=$db->getGlobalDb($sql);
		$options = array();
		if($rs){
			foreach($rs as $read)
				$options[$read[$value]]=$read[$label];
		}
		return $options;
	}
	public function getImgActive($rows,$base_url, $case='',$month=null,$display=null){
		if($rows){
			$imgnone='<img src="'.$base_url.'/images/icon/cross.png"/>';
			$imgtick='<img src="'.$base_url.'/images/icon/apply2.png"/>';
	
			foreach ($rows as $i =>$row){
				if($month!=null){
					$dg = new Application_Model_DbTable_DbGlobal();
					$rows[$i]['fordate']  = $dg->getAllMonths($row['fordate']);
				}
				if($display!=null){
					$rows[$i]['displayby']= ($row['displayby']==1)?'Khmer':'English';
				}
				if($row['status'] == 1){
					$rows[$i]['status']= $imgtick;
				}
				else{
					$rows[$i]['status'] = $imgnone;
				}
					
			}
		}
		return $rows;
	}
	
	/**
	 * replace value of statu by image
	 * @param array $rows
	 * @param string $base_url
	 * @param bool  $case 
	 * @return array
	 * @uses must have status field in $rows
	 */
	public function getImgStatus($rows,$base_url, $case=''){
		if($rows){			
			$imgnone='<img src="'.$base_url.'/images/icon/none.png"/>';
			$imgtick='<img src="'.$base_url.'/images/icon/tick.png"/>';
			if($case !== ''){
				$imgnone='<img src="'.$base_url.'/images/icon/close.png"/>';
				$imgtick='<img src="'.$base_url.'/images/icon/open.png"/>';
			}
			 
			foreach ($rows as $i =>$row){
				if($row['status'] == 1){
					$rows[$i]['status'] = $imgtick;
				}
				else{
					$rows[$i]['status'] = $imgnone;
				}
			}
			 
		}		
		return $rows;
	}
	
	/**
	 * Generate UUID for use in invoce no
	 * @return string
	 */
	public static function getInvoiceWithdraw($type=null){
		$sub=substr(uniqid(rand(10,1000),false),rand(0,10),6);
		$date= new Zend_Date();
		if($type==1){
			$head="DP-";//deposite
		}else if($type==2){
			$head="DL-";//DELAY
		}elseif($type==3){
			$head="TR-";//TRANSFER
		}elseif($type==4){
			$head="RF-";//REFUND
		}elseif($type==5){
			$head="LN-";//loan
		}elseif($type==6){
			$head="PO-";//PAYOUT
		}
		else{
			$head="WD-";//withdraw
		}
		return strtoupper($head.$sub);
	}
	public static function getInvoiceNo(){	
		return strtoupper(uniqid());
	}
	public static function getInvoiceOwe(){
		$sub=substr(uniqid(rand(10,1000),false),rand(0,10),5);
		$date= new Zend_Date();
		$head="W".$date->get('YY-MM-d');
		return $head.$sub;
	}	
	
   public function getImgMemberStatus($rows,$base_url, $case=''){
		if($rows){			
			$imgpre='<img src="'.$base_url.'/images/icon/Pre-member.png"/>';
			$imgcertified='<img src="'.$base_url.'/images/icon/Certified-Memeber.png"/>';
			$imgterminate='<img src="'.$base_url.'/images/icon/Terminate-Member.png"/>';
			if($case !== ''){
				$imgpre='<img src="'.$base_url.'/images/icon/Pre-member.png"/>';
				$imgcertified='<img src="'.$base_url.'/images/icon/Certified-Memeber.png"/>';
				$imgterminate='<img src="'.$base_url.'/images/icon/Terminate-Member.png"/>';
			}
			 
			foreach ($rows as $i =>$row){
				if($row['status'] == 1){
					$rows[$i]['status'] = $imgcertified;
				}
			   elseif($row['status'] == 2){
					$rows[$i]['status'] = $imgpre;
				}
				else{
					$rows[$i]['status'] = $imgterminate;
				}
			}
			 
		}		
		return $rows;
	}
	
   public function getImgAttachStatus($rows,$base_url, $case=''){
		if($rows){			
			$imgattach='<img src="'.$base_url.'/images/icon/attachment.png"/>';
			$imgnone='<img src="'.$base_url.'/images/icon/no-attachment.png"/>';
			if($case !== ''){
				$imgattach='<img src="'.$base_url.'/images/icon/attachment.png"/>';
				$imgnone='<img src="'.$base_url.'/images/icon/no-attachment.png"/>';
			}
			 
			foreach ($rows as $i =>$row){
				if(is_dir('docs/case_note_id_'.$row['note_id'])){
					$rows[$i]['note_id'] = $imgattach;
				}
				else{
					$rows[$i]['note_id'] = $imgnone;
				}
			}
			 
		}		
		return $rows;
	}
	/**
	 * add element "delete" to $rows
	 * @param array $rows
	 * @param string $url_delete
	 * @param string $base_url
	 * @return array $rows
	 */
	public static function getImgDelete($rows,$url_delete,$base_url){
		foreach($rows as $key=>$row){
			$url = $url_delete.$row["id"];
			$row['delete'] = '<a href="'.$url.'"><img src="'.BASE_URL.'/images/icon/cross.png"/></a>';
			$rows[$key] = $row;
		}
		return $rows;
	}
	
	
	/**
	 * add datepicker to text box of date fields
	 * @param array $date_fields
	 */
	public static function addDateField($date_fields)
	{
		$template='$("#template").datepicker({"changeYear":"true","changeMonth":"true","yearRange":"-40:+100","dateFormat":"dd-mm-yy"});';
		$script='<script language="javascript"> $(document).ready(function() {  #template#		});</script>';
		$value='';
		if(is_array($date_fields)){
			foreach($date_fields as $read){
				$value.=str_replace('#template', '#'.$read, $template);
			}
		}
		else{
			$value=str_replace('#template', '#'.$date_fields, $template);
		}
		echo str_replace('#template#', $value, $script);
	}
	
	/**
	 * add dateatimepicker to text box of date fields
	 * @param array $date_fields
	 */
	public static function addDateTimeField($date_fields)
	{
		$template='$("#template").datetimepicker({dateFormat: "yy-mm-dd"} );';
		$script='<script language="javascript"> $(document).ready(function() {  #template#		});</script>';
		$value='';
		if(is_array($date_fields)){
			foreach($date_fields as $read){
				$value.=str_replace('#template', '#'.$read, $template);
			}
		}
		else{
			$value=str_replace('#template', '#'.$date_fields, $template);
		}
		echo str_replace('#template#', $value, $script);
	}

	/**
	 * Get Day name With multiple Languages
	 * @param string $key
	 * @var $key ('mo', 'tu', 'we', 'th', 'fr', 'sa', 'su')
	 */
	public function getDayName($key = ''){
		$tr = Application_Form_FrmLanguages::getCurrentlanguage();
		$day_name = array(
							'su' => $tr->translate('SU'),
							'mo' => $tr->translate('MO'),
							'tu' => $tr->translate('TU'),
							'we' => $tr->translate('WE'),
							'th' => $tr->translate('TH'),
							'fr' => $tr->translate('FR'),
							'sa' => $tr->translate('SA')							
						 );
		if(empty($key)){
			return $day_name;
		}
		return  $day_name[$key];
	}
	
	/**
	 * Get all Hour per day
	 * @param int $key
	 * @return multitype:string |Ambigous <string>
	 * @var $key = [0-23]
	 */
	public function getHours($key = ''){
		$tr = Application_Form_FrmLanguages::getCurrentlanguage();
		$am = $tr->translate('AM');
		$pm = $tr->translate('PM');
		$hours = array(
				'12:00 '. $pm,
				'01:00 '. $am,
				'02:00 '. $am,
				'03:00 '. $am,
				'04:00 '. $am,
				'05:00 '. $am,
				'06:00 '. $am,
				'07:00 '. $am,
				'08:00 '. $am,
				'09:00 '. $am,
				'10:00 '. $am,
				'11:00 '. $am,
				'12:00 '. $am,
				'01:00 '. $pm,
				'02:00 '. $pm,
				'03:00 '. $pm,
				'04:00 '. $pm,
				'05:00 '. $pm,
				'06:00 '. $pm,
				'07:00 '. $pm,
				'08:00 '. $pm,
				'09:00 '. $pm,
				'10:00 '. $pm,
				'11:00 '. $pm				
				); 
		if(empty($key)){
			return $hours;
		}
		return  $hours[$key];
	}
	
	/**
	 * Generate Age for child
	 */
	public function getAges(){
		$age = array();
		$age[0] = "< 1";
		for($i=1; $i <= 30; $i++){			
			$age[$i] = $i;
		}
		return $age;
	}
	
	/**
	 * Geat Static Value
	 * @param unknown_type $type
	 * @param unknown_type $key
	 * @uses $type = 0 ["No", "Yes"]; 1["Close", "Open"]; 2["Male", "Female"] 
	 */
	public function getStaticValue($type, $key=''){
		$tr = Application_Form_FrmLanguages::getCurrentlanguage();
		$vals = array();
		if($type == 0){
			$vals[0] = $tr->translate("_NO");
			$vals[1] = $tr->translate("_YES");
		}
		elseif($type == 1){
			$vals[0] = $tr->translate("CLOSE");
			$vals[1] = $tr->translate("OPEN");
		}
		elseif($type == 2){
			$vals[0] = $tr->translate("MALE");
			$vals[1] = $tr->translate("FEMALE");
		}elseif($type == 3){
			$vals["New"] = $tr->translate("NEW");
			//$vals["Refresh"] = $tr->translate("REFRESH");
		}elseif($type == 4){
			$vals["Male"] = $tr->translate("MALE");
			$vals["Female"] = $tr->translate("FEMALE");
		}
		elseif($type == 5){
			// For case hotline
			$vals[1] = $tr->translate("TARGET");
			$vals[0] = $tr->translate("NON-TARGET");
		}
		elseif($type == 6){
			// For Close case hotline			
			$vals[1] = $tr->translate("_NO");
			$vals[0] = $tr->translate("_YES");
		}
		
		if($key === ''){
			return $vals;
		}
		
		return $vals[$key];
	}
	
	/**
	 * get common options in the system
	 * @param int $type
	 * @return Ambigous <multitype:, array('id'=>'label'), multitype:unknown >
	 */
	public function getCommonOptions($type){
		$auth = new Zend_Session_Namespace('auth');
		$vals = array();
		if($type == 0){//zone_id
			$vals = $this->getOption('id', 'zone_name_en', 'SELECT id, zone_name_en FROM fi_cs_zone WHERE cso_id = '. $auth->cso_id);
		}
		return $vals;
	}

	public function getSelectBoxOptions($options){
		$sl_opt = "";
		foreach($options as $key=>$opt){
			$sl_opt .= "<option value='".$key."'>".$opt."</option>";
		}
		return $sl_opt;
	}	
	
	/**
	 * get phone number in format
	 * @param string $str
	 * @return string
	 */
	public static function getPhoneNumber($str)
	{
		$str = str_replace(" ", "", $str);
		$firt = substr($str, 0,3);
		$second = substr($str, 3, strlen($str)-3);
		$phone = $firt." ".$second;
		return $phone;
	}
	
	/**
	 * Generate Options for select option in html code
	 * @author Sovann
	 * @param string $sql
	 * @param string $display
	 * @param string $value
	 * @return string
	 */
	public function getOptonsHtml($sql, $display, $value){
		$db = $this->getAdapter();		
		$option = '<option value="">--- Select ---</option>';
		foreach($db->fetchAll($sql) as $r){
			
			$option .= '<option value="'.$r[$value].'">'.htmlspecialchars($r[$display], ENT_QUOTES).'</option>';
		}
		return $option;
	}
	//bunrath 24/10/2012
	public function getOptionStatic(){
		$tr = Application_Form_FrmLanguages::getCurrentlanguage();
		$option = '<option value="">'.$tr->translate('SELECT_OPTION').'</option>';
		$option .= '<option value="0">'.$tr->translate('DISABLE').'</option>';
		$option .= '<option value="1">'.$tr->translate('CAN_VIEW').'</option>';
		$option .= '<option value="2">'.$tr->translate('CAN_EDIT').'</option>';
		return $option;
	}
	
	//Sovann add 03 Jan 2013
	public function getChildAgeOption(){		 
		$session_language=new Zend_Session_Namespace('language');
		$lang = $session_language->language;
		$tr = Application_Form_FrmLanguages::getCurrentlanguage();
	
		$db = $this->getAdapter();
		$sql = "SELECT id, age_en AS age FROM `fi_cs_child_age` WHERE STATUS = 1";
		if($lang == "KM"){
			$sql = "SELECT id, age_kh AS age FROM `fi_cs_child_age` WHERE STATUS = 1";
		}
		$option = '<option value="">'. $tr->translate('PLS-SELECT') .'</option>';
		foreach($db->fetchAll($sql) as $value){
			$option .= '<option value="'.$value['id'].'">'.htmlspecialchars($value['age'], ENT_QUOTES).'</option>';
		}
		return $option;
	}
	
	//Sophen add 30 July 2012
    public function getCaseTypeOption(){
    	$auth = new Zend_Session_Namespace('auth');
    	
    	$session_language=new Zend_Session_Namespace('language');
    	$lang = $session_language->language;
    	$tr = Application_Form_FrmLanguages::getCurrentlanguage();
    	 
		$db = $this->getAdapter();
		$sql = "SELECT id, type_en AS type FROM `fi_cs_type_case` WHERE STATUS = 1 AND cso_id=". $auth->cso_id;
		if($lang == "KM"){
			$sql = "SELECT id, type_kh AS type FROM `fi_cs_type_case` WHERE STATUS = 1 AND cso_id=". $auth->cso_id;
		}
		$option = '<option value="">'. $tr->translate('PLS-SELECT') .'</option>';
		foreach($db->fetchAll($sql) as $value){
		    $option .= '<option value="'.$value['id'].'">'.htmlspecialchars($value['type'], ENT_QUOTES).'</option>';
		}
		return $option;
	}
	
	public function getAssRequestedOption(){
		$db = $this->getAdapter();
		
		$session_language=new Zend_Session_Namespace('language');
		$lang = $session_language->language;
		$tr = Application_Form_FrmLanguages::getCurrentlanguage();
		
		$auth = new Zend_Session_Namespace('auth');
		$sql = "SELECT id, `requested_en` AS req FROM `fi_cs_ass_requested` WHERE STATUS = 1 AND cso_id=". $auth->cso_id;
		
		if($lang == "KM"){
			$sql = "SELECT id,`requested_kh` AS req FROM `fi_cs_ass_requested` WHERE STATUS = 1 AND cso_id=". $auth->cso_id;
		}
		
		$option = '<option value="">'. $tr->translate('PLS-SELECT') .'</option>';
		foreach($db->fetchAll($sql) as $value){
		    $option .= '<option value="'.$value['id'].'">'.htmlspecialchars($value['req'], ENT_QUOTES).'</option>';
		}
		return $option;
	}
	
	public function getAssProvidedOption(){
		$db = $this->getAdapter();
		
		$session_language=new Zend_Session_Namespace('language');
		$lang = $session_language->language;
		$tr = Application_Form_FrmLanguages::getCurrentlanguage();
		
		$auth = new Zend_Session_Namespace('auth');
		$sql = "SELECT id, `provided_en` AS pro FROM `fi_cs_ass_provided` WHERE STATUS = 1 AND cso_id=". $auth->cso_id;

		if($lang == "KM"){
			$sql = "SELECT id, `provided_kh` AS pro FROM `fi_cs_ass_provided` WHERE STATUS = 1 AND cso_id=". $auth->cso_id;
		}
		
		$option = '<option value="">'. $tr->translate('PLS-SELECT') .'</option>';
		foreach($db->fetchAll($sql) as $value){
		    $option .= '<option value="'.$value['id'].'">'.htmlspecialchars($value['pro'], ENT_QUOTES).'</option>';
		}
		return $option;
	}
	
	public function getReferralTypeOption(){
		$db = $this->getAdapter();
		
		$session_language=new Zend_Session_Namespace('language');
		$lang = $session_language->language;
		$tr = Application_Form_FrmLanguages::getCurrentlanguage();
		
		$auth = new Zend_Session_Namespace('auth');
		$sql = "SELECT id, `referal_en` AS ref FROM `fi_cs_referal` WHERE STATUS = 1 AND cso_id=". $auth->cso_id;
		
		if($lang == "KM"){
			$sql = "SELECT id, `referal_kh` AS ref FROM `fi_cs_referal` WHERE STATUS = 1 AND cso_id=". $auth->cso_id;
		}
		
		$option = '<option value="">'. $tr->translate('PLS-SELECT') .'</option>';
		foreach($db->fetchAll($sql) as $value){
		    $option .= '<option value="'.$value['id'].'">'.htmlspecialchars($value['ref'], ENT_QUOTES).'</option>';
		}
		return $option;
	}
	
	public function getSubjectOption(){
		$db = $this->getAdapter();
		$auth = new Zend_Session_Namespace('auth');
		$sql = "SELECT id, `subject_en` FROM `fi_cs_subject` WHERE STATUS = 1 AND cso_id=". $auth->cso_id;
		$option = '<option value="">--- Select ---</option>';
		foreach($db->fetchAll($sql) as $value){
		    $option .= '<option value="'.$value['id'].'">'.htmlspecialchars($value['subject_en'], ENT_QUOTES).'</option>';
		}
		return $option;
	}
	public function getTrainingTypeOption(){
	//Select Public for report
		$myopt = '<option value="">---Select----</option>';
		$myopt .= '<option value="Train">Train</option>';
		$myopt .= '<option value="Refresh">Refresh</option>';
    	return $myopt;
    	
	} 
	
		public function getYesNoOption(){
		//Select Public for report
			$myopt = '<option value="">---Select----</option>';
			$myopt .= '<option value="Yes">Yes</option>';
			$myopt .= '<option value="No">No</option>';
	    	return $myopt;
	    	
		} 
	
	
		public function getMaterialOption(){
		$db = $this->getAdapter();
		$auth = new Zend_Session_Namespace('auth');
		$sql = "SELECT id, `name_en` FROM `fi_cs_items` where cso_id=". $auth->cso_id . " AND status=1";
		$option = '<option value="">--- Select ---</option>';
		foreach($db->fetchAll($sql) as $value){
		    $option .= '<option value="'.$value['id'].'">'.htmlspecialchars($value['name_en'], ENT_QUOTES).'</option>';
		}
		return $option;
	   }
	//End sophen add
	
	
}

