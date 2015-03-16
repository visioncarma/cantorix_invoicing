<?php
App::uses('AcrInvoiceCustomField', 'Model');

/**
 * AcrInvoiceCustomField Test Case
 *
 */
class AcrInvoiceCustomFieldTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acr_invoice_custom_field',
		'app.sbs_subscriber',
		'app.acr_invoice_custom_value'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcrInvoiceCustomField = ClassRegistry::init('AcrInvoiceCustomField');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcrInvoiceCustomField);

		parent::tearDown();
	}

}
