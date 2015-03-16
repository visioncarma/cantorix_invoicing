<?php
App::uses('AppModel', 'Model');
/**
 * InvInventoryCustomValue Model
 *
 * @property InvInventoryCustomField $InvInventoryCustomField
 * @property InvInventory $InvInventory
 */
class InvInventoryCustomValue extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'InvInventoryCustomField' => array(
			'className' => 'InvInventoryCustomField',
			'foreignKey' => 'inv_inventory_custom_field_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'InvInventory' => array(
			'className' => 'InvInventory',
			'foreignKey' => 'inv_inventory_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function addCustomValue($fieldId = null,$data = null,$inventoryId = null){
		if($fieldId && $data && $inventoryId){
			$this->create();
			$addCustomValue->data = null;
			$addCustomValue->data['InvInventoryCustomValue']['inv_inventory_custom_field_id'] = $fieldId;
			$addCustomValue->data['InvInventoryCustomValue']['inv_inventory_id'] 			  = $inventoryId;
			$addCustomValue->data['InvInventoryCustomValue']['data'] 						  = $data;
			if($this->save($addCustomValue->data)){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public function getCustomValueList($inventoryId = null){
		
		$valueList = $this->find('list',array('conditions'=>array('InvInventoryCustomValue.inv_inventory_id'=>$inventoryId),'fields'=>array('InvInventoryCustomValue.inv_inventory_custom_field_id','InvInventoryCustomValue.data')));
		return $valueList;
		
	}
	public function updateCustomValue($getCustomFieldValueId = null,$customFieldValue = null,$updateInventory = null){
		if($getCustomFieldValueId){
			$updateData->data = null;
			$updateData->data['InvInventoryCustomValue']['id'] = $getCustomFieldValueId;
			$updateData->data['InvInventoryCustomValue']['data'] = $customFieldValue;
			if($this->save($updateData->data)){
				return $getCustomFieldValueId;
			}
		}
	}
	
	public function getCustomValueId($inventoryId,$customFieldId){
		$getValue = $this->find('first',array('conditions'=>array('InvInventoryCustomValue.inv_inventory_id'=>$inventoryId,'InvInventoryCustomValue.inv_inventory_custom_field_id'=>$customFieldId)));
		if($getValue){
			return $getValue;
		}else{
			return false;
		}
	}
}
