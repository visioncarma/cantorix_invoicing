<?php
  $ack = 'Success';
?>
<div class="full_container">
	<div class="container">
		<div class="row paddingtb40">
			<div class="col-xs-12">
				<!--signup box starts-->
				<div class="login-container login-container-message payment-container">
					<div class="position-relative">
						<div class="signup-box widget-box no-border login-box visible widget-box no-border ">
							<div class="widget-body ">
								<div class="widget-main fontbig15 ">
									<?php if($subscriptionType == 'Free') { ?>
										<h2 class="">Thank you for Registering ! </h2>
									<?php } else { ?>	
									<h2 class="">You Just Completed Your Payment </h2>
									<div class="font15 ">
										Your account information has been sent to your email address,
									</div>
									<div class="font15 ">
										please check your email and follow the instructions.
									</div>
									<div class="space-12"></div>								

									<div class="width100per floatleft paddingbottom10">
										<div class="col-xs-5 nopadding">
											Profile Status
										</div>
										<div class="col-xs-7 nopadding bold">
											<?php echo $profile_status; ?>
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10">
										<div class="col-xs-5 nopadding">
											Payment Type
										</div>
										<div class="col-xs-7 nopadding bold">
											Paypal- Express Checkout
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10">
										<div class="col-xs-5 nopadding">
											signup date
										</div>
										<div class="col-xs-7 nopadding bold">
											<?php echo date("d M Y"); ?>
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10">
										<div class="col-xs-5 nopadding">
											Subscription Amount
										</div>
										<div class="col-xs-7 nopadding bold">
											<?php echo $bill_amount; ?>
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10" >
										<div class="col-xs-5 nopadding">
											 Status
										</div>
										<div class="col-xs-7 nopadding bold green">
											 <i class="icon-ok green"></i> <?php echo $ack; ?> 
										</div>
									</div>
									<?php } ?>
								</div>
							</div><!-- /widget-body -->
						</div><!-- /signup-box -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>