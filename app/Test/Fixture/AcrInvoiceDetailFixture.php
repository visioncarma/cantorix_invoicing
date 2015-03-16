<?php
/**
 * AcrInvoiceDetailFixture
 *
 */
class AcrInvoiceDetailFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => null),
		'unit_rate' => array('type' => 'float', 'null' => false, 'default' => null),
		'discount_percent' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'line_total' => array('type' => 'float', 'null' => false, 'default' => null),
		'acr_client_invoice_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'sbs_subscriber_tax_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'sbs_subscriber_tax_group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_invoice_details_acr_client_invoices1' => array('column' => 'acr_client_invoice_id', 'unique' => 0),
			'fk_acr_invoice_details_sbs_subscriber_taxes1' => array('column' => 'sbs_subscriber_tax_id', 'unique' => 0),
			'fk_acr_invoice_details_sbs_subscriber_tax_groups1' => array('column' => 'sbs_subscriber_tax_group_id', 'unique' => 0)
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
			'quantity' => 1,
			'unit_rate' => 1,
			'discount_percent' => 1,
			'line_total' => 1,
			'acr_client_invoice_id' => 1,
			'sbs_subscriber_tax_id' => 1,
			'sbs_subscriber_tax_group_id' => 1
		),
	);

}
