<?php
App::uses('AcrInvoicePaymentDetailCustomFieldValue', 'Model');

/**
 * AcrInvoicePaymentDetailCustomFieldValue Test Case
 *
 */
class AcrInvoicePaymentDetailCustomFieldValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acr_invoice_payment_detail_custom_field_value',
		'app.acr_invoice_payment_detail',
		'app.acr_client',
		'app.cpn_language',
		'app.sbs_subscriber_organization_detail',
		'app.cpn_financial_year',
		'app.cpn_currency',
		'app.sbs_subscriber',
		'app.cpn_subscription_plan',
		'app.aco',
		'app.aro',
		'app.permission',
		'app.acp_expense_category',
		'app.acp_expense',
		'app.acp_inventory_expense',
		'app.inv_inventory',
		'app.sbs_subscriber_tax',
		'app.acr_invoice_detail',
		'app.acr_client_invoice',
		'app.sbs_subscriber_payment_term',
		'app.acr_client_recurring_invoice',
		'app.acr_invoice_custom_value',
		'app.acr_invoice_custom_field',
		'app.sbs_subscriber_tax_group',
		'app.sbs_subscriber_tax_group_mapping',
		'app.sls_quotation_product',
		'app.sls_quotation',
		'app.sls_quotation_custom_value',
		'app.sls_quotation_custom_field',
		'app.inv_inventory_unit_type',
		'app.acr_inventory_invoice',
		'app.acr_client_custom_field',
		'app.acr_client_custom_value',
		'app.cpn_subscriber_invoice_detail',
		'app.cpn_recurring_invoice',
		'app.sbs_subscriber_setting',
		'app.user',
		'app.acr_client_contact',
		'app.cpn_payment_method',
		'app.acr_invoice_payment_detail_custom_field'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcrInvoicePaymentDetailCustomFieldValue = ClassRegistry::init('AcrInvoicePaymentDetailCustomFieldValue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcrInvoicePaymentDetailCustomFieldValue);

		parent::tearDown();
	}

}
