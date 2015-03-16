<?php $counts = $this->Paginator->params();?>
<?php $pages = $this->Paginator->current('SbsSubscriberCpnCurrencyMapping');?>
<?php echo $this->Session->flash();?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript" src="">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>

	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link(__('<i class="icon-home home-icon"></i>Home'),array('controller'=>'Users','action'=>'Dashboard'),array('escape'=>false));?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Settings'),array('controller'=>'SubscriptionPlans','action'=>'index'));?>
		</li>
		<li class="active">
			<?php echo __('Currency Settings');?>
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1> <?php echo __('Manage Currency');?> </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<button class="btn btn-sm btn-success pull-right addbutton">
					<i class="icon-plus"></i>
					Add New Currency
				</button>', array('controller'=>'SubscriberCurrencies','action'=>'add',$pages,$filterBy,$value),array('escape'=>false)); ?>
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
				<?php echo $this->Form->create('filterCurrency',array('id'=>'filterCurrencyId'));?>                                            	    
                    <div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-sm-5 nopadding col-lg-2">
                    	<?php echo $this->Form->input('filterCurrency.filterBy',array('label'=>false,'class'=>'form-control selectpicker','div'=>false,'options'=>array(''=>'Filter By','name'=>'Currency Name','code'=>'Currency Code')));?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-lg-2 col-sm-5 nopadding">
                     	<?php echo $this->Form->input('filterCurrency.value',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'text','placeholder'=>'Enter Value'));?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero clearlefttrespon">
                     	<?php echo $this->Form->button('Filter',array('type'=>'submit','class'=>'btn btn-sm btn-primary filter-btn form-control',array('controller'=>'Currencies','action'=>'index')));?>
                     </div>
                   <?php echo $this->Form->end();?>
                 </div>
                  <div  class="row magin-delete-all hidden-480">
                 <span class="deleteicon delete" title="Delete All"><i class="icon-trash bigger-120" style="color:#B74635;"></i></span>
                </div> 
                
               
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table table_">
					<thead>
						<tr>
							<th class="center"><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label></th>
							<th class="hidden-480"><?php echo $this->Paginator->sort('CpnCurrency.code','Currency Code',array('update'=>'#pageContent','data'=>array('filterBy'=>$filterBy,'value'=>$value))); ?></th>
							<th ><?php echo $this->Paginator->sort('CpnCurrency.name','Currency Name',array('update'=>'#pageContent','data'=>array('filterBy'=>$filterBy,'value'=>$value))); ?></th>
							<?php /*if($permission['_update'] == 1 || $permission['_delete'] == 1):*/?>
								<th><?php echo __('Actions');?></th>
							<?php /*endif;*/?>
						</tr>
					</thead>

					<tbody>
					<?php $slno = null;?>
					<?php foreach ($sbsSubscriberCpnCurrencyMappings as $cpnCurrency): ?>
					
					<?php echo $this->Form->create('editCurrency',array('class'=>'custom-form-sl','role'=>'form','id'=>'editCurrency'));?>
					<?php echo $this->Form->hidden('editCurrency.page',array('value'=>$pages));?>
					<?php echo $this->Form->hidden('editCurrency.filterBy',array('value'=>$filterBy));?>
					<?php echo $this->Form->hidden('editCurrency.filterValue',array('value'=>$value));?>
						<?php $slno++;?>
						<tr>
							<td class="center"><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label></td>
							<td class="hidden-480"><span class="on-load"><?php echo h($cpnCurrency['CpnCurrency']['code']); ?></span>
							</td>
							<td ><span class="on-load"><?php echo h($cpnCurrency['CpnCurrency']['name']); ?>&nbsp;</span>
							</td>
							<?php /*if($permission['_update'] == 1 || $permission['_delete'] == 1):*/?>
							<td>
								<div class="visible-md visible-lg visible-sm visible-xs btn-group">
									
									
									<?php /*if($permission['_delete'] == 1):*/?>
										<?php /*echo $this->Form->postLink('<button class="btn btn-xs btn-danger delete delete-row on-load" title="delete"><i class="icon-trash bigger-120"></i></button>', array('controller'=>'Currencies','action' => 'delete', $cpnCurrency['CpnCurrency']['id']),array('id'=>'#sd'.$cpnCurrency['CpnCurrency']['id'],'escape'=>false),__('Are you sure you want to delete  %s?', $cpnCurrency['CpnCurrency']['name']));*/ ?>
										
										<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>', array('action' => 'delete', $cpnCurrency['SbsSubscriberCpnCurrencyMapping']['id'],$pages,$filterBy,$value),array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>false),__('Are you sure you want to delete # %s?', $cpnCurrency['CpnCurrency']['name'])); ?>
									<?php/* endif;*/?>
								</div>
								
								
							</td>
							<?php /*endif;*/?>
						</tr>	
						<?php echo $this->Form->end();?>
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
												'url' => array('controller'=>'SubscriberCurrencies','action'=>'index',$filterBy,$value),
												'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false))
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
$(document).ready(function(){
	$.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, "Please enter only Alphabets"); 
 $.validator.addMethod('correncycode', function(value) {            
               var cc =  /^[A-Z]+$/ 
                return value.match(cc);
            }, 'Currency code should be in capital letters ');
  
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
	$("#filterCurrencyId").validate({
		 rules: {           
			"data[filterCurrency][filterBy]": {
				required : true
			},			
			"data[filterCurrency][value]":{
				required : true
			}
		 },
		 messages:{			 
			 "data[filterCurrency][filterBy]":{
				required: "Please select filter option"
		 	 },
			 "data[filterCurrency][value]":{
				required: "Please enter the value"		 	 }
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