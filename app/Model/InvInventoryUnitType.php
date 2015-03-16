<?php
App::uses('AppModel', 'Model');
/**
 * InvInventoryUnitType Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property InvInventory $InvInventory
 */
class InvInventoryUnitType extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'type_name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'InvInventory' => array(
			'className' => 'InvInventory',
			'foreignKey' => 'inv_inventory_unit_type_id',
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
	
	public function addUnitType($subscriberId = null,$unitType = null){
		if($subscriberId && $unitType){
			$checkTypeExist = $this->getTypeByName($subscriberId,$unitType);
			if(empty($checkTypeExist)){
				$saveUnit->data = null;
				$this->create();
				$saveUnit->data['InvInventoryUnitType']['sbs_subscriber_id'] 	= $subscriberId;
				$saveUnit->data['InvInventoryUnitType']['type_name'] 			= $unitType;
				if($this->save($saveUnit->data)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}
	
	public function getUnitTypeList($subscriberId = null){
		$unitTypeList = $this->find('list',array('conditions'=>array('InvInventoryUnitType.sbs_subscriber_id'=>$subscriberId),'fields'=>array('InvInventoryUnitType.id','InvInventoryUnitType.type_name'),'order'=>array('InvInventoryUnitType.type_name ASC')));
		return 	$unitTypeList;
	}
	public function getTypeByName($subscriberId = null,$unitType = null){
		$unitTypeList = $this->find('first',array('conditions'=>array('InvInventoryUnitType.type_name'=>$unitType,'InvInventoryUnitType.sbs_subscriber_id'=>$subscriberId),'fields'=>array('InvInventoryUnitType.id','InvInventoryUnitType.type_name')));
		return $unitTypeList;
	}
	
	public function importUnitType($unitTypeName,$subscriberId){
		if(($unitTypeName) && ($unitTypeName)){
			$unitTypeList = $this->find('first',array('conditions'=>array('InvInventoryUnitType.type_name'=>$unitTypeName,'InvInventoryUnitType.sbs_subscriber_id'=>$subscriberId),'fields'=>array('InvInventoryUnitType.id','InvInventoryUnitType.type_name')));
			if($unitTypeList){
				return $unitTypeList['InvInventoryUnitType']['id'];
			}else{
				$saveUnit->data = null;
				$this->create();
				$saveUnit->data['InvInventoryUnitType']['sbs_subscriber_id'] 	= $subscriberId;
				$saveUnit->data['InvInventoryUnitType']['type_name'] 			= $unitTypeName;
				if($this->save($saveUnit->data)){
					$lastInsertedId	=	$this->getLastInsertId();
					return $lastInsertedId;
				}else{
					return false;
				}
			}
		}else{
			return false;
		}
	}

    public function inventoryUnitTypeExist($subscriber=null,$unit_type=null){
    	$unitTypeExist = $this->find('first',array('conditions'=>array('InvInventoryUnitType.sbs_subscriber_id'=>$subscriber,'InvInventoryUnitType.type_name'=>$unit_type),'fields'=>array('InvInventoryUnitType.id')));
		if($unitTypeExist){
			return true;
		}else{
			return false;
		}
    }
	
	
	 public function getUnitTypeByID($subscriber=null,$id=null){
    	$unitType = $this->find('first',array('conditions'=>array('InvInventoryUnitType.sbs_subscriber_id'=>$subscriber,'InvInventoryUnitType.id'=>$id),'fields'=>array('InvInventoryUnitType.id','InvInventoryUnitType.type_name')));
		if($unitType){
			return $unitType;
		}else{
			return false;
		}
    }
}
