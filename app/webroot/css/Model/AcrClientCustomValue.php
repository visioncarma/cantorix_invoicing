<?php
App::uses('AppModel', 'Model');
/**
 * AcrClientCustomValue Model
 *
 * @property AcrClient $AcrClient
 * @property AcrClientCustomField $AcrClientCustomField
 */
class AcrClientCustomValue extends AppModel {


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
		'AcrClientCustomField' => array(
			'className' => 'AcrClientCustomField',
			'foreignKey' => 'acr_client_custom_field_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function getCustomValueByClient($clientId=null){
		$custom_values=$this->find('list',array('conditions'=>array('AcrClientCustomValue.acr_client_id'=>$clientId),'order'=>array('AcrClientCustomValue.data ASC'),'fields'=>array('AcrClientCustomValue.acr_client_custom_field_id','AcrClientCustomValue.data')));
	    return $custom_values;
	}
	
	public function getCustomValueByField($clientId=null){
		$customFields=$this->find('list',array('conditions'=>array('AcrClientCustomValue.acr_client_id'=>$clientId),'order'=>array('AcrClientCustomValue.data ASC'),'fields'=>array('AcrClientCustomValue.acr_client_custom_field_id','AcrClientCustomValue.id')));
	    return $customFields;
	}
	
	public function addValue($clientId=null,$value=null,$customFieldId = null){
		if($clientId && $value){
			$this->create();
			$saveArray->data = null;
			$saveArray->data['AcrClientCustomValue']['acr_client_id'] = $clientId;
			$saveArray->data['AcrClientCustomValue']['data'] 		  = $value;
			$saveArray->data['AcrClientCustomValue']['acr_client_custom_field_id'] = $customFieldId;
			if($this->save($saveArray->data)){
				return $this->getLastInsertId();
			}else{
				return false;
			}
			
		}else{
			return false;
		}
	}
	public function addCustomValue($lastInsertedId=null,$data=null){
		if($lastInsertedId && $data){
			 foreach($data['FieldValue'] as $key=>$val){
	        	
	        	  $addFieldValue=null;
	        	  $this->create();
	        	  $addFieldValue['AcrClientCustomValue']['data']                       = $val;
	        	  $addFieldValue['AcrClientCustomValue']['acr_client_id']              = $lastInsertedId;
	        	  $addFieldValue['AcrClientCustomValue']['acr_client_custom_field_id'] = $key;
	        	  $this->save($addFieldValue);
           }
		}else{
			return false;
		}
		 
	}
		
	
}
