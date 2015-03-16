<?php
App::uses('AppController', 'Controller');
/**
 * CpnPaymentMethodAttributes Controller
 *
 * @property CpnPaymentMethodAttribute $CpnPaymentMethodAttribute
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CpnPaymentMethodAttributesController extends AppController {

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
		$this->CpnPaymentMethodAttribute->recursive = 0;
		$this->set('cpnPaymentMethodAttributes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CpnPaymentMethodAttribute->exists($id)) {
			throw new NotFoundException(__('Invalid cpn payment method attribute'));
		}
		$options = array('conditions' => array('CpnPaymentMethodAttribute.' . $this->CpnPaymentMethodAttribute->primaryKey => $id));
		$this->set('cpnPaymentMethodAttribute', $this->CpnPaymentMethodAttribute->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CpnPaymentMethodAttribute->create();
			if ($this->CpnPaymentMethodAttribute->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn payment method attribute has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn payment method attribute could not be saved. Please, try again.'));
			}
		}
		$cpnPaymentMethods = $this->CpnPaymentMethodAttribute->CpnPaymentMethod->find('list');
		$this->set(compact('cpnPaymentMethods'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CpnPaymentMethodAttribute->exists($id)) {
			throw new NotFoundException(__('Invalid cpn payment method attribute'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CpnPaymentMethodAttribute->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn payment method attribute has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn payment method attribute could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CpnPaymentMethodAttribute.' . $this->CpnPaymentMethodAttribute->primaryKey => $id));
			$this->request->data = $this->CpnPaymentMethodAttribute->find('first', $options);
		}
		$cpnPaymentMethods = $this->CpnPaymentMethodAttribute->CpnPaymentMethod->find('list');
		$this->set(compact('cpnPaymentMethods'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CpnPaymentMethodAttribute->id = $id;
		if (!$this->CpnPaymentMethodAttribute->exists()) {
			throw new NotFoundException(__('Invalid cpn payment method attribute'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CpnPaymentMethodAttribute->delete()) {
			$this->Session->setFlash(__('The cpn payment method attribute has been deleted.'));
		} else {
			$this->Session->setFlash(__('The cpn payment method attribute could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
