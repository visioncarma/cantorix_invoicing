<?php
/**
 * SlsQuotationCustomValueFixture
 *
 */
class SlsQuotationCustomValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'data' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sls_quotation_custom_field_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'sls_quotation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_quotation_custom_values_sls_quotation_custom_fields1' => array('column' => 'sls_quotation_custom_field_id', 'unique' => 0),
			'fk_sls_quotation_custom_values_sls_quotations1' => array('column' => 'sls_quotation_id', 'unique' => 0)
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
			'sls_quotation_custom_field_id' => 1,
			'sls_quotation_id' => 1
		),
	);

}
