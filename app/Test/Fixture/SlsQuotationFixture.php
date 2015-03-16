<?php
/**
 * SlsQuotationFixture
 *
 */
class SlsQuotationFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'quotation_no' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'exchange_rate' => array('type' => 'float', 'null' => true, 'default' => '1'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'issue_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'purchase_order_no' => array('type' => 'integer', 'null' => true, 'default' => null),
		'expiry_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'notes' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sub_total' => array('type' => 'float', 'null' => true, 'default' => null),
		'tax_total' => array('type' => 'float', 'null' => true, 'default' => null),
		'func_estimate_total' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'Application currency total'),
		'acr_client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'sbs_subscriber_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'invoice_amount' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'Client currency total'),
		'invoice_currency_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 15, 'collate' => 'latin1_swedish_ci', 'comment' => 'Client currency code', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_quotations_acr_clients1' => array('column' => 'acr_client_id', 'unique' => 0),
			'fk_sls_quotations_sbs_subscribers1' => array('column' => 'sbs_subscriber_id', 'unique' => 0)
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
			'quotation_no' => 'Lorem ipsum dolor sit amet',
			'exchange_rate' => 1,
			'description' => 'Lorem ipsum dolor sit amet',
			'issue_date' => '2014-05-21',
			'purchase_order_no' => 1,
			'expiry_date' => '2014-05-21',
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'sub_total' => 1,
			'tax_total' => 1,
			'func_estimate_total' => 1,
			'acr_client_id' => 1,
			'sbs_subscriber_id' => 1,
			'invoice_amount' => 1,
			'invoice_currency_code' => 'Lorem ipsum d'
		),
	);

}
