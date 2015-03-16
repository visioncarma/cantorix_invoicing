<?php
App::uses('AcpExpense', 'Model');

/**
 * AcpExpense Test Case
 *
 */
class AcpExpenseTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acp_expense',
		'app.acp_expense_category',
		'app.sbs_subscriber',
		'app.acp_inventory_expense'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcpExpense = ClassRegistry::init('AcpExpense');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcpExpense);

		parent::tearDown();
	}

}
