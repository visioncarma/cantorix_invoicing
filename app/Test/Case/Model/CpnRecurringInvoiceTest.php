<?php
App::uses('CpnRecurringInvoice', 'Model');

/**
 * CpnRecurringInvoice Test Case
 *
 */
class CpnRecurringInvoiceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cpn_recurring_invoice',
		'app.cpn_subscriber_invoice_detail'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CpnRecurringInvoice = ClassRegistry::init('CpnRecurringInvoice');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CpnRecurringInvoice);

		parent::tearDown();
	}

}
