<?php
/**
 * AcpInventoryExpenseFixture
 *
 */
class AcpInventoryExpenseFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'quantity' => array('type' => 'integer', 'null' => false, 'default' => null),
		'cost_price' => array('type' => 'float', 'null' => false, 'default' => null),
		'total_amount' => array('type' => 'float', 'null' => false, 'default' => null),
		'func_curr_amount' => array('type' => 'float', 'null' => false, 'default' => null, 'comment' => 'Application currency amount'),
		'due_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'transaction_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'inv_inventory_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'acp_expense_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'sbs_subscriber_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'invoice_amount' => array('type' => 'float', 'null' => true, 'default' => null),
		'invoice_currency_code' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 10, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_inventory_expenses_inv_inventories1' => array('column' => 'inv_inventory_id', 'unique' => 0),
			'fk_acp_inventory_expenses_acp_expenses1' => array('column' => 'acp_expense_id', 'unique' => 0),
			'fk_acp_inventory_expenses_sbs_subscribers1' => array('column' => 'sbs_subscriber_id', 'unique' => 0)
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
			'cost_price' => 1,
			'total_amount' => 1,
			'func_curr_amount' => 1,
			'due_date' => '2014-05-21',
			'transaction_id' => 'Lorem ipsum dolor sit amet',
			'inv_inventory_id' => 1,
			'acp_expense_id' => 1,
			'sbs_subscriber_id' => 1,
			'invoice_amount' => 1,
			'invoice_currency_code' => 'Lorem ip'
		),
	);

}
