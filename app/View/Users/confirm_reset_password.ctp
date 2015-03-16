<div class="full_container">
	<div class="container">
		<div class="row paddingtb40">
			<div class="col-xs-12">
				<?php echo $this->Session->flash('auth');?>
				<?php echo $this->Session->flash();?>
				<!--signup box starts-->
				<div class="login-container">
					<div class="position-relative">
						<div class="signup-box widget-box no-border login-box visible widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<h4 class="header lighter bigger signupblue bold"> Change Password </h4>
	
									<div class="space-6"></div>
	
									<!-- <form id="loginform" name="loginform"> --> 
									<?php echo $this->Form->create('User',array('id'=>'PasswordReset'));?>
									<?php $this->Form->inputDefaults(array('label' => false,'div' => false,'class' => 'form-control'));?>
									<?php echo $this->Form->hidden('id',array('value'=>$findUser['User']['id']));?>	
										<fieldset>
											<label class="block clearfix"> 
												<span class="block">
													<?php echo $this->Form->password('password',array('placeholder'=>'Password','id'=>'password12','class'=>'form-control'));?>
												</span> 
											</label>
	
											<label class="block clearfix"> <span class="block">
												<?php echo $this->Form->password('confirm_password',array('placeholder'=>'Confirm password','class'=>'form-control'));?>
												</span> </label>
											<div class="rememberforgot">
												<label class="block">
													&nbsp; 
												</label>
											</div>
											<div class="loginwrapper">
												<?php echo $this->Form->submit('Submit',array('class'=>'width-65 pull-right btn btn-sm btn-success'));?>
											</div>
										</fieldset>
									<?php echo $this->Form->end();?>
								</div>
							</div><!-- /widget-body -->
						</div><!-- /signup-box -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$("#PasswordReset").validate({
			rules: {
				'data[User][password]': {
					required : true,
					minlength: 6
					
				},
				'data[User][confirm_password]': {
					required: true,
					minlength: 6,
					equalTo: "#password12"
				}
			},
			messages: {
				'data[User][password]': {
					required : "Please enter password",
					minlenght : "Password should be atleast 6 character long"
				},
				'data[User][confirm_password]': {
					required : "Please confirm password",
					minlenght : "Password should be atleast 6 character long",
					equalTo : "Password and Confirm Password is different"
				}
			}
		});
	});			
</script>