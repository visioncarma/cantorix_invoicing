<?php
App::uses('AppController', 'Controller');
/**
 * AcrClients Controller
 *
 * @property AcrClient $AcrClient
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ClientsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public function beforeFilter() {
        parent::beforeFilter();
      	$this->Auth->allow();
      
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->loadModel('AcrClient');
		$this->AcrClient->recursive = 0;
		$this->set('acrClients', $this->Paginator->paginate('AcrClient'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->AcrClient->exists($id)) {
			throw new NotFoundException(__('Invalid acr client'));
		}
		$options = array('conditions' => array('AcrClient.' . $this->AcrClient->primaryKey => $id));
		$this->set('acrClient', $this->AcrClient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		configure::write('debug',2);
		$this->loadModel('AcrClient');
		if ($this->request->is('post')) {
			$this->AcrClient->create();
			if ($this->AcrClient->save($this->request->data)) {
				$this->Session->setFlash(__('The acr client has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The acr client could not be saved. Please, try again.'));
			}
		}
		$cpnLanguages = $this->AcrClient->CpnLanguage->find('list',array('fields'=>array('CpnLanguage.id','CpnLanguage.language')));
		$cpnCurrencies = $this->AcrClient->CpnCurrency->find('list',array('fields'=>array('CpnCurrency.id','CpnCurrency.name')));
		$sbsSubscribers = $this->AcrClient->SbsSubscriber->find('list',array('fields'=>array('SbsSubscriber.id','SbsSubscriber.fullname')));
		$this->set(compact('cpnLanguages', 'cpnCurrencies', 'sbsSubscribers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->loadModel('AcrClient');
		if (!$this->AcrClient->exists($id)) {
			throw new NotFoundException(__('Invalid acr client'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->AcrClient->save($this->request->data)) {
				$this->Session->setFlash(__('The acr client has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The acr client could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('AcrClient.' . $this->AcrClient->primaryKey => $id));
			$this->request->data = $this->AcrClient->find('first', $options);
		}
		$cpnLanguages = $this->AcrClient->CpnLanguage->find('list',array('fields'=>array('CpnLanguage.id','CpnLanguage.language')));
		$cpnCurrencies = $this->AcrClient->CpnCurrency->find('list',array('fields'=>array('CpnCurrency.id','CpnCurrency.name')));
		$sbsSubscribers = $this->AcrClient->SbsSubscriber->find('list',array('fields'=>array('SbsSubscriber.id','SbsSubscriber.fullname')));
		$this->set(compact('cpnLanguages', 'cpnCurrencies', 'sbsSubscribers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->AcrClient->id = $id;
		if (!$this->AcrClient->exists()) {
			throw new NotFoundException(__('Invalid acr client'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->AcrClient->delete()) {
			$this->Session->setFlash(__('The acr client has been deleted.'));
		} else {
			$this->Session->setFlash(__('The acr client could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
