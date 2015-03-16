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
		if($default) {
			return $default;
			//$default = $this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriberID)));
		}else{
			return false;
		}
		
	}

    public function getAllPaymentTermsBySubscriber($subscriber=null){
		$subscriberPaymentTerms=$this->find('all',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriber),'fields'=>array('SbsSubscriberPaymentTerm.id','SbsSubscriberPaymentTerm.term','SbsSubscriberPaymentTerm.no_of_days','SbsSubscriberPaymentTerm.is_default'),'order'=>array('SbsSubscriberPaymentTerm.term ASC')));
	    if($subscriberPaymentTerms){
	       return $subscriberPaymentTerms;
	    }else{
	       return false;
	    }
	    
	}
	
	public function getDefaultPaymentTerm($subscriber=null){
		$defaultTerm=$this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriber,'SbsSubscriberPaymentTerm.is_default'=>'Y')));
	    if($defaultTerm){
	       return $defaultTerm;
	    }else{
	       return false;
	    }
	    
	}
	
	public function getPaymentTermById($id=null){
		$paymentTermInfo=$this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.id'=>$id)));
	    if($paymentTermInfo){
	    	return $paymentTermInfo;
	    }else{
	    	return false;
	    }
	   
	}

   public function checkPaymentTermDefaultBySubscriber($subscriber=nul,$id=null){
		$paymentTermDefault=$this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.id !='=>$id,'SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriber,'SbsSubscriberPaymentTerm.is_default'=>'Y'),'fields'=>array('SbsSubscriberPaymentTerm.is_default')));
	    if($paymentTermDefault){
	    	return $paymentTermDefault;
	    }else{
	    	return false;
	    }
	}

    public function checkPaymentTermExistBySubscriber($subscriber=null,$term=null){
		$paymentTermExist=$this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriber,'SbsSubscriberPaymentTerm.term'=>trim($term)),'fields'=>array('SbsSubscriberPaymentTerm.id')));
	    if($paymentTermExist){
	    	return $paymentTermExist;
	    }else{
	    	return false;
	    }
	   
	}

    public function checkPaymentDaysExistBySubscriber($subscriber=null,$days=null){
		$paymentDaysExist=$this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriber,'SbsSubscriberPaymentTerm.no_of_days'=>trim($days)),'fields'=>array('SbsSubscriberPaymentTerm.id')));
	    if($paymentDaysExist){
	    	return $paymentDaysExist;
	    }else{
	    	return false;
	    }
	   
	}
	
	public function paymentTermExist($subscriber=null,$id=null,$term=null){
		$payment_term_present=$this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.id !='=>$id,'SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriber,'SbsSubscriberPaymentTerm.term'=>trim($term)),'fields'=>array('SbsSubscriberPaymentTerm.id')));
	    if($payment_term_present){
	    	return $payment_term_present;
	    }else{
	    	return false;
	    }
	   
	}

    public function paymentDaysExist($subscriber=null,$id=null,$days=null){
		$payment_days_present=$this->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.id !='=>$id,'SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$subscriber,'SbsSubscriberPaymentTerm.no_of_days'=>trim($days)),'fields'=>array('SbsSubscriberPaymentTerm.id')));
	    if($payment_days_present){
	    	return $payment_days_present;
	    }else{
	    	return false;
	    }
	   
	}
}
