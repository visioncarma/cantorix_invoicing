<?php
App::uses('AppModel', 'Model');
App::import('Component', 'SessionComponent');
/**
 * AcpExpenseCategory Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property AcpExpense $AcpExpense
 */
class AcpExpenseCategory extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'sbs_subscriber_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
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
		'AcpExpense' => array(
			'className' => 'AcpExpense',
			'foreignKey' => 'acp_expense_category_id',
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
	
	public function checkFraud($id) {
		$session = new SessionComponent();
		$ifExist = $this->find('first',array('conditions'=>array('sbs_subscriber_id'=>$session->read('Auth.User.sbs_subscriber_id'),'id'=>$id),'fields'=>array('id')));
		if(!empty($ifExist)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function getList($subscriberID = NULL) {
		return $this->find('list',array('fields'=>array('id','category_name'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID)));
	}
	
	public function getCategoryIdByName($name = NULL) {
		$session = new SessionComponent();
		$result = $this->find('first',array('fields'=>array('id'),'conditions'=>array('sbs_subscriber_id'=>$session->read('Auth.User.sbs_subscriber_id'),'category_name LIKE'=>$name)));
		return $result['AcpExpenseCategory']['id'];
	}

}
