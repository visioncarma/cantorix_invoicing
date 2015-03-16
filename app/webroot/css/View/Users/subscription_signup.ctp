
<div class="full_container">
	<div class="container mainwrapper">
		<div class="paddingtb40">

			<div class="heading_main_subscription">
				<div class="col-md-4">
					<hr>
				</div>
				<div class="col-md-4">
					<h3 class="bolder"> Choose Your Pricing Option </h3>
				</div>
				<div class="col-md-4">
					<hr>
				</div>
			</div>

			<div class="col-xs-12  pricing-span-body pricing-span-bodypaddingneed">

				<div class="pricing-span3 noborderright freeplan">
					<div class="pricingboxx pricingboxx1">

						<div class="pricingboxx_head">
							<div class="pricingboxx_headinner">
								<h5 class="bigger bolder"> <?php echo $subscriptionFree['CpnSubscriptionPlan']['type']; ?> </h5>
							</div>
						</div>

						<div class="common_priceboxrow common_memory pricegreen">
							<h5 class="pricee bolder greenn"> $<?php echo $subscriptionFree['CpnSubscriptionPlan']['cost']; ?> / Month</h5>
						</div>

						<div class="common_priceboxrow">
							<div>
								No of customers you can manage
							</div>

							<div class="bolder">								
								<?php if($subscriptionFree['CpnSubscriptionPlan']['no_of_clients'] < 0){
										echo 'Unlimited';
									   } else {
										echo $subscriptionFree['CpnSubscriptionPlan']['no_of_clients'];
									   } ?>
								<?php echo '(limited to '. $subscriptionFree['CpnSubscriptionPlan']['validity']. ' days trial)'; ?>
							</div>

						</div>

						<div class="common_priceboxrow">
							<div>
								Additional staff who can access your account
							</div>
							<div class="bolder">								
								<?php if($subscriptionFree['CpnSubscriptionPlan']['no_of_staffs'] < 0){
										echo 'Unlimited';
									   } else {
										echo $subscriptionFree['CpnSubscriptionPlan']['no_of_staffs'];
									   } ?>
							</div>
						</div>

						<div class="common_priceboxrow">
							<div>
								No of invoices you can send
							</div>
							<div class="bolder">								
								<?php if($subscriptionFree['CpnSubscriptionPlan']['no_of_invoices'] < 0){
										echo 'Unlimited';
									   } else {
										echo $subscriptionFree['CpnSubscriptionPlan']['no_of_invoices'];
									   } ?>
							</div>

						</div>

						<div class="common_priceboxrow_signup">

							<div class="pricing_signupp">
								<div class="pricing_signuppinner">								
									<?php echo $this -> Html -> link('Sign Up Now', array('controller' => 'users', 'action' => 'organizationDetails',$subscriptionFree['CpnSubscriptionPlan']['id']), array('class'=>'uppercase textdecor')); ?>
								</div>

							</div>
						</div>

					</div>
				</div>

				<div class="pricing-span3 standarplannn">
					<div class="pricingboxx pricingboxx2 activeprice">

						<div class="pricingboxx_head">
							<div class="pricingboxx_headinner">
								<h5 class="bigger bolder"> <?php echo $subscriptionStandard['CpnSubscriptionPlan']['type']; ?> </h5>
							</div>
						</div>

						<div class="common_priceboxrow common_memory pricegreen">
							<h5 class="pricee bolder greenn"> $<?php echo $subscriptionStandard['CpnSubscriptionPlan']['cost']; ?> / Month</h5>
						</div>

						<div class="common_priceboxrow">
							<div>
								No of customers you can manage
							</div>

							<div class="bolder">								
								<?php if($subscriptionStandard['CpnSubscriptionPlan']['no_of_clients'] < 0){
										echo 'Unlimited';
									   } else {
										echo $subscriptionStandard['CpnSubscriptionPlan']['no_of_clients'];
									   } ?>
							</div>

						</div>

						<div class="common_priceboxrow">
							<div>
								Additional staff who can access your account
							</div>
							<div class="bolder">								
								<?php if($subscriptionStandard['CpnSubscriptionPlan']['no_of_staffs'] < 0){
										echo 'Unlimited';
									   } else {
										echo $subscriptionStandard['CpnSubscriptionPlan']['no_of_staffs'];
									   } ?>
							</div>
						</div>

						<div class="common_priceboxrow">
							<div>
								No of invoices you can send
							</div>
							<div class="bolder">								
								<?php if($subscriptionStandard['CpnSubscriptionPlan']['no_of_invoices'] < 0){
										echo 'Unlimited';
									   } else {
										echo $subscriptionStandard['CpnSubscriptionPlan']['no_of_invoices'];
									   } ?>
							</div>

						</div>

						<div class="common_priceboxrow_signup">

							<div class="pricing_signupp">
								<div class="pricing_signuppinner">
									<?php echo $this -> Html -> link('Sign Up Now', array('controller' => 'users', 'action' => 'organizationDetails',$subscriptionStandard['CpnSubscriptionPlan']['id']), array('class'=>'uppercase textdecor')); ?>
								</div>
							</div>
						</div>

					</div>
				</div>

				<div class="pricing-span3 noborderleft">
					<div class="pricingboxx pricingboxx3">

						<div class="pricingboxx_head">
							<div class="pricingboxx_headinner">
								<h5 class="bigger bolder"> <?php echo $subscriptionUnlimited['CpnSubscriptionPlan']['type']; ?>  </h5>
							</div>
						</div>

						<div class="common_priceboxrow common_memory pricegreen">
							<h5 class="pricee bolder greenn"> $<?php echo $subscriptionUnlimited['CpnSubscriptionPlan']['cost']; ?> / Month </h5>
						</div>

						<div class="common_priceboxrow">
							<div>
								No of customers you can manage
							</div>

							<div class="bolder">								
								<?php if($subscriptionUnlimited['CpnSubscriptionPlan']['no_of_clients'] < 0){
										echo 'Unlimited';
									   } else {
										echo $subscriptionUnlimited['CpnSubscriptionPlan']['no_of_clients'];
									   } ?>
							</div>

						</div>

						<div class="common_priceboxrow">
							<div>
								Additional staff who can access your account
							</div>
							<div class="bolder">
								<?php if($subscriptionUnlimited['CpnSubscriptionPlan']['no_of_staffs'] < 0){
										echo 'Unlimited';
									   } else {
										echo $subscriptionUnlimited['CpnSubscriptionPlan']['no_of_staffs'];
									   } ?>
							</div>
						</div>

						<div class="common_priceboxrow">
							<div>
								No of invoices you can send
							</div>
							<div class="bolder">
								<?php if($subscriptionUnlimited['CpnSubscriptionPlan']['no_of_invoices'] < 0){
										echo 'Unlimited';
									   } else {
										echo $subscriptionUnlimited['CpnSubscriptionPlan']['no_of_invoices'];
									   } ?>
							</div>

						</div>

						<div class="common_priceboxrow_signup">

							<div class="pricing_signupp">
								<div class="pricing_signuppinner">
									<?php echo $this -> Html -> link('Sign Up Now', array('controller' => 'users', 'action' => 'organizationDetails',$subscriptionUnlimited['CpnSubscriptionPlan']['id']), array('class'=>'uppercase textdecor')); ?>
								</div>

							</div>
						</div>

					</div>
				</div>

			</div>

		</div>
	</div>
</div>