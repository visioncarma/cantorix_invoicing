<?php
  $ack = 'Success';
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="#">Home</a>
		</li>
		<li>
			<a href="#">Settings</a>
		</li>
		<li>
			<?php echo $this->Js->link('Change Subscription',array('controller'=>'subscribers','action'=>'changeSubscription'),array('update'=>'#pageContent'));?>
		</li>
		<li class="active">
			Payment Details
		</li>
	</ul><!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 class="managecustomer"> Payment Details </h1>
	</div>
	<!-- /.page-header -->
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

									<h2 class="">You Just Completed Your Payment </h2>
									
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
											Sign Up Date
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
											<?php echo $ack; ?>
										</div>
									</div>

								</div>
							</div><!-- /widget-body -->
						</div><!-- /signup-box -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>