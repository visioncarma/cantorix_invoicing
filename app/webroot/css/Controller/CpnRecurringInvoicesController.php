<?php
App::uses('AppController', 'Controller');
/**
 * CpnRecurringInvoices Controller
 *
 * @property CpnRecurringInvoice $CpnRecurringInvoice
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CpnRecurringInvoicesController extends AppController {

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
		$this->CpnRecurringInvoice->recursive = 0;
		$this->set('cpnRecurringInvoices', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CpnRecurringInvoice->exists($id)) {
			throw new NotFoundException(__('Invalid cpn recurring invoice'));
		}
		$options = array('conditions' => array('CpnRecurringInvoice.' . $this->CpnRecurringInvoice->primaryKey => $id));
		$this->set('cpnRecurringInvoice', $this->CpnRecurringInvoice->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CpnRecurringInvoice->create();
			if ($this->CpnRecurringInvoice->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn recurring invoice has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn recurring invoice could not be saved. Please, try again.'));
			}
		}
		$cpnSubscriberInvoiceDetails = $this->CpnRecurringInvoice->CpnSubscriberInvoiceDetail->find('list');
		$this->set(compact('cpnSubscriberInvoiceDetails'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CpnRecurringInvoice->exists($id)) {
			throw new NotFoundException(__('Invalid cpn recurring invoice'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CpnRecurringInvoice->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn recurring invoice has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn recurring invoice could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CpnRecurringInvoice.' . $this->CpnRecurringInvoice->primaryKey => $id));
			$this->request->data = $this->CpnRecurringInvoice->find('first', $options);
		}
		$cpnSubscriberInvoiceDetails = $this->CpnRecurringInvoice->CpnSubscriberInvoiceDetail->find('list');
		$this->set(compact('cpnSubscriberInvoiceDetails'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CpnRecurringInvoice->id = $id;
		if (!$this->CpnRecurringInvoice->exists()) {
			throw new NotFoundException(__('Invalid cpn recurring invoice'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CpnRecurringInvoice->delete()) {
			$this->Session->setFlash(__('The cpn recurring invoice has been deleted.'));
		} else {
			$this->Session->setFlash(__('The cpn recurring invoice could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
