<div class="full_container">
	<div class="container">
		<div class="row paddingtb40">
			<div class="col-xs-12">
				<?php echo $this->Session->flash();?>
				<!--signup box starts-->
				<div class="login-container">
					<div class="position-relative">
						<div class="signup-box widget-box no-border login-box visible widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<h4 class="header lighter bigger signupblue bold" style="font-weight: bold"> Retrieve Password </h4>
									<div class="space-6"></div>
									<p>
										Enter your email to receive instructions
									</p>
									<?php echo $this->Form->create('User',array('id'=>'forgot-password'));?>
										<fieldset>
											<label class="block clearfix"> <span class="block">
													<?php echo $this->Form->input('email',array('div'=>FALSE,'label'=>FALSE,'type'=>'email','placeholder'=>'Email','class'=>'form-control'));?>
												</span> </label>
											<div class="rememberforgot">
												<label class="block backtologin"> <i class="icon-arrow-left icon-on-left"></i> <?php echo $this->Html->link('Back to login','/login');?></label>
											</div>
											<div class="loginwrapper sendme">
												<div class="right-inner-addon">
													<?php echo $this->Form->submit('Submit',array('class'=>'width-65 pull-right btn btn-sm btn-success'));?>
												</div>
											</div>
										</fieldset>
									</form>
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
		$("#forgot-password").validate({
			rules: {
				'data[User][email]': {
					required : {
        			     depends:function() {
            			            $(this).val($.trim($(this).val()));
            		               	return true;
        			     }
        			},
					email : true
				}
			},
			messages: {
				'data[User][email]': {
					required : "Please enter your email!",
					email : "Please enter valid email!"
				}
			}
		});
	});			
</script>