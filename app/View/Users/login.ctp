<?php 
	if($cookieValues['username']) {
		$user = $cookieValues['username'];
	} else {
		$user = $cookieValues['email'];
	}
?>
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
									<h4 class="header bigger signupblue bold"> Sign In </h4>
									<span class="info">Please enter your information</span>
									<div class="space-6"></div>
									<!-- <form id="loginform" name="loginform"> --> 
									<?php echo $this->Form->create('User',array('id'=>'loginform'));?>
									<?php $this->Form->inputDefaults(array('label' => false,'div' => false,'class' => 'form-control'));?>	
										<fieldset>
											<label class="block clearfix"> <span class="block">
												<?php echo $this->Form->input('username',array('placeholder'=>'Username','value'=>trim($user)));?>
												</span> </label>
	
											<label class="block clearfix"> <span class="block">
												<?php echo $this->Form->password('password',array('placeholder'=>'Password','class'=>'form-control'));?>
												</span> </label>
											<div class="rememberforgot">
												<label class="block">
													<input type="checkbox" class="ace" />
													<?php echo $this->Form->checkbox('remember_me',array('class'=>'ace','checked'=>$cookieValues['rememberMe']));?>
													<span class="lbl rememberme"> Remember me </span> </label>
												<label class="block"> <?php echo $this->Html->link('Forgot Password ?',array('controller'=>'users','action'=>'forgotPassword'),array('class'=>'forgotpassword'));?></label>
											</div>
											<?php if($captcha):?>
											<p class="typecode" style="clear: both;">
												Type the code shown below
											</p>
											<div class="captchaa">
												<?php echo $this->Html->image($this->Html->url(array('controller'=>'users', 'action'=>'captcha'), true),array('id'=>'img-captcha','vspace'=>2));
												echo $this->Html->link($this->Html->image("referesh.png",array('id'=>'a-reload', 'class'=>'')),'',array('escape'=>false)); 											
												echo $this->Form->input('captcha',array('autocomplete'=>FALSE,'label'=>false,'style'=>'width:145px;')); ?>
												<?php echo $securityError;?>
											</div>
											
											<?php endif;?>
											<div class="loginwrapper">
												<?php echo $this->Form->submit('Sign In',array('class'=>'width-65 pull-right btn btn-sm btn-success'));?>
											</div>
										</fieldset>
									</form>
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
		$("#loginform").validate({
			rules: {
				'data[User][username]': "required",
				'data[User][password]': "required",
				<?php if($captcha):?>
					'data[User][captcha]': "required"
				<?php endif;?>
			},
			messages: {
				'data[User][username]': "Please enter Username",
				'data[User][password]': "Please Enter Password",
				<?php if($captcha):?>
					'data[User][captcha]': "Please Enter Security Code"
				<?php endif;?>
			}
		});
	});			
</script>
<script>
$('#a-reload').click(function() {
	var $captcha = $("#img-captcha");
    $captcha.attr('src', $captcha.attr('src')+'?'+Math.random());
	return false;
});
</script>