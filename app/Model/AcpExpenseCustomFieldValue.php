<?php
App::uses('AppModel', 'Model');
/**
 * AcpExpenseCustomFieldValue Model
 *
 * @property AcpExpense $AcpExpense
 * @property AcpExpenseCustomField $AcpExpenseCustomField
 */
class AcpExpenseCustomFieldValue extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'AcpExpense' => array(
			'className' => 'AcpExpense',
			'foreignKey' => 'acp_expense_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'AcpExpenseCustomField' => array(
			'className' => 'AcpExpenseCustomField',
			'foreignKey' => 'acp_expense_custom_field_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
