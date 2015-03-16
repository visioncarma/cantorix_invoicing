<?php
App::uses('AppModel', 'Model');
/**
 * SlsQuotationCustomField Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property SlsQuotationCustomValue $SlsQuotationCustomValue
 */
class SlsQuotationCustomField extends AppModel {


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
		'SlsQuotationCustomValue' => array(
			'className' => 'SlsQuotationCustomValue',
			'foreignKey' => 'sls_quotation_custom_field_id',
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
	
/**
 * @method  To get the custom field list added by subscriber
 * @author  Ganesh R
 * @param   Subscriber id
 * @return  list of custom fields id and fieldname
 * */
	public function getFieldList($subscriberID = NULL) {
		return $this->find('list',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberID),'fields'=>array('SlsQuotationCustomField.id','SlsQuotationCustomField.field_name')));
	}
	public function getFieldByName($fieldName,$subscriberId){
		$getList  = $this->find('first',array('conditions'=>array('SlsQuotationCustomField.sbs_subscriber_id'=>$subscriberId,'SlsQuotationCustomField.field_name'=>$fieldName),'fields'=>array('SlsQuotationCustomField.id','SlsQuotationCustomField.field_name')));
		return $getList;
	}

}
