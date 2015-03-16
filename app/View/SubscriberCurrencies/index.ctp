<?php $counts = $this->Paginator->params();?>
<?php $pages = $this->Paginator->current('SbsSubscriberCpnCurrencyMapping');?>
<?php echo $this->Session->flash();?>

<?php if(!$currencyCodeValue){$currencyCodeValue = "null";}?>
<?php if(!$currencyNameValue){$currencyNameValue = "null";}
$url = array('controller'=>'SubscriberCurrencies','action'=>'index',$filterBy,$currencyNameValue,$currencyCodeValue)
?>
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
		<li class="active">
			<?php echo __('Currency Settings');?>
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600"> <?php echo __('Manage Currency');?></div>
		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-8 no-padding-left no-padding-right width-after-600">
			
			<?php if($permission['_create'] == '1'): ?>
			<?php echo $this->Html->link('<button class="btn btn-sm btn-success pull-right addbutton width-after-400 ">
					<i class="icon-plus"></i>
					Add New Currency
				</button>', array('controller'=>'SubscriberCurrencies','action'=>'add',$pages,$filterBy,$value),array('escape'=>false)); ?>
			<?php endif ; ?>
		</div>
	</div>
	<!-- /.page-header -->
	
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive table-responsivenoscroll">
				<div class="table-header">
					<?php echo __('Currency List');?>
				</div>
				<div class="row margin-twenty-zero filterdivmob">
				<?php echo $this->Form->create('filterCurrency',array('id'=>'filterCurrencyId'));?>                                            	    
                    <div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-4 col-sm-4 col-md-3 col-lg-2 nopadding width-100-480">
                    	<?php if($currencyNameValue && ($currencyNameValue !="null")){
                     		echo $this->Form->input('filterCurrency.currencyName',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'text','placeholder'=>'Enter Currency Name','value'=>$currencyNameValue));
                     	}else{
                     		echo $this->Form->input('filterCurrency.currencyName',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'text','placeholder'=>'Enter Currency Name'));
                     	}?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-4 col-sm-4 col-md-3 col-lg-2 nopadding width-100-480">
                     	<?php
							if($currencyCodeValue &&($currencyCodeValue!="null")){
								echo $this->Form->input('filterCurrency.currencyCode',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'text','placeholder'=>'Enter Currency Code','value'=>$currencyCodeValue));
							}else{
								echo $this->Form->input('filterCurrency.currencyCode',array('label'=>false,'class'=>'form-control','div'=>false,'type'=>'text','placeholder'=>'Enter Currency Code'));
							}
                     	?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero mobile_100">
                     	<?php echo $this->Form->button('Filter',array('type'=>'submit','class'=>'btn btn-sm btn-primary filter-btn form-control mobile_100',array('controller'=>'Currencies','action'=>'index')));?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'SubscriberCurrencies','action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new form-control mobile_100','update'=>'#pageContent'));?>
					</div>
                   <?php echo $this->Form->end();?>
                 </div>
            </div>
         </div>
       </div>
       <div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="">
                  <?php echo $this->Form->create('editCurrency',array('class'=>'custom-form-sl','role'=>'form','id'=>'editCurrency'));?>
				  <?php echo $this->Form->hidden('editCurrency.page',array('value'=>$pages));?>
				  <?php echo $this->Form->hidden('editCurrency.filterBy',array('value'=>$filterBy));?>
				  <?php echo $this->Form->hidden('editCurrency.currencyNameValue',array('value'=>$currencyNameValue));?>
				  <?php echo $this->Form->hidden('editCurrency.currencyCodeValue',array('value'=>$currencyCodeValue));?>
                 <?php if($permission['_delete'] == '1'):?>
                  <div  class="row magin-delete-all">
                 	<span class="deleteicon delete" title="Delete Selected">
                 		<?php echo $this->Js->submit('delete_selected.png', array('div'=>false,'id'=>'click_img','url' => array('controller'=>'SubscriberCurrencies','action' => 'deleteAll'),'type'=>'submit','escape'=>false,'update' => '#pageContent','confirm'=>'Are you sure you want to remove the selected currencies?'));?>
                 	</span>
                  </div> 
                 <?php endif; ?>
               
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table table_">
					<thead>
						<tr>
							<?php if($permission['_delete'] == '1'):?>
							<th class="center"><label>
								<?php echo $this->Form->checkbox('deleteAll.All',array('div'=>false,'label'=>false,'class'=>'ace delete-m-row'));?>
								<span class="lbl"></span> </label></th>
							<?php endif;?>
							<th class="hidden-480"><?php echo $this->Paginator->sort('CpnCurrency.code','Currency Code',array('update'=>'#pageContent','url'=>$url)); ?></th>
							<th ><?php echo $this->Paginator->sort('CpnCurrency.name','Currency Name',array('update'=>'#pageContent','url'=>$url)); ?></th>
							<?php if($permission['_update'] == 1 || $permission['_delete'] == 1):?>
								<th><?php echo __('Actions');?></th>
							<?php endif;?>
						</tr>
					</thead>

					<tbody>
					<?php $slno = null;?>
					<?php foreach ($sbsSubscriberCpnCurrencyMappings as $cpnCurrency): ?>
					
					
						<?php $slno++;?>
						<tr>
							<?php if($permission['_delete'] == '1'):?>
							<td class="center"><label>
								<?php echo $this->Form->checkbox('deleteAll.'.$cpnCurrency['SbsSubscriberCpnCurrencyMapping']['id'],array('div'=>false,'label'=>false,'class'=>'ace delete-m-row'));?>
								<span class="lbl"></span> </label></td>
							<?php endif; ?>
							<td class="hidden-480"><span class="on-load"><?php echo h($cpnCurrency['CpnCurrency']['code']); ?></span>
							</td>
							<td ><span class="on-load"><?php echo h($cpnCurrency['CpnCurrency']['name']); ?>&nbsp;</span>
							</td>
							<?php /*if($permission['_update'] == 1 || $permission['_delete'] == 1):*/?>
							<td>
								<div class="visible-md visible-lg visible-sm visible-xs btn-group">
									
									
									<?php if($permission['_delete'] == 1):?>
										<?php /*echo $this->Form->postLink('<button class="btn btn-xs btn-danger delete delete-row on-load" title="delete"><i class="icon-trash bigger-120"></i></button>', array('controller'=>'Currencies','action' => 'delete', $cpnCurrency['CpnCurrency']['id']),array('id'=>'#sd'.$cpnCurrency['CpnCurrency']['id'],'escape'=>false),__('Are you sure you want to delete  %s?', $cpnCurrency['CpnCurrency']['name']));*/ ?>
										
										<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>', array('action' => 'delete', $cpnCurrency['SbsSubscriberCpnCurrencyMapping']['id'],$filterBy,$currencyNameValue,$currencyCodeValue,$pages),array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>false),__('Are you sure you want to delete # %s?', $cpnCurrency['CpnCurrency']['name'])); ?>
									<?php endif;?>
								</div>
								
								
							</td>
							<?php/* endif;*/?>
						</tr>	
						
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
		
			 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margin10top paginationText">
                      <div id="sample-table-2_info" class="dataTables_info">
	                     	<?php
								echo $this->Paginator->counter(array(
									'format' => __('showing <span>{:start}</span> to <span>{:end}</span> of {:count}')
								));
							?>
                     	</div>
                      </div>
	                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paginationNumber">
	                           <div class="dataTables_paginate paging_bootstrap">
	                                <ul class="pagination">
	                                	<?php if(!$currencyCodeValue){$currencyCodeValue = "null";}?>
	                                	<?php if(!$currencyNameValue){$currencyNameValue = "null";}?>
	                                	<?php
											$this->Paginator->options(array(
		     									'update' => '#pageContent',
												'evalScripts' => true,
												'url' => array('controller'=>'SubscriberCurrencies','action'=>'index',$filterBy,$currencyNameValue,$currencyCodeValue),
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