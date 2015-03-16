<?php
App::uses('AcrClientCustomValue', 'Model');

/**
 * AcrClientCustomValue Test Case
 *
 */
class AcrClientCustomValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acr_client_custom_value',
		'app.acr_client',
		'app.acr_client_custom_field',
		'app.sbs_subscriber'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcrClientCustomValue = ClassRegistry::init('AcrClientCustomValue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcrClientCustomValue);

		parent::tearDown();
	}

}
