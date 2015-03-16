<?php
/**
 * CpnRecurringInvoiceFixture
 *
 */
class CpnRecurringInvoiceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'payment_period' => array('type' => 'integer', 'null' => true, 'default' => null),
		'payment_frequency' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'cpn_subscriber_invoice_detail_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_cpn_recurring_invoices_cpn_subscriber_invoice_details1' => array('column' => 'cpn_subscriber_invoice_detail_id', 'unique' => 0)
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
			'payment_period' => 1,
			'payment_frequency' => 1,
			'cpn_subscriber_invoice_detail_id' => 1
		),
	);

}
