<?php
App::uses('AppModel', 'Model');
/**
 * SbsSubscriberPaymentTerm Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property AcrClient $AcrClient
 */
class SbsSubscriberPaymentTerm extends AppModel {


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
		'AcrClient' => array(
			'className' => 'AcrClient',
			'foreignKey' => 'sbs_subscriber_payment_term_id',
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
	
	public function getPaymentTermsBySubscriber($subscriber=null){
		$paymentTerms=$this->find('list',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriber),'fields'=>array('SbsSubscriberPaymentTerm.term'),'order'=>array('SbsSubscriberPaymentTerm.term ASC')));
	    return $paymentTerms;
	}
	public function getTermsByName($termName = null,$subscriber=null){
		$paymentTerms=$this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.term'=>$termName,'SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriber),'fields'=>array('SbsSubscriberPaymentTerm.id','SbsSubscriberPaymentTerm.term')));
	    if($paymentTerms){
	    	return $paymentTerms['SbsSubscriberPaymentTerm']['id'];
	    }else{
	    	return false;
	    }
	    
	}
	public function getTermsById($termId = null){
		$paymentTerms=$this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.id'=>$termId),'fields'=>array('SbsSubscriberPaymentTerm.id','SbsSubscriberPaymentTerm.no_of_days')));
	    if($paymentTerms){
	    	return $paymentTerms['SbsSubscriberPaymentTerm']['no_of_days'];
	    }else{
	    	return false;
	    }
	    
	}

/**
 * @method  get default term set by subscriber
 * @author  Ganesh R
 * @param   Subscriber ID
 * @return  default term record
 * @version 1.1
 * @since   18 Aug 2014
 * */
	public function getDefaultTerm($subscriberID = NULL) {
		$default = $this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriberID,'SbsSubscriberPaymentTerm.is_default'=>'Y')));
		if(empty($default)) {
			$default = $this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriberID)));
		}
		return $default;
	}

}
