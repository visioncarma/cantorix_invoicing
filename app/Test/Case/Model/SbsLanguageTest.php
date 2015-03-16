<?php
App::uses('SbsLanguage', 'Model');

/**
 * SbsLanguage Test Case
 *
 */
class SbsLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sbs_language',
		'app.acr_client',
		'app.sbs_currency',
		'app.sbs_subscriber_organization_detail',
		'app.sbs_subscriber',
		'app.acr_client_contact',
		'app.acr_client_custom_value',
		'app.acr_client_custom_field',
		'app.acr_client_invoice',
		'app.inv_inventory',
		'app.acp_inventory_expense',
		'app.transaction',
		'app.acp_expense',
		'app.acp_expense_category',
		'app.acr_inventory_invoice',
		'app.sls_quotation_product',
		'app.acr_client_recurring_invoice',
		'app.acr_invoice_custom_value',
		'app.acr_invoice_custom_field',
		'app.acr_invoice_detail',
		'app.sbs_subscriber_tax',
		'app.sbs_subscriber_tax_group',
		'app.acr_invoice_payment_detail',
		'app.sls_quotation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SbsLanguage = ClassRegistry::init('SbsLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SbsLanguage);

		parent::tearDown();
	}

}
