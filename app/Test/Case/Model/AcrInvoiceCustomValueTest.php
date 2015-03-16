<?php
App::uses('AcrInvoiceCustomValue', 'Model');

/**
 * AcrInvoiceCustomValue Test Case
 *
 */
class AcrInvoiceCustomValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acr_invoice_custom_value',
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
		'app.acr_invoice_detail',
		'app.acr_invoice_custom_field'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcrInvoiceCustomValue = ClassRegistry::init('AcrInvoiceCustomValue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcrInvoiceCustomValue);

		parent::tearDown();
	}

}
