<?php
App::uses('AppModel', 'Model');
/**
 * SbsSubscriberTax Model
 *
 * @property SbsSubscriber $SbsSubscriber
 * @property AcrInvoiceDetail $AcrInvoiceDetail
 * @property SbsSubscriberTaxGroupMapping $SbsSubscriberTaxGroupMapping
 * @property SlsQuotationProduct $SlsQuotationProduct
 */
class SbsSubscriberTax extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	public $virtualFields = array(
    	'tax' => 'CONCAT(SbsSubscriberTax.name, "(", SbsSubscriberTax.percent,")")'
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
		'AcrInvoiceDetail' => array(
			'className' => 'AcrInvoiceDetail',
			'foreignKey' => 'sbs_subscriber_tax_id',
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
			'foreignKey' => 'sbs_subscriber_tax_id',
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
			'foreignKey' => 'sbs_subscriber_tax_id',
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
	
	public function getTaxById($id=null){
		$taxInfo=$this->find('first',array('conditions'=>array('SbsSubscriberTax.id'=>$id)));
		return $taxInfo;
	}
	
	public function getTaxesBySubscriber($subscriber=null){
		$taxList=$this->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber),'order'=>array('SbsSubscriberTax.name ASC'),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.code')));
	    return $taxList;
	}


    public function getTaxesPercentBySubscriber($subscriber=null){
		$taxList1=$this->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber),'order'=>array('SbsSubscriberTax.name ASC'),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.percent')));
	    return $taxList1;
	}
	public function getTaxesBySubscriberQuotes($subscriber=null){
		$taxAll=$this->find('all',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber),'order'=>array('SbsSubscriberTax.name ASC'),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.code','SbsSubscriberTax.percent')));
	    foreach($taxAll as $key=>$taxValue){
	    	$taxList[$taxValue['SbsSubscriberTax']['id']] = $taxValue['SbsSubscriberTax']['code'].'(@'.$taxValue['SbsSubscriberTax']['percent'].'%)';
	    }
	    return $taxList;
	}
	
	public function checkTaxExists($tax_name=null,$subscriber=null){
		$taxName=$this->find('first',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber,'SbsSubscriberTax.name'=>trim($tax_name)),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.name')));
	    return $taxName;
	}
	
	public function checkTaxCodeExists($tax_code=null,$subscriber=null){
		$taxCode=$this->find('first',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber,'SbsSubscriberTax.code'=>trim($tax_code)),'fields'=>array('SbsSubscriberTax.code')));
	    return $taxCode;
	}
	
	public function getTaxPercentBySubscriber($subscriber=null){
		$taxPercentList=$this->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber),'order'=>array('SbsSubscriberTax.name ASC'),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.percent')));
	    return $taxPercentList;
	}
	public function getActiveTaxes($subscriber){
		$taxPercentList=$this->find('list',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber),'order'=>array('SbsSubscriberTax.name ASC'),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.name')));
	    return $taxPercentList;
	}
	public function getTaxByName($taxName = null,$subscriber = null){
		$taxPercentList=$this->find('first',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber,'SbsSubscriberTax.name'=>$taxName),'fields'=>array('SbsSubscriberTax.id','SbsSubscriberTax.name')));
	    if($taxPercentList){
	    	return $taxPercentList['SbsSubscriberTax']['id'];
	    }else{
	    	return false;
	    }
	    
	}
    
	public function getSubscriberTaxes($subscriber=null){
		 $taxCodeList=$this->find('all',array('conditions'=>array('SbsSubscriberTax.sbs_subscriber_id'=>$subscriber),'order'=>array('SbsSubscriberTax.code ASC')));
	     if($taxCodeList){
	     	  return $taxCodeList;
	     }else{
	     	  return false;
	     }
	    
	}
}
