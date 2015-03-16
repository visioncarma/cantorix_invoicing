<?php
App::uses('AppModel', 'Model');
/**
 * SbsCurrency Model
 *
 * @property AcrClient $AcrClient
 * @property SbsSubscriberOrganizationDetail $SbsSubscriberOrganizationDetail
 */
class SbsCurrency extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'AcrClient' => array(
			'className' => 'AcrClient',
			'foreignKey' => 'sbs_currency_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SbsSubscriberOrganizationDetail' => array(
			'className' => 'SbsSubscriberOrganizationDetail',
			'foreignKey' => 'sbs_currency_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
