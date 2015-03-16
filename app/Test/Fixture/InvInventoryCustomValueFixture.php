<?php
/**
 * InvInventoryCustomValueFixture
 *
 */
class InvInventoryCustomValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'data' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'inv_inventory_custom_field_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'inv_inventory_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'inv_inventory_custom_field_id' => array('column' => 'inv_inventory_custom_field_id', 'unique' => 0),
			'inv_inventory_id' => array('column' => 'inv_inventory_id', 'unique' => 0)
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
			'data' => 'Lorem ipsum dolor sit amet',
			'inv_inventory_custom_field_id' => 1,
			'inv_inventory_id' => 1
		),
	);

}
