<?php
App::uses('AcrInventoryInvoice', 'Model');

/**
 * AcrInventoryInvoice Test Case
 *
 */
class AcrInventoryInvoiceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acr_inventory_invoice',
		'app.acr_client',
		'app.sbs_language',
		'app.sbs_currency',
		'app.sbs_subscriber',
		'app.acr_client_contact',
		'app.acr_client_custom_value',
		'app.acr_client_custom_field',
		'app.acr_client_invoice',
		'app.inv_inventory',
		'app.acr_client_recurring_invoice',
		'app.acr_invoice_custom_value',
		'app.acr_invoice_detail',
		'app.acr_invoice_payment_detail',
		'app.sls_quotation',
		'app.acp_inventory_expense',
		'app.transaction',
		'app.acp_expense',
		'app.acp_expense_category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcrInventoryInvoice = ClassRegistry::init('AcrInventoryInvoice');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcrInventoryInvoice);

		parent::tearDown();
	}

}
