<?php
App::uses('AcrInvoiceDetail', 'Model');

/**
 * AcrInvoiceDetail Test Case
 *
 */
class AcrInvoiceDetailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acr_invoice_detail',
		'app.acr_client_invoice',
		'app.acr_client',
		'app.sbs_language',
		'app.sbs_currency',
		'app.sbs_subscriber',
		'app.acr_client_contact',
		'app.acr_client_custom_value',
		'app.acr_client_custom_field',
		'app.acr_inventory_invoice',
		'app.acp_inventory_expense',
		'app.transaction',
		'app.inv_inventory',
		'app.acp_expense',
		'app.acp_expense_category',
		'app.acr_invoice_payment_detail',
		'app.sls_quotation',
		'app.acr_client_recurring_invoice',
		'app.acr_invoice_custom_value',
		'app.acr_invoice_custom_field',
		'app.sbs_subscriber_tax',
		'app.sbs_subscriber_tax_group'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcrInvoiceDetail = ClassRegistry::init('AcrInvoiceDetail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcrInvoiceDetail);

		parent::tearDown();
	}

}
