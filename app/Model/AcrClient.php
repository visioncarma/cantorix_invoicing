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
		Configure::write('debug',2);
        debug('Entered');
        
         /**Declare two database connections*/
		$dataSource0 = ConnectionManager::getDataSource('default');
		$defaultDatabase =  $dataSource0->config['database'];
		$defaultConfigVar = 'default';
		
		$dataSource = ConnectionManager::getDataSource('archive');
		$archiveDatabase = $dataSource->config['database'];
		$archiveConfigVar = 'archive';
        /**End of declaration*/
		
		/* Get all required data from client module tables*/
		
		$SbsSubscriberPaymentTerm = ClassRegistry::init('SbsSubscriberPaymentTerm');
		$paymentTerms = $SbsSubscriberPaymentTerm->find('all',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id' => $subscriberId)));
		debug($paymentTerms);
        
		$SbsSubscriberCpnCurrencyMapping = ClassRegistry::init('SbsSubscriberCpnCurrencyMapping');
		$currencyMappings = $SbsSubscriberCpnCurrencyMapping->find('all',array('conditions'=>array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id' => $subscriberId)));
		debug($currencyMappings);
        	
		$clients = $this->find('all',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
		$clientIds = $this->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
		debug($clientIds);
        
		$AcrClientContact = ClassRegistry::init('AcrClientContact'); 
		$clientContacts =  $AcrClientContact->find('all',array('conditions'=>array('AcrClientContact.sbs_subscriber_id'=>$subscriberId)));
		debug($clientContacts);
        
		$AcrClientCustomField = ClassRegistry::init('AcrClientCustomField');
		$clientFields = $AcrClientCustomField->find('all',array('conditions'=>array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId)));
		debug($clientFields);
        
		$AcrClientCustomValue = ClassRegistry::init('AcrClientCustomValue');
		$clientCustomValues = $AcrClientCustomValue->find('all',array('conditions'=>array('AcrClientCustomValue.acr_client_id'=>$clientIds)));
		debug($clientCustomValues);
        
        $AcrClientCreditnote        = ClassRegistry::init('AcrClientCreditnote');
        $creditNotes                = $AcrClientCreditnote->find('all',array('conditions'=>array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId)));
        $creditNotesIds             = $AcrClientCreditnote->find('list',array('conditions'=>array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId)));
        debug($creditNotes);
        debug($creditNotesIds);
        
        $AcrCreditnotePaymentMapping = ClassRegistry::init('AcrCreditnotePaymentMapping');
        $creditNoteMapping           = $AcrCreditnotePaymentMapping->find('all',array('conditions'=>array('AcrCreditnotePaymentMapping.sbs_subscriber_id'=>$subscriberId)));
        debug($creditNoteMapping);
        
        $AcrClientCreditnoteProduct  = ClassRegistry::init('AcrClientCreditnoteProduct');
        $AcrCreditnoteProducts       = $AcrClientCreditnoteProduct->find('all',array('conditions'=>array('AcrClientCreditnoteProduct.acr_client_creditnote_id'=>$creditNotesIds)));
        debug($AcrCreditnotePrdoucts);
        
		$InvInventory                 = ClassRegistry::init('InvInventory');
		$inventories                  = $InvInventory->find('all',array('conditions'=>array('InvInventory.sbs_subscriber_id'=>$subscriberId)));
        $inventoryIds                 = $InvInventory->find('list',array('conditions'=>array('InvInventory.sbs_subscriber_id'=>$subscriberId),'fields'=>array('InvInventory.id','InvInventory.id')));
        debug($inventories);
        debug($inventoryIds);
        
        $InvInventoryCustomField      = ClassRegistry::init('InvInventoryCustomField');
        $inventoryCustomFields        = $InvInventoryCustomField->find('all',array('conditions'=>array('InvInventoryCustomField.sbs_subscriber_id'=>$subscriberId)));
        debug($inventoryCustomFields);
        
        $InvInventoryCustomValue = ClassRegistry::init('InvInventoryCustomValue');
        $inventoryCustomValues = $InvInventoryCustomValue->find('all',array('conditions'=>array('InvInventoryCustomValue.inv_inventory_id'=>$inventoryIds)));
		debug($inventoryCustomValues);
        
        $InvInventoryUnitType = ClassRegistry::init('InvInventoryUnitType');
        $inventoryUnitTypes = $InvInventoryUnitType->find('all',array('conditions'=>array('InvInventoryUnitType.sbs_subscriber_id'=>$subscriberId))); 
        debug($inventoryUnitTypes);
        
		$AcpExpenseCategory = ClassRegistry::init('AcpExpenseCategory');
		$expensecatogries = $AcpExpenseCategory->find('all',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId))); 
		debug($expensecatogries);
        
		$AcpExpense = ClassRegistry::init('AcpExpense');
		$expenses = $AcpExpense->find('all',array('conditions'=>array('AcpExpense.sbs_subscriber_id'=>$subscriberId)));
        $expenseIds = $AcpExpense->find('list',array('conditions'=>array('AcpExpense.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcpExpense.id','AcpExpense.id')));
        debug($expenses);
        
        $AcpExpenseCustomField = ClassRegistry::init('AcpExpenseCustomField');
        debug($subscriberId);
        $expenseCustomFields = $AcpExpenseCustomField->find('all', array('conditions' => array('AcpExpenseCustomField.sbs_subscriber_id' => $subscriberId)));
        debug($expenseCustomFields);
        
        $AcpExpenseCustomFieldValue = ClassRegistry::init('AcpExpenseCustomFieldValue');
        $expenseCustomFieldValues = $AcpExpenseCustomFieldValue->find('all',array('conditions'=>array('AcpExpenseCustomFieldValue.acp_expense_id'=>$expenseIds)));
        debug($expenseCustomFieldValues);
        
        
        $AcpVendor = ClassRegistry::init('AcpVendor');
        $vendors = $AcpVendor->find('all',array('conditions'=>array('AcpVendor.sbs_subscriber_id'=>$subscriberId)));
		debug($vendors);
        
		$AcpInventoryExpense = ClassRegistry::init('AcpInventoryExpense');
		$inventoryExpenses = $AcpInventoryExpense->find('all',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId)));
		$inventoryExpenseIds = $AcpInventoryExpense->find('list',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcpInventoryExpense.id','AcpInventoryExpense.id')));
		debug($inventoryExpenses);
        debug($inventoryExpenseIds);
        
		$AcrInventoryInvoice = ClassRegistry::init('AcrInventoryInvoice');
		$inventoryInvoices = $AcrInventoryInvoice->find('all',array('conditions'=>array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds))); 
		debug($inventoryInvoices);
        
		$SbsSubscriberTax = ClassRegistry::init('SbsSubscriberTax');
		$taxes =  $SbsSubscriberTax->find('all',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId)));
		$taxIds = $SbsSubscriberTax->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.id')));
		debug($taxes);
        debug($taxIds);
        
		$SbsSubscriberTaxGroup = ClassRegistry::init('SbsSubscriberTaxGroup');
		$taxgroups =  $SbsSubscriberTaxGroup->find('all',array('conditions'=>array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId)));
		debug($taxgroups);
        
		$SbsSubscriberTaxGroupMapping = ClassRegistry::init('SbsSubscriberTaxGroupMapping');
		$taxgroupMappings =  $SbsSubscriberTaxGroupMapping->find('all',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxIds)));
		debug($taxgroupMappings);
        
		$SlsQuotation = ClassRegistry::init('SlsQuotation');
		$quotations = $SlsQuotation->find('all',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId)));
		$quotationIds = $SlsQuotation->find('list',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotation.id')));
		debug($quotations);
        debug($quotationIds);
        
		$SlsQuotationProduct = ClassRegistry::init('SlsQuotationProduct');
		$quotationProducts = $SlsQuotationProduct->find('all', array('conditions' => array('SlsQuotationProduct.sls_quotation_id' => $quotationIds)));
		debug($quotationProducts);
        
		$SlsQuotationCustomField = ClassRegistry::init('SlsQuotationCustomField');
		$quotationCustomFields = $SlsQuotationCustomField->find('all',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId)));
		$quotationCustomFieldIds = $SlsQuotationCustomField->find('list',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotationCustomField.id','SlsQuotationCustomField.id')));
		debug($quotationCustomFields);
        debug($quotationCustomFieldIds);
        
		$SlsQuotationCustomValue = ClassRegistry::init('SlsQuotationCustomValue');
		$quotationCustomValues = $SlsQuotationCustomValue->find('all',array('conditions'=>array('SlsQuotationCustomValue.sls_quotation_id'=>$quotationIds)));
		debug($quotationCustomValues);
        
		$AcrClientInvoice = ClassRegistry::init('AcrClientInvoice');
		$clientInvoices = $AcrClientInvoice->find('all',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId)));
		$clientInvoiceIds = $AcrClientInvoice->find('list',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClientInvoice.id','AcrClientInvoice.id')));
		debug($clientInvoices);
        debug($clientInvoiceIds);
         
		$AcrInvoiceCustomField = ClassRegistry::init('AcrInvoiceCustomField');
		$invoiceCustomFields = $AcrInvoiceCustomField->find('all',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId)));
		$invoiceCustomFieldIds = $AcrInvoiceCustomField->find('list',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoiceCustomField.id','AcrInvoiceCustomField.id')));
		debug($invoiceCustomFields);
        debug($invoiceCustomFieldIds);
        
		$AcrInvoiceCustomValue = ClassRegistry::init('AcrInvoiceCustomValue');
		$invoiceCustomValues = $AcrInvoiceCustomValue->find('all',array('conditions'=>array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds)));
		debug($invoiceCustomValues);
        
		$AcrInvoiceDetail = ClassRegistry::init('AcrInvoiceDetail');
		$invoiceDetails = $AcrInvoiceDetail->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds)));
		debug($invoiceDetails);
        
		$AcrInvoicePaymentDetail  = ClassRegistry::init('AcrInvoicePaymentDetail');
		$payments                 = $AcrInvoicePaymentDetail->find('all',array('conditions'=>array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId)));
		debug($payments);
        
		$AcrClientRecurringInvoice = ClassRegistry::init('AcrClientRecurringInvoice');
		$recurringPayments         = $AcrClientRecurringInvoice->find('all',array('conditions'=>array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds)));
		debug($recurringPayments);
        
		$SbsAgingBucket         = ClassRegistry::init('SbsAgingBucket');
        $agingBuckets           = $SbsAgingBucket->find('all',array('conditions'=>array('SbsAgingBucket.sbs_subscriber_id'=>$subscriberId)));
        debug($agingBuckets);
        
        $SbsDowngradeRequest    = ClassRegistry::init('SbsDowngradeRequest');
        $downgradeRequests      = $SbsDowngradeRequest->find('all',array('conditions'=>array('SbsDowngradeRequest.sbs_subscriber_id'=>$subscriberId)));
        debug($downgradeRequests);
        
        $SbsEmailTemplateDetail = ClassRegistry::init('SbsEmailTemplateDetail');
        $emailTemplateDetails   = $SbsEmailTemplateDetail->find('all',array('conditions'=>array('SbsEmailTemplateDetail.sbs_subscriber_id'=>$subscriberId)));
        debug($emailTemplateDetails); 
		
        
        $SbsPaymentMethodValue  = ClassRegistry::init('SbsPaymentMethodValue');
        $paymentMethValues      = $SbsPaymentMethodValue->find('all',array('conditions'=>array('SbsPaymentMethodValue.subscriber_id'=>$subscriberId)));
        debug($paymentMethValues);
        
        $SbsPaymentMethod       = ClassRegistry::init('SbsPaymentMethod');
        $paymentMethods         = $SbsPaymentMethod->find('all',array('conditions'=>array('SbsPaymentMethod.subscriber_id'=>$subscriberId)));
        debug($paymentMethods);
		/* End Get all required data from client module tables*/
		
		
		/*Connect Archive database*/
		$this->useDbConfig                        = $archiveConfigVar;
		$this->schemaName                         = $archiveDatabase;
		
		$AcrClientContact->useDbConfig            = $archiveConfigVar;
		$AcrClientContact->schemaName             = $archiveDatabase;
		
		$AcrClientCustomField->useDbConfig        = $archiveConfigVar;
		$AcrClientCustomField->schemaName         = $archiveDatabase;
		
		$AcrClientCustomValue->useDbConfig        = $archiveConfigVar;
		$AcrClientCustomValue->schemaName         = $archiveDatabase;
		
        $InvInventoryUnitType->useDbConfig        = $archiveConfigVar;
        $InvInventoryUnitType->schemaName         = $archiveDatabase;
        
        $InvInventoryCustomValue->useDbConfig     = $archiveConfigVar;
        $InvInventoryCustomValue->schemaName      = $archiveDatabase;
        
        $InvInventoryCustomField->useDbConfig     = $archiveConfigVar;
        $InvInventoryCustomField->schemaName      = $archiveDatabase;
        
		$InvInventory->useDbConfig                = $archiveConfigVar;
		$InvInventory->schemaName                 = $archiveDatabase;
		
		$AcpExpenseCategory->useDbConfig          = $archiveConfigVar;
		$AcpExpenseCategory->schemaName           = $archiveDatabase;
		
        $AcpExpenseCustomField->useDbConfig       = $archiveConfigVar;
        $AcpExpenseCustomField->schemaName        = $archiveDatabase;
        
        $AcpExpenseCustomFieldValue->useDbConfig  = $archiveConfigVar;
        $AcpExpenseCustomFieldValue->schemaName   = $archiveDatabase;
        
        $AcpVendor->useDbConfig                   = $archiveConfigVar;
        $AcpVendor->schemaName                    = $archiveDatabase;
        
		$AcpExpense->useDbConfig                  = $archiveConfigVar;
		$AcpExpense->schemaName                   = $archiveDatabase;
		
		$AcpInventoryExpense->useDbConfig         = $archiveConfigVar;
		$AcpInventoryExpense->schemaName          = $archiveDatabase;
		
		$AcrInventoryInvoice->useDbConfig         = $archiveConfigVar;
		$AcrInventoryInvoice->schemaName          = $archiveDatabase;
		
		$SbsSubscriberTax->useDbConfig            = $archiveConfigVar;
		$SbsSubscriberTax->schemaName             = $archiveDatabase;
		
		$SbsSubscriberTaxGroup->useDbConfig       = $archiveConfigVar;
		$SbsSubscriberTaxGroup->schemaName        = $archiveDatabase;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig = $archiveConfigVar;
		$SbsSubscriberTaxGroupMapping->schemaName = $archiveDatabase;
		
		$SlsQuotation->useDbConfig                = $archiveConfigVar;
		$SlsQuotation->schemaName                 = $archiveDatabase;
		
		$SlsQuotationProduct->useDbConfig         = $archiveConfigVar;
		$SlsQuotationProduct->schemaName          = $archiveDatabase;
		
		$SlsQuotationCustomField->useDbConfig     = $archiveConfigVar;
		$SlsQuotationCustomField->schemaName      = $archiveDatabase;
		
		$SlsQuotationCustomValue->useDbConfig     = $archiveConfigVar;
		$SlsQuotationCustomValue->schemaName      = $archiveDatabase;
		
		$AcrClientInvoice->useDbConfig            = $archiveConfigVar;
		$AcrClientInvoice->schemaName             = $archiveDatabase;
		
		$AcrInvoiceCustomField->useDbConfig       = $archiveConfigVar;
		$AcrInvoiceCustomField->schemaName        = $archiveDatabase;
		
		$AcrInvoiceCustomValue->useDbConfig       = $archiveConfigVar;
		$AcrInvoiceCustomValue->schemaName        = $archiveDatabase;
		
		$AcrInvoiceDetail->useDbConfig            = $archiveConfigVar;
		$AcrInvoiceDetail->schemaName             = $archiveDatabase;
		
		$AcrInvoicePaymentDetail->useDbConfig     = $archiveConfigVar;
		$AcrInvoicePaymentDetail->schemaName      = $archiveDatabase;
		
		$AcrClientRecurringInvoice->useDbConfig   = $archiveConfigVar;
		$AcrClientRecurringInvoice->schemaName    = $archiveDatabase;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $archiveConfigVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName  = $archiveDatabase;
		
		$SbsSubscriberPaymentTerm->useDbConfig      = $archiveConfigVar;
		$SbsSubscriberPaymentTerm->schemaName       = $archiveDatabase;
        
        $SbsAgingBucket->useDbConfig                = $archiveConfigVar;
        $SbsAgingBucket->schemaName                 = $archiveDatabase;
        
        $SbsEmailTemplateDetail->useDbConfig        = $archiveConfigVar;
        $SbsEmailTemplateDetail->schemaName         = $archiveDatabase;
        
        $AcrClientCreditnote->useDbConfig           = $archiveConfigVar;
        $AcrClientCreditnote->schemaName            = $archiveDatabase;
        
        $AcrClientCreditnoteProduct->useDbConfig    = $archiveConfigVar;
        $AcrClientCreditnoteProduct->schemaName     = $archiveDatabase;
        
        $AcrCreditnotePaymentMapping->useDbConfig   = $archiveConfigVar;
        $AcrCreditnotePaymentMapping->schemaName    = $archiveDatabase;
        
        $SbsDowngradeRequest->schemaName            = $archiveDatabase;
        $SbsDowngradeRequest->useDbConfig           = $archiveConfigVar;
        
        $SbsPaymentMethodValue->schemaName          = $archiveDatabase;
        $SbsPaymentMethodValue->useDbConfig         = $archiveConfigVar;
        
        $SbsPaymentMethod->schemaName               = $archiveDatabase;
        $SbsPaymentMethod->useDbConfig              = $archiveConfigVar;
		/*Connecting Database*/
		
		debug($paymentTerms);
		/*Payment terms Insert*/
		foreach ($paymentTerms as $paymentTerm) {
			if($SbsSubscriberPaymentTerm->save($paymentTerm)) {
			    debug('Payment term saved');
			} else {
			    debug('Payment term not saved');
			}
		}
		/*Payment terms Insert*/
		
		/*Currency Mappings Insert*/
		foreach ($currencyMappings as $currency) {
			$SbsSubscriberCpnCurrencyMapping->save($currency);
		}
		/*Currency Mappings Insert*/
		
		debug($clients);
		/*Clients Insert*/
		foreach($clients as $clientInsert) {
		    debug($clientInsert);
			if($this->save($clientInsert)) {
			     debug('client saved');    
			} else {
			    debug('client not saved');
			}
		}
		/*End Clients Insert*/
		
		debug($clientContacts);
		/*Client Contacts Insert*/
		foreach($clientContacts as $clientContact) {
			if($AcrClientContact->save($clientContact)) {
			    debug('ClientContact saved');
			} else {
			    debug('ClientContact not saved');
			}
		}
		/*End Client Contacts Insert*/
		
		debug($clientFields);
		/*Client Custom fields Insert*/
		foreach($clientFields as $clientField) {
			$AcrClientCustomField->save($clientField);
		}
		/*End Client Custom fields Insert*/
		debug($clientCustomValues);
		/*Client Custom values Insert*/
        foreach($clientCustomValues as $clientCustomValue) {
            $AcrClientCustomValue->save($clientCustomValue);
        }
        /*End Client Custom fields Insert*/
		debug($clientCustomValues);
        
        /*Taxes Insert*/
        foreach($taxes as $tax) {
            $SbsSubscriberTax->save($tax);
        }
        /*End Taxes Insert*/
        
        /*Tax group Insert*/
        foreach($taxgroups as $taxgroup) {
            $SbsSubscriberTaxGroup->save($taxgroup);
        }
        /*End Tax group Insert*/
        
        debug($taxgroupMappings);
        /*Tax group mappings Insert*/
        foreach($taxgroupMappings as $taxgroupMapping) {
            debug($taxgroupMapping);
            debug($SbsSubscriberTaxGroupMapping->save($taxgroupMapping));
        }
        /*End Tax group mappings Insert*/
        
		/*Inventory Custom field*/
		foreach ($inventoryCustomFields as $inventoryCustomField) {
			$InvInventoryCustomField->save($inventoryCustomField);
		}
		/*End Inventory Custom field*/
		
		/*Inventory unit types*/
        foreach ($inventoryUnitTypes as $inventoryUnitType) {
            $InvInventoryUnitType->save($inventoryUnitType);
        }
        /*End Inventory unit types*/
		
		/*Inventories Insert*/
		foreach($inventories as $inventory) {
			$InvInventory->save($inventory);
		}
		/*End Inventories Insert*/
		
		/*Inventory custom field values*/
		foreach ($inventoryCustomValues as $inventoryCustomValue) {
			$InvInventoryCustomValue->save($inventoryCustomValue);
		}
        /*End Inventory custom field values*/
		
		
		/*Invoices custom values Insert*/
        foreach($invoiceCustomFields as $invoiceCustomField) {
            $AcrInvoiceCustomField->save($invoiceCustomField);
        }
        /*End Invoices custom values Insert*/
        
		
		
		/*Invoices Insert*/
		foreach($clientInvoices as $clientInvoice) {
			$AcrClientInvoice->save($clientInvoice);
		}
		/*End Invoices Insert*/
		
		
		/*Invoices custom values Insert*/
		foreach($invoiceCustomValues as $invoiceCustomValue) {
			$AcrInvoiceCustomValue->save($invoiceCustomValue);
		}
		/*End Invoices custom values Insert*/
		
		/*Invoices details Insert*/
		foreach($invoiceDetails as $invoiceDetail) {
			$AcrInvoiceDetail->save($invoiceDetail);
		}
		/*End Invoices details Insert*/
		
		/*Recurring Invoices details Insert*/
		foreach($recurringPayments as $recurringPayment) {
			$AcrClientRecurringInvoice->save($recurringPayment);
		}
		/*End Recurring Invoices details Insert*/
		
		/*Invoice payments Insert*/
		foreach($payments as $payment) {
			$AcrInvoicePaymentDetail->save($payment);
		}
		/*End Invoices payments Insert*/
		
		debug($creditNotes);
		/*Client Credit Notes*/
		foreach ($creditNotes as $creditNote) {
			$AcrClientCreditnote->save($creditNote);
		}
		/*End Client Credit Notes*/
		
		/*Credit note products*/
		foreach ($AcrCreditnoteProducts as $CreditnoteProduct) {
			$AcrClientCreditnoteProduct->save($CreditnoteProduct);
		}
		/*End Credit note products*/
		
		/*CreditNote mapping*/
		foreach ($creditNoteMapping as $creditNoteMappingDet) {
			$AcrCreditnotePaymentMapping->save($creditNoteMappingDet);
		}
		/*End CreditNote mapping*/
		
		
		/*Quotation Insert*/
        foreach($quotations as $quotation) {
            $SlsQuotation->save($quotation);
        }
        /*End Quotation Insert*/
        
        /*Quotation products Insert*/
        foreach($quotationProducts as $quotationProduct) {
            $SlsQuotationProduct->save($quotationProduct);
        }
        /*End Quotation products Insert*/
        
        /*Quotation custom fields Insert*/
        foreach($quotationCustomFields as $quotationCustomField) {
            $SlsQuotationCustomField->save($quotationCustomField);
        }
        /*End Quotation custom fields Insert*/
        
        /*Quotation custom values Insert*/
        foreach($quotationCustomValues as $quotationCustomValue) {
            $SlsQuotationCustomValue->save($quotationCustomValue);
        }
        /*End Quotation custom values Insert*/
        
		
		
		/*Expense category Insert*/
        foreach($expensecatogries as $expensecatogry) {
            $AcpExpenseCategory->save($expensecatogry);
        }
        /*End Expense category Insert*/
        
        /*Expense vendor Insert*/
        foreach($vendors as $vendor) {
            $AcpVendor->save($vendor);
        }
        /*End Expense vendor Insert*/
        
        /*Expense Custom fields Insert*/
        foreach($expenseCustomFields as $expenseCustomField) {
            $AcpExpenseCustomField->save($expenseCustomField);
        }
        /*End Expense Custom fields Insert*/
        
        /*Expense Insert*/
        foreach($expenses as $expense) {
            if($AcpExpense->save($expense)) {
                debug('Expense saved');
            } else {
                debug('expense not saved');
            }
        }
        /*End Expense Insert*/
        debug('reacccched');
        debug($expenseCustomFieldValues);
        /*Expense Custom field values Insert*/
        
        foreach ($expenseCustomFieldValues as $expenseCustomValue) {
            $AcpExpenseCustomFieldValue->save($expenseCustomValue);
        }
        /*End Expense Custom field values Insert*/
        
        /*Inventory Expenses Insert*/
        foreach($inventoryExpenses as $inventoryExpense) {
            $AcpInventoryExpense->save($inventoryExpense);
        }
        /*End Inventory Expenses Insert*/
        
        /*Inventory expense invoices insert*/
        foreach ($inventoryInvoices as $inventoryInvoice) {
            $AcrInventoryInvoice->save($inventoryInvoice);
        }
        /*End Inventory expense invoices insert*/
        
        /*Downgrade Insert*/
		foreach ($downgradeRequests as $downgradeOption) {
			$SbsDowngradeRequest->save($downgradeOption);
		}
        /*End Downgrade Insert*/
		
		/*Aging bucket Insert*/
		foreach ($agingBuckets as $agingBucket) {
			$SbsAgingBucket->save($agingBucket);
		}
        /*End Aging bucket Insert*/
        
        /*Email Template details Insert*/
        foreach ($emailTemplateDetails as $emailTemplateDetail) {
            if($SbsEmailTemplateDetail->save($emailTemplateDetail)) {
                debug('emailtemplate saved');
            } else {
                debug('email template not saved');
            }
        }
        /*End Email Template details Insert*/
        
        /*Payment Method values*/
        foreach ($paymentMethValues as $paymentMethValue) {
            $SbsPaymentMethodValue->save($paymentMethValue);
        }
        /*End Payment Method values*/
        
        /*Payment Methods*/
        foreach ($paymentMethods as $paymentMethod) {
            $SbsPaymentMethod->save($paymentMethod);
        }
        /*End Payment Methods*/
        debug('insertion over');
        
		/*Disconnect Archive database & Start default(cantorix) connection*/
		$this->useDbConfig                            = $defaultConfigVar;
		$this->schemaName                             = $defaultDatabase;
		
		$AcrClientContact->useDbConfig                = $defaultConfigVar;
		$AcrClientContact->schemaName                 = $defaultDatabase;
		
        $AcrClientCreditnote->useDbConfig             = $defaultConfigVar;
        $AcrClientCreditnote->schemaName              = $defaultDatabase;
        
		$AcrClientCustomField->useDbConfig            = $defaultConfigVar;
		$AcrClientCustomField->schemaName             = $defaultDatabase;
		
		$AcrClientCustomValue->useDbConfig            = $defaultConfigVar;
		$AcrClientCustomValue->schemaName             = $defaultDatabase;
		
		$InvInventory->useDbConfig                    = $defaultConfigVar;
		$InvInventory->schemaName                     = $defaultDatabase;
		
        $InvInventoryUnitType->useDbConfig            = $defaultConfigVar;
        $InvInventoryUnitType->schemaName             = $defaultDatabase;
        
        $InvInventoryCustomValue->useDbConfig         = $defaultConfigVar;
        $InvInventoryCustomValue->schemaName          = $defaultDatabase;
        
        $InvInventoryCustomField->useDbConfig         = $defaultConfigVar;
        $InvInventoryCustomField->schemaName          = $defaultDatabase;
        
		$AcpExpenseCategory->useDbConfig              = $defaultConfigVar;
		$AcpExpenseCategory->schemaName               = $defaultDatabase;
		
        $AcpExpenseCustomField->useDbConfig           = $defaultConfigVar;
        $AcpExpenseCustomField->schemaName            = $defaultDatabase;
        
        $AcpExpenseCustomFieldValue->useDbConfig      = $defaultConfigVar;
        $AcpExpenseCustomFieldValue->schemaName       = $defaultDatabase;
        
		$AcpExpense->useDbConfig                      = $defaultConfigVar;
		$AcpExpense->schemaName                       = $defaultDatabase;
		
        $AcpVendor->useDbConfig                       = $defaultConfigVar;
        $AcpVendor->schemaName                        = $defaultDatabase;
        
		$AcpInventoryExpense->useDbConfig             = $defaultConfigVar;
		$AcpInventoryExpense->schemaName              = $defaultDatabase;
		
		$AcrInventoryInvoice->useDbConfig             = $defaultConfigVar;
		$AcrInventoryInvoice->schemaName              = $defaultDatabase;
		
		$SbsSubscriberTax->useDbConfig                = $defaultConfigVar;
		$SbsSubscriberTax->schemaName                 = $defaultDatabase;
		
		$SbsSubscriberTaxGroup->useDbConfig           = $defaultConfigVar;
		$SbsSubscriberTaxGroup->schemaName            = $defaultDatabase;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig    = $defaultConfigVar;
		$SbsSubscriberTaxGroupMapping->schemaName     = $defaultDatabase;
		
		$SlsQuotation->useDbConfig                    = $defaultConfigVar;
		$SlsQuotation->schemaName                     = $defaultDatabase;
		
		$SlsQuotationProduct->useDbConfig             = $defaultConfigVar;
		$SlsQuotationProduct->schemaName              = $defaultDatabase;
		
		$SlsQuotationCustomField->useDbConfig         = $defaultConfigVar;
		$SlsQuotationCustomField->schemaName          = $defaultDatabase;
		
		$SlsQuotationCustomValue->useDbConfig         = $defaultConfigVar;
		$SlsQuotationCustomValue->schemaName          = $defaultDatabase;
		
		$AcrClientInvoice->useDbConfig                = $defaultConfigVar;
		$AcrClientInvoice->schemaName                 = $defaultDatabase;
		
		$AcrInvoiceCustomField->useDbConfig           = $defaultConfigVar;
		$AcrInvoiceCustomField->schemaName            = $defaultDatabase;
		
		$AcrInvoiceCustomValue->useDbConfig           = $defaultConfigVar;
		$AcrInvoiceCustomValue->schemaName            = $defaultDatabase;
		
		$AcrInvoiceDetail->useDbConfig                = $defaultConfigVar;
		$AcrInvoiceDetail->schemaName                 = $defaultDatabase;
		
		$AcrInvoicePaymentDetail->useDbConfig         = $defaultConfigVar;
		$AcrInvoicePaymentDetail->schemaName          = $defaultDatabase;
		
		$AcrClientRecurringInvoice->useDbConfig       = $defaultConfigVar;
		$AcrClientRecurringInvoice->schemaName        = $defaultDatabase;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $defaultConfigVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName  = $defaultDatabase;
		
		$SbsSubscriberPaymentTerm->useDbConfig        = $defaultConfigVar;
		$SbsSubscriberPaymentTerm->schemaName         = $defaultDatabase;
        
        $SbsAgingBucket->useDbConfig                  = $defaultConfigVar;
        $SbsAgingBucket->schemaName                   = $defaultDatabase;
        
        $SbsEmailTemplateDetail->useDbConfig          = $defaultConfigVar;
        $SbsEmailTemplateDetail->schemaName           = $defaultDatabase;
        
        $AcrClientCreditnote->useDbConfig             = $defaultConfigVar;
        $AcrClientCreditnote->schemaName              = $defaultDatabase;
        
        $AcrClientCreditnoteProduct->useDbConfig      = $defaultConfigVar;
        $AcrClientCreditnoteProduct->schemaName       = $defaultDatabase;
        
        $AcrCreditnotePaymentMapping->useDbConfig     = $defaultConfigVar;
        $AcrCreditnotePaymentMapping->schemaName      = $defaultDatabase;
        
        $SbsDowngradeRequest->useDbConfig             = $defaultConfigVar;
        $SbsDowngradeRequest->schemaName              = $defaultDatabase;
        
        $SbsPaymentMethodValue->useDbConfig           = $defaultConfigVar;
        $SbsPaymentMethodValue->schemaName            = $defaultDatabase;
        
        $SbsPaymentMethod->useDbConfig                = $defaultConfigVar;
        $SbsPaymentMethod->schemaName                 = $defaultDatabase;
        
		/*End Disconnect Archive database  & Start default(cantorix) connection*/
		
		/*Delete All the archived records from cantorix database*/
		
		$SlsQuotationCustomValue->deleteAll(array('SlsQuotationCustomValue.sls_quotation_id'=>$quotationIds), FALSE);
		//$SlsQuotationCustomField->deleteAll(array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$SlsQuotationProduct->deleteAll(array('SlsQuotationProduct.sls_quotation_id'=>$quotationIds), FALSE);
		$SlsQuotation->deleteAll(array('SlsQuotation.sbs_subscriber_id'=>$subscriberId), FALSE);
        
		/*Expense Deletions*/
		$AcpInventoryExpense->recursive = -1;
		$AcrInventoryInvoice->deleteAll(array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds),FALSE);
        $AcpExpenseCustomFieldValue->deleteAll(array('AcpExpenseCustomFieldValue.acp_expense_id'=>$expenseIds),FALSE);
		$AcpInventoryExpense->deleteAll(array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
		$AcpExpense->deleteAll(array('AcpExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
		$AcpExpenseCategory->deleteAll(array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcpExpenseCustomField->deleteAll(array('AcpExpenseCustomField.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcpVendor->deleteAll(array('AcpVendor.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*End Expense Deletions*/
		
		/*Invoice related Deletions*/
		$AcrCreditnotePaymentMapping->deleteAll(array('AcrCreditnotePaymentMapping.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcrClientCreditnoteProduct->deleteAll(array('AcrClientCreditnoteProduct.acr_client_creditnote_id'=>$creditNotesIds),FALSE);
		$AcrClientCreditnote->deleteAll(array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId),FALSE);
		$AcrInvoicePaymentDetail->deleteAll(array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientRecurringInvoice->deleteAll(array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceDetail->deleteAll(array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceCustomValue->deleteAll(array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds), FALSE);
		$AcrInvoiceCustomField->deleteAll(array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientInvoice->deleteAll(array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*End Invoice related Deletions*/
		
		
		/*Client related Deletions*/
		$AcrClientCustomValue->deleteAll(array('AcrClientCustomValue.acr_client_id'=>$clientIds),FALSE);
		$AcrClientCustomField->deleteAll(array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientContact->deleteAll(array('AcrClientContact.sbs_subscriber_id'=>$subscriberId), FALSE);
		$this->deleteAll(array('AcrClient.sbs_subscriber_id' => $subscriberId),FALSE);
        debug('Came');
        debug('asdasdasd');    
		/*End Client related Deletions*/
		
		/*Currency mapping Deletion*/
		$SbsSubscriberCpnCurrencyMapping->deleteAll(array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*End Currency mapping Deletion*/
		debug('123123aaaaaaaaaaaaa');
		/*Payment Terms Deletion*/
		$SbsSubscriberPaymentTerm->deleteAll(array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*End Payment Terms Deletion*/
		
		/*Aging bucket deletion*/
		$SbsAgingBucket->deleteAll(array('SbsAgingBucket.sbs_subscriber_id'=>$subscriberId),FALSE);
        /*End Aging bucket deletion*/
		
		/*Email template details*/
		$SbsEmailTemplateDetail->deleteAll(array('SbsEmailTemplateDetail.sbs_subscriber_id'=>$subscriberId),FALSE);
        /*End Email template details*/
		
		/*inventory Deletion*/
		$InvInventoryCustomValue->deleteAll(array('InvInventoryCustomValue.inv_inventory_id'=>$inventoryIds),FALSE);		
		$InvInventory->deleteAll(array('InvInventory.sbs_subscriber_id'=>$subscriberId),FALSE);
        $InvInventoryCustomField->deleteAll(array('InvInventoryCustomField.sbs_subscriber_id'=>$subscriberId),FALSE);
        $InvInventoryUnitType->deleteAll(array('InvInventoryUnitType.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*End Inventory Deletion*/
		
		/*Tax related deletions*/
		$SbsSubscriberTaxGroupMapping->deleteAll(array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxIds), FALSE);
		$SbsSubscriberTaxGroup->deleteAll(array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId),FALSE);
		$SbsSubscriberTax->deleteAll(array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*End Tax related deletions*/
		debug('end Tax');
		
        /*Downgrade Deletion*/
        $SbsDowngradeRequest->deleteAll(array('SbsDowngradeRequest.sbs_subscriber_id'=>$subscriberId), FALSE);
        /*End Downgrade Deletion*/
        debug('Request');
        
        /*Payment Methods*/
        $SbsPaymentMethod->deleteAll(array('SbsPaymentMethod.subscriber_id'=>$subscriberId), FALSE);
        /*End Payment Methods*/
        debug('PaymentMethod');
        
		/*Payment method values*/
        $SbsPaymentMethodValue->deleteAll(array('SbsPaymentMethodValue.subscriber_id'=>$subscriberId), FALSE);
        debug('MethodValue');
        /*End Payment method values*/
		
		
		debug('Archive Completed');
		/*End Delete All the archived records from cantorix database*/
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
		$AcrClientContact                 = ClassRegistry::init('AcrClientContact');
		$AcrClientCustomField             = ClassRegistry::init('AcrClientCustomField');
		$AcrClientCustomValue             = ClassRegistry::init('AcrClientCustomValue');
		$AcpExpenseCategory               = ClassRegistry::init('AcpExpenseCategory');
        
		$AcpExpense                       = ClassRegistry::init('AcpExpense');
        $AcpExpenseCustomField            = ClassRegistry::init('AcpExpenseCustomField');
        $AcpExpenseCustomFieldValue       = ClassRegistry::init('AcpExpenseCustomFieldValue');
        $AcpVendor                        = ClassRegistry::init('AcpVendor');
		$AcpInventoryExpense              = ClassRegistry::init('AcpInventoryExpense');
		$AcrInventoryInvoice              = ClassRegistry::init('AcrInventoryInvoice');
		
		$SbsSubscriberTax                 = ClassRegistry::init('SbsSubscriberTax');
		$SbsSubscriberTaxGroup            = ClassRegistry::init('SbsSubscriberTaxGroup');
		$SbsSubscriberTaxGroupMapping     = ClassRegistry::init('SbsSubscriberTaxGroupMapping');
        
		$SlsQuotation                     = ClassRegistry::init('SlsQuotation');
		$SlsQuotationProduct              = ClassRegistry::init('SlsQuotationProduct');
		$SlsQuotationCustomValue          = ClassRegistry::init('SlsQuotationCustomValue');
        
		$AcrClientInvoice                 = ClassRegistry::init('AcrClientInvoice');
		$AcrInvoiceCustomField            = ClassRegistry::init('AcrInvoiceCustomField');
		$AcrInvoiceCustomValue            = ClassRegistry::init('AcrInvoiceCustomValue');
		$AcrInvoicePaymentDetail          = ClassRegistry::init('AcrInvoicePaymentDetail');
		$AcrInvoiceDetail                 = ClassRegistry::init('AcrInvoiceDetail');
		$AcrClientRecurringInvoice        = ClassRegistry::init('AcrClientRecurringInvoice');
		
        $AcrClientCreditnote              = ClassRegistry::init('AcrClientCreditnote');
        $AcrCreditnotePaymentMapping      = ClassRegistry::init('AcrCreditnotePaymentMapping');
        $AcrClientCreditnoteProduct       = ClassRegistry::init('AcrClientCreditnoteProduct');
        
        $SbsSubscriberPaymentTerm         = ClassRegistry::init('SbsSubscriberPaymentTerm');
        $SbsSubscriberCpnCurrencyMapping  = ClassRegistry::init('SbsSubscriberCpnCurrencyMapping');
        $SbsDowngradeRequest              = ClassRegistry::init('SbsDowngradeRequest');
        $SbsPaymentMethodValue            = ClassRegistry::init('SbsPaymentMethodValue');
        $SbsPaymentMethod                 = ClassRegistry::init('SbsPaymentMethod');
        $SbsSubscriberCpnCurrencyMapping  = ClassRegistry::init('SbsSubscriberCpnCurrencyMapping');
        $SbsAgingBucket                   = ClassRegistry::init('SbsAgingBucket');
        $SbsEmailTemplateDetail           = ClassRegistry::init('SbsEmailTemplateDetail');
        $SbsSubscriberSetting             = ClassRegistry::init('SbsSubscriberSetting');
        $SbsSubscriber                    = ClassRegistry::init('SbsSubscriber');
        $SbsSubscriberOrganizationDetail  = ClassRegistry::init('SbsSubscriberOrganizationDetail');
        
        
        
        $InvInventoryCustomValue          = ClassRegistry::init('InvInventoryCustomValue');
        $InvInventoryUnitType             = ClassRegistry::init('InvInventoryUnitType');
        $InvInventory                     = ClassRegistry::init('InvInventory');
        $InvInventoryCustomField          = ClassRegistry::init('InvInventoryCustomField');
		/*Loading all required models*/
		
		/*Connect Archive database */
		$this->useDbConfig                            = $archiveConfigVar;
		$this->schemaName                             = $archiveDatabase;
		
		$AcrClientContact->useDbConfig                = $archiveConfigVar;
		$AcrClientContact->schemaName                 = $archiveDatabase;
		
		$AcrClientCustomField->useDbConfig            = $archiveConfigVar;
		$AcrClientCustomField->schemaName             = $archiveDatabase;
		
		$AcrClientCustomValue->useDbConfig            = $archiveConfigVar;
		$AcrClientCustomValue->schemaName             = $archiveDatabase;
		
		$InvInventory->useDbConfig                    = $archiveConfigVar;
		$InvInventory->schemaName                     = $archiveDatabase;
		
        $InvInventoryUnitType->useDbConfig            = $archiveConfigVar;
        $InvInventoryUnitType->schemaName             = $archiveDatabase;
        
        $InvInventoryCustomField->useDbConfig         = $archiveConfigVar;
        $InvInventoryCustomField->schemaName          = $archiveDatabase;
        
        $InvInventoryCustomValue->useDbConfig         = $archiveConfigVar;
        $InvInventoryCustomValue->schemaName          = $archiveDatabase;
        
		$AcpExpenseCategory->useDbConfig              = $archiveConfigVar;
		$AcpExpenseCategory->schemaName               = $archiveDatabase;
		
		$AcpExpense->useDbConfig                      = $archiveConfigVar;
		$AcpExpense->schemaName                       = $archiveDatabase;
		
        $AcpExpenseCustomField->useDbConfig           = $archiveConfigVar;
        $AcpExpenseCustomField->schemaName            = $archiveDatabase;
        
        $AcpExpenseCustomFieldValue->useDbConfig      = $archiveConfigVar;
        $AcpExpenseCustomFieldValue->schemaName       = $archiveDatabase;
        
        $AcpVendor->useDbConfig                       = $archiveConfigVar;
        $AcpVendor->schemaName                        = $archiveDatabase;
        
		$AcpInventoryExpense->useDbConfig             = $archiveConfigVar;
		$AcpInventoryExpense->schemaName              = $archiveDatabase;
		
		$AcrInventoryInvoice->useDbConfig             = $archiveConfigVar;
		$AcrInventoryInvoice->schemaName              = $archiveDatabase;
		
		$SbsSubscriberTax->useDbConfig                = $archiveConfigVar;
		$SbsSubscriberTax->schemaName                 = $archiveDatabase;
		
		$SbsSubscriberTaxGroup->useDbConfig           = $archiveConfigVar;
		$SbsSubscriberTaxGroup->schemaName            = $archiveDatabase;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig    = $archiveConfigVar;
		$SbsSubscriberTaxGroupMapping->schemaName     = $archiveDatabase;
		
        $SbsSubscriberPaymentTerm->useDbConfig        = $archiveConfigVar;
        $SbsSubscriberPaymentTerm->schemaName         = $archiveDatabase;
        
        $SbsAgingBucket->useDbConfig                  = $archiveConfigVar;
        $SbsAgingBucket->schemaName                   = $archiveDatabase;
        
		$SlsQuotation->useDbConfig                    = $archiveConfigVar;
		$SlsQuotation->schemaName                     = $archiveDatabase;
		
		$SlsQuotationProduct->useDbConfig             = $archiveConfigVar;
		$SlsQuotationProduct->schemaName              = $archiveDatabase;
		
		$SlsQuotationCustomValue->useDbConfig         = $archiveConfigVar;
		$SlsQuotationCustomValue->schemaName          =  $archiveDatabase;
		
		$AcrClientInvoice->useDbConfig                = $archiveConfigVar;
		$AcrClientInvoice->schemaName                 = $archiveDatabase;
		
		$AcrInvoiceCustomField->useDbConfig           = $archiveConfigVar;
		$AcrInvoiceCustomField->schemaName            = $archiveDatabase;
		
		$AcrInvoiceCustomValue->useDbConfig           = $archiveConfigVar;
		$AcrInvoiceCustomValue->schemaName            = $archiveDatabase;
		
		$AcrInvoiceDetail->useDbConfig                = $archiveConfigVar;
		$AcrInvoiceDetail->schemaName                 = $archiveDatabase;
		
		$AcrInvoicePaymentDetail->useDbConfig         = $archiveConfigVar;
		$AcrInvoicePaymentDetail->schemaName          = $archiveDatabase;
		
		$AcrClientRecurringInvoice->useDbConfig       = $archiveConfigVar;
		$AcrClientRecurringInvoice->schemaName        = $archiveDatabase;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $archiveConfigVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName  = $archiveDatabase;
        
        $AcrClientCreditnote->useDbConfig             = $archiveConfigVar;
        $AcrClientCreditnote->schemaName              = $archiveDatabase;
        
        $AcrCreditnotePaymentMapping->useDbConfig     = $archiveConfigVar;
        $AcrCreditnotePaymentMapping->schemaName      = $archiveDatabase;
        
        $AcrClientCreditnoteProduct->useDbConfig      = $archiveConfigVar;
        $AcrClientCreditnoteProduct->schemaName       = $archiveDatabase;
        
        $SbsEmailTemplateDetail->useDbConfig          = $archiveConfigVar;
        $SbsEmailTemplateDetail->schemaName           = $archiveDatabase;
        
        $SbsDowngradeRequest->useDbConfig             = $archiveConfigVar;
        $SbsDowngradeRequest->schemaName              = $archiveDatabase;
        
        $SbsPaymentMethodValue->useDbConfig           = $archiveConfigVar;
        $SbsPaymentMethodValue->schemaName            = $archiveDatabase;
        
        $SbsPaymentMethod->useDbConfig                = $archiveConfigVar;
        $SbsPaymentMethod->schemaName                 = $archiveDatabase;
        
		/*Connecting Database*/
		
		/* Get all required data from client module tables*/
		
		$paymentTerms = $SbsSubscriberPaymentTerm->find('all',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id' => $subscriberId)));
		
		$currencyMappings = $SbsSubscriberCpnCurrencyMapping->find('all',array('conditions'=>array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id' => $subscriberId)));
			
		$clients = $this->find('all',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
		$clientIds = $this->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
		 
		$clientContacts =  $AcrClientContact->find('all',array('conditions'=>array('AcrClientContact.sbs_subscriber_id'=>$subscriberId)));
		
		$clientFields = $AcrClientCustomField->find('all',array('conditions'=>array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId)));
		
		$clientCustomValues = $AcrClientCustomValue->find('all',array('conditions'=>array('AcrClientCustomValue.acr_client_id'=>$clientIds)));
        
        
		/*Inventory Module related tables*/
        $inventoryUnitTypes = $InvInventoryUnitType->find('all',array('conditions'=>array('InvInventoryUnitType.sbs_subscriber_id'=>$subscriberId))); 
        debug($inventoryUnitTypes);
        
		$inventories = $InvInventory->find('all',array('conditions'=>array('InvInventory.sbs_subscriber_id'=>$subscriberId)));
		$inventoryIds = $InvInventory->find('list',array('conditions'=>array('InvInventory.sbs_subscriber_id'=>$subscriberId),'fields'=>array('InvInventory.id','InvInventory.id')));
		
        $inventoryCustomFields        = $InvInventoryCustomField->find('all',array('conditions'=>array('InvInventoryCustomField.sbs_subscriber_id'=>$subscriberId)));
        debug($inventoryCustomFields);
        
        debug($inventoryIds);
        $inventoryCustomValues = $InvInventoryCustomValue->find('all',array('conditions'=>array('InvInventoryCustomValue.inv_inventory_id'=>$inventoryIds)));
        debug($inventoryCustomValues);
        /* End Inventory Module related tables*/
        
        
        /*Expense Module related Tables*/
        $expenseVendors = $AcpVendor->find('all',array('conditions'=>array('AcpVendor.sbs_subscriber_id'=>$subscriberId)));
        
		$expensecatogries = $AcpExpenseCategory->find('all',array('conditions'=>array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId)));
        
		$expenses = $AcpExpense->find('all',array('conditions'=>array('AcpExpense.sbs_subscriber_id'=>$subscriberId)));
        
        $expenseCustomFields = $AcpExpenseCustomField->find('all',array('conditions'=>array('AcpExpenseCustomField.sbs_subscriber_id' => $subscriberId)));
        $expenseCustomFieldIds = $AcpExpenseCustomField->find('list',array('conditions'=>array('AcpExpenseCustomField.sbs_subscriber_id' => $subscriberId)));
        
        $expensecustomValues = $AcpExpenseCustomFieldValue->find('all',array('conditions'=>array('AcpExpenseCustomFieldValue.acp_expense_custom_field_id' => $expenseCustomFieldIds)));
        
		$inventoryExpenses = $AcpInventoryExpense->find('all',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId)));
		$inventoryExpenseIds = $AcpInventoryExpense->find('list',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcpInventoryExpense.id','AcpInventoryExpense.id')));
        
		$inventoryInvoices = $AcrInventoryInvoice->find('all',array('conditions'=>array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds)));
		/*End Expense Module related Tables*/
		
		$taxes =  $SbsSubscriberTax->find('all',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId)));
		$taxIds = $SbsSubscriberTax->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.id')));
		
		$taxgroups =  $SbsSubscriberTaxGroup->find('all',array('conditions'=>array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId)));
		
		$taxgroupMappings =  $SbsSubscriberTaxGroupMapping->find('all',array('conditions'=>array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxIds)));
		
		$clientInvoices = $AcrClientInvoice->find('all',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId)));
		$clientInvoiceIds = $AcrClientInvoice->find('list',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClientInvoice.id','AcrClientInvoice.id')));
		
		$invoiceCustomFields = $AcrInvoiceCustomField->find('all',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId)));
		$invoiceCustomFieldIds = $AcrInvoiceCustomField->find('list',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoiceCustomField.id','AcrInvoiceCustomField.id')));
		
		$invoiceCustomValues = $AcrInvoiceCustomValue->find('all',array('conditions'=>array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds)));
		
		$invoiceDetails = $AcrInvoiceDetail->find('all',array('conditions'=>array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds)));
		
		$payments = $AcrInvoicePaymentDetail->find('all',array('conditions'=>array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId)));
		
		$recurringPayments = $AcrClientRecurringInvoice->find('all',array('conditions'=>array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds)));
        
        $quotations = $SlsQuotation->find('all',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId)));
        $quotationIds = $SlsQuotation->find('list',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotation.id')));
        
        $quotationProducts = $SlsQuotationProduct->find('all',array('conditions'=>array('SlsQuotationProduct.sls_quotation_id'=>$quotationIds)));
        
        $quotationCustomValues = $SlsQuotationCustomValue->find('all',array('conditions'=>array('SlsQuotationCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds)));
        
        $creditNotes                = $AcrClientCreditnote->find('all',array('conditions'=>array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId)));
        $creditNotesIds             = $AcrClientCreditnote->find('list',array('conditions'=>array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId)));
        debug($creditNotes);
        debug($creditNotesIds);
        
        $creditNoteMapping           = $AcrCreditnotePaymentMapping->find('all',array('conditions'=>array('AcrCreditnotePaymentMapping.sbs_subscriber_id'=>$subscriberId)));
        debug($creditNoteMapping);
        
        $AcrCreditnoteProducts       = $AcrClientCreditnoteProduct->find('all',array('conditions'=>array('AcrClientCreditnoteProduct.acr_client_creditnote_id'=>$creditNotesIds)));
        debug($AcrCreditnoteProducts);
        
        $agingBuckets           = $SbsAgingBucket->find('all',array('conditions'=>array('SbsAgingBucket.sbs_subscriber_id'=>$subscriberId)));
        debug($agingBuckets);
        
        $emailTemplateDetails   = $SbsEmailTemplateDetail->find('all',array('conditions'=>array('SbsEmailTemplateDetail.sbs_subscriber_id'=>$subscriberId)));
        debug($emailTemplateDetails); 
        
        $downgradeRequests      = $SbsDowngradeRequest->find('all',array('conditions'=>array('SbsDowngradeRequest.sbs_subscriber_id'=>$subscriberId)));
        debug($downgradeRequests);
        
        $paymentMethValues      = $SbsPaymentMethodValue->find('all',array('conditions'=>array('SbsPaymentMethodValue.subscriber_id'=>$subscriberId)));
        debug($paymentMethValues);
        
        $paymentMethods         = $SbsPaymentMethod->find('all',array('conditions'=>array('SbsPaymentMethod.subscriber_id'=>$subscriberId)));
        debug($paymentMethods);
        
		/* End Get all required data from client module tables*/
		
		
		/*Disconnect Archive database & Start default(cantorix) connection*/
		$this->useDbConfig                            = $defaultConfigVar;
		$this->schemaName                             = $defaultDatabase;
		
		$AcrClientContact->useDbConfig                = $defaultConfigVar;
		$AcrClientContact->schemaName                 = $defaultDatabase;
		
		$AcrClientCustomField->useDbConfig            = $defaultConfigVar;
		$AcrClientCustomField->schemaName             = $defaultDatabase;
		
		$AcrClientCustomValue->useDbConfig            = $defaultConfigVar;
		$AcrClientCustomValue->schemaName             = $defaultDatabase;
		
		$InvInventory->useDbConfig                    = $defaultConfigVar;
		$InvInventory->schemaName                     = $defaultDatabase;
		
        $InvInventoryUnitType->useDbConfig            = $defaultConfigVar;
        $InvInventoryUnitType->schemaName             = $defaultDatabase;
        
        $InvInventoryCustomField->useDbConfig         = $defaultConfigVar;
        $InvInventoryCustomField->schemaName          = $defaultDatabase;
        
        $InvInventoryCustomValue->useDbConfig         = $defaultConfigVar;
        $InvInventoryCustomValue->schemaName          = $defaultDatabase;
        
        
        $AcpVendor->useDbConfig                       = $defaultConfigVar;
        $AcpVendor->schemaName                        = $defaultDatabase;
        
		$AcpExpenseCategory->useDbConfig              = $defaultConfigVar;
		$AcpExpenseCategory->schemaName               = $defaultDatabase;
		
		$AcpExpense->useDbConfig                      = $defaultConfigVar;
		$AcpExpense->schemaName                       = $defaultDatabase;
		
		$AcpInventoryExpense->useDbConfig             = $defaultConfigVar;
		$AcpInventoryExpense->schemaName              = $defaultDatabase;
		
        $AcpExpenseCustomField->useDbConfig           = $defaultConfigVar;
        $AcpExpenseCustomField->schemaName            = $defaultDatabase;
        
        $AcpExpenseCustomFieldValue->useDbConfig      = $defaultConfigVar;
        $AcpExpenseCustomFieldValue->schemaName       = $defaultDatabase;
        
		$AcrInventoryInvoice->useDbConfig             = $defaultConfigVar;
		$AcrInventoryInvoice->schemaName              = $defaultDatabase;
		
		$SbsSubscriberTax->useDbConfig                = $defaultConfigVar;
		$SbsSubscriberTax->schemaName                 = $defaultDatabase;
		
		$SbsSubscriberTaxGroup->useDbConfig           = $defaultConfigVar;
		$SbsSubscriberTaxGroup->schemaName            = $defaultDatabase;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig    = $defaultConfigVar;
		$SbsSubscriberTaxGroupMapping->schemaName     = $defaultDatabase;
		
		$SlsQuotation->useDbConfig                    = $defaultConfigVar;
		$SlsQuotation->schemaName                     = $defaultDatabase;
		
		$SlsQuotationProduct->useDbConfig             = $defaultConfigVar;
		$SlsQuotationProduct->schemaName              = $defaultDatabase;
		
		$SlsQuotationCustomField->useDbConfig         = $defaultConfigVar;
		$SlsQuotationCustomField->schemaName          = $defaultDatabase;
		
		$SlsQuotationCustomValue->useDbConfig         = $defaultConfigVar;
		$SlsQuotationCustomValue->schemaName          = $defaultDatabase;
		
		$AcrClientInvoice->useDbConfig                = $defaultConfigVar;
		$AcrClientInvoice->schemaName                 = $defaultDatabase;
		
		$AcrInvoiceCustomField->useDbConfig           = $defaultConfigVar;
		$AcrInvoiceCustomField->schemaName            = $defaultDatabase;
		
		$AcrInvoiceCustomValue->useDbConfig           = $defaultConfigVar;
		$AcrInvoiceCustomValue->schemaName            = $defaultDatabase;
		
		$AcrInvoiceDetail->useDbConfig                = $defaultConfigVar;
		$AcrInvoiceDetail->schemaName                 = $defaultDatabase;
		
		$AcrInvoicePaymentDetail->useDbConfig         = $defaultConfigVar;
		$AcrInvoicePaymentDetail->schemaName          = $defaultDatabase;
		
		$AcrClientRecurringInvoice->useDbConfig       = $defaultConfigVar;
		$AcrClientRecurringInvoice->schemaName        = $defaultDatabase;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $defaultConfigVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName  = $defaultDatabase;
		
		$SbsSubscriberPaymentTerm->useDbConfig        = $defaultConfigVar;
		$SbsSubscriberPaymentTerm->schemaName         = $defaultDatabase;
		
        $AcrClientCreditnote->useDbConfig             = $defaultConfigVar;
        $AcrClientCreditnote->schemaName              = $defaultDatabase;
        
        $AcrCreditnotePaymentMapping->useDbConfig     = $defaultConfigVar;
        $AcrCreditnotePaymentMapping->schemaName      = $defaultDatabase;
        
        $AcrClientCreditnoteProduct->useDbConfig      = $defaultConfigVar;
        $AcrClientCreditnoteProduct->schemaName       = $defaultDatabase;
        
        $SbsAgingBucket->useDbConfig                  = $defaultConfigVar;
        $SbsAgingBucket->schemaName                   = $defaultDatabase;
        
        $SbsEmailTemplateDetail->useDbConfig          = $defaultConfigVar;
        $SbsEmailTemplateDetail->schemaName           = $defaultDatabase;
        
        $SbsDowngradeRequest->useDbConfig             = $defaultConfigVar;
        $SbsDowngradeRequest->schemaName              = $defaultDatabase;
        
        $SbsPaymentMethodValue->useDbConfig           = $defaultConfigVar;
        $SbsPaymentMethodValue->schemaName            = $defaultDatabase;
        
        $SbsPaymentMethod->useDbConfig                = $defaultConfigVar;
        $SbsPaymentMethod->schemaName                 = $defaultDatabase;
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
			$AcrClientContact->save($clientContact);
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
		
		
		/*Inventory Custom field*/
        foreach ($inventoryCustomFields as $inventoryCustomField) {
            $InvInventoryCustomField->save($inventoryCustomField);
        }
        /*End Inventory Custom field*/
		
		/*Inventory unit types*/
        foreach ($inventoryUnitTypes as $inventoryUnitType) {
            $InvInventoryUnitType->save($inventoryUnitType);
        }
        /*End Inventory unit types*/
		
		/*Inventories Insert*/
		foreach($inventories as $inventory) {
			$InvInventory->save($inventory,array('validate' => false));
		}
		/*Inventories Insert*/
		
		debug($inventoryCustomValues);
        /*Inventory custom field values*/
        foreach ($inventoryCustomValues as $inventoryCustomValue) {
            $InvInventoryCustomValue->save($inventoryCustomValue);
        }
        /*End Inventory custom field values*/
		
		/*Inventory expense invoices insert*/
		foreach ($inventoryInvoices as $inventoryInvoice) {
			$AcrInventoryInvoice->save($inventoryInvoice);
		}
		/*End Inventory expense invoices insert*/
		
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
        
        /*Vendors Insert*/
        foreach($expenseVendors as $expenseVendor) {
            $AcpVendor->save($expenseVendor);
        }
        /*End Vendors Insert*/
        
        /*Expense category Insert*/
        foreach($expensecatogries as $expensecatogry) {
            $AcpExpenseCategory->save($expensecatogry);
        }
        /*Expense category Insert*/
        debug('Expense category');
        /*Expense Insert*/
        foreach($expenses as $expense) {
            debug($expense);
            $AcpExpense->save($expense);
            debug('stoped');
        }
        /*Expense Insert*/
        debug('Expense');
        /*Inventory Expenses Insert*/
        foreach($inventoryExpenses as $inventoryExpense) {
            $AcpInventoryExpense->save($inventoryExpense);
        }
        /*Inventory Expenses Insert*/
        
        /*Expense custom fields*/
        foreach ($expenseCustomFields as $expenseCustomField) {
            $AcpExpenseCustomField->save($expenseCustomField);
        }
        /*End Expense Custom Fields*/
        
        /*Expense custom values*/
        foreach ($expensecustomValues as $expensecustomValue) {
            $AcpExpenseCustomFieldValue->save($expensecustomValue);
        }
        /*End Expense custom values*/
        
        debug($creditNotes);
        /*Client Credit Notes*/
        foreach ($creditNotes as $creditNote) {
            $AcrClientCreditnote->save($creditNote);
        }
        /*End Client Credit Notes*/
        
        /*Credit note products*/
        foreach ($AcrCreditnoteProducts as $CreditnoteProduct) {
            $AcrClientCreditnoteProduct->save($CreditnoteProduct);
        }
        /*End Credit note products*/
        
        /*CreditNote mapping*/
        foreach ($creditNoteMapping as $creditNoteMappingDet) {
            $AcrCreditnotePaymentMapping->save($creditNoteMappingDet);
        }
        /*End CreditNote mapping*/
        
        /*Quotation Insert*/
        foreach($quotations as $quotation) {
            $SlsQuotation->save($quotation);
        }
        /*Quotation Insert*/
        
        /*Quotation products Insert*/
        foreach($quotationProducts as $quotationProduct) {
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
        
        /*Aging bucket Insert*/
        foreach ($agingBuckets as $agingBucket) {
            $SbsAgingBucket->save($agingBucket);
        }
        /*End Aging bucket Insert*/
		
		/*Email Template details Insert*/
        foreach ($emailTemplateDetails as $emailTemplateDetail) {
            if($SbsEmailTemplateDetail->save($emailTemplateDetail)) {
                debug('emailtemplate saved');
            } else {
                debug('email template not saved');
            }
        }
        debug('insertion over');
        /*End Email Template details Insert*/
        
        /*Downgrade Insert*/
        foreach ($downgradeRequests as $downgradeOption) {
            $SbsDowngradeRequest->save($downgradeOption);
        }
        /*End Downgrade Insert*/
        
        /*Payment Method values*/
        foreach ($paymentMethValues as $paymentMethValue) {
            $SbsPaymentMethodValue->save($paymentMethValue);
        }
        /*End Payment Method values*/
        
        /*Payment Methods*/
        foreach ($paymentMethods as $paymentMethod) {
            $SbsPaymentMethod->save($paymentMethod);
        }
        /*End Payment Methods*/
        
		
		/*Connect Archive database */
		$this->useDbConfig                            = $archiveConfigVar;
		$this->schemaName                             = $archiveDatabase;
		
		$AcrClientContact->useDbConfig                = $archiveConfigVar;
		$AcrClientContact->schemaName                 = $archiveDatabase;
		
		$AcrClientCustomField->useDbConfig            = $archiveConfigVar;
		$AcrClientCustomField->schemaName             = $archiveDatabase;
		
		$AcrClientCustomValue->useDbConfig            = $archiveConfigVar;
		$AcrClientCustomValue->schemaName             = $archiveDatabase;
		
        $InvInventoryCustomValue->useDbConfig         = $archiveConfigVar;
        $InvInventoryCustomValue->schemaName          = $archiveDatabase;
        
		$InvInventory->useDbConfig                    = $archiveConfigVar;
		$InvInventory->schemaName                     = $archiveDatabase;
		
        $InvInventoryCustomField->useDbConfig         = $archiveConfigVar;
        $InvInventoryCustomField->schemaName          = $archiveDatabase;
        
        $InvInventoryUnitType->useDbConfig            = $archiveConfigVar;
        $InvInventoryUnitType->schemaName             = $archiveDatabase;
        
        $AcpVendor->useDbConfig                       = $archiveConfigVar;
        $AcpVendor->schemaName                        = $archiveDatabase;
        
        $AcpExpenseCustomField->useDbConfig           = $archiveConfigVar;
        $AcpExpenseCustomField->schemaName            = $archiveDatabase;
        
        $AcpExpenseCustomFieldValue->useDbConfig      = $archiveConfigVar;
        $AcpExpenseCustomFieldValue->schemaName       = $archiveDatabase;
        
		$AcpExpenseCategory->useDbConfig              = $archiveConfigVar;
		$AcpExpenseCategory->schemaName               = $archiveDatabase;
		
		$AcpExpense->useDbConfig                      = $archiveConfigVar;
		$AcpExpense->schemaName                       = $archiveDatabase;
		
		$AcpInventoryExpense->useDbConfig             = $archiveConfigVar;
		$AcpInventoryExpense->schemaName              = $archiveDatabase;
		
		$AcrInventoryInvoice->useDbConfig             = $archiveConfigVar;
		$AcrInventoryInvoice->schemaName              = $archiveDatabase;
		
		$SbsSubscriberTax->useDbConfig                = $archiveConfigVar;
		$SbsSubscriberTax->schemaName                 = $archiveDatabase;
		
		$SbsSubscriberTaxGroup->useDbConfig           = $archiveConfigVar;
		$SbsSubscriberTaxGroup->schemaName            = $archiveDatabase;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig    = $archiveConfigVar;
		$SbsSubscriberTaxGroupMapping->schemaName     = $archiveDatabase;
		
		$SlsQuotation->useDbConfig                    = $archiveConfigVar;
		$SlsQuotation->schemaName                     = $archiveDatabase;
		
		$SlsQuotationProduct->useDbConfig             = $archiveConfigVar;
		$SlsQuotationProduct->schemaName              = $archiveDatabase;
		
		$SlsQuotationCustomField->useDbConfig         = $archiveConfigVar;
		$SlsQuotationCustomField->schemaName          = $archiveDatabase;
		
		$SlsQuotationCustomValue->useDbConfig         = $archiveConfigVar;
		$SlsQuotationCustomValue->schemaName          = $archiveDatabase;
		
		$AcrClientInvoice->useDbConfig                = $archiveConfigVar;
		$AcrClientInvoice->schemaName                 = $archiveDatabase;
		
		$AcrInvoiceCustomField->useDbConfig           = $archiveConfigVar;
		$AcrInvoiceCustomField->schemaName            = $archiveDatabase;
		
		$AcrInvoiceCustomValue->useDbConfig           = $archiveConfigVar;
		$AcrInvoiceCustomValue->schemaName            = $archiveDatabase;
		
		$AcrInvoiceDetail->useDbConfig                = $archiveConfigVar;
		$AcrInvoiceDetail->schemaName                 = $archiveDatabase;
		
		$AcrInvoicePaymentDetail->useDbConfig         = $archiveConfigVar;
		$AcrInvoicePaymentDetail->schemaName          = $archiveDatabase;
		
		$AcrClientRecurringInvoice->useDbConfig       = $archiveConfigVar;
		$AcrClientRecurringInvoice->schemaName        = $archiveDatabase;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $archiveConfigVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName  = $archiveDatabase;
		
		$SbsSubscriberPaymentTerm->useDbConfig        = $archiveConfigVar;
		$SbsSubscriberPaymentTerm->schemaName         = $archiveDatabase;
		
        $AcrClientCreditnote->useDbConfig             = $archiveConfigVar;
        $AcrClientCreditnote->schemaName              = $archiveDatabase;
        
        $AcrCreditnotePaymentMapping->useDbConfig     = $archiveConfigVar;
        $AcrCreditnotePaymentMapping->schemaName      = $archiveDatabase;
        
        $AcrClientCreditnoteProduct->useDbConfig      = $archiveConfigVar;
        $AcrClientCreditnoteProduct->schemaName       = $archiveDatabase;
        
        $SbsEmailTemplateDetail->useDbConfig          = $archiveConfigVar;
        $SbsEmailTemplateDetail->schemaName           = $archiveDatabase;
        
        /*$InvInventoryCustomValue->useDbConfig         = $archiveConfigVar;
        $InvInventoryCustomValue->schemaName          = $archiveDatabase;*/
        
        $SbsSubscriber->useDbConfig                   = $archiveConfigVar;
        $SbsSubscriber->schemaName                    = $archiveDatabase;
        
        $SbsSubscriberOrganizationDetail->useDbConfig = $archiveConfigVar;
        $SbsSubscriberOrganizationDetail->schemaName  = $archiveDatabase;
        
        $SbsAgingBucket->useDbConfig                  = $archiveConfigVar;
        $SbsAgingBucket->schemaName                   = $archiveDatabase;
        
        $SbsSubscriberSetting->useDbConfig            = $archiveConfigVar;
        $SbsSubscriberSetting->schemaName             = $archiveDatabase;
        
        $SbsDowngradeRequest->useDbConfig             = $archiveConfigVar;
        $SbsDowngradeRequest->schemaName              = $archiveDatabase;
        
        $SbsPaymentMethodValue->useDbConfig           = $archiveConfigVar;
        $SbsPaymentMethodValue->schemaName            = $archiveDatabase;
        
        $SbsPaymentMethod->useDbConfig                = $archiveConfigVar;
        $SbsPaymentMethod->schemaName                 = $archiveDatabase;
		/*Connecting Database*/
		
		/*Delete All the archived records from cantorix database*/
		$SlsQuotationCustomValue->deleteAll(array('SlsQuotationCustomValue.acr_invoice_custom_field_id' => $invoiceCustomFieldIds), FALSE);
		$SlsQuotationProduct->deleteAll(array('SlsQuotationProduct.sls_quotation_id' => $quotationIds), FALSE);
		$SlsQuotation->deleteAll(array('SlsQuotation.sbs_subscriber_id' => $subscriberId), FALSE);
		
        
        /*Expense Deletions*/
        $AcpInventoryExpense->recursive = -1;
        $AcrInventoryInvoice->deleteAll(array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds),FALSE);
        $AcpInventoryExpense->deleteAll(array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcpExpenseCustomFieldValue->deleteAll(array('AcpExpenseCustomFieldValue.acp_expense_custom_field_id' => $expenseCustomFieldIds),FALSE);
        $AcpExpenseCustomField->deleteAll(array('AcpExpenseCustomField.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcpExpense->deleteAll(array('AcpExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcpExpenseCategory->deleteAll(array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcpVendor->deleteAll(array('AcpVendor.sbs_subscriber_id'=>$subscriberId),FALSE);
        /*Expense Deletions*/
        
		/*Invoice related Deletions*/
		$AcrCreditnotePaymentMapping->deleteAll(array('AcrCreditnotePaymentMapping.sbs_subscriber_id'=>$subscriberId), FALSE);
        $AcrClientCreditnoteProduct->deleteAll(array('AcrClientCreditnoteProduct.acr_client_creditnote_id'=>$creditNotesIds),FALSE);
        $AcrClientCreditnote->deleteAll(array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId),FALSE);
		$AcrInvoicePaymentDetail->deleteAll(array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientRecurringInvoice->deleteAll(array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceDetail->deleteAll(array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceCustomValue->deleteAll(array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds), FALSE);
		$AcrInvoiceCustomField->deleteAll(array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientInvoice->deleteAll(array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Invoice related Deletions*/
		
		
		
		
		/*Client related Deletions*/
		$AcrClientCustomValue->deleteAll(array('AcrClientCustomValue.acr_client_id'=>$clientIds),FALSE);
		$AcrClientCustomField->deleteAll(array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientContact->deleteAll(array('AcrClientContact.sbs_subscriber_id'=>$subscriberId), FALSE);
		$this->deleteAll(array('AcrClient.sbs_subscriber_id' => $subscriberId),FALSE);
		/*Client related Deletions*/
		
		/*inventory Deletion*/
		  $InvInventoryCustomValue->deleteAll(array('InvInventoryCustomValue.inv_inventory_id'=>$inventoryIds),FALSE);        
        $InvInventory->deleteAll(array('InvInventory.sbs_subscriber_id'=>$subscriberId),FALSE);
        $InvInventoryCustomField->deleteAll(array('InvInventoryCustomField.sbs_subscriber_id'=>$subscriberId),FALSE);
        $InvInventoryUnitType->deleteAll(array('InvInventoryUnitType.sbs_subscriber_id'=>$subscriberId),FALSE);
        /*End Inventory Deletion*/  
		
		/*Currency mapping Deletion*/
		$SbsSubscriberCpnCurrencyMapping->deleteAll(array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Currency mapping Deletion*/
		
		/*Payment Terms Deletion*/
		$SbsSubscriberPaymentTerm->deleteAll(array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Payment Terms Deletion*/
		
		/*Email template details*/
        $SbsEmailTemplateDetail->deleteAll(array('SbsEmailTemplateDetail.sbs_subscriber_id'=>$subscriberId),FALSE);
        /*End Email template details*/
		
		/*Tax related deletions*/
		$SbsSubscriberTaxGroupMapping->deleteAll(array('SbsSubscriberTaxGroupMapping.sbs_subscriber_tax_id'=>$taxIds), FALSE);
		$SbsSubscriberTaxGroup->deleteAll(array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId),FALSE);
		$SbsSubscriberTax->deleteAll(array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*Tax related deletions*/
		
		$SbsAgingBucket->deleteAll(array('SbsAgingBucket.sbs_subscriber_id' => $subscriberId), FALSE);
        
        $SbsDowngradeRequest->deleteAll(array('SbsDowngradeRequest.sbs_subscriber_id' => $subscriberId), false);
        
        $SbsPaymentMethod->deleteAll(array('SbsPaymentMethod.subscriber_id'=>$subscriberId), FALSE);
        $SbsPaymentMethodValue->deleteAll(array('SbsPaymentMethodValue.subscriber_id'=>$subscriberId), FALSE);
        $SbsSubscriberSetting->deleteAll(array('SbsSubscriberSetting.sbs_subscriber_id' => $subscriberId), false);
        $subscriber                 = $SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$subscriberId)));
        $SbsSubscriber->delete($subscriberId);
        $SbsSubscriberOrganizationDetail->deleteAll(array('SbsSubscriberOrganizationDetail.id'=>$subscriber['SbsSubscriber']['sbs_subscriber_organization_detail_id']));  
		/*End Delete All the archived records from cantorix database*/
		
		
		/*Disconnect Archive database & Start default(cantorix) connection*/
        $this->useDbConfig                            = $defaultConfigVar;
        $this->schemaName                             = $defaultDatabase;
        
        $AcrClientContact->useDbConfig                = $defaultConfigVar;
        $AcrClientContact->schemaName                 = $defaultDatabase;
        
        $AcrClientCustomField->useDbConfig            = $defaultConfigVar;
        $AcrClientCustomField->schemaName             = $defaultDatabase;
        
        $AcrClientCustomValue->useDbConfig            = $defaultConfigVar;
        $AcrClientCustomValue->schemaName             = $defaultDatabase;
        
        $InvInventory->useDbConfig                    = $defaultConfigVar;
        $InvInventory->schemaName                     = $defaultDatabase;
        
        $InvInventoryUnitType->useDbConfig            = $defaultConfigVar;
        $InvInventoryUnitType->schemaName             = $defaultDatabase;
        
        $InvInventoryCustomField->useDbConfig         = $defaultConfigVar;
        $InvInventoryCustomField->schemaName          = $defaultDatabase;
        
        $InvInventoryCustomValue->useDbConfig         = $defaultConfigVar;
        $InvInventoryCustomValue->schemaName          = $defaultDatabase;
        
        
        $AcpVendor->useDbConfig                       = $defaultConfigVar;
        $AcpVendor->schemaName                        = $defaultDatabase;
        
        $AcpExpenseCategory->useDbConfig              = $defaultConfigVar;
        $AcpExpenseCategory->schemaName               = $defaultDatabase;
        
        $AcpExpense->useDbConfig                      = $defaultConfigVar;
        $AcpExpense->schemaName                       = $defaultDatabase;
        
        $AcpInventoryExpense->useDbConfig             = $defaultConfigVar;
        $AcpInventoryExpense->schemaName              = $defaultDatabase;
        
        $AcpExpenseCustomField->useDbConfig           = $defaultConfigVar;
        $AcpExpenseCustomField->schemaName            = $defaultDatabase;
        
        $AcpExpenseCustomFieldValue->useDbConfig      = $defaultConfigVar;
        $AcpExpenseCustomFieldValue->schemaName       = $defaultDatabase;
        
        $AcrInventoryInvoice->useDbConfig             = $defaultConfigVar;
        $AcrInventoryInvoice->schemaName              = $defaultDatabase;
        
        $SbsSubscriberTax->useDbConfig                = $defaultConfigVar;
        $SbsSubscriberTax->schemaName                 = $defaultDatabase;
        
        $SbsSubscriberTaxGroup->useDbConfig           = $defaultConfigVar;
        $SbsSubscriberTaxGroup->schemaName            = $defaultDatabase;
        
        $SbsSubscriberTaxGroupMapping->useDbConfig    = $defaultConfigVar;
        $SbsSubscriberTaxGroupMapping->schemaName     = $defaultDatabase;
        
        $SlsQuotation->useDbConfig                    = $defaultConfigVar;
        $SlsQuotation->schemaName                     = $defaultDatabase;
        
        $SlsQuotationProduct->useDbConfig             = $defaultConfigVar;
        $SlsQuotationProduct->schemaName              = $defaultDatabase;
        
        $SlsQuotationCustomField->useDbConfig         = $defaultConfigVar;
        $SlsQuotationCustomField->schemaName          = $defaultDatabase;
        
        $SlsQuotationCustomValue->useDbConfig         = $defaultConfigVar;
        $SlsQuotationCustomValue->schemaName          = $defaultDatabase;
        
        $AcrClientInvoice->useDbConfig                = $defaultConfigVar;
        $AcrClientInvoice->schemaName                 = $defaultDatabase;
        
        $AcrInvoiceCustomField->useDbConfig           = $defaultConfigVar;
        $AcrInvoiceCustomField->schemaName            = $defaultDatabase;
        
        $AcrInvoiceCustomValue->useDbConfig           = $defaultConfigVar;
        $AcrInvoiceCustomValue->schemaName            = $defaultDatabase;
        
        $AcrInvoiceDetail->useDbConfig                = $defaultConfigVar;
        $AcrInvoiceDetail->schemaName                 = $defaultDatabase;
        
        $AcrInvoicePaymentDetail->useDbConfig         = $defaultConfigVar;
        $AcrInvoicePaymentDetail->schemaName          = $defaultDatabase;
        
        $AcrClientRecurringInvoice->useDbConfig       = $defaultConfigVar;
        $AcrClientRecurringInvoice->schemaName        = $defaultDatabase;
        
        $SbsSubscriberCpnCurrencyMapping->useDbConfig = $defaultConfigVar;
        $SbsSubscriberCpnCurrencyMapping->schemaName  = $defaultDatabase;
        
        $SbsSubscriberPaymentTerm->useDbConfig        = $defaultConfigVar;
        $SbsSubscriberPaymentTerm->schemaName         = $defaultDatabase;
        
        $AcrClientCreditnote->useDbConfig             = $defaultConfigVar;
        $AcrClientCreditnote->schemaName              = $defaultDatabase;
        
        $AcrCreditnotePaymentMapping->useDbConfig     = $defaultConfigVar;
        $AcrCreditnotePaymentMapping->schemaName      = $defaultDatabase;
        
        $AcrClientCreditnoteProduct->useDbConfig      = $defaultConfigVar;
        $AcrClientCreditnoteProduct->schemaName       = $defaultDatabase;
        
        $SbsAgingBucket->useDbConfig                  = $defaultConfigVar;
        $SbsAgingBucket->schemaName                   = $defaultDatabase;
        
        $SbsEmailTemplateDetail->useDbConfig          = $defaultConfigVar;
        $SbsEmailTemplateDetail->schemaName           = $defaultDatabase;
        
        $SbsDowngradeRequest->useDbConfig             = $defaultConfigVar;
        $SbsDowngradeRequest->schemaName              = $defaultDatabase;
        
        $SbsPaymentMethodValue->useDbConfig           = $defaultConfigVar;
        $SbsPaymentMethodValue->schemaName            = $defaultDatabase;
        
        $SbsPaymentMethod->useDbConfig                = $defaultConfigVar;
        $SbsPaymentMethod->schemaName                 = $defaultDatabase;
        
        $SbsSubscriber->useDbConfig                   = $defaultConfigVar;
        $SbsSubscriber->schemaName                    = $defaultDatabase;
        /*End Disconnect Archive database  & Start default(cantorix) connection*/
		
		
		
		
		debug('completed!');
		return TRUE;
	}
	
	
	public function deleteSubscriber($subscriberId = NULL,$connection = NULL) {
		//Configure::write('debug',2);
        debug('123455667');
  		/*Loading all required models*/
		$AcrClientContact                 = ClassRegistry::init('AcrClientContact');
		$AcrClientCustomField             = ClassRegistry::init('AcrClientCustomField');
		$AcrClientCustomValue             = ClassRegistry::init('AcrClientCustomValue');
		$InvInventory                     = ClassRegistry::init('InvInventory');
		$AcpExpenseCategory               = ClassRegistry::init('AcpExpenseCategory');
		$AcpExpense                       = ClassRegistry::init('AcpExpense');
		$AcpInventoryExpense              = ClassRegistry::init('AcpInventoryExpense');
		$AcrInventoryInvoice              = ClassRegistry::init('AcrInventoryInvoice');
		$SbsSubscriberTax                 = ClassRegistry::init('SbsSubscriberTax');
		$SbsSubscriberTaxGroup            = ClassRegistry::init('SbsSubscriberTaxGroup');
		$SbsSubscriberTaxGroupMapping     = ClassRegistry::init('SbsSubscriberTaxGroupMapping');
		$SlsQuotation                     = ClassRegistry::init('SlsQuotation');
		$SlsQuotationProduct              = ClassRegistry::init('SlsQuotationProduct');
		$SlsQuotationCustomField          = ClassRegistry::init('SlsQuotationCustomField');
		$SlsQuotationCustomValue          = ClassRegistry::init('SlsQuotationCustomValue');
		$AcrClientInvoice                 = ClassRegistry::init('AcrClientInvoice');
		$AcrInvoiceCustomField            = ClassRegistry::init('AcrInvoiceCustomField');
		$AcrInvoiceCustomValue            = ClassRegistry::init('AcrInvoiceCustomValue');
		$AcrInvoicePaymentDetail          = ClassRegistry::init('AcrInvoicePaymentDetail');
		$AcrInvoiceDetail                 = ClassRegistry::init('AcrInvoiceDetail');
		$AcrClientRecurringInvoice        = ClassRegistry::init('AcrClientRecurringInvoice');
		$SbsSubscriberCpnCurrencyMapping  = ClassRegistry::init('SbsSubscriberCpnCurrencyMapping');
		$SbsSubscriberPaymentTerm         = ClassRegistry::init('SbsSubscriberPaymentTerm');
		$SbsSubscriber                    = ClassRegistry::init('SbsSubscriber');
		$SbsSubscriberOrganizationDetail  = ClassRegistry::init('SbsSubscriberOrganizationDetail');
        $AcpExpenseCustomField            = ClassRegistry::init('AcpExpenseCustomField');
        $AcpExpenseCustomFieldValue       = ClassRegistry::init('AcpExpenseCustomFieldValue');
        $AcpVendor                        = ClassRegistry::init('AcpVendor');
        $InvInventoryCustomField          = ClassRegistry::init('InvInventoryCustomField');
        $InvInventoryCustomValue          = ClassRegistry::init('InvInventoryCustomValue');
        $InvInventoryUnitType             = ClassRegistry::init('InvInventoryUnitType');
        $SbsAgingBucket                   = ClassRegistry::init('SbsAgingBucket');
        $SbsEmailTemplateDetail           = ClassRegistry::init('SbsEmailTemplateDetail');
        $AcrClientCreditnote              = ClassRegistry::init('AcrClientCreditnote');
        $AcrClientCreditnoteProduct       = ClassRegistry::init('AcrClientCreditnoteProduct');
        $AcrCreditnotePaymentMapping      = ClassRegistry::init('AcrCreditnotePaymentMapping');
        $SbsDowngradeRequest              = ClassRegistry::init('SbsDowngradeRequest');
        $SbsPaymentMethodValue            = ClassRegistry::init('SbsPaymentMethodValue');
        $SbsSubscriberSetting             = ClassRegistry::init('SbsSubscriberSetting');
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
		$this->useDbConfig                            = $configVar;
		$this->schemaName                             = $database;
		
		$AcrClientContact->useDbConfig                = $configVar;
		$AcrClientContact->schemaName                 = $database;
		
		$AcrClientCustomField->useDbConfig            = $configVar;
		$AcrClientCustomField->schemaName             = $database;
		
		$AcrClientCustomValue->useDbConfig            = $configVar;
		$AcrClientCustomValue->schemaName             = $database;
		
		$InvInventory->useDbConfig                    = $configVar;
		$InvInventory->schemaName                     = $database;
		
		$AcpExpenseCategory->useDbConfig              = $configVar;
		$AcpExpenseCategory->schemaName               = $database;
		
		$AcpExpense->useDbConfig                      = $configVar;
		$AcpExpense->schemaName                       = $database;
		
		$AcpInventoryExpense->useDbConfig             = $configVar;
		$AcpInventoryExpense->schemaName              = $database;
		
		$AcrInventoryInvoice->useDbConfig             = $configVar;
		$AcrInventoryInvoice->schemaName              = $database;
		
		$SbsSubscriberTax->useDbConfig                = $configVar;
		$SbsSubscriberTax->schemaName                 = $database;
		
		$SbsSubscriberTaxGroup->useDbConfig           = $configVar;
		$SbsSubscriberTaxGroup->schemaName            = $database;
		
		$SbsSubscriberTaxGroupMapping->useDbConfig    = $configVar;
		$SbsSubscriberTaxGroupMapping->schemaName     = $database;
		
		$SlsQuotation->useDbConfig                    = $configVar;
		$SlsQuotation->schemaName                     = $database;
		
		$SlsQuotationProduct->useDbConfig             = $configVar;
		$SlsQuotationProduct->schemaName              = $database;
		
		$SlsQuotationCustomValue->useDbConfig         = $configVar;
		$SlsQuotationCustomValue->schemaName          = $database;
		
		$AcrClientInvoice->useDbConfig                = $configVar;
		$AcrClientInvoice->schemaName                 = $database;
		
		$AcrInvoiceCustomField->useDbConfig           = $configVar;
		$AcrInvoiceCustomField->schemaName            = $database;
		
		$AcrInvoiceCustomValue->useDbConfig           = $configVar;
		$AcrInvoiceCustomValue->schemaName            = $database;
		
		$AcrInvoiceDetail->useDbConfig                = $configVar;
		$AcrInvoiceDetail->schemaName                 = $database;
		
		$AcrInvoicePaymentDetail->useDbConfig         = $configVar;
		$AcrInvoicePaymentDetail->schemaName          = $database;
		
		$AcrClientRecurringInvoice->useDbConfig       = $configVar;
		$AcrClientRecurringInvoice->schemaName        = $database;
		
		$SbsSubscriber->useDbConfig                   = $configVar;
		$SbsSubscriber->schemaName                    = $database;
		
		$SbsSubscriberPaymentTerm->useDbConfig        = $configVar;
		$SbsSubscriberPaymentTerm->schemaName         = $database;
		
		$SbsSubscriberCpnCurrencyMapping->useDbConfig = $configVar;
		$SbsSubscriberCpnCurrencyMapping->schemaName  = $database;
		
        //Latest
        $AcpExpenseCustomField->useDbConfig           = $configVar;
        $AcpExpenseCustomField->schemaName            = $database;
        
        $AcpExpenseCustomFieldValue->useDbConfig      = $configVar;
        $AcpExpenseCustomFieldValue->schemaName       = $database;
        
        $AcpVendor->useDbConfig                       = $configVar;
        $AcpVendor->schemaName                        = $database;
        
        $InvInventoryCustomField->useDbConfig         = $configVar;
        $InvInventoryCustomField->schemaName          = $database;
        
        $InvInventoryCustomValue->useDbConfig         = $configVar;
        $InvInventoryCustomValue->schemaName          = $database;
        
        $InvInventoryUnitType->useDbConfig            = $configVar;
        $InvInventoryUnitType->schemaName             = $database;
        
        $SbsAgingBucket->useDbConfig                  = $configVar;
        $SbsAgingBucket->schemaName                   = $database;
        
        $SbsEmailTemplateDetail->useDbConfig          = $configVar;
        $SbsEmailTemplateDetail->schemaName           = $database;
        
        $AcrClientCreditnote->useDbConfig             = $configVar;
        $AcrClientCreditnote->schemaName              = $database;
        
        $AcrClientCreditnoteProduct->useDbConfig      = $configVar;
        $AcrClientCreditnoteProduct->schemaName       = $database;
        
        $AcrCreditnotePaymentMapping->useDbConfig     = $configVar;
        $AcrCreditnotePaymentMapping->schemaName      = $database;
        
        $SbsDowngradeRequest->useDbConfig             = $configVar;
        $SbsDowngradeRequest->schemaName              = $database;
        
        $SbsPaymentMethodValue->useDbConfig           = $configVar;
        $SbsPaymentMethodValue->schemaName            = $database;
        
        $SbsSubscriberOrganizationDetail->useDbConfig = $configVar;
        $SbsSubscriberOrganizationDetail->schemaName  = $database;
        
        $SbsSubscriberSetting->useDbConfig            = $configVar;
        $SbsSubscriberSetting->schemaName             = $database;
        
		/*Connecting Database*/
		
		
		/* Get all required data from database tables*/
		$subscriber                 = $SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$subscriberId)));
        debug($subscriber);
		$clientIds                  = $this->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id' => $subscriberId)));
        $quotationCustomFieldIds    = $SlsQuotationCustomField->find('list',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotationCustomField.id','SlsQuotationCustomField.id')));
        $quotationIds               = $SlsQuotation->find('list',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SlsQuotation.id')));
        $clientInvoiceIds           = $AcrClientInvoice->find('list',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClientInvoice.id','AcrClientInvoice.id')));
        $invoiceCustomFieldIds      = $AcrInvoiceCustomField->find('list',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoiceCustomField.id','AcrInvoiceCustomField.id')));
        $AcpExpenseCustomFieldIds   = $AcpExpenseCustomField->find('list',array('conditions'=>array('AcpExpenseCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('id','id')));
        $inventoryExpenseIds        = $AcpInventoryExpense->find('list',array('conditions'=>array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcpInventoryExpense.id','AcpInventoryExpense.id')));
        $InvInventoryCustomFieldIds = $InvInventoryCustomField->find('list',array('conditions'=>array('InvInventoryCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('id','id')));
        $taxIds                     = $SbsSubscriberTax->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriberId),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.id')));
        $creditNotesIds             = $AcrClientCreditnote->find('list',array('conditions'=>array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClientCreditnote.id','AcrClientCreditnote.id')));
		/* End Get all required data from database tables*/
		
		/*Currency Mappings deletions*/
		$SbsSubscriberCpnCurrencyMapping->deleteAll(array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id' => $subscriberId), FALSE);
		/*Currency Mappings deletions*/
		
		/*Delete All records from cantorix database*/
		
		
		/*Expense Deletions*/
        $AcpInventoryExpense->recursive = -1;
        $AcpExpenseCustomFieldValue->deleteAll(array('AcpExpenseCustomFieldValue.acp_expense_custom_field_id'=>$AcpExpenseCustomFieldIds),FALSE);
        $AcpExpenseCustomField->deleteAll(array('AcpExpenseCustomField.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcrInventoryInvoice->deleteAll(array('AcrInventoryInvoice.acp_inventory_expense_id'=>$inventoryExpenseIds),FALSE);
        $AcpInventoryExpense->deleteAll(array('AcpInventoryExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcpExpense->deleteAll(array('AcpExpense.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcpExpenseCategory->deleteAll(array('AcpExpenseCategory.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcpVendor->deleteAll(array('AcpVendor.sbs_subscriber_id'=>$subscriberId),FALSE);
        /*Expense Deletions*/
        
        
        /*Quotation Deletions*/
        $SlsQuotationCustomValue->deleteAll(array('SlsQuotationCustomValue.sls_quotation_id'=>$quotationIds), FALSE);   
        $SlsQuotationProduct->deleteAll(array('SlsQuotationProduct.sls_quotation_id'=>$quotationIds), FALSE);
        $SlsQuotation->deleteAll(array('SlsQuotation.sbs_subscriber_id'=>$subscriberId), FALSE);
        /*Quotation Deletions*/
        
        
		
		/*Invoice related Deletions*/
		$AcrCreditnotePaymentMapping->deleteAll(array('AcrCreditnotePaymentMapping.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcrClientCreditnoteProduct->deleteAll(array('AcrClientCreditnoteProduct.acr_client_creditnote_id'=>$creditNotesIds),FALSE);
        $AcrClientCreditnote->deleteAll(array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId),FALSE);
        $AcrInvoicePaymentDetail->deleteAll(array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientRecurringInvoice->deleteAll(array('AcrClientRecurringInvoice.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceDetail->deleteAll(array('AcrInvoiceDetail.acr_client_invoice_id'=>$clientInvoiceIds), FALSE);
		$AcrInvoiceCustomValue->deleteAll(array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$invoiceCustomFieldIds), FALSE);
		$AcrInvoiceCustomField->deleteAll(array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientInvoice->deleteAll(array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId), FALSE);
		/*Invoice related Deletions*/
		
		
		/*Inventory deletions*/
		$InvInventoryCustomValue->deleteAll(array('InvInventoryCustomValue.inv_inventory_custom_field_id'=>$InvInventoryCustomFieldIds),FALSE);
		$InvInventoryCustomField->deleteAll(array('InvInventoryCustomField.sbs_subscriber_id'=>$subscriberId),FALSE);
		$InvInventory->deleteAll(array('InvInventory.sbs_subscriber_id'=>$subscriberId),FALSE);
        $InvInventoryUnitType->deleteAll(array('InvInventoryUnitType.sbs_subscriber_id'=>$subscriberId),FALSE);
		/*Inventory deletions*/
		
		/*Client related Deletions*/
		$AcrClientCustomValue->deleteAll(array('AcrClientCustomValue.acr_client_id'=>$clientIds),FALSE);
		$AcrClientCustomField->deleteAll(array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId), FALSE);
		$AcrClientContact->deleteAll(array('AcrClientContact.sbs_subscriber_id'=>$subscriberId), FALSE);
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
		
		
		
		
		$SbsAgingBucket->deleteAll(array('SbsAgingBucket.sbs_subscriber_id' => $subscriberId), FALSE);
        $SbsEmailTemplateDetail->deleteAll(array('SbsEmailTemplateDetail.sbs_subscriber_id' => $subscriberId), FALSE);
        $SbsDowngradeRequest->deleteAll(array('SbsDowngradeRequest.sbs_subscriber_id' => $subscriberId), false);
        $SbsSubscriberSetting->deleteAll(array('SbsSubscriberSetting.sbs_subscriber_id' => $subscriberId), false);
        $SbsSubscriber->delete($subscriberId);
        $organization = $SbsSubscriberOrganizationDetail->find('first',array('conditions'=>array('SbsSubscriberOrganizationDetail.id'=>$subscriber['SbsSubscriber']['sbs_subscriber_organization_detail_id'])));
        $SbsSubscriberOrganizationDetail->delete($organization['SbsSubscriberOrganizationDetail']['id']);    
        /*End Delete All records from cantorix database*/
        
        debug('Deletion Completed!');
		return TRUE;
		
  	}
	

/******@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ DONT DELETE/CHANGE ANY CODE ABOVE WITHOUT INTIMATION @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@******/



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
   		$customerList = $this->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$subscriberId,'AcrClient.status'=>'Active'),'fields'=>array('AcrClient.id','AcrClient.organization_name'),'order'=>array('AcrClient.organization_name ASC')));
   		return $customerList;
   	}
   }
   
   public function getClientCurrency($clientId = null){
   	$clientCurrency = $this->find('first',array('conditions'=>array('AcrClient.id'=>$clientId),'fields'=>array('AcrClient.id','AcrClient.cpn_currency_id')));
   return $clientCurrency;
   }
   
   /**
    * @method Get active customers for a subscribers
    * @author Ganesh R
    * */
	public function getActiveCustomerList($subscriberId = NULL) {
		if($subscriberId){
			return $this->find('list',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$subscriberId,'AcrClient.status'=>'Active'),'fields'=>array('AcrClient.id','AcrClient.organization_name'),'order'=>array('AcrClient.organization_name'=>'Asc')));
		}
  	}
   
   public function importClient($subscriberId,$clientInformation,$languageId,$currencyId,$paymentTermId){
   	
   		if($subscriberId && $clientInformation){
   			$clientExist = $this->clientCheck($clientInformation['Client Name *'],$clientInformation['Organization Name *'],$clientInformation['City'],$clientInformation['State/Province'],$clientInformation['Country'],$clientInformation['Postal Code'],$subscriberId);
   			/*
			   if(!$clientInformation['Client Name']){
									  $arraySave['failure'] = '1';
									  $arraySave['error'] = "Client Name Missing";
									  return $arraySave;
							  }*/
			   if(!$clientInformation['Organization Name *']){
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
		   			$saveArray->data['AcrClient']['organization_name'] 				= $clientInformation['Organization Name *'];
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
   		$getClient = $this->find('first',array('conditions'=>array('AcrClient.organization_name LIKE'=>$organisationName,'AcrClient.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClient.id')));
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
   
   public function checkPaymentTermBySubscriber($subscriber=null,$payment_term=null){
   	  $subscriber_payment_term_exist = $this->find('first',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$subscriber,'AcrClient.sbs_subscriber_payment_term_id'=>$payment_term),'fields'=>array('AcrClient.id')));
      if($subscriber_payment_term_exist){
      	  return $subscriber_payment_term_exist;
      }else{
      	  return false;
      }
   }
}
