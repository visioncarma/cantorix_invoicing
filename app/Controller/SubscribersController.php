<?php
App::uses('AppController', 'Controller');
/**
 * CpnCurrencies Controller
 *
 * @property SbsSubscribers $SbsSubscribers
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
	class SubscribersController extends AppController {
		public $components = array('Paginator');
		public $uses = array('SbsSubscriber');
		private $permission = NULL;
		
		public function beforeFilter() {
	        parent::beforeFilter();
	      	$this->layout = "cpn_layout";
	  		$this->permission = $this->Session->read('Auth.AllPermissions.Manage Subscription');
	  		$subscriptionActive = 'active';
			$menuActive = 'Manage Subscribers';
			$this->set(compact('subscriptionActive','menuActive'));
	    }
		
		public function index($plan=0,$company=0,$subscriberName = 0,$status=0,$page = NULL) {
			$this->permission = $this->Session->read('Auth.AllPermissions.Manage Subscribers');
			$permission = $this->permission;$conditions=NULL;
			if($this->permission['_read'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			$menuActive = 'Manage Subscribers';
			$subscriptionActive = 'active';
			$this->set(compact('permission','menuActive','subscriptionActive'));
			$this->loadModel('CpnSubscriptionPlan');$this->loadModel('CpnSetting');
			$plans = $this->CpnSubscriptionPlan->getSubscriptionPlanList();
			$settings = $this->CpnSetting->getAllSettings();
			$limit = $settings['CpnSetting']['lines_per_page'];
			$order = array('SbsSubscriber.id' =>'desc');
			if($plan) {
				$this->request->data['Filter']['plan'] = $plan;
			}
			if($company) {
				$this->request->data['Filter']['companyName'] = $company;
			}
			if($subscriberName) {
				$this->request->data['Filter']['subscriberName'] = $subscriberName;
			}
			if($status) {
				$this->request->data['Filter']['status'] = $status;
			}
			
			if(!empty($this->data)) {
				
				if(!empty($this->request->data['Filter']['plan'])) {
					$plan = trim($this->request->data['Filter']['plan']);
				}
				if(!empty($this->request->data['Filter']['companyName'])) {
					 $company = trim($this->request->data['Filter']['companyName']);
				}
				if(!empty($this->request->data['Filter']['subscriberName'])) {
					$subscriberName = trim($this->request->data['Filter']['subscriberName']);
				}
				if(!empty($this->request->data['Filter']['status'])) {
					$status = trim($this->request->data['Filter']['status']);
				}
				if(empty($plan) && empty($company) && empty($subscriberName) && empty($status)) {
					$this->Session->setFlash('<div class="alert alert-info">Please enter atleast one search term.</div>');
					$this->redirect(array('action'=>'index',$plan,$company,$subscriberName,'page:'.$page));
				} 
				
				$condition_array=null;$plan_array=null;$company_array=null;$name_array=null;$status_array=null;
				if($plan)$plan_array=array('SbsSubscriber.cpn_subscription_plan_id'=>$plan);
				if($company)$company_array=array('SbsSubscriberOrganizationDetail.organization_name LIKE'=>'%'.$company.'%');
				if($subscriberName)$name_array=array('SbsSubscriber.fullname LIKE'=>'%'.$subscriberName.'%');
				if($status)$status_array=array('SbsSubscriber.status LIKE'=>$status);
				$conditions=array($plan_array,$company_array,$name_array,$status_array);
			}
			$this->SbsSubscriber->recursive = 0;
			$this->SbsSubscriber->unbindModel(array('belongsTo'=>array('CpnSubscriptionPlan')));
			$this->Paginator->settings = array('conditions'=>$conditions,'limit'=>$limit,'order'=>$order,
				'fields'=>array('SbsSubscriber.id','SbsSubscriber.fullname','SbsSubscriber.sbs_subscriber_organization_detail_id','SbsSubscriber.cpn_subscription_plan_id',
					'SbsSubscriber.status','SbsSubscriberOrganizationDetail.organization_name','SbsSubscriber.is_archived'));
			$subscribersPaginate = $this->Paginator->paginate('SbsSubscriber');
			$this->loadModel('User');
			foreach($subscribersPaginate as $index => $subscriber) {
				$userDetailssss = $this->User->find('first',array('fields'=>array('User.email'),'conditions'=>array('sbs_subscriber_id'=>$subscriber['SbsSubscriber']['id'])));
				$subscribers[$index] = $subscriber;
				$subscribers[$index]['User']['email'] = $userDetailssss['User']['email'];
			}
			$this->set(compact('plans','company','plan','subscriberName','page','subscribers','status'));
			/*if(empty($subscribers)) {
				$this->Session->setFlash('<div class="alert alert-danger">Sorry! subscribers not found!</div>');
				return;
			}*/
		}

		public function view($id = NULL,$plan=0,$company=0,$subscriberName = 0,$page = 1) {
			
			if($this->permission['_read'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			$this->request->onlyAllow('post', 'view');
			$this->SbsSubscriber->recursive = 0;
			$this->SbsSubscriber->bindModel(array('hasOne' => array('User')));
			$subscriberDetail = $this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$id)));
			$countries = AppController::countryList();
			$this->loadModel('CpnSubscriberInvoiceDetail');
			$amount_due = $this->CpnSubscriberInvoiceDetail->find('first',array('conditions'=>array('CpnSubscriberInvoiceDetail.sbs_subscriber_id' =>$id),'fields'=>array('SUM(CpnSubscriberInvoiceDetail.outstanding_balance) as balance')));
			$this->set(compact('subscriberDetail','company','plan','subscriberName','page','countries','amount_due'));
		}
		
		public function changeSubscription() {
			$permission = $this->Session->read('Auth.AllPermissions.Change Subscription');
			if($permission['_delete'] != 1) {
	            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			if(!$this->request->is('ajax')) {
				$this->layout = "sbs_layout";
			}
			$menuActive = 'Change Subscription';
			$settingsActive = 'active';
			$this->set(compact('menuActive','settingsActive'));
			$id = $this->Session->read('Auth.User.SbsSubscriber.id');
			$this->loadModel('SbsDowngradeRequest');
			$this->SbsSubscriber->recursive = 0;
			$this->SbsSubscriber->unbindModel(array('belongsTo'=>array('SbsSubscriberOrganizationDetail')));
			$plan = $this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$id)));
			$this->loadModel('AcrClient'); $this->loadModel('User'); $this->loadModel('CpnSubscriptionPlan');$this->loadModel('CpnSubscriberInvoiceDetail');
			$customersCount = $this->AcrClient->find('count',array('conditions'=>array('AcrClient.sbs_subscriber_id'=>$id,'AcrClient.status'=>'Active')));
			$usersCount = $this->User->find('count',array('conditions'=>array('User.sbs_subscriber_id'=>$id,'User.active'=>'Y')));
			$standardPlan = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.type'=>'Standard')));
			$invoices = $this->CpnSubscriberInvoiceDetail->find('first',array(
				'conditions'=>array('CpnSubscriberInvoiceDetail.sbs_subscriber_id'=>$id),
				'order'=>array('CpnSubscriberInvoiceDetail.id DESC')
			));
            $downgradeRequest = $this->SbsDowngradeRequest->find('first', array('conditions' => array('SbsDowngradeRequest.status'=>'Active','SbsDowngradeRequest.sbs_subscriber_id'=>$id)));
            $this->set(compact('plan','customersCount','usersCount','standardPlan','invoices','downgradeRequest'));
		}
		
		public function cancelSubscription() {
			$permission = $this->Session->read('Auth.AllPermissions.Change Subscription');
			if($permission['_delete'] != 1) {
				$this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			if(!$this->request->is('ajax')) {
				$this->layout = "sbs_layout";
			}
			$id = $this -> Session -> read('Auth.User.SbsSubscriber.id');
            $subscriberDetails = $this -> SbsSubscriber -> findById($id);
            $this->loadModel('CpnSubscriptionPlan');
            
            $plan = $this -> CpnSubscriptionPlan -> findById($subscriberDetails['SbsSubscriber']['cpn_subscription_plan_id']);
			if($id && $plan['CpnSubscriptionPlan']['type'] != 'Free') {
				$success = $this->requestAction(array('controller' => 'users','action' => 'suspendSubscriberPaypalRecurringProfile',$id,0,'Cancel'));
			} elseif($plan['CpnSubscriptionPlan']['type'] == 'Free') {
			    $success = TRUE;
			}
			if($success) {
				$data = array('id' => $id, 'status' => 'Cancelled','updation'=>date('Y-m-d'));
				if($this->SbsSubscriber->save($data)) {
				    $this->loadModel('User');
				    $UserDetails = $this->User->find('first', array('conditions' => array('User.sbs_subscriber_id' => $id), 'order' => array('User.id'=>'Asc')));
                    if( isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
                        $protocol_final = 'https';
                    } else {
                        $protocol_final = 'http';
                    }
				    $body1 = 'Your subscription has been cancelled. Service will continue till end of the billing period after that you can reactivate your profile using existing logins with below link after login';
                    $body2 = $protocol_final.'://'.$_SERVER['HTTP_HOST'].$this->webroot;
                    $actionToPerform = 'Login';
                    $imgLogo = $protocol_final.'://'.$_SERVER['HTTP_HOST'].$this->webroot.'/img/logo.png';
                    $this->set(compact('body1','body2','actionToPerform','imgLogo'));
                    $this->Email->to        = $UserDetails['User']['email'];
                    $this->Email->subject   = 'CantoriX Cancellation Request';
                    $this->Email->replyTo   = 'admin@cantorix.com';
                    $this->Email->from      = 'admin@cantorix.com';
                    $this->Email->template  = 'common_template';
                    $this->Email->sendAs    = 'html';
                    $this->Email->send();
				}
				$msg = '<div class="alert alert-block alert-success">Subscriber has been deactivated!</div>';
			} else {
				$msg = '<div class="alert alert-danger">Subscriber couldn\'t be deactivated! Paypal couldn\'t cancel recurring account!</div>';
			}
			$this->Session->setFlash($msg);
			$this->redirect(array('controller'=>'subscribers','action'=>'changeSubscription'));
		}

		public function upgradeSubscription() {
			$permission = $this->Session->read('Auth.AllPermissions.Change Subscription');
			if($permission['_delete'] != 1) {
				$this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			if(!$this->request->is('ajax')) {
				$this->layout = "sbs_layout";
			}
			$menuActive = 'Change Subscription';
			$settingsActive = 'active';
			$this->set(compact('menuActive','settingsActive'));
			$id = $this->Session->read('Auth.User.SbsSubscriber.id');
			$this->SbsSubscriber->recursive = 0;
			$this->SbsSubscriber->unbindModel(array('belongsTo'=>array('SbsSubscriberOrganizationDetail')));
			$this->loadModel('CpnSubscriptionPlan');
			$plan = $this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$id)));
			switch ($plan['CpnSubscriptionPlan']['type']) {
				case 'Free':
						$conditions = array('NOT'=>array('CpnSubscriptionPlan.id'=>$plan['CpnSubscriptionPlan']['id'],'CpnSubscriptionPlan.type'=>'Free'));
					break;
				case 'Standard':
					$conditions = array('NOT'=>array('CpnSubscriptionPlan.id'=>$plan['CpnSubscriptionPlan']['id'],'CpnSubscriptionPlan.type'=>'Free'));
					break;
				case 'Unlimited':
					$conditions = array('NOT'=>array('CpnSubscriptionPlan.id'=>$plan['CpnSubscriptionPlan']['id'],'CpnSubscriptionPlan.type'=>array('Free','Standard')));	
				break;
				default:
					break;
			}
			$allPlans = $this->CpnSubscriptionPlan->find('all',array(
				'conditions'=> $conditions,
			));
			$this->set(compact('plan','allPlans'));
			
				
			
			
			
		}


		public function downgradeSubscription() {
			$permission = $this->Session->read('Auth.AllPermissions.Change Subscription');
			if($permission['_delete'] != 1) {
				$this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			if(!$this->request->is('ajax')) {
				$this->layout = "sbs_layout";
			}
			$menuActive = 'Change Subscription';
			$settingsActive = 'active';
			$this->set(compact('menuActive','settingsActive'));
			$id = $this->Session->read('Auth.User.SbsSubscriber.id');
			$this->SbsSubscriber->recursive = 0;
			$this->SbsSubscriber->unbindModel(array('belongsTo'=>array('SbsSubscriberOrganizationDetail')));
			$this->loadModel('CpnSubscriptionPlan');
			$plan = $this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$id)));
			$standard = $this->CpnSubscriptionPlan->find('first',array('conditions'=> array('type'=>'Standard')));
			$this->set(compact('standard'));
		}
		
		public function checkout($planId = NULL) {
			$this->loadModel('CpnSetting');
			$this->loadModel('CpnSubscriptionPlan');
			if($planId) {
			    $this->Session->write('Auth.User.NewPlanId',$planId);
				$cpnSetting    			    = $this->CpnSetting->getAllSettings();
				$cpn_subscription_plan_id 	= $planId;
				$subscriptionPlan  			= $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);
				$bill_start_day			    = $cpnSetting['CpnSetting']['bill_start_day'];
				$i=0;   
		    	if($bill_start_day <=9) {$bill_start_day = $i.$bill_start_day;} 
		    	else {$bill_start_day = $bill_start_day;}
				$currenttPPlanID = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
				$currenttPPlanName  		= $this->CpnSubscriptionPlan->getSubscriptionNameById($currenttPPlanID);
				$this->Session->write('amount_threshold',$amount_threshold);	
				$service_tax_percenage 		= $cpnSetting['CpnSetting']['service_tax_percenage'];		
				$subscriptionType		    = $subscriptionPlan['CpnSubscriptionPlan']['type'];
				$subscriptionCost		    = $subscriptionPlan['CpnSubscriptionPlan']['cost'];
				$subscriptionCost			= money_format('%!(.2n',$subscriptionCost);
				$serviceTax					= $subscriptionCost*($service_tax_percenage/100);
				$serviceTax					= money_format('%!(.2n',$serviceTax);
				$billAmount					= $subscriptionCost + $serviceTax;
				$billAmount					= money_format('%!(.2n',$billAmount);		
				
				$subscription_type		 = $subscriptionType;
				$subscription_cost		 = $subscriptionCost;
				$service_tax			 = $serviceTax;
				$bill_amount			 = $billAmount;
				
				$subscription_name 		 = $subscription_type.' Subscription';
				$initial_amount		= 0.00;
				$prorata_amount		= 0.00;
				$init_service_tax	= 0.00;
				$billdateAr   = date("Y-m", strtotime("+1 month"));
				$bd 		  = explode('-', $billdateAr); 
				$year  = $bd[0];
				$month = $bd[1];
				$day   = $bill_start_day;
				$billdate = $year.'-'.$month.'-'.$bill_start_day;
				$billBegins = gmdate("$billdate\TH:i:s\Z");
				$profilestartdate = $billBegins;
				$splitRow = 1;
				
				$this->set(compact('currenttPPlanName','countries','visitorDetails','subscriptionType','subscriptionCost','serviceTax','billAmount','initial_amount','profilestartdate','splitRow','prorata_amount','init_service_tax','amount_threshold','bill_start_day'));
			}
		}
		
		
		public function upgradeCheckout($planId = NULL) {
			$this->loadModel('CpnSetting');
			$this->loadModel('CpnSubscriptionPlan');
            if($planId) {
			    $currentPlanId = $this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id');
				$this->Session->write('cpn_subscription_plan_id',$planId);
				$cpnSetting    			    = $this->CpnSetting->getAllSettings();
                $cpn_subscription_plan_id 	= $planId;
				$subscriptionPlan  			= $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);
                $currentSubscriptionPlan    = $this->CpnSubscriptionPlan->getSubscriptionNameById($currentPlanId);
                $bill_start_day			    = $cpnSetting['CpnSetting']['bill_start_day'];
				$i=0;   
		    	if($bill_start_day <=9) {
		    	    $bill_start_day = $i.$bill_start_day;
                } else {
                    $bill_start_day = $bill_start_day;
                }
				$amount_threshold		    = $cpnSetting['CpnSetting']['amount_threshold'];
				$this->Session->write('amount_threshold',$amount_threshold);	
				$service_tax_percenage 		= $cpnSetting['CpnSetting']['service_tax_percenage'];		
				$subscriptionType		    = $subscriptionPlan['CpnSubscriptionPlan']['type'];
				$subscriptionCost		    = $subscriptionPlan['CpnSubscriptionPlan']['cost'];
				$subscriptionCost			= money_format('%!(.2n',$subscriptionCost);
				$serviceTax					= $subscriptionCost*($service_tax_percenage/100);
				$serviceTax					= money_format('%!(.2n',$serviceTax);
				$billAmount					= $subscriptionCost + $serviceTax;
				$billAmount					= money_format('%!(.2n',$billAmount);		
				$subscription_type		    = $subscriptionType;
				$subscription_cost		    = $subscriptionCost;
				$service_tax			    = $serviceTax;
				$bill_amount			    = $billAmount;
                $subscription_name 		    = $subscription_type.' Subscription';
				$initial_amount		        = 0.00;
				$prorata_amount		        = 0.00;
				$init_service_tax	        = 0.00;
                
				// First payment on the day of subscribe
        		$tdyDate 		            = date('d');
        		$lastDayOfMonth             = date('t');
        		$dayRemaining 	            = $lastDayOfMonth - $tdyDate;
        		$prorata_amount			    = (($subscription_cost/$lastDayOfMonth)*$dayRemaining) - (($currentSubscriptionPlan['CpnSubscriptionPlan']['cost']/$lastDayOfMonth)*$dayRemaining);
        		$prorata_amount			    = money_format('%!(.2n',$prorata_amount);
        		$init_service_tax		    = $prorata_amount*($service_tax_percenage/100);
        		$init_service_tax		    = money_format('%!(.2n',$init_service_tax);
        		$initial_amount			    = $prorata_amount + $init_service_tax;
        		$initial_amount			    = money_format('%!(.2n',$initial_amount);
        		$bill_start_day             = $cpnSetting['CpnSetting']['bill_start_day'];
        		if($initial_amount < $amount_threshold) {
        			$initial_amount		    = 0.00;
        			$prorata_amount		    = 0.00;
        			$init_service_tax	    = 0.00;
        			$billdateAr             = date("Y-m", strtotime("+1 month"));
        			$bd 		            = explode('-', $billdateAr); 
        			$year                   = $bd[0];
        			$month                  = $bd[1];
        			$day                    = $bill_start_day;
        			$billdate = $year.'-'.$month.'-'.$day;
        			$billBegins             = gmdate("$billdate\TH:i:s\Z");
        			$profilestartdate       = $billBegins;
        			$splitRow               = 1;			
        		} else {
        			$initial_amount         = $initial_amount;
        			$billdateAr             = date("Y-m", strtotime("+1 month"));
        			$bd 		            = explode('-', $billdateAr); 
        			$year                   = $bd[0];
        			$month                  = $bd[1];
        			$day                    = $bill_start_day;
        			$billdate               = $year.'-'.$month.'-'.$day;
        			$billBegins             = gmdate("$billdate\TH:i:s\Z");
        			$profilestartdate       = $billBegins;
        			$splitRow               = 1;
        		}		
				$this->set(compact('countries','visitorDetails','subscriptionType','subscriptionCost','serviceTax','billAmount','initial_amount','profilestartdate','splitRow','prorata_amount','init_service_tax','amount_threshold','bill_start_day'));
			}
		}
		
		
		public function user_profile(){
			
			$this->loadModel('User');
			$this->loadModel('SbsSubscriber');
			$this->SbsSubscriber->Behaviors->attach('Containable');
			
			$user_id = $this->Session->read('Auth.User.id');
			$user_detail= $this->User->getUserInfoById($user_id);
			if($user_detail['User']['user_type'] =='Subscriber'){
				$this->layout = "sbs_layout";
			}else{
				$this->layout = "cpn_layout";
			}
			$subscriber_id_details=$this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$user_detail['User']['sbs_subscriber_id']),'fields'=>array('SbsSubscriber.sbs_subscriber_organization_detail_id','SbsSubscriber.cpn_subscription_plan_id'),'contain'=>array('SbsSubscriberOrganizationDetail.organization_name','CpnSubscriptionPlan.type')));
            $this->set(compact('user_detail','subscriber_id_details'));
		}
		
		public function change_password(){
			
			$this->loadModel('User');
			$user_id = $this->Session->read('Auth.User.id');
			$userType = $this->Session->read('Auth.User.user_type');
			if($userType == 'Subscriber'){
				$this->layout = "sbs_layout";
			}else{
				$this->layout = "cpn_layout";
			}
			$user_detail= $this->User->getUserInfoById($user_id);
			
		    $current_password = AuthComponent::password($this->data['User']['current_password']);
	   	    $check_password = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id,'User.password'=>$current_password)));
	   	    if(!empty($check_password)){
	   	    	  if($this->data['User']['new_password'] == $this->data['User']['confirm_password']){
	   	    	  	         $this->request->data['User']['id']       = $user_id;
	   	    	  	         $this->request->data['User']['password'] = $this->data['User']['new_password'];
	   	        			 
	   	        			 if($this->User->save($this->request->data)){
	   	        			 	  $userDetails = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id)));
	   	                          $this->Session->write('Auth.User.password',$userDetails['User']['password']);
	   	                          $this->Session->setFlash(__('<div class="alert alert-block alert-success">Password successfully changed.</div>'));
	   	        			 	  $this->redirect(array('controller'=>'subscribers','action' =>'user_profile'));
	   	        			 	  
	   	        			 	  
	   	        			 }	
        		  }else{
        		  	   $this->Session->setFlash('<div class="alert alert-danger">Sorry! New password and confirm password did not match.</div>');
        			   $this->redirect(array('controller'=>'subscribers','action' =>'user_profile'));	
        			   
        		 }
	   	    	
	   	    }else{
	   	    	 $this->Session->setFlash('<div class="alert alert-danger">Sorry! Your current password is incorrect.</div>');
	   	    	 $this->redirect(array('controller'=>'subscribers','action' =>'user_profile'));
	   	    }
			
		}
		
		public function password_check(){
			
			$this->autoRender = false;	
			$this->loadModel('User');
			$user_id = $this->Session->read('Auth.User.id');
			$user_detail= $this->User->getUserInfoById($user_id);
			
		    $current_password = AuthComponent::password($this->params->query['current_password']);
	   	    $check_password = $this->User->find('first',array('conditions'=>array('User.id'=>$user_id,'User.password'=>$current_password)));
			if($check_password){
				echo 1;
			}else{
				echo 0;
			}
			
		}
		
		public function emailexist(){
		 
		  $this->autoRender = false;	
		  $this->loadModel('User');	
		  $user_id = $this->Session->read('Auth.User.id');
		  $user_detail= $this->User->getUserInfoById($user_id);
		 
		  $emailExist=$this->User->find('first',array('conditions'=>array('User.email'=>$this->params->query['email'])));	
		  if(($user_detail['User']['email'] !=$this->params->query['email']) && ($emailExist)){
		  	echo 1;
		  }else{
		  	echo 0;
		  }
		}	
		
	     
	     public function usernameexist(){
		 
		  $this->autoRender = false;	
		  $this->loadModel('User');	
		  $user_id = $this->Session->read('Auth.User.id');
		  $user_detail= $this->User->getUserInfoById($user_id);
		 
		  $usernameExist=$this->User->find('first',array('conditions'=>array('User.username'=>$this->params->query['username'])));	
		  if(($user_detail['User']['username'] !=$this->params->query['username']) && ($usernameExist)){
		  	echo 1;
		  }else{
		  	echo 0;
		  }
		 
	     }	  
	   
	     
		public function edit_profile(){
			
			$this->loadModel('User');
			$this->SbsSubscriber->Behaviors->attach('Containable');
			$user_id = $this->Session->read('Auth.User.id');
			$user_detail= $this->User->getUserInfoById($user_id);
			if($user_detail['User']['user_type'] == 'Subscriber'){
				$this->layout = "sbs_layout";
			}else{
				$this->layout = "cpn_layout";
			}
			
			if(!empty($this->data)){
			    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
				$userNameExist=$this->User->find('first',array('conditions'=>array('User.username'=>trim($this->data['User']['username']))));
				$emailExist=$this->User->find('first',array('conditions'=>array('User.email'=>trim($this->data['User']['email']))));
				
				if(($user_detail['User']['username']) != trim($this->data['User']['username']) && ($userNameExist)){
					$this->Session->setFlash('<div class="alert alert-danger">Sorry! username already exists.</div>');
				    $this->redirect(array('controller'=>'subscribers','action' =>'edit_profile'));
				
				}elseif(($user_detail['User']['email']) != trim($this->data['User']['email']) && ($emailExist)){
					 $this->Session->setFlash('<div class="alert alert-danger">Sorry! email already exists.</div>');
				     $this->redirect(array('controller'=>'subscribers','action' =>'edit_profile'));
			    
			    }elseif(!preg_match($regex, trim($this->data['User']['email']))) {
                     $this->Session->setFlash('<div class="alert alert-danger">Please enter the valid email address.</div>');
				     $this->redirect(array('controller'=>'subscribers','action' =>'edit_profile'));
                }else{
					
					 $this->request->data['User']['id']= $user_id;
				     if($_FILES['file']['name']){
				     	$checkImageFile  = exif_imagetype($_FILES['file']['tmp_name']);
					    if (($checkImageFile > 3) || ($checkImageFile < 1)) {
		                    $this->Session->setFlash(__('<div class="alert alert-danger">Please upload image. Acceptable file types: gif, jpg, png.</div>'));
			   	        	$this->redirect(array('controller'=>'subscribers','action' =>'user_profile'));
		                }
						
				     	if($user_detail['User']['user_type'] == 'Subscriber'){
				     		$uploadProfilePhoto = $this->uploadFiles('files/uploads/subscriber'.$user_detail['User']['sbs_subscriber_id'],$_FILES);
				     	}else{
				     		$uploadProfilePhoto = $this->uploadFiles('files/uploads/admin'.$user_detail['User']['id'],$_FILES);
				     	}
						
						if(!$uploadProfilePhoto['errors']) {  
							$this->request->data['User']['profile_picture_path'] = $uploadProfilePhoto['urls'][0];
						 }else{
						 	 $this->Session->setFlash(__('<div class="alert alert-danger">'.$uploadProfilePhoto['errors'][0].'</div>'));
			   	        	$this->redirect(array('controller'=>'subscribers','action' =>'user_profile'));
						 }
						}
						if($this->User->save($this->request->data)){
							 $this->Session->setFlash(__('<div class="alert alert-block alert-success">Profile has been updated.</div>'));
			   	        	 $this->redirect(array('controller'=>'subscribers','action' =>'user_profile'));
							 
						}	
				}
				
			}
			$subscriber_id_details=$this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$user_detail['User']['sbs_subscriber_id']),'fields'=>array('SbsSubscriber.sbs_subscriber_organization_detail_id','SbsSubscriber.cpn_subscription_plan_id'),'contain'=>array('SbsSubscriberOrganizationDetail.organization_name','CpnSubscriptionPlan.type')));
            $this->set(compact('subscriber_id_details','user_detail'));
		}
		
		public function getuserpic(){
			$this->loadModel('User');
			$user_id = $this->Session->read('Auth.User.id'); 
			$user_detail= $this->User->getUserInfoById($user_id);
			return $user_detail;
		}

		public function getSubscriberDetails() {
			$this->loadModel('User');$this->loadModel('SbsSubscriberSetting');
			$user_id = $this->Session->read('Auth.User.id'); $subscriber_id = $this->Session->read('Auth.User.SbsSubscriber.id');
			$final['user_detail'] = $this->User->find('first',array('fields'=>array('profile_picture_path','firstname'),'conditions'=>array('User.id'=>$user_id)));
			$final['logo'] = $this->SbsSubscriberSetting->find('first',array('fields'=>array('invoice_logo','text_logo'),'conditions'=>array('SbsSubscriberSetting.sbs_subscriber_id'=>$subscriber_id)));
			return $final;
		}

		
		public function updateOrganisationDetails() {
			$permission = $this->Session->read('Auth.AllPermissions.Organization Profile');
			if($permission['_update'] != 1) {
				$this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			if(!$this->request->is('ajax')) {
				$this->layout = "sbs_layout";
			}
			$menuActive = 'Organization Profile';
			$settingsActive = 'active';
			$final = $this->organisationProfile();
			$Auth = $this->Session->read('Auth');
			$this->loadModel('SbsSubscriberCpnCurrencyMapping');
			$this->loadModel('CpnLanguage');
			$this->loadModel('CpnFinancialYear');
			$subsCriberCurrency		= $this->SbsSubscriberCpnCurrencyMapping->getCurrencyList($Auth['User']['sbs_subscriber_id']);
			foreach($subsCriberCurrency as $subkey => $subscriberCurrencyMap) {
				if($subscriberCurrencyMap['CpnCurrency']['name']) {
					$currencyList[$subscriberCurrencyMap['CpnCurrency']['id']] = $subscriberCurrencyMap['CpnCurrency']['name'];
				}			
			}
			$currencyList			= $this->CpnCurrency->find('list',array('fields'=>array('id','code')));
			$countryList			= $this->countryList();
			$languageList			= $this->CpnLanguage->find('list',array('fields'=>array('id','language')));
			$financialYears			= $this->CpnFinancialYear->find('all');
			foreach ($financialYears as $value) {
				$financialYearList[$value['CpnFinancialYear']['id']] = $value['CpnFinancialYear']['from_month'].' - '.$value['CpnFinancialYear']['to_month'];
			}
			$this->loadModel('SlsQuotation');
			$this->loadModel('AcrClientInvoice');
			$this->loadModel('InvInventory');
			$this->loadModel('AcpExpense');
			$quote 		= $this->SlsQuotation->find('first',array('fields'=>array('id'),'conditions'=>array('sbs_subscriber_id'=>$Auth['User']['sbs_subscriber_id'])));
			$invoice 	= $this->AcrClientInvoice->find('first',array('fields'=>array('id'),'conditions'=>array('sbs_subscriber_id'=>$Auth['User']['sbs_subscriber_id'])));
			$inventory	= $this->InvInventory->find('first',array('fields'=>array('id'),'conditions'=>array('sbs_subscriber_id'=>$Auth['User']['sbs_subscriber_id'])));
			$expense	= $this->AcpExpense->find('first',array('fields'=>array('id'),'conditions'=>array('sbs_subscriber_id'=>$Auth['User']['sbs_subscriber_id'])));
			$this->set(compact('settingsActive','menuActive','final','languageList','countryList','currencyList','financialYearList','quote','invoice','inventory','expense'));
			if(!empty($this->data)) {
				$organisationDetail = NULL;
				$organisationDetail['SbsSubscriberOrganizationDetail']['id'] 						= $final['organisationDetail']['SbsSubscriberOrganizationDetail']['id'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['organization_name'] 		= $this->data['OrganisationProfile']['organisation_name'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'] 	= $this->data['OrganisationProfile']['billing_address_line1'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'] 	= $this->data['OrganisationProfile']['billing_address_line2'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['billing_city'] 				= $this->data['OrganisationProfile']['billing_city'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['billing_state'] 			= $this->data['OrganisationProfile']['billing_state'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'] 				= $this->data['OrganisationProfile']['billing_zip'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['billing_country_code'] 		= $this->data['OrganisationProfile']['billing_country_code'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['billing_country'] 			= $countryList[$this->data['OrganisationProfile']['billing_country_code']];
				$organisationDetail['SbsSubscriberOrganizationDetail']['shipping_address_line1'] 	= $this->data['OrganisationProfile']['shipping_address_line1'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['shipping_address_line2'] 	= $this->data['OrganisationProfile']['shipping_address_line2'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['shipping_city'] 			= $this->data['OrganisationProfile']['shipping_city'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['shipping_state'] 			= $this->data['OrganisationProfile']['shipping_state'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['shipping_zip'] 				= $this->data['OrganisationProfile']['shipping_zip'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['shipping_country_code'] 	= $this->data['OrganisationProfile']['shipping_country_code'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['shipping_country'] 			= $countryList[$this->data['OrganisationProfile']['shipping_country_code']];
				$organisationDetail['SbsSubscriberOrganizationDetail']['phone'] 					= $this->data['OrganisationProfile']['phone'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['fax'] 						= $this->data['OrganisationProfile']['fax'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['website'] 					= $this->data['OrganisationProfile']['website'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['time_zone'] 				= $this->data['OrganisationProfile']['time_zone'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['vat_no'] 					= $this->data['OrganisationProfile']['vat_no'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['reg_no'] 					= $this->data['OrganisationProfile']['reg_no'];
				
				if(!empty($this->data['OrganisationProfile']['cpn_currency_id'])) {
					$curencySetting = NULL;
					$curencySetting['SbsSubscriberSetting']['id'] 				= $final['Settings']['SbsSubscriberSetting']['id'];
					$curencySetting['SbsSubscriberSetting']['cpn_currency_id'] 	= $this->data['OrganisationProfile']['cpn_currency_id'];
					if($this->SbsSubscriberSetting->save($curencySetting)) {
					   $organisationDetail['SbsSubscriberOrganizationDetail']['cpn_currency_id']   = $this->data['OrganisationProfile']['cpn_currency_id'];
                       $this->loadModel('SbsSubscriberCpnCurrencyMapping');
                       $currencyMapping =  $this->SbsSubscriberCpnCurrencyMapping->find('first',array('conditions'=>array('SbsSubscriberCpnCurrencyMapping.cpn_currency_id'=>$this->data['OrganisationProfile']['cpn_currency_id'],'SbsSubscriberCpnCurrencyMapping.sbs_subscriber_id'=>$Auth['User']['sbs_subscriber_id'])));
                       if(empty($currencyMapping)) {
                           $createMapping['SbsSubscriberCpnCurrencyMapping']['sbs_subscriber_id'] = $Auth['User']['sbs_subscriber_id'];
                           $createMapping['SbsSubscriberCpnCurrencyMapping']['cpn_currency_id'] = $this->data['OrganisationProfile']['cpn_currency_id'];
                           $this->SbsSubscriberCpnCurrencyMapping->create();
                           $this->SbsSubscriberCpnCurrencyMapping->save($createMapping);
                       }
					} 
				}
				$organisationDetail['SbsSubscriberOrganizationDetail']['cpn_language_id'] 			= $this->data['OrganisationProfile']['cpn_language_id'];
				$organisationDetail['SbsSubscriberOrganizationDetail']['cpn_financial_year_id'] 	= $this->data['OrganisationProfile']['cpn_financial_id'];
				if($this->SbsSubscriberOrganizationDetail->save($organisationDetail)) {
					$userDetail['User']['id']			= $final['adminUserDetails']['User']['id'];
					$userDetail['User']['firstname']	= $this->data['OrganisationProfile']['first_name'];
					$userDetail['User']['lastname']		= $this->data['OrganisationProfile']['last_name'];
					$userDetail['User']['home_phone']	= $this->data['OrganisationProfile']['home_phone'];
					$userDetail['User']['mobile']		= $this->data['OrganisationProfile']['primary_mobile'];
					$userDetail['User']['email']		= $this->data['OrganisationProfile']['email'];
					$userDetail['User']['username']		= $this->data['OrganisationProfile']['username'];
					if($this->User->save($userDetail)) {
						$this->Session->setFlash('<div class="alert alert-block alert-success">Subscriber details updated.</div>');
					} else {
						$this->Session->setFlash('<div class="alert alert-danger">Error occurred. Couldn\'t update!</div>');
						return;
					}
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">Error occurred. Couldn\'t update!</div>');
					return;
				}
				$this->redirect(array('action'=>'organisationProfile'));
			}
		}


		public function organisationProfile() {
			$permission = $this->Session->read('Auth.AllPermissions.Organization Profile');
			if($permission['_read'] != 1) {
				$this->redirect(array('controller'=>'users','action'=>'noaccess'));
			}
			if(!$this->request->is('ajax')) {
				$this->layout = "sbs_layout";
			}
			$menuActive = 'Organization Profile';
			$settingsActive = 'active';
			$this->loadModel('SbsSubscriberOrganizationDetail');
			$this->loadModel('User');
			$this->loadModel('SbsSubscriberSetting');
			$this->loadModel('CpnCurrency');
			$Auth = $this->Session->read('Auth');
			$this->SbsSubscriberOrganizationDetail->recursive = 0;
			$organisationDetail = $this->SbsSubscriberOrganizationDetail->getOrganizationDetailById($Auth['User']['SbsSubscriber']['sbs_subscriber_organization_detail_id']);
			$adminUser = $this->Acl->Aro->find('first',array('fields'=>array('foreign_key'),'conditions'=>array('sbs_subscriber_id'=>$Auth['User']['sbs_subscriber_id'],'foreign_key IS NOT NULL'),'order'=>array('id'=>'Asc')));
			$adminUserDetails = $this->User->findById($adminUser['Aro']['foreign_key']);
			$time_zones = $this->getAllTimezones();
			$subsSetting = $this->SbsSubscriberSetting->defaultSettings($Auth['User']['sbs_subscriber_id']);
			$currency	 =	$this->CpnCurrency->findById($subsSetting['SbsSubscriberSetting']['cpn_currency_id']);
			$final['organisationDetail'] 	= $organisationDetail;
			$final['adminUserDetails'] 		= $adminUserDetails;
			$final['time_zones'] 			= $time_zones;
			$final['currency']				= $currency;
			$final['Settings']				= $subsSetting;
			$this->set(compact('settingsActive','menuActive','organisationDetail','adminUserDetails','time_zones','final','permission','currency'));
			return $final;
		}


		public function checkAdminEmail($id = NULL) {
			
			$this->autoRender = FALSE;
			$this->loadModel('User');
			$userExist = $this->User->find('first',array('fields'=>array('id'),'conditions'=>array('User.email'=>trim($this->data['OrganisationProfile']['email']),'NOT'=>array('User.id'=>$id))));
			if(empty($userExist)) {
				return 'false';
			} else {
				return 'true';
			}
		}
		
		public function checkAdminUsername($id = NULL) {
			
			$this->autoRender = FALSE;
			$this->loadModel('User');
			$userExist = $this->User->find('first',array('fields'=>array('id'),'conditions'=>array('User.username'=>trim($this->data['OrganisationProfile']['username']),'NOT'=>array('User.id'=>$id))));
			if(empty($userExist)) {
				return 'false';
			} else {
				return 'true';
			}
		}

	}
?>