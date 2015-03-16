<?php
App::uses('AppModel', 'Model');
/**
 * AcrInvoiceCustomValue Model
 *
 * @property AcrClientInvoice $AcrClientInvoice
 * @property AcrInvoiceCustomField $AcrInvoiceCustomField
 */
class AcrInvoiceCustomValue extends AppModel {


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
		'AcrInvoiceCustomField' => array(
			'className' => 'AcrInvoiceCustomField',
			'foreignKey' => 'acr_invoice_custom_field_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function addValue($data){
		if($data){
			$saveArray->data = null;
			$this->create();
			$saveArray->data['AcrInvoiceCustomValue']['acr_invoice_custom_field_id'] = $data['acr_invoice_custom_field_id'];
			$saveArray->data['AcrInvoiceCustomValue']['acr_client_invoice_id'] 		 = $data['acr_client_invoice_id'];
			$saveArray->data['AcrInvoiceCustomValue']['data'] 						 = $data['data'];
			if($this->save($saveArray->data)){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public function getFieldValue($customFieldId = null,$invoiceId = null){
		if($customFieldId && $invoiceId){
			$customField = $this->find('list',array('conditions'=>array('AcrInvoiceCustomValue.acr_invoice_custom_field_id'=>$customFieldId,'AcrInvoiceCustomValue.acr_client_invoice_id'=>$invoiceId),'fields'=>array('AcrInvoiceCustomValue.acr_invoice_custom_field_id','AcrInvoiceCustomValue.data')));
			return $customField;
		}else{
			return false;
		}
	}
	
	public function getFieldValueByInvoiceId($invoiceId = null){
		if($invoiceId){
			$customField = $this->find('list',array('conditions'=>array('AcrInvoiceCustomValue.acr_client_invoice_id'=>$invoiceId),'fields'=>array('AcrInvoiceCustomValue.acr_invoice_custom_field_id','AcrInvoiceCustomValue.data')));
			return $customField;
		}else{
			return false;
		}
	}
}
