<?php
/**
 * CpnSubscriptionPlanFixture
 *
 */
class CpnSubscriptionPlanFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 155, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'validity' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'no_of_staffs' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 6),
		'no_of_clients' => array('type' => 'integer', 'null' => true, 'default' => null),
		'no_of_invoices' => array('type' => 'biginteger', 'null' => true, 'default' => null),
		'cost' => array('type' => 'float', 'null' => false, 'default' => null),
		'deletion_days' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'archieve_days' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'type' => 'Lorem ipsum dolor sit amet',
			'validity' => 'Lorem ipsum dolor sit amet',
			'no_of_staffs' => 1,
			'no_of_clients' => 1,
			'no_of_invoices' => '',
			'cost' => 1,
			'deletion_days' => 1,
			'archieve_days' => 1
		),
	);

}
