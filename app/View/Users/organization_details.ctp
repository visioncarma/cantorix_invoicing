<?php if($this->Session->read('time_zone')) {
		$time_zone 	= 	$this->Session->read('time_zone');
} else { ?>
<script>
		$(document).ready(function(){			
			$.ajax({
				url: '<?php echo $this->webroot.'timezone_detect.php';?>',
				data: getTimeZoneData(),
				method: 'POST',
				dataType: 'JSON'
			}).done(function(data) {				
				$('#form-field-select-1').val(data);				
				$('.btn.dropdown-toggle.selectpicker.btn-default .filter-option').text($('#form-field-select-1 option:selected').text());
				$('.btn.dropdown-toggle.selectpicker.btn-default').attr('title',$('#form-field-select-1 option:selected').text());
				
			});
		});
</script>
<?php } 
	$organization_name 	=	$this->Session->read('organization_name');	
	$email_address		=	$this->Session->read('email');
?>
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
									<h4 class="header bigger signupblue bold"> Sign Up </h4>

									<div class="space-6"></div>
									<p>
										Enter your details to begin:
									</p>

									<?php echo $this -> Form -> create('organizationForm',array('url' => array('controller' => 'users', 'action' => 'subscriberDetails'),'id'=>'organizationForm')); ?>
										<fieldset>
											<label class="block clearfix"> <span class="block">													
													<?php echo $this->Form->input('organization_name',array('id'=>'organization_name','placeholder'=>'Company Name','div'=>false,'label'=>false,'class'=>'form-control', 'value'=>"$organization_name"));?>
												</span> </label>

											<label class="block clearfix"> <span class="block">
													<?php echo $this->Form->input('email_address',array('id'=>'email','placeholder'=>'Email Address','div'=>false,'label'=>false,'class'=>'form-control', 'value'=>"$email_address"));?>
												</span> </label>

											<label class="block clearfix"> <span class="block signupselect">
												<?php echo $this->Form->input('time_zone',array('id'=>'form-field-select-1','label'=>false,'data-live-search' => 'true','class'=>'form-control selectpicker', 'placeholder'=> 'Time Zone', 'options'=>array(''=>'Time Zone',$time_zones),'default'=>$time_zone));?>
											 </span> </label>

											<label class="block">
												<input type="checkbox" class="ace" />
												<span class="lbl"> Daylight Savings </span> </label>

											<div class="space-24"></div>

											<div class="clearfix">
												<div  class="width-49 pull-left btn btn-sm btn-inverse fontnormal">
													<i class="icon-refresh"></i>
													Reset
												</div>

												<div class="right-inner-addon">
													<?php  echo $this->Form->submit('Next',array('div'=>false,'label'=>false,'class'=>'width-49 pull-right btn btn-sm fontnormal btn-success')); ?>
													<i class="icon-arrow-right icon-on-right"></i>
												</div>

											</div>
										</fieldset>
									<?php echo $this -> Form -> end(); ?>
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
$(document).ready(function(){
	 
	$('body').on('click','.btn-inverse',function(){
		$('#organization_name').val('');
		$('#email').val('');
	});
	
	if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
     } 
});	
</script>
