<?php
App::uses('AppModel', 'Model');
/**
 * SbsSubscriberSetting Model
 *
 * @property SbsSubscriber $SbsSubscriber
 */
class SbsSubscriberSetting extends AppModel {


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
	
	public function addSubscriberSettings ($sbs_subscriber_id){	
			
			$cpns 	     = ClassRegistry::init('CpnSetting');
			$preSettings = $cpns->getAllSettings();	
			
			$lines_per_page	= $preSettings['CpnSetting']['lines_per_page'];
			$date_format	= $preSettings['CpnSetting']['date_format'];	
			$saveSS->data = null;
			$this->create();			
			$saveSS->data['SbsSubscriberSetting']['lines_per_page']		= $lines_per_page;
			$saveSS->data['SbsSubscriberSetting']['date_format']  		= $date_format;
			$saveSS->data['SbsSubscriberSetting']['sbs_subscriber_id'] 	= $sbs_subscriber_id;
			if($this->save($saveSS->data)){				
				return 1;
			} else {
				return 0;
			}
	}
	
	public function defaultSettings($subscriber_id=null){
		
   		return $this->find('first',array('conditions'=>array('SbsSubscriberSetting.sbs_subscriber_id'=>$subscriber_id)));
 
	}
	
}
