<?php 
        // ini_set('log_errors', true);
	   //  ini_set('error_log', '../tmp/logs/error_ipn.log');
				
		// instantiate the IpnListener class	
		include('IpnListener.php');	
		$listener = new IpnListener();
		$listener->use_sandbox = true;
		
		//To post over standard HTTP connection, use:
		//$listener->use_ssl = false;
		
		//To post using the fsockopen() function rather than cURL, use:
		//$listener->use_curl = false;
	
		try {
		    $listener->requirePostMethod();
		    $verified = $listener->processIpn();
		} catch (Exception $e) {
		    error_log($e->getMessage());
		    exit(0);
		}
		
		$DB_HOST = 'localhost';
		$DB_USER = 'root';
		$DB_PASS = 'qwertplm123';
		$DB_NAME = 'cantorix';
		$businessEmail = 'venugopal-facilitator@carmatec.com';
		$dbcon = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die(mysql_error());		
	    mysql_select_db($DB_NAME, $dbcon) or die(mysql_error());
		
		$currency = getCurrency();		
		/*
		The processIpn() method returned true if the IPN was "VERIFIED" and false if it
		was "INVALID".
		*/
		if ($verified) {		   
		    
		       //1. Check the $_POST['payment_status'] is "Completed"
		        
			   // 2. Check that $_POST['txn_id'] has not been previously processed 
			   
			   // 3. Check that $_POST['receiver_email'] is your Primary PayPal email 
			   
			   // 4. Check that $_POST['payment_amount'] and $_POST['payment_currency']
		   
	       switch ($_POST['txn_type']) {
	     	
				case 'recurring_payment_profile_created':
					
						$txn_type = 'profile_created';
						$recurring_payment_id	=	$_POST['recurring_payment_id'];
						$last_payment_date 		= 	date('Y-m-d H:i:s');  
						$last_payment_amount	=	$_POST['initial_payment_amount'];
						$tax_amount				=	$_POST['tax'];
						$payment_status			=	$_POST['initial_payment_status'];			
						$txn_id					=	$_POST['initial_payment_txn_id'];
						$next_payment_date		=	date('Y-m-d H:i:s',strtotime($_POST['next_payment_date']));
						$outstanding_balance	=	$_POST['outstanding_balance'];						
						if($payment_fee) {
							$payment_fee		=	$_POST['payment_fee']; 
						}else {
							$payment_fee		=   0;
						}
						$time_created			=	$_POST['time_created'];
						$profile_status			=	$_POST['profile_status'];
						$receiver_email			=   $_POST['receiver_email'];
						$updation				=   date('Y-m-d');
						
						$isTxnIdProcessed		=	checkTxnId($txn_id);					
						
						if(($payment_status == 'Completed') && !($isTxnIdProcessed) && ($receiver_email == $businessEmail) ) {
							$sbs_subscriber_id		=   getSubscriberIdByProfileId($recurring_payment_id);
							$invoice_no				=   generate_invoiceno($recurring_payment_id);							
							$subscription_type		=   getSubscriptionDetails($sbs_subscriber_id);	
														
							$qry1 	= "INSERT INTO cpn_subscriber_invoice_details(invoice_no,last_payment_date,last_payment_amount,tax_amount
							,payment_status,txn_type,txn_id,next_payment_date,outstanding_balance,payment_fee,time_created,subscription_type,sbs_subscriber_id) 
							VALUES('".$invoice_no."','".$last_payment_date."',$last_payment_amount,$tax_amount,'".$payment_status."','".$txn_type."','".$txn_id."','".$next_payment_date."',$outstanding_balance,$payment_fee,'".$time_created."','".$subscription_type."',$sbs_subscriber_id)";	
							
							mysql_query($qry1, $dbcon);
							
							$qry2 	= "update sbs_subscribers set status = '".$profile_status."', updation = '".$updation."' where id = '".$sbs_subscriber_id."'";
							mysql_query($qry2, $dbcon);								
						}														
						break;
					
				case 'recurring_payment':
					
						$txn_type = 'recurring_payment';
						$recurring_payment_id	=	$_POST['recurring_payment_id'];
						$last_payment_date 		= 	date('Y-m-d H:i:s',strtotime($_POST['payment_date']));
						$last_payment_amount	=	$_POST['mc_gross'];
						$tax_amount				=	$_POST['tax'];
						$payment_status			=	$_POST['payment_status'];			
						$txn_id					=	$_POST['txn_id'];
						$next_payment_date		=	date('Y-m-d',strtotime($_POST['next_payment_date']));
						$outstanding_balance	=	$_POST['outstanding_balance'];
						$payment_fee			=	$_POST['payment_fee']; 
						$time_created			=	$_POST['time_created'];
						$profile_status			=	$_POST['profile_status'];
						$receiver_email			=   $_POST['receiver_email'];
						$curncy					=   $_POST['mc_currency'];
						
						$isTxnIdProcessed		=	checkTxnId($txn_id);
						$sbs_subscriber_id		=   getSubscriberIdByProfileId($recurring_payment_id);
						$subsStr				=	checkPrice($sbs_subscriber_id);													
						$subsAr         	    = 	explode("--",$subsStr);
						$subsCost			    = 	$subsAr[0];						
						$subsType			    = 	$subsAr[1];
						
						if(($payment_status == 'Completed') && !($isTxnIdProcessed) && ($receiver_email == $businessEmail) && ($curncy == $currency) && ($last_payment_amount == $subsCost) ) {
																					
							$invoice_no				=   generate_invoiceno($recurring_payment_id);			
							 								
							$qry 	= "INSERT INTO cpn_subscriber_invoice_details(invoice_no,last_payment_date,last_payment_amount,tax_amount
							,payment_status,txn_type,txn_id,next_payment_date,outstanding_balance,payment_fee,time_created,subscription_type,sbs_subscriber_id) 
							VALUES('".$invoice_no."','".$last_payment_date."',$last_payment_amount,$tax_amount,'".$payment_status."','".$txn_type."','".$txn_id."','".$next_payment_date."',$outstanding_balance,$payment_fee,'".$time_created."','".$subsType."',$sbs_subscriber_id)";	
							mysql_query($qry, $dbcon);
														
						}						 
						break;
					
				case 'recurring_payment_failed':
					
						$txn_type = 'payment_failed';
						$recurring_payment_id	=	$_POST['recurring_payment_id'];
						$last_payment_date 		= 	null;
						$last_payment_amount	=	0.00;
						$tax_amount				=	$_POST['tax'];
						$payment_status			=	'Failed';			
						$txn_id					=	null;
						$next_payment_date		=	date('Y-m-d H:i:s',strtotime($_POST['next_payment_date']));
						$outstanding_balance	=	$_POST['outstanding_balance'];
						$payment_fee			=	null; 
						$time_created			=	$_POST['time_created'];
						$profile_status			=	$_POST['profile_status'];
						$receiver_email			=   $_POST['receiver_email'];							
							
						
						if($receiver_email == $businessEmail) {
							
							$sbs_subscriber_id		=   getSubscriberIdByProfileId($recurring_payment_id);
							$invoice_no				=   generate_invoiceno($recurring_payment_id);
							$subscription_type		=   getSubscriptionDetails($sbs_subscriber_id);	
														 
							$qry 	= "INSERT INTO cpn_subscriber_invoice_details(invoice_no,last_payment_date,last_payment_amount,tax_amount
							,payment_status,txn_type,txn_id,next_payment_date,outstanding_balance,payment_fee,time_created,subscription_type,sbs_subscriber_id) 
							VALUES('".$invoice_no."','".$last_payment_date."',$last_payment_amount,$tax_amount,'".$payment_status."','".$txn_type."','".$txn_id."','".$next_payment_date."',$outstanding_balance,$payment_fee,'".$time_created."','".$subscription_type."',$sbs_subscriber_id)";	
							mysql_query($qry, $dbcon);								
						}
						break;	
					
				case 'recurring_payment_profile_cancel':						
						
						$txn_type = 'profile_cancel';						
						$recurring_payment_id	=	$_POST['recurring_payment_id'];
						$profile_status			=	$_POST['profile_status'];
						$sbs_subscriber_id		=   getSubscriberIdByProfileId($recurring_payment_id);						
						$updation				=   date('Y-m-d');
						
						$qry 	= "update sbs_subscribers set status = '".$profile_status."', updation = '".$updation."' where id = '".$sbs_subscriber_id."'";
						mysql_query($qry, $dbcon);
						break;	
					
				case 'recurring_payment_suspended':
				
						$txn_type = 'profile_suspended';
						$recurring_payment_id	=	$_POST['recurring_payment_id'];
						$profile_status			=	$_POST['profile_status'];
						$sbs_subscriber_id		=   getSubscriberIdByProfileId($recurring_payment_id);							
						$updation				=   date('Y-m-d');
						
						$qry1 	= "update sbs_subscribers set status = '".$profile_status."', updation = '".$updation."' where id = '".$sbs_subscriber_id."'";
						mysql_query($qry1, $dbcon);
						$qry2 	= "update users set active = 'N' where sbs_subscriber_id = '".$sbs_subscriber_id."'";
						mysql_query($qry2, $dbcon);
						break;	
					
				case 'recurring_payment_expired':
					
					$profile_status = 'profile_expired';
					break;												
			}					    
		   		
		    mail('admin@carmatec.com', 'Verified IPN', $listener->getTextReport());		
		
		} else {
		    /*
		    An Invalid IPN *may* be caused by a fraudulent transaction attempt. It's
		    a good idea to have a developer or sys admin manually investigate any 
		    invalid IPN.
		    */
		    	   
		    mail('admin@cantorix.com', 'Invalid IPN', $listener->getTextReport());
		}		

		// check txn id if previously processed
		function checkTxnId ($txnId) {			
			
			global $dbcon;
			$qry 	= "select txn_id from cpn_subscriber_invoice_details where txn_id = '".$txnId."'";
			$result = mysql_query($qry, $dbcon);
			$txnid_exist    = mysql_num_rows($result);
	 		if($txnid_exist > 0){
	 			return true;	
			}else{
				return false;	
			}		
		}
		
		// get subscriber id by profile id
		function getSubscriberIdByProfileId ($profileId) {
			
			global $dbcon;			 
		   	$qry 	= "select id from sbs_subscribers where profileId = '".$profileId."'";
			$result = mysql_query($qry, $dbcon);

			while($row = mysql_fetch_array($result)) {
			 	 $subscriberId = $row['id'];
			}	
	 		return $subscriberId;
		}

	// generate invoice number
	function generate_invoiceno($profileId) {
				
		global $dbcon;
		$qry1 	= "select id, subscribed_date from sbs_subscribers where profileId = '".$profileId."'";
		$result1 = mysql_query($qry1, $dbcon);

		while($row1 = mysql_fetch_array($result1)) {
			  $subscriberId    = $row1['id'];
			  $subscribed_date = $row1['subscribed_date'];
		}
		
		$qry2 	= "select id from cpn_subscriber_invoice_details where sbs_subscriber_id = '".$subscriberId."' order by id desc";
		$result2 = mysql_query($qry2, $dbcon);

		while($row2 = mysql_fetch_array($result2)) {
			  $lastRowId = $row2['id'];
		}
		
		if($lastRowId) {
			$lastRowId		 = $lastRowId + 1;
		} else {
			$lastRowId       = 1;
		}
		
		$subscribed_date = $subscribed_date;
		$dateAr          = explode("-",$subscribed_date);
		$year			 = $dateAr[0];
		$month			 = $dateAr[1];
		$sbs_id			 = $subscriberId;		
		$invoiceNo		 = 'INV-'.$year.$month.$sbs_id.$lastRowId;		
 		return $invoiceNo;
	}
	
	// get subscription Price for subscriber
	function checkPrice ($sbs_subscriber_id) {			
			
			global $dbcon;			 
		   	$qry1 	= "select cpn_subscription_plan_id from sbs_subscribers where id = '".$sbs_subscriber_id."'";
			$result1 = mysql_query($qry1, $dbcon);

			while($row1 = mysql_fetch_array($result1)) {
			 	 $subscriberPlanId = $row1['cpn_subscription_plan_id'];
			}

			$qry2 	= "select cost,type from cpn_subscription_plans where id = '".$subscriberPlanId."'";
			$result2 = mysql_query($qry2, $dbcon);

			while($row2 = mysql_fetch_array($result2)) {
			 	 $subsCost = $row2['cost'];
				 $subsType = $row2['type'];
			}	 		
			$subsCost			= money_format('%!(.2n',$subsCost);
			return "$subsCost--$subsType";		
	}
	
	// get currency
	function getCurrency () {			
			
			global $dbcon;
			$qry 	= "select currency_code from cpn_settings";
			$result = mysql_query($qry, $dbcon);
			while($row = mysql_fetch_array($result)) {
			 	 $currency = $row['currency_code'];
			}	
	 		return $currency;	
	}
	
	// get subscription details for subscriber
	function getSubscriptionDetails ($sbs_subscriber_id) {			
			
			global $dbcon;			 
		   	$qry1 	= "select cpn_subscription_plan_id from sbs_subscribers where id = '".$sbs_subscriber_id."'";
			$result1 = mysql_query($qry1, $dbcon);

			while($row1 = mysql_fetch_array($result1)) {
			 	 $subscriberPlanId = $row1['cpn_subscription_plan_id'];
			}

			$qry2 	= "select type from cpn_subscription_plans where id = '".$subscriberPlanId."'";
			$result2 = mysql_query($qry2, $dbcon);

			while($row2 = mysql_fetch_array($result2)) {
			 	 $subsPlan = $row2['type'];
			}
			return $subsPlan;		
	}
	
?>
