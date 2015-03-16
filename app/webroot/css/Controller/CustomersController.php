<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'php-excel-reader/excel_reader2');
/**
 * CpnCurrencies Controller
 *
 * @property Customers $Customers
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
	class CustomersController extends AppController {
		public $components = array('Paginator', 'Session','RequestHandler');
		public $uses = array('AcrClient');
		public $subscriber = NULL;
		private $permission = NULL;
		public function beforeFilter() {
	        parent::beforeFilter();
	      	//$this->Auth->allow('login','inactive');
	      	$this->loadModel('CpnCurrency');
	      	$this->layout = "sbs_layout";
	  		$this->permission = $this->Session->read('Auth.AllPermissions.Customers');
	      	$this->subscriber = $this->Session->read('Auth.User.SbsSubscriber.id');
			$customersActive = 'active';
			$this->set(compact('customersActive'));
	    }
		
		/**
		 * @Author Ganesh
		 * @Method Lists all the customers for an subscribers
		 * @Since 18-Jun-2014
		 * */		
		public function index($organization = 0,$client = 0,$email = 0,$status = 0,$page=1) {
			$permission = $this->permission;
			if($this->permission['_read'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			if($this->request->is('ajax')) {
				$ajax = TRUE;
				$this->set(compact('ajax'));
			}
			$this->set(compact('permission'));
			$this->loadModel('CpnSubscriptionPlan');
			$cpn_subscription_plan_id = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
			$noofcustomers = $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);
			$presentCustCount = $this->AcrClient->find('count',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber,'AcrClient.status'=>'active')));
			if($noofcustomers['CpnSubscriptionPlan']['no_of_clients'] > $presentCustCount) {
				$showAddButton = TRUE;
			} else {
				$showAddButton = FALSE;
			}
			if($noofcustomers['CpnSubscriptionPlan']['no_of_clients'] == -1) {
				$showAddButton = TRUE;
			}
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('AcrClientContact');
			$settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
			$this->AcrClient->recursive = -1;
			$limit = 10;
			$limit = $settings['SbsSubscriberSetting']['lines_per_page'];
			$order = array('AcrClient.client_name' => 'ASC');
			$conditions = array('AcrClient.sbs_subscriber_id'=>$this->subscriber);
			
			if($organization) {
				$this->request->data['Filter']['organization_name'] = $organization;
			}
			if($client) {
				$this->request->data['Filter']['client_name'] = $client;
			}
			if($email) {
				$this->request->data['Filter']['email1'] = $email;
			}
			if($status) {
				$this->request->data['Filter']['status'] = $status;
			}
			if(!empty($this->data)) {
				if(!empty($this->request->data['Filter']['organization_name'])) {
					 $organization = trim($this->request->data['Filter']['organization_name']);
				}
				if(!empty($this->request->data['Filter']['client_name'])) {
					$client = trim($this->request->data['Filter']['client_name']);
				}
				if(!empty($this->request->data['Filter']['email1'])) {
					$email = trim($this->request->data['Filter']['email1']);
				}
				if(!empty($this->request->data['Filter']['status'])) {
					$status = trim($this->request->data['Filter']['status']);
				}
			
				if(empty($organization) && empty($client) && empty($email) && empty($status)) {
					$this->Session->setFlash('<div class="alert alert-info">Please enter atleast one search term!</div>');
					$this->redirect(array('action'=>'index',$organization,$client,$email,$status,'page:'.$page));
				}
				
				$condition_array=null;$organization_array=null;$client_array=null;$email_array=null;$status_array=null;
				if($organization) {
					$organization_array = array('AcrClient.sbs_subscriber_id'=>$this->subscriber,'AcrClient.organization_name LIKE'=>'%'.$organization.'%');
				}
				if($client) {
					$client_array = array('AcrClient.sbs_subscriber_id'=>$this->subscriber,'AcrClient.client_name LIKE'=>'%'.$client.'%');
				}
				if($email) {
					$clientIds = $this->AcrClientContact->find('list',array('conditions'=>array('AcrClientContact.sbs_subscriber_id'=>$this->subscriber,'AcrClientContact.email LIKE'=>'%'.$email.'%'),'fields'=>array('acr_client_id','acr_client_id')));
					$email_array = array('AcrClient.id'=>$clientIds);
				}
				if($status) {
					$status_array = array('AcrClient.sbs_subscriber_id'=>$this->subscriber,'AcrClient.status'=>$status);
				}
				$conditions = array($organization_array,$client_array,$email_array,$status_array);
			}
			if(!$limit) {
				$limit = 10;
			}
			$this->Paginator->settings = array('conditions'=>$conditions,'limit'=>$limit,'order'=>$order);
			$customers = $this->Paginator->paginate('AcrClient');
			
			foreach ($customers as $key => $value) {
				$clients[$key] = $value;
				$clients[$key]['Contact'] = $this->AcrClientContact->find('first',array(
					'conditions'=>array('AcrClientContact.acr_client_id'=>$value['AcrClient']['id'],'AcrClientContact.is_primary'=>'Y'),
					'fields' => array('email')
				));
			}
			$this->set('clients',$clients);
			$this->set('subscriberID',$this->subscriber);
			$this->set(compact('organization','client','email','status','page','showAddButton'));
			if(empty($customers)) {
				//$this->Session->setFlash('<div class="alert alert-danger">Sorry! customers not found!</div>');
				return;
			}
			
		}
		
		
		
		public function delete($subsID = NULL,$id = 0,$organization = 0,$client = 0,$email = 0,$status = 0,$page=1) {
			//Configure::write('debug',2);
			if($this->permission['_delete'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			if($subsID != $this->subscriber) {
				$this->Session->setFlash('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
				$this->redirect(array('action'=>'index',$organization,$client,$email,$status,'page:'.$page));
			}
			$this->loadModel('AcrClientInvoice');
			$this->loadModel('SlsQuotation'); 
			$this->loadModel('AcrClientCustomValue');
			$this->loadModel('AcrClientContact');
			$clientName = $this->AcrClient->findById($id,array('organization_name'));
			$invoice = $this->AcrClientInvoice->find('first',array('conditions'=>array('AcrClientInvoice.acr_client_id'=>$id),'fields'=>array('id')));
			$quote = $this->SlsQuotation->find('first',array('conditions'=>array('SlsQuotation.acr_client_id'=>$id),'fields'=>array('id')));
			if(empty($invoice) && empty($quote)) {
				$this->AcrClientCustomValue->deleteAll(array('AcrClientCustomValue.acr_client_id'=>$id),FALSE);
				$this->AcrClientContact->deleteAll(array('AcrClientContact.acr_client_id'=>$id),FALSE);
				$deleteed = $this->AcrClient->deleteAll(array('AcrClient.id'=>$id),FALSE);
				if ($deleteed) {
					$this->Session->setFlash(__('<div class="alert alert-block alert-success">'.$clientName['AcrClient']['organization_name'].' has been deleted.</div>'));
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">Customer couldn\'t be deleted due to internal error.</div>');
				}
			} else {
				$updated = $this->AcrClient->updateAll(
					array('AcrClient.status' => "'Inactive'"),array('AcrClient.id ' => $id)
				);
				if($updated) {
					if($invoice && !$quote) {
						$msg = '<div class="alert alert-block alert-success">'.$clientName['AcrClient']['organization_name'].' has been made inactive due to existing invoice.</div>';
					} elseif(!$invoice && $quote) {
						$msg = '<div class="alert alert-block alert-success">'.$clientName['AcrClient']['organization_name'].' has been made inactive due to existing quotes.</div>';
					} elseif($invoice && $quote) {
						$msg = '<div class="alert alert-block alert-success">'.$clientName['AcrClient']['organization_name'].' has been made inactive due to existing invoices and quotes.</div>';
					}
					$this->Session->setFlash(__($msg));
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">Customer couldn\'t be made inactive due to internal error.</div>');
				}
			}
			$this->redirect(array('action'=>'index',$organization,$client,$email,$status,'page:'.$page));
		}
		
		public function add() {
			//configure::write('debug',2);
			$this->loadModel('CpnCurrency');
			$this->loadModel('CpnLanguage');
			$this->loadModel('SbsSubscriber');
			$this->loadModel('AcrClientContact');
			$this->loadModel('AcrClientInvoice');
			$this->loadModel('CpnSubscriptionPlan');
			$this->loadModel('AcrClientCustomField');
			$this->loadModel('ASbsSubscribercrClientCustomValue');
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('SbsSubscriberPaymentTerm');
			$this->loadModel('SbsSubscriberOrganizationDetail');
			$this->loadModel('SbsSubscriberCpnCurrencyMapping');
			$subscriber_id=$this->subscriber;
			
			if($this->permission['_create'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			$cpn_subscription_plan_id = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
			$noofcustomers = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.id'=>$cpn_subscription_plan_id),'fields'=>array('CpnSubscriptionPlan.no_of_clients')));
			$presentCustCount = $this->AcrClient->find('count',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber,'AcrClient.status'=>'active')));
			if($noofcustomers['CpnSubscriptionPlan']['no_of_clients'] > $presentCustCount) {
				$showAddButton = TRUE;
			} else {
				$showAddButton = FALSE;
			}
			if($noofcustomers['CpnSubscriptionPlan']['no_of_clients'] == -1) {
				$showAddButton = TRUE;
			}
			if(!$showAddButton){
				$this->Session->setFlash(('<div class="alert alert-danger">'.__('Maximum limit is '.$noofcustomers['CpnSubscriptionPlan']['no_of_clients'].'.You are trying to exceed the highest limit').'</div>'));
			}else{
			$this->set(compact('showAddButton'));	
			
			$subscriber_settings = $this->SbsSubscriberSetting->defaultSettings($this->subscriber);
	        $defaultCurrenyId    = $subscriber_settings['SbsSubscriberSetting']['cpn_currency_id'];
			//debug($defaultCurrenyId);
		    $organisationDetailId= $this->SbsSubscriber->getOrganisationDetailIdBYSubscriber($subscriber_id);
			$defaultLanguageId = $this->SbsSubscriberOrganizationDetail->getLanguageByOrganisationId($organisationDetailId);
			$paymentTermDefault = $this->SbsSubscriberPaymentTerm->getDefaultTerm($this->subscriber);
			$countriesList = AppController::countryList();	
			foreach($countriesList as $key=>$val){
				$countries[$val] = $val;
			}
			$languages = $this->CpnLanguage->getLanguage();
			$getSubscriberCurrencies = $this->SbsSubscriberCpnCurrencyMapping->getListOfSubscriberCurrency($this->subscriber);
			//debug($getSubscriberCurrencies);
			$currencyActual = $this->CpnCurrency->getCurrency();
			//debug($currencyActual);
			foreach($getSubscriberCurrencies as $k11 => $v11) {
				$currencies[$v11] = $currencyActual[$v11];
			}
			//debug($currencies);
			$field_names = $this->AcrClientCustomField->getFieldBySubscriber($subscriber_id); 
			$payment_terms = $this->SbsSubscriberPaymentTerm->getPaymentTermsBySubscriber($subscriber_id);
			$this->set(compact('paymentTermDefault','currencies','countries','languages','field_names','payment_terms','getSubscriberCurrencies','defaultCurrenyId','defaultLanguageId'));
			
			if($this->data){
					
				$contact_count=count($this->data)-1;
				$clientNo=$this->AcrClient->getClientNo($subscriber_id);
				
			    $this->AcrClient->create();
				if($this->data['AcrClient']['send_invoice_byEmail']){
				    $this->request->data['AcrClient']['send_invoice_by'] = 'email';
				}else{
				    $this->request->data['AcrClient']['send_invoice_by'] = 'snail_mail';
				}
				if($this->data['AcrClient']['status']){
					$this->request->data['AcrClient']['status'] = 'active';
				}else{
				    $this->request->data['AcrClient']['status'] = 'Inactive';
				}
				$this->request->data['AcrClient']['client_no']           = $clientNo;
				$this->request->data['AcrClient']['sbs_subscriber_id']   = $subscriber_id;
				
				if($this->AcrClient->save($this->request->data,array('validate'=>false)));
					        
					        $lastInsertedId=$this->AcrClient->getLastInsertId();
					        for($i=1; $i <= $contact_count ;$i++) {
					        	
					        	 if($this->data['Contact'.$i]['name']){
					        	 	     	
					        	 	     $addClientContact=null;
							        	 $this->AcrClientContact->create();
							        	 
							        	 $addClientContact['AcrClientContact']['acr_client_id']     = $lastInsertedId;
							        	 $addClientContact['AcrClientContact']['name']              = $this->data['Contact'.$i]['name'];
							        	 $addClientContact['AcrClientContact']['sur_name']          = $this->data['Contact'.$i]['sur_name'];
							        	 $addClientContact['AcrClientContact']['email']             = $this->data['Contact'.$i]['email'];
							        	 $addClientContact['AcrClientContact']['mobile']            = $this->data['Contact'.$i]['mobile'];
							        	 $addClientContact['AcrClientContact']['home_phone']        = $this->data['Contact'.$i]['home_phone'];
							        	 $addClientContact['AcrClientContact']['work_phone']        = $this->data['Contact'.$i]['work_phone'];
							        	 $addClientContact['AcrClientContact']['sbs_subscriber_id'] = $subscriber_id;
							        	 if($this->data['Contact'.$i]['is_primary']){
							        	 $addClientContact['AcrClientContact']['is_primary']         = 'Y';	
							        	 }else{
							        	 $addClientContact['AcrClientContact']['is_primary']         = 'N';	
							        	 }
										 $this->AcrClientContact->save($addClientContact,array('validate'=>false));
							       }
					        	 
					        }
					        foreach($this->data['FieldValue'] as $key=>$val){
					        	
					        	  $addFieldValue=null;
					        	  $this->AcrClientCustomValue->create();
					        	  $addFieldValue['AcrClientCustomValue']['data']                       = $val;
					        	  $addFieldValue['AcrClientCustomValue']['acr_client_id']              = $lastInsertedId;
					        	  $addFieldValue['AcrClientCustomValue']['acr_client_custom_field_id'] = $key;
					        	  $this->AcrClientCustomValue->save($addFieldValue);
					        }
					        $clientName=$this->AcrClientContact->getClientContactName($lastInsertedId);
					        $addClientName=null;
					        $addClientName['AcrClient']['id']          = $lastInsertedId;
					        $addClientName['AcrClient']['client_name'] = $clientName;
					        $this->AcrClient->save($addClientName);
							$this->Session->setFlash(__('<div class="alert alert-block alert-success">Customer has been saved!</div>'));
			                $this->redirect(array('controller'=>'customers','action'=>'index'));
				}
			}
		}
	
		
		
		public function edit($id = NULL,$subscriberID = NULL,$org = 0,$client = 0,$eml = 0,$st = 0,$page=1){ 
			//configure::write('debug',2);
			if(($this->permission['_update'] != 1) || ($subscriberID != $this->subscriber)) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			$this->loadModel('CpnCurrency');
			$this->loadModel('CpnLanguage');
			$this->loadModel('AcrClientContact');
			$this->loadModel('AcrClientInvoice');
			$this->loadModel('AcrClientCustomField');
			$this->loadModel('AcrClientCustomValue');
			$this->loadModel('CpnSubscriptionPlan');
			$this->loadModel('SbsSubscriberPaymentTerm');
			$this->loadModel('SbsSubscriberCpnCurrencyMapping');
			$subscriber_id=$this->subscriber;
			
			$cpn_subscription_plan_id = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
			$noofcustomers = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.id'=>$cpn_subscription_plan_id),'fields'=>array('CpnSubscriptionPlan.no_of_clients')));
			$planLimit=$noofcustomers['CpnSubscriptionPlan']['no_of_clients'];
			$presentCustCount = $this->AcrClient->find('count',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber,'AcrClient.status'=>'active')));
			if(($planLimit != '-1') && ($presentCustCount < $planLimit) ){
				
				$restrict_status ='1';
				$this->set(compact('restrict_status'));
			}
			$client_detail=$this->AcrClient->getClientDetail($id);
			$fieldValues=$this->AcrClientCustomValue->getCustomValueByClient($id);
			$fieldValueId=$this->AcrClientCustomValue->getCustomValueByField($id);
			$clientInvoice=$this->AcrClientInvoice->getInvoiceByClient($id);
			$client_contact_details=$this->AcrClientContact->getClientContactDetail($id);
			$edit_count=count($client_contact_details);
			
			$countriesList = AppController::countryList();	
			foreach($countriesList as $key=>$val){
				$countries[$val] = $val;
			}
			$languages = $this->CpnLanguage->getLanguage();
			$getSubscriberCurrencies = $this->SbsSubscriberCpnCurrencyMapping->getListOfSubscriberCurrency($this->subscriber);
			$currencyActual = $this->CpnCurrency->getCurrency();
			foreach($getSubscriberCurrencies as $k11 => $v11) {
				$currencies[$v11] = $currencyActual[$v11];
			}
			$field_names = $this->AcrClientCustomField->getFieldBySubscriber($subscriber_id); 
			$payment_terms = $this->SbsSubscriberPaymentTerm->getPaymentTermsBySubscriber($subscriber_id);
			$this->set(compact('client_detail','client_contact_details','edit_count','fieldValues','id','clientInvoice','org','client','eml','st','page','currencies','countries','languages','field_names','payment_terms'));
			
			if($this->data){
				  
				    $addCount = count($this->data['Add']) + ($edit_count);
				    $contactCount= $edit_count + 1;
				    
				    $this->request->data['AcrClient']['id']                                 = $id;
				    $this->request->data['AcrClient']['sbs_subscriber_id']                  = $subscriber_id;
				    if($this->data['AcrClient']['send_invoice_byEmail']){
		   				$this->request->data['AcrClient']['send_invoice_by'] 				= 'email';
		   			}else{
		   				$this->request->data['AcrClient']['send_invoice_by'] 				= 'snail_mail';
		   			}
		   			if($this->data['AcrClient']['status']){
		   				$this->request->data['AcrClient']['status'] 						= 'active';
		   			}else{
		   				$this->request->data['AcrClient']['status'] 						= 'Inactive';
		   			}
		   			if($this->AcrClient->save($this->request->data,array('validate'=>false))){
				  		
				  		 for($cnt=1; $cnt <= $edit_count ; $cnt++ ){
				  		  	
				  		  	     if($this->data['Edit']['Contact'.$cnt]){
				  		  	     	    
				  		  	     	    $edit_contact=null;
				  		  	     	    $edit_contact['AcrClientContact']['id']          = $this->data['Edit']['Contact'.$cnt]['contactid'];
				  		  	     	    $edit_contact['AcrClientContact']['name']        = $this->data['Edit']['Contact'.$cnt]['name'];
				  		  	     	    $edit_contact['AcrClientContact']['sur_name']    = $this->data['Edit']['Contact'.$cnt]['sur_name'];
				  		  	     	    $edit_contact['AcrClientContact']['email']       = $this->data['Edit']['Contact'.$cnt]['email'];
				  		  	     	    $edit_contact['AcrClientContact']['mobile']      = $this->data['Edit']['Contact'.$cnt]['mobile'];
				  		  	     	    $edit_contact['AcrClientContact']['home_phone']  = $this->data['Edit']['Contact'.$cnt]['home_phone'];
				  		  	     	    $edit_contact['AcrClientContact']['work_phone']  = $this->data['Edit']['Contact'.$cnt]['work_phone'];
				  		  	     	    if($this->data['Edit']['Contact'.$cnt]['is_primary']){
				  		  	     	    $edit_contact['AcrClientContact']['is_primary']  = 'Y';	
				  		  	     	    }else{
				  		  	     	    $edit_contact['AcrClientContact']['is_primary']  = 'N';	
				  		  	     	    }	
				  		  	     	    $this->AcrClientContact->save($edit_contact);
				  		  	     }
				  		  }
				  		  $addCount = count($this->data['Add']) + ($edit_count);
				  		  $contactCount= $edit_count + 1;
				  		  for($a = $contactCount; $a <= $addCount ; $a++ ){
				  		   	    
				  		   	   if($this->data['Add']['Contact'.$a] && ($this->data['Add']['Contact'.$a]['name'])){
				  		   	   	
				  		   	   	        $addNewContact=null;
						  		   	    $this->AcrClientContact->create();
						  		   	    $addNewContact['AcrClientContact']['name']              = $this->data['Add']['Contact'.$a]['name'];
						  		   	    $addNewContact['AcrClientContact']['sur_name']          = $this->data['Add']['Contact'.$a]['sur_name'];
						  		   	    $addNewContact['AcrClientContact']['email']             = $this->data['Add']['Contact'.$a]['email'];
						  		   	    $addNewContact['AcrClientContact']['mobile']            = $this->data['Add']['Contact'.$a]['mobile'];
						  		   	    $addNewContact['AcrClientContact']['home_phone']        = $this->data['Add']['Contact'.$a]['home_phone'];
						  		   	    $addNewContact['AcrClientContact']['work_phone']        = $this->data['Add']['Contact'.$a]['work_phone'];
						  		   	    if($this->data['Add']['Contact'.$a]['is_primary']){
						  		   	    $addNewContact['AcrClientContact']['is_primary']        = 'Y';	
						  		   	    }else{
						  		   	    $addNewContact['AcrClientContact']['is_primary']        = 'N';
						  		   	    }
						  		   	    $addNewContact['AcrClientContact']['sbs_subscriber_id'] = $subscriber_id;
						  		   	    $addNewContact['AcrClientContact']['acr_client_id'] = $id;
						  		   	    $this->AcrClientContact->save($addNewContact);
						  		}
				  		  }
				  		  if($this->data['FieldValue']){
				  		  	  foreach($this->data['FieldValue'] as $key1=>$val1){
				  		  	  	       if($val1){
				  		  	  	       		 $editFieldValue=null;
				  		  	          	     $editFieldValue['AcrClientCustomValue']['id']   = $key1; 
				  		  	           	     $editFieldValue['AcrClientCustomValue']['acr_client_id'] = $id;
				  		  	          	     $editFieldValue['AcrClientCustomValue']['data'] = $val1;
				  		  	          	     $this->AcrClientCustomValue->save($editFieldValue,array('validate'=>false));
				  		  	  	       }
				  		  	  	       
				  		  	  }
				  		}
                        
						$clientName=$this->AcrClientContact->getClientContactName($id);
				        $addClientName=null;
				        $addClientName['AcrClient']['id']          = $id;
				        $addClientName['AcrClient']['client_name'] = $clientName;
				        $this->AcrClient->save($addClientName,array('validate'=>false));
						$this->Session->setFlash(__('<div class="alert alert-block alert-success">Customer Details has been updated!</div>'));
			            $this->redirect(array('action'=>'index',$org,$client,$eml,$st,'page:'.$page));
				  	}	
			}
		}
		
		public function view($id = NULL,$subscriberID = NULL, $org = 0,$client = 0,$eml = 0,$st = 0,$page=1){ 
			//Configure::write('debug',2);
			
			if(($this->permission['_read'] != 1) || ($subscriberID != $this->subscriber)) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			//$this->request->onlyAllow('post', 'view');
			
			$this->loadModel('CpnCurrency');
			$this->loadModel('CpnLanguage');
			$this->loadModel('AcrClientInvoice');
			$this->loadModel('AcrClientContact');
			$this->loadModel('AcrClientCustomField');
			$this->loadModel('AcrClientCustomValue');
			$this->loadModel('SbsSubscriberPaymentTerm');
			
			$this->AcrClient->Behaviors->attach('Containable');
			$subscriber_id=$this->subscriber;
			
			$countries = AppController::countryList();	
			$fieldValues=$this->AcrClientCustomValue->getCustomValueByClient($id);
			$client_contact_details=$this->AcrClientContact->getClientContactDetail($id);
			$field_names = $this->AcrClientCustomField->getFieldBySubscriber($subscriber_id); 
			$primary_client_contact=$this->AcrClientContact->getClientPrimaryContactDetail($id);
			//debug($primary_client_contact);
			$client_detail=$this->AcrClient->find('first',array('conditions'=>array('AcrClient.id'=>$id),'contain'=>array('CpnLanguage.language','CpnCurrency.code')));
			$paymentTerm=$this->SbsSubscriberPaymentTerm->find('first',array('conditions'=>array('SbsSubscriberPaymentTerm.id'=>$client_detail['AcrClient']['sbs_subscriber_payment_term_id']),'fields'=>array('SbsSubscriberPaymentTerm.term')));
			$clientInvoice= $this->AcrClientInvoice->find('list',array('conditions'=>array('AcrClientInvoice.acr_client_id'=>$id,'OR'=>array(array('AcrClientInvoice.status '=>'Open'),array('AcrClientInvoice.status'=>'OverDue'))),'fields'=>array('AcrClientInvoice.func_currency_total')));
			$amount_due=array_sum($clientInvoice);
			$this->set(compact('client_detail','client_contact_details','primary_client_contact','fieldValues','field_names','amount_due','countries','paymentTerm','org','client','eml','st','page'));
		}
		public function downloadLink(){
			$this->viewClass = 'Media';
        	$params = array(
            	'id'        => 'clientsInformations.xls',
           	 	'name'      => 'clientsInformations',
            	'download'  => true,
            	'extension' => 'xls',
            	'path'      => 'files'.DS
        	);
        	$this->set($params);
		}
/**
 * Display the content of example.xls
 */
		function show_excel() {
			$this->loadModel('AcrClient');
	   		$this->loadModel('CpnSubscriptionPlan');
			if($this->data){
				if((($_FILES['file']['type'] == 'application/vnd.ms-excel') || ($_FILES['file']['type'] == 'application/octet-stream'))){
					$fileOK = $this->uploadFiles('files', $_FILES);
					if($fileOK['urls']['0']){
	   					//$excel = new PhpExcelReader;
	   						$excel = new Spreadsheet_Excel_Reader;
	   						$excel->read($fileOK['urls']['0']);
	   						$nr_sheets = count($excel->sheets);
	   						$excel_data = '';
	   						$sheetOrderProvided = array(
	   							'0'=>'Instruction Sheets',
	   							'1'=>'Clients Informations',
	   							'2'=>'Contact Informations'
	   						);
	   						foreach($sheetOrderProvided as $key1=>$val1){
	   							if($excel->boundsheets[$key1]['name'] != $val1){
	   								$sheetNameOrder = 1;
	   							}
	   						}
	   						if((!$sheetNameOrder)){
	   							$this->loadModel('AcrClient');
	   							$this->loadModel('CpnSubscriptionPlan');
			 					$this->loadModel('AcrClientContact');
			 					$this->loadModel('CpnLanguage');
			 					$this->loadModel('SbsSubscriberPaymentTerm');
			 					$this->loadModel('CpnCurrency');
	   							$cpn_subscription_plan_id = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
								$noofcustomers = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.id'=>$cpn_subscription_plan_id)));
								$presentCustCount = $this->AcrClient->find('count',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber,'AcrClient.status'=>'active')));
								$totalCountAfterImport = $presentCustCount + $excel->sheets['1']['numRows'] -1;
								if($noofcustomers['CpnSubscriptionPlan']['no_of_clients'] > $totalCountAfterImport) {
									$showAddButton = TRUE;
								} else {
									$showAddButton = FALSE;
								}
								if($noofcustomers['CpnSubscriptionPlan']['no_of_clients'] == -1) {
									$showAddButton = TRUE;
								}
								if(!$showAddButton){
									$this->Session->setFlash(('<div class="alert alert-danger">'.__('Maximum limit is '.$noofcustomers['CpnSubscriptionPlan']['no_of_clients'].'.You are trying to exceed the highest limit').'</div>'));
								}else{
										for($i=1; $i<$nr_sheets; $i++) {
									if($excel->boundsheets[$i]['name'] == $sheetOrderProvided[$i]){
										//$excel_data =  $this->sheetData($excel->sheets[$i],$excel->boundsheets[$i]['name']) ;  
										
										
			 							$clientInformationSuccessCount = 0;
			 							$clientContactInformation = 0;
										if($excel->boundsheets[$i]['name'] == 'Clients Informations'){
											$clientInformation = $this->sheetData($excel->sheets[$i],$excel->boundsheets[$i]['name']) ;
										}if($excel->boundsheets[$i]['name'] == 'Contact Informations'){
											$clientContact = $this->sheetData($excel->sheets[$i],$excel->boundsheets[$i]['name']) ;
											foreach($clientInformation as $key=>$informations){
												$contactArray = null;
												foreach($clientContact as $key1=>$contactInformation){
													if($contactInformation['Client Sl No'] == $informations['Client Sl No.']){
														$contactArray[$key1] = $contactInformation;
													}
												}
												$subscriberId = $this->Session->read('Auth.User.sbs_subscriber_id');
												$orgExists= $this->AcrClient->find('first',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$subscriberId,'AcrClient.organization_name'=>trim($informations['Organization Name']))));
												if(empty($orgExists)){
													$getLanguageId = $this->CpnLanguage->getLanguageByName($informations['Language']);
													if($getLanguageId){
														$getPaymentTermId = $this->SbsSubscriberPaymentTerm->getTermsByName($informations['Payment Terms'],$subscriberId);
														if($getPaymentTermId){
															$getCurrencyId = $this->CpnCurrency->getCurrencyIdByCurrencyCode($informations['Currency Code']);
															if($getCurrencyId){
																$newClientId = $this->AcrClient->importClient($subscriberId,$informations,$getLanguageId,$getCurrencyId,$getPaymentTermId);
																	if($newClientId){
																		if($newClientId['Success']){
																			$clientInformationSuccessCount++;
																		}else{
																			$errorMessage[$key]['Client Sl No'] = $informations['Client Sl No.'];
																			$errorMessage[$key]['Client Name']		 	=  $informations['Client Name'];
																			$errorMessage[$key]['Organization Name'] 	=  $informations['Organization Name'];
																			$errorMessage[$key]['Error Message'] 		=  $newClientId['error'];
																		}
																		$NewClientContact = $this->AcrClientContact->importClientContact($subscriberId,$newClientId['Success'],$contactArray);
																		if($NewClientContact && $newClientId['Success']){
																			if($NewClientContact['Success']){
																				$clientContactInformation++;
																			}else{
																				foreach($contactArray as $key11=>$val11){
																					$contactError[$key11]['Client Sl No'] 			=  $val11['Client Sl No'];
																					$contactError[$key11]['Contact Name']		 	=  $val11['Contact Name'];
																					$contactError[$key11]['Contact Email'] 			=  $val11['Contact Email'];
																					$contactError[$key11]['Mobile'] 				=  $val11['Mobile'];
																					$contactError[$key11]['Error Message'] 			=  $NewClientContact['error'];
																				}
																			}
																		}else{
																			foreach($contactArray as $key11=>$val11){
																				$contactError[$key11]['Client Sl No'] 			=  $val11['Client Sl No'];
																				$contactError[$key11]['Contact Name']		 	=  $val11['Contact Name'];
																				$contactError[$key11]['Contact Email'] 			=  $val11['Contact Email'];
																				$contactError[$key11]['Mobile'] 				=  $val11['Mobile'];
																				$contactError[$key11]['Error Message'] 			=  "There is a problem in importing the customer associated with this contact";
																			}
																		}
																		
																	}
															}else{
																$errorMessage[$key]['Client Sl No'] 		=  $informations['Client Sl No.'];
																$errorMessage[$key]['Client Name']		 	=  $informations['Client Name'];
																$errorMessage[$key]['Organization Name'] 	=  $informations['Organization Name'];
																$errorMessage[$key]['Error Message'] 		=  "Currency not supported";
															}
															
														}else{
															$errorMessage[$key]['Client Sl No'] 		=  $informations['Client Sl No.'];
															$errorMessage[$key]['Client Name']		 	=  $informations['Client Name'];
															$errorMessage[$key]['Organization Name'] 	=  $informations['Organization Name'];
															$errorMessage[$key]['Error Message'] 		=  "Payment Type is not supported";
														}
														
													}else{
														$errorMessage[$key]['Client Sl No'] 		=  $informations['Client Sl No.'];
														$errorMessage[$key]['Client Name']		 	=  $informations['Client Name'];
														$errorMessage[$key]['Organization Name'] 	=  $informations['Organization Name'];
														$errorMessage[$key]['Error Message'] 		=  "Language entered is not supported";
													}
												}else{
													$errorMessage[$key]['Client Sl No'] 		=  $informations['Client Sl No.'];
													$errorMessage[$key]['Client Name']		 	=  $informations['Client Name'];
													$errorMessage[$key]['Organization Name'] 	=  $informations['Organization Name'];
													$errorMessage[$key]['Error Message'] 		=  "Organisation already exists";
												}
												
												
											}
										}
									}else{
										$this->Session->setFlash(('<div class="alert alert-danger">'.__('Please use the default excel format,sheet name and sheet order').'</div>'));
									}
								}
	    							$this->set(compact('clientInformationSuccessCount','errorMessage','contactError','clientContactInformation'));
	   						
								}
	   								// traverses the number of sheets and sets html table with each sheet data in $excel_data
							}else{
	   							$this->Session->setFlash(('<div class="alert alert-danger">'.__('Please use the default excel format,sheet name and sheet order').'</div>'));
	   						}
	   				}else{
	   					$this->Session->setFlash(('<div class="alert alert-danger">'.__('Data import failed.Please save the excel with .xls').'</div>'));
	  				}
				}elseif(($_FILES['file']['type']) && ($_FILES['file']['type'] != 'application/vnd.ms-excel')){
						$this->Session->setFlash(('<div class="alert alert-danger">'.__('File you tried to import is invalid').'</div>'));
				}elseif(empty($_FILES['file']['type'])){
						$this->Session->setFlash(('<div class="alert alert-danger">'.__('File you tried to import has no file type.Please try uploading a new excel sheet').'</div>'));
				}
				$fileUploadSuccess = 1;
				$documentPath = WWW_ROOT.$fileOK['urls']['0'];
				unlink($documentPath);
				$this->set(compact('fileUploadSuccess'));
			}
				$cpn_subscription_plan_id = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
				$noofcustomers = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.id'=>$cpn_subscription_plan_id),'fields'=>array('CpnSubscriptionPlan.no_of_clients')));
				$presentCustCount = $this->AcrClient->find('count',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$this->subscriber,'AcrClient.status'=>'active')));
				if($noofcustomers['CpnSubscriptionPlan']['no_of_clients'] > $presentCustCount) {
					$showAddButton = TRUE;
				} else {
					$showAddButton = FALSE;
					$this->Session->setFlash(('<div class="alert alert-danger">'.__('Maximum limit is '.$noofcustomers['CpnSubscriptionPlan']['no_of_clients'].'.You can not import more customers.').'</div>'));
				}
				if($noofcustomers['CpnSubscriptionPlan']['no_of_clients'] == -1) {
					$showAddButton = TRUE;
				}
				$this->set(compact('showAddButton'));
			
		}
		public function sheetData($sheet,$sheetName) {
		 	$fieldsArray = $sheet['cells']['1'];
		 	$countRecords = count($sheet['cells']);
		 	foreach($fieldsArray as $key=>$val){
		 		for($i=2;$i<=$countRecords;$i++){
		 			if($sheetName == 'Clients Informations'){
		 				//arrayFor Customer
		 				if($val=='Client Sl No.'){
		 					$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Client Name'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Organization Name'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Billing Address Line 1'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Billing Address Line 2'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='City'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='State/Province'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Country'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Postal Code'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Currency Code'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Language'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Payment Terms'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Business Phone'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Business Fax'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Custom Field1'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Custom Field2'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Custom Field3'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Custom Field4'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Custom Field5'){
			 				$dataClient[$i][$val] = $sheet['cells'][$i][$key];
			 			}else{
			 				$dataClient[$i]['fieldMissing'] = '1';
			 			}
		 			}
		 			if($sheetName == 'Contact Informations'){
		 				//array for customer contact
		 				if($val=='Client Sl No'){
		 					$dataContact[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Contact Name'){
			 				$dataContact[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Contact Surname'){
			 				$dataContact[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Contact Email'){
			 				$dataContact[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Mobile'){
			 				$dataContact[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Home Phone'){
			 				$dataContact[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Work Phone'){
			 				$dataContact[$i][$val] = $sheet['cells'][$i][$key];
			 			}elseif($val=='Primary Contact'){
			 				$dataContact[$i][$val] = $sheet['cells'][$i][$key];
			 			}else{
			 				$dataContact[$i]['fieldMissing'] = '1';
			 			}
		 			}
		 		}
		 	}
		 	if($dataClient){
		 		return $dataClient;
		 	}elseif($dataContact){
		 		return $dataContact;
		 	}else{
		 		return false;
		 	}
		}
		
		public function orgcheck(){
		 
		  $this->autoRender = false;	
		  $this->loadModel('AcrClient');	
		  $subscriber_id=$this->subscriber;
		 
		  $orgExists= $this->AcrClient->find('first',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$subscriber_id,'AcrClient.organization_name'=>trim($this->params->query['organization_name']))));
	      if(!$orgExists){
		  	echo 1;
		  }else{
		  	echo 0;
		  }
		 
	     }	
		
		public function orgExist($id=null){
		 
		  $this->autoRender = false;	
		  $this->loadModel('AcrClient');	
		  $subscriber_id=$this->subscriber;
		  
		  $client_detail=$this->AcrClient->getClientDetail($id);
		  $orgExists= $this->AcrClient->find('first',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$subscriber_id,'AcrClient.organization_name'=>trim($this->params->query['organization_name']))));
	      if(($client_detail['AcrClient']['organization_name'] !=trim($this->params->query['organization_name'])) && $orgExists ){
		  	echo 0;
		  }else{
		  	echo 1;
		  }
		 
	     }
		
		public function EmailExist(){
		  $this->autoRender = false;	
		  $this->loadModel('AcrClientContact');	
		  $subscriber_id=$this->subscriber;
		  
	      $emailExists=$this->AcrClientContact->find('first',array('conditions'=>array('AcrClientContact.sbs_subscriber_id'=>$subscriber_id,'AcrClientContact.email'=>trim($this->params->query['email']))));
	      if(($emailExists)){
		  	echo 0;
		  }else{
		  	echo 1;
		  }
		 
	     }
		
		public function EmailExistCheck($id=null){
		  //Configure::write('debug',2);
		  $this->autoRender = false;	
		  $this->loadModel('AcrClientContact');	
		  $subscriber_id=$this->subscriber;
		  
		  $emailExists=$this->AcrClientContact->find('first',array('conditions'=>array('AcrClientContact.acr_client_id !='=>$id,'AcrClientContact.sbs_subscriber_id'=>$subscriber_id,'AcrClientContact.email'=>trim($this->params->query['email']))));
	      if(($emailExists)){
		  	echo 0;
		  }else{
		  	echo 1;
		  }
	    	 
	   }

       public function EmailExistTest(){
		  //Configure::write('debug',2);
		  $this->autoRender = false;	
		  $this->loadModel('AcrClientContact');	
		  $subscriber_id=$this->subscriber;
		  $emailExists=$this->AcrClientContact->find('first',array('conditions'=>array('AcrClientContact.sbs_subscriber_id'=>$subscriber_id,'AcrClientContact.email'=>trim($this->params->query['email']))));
	      if(($emailExists)){
		  	echo 0;
		  }else{
		  	echo 1;
		  }
	    	 
	   }
	} 
?>