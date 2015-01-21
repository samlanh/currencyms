<?php 
Class tellerandexchange_Form_FrmLoan extends Zend_Dojo_Form {
	protected $tr;
	public function init()
	{
		$this->tr = Application_Form_FrmLanguages::getCurrentlanguage();
	}
	public function FrmAddLoan($data=null){
		
		$_isgroup = new Zend_Dojo_Form_Element_CheckBox('is_group');
		$_isgroup->setAttribs(array(
				'dojoType'=>'dijit.form.CheckBox',
				'class'=>'fullside',
				// 				'onkeyup'=>'Calcuhundred()'
		));
		
		
		$_loan_code = new Zend_Dojo_Form_Element_TextBox('loan_code');
		$_loan_code->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
				'readonly'=>true,
				'style'=>'color:red; font-weight: bold;'
		));
		$db = new Application_Model_DbTable_DbGlobal();
		$loan_number = $db->getLoanNumber();
		$_loan_code->setValue($loan_number);
		
		$_collect_term = new Zend_Dojo_Form_Element_FilteringSelect('collect_termtype');
		$_collect_term->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'onchange'=>'changeGraicePeroid();'
		));
		$term_opt = $db->getVewOptoinTypeByType(1,1,3);
		$_collect_term->setMultiOptions($term_opt);
		
		
		$_client_code = new Zend_Dojo_Form_Element_TextBox('client_code');
		$_client_code->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
		));
		
		
		$_groupid = new Zend_Dojo_Form_Element_FilteringSelect('group_id');
		$_groupid->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
 				'onchange'=>'popupCheckClient();'
				));
		$rows = $db ->getClientByType(1);
		$options=array(''=>"------Select------",-1=>"Add New new group");
		if(!empty($rows))foreach($rows AS $row){
			$options[$row['client_id']]=$row['name_en'].','.$row['province_en_name'].','.$row['district_name'].','.$row['commune_name'].','.$row['village_name'];
		}
		$_groupid->setMultiOptions($options);
		
		$_coid = new Zend_Dojo_Form_Element_FilteringSelect('co_id');
		$rows = $db ->getAllCOName();
		$options=array(''=>"------Select------",-1=>"Add New");
		if(!empty($rows))foreach($rows AS $row) $options[$row['co_id']]=$row['co_khname'];
		$_coid->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
								'class'=>'fullside',
		 						'onchange'=>'popupCheckCO();'
		));
		$_coid->setMultiOptions($options);
		
		$_member = new Zend_Dojo_Form_Element_FilteringSelect('member');
		$_member->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
		));
		$rows = $db->getClientByType();
		$options=array(''=>"------Select------",-1=>"Add New");
		if(!empty($rows))foreach($rows AS $row) $options[$row['client_id']]=$row['name_en'];
		$_member->setMultiOptions($options);
		
		$_currency_type = new Zend_Dojo_Form_Element_FilteringSelect('currency_type');
		$_currency_type->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
		));
		$opt = array(2=>"Dollar",1=>'Khmer',3=>"Bath");
		$_currency_type->setMultiOptions($opt);
		
		$_zone = new Zend_Dojo_Form_Element_FilteringSelect('zone');
		$_zone->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'onchange'=>'popupCheckZone();'
		));
		$rows = $db ->getZoneList();
		
		$options=array(''=>"------Select------",-1=>"Add New");
		if(!empty($rows))foreach($rows AS $row) $options[$row['zone_id']]=$row['zone_name'];
		$_zone->setMultiOptions($options);
		
		$_loan_fee = new Zend_Dojo_Form_Element_NumberTextBox('loan_fee');
		$_loan_fee->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
		));
		$_loan_fee->setValue(0);
		
		$_time_collect = new Zend_Dojo_Form_Element_NumberTextBox('amount_collect');
		$_time_collect->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'onkeyup'=>'getFirstPayment();'
		));
 		$_time_collect->setValue(1);
 		
 		$_time_collect_pri = new Zend_Dojo_Form_Element_NumberTextBox('amount_collect_pricipal');
 		$_time_collect_pri->setAttribs(array(
 				'dojoType'=>'dijit.form.NumberTextBox',
 				'class'=>'fullside',
 				'readonly'=>true,
 				'required'=>true
 		));
 		$_time_collect_pri->setValue(2);
		
		$_amount = new Zend_Dojo_Form_Element_NumberTextBox('total_amount');
		$_amount->setAttribs(array(
						'dojoType'=>'dijit.form.NumberTextBox',
						'class'=>'fullside',
						'required' =>'true'
		));
		
		$_level = new Zend_Dojo_Form_Element_NumberTextBox('level');
		$_level->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required' =>'true'
		));
		$_level->setValue(1);
		
// 		$_rate = new Zend_Dojo_Form_Element_NumberTextBox('interest_rate');
// 		$_rate->setAttribs(array(
// 				'data-dojo-Type'=>'dijit.form.NumberTextBox',
// 				'data-dojo-props'=>"regExp:'[0-9]{1,2}',
// 				'required':true,
// 				'name':'batch',
// 				'value':2.5,
// 				'class':'fullside',
// 				'invalidMessage':'អាចបញ្ជូលពី 1 ដល់ 99'"));

		$_rate =  new Zend_Dojo_Form_Element_ValidationTextBox("interest_rate");
		$_rate->setAttribs(array(
				'data-dojo-Type'=>'dijit.form.ValidationTextBox',
				'data-dojo-props'=>"
				'required':true,
				'name':'interest_rate',
				'value':2.5,
				'class':'fullside',
				'invalidMessage':'អាចបញ្ជូលពី 1 ដល់  100'"));
		
		

		
// 		$value_interest = 2.5;
// 		$_rate->setValue($value_interest);
		
		$_period = new Zend_Dojo_Form_Element_NumberTextBox('period');
		$_period->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required' =>'true',
				'onkeyup'=>'calCulatePeriod();'
		));
		$_period->setValue(12);
		
		$_releasedate = new Zend_Dojo_Form_Element_DateTextBox('release_date');
		$_releasedate->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox',
				'class'=>'fullside',
				'required' =>'true',
				'onchange'=>'checkReleaseDate();'
		));
		$s_date = date('Y-m-d');
		$_releasedate->setValue($s_date);
		
		$_first_payment = new Zend_Dojo_Form_Element_DateTextBox('first_payment');
		$_first_payment->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox',
				'class'=>'fullside',
				'required' =>'true',
				//'onchange'=>'calCulateFirstPayment();'
				
		));
		//$_first_payment->setValue('2005-12-30');
		
		$_dateline = new Zend_Dojo_Form_Element_DateTextBox('date_line');
		$_dateline->setAttribs(array(
				'dojoType'=>'dijit.form.DateTextBox',
				'class'=>'fullside',
				'required' =>'true',
				'readonly'=>true,
		));
		
		
		$_graice_pariod = new Zend_Dojo_Form_Element_TextBox('graice_pariod');
		$_graice_pariod->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
				'required' =>'true'
		));
		$_graice_pariod->setValue(0);
	
		$_payterm = new Zend_Dojo_Form_Element_FilteringSelect('payment_term');
		$_payterm->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required' =>'true'
		));
		$options= array(1=>"Day",2=>"Week",3=>"Month");
		$_payterm->setMultiOptions($options);
		
		$_pay_every = new Zend_Dojo_Form_Element_FilteringSelect('pay_every');
		$_pay_every->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required' =>'true',
				'onchange'=>'changeCollectType();'
		));
		$options= array(1=>"Day",2=>"Week",3=>"Month");
		$_pay_every->setMultiOptions($options);
		$_pay_every->setValue(3);
		
		$_every_payamount = new Zend_Dojo_Form_Element_FilteringSelect('every_payamount');
		$_every_payamount->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required' =>'true'
		));
		$options= array(2=>"After",1=>"Before",3=>"Normal");
		$_every_payamount->setMultiOptions($options);
		
		$_time= new Zend_Dojo_Form_Element_TextBox('time');
		$_time->setAttribs(array(
				'dojoType'=>'dijit.form.TextBox',
				'class'=>'fullside',
		));
		$set_time='10:00-11:00 AM';
		$_time->setValue($set_time);
		
		$_paybefore = new Zend_Dojo_Form_Element_NumberTextBox('pay_before');
		$_paybefore->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required' =>'true'
		));
		$_paybefore->setValue(0);
		
		$_pay_late = new Zend_Dojo_Form_Element_NumberTextBox('pay_late');
		$_pay_late->setAttribs(array(
				'dojoType'=>'dijit.form.NumberTextBox',
				'class'=>'fullside',
				'required' =>'true'
		));
		$_pay_late->setValue(0);
		
		$_branch_id = new Zend_Dojo_Form_Element_FilteringSelect('branch_id');
		$_branch_id->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required' =>'true'
		));
		
		$rows = $db->getAllBranchName();
		$options='';
			if(!empty($rows))foreach($rows AS $row){
				$options[$row['br_id']]=$row['branch_namekh'];
			}
		$_branch_id->setMultiOptions($options);
		
		$_repayment_method = new Zend_Dojo_Form_Element_FilteringSelect('repayment_method');
		$_repayment_method->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required' =>'true',
				'onchange'=>'chechPaymentMethod()'
		));
		//$options= array(1=>"Decline",2=>"Baloon",3=>"Fixed Rate",4=>"Fixed Payment",5=>"Semi Baloon");
		
// 		$options= array(
// 				1=>"Decline",
// 				2=>"Baloon",
// 				3=>"Fixed Rate",
// 				4=>"Fixed Pyment(Full Last Period)",
// 				5=>"Semi Baloon",
// 				6=>"Fixed Payment (Fixed Rate)");
		$options = $db->getAllPaymentMethod(null,1);
		$_repayment_method->setMultiOptions($options);
		
		$_holiday = new Zend_Dojo_Form_Element_FilteringSelect('holiday');
		$_holiday->setAttribs(array(
				'dojoType'=>'dijit.form.FilteringSelect',
				'class'=>'fullside',
				'required' =>'true'
		));
		$options= array(1=>"Befor",2=>"After",3=>"Cancel");
		$_holiday->setMultiOptions($options);
		
		if($data!=null){
			print_r($data);
			$_branch_id->setValue($data['member_id']);
			$_level->setValue($data['level']);
			$_loan_fee->setValue($data['admin_fee']);
			$_member->setValue($data['client_id']);
			$_coid->setValue($data['co_id']);
			$_zone->setValue($data['zone_id']);
			
			$_releasedate->setValue($data['date_release']);
			$_period->setValue($data['zone_id']);
			$_first_payment->setValue($data['zone_id']);
			$_time->setValue($data['time_collect']);
			$_every_payamount->setValue($data['pay_term']);
			$_amount->setValue($data['total_capital']);
			
			$_currency_type->setValue($data['payment_method']);
			$_rate->setValue($data['zone_id']);
			
			$_repayment_method->setValue($data['payment_method']);
			$_graice_pariod->setValue($data['graice_pariod']);
			$_time_collect_pri->setValue($data['amount_collect_pricipal']);
			
		}
		$this->addElements(array($_isgroup,$_groupid,$_client_code,$_time_collect,$_loan_fee,$_level,$_paybefore,$_pay_late,$_branch_id,$_member,$_coid,$_currency_type,$_zone,$_amount,$_rate,$_releasedate
				,$_payterm,$_every_payamount,$_time,$_time_collect_pri,$_holiday,$_graice_pariod,$_period,
				$_first_payment,$_repayment_method,$_pay_every,$_loan_code,$_collect_term,$_dateline));
		return $this;
		
	}	
}