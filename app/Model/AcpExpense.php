<?php
App::uses('AppModel', 'Model');
/**
 * AcpExpense Model
 *
 * @property AcpExpenseCategory $AcpExpenseCategory
 * @property SbsSubscriber $SbsSubscriber
 * @property AcpInventoryExpense $AcpInventoryExpense
 */
class AcpExpense extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'AcpExpenseCategory' => array(
			'className' => 'AcpExpenseCategory',
			'foreignKey' => 'acp_expense_category_id',
			'conditions' => '',
			'fields' => array('AcpExpenseCategory.id','AcpExpenseCategory.category_name','AcpExpenseCategory.description'),
			'order' => ''
		),
		'AcrClient' => array(
			'className' => 'AcrClient',
			'foreignKey' => 'acr_client_id',
			'conditions' => '',
			'fields' => array('AcrClient.id','AcrClient.client_name','AcrClient.organization_name','AcrClient.cpn_currency_id'),
			'order' => ''
		),
		'AcpVendor' => array(
			'className' => 'AcpVendor',
			'foreignKey' => 'acp_vendor_id',
			'conditions' => '',
			'fields' => array('AcpVendor.id','AcpVendor.vendor_name'),
			'order' => ''
		),
		'SbsSubscriber' => array(
			'className' => 'SbsSubscriber',
			'foreignKey' => 'sbs_subscriber_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'AcpInventoryExpense' => array(
			'className' => 'AcpInventoryExpense',
			'foreignKey' => 'acp_expense_id',
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
