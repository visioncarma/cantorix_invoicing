<?php
/**
 * InvInventoryUnitTypeFixture
 *
 */
class InvInventoryUnitTypeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'type_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sbs_subscriber_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'unique'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'sbs_subscriber_id' => array('column' => 'sbs_subscriber_id', 'unique' => 1)
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
			'type_name' => 'Lorem ipsum dolor sit amet',
			'sbs_subscriber_id' => 1
		),
	);

}
