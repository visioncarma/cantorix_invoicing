<?php
App::uses('AppModel', 'Model');
/**
 * AcrInvoicePaymentDetailCustomFieldValue Model
 *
 * @property AcrInvoicePaymentDetail $AcrInvoicePaymentDetail
 * @property AcrInvoicePaymentDetailCustomField $AcrInvoicePaymentDetailCustomField
 */
class AcrInvoicePaymentDetailCustomFieldValue extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'AcrInvoicePaymentDetail' => array(
			'className' => 'AcrInvoicePaymentDetail',
			'foreignKey' => 'acr_invoice_payment_detail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AcrInvoicePaymentDetailCustomField' => array(
			'className' => 'AcrInvoicePaymentDetailCustomField',
			'foreignKey' => 'acr_invoice_payment_detail_custom_field_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
