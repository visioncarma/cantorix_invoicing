<?php
App::uses('AppModel', 'Model');
/**
 * SlsQuotationCustomValue Model
 *
 * @property SlsQuotationCustomField $SlsQuotationCustomField
 * @property SlsQuotation $SlsQuotation
 */
class SlsQuotationCustomValue extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'AcrInvoiceCustomField' => array(
			'className' => 'AcrInvoiceCustomField',
			'foreignKey' => 'acr_invoice_custom_field_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SlsQuotation' => array(
			'className' => 'SlsQuotation',
			'foreignKey' => 'sls_quotation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function getCustomValues($sls_quotation_id = NULL) {
		return $this->find('list',array('conditions'=>array('sls_quotation_id'=>$sls_quotation_id),'fields'=>array('acr_invoice_custom_field_id','data')));
	}
	
	public function getCustomValueIDs($sls_quotation_id = NULL) {
		return $this->find('list',array('conditions'=>array('sls_quotation_id'=>$sls_quotation_id),'fields'=>array('acr_invoice_custom_field_id','id')));
	}
}
