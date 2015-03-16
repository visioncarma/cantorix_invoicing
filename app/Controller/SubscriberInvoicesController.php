<?php
App::uses('AppController', 'Controller');
/**
 * CpnSubscriberInvoiceDetails Controller
 *
 * @property CpnSubscriberInvoiceDetail $CpnSubscriberInvoiceDetail
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SubscriberInvoicesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session','RequestHandler');
	public $uses = array('CpnSubscriberInvoiceDetail');
	public function beforeFilter() {
        parent::beforeFilter();
      //	$this->Auth->allow('login','inactive');
     // $this->loadModel('CpnSubscriberInvoiceDetail');
      $this->layout = "cpn_layout";
       $this->permission = $this->Session->read('Auth.AllPermissions.SubscriberInvoices');
      
    }
/**
 * index method
 *
 * @return void
 */
	public function index($filterOption,$filterBy,$status,$page,$subs_plan = 0,$subs_company = 0,$subs_name = 0,$subs_status=0,$subs_page = 1) {
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriber');
		$this->loadModel('CpnSetting');
		$settings = $this->CpnSetting->getAllSettings();
		$limit = $settings['CpnSetting']['lines_per_page'];
		$subscriptionActive = 'active';
		$menuActive = 'Manage Invoices';
		//$this->CpnSubscriberInvoiceDetail->recursive = 0;
		/*
		$this->Paginator->settings = array(
						'CpnSubscriberInvoiceDetail' => array(
							'page'	=> $page,
						)
					);*/
		
    		
    	if($this->params->query){
    		if($this->params->query['filterOption']){
				$filterOption = $this->params->query['filterOption'];
			}
			if($this->params->query['filterBy']){
				$filterBy = $this->params->query['filterBy'];
			}
			if($this->params->query['status']){
				$status = $this->params->query['status'];
			}
		}
    		
    	if($this->data['invoiceFilter']['filterOption']){
    		$filterOption = $this->data['invoiceFilter']['filterOption'];
    		if($this->data['invoiceFilter']['filterBy']){
    			$filterBy = $this->data['invoiceFilter']['filterBy'];
    		}
    		
    	}
    	if($this->data['invoiceFilter']['status']){
    			$status = $this->data['invoiceFilter']['status'];
    		}
		if($filterBy == "null"){$filterBy = null;}
		if($filterOption == "null"){$filterOption = null;}
    	$this->set(compact('page','filterOption','filterBy','status','subscriptionActive','menuActive'));
    	switch($filterOption){
    		case "Company Name" : 
    								$getCompanyList = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailByName(trim($filterBy));
    								if($filterBy && $status){
    									$conditions = array('SbsSubscriber.sbs_subscriber_organization_detail_id'=>$getCompanyList,'CpnSubscriberInvoiceDetail.payment_status'=>$status);
    									$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif($filterBy && !$status){
    									$conditions = array('SbsSubscriber.sbs_subscriber_organization_detail_id'=>$getCompanyList);
										$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif($status && !$filterBy){
    									$conditions = array('CpnSubscriberInvoiceDetail.payment_status'=>$status);
										$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif(!$status && !$filterBy){
    									$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    									$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>
												<i class="icon-remove"></i>' .
														'Sorry!												
											</strong>Please Select filter parameters to filter data.<br />
										</div>'));
    								}
    								break;
    		
    		case "Subscriber Name" : 
    								if($filterBy && $status){
    								/*$conditions = array('OR'=>array('SbsSubscriber.name like '=>'%'.trim($filterBy).'%','SbsSubscriber.surname like '=>'%'.trim($filterBy).'%','SbsSubscriber.fullname like'=>'%'.trim($filterBy).'%'),'CpnSubscriberInvoiceDetail.payment_status'=>$status);*/
    								$conditions = array('CONCAT(`name`, " ", `surname`) like'=>'%'.trim($filterBy).'%','CpnSubscriberInvoiceDetail.payment_status'=>$status);
    								$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    								$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif($filterBy && !$status){
    									//$this->virtualFields['fullname'] = $this->SbsSubscriber->virtualFields['fullname'];
										//$conditions = array('SbsSubscriber.name like '=>'%'.$filterBy.'%');
    									/*$conditions = array('OR'=>array('SbsSubscriber.name like '=>'%'.trim($filterBy).'%','SbsSubscriber.surname like '=>'%'.trim($filterBy).'%','SbsSubscriber.fullname like'=>'%'.trim($filterBy).'%'));*/
    									$conditions = array('CONCAT(`name`, " ", `surname`) like'=>'%'.trim($filterBy).'%');
										$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif($status && !$filterBy){
    									$conditions = array('CpnSubscriberInvoiceDetail.payment_status'=>$status);
										$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif(!$status && !$filterBy){
    									$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    									$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>
												<i class="icon-remove"></i>' .
														'Sorry!												
											</strong>Please Select filter parameters to filter data.<br />
										</div>'));
    								}
    								break;
			case 'Invoice Number':
										if($filterBy && $status){
    								$conditions = array('CpnSubscriberInvoiceDetail.invoice_no like '=>'%'.trim($filterBy).'%','CpnSubscriberInvoiceDetail.payment_status'=>$status);
    								$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    								$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif($filterBy && !$status){
    									//$conditions = array('SbsSubscriber.name like '=>'%'.$filterBy.'%');
    									$conditions = array('CpnSubscriberInvoiceDetail.invoice_no like '=>'%'.trim($filterBy).'%');
										$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif($status && !$filterBy){
    									$conditions = array('CpnSubscriberInvoiceDetail.payment_status'=>$status);
										$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif(!$status && !$filterBy){
    									$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    									$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>
												<i class="icon-remove"></i>' .
														'Sorry!												
											</strong>Please Select filter parameters to filter data.<br />
										</div>'));
    								}
				break;
			
    		case "Subscription Filter" :
    								if($filterBy == "Paid"){
    									$conditions = array('CpnSubscriberInvoiceDetail.payment_status'=>'Completed','CpnSubscriberInvoiceDetail.last_payment_date like'=>date('Y-m').'%');
    									$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif($filterBy == "Due"){
    									$conditions = array('OR'=>array(array('CpnSubscriberInvoiceDetail.payment_status'=>'Pending','CpnSubscriberInvoiceDetail.payment_status'=>'Failed'),'CpnSubscriberInvoiceDetail.next_payment_date like'=>date('Y-m').'%'));
    									$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif($filterBy == "Cancel"){
    									$conditions = array('CpnSubscriberInvoiceDetail.payment_status'=>'Refunded','CpnSubscriberInvoiceDetail.last_payment_date like'=>date('Y-m').'%');
    									$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								} 
    								break;
				case "Subscriber id" :
    								if($filterBy && $status){
    								$conditions = array('SbsSubscriber.id'=>$filterBy,'CpnSubscriberInvoiceDetail.payment_status'=>$status);
									$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    								$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif($filterBy && !$status){
    									//$conditions = array('SbsSubscriber.name like '=>'%'.$filterBy.'%');
    									$conditions = array('SbsSubscriber.id'=>$filterBy);
										$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif($status && !$filterBy){
    									$conditions = array('CpnSubscriberInvoiceDetail.payment_status'=>$status);
										$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    								}elseif(!$status && !$filterBy){
    									$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    									$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    									$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>
												<i class="icon-remove"></i>' .
														'Sorry!												
											</strong>Please Select filter parameters to filter data.<br />
										</div>'));
    								}
    								break;
    		default : 			
    							if($status){
    								$conditions = array('CpnSubscriberInvoiceDetail.payment_status'=>$status);
									$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'conditions'=>$conditions,'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    								$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    							}else{
    								
    								$this->Paginator->settings = array('limit'=>$limit,'joins'=>array(
    									array('table'=>'sbs_subscribers','alias'=>'SbsSubscriber','type'=>'LEFT','conditions'=>array('SbsSubscriber.id = CpnSubscriberInvoiceDetail.sbs_subscriber_id')),
    									array('table'=>'sbs_subscriber_organization_details','alias'=>'SbsSubscriberOrganizationDetail','type'=>'LEFT','conditions'=>array('SbsSubscriberOrganizationDetail.id = SbsSubscriber.sbs_subscriber_organization_detail_id'))
									),'fields'=>array('CpnSubscriberInvoiceDetail.*','SbsSubscriber.*','SbsSubscriberOrganizationDetail.*'));
    								$getAllInvoices = $this->Paginator->paginate('CpnSubscriberInvoiceDetail');
    							}
								
    							break;
    							
    	}
		if($this->params['named']['sort'] == "SbsSubscriberOrganizationDetail.organization_name"){
			$getAllInvoices =  Set::sort($getAllInvoices,'{n}.SbsSubscriberOrganizationDetail.organization_name',$this->params['named']['direction']);
		}
		
		$this->set('cpnSubscriberInvoiceDetails', $getAllInvoices);
		/*
		if($getAllInvoices){
					$this->loadModel('SbsSubscriberOrganizationDetail');
					foreach($getAllInvoices as $getAllInvoice){
						$getOrganization = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($getAllInvoice['SbsSubscriber']['sbs_subscriber_organization_detail_id']);
						if($getOrganization){
							$organization[$getAllInvoice['CpnSubscriberInvoiceDetail']['invoice_no']] = $getOrganization['SbsSubscriberOrganizationDetail']['organization_name'];
						}
					}
					$this->set(compact('organization'));
				}*/
		
		$getSetting = $this->getAdminSetting();
		$this->set(compact('getSetting'));
		$this->set(compact('subs_plan','subs_company','subs_name','subs_status','subs_page'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CpnSubscriberInvoiceDetail->exists($id)) {
			throw new NotFoundException(__('Invalid cpn subscriber invoice detail'));
		}
		$options = array('conditions' => array('CpnSubscriberInvoiceDetail.' . $this->CpnSubscriberInvoiceDetail->primaryKey => $id));
		$this->set('cpnSubscriberInvoiceDetail', $this->CpnSubscriberInvoiceDetail->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CpnSubscriberInvoiceDetail->create();
			if ($this->CpnSubscriberInvoiceDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn subscriber invoice detail has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn subscriber invoice detail could not be saved. Please, try again.'));
			}
		}
		$sbsSubscribers = $this->CpnSubscriberInvoiceDetail->SbsSubscriber->find('list');
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
		if (!$this->CpnSubscriberInvoiceDetail->exists($id)) {
			throw new NotFoundException(__('Invalid cpn subscriber invoice detail'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->CpnSubscriberInvoiceDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The cpn subscriber invoice detail has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cpn subscriber invoice detail could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CpnSubscriberInvoiceDetail.' . $this->CpnSubscriberInvoiceDetail->primaryKey => $id));
			$this->request->data = $this->CpnSubscriberInvoiceDetail->find('first', $options);
		}
		$sbsSubscribers = $this->CpnSubscriberInvoiceDetail->SbsSubscriber->find('list');
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
		$this->CpnSubscriberInvoiceDetail->id = $id;
		if (!$this->CpnSubscriberInvoiceDetail->exists()) {
			throw new NotFoundException(__('Invalid cpn subscriber invoice detail'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CpnSubscriberInvoiceDetail->delete()) {
			$this->Session->setFlash(__('The cpn subscriber invoice detail has been deleted.'));
		} else {
			$this->Session->setFlash(__('The cpn subscriber invoice detail could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
