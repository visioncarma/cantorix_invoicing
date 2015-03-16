<?php
App::uses('AppController', 'Controller');
/**
 * SbsPaymentMethodValues Controller
 *
 * @property SbsPaymentMethodValue $SbsPaymentMethodValue
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SbsPaymentMethodValuesController extends AppController {

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
		$this->SbsPaymentMethodValue->recursive = 0;
		$this->set('sbsPaymentMethodValues', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SbsPaymentMethodValue->exists($id)) {
			throw new NotFoundException(__('Invalid sbs payment method value'));
		}
		$options = array('conditions' => array('SbsPaymentMethodValue.' . $this->SbsPaymentMethodValue->primaryKey => $id));
		$this->set('sbsPaymentMethodValue', $this->SbsPaymentMethodValue->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SbsPaymentMethodValue->create();
			if ($this->SbsPaymentMethodValue->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs payment method value has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs payment method value could not be saved. Please, try again.'));
			}
		}
		$subscribers = $this->SbsPaymentMethodValue->Subscriber->find('list');
		$cpnPaymentMethods = $this->SbsPaymentMethodValue->CpnPaymentMethod->find('list');
		$cpnPaymentAttributes = $this->SbsPaymentMethodValue->CpnPaymentAttribute->find('list');
		$this->set(compact('subscribers', 'cpnPaymentMethods', 'cpnPaymentAttributes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SbsPaymentMethodValue->exists($id)) {
			throw new NotFoundException(__('Invalid sbs payment method value'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SbsPaymentMethodValue->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs payment method value has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs payment method value could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SbsPaymentMethodValue.' . $this->SbsPaymentMethodValue->primaryKey => $id));
			$this->request->data = $this->SbsPaymentMethodValue->find('first', $options);
		}
		$subscribers = $this->SbsPaymentMethodValue->Subscriber->find('list');
		$cpnPaymentMethods = $this->SbsPaymentMethodValue->CpnPaymentMethod->find('list');
		$cpnPaymentAttributes = $this->SbsPaymentMethodValue->CpnPaymentAttribute->find('list');
		$this->set(compact('subscribers', 'cpnPaymentMethods', 'cpnPaymentAttributes'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SbsPaymentMethodValue->id = $id;
		if (!$this->SbsPaymentMethodValue->exists()) {
			throw new NotFoundException(__('Invalid sbs payment method value'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SbsPaymentMethodValue->delete()) {
			$this->Session->setFlash(__('The sbs payment method value has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sbs payment method value could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
