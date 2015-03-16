<?php
App::uses('AppController', 'Controller');
/**
 * SbsSubscriberTaxes Controller
 *
 * @property SbsSubscriberTax $SbsSubscriberTax
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SbsSubscriberTaxesController extends AppController {

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
		$this->SbsSubscriberTax->recursive = 0;
		$this->set('sbsSubscriberTaxes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SbsSubscriberTax->exists($id)) {
			throw new NotFoundException(__('Invalid sbs subscriber tax'));
		}
		$options = array('conditions' => array('SbsSubscriberTax.' . $this->SbsSubscriberTax->primaryKey => $id));
		$this->set('sbsSubscriberTax', $this->SbsSubscriberTax->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SbsSubscriberTax->create();
			if ($this->SbsSubscriberTax->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs subscriber tax has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs subscriber tax could not be saved. Please, try again.'));
			}
		}
		$sbsSubscribers = $this->SbsSubscriberTax->SbsSubscriber->find('list');
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
		if (!$this->SbsSubscriberTax->exists($id)) {
			throw new NotFoundException(__('Invalid sbs subscriber tax'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SbsSubscriberTax->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs subscriber tax has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs subscriber tax could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SbsSubscriberTax.' . $this->SbsSubscriberTax->primaryKey => $id));
			$this->request->data = $this->SbsSubscriberTax->find('first', $options);
		}
		$sbsSubscribers = $this->SbsSubscriberTax->SbsSubscriber->find('list');
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
		$this->SbsSubscriberTax->id = $id;
		if (!$this->SbsSubscriberTax->exists()) {
			throw new NotFoundException(__('Invalid sbs subscriber tax'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SbsSubscriberTax->delete()) {
			$this->Session->setFlash(__('The sbs subscriber tax has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sbs subscriber tax could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
