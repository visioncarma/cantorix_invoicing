<?php
App::uses('AppController', 'Controller');
/**
 * CpnCurrencies Controller
 *
 * @property CpnCurrency $CpnCurrency
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CurrenciesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public function beforeFilter() {
        parent::beforeFilter();
      //	$this->Auth->allow('login','inactive');
      $this->loadModel('CpnCurrency');
      $this->layout = "cpn_layout";
       $this->permission = $this->Session->read('Auth.AllPermissions.Currency Settings');
      
    }


	/**
	 * Below actions are related to maxmind location and currency pull based on Ip.
	 * Methods for currency conversion is also included.
	 */
	
	
/**
 * index method
 *
 * @return void
 */
	public function index($filterBy = null,$value = null,$page = null) {
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if($this->params->query){
			if($this->params->query['filterBy']){
				$filterBy = $this->params->query['filterBy'];
			}
			if($this->params->query['value']){
				$value = $this->params->query['value'];
			}
		}
		
		if($this->data['filterCurrency']['filterBy']){
			$filterBy = $this->data['filterCurrency']['filterBy'];
			$this->set(compact('filterBy'));
		}else{
			$filterBy = $filterBy;
			$this->set(compact('filterBy'));
		}
		if($this->data['filterCurrency']['value']){
			$value = $this->data['filterCurrency']['value'];
			$this->set(compact('value'));
		}else{
			$value = $value ;
			$this->set(compact('value'));
		}
		//Add Currency
		if(($this->data['CpnCurrency']['code']) && ($this->data['CpnCurrency']['name'])){
			if ($this->request->is('post')) {
				$isExistCurrency = $this->CpnCurrency->isCurrencyExist($this->data['CpnCurrency']['code'],$this->data['CpnCurrency']['name']);
				if(!$isExistCurrency){
					$this->CpnCurrency->create();
					if ($this->CpnCurrency->save($this->request->data)) {
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<p>
												<strong>
													<i class="icon-ok"></i>
													Done!
												</strong>A new currency has been added to the system</p>
										</div>'));
						//$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>' .
													'Sorry!
												<i class="icon-remove"></i>												
											</strong>Currency add failed!Please try again</p>
										</div>'));
					}
				}else{
					$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>' .
													'Sorry!
												<i class="icon-remove"></i>												
											</strong>Currency exists!</p>
										</div>'));
				}
				
				
			}
		}
		//Edit Currency
		if($this->data['editCurrency']){
			$page 		= $this->data['editCurrency']['page'];
			$filterBy 	= $this->data['editCurrency']['filterBy'];
			$value 		= $this->data['editCurrency']['filterValue'];
			if(!empty($this->data['editCurrency']['code']) && (!empty($this->data['editCurrency']['name']))){
				if ($this->request->is('post')) {
						foreach($this->data['editCurrency']['code'] as $currencyId => $currencyVal){
							if($currencyVal && $this->data['editCurrency']['name'][$currencyId]){
								$currencyCompare = $this->CpnCurrency->getCurrencyById($currencyId);
								if(($currencyCompare['CpnCurrency']['code']!=$currencyVal)){
									$isExistCurrency = $this->CpnCurrency->isCurrencyExist($currencyVal,$this->data['editCurrency']['name'][$currencyId]);
									
									if(!$isExistCurrency){
										$updateCurrency	=	$this->CpnCurrency->updateCurrency($currencyId,$currencyVal,$this->data['editCurrency']['name'][$currencyId]);
										if($updateCurrency){
											$this->Session->setFlash(__('<div class="alert alert-block alert-success">
												<button type="button" class="close" data-dismiss="alert">
													<i class="icon-remove"></i>
												</button>

												<p>
													<strong>
														<i class="icon-ok"></i>
														Done!
													</strong>Currency updated successfully.</p>
											</div>'));
											//$this->redirect(array('controller'=>'Currencies','action'=>'index',$page));
										}else{
											$this->Session->setFlash(__('<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert">
													<i class="icon-remove"></i>
												</button>
												<p>
												<strong>' .
													'Sorry!
													<i class="icon-remove"></i>												
												</strong>Currency update failed!Please try again.</p>
											</div>'));
										}								
									}else{
										
									$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>' .
													'Sorry!
												<i class="icon-remove"></i>												
											</strong>Currency exists!</p>
										</div>'));
									}								
								}else{
									$updateCurrency	=	$this->CpnCurrency->updateCurrency($currencyId,$currencyVal,$this->data['editCurrency']['name'][$currencyId]);
										if($updateCurrency){
											$this->Session->setFlash(__('<div class="alert alert-block alert-success">
												<button type="button" class="close" data-dismiss="alert">
													<i class="icon-remove"></i>
												</button>

												<p>
													<strong>
														<i class="icon-ok"></i>
														Done!
													</strong>Currency updated successfully.</p>
											</div>'));
											//$this->redirect(array('controller'=>'Currencies','action'=>'index',$page));
										}else{
											$this->Session->setFlash(__('<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert">
													<i class="icon-remove"></i>
												</button>
												<p>
												<strong>' .
													'Sorry!
													<i class="icon-remove"></i>												
												</strong>Currency update failed!Please try again.</p>
											</div>'));
										}	
								}

							}
						}
				}else{
					$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>' .
													'Sorry!
												<i class="icon-remove"></i>												
											</strong>Invalid Request.</p>
										</div>'));
				}
				
			}
		}
			
		//Manage Screen
		if($this->params['named']['direction']){
			$order = $this->params['named']['direction'];
		}else{
			$order = 'ASC';
		}
		
		$this->Paginator->settings = array(
       		 'CpnCurrency' => array(
            		'page'	=> $page,
            		'order' => array('code' => $order),
            		'limit' =>'10'
       		 )
    		);
			$this->set(compact('page'));
		$this->CpnCurrency->recursive = 0;
		switch($filterBy){
			case "name"	:
							$conditions = array('CpnCurrency.name like'=>'%'.trim($value).'%');
							$this->set('cpnCurrencies', $this->Paginator->paginate('CpnCurrency',$conditions));
							break;
			case "code"	:   $conditions = array('CpnCurrency.code like'=>'%'.trim($value).'%');
							$this->set('cpnCurrencies', $this->Paginator->paginate('CpnCurrency',$conditions));
							break;
			default		:	
							$this->set('cpnCurrencies', $this->Paginator->paginate('CpnCurrency'));
							break;
		}
		$permission = $this->permission;
		$menuActive = 'Currency Settings';
		$settingsActive = 'active';
		$this->set(compact('permission','menuActive','settingsActive'));
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CpnCurrency->exists($id)) {
			throw new NotFoundException(__('Invalid cpn currency'));
		}
		$options = array('conditions' => array('CpnCurrency.' . $this->CpnCurrency->primaryKey => $id));
		$this->set('cpnCurrency', $this->CpnCurrency->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		
		/*if ($this->request->is('post')) {
			$this->CpnCurrency->create();
			if ($this->CpnCurrency->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn currency has been saved.'));
				//return $this->redirect(array('action' => 'index'));
			} else {
				//$this->Session->setFlash(__('The cpn currency could not be saved. Please, try again.'));
			}
		}*/
		/*if($_SERVER['SERVER_ADDR']=='192.168.0.164'){
			$ip="182.73.165.90";
		}else{
			//$ip= $_SERVER['REMOTE_ADDR'];
			$ip = CakeRequest::clientIp(true);
		}*/	
		//$locationDetails = $this->locate($ip);
		//$checkForCurrency = $this->CpnCurrency->checkCurrency($locationDetails['geoplugin_currencyCode'],$locationDetails['geoplugin_currencySymbol_UTF8']);
		//$timeZone = $this->getTimeZone('182.73.165.90');
		//$timezone = $this->LocationCity->getcity_info('182.73.165.90');
		
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CpnCurrency->exists($id)) {
			throw new NotFoundException(__('Invalid cpn currency'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CpnCurrency->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn currency has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn currency could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CpnCurrency.' . $this->CpnCurrency->primaryKey => $id));
			$this->request->data = $this->CpnCurrency->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null,$page=null,$filterBy = null,$value = null) {
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->loadModel('AcrClient');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
		$getClient = $this->AcrClient->getClientDetails($id);
		$getOrganization = $this->SbsSubscriberOrganizationDetail->getOrganizationDetails($id);
		$subscriberCurrency = $this->SbsSubscriberCpnCurrencyMapping->getMapping($id);
		if(empty($getClient) && (empty($getOrganization) && (empty($subscriberCurrency)))){
			$this->CpnCurrency->id = $id;
			if (!$this->CpnCurrency->exists()) {
				throw new NotFoundException(__('Invalid cpn currency'));
			}
			//$this->request->onlyAllow('post', 'delete');
			if ($this->CpnCurrency->delete($id)) {
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<p>
												<strong>
													<i class="icon-ok"></i>
													Done!
												</strong>Currency removed from the system!</p>
										</div>'));
			} else {
				$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>Currency could not be removed.Please try again.<br />
										</div>'));
			}
			if(!$filterBy){$filterBy="null";}
			if(!$value){$value="null";}
			return $this->redirect(array('action' => 'index/'.$filterBy.'/'.$value.'/'.$page));
		}else{
			$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>Currency could not be removed.A client is using this currency.<br />
										</div>'));
				if(!$filterBy){$filterBy="null";}
				if(!$value){$value="null";}
			return $this->redirect(array('action' => 'index/'.$filterBy.'/'.$value.'/'.$page));
		}
		
	}
	public function deleteAll(){
		$this->autoRender = false;
		if($this->data['editCurrency']['filterBy']){
			$filterBy			=	$this->data['editCurrency']['filterBy'];
		}else{
			$filterBy			=	"null";
		}
		if($this->data['editCurrency']['value']){
			$value 	= 	$this->data['editCurrency']['value'];
		}else{
			$value	= "null";
		}
		$pages 				= 	$this->data['editCurrency']['page'];
		if($this->data['deleteAll']){
					foreach($this->data['deleteAll'] as $currencyId => $deleteValue){
						if($deleteValue){
							$selected = 1;
							$this->loadModel('AcrClient');
							$this->loadModel('SbsSubscriberOrganizationDetail');
							$this->loadModel('SbsSubscriberCpnCurrencyMapping');
							$getClient = $this->AcrClient->getClientDetails($currencyId);
							$getOrganization = $this->SbsSubscriberOrganizationDetail->getOrganizationDetails($currencyId);
							$subscriberCurrency = $this->SbsSubscriberCpnCurrencyMapping->getMapping($currencyId);
							if($getClient || $getOrganization || $subscriberCurrency){
								$used = 1;
							}else{
								$this->CpnCurrency->id = $currencyId;
								if ($this->CpnCurrency->delete()) {
									$deleted = 1;
								}
							}
						}
					}
					
				}
		if(!$selected){
						$this->Session->setFlash(__('<div class="alert alert-danger"> Please select atleast one currency to delete.</div>'));
					}elseif($used && $deleted){
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">Some of the currencies are being used in the system and therefore we cannot remove them.Others were removed</div>'));
					}elseif($deleted && !$used){
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">All the selected currencies are removed.</div>'));
					}elseif(!$deleted && $used){
						$this->Session->setFlash(__('<div class="alert alert-danger">All the selected currencies are used in the system and therefore we cannot remove them.</div>'));
					}
		if(!$filterBy){$filterBy="null";}
				if(!$value){$value="null";}
			return $this->redirect(array('action' => 'index/'.$filterBy.'/'.$value.'/'.$pages));
		
	}
}
