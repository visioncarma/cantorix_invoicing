<?php
App::uses('AppModel', 'Model');
/**
 * SbsLanguage Model
 *
 * @property AcrClient $AcrClient
 * @property SbsSubscriberOrganizationDetail $SbsSubscriberOrganizationDetail
 */
class CpnLanguage extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'AcrClient' => array(
			'className' => 'AcrClient',
			'foreignKey' => 'cpn_language_id',
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
			'foreignKey' => 'cpn_language_id',
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

 	public function getDefaultLanguage () {
				
		$defaultLanguage = $this->find('first', array (
			'conditions' => array (
				'CpnLanguage.language' => 'English'
			)
		));	
		return $defaultLanguage; 
	}
	public function getLanguageByName($language){
		if($language){
			$defaultLanguage = $this->find('first', array (
			'conditions' => array (
				'CpnLanguage.language' => $language
			)
			));	
			if($defaultLanguage){
				return $defaultLanguage['CpnLanguage']['id']; 
			}else{
				return false;
			}
			
		}else{
			$defaultLanguage = $this->find('first', array (
			'conditions' => array (
				'CpnLanguage.language' => 'English'
			)
		));	
		return $defaultLanguage; 
		}
		
	}
	public function getLanguage(){
		
		$languages=$this->find('list',array('fields'=>array('CpnLanguage.language'),'order'=>array('CpnLanguage.language ASC')));
		return $languages;
	}
}
