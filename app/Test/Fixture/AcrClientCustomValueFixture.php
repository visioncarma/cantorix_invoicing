<?php
/**
 * AcrClientCustomValueFixture
 *
 */
class AcrClientCustomValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'data' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'acr_client_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'acr_client_custom_field_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_client_custom_values_acr_clients1' => array('column' => 'acr_client_id', 'unique' => 0),
			'fk_client_custom_values_acr_client_custom_fields1' => array('column' => 'acr_client_custom_field_id', 'unique' => 0)
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
			'acr_client_id' => 1,
			'acr_client_custom_field_id' => 1
		),
	);

}
