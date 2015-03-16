<?php

			$subscription_type 	= $this->Session->read('subscriptionType');
			$currency_code	 	= $this->Session->read('cpn_currency');
			$billAmount			= $this->Session->read('bill_amount');
			$profilestartdate   = $this->Session->read('profilestartdate');
			$initial_amount     = $this->Session->read('initial_amount');
			$splitRow     		= $this->Session->read('splitRow');
			$prorata_amount     = $this->Session->read('prorata_amount');
			$init_service_tax   = $this->Session->read('init_service_tax');
			$amount_threshold   = $this->Session->read('amount_threshold');
			
			// Extract the response details.
			$payerID 		 = 	urldecode($httpParsedResponseAr['PAYERID']);
			$payerStatus	 =	urldecode($httpParsedResponseAr["PAYERSTATUS"]);
			$street1 		 =  urldecode($httpParsedResponseAr["SHIPTOSTREET"]);
			if(array_key_exists("SHIPTOSTREET2", $httpParsedResponseAr)) {
				$street2     = urldecode($httpParsedResponseAr["SHIPTOSTREET2"]);
			}
			$city_name 		 =  urldecode($httpParsedResponseAr["SHIPTOCITY"]);
			$state_province  =  urldecode($httpParsedResponseAr["SHIPTOSTATE"]);
			$postal_code 	 =  urldecode($httpParsedResponseAr["SHIPTOZIP"]);
			$country_code 	 =  urldecode($httpParsedResponseAr["SHIPTOCOUNTRYCODE"]);
			$country_name	 =  urldecode($httpParsedResponseAr["SHIPTOCOUNTRYNAME"]);			
			$token			 =  urldecode($httpParsedResponseAr["TOKEN"]); 
		    $billAgreeStatus =  urldecode($httpParsedResponseAr["BILLINGAGREEMENTACCEPTEDSTATUS"]);		   
		    $paypalEmail	 =  urldecode($httpParsedResponseAr["EMAIL"]);		    
		    $firstName       =  urldecode($httpParsedResponseAr["FIRSTNAME"]);
		    $lastName        =  urldecode($httpParsedResponseAr["LASTNAME"]);
		    $addressStatus	   =  urldecode($httpParsedResponseAr["ADDRESSSTATUS"]);
			$subscription_cost = urldecode($httpParsedResponseAr["AMT"]);
			$service_tax 	   = urldecode($httpParsedResponseAr["TAXAMT"]); // paypal not returning taxamount 0.00 comes all time
			
			$service_tax	   = $billAmount - $subscription_cost;	
			$service_tax	   = money_format('%!(.2n',$service_tax);			
			$subscription_name = $subscription_type.' Subscription';
			$recurrinBillDate = date("d M Y", strtotime($profilestartdate));					
			//$L_BILLINGAGREEMENTDESCRIPTION0 = "$subscription_name : Monthly Recurring Charge (Incl. Tax) = $billAmount $currency_code with effect from $recurrinBillDate. Initial Prorate Subscription Cost (Incl. Tax) = $initial_amount $currency_code. Your prorate amount has been calculated on the remaining days to the first recurring payment date. (A prorate amount less than $"."$amount_threshold has been discarded).";
			$L_BILLINGAGREEMENTDESCRIPTION0 = '<span style="color:#000000;">'."$subscription_name : Monthly Recurring Charge (Incl. Tax) = $billAmount $currency_code with effect from $recurrinBillDate. ". '<span style="text-decoration:underline;">Initial</span> '.'Prorate Subscription Cost (Incl. Tax) ='." $initial_amount $currency_code. ". '<span style="font-style:italic;">Your prorate amount has been calculated on the remaining days to the first recurring payment date. (A prorate amount less than $'."$amount_threshold has been discarded).</span>".'</span>';
	 echo $this -> Form -> create('orderForm',array('url' => array('controller' => 'users', 'action' => 'makePayment'),'id'=>'orderForm')); 
		 echo $this -> Form -> hidden('token', array('id' => 'token', 'value' => $token));
		 echo $this -> Form -> hidden('payerID', array('id' => 'payerID', 'value' => $payerID));		 
		 echo $this -> Form -> hidden('street1', array('id' => 'street1', 'value' => $street1));
		 echo $this -> Form -> hidden('city_name', array('id' => 'city_name', 'value' => $city_name));
		 echo $this -> Form -> hidden('state_province', array('id' => 'state_province', 'value' => $state_province));
		 echo $this -> Form -> hidden('postal_code', array('id' => 'postal_code', 'value' => $postal_code));
		 echo $this -> Form -> hidden('country_code', array('id' => 'country_code', 'value' => $country_code));
		 echo $this -> Form -> hidden('country_name', array('id' => 'country_name', 'value' => $country_name));
		 echo $this -> Form -> hidden('firstName', array('id' => 'firstName', 'value' => $firstName));
		 echo $this -> Form -> hidden('lastName', array('id' => 'lastName', 'value' => $lastName));			 
		 echo $this -> Form -> hidden('subscriptionCost', array('id' => 'subscriptionCost', 'value' => $subscription_cost));
		 echo $this -> Form -> hidden('serviceTax', array('id' => 'serviceTax', 'value' => $service_tax));	
		 echo $this -> Form -> hidden('subscriptionType', array('id' => 'subscriptionType', 'value' => $subscription_type));
		 echo $this -> Form -> hidden('bill_amount', array('id' => 'bill_amount', 'value' =>$billAmount));
		 echo $this -> Form -> hidden('profilestartdate', array('id' => 'profilestartdate', 'value' => $profilestartdate));
		 echo $this -> Form -> hidden('initial_amount', array('id' => 'initial_amount', 'value' => $initial_amount));
	
?>
<div class="full_container">
	<div class="container">
		<div class="row paddingtb40">
			<div class="col-xs-12">
				<!--signup box starts-->
				<div class=" payment-container login-container">
					<div class="signup-box widget-box no-border login-box visible widget-box no-border">
						<div class="widget-body">
							<div class="widget-main">
								<div class="payment-box">
									<h3 class="payment-heading signupblue bold">Payment Review and Confirmation</h3>

									<div class="space-12" ></div>
									<div class="width100per floatleft paddingbottom10" >
										<div class="col-xs-5 nopadding">
											First Name
										</div>
										<div class="col-xs-7 nopadding bold bold">
											<?php echo $firstName;?>
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10" >
										<div class="col-xs-5 nopadding">
											Last Name
										</div>
										<div class="col-xs-7 nopadding bold bold">
											<?php echo $lastName;?>
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10" >
										<h5 class="signupblue bold"> Billing/Shipping Address</h5>
										<div>
											<?php echo $street1; ?>,
										</div>
										<div>
											<?php echo $city_name.', '. $state_province.', '. $country_name.', '. $postal_code; ?>
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10" >
										<h5 class="signupblue bold"> Billing Agreement</h5>
										<div class="justify">
											<?php echo $L_BILLINGAGREEMENTDESCRIPTION0; ?>
										</div>

									</div>
									<div class="width100per floatleft " >
										<h5 class="signupblue bold">Invoice Details</h5>
									  <div class="price-details margin-bottom-20">
										<div class="price-row">
											<div class="price-name">
												<p class="bold">
													Description
												</p>
											</div>
											<div class="price-value">
												<p class="bold">
													<!-- Item Price -->
												</p>
											</div>
										</div>
										<div class="price-row">
											<div class="price-name">
												<p>
													<?php echo $subscription_type ?> Subscription
												</p>
											</div>
											<div class="price-value">
												<p>
													$<?php echo $subscription_cost; ?>
												</p>
											</div>
										</div>
										<div class="price-row price-row border-bottom-none">
											<div class="price-name" style="border-bottom:1px solid #d5d5d5;">
												<p>
													Service Tax
												</p>
											</div>
											<div class="price-value" style="border-bottom:1px solid #333333;">
												<p>
													$<?php echo $service_tax; ?>
												</p>
											</div>
										</div>
										<div class="price-row border-bottom-none">
											<div class="price-name" style="border-bottom:1px solid #d5d5d5;">
												<p class="bold">
													Total Monthly Recurring Payment (Incl Tax)
												</p>
											</div>
											<div class="price-value" style="border-bottom:1px solid #333333;">
												<p class="bold">
													$<?php echo $billAmount; ?>
												</p>
											</div>
										</div>
										<div class="price-row border-bottom-none">
											<div class="price-name">
												<p>
												   Recurring Payment Start Date
												</p>
											</div>
											<div class="price-value">
												<p>
													<?php echo date("d M Y", strtotime($profilestartdate));	?>	
												</p>
											</div>
										</div>
									</div>
									<div class="price-details margin-top-zero margin-bottom-20">
										<?php if ($splitRow) { //$init_amount = $initial_amount - $billAmount;
																 $init_amount = $prorata_amount;  } else {
											$init_amount = $prorata_amount;
										}?>										
										<div class="price-row">
											<div class="price-name">
												<p>
												   Initial Prorata Subscription Cost *
												</p>
											</div>
											<div class="price-value">
												<p>
													$<?php echo money_format('%!(.2n',$init_amount); ?>
												</p>
											</div>
										</div>
										<?php if ($splitRow) { ?>
										<div class="price-row border-bottom-none">
											<div class="price-name" style="border-bottom:1px solid #d5d5d5;">
												<p>
												   Service Tax
												</p>
											</div>
											<div class="price-value" style="border-bottom:1px solid #333333;">
												<p>
													$<?php echo money_format('%!(.2n',$init_service_tax); ?>
												</p>
											</div>
										</div>																					
										<?php } ?>	
										<div class="price-row border-bottom-none">
											<div class="price-name" style="border-bottom:1px solid #d5d5d5;">
												<p class="bold">
													Total Initial Payment (incl Tax)
												</p>
											</div>
											<div class="price-value" style="border-bottom:1px solid #333333;">
												<p class="bold">													
													$<?php echo money_format('%!(.2n',$initial_amount); ?>
												</p>
											</div>
										</div>
										<div class="price-row border-bottom-none">
											<div class="price-name">
												<p>
												   Initial Payment Date
												</p>
											</div>
											<div class="price-value">
												<p>
													<?php echo date("d M Y"); ?>
												</p>
											</div>
										</div>
									</div>
									<!-- <p>* Your prorate amount has been calculated on the remaining days to the recurring payment date. Any prorate amount less than <span class="bold">$<?php $amount_threshold; ?></span> has been discarded.</p> -->					
							    </div>
							</div>

								<div class="input-row">									
									<?php  echo $this->Form->submit('Confirm',array('div'=>false,'label'=>false,'class'=>'btn btn-primary normal-btn pull-right lighter')); ?>
								</div>

							</div>
						</div><!-- /widget-body -->
					</div><!-- /signup-box -->
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this -> Form -> end(); ?>