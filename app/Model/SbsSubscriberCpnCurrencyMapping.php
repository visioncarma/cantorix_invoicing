<?php
App::uses('AppModel', 'Model');
/**
 * SbsSubscriberCpnCurrencyMapping Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property CpnCurrency $CpnCurrency
 */
class SbsSubscriberCpnCurrencyMapping extends AppModel {


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
		),
		'CpnCurrency' => array(
			'className' => 'CpnCurrency',
			'foreignKey' => 'cpn_currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	
	public function getListOfSubscriberCurrency($subscriber_id){
		$this->recursive = 0;
		$currencyList = $this->find('list',array('conditions'=>array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$subscriber_id),'fields'=>array('SbsSubscriberCpnCurrencyMapping.cpn_currency_id','SbsSubscriberCpnCurrencyMapping.cpn_currency_id')));
		return $currencyList;
	}
	public function getMapping($currencyId){
		$currencyList = $this->find('all',array('conditions'=>array('SbsSubscriberCpnCurrencyMapping.cpn_currency_id'=>$currencyId),'fields'=>array('SbsSubscriberCpnCurrencyMapping.cpn_currency_id','SbsSubscriberCpnCurrencyMapping.cpn_currency_id')));
		return $currencyList;
	}
	public function getCurrencyList($subscriber_id){
		$this->recursive = 0;
		$currencyList = $this->find('all',array('conditions'=>array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$subscriber_id)));
		return $currencyList;
	}
	public function getMappingDetails($mappingId = null,$subscriber_id = null){
		$currencyList = $this->find('first',array('conditions'=>array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$subscriber_id,'SbsSubscriberCpnCurrencyMapping.id'=>$mappingId)));
		return $currencyList;
	}
	public function addToMyList($currencyId,$subsciberId){
		if($currencyId && $subsciberId){
			$saveArray->data = null;
			$this->create();
			$saveArray->data['SbsSubscriberCpnCurrencyMapping']['sbs_subscriber_id'] = $subsciberId;
			$saveArray->data['SbsSubscriberCpnCurrencyMapping']['cpn_currency_id'] 	 = $currencyId;
			if($this->save($saveArray->data)){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public function isCurrencyExistForSubscriber($currencyId = null,$subscriberId = null){
		$getMapping = $this->find('first',array('conditions'=>array('SbsSubscriberCpnCurrencyMapping.cpn_currency_id'=>$currencyId,'SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$subscriberId)));
		if($getMapping){
			return true;
		}else{
			return false;
		}
	}
}
