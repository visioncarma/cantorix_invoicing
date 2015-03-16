<?php
/**
 * AcrInvoiceCustomValueFixture
 *
 */
class AcrInvoiceCustomValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'data' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'acr_client_invoice_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'acr_invoice_custom_field_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_invoice_custom_values_acr_client_invoices1' => array('column' => 'acr_client_invoice_id', 'unique' => 0),
			'fk_acr_invoice_custom_values_acr_invoice_custom_fields1' => array('column' => 'acr_invoice_custom_field_id', 'unique' => 0)
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
			'data' => 'Lorem ipsum dolor sit amet',
			'acr_client_invoice_id' => 1,
			'acr_invoice_custom_field_id' => 1
		),
	);

}
