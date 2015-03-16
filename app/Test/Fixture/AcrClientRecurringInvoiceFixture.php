<?php
/**
 * AcrClientRecurringInvoiceFixture
 *
 */
class AcrClientRecurringInvoiceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'next_invoice_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'last_invoice_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'invoice_start_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'invoice_end_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'payment_frequency' => array('type' => 'integer', 'null' => true, 'default' => null),
		'acr_client_invoice_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_client_recurring_invoices_acr_client_invoices1' => array('column' => 'acr_client_invoice_id', 'unique' => 0)
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
			'next_invoice_date' => '2014-05-21',
			'last_invoice_date' => '2014-05-21',
			'invoice_start_date' => '2014-05-21',
			'invoice_end_date' => '2014-05-21',
			'payment_frequency' => 1,
			'acr_client_invoice_id' => 1
		),
	);

}
