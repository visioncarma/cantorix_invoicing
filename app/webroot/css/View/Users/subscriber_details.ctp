<?php
	$name 	  =	$this->Session->read('name');
	$surname  = $this->Session->read('surname');
	$username =	$this->Session->read('username');
	if($subscriptionType == 'Free') {
		$action = 'trialRegistration';
	} else {
		$action = 'paymentDetails';
	}
?>
<div class="full_container">
	<div class="container">
		<div class="row paddingtb40">
			<div class="col-xs-12">
				<!--signup box starts-->
				<div class="login-container">
					<div class="position-relative">
						<div id= "login-box" class="signup-box widget-box no-border login-box visible widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<h4 class="header lighter bigger signupblue bold"> Subscriber Details </h4>

									<div class="space-6"></div>
									<?php echo $this -> Form -> create('subscriberForm',array('url' => array('controller' => 'users', 'action' => $action),'id'=>'subscriberForm')); ?>
										<fieldset>
											<label class="block clearfix"> <span class="block">
													<?php echo $this->Form->input('name',array('id'=>'name','placeholder'=>'Name','div'=>false,'label'=>false,'class'=>'form-control', 'value'=>"$name"));?>
												</span> 
												<span class="error-placement"></span>
											</label>

											<label class="block clearfix"> <span class="block">													
													<?php echo $this->Form->input('surname',array('id'=>'surname','placeholder'=>'Surname','div'=>false,'label'=>false,'class'=>'form-control', 'value'=>"$surname"));?>
												</span>
												<span class="error-placement"></span> 
												</label>
											<label class="block clearfix"> <span class="block">													
													<?php echo $this->Form->input('username',array('id'=>'username','placeholder'=>'Username','div'=>false,'label'=>false,'class'=>'form-control', 'value'=>"$username"));?>
												</span>
												<span class="error-placement"></span> 
												</label>
											<p class="typecode">
												Type the code shown below												
											</p>
											<label class="block">	
											<div class="captchaa">
												<?php echo $this->Html->image($this->Html->url(array('controller'=>'users', 'action'=>'captcha'), true),array('id'=>'img-captcha','vspace'=>2));
												echo $this->Html->link($this->Html->image("referesh.png",array('id'=>'a-reload', 'class'=>'')),'',array('escape'=>false)); 											
												echo $this->Form->input('captcha',array('autocomplete'=>'off','label'=>false,'class'=>'')); ?>												
												<?php echo $this->Session->flash(); ?>
											</div>
											</label>
											<div class="space-24"></div>
									  		<label class="block">												
												<?php echo $this->Form->checkbox('tc',array('class'=>'ace','div'=>FALSE,'label'=>FALSE));?>                 
												<span class="lbl"> Accept <a href="#modal-wizard-terms" data-toggle="modal" class="">Terms and Conditions</a> </span> 
												<span class="error-placement"></span>
											</label>

											<label class="block">
												<?php echo $this->Form->checkbox('policy',array('class'=>'ace','div'=>FALSE,'label'=>FALSE));?>
												<span class="lbl"> Accept <a href="#modal-wizard-privacy" data-toggle="modal" class="">Policy Information</a> </span> 
												<span class="error-placement"></span>
											</label>
											<div class="space-24"></div>
											<div class="clearfix">
												<!--<button type="reset" class="width-30 pull-left btn btn-sm">
													<i class="icon-refresh"></i>
													Reset
												</button>-->
												
												<div class="width-49 pull-left btn btn-sm btn-inverse">
													<i class="icon-refresh"></i>
													Reset
												</div>

												<div class="right-inner-addon">
												
													<?php  echo $this->Form->submit('Next',array('div'=>false,'label'=>false,'class'=>'width-49 pull-right btn btn-sm btn-success')); ?>
													<i class="icon-arrow-right icon-on-right"></i>
												</div>
																								
											</div>
										</fieldset>
									<?php echo $this -> Form -> end(); ?>
								</div>
							</div><!-- /widget-body -->
						</div>
					</div>
				</div>
				<!-- /signup-box -->
			</div>
		</div>
	</div>
</div>

<div id="modal-wizard-terms" class="modal" tabindex='-1'>
	<div class="modal-dialog">
	<div class="modal-content">
		<div class="modalinside">		
		<div class="pull-right"> <?php echo $this->Html->image('close_icon.png',array('class'=>'pointer', 'data-dismiss'=>'modal')); ?> </div>												
		<h4 class="header lighter bigger signupblue bold noborder">
			Terms and Conditions
		</h4>		
		<p> 
		There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words.</p>
		<p>
There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet etc.
		</p>
		</div>
	</div>
	</div>
</div>
		
<div id="modal-wizard-privacy" class="modal" tabindex='-1'>
	<div class="modal-dialog">
	<div class="modal-content">
		<div class="modalinside">		
		<div class="pull-right"> <?php echo $this->Html->image('close_icon.png',array('class'=>'pointer', 'data-dismiss'=>'modal')); ?> </div>												
		<h4 class="header lighter bigger signupblue bold noborder">
			Privacy 
		</h4>		
		<p> 
		There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words.</p>
		<p> 
There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet etc.
		</p>
		</div>
	</div>
	</div>
</div>

<script>
$(document).ready(function(){
	$('.btn.btn-sm.btn-success').click(function(){
		if($('#subscriberFormCaptcha').val()==''){
			$('.errorflashmessage').css('display','block');
		}
	});
	$('#subscriberFormCaptcha').focus(function(){		
		$('.errorflashmessage').hide();
	});	
});
$('#a-reload').click(function() {
	var $captcha = $("#img-captcha");
    $captcha.attr('src', $captcha.attr('src')+'?'+Math.random());
	return false;
});

$('body').on('click','.btn-inverse',function(){
		$('#name').val('');
		$('#surname').val('');
		$('#username').val('');
		$('#subscriberFormCaptcha').val('');
	});
</script>