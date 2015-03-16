<?php
App::uses('AppController', 'Controller');
/**
 * SbsSubscriberCpnCurrencyMappings Controller
 *
 * @property SbsSubscriberCpnCurrencyMapping $SbsSubscriberCpnCurrencyMapping
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SubscriberCurrencyController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->SbsSubscriberCpnCurrencyMapping->recursive = 0;
		$this->set('sbsSubscriberCpnCurrencyMappings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SbsSubscriberCpnCurrencyMapping->exists($id)) {
			throw new NotFoundException(__('Invalid sbs subscriber cpn currency mapping'));
		}
		$options = array('conditions' => array('SbsSubscriberCpnCurrencyMapping.' . $this->SbsSubscriberCpnCurrencyMapping->primaryKey => $id));
		$this->set('sbsSubscriberCpnCurrencyMapping', $this->SbsSubscriberCpnCurrencyMapping->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SbsSubscriberCpnCurrencyMapping->create();
			if ($this->SbsSubscriberCpnCurrencyMapping->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs subscriber cpn currency mapping has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs subscriber cpn currency mapping could not be saved. Please, try again.'));
			}
		}
		$sbsSubscribers = $this->SbsSubscriberCpnCurrencyMapping->SbsSubscriber->find('list');
		$cpnCurrencies = $this->SbsSubscriberCpnCurrencyMapping->CpnCurrency->find('list');
		$this->set(compact('sbsSubscribers', 'cpnCurrencies'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SbsSubscriberCpnCurrencyMapping->exists($id)) {
			throw new NotFoundException(__('Invalid sbs subscriber cpn currency mapping'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SbsSubscriberCpnCurrencyMapping->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs subscriber cpn currency mapping has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs subscriber cpn currency mapping could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SbsSubscriberCpnCurrencyMapping.' . $this->SbsSubscriberCpnCurrencyMapping->primaryKey => $id));
			$this->request->data = $this->SbsSubscriberCpnCurrencyMapping->find('first', $options);
		}
		$sbsSubscribers = $this->SbsSubscriberCpnCurrencyMapping->SbsSubscriber->find('list');
		$cpnCurrencies = $this->SbsSubscriberCpnCurrencyMapping->CpnCurrency->find('list');
		$this->set(compact('sbsSubscribers', 'cpnCurrencies'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SbsSubscriberCpnCurrencyMapping->id = $id;
		if (!$this->SbsSubscriberCpnCurrencyMapping->exists()) {
			throw new NotFoundException(__('Invalid sbs subscriber cpn currency mapping'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SbsSubscriberCpnCurrencyMapping->delete()) {
			$this->Session->setFlash(__('The sbs subscriber cpn currency mapping has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sbs subscriber cpn currency mapping could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
