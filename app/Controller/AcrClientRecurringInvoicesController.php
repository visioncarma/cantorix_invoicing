<?php
App::uses('AppController', 'Controller');
/**
 * AcrClientRecurringInvoices Controller
 *
 * @property AcrClientRecurringInvoice $AcrClientRecurringInvoice
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AcrClientRecurringInvoicesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Email', 'RequestHandler', 'Session');
	public function beforeFilter() {
        parent::beforeFilter();
       // $this->Auth->allow('login','inactive');
       
       $this->layout = "sbs_layout";
       $this->permission = $this->Session->read('Auth.AllPermissions.Recurring Invoices');
	   $this->inventoryPermission = $this->Session->read('Auth.AllPermissions.Inventories');
       $this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
	   $invoicesActive = 'active';
		$menuActive = 'Recurring Invoices';
		$this->set(compact('invoicesActive','menuActive'));
      
    }

/**
 * index method
 *
 * @return void
 */
	public function index($filterAction = 0, $filterValue = 0, $filterValue1 = 0, $filterValue2 = 0, $isRecurring = 0, $status = 0, $fromDate = 0, $toDate = 0, $page = 1) {
		$permission = $this->permission;
		$inventoryPermission = $this->inventoryPermission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('AcrClientInvoice');
		$this->AcrClientRecurringInvoice->recursive = 0;
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$limit 			= $settings['SbsSubscriberSetting']['lines_per_page'];
		
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
			$this->request->data['InvoiceFilter']['fromDate'] 		= str_replace('/','-',$fromDate);
		}
		if(trim($toDate)) {
			$this->request->data['InvoiceFilter']['toDate'] 		= str_replace('/','-',$toDate);
		}		
		if($this->data['InvoiceFilter']){
			
			$filterAction = trim($this->request->data['InvoiceFilter']['filterAction']);
			if($filterAction == 'invoice_number'){
				$invoice_number = trim($this->request->data['InvoiceFilter']['filterValue']);
				$filterValue = trim($this->request->data['InvoiceFilter']['filterValue']);
				
			} elseif($filterAction == 'customer_name') {
				$customer_name   = trim($this->request->data['InvoiceFilter']['filterValue']);
				$filterValue = trim($this->request->data['InvoiceFilter']['filterValue']);
			} elseif($filterAction == 'amount') {
				$min_amount  	= trim($this->request->data['InvoiceFilter']['filterValue1']);
				$max_amount  	= trim($this->request->data['InvoiceFilter']['filterValue2']);
				$filterValue1 = $min_amount;
				$filterValue2 = $max_amount;
			} 	
			
			$isRecurring  = trim($this->request->data['InvoiceFilter']['isRecurring']);			
			$status       = trim($this->request->data['InvoiceFilter']['status']);			
			$fromDate     = trim($this->request->data['InvoiceFilter']['fromDate']);
			if($fromDate) $fromDate	  = date('Y-m-d', strtotime(str_replace('/', '-', $fromDate)));
			$toDate       = trim(str_replace('/','-',$this->request->data['InvoiceFilter']['toDate']));
			if($toDate)   $toDate	  = date('Y-m-d', strtotime(str_replace('/', '-', $toDate)));
			
			// server side validation
			if(empty($filterAction) && empty($status) && empty($isRecurring) && empty($fromDate) && empty($toDate)) {
				$this->Session->setFlash('<div class="alert alert-info">Please Enter Atleast One Search Term.</div>');
				//return;				
			}
			if(!empty($filterAction) && $filterAction == 'amount' && (empty($min_amount) && empty($max_amount)) ) {
				$this->Session->setFlash('<div class="alert alert-info">Are You Trying To Filter By Invoice Amount Range, Please Enter Amount Value Range.</div>');
				//return;				
			}
			if(!empty($filterAction) && ($filterAction == 'invoice_number' || $filterAction == 'customer_name') ) {				
				if ($filterAction == 'invoice_number' && empty($invoice_number)) {
					$this->Session->setFlash('<div class="alert alert-info">Are You Trying To Filter By Invoice Number, Please Enter term related to Invoice Number.</div>');
					//return;					
				} elseif ($filterAction == 'customer_name' && empty($customer_name)) {
					$this->Session->setFlash('<div class="alert alert-info">Are You Trying To Filter By Customer Name, Please Enter term related to Customer Name.</div>');
					//return;					
				}				
			} //
			
			$condition_array = null; $filterAction_array = null; $isRecurring_array = null; $status_array = null; $invoice_date_array = null;
			
			if($filterAction) {
				if($filterAction == 'invoice_number' && $invoice_number){
					 $filterAction_array   =	array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.invoice_number LIKE'=> '%'.$invoice_number.'%','AcrClientInvoice.recurring'=>'Y');
					
				} elseif($filterAction == 'customer_name' && $customer_name) {
					$filterAction_array   =	array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClient.client_name LIKE'=> '%'.$customer_name.'%','AcrClientInvoice.recurring'=>'Y');
					
				}elseif($filterAction == 'amount' && $min_amount && !$max_amount){
					$filterAction_array   =	array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.invoice_total >='=>$min_amount,'AcrClientInvoice.recurring'=>'Y');
				}elseif($filterAction == 'amount' && !$min_amount && $max_amount){
					$filterAction_array   =	array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.invoice_total <='=>$max_amount,'AcrClientInvoice.recurring'=>'Y');
				}
				 elseif($filterAction == 'amount' && ($min_amount && $max_amount)) {					
					$filterAction_array   =	array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.invoice_total BETWEEN ? and ?'=>array($min_amount,$max_amount),'AcrClientInvoice.recurring'=>'Y');
				} 
			}			
			/*if($isRecurring) $isRecurring_array 		 =	array('AcrClientInvoice.recurring' => $isRecurring);*/
			if($status) $status_array 					 =	array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientRecurringInvoice.status' => $status,'AcrClientInvoice.recurring'=>'Y');
			if($fromDate && $toDate) $invoice_date_array =	array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.invoiced_date BETWEEN ? and ?'=>array($fromDate,$toDate),'AcrClientInvoice.recurring'=>'Y');
			if($filterAction_array || $isRecurring_array || $status_array || $invoice_date_array){
				$conditions = array($filterAction_array, $isRecurring_array, $status_array, $invoice_date_array);	
			}else{
				$conditions 			= array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.recurring'=>'Y');
			}
			
			
			
		} else {
			$conditions 			= array('AcrClientInvoice.sbs_subscriber_id'=>$this->subscriber,'AcrClientInvoice.recurring'=>'Y');
		}		
		$this->AcrClientInvoice->unbindModel(array('belongsTo'=>array('SbsSubscriberPaymentTerm','SbsSubscriber')));
		$this->Paginator->settings = array('conditions'=>$conditions,'limit'=>$limit,'page'	=> $page,'order'=>array('AcrClientInvoice.id' => 'DESC'),
				'fields'=>array('AcrClientRecurringInvoice.*','AcrClientInvoice.id','AcrClientInvoice.invoice_number','AcrClientInvoice.invoiced_date','AcrClientInvoice.invoice_total','AcrClientInvoice.sbs_subscriber_id',
					'AcrClientInvoice.status','AcrClientInvoice.invoice_currency_code','AcrClientInvoice.pdf_generated','AcrClientInvoice.recurring'/*,'AcrClient.client_name','AcrClient.id'*/));
			
		$this->set('acrClientInvoices', $this->Paginator->paginate('AcrClientRecurringInvoice'));
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$this->set(compact('inventoryPermission','dateFormat','filterAction','filterValue','filterValue1','filterValue2','isRecurring','status','fromDate','toDate'));
	}	

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null,$filterAction = 0, $filterValue = 0, $filterValue1 = 0, $filterValue2 = 0,$isRecurring,$status = 0,$fromDate = 0,$toDate = 0,$page) {
		$permission = $this->permission;
		$inventoryPermission = $this->inventoryPermission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrInvoiceCustomField');
		$this->loadModel('AcrInvoiceCustomValue');
		if (!$this->AcrClientRecurringInvoice->exists($id)) {
			throw new NotFoundException(__('Invalid invoice'));
		}
		$options = array('conditions' => array('AcrClientRecurringInvoice.' . $this->AcrClientRecurringInvoice->primaryKey => $id));
		$acrClientRecurringInvoice = $this->AcrClientRecurringInvoice->find('first', $options);
		if($acrClientRecurringInvoice){
			$this->loadModel('AcrClientInvoice');
			$this->loadModel('AcrInvoiceDetail');
			$this->loadModel('SbsSubscriberOrganizationDetail');
			$invoiceData	= $this->AcrClientInvoice->getInvoiceDetailsById($acrClientRecurringInvoice['AcrClientRecurringInvoice']['acr_client_invoice_id']);	
			$invoiceDetail = $this->AcrInvoiceDetail->getInvoiceDetails($invoiceData['AcrClientInvoice']['id']);
			$taxArray = $this->getTaxCalculation($invoiceDetail);
			$subscriberOrganisationDetail = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($invoiceData['SbsSubscriber']['sbs_subscriber_organization_detail_id']);
		}
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$defaultCurrencyInfo 	= $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
		$defaultCurrency 	 = $defaultCurrencyInfo['CpnCurrency']['code'];
		$getCustomFields = $this->AcrInvoiceCustomField->getFieldList($this->subscriber);
		$getCustomFieldsVal = $this->AcrInvoiceCustomValue->getFieldValueByInvoiceId($invoiceData['AcrClientInvoice']['id']);
		$this->set(compact('dateFormat','defaultCurrency','taxArray','getCustomFields','getCustomFieldsVal'));
		$this->set(compact('filterAction','filterValue','filterValue1','filterValue2','isRecurring','status','fromDate','toDate','page'));
		$this->set(compact('inventoryPermission','acrClientRecurringInvoice','invoiceDetail','invoiceData','subscriberOrganisationDetail'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$permission = $this->permission;
		$inventoryPermission = $this->inventoryPermission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('InvInventory');
		$this->loadModel('AcrClient');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$this->loadModel('SbsSubscriberPaymentTerm');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrInvoiceCustomField');
		$this->loadModel('InvInventoryUnitType');
		
		if ($this->request->is('post')) {
			if(!empty($this->data['AcrClientInvoice']['inventory'])){
				$invoiceDetail['invoice_number'] 		= $this->data['AcrClientInvoice']['recurring_invoice_no'];
				$invoiceDetail['purchase_order_no'] 	= $this->data['AcrClientInvoice']['purchase_order_no'];
				$invoiceDetail['invoice_description'] 	= $this->data['AcrClientInvoice']['invoice_description'];
				$invoiceDetail['acr_client_id'] 		= $this->data['AcrClientInvoice']['acr_client_id'];
				$subscriberCurrency = $this->CpnCurrency->getCurrencyById($this->data['AcrClientInvoice']['cpn_currency_id']);
				$invoiceDetail['defaultCurrencyId'] 	= $subscriberCurrency['CpnCurrency']['code'];//Invoiced Currency
				$invoiceDetail['conversionValue'] 		= $this->data['AcrClientInvoice']['conversionValue'];
				$invoiceDetail['recurring'] 			= 'Y';
				$invoiceDetail['invoiced_date'] 		= str_replace('/','-',$this->data['AcrClientInvoice']['start_date']);
				$invoiceDetail['sbs_subscriber_payment_term_id'] = $this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id'];
				$invoiceDetail['sbs_subscriber_id'] 			 = $this->subscriber;
				$enddate = $this->findEndDate($this->data['AcrClientInvoice']['start_date'],$this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id']);
				if($enddate){
					$invoiceDetail['due_date'] 			= date('Y-m-d',strtotime(str_replace('/','-',$enddate)));
				}
				$invoiceDetail['discount_total'] 	= $this->data['AcrClientInvoice']['discount_total'];
				if($this->data['Save_Invoice']	==	'1'){
					$invoiceDetail['status'] = 'Draft';
				}elseif($this->data['Send_Now']	==	'1'){
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
					$invoiceDetail['exchange_rate'] 		= $this->data['AcrClientInvoice']['conversionValue'];
					$invoiceDetail['invoice_total'] 		=  $invoiceDetail['func_currency_total']/$this->data['AcrClientInvoice']['conversionValue'] ;
				}else{
					$invoiceDetail['exchange_rate'] 		= 1;
					$invoiceDetail['invoice_total'] 		=  $invoiceDetail['func_currency_total'] ;
				}
				
				
				$saveInvoice = $this->AcrClientInvoice->addInvoice($invoiceDetail);
				if($saveInvoice){
					//$lastInvoiceDate = date('Y-m-d');
					$lastInvoiceDate	= date('Y-m-d',strtotime(str_replace('/','-', $this->data['AcrClientInvoice']['start_date'])));
					$saveRecuringDetail['acr_client_invoice_id']	=	$saveInvoice;
					$saveRecuringDetail['billing_period']			=	$this->data['AcrClientInvoice']['recurring_period'];
					$saveRecuringDetail['billing_frequency']		=	$this->data['AcrClientInvoice']['recurring_frequency'];
					$saveRecuringDetail['invoice_start_date']		=	date('Y-m-d',strtotime(str_replace('/','-', $this->data['AcrClientInvoice']['start_date'])));
					$saveRecuringDetail['invoice_end_date']			=	date('Y-m-d',strtotime(str_replace('/','-',$this->data['AcrClientInvoice']['end_date'])));
					$nextInvoiceDate = $this->getNextInvoiceDate($lastInvoiceDate,$this->data['AcrClientInvoice']['recurring_period'],$this->data['AcrClientInvoice']['recurring_frequency']);
					$saveRecuringDetail['next_invoice_date']		=	$nextInvoiceDate;
					$saveRecuringDetail['last_invoice_date']		=	$lastInvoiceDate;
					$saveRecurringDetail = $this->AcrClientRecurringInvoice->addRecurringDetail($saveRecuringDetail);
					if($saveRecurringDetail){
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
									$updateInventoryStock = $this->InvInventory->updateStock($saveInvoice,$this->data['AcrClientInvoice']['quantity'][$inventoryCount]);
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
						$send 		= $this->sentInvoice($saveInvoice,$customerInfo,$template,$from,$to,$subject);
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">A new invoice is created and mailed to customer.</div>'));
						$this->redirect(array('action' => 'index'));
					}
				}else{
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">A new invoice is created.</div>'));
					$this->redirect(array('action' => 'index'));
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
		$invoiceNumber = $this->generateRecurringInvoiceNumber($this->subscriber);
		$getCustomFields = $this->AcrInvoiceCustomField->getFieldList($this->subscriber);
		$this->set(compact('inventoryPermission','termsAndConditions','defaultNotes','invoiceNumber','customer', 'inventoryList','currencyList','defaultCurrency','paymentTerm','taxList','defaultCurrencyCode','getCustomFields','dateFormat'));
		if($this->request->is('mobile')){
			$this->render('/AcrClientRecurringInvoices/m_add');
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	
	
	public function edit($id = null,$recurringId = null,$filterAction = 0, $filterValue = 0, $filterValue1 = 0, $filterValue2 = 0,$isRecurring,$status = 0,$fromDate = 0,$toDate = 0,$page) {
		$permission = $this->permission;
		$inventoryPermission = $this->inventoryPermission;
		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		$this->loadModel('InvInventory');
		$this->loadModel('AcrClient');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$this->loadModel('SbsSubscriberPaymentTerm');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrInvoiceCustomField');
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('AcrClientContact');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('AcrInvoiceCustomValue');
		/*if (!$this->AcrClientInvoice->exists($recurringId)) {
			throw new NotFoundException(__('Invalid acr client invoice'));
		}*/
		if ($this->request->is(array('post', 'put'))) {
			if(!empty($this->data['AcrClientInvoice']['inventory'])){
				$invoiceDetail['invoiceId']				= $this->data['AcrClientInvoice']['invoiceId'];
				$invoiceDetail['invoice_number'] 		= $this->data['AcrClientInvoice']['invoice_number'];
				$invoiceDetail['purchase_order_no'] 	= $this->data['AcrClientInvoice']['purchase_order_no'];
				$invoiceDetail['invoice_description'] 	= $this->data['AcrClientInvoice']['invoice_description'];
				$invoiceDetail['acr_client_id'] 		= $this->data['AcrClientInvoice']['acr_client_id'];
				$subscriberCurrency = $this->CpnCurrency->getCurrencyById($this->data['AcrClientInvoice']['cpn_currency_id']);
				$invoiceDetail['defaultCurrencyId'] 	= $subscriberCurrency['CpnCurrency']['code'];//Invoiced Currency
				//$invoiceDetail['defaultCurrencyId'] = $subscriberCurrency['CpnCurrency']['code'];
				$invoiceDetail['conversionValue'] 		= $this->data['AcrClientInvoice']['conversionValue'];
				$invoiceDetail['invoiced_date'] 		= str_replace('/','-',$this->data['AcrClientInvoice']['invoiced_date']);
				$invoiceDetail['sbs_subscriber_payment_term_id'] = $this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id'];
				$invoiceDetail['sbs_subscriber_id'] 			 = $this->subscriber;
				$enddate = $this->findEndDate($this->data['AcrClientInvoice']['invoiced_date'],$this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id']);
				$invoiceDetail['due_date'] 			= date('Y-m-d',strtotime(str_replace('/', '-', $enddate)));
				$invoiceDetail['discount_total'] 	= $this->data['AcrClientInvoice']['discount_total'];
				if($this->data['Save_Invoice']	==	'1'){
					$invoiceDetail['status'] = 'Draft';
				}elseif($this->data['Send_Now']	==	'1'){
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
					$invoiceDetail['exchange_rate'] 		= $this->data['AcrClientInvoice']['conversionValue'];
					$invoiceDetail['invoice_total'] 		=  $invoiceDetail['func_currency_total']/$this->data['AcrClientInvoice']['conversionValue'] ;
				}else{
					$invoiceDetail['exchange_rate'] 		= 1;
					$invoiceDetail['invoice_total'] 		=  $invoiceDetail['func_currency_total'];
				}
				
				$invoiceDetail['recurring'] 			= 'Y';
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
								/*if($updateInventoryStock){*/
									$lastInvoiceDate 							= $this->data['AcrClientInvoice']['last_invoice_date'];
									$recurringInvoiceData['recurring_id']		= $this->data['AcrClientInvoice']['recurrenceId'];
									$recurringInvoiceData['billing_period'] 	= $this->data['AcrClientInvoice']['recurring_period'];
									$recurringInvoiceData['billing_frequency']  = $this->data['AcrClientInvoice']['recurring_frequency'];
									$nextInvoiceDate = $this->getNextInvoiceDate($lastInvoiceDate,$this->data['AcrClientInvoice']['recurring_period'],$this->data['AcrClientInvoice']['recurring_frequency']);
									$recurringInvoiceData['next_invoice_date']  = $nextInvoiceDate;
									$recurringInvoiceData['last_invoice_date']  = $lastInvoiceDate;
									$recurringInvoiceData['invoice_start_date'] = date('Y-m-d',strtotime(str_replace('/', '-', $this->data['AcrClientInvoice']['start_date'])));
									$recurringInvoiceData['invoice_end_date'] 	= date('Y-m-d',strtotime(str_replace('/', '-', $this->data['AcrClientInvoice']['end_date'])));
									$recurrenceUpdate = $this->AcrClientRecurringInvoice->updateRecurrence($recurringInvoiceData);
								/*}*/
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
						$send 		= $this->sentInvoice($saveInvoice,$customerInfo,$template,$from,$to,$subject);
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">A new invoice is created and mailed to customer.</div>'));
						/*$this->redirect(array('action' => 'index'));*/
						$this->redirect(array('action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$page));
					}
				}else{
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">Inv# '.$this->data['AcrClientInvoice']['invoice_number'].'updated successfully .</div>'));
					$this->redirect(array('action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$page));
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
		$options = array('conditions' => array('AcrClientRecurringInvoice.' . $this->AcrClientRecurringInvoice->primaryKey => $recurringId));
		$acrClientRecurringInvoice = $this->AcrClientRecurringInvoice->find('first', $options);
		$taxArray = $this->getTaxCalculation($invoiceDetail);
		$invoicedCurrency = $this->CpnCurrency->getCurrencyIdByCurrencyCode($invoiceData['AcrClientInvoice']['invoice_currency_code']);
		$inventoryList	 	 = $this->InvInventory->getListOfInventory($this->subscriber);
		$customer 		 	 = $this->AcrClient->getCustomerList($this->subscriber);
		
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
		$subsCriberCurrency  = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
		$paymentTerm = $this->SbsSubscriberPaymentTerm->getPaymentTermsBySubscriber($this->subscriber);
		
		foreach($subsCriberCurrency as $subkey => $subscriberCurrencyMap){
			if($subscriberCurrencyMap['CpnCurrency']['name']){
				$currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['code'];
			}			
		}
		$taxList = $this->taxTree();
		$getCustomFields = $this->AcrInvoiceCustomField->getFieldList($this->subscriber);
		$getCustomFieldsVal = $this->AcrInvoiceCustomValue->getFieldValueByInvoiceId($invoiceData['AcrClientInvoice']['id']); 
		$this->set(compact('getCustomFieldsVal','dateFormat','acrClientRecurringInvoice','invoiceData','invoiceDetail','customer','invoicedCurrency', 'inventoryList','currencyList','defaultCurrency','paymentTerm','taxList','defaultCurrencyCode','getCustomFields','taxArray'));
		$this->set(compact('inventoryPermission','filterAction','filterValue','filterValue1','filterValue2','isRecurring','status','fromDate','toDate','page'));
		if($this->request->is('mobile')){
			$this->render('/AcrClientRecurringInvoices/m_edit');
		}
		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null,$filterAction = 0, $filterValue = 0, $filterValue1 = 0, $filterValue2 = 0,$isRecurring,$status = 0,$fromDate = 0,$toDate = 0,$page) {
		$this->AcrClientRecurringInvoice->id = $id;
		if (!$this->AcrClientRecurringInvoice->exists()) {
			throw new NotFoundException(__('Recurrence could not be found'));
		}
		/*$this->request->onlyAllow('post', 'delete');*/
		$this->AcrClientRecurringInvoice->recursive = 0;
		$options = array('conditions' => array('AcrClientRecurringInvoice.' . $this->AcrClientRecurringInvoice->primaryKey => $id));
		$acrClientRecurringInvoice = $this->AcrClientRecurringInvoice->find('first', $options);
		if ($this->AcrClientRecurringInvoice->delete()) {
			$this->Session->setFlash(__('<div class="alert alert-block alert-success">The recurrence for Invoice#'.$acrClientRecurringInvoice['AcrClientInvoice']['invoice_number'].' has been removed.</div>'));
		} else {
			$this->Session->setFlash(__('<div class="alert alert-danger"> Sorry! The recurrence for Invoice# '.$acrClientRecurringInvoice['AcrClientInvoice']['invoice_number'].' could not be removed.</div>'));
		}
		return $this->redirect(array('action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$page));
	}
	public function deleteAll(){
		$this->autoRender = false;
		$filterAction 	= $this->data['AcrClientRecuringInvoice']['filterAction'];
		$filterValue 	= $this->data['AcrClientRecuringInvoice']['filterValue'];
		$filterValue1 	= $this->data['AcrClientRecuringInvoice']['filterValue1'];
		$filterValue2 	= $this->data['AcrClientRecuringInvoice']['filterValue2'];
		$isRecurring 	= $this->data['AcrClientRecuringInvoice']['isRecurring'];
		$status 		= $this->data['AcrClientRecuringInvoice']['status'];
		$fromDate 		= $this->data['AcrClientRecuringInvoice']['fromDate'];
		$toDate 		= $this->data['AcrClientRecuringInvoice']['toDate'];
		$page 			= $this->data['AcrClientRecuringInvoice']['page'];
		if($this->data['deleteAll']){
			foreach($this->data['deleteAll'] as $recurrenceId=>$deleteValue){
				if($deleteValue){
					$this->AcrClientRecurringInvoice->id = $recurrenceId;
					if($this->AcrClientRecurringInvoice->delete()){
						$deleteTrue = 1;
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">Selected recurrence are removed.You cannot retrieve these recurrences again</div>'));
					}
				}
			}
		}
		if(!$deleteTrue){
			$this->Session->setFlash(__('<div class="alert alert-danger"> Please select atleast one recurrence to delete.</div>'));
		}
		return $this->redirect(array('action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$page));
		
	}
	public function getNextInvoiceDate($lastInvoiceDate = null,$recuringPeriod = null,$recuringFrequency = null){
		if($lastInvoiceDate && $recuringPeriod && $recuringFrequency){
			$nextInvoiceDate = date('Y-m-d', strtotime($lastInvoiceDate. ' + '.$recuringFrequency.$recuringPeriod));
			return $nextInvoiceDate;
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
			
		}
	public function calculateTotal($rowId){
			$this->loadModel('CpnCurrency');
			foreach($this->data['AcrClientInvoice']['inventory'] as $key1=>$val){
				if($val){
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
								$taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['name'];
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
								$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['name'];
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
	public function findEndDate($invoiced_date = null,$termId = null){
		if(($this->data['AcrClientInvoice']['invoiced_date']) && ($this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id'])){
			$this->loadModel('SbsSubscriberPaymentTerm');
			$getPaymentTermDetail = $this->SbsSubscriberPaymentTerm->getTermsById($this->data['AcrClientInvoice']['sbs_subscriber_payment_term_id']);
			if($getPaymentTermDetail){
				$this->loadModel('SbsSubscriberSetting');
				$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		 		$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
				$dueDate = date($dateFormat, strtotime($this->data['AcrClientInvoice']['invoiced_date']. ' + '.$getPaymentTermDetail.' days'));
				$this->set(compact('dueDate'));
				return $dueDate;
			}
			
		}elseif($invoiced_date && $termId){
			$this->loadModel('SbsSubscriberPaymentTerm');
			$getPaymentTermDetail = $this->SbsSubscriberPaymentTerm->getTermsById($termId);
			if($getPaymentTermDetail){
				
				$dueDate = date('Y-m-d', strtotime($invoiced_date. ' + '.$getPaymentTermDetail.' days'));
				return $dueDate;
			}
		}
	}
	public function sentInvoice ($invoiceId = null, $customerInfo = null, $template = null, $from = null, $to = null, $subject) {		

		$generate      			= $this->generatePdf($invoiceId);
		if($generate){
			$updatePdfGenerated = $this->pdfGen($invoiceId);
			
		}
		$clientCurrencyCode 	= $generate['clientCurrencyCode'];
		$subscriberCurrencyCode = $generate['subscriberCurrencyCode'];
		$options 				= $generate['options'];
		$invoiceData 			= $generate['invoiceData'];
		$invoiceDetail 			= $generate['invoiceDetail'];
		$taxArray 				= $generate['taxArray'];		
		$this->set(compact('customerInfo', 'clientCurrencyCode', 'subscriberCurrencyCode', 'options', 'invoiceData', 'invoiceDetail', 'taxArray'));
		$this->Email->filePaths   = array($_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/invoice/");
       	$this->Email->attachments = array($invoiceData['AcrClientInvoice']['invoice_number'].'.pdf');
       
       	$from 	= $this->EMAIL_FROM;
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

	// Generate invoice pdf and also use for view invoice details
	public function generatePdf($invoiceId = null, $actionType = null){
		
		$this->loadModel('AcrInvoiceDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
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
		$defaultCurrencyInfo 	= $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$subscriberCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
		$clientCurrencyCode 	= $invoiceData['AcrClientInvoice']['invoice_currency_code'];
		$options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');
		if(!$actionType) {
			$this->set(compact('taxArray','clientCurrencyCode','subscriberCurrencyCode','options'));
			$this->render('/Pdf/my_pdf_view');
		}
		$returnResponse = array('clientCurrencyCode'=>$clientCurrencyCode, 'subscriberCurrencyCode'=>$subscriberCurrencyCode, 'options'=>$options, 'invoiceData'=>$invoiceData, 'invoiceDetail'=>$invoiceDetail, 'taxArray'=>$taxArray);
		return $returnResponse;
	}
	public function customerInfo($clientId = null){
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
				$this->set(compact('contactPersonName','contactEmail','contactMobile','contactHomePhone','contactWorkPhone'));
			}
			
		}
		return $clientInfo;
		
	}
	
	public function currencyInfo(){
		if($this->data['AcrClientInvoice']['cpn_currency_id']) {
			$currencyId = $this->data['AcrClientInvoice']['cpn_currency_id'];
		}
		if($currencyId){
			$this->loadModel('CpnCurrency');
			$currencyDetail 		= $this->CpnCurrency->getCurrencyById($currencyId);
			$defaultCurrencyCode 	= $currencyDetail['CpnCurrency']['code'];
			$this->set(compact('defaultCurrencyCode'));
		}
	}
	
	public function generateInvoice($acrClientRecurringInvoiceId){
		if($acrClientRecurringInvoiceId){
			$this->loadModel('AcrInvoiceDetail');
			$this->loadModel('AcrClientInvoice');
			$this->loadModel('AcrInvoiceCustomField');
			$this->loadModel('AcrInvoiceCustomValue');
			$this->loadModel('InvInventory');
			$this->AcrClientRecurringInvoice->recursive = 0;
			$options = array('conditions' => array('AcrClientRecurringInvoice.' . $this->AcrClientRecurringInvoice->primaryKey => $acrClientRecurringInvoiceId));
			$acrClientRecurringInvoice = $this->AcrClientRecurringInvoice->find('first', $options);
			if($acrClientRecurringInvoice){
				$invoiceDetailList 	= $this->AcrInvoiceDetail->getInvoiceDetails($acrClientRecurringInvoice['AcrClientRecurringInvoice']['acr_client_invoice_id']);
				$getCustomFields   	= $this->AcrInvoiceCustomField->getFieldList($this->subscriber);
				$getCustomFieldsVal = $this->AcrInvoiceCustomValue->getFieldValue($getCustomFields['AcrInvoiceCustomField']['id'],$acrClientRecurringInvoice['AcrClientInvoice']['id']); 
				$enddate 		   	= $this->findEndDate(date('Y-m-d'),$acrClientRecurringInvoice['AcrClientInvoice']['sbs_subscriber_payment_term_id']);
				$invoiceNumber 		= $this->generateInvoiceNumber($this->subscriber);
				
				$invoiceDetail['invoice_number'] 					= $invoiceNumber;
				$invoiceDetail['invoice_description'] 				= $acrClientRecurringInvoice['AcrClientInvoice']['description'];
				$invoiceDetail['invoiced_date'] 					= date('Y-m-d');
				$invoiceDetail['purchase_order_no'] 				= $acrClientRecurringInvoice['AcrClientInvoice']['purchase_order_no'];
				$invoiceDetail['due_date'] 							= date('Y-m-d',strtotime($enddate));
				$invoiceDetail['discount_total'] 					= $acrClientRecurringInvoice['AcrClientInvoice']['discount_percent'];
				$invoiceDetail['status'] 							= 'Draft';
				$invoiceDetail['notes'] 							= $acrClientRecurringInvoice['AcrClientInvoice']['notes'];
				$invoiceDetail['terms'] 							= $acrClientRecurringInvoice['AcrClientInvoice']['term_conditions'];
				$invoiceDetail['sub_total'] 						= $acrClientRecurringInvoice['AcrClientInvoice']['sub_total'];
				$invoiceDetail['tax_total'] 						= $acrClientRecurringInvoice['AcrClientInvoice']['tax_total'];
				$invoiceDetail['func_currency_total'] 				= $acrClientRecurringInvoice['AcrClientInvoice']['func_currency_total'];
				$invoiceDetail['exchange_rate'] 					= $acrClientRecurringInvoice['AcrClientInvoice']['exchange_rate'];
				$invoiceDetail['conversionValue'] 					= $acrClientRecurringInvoice['AcrClientInvoice']['exchange_rate'];
				$invoiceDetail['recurring'] 						= 'N';
				$invoiceDetail['acr_client_id'] 					= $acrClientRecurringInvoice['AcrClientInvoice']['acr_client_id'];
				$invoiceDetail['sbs_subscriber_id'] 			 	= $this->subscriber;
				$invoiceDetail['sbs_subscriber_payment_term_id'] 	= $acrClientRecurringInvoice['AcrClientInvoice']['sbs_subscriber_payment_term_id'];
				$invoiceDetail['invoice_total'] 					= $acrClientRecurringInvoice['AcrClientInvoice']['invoice_total'];
				$invoiceDetail['defaultCurrencyId'] 				= $acrClientRecurringInvoice['AcrClientInvoice']['invoice_currency_code'];//Invoiced Currency
				
				$saveInvoice = $this->AcrClientInvoice->addInvoice($invoiceDetail);
				if($saveInvoice){
					$this->set(compact('saveInvoice','invoiceNumber'));
					$lastInvoiceDate = date('Y-m-d');
					$saveRecuringDetail['id']						=	$acrClientRecurringInvoice['AcrClientRecurringInvoice']['id'];
					$saveRecuringDetail['last_invoice_date']		=	$lastInvoiceDate;
					$saveRecurringDetail = $this->AcrClientRecurringInvoice->updateRecurrenceOnGenerate($saveRecuringDetail);
					if($saveRecurringDetail){
						foreach($invoiceDetailList as $arrayKey => $invoiceDetailValue){
							$invoiceDetailRecord = null;
							if($invoiceDetailValue){
								$invoiceDetailRecord['quantity'] 						= $invoiceDetailValue['AcrInvoiceDetail']['quantity'];
								$invoiceDetailRecord['unit_rate'] 						= $invoiceDetailValue['AcrInvoiceDetail']['unit_rate'];
								$invoiceDetailRecord['discount_percent'] 				= $invoiceDetailValue['AcrInvoiceDetail']['discount_percent'];
								$invoiceDetailRecord['inventory_description']			= $invoiceDetailValue['AcrInvoiceDetail']['inventory_description'];
								$invoiceDetailRecord['line_total'] 						= $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
								$invoiceDetailRecord['acr_client_invoice_id'] 			= $saveInvoice;
								$invoiceDetailRecord['inv_inventory_id'] 	  			= $invoiceDetailValue['AcrInvoiceDetail']['inv_inventory_id'];
								if($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']){
									$invoiceDetailRecord['sbs_subscriber_tax_group_id'] = $invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_group_id'];
								}else{
									$invoiceDetailRecord['sbs_subscriber_tax_id'] 		= $invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id'];
								}
								$invDetailId = $this->AcrInvoiceDetail->addInvoiceDetail($invoiceDetailRecord);
								if($invDetailId){
									$updateInventoryStock = $this->InvInventory->updateStock($saveInvoice,$invoiceDetailValue['AcrInvoiceDetail']['quantity']);
								}
							}
						}
						if(!empty($getCustomFields)){
							foreach($getCustomFields as $customFieldId=>$customFieldValue){
								if($customFieldValue){
									$customData['acr_invoice_custom_field_id'] = $customFieldId;
									$customData['acr_client_invoice_id']	   = $saveInvoice;
									$customData['data'] 					   = $getCustomFieldsVal[$customFieldId];
									$addValue = $this->AcrInvoiceCustomValue->addValue($customData);
								}
							}
						}
					}
				}
			}
		}
	}
	
	public function stopRecurrence($acrClientRecurringInvoiceId){
		if($acrClientRecurringInvoiceId){
			$this->loadModel('SbsSubscriberSetting');
			$stopRecurrence = $this->AcrClientRecurringInvoice->stopInvoiceRecurrence($acrClientRecurringInvoiceId);
			$this->AcrClientRecurringInvoice->recursive = 0;
				$acrClientInvoice = $this->AcrClientRecurringInvoice->find('first',array('conditions'=>array('AcrClientRecurringInvoice.id'=>$acrClientRecurringInvoiceId)));
			if($stopRecurrence){
				$this->set(compact('stopRecurrence'));
			}
			$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
			$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
			$this->set(compact('acrClientInvoice','dateFormat','defaultCurrency'));
		}
	}
	
	public function startRecurrence($acrClientRecurringInvoiceId){
		if($acrClientRecurringInvoiceId){
			$this->loadModel('SbsSubscriberSetting');
			$stopRecurrence = $this->AcrClientRecurringInvoice->startInvoiceRecurrence($acrClientRecurringInvoiceId);
			$this->AcrClientRecurringInvoice->recursive = 0;
				$acrClientInvoice = $this->AcrClientRecurringInvoice->find('first',array('conditions'=>array('AcrClientRecurringInvoice.id'=>$acrClientRecurringInvoiceId)));
			if($stopRecurrence){
				$this->set(compact('stopRecurrence'));
			}
			$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$dateFormat			 = $settings['SbsSubscriberSetting']['date_format'];
			$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
			$this->set(compact('acrClientInvoice','dateFormat','defaultCurrency'));
		}
	}
	public function invoiceNumberExist(){
			$this->loadModel('AcrClientInvoice');
			if($this->data['AcrClientInvoice']['recurring_invoice_no']){
				$invoiceExist = $this->AcrClientInvoice->getInvoiceByInvoiceNumber($this->data['AcrClientInvoice']['recurring_invoice_no'],$this->subscriber);
				if($invoiceExist){
					$invoiceNumber = $this->generateRecurringInvoiceNumber($this->subscriber);
					$enteredInvoiceNumber = $this->data['AcrClientInvoice']['recurring_invoice_no'];
					$this->set(compact('invoiceExist','invoiceNumber','enteredInvoiceNumber'));
				}else{
					$invoiceNumber = $this->data['AcrClientInvoice']['recurring_invoice_no'];
					$this->set(compact('invoiceNumber'));
				}
			}
		}
	
}
