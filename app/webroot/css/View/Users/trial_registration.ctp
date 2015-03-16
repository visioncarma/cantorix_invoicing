<?php 
$organization_name 	= $this->Session->read('organization_name');
$billing_country 	= $visitorDetails['geoplugin_countryCode']; ?>
<div class="full_container">
	<div class="container">
		<div class="row paddingtb40">
			<div class="col-xs-12">
				<!--signup box starts-->
			<?php echo $this -> Form -> create('paymentForm',array('url' => array('controller' => 'users', 'action' => 'freeCheckout'),'id'=>'paymentForm')); ?>
				<div class="login-container payment-container">
					<div class="signup-box widget-box no-border login-box visible widget-box no-border">
						<div class="widget-body">
							<div class="widget-main">
								<div class="payment-box">
									<h3 class="payment-heading signupblue bold">Subcription Payment Details</h3>
									<div class="price-details">
										<div class="price-row">
											<div class="price-name">
												<p class="bold">
													Description
												</p>
											</div>
											<div class="price-value">
												<p class="bold">
													Item Price
												</p>
											</div>
										</div>
										<div class="price-row">
											<div class="price-name">
												<p>
													<?php echo $subscriptionType ?> Subcription
												</p>
											</div>
											<div class="price-value">
												<p>
													$<?php echo $subscriptionCost; ?>
												</p>
											</div>
										</div>
										<div class="price-row">
											<div class="price-name">
												<p>
													Service Tax
												</p>
											</div>
											<div class="price-value">
												<p>
													$<?php echo $serviceTax; ?>
												</p>
											</div>
										</div>
										<div class="price-row border-bottom-none">
											<div class="price-name">
												<p class="bold">
													Total
												</p>
											</div>
											<div class="price-value">
												<p class="bold">
													$<?php echo $billAmount; ?>
												</p>
											</div>
										</div>
									</div>
								</div>
								<?php
									echo $this -> Form -> hidden('currency_code', array('id' => 'currency_code', 'value' => $visitorDetails['geoplugin_currencyCode']));
									echo $this -> Form -> hidden('currency_symbol_UTF8', array('id' => 'currency_symbol_UTF8', 'value' => $visitorDetails['geoplugin_currencySymbol_UTF8']));								      
								?>
								<div class="payment-box">
									<h3 class="payment-heading signupblue bold">Billing Information</h3>
									<div class="billing-information">
										<div class="input-row">
											<?php echo $this->Form->input('organization_name',array('id'=>'organization_name','placeholder'=>'Company Name','div'=>false,'label'=>false,'class'=>'form-control', 'disabled' => 'disabled', 'value'=>"$organization_name"));?>
										</div>
										<div class="input-row">										
											<?php echo $this->Form->input('billing_address_line1',array('id'=>'billing_address_line1','placeholder'=>'Street Address','div'=>false,'label'=>false,'class'=>'form-control', 'value'=>"$billing_address_line1"));?>
										</div>
										<div class="input-row">										
											<?php echo $this->Form->input('billing_city',array('id'=>'billing_city','placeholder'=>'City','div'=>false,'label'=>false,'class'=>'form-control', 'value'=>"$billing_city"));?>
										</div>
										<div class="input-row">
											<?php echo $this->Form->input('billing_state',array('id'=>'billing_state','placeholder'=>'State/Province','div'=>false,'label'=>false,'class'=>'form-control', 'value'=>"$billing_state"));?>
										</div>
										<div class="input-row">
											<?php echo $this->Form->input('billing_country',array('id'=>'billing_country','label'=>false,'class'=>'form-control', 'placeholder'=> 'Country', 'options'=>array(''=>'Country',$countries),'default'=>$billing_country)); ?>
										</div>										
										<div class="input-row">
											<?php echo $this->Form->input('billing_zip',array('id'=>'billing_zip','placeholder'=>'ZIP/Postal Code','div'=>false,'label'=>false,'class'=>'form-control', 'value'=>"$billing_zip"));?>
										</div>
										<div class="input-row">											
											<?php  echo $this->Form->submit('Submit',array('div'=>false,'label'=>false,'class'=>'btn btn-primary normal-btn pull-right')); ?>
										</div>
									</div>
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