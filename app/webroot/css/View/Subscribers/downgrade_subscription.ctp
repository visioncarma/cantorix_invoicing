<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
	$settings = $this->Breadcrumb->getLink('Settings');
?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		<li>
			<?php echo $this->Js->link('Change Subscription',array('action'=>'changeSubscription'),array('update'=>'#pageContent'));?>
		</li>
		<li class="active">
			Downgrade Subscription
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1> Downgrade Subscription </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Js->link('<i class="icon-arrow-left icon-on-left"></i> Back ',array('action'=>'changeSubscription'),array('update'=>'#pageContent','class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12 pricing-span-body pricing-span-bodypaddingneed">
			<div class=" login-container downgrade_subscription">
				<div class="position-relative">
					<div class="center bolder">
						<h2 class="smaller bolder"> Choose Your Pricing Option </h2>
					</div>
					<div class="pricing-span3 span100percentblue bluetheme commoncellpaddinggg">

						<div class="pricingboxx rightbottomshadow">

							<div class="pricingboxx_head">
								<div class="pricingboxx_headinner">
									<h5 class="bigger bolder col-xs-12"> Standard </h5>
								</div>
							</div>

							<div class="common_priceboxrow common_memory pricegreen">
								<h5 class="pricee bolder bluetext col-xs-12"> $<?php echo $standard['CpnSubscriptionPlan']['cost']?>  / Month</h5>
							</div>

							<div class="common_priceboxrow common_priceboxrow_tablebody">
								<div >
									No of customers you can manage
								</div>

								<div class="bolder">
									<?php 
									 	if($plan['CpnSubscriptionPlan']['type'] == 'Free') {
									 		if($standard['CpnSubscriptionPlan']['no_of_clients'] == -1) {
									 			echo 'Unlimited (30 days trial)';
									 		} else {
									 			echo $standard['CpnSubscriptionPlan']['no_of_clients'].' (limited to 30 days trial)'; 
									 		}
									 	} else {
									 		if($plan['CpnSubscriptionPlan']['no_of_clients'] == -1) {
												echo 'Unlimited';
											} else {
												echo $standard['CpnSubscriptionPlan']['no_of_clients'];
											}
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
										if($standard['CpnSubscriptionPlan']['no_of_staffs'] == -1) {
											echo 'Unlimited';  
										} else {
											echo $standard['CpnSubscriptionPlan']['no_of_staffs']; 
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
										if($standard['CpnSubscriptionPlan']['no_of_invoices'] == -1) {
											 echo 'Unlimited'; 
										} else {
											echo $standard['CpnSubscriptionPlan']['no_of_invoices'];
										}
									?>
								</div>

							</div>

							<div class="common_priceboxrow_signup common_priceboxrow_signup_downgrade">

								<div class="pricing_signupp">
									<div class="">
										<?php echo $this->Js->link('Select',array('action'=>'checkout',$standard['CpnSubscriptionPlan']['id']),array('class'=>'uppercase textdecor btn btn-primary bolder btn-lg','update'=>'#pageContent'));?>
									</div>

								</div>
							</div>

						</div>

					</div>
				</div>
			</div>

		</div>
	</div>
</div><!-- /.page-content -->

<script type="text/javascript">
	$('[data-rel=popover]').popover({
		container : 'body'
	}); 
</script>
<?php echo $this->Js->writeBuffer();?>