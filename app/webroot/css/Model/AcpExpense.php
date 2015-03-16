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
			'fields' => '',
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
