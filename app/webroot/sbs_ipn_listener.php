<?php       
        // ini_set('log_errors', true);
	//    ini_set('error_log', '../tmp/logs/error_ipn.log');
	// instantiate the IpnListener class	
		include('IpnListener.php');	
		$listener = new IpnListener();
		$listener->use_sandbox = false;
		
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
		$DB_USER = 'cantorix_invoice';
		$DB_PASS =  'CantorixInvoicingFrikkie5!';
		$DB_NAME =  'cantorix_invoicing';	
		$dbcon = mysql_connect($DB_HOST,$DB_USER,$DB_PASS) or die(mysql_error());		
	    mysql_select_db($DB_NAME, $dbcon) or die(mysql_error());
     		
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
					
				case 'web_accept':	
						
						$payment_status			=	$_POST['payment_status'];			
						$txn_id				=	$_POST['txn_id'];								
						$payment_fee			=	$_POST['mc_fee'];						
						$payment_date	           =	date('Y-m-d',strtotime($_POST['payment_date']));						
						$receiver_email			=   $_POST['receiver_email'];
						$curncy					=   $_POST['mc_currency'];
						$paid_amount			=   $_POST['mc_gross'];
						$invoice_no				=   $_POST['invoice'];
						$send_payment_note		=	'Y';
						$sbs_subscriber_id 		=   $_POST['custom'];
						$paymentMethod			=   'PayPal';
					        $businessEmail                  = getSbsBusinessEmail($sbs_subscriber_id,$paymentMethod);
						$isTxnIdProcessed		=	checkTxnId($txn_id);						
						$invoice_details		=	getInvoiceByInvoiceNumber ($invoice_no, $sbs_subscriber_id);
						$cpn_payment_method_id  =   getPaymentMethodByname($paymentMethod);						
						$acr_client_id			=	$invoice_details['acr_client_id'];
						$acr_client_invoice_id	=	$invoice_details['id'];
						$currency				=	$invoice_details['invoice_currency_code'];
						$reciept_amount			=	$invoice_details['invoice_total'];
						$reciept_amount			=	money_format('%!(.2n',$reciept_amount);
						if(($payment_status == 'Completed') && !($isTxnIdProcessed) && ($receiver_email == $businessEmail) && ($curncy == $currency) && ($paid_amount == $reciept_amount) ) {
							
							$status = 'Paid';
								
							$qry 	= "INSERT INTO acr_invoice_payment_details(cpn_payment_method_id,txn_id,payment_fee,
							payment_date,paid_amount,send_payment_note,acr_client_id,acr_client_invoice_id,sbs_subscriber_id) 
							VALUES($cpn_payment_method_id,'".$txn_id."',$payment_fee,'".$payment_date."',$paid_amount,'".$send_payment_note."',$acr_client_id,$acr_client_invoice_id,$sbs_subscriber_id)";	
							
							mysql_query($qry, $dbcon);
							
							$qry1 	= "UPDATE acr_client_invoices set status = '".$status."' where id = $acr_client_invoice_id and sbs_subscriber_id = $sbs_subscriber_id";								
							mysql_query($qry1, $dbcon);
														
						}						 
						break;
																
			}					    
		    $clientDetails = getClientDetails($acr_client_id, $sbs_subscriber_id);
		$msg                   = getPaymentReceivedTemplate($sbs_subscriber_id,'Payment',$payment_date,$paid_amount,$acr_client_invoice_id,$acr_client_id,$cpn_payment_method_id);
                    $body_content =   $msg['content'];
                    $from      = $msg['from'];
                        $to        = $clientDetails['email'];
                        $subject        = $msg['subject'];
                        ob_start();
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $header .= $body_content."\r\n\r\n";
                        $header = "From: "."<".$from.">\r\n";
                $header .= "Reply-To: ".'admin@cantorix.com'."\r\n";
                        $success = mail($to, $subject, $body_content, $header);
			 		
		
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
			$qry 	= "select txn_id from acr_invoice_payment_details where txn_id = '".$txnId."'";
			$result = mysql_query($qry, $dbcon);
			$txnid_exist    = mysql_num_rows($result);
	 		if($txnid_exist > 0){
	 			return true;	
			}else{
				return false;	
			}		
		}
		
		// get invoice dtails by invoice number and sbs id
		function getInvoiceByInvoiceNumber ($invoice_no, $sbs_subscriber_id) {			
			
			global $dbcon;
			$qry 	= "select * from acr_client_invoices where invoice_number = '".$invoice_no."'" ." and sbs_subscriber_id = $sbs_subscriber_id";			
			$result = mysql_query($qry, $dbcon);			
			$txnid_exist    = mysql_num_rows($result);
	 		if($txnid_exist > 0){
	 			while($row = mysql_fetch_array($result)) {
			 	 	$invoice_details['id'] 					  = $row['id'];
					$invoice_details['acr_client_id']  		  = $row['acr_client_id'];
					$invoice_details['invoice_total'] 		  = $row['invoice_total'];
					$invoice_details['invoice_currency_code'] = $row['invoice_currency_code'];					
				}	
			 	return $invoice_details;
			}
			else{
				return false;	
			}		
		}		
		
		//fetch Payment Method Id
	   function getPaymentMethodByname($paymentMethod){
	  	 	global $dbcon;
			
			$getpaymentMethodDetails = "select id from cpn_payment_methods where payment_option_name = '$paymentMethod'";
			
			$result 		  = mysql_query($getpaymentMethodDetails, $dbcon);
			if($result){
				 while($row = mysql_fetch_array($result)) {
					 $cpn_payment_method_id = $row['id'];
				}
				 return $cpn_payment_method_id;	
			}else{
				return false;	
			}	
		}		
		
		function getPaymentMethodAttribute($paymentMethod){
			global $dbcon;
			$paymentMethodId	=	getPaymentMethodByname($paymentMethod);
			$methodAttribute	=	"select id from cpn_payment_method_attributes where cpn_payment_method_id= $paymentMethodId and attribute = 'PayPal Email'";
			 $result                   = mysql_query($methodAttribute, $dbcon);
			if($result){
                                 while($row = mysql_fetch_array($result)) {
                                         $cpn_payment_method_attribute_id = $row['id'];
                                }
                                 return $cpn_payment_method_attribute_id;
                        }else{
                                return false;  
                        }  
		}
		// sbs business email		
		
		function getSbsBusinessEmail($sbs_subscriber_id,$paymentMethod) {

					global $dbcon;
					$paymentMethodId        =       getPaymentMethodByname($paymentMethod);
					$attributeId		=	getPaymentMethodAttribute($paymentMethod);
					$qry 	= "select value from sbs_payment_method_values where subscriber_id = '".$sbs_subscriber_id."' and cpn_payment_method_id = $paymentMethodId and cpn_payment_attribute_id = $attributeId";
					$result = mysql_query($qry, $dbcon);			
					 if($result){
						 while($row = mysql_fetch_array($result)) {
							 $business_email = $row['value'];
						}
						 return $business_email;	
					}else{
						return false;	
					}	
				}
				
		
		// get client details
		function getClientDetails($acr_client_id, $sbs_subscriber_id){
	  	 	global $dbcon;
			$qry    = "select name, sur_name, email from acr_client_contacts where acr_client_id = $acr_client_id and sbs_subscriber_id = $sbs_subscriber_id";
			$result = mysql_query($qry, $dbcon);
			if($result){
				 while($row = mysql_fetch_array($result)) {
					 $clientDetails['name']     = $row['name'];
					 $clientDetails['sur_name'] = $row['sur_name'];
					 $clientDetails['email']    = $row['email'];
				}
				 return $clientDetails;	
			}else{
				return false;	
			}	
		}		
				
function getPaymentReceivedTemplate($subscriberId,$template,$payment_date,$payment_fee,$acr_client_invoice_id,$acr_client_id,$cpn_payment_method_id){
                        global $dbcon;
                        $qry = "select * from sbs_email_template_details where module_related = '$template' and sbs_subscriber_id = $subscriberId";
                        $qry1 = "select * from acr_clients where id = $acr_client_id and sbs_subscriber_id = $subscriberId";
                        $qry2 = "select * from acr_client_invoices where id = $acr_client_invoice_id and sbs_subscriber_id = $subscriberId";
                        $qry3 = "select * from acr_client_contacts where acr_client_id = $acr_client_id and sbs_subscriber_id = $subscriberId";
                        $result = mysql_query($qry, $dbcon);
                        if($result){
                                 while($row = mysql_fetch_array($result)) {
                                         $subject       = $row['subject'];
                                         $body                  = $row['body_content'];
                                         $from                  = $row['from_email_address'];
                                }
                $result1 = mysql_query($qry1, $dbcon);
                        if($result1){
                                 while($row1 = mysql_fetch_array($result1)) {
                                         $organisationName = $row1['organization_name'];
                                         $website       =       $row1['website'];
                                         $businessPhone = $row1['business_phone'];
                                         $fax                   =       $row1['business_fax'];
                                }
                        }

                        $result2 = mysql_query($qry2, $dbcon);
                        if($result2){
                                while($row2 = mysql_fetch_array($result2)) {
                                         $invoiceNumber = $row2['invoice_number'];
                                         $invoiceCurrencyCode = $row2['invoice_currency_code'];
                                         $invoiceTotal = $row2['invoice_total'];
                                         $invoiceDate   =       $row2['invoiced_date'];
                                         $po    =       $row2['purchase_order_no'];
                                         $invoiceDescription = $row2['description'];
                                }
                        }
                        $result3 = mysql_query($qry3, $dbcon);
			 if($result3){
                                 while($row3 = mysql_fetch_array($result3)) {
                                         $name = $row3['name'];
                                         $surname = $row3['sur_name'];
                                }
                        }
                        $paidAmount     = money_format('%!(.2n',$payment_fee);
                        if($paidAmount){
                                $balanceAmount = money_format('%!(.2n',$invoiceTotal) - $paidAmount;
                        }else{
                                $balanceAmount = money_format('%!(.2n',$invoiceTotal);
                        }
                                $swears = array(
                                                "[Invoice No]"                          => $invoiceNumber,
                                                "[Payment Date]"                        => $payment_date,
                                                "[Receipt Amount]"              =>  $invoiceCurrencyCode.' '.money_format('%!(.2n',$paidAmount),
                                                "[Balance]"                             => $invoiceCurrencyCode.' '.money_format('%!(.2n',$invoiceTotal),
                                                "[Balance Due]"                         => $invoiceCurrencyCode.' '.money_format('%!(.2n',$balanceAmount),
                                                "[Invoice Date]"                        => $invoiceDate,
                                                "[PO Number]"                           => $po,
                                                "[Invoice Description]"         => $invoiceDescription,
                                                "[Organization Name]"           => $organisationName,
                                                "[Organization Website]"        => $website,
                                                "[Business Phone]"              => $businessPhone,
                                                "[Business Fax]"                        => $fax,
                                                "[Primary Contact Name]"        => $name,
                                                "[Primary Contact Surname]"     => $surname
                                );
                                $msg['subject'] = str_replace(array_keys($swears), array_values($swears), $subject);
                                $msg['content'] = str_replace(array_keys($swears), array_values($swears), $body);
                                $msg['from']    =       $from;
                                return $msg;
                        }else{
                                return false;
                        }
                }
		
	
?>
