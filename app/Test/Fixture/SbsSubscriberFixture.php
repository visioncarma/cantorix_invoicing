<?php
/**
 * SbsSubscriberFixture
 *
 */
class SbsSubscriberFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 155, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'surname' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 155, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'subscribed_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'home_phone' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'mobile' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'cpn_subscription_plan_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'sbs_subscriber_organization_detail_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'fk_subscribers_cpn_subscription_plans1' => array('column' => 'cpn_subscription_plan_id', 'unique' => 0),
			'fk_subscribers_sbs_subscriber_organization_details1' => array('column' => 'sbs_subscriber_organization_detail_id', 'unique' => 0)
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
			'name' => 'Lorem ipsum dolor sit amet',
			'surname' => 'Lorem ipsum dolor sit amet',
			'subscribed_date' => '2014-05-21',
			'home_phone' => 'Lorem ipsum dolor sit amet',
			'mobile' => 'Lorem ipsum dolor sit amet',
			'cpn_subscription_plan_id' => 1,
			'sbs_subscriber_organization_detail_id' => 1
		),
	);

}
