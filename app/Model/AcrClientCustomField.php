<?php
App::uses('AppModel', 'Model');
/**
 * AcrClientCustomField Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property AcrClientCustomValue $AcrClientCustomValue
 */
class AcrClientCustomField extends AppModel {

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
		'AcrClientCustomValue' => array(
			'className' => 'AcrClientCustomValue',
			'foreignKey' => 'acr_client_custom_field_id',
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
	public function addField($data){
		if(($data['sbs_subscriber_id']) && ($data['field_name'])){
			$this->create();
			$data['AcrClientCustomField'] = $data;
			if($this->save($data)){
				return $this->getLastInsertId();
			}else{
				return false;
			}
		}
	}
	public function updateField($data){
		if(($data['sbs_subscriber_id']) && ($data['field_name'])){
			$data['AcrClientCustomField'] = $data;
			if($this->save($data)){
				return true;
			}else{
				return false;
			}
		}
	}
	public function getFieldBySubscriber($subscriber=null){
		
		$fields=$this->find('list',array('conditions'=>array('AcrClientCustomField.sbs_subscriber_id'=>$subscriber),'fields'=>array('AcrClientCustomField.field_name'),'order'=>array('AcrClientCustomField.field_name ASC')));
	    return $fields;
	}
	
	public function getListOfFields($subscriberId){
		$getList  = $this->find('list',array('conditions'=>array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrClientCustomField.id','AcrClientCustomField.field_name')));
		return $getList;
	}
	public function getFieldByName($fieldName,$subscriberId){
		$getList  = $this->find('first',array('conditions'=>array('AcrClientCustomField.sbs_subscriber_id'=>$subscriberId,'AcrClientCustomField.field_name'=>$fieldName),'fields'=>array('AcrClientCustomField.id','AcrClientCustomField.field_name')));
		return $getList;
	}

}
