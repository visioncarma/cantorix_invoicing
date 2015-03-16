<?php
App::uses('AppModel', 'Model');
/**
 * SbsSubscriberTaxGroup Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property AcrInvoiceDetail $AcrInvoiceDetail
 * @property SbsSubscriberTaxGroupMapping $SbsSubscriberTaxGroupMapping
 * @property SlsQuotationProduct $SlsQuotationProduct
 */
class SbsSubscriberTaxGroup extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'group_name';


	

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
		'AcrInvoiceDetail' => array(
			'className' => 'AcrInvoiceDetail',
			'foreignKey' => 'sbs_subscriber_tax_group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SbsSubscriberTaxGroupMapping' => array(
			'className' => 'SbsSubscriberTaxGroupMapping',
			'foreignKey' => 'sbs_subscriber_tax_group_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'SlsQuotationProduct' => array(
			'className' => 'SlsQuotationProduct',
			'foreignKey' => 'sbs_subscriber_tax_group_id',
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

	
	public function checkTaxGroupExists($group=null,$subscriber=null){
		$taxGroup=$this->find('first',array('conditions'=>array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriber,'SbsSubscriberTaxGroup.group_name'=>trim($group)),'fields'=>array('SbsSubscriberTaxGroup.id','SbsSubscriberTaxGroup.group_name')));
	    return $taxGroup;
	}
	public function getGroupInfo($groupId=null,$subscriber=null){
		$taxGroup=$this->find('first',array('conditions'=>array('SbsSubscriberTaxGroup.id'=>$groupId,'SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriber),'fields'=>array('SbsSubscriberTaxGroup.group_name')));
	    return $taxGroup;
	}
	public function getTaxGroupListBySubscriber($subscriber = null){
		$taxGroup=$this->find('list',array('conditions'=>array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriber),'order'=>array('SbsSubscriberTaxGroup.group_name ASC'),'fields'=>array('SbsSubscriberTaxGroup.id','SbsSubscriberTaxGroup.group_name')));
	    return $taxGroup;
	}
	public function getTaxGroupByName($groupName = null,$subscriberId = null){
		$taxGroup = $this->find('first',array('conditions'=>array('SbsSubscriberTaxGroup.sbs_subscriber_id'=>$subscriberId,'SbsSubscriberTaxGroup.group_name'=>$groupName)));
		if($taxGroup){
			return $taxGroup['SbsSubscriberTaxGroup']['id'];
		}else{
			return false;
		}
	}
	
	
}
