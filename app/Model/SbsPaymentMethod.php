<?php
App::uses('AppModel', 'Model');
/**
 * SbsPaymentMethod Model
 *
 * @property CpnPaymentMethod $CpnPaymentMethod
 */
class SbsPaymentMethod extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CpnPaymentMethod' => array(
			'className' => 'CpnPaymentMethod',
			'foreignKey' => 'cpn_payment_method_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
