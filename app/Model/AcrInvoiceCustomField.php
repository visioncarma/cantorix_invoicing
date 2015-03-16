<?php
App::uses('AppModel', 'Model');
/**
 * AcrInvoiceCustomField Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property AcrInvoiceCustomValue $AcrInvoiceCustomValue
 */
class AcrInvoiceCustomField extends AppModel {


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
		'AcrInvoiceCustomValue' => array(
			'className' => 'AcrInvoiceCustomValue',
			'foreignKey' => 'acr_invoice_custom_field_id',
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
			$data['AcrInvoiceCustomField'] = $data;
			if($this->save($data)){
				return $this->getLastInsertId();
			}else{
				return false;
			}
		}
	}
	public function updateField($data){
		if(($data['sbs_subscriber_id']) && ($data['field_name'])){
			$data['AcrInvoiceCustomField'] = $data;
			if($this->save($data)){
				return true;
			}else{
				return false;
			}
		}
	}
	public function getFieldList($subscriberId){
		if($subscriberId){
			$fieldList = $this->find('list',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoiceCustomField.id','AcrInvoiceCustomField.field_name')));
			return $fieldList;
		}
	}
	public function getListOfFields($subscriberId){
		$getList  = $this->find('list',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoiceCustomField.id','AcrInvoiceCustomField.field_name')));
		return $getList;
	}
	public function getFieldByName($fieldName,$subscriberId){
		$getList  = $this->find('first',array('conditions'=>array('AcrInvoiceCustomField.sbs_subscriber_id'=>$subscriberId,'AcrInvoiceCustomField.field_name'=>$fieldName),'fields'=>array('AcrInvoiceCustomField.id','AcrInvoiceCustomField.field_name')));
		return $getList;
	}

}
