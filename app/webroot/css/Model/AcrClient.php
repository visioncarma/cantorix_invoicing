<?php
App::uses('AppModel', 'Model');
/**
 * AcrClient Model
 *
 * @property CpnLanguage $CpnLanguage
 * @property CpnCurrency $CpnCurrency
 * @property SbsSubscriber $SbsSubscriber
 * @property AcrClientContact $AcrClientContact
 * @property AcrClientCustomValue $AcrClientCustomValue
 * @property AcrClientInvoice $AcrClientInvoice
 * @property AcrInventoryInvoice $AcrInventoryInvoice
 * @property AcrInvoicePaymentDetail $AcrInvoicePaymentDetail
 * @property SlsQuotation $SlsQuotation
 */
class AcrClient extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'client_no' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'client_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		//'business_phone' => array(
			//'phone' => array(
			//	'rule' => array('phone'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//),
		//),
		//'business_fax' => array(
		//	'phone' => array(
		//		'rule' => array('phone'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//),
		//),
		//'cpn_language_id' => array(
		//	'numeric' => array(
		//		'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			//),
		//),
		'cpn_currency_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'sbs_subscriber_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CpnLanguage' => array(
			'className' => 'CpnLanguage',
			'foreignKey' => 'cpn_language_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CpnCurrency' => array(
			'className' => 'CpnCurrency',
			'foreignKey' => 'cpn_currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SbsSubscriber' => array(
			'className' => 'SbsSubscriber',
			'foreignKey' => 'sbs_subscriber_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'AcrClientContact' => array(
			'className' => 'AcrClientContact',
			'foreignKey' => 'acr_client_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AcrClientCustomValue' => array(
			'className' => 'AcrClientCustomValue',
			'foreignKey' => 'acr_client_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AcrClientInvoice' => array(
			'className' => 'AcrClientInvoice',
			'foreignKey' => 'acr_client_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AcrInventoryInvoice' => array(
			'className' => 'AcrInventoryInvoice',
			'foreignKey' => 'acr_client_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AcrInvoicePaymentDetail' => array(
			'className' => 'AcrInvoicePaymentDetail',
			'foreignKey' => 'acr_client_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SlsQuotation' => array(
			'className' => 'SlsQuotation',
			'foreignKey' => 'acr_client_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	
/******@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ DONT DELETE/CHANGE ANY CODE BELOW WITHOUT INTIMATION @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@******/
/**
 * @Author Ganesh
 * @Since 9-Jun-2014
 * @Version v.1
 * @Param subscriber id 
 * @Method Archive Client related data
 * **/
	public function archiveData($subscriberId = NULL) {
		
		$dataSource0 = ConnectionManager::getDataSource('default');
		$defaultDatabase =  $dataSource0->config['database'];
		$defaultConfigVar = 'default';
		
		$dataSource = ConnectionManager::getDataSource('archive');
		$archiveDatabase = $dataSource->config['database'];
		$archiveConfigVar = 'archive';
		
		/* Get all required data from client module tables*/
		
		$SbsSubscriberPaymentTerm = ClassRegistry::init('SbsSubscriberPaymentTerm');
		$paymentTerms = $SbsSubscriberPaymentTerm->find('all',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id' => $subscriberId)));
		
		$SbsSubscriberCpnCurrencyMapping = ClassRegistry::init('SbsSubscriberCpnCurrencyMapping');
		$currencyMappings = $SbsSubscriberCpnCurrencyMapping->find('all',array('conditions'=>array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id' => $subscriberId)));
			
		$clients = $this->find('all',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
		$clientIds = $this->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
		
		$AcrClientContact = ClassRegistry::init('AcrClientContact'); 
		$clientContacts =  $AcrClientContact->find('all',array('conditions'=>array('AcrClientContact.acr_client_id'=>$clientIds)));
		
		$AcrClientCustomField = ClassRegistry::init('AcrClientCustomField');
		$clientFields = $AcrClientCustomField->find('all',array('conditions'=>array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId)));
		
		$AcrClientCustomValue = ClassRegistry::init('AcrClientCustomValue');
		$clientCustomValues = $AcrClientCustomValue->find('all',array('conditions'=>array('AcrClientCustomValue.acr_client_id'=>$clientIds)));
		
		$InvInventory = ClassRegistry::init('InvInventory');
		$inventories = $InvInventory->find('all',array('conditions'=>array('InvInventory.sbs_subscriber_id'=>$subscriberId)));
		
		$AcpExpenseCategory = ClassRegistry::init('AcpExpenseCategory');
		$expensecatogries = $AcpExpenseCategory->find('all',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId))); 
		
		$AcpExpense = ClassRegistry::init('AcpExpense');
		$expenses = $AcpExpense->find('all',array('conditions'=>array('AcpExpense.sbs_subscriber_id'=>$subscriberId))); 
		
		$AcpInventoryExpense = ClassRegistry::init('AcpInventoryExpense');
		$inventoryExpenses = $AcpInventoryExpense->find('all',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId)));
		$inventoryExpenseIds = $AcpInventoryExpense->find('list',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcpInventoryExpense.id','AcpInventoryExpense.id')));
		
		$AcrInventoryInvoice = ClassRegistry::init('AcrInventoryInvoice');
		$inventoryInvoices = $AcrInventoryInvoice->find('all',array('conditions'=>array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds))); 
		
		$SbsSubscriberTax = ClassRegistry::init('SbsSubscriberTax');
		$taxes =  $SbsSubscriberTax->find('all',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId)));
		$taxIds = $SbsSubscriberTax->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.id')));
		
		$SbsSubscriberTaxGroup = ClassRegistry::init('SbsSubscriberTaxGroup');
		$taxgroups =  $SbsSubscriberTaxGroup->find('all',array('conditions'=>array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId)));
		
		$SbsSubscriberTaxGroupMapping = ClassRegistry::init('SbsSubscriberTaxGroupMapping');
		$taxgroupMappings =  $SbsSubscriberTaxGroupMapping->find('all',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxIds)));
		
		$SlsQuotation = ClassRegistry::init('SlsQuotation');
		$quotations = $SlsQuotation->find('all',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId)));
		$quotationIds = $SlsQuotation->find('list',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotation.id')));
		
		$SlsQuotationProduct = ClassRegistry::init('SlsQuotationProduct');
		$quotationProducts = $SlsQuotationProduct->find('all',array('conditions'=>array('SlsQuotationProduct.sls_quotation_id'=>$quotationIds)));
		
		$SlsQuotationCustomField = ClassRegistry::init('SlsQuotationCustomField');
		$quotationCustomFields = $SlsQuotationCustomField->find('all',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId)));
		$quotationCustomFieldIds = $SlsQuotationCustomField->find('list',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotationCustomField.id','SlsQuotationCustomField.id')));
		
		$SlsQuotationCustomValue = ClassRegistry::init('SlsQuotationCustomValue');
		$quotationCustomValues = $SlsQuotationCustomValue->find('all',array('conditions'=>array('SlsQuotationCustomValue.sls_quotation_custom_field_id'=>$quotationCustomFieldIds)));
		
		$AcrClientInvoice = ClassRegistry::init('AcrClientInvoice');
		$clientInvoices = $AcrClientInvoice->find('all',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId)));
		$clientInvoiceIds = $AcrClientInvoice->find('list',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClientInvoice.id','AcrClientInvoice.id')));
		 
		$AcrInvoiceCustomField = ClassRegistry::init('AcrInvoiceCustomField');
		$invoiceCustomFields = $AcrInvoiceCustomField->find('all',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId)));
		$invoiceCustomFieldIds = $AcrInvoiceCustomField->find('list',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoiceCustomField.id','AcrInvoiceCustomField.id')));
		
		$AcrInvoiceCustomValue = ClassRegistry::init('AcrInvoiceCustomValue');
		$invoiceCustomValues = $AcrInvoiceCustomValue->find('all',array('conditions'=>array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds)));
		
		$AcrInvoiceDetail = ClassRegistry::init('AcrInvoiceDetail');
		$invoiceDetails = $AcrInvoiceDetail->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds)));
		
		$AcrInvoicePaymentDetail = ClassRegistry::init('AcrInvoicePaymentDetail');
		$payments = $AcrInvoicePaymentDetail->find('all',array('conditions'=>array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId)));
		
		$AcrClientRecurringInvoice = ClassRegistry::init('AcrClientRecurringInvoice');
		$recurringPayments = $AcrClientRecurringInvoice->find('all',array('conditions'=>array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds)));
		
		
		/* End Get all required data from client module tables*/
		
		
		/*Connect Archive database */
		$this->useDbConfig = $configVar;
		$this->schemaName = $defaultDatabase;
		
		$AcrClientContact->useDbConfig = $archiveConfigVar;
		$AcrClientContact->schemaName = $archiveDatabase;
		
		$AcrClientCustomField->useDbConfig = $archiveConfigVar;
		$AcrClientCustomField->schemaName = $archiveDatabase;
		
		$AcrClientCustomValue->useDbConfig = $archiveConfigVar;
		$AcrClientCustomValue->schemaName = $archiveDatabase;
		
		$InvInventory->useDbConfig = $archiveConfigVar;
		$InvInventory->schemaName = $archiveDatabase;
		
		$AcpExpenseCategory->useDbConfig =  $archiveConfigVar;
		$AcpExpenseCategory->schemaName = $archiveDatabase;
		
		$AcpExpense->useDbConfig =  $archiveConfigVar;
		$AcpExpense->schemaName = $archiveDatabase;
		
		$AcpInventoryExpense->useDbConfig =  $archiveConfigVar;
		$AcpInventoryExpense->schemaName = $archiveDatabase;
		
		$AcrInventoryInvoice->useDbConfig =  $archiveConfigVar;
		$AcrInventoryInvoice->schemaName = $archiveDatabase;
		
		$SbsSubscriberTax->useDbConfig =  $archiveConfigVar;
		$SbsSubscriberTax->schemaName = $archiveDatabase;
		
		$SbsSubscriberTaxGroup->useDbConfig =  $archiveConfigVar;
		$SbsSubscriberTaxGroup->schemaName = $archiveDatabase;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig =  $archiveConfigVar;
		$SbsSubscriberTaxGroupMapping->schemaName = $archiveDatabase;
		
		$SlsQuotation->useDbConfig =  $archiveConfigVar;
		$SlsQuotation->schemaName = $archiveDatabase;
		
		$SlsQuotationProduct->useDbConfig =  $archiveConfigVar;
		$SlsQuotationProduct->schemaName = $archiveDatabase;
		
		$SlsQuotationCustomField->useDbConfig =  $archiveConfigVar;
		$SlsQuotationCustomField->schemaName = $archiveDatabase;
		
		$SlsQuotationCustomValue->useDbConfig =  $archiveConfigVar;
		$SlsQuotationCustomValue->schemaName = $archiveDatabase;
		
		$AcrClientInvoice->useDbConfig =  $archiveConfigVar;
		$AcrClientInvoice->schemaName = $archiveDatabase;
		
		$AcrInvoiceCustomField->useDbConfig =  $archiveConfigVar;
		$AcrInvoiceCustomField->schemaName = $archiveDatabase;
		
		$AcrInvoiceCustomValue->useDbConfig =  $archiveConfigVar;
		$AcrInvoiceCustomValue->schemaName = $archiveDatabase;
		
		$AcrInvoiceDetail->useDbConfig =  $archiveConfigVar;
		$AcrInvoiceDetail->schemaName = $archiveDatabase;
		
		$AcrInvoicePaymentDetail->useDbConfig =  $archiveConfigVar;
		$AcrInvoicePaymentDetail->schemaName = $archiveDatabase;
		
		$AcrClientRecurringInvoice->useDbConfig =  $archiveConfigVar;
		$AcrClientRecurringInvoice->schemaName = $archiveDatabase;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig =  $archiveConfigVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName = $archiveDatabase;
		
		$SbsSubscriberPaymentTerm->useDbConfig =  $archiveConfigVar;
		$SbsSubscriberPaymentTerm->schemaName = $archiveDatabase;
		/*Connecting Database*/
		
		/*Payment terms Insert*/
		foreach ($paymentTerms as $paymentTerm) {
			$SbsSubscriberPaymentTerm->save($paymentTerm);
		}
		/*Payment terms Insert*/
		
		/*Currency Mappings Insert*/
		foreach ($currencyMappings as $currency) {
			$SbsSubscriberCpnCurrencyMapping->save($currency);
		}
		/*Currency Mappings Insert*/
		
		/*Clients Insert*/
		foreach($clients as $clientInsert) {
			$this->save($clientInsert);
		}
		/*End Clients Insert*/
		
		/*Client Contacts Insert*/
		foreach($clientContacts as $clientContact) {
			$AcrClientContact->save($clientInsert);
		}
		/*End Client Contacts Insert*/
		
		/*Client Custom fields Insert*/
		foreach($clientFields as $clientField) {
			$AcrClientCustomField->save($clientField);
		}
		/*End Client Custom fields Insert*/
		
		/*Client Custom values Insert*/
		foreach($clientCustomValues as $clientCustomValue) {
			$AcrClientCustomValue->save($clientCustomValue);
		}
		/*End Client Custom fields Insert*/
		
		/*Inventories Insert*/
		foreach($inventories as $inventory) {
			$InvInventory->save($inventory);
		}
		/*Inventories Insert*/
		
		/*Expense category Insert*/
		foreach($expensecatogries as $expensecatogry) {
			$AcpExpenseCategory->save($expensecatogry);
		}
		/*Expense category Insert*/
		
		/*Expense Insert*/
		foreach($expenses as $expense) {
			$AcpExpense->save($expense);
		}
		/*Expense Insert*/
		
		/*Inventory Expenses Insert*/
		foreach($inventoryExpenses as $inventoryExpense) {
			$AcpInventoryExpense->save($inventoryExpense);
		}
		/*Inventory Expenses Insert*/
		
		/*Inventory expense invoices insert*/
		foreach ($inventoryInvoices as $inventoryInvoice) {
			$AcrInventoryInvoice->save($inventoryInvoice);
		}
		/*Inventory expense invoices insert*/
		
		/*Taxes Insert*/
		foreach($taxes as $tax) {
			$SbsSubscriberTax->save($tax);
		}
		/*Taxes Insert*/
		
		/*Tax group Insert*/
		foreach($taxgroups as $taxgroup) {
			$SbsSubscriberTaxGroup->save($taxgroup);
		}
		/*Tax group Insert*/
		
		/*Tax group mappings Insert*/
		foreach($taxgroupMappings as $taxgroupMapping) {
			$SbsSubscriberTaxGroupMapping->save($taxgroupMapping);
		}
		/*Tax group mappings Insert*/
		
		/*Quotation Insert*/
		foreach($quotations as $quotation) {
			$SlsQuotation->save($quotation);
		}
		/*Quotation Insert*/
		
		/*Quotation products Insert*/
		foreach($quotationProduct as $quotationProduct) {
			$SlsQuotationProduct->save($quotationProduct);
		}
		/*Quotation products Insert*/
		
		/*Quotation custom fields Insert*/
		foreach($quotationCustomFields as $quotationCustomField) {
			$SlsQuotationCustomField->save($quotationCustomField);
		}
		/*Quotation custom fields Insert*/
		
		/*Quotation custom values Insert*/
		foreach($quotationCustomValues as $quotationCustomValue) {
			$SlsQuotationCustomValue->save($quotationCustomValue);
		}
		/*Quotation custom values Insert*/
		
		/*Invoices Insert*/
		foreach($clientInvoices as $clientInvoice) {
			$AcrClientInvoice->save($clientInvoice);
		}
		/*Invoices Insert*/
		
		/*Invoices custom values Insert*/
		foreach($invoiceCustomFields as $invoiceCustomField) {
			$AcrInvoiceCustomField->save($invoiceCustomField);
		}
		/*Invoices custom values Insert*/
		
		/*Invoices custom values Insert*/
		foreach($invoiceCustomValues as $invoiceCustomValue) {
			$AcrInvoiceCustomValue->save($invoiceCustomValue);
		}
		/*Invoices custom values Insert*/
		
		/*Invoices details Insert*/
		foreach($invoiceDetails as $invoiceDetail) {
			$AcrInvoiceDetail->save($invoiceDetail);
		}
		/*Invoices details Insert*/
		
		/*Recurring Invoices details Insert*/
		foreach($recurringPayments as $recurringPayment) {
			$AcrClientRecurringInvoice->save($recurringPayment);
		}
		/*Recurring Invoices details Insert*/
		
		/*Invoice payments Insert*/
		foreach($payments as $payment) {
			$AcrInvoicePaymentDetail->save($payment);
		}
		/*Invoices payments Insert*/
		
		/*Disconnect Archive database & Start default(cantorix) connection*/
		$this->useDbConfig = $defaultConfigVar;
		$this->schemaName = $defaultDatabase;
		
		
		$AcrClientContact->useDbConfig = $defaultConfigVar;
		$AcrClientContact->schemaName = $defaultDatabase;
		
		$AcrClientCustomField->useDbConfig =  $defaultConfigVar;
		$AcrClientCustomField->schemaName = $defaultDatabase;
		
		$AcrClientCustomValue->useDbConfig =  $defaultConfigVar;
		$AcrClientCustomValue->schemaName = $defaultDatabase;
		
		$InvInventory->useDbConfig =  $defaultConfigVar;
		$InvInventory->schemaName = $defaultDatabase;
		
		$AcpExpenseCategory->useDbConfig =  $defaultConfigVar;
		$AcpExpenseCategory->schemaName = $defaultDatabase;
		
		$AcpExpense->useDbConfig =  $defaultConfigVar;
		$AcpExpense->schemaName = $defaultDatabase;
		
		$AcpInventoryExpense->useDbConfig =  $defaultConfigVar;
		$AcpInventoryExpense->schemaName = $defaultDatabase;
		
		$AcrInventoryInvoice->useDbConfig =  $defaultConfigVar;
		$AcrInventoryInvoice->schemaName = $defaultDatabase;
		
		$SbsSubscriberTax->useDbConfig =  $defaultConfigVar;
		$SbsSubscriberTax->schemaName = $defaultDatabase;
		
		$SbsSubscriberTaxGroup->useDbConfig =  $defaultConfigVar;
		$SbsSubscriberTaxGroup->schemaName = $defaultDatabase;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig =  $defaultConfigVar;
		$SbsSubscriberTaxGroupMapping->schemaName = $defaultDatabase;
		
		$SlsQuotation->useDbConfig =  $defaultConfigVar;
		$SlsQuotation->schemaName = $defaultDatabase;
		
		$SlsQuotationProduct->useDbConfig =  $defaultConfigVar;
		$SlsQuotationProduct->schemaName = $defaultDatabase;
		
		$SlsQuotationCustomField->useDbConfig =  $defaultConfigVar;
		$SlsQuotationCustomField->schemaName = $defaultDatabase;
		
		$SlsQuotationCustomValue->useDbConfig =  $defaultConfigVar;
		$SlsQuotationCustomValue->schemaName = $defaultDatabase;
		
		$AcrClientInvoice->useDbConfig =  $defaultConfigVar;
		$AcrClientInvoice->schemaName = $defaultDatabase;
		
		$AcrInvoiceCustomField->useDbConfig =  $defaultConfigVar;
		$AcrInvoiceCustomField->schemaName = $defaultDatabase;
		
		$AcrInvoiceCustomValue->useDbConfig =  $defaultConfigVar;
		$AcrInvoiceCustomValue->schemaName = $defaultDatabase;
		
		$AcrInvoiceDetail->useDbConfig =  $defaultConfigVar;
		$AcrInvoiceDetail->schemaName = $defaultDatabase;
		
		$AcrInvoicePaymentDetail->useDbConfig =  $defaultConfigVar;
		$AcrInvoicePaymentDetail->schemaName = $defaultDatabase;
		
		$AcrClientRecurringInvoice->useDbConfig = $defaultConfigVar;
		$AcrClientRecurringInvoice->schemaName = $defaultDatabase;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $defaultConfigVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName = $defaultDatabase;
		
		$SbsSubscriberPaymentTerm->useDbConfig = $defaultConfigVar;
		$SbsSubscriberPaymentTerm->schemaName = $defaultDatabase;
		/*End Disconnect Archive database  & Start default(cantorix) connection*/
		
		/*Delete All the archived records from cantorix database*/
		
		
		$SlsQuotationCustomValue->deleteAll(array('SlsQuotationCustomValue.sls_quotation_custom_field_id'=>$quotationCustomFieldIds), FALSE);
		$SlsQuotationCustomField->deleteAll(array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$SlsQuotationProduct->deleteAll(array('SlsQuotationProduct.sls_quotation_id'=>$quotationIds), FALSE);
		$SlsQuotation->deleteAll(array('SlsQuotation.sbs_subscriber_id'=>$subscriberId), FALSE);
		
		/*Invoice related Deletions*/
		$AcrInvoicePaymentDetail->deleteAll(array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientRecurringInvoice->deleteAll(array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceDetail->deleteAll(array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceCustomValue->deleteAll(array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds), FALSE);
		$AcrInvoiceCustomField->deleteAll(array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientInvoice->deleteAll(array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Invoice related Deletions*/
		
		/*Expense Deletions*/
		$AcpInventoryExpense->recursive = -1;
		$AcrInventoryInvoice->deleteAll(array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds),FALSE);
		$AcpInventoryExpense->deleteAll(array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
		$AcpExpense->deleteAll(array('AcpExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
		$AcpExpenseCategory->deleteAll(array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*Expense Deletions*/
		
		
		
		/*Client related Deletions*/
		$AcrClientCustomValue->deleteAll(array('AcrClientCustomValue.acr_client_id'=>$clientIds),FALSE);
		$AcrClientCustomField->deleteAll(array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientContact->deleteAll(array('AcrClientContact.acr_client_id'=>$clientIds), FALSE);
		$this->deleteAll(array('AcrClient.sbs_subscriber_id' => $subscriberId),FALSE);
		/*Client related Deletions*/
		
		/*Currency mapping Deletion*/
		$SbsSubscriberCpnCurrencyMapping->deleteAll(array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Currency mapping Deletion*/
		
		/*Payment Terms Deletion*/
		$SbsSubscriberPaymentTerm->deleteAll(array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Payment Terms Deletion*/
		
		/*inventory Deletion*/
		$InvInventory->deleteAll(array('InvInventory.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*Inventory Deletion*/
		
		/*Tax related deletions*/
		$SbsSubscriberTaxGroupMapping->deleteAll(array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxIds), FALSE);
		$SbsSubscriberTaxGroup->deleteAll(array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId),FALSE);
		$SbsSubscriberTax->deleteAll(array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*Tax related deletions*/
		
		
		/*End Delete All the archived records from cantorix database*/
		echo 'Completed';
		return TRUE;
	}


/**
 * @Author Ganesh
 * @Since 9-Jun-2014
 * @Version v.1
 * @Param subscriber id 
 * @Method Archive Client related data
 * **/
	public function restoreArchivedData($subscriberId = NULL) {
		
		$dataSource0 = ConnectionManager::getDataSource('default');
		$defaultDatabase =  $dataSource0->config['database'];
		$defaultConfigVar = 'default';
		
		$dataSource = ConnectionManager::getDataSource('archive');
		$archiveDatabase = $dataSource->config['database'];
		$archiveConfigVar = 'archive';
		
		
		/*Loading all required models*/
		$AcrClientContact = ClassRegistry::init('AcrClientContact');
		$AcrClientCustomField = ClassRegistry::init('AcrClientCustomField');
		$AcrClientCustomValue = ClassRegistry::init('AcrClientCustomValue');
		$InvInventory = ClassRegistry::init('InvInventory');
		$AcpExpenseCategory = ClassRegistry::init('AcpExpenseCategory');
		$AcpExpense = ClassRegistry::init('AcpExpense');
		$AcpInventoryExpense = ClassRegistry::init('AcpInventoryExpense');
		$AcrInventoryInvoice = ClassRegistry::init('AcrInventoryInvoice');
		$SbsSubscriberTax = ClassRegistry::init('SbsSubscriberTax');
		$SbsSubscriberTaxGroup = ClassRegistry::init('SbsSubscriberTaxGroup');
		$SbsSubscriberTaxGroupMapping = ClassRegistry::init('SbsSubscriberTaxGroupMapping');
		$SlsQuotation = ClassRegistry::init('SlsQuotation');
		$SlsQuotationProduct = ClassRegistry::init('SlsQuotationProduct');
		$SlsQuotationCustomField = ClassRegistry::init('SlsQuotationCustomField');
		$SlsQuotationCustomValue = ClassRegistry::init('SlsQuotationCustomValue');
		$AcrClientInvoice = ClassRegistry::init('AcrClientInvoice');
		$AcrInvoiceCustomField = ClassRegistry::init('AcrInvoiceCustomField');
		$AcrInvoiceCustomValue = ClassRegistry::init('AcrInvoiceCustomValue');
		$AcrInvoicePaymentDetail = ClassRegistry::init('AcrInvoicePaymentDetail');
		$AcrInvoiceDetail = ClassRegistry::init('AcrInvoiceDetail');
		$AcrClientRecurringInvoice = ClassRegistry::init('AcrClientRecurringInvoice');
		$SbsSubscriberPaymentTerm = ClassRegistry::init('SbsSubscriberPaymentTerm');
		$SbsSubscriberCpnCurrencyMapping = ClassRegistry::init('SbsSubscriberCpnCurrencyMapping');
		
		/*Loading all required models*/
		
		/*Connect Archive database */
		$this->useDbConfig = $archiveConfigVar;
		$this->schemaName = $archiveDatabase;
		
		$AcrClientContact->useDbConfig = $archiveConfigVar;
		$AcrClientContact->schemaName = $archiveDatabase;
		
		$AcrClientCustomField->useDbConfig = $archiveConfigVar;
		$AcrClientCustomField->schemaName = $archiveDatabase;
		
		$AcrClientCustomValue->useDbConfig = $archiveConfigVar;
		$AcrClientCustomValue->schemaName = $archiveDatabase;
		
		$InvInventory->useDbConfig = $archiveConfigVar;
		$InvInventory->schemaName = $archiveDatabase;
		
		$AcpExpenseCategory->useDbConfig = $archiveConfigVar;
		$AcpExpenseCategory->schemaName = $archiveDatabase;
		
		$AcpExpense->useDbConfig = $archiveConfigVar;
		$AcpExpense->schemaName = $archiveDatabase;
		
		$AcpInventoryExpense->useDbConfig = $archiveConfigVar;
		$AcpInventoryExpense->schemaName = $archiveDatabase;
		
		$AcrInventoryInvoice->useDbConfig = $archiveConfigVar;
		$AcrInventoryInvoice->schemaName = $archiveDatabase;
		
		$SbsSubscriberTax->useDbConfig = $archiveConfigVar;
		$SbsSubscriberTax->schemaName = $archiveDatabase;
		
		$SbsSubscriberTaxGroup->useDbConfig = $archiveConfigVar;
		$SbsSubscriberTaxGroup->schemaName = $archiveDatabase;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig = $archiveConfigVar;
		$SbsSubscriberTaxGroupMapping->schemaName = $archiveDatabase;
		
		$SlsQuotation->useDbConfig = $archiveConfigVar;
		$SlsQuotation->schemaName = $archiveDatabase;
		
		$SlsQuotationProduct->useDbConfig = $archiveConfigVar;
		$SlsQuotationProduct->schemaName = $archiveDatabase;
		
		$SlsQuotationCustomField->useDbConfig = $archiveConfigVar;
		$SlsQuotationCustomField->schemaName = $archiveDatabase;
		
		$SlsQuotationCustomValue->useDbConfig = $archiveConfigVar;
		$SlsQuotationCustomValue->schemaName =  $archiveDatabase;
		
		$AcrClientInvoice->useDbConfig = $archiveConfigVar;
		$AcrClientInvoice->schemaName = $archiveDatabase;
		
		$AcrInvoiceCustomField->useDbConfig = $archiveConfigVar;
		$AcrInvoiceCustomField->schemaName = $archiveDatabase;
		
		$AcrInvoiceCustomValue->useDbConfig = $archiveConfigVar;
		$AcrInvoiceCustomValue->schemaName = $archiveDatabase;
		
		$AcrInvoiceDetail->useDbConfig = $archiveConfigVar;
		$AcrInvoiceDetail->schemaName = $archiveDatabase;
		
		$AcrInvoicePaymentDetail->useDbConfig = $archiveConfigVar;
		$AcrInvoicePaymentDetail->schemaName = $archiveDatabase;
		
		$AcrClientRecurringInvoice->useDbConfig = $archiveConfigVar;
		$AcrClientRecurringInvoice->schemaName =  $archiveDatabase;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $archiveConfigVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName = $archiveDatabase;
		
		$SbsSubscriberPaymentTerm->useDbConfig = $archiveConfigVar;
		$SbsSubscriberPaymentTerm->schemaName = $archiveDatabase;
		
		/*Connecting Database*/
		
		/* Get all required data from client module tables*/
		
		$SbsSubscriberPaymentTerm = ClassRegistry::init('SbsSubscriberPaymentTerm');
		$paymentTerms = $SbsSubscriberPaymentTerm->find('all',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id' => $subscriberId)));
		
		$SbsSubscriberCpnCurrencyMapping = ClassRegistry::init('SbsSubscriberCpnCurrencyMapping');
		$currencyMappings = $SbsSubscriberCpnCurrencyMapping->find('all',array('conditions'=>array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id' => $subscriberId)));
			
		$clients = $this->find('all',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
		$clientIds = $this->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
		 
		$clientContacts =  $AcrClientContact->find('all',array('conditions'=>array('AcrClientContact.acr_client_id'=>$clientIds)));
		
		$clientFields = $AcrClientCustomField->find('all',array('conditions'=>array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId)));
		
		$clientCustomValues = $AcrClientCustomValue->find('all',array('conditions'=>array('AcrClientCustomValue.acr_client_id'=>$clientIds)));
		
		$inventories = $InvInventory->find('all',array('conditions'=>array('InvInventory.sbs_subscriber_id'=>$subscriberId)));
		
		$expensecatogries = $AcpExpenseCategory->find('all',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId))); 
		
		$expenses = $AcpExpense->find('all',array('conditions'=>array('AcpExpense.sbs_subscriber_id'=>$subscriberId))); 
		
		$inventoryExpenses = $AcpInventoryExpense->find('all',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId)));
		$inventoryExpenseIds = $AcpInventoryExpense->find('list',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcpInventoryExpense.id','AcpInventoryExpense.id')));
		
		$inventoryInvoices = $AcrInventoryInvoice->find('all',array('conditions'=>array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds))); 
		
		$taxes =  $SbsSubscriberTax->find('all',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId)));
		$taxIds = $SbsSubscriberTax->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.id')));
		
		$taxgroups =  $SbsSubscriberTaxGroup->find('all',array('conditions'=>array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId)));
		
		$taxgroupMappings =  $SbsSubscriberTaxGroupMapping->find('all',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxIds)));
		
		$quotations = $SlsQuotation->find('all',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId)));
		$quotationIds = $SlsQuotation->find('list',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotation.id')));
		
		$quotationProducts = $SlsQuotationProduct->find('all',array('conditions'=>array('SlsQuotationProduct.sls_quotation_id'=>$quotationIds)));
		
		$quotationCustomFields = $SlsQuotationCustomField->find('all',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId)));
		$quotationCustomFieldIds = $SlsQuotationCustomField->find('list',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotationCustomField.id','SlsQuotationCustomField.id')));
		
		$quotationCustomValues = $SlsQuotationCustomValue->find('all',array('conditions'=>array('SlsQuotationCustomValue.sls_quotation_custom_field_id'=>$quotationCustomFieldIds)));
		
		$clientInvoices = $AcrClientInvoice->find('all',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId)));
		$clientInvoiceIds = $AcrClientInvoice->find('list',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClientInvoice.id','AcrClientInvoice.id')));
		
		$invoiceCustomFields = $AcrInvoiceCustomField->find('all',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId)));
		$invoiceCustomFieldIds = $AcrInvoiceCustomField->find('list',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoiceCustomField.id','AcrInvoiceCustomField.id')));
		
		$invoiceCustomValues = $AcrInvoiceCustomValue->find('all',array('conditions'=>array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds)));
		
		$invoiceDetails = $AcrInvoiceDetail->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds)));
		
		$payments = $AcrInvoicePaymentDetail->find('all',array('conditions'=>array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId)));
		
		$recurringPayments = $AcrClientRecurringInvoice->find('all',array('conditions'=>array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds)));
		/* End Get all required data from client module tables*/
		
		
		/*Disconnect Archive database & Start default(cantorix) connection*/
		$this->useDbConfig = $defaultConfigVar;
		$this->schemaName = $defaultDatabase;
		
		$AcrClientContact->useDbConfig = $defaultConfigVar;
		$AcrClientContact->schemaName = $defaultDatabase;
		
		$AcrClientCustomField->useDbConfig = $defaultConfigVar;
		$AcrClientCustomField->schemaName = $defaultDatabase;
		
		$AcrClientCustomValue->useDbConfig = $defaultConfigVar;
		$AcrClientCustomValue->schemaName = $defaultDatabase;
		
		$InvInventory->useDbConfig = $defaultConfigVar;
		$InvInventory->schemaName = $defaultDatabase;
		
		$AcpExpenseCategory->useDbConfig = $defaultConfigVar;
		$AcpExpenseCategory->schemaName = $defaultDatabase;
		
		$AcpExpense->useDbConfig = $defaultConfigVar;
		$AcpExpense->schemaName = $defaultDatabase;
		
		$AcpInventoryExpense->useDbConfig = $defaultConfigVar;
		$AcpInventoryExpense->schemaName = $defaultDatabase;
		
		$AcrInventoryInvoice->useDbConfig = $defaultConfigVar;
		$AcrInventoryInvoice->schemaName = $defaultDatabase;
		
		$SbsSubscriberTax->useDbConfig = $defaultConfigVar;
		$SbsSubscriberTax->schemaName = $defaultDatabase;
		
		$SbsSubscriberTaxGroup->useDbConfig = $defaultConfigVar;
		$SbsSubscriberTaxGroup->schemaName = $defaultDatabase;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig = $defaultConfigVar;
		$SbsSubscriberTaxGroupMapping->schemaName = $defaultDatabase;
		
		$SlsQuotation->useDbConfig = $defaultConfigVar;
		$SlsQuotation->schemaName = $defaultDatabase;
		
		$SlsQuotationProduct->useDbConfig = $defaultConfigVar;
		$SlsQuotationProduct->schemaName = $defaultDatabase;
		
		$SlsQuotationCustomField->useDbConfig = $defaultConfigVar;
		$SlsQuotationCustomField->schemaName = $defaultDatabase;
		
		$SlsQuotationCustomValue->useDbConfig = $defaultConfigVar;
		$SlsQuotationCustomValue->schemaName = $defaultDatabase;
		
		$AcrClientInvoice->useDbConfig = $defaultConfigVar;
		$AcrClientInvoice->schemaName = $defaultDatabase;
		
		$AcrInvoiceCustomField->useDbConfig = $defaultConfigVar;
		$AcrInvoiceCustomField->schemaName = $defaultDatabase;
		
		$AcrInvoiceCustomValue->useDbConfig = $defaultConfigVar;
		$AcrInvoiceCustomValue->schemaName = $defaultDatabase;
		
		$AcrInvoiceDetail->useDbConfig = $defaultConfigVar;
		$AcrInvoiceDetail->schemaName = $defaultDatabase;
		
		$AcrInvoicePaymentDetail->useDbConfig = $defaultConfigVar;
		$AcrInvoicePaymentDetail->schemaName = $defaultDatabase;
		
		$AcrClientRecurringInvoice->useDbConfig = $defaultConfigVar;
		$AcrClientRecurringInvoice->schemaName = $defaultDatabase;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $defaultConfigVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName = $defaultDatabase;
		
		$SbsSubscriberPaymentTerm->useDbConfig = $defaultConfigVar;
		$SbsSubscriberPaymentTerm->schemaName = $defaultDatabase;
		
		
		/*End Disconnect Archive database  & Start default(cantorix) connection*/
		
		/*Payment terms Insert*/
		foreach ($paymentTerms as $paymentTerm) {
			$SbsSubscriberPaymentTerm->save($paymentTerm);
		}
		/*Payment terms Insert*/
		
		/*Currency Mappings Insert*/
		foreach ($currencyMappings as $currency) {
			$SbsSubscriberCpnCurrencyMapping->save($currency);
		}
		/*Currency Mappings Insert*/
		
		/*Clients Insert*/
		foreach($clients as $clientInsert) {
			$this->save($clientInsert);
		}
		/*End Clients Insert*/
		
		/*Client Contacts Insert*/
		foreach($clientContacts as $clientContact) {
			$AcrClientContact->save($clientInsert);
		}
		/*End Client Contacts Insert*/
		
		/*Client Custom fields Insert*/
		foreach($clientFields as $clientField) {
			$AcrClientCustomField->save($clientField);
		}
		/*End Client Custom fields Insert*/
		
		/*Client Custom values Insert*/
		foreach($clientCustomValues as $clientCustomValue) {
			$AcrClientCustomValue->save($clientCustomValue);
		}
		/*End Client Custom fields Insert*/
		
		/*Inventories Insert*/
		foreach($inventories as $inventory) {
			$InvInventory->save($inventory,array('validate' => false));
		}
		/*Inventories Insert*/
		
		/*Expense category Insert*/
		foreach($expensecatogries as $expensecatogry) {
			$AcpExpenseCategory->save($expensecatogry);
		}
		/*Expense category Insert*/
		
		/*Expense Insert*/
		foreach($expenses as $expense) {
			$AcpExpense->save($expense);
		}
		/*Expense Insert*/
		
		/*Inventory Expenses Insert*/
		foreach($inventoryExpenses as $inventoryExpense) {
			$AcpInventoryExpense->save($inventoryExpense);
		}
		/*Inventory Expenses Insert*/
		
		/*Inventory expense invoices insert*/
		foreach ($inventoryInvoices as $inventoryInvoice) {
			$AcrInventoryInvoice->save($inventoryInvoice);
		}
		/*Inventory expense invoices insert*/
		
		/*Taxes Insert*/
		foreach($taxes as $tax) {
			$SbsSubscriberTax->save($tax);
		}
		/*Taxes Insert*/
		
		/*Tax group Insert*/
		foreach($taxgroups as $taxgroup) {
			$SbsSubscriberTaxGroup->save($taxgroup);
		}
		/*Tax group Insert*/
		
		/*Tax group mappings Insert*/
		foreach($taxgroupMappings as $taxgroupMapping) {
			$SbsSubscriberTaxGroupMapping->save($taxgroupMapping);
		}
		/*Tax group mappings Insert*/
		
		/*Quotation Insert*/
		foreach($quotations as $quotation) {
			$SlsQuotation->save($quotation);
		}
		/*Quotation Insert*/
		
		/*Quotation products Insert*/
		foreach($quotationProduct as $quotationProduct) {
			$SlsQuotationProduct->save($quotationProduct);
		}
		/*Quotation products Insert*/
		
		/*Quotation custom fields Insert*/
		foreach($quotationCustomFields as $quotationCustomField) {
			$SlsQuotationCustomField->save($quotationCustomField);
		}
		/*Quotation custom fields Insert*/
		
		/*Quotation custom values Insert*/
		foreach($quotationCustomValues as $quotationCustomValue) {
			$SlsQuotationCustomValue->save($quotationCustomValue);
		}
		/*Quotation custom values Insert*/
		
		/*Invoices Insert*/
		foreach($clientInvoices as $clientInvoice) {
			$AcrClientInvoice->save($clientInvoice);
		}
		/*Invoices Insert*/
		
		/*Invoices custom values Insert*/
		foreach($invoiceCustomFields as $invoiceCustomField) {
			$AcrInvoiceCustomField->save($invoiceCustomField);
		}
		/*Invoices custom values Insert*/
		
		/*Invoices custom values Insert*/
		foreach($invoiceCustomValues as $invoiceCustomValue) {
			$AcrInvoiceCustomValue->save($invoiceCustomValue);
		}
		/*Invoices custom values Insert*/
		
		/*Invoices details Insert*/
		foreach($invoiceDetails as $invoiceDetail) {
			$AcrInvoiceDetail->save($invoiceDetail);
		}
		/*Invoices details Insert*/
		
		/*Recurring Invoices details Insert*/
		foreach($recurringPayments as $recurringPayment) {
			$AcrClientRecurringInvoice->save($recurringPayment);
		}
		/*Recurring Invoices details Insert*/
		
		/*Invoice payments Insert*/
		foreach($payments as $payment) {
			$AcrInvoicePaymentDetail->save($payment);
		}
		/*Invoices payments Insert*/
		
		/*Connect Archive database */
		$this->useDbConfig = $archiveConfigVar;
		$this->schemaName = $archiveDatabase;
		
		$AcrClientContact->useDbConfig = $archiveConfigVar;
		$AcrClientContact->schemaName = $archiveDatabase;
		
		$AcrClientCustomField->useDbConfig = $archiveConfigVar;
		$AcrClientCustomField->schemaName = $archiveDatabase;
		
		$AcrClientCustomValue->useDbConfig = $archiveConfigVar;
		$AcrClientCustomValue->schemaName = $archiveDatabase;
		
		$InvInventory->useDbConfig = $archiveConfigVar;
		$InvInventory->schemaName = $archiveDatabase;
		
		$AcpExpenseCategory->useDbConfig = $archiveConfigVar;
		$AcpExpenseCategory->schemaName = $archiveDatabase;
		
		$AcpExpense->useDbConfig = $archiveConfigVar;
		$AcpExpense->schemaName = $archiveDatabase;
		
		$AcpInventoryExpense->useDbConfig = $archiveConfigVar;
		$AcpInventoryExpense->schemaName = $archiveDatabase;
		
		$AcrInventoryInvoice->useDbConfig = $archiveConfigVar;
		$AcrInventoryInvoice->schemaName = $archiveDatabase;
		
		$SbsSubscriberTax->useDbConfig = $archiveConfigVar;
		$SbsSubscriberTax->schemaName = $archiveDatabase;
		
		$SbsSubscriberTaxGroup->useDbConfig = $archiveConfigVar;
		$SbsSubscriberTaxGroup->schemaName = $archiveDatabase;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig = $archiveConfigVar;
		$SbsSubscriberTaxGroupMapping->schemaName = $archiveDatabase;
		
		$SlsQuotation->useDbConfig = $archiveConfigVar;
		$SlsQuotation->schemaName = $archiveDatabase;
		
		$SlsQuotationProduct->useDbConfig = $archiveConfigVar;
		$SlsQuotationProduct->schemaName = $archiveDatabase;
		
		$SlsQuotationCustomField->useDbConfig = $archiveConfigVar;
		$SlsQuotationCustomField->schemaName = $archiveDatabase;
		
		$SlsQuotationCustomValue->useDbConfig = $archiveConfigVar;
		$SlsQuotationCustomValue->schemaName = $archiveDatabase;
		
		$AcrClientInvoice->useDbConfig = $archiveConfigVar;
		$AcrClientInvoice->schemaName = $archiveDatabase;
		
		$AcrInvoiceCustomField->useDbConfig = $archiveConfigVar;
		$AcrInvoiceCustomField->schemaName = $archiveDatabase;
		
		$AcrInvoiceCustomValue->useDbConfig = $archiveConfigVar;
		$AcrInvoiceCustomValue->schemaName = $archiveDatabase;
		
		$AcrInvoiceDetail->useDbConfig = $archiveConfigVar;
		$AcrInvoiceDetail->schemaName = $archiveDatabase;
		
		$AcrInvoicePaymentDetail->useDbConfig = $archiveConfigVar;
		$AcrInvoicePaymentDetail->schemaName = $archiveDatabase;
		
		$AcrClientRecurringInvoice->useDbConfig = $archiveConfigVar;
		$AcrClientRecurringInvoice->schemaName = $archiveDatabase;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $archiveConfigVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName = $archiveDatabase;
		
		$SbsSubscriberPaymentTerm->useDbConfig = $archiveConfigVar;
		$SbsSubscriberPaymentTerm->schemaName = $archiveDatabase;
		
		/*Connecting Database*/
		
		/*Delete All the archived records from cantorix database*/
		$SlsQuotationCustomValue->deleteAll(array('SlsQuotationCustomValue.sls_quotation_custom_field_id'=>$quotationCustomFieldIds), FALSE);
		$SlsQuotationCustomField->deleteAll(array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$SlsQuotationProduct->deleteAll(array('SlsQuotationProduct.sls_quotation_id'=>$quotationIds), FALSE);
		$SlsQuotation->deleteAll(array('SlsQuotation.sbs_subscriber_id'=>$subscriberId), FALSE);
		
		/*Invoice related Deletions*/
		$AcrInvoicePaymentDetail->deleteAll(array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientRecurringInvoice->deleteAll(array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceDetail->deleteAll(array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceCustomValue->deleteAll(array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds), FALSE);
		$AcrInvoiceCustomField->deleteAll(array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientInvoice->deleteAll(array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Invoice related Deletions*/
		
		/*Expense Deletions*/
		$AcpInventoryExpense->recursive = -1;
		$AcrInventoryInvoice->deleteAll(array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds),FALSE);
		$AcpInventoryExpense->deleteAll(array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
		$AcpExpense->deleteAll(array('AcpExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
		$AcpExpenseCategory->deleteAll(array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*Expense Deletions*/
		
		
		/**/
		$InvInventory->deleteAll(array('InvInventory.sbs_subscriber_id'=>$subscriberId),FALSE);
		/**/
		
		/*Client related Deletions*/
		$AcrClientCustomValue->deleteAll(array('AcrClientCustomValue.acr_client_id'=>$clientIds),FALSE);
		$AcrClientCustomField->deleteAll(array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientContact->deleteAll(array('AcrClientContact.acr_client_id'=>$clientIds), FALSE);
		$this->deleteAll(array('AcrClient.sbs_subscriber_id' => $subscriberId),FALSE);
		/*Client related Deletions*/
		
		/*Currency mapping Deletion*/
		$SbsSubscriberCpnCurrencyMapping->deleteAll(array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Currency mapping Deletion*/
		
		/*Payment Terms Deletion*/
		$SbsSubscriberPaymentTerm->deleteAll(array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Payment Terms Deletion*/
		
		/*Tax related deletions*/
		$SbsSubscriberTaxGroupMapping->deleteAll(array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxIds), FALSE);
		$SbsSubscriberTaxGroup->deleteAll(array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId),FALSE);
		$SbsSubscriberTax->deleteAll(array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*Tax related deletions*/
		
		
		/*End Delete All the archived records from cantorix database*/
		echo 'Completed';
		return TRUE;
	}
	
	
	public function deleteSubscriber($subscriberId = NULL,$connection = NULL) {
		
  		/*Loading all required models*/
		$AcrClientContact = ClassRegistry::init('AcrClientContact');
		$AcrClientCustomField = ClassRegistry::init('AcrClientCustomField');
		$AcrClientCustomValue = ClassRegistry::init('AcrClientCustomValue');
		$InvInventory = ClassRegistry::init('InvInventory');
		$AcpExpenseCategory = ClassRegistry::init('AcpExpenseCategory');
		$AcpExpense = ClassRegistry::init('AcpExpense');
		$AcpInventoryExpense = ClassRegistry::init('AcpInventoryExpense');
		$AcrInventoryInvoice = ClassRegistry::init('AcrInventoryInvoice');
		$SbsSubscriberTax = ClassRegistry::init('SbsSubscriberTax');
		$SbsSubscriberTaxGroup = ClassRegistry::init('SbsSubscriberTaxGroup');
		$SbsSubscriberTaxGroupMapping = ClassRegistry::init('SbsSubscriberTaxGroupMapping');
		$SlsQuotation = ClassRegistry::init('SlsQuotation');
		$SlsQuotationProduct = ClassRegistry::init('SlsQuotationProduct');
		$SlsQuotationCustomField = ClassRegistry::init('SlsQuotationCustomField');
		$SlsQuotationCustomValue = ClassRegistry::init('SlsQuotationCustomValue');
		$AcrClientInvoice = ClassRegistry::init('AcrClientInvoice');
		$AcrInvoiceCustomField = ClassRegistry::init('AcrInvoiceCustomField');
		$AcrInvoiceCustomValue = ClassRegistry::init('AcrInvoiceCustomValue');
		$AcrInvoicePaymentDetail = ClassRegistry::init('AcrInvoicePaymentDetail');
		$AcrInvoiceDetail = ClassRegistry::init('AcrInvoiceDetail');
		$AcrClientRecurringInvoice = ClassRegistry::init('AcrClientRecurringInvoice');
		$SbsSubscriberCpnCurrencyMapping = ClassRegistry::init('SbsSubscriberCpnCurrencyMapping');
		$SbsSubscriberPaymentTerm = ClassRegistry::init('SbsSubscriberPaymentTerm');
		$SbsSubscriber = ClassRegistry::init('SbsSubscriber');
		$SbsSubscriberOrganizationDetail = ClassRegistry::init('SbsSubscriberOrganizationDetail'); 
		/*Loading all required models*/
		
		
		$configVar = 'default';
		if($connection == 'archive') {
			$configVar = 'archive';
		} else {
			$configVar = 'default';
		}
		
		$dataSource = ConnectionManager::getDataSource($configVar);
		$database = $dataSource->config['database'];
		
		/*Connect Archive database */
		$this->useDbConfig = $configVar;
		$this->schemaName = $database;
		
		$AcrClientContact->useDbConfig = $configVar;
		$AcrClientContact->schemaName = $database;
		
		$AcrClientCustomField->useDbConfig = $configVar;
		$AcrClientCustomField->schemaName = $database;
		
		$AcrClientCustomValue->useDbConfig = $configVar;
		$AcrClientCustomValue->schemaName = $database;
		
		$InvInventory->useDbConfig = $configVar;
		$InvInventory->schemaName = $database;
		
		$AcpExpenseCategory->useDbConfig = $configVar;
		$AcpExpenseCategory->schemaName = $database;
		
		$AcpExpense->useDbConfig = $configVar;
		$AcpExpense->schemaName = $database;
		
		$AcpInventoryExpense->useDbConfig = $configVar;
		$AcpInventoryExpense->schemaName = $database;
		
		$AcrInventoryInvoice->useDbConfig = $configVar;
		$AcrInventoryInvoice->schemaName = $database;
		
		$SbsSubscriberTax->useDbConfig = $configVar;
		$SbsSubscriberTax->schemaName = $database;
		
		$SbsSubscriberTaxGroup->useDbConfig = $configVar;
		$SbsSubscriberTaxGroup->schemaName = $database;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig = $configVar;
		$SbsSubscriberTaxGroupMapping->schemaName = $database;
		
		$SlsQuotation->useDbConfig = $configVar;
		$SlsQuotation->schemaName = $database;
		
		$SlsQuotationProduct->useDbConfig = $configVar;
		$SlsQuotationProduct->schemaName = $database;
		
		$SlsQuotationCustomField->useDbConfig = $configVar;
		$SlsQuotationCustomField->schemaName = $database;
		
		$SlsQuotationCustomValue->useDbConfig = $configVar;
		$SlsQuotationCustomValue->schemaName = $database;
		
		$AcrClientInvoice->useDbConfig = $configVar;
		$AcrClientInvoice->schemaName = $database;
		
		$AcrInvoiceCustomField->useDbConfig = $configVar;
		$AcrInvoiceCustomField->schemaName = $database;
		
		$AcrInvoiceCustomValue->useDbConfig = $configVar;
		$AcrInvoiceCustomValue->schemaName = $database;
		
		$AcrInvoiceDetail->useDbConfig = $configVar;
		$AcrInvoiceDetail->schemaName = $database;
		
		$AcrInvoicePaymentDetail->useDbConfig = $configVar;
		$AcrInvoicePaymentDetail->schemaName = $database;
		
		$AcrClientRecurringInvoice->useDbConfig = $configVar;
		$AcrClientRecurringInvoice->schemaName = $database;
		
		$SbsSubscriber->useDbConfig = $configVar;
		$SbsSubscriber->schemaName = $database;
		
		$SbsSubscriberPaymentTerm->useDbConfig = $configVar;
		$SbsSubscriberPaymentTerm->schemaName = $database;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $configVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName = $database;
		
		/*Connecting Database*/
		
		
		/* Get all required data from client module tables*/
		
		$subscriber = $SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$subscriberId)));
			
		$clients = $this->find('all',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
		$clientIds = $this->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
		 
		$clientContacts =  $AcrClientContact->find('all',array('conditions'=>array('AcrClientContact.acr_client_id'=>$clientIds)));
		
		$clientFields = $AcrClientCustomField->find('all',array('conditions'=>array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId)));
		
		$clientCustomValues = $AcrClientCustomValue->find('all',array('conditions'=>array('AcrClientCustomValue.acr_client_id'=>$clientIds)));
		
		$inventories = $InvInventory->find('all',array('conditions'=>array('InvInventory.sbs_subscriber_id'=>$subscriberId)));
		
		$expensecatogries = $AcpExpenseCategory->find('all',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId))); 
		
		$expenses = $AcpExpense->find('all',array('conditions'=>array('AcpExpense.sbs_subscriber_id'=>$subscriberId))); 
		
		$inventoryExpenses = $AcpInventoryExpense->find('all',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId)));
		$inventoryExpenseIds = $AcpInventoryExpense->find('list',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcpInventoryExpense.id','AcpInventoryExpense.id')));
		
		$inventoryInvoices = $AcrInventoryInvoice->find('all',array('conditions'=>array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds))); 
		
		$taxes =  $SbsSubscriberTax->find('all',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId)));
		$taxIds = $SbsSubscriberTax->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.id')));
		
		$taxgroups =  $SbsSubscriberTaxGroup->find('all',array('conditions'=>array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId)));
		
		$taxgroupMappings =  $SbsSubscriberTaxGroupMapping->find('all',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxIds)));
		
		$quotations = $SlsQuotation->find('all',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId)));
		$quotationIds = $SlsQuotation->find('list',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotation.id')));
		
		$quotationProducts = $SlsQuotationProduct->find('all',array('conditions'=>array('SlsQuotationProduct.sls_quotation_id'=>$quotationIds)));
		
		$quotationCustomFields = $SlsQuotationCustomField->find('all',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId)));
		$quotationCustomFieldIds = $SlsQuotationCustomField->find('list',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotationCustomField.id','SlsQuotationCustomField.id')));
		
		$quotationCustomValues = $SlsQuotationCustomValue->find('all',array('conditions'=>array('SlsQuotationCustomValue.sls_quotation_custom_field_id'=>$quotationCustomFieldIds)));
		
		$clientInvoices = $AcrClientInvoice->find('all',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId)));
		$clientInvoiceIds = $AcrClientInvoice->find('list',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClientInvoice.id','AcrClientInvoice.id')));
		
		$invoiceCustomFields = $AcrInvoiceCustomField->find('all',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId)));
		$invoiceCustomFieldIds = $AcrInvoiceCustomField->find('list',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoiceCustomField.id','AcrInvoiceCustomField.id')));
		
		$invoiceCustomValues = $AcrInvoiceCustomValue->find('all',array('conditions'=>array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds)));
		
		$invoiceDetails = $AcrInvoiceDetail->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds)));
		
		$payments = $AcrInvoicePaymentDetail->find('all',array('conditions'=>array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId)));
		
		$recurringPayments = $AcrClientRecurringInvoice->find('all',array('conditions'=>array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds)));
		/* End Get all required data from client module tables*/
		
		/*Currency Mappings deletions*/
		$SbsSubscriberCpnCurrencyMapping->deleteAll(array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id' => $subscriberId), FALSE);
		/*Currency Mappings deletions*/
		
		/*Delete All records from cantorix database*/
		$SlsQuotationCustomValue->deleteAll(array('SlsQuotationCustomValue.sls_quotation_custom_field_id'=>$quotationCustomFieldIds), FALSE);
		$SlsQuotationCustomField->deleteAll(array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$SlsQuotationProduct->deleteAll(array('SlsQuotationProduct.sls_quotation_id'=>$quotationIds), FALSE);
		$SlsQuotation->deleteAll(array('SlsQuotation.sbs_subscriber_id'=>$subscriberId), FALSE);
		
		/*Invoice related Deletions*/
		$AcrInvoicePaymentDetail->deleteAll(array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientRecurringInvoice->deleteAll(array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceDetail->deleteAll(array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceCustomValue->deleteAll(array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds), FALSE);
		$AcrInvoiceCustomField->deleteAll(array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientInvoice->deleteAll(array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Invoice related Deletions*/
		
		/*Expense Deletions*/
		$AcpInventoryExpense->recursive = -1;
		$AcrInventoryInvoice->deleteAll(array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds),FALSE);
		$AcpInventoryExpense->deleteAll(array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
		$AcpExpense->deleteAll(array('AcpExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
		$AcpExpenseCategory->deleteAll(array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*Expense Deletions*/
		
		/*Inventory deletions*/
		$InvInventory->deleteAll(array('InvInventory.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*Inventory deletions*/
		
		/*Client related Deletions*/
		$AcrClientCustomValue->deleteAll(array('AcrClientCustomValue.acr_client_id'=>$clientIds),FALSE);
		$AcrClientCustomField->deleteAll(array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientContact->deleteAll(array('AcrClientContact.acr_client_id'=>$clientIds), FALSE);
		$this->deleteAll(array('AcrClient.sbs_subscriber_id' => $subscriberId),FALSE);
		/*Client related Deletions*/
		
		/*Tax related deletions*/
		$SbsSubscriberTaxGroupMapping->deleteAll(array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxIds), FALSE);
		$SbsSubscriberTaxGroup->deleteAll(array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId),FALSE);
		$SbsSubscriberTax->deleteAll(array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*Tax related deletions*/
		
		/*payment terms deletions*/
		$SbsSubscriberPaymentTerm->deleteAll(array('SbsSubscriberPaymentTerm.sbs_subscriber_id' => $subscriberId), FALSE);
		/*payment terms deletions*/
		
		$SbsSubscriber->delete($subscriberId);
		$organization = $SbsSubscriberOrganizationDetail->find('first',array('conditions'=>array('SbsSubscriberOrganizationDetail.id'=>$subscriber['SbsSubscriber']['sbs_subscriber_organization_detail_id'])));
		$SbsSubscriberOrganizationDetail->delete($organization['SbsSubscriberOrganizationDetail']['id']);
		/*End Delete All records from cantorix database*/
		return TRUE;
		
  	}
	

/******@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ DONT DELETE/CHANGE ANY CODE BELOW WITHOUT INTIMATION @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@******/



    public function getClientNo($subscriber=null){
    	
    	$client_record=$this->find('first',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$subscriber,'AcrClient.status'=>'active'),'order'=>array('AcrClient.id DESC'),'fields'=>array('AcrClient.client_no')));
        if(!empty($client_record['AcrClient']['client_no'])){
        	$client_no= $client_record['AcrClient']['client_no'] + 1;
        }else{
        	$client_no = 1;
        }
        return $client_no;
    }

   public function getClientDetail($id=null){
   	  $clientDetails=$this->find('first',array('conditions'=>array('AcrClient.id'=>$id)));
   	  return $clientDetails;
   }
   public function clientCheck($clientName=null,$organisationName=null,$city=null,$state=null,$country=null,$pin=null,$subscriberId = null){
   		$clientInfo = $this->find('first',array('conditions'=>array('AcrClient.client_name'=>$clientName,'AcrClient.organization_name'=>$organisationName,'AcrClient.billing_city'=>$city,'AcrClient.billing_state'=>$state,'AcrClient.billing_country'=>$country,'AcrClient.billing_zip'=>$pin,'AcrClient.sbs_subscriber_id'=>$subscriberId)));
   		if($clientInfo){
   			return $clientInfo;
   		}else{
   			return false;
   		}
   }
   public function getCustomerList($subscriberId = null){
   	if($subscriberId){
   		$customerList = $this->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$subscriberId,'AcrClient.status'=>'Active'),'fields'=>array('AcrClient.id','AcrClient.organization_name')));
   		return $customerList;
   	}
   }
   
   /**
    * @method Get active customers for a subscribers
    * @author Ganesh R
    * */
	public function getActiveCustomerList($subscriberId = NULL) {
		if($subscriberId){
			return $this->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$subscriberId,'AcrClient.status'=>'Active'),'fields'=>array('AcrClient.id','AcrClient.client_name')));
		}
  	}
   
   public function importClient($subscriberId,$clientInformation,$languageId,$currencyId,$paymentTermId){
   		if($subscriberId && $clientInformation){
   			$clientExist = $this->clientCheck($clientInformation['Client Name'],$clientInformation['Organization Name'],$clientInformation['City'],$clientInformation['State/Province'],$clientInformation['Country'],$clientInformation['Postal Code'],$subscriberId);
   			if(!$clientInformation['Client Name']){
   					$arraySave['failure'] = '1';
   					$arraySave['error'] = "Client Name Missing";
   					return $arraySave;
   			}elseif(!$clientInformation['Organization Name']){
   				$arraySave['failure'] = '1';
   				$arraySave['error'] = "Organisation Name Missing";
   				return $arraySave;
   			}elseif($clientExist){
   				$arraySave['failure'] = '1';
   				$arraySave['error'] = "Organisation already exists";
   				return $arraySave;
   			}else{
   					$saveArray->data = null;
		   			$this->create();
		   			$clientNumber = $this->getClientNo($subscriberId);
		   			$saveArray->data['AcrClient']['client_no'] 						= $clientNumber;
		   			$saveArray->data['AcrClient']['sbs_subscriber_id'] 				= $subscriberId;
		   			$saveArray->data['AcrClient']['client_name'] 					= $clientInformation['Client Name'];
		   			$saveArray->data['AcrClient']['organization_name'] 				= $clientInformation['Organization Name'];
		   			$saveArray->data['AcrClient']['billing_address_line1'] 			= $clientInformation['Billing Address Line 1'];
		   			$saveArray->data['AcrClient']['billing_address_line2'] 			= $clientInformation['Billing Address Line 2'];
		   			$saveArray->data['AcrClient']['billing_city'] 					= $clientInformation['City'];
		   			$saveArray->data['AcrClient']['billing_state'] 					= $clientInformation['State/Province'];
		   			$saveArray->data['AcrClient']['billing_country'] 				= $clientInformation['Country'];
		   			$saveArray->data['AcrClient']['billing_zip'] 					= $clientInformation['Postal Code'];
		   			$saveArray->data['AcrClient']['shiping_address_line1'] 			= $clientInformation['Shipping Address Line 1'];
		   			$saveArray->data['AcrClient']['shipping_address_line2'] 		= $clientInformation['Shipping Address Line 2'];
		   			$saveArray->data['AcrClient']['shipping_city'] 					= $clientInformation['Shipping City'];
		   			$saveArray->data['AcrClient']['shipping_state'] 				= $clientInformation['Shipping State/Province'];
		   			$saveArray->data['AcrClient']['shipping_country'] 				= $clientInformation['Country'];
		   			$saveArray->data['AcrClient']['shipping_zip'] 					= $clientInformation['Postal Code'];
		   			$saveArray->data['AcrClient']['website'] 						= $clientInformation['Website'];
		   			$saveArray->data['AcrClient']['business_phone'] 				= $clientInformation['Business Phone'];
		   			$saveArray->data['AcrClient']['business_fax'] 					= $clientInformation['Business Fax'];
		   			$saveArray->data['AcrClient']['send_invoice_by'] 				= 'email';
		   			$saveArray->data['AcrClient']['status'] 						= 'active';
		   			$saveArray->data['AcrClient']['cpn_language_id'] 				= $languageId;
		   			$saveArray->data['AcrClient']['cpn_currency_id'] 				= $currencyId;
		   			$saveArray->data['AcrClient']['sbs_subscriber_payment_term_id'] = $paymentTermId;
		   			if($this->save($saveArray->data,array('validate'=>false))){
		   				$lastInsertedId	=	$this->getLastInsertId();
		   				$AcrClientCustomField = ClassRegistry::init('AcrClientCustomField');
		   				$AcrClientCustomValue = ClassRegistry::init('AcrClientCustomValue');
   						$getCustomFields = $AcrClientCustomField->getFieldBySubscriber($subscriberId);
   						$fieldCount = 1;
   						foreach($getCustomFields as $customFieldKey=>$customFieldVal){
   							if($clientInformation['Custom Field'.$fieldCount]){
   								$addCustomValue =  $AcrClientCustomValue->addValue($lastInsertedId,$clientInformation['Custom Field'.$fieldCount],$customFieldKey);
   							}
   							$fieldCount++;
   						}
		   				$arraySave['Success'] = $lastInsertedId;
		   				return $arraySave;
		   			}
   			}
   		}
   }
   public function getClientDetails($currencyId){
   	if($currencyId){
   		$getClientDetails = $this->find('all',array('conditions'=>array('AcrClient.cpn_currency_id'=>$currencyId)));
   		return $getClientDetails;
   	}else{
   		return false;
   	}
   }
   public function getClientIdByOrganisationName($organisationName = null,$subscriberId = null){
   	if($organisationName){
   		$getClient = $this->find('first',array('conditions'=>array('AcrClient.organization_name'=>$organisationName,'AcrClient.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClient.id')));
   		if($getClient){
   			return $getClient['AcrClient']['id'];
   		}else{
   			return false;
   		}
   	}else{
   		return false;
   	}
   }
   
/**
 * @Author Ganesh
 * @Since 20 Aug 2014
 * @Version v.1
 * @Method get ACTIVE Customer count for Subscriber Dashboard
 * **/
 	public function getCustomerCount($subscriberID = NULL) {
 		return $this->find('count',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberID, 'AcrClient.status' => 'active')));
 	}   
   
  
}
