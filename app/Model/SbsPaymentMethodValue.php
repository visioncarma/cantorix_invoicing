<?php
App::uses('AppModel', 'Model');
/**
 * SbsPaymentMethodValue Model
 *
 * @property Subscriber $Subscriber
 * @property CpnPaymentMethod $CpnPaymentMethod
 * @property CpnPaymentAttribute $CpnPaymentAttribute
 */
class SbsPaymentMethodValue extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Subscriber' => array(
			'className' => 'Subscriber',
			'foreignKey' => 'subscriber_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CpnPaymentMethod' => array(
			'className' => 'CpnPaymentMethod',
			'foreignKey' => 'cpn_payment_method_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CpnPaymentAttribute' => array(
			'className' => 'CpnPaymentAttribute',
			'foreignKey' => 'cpn_payment_attribute_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
