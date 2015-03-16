<?php
App::uses('AppController', 'Controller');
/**
 * CpnSubscriptionPlans Controller
 *
 * @property CpnSubscriptionPlan $CpnSubscriptionPlan
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SubscriptionPlansController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public $permission;
	public function beforeFilter() {
        parent::beforeFilter();
        $this->loadModel('CpnSubscriptionPlan');
        $this->layout = "cpn_layout";
	  $this->permission = $this->Session->read('Auth.AllPermissions.Manage Subscription Plans');
	  $settingsActive = 'active';
	$menuActive = 'Manage Subscription Plans';
	$this->set(compact('settingsActive','menuActive'));
	 // $this->Auth->allow('index','view','add','edit','delete');
	  
      
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->CpnSubscriptionPlan->recursive = 0;
		$this->set('cpnSubscriptionPlans', $this->Paginator->paginate('CpnSubscriptionPlan'));
		$permission = $this->permission;
		$this->set(compact('permission'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CpnSubscriptionPlan->exists($id)) {
			throw new NotFoundException(__('Invalid cpn subscription plan'));
		}
		$options = array('conditions' => array('CpnSubscriptionPlan.' . $this->CpnSubscriptionPlan->primaryKey => $id));
		$this->set('cpnSubscriptionPlan', $this->CpnSubscriptionPlan->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if ($this->request->is('post')) {
			$getSamePlan = $this->CpnSubscriptionPlan->getSubscriptionByType($this->data['CpnSubscriptionPlan']['type']);
				
			if(!$getSamePlan){
				$this->CpnSubscriptionPlan->create();
				if ($this->CpnSubscriptionPlan->save($this->request->data)) {
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<p>
												<strong>
													<i class="icon-ok"></i>
													Done!
												</strong>A new plan has been added to the system.</p>
										</div>'));
					return $this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>
												<i class="icon-remove"></i>' .
														'Sorry!												
											</strong>Subscription Plan could not be added.Please try again.<br />
										</div>'));
				}
			}else{
				$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>
												<i class="icon-remove"></i>' .
														'Sorry!												
											</strong>A Subscription Plan with same type already exists.Please try again.<br />
										</div>'));
			}
				
			}
		
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if($id){
			$id = $id;
		}else{
			$id = $this->data['CpnSubscriptionPlan']['id'];
		}
		if (!$this->CpnSubscriptionPlan->exists($id)) {
			throw new NotFoundException(__('Invalid cpn subscription plan'));
		}
		
		if (($this->request->is(array('post', 'put')) && ($this->data['CpnSubscriptionPlan']['id']))) {
			$this->request->onlyAllow('post', 'put');
			if ($this->CpnSubscriptionPlan->save($this->request->data)) {
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<p>
												<strong>
													<i class="icon-ok"></i>
													Done!
												</strong>Subscription Plan updated successfully.</p>
										</div>'));
				return $this->redirect(array('action' => 'index'));
			} else{
				$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>Changes to Subscription Plan failed.Please try again.<br />
										</div>'));
			}
		} else {
			$options = array('conditions' => array('CpnSubscriptionPlan.' . $this->CpnSubscriptionPlan->primaryKey => $id));
			$this->request->data = $this->CpnSubscriptionPlan->find('first', $options);
			$data = $this->CpnSubscriptionPlan->find('first', $options);
		}
		$this->set(compact('id','data'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->CpnSubscriptionPlan->id = $id;
		if (!$this->CpnSubscriptionPlan->exists()) {
			throw new NotFoundException(__('Invalid cpn subscription plan'));
		}
		$this->request->onlyAllow('post', 'delete');
		$this->loadModel('SbsSubscriber');
		$subscriberMappedToPlan = $this->SbsSubscriber->getSubscriberBySubscriptionPlan($id);
		if($subscriberMappedToPlan){
			$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>Subscription with this plan exists! Please delete the subscription and then try to delete the plan.<br />
										</div>'));
		
		}else{
			if ($this->CpnSubscriptionPlan->delete()) {
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<p>
												<strong>
													<i class="icon-ok"></i>
													Done!
												</strong>Subscription Plan removed from the system.</p>
										</div>'));
			} else {
				$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>Subscription Plan could not be removed.Please try again.<br />
										</div>'));
			}
		
		}
		return $this->redirect(array('action' => 'index'));
		
	}
}
