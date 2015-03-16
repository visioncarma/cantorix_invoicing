<?php
App::uses('AppController', 'Controller');

/**
 * Quotes Controller
 */
class QuotesController extends AppController {

 /**
 * Components
 * @var array
 */
	public $components = array('Paginator', 'Session','RequestHandler');
	public $uses = array('SlsQuotation','SlsQuotationProduct','AcrClient','CpnCurrency','InvInventory');
	private $permission = NULL;
	
	/**
	 * @method Constructor method
	 * 
	 * */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = "sbs_layout";
		$this->permission = $this->Session->read('Auth.AllPermissions.Quotes');
      	$this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
		$quotesActive = 'active';
		$this->set(compact('quotesActive'));
	}
	
	public function index($customer = 0, $min = 0, $max = 0, $status = 0, $from = 0, $to = 0, $page = NULL) {
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		$this->loadModel('SbsSubscriberSetting');
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$limit 			= $settings['SbsSubscriberSetting']['lines_per_page'];
		$this->SlsQuotation->recursive = 0;
		$this->SlsQuotation->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
		$conditions = array('SlsQuotation.sbs_subscriber_id'=>$this->subscriber);
		
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('CpnSubscriptionPlan');
		$invoiceCount 	= $this->AcrClientInvoice->getActiveInvoiceCount($this->subscriber);
		$currntPlan 	= $this->CpnSubscriptionPlan->getPlanDetails($this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id'));
		
		/**Filter section code starts**/
		if($customer) { $this->request->data['Filter']['customer_name'] = $customer; }
		if($min) { $this->request->data['Filter']['min_price'] = $min; }
		if($max) { $this->request->data['Filter']['max_price'] = $max; }
		if($status) { $this->request->data['Filter']['status'] = $status; }
		if($from) { $this->request->data['Filter']['from_date'] = $from; }
		if($to) { $this->request->data['Filter']['to_date'] = $to; }
		if(!empty($this->data)) {
			if(!empty($this->request->data['Filter']['customer_name'])) {
				 $customer = trim($this->request->data['Filter']['customer_name']);
			}
			if(!empty($this->request->data['Filter']['min_price'])) {
				$min = trim($this->request->data['Filter']['min_price']);
			}
			if(!empty($this->request->data['Filter']['max_price'])) {
				$max = trim($this->request->data['Filter']['max_price']);
			}
			if(!empty($this->request->data['Filter']['status'])) {
				$status = trim($this->request->data['Filter']['status']);
			}
			if(!empty($this->request->data['Filter']['from_date'])) {
				$from = trim($this->request->data['Filter']['from_date']);
			}
			if(!empty($this->request->data['Filter']['to_date'])) {
				$to = trim($this->request->data['Filter']['to_date']);
			}
			if(empty($customer) && empty($min) && empty($max) && empty($status) && empty($from) && empty($to)) {
				$this->Session->setFlash('<div class="alert alert-info">Please enter atleast one search term!</div>');
				$this->redirect(array('action'=>'index',$organization,$client,$email,$status,'page:'.$page));
			}
			$condition_array=null;$organization_array=null;$client_array=null;$email_array=null;$status_array=null;
			if($customer) {
				$customer_array = array('AcrClient.client_name LIKE'=>'%'.$customer.'%');
			}
			if($min && !$max) {
				$price_array = array('SlsQuotation.invoice_amount >='=>$min);
			}
			if(!$min && $max) {
				$price_array = array('SlsQuotation.invoice_amount <='=>$max);
			}
			if($min && $max) {
				$price_array = array('SlsQuotation.invoice_amount BETWEEN ? and ?'=>array($min,$max));
			}
			if($status) {
				$status_array = array('SlsQuotation.status'=>$status);
			}
			if($from && !$to) {
				$date_array = array('SlsQuotation.issue_date >='=>date('Y-m-d',strtotime($from)));
			}
			if($to && !$from) {
				$date_array = array('SlsQuotation.issue_date <='=>date('Y-m-d',strtotime($to)));
			}
			if($from && $to) {
				$date_array = array('SlsQuotation.issue_date BETWEEN ? and ?'=>array(date('Y-m-d',strtotime($from)),date('Y-m-d',strtotime($to))));
			}
			$subscriber_array = array('SlsQuotation.sbs_subscriber_id'=>$this->subscriber);
			$conditions = array($subscriber_array,$customer_array,$price_array,$status_array,$status_array,$date_array);
		}
		/**Filter section code ends**/
		
		$this->Paginator->settings = array(
			'conditions'=>$conditions,
			'fields'=>array('SlsQuotation.id','SlsQuotation.quotation_no','AcrClient.client_name','AcrClient.status','SlsQuotation.issue_date','SlsQuotation.acr_client_invoice_id','SlsQuotation.invoice_currency_code','SlsQuotation.invoice_amount','SlsQuotation.status','SlsQuotation.acr_client_id'),
			'limit' => $limit,
			'order'=>array('SlsQuotation.quotation_no' => 'Desc'));
		$quotes = $this->Paginator->paginate('SlsQuotation');
		$subscriberID = $this->subscriber;
		$this->set(compact('quotes','settings','customer','min','max','status','from','to','subscriberID','invoiceCount','currntPlan'));
	}
	
	public function add($customer = 0, $min = 0, $max = 0, $status = 0, $from = 0, $to = 0, $page = NULL) {
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$title_for_layout = 'Add Quote';
		$this->set(compact('title_for_layout'));
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$this->loadModel('SbsSubscriberPaymentTerm');
		$inventoryList	 	 = $this->InvInventory->getListOfInventory($this->subscriber);
		$customers 		 	 = $this->AcrClient->getActiveCustomerList($this->subscriber);
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
		$subsCriberCurrency  = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
		$paymentTerm = $this->SbsSubscriberPaymentTerm->getPaymentTermsBySubscriber($this->subscriber);
		foreach($subsCriberCurrency as $subkey => $subscriberCurrencyMap){
			if($subscriberCurrencyMap['CpnCurrency']['name']){
				$currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['name'];
			}			
		}
		$taxList = $this->taxTree();
		$this->loadModel('InvInventoryUnitType');
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$this->loadModel('SlsQuotationCustomField');
		$customFields = $this->SlsQuotationCustomField->getFieldList($this->subscriber);
		$quoteNumber = $this->generateQuoteNumber($this->subscriber);
		$this->set(compact('unitTypeList','quoteNumber','customers', 'inventoryList','currencyList','defaultCurrency','paymentTerm','taxList','defaultCurrencyCode','customFields','settings'));
		$this->set(compact('customer','min','max','status','from','to','page'));
		if(!empty($this->request->data)) {
			$addQuote = $this->SlsQuotation->addQuote($this->subscriber,$this->data);
			$sentSuccess = FALSE;
			if($addQuote) {
				if(!empty($this->data['AcrClientInvoice']['email_template'])) {
					$sentSuccess = $this->sendEmailQuotation($addQuote,$this->data);
				}
				if(!empty($this->data['AcrClientInvoice']['email_template'])) {
					if($sentSuccess) {
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">Quote has been sent.</div>'));
					} else {
						$this->Session->setFlash(__('<div class="alert alert-warning">Quote has been saved and error occurred while sending an email.</div>'));
					}
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">Quote has been saved.</div>'));
					$this->redirect(array('action' => 'index'));
				}
			} else {
				if($this->data['AcrClientInvoice']['quotation_status'] == 'Open') {
					$this->Session->setFlash('<div class="alert alert-danger">Quote couldn\'t send.</div>');
					return;
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">Quote couldn\'t save.</div>');
					return;
				}
			}
		}
	}
	
	public function edit($subscriberID = 0, $id = 0, $customer = 0, $min = 0, $max = 0, $status = 0, $from = 0, $to = 0, $page = 0) {
		$permission = $this->permission;
		//Configure::write('debug',2);
		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if($subscriberID != $this->subscriber) {
			$this->Session->setFlash('<div class="alert alert-danger">Error occurred.Please try again.</div>');
			$this->redirect(array('action' => 'index',$id,$customer,$min,$max,$status,$from,$to,'page:'.$page));
		}
		$title_for_layout = 'Edit Quote';
		$this->set(compact('title_for_layout'));
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$this->loadModel('SbsSubscriberPaymentTerm');
		$this->loadModel('SlsQuotationCustomValue');
		$inventoryList	 	 = $this->InvInventory->getListOfInventory($this->subscriber);
		$customers 		 	 = $this->AcrClient->getActiveCustomerList($this->subscriber);
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$defaultCurrency 	 = $settings['SbsSubscriberSetting']['cpn_currency_id'];
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		$defaultCurrencyCode = $defaultCurrencyInfo['CpnCurrency']['code'];
		$subsCriberCurrency  = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
		$paymentTerm = $this->SbsSubscriberPaymentTerm->getPaymentTermsBySubscriber($this->subscriber);
		foreach($subsCriberCurrency as $subkey => $subscriberCurrencyMap){
			if($subscriberCurrencyMap['CpnCurrency']['name']){
				$currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['name'];
			}			
		}
		
		$taxList = $this->taxTree();
		$this->loadModel('SbsSubscriberTaxGroup');
		$taxGroupNames = $this->SbsSubscriberTaxGroup->find('list',array('fields'=>array('id','group_name'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID)));
		$this->loadModel('InvInventoryUnitType');
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$this->loadModel('SlsQuotationCustomField');
		$customFields = $this->SlsQuotationCustomField->getFieldList($this->subscriber);
		$quoteNumber = $this->generateQuoteNumber($this->subscriber);
		$this->SlsQuotation->recursive = 0;
		$this->SlsQuotation->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
		$quote = $this->SlsQuotation->findById($id,array('SlsQuotation.*','AcrClient.id','AcrClient.client_no','AcrClient.client_name','AcrClient.organization_name','AcrClient.billing_address_line1','AcrClient.billing_address_line2','AcrClient.billing_city','AcrClient.billing_state','AcrClient.billing_country','AcrClient.billing_zip'));
		$customerDetails = $this->customerDetails($quote['SlsQuotation']['acr_client_id']);
		$quoteProducts = $this->SlsQuotationProduct->find('all',array('conditions'=>array('SlsQuotationProduct.sls_quotation_id' => $quote['SlsQuotation']['id'])/*,'fields'=>array('SlsQuotationProduct.*')*/));
		$inventoryUnitTypeList = $this->InvInventory->find('list',array('conditions'=>array('InvInventory.sbs_subscriber_id'=>$this->subscriber),'fields'=>array('InvInventory.id','InvInventory.inv_inventory_unit_type_id')));
		$subscriberCurrencyIDD = $this->CpnCurrency->getCurrencyIdByCurrencyCode($quote['SlsQuotation']['invoice_currency_code']);
		foreach ($quoteProducts as $key => $value) {
			$InvoiceArray[$key]['AcrInvoiceDetail'] = $value['SlsQuotationProduct'];
		}
		$taxCalcuations = $this->getTaxCalculation($InvoiceArray);
		$customFieldValues = $this->SlsQuotationCustomValue->getCustomValues($id);
		$customFieldValueIDS = $this->SlsQuotationCustomValue->getCustomValueIDs($id);
		$this->set(compact('unitTypeList','quoteNumber','customers', 'inventoryList','currencyList','defaultCurrency','paymentTerm','taxList','defaultCurrencyCode','customFields','settings'));
		$this->set(compact('quote','customerDetails','quoteProducts','taxCalcuations','customFieldValues','customFieldValueIDS','inventoryUnitTypeList'));
		$this->set(compact('id','subscriberID','customer','min','max','status','from','to','page','subscriberCurrencyIDD','taxGroupNames'));
		
		if(!empty($this->data)) {
			$updateQuote = $this->SlsQuotation->updateQuote($this->subscriber,$this->data,$id);
			$sentSuccess = FALSE;
			if($updateQuote) {
				if(!empty($this->data['AcrClientInvoice']['email_template'])) {
					$sentSuccess = $this->sendEmailQuotation($updateQuote,$this->data);
				}
				if(!empty($this->data['AcrClientInvoice']['email_template'])) {
					if($sentSuccess) {
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">Quote has been updated and email has been sent.</div>'));
					} else {
						$this->Session->setFlash(__('<div class="alert alert-warning">Quote has been updated and error occurred while sending an email.</div>'));
					}
					$this->redirect(array('action' => 'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page));
				} else {
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">Quote has been updated.</div>'));
					$this->redirect(array('action' => 'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page));
				}
			} else {
				if($this->data['AcrClientInvoice']['quotation_status'] == 'Open') {
					$this->Session->setFlash('<div class="alert alert-danger">Quote couldn\'t send.</div>');
					return;
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">Quote couldn\'t update.</div>');
					return;
				}
			}
			$this->redirect(array('action'=>'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page));
		}
		
	}
	
	public function view($subscriberID = 0, $id = 0, $customer = 0,  $min = 0, $max = 0, $status = 0, $from = 0, $to = 0, $page = 0) {
		if($subscriberID != $this->subscriber) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$title_for_layout = 'View Quote';
		$this->set(compact('title_for_layout'));
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->SlsQuotation->recursive = 0;
		$this->SlsQuotation->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
		$quote = $this->SlsQuotation->findById($id,array('SlsQuotation.*','AcrClient.id','AcrClient.client_no','AcrClient.client_name','AcrClient.organization_name','AcrClient.billing_address_line1','AcrClient.billing_address_line2','AcrClient.billing_city','AcrClient.billing_state','AcrClient.billing_country','AcrClient.billing_zip'));
		$organisationDetails = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'),
			array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$this->SlsQuotationProduct->recursive = 0;
		$this->SlsQuotation->unbindModel(array('belongsTo'=>array('SlsQuotation')));
		$quoteProducts = $this->SlsQuotationProduct->find('all',array('conditions'=>array('SlsQuotationProduct.sls_quotation_id' => $quote['SlsQuotation']['id']),'fields'=>array('SlsQuotationProduct.*','InvInventory.name','InvInventory.description','InvInventory.list_price','SbsSubscriberTax.id','SbsSubscriberTaxGroup.id')));
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		foreach ($quoteProducts as $key => $value) {
			$InvoiceArray[$key]['AcrInvoiceDetail'] = $value['SlsQuotationProduct'];
		}
		$taxCalcuations = $this->getTaxCalculation($InvoiceArray);
		$this->loadModel('SlsQuotationCustomField');
		$this->loadModel('SlsQuotationCustomValue');
		$customValues 	= $this->SlsQuotationCustomValue->getCustomValues($id);
		$customFields	= $this->SlsQuotationCustomField->getFieldList($subscriberID);
		$this->set(compact('quote','organisationDetails','quoteProducts','settings','defaultCurrencyInfo','taxCalcuations','customer','min','max','status','from','to','page','customValues','customFields'));
	}

	
	public function delete($subscriberID = 0, $id = 0, $customer = 0, $min = 0, $max = 0, $status = 0, $from = 0, $to = 0, $page = 0) {
		$permission = $this->permission;
		$this->autoRender = FALSE;
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$quote = $this->SlsQuotation->findById($id,array('SlsQuotation.quotation_no'));
		$this->loadModel('SlsQuotationCustomValue');
		$this->SlsQuotationCustomValue->deleteAll(array('SlsQuotationCustomValue.sls_quotation_id'=>$id),FALSE);
		$this->SlsQuotationProduct->deleteAll(array('SlsQuotationProduct.sls_quotation_id'=>$id),FALSE);
		$deleted = $this->SlsQuotation->delete($id);
		if ($deleted) {
			$this->Session->setFlash(__('<div class="alert alert-block alert-success">Quote #'.$quote['SlsQuotation']['quotation_no'].' has been deleted.</div>'));
		} else {
			$this->Session->setFlash('<div class="alert alert-danger">Quote couldn\'t be deleted!</div>');
		}
		$this->redirect(array('action'=>'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page));
	}
	
	public function convertToInvoice($subscriberID = 0, $id = 0, $customer = 0, $min = 0, $max = 0, $status = 0, $from = 0, $to = 0, $page = 0) {
		$permission = $this->permission;
		$this->autoRender = FALSE;
		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if($subscriberID != $this->subscriber) {
			$this->Session->setFlash('<div class="alert alert-danger">Error occurred.Please try again.</div>');
			$this->redirect(array('action' => 'index',$id,$customer,$price,$status,$from,$to,'page:'.$page));
		}
		$converted = $this->SlsQuotation->convertToInvoice($id);
		if($converted) {
			$this->Session->setFlash(__('<div class="alert alert-block alert-success">Quote has been converted to an invoice.</div>'));
			$this->redirect(array('controller'=>'AcrClientInvoices','action'=>'edit',$converted,$this->subscriber));
		} else {
			$this->Session->setFlash('<div class="alert alert-danger">Quote couldn\'t be converted to an invoice.</div>');
			$this->redirect(array('action'=>'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page));
		}
		
	}
	
	public function customerCurrency($currencyList = NULL) {
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$currencyID = $this->AcrClient->findById($this->data['AcrClientInvoice']['acr_client_id'],array('cpn_currency_id')); 
		$subsCriberCurrency  = $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($this->subscriber);
		foreach($subsCriberCurrency as $subkey => $subscriberCurrencyMap){
			if($subscriberCurrencyMap['CpnCurrency']['name']){
				$currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['name'];
			}			
		}
		$this->set(compact('currencyID','currencyList'));
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
						$taxArray[$val1['SbsSubscriberTax']['id']]['taxName'] = $val1['SbsSubscriberTax']['name'];
						if($val1['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
							$taxAmount = ($product*$val1['SbsSubscriberTax']['percent'])/100;
							$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
							$product = $product + $taxAmount;
						}else{
							/*$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];*/
							$taxAmount = ($lineTotal * $val1['SbsSubscriberTax']['percent'])/100;
							$taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$val1['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
							$product = $lineTotal + $taxAmount;
						}
					}
				}elseif($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id']){
					$this->loadModel('SbsSubscriberTax');
					$product = $invoiceDetailValue['AcrInvoiceDetail']['line_total'];
					$taxDetails = $this->SbsSubscriberTax->getTaxById($invoiceDetailValue['AcrInvoiceDetail']['sbs_subscriber_tax_id']);
					if($taxDetails){
						$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxName'] = $taxDetails['SbsSubscriberTax']['name'];
						$taxAmount = ($product * $taxDetails['SbsSubscriberTax']['percent'])/100;
						$taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] = $taxArray[$taxDetails['SbsSubscriberTax']['id']]['taxAmount'] + $taxAmount;
						//$product = $product + ($product * $taxDetails['SbsSubscriberTax']['percent'])/100;
					}
				}
			}
			return $taxArray;
		}
	}
	
	public function customerDetails($clientId = NULL) {
		if(!$clientId) $clientId = $this->data['AcrClientInvoice']['acr_client_id'];
		if($clientId){
			$this->loadModel('AcrClientContact');
			$clientInfo = $this->AcrClientContact->find('first',array('conditions'=>array('AcrClientContact.acr_client_id'=> $clientId,'AcrClientContact.is_primary'=>'Y')));
			if(empty($clientInfo)) {
				$clientInfo = $this->AcrClientContact->find('first',array('conditions'=>array('AcrClientContact.acr_client_id'=> $clientId)));
			}
			if(!empty($clientInfo)) {
				$contactPersonName 	= $clientInfo['AcrClientContact']['name'];
				$contactSurName		= $clientInfo['AcrClientContact']['sur_name'];
				$contactEmail 		= $clientInfo['AcrClientContact']['email'];
				$contactMobile 		= $clientInfo['AcrClientContact']['mobile'];
				$contactHomePhone 	= $clientInfo['AcrClientContact']['home_phone'];
				$contactWorkPhone 	= $clientInfo['AcrClientContact']['work_phone'];
				$this->set(compact('contactPersonName','contactEmail','contactMobile','contactHomePhone','contactWorkPhone','contactSurName'));
			}
			return $clientInfo;
		}
	}
	
	public function preview() {
		$data = $this->data;
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('AcrClient');
		$this->loadModel('InvInventory');
		$this->loadModel('SbsSubscriberTax');
		$organisationDetails  = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'),
			array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));
		$customerDetails = $this->AcrClient->findById($this->data['AcrClientInvoice']['acr_client_id'],
			array('client_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip')
		);
		$inventories = $this->InvInventory->getListOfInventory($this->subscriber);
		$taxes = $this->SbsSubscriberTax->getTaxesBySubscriber($this->subscriber);
		$this->set(compact('data','organisationDetails','customerDetails','inventories','taxes'));
	}
	
	public function sendEmailQuotation($quoteID = NULL,$data = NULL) {
		$data = $this->data;
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('AcrClient');
		$this->loadModel('InvInventory');
		$this->loadModel('SbsSubscriberTax');
		$this->loadModel('AcrClientContact');
		$template = $data['AcrClientInvoice']['email_template'];
		$organisationDetails  = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'),
			array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));
		$customerDetails = $this->AcrClient->findById($this->data['AcrClientInvoice']['acr_client_id'],
			array('client_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip')
		);
		$emailDetails = $this->AcrClientContact->getClientPrimaryContactDetail($data['AcrClientInvoice']['acr_client_id']);
		$inventories = $this->InvInventory->getListOfInventory($this->subscriber);
		$taxes = $this->SbsSubscriberTax->getTaxesBySubscriber($this->subscriber);
		
		$filePath 	= $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/quotes/Subscriber-".$this->subscriber.'/';
		$this->generatePdf($template,$quoteID);
		$file		= $data['AcrClientInvoice']['quote_no'].'.pdf';
		
		
		$this->set(compact('data','organisationDetails','customerDetails','inventories','taxes'));
		$this->Email->filePaths   = array($filePath);
       	$this->Email->attachments = array($file);
       	$EMAILfrom 					= $this->EMAIL_FROM;
		$this->Email->to 	  	= $emailDetails['AcrClientContact']['email'];
		$this->Email->cc		= array('ganesh@carmatec.com','venugopal@carmatec.com');
        $this->Email->subject 	= 'Quote';
   		$this->Email->replyTo 	= $EMAILfrom;
    	$this->Email->from 		= $EMAILfrom;
    	$this->Email->template 	= $template;
   		$this->Email->sendAs 	= 'html' ;
   		if($this->Email->send()) {
   			return 'Open';
   		} else {
			return 'Draft';
		}
	}
	
	
	public function previewCommon() {
		$template 	= $this->data['AcrClientInvoice']['email_template'];
		$id 		= $this->data['AcrClientInvoice']['id'];
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->SlsQuotation->recursive = 0;
		$this->SlsQuotation->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
		$quote = $this->SlsQuotation->findById($id,array('SlsQuotation.*','AcrClient.id','AcrClient.client_no','AcrClient.client_name','AcrClient.organization_name','AcrClient.billing_address_line1','AcrClient.billing_address_line2','AcrClient.billing_city','AcrClient.billing_state','AcrClient.billing_country','AcrClient.billing_zip'));
		debug($quote);
		$organisationDetails = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'),
			array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$this->SlsQuotationProduct->recursive = 0;
		$this->SlsQuotation->unbindModel(array('belongsTo'=>array('SlsQuotation')));
		$quoteProducts = $this->SlsQuotationProduct->find('all',array('conditions'=>array('SlsQuotationProduct.sls_quotation_id' => $quote['SlsQuotation']['id']),'fields'=>array('SlsQuotationProduct.*','InvInventory.name','InvInventory.inv_inventory_unit_type_id','InvInventory.description','InvInventory.list_price','SbsSubscriberTax.id','SbsSubscriberTaxGroup.id')));
		$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
		foreach ($quoteProducts as $key => $value) {
			$InvoiceArray[$key]['AcrInvoiceDetail'] = $value['SlsQuotationProduct'];
		}
		$taxCalcuations = $this->getTaxCalculation($InvoiceArray);
		$this->loadModel('InvInventoryUnitType');
		$unitTypeList = $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$this->set(compact('unitTypeList','template','quote','organisationDetails','quoteProducts','settings','defaultCurrencyInfo','taxCalcuations','customer','price','status','from','to','page'));
	}

	
	public function sendMailQuotationCommon($quotation = 0, $customer = 0, $min = 0, $max = 0, $status = 0, $from = 0, $to = 0, $page = 0) {
		$template 	= $this->data['AcrClientInvoice']['email_template'];
		if(!$quotation) {
			$id	= $this->data['AcrClientInvoice']['id'];
		}
		
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrClientContact');
		$this->loadModel('InvInventory');
		$this->loadModel('SbsSubscriberTax');
		$this->SlsQuotation->recursive = 0;
		$this->SlsQuotation->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
		$quote = $this->SlsQuotation->findById($id,array('SlsQuotation.*','AcrClient.id','AcrClient.client_no','AcrClient.client_name','AcrClient.organization_name','AcrClient.billing_address_line1','AcrClient.billing_address_line2','AcrClient.billing_city','AcrClient.billing_state','AcrClient.billing_country','AcrClient.billing_zip'));
		$organisationDetails = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'),
			array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));
		$quoteProducts = $this->SlsQuotationProduct->find('all',array('conditions'=>array('SlsQuotationProduct.sls_quotation_id' => $quote['SlsQuotation']['id'])));
		foreach ($quoteProducts as $key => $value) {
			$InvoiceArray[$key]['AcrInvoiceDetail'] = $value['SlsQuotationProduct'];
		}
		$taxCalcuations = $this->getTaxCalculation($InvoiceArray);
		
		$filePath 	= $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/quotes/Subscriber-".$this->subscriber.'/';
		$this->generatePdf($template,$id);
		$file		= $quote['SlsQuotation']['quotation_no'].'.pdf';
		$this->loadModel('InvInventoryUnitType');
		$unitTypeList 		= $this->InvInventoryUnitType->getUnitTypeList($this->subscriber);
		$inventories 		= $this->InvInventory->getListOfInventory($this->subscriber);
		$taxes 				= $this->SbsSubscriberTax->getTaxesBySubscriber($this->subscriber);
		$settings 			= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		
		foreach ($quoteProducts as $key => $value) {
			$InvoiceArray[$key]['AcrInvoiceDetail'] 				= $value['SlsQuotationProduct'];
			$data['AcrClientInvoice']['inventory'][$key]			= $value['SlsQuotationProduct']['inv_inventory_id'];
			$data['AcrClientInvoice']['description'][$key]			= $value['SlsQuotationProduct']['inventory_description'];
			$data['AcrClientInvoice']['quantity'][$key]				= $value['SlsQuotationProduct']['quantity'];
			$data['AcrClientInvoice']['unit_rate'][$key]			= $value['SlsQuotationProduct']['unit_rate'];
			$data['AcrClientInvoice']['discount_percent'][$key] 	= $value['SlsQuotationProduct']['discount_percent'];
			$data['AcrClientInvoice']['line_total_hidden'][$key]	= $value['SlsQuotationProduct']['line_total'];
			$data['AcrClientInvoice']['unitTypeofInventory'][$key]  = $unitTypeList[$value['SlsQuotationProduct']['inv_inventory_id']];
		}
		
		$data['AcrClientInvoice']['quote_no'] 							= $quote['SlsQuotation']['quotation_no'];
		$data['AcrClientInvoice']['issueDate']							= date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['issue_date']));
		$data['AcrClientInvoice']['expiryDate']							= date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['expiry_date']));
		$data['AcrClientInvoice']['purchase_order_no']					= $quote['SlsQuotation']['purchase_order_no'];
		$data['AcrClientInvoice']['terms']								= $quote['SlsQuotation']['term_conditions'];
		$data['AcrClientInvoice']['conversionValue']					= $quote['SlsQuotation']['exchange_rate'];
		$data['AcrClientInvoice']['invoice_currency_code']				= $quote['SlsQuotation']['invoice_currency_code'];
		$data['AcrClientInvoice']['subTotal']							= $quote['SlsQuotation']['sub_total'];
		$data['AcrClientInvoice']['invoicetotal']						= $quote['SlsQuotation']['invoice_amount'];
		
		foreach ($taxCalcuations as $taxID => $taxDetails) {
			$data['AcrClientInvoice']['taxValue'][$taxID] = $taxDetails['taxAmount'];
		}
		
		$customerDetails['AcrClient']['client_name'] 					= $quote['AcrClient']['client_name'];
		$customerDetails['AcrClient']['organization_name'] 				= $quote['AcrClient']['organization_name'];
		$customerDetails['AcrClient']['billing_address_line1'] 			= $quote['AcrClient']['billing_address_line1'];
		$customerDetails['AcrClient']['billing_address_line2'] 			= $quote['AcrClient']['billing_address_line2'];
		$customerDetails['AcrClient']['billing_city'] 					= $quote['AcrClient']['billing_city'];
		$customerDetails['AcrClient']['billing_state'] 					= $quote['AcrClient']['billing_state'];
		$customerDetails['AcrClient']['billing_country'] 				= $quote['AcrClient']['billing_country'];
		$customerDetails['AcrClient']['billing_zip'] 					= $quote['AcrClient']['billing_zip'];
		
		$this->set(compact('customerDetails','data','inventories','taxes','organisationDetails'));
		$emailDetails = $this->AcrClientContact->getClientPrimaryContactDetail($quote['AcrClient']['id']);
       	$from_email 			= $this->EMAIL_FROM;
		$this->Email->to 	  	= trim($emailDetails['AcrClientContact']['email']);
		$this->Email->cc		= array('ganesh@carmatec.com','venugopal@carmatec.com');
        $this->Email->subject 	= 'Quote';
        $this->Email->filePaths   = array($filePath);
       	$this->Email->attachments = array($file);
   		$this->Email->replyTo 	= 'admin@cantorix.com';
    	$this->Email->from 		= 'admin@cantorix.com';
    	$this->Email->template 	= $template;
   		$this->Email->sendAs 	= 'html' ;
		try {
			if($this->Email->send()) {
				$updateQuote['SlsQuotation']['id'] 		= $id;
				$updateQuote['SlsQuotation']['status'] 	= 'Open';
				$this->SlsQuotation->save($updateQuote);
				
	   			$this->Session->setFlash(__('<div class="alert alert-block alert-success">Quote has been sent.</div>'));
	   		} else {
				$this->Session->setFlash('<div class="alert alert-danger">Error occurred while sending quote.</div>');
			}
			$this->redirect(array('action'=>'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page));
		} catch (Exception $e) {
			$this->Session->setFlash('<div class="alert alert-danger">Error occurred while sending quote.</div>');
			$this->redirect(array('action'=>'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page));
		}
	}
	
	
	public function generateQuoteNumber($subscriberId = null) {
		$this->loadModel('SbsSubscriberSetting');
		$settings			= $this->SbsSubscriberSetting->defaultSettings($subscriberId);
		$quoteFormat 		= $settings['SbsSubscriberSetting']['quote_number_format'];
		$lastQuote 			= $this->SlsQuotation->find('first',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$this->subscriber,'SlsQuotation.quotation_no LIKE'=>$quoteFormat.'%'),'fields'=>array('quotation_no'),'order'=>array('quotation_no'=>'Desc')));
		$final				= explode($quoteFormat, $lastQuote['SlsQuotation']['quotation_no']);
		$fTotalQuote 		= $this->SlsQuotation->find('count',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$this->subscriber)));
		if($fTotalQuote == 0) {
			$totalQuote			 = 1;
			$formattedNumber     = sprintf('%07d', $totalQuote);
			$newQuoteNumber	     = $quoteFormat.$formattedNumber;
		} else {
			$totalQuote 		= $final[1];
			do {
				$totalQuote++;
				$formattedNumber     = sprintf('%07d', $totalQuote);
				$newQuoteNumber	     = $quoteFormat.$formattedNumber;
				$quoteExist = $this->SlsQuotation->find('first',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$this->subscriber,'SlsQuotation.quotation_no'=>$newQuoteNumber),'fields'=>array('id')));
			} while (!empty($quoteExist));
		}
		
		return $newQuoteNumber;
	}
	
	
	public function checkQuotationNo($quoteNo1 = NULL){
		$this->autoRender = FALSE;
		$quoteNo = $this->data['AcrClientInvoice']['quote_no'];
		if($quoteNo1) {
			if($quoteNo == $quoteNo1) {
				return 'false';
			}
		}
		$quoteExist = $this->SlsQuotation->find('first',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$this->subscriber,'SlsQuotation.quotation_no'=>$quoteNo),'fields'=>array('id')));
		if(empty($quoteExist)) {
			return 'false';
		} else {
			return 'true';
		}
	}
	
	public function generatePdf($template = NULL,$id = NULL) {
		//Configure::write('debug',2);
		try {
			$dir = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/quotes/Subscriber-".$this->subscriber."/";
			$createDir = "files/uploads/quotes/Subscriber-".$this->subscriber."/";
			if (!file_exists($dir) && !is_dir($dir)) {
				$tmp = $_SERVER['DOCUMENT_ROOT'].$this->webroot."app/webroot/files/uploads/quotes/";
				if(!file_exists($tmp) && !is_dir($tmp)) {
					mkdir($tmp);
				}
				mkdir($dir);        
			} else {
				//echo 'Directory exist';
			}
			$this->set('subscriberID',$this->subscriber);
			$this->set(compact('quoteID'));
			  
			$this->loadModel('SbsSubscriberOrganizationDetail');
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('CpnCurrency');
			$this->SlsQuotation->recursive = 0;
			$this->SlsQuotation->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
			$quote = $this->SlsQuotation->findById($id,array('SlsQuotation.*','AcrClient.id','AcrClient.client_no','AcrClient.client_name','AcrClient.organization_name','AcrClient.billing_address_line1','AcrClient.billing_address_line2','AcrClient.billing_city','AcrClient.billing_state','AcrClient.billing_country','AcrClient.billing_zip'));
			$organisationDetails = $this->SbsSubscriberOrganizationDetail->findById($this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id'),
				array('id','organization_name','billing_address_line1','billing_address_line2','billing_city','billing_state','billing_country','billing_zip','logo'));
			$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$this->SlsQuotationProduct->recursive = 0;
			$this->SlsQuotation->unbindModel(array('belongsTo'=>array('SlsQuotation')));
			$quoteProducts = $this->SlsQuotationProduct->find('all',array('conditions'=>array('SlsQuotationProduct.sls_quotation_id' => $quote['SlsQuotation']['id']),'fields'=>array('SlsQuotationProduct.*','InvInventory.name','InvInventory.description','InvInventory.list_price','SbsSubscriberTax.id','SbsSubscriberTaxGroup.id')));
			$defaultCurrencyInfo = $this->CpnCurrency->getCurrencyById($settings['SbsSubscriberSetting']['cpn_currency_id']);
			foreach ($quoteProducts as $key => $value) {
				$InvoiceArray[$key]['AcrInvoiceDetail'] = $value['SlsQuotationProduct'];
			}
			$taxCalcuations = $this->getTaxCalculation($InvoiceArray);
			$this->set(compact('quote','organisationDetails','quoteProducts','settings','defaultCurrencyInfo','taxCalcuations'));
			 
			$this->layout = '/pdf/default';
			$this->render('/Pdf/'.$template);
			return $quote['SlsQuotation']['quotation_no'].'pdf';
		} catch(Exception $e) {
			return FALSE;
		}
	}
	
}
 
?>