<?php
App::uses('AppModel', 'Model');
/**
 * SbsFinancialYear Model
 *
 * @property SbsSubscriberOrganizationDetail $SbsSubscriberOrganizationDetail
 */
class CpnFinancialYear extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'SbsSubscriberOrganizationDetail' => array(
			'className' => 'SbsSubscriberOrganizationDetail',
			'foreignKey' => 'cpn_financial_year_id',
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


 	public function getDefaultFinancialYear () {
				
		$defaultFinancialYear = $this->find('first', array (
			'conditions' => array (
				'CpnFinancialYear.from_month' => 'Jan', 'CpnFinancialYear.to_month' => 'Dec',
			)
		));	
		return $defaultFinancialYear; 
	}

}
