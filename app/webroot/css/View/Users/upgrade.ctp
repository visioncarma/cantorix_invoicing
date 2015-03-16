<?php echo $this->Html->css(array('ace-rtl.min.css','ace-skins.min.css','template_dashboard.css'));?>
<?php echo $this->Html->script(array('typeahead-bs2.min','jquery-ui-1.10.3.custom.min','jquery.ui.touch-punch.min','jquery.slimscroll.min','jquery.easy-pie-chart.min','jquery.sparkline.min'));?>
<div class="full_container">
	<div class="main-container" id="main-container">
		<script type="text/javascript">
			try {
				ace.settings.check('main-container', 'fixed')
			} catch(e) {
			}
		</script>
		<div class="main-container-inner">

			<div class="main-content trialexceeded">

				<div class="page-content">
					<div class="row">
						<div class="col-xs-9 pricing-span-body pricing-span-bodypaddingneed trialdays">
							<div class="login-container downgrade_subscription upgrade_subscription">
								<div class="position-relative">
									<div class="center ">
										<h2 class="smaller bluetext"> Your <?php echo $currentPlan['CpnSubscriptionPlan']['validity'];?>-days free trial period has expired.</h2>
									</div>
									<div class="center ">
										<h2 class="smaller bluetext"> We would like to keep you on as a subscriber,</h2>
									</div>
									<div class="center ">
										<h2 class="smaller bluetext"> if you wish to continue then please subscribe to one of the pricing options below.</h2>
									</div>
									<div class="center bolder">
										<h2 class="smaller bolder"> Choose Your Pricing Option </h2>
									</div>
									<?php foreach($plans as $plan):?>
										<?php 
											if($plan['CpnSubscriptionPlan']['type'] == 'Unlimited'){
												$firstClass = "pricing-span3 span100percentblue bluetheme commoncellpaddinggg span50percentblue nomargineft orangee";
												$lastClass = "uppercase textdecor btn btn-primary bolder btn-lg btn-warning";
											} else {
												$firstClass = "pricing-span3 span100percentblue bluetheme commoncellpaddinggg span50percentblue";
												$lastClass = "uppercase textdecor btn btn-primary bolder btn-lg";
											}
										?>
									<div class="<?php echo $firstClass;?>">
										<div class="pricingboxx rightbottomshadow">

											<div class="pricingboxx_head">
												<div class="pricingboxx_headinner">
													<h5 class="bigger bolder col-xs-12"> <?php echo $plan['CpnSubscriptionPlan']['type'];?> </h5>
												</div>
											</div>
											<div class="common_priceboxrow common_memory pricegreen">
												<h5 class="pricee bolder bluetext col-xs-12"> $<?php echo $plan['CpnSubscriptionPlan']['cost'];?> / Month</h5>
											</div>
											<div class="common_priceboxrow common_priceboxrow_tablebody">
												<div >
													No of customers you can manage
												</div>
												<div class="bolder">
													<?php
														if($plan['CpnSubscriptionPlan']['no_of_clients'] == -1) {
															echo 'Unlimited';
														} else {
															echo $plan['CpnSubscriptionPlan']['no_of_clients'];
														}
													?>
												</div>
											</div>
											<div class="common_priceboxrow common_priceboxrow_tablebody">
												<div>
													Additional staff who can access your account
												</div>
												<div class="bolder">
													<?php
														if($plan['CpnSubscriptionPlan']['no_of_staffs'] == -1) {
															echo 'Unlimited';
														} else {
															echo $plan['CpnSubscriptionPlan']['no_of_staffs'];
														}
													?>
												</div>
											</div>
											<div class="common_priceboxrow common_priceboxrow_tablebody">
												<div >
													No of invoices you can send
												</div>
												<div class="bolder">
													<?php
														if($plan['CpnSubscriptionPlan']['no_of_invoices'] == -1) {
															echo 'Unlimited';
														} else {
															echo $plan['CpnSubscriptionPlan']['no_of_invoices'];
														}
													?>
												</div>
											</div>
											<div class="common_priceboxrow_signup common_priceboxrow_signup_downgrade">
												<div class="pricing_signupp">
													<div class="">
														<?php echo $this->Html->link('Select',array('action'=>'paymentDetailRenewal',$plan['CpnSubscriptionPlan']['id']),array('class'=>$lastClass));?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php endforeach;?>
								</div>
							</div>

						</div>
					</div>
				</div><!-- /.page-content -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container-inner -->

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a>
	</div><!-- /.main-container -->
</div>