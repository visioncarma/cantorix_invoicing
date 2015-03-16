<?php
App::uses('AppController', 'Controller');
/**
 * CpnPaymentMethods Controller
 *
 * @property CpnPaymentMethod $CpnPaymentMethod
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CpnPaymentMethodsController extends AppController {

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
		
		$this->CpnPaymentMethod->recursive = 0;
		$this->set('cpnPaymentMethods', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CpnPaymentMethod->exists($id)) {
			throw new NotFoundException(__('Invalid cpn payment method'));
		}
		$options = array('conditions' => array('CpnPaymentMethod.' . $this->CpnPaymentMethod->primaryKey => $id));
		$this->set('cpnPaymentMethod', $this->CpnPaymentMethod->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CpnPaymentMethod->create();
			if ($this->CpnPaymentMethod->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn payment method has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn payment method could not be saved. Please, try again.'));
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
		if (!$this->CpnPaymentMethod->exists($id)) {
			throw new NotFoundException(__('Invalid cpn payment method'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CpnPaymentMethod->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn payment method has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn payment method could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CpnPaymentMethod.' . $this->CpnPaymentMethod->primaryKey => $id));
			$this->request->data = $this->CpnPaymentMethod->find('first', $options);
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
		$this->CpnPaymentMethod->id = $id;
		if (!$this->CpnPaymentMethod->exists()) {
			throw new NotFoundException(__('Invalid cpn payment method'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CpnPaymentMethod->delete()) {
			$this->Session->setFlash(__('The cpn payment method has been deleted.'));
		} else {
			$this->Session->setFlash(__('The cpn payment method could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
