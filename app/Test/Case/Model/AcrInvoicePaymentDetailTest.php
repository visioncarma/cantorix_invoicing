<?php
App::uses('AcrInvoicePaymentDetail', 'Model');

/**
 * AcrInvoicePaymentDetail Test Case
 *
 */
class AcrInvoicePaymentDetailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acr_invoice_payment_detail',
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
		'app.acr_invoice_custom_field',
		'app.acr_invoice_detail',
		'app.sbs_subscriber_tax',
		'app.sbs_subscriber_tax_group',
		'app.acr_inventory_invoice',
		'app.acp_inventory_expense',
		'app.transaction',
		'app.acp_expense',
		'app.acp_expense_category',
		'app.sls_quotation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcrInvoicePaymentDetail = ClassRegistry::init('AcrInvoicePaymentDetail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcrInvoicePaymentDetail);

		parent::tearDown();
	}

}
