<?php
App::uses('SbsSubscriberOrganizationDetail', 'Model');

/**
 * SbsSubscriberOrganizationDetail Test Case
 *
 */
class SbsSubscriberOrganizationDetailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sbs_subscriber_organization_detail',
		'app.sbs_financial_year',
		'app.sbs_language',
		'app.acr_client',
		'app.sbs_currency',
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
		$this->SbsSubscriberOrganizationDetail = ClassRegistry::init('SbsSubscriberOrganizationDetail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SbsSubscriberOrganizationDetail);

		parent::tearDown();
	}

}
