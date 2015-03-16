<?php
App::uses('AppController', 'Controller');
/**
 * SbsSubscriberCpnCurrencyMappings Controller
 *
 * @property SbsSubscriberCpnCurrencyMapping $SbsSubscriberCpnCurrencyMapping
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SubscriberCurrenciesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public function beforeFilter() {
        parent::beforeFilter();
      //	$this->Auth->allow('login','inactive');
     		$this->loadModel('SbsSubscriberCpnCurrencyMapping');
     		$this->layout = "sbs_layout";
       		$this->permission = $this->Session->read('Auth.AllPermissions.Customers');
	      	$this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
      
    }

/**
 * index method
 *
 * @return void
 */
	public function index($page = null,$filterBy = null,$value = null) {
		$settingsActive = 'active';
		$menuActive = 'Currencies';
		$this->set(compact('settingsActive','menuActive'));
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
		$this->Paginator->settings = array(
       		 'SbsSubscriberCpnCurrencyMapping' => array(
            		'page'	=> $page,
            		'limit' => 10
       		 )
    		);
			$this->set(compact('page'));
			$this->set(compact('filterBy'));
			$this->set(compact('value'));
		$this->SbsSubscriberCpnCurrencyMapping->recursive = 0;
		switch($filterBy){
			case "name"	:
							$conditions = array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$this->Session->read('Auth.User.sbs_subscriber_id'),'CpnCurrency.name like'=>'%'.trim($value).'%');
							$this->set('sbsSubscriberCpnCurrencyMappings', $this->Paginator->paginate('SbsSubscriberCpnCurrencyMapping',$conditions));
							break;
			case "code"	:  
							$conditions = array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$this->Session->read('Auth.User.sbs_subscriber_id'),'CpnCurrency.code like'=>'%'.trim($value).'%');
							$this->set('sbsSubscriberCpnCurrencyMappings', $this->Paginator->paginate('SbsSubscriberCpnCurrencyMapping',$conditions));
							break;
			default		:	
							$conditions = array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$this->Session->read('Auth.User.sbs_subscriber_id'));
							$this->set('sbsSubscriberCpnCurrencyMappings', $this->Paginator->paginate('SbsSubscriberCpnCurrencyMapping',$conditions));
							break;
		}
		$permission = $this->permission;
		$this->set(compact('permission'));
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->SbsSubscriberCpnCurrencyMapping->exists($id)) {
			throw new NotFoundException(__('Invalid sbs subscriber cpn currency mapping'));
		}
		$options = array('conditions' => array('SbsSubscriberCpnCurrencyMapping.' . $this->SbsSubscriberCpnCurrencyMapping->primaryKey => $id));
		$this->set('sbsSubscriberCpnCurrencyMapping', $this->SbsSubscriberCpnCurrencyMapping->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($filterBy,$value,$page) {
		$this->loadModel('CpnCurrency');
		$this->CpnCurrency->recursive = 0;
			$this->set(compact('page'));
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
		$subscriberCurrency = $this->SbsSubscriberCpnCurrencyMapping->getListOfSubscriberCurrency($this->Session->read('Auth.User.sbs_subscriber_id'));
		switch($filterBy){
			case "name"	:
							$conditions = array('NOT'=>array('CpnCurrency.id'=>$subscriberCurrency),'CpnCurrency.name like'=>'%'.trim($value).'%');
							break;
			case "code"	:  
							$conditions = array('NOT'=>array('CpnCurrency.id'=>$subscriberCurrency),'CpnCurrency.code like'=>'%'.trim($value).'%');
							break;
			default		:	
							$conditions = array('NOT'=>array('CpnCurrency.id'=>$subscriberCurrency));
							break;
		}
		$this->Paginator->settings = array(
											'conditions'=>$conditions,
											'page'	=> $page,
            								'order' => array('code' => 'asc'),
											'limit' => 10
										  );
	    $this->set(compact('page'));
		$this->set('cpnCurrencies', $this->Paginator->paginate('CpnCurrency'));
	}
	
	public function addToFav($currencyId,$filterBy,$value,$pages){
		
		if($currencyId){
			$addToFav = $this->SbsSubscriberCpnCurrencyMapping->addToMyList($currencyId,$this->Session->read('Auth.User.sbs_subscriber_id'));
			if($addToFav){
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">
												<button type="button" class="close" data-dismiss="alert">
													<i class="icon-remove"></i>
												</button>

												<p>
													<strong>
														<i class="icon-ok"></i>
														Done!
													</strong>Currency added to your list</p>
											</div>'));
				$this->redirect(array('controller'=>'SubscriberCurrencies','action'=>'add',$filterBy,$value,$pages));
			}else{
				$this->Session->setFlash(__('<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert">
													<i class="icon-remove"></i>
												</button>
												<p>
												<strong>' .
													'Sorry!
													<i class="icon-remove"></i>												
												</strong>Currency could not be added to your list</p>
											</div>'));
				$this->redirect(array('controller'=>'SubscriberCurrencies','action'=>'add',$filterBy,$value,$pages));
			}
			
		}
	}


    public function multiCurrenyAdd($filterBy,$value,$pages){
    	
		$this->autoRender = false;	
		$count=0;
		foreach($this->data['Add'] as $key=>$value){
			  if($value){
			  	    
					$addToFav = $this->SbsSubscriberCpnCurrencyMapping->addToMyList($key,$this->Session->read('Auth.User.sbs_subscriber_id'));
					debug($addToFav);
					if($addToFav){
						$count++;
					}
			 }
        }
        if($count){
        	  $this->Session->setFlash(__('<div class="alert alert-block alert-success">
												<button type="button" class="close" data-dismiss="alert">
													<i class="icon-remove"></i>
												</button>

												<p>
													<strong>
														<i class="icon-ok"></i>
														Done!
													</strong>Selected currencies added to your list</p>
											</div>'));
			 $this->redirect(array('controller'=>'SubscriberCurrencies','action'=>'add',$filterBy,$value,$pages));								
        }else{
        	 $this->Session->setFlash(__('<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert">
													<i class="icon-remove"></i>
												</button>
												<p>
												<strong>' .
													'Sorry!
													<i class="icon-remove"></i>												
												</strong>Selected currencies could not be added to your list</p>
											</div>'));
				$this->redirect(array('controller'=>'SubscriberCurrencies','action'=>'add',$filterBy,$value,$pages));
        }
		
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->SbsSubscriberCpnCurrencyMapping->exists($id)) {
			throw new NotFoundException(__('Invalid sbs subscriber cpn currency mapping'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SbsSubscriberCpnCurrencyMapping->save($this->request->data)) {
				$this->Session->setFlash(__('The sbs subscriber cpn currency mapping has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sbs subscriber cpn currency mapping could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SbsSubscriberCpnCurrencyMapping.' . $this->SbsSubscriberCpnCurrencyMapping->primaryKey => $id));
			$this->request->data = $this->SbsSubscriberCpnCurrencyMapping->find('first', $options);
		}
		$sbsSubscribers = $this->SbsSubscriberCpnCurrencyMapping->SbsSubscriber->find('list');
		$cpnCurrencies = $this->SbsSubscriberCpnCurrencyMapping->CpnCurrency->find('list');
		$this->set(compact('sbsSubscribers', 'cpnCurrencies'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null,$pages,$filterBy,$value) {
		$this->SbsSubscriberCpnCurrencyMapping->id = $id;
		if (!$this->SbsSubscriberCpnCurrencyMapping->exists()) {
			throw new NotFoundException(__('Invalid sbs subscriber cpn currency mapping'));
		}
		/*$this->request->onlyAllow('post', 'delete');*/
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('SlsQuotation');
		$mappingDetails = $this->SbsSubscriberCpnCurrencyMapping->getMappingDetails($id,$this->subscriber);
		($mappingDetails);
		$currencyDetail = $this->CpnCurrency->getCurrencyById($mappingDetails['SbsSubscriberCpnCurrencyMapping']['cpn_currency_id']);
		$currencyInvoiced = $this->AcrClientInvoice->getCountOfInvoice($currencyDetail['CpnCurrency']['code'],$this->subscriber);
		$currencyQuoted = $this->SlsQuotation->getCountOfQuote($currencyDetail['CpnCurrency']['code'],$this->subscriber);
		if($currencyInvoiced){
			$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>There are invoices invoiced in '.$currencyDetail['CpnCurrency']['name'].'.Please Cancel the invoice before deleting the currency again.<br />
										</div>'));
		}elseif($currencyQuoted){
			$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>There are quotations quoted in '.$currencyDetail['CpnCurrency']['name'].'.Please Cancel the quotation before deleting the currency again.<br />
										</div>'));
		}else{
			if ($this->SbsSubscriberCpnCurrencyMapping->delete()) {
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<p>
												<strong>
													<i class="icon-ok"></i>
													Done!
												</strong>Currency removed from the list!</p>
										</div>'));
			}else{
				$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>Currency could not be removed.Please try again.<br />
										</div>'));
			}
		}
		
		return $this->redirect(array('action' => 'index/'.$filterBy.'/'.$value.'/'.$pages));
	}
}
