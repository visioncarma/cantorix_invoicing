<?php
App::uses('AppModel', 'Model');
App::import('Component', 'SessionComponent');
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
	public function addCreditNote($creditAmount,$acr_client_id,$acr_client_invoice_id,$sbs_subscriber_id,$paymentId,$clientCurCode) {
		if($creditAmount && $acr_client_id && $acr_client_invoice_id && $sbs_subscriber_id && $paymentId){
			
			$saveDetail->data = null;
			$this->create();
           
            $saveDetail->data['AcrClientCreditnote']['credit_no']              = $this->generateCreditNumber($sbs_subscriber_id);
			$saveDetail->data['AcrClientCreditnote']['balance_amount']         = $creditAmount;            
            $saveDetail->data['AcrClientCreditnote']['status']                 = 'Open';
        	$saveDetail->data['AcrClientCreditnote']['func_sub_total']         = $creditAmount;
        	$saveDetail->data['AcrClientCreditnote']['func_tax_total']         = 0;
        	$saveDetail->data['AcrClientCreditnote']['func_total']             = $creditAmount; 
        	$saveDetail->data['AcrClientCreditnote']['client_currency_code']   = $clientCurCode;
            $saveDetail->data['AcrClientCreditnote']['amount'] 							= 	$creditAmount; 		
			$saveDetail->data['AcrClientCreditnote']['acr_client_id']					=	$acr_client_id;			
			$saveDetail->data['AcrClientCreditnote']['acr_client_invoice_id']			=	$acr_client_invoice_id; 			
			$saveDetail->data['AcrClientCreditnote']['sbs_subscriber_id']				=	$sbs_subscriber_id; 
			$saveDetail->data['AcrClientCreditnote']['date_created']					=	date('Y-m-d');			
			$saveDetail->data['AcrClientCreditnote']['datemodified']					=	date('Y-m-d');
			$saveDetail->data['AcrClientCreditnote']['acr_invoice_payment_detail_id']   =	$paymentId;
		 	
			if($this->save($saveDetail->data)){
			    $lastInsertID = $this->getLastInsertID();
			    $this->addCreditProduct($lastInsertID,$creditAmount);
				return true;
			}else{
				return false;
			}
		}		
	}

    public function addCreditProduct($creditID = null, $creditAmount = null) {
        $AcrClientCreditnoteProduct = ClassRegistry::init('AcrClientCreditnoteProduct');
        $saveProduct['AcrClientCreditnoteProduct']['inv_inventory_id'] = -1;
        $saveProduct['AcrClientCreditnoteProduct']['quantity'] = 1;
        $saveProduct['AcrClientCreditnoteProduct']['unit_rate'] = $creditAmount;
        $saveProduct['AcrClientCreditnoteProduct']['discount_percent'] = 0;
        $saveProduct['AcrClientCreditnoteProduct']['line_total'] = $creditAmount;
        $saveProduct['AcrClientCreditnoteProduct']['acr_client_creditnote_id'] = $creditID;
        $AcrClientCreditnoteProduct->create();
        $AcrClientCreditnoteProduct->save($saveProduct);
        return true;
    }
	
	// edit credit note  for payment 
	public function updateCreditNote($creditNoteId , $creditAmount){
		if($creditNoteId && $creditAmount){
			$updateArray->data['AcrClientCreditnote']['id'] 			= $creditNoteId;
            
            $creditNoteDetail = $this->findById($creditNoteId);
            if($creditNoteDetail['AcrClientCreditnote']['func_tax_total'] == 0) {
                $updateArray->data['AcrClientCreditnote']['func_sub_total'] = ($creditAmount*$creditNoteDetail['AcrClientCreditnote']['exchange_rate']);
            } else {
                $temp = ($creditAmount*$creditNoteDetail['AcrClientCreditnote']['exchange_rate']) - $creditNoteDetail['AcrClientCreditnote']['func_tax_total'];
                $updateArray->data['AcrClientCreditnote']['func_sub_total'] = $temp;  
            }
            $updateArray->data['AcrClientCreditnote']['func_total']     = $updateArray->data['AcrClientCreditnote']['func_sub_total'];
			$updateArray->data['AcrClientCreditnote']['amount'] 		= $creditAmount;
            $newBalance                                                 = $creditAmount - $creditNoteDetail['AcrClientCreditnote']['amount'];
            $updateArray->data['AcrClientCreditnote']['balance_amount'] = $creditNoteDetail['AcrClientCreditnote']['balance_amount'] + $newBalance;
			$updateArray->data['AcrClientCreditnote']['datemodified'] 	= date('Y-m-d');
            $finalBalance                                               = $updateArray->data['AcrClientCreditnote']['balance_amount'];
            $finalTotalAmount                                           = $updateArray->data['AcrClientCreditnote']['amount'];
            if($finalBalance == $finalTotalAmount) {
                $status = 'Open';
                
            } elseif($finalBalance > 0) {
                $status = 'Partially Applied';
            } else {
                $status = 'Applied';
            }
            $updateArray->data['AcrClientCreditnote']['status']         = $status;
            $this->addCreditProduct($creditNoteId,$newBalance);
			if($this->save($updateArray->data)){
				return true;
			} else {
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
			
			$getCreditAmount = $this->find('all',array('conditions'=>array('OR'=>array(array('AcrClientCreditnote.acr_client_id'=>$customerId,'AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId,'AcrClientCreditnote.status'=>'Open'),array('AcrClientCreditnote.acr_client_id'=>$customerId,'AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId,'AcrClientCreditnote.status'=>'Partially Applied')))));
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
			$session 		  = new SessionComponent();
		    $subscriberId 	  =	$session->read('Auth.User.SbsSubscriber.id');
			$getCreditNoteAmount= $this->find('first',array('conditions'=>array('AcrClientCreditnote.id'=>$id, 'AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClientCreditnote.amount')));
			if($getCreditNoteAmount){
				return $getCreditNoteAmount['AcrClientCreditnote']['amount'];
			}else{
				return false;
			}
		}
	}
	
	public function update($acrClientCreditNoteId = null,$amount = null,$status = null){
		if($acrClientCreditNoteId && $amount){
			debug($acrClientCreditNoteId);
			$updateArray->data['AcrClientCreditnote']['id'] 			= $acrClientCreditNoteId;
			$updateArray->data['AcrClientCreditnote']['balance_amount'] = $amount;
			$updateArray->data['AcrClientCreditnote']['status'] 		= $status;
			$updateArray->data['AcrClientCreditnote']['datemodified'] 	= date('Y-m-d');
			debug($updateArray->data);
			if($this->save($updateArray->data)){
				return $acrClientCreditNoteId;
			}else{
				return false;
			}
		}
	}
    
/**
 * @method To generate a creditnote sequence number
 * @author Ganesh
 * @param  Subscriber ID
 * @return Credit note sequence number
 * @version v.1    
 * */    
    public function generateCreditNumber($subscriberId = null) {
        $SbsSubscriberSetting = ClassRegistry::init('SbsSubscriberSetting');
        $settings           = $SbsSubscriberSetting->defaultSettings($subscriberId);
        $creditFormat        = $settings['SbsSubscriberSetting']['credit_note_prefix'];
        if(empty($settings['SbsSubscriberSetting']['credit_note_prefix'])) $creditFormat = 'CDN-';
        $creditInitalNumber = $settings['SbsSubscriberSetting']['credit_note_sequence_number'];
        if(empty($creditInitalNumber)) $creditInitalNumber = '0001';
        $lastCredit          = $this->find('first',array('conditions'=>array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId,'AcrClientCreditnote.credit_no LIKE'=>$creditFormat.'%'),'fields'=>array('credit_no'),'order'=>array('credit_no'=>'Desc')));
        preg_match_all('!\d+!', $lastCredit['AcrClientCreditnote']['credit_no'], $final);
        $fTotalCredit        = $this->find('count',array('conditions'=>array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId,'AcrClientCreditnote.credit_no LIKE'=>$creditFormat.'%')));
        if($fTotalCredit == 0) {
            $newCreditNumber      = $creditFormat.$creditInitalNumber;
        } else {
            $totalCredit         = $final[0][0];
            do {
                $totalCredit++;
                $digitsCount = strlen($final[0][0]);
                $formattedNumber      = sprintf('%0'.$digitsCount.'d', $totalCredit);
                $newCreditNumber      = $creditFormat.$formattedNumber;
                $creditExist = $this->find('first',array('conditions'=>array('AcrClientCreditnote.sbs_subscriber_id'=>$subscriberId,'AcrClientCreditnote.credit_no'=>$newCreditNumber),'fields'=>array('id')));
            } while (!empty($creditExist));
        }
        return $newCreditNumber;
    }


/**
 * @method  Add New Credit
 * @author  Ganesh R
 * @param   Subscriber ID, Form data
 * @return  True/False
 * @version 1.1
 * @since   7 Aug 2014
 * */
    public function addCredit($subsID = NULL, $data = NULL) {
        $taxTotal = 0;
        foreach($data['AcrClientInvoice']['taxValue'] as $taxId=>$taxVal) {
            $taxTotal = $taxTotal + $taxVal;
        }
        $save = NULL;
        $save['AcrClientCreditnote']['credit_no']              = trim($data['AcrClientInvoice']['credit_no']);
        $save['AcrClientCreditnote']['reference_no']           = $data['AcrClientInvoice']['reference_no'];
        $save['AcrClientCreditnote']['exchange_rate']          = $data['AcrClientInvoice']['conversionValue'];
        $save['AcrClientCreditnote']['date_created']           = date('Y-m-d',strtotime(str_replace('/', '-', $data['AcrClientInvoice']['issueDate'])));
        if(!empty($data['AcrClientInvoice']['expiryDate'])) { 
            $save['AcrClientCreditnote']['expiry_date']            = date('Y-m-d',strtotime(str_replace('/', '-', $data['AcrClientInvoice']['expiryDate'])));
        } else {
            $save['AcrClientCreditnote']['expiry_date']            = date('Y-m-d');
        }
        $save['AcrClientCreditnote']['status']                 = 'Open';
        $save['AcrClientCreditnote']['func_sub_total']         = $data['AcrClientInvoice']['subTotal'];
        $save['AcrClientCreditnote']['func_tax_total']         = $taxTotal;
        $save['AcrClientCreditnote']['func_total']             = $data['AcrClientInvoice']['subTotal'] + $taxTotal;
        $save['AcrClientCreditnote']['acr_client_id']          = $data['AcrClientInvoice']['acr_client_id'];
        $save['AcrClientCreditnote']['sbs_subscriber_id']      = $subsID;
        $save['AcrClientCreditnote']['amount']                 = $data['AcrClientInvoice']['invoicetotal'];
        $save['AcrClientCreditnote']['balance_amount']         = $data['AcrClientInvoice']['invoicetotal'];
        $save['AcrClientCreditnote']['client_currency_code']   = $data['AcrClientInvoice']['invoice_currency_code'];
        $this->create();
        if($this->save($save)) {
            $AcrClientCreditnoteProduct = ClassRegistry::init('AcrClientCreditnoteProduct');
            $creditId = $this->getLastInsertID();
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
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['inv_inventory_id']         = $value;
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['inventory_description']    = $data['AcrClientInvoice']['description'][$index];
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['quantity']                 = $data['AcrClientInvoice']['quantity'][$index];
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['unit_rate']                = $data['AcrClientInvoice']['unit_rate'][$index];
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['discount_percent']         = $data['AcrClientInvoice']['discount_percent'][$index];
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['line_total']               = $data['AcrClientInvoice']['line_total_hidden'][$index];
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['acr_client_creditnote_id'] = $creditId;
                    $taxes = $data['AcrClientInvoice']['tax_inventory'][$index];
                    $explodeTax = explode('-', $taxes);
                    if($explodeTax[1]) {
                        $saveInventoryDetails['AcrClientCreditnoteProduct']['sbs_subscriber_tax_group_id'] = $explodeTax[1];
                    }
                    if(empty($explodeTax[1])) {
                        $saveInventoryDetails['AcrClientCreditnoteProduct']['sbs_subscriber_tax_id'] = $data['AcrClientInvoice']['tax_inventory'][$index]; 
                    }
                    $AcrClientCreditnoteProduct->create();
                    $AcrClientCreditnoteProduct->save($saveInventoryDetails);
                }
            }
            return $creditId;
        } else {
            return FALSE;
        }
    }



/**
 * @method  Update Credit Note
 * @author  Ganesh R
 * @param   Subscriber ID, Form data
 * @return  True/False
 * @version 1.1
 * @since   7 Aug 2014
 * */
    public function updateCreditNotes($data = null, $usedCredit = null) {
        $taxTotal = 0;
        foreach($data['AcrClientInvoice']['taxValue'] as $taxId=>$taxVal) {
            $taxTotal = $taxTotal + $taxVal;
        }
        $save = NULL;
        $save['AcrClientCreditnote']['id']                     = trim($data['AcrClientInvoice']['creditID']);
        $save['AcrClientCreditnote']['credit_no']              = $data['AcrClientInvoice']['credit_no'];
        $save['AcrClientCreditnote']['reference_no']           = $data['AcrClientInvoice']['reference_no'];
        $save['AcrClientCreditnote']['exchange_rate']          = $data['AcrClientInvoice']['conversionValue'];
        $save['AcrClientCreditnote']['date_created']           = date('Y-m-d',strtotime(str_replace('/', '-', $data['AcrClientInvoice']['issueDate'])));
        $save['AcrClientCreditnote']['datemodified']           = date('Y-m-d');
        if($data['AcrClientInvoice']['status'] == 'Active') {
            if($usedCredit == $data['AcrClientInvoice']['invoicetotal']) {
                $save['AcrClientCreditnote']['status']         = 'Applied';
            } elseif($usedCredit < $data['AcrClientInvoice']['invoicetotal'] && $usedCredit != 0) {
                $save['AcrClientCreditnote']['status']         = 'Partially Applied';
            } elseif($usedCredit == 0 || $usedCredit == 0.00) {
                $save['AcrClientCreditnote']['status']         = 'Open';    
            }
        } else {
            $save['AcrClientCreditnote']['status']             = 'Void';
        }
        $save['AcrClientCreditnote']['func_sub_total']         = $data['AcrClientInvoice']['subTotal'];
        $save['AcrClientCreditnote']['func_tax_total']         = $taxTotal;
        $save['AcrClientCreditnote']['func_total']             = $data['AcrClientInvoice']['subTotal'] + $taxTotal;
        $save['AcrClientCreditnote']['acr_client_id']          = $data['AcrClientInvoice']['acr_client_id'];
        //$save['AcrClientCreditnote']['sbs_subscriber_id']      = $subsID;
        $save['AcrClientCreditnote']['amount']                 = $data['AcrClientInvoice']['invoicetotal'];
        $save['AcrClientCreditnote']['balance_amount']         = ($data['AcrClientInvoice']['invoicetotal'] - $usedCredit);
        $save['AcrClientCreditnote']['client_currency_code']   = $data['AcrClientInvoice']['invoice_currency_code'];
        if($this->save($save)) {
            $AcrClientCreditnoteProduct = ClassRegistry::init('AcrClientCreditnoteProduct');
            $creditId = $data['AcrClientInvoice']['creditID'];
            foreach ($data['AcrClientInvoice']['inventory'] as $index => $value) {
                if($value) {
                    if(!empty($data['AcrClientInvoice']['product_id'][$index])) {
                        $saveInventoryDetails['AcrClientCreditnoteProduct']['id']  = $data['AcrClientInvoice']['product_id'][$index];
                    } else {
                        $saveInventoryDetails['AcrClientCreditnoteProduct']['id']  = NULL;
                        $AcrClientCreditnoteProduct->create();
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
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['inv_inventory_id']         = $value;
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['inventory_description']    = $data['AcrClientInvoice']['description'][$index];
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['quantity']                 = $data['AcrClientInvoice']['quantity'][$index];
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['unit_rate']                = $data['AcrClientInvoice']['unit_rate'][$index];
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['discount_percent']         = $data['AcrClientInvoice']['discount_percent'][$index];
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['line_total']               = $data['AcrClientInvoice']['line_total_hidden'][$index];
                    $saveInventoryDetails['AcrClientCreditnoteProduct']['acr_client_creditnote_id'] = $creditId;
                    $taxes = $data['AcrClientInvoice']['tax_inventory'][$index];
                    
                    $explodeTax = explode('-', $taxes);
                    if(!empty($explodeTax[1])) {
                        $saveInventoryDetails['AcrClientCreditnoteProduct']['sbs_subscriber_tax_group_id'] = $explodeTax[1];
                        $saveInventoryDetails['AcrClientCreditnoteProduct']['sbs_subscriber_tax_id'] = null;
                    }
                    if(empty($explodeTax[1])) {
                        $saveInventoryDetails['AcrClientCreditnoteProduct']['sbs_subscriber_tax_group_id'] = null;
                        $saveInventoryDetails['AcrClientCreditnoteProduct']['sbs_subscriber_tax_id'] = $data['AcrClientInvoice']['tax_inventory'][$index]; 
                    }

                    $AcrClientCreditnoteProduct->save($saveInventoryDetails);
                }
            }
            foreach($data['AcrClientInvoice']['delete'] as $rowID => $prodID ) {
                if($prodID) {
                    $deleteIDS[$prodID] = $prodID;
                }
            }
            $AcrClientCreditnoteProduct = ClassRegistry::init('AcrClientCreditnoteProduct');
            if(!empty($deleteIDS)) {
                $AcrClientCreditnoteProduct->deleteAll(array('AcrClientCreditnoteProduct.id'=>$deleteIDS),FALSE);
            }
            return $creditId;
        } else {
            return FALSE;
        }        
    }
}
