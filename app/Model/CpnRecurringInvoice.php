<?php
App::uses('AppModel', 'Model');
/**
 * CpnRecurringInvoice Model
 *
 * @property CpnSubscriberInvoiceDetail $CpnSubscriberInvoiceDetail
 */
class CpnRecurringInvoice extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CpnSubscriberInvoiceDetail' => array(
			'className' => 'CpnSubscriberInvoiceDetail',
			'foreignKey' => 'cpn_subscriber_invoice_detail_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
