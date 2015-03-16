<?php
/**
 * AcrClientInvoiceFixture
 *
 */
class AcrClientInvoiceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'invoice_number' => array('type' => 'integer', 'null' => false, 'default' => null),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'invoiced_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'purchase_order_no' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'due_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'terms' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'discount_percent' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
		'notes' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sub_total' => array('type' => 'float', 'null' => false, 'default' => null),
		'tax_total' => array('type' => 'float', 'null' => false, 'default' => null),
		'func_currency_total' => array('type' => 'float', 'null' => false, 'default' => null, 'comment' => 'Application currency total amount'),
		'exchange_rate' => array('type' => 'float', 'null' => true, 'default' => '1'),
		'acr_client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'inv_inventory_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'sbs_subscriber_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'invoice_total' => array('type' => 'float', 'null' => true, 'default' => null, 'comment' => 'Client currency total amount'),
		'invoice_currency_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'comment' => 'Client currecncy code', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_client_invoices_acr_clients1' => array('column' => 'acr_client_id', 'unique' => 0),
			'fk_client_invoices_inv_inventories1' => array('column' => 'inv_inventory_id', 'unique' => 0),
			'fk_acr_client_invoices_sbs_subscribers1' => array('column' => 'sbs_subscriber_id', 'unique' => 0)
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
			'invoice_number' => 1,
			'description' => 'Lorem ipsum dolor sit amet',
			'invoiced_date' => '2014-05-21',
			'purchase_order_no' => 'Lorem ipsum dolor sit amet',
			'due_date' => '2014-05-21',
			'terms' => 'Lorem ipsum dolor sit amet',
			'discount_percent' => 1,
			'notes' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'sub_total' => 1,
			'tax_total' => 1,
			'func_currency_total' => 1,
			'exchange_rate' => 1,
			'acr_client_id' => 1,
			'inv_inventory_id' => 1,
			'sbs_subscriber_id' => 1,
			'invoice_total' => 1,
			'invoice_currency_code' => 'Lorem ip'
		),
	);

}
