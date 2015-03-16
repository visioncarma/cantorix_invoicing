<?php
/**
 * CpnSubscriberInvoiceDetailFixture
 *
 */
class CpnSubscriberInvoiceDetailFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'invoice_no' => array('type' => 'integer', 'null' => false, 'default' => null),
		'invoiced_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'invoice_due_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'paid_amount' => array('type' => 'float', 'null' => true, 'default' => null),
		'paid_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'sbs_subscriber_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_subscriber_invoice_details_sbs_subscribers1' => array('column' => 'sbs_subscriber_id', 'unique' => 0)
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
			'invoice_no' => 1,
			'invoiced_date' => '2014-05-21',
			'invoice_due_date' => '2014-05-21',
			'paid_amount' => 1,
			'paid_date' => '2014-05-21',
			'sbs_subscriber_id' => 1
		),
	);

}
