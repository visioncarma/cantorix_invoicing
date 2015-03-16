<?php
App::uses('AppController', 'Controller');
/**
 * CpnSubscriptionPlans Controller
 *
 * @property CpnSubscriptionPlan $CpnSubscriptionPlan
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CpnSubscriptionPlansController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

	public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = "cpn_layout";
      //	$this->Auth->allow('login','inactive');
      $this->Auth->allow('index','view','add','edit','delete');
      
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		configure::write('debug',2);
		
		
		$this->CpnSubscriptionPlan->recursive = 0;
		$this->set('cpnSubscriptionPlans', $this->Paginator->paginate());
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
		if ($this->request->is('post')) {
			$this->CpnSubscriptionPlan->create();
			if ($this->CpnSubscriptionPlan->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn subscription plan has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn subscription plan could not be saved. Please, try again.'));
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
		if (!$this->CpnSubscriptionPlan->exists($id)) {
			throw new NotFoundException(__('Invalid cpn subscription plan'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CpnSubscriptionPlan->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn subscription plan has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn subscription plan could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CpnSubscriptionPlan.' . $this->CpnSubscriptionPlan->primaryKey => $id));
			$this->request->data = $this->CpnSubscriptionPlan->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CpnSubscriptionPlan->id = $id;
		if (!$this->CpnSubscriptionPlan->exists()) {
			throw new NotFoundException(__('Invalid cpn subscription plan'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CpnSubscriptionPlan->delete()) {
			$this->Session->setFlash(__('The cpn subscription plan has been deleted.'));
		} else {
			$this->Session->setFlash(__('The cpn subscription plan could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
