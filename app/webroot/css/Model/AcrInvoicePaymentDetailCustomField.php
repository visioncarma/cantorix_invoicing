<?php
App::uses('AppModel', 'Model');
/**
 * AcrInvoicePaymentDetailCustomField Model
 *
 * @property SbsSubscriber $SbsSubscriber
 */
class AcrInvoicePaymentDetailCustomField extends AppModel {


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
	
	
	
	public function addField($data){
		if(($data['sbs_subscriber_id']) && ($data['field_name'])){
			$this->create();
			$data['AcrInvoicePaymentDetailCustomField'] = $data;
			if($this->save($data)){
				return $this->getLastInsertId();
			}else{
				return false;
			}
		}
	}
	public function updateField($data){
		if(($data['sbs_subscriber_id']) && ($data['field_name'])){
			$data['AcrInvoicePaymentDetailCustomField'] = $data;
			if($this->save($data)){
				return true;
			}else{
				return false;
			}
		}
	}
	public function getListOfFields($subscriberId){
		$getList  = $this->find('list',array('conditions'=>array('AcrInvoicePaymentDetailCustomField.sbs_subscriber_id'=>$subscriberId),'fields'=>array('AcrInvoicePaymentDetailCustomField.id','AcrInvoicePaymentDetailCustomField.field_name')));
		return $getList;
	}
}
