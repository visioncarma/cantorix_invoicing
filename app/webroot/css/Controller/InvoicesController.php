<?php
App::uses('AppController', 'Controller');
/**
 * AcrClientInvoices Controller
 *
 * @property AcrClientInvoice $AcrClientInvoice
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class InvoicesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public function beforeFilter() {
        parent::beforeFilter();
      //	$this->Auth->allow('login','inactive');
      $this->loadModel('AcrClientInvoice');
      $this->layout = "sbs_layout";
       $this->permission = $this->Session->read('Auth.AllPermissions.Invoices');
      
    }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AcrClientInvoice->recursive = 0;
		$this->set('acrClientInvoices', $this->Paginator->paginate('AcrClientInvoice'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->AcrClientInvoice->exists($id)) {
			throw new NotFoundException(__('Invalid acr client invoice'));
		}
		$options = array('conditions' => array('AcrClientInvoice.' . $this->AcrClientInvoice->primaryKey => $id));
		$this->set('acrClientInvoice', $this->AcrClientInvoice->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AcrClientInvoice->create();
			if ($this->AcrClientInvoice->save($this->request->data)) {
				$this->Session->setFlash(__('The acr client invoice has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The acr client invoice could not be saved. Please, try again.'));
			}
		}
		$acrClients = $this->AcrClientInvoice->AcrClient->find('list');
		$invInventories = $this->AcrClientInvoice->InvInventory->find('list');
		$sbsSubscribers = $this->AcrClientInvoice->SbsSubscriber->find('list');
		$this->set(compact('acrClients', 'invInventories', 'sbsSubscribers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->AcrClientInvoice->exists($id)) {
			throw new NotFoundException(__('Invalid acr client invoice'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->AcrClientInvoice->save($this->request->data)) {
				$this->Session->setFlash(__('The acr client invoice has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The acr client invoice could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('AcrClientInvoice.' . $this->AcrClientInvoice->primaryKey => $id));
			$this->request->data = $this->AcrClientInvoice->find('first', $options);
		}
		$acrClients = $this->AcrClientInvoice->AcrClient->find('list');
		$invInventories = $this->AcrClientInvoice->InvInventory->find('list');
		$sbsSubscribers = $this->AcrClientInvoice->SbsSubscriber->find('list');
		$this->set(compact('acrClients', 'invInventories', 'sbsSubscribers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->AcrClientInvoice->id = $id;
		if (!$this->AcrClientInvoice->exists()) {
			throw new NotFoundException(__('Invalid acr client invoice'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->AcrClientInvoice->delete()) {
			$this->Session->setFlash(__('The acr client invoice has been deleted.'));
		} else {
			$this->Session->setFlash(__('The acr client invoice could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
