<?php $counts = $this->Paginator->params();?>
<?php $pages = $this->Paginator->current('CpnCurrency');?>
<?php echo $this->Session->flash();?>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
	$settings = $this->Breadcrumb->getLink('Settings');
	if(!$currencyNameValue){ $currencyNameValue = "null"; }
	if(!$currencyCodeValue){ $currencyCodeValue = "null"; }
	if(!$filterBy){ $filterBy = "null"; }
	$url = array('controller'=>'SubscriberCurrencies','action'=>'add',$filterBy,$currencyNameValue,$currencyCodeValue);
	
	
	
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
		<li class="active">
			<?php echo __('Currency Settings');?>
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<!--<h1> <?php echo __('Manage Currency');?> </h1>-->
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600"><?php echo __('Manage Currency');?>  </div>
		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-8 no-padding-left no-padding-right width-after-600">
			<div class="widthauto paddingleftrightzero pull-right clear400 buttonrightwidth padding-right-3-480 margin-bottom-10-400 marginleft1">
				<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index'),array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right addbutton'));?>
			</div>
			
		</div>
	</div>
	<!-- /.page-header -->
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll">
				<div class="table-header">
					<?php echo __('Currency List');?>
				</div>
				<div class="row margin-twenty-zero filterdivmob">
				<?php echo $this->Form->create('filterCurrency',array('id'=>'filterCurrencyId','url'=>array('controller'=>'subscriber_currencies','action'=>'add')));?>                                            	    
                    <div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 nopadding col-lg-2 col-sm-3">
                    	<?php echo $this->Form->input('filterCurrency.currencyName',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'text','placeholder'=>'Enter Currency Name'));?>
                    	<?php /*echo $this->Form->input('filterCurrency.filterBy',array('label'=>false,'class'=>'form-control selectpicker','div'=>false,'options'=>array(''=>'Filter By','name'=>'Currency Name','code'=>'Currency Code')));*/?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-lg-2 col-sm-3 nopadding">
                     	<?php echo $this->Form->input('filterCurrency.currencyCode',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'text','placeholder'=>'Enter Currency Code'));?>
                     	<?php /*echo $this->Form->input('filterCurrency.value',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'text','placeholder'=>'Enter Value'));*/?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero clearlefttrespon mobile_100">
                     	<?php echo $this->Form->button('Filter',array('type'=>'submit','class'=>'btn btn-sm btn-primary filter-btn form-control mobile_100',array('controller'=>'Currencies','action'=>'index')));?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'SubscriberCurrencies','action'=>'add',1),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','update'=>'#pageContent'));?>
					</div>
                   <?php echo $this->Form->end();?>
                
	              
                </div>
                
                 <?php echo $this->Form->create('editCurrency',array('class'=>'custom-form-sl','role'=>'form','id'=>'editCurrency'));?>
					 <div class="row marginzero filterdivmob">
						 <div class="col-lg-2 col-xs-12 paddingleftrightzero marginbottom5" style="float:right;">
							<?php echo $this->Js->submit('Add Selected Currencies', array('url' => '/SubscriberCurrencies/multiCurrenyAdd',$filterBy,$value,$pages,'label'=>false,'div'=>false,'class'=>'btn btn-sm btn-primary filter-btn form-control','style'=>array('border-top-width: 0;margin-bottom: 0;margin-left:0px;margin-right: 0;margin-top:0px;'),'update' =>'#pageContent'));?>
						 </div>
					 </div>
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<th class="center"><label>
								
								 <input class="ace" type="checkbox">
								
								<span class="lbl"></span> </label></th>
								
							<th><?php echo $this->Paginator->sort('CpnCurrency.code','Currency Code',array('update'=>'#pageContent','url'=>$url)); ?></th>
							<th ><div class="btn-group"> <?php echo $this->Paginator->sort('CpnCurrency.name','Currency Name',array('update'=>'#pageContent','url'=>$url)); ?></div></th>
							
						</tr>
					</thead>

					<tbody>
					<?php $slno = null;?>
					<?php foreach ($cpnCurrencies as $cpnCurrency): ?>
					<?php echo $this->Form->hidden('editCurrency.page',array('value'=>$pages));?>
					<?php echo $this->Form->hidden('editCurrency.filterBy',array('value'=>$filterBy));?>
					<?php echo $this->Form->hidden('editCurrency.filterValue',array('value'=>$value));?>
						<?php $slno++;?>
						<tr>
							<td class="center"><label>
								<!--<input class="ace" type="checkbox">-->
								<?php echo $this->Form->input('Add.'.$cpnCurrency['CpnCurrency']['id'],array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace'));?>
								<span class="lbl"></span> </label></td>
							<td><span class="on-load"><?php echo h($cpnCurrency['CpnCurrency']['code']); ?></span>
							</td>
							<td > <div class="btn-group"> <span class="on-load"><?php echo h($cpnCurrency['CpnCurrency']['name']); ?>&nbsp;</span></div>
							</td>
						</tr>	
						<?php //echo $this->Form->end();?>
						<script type="text/javascript">
								$.validator.addMethod("lettersonly", function(value, element) {
								  return this.optional(element) || /^[a-z\s]+$/i.test(value);
								}, "Please enter only Alphabets"); 
								 $.validator.addMethod('correncycode', function(value) {            
								               var cc =  /^[A-Z]+$/ 
								                return value.match(cc);
								            }, 'Invalid Currency Code ');
								  $(document).ready(function(){
									  $("#editCurrency").validate({
										 rules: {           
											"data[CpnCurrency][code][<?php echo $cpnCurrency['CpnCurrency']['id']?>]": {
												required : true,
												correncycode: true
											},			
											"data[CpnCurrency][name][<?php echo $cpnCurrency['CpnCurrency']['id']?>]":{
												required : true,
												lettersonly : true
											}
										 },
										 messages:{			 
											 "data[CpnCurrency][code][<?php echo $cpnCurrency['CpnCurrency']['id']?>]":{
												required: "Please enter the Currency Code"
										 	 },
											 "data[CpnCurrency][name][<?php echo $cpnCurrency['CpnCurrency']['id']?>]":{
												required: "Please enter the Currency Name"		 	 }
										 }
									});	
								  });
					</script>	
					<?php endforeach;?>
					
					</tbody>
				</table>
				<?php echo $this->Form->end();?>
		</div>
		
		 <div class="row clear col-xs-12 paginationmaindiv">
                   <div class="col-sm-6">
                      <div id="sample-table-2_info" class="dataTables_info">
	                     	<?php
								echo $this->Paginator->counter(array(
									'format' => __('showing <span>{:start}</span> to <span>{:end}</span> of {:count}')
								));
							?>
                     	</div>
                      </div>
                    
	                      <div class="col-sm-6">
	                           <div class="dataTables_paginate paging_bootstrap">
	                                <ul class="pagination">
	                                	<?php
											$this->Paginator->options(array(
		     									'update' => '#pageContent',
												'evalScripts' => true,
												'url' => array('controller'=>'SubscriberCurrencies','action'=>'add',$filterBy,$currencyNameValue,$currencyCodeValue),
												'before' => $this->Js->get('#busy_indicator_back')->effect('fadeIn', array('buffer' => false)),
												'complete' => $this->Js->get('#busy_indicator_back')->effect('fadeOut', array('buffer' => false))
											)); 
											echo $this->Paginator->first('<i class="icon-double-angle-left"></i>', array('escape'=>false,'tag' => 'li','title'=>'First'), array('escape'=>false,'tag'=>'li','title'=>'First')); 
											echo $this->Paginator->prev('<i class="icon-angle-left"></i>', array('escape'=>false,'tag' => 'li','title'=>'Previous'), '',array('escape'=>false,'tag'=>'li','style'=>'display:none;'));
											echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentClass'=>'active','currentTag'=>'a'));
											echo $this->Paginator->next('<i class="icon-angle-right"></i>', array('escape'=>false,'tag' => 'li','title'=>'Next'),'<a href="#"><i class="icon-double-angle-right"></i></a>', array('escape'=>false,'tag'=>'li','style'=>'display:none;'));
											echo $this->Paginator->last('<i class="icon-double-angle-right"></i>', array('escape'=>false,'tag' => 'li','title'=>'Last'), array('escape'=>false,'tag'=>'li','title'=>'Last'));
											echo $this->Html->image('loding.gif', array('id'=>'loading','style'=>'display:none;float: right;margin-right: -18px;padding-top: 4px;'));
										?>
	                                 </ul>
	                            </div>
	                     </div>
                    
                </div>
	</div>
 </div>	
</div><!-- /.page-content -->


<script type="text/javascript">
$.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, "Please enter only Alphabets"); 
 $.validator.addMethod('correncycode', function(value) {            
               var cc =  /^[A-Z]+$/ 
                return value.match(cc);
            }, 'Currency code should be in capital letters ');
  $(document).ready(function(){
	  $("#addnewcurrency12").validate({
		 rules: {           
			"data[CpnCurrency][code]": {
				required : true,
				correncycode: true
			},			
			"data[CpnCurrency][name]":{
				required : true,
				lettersonly : true
			}
		 },
		 messages:{			 
			 "data[CpnCurrency][code]":{
				required: "Please enter the Currency Code"
		 	 },
			 "data[CpnCurrency][name]":{
				required: "Please enter the Currency Name"		 	 }
		 }
	});	
  });
  $(document).ready(function(){
  	$( ".addnew" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
  });
</script>
<script type="text/javascript">
    $(document).ready(function(){ 
    	//Select all for checkbox for table
			$('table th input:checkbox').on('click' , function(){
				var that = this;
				$(this).closest('table').find('tr > td:first-child input:checkbox')
				.each(function(){
					this.checked = that.checked;
					$(this).closest('tr').toggleClass('selected');
				});					
			});
    	if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	}    	
	    var flag=0;
	    var count=0;
	 	$('th .ace').change(function(){
	 		if(count!=0)
	 		   count=0;
	 		if(flag==0){
	 		    $('.magin-delete-all .deleteicon').fadeIn('slow');
	 		    flag=1;
	 		}
	 		else{
	 			 $('.magin-delete-all .deleteicon').fadeOut('slow');
	 			 flag=0;
	 		}
	 	});
	 	$('td .ace').change(function(){
	 		
	 		if(flag==0){
	 		          var x=$(this).prop("checked");
			 		  if(x==true){	
			 		 	
			 		  	count+=1;
			 		  }
			 		  else{	 		  	
			 		  	count-=1;
			 		  }
	 		  
			 		  if(count>0 )
			 		    $('.magin-delete-all .deleteicon').fadeIn('slow');
			 		  else if(count<=0&&flag==0){ 	 		  	
			 			 $('.magin-delete-all .deleteicon').fadeOut('slow');	 			
			 		  }
	 		 }
	 	});	 		
	 	});
</script>
<!--/** for responsive **/-->
<script type="text/javascript">
$(document).ready(function(){
var flag=0;
var count=0;
$('.row.header-small-view .ace').change(function(){
	if(count!=0)
	   count=0;
	if(flag==0){
	    $('.magin-delete-all .deleteicon').fadeIn('slow');
	    flag=1;
	}
	else{
		 $('.magin-delete-all .deleteicon').fadeOut('slow');
		 flag=0;
	}
});
$('.contentrow.row .ace').change(function(){
	if(flag==0){
	  var x=$(this).prop("checked");
	  if(x==true){		 		
	  	count+=1;
	  }
	  else{	 		  	
	  	count-=1;
	  }
	  if(count>0 )
	    $('.magin-delete-all .deleteicon').fadeIn('slow');
	  else if(count<=0&&flag==0){ 	 		  	
		 $('.magin-delete-all .deleteicon').fadeOut('slow');	 			
	  }
	 
	 }
 });
 });
         
 $(document).ready(function(){
 	
    $('.header-small-view input:checkbox').on('click' , function(){
		var that = this;
		$(this).parents('.row').siblings('.row').find('input:checkbox')
		.each(function(){
			this.checked = that.checked;
		});
    });
});
</script>			
<?php echo $this->Js->writeBuffer();?>