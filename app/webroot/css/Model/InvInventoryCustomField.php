<?php
App::uses('AppModel', 'Model');
/**
 * InvInventoryCustomField Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property InvInventoryCustomValue $InvInventoryCustomValue
 */
class InvInventoryCustomField extends AppModel {


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
		'InvInventoryCustomValue' => array(
			'className' => 'InvInventoryCustomValue',
			'foreignKey' => 'inv_inventory_custom_field_id',
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
			$data['InvInventoryCustomField'] = $data;
			if($this->save($data)){
				return $this->getLastInsertId();
			}else{
				return false;
			}
		}
	}
	public function updateField($data){
		if(($data['sbs_subscriber_id']) && ($data['field_name'])){
			$data['InvInventoryCustomField'] = $data;
			if($this->save($data)){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public function getListOfFields($subscriberId){
		$getList  = $this->find('list',array('conditions'=>array('InvInventoryCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('InvInventoryCustomField.id','InvInventoryCustomField.field_name')));
		return $getList;
	}
}
