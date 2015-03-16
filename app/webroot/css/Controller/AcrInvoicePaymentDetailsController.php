<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * AcrInvoicePaymentDetails Controller
 *
 * @property AcrInvoicePaymentDetail $AcrInvoicePaymentDetail
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class AcrInvoicePaymentDetailsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','Email', 'RequestHandler', 'Session');
	private $permission = NULL;
	
	public function beforeFilter() {
        parent::beforeFilter();
       // $this->Auth->allow('login','inactive');
       $this->loadModel('AcrInvoicePaymentDetail');
       $this->layout 		=  "sbs_layout";
       $this->permission 	=  $this->Session->read('Auth.AllPermissions.Invoices');
       $this->subscriber 	=  $this->Session->read('Auth.User.SbsSubscriber.id');
       $invoicesActive 		= 'active';
	   $menuActive		    = 'Payments';
	   $this->set(compact('invoicesActive','menuActive'));
		
    }
	
	/**
 * index method
 * listing payment details and filters
 * @return void
 */
	public function index($filterAction = 0, $filterValue = 0, $filterValue1 = 0, $filterValue2 = 0, $fromDate = 0, $toDate = 0, $page = null) {			
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		// configure::write('debug',2);
		$this->loadModel('SbsSubscriberSetting');
		$this->AcrInvoicePaymentDetail->recursive = 0;
		$settings 		= $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$date_format    = $settings['SbsSubscriberSetting']['date_format'];			
		$limit 			= $settings['SbsSubscriberSetting']['lines_per_page'];
		$condition_array = null;$filterAction_array = null; $payment_date_array = null;
		if(trim($filterAction)) {
			$this->request->data['PaymentFilter']['filterAction'] 	= $filterAction;
		}
		if(trim($filterValue)) {
			$this->request->data['PaymentFilter']['filterValue'] 	= $filterValue;
		}
		if(trim($filterValue1)) {
			$this->request->data['PaymentFilter']['filterValue1'] 	= $filterValue1;
		}
		if(trim($filterValue2)) {
			$this->request->data['PaymentFilter']['filterValue2'] 	= $filterValue2;
		}		
		if(trim($fromDate)) {
			$this->request->data['PaymentFilter']['fromDate'] 		= $fromDate;
		}
		if(trim($toDate)) {
			$this->request->data['PaymentFilter']['toDate'] 		= $toDate;
		}		
		
		if($this->data['PaymentFilter']){
			
			if(!empty($this->request->data['PaymentFilter']['filterAction'])) {
				$filterAction = trim($this->request->data['PaymentFilter']['filterAction']);
				if($filterAction == 'invoice_number'){
					$invoice_number = trim($this->request->data['PaymentFilter']['filterValue']);
					$filterValue	= $invoice_number;
					
				} elseif($filterAction == 'customer_name') {
					$customer_name   = trim($this->request->data['PaymentFilter']['filterValue']);
					$filterValue	 = $customer_name;
					
				} elseif($filterAction == 'amount') {
					$min_amount  	= trim($this->request->data['PaymentFilter']['filterValue1']);
					$filterValue1	= $min_amount;
					$max_amount  	= trim($this->request->data['PaymentFilter']['filterValue2']);
					$filterValue2	= $max_amount;
				} 	
			}
			if(!empty($this->request->data['PaymentFilter']['fromDate'])) 				
			 $fromDate     = trim($this->request->data['PaymentFilter']['fromDate']);
			if($fromDate) $fromDate	  = date('Y-m-d', strtotime($fromDate));
			if(!empty($this->request->data['PaymentFilter']['toDate']))
			 $toDate       = trim($this->request->data['PaymentFilter']['toDate']);
			if($toDate)   $toDate	  = date('Y-m-d', strtotime($toDate));
			
			// server side validation
			if(empty($filterAction) && empty($fromDate) && empty($toDate)) {
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
			
			if($fromDate && $toDate) $payment_date_array =	array('AcrInvoicePaymentDetail.payment_date BETWEEN ? and ?'=>array($fromDate,$toDate));
			
			$condition_array = array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$this->subscriber,'AcrInvoicePaymentDetail.is_deleted'=>'no');
			$conditions 	 = array($condition_array, $filterAction_array, $payment_date_array);	
			
			
		} else {
			$conditions 			= array('AcrInvoicePaymentDetail.sbs_subscriber_id'=>$this->subscriber,'AcrInvoicePaymentDetail.is_deleted'=>'no');
		}
		
		$this->AcrInvoicePaymentDetail->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
		$this->Paginator->settings = array('conditions'=>$conditions,'limit'=>$limit,'order'=>array('AcrClientInvoice.invoice_number' => 'ASC'),
				'fields'=>array('AcrInvoicePaymentDetail.id','AcrClientInvoice.invoice_number','AcrInvoicePaymentDetail.payment_date','AcrClientInvoice.invoice_total',
					'CpnPaymentMethod.payment_option_name','AcrClientInvoice.invoice_currency_code','AcrClient.client_name','AcrInvoicePaymentDetail.paid_amount'));
					
		$this->set(compact('date_format','filterAction','filterValue','filterValue1','filterValue2','fromDate','toDate'));		
		$this->set('acrInvoicePaymentDetails', $this->Paginator->paginate('AcrInvoicePaymentDetail'));		
	}

	// view payment details for payment ID
	public function view($paymentId, $filterAction = null, $filterValue = null, $filterValue1 = null, $filterValue2 = null, $fromDate = null, $toDate = null, $page = null) {		
		
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		
		//configure::write('debug',2);
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('SbsSubscriberSetting');
		
		$paymentData   = $this->AcrInvoicePaymentDetail->getPaymentDetailsById($paymentId);
		
		$settings 		   = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$date_format       = $settings['SbsSubscriberSetting']['date_format'];		
		$payment_history   = $this->AcrInvoicePaymentDetail->getPaymentHistoryForInvoice($paymentData['AcrInvoicePaymentDetail']['acr_client_invoice_id']);		
		$total_paid 	   = $this->AcrInvoicePaymentDetail->getTotalPaidAmount($paymentData['AcrInvoicePaymentDetail']['acr_client_invoice_id']);
		$total_paid_amount = $total_paid[0]['total_sum'];
		
		$invoicedAmount         = money_format('%!(.2n',$paymentData['AcrClientInvoice']['invoice_total']); 
		$total_paid_amount      = money_format('%!(.2n',$total_paid_amount);
		$balance_due 			= $invoicedAmount - $total_paid_amount;	
		$recieptAmount			= $invoicedAmount - $total_paid_amount;
		
		$this->set(compact('invoicedAmount','payment_history','total_paid_amount','balance_due','date_format','recieptAmount','paymentData'));
		$this->set(compact('filterAction','filterValue','filterValue1','filterValue2','fromDate','toDate'));	
	}

	public function add($id = null) {
		
		// $id = $acr_client_invoice_id
		//configure::write('debug',2);
		//debug($this->data);
		
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnPaymentMethod');
		
		$settings 		   = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$date_format       = $settings['SbsSubscriberSetting']['date_format'];		
		$payment_history   = $this->AcrInvoicePaymentDetail->getPaymentHistoryForInvoice($id);		
		$total_paid 	   = $this->AcrInvoicePaymentDetail->getTotalPaidAmount($id);
		$total_paid_amount = $total_paid[0]['total_sum'];
		$paymentMethods    = $this->CpnPaymentMethod->getAllPaymentOptions();
			
		if($id){
			
			$invoiceDetails   		= $this->AcrClientInvoice->getInvoiceDetailsById($id);
			
			$invoiceNumber   		= $invoiceDetails['AcrClientInvoice']['invoice_number'];	
			$invoicedAmount  		= $invoiceDetails['AcrClientInvoice']['invoice_total'];
			$invoicedCurrency 		= $invoiceDetails['AcrClientInvoice']['invoice_currency_code'];
			$acr_client_id 			= $invoiceDetails['AcrClientInvoice']['acr_client_id'];
			$acr_client_invoice_id 	= $id;
			$client_name 			= $invoiceDetails['AcrClient']['client_name'];
			$sbs_subscriber_id 		= $this->subscriber;
			$invoicedAmount         = money_format('%!(.2n',$invoicedAmount); 
			$total_paid_amount      = money_format('%!(.2n',$total_paid_amount);
			$balance_due 			= $invoicedAmount - $total_paid_amount;	
			$recieptAmount			= $invoicedAmount - $total_paid_amount;
			$this->set(compact('invoiceNumber','invoicedAmount','invoicedCurrency','payment_history','total_paid_amount','balance_due','date_format','paymentMethods','recieptAmount'));
		}
		
		if ($this->request->is(array('post'))) {
			debug($this->data['capturePayment']['balance_due']);
			$creditAmount 							= $this->data['capturePayment']['creditAmount'];	
			$paymentDetail['payment_method'] 		= $this->data['capturePayment']['payment_method'];
			if($creditAmount){
				$paymentDetail['paid_amount']			= $this->data['capturePayment']['paid_amount'] - $creditAmount;
			} else {
				$paymentDetail['paid_amount']			= $this->data['capturePayment']['paid_amount'];
			}			
			$paymentDetail['payment_date'] 			= date('Y-m-d', strtotime($this->data['capturePayment']['payment_date']));			 
			$paymentDetail['reference_no'] 			= $this->data['capturePayment']['reference_no'];
			$paymentDetail['notes'] 				= $this->data['capturePayment']['notes'];
			$paymentDetail['osBalance'] 			= $this->data['capturePayment']['balance_due'];
			if($this->data['capturePayment']['send_payment_note']){
				$paymentDetail['send_payment_note'] 	= 'Y';
			} else {
				$paymentDetail['send_payment_note'] 	= 'N';
			}			
			$paymentDetail['acr_client_id'] 		= $acr_client_id;
			$paymentDetail['acr_client_invoice_id'] = $acr_client_invoice_id;
			$paymentDetail['sbs_subscriber_id'] 	= $sbs_subscriber_id;			
			
			$capturePayment   	   = $this->AcrInvoicePaymentDetail->addPaymentDetail($paymentDetail);
		    
			//if($this->data['capturePayment']['credit_note']){
			    if($creditAmount){
			    	$this->loadModel('AcrClientCreditnote');
					$paymentId     		= $capturePayment;
					$createCreditNote   = $this->AcrClientCreditnote->addCreditNote($creditAmount,$acr_client_id,$acr_client_invoice_id,$sbs_subscriber_id,$paymentId);
				}
			//}			
			
			if($paymentDetail['osBalance'] <= 0 || $paymentDetail['osBalance'] == $paymentDetail['paid_amount']) {
				$status = 'Marked as paid';
				$updateInvoiceStatus   = $this->AcrClientInvoice->updateInvoiceStatus($acr_client_invoice_id, $status);
			}		
			
			if($this->data['capturePayment']['send_payment_note']){
				$template 	= "send_payment_note";
			  	$subject 	= "Payment Completed";
			 	$notify 	= $this->sendPaymentNote($acr_client_id,$template,$subject,$client_name);			 
			}
			
			$this->redirect(array('action' => 'index','page:'.$page));
		}
	}
	
	public function edit($id = null, $filterAction = null, $filterValue = null, $filterValue1 = null, $filterValue2 = null, $fromDate = null, $toDate = null, $page = null) {
		
		 // configure::write('debug',2);
		 // debug($this->data);
		 
		$permission = $this->permission;		
		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		 
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnPaymentMethod');
		
		$paymentData    = $this->AcrInvoicePaymentDetail->getPaymentDetailsById($id);		
		
		$settings 		   = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$sbs_subscriber_id = $this->subscriber;
		$date_format       = $settings['SbsSubscriberSetting']['date_format'];		
		$payment_history   = $this->AcrInvoicePaymentDetail->getPaymentHistoryForInvoice($paymentData['AcrInvoicePaymentDetail']['acr_client_invoice_id']);		
		$total_paid 	   = $this->AcrInvoicePaymentDetail->getTotalPaidAmount($paymentData['AcrInvoicePaymentDetail']['acr_client_invoice_id']);
		$total_paid_amount = $total_paid[0]['total_sum'];
		
		$invoicedAmount         = money_format('%!(.2n',$paymentData['AcrClientInvoice']['invoice_total']); 
		$total_paid_amount      = money_format('%!(.2n',$total_paid_amount);
		$balance_due 			= $invoicedAmount - $total_paid_amount;	
		$recieptAmount			= $invoicedAmount - $total_paid_amount;
		$paymentMethods    = $this->CpnPaymentMethod->getAllPaymentOptions();
		$this->set(compact('invoicedAmount','payment_history','total_paid_amount','balance_due','date_format','recieptAmount','paymentData','paymentMethods'));
		$this->set(compact('filterAction','filterValue','filterValue1','filterValue2','fromDate','toDate'));	
		if ($this->request->is(array('post'))) {		
			
			$paymentDetail['id'] 					= $id;
			$creditAmount 							= $this->data['editPayment']['creditAmount'];
			$paymentDetail['payment_method'] 		= $this->data['editPayment']['payment_method'];
			if($creditAmount){
				$paymentDetail['paid_amount']			= $this->data['editPayment']['paid_amount'] - $creditAmount;
			} else {
				$paymentDetail['paid_amount']			= $this->data['editPayment']['paid_amount'];
			}
			$paymentDetail['payment_date'] 			= date('Y-m-d', strtotime($this->data['editPayment']['payment_date']));			 
			$paymentDetail['reference_no'] 			= $this->data['editPayment']['reference_no'];
			$paymentDetail['notes'] 				= $this->data['editPayment']['notes'];
			$paymentDetail['osBalance'] 			= $this->data['editPayment']['balance_due'];
			if($this->data['editPayment']['send_payment_note']){
				$paymentDetail['send_payment_note'] 	= 'Y';
			} else {
				$paymentDetail['send_payment_note'] 	= 'N';
			}						
			
			$capturePayment   = $this->AcrInvoicePaymentDetail->updatePaymentDetail($paymentDetail);
			
			//if($this->data['editPayment']['credit_note']){
		   $this->loadModel('AcrClientCreditnote');				    
		   if($creditAmount){				    	
						$acr_client_id         = $paymentData['AcrInvoicePaymentDetail']['acr_client_id'];
						$acr_client_invoice_id = $paymentData['AcrInvoicePaymentDetail']['acr_client_invoice_id'];
						$paymentId			   = $id;	
						$creditNoteId		   = $this->AcrClientCreditnote->getCreditByPaymetId($paymentId, $sbs_subscriber_id);
						if($creditNoteId) {
							$createCreditNote   = $this->AcrClientCreditnote->updateCreditNote($creditNoteId , $creditAmount);
						} else {
							$updateCreditNote   = $this->AcrClientCreditnote->addCreditNote($creditAmount,$acr_client_id,$acr_client_invoice_id,$sbs_subscriber_id,$paymentId);
						}						
					}
			// } 
			else {				
				if(!$creditAmount){				    							
						$paymentId			   = $id;	
						$creditNoteId		   =  $this->AcrClientCreditnote->getCreditByPaymetId($paymentId, $sbs_subscriber_id);
						if($creditNoteId) {
							$createCreditNote   = $this->AcrClientCreditnote->deleteCreditNote($creditNoteId);
						} 						
					}				
			}
			
			if($paymentDetail['osBalance'] <= 0 || $paymentDetail['osBalance'] == $paymentDetail['paid_amount']) {
				$status = 'Marked as paid';
				$updateInvoiceStatus   = $this->AcrClientInvoice->updateInvoiceStatus($paymentData['AcrInvoicePaymentDetail']['acr_client_invoice_id'], $status);
			} else {
				$status = 'Sent';
				$updateInvoiceStatus   = $this->AcrClientInvoice->updateInvoiceStatus($paymentData['AcrInvoicePaymentDetail']['acr_client_invoice_id'], $status);
			}
			if($this->data['editPayment']['send_payment_note']){
				
				$invoiceDetails = $this->AcrClientInvoice->getInvoiceDetailsById($paymentData['AcrInvoicePaymentDetail']['acr_client_invoice_id']);
				$acr_client_id 	= $invoiceDetails['AcrClientInvoice']['acr_client_id'];				
				$client_name 	= $invoiceDetails['AcrClient']['client_name'];				
				$template 	= "send_payment_note";
			  	$subject 	= "Payment Completed";
			 	$notify 	= $this->sendPaymentNote($acr_client_id,$template,$subject,$client_name);			 	
			}			 
			 $this->redirect(array('action'=>'index',$filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate,'page:'.$page));
		}		
		
	}
	
	public function delete($id = null, $credit_note = 0, $filterAction = 0, $filterValue = 0, $filterValue1 = 0, $filterValue2 = 0, $fromDate = 0, $toDate = 0, $page = null) {
	
		$permission = $this->permission;		
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if($id) {
			$this->loadModel('AcrClientInvoice');		
			$this->loadModel('SbsSubscriberSetting');
			
			$settings 		   = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		    $sbs_subscriber_id = $this->subscriber;			
			$paymentData           = $this->AcrInvoicePaymentDetail->getPaymentDetailsById($id);
			$acr_client_id         = $paymentData['AcrInvoicePaymentDetail']['acr_client_id'];
			$acr_client_invoice_id = $paymentData['AcrInvoicePaymentDetail']['acr_client_invoice_id'];
			$creditAmount          = $paymentData['AcrInvoicePaymentDetail']['paid_amount'];
			$paymentId			   = $id;
			$deletedpayment        = $this->AcrInvoicePaymentDetail->deletePayment($id);	
			if ($deletedpayment) {				
				$status = 'Sent';				
				$updateInvoiceStatus   = $this->AcrClientInvoice->updateInvoiceStatus($acr_client_invoice_id, $status);	
				
				if($credit_note == 'Yes'){
				    	$this->loadModel('AcrClientCreditnote');
						$creditNoteId		   = $this->AcrClientCreditnote->getCreditByPaymetId($paymentId, $sbs_subscriber_id);						
						
						if($creditNoteId) {
							$creditNoteAmount	   = $this->AcrClientCreditnote->getCreditAmountById($creditNoteId);
							$creditAmountTotal     = $creditNoteAmount + $creditAmount;
							$updateCreditNote      = $this->AcrClientCreditnote->updateCreditNote($creditNoteId , $creditAmountTotal);
						} else {
							$createCreditNote      = $this->AcrClientCreditnote->addCreditNote($creditAmount,$acr_client_id,$acr_client_invoice_id,$sbs_subscriber_id,$paymentId);
						}
				 } 			
							
				$this->Session->setFlash('<div class="alert alert-success">Payment has been deleted !</div>');				
				$this->redirect(array('action'=>'index',$filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate,'page:'.$page));
			}
		}
	}
	
	public function deleteSelected($page = NULL) {
		
		//configure::write('debug',2);		
		$this->autoRender = false;
		$count = 0;		
		if($this->data['PaymentDelete']){
		$this->loadModel('AcrClientInvoice');
		foreach ($this->data['PaymentDelete']['id'] as $key => $value) {
			if($value) {
				$acr_client_invoice_id = $this->AcrInvoicePaymentDetail->getInvoiceIdByPaymentId($key);
				$this->AcrInvoicePaymentDetail->id = $key;
				if($this->AcrInvoicePaymentDetail->delete()) {
					$status = 'Sent';
					$updateInvoiceStatus   = $this->AcrClientInvoice->updateInvoiceStatus($acr_client_invoice_id, $status);
					$count++;
				}
			}
		}
	  }		
		if($count){
			$this->Session->setFlash('<div class="alert alert-success">'.$count.__(' Payments has been deleted !').'</div>');			
		}
		$this->redirect(array('action' => 'index','page:'.$page));
	}
	
	
	public function addNewPayment() {		
		
		// configure::write('debug',2);
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('CpnPaymentMethod');
		
		$errorFlag = 0;
		$settings 		   = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$date_format       = $settings['SbsSubscriberSetting']['date_format'];			
		$paymentMethods    = $this->CpnPaymentMethod->getAllPaymentOptions();		
		$this->set(compact('paymentMethods','date_format'));
		
		if ($this->request->is(array('put'))) {
			
			$invoice_number	   = $this->data['addNewPayment']['invoice_number'];
		
			if($invoice_number){
						
				$invoiceDetails   		= $this->AcrClientInvoice->getInvoiceByInvoiceNumber($invoice_number, $this->subscriber);
				
				if($invoiceDetails)	{
					
					$invoicenoExist    = $this->AcrClientInvoice->checkInvoiceNumber($invoice_number, $this->subscriber);
					if($invoicenoExist == 'Canceled') {
						$this->Session->setFlash('<div class="alert alert-info">Entered Invoice Number is already been canceled. </div>');
						$errorFlag = 1;
					}
					if($invoicenoExist == 'Draft') {
						$this->Session->setFlash('<div class="alert alert-info">To Record payment, First Please send the Invoice. </div>');
						$errorFlag = 1;
					}
					
					$id 			   = $invoiceDetails['AcrClientInvoice']['id'];			
					$payment_history   = $this->AcrInvoicePaymentDetail->getPaymentHistoryForInvoice($id);		
					$total_paid 	   = $this->AcrInvoicePaymentDetail->getTotalPaidAmount($id);
					$total_paid_amount = $total_paid[0]['total_sum'];	
					$invoiceStatus   		= $invoiceDetails['AcrClientInvoice']['status'];
					$client_name 			= $invoiceDetails['AcrClient']['client_name'];							
					$invoiceNumber   		= $invoiceDetails['AcrClientInvoice']['invoice_number'];	
					$invoicedAmount  		= $invoiceDetails['AcrClientInvoice']['invoice_total'];
					$invoicedCurrency 		= $invoiceDetails['AcrClientInvoice']['invoice_currency_code'];
					$acr_client_id 			= $invoiceDetails['AcrClientInvoice']['acr_client_id'];
					$acr_client_invoice_id 	= $id;
					$client_name 			= $invoiceDetails['AcrClient']['client_name'];
					$sbs_subscriber_id 		= $this->subscriber;
					$invoicedAmount         = money_format('%!(.2n',$invoicedAmount); 
					$total_paid_amount      = money_format('%!(.2n',$total_paid_amount);
					$balance_due 			= $invoicedAmount - $total_paid_amount;	
					$recieptAmount			= $invoicedAmount - $total_paid_amount;
					if($invoiceStatus == 'Marked as paid' || $invoiceStatus == 'Paid') {
						$this->Session->setFlash('<div class="alert alert-info">Entered Invoice Number is already marked as paid. Please check payment history Below. </div>');
				  		$errorFlag = 1;	
					}
					$this->set(compact('invoiceNumber','invoicedAmount','invoicedCurrency','payment_history','total_paid_amount',
					'balance_due','recieptAmount','acr_client_id','acr_client_invoice_id','client_name','invoiceStatus'));
				  }
				 else {
				  	    $this->Session->setFlash('<div class="alert alert-info">Entered Invoice Number does not exist, Please Enter correct Invoice Number.</div>');
				  	    $errorFlag = 1; 
					 }
				 $this->set(compact('errorFlag'));
			 }
		 }
		
		
		if ($this->request->is(array('post'))) {				 	
					
					
					$invoice_number	   		= $this->data['addNewPayment']['invoice_number'];
			        if(!trim($invoice_number)) {
						$this->Session->setFlash('<div class="alert alert-danger"> Please Enter Invoice number. </div>');
						$this->redirect(array('action' => 'addNewPayment'));
				  	}
					$invoicenoExist    = $this->AcrClientInvoice->checkInvoiceNumber($invoice_number, $this->subscriber);
					if($invoicenoExist == 'Canceled') {
						$this->Session->setFlash('<div class="alert alert-info">Entered Invoice Number is already been canceled. </div>');
						$this->redirect(array('action' => 'addNewPayment'));
					} 
					if($invoicenoExist == 'Draft') {
						$this->Session->setFlash('<div class="alert alert-info">To Record payment, First Please send the Invoice. </div>');
					    $this->redirect(array('action' => 'addNewPayment'));
					}
					if(!$invoicenoExist) {
						$this->Session->setFlash('<div class="alert alert-info">Entered Invoice Number does not exist, Please Enter correct Invoice Number.</div>');
						$this->redirect(array('action' => 'addNewPayment'));
					}

					$acr_client_id 			= $this->data['addNewPayment']['acr_client_id'];
					$acr_client_invoice_id 	= $this->data['addNewPayment']['acr_client_invoice_id'];
					$client_name 			= $this->data['addNewPayment']['client_name'];
					$sbs_subscriber_id 		= $this->subscriber;	
					$invoiceStatus			= $this->data['addNewPayment']['invoiceStatus'];
					$creditAmount 							= $this->data['addNewPayment']['creditAmount'];							
					$paymentDetail['payment_method'] 		= $this->data['addNewPayment']['payment_method'];
					if($creditAmount){
						$paymentDetail['paid_amount']			= $this->data['addNewPayment']['paid_amount'] - $creditAmount;
					} else {
						$paymentDetail['paid_amount']			= $this->data['addNewPayment']['paid_amount'];
					}
					$paymentDetail['payment_date'] 			= date('Y-m-d', strtotime($this->data['addNewPayment']['payment_date']));			 
					$paymentDetail['reference_no'] 			= $this->data['addNewPayment']['reference_no'];
					$paymentDetail['notes'] 				= $this->data['addNewPayment']['notes'];
					$paymentDetail['osBalance'] 			= $this->data['addNewPayment']['balance_due'];
					if($this->data['addNewPayment']['send_payment_note']){
						$paymentDetail['send_payment_note'] 	= 'Y';
					} else {
						$paymentDetail['send_payment_note'] 	= 'N';
					}								
					$paymentDetail['acr_client_id'] 		= $acr_client_id;
					$paymentDetail['acr_client_invoice_id'] = $acr_client_invoice_id;
					$paymentDetail['sbs_subscriber_id'] 	= $sbs_subscriber_id;			
					
					if($invoiceStatus == 'Marked as paid' || $invoiceStatus == 'Paid') {
						$this->Session->setFlash('<div class="alert alert-info">Entered Invoice Number was already marked as paid. </div>');
				  		$this->redirect(array('action' => 'addNewPayment'));
					} 
					
					$capturePayment   	   = $this->AcrInvoicePaymentDetail->addPaymentDetail($paymentDetail);
					
					//if($this->data['addNewPayment']['credit_note']){						  
						    if($creditAmount){
						    	$this->loadModel('AcrClientCreditnote');
								$paymentId     		= $capturePayment;
								$createCreditNote   = $this->AcrClientCreditnote->addCreditNote($creditAmount,$acr_client_id,$acr_client_invoice_id,$sbs_subscriber_id,$paymentId);
							}
					//} 
				
					if($paymentDetail['osBalance'] <= 0 || $paymentDetail['osBalance'] == $paymentDetail['paid_amount']) {
						$status = 'Marked as paid';
						$updateInvoiceStatus   = $this->AcrClientInvoice->updateInvoiceStatus($acr_client_invoice_id, $status);
					}		
					
					if($this->data['addNewPayment']['send_payment_note']){
						$template 	= "send_payment_note";
						$subject 	= "Payment Completed";
					    $notify 	= $this->sendPaymentNote($acr_client_id,$template,$subject,$client_name);			 
					}
					
					$this->redirect(array('action' => 'index','page:'.$page));
				}		
	}
	
	
	public function sendPaymentNote($acr_client_id,$template,$subject,$client_name) {
		
		$this->loadModel('AcrClientContact');		
		$clientPrimaryContact = $this->AcrClientContact->getClientPrimaryContactDetail($acr_client_id);	
		$this->set(compact('client_name'));		
		/*$this->Email->to 	  	= $clientPrimaryContact['AcrClientContact']['email'];*/
		$this->Email->to 	  	= 'siddharth@carmatec.com';
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


	/**
 * Display the content of example.xls
 */
		function show_excel() {
			$this->loadModel('AcrClientInvoice');
	   		
			if($this->data){
				if((($_FILES['file']['type'] == 'application/vnd.ms-excel') || ($_FILES['file']['type'] == 'application/octet-stream'))){
					$fileOK = $this->uploadFiles('files', $_FILES);
					if($fileOK['urls']['0']){
	   					//$excel = new PhpExcelReader;
	   						$excel = new Spreadsheet_Excel_Reader;
	   						$excel->read($fileOK['urls']['0']);
	   						$nr_sheets = count($excel->sheets);
	   						$excel_data = '';
	   						$sheetOrderProvided = array(
	   							'0'=>'Instruction Sheets',
	   							'1'=>'Payment Informations'	   							
	   						);
	   						foreach($sheetOrderProvided as $key1=>$val1){
	   							if($excel->boundsheets[$key1]['name'] != $val1){
	   								$sheetNameOrder = 1;
	   							}
	   						}
	   					if((!$sheetNameOrder)){
	   							$this->loadModel('AcrClient');	   							
	   							
							for($i=1; $i<$nr_sheets; $i++) {
								if($excel->boundsheets[$i]['name'] == $sheetOrderProvided[$i]){																			
		 							$paymentInformationSuccessCount = 0;			 						
									if($excel->boundsheets[$i]['name'] == 'Payment Informations'){
										$paymentInformation = $this->sheetData($excel->sheets[$i],$excel->boundsheets[$i]['name']);
									}											
									foreach($paymentInformation as $key=>$informations){											
										$subscriberId = $this->Session->read('Auth.User.sbs_subscriber_id');																					
										$invoice_no   = $informations['Invoice Number']; 
										// get invoice details and pass as parameter	
										$invocedetailArr        = $this->AcrClientInvoice->getInvoiceByInvoiceNumber($invoice_no, $subscriberId);
										$acr_client_invoice_id  = $invocedetailArr['id'];
										$acr_client_id          = $invocedetailArr['acr_client_id'];	
										// get payment method id by name and pass as a parameter
										
										$newPaymentId    	    = $this->AcrInvoicePaymentDetail->importPayment($subscriberId,$informations,$acr_client_invoice_id,$acr_client_id);
											if($newPaymentId){
												if($newPaymentId['Success']){
														$paymentInformationSuccessCount++;
												}else{
													$errorMessage[$key]['Payment Sl No']     = $informations['Client Sl No.'];
													$errorMessage[$key]['Invoice Number']    = $informations['Invoice Number'];													
													$errorMessage[$key]['Error Message'] 	 = $newClientId['error'];
												}
										}
								  } 										
								} else{
										$this->Session->setFlash(('<div class="alert alert-danger">'.__('Please use the default excel format,sheet name and sheet order').'</div>'));
									}
							}
	    						$this->set(compact('paymentInformationSuccessCount','errorMessage','contactError','clientContactInformation'));	   						
							
						}else{
	   							$this->Session->setFlash(('<div class="alert alert-danger">'.__('Please use the default excel format,sheet name and sheet order').'</div>'));
	   						}
	   				}else{
	   					$this->Session->setFlash(('<div class="alert alert-danger">'.__('Data import failed.Please save the excel with .xls').'</div>'));
	  				}
				}elseif(($_FILES['file']['type']) && ($_FILES['file']['type'] != 'application/vnd.ms-excel')){
						$this->Session->setFlash(('<div class="alert alert-danger">'.__('File you tried to import is invalid').'</div>'));
				}elseif(empty($_FILES['file']['type'])){
						$this->Session->setFlash(('<div class="alert alert-danger">'.__('File you tried to import has no file type.Please try uploading a new excel sheet').'</div>'));
				}
				$fileUploadSuccess = 1;
				$documentPath = WWW_ROOT.$fileOK['urls']['0'];
				unlink($documentPath);
				$this->set(compact('fileUploadSuccess'));
			}			
		}


		public function sheetData($sheet,$sheetName) {
		 	$fieldsArray = $sheet['cells']['1'];
		 	$countRecords = count($sheet['cells']);
		 	foreach($fieldsArray as $key=>$val){
		 		for($i=2;$i<=$countRecords;$i++){
		 			if($sheetName == 'Payment Informations'){
		 				//arrayFor Payment
		 				if($val=='Payment Sl No.'){
		 					$dataPayment[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Invoice Number'){
			 				$dataPayment[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Reciept Amount'){
			 				$dataPayment[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Payment Date'){
			 				$dataPayment[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Payment Method'){
			 				$dataPayment[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Reference No.'){
			 				$dataPayment[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Notes'){
			 				$dataPayment[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Send Payment Note'){
			 				$dataPayment[$i][$val] = $sheet['cells'][$i][$key];
			 			}else{
			 				$dataPayment[$i]['fieldMissing'] = '1';
			 			}
		 			}		 			
		 		}
		 	}
		 	if ($dataPayment) {
		 		return $dataPayment;
		 	} else {
		 		return false;
		 	}
		}
	
}