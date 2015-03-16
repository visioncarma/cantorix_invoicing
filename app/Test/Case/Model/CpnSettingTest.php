<?php
App::uses('CpnSetting', 'Model');

/**
 * CpnSetting Test Case
 *
 */
class CpnSettingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cpn_setting'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CpnSetting = ClassRegistry::init('CpnSetting');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CpnSetting);

		parent::tearDown();
	}

}
