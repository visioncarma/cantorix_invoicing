<?php
App::uses('AppController', 'Controller');
/**
 * CpnSubscriptionPlans Controller
 *
 * @property CpnSubscriptionPlan $CpnSubscriptionPlan
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SubscriptionPlansController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public $permission;
	public function beforeFilter() {
        parent::beforeFilter();
        $this->loadModel('CpnSubscriptionPlan');
        $this->layout = "cpn_layout";
	    $this->permission = $this->Session->read('Auth.AllPermissions.Manage Subscription Plans');
		$this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
	    $settingsActive = 'active';
	    $menuActive = 'Manage Subscription Plans';
	    $this->set(compact('settingsActive','menuActive'));
	    // $this->Auth->allow('index','view','add','edit','delete');
	  
      
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->CpnSubscriptionPlan->recursive = 0;
		$this->set('cpnSubscriptionPlans', $this->Paginator->paginate('CpnSubscriptionPlan'));
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
		if (!$this->CpnSubscriptionPlan->exists($id)) {
			throw new NotFoundException(__('Invalid cpn subscription plan'));
		}
		$options = array('conditions' => array('CpnSubscriptionPlan.' . $this->CpnSubscriptionPlan->primaryKey => $id));
		$this->set('cpnSubscriptionPlan', $this->CpnSubscriptionPlan->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if($this->permission['_create'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if ($this->request->is('post')) {
			$getSamePlan = $this->CpnSubscriptionPlan->getSubscriptionByType($this->data['CpnSubscriptionPlan']['type']);
				
			if(!$getSamePlan){
				$this->CpnSubscriptionPlan->create();
				if ($this->CpnSubscriptionPlan->save($this->request->data)) {
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<p>
												<strong>
													<i class="icon-ok"></i>
													Done!
												</strong>A new plan has been added to the system.</p>
										</div>'));
					return $this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>
												<i class="icon-remove"></i>' .
														'Sorry!												
											</strong>Subscription Plan could not be added.Please try again.<br />
										</div>'));
				}
			}else{
				$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>
												<i class="icon-remove"></i>' .
														'Sorry!												
											</strong>A Subscription Plan with same type already exists.Please try again.<br />
										</div>'));
			}
				
			}
		$counOfPlan = $this->CpnSubscriptionPlan->find('count');
			if($counOfPlan == 3){
				$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>
											<p>
											<strong>
												<i class="icon-remove"></i>' .
														'Sorry!												
											</strong>Maximum 3 plans can be added.You cannot add any more plans.<br />
										</div>'));
				return $this->redirect(array('action' => 'index'));
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
		if($this->permission['_update'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if($id){
			$id = $id;
		}else{
			$id = $this->data['CpnSubscriptionPlan']['id'];
		}
		if (!$this->CpnSubscriptionPlan->exists($id)) {
			throw new NotFoundException(__('Invalid cpn subscription plan'));
		}
		
		if (($this->request->is(array('post', 'put')) && ($this->data['CpnSubscriptionPlan']['id']))) {
			$this->request->onlyAllow('post', 'put');
			if ($this->CpnSubscriptionPlan->save($this->request->data)) {
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<p>
												<strong>
													<i class="icon-ok"></i>
													Done!
												</strong>Subscription Plan updated successfully.</p>
										</div>'));
				return $this->redirect(array('action' => 'index'));
			} else{
				$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>Changes to Subscription Plan failed.Please try again.<br />
										</div>'));
			}
		} else {
			$options = array('conditions' => array('CpnSubscriptionPlan.' . $this->CpnSubscriptionPlan->primaryKey => $id));
			$this->request->data = $this->CpnSubscriptionPlan->find('first', $options);
			$data = $this->CpnSubscriptionPlan->find('first', $options);
		}
		$this->set(compact('id','data'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->CpnSubscriptionPlan->id = $id;
		if (!$this->CpnSubscriptionPlan->exists()) {
			throw new NotFoundException(__('Invalid cpn subscription plan'));
		}
		$this->request->onlyAllow('post', 'delete');
		$this->loadModel('SbsSubscriber');
		$subscriberMappedToPlan = $this->SbsSubscriber->getSubscriberBySubscriptionPlan($id);
		if($subscriberMappedToPlan){
			$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>Subscription with this plan exists! Please delete the subscription and then try to delete the plan.<br />
										</div>'));
		
		}else{
			if ($this->CpnSubscriptionPlan->delete()) {
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<p>
												<strong>
													<i class="icon-ok"></i>
													Done!
												</strong>Subscription Plan removed from the system.</p>
										</div>'));
			} else {
				$this->Session->setFlash(__('<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert">
												<i class="icon-remove"></i>
											</button>

											<strong>
												<i class="icon-remove"></i>												
											</strong>Subscription Plan could not be removed.Please try again.<br />
										</div>'));
			}
		
		}
		return $this->redirect(array('action' => 'index'));
		
	}

    public function general_setting(){
		//Configure::write('debug',2);
		$settingsActive = 'active';
		$menuActive = 'General Settings';
		$this->set(compact('settingsActive','menuActive'));
		
		$this->layout = "sbs_layout";
		$this->loadModel('SbsSubscriber');
		$this->loadModel('SbsAgingBucket');
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		
		$permission = $this->Session->read('Auth.AllPermissions.General Settings');
		//debug($permission);
		if($permission['_read'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$subscriber_id           = $this->subscriber;
    	$time_zones              = $this->getAllTimezones();	
		$get_org_id              = $this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($subscriber_id);
		$get_org_detail          = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($get_org_id); 
		$get_subscriber_settings = $this->SbsSubscriberSetting->defaultSettings($subscriber_id);
		$aging_bucket_details    = $this->SbsAgingBucket->find('all',array('conditions'=>array('SbsAgingBucket.sbs_subscriber_id'=>$subscriber_id),'order'=>array('SbsAgingBucket.id ASC'))); 	
		$this->set(compact('time_zones','get_org_detail','get_subscriber_settings','aging_bucket_details','permission'));
		
		if($this->data){ 
			
			 $update_setting=null;
			 $update_setting['SbsSubscriberSetting']['id']                          = $get_subscriber_settings['SbsSubscriberSetting']['id'];
			 $update_setting['SbsSubscriberSetting']['date_format']                 = $this->data['SbsSubscriberSetting']['date_format'];
			 $update_setting['SbsSubscriberSetting']['lines_per_page']              = $this->data['SbsSubscriberSetting']['lines_per_page'];
			 $update_setting['SbsSubscriberSetting']['invoice_number_prefix']       = $this->data['SbsSubscriberSetting']['invoice_number_prefix'];
			 $update_setting['SbsSubscriberSetting']['invoice_sequence_number']     = $this->data['SbsSubscriberSetting']['invoice_sequence_number'];
			 $update_setting['SbsSubscriberSetting']['recurring_status']            = $this->data['SbsSubscriberSetting']['recurring_status'];
			 $update_setting['SbsSubscriberSetting']['recurring_invoice_format']    = $this->data['SbsSubscriberSetting']['recurring_invoice_format'];
			 $update_setting['SbsSubscriberSetting']['quote_number_prefix']         = $this->data['SbsSubscriberSetting']['quote_number_prefix'];
			 $update_setting['SbsSubscriberSetting']['quote_sequence_number']       = $this->data['SbsSubscriberSetting']['quote_sequence_number'];
			 $update_setting['SbsSubscriberSetting']['credit_note_prefix']          = $this->data['SbsSubscriberSetting']['credit_note_prefix'];
			 $update_setting['SbsSubscriberSetting']['credit_note_sequence_number'] = $this->data['SbsSubscriberSetting']['credit_note_sequence_number'];
			 $update_setting['SbsSubscriberSetting']['late_payment_reminder_days']  = $this->data['SbsSubscriberSetting']['late_payment_reminder_days'];
			 $update_setting['SbsSubscriberSetting']['notes']                       = $this->data['SbsSubscriberSetting']['notes'];
			 $update_setting['SbsSubscriberSetting']['terms_conditions']            = $this->data['SbsSubscriberSetting']['terms_conditions'];
			 $update_setting['SbsSubscriberSetting']['email_signature']             = $this->data['SbsSubscriberSetting']['email_signature'];
			 if($_FILES['file']['name'] && ($this->data['SbsSubscriberSetting']['Imageupload'] == 'true')){
	     	    $uploadInvoiceLogo = $this->uploadFiles('files/uploads/logo-subscriber'.$subscriber_id,$_FILES);
	     	 }
			 if(!$uploadInvoiceLogo['errors'] && $_FILES['file']['name'] && ($this->data['SbsSubscriberSetting']['Imageupload'] == 'true') ){
				$update_setting['SbsSubscriberSetting']['invoice_logo'] = $this->webroot.'/'.$uploadInvoiceLogo['urls'][0];
				if($_FILES['file']['name'] ){ 
					$logo_explode= explode('/',$get_subscriber_settings['SbsSubscriberSetting']['invoice_logo']);
				    $file= WWW_ROOT.'files/uploads/logo-subscriber'.$subscriber_id.'/'.$logo_explode[3];
				    unlink($file);
				} 
			 }
			 
			 if($this->SbsSubscriberSetting->save($update_setting)){
			 	
				     $update_org_detail=null;
				     $update_org_detail['SbsSubscriberOrganizationDetail']['id']        = $get_org_detail['SbsSubscriberOrganizationDetail']['id'];
					 $update_org_detail['SbsSubscriberOrganizationDetail']['time_zone'] = $this->data['SbsSubscriberSetting']['time_zone'];
					 $update_org_detail['SbsSubscriberOrganizationDetail']['text_logo'] = $this->data['SbsSubscriberSetting']['text_logo'];
					 if(!$uploadInvoiceLogo['errors'] && $_FILES['file']['name'] && ($this->data['SbsSubscriberSetting']['Imageupload'] == 'true') ){
					    $update_org_detail['SbsSubscriberOrganizationDetail']['logo']   =  $this->webroot.'/'.$uploadInvoiceLogo['urls'][0];
					 }
					 if($this->SbsSubscriberOrganizationDetail->save($update_org_detail)){
					 	
						     if(($this->data['name']) || ($this->data['edit_name'])){
								 	
						     	 if(empty($aging_bucket_details)){
						     	 	     $save_record=0;	
								     	 foreach($this->data['name'] as $key=>$value){
								     	 	
											     $this->SbsAgingBucket->create();
										         $add_aging_bucket=null;
												 $add_aging_bucket['SbsAgingBucket']['bucket']            = $this->data['name'][$key];
												 $add_aging_bucket['SbsAgingBucket']['from_day']          = $this->data['from_day'][$key];
												 $add_aging_bucket['SbsAgingBucket']['to_day']            = $this->data['to_day'][$key];
												 $add_aging_bucket['SbsAgingBucket']['sbs_subscriber_id'] = $subscriber_id;
												 if($this->SbsAgingBucket->save($add_aging_bucket)){
												 	 $save_record++;
												 }	
										}	
						     	 }else{
						     	 	     $edit_record=0;	
								     	 foreach($this->data['edit_name'] as $key1=>$value1){
								     	 	
											    
										         $edit_aging_bucket=null;
											     $edit_aging_bucket['SbsAgingBucket']['id']        = $this->data['edit_id'][$key1];
												 $edit_aging_bucket['SbsAgingBucket']['bucket']    = $this->data['edit_name'][$key1];
												 $edit_aging_bucket['SbsAgingBucket']['from_day']  = $this->data['edit_from_day'][$key1];
												 $edit_aging_bucket['SbsAgingBucket']['to_day']    = $this->data['edit_to_day'][$key1];	
												 if($this->SbsAgingBucket->save($edit_aging_bucket)){
												 	 $edit_record++;
												 }	
										}
						     	 }
								 if($save_record || $edit_record){
								   	       $this->Session->setFlash(__('<div class="alert alert-block alert-success">
																		<button type="button" class="close" data-dismiss="alert">
																			<i class="icon-remove"></i>
																		</button>
							
																		<p>
																			<strong>
																				<i class="icon-ok"></i>
																				Done!
																			</strong>General Settings have been updated.</p>
																	</div>'));
											return $this->redirect(array('controller'=>'subscription_plans','action' => 'general_setting'));						
								  }
							}
					 	
					 }
			 	
			 }
			
		}
    }
    
	public function delete_logo($id=null){
		//Configure::write('debug',2);
		$this->loadModel('SbsSubscriberSetting');
		
		$subscriber_id           = $this->subscriber;
		$get_subscriber_settings = $this->SbsSubscriberSetting->defaultSettings($subscriber_id);
		
		if($get_subscriber_settings['SbsSubscriberSetting']['id'] == $id){
			    	
		    $delete_logo=null;
			$delete_logo['SbsSubscriberSetting']['id']           = $id;
			$delete_logo['SbsSubscriberSetting']['invoice_logo'] = NULL;
			if($this->SbsSubscriberSetting->save($delete_logo)){
				
				 $logo_explode= explode('/',$get_subscriber_settings['SbsSubscriberSetting']['invoice_logo']);
				 $file= WWW_ROOT.'files/uploads/logo-subscriber'.$subscriber_id.'/'.$logo_explode[3];
				 unlink($file);
				 $this->Session->setFlash(__('<div class="alert alert-block alert-success">
														<button type="button" class="close" data-dismiss="alert">
															<i class="icon-remove"></i>
														</button>
			
														<p>
															<strong>
																<i class="icon-ok"></i>
																Done!
															</strong>Logo has been deleted successfully.</p>
													</div>'));
				return $this->redirect(array('controller'=>'subscription_plans','action' => 'general_setting'));										
			}else{
				$this->Session->setFlash(__('<div class="alert alert-danger">
													<button type="button" class="close" data-dismiss="alert">
														<i class="icon-remove"></i>
													</button>
		
													<strong>
														<i class="icon-remove"></i>												
													</strong>Logo cannot be deleted.<br />
												  </div>'));
			  return $this->redirect(array('controller'=>'subscription_plans','action' => 'general_setting'));										  
			}
		}else{
			$this->Session->setFlash(__('<div class="alert alert-danger">
													<button type="button" class="close" data-dismiss="alert">
														<i class="icon-remove"></i>
													</button>
		
													<strong>
														<i class="icon-remove"></i>												
													</strong>Logo cannot be deleted.<br />
												  </div>'));
			return $this->redirect(array('controller'=>'subscription_plans','action' => 'general_setting'));										  
		}
		
		
	}
	
	public function payment_term_setup(){
		//Configure::write('debug',2);
		if(!$this->request->is('ajax')) {
			$this->layout = "sbs_layout";
		}
		
		$settingsActive = 'active';
		$menuActive = 'Payment Terms Setup';
		$this->set(compact('settingsActive','menuActive'));
		
		$this->loadModel('SbsSubscriberSetting');
		$this->loadModel('SbsSubscriberPaymentTerm');
		
		$permission = $this->Session->read('Auth.AllPermissions.Payment Terms Setup');
		//debug($permission);
		if($permission['_read'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
        $this->set(compact('permission'));
		
		$settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
		$limit = $settings['SbsSubscriberSetting']['lines_per_page'];
        
        //$subscriber_payment_detail = $this->SbsSubscriberPaymentTerm->getAllPaymentTermsBySubscriber($this->subscriber);
		$conditions=array('SbsSubscriberPaymentTerm.sbs_subscriber_id'=>$this->subscriber);
		$this->Paginator->settings = array('conditions'=>$conditions,'limit'=>$limit,'order' => array('type_name' => 'ASC'));
	    
	    $this->set('subscriber_payment_detail', $this->Paginator->paginate('SbsSubscriberPaymentTerm'));
	}
 
 
    public function add_payment_term(){
    		
		$this->autoRender=false;	
	    $this->loadModel('SbsSubscriberPaymentTerm');
				
    	$subscriber_id      = $this->subscriber;
		$check_default      = $this->SbsSubscriberPaymentTerm->getDefaultPaymentTerm($subscriber_id);
		$payment_term_exist = $this->SbsSubscriberPaymentTerm->checkPaymentTermExistBySubscriber($subscriber_id,trim($this->data['AddSbsSubscriberPaymentTerm']['term']));
		//$payment_day_exist  = $this->SbsSubscriberPaymentTerm->checkPaymentDaysExistBySubscriber($subscriber_id,trim($this->data['AddSbsSubscriberPaymentTerm']['no_of_days']));
		
		if($this->data){
			
			if($payment_term_exist){
				 $this->Session->setFlash('<div class="alert alert-danger">Payment term name already exists for subscriber.</div>');
				 return $this->redirect(array('action' => 'payment_term_setup'));									  
				
			}else{
				    $add_payment_term=null;
					$add_payment_term['SbsSubscriberPaymentTerm']['sbs_subscriber_id']  = $subscriber_id; 
					$add_payment_term['SbsSubscriberPaymentTerm']['term']               = $this->data['AddSbsSubscriberPaymentTerm']['term']; 	
					$add_payment_term['SbsSubscriberPaymentTerm']['no_of_days']         = $this->data['AddSbsSubscriberPaymentTerm']['no_of_days']; 	
		            if($check_default){
					    $add_payment_term['SbsSubscriberPaymentTerm']['is_default']     = 'N'; 	
					}else{
					    $add_payment_term['SbsSubscriberPaymentTerm']['is_default']     = 'Y'; 	
					}
					
					if($this->SbsSubscriberPaymentTerm->save($add_payment_term)){
						 $this->Session->setFlash('<div class="alert alert-block alert-success">Payment Term has been saved.</div>');
							
					}else{
						 $this->Session->setFlash('<div class="alert alert-danger">Payment term name could not been saved.</div>');
					}
					return $this->redirect(array('action' => 'payment_term_setup'));	
				
			}
		}
    }
	
    public function edit_payment_term($id=null,$page=null){
    	   $permission = $this->Session->read('Auth.AllPermissions.Payment Terms Setup');
		   if($permission['_update'] != 1) {
		            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		   }
		   $this->autoRender=false;
		   $this->loadModel('SbsSubscriberPaymentTerm');
		   
		   $subscriber_id       = $this->subscriber;
		   $payment_term_info   = $this->SbsSubscriberPaymentTerm->getPaymentTermById($id);
		   $payment_term_exist  = $this->SbsSubscriberPaymentTerm->paymentTermExist($subscriber_id,$id,trim($this->data['term'][$id]));
		   //$payment_day_exist   = $this->SbsSubscriberPaymentTerm->paymentDaysExist($subscriber_id,$id,trim($this->data['no_of_days'][$id]));
		   $check_payment_term_default_exist = $this->SbsSubscriberPaymentTerm->checkPaymentTermDefaultBySubscriber($subscriber_id,$id);
		   
		   $this->set(compact('payment_term_info'));
		   
		   if($this->data){
		   	        	
					if(empty($this->data['term'][$id])){
						  $this->Session->setFlash('<div class="alert alert-danger">Payment term name should not be empty.</div>');
						  return $this->redirect(array('action' => 'payment_term_setup/page:'.$page));
						  
					}elseif(empty($this->data['no_of_days'])){
						  $this->Session->setFlash('<div class="alert alert-danger">Payment term days should not be empty.</div>');
						  return $this->redirect(array('action' => 'payment_term_setup/page:'.$page));
						  
					}elseif(($this->data['term'][$id] != $payment_term_info['SbsSubscriberPaymentTerm']['term']) && $payment_term_exist){
						  $this->Session->setFlash('<div class="alert alert-danger">Payment term name already exists for subscriber.</div>');
						  return $this->redirect(array('action' => 'payment_term_setup/page:'.$page));
						  
					}else{
						    	
						    $edit_payment_term = null;
				   	        $edit_payment_term['SbsSubscriberPaymentTerm']['id']         = $id; 
							$edit_payment_term['SbsSubscriberPaymentTerm']['term']       = $this->data['term'][$id]; 
							$edit_payment_term['SbsSubscriberPaymentTerm']['no_of_days'] = $this->data['no_of_days'][$id]; 
							
							if($this->data['is_default'][$id]){
								$default_value= 'Y';
							}else{
								$default_value= 'N';
							}
							
							if($default_value !=  $payment_term_info['SbsSubscriberPaymentTerm']['is_default']){
									if($default_value == 'Y'){
										if(!$check_payment_term_default_exist){
											$edit_payment_term['SbsSubscriberPaymentTerm']['is_default'] = 'Y'; 
										}else{
											$edit_payment_term['SbsSubscriberPaymentTerm']['is_default'] = 'N'; 
										}
									}else{
										if(!$check_payment_term_default_exist){
											$edit_payment_term['SbsSubscriberPaymentTerm']['is_default'] = 'N'; 
										}else{
											$edit_payment_term['SbsSubscriberPaymentTerm']['is_default'] = 'Y'; 
										}
									}
							
							}if($this->SbsSubscriberPaymentTerm->save($edit_payment_term)){
								 $this->Session->setFlash('<div class="alert alert-block alert-success">Payment Term has been updated.</div>');
							}else{
								 $this->Session->setFlash('<div class="alert alert-danger">Payment term could been updated.</div>');
						    }
							return $this->redirect(array('action' => 'payment_term_setup/page:'.$page));
					}	
			}
    }

    public function delete_payment_term($id=null,$page=null){
    	  
		   $permission = $this->Session->read('Auth.AllPermissions.Payment Terms Setup');
		   if($permission['_delete'] != 1) {
		        $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		   }
		   $this->loadModel('AcrClient');
		   $this->loadModel('AcrClientInvoice');
		   $this->loadModel('SbsSubscriberPaymentTerm');
		   $this->autoRender=false;
		   
		   $subscriber_id                  = $this->subscriber;
		   $check_acr_client_exist         = $this->AcrClient->checkPaymentTermBySubscriber($subscriber_id,$id);
		   $check_acr_client_invoice_exist = $this->AcrClientInvoice->checkPaymentTermBySubscriber($subscriber_id,$id);
		   $payment_term_info  = $this->SbsSubscriberPaymentTerm->getPaymentTermById($id);
		   
		   if(!$check_acr_client_exist && !$check_acr_client_invoice_exist){
		   	   	
		   	   if($this->SbsSubscriberPaymentTerm->delete($id)){
		   	   	    $this->Session->setFlash('<div class="alert alert-block alert-success">Payment Term '.$payment_term_info['SbsSubscriberPaymentTerm']['term'].' was successfully deleted.</div>');
		   	   }else{
		   	   	    $this->Session->setFlash('<div class="alert alert-danger">Payment Term '.$payment_term_info['SbsSubscriberPaymentTerm']['term'].' could not been deleted.</div>');
		   	   }
			}else{
		   	     $this->Session->setFlash('<div class="alert alert-danger">Payment Term '.$payment_term_info['SbsSubscriberPaymentTerm']['term'].' could not been deleted.</div>');
			}
		    return $this->redirect(array('action' => 'payment_term_setup/page:'.$page));
    }
	
	public function delete_all(){
    	  
		   $this->autoRender=false;
		   $this->loadModel('AcrClient');
		   $this->loadModel('AcrClientInvoice');
		   $this->loadModel('SbsSubscriberPaymentTerm');
		   
		   if($this->data['Delete']){
			  
			  $i=0;	
			  $check_row=array_sum($this->data['Delete']);
			  if($check_row){ 	
					     foreach($this->data['Delete'] as $del_id => $del_val):
						        if($del_val){
						        	 $this->SbsSubscriberPaymentTerm->delete($del_id);
							         $i++;
						        }
						 endforeach;
					     if($i == 1) {
						     $this->Session->setFlash('<div class="alert alert-block alert-success">Payment Term was deleted.</div>');
					     }elseif($i > 1){
					     	 $this->Session->setFlash('<div class="alert alert-block alert-success">'.$i .' Payment Term were deleted.</div>');
						      
					     }else{
					     	 $this->Session->setFlash('<div class="alert alert-danger">Payment Term could not been deleted.</div>');
					     }
                         return $this->redirect(array('action' => 'payment_term_setup/page:'.$page));
					     		
			  }else{
			  	     	
					$this->Session->setFlash('<div class="alert alert-danger">Select payment terms to be deleted.</div>');
					return $this->redirect(array('action' => 'payment_term_setup/page:'.$page));				
			  }
			 
	  }else{
			$this->Session->setFlash('<div class="alert alert-danger">Select payment terms to be deleted.</div>');	
		    return $this->redirect(array('action' => 'payment_term_setup/page:'.$page));							
	  }
   }

   public function checkPaymentTerm($id=null){
   	       	
   	       $this->autoRender=false;	
   	       $this->loadModel('AcrClient');
		   $this->loadModel('AcrClientInvoice');
		   $this->loadModel('SbsSubscriberPaymentTerm');
		   
		   $subscriber_id                  = $this->subscriber;
		   $check_acr_client_exist         = $this->AcrClient->checkPaymentTermBySubscriber($subscriber_id,$id);
		   $check_acr_client_invoice_exist = $this->AcrClientInvoice->checkPaymentTermBySubscriber($subscriber_id,$id);
		   
		   if(!$check_acr_client_exist && !$check_acr_client_invoice_exist ){
		   	  return "notexist";
		   }else{
		   	  return "exist";
		   }
   }
}
