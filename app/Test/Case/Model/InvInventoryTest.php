<?php
App::uses('InvInventory', 'Model');

/**
 * InvInventory Test Case
 *
 */
class InvInventoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.inv_inventory',
		'app.sbs_subscriber',
		'app.acp_inventory_expense',
		'app.transaction',
		'app.acp_expense',
		'app.acp_expense_category',
		'app.acr_inventory_invoice',
		'app.acr_client',
		'app.sbs_language',
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
		'app.sbs_subscriber_tax_group',
		'app.acr_invoice_payment_detail',
		'app.sls_quotation',
		'app.sls_quotation_product'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->InvInventory = ClassRegistry::init('InvInventory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->InvInventory);

		parent::tearDown();
	}

}
