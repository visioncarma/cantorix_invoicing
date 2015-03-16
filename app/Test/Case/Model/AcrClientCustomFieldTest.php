<?php
App::uses('AcrClientCustomField', 'Model');

/**
 * AcrClientCustomField Test Case
 *
 */
class AcrClientCustomFieldTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acr_client_custom_field',
		'app.sbs_subscriber',
		'app.acr_client_custom_value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcrClientCustomField = ClassRegistry::init('AcrClientCustomField');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcrClientCustomField);

		parent::tearDown();
	}

}
