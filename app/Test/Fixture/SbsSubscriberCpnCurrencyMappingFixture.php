<?php
/**
 * SbsSubscriberCpnCurrencyMappingFixture
 *
 */
class SbsSubscriberCpnCurrencyMappingFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'sbs_subscriber_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'cpn_currency_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'sbs_subscriber_id' => array('column' => 'sbs_subscriber_id', 'unique' => 0),
			'cpn_currency_id' => array('column' => 'cpn_currency_id', 'unique' => 0)
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
			'sbs_subscriber_id' => 1,
			'cpn_currency_id' => 1
		),
	);

}
