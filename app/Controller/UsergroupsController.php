<?php
App::uses('AppController', 'Controller');
/**
 * SbsSubscriberTaxes Controller
 *
 * @property SbsSubscriberTax $SbsSubscriberTax
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class UsergroupsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public $uses = array('User');
	public $permission;
	
	/*Acts as a Constructor*/
	public function beforeFilter() {
        parent::beforeFilter();
		$this->layout = "cpn_layout";
	  	$this->permission = $this->Session->read('Auth.AllPermissions.Manage Roles');
    }
	

/**
 * @Author Ganesh
 * @Since 31-Jul-2014
 * @Version v.1
 * @Method Subscriber Add Usergroup Method
 * **/
 	public function add() {
 		$this->permission = $this->Session->read('Auth.AllPermissions.Roles');
 		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->layout = 'sbs_layout';
		$menuActive = 'Roles';
		$settingsActive = 'active';
		$subscriberID = $this->Session->read('Auth.User.sbs_subscriber_id');
		$menus = $this->User->getAllMenus('Subscriber');
		$title_for_layout = 'Add Role';
		$this->set(compact('menus','title_for_layout','subscriberID','menuActive','settingsActive'));
 		if(!empty($this->request->data)) {
 			$usergroupExist = $this->Acl->Aro->find('all',array('conditions'=>array('Aro.alias'=>trim($this->request->data['Usergroup']['group_name']),'Aro.sbs_subscriber_id'=>$subscriberID,''),'fields'=>array('Aro.id')));
			if(empty($usergroupExist)) {
				if($this->User->addUserGroup($this->request->data,'Subscriber',0,$subscriberID)) {
			 		$this->Session->setFlash('<div class="alert alert-block alert-success">User role has been created</div>');
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">User role couldn\'t be created.</div>');
				}
				$this->refreshPermission();
				$this->getMenus('Subscriber');
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">User role exist! could\'t create duplicate user role!</div>');				
			}
			return $this->redirect(array('action' => 'index'));
 		}
	}


/**
 * @Author Ganesh
 * @Since 31-Jul-2014
 * @Version v.1
 * @Method Subscriber Usergroups List Page
 * **/
	public function index() {
		$this->permission = $this->Session->read('Auth.AllPermissions.Roles');
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if(!$this->request->is('ajax')){
			$this->layout = 'sbs_layout';
		}
		$title_for_layout = 'Roles';
		$menuActive = 'Roles';
		$settingsActive = 'active';
		$permission = $this->permission;
		$this->loadModel('SbsSubscriber');
		$subscriberID = $this->Session->read('Auth.User.sbs_subscriber_id');
		$usergroups = $this->User->getUsergroups('Subscriber',$subscriberID);
		$this->loadModel('SbsSubscriberSetting');
		$settings = $this->SbsSubscriberSetting->defaultSettings($subscriberID);
		$limit = $settings['SbsSubscriberSetting']['lines_per_page'];
		$this->set(compact('title_for_layout','menuActive','permission','settingsActive','subscriberID'));
		$userGroup = $this->Acl->Aro;
		$userGroup->recursive = -1;
		$parenttIDDDD = $userGroup->find('first',array('conditions'=>array('Aro.parent_id'=>NULL,'Aro.foreign_key'=>NULL,'Aro.sbs_subscriber_id'=>0,'Aro.alias'=>'Subscriber'),'fields'=>array('Aro.id')));
		$adminUsergroup = $userGroup->find('first',array('conditions'=>array('Aro.parent_id' => $parenttIDDDD['Aro']['id'],'Aro.sbs_subscriber_id'=>$subscriberID)));
		$this->Paginator->settings = array('conditions'=>array('Aro.foreign_key IS NULL','Aro.parent_id'=>$parenttIDDDD['Aro']['id'],'Aro.sbs_subscriber_id'=>$subscriberID),'limit'=>$limit,'fields'=>array('id','alias'));
		$usergroups = $this->Paginator->paginate($userGroup);
		
		foreach($usergroups as $index => $value) {
			$usergroups[$index] = $value;
			$usergroups[$index]['users_count'] = $userGroup->find('count',array('conditions'=>array(
				'Aro.parent_id'=>$value['Aro']['id'],'NOT'=>array('Aro.foreign_key' => NULL)
			)));
		}
		
		foreach($usergroups as $index => $value) {
			$userIDSS = NULL;
			$usergroups[$index] = $value;
			$userIDSS = $userGroup->find('list',array('conditions'=>array('Aro.parent_id'=>$value['Aro']['id'],'NOT'=>array('Aro.foreign_key' => NULL)),'fields'=>array('Aro.foreign_key','Aro.foreign_key')));
			$usergroups[$index]['users_count'] = $this->User->find('count',array('conditions'=>array('User.id'=>$userIDSS)));
		}

		$this->set(compact('usergroups','adminUsergroup','subscriberID'));
	}


/**
 * @Author Ganesh
 * @Since 29-May-2014
 * @Version v.1
 * @Method Subscriber Edit Usergroup Method
 * **/
 	public function edit($id = null,$subscriberID = NULL, $page = 1) {
 		$this->permission = $this->Session->read('Auth.AllPermissions.Roles');
 		if($subscriberID != $this->Session->read('Auth.User.sbs_subscriber_id')) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
 		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$Aro = $this->Acl->Aro;
		$Aro->id = $id;
		$groupName = $Aro->find('first',array('field'=>array('id'),'conditions'=>array('id'=>$id,'sbs_subscriber_id'=>$this->Session->read('Auth.User.sbs_subscriber_id'))));
		if (empty($groupName)) {
			throw new NotFoundException(__('Invalid Role'));
		}
		$this->layout = 'sbs_layout';
		$menuActive = 'Roles';
		$settingsActive = 'active';
		$subscriberID = $this->Session->read('Auth.User.sbs_subscriber_id');
		$menus = $this->User->getAllMenus('Subscriber');
		$title_for_layout = 'Add Role';
		$this->set(compact('menus','title_for_layout','subscriberID','menuActive','settingsActive'));
		$permission = $this->User->getPermissions($id);
		$Aro = $this->Acl->Aro;
		$Aro->recursive = -1;
		//$groupName = $Aro->findById($id);
		$title_for_layout = 'Edit Role';
		$this->set(compact('menus','title_for_layout','permission','groupName'));
 		if(!empty($this->request->data)) {
 			if($this->User->addUserGroup($this->request->data,'Subscriber',$id,$subscriberID)) {
		 		$this->Session->setFlash(__('<div class="alert alert-block alert-success">User role has been updated!</div>'));
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Internal error occurred</div>');
			}
			$this->refreshPermission();
			$this->getMenus('Subscriber');
			return $this->redirect(array('action' => 'index'));
 		}
	}

 /**
 * @Author Ganesh
 * @Since 1-Aug-2014
 * @Version 1.1
 * @Method View User group
 * @Param 
 */ 	
	public function view($id = null,$subscriberID = NULL,$user_id = null,$delete = NULL) {
		$this->User->cacheQueries=false;
		$this->permission = $this->Session->read('Auth.AllPermissions.Roles');
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if(!$this->request->is('ajax')){
			$this->layout = 'sbs_layout';
		}
		$subsID = $this->Session->read('Auth.User.sbs_subscriber_id');
		$menuActive = 'Roles';
		$settingsActive = 'active';
		if($subscriberID == $subsID) {
			if(!$id) {$id = $this->request->params['id'];}
			if(!$user_id) {$this->request->params['user_id'];}
			$Aro = $this->Acl->Aro;
			$Aro->id = $id;
			if (!$Aro->exists()) {
				throw new NotFoundException(__('Invalid Role'));
			}
			$menus = $this->User->getAllMenus('Subscriber');
			$permission = $this->User->getPermissions($id);
			$permissions = $this->permission;
			$userPermission = $this->Session->read('Auth.AllPermissions.Users');
			$Aro = $this->Acl->Aro;
			$Aro->recursive = -1;
			$groupName = $Aro->findById($id);
			$title_for_layout = 'View Role';
			$user_groups = $this->User->getUsergroups('Subscriber',$subsID);
			$adminUser = $Aro->find('first',array('conditions'=>array('Aro.sbs_subscriber_id'=>$subscriberID,'NOT'=>array('Aro.foreign_key'=>NULL)),'order'=>array('Aro.id'=>'asc')));
			$this->loadModel('SbsSubscriberSetting');
			$settings = $this->SbsSubscriberSetting->defaultSettings();
			$limit = $settings['SbsSubscriberSetting']['lines_per_page'];
			if(!$limit) $limit=10;
			$limit=5;
			$userIDS = $Aro->find('list',array('conditions'=>array('Aro.parent_id'=>$id),'fields'=>array('Aro.foreign_key','Aro.foreign_key')));
			$this->Paginator->settings = array('conditions'=>array('User.id' => $userIDS,'User.sbs_subscriber_id'=>$subscriberID),'limit'=>$limit,'order'=>array('User.id'=>'desc'));
			$users = $this->Paginator->paginate('User');
			$this->set(compact('menuActive','settingsActive','menus','title_for_layout','permission','groupName','users','permissions','user_groups','id','subscriberID','adminUser','userPermission'));
	
		} else {
			$this->Session->setFlash(__('<div class="alert alert-danger">Error occurred.</div>'));
			return $this->redirect(array('action' => 'index'));
		}
		
	}


/**
 * @Author Ganesh
 * @Since 29-May-2014
 * @Version v.1
 * @Method Delete User from View Role
 * **/
	public function deleteUser($aroID = NULL,$userID = NULL,$subscriberID = NULL,$page = NULL) {
		$subsID = $this->Session->read('Auth.User.sbs_subscriber_id');
		if($subsID > 0) {
			$this->permission = $this->Session->read('Auth.AllPermissions.Roles');
		} else {
			$this->permission = $this->Session->read('Auth.AllPermissions.Manage Roles');
		}
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		
		if($subsID > 0) {
			if($subscriberID != $subsID) {
				$this->Session->setFlash(__('<div class="alert alert-danger">Error occurred.</div>'));
			}
		}
		$Aro = $this->Acl->Aro;
		$Aro->deleteAll(array('Aro.foreign_key'=> $userID), FALSE);
		if ($this->User->delete($userID)) {
			$this->User->cacheQueries=false;
			$this->Session->setFlash(__('<div class="alert alert-block alert-success">User has been deleted!</div>'));
		} else {
			$this->Session->setFlash(__('<div class="alert alert-danger">User could not be deleted. Please try again.</div>'));
		}
		if($subsID > 0) {
			return $this->redirect(array('action'=>'view',$aroID,$subscriberID,'page:'.$page));
		} else {
			return $this->redirect(array('action'=>'viewUsergroup',$aroID,'page:'.$page));
		}
		
	}
 
	
/**
 * @Author Ganesh
 * @Since 29-May-2014
 * @Version v.1
 * @Method Admin Panel Add Usergroup Method
 * **/
 	public function addUsergroup() {
 		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		
		$menus = $this->User->getAllMenus('Super Admin');
		$title_for_layout = 'Add Role';
		$menuActive = 'Manage Roles';
		$settingsActive = 'active';
		$this->set(compact('menus','title_for_layout','menuActive','settingsActive'));
 		if(!empty($this->request->data)) {
 			$parenttIDDDD = $this->Acl->Aro->find('first',array('conditions'=>array('Aro.parent_id'=>NULL,'Aro.foreign_key'=>NULL,'Aro.sbs_subscriber_id'=>0,'Aro.alias'=>'Admin'),'fields'=>array('Aro.id')));
 			$usergroupExist = $this->Acl->Aro->find('all',array('conditions'=>array('Aro.alias'=>trim($this->request->data['Usergroup']['group_name']),'Aro.parent_id'=>$parenttIDDDD['Aro']['id']),'fields'=>array('Aro.id')));
			if(empty($usergroupExist)) {
				if($this->User->addUserGroup($this->request->data,'Super Admin')) {
			 		$this->Session->setFlash('<div class="alert alert-block alert-success">User role has been created!</div>');
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">User role couldn\'t be created!</div>');
				}
				$this->refreshPermission();
				$this->getMenus('Super Admin');
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">User role exist! could\'t create duplicate user role!</div>');				
			}
			return $this->redirect(array('action' => 'manageUsergroup'));
 		}
	}
	
/**
 * @Author Ganesh
 * @Since 29-May-2014
 * @Version v.1
 * @Method To check role exist or not! Method used for Super Admin
 * **/	
	public function checkRole($AroId=NULL) {
		$this->autoRender = FALSE;
		if(!empty($this->data)) {
			if($AroId) {
				$usergroupExist = $this->Acl->Aro->find('all',array('conditions'=>array('Aro.alias'=>trim($this->request->data['Usergroup']['group_name']),'Aro.parent_id'=>'1','NOT'=>array('Aro.id'=>$AroId)),'fields'=>array('Aro.id')));
			} else {
				$usergroupExist = $this->Acl->Aro->find('all',array('conditions'=>array('Aro.alias'=>trim($this->request->data['Usergroup']['group_name']),'Aro.parent_id'=>'1'),'fields'=>array('Aro.id')));
			}
			if(empty($usergroupExist)) {
				return 'false';
			} else {
				return 'true';
			}
		}
	}
	



/**
 * @Author Ganesh
 * @Since 29-May-2014
 * @Version v.1
 * @Method To check role exist or not! Method used for Subscriber
 * **/	
	public function checkSubscribersRole($subsID = NULL,$AroID = NULL) {
		$this->autoRender = FALSE;
		if(!empty($this->data)) {
			if($AroID) {
				$usergroupExist = $this->Acl->Aro->find('all',array('conditions'=>array('Aro.alias'=>trim($this->request->data['Usergroup']['group_name']),'NOT'=>array('Aro.id'=>$AroID),'Aro.sbs_subscriber_id'=>$subsID),'fields'=>array('Aro.id')));
			} else {
				$usergroupExist = $this->Acl->Aro->find('all',array('conditions'=>array('Aro.alias'=>trim($this->request->data['Usergroup']['group_name']),'Aro.sbs_subscriber_id'=>$subsID),'fields'=>array('Aro.id')));
			}
			
			if(empty($usergroupExist)) {
				return 'false';
			} else {
				return 'true';
			}
		}
	}



	
/**
 * @Author Ganesh
 * @Since 29-May-2014
 * @Version v.1
 * @Method Subscriber Add Usergroup Method
 * **/
 	public function editUsergroup($id = null) {
 		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$Fraud = $this->User->checkFraudUsergroupAdmin($id);
		if(!$Fraud) {
			$menus = $this->User->getAllMenus('Super Admin');
			$permission = $this->User->getPermissions($id);
			$Aro = $this->Acl->Aro;
			$Aro->recursive = -1;
			$groupName = $Aro->findById($id);
			$title_for_layout = 'Edit Role';
			$menuActive = 'Manage Roles';
			$settingsActive = 'active';
			$this->set(compact('menus','title_for_layout','permission','groupName','menuActive','settingsActive'));
			if(!empty($this->request->data)) {
				if($this->User->addUserGroup($this->request->data,'Super Admin',$id)) {
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">User role has been updated!</div>'));
				} else {
					$this->Session->setFlash(__('<div class="alert alert-danger">User role couldn\'t update!</div>'));
				}
				$this->refreshPermission();
				$this->getMenus('Super Admin');
				return $this->redirect(array('action' => 'manageUsergroup'));
			}
		} else {
			$this->redirect(array('controller'=>'users','action'=>'accessDenied'));
		}
	}



	 
 /**
 * @Author Ganesh
 * @Since 29-May-2014
 * @Version v.1
 * @Method Subscriber Add Usergroup Method
 * **/
	public 	function manageUsergroup()	{
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('CpnSetting');
		$title_for_layout = 'Manage Roles'; $menuActive = 'Manage Roles'; $settingsActive = 'active'; $permission = $this->permission;
		$userGroup = $this->Acl->Aro; $userGroup->recursive = -1; $settings = $this->CpnSetting->getAllSettings();
		$limit = $settings['CpnSetting']['lines_per_page'];
		$parenttIDDDD = $userGroup->find('first',array('conditions'=>array('Aro.parent_id'=>NULL,'Aro.foreign_key'=>NULL,'Aro.sbs_subscriber_id'=>0,'Aro.alias'=>'Admin'),'fields'=>array('Aro.id')));
		$adminUsergroup = $userGroup->find('first',array('conditions'=>array('Aro.parent_id' => $parenttIDDDD['Aro']['id'],'Aro.alias'=>'Admin')));
		$this->Paginator->settings = array('conditions'=>array('Aro.foreign_key IS NULL','Aro.parent_id'=>$parenttIDDDD['Aro']['id']),'limit'=>$limit,'fields'=>array('id','alias'));
		$usergroups = $this->Paginator->paginate($userGroup);
		foreach($usergroups as $index => $value) {
			$userIDSS = NULL;
			$usergroups[$index] = $value;
			$userIDSS = $userGroup->find('list',array('conditions'=>array('Aro.parent_id'=>$value['Aro']['id'],'NOT'=>array('Aro.foreign_key' => NULL)),'fields'=>array('Aro.foreign_key','Aro.foreign_key')));
			$usergroups[$index]['users_count'] = $this->User->find('count',array('conditions'=>array('User.id'=>$userIDSS)));
		}
		$this->set(compact('usergroups','adminUsergroup','title_for_layout','menuActive','permission','settingsActive'));
	}
	
/**
 * @Author Ganesh
 * @Since 29-May-2014
 * @Version 1.1
 * @Method Delete Roles
 * @Param string $id
 */
	public function delete($id = null) {
		$subscriberID = $this->Session->read('Auth.User.sbs_subscriber_id');
		if($subscriberID > 0) {
			$this->permission = $this->Session->read('Auth.AllPermissions.Roles');
		} else {
			$Fraud = $this->User->checkFraudUsergroupAdmin($id);
			if($Fraud) {
				$this->redirect(array('controller'=>'users','action'=>'accessDenied'));
			}
			$this->permission = $this->Session->read('Auth.AllPermissions.Manage Roles');
		}
		if($this->permission['_delete'] != 1) {
        	$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$Aro = $this->Acl->Aro;
		$Aro->id = $id;
		if (!$Aro->exists()) {
			throw new NotFoundException(__('Invalid Role'));
		}
		$this->loadModel('ArosAco');
		$usersList = $Aro->find('list',array('conditions'=>array('Aro.parent_id'=> $id),'fields'=>array('Aro.foreign_key','Aro.foreign_key')));
		$this->User->deleteAll(array('User.id'=> $usersList), FALSE);
		$Aro->deleteAll(array('Aro.parent_id'=> $id), FALSE);
		$this->ArosAco->deleteAll(array('ArosAco.aro_id' => $id), FALSE);
		if ($Aro->delete()) {
			$this->Session->setFlash(__('<div class="alert alert-block alert-success">User role and it\'s users has been deleted!</div>'));
		} else {
			$this->Session->setFlash(__('<div class="alert alert-danger">User role could not be deleted. Please, try again.</div>'));
		}
		$this->refreshPermission();
		if($subscriberID > 0) {
			$this->getMenus('Subscriber');
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->getMenus('Super Admin');
			return $this->redirect(array('action' => 'manageUsergroup'));
		}	
	}
	
	
	
/**
 * @Author Ganesh
 * @Since 17-Sep-2014
 * @Version v.1
 * @Method Admin Control Panel Delete Multiple Usergroup Method
 * **/
	public function deleteACAll() {
		$subscriberID = $this->Session->read('Auth.User.sbs_subscriber_id');
		foreach ($this->data['delete'] as $RoleIdd => $isDelete) {
			if($isDelete == 1) {
				$roleArray[$RoleIdd] = $RoleIdd;
			}
		}
		if(!empty($roleArray)) {
			$this->loadModel('ArosAco');
			$Aro = $this->Acl->Aro;
			if($subscriberID > 0) {
				$usersList = $Aro->find('list',array('conditions'=>array('Aro.parent_id'=> $roleArray,'Aro.sbs_subscriber_id'=>$subscriberID),'fields'=>array('Aro.foreign_key','Aro.foreign_key')));
				$roleArray1 = $Aro->find('list',array('conditions'=>array('Aro.id'=> $roleArray,'Aro.sbs_subscriber_id'=>$subscriberID),'fields'=>array('Aro.id','Aro.id')));
			} else {
				$usersList = $Aro->find('list',array('conditions'=>array('Aro.parent_id'=> $roleArray,'Aro.sbs_subscriber_id'=>0),'fields'=>array('Aro.foreign_key','Aro.foreign_key')));
				$roleArray1 = $Aro->find('list',array('conditions'=>array('Aro.id'=> $roleArray,'Aro.sbs_subscriber_id'=>0),'fields'=>array('Aro.id','Aro.id')));
			}
			if(!empty($usersList)) {
				$this->User->deleteAll(array('User.id'=> $usersList), FALSE);
				$Aro->deleteAll(array('Aro.foreign_key'=>$usersList), FALSE);
			}
			if(!empty($roleArray1)) {
				$this->ArosAco->deleteAll(array('ArosAco.aro_id' => $roleArray1), FALSE);
				if ($Aro->deleteAll(array('Aro.id'=> $roleArray1), FALSE)) {
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">User role and it\'s users has been deleted!</div>'));
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">User roles could not be deleted.</div>');
				}
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Select atleast one role to delete.</div>');
			}
			$this->refreshPermission();
		} else {
			$this->Session->setFlash('<div class="alert alert-danger">Select atleast one role to delete.</div>');
		}
		if($subscriberID > 0) {
			$this->getMenus('Subscriber');
			return $this->redirect(array('action' => 'index'));
		} else {
			$this->getMenus('Super Admin');
			return $this->redirect(array('action' => 'manageUsergroup'));
		}
	}	
	
	 
/**
 * @Author Ganesh
 * @Since 3-Jun-2014
 * @Version 1.1
 * @Method View User group
 * @Param 
 */ 	
	public function viewUsergroup($id = null,$page = NULL) {
		$this->User->cacheQueries=false;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if(!$id) {$id = $this->request->params['id'];}
		if(!$user_id) {$this->request->params['user_id'];}
		$Fraud = $this->User->checkFraudUsergroupAdmin($id);
		if(!$Fraud) {
			$Aro = $this->Acl->Aro;
			$Aro->id = $id;
			if (!$Aro->exists()) {
				throw new NotFoundException(__('Invalid Role'));
			}
			$menuActive = 'Manage Roles';
			$settingsActive = 'active';
			$menus = $this->User->getAllMenus('Super Admin');
			$permission = $this->User->getPermissions($id);
			$permissions = $this->permission;
			$userPermission = $this->Session->read('Auth.AllPermissions.Manage Users');
			$Aro = $this->Acl->Aro;
			$Aro->recursive = -1;
			$groupName = $Aro->findById($id);
			$title_for_layout = 'View Role';
			$user_groups = $this->User->getUsergroups('Super Admin');
			$parenttIDDDD = $Aro->find('first',array('conditions'=>array('Aro.parent_id'=>NULL,'Aro.foreign_key'=>NULL,'Aro.sbs_subscriber_id'=>0,'Aro.alias'=>'Admin'),'fields'=>array('Aro.id')));
			$adminUserGroup = $Aro->find('first',array('conditions'=>array('Aro.alias'=>'Admin','Aro.parent_id'=>$parenttIDDDD['Aro']['id']),'fields'=>array('Aro.id')));
			$adminUser = $Aro->find('first',array('conditions'=>array('Aro.parent_id'=>$adminUserGroup['Aro']['id'])));
			$this->loadModel('CpnSetting');
			$settings = $this->CpnSetting->getAllSettings();
			$limit = $settings['CpnSetting']['lines_per_page'];
			if(!$limit) $limit=10;
			$limit=2;
			$userIDS = $Aro->find('list',array('conditions'=>array('Aro.parent_id'=>$id),'fields'=>array('Aro.foreign_key','Aro.foreign_key')));
			$this->Paginator->settings = array('conditions'=>array('User.id' => $userIDS),'limit'=>$limit,'order'=>array('User.id'=>'desc'));
			$users = $this->Paginator->paginate('User');
			$this->set(compact('menuActive','settingsActive','menus','title_for_layout','permission','groupName','users','permissions','user_groups','id','subscriberID','adminUser','userPermission'));
		} else {
			$this->redirect(array('controller'=>'users','action'=>'accessDenied'));
		}
	}
	
}