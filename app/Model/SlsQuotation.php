<?php
App::uses('AppModel', 'Model');
/**
 * SlsQuotation Model
 *
 * @property AcrClient $AcrClient
 * @property SbsSubscriber $SbsSubscriber
 * @property SlsQuotationCustomValue $SlsQuotationCustomValue
 * @property SlsQuotationProduct $SlsQuotationProduct
 */
class SlsQuotation extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'AcrClient' => array(
			'className' => 'AcrClient',
			'foreignKey' => 'acr_client_id',
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
		'SlsQuotationCustomValue' => array(
			'className' => 'SlsQuotationCustomValue',
			'foreignKey' => 'sls_quotation_id',
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
		'SlsQuotationProduct' => array(
			'className' => 'SlsQuotationProduct',
			'foreignKey' => 'sls_quotation_id',
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
	
/**
 * @method Get total number of quotes for a subscriber
 * @author Ganesh R
 * @param  Subscriber ID
 * @return Count of quotes
 * @version 1.1
 * @since   7 Aug 2014
* */
	public function getTotalQuotes($subscriberId = null) {
		if($subscriberId) {
			return $this->find('count',array('conditions'=>array('SlsQuotation.sbs_subscriber_id'=>$subscriberId)));
		} else {
			return 0;
		}
	}

/**
 * @method  Add New Quote
 * @author  Ganesh R
 * @param   Subscriber ID, Form data
 * @return  True/False
 * @version 1.1
 * @since   7 Aug 2014
 * */	
	public function addQuote($subsID = NULL, $data = NULL){
		$taxTotal = 0;
		foreach($data['AcrClientInvoice']['taxValue'] as $taxId=>$taxVal){
			$taxTotal = $taxTotal + $taxVal;
		}
		$save = NULL;
		$save['SlsQuotation']['quotation_no'] 			= $data['AcrClientInvoice']['quote_no'];
		$save['SlsQuotation']['exchange_rate'] 			= $data['AcrClientInvoice']['conversionValue'];
		$save['SlsQuotation']['description'] 			= $data['AcrClientInvoice']['quote_description'];
		$save['SlsQuotation']['issue_date'] 			= date('Y-m-d',strtotime(str_replace('/', '-', $data['AcrClientInvoice']['issueDate'])));
		$save['SlsQuotation']['purchase_order_no'] 		= $data['AcrClientInvoice']['purchase_order_no'];
		if(!empty($data['AcrClientInvoice']['expiryDate'])) { 
		$save['SlsQuotation']['expiry_date'] 		    = date('Y-m-d',strtotime(str_replace('/','-',$data['AcrClientInvoice']['expiryDate'])));
		}
		$save['SlsQuotation']['status'] 				= $data['quotation_status'];
		$save['SlsQuotation']['notes'] 					= $data['AcrClientInvoice']['notes'];
		$save['SlsQuotation']['term_conditions'] 		= $data['AcrClientInvoice']['terms'];
		$save['SlsQuotation']['sub_total'] 				= $data['AcrClientInvoice']['subTotal'];
		$save['SlsQuotation']['tax_total'] 				= $taxTotal;
		$save['SlsQuotation']['func_estimate_total'] 	= $data['AcrClientInvoice']['subTotal'] + $taxTotal;
		$save['SlsQuotation']['acr_client_id'] 			= $data['AcrClientInvoice']['acr_client_id'];
		$save['SlsQuotation']['sbs_subscriber_id'] 		= $subsID;
		$save['SlsQuotation']['invoice_amount'] 		= $data['AcrClientInvoice']['invoicetotal'];
		$save['SlsQuotation']['invoice_currency_code'] 	= $data['AcrClientInvoice']['invoice_currency_code'];
		$this->create();
		if($this->save($save)) {
			$SlsQuotationProduct = ClassRegistry::init('SlsQuotationProduct');
			$quotationId = $this->getLastInsertID();
			foreach ($data['AcrClientInvoice']['inventory'] as $index => $value) {
				if($value) {
					if(empty($data['AcrClientInvoice']['quantity'][$index])) {
						$data['AcrClientInvoice']['quantity'][$index] = 0;
					}
					if(empty($data['AcrClientInvoice']['unit_rate'][$index])) {
						$data['AcrClientInvoice']['unit_rate'][$index] = 0;
					}
					if(empty($data['AcrClientInvoice']['line_total_hidden'][$index])) {
						$data['AcrClientInvoice']['line_total_hidden'][$index] = 0;
					}
					$saveInventoryDetails['SlsQuotationProduct']['inv_inventory_id'] 	  = $value;
					$saveInventoryDetails['SlsQuotationProduct']['inventory_description'] = $data['AcrClientInvoice']['description'][$index];
					$saveInventoryDetails['SlsQuotationProduct']['quantity'] 			  = $data['AcrClientInvoice']['quantity'][$index];
					$saveInventoryDetails['SlsQuotationProduct']['unit_rate'] 			  = $data['AcrClientInvoice']['unit_rate'][$index];
					$saveInventoryDetails['SlsQuotationProduct']['discount_percent'] 	  = $data['AcrClientInvoice']['discount_percent'][$index];
					$saveInventoryDetails['SlsQuotationProduct']['line_total']            = $data['AcrClientInvoice']['line_total_hidden'][$index];
					$saveInventoryDetails['SlsQuotationProduct']['sls_quotation_id']      = $quotationId;
					$taxes = $data['AcrClientInvoice']['tax_inventory'][$index];
					$explodeTax = explode('-', $taxes);
					if($explodeTax[1]) {
						$saveInventoryDetails['SlsQuotationProduct']['sbs_subscriber_tax_group_id'] = $explodeTax[1];
					}
					if(empty($explodeTax[1])) {
						$saveInventoryDetails['SlsQuotationProduct']['sbs_subscriber_tax_id'] = $data['AcrClientInvoice']['tax_inventory'][$index]; 
					}
					$SlsQuotationProduct->create();
					$SlsQuotationProduct->save($saveInventoryDetails);
				}
			}
			
			$SlsQuotationCustomValue = ClassRegistry::init('SlsQuotationCustomValue');
			foreach ($data['AcrClientInvoice']['custom_field'] as $customFieldID => $customValue) {
				if($customValue) {
					$saveCustomValue['SlsQuotationCustomValue']['acr_invoice_custom_field_id'] = $customFieldID;
					$saveCustomValue['SlsQuotationCustomValue']['data'] = $customValue;
					$saveCustomValue['SlsQuotationCustomValue']['sls_quotation_id'] = $quotationId;
					$SlsQuotationCustomValue->create();
					$SlsQuotationCustomValue->save($saveCustomValue);
				}
			}
			
			return $quotationId;
		} else {
			return FALSE;
		}
	}




/**
 * @method  Update Quote
 * @author  Ganesh R
 * @param   Subscriber ID, Form data, quotation id
 * @return  True/False
 * @version 1.1
 * @since   7 Aug 2014
 * */	
	public function updateQuote($subsID = NULL, $data = NULL,$quotationId = NULL) {
		foreach ($data['AcrClientInvoice']['taxValue'] as $taxIndex => $taxValue) {
			$taxTotal += $taxValue;
		}
		$save = NULL;
		$save['SlsQuotation']['id'] 					= $data['AcrClientInvoice']['id'];
		$save['SlsQuotation']['quotation_no'] 			= $data['AcrClientInvoice']['quote_no'];
		$save['SlsQuotation']['exchange_rate'] 			= $data['AcrClientInvoice']['conversionValue'];
		$save['SlsQuotation']['description'] 			= $data['AcrClientInvoice']['quote_description'];
		$save['SlsQuotation']['issue_date'] 			= date('Y-m-d',strtotime(str_replace('/', '-',$data['AcrClientInvoice']['issueDate'])));
		$save['SlsQuotation']['purchase_order_no'] 		= $data['AcrClientInvoice']['purchase_order_no'];
		if(!empty($data['AcrClientInvoice']['expiryDate'])) { 
		$save['SlsQuotation']['expiry_date'] 		    = date('Y-m-d',strtotime(str_replace('/', '-', $data['AcrClientInvoice']['expiryDate'])));
		}
		$save['SlsQuotation']['status'] 				= $data['quotation_status'];
		$save['SlsQuotation']['notes'] 					= $data['AcrClientInvoice']['notes'];
		$save['SlsQuotation']['term_conditions'] 		= $data['AcrClientInvoice']['terms'];
		$save['SlsQuotation']['sub_total'] 				= $data['AcrClientInvoice']['subTotal'];
		$save['SlsQuotation']['tax_total'] 				= $taxTotal;
		$save['SlsQuotation']['func_estimate_total'] 	= $data['AcrClientInvoice']['subscribertotalEditQuote'];
		$save['SlsQuotation']['acr_client_id'] 			= $data['AcrClientInvoice']['acr_client_id'];
		$save['SlsQuotation']['sbs_subscriber_id'] 		= $subsID;
		$save['SlsQuotation']['invoice_amount'] 		= $data['AcrClientInvoice']['invoicetotal'];
		$save['SlsQuotation']['invoice_currency_code'] 	= $data['AcrClientInvoice']['invoice_currency_code'];
		if($this->save($save)) {
			$SlsQuotationProduct = ClassRegistry::init('SlsQuotationProduct');
			foreach ($data['AcrClientInvoice']['inventory'] as $index => $value) {
				if($value) {
					$saveInventoryDetails['SlsQuotationProduct']['id'] = NULL;
					if(!empty($data['AcrClientInvoice']['product_id'][$index])) {
						$saveInventoryDetails['SlsQuotationProduct']['id'] 	              = $data['AcrClientInvoice']['product_id'][$index];
					} else {
						$SlsQuotationProduct->create();
					}
					if(empty($data['AcrClientInvoice']['quantity'][$index])) {
						$data['AcrClientInvoice']['quantity'][$index] = 0;
					}
					if(empty($data['AcrClientInvoice']['unit_rate'][$index])) {
						$data['AcrClientInvoice']['unit_rate'][$index] = 0;
					}
					if(empty($data['AcrClientInvoice']['line_total_hidden'][$index])) {
						$data['AcrClientInvoice']['line_total_hidden'][$index] = 0;
					}
					$saveInventoryDetails['SlsQuotationProduct']['inv_inventory_id'] 	  = $value;
					$saveInventoryDetails['SlsQuotationProduct']['inventory_description'] = $data['AcrClientInvoice']['description'][$index];
					$saveInventoryDetails['SlsQuotationProduct']['quantity'] 			  = $data['AcrClientInvoice']['quantity'][$index];
					$saveInventoryDetails['SlsQuotationProduct']['unit_rate'] 			  = $data['AcrClientInvoice']['unit_rate'][$index];
					$saveInventoryDetails['SlsQuotationProduct']['discount_percent'] 	  = $data['AcrClientInvoice']['discount_percent'][$index];
					$saveInventoryDetails['SlsQuotationProduct']['line_total']            = $data['AcrClientInvoice']['line_total_hidden'][$index];
					$saveInventoryDetails['SlsQuotationProduct']['sls_quotation_id']      = $quotationId;
					$taxes = $data['AcrClientInvoice']['tax_inventory'][$index];
					$explodeTax = explode('-', $taxes);
					if($explodeTax[1]) {
						$saveInventoryDetails['SlsQuotationProduct']['sbs_subscriber_tax_group_id'] = $explodeTax[1];
					}
					if(empty($explodeTax[1])) {
						$saveInventoryDetails['SlsQuotationProduct']['sbs_subscriber_tax_id'] = $data['AcrClientInvoice']['tax_inventory'][$index]; 
					}
					$SlsQuotationProduct->save($saveInventoryDetails);
				}
			}
			
			$SlsQuotationCustomValue = ClassRegistry::init('SlsQuotationCustomValue');
			foreach($data['AcrClientInvoice']['custom_field'] as $customFieldID => $customValue) {
				$saveCustomValue['SlsQuotationCustomValue']['id'] = NULL;
				if(!empty($data['AcrClientInvoice']['custom_field_id'][$customFieldID])) {
					$saveCustomValue['SlsQuotationCustomValue']['id'] = $data['AcrClientInvoice']['custom_field_id'][$customFieldID];
				} else {
					$SlsQuotationCustomValue->create();
				}
				$saveCustomValue['SlsQuotationCustomValue']['acr_invoice_custom_field_id'] = $customFieldID;
				$saveCustomValue['SlsQuotationCustomValue']['data'] = $customValue;
				$saveCustomValue['SlsQuotationCustomValue']['sls_quotation_id'] = $quotationId;
				$SlsQuotationCustomValue->save($saveCustomValue);
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	
/**
 * @method getCount of invoices based on currency code
 * @author saurabh
*/

	public function getCountOfQuote($currencyCode,$subscriber){
		$count = $this->find('count',array(conditions=>array('SlsQuotation.sbs_subscriber_id'=>$subscriber,'SlsQuotation.invoice_currency_code'=>$currencyCode)));
		return $count;
	}
/**
 * @method  Convert quote to invoice
 * @author  Ganesh R
 * @param   Subscriber ID, Form data, quotation id
 * @return  True/False
 * @version 1.1
 * @since   7 Aug 2014
 * */	
	public function convertToInvoice($id = NULL) {
		//configure::write('debug',2);
		$this->recursive = 1;
		$this->unbindModel(array('belongsTo'=>array('SbsSubscriber','AcrClient')));
		$quote = $this->findById($id);
		if(!empty($quote)) {
		    $AcrClientInvoice = ClassRegistry::init('AcrClientInvoice');
			$SbsSubscriberPaymentTerm = ClassRegistry::init('SbsSubscriberPaymentTerm');
            $AcrInvoiceCustomValue   = ClassRegistry::init('AcrInvoiceCustomValue');
            $SlsQuotationCustomValue = ClassRegistry::init('SlsQuotationCustomValue');
            $AcrInvoiceDetail = ClassRegistry::init('AcrInvoiceDetail');
            $InvInventory = ClassRegistry::init('InvInventory');
			$paymentTerm = $SbsSubscriberPaymentTerm->getDefaultTerm($quote['SlsQuotation']['sbs_subscriber_id']);
			$enddate = $this->requestAction('/acr_client_invoices/findEndDate/'.date('d M Y').'/'.$paymentTerm['SbsSubscriberPaymentTerm']['id']);
			$invoiceDetail['due_date'] 			= 
			$invoice['AcrClientInvoice']['invoice_number'] 					= $this->requestAction('/app/generateInvoiceNumber/'.$quote['SlsQuotation']['sbs_subscriber_id']);
			$invoice['AcrClientInvoice']['description'] 					= $quote['SlsQuotation']['description'];
			$invoice['AcrClientInvoice']['invoiced_date'] 					= date('Y-m-d');
			$invoice['AcrClientInvoice']['purchase_order_no'] 				= $quote['SlsQuotation']['purchase_order_no'];
			$invoice['AcrClientInvoice']['due_date'] 						= date('Y-m-d',strtotime(str_replace('/', '-',$enddate)));
		//	$invoice['AcrClientInvoice']['discount_percent'] 				= $quote['SlsQuotation'][''];
			$invoice['AcrClientInvoice']['status'] 							= 'Draft';
			$invoice['AcrClientInvoice']['notes'] 							= $quote['SlsQuotation']['notes'];
			$invoice['AcrClientInvoice']['term_conditions'] 				= $quote['SlsQuotation']['term_conditions'];
			$invoice['AcrClientInvoice']['sub_total'] 						= $quote['SlsQuotation']['sub_total'];
			$invoice['AcrClientInvoice']['tax_total'] 						= $quote['SlsQuotation']['tax_total'];
			$invoice['AcrClientInvoice']['func_currency_total'] 			= $quote['SlsQuotation']['func_estimate_total'];
            if(!empty($quote['SlsQuotation']['exchange_rate'])) {
                $invoice['AcrClientInvoice']['exchange_rate']               = $quote['SlsQuotation']['exchange_rate'];    
            } else {
                $invoice['AcrClientInvoice']['exchange_rate']               = 1;
            }
			$invoice['AcrClientInvoice']['recurring'] 						= 'N';
			$invoice['AcrClientInvoice']['pdf_generated'] 					= 'No';
			$invoice['AcrClientInvoice']['acr_client_id'] 					= $quote['SlsQuotation']['acr_client_id'];
			$invoice['AcrClientInvoice']['sbs_subscriber_id'] 				= $quote['SlsQuotation']['sbs_subscriber_id'];
			$invoice['AcrClientInvoice']['sbs_subscriber_payment_term_id'] 	= $paymentTerm['SbsSubscriberPaymentTerm']['id'];
			$invoice['AcrClientInvoice']['invoice_total'] 					= $quote['SlsQuotation']['invoice_amount'];
			$invoice['AcrClientInvoice']['invoice_currency_code'] 			= $quote['SlsQuotation']['invoice_currency_code'];
			$invoice['AcrClientInvoice']['updated_date'] 					= date('Y-m-d');
			$AcrClientInvoice->create();
			if($AcrClientInvoice->save($invoice)) {
				$lastID = $AcrClientInvoice->getLastInsertId();
				foreach ($quote['SlsQuotationProduct'] as $index => $value) {
					$invoiceDetail['AcrInvoiceDetail']['inventory_description'] 		= $value['inventory_description'];
					$invoiceDetail['AcrInvoiceDetail']['quantity'] 						= $value['quantity'];
					$invoiceDetail['AcrInvoiceDetail']['unit_rate'] 					= $value['unit_rate'];
					$invoiceDetail['AcrInvoiceDetail']['discount_percent'] 				= $value['discount_percent'];
					$invoiceDetail['AcrInvoiceDetail']['line_total'] 					= $value['line_total'];
					$invoiceDetail['AcrInvoiceDetail']['acr_client_invoice_id'] 		= $lastID;
					$invoiceDetail['AcrInvoiceDetail']['inv_inventory_id'] 				= $value['inv_inventory_id'];
					$invoiceDetail['AcrInvoiceDetail']['sbs_subscriber_tax_id'] 		= $value['sbs_subscriber_tax_id'];
					$invoiceDetail['AcrInvoiceDetail']['sbs_subscriber_tax_group_id'] 	= $value['sbs_subscriber_tax_group_id'];
					$AcrInvoiceDetail->create();
					if($AcrInvoiceDetail->save($invoiceDetail)) {
						if(!empty($value['inv_inventory_id'])) {
							$InvInventory->updateStock($value['inv_inventory_id'],$value['quantity']);
						}
					}
				}
				$save['SlsQuotation']['id']       					= $quote['SlsQuotation']['id'];
				$save['SlsQuotation']['acr_client_invoice_id']		= $lastID;
				$save['SlsQuotation']['status']   					= 'Invoiced';
				$this->save($save);
				$customFieldsValues = $SlsQuotationCustomValue->find('all',array('conditions'=>array('SlsQuotationCustomValue.sls_quotation_id'=>$id)));
				foreach ($customFieldsValues as $CustomFieldvalue) {
				    debug($lastID);
					$customFields = NULL;
					$customFields['AcrInvoiceCustomValue']['data'] 							= $CustomFieldvalue['SlsQuotationCustomValue']['data'];
					$customFields['AcrInvoiceCustomValue']['acr_client_invoice_id'] 		= $lastID;
					$customFields['AcrInvoiceCustomValue']['acr_invoice_custom_field_id'] 	= $CustomFieldvalue['SlsQuotationCustomValue']['acr_invoice_custom_field_id'];
					$AcrInvoiceCustomValue->create();
					$AcrInvoiceCustomValue->save($customFields);
				}
			}
			return $lastID;
		} else {
			return FALSE;
		}
	}

	public function getQuotationById($quotationId = null){
		$this->recursive = 0;
		$getQuotationDetails = $this->find('first',array('conditions'=>array('SlsQuotation.id'=>$quotationId)));
		return $getQuotationDetails;
	}

}
