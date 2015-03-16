<?php
    App::uses('AppModel', 'Model');
    /**
     * AcrCreditnotePaymentMapping Model
     */
    class AcrCreditnotePaymentMapping extends AppModel {
            
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    
    /**
     * belongsTo associations
     *
     * @var array
     */
     
     public $belongsTo = array(
            'AcrClientInvoice' => array(
                'className' => 'AcrClientInvoice',
                'foreignKey' => 'acr_client_invoice_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            'AcrClientCreditnote' => array(
                'className' => 'AcrClientCreditnote',
                'foreignKey' => 'acr_client_creditnote_id',
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
            'AcrInvoicePaymentDetail' => array(
                'className' => 'AcrInvoicePaymentDetail',
                'foreignKey' => 'acr_invoice_payment_detail_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            )
        );   
		
		public function addMapping($updateCreditNoteMapping = null){
			debug($updateCreditNoteMapping);
			if($updateCreditNoteMapping){
				$this->create();
				
				if($this->save($updateCreditNoteMapping)){
					debug('123');
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		} 
    }
?>