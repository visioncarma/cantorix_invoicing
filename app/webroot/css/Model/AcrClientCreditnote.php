<?php
App::uses('AppModel', 'Model');
/**
 * AcrClientCreditnote Model

 */
class AcrClientCreditnote extends AppModel {


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
		'AcrInvoicePaymentDetail' => array(
			'className' => 'AcrInvoicePaymentDetail',
			'foreignKey' => 'acr_invoice_payment_detail_id',
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
	
	// add credit note for payment
	public function addCreditNote($creditAmount,$acr_client_id,$acr_client_invoice_id,$sbs_subscriber_id,$paymentId) {
		if($creditAmount && $acr_client_id && $acr_client_invoice_id && $sbs_subscriber_id && $paymentId){
			
			$saveDetail->data = null;
			$this->create();
			$saveDetail->data['amount'] 						= 	$creditAmount; 		
			$saveDetail->data['acr_client_id']					=	$acr_client_id;			
			$saveDetail->data['acr_client_invoice_id']			=	$acr_client_invoice_id; 			
			$saveDetail->data['sbs_subscriber_id']				=	$sbs_subscriber_id; 
			$saveDetail->data['date_created']					=	date('Y-m-d');			
			$saveDetail->data['datemodified']					=	date('Y-m-d');
			$saveDetail->data['acr_invoice_payment_detail_id']  =	$paymentId;
		 	
			if($this->save($saveDetail->data)){
				return true;
			}else{
				return false;
			}
		}		
	}
	
	// edit credit note  for payment 
	public function updateCreditNote($creditNoteId , $creditAmount){
		if($creditNoteId && $creditAmount){
			$updateArray->data['AcrClientCreditnote']['id'] 			= $creditNoteId;
			$updateArray->data['AcrClientCreditnote']['amount'] 		= $creditAmount;
			$updateArray->data['AcrClientCreditnote']['datemodified'] 	= date('Y-m-d');
			if($this->save($updateArray->data)){
				return true;
			}else{
				return false;
			}
		}
	}
	
	// delete credit note for payment
	public function deleteCreditNote($id = null) {		
		if($id) {					
			$this->id = $id;			
			if ($this->delete()) {				
				return true;
			} else {
				return false;
			}
		}
	}
	
	
	public function getCreditByClient($customerId = null,$subscriberId = null){
		if($customerId && $subscriberId){
			$getCreditAmount = $this->find('all',array('conditions'=>array('AcrClientCreditnote.acr_client_id'=>$customerId,'AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId)));
			if($getCreditAmount){
				return $getCreditAmount;
			}else{
				return false;
			}
		}
	}
	
	// credit note id by payment id
	public function getCreditByPaymetId($paymentId = null,$subscriberId = null){
		if($paymentId && $subscriberId){
			$getCreditNoteId = $this->find('first',array('conditions'=>array('AcrClientCreditnote.acr_invoice_payment_detail_id'=>$paymentId,'AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClientCreditnote.id')));
			if($getCreditNoteId){
				return $getCreditNoteId['AcrClientCreditnote']['id'];
			}else{
				return false;
			}
		}
	}
	
	// credit note amount by credit note id
	public function getCreditAmountById($id = null){
		if($id){
			$getCreditNoteAmount= $this->find('first',array('conditions'=>array('AcrClientCreditnote.id'=>$id),'fields'=>array('AcrClientCreditnote.amount')));
			if($getCreditNoteAmount){
				return $getCreditNoteAmount['AcrClientCreditnote']['amount'];
			}else{
				return false;
			}
		}
	}
	
	public function update($acrClientCreditNoteId = null,$amount = null){
		if($acrClientCreditNoteId && $amount){
			$updateArray->data['AcrClientCreditnote']['id'] 			= $acrClientCreditNoteId;
			$updateArray->data['AcrClientCreditnote']['amount'] 		= $amount;
			$updateArray->data['AcrClientCreditnote']['datemodified'] 	= date('Y-m-d');
			if($this->save($updateArray->data)){
				return $acrClientCreditNoteId;
			}else{
				return false;
			}
		}
	}
	
	
}
