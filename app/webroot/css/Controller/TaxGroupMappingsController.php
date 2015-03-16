<?php
App::uses('AppController', 'Controller');
/**
 * SbsSubscriberTaxGroupMappings Controller
 *
 * @property SbsSubscriberTaxGroupMapping $SbsSubscriberTaxGroupMapping
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SbsSubscriberTaxGroupMappingsController extends AppController {

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
		$this->SbsSubscriberTaxGroupMapping->recursive = 0;
		$this->set('sbsSubscriberTaxGroupMappings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SbsSubscriberTaxGroupMapping->exists($id)) {
			throw new NotFoundException(__('Invalid sbs subscriber tax group mapping'));
		}
		$options = array('conditions' => array('SbsSubscriberTaxGroupMapping.' . $this->SbsSubscriberTaxGroupMapping->primaryKey => $id));
		$this->set('sbsSubscriberTaxGroupMapping', $this->SbsSubscriberTaxGroupMapping->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SbsSubscriberTaxGroupMapping->create();
			if ($this->SbsSubscriberTaxGroupMapping->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs subscriber tax group mapping has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs subscriber tax group mapping could not be saved. Please, try again.'));
			}
		}
		$sbsSubscriberTaxes = $this->SbsSubscriberTaxGroupMapping->SbsSubscriberTax->find('list');
		$sbsSubscriberTaxGroups = $this->SbsSubscriberTaxGroupMapping->SbsSubscriberTaxGroup->find('list');
		$this->set(compact('sbsSubscriberTaxes', 'sbsSubscriberTaxGroups'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SbsSubscriberTaxGroupMapping->exists($id)) {
			throw new NotFoundException(__('Invalid sbs subscriber tax group mapping'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SbsSubscriberTaxGroupMapping->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs subscriber tax group mapping has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs subscriber tax group mapping could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SbsSubscriberTaxGroupMapping.' . $this->SbsSubscriberTaxGroupMapping->primaryKey => $id));
			$this->request->data = $this->SbsSubscriberTaxGroupMapping->find('first', $options);
		}
		$sbsSubscriberTaxes = $this->SbsSubscriberTaxGroupMapping->SbsSubscriberTax->find('list');
		$sbsSubscriberTaxGroups = $this->SbsSubscriberTaxGroupMapping->SbsSubscriberTaxGroup->find('list');
		$this->set(compact('sbsSubscriberTaxes', 'sbsSubscriberTaxGroups'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SbsSubscriberTaxGroupMapping->id = $id;
		if (!$this->SbsSubscriberTaxGroupMapping->exists()) {
			throw new NotFoundException(__('Invalid sbs subscriber tax group mapping'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SbsSubscriberTaxGroupMapping->delete()) {
			$this->Session->setFlash(__('The sbs subscriber tax group mapping has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sbs subscriber tax group mapping could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
