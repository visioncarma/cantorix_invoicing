<?php
App::uses('AppModel', 'Model');
/**
 * AcpInventoryExpense Model
 *
 * @property Transaction $Transaction
 * @property InvInventory $InvInventory
 * @property AcpExpense $AcpExpense
 * @property SbsSubscriber $SbsSubscriber
 * @property AcrInventoryInvoice $AcrInventoryInvoice
 */
class AcpInventoryExpense extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'InvInventory' => array(
			'className' => 'InvInventory',
			'foreignKey' => 'inv_inventory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AcpExpense' => array(
			'className' => 'AcpExpense',
			'foreignKey' => 'acp_expense_id',
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
		'AcrInventoryInvoice' => array(
			'className' => 'AcrInventoryInvoice',
			'foreignKey' => 'acp_inventory_expense_id',
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
