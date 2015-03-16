<?php
$organization_name = $this -> Session -> read('organization_name');
$billing_country = $visitorDetails['geoplugin_countryCode'];
?>
<div class="full_container">
	<div class="container">
		<div class="row paddingtb40">
			<div class="col-xs-12">
				<!--signup box starts-->
			<?php echo $this -> Form -> create('paymentForm', array('url' => array('controller' => 'users', 'action' => 'paidCheckoutRenewal'), 'id' => 'paymentForm')); ?>
				<div class="login-container payment-container">
					<div class="signup-box widget-box no-border login-box visible widget-box no-border">
						<div class="widget-body">
							<div class="widget-main">
								<div class="payment-box">
									<h3 class="payment-heading signupblue bold">Subcription Payment Details</h3>
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
													<?php echo $subscriptionType ?> Subscription
												</p>
											</div>
											<div class="price-value">
												<p>
													$<?php echo $subscriptionCost; ?>
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
													$<?php echo $serviceTax; ?>
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
													<?php echo date("d M Y", strtotime($profilestartdate)); ?>	
												</p>
											</div>
										</div>
									</div>
										<!-- <div class="price-row">
											<div class="price-name" style="border-right: none;">
												
											</div>	
										</div> -->
									<div class="price-details margin-top-zero margin-bottom-20">
										<?php
										if ($splitRow) {//$init_amount = $initial_amount - $billAmount;
											$init_amount = $prorata_amount;
										} else {
											$init_amount = $prorata_amount;
										}
									?>										
										<div class="price-row">
											<div class="price-name">
												<p>
												   Initial Prorata Subscription Cost *
												</p>
											</div>
											<div class="price-value">
												<p>
													$<?php echo money_format('%!(.2n', $init_amount); ?>
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
													$<?php echo money_format('%!(.2n', $init_service_tax); ?>
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
													$<?php echo money_format('%!(.2n', $initial_amount); ?>
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
									<p>* Your prorate amount has been calculated on the remaining days to the recurring payment date. Any prorate amount less than <span class="bold">$<?php echo $amount_threshold; ?></span> has been discarded.</p>
								</div>
								<?php
								echo $this -> Form -> hidden('currency_code', array('id' => 'currency_code', 'value' => $visitorDetails['geoplugin_currencyCode']));
								echo $this -> Form -> hidden('currency_symbol_UTF8', array('id' => 'currency_symbol_UTF8', 'value' => $visitorDetails['geoplugin_currencySymbol_UTF8']));
								echo $this -> Form -> hidden('subscriptionType', array('id' => 'subscriptionType', 'value' => $subscriptionType));
								echo $this -> Form -> hidden('subscriptionCost', array('id' => 'subscriptionCost', 'value' => $subscriptionCost));
								echo $this -> Form -> hidden('serviceTax', array('id' => 'serviceTax', 'value' => $serviceTax));
								echo $this -> Form -> hidden('billAmount', array('id' => 'billAmount', 'value' => $billAmount));
								echo $this -> Form -> hidden('profilestartdate', array('id' => 'profilestartdate', 'value' => $profilestartdate));
								echo $this -> Form -> hidden('initial_amount', array('id' => 'initial_amount', 'value' => $initial_amount));
								echo $this -> Form -> hidden('splitRow', array('id' => 'splitRow', 'value' => $splitRow));
								echo $this -> Form -> hidden('prorata_amount', array('id' => 'prorata_amount', 'value' => $init_amount));
								echo $this -> Form -> hidden('init_service_tax', array('id' => 'init_service_tax', 'value' => $init_service_tax));
								?>
								<div class="input-row">									
									<?php  echo $this -> Form -> submit('Proceed to Checkout', array('div' => false, 'label' => false, 'class' => 'btn btn-primary normal-btn pull-right lighter')); ?>
								</div>
							</div>
						</div><!-- /widget-body -->
					</div><!-- /signup-box -->
				</div>
			<?php echo $this -> Form -> end(); ?>
			</div>
		</div>
	</div>
</div>