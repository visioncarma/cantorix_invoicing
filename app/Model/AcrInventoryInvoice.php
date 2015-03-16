<?php
App::uses('AppModel', 'Model');
/**
 * AcrInventoryInvoice Model
 *
 * @property AcrClient $AcrClient
 * @property AcpInventoryExpense $AcpInventoryExpense
 */
class AcrInventoryInvoice extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'AcrClient' => array(
			'className' => 'AcrClient',
			'foreignKey' => 'acr_client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AcpInventoryExpense' => array(
			'className' => 'AcpInventoryExpense',
			'foreignKey' => 'acp_inventory_expense_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
