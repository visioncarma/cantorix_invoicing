<?php
App::uses('AppModel', 'Model');
/**
 * AcrClientContact Model
 *
 * @property AcrClient $AcrClient
 */
class AcrClientContact extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


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
		)
	);
	
	public function getClientContactName($clientId=null){
		$contact=$this->find('first',array('conditions'=>array('AcrClientContact.acr_client_id'=>$clientId,'AcrClientContact.is_primary'=>'Y'),'fields'=>array('AcrClientContact.name','AcrClientContact.sur_name')));
	    if($contact['AcrClientContact']['sur_name']){
	    	return $contact['AcrClientContact']['name'].' '.$contact['AcrClientContact']['sur_name'];
	    }else{
	    	return $contact['AcrClientContact']['name'];
	    }
	    
	}
	
	public function getClientContactDetail($clientId=null){
		$contact_details=$this->find('all',array('conditions'=>array('AcrClientContact.acr_client_id'=>$clientId)));
	    return $contact_details;
	}
	
	public function getClientPrimaryContactDetail($clientId=null){
		$primary_contact=$this->find('first',array('conditions'=>array('AcrClientContact.acr_client_id'=>$clientId,'AcrClientContact.is_primary'=>'Y')));
	    return $primary_contact;
	}
	public function importClientContact($subscriberId,$newClientId,$contactArray){
		if($subscriberId && $newClientId && $contactArray){
			foreach($contactArray as $key=>$val){
				if(!$val['Contact Name']){
					$arraySave['failure'] = '1';
   					$arraySave['error'] = "Contact Name Missing";
   					return $arraySave;
				}elseif(!$val['Contact Email']){
					$arraySave['failure'] = '1';
   					$arraySave['error'] = "Contact Email Missing";
   					return $arraySave;
				}elseif(!$val['Mobile']){
					$arraySave['failure'] = '1';
   					$arraySave['error'] = "Mobile contact Missing";
   					return $arraySave;
				}else{
					$saveArray->data = null;
					$this->create();
					$saveArray->data['AcrClientContact']['name'] 				= $val['Contact Name'];
					$saveArray->data['AcrClientContact']['sur_name'] 			= $val['Contact Surname'];
					$saveArray->data['AcrClientContact']['email'] 				= $val['Contact Email'];
					$saveArray->data['AcrClientContact']['mobile'] 				= $val['Mobile'];
					$saveArray->data['AcrClientContact']['home_phone'] 			= $val['Home Phone'];
					$saveArray->data['AcrClientContact']['work_phone'] 			= $val['Work Phone'];
					if(($val['Primary Contact'] == 'Yes') || ($val['Primary Contact'] == 'yes') || ($val['Primary Contact'] == 'Y') ||($val['Primary Contact'] == 'y')){
						$saveArray->data['AcrClientContact']['is_primary'] 			= 'Y';
					}else{
						$saveArray->data['AcrClientContact']['is_primary'] 			= 'N';
					}
					
					$saveArray->data['AcrClientContact']['acr_client_id'] 		= $newClientId;
					$saveArray->data['AcrClientContact']['sbs_subscriber_id'] 	= $subscriberId;
					if($this->save($saveArray->data)){
						$lastInsertedId	=	$this->getLastInsertId();
		   				$arraySave['Success'] = $lastInsertedId;
		   				return $arraySave;
					}
				}
				
			}
			
		}
	}
	
	
	
	
}
