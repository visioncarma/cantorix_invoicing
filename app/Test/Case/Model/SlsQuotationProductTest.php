<?php
App::uses('SlsQuotationProduct', 'Model');

/**
 * SlsQuotationProduct Test Case
 *
 */
class SlsQuotationProductTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sls_quotation_product',
		'app.sls_quotation',
		'app.inv_inventory',
		'app.sbs_subscriber',
		'app.cpn_subscription_plan',
		'app.sbs_subscriber_organization_detail',
		'app.sbs_financial_year',
		'app.sbs_language',
		'app.acr_client',
		'app.sbs_currency',
		'app.acr_client_contact',
		'app.acr_client_custom_value',
		'app.acr_client_custom_field',
		'app.acr_client_invoice',
		'app.acr_client_recurring_invoice',
		'app.acr_invoice_custom_value',
		'app.acr_invoice_custom_field',
		'app.acr_invoice_detail',
		'app.sbs_subscriber_tax',
		'app.sbs_subscriber_tax_group_mapping',
		'app.sbs_subscriber_tax_group',
		'app.acr_invoice_payment_detail',
		'app.acr_inventory_invoice',
		'app.acp_inventory_expense',
		'app.transaction',
		'app.acp_expense',
		'app.acp_expense_category',
		'app.aco',
		'app.aro',
		'app.aros_aco',
		'app.permission',
		'app.cpn_subscriber_invoice_detail',
		'app.cpn_recurring_invoice',
		'app.sbs_subscriber_setting',
		'app.sls_quotation_custom_field',
		'app.sls_quotation_custom_value',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SlsQuotationProduct = ClassRegistry::init('SlsQuotationProduct');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SlsQuotationProduct);

		parent::tearDown();
	}

}
