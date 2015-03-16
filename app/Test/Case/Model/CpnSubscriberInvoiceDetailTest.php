<?php
App::uses('CpnSubscriberInvoiceDetail', 'Model');

/**
 * CpnSubscriberInvoiceDetail Test Case
 *
 */
class CpnSubscriberInvoiceDetailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cpn_subscriber_invoice_detail',
		'app.sbs_subscriber',
		'app.cpn_recurring_invoice'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CpnSubscriberInvoiceDetail = ClassRegistry::init('CpnSubscriberInvoiceDetail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CpnSubscriberInvoiceDetail);

		parent::tearDown();
	}

}
