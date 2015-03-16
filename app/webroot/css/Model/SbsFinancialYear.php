<?php
App::uses('AppModel', 'Model');
/**
 * SbsFinancialYear Model
 *
 * @property SbsSubscriberOrganizationDetail $SbsSubscriberOrganizationDetail
 */
class SbsFinancialYear extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'SbsSubscriberOrganizationDetail' => array(
			'className' => 'SbsSubscriberOrganizationDetail',
			'foreignKey' => 'sbs_financial_year_id',
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
