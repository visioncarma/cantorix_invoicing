<?php
App::uses('AppController', 'Controller');
/**
 * SbsSubscriberTaxGroups Controller
 *
 * @property SbsSubscriberTaxGroup $SbsSubscriberTaxGroup
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SbsSubscriberTaxGroupsController extends AppController {

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
		$this->SbsSubscriberTaxGroup->recursive = 0;
		$this->set('sbsSubscriberTaxGroups', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SbsSubscriberTaxGroup->exists($id)) {
			throw new NotFoundException(__('Invalid sbs subscriber tax group'));
		}
		$options = array('conditions' => array('SbsSubscriberTaxGroup.' . $this->SbsSubscriberTaxGroup->primaryKey => $id));
		$this->set('sbsSubscriberTaxGroup', $this->SbsSubscriberTaxGroup->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SbsSubscriberTaxGroup->create();
			if ($this->SbsSubscriberTaxGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs subscriber tax group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs subscriber tax group could not be saved. Please, try again.'));
			}
		}
		$sbsSubscribers = $this->SbsSubscriberTaxGroup->SbsSubscriber->find('list');
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
		if (!$this->SbsSubscriberTaxGroup->exists($id)) {
			throw new NotFoundException(__('Invalid sbs subscriber tax group'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SbsSubscriberTaxGroup->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs subscriber tax group has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs subscriber tax group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SbsSubscriberTaxGroup.' . $this->SbsSubscriberTaxGroup->primaryKey => $id));
			$this->request->data = $this->SbsSubscriberTaxGroup->find('first', $options);
		}
		$sbsSubscribers = $this->SbsSubscriberTaxGroup->SbsSubscriber->find('list');
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
		$this->SbsSubscriberTaxGroup->id = $id;
		if (!$this->SbsSubscriberTaxGroup->exists()) {
			throw new NotFoundException(__('Invalid sbs subscriber tax group'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SbsSubscriberTaxGroup->delete()) {
			$this->Session->setFlash(__('The sbs subscriber tax group has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sbs subscriber tax group could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
