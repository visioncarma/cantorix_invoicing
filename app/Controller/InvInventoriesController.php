<?php
App::uses('AppController', 'Controller');
/**
 * InvInventories Controller
 *
 * @property InvInventory $InvInventory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class InvInventoriesController extends AppController {

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
		$this->InvInventory->recursive = 0;
		$this->set('invInventories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->InvInventory->exists($id)) {
			throw new NotFoundException(__('Invalid inv inventory'));
		}
		$options = array('conditions' => array('InvInventory.' . $this->InvInventory->primaryKey => $id));
		$this->set('invInventory', $this->InvInventory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->InvInventory->create();
			if ($this->InvInventory->save($this->request->data)) {
				$this->Session->setFlash(__('The inv inventory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inv inventory could not be saved. Please, try again.'));
			}
		}
		$sbsSubscribers = $this->InvInventory->SbsSubscriber->find('list');
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
		if (!$this->InvInventory->exists($id)) {
			throw new NotFoundException(__('Invalid inv inventory'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->InvInventory->save($this->request->data)) {
				$this->Session->setFlash(__('The inv inventory has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inv inventory could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('InvInventory.' . $this->InvInventory->primaryKey => $id));
			$this->request->data = $this->InvInventory->find('first', $options);
		}
		$sbsSubscribers = $this->InvInventory->SbsSubscriber->find('list');
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
		$this->InvInventory->id = $id;
		if (!$this->InvInventory->exists()) {
			throw new NotFoundException(__('Invalid inv inventory'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->InvInventory->delete()) {
			$this->Session->setFlash(__('The inv inventory has been deleted.'));
		} else {
			$this->Session->setFlash(__('The inv inventory could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
