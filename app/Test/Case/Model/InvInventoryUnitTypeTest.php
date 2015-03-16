<?php
App::uses('InvInventoryUnitType', 'Model');

/**
 * InvInventoryUnitType Test Case
 *
 */
class InvInventoryUnitTypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.inv_inventory_unit_type',
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
		'app.inv_inventory',
		'app.sbs_subscriber_tax',
		'app.acr_invoice_detail',
		'app.sbs_subscriber_tax_group',
		'app.sbs_subscriber_tax_group_mapping',
		'app.sls_quotation_product',
		'app.sls_quotation',
		'app.sls_quotation_custom_value',
		'app.sls_quotation_custom_field',
		'app.acp_inventory_expense',
		'app.acp_expense',
		'app.acp_expense_category',
		'app.acr_inventory_invoice',
		'app.acr_client_recurring_invoice',
		'app.acr_invoice_custom_value',
		'app.acr_invoice_custom_field',
		'app.acr_invoice_payment_detail',
		'app.aco',
		'app.aro',
		'app.permission',
		'app.cpn_subscriber_invoice_detail',
		'app.cpn_recurring_invoice',
		'app.sbs_subscriber_setting',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InvInventoryUnitType = ClassRegistry::init('InvInventoryUnitType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InvInventoryUnitType);

		parent::tearDown();
	}

}
