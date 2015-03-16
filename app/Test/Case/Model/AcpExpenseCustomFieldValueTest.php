<?php
App::uses('AcpExpenseCustomFieldValue', 'Model');

/**
 * AcpExpenseCustomFieldValue Test Case
 *
 */
class AcpExpenseCustomFieldValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acp_expense_custom_field_value',
		'app.acp_expense',
		'app.acp_expense_category',
		'app.sbs_subscriber',
		'app.cpn_subscription_plan',
		'app.sbs_subscriber_organization_detail',
		'app.cpn_financial_year',
		'app.cpn_language',
		'app.acr_client',
		'app.cpn_currency',
		'app.acr_client_contact',
		'app.acr_client_custom_value',
		'app.acr_client_custom_field',
		'app.acr_client_invoice',
		'app.sbs_subscriber_payment_term',
		'app.acr_client_recurring_invoice',
		'app.acr_invoice_custom_value',
		'app.acr_invoice_custom_field',
		'app.acr_invoice_detail',
		'app.sbs_subscriber_tax',
		'app.sbs_subscriber_tax_group_mapping',
		'app.sbs_subscriber_tax_group',
		'app.sls_quotation_product',
		'app.sls_quotation',
		'app.sls_quotation_custom_value',
		'app.sls_quotation_custom_field',
		'app.inv_inventory',
		'app.inv_inventory_unit_type',
		'app.acp_inventory_expense',
		'app.acr_inventory_invoice',
		'app.acr_invoice_payment_detail',
		'app.cpn_payment_method',
		'app.aco',
		'app.aro',
		'app.permission',
		'app.cpn_subscriber_invoice_detail',
		'app.cpn_recurring_invoice',
		'app.sbs_subscriber_setting',
		'app.user',
		'app.acp_expense_custom_field'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcpExpenseCustomFieldValue = ClassRegistry::init('AcpExpenseCustomFieldValue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcpExpenseCustomFieldValue);

		parent::tearDown();
	}

}
