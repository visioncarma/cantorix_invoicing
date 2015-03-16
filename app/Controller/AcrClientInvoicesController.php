<?php
App::uses('AppController','Controller');
App::uses('CakeEmail','Network/Email');
App::uses('CakeNumber', 'Utility');
App::import('Vendor','php-excel-reader/excel_reader2');
/**
 * AcrClientInvoices Controller
 *
 * @property AcrClientInvoice $AcrClientInvoice
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AcrClientInvoicesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Email', 'RequestHandler', 'Session');
	var $helpers = array('Xls');
	public $permission;
	
	
	
	public function beforeFilter() {
        parent::beforeFilter();
       $this->loadModel('AcrClientInvoice');
       $this->layout = "sbs_layout";
       $this->permission = $this->Session->read('Auth.AllPermissions.Invoices');
	   $this->inventoryPermission = $this->Session->read('Auth.AllPermissions.Inventories');
       $this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
      	$invoicesActive = 'active';
		$this->set(compact('invoicesActive'));
    }
   
/**
 * index method
 *
 * @return void
 */
	public function index($filterAction = 0, $filterValue = 0, $filterValue1 = 0, $filterValue2 = 0, $isRecurring = 0, $status = 0, $fromDate = 0, $toDate = 0, $page = null) {
		
		$permission = $this->permission;
		$menuActive = 'Manage Invoices';
		$this->set(compact('menuActive'));
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnSubscriptionPlan');
		$this->AcrClientInvoice->recursive = 1;
		
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$limit 			= $settings['SbsSubscriberSetting']['lines_per_page'];
		$dateFormat		= $settings['SbsSubscriberSetting']['date_format'];	
		if($page){
			$page = $page;
		}
		$cpn_subscription_plan_id = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
		$noofcustomers = $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);
		$presentCustCount = $this->AcrClientInvoice->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.status !='=>'Canceled')));
		if($noofcustomers['CpnSubscriptionPlan']['no_of_invoices'] > $presentCustCount) {
			$showAddButton = TRUE;
		} else {
			$showAddButton = FALSE;
		}
		if($noofcustomers['CpnSubscriptionPlan']['no_of_invoices'] == -1) {
			$showAddButton = TRUE;
		}
		
		$condition_array = null; $filterAction_array = null; $isRecurring_array = null; $status_array = null; $invoice_date_array = null;
		if(trim($filterAction)) {
			$this->request->data['InvoiceFilter']['filterAction'] 	= $filterAction;
		}
		if(trim($filterValue)) {
			$this->request->data['InvoiceFilter']['filterValue'] 	= $filterValue;
		}
		if(trim($filterValue1)) {
			$this->request->data['InvoiceFilter']['filterValue1'] 	= $filterValue1;
		}
		if(trim($filterValue2)) {
			$this->request->data['InvoiceFilter']['filterValue2'] 	= $filterValue2;
		}
		if(trim($isRecurring)) {
			$this->request->data['InvoiceFilter']['isRecurring'] 	= $isRecurring;
		}
		if(trim($status)) {
			$this->request->data['InvoiceFilter']['status'] 		= $status;
		}
		if(trim($fromDate)) {
			$this->request->data['InvoiceFilter']['fromDate'] 		= $fromDate;
		}
		if(trim($toDate)) {
			$this->request->data['InvoiceFilter']['toDate'] 		= $toDate;
		}		
		
		if($this->data['InvoiceFilter']){
			if(!empty($this->request->data['InvoiceFilter']['filterAction'])) {
			    $filterAction    = trim($this->request->data['InvoiceFilter']['filterAction']);
				if($filterAction == 'invoice_number'){
					$invoice_number = trim($this->request->data['InvoiceFilter']['filterValue']);
					$filterValue	= $invoice_number;
					
				} elseif($filterAction == 'customer_name') {
					$customer_name   = trim($this->request->data['InvoiceFilter']['filterValue']);
					$filterValue	 = $customer_name;
					
				} elseif($filterAction == 'amount') {
					if($this->request->data['InvoiceFilter']['filterValue1'] == "null"){
						$min_amount = '';
					}else{
						$min_amount  	= trim($this->request->data['InvoiceFilter']['filterValue1']);
					}
					$filterValue1	= $min_amount;
					if($this->request->data['InvoiceFilter']['filterValue2'] == "null"){
						$max_amount = '';
					}else{
						$max_amount  	= trim($this->request->data['InvoiceFilter']['filterValue2']);
					}
					$filterValue2	= $max_amount;
				} 	
		}
			if(!empty($this->request->data['InvoiceFilter']['isRecurring']))
				$isRecurring  = trim($this->request->data['InvoiceFilter']['isRecurring']);			
			if(!empty($this->request->data['InvoiceFilter']['status']))
				$status       = trim($this->request->data['InvoiceFilter']['status']);
			if(!empty($this->request->data['InvoiceFilter']['fromDate']))			
				$fromDate     = trim($this->request->data['InvoiceFilter']['fromDate']);		
			if($fromDate) $fromDate	  = date('Y-m-d', strtotime(str_replace('/', '-', $fromDate)));
			if(!empty($this->request->data['InvoiceFilter']['toDate']))
				$toDate       = trim($this->request->data['InvoiceFilter']['toDate']);
			if($toDate)   $toDate	  = date('Y-m-d', strtotime(str_replace('/', '-', $toDate)));
			
			// server side validation
			if(empty($filterAction) && empty($status) && empty($isRecurring) && empty($fromDate) && empty($toDate)) {
				$this->Session->setFlash('<div class="alert alert-danger">Please Enter Atleast One Search Term.</div>');
				//return;				
			}
			if(!empty($filterAction) && $filterAction == 'amount' && (empty($min_amount) && empty($max_amount)) ) {
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
					$filterAction_array   =	array('AcrClient.organization_name LIKE'=> '%'.$customer_name.'%');
					
				}elseif($filterAction == 'amount' && ($min_amount && !$max_amount)) {					
					$filterAction_array   =	array('AcrClientInvoice.invoice_total >='=>$min_amount);
					$filterValue2 = "null";
				} elseif($filterAction == 'amount' && (!$min_amount && $max_amount)) {					
					$filterAction_array   =	array('AcrClientInvoice.invoice_total <='=>$max_amount);
					$filterValue1 = "null";
				}  elseif($filterAction == 'amount' && ($min_amount && $max_amount)) {					
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
			
			$condition_array = array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.recurring'=>'N');
			$conditions 	 = array($condition_array, $filterAction_array, $isRecurring_array, $status_array, $invoice_date_array);			
			
		} else {
			$conditions 			= array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.recurring'=>'N');
		}		
		
		$this->AcrClientInvoice->unbindModel(array('belongsTo'=>array('SbsSubscriberPaymentTerm','SbsSubscriber'),'hasMany' => array('AcrClientRecurringInvoice','AcrInvoiceCustomValue','AcrInvoiceDetail')));
		$this->AcrInvoicePaymentDetail->virtualFields=array('sum_of_payments'=>'sum(AcrInvoicePaymentDetail.paid_amount)');
		$this->Paginator->settings = array('conditions'=>$conditions,'limit'=>$limit,'order'=>array('AcrClientInvoice.id' => 'DESC'),'page'=>$page,
				'fields'=>array('AcrClientInvoice.id','AcrClientInvoice.acr_client_id','AcrClientInvoice.invoice_number','AcrClientInvoice.invoiced_date','AcrClientInvoice.invoice_total',
					'AcrClientInvoice.status','AcrClientInvoice.invoice_currency_code','AcrClientInvoice.pdf_generated','AcrClient.client_name','AcrClient.organization_name'));
		$this->set('acrClientInvoices', $this->Paginator->paginate('AcrClientInvoice'));	
		//$fromDate = date($dateFormat,strtotime($fromDate));
		//$toDate	  = date($dateFormat,strtotime($toDate));
		$this->set(compact('permission','showAddButton','dateFormat','filterAction','filterValue','filterValue1','filterValue2','isRecurring','status','fromDate','toDate'));
	}	
	
	
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($invoiceId,$filterAction = 0, $filterValue = 0, $filterValue1 = 0, $filterValue2 = 0, $isRecurring = 0, $status = 0, $fromDate = 0, $toDate = 0, $page = null) {
		$menuActive = 'Manage Invoices';
		$this->set(compact('menuActive'));
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrClientCreditnote');
		$this->loadModel('AcrInvoicePaymentDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('AcrInvoiceCustomField');
		$this->loadModel('AcrInvoiceCustomValue');
		$this->loadModel('AcrClient');
		
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$subscriberCurrencyCodeDesc = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode = $subscriberCurrencyCodeDesc['CpnCurrency']['code'];

		$generate      			= $this->generatePdf($invoiceId, 1);
		$clientCurrencyCode 	= $generate['clientCurrencyCode'];
		/*$subscriberCurrencyCode = $generate['subscriberCurrencyCode'];*/
		//$options 				= $generate['options'];
		$invoiceData 			= $generate['invoiceData'];
		$invoiceDetail 			= $generate['invoiceDetail'];
		$taxArray 				= $generate['taxArray'];
		$getPaymentForInvoice = $this->AcrInvoicePaymentDetail->getPaymentHistoryForInvoice($invoiceId);
		if($getPaymentForInvoice){
			foreach($getPaymentForInvoice as $key=>$paymentDetail){
				$paidAmount = $paidAmount + $paymentDetail['AcrInvoicePaymentDetail']['paid_amount'];
			}
		}
		if($paidAmount<=$invoiceData['AcrClientInvoice']['invoice_total']){
				$dueAmount = $invoiceData['AcrClientInvoice']['invoice_total'] - $paidAmount;
			}
		$getCredit = $this->AcrClientCreditnote->getCreditByClient($invoiceData['AcrClient']['id'],$this->subscriber);
				/*
				if($getCredit){
									foreach($getCredit as $key=>$value){
										$available = $available + $value['AcrClientCreditnote']['balance_amount'];
									}
									if($available >= $dueAmount){
										$available = $dueAmount;
									}else{
										$available = $available;
									}
									
								}*/
				
		
		$getCustomFields = $this->AcrInvoiceCustomField->getFieldList($this->subscriber);
		$getCustomFieldsVal = $this->AcrInvoiceCustomValue->getFieldValueByInvoiceId($invoiceId);
		$organisationDetails  = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'),
				array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));
			$customerDetails = $this->AcrClient->findById($this->data['AcrClientInvoice']['acr_client_id'],
				array('client_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip')
			);
		$this->set(compact('getCustomFields','getCustomFieldsVal','dateFormat','organisationDetails','dateFormat','getPaymentForInvoice','paidAmount','dueAmount','clientCurrencyCode', 'subscriberCurrencyCode', 'options', 'invoiceData', 'invoiceDetail', 'taxArray','available','getCredit'));
		$this->set(compact('settings','filterAction','filterValue','filterValue1','filterValue2','isRecurring','status','fromDate','toDate','page'));	
	}
	
	public function getInvoicePaymentDetails($invoiceId = null){
		if($invoiceId){
			$this->loadModel('AcrInvoicePaymentDetail');
			$getPaymentForInvoice = $this->AcrInvoicePaymentDetail->getPaymentHistoryForInvoice($invoiceId);
			foreach($getPaymentForInvoice as $index=>$paymentDetails){
				$paidAmount = $paidAmount + $paymentDetails['AcrInvoicePaymentDetail']['paid_amount'];
			}
			return $paidAmount;
		}
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		$menuActive = 'Manage Invoices';
		$this->set(compact('menuActive'));
		$permission = $this->permission;
		$inventoryPermission = $this->inventoryPermission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('InvInventory');
		$this->loadModel('AcrClient');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$this->loadModel('SbsSubscriberPaymentTerm');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrInvoiceCustomField');
		$this->loadModel('InvInventoryUnitType');
		$this->loadModel('CpnSubscriptionPlan');
		$cpn_subscription_plan_id = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
		$noofcustomers = $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);
		$presentCustCount = $this->AcrClientInvoice->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.status !='=>'Canceled')));
		if($noofcustomers['CpnSubscriptionPlan']['no_of_invoices'] > $presentCustCount) {
			$showAddButton = TRUE;
		} else {
			$showAddButton = FALSE;
		}
		if($noofcustomers['CpnSubscriptionPlan']['no_of_invoices'] == -1) {
			$showAddButton = TRUE;
		}
		if ($this->request->is('post') && $showAddButton) {
			
			if(!empty($this->data['AcrClientInvoice']['invoicetotal'])){
				$invoiceDetail['invoice_number'] 		= trim($this->data['AcrClientInvoice']['invoice_number']);
				$invoiceDetail['purchase_order_no'] 	= $this->data['AcrClientInvoice']['purchase_order_no'];
				$invoiceDetail['invoice_description'] 	= $this->data['AcrClientInvoice']['invoice_description'];
				$invoiceDetail['acr_client_id'] 		= $this->data['AcrClientInvoice']['acr_client_id'];
				$subscriberCurrency = $this->CpnCurrency->getCurrencyById($this->data['AcrClientInvoice']['cpn_currency_id']);
				$invoiceDetail['defaultCurrencyId'] 	= $subscriberCurrency['CpnCurrency']['code'];//Invoiced Currency
				//$invoiceDetail['defaultCurrencyId'] = $subscriberCurrency['CpnCurrency']['code'];
				if($this->data['AcrClientInvoice']['conversionValue']){
					$invoiceDetail['conversionValue'] 		= $this->data['AcrClientInvoice']['conversionValue'];
				}else{
					$invoiceDetail['conversionValue'] 		= 1;
				}
				
				$invoiceDetail['invoiced_date'] 		= date('Y-m-d',strtotime(str_replace('/', '-', $this->data['AcrClientInvoice']['invoiced_date'])));
				$invoiceDetail['sbs_subscriber_payment_term_id'] = $this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id'];
				$invoiceDetail['sbs_subscriber_id'] 			 = $this->subscriber;
				$enddate = $this->findEndDate($this->data['AcrClientInvoice']['invoiced_date'],$this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id']);
				if($enddate){
					$invoiceDetail['due_date'] 			= date('Y-m-d',strtotime(str_replace('/', '-', $enddate)));
				}
				
				$invoiceDetail['discount_total'] 	= $this->data['AcrClientInvoice']['discount_total'];
				if($this->data['Save_Invoice']	==	'1'){
					$invoiceDetail['status'] = 'Draft';
				}elseif($this->data['Send_Now']	==	'1'){
					$invoiceDetail['status'] = 'Sent';
				}
				
				$invoiceDetail['notes'] = $this->data['AcrClientInvoice']['note'];
				$invoiceDetail['terms'] = $this->data['AcrClientInvoice']['terms'];
				if($this->data['Send_Now'] == '1') { 
				$invoiceDetail['email_format'] 	=  $this->data['AcrClientInvoice']['template'] ;
				}
				$invoiceDetail['sub_total'] = $this->data['AcrClientInvoice']['subTotal'];
				$taxTotal = 0;
				foreach($this->data['AcrClientInvoice']['taxValue'] as $taxId=>$taxVal){
					$taxTotal = $taxTotal + $taxVal;
				}
				$invoiceDetail['tax_total'] = $taxTotal;
				$invoiceDetail['func_currency_total'] 	= $this->data['AcrClientInvoice']['subTotal'] + $taxTotal;
				$invoiceDetail['exchange_rate'] 		= $invoiceDetail['conversionValue'];
				if($this->data['AcrClientInvoice']['conversionValue']){
					/*$invoiceDetail['invoice_total'] 		= $this->data['AcrClientInvoice']['conversionValue'] * $invoiceDetail['func_currency_total'] ;*/
					$invoiceDetail['invoice_total'] 		= $invoiceDetail['func_currency_total']/$this->data['AcrClientInvoice']['conversionValue'] ;
				}else{
					$invoiceDetail['invoice_total'] 		=  $invoiceDetail['func_currency_total'] ;
				}
				$saveInvoice = $this->AcrClientInvoice->addInvoice($invoiceDetail);
				if($saveInvoice){
					$this->loadModel('AcrInvoiceDetail');
					foreach($this->data['AcrClientInvoice']['inventory'] as $inventoryCount => $inventoryVal){
						$invoiceDetailRecord = null;
						if($inventoryVal){
							$invoiceDetailRecord['quantity'] 	= $this->data['AcrClientInvoice']['quantity'][$inventoryCount];
							$invoiceDetailRecord['unit_rate'] 	= $this->data['AcrClientInvoice']['unit_rate'][$inventoryCount];
							if($this->data['AcrClientInvoice']['discount_percent'][$inventoryCount]){
								$invoiceDetailRecord['discount_percent'] = $this->data['AcrClientInvoice']['discount_percent'][$inventoryCount];
							}else{
								$invoiceDetailRecord['discount_percent'] = 0;
							}
							$invoiceDetailRecord['inventory_description']	=	$this->data['AcrClientInvoice']['description'][$inventoryCount];
							$invoiceDetailRecord['line_total'] = $this->getLineTotal(0,$this->data['AcrClientInvoice']['quantity'][$inventoryCount],$this->data['AcrClientInvoice']['unit_rate'][$inventoryCount],$this->data['AcrClientInvoice']['discount_percent'][$inventoryCount]);
							$invoiceDetailRecord['acr_client_invoice_id'] = $saveInvoice;
							$invoiceDetailRecord['inv_inventory_id'] 	  = $inventoryVal;
							$taxApplied = explode('-',$this->data['AcrClientInvoice']['tax_inventory'][$inventoryCount]);
							if($taxApplied['1']){
								$invoiceDetailRecord['sbs_subscriber_tax_group_id'] = $taxApplied['1'];
							}else{
								$invoiceDetailRecord['sbs_subscriber_tax_id'] = $this->data['AcrClientInvoice']['tax_inventory'][$inventoryCount];
							}
							$invDetailId = $this->AcrInvoiceDetail->addInvoiceDetail($invoiceDetailRecord);
							if($invDetailId){
								$updateInventoryStock = $this->InvInventory->updateStock($inventoryVal,$this->data['AcrClientInvoice']['quantity'][$inventoryCount]);
							}
						}
					}
					if(!empty($this->data['AcrClientInvoice']['customField'])){
						$this->loadModel('AcrInvoiceCustomValue');
						foreach($this->data['AcrClientInvoice']['customField'] as $customFieldId=>$customFieldValue){
							if($customFieldValue){
								$customData['acr_invoice_custom_field_id'] = $customFieldId;
								$customData['acr_client_invoice_id']	   = $saveInvoice;
								$customData['data'] 					   = $customFieldValue;
								$addValue = $this->AcrInvoiceCustomValue->addValue($customData);
							}
						}
					}
				}
				if($this->data['Send_Now'] == '1'){
					$customerInfo = $this->customerInfo($this->data['AcrClientInvoice']['acr_client_id']);
					if($customerInfo['AcrClientContact']['email']){
						$to 		= $customerInfo['AcrClientContact']['email'];
						$from 		=  $this->EMAIL_FROM;
						$subject 	= "Invoice";
						if($this->data['AcrClientInvoice']['template']){
							$template 	= $this->data['AcrClientInvoice']['template'];
						}else{
							$template 	= "sent_invoice";
						}
						$send 		= $this->sentInvoice($saveInvoice,$customerInfo,$template,$from,$to,$subject,'Invoice');
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">A new invoice is created and mailed to customer.</div>'));
						$this->redirect(array('action' => 'index'));
						/*$this->redirect(array('action' => 'view',$saveInvoice));*/
					}
				}else{
					$pdfGenerate = $this->generatePdf($saveInvoice);
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">A new invoice is created.</div>'));
					$this->redirect(array('action' => 'index'));
					/*$this->redirect(array('action' => 'view',$saveInvoice));*/
				}
				
					
			}else{
				$this->Session->setFlash('<div class="alert alert-danger">Sorry! There are no inventory selected for the invoice.</div>');
			}
		}
		$inventoryList	 	 = $this->InvInventory->getListOfInventory($this->subscriber);
		$customer 		 	 = $this->AcrClient->getCustomerList($this->subscriber);
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
		$termsAndConditions	 = $settings['SbsSubscriberSetting']['terms_conditions'];
		$defaultNotes		 = $settings['SbsSubscriberSetting']['notes'];
		$subsCriberCurrency  = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
		$paymentTerm = $this->SbsSubscriberPaymentTerm->getPaymentTermsBySubscriber($this->subscriber);
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$this->set(compact('unitTypeList'));
		
		foreach($subsCriberCurrency as $subkey => $subscriberCurrencyMap){
			if($subscriberCurrencyMap['CpnCurrency']['name']){
				$currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['code'];
			}			
		}
		$taxList = $this->taxTree();
		$invoiceNumber = $this->generateInvoiceNumber($this->subscriber);
		$getCustomFields = $this->AcrInvoiceCustomField->getFieldList($this->subscriber);
		$this->set(compact('termsAndConditions','defaultNotes','settings','showAddButton','invoiceNumber','customer', 'inventoryList','currencyList','defaultCurrency','paymentTerm','taxList','defaultCurrencyCode','getCustomFields','dateFormat','inventoryPermission','permission'));
		if($this->request->is('mobile')){
			$this->render('/AcrClientInvoices/m_add');
		}
}
	
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null,$filterAction = 0, $filterValue = 0, $filterValue1 = 0, $filterValue2 = 0, $isRecurring = 0, $status = 0, $fromDate = 0, $toDate = 0, $page = null) {
		$menuActive = 'Manage Invoices';
		$this->set(compact('menuActive'));
		$inventoryPermission = $this->inventoryPermission;
		$permission = $this->permission;
		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		
		$this->loadModel('InvInventory');
		$this->loadModel('InvInventoryUnitType');
		$this->loadModel('AcrClient');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$this->loadModel('SbsSubscriberPaymentTerm');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrInvoiceCustomField');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('AcrClientContact');
		$this->loadModel('AcrInvoiceCustomValue');
		if (!$this->AcrClientInvoice->exists($id)) {
			throw new NotFoundException(__('Invalid  invoice'));
		}
		if ($this->request->is(array('post', 'put'))) {
		if(!empty($this->data['AcrClientInvoice']['inventory'])){
			if(!empty($this->data['AcrClientInvoice']['invoicetotal'])){
				$invoiceDetail['invoiceId']				= $this->data['AcrClientInvoice']['invoiceId'];
				$invoiceDetail['invoice_number'] 		= trim($this->data['AcrClientInvoice']['invoice_number']);
				$invoiceDetail['purchase_order_no'] 	= $this->data['AcrClientInvoice']['purchase_order_no'];
				$invoiceDetail['invoice_description'] 	= $this->data['AcrClientInvoice']['invoice_description'];
				$invoiceDetail['acr_client_id'] 		= $this->data['AcrClientInvoice']['acr_client_id'];
				$subscriberCurrency = $this->CpnCurrency->getCurrencyById($this->data['AcrClientInvoice']['cpn_currency_id']);
				$invoiceDetail['defaultCurrencyId'] 	= $subscriberCurrency['CpnCurrency']['code'];//Invoiced Currency
				//$invoiceDetail['defaultCurrencyId'] = $subscriberCurrency['CpnCurrency']['code'];
				if($this->data['AcrClientInvoice']['conversionValue']){
					$invoiceDetail['conversionValue'] 		= $this->data['AcrClientInvoice']['conversionValue'];
				}else{
					$invoiceDetail['conversionValue'] 		= 1;
				}
				
				$invoiceDetail['invoiced_date'] 		= date('Y-m-d',strtotime(str_replace('/', '-',$this->data['AcrClientInvoice']['invoiced_date'])));
				$invoiceDetail['sbs_subscriber_payment_term_id'] = $this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id'];
				$invoiceDetail['sbs_subscriber_id'] 			 = $this->subscriber;
				$enddate = $this->findEndDate($this->data['AcrClientInvoice']['invoiced_date'],$this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id']);
				$invoiceDetail['due_date'] 			= date('Y-m-d',strtotime(str_replace('/', '-', $enddate)));
				$invoiceDetail['discount_total'] 	= $this->data['AcrClientInvoice']['discount_total'];
				if($this->data['Save_Invoice']	==	'1'){
					if($this->data['AcrClientInvoice']['invoice_status'] == "Open"){
						$invoiceDetail['status']	=	'Open';
					}else{
						$invoiceDetail['status'] = 'Draft';
					}
					
				}elseif($this->data['Send_Now']	==	'1'){
					$invoiceDetail['email_format'] 	=  $this->data['AcrClientInvoice']['template'] ;
					$invoiceDetail['status'] = 'Sent';
				}
				$invoiceDetail['notes'] = $this->data['AcrClientInvoice']['note'];
				$invoiceDetail['terms'] = $this->data['AcrClientInvoice']['terms'];
				$invoiceDetail['sub_total'] = $this->data['AcrClientInvoice']['subTotal'];
				$taxTotal = 0;
				foreach($this->data['AcrClientInvoice']['taxValue'] as $taxId=>$taxVal){
					$taxTotal = $taxTotal + $taxVal;
				}
				$invoiceDetail['tax_total'] = $taxTotal;
				$invoiceDetail['func_currency_total'] 	= $this->data['AcrClientInvoice']['subTotal'] + $taxTotal;
				
				if($this->data['AcrClientInvoice']['conversionValue']){
					$invoiceDetail['exchange_rate'] 		= $invoiceDetail['conversionValue'] ;
					/*$invoiceDetail['invoice_total'] 	= $this->data['AcrClientInvoice']['conversionValue'] * $invoiceDetail['func_currency_total'];*/
					$invoiceDetail['invoice_total'] 	= $invoiceDetail['func_currency_total']/$this->data['AcrClientInvoice']['conversionValue'];
				}else{
					$invoiceDetail['exchange_rate'] 		= '1' ;
					$invoiceDetail['invoice_total'] 	=  $invoiceDetail['func_currency_total'];
				}
				
				
				$saveInvoice = $this->AcrClientInvoice->updateInvoice($invoiceDetail);
				if($saveInvoice){
					$this->loadModel('AcrInvoiceDetail');
					foreach($this->data['AcrClientInvoice']['inventory'] as $inventoryCount => $inventoryVal){
						$invoiceDetailRecord = null;
						if($inventoryVal){
							
							if(array_key_exists($inventoryCount,$this->data['AcrClientInvoice']['inventory_Old'])){
								$invoiceDetailRecord['id'] 			= $inventoryCount;
							}
							$invoiceDetailRecord['inventory_description'] 	= $this->data['AcrClientInvoice']['description'][$inventoryCount];
							$invoiceDetailRecord['quantity'] 	= $this->data['AcrClientInvoice']['quantity'][$inventoryCount];
							$invoiceDetailRecord['unit_rate'] 	= $this->data['AcrClientInvoice']['unit_rate'][$inventoryCount];
							if($this->data['AcrClientInvoice']['discount_percent'][$inventoryCount]){
								$invoiceDetailRecord['discount_percent'] = $this->data['AcrClientInvoice']['discount_percent'][$inventoryCount];
							}else{
								$invoiceDetailRecord['discount_percent'] = 0;
							}
							$invoiceDetailRecord['line_total'] = $this->getLineTotal(0,$this->data['AcrClientInvoice']['quantity'][$inventoryCount],$this->data['AcrClientInvoice']['unit_rate'][$inventoryCount],$this->data['AcrClientInvoice']['discount_percent'][$inventoryCount]);
							$invoiceDetailRecord['acr_client_invoice_id'] = $saveInvoice;
							$invoiceDetailRecord['inv_inventory_id'] 	  = $inventoryVal;
							$taxApplied = explode('-',$this->data['AcrClientInvoice']['tax_inventory'][$inventoryCount]);
							if($taxApplied['1']){
								$invoiceDetailRecord['sbs_subscriber_tax_group_id'] = $taxApplied['1'];
								$invoiceDetailRecord['sbs_subscriber_tax_id'] = null;
							}else{
								$invoiceDetailRecord['sbs_subscriber_tax_id'] = $this->data['AcrClientInvoice']['tax_inventory'][$inventoryCount];
								$invoiceDetailRecord['sbs_subscriber_tax_group_id'] = null;
							}
							if(array_key_exists($inventoryCount,$this->data['AcrClientInvoice']['inventory_Old'])){
								$invDetailId = $this->AcrInvoiceDetail->updateInvoiceDetail($invoiceDetailRecord);
							}else{
								$invDetailId = $this->AcrInvoiceDetail->addInvoiceDetail($invoiceDetailRecord);
							}
							
							if($invDetailId){
								$updateInventoryStock = $this->InvInventory->updateStock($inventoryVal,$this->data['AcrClientInvoice']['quantity'][$inventoryCount],$this->data['AcrClientInvoice']['quantity_old'][$inventoryCount]);
							}
							
						}
					}
					if(!empty($this->data['AcrClientInvoice']['customField'])){
						$this->loadModel('AcrInvoiceCustomValue');
						foreach($this->data['AcrClientInvoice']['customField'] as $customFieldId=>$customFieldValue){
							if($customFieldValue){
								$customData['acr_invoice_custom_field_id'] = $customFieldId;
								$customData['acr_client_invoice_id']	   = $saveInvoice;
								$customData['data'] 					   = $customFieldValue;
								$addValue = $this->AcrInvoiceCustomValue->addValue($customData);
							}
						}
					}
				}
				if($this->data['Send_Now'] == '1'){
					$customerInfo = $this->customerInfo($this->data['AcrClientInvoice']['acr_client_id']);
					if($customerInfo['AcrClientContact']['email']){
						$to 		= $customerInfo['AcrClientContact']['email'];
						$from 		=  $this->EMAIL_FROM;
						$subject 	= "Invoice";
						if($this->data['AcrClientInvoice']['template']){
							$template 	= $this->data['AcrClientInvoice']['template'];
						}else{
							$template 	= "sent_invoice";
						}
						$send 		= $this->sentInvoice($saveInvoice,$customerInfo,$template,$from,$to,$subject,'Invoice');
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">A new invoice is created and mailed to customer.</div>'));
						$this->redirect(array('action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$page));
						/*$this->redirect(array('action' => 'view',$saveInvoice));*/
					}
				}else{
					$pdfGenerate = $this->generatePdf($saveInvoice);
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">Inv# '.$this->data['AcrClientInvoice']['invoice_number'].' updated successfully .</div>'));
					$this->redirect(array('action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$page));
					/*$this->redirect(array('action' => 'view',$saveInvoice));*/
				}
				
					
			}else{
				$this->Session->setFlash('<div class="alert alert-danger">Sorry! There are no inventory selected for the invoice.</div>');
			}
		}else{
			$this->Session->setFlash('<div class="alert alert-danger">Sorry! There are no inventory selected for the invoice.</div>');
		} 
		}
		$invoiceData		 = $this->AcrClientInvoice->getInvoiceDetailsById($id);
		$invoiceDetail		 = $this->AcrInvoiceDetail->getInvoiceDetails($id);
		$clientContact		 = $this->AcrClientContact->getClientPrimaryContactDetail($invoiceData['AcrClientInvoice']['acr_client_id']);
		$contactPersonName	 = $clientContact['AcrClientContact']['name'];
		$contactSurName	 	 = $clientContact['AcrClientContact']['sur_name'];
		$contactEmail	 	 = $clientContact['AcrClientContact']['email'];
		$contactMobile	 	 = $clientContact['AcrClientContact']['mobile'];
		$contactHomePhone	 = $clientContact['AcrClientContact']['home_phone'];
		$contactWorkPhone	 = $clientContact['AcrClientContact']['work_phone'];
		$this->set(compact('contactPersonName','contactSurName','contactEmail','contactMobile','contactHomePhone','contactWorkPhone'));
		$taxArray = $this->getTaxCalculation($invoiceDetail);
		$invoicedCurrency = $this->CpnCurrency->getCurrencyIdByCurrencyCode($invoiceData['AcrClientInvoice']['invoice_currency_code']);
		$inventoryList	 	 = $this->InvInventory->getListOfInventory($this->subscriber);
		$customer 		 	 = $this->AcrClient->getCustomerList($this->subscriber);
		
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
		$dateFormat = $settings['SbsSubscriberSetting']['date_format'];
		$subsCriberCurrency  = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
		$paymentTerm = $this->SbsSubscriberPaymentTerm->getPaymentTermsBySubscriber($this->subscriber);
		
		foreach($subsCriberCurrency as $subkey => $subscriberCurrencyMap){
			if($subscriberCurrencyMap['CpnCurrency']['name']){
				$currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['code'];
			}			
		}
		$taxList = $this->taxTree();
		$getCustomFields = $this->AcrInvoiceCustomField->getFieldList($this->subscriber);
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$this->set(compact('unitTypeList'));
		$getCustomFieldsVal = $this->AcrInvoiceCustomValue->getFieldValueByInvoiceId($id); 
		$this->set(compact('inventoryPermission','getCustomFieldsVal','invoiceData','invoiceDetail','customer','invoicedCurrency', 'inventoryList','currencyList','defaultCurrency','paymentTerm','taxList','defaultCurrencyCode','getCustomFields','taxArray','dateFormat'));
		if($this->request->is('mobile')){
			$this->render('/AcrClientInvoices/m_edit');
		}
		
		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->AcrClientInvoice->id = $id;
		if (!$this->AcrClientInvoice->exists()) {
			throw new NotFoundException(__('Invalid acr client invoice'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->AcrClientInvoice->delete()) {
			$this->Session->setFlash(__('The acr client invoice has been deleted.'));
		} else {
			$this->Session->setFlash(__('The acr client invoice could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	// send invoice to customer Email
	public function sentInvoice ($invoiceId = null, $customerInfo = null, $template = null, $from = null, $to = null, $subject = null,$module = null) {
		$menuActive = 'Manage Invoices';
		$this->set(compact('menuActive'));
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsEmailTemplateDetail');
		
		$getEmailTemplateDetail = $this->SbsEmailTemplateDetail->find('first',array('conditions'=>array('SbsEmailTemplateDetail.module_related'=>$module,'SbsEmailTemplateDetail.sbs_subscriber_id'=>$this->subscriber)));
				
				if($template == "sent_invoice_modern"){
									$generate      			= $this->generatePdfModern($invoiceId);
								}elseif($template == "sent_invoice_service_classic"){
									$generate      			= $this->generatePdfServiceClassic($invoiceId);
								}elseif($template == "sent_invoice_service_modern"){
									$generate      			= $this->generatePdfServiceModern($invoiceId);
								}else{
									$generate      			= $this->generatePdf($invoiceId);
								}
								
								if($generate){
									$updatePdfGenerated = $this->pdfGen($invoiceId);
								}
				
		
		$clientCurrencyCode 	= $generate['clientCurrencyCode'];
		$subscriberCurrencyCode = $generate['subscriberCurrencyCode'];
		$options 				= $generate['options'];
		$invoiceData 			= $generate['invoiceData'];
		$invoiceDetail 			= $generate['invoiceDetail'];
		$taxArray 				= $generate['taxArray'];
		$settings 			 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$dateFormat				= $settings['SbsSubscriberSetting']['date_format'];
		$logo					= $settings['SbsSubscriberSetting']['invoice_logo'];
		$signature				= $settings['SbsSubscriberSetting']['email_signature'];
		
		if($getEmailTemplateDetail){
					$subject = $this->getBodyContent($getEmailTemplateDetail['SbsEmailTemplateDetail']['subject'],$module,$invoiceId);
					$from = $getEmailTemplateDetail['SbsEmailTemplateDetail']['from_email_address'];
					$bodyContent = $getEmailTemplateDetail['SbsEmailTemplateDetail']['body_content'];
					$content = $this->getBodyContent($bodyContent,$module,$invoiceId);
					$this->set(compact('mailTemplateType','content','signature'));
				}
		$organisationDetails  = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'),
				array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));		
		$paidAmount = $this->getInvoicePaymentDetails($invoiceId);
		if(!$paidAmount){
			$paidAmount = 0;
		}
		$balanceDue = $invoiceData['AcrClientInvoice']['invoice_total'] - $paidAmount;
		$payPalLink = $this->generatePaypalLink($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code'],$invoiceData['AcrClientInvoice']['invoice_number']);
		$this->set(compact('customerInfo','payPalLink','balanceDue','paidAmount','customerInfo', 'clientCurrencyCode', 'subscriberCurrencyCode', 'options', 'invoiceData', 'invoiceDetail', 'taxArray','organisationDetails','payPalLink'));
		$this->Email->filePaths   = array($_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/invoice/Subscriber-".$this->subscriber."/");
       	$this->Email->attachments = array($invoiceData['AcrClientInvoice']['invoice_number'].'.pdf');
		$this->Email->to 	  	= $to;
		$this->Email->cc 	  	= $cc;
        $this->Email->subject 	= $subject;
   		$this->Email->replyTo 	= $from;
    	$this->Email->from 		= $from;
    	$this->Email->template 	= $template;
   		$this->Email->sendAs 	= 'html';
   		if($this->Email->send()) {
   			return 1;
   		} else {
			return 0;
		}
		
	}
	public function getBodyContent($bodyContent = null,$module = null,$invoiceId = null){
		$this->loadModel('AcrInvoicePaymentDetail');
		$this->loadModel('AcrClientContact');
		if($bodyContent && $module){
			$invoiceData = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
			
			$invoicePayment = $this->AcrInvoicePaymentDetail->getTotalPaidAmount($invoiceId);
			if($invoicePayment){
				$balanceAmount = $invoiceData['AcrClientInvoice']['invoice_total'] - $invoicePayment['AcrInvoicePaymentDetail']['total_sum'];
			}else{
				$balanceAmount = $invoiceData['AcrClientInvoice']['invoice_total'];
			}
			$getClientContact  = $this->AcrClientContact->getClientPrimaryContactDetail($invoiceData['AcrClientInvoice']['acr_client_id']);
			
			switch($module){
				case "Invoice":
								$swears = array(
										"[Balance]"  				=> CakeNumber::currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']),
										"[Balance Due]"  			=> CakeNumber::currency($balanceAmount,$invoiceData['AcrClientInvoice']['invoice_currency_code']),
										"[Invoice Date]"  			=> $invoiceData['AcrClientInvoice']['invoiced_date'],
										"[Invoice No]"  			=> $invoiceData['AcrClientInvoice']['invoice_number'],
										"[PO Number]"  				=> $invoiceData['AcrClientInvoice']['purchase_order_no'],
										"[Invoice Description]" 	=> $invoiceData['AcrClientInvoice']['description'],
										"[Due Date]"  				=> $invoiceData['AcrClientInvoice']['due_date'],
										"[Invoice Amount]" 			=> CakeNumber::currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']),
										"[Organization Name]"  		=> $invoiceData['AcrClient']['organization_name'],
										"[Organization Website]"	=> $invoiceData['AcrClient']['website'],
										"[Business Phone]"  		=> $invoiceData['AcrClient']['business_phone'],
										"[Business Fax]"  			=> $invoiceData['AcrClient']['business_fax'],
										"[Primary Contact Name]"	=> $getClientContact['AcrClientContact']['name'],
										"[Primary Contact Surname]"	=> $getClientContact['AcrClientContact']['sur_name']
										
								);
					
								$content = str_replace(array_keys($swears), array_values($swears), $bodyContent);
								break;
				case "Payment Reminder":
								$swears = array(
										"[Balance]"  				=> CakeNumber::currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']),
										"[Balance Due]"  			=> CakeNumber::currency($balanceAmount,$invoiceData['AcrClientInvoice']['invoice_currency_code']),
										"[Invoice Date]"  			=> $invoiceData['AcrClientInvoice']['invoiced_date'],
										"[Invoice No]"  			=> $invoiceData['AcrClientInvoice']['invoice_number'],
										"[PO Number]"  				=> $invoiceData['AcrClientInvoice']['purchase_order_no'],
										"[Invoice Description]" 	=> $invoiceData['AcrClientInvoice']['description'],
										"[Due Date]"  				=> $invoiceData['AcrClientInvoice']['due_date'],
										"[Invoice Amount]" 			=> CakeNumber::currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']),
										"[Organization Name]"  		=> $invoiceData['AcrClient']['organization_name'],
										"[Organization Website]"	=> $invoiceData['AcrClient']['website'],
										"[Business Phone]"  		=> $invoiceData['AcrClient']['business_phone'],
										"[Business Fax]"  			=> $invoiceData['AcrClient']['business_fax'],
										"[Primary Contact Name]"	=> $getClientContact['AcrClientContact']['name'],
										"[Primary Contact Surname]"	=> $getClientContact['AcrClientContact']['sur_name']
										
								);
								$content = str_replace(array_keys($swears), array_values($swears), $bodyContent);
								break;
			}
			return $content;
		}else{
			$content = $bodyContent;
			return $content;
		}
	}
	// Generate invoice pdf and also use for view invoice details
	/*
	public function downloadGeneratePdfModern($invoiceId = null, $actionType = null){
			// Include Component
			App::import('Component', 'Pdf');
			// Make instance
			$Pdf = new PdfComponent();
			// Invoice name (output name)
			$Pdf->filename = 'INV-49'; // Without .pdf
			// You can use download or browser here
			$Pdf->output = 'download';
			$Pdf->init();
			// Render the view
			$Pdf->process(Router::url('/', true) . 'acr_client_invoices/view/'. $invoiceId);
			$this->render(false); 
		}*/
	
	public function generatePdfModern($invoiceId = null, $actionType = null){
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('AcrInvoicePaymentDetail');
		if(!$actionType) {
			ob_start();
		}		
		$invoiceData   = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
		$invoiceDetail = $this->AcrInvoiceDetail->getInvoiceDetails($invoiceId);
		if(!$actionType) {
			$this->layout = '/pdf/default';
			$this->set(compact('invoiceData','invoiceDetail'));
		}
		$taxArray  = $this->getTaxCalculation($invoiceDetail);
		
		$settings 			 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$dateFormat				=$settings['SbsSubscriberSetting']['date_format'];
		$logo					= $settings['SbsSubscriberSetting']['invoice_logo'];
		/*$defaultCurrencyInfo 	= $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);*/
		$subscriberCurrencyCode = $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$clientCurrencyCode 	= $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');
		$subscriberOrganisationDetail = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($invoiceData['SbsSubscriber']['sbs_subscriber_organization_detail_id']);
		/*
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'] && $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2']){
					$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
				}elseif($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1']){
					$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
				}else{
					$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
				}
				if($invoiceData['AcrClient']['billing_address_line1'] && $invoiceData['AcrClient']['billing_address_line2']){
					$clientAddress = $invoiceData['AcrClient']['billing_address_line1'].'<br />'.$invoiceData['AcrClient']['billing_address_line2'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
				}elseif($invoiceData['AcrClient']['billing_address_line1']){
					$clientAddress = $invoiceData['AcrClient']['billing_address_line1'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
				}else{
					$clientAddress = $invoiceData['AcrClient']['billing_address_line2'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
				}*/
		
		
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'].'<br />';}
		
		
		if($invoiceData['AcrClient']['billing_address_line1']){$clientAddress .= $invoiceData['AcrClient']['billing_address_line1'].'<br />';}
		if($invoiceData['AcrClient']['billing_address_line2']){$clientAddress .= $invoiceData['AcrClient']['billing_address_line2'].'<br />';}
		if($invoiceData['AcrClient']['billing_city']){$clientAddress .= $invoiceData['AcrClient']['billing_city'].'<br />';}
		if($invoiceData['AcrClient']['billing_state']){$clientAddress .= $invoiceData['AcrClient']['billing_state'].'<br />';}
		if($invoiceData['AcrClient']['billing_country']){$clientAddress .= $invoiceData['AcrClient']['billing_country'].'<br />';}
		if($invoiceData['AcrClient']['billing_zip']){$clientAddress .= $invoiceData['AcrClient']['billing_zip'].'<br />';}
		$getPaidAmount = $this->AcrInvoicePaymentDetail->getTotalPaidAmount($invoiceId);
		$download_pay = $getPaidAmount['0']['total_sum'];
		$subscriberId = $this->subscriber;
		$this->set(compact('subscriberOrganisationDetail','dateFormat','download_pay','logo','subscriberAddress','clientAddress','subscriberId'));
		if(!$actionType) {
			$this->set(compact('taxArray','clientCurrencyCode','subscriberCurrencyCode','options'));
			$this->render('/Pdf/my_pdf_view_modern');
		}
		$returnResponse = array('clientCurrencyCode'=>$clientCurrencyCode, 'subscriberCurrencyCode'=>$subscriberCurrencyCode, 'options'=>$options, 'invoiceData'=>$invoiceData, 'invoiceDetail'=>$invoiceDetail, 'taxArray'=>$taxArray);
		return $returnResponse;
	}
	
	public function generatePdfServiceClassic($invoiceId = null, $actionType = null){
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('AcrInvoicePaymentDetail');
		if(!$actionType) {
			ob_start();
		}		
		$invoiceData   = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
		$invoiceDetail = $this->AcrInvoiceDetail->getInvoiceDetails($invoiceId);
		if(!$actionType) {
			$this->layout = '/pdf/default';
			$this->set(compact('invoiceData','invoiceDetail'));
		}
		$taxArray  = $this->getTaxCalculation($invoiceDetail);
		
		$settings 			 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$dateFormat				= $settings['SbsSubscriberSetting']['date_format'];
		$logo					= $settings['SbsSubscriberSetting']['invoice_logo'];
		/*$defaultCurrencyInfo 	= $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);*/
		$subscriberCurrencyCode = $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$clientCurrencyCode 	= $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');
		$subscriberOrganisationDetail = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($invoiceData['SbsSubscriber']['sbs_subscriber_organization_detail_id']);
		/*
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'] && $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2']){
					$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
				}elseif($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1']){
					$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
				}else{
					$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
				}
				if($invoiceData['AcrClient']['billing_address_line1'] && $invoiceData['AcrClient']['billing_address_line2']){
					$clientAddress = $invoiceData['AcrClient']['billing_address_line1'].'<br />'.$invoiceData['AcrClient']['billing_address_line2'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
				}elseif($invoiceData['AcrClient']['billing_address_line1']){
					$clientAddress = $invoiceData['AcrClient']['billing_address_line1'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
				}else{
					$clientAddress = $invoiceData['AcrClient']['billing_address_line2'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
				}*/
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'].'<br />';}
		
		
		if($invoiceData['AcrClient']['billing_address_line1']){$clientAddress .= $invoiceData['AcrClient']['billing_address_line1'].'<br />';}
		if($invoiceData['AcrClient']['billing_address_line2']){$clientAddress .= $invoiceData['AcrClient']['billing_address_line2'].'<br />';}
		if($invoiceData['AcrClient']['billing_city']){$clientAddress .= $invoiceData['AcrClient']['billing_city'].'<br />';}
		if($invoiceData['AcrClient']['billing_state']){$clientAddress .= $invoiceData['AcrClient']['billing_state'].'<br />';}
		if($invoiceData['AcrClient']['billing_country']){$clientAddress .= $invoiceData['AcrClient']['billing_country'].'<br />';}
		if($invoiceData['AcrClient']['billing_zip']){$clientAddress .= $invoiceData['AcrClient']['billing_zip'].'<br />';}
		$getPaidAmount = $this->AcrInvoicePaymentDetail->getTotalPaidAmount($invoiceId);
		$download_pay = $getPaidAmount['0']['total_sum'];
		$subscriberId = $this->subscriber;
		$this->set(compact('subscriberOrganisationDetail','dateFormat','download_pay','logo','clientAddress','subscriberAddress','subscriberId'));
		if(!$actionType) {
			$this->set(compact('taxArray','clientCurrencyCode','subscriberCurrencyCode','options'));
			$this->render('/Pdf/my_pdf_view_service_classic');
		}
		$returnResponse = array('clientCurrencyCode'=>$clientCurrencyCode, 'subscriberCurrencyCode'=>$subscriberCurrencyCode, 'options'=>$options, 'invoiceData'=>$invoiceData, 'invoiceDetail'=>$invoiceDetail, 'taxArray'=>$taxArray);
		return $returnResponse;
	}
	public function generatePdfServiceModern($invoiceId = null, $actionType = null){
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('AcrInvoicePaymentDetail');
		if(!$actionType) {
			ob_start();
		}		
		$invoiceData   = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
		$invoiceDetail = $this->AcrInvoiceDetail->getInvoiceDetails($invoiceId);
		if(!$actionType) {
			$this->layout = '/pdf/default';
			$this->set(compact('invoiceData','invoiceDetail'));
		}
		$taxArray  = $this->getTaxCalculation($invoiceDetail);
		
		$settings 			 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$dateFormat				=$settings['SbsSubscriberSetting']['date_format'];
		$logo					= $settings['SbsSubscriberSetting']['invoice_logo'];
		/*$defaultCurrencyInfo 	= $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);*/
		$subscriberCurrencyCode = $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$clientCurrencyCode 	= $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');
		$subscriberOrganisationDetail = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($invoiceData['SbsSubscriber']['sbs_subscriber_organization_detail_id']);
		/*
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'] && $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2']){
					$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
				}elseif($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1']){
					$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
				}else{
					$subscriberAddress = $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />'.$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];
				}
				if($invoiceData['AcrClient']['billing_address_line1'] && $invoiceData['AcrClient']['billing_address_line2']){
					$clientAddress = $invoiceData['AcrClient']['billing_address_line1'].'<br />'.$invoiceData['AcrClient']['billing_address_line2'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
				}elseif($invoiceData['AcrClient']['billing_address_line1']){
					$clientAddress = $invoiceData['AcrClient']['billing_address_line1'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
				}else{
					$clientAddress = $invoiceData['AcrClient']['billing_address_line2'].'<br />'.$invoiceData['AcrClient']['billing_city'].'<br />'.$invoiceData['AcrClient']['billing_state'].'<br />'.$invoiceData['AcrClient']['billing_country'].'<br />'.$invoiceData['AcrClient']['billing_zip'];
				}*/
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'].'<br />';}
		
		
		if($invoiceData['AcrClient']['billing_address_line1']){$clientAddress .= $invoiceData['AcrClient']['billing_address_line1'].'<br />';}
		if($invoiceData['AcrClient']['billing_address_line2']){$clientAddress .= $invoiceData['AcrClient']['billing_address_line2'].'<br />';}
		if($invoiceData['AcrClient']['billing_city']){$clientAddress .= $invoiceData['AcrClient']['billing_city'].'<br />';}
		if($invoiceData['AcrClient']['billing_state']){$clientAddress .= $invoiceData['AcrClient']['billing_state'].'<br />';}
		if($invoiceData['AcrClient']['billing_country']){$clientAddress .= $invoiceData['AcrClient']['billing_country'].'<br />';}
		if($invoiceData['AcrClient']['billing_zip']){$clientAddress .= $invoiceData['AcrClient']['billing_zip'].'<br />';}
		$getPaidAmount = $this->AcrInvoicePaymentDetail->getTotalPaidAmount($invoiceId);
		$download_pay = $getPaidAmount['0']['total_sum'];
		$subscriberId = $this->subscriber;
		$this->set(compact('subscriberOrganisationDetail','dateFormat','download_pay','logo','clientAddress','subscriberAddress','subscriberId'));
		if(!$actionType) {
			$this->set(compact('taxArray','clientCurrencyCode','subscriberCurrencyCode','options'));
			$this->render('/Pdf/my_pdf_view_service_modern');
		}
		$returnResponse = array('clientCurrencyCode'=>$clientCurrencyCode, 'subscriberCurrencyCode'=>$subscriberCurrencyCode, 'options'=>$options, 'invoiceData'=>$invoiceData, 'invoiceDetail'=>$invoiceDetail, 'taxArray'=>$taxArray);
		return $returnResponse;
	}
	
	
	public function generatePdf($invoiceId = null, $actionType = null){
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('AcrInvoicePaymentDetail');
		if(!$actionType) {
			ob_start();
		}		
		$invoiceData   = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
		$invoiceDetail = $this->AcrInvoiceDetail->getInvoiceDetails($invoiceId);
		if(!$actionType) {
			$this->layout = '/pdf/default';
			$this->set(compact('invoiceData','invoiceDetail'));
		}
		$taxArray  = $this->getTaxCalculation($invoiceDetail);
		
		$settings 			 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$dateFormat				=$settings['SbsSubscriberSetting']['date_format'];
		$logo					= $settings['SbsSubscriberSetting']['invoice_logo'];
		/*$defaultCurrencyInfo 	= $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);*/
		$subscriberCurrencyCode = $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$clientCurrencyCode 	= $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');
		$subscriberOrganisationDetail = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($invoiceData['SbsSubscriber']['sbs_subscriber_organization_detail_id']);
		
		
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'].'<br />';}
		
		
		if($invoiceData['AcrClient']['billing_address_line1']){$clientAddress .= $invoiceData['AcrClient']['billing_address_line1'].'<br />';}
		if($invoiceData['AcrClient']['billing_address_line2']){$clientAddress .= $invoiceData['AcrClient']['billing_address_line2'].'<br />';}
		if($invoiceData['AcrClient']['billing_city']){$clientAddress .= $invoiceData['AcrClient']['billing_city'].'<br />';}
		if($invoiceData['AcrClient']['billing_state']){$clientAddress .= $invoiceData['AcrClient']['billing_state'].'<br />';}
		if($invoiceData['AcrClient']['billing_country']){$clientAddress .= $invoiceData['AcrClient']['billing_country'].'<br />';}
		if($invoiceData['AcrClient']['billing_zip']){$clientAddress .= $invoiceData['AcrClient']['billing_zip'].'<br />';}


		$getPaidAmount = $this->AcrInvoicePaymentDetail->getTotalPaidAmount($invoiceId);
		$download_pay = $getPaidAmount['0']['total_sum'];
		$subscriberId = $this->subscriber;
		$this->set(compact('subscriberOrganisationDetail','dateFormat','subscriberAddress','clientAddress','logo'));
		if(!$actionType) {
			$this->set(compact('taxArray','clientCurrencyCode','subscriberCurrencyCode','options','download_pay','subscriberId'));
			$this->render('/Pdf/my_pdf_view');
		}
		$returnResponse = array('clientCurrencyCode'=>$clientCurrencyCode, 'subscriberCurrencyCode'=>$subscriberCurrencyCode, 'options'=>$options, 'invoiceData'=>$invoiceData, 'invoiceDetail'=>$invoiceDetail, 'taxArray'=>$taxArray);
		return $returnResponse;
	}
	
	// send invoice pdf to customer
	public function sentPdf ($id = null) {
		
	}
	
	// send reminder to customer
	public function sentReminder () {
		$menuActive = 'Manage Invoices';
		$this->set(compact('menuActive'));	
		$invoice_details = null;
		$invoice_details = $this->AcrClientInvoice->getInvoiceDetailsById();
		
		$this->set(compact('invoice_details'));
		$this->Email->to 	  	= '';
        $this->Email->subject 	= 'Invoice!';
   		$this->Email->replyTo 	= 'admin@cantorix.com';
    	$this->Email->from 		= 'admin@cantorix.com';
    	$this->Email->template 	= 'sent_invoice';
   		$this->Email->sendAs 	= 'html';
   		if($this->Email->send()) {
   			return 1;
   		} else {
			return 0;
		}
		
	}
	public function sentCancelNotification($invoiceId = null,$status = null,$template = null,$subject = null) {
		$this->loadModel('AcrClientContact');
		$invoice_details = null;
		$invoice_details = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
		$clientPrimaryContact = $this->AcrClientContact->getClientPrimaryContactDetail($invoice_details['AcrClient']['id']);
		$options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'after');
		$this->set(compact('status','invoice_details','options'));
		$this->Email->to 	  	= $clientPrimaryContact['AcrClientContact']['email'];
        $this->Email->subject 	= $subject;
   		$this->Email->replyTo 	= $this->EMAIL_FROM;
    	$this->Email->from 		= $this->EMAIL_FROM;
    	$this->Email->template 	= $template;
   		$this->Email->sendAs 	= 'html';
   		if($this->Email->send()) {
   			return 1;
   		} else {
			return 0;
		}
		
	}
	
	// $id = unique invoice id, cancel invoice for customer
	public function cancelInvoice ($id = null, $status = null) {
		$menuActive = 'Manage Invoices';
		$this->set(compact('menuActive'));
		$this->loadModel('AcrInvoicePaymentDetail');
		
		$getPaymentForInvoice = $this->AcrInvoicePaymentDetail->getPaymentHistoryForInvoice($id);
		if(empty($getPaymentForInvoice)){
			if($id && $status){
		     	$save->data= null;
				$save->data['AcrClientInvoice']['id']      	  = $id;
			 	$save->data['AcrClientInvoice']['status']  	  = 'Canceled';
			 	$save->data['AcrClientInvoice']['updated_date']  = date('Y-m-d');	
			 
		   	 	switch($status){
					case 'Draft':				
				 	if($this->AcrClientInvoice->save($save->data)){
				 		$this->loadModel('AcrInvoiceDetail');
				 		$this->loadModel('InvInventory');
				 		$acrClientInvoice = $this->AcrClientInvoice->getInvoiceDetailsById($id);
				 		$invoiceDetail = $this->AcrInvoiceDetail->getInvoiceDetails($id);
				 		foreach($invoiceDetail as $invoiceDetailKey=>$invoiceDetailVal){
				 			if($invoiceDetailVal['InvInventory']['id']){
				 				$updateStock = $this->InvInventory->updateStock($invoiceDetailVal['InvInventory']['id'],0,$invoiceDetailVal['AcrInvoiceDetail']['quantity']);
				 			}
				 		}
				 		$this->set(compact('acrClientInvoice'));
				 	}				  
				 	break;
					case 'Sent':
				  	if($this->AcrClientInvoice->save($save->data)){
				  		$template 	= "cancel_notification";
				  		$subject 	= "Invoice Cancel Notification";
				 		$notify 		  = $this->sentCancelNotification($id,$status,$template,$subject);
				 		$acrClientInvoice = $this->AcrClientInvoice->getInvoiceDetailsById($id);
				 		$this->set(compact('acrClientInvoice'));
				 	
						// SENT NOTIFICATION ALSO VIA MAIL
				 	}
					case 'Open':
				  	if($this->AcrClientInvoice->save($save->data)){
				  		$template 	= "cancel_notification";
				  		$subject 	= "Invoice Cancel Notification";
				 		$notify 		  = $this->sentCancelNotification($id,$status,$template,$subject);
				 		$acrClientInvoice = $this->AcrClientInvoice->getInvoiceDetailsById($id);
				 		$this->set(compact('acrClientInvoice'));
				 	
						// SENT NOTIFICATION ALSO VIA MAIL
				 	}
				 	break;
					case 'Marked as Paid':				  	 	
						// Check Payment is removed, if removed then else message
				 	if($this->AcrClientInvoice->save($save->data)){
				 		$acrClientInvoice = $this->AcrClientInvoice->getInvoiceDetailsById($id);
				 		$this->set(compact('acrClientInvoice'));
						// SENT NOTIFICATION ALSO VIA MAIL
				 	}
				 	break;			
			 	}			 
			}
		
			 $this->loadModel('SbsSubscriberSetting');
			 $settings 		 	 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			 $dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
			 $acrClientInvoice 		 = $this->AcrClientInvoice->getInvoiceDetailsById($id);
			 $balance = $acrClientInvoice['AcrClientInvoice']['invoice_total'];
			 $this->set(compact('acrClientInvoice','dateFormat','balance'));
		}else{
			$invoiceLogged = 1;
			$invoiceno = $this->AcrClientInvoice->getInvoiceNumberByInvoiceId($id);
			$paymentDetail = $getPaymentForInvoice;
			if($paymentDetail){
				foreach($paymentDetail as $keyIndex=>$valIndex){
					$paidAmount += $valIndex['AcrInvoicePaymentDetail']['paid_amount'];
				}
				$balance = $paymentDetail['AcrClientInvoice']['invoice_total'] - $paidAmount;
				if($balance <=0){
					$balance = 0;
				}
			}
			else{
							$balance = $invoiceno['AcrClientInvoice']['invoice_total'];
						}
			
			
			
			$this->set(compact('invoiceLogged','invoiceno','balance'));
		}

	}
	public function reminder($invoiceId,$status){
		
		if($this->data['MailTemplate']['invoiceId']){
			$invoiceId 		= $this->data['MailTemplate']['invoiceId'];
			$filterAction 	= $this->data['MailTemplate']['filterAction'];
			$filterValue 	= $this->data['MailTemplate']['filterValue'];
			$filterValue1 	= $this->data['MailTemplate']['filterValue1'];
			$filterValue2 	= $this->data['MailTemplate']['filterValue2'];
			$isRecurring 	= $this->data['MailTemplate']['isRecurring'];
			$statusFilter 	= $this->data['MailTemplate']['status'];
			$fromDate 		= $this->data['MailTemplate']['fromDate'];
			$toDate 		= $this->data['MailTemplate']['toDate'];
			$page 			= $this->data['MailTemplate']['page'];
			if($this->data['MailTemplate']['template']){
				$template = $this->data['MailTemplate']['template'];
			}else{
				$template = "sent_invoice";
			}
		}
		
			if($invoiceId){
			 		$invoice_details = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
					$customerInfo = $this->customerInfo($invoice_details['AcrClientInvoice']['acr_client_id']);
					$this->set(compact('payPalLink'));
					if($customerInfo['AcrClientContact']['email']){
						$to 		= $customerInfo['AcrClientContact']['email'];
						$from 		=  $this->EMAIL_FROM;
						$subject 	= "Invoice";
						$template 	= $template;
						if(($invoice_details['AcrClientInvoice']['status'] == "Sent") || ($invoice_details['AcrClientInvoice']['status'] == "Partially Paid") || ($invoice_details['AcrClientInvoice']['status'] == "Paid")){
							$send 		= $this->sentInvoice($invoiceId,$customerInfo,$template,$from,$to,$subject,"Payment Reminder");
						}else{
							$send 		= $this->sentInvoice($invoiceId,$customerInfo,$template,$from,$to,$subject,"Invoice");
						}
						
						if($send){
							$save->data= null;
							$save->data['AcrClientInvoice']['email_format'] 	=  $template ;
							$save->data['AcrClientInvoice']['id']      	  = $invoiceId;
							if(($status != "Mark as paid") && ($status!= "Paid")&& ($invoice_details['AcrClientInvoice']['status'] != "Paid") && ($invoice_details['AcrClientInvoice']['status'] !="Partially Paid")){
								$save->data['AcrClientInvoice']['status']  	  = 'Sent';
							}
			 				
			 				$save->data['AcrClientInvoice']['updated_date']  = date('Y-m-d');	
			 				$this->AcrClientInvoice->save($save->data);
						}
					}
			}
			if($send){
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">A mail is sent to the customer with invoice attatched.</div>'));
			}else{
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">Mail Could not be sent.</div>'));
			}
			$acrClientInvoice = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
			//$this->redirect(array('controller'=>'acr_client_invoices','action'=>'index'));
			$this->redirect(array('action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$statusFilter,$fromDate,$toDate,$page));
		}
	// create paypal link
	private function generatePaypalLink ($amount = null, $currency = null, $invoice_no = null ) {
		
		$host 	    =  $_SERVER['SERVER_NAME'];		    
		$root       =  $this->webroot; 
		$notify_url = "http://$host$root".'sbs_ipn_listener.php';
		$custom		=  $this->subscriber;
		$amount		=  money_format('%!(.2n',$amount);
		$businessEmail     = $this->payment_gateway_email();
		//$businessEmail       = "venugopal-facilitator@carmatec.com ";		
		if($amount && $currency && $invoice_no && $businessEmail) {
			$url           = 'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick';
                        
			$link 		   = $url."&business=$businessEmail&currency_code=$currency&amount=$amount&item_name=invoice&invoice=$invoice_no&custom=$custom&notify_url=$notify_url";
		}
		return $link;
	}
	
	// payment options Business Details
	private function getPaymentOptionDetails ($paymentOption = null, $subscriberId = null) {
		switch($paymentOption){
			case 'PayPal':
				  $this->loadModel('SbsPaymentMethodValue');
				  $paymentOptionDetails = $this->modelname->find('all', array ('conditions'=>array('modelname.id'=>$id)));
				  break;
		}
		return $paymentOptionDetails;
	}
	
	// payment options
	private function getPaymentOptions ($subscriberId = null) {
		
		$paymentOptions = $this->modelname->find('all', array ('conditions'=>array('modelname.subs_id'=>$subscriberId, 'modelname.subs_status'=>'active')));		
		return $paymentOptions;
	}
	
	
	//ajax request to get customer info
	public function customerInfo($clientId = null){
		$this->loadModel('AcrClientCreditnote');
		if($this->data['AcrClientInvoice']['acr_client_id'] && !$clientId){
			$clientId = $this->data['AcrClientInvoice']['acr_client_id'];
			$ret =1;
		}
		if($clientId){
			$this->loadModel('AcrClientContact');
			$clientInfo = $this->AcrClientContact->getClientPrimaryContactDetail($clientId);
			if($clientInfo){
				$contactPersonName 	= $clientInfo['AcrClientContact']['name'] .' '.$clientInfo['AcrClientContact']['sur_name'];
				$contactEmail 		= $clientInfo['AcrClientContact']['email'];
				$contactMobile 		= $clientInfo['AcrClientContact']['mobile'];
				$contactHomePhone 	= $clientInfo['AcrClientContact']['home_phone'];
				$contactWorkPhone 	= $clientInfo['AcrClientContact']['work_phone'];
				$this->set(compact('contactPersonName','contactEmail','contactMobile','contactHomePhone','contactWorkPhone','available','defaultCurrencyCode'));
			}
			/*
			$getCredit = $this->AcrClientCreditnote->getCreditByClient($clientId,$this->subscriber);
							if($getCredit){
								foreach($getCredit as $key=>$value){
									$available = $available + $value['AcrClientCreditnote']['amount'];
								}
								$this->set(compact('available'));
							}*/
			
			
		}
		return $clientInfo;
		
	}
	
	public function currencyInfo(){
		if($this->data['AcrClientInvoice']['cpn_currency_id']) {
			$currencyId = $this->data['AcrClientInvoice']['cpn_currency_id'];
		}
		if($currencyId){
			$this->loadModel('CpnCurrency');
			$this->loadModel('SbsSubscriberSetting');
			$currencyDetail 		= $this->CpnCurrency->getCurrencyById($currencyId);
			$defaultCurrencyCode 	= $currencyDetail['CpnCurrency']['code'];
			$settings 		 	 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$defaultCurrency 	 	= $settings['SbsSubscriberSetting']['cpn_currency_id'];
			$subscriberCurrencyDesc = $this->CpnCurrency->getCurrencyById($defaultCurrency);
			$subscriberCurrencyCode = $subscriberCurrencyDesc['CpnCurrency']['code'];
			$this->set(compact('defaultCurrencyCode','currencyId','subscriberCurrencyCode','defaultCurrency'));
		}
	}
	
	public function findEndDate($invoiced_date = null,$termId = null){
		
		if(($this->data['AcrClientInvoice']['invoiced_date']) && ($this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id'])){
			$this->loadModel('SbsSubscriberPaymentTerm');
			$getPaymentTermDetail = $this->SbsSubscriberPaymentTerm->getTermsById($this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id']);
			if($getPaymentTermDetail){
				$this->loadModel('SbsSubscriberSetting');
				$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		 		$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
				
				$invoicedDate = str_replace('/', '-', $this->data['AcrClientInvoice']['invoiced_date']);
				$dueDate = date($dateFormat, strtotime($invoicedDate. ' + '.$getPaymentTermDetail.' days'));
				$this->set(compact('dueDate'));
				return $dueDate;
			}elseif($getPaymentTermDetail == 0){
				$this->loadModel('SbsSubscriberSetting');
				$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		 		$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
				$invoicedDate = str_replace('/', '-', $this->data['AcrClientInvoice']['invoiced_date']);
				$dueDate = date($dateFormat,strtotime($invoicedDate));
				
				$this->set(compact('dueDate'));
				return $dueDate;
			}
			
		}elseif($invoiced_date && $termId){
			$this->loadModel('SbsSubscriberPaymentTerm');
			$getPaymentTermDetail = $this->SbsSubscriberPaymentTerm->getTermsById($termId);
			if($getPaymentTermDetail){
				$invoicedDate = str_replace('/', '-', $invoiced_date);
				$dueDate = date('Y-m-d', strtotime($invoicedDate. ' + '.$getPaymentTermDetail.' days'));
				return $dueDate;
			}else{
				$dueDate = str_replace('/', '-', $invoiced_date);
				return $dueDate;
			}
		}
	}
	public function getInventoryDetails($rowId = null,$invoiceDetailId = null,$quoteFlag = NULL,$hideAddInventory){
		
		$inventoryPermission = $this->inventoryPermission;
		$this->loadModel('InvInventory');
		$this->loadModel('AcrClient');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$this->loadModel('SbsSubscriberPaymentTerm');
		$this->loadModel('InvInventoryUnitType');
		if($this->data['AcrClientInvoice']['inventory'][$rowId]){
			$this->loadModel('InvInventory');
			$getInventoryDetails = $this->InvInventory->getInventory($this->data['AcrClientInvoice']['inventory'][$rowId]);
			if($getInventoryDetails){
				$inventoryId 		= $this->data['AcrClientInvoice']['inventory'][$rowId];
				$inventoryDesc 		= $getInventoryDetails['InvInventory']['description'];
				$inventoryRate	  	= $getInventoryDetails['InvInventory']['list_price'];
				$inventoryUnitType 	= $getInventoryDetails['InvInventoryUnitType']['type_name'];
				$inventoryQuantity	= 1;
				if($getInventoryDetails['InvInventory']['sbs_subscriber_tax_group_id']){
					$taxId = $getInventoryDetails['SbsSubscriberTaxGroup']['group_name'].'-'.$getInventoryDetails['SbsSubscriberTaxGroup']['id'];
				}elseif($getInventoryDetails['InvInventory']['sbs_subscriber_tax_id']){
					$taxId = $getInventoryDetails['InvInventory']['sbs_subscriber_tax_id'];
				}else{
					$taxId = null;
				}
				$this->set(compact('inventoryId','inventoryDesc','inventoryRate','inventoryUnitType','inventoryQuantity','taxId','quoteFlag','hideAddInventory'));
			}
		}
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
		$inventoryList = $this->InvInventory->getListOfInventory($this->subscriber);
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$this->set(compact('unitTypeList'));
		$taxList = $this->taxTree();
		$this->set(compact('defaultCurrencyCode','inventoryPermission','customer','invoiceDetailId', 'inventoryList','currencyList','defaultCurrency','paymentTerm','taxList','defaultCurrencyCode','rowId'));
		if($this->request->is('mobile')){
			$this->render('/AcrClientInvoices/m_get_inventory_details');
		}	
}
	
	public function getLineTotal($rowId,$quantity = null,$rate=null,$discountValue=null){
		
		if((!$quantity) && ($this->data['AcrClientInvoice']['quantity'][$rowId])){
			$quantity = $this->data['AcrClientInvoice']['quantity'][$rowId];
		}
		if((!$rate) && ($this->data['AcrClientInvoice']['unit_rate'][$rowId])){
			$rate = $this->data['AcrClientInvoice']['unit_rate'][$rowId];
		}
		if((!$discountValue) && ($this->data['AcrClientInvoice']['discount_percent'][$rowId])){
			$discountValue = $this->data['AcrClientInvoice']['discount_percent'][$rowId];
		}
		if(($quantity) && ($rate)){
			$product = $quantity * $rate;
			if($discountValue){
				$discount = ($product * $discountValue)/100;
				$product = $product - $discount;
			}
			}
			$inventoryRate = $product;
			if($rowId){
				$this->set(compact('inventoryRate','rowId'));
			}else{
				return $inventoryRate;
			}
			return $inventoryRate;
		}
		
		public function calculateTotal($rowId){
			
			$this->loadModel('CpnCurrency');
			foreach($this->data['AcrClientInvoice']['inventory'] as $key1=>$val){
				if($this->data['AcrClientInvoice']['unit_rate'][$key1]){
					if(!$this->data['AcrClientInvoice']['unit_rate'][$key1]){$rate = 0;}
					
					if(($this->data['AcrClientInvoice']['quantity'][$key1]) && ($this->data['AcrClientInvoice']['unit_rate'][$key1])){
						$product = $product + $this->data['AcrClientInvoice']['quantity'][$key1] * $this->data['AcrClientInvoice']['unit_rate'][$key1];
						$rate	=	$this->data['AcrClientInvoice']['quantity'][$key1] * $this->data['AcrClientInvoice']['unit_rate'][$key1];
					}
					if($this->data['AcrClientInvoice']['discount_percent'][$key1]){
						$discount = ($rate * $this->data['AcrClientInvoice']['discount_percent'][$key1])/100;
						$product = $product - $discount;
						$rate = $rate - $discount;
					}
					$subTotal = $subTotal + $rate;
					if($this->data['AcrClientInvoice']['tax_inventory'][$key1]){
						$product = $rate;
						$taxId = explode('-',$this->data['AcrClientInvoice']['tax_inventory'][$key1]);
						if($taxId['1']){
							$this->loadModel('SbsSubscriberTaxGroupMapping');
							$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($taxId['1']);
							foreach($groupTaxMap as $key=>$val1){
								$taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['code'].' (@'.$val1['SbsSubscriberTax']['percent'].'%)';
								if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
									$taxAmount = ($product*$val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									$product = $product + $taxAmount;
								}else{
									$taxAmount = ($rate * $val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									$product = $product + $taxAmount;
								}
							}
						}else{
							$this->loadModel('SbsSubscriberTax');
							$taxDetails = $this->SbsSubscriberTax->getTaxById($this->data['AcrClientInvoice']['tax_inventory'][$key1]);
							if($taxDetails){
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['code'].' (@'.$taxDetails['SbsSubscriberTax']['percent'].'%)';
								$taxAmount = ($rate * $taxDetails['SbsSubscriberTax']['percent'])/100;
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
								$product = $product + ($rate * $taxDetails['SbsSubscriberTax']['percent'])/100;
							}
						}
					}
				}
			}
			$this->set(compact('taxArray'));
			foreach($taxArray as $taxKey =>$taxValue){
				$totalTaxValue = $totalTaxValue + $taxValue['taxAmount'];
			}
			$finalProduct = $subTotal + $totalTaxValue;
			$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($this->data['AcrClientInvoice']['defaultCurrencyId']);
			if($this->data['AcrClientInvoice']['defaultCurrencyId'] == $this->data['AcrClientInvoice']['cpn_currency_id']){
				$invoicedCurrencyAmount = $finalProduct;
				$defaultCurrencyCode 	= $defaultCurrencyInfo['CpnCurrency']['code'];
				$invoicedCurrencyCode 	= $defaultCurrencyCode;
			}else{
				$invoicedCurrencyInfo 	= $this->CpnCurrency->getCurrencyById($this->data['AcrClientInvoice']['cpn_currency_id']);
				if($this->data['AcrClientInvoice']['conversionValue']){
					/*$invoicedCurrencyAmount = $finalProduct * $this->data['AcrClientInvoice']['conversionValue'];*/
					$invoicedCurrencyAmount = $finalProduct / $this->data['AcrClientInvoice']['conversionValue'];
				}else{
					$invoicedCurrencyAmount = $finalProduct;
				}
				$defaultCurrencyCode 	= $defaultCurrencyInfo['CpnCurrency']['code'];
				if($invoicedCurrencyInfo['CpnCurrency']['code']){
					$invoicedCurrencyCode 	= $invoicedCurrencyInfo['CpnCurrency']['code'];
				}else{
					$invoicedCurrencyCode 	= $defaultCurrencyInfo['CpnCurrency']['code'];
				}
			}
			if(!$defaultCurrencyCode){
				$this->loadModel('SbsSubscriberSetting');
				$settings 		 	 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
				$defaultCurrency 	 	= $settings['SbsSubscriberSetting']['cpn_currency_id'];
				$subscriberCurrencyDesc = $this->CpnCurrency->getCurrencyById($defaultCurrency);
				$defaultCurrencyCode = $subscriberCurrencyDesc['CpnCurrency']['code'];
				if($this->data['AcrClientInvoice']['acr_client_id']){
					$this->loadModel('AcrClient');
					$getClientCurrency = $this->AcrClient->getClientCurrency($this->data['AcrClientInvoice']['acr_client_id']);
					$invoicedCurrencyDetail = $this->CpnCurrency->getCurrencyById($getClientCurrency['AcrClient']['cpn_currency_id']);
					$invoicedCurrencyCode	=	$invoicedCurrencyDetail['CpnCurrency']['code'];
					
				}
			}
			debug($finalProduct);
			$this->set(compact('subTotal','product','invoicedCurrencyAmount','invoicedCurrencyCode','defaultCurrencyCode','finalProduct'));
		}
		
		public function calculateTotalAfterDelete($rowId){
			$this->loadModel('CpnCurrency');
			foreach($this->data['AcrClientInvoice']['inventory'] as $key1=>$val){
			if($key1 != $rowId)	{
				if($this->data['AcrClientInvoice']['unit_rate'][$key1]){
					if(!$this->data['AcrClientInvoice']['unit_rate'][$key1]){$rate = 0;}
					
					if(($this->data['AcrClientInvoice']['quantity'][$key1]) && ($this->data['AcrClientInvoice']['unit_rate'][$key1])){
						$product = $product + $this->data['AcrClientInvoice']['quantity'][$key1] * $this->data['AcrClientInvoice']['unit_rate'][$key1];
						$rate	=	$this->data['AcrClientInvoice']['quantity'][$key1] * $this->data['AcrClientInvoice']['unit_rate'][$key1];
					}
					if($this->data['AcrClientInvoice']['discount_percent'][$key1]){
						$discount = ($rate * $this->data['AcrClientInvoice']['discount_percent'][$key1])/100;
						$product = $product - $discount;
						$rate = $rate - $discount;
					}
					$subTotal = $subTotal + $rate;
					if($this->data['AcrClientInvoice']['tax_inventory'][$key1]){
						$product = $rate;
						$taxId = explode('-',$this->data['AcrClientInvoice']['tax_inventory'][$key1]);
						if($taxId['1']){
							$this->loadModel('SbsSubscriberTaxGroupMapping');
							$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($taxId['1']);
							foreach($groupTaxMap as $key=>$val1){
								$taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['code'];
								if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
									$taxAmount = ($product*$val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									$product = $product + $taxAmount;
								}else{
									$taxAmount = ($rate * $val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									$product = $product + $taxAmount;
								}
							}
						}else{
							$this->loadModel('SbsSubscriberTax');
							$taxDetails = $this->SbsSubscriberTax->getTaxById($this->data['AcrClientInvoice']['tax_inventory'][$key1]);
							if($taxDetails){
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['code'];
								$taxAmount = ($rate * $taxDetails['SbsSubscriberTax']['percent'])/100;
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
								$product = $product + ($rate * $taxDetails['SbsSubscriberTax']['percent'])/100;
							}
						}
					}
				}
			  }
			} 
			
			$this->set(compact('taxArray'));
			foreach($taxArray as $taxKey =>$taxValue){
				$totalTaxValue = $totalTaxValue + $taxValue['taxAmount'];
			}
			$finalProduct = $subTotal + $totalTaxValue;
			$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($this->data['AcrClientInvoice']['defaultCurrencyId']);
			if($this->data['AcrClientInvoice']['defaultCurrencyId'] == $this->data['AcrClientInvoice']['cpn_currency_id']){
				$invoicedCurrencyAmount = $finalProduct;
				$defaultCurrencyCode 	= $defaultCurrencyInfo['CpnCurrency']['code'];
				$invoicedCurrencyCode 	= $defaultCurrencyCode;
			}else{
				$invoicedCurrencyInfo 	= $this->CpnCurrency->getCurrencyById($this->data['AcrClientInvoice']['cpn_currency_id']);
				if($this->data['AcrClientInvoice']['conversionValue']){
					/*$invoicedCurrencyAmount = $finalProduct * $this->data['AcrClientInvoice']['conversionValue'];*/
					$invoicedCurrencyAmount = $finalProduct / $this->data['AcrClientInvoice']['conversionValue'];
				}else{
					$invoicedCurrencyAmount = $finalProduct;
				}
				$defaultCurrencyCode 	= $defaultCurrencyInfo['CpnCurrency']['code'];
				if($invoicedCurrencyInfo['CpnCurrency']['code']){
					$invoicedCurrencyCode 	= $invoicedCurrencyInfo['CpnCurrency']['code'];
				}else{
					$invoicedCurrencyCode 	= $defaultCurrencyInfo['CpnCurrency']['code'];
				}
			}
			$this->set(compact('subTotal','product','invoicedCurrencyAmount','invoicedCurrencyCode','defaultCurrencyCode','finalProduct'));
		}
		
		public function invoiceNumberExist(){
			
			if($this->data['AcrClientInvoice']['invoice_number']){
				$invoiceExist = $this->AcrClientInvoice->getInvoiceByInvoiceNumber(trim($this->data['AcrClientInvoice']['invoice_number']),$this->subscriber);
				if($invoiceExist){
					$invoiceNumber = $this->generateInvoiceNumber($this->subscriber);
					$enteredInvoiceNumber = $this->data['AcrClientInvoice']['invoice_number'];
					$this->set(compact('invoiceExist','invoiceNumber','enteredInvoiceNumber'));
				}else{
					$invoiceNumber = $this->data['AcrClientInvoice']['invoice_number'];
					$this->set(compact('invoiceNumber'));
				}
			}
		}
		
		public function getTaxCalculation($invoiceDetail = null){
                
		if($invoiceDetail){
			foreach($invoiceDetail as $key=>$invoiceDetailValue){
				if($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']){
							$this->loadModel('SbsSubscriberTaxGroupMapping');
							$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']);
							$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
							$lineTotal = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
							foreach($groupTaxMap as $key=>$val1){
								$taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['code'].'(@'.$val1['SbsSubscriberTax']['percent'].'%)';
								if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
									$taxAmount = ($product*$val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									$product = $product + $taxAmount;
								}else{
									/*$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];*/
									$taxAmount = ($lineTotal * $val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									//$product = $lineTotal + $taxAmount;
                                                                          $product = $product + $taxAmount;
								}
							}
						}elseif($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id']){
							$this->loadModel('SbsSubscriberTax');
							$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
							$taxDetails = $this->SbsSubscriberTax->getTaxById($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id']);
							if($taxDetails){
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['code'].'(@'.$taxDetails['SbsSubscriberTax']['percent'].'%)';
								$taxAmount = ($product * $taxDetails['SbsSubscriberTax']['percent'])/100;
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
								//$product = $product + ($product * $taxDetails['SbsSubscriberTax']['percent'])/100;
							}
						}
			}
			return $taxArray;
		}
	}

	public function getClientCurrency(){
		
		if($this->data['AcrClientInvoice']['acr_client_id']){
			$this->loadModel('AcrClient');
			$this->loadModel('CpnCurrency');
			$this->loadModel('SbsSubscriberCpnCurrencyMapping');
			$this->loadModel('SbsSubscriberSetting');
				$lockCurrency =1;
				$getClientCurrency = $this->AcrClient->getClientCurrency($this->data['AcrClientInvoice']['acr_client_id']);
				$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($getClientCurrency['AcrClient']['cpn_currency_id']);
			
			
			$subsCriberCurrency  = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
			foreach($subsCriberCurrency as $subkey => $subscriberCurrencyMap){
			if($subscriberCurrencyMap['CpnCurrency']['name']){
				$currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['code'];
				}			
			}
			$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
			$defaultCurrencyChange = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
			$defaultCurrencyCodeChange = $defaultCurrencyChange['CpnCurrency']['code'];
			$this->set(compact ('lockCurrency','currencyList','defaultCurrencyInfo','getClientCurrency','defaultCurrency','defaultCurrencyChange', 'defaultCurrencyCodeChange'));
			
		}
		debug($defaultCurrency);
		debug($defaultCurrencyCodeChange);
	}

	public function currencyChange($clientCurrencyId = null,$defaultCurrency = null,$defaultCurrencyCodeChange = null){
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$currencySelected = $this->data['AcrClientInvoice']['cpn_currency_id'];
		$subsCriberCurrency  = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
			foreach($subsCriberCurrency as $subkey => $subscriberCurrencyMap){
			if($subscriberCurrencyMap['CpnCurrency']['name']){
				$currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['code'];
				}			
			 }
		$this->set(compact('clientCurrencyId','defaultCurrency','defaultCurrencyCodeChange','currencySelected','currencyList'));
	}
	public function addmore($rowId = null){
		
		$inventoryPermission = $this->inventoryPermission;
		$this->loadModel('InvInventory');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('InvInventoryUnitType');
		if(!$rowId){
			/**/
			if(empty($this->data['rowcount'])){
				$rowId = 1500;
			}else{
				$rowId = $this->data['rowcount'];
			}
		}
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$this->set(compact('unitTypeList'));
		$inventoryList	 	 = $this->InvInventory->getListOfInventory($this->subscriber);
		$taxList = $this->taxTree();
		$this->set(compact('taxList','inventoryList','rowId','defaultCurrencyCode','inventoryPermission','unitTypeList'));
		if($this->request->is('mobile')){
			$this->render('/AcrClientInvoices/m_addmore');
		}
	}
	public function downloadLink($invoiceId = null,$invoiceNumber = null){
        		$this->viewClass = 'Media';
        			$params = array(
            			'id'        => $invoiceNumber.'.pdf',
           	 			'name'      => $invoiceNumber,
            			'download'  => true,
            			'extension' => 'pdf',
            			'path'      => 'files/uploads/invoice'.DS
        		);
	        	$this->set($params);
	        	
        	
		}
	public function downloadOnlyPdf($invoiceId = null,$invoiceNumber = null){
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('AcrInvoicePaymentDetail');
		ob_start();
		$invoiceData   = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
		$invoiceDetail = $this->AcrInvoiceDetail->getInvoiceDetails($invoiceId);
		$this->layout = '/pdf/default';
		$this->set(compact('invoiceData','invoiceDetail'));
		$taxArray  = $this->getTaxCalculation($invoiceDetail);
		
		$settings 			 	= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$dateFormat				=$settings['SbsSubscriberSetting']['date_format'];
		$logo					= $settings['SbsSubscriberSetting']['invoice_logo'];
		$subscriberCurrencyCode = $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$clientCurrencyCode 	= $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$options = array('zero'=>'0.00','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');
		$subscriberOrganisationDetail = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($invoiceData['SbsSubscriber']['sbs_subscriber_organization_detail_id']);
		
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'].'<br />';}
		if($subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip']){$subscriberAddress .=$subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'].'<br />';}
		
		
		if($invoiceData['AcrClient']['billing_address_line1']){$clientAddress .= $invoiceData['AcrClient']['billing_address_line1'].'<br />';}
		if($invoiceData['AcrClient']['billing_address_line2']){$clientAddress .= $invoiceData['AcrClient']['billing_address_line2'].'<br />';}
		if($invoiceData['AcrClient']['billing_city']){$clientAddress .= $invoiceData['AcrClient']['billing_city'].'<br />';}
		if($invoiceData['AcrClient']['billing_state']){$clientAddress .= $invoiceData['AcrClient']['billing_state'].'<br />';}
		if($invoiceData['AcrClient']['billing_country']){$clientAddress .= $invoiceData['AcrClient']['billing_country'].'<br />';}
		if($invoiceData['AcrClient']['billing_zip']){$clientAddress .= $invoiceData['AcrClient']['billing_zip'].'<br />';}
		$getPaidAmount = $this->AcrInvoicePaymentDetail->getTotalPaidAmount($invoiceId);
		$download_pay = $getPaidAmount['0']['total_sum'];
		$this->set(compact('subscriberOrganisationDetail','dateFormat','download_pay','logo','subscriberAddress','clientAddress'));
		$this->set(compact('taxArray','clientCurrencyCode','subscriberCurrencyCode','options'));
		$this->render('/Pdf/pdf_download_invoice');
		//$this->render('/Pdf/my_pdf_view_modern');
	}
		public function savePdf($invoiceId = null,$invoiceNumber = null){
			
			if($invoiceId){
				$pdfGenerate = $this->generatePdf($invoiceId);
				if($pdfGenerate){
					$updatepdf = $this->pdfGen($invoiceId);
					if($updatepdf){
						$pdf = 'Yes';
					}else{
						$pdf = 'No';
					}
				}
				$this->set(compact('pdf','invoiceId','invoiceNumber'));
				$this->render('save_pdf');
			}
		}
		public function pdfGen($invoiceId = null){
			if($invoiceId){
				$saveArray->data = null;
				$saveArray->data['AcrClientInvoice']['id'] = $invoiceId;
				$saveArray->data['AcrClientInvoice']['pdf_generated'] = 'Yes';
				if($this->AcrClientInvoice->save($saveArray->data)){
					return true;
				}else{
					return false;
				}
			}
			
		}
		
		public function availCredit($invoiceId = null,$creditAmount = null){
			$this->autoRender = false;
			if($invoiceId && $creditAmount){
				$this->loadModel('CpnPaymentMethod');
				$this->loadModel('AcrInvoicePaymentDetail');
				$this->loadModel('AcrClientCreditnote');
				$this->loadModel('AcrCreditnotePaymentMapping');
				$invoiceData		 = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
				$getCredit 			 = $this->AcrClientCreditnote->getCreditByClient($invoiceData['AcrClient']['id'],$this->subscriber);
				if($getCredit){
					$payMentMethod 		 = 'Credit Note';
					$getPaymentMethodId  = $this->CpnPaymentMethod->getPaymentMethodByname($payMentMethod);
					if(!$getPaymentMethodId){
						$getPaymentMethodId = $this->CpnPaymentMethod->addNewPaymentMethod($payMentMethod);
					}
					
					$paymentDetail['payment_method'] 		=  		$getPaymentMethodId;
					if($invoiceData['AcrClientInvoice']['exchange_rate']){
						$paymentDetail['paid_amount']	 		=		$creditAmount;
					}else{
						$paymentDetail['paid_amount']	 		=		$creditAmount;
					}
					$paymentDetail['payment_date']			=		date('Y-m-d'); 			
					$paymentDetail['reference_no']	 		=		'Payment Recorded against Inv#'.$invoiceData['AcrClientInvoice']['invoice_number'].' from credit note'; 			
					$paymentDetail['notes']			 		=		'Credit applied as a payment method.'; 				
					$paymentDetail['send_payment_note'] 	=		'N';
					$paymentDetail['acr_client_id']			=		$invoiceData['AcrClient']['id']; 		
					$paymentDetail['acr_client_invoice_id'] =		$invoiceId;
					$paymentDetail['sbs_subscriber_id']		=		$this->subscriber;
					$lastPaymentId =  	$this->AcrInvoicePaymentDetail->addPaymentDetail($paymentDetail);
					if($lastPaymentId){
						if($invoiceData['AcrClientInvoice']['exchange_rate']){
							$exchangeRate = $invoiceData['AcrClientInvoice']['exchange_rate'];
						}else{
							$exchangeRate = 1;
						}
						if(($creditAmount*$exchangeRate) == $invoiceData['AcrClientInvoice']['invoice_total']){
							$updateInvoiceStatus = null;
							$updateInvoiceStatus['AcrClientInvoice']['id'] = $invoiceId;
							$updateInvoiceStatus['AcrClientInvoice']['status'] = 'Paid';
							$this->AcrClientInvoice->save($updateInvoiceStatus);
						}
						foreach($getCredit as $key=>$creditVal){
							if($creditAmount>=$creditVal['AcrClientCreditnote']['amount']){
								$amount = 0;
								$creditAmount = $creditAmount - $creditVal['AcrClientCreditnote']['balance_amount'];
								$status = "Applied";
								$updateCreditAmount = $this->AcrClientCreditnote->update($creditVal['AcrClientCreditnote']['id'],$amount,$status);
								if($updateCreditAmount){
									$updateCreditNoteMapping = null;
									$updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_client_creditnote_id'] 	 = $creditVal['AcrClientCreditnote']['id'];
									$updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_invoice_payment_detail_id'] = $lastPaymentId;
									$updateCreditNoteMapping['AcrCreditnotePaymentMapping']['sbs_subscriber_id'] = $this->subscriber;
									$updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_client_invoice_id'] = $invoiceId;
									$this->AcrCreditnotePaymentMapping->addMapping($updateCreditNoteMapping);
								}
								//$this->AcrClientCreditnote->id = $creditVal['AcrClientCreditnote']['id'];
								//$this->AcrClientCreditnote->delete();
							}elseif($creditAmount>0){
								$amount = $creditVal['AcrClientCreditnote']['balance_amount'] - $creditAmount;
								$creditAmount = 0;
								if($amount>0){
									$status = "Partially Applied";
								}else{
									$status = "Applied";
								}
								$updateCredit = $this->AcrClientCreditnote->update($creditVal['AcrClientCreditnote']['id'],$amount,$status);
								if($updateCredit){
									$updateCreditNoteMapping = null;
									$updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_client_creditnote_id'] 	 = $creditVal['AcrClientCreditnote']['id'];
									$updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_invoice_payment_detail_id'] = $lastPaymentId;
									$updateCreditNoteMapping['AcrCreditnotePaymentMapping']['sbs_subscriber_id'] = $this->subscriber;
									$updateCreditNoteMapping['AcrCreditnotePaymentMapping']['acr_client_invoice_id'] = $invoiceId;
									$this->AcrCreditnotePaymentMapping->addMapping($updateCreditNoteMapping);
								}
							}
						}
						
					}
				}
				
			}
			$this->redirect(array('action' => 'view',$invoiceId));
		}
		
		public function preview(){
			
			$data = $this->data;
			$this->loadModel('SbsSubscriberPaymentTerm');
			$this->loadModel('SbsSubscriberOrganizationDetail');
			$this->loadModel('AcrClient');
			$this->loadModel('InvInventory');
			$this->loadModel('SbsSubscriberTax');
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('CpnCurrency');
			$organisationDetails  = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'),
				array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));
			$customerDetails = $this->AcrClient->findById($this->data['AcrClientInvoice']['acr_client_id'],
				array('client_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip')
			);
			$inventories = $this->InvInventory->getListOfInventory($this->subscriber);
			$taxes = $this->SbsSubscriberTax->getTaxesBySubscriber($this->subscriber);
			$settings 			 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$invoicedCurrency 	 = $this->CpnCurrency->getCurrencyById($data['AcrClientInvoice']['cpn_currency_id']);
			$paymentTerm 		 = $this->SbsSubscriberPaymentTerm->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.id'=>$data['AcrClientInvoice']['sbs_subscriber_payment_term_id'])));
			$data['AcrClientInvoice']['invoice_currency_code'] = $invoicedCurrency['CpnCurrency']['code'];
			$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
			$logo					= $settings['SbsSubscriberSetting']['invoice_logo'];
			$enddate = $this->findEndDate($data['AcrClientInvoice']['invoiced_date'],$data['AcrClientInvoice']['sbs_subscriber_payment_term_id']);
			foreach($data['AcrClientInvoice']['inventory'] as $inventoryCount=>$inventoryVal){
				if(!$data['line_total_hidden'][$inventoryCount]){
					$data['AcrClientInvoice']['line_total_hidden'][$inventoryCount] = $this->getLineTotal(0,$data['AcrClientInvoice']['quantity'][$inventoryCount],$data['AcrClientInvoice']['unit_rate'][$inventoryCount],$data['AcrClientInvoice']['discount_percent'][$inventoryCount]);
				}
			}
			$this->set(compact('logo','paymentTerm','data','organisationDetails','customerDetails','inventories','taxes','invoicedCurrency','dateFormat','enddate'));
		}
		
		
		
		public function previewSend(){
			$this->loadModel('AcrInvoiceDetail');
			$this->loadModel('SbsSubscriberOrganizationDetail');
			$this->loadModel('AcrClient');
			$this->loadModel('SbsSubscriberSetting');
				$invoiceId = $this->data['MailTemplate']['invoiceId'];
				$mailTemplate = $this->data['MailTemplate']['template'];
			
			
			
			$invoiceData		 = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
			if($invoiceData['AcrClientInvoice']['exchange_rate']){
				$conversionValue 	 = $invoiceData['AcrClientInvoice']['exchange_rate'];
			}else{
				$conversionValue 	 = 1;
			}
			
			$subscriberCurrencyCode = $invoiceData['AcrClientInvoice']['invoice_currency_code'];
			$invoiceDetail		 = $this->AcrInvoiceDetail->getInvoiceDetails($invoiceId);
			$taxArray  = $this->getTaxCalculation($invoiceDetail);
			$organisationDetails  = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'),
				array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));
			$customerDetails = $this->AcrClient->findById($invoiceData['AcrClientInvoice']['acr_client_id'],
				array('client_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip')
			);
			$settings 			 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
			$logo					= $settings['SbsSubscriberSetting']['invoice_logo'];
			$this->set(compact('logo','dateFormat','invoiceId','mailTemplate','invoiceData','invoiceDetail','taxArray','organisationDetails','customerDetails','conversionValue','subscriberCurrencyCode'));
			
		}
		
		public function showExcel(){
			$permission = $this->permission;
			if($this->permission['_create'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			$this->set(compact('permission'));
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('CpnSubscriptionPlan');
			$this->loadModel('CpnCurrency');
			$cpn_subscription_plan_id = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
			$noofcustomers = $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);
			
			$presentCustCount = $this->AcrClientInvoice->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.status !='=>'Canceled')));
			if($noofcustomers['CpnSubscriptionPlan']['no_of_invoices'] > $presentCustCount) {
				$showAddButton = TRUE;
			} else {
				$showAddButton = FALSE;
			}
			if($noofcustomers['CpnSubscriptionPlan']['no_of_invoices'] == -1) {
				$showAddButton = TRUE;
			}
			$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$dateFormat = $settings['SbsSubscriberSetting']['date_format'];
			$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
			$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
			$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
			
			
			$this->set(compact('dateFormat','showAddButton'));
			if($this->data){
				$this->loadModel('SbsSubscriberTax');
				$this->loadModel('SbsSubscriberTaxGroup');
				$this->loadModel('SbsSubscriberTaxGroupMapping');
				$this->loadModel('AcrInvoiceDetail');
				$this->loadModel('InvInventory');
				
				$this->loadModel('AcrClient');
				if((($_FILES['file']['type'] == 'application/vnd.ms-excel') || ($_FILES['file']['type'] == 'application/octet-stream'))){
					$fileOK = $this->uploadFiles('files', $_FILES);
					if($fileOK['urls']['0']){
						$excel = new Spreadsheet_Excel_Reader;
						$excel->read($fileOK['urls']['0']);
						$nr_sheets = count($excel->sheets);
						$excel_data = '';
						$sheetOrderProvided = array(
	   							'0'=>'Instruction Sheet',
	   							'1'=>'Invoice Informations',
	   							'2'=>'Item Informations'
	   						);
	   					foreach($sheetOrderProvided as $key1=>$val1){
	   						
	   						if($excel->boundsheets[$key1]['name'] != $val1){
	   							$sheetNameOrder = 1;
	   						}
	   					}
	   					if((!$sheetNameOrder)){
	   						$totalCountAfterImport = $presentCustCount + $excel->sheets['1']['numRows'] -1;
								if($noofcustomers['CpnSubscriptionPlan']['no_of_invoices'] >= $totalCountAfterImport) {
									$showAddButton = TRUE;
								} else {
									$showAddButton = FALSE;
								}
								if($noofcustomers['CpnSubscriptionPlan']['no_of_invoices'] == -1) {
									$showAddButton = TRUE;
								}
								if(!$showAddButton){
									$this->Session->setFlash(('<div class="alert alert-danger">'.__('Maximum limit is '.$noofcustomers['CpnSubscriptionPlan']['no_of_invoices'].'.You are trying to exceed the highest limit').'</div>'));
								}else{
									for($i=1; $i<$nr_sheets; $i++) {
			   							if($excel->boundsheets[$i]['name'] == 'Invoice Informations'){
			   								$invoiceInformation = $this->sheetData($excel->sheets[$i],$excel->boundsheets[$i]['name']) ;
			   							}elseif($excel->boundsheets[$i]['name'] == 'Item Informations'){
			   								$invoiceDetailInformation = $this->sheetData($excel->sheets[$i],$excel->boundsheets[$i]['name']) ;
			   							}
			   						}
			   						if($invoiceDetailInformation){
			   							foreach($invoiceDetailInformation as $key=>$val){
			   								$lineTotal[$key] = $this->getLineTotal('0',$val['Quantity *'],$val['Unit Rate *'],$val['Discount']);
			   								
			   								$invoiceDetailArray[$val['Invoice Number *']][$key]['quantity'] 				= $val['Quantity *'];
			   								$invoiceDetailArray[$val['Invoice Number *']][$key]['unit_rate'] 				= $val['Unit Rate *'];
			   								$invoiceDetailArray[$val['Invoice Number *']][$key]['discount'] 				= $val['Discount'];
			   								if($val['Tax']){
			   									$invoiceDetailArray[$val['Invoice Number *']][$key]['tax'] 				= $val['Tax'];
			   								}elseif($val['Tax Group']){
			   									$invoiceDetailArray[$val['Invoice Number *']][$key]['taxgroup'] 			= $val['Tax Group'];
			   								}
			   								
			   								$invoiceDetailArray[$val['Invoice Number *']][$key]['lineTotal'] 				= $lineTotal[$key];
			   								$invoiceDetailArray[$val['Invoice Number *']][$key]['inv_inventory_id'] 		= $val['Item'];
			   								$invoiceDetailArray[$val['Invoice Number *']][$key]['inventory_description']	= $val['Item Description'];
			   								if($val['Tax']){
			   									$taxDetail = $this->SbsSubscriberTax->getTaxById($val['Tax']);
			   									$tax[$val['Invoice Number *']] =$tax[$val['Invoice Number *']] + (($lineTotal[$key]*$taxDetail['SbsSubscriberTax']['percent'])/100);
			   								}elseif($val['Tax Group']){
			   									$taxGroupDetail = $this->SbsSubscriberTaxGroup->getGroupInfo($val['Tax Group'],$this->subscriber);
			   									if($taxGroupDetail['SbsSubscriberTaxGroup']['compounded'] == 'Y'){
			   										$groupMapping = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($val['Tax Group']);
			   										$lineTotal = $lineTotal[$key];
			   										foreach($groupMapping as $groupMappingKey => $groupMappingVal){
			   											$taxAmount = ($lineTotal*$groupMappingVal['SbsSubscriber']['percent'])/100;
			   											$tax[$val['Invoice Number *']] = $tax[$val['Invoice Number *']] + $taxAmount;
			   											$lineTotal = $lineTotal + $taxAmount;
			   										}
			   									}else{
			   										$groupMapping = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($val['Tax Group']);
			   										$lineTotal = $lineTotal[$key];
			   										foreach($groupMapping as $groupMappingKey => $groupMappingVal){
			   											$taxAmount = ($lineTotal*$groupMappingVal['SbsSubscriber']['percent'])/100;
			   											$tax[$val['Invoice Number *']] = $tax[$val['Invoice Number *']] + $taxAmount;
			   										}
			   									}
			   								}
			   								$subTotal[$val['Invoice Number *']] = $subTotal[$val['Invoice Number *']] + $lineTotal[$key];
			   								$invoiceAmount[$val['Invoice Number *']] = $subTotal[$val['Invoice Number *']] + $tax[$val['Invoice Number *']];
			   							}
										
			   							if($invoiceInformation){
			   								
			   								$this->loadModel('AcrInvoiceCustomField');
			   								$this->loadModel('AcrInvoiceCustomValue');
			   								$invoiceImportCount = 0;
			   								$getCustomFields = $this->AcrInvoiceCustomField->getFieldList($this->subscriber);
			   								foreach($invoiceInformation as $invoiceKey => $invoiceVal){
			   									if($invoiceVal['Invoice Number *']){
			   										if($invoiceVal['Customer Organization Name *']){
				   										if($invoiceVal['Payment Term *']){
				   											if($invoiceVal['Currency Code *']){
				   												$getClientCurrencyDetails = $this->AcrClient->getClientCurrency($invoiceVal['Customer Organization Name *']);
																$retrieveClientCurrency = $this->CpnCurrency->getCurrencyById($getClientCurrencyDetails['AcrClient']['cpn_currency_id']);
																if($retrieveClientCurrency['CpnCurrency']['code'] == $invoiceVal['Currency Code *']){
																	if($invoiceVal['Invoiced Date *']){
				   													if($subTotal[$invoiceVal['Invoice Number *']]){
				   														$invoiceExist = $this->AcrClientInvoice->getInvoiceByInvoiceNumber($invoiceVal['Invoice Number *'],$this->subscriber);
				   														if(!$invoiceExist){
				   															$data['invoice_number'] 				= $invoiceVal['Invoice Number *'];
				   															$data['description'] 					= $invoiceVal['Description'];
				   															$data['invoiced_date'] 					= str_replace('/', '-', $invoiceVal['Invoiced Date *']);
				   															$data['purchase_order_no'] 				= $invoiceVal['Purchase Order Number'];
				   															$data['due_date'] 						= str_replace('/', '-',$invoiceVal['Due Date']);
				   															$data['status'] 						= 'Draft';
				   															$data['notes'] 							= $invoiceVal['Notes'];
				   															$data['term_conditions'] 				= $invoiceVal['Term and Conditions'];
				   															$data['sub_total'] 						= $subTotal[$invoiceVal['Invoice Number *']];
				   															$data['tax_total'] 						= $tax[$invoiceVal['Invoice Number *']];
				   															if((!$invoiceVal['Exchange Rate *']) || ($defaultCurrencyCode == $invoiceVal['Currency Code *'])){
					   															$invoiceVal['Exchange Rate *'] = 1;
					   														}
				   															$data['func_currency_total'] 			= ($invoiceAmount[$invoiceVal['Invoice Number *']]);
				   															$data['exchange_rate'] 					= $invoiceVal['Exchange Rate *'];
				   															$data['recurring'] 						= 'N';
				   															$data['pdf_generated'] 					= 'No';
				   															$data['acr_client_id'] 					= $invoiceVal['Customer Organization Name *'];
				   															$data['sbs_subscriber_id'] 				= $this->subscriber;
				   															$data['sbs_subscriber_payment_term_id'] = $invoiceVal['Payment Term *'];
				   															$data['invoice_total'] 					= ($invoiceAmount[$invoiceVal['Invoice Number *']]/$invoiceVal['Exchange Rate *']);
				   															$data['defaultCurrencyId'] 			= $invoiceVal['Currency Code *'];
				   															$data['updated_date'] 					= date('Y-m-d');
				   															$saveData = $this->AcrClientInvoice->addInvoice($data);
				   															if($saveData){
				   																$invoiceImportCount++;
				   																$fileUploadSuccess = 1;
				   																foreach($invoiceDetailArray[$invoiceVal['Invoice Number *']] as $invDetKey=>$invDetVal){
				   																	$invoiceDetailData['inventory_description'] 		= $invDetVal['inventory_description'];
				   																	$invoiceDetailData['quantity'] 						= $invDetVal['quantity'];
				   																	$invoiceDetailData['unit_rate'] 					= $invDetVal['unit_rate'];
				   																	$invoiceDetailData['discount_percent'] 				= $invDetVal['discount'];
				   																	$invoiceDetailData['line_total'] 					= $invDetVal['lineTotal'];
				   																	$invoiceDetailData['acr_client_invoice_id'] 		= $saveData;
																					if($invDetVal['inv_inventory_id']){
																						$invoiceDetailData['inv_inventory_id'] 				= $invDetVal['inv_inventory_id'];
																					}else{
																						$invoiceDetailData['inv_inventory_id'] = -1;
																					}
				   																	
				   																	if($invDetVal['tax']){
				   																		$invoiceDetailData['sbs_subscriber_tax_id'] 		= $invDetVal['tax'];
				   																	}elseif($invDetVal['taxgroup']){
				   																		$invoiceDetailData['sbs_subscriber_tax_group_id'] 	= $invDetVal['taxgroup'];
				   																	}
				   																	$saveDetail = $this->AcrInvoiceDetail->addInvoiceDetail($invoiceDetailData);
				   																	if($saveDetail){
				   																		$updateInventoryStock = $this->InvInventory->updateStock($invDetVal['inv_inventory_id'],$invDetVal['quantity']);
				   																	}
				   																}
				   																$i = 1;
				   																foreach($getCustomFields as $customFieldId=>$customFieldVal){
				   																	if($customFieldVal){
																						$customData['acr_invoice_custom_field_id'] = $customFieldId;
																						$customData['acr_client_invoice_id']	   = $saveData;
																						$customData['data'] 					   = $invoiceVal['Custom Field '.$i];
																						if($customData['data']){
																							$addValue = $this->AcrInvoiceCustomValue->addValue($customData);
																						}
																						$i++;
																					}
				   																}
				   															}
				   														}else{
				   															$errorMessage[$invoiceKey]['Invoice Number'] 			 =  $invoiceVal['Invoice Number *'];
				   															$errorMessage[$invoiceKey]['Invoiced Date'] 			 =  $invoiceVal['Invoiced Date *'];
				   															$errorMessage[$invoiceKey]['Error Message'] 			 =  'Duplicate invoice cannot be created.';
				   														}
				   													}else{
				   														$errorMessage[$invoiceKey]['Invoice Number'] 			 =  $invoiceVal['Invoice Number *'];
				   														$errorMessage[$invoiceKey]['Invoiced Date'] 			 =  $invoiceVal['Invoiced Date *'];
				   														$errorMessage[$invoiceKey]['Error Message'] 			 =  'There are no invoice detail.';
				   													}
				   													
				   												}else{
				   													$errorMessage[$invoiceKey]['Invoice Number'] 			 =  $invoiceVal['Invoice Number *'];
				   													$errorMessage[$invoiceKey]['Invoiced Date'] 			 =  $invoiceVal['Invoiced Date *'];
				   													$errorMessage[$invoiceKey]['Error Message'] 			 =  'Please enter a valid invoice date.';
				   												}
																}else{
																	$errorMessage[$invoiceKey]['Invoice Number'] 			 =  $invoiceVal['Invoice Number *'];
				   													$errorMessage[$invoiceKey]['Invoiced Date'] 			 =  $invoiceVal['Invoiced Date *'];
				   													$errorMessage[$invoiceKey]['Error Message'] 			 =  'Client currency doesnot match.';
																}
				   												
				   											}else{
				   												$errorMessage[$invoiceKey]['Invoice Number'] 			 =  $invoiceVal['Invoice Number *'];
				   												$errorMessage[$invoiceKey]['Invoiced Date'] 			 =  $invoiceVal['Invoiced Date *'];
				   												$errorMessage[$invoiceKey]['Error Message'] 			 =  'Currency Code does not exist.';
				   											}
				   										}else{
				   											$errorMessage[$invoiceKey]['Invoice Number'] 			 =  $invoiceVal['Invoice Number *'];
				   											$errorMessage[$invoiceKey]['Invoiced Date'] 			 =  $invoiceVal['Invoiced Date *'];
				   											$errorMessage[$invoiceKey]['Error Message'] 			 =  'Payment Term does not exist.';
				   										}
				   									}else{
				   										$errorMessage[$invoiceKey]['Invoice Number'] 			 =  $invoiceVal['Invoice Number *'];
				   										$errorMessage[$invoiceKey]['Invoiced Date'] 			 =  $invoiceVal['Invoiced Date *'];
				   										$errorMessage[$invoiceKey]['Error Message'] 			 =  'Customer does not exist in the system.';
				   									}
			   									}
			   									
			   								 
			   								}
			   								$this->set(compact('invoiceImportCount','errorMessage','fileUploadSuccess'));
			   							}
			   						}
								}
	   						
	   					}else{
	   						$this->Session->setFlash(('<div class="alert alert-danger">'.__('Please use the default excel format,sheet name and sheet order').'</div>'));
	   					}
					}
				}
				$documentPath = WWW_ROOT.$fileOK['urls']['0'];
				unlink($documentPath);
			}
		}
		
		public function sheetData($sheet,$sheetName) {
			$this->loadModel('AcrClient');
			$this->loadModel('SbsSubscriberPaymentTerm');
			$this->loadModel('CpnCurrency');
			$this->loadModel('InvInventory');
			$this->loadModel('SbsSubscriberTax');
			$this->loadModel('SbsSubscriberTaxGroup');
			
			$fieldsArray = $sheet['cells']['1'];
			$countRecords = count($sheet['cells']);
			foreach($fieldsArray as $key=>$val){
				for($i=2;$i<=$countRecords;$i++){
						if($sheetName == 'Invoice Informations'){
							if($sheet['cells'][$i][$key]){
							if($val=='Invoice Number *'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}elseif($val=='Description'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}elseif($val=='Customer Organization Name *'){
								$clientId = $this->AcrClient->getClientIdByOrganisationName($sheet['cells'][$i][$key],$this->subscriber);
								if($clientId){
									$dataInvoice[$i][$val] = $clientId;
								}
							}
							elseif($val=='Invoiced Date *'){
								$dataInvoice[$i][$val] = date('Y-m-d',strtotime(str_replace('/', '-',$sheet['cells'][$i][$key])));
							}
							elseif($val=='Due Date'){
								$dataInvoice[$i][$val] = date('Y-m-d',strtotime(str_replace('/', '-',$sheet['cells'][$i][$key])));
							}
							elseif($val=='Purchase Order Number'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}
							elseif($val=='Payment Term *'){
								$paymentTermId = $this->SbsSubscriberPaymentTerm->getTermsByName($sheet['cells'][$i][$key],$this->subscriber);
								if($paymentTermId){
									$dataInvoice[$i][$val] = $paymentTermId;
								}
							}
							elseif($val=='Notes'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}
							elseif($val=='Term and Conditions'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}
							elseif($val=='Exchange Rate *'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}
							elseif($val=='Currency Code *'){
								$currencyCode = $this->CpnCurrency->getCurrencyIdByCurrencyCode($sheet['cells'][$i][$key]);
								if($currencyCode){
									$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
								}
							}
							elseif($val=='Custom Field 1'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}
							elseif($val=='Custom Field 2'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}
							elseif($val=='Custom Field 3'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}
							elseif($val=='Custom Field 4'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}
							elseif($val=='Custom Field 5'){
								$dataInvoice[$i][$val] = $sheet['cells'][$i][$key];
							}else{
			 					$dataInvoice[$i]['fieldMissing'] = '1';
			 				}
			 				}
						}
						if($sheetName == 'Item Informations'){
							if($sheet['cells'][$i][$key]){
							if($val=='Invoice Number *'){
		 							$dataInvoiceDetail[$i][$val] = $sheet['cells'][$i][$key];
		 						
			 				}elseif($val=='Item'){
			 					$getInventoryId = $this->InvInventory->getInventoryByName($sheet['cells'][$i][$key],$this->subscriber);
			 					if($getInventoryId){
			 						$dataInvoiceDetail[$i][$val] = $getInventoryId;
			 					}else{
			 						$dataInvoiceDetail[$i][$val] = '-1';
			 					}
			 				}elseif($val=='Item Description'){
			 					$dataInvoiceDetail[$i][$val] = $sheet['cells'][$i][$key];
			 				}elseif($val=='Quantity *'){
			 					$dataInvoiceDetail[$i][$val] = $sheet['cells'][$i][$key];
			 				}elseif($val=='Unit Rate *'){
			 					$dataInvoiceDetail[$i][$val] = $sheet['cells'][$i][$key];
			 				}elseif($val=='Discount'){
			 					$dataInvoiceDetail[$i][$val] = $sheet['cells'][$i][$key];
			 				}
			 				elseif($val=='Tax'){
			 					$taxId = $this->SbsSubscriberTax->getTaxByName($sheet['cells'][$i][$key],$this->subscriber);
			 					if($taxId){
			 						$dataInvoiceDetail[$i][$val] = $taxId;
			 					}
			 				}elseif($val=='Tax Group'){
			 					$taxId = $this->SbsSubscriberTaxGroup->getTaxGroupByName($sheet['cells'][$i][$key],$this->subscriber);
			 					if($taxId){
			 						$dataInvoiceDetail[$i][$val] = $taxId;
			 					}
			 				}/*
							 elseif($val=='Amount'){
															  $dataInvoiceDetail[$i][$val] = $sheet['cells'][$i][$key];
														  }*/
							 else{
			 					$dataInvoiceDetail[$i]['fieldMissing'] = '1';
			 				}
			 				}
						}
				}
			}
			if($dataInvoice){
		 		return $dataInvoice;
		 	}elseif($dataInvoiceDetail){
		 		return $dataInvoiceDetail;
		 	}else{
		 		return false;
		 	}
		}
		
		public function exportInvoices(){
			
		}
		public function deleteRow($invoiceId = null,$invoiceDetailId = null){
			if($invoiceDetailId){
				$this->loadModel('AcrInvoiceDetail');
				$this->AcrInvoiceDetail->id = $invoiceDetailId;
				$getInvoiceDetail = $this->AcrInvoiceDetail->getDetailByID($invoiceDetailId);
				$lineTotal = $getInvoiceDetail['AcrInvoiceDetail']['line_total'];
				
				if($getInvoiceDetail['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']){
							$this->loadModel('SbsSubscriberTaxGroupMapping');
							$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($getInvoiceDetail['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']);
							foreach($groupTaxMap as $key=>$val1){
								$taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['name'];
								if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
									$taxAmount = ($lineTotal*$val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									$product = $product + $taxAmount;
								}else{
									$taxAmount = ($rate * $val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									$product = $product + $taxAmount;
								}
							}
						}elseif($getInvoiceDetail['AcrInvoiceDetail']['sbs_subscriber_tax_id']){
							$this->loadModel('SbsSubscriberTax');
							$taxDetails = $this->SbsSubscriberTax->getTaxById($getInvoiceDetail['AcrInvoiceDetail']['sbs_subscriber_tax_id']);
							if($taxDetails){
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['name'];
								$taxAmount = ($lineTotal * $taxDetails['SbsSubscriberTax']['percent'])/100;
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
								$product = $product + ($lineTotal * $taxDetails['SbsSubscriberTax']['percent'])/100;
							}
						}
					foreach($taxArray as $taxId => $taxValue){
						$totalTaxOnItem = $totalTaxOnItem + $taxValue['taxAmount'];
					}
					$invoiceTotal = $lineTotal + $totalTaxOnItem;
					$invoiceData  = $this->AcrClientInvoice->getInvoiceDetailsById($invoiceId);
					$data['id']				= $invoiceId;
					$data['subTotal'] 				= $invoiceData['AcrClientInvoice']['sub_total'] - $lineTotal;
					$data['taxTotal'] 				= $invoiceData['AcrClientInvoice']['tax_total'] - $totalTaxOnItem;
					$data['func_currency_total'] 	= $invoiceData['AcrClientInvoice']['func_currency_total'] - $totalTaxOnItem - $lineTotal;
					if($invoiceData['AcrClientInvoice']['exchange_rate']){
						$data['invoice_total'] 			= $data['func_currency_total'] * $invoiceData['AcrClientInvoice']['exchange_rate'];
					}else{
						$data['invoice_total'] 			= $data['func_currency_total'] * 1;
					}
				if($this->AcrInvoiceDetail->delete()){
					$updateTotal = $this->AcrClientInvoice->updateTotal($data);
				}
				
			}
		}
		
		public function deleteRow1($rowId,$invoiceDetailId){
			if($invoiceDetailId){
				$this->loadModel('AcrInvoiceDetail');
				$this->AcrInvoiceDetail->id = $invoiceDetailId;
				$getInvoiceDetail = $this->AcrInvoiceDetail->getDetailByID($invoiceDetailId);
				$lineTotal = $getInvoiceDetail['AcrInvoiceDetail']['line_total'];
				
				if($getInvoiceDetail['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']){
							$this->loadModel('SbsSubscriberTaxGroupMapping');
							$groupTaxMap = $this->SbsSubscriberTaxGroupMapping->getGroupMapping($getInvoiceDetail['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']);
							foreach($groupTaxMap as $key=>$val1){
								$taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['name'];
								if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
									$taxAmount = ($lineTotal*$val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									$product = $product + $taxAmount;
								}else{
									$taxAmount = ($rate * $val1['SbsSubscriberTax']['percent'])/100;
									$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
									$product = $product + $taxAmount;
								}
							}
						}elseif($getInvoiceDetail['AcrInvoiceDetail']['sbs_subscriber_tax_id']){
							$this->loadModel('SbsSubscriberTax');
							$taxDetails = $this->SbsSubscriberTax->getTaxById($getInvoiceDetail['AcrInvoiceDetail']['sbs_subscriber_tax_id']);
							if($taxDetails){
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['name'];
								$taxAmount = ($lineTotal * $taxDetails['SbsSubscriberTax']['percent'])/100;
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
								$product = $product + ($lineTotal * $taxDetails['SbsSubscriberTax']['percent'])/100;
							}
						}
					foreach($taxArray as $taxId => $taxValue){
						$totalTaxOnItem = $totalTaxOnItem + $taxValue['taxAmount'];
					}
					$invoiceTotal = $lineTotal + $totalTaxOnItem;
					$invoiceData  = $this->AcrClientInvoice->getInvoiceDetailsById($getInvoiceDetail['AcrInvoiceDetail']['acr_client_invoice_id']);
					$data['id']						= $getInvoiceDetail['AcrInvoiceDetail']['acr_client_invoice_id'];
					$data['subTotal'] 				= $invoiceData['AcrClientInvoice']['sub_total'] - $lineTotal;
					$data['taxTotal'] 				= $invoiceData['AcrClientInvoice']['tax_total'] - $totalTaxOnItem;
					$data['func_currency_total'] 	= $invoiceData['AcrClientInvoice']['func_currency_total'] - $totalTaxOnItem - $lineTotal;
					if($invoiceData['AcrClientInvoice']['exchange_rate']){
						$data['invoice_total'] 			= $data['func_currency_total'] * $invoiceData['AcrClientInvoice']['exchange_rate'];
					}else{
						$data['invoice_total'] 			= $data['func_currency_total'] * 1;
					}
				if($this->AcrInvoiceDetail->delete()){
					$updateTotal = $this->AcrClientInvoice->updateTotal($data);
				}
				
			}
		}
		public function export(){
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
						if($fromDate) $fromDate	  = date('Y-m-d', strtotime($fromDate));
						if(!empty($this->request->data['InvoiceFilter']['toDate']))
							$toDate       = trim($this->request->data['InvoiceFilter']['toDate']);
						if($toDate)   $toDate	  = date('Y-m-d', strtotime($toDate));
						
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
								$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Invoice Date']				=	date($dateFormat,strtotime($acrClientInvoice['AcrClientInvoice']['invoiced_date']));
							}
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Invoice ID']						=	$acrClientInvoice['AcrClientInvoice']['id'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Invoice Number']					=	$acrClientInvoice['AcrClientInvoice']['invoice_number'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Invoice Status']					=	$acrClientInvoice['AcrClientInvoice']['status'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Customer Name']					=	$acrClientInvoice['AcrClient']['organization_name'];
							$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Customer ID']					=	$acrClientInvoice['AcrClient']['id'];
							if($acrClientInvoice['AcrClientInvoice']['due_date']){
								$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Due Date']					=	date($dateFormat,strtotime($acrClientInvoice['AcrClientInvoice']['due_date']));
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
								$finalArray[$invoiceDetail['AcrInvoiceDetail']['id']]['Last Payment Date']				=	date($dateFormat,strtotime($lastPaymentDate));
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
		public function downloadLinkRaw(){
					$this->viewClass = 'Media';
		        	$params = array(
		            	'id'        => 'invoice.xls',
		           	 	'name'      => 'invoices',
		            	'download'  => true,
		            	'extension' => 'xls',
		            	'path'      => 'files'.DS
		        	);
		        	$this->set($params);
				}
		public function getDefaultPaymentTerm(){
			$this->loadModel('SbsSubscriberPaymentTerm');
			$this->loadModel('AcrClient');
			$paymentTerm = $this->SbsSubscriberPaymentTerm->getPaymentTermsBySubscriber($this->subscriber);
			$getCustomerPaymentTerm = $this->AcrClient->find('first',array('conditions'=>array('AcrClient.id'=>$this->data['AcrClientInvoice']['acr_client_id'],'AcrClient.sbs_subscriber_id'=>$this->subscriber),'fields'=>array('AcrClient.sbs_subscriber_payment_term_id')));
			if($getCustomerPaymentTerm['AcrClient']['sbs_subscriber_payment_term_id']){
				$defaultPaymentTermId	=	$getCustomerPaymentTerm['AcrClient']['sbs_subscriber_payment_term_id'];
			}else{
				$defaultPaymentTerm = $this->SbsSubscriberPaymentTerm->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$this->subscriber,'SbsSubscriberPaymentTerm.is_default'=>'Y'),'fields'=>array('SbsSubscriberPaymentTerm.id')));
				if($defaultPaymentTerm){
					$defaultPaymentTermId	=	$defaultPaymentTerm['SbsSubscriberPaymentTerm']['id'];
				}else{
					$defaultPaymentTermId ='';
				}
			}
			
			$this->set(compact('paymentTerm','defaultPaymentTermId'));
		}
		
		
		public function payment_gateway_email(){
			 
			$this->loadModel('CpnPaymentMethod');
			$this->loadModel('SbsPaymentMethodValue');
			$this->loadModel('CpnPaymentMethodAttribute');
			
			$method = $this->CpnPaymentMethod->find('first',array('conditions'=>array('CpnPaymentMethod.payment_option_name'=>'Paypal'),'fields'=>array('id')));
			$methodAttribute = $this->CpnPaymentMethodAttribute->find('first',array('conditions'=>array('CpnPaymentMethodAttribute.cpn_payment_method_id'=>$method['CpnPaymentMethod']['id'],'CpnPaymentMethodAttribute.attribute'=>'PayPal Email'),'fields'=>array('id')));
			$methodValues    = $this->SbsPaymentMethodValue->find('first',array('conditions'=>array('SbsPaymentMethodValue.cpn_payment_method_id'=>$method['CpnPaymentMethod']['id'],'SbsPaymentMethodValue.subscriber_id'=>$this->subscriber,'SbsPaymentMethodValue.cpn_payment_attribute_id'=>$methodAttribute['CpnPaymentMethodAttribute']['id']),'fields'=>array('value')));
			if($methodValues['SbsPaymentMethodValue']['value']){
				return $methodValues['SbsPaymentMethodValue']['value'];
			}else{
				return false;
			}
			
		}
		
}
