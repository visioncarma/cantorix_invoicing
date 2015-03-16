<?php
App::uses('AppModel', 'Model');
/**
 * SbsUpgradeNotification Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property CpnSubscriptionPlan $CpnSubscriptionPlan
 */
class SbsUpgradeNotification extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'SbsSubscriber' => array(
			'className' => 'SbsSubscriber',
			'foreignKey' => 'sbs_subscriber_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CpnSubscriptionPlan' => array(
			'className' => 'CpnSubscriptionPlan',
			'foreignKey' => 'cpn_subscription_plan_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
