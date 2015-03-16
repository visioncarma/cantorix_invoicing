<?php
 $ack = 'Failure';
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
			<?php echo $this->Js->link('Change Subscription',array('action'=>'changeSubscription'),array('update'=>'#pageContent'));?>
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

									<h2 class="">Due to some Error </h2>
									<div class="font15 ">
										Your Change Subscription is not Successful,
									</div>
									<div class="font15 ">
										Please try again ! Sorry for inconvenience.
									</div>
									<div class="space-12"></div>
							<?php if($methodError) { ?>
									<div class="width100per floatleft paddingbottom10">
										<div class="col-xs-5 nopadding">
											Error
										</div>
										<div class="col-xs-7 nopadding bold">
											<?php echo $methodError.' failed';  ?>
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10">
										<div class="col-xs-5 nopadding">
											Error Code
										</div>
										<div class="col-xs-7 nopadding bold">
											<?php echo $errorCode; ?>
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10">
										<div class="col-xs-5 nopadding">
											Small Message
										</div>
										<div class="col-xs-7 nopadding bold">
											<?php echo $errorSmallMsg; ?>
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10">
										<div class="col-xs-5 nopadding">
											Long Message
										</div>
										<div class="col-xs-7 nopadding bold">
											<?php echo $errorLongMsg; ?>
										</div>
									</div>

									<div class="width100per floatleft paddingbottom10">
										<div class="col-xs-5 nopadding">
											Server Code
										</div>
										<div class="col-xs-7 nopadding bold">
											<?php echo $serverCode; ?>
										</div>
									</div>
							<?php } ?>
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