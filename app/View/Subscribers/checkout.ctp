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
			Payment Details
		</li>
	</ul><!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 class="managecustomer"> Payment Details </h1>
	</div>
	<!-- /.page-header -->
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
		<p>Note:</p>
		<p> 1.Your current <i><?php echo $currenttPPlanName['CpnSubscriptionPlan']['type'];?></i> subscription plan will remain until <?php echo date('jS \of F Y',strtotime($profilestartdate.' -1 month'));?> thereafter the subscription plan will change to <i><?php echo $subscriptionType ?></i> Subscription with effect from <?php echo date('jS \of F Y',strtotime($profilestartdate));?></p>
		<p> 2.The monthly recurring charge for <i><?php echo $subscriptionType ?></i> subscription plan will be applied on the <?php echo date('jS',strtotime($profilestartdate));?> of each month.</p>
	</div>
	<?php echo $this -> Form -> create('paymentForm',array('url' => array('controller' => 'users', 'action' => 'changeSubscriptionCheckout','subscribers','changeSubscription','downgrade'),'id'=>'paymentForm')); ?>
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
</div>
<?php echo $this->Js->writeBuffer();?>