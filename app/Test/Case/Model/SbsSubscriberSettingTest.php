<?php
App::uses('SbsSubscriberSetting', 'Model');

/**
 * SbsSubscriberSetting Test Case
 *
 */
class SbsSubscriberSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sbs_subscriber_setting',
		'app.sbs_subscriber'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SbsSubscriberSetting = ClassRegistry::init('SbsSubscriberSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SbsSubscriberSetting);

		parent::tearDown();
	}

}
