<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
	$settings = $this->Breadcrumb->getLink('Settings');
	
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript" src="">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>

	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Subscription Plans'),array('controller'=>'SubscriptionPlans','action'=>'index'));?>
		</li>
		<li class="active">
			<?php echo __('Add Subscription Plans');?>
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1> <?php echo __('Add Subscription Plans');?> </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back', array('action' => 'index'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>false)); ?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<?php echo $this->Form->create('CpnSubscriptionPlan',array('class'=>'form-horizontal','role'=>'form')); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right"> <?php echo __('Plan Type');?> </label>

					<div class="col-sm-10 relative">
						<div class="col-xs-10 ol-sm-5 col-lg-3 nopaddingleft nopaddingright labelerror">
						<?php echo $this->Form->input('type',array('label'=>false,'div'=>false,'id'=>'form11','class'=>'form-control selectpicker selectitem','options'=>array(''=>'Select Plan Type','Free'=>'Free','Standard'=>'Standard','Unlimited'=>'Unlimited')));?>
					   </div>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-2"> <?php echo __('Validity');?> </label>

					<div class="col-sm-10">
						<?php echo $this->Form->input('validity',array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-2','class'=>'col-xs-10 ol-sm-5 col-lg-3'));?>
						<span class="help-button new-help" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter the validity in days.For unlimited validity enter -1">?</span>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-3"><?php echo __('No of Staff');?> </label>

					<div class="col-sm-10">
						<?php echo $this->Form->input('no_of_staffs',array('id'=>'form-field-3','div'=>false,'label'=>false,'type'=>'text','class'=>'col-xs-10 ol-sm-5 col-lg-3'));?>
						<span class="help-button new-help" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter number staffs allowed per subscription.For unlimited staffs enter -1">?</span>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-4"> <?php echo __('No of Clients');?> </label>

					<div class="col-sm-10">
						<?php echo $this->Form->input('no_of_clients',array('id'=>'form-field-4','div'=>false,'label'=>false,'type'=>'text','class'=>'col-xs-10 ol-sm-5 col-lg-3'));?>
						<span class="help-button new-help" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter number of clients per subscription.For unlimited clients enter -1">?</span>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-5"> <?php echo __('No of Invoices');?> </label>

					<div class="col-sm-10">
						<?php echo $this->Form->input('no_of_invoices',array('id'=>'form-field-5','div'=>false,'label'=>false,'type'=>'text','class'=>'col-xs-10 ol-sm-5 col-lg-3'));?>
						<span class="help-button new-help" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter number of invoices per subscription.For unlimited invoices enter -1">?</span>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-6"> <?php echo __('Cost');?> </label>

					<div class="col-sm-10">
						<?php echo $this->Form->input('cost',array('id'=>'form-field-6','div'=>false,'label'=>false,'type'=>'text','class'=>'col-xs-10 ol-sm-5 col-lg-3'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-7"><?php echo __('Overdue Days for Archival');?></label>

					<div class="col-sm-10">
						<?php echo $this->Form->input('archieve_days',array('id'=>'form-field-7','div'=>false,'label'=>false,'type'=>'text','class'=>'col-xs-10 ol-sm-5 col-lg-3'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group marginbottomzero">
					<label class="col-sm-2 control-label no-padding-right" for="form-field-8"> <?php echo __('Overdue Days for Deletion');?></label>

					<div class="col-sm-10">
						<?php echo $this->Form->input('deletion_days',array('id'=>'form-field-8','div'=>false,'label'=>false,'type'=>'text','class'=>'col-xs-10 ol-sm-5 col-lg-3'));?>
					</div>
				</div>
				<div class="clearfix form-actions margintopzero ">
					
					<div class="col-md-offset-2 col-md-3 nopaddingleft nopaddingright ">
						<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('type'=>'submit','class'=>'btn btn-info'));?>
						<?php  echo $this->Form->button('<i class="icon-undo bigger-110"></i>Reset',array('type'=>'reset','class'=>'btn btn-inverse'));?>
					</div>
				</div>

			<?php echo $this->Form->end();?>
		</div>
	</div>
</div><!-- /.page-content -->
</div><!-- /.main-content -->
</div><!-- /.main-container-inner -->

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a>

<script type="text/javascript">
	jQuery(function($) {
		$('[data-rel=popover]').popover({container:'body'});				
	})
	$(document).ready(function(){
		
		if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 

		$.validator.addMethod("numbersOnly", function (value, element) {
		    return /^([0-9]+|-1)$/.test(value);
		}, "Invalid entry, please enter -1 or any positive number");	

 	$("#CpnSubscriptionPlanAddForm").validate({
 		 ignore: [], 
		 rules: {           
			"data[CpnSubscriptionPlan][type]": {
				required : true
			},			
			"data[CpnSubscriptionPlan][validity]":{
				required : true,
				numbersOnly : true
			},
			"data[CpnSubscriptionPlan][no_of_staffs]":{
				required : true,
				numbersOnly : true
			},
			"data[CpnSubscriptionPlan][no_of_clients]":{
				required : true,
				numbersOnly : true
			},
			"data[CpnSubscriptionPlan][no_of_invoices]":{
				required : true,
				numbersOnly : true
			},
			"data[CpnSubscriptionPlan][cost]":{
				required : true,
				number : true
			},
			"data[CpnSubscriptionPlan][archieve_days]":{
				required : true,
				digits : true
			},
			"data[CpnSubscriptionPlan][deletion_days]":{
				required : true,
				digits : true
			}
		 },
		 messages:{			 
			 "data[CpnSubscriptionPlan][type]":{
				required: "Please select plan type"				
		 	 },
			 "data[CpnSubscriptionPlan][validity]":{
				required: "Please enter the validity",
				numbersOnly: "Invalid entry, please enter -1 or any positive number"
		    },
		    "data[CpnSubscriptionPlan][no_of_staffs]":{
				required: "Please enter no of staffs",
				numbersOnly: "Invalid entry, please enter -1 or any positive number"
		    },
		     "data[CpnSubscriptionPlan][no_of_clients]":{
				required: "Please enter no of clients",
				numbersOnly: "Invalid entry, please enter -1 or any positive number"
		 	 },
		 	  "data[CpnSubscriptionPlan][no_of_invoices]":{
				required: "Please enter no of invoices",
				numbersOnly: "Invalid entry, please enter -1 or any positive number"
		 	 },
		 	  "data[CpnSubscriptionPlan][cost]":{
				required: "Please enter the cost",
				number:"Please enter number or decimal"
		 	 },
		 	  "data[CpnSubscriptionPlan][archieve_days]":{
				required: "Please enter overdue days for archival",
				digits:"Please enter digits"
		 	 },
		 	  "data[CpnSubscriptionPlan][deletion_days]":{
				required: "Please enter overdue days for deletion",
				digits:"Please enter digits"
		 	 }
		 }
	});	
	$('body').on('change','.selectitem',function(){
	var thisvalue = $('.selectitem option:selected').text();
	if (thisvalue=="Select Plan Type")
	   {
	   	 $(this).next('.error').show();
	   }
	   else{
	   	  $(this).next('.error').hide();
	   }
    });	 	
	});
</script>
