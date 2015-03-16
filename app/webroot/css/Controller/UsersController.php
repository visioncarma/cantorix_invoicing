<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'PaypalRecurring');
App::import('Vendor', 'IpnListener');
App::import('Vendor', 'PaypalRecurringPaymentProfile');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {
	
	public $components = array('Captcha','Paginator');
	public $permission;
	
	public function beforeFilter() {
		$this->Auth->allow('subscriptionSignup','organizationDetails','subscriberDetails','trialRegistration','paymentDetails','freeCheckout','paidCheckout','reviewOrder','makePayment','signupSuccess','signupFailure','generate_password','getVisitorDetails','isEmailExist','isUsernameExist','captcha','login','upgrade','logout','forgotPassword','confirmResetPassword','get_time_difference','password_cryptData','createAdminUser','addMenu','manageUsers','validateUserEmail','validateUsername','deleteUser','index','activateSubscriber','cancelSubscriber','paymentDetailRenewal','makePaymentRenewal','paidCheckoutRenewal','reviewOrderRenewal','account_activation','activateAccount');
		$this->layout = "signup_login";
		parent::beforeFilter();
		$this->permission = $this->Session->read('Auth.AllPermissions.Manage Users');
	}
	
	
	// Home page for new subscriber signup 
	function subscriptionSignup () {
		
		$this->Session->destroy();			 
		$this->loadModel('CpnSubscriptionPlan');
				
		$subscriptionFree  	    = $this->CpnSubscriptionPlan->getSubscriptionByType('Free');
		$subscriptionStandard   = $this->CpnSubscriptionPlan->getSubscriptionByType('Standard');
		$subscriptionUnlimited  = $this->CpnSubscriptionPlan->getSubscriptionByType('Unlimited');		
				
		$this->set(compact('subscriptionFree','subscriptionStandard','subscriptionUnlimited'));		
	}	
	
	// signup step 1	
	public function organizationDetails ($cpn_subscription_plan_id) {
		
		// store subscription in session	
		if(isset($cpn_subscription_plan_id)){			
			$this->Session->write('cpn_subscription_plan_id',$cpn_subscription_plan_id);
		}
		$time_zones = $this->getAllTimezones();	
		$this->set(compact('time_zones'));
	}
	
	// signup step 2
	function subscriberDetails () {
		
		$this->loadModel('CpnSubscriptionPlan');
		// store organization details in session
		if ($this->request->is('post')) {
			$organization_name = trim($this->data['organizationForm']['organization_name']);
			$time_zone  	   = $this->data['organizationForm']['time_zone'];
			$email			   = trim($this->data['organizationForm']['email_address']);
	
			if(isset($organization_name))	
				$this->Session->write('organization_name',$organization_name);
			if(isset($time_zone))	
				$this->Session->write('time_zone',$time_zone);
			if(isset($email))	
				$this->Session->write('email',$email);	
		}	
		
		$cpn_subscription_plan_id 	= $this->Session->read('cpn_subscription_plan_id');
		$subscriptionPlan  			= $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);			
	    $subscriptionType		    = $subscriptionPlan['CpnSubscriptionPlan']['type'];
		$this->Session->write('subscriptionType',$subscriptionType);
		$this->set(compact('subscriptionType'));	
	}	
	
	// signup step 3
	
	// if Free Plan
	public function trialRegistration () {
			
		$this->loadModel('CpnSubscriptionPlan');	
		// store subscriber details in session
		if ($this->request->is('post')) {
			$name 		= trim($this->data['subscriberForm']['name']);
			$surname  	= trim($this->data['subscriberForm']['surname']);
			$username	= trim($this->data['subscriberForm']['username']); 
			if(!isset($username)) {
				$username = $this->Session->read('email');
			}  
			$captcha	= $this->data['subscriberForm']['captcha'];
			$componentCode = $this->Captcha->getVerCode();
			
			if(isset($name))	
				$this->Session->write('name',$name);
			if(isset($surname))	
				$this->Session->write('surname',$surname);
			if(isset($username))	
				$this->Session->write('username',$username);
			
			if( $captcha != $componentCode){
				$securityError = '<div class="errorflashmessage">Security Code does not match</div>';
				$this->Session->setFlash($securityError);
				$this->redirect(array('controller'=>'users','action' => 'subscriberDetails'));
			}			
		}
		$visitorDetails 	= $this->getVisitorDetails();		   
		$countries 			= $this->countryList();
		$cpn_subscription_plan_id 	= $this->Session->read('cpn_subscription_plan_id');
		$subscriptionPlan  			= $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);
		$subscriptionType		    = $subscriptionPlan['CpnSubscriptionPlan']['type'];
		$subscriptionCost		    = $subscriptionPlan['CpnSubscriptionPlan']['cost'];
		$serviceTax					= 0;
		$billAmount					= $subscriptionCost + $serviceTax;
		$this->set(compact('countries','visitorDetails','subscriptionType','subscriptionCost','serviceTax','billAmount'));
	}	
	
	// if Paid Plan
	public function paymentDetails () {
		
		$this->loadModel('CpnSubscriptionPlan');
		$this->loadModel('CpnSetting');
			
		// store subscriber details in session
		if ($this->request->is('post')) {
			$name 		= trim($this->data['subscriberForm']['name']);
			$surname  	= trim($this->data['subscriberForm']['surname']);
			$username	= trim($this->data['subscriberForm']['username']); 
			if(!isset($username)) {
				$username = $this->Session->read('email');
			}  
			$captcha	= $this->data['subscriberForm']['captcha'];  
			$componentCode = $this->Captcha->getVerCode();
			if(isset($name))	
				$this->Session->write('name',$name);
			if(isset($surname))	
				$this->Session->write('surname',$surname);
			if(isset($username))	
				$this->Session->write('username',$username);
			
			if( $captcha != $componentCode){
				$securityError = '<div class="errorflashmessage">Security Code does not match</div>';
				$this->Session->setFlash($securityError);
				$this->redirect(array('controller'=>'users','action' => 'subscriberDetails'));
			}				
		}		
		
		$cpnSetting    			    = $this->CpnSetting->getAllSettings();
		$cpn_subscription_plan_id 	= $this->Session->read('cpn_subscription_plan_id');
		$subscriptionPlan  			= $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);			
		
		$bill_start_day			   = $cpnSetting['CpnSetting']['bill_start_day'];
		
		$i=0;   
    	if($bill_start_day <=9) {$bill_start_day = $i.$bill_start_day;} 
    	else {$bill_start_day = $bill_start_day;}
		$amount_threshold		= $cpnSetting['CpnSetting']['amount_threshold'];
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
		
		// First payment on the day of subscribe
		$tdyDate 		= date('d');
		$lastDayOfMonth = date('t');
		$dayRemaining 	= $lastDayOfMonth - $tdyDate;
		
		$prorata_amount			 = ($subscription_cost/$lastDayOfMonth)*$dayRemaining;
		$prorata_amount			 = money_format('%!(.2n',$prorata_amount);
		$init_service_tax		 = $prorata_amount*($service_tax_percenage/100);
		$init_service_tax		 = money_format('%!(.2n',$init_service_tax);
		$initial_amount			 = $prorata_amount + $init_service_tax;
		$initial_amount			 = money_format('%!(.2n',$initial_amount);
				
		if($initial_amount < $amount_threshold) {
			
			$initial_amount		= 0.00;
			$prorata_amount		= 0.00;
			$init_service_tax	= 0.00;			
			$billdateAr   = date("Y-m", strtotime("+1 month"));
			$bd 		  = explode('-', $billdateAr); 
			$year  = $bd[0];
			$month = $bd[1];
			$day   = $bill_start_day;
			$billdate = $year.'-'.$month.'-'.$day;
			$billBegins = gmdate("$billdate\TH:i:s\Z");
			$profilestartdate = $billBegins;
			$splitRow = 1;			
		} else {
			$initial_amount = $initial_amount;
			$billdateAr   = date("Y-m", strtotime("+1 month"));
			$bd 		  = explode('-', $billdateAr); 
			$year  = $bd[0];
			$month = $bd[1];
			$day   = $bill_start_day;
			$billdate = $year.'-'.$month.'-'.$day;			
			$billBegins = gmdate("$billdate\TH:i:s\Z");
			$profilestartdate = $billBegins;
			$splitRow = 1;
		}		
		
		$visitorDetails 	= $this->getVisitorDetails();
		$countries = $this->countryList();				
		
		$this->set(compact('countries','visitorDetails','subscriptionType','subscriptionCost','serviceTax','billAmount','initial_amount','profilestartdate','splitRow','prorata_amount','init_service_tax','amount_threshold'));	
			
	}	
	
	//signup step 4
	function freeCheckout () {
	   
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriber');
		$this->loadModel('SbsSubscriberSetting');		
				
	    $this->autoRender = false; 
		if ($this->request->is('post')) {
			
			$billing_address_line1   = trim($this->data['paymentForm']['billing_address_line1']);
			$billing_state           = trim($this->data['paymentForm']['billing_state']);
			$billing_city            = trim($this->data['paymentForm']['billing_city']);
			$billing_country_code    = $this->data['paymentForm']['billing_country'];
			$billing_country         = $this->data['paymentForm']['country_name'];
			$billing_zip             = $this->data['paymentForm']['billing_zip'];			
			$currencyName         	 = $this->data['paymentForm']['currency_code'];
			$currencySymbol          = $this->data['paymentForm']['currency_symbol_UTF8'];
									
			$detailArray 			 = array('billing_address_line1'=>$billing_address_line1,
											 'billing_city'=>$billing_city, 
											 'billing_state'=>$billing_state,
											 'billing_country'=>$billing_country, 
											 'billing_country_code'=>$billing_country_code,
											 'billing_zip'=>$billing_zip, 
											 'currencyName'=>$currencyName,
											 'currencySymbol'=>$currencySymbol);
											 
			$addOrganizationDetail   = $this->SbsSubscriberOrganizationDetail->addOrganizationDetails($detailArray);
			if($addOrganizationDetail){ 
					$sbs_subscriber_organization_detail_id = $addOrganizationDetail;
					$addSubscriberDetail = $this->SbsSubscriber->addSubscriberDetails($sbs_subscriber_organization_detail_id, 'free');
					if($addSubscriberDetail) {
						$sbs_subscriber_id =  $addSubscriberDetail;					
						$addSbsSettings    = $this->SbsSubscriberSetting->addSubscriberSettings ($sbs_subscriber_id);
						if ($addSbsSettings) {
							$password 		   = $this->generate_password();
							$addUser		   = $this->User->addSubscriber ($sbs_subscriber_id, $password);
							if($addUser){
								$this->redirect(array('controller'=>'users','action' => 'signupSuccess'));
							} else {
								// signupFailure
								$this->redirect(array('controller'=>'users','action' => 'signupFailure'));
							}
						} else {
							// signupFailure
							$this->redirect(array('controller'=>'users','action' => 'signupFailure'));
						}					
					} else { 
						// signupFailure
						$this->redirect(array('controller'=>'users','action' => 'signupFailure'));
					}					 
			} else { 
				// signupFailure
				$this->redirect(array('controller'=>'users','action' => 'signupFailure'));
			}
		 }
	}
	
	function paidCheckout () {		
		
		$this->autoRender = false; 
		$this->loadModel('CpnSetting');
		
		/* PAYPAL API  DETAILS */
			$API_UserName 	= $this->API_UserName;
			$API_Password 	= $this->API_Password;
			$API_Signature  = $this->API_Signature;
			$API_Endpoint 	= $this->API_Endpoint;
		    $version		= $this->version;
		
		/*SET SUCCESS AND FAIL URL*/
		    $host 	   =  $_SERVER['SERVER_NAME'];		    
			$root      =  $this->webroot; 
			$returnURL = "http://$host$root".'users/reviewOrder';
			$cancelURL = "http://$host$root".'users/signupFailure';
		
		/* SET VALUES */	
		 $environment 					= $this->environment;		
		 $L_BILLINGTYPE0 				= 'RecurringPayments';		
		
		if ($this->request->is('post')) {
			
			$cpnSetting    		= $this->CpnSetting->getAllSettings();
			$currency_code 		= $cpnSetting['CpnSetting']['currency_code']; // currency which is used for subscriber Recurring Billing 
			
			$service_tax     		 = trim($this->data['paymentForm']['serviceTax']);
			$subscription_type       = trim($this->data['paymentForm']['subscriptionType']);
			$bill_amount	         = trim($this->data['paymentForm']['billAmount']);			
			$subscription_cost       = trim($this->data['paymentForm']['subscriptionCost']);
			$initial_amount	         = trim($this->data['paymentForm']['initial_amount']);			
			$profilestartdate        = trim($this->data['paymentForm']['profilestartdate']);
			$splitRow        		 = trim($this->data['paymentForm']['splitRow']);
			$prorata_amount        	 = trim($this->data['paymentForm']['prorata_amount']);
			$init_service_tax        = trim($this->data['paymentForm']['init_service_tax']);
			$subscription_name 		 = $subscription_type.' Subscription';
			
			$currencyName       	 = $this->data['paymentForm']['currency_code'];
			$currencySymbol     	 = $this->data['paymentForm']['currency_symbol_UTF8'];
			
			// store in session for later use
			$this->Session->write('currencyName',$currencyName);			
			$this->Session->write('currencySymbol',$currencySymbol);
			$this->Session->write('subscriptionType',$subscription_type);
			$this->Session->write('cpn_currency',$currency_code);
			$this->Session->write('bill_amount',$bill_amount);
			$this->Session->write('initial_amount',$initial_amount);
			$this->Session->write('profilestartdate',$profilestartdate);
			$this->Session->write('splitRow',$splitRow);
			$this->Session->write('prorata_amount',$prorata_amount);
			$this->Session->write('init_service_tax',$init_service_tax);			
			$amount_threshold   = $this->Session->read('amount_threshold');
			$recurrinBillDate = date("d M Y", strtotime($profilestartdate));						
			$L_BILLINGAGREEMENTDESCRIPTION0 = "$subscription_name : Monthly Recurring Charge (Incl. Tax) = $bill_amount $currency_code with effect from $recurrinBillDate.";
			
			$obj	=	new PaypalRecurring;		
			
			/* PAYPAL API  DETAILS */
			$obj->API_UserName 	= urlencode($API_UserName);
			$obj->API_Password 	= urlencode($API_Password);
			$obj->API_Signature = urlencode($API_Signature);
			$obj->API_Endpoint 	= $API_Endpoint;
			$obj->version 		= urlencode($version);
			
			/*SET SUCCESS AND FAIL URL*/
			$obj->returnURL = urlencode($returnURL);
			$obj->cancelURL = urlencode($cancelURL);
			
			$obj->environment 						=  $environment;	
			$obj->paymentType 						=  urlencode($paymentType);	
			$obj->L_BILLINGTYPE0 					=  $L_BILLINGTYPE0;		
			$obj->L_BILLINGAGREEMENTDESCRIPTION0	=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0);	
			$obj->paymentAmount						=  urlencode($subscription_cost); //Amt
			$obj->taxamount							=  urlencode($service_tax);	
			$obj->currencyID						=  urlencode($currency_code);	
			$obj->L_PAYMENTREQUEST_0_NAME0			=  urlencode($subscription_name);
			$obj->L_PAYMENTREQUEST_0_AMT0			=  urlencode($subscription_cost);
			$obj->L_PAYMENTREQUEST_0_DESC0			=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0);	
			$obj->PAYMENTREQUEST_0_ITEMAMT			=  urlencode($subscription_cost);
			$obj->PAYMENTREQUEST_0_TAXAMT			=  urlencode($service_tax);
			$obj->PAYMENTREQUEST_0_AMT				=  urlencode($bill_amount); // grand total
			$obj->PAYMENTREQUEST_0_CURRENCYCODE		=  urlencode($currency_code);
							
			$task = "setExpressCheckout"; //set initial task as Express Checkout			
			$httpParsedResponseAr = $obj->setExpressCheckout();
			$methodError = 'SetExpressCheckout';			
			$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
			$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
			$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
			$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
			
			// store in session for later use
			$this->Session->write('errorCode',$errorCode);			
			$this->Session->write('errorSmallMsg',$errorSmallMsg);
			$this->Session->write('errorLongMsg',$errorLongMsg);	
			$this->Session->write('serverCode',$serverCode);			
			$this->redirect(array('controller'=>'users','action' => 'signupFailure/'.$methodError));
			
		}
	}
			
	
	public function reviewOrder () {
		
		/* PAYPAL API  DETAILS */
			$API_UserName 	= $this->API_UserName;
			$API_Password 	= $this->API_Password;
			$API_Signature  = $this->API_Signature;
			$API_Endpoint 	= $this->API_Endpoint;
		    $version		= $this->version;	
		
		/* SET VALUES */
		 $environment 					= $this->environment;		
		 $L_BILLINGTYPE0 				= 'RecurringPayments';
		
		$obj	=	new PaypalRecurring;		
		
		/* PAYPAL API  DETAILS */
		$obj->API_UserName 	= urlencode($API_UserName);
		$obj->API_Password 	= urlencode($API_Password);
		$obj->API_Signature = urlencode($API_Signature);
		$obj->API_Endpoint 	= $API_Endpoint;
		$obj->version 		= urlencode($version);				
		$obj->environment 	=  $environment;		
			
		$task = "getExpressCheckout"; //set initial task as Express Checkout			
		$httpParsedResponseAr = $obj->getExpressCheckout();
		
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {			
			$this->set(compact('httpParsedResponseAr'));
		} else  {			
			$methodError = 'GetExpressCheckoutDetails';			
			$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
			$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
			$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
			$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
			
			// store in session for later use
			$this->Session->write('errorCode',$errorCode);			
			$this->Session->write('errorSmallMsg',$errorSmallMsg);
			$this->Session->write('errorLongMsg',$errorLongMsg);	
			$this->Session->write('serverCode',$serverCode);			
			$this->redirect(array('controller'=>'users','action' => 'signupFailure/'.$methodError));
			
		}		
	}



	
	
	function makePayment () {		
		
		/* PAYPAL API  DETAILS */
			$API_UserName 	= $this->API_UserName;
			$API_Password 	= $this->API_Password;
			$API_Signature  = $this->API_Signature;
			$API_Endpoint 	= $this->API_Endpoint;
		    $version		= $this->version;
				
		/* SET VALUES */
		 $environment 					= $this->environment;		
		 $L_BILLINGTYPE0 				= 'RecurringPayments';
		
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriber');
		$this->loadModel('SbsSubscriberSetting');	
		$this->loadModel('CpnSetting');
						
		if ($this->request->is('post')) {
			
			$cpnSetting    			= $this->CpnSetting->getAllSettings();
			
			$currency_code 			= $cpnSetting['CpnSetting']['currency_code'];
			$billing_period			= $cpnSetting['CpnSetting']['billing_period'];
			$billing_frequency		= $cpnSetting['CpnSetting']['billing_frequency'];
			$billing_cycles			= $cpnSetting['CpnSetting']['billing_cycles'];
			$bill_start_day			= $cpnSetting['CpnSetting']['bill_start_day'];
			
			$subscription_type		 = trim($this->data['orderForm']['subscriptionType']);
			$subscription_cost		 = trim($this->data['orderForm']['subscriptionCost']);
			$service_tax			 = trim($this->data['orderForm']['serviceTax']);
			$bill_amount			 = trim($this->data['orderForm']['bill_amount']);
			$profilestartdate		 = trim($this->data['orderForm']['profilestartdate']);
			$initial_amount			 = trim($this->data['orderForm']['initial_amount']);
			
			$subscription_name 		 = $subscription_type.' Subscription';			
			
			// billing shipping same			
			$billing_address_line1   = trim($this->data['orderForm']['street1']);
			$billing_city            = trim($this->data['orderForm']['city_name']);
			$billing_state           = trim($this->data['orderForm']['state_province']);
			$billing_country         = trim($this->data['orderForm']['country_name']);
			$billing_country_code	 = trim($this->data['orderForm']['country_code']);
			$billing_zip             = trim($this->data['orderForm']['postal_code']);
						
			$currencyName       = $this->Session->read('currencyName');
			$currencySymbol     = $this->Session->read('currencySymbol');	
						
			$subscriber_email	= $this->Session->read('email');			
			$token 				= $this->data['orderForm']['token'];
			$amount_threshold   = $this->Session->read('amount_threshold');
			// create recurring Profile 		
			$recurrinBillDate = date("d M Y", strtotime($profilestartdate));
			$L_BILLINGAGREEMENTDESCRIPTION0 = "$subscription_name : Monthly Recurring Charge (Incl. Tax) = $bill_amount $currency_code with effect from $recurrinBillDate.";
			$obj	=	new PaypalRecurring;
			
			/* PAYPAL API  DETAILS */
			$obj->API_UserName 	= urlencode($API_UserName);
			$obj->API_Password 	= urlencode($API_Password);
			$obj->API_Signature = urlencode($API_Signature);
			$obj->API_Endpoint 	= $API_Endpoint;
			$obj->version 		= urlencode($version);			
			
			// Set request-specific fields.
			$obj->startDate 	= urlencode($profilestartdate);
			$obj->billingPeriod = urlencode($billing_period);				
			$obj->billingFreq 	= urlencode($billing_frequency);						
			$obj->paymentAmount = urlencode($subscription_cost);
			$obj->currencyID 	= urlencode($currency_code);			
			$obj->taxamount		= urlencode($service_tax);	
		    $obj->maxfailedpayments 	   = 3;  
		    $obj->autobillamount    	   = 'AddToNextBilling';	  
			$obj->initamount			   = $initial_amount;
			$obj->failedinitamountaction   = 'CancelOnFailure';   //FAILEDINITAMTACTION
			$obj->environment 						=  $environment;	
			$obj->paymentType 						=  urlencode($paymentType);	
			$obj->L_BILLINGTYPE0 					=  $L_BILLINGTYPE0;		
			$obj->L_BILLINGAGREEMENTDESCRIPTION0	=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0); 
			// creating recurring profile
			$httpParsedResponseAr = $obj->createRecurringPaymentsProfile($token);
			
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {		
			
				$profile_id  	=  urldecode($httpParsedResponseAr["PROFILEID"]);
				$profile_status =  urldecode($httpParsedResponseAr["PROFILESTATUS"]);
				
				switch ($profile_status) {
					case 'ActiveProfile':
						$profile_status = 'Active';	
						break;
					case 'PendingProfile':
						$profile_status = 'Pending';
						break;
					case 'CancelledProfile':
						$profile_status = 'Cancelled';
						break;	
					case 'SuspendedProfile':
						$profile_status = 'Suspended';
						break;	
					case 'ExpiredProfile':
						$profile_status = 'Expired';
						break;												
				}
				
				// store in session for later use
				$this->Session->write('profile_id',$profile_id);			
				$this->Session->write('profile_status',$profile_status);
				
				$detailArray 			 = array('billing_address_line1'=>$billing_address_line1,
												 'billing_city'=>$billing_city,
												 'billing_state'=>$billing_state,
												 'billing_country'=>$billing_country,
												 'billing_country_code'=>$billing_country_code, 
												 'billing_zip'=>$billing_zip, 
												 'currencyName'=>$currencyName,
												 'currencySymbol'=>$currencySymbol);
										 
				
				$addOrganizationDetail   = $this->SbsSubscriberOrganizationDetail->addOrganizationDetails($detailArray);
				if($addOrganizationDetail){ 
						$sbs_subscriber_organization_detail_id = $addOrganizationDetail;
						$addSubscriberDetail = $this->SbsSubscriber->addSubscriberDetails($sbs_subscriber_organization_detail_id);
						if($addSubscriberDetail) {
							$sbs_subscriber_id =  $addSubscriberDetail;					
							$addSbsSettings    = $this->SbsSubscriberSetting->addSubscriberSettings ($sbs_subscriber_id);
							if ($addSbsSettings) {
								$password 		   = $this->generate_password();
								$addUser		   = $this->User->addSubscriber ($sbs_subscriber_id, $password);
								if($addUser){
									// signupSuccess									
									$this->redirect(array('controller'=>'users','action' => 'signupSuccess'));
								} else {
									// signupFailure
									$this->redirect(array('controller'=>'users','action' => 'signupFailure'));
								}
							} else {
								// signupFailure
								$this->redirect(array('controller'=>'users','action' => 'signupFailure'));
							}					
						} else { 
							// signupFailure
							$this->redirect(array('controller'=>'users','action' => 'signupFailure'));
						}					 
				} else { 
					  // signupFailure
					  $this->redirect(array('controller'=>'users','action' => 'signupFailure'));
				   }
			}
			else  {
				    // signupFailure
				    $methodError 	= 'createRecurringPaymentsProfile';
					$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
					$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
					$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
					$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
					
					// store in session for later use
					$this->Session->write('errorCode',$errorCode);			
					$this->Session->write('errorSmallMsg',$errorSmallMsg);
					$this->Session->write('errorLongMsg',$errorLongMsg);	
					$this->Session->write('serverCode',$serverCode);			
					$this->redirect(array('controller'=>'users','action' => 'signupFailure/'.$methodError));
			}
		 }
	}	

	//signup step 5
	public function signupSuccess () {
		
		//$profile_id     = $this->Session->read('profile_id');	
		$this->account_activation();				
		$profile_status   = $this->Session->read('profile_status');
		$bill_amount      = $this->Session->read('bill_amount');
		$subscriptionType = $this->Session->read('subscriptionType');
		$this->set(compact('profile_status','bill_amount','subscriptionType'));
		$this->Session->destroy();
	}

	public function activateAccount() {
		try{
			$encrypt = $this->params->query['param'];
			if($encrypt) {
				$decrypt_key = $this->password_cryptData($encrypt,'decrypt');
				$exp_decrypt_key = explode("-",$decrypt_key);
				$findUser = $this->User->find('first',array('conditions'=>array('User.id'=>$exp_decrypt_key[0])));
				$userEmail = $findUser['User']['email'];
				$this->set(compact('userEmail'));
				if(!empty($findUser)) {
					if($findUser['User']['active'] != 'Y') {
						$this->set(compact('findUser'));
						if(!empty($this->data)) {
							$updateUser['User']['id'] = $findUser['User']['id'];
							$updateUser['User']['active'] = 'Y';
							$this->User->save($updateUser);
			 			}
					} else {
						$this->Session->setFlash(__('
					 	<div class="col-md-8 col-md-offset-2 clear"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><strong><i class="icon-remove"></i></strong>
							You have already activated your account!
							<br>
				  		</div></div><div class="space-30"></div><div class="space-30"></div>
					 '));
					 $this->redirect(array('controller'=>'users','action' => 'login'));
					}
				 } else {
					 $this->Session->setFlash(__('
					 	<div class="col-md-8 col-md-offset-2 clear"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><strong><i class="icon-remove"></i></strong>
							Error occurred! User is not present!
							<br>
				  		</div></div><div class="space-30"></div><div class="space-30"></div>
					 '));
					 $this->redirect(array('controller'=>'users','action' => 'login'));
				 }
			 } else {
					$this->Session->setFlash(__('
						<div class="col-md-8 col-md-offset-2 clear"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><strong><i class="icon-remove"></i></strong>
							Error occurred! Couldn\'t activate your account! Please contact cantorix support team!
							<br>
				  		</div></div><div class="space-30"></div><div class="space-30"></div>'
					));
				  	$this->redirect(array('controller'=>'users','action' => 'login'));
			}
		} catch( Exception $e) {
			 $this->Session->setFlash(__('
			 	<div class="col-md-8 col-md-offset-2 clear"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><strong><i class="icon-remove"></i></strong>
					Error occurred! Couldn\'t activate your account! Please contact cantorix support team!
					<br>
			  	</div></div><div class="space-30"></div><div class="space-30"></div>
			 '));
			 $this->redirect(array('controller'=>'users','action' => 'login'));
		}
		if ($this->request->is('post')) {
			
			$updateUserPassword['User']['id'] = $findUser['User']['id'];
			$updateUserPassword['User']['password'] = $this->data['User']['password'];
			if($this->User->save($updateUserPassword)) {
				$this->Auth->authenticate = array(
			 	'Form' => array(
	          			'fields' => array('username' => 'email', 'password' => 'password'),
	      			)
	   			);
				if ($this->Auth->login()) {
					$UserDetails = $this->Session->read();
					if(!empty($UserDetails['Auth']['User']['id']) && $UserDetails['Auth']['User']['active'] == 'Y') {
						$User = $this->Session->read();
						$aro = null;
						$aro = $this->Acl->Aro->find('first', array(
					        'conditions' => array(
					            'Aro.foreign_key' => $UserDetails['Auth']['User']['id']
					        ),
					    ));
						$this->Session->write('Auth.User.user_role',$aro['Aro']['parent_id']);
						if($UserDetails['Auth']['User']['sbs_subscriber_id'] > 0) {
							$this->getMenus('Subscriber');
						} else {
							$this->getMenus('Super Admin');
						}
						$this->refreshPermission();
						$mennnnuuusss = $this->Session->read('Auth.User.Menus.Menus');
						$rrr = 1;
						foreach ($mennnnuuusss as $asd) {
							if($rrr == 1) {
								$url = $asd['Aco']['url'];
							}
							break;
						}
						if(!$url){
							$url = '/users/noaccess';
						}
						if($User['Auth']['User']['user_type'] == "Subscriber") {
							$this->loadModel('CpnSubscriptionPlan');
							$plandetails = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.id'=> $UserDetails['Auth']['User']['SbsSubscriber']['cpn_subscription_plan_id'])));
							$today = strtotime(date('Y-m-d')); // or your date as well
						    $your_date = strtotime($UserDetails['Auth']['User']['SbsSubscriber']['subscribed_date']);
						   	$datediff = $today - $your_date;
						    $totalDaysOver = floor($datediff/(60*60*24));
							if($plandetails['CpnSubscriptionPlan']['type'] == "Free") {
								if($totalDaysOver > $plandetails['CpnSubscriptionPlan']['validity']) {
									$this->Session->write('Upgrade.Auth',$User['Auth']);
									$this->Session->delete('Auth');
									$this->Auth->loginRedirect = array('controller' => 'users','action' => 'upgrade');	
								} else {
									$this->Auth->loginRedirect = $url;
								}
							} else {
								$this->Auth->loginRedirect = $url;
							}
						} else {
							$this->Auth->loginRedirect = $url;
						}
					}
					return $this->redirect($this->Auth->redirect());
				}
				
			} else {
				$this->Session->setFlash(__('
				 	<div class="col-md-8 col-md-offset-2 clear"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><strong><i class="icon-remove"></i></strong>
						Error occurred! Couldn\'t update your password at this moment, please try again!
						<br>
				  	</div></div><div class="space-30"></div><div class="space-30"></div>
				'));
				return;
			}
		}
	}
		
	
	public function account_activation() {
		$userExist = $this->Session->read('userIDD');
		$encrypt_key = $this->password_cryptData($userExist.'-'.'Cantorix User Password Encrypt'.'-'.strtotime(date('Y-m-d H:i:s')),'encrypt');
		$details = null;
		$details['resetlinkKey'] = $encrypt_key;
		$this->set(compact('details'));		
		$this->Email->to 	  	= $this->Session->read('email');
		$this->Email->cc		= array('ganesh@carmatec.com','venugopal@carmatec.com');
        $this->Email->subject 	= 'Cantorix Account Activation';
   		$this->Email->replyTo 	= 'admin@cantorix.com';
    	$this->Email->from 		= 'admin@cantorix.com';
    	$this->Email->template 	= 'account_activation';
   		$this->Email->sendAs 	= 'html' ;
		$this->Email->send() ;	
		return;	
	}
	
	public function signupFailure ($methodError=null) {
		
		$errorCode     = $this->Session->read('errorCode');			
		$errorSmallMsg = $this->Session->read('errorSmallMsg');
		$errorLongMsg  = $this->Session->read('errorLongMsg');
		$serverCode	   = $this->Session->read('serverCode');
		
		$this->set(compact('errorCode','errorSmallMsg','errorLongMsg','serverCode','methodError'));
		$this->Session->destroy();		
	}		
		
	// random generate password of length 8
	function generate_password( $length = 8 ) {
		$this->autoRender = false;	
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
		$password = substr( str_shuffle( $chars ), 0, $length );
		return $password;
	}

	
	// get visitor details	
	function getVisitorDetails () {
				
		   $ip = $this->get_client_ip();		   
		   $visitorDetails = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
		   return $visitorDetails;		
	}
	
	
	function isEmailExist(){
		$this->autoRender = false;	
		$email = $this->params->query['emailaddress'];		
		$this->loadModel('User');		 
	    	$email_exist = $this->User->find('first', array (
			'conditions' => array (
				'User.email' => $email
			)
		));		
 		if($email_exist){
 			echo "true";	
		}else{
			echo "false";	
		}
	}
	
	function isUsernameExist(){
		$this->autoRender = false;	
		$username = $this->params->query['username'];		
		$this->loadModel('User');		 
	    	$username_exist = $this->User->find('first', array (
			'conditions' => array (
				'User.username' => $username
			)
		));		
 		if($username_exist){
 			echo "true";	
		}else{
			echo "false";	
		}
	}
	
	function captcha()	{
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{ //if Component was not loaded throug $components array()
			$this->Captcha = $this->Components->load('Captcha', array(
				'width' => 150,
				'height' => 50,
				'theme' => 'default', //possible values : default, random ; No value means 'default'
			)); //load it
			}
		$this->Captcha->create();
	}

	/*Login function*/
	public function login() {
		//Configure::write('debug',2);
		$this->layout = "signup_login";
		$title_for_layout = 'Sign In';
		$cookieValues = $this->Cookie->read('remember_me_cookie');
		$this->set(compact('cookieValues','title_for_layout'));
		$loginAttemptCheck = $this->Session->read('LoginAttempt.Incorrect');
		if($loginAttemptCheck > 3) {
			$captcha = TRUE;
			$this->set(compact('captcha'));
		}
		
		$UserDetails = $this->Session->read();
		if(!empty($UserDetails['Auth']['User']['id']) && $UserDetails['Auth']['User']['active'] == 'Y') {
			$mennnnuuusss = $this->Session->read('Auth.User.Menus.Menus');
			$rrr = 1;
			foreach ($mennnnuuusss as $asd) {
				if($rrr == 1) {
					$url = $asd['Aco']['url'];
				}
				break;
			}
			if(!$url){
				$url = '/users/noaccess';
			}
			if($UserDetails['Auth']['User']['user_type'] == "Subscriber") {
				$this->loadModel('CpnSubscriptionPlan');
				$plandetails=null;
				$plandetails = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.id'=> $UserDetails['Auth']['User']['SbsSubscriber']['cpn_subscription_plan_id'])));
				$today = strtotime(date('Y-m-d')); // or your date as well
			    $your_date = strtotime($UserDetails['Auth']['User']['SbsSubscriber']['subscribed_date']);
			   	$datediff = $today - $your_date;
			    $totalDaysOver = floor($datediff/(60*60*24));
				if($plandetails['CpnSubscriptionPlan']['type'] == "Free") {
					if($totalDaysOver > $plandetails['CpnSubscriptionPlan']['validity']) {
						$this->Session->write('Upgrade.Auth',$User['Auth']);
						$this->Session->delete('Auth');
						$this->Auth->loginRedirect = array('controller' => 'users','action' => 'upgrade');	
					} else {
						$this->Auth->loginRedirect = $url;
					}
				} else {
					$this->Session->setFlash('<div class="alert alert-info"> Welcome back!</div>');
					$this->Auth->loginRedirect = $url;
				}
			} else {
				$this->Auth->loginRedirect = $url;
			}
			return $this->redirect($this->Auth->redirect());
		}
		if ($this->request->is('post')) {
			if(!empty($this->data['User']['captcha'])) {
				$captcha	= $this->data['User']['captcha'];
				$componentCode = $this->Captcha->getVerCode();
				if( $componentCode != $captcha ){
						$securityError = '<label for="UserCaptcha" class="error">Security Code does not match</label>';
						$this->set(compact('securityError'));
						return;
				}
			}
			
			if (filter_var(trim($this->request->data['User']['username']), FILTER_VALIDATE_EMAIL)) {
				$this->request->data['User']['email'] = trim($this->data['User']['username']);
				unset($this->request->data['User']['username']);
				$this->Auth->authenticate = array(
			 	'Form' => array(
	          			'fields' => array('username' => 'email', 'password' => 'password'),
	      			)
	   			);
				$this->Auth->authorize = 'Controller';
				$this->Auth->loginAction = array('controller'=>'users','action'=>'login');			
				$this->Auth->logoutRedirect = array('controller' => 'users','action' => 'login');
			}
			if ($this->Auth->login()) {
	            $this->Session->delete('LoginAttempt.Incorrect');
				if ($this->request->data['User']['remember_me'] == 1) {
	                unset($this->request->data['User']['remember_me']);
	                $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
	                $this->Cookie->write('remember_me_cookie', $this->request->data['User'], true, '2 weeks');
					$this->Cookie->write('remember_me_cookie.rememberMe', 1, true, '2 weeks');
	            }
				
				$UserDetails = $this->Session->read();
				if(!empty($UserDetails['Auth']['User']['id']) && $UserDetails['Auth']['User']['active'] == 'Y') {
					$User = $this->Session->read();
					$aro = null;
					$aro = $this->Acl->Aro->find('first', array(
				        'conditions' => array(
				            'Aro.foreign_key' => $UserDetails['Auth']['User']['id']
				        ),
				    ));
					$this->Session->write('Auth.User.user_role',$aro['Aro']['parent_id']);
					if($UserDetails['Auth']['User']['sbs_subscriber_id'] > 0) {
						$this->getMenus('Subscriber');
					} else {
						$this->getMenus('Super Admin');
					}
					$this->refreshPermission();
					$mennnnuuusss = $this->Session->read('Auth.User.Menus.Menus');
					$rrr = 1;
					foreach ($mennnnuuusss as $asd) {
						if($rrr == 1) {
							$url = $asd['Aco']['url'];
						}
						break;
					}
					if(!$url){
						$url = '/users/noaccess';
					} 
					if($User['Auth']['User']['user_type'] == "Subscriber") {
						$this->loadModel('CpnSubscriptionPlan');
						$plandetails = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.id'=> $UserDetails['Auth']['User']['SbsSubscriber']['cpn_subscription_plan_id'])));
						$today = strtotime(date('Y-m-d')); // or your date as well
					    $your_date = strtotime($UserDetails['Auth']['User']['SbsSubscriber']['subscribed_date']);
					   	$datediff = $today - $your_date;
					    $totalDaysOver = floor($datediff/(60*60*24));
						if($plandetails['CpnSubscriptionPlan']['type'] == "Free") {
							if($totalDaysOver > $plandetails['CpnSubscriptionPlan']['validity']) {
								$this->Session->write('Upgrade.Auth',$User['Auth']);
								$this->Session->delete('Auth');
								$this->Auth->loginRedirect = array('controller' => 'users','action' => 'upgrade');	
							} else {
								$this->Auth->loginRedirect = $url;
							}
						} else {
							$this->Auth->loginRedirect = $url;
						}
					} else {
						$this->Auth->loginRedirect = $url;
					}
				} else {
					$this->Session->setFlash('
						<div class="col-md-8 col-md-offset-2 clear"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
									<strong><i class="icon-remove"></i></strong>User is inactive! Please contact admin team!
									<br>
					  			</div>
							</div><div class="space-30"></div><div class="space-30"></div>',
		                'default',array(),'auth'
		            );
					return $this->redirect($this->Auth->logout());
				}
	            return $this->redirect($this->Auth->redirect());
	        } else {
	        	$read = $this->Session->read('LoginAttempt.Incorrect');
	        	$this->Session->write('LoginAttempt.Incorrect',$read+1);
				$loginAttempts = $this->Session->read('LoginAttempt.Incorrect');
				if($loginAttempts > 3) {
					$this->Session->setFlash('
						<div class="col-md-8 col-md-offset-2 clear"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button><strong><i class="icon-remove"></i></strong>
							You have exceeded more than three unsuccessful attempts, Please try again
							<br>
					  	</div></div><div class="space-30"></div><div class="space-30"></div>','default',array(),'auth'
		            );
					$captcha = TRUE;
					$this->set(compact('captcha'));
				} else {
					$this->Session->setFlash(
		               '<div class="col-md-8 col-md-offset-2 clear">
	        					<div class="alert alert-danger">
									<button type="button" class="close" data-dismiss="alert">
										<i class="icon-remove"></i>
									</button>
									<strong>
										<i class="icon-remove"></i>												
									</strong>
									Username or password incorrect! Please try again!
									<br>
					  			</div>
							</div>
							<div class="space-30"></div>
							<div class="space-30"></div>',
		                'default',
		                array(),
		                'auth'
		            );
				}
	        }
	    }
	}

	public function upgrade() {
		$this->loadModel('CpnSubscriptionPlan');
		$plans = $this->CpnSubscriptionPlan->find('all',array('conditions'=>array('NOT'=>array('CpnSubscriptionPlan.type'=>'Free'))));
		$currentPlan = $this->CpnSubscriptionPlan->find('first',array('conditions'=>array('CpnSubscriptionPlan.type'=>'Free')));
		$this->set(compact('currentPlan','plans'));
	}

/**
 * @Author Ganesh
 * @Since 26-May-2014
 * @Version v.1
 * @Method Logout function.
 * **/	
	public function logout() {
		$this->Session->delete('Auth');
		$this->Session->delete('LoginAttempt');
		$this->Session->setFlash(
           '<div class="alert alert-info"><button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>
				<strong>Thank you!  See you soon!</strong><br></div>',
            'default',
            array(),
            'auth'
        );
    	return $this->redirect($this->Auth->logout());
	}

/**
 * @Author Ganesh
 * @Since 28-May-2014
 * @Version v.1
 * @Method Forgot password function.
 * **/		
	public function forgotPassword() {
		$title_for_layout = 'Forgot Password';
		$this->set(compact('title_for_layout'));
		if(!empty($this->data)) {
			$userExist = $this->User->findByEmail($this->data['User']['email']);
			if(empty($userExist)) {
				$this->Session->setFlash('<div class="alert alert-warning">
											<button data-dismiss="alert" class="close" type="button">
												<i class="icon-remove"></i>
											</button><strong>Warning!</strong>  User doesn\'t exist!<br>
										</div>','default');
				return;
			} else {
				$encrypt_key = $this->password_cryptData($userExist['User']['id'].'-'.'Cantorix User Password Encrypt'.'-'.strtotime(date('Y-m-d H:i:s')),'encrypt');
				$details = null;
				$details['resetlinkKey'] = $encrypt_key;
				$this->set(compact('details'));
				$this->Email->to 	  	= $this->data['User']['email'];
				$this->Email->cc		= array('venugopal@carmatec.com','ganesh@carmatec.com');
		        $this->Email->subject 	= 'Cantorix Password Reset Confirmation';
		   		$this->Email->replyTo 	= 'admin@cantorix.com';
		    	$this->Email->from 		= 'admin@cantorix.com';
		    	$this->Email->template 	= 'confirm_reset_pass';
		   		$this->Email->sendAs 	= 'html' ;
		   		if($this->Email->send()) {
		   			$this->Session->setFlash(__('<div class="alert alert-block alert-success">Password reset link is sent successfully. Please check your mail for further details.</div>'));
					$this->redirect(array('controller'=>'users','action' => 'login'));
		   		} else {
		   			$this->Session->setFlash(__('
		   			<div class="col-md-8 col-md-offset-2 clear">
    					<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="icon-remove"></i>
							</button>
							<strong>
								<i class="icon-remove"></i>												
							</strong>
							Password is reset failed. Please try again.
							<br>
			  			</div>
					</div>
					<div class="space-30"></div>
					<div class="space-30"></div>
		   			'));
					return;
		   		}
			}
		}
	}
	
	
/**
 * @Author Ganesh
 * @Since 28-May-2014
 * @Version v.1
 * @Method Confirm reset password function, resets the password of the user.
 * **/
	 public function confirmResetPassword() {
	 	
	 	try{
			 $encrypt = $this->params->query['param'];
			 if($encrypt) {
			 	debug($encrypt);
				 $decrypt_key = $this->password_cryptData($encrypt,'decrypt');
				 debug($decrypt_key);
				 $exp_decrypt_key = explode("-",$decrypt_key);
				 $resettime = date('Y-m-d H:i:s', $exp_decrypt_key[2]);
				 $currenttime = date('Y-m-d H:i:s');
				 debug($resettime);
				 debug($currenttime);
				 $timediff = $this->get_time_difference($resettime,$currenttime);
				 debug($timediff);
				 $loginlimit = '45';
				 $within_mins = false;
				 if($timediff['days']=='0' && $timediff['hours']=='0' && $timediff['minutes']<=$loginlimit) {
					 if($timediff['minutes']==$loginlimit && $timediff['seconds']>'0') {
						 $within_mins = false;
					 } else {
						 $within_mins = true;
					 }
				 } else {
					 $within_mins = false;
				 }
				$within_mins = TRUE;
				 if($within_mins) {
				 	$this->User->unbindModel(array('belongsTo'=>array('SbsSubscriber')));
					 $findUser = $this->User->find('first',array('conditions'=>array('User.id'=>$exp_decrypt_key[0])));
					 if(!empty($findUser)) {
					 	$this->set(compact('findUser'));
						 if(!empty($this->data)) {
							 if($this->User->save($this->data)) {
							 	$this->Session->setFlash(__('<div class="col-md-8 col-md-offset-2 clear">
	        					<div class="alert alert-block alert-success">
									<p>
										<strong>
												<i class="icon-ok"></i>Success
												</strong>
										Password reset is successful!
									<br>
					  			</div>
							</div>
							<div class="space-30"></div>
							<div class="space-30"></div>'));
								 $this->redirect(array('controller'=>'users','action' => 'login'));
							 } else {
							 	 $this->Session->setFlash(__('
							 	 <div class="col-md-8 col-md-offset-2 clear">
    						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="icon-remove"></i>
							</button>
							<strong>
								<i class="icon-remove"></i>												
							</strong>
							Error! Password couldnot be saved!
							<br>
			  			</div>
					</div>
					<div class="space-30"></div>
					<div class="space-30"></div>'));
						 		$this->redirect(array('controller'=>'users','action' => 'login'));
							 }
			 			}
					 } else {
						 $this->Session->setFlash(__('
						 	<div class="col-md-8 col-md-offset-2 clear">
    						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="icon-remove"></i>
							</button>
							<strong>
								<i class="icon-remove"></i>												
							</strong>
							Error occurred! User is not present!
							<br>
			  			</div>
					</div>
					<div class="space-30"></div>
					<div class="space-30"></div>
						 '));
						 $this->redirect(array('controller'=>'users','action' => 'login'));
					 }
				 } else {
					 $this->Session->setFlash(__('
					 <div class="col-md-8 col-md-offset-2 clear">
    					<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="icon-remove"></i>
							</button>
							<strong>
								<i class="icon-remove"></i>												
							</strong>
							Sorry! this link is expired! Couldn\'t reset your password! Please reset your password again!
							<br>
			  			</div>
					</div>
					<div class="space-30"></div>
					<div class="space-30"></div>
					 '));
					 $this->redirect(array('controller'=>'users','action' => 'login'));
				 }
			 } else {
				  $this->Session->setFlash(__('<div class="col-md-8 col-md-offset-2 clear">
    					<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="icon-remove"></i>
							</button>
							<strong>
								<i class="icon-remove"></i>												
							</strong>
							Error occurred! Couldn\'t reset your password! Please try again!
							<br>
			  			</div>
					</div>
					<div class="space-30"></div>
					<div class="space-30"></div>'));
				  $this->redirect(array('controller'=>'users','action' => 'login'));
			  }
			} catch( Exception $e) {
			 $this->Session->setFlash(__('
			 <div class="col-md-8 col-md-offset-2 clear">
    					<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert">
								<i class="icon-remove"></i>
							</button>
							<strong>
								<i class="icon-remove"></i>												
							</strong>
							Error occurred! Couldn\'t reset your password! Please try again!
							<br>
			  			</div>
					</div>
					<div class="space-30"></div>
					<div class="space-30"></div>
			 '));
			 $this->redirect(array('controller'=>'users','action' => 'login'));
		 }
	 }
	
/**
 * @Author Ganesh
 * @Since 28-May-2014
 * @Version v.1
 * @Method Returns the time difference between two times.
 * **/
 	private function get_time_difference( $start, $end ) {
    	$uts['start']      =    strtotime( $start );
    	$uts['end']        =    strtotime( $end );
   		if( $uts['start']!==-1 && $uts['end']!==-1 ) {
        	if( $uts['end'] >= $uts['start'] ) {
            	$diff    =    $uts['end'] - $uts['start'];
            	if( $days=intval((floor($diff/86400))) )
                	$diff = $diff % 86400;
            	if( $hours=intval((floor($diff/3600))) )
                	$diff = $diff % 3600;
            	if( $minutes=intval((floor($diff/60))) )
                	$diff = $diff % 60;
           	 		$diff    =    intval( $diff );            
            	return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        	}
    	}
	}

/**
 * @Author Ganesh
 * @Since 28-May-2014
 * @Version v.1
 * @Method Returns the time difference between two times.
 * **/
	private function password_cryptData($value, $action) {
    	$key = 'passreset';
	    switch($action) {
	       case "encrypt":
	                for($i=0; $i<strlen($value); $i++) {
						$char = substr($value, $i, 1);
						$keychar = substr($key, ($i % strlen($key))-1, 1);
						$char = chr(ord($char)+ord($keychar));
						$result.=$char;
					}
					$result = base64_encode($result);  
	           break;
	       case "decrypt":
	       			$string = base64_decode($value);
	                for($i=0; $i<strlen($string); $i++) {
						$char = substr($string, $i, 1);
						$keychar = substr($key, ($i % strlen($key))-1, 1);
						$char = chr(ord($char)-ord($keychar));
						$result.=$char;
					} 
	           break;
	       default:
	           break;
	    };
	    return $result;
	}
	
	
	public function createAdminUser() {
		
		$menus = $this->getMenus('Super Admin');
		$refreshPermission = $this->refreshPermission();
		
		$Acl = new AclComponent();
		$aro = $Acl->Aro;
		
		$adminUserGroupExist =  $aro->find('first',array('conditions'=>array('Aro.alias'=>'Admin','Aro.parent_id'=> null,'Aro.foreign_key'=> null)));
		
		if(empty($adminUserGroupExist)) {
			$aro->create();
			$saveUserGroupAdmin['Aro']['alias'] = 'Admin';
			$aro->save($saveUserGroupAdmin);
		}
		
		$subscriberUserGroupExist = $aro->find('first',array('conditions'=>array('Aro.alias'=>'Subscriber','Aro.parent_id'=> null,'Aro.foreign_key'=> null)));
		if(empty($subscriberUserGroupExist)) {
			$aro->create();
			$saveUserGroupSubscribers['Aro']['alias'] = 'Subscriber';
			$aro->save($saveUserGroupSubscribers);
		}
		
		$adminUserExist = $this->User->find('first',array('conditions'=>array('User.email'=>'admin@carmatec.com')));
		if(empty($adminUserExist)) {
			$saveUser->data = null;
			$this->User->create();			
			$saveUser->data['User']['username']  			= 'admin';
			$saveUser->data['User']['email']				= 'admin@carmatec.com';
			$saveUser->data['User']['password']				= 'qazplm123';
			$saveUser->data['User']['active']				= 'Y';
			$saveUser->data['User']['user_type']			= 'Super Admin';		
			$this->User->save($saveUser->data);
			if($this->User->save($saveUser->data)) {
				/*Creating Admin Usergroup for subscribers*/
				$lastuser = $this->User->getLastInsertID();
				$data     = null;
				$aro->create();
				$data['alias']       = 'Admin';
				$data['parent_id']   = 1;
				$data['model']       = "Usergroup";
				$data['foreign_key'] = null;
				$aro->save($data);
				$usergroupId = $aro->getLastinsertId();
				/*End Usergroup*/
				
				
				/*Creating Permissions for usergroup*/
				$aco = $Acl->Aco;
				$AroAco = Classregistry::init('ArosAco');
				$menus = $aco->find('all',array('conditions'=>array('Aco.user_type'=>'Super Admin')));
				foreach($menus as $menu) {
					$permisssion['ArosAco']['aro_id'] = $usergroupId;
					$permisssion['ArosAco']['aco_id'] = $menu['Aco']['id'];
					$permisssion['ArosAco']['_create'] = 1;
					$permisssion['ArosAco']['_read'] = 1;
					$permisssion['ArosAco']['_update'] = 1;
					$permisssion['ArosAco']['_delete'] = 1;
					
					$AroAco->create();
					$AroAco->save($permisssion);
				}
				/*End Permisions*/
				
				
				/*Mapping the user to Usergroup*/
				$data     = null;
				$aro->create();
				$data['alias']       = 'admin@carmatec.com';		
				$data['model']       = "Super User";
				$data['parent_id']   = $usergroupId;
				$data['foreign_key'] = $lastuser;
				$aro->save($data);
				/*End Mapping*/
				
				
				$this->Session->setFlash(__('<div class="col-md-8 col-md-offset-2 clear">
		        					<div class="alert alert-block alert-success">
										<p>
											<strong>
													<i class="icon-ok"></i>Success
													</strong>
											Admin username and password is created!
										<br>
						  			</div>
								</div>
								<div class="space-30"></div>
								<div class="space-30"></div>'));
			} else {
				$this->Session->setFlash(__('
				 <div class="col-md-8 col-md-offset-2 clear">
	    					<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">
									<i class="icon-remove"></i>
								</button>
								<strong>
									<i class="icon-remove"></i>												
								</strong>
								Error occurred! Couldn\'t create admin user! Please try again later!
								<br>
				  			</div>
						</div>
						<div class="space-30"></div>
						<div class="space-30"></div>
				 '));
			}
		} else {
			$this->Session->setFlash(__('
				 <div class="col-md-8 col-md-offset-2 clear">
	    					<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">
									<i class="icon-remove"></i>
								</button>
								<strong>
									<i class="icon-remove"></i>												
								</strong>
								Error occurred! Admin user already exist!
								<br>
				  			</div>
						</div>
						<div class="space-30"></div>
						<div class="space-30"></div>
				 '));
		}
		return $this->redirect(array('controller'=>'users','action'=>'login'));
	}
	
	
	public function addMenu() {
		
		$aco = $this->Acl->Aco;
		$aco->recursive = 0;
		$options = $aco->find('list',array('conditions'=>array('Aco.parent_id IS NULL'),'fields'=>array('id','alias')));
		$this->set(compact('options'));
		if(!empty($this->data)) {
			debug($this->data);
			$aco = $this->Acl->Aco;
			$aco1['Aco']['model'] = $this->data['Aco']['model'];
			$aco1['Aco']['alias'] = $this->data['Aco']['alias'];
			$aco1['Aco']['order'] = $this->data['Aco']['order'];
			$aco1['Aco']['parent_id'] = $this->data['Aco']['parent_id'];
			$aco1['Aco']['url'] = $this->data['Aco']['url'];
			$aco1['Aco']['user_type'] = $this->data['Aco']['user_type'];
			$aco->create();
			if($aco->save($aco1)){
				$this->redirect('/users/addMenu/');
			}
		}
	}

/**
 * @Author Ganesh
 * @Since 4-Jun-2014
 * @Version v.1
 * @Method Manage Admin users.
 * **/
	public function manageUsers($user_id = null,$userName = 0, $emailId = 0, $role = 0) {
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if(!$this->request->is('ajax')) {
			$this->layout = "cpn_layout";
		}
		/*if ($this->request->isMobile()) {
			 //$this->autoRender = false;
   			//$this->render('/Users/noaccess');
		}*/
		$title_for_layout = 'Manage Users';
		$menuActive = 'Manage Users';
		$settingsActive = 'active';
		$permission = $this->permission;
		$usergroups = $this->User->getUsergroups('Super Admin');
		$this->loadModel('CpnSetting');
		$settings = $this->CpnSetting->getAllSettings();
		$limit = $settings['CpnSetting']['lines_per_page'];
		$userGroup = $this->Acl->Aro;
		$userGroup->recursive = -1;
		$admin_roles = $userGroup->find('list',array('conditions'=>array('Aro.parent_id'=>1,'Aro.foreign_key'=>NULL),'fields'=>array('Aro.id','Aro.alias')));
		$adminUsergroup = $userGroup->find('first',array('conditions'=>array('Aro.parent_id' => '1','Aro.alias'=>'Admin')));
		$adminUser = $userGroup->find('first',array('conditions'=>array('Aro.parent_id' => $adminUsergroup['Aro']['id']),'fields'=>array('Aro.foreign_key')));
		
		
		$this->set(compact('title_for_layout','menuActive','permission','usergroups','settingsActive','adminUser'));
		$this->Paginator->settings = array('conditions'=>array('User.user_type' => 'Super Admin'),'limit'=>$limit,'order'=>array('User.id'=>'desc'));
		

		/*Add New User Section starts here*/
		if(!empty($this->data['UserNew'])) {
			$emailExist = NULL;
			$emailExist = $this->validateUserEmail('add',$this->data);
			if(!$emailExist) {
				$user_idddd = $this->User->saveNewUser($this->data);
				if($user_idddd) {
					$this->set('data',$this->data);
					$encrypt_key = $this->password_cryptData($user_idddd.'-'.'Cantorix User Password Encrypt'.'-'.strtotime(date('Y-m-d H:i:s')),'encrypt');
					$details = null;
					$details['resetlinkKey'] = $encrypt_key;
					$this->set(compact('details'));
					$this->Email->to 	  	= $this->data['UserNew']['email'];
					$this->Email->cc		= array('venugopal@caramtec.com','ganesh@carmatec.com');
			        $this->Email->subject 	= 'Welcome to CantoriX!';
			   		$this->Email->replyTo 	= 'admin@cantorix.com';
			    	$this->Email->from 		= 'admin@cantorix.com';
			    	$this->Email->template 	= 'confirm_reset_pass';
			   		$this->Email->sendAs 	= 'html';
			   		if($this->Email->send()) {
			   			$this->Session->setFlash('<div class="alert alert-block alert-success">User has been created successfully and login credentials has been sent to user.</div>');
					} else {
						$this->Session->setFlash('<div class="alert alert-info">User has been created successfully and login credentials couldn\'t send.</div>');
					}
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">Email you entered already exist. Please try other email!</div>');
				}
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Email you entered already exist. Please try other email!</div>');
				//$this->Session->setFlash('<div class="alert alert-danger">Email you entered already exist! please try other email!</div>');
			}
			return $this->redirect(array('action'=>'manageUsers'));
		}
		/*Add New User Section ends here*/
		
		
		/*Filter Section Code starts here*/
		
		if($userName) {
			$this->request->data['Filter']['username'] = $userName;
		}
		if($emailId){
			$this->request->data['Filter']['email1'] = $emailId;
		}
		if($role) {
			$this->request->data['Filter']['role'] = $role;
		}
		if(!empty($this->data['Filter'])) {
			
			if(!empty($this->request->data['Filter']['username'])) {
				$userName = trim($this->request->data['Filter']['username']);
			}
			if(!empty($this->request->data['Filter']['email1'])) {
				$emailId = trim($this->request->data['Filter']['email1']);
			}
			if(!empty($this->request->data['Filter']['role'])) {
				$role = trim($this->request->data['Filter']['role']);
			}
			if(empty($userName) && empty($emailId) && empty($role)) {
				$this->Session->setFlash('<div class="alert alert-info">Please enter atleast one search term.</div>');
				$this->redirect(array('action'=>'manageUsers'));
			}
			
			$condition_array=null; $userName_array=null; $emailId_array=null; $role_array=null;
			if($userName) {
				$userName_array = array('User.user_type' => 'Super Admin','User.username LIKE' => '%'.$userName.'%');
			}
			if($emailId) {
				$emailId_array = $conditions = array('User.user_type' => 'Super Admin','User.email LIKE' => '%'.$emailId.'%');
			}
			if($role) {
				$userIds = $userGroup->find('list',array('conditions'=>array('Aro.parent_id'=>$role),'fields'=>array('Aro.foreign_key','Aro.foreign_key')));
				$role_array = array('User.id' => $userIds);
			}
			
			$conditions=array($userName_array,$emailId_array,$role_array);
			$this->Paginator->settings = array(
				'conditions'=> $conditions,'limit' => $limit,'order'=>array('User.id'=>'desc')
			);
		}
		/*Filter Section Code ends here*/
		
		/*Data listing code Section starts here*/			
		
		$users = $this->Paginator->paginate('User');
		if(empty($users)) {
			$this->Session->setFlash('<div class="alert alert-info">No users found.</div>');
		}
		
		foreach($users as $index => $value) {
			$users[$index] = $value;
			$aro_id = $userGroup->find('first',array('conditions'=>array('Aro.foreign_key'=>$value['User']['id'])));
			$users[$index]['usergroup_details'] = $userGroup->find('first',array('conditions'=>array('Aro.id'=>$aro_id['Aro']['parent_id'])));
		}
		if($this->params['named']['sort'] == 'Aro.alias') {
			$users = Set::sort($users, '{n}.usergroup_details.Aro.alias', $this->params['named']['direction']);
		}
		$this->set(compact('users','userName','emailId','role','admin_roles'));
		/*Data listing code Section ends here*/
		
	}


/**
 * @Author Ganesh
 * @Since 4-Jun-2014
 * @Version v.1
 * @Method Edit Admin users.
 * **/
	public function editUser($id=NULL, $action = NULL) {
		if($actionnnn != 'view') {
			$this->permission = $this->Session->read('Auth.AllPermissions.Manage Users');
		} else {
			$this->permission = $this->Session->read('Auth.AllPermissions.Manage Roles');
		}
		if($this->permission['_update'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$permission = $this->permission;
		$subsID = $this->Session->read('Auth.User.sbs_subscriber_id');
		$userGroup = $this->Acl->Aro;
		if(empty($subsID)) {
			$update['User']['id'] = $this->data['User'][$id]['id'];
			$update['User']['active'] = $this->data['User'][$id]['active'];
			$this->User->save($update);
			
			$AroExist = $userGroup->find('first',array('conditions'=>array('Aro.foreign_key'=>$id),'fields'=>array('Aro.id')));
			if ($AroExist) {
				$userGroup->updateAll(
				    array('Aro.parent_id' => $this->data['User'][$id]['aro_id']),
				    array('Aro.foreign_key' => $id)
				);
			} else {
				$saveAro['Aro']['parent_id'] = $this->data['User'][$id]['aro_id'];
				$saveAro['Aro']['model'] = 'Super User';
				$saveAro['Aro']['foreign_key'] = $id;
				$saveAro['Aro']['alias'] = $update['User']['email'];
				$saveAro['Aro']['sbs_subscriber_id'] = 0;
				$userGroup->create();
				$userGroup->save($saveAro);
			}
			$user['User'] = $this->data['User'][$id];
			$user['usergroup_details']['Aro']['id'] = $this->data['User'][$id]['aro_id'];
		} else {
			$user = $this->User->findById($id);
			$usergroupID = $userGroup->find('first',array('conditions'=>array('Aro.foreign_key'=>$user['User']['id']),'fields'=>array('Aro.parent_id','Aro.alias')));
			$user['usergroup_details']['Aro']['id'] = $usergroupID['Aro']['parent_id'];
		}
		$usergroups = $this->User->getUsergroups('Super Admin');
		$this->set(compact('user','usergroups','permission','action'));
	}



	public function validateUserEmail($method = NULL,$data = NULL, $user_id=NULL) {
		$this->autoRender = FALSE;
		$userExist= NULL;$errorMsg = NULL;
		if($method == 'add') {
			if($data) {
				$this->request->data = $data;
			}
			$userExist = $this->User->find('first',array('conditions'=>array('User.email'=>$this->data['UserNew']['email']),'fields'=>array('User.id')));
			if($userExist) {
				$errorMsg = 'false';
			}
		} else {
			
		}
		return $errorMsg;
	}
	
	public function checkUserNameAvailability() {
		$this->autoRender = FALSE;$errorMsg = NULL;$userExist= NULL;
		$userNamee = trim($this->data['UserNew']['username']);
		if(!empty($userNamee)) {
			$userExist = $this->User->find('first',array('conditions'=>array('User.username'=>$userNamee),'fields'=>array('User.id')));
			if(!empty($userExist)) {
				$errorMsg = 'false';
			}
		}
		return $errorMsg;
	}
	
	
	public function validateUsername($user_id=NULL,$data = NULL) {
		$this->autoRender = FALSE;
		if($data) {
			$this->request->data['User'.$user_id]['username'] = $data['User'.$user_id]['username'];
		}
		$userExist = $this->User->find('first',array('conditions'=>array('User.username'=>$this->data['User'.$user_id]['username'],'NOT'=>array('User.id'=>$user_id)),'fields'=>array('User.id')));
		$errorMsg = NULL;
		if($userExist) {
			$errorMsg = '<label for="UserCaptcha1" class="error">Username already taken! Couldn\'t update!</label>';
		} else {
			$errorMsg = NULL;
		}
		return $errorMsg;
	}
	
	public function deleteUser($user_id=null,$controller = NULL, $action = NULL, $param1 = NULL) {
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$subsID = $this->Session->read('Auth.User.sbs_subscriber_id');
		if($subsID == 0) {
			$Aro = $this->Acl->Aro;
			$Aro->deleteAll(array('Aro.foreign_key'=> $user_id), FALSE);
			if ($this->User->delete($user_id)) {
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">User has been deleted!</div>'));
			} else {
				$this->Session->setFlash(__('<div class="alert alert-danger">User could not be deleted. Please, try again.</div>'));
			}
			$this->redirect(array('action' => 'manageUsers'));
		}
	}
	
	public function index($user_id = null,$userName = 0, $emailId = 0, $role = 0) {
		$this->permission = $this->Session->read('Auth.AllPermissions.Users');
		if($this->permission['_read'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		if(!$this->request->is('ajax')) {
			$this->layout = "sbs_layout";
		}
		$this->loadModel('SbsSubscriber');
		$subscriberID = $this->Session->read('Auth.User.sbs_subscriber_id');
		$usergroups = $this->User->getUsergroups('Subscriber',$subscriberID);
		$this->loadModel('SbsSubscriberSetting');
		$settings = $this->SbsSubscriberSetting->defaultSettings();
		$limit = $settings['SbsSubscriberSetting']['lines_per_page'];
		if(!$limit) $limit=10;
		$permission = $this->permission;
		$menuActive = 'Users';
		$settingsActive = 'active';
		$adminUser = $this->User->find('first',array('conditions'=>array('User.user_type' => 'Subscriber','User.sbs_subscriber_id'=>$subscriberID)));
		$this->loadModel('CpnSubscriptionPlan');
		$planDetails = $this->CpnSubscriptionPlan->getSubscriptionNameById($this->Session->read('Auth.User.SbsSubscriber.cpn_subscription_plan_id'));
		$presentUsersCount = $this->User->find('count',array('conditions'=>array('User.sbs_subscriber_id'=>$subscriberID,'User.active'=>'Y')));
		if($planDetails['CpnSubscriptionPlan']['no_of_staffs'] > $presentUsersCount || $planDetails['CpnSubscriptionPlan']['no_of_staffs'] == -1) {
			$showAddButton = TRUE;
		} else {
			$showAddButton = FALSE;
		}
		$this->set(compact('menuActive','permission','usergroups','settingsActive','adminUser','showAddButton','planDetails'));
		$this->Paginator->settings = array('conditions'=>array('User.user_type' => 'Subscriber','User.sbs_subscriber_id'=>$subscriberID),'limit'=>$limit,'order'=>array('User.id'=>'desc'));
		$userGroup = $this->Acl->Aro;
		/*Add New User Section starts here*/
		if(!empty($this->data['UserNew'])) {
			$emailExist = NULL;
			$emailExist = $this->validateUserEmail('add',$this->data);
			if(!$emailExist) {
				$user_idddd = $this->User->saveNewSubscriberUser($this->data,$subscriberID);
				if($user_idddd) {
					$this->set('data',$this->data);
					$encrypt_key = $this->password_cryptData($user_idddd.'-'.'Cantorix User Password Encrypt'.'-'.strtotime(date('Y-m-d H:i:s')),'encrypt');
					$details = null;
					$details['resetlinkKey'] = $encrypt_key;
					$this->set(compact('details'));
					$this->Email->to 	  	= $this->data['UserNew']['email'];
					$this->Email->cc		= array('venugopal@caramtec.com','ganesh@carmatec.com');
			        $this->Email->subject 	= 'Welcome to CantoriX!';
			   		$this->Email->replyTo 	= 'admin@cantorix.com';
			    	$this->Email->from 		= 'admin@cantorix.com';
			    	$this->Email->template 	= 'confirm_reset_pass';
			   		$this->Email->sendAs 	= 'html';
			   		if($this->Email->send()) {
			   			$this->Session->setFlash('<div class="alert alert-block alert-success">User has been created successfully and login credentials has been sent to user.</div>');
					} else {
						$this->Session->setFlash('<div class="alert alert-info">User has been created successfully and login credentials couldn\'t send.</div>');
					}
				} else {
					$this->Session->setFlash('<div class="alert alert-danger">Email you entered already exist. Please try other email!</div>');
				}
			} else {
				$this->Session->setFlash('<div class="alert alert-danger">Email you entered already exist. Please try other email!</div>');
			}
			return $this->redirect(array('action'=>'index'));
		}
		/*Add New User Section ends here*/
		
		
		/*Filter Section Code starts here*/
		if($userName) {
			$this->request->data['Filter']['username'] = $userName;
		}
		if($emailId){
			$this->request->data['Filter']['email1'] = $emailId;
		}
		if($role) {
			$this->request->data['Filter']['role'] = $role;
		}
		if(!empty($this->data['Filter'])) {
			if(!empty($this->request->data['Filter']['username'])) {
				$userName = trim($this->request->data['Filter']['username']);
			}
			if(!empty($this->request->data['Filter']['email1'])) {
				$emailId = trim($this->request->data['Filter']['email1']);
			}
			if(!empty($this->request->data['Filter']['role'])) {
				$role = trim($this->request->data['Filter']['role']);
			}
			if(empty($userName) && empty($emailId) && empty($role)) {
				$this->Session->setFlash('<div class="alert alert-info">Please enter atleast one search term.</div>');
				$this->redirect(array('action'=>'index'));
			}

			$condition_array=null; $userName_array=null; $emailId_array=null; $role_array=null;
			if($userName) {
				$userName_array = array('User.user_type' => 'Subscriber','User.username LIKE' => '%'.$userName.'%','User.sbs_subscriber_id'=>$subscriberID);
			}
			if($emailId) {
				$emailId_array = $conditions = array('User.user_type' => 'Subscriber','User.email LIKE' => '%'.$emailId.'%','User.sbs_subscriber_id'=>$subscriberID);
			}
			if($role) {
				$userIds = $userGroup->find('list',array('conditions'=>array('Aro.parent_id'=>$role,'Aro.sbs_subscriber_id'=>$subscriberID),'fields'=>array('Aro.foreign_key','Aro.foreign_key')));
				$role_array = array('User.id' => $userIds,'User.sbs_subscriber_id'=>$subscriberID);
			}
			$conditions=array($userName_array,$emailId_array,$role_array);
			
			$this->Paginator->settings = array(
				'conditions'=> $conditions,'limit' => $limit,'order'=>array('User.id'=>'desc')
			);
		}
		/*Filter Section Code ends here*/
		
		
		
		/*Data listing code Section starts here*/
		$userGroup = $this->Acl->Aro;
		$userGroup->recursive = -1;
		$users = $this->Paginator->paginate('User');
		if(empty($users)) {
			$this->Session->setFlash('<div class="alert alert-info">No users found.</div>');
		}
		foreach($users as $index => $value) {
			$users[$index] = $value;
			$aro_id = $userGroup->find('first',array('conditions'=>array('Aro.foreign_key'=>$value['User']['id'])));
			$users[$index]['usergroup_details'] = $userGroup->find('first',array('conditions'=>array('Aro.id'=>$aro_id['Aro']['parent_id'])));
		}
		$this->set(compact('users','userName','emailId','role','subscriberID'));
		/*Data listing code Section ends here*/
	}

/**
 * @Author Ganesh
 * @Since 27-Jun-2014
 * @Version v.1
 * @Method Edit userdetail (This method used in Users Index -> Inline edit((Method Users/index)) & View User Roles -> Inline edit User(Method Usergroups/view))
 * **/
	public function edit($id=NULL,$subscriberID = NULL,$actionnnn = NULL) {
		if($actionnnn != 'view') {
			$this->permission = $this->Session->read('Auth.AllPermissions.Users');
		} else {
			$this->permission = $this->Session->read('Auth.AllPermissions.Roles');
		}
		if($this->permission['_update'] != 1) {
			$this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$permission = $this->permission;
		$subsID = $this->Session->read('Auth.User.sbs_subscriber_id');
		$userGroup = $this->Acl->Aro;
		if($subscriberID == $subsID) {
			$update['User']['id'] = $this->data['User'][$id]['id'];
			$update['User']['active'] = $this->data['User'][$id]['active'];
			$this->User->save($update);
			
			$AroExist = $userGroup->find('first',array('conditions'=>array('Aro.foreign_key'=>$id),'fields'=>array('Aro.id')));
			if ($AroExist) {
				$userGroup->updateAll(
				    array('Aro.parent_id' => $this->data['User'][$id]['aro_id']),
				    array('Aro.foreign_key' => $id)
				);
			} else {
				$saveAro['Aro']['parent_id'] = $this->data['User'][$id]['aro_id'];
				$saveAro['Aro']['model'] = 'User';
				$saveAro['Aro']['foreign_key'] = $id;
				$saveAro['Aro']['alias'] = $update['User']['email'];
				$saveAro['Aro']['sbs_subscriber_id'] = $subscriberID;
				$userGroup->create();
				$userGroup->save($saveAro);
			}
			$user['User'] = $this->data['User'][$id];
			$user['usergroup_details']['Aro']['id'] = $this->data['User'][$id]['aro_id'];
		} else {
			$user = $this->User->findById($id);
			 $usergroupID = $userGroup->find('first',array('conditions'=>array('Aro.foreign_key'=>$user['User']['id']),'fields'=>array('Aro.parent_id','Aro.alias')));
			$user['usergroup_details']['Aro']['id'] = $usergroupID['Aro']['parent_id'];
		}
		$usergroups = $this->User->getUsergroups('Subscriber',$subsID);
		$this->set(compact('user','usergroups','permission','subsID','actionnnn'));
	}



/**
 * @Author Ganesh
 * @Since 31-Jun-2014
 * @Version v.1
 * @Method Delete subscriber user.
 * **/
	public function delete($id = NULL, $subscriberID = NULL) {
		$this->permission = $this->Session->read('Auth.AllPermissions.Users');
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$subsID = $this->Session->read('Auth.User.sbs_subscriber_id');
		if($subscriberID == $subsID) {
			$Aro = $this->Acl->Aro;
			$Aro->deleteAll(array('Aro.foreign_key'=> $id), FALSE);
			if ($this->User->delete($id)) {
				$this->Session->setFlash(__('<div class="alert alert-block alert-success">User has been deleted!</div>'));
			} else {
				$this->Session->setFlash(__('<div class="alert alert-danger">User could not be deleted. Please, try again.</div>'));
			}
		} else {
			$this->Session->setFlash(__('<div class="alert alert-danger">Error occurred. User could not be deleted. Please, try again.</div>'));
		}
		$this->redirect(array('action' => 'index'));
	}




 
/**
 * @Author Ganesh
 * @Since 27-Jun-2014
 * @Version v.1
 * @Method Activate subscribers.
 * **/	
	public function activateSubscriber($id = NULL,$plan=0,$company=0,$subscriberName = 0,$page = 1) {
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->request->onlyAllow('post', 'activateSubscriber');
		
		$this->loadModel('SbsSubscriber');
		$usersExist = $this->User->find('count',array('conditions'=>array('User.sbs_subscriber_id'=>$id)));
		if(!$usersExist) {
			$result = $this->requestAction(array('controller'=>'pages','action'=>'restoreSubscriber',$id));
		}
		
		$this->SbsSubscriber->recursive = 0;
		$this->loadModel('SbsSubscriber');
		
		$subscriberDetails = $this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$id),
			'fields'=>array('SbsSubscriber.id','SbsSubscriber.profileId')));
		
		/* PAYPAL API  DETAILS */
		$API_UserName 	= $this->API_UserName;
		$API_Password 	= $this->API_Password;
		$API_Signature  = $this->API_Signature;
		
		/*Object of recurring profile*/
		$obj	=	new PaypalRecurringPaymentProfile($API_UserName,$API_Password,$API_Signature);			
		
		/*Reactivate recurring profile*/
		$profileId = $subscriberDetails['SbsSubscriber']['profileId'];
		$action = 'Reactivate';
		$httpParsedResponseAr = $obj->manageProfileStatus($profileId,$action);
		$failed = FALSE;
		if(strtoupper($httpParsedResponseAr['ACK']) == 'SUCCESS') {
			$msg = '<div class="alert alert-block alert-success">Subscriber has been activated!</div>';
			$failed = FALSE;												
		} else {
			$failed = TRUE;
			$msg = '<div class="alert alert-danger">Subscriber couldn\'t be activated.</div>';
		}
		if(!$failed) {
			$data = array('id' => $id, 'status' => 'Active','updation'=>date('Y-m-d'));
			$this->SbsSubscriber->save($data);
			$this->User->updateAll(array('User.active' => "'Y'"),array('User.sbs_subscriber_id' => $id));
		}
		$this->Session->setFlash($msg);
		$this->redirect(array('controller'=>'subscribers','action'=>'index',$plan,$company,$subscriberName,'page:'.$page));
	}
/**
 * @Author Ganesh
 * @Since 26-Jun-2014
 * @Version v.1
 * @Method Cancel subscribers.
 * **/	
	public function cancelSubscriber($id = NULL,$plan=0,$company=0,$subscriberName = 0,$page = 1) {
		
		if($this->permission['_delete'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->request->onlyAllow('post', 'cancelSubscriber');
		$this->SbsSubscriber->recursive = 0;
		$this->loadModel('SbsSubscriber');
		
		$subscriberDetails = $this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$id),
			'fields'=>array('SbsSubscriber.id','SbsSubscriber.profileId')));
		
		/* PAYPAL API  DETAILS */
		$API_UserName 	= $this->API_UserName;
		$API_Password 	= $this->API_Password;
		$API_Signature  = $this->API_Signature;
		
		/*Object of recurring profile*/
		$obj	=	new PaypalRecurringPaymentProfile($API_UserName,$API_Password,$API_Signature);			
		
		/*Suspend recurring profile*/
		$profileId = $subscriberDetails['SbsSubscriber']['profileId'];
		$action = 'Suspend';
		$httpParsedResponseAr = $obj->manageProfileStatus($profileId,$action);
		$failed = FALSE;
		if(strtoupper($httpParsedResponseAr['ACK']) == 'SUCCESS') {
			$msg = '<div class="alert alert-block alert-success">Subscriber has been deactivated!</div>';
			$failed = FALSE;												
		} else {
			$failed = TRUE;
			$msg = '<div class="alert alert-danger">Subscriber couldn\'t be deactivated!</div>';
		}
		if(!$failed) {
			$data = array('id' => $id, 'status' => 'Suspended','updation'=>date('Y-m-d'));
			$this->SbsSubscriber->save($data);
			$this->User->updateAll(array('User.active' => "'N'"),array('User.sbs_subscriber_id' => $id));
		}
		$this->Session->setFlash($msg);
		$this->redirect(array('controller'=>'subscribers','action'=>'index',$plan,$company,$subscriberName,'page:'.$page));
	}


	public function noaccess() {
		
		$this->layout = FALSE;
	}

/**
 * @Author Ganesh
 * @Since 26-Jun-2014
 * @Version v.1
 * @Method Suspend subscribers in paypal.
 * **/	
	public function suspendSubscriberPaypalRecurringProfile($id = NULL,$profileId = NULL,$action = NULL) {
		
		$this->loadModel('SbsSubscriber');
		$this->SbsSubscriber->recursive = 0;
		if(!$profileId) {
			$subscriberDetails = $this->SbsSubscriber->find('first',array('conditions'=>array('SbsSubscriber.id'=>$id),
				'fields'=>array('SbsSubscriber.id','SbsSubscriber.profileId')));
			$profileId = $subscriberDetails['SbsSubscriber']['profileId'];
		} else {
			$profileId = $profileId;
		}
		
		
		/* PAYPAL API  DETAILS */
		$API_UserName 	= $this->API_UserName;
		$API_Password 	= $this->API_Password;
		$API_Signature  = $this->API_Signature;
		
		/*Object of recurring profile*/
		$obj	=	new PaypalRecurringPaymentProfile($API_UserName,$API_Password,$API_Signature);			
		/*Suspend recurring profile*/
		
		if(!$action) {
			$action = 'Suspend';
		}
		$httpParsedResponseAr = $obj->manageProfileStatus($profileId,$action);
		$success = FALSE;
		if(strtoupper($httpParsedResponseAr['ACK']) == 'SUCCESS') {
			$success = TRUE;												
		} else {
			$success = FALSE;
		}
		return $success;
	}


	/**
	 * DONT CHANGE ANYTHING IN THIS FUNCTION
	 * @Author Ganesh
	 * @Method Check out method for change subscription!
	 * */
	function changeSubscriptionCheckout ($controller = NULL, $action = NULL,$typee = NULL) {
		
		$this->autoRender = false; 
		$this->loadModel('CpnSetting');
		
		/* PAYPAL API  DETAILS */
			$API_UserName 	= $this->API_UserName;
			$API_Password 	= $this->API_Password;
			$API_Signature  = $this->API_Signature;
			$API_Endpoint 	= $this->API_Endpoint;
		    $version		= $this->version;
		
		/*SET SUCCESS AND FAIL URL*/
		    $host 	   =  $_SERVER['SERVER_NAME'];		    
			$root      =  $this->webroot; 
			if($typee == 'upgrade') {
				$returnURL = "http://$host$root".'users/changeSubscriptionReviewOrder/1';
				$cancelURL = "http://$host$root".'subscribers/signupFailure';
			} else {
				$returnURL = "http://$host$root".'users/changeSubscriptionReviewOrder';
				$cancelURL = "http://$host$root".'subscribers/signupFailure';
			}
			
		
		/* SET VALUES */
	
		 $environment 					= $this->environment;		
		 $L_BILLINGTYPE0 				= 'RecurringPayments';		
		
		if ($this->request->is('post')) {
			
			$cpnSetting    		= $this->CpnSetting->getAllSettings();
			$currency_code 		= $cpnSetting['CpnSetting']['currency_code']; // currency which is used for subscriber Recurring Billing 
			
			$service_tax     		 = trim($this->data['paymentForm']['serviceTax']);
			$subscription_type       = trim($this->data['paymentForm']['subscriptionType']);
			$bill_amount	         = trim($this->data['paymentForm']['billAmount']);			
			$subscription_cost       = trim($this->data['paymentForm']['subscriptionCost']);
			$initial_amount	         = trim($this->data['paymentForm']['initial_amount']);			
			$profilestartdate        = trim($this->data['paymentForm']['profilestartdate']);
			$splitRow        		 = trim($this->data['paymentForm']['splitRow']);
			$prorata_amount        	 = trim($this->data['paymentForm']['prorata_amount']);
			$init_service_tax        = trim($this->data['paymentForm']['init_service_tax']);
			$subscription_name 		 = $subscription_type.' Subscription';
			
			$currencyName       	 = $this->data['paymentForm']['currency_code'];
			$currencySymbol     	 = $this->data['paymentForm']['currency_symbol_UTF8'];
			
			// store in session for later use
			$this->Session->write('currencyName',$currencyName);			
			$this->Session->write('currencySymbol',$currencySymbol);
			$this->Session->write('subscriptionType',$subscription_type);
			$this->Session->write('cpn_currency',$currency_code);
			$this->Session->write('bill_amount',$bill_amount);
			$this->Session->write('initial_amount',$initial_amount);
			$this->Session->write('profilestartdate',$profilestartdate);
			$this->Session->write('splitRow',$splitRow);
			$this->Session->write('prorata_amount',$prorata_amount);
			$this->Session->write('init_service_tax',$init_service_tax);			
			$amount_threshold   = $this->Session->read('amount_threshold');
			$recurrinBillDate = date("d M Y", strtotime($profilestartdate));						
			$L_BILLINGAGREEMENTDESCRIPTION0 = "$subscription_name : Monthly Recurring Charge (Incl. Tax) = $bill_amount $currency_code with effect from $recurrinBillDate.";
			
			$obj	=	new PaypalRecurring;		
			
			/* PAYPAL API  DETAILS */
			$obj->API_UserName 	= urlencode($API_UserName);
			$obj->API_Password 	= urlencode($API_Password);
			$obj->API_Signature = urlencode($API_Signature);
			$obj->API_Endpoint 	= $API_Endpoint;
			$obj->version 		= urlencode($version);
			
			/*SET SUCCESS AND FAIL URL*/
			$obj->returnURL = urlencode($returnURL);
			$obj->cancelURL = urlencode($cancelURL);
			
			$obj->environment 						=  $environment;	
			$obj->paymentType 						=  urlencode($paymentType);	
			$obj->L_BILLINGTYPE0 					=  $L_BILLINGTYPE0;		
			$obj->L_BILLINGAGREEMENTDESCRIPTION0	=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0);	
			$obj->paymentAmount						=  urlencode($subscription_cost); //Amt
			$obj->taxamount							=  urlencode($service_tax);	
			$obj->currencyID						=  urlencode($currency_code);	
			$obj->L_PAYMENTREQUEST_0_NAME0			=  urlencode($subscription_name);
			$obj->L_PAYMENTREQUEST_0_AMT0			=  urlencode($subscription_cost);
			$obj->L_PAYMENTREQUEST_0_DESC0			=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0);	
			$obj->PAYMENTREQUEST_0_ITEMAMT			=  urlencode($subscription_cost);
			$obj->PAYMENTREQUEST_0_TAXAMT			=  urlencode($service_tax);
			$obj->PAYMENTREQUEST_0_AMT				=  urlencode($bill_amount); // grand total
			$obj->PAYMENTREQUEST_0_CURRENCYCODE		=  urlencode($currency_code);
						
				
			$task = "setExpressCheckout"; //set initial task as Express Checkout			
			$httpParsedResponseAr = $obj->setExpressCheckout();
			$methodError = 'SetExpressCheckout';			
			$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
			$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
			$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
			$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
			
			// store in session for later use
			$this->Session->write('errorCode',$errorCode);			
			$this->Session->write('errorSmallMsg',$errorSmallMsg);
			$this->Session->write('errorLongMsg',$errorLongMsg);	
			$this->Session->write('serverCode',$serverCode);			
			$this->redirect(array('controller'=>$controller,'action' => $action));
			
		}
	}
	

	public function changeSubscriptionReviewOrder ($upgrade = NULL) {
		
		$this->layout = 'sbs_layout';
		$menuActive = 'Change Subscription';
		$settingsActive = 'active';
		$this->set(compact('menuActive','settingsActive'));
		/* PAYPAL API  DETAILS */
			$API_UserName 	= $this->API_UserName;
			$API_Password 	= $this->API_Password;
			$API_Signature  = $this->API_Signature;
			$API_Endpoint 	= $this->API_Endpoint;
		    $version		= $this->version;	
		
		/* SET VALUES */
		 $environment 					= $this->environment;		
		 $L_BILLINGTYPE0 				= 'RecurringPayments';
		
		$obj	=	new PaypalRecurring;		
		
		/* PAYPAL API  DETAILS */
		$obj->API_UserName 	= urlencode($API_UserName);
		
		$obj->API_Password 	= urlencode($API_Password);
		$obj->API_Signature = urlencode($API_Signature);
		$obj->API_Endpoint 	= $API_Endpoint;
		$obj->version 		= urlencode($version);				
		$obj->environment 	=  $environment;		
		$subscriberId = $this->Session->read('Auth.User.SbsSubscriber.id');	
		$task = "getExpressCheckout"; //set initial task as Express Checkout			
		$httpParsedResponseAr = $obj->getExpressCheckout();
		$this->set(compact('upgrade'));
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {			
			$this->set(compact('httpParsedResponseAr'));
		} else  {
			
			$methodError = 'GetExpressCheckoutDetails';			
			$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
			$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
			$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
			$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
			
			// store in session for later use
			$this->Session->write('errorCode',$errorCode);			
			$this->Session->write('errorSmallMsg',$errorSmallMsg);
			$this->Session->write('errorLongMsg',$errorLongMsg);	
			$this->Session->write('serverCode',$serverCode);	
			$this->set(compact('subscriberId'));		
			$this->redirect(array('controller'=>'users','action' => 'changeSubscriptionSignupFailure/'.$methodError));
			
		}		
	}	
	
	function changeSubscriptionMakePayment ($upgradee = NULL) {
		/* PAYPAL API  DETAILS */
			$API_UserName 	= $this->API_UserName;
			$API_Password 	= $this->API_Password;
			$API_Signature  = $this->API_Signature;
			$API_Endpoint 	= $this->API_Endpoint;
		    $version		= $this->version;
				
		/* SET VALUES */
		 $environment 					= $this->environment;		
		 $L_BILLINGTYPE0 				= 'RecurringPayments';
		
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriber');
		$this->loadModel('SbsSubscriberSetting');	
		$this->loadModel('CpnSetting');
						
		if ($this->request->is('post')) {
			$cpnSetting    			= $this->CpnSetting->getAllSettings();
			$currency_code 			= $cpnSetting['CpnSetting']['currency_code'];
			$billing_period			= $cpnSetting['CpnSetting']['billing_period'];
			$billing_frequency		= $cpnSetting['CpnSetting']['billing_frequency'];
			$billing_cycles			= $cpnSetting['CpnSetting']['billing_cycles'];
			$bill_start_day			= $cpnSetting['CpnSetting']['bill_start_day'];
			
			$subscriberId			 = trim($this->data['orderForm']['subscriber_id']);
			$subscription_type		 = trim($this->data['orderForm']['subscriptionType']);
			$subscription_cost		 = trim($this->data['orderForm']['subscriptionCost']);
			$service_tax			 = trim($this->data['orderForm']['serviceTax']);
			$bill_amount			 = trim($this->data['orderForm']['bill_amount']);
			$profilestartdate		 = trim($this->data['orderForm']['profilestartdate']);
			$initial_amount			 = trim($this->data['orderForm']['initial_amount']);
		
			$subscription_name 		 = $subscription_type.' Subscription';			
			
			$currencyName       = $this->Session->read('currencyName');
			$currencySymbol     = $this->Session->read('currencySymbol');	
						
			$subscriber_email	= $this->Session->read('email');			
			$token 				= $this->data['orderForm']['token'];
			$amount_threshold   = $this->Session->read('amount_threshold');
			
			// create recurring Profile 		
			$recurrinBillDate = date("d M Y", strtotime($profilestartdate));
			$L_BILLINGAGREEMENTDESCRIPTION0 = "$subscription_name : Monthly Recurring Charge (Incl. Tax) = $bill_amount $currency_code with effect from $recurrinBillDate.";
			$obj	=	new PaypalRecurring;
			
			/* PAYPAL API  DETAILS */
			$obj->API_UserName 	= urlencode($API_UserName);
			$obj->API_Password 	= urlencode($API_Password);
			$obj->API_Signature = urlencode($API_Signature);
			$obj->API_Endpoint 	= $API_Endpoint;
			$obj->version 		= urlencode($version);			
			
			// Set request-specific fields.
			$obj->startDate 	= urlencode($profilestartdate);
			$obj->billingPeriod = urlencode($billing_period);				
			$obj->billingFreq 	= urlencode($billing_frequency);						
			$obj->paymentAmount = urlencode($subscription_cost);
			$obj->currencyID 	= urlencode($currency_code);			
			$obj->taxamount		= urlencode($service_tax);	
		    $obj->maxfailedpayments 	   = 3;  
		    $obj->autobillamount    	   = 'AddToNextBilling';	  
			$obj->initamount			   = $initial_amount;
			$obj->failedinitamountaction   = 'CancelOnFailure';   //FAILEDINITAMTACTION
			$obj->environment 						=  $environment;	
			$obj->paymentType 						=  urlencode($paymentType);	
			$obj->L_BILLINGTYPE0 					=  $L_BILLINGTYPE0;		
			$obj->L_BILLINGAGREEMENTDESCRIPTION0	=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0);
			
			// creating recurring profile
			$httpParsedResponseAr = $obj->createRecurringPaymentsProfile($token);
		
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {		
			
				$profile_id  	=  urldecode($httpParsedResponseAr["PROFILEID"]);
				$profile_status =  urldecode($httpParsedResponseAr["PROFILESTATUS"]);
				
				switch ($profile_status) {
					case 'ActiveProfile':
						$profile_status = 'Active';	
						break;
					case 'PendingProfile':
						$profile_status = 'Pending';
						break;
					case 'CancelledProfile':
						$profile_status = 'Cancelled';
						break;	
					case 'SuspendedProfile':
						$profile_status = 'Suspended';
						break;	
					case 'ExpiredProfile':
						$profile_status = 'Expired';
						break;												
				}
				// store in session for later use
				$this->Session->write('profile_id',$profile_id);			
				$this->Session->write('profile_status',$profile_status);
				$subscriberId	= $this->Session->read('Auth.User.SbsSubscriber.id');
				$updateSubscriberDetail['SbsSubscriber']['id'] = $subscriberId; 
				$updateSubscriberDetail['SbsSubscriber']['profileId'] = $profile_id;
				$updateSubscriberDetail['SbsSubscriber']['updation'] = date('Y-m-d');
				$updateSubscriberDetail['SbsSubscriber']['status'] = $profile_status;
				if($upgradee) {
					$updateSubscriberDetail['SbsSubscriber']['cpn_subscription_plan_id'] = $this->Session->read('cpn_subscription_plan_id');
				}
				$updateSubscriber = $this->SbsSubscriber->save($updateSubscriberDetail);
				if($updateSubscriber) { 
					// signupSuccess
					$oldProfileId = $this->Session->read('Auth.User.SbsSubscriber.profileId');
					if(!strcmp($oldProfileId, 'NA')) {
						$this->suspendSubscriberPaypalRecurringProfile($subscriberId,$oldProfileId);
					}
					$this->redirect(array('controller'=>'users','action' => 'changeSubscriptionSignupSuccess'));
				} else { 
				  // signupFailure
				  $this->redirect(array('controller'=>'users','action' => 'changeSubscriptionSignupFailure'));
				}
			} else  {
				    // signupFailure
				    $methodError 	= 'createRecurringPaymentsProfile';
					$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
					$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
					$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
					$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
					
					// store in session for later use
					$this->Session->write('errorCode',$errorCode);			
					$this->Session->write('errorSmallMsg',$errorSmallMsg);
					$this->Session->write('errorLongMsg',$errorLongMsg);	
					$this->Session->write('serverCode',$serverCode);			
					$this->redirect(array('controller'=>'users','action' => 'changeSubscriptionSignupFailure/'.$methodError));
			}
		 }
	}
	
	public function changeSubscriptionSignupSuccess () {		
		
		$this->layout = 'sbs_layout';		
		$profile_status = $this->Session->read('profile_status');
		$this->Session->read('bill_amount');
		$menuActive = 'Change Subscription';
		$settingsActive = 'active';
		$this->set(compact('menuActive','settingsActive'));
		$this->set(compact('profile_status','bill_amount'));
	}

	public function changeSubscriptionSignupFailure ($methodError=null) {
		
		$errorCode     = $this->Session->read('errorCode');			
		$errorSmallMsg = $this->Session->read('errorSmallMsg');
		$errorLongMsg  = $this->Session->read('errorLongMsg');
		$serverCode	   = $this->Session->read('serverCode');
		$menuActive = 'Change Subscription';
		$settingsActive = 'active';
		$this->set(compact('menuActive','settingsActive'));
		$this->set(compact('errorCode','errorSmallMsg','errorLongMsg','serverCode','methodError'));		
	}
	
	// if Paid Plan
	public function paymentDetailRenewal ($cpn_subscription_plan_id = null) {
		
		$this->loadModel('CpnSubscriptionPlan');
		$this->loadModel('CpnSetting');
		
		$cpnSetting    			    = $this->CpnSetting->getAllSettings();
		$subscriptionPlan  			= $this->CpnSubscriptionPlan->getSubscriptionNameById($cpn_subscription_plan_id);
		$this->Session->write('cpn_subscription_plan_id',$cpn_subscription_plan_id);
		$bill_start_day			   = $cpnSetting['CpnSetting']['bill_start_day'];
		$i=0;   
    	if($bill_start_day <=9) {$bill_start_day = $i.$bill_start_day;} 
    	else {$bill_start_day = $bill_start_day;}
		$amount_threshold		= $cpnSetting['CpnSetting']['amount_threshold'];
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
		
		// First payment on the day of subscribe
		$tdyDate 		= date('d');
		$lastDayOfMonth = date('t');
		$dayRemaining 	= $lastDayOfMonth - $tdyDate;
		
		$prorata_amount			 = ($subscription_cost/$lastDayOfMonth)*$dayRemaining;
		$prorata_amount			 = money_format('%!(.2n',$prorata_amount);
		$init_service_tax		 = $prorata_amount*($service_tax_percenage/100);
		$init_service_tax		 = money_format('%!(.2n',$init_service_tax);
		$initial_amount			 = $prorata_amount + $init_service_tax;
		$initial_amount			 = money_format('%!(.2n',$initial_amount);
		
		
		if($initial_amount < $amount_threshold) {
			
			$initial_amount		= 0.00;
			$prorata_amount		= 0.00;
			$init_service_tax	= 0.00;
			
			$billdateAr   = date("Y-m", strtotime("+1 month"));
			$bd 		  = explode('-', $billdateAr); 
			$year  = $bd[0];
			$month = $bd[1];
			$day   = $bill_start_day;
			$billdate = $year.'-'.$month.'-'.$day;
		
			$billBegins = gmdate("$billdate\TH:i:s\Z");
			$profilestartdate = $billBegins;
			$splitRow = 1;			
		} else {
			$initial_amount = $initial_amount;
			$billdateAr   = date("Y-m", strtotime("+1 month"));
			$bd 		  = explode('-', $billdateAr); 
			$year  = $bd[0];
			$month = $bd[1];
			$day   = $bill_start_day;
			$billdate = $year.'-'.$month.'-'.$day;
			
			$billBegins = gmdate("$billdate\TH:i:s\Z");
			$profilestartdate = $billBegins;
			$splitRow = 1;
		}		
		
		$visitorDetails 	= $this->getVisitorDetails();
		$countries = $this->countryList();				
		
		$this->set(compact('countries','visitorDetails','subscriptionType','subscriptionCost','serviceTax','billAmount','initial_amount','profilestartdate','splitRow','prorata_amount','init_service_tax','amount_threshold'));	
			
	}


	function paidCheckoutRenewal () {		
		
		$this->autoRender = false; 
		$this->loadModel('CpnSetting');
		
		/* PAYPAL API  DETAILS */
			$API_UserName 	= $this->API_UserName;
			$API_Password 	= $this->API_Password;
			$API_Signature  = $this->API_Signature;
			$API_Endpoint 	= $this->API_Endpoint;
		    $version		= $this->version;
		
		/*SET SUCCESS AND FAIL URL*/
		    $host 	   =  $_SERVER['SERVER_NAME'];		    
			$root      =  $this->webroot; 
			$returnURL = "http://$host$root".'users/reviewOrderRenewal';
			$cancelURL = "http://$host$root".'users/signupFailure';
		
		/* SET VALUES */
		// $paymentType 				= 'Sale';	// PAYMENTACTION
		 $environment 					= $this->environment;		
		 $L_BILLINGTYPE0 				= 'RecurringPayments';		
		
		if ($this->request->is('post')) {
			
			$cpnSetting    		= $this->CpnSetting->getAllSettings();
			$currency_code 		= $cpnSetting['CpnSetting']['currency_code']; // currency which is used for subscriber Recurring Billing 
			
			$service_tax     		 = trim($this->data['paymentForm']['serviceTax']);
			$subscription_type       = trim($this->data['paymentForm']['subscriptionType']);
			$bill_amount	         = trim($this->data['paymentForm']['billAmount']);			
			$subscription_cost       = trim($this->data['paymentForm']['subscriptionCost']);
			$initial_amount	         = trim($this->data['paymentForm']['initial_amount']);			
			$profilestartdate        = trim($this->data['paymentForm']['profilestartdate']);
			$splitRow        		 = trim($this->data['paymentForm']['splitRow']);
			$prorata_amount        	 = trim($this->data['paymentForm']['prorata_amount']);
			$init_service_tax        = trim($this->data['paymentForm']['init_service_tax']);
			$subscription_name 		 = $subscription_type.' Subscription';
			
			$currencyName       	 = $this->data['paymentForm']['currency_code'];
			$currencySymbol     	 = $this->data['paymentForm']['currency_symbol_UTF8'];
			
			// store in session for later use
			$this->Session->write('currencyName',$currencyName);			
			$this->Session->write('currencySymbol',$currencySymbol);
			$this->Session->write('subscriptionType',$subscription_type);
			$this->Session->write('cpn_currency',$currency_code);
			$this->Session->write('bill_amount',$bill_amount);
			$this->Session->write('initial_amount',$initial_amount);
			$this->Session->write('profilestartdate',$profilestartdate);
			$this->Session->write('splitRow',$splitRow);
			$this->Session->write('prorata_amount',$prorata_amount);
			$this->Session->write('init_service_tax',$init_service_tax);			
			$amount_threshold   = $this->Session->read('amount_threshold');
			$recurrinBillDate = date("d M Y", strtotime($profilestartdate));						
			$L_BILLINGAGREEMENTDESCRIPTION0 = "$subscription_name : Monthly Recurring Charge (Incl. Tax) = $bill_amount $currency_code with effect from $recurrinBillDate.";
			
			$obj	=	new PaypalRecurring;		
			
			/* PAYPAL API  DETAILS */
			$obj->API_UserName 	= urlencode($API_UserName);
			$obj->API_Password 	= urlencode($API_Password);
			$obj->API_Signature = urlencode($API_Signature);
			$obj->API_Endpoint 	= $API_Endpoint;
			$obj->version 		= urlencode($version);
			
			/*SET SUCCESS AND FAIL URL*/
			$obj->returnURL = urlencode($returnURL);
			$obj->cancelURL = urlencode($cancelURL);
			
			$obj->environment 						=  $environment;	
			$obj->paymentType 						=  urlencode($paymentType);	
			$obj->L_BILLINGTYPE0 					=  $L_BILLINGTYPE0;		
			$obj->L_BILLINGAGREEMENTDESCRIPTION0	=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0);	
			$obj->paymentAmount						=  urlencode($subscription_cost); //Amt
			$obj->taxamount							=  urlencode($service_tax);	
			$obj->currencyID						=  urlencode($currency_code);	
			$obj->L_PAYMENTREQUEST_0_NAME0			=  urlencode($subscription_name);
			$obj->L_PAYMENTREQUEST_0_AMT0			=  urlencode($subscription_cost);
			$obj->L_PAYMENTREQUEST_0_DESC0			=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0);	
			$obj->PAYMENTREQUEST_0_ITEMAMT			=  urlencode($subscription_cost);
			$obj->PAYMENTREQUEST_0_TAXAMT			=  urlencode($service_tax);
			$obj->PAYMENTREQUEST_0_AMT				=  urlencode($bill_amount); // grand total
			$obj->PAYMENTREQUEST_0_CURRENCYCODE		=  urlencode($currency_code);
									
				
			$task = "setExpressCheckout"; //set initial task as Express Checkout			
			$httpParsedResponseAr = $obj->setExpressCheckout();
			$methodError = 'SetExpressCheckout';			
			$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
			$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
			$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
			$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
			
			// store in session for later use
			$this->Session->write('errorCode',$errorCode);			
			$this->Session->write('errorSmallMsg',$errorSmallMsg);
			$this->Session->write('errorLongMsg',$errorLongMsg);	
			$this->Session->write('serverCode',$serverCode);			
			$this->redirect(array('controller'=>'users','action' => 'signupFailure/'.$methodError));
			
		}
	}
	
	public function reviewOrderRenewal () {
		
		/* PAYPAL API  DETAILS */
			$API_UserName 	= $this->API_UserName;
			$API_Password 	= $this->API_Password;
			$API_Signature  = $this->API_Signature;
			$API_Endpoint 	= $this->API_Endpoint;
		    $version		= $this->version;	
		
		/* SET VALUES */
		 $environment 					= $this->environment;		
		 $L_BILLINGTYPE0 				= 'RecurringPayments';
		
		$obj	=	new PaypalRecurring;		
		
		/* PAYPAL API  DETAILS */
		$obj->API_UserName 	= urlencode($API_UserName);
		$obj->API_Password 	= urlencode($API_Password);
		$obj->API_Signature = urlencode($API_Signature);
		$obj->API_Endpoint 	= $API_Endpoint;
		$obj->version 		= urlencode($version);				
		$obj->environment 	=  $environment;		
			
		$task = "getExpressCheckout"; //set initial task as Express Checkout			
		$httpParsedResponseAr = $obj->getExpressCheckout();
		
		if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {			
			$this->set(compact('httpParsedResponseAr'));
		} else  {
		
			$methodError = 'GetExpressCheckoutDetails';			
			$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
			$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
			$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
			$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
			
			// store in session for later use
			$this->Session->write('errorCode',$errorCode);			
			$this->Session->write('errorSmallMsg',$errorSmallMsg);
			$this->Session->write('errorLongMsg',$errorLongMsg);	
			$this->Session->write('serverCode',$serverCode);			
			$this->redirect(array('controller'=>'users','action' => 'signupFailure/'.$methodError));
			
		}		
	}
	
	
	function makePaymentRenewal () {
	
		/* PAYPAL API  DETAILS */
			$API_UserName 	= $this->API_UserName;
			$API_Password 	= $this->API_Password;
			$API_Signature  = $this->API_Signature;
			$API_Endpoint 	= $this->API_Endpoint;
		    $version		= $this->version;
				
		/* SET VALUES */
		 $environment 					= $this->environment;		
		 $L_BILLINGTYPE0 				= 'RecurringPayments';
		
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('SbsSubscriber');
		$this->loadModel('SbsSubscriberSetting');	
		$this->loadModel('CpnSetting');
						
		if ($this->request->is('post')) {
			
			$cpnSetting    			= $this->CpnSetting->getAllSettings();
			
			$currency_code 			= $cpnSetting['CpnSetting']['currency_code'];
			$billing_period			= $cpnSetting['CpnSetting']['billing_period'];
			$billing_frequency		= $cpnSetting['CpnSetting']['billing_frequency'];
			$billing_cycles			= $cpnSetting['CpnSetting']['billing_cycles'];
			$bill_start_day			= $cpnSetting['CpnSetting']['bill_start_day'];
			
			$subscription_type		 = trim($this->data['orderForm']['subscriptionType']);
			$subscription_cost		 = trim($this->data['orderForm']['subscriptionCost']);
			$service_tax			 = trim($this->data['orderForm']['serviceTax']);
			$bill_amount			 = trim($this->data['orderForm']['bill_amount']);
			$profilestartdate		 = trim($this->data['orderForm']['profilestartdate']);
			$initial_amount			 = trim($this->data['orderForm']['initial_amount']);
			
			$subscription_name 		 = $subscription_type.' Subscription';			
			
			// billing shipping same			
			$billing_address_line1   = trim($this->data['orderForm']['street1']);
			$billing_city            = trim($this->data['orderForm']['city_name']);
			$billing_state           = trim($this->data['orderForm']['state_province']);
			$billing_country         = trim($this->data['orderForm']['country_name']);
			$billing_country_code	 = trim($this->data['orderForm']['country_code']);
			$billing_zip             = trim($this->data['orderForm']['postal_code']);
			
			
			$currencyName       = $this->Session->read('currencyName');
			$currencySymbol     = $this->Session->read('currencySymbol');	
						
			$subscriber_email	= $this->Session->read('email');			
			$token 				= $this->data['orderForm']['token'];
			$amount_threshold   = $this->Session->read('amount_threshold');
			// create recurring Profile 		
			$recurrinBillDate = date("d M Y", strtotime($profilestartdate));
			$L_BILLINGAGREEMENTDESCRIPTION0 = "$subscription_name : Monthly Recurring Charge (Incl. Tax) = $bill_amount $currency_code with effect from $recurrinBillDate.";
			$obj	=	new PaypalRecurring;
			
			/* PAYPAL API  DETAILS */
			$obj->API_UserName 	= urlencode($API_UserName);
			$obj->API_Password 	= urlencode($API_Password);
			$obj->API_Signature = urlencode($API_Signature);
			$obj->API_Endpoint 	= $API_Endpoint;
			$obj->version 		= urlencode($version);			
			
			// Set request-specific fields.
			$obj->startDate 	= urlencode($profilestartdate);
			$obj->billingPeriod = urlencode($billing_period);				
			$obj->billingFreq 	= urlencode($billing_frequency);						
			$obj->paymentAmount = urlencode($subscription_cost);
			$obj->currencyID 	= urlencode($currency_code);			
			$obj->taxamount		= urlencode($service_tax);	
		    $obj->maxfailedpayments 	   = 3;  
		    $obj->autobillamount    	   = 'AddToNextBilling';	  
			$obj->initamount			   = $initial_amount;
			$obj->failedinitamountaction   = 'CancelOnFailure';   //FAILEDINITAMTACTION
			$obj->environment 						=  $environment;	
			$obj->paymentType 						=  urlencode($paymentType);	
			$obj->L_BILLINGTYPE0 					=  $L_BILLINGTYPE0;		
			$obj->L_BILLINGAGREEMENTDESCRIPTION0	=  urlencode($L_BILLINGAGREEMENTDESCRIPTION0); 
			// creating recurring profile
			$httpParsedResponseAr = $obj->createRecurringPaymentsProfile($token);
			
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {		
			
				$profile_id  	=  urldecode($httpParsedResponseAr["PROFILEID"]);
				$profile_status =  urldecode($httpParsedResponseAr["PROFILESTATUS"]);
				
				switch ($profile_status) {
					case 'ActiveProfile':
						$profile_status = 'Active';	
						break;
					case 'PendingProfile':
						$profile_status = 'Pending';
						break;
					case 'CancelledProfile':
						$profile_status = 'Cancelled';
						break;	
					case 'SuspendedProfile':
						$profile_status = 'Suspended';
						break;	
					case 'ExpiredProfile':
						$profile_status = 'Expired';
						break;												
				}
				
				// store in session for later use
				$this->Session->write('profile_id',$profile_id);			
				$this->Session->write('profile_status',$profile_status);
				$subscriberId	= $this->Session->read('Upgrade.Auth.User.SbsSubscriber.id');
				$updateSubscriberDetail['SbsSubscriber']['id'] = $subscriberId; 
				$updateSubscriberDetail['SbsSubscriber']['profileId'] = $profile_id;
				$updateSubscriberDetail['SbsSubscriber']['updation'] = date('Y-m-d');
				$updateSubscriberDetail['SbsSubscriber']['status'] = $profile_status;
				$updateSubscriberDetail['SbsSubscriber']['cpn_subscription_plan_id'] = $this->Session->read('cpn_subscription_plan_id');
				$updateSubscriberDetail['SbsSubscriber']['rp_startdate'] = $this->Session->read('profile_status');
				$updateSubscriber = $this->SbsSubscriber->save($updateSubscriberDetail);
				if($updateSubscriber) {
					// signupSuccess									
					$this->redirect(array('controller'=>'users','action' => 'signupSuccess'));				
				} else { 
					// signupFailure
					$this->redirect(array('controller'=>'users','action' => 'signupFailure'));
				}					 
				
			} else {
				    // signupFailure
				    $methodError 	= 'createRecurringPaymentsProfile';
					$errorCode  	=  urldecode($httpParsedResponseAr["L_ERRORCODE0"]);
					$errorSmallMsg  =  urldecode($httpParsedResponseAr["L_SHORTMESSAGE0"]);
					$errorLongMsg   =  urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]);
					$serverCode     =  urldecode($httpParsedResponseAr["L_SEVERITYCODE0"]);
					
					// store in session for later use
					$this->Session->write('errorCode',$errorCode);			
					$this->Session->write('errorSmallMsg',$errorSmallMsg);
					$this->Session->write('errorLongMsg',$errorLongMsg);	
					$this->Session->write('serverCode',$serverCode);			
					$this->redirect(array('controller'=>'users','action' => 'signupFailure/'.$methodError));
			}
		 }
	}	

	
	public function dashboard() {
		//Configure::write('debug',2);
		$this->permission = $this->Session->read('Auth.AllPermissions.Dashboard');
		if($this->permission['_read'] != 1) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$title_for_layout = 'Dashboard';
		$this->layout = 'sbs_layout';
		$dashboardActive = 'active';
		$this->set(compact('dashboardActive','title_for_layout'));
		$userDetails = $this->Session->read('Auth');
		$subscriberID = $userDetails['User']['sbs_subscriber_id'];
		$this->loadModel('CpnSubscriptionPlan');
		$this->loadModel('AcrClient');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('AcrInvoicePaymentDetail');
		
		/*******************************Breadcrum Section************************************/
		$topFinal['currentPlanDetails'] = $this->CpnSubscriptionPlan->getPlanDetails($userDetails['User']['SbsSubscriber']['cpn_subscription_plan_id']);
		$topFinal['customersCount'] 	= $this->AcrClient->getCustomerCount($subscriberID);
		$topFinal['staffsCount'] 		= $this->User->getActiveUserCount($subscriberID);
		$topFinal['invoicesCount'] 		= $this->AcrClientInvoice->getActiveInvoiceCount($subscriberID);
		/*******************************Breadcrum Section************************************/
		
		
		/*******************************Current Month Snapshot*******************************/
		$currentMonth = date('Y-m');
		$row1Left['totalInvoices'] 		= $this->AcrClientInvoice->find('first',array('fields'=>array('SUM(func_currency_total) as total'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'invoiced_date LIKE'=>$currentMonth.'%','NOT'=>array('status'=>'Canceled'))));
		$exchangeRates[0]				= $this->AcrClientInvoice->find('list',array('fields'=>array('id','exchange_rate'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'invoiced_date LIKE'=>$currentMonth.'%','NOT'=>array('status'=>'Canceled'))));
		//$row1Left['totalPayments']		= $this->AcrInvoicePaymentDetail->getPayments($exchangeRates);
		$paymentsMadeCurrentMonth 		= $this->AcrInvoicePaymentDetail->find('all',array('fields'=>array('SUM(paid_amount) as paidAmount','acr_client_invoice_id'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'is_deleted'=>'no','payment_date LIKE'=>$currentMonth.'%'),'group'=>array('acr_client_invoice_id')));
		foreach ($paymentsMadeCurrentMonth as $paymentMonth) {
			$invoiceDetailMonth  = $this->AcrClientInvoice->find('first',array('fields'=>array('id','exchange_rate'),'conditions'=>array('id'=>$paymentMonth['AcrInvoicePaymentDetail']['acr_client_invoice_id'])));
			$paidAmountMonth		+= ($paymentMonth[0]['paidAmount'] / $invoiceDetailMonth['AcrClientInvoice']['exchange_rate']);
		}
		$row1Left['totalPayments'] = $paidAmountMonth;
		
		$row1Left['totalExpenses'] 		= '0';
		$invoiceDetail = NULL;
		/*******************************Current Month Snapshot*******************************/
		
		
		/*******************************Receivables Analysis*********************************/
		$recievableInvoices					= $this->AcrClientInvoice->find('all',array('fields'=>array('id','exchange_rate','invoice_total'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'NOT'=>array('status'=>'Canceled'))));
		$recievableAmount = 0;
		foreach ($recievableInvoices as $invoiceDetail) {
			$paymentsMade 					= $this->AcrInvoicePaymentDetail->find('first',array('fields'=>array('SUM(paid_amount) as paidAmount'),'conditions'=>array('acr_client_invoice_id'=>$invoiceDetail['AcrClientInvoice']['id'],'is_deleted'=>'no')));
			$recievableAmount 				+= (($invoiceDetail['AcrClientInvoice']['invoice_total'] - $paymentsMade[0]['paidAmount']) / $invoiceDetail['AcrClientInvoice']['exchange_rate']);
		}
		$row1Right['totalRecievable'] 		= $recievableAmount;
		
		$recievableOverDueInvoices			= $this->AcrClientInvoice->find('all',array('fields'=>array('id','exchange_rate','invoice_total'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'NOT'=>array('status'=>'Canceled'),'due_date <'=>date('Y-m-d'))));
		$recievableOverDueAmount = 0;
		foreach ($recievableOverDueInvoices as $overDueInvoiceDetail) {
			$paymentsMade 					= $this->AcrInvoicePaymentDetail->find('first',array('fields'=>array('SUM(paid_amount) as paidAmount'),'conditions'=>array('acr_client_invoice_id'=>$overDueInvoiceDetail['AcrClientInvoice']['id'],'is_deleted'=>'no')));
			$overDuerecievableAmount 		+= (($overDueInvoiceDetail['AcrClientInvoice']['invoice_total'] - $paymentsMade[0]['paidAmount']) / $overDueInvoiceDetail['AcrClientInvoice']['exchange_rate']);
		}
		$row1Right['totalOverDue']	 		= $overDuerecievableAmount;
		
		
		$recievableDueInvoices				= $this->AcrClientInvoice->find('all',array('fields'=>array('id','exchange_rate','invoice_total'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'NOT'=>array('status'=>'Canceled'),'due_date >='=>date('Y-m-d'))));
		$recievableDueAmount = 0;
		foreach ($recievableDueInvoices as $dueInvoiceDetail) {
			$paymentsMade 					= $this->AcrInvoicePaymentDetail->find('first',array('fields'=>array('SUM(paid_amount) as paidAmount'),'conditions'=>array('acr_client_invoice_id'=>$dueInvoiceDetail['AcrClientInvoice']['id'],'is_deleted'=>'no')));
			$recievableDueAmount 			+= (($dueInvoiceDetail['AcrClientInvoice']['invoice_total'] - $paymentsMade[0]['paidAmount']) / $dueInvoiceDetail['AcrClientInvoice']['exchange_rate']);
		}
		$row1Right['totalDue']	 			= $recievableDueAmount;
		/*******************************Receivables Analysis*********************************/
		
		
		/*******************************Fiscal Year Analysis*********************************/
		//This comes calculated in dashboardGraph method and view is in Elements -> client_dashboard_graph.ctp
		/*******************************Fiscal Year Analysis*********************************/
		
		
		/*******************************Unpaid Invoices**************************************/
			$recievableCurrentDueInvoices		= $this->AcrClientInvoice->find('all',array('fields'=>array('id','exchange_rate','invoice_total'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'NOT'=>array('status'=>'Canceled'),'due_date >'=>date('Y-m-d'))));
			$recievableCurrentAmount = 0;
			foreach ($recievableCurrentDueInvoices as $currentInvoiceDetail) {
				$paymentsMade 					= $this->AcrInvoicePaymentDetail->find('first',array('fields'=>array('SUM(paid_amount) as paidAmount'),'conditions'=>array('acr_client_invoice_id'=>$currentInvoiceDetail['AcrClientInvoice']['id'],'is_deleted'=>'no')));
				$recievableCurrentAmount 		+= (($currentInvoiceDetail['AcrClientInvoice']['invoice_total'] - $paymentsMade[0]['paidAmount']) / $currentInvoiceDetail['AcrClientInvoice']['exchange_rate']);
			}
			$row3Left['totalCurrent']	 		= $recievableCurrentAmount;
			$currentDueInvoices					= $this->AcrClientInvoice->find('all',array('fields'=>array('id','exchange_rate','invoice_total'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'NOT'=>array('status'=>'Canceled'),'due_date'=>date('Y-m-d'))));
			$currentDueAmount = 0;
			foreach ($currentDueInvoices as $currentDueInvoice) {
				$paymentsMade 					= $this->AcrInvoicePaymentDetail->find('first',array('fields'=>array('SUM(paid_amount) as paidAmount'),'conditions'=>array('acr_client_invoice_id'=>$currentDueInvoice['AcrClientInvoice']['id'],'is_deleted'=>'no')));
				$currentDueAmount 				+= (($currentDueInvoice['AcrClientInvoice']['invoice_total'] - $paymentsMade[0]['paidAmount']) / $currentDueInvoice['AcrClientInvoice']['exchange_rate']);
			}
			$row3Left['totaldue']	 			= $currentDueAmount;
			
			$this->loadModel('SbsAgingBucket');
			$agingBuckets				= $this->SbsAgingBucket->find('first',array('conditions'=>array('sbs_subscriber_id'=>$subscriberID)));
			if(!empty($agingBuckets['SbsAgingBucket']['bucket1'])) { $bucket[1] = $agingBuckets['SbsAgingBucket']['bucket1']; } else {$bucket[1] = '0-30';}
			if(!empty($agingBuckets['SbsAgingBucket']['bucket2'])) { $bucket[2] = $agingBuckets['SbsAgingBucket']['bucket2']; } else { $bucket[2] = '30-60';}
			if(!empty($agingBuckets['SbsAgingBucket']['bucket3'])) { $bucket[3] = $agingBuckets['SbsAgingBucket']['bucket3']; } else { $bucket[3] = '60-90';}
			if(!empty($agingBuckets['SbsAgingBucket']['bucket4'])) { $bucket[4] = $agingBuckets['SbsAgingBucket']['bucket4']; } else { $bucket[4] = '90+';}
			$exp[1] 					= explode('-', $bucket[1]);
			$from[1]					= date('Y-m-d', strtotime('today - '.$exp[1][1].' days'));
			$to[1] 						= date('Y-m-d');
			for ($icount=1; $icount <= 4; $icount++) {
				$exp[$icount] = explode('-', $bucket[$icount]);
				$difference[$icount] = $exp[$icount][1] - $exp[$icount][0];
				if($icount != 1) $from[$icount]		= date('Y-m-d', strtotime($from[$icount-1].' - '.$difference[$icount].' days'));
				if($icount != 1) $to[$icount] 		= $from[$icount-1];
				if(!empty($exp[$icount][1])) {
					$agingBucketsInv[$icount]				= $this->AcrClientInvoice->find('all',array('fields'=>array('id','exchange_rate','invoice_total'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'NOT'=>array('status'=>'Canceled'),'due_date BETWEEN ? AND ? '=>array($from[$icount],$to[$icount]))));
				} else {
					$agingBucketsInv[$icount]				= $this->AcrClientInvoice->find('all',array('fields'=>array('id','exchange_rate','invoice_total'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'NOT'=>array('status'=>'Canceled'),'due_date <='=>$from[$icount])));
				}
				foreach ($agingBucketsInv[$icount] as $agingBucketDetail[$icount]) {
					$paymentsMade 					= $this->AcrInvoicePaymentDetail->find('first',array('fields'=>array('SUM(paid_amount) as paidAmount'),'conditions'=>array('acr_client_invoice_id'=>$agingBucketDetail[$icount]['AcrClientInvoice']['id'],'is_deleted'=>'no')));
					$agingBucketAmount[$icount] 	+= (($agingBucketDetail[$icount]['AcrClientInvoice']['invoice_total'] - $paymentsMade[0]['paidAmount']) / $agingBucketDetail[$icount]['AcrClientInvoice']['exchange_rate']);
				}
				$row3Right['agingBucket'.$icount]	 = $agingBucketAmount[$icount];
			}
			$row3Right['agingBucketsLabel']			= $agingBuckets['SbsAgingBucket'];
		/*******************************Unpaid Invoices**************************************/
		
		
		/*******************************Top Ten Customers************************************/
		//This comes calculated in dashboardCustomerGraph method and view is in Elements -> customer_dashboard_graph.ctp
		/*******************************Top Ten Customers************************************/
		
		
		/*******************************Top Ten Expenses*************************************/
		
		/*******************************Top Ten Expenses*************************************/
		
		$this->set(compact('topFinal','subscriberID','row1Left','row1Right','row3Left','row3Right'));
	}
	
	
	public function getPeriod($formData = NULL) {
	
		$organisationID = $this->Session->read('Auth.User.SbsSubscriber.sbs_subscriber_organization_detail_id');
		$this->loadModel('SbsSubscriberOrganizationDetail');
		$this->loadModel('AcrClientInvoice');
		$this->loadModel('AcrInvoicePaymentDetail');
		$this->SbsSubscriberOrganizationDetail->recursive = 0;
		$this->SbsSubscriberOrganizationDetail->unbindModel(array('belongsTo'=>array('CpnLanguage','CpnCurrency')));
		$currMonth = date('m');
		switch ($formData) {
			case 'Current Calendar':
				$fromYear 		= date('Y'); 	$toYear		= date('Y')+1;
				$fromMonth		= 'Jan'; 		$toMonth	= 'Dec'; 		$text2	= 'Current';
				break;
			case 'Previous Calendar':
				$fromYear 	= date('Y')-1; 		$toYear		= date('Y');
				$fromMonth		= 'Jan'; 		$toMonth	= 'Dec';		$text2	= 'Previous';
				break;
			case 'Current Financial':
				$organisationDetail = $this->SbsSubscriberOrganizationDetail->findById($organisationID,array('CpnFinancialYear.*'));
				$fromMonth		= date('m',strtotime($organisationDetail['CpnFinancialYear']['from_month']));
				$toMonth		= date('m',strtotime($organisationDetail['CpnFinancialYear']['to_month']));
				if($currMonth < $fromMonth) {
					$fromYear 	= date('Y')-1; 	$toYear		= date('Y');
				} elseif($toMonth == '12'){
					$fromYear 	= date('Y'); 	$toYear		= date('Y');
				} else {
					$fromYear 	= date('Y'); 	$toYear		= date('Y')+1;
				}
				$text2			= 'Current';
				break;
			case 'Previous Financial':
				$organisationDetail = $this->SbsSubscriberOrganizationDetail->findById($organisationID,array('CpnFinancialYear.*'));
				$fromMonth		= date('m',strtotime($organisationDetail['CpnFinancialYear']['from_month']));
				$toMonth		= date('m',strtotime($organisationDetail['CpnFinancialYear']['to_month']));
				if($currMonth < $fromMonth) {
					$fromYear 	= date('Y')-2; 	$toYear		= date('Y')-1;
				}
				if($currMonth < $fromMonth) {
					$fromYear 	= date('Y')-2; 	$toYear		= date('Y')-1;
				} elseif($toMonth == '12'){
					$fromYear 	= date('Y')-1; 	$toYear		= date('Y')-1;
				} else {
					$fromYear 	= date('Y')-1; 	$toYear		= date('Y');
				}
				$text2			= 'Previous';
				break;
			case 'Current Month':
				$fromYear = $toYear	= date('Y');
				$fromMonth = $toMonth = date('m');
				break;
			case 'Previous Month':
				if($currMonth == 1) {
					$fromMonth = 12; $toMonth = 12;
					$fromYear = $toYear = date('Y') -1 ;
				} else {
					$fromMonth = $toMonth = date('m') -1;
					$fromYear = $toYear = date('Y');
				}
				break;
			default:
				$fromYear 		= date('Y');	$toYear			= date('Y');
				$fromMonth		= '01';		$toMonth		= '12';		$text2			= 'Current';
				
				break;
		}
		$start = new DateTime($fromYear.'-'.$fromMonth);
		if($toMonth == 12){
			$toMonth = '01';
			$toYear +=1;
		} else {
			$toMonth = $toMonth+1;
		}		
		$end = new DateTime($toYear.'-'.($toMonth));
		$interval = DateInterval::createFromDateString('1 month'); 
		$period = new DatePeriod($start, $interval, $end);
		$final['period'] = $period;
		$final['text2']  = $text2;
		return $final;
	}
	
	public function dashboardGraph() {
		$subscriberID = $this->Session->read('Auth.User.SbsSubscriber.id');
		if(!empty($this->data['Dashboard']['graphFiscalYear'])) {
			$period = $this->getPeriod($this->data['Dashboard']['graphFiscalYear']);
		} else {
			$period = $this->getPeriod();
		}
		
		foreach ($period['period'] as $dt) {
			$monthArray[] 		= $dt->format("M");		
			$dateArray[]		= $dt->format('Y-m');
			$invoiceArray[] 	= $this->AcrClientInvoice->find('first',array('fields'=>array('SUM(func_currency_total) as total'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'NOT'=>array('status'=>'Canceled'),'invoiced_date LIKE'=>$dt->format('Y-m').'%')));
			$paidAmount = 0;
			$paymentsMade 		= $this->AcrInvoicePaymentDetail->find('all',array('fields'=>array('SUM(paid_amount) as paidAmount','acr_client_invoice_id'),'conditions'=>array('sbs_subscriber_id'=>$subscriberID,'is_deleted'=>'no','payment_date LIKE'=>$dt->format('Y-m').'%'),'group'=>array('acr_client_invoice_id')));
			foreach ($paymentsMade as $payment) {
				$invoiceDetail  = $this->AcrClientInvoice->find('first',array('fields'=>array('id','exchange_rate'),'conditions'=>array('id'=>$payment['AcrInvoicePaymentDetail']['acr_client_invoice_id'])));
				$paidAmount		+= ($payment[0]['paidAmount'] / $invoiceDetail['AcrClientInvoice']['exchange_rate']);
			}
			$paymentArray[] = $paidAmount;
		}
		$text 			= $this->data['Dashboard']['graphFiscalYear'];
		$text2			= $period['text2'];
		
		$final['monthArray'] 			= $monthArray;
		$final['invoiceArray']			= $invoiceArray;
		$final['paymentArray']			= $paymentArray;
		$this->set(compact('text','text2'));
		return $final;
	}


	public function dashboardCustomerGraph() {
		$subscriberID = $this->Session->read('Auth.User.SbsSubscriber.id');
		if(empty($this->data['Dashboard']['customerGraph'])) {
			$this->request->data['Dashboard']['customerGraph'] = 'Current Month';
		}
		$period = $this->getPeriod($this->data['Dashboard']['customerGraph']);
		$this->loadModel('AccountInvoice');
		$i = 1;
		foreach ($period['period'] as $dt) {
			if($i==1) $fromDate	= $dt->format('Y-m').'-01';
			$i = 2;
			$toDate		= $dt->format('Y-m-t');
			$totalINVAmount[]	= $customInvoice;
		}
		$this->AcrClientInvoice->recursive = 0;
		$this->AcrClientInvoice->unbindModel(array('belongsTo'=>array('SbsSubscriberPaymentTerm','SbsSubscriber','')));
		$customerInvoice 		= $this->AcrClientInvoice->find('all',array(
				'fields'=>array('SUM(func_currency_total) as total','AcrClientInvoice.acr_client_id','AcrClient.client_name'),
				'conditions'=>array('AcrClientInvoice.sbs_subscriber_id'=>$subscriberID,'NOT'=>array('AcrClientInvoice.status'=>'Canceled'),'AcrClientInvoice.invoiced_date BETWEEN ? AND ?'=>array($fromDate,$toDate)),
				'group' => array('AcrClientInvoice.acr_client_id'),
				'order' => array('total'=>'desc'),
				'limit'	=> 10
			));
		$final['customerInvoice']	= $customerInvoice;
		return $final;
	}
	
	
	public function adminDashboard() {
		$this->permission = $this->Session->read('Auth.AllPermissions.Dashboard');
		$subsIDDd = $this->Session->read('Auth.User.sbs_subscriber_id');
		if(($this->permission['_read'] != 1) || $subsIDDd > 0) {
            $this->redirect(array('controller'=>'users','action'=>'noaccess'));
		}
		$this->layout = "cpn_layout";
		$this->loadModel('SbsSubscriber');
		$this->loadModel('CpnSubscriptionPlan');
		$this->loadModel('CpnSubscriberInvoiceDetail');
		$this->loadModel('CpnSetting');
		$completedCount = 0;
		$dueCount = 0;
		$cancelledCount = 0;
		$lastMonthCompletedCount = 0;
		$lastMonthDueCount = 0;
		$lastMonthCancelledCount = 0;
		$adminSetting = $this->CpnSetting->getAllSettings();
		$allPlan = $this->CpnSubscriptionPlan->getSubscriptionPlanList();
		$dashboardActive = 'active';
		$this->set(compact('allPlan','dashboardActive'));
		foreach($allPlan as $planId => $planName){
			$getsubscriber = $this->SbsSubscriber->getSubscriberBySubscriptionPlanForCurrentMonth($planId);
			$getsubscriberLastMonth = $this->SbsSubscriber->getSubscriberBySubscriptionPlanForLastMonth($planId);
			/*$getCancelledSubscriberForCurrentMonth = $this->SbsSubscriber->getCurrentMonthCancellation();*/
			
			if($getsubscriber){
				if($getsubscriber || $getsubscriberLastMonth){
					$growthPercentage = $this->calculateGrowth(count($getsubscriber),count($getsubscriberLastMonth));
				}
				$getSubscriptionCount[$planName]	=	count($getsubscriber);
				$getSubscriptionGrowth[$planName]	=	$growthPercentage;
				foreach($getsubscriber as $subscriber){
					$getSubscriptionStatus = $this->CpnSubscriberInvoiceDetail->getInvoiceStatusBasedOnSubscriberId($subscriber['SbsSubscriber']['id']);
					$getLastMonthSubscriptionStatus = $this->CpnSubscriberInvoiceDetail->getLastMonthInvoiceStatusBasedOnSubscriberId($subscriber['SbsSubscriber']['id']);
					$nextPayment = explode(' ',$getSubscriptionStatus['CpnSubscriberInvoiceDetail']['next_payment_date']);
					if($getSubscriptionStatus['CpnSubscriberInvoiceDetail']['payment_status'] == "Completed"){
						$completedCount++;
					}elseif((($getSubscriptionStatus['CpnSubscriberInvoiceDetail']['payment_status'] == "Failed") || ($getSubscriptionStatus['CpnSubscriberInvoiceDetail']['payment_status'] == "Pending")) && (strtotime($nextPayment) <= strtotime(date('Y-m-d H:i:s')))){
						$dueCount++;
					}elseif( ($getSubscriptionStatus['CpnSubscriberInvoiceDetail']['payment_status'] == "Refunded")){
						$cancelledCount++;
					}
					if($getLastMonthSubscriptionStatus['CpnSubscriberInvoiceDetail']['payment_status'] == "Completed"){
						$getLastMonthSubscriptionCount['Paid Subscription'] = $lastMonthCompletedCount++;
					}elseif($getLastMonthSubscriptionStatus['CpnSubscriberInvoiceDetail']['payment_status'] == "Failed"){
						$getLastMonthSubscriptionCount['Due Subscription'] = $lastMonthDueCount++;
					}elseif(($getSubscriptionStatus['CpnSubscriberInvoiceDetail']['payment_status'] == "Refunded")){
						$getLastMonthSubscriptionCount['Cancel Subscription'] = $lastMonthCancelledCount++;
					}
					$getSubscriptionCount['Paid Subscription'] = $completedCount;
					$getSubscriptionCount['Due Subscription'] = $dueCount;
					$getSubscriptionCount['Cancel Subscription'] = $cancelledCount;
				}
				$growthPercentageOther['Paid Subscription'] 		= $this->calculateGrowth($getSubscriptionCount['Paid Subscription'],$getLastMonthSubscriptionCount['Paid Subscription']);
				$growthPercentageOther['Due Subscription'] 		= $this->calculateGrowth($getSubscriptionCount['Due Subscription'],$getLastMonthSubscriptionCount['Due Subscription']);
				$growthPercentageOther['Cancel Subscription'] 	= $this->calculateGrowth($getSubscriptionCount['Cancel Subscription'],$getLastMonthSubscriptionCount['Cancel Subscription']);
			}else{
				$getSubscriptionCount[$planName]	=	0;
				$getSubscriptionGrowth[$planName]   =   0; 
			}
			
		}
		$getSixMonthData = $this->SbsSubscriber->getSubscriberBySubscriptionPlanForLastSixMonth();
		$getSixMonthSubscriberPerSubscription = $this->SbsSubscriber->getSubscriberPerSubscriptionForSixMonth($allPlan);
		$getRevenueDetails = $this->CpnSubscriberInvoiceDetail->getSixMonthInvoiceValues();
		$this->set(compact('getSubscriptionCount','getSubscriptionGrowth','growthPercentageOther','getSixMonthData','getSixMonthSubscriberPerSubscription','getRevenueDetails','adminSetting'));
	 }
	
	public function calculateGrowth($currentMonthSubscription,$previousMonthSubscription){
		if($currentMonthSubscription>$previousMonthSubscription){
			if($previousMonthSubscription>0){
				$arrayValue['Growth'] = "up";
				$value = (($currentMonthSubscription-$previousMonthSubscription)/$previousMonthSubscription)*100;
				$arrayValue['val']	=	round($value);
			}else{
				$arrayValue['Growth'] = "up";
				$arrayValue['val']	=	round($currentMonthSubscription)*100;
			}
			
		}elseif($currentMonthSubscription<$previousMonthSubscription){
			$arrayValue['Growth'] = "down";
			$value = (($previousMonthSubscription-$currentMonthSubscription)/$previousMonthSubscription)*100;
			$arrayValue['val']	=	round($value);
		}else{
			$arrayValue['Growth'] = "equal";
			$arrayValue['val']	=	0;
		}
		return $arrayValue;
	}
	
	function get_client_ip() {
		
	    $ipaddress = '';
	    if($_SERVER['REMOTE_ADDR'])
	        $ipaddress = $_SERVER['REMOTE_ADDR'];
		else if($_SERVER['HTTP_CLIENT_IP'])
	        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    else if($_SERVER['HTTP_X_FORWARDED'])
	        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    else if($_SERVER['HTTP_FORWARDED_FOR'])
	        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    else if($_SERVER['HTTP_FORWARDED'])
	        $ipaddress = $_SERVER['HTTP_FORWARDED'];    
	   
	    return $ipaddress;
	}
	
}