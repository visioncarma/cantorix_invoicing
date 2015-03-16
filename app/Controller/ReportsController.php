<?php
App::uses('AppController', 'Controller');
Class ReportsController extends AppController {
	 
	
	/**
 * Components
 *
 * @var array
 */
   
	public $components = array('Paginator','Email', 'RequestHandler', 'Session');
	var $helpers = array('Xls');
	private $permission = NULL;
	
	public function beforeFilter() { 
	
	   parent::beforeFilter();    
	   $this->layout 		=  "sbs_layout";
       $this->permission 	=  $this->Session->read('Auth.AllPermissions.Invoices');
       $this->subscriber 	=  $this->Session->read('Auth.User.SbsSubscriber.id');
       
       $reportsActive = 'active';
       $this->set(compact('reportsActive')); 
    }
	
	public function index() {
		$this->layout = 'sbs_layout';
		$this->redirect(array('action'=>'customerBalance'));
	}
	
	/* Customer Balance Report section START */
	
	public function customerBalance ($export = null, $orgName = null, $filterAction = null, $min = null, $max = null, $toDate = null,  $defaultSortBy = null, $sortBy = null) {
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Customer Balance Report';
		$this->set(compact('menuActive','permission'));
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		
		
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('AcrInvoicePaymentDetail');
		$this->loadModel('AcrClientCreditnote');
		$this->loadModel('AcrClient');	
		$this->loadModel('SbsSubscriber');
		$this->loadModel('SbsSubscriberOrganizationDetail');		
			
		
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$date_format    = $settings['SbsSubscriberSetting']['date_format'];			
		$subscriberCurrency 	= $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode = $subscriberCurrency['CpnCurrency']['code'];				
		$sbsOrgId			    = $this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($this->subscriber);
		$sbsOrgNameArr 			= $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($sbsOrgId);
		$sbsOrgName 			= $sbsOrgNameArr['SbsSubscriberOrganizationDetail']['organization_name'];
		
		$condition_array = null; $customer_array = null;  $final_array = null; $final_array = array(); $final = array();	
		
		if ($export == 'ex_excel' || $export == 'ex_pdf' || $export == 'null') {
			
			
				if($orgName == 'null')
				{
					$orgName = null;
				}
				if($filterAction == 'null')
				{
					$filterAction = null;
				}
				if($min == 'null')
				{
					$min = null;
				}
				if($max == 'null')
				{
					$max = null;
				}
				if($toDate == 'null')
				{
					$toDate = null;
				}			
			
			    $this->request->data['CustomerBalance']['orgName'] 		= trim($orgName);			
			
				$this->request->data['CustomerBalance']['filterAction'] = trim($filterAction);			
			
				$this->request->data['CustomerBalance']['min'] 			= trim($min);			
			
				$this->request->data['CustomerBalance']['max'] 			= trim($max);			
			
				$this->request->data['CustomerBalance']['toDate'] 		= trim($toDate);		
			
		}
		
		if($this->data['CustomerBalance'] || ($export == 'ex_excel' || $export == 'ex_pdf')){
			
			if(!empty($this->request->data['CustomerBalance']['orgName'])) 				
			 $orgName     = trim($this->request->data['CustomerBalance']['orgName']);
			
			if(!empty($this->request->data['CustomerBalance']['filterAction'])) 				
			 	$fa     = trim($this->request->data['CustomerBalance']['filterAction']);
			if(isset($this->request->data['CustomerBalance']['min'])) {
				$mi     = trim($this->request->data['CustomerBalance']['min']);
				if($mi == '0') {$min = 0; $filterAction   = $fa;	}
			}
			if(isset($this->request->data['CustomerBalance']['max'])){
				$ma     = trim($this->request->data['CustomerBalance']['max']);
				if($ma == '0') {$max = 0; $filterAction   = $fa;	}
			} 				
						
			if($fa && (!empty($mi) || !empty($ma))) {
										
				if((is_numeric($mi) && is_numeric($ma)) && ($mi <= $ma) ){	
					$filterAction   = $fa;								
					$min  			= $mi;					
					$max  			= $ma;	
				} elseif (is_numeric($mi) && !$ma) {
					$filterAction   = $fa;								
					$min  			= $mi;
				} elseif (is_numeric($ma) && !$mi) {
					$filterAction   = $fa;								
					$max  			= $ma;
				} else {
					$this->Session->setFlash('<div class="alert alert-danger"> Please Enter Correct Min Max Value.</div>');
				}								
			}
			
			if($min > 0 && (!is_null($max) && $max == 0)) {
				
				$filterAction = null; 
				$this->Session->setFlash('<div class="alert alert-danger"> Please Enter Correct Min Max Value.</div>');
			} 			
			
			if(!empty($this->request->data['CustomerBalance']['toDate']))
			 $toDate       = trim($this->request->data['CustomerBalance']['toDate']);
			if($toDate)   $toDate	  = date('Y-m-d', strtotime(str_replace('/', '-', $toDate)));				
			
			if($orgName) $customer_array =	array('AcrClient.organization_name LIKE'=> '%'.$orgName.'%');
			
			$condition_array = array('AcrClient.sbs_subscriber_id'=>$this->subscriber);
			
			$conditions 	 = array($condition_array, $customer_array);
						
		} else {			
			$toDate	  	= date('Y-m-d');
			$conditions = array('AcrClient.sbs_subscriber_id'=>$this->subscriber);
		}
		
		$clientResArr =  $this->AcrClient->find('all', array('conditions'=>$conditions,
		  'order'=>array('AcrClient.id' => 'DESC'),
		 'fields'=>array('AcrClient.id','AcrClient.organization_name')));
		
		$organizations =  $this->AcrClient->find('list', array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber),
		  'order'=>array('AcrClient.id' => 'DESC'),
		 'fields'=>array('AcrClient.organization_name','AcrClient.organization_name')));
		 
		 switch ($filterAction) {
		 	case 'invoice_balance':
					if(($min && $max) || ((!is_null($min) && !is_null($max)) && ($min == 0 && $max == 0))) {
						
						foreach($clientResArr as $ckey=>$cvalue){
			
							$clientId 			= $cvalue['AcrClient']['id'];
							$organizationName   = $cvalue['AcrClient']['organization_name'];
							
							$custCrncy =  $this->AcrClient->find('first', array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('cpn_currency_id')));
							$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($custCrncy['AcrClient']['cpn_currency_id']);
							$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];			
							
							$invoiceResArr =  $this->AcrClientInvoice->find('first', array(		 
							 'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId, 'AcrClientInvoice.invoiced_date <='=>$toDate,'AcrClientInvoice.recurring'=>'N','NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))), 
							 'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));							 
							 $totalInvoice   = $invoiceResArr['0']['invoice_total_amount'];
							  
							$paymentResArr =  $this->AcrInvoicePaymentDetail->find('first', array(	 
							 'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.payment_date <='=>$toDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
							 'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
							  $totalPayment   = $paymentResArr['0']['paid_total_amount'];	
							  
							  $invoiceBalance 	= $totalInvoice - $totalPayment;  
							 if($invoiceBalance >= $min && $invoiceBalance <=$max){
							 	
								$creditResArr =  $this->AcrClientCreditnote->find('first', array(			 
						 'conditions'=>array(
						 				'AND'=>array(
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Void'
													),
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Applied'
													)
												)
										), 
						 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));	
						 $totalCredit   = $creditResArr['AcrClientCreditnote']['balance_amount'];			 
								 
								 $creditBalance 	= $totalCredit;
								 $balance 			= $invoiceBalance - $creditBalance;
								 
								 $final_array[$ckey]['organizationName'] = $organizationName;
								 $final_array[$ckey]['invoiceBalance'] 	 = $invoiceBalance;
								 $final_array[$ckey]['creditBalance'] 	 = $creditBalance;
								 $final_array[$ckey]['balance'] 		 = $balance;
								 $final_array[$ckey]['custCrncyCode'] 	 = $customerCurrencyCode;	 								
							 }
							 
							
					 	} 
					} elseif(($min && !$max) || (!is_null($min) && $min == 0 && !$max)){
					   
						foreach($clientResArr as $ckey=>$cvalue){
			
							$clientId 			= $cvalue['AcrClient']['id'];
							$organizationName   = $cvalue['AcrClient']['organization_name'];
							
							$custCrncy =  $this->AcrClient->find('first', array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('cpn_currency_id')));
							$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($custCrncy['AcrClient']['cpn_currency_id']);
							$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];			
							
							$invoiceResArr =  $this->AcrClientInvoice->find('first', array(		 
							 'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId, 'AcrClientInvoice.invoiced_date <='=>$toDate,'AcrClientInvoice.recurring'=>'N', 'NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))), 
							 'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));			 
							 $totalInvoice   = $invoiceResArr['0']['invoice_total_amount'];
							  
							$paymentResArr =  $this->AcrInvoicePaymentDetail->find('first', array(	 
							 'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.payment_date <='=>$toDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
							 'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
							  $totalPayment   = $paymentResArr['0']['paid_total_amount'];	
							  
							  $invoiceBalance 	= $totalInvoice - $totalPayment;  
							if($invoiceBalance >= $min){							 
								$creditResArr =  $this->AcrClientCreditnote->find('first', array(			 
						 'conditions'=>array(
						 				'AND'=>array(
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Void'
													),
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Applied'
													)
												)
										), 
						 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));	
						 $totalCredit   = $creditResArr['AcrClientCreditnote']['balance_amount'];			 
								 
								 $creditBalance 	= $totalCredit;
								 $balance 			= $invoiceBalance - $creditBalance;
								 
								 $final_array[$ckey]['organizationName'] = $organizationName;
								 $final_array[$ckey]['invoiceBalance'] 	 = $invoiceBalance;
								 $final_array[$ckey]['creditBalance'] 	 = $creditBalance;
								 $final_array[$ckey]['balance'] 		 = $balance;
								 $final_array[$ckey]['custCrncyCode'] 	 = $customerCurrencyCode;	 
							 }
					 	} 
					} elseif(($max && !$min) || (!is_null($max) && $max == 0 && !$min)) {
						
						foreach($clientResArr as $ckey=>$cvalue){
			
							$clientId 			= $cvalue['AcrClient']['id'];
							$organizationName   = $cvalue['AcrClient']['organization_name'];			
							
							$custCrncy =  $this->AcrClient->find('first', array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('cpn_currency_id')));
							$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($custCrncy['AcrClient']['cpn_currency_id']);
							$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];
							
							$invoiceResArr =  $this->AcrClientInvoice->find('first', array(		 
							 'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId, 'AcrClientInvoice.invoiced_date <='=>$toDate,'AcrClientInvoice.recurring'=>'N','NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))), 
							 'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));			 
							 $totalInvoice   = $invoiceResArr['0']['invoice_total_amount'];
							  
							$paymentResArr =  $this->AcrInvoicePaymentDetail->find('first', array(	 
							 'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.payment_date <='=>$toDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
							 'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
							  $totalPayment   = $paymentResArr['0']['paid_total_amount'];	
							  
							  $invoiceBalance 	= $totalInvoice - $totalPayment;  
							 if($invoiceBalance <=$max){
							 
								$creditResArr =  $this->AcrClientCreditnote->find('first', array(			 
						 'conditions'=>array(
						 				'AND'=>array(
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Void'
													),
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Applied'
													)
												)
										), 
						 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));	
						 $totalCredit   = $creditResArr['AcrClientCreditnote']['balance_amount'];			 
								 
								 $creditBalance 	= $totalCredit;
								 $balance 			= $invoiceBalance - $creditBalance;
								 
								 $final_array[$ckey]['organizationName'] = $organizationName;
								 $final_array[$ckey]['invoiceBalance'] 	 = $invoiceBalance;
								 $final_array[$ckey]['creditBalance'] 	 = $creditBalance;
								 $final_array[$ckey]['balance'] 		 = $balance;
								 $final_array[$ckey]['custCrncyCode'] 	 = $customerCurrencyCode;	 
							}
					 	} 						
					}
				break;
			case 'credit_balance':
					if(($min && $max) || ((!is_null($min) && !is_null($max)) && ($min == 0 && $max == 0))) {
						foreach($clientResArr as $ckey=>$cvalue){
			
							$clientId 			= $cvalue['AcrClient']['id'];
							$organizationName   = $cvalue['AcrClient']['organization_name'];
							
							$custCrncy =  $this->AcrClient->find('first', array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('cpn_currency_id')));
							$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($custCrncy['AcrClient']['cpn_currency_id']);
							$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];
							 
							$creditResArr =  $this->AcrClientCreditnote->find('first', array(			 
						 'conditions'=>array(
						 				'AND'=>array(
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Void'
													),
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Applied'
													)
												)
										), 
						 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));	
						 $totalCredit   = $creditResArr['AcrClientCreditnote']['balance_amount'];
							 $creditBalance 	= $totalCredit;
							 
							  if($creditBalance >= $min && $creditBalance <=$max){
								  	$invoiceResArr =  $this->AcrClientInvoice->find('first', array(		 
								 	'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId, 'AcrClientInvoice.invoiced_date <='=>$toDate,'AcrClientInvoice.recurring'=>'N','NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))), 
								 	'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));			 
								 	$totalInvoice   = $invoiceResArr['0']['invoice_total_amount'];
								  
									$paymentResArr =  $this->AcrInvoicePaymentDetail->find('first', array(	 
								 	'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.payment_date <='=>$toDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
								 	'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
								  	$totalPayment   = $paymentResArr['0']['paid_total_amount'];	
								  
							  		$invoiceBalance 	= $totalInvoice - $totalPayment; 
									$balance 			= $invoiceBalance - $creditBalance;
							 
								 $final_array[$ckey]['organizationName'] = $organizationName;
								 $final_array[$ckey]['invoiceBalance'] 	 = $invoiceBalance;
								 $final_array[$ckey]['creditBalance'] 	 = $creditBalance;
								 $final_array[$ckey]['balance'] 		 = $balance;
								 $final_array[$ckey]['custCrncyCode'] 	 = $customerCurrencyCode;	 
							 }
					 	} 						
					} elseif(($min && !$max) || (!is_null($min) && $min == 0 && !$max)){
						foreach($clientResArr as $ckey=>$cvalue){
			
							$clientId 			= $cvalue['AcrClient']['id'];
							$organizationName   = $cvalue['AcrClient']['organization_name'];
							
							$custCrncy =  $this->AcrClient->find('first', array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('cpn_currency_id')));
							$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($custCrncy['AcrClient']['cpn_currency_id']);
							$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];
							 
							$creditResArr =  $this->AcrClientCreditnote->find('first', array(			 
						 'conditions'=>array(
						 				'AND'=>array(
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Void'
													),
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Applied'
													)
												)
										), 
						 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));	
						 $totalCredit   = $creditResArr['AcrClientCreditnote']['balance_amount'];
							 $creditBalance 	= $totalCredit;
							 
							  if($creditBalance >= $min){
								  	$invoiceResArr =  $this->AcrClientInvoice->find('first', array(		 
								 	'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId, 'AcrClientInvoice.invoiced_date <='=>$toDate,'AcrClientInvoice.recurring'=>'N','NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))), 
								 	'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));			 
								 	$totalInvoice   = $invoiceResArr['0']['invoice_total_amount'];
								  
									$paymentResArr =  $this->AcrInvoicePaymentDetail->find('first', array(	 
								 	'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.payment_date <='=>$toDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
								 	'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
								  	$totalPayment   = $paymentResArr['0']['paid_total_amount'];	
								  
							  		$invoiceBalance 	= $totalInvoice - $totalPayment; 
									$balance 			= $invoiceBalance - $creditBalance;
							 
								 $final_array[$ckey]['organizationName'] = $organizationName;
								 $final_array[$ckey]['invoiceBalance'] 	 = $invoiceBalance;
								 $final_array[$ckey]['creditBalance'] 	 = $creditBalance;
								 $final_array[$ckey]['balance'] 		 = $balance;
								 $final_array[$ckey]['custCrncyCode'] 	 = $customerCurrencyCode;	 
							 }
					 	}
						
					} elseif(($max && !$min) || (!is_null($max) && $max == 0 && !$min)) {
						foreach($clientResArr as $ckey=>$cvalue){
			
							$clientId 			= $cvalue['AcrClient']['id'];
							$organizationName   = $cvalue['AcrClient']['organization_name'];
							
							$custCrncy =  $this->AcrClient->find('first', array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('cpn_currency_id')));
							$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($custCrncy['AcrClient']['cpn_currency_id']);
							$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];
							 
							$creditResArr =  $this->AcrClientCreditnote->find('first', array(			 
						 'conditions'=>array(
						 				'AND'=>array(
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Void'
													),
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Applied'
													)
												)
										), 
						 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));	
						 	$totalCredit   = $creditResArr['AcrClientCreditnote']['balance_amount'];
							 $creditBalance 	= $totalCredit;
							 
							  if($creditBalance <=$max){
								  	$invoiceResArr =  $this->AcrClientInvoice->find('first', array(		 
								 	'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId, 'AcrClientInvoice.invoiced_date <='=>$toDate,'AcrClientInvoice.recurring'=>'N','NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))), 
								 	'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));			 
								 	$totalInvoice   = $invoiceResArr['0']['invoice_total_amount'];
								  
									$paymentResArr =  $this->AcrInvoicePaymentDetail->find('first', array(	 
								 	'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.payment_date <='=>$toDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
								 	'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
								  	$totalPayment   = $paymentResArr['0']['paid_total_amount'];	
								  
							  		$invoiceBalance 	= $totalInvoice - $totalPayment; 
									$balance 			= $invoiceBalance - $creditBalance;
							 
								 $final_array[$ckey]['organizationName'] = $organizationName;
								 $final_array[$ckey]['invoiceBalance'] 	 = $invoiceBalance;
								 $final_array[$ckey]['creditBalance'] 	 = $creditBalance;
								 $final_array[$ckey]['balance'] 		 = $balance;
								 $final_array[$ckey]['custCrncyCode'] 	 = $customerCurrencyCode;	 
							 }
					 	}		
					}
				break;
			case 'balance':
					if(($min && $max) || ((!is_null($min) && !is_null($max)) && ($min == 0 && $max == 0))) {
						foreach($clientResArr as $ckey=>$cvalue){
			
							$clientId 			= $cvalue['AcrClient']['id'];
							$organizationName   = $cvalue['AcrClient']['organization_name'];			
							
							$custCrncy =  $this->AcrClient->find('first', array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('cpn_currency_id')));
							$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($custCrncy['AcrClient']['cpn_currency_id']);
							$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];
							
							$invoiceResArr =  $this->AcrClientInvoice->find('first', array(		 
							 'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId, 'AcrClientInvoice.invoiced_date <='=>$toDate,'AcrClientInvoice.recurring'=>'N','NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))), 
							 'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));			 
							 $totalInvoice   = $invoiceResArr['0']['invoice_total_amount'];
							  
							$paymentResArr =  $this->AcrInvoicePaymentDetail->find('first', array(	 
							 'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.payment_date <='=>$toDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
							 'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
							  $totalPayment   = $paymentResArr['0']['paid_total_amount'];	
							  
							  $invoiceBalance 	= $totalInvoice - $totalPayment;  
							 
							 
							$creditResArr =  $this->AcrClientCreditnote->find('first', array(			 
						 'conditions'=>array(
						 				'AND'=>array(
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Void'
													),
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Applied'
													)
												)
										), 
						 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));	
						 $totalCredit   = $creditResArr['AcrClientCreditnote']['balance_amount'];		 
							 
							 $creditBalance 	= $totalCredit;
							 $balance 			= $invoiceBalance - $creditBalance;
							 if($balance >= $min && $balance <=$max){
								 $final_array[$ckey]['organizationName'] = $organizationName;
								 $final_array[$ckey]['invoiceBalance'] 	 = $invoiceBalance;
								 $final_array[$ckey]['creditBalance'] 	 = $creditBalance;
								 $final_array[$ckey]['balance'] 		 = $balance;
								 $final_array[$ckey]['custCrncyCode'] 	 = $customerCurrencyCode;	 
							}
					 	} 
						
					} elseif(($min && !$max) || (!is_null($min) && $min == 0 && !$max)){
						foreach($clientResArr as $ckey=>$cvalue){
			
							$clientId 			= $cvalue['AcrClient']['id'];
							$organizationName   = $cvalue['AcrClient']['organization_name'];			
							
							$custCrncy =  $this->AcrClient->find('first', array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('cpn_currency_id')));
							$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($custCrncy['AcrClient']['cpn_currency_id']);
							$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];
							
							$invoiceResArr =  $this->AcrClientInvoice->find('first', array(		 
							 'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId, 'AcrClientInvoice.invoiced_date <='=>$toDate,'AcrClientInvoice.recurring'=>'N','NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))), 
							 'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));			 
							 $totalInvoice   = $invoiceResArr['0']['invoice_total_amount'];
							  
							$paymentResArr =  $this->AcrInvoicePaymentDetail->find('first', array(	 
							 'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.payment_date <='=>$toDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
							 'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
							  $totalPayment   = $paymentResArr['0']['paid_total_amount'];	
							  
							  $invoiceBalance 	= $totalInvoice - $totalPayment;  
							 
							 
							$creditResArr =  $this->AcrClientCreditnote->find('first', array(			 
						 'conditions'=>array(
						 				'AND'=>array(
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Void'
													),
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Applied'
													)
												)
										), 
						 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));	
						 $totalCredit   = $creditResArr['AcrClientCreditnote']['balance_amount'];			 
							 
							 $creditBalance 	= $totalCredit;
							 $balance 			= $invoiceBalance - $creditBalance;
							 if($balance >= $min){
								 $final_array[$ckey]['organizationName'] = $organizationName;
								 $final_array[$ckey]['invoiceBalance'] 	 = $invoiceBalance;
								 $final_array[$ckey]['creditBalance'] 	 = $creditBalance;
								 $final_array[$ckey]['balance'] 		 = $balance;
								 $final_array[$ckey]['custCrncyCode'] 	 = $customerCurrencyCode;	
							 }
					 	} 
						
					} elseif(($max && !$min) || (!is_null($max) && $max == 0 && !$min)) {
						foreach($clientResArr as $ckey=>$cvalue){
			
							$clientId 			= $cvalue['AcrClient']['id'];
							$organizationName   = $cvalue['AcrClient']['organization_name'];			
							
							$custCrncy =  $this->AcrClient->find('first', array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('cpn_currency_id')));
							$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($custCrncy['AcrClient']['cpn_currency_id']);
							$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];
							
							$invoiceResArr =  $this->AcrClientInvoice->find('first', array(		 
							 'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId, 'AcrClientInvoice.invoiced_date <='=>$toDate,'AcrClientInvoice.recurring'=>'N','NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))), 
							 'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));			 
							 $totalInvoice   = $invoiceResArr['0']['invoice_total_amount'];
							  
							$paymentResArr =  $this->AcrInvoicePaymentDetail->find('first', array(	 
							 'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.payment_date <='=>$toDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
							 'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
							  $totalPayment   = $paymentResArr['0']['paid_total_amount'];	
							  
							  $invoiceBalance 	= $totalInvoice - $totalPayment;  
							 
							 
							$creditResArr =  $this->AcrClientCreditnote->find('first', array(			 
						 'conditions'=>array(
						 				'AND'=>array(
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Void'
													),
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Applied'
													)
												)
										), 
						 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));	
						 $totalCredit   = $creditResArr['AcrClientCreditnote']['balance_amount'];			 
							 
							 $creditBalance 	= $totalCredit;
							 $balance 			= $invoiceBalance - $creditBalance;
							 if($balance <=$max){
								 $final_array[$ckey]['organizationName'] = $organizationName;
								 $final_array[$ckey]['invoiceBalance'] 	 = $invoiceBalance;
								 $final_array[$ckey]['creditBalance'] 	 = $creditBalance;
								 $final_array[$ckey]['balance'] 		 = $balance;
								 $final_array[$ckey]['custCrncyCode'] 	 = $customerCurrencyCode;	
							 }
					 	} 						
					}
				break;
			default :
					foreach($clientResArr as $ckey=>$cvalue){
			
						$clientId 			= $cvalue['AcrClient']['id'];
						$organizationName   = $cvalue['AcrClient']['organization_name'];			
						
						$custCrncy =  $this->AcrClient->find('first', array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('cpn_currency_id')));
						$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($custCrncy['AcrClient']['cpn_currency_id']);
						$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];
						
						$invoiceResArr =  $this->AcrClientInvoice->find('first', array(		 
						 'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId, 'AcrClientInvoice.invoiced_date <='=>$toDate,'AcrClientInvoice.recurring'=>'N','NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))), 
						 'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));			 
						 $totalInvoice   = $invoiceResArr['0']['invoice_total_amount'];
						  
						$paymentResArr =  $this->AcrInvoicePaymentDetail->find('first', array(	 
						 'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.payment_date <='=>$toDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
						 'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
						  $totalPayment   = $paymentResArr['0']['paid_total_amount'];	
						  
						  $invoiceBalance 	= $totalInvoice - $totalPayment;  
						 
						 
						$creditResArr =  $this->AcrClientCreditnote->find('first', array(			 
						 'conditions'=>array(
						 				'AND'=>array(
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Void'
													),
						 						array(
						 								'AcrClientCreditnote.acr_client_id'=>$clientId, 
						 								'AcrClientCreditnote.date_created <='=>$toDate, 
						 								'AcrClientCreditnote.status !=' => 'Applied'
													)
												)
										), 
						 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));	
						 $totalCredit   = $creditResArr['AcrClientCreditnote']['balance_amount'];			 
						 
						 $creditBalance 	= $totalCredit;
						 $balance 			= $invoiceBalance - $creditBalance;
						 
						 $final_array[$ckey]['organizationName'] = $organizationName;
						 $final_array[$ckey]['invoiceBalance'] 	 = $invoiceBalance;
						 $final_array[$ckey]['creditBalance'] 	 = $creditBalance;
						 $final_array[$ckey]['balance'] 		 = $balance;
						 $final_array[$ckey]['custCrncyCode'] 	 = $customerCurrencyCode;						 
					} 
				break;	
		 }	
		
		 if($export == 'ex_excel' || $export == 'ex_pdf' ){
		 	$final['final_array'] 			 = $final_array;
			$final['date_format'] 		  	 = $date_format;
			$final['subscriberCurrencyCode'] = $subscriberCurrencyCode;
			$final['sbsOrgName'] 			 = $sbsOrgName;			
	    	return $final;
		}
		
		/*Dynamic Sorting */
		$sortingOrder = "ASC";
		if($defaultSortBy){
			if($defaultSortBy =="ASC"){
				$sortingOrder = "DESC";
			}else{
				$sortingOrder = "ASC";
			}			
		}
		switch($sortBy){
			case "Customer Name": $final_array 		= Set::sort($final_array,'{n}.organizationName',$sortingOrder);
								  break;
			case "Invoice Balance": $final_array  	= Set::sort($final_array,'{n}.invoiceBalance',$sortingOrder);
								  break;
			case "Credit Balance": $final_array 	= Set::sort($final_array,'{n}.creditBalance',$sortingOrder);
								  break;
			case "Balance": $final_array 			= Set::sort($final_array,'{n}.balance',$sortingOrder);
								  break;			
		}
		/*Dynamic Sorting Ends */
	   
		
		$this->set(compact('organizations', 'date_format','final_array','sortingOrder', 'orgName', 'filterAction', 'min', 'max', 'toDate','subscriberCurrencyCode','sbsOrgName'));	
	}

	public function custBalExcel ($ex_excel = null, $orgName = null, $filterAction = null, $min = null, $max = null, $toDate = null) {
		if($ex_excel == 'ex_excel'){
			$final_arrays = $this->customerBalance('ex_excel', $orgName, $filterAction, $min, $max, $toDate);
			$final_array 			= $final_arrays['final_array'];
			$date_format			= $final_arrays['date_format'];
			$subscriberCurrencyCode	= $final_arrays['subscriberCurrencyCode'];	    		
		}		
		$this->set(compact('final_array', 'toDate','date_format','subscriberCurrencyCode'));
	}


	public function custBalPdf ($ex_pdf = null, $orgName = null, $filterAction = null, $min = null, $max = null, $toDate = null) {
		
		$this->layout = '/pdf/default';
		if($ex_pdf == 'ex_pdf'){
			$final_arrays = $this->customerBalance('ex_pdf', $orgName, $filterAction, $min, $max, $toDate);		
			$final_array 			= $final_arrays['final_array'];
			$date_format			= $final_arrays['date_format'];
			$subscriberCurrencyCode	= $final_arrays['subscriberCurrencyCode'];
			$sbsOrgName				= $final_arrays['sbsOrgName'];
	
			$this->set(compact('final_array', 'toDate','date_format','subscriberCurrencyCode','sbsOrgName'));
			$this->render('/Pdf/cust_bal_pdf');
		}	
	}	
	
	/* Customer Balance Report section END */
	
	
	
	/* Customer Statement Report section START */
	
	public function customerStatement ($export = null, $orgName = null, $docType = null, $docNo = null, $fromDate = null, $toDate = null,  $defaultSortBy = null) {
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Customer Statement Report';
		$this->set(compact('menuActive','permission'));
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));		
	
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('AcrInvoicePaymentDetail');
		$this->loadModel('AcrClientCreditnote');
		$this->loadModel('AcrClient');				
			
		
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$date_format    = $settings['SbsSubscriberSetting']['date_format'];			
		$subscriberCurrency 	= $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode = $subscriberCurrency['CpnCurrency']['code'];		
		
		$organizations =  $this->AcrClient->find('list', array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber),
		  'order'=>array('AcrClient.id' => 'DESC'),
		 'fields'=>array('AcrClient.id','AcrClient.organization_name')));
		 
		 if(!$fromDate) $fromDate = date('Y-m-01');
		 if(!$toDate)   $toDate	  = date('Y-m-t');
		 
		$final = array(); $count = 0; $total_amount = 0; $total_due = 0;
		
		if ($export == 'ex_excel' || $export == 'ex_pdf' || $export == 'null') {
			
				if($orgName == 'null')
				{
					$orgName = null;
				}
				if($docType == 'null')
				{
					$docType = null;
				}
				if($docNo == 'null')
				{
					$docNo = null;
				}
				if($fromDate == 'null')
				{
					$fromDate = null;
				}
				if($toDate == 'null')
				{
					$toDate = null;
				}										
			
			    $this->request->data['CustomerStatement']['orgName']  	= trim($orgName);			
			
				$this->request->data['CustomerStatement']['docType']   	= trim($docType);			
			
				$this->request->data['CustomerStatement']['docNo'] 		= trim($docNo);			
			
				$this->request->data['CustomerStatement']['fromDate'] 	= trim($fromDate);			
			
				$this->request->data['CustomerStatement']['toDate'] 	= trim($toDate);		
			
		}	
		
		if($this->data['CustomerStatement'] || ($export == 'ex_excel' || $export == 'ex_pdf')){			
			
			
			if(!empty($this->request->data['CustomerStatement']['orgName'])) 				
			 $orgName    = trim($this->request->data['CustomerStatement']['orgName']);
			
			if(!empty($this->request->data['CustomerStatement']['docType'])) 				
			 $docType    = trim($this->request->data['CustomerStatement']['docType']);				
			
			if(!empty($this->request->data['CustomerStatement']['docNo'])) 				
			 $docNo      = trim($this->request->data['CustomerStatement']['docNo']);					
			
			if(!empty($this->request->data['CustomerStatement']['fromDate']))
			 $fromDate       = trim($this->request->data['CustomerStatement']['fromDate']);
			if($fromDate)   $fromDate	  = date('Y-m-d', strtotime(str_replace('/', '-', $fromDate)));			
			
			if(!empty($this->request->data['CustomerStatement']['toDate']))
			 $toDate       = trim($this->request->data['CustomerStatement']['toDate']);
			if($toDate)   $toDate	  = date('Y-m-d', strtotime(str_replace('/', '-', $toDate)));
		 
			if(!$orgName || !$fromDate || !$toDate) {
		 		$this->Session->setFlash('<div class="alert alert-danger"> CustomerName, From Date and To Date are Mandatory Fields.</div>');
			 }
			else {
				
				$orgnameArr  = $this->AcrClient->find('first', array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber, 'AcrClient.id'=>$orgName),		 
		 					'fields'=>array('AcrClient.organization_name','AcrClient.cpn_currency_id')));
				$orgname = $orgnameArr['AcrClient']['organization_name'];				
				$customerCurrency 	  = $this->CpnCurrency->getCurrencyById($orgnameArr['AcrClient']['cpn_currency_id']);
				$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];				
				
				$invoiceResTotal =  $this->AcrClientInvoice->find('first', array(		 
				 'conditions'=>array('AcrClientInvoice.acr_client_id'=>$orgName, 'AcrClientInvoice.invoiced_date <'=>$fromDate,'AcrClientInvoice.recurring'=>'N', 'NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft'))),
				 'fields'=>array('SUM(AcrClientInvoice.invoice_total) As invoice_total_amount')));			 
				 $totalInvoice   = $invoiceResTotal['0']['invoice_total_amount'];
				  
				$paymentResTotal =  $this->AcrInvoicePaymentDetail->find('first', array(	 
				 'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$orgName, 'AcrInvoicePaymentDetail.payment_date <'=>$fromDate, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),  
				 'fields'=>array('SUM(AcrInvoicePaymentDetail.paid_amount) As paid_total_amount')));	
				  $totalPayment   = $paymentResTotal['0']['paid_total_amount'];
				 
				/*
				$creditResTotal =  $this->AcrClientCreditnote->find('first', array(			 
								 'conditions'=>array('AND'=>array(
																 array('AcrClientCreditnote.acr_client_id'=>$orgName, 
																 'AcrClientCreditnote.date_created <'=>$fromDate, 
																 'AcrClientCreditnote.status !=' => 'Void'
																),
																 array('AcrClientCreditnote.acr_client_id'=>$orgName, 
																 'AcrClientCreditnote.date_created <'=>$fromDate, 
																 'AcrClientCreditnote.status !=' => 'Open')
															)
													), 
																  'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')));*/
				
				$creditResTotal =  $this->AcrClientCreditnote->find('first', array(			 
				 'conditions'=>array(
				 						'AcrClientCreditnote.acr_client_id'=>$orgName, 
				 						'AcrClientCreditnote.date_created <'=>$fromDate, 
				 						'AcrClientCreditnote.status !=' => 'Void'
									), 
				
				 /*'fields'=>array('SUM(AcrClientCreditnote.amount) As credit_total_amount')*/));
					
				 $totalCredit   = $creditResTotal['AcrClientCreditnote']['balance_amount'];	
				
				 $initial_balance_due =  $totalInvoice - ($totalPayment + $totalCredit);
				 $init_bal_due        =  $initial_balance_due;				
				
			    if($docType) {
					
					switch ($docType) {
			 	
					 	case 'invoice': 
					 				$clientId 			= $orgName;	
									if($docNo){
										$conditions = array('AcrClientInvoice.acr_client_id'=>$clientId,'AcrClientInvoice.recurring'=>'N', 'NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft')), 'AcrClientInvoice.invoice_number like'=>'%'.$docNo.'%', 'AcrClientInvoice.invoiced_date BETWEEN ? and ?' =>array($fromDate, $toDate));	
									} else {
										$conditions = array('AcrClientInvoice.acr_client_id'=>$clientId,'AcrClientInvoice.recurring'=>'N', 'NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft')), 'AcrClientInvoice.invoiced_date BETWEEN ? and ?' =>array($fromDate, $toDate));
									}																	
									$invoiceResArr =  $this->AcrClientInvoice->find('all', array(		 
									 'conditions'=>$conditions, 
									 'fields'=>array('AcrClientInvoice.invoice_number', 'AcrClientInvoice.invoice_total', 'AcrClientInvoice.invoiced_date'),
									 'order'=>array('AcrClientInvoice.invoiced_date' => 'DESC')));						
								foreach($invoiceResArr as $key=>$value){
									
									$final[$value['AcrClientInvoice']['invoiced_date']][$count]['doc_type'] = "Invoice";
									$final[$value['AcrClientInvoice']['invoiced_date']][$count]['doc_no']    = $value['AcrClientInvoice']['invoice_number'];
									$final[$value['AcrClientInvoice']['invoiced_date']][$count]['amount']    = $value['AcrClientInvoice']['invoice_total'];
									$final[$value['AcrClientInvoice']['invoiced_date']][$count]['date']      = $value['AcrClientInvoice']['invoiced_date'];
								    $total_amount = $total_amount + $value['AcrClientInvoice']['invoice_total'];									
								    $count++;
								}
								$final['totalAmount'] 			 = $total_amount;
								$final['date_format'] 			 = $date_format;
								$final['subscriberCurrencyCode'] = $subscriberCurrencyCode;
								$final['orgname'] 				 = $orgname;
								$final['custCrncyCode']			 = $customerCurrencyCode;								
							break;
								
						case 'payment': 
			 				$clientId 			= $orgName;
							if($docNo){
								$conditions = array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.is_deleted'=>'no', 'AcrInvoicePaymentDetail.reference_no like'=>'%'.$docNo.'%', 'AcrInvoicePaymentDetail.payment_date BETWEEN ? and ?' =>array($fromDate, $toDate));	
							} else {
								$conditions = array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.is_deleted'=>'no',  'AcrInvoicePaymentDetail.payment_date BETWEEN ? and ?' =>array($fromDate, $toDate));
							}
							$paymentResArr =  $this->AcrInvoicePaymentDetail->find('all', array(	 
							 'conditions'=>$conditions,  
							 'fields'=>array('AcrInvoicePaymentDetail.reference_no', 'AcrInvoicePaymentDetail.paid_amount', 'AcrInvoicePaymentDetail.payment_date'),
							 'order'=>array('AcrInvoicePaymentDetail.payment_date' => 'DESC')));						 
							 	foreach($paymentResArr as $key=>$value){
									
									$final[$value['AcrInvoicePaymentDetail']['payment_date']][$count]['doc_type'] 	= "Payment";
									$final[$value['AcrInvoicePaymentDetail']['payment_date']][$count]['doc_no'] 	= $value['AcrInvoicePaymentDetail']['reference_no'];
									$final[$value['AcrInvoicePaymentDetail']['payment_date']][$count]['amount'] 	= $value['AcrInvoicePaymentDetail']['paid_amount'];
									$final[$value['AcrInvoicePaymentDetail']['payment_date']][$count]['bal_due']    = $initial_balance_due - $value['AcrInvoicePaymentDetail']['paid_amount'];
									$total_amount = $total_amount + $value['AcrInvoicePaymentDetail']['paid_amount'];
									$count++;
								} 
								$final['totalAmount'] 			 = $total_amount;
								$final['date_format'] 			 = $date_format;
								$final['subscriberCurrencyCode'] = $subscriberCurrencyCode;
								$final['orgname'] 				 = $orgname;
								$final['custCrncyCode']			 = $customerCurrencyCode;								 
							break;
							
						case 'credit': 
			 				$clientId 			= $orgName;
							if($docNo){
								$conditions = array('AcrClientCreditnote.acr_client_id'=>$clientId,'AcrClientCreditnote.status !='=>'Void',  'AcrClientCreditnote.id like'=>'%'.$docNo.'%', 'AcrClientCreditnote.date_created BETWEEN ? and ?' =>array($fromDate, $toDate));	
							} else {
								$conditions = array('AcrClientCreditnote.acr_client_id'=>$clientId,'AcrClientCreditnote.status !='=>'Void', 'AcrClientCreditnote.date_created BETWEEN ? and ?' =>array($fromDate, $toDate));
							}
							$creditResArr =  $this->AcrClientCreditnote->find('all', array(			 
							 'conditions'=>$conditions, 
							 'fields'=>array('AcrClientCreditnote.id', 'AcrClientCreditnote.balance_amount', 'AcrClientCreditnote.date_created','AcrClientCreditnote.status'),
							 'order'=>array('AcrClientCreditnote.date_created' => 'DESC')));	
							 	foreach($creditResArr as $key=>$value){
									
									$final[$value['AcrClientCreditnote']['date_created']][$count]['doc_type'] 	= "Credit";
									$final[$value['AcrClientCreditnote']['date_created']][$count]['doc_no'] 	= 'CRD-'.$value['AcrClientCreditnote']['id'];
									$final[$value['AcrClientCreditnote']['date_created']][$count]['amount'] 	= $value['AcrClientCreditnote']['balance_amount'];
									$final[$value['AcrClientCreditnote']['date_created']][$count]['date'] 		= $value['AcrClientCreditnote']['date_created'];
									$total_amount = $total_amount + $value['AcrClientCreditnote']['balance_amount'];
									$count++;
									if(($value['AcrClientCreditnote']['status'] == 'Open') || ($value['AcrClientCreditnote']['status'] == 'Partially Applied')){
										$final[$value['AcrClientCreditnote']['date_created']][$count]['doc_type'] 	= "Credit Reversal";
										$final[$value['AcrClientCreditnote']['date_created']][$count]['doc_no'] 	= 'CRD-'.$value['AcrClientCreditnote']['id'];
										$final[$value['AcrClientCreditnote']['date_created']][$count]['amount'] 	= $value['AcrClientCreditnote']['balance_amount'];
										$final[$value['AcrClientCreditnote']['date_created']][$count]['date'] 		= $value['AcrClientCreditnote']['date_created'];
										$total_amount = $total_amount + $value['AcrClientCreditnote']['balance_amount'];
										$count++;
									}					
								}
								$final['totalAmount'] 			 = $total_amount;
								$final['date_format'] 			 = $date_format;
								$final['subscriberCurrencyCode'] = $subscriberCurrencyCode;
								$final['orgname'] 				 = $orgname;	
								$final['custCrncyCode']			 = $customerCurrencyCode;						 
							break;							
						}					
				} else {					
							$clientId 			= $orgName;
							$invoiceResArr =  $this->AcrClientInvoice->find('all', array(		 
							 'conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId,'AcrClientInvoice.recurring'=>'N', 'NOT'=>array('AcrClientInvoice.status'=>array('Canceled', 'Draft')), 'AcrClientInvoice.invoiced_date BETWEEN ? and ?' =>array($fromDate, $toDate)), 
							 'fields'=>array('AcrClientInvoice.invoice_number', 'AcrClientInvoice.invoice_total', 'AcrClientInvoice.invoiced_date'),
							 'order'=>array('AcrClientInvoice.invoiced_date' => 'DESC')));						
								foreach($invoiceResArr as $key=>$value){
									
									$final[$value['AcrClientInvoice']['invoiced_date']][$count]['doc_type']  = "Invoice";
									$final[$value['AcrClientInvoice']['invoiced_date']][$count]['doc_no']    = $value['AcrClientInvoice']['invoice_number'];
									$final[$value['AcrClientInvoice']['invoiced_date']][$count]['amount']    = $value['AcrClientInvoice']['invoice_total'];
									$final[$value['AcrClientInvoice']['invoiced_date']][$count]['date']      = $value['AcrClientInvoice']['invoiced_date'];
								    $total_amount = $total_amount + $value['AcrClientInvoice']['invoice_total'];								    
								    $count++;
								}  
							$paymentResArr =  $this->AcrInvoicePaymentDetail->find('all', array(	 
							 'conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId, 'AcrInvoicePaymentDetail.is_deleted'=>'no', 'AcrInvoicePaymentDetail.payment_date BETWEEN ? and ?' =>array($fromDate, $toDate)),  
							 'fields'=>array('AcrInvoicePaymentDetail.reference_no', 'AcrInvoicePaymentDetail.paid_amount', 'AcrInvoicePaymentDetail.payment_date'),
							 'order'=>array('AcrInvoicePaymentDetail.payment_date' => 'DESC')));						 
							 	foreach($paymentResArr as $key=>$value){
									
									$final[$value['AcrInvoicePaymentDetail']['payment_date']][$count]['doc_type'] 	= "Payment";
									$final[$value['AcrInvoicePaymentDetail']['payment_date']][$count]['doc_no'] 	= $value['AcrInvoicePaymentDetail']['reference_no'];
									$final[$value['AcrInvoicePaymentDetail']['payment_date']][$count]['amount'] 	= $value['AcrInvoicePaymentDetail']['paid_amount'];
									$final[$value['AcrInvoicePaymentDetail']['payment_date']][$count]['date'] 		= $value['AcrInvoicePaymentDetail']['payment_date'];
									$total_amount = $total_amount - $value['AcrInvoicePaymentDetail']['paid_amount'];
									$count++;
								}
							$creditResArr =  $this->AcrClientCreditnote->find('all', array(			 
							 'conditions'=>array(
							 								
							 									'AcrClientCreditnote.acr_client_id'=>$clientId, 
							 									'AcrClientCreditnote.status !=' => 'Void', 
							 									'AcrClientCreditnote.date_created BETWEEN ? and ?' =>array($fromDate, $toDate)
												), 
							 'fields'=>array('AcrClientCreditnote.id', 'AcrClientCreditnote.balance_amount', 'AcrClientCreditnote.date_created','AcrClientCreditnote.status'),
							 'order'=>array('AcrClientCreditnote.date_created' => 'DESC')));	
							 	;
							 	foreach($creditResArr as $key=>$value){
									
									$final[$value['AcrClientCreditnote']['date_created']][$count]['doc_type'] 	= "Credit";
									$final[$value['AcrClientCreditnote']['date_created']][$count]['doc_no'] 	= 'CRD-'.$value['AcrClientCreditnote']['id'];
									$final[$value['AcrClientCreditnote']['date_created']][$count]['amount'] 	= $value['AcrClientCreditnote']['balance_amount'];
									$final[$value['AcrClientCreditnote']['date_created']][$count]['date'] 		= $value['AcrClientCreditnote']['date_created'];
									$total_amount = $total_amount - $value['AcrClientCreditnote']['balance_amount'];
									$count++;	
									
									if(($value['AcrClientCreditnote']['status'] == 'Open')|| ($value['AcrClientCreditnote']['status'] == 'Partially Applied')){
										$final[$value['AcrClientCreditnote']['date_created']][$count]['doc_type'] 	= "Credit Reversal";
										$final[$value['AcrClientCreditnote']['date_created']][$count]['doc_no'] 	= 'CRD-'.$value['AcrClientCreditnote']['id'];
										$final[$value['AcrClientCreditnote']['date_created']][$count]['amount'] 	= $value['AcrClientCreditnote']['balance_amount'];
										$final[$value['AcrClientCreditnote']['date_created']][$count]['date'] 		= $value['AcrClientCreditnote']['date_created'];
										$total_amount = $total_amount + $value['AcrClientCreditnote']['balance_amount'];
										$count++;
									}				
								}
								$final['totalAmount'] 			 = $total_amount;
								$final['date_format'] 			 = $date_format;
								$final['subscriberCurrencyCode'] = $subscriberCurrencyCode;
								$final['orgname'] 				 = $orgname;
								$final['custCrncyCode']			 = $customerCurrencyCode;		
								$final['init_bal_due'] 			 = $init_bal_due;								
				   }
                    $sortingOrder = 'Asc';
					if(is_null($defaultSortBy)){
						$defaultSortBy = $sortingOrder;
					}
					if($defaultSortBy && $defaultSortBy == 'Desc'){
						// sort array by key in descending order
						 krsort($final);
						 $sortingOrder = 'Asc';						
					} else {
						// sort array by key in ascending order
						ksort($final);
						$sortingOrder = 'Desc';
					}
			   }
		  }	
		
		if($export == 'ex_excel' || $export == 'ex_pdf' ){				
	    	return $final;
		}	   
		
		$this->set(compact('date_format', 'init_bal_due', 'final','sortingOrder', 'orgName', 'docType', 'docNo', 'fromDate', 'toDate','customerCurrencyCode','subscriberCurrencyCode','organizations'));	
		
	}	
	
	public function custStatementExcel ($ex_excel = null, $orgName = null, $docType = null, $docNo = null, $fromDate = null, $toDate = null) {
		
		if($ex_excel == 'ex_excel'){
			$final = $this->customerStatement('ex_excel', $orgName, $docType, $docNo, $fromDate, $toDate);			    		
		}		
		$this->set(compact('final', 'toDate', 'fromDate'));
	}
	
	public function custStatementPdf ($ex_pdf = null, $orgName = null, $docType = null, $docNo = null, $fromDate = null, $toDate = null) {
		
		$this->layout = '/pdf/default';
		if($ex_pdf == 'ex_pdf'){
			$final = $this->customerStatement('ex_pdf', $orgName, $docType, $docNo, $fromDate, $toDate);	
			$this->set(compact('final', 'toDate', 'fromDate'));
			$this->render('/Pdf/cust_statement_pdf');
		}			
	}
	
	
	/* Customer Statement Report section END */
	
	
	
	public function salesReport($sortBy = null,$defaultSortBy = null,$organizationName = null,$filterAction = null,$min = null,$max = null,$fromDate = null,$toDate = null){
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Sales Report';
		$this->set(compact('menuActive','permission')); 
		
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrClient');
		if($organizationName != "null"){
			$data['sales']['orgName'] = $organizationName;
		}
		if($filterAction != "null"){
			$data['sales']['filterAction'] = $filterAction;
		}
		if($min){
			$data['sales']['min'] = $min;
		}
		if($max){
			$data['sales']['max'] = $max;
		}if($toDate){
			$data['sales']['toDate'] = str_replace('/', '-',$toDate);
		}else{
			$data['sales']['toDate']	=	date('Y-m-d');
		}
		if($fromDate){
			$data['sales']['fromDate'] = str_replace('/', '-',$fromDate);
		}else{
			$data['sales']['fromDate'] = date('Y-m-01');
		}
		if($this->data['sales']){
			$data['sales'] = $this->data['sales'];
		}
		if($data['sales']['toDate']){
			$toDate = str_replace('/', '-',$data['sales']['toDate']);
		}else{
			$toDate = date('Y-m-d');
			//$toDate = '2014-10-30';
		}if($data['sales']['fromDate']){
			$fromDate = str_replace('/', '-',$data['sales']['fromDate']);
		}else{
			$fromDate = date('Y-m-01');
			//$fromDate	=	'2014-10-01';
		}
		$subscriberId = $this->subscriber;
		if($data['sales']){
			if($data['sales']['orgName']){
				$organizationName = $data['sales']['orgName'];
				$toDate = $data['sales']['toDate'];
				switch($data['sales']['filterAction']){
					case "no_item_sold" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%');
										$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																				
																				
																				
																			 ),
														'group' => array(
															'AcrClientInvoice.acr_client_id'
														)
										);
										
										$filterAction = "no_item_sold";
										break;
					case "no_of_invoice" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.count_id BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "no_of_invoice";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																					
																				)
														
																			
																			
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min'].' AND count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
																		  
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					case "sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.sum_sub_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "sales";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),  
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),  
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					case "tax" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.sum_tax_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "tax";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					case "total_sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.sum_func_currency_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "total_sales";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					default		:      	$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%');	
										$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																			 			'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																			 			'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														'group' => array(
															'AcrClientInvoice.acr_client_id'
														)
										);		
										break;		
			}		
			}elseif($data['sales']['filterAction']){
				switch($data['sales']['filterAction']){
					case "no_item_sold" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber);
										$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														'group' => array(
															'acr_client_id'
														)
										);
										$filterAction = "no_item_sold";
										break;
					case "no_of_invoice" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.count_id BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min'].' AND count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
																		  
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										
										$filterAction = "no_of_invoice";
										
										break;
					case "sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_sub_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/', '-', $data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										$filterAction = "sales";
										break;
					case "tax" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_tax_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										$filterAction = "tax";
										break;
					case "total_sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_func_currency_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										$filterAction = "total_sales";
										break;
				}
			}else{
				$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_func_currency_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
				$options = array(
					'fields' => array(
								'AcrClientInvoice.acr_client_id',
								'AcrClient.organization_name',
								'AcrClientInvoice.count_id',
								'AcrClientInvoice.sum_sub_total',
								'AcrClientInvoice.sum_tax_total',
								'AcrClientInvoice.sum_func_currency_total',
								'AcrClientInvoice.status',
								'AcrClientInvoice.invoiced_date'
								),
					'conditions' => array(
										'AND'=>array(
													array(
													'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
													'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
													'AcrClientInvoice.status !=' =>'Canceled','AcrClientInvoice.recurring'=>'N'
													),
													array(
													'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
													'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
													'AcrClientInvoice.status !=' =>'Draft','AcrClientInvoice.recurring'=>'N'
													)
												),
										
										
									),
					'group' => array(
									'AcrClientInvoice.acr_client_id'
							   ),
				);
			}
			if(!$organizationName){$organizationName = "null";}
			if(!$filterAction){$filterAction = "null";}
			$min = $data['sales']['min'];
			$max = $data['sales']['max'];
			if(!$min){$min = 0;}
			if(!$max){$max = 0;}
			/*
			if($data['sales']['toDate']){$toDate = $data['sales']['toDate'];}
						else{
							$toDate = date('Y-m-d');
						}*/
			
			$this->set(compact('organizationName','filterAction','min','max','toDate','fromDate'));
		}
		if($conditions){
			
			$invoiceData   = $this->AcrClientInvoice->getInvoicesGroupByClient($this->subscriber,$options);
			$invoiceDetails = $this->AcrInvoiceDetail->detailGroupedByClient($this->subscriber,$fromDate,$toDate);
			if($data['sales']['filterAction'] == "no_item_sold"){
				
				if(($data['sales']['min']) && ($data['sales']['max'])){
					foreach($invoiceDetails as $key => $invoiceDetail){
						if(($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] >= $data['sales']['min']) && ($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] <= $data['sales']['max']) && ($invoiceData[$key]['AcrClient']['organization_name'])){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}else{
							$invoiceData[$key] = null;
						}
					}
				}elseif(($data['sales']['min']) && (!$data['sales']['max'])){
					foreach($invoiceDetails as $key => $invoiceDetail){
						if(($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] >= $data['sales']['min'])&& ($invoiceData[$key]['AcrClient']['organization_name'])){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}else{
							$invoiceData[$key] = null;
						}
					}
				}elseif((!$data['sales']['min']) && ($data['sales']['max'])){
					foreach($invoiceDetails as $key => $invoiceDetail){
						if(($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] <= $data['sales']['max']) && ($invoiceData[$key]['AcrClient']['organization_name'])){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}else{
							$invoiceData[$key] = null;
						}
					}
				}
			}else{
					foreach($invoiceDetails as $key => $invoiceDetail){
						if($invoiceData[$key]['AcrClient']['organization_name']){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}
					}
			}
			
		}else{
			
			$invoiceData   = $this->AcrClientInvoice->getInvoicesGroupByClient($this->subscriber);
			$invoiceDetails = $this->AcrInvoiceDetail->detailGroupedByClient($this->subscriber);
			
			foreach($invoiceDetails as $key => $invoiceDetail){
				$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
				$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
			}
		}
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode = $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
		$date_format    = $settings['SbsSubscriberSetting']['date_format'];
		
		/*Dynamic Sorting */
		$sortingOrder = "ASC";
		if($defaultSortBy){
			if($defaultSortBy =="ASC"){
				$sortingOrder = "DESC";
			}else{
				$sortingOrder = "ASC";
			}
			
		}
		switch($sortBy){
			case "Customer Name": $invoiceData = Set::sort($invoiceData,'{n}.AcrClient.organization_name',$sortingOrder);
								  break;
			case "No Invoices": $invoiceData = Set::sort($invoiceData,'{n}.AcrClientInvoice.count_id',$sortingOrder);
								  break;
			case "No Item Sold": $invoiceData = Set::sort($invoiceData,'{n}.AcrClientInvoice.sold-items',$sortingOrder);
								  break;
			case "Sales": $invoiceData = Set::sort($invoiceData,'{n}.AcrClientInvoice.sum_sub_total',$sortingOrder);
								  break;
			case "Tax": $invoiceData = Set::sort($invoiceData,'{n}.AcrClientInvoice.sum_tax_total',$sortingOrder);
								  break;
			case "Total Sales": $invoiceData = Set::sort($invoiceData,'{n}.AcrClientInvoice.sum_func_currency_total',$sortingOrder);
								  break;
		}
		/*Dynamic Sorting Ends */
	
		$customerList = $this->AcrClient->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber),'fields'=>array('AcrClient.id','AcrClient.organization_name')));
		foreach($customerList as $customerID1=>$customerOrganization){
			$listCustomer[$customerOrganization] = $customerOrganization;
		}
		
		
		$toDate   = date('Y-m-d', strtotime($toDate));
		$fromDate = date('Y-m-d', strtotime($fromDate));
		$this->set(compact('listCustomer','invoiceData','invoiceDetail','subscriberCurrencyCode','sortingOrder','date_format','data','toDate','fromDate'));
	}

	public function salesExcel($ex_excel = null, $organizationName = null, $filterAction = null, $min = null, $max = null,$fromDate = null,$toDate = null){
		if($ex_excel == 'ex_excel'){
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrClient');
		if($organizationName != "null"){
			$data['sales']['orgName'] = $organizationName;
		}
		if($filterAction != "null"){
			$data['sales']['filterAction'] = $filterAction;
		}
		if($min){
			$data['sales']['min'] = $min;
		}
		if($max){
			$data['sales']['max'] = $max;
		}if($toDate){
			$data['sales']['toDate'] = str_replace('/', '-',$toDate);
		}
		if($fromDate){
			$data['sales']['fromDate'] = str_replace('/', '-',$fromDate);
		}
		if($this->data['sales']){
			$data['sales'] = $this->data['sales'];
		}
		if($data['sales']['toDate']){
			$toDate = str_replace('/', '-',$data['sales']['toDate']);
		}else{
			$toDate = date('Y-m-d');
			//$toDate = '2014-10-30';
		}if($data['sales']['fromDate']){
			$fromDate = str_replace('/', '-',$data['sales']['fromDate']);
		}else{
			$fromDate = date('Y-m-01');
			//$fromDate	=	'2014-10-01';
		}
		$subscriberId = $this->subscriber;
		if($data['sales']){
			if($data['sales']['orgName']){
				$organizationName = $data['sales']['orgName'];
				$toDate = $data['sales']['toDate'];
				switch($data['sales']['filterAction']){
					case "no_item_sold" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%');
										$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																				
																				
																				
																			 ),
														'group' => array(
															'AcrClientInvoice.acr_client_id'
														)
										);
										
										$filterAction = "no_item_sold";
										break;
					case "no_of_invoice" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.count_id BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "no_of_invoice";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																					
																				)
														
																			
																			
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min'].' AND count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
																		  
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					case "sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.sum_sub_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "sales";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),  
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),  
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					case "tax" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.sum_tax_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "tax";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					case "total_sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.sum_func_currency_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "total_sales";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					default		:      	$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%');	
										$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																			 			'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																			 			'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														'group' => array(
															'AcrClientInvoice.acr_client_id'
														)
										);		
										break;		
			}		
			}elseif($data['sales']['filterAction']){
				switch($data['sales']['filterAction']){
					case "no_item_sold" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber);
										$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														'group' => array(
															'acr_client_id'
														)
										);
										$filterAction = "no_item_sold";
										break;
					case "no_of_invoice" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.count_id BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min'].' AND count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
																		  
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										
										$filterAction = "no_of_invoice";
										
										break;
					case "sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_sub_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										$filterAction = "sales";
										break;
					case "tax" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_tax_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										$filterAction = "tax";
										break;
					case "total_sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_func_currency_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime($data['sales']['toDate']))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										$filterAction = "total_sales";
										break;
				}
			}else{
				$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_func_currency_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
				$options = array(
					'fields' => array(
								'AcrClientInvoice.acr_client_id',
								'AcrClient.organization_name',
								'AcrClientInvoice.count_id',
								'AcrClientInvoice.sum_sub_total',
								'AcrClientInvoice.sum_tax_total',
								'AcrClientInvoice.sum_func_currency_total',
								'AcrClientInvoice.status',
								'AcrClientInvoice.invoiced_date'
								),
					'conditions' => array(
										'AND'=>array(
													array(
													'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
													'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$fromDate))),date('Y-m-d',strtotime(str_replace('/','-',$toDate)))),
													'AcrClientInvoice.status !=' =>'Canceled','AcrClientInvoice.recurring'=>'N'
													),
													array(
													'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
													'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$fromDate))),date('Y-m-d',strtotime(str_replace('/','-',$toDate)))),
													'AcrClientInvoice.status !=' =>'Draft','AcrClientInvoice.recurring'=>'N'
													)
												),
										
										
									),
					'group' => array(
									'AcrClientInvoice.acr_client_id'
							   ),
				);
			}
			if(!$organizationName){$organizationName = "null";}
			if(!$filterAction){$filterAction = "null";}
			$min = $data['sales']['min'];
			$max = $data['sales']['max'];
			if(!$min){$min = 0;}
			if(!$max){$max = 0;}
			if($data['sales']['toDate']){$toDate = $data['sales']['toDate'];}
			else{
				$toDate = date('Y-m-d');
			}
			$this->set(compact('organizationName','filterAction','min','max','toDate','fromDate'));
		}
		if($conditions){
			
			$invoiceData   = $this->AcrClientInvoice->getInvoicesGroupByClient($this->subscriber,$options);
			$invoiceDetails = $this->AcrInvoiceDetail->detailGroupedByClient($this->subscriber,$fromDate,$toDate);
			if($data['sales']['filterAction'] == "no_item_sold"){
				
				if(($data['sales']['min']) && ($data['sales']['max'])){
					foreach($invoiceDetails as $key => $invoiceDetail){
						if(($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] >= $data['sales']['min']) && ($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] <= $data['sales']['max']) && ($invoiceData[$key]['AcrClient']['organization_name'])){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}else{
							$invoiceData[$key] = null;
						}
					}
				}elseif(($data['sales']['min']) && (!$data['sales']['max'])){
					foreach($invoiceDetails as $key => $invoiceDetail){
						if(($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] >= $data['sales']['min'])&& ($invoiceData[$key]['AcrClient']['organization_name'])){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}else{
							$invoiceData[$key] = null;
						}
					}
				}elseif((!$data['sales']['min']) && ($data['sales']['max'])){
					foreach($invoiceDetails as $key => $invoiceDetail){
						if(($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] <= $data['sales']['max']) && ($invoiceData[$key]['AcrClient']['organization_name'])){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}else{
							$invoiceData[$key] = null;
						}
					}
				}
			}else{
					foreach($invoiceDetails as $key => $invoiceDetail){
						if($invoiceData[$key]['AcrClient']['organization_name']){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}
					}
			}
			
		}else{
			
			$invoiceData   = $this->AcrClientInvoice->getInvoicesGroupByClient($this->subscriber);
			$invoiceDetails = $this->AcrInvoiceDetail->detailGroupedByClient($this->subscriber);
			
			foreach($invoiceDetails as $key => $invoiceDetail){
				$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
				$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
			}
		}
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode = $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
		$date_format    = $settings['SbsSubscriberSetting']['date_format'];
		$this->set(compact('invoiceData','invoiceDetail','subscriberCurrencyCode','sortingOrder','date_format','data','toDate','fromDate'));		
		}		
		$this->set(compact('invoiceData','invoiceDetail','subscriberCurrencyCode','sortingOrder','date_format','data','toDate','fromDate'));
	}

	public function salesPdf($ex_excel = null, $organizationName = null, $filterAction = null, $min = null, $max = null,$fromDate = null,$toDate = null){
		
		$this->layout = '/pdf/default';
		if($ex_excel == 'ex_pdf'){
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrClient');
		
		$this->LoadModel('SbsSubscriber');
		$this->LoadModel('SbsSubscriberOrganizationDetail');
		if($organizationName != "null"){
			$data['sales']['orgName'] = $organizationName;
		}
		if($filterAction != "null"){
			$data['sales']['filterAction'] = $filterAction;
		}
		if($min){
			$data['sales']['min'] = $min;
		}
		if($max){
			$data['sales']['max'] = $max;
		}if($toDate){
			$data['sales']['toDate'] = str_replace('/', '-',$toDate);
		}
		if($fromDate){
			$data['sales']['fromDate'] = str_replace('/', '-',$fromDate);
		}
		if($this->data['sales']){
			$data['sales'] = $this->data['sales'];
		}
		if($data['sales']['toDate']){
			$toDate = str_replace('/', '-',$data['sales']['toDate']);
		}else{
			$toDate = date('Y-m-d');
			//$toDate = '2014-10-30';
		}if($data['sales']['fromDate']){
			$fromDate = str_replace('/', '-',$data['sales']['fromDate']);
		}else{
			$fromDate = date('Y-m-01');
			//$fromDate	=	'2014-10-01';
		}
		$subscriberId = $this->subscriber;
		if($data['sales']){
			if($data['sales']['orgName']){
				$organizationName = $data['sales']['orgName'];
				$toDate = $data['sales']['toDate'];
				switch($data['sales']['filterAction']){
					case "no_item_sold" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%');
										$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																				
																				
																				
																			 ),
														'group' => array(
															'AcrClientInvoice.acr_client_id'
														)
										);
										
										$filterAction = "no_item_sold";
										break;
					case "no_of_invoice" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.count_id BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "no_of_invoice";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																					
																				)
														
																			
																			
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min'].' AND count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
																		  
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					case "sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.sum_sub_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "sales";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),  
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
														
																			
																	 		),  
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					case "tax" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.sum_tax_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "tax";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																	 					'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					case "total_sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%','AcrClientInvoice.sum_func_currency_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										$filterAction = "total_sales";
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										break;
					default		:      	$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%');	
										$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																			 			'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClient.organization_name like'=>'%'.trim($data['sales']['orgName']).'%',
																			 			'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														'group' => array(
															'AcrClientInvoice.acr_client_id'
														)
										);		
										break;		
			}		
			}elseif($data['sales']['filterAction']){
				switch($data['sales']['filterAction']){
					case "no_item_sold" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber);
										$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
														'group' => array(
															'acr_client_id'
														)
										);
										$filterAction = "no_item_sold";
										break;
					case "no_of_invoice" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.count_id BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min'].' AND count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
																		  
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		), 
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING count(`AcrClientInvoice`.`id`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime($data['sales']['toDate']))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										
										$filterAction = "no_of_invoice";
										
										break;
					case "sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_sub_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`sub_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										$filterAction = "sales";
										break;
					case "tax" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_tax_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`tax_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										$filterAction = "tax";
										break;
					case "total_sales" : 
										$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_func_currency_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
										
										if($data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min'].' AND sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}elseif($data['sales']['min'] && !$data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) >='.$data['sales']['min']
																			),
														);
										}elseif(!$data['sales']['min'] && $data['sales']['max']){
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id HAVING sum(`AcrClientInvoice`.`func_currency_total`) <='.$data['sales']['max']
																			),
														);
										}else{
											$options = array(
														'fields' => array(
																			'AcrClientInvoice.acr_client_id',
																			'AcrClient.organization_name',
																			'AcrClientInvoice.count_id',
																			'AcrClientInvoice.sum_sub_total',
																			'AcrClientInvoice.sum_tax_total',
																			'AcrClientInvoice.sum_func_currency_total',
																		  ),
														'conditions' => array(
																				'AND'=>array(
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Draft','AcrClientInvoice.recurring'=>'N'
																					),
																					array(
																						'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
																						'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['fromDate']))),date('Y-m-d',strtotime(str_replace('/','-',$data['sales']['toDate'])))),
																						'AcrClientInvoice.status !='	=> 'Canceled','AcrClientInvoice.recurring'=>'N'
																					)
																				)
																	 		),
															'group' => array(
																				'AcrClientInvoice.acr_client_id'
																			),
														);
										}
										$filterAction = "total_sales";
										break;
				}
			}else{
				$conditions = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.sum_func_currency_total BETWEEN ? AND ?'=>array($data['sales']['min'],$data['sales']['max']));
				$options = array(
					'fields' => array(
								'AcrClientInvoice.acr_client_id',
								'AcrClient.organization_name',
								'AcrClientInvoice.count_id',
								'AcrClientInvoice.sum_sub_total',
								'AcrClientInvoice.sum_tax_total',
								'AcrClientInvoice.sum_func_currency_total',
								'AcrClientInvoice.status',
								'AcrClientInvoice.invoiced_date'
								),
					'conditions' => array(
										'AND'=>array(
													array(
													'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
													'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$fromDate))),date('Y-m-d',strtotime(str_replace('/','-',$toDate)))),
													'AcrClientInvoice.status !=' =>'Canceled','AcrClientInvoice.recurring'=>'N'
													),
													array(
													'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
													'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array(date('Y-m-d',strtotime(str_replace('/','-',$fromDate))),date('Y-m-d',strtotime(str_replace('/','-',$toDate)))),
													'AcrClientInvoice.status !=' =>'Draft','AcrClientInvoice.recurring'=>'N'
													)
												),
										
										
									),
					'group' => array(
									'AcrClientInvoice.acr_client_id'
							   ),
				);
			}
			if(!$organizationName){$organizationName = "null";}
			if(!$filterAction){$filterAction = "null";}
			$min = $data['sales']['min'];
			$max = $data['sales']['max'];
			if(!$min){$min = 0;}
			if(!$max){$max = 0;}
			if($data['sales']['toDate']){$toDate = $data['sales']['toDate'];}
			else{
				$toDate = date('Y-m-d');
			}
			$this->set(compact('organizationName','filterAction','min','max','toDate','fromDate'));
		}
		if($conditions){
			
			$invoiceData   = $this->AcrClientInvoice->getInvoicesGroupByClient($this->subscriber,$options);
			$invoiceDetails = $this->AcrInvoiceDetail->detailGroupedByClient($this->subscriber,$fromDate,$toDate);
			if($data['sales']['filterAction'] == "no_item_sold"){
				
				if(($data['sales']['min']) && ($data['sales']['max'])){
					foreach($invoiceDetails as $key => $invoiceDetail){
						if(($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] >= $data['sales']['min']) && ($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] <= $data['sales']['max']) && ($invoiceData[$key]['AcrClient']['organization_name'])){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}else{
							$invoiceData[$key] = null;
						}
					}
				}elseif(($data['sales']['min']) && (!$data['sales']['max'])){
					foreach($invoiceDetails as $key => $invoiceDetail){
						if(($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] >= $data['sales']['min'])&& ($invoiceData[$key]['AcrClient']['organization_name'])){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}else{
							$invoiceData[$key] = null;
						}
					}
				}elseif((!$data['sales']['min']) && ($data['sales']['max'])){
					foreach($invoiceDetails as $key => $invoiceDetail){
						if(($invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'] <= $data['sales']['max']) && ($invoiceData[$key]['AcrClient']['organization_name'])){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}else{
							$invoiceData[$key] = null;
						}
					}
				}
			}else{
					foreach($invoiceDetails as $key => $invoiceDetail){
						if($invoiceData[$key]['AcrClient']['organization_name']){
							$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
							$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
						}
					}
			}
			
		}else{
			
			$invoiceData   = $this->AcrClientInvoice->getInvoicesGroupByClient($this->subscriber);
			$invoiceDetails = $this->AcrInvoiceDetail->detailGroupedByClient($this->subscriber);
			
			foreach($invoiceDetails as $key => $invoiceDetail){
				$invoiceData[$key]['AcrClientInvoice']['sold-items']	=	$invoiceDetail['AcrInvoiceDetail']['count_invoice_detail_id'];
				$invoiceData[$key]['AcrClient']['organization_name']	=	ucwords($invoiceData[$key]['AcrClient']['organization_name']);
			}
		}
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode = $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
		$date_format    = $settings['SbsSubscriberSetting']['date_format'];
					
		}
		
		$sbsOrgId			    = $this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($this->subscriber);
		$sbsOrgNameArr 			= $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($sbsOrgId);
		$sbsOrgName 			= $sbsOrgNameArr['SbsSubscriberOrganizationDetail']['organization_name'];	
		$this->set(compact('invoiceData','invoiceDetail','subscriberCurrencyCode','sortingOrder','date_format','data','toDate','sbsOrgName'));
		$this->render('/Pdf/sales_pdf');
	}	


	public function itemSalesReport($sortBy = null,$defaultSortBy = null,$itemName = null,$filterAction = null,$min = null,$max = null,$fromDate = null,$toDate = null){
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Item Sales Report';
		$this->set(compact('menuActive','permission')); 
		
		$this->set(compact('reportsActive','menuActive'));
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('InvInventory');
		if($fromDate){
			$fromDate = str_replace('/', '-',$fromDate);
		}else{
			$fromDate = date('Y-m-01');
		}
		if($toDate){
			$toDate = str_replace('/', '-',$toDate);
		}else{
			$toDate   = date('Y-m-d');
		}
		if($this->data['item-sale']['fromDate']){
				$fromDate = date('Y-m-d',strtotime(str_replace('/', '-',$this->data['item-sale']['fromDate'])));
		}
		if($this->data['item-sale']['toDate']){
			$toDate = date('Y-m-d',strtotime(str_replace('/', '-',$this->data['item-sale']['toDate'])));
		}
		if($this->data['item-sale']){
			$data['item-sale']	=	$this->data['item-sale'];
			
		}
		if($itemName && ($itemName != "null")){
			$data['item-sale']['item-name']	= 	$itemName;
		}
		if($filterAction && ($filterAction != "null")){
			$data['item-sale']['filterAction']	= 	$filterAction;
			if($min){
				$data['item-sale']['item-name']	= 	$itemName;
			}
			if($max){
				$data['item-sale']['item-name']	= 	$itemName;
			}
		}
		if($data['item-sale']['item-name']){$itemName = $data['item-sale']['item-name'];}
		if($this->data['item-sale']['filterAction']){
				$filterAction = $data['item-sale']['filterAction'];
				if($data['item-sale']['min']){$min = $data['item-sale']['min'];}
				if($data['item-sale']['max']){$max = $data['item-sale']['max'];}
				if($data['item-sale']['fromDate']){$fromDate = date('Y-m-d',strtotime(str_replace('/', '-',$data['item-sale']['fromDate'])));}
				if($data['item-sale']['toDate']){$toDate = date('Y-m-d',strtotime(str_replace('/', '-',$data['item-sale']['toDate'])));}
		}

		if($itemName && ($itemName != "null")){
			$conditions = array(
								'AND'=>array(
									array(
										'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
										'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array($fromDate,$toDate),
										'InvInventory.name like'=>'%'.trim($itemName).'%',
										'AcrClientInvoice.status !='=> 'Canceled','AcrClientInvoice.recurring'=>'N'
									),
									array(
										'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
										'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array($fromDate,$toDate),
										'InvInventory.name like'=>'%'.trim($itemName).'%',
										'AcrClientInvoice.status !='=> 'Draft','AcrClientInvoice.recurring'=>'N'
									)
								)
							
						);
		}else{
			$conditions = array(
								'AND'=>array(
									array(
										'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
										'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array($fromDate,$toDate),
										'AcrClientInvoice.status !='=> 'Canceled','AcrClientInvoice.recurring'=>'N'
									),
									array(
										'AcrClientInvoice.sbs_subscriber_id' => $this->subscriber,
										'AcrClientInvoice.invoiced_date BETWEEN ? and ?'  =>	array($fromDate,$toDate),
										'AcrClientInvoice.status !='=> 'Draft','AcrClientInvoice.recurring'=>'N'
									)
								)
							
						);
		}
		if($filterAction && ($filterAction != "null")){
			switch($filterAction){
					case "item-sold" : 
										if($min && $max){
												 $groupBy	=	array(
										    					'AcrInvoiceDetail.inv_inventory_id HAVING sum(`AcrInvoiceDetail.quantity`) >='.$min.' AND sum(`AcrInvoiceDetail.quantity`) <='.$max
															);
										}elseif(!$min && $max){
												 $groupBy	=	array(
										    					'AcrInvoiceDetail.inv_inventory_id HAVING sum(`AcrInvoiceDetail.quantity`) <='.$max
															);
										}elseif($min && !$max){
												 $groupBy	=	array(
										    					'AcrInvoiceDetail.inv_inventory_id HAVING sum(`AcrInvoiceDetail.quantity`) >='.$min
															);
										}else{
												$this->Session->setFlash('<div class="alert alert-danger"> Please Enter Correct Min Max Value.</div>');
												$groupBy	=	array(
																	'AcrInvoiceDetail.inv_inventory_id'
																);
										}
										break;
					case "Amount"	 :
										if($min && $max){
												 $groupBy	=	array(
										    					'AcrInvoiceDetail.inv_inventory_id HAVING sum(`AcrInvoiceDetail.quantity` * `AcrInvoiceDetail.unit_rate`) >='.$min.' AND sum(`AcrInvoiceDetail.quantity` * `AcrInvoiceDetail.unit_rate`) <='.$max
															);
										}elseif(!$min && $max){
												 $groupBy	=	array(
										    					'AcrInvoiceDetail.inv_inventory_id HAVING sum(`AcrInvoiceDetail.quantity` * `AcrInvoiceDetail.unit_rate`) <='.$max
															);
										}elseif($min && !$max){
												 $groupBy	=	array(
										    					'AcrInvoiceDetail.inv_inventory_id HAVING sum(`AcrInvoiceDetail.quantity` * `AcrInvoiceDetail.unit_rate`) >='.$min
															);
										}else{
												$this->Session->setFlash('<div class="alert alert-danger"> Please Enter Correct Min Max Value.</div>');
												$groupBy	=	array(
																	'AcrInvoiceDetail.inv_inventory_id'
																);
										}
						
										break;
					case "avgSale"	 :
										if($min && $max){
												 $groupBy	=	array(
										    					'AcrInvoiceDetail.inv_inventory_id HAVING (sum(`AcrInvoiceDetail.quantity` * `AcrInvoiceDetail.unit_rate )'.')/'.'sum(`AcrInvoiceDetail.quantity`) >='.$min.' AND (sum(`AcrInvoiceDetail.quantity` * `AcrInvoiceDetail.unit_rate ))/sum(`AcrInvoiceDetail.quantity`) <='.$max
															);
										}elseif(!$min && $max){
												 $groupBy	=	array(
										    					'AcrInvoiceDetail.inv_inventory_id HAVING (sum(`AcrInvoiceDetail.quantity` * `AcrInvoiceDetail.unit_rate )'.')/'.'sum(`AcrInvoiceDetail.quantity`) <='.$max
															);
										}elseif($min && !$max){
												 $groupBy	=	array(
										    					'AcrInvoiceDetail.inv_inventory_id HAVING (sum(`AcrInvoiceDetail.quantity` * `AcrInvoiceDetail.unit_rate )'.')/'.'sum(`AcrInvoiceDetail.quantity`) >='.$min
															);
										}else{
												$this->Session->setFlash('<div class="alert alert-danger"> Please Enter Correct Min Max Value.</div>');
												$groupBy	=	array(
																	'AcrInvoiceDetail.inv_inventory_id'
																);
										}
										break;
			}
		}else{
			$groupBy	=	array(
								'AcrInvoiceDetail.inv_inventory_id'
							);
		}
		$options = array(
					'fields' => array(
								'InvInventory.name',
								'AcrInvoiceDetail.inventory_description',
								'AcrInvoiceDetail.sum_quantity',
								'AcrInvoiceDetail.sum_line_total',
								'AcrInvoiceDetail.price_prod',
								'AcrInvoiceDetail.avg_price'
					),
					'conditions' => $conditions,
					'group' 	 => $groupBy,
					'order'		 => array('InvInventory.name ASC')
				);
		$itemDetails 				= $this->AcrInvoiceDetail->getDetailGroupedByItem($options);
		foreach($itemDetails as $key=>$val){
			if($val['InvInventory']['name']){
				$itemData[$key]['Inventory Name'] 			= $val['InvInventory']['name'];
			}else{
				$itemData[$key]['Inventory Name'] 			= "Non Inventory Items";
			}
			$itemData[$key]['Inventory Description'] 	= $val['AcrInvoiceDetail']['inventory_description'];
			$itemData[$key]['# Item'] 		  			= $val['AcrInvoiceDetail']['sum_quantity'];
			$itemData[$key]['Amount'] 		  			= $val['AcrInvoiceDetail']['price_prod'] ;
			$itemData[$key]['Average Price'] 		    = $val['AcrInvoiceDetail']['avg_price'] ;
			$totalSoldItems								= $totalSoldItems + $itemData[$key]['# Item'];
			$totalAmount								= $totalAmount + $itemData[$key]['Amount'];
			$totalAveragePrice							= $totalAveragePrice + $itemData[$key]['Average Price'];
		}
		$total['Total Sold Item']						=	$totalSoldItems;
		$total['Total Amount']							=	$totalAmount;
		$total['Total Average Price']					=	$totalAveragePrice;
		$settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
		$date_format    			= $settings['SbsSubscriberSetting']['date_format'];
		$finalInventoryList = $this->InvInventory->find('list',array('conditions'=>array('InvInventory.sbs_subscriber_id'=>$this->subscriber),'order'=>array('InvInventory.name ASC'),'fields'=>array('InvInventory.id','InvInventory.name')));	
		foreach($finalInventoryList as $inventoryId=>$inventoryName){
			$soldItem[$inventoryName] = $inventoryName  ;
		}
		/*Dynamic Sorting */
		$sortingOrder = "ASC";
		if(!$sortBy){
			$sortBy = "Item Name";
		}
		if($defaultSortBy){
			if($defaultSortBy =="ASC"){
				$sortingOrder = "DESC";
			}else{
				$sortingOrder = "ASC";
			}
			
		}
		switch($sortBy){
			case "Item Name": $itemData = Set::sort($itemData,'{n}.Inventory Name',$sortingOrder);
								  break;
			case "# Items": $itemData = Set::sort($itemData,'{n}.# Item',$sortingOrder);
								  break;
			case "Amount": $itemData = Set::sort($itemData,'{n}.Amount',$sortingOrder);
								  break;
			case "Average Price": $itemData = Set::sort($itemData,'{n}.Average Price',$sortingOrder);
								  break;
			
		}
		/*Dynamic Sorting Ends */
		if(!$itemName){$itemName = "null";}
			if(!$filterAction){$filterAction = "null";}
			
			if(!$min){$min = 0;}
			if(!$max){$max = 0;}
			$this->set(compact('itemName','filterAction','min','max','toDate','fromDate','soldItem'));
		
		$this->set(compact('date_format','subscriberCurrencyCode','itemData','total','sortingOrder','sortBy'));
		$returnArray = array('itemData'=>Set::sort($itemData,'{n}.Inventory Name','ASC'),'columnTotal'=>$total);
		return $returnArray;
	}

	public function itemSalesExcel($excel = null,$sortBy = null,$defaultSortBy = null,$itemName = null,$filterAction = null,$min = null,$max = null,$fromDate = null,$toDate = null){
		if($excel == "ex_excel"){
			$getData = $this->itemSalesReport($sortBy,$defaultSortBy,$itemName,$filterAction,$min,$max,$fromDate,$toDate);
			$excelData = $getData['itemData'];
			$totalData = $getData['columnTotal'];
			$settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
			$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
			$this->set(compact('excelData','totalData','subscriberCurrencyCode'));
		}
		
	}
	public function itemSalesPdf($excel = null,$sortBy = null,$defaultSortBy = null,$itemName = null,$filterAction = null,$min = null,$max = null,$fromDate = null,$toDate = null){
		if($excel == "ex_pdf"){
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('CpnCurrency');
			$this->loadModel('SbsSubscriber');
			$this->loadModel('SbsSubscriberOrganizationDetail');
			$this->loadModel('SbsSubscriberSetting');
			$getData   = $this->itemSalesReport($sortBy,$defaultSortBy,$itemName,$filterAction,$min,$max,$fromDate,$toDate);
			$excelData = $getData['itemData'];
			$totalData = $getData['columnTotal'];
			$settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
			$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
			$date_format    			= $settings['SbsSubscriberSetting']['date_format'];
			$sbsOrgId			    	= $this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($this->subscriber);
			$sbsOrgNameArr 				= $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($sbsOrgId);
			$organizationName 			= $sbsOrgNameArr['SbsSubscriberOrganizationDetail']['organization_name'];
			$toDate 					= date($date_format,strtotime($toDate));
			$fromDate 					= date($date_format,strtotime($fromDate));	
			$todayDate 					= date($date_format,strtotime(date('Y-m-d')));
			$this->set(compact('excelData','totalData','fromDate','toDate','date_format','subscriberCurrencyCode','organizationName','todayDate'));
			$this->render('/Pdf/item_sales_pdf');
		}
	}

	public function agingReport($sortBy = null,$defaultSortBy = null,$bucketValuePass = null,$customerName = null,$bucketFilter = null,$min=null,$max=null){
		
        $permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Aging Report';
		$this->set(compact('menuActive','permission')); 

		$this->loadModel('SbsAgingBucket');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('AcrInvoicePaymentDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrClient');
		$fromDate = date('Y-m-01');
		$toDate   = date('Y-m-d');
		
		if($this->data['aging']['age-past'] || $bucketFilter ){
			if(!$bucketFilter){
				$bucketFilter = $this->data['aging']['age-past'];
				if($bucketFilter == "total"){
					$min = $this->data['aging']['min'];
					$max = $this->data['aging']['max'];
					$this->set(compact('min','max'));
				}
			}
			/*$conditions = array('SbsAgingBucket.id'=>$bucketFilter,'SbsAgingBucket.sbs_subscriber_id'=>$this->subscriber);*/
			$conditions = array('SbsAgingBucket.sbs_subscriber_id'=>$this->subscriber);
			$this->set(compact('bucketFilter'));
		}else{
			$bucketFilter = null;
			$conditions = array('SbsAgingBucket.sbs_subscriber_id'=>$this->subscriber);
			$this->set(compact('bucketFilter'));
		}
		
		if($this->data['aging']['customer-name'] || $customerName){
			if(!$customerName){
				$customerName = $this->data['aging']['customer-name'];
			}
			if($customerName=="null"){
				$customerName = '';
			}
			$this->set(compact('customerName'));
		}
		$buckets  = $this->SbsAgingBucket->getBucketsForSubscriber($this->subscriber,$conditions);
		if(empty($buckets)){
			$buckets = array(
							(int) 0 => array(
										'SbsAgingBucket' => array(
															'id' => '73',
															'bucket' => '0-30 days',
															'from_day' => '0',
															'to_day' => '30',
															'sbs_subscriber_id' => '54'
															)
											),
							(int) 1 => array(
										'SbsAgingBucket' => array(
															'id' => '74',
															'bucket' => '31-60 days',
															'from_day' => '31',
															'to_day' => '60',
															'sbs_subscriber_id' => '54'
														)
										),
							(int) 2 => array(
										'SbsAgingBucket' => array(
																'id' => '75',
																'bucket' => '61-90 days',
																'from_day' => '61',
																'to_day' => '100',
																'sbs_subscriber_id' => '54'
															)
										),
							(int) 3 => array(
										'SbsAgingBucket' => array(
																'id' => '76',
																'bucket' => '90+ days',
																'from_day' => '91',
																'to_day' => '',
																'sbs_subscriber_id' => '54'
										)
							)
			);
		}
		if($buckets){
			foreach($buckets as $bucket){
				$startDate = date('Y-m-d', strtotime('-'.$bucket['SbsAgingBucket']['from_day'].' days', strtotime($toDate)));
				if($bucket['SbsAgingBucket']['to_day']){
					$endDate   = date('Y-m-d', strtotime('-'.$bucket['SbsAgingBucket']['to_day'].' days', strtotime($toDate)));
				}else{
					$endDate = null;
				}
				if($customerName){
					if($bucketFilter){
						$invoices[$bucket['SbsAgingBucket']['bucket']]  = $this->AcrClientInvoice->getAgingInvoices($this->subscriber,$bucket['SbsAgingBucket']['bucket'],$startDate,$endDate,$customerName);
					}else{
						$invoices[$bucket['SbsAgingBucket']['bucket']]  = $this->AcrClientInvoice->getAgingInvoices($this->subscriber,$bucket['SbsAgingBucket']['bucket'],$startDate,$endDate,$customerName);	
					}
				}else{
					$invoices[$bucket['SbsAgingBucket']['bucket']]  = $this->AcrClientInvoice->getAgingInvoices($this->subscriber,$bucket['SbsAgingBucket']['bucket'],$startDate,$endDate);
					
				}
				$bucketList[$bucket['SbsAgingBucket']['id']] 	= $bucket['SbsAgingBucket']['bucket'];
				
			}
			$numberOfBuckets = count($bucketList);
			foreach($invoices as $bucketName => $InvoiceDetails){
				foreach($InvoiceDetails as $key=>$val){
					$clientPayment = $this->AcrInvoicePaymentDetail->getClientLastPayment($this->subscriber,$val['AcrClientInvoice']['acr_client_id']);
					$agingArray[$val['AcrClientInvoice']['acr_client_id']]['organizationName']	=	$val['AcrClient']['organization_name'];
					$agingArray[$val['AcrClientInvoice']['acr_client_id']]['lastPaymentDate']	=	$clientPayment['AcrInvoicePaymentDetail']['payment_date'];
					$agingArray[$val['AcrClientInvoice']['acr_client_id']]['Paid']				=	$clientPayment['AcrInvoicePaymentDetail']['paid_amount'];
					$agingArray[$val['AcrClientInvoice']['acr_client_id']][$bucketName]			=	$agingArray[$val['AcrClientInvoice']['acr_client_id']][$bucketName] + $val['AcrClientInvoice']['func_currency_total'];
					$agingArray[$val['AcrClientInvoice']['acr_client_id']]['rowTotal']			=	$agingArray[$val['AcrClientInvoice']['acr_client_id']]['rowTotal'] + $val['AcrClientInvoice']['func_currency_total'];
			
				}
			}
			if($bucketFilter =="total"){
				if($min == "null"){$min = '';}
				if($max == "null"){$max = '';}
				foreach($agingArray as $clientId => $indexVal){
					if($min && $max){
						 if($indexVal['rowTotal']<=$min || $indexVal['rowTotal']>=$max){
						 	$agingArray[$clientId] = null;
						 }
					}elseif($min && !$max){
						if($indexVal['rowTotal']<=$min){
						 	$agingArray[$clientId] = null;
							$max = "null";
						 }	
					}elseif($max && !$min){
						if($indexVal['rowTotal']>=$max){
						 	$agingArray[$clientId] = null;
							$min = "null";
						 }
					}
				}
				
				$this->set(compact('min','max'));
			}
			else{
							if($bucketFilter !="total" && ($bucketFilter)){
								foreach($agingArray as $clientId => $valueIndex){
									if($valueIndex[$bucketList[$bucketFilter]] <= 0){
										$agingArray[$clientId] = null;
									}
								}
							}
						}
			
		}
		/*Dynamic Sorting */
		$sortingOrder = "ASC";
		if(!$sortBy){
			$sortBy = "Customer Name";
		}
		if($defaultSortBy){
			if($defaultSortBy =="ASC"){
				$sortingOrder = "DESC";
			}else{
				$sortingOrder = "ASC";
			}
			
		}
		switch($sortBy){
			case "Customer Name": $agingArray = Set::sort($agingArray,'{n}.organizationName',$sortingOrder);
								  break;
			case "Last Payment Date": $agingArray = Set::sort($agingArray,'{n}.lastPaymentDate',$sortingOrder);
								  break;
			case "Last Payment Amount": $agingArray = Set::sort($agingArray,'{n}.Paid',$sortingOrder);
								  break;
			case "Bucket": 		$agingArray = Set::sort($agingArray,'{n}.'.$bucketValuePass,$sortingOrder);
								break;
			case "Total":		$agingArray = Set::sort($agingArray,'{n}.rowTotal',$sortingOrder);
								break;
			
			
		}
		/*Dynamic Sorting Ends */
		$settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
		$date_format    			= $settings['SbsSubscriberSetting']['date_format'];
		if(!$customerName){
			$customerName = "null";
			$this->set(compact('customerName'));
		}
		$customerList = $this->AcrClient->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber),'fields'=>array('AcrClient.id','AcrClient.organization_name')));
		foreach($customerList as $customerID1=>$customerOrganization){
			$listCustomer[$customerOrganization] = $customerOrganization;
		}
		$this->set(compact('agingArray','bucketList','total','subscriberCurrencyCode','date_format','sortingOrder','sortBy','fromDate','toDate','listCustomer'));
		
		$returnArray = array('itemData'=>Set::sort($agingArray,'{n}.organizationName','ASC'),'columnTotal'=>$total,'bucketList'=>$bucketList,'dateFormat'=>$date_format);
		return $returnArray;
	}

	public function agingPdf($excel = null,$sortBy = null,$defaultSortBy = null,$bucketValuePass = null,$customerName = null,$bucketFilter = null,$min=null,$max=null){
		
		if($excel == "ex_pdf"){
			$fromDate = date('Y-m-01');
			$toDate   = date('Y-m-d');
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('CpnCurrency');
			$this->loadModel('SbsSubscriber');
			$this->loadModel('SbsSubscriberOrganizationDetail');
			$this->loadModel('SbsSubscriberSetting');
			$getData = $this->agingReport($sortBy,$defaultSortBy,$bucketValuePass,$customerName,$bucketFilter,$min,$max);
			$excelData 	= $getData['itemData'];
			//$totalData 	= $getData['columnTotal'];
			$bucketList = $getData['bucketList'];
			foreach($excelData as $key=>$val){
				$i = 0;
				foreach($bucketList as $bucketKey=>$bucketValue){
					$i++;
					$bucketAmount[$key][$i] = $val[$bucketValue];
					$totalColumn[$i] += $val[$bucketValue];
					$finalTotal += $totalColumn[$i];
				}
				
			}
			
			$settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
			$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
			$date_format    			= $settings['SbsSubscriberSetting']['date_format'];
			$sbsOrgId			    	= $this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($this->subscriber);
			$sbsOrgNameArr 				= $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($sbsOrgId);
			$organizationName 			= $sbsOrgNameArr['SbsSubscriberOrganizationDetail']['organization_name'];
			$toDate 					= date($date_format,strtotime(str_replace('/','-',$toDate)));
			$fromDate 					= date($date_format,strtotime(str_replace('/','-',$fromDate)));	
			$todayDate 					= date($date_format,strtotime(date('Y-m-d')));
			$this->set(compact('finalTotal','totalColumn','bucketAmount','excelData','totalData','fromDate','toDate','date_format','subscriberCurrencyCode','organizationName','todayDate'));
			$this->set(compact('bucketList'));
			$this->render('/Pdf/aging_report_pdf');
		}
	}
	public function agingExcel($excel = null,$sortBy = null,$defaultSortBy = null,$bucketValuePass = null,$customerName = null,$bucketFilter = null,$min=null,$max=null){
		if($excel == "ex_excel"){
			$getData = $this->agingReport($sortBy,$defaultSortBy,$bucketValuePass,$customerName,$bucketFilter,$min,$max);
			$excelData 	= $getData['itemData'];
			$totalData 	= $getData['columnTotal'];
			$bucketList = $getData['bucketList'];
			$dateFormat	= $getData['dateFormat'];
			$settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
			$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
			$this->set(compact('excelData','totalData','bucketList','dateFormat','subscriberCurrencyCode'));
		}
	}
	
	public function expenseSummaryReport($sortBy = null,$defaultSortBy = null ,$data_customer_name =null ,$data_status =null ,$data_category_id =null ,$data_min_amount =null ,$data_max_amount=null){
	 
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Expense Summary Report';
		$this->set(compact('menuActive','permission')); 
	 
	 
	 
		$this->LoadModel('AcpExpense');
		$this->LoadModel('AcrClient');
		$this->LoadModel('AcpExpenseCategory');
		$this->LoadModel('SbsSubscriberSetting');
		$this->LoadModel('CpnCurrency');
		
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
	    $date_format    = $settings['SbsSubscriberSetting']['date_format'];	
		
	    
		
		$this->AcpExpense->recursive = 0;
		$this->AcpExpense->unbindModel(array('belongsTo'=>array('SbsSubscriber','AcpVendor')));
		  
		$sortingOrder = "ASC";
       
        $organizations =  $this->AcrClient->find('list', array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber),
		  'order'=>array('AcrClient.id' => 'DESC'),
		  'fields'=>array('AcrClient.id','AcrClient.organization_name')));  
 
		$expense_status_list = array('Billable'=>'Billable','Billed'=>'Billed','Non Billable'=>'Non Billable'); 
        $expense_categories = $this->AcpExpenseCategory->find('list',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber),'fields'=>array('id','category_name'),'order'=>'category_name ASC'));
       
        if($data_customer_name == 'null')
		{
			$data_customer_name = null;
		}
		if($data_status == 'null')
		{
			$data_status = null;
		}
		if($data_category_id == 'null')
		{
			$data_category_id = null;
		}
		if($data_min_amount == 'null')
		{
			$data_min_amount = null;
		}
		if($data_max_amount == 'null')
		{
			$data_max_amount = null;
		}
		
        
        if($data_customer_name){
             $this->request->data['expense_summary_report']['customer_name'] 		= $data_customer_name;	
        }
        if($data_status){
        	 $this->request->data['expense_summary_report']['expense_status'] 		= $data_status;	
        }
        if($data_category_id){
        	 $this->request->data['expense_summary_report']['expense_category_id']  = $data_category_id;
        }
        if($data_min_amount){
        	 $this->request->data['expense_summary_report']['min_amount']  = $data_min_amount;
        }
         if($data_max_amount){
        	 $this->request->data['expense_summary_report']['max_amount']  = $data_max_amount;
        }
            
        
       if(!empty($this->data['expense_summary_report']['customer_name'])){
       	
       } 
       
       
       if(($this->data['expense_summary_report']['customer_name'])||($this->data['expense_summary_report']['expense_status'])||($this->data['expense_summary_report']['expense_category_id'])||($this->data['expense_summary_report']['min_amount'])||($this->data['expense_summary_report']['min_amount'])||($this->request->data['expense_summary_report']['fromDate'])||($this->request->data['expense_summary_report']['toDate'])){
      	    $cust_name = $category_name = $exp_data= $min_amount = $max_amount = $start_date = $end_date = null;
            if(!empty($this->data['expense_summary_report']['customer_name'])){
             	 $customer_name = trim($this->data['expense_summary_report']['customer_name']);
                 $cust_name = array("AcrClient.id"=>$customer_name);
            }	
           
            if(!empty($this->data['expense_summary_report']['expense_status'])){
           	 	$exp_data= array("AcpExpense.status"=>$this->data['expense_summary_report']['expense_status']);
            }
           
            if(!empty($this->data['expense_summary_report']['expense_category_id'])){
           	    $category_name= array("AcpExpense.acp_expense_category_id"=>$this->data['expense_summary_report']['expense_category_id']);
            } 
           
            if(!empty($this->data['expense_summary_report']['min_amount'])){
           	    $min_amount= array("AcpExpense.amount >="=>trim($this->data['expense_summary_report']['min_amount']));
            }  
           
            if(!empty($this->data['expense_summary_report']['max_amount'])){
           	    $max_amount= array("AcpExpense.amount <="=>trim($this->data['expense_summary_report']['max_amount']));
            }
           
            if(!empty($this->request->data['expense_summary_report']['fromDate']))
			 $fromDate       = trim($this->request->data['expense_summary_report']['fromDate']);
			if($fromDate)   $fromDate	  = date('Y-m-d', strtotime(str_replace('/','-',$fromDate)));	
			
			if(!empty($this->request->data['expense_summary_report']['toDate']))
			 $toDate       = trim($this->request->data['expense_summary_report']['toDate']);
			if($toDate)   $toDate	  = date('Y-m-d', strtotime(str_replace('/','-',$toDate)));	
           
           
           
            if(!empty($this->data['expense_summary_report']['fromDate'])){
           		$start_date= array("AcpExpense.date >="=>$fromDate);
            }
           
            if(!empty($this->data['expense_summary_report']['toDate'])){
           		$end_date= array("AcpExpense.date <="=>$toDate);
            }
          
          
          
            $data_status        = (empty($this->data['expense_summary_report']['expense_status'])) ? 'null' : $this->data['expense_summary_report']['expense_status']; 
            $data_customer_name = (empty($this->data['expense_summary_report']['customer_name'])) ? 'null' : $this->data['expense_summary_report']['customer_name'];
            $data_category_id   = (empty($this->data['expense_summary_report']['expense_category_id'])) ? 'null' : $this->data['expense_summary_report']['expense_category_id'];
            $data_min_amount    = (empty($this->data['expense_summary_report']['min_amount'])) ? 'null' : $this->data['expense_summary_report']['min_amount']; 
            $data_max_amount    = (empty($this->data['expense_summary_report']['max_amount'])) ? 'null' : $this->data['expense_summary_report']['max_amount']; 
            $data_from_date     = (empty($this->data['expense_summary_report']['fromDate'])) ? 'null' : date('Y-m-d', strtotime(str_replace('/','-',$this->data['expense_summary_report']['fromDate']))); 
            $data_to_date       = (empty($this->data['expense_summary_report']['toDate'])) ? 'null' : date('Y-m-d', strtotime(str_replace('/','-',$this->data['expense_summary_report']['toDate'])));  
           
           
            $this->set(compact('data_status','data_customer_name','data_category_id','data_status','data_min_amount','data_max_amount','data_from_date','data_to_date'));
            $expense_summary = $this->AcpExpense->find('all',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber,$cust_name,$exp_data,$category_name,$min_amount,$max_amount,$start_date,$end_date),'fields'=>array('AcpExpense.acp_expense_category_id','AcpExpense.amount','AcpExpense.tax_total','AcpExpense.sub_total','AcpExpense.status','AcpExpense.date','AcpExpense.expense_no','AcrClient.organization_name','AcpExpenseCategory.category_name')));
 
		}else{
			$defaultfromDate = date('Y-m-d', strtotime(str_replace('/','-',date($date_format,strtotime(date('Y-m-01'))))));	
		    $defaulttoDate   = date('Y-m-d', strtotime(str_replace('/','-',date($date_format,strtotime(date('Y-m-d'))))));	
		    $this->AcpExpense->recursive = 0;
		    $expense_summary = $this->AcpExpense->find('all',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber,'AcpExpense.date between ? and ?'=>array($defaultfromDate,$defaulttoDate)),'fields'=>array('AcpExpense.amount','AcpExpense.tax_total','AcpExpense.sub_total','AcpExpense.status','AcpExpense.date','AcpExpense.expense_no','AcrClient.organization_name','AcpExpenseCategory.category_name','AcpExpense.date')));
	  } 
	 
		
		foreach($expense_summary as $key=>$value){
	     		$expenseReport[$key]['status']         = $value['AcpExpense']['status'];
				$expenseReport[$key]['expense_date']   = $value['AcpExpense']['date'];
				$expenseReport[$key]['ref_no']         = $value['AcpExpense']['expense_no'];
				$expenseReport[$key]['customer_name']  = $value['AcrClient']['organization_name'];
				$expenseReport[$key]['category']       = $value['AcpExpenseCategory']['category_name'];
				$expenseReport[$key]['expense_amount'] = $value['AcpExpense']['sub_total'];
				$expenseReport[$key]['tax_amount']     = $value['AcpExpense']['tax_total'];
				$expenseReport[$key]['expense_amount_incl_tax'] = $value['AcpExpense']['amount'];
				$total_amount += $value['AcpExpense']['amount'];
		} 
		
		
		 
         if(!$sortBy){
		   	 $sortBy ='Customer Name';
		 } 
		 
		 if($defaultSortBy){
				if($defaultSortBy =="ASC"){
					$sortingOrder = "DESC";
				}else{
					$sortingOrder = "ASC";
				}
		  }
		
		 switch($sortBy){
			case "Customer Name": $expenseReport = Set::sort($expenseReport,'{n}.customer_name',$sortingOrder);
								  break;
			case "Status": $expenseReport = Set::sort($expenseReport,'{n}.status',$sortingOrder);
								  break;
			case "Expense_Date": $expenseReport = Set::sort($expenseReport,'{n}.expense_date',$sortingOrder);
								  break;
			case "Ref_No": 		$expenseReport = Set::sort($expenseReport,'{n}.ref_no',$sortingOrder);
								break;
			case "Category":		$expenseReport = Set::sort($expenseReport,'{n}.category',$sortingOrder);
								break;
			case "Expense_Amount":		$expenseReport = Set::sort($expenseReport,'{n}.expense_amount',$sortingOrder);
								break;
			case "Tax_Amount":		$expenseReport = Set::sort($expenseReport,'{n}.tax_amount',$sortingOrder);
								break;
			case "Expense_Amount_Incltax":		$expenseReport = Set::sort($expenseReport,'{n}.expense_amount_incl_tax',$sortingOrder);
								break;										
			
		}
		
		
	    $subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
	    $subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
    
		$this->set(compact('subscriberCurrencyCode','date_format','data_max_amount','data_min_amount','data_status','data_category_id','data_customer_name','organizations','sortBy','expenseReport','sortingOrder','subscriberCurrencyCode','expense_status_list','expense_categories','date_format','total_amount'));
    }
 
  public function expenseExcel($sortBy=null,$defaultSortBy=null,$data_customer_name=null,$data_status=null,$data_category_id=null,$data_min_amount=null,$data_max_amount=null,$data_from_date=null,$data_to_date=null){
  	   
        $this->LoadModel('AcpExpense');
		$this->LoadModel('AcrClient');
		$this->LoadModel('AcpExpenseCategory');
		$this->LoadModel('SbsSubscriberSetting');
		$this->LoadModel('CpnCurrency');
    
       
        $settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
    
    
        $this->AcpExpense->recursive = 0;
		$this->AcpExpense->unbindModel(array('belongsTo'=>array('SbsSubscriber','AcpVendor')));
		  
		$sortingOrder = "ASC";
      
       if($data_status=='null'){
           $data_status =null;
       }
       if($data_category_id=='null'){
           $data_category_id =null;
       }
       if($data_min_amount=='null'){
           $data_min_amount =null;
       }
       if($data_max_amount=='null'){
           $data_max_amount =null;
       }
       if($data_from_date=='null'){
           $data_from_date =null;
       }
       if($data_to_date=='null'){
           $data_to_date =null;
       }
        
       
            $complex_query =null;
            if(!empty($data_customer_name)&&($data_customer_name!='null')){
            	 $cust_name = array("AcrClient.id"=>$data_customer_name);
             	 $complex_query ='1';
            }	
           
            if(!empty($data_status)){
             	$exp_data= array("AcpExpense.status"=>$data_status);
           	 	$complex_query ='1';
            }
           
            if(!empty($data_category_id)){
           	    $category_name= array("AcpExpense.acp_expense_category_id"=>$data_category_id);
           	    $complex_query ='1';
            } 
           
            if(!empty($data_min_amount)){
           	    $min_amount= array("AcpExpense.amount >="=>trim($data_min_amount));
           	    $complex_query ='1';
            }  
           
            if(!empty($data_max_amount)){
           	    $max_amount= array("AcpExpense.amount <="=>trim($data_max_amount));
           	    $complex_query ='1';
            }
           
            if(!empty($data_from_date)){
           		$start_date= array("AcpExpense.date >="=>$data_from_date);
           		$complex_query ='1';
            }
           
            if(!empty($data_to_date)){
           		$end_date= array("AcpExpense.date <="=>$data_to_date);
           		$complex_query ='1';
            }
         
           
       if($complex_query){     
             $expense_summary = $this->AcpExpense->find('all',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber,$cust_name,$exp_data,$category_name,$min_amount,$max_amount,$start_date,$end_date),'fields'=>array('AcpExpense.acp_expense_category_id','AcpExpense.amount','AcpExpense.tax_total','AcpExpense.sub_total','AcpExpense.status','AcpExpense.date','AcpExpense.expense_no','AcrClient.organization_name','AcpExpenseCategory.category_name')));
		}else{
       	     $expense_summary = $this->AcpExpense->find('all',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber),'fields'=>array('AcpExpense.amount','AcpExpense.tax_total','AcpExpense.sub_total','AcpExpense.status','AcpExpense.date','AcpExpense.expense_no','AcrClient.organization_name','AcpExpenseCategory.category_name')));
	   }  
	 
        foreach($expense_summary as $key=>$value){
	     		$expenseReport[$key]['status']         = $value['AcpExpense']['status'];
				$expenseReport[$key]['expense_date']   = $value['AcpExpense']['date'];
				$expenseReport[$key]['ref_no']         = $value['AcpExpense']['expense_no'];
				$expenseReport[$key]['customer_name']  = $value['AcrClient']['organization_name'];
				$expenseReport[$key]['category']       = $value['AcpExpenseCategory']['category_name'];
				$expenseReport[$key]['expense_amount'] = $value['AcpExpense']['sub_total'];
				$expenseReport[$key]['tax_amount']     = $value['AcpExpense']['tax_total'];
				$expenseReport[$key]['expense_amount_incl_tax'] = $value['AcpExpense']['amount'];
				$total_amount += $value['AcpExpense']['amount'];
		 } 
          
         if(!$sortBy){
		   	 $sortBy ='Customer Name';
		  } 
		
		 if($defaultSortBy){
				if($defaultSortBy =="ASC"){
					$sortingOrder = "DESC";
				}else{
					$sortingOrder = "ASC";
				}
		  }
		
		 switch($sortBy){
			case "Customer Name": $expenseReport = Set::sort($expenseReport,'{n}.customer_name',$sortingOrder);
								  break;
			case "Status": $expenseReport = Set::sort($expenseReport,'{n}.status',$sortingOrder);
								  break;
			case "Expense_Date": $expenseReport = Set::sort($expenseReport,'{n}.expense_date',$sortingOrder);
								  break;
			case "Ref_No": 		$expenseReport = Set::sort($expenseReport,'{n}.ref_no',$sortingOrder);
								break;
			case "Category":		$expenseReport = Set::sort($expenseReport,'{n}.category',$sortingOrder);
								break;
			case "Expense_Amount":		$expenseReport = Set::sort($expenseReport,'{n}.expense_amount',$sortingOrder);
								break;
			case "Tax_Amount":		$expenseReport = Set::sort($expenseReport,'{n}.tax_amount',$sortingOrder);
								break;
			case "Expense_Amount_Incltax":		$expenseReport = Set::sort($expenseReport,'{n}.expense_amount_incl_tax',$sortingOrder);
								break;										
		}
	 
	 $this->set(compact('expenseReport','total_amount','subscriberCurrencyCode'));
	 return($expenseReport); 
  }
  
  
  Public function expensePdf($sortBy=null,$defaultSortBy=null,$data_customer_name=null,$data_status=null,$data_category_id=null,$data_min_amount=null,$data_max_amount=null,$data_from_date=null,$data_to_date=null){
    
    $this->LoadModel('SbsSubscriberSetting');
    $this->LoadModel('CpnCurrency');
    $this->LoadModel('SbsSubscriber');
    $this->LoadModel('SbsSubscriberOrganizationDetail');
  
  
  
     if($data_status=='null'){
           $data_status =null;
       }
       if($data_category_id=='null'){
           $data_category_id =null;
       }
       if($data_min_amount=='null'){
           $data_min_amount =null;
       }
       if($data_max_amount=='null'){
           $data_max_amount =null;
       }
       if($data_from_date=='null'){
           $data_from_date =null;
       }
       if($data_to_date=='null'){
           $data_to_date =null;
       }
  
    
    $toDate    = date('Y-m-d');
    
    $settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
	$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
	$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
	 
	$date_format    			= $settings['SbsSubscriberSetting']['date_format'];
    $todayDate 					= date($date_format,strtotime(date('Y-m-d')));
    $sbsOrgId			    	= $this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($this->subscriber);
	$sbsOrgNameArr 				= $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($sbsOrgId);
	$organizationName 			= $sbsOrgNameArr['SbsSubscriberOrganizationDetail']['organization_name'];
  	$report_details = $this->expenseExcel($sortBy,$defaultSortBy,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount,$data_from_date,$data_to_date);
    
  	$this->set(compact('subscriberCurrencyCode','report_details','toDate','organizationName','todayDate'));
  	$this->render('/Pdf/expense_summary_report_pdf');
  	
  }

 public function tax_summary($group_type=null,$from_date=null,$to_date=null,$export=null){
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Tax Summary';
		$this->set(compact('menuActive','permission')); 
		
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberTax');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('AcpInventoryExpense');
		$this->loadModel('SbsSubscriberTaxGroupMapping');
		
		$this->AcpInventoryExpense->recursive = 0;
		$this->AcrInvoiceDetail->Behaviors->attach('Containable');
		
		if($group_type){
			$this->request->data['TaxReport']['groupType'] = $group_type;
		}elseif($from_date && $to_date){
			$this->request->data['TaxReport']['fromDate'] = $from_date;
			$this->request->data['TaxReport']['toDate']   = $to_date;
		}
		
		
		if($this->data){
			if(empty($this->data['TaxReport']['groupType']) && $this->data['TaxReport']['fromDate'] && $this->data['TaxReport']['toDate']){
					
				$invoicedetail = $this->AcrInvoiceDetail->find('all',array('conditions'=>array('NOT'=>array('AcrClientInvoice.status'=>array('Canceled','Draft')),'AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.invoiced_date between ? and ?'=>array($this->data['TaxReport']['fromDate'],$this->data['TaxReport']['toDate'])),'fields'=>array('AcrInvoiceDetail.id','AcrInvoiceDetail.line_total','AcrClientInvoice.sbs_subscriber_id','AcrInvoiceDetail.sbs_subscriber_tax_group_id','AcrInvoiceDetail.sbs_subscriber_tax_id'),'contain'=>array('SbsSubscriberTax.code','SbsSubscriberTax.name','SbsSubscriberTax.percent','AcrClientInvoice.sbs_subscriber_id','AcrClientInvoice.invoiced_date','AcrClientInvoice.status')));
				$expensedetail = $this->AcpInventoryExpense->find('all',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$this->subscriber,'AcpExpense.date between ? and ?'=>array($this->data['TaxReport']['fromDate'],$this->data['TaxReport']['toDate'])),'fields'=>array('AcpInventoryExpense.sbs_subscriber_tax_id','AcpInventoryExpense.sbs_subscriber_tax_group_id','AcpExpense.sub_total','AcpExpense.tax_total','AcpExpense.date')));
				
				$fromDate = $this->data['TaxReport']['fromDate'];
				$toDate   = $this->data['TaxReport']['toDate'];
				$this->set(compact('fromDate','toDate'));
				
				
			}elseif(($this->data['TaxReport']['groupType']) && $this->data['TaxReport']['fromDate'] && $this->data['TaxReport']['toDate']){
				
				if($this->data['TaxReport']['groupType'] == 'Sales'){
					  $invoicedetail = $this->AcrInvoiceDetail->find('all',array('conditions'=>array('NOT'=>array('AcrClientInvoice.status'=>array('Canceled','Draft')),'AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.invoiced_date between ? and ?'=>array($this->data['TaxReport']['fromDate'],$this->data['TaxReport']['toDate'])),'fields'=>array('AcrInvoiceDetail.id','AcrInvoiceDetail.line_total','AcrClientInvoice.sbs_subscriber_id','AcrInvoiceDetail.sbs_subscriber_tax_group_id','AcrInvoiceDetail.sbs_subscriber_tax_id'),'contain'=>array('SbsSubscriberTax.code','SbsSubscriberTax.name','SbsSubscriberTax.percent','AcrClientInvoice.sbs_subscriber_id','AcrClientInvoice.invoiced_date','AcrClientInvoice.status')));
				}else{
					 $expensedetail = $this->AcpInventoryExpense->find('all',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$this->subscriber,'AcpExpense.date between ? and ?'=>array($this->data['TaxReport']['fromDate'],$this->data['TaxReport']['toDate'])),'fields'=>array('AcpInventoryExpense.sbs_subscriber_tax_id','AcpInventoryExpense.sbs_subscriber_tax_group_id','AcpExpense.sub_total','AcpExpense.tax_total','AcpExpense.date')));
			    }	
                
				$groupType = $this->data['TaxReport']['groupType'];
                $fromDate  = $this->data['TaxReport']['fromDate'];
				$toDate    = $this->data['TaxReport']['toDate'];
				$this->set(compact('fromDate','toDate','groupType'));
			
           }elseif(($this->data['TaxReport']['groupType']) && empty($this->data['TaxReport']['fromDate']) && empty($this->data['TaxReport']['toDate'])){
				
				$fromDate = date('Y').'-01'.'-01';
			    $toDate = date('Y-m-d');
				
				if($this->data['TaxReport']['groupType'] == 'Sales'){
					  $invoicedetail = $this->AcrInvoiceDetail->find('all',array('conditions'=>array('NOT'=>array('AcrClientInvoice.status'=>array('Canceled','Draft')),'AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.invoiced_date between ? and ?'=>array($fromDate,$toDate)),'fields'=>array('AcrInvoiceDetail.id','AcrInvoiceDetail.line_total','AcrClientInvoice.sbs_subscriber_id','AcrInvoiceDetail.sbs_subscriber_tax_group_id','AcrInvoiceDetail.sbs_subscriber_tax_id'),'contain'=>array('SbsSubscriberTax.code','SbsSubscriberTax.name','SbsSubscriberTax.percent','AcrClientInvoice.sbs_subscriber_id','AcrClientInvoice.invoiced_date','AcrClientInvoice.status')));
				}else{
					 $expensedetail = $this->AcpInventoryExpense->find('all',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$this->subscriber,'AcpExpense.date between ? and ?'=>array($fromDate,$toDate)),'fields'=>array('AcpInventoryExpense.sbs_subscriber_tax_id','AcpInventoryExpense.sbs_subscriber_tax_group_id','AcpExpense.sub_total','AcpExpense.tax_total','AcpExpense.date')));
			    }	
                
				$groupType = $this->data['TaxReport']['groupType'];
                $fromDate  = $this->data['TaxReport']['fromDate'];
				$toDate    = $this->data['TaxReport']['toDate'];
				$this->set(compact('fromDate','toDate','groupType'));
			}
			
		}else{
			 $fromDate = date('Y').'-01'.'-01';
			 $toDate = date('Y-m-d');
			 	
			 $invoicedetail = $this->AcrInvoiceDetail->find('all',array('conditions'=>array('NOT'=>array('AcrClientInvoice.status'=>array('Canceled','Draft')),'AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.invoiced_date between ? and ?'=>array($fromDate,$toDate)),'fields'=>array('AcrInvoiceDetail.id','AcrInvoiceDetail.line_total','AcrClientInvoice.sbs_subscriber_id','AcrInvoiceDetail.sbs_subscriber_tax_group_id','AcrInvoiceDetail.sbs_subscriber_tax_id'),'contain'=>array('SbsSubscriberTax.code','SbsSubscriberTax.name','SbsSubscriberTax.percent','AcrClientInvoice.sbs_subscriber_id','AcrClientInvoice.invoiced_date','AcrClientInvoice.status')));
			 $expensedetail = $this->AcpInventoryExpense->find('all',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$this->subscriber,'AcpExpense.date between ? and ?'=>array($fromDate,$toDate)),'fields'=>array('AcpInventoryExpense.sbs_subscriber_tax_id','AcpInventoryExpense.sbs_subscriber_tax_group_id','AcpExpense.sub_total','AcpExpense.tax_total','AcpExpense.date')));
		}	
        
		foreach($invoicedetail as $key=>$val){
			if($val['SbsSubscriberTax']['id']){
				$getValue  = $this->calculateTaxAmount($val['AcrInvoiceDetail']['line_total'],$val['SbsSubscriberTax']['percent']);
				$tax['Sales'][$val['SbsSubscriberTax']['id']]['name']    =  $val['SbsSubscriberTax']['name'];
				$tax['Sales'][$val['SbsSubscriberTax']['id']]['code']    =  $val['SbsSubscriberTax']['code'];
				$tax['Sales'][$val['SbsSubscriberTax']['id']]['percent'] =  $val['SbsSubscriberTax']['percent'];
				$tax['Sales'][$val['SbsSubscriberTax']['id']]['amount']  =	$tax['Sales'][$val['SbsSubscriberTax']['id']]['amount'] + $getValue;
			}elseif($val['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']){
				$groupDetail = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($val['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']);
				$newLineTotal = $val['AcrInvoiceDetail']['line_total'];
				foreach($groupDetail as $groupKey=>$groupVal){
					if($groupVal['SbsSubscriberTaxGroupMapping']['compounded']=='Y'){
						$getValue = $this->calculateTaxAmount($newLineTotal,$groupVal['SbsSubscriberTax']['percent']);
						$tax['Sales'][$groupVal['SbsSubscriberTax']['id']]['name']    = $groupVal['SbsSubscriberTax']['name'];
						$tax['Sales'][$groupVal['SbsSubscriberTax']['id']]['code']    = $groupVal['SbsSubscriberTax']['code'];
						$tax['Sales'][$groupVal['SbsSubscriberTax']['id']]['percent'] = $groupVal['SbsSubscriberTax']['percent'];
						$tax['Sales'][$groupVal['SbsSubscriberTax']['id']]['amount']  =	$tax['Sales'][$groupVal['SbsSubscriberTax']['id']]['amount'] + $getValue;
					}else{
						$getValue  = $this->calculateTaxAmount($val['AcrInvoiceDetail']['line_total'],$groupVal['SbsSubscriberTax']['percent']);
						$tax['Sales'][$groupVal['SbsSubscriberTax']['id']]['name']    = $groupVal['SbsSubscriberTax']['name'];
						$tax['Sales'][$groupVal['SbsSubscriberTax']['id']]['code']    = $groupVal['SbsSubscriberTax']['code'];
						$tax['Sales'][$groupVal['SbsSubscriberTax']['id']]['percent'] = $groupVal['SbsSubscriberTax']['percent'];
						$tax['Sales'][$groupVal['SbsSubscriberTax']['id']]['amount']  =	$tax['Sales'][$groupVal['SbsSubscriberTax']['id']]['amount'] + $getValue;
						$newLineTotal = $newLineTotal + $getValue;
					}
				}
			}
		}
		
		
		foreach($expensedetail as $key=>$val){
			$taxDetail = $this->SbsSubscriberTax->getTaxById($val['AcpInventoryExpense']['sbs_subscriber_tax_id']);	
			
			if($val['AcpInventoryExpense']['sbs_subscriber_tax_id']){
				$tax1['Expenses'][$val['AcpInventoryExpense']['sbs_subscriber_tax_id']]['name']   = $taxDetail['SbsSubscriberTax']['name'];
				$tax1['Expenses'][$val['AcpInventoryExpense']['sbs_subscriber_tax_id']]['code']   = $taxDetail['SbsSubscriberTax']['code'];
				$tax1['Expenses'][$val['AcpInventoryExpense']['sbs_subscriber_tax_id']]['percent']= $taxDetail['SbsSubscriberTax']['percent'];
				$tax1['Expenses'][$val['AcpInventoryExpense']['sbs_subscriber_tax_id']]['amount'] =	$tax1['Expenses'][$val['AcpInventoryExpense']['sbs_subscriber_tax_id']]['amount'] + $val['AcpExpense']['tax_total'];
			}elseif($val['AcpInventoryExpense']['sbs_subscriber_tax_group_id']){
				$groupDetail = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($val['AcpInventoryExpense']['sbs_subscriber_tax_group_id']);
				$newLineTotal = $val['AcpExpense']['sub_total'];
				foreach($groupDetail as $groupKey=>$groupVal){
					if($groupVal['SbsSubscriberTaxGroupMapping']['compounded']=='Y'){
						$getValue = $this->calculateTaxAmount($newLineTotal,$groupVal['SbsSubscriberTax']['percent']);
						$tax1['Expenses'][$groupVal['SbsSubscriberTax']['id']]['name']    = $groupVal['SbsSubscriberTax']['name'];
						$tax1['Expenses'][$groupVal['SbsSubscriberTax']['id']]['code']    = $groupVal['SbsSubscriberTax']['code'];
						$tax1['Expenses'][$groupVal['SbsSubscriberTax']['id']]['percent'] = $groupVal['SbsSubscriberTax']['percent'];
						$tax1['Expenses'][$groupVal['SbsSubscriberTax']['id']]['amount']  =	$tax1['Expenses'][$groupVal['SbsSubscriberTax']['id']]['amount'] + $getValue;
					}else{
						$getValue  = $this->calculateTaxAmount($val['AcpExpense']['sub_total'],$groupVal['SbsSubscriberTax']['percent']);
						$tax1['Expenses'][$groupVal['SbsSubscriberTax']['id']]['name']    = $groupVal['SbsSubscriberTax']['name'];
						$tax1['Expenses'][$groupVal['SbsSubscriberTax']['id']]['code']    = $groupVal['SbsSubscriberTax']['code'];
						$tax1['Expenses'][$groupVal['SbsSubscriberTax']['id']]['percent'] = $groupVal['SbsSubscriberTax']['percent'];
						$tax1['Expenses'][$groupVal['SbsSubscriberTax']['id']]['amount']  =	$tax1['Expenses'][$groupVal['SbsSubscriberTax']['id']]['amount'] + $getValue;
						$newLineTotal = $newLineTotal + $getValue;
					}
				}
			}
		}
        
    if($export == 'pdf' || $export == 'excel'){
        
		if($tax && $tax1){
    		$final =array_merge($tax,$tax1);	
			
    	}elseif(!$tax && $tax1){
    		$final =$tax1;	
    	
		}elseif($tax && !$tax1){
    		$final =$tax;	
    	}
    	return $final;
    }else{
    	if($tax && $tax1){
    		$final =array_merge($tax,$tax1);	
			
    	}elseif(!$tax && $tax1){
    		$final =$tax1;	
    	
		}elseif($tax && !$tax1){
    		$final =$tax;	
    	}
    	
    	$this->set(compact('final'));
    }
    
    $settings               = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
	$date_format            = $settings['SbsSubscriberSetting']['date_format'];
	$subscriberCurrencyCode = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
	$this->set(compact('subscriberCurrencyCode','date_format'));
	}
	public function calculateTaxAmount($lineTotal = null,$percentage = null){
		$value = ($lineTotal*$percentage)/100;
		return $value;
	}
	
	public function tax_summary_excel($group_type,$from_date,$to_date,$export) {
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberSetting');
		
		$subscriber_id = $this->subscriber;
		$settings 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$subscriberCurrencyCode = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$final = $this->tax_summary($group_type,$from_date,$to_date,$export);	
		$this->set(compact('final','subscriberCurrencyCode'));
	}
	
	public function tax_summary_pdf($group_type,$from_date,$to_date,$export) {
		
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriber');
		$this->SbsSubscriber->Behaviors->attach('Containable');
		
		$subscriber_id = $this->subscriber;
		$settings 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$subscriberCurrencyCode = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$dateFormat	= $settings['SbsSubscriberSetting']['date_format'];
		$subscriber_info = $this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$subscriber_id),'fields'=>array('SbsSubscriber.id','SbsSubscriber.sbs_subscriber_organization_detail_id'),'contain'=>array('SbsSubscriberOrganizationDetail.organization_name')));
		$subscriber_organization = $subscriber_info['SbsSubscriberOrganizationDetail']['organization_name'];
		$this->layout = '/pdf/default';
		$final = $this->tax_summary($group_type,$from_date,$to_date,$export);	
		$this->set(compact('final','from_date','to_date','dateFormat','subscriberCurrencyCode','subscriber_organization'));
		$this->render('/Pdf/tax_summary_pdf');
	}
	
	public function invoiceDetailReport($data_customer_name=null,$data_status=null,$data_from_date=null,$data_to_date=null,$return=null){
	    $permission = $this->permission;
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Invoice Detail Report';
		$this->set(compact('menuActive','permission')); 
	    
	    
		$this->set(compact('reportsActive','menuActive'));
		$this->LoadModel('AcrClientInvoice');
		$this->LoadModel('AcrClient');
		$this->LoadModel('AcrInvoiceDetail');
		$this->LoadModel('SbsSubscriberTax');
		$this->LoadModel('SbsSubscriberTaxGroup');
	    $this->LoadModel('AcrInvoicePaymentDetail');
	    $this->LoadModel('CpnCurrency');
	    $this->LoadModel('SbsSubscriberSetting');
	    
	    
        $this->AcrClientInvoice->recursive = 1;
		$this->AcrClientInvoice->unbindModel(array('hasMany'=>array('AcrInvoiceCustomValue','AcrClientRecurringInvoice','AcrInvoicePaymentDetail')));
		$this->AcrClientInvoice->unbindModel(array('belongsTo'=>array('SbsSubscriberPaymentTerm','SbsSubscriber')));
		$this->AcrClientInvoice->bindModel(array('hasMany'=>array('AcrInvoiceDetail')));
        
        $date_format = 'Y-m-d';	
        $invoice_status_list = array('Draft'=>'Draft','Sent'=>'Sent','Paid'=>'Paid','Partially Paid'=>'Partially Paid','Canceled'=>'Canceled','Open'=>'Open');
        $organizations =  $this->AcrClient->find('list', array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber),
						  'order'=>array('AcrClient.id' => 'DESC'),
						  'fields'=>array('AcrClient.id','AcrClient.organization_name')));
		
		
		if(($data_customer_name == null)&&($data_status== null)&&($data_from_date== null)&&($data_to_date== null)){
			$return ='0';
		}
		  
		 		         
         if(!empty($this->data)){
         	 
         	$cust_name = $exp_data = $start_date = $end_date = null;
         	if(!empty($this->data['invoice_detail_report']['customer_name'])){
              
                 $cust_name = array("AcrClient.id"=>$this->data['invoice_detail_report']['customer_name']);
            }
            
            if(!empty($this->data['invoice_detail_report']['expense_status'])){
           	 	$exp_data= array("AcrClientInvoice.status"=>$this->data['invoice_detail_report']['expense_status']);
            }
            
            
            if(!empty($this->request->data['invoice_detail_report']['fromDate']))
			 $fromDate       = trim($this->request->data['invoice_detail_report']['fromDate']);
			if($fromDate)   $fromDate	  = date('Y-m-d', strtotime(str_replace('/','-',$fromDate)));	
			
			if(!empty($this->request->data['invoice_detail_report']['toDate']))
			 $toDate       = trim($this->request->data['invoice_detail_report']['toDate']);
			if($toDate)   $toDate	  = date('Y-m-d', strtotime(str_replace('/','-',$toDate)));	
            
           
            if(!empty($this->data['invoice_detail_report']['fromDate'])){
           		$start_date= array("AcrClientInvoice.invoiced_date >="=>$fromDate);
            }
           
            if(!empty($this->data['invoice_detail_report']['toDate'])){
           		$end_date= array("AcrClientInvoice.invoiced_date <="=>$toDate);
            }
            
            
            
            
            
            
            $data_status        = (empty($this->data['invoice_detail_report']['expense_status'])) ? 'null' : $this->data['invoice_detail_report']['expense_status']; 
            $data_customer_name = (empty($this->data['invoice_detail_report']['customer_name'])) ? 'null' : $this->data['invoice_detail_report']['customer_name'];
            $data_from_date     = (empty($this->data['invoice_detail_report']['fromDate'])) ? 'null' : date('Y-m-d', strtotime(str_replace('/','-',$this->data['invoice_detail_report']['fromDate']))); 
            $data_to_date       = (empty($this->data['invoice_detail_report']['toDate'])) ? 'null' : date('Y-m-d', strtotime(str_replace('/','-',$this->data['invoice_detail_report']['toDate'])));  
            
           
             
            
           $this->set(compact('data_status','data_customer_name','data_from_date','data_to_date'));
           $client_invoice = $this->AcrClientInvoice->find('all',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.recurring'=>'N',$cust_name,$exp_data,$start_date,$end_date)));
         }elseif($return){
         	  
	         	$cust_name = $exp_data = $start_date = $end_date = null;
			 	if($data_customer_name!='null'){
			 		 $customer_name = trim($data_customer_name);
	                 $cust_name = array("AcrClient.id"=>$data_customer_name);
			 	}
			 	 
			 	if($data_status!='null'){
			 	    $exp_data= array("AcrClientInvoice.status"=>$data_status);
			 	}
			 	
			 	if($data_from_date!='null'){
			 	    $start_date= array("AcrClientInvoice.invoiced_date >="=>$data_from_date);
			 	}
			 	
			 	if($data_to_date!='null'){
			 	    $end_date= array("AcrClientInvoice.invoiced_date <="=>$data_to_date);
			 	} 
			 	 
		 	 $client_invoice = $this->AcrClientInvoice->find('all',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.recurring'=>'N',$cust_name,$exp_data,$start_date,$end_date)));
         }else{
		   //$client_invoice = $this->AcrClientInvoice->find('all',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber),'limit'=>'5'));
		 }
         
       
         
   
        $j=0;
        foreach($client_invoice as $key=>$value){
			    $j++;
			    
			    $customerCurrency 	  = $this->CpnCurrency->getCurrencyById($value['AcrClient']['cpn_currency_id']);
				$customerCurrencyCode = $customerCurrency['CpnCurrency']['code'];
			    $exchangeRate	=	$value['AcrClientInvoice']['exchange_rate'];
			    $final_invoice[$value['AcrClient']['organization_name']][$j]['invoice_number'] = $value['AcrClientInvoice']['invoice_number'];
		    	$final_invoice[$value['AcrClient']['organization_name']][$j]['invoice_date']   = $value['AcrClientInvoice']['invoiced_date'];
		    	$final_invoice[$value['AcrClient']['organization_name']][$j]['invoice_status'] = $value['AcrClientInvoice']['status'];
		    	$final_invoice[$value['AcrClient']['organization_name']][$j]['currency_code'] = $customerCurrencyCode;
		    	$tax_total  =  $value['AcrClientInvoice']['func_currency_total']- $value['AcrClientInvoice']['sub_total'];
		    	$final_invoice[$value['AcrClient']['organization_name']][$j]['tax_total'] = $tax_total/$exchangeRate;
		    	
		    	foreach($value['AcrInvoiceDetail'] as $k=>$v){
		    		     $find_paidAmount = $this->AcrInvoicePaymentDetail->find('all', array('fields' => array('sum(AcrInvoicePaymentDetail.paid_amount)   AS paid_amount'), 'conditions'=>array('AcrInvoicePaymentDetail.acr_client_invoice_id'=>$value['AcrClientInvoice']['id'],'AcrInvoicePaymentDetail.is_deleted'=>'no')));
		    		   
			            $tax_code =null;
		    	       if(!empty($v['sbs_subscriber_tax_id'])){
		    	       		$tax_details = $this->SbsSubscriberTax->find('first',array('conditions'=>array('SbsSubscriberTax.id'=>$v['sbs_subscriber_tax_id']),'fields'=>array('code','percent')));
		    	        	$tax_code = $tax_details['SbsSubscriberTax']['code'].$tax_details['SbsSubscriberTax']['percent'];
		    	       }else{
		    	       	    $tax_details = $this->SbsSubscriberTaxGroup->find('first',array('conditions'=>array('SbsSubscriberTaxGroup.id'=>$v['sbs_subscriber_tax_group_id']),'fields'=>array('group_name')));
		    	       	    $tax_code =$tax_details['SbsSubscriberTaxGroup']['group_name'];
		    	       }
		    	        $final_invoice[$value['AcrClient']['organization_name']][$j]['invoice_details'][$k]['item_description'] = $v['inventory_description'];
		    	        $final_invoice[$value['AcrClient']['organization_name']][$j]['invoice_details'][$k]['tax_code']  = $tax_code; 	
		    	        $final_invoice[$value['AcrClient']['organization_name']][$j]['invoice_details'][$k]['unit_cost'] =  $v['unit_rate']/$exchangeRate;
		    		    $final_invoice[$value['AcrClient']['organization_name']][$j]['invoice_details'][$k]['quantity']  =  $v['quantity'];
		    		    $final_invoice[$value['AcrClient']['organization_name']][$j]['invoice_details'][$k]['discount']  =  $v['discount_percent'];
		    		    $final_invoice[$value['AcrClient']['organization_name']][$j]['invoice_details'][$k]['amount']    =  $v['line_total']/$value['AcrClientInvoice']['exchange_rate'];
		    		    $final_invoice[$value['AcrClient']['organization_name']][$j]['invoice_details'][$k]['paid_amount'] = $find_paidAmount['0']['0']['paid_amount'];
		    	
		    	}
		    
		  }
	
	    
	    $settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$date_format    = $settings['SbsSubscriberSetting']['date_format'];	
	   
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode = $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
	 
	 	$this->set(compact('final_invoice','organizations','invoice_status_list','date_format','subscriberCurrencyCode'));
		return $final_invoice;
		 
	}
	
	public function invoiceExcel($data_customer_name=null,$data_status=null,$data_from_date=null,$data_to_date=null){
		$this->LoadModel('invoiceDetailReport');
		$this->LoadModel('SbsSubscriberSetting');
		$this->LoadModel('CpnCurrency');
		
		$return ='1';
		$invoice_Report = $this->invoiceDetailReport($data_customer_name,$data_status,$data_from_date,$data_to_date,$return);
		
		$settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
		
		$this->set(compact('invoice_Report','subscriberCurrencyCode'));
	}
	
	 
	
	public function invoicedetailPdf($data_customer_name=null,$data_status=null,$data_from_date=null,$data_to_date=null){
	
		$return ='1';
		$this->LoadModel('SbsSubscriberSetting');
	    $this->LoadModel('CpnCurrency');
	    $this->LoadModel('SbsSubscriber');
	    $this->LoadModel('SbsSubscriberOrganizationDetail');
	   
	    $toDate    = date('Y-m-d');
	    
	    $settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
		$date_format    			= $settings['SbsSubscriberSetting']['date_format'];
	    $todayDate 					= date($date_format,strtotime(date('Y-m-d')));
	    $sbsOrgId			    	= $this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($this->subscriber);
		$sbsOrgNameArr 				= $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($sbsOrgId);
		$organizationName 			= $sbsOrgNameArr['SbsSubscriberOrganizationDetail']['organization_name'];
	  	 
	   
	  	$invoice_Report = $this->invoiceDetailReport($data_customer_name,$data_status,$data_from_date,$data_to_date,$return);
	    $this->set(compact('invoice_Report','toDate','organizationName','todayDate','subscriberCurrencyCode'));
		$this->render('/Pdf/invoice_detail_report_pdf');
	}
	
	public function profitLossReport(){
	     
		
		$dateFinder = new DateTime('now');
        $dateFinder->modify('last day of this month');
        $LastDateofMonth = $dateFinder->format('Y-m-d');
		
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
		   $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$menuActive = 'Profit and Loss Report';
		$this->set(compact('menuActive','permission')); 
		
		$this->LoadModel('AcrInvoiceDetail');
		$this->LoadModel('SbsSubscriberSetting');
		$this->LoadModel('CpnCurrency');
		$this->LoadModel('AcpExpenseCategory');
		$this->LoadModel('AcpExpenseCategory');
		
		
		$periodDropdown  = array('Yearly'=>'Yearly','Quarterly'=>'Quarterly','Monthly'=>'Monthly');
		$revenueTypes    = array('Collected'=>'Collected','Billed'=>'Billed');
		$expenseTax      = array('Include'=>'Include','Exclude'=>'Exclude'); 
		
		
		$settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$date_format                = $settings['SbsSubscriberSetting']['date_format'];	
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
		
		
		
	if($this->data){	
		
		 $expenseCategory =  $this->AcpExpenseCategory->find('list',array('fields'=>array('AcpExpenseCategory.category_name'),'conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)));
		  if($this->data['profit_loss_report']['period'] == 'Monthly'){
		       $periodType = 'Monthly';
		       $revenueType =  $expenseTaxReturn = null;
		       if(!empty($this->data['profit_loss_report']['toDate'])){
		       	   		  $datePassed  = date('Y-m-d', strtotime(str_replace('/','-',$this->data['profit_loss_report']['toDate'])));
				            $explode_year = explode('-',$datePassed);
				            $presentYear = $explode_year['0'];
				           
				         if($presentYear =='1970'){
				            $presentYear121 = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->data['profit_loss_report']['toDate']);
				            $explode_year = explode('-',$presentYear121);
				         	$presentYear = $explode_year['0'];
				         }
		       }else{
		       	   $presentYear = date('Y');
		       }
		       
		       if(!empty($this->data['profit_loss_report']['revenueType'])){
		       	   $revenueType = $this->data['profit_loss_report']['revenueType'];
		       }
		       
		       if(!empty($this->data['profit_loss_report']['expenseTax'])){
		       	   $expenseTaxReturn = $this->data['profit_loss_report']['expenseTax'];
		       }
		       
		       $financialYear = $presentYear;
		      
					 $finalArray=null;
					 for($month=1;$month<=12;$month++){
						 	if($month <=9) $month = '0'.$month;
						    $monthName = date("M", mktime(0, 0, 0, $month, 10)); 
						    $forTheMonth = $presentYear.'-'.$month.'-';
						 	$finalData  = $this->profitLossData($forTheMonth,$revenueType,$expenseTaxReturn);
						    $finalArray['Sales'][$monthName.'-'.substr($presentYear, -2)]         = $finalData['Sales'];
						    $finalArray['GoodsSold'][$monthName.'-'.substr($presentYear, -2)]     = $finalData['GoodsSold'];
						    $finalArray['LessExpenses'][$monthName.'-'.substr($presentYear, -2)]  = $finalData['LessExpenses'];
						    $totalExpenses 														  = array_sum($finalData['LessExpenses']);
						    $finalArray['TotalExpenses'][$monthName.'-'.substr($presentYear, -2)] = $totalExpenses;
						    $finalArray['Total'][$monthName.'-'.substr($presentYear, -2)]         = ($finalData['Sales']-$finalData['GoodsSold']);
						    $finalArray['NetProfit'][$monthName.'-'.substr($presentYear, -2)]     = ($finalData['Sales']-$finalData['GoodsSold']) -$totalExpenses;
						    $year[$monthName.'-'.substr($presentYear, -2)]                        = $monthName.'-'.substr($presentYear, -2);
					 }
					
					
					
				    $expenseCategory =  $this->AcpExpenseCategory->find('list',array('fields'=>array('AcpExpenseCategory.category_name'),'conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)));
		 		 
					$lessexp=null; $check=null;
					foreach($year as $ye1=>$ye2){
						foreach($expenseCategory as $ex1=>$ex2){
							if($finalArray['LessExpenses'][$ye1][$ex1]){ $check[$ex1]=1; $lessexp[$ex1][$ye1]=$finalArray['LessExpenses'][$ye1][$ex1];  }
							else{ $lessexp[$ex1][$ye1]='-'; }
						}
					}
					 
				 	
					$expenseCategory1=$expenseCategory;
					foreach($expenseCategory1 as $ex1=>$ex2){
						if(!$check[$ex1]){unset($lessexp[$ex1]); unset($expenseCategory[$ex1]);}
					}
		  }	 elseif($this->data['profit_loss_report']['period'] == 'Quarterly'){  
		  	        $periodType = 'Quarterly';
		  	       
		  	        $revenueType =  $expenseTaxReturn = null;
				    if(!empty($this->data['profit_loss_report']['toDate'])){
				      	    $datePassed  = date('Y-m-d', strtotime(str_replace('/','-',$this->data['profit_loss_report']['toDate'])));
				            $explode_year = explode('-',$datePassed);
				            $presentYear = $explode_year['0'];
				           
				         if($presentYear =='1970'){
				            $presentYear121 = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->data['profit_loss_report']['toDate']);
				            $explode_year = explode('-',$presentYear121);
				         	$presentYear = $explode_year['0'];
				         }
				    
				    }else{
				           $presentYear = date('Y');
				    }
				       
				    if(!empty($this->data['profit_loss_report']['revenueType'])){
				    	   $revenueType = $this->data['profit_loss_report']['revenueType'];
				    }
				       
				    if(!empty($this->data['profit_loss_report']['expenseTax'])){
				        $expenseTaxReturn = $this->data['profit_loss_report']['expenseTax'];
				    }
				    
				    
				   
					 $financialYear = $presentYear;
		  	
			  	 for($month=1;$month<=12;$month++){
			  	     $fromMonth = $month;
			  	     $toMonth   = $month+2;
			  	     $month     = $toMonth;
			  	     
			  	     if($fromMonth <=9) $fromMonth = '0'.$fromMonth;
			  	     if($toMonth <=9) $toMonth = '0'.$toMonth;
					    $fromMonthName = date("M", mktime(0, 0, 0, $fromMonth, 10));
					    $toMonthName = date("M", mktime(0, 0, 0, $toMonth, 10)); 
					    $forTheMonth = $presentYear.'-'.$month.'-';
					    
					    $finalData =null;$totalExpenses =null;
					   
					 	$finalData  = $this->profitLossDataQuarterly($fromMonth,$toMonth,$presentYear,$revenueType,$expenseTaxReturn);
					 
					 	$dateRange = $fromMonthName.'-'.substr($presentYear, -2).' To ' .$toMonthName.'-'.substr($presentYear, -2);
					    $finalArray['Sales'][$dateRange] = $finalData['Sales'];
					    $finalArray['GoodsSold'][$dateRange] = $finalData['GoodsSold'];
					    $finalArray['LessExpenses'][$dateRange] = $finalData['LessExpenses'];
					    $totalExpenses = array_sum($finalData['LessExpenses']);
						$finalArray['TotalExpenses'][$dateRange] = $totalExpenses;
						$finalArray['Total'][$dateRange] = ($finalData['Sales']-$finalData['GoodsSold']);
					    $finalArray['NetProfit'][$dateRange]     = ($finalData['Sales']-$finalData['GoodsSold']) -$totalExpenses;
						    
					    
					    $year[$dateRange]=$dateRange;
			  	    
			  	     
				  	     $expenseCategory =  $this->AcpExpenseCategory->find('list',array('fields'=>array('AcpExpenseCategory.category_name'),'conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)));
		 	
						$lessexp=null; $check=null;
						foreach($year as $ye1=>$ye2){
							foreach($expenseCategory as $ex1=>$ex2){
								if($finalArray['LessExpenses'][$ye1][$ex1]){ $check[$ex1]=1; $lessexp[$ex1][$ye1]=$finalArray['LessExpenses'][$ye1][$ex1];  }
								else{ $lessexp[$ex1][$ye1]='-'; }
							}
						}
					 
						$expenseCategory1=$expenseCategory;
						foreach($expenseCategory1 as $ex1=>$ex2){
							if(!$check[$ex1]){unset($lessexp[$ex1]); unset($expenseCategory[$ex1]);}
						}
			   }  
		 } elseif($this->data['profit_loss_report']['period'] == 'Yearly'){  
		 	        $periodType = 'Yearly';  
		 	       
		  	        $revenueType =  $expenseTaxReturn = null;
				    if(!empty($this->data['profit_loss_report']['toDate'])){
				          $datePassed  = date('Y-m-d', strtotime(str_replace('/','-',$this->data['profit_loss_report']['toDate'])));
				            $explode_year = explode('-',$datePassed);
				            $presentYear = $explode_year['0'];
				           
				         if($presentYear =='1970'){
				            $presentYear121 = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/","$3-$2-$1",$this->data['profit_loss_report']['toDate']);
				            $explode_year = explode('-',$presentYear121);
				         	$presentYear = $explode_year['0'];
				         }
				    }else{
				         $presentYear = date('Y');
				    }
				       
				      
				    if(!empty($this->data['profit_loss_report']['revenueType'])){
				    	 $revenueType = $this->data['profit_loss_report']['revenueType'];
				    }
				       
				    if(!empty($this->data['profit_loss_report']['expenseTax'])){
				        $expenseTaxReturn = $this->data['profit_loss_report']['expenseTax'];
				    }
		 	         
		 	        $fromMonth = '1';
			  	    $toMonth   = '12';
			  	     
			  	     
			  	      $financialYear = $presentYear;
			  	     if($fromMonth <=9) $fromMonth = '0'.$fromMonth;
			  	     if($toMonth <=9) $toMonth = '0'.$toMonth;
					    $fromMonthName = date("M", mktime(0, 0, 0, $fromMonth, 10));
					    $toMonthName = date("M", mktime(0, 0, 0, $toMonth, 10)); 
					    $forTheMonth = $presentYear.'-'.$month.'-';
					    
					 	$finalData  = $this->profitLossDataQuarterly($fromMonth,$toMonth,$presentYear,$revenueType,$expenseTaxReturn);
					
					 	$dateRange = $fromMonthName.'-'.substr($presentYear, -2).' To ' .$toMonthName.'-'.substr($presentYear, -2);
					    $finalArray['Sales'][$dateRange] = $finalData['Sales'];
					    $finalArray['GoodsSold'][$dateRange] = $finalData['GoodsSold'];
					    $finalArray['LessExpenses'][$dateRange] = $finalData['LessExpenses'];
					    $totalExpenses = array_sum($finalData['LessExpenses']);
						$finalArray['TotalExpenses'][$dateRange] = $totalExpenses;
						$finalArray['Total'][$dateRange] = ($finalData['Sales']-$finalData['GoodsSold']);
						$finalArray['NetProfit'][$dateRange]     = ($finalData['Sales']-$finalData['GoodsSold']) -$totalExpenses;
					    $year[$dateRange]=$dateRange;
			  	    
			  	     
				  	    $expenseCategory =  $this->AcpExpenseCategory->find('list',array('fields'=>array('AcpExpenseCategory.category_name'),'conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)));
		 	
						$lessexp=null; $check=null;
						foreach($year as $ye1=>$ye2){
							foreach($expenseCategory as $ex1=>$ex2){
								if($finalArray['LessExpenses'][$ye1][$ex1]){ $check[$ex1]=1; $lessexp[$ex1][$ye1]=$finalArray['LessExpenses'][$ye1][$ex1];  }
								else{ $lessexp[$ex1][$ye1]='-'; }
							}
						}
					 
						$expenseCategory1=$expenseCategory;
						foreach($expenseCategory1 as $ex1=>$ex2){
							if(!$check[$ex1]){unset($lessexp[$ex1]); unset($expenseCategory[$ex1]);}
						}
		  }  
	} else{
		
		
		
			         $periodType = 'Monthly';
			         $revenueType =  $expenseTaxReturn = null;
			         $revenueType = '';
			         $expenseTaxReturn = '';
			        
			         $presentYear = date('Y');
			         $financialYear = $presentYear;
		       
					 $finalArray=null;
					 for($month=1;$month<=12;$month++){
						 	if($month <=9) $month = '0'.$month;
						    $monthName = date("M", mktime(0, 0, 0, $month, 10)); 
						    $forTheMonth = $presentYear.'-'.$month.'-';
						 	$finalData  = $this->profitLossData($forTheMonth,$revenueType,$expenseTaxReturn);
						 	
						    $finalArray['Sales'][$monthName.'-'.substr($presentYear, -2)]         = $finalData['Sales'];
						    $finalArray['GoodsSold'][$monthName.'-'.substr($presentYear, -2)]     = $finalData['GoodsSold'];
						    $finalArray['LessExpenses'][$monthName.'-'.substr($presentYear, -2)]  = $finalData['LessExpenses'];
						    $totalExpenses 														  = array_sum($finalData['LessExpenses']);
						    $finalArray['TotalExpenses'][$monthName.'-'.substr($presentYear, -2)] = $totalExpenses;
						    $finalArray['Total'][$monthName.'-'.substr($presentYear, -2)]         = ($finalData['Sales']-$finalData['GoodsSold']);
						    $finalArray['NetProfit'][$monthName.'-'.substr($presentYear, -2)]     = ($finalData['Sales']-$finalData['GoodsSold']) -$totalExpenses;
						    $year[$monthName.'-'.substr($presentYear, -2)]                        = $monthName.'-'.substr($presentYear, -2);
					 }
					
					
					
					
				    $expenseCategory =  $this->AcpExpenseCategory->find('list',array('fields'=>array('AcpExpenseCategory.category_name'),'conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)));
		 		 
					$lessexp=null; $check=null;
					foreach($year as $ye1=>$ye2){
						foreach($expenseCategory as $ex1=>$ex2){
							if($finalArray['LessExpenses'][$ye1][$ex1]){ $check[$ex1]=1; $lessexp[$ex1][$ye1]=$finalArray['LessExpenses'][$ye1][$ex1];  }
							else{ $lessexp[$ex1][$ye1]='-'; }
						}
					}
					 
				 	
					$expenseCategory1=$expenseCategory;
					foreach($expenseCategory1 as $ex1=>$ex2){
						if(!$check[$ex1]){unset($lessexp[$ex1]); unset($expenseCategory[$ex1]);}
					}
		  
		
		
		 
	} 
	
	    $this->set(compact('LastDateofMonth','periodDropdown','expenseTax','revenueTypes','periodType','revenueType','expenseTaxReturn','financialYear'));
		$this->set(compact('subscriberCurrencyCode','date_format','expenseCategory','finalArray','lessexp','expenseCategory'));
	}
	
	public function profitLossData($forTheMonth,$revenueType=null,$expenseTax=null){
	    
	    $CalDetails = explode('-',$forTheMonth);
	    $this->LoadModel('AcrInvoiceDetail');
		$this->LoadModel('SbsSubscriberSetting');
		$this->LoadModel('CpnCurrency');
		$this->loadModel('AcpExpense');
		$this->loadModel('AcrClientInvoice');
	 
	    $finalAmount = null;
		$this->AcrInvoiceDetail->recursive = 0;
		
	    if(!empty($revenueType)){  
	    	if($revenueType == 'Billed'){
	    		$revenueData = array("AcrClientInvoice.status"=>array('Open','Sent','Paid','Partially Paid'));
	    	}elseif($revenueType == 'Collected'){
	    		$revenueData = array("AcrClientInvoice.status"=>array('Paid','Partially Paid'));
	    	}
        } 
	    
	    if(!empty($expenseTax)){
	    	if($expenseTax == 'Include'){
	    		//$expenseData = array('OR'=>array('NOT'=>array("AcrInvoiceDetail.sbs_subscriber_tax_id"=>null,"AcrInvoiceDetail.sbs_subscriber_tax_group_id"=>null)));
	    		$expenseData = array('OR'=>array(array('AcrInvoiceDetail.sbs_subscriber_tax_id IS NOT NULL'),array('AcrInvoiceDetail.sbs_subscriber_tax_group_id IS NOT NULL')));
	    	  }elseif($expenseTax == 'Exclude'){
	    		$expenseData = array("AcrInvoiceDetail.sbs_subscriber_tax_id"=>null,"AcrInvoiceDetail.sbs_subscriber_tax_group_id"=>null);	
	    	}
	    }
	     
		
		$itemSold			= $this->AcpExpense->find('first',array('conditions'=>array('AcpExpense.status'=>'Billed','AcpExpense.date LIKE'=>$forTheMonth.'%','AcpExpense.sbs_subscriber_id'=>$this->subscriber),'fields'=>array('SUM(AcpExpense.amount) AS Expenses')));
		$invoicesGenrated = $this->AcrClientInvoice->find('first',array('conditions'=>array('AND'=>array(
													array('AcrClientInvoice.status !='=>'Canceled','AcrClientInvoice.invoiced_date LIKE'=>$forTheMonth.'%','AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.recurring'=>'N',$revenueData,$expenseData),
													array('AcrClientInvoice.status !='=>'Draft','AcrClientInvoice.invoiced_date LIKE'=>$forTheMonth.'%','AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.recurring'=>'N',$revenueData,$expenseData)
													)),'fields'=>array('SUM(AcrClientInvoice.func_currency_total) AS Sales')))	;	 
		
		/*** Less Expense **/
		$lessExpenseData = null;
		if(!empty($expenseTax)){
	    	if($expenseTax == 'Include'){
	    	  // $lessExpenseData = array("AcpExpense.tax_included"=>'Y');
	    	   
	    	}elseif($expenseTax == 'Exclude'){
	    	   //$lessExpenseData = array("AcpExpense.tax_included"=>'N');
	    	   	
	    	}
	    }
		
		
		$this->loadModel('AcpExpenseCategory');
		$this->loadModel('AcpExpense');
		$expenseCategory =  $this->AcpExpenseCategory->find('list',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)));
		
		$this->AcpExpense->recursive = 0;
		if($expenseTax == 'Exclude'){
			 
			$expenseDetails       =  $this->AcpExpense->find('all',array(
                    'conditions'=>array('AcpExpense.date LIKE'=>$forTheMonth.'%','NOT'=>array('AcpExpense.status'=>'Billed'),'AcpExpense.acp_expense_category_id'=>$expenseCategory,$lessExpenseData),
                    'fields' =>array('SUM(AcpExpense.sub_total) as expense_amount','AcpExpense.acp_expense_category_id','AcpExpenseCategory.category_name'),
                    'group' =>array('AcpExpense.acp_expense_category_id')
            ));
            
		}else{
			 
			 $expenseDetails      =  $this->AcpExpense->find('all',array(
                    'conditions'=>array('AcpExpense.date LIKE'=>$forTheMonth.'%','NOT'=>array('AcpExpense.status'=>'Billed'),'AcpExpense.acp_expense_category_id'=>$expenseCategory,$lessExpenseData),
                    'fields' =>array('SUM(AcpExpense.sub_total) as sub_total', 'SUM(AcpExpense.tax_total) as tax_total','AcpExpense.acp_expense_category_id','AcpExpenseCategory.category_name'),
                    'group' =>array('AcpExpense.acp_expense_category_id')
            ));
             
            foreach ($expenseDetails as $key => $expenseValue) {
                $expenseDetails[$key] = $expenseValue;
                $expenseDetails[$key][0]['expense_amount'] = $expenseValue[0]['sub_total'] + $expenseValue[0]['tax_total'];
            }
		}
		
		/*$this->AcpExpense->recursive = 0;
		$expenseDetails		 =	$this->AcpExpense->find('all',array(
				'conditions'=>array('AcpExpense.date LIKE'=>$forTheMonth.'%','NOT'=>array('AcpExpense.status'=>'Billed'),'AcpExpense.acp_expense_category_id'=>$expenseCategory,$lessExpenseData),
				'fields' =>array('SUM(amount) as expense_amount','AcpExpense.acp_expense_category_id','AcpExpenseCategory.category_name'),
				'group' =>array('AcpExpense.acp_expense_category_id')
		));*/
		
		 
		$profitYear = $CalDetails[0];
	    $profitMonth = $CalDetails[1];
	    $monthName = date("M", mktime(0, 0, 0, $profitMonth, 10)); 
		$val = ($monthName.'-'.substr($profitYear, -2));
		
		$expenses = null;$i=0;
		foreach($expenseDetails as $key=>$value){
			 
			 $expenses[$value['AcpExpense']['acp_expense_category_id']] = $value['0']['expense_amount'];
		}
		
		 
		$returnArray['Sales']        = $invoicesGenrated['0']['Sales'];
		$returnArray['GoodsSold']    = $itemSold['0']['Expenses'];
		$returnArray['LessExpenses'] = $expenses;
	 
		return $returnArray;
	}
	
	public function profitLossDataQuarterly($fromMonth,$toMonth,$year,$revenueType=null,$expenseTax=null){
	  
	    $this->LoadModel('AcrInvoiceDetail');
		$this->LoadModel('SbsSubscriberSetting');
		$this->LoadModel('CpnCurrency');
	    
	    $numDaysMonth = cal_days_in_month(CAL_GREGORIAN,$toMonth, $year);
	    $forTheMonth  = $year.'-'.$fromMonth.'-'.'01';
	    $toTheMonth   = $year.'-'.$toMonth.'-'.$numDaysMonth;
	     
		$finalAmount = null;
		$this->AcrInvoiceDetail->recursive = 0; 
		$revenueData=$expenseData=null;
		if(!empty($revenueType)){  
	    	if($revenueType == 'Billed'){
	    		$revenueData = array("AcrClientInvoice.status"=>array('Open','Sent'));
	    	}elseif($revenueType == 'Collected'){
	    		$revenueData = array("AcrClientInvoice.status"=>array('Paid','Marked as paid'));
	    	}
        } 
	    
	    if(!empty($expenseTax)){
	    	if($expenseTax == 'Include'){
	    		$expenseData = array('OR'=>array('NOT'=>array("AcrInvoiceDetail.sbs_subscriber_tax_id"=>null,"AcrInvoiceDetail.sbs_subscriber_tax_group_id"=>null)));
	    	}elseif($expenseTax == 'Exclude'){
	    		$expenseData = array("AcrInvoiceDetail.sbs_subscriber_tax_id"=>null,"AcrInvoiceDetail.sbs_subscriber_tax_group_id"=>null);	
	    	}
	    }
		                              
		                              
		                              
		                              $itemSold   = $this->AcrInvoiceDetail->find('all',array('conditions'=>array('AND'=>array(
	    									array('AcrClientInvoice.status !='=>'Canceled', 'AcrClientInvoice.invoiced_date BETWEEN ? and ?' =>array($forTheMonth, $toTheMonth),'AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,$revenueData,$expenseData),
	    									array('AcrClientInvoice.status !='=>'Draft', 'AcrClientInvoice.invoiced_date BETWEEN ? and ?' =>array($forTheMonth, $toTheMonth),'AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,$revenueData,$expenseData)
	    									))));
		                                                                                                                                             
		//$itemSold   = $this->AcrInvoiceDetail->find('all',array('conditions'=>array('NOT'=>array('AcrClientInvoice.status'=>'Canceled','AcrClientInvoice.status'=>'Draft'), 'AcrClientInvoice.invoiced_date BETWEEN ? and ?' =>array($forTheMonth, $toTheMonth),'AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,$revenueData,$expenseData)));
	    
	    $finalArray = $finalArray1 = null;
		foreach($itemSold as $key=>$val){
			$finalArray1['SaleAmount'] += $val['AcrClientInvoice']['func_currency_total'];
			$finalArray[$val['AcrClientInvoice']['id']][$val['InvInventory']['id']]['quantity'] = $val['AcrInvoiceDetail']['quantity'];
			$finalArray[$val['AcrClientInvoice']['id']][$val['InvInventory']['id']]['sold_at'] = $val['AcrInvoiceDetail']['unit_rate'];
			$finalArray[$val['AcrClientInvoice']['id']][$val['InvInventory']['id']]['original_price'] = $val['InvInventory']['list_price'];
		}
		 
		foreach($finalArray as $k=>$v){
			foreach($v as $key1=>$value1){
				$finalAmount += $value1['original_price']*$value1['quantity'];
			}
		}
		
		
		/*** Less Expense **/
		$lessExpenseData = null;
		if(!empty($expenseTax)){
	    	if($expenseTax == 'Include'){
	    		$lessExpenseData = array("AcpExpense.tax_included"=>'Y');
	    	}elseif($expenseTax == 'Exclude'){
	    		$lessExpenseData = array("AcpExpense.tax_included"=>'N');	
	    	}
	    }
		
		$this->loadModel('AcpExpenseCategory');
		$this->loadModel('AcpExpense');
		$expenseCategory =  $this->AcpExpenseCategory->find('list',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)));
		$this->AcpExpense->recursive = 0;
		$expenseDetails		 =	$this->AcpExpense->find('all',array(
				'conditions'=>array('AcpExpense.date BETWEEN ? and ?'=>array($forTheMonth, $toTheMonth),'NOT'=>array('AcpExpense.status'=>'Billed'),'AcpExpense.acp_expense_category_id'=>$expenseCategory,$lessExpenseData),
				'fields' =>array('SUM(amount) as expense_amount','AcpExpense.acp_expense_category_id','AcpExpenseCategory.category_name'),
				'group' =>array('AcpExpense.acp_expense_category_id')
		));
		
		 
		$expenses = null;$i=0;
		foreach($expenseDetails as $key=>$value){
			 $expenses[$value['AcpExpense']['acp_expense_category_id']] = $value['0']['expense_amount'];
		}
		 
		$returnArray['Sales']        = $finalArray1['SaleAmount'];
		$returnArray['GoodsSold']    = $finalAmount;
		$returnArray['LessExpenses'] = $expenses;
		 
		return $returnArray;
	}
	
	public function profitlossExcel($pdf=null,$periodType=null,$revenueType =null,$expressTax=null,$financialYear =null){
		   
		   $this->LoadModel('AcpExpenseCategory');
		   $this->LoadModel('SbsSubscriberSetting');
		   $this->LoadModel('CpnCurrency');
		   $this->LoadModel('SbsSubscriber');
		   $this->LoadModel('SbsSubscriberOrganizationDetail');
		  
		   $expenseCategory =  $this->AcpExpenseCategory->find('list',array('fields'=>array('AcpExpenseCategory.category_name'),'conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)));
		   $settings 					= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		   $subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		   $subscriberCurrencyCode 	= $subscriberCurrencyCodeDesc['CpnCurrency']['code'];
	       $date_format    			= $settings['SbsSubscriberSetting']['date_format'];
		   $sbsOrgId			    	= $this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($this->subscriber);
		   $sbsOrgNameArr 				= $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($sbsOrgId);
		   $organizationName 			= $sbsOrgNameArr['SbsSubscriberOrganizationDetail']['organization_name'];
		   $toDate 					    = date($date_format,strtotime(str_replace('/','-',$toDate)));
		   $fromDate 					= date($date_format,strtotime(str_replace('/','-',$fromDate)));	
		   $todayDate 					= date($date_format,strtotime(date('Y-m-d'))); 
		    
		    
		    if(!empty($financialYear)){
		       	   $present_Year = $financialYear;
		       }else{
		       	   $present_Year = date('Y');
		       }
		     
		    $numDaysMonth = cal_days_in_month(CAL_GREGORIAN,12, $present_Year);
	        $toTheMonth   = $present_Year.'-'.'12'.'-'.$numDaysMonth;
		    $EndDate 	  = date($date_format,strtotime($toTheMonth)); 
		   
		 
		 if($periodType == 'Monthly'){
		 	   
		 	   if(!empty($financialYear)){
		       	   $presentYear = substr($financialYear, -4);
		       }else{
		       	   $presentYear = date('Y');
		       }
		       
		       if(!empty($revenueType)){
		       	   $revenueType = $revenueType;
		       }
		       
		       if(!empty($expressTax)){
		       	   $expenseTax = $expressTax;
		       }
		       
		       $finalArray=null;
			   for($month=1;$month<=12;$month++){
						 	if($month <=9) $month = '0'.$month;
						    $monthName = date("M", mktime(0, 0, 0, $month, 10)); 
						    $forTheMonth = $presentYear.'-'.$month.'-';
						 	
						 	$finalData  = $this->profitLossData($forTheMonth,$revenueType,$expenseTax);
						 	
						    $finalArray['Sales'][$monthName.'-'.substr($presentYear, -2)]         = $finalData['Sales'];
						    $finalArray['GoodsSold'][$monthName.'-'.substr($presentYear, -2)]     = $finalData['GoodsSold'];
						    $finalArray['LessExpenses'][$monthName.'-'.substr($presentYear, -2)]  = $finalData['LessExpenses'];
						    $totalExpenses 														  = array_sum($finalData['LessExpenses']);
						    $finalArray['TotalExpenses'][$monthName.'-'.substr($presentYear, -2)] = $totalExpenses;
						    $finalArray['Total'][$monthName.'-'.substr($presentYear, -2)]         = ($finalData['Sales']-$finalData['GoodsSold']);
						    $finalArray['NetProfit'][$monthName.'-'.substr($presentYear, -2)]     = ($finalData['Sales']-$finalData['GoodsSold']) -$totalExpenses;
						    $year[$monthName.'-'.substr($presentYear, -2)]                        = $monthName.'-'.substr($presentYear, -2);
					}
					
					$expenseCategory =  $this->AcpExpenseCategory->find('list',array('fields'=>array('AcpExpenseCategory.category_name'),'conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)));
		 
							
					$lessexp=null; $check=null;
					foreach($year as $ye1=>$ye2){
						foreach($expenseCategory as $ex1=>$ex2){
							if($finalArray['LessExpenses'][$ye1][$ex1]){ $check[$ex1]=1; $lessexp[$ex1][$ye1]=$finalArray['LessExpenses'][$ye1][$ex1];  }
							else{ $lessexp[$ex1][$ye1]='-'; }
						}
					}
					 
				 	$expenseCategory1=$expenseCategory;
					foreach($expenseCategory1 as $ex1=>$ex2){
						if(!$check[$ex1]){unset($lessexp[$ex1]); unset($expenseCategory[$ex1]);}
					}
		    }elseif($periodType == 'Quarterly'){
		   	    
			   	       if(!empty($financialYear)){
			       	       $presentYear = substr($financialYear, -4);
				       }else{
				       	   $presentYear = date('Y');
				       }
				       
				       if(!empty($revenueType)){
				       	   $revenueType = $revenueType;
				       }
				       
				       if(!empty($expressTax)){
				       	   $expenseTax = $expressTax;
				       }
			   	       
			   	       
			   	       for($month=1;$month<=12;$month++){
					  	   $fromMonth = $month;
					  	   $toMonth   = $month+2;
					  	   $month     = $toMonth;
				  	     
				  	     if($fromMonth <=9) $fromMonth = '0'.$fromMonth;
				  	     if($toMonth <=9) $toMonth = '0'.$toMonth;
						    $fromMonthName = date("M", mktime(0, 0, 0, $fromMonth, 10));
						    $toMonthName = date("M", mktime(0, 0, 0, $toMonth, 10)); 
						    $forTheMonth = $presentYear.'-'.$month.'-';
						    
						    $finalData =null;$totalExpenses =null;
						 	$finalData  = $this->profitLossDataQuarterly($fromMonth,$toMonth,$presentYear,$revenueType,$expenseTax);
						
						 	$dateRange = $fromMonthName.'-'.substr($presentYear, -2).' To ' .$toMonthName.'-'.substr($presentYear, -2);
						    $finalArray['Sales'][$dateRange] = $finalData['Sales'];
						    $finalArray['GoodsSold'][$dateRange] = $finalData['GoodsSold'];
						    $finalArray['LessExpenses'][$dateRange] = $finalData['LessExpenses'];
						    $totalExpenses = array_sum($finalData['LessExpenses']);
							$finalArray['TotalExpenses'][$dateRange] = $totalExpenses;
							$finalArray['Total'][$dateRange] = ($finalData['Sales']-$finalData['GoodsSold']);
						    $finalArray['NetProfit'][$dateRange]     = ($finalData['Sales']-$finalData['GoodsSold']) -$totalExpenses;
							    
						    
						    $year[$dateRange]=$dateRange;
				  	    
				  	     
					  	    $expenseCategory =  $this->AcpExpenseCategory->find('list',array('fields'=>array('AcpExpenseCategory.category_name'),'conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$this->subscriber)));
		 
							$lessexp=null; $check=null;
							foreach($year as $ye1=>$ye2){
								foreach($expenseCategory as $ex1=>$ex2){
									if($finalArray['LessExpenses'][$ye1][$ex1]){ $check[$ex1]=1; $lessexp[$ex1][$ye1]=$finalArray['LessExpenses'][$ye1][$ex1];  }
									else{ $lessexp[$ex1][$ye1]='-'; }
								}
							}
						 
							$expenseCategory1=$expenseCategory;
							foreach($expenseCategory1 as $ex1=>$ex2){
								if(!$check[$ex1]){unset($lessexp[$ex1]); unset($expenseCategory[$ex1]);}
							}
			             }        
		   	  }elseif($periodType == 'Yearly'){
		        	 
		 	     
		 	        
				     if(!empty($financialYear)){
			       	       $presentYear = substr($financialYear, -4);
				       }else{
				       	   $presentYear = date('Y');
				       }
				       
				       if(!empty($revenueType)){
				       	   $revenueType = $revenueType;
				       }
				       
				       if(!empty($expressTax)){
				       	   $expenseTax = $expressTax;
				       }
		 	         
		 	        $fromMonth = '1';
			  	    $toMonth   = '12';
			  	     
			  	      $financialYear = $presentYear;
			  	     if($fromMonth <=9) $fromMonth = '0'.$fromMonth;
			  	     if($toMonth <=9) $toMonth = '0'.$toMonth;
					    $fromMonthName = date("M", mktime(0, 0, 0, $fromMonth, 10));
					    $toMonthName = date("M", mktime(0, 0, 0, $toMonth, 10)); 
					  
					    
					 	$finalData  = $this->profitLossDataQuarterly($fromMonth,$toMonth,$presentYear,$revenueType,$expenseTax);
					
					 	$dateRange = $fromMonthName.'-'.substr($presentYear, -2).' To ' .$toMonthName.'-'.substr($presentYear, -2);
					    $finalArray['Sales'][$dateRange] = $finalData['Sales'];
					    $finalArray['GoodsSold'][$dateRange] = $finalData['GoodsSold'];
					    $finalArray['LessExpenses'][$dateRange] = $finalData['LessExpenses'];
					    $totalExpenses = array_sum($finalData['LessExpenses']);
						$finalArray['TotalExpenses'][$dateRange] = $totalExpenses;
						$finalArray['Total'][$dateRange] = ($finalData['Sales']-$finalData['GoodsSold']);
						$finalArray['NetProfit'][$dateRange]     = ($finalData['Sales']-$finalData['GoodsSold']) -$totalExpenses;
					    $year[$dateRange]=$dateRange;
			  	    
			  	     
				  	    $expenseCategory =  $this->AcpExpenseCategory->find('list',array('fields'=>array('AcpExpenseCategory.category_name')));
						$lessexp=null; $check=null;
						foreach($year as $ye1=>$ye2){
							foreach($expenseCategory as $ex1=>$ex2){
								if($finalArray['LessExpenses'][$ye1][$ex1]){ $check[$ex1]=1; $lessexp[$ex1][$ye1]=$finalArray['LessExpenses'][$ye1][$ex1];  }
								else{ $lessexp[$ex1][$ye1]='-'; }
							}
						}
					 
						$expenseCategory1=$expenseCategory;
						foreach($expenseCategory1 as $ex1=>$ex2){
							if(!$check[$ex1]){unset($lessexp[$ex1]); unset($expenseCategory[$ex1]);}
						}
		   }
		    
		 	 
		if($pdf){
			$this->set(Compact('finalArray','lessexp','expenseCategory','subscriberCurrencyCode','organizationName','todayDate','EndDate'));
			$this->render('/Pdf/profit_loss_pdf');
			 
		}
		
		
		$this->set(Compact('finalArray','lessexp','expenseCategory','subscriberCurrencyCode','organizationName'));
	}
	public function export(){
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('AcrInvoiceDetail');
						$this->loadModel('SbsSubscriberSetting');
						$this->loadModel('AcrInvoicePaymentDetail');
						$this->loadModel('AcrInvoiceCustomField');
						$this->loadModel('AcrInvoiceCustomValue');
						$this->loadModel('SbsSubscriberSetting');
						$this->AcrInvoiceDetail->recursive = 0;
						$this->AcrClientInvoice->recursive = 0;
						$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
						$dateFormat		= $settings['SbsSubscriberSetting']['date_format'];	
						$condition_array = null; $filterAction_array = null; $isRecurring_array = null; $status_array = null; $invoice_date_array = null;
					if($this->data['InvoiceFilter']){
						if(!empty($this->request->data['InvoiceFilter']['filterAction'])) {
							$filterAction    = trim($this->request->data['InvoiceFilter']['filterAction']);
							if($filterAction == 'invoice_number'){
								$invoice_number = trim($this->request->data['InvoiceFilter']['filterValue']);
								
							} elseif($filterAction == 'customer_name') {
								$customer_name   = trim($this->request->data['InvoiceFilter']['filterValue']);
								
							} elseif($filterAction == 'amount') {
								$min_amount  	= trim($this->request->data['InvoiceFilter']['filterValue1']);
								$max_amount  	= trim($this->request->data['InvoiceFilter']['filterValue2']);
							} 	
					}
						if(!empty($this->request->data['InvoiceFilter']['isRecurring']))
							$isRecurring  = trim($this->request->data['InvoiceFilter']['isRecurring']);			
						if(!empty($this->request->data['InvoiceFilter']['status']))
							$status       = trim($this->request->data['InvoiceFilter']['status']);
						if(!empty($this->request->data['InvoiceFilter']['fromDate']))			
							$fromDate     = trim($this->request->data['InvoiceFilter']['fromDate']);		
						if($fromDate) $fromDate	  = date('Y-m-d', strtotime(str_replace('/','-',$fromDate)));
						if(!empty($this->request->data['InvoiceFilter']['toDate']))
							$toDate       = trim($this->request->data['InvoiceFilter']['toDate']);
						if($toDate)   $toDate	  = date('Y-m-d', strtotime(str_replace('/','-',$toDate)));
						
						// server side validation
						if(empty($filterAction) && empty($status) && empty($isRecurring) && empty($fromDate) && empty($toDate)) {
							$this->Session->setFlash('<div class="alert alert-danger">Please Enter Atleast One Search Term.</div>');
							//return;				
						}
						if(!empty($filterAction) && $filterAction == 'amount' && (empty($min_amount) || empty($max_amount)) ) {
							$this->Session->setFlash('<div class="alert alert-danger">Are You Trying To Filter By Invoice Amount Range, Please Enter Amount Value Range.</div>');
							//return;				
						}
						if(!empty($filterAction) && ($filterAction == 'invoice_number' || $filterAction == 'customer_name') ) {				
							if ($filterAction == 'invoice_number' && empty($invoice_number)) {
								$this->Session->setFlash('<div class="alert alert-danger">Are You Trying To Filter By Invoice Number, Please Enter term related to Invoice Number.</div>');
								//return;					
							} elseif ($filterAction == 'customer_name' && empty($customer_name)) {
								$this->Session->setFlash('<div class="alert alert-danger">Are You Trying To Filter By Customer Name, Please Enter term related to Customer Name.</div>');
								//return;					
							}				
						} //
						
						if($filterAction) {
							if($filterAction == 'invoice_number' && $invoice_number){
								 $filterAction_array   =	array('AcrClientInvoice.invoice_number LIKE'=> '%'.$invoice_number.'%');
								
							} elseif($filterAction == 'customer_name' && $customer_name) {
								$filterAction_array   =	array('AcrClient.client_name LIKE'=> '%'.$customer_name.'%');
								
							} elseif($filterAction == 'amount' && ($min_amount && $max_amount)) {					
								$filterAction_array   =	array('AcrClientInvoice.invoice_total BETWEEN ? and ?'=>array($min_amount,$max_amount));
							} 
						}						
						if($isRecurring) {
							if($isRecurring == 'All'){
								$isRecurring_array 		 =	array('AcrClientInvoice.recurring' => array('Y','N'));
							} else {
								$isRecurring_array 		 =	array('AcrClientInvoice.recurring' => $isRecurring);
							}
						 }
						if($status) $status_array 					 =	array('AcrClientInvoice.status' => $status);
						if($fromDate && $toDate) $invoice_date_array =	array('AcrClientInvoice.invoiced_date BETWEEN ? and ?'=>array($fromDate,$toDate));
						
						$condition_array = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber);
						$conditions 	 = array($condition_array, $filterAction_array, $isRecurring_array, $status_array, $invoice_date_array);			
					} else {
						$conditions 			= array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber);
					}		
					$acrClientInvoices = $this->AcrClientInvoice->find('all',array('conditions'=>$conditions,'order'=>array('AcrClientInvoice.id DESC')));
					foreach($acrClientInvoices as $acrClientInvoice){
						$invoicePaymentDetails = $this->AcrInvoicePaymentDetail->find('all',array('conditions'=>array('AcrInvoicePaymentDetail.acr_client_invoice_id'=>$acrClientInvoice['AcrClientInvoice']['id'],'AcrInvoicePaymentDetail.is_deleted'=>'no'),'order'=>array('AcrInvoicePaymentDetail.id ASC')));
						foreach($invoicePaymentDetails as $invoicePaymentDetail){
							$totalPayment = $totalPayment + $invoicePaymentDetail['AcrInvoicePaymentDetail']['paid_amount'];
							$lastPaymentDate = $invoicePaymentDetail['AcrInvoicePaymentDetail']['payment_date'];
						}
						$getCustomFields = $this->AcrInvoiceCustomField->getFieldList($this->subscriber);
						$getCustomFieldsVal = $this->AcrInvoiceCustomValue->getFieldValueByInvoiceId($acrClientInvoice['AcrClientInvoice']['id']);
						$invoiceDetails = $this->AcrInvoiceDetail->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$acrClientInvoice['AcrClientInvoice']['id']),'order'=>array('AcrClientInvoice.id DESC')));
						foreach($invoiceDetails as $invoiceDetail){
							if($acrClientInvoice['AcrClientInvoice']['invoiced_date']){
								$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Invoice Date']				=	date($dateFormat,strtotime(str_replace('/','-',$acrClientInvoice['AcrClientInvoice']['invoiced_date'])));
							}
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Invoice ID']						=	$acrClientInvoice['AcrClientInvoice']['id'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Invoice Number']					=	$acrClientInvoice['AcrClientInvoice']['invoice_number'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Invoice Status']					=	$acrClientInvoice['AcrClientInvoice']['status'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Customer Name']					=	$acrClientInvoice['AcrClient']['organization_name'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Customer ID']					=	$acrClientInvoice['AcrClient']['id'];
							if($acrClientInvoice['AcrClientInvoice']['due_date']){
								$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Due Date']					=	date($dateFormat,strtotime(str_replace('/','-',$acrClientInvoice['AcrClientInvoice']['due_date'])));
							}
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Purchase Order']					=	$acrClientInvoice['AcrClientInvoice']['purchase_order_no'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Currency Code']					=	$acrClientInvoice['AcrClientInvoice']['invoice_currency_code'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Exchange Rate']					=	$acrClientInvoice['AcrClientInvoice']['exchange_rate'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Item Name']						=	$invoiceDetail['InvInventory']['name'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Item Desc']						=	$invoiceDetail['AcrInvoiceDetail']['inventory_description'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Quantity']						=	$invoiceDetail['AcrInvoiceDetail']['quantity'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Item Price']						=	$invoiceDetail['AcrInvoiceDetail']['unit_rate'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Discount(%)']					=	$invoiceDetail['AcrInvoiceDetail']['discount_percent'];
							if($invoiceDetail['SbsSubscriberTaxGroup']['group_name']){
								$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Tax Group']					=	$invoiceDetail['SbsSubscriberTaxGroup']['group_name'];
							}elseif($invoiceDetail['SbsSubscriberTax']['name']){
								$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Tax']						=	$invoiceDetail['SbsSubscriberTax']['name'];
							}
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Item Total']						=	$invoiceDetail['AcrInvoiceDetail']['line_total'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Sub Total']						=	$acrClientInvoice['AcrClientInvoice']['sub_total'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Tax Total']						=	$acrClientInvoice['AcrClientInvoice']['tax_total'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Total']							=	$acrClientInvoice['AcrClientInvoice']['invoice_total'];
							if($totalPayment<=$acrClientInvoice['AcrClientInvoice']['invoice_total']){
								$balance = $acrClientInvoice['AcrClientInvoice']['invoice_total']-$totalPayment;
							}elseif($totalPayment>$acrClientInvoice['AcrClientInvoice']['invoice_total']){
								$balance = '0.00';
							}else{
								$balance = $acrClientInvoice['AcrClientInvoice']['invoice_total'];
							}
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Balance']						=	$balance;
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Payment Terms']					=	$acrClientInvoice['SbsSubscriberPaymentTerm']['term'];
							if($lastPaymentDate){
								$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Last Payment Date']				=	date($dateFormat,strtotime(str_replace('/','-',$lastPaymentDate)));
							}
							if($acrClientInvoice['AcrClientInvoice']['notes']){
								$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Notes']						=	$acrClientInvoice['AcrClientInvoice']['notes'];
							}
							if($acrClientInvoice['AcrClientInvoice']['term_conditions']){
								$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Terms And Conditions']			=	$acrClientInvoice['AcrClientInvoice']['term_conditions'];
							}
						}
					}
						$this->set(compact('acrClientInvoices','invoiceDetail','dateFormat','finalArray','getCustomFields','getCustomFieldsVal'));
	}
	public function profitLossPdf(){
		
	}
	
}
?>