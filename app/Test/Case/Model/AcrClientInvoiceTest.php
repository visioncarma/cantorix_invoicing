<?php
App::uses('AcrClientInvoice', 'Model');

/**
 * AcrClientInvoice Test Case
 *
 */
class AcrClientInvoiceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acr_client_invoice',
		'app.acr_client',
		'app.inv_inventory',
		'app.sbs_subscriber',
		'app.acr_client_recurring_invoice',
		'app.acr_invoice_custom_value',
		'app.acr_invoice_detail',
		'app.acr_invoice_payment_detail'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcrClientInvoice = ClassRegistry::init('AcrClientInvoice');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcrClientInvoice);

		parent::tearDown();
	}

}
