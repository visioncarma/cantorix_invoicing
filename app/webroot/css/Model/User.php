<?php
App::uses('AppModel', 'Model');
App::import('Component', 'SessionComponent'); 
/**
 * User Model
 *
 * @property SbsSubscriber $SbsSubscriber
 */
class User extends AppModel {


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
	
	public function beforeSave($options = array()) {
		if($this->data['User']['password']){
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
        return true;
    }	
		
	//var $useTable = false; //i dont have a table right now, just testing captcha!
	var $name='User';
	var $captcha = ''; //intializing captcha var

	var $validate = array(
			'captcha'=>array(
				'rule' => array('matchCaptcha'),
				'message'=>'Failed validating human check.'
			),
		);

	function matchCaptcha($inputValue)	{
		return $inputValue['captcha']==$this->getCaptcha(); //return true or false after comparing submitted value with set value of captcha
	}

	function setCaptcha($value)	{
		$this->captcha = $value; //setting captcha value
	}

	function getCaptcha()	{
		return $this->captcha; //getting captcha value
	}	
	
	
	public function addSubscriber ($sbs_subscriber_id, $password){
		
		$session = new SessionComponent(); 		
		$username  = $session->read('username');
		$email     = $session->read('email');
		$active	   = 'N';
		$user_type = 'Subscriber';
		$firstname = $session->read('name');
		$lastname = $session->read('surname');
			
        $saveUser->data = null;
		$this->create();			
		$saveUser->data['User']['username']  			= $username;
		$saveUser->data['User']['email']				= $email;
		$saveUser->data['User']['password']				= $password;
		$saveUser->data['User']['active']				= $active;
		$saveUser->data['User']['user_type']			= $user_type;
		$saveUser->data['User']['sbs_subscriber_id']	= $sbs_subscriber_id;	
		$saveUser->data['User']['firstname']	        = $firstname;		
		$saveUser->data['User']['lastname']	            = $lastname;
		$this->save($saveUser->data);
		$lastuser = $this->getLastInsertID();
		$email     = $session->write('userIDD',$lastuser);
		if($lastuser) {
			/*Creating Admin Usergroup for subscribers*/
			$Acl = new AclComponent();
			$aro = $Acl->Aro;
			$data     = null;
			$aro->create();
			$data['alias']       = 'Admin';
			$data['parent_id']   = 2;
			$data['model']       = "Usergroup";
			$data['foreign_key'] = null;
			$data['sbs_subscriber_id'] = $sbs_subscriber_id;
			$aro->save($data);
			$usergroupId = $aro->getLastinsertId();
			/*End Usergroup*/
			
			
			/*Creating Permissions for usergroup*/
			$aco = $Acl->Aco;
			$AroAco = Classregistry::init('ArosAco');
			$menus = $aco->find('all',array('conditions'=>array('Aco.user_type'=>'Subscriber')));
			foreach($menus as $menu) {
				$permisssion['ArosAco']['aro_id'] = $usergroupId;
				$permisssion['ArosAco']['aco_id'] = $menu['Aco']['id'];
				$permisssion['ArosAco']['_create'] = 1;
				$permisssion['ArosAco']['_read'] = 1;
				$permisssion['ArosAco']['_update'] = 1;
				$permisssion['ArosAco']['_delete'] = 1;
				$AroAco->create();
				$AroAco->save($permisssion);
			}
			/*End Permisions*/
			
			
			/*Mapping the user to Usergroup*/
			$data     = null;
			$aro->create();
			$data['alias']       = $saveUser->data['User']['email'];		
			$data['model']       = "User";
			$data['parent_id']   = $usergroupId;
			$data['foreign_key'] = $lastuser;
			$data['sbs_subscriber_id'] = $sbs_subscriber_id;
			$aro->save($data);
			/*End Mapping*/
			return 1;
		} else {
			return 0;
		}
		
	}


/**
 * @Author Ganesh
 * @Since 29-May-2014
 * @Version 1.1
 * @Method Add Subscriber Usergroup
 */	
 	public function sbsAddUserGroup($data = NULL) {
		 return TRUE;
	 }
	
/**
 * @Author Ganesh
 * @Since 2-Jun-2013
 * @Version 1.1
 * @Method get all menus based on user_type
 */	
	public function getAllMenus($usertype = null) {
		$Acl = new AclComponent();	
		$aco = $Acl->Aco;
		$aco->recursive = -1;
		$menus = $aco->find('all',array('conditions'=>array('Aco.user_type'=>$usertype,'Aco.parent_id'=>NULL),'fields' => array('Aco.id','Aco.parent_id','Aco.alias','Aco.order','Aco.url')
			,'order' => array('Aco.order ASC')));
		foreach($menus as $index => $menu) {
			$final[$index] = $menu;
			$final[$index]['Child'] = $aco->find('all',array(
				'conditions'=>array('Aco.parent_id'=>$menu['Aco']['id']),
				'fields' => array('Aco.id','Aco.parent_id','Aco.alias','Aco.order','Aco.url'),
				'order' => array('Aco.order ASC')
			));
		}
		return $final;
	}
	
/**
 * @Author Ganesh
 * @Since 2-Jun-2013
 * @Version 1.1
 * @Method addUsergroup
 */	
	public function addUserGroup($data = NULL,$user_type = NULL, $aro_id = NULL ,$subscriber_id = NULL) {
		$Acl = new AclComponent();
		$aro = $Acl->Aro;
		if(!empty($subscriber_id)) {
			$save['Aro']['sbs_subscriber_id'] = $subscriber_id;
		}
		if($user_type == 'Super Admin') {
			$save['Aro']['parent_id'] = 1;
		} else {
			$save['Aro']['parent_id'] = 2;
		}
		if($aro_id) {
			$save['Aro']['id'] = $aro_id;
		} else {
			$aro->create();
		}
		$save['Aro']['alias'] = trim($data['Usergroup']['group_name']);
		$save['Aro']['model'] = 'usergroup';
		
		if($aro->save($save)) {
			if($aro_id) {
				$aroId = $aro_id;
			} else {
				$aroId = $aro->getLastInsertId();
			}
			$ArosAco = Classregistry::init('ArosAco');
			foreach($data['Permission'] as $acoId => $permission) {
				$saveAroAco['ArosAco']['aro_id'] = $aroId;
				$saveAroAco['ArosAco']['aco_id'] = $acoId;
				$saveAroAco['ArosAco']['_create'] = $permission['_create'];
				$saveAroAco['ArosAco']['_read'] = $permission['_read'];
				$saveAroAco['ArosAco']['_update'] = $permission['_update'];
				$saveAroAco['ArosAco']['_delete'] = $permission['_delete'];
				if(empty($permission['id'])) {
					$ArosAco->create();
					$saveAroAco['ArosAco']['id'] = NULL;
				} else {
					$saveAroAco['ArosAco']['id'] = $permission['id'];
				}
				debug($saveAroAco);
				$ArosAco->save($saveAroAco);
			}
			return TRUE;
		} else {
			return FALSE;
		}
		return;
	}

/**
 * @Author Ganesh
 * @Since 2-Jun-2013
 * @Version 1.1
 * @Method get user group permissions
 * @Param usergroup id
 */
	public function getPermissions($aro_id = Null) {
		$ArosAco =  Classregistry::init('ArosAco');
		$permissions = $ArosAco->find('all',array('conditions'=>array('ArosAco.aro_id'=>$aro_id)));
		foreach($permissions as $permission) {
			$final[$permission['ArosAco']['aco_id']] = $permission['ArosAco'];
		}
		return $final;
	}
	
/**
 * @Author Ganesh
 * @Since 2-Jun-2013
 * @Version 1.1
 * @Method get users for usergroup
 * @Param usergroup id
 */
	public function getUsersList($aro_id = NULL,$subscriberID = NULL) {
		$Acl = new AclComponent();
		$Aro = $Acl->Aro;
		if($subscriberID) {
			$users = $this->find('list',array('conditions'=>array('User.sbs_subscriber_id'=>$subscriberID)));
			return $Aro->find('all',array('conditions'=>array('Aro.foreign_key'=>$users,'Aro.sbs_subscriber_id'=>$subscriberID),'order'=>array('Aro.id'=>'ASC')));
		} else {
			return $Aro->find('all',array('conditions'=>array('Aro.parent_id'=>$aro_id),'order'=>array('Aro.id'=>'ASC')));
		}
		
	}
	

/**
 * @Author Ganesh
 * @Since 2-Jun-2013
 * @Version 1.1
 * @Method get all usergroups based on user_type
 * @Param user_type, subscriber id
 */	
	public function getUsergroups($user_type = NULL,$subscriber_id = NULL) {
		$Acl = new AclComponent();
		$Aro = $Acl->Aro;
		if($user_type == 'Subscriber') {
			$usergroups = $Aro->find('list',array('conditions'=>array('Aro.parent_id'=>2,'Aro.foreign_key'=> NULL,'Aro.sbs_subscriber_id'=>$subscriber_id),'fields'=>array('Aro.id','Aro.alias')));
		} else {
			$usergroups = $Aro->find('list',array('conditions'=>array('Aro.parent_id'=>1,'Aro.foreign_key'=> NULL),'fields'=>array('Aro.id','Aro.alias')));
		}
		return $usergroups;
	}

/**
 * @Author Ganesh
 * @Since 5-Jun-2013
 * @Version 1.1
 * @Method create a new super user
 * @Param $this->data
 */
	public function saveNewUser($data = NULL) {
		$userSave = NULL;$aroSave = NULL;$userDetailSave = NULL;
		$userSave['User']['email'] = $data['UserNew']['email'];
		$userSave['User']['password'] = rand('1','10000');
		$userSave['User']['active'] = 'Y';
		$userSave['User']['firstname'] = $data['UserNew']['firstname'];
		$userSave['User']['lastname'] = $data['UserNew']['lastname'];
		$userSave['User']['user_type'] = 'Super Admin';
		$userSave['User']['username'] = $data['UserNew']['username'];
		$this->create();
		if($this->save($userSave)) {
			$Acl = new AclComponent();
			$aro = $Acl->Aro;
			$userId = $this->getLastInsertId();
			$aroSave['Aro']['parent_id'] = $data['UserNew']['role_id'];
			$aroSave['Aro']['model'] = 'Super User';
			$aroSave['Aro']['foreign_key'] = $userId;
			$aroSave['Aro']['alias'] = $data['UserNew']['email'];
			$aro->create();
			$aro->save($aroSave);
			return $userId;
		} else {
			return FALSE;
		}
	}


/**
 * @Author Ganesh
 * @Since 5-Jun-2013
 * @Version 1.1
 * @Method create a new super user
 * @Param $this->data
 */
	public function saveNewSubscriberUser($data = NULL, $subscriberId = NULL) {
		$userSave = NULL; $aroSave = NULL;
		$userSave['User']['email'] = $data['UserNew']['email'];
		$userSave['User']['password'] = rand('1','10000');
		$userSave['User']['active'] = 'Y';
		$userSave['User']['firstname'] = $data['UserNew']['firstname'];
		$userSave['User']['lastname'] = $data['UserNew']['lastname'];
		$userSave['User']['user_type'] = 'Subscriber';
		$userSave['User']['username'] = $data['UserNew']['username'];
		$userSave['User']['sbs_subscriber_id'] = $subscriberId;
		$this->create();
		if($this->save($userSave)) {
			$Acl = new AclComponent();
			$aro = $Acl->Aro;
			$userId = $this->getLastInsertId();
			$aroSave['Aro']['parent_id'] = $data['UserNew']['role_id'];
			$aroSave['Aro']['model'] = 'User';
			$aroSave['Aro']['foreign_key'] = $userId;
			$aroSave['Aro']['alias'] = $data['UserNew']['email'];
			$aroSave['Aro']['sbs_subscriber_id'] = $subscriberId;
			$aro->create();
			$aro->save($aroSave);
			return $userId;
		} else {
			return FALSE;
		}
	}





/**
 * @Author Ganesh
 * @Since 9-Jun-2013
 * @Version 1.1
 * @Method Archive user related data
 * @Param Subscriber id
 */
	public function archiveUser($subscriberId = NULL) {
		
		$defaultConfigVar = 'default';
		$dataSource0 = ConnectionManager::getDataSource($defaultConfigVar);
		$defaultDatabase =  $dataSource0->config['database'];
		
		$archiveConfigVar = 'archive';
		$dataSource = ConnectionManager::getDataSource($archiveConfigVar);
		$archiveDatabase = $dataSource->config['database'];
		
		/*Aro Table data*/
		$Acl = new AclComponent();
		$aro = $Acl->Aro;
		$aco->recursive = -1;
		$aco = $Acl->Aco;
		$aro->recursive = -1;
		$aros = $aro->find('all',array('conditions'=>array('Aro.sbs_subscriber_id'=>$subscriberId)));
		$menus = $aco->find('all');
		$aroIds = $aro->find('list',array('conditions'=>array('Aro.sbs_subscriber_id'=>$subscriberId),'fields'=>array('Aro.id')));
		/*End Aro Table data*/
		
		/*ArosAcos Table data*/
		$ArosAco = ClassRegistry::init('ArosAco');
		$arosacos = $ArosAco->find('all',array('conditions'=>array('ArosAco.aro_id'=>$aroIds)));
		/*End ArosAcos Table data*/
		
		/*Users Table data*/
		$users = $this->find('all',array('conditions'=>array('User.sbs_subscriber_id'=>$subscriberId)));
		/*End Users Table data*/
		
		$SbsSubscriberOrganizationDetail = ClassRegistry::init('SbsSubscriberOrganizationDetail'); 
		$SbsSubscriberSetting = ClassRegistry::init('SbsSubscriberSetting');
		$SbsSubscriber = ClassRegistry::init('SbsSubscriber');
		$CpnFinancialYear = ClassRegistry::init('CpnFinancialYear');
		$CpnLanguage = ClassRegistry::init('CpnLanguage');
		$CpnCurrency = ClassRegistry::init('CpnCurrency');
		$CpnSubscriptionPlan = ClassRegistry::init('CpnSubscriptionPlan');
		
		$subscriber = $SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$subscriberId)));
		$settings = $SbsSubscriberSetting->find('first',array('conditions'=>array('SbsSubscriberSetting.sbs_subscriber_id'=>$subscriberId)));
		$organization = $SbsSubscriberOrganizationDetail->find('first',array('conditions'=>array('SbsSubscriberOrganizationDetail.id'=>$subscriber['SbsSubscriber']['sbs_subscriber_organization_detail_id'])));
		
		$financialYears = $CpnFinancialYear->find('all');
		$languages = $CpnLanguage->find('all');
		$currencies = $CpnCurrency->find('all');
		$plans = $CpnSubscriptionPlan->find('all');
		
		/*Connect Archive database */
		$this->useDbConfig = $archiveConfigVar;
		$this->schemaName = $archiveDatabase;
		$CpnFinancialYear->useDbConfig = $archiveConfigVar;
		$CpnFinancialYear->schemaName = $archiveDatabase;
		$SbsSubscriberOrganizationDetail->useDbConfig = $archiveConfigVar;
		$SbsSubscriberOrganizationDetail->schemaName = $archiveDatabase;
		$SbsSubscriberSetting->useDbConfig = $archiveConfigVar;
		$SbsSubscriberSetting->schemaName = $archiveDatabase;
		$SbsSubscriber->useDbConfig = $archiveConfigVar;
		$SbsSubscriber->schemaName = $archiveDatabase;
		$CpnLanguage->useDbConfig = $archiveConfigVar;
		$CpnLanguage->schemaName = $archiveDatabase;
		$CpnCurrency->useDbConfig = $archiveConfigVar;
		$CpnCurrency->schemaName = $archiveDatabase;
		$CpnSubscriptionPlan->useDbConfig  = $archiveConfigVar;
		$CpnSubscriptionPlan->schemaName = $archiveDatabase;
		$aro->useDbConfig  = $archiveConfigVar;
		$aro->schemaName = $archiveDatabase;
		$aco->useDbConfig  = $archiveConfigVar;
		$aco->schemaName = $archiveDatabase;
		$ArosAco->useDbConfig  = $archiveConfigVar;
		$ArosAco->schemaName = $archiveDatabase;
		/*Connect Archive database */
		
		foreach ($financialYears as $financialYear) {
			$archive = $CpnFinancialYear->find('first',array('conditions'=>array('CpnFinancialYear.id'=>$financialYear['CpnFinancialYear']['id']),'fields'=>array('CpnFinancialYear.id')));
			if(empty($archive)) {
				$CpnFinancialYear->save($financialYear);
			}
		}
		
		foreach ($languages as $language) {
			$archiveLanguages = $CpnLanguage->find('first',array('conditions'=>array('CpnLanguage.id'=>$language['CpnLanguage']['id']),'fields'=>array('CpnLanguage.id')));
			if(empty($archiveLanguages)) {
				$CpnLanguage->save($language);
			}
		}
		
		foreach ($currencies as $currency) {
			$archiveCurrencies = $CpnCurrency->find('first',array('conditions'=>array('CpnCurrency.id'=>$currency['CpnCurrency']['id']),'fields'=>array('CpnCurrency.id')));
			if(empty($archiveCurrencies)) {
				$CpnCurrency->save($currency);
			}
		}
		
		foreach ($plans as $plan) {
			$archivePlans = $CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.id'=>$plan['CpnSubscriptionPlan']['id']),'fields'=>array('CpnSubscriptionPlan.id')));
			if(empty($archivePlans)) {
				$CpnSubscriptionPlan->save($plan);
			}
		}

		foreach ($menus as $menu) {
			$archiveMenus = $aco->find('first',array('conditions'=>array('Aco.id'=>$menu['Aco']['id']),'fields'=>array('Aco.id')));
			if(empty($archiveMenus)){
				$aco->save($menu);
			}
		}

		$SbsSubscriberOrganizationDetail->save($organization);
		$SbsSubscriber->save($subscriber);
		$SbsSubscriberSetting->save($settings);
		
		
		/*Aro Insert*/
		foreach($aros as $aroInsert) {
			$aro->save($aroInsert);
		}
		/*End Aro Insert*/
		
		/*ArosAco Insert*/
		foreach ($arosacos as $ArosAcoInsert) {
			$arosacos->save($ArosAcoInsert);
		}
		/*End ArosAco Insert*/
		
		/*Users Insert*/
		foreach ($users as $value) {
			$this->save($value,array('callbacks' => false));
		}
		/*End Users Insert*/
		
		
		/*Disconnect Archive database & Start default(cantorix) connection*/
		$this->useDbConfig = $defaultConfigVar;
		$this->schemaName = $defaultDatabase;
		$CpnFinancialYear->useDbConfig = $defaultConfigVar;
		$CpnFinancialYear->schemaName = $defaultDatabase;
		$SbsSubscriberOrganizationDetail->useDbConfig = $defaultConfigVar;
		$SbsSubscriberOrganizationDetail->schemaName = $defaultDatabase;
		$SbsSubscriberSetting->useDbConfig = $defaultConfigVar;
		$SbsSubscriberSetting->schemaName = $defaultDatabase;
		$SbsSubscriber->useDbConfig = $defaultConfigVar;
		$SbsSubscriber->schemaName = $defaultDatabase;
		$CpnCurrency->useDbConfig = $defaultConfigVar;
		$CpnCurrency->schemaName = $defaultDatabase;
		$CpnLanguage->useDbConfig = $defaultConfigVar;
		$CpnLanguage->schemaName = $defaultDatabase;
		$CpnSubscriptionPlan->useDbConfig = $defaultConfigVar;
		$CpnSubscriptionPlan->schemaName = $defaultDatabase;
		$aro->useDbConfig  = $defaultConfigVar;
		$aro->schemaName = $defaultDatabase;
		$aco->useDbConfig  = $defaultConfigVar;
		$aco->schemaName = $defaultDatabase;
		$ArosAco->useDbConfig  = $defaultConfigVar;
		$ArosAco->schemaName = $defaultDatabase;
		/*Disconnect Archive database  & Start default(cantorix) connection*/
		
		/*Delete All the archived records from cantorix database*/
		$ArosAco->deleteAll(array('ArosAco.aro_id'=>$aroIds),FALSE);
		$aro->deleteAll(array('Aro.sbs_subscriber_id'=>$subscriberId), FALSE);
		$this->deleteAll(array('User.sbs_subscriber_id'=>$subscriberId),FALSE);
		//$SbsSubscriberSetting->delete($settings['SbsSubscriberSetting']['id']);
		//$SbsSubscriberOrganizationDetail->delete($organization['SbsSubscriberOrganizationDetail']['id']);
		/*End Delete All the archived records from cantorix database*/
		
		return TRUE;
	}



/**
 * @Author Ganesh
 * @Since 9-Jun-2013
 * @Version 1.1
 * @Method Archive user related data
 * @Param Subscriber id
 */
	public function restoreArchivedUser($subscriberId = NULL) {
		
		$SbsSubscriberOrganizationDetail = ClassRegistry::init('SbsSubscriberOrganizationDetail'); 
		$SbsSubscriberSetting = ClassRegistry::init('SbsSubscriberSetting');
		$SbsSubscriber = ClassRegistry::init('SbsSubscriber');
		$ArosAco = ClassRegistry::init('ArosAco');
		$aro = ClassRegistry::init('Aro');
		
		$defaultConfigVar = 'default';
		$dataSource0 = ConnectionManager::getDataSource($defaultConfigVar);
		$defaultDatabase =  $dataSource0->config['database'];
		
		$archiveConfigVar = 'archive';
		$dataSource = ConnectionManager::getDataSource($archiveConfigVar);
		$archiveDatabase = $dataSource->config['database'];
		
		/*Connect Archive database */
		$this->useDbConfig = $archiveConfigVar;
		$this->schemaName = $archiveDatabase;
		$SbsSubscriberOrganizationDetail->useDbConfig = $archiveConfigVar;
		$SbsSubscriberOrganizationDetail->schemaName = $archiveDatabase;
		$SbsSubscriberSetting->useDbConfig = $archiveConfigVar;
		$SbsSubscriberSetting->schemaName = $archiveDatabase;
		$SbsSubscriber->useDbConfig = $archiveConfigVar;
		$SbsSubscriber->schemaName = $archiveDatabase;
		$aro->useDbConfig  = $archiveConfigVar;
		$aro->schemaName = $archiveDatabase;
		$ArosAco->useDbConfig  = $archiveConfigVar;
		$ArosAco->schemaName = $archiveDatabase;
		/*Connect Archive database */
		
		/*Aro Table data*/
		//$Acl = new AclComponent();
		
		//$aco->recursive = -1;
		//$aco = $Acl->Aco;
		$aro->recursive = -1;
		$aros = $aro->find('all',array('conditions'=>array('Aro.sbs_subscriber_id'=>$subscriberId)));
		$aroIds = $aro->find('list',array('conditions'=>array('Aro.sbs_subscriber_id'=>$subscriberId),'fields'=>array('Aro.id')));
		/*End Aro Table data*/
		
		/*ArosAcos Table data*/
		$arosacos = $ArosAco->find('all',array('conditions'=>array('ArosAco.aro_id'=>$aroIds)));
		/*End ArosAcos Table data*/
		
		/*Users Table data*/
		$users = $this->find('all',array('conditions'=>array('User.sbs_subscriber_id'=>$subscriberId)));
		/*End Users Table data*/
		
		$subscriber = $SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$subscriberId)));
		$settings = $SbsSubscriberSetting->find('first',array('conditions'=>array('SbsSubscriberSetting.sbs_subscriber_id'=>$subscriberId)));
		$organization = $SbsSubscriberOrganizationDetail->find('first',array('conditions'=>array('SbsSubscriberOrganizationDetail.id'=>$subscriber['SbsSubscriber']['sbs_subscriber_organization_detail_id'])));
		
		/*Disconnect Archive database & Start default(cantorix) connection*/
		$this->useDbConfig = $defaultConfigVar;
		$this->schemaName = $defaultDatabase;
		$SbsSubscriberOrganizationDetail->useDbConfig = $defaultConfigVar;
		$SbsSubscriberOrganizationDetail->schemaName = $defaultDatabase;
		$SbsSubscriberSetting->useDbConfig = $defaultConfigVar;
		$SbsSubscriberSetting->schemaName = $defaultDatabase;
		$SbsSubscriber->useDbConfig = $defaultConfigVar;
		$SbsSubscriber->schemaName = $defaultDatabase;
		$aro->useDbConfig  = $defaultConfigVar;
		$aro->schemaName = $defaultDatabase;
		$ArosAco->useDbConfig  = $defaultConfigVar;
		$ArosAco->schemaName = $defaultDatabase;
		/*Disconnect Archive database  & Start default(cantorix) connection*/
		
		/*Aro Insert*/
		foreach($aros as $aroInsert) {
			$aro->save($aroInsert);
		}
		/*End Aro Insert*/
		
		/*ArosAco Insert*/
		foreach ($arosacos as $ArosAcoInsert) {
			$arosacos->save($ArosAcoInsert);
		}
		/*End ArosAco Insert*/
		
		/*Users Insert*/
		foreach ($users as $value) {
			$this->save($value,array('callbacks' => false));
		}
		/*End Users Insert*/
		
		
		/*Connect Archive database */
		$this->useDbConfig = $archiveConfigVar;
		$this->schemaName = $archiveDatabase;
		$SbsSubscriberOrganizationDetail->useDbConfig = $archiveConfigVar;
		$SbsSubscriberOrganizationDetail->schemaName = $archiveDatabase;
		$SbsSubscriberSetting->useDbConfig = $archiveConfigVar;
		$SbsSubscriberSetting->schemaName = $archiveDatabase;
		$SbsSubscriber->useDbConfig = $archiveConfigVar;
		$SbsSubscriber->schemaName = $archiveDatabase;
		$aro->useDbConfig  = $archiveConfigVar;
		$aro->schemaName = $archiveDatabase;
		$ArosAco->useDbConfig  = $archiveConfigVar;
		$ArosAco->schemaName = $archiveDatabase;
		/*Connect Archive database */
		
		
		/*Delete All the archived records from cantorix database*/
		$ArosAco->deleteAll(array('ArosAco.aro_id'=>$aroIds),FALSE);
		$aro->deleteAll(array('Aro.sbs_subscriber_id'=>$subscriberId), FALSE);
		$this->deleteAll(array('User.sbs_subscriber_id'=>$subscriberId),FALSE);
		//$SbsSubscriberSetting->delete($settings['SbsSubscriberSetting']['id']);
		//$SbsSubscriberOrganizationDetail->delete($organization['SbsSubscriberOrganizationDetail']['id']);
		/*End Delete All the archived records from cantorix database*/
		
		
		/*Disconnect Archive database & Start default(cantorix) connection*/
		$this->useDbConfig = $defaultConfigVar;
		$this->schemaName = $defaultDatabase;
		$SbsSubscriberOrganizationDetail->useDbConfig = $defaultConfigVar;
		$SbsSubscriberOrganizationDetail->schemaName = $defaultDatabase;
		$SbsSubscriberSetting->useDbConfig = $defaultConfigVar;
		$SbsSubscriberSetting->schemaName = $defaultDatabase;
		$SbsSubscriber->useDbConfig = $defaultConfigVar;
		$SbsSubscriber->schemaName = $defaultDatabase;
		$aro->useDbConfig  = $defaultConfigVar;
		$aro->schemaName = $defaultDatabase;
		$ArosAco->useDbConfig  = $defaultConfigVar;
		$ArosAco->schemaName = $defaultDatabase;
		/*Disconnect Archive database  & Start default(cantorix) connection*/
		
		return TRUE;
	}

	public function deleteSubscriber($subscriberId = NULL, $connection = NULL) {
		
		$SbsSubscriberSetting = ClassRegistry::init('SbsSubscriberSetting');
		$ArosAco = ClassRegistry::init('ArosAco');
		$aro = ClassRegistry::init('Aro');
		
		$configVar = 'default';
		if($connection == 'archive') {
			$configVar = 'archive';
		} else {
			$configVar = 'default';
		}
		
		$dataSource = ConnectionManager::getDataSource($configVar);
		$database = $dataSource->config['database'];
		
		$SbsSubscriberSetting->useDbConfig = $configVar;
		$SbsSubscriberSetting->schemaName = $database;
			
		$ArosAco->useDbConfig = $configVar;
		$ArosAco->schemaName = $database;
		
		$aro->useDbConfig = $configVar;
		$aro->useDbConfig = $database;
		
		$aroIds = $aro->find('list',array('conditions'=>array('Aro.sbs_subscriber_id'=>$subscriberId),'fields'=>array('Aro.id')));
		$settings = $SbsSubscriberSetting->find('first',array('conditions'=>array('SbsSubscriberSetting.sbs_subscriber_id'=>$subscriberId)));
		
		/*Delete All records from cantorix database*/
		$ArosAco->deleteAll(array('ArosAco.aro_id'=>$aroIds),FALSE);
		$aro->deleteAll(array('Aro.sbs_subscriber_id'=>$subscriberId), FALSE);
		$this->deleteAll(array('User.sbs_subscriber_id'=>$subscriberId),FALSE);
		if(!empty($settings)) {
			$SbsSubscriberSetting->delete($settings['SbsSubscriberSetting']['id']);
		}
		/*End Delete All records from cantorix database*/

		return TRUE;
	}
  
    public function getUserInfoById($Id=null){
    	$user_detail= $this->find('first',array('conditions'=>array('User.id'=>$Id,'User.active'=>'Y')));
    	return $user_detail;
    }
	
/**
 * @Author Ganesh
 * @Since 20 Aug 2014
 * @Version v.1
 * @Method get ACTIVE user count for Subscriber Dashboard
 * **/
 	public function getActiveUserCount($subscriberID = NULL) {
 		return $this->find('count',array('conditions'=>array('User.active' => 'Y', 'User.sbs_subscriber_id' => $subscriberID)));
 	}	

}