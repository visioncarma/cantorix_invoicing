<?php
App::uses('AcrClientContact', 'Model');

/**
 * AcrClientContact Test Case
 *
 */
class AcrClientContactTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acr_client_contact',
		'app.acr_client'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcrClientContact = ClassRegistry::init('AcrClientContact');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcrClientContact);

		parent::tearDown();
	}

}
