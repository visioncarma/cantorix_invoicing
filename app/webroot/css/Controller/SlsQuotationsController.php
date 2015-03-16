<?php
App::uses('AppController', 'Controller');
/**
 * SlsQuotations Controller
 *
 * @property SlsQuotation $SlsQuotation
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SlsQuotationsController extends AppController {

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
		$this->SlsQuotation->recursive = 0;
		$this->set('slsQuotations', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SlsQuotation->exists($id)) {
			throw new NotFoundException(__('Invalid sls quotation'));
		}
		$options = array('conditions' => array('SlsQuotation.' . $this->SlsQuotation->primaryKey => $id));
		$this->set('slsQuotation', $this->SlsQuotation->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SlsQuotation->create();
			if ($this->SlsQuotation->save($this->request->data)) {
				$this->Session->setFlash(__('The sls quotation has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sls quotation could not be saved. Please, try again.'));
			}
		}
		$acrClients = $this->SlsQuotation->AcrClient->find('list');
		$sbsSubscribers = $this->SlsQuotation->SbsSubscriber->find('list');
		$this->set(compact('acrClients', 'sbsSubscribers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SlsQuotation->exists($id)) {
			throw new NotFoundException(__('Invalid sls quotation'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SlsQuotation->save($this->request->data)) {
				$this->Session->setFlash(__('The sls quotation has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sls quotation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SlsQuotation.' . $this->SlsQuotation->primaryKey => $id));
			$this->request->data = $this->SlsQuotation->find('first', $options);
		}
		$acrClients = $this->SlsQuotation->AcrClient->find('list');
		$sbsSubscribers = $this->SlsQuotation->SbsSubscriber->find('list');
		$this->set(compact('acrClients', 'sbsSubscribers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->SlsQuotation->id = $id;
		if (!$this->SlsQuotation->exists()) {
			throw new NotFoundException(__('Invalid sls quotation'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SlsQuotation->delete()) {
			$this->Session->setFlash(__('The sls quotation has been deleted.'));
		} else {
			$this->Session->setFlash(__('The sls quotation could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
