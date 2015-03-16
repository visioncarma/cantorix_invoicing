<?php
/**
 * SbsSubscriberTaxGroupMappingFixture
 *
 */
class SbsSubscriberTaxGroupMappingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'priority' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 4),
		'sbs_subscriber_tax_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'sbs_subscriber_tax_group_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_subscriber_tax_group_mappings_sbs_subscriber_taxes1' => array('column' => 'sbs_subscriber_tax_id', 'unique' => 0),
			'fk_sbs_subscriber_tax_group_mappings_sbs_subscriber_tax_groups1' => array('column' => 'sbs_subscriber_tax_group_id', 'unique' => 0)
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
			'priority' => 1,
			'sbs_subscriber_tax_id' => 1,
			'sbs_subscriber_tax_group_id' => 1
		),
	);

}
