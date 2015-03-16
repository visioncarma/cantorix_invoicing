<?php
App::uses('AppModel', 'Model');
/**
 * CpnCurrency Model
 *
 * @property AcrClient $AcrClient
 * @property SbsSubscriberOrganizationDetail $SbsSubscriberOrganizationDetail
 */
class CpnCurrency extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	/*public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'custom1' => array(
				'rule' => array('custom', '/^[a-z0-9 ]*$/i'),
				'message' => 'Currency Name Should not have special characters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notEmpty' => array('rule' => array('notEmpty'),
                'message' => 'Currency Name is mandatory'
            )
		),
		'code' => array(
            'rule1' => array('rule' => array('notEmpty'),
                'message' => 'Currency Code is mandatory'
            ),
        ),
	);*/

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'AcrClient' => array(
			'className' => 'AcrClient',
			'foreignKey' => 'cpn_currency_id',
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
		'SbsSubscriberOrganizationDetail' => array(
			'className' => 'SbsSubscriberOrganizationDetail',
			'foreignKey' => 'cpn_currency_id',
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
	
	public function checkCurrency($currencyName,$currencySymbol){
		$getCurrency = $this->find('first',array('conditions'=>array('CpnCurrency.code'=>$currencyName)));
		if(empty($getCurrency)){
			$saveCurrency->data = null;
			$saveCurrency->data['CpnCurrency']['code'] = $currencyName;
			$saveCurrency->data['CpnCurrency']['name'] = $currencySymbol;
			if($this->save($saveCurrency->data)){
				$currencyId = $this->getLastInsertID();
				$getCurrency = $this->find('first',array('conditions'=>array('CpnCurrency.id'=>$currencyId)));
			}
			
		}
		return $getCurrency;
		
	}
	
	public function updateCurrency($currencyId,$currencyCode,$currencyName){
		if($currencyId && $currencyCode && $currencyName){
			$saveCurrency->data = null;
			$saveCurrency->data['CpnCurrency']['id']   = $currencyId;
			$saveCurrency->data['CpnCurrency']['name'] = $currencyName;
			$saveCurrency->data['CpnCurrency']['code'] = $currencyCode;
			if($this->save($saveCurrency->data)){
				return $currencyId;
			}else{
				return false;
			}
		}
	}
	
	public function isCurrencyExist($currencyCode,$currencyName){
		$getCurrency = $this->find('first',array('conditions'=>array('CpnCurrency.code'=>trim($currencyCode))));
		if($getCurrency){
			return $getCurrency['CpnCurrency']['id'];
		}else{
			return false;
		}
	}
	public function getCurrencyById($currencyId){
		$getCurrency = $this->find('first',array('conditions'=>array('CpnCurrency.id'=>$currencyId)));
		return $getCurrency;
	}
	public function getCurrencyIdByCurrencyCode($currencyCode){
		$getCurrency = $this->find('first',array('conditions'=>array('CpnCurrency.code'=>$currencyCode)));
		if($getCurrency){
			return $getCurrency['CpnCurrency']['id'];
		}else{
			return false;
		}
	}
	
	public function getCurrency(){
		$get_currency = $this->find('list',array('fields'=>array('CpnCurrency.code'),'order'=>array('CpnCurrency.code ASC')));
		return $get_currency;
	}

}
