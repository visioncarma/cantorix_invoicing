<?php
App::uses('CpnSubscriptionPlan', 'Model');

/**
 * CpnSubscriptionPlan Test Case
 *
 */
class CpnSubscriptionPlanTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cpn_subscription_plan',
		'app.sbs_subscriber'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CpnSubscriptionPlan = ClassRegistry::init('CpnSubscriptionPlan');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CpnSubscriptionPlan);

		parent::tearDown();
	}

}
