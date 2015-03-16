<?php echo $this->Session->flash();?>
<?php echo $this->Session->flash('Auth');?>
<div class="full_container">
	<div class="container">
		<div class="row paddingtb40">
			<div class="col-xs-12">
				<!--signup box starts-->
				<div class="login-container">
					<div class="position-relative">
						<div class="signup-box widget-box no-border login-box visible widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<h4 class="header lighter bigger signupblue bold"> Activate Your Account </h4>
									<p>
										Please complete your password confirmation details to continue
									</p>
									<?php echo $this->Form->create('User',array('id'=>'PasswordReset'));?>
										<fieldset>
											<label class="block clearfix"> <span class="block">
													<?php ?>
													<?php echo $this->Form->hidden('email',array('value'=>$userEmail));?>
													<?php echo $this->Form->password('password',array('placeholder'=>'Password','id'=>'password12','class'=>'form-control'));?>
												</span> </label>
											<label class="block clearfix"> <span class="block">
													<?php echo $this->Form->password('confirm_password',array('placeholder'=>'Confirm password','class'=>'form-control'));?>
												</span> </label>
											<label class="block clearfix">
												<div class="loginwrapper sendme pull-right">
													<div class="right-inner-addon">
														<?php echo $this->Form->submit('Login',array('class'=>'width-65 pull-right btn btn-sm btn-success sendme'));?>
													</div>
												</div> </label>
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