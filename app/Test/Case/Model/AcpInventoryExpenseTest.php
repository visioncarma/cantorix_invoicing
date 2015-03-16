<?php
App::uses('AcpInventoryExpense', 'Model');

/**
 * AcpInventoryExpense Test Case
 *
 */
class AcpInventoryExpenseTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acp_inventory_expense',
		'app.transaction',
		'app.inv_inventory',
		'app.acp_expense',
		'app.acp_expense_category',
		'app.sbs_subscriber',
		'app.acr_inventory_invoice'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcpInventoryExpense = ClassRegistry::init('AcpInventoryExpense');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcpInventoryExpense);

		parent::tearDown();
	}

}
