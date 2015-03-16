<?php
/**
 * AcrInventoryInvoiceFixture
 *
 */
class AcrInventoryInvoiceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'acr_client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'acp_inventory_expense_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_inventory_invoices_acr_clients1' => array('column' => 'acr_client_id', 'unique' => 0),
			'fk_acr_inventory_invoices_acp_inventory_expenses1' => array('column' => 'acp_inventory_expense_id', 'unique' => 0)
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
			'acr_client_id' => 1,
			'acp_inventory_expense_id' => 1
		),
	);

}
