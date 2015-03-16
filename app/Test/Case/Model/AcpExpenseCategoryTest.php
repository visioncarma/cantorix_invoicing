<?php
App::uses('AcpExpenseCategory', 'Model');

/**
 * AcpExpenseCategory Test Case
 *
 */
class AcpExpenseCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.acp_expense_category',
		'app.sbs_subscriber',
		'app.acp_expense'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->AcpExpenseCategory = ClassRegistry::init('AcpExpenseCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->AcpExpenseCategory);

		parent::tearDown();
	}

}
