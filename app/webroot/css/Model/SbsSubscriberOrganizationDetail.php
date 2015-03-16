<?php
App::uses('AppModel', 'Model');
App::import('Component', 'SessionComponent'); 
/**
 * SbsSubscriberOrganizationDetail Model
 *
 * @property SbsFinancialYear $SbsFinancialYear
 * @property SbsLanguage $SbsLanguage
 * @property SbsCurrency $SbsCurrency
 * @property SbsSubscriber $SbsSubscriber
 */
class SbsSubscriberOrganizationDetail extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'CpnFinancialYear' => array(
			'className' => 'CpnFinancialYear',
			'foreignKey' => 'cpn_financial_year_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CpnLanguage' => array(
			'className' => 'CpnLanguage',
			'foreignKey' => 'cpn_language_id',
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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'SbsSubscriber' => array(
			'className' => 'SbsSubscriber',
			'foreignKey' => 'sbs_subscriber_organization_detail_id',
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
	
	public function addOrganizationDetails ($detailArray){	
			
			$session = new SessionComponent(); 
			$organization_name 		=	$session->read('organization_name');
			$time_zone 				= 	$session->read('time_zone');
			$billing_address_line1	=	$detailArray['billing_address_line1'];
			$billing_city			=	$detailArray['billing_city'];
			$billing_state			=	$detailArray['billing_state'];
			$billing_country		=	$detailArray['billing_country'];
			$billing_country_code	=   $detailArray['billing_country_code'];
			$billing_zip			=	$detailArray['billing_zip'];	
			$currencyName         	=   $detailArray['currencyName'];
			$currencySymbol         =   $detailArray['currencySymbol'];			
			
			$defaultFinancialYear 	= $this->CpnFinancialYear->getDefaultFinancialYear();
			$cpn_financial_year_id	= $defaultFinancialYear['CpnFinancialYear']['id'];
			$defaultLanguage 		= $this->CpnLanguage->getDefaultLanguage();
			$cpn_language_id		= $defaultLanguage['CpnLanguage']['id'];
			$homeCurrency			= $this->CpnCurrency->checkCurrency($currencyName,$currencySymbol);
			$cpn_currency_id		= $homeCurrency['CpnCurrency']['id'];			
				
			$saveOD->data = null;
			$this->create();			
			$saveOD->data['SbsSubscriberOrganizationDetail']['organization_name']  		= $organization_name;
			$saveOD->data['SbsSubscriberOrganizationDetail']['time_zone']  		 		= $time_zone;
			$saveOD->data['SbsSubscriberOrganizationDetail']['billing_address_line1'] 	= $billing_address_line1;
			$saveOD->data['SbsSubscriberOrganizationDetail']['billing_city'] 			= $billing_city;
			$saveOD->data['SbsSubscriberOrganizationDetail']['billing_state'] 			= $billing_state;
			$saveOD->data['SbsSubscriberOrganizationDetail']['billing_country'] 		= $billing_country;
			$saveOD->data['SbsSubscriberOrganizationDetail']['billing_country_code'] 	= $billing_country_code;
			$saveOD->data['SbsSubscriberOrganizationDetail']['billing_zip']				= $billing_zip;	
			$saveOD->data['SbsSubscriberOrganizationDetail']['shipping_address_line1'] 	= $billing_address_line1;
			$saveOD->data['SbsSubscriberOrganizationDetail']['shipping_city'] 			= $billing_city;
			$saveOD->data['SbsSubscriberOrganizationDetail']['shipping_state'] 			= $billing_state;
			$saveOD->data['SbsSubscriberOrganizationDetail']['shipping_country'] 		= $billing_country;
			$saveOD->data['SbsSubscriberOrganizationDetail']['shipping_country_code'] 	= $billing_country_code;
			$saveOD->data['SbsSubscriberOrganizationDetail']['shipping_zip']			= $billing_zip;
			$saveOD->data['SbsSubscriberOrganizationDetail']['cpn_financial_year_id']	= $cpn_financial_year_id;
			$saveOD->data['SbsSubscriberOrganizationDetail']['cpn_currency_id']			= $cpn_currency_id;	
			$saveOD->data['SbsSubscriberOrganizationDetail']['cpn_language_id']			= $cpn_language_id;
			if($this->save($saveOD->data)){
				$getLastInsertedId = $this->getLastInsertID();
				return $getLastInsertedId;
			} else {
				return 0;
			}
	}	
	
	public function getOrganizationDetails($currencyId = null){
		if($currencyId){
			$organizationDetails  =$this->find('all',array('conditions'=>array('SbsSubscriberOrganizationDetail.cpn_currency_id'=>$currencyId)));
			if($organizationDetails){
				return $organizationDetails;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function getOrganizationDetailById($organizationId){
		if($organizationId){
			$organizationDetails  =$this->find('first',array('conditions'=>array('SbsSubscriberOrganizationDetail.id'=>$organizationId)/*,'fields'=>array('SbsSubscriberOrganizationDetail.id','SbsSubscriberOrganizationDetail.organization_name')*/));
			if($organizationDetails){
				return $organizationDetails;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function getOrganizationDetailByName($companyName){
		if($companyName){
			$organizationDetails  =$this->find('list',array('conditions'=>array('SbsSubscriberOrganizationDetail.organization_name like'=>'%'.$companyName.'%'),'fields'=>array('SbsSubscriberOrganizationDetail.id','SbsSubscriberOrganizationDetail.id')));
			if($organizationDetails){
				return $organizationDetails;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	public function getLanguageByOrganisationId($id=null){
		  if($id){
			  	$organizationDetailLanguage =$this->find('first',array('conditions'=>array('SbsSubscriberOrganizationDetail.id'=>$id),'fields'=>array('SbsSubscriberOrganizationDetail.cpn_language_id')));
				if($organizationDetailLanguage){
					return $organizationDetailLanguage['SbsSubscriberOrganizationDetail']['cpn_language_id'];
				}else{
					return false;
				}
		  }
		
	}

}
