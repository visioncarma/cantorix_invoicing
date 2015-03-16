<?php
/**
 * AcrInvoicePaymentDetailCustomFieldValueFixture
 *
 */
class AcrInvoicePaymentDetailCustomFieldValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'data' => array('type' => 'integer', 'null' => false, 'default' => null),
		'acr_invoice_payment_detail_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'acr_invoice_payment_detail_custom_field_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'data' => 1,
			'acr_invoice_payment_detail_id' => 1,
			'acr_invoice_payment_detail_custom_field_id' => 1
		),
	);

}
