<?php
App::uses('SbsFinancialYear', 'Model');

/**
 * SbsFinancialYear Test Case
 *
 */
class SbsFinancialYearTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sbs_financial_year',
		'app.sbs_subscriber_organization_detail'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SbsFinancialYear = ClassRegistry::init('SbsFinancialYear');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SbsFinancialYear);

		parent::tearDown();
	}

}
