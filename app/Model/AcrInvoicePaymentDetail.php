<?php
App::uses('AppModel', 'Model');
App::import('Component', 'SessionComponent');
/**
 * AcrInvoicePaymentDetail Model
 *
 * @property AcrClient $AcrClient
 * @property AcrClientInvoice $AcrClientInvoice
 * @property SbsSubscriber $SbsSubscriber
 */
class AcrInvoicePaymentDetail extends AppModel {


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
		'AcrClientInvoice' => array(
			'className' => 'AcrClientInvoice',
			'foreignKey' => 'acr_client_invoice_id',
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
		),
		'CpnPaymentMethod' => array(
			'className' => 'CpnPaymentMethod',
			'foreignKey' => 'cpn_payment_method_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function getPaymentDetailsById($paymentId = null){
		$session 		  = new SessionComponent();
		$subscriberId 	  =	$session->read('Auth.User.SbsSubscriber.id');
		$this->recursive = 0;
		$this->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
		$payment_details = $this->find('first',array('conditions'=>array('AcrInvoicePaymentDetail.id'=>$paymentId, 'AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId),'fields'=>array('CpnPaymentMethod.payment_option_name','CpnPaymentMethod.id'
		,'AcrInvoicePaymentDetail.payment_date','AcrInvoicePaymentDetail.reference_no','AcrInvoicePaymentDetail.notes','AcrClientInvoice.invoice_number','AcrClientInvoice.status'
		,'AcrClientInvoice.invoice_total','AcrClientInvoice.invoice_currency_code','AcrInvoicePaymentDetail.acr_client_invoice_id','AcrInvoicePaymentDetail.acr_client_id','AcrInvoicePaymentDetail.paid_amount','AcrInvoicePaymentDetail.send_payment_note','AcrClient.client_name')));
		return $payment_details;
	}
	
	// get payment history for invoice
	public function getPaymentHistoryForInvoice($invoiceId = null){
		$session 		  = new SessionComponent();
		$subscriberId 	  =	$session->read('Auth.User.SbsSubscriber.id');
		$this->recursive = 0;
		$this->unbindModel(array('belongsTo'=>array('AcrClient','SbsSubscriber')));		
		$payment_history = $this->find('all',array('conditions'=>array('AcrInvoicePaymentDetail.acr_client_invoice_id'=>$invoiceId, 'AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),'fields'=>array('CpnPaymentMethod.payment_option_name'
		,'AcrInvoicePaymentDetail.payment_date','AcrInvoicePaymentDetail.reference_no','AcrInvoicePaymentDetail.notes','AcrClientInvoice.invoice_number','AcrClientInvoice.status'
		,'AcrClientInvoice.invoice_total','AcrClientInvoice.invoice_currency_code','CpnPaymentMethod.payment_option_name','AcrInvoicePaymentDetail.paid_amount')));
		return $payment_history;
	}
	
	// calculate total paid amount for invoice
	public function getTotalPaidAmount($invoiceId = null){				
		$total_paid_amount = $this->find('first',array('conditions'=>array('AcrInvoicePaymentDetail.acr_client_invoice_id'=>$invoiceId, 'AcrInvoicePaymentDetail.is_deleted'=>'no'),'fields'=>array('sum(AcrInvoicePaymentDetail.paid_amount) as total_sum')));
		return $total_paid_amount;
	}
	
	// get invoiceId By Payment Id
	public function getInvoiceIdByPaymentId ($paymentId = null){
		$session 		  = new SessionComponent();
		$subscriberId 	  =	$session->read('Auth.User.SbsSubscriber.id');
		$acr_client_invoice_id = $this->find('first',array('conditions'=>array('AcrInvoicePaymentDetail.id'=>$paymentId, 'AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoicePaymentDetail.acr_client_invoice_id')));
		return $acr_client_invoice_id['AcrInvoicePaymentDetail']['acr_client_invoice_id'];
	}

	
	public function chkPaymentId ($paymentId = null){
		$session 		  = new SessionComponent();
		$subscriberId 	  =	$session->read('Auth.User.SbsSubscriber.id');
		$exist			  = $this->find('count',array('conditions'=>array('AcrInvoicePaymentDetail.id'=>$paymentId, 'AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId)));
		if($exist){
			return true;
		} else {
			return false;
		}		
	 }

/**
 * @Author Ganesh
 * @Since 21 Aug 2014
 * @Version v.1
 * @Method Calculate total payments for invoices
 * @param Invoice ids array 
 * **/
	public function getPayments($conversionRate = NULL) {
		$conversionArray		= $conversionRate[0];
		$totalAmount 			= 0;
		foreach ($conversionArray as $invoiceID => $rate) {
			$amount = $this->find('first',array('fields'=>array('SUM(paid_amount) as payments'),'conditions'=>array('acr_client_invoice_id'=>$invoiceID,'is_deleted'=>'no')));
			$totalAmount += ($amount[0]['payments']/$rate);
		}
		return $totalAmount;
	}

	
	public function addPaymentDetail($paymentDetail){
		if($paymentDetail){
			
			$saveDetail->data = null;
			$this->create();
			$saveDetail->data['cpn_payment_method_id'] 	= 	$paymentDetail['payment_method']; 		
			$saveDetail->data['paid_amount']			=	$paymentDetail['paid_amount'];			
			$saveDetail->data['payment_date']			=	$paymentDetail['payment_date']; 			
			$saveDetail->data['reference_no']			=	$paymentDetail['reference_no']; 			
			$saveDetail->data['notes']					=	$paymentDetail['notes']; 				
			$saveDetail->data['send_payment_note']		=	$paymentDetail['send_payment_note']; 	
			$saveDetail->data['acr_client_id']			=	$paymentDetail['acr_client_id']; 		
			$saveDetail->data['acr_client_invoice_id']	=	$paymentDetail['acr_client_invoice_id'];
			$saveDetail->data['sbs_subscriber_id']		=	$paymentDetail['sbs_subscriber_id']; 	
			if($this->save($saveDetail->data)){
				$paymentId = $this->getLastInsertId();
				return $paymentId;
			}else{
				return false;
			}
		}		
	}

	public function updatePaymentDetail($paymentDetail){
		if($paymentDetail){
			
			$saveDetail->data = null;
			
			$saveDetail->data['id'] 					= 	$paymentDetail['id']; 	
			$saveDetail->data['cpn_payment_method_id'] 	= 	$paymentDetail['payment_method']; 		
			$saveDetail->data['paid_amount']			=	$paymentDetail['paid_amount'];			
			$saveDetail->data['payment_date']			=	$paymentDetail['payment_date']; 			
			$saveDetail->data['reference_no']			=	$paymentDetail['reference_no']; 			
			$saveDetail->data['notes']					=	$paymentDetail['notes']; 				
			$saveDetail->data['send_payment_note']		=	$paymentDetail['send_payment_note']; 	
			
			if($this->save($saveDetail->data)){
				return true;
			}else{
				return false;
			}
		}		
	}
	
	// update payment with is_deleted = yes
	public function deletePayment($id = null){
		if($id){			
			$saveDetail->data = null;			
			$saveDetail->data['id'] 					= 	$id; 	
			$saveDetail->data['is_deleted'] 			= 	'yes';
			if($this->save($saveDetail->data)){
				return true;
			}else{
				return false;
			}
		}		
	}
	
	public function importPayment($subscriberId,$paymentInformation,$acr_client_invoice_id,$acr_client_id){
   		if($subscriberId && $paymentInformation){
   			if(!$paymentInformation['']){
   					$arraySave['failure'] = '1';
   					$arraySave['error'] = "Missing";
   					return $arraySave;
   			}elseif(!$paymentInformation['Name']){
   				$arraySave['failure'] = '1';
   				$arraySave['error'] = "Missing";
   				return $arraySave;
   			}else{   				    		 				 				   					
					$saveDetail->data = null;
					$this->create();
					$saveDetail->data['cpn_payment_method_id'] 	= 	$paymentInformation['Payment Method']; 		
					$saveDetail->data['paid_amount']			=	$paymentInformation['Reciept Amount'];			
					$saveDetail->data['payment_date']			=	$paymentInformation['Payment Date']; 			
					$saveDetail->data['reference_no']			=	$paymentInformation['Reference No.']; 			
					$saveDetail->data['notes']					=	$paymentInformation['Notes']; 				
					$saveDetail->data['send_payment_note']		=	$paymentInformation['Send Payment Note']; 	
					$saveDetail->data['acr_client_id']			=	$acr_client_id; 		
					$saveDetail->data['acr_client_invoice_id']	=	$acr_client_invoice_id;
					$saveDetail->data['sbs_subscriber_id']		=	$subscriberId; 	
					if($this->save($saveDetail->data)){
						$lastInsertedId       = $this->getLastInsertId();
						$arraySave['Success'] = $lastInsertedId;
		   				return $arraySave;
					}else{
						return false;
					}				
   			}
   		}
   }

	public function getClientLastPayment($subscriberId = null,$clientId = null){
		if($subscriberId && $clientId){
			$paymentDetail = $this->find('first',array('conditions'=>array('AcrInvoicePaymentDetail.acr_client_id'=>$clientId,'AcrInvoicePaymentDetail.sbs_subscriber_id'=>$subscriberId),'order'=>array('AcrInvoicePaymentDetail.id DESC')));
			return $paymentDetail;
		}
	}
	
}
