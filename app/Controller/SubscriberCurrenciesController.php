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
       		$this->permission = $this->Session->read('Auth.AllPermissions.Currencies');
	      	$this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
      
    }

/**
 * index method
 *
 * @return void
 */
	public function index($filterBy = null,$currencyNameValue = null,$currencyCodeValue = null,$page = 1) {
		$settingsActive = 'active';
		$menuActive = 'Currencies';
		$this->set(compact('settingsActive','menuActive'));
		$permission = $this->permission;
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		$this->loadModel('SbsSubscriberSetting');
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$limit = $settings['SbsSubscriberSetting']['lines_per_page'];
		if($this->params->query){
			if($this->params->query['filterBy']){
				$filterBy = $this->params->query['filterBy'];
			}
			if($this->params->query['currencyNameValue'] || $this->params->query['currencyCodeValue']){
				if($filterBy == "both"){
					$currencyNameValue = $this->params->query['currencyNameValue'];
					$currencyCodeValue = $this->params->query['currencyCodeValue'];
				}elseif($filterBy = "name"){
					$currencyNameValue = $this->params->query['currencyNameValue'];
				}elseif($filterBy = "code"){
					$currencyCodeValue = $this->params->query['currencyCodeValue'];
				}
				
			}
		}
		//alteration code
		if($this->data['filterCurrency']['currencyName'] && $this->data['filterCurrency']['currencyCode']){
			$filterBy = "both";
			$currencyNameValue = $this->data['filterCurrency']['currencyName'];
			$currencyCodeValue = $this->data['filterCurrency']['currencyCode'];
			$value = array('currencyNameValue'=>$currencyNameValue,'currencyCodeValue'=>$currencyCodeValue);
		}elseif($this->data['filterCurrency']['currencyName']){
			$filterBy = "name";
			$currencyNameValue = $this->data['filterCurrency']['currencyName'];
			$value = array('currencyNameValue'=>$currencyNameValue);
		}elseif($this->data['filterCurrency']['currencyCode']){
			$filterBy = "code";
			$currencyCodeValue = $this->data['filterCurrency']['currencyCode'];
			$value = array('currencyCodeValue'=>$currencyCodeValue);
		}
		//end
		if($filterBy == "null"){$filterBy = null;}
		if($currencyCodeValue == "null" ){$currencyCodeValue = null;}
		if($currencyNameValue == "null"){$currencyNameValue = null;}
		
		$this->Paginator->settings = array(
       		 'SbsSubscriberCpnCurrencyMapping' => array(
            		'page'	=> $page,
            		'limit' => $limit
       		 )
    		);
			$this->set(compact('page'));
			$this->set(compact('filterBy'));
			$this->set(compact('currencyNameValue','currencyCodeValue'));
		$this->SbsSubscriberCpnCurrencyMapping->recursive = 0;
		switch($filterBy){
			case "name"	:
							$conditions = array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$this->Session->read('Auth.User.sbs_subscriber_id'),'CpnCurrency.name like'=>'%'.trim($currencyNameValue).'%');
							$this->set('sbsSubscriberCpnCurrencyMappings', $this->Paginator->paginate('SbsSubscriberCpnCurrencyMapping',$conditions));
							break;
			case "code"	:  
							$conditions = array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$this->Session->read('Auth.User.sbs_subscriber_id'),'CpnCurrency.code like'=>'%'.trim($currencyCodeValue).'%');
							$this->set('sbsSubscriberCpnCurrencyMappings', $this->Paginator->paginate('SbsSubscriberCpnCurrencyMapping',$conditions));
							break;
			case "both" : 	$conditions = array('SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$this->Session->read('Auth.User.sbs_subscriber_id'),'CpnCurrency.code like'=>'%'.trim($currencyCodeValue).'%','CpnCurrency.name like'=>'%'.trim($currencyNameValue).'%');
							$this->set('sbsSubscriberCpnCurrencyMappings', $this->Paginator->paginate('SbsSubscriberCpnCurrencyMapping',$conditions));
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
	public function add($filterBy = null,$currencyNameValue = null,$currencyCodeValue = null,$page = 1) {
		
		$settingsActive = 'active';
		$menuActive = 'Currencies';
		$this->set(compact('settingsActive','menuActive'));
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
		$this->loadModel('CpnCurrency');
		$this->loadModel('SbsSubscriberSetting');
		
		if($currencyNameValue == "null"){
			$currencyNameValue = '';
		}
		if($currencyCodeValue == "null"){
			$currencyCodeValue = '';
		}
		
		$settings 		 	 = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$limit = $settings['SbsSubscriberSetting']['lines_per_page'];
		$this->CpnCurrency->recursive = 0;
			$this->set(compact('page'));
			if($this->params->query){
			if($this->params->query['filterBy']){
				if($this->params->query['filterBy'] == "null"){$this->params->query['filterBy'] ='';}
				$filterBy = $this->params->query['filterBy'];
			}
			if($this->params->query['currencyNameValue'] || $this->params->query['currencyCodeValue'] || $currencyNameValue || $currencyCodeValue){
				/*
				if(($this->params->query['currencyNameValue'] == "null") || ){$this->params->query['currencyNameValue'] == '';}
								if($this->params->query['currencyCodeValue'] == "null"){$this->params->query['currencyCodeValue'] == '';}*/
				
				if($filterBy == "both"){
					$currencyNameValue = $currencyNameValue;
					$currencyCodeValue = $currencyCodeValue;
				}elseif($filterBy = "name"){
					$currencyNameValue =$currencyNameValue;
					$currencyCodeValue = 'null';
				}elseif($filterBy = "code"){
					$currencyCodeValue = $currencyCodeValue;
					$currencyNameValue = 'null';
				}
				
			}
		}
			
			
			
			
			if($this->data['filterCurrency']['currencyName'] && $this->data['filterCurrency']['currencyCode']){
			$filterBy = "both";
			$currencyNameValue = $this->data['filterCurrency']['currencyName'];
			$currencyCodeValue = $this->data['filterCurrency']['currencyCode'];
			$value = array('currencyNameValue'=>$currencyNameValue,'currencyCodeValue'=>$currencyCodeValue);
		}elseif($this->data['filterCurrency']['currencyName']){
			$filterBy = "name";
			$currencyNameValue = $this->data['filterCurrency']['currencyName'];
			$value = array('currencyNameValue'=>$currencyNameValue);
		}elseif($this->data['filterCurrency']['currencyCode']){
			$filterBy = "code";
			$currencyNameValue = 'null';
			$currencyCodeValue = $this->data['filterCurrency']['currencyCode'];
			$value = array('currencyCodeValue'=>$currencyCodeValue);
		}
		$this->set(compact('page'));
		$this->set(compact('filterBy'));
		$this->set(compact('currencyNameValue','currencyCodeValue'));
			
		$subscriberCurrency = $this->SbsSubscriberCpnCurrencyMapping->getListOfSubscriberCurrency($this->Session->read('Auth.User.sbs_subscriber_id'));
		switch($filterBy){
			case "name"	:
							$conditions = array('NOT'=>array('CpnCurrency.id'=>$subscriberCurrency),'CpnCurrency.name like'=>'%'.trim($currencyNameValue).'%');
							break;
			case "code"	:  
							$conditions = array('NOT'=>array('CpnCurrency.id'=>$subscriberCurrency),'CpnCurrency.code like'=>'%'.trim($currencyCodeValue).'%');
							break;
			case "both" :   $conditions = array('NOT'=>array('CpnCurrency.id'=>$subscriberCurrency),'CpnCurrency.code like'=>'%'.trim($currencyCodeValue).'%','CpnCurrency.name like'=>'%'.trim($currencyNameValue).'%');
							break;
			default		:	
							$conditions = array('NOT'=>array('CpnCurrency.id'=>$subscriberCurrency));
							break;
		}
		$this->Paginator->settings = array(
											'conditions'=>$conditions,
											'page'	=> $page,
											'limit' => $limit
										  );
	    $this->set(compact('page'));
		
		
		$this->set('cpnCurrencies', $this->Paginator->paginate('CpnCurrency'));
	}
	
	public function addToFav($currencyId,$filterBy,$value,$pages){
		$settingsActive = 'active';
		$menuActive = 'Currencies';
		$this->set(compact('settingsActive','menuActive'));
		$permission = $this->permission;
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->set(compact('permission'));
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
    	$settingsActive = 'active';
		$menuActive = 'Currencies';
		$this->set(compact('settingsActive','menuActive'));
		$this->autoRender = false;	
		$count=0;
		foreach($this->data['Add'] as $key=>$value){
			  if($value){
					$addToFav = $this->SbsSubscriberCpnCurrencyMapping->addToMyList($key,$this->Session->read('Auth.User.sbs_subscriber_id'));
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
			// $this->redirect(array('controller'=>'SubscriberCurrencies','action'=>'add',$filterBy,$value,$pages));	
			  $this->redirect(array('controller'=>'SubscriberCurrencies','action'=>'index'));							
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

	public function deleteAll(){
		$this->autoRender = false;
		if($this->data['editCurrency']['filterBy']){
			$filterBy			=	$this->data['editCurrency']['filterBy'];
		}else{
			$filterBy			=	"null";
		}
		if($this->data['editCurrency']['currencyNameValue']){
			$currencyNameValue 	= 	$this->data['editCurrency']['currencyNameValue'];
		}else{
			$currencyNameValue	= "null";
		}
		if($this->data['editCurrency']['currencyCodeValue']){
			$currencyCodeValue	=	$this->data['editCurrency']['currencyCodeValue'];
		}else{
			$currencyCodeValue	= "null";
		}
		$pages 				= 	$this->data['editCurrency']['page'];
		if($this->data['deleteAll']){
				foreach($this->data['deleteAll'] as $mappingId => $deleteValue){
					if($deleteValue){
						$selected = 1;
								$this->loadModel('CpnCurrency');
								$this->loadModel('AcrClientInvoice');
								$this->loadModel('SlsQuotation');
								$this->loadModel('SbsSubscriberOrganizationDetail');
								$this->loadModel('SbsSubscriber');
								$mappingDetails = $this->SbsSubscriberCpnCurrencyMapping->getMappingDetails($mappingId,$this->subscriber);
								$currencyDetail = $this->CpnCurrency->getCurrencyById($mappingDetails['SbsSubscriberCpnCurrencyMapping']['cpn_currency_id']);
								$currencyInvoiced = $this->AcrClientInvoice->getCountOfInvoice($currencyDetail['CpnCurrency']['code'],$this->subscriber);
								$currencyQuoted = $this->SlsQuotation->getCountOfQuote($currencyDetail['CpnCurrency']['code'],$this->subscriber);
								$subscriberOrganizationDetailId	=	$this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($this->subscriber);
								if($subscriberOrganizationDetailId){
									$homeCurrency	= $this->SbsSubscriberOrganizationDetail->getHomeCurrency($mappingDetails['SbsSubscriberCpnCurrencyMapping']['cpn_currency_id'],$subscriberOrganizationDetailId);
								}
								if($currencyInvoiced){
									$used = 1;
								}elseif($currencyQuoted){
									$used = 1;
								}elseif($homeCurrency){
									$used = 1;
								}else{
									$this->SbsSubscriberCpnCurrencyMapping->id = $mappingId;
									if ($this->SbsSubscriberCpnCurrencyMapping->delete()){
										$delete = 1;
									}
								}
					}
				}
				if(!$selected){
					$this->Session->setFlash(__('<div class="alert alert-danger"> Please select atleast one currency to delete.</div>'));
				}elseif($delete && $used){
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">Some of the currencies are being used in the system and therefore we cannot remove them.Others were removed</div>'));
				}elseif(!$delete && $used){
					$this->Session->setFlash(__('<div class="alert alert-danger">All the selected currencies are used in the system and therefore we cannot remove them.</div>'));
				}elseif($delete && !$used){
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">All the selected currencies are removed.</div>'));
				}elseif(!$used && !$delete){
					$this->Session->setFlash(__('<div class="alert alert-danger">There is no currency to delete.</div>'));
				}
				return $this->redirect(array('action' => 'index/'.$filterBy.'/'.$currencyNameValue.'/'.$currencyCodeValue.'/'.$pages));
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
	public function delete($id = null,$filterBy,$currencyNameValue,$currencyCodeValue,$pages) {
		$this->SbsSubscriberCpnCurrencyMapping->id = $id;
		if (!$this->SbsSubscriberCpnCurrencyMapping->exists()) {
			throw new NotFoundException(__('Invalid sbs subscriber cpn currency mapping'));
		}
		/*$this->request->onlyAllow('post', 'delete');*/
		$this->loadModel('CpnCurrency');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('SlsQuotation');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriber');
		$mappingDetails = $this->SbsSubscriberCpnCurrencyMapping->getMappingDetails($id,$this->subscriber);
		($mappingDetails);
		$currencyDetail = $this->CpnCurrency->getCurrencyById($mappingDetails['SbsSubscriberCpnCurrencyMapping']['cpn_currency_id']);
		$currencyInvoiced = $this->AcrClientInvoice->getCountOfInvoice($currencyDetail['CpnCurrency']['code'],$this->subscriber);
		$currencyQuoted = $this->SlsQuotation->getCountOfQuote($currencyDetail['CpnCurrency']['code'],$this->subscriber);
		$subscriberOrganizationDetailId	=	$this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($this->subscriber);
		if($subscriberOrganizationDetailId){
			$homeCurrency	= $this->SbsSubscriberOrganizationDetail->getHomeCurrency($mappingDetails['SbsSubscriberCpnCurrencyMapping']['cpn_currency_id'],$subscriberOrganizationDetailId);
		}
		
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
		}elseif($homeCurrency){
			$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>'.$currencyDetail['CpnCurrency']['name'].' is your home currency.<br />
										</div>'));
		}
		else{
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
		
		return $this->redirect(array('action' => 'index/'.$filterBy.'/'.$currencyNameValue.'/'.$currencyCodeValue.'/'.$pages));
	}
}
