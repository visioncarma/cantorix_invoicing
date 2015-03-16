<?php echo $this->Session->flash();?>
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

			<li class="active">
				Change Subscription
			</li>
		</ul><!-- .breadcrumb -->
	</div>

	<div class="page-content">
		<div class="page-header">
			<h1> Change Subscription </h1>
			<!--<div class="col-lg-2 paddingleftrightzero">
				<a class="btn btn-sm btn-success pull-right addbutton" href="#"> <i class="icon-arrow-left icon-on-left"></i> Back </a>
			</div>-->
		</div>
		<!-- /.page-header -->
		<div class="row">
			
			<div class="col-xs-12 col-lg-12 col-sm-9 col-md-9 pricing-span-body pricing-span-bodypaddingneed">
				
				<div class=" login-container downgrade_subscription">
				<div class="position-relative">
					
				<div class="pricing-span3 span100percent">
					<div class="pricingboxx rightbottomshadow">

						<div class="pricingboxx_head">
							<div class="pricingboxx_headinner">
								<h5 class="bigger bolder col-xs-12"> Current Subscription - <?php echo $plan['CpnSubscriptionPlan']['type'];?> </h5>
							</div>
						</div>

						<div class="common_priceboxrow common_memory pricegreen">
							<h5 class="pricee bolder greenn col-xs-12"> $<?php echo $plan['CpnSubscriptionPlan']['cost']?> / Month</h5>
						</div>

						<div class="common_priceboxrow common_priceboxrow_tablebody">
							<div class="col-xs-8 ">
								No of customers you can manage
							</div>

							<div class="col-xs-4 bolder">
								 <?php 
								 	if($plan['CpnSubscriptionPlan']['type'] == 'Free') {
								 		if($plan['CpnSubscriptionPlan']['no_of_clients'] == -1) {
								 			echo 'Unlimited (30 days trial)';
								 		} else {
								 			echo $plan['CpnSubscriptionPlan']['no_of_clients'].' (limited to 30 days trial)'; 
								 		}
								 	} else {
								 		if($plan['CpnSubscriptionPlan']['no_of_clients'] == -1) {
											echo 'Unlimited';
										} else {
											echo $plan['CpnSubscriptionPlan']['no_of_clients'];
										}
								 	}
								?>
							</div>

						</div>

						<div class="common_priceboxrow common_priceboxrow_tablebody">
							<div class="col-xs-8">
								Additional staff who can access your account
							</div>
							<div class="col-xs-4 bolder">
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
							<div class="col-xs-8">
								No of invoices you can send
							</div>
							<div class="col-xs-4 bolder">
								<?php 
									if($plan['CpnSubscriptionPlan']['no_of_invoices'] == -1) {
										 echo 'Unlimited'; 
									} else {
										echo $plan['CpnSubscriptionPlan']['no_of_invoices'];
									}
								?>
							</div>

						</div>

					</div>
				</div>
				
				<div class="left width100 margin20top">
					<?php if($plan['CpnSubscriptionPlan']['type'] != 'Unlimited') { ?>
						
					<?php
						if(($invoices['CpnSubscriberInvoiceDetail']['payment_status'] == 'Pending' || $invoices['CpnSubscriberInvoiceDetail']['payment_status'] == 'Failed' || $invoices['CpnSubscriberInvoiceDetail']['outstanding_balance'] > 0)) {
							echo '<div class="left paddingleftrightzero col-lg-6 col-md-6 col-sm-6">
									<button data-target="#upgradegrade" data-toggle="modal" class="col-lg-12 btn btn-sm btn-success pull-left upgradeblue">
										Downgrade Subscription
									</button>
								</div>';
						} else {
					?>	
					<div class="left paddingleftrightzero col-lg-6 col-md-6">
						<?php echo $this->Js->link('Upgrade Subscription',array('controller'=>'subscribers','action'=>'upgradeSubscription'),array('class'=>'col-lg-12 btn btn-sm btn-success pull-left upgradeblue','update'=>'#pageContent'));?>
					</div>
					<?php }?>
					<?php }?>
					
					<?php if($plan['CpnSubscriptionPlan']['type'] == 'Unlimited') {
						
							if($usersCount > $standardPlan['CpnSubscriptionPlan']['no_of_staffs'] && $standardPlan['CpnSubscriptionPlan']['no_of_staffs'] != -1) {
								echo '<div class="left paddingleftrightzero col-lg-6 col-md-6">
										<button data-target="#downgrade" data-toggle="modal" class="col-lg-12 btn btn-sm btn-success pull-left upgradeblue">
											Downgrade Subscription
										</button>
									</div>';
							} elseif($customersCount > $standardPlan['CpnSubscriptionPlan']['no_of_clients'] && $standardPlan['CpnSubscriptionPlan']['no_of_clients'] != -1) {
								echo '<div class="left paddingleftrightzero col-lg-6 col-md-6">
										<button data-target="#downgrade" data-toggle="modal" class="col-lg-12 btn btn-sm btn-success pull-left upgradeblue">
											Downgrade Subscription
										</button>
									</div>';
							} elseif(($invoices['CpnSubscriberInvoiceDetail']['payment_status'] == 'Pending' || $invoices['CpnSubscriberInvoiceDetail']['payment_status'] == 'Failed' || $invoices['CpnSubscriberInvoiceDetail']['outstanding_balance'] > 0)) { 
								echo '<div class="left paddingleftrightzero col-lg-6 col-md-6">
										<button data-target="#downgrade" data-toggle="modal" class="col-lg-12 btn btn-sm btn-success pull-left upgradeblue">
											Downgrade Subscription
										</button>
									</div>';
							} else {
						 ?>
					<div class="left paddingleftrightzero padingleftneed col-lg-6 col-md-6 col-sm-6">
						<?php echo $this->Js->link('Downgrade Subscription',array('controller'=>'subscribers','action'=>'downgradeSubscription'),array('class'=>'col-lg-12 btn btn-sm btn-success pull-left upgradeblue','update'=>'#pageContent'));?>
					</div>
					<?php }?>
					<?php }?>
					
					<div class="left paddingleftrightzero padingleftneed marginneedtop col-lg-6 col-md-6 col-sm-6 nopaddingmobile">
						<button data-target="#cancelsubscription" data-toggle="modal" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-sm btn-success pull-left cancelredd widthfulmobcance">
							Cancel Subscription
						</button>
					</div>
				</div>
				
				</div>
				</div>

				

			</div>
		</div>
	</div><!-- /.page-content -->
	<?php echo $this->Html->script(array('jquery.flot.min.js','jquery.flot.pie.min.js','jquery.flot.resize.min.js'));?>
	<script type="text/javascript">
		$('[data-rel=popover]').popover({container:'body'});
	</script>
	<!-- ace scripts -->
	
	<!-- inline scripts related to this page -->
	<!--Popup add  -->
<div class="modal fade" id="cancelsubscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modaldialogcancel475">
    <div class="modal-content width100 left">
      <div class="modalinside left width100">
       <div class="pull-right"> <?php echo $this->Html->image('close_icon.png',array('class'=>'pointer','data-dismiss'=>'modal'));?> </div>  
    
      <form class="form-horizontal popup no-border" role="form" id="addnewcurrency" method="POST">
      <div class="modal-body">
         <div class="model-body-inner-content">  
         	<div>
			 <h3 class="bolder red 22pfont center"> Cancel Subscription </h3>
			 <div class="center 14pfont paddingbottom">
			 	<?php 
			 		if($plan['SbsSubscriber']['status'] == 'Active') {
			 			echo 'Are you sure you want to cancel the subscription.';
			 		} elseif($plan['SbsSubscriber']['status'] == 'Cancelled') {
			 			echo 'You\'ve already <strong> cancellation </strong> your subscription!';
			 		} elseif($plan['SbsSubscriber']['status'] == 'Pending' || $plan['SbsSubscriber']['status'] == 'Suspended' || $plan['SbsSubscriber']['status'] == 'Cancelled' || $plan['SbsSubscriber']['status'] == 'Expired' ) {
			 			echo 'Your supscription is <strong>'.$plan['SbsSubscriber']['status'].'</strong>! couldn\'t cancel subscription';
			 		}
				?> 
			 	 
			 </div>
			 <div class="space-12"></div>
			 
			 <div class="paddingleftrightzero padingleftneed buttoncenter">
			 	<?php 
			 		if($plan['SbsSubscriber']['status'] == 'Active') {
			 			echo $this->Html->link('Confirm',array('controller'=>'subscribers','action'=>'cancelSubscription',$id),array('class'=>'btn btn-sm btn-success  cancelredd'));
			  		} elseif($plan['SbsSubscriber']['status'] == 'Suspended' || $plan['SbsSubscriber']['status'] == 'Cancelled' || $plan['SbsSubscriber']['status'] == 'Pending' || $plan['SbsSubscriber']['status'] == 'Expired') {?>
			  			<button class="btn btn-sm btn-success  cancelredd" data-dismiss="modal">
							Close
			   			</button>
			  <?php } ?>
			</div>
			 <div class="space-6"></div>
			<p>
				<span class="bolder"> Please note: </span> You can cancel at any point before the 1st of next month. If you cancel after 1st our billing cycle has already run and your cancellation will only be effective for the end of the next month.'
			</p>
            </div>			
          </div>
      </div>
     
        </form>
	  </div>
    </div>
  </div>
</div>
<!--end of pop--> 

<!--Popup add  -->
<div class="modal fade" id="downgrade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modaldialogcancel475">
    <div class="modal-content width100 left">
      <div class="modalinside">
       <div class="pull-right"> <?php echo $this->Html->image('close_icon.png',array('class'=>'pointer','data-dismiss'=>'modal'));?> </div>  
    
      <form class="form-horizontal popup no-border" role="form" id="addnewcurrency" method="POST">
      <div class="modal-body">
         <div class="model-body-inner-content">  
         	<div>
			 <h3 class="bolder red 22pfont center"> Downgrade Subscription </h3>
			 <div class="center 14pfont paddingbottom">
			 	<?php 
			 		if($usersCount > $standardPlan['CpnSubscriptionPlan']['no_of_staffs'] && $standardPlan['CpnSubscriptionPlan']['no_of_staffs'] != -1) {
			 			echo 'Staff limit exceeded! Please reduce the staffs to '. $standardPlan['CpnSubscriptionPlan']['no_of_staffs'] .' or below to downgrade subscription.';
			 		} elseif($customersCount > $standardPlan['CpnSubscriptionPlan']['no_of_clients'] && $standardPlan['CpnSubscriptionPlan']['no_of_clients'] != -1) {
						echo 'Customers limit exceeded! Please reduce the customers to '. $standardPlan['CpnSubscriptionPlan']['no_of_clients'] .' or below to downgrade subscription.';
			 		} elseif(($invoices['CpnSubscriberInvoiceDetail']['payment_status'] == 'Pending' || $invoices['CpnSubscriberInvoiceDetail']['payment_status'] == 'Failed' || $invoices['CpnSubscriberInvoiceDetail']['outstanding_balance'] == 0)) {
			 			echo 'Your invoice is due please clear the invoice dues to downgrade the plan.';
			 		}
				?> 
			 	 
			 </div>
			 <div class="space-12"></div>
			 
			 <div class="paddingleftrightzero padingleftneed buttoncenter">
	  			<button class="btn btn-sm btn-success  cancelredd" data-dismiss="modal">
					Close
	   			</button>
			</div>
			 <div class="space-6"></div>
            </div>			
          </div>
      </div>
     
        </form>
	  </div>
    </div>
  </div>
</div>
<!--end of pop-->


<!--Popup add  -->
<div class="modal fade" id="upgrade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modaldialogcancel475">
    <div class="modal-content">
      <div class="modalinside left width100">
       <div class="pull-right"> <?php echo $this->Html->image('close_icon.png',array('class'=>'pointer','data-dismiss'=>'modal'));?> </div>  
    
      <form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
      <div class="modal-body">
         <div class="model-body-inner-content">  
         	<div>
			 <h3 class="bolder red 22pfont center"> Upgrade Subscription </h3>
			 <div class="center 14pfont paddingbottom">
			 	<?php 
			 		if(($invoices['CpnSubscriberInvoiceDetail']['payment_status'] == 'Pending' || $invoices['CpnSubscriberInvoiceDetail']['payment_status'] == 'Failed' || $invoices['CpnSubscriberInvoiceDetail']['outstanding_balance'] > 0)) {
			 			echo 'Your invoice is due please clear the invoice dues to downgrade the plan.';
			 		}
				?> 
			 	 
			 </div>
			 <div class="space-12"></div>
			 
			 <div class="paddingleftrightzero padingleftneed buttoncenter">
	  			<button class="btn btn-sm btn-success  cancelredd" data-dismiss="modal">
					Close
	   			</button>
			</div>
			 <div class="space-6"></div>
            </div>			
          </div>
      </div>
     
        </form>
	  </div>
    </div>
  </div>
</div>
<!--end of pop-->



<?php echo $this->Js->writeBuffer();?>