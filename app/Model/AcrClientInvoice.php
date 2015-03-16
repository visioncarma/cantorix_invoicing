<?php
App::uses('AppModel', 'Model');
App::import('Component', 'SessionComponent');
/**
 * AcrClientInvoice Model
 *
 * @property AcrClient $AcrClient
 * @property InvInventory $InvInventory
 * @property SbsSubscriber $SbsSubscriber
 * @property AcrClientRecurringInvoice $AcrClientRecurringInvoice
 * @property AcrInvoiceCustomValue $AcrInvoiceCustomValue
 * @property AcrInvoiceDetail $AcrInvoiceDetail
 * @property AcrInvoicePaymentDetail $AcrInvoicePaymentDetail
 */
class AcrClientInvoice extends AppModel {


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
		'SbsSubscriberPaymentTerm' => array(
			'className' => 'SbsSubscriberPaymentTerm',
			'foreignKey' => 'sbs_subscriber_payment_term_id',
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
		'AcrClientRecurringInvoice' => array(
			'className' => 'AcrClientRecurringInvoice',
			'foreignKey' => 'acr_client_invoice_id',
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
		'AcrInvoiceCustomValue' => array(
			'className' => 'AcrInvoiceCustomValue',
			'foreignKey' => 'acr_client_invoice_id',
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
		'AcrInvoiceDetail' => array(
			'className' => 'AcrInvoiceDetail',
			'foreignKey' => 'acr_client_invoice_id',
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
			'foreignKey' => 'acr_client_invoice_id',
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
	
	
	
	public function getInvoiceByClient($clientId=null){
		$clientInvoice=$this->find('first',array('conditions'=>array('AcrClientInvoice.acr_client_id'=>$clientId,'AcrClientInvoice.recurring'=>'N')));
		if(!empty($clientInvoice)){
			$checkInvoice='Exists';
		}else{
			$checkInvoice='NotExists';
		}
		return $checkInvoice;
	}

	public function getInvoiceForInventory($inventoryId = null,$subscriberId= null){
		if($inventoryId){
			$this->recursive = 0;
			$clientInvoice=$this->find('first',array('conditions'=>array('AcrInvoiceDetail.inv_inventory_id'=>$inventoryId,'AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.recurring'=>'N')));
			return $clientInvoice;
		}
	}
	
	public function getInvoiceDetailsById($invoiceId = null){
		$this->recursive = 0;
		
		$session 		  = new SessionComponent();
		$subscriberId 	  =	$session->read('Auth.User.SbsSubscriber.id');
		$invoice_details  = $this->find('first',array('conditions'=>array('AcrClientInvoice.id'=>$invoiceId, 'AcrClientInvoice.sbs_subscriber_id'=>$subscriberId)));
		return $invoice_details;
	}
	public function getInvoiceByInvoiceNumber($invoiceNumber = null,$subscriberId = null){
		$this->recursive = 0;
		$invoice_details = $this->find('first',array('conditions'=>array('AcrClientInvoice.invoice_number'=>$invoiceNumber,'AcrClientInvoice.sbs_subscriber_id'=>$subscriberId)));
		return $invoice_details;
	}
	public function addInvoice($data){
		if($data){
			$addInvoice->data = null;
			$this->create();
			$addInvoice->data['AcrClientInvoice']['invoice_number']					=	$data['invoice_number'];
			$addInvoice->data['AcrClientInvoice']['purchase_order_no']				=	$data['purchase_order_no'];
			$addInvoice->data['AcrClientInvoice']['description']					=	$data['invoice_description'];
			$addInvoice->data['AcrClientInvoice']['invoiced_date']					=	date('Y-m-d',strtotime($data['invoiced_date']));
			$addInvoice->data['AcrClientInvoice']['due_date']						=	$data['due_date'];
			$addInvoice->data['AcrClientInvoice']['discount_percent']				=	$data['discount_total'];
			$addInvoice->data['AcrClientInvoice']['status']							=	$data['status'];
			$addInvoice->data['AcrClientInvoice']['notes']							=	$data['notes'];
			$addInvoice->data['AcrClientInvoice']['term_conditions']				=	$data['terms'];
			$addInvoice->data['AcrClientInvoice']['sub_total']						=	$data['sub_total'];
			$addInvoice->data['AcrClientInvoice']['tax_total']						=	$data['tax_total'];
			$addInvoice->data['AcrClientInvoice']['func_currency_total']			=	$data['func_currency_total'];
			$addInvoice->data['AcrClientInvoice']['exchange_rate']					=	$data['exchange_rate'];
			if($data['recurring'] == 'Y'){
				$addInvoice->data['AcrClientInvoice']['recurring']						=	'Y';
			}else{
				$addInvoice->data['AcrClientInvoice']['recurring']						=	'N';
			}
			if($data['email_format']){
				$addInvoice->data['AcrClientInvoice']['email_format']				=	$data['email_format'];
			}
			$addInvoice->data['AcrClientInvoice']['acr_client_id']					=	$data['acr_client_id'];
			$addInvoice->data['AcrClientInvoice']['sbs_subscriber_id']				=	$data['sbs_subscriber_id'];
			$addInvoice->data['AcrClientInvoice']['sbs_subscriber_payment_term_id']	=	$data['sbs_subscriber_payment_term_id'];
			$addInvoice->data['AcrClientInvoice']['invoice_total']					=	$data['invoice_total'];
			$addInvoice->data['AcrClientInvoice']['invoice_currency_code']			=	$data['defaultCurrencyId'];
			$addInvoice->data['AcrClientInvoice']['updated_date']					=	date('Y-m-d');
			if($this->save($addInvoice->data)){
				$invoiceId = $this->getLastInsertId();
				return $invoiceId;
			}else{
				return false;
			}
		}
	}
	
	public function updateInvoice($data){
		if($data){
			$addInvoice->data = null;
			$addInvoice->data['AcrClientInvoice']['id']								=	$data['invoiceId'];
			$addInvoice->data['AcrClientInvoice']['invoice_number']					=	$data['invoice_number'];
			$addInvoice->data['AcrClientInvoice']['purchase_order_no']				=	$data['purchase_order_no'];
			$addInvoice->data['AcrClientInvoice']['description']					=	$data['invoice_description'];
			$addInvoice->data['AcrClientInvoice']['invoiced_date']					=	date('Y-m-d',strtotime($data['invoiced_date']));
			$addInvoice->data['AcrClientInvoice']['due_date']						=	$data['due_date'];
			$addInvoice->data['AcrClientInvoice']['discount_percent']				=	$data['discount_total'];
			$addInvoice->data['AcrClientInvoice']['status']							=	$data['status'];
			$addInvoice->data['AcrClientInvoice']['notes']							=	$data['notes'];
			$addInvoice->data['AcrClientInvoice']['term_conditions']				=	$data['terms'];
			$addInvoice->data['AcrClientInvoice']['sub_total']						=	$data['sub_total'];
			$addInvoice->data['AcrClientInvoice']['tax_total']						=	$data['tax_total'];
			$addInvoice->data['AcrClientInvoice']['func_currency_total']			=	$data['func_currency_total'];
			$addInvoice->data['AcrClientInvoice']['exchange_rate']					=	$data['exchange_rate'];
			if($data['recurring']){	
				$addInvoice->data['AcrClientInvoice']['recurring']						=	$data['recurring'];
			
			}else{
				$addInvoice->data['AcrClientInvoice']['recurring']						=	'N';
			}
			if($data['email_format']){
				$addInvoice->data['AcrClientInvoice']['email_format']				=	$data['email_format'];
			}	
			$addInvoice->data['AcrClientInvoice']['acr_client_id']					=	$data['acr_client_id'];
			$addInvoice->data['AcrClientInvoice']['sbs_subscriber_id']				=	$data['sbs_subscriber_id'];
			$addInvoice->data['AcrClientInvoice']['sbs_subscriber_payment_term_id']	=	$data['sbs_subscriber_payment_term_id'];
			$addInvoice->data['AcrClientInvoice']['invoice_total']					=	$data['invoice_total'];
			$addInvoice->data['AcrClientInvoice']['invoice_currency_code']			=	$data['defaultCurrencyId'];
			$addInvoice->data['AcrClientInvoice']['updated_date']					=	date('Y-m-d');
			if($this->save($addInvoice->data)){
				$invoiceId = $data['invoiceId'];
				return $invoiceId;
			}else{
				return false;
			}
		}
	}
	
	public function getTotalInvoice($subscriberId = null){
		if($subscriberId){
			$invoiceCount = $this->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.recurring'=>'N')));
			if($invoiceCount){
				return $invoiceCount;
			}else{
				return '0';
			}
		}else{
			return false;
		}
	}
	
	public function updateInvoiceStatus ($id, $status) {
		
		if($id && $status) {
			$updateInvoice->data = null;
			$updateInvoice->data['AcrClientInvoice']['id']		=	$id;
			$updateInvoice->data['AcrClientInvoice']['status']	=	$status;
			if($this->save($updateInvoice->data)){				
					return true;
				}else{
					return false;
				}
		}	
	}
	
	// check invoice exist, return status
	public function checkInvoiceNumber($invoiceNumber = null,$subscriberId = null){		
		$invoicenoExist = $this->find('first',array('conditions'=>array('AcrClientInvoice.invoice_number'=>$invoiceNumber,
		'AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.recurring'=>'N'), 'fields'=>array('AcrClientInvoice.status')));
		return $invoicenoExist['AcrClientInvoice']['status'];
	}
	
	public function getInvoiceNumberByInvoiceId($invoiceId = null){
		
		$session 		  = new SessionComponent();
		$subscriberId 	  =	$session->read('Auth.User.SbsSubscriber.id');
		
		$invoiceno = $this->find('first',array('conditions'=>array('AcrClientInvoice.id'=>$invoiceId, 'AcrClientInvoice.sbs_subscriber_id'=>$subscriberId),
		 'fields'=>array('AcrClientInvoice.invoice_number')));
		return $invoiceno['AcrClientInvoice']['invoice_number'];
	}
	
/**
 * @Author Ganesh
 * @Since 20 Aug 2014
 * @Version v.1
 * @Method get except CANCELED invoices count for Subscriber Dashboard
 * **/
 	public function getActiveInvoiceCount($subscriberID = NULL) {
 		return $this->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberID,'AcrClientInvoice.recurring'=>'N','NOT'=>array('AcrClientInvoice.status'=>'Canceled'))));
 	}
 	
 	public function getCountOfInvoice($currencyCode = null,$subscriberID = null){
 		return $this->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberID,'AcrClientInvoice.recurring'=>'N','AcrClientInvoice.invoice_currency_code'=>$currencyCode,'NOT'=>array('AcrClientInvoice.status'=>'Canceled'))));
 	}
	
	public function chkInvoiceId ($invoiceId = null){
		$session 		  = new SessionComponent();
		$subscriberId 	  =	$session->read('Auth.User.SbsSubscriber.id');
		$exist			  = $this->find('count',array('conditions'=>array('AcrClientInvoice.id'=>$invoiceId, 'AcrClientInvoice.sbs_subscriber_id'=>$subscriberId)));
		if($exist){
			return true;
		} else {
			return false;
		}		
	 }
	public function updateTotal($data){
		if($data){
			$updateInvoice->data = null;
			$updateInvoice->data['AcrClientInvoice']['id']						=	$data['id'];
			$updateInvoice->data['AcrClientInvoice']['sub_total']				=	$data['subTotal'];
			$updateInvoice->data['AcrClientInvoice']['tax_total']				=	$data['taxTotal'];
			$updateInvoice->data['AcrClientInvoice']['func_currency_total']		=	$data['func_currency_total'];
			$updateInvoice->data['AcrClientInvoice']['invoice_total']			=	$data['invoice_total'];
			if($this->save($updateInvoice->data)){				
					return true;
				}else{
					return false;
				}
		}	
		}
	
	public function getInvoicesGroupByClient($subscriberId = null,$options = null){
		if($subscriberId){
			$this->recursive = 0;
			$this->virtualFields = array(
									'count_id' => 'count(`AcrClientInvoice.id`)',
									'sum_sub_total' => 'sum(`sub_total`)',
									'sum_tax_total' => 'sum(`tax_total`)',
									'sum_func_currency_total' => 'sum(`func_currency_total`)',
								);
			$this->unbindModel(array('belongsTo' => array('SbsSubscriberPaymentTerm','SbsSubscriber')));
			if($options){
				$options = $options;
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
														'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
														'AcrClientInvoice.recurring'=>'N'
													 ),
								'group' => array(
									'acr_client_id',
								)
						);
			}
			
			$getAllInvoices = $this->find('all', $options);
			return $getAllInvoices;
		}
	}
	
	
	
    public function getAgingInvoices($subscriberId = null,$bucketName = null,$startDate = null,$endDate = null,$customerName){
		$this->recursive = 0;
		$this->virtualFields = array(
									'count_id' => 'count(`AcrClientInvoice.id`)',
									'sum_sub_total' => 'sum(`AcrClientInvoice.sub_total`)',
									'sum_tax_total' => 'sum(`AcrClientInvoice.tax_total`)',
									'sum_func_currency_total' => 'sum(`AcrClientInvoice.func_currency_total`)',
								);
		$this->unbindModel(array('belongsTo' => array('SbsSubscriberPaymentTerm','SbsSubscriber')));
		if($customerName){
			if($endDate){
				$conditions = array(
					'OR'=>array(
							array(
									'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
									'AcrClient.organization_name like'=>'%'.$customerName.'%',
									'AcrClientInvoice.status'=>'Sent',
									'AcrClientInvoice.recurring'=>'N',
									'AcrClientInvoice.due_date <'=>$startDate,
									'AcrClientInvoice.due_date >='=>$endDate
							),
							array(
									'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
									'AcrClient.organization_name like'=>'%'.$customerName.'%',
									'AcrClientInvoice.status'=>'Open',
									'AcrClientInvoice.recurring'=>'N',
									'AcrClientInvoice.due_date <'=>$startDate,
									'AcrClientInvoice.due_date >='=>$endDate
							)
					));
			}else{
				$conditions = array(
					'OR'=>array(
							array(
									'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
									'AcrClient.organization_name like'=>'%'.$customerName.'%',
									'AcrClientInvoice.recurring'=>'N',
									'AcrClientInvoice.status'=>'Sent',
									'AcrClientInvoice.due_date <'=>$startDate,
							),
							array(
									'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
									'AcrClient.organization_name like'=>'%'.$customerName.'%',
									'AcrClientInvoice.recurring'=>'N',
									'AcrClientInvoice.status'=>'Open',
									'AcrClientInvoice.due_date <'=>$startDate,
							)
					));
			}
			
		}else{
			if($endDate){
				$conditions = array(
					'OR'=>array(
							array(
									'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
									'AcrClientInvoice.status'=>'Sent',
									'AcrClientInvoice.recurring'=>'N',
									'AcrClientInvoice.due_date <'=>$startDate,
									'AcrClientInvoice.due_date >='=>$endDate
							),
							array(
									'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
									'AcrClientInvoice.status'=>'Open',
									'AcrClientInvoice.recurring'=>'N',
									'AcrClientInvoice.due_date <'=>$startDate,
									'AcrClientInvoice.due_date >='=>$endDate
							)
					));
			}else{
				$conditions = array(
					'OR'=>array(
							array(
									'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
									'AcrClientInvoice.status'=>'Sent',
									'AcrClientInvoice.recurring'=>'N',
									'AcrClientInvoice.due_date <'=>$startDate,
							),
							array(
									'AcrClientInvoice.sbs_subscriber_id' => $subscriberId,
									'AcrClientInvoice.status'=>'Open',
									'AcrClientInvoice.recurring'=>'N',
									'AcrClientInvoice.due_date <'=>$startDate,
							)
					));
			}
			
			
		}
	$options = array(
				'fields' => array(
						'AcrClientInvoice.acr_client_id',
						'AcrClient.organization_name',
						'AcrClientInvoice.due_date',
						'AcrClientInvoice.func_currency_total',
				),
				'conditions' => $conditions,
			);
		$getAllInvoices = $this->find('all', $options);
		return $getAllInvoices;
	}
	public function checkPaymentTermBySubscriber($subscriber=null,$payment_term=null){
		$acr_client_invoice_pay_term=$this->find('first',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriber,'AcrClientInvoice.sbs_subscriber_payment_term_id'=>$payment_term),array('AcrClientInvoice.id')));
	    if($acr_client_invoice_pay_term){
	    	return $acr_client_invoice_pay_term;
	    }else{
	    	return false;
	    }
    }

	public function getTotalInvoicePatternBased($subscriberId,$pattern){
		$getCount = $this->find('count',array('conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberId,'AcrClientInvoice.invoice_number like'=>$pattern.'%')));
		return $getCount;
	}
}
