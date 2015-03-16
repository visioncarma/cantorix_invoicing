<?php
/**
 * AcrInvoicePaymentDetailFixture
 *
 */
class AcrInvoicePaymentDetailFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'payment_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'refrence_no' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'notes' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'acr_client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'acr_client_invoice_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'sbs_subscriber_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_invoice_payment_details_acr_clients1' => array('column' => 'acr_client_id', 'unique' => 0),
			'fk_invoice_payment_details_acr_client_invoices1' => array('column' => 'acr_client_invoice_id', 'unique' => 0),
			'fk_acr_invoice_payment_details_sbs_subscribers1' => array('column' => 'sbs_subscriber_id', 'unique' => 0)
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
			'payment_date' => '2014-05-21',
			'refrence_no' => 'Lorem ipsum dolor sit amet',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'acr_client_id' => 1,
			'acr_client_invoice_id' => 1,
			'sbs_subscriber_id' => 1
		),
	);

}
