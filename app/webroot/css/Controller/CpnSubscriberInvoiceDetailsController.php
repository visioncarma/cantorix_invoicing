<?php
App::uses('AppController', 'Controller');
/**
 * CpnSubscriberInvoiceDetails Controller
 *
 * @property CpnSubscriberInvoiceDetail $CpnSubscriberInvoiceDetail
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CpnSubscriberInvoiceDetailsController extends AppController {

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
		$this->CpnSubscriberInvoiceDetail->recursive = 0;
		$this->set('cpnSubscriberInvoiceDetails', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CpnSubscriberInvoiceDetail->exists($id)) {
			throw new NotFoundException(__('Invalid cpn subscriber invoice detail'));
		}
		$options = array('conditions' => array('CpnSubscriberInvoiceDetail.' . $this->CpnSubscriberInvoiceDetail->primaryKey => $id));
		$this->set('cpnSubscriberInvoiceDetail', $this->CpnSubscriberInvoiceDetail->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CpnSubscriberInvoiceDetail->create();
			if ($this->CpnSubscriberInvoiceDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn subscriber invoice detail has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn subscriber invoice detail could not be saved. Please, try again.'));
			}
		}
		$sbsSubscribers = $this->CpnSubscriberInvoiceDetail->SbsSubscriber->find('list');
		$this->set(compact('sbsSubscribers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CpnSubscriberInvoiceDetail->exists($id)) {
			throw new NotFoundException(__('Invalid cpn subscriber invoice detail'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CpnSubscriberInvoiceDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn subscriber invoice detail has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn subscriber invoice detail could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CpnSubscriberInvoiceDetail.' . $this->CpnSubscriberInvoiceDetail->primaryKey => $id));
			$this->request->data = $this->CpnSubscriberInvoiceDetail->find('first', $options);
		}
		$sbsSubscribers = $this->CpnSubscriberInvoiceDetail->SbsSubscriber->find('list');
		$this->set(compact('sbsSubscribers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CpnSubscriberInvoiceDetail->id = $id;
		if (!$this->CpnSubscriberInvoiceDetail->exists()) {
			throw new NotFoundException(__('Invalid cpn subscriber invoice detail'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CpnSubscriberInvoiceDetail->delete()) {
			$this->Session->setFlash(__('The cpn subscriber invoice detail has been deleted.'));
		} else {
			$this->Session->setFlash(__('The cpn subscriber invoice detail could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
