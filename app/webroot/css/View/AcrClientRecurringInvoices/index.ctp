<?php $counts = $this->Paginator->params();?>
<?php $pages = $this->Paginator->current('AcrClientRecurringInvoice');?>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
?>

<?php 
	if(!$filterAction){$filterAction = 0;}
	if(!$filterValue){$filterValue = 0;}
	if(!$filterValue1){$filterValue1 = 0;}
	if(!$filterValue2){$filterValue2 = 0;}
	if(!$isRecurring){$isRecurring = 1;}
	if(!$status){$status = 0;}
	if(!$fromDate){$fromDate = 0;}
	if(!$toDate){$toDate = 0;}
?>
<div id = "flashMessage">
<?php echo $this->Session->flash();?>
</div>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
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
			<?php echo __('Recurring Invoices');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 class="widthauto col-xs-12"><?php echo __('Recurring Invoices');?></h1>
		<div class="col-lg-8 col-md-12 col-xs-12 paddingleftrightzero pull-right">
			<?php echo $this->Html->link('<i class="icon-plus"></i>Add New Recurring Invoice',array('action'=>'add'),array('class'=>'btn btn-sm btn-success pull-right addbutton marginleft1','escape'=>FALSE));?>
		
		
			<!--div class="btn btn-sm btn-success pull-right manageinventoryexport marginleft1">
				Export Invoices <i class="icon-caret-down icon-on-right"></i>
			</div-->
		
			<!--a class="btn btn-sm btn-success pull-right importbutton marginleft1" href="#"> Import Invoices <i class="icon-caret-down icon-on-right"></i> </a-->
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<div class="table-header">
					<?php echo __('Recurring Invoice List');?>
				</div>
				<?php echo $this->Form->create('InvoiceFilter',array('id'=>'InvoiceFilter','url'=>array('controller'=>'AcrClientRecurringInvoices','action'=>'index')));?>
				<div class="row margin-twenty-zero">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field">						
						<?php echo $this->Form->input('filterAction',array('label'=>false,'class'=>'form-control selectpicker selectitem','data-placeholder'=>'Status','options'=>array(''=>'Filter By','invoice_number'=>'Invoice Number','amount'=>'Amount')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero widthinput150 dispalycommon">	
						<?php if($filterValue){
							echo $this->Form->input('filterValue',array('label'=>false, 'placeholder'=>'Enter', 'id'=>"", 'class'=>"form-control", 'value'=>$filterValue));
						}else{
							echo $this->Form->input('filterValue',array('label'=>false, 'placeholder'=>'Enter', 'id'=>"", 'class'=>"form-control"));
						}?>					
					</div>
					<div class="form-group filed-left margin-bottom-zero widthinput150 displayifnumber">
						<div class="form-group margin-bottom-zero inpuwidth70 left marginright10">	
							<?php if($filterValue1){
								echo $this->Form->input('filterValue1',array('label'=>false, 'placeholder'=>'Min', 'id'=>"", 'class'=>"form-control", 'value'=>$filterValue1));
							}else{
								echo $this->Form->input('filterValue1',array('label'=>false, 'placeholder'=>'Min', 'id'=>"", 'class'=>"form-control"));
							}?>					     
						</div>
						<div class="form-group margin-bottom-zero inpuwidth70 left">		
							<?php if($filterValue2){
								echo $this->Form->input('filterValue2',array('label'=>false, 'placeholder'=>'Max', 'id'=>"", 'class'=>"form-control", 'value'=>$filterValue2));
							}else{
								echo $this->Form->input('filterValue2',array('label'=>false, 'placeholder'=>'Max', 'id'=>"", 'class'=>"form-control"));
							}?>				    
						</div>     
					</div>
					<!--div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field">						
						<?php /*echo $this->Form->input('isRecurring',array('label'=>false, 'class'=>'form-control selectpicker','data-placeholder'=>'Status','options'=>array('N'=>'All Invoices','Y'=>'Recurring Invoices')));*/?>
					</div-->
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field">												
						<?php echo $this->Form->input('status',array('label'=>false, 'class'=>'form-control selectpicker','data-placeholder'=>'Status','options'=>array(''=>'Status','Active'=>'Active','Inactive'=>'Inactive')));?>
					</div>
					<div class="input-group custom-datepicker invoicedate">
						<?php if($fromDate){
							echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default', 'value'=>$fromDate));
						}else{
							echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default'));
						}?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="input-group custom-datepicker invoicedate">
						<?php if($toDate){
							echo $this->Form->input('toDate',array('label'=>false, 'placeholder'=>'To', 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default', 'value'=>$toDate));
						}else{
							echo $this->Form->input('toDate',array('label'=>false, 'placeholder'=>'To', 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default'));
						}?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero">						
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn filter_btn_new','url' => array('controller'=>'AcrClientRecurringInvoices','action' => 'index'),'escape'=>false,'update' => '#pageContent'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php /*echo $this->Form->reset('Reset',array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new'));*/?>
						<?php echo $this->Js->link('Reset',array('controller'=>'AcrClientRecurringInvoices','action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new','update'=>'#pageContent'));?>
					</div>
				</div>
				<?php echo $this->Form->end();?>
				<?php echo $this->Form->create('AcrClientRecuringInvoice');?>
				
				<div  class="row magin-delete-all">
					<span class="deleteicon delete" title="Delete All"> 
						<?php 
							echo $this->Form->hidden('filterAction',array('value'=>$filterAction));
							echo $this->Form->hidden('filterValue',array('value'=>$filterValue));
							echo $this->Form->hidden('filterValue1',array('value'=>$filterValue1));
							echo $this->Form->hidden('filterValue2',array('value'=>$filterValue2));
							echo $this->Form->hidden('isRecurring',array('value'=>$isRecurring));
							echo $this->Form->hidden('status',array('value'=>$status));
							echo $this->Form->hidden('fromDate',array('value'=>$fromDate));
							echo $this->Form->hidden('toDate',array('value'=>$toDate));
							echo $this->Form->hidden('page',array('value'=>$pages));
						?>
						<?php echo $this->Js->submit('Delete', array('div'=>false,'url' => array('controller'=>'AcrClientRecurringInvoices','action' => 'deleteAll'),'type'=>'submit','escape'=>false,'update' => '#pageContent','confirm'=>'Are you sure you want to remove the selected recurrence'));?>
					</span>
				</div>
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<th class="width10"><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label></th>
							<th class="width200"><?php echo __('Invoice No.');?></th>
							<th class="width200"><?php echo __('Start Date');?></th>
							<th class="width200"><?php echo __('End Date');?></th>
							<th class="width200"><?php echo __('Amount');?></th>
							<th class="width200"><?php echo __('Status');?></th>
							<th class="width180 paddingleft25"><?php echo __('Action');?></th>
						</tr>
					</thead>
					<tbody>
					
					<?php foreach($acrClientInvoices as $acrClientInvoice):?>
						<tr id = "tr-<?php echo $acrClientInvoice['AcrClientRecurringInvoice']['id']?>">
							<td><span class=""> <label>
									<?php echo $this->Form->checkbox('deleteAll.'.$acrClientInvoice['AcrClientRecurringInvoice']['id'],array('div'=>false,'label'=>false,'class'=>'ace delete-m-row'));?>
									<span class="lbl"></span> </label> </span></td>
							<td><span class="on-load statusopn"><?php echo $acrClientInvoice['AcrClientInvoice']['invoice_number'];?></span>
							</td>
							<td><span class="on-load"><?php echo date("$dateFormat",strtotime($acrClientInvoice['AcrClientRecurringInvoice']['invoice_start_date']));?></span>
							</td>
							<td><span class="on-load"><?php echo date("$dateFormat",strtotime($acrClientInvoice['AcrClientRecurringInvoice']['invoice_end_date']));?></span>
							</td>
							<td><span class="on-load"><?php $options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
									<?php echo $this->Number->currency($acrClientInvoice['AcrClientInvoice']['invoice_total'],$acrClientInvoice['AcrClientInvoice']['invoice_currency_code'],$options);?></span>
							</td>
							<td id = "td-<?php echo $acrClientInvoice['AcrClientRecurringInvoice']['id']?>"><span class="on-load "><?php echo $acrClientInvoice['AcrClientRecurringInvoice']['status'];?></span>
							</td>
							<td style = "padding-right: 4%;">
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<div class="pull-right">
									<div class="inline position-relative">
										<button class="btn btn-minier btn-warning dropdown-toggle" data-toggle="dropdown">
											<i class="icon-caret-down bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
											<li>
												<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'view',$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-success view on-load pull-right','escape'=>FALSE,'title'=>'View'));?>
											</li>
											<li>
												<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'delete',$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-danger delete pull-right','escape'=>FALSE,'title'=>'Delete','confirm'=>'Are you sure you want to remove the recurrence for Invoice# '.$acrClientInvoice['AcrClientInvoice']['invoice_number'].'?'));?>
											</li>
										</ul>
									</div>
								</div>
								<?php if($acrClientInvoice['AcrClientRecurringInvoice']['status']=='Active'){?>
								<?php echo $this -> Js -> link('<i class=" icon-circle  bigger-120"></i>', 
													array('controller' => 'acr_client_recurring_invoices', 'action' => 'stopRecurrence',$acrClientInvoice['AcrClientRecurringInvoice']['id']),
												    array('class'=>'btn btn-xs btn-danger edit edit-row on-load pull-right','escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientRecurringInvoice']['id'],'title'=>'Stop Recurrence','confirm'=>'Do you want to stop recurrence for Invoice# '. $acrClientInvoice['AcrClientInvoice']['invoice_number']. '?'));?>
								<?php } ?>
								<?php echo $this -> Js -> link('<i class="icon-save bigger-120"></i>', 
													array('controller' => 'acr_client_recurring_invoices', 'action' => 'generateInvoice',$acrClientInvoice['AcrClientRecurringInvoice']['id']),
												    array('class'=>'btn btn-xs btn-pink edit edit-row on-load pull-right','escape' => FALSE, 'update' => '#flashMessage','title'=>'Generate Invoice','confirm'=>'Do you want to generate invoice for this recurrence?'));?>
								<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'edit',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-info edit on-load pull-right','escape'=>FALSE,'title'=>'Edit'));?>
								
							</div>
							
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>
									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
										<li>
											<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'edit',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-info edit on-load pull-right','escape'=>FALSE,'title'=>'Edit'));?>
										</li>
										<li>
											<?php echo $this -> Js -> link('<i class="icon-save bigger-120"></i>', 
													array('controller' => 'acr_client_recurring_invoices', 'action' => 'generateInvoice',$acrClientInvoice['AcrClientRecurringInvoice']['id']),
												    array('class'=>'btn btn-xs btn-pink edit edit-row on-load pull-right','escape' => FALSE, 'update' => '#flashMessage','title'=>'Generate Invoice','confirm'=>'Do you want to generate invoice for this recurrence?'));?>
										</li>
										<li>
											<?php if($acrClientInvoice['AcrClientRecurringInvoice']['status']=='Active'){?>
											<?php echo $this -> Js -> link('<i class=" icon-circle  bigger-120"></i>', 
													array('controller' => 'acr_client_recurring_invoices', 'action' => 'stopRecurrence',$acrClientInvoice['AcrClientRecurringInvoice']['id']),
												    array('class'=>'btn btn-xs btn-danger edit edit-row on-load pull-right','escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientRecurringInvoice']['id'],'title'=>'Stop Recurrence','confirm'=>'Do you want to stop recurrence for Invoice# '. $acrClientInvoice['AcrClientInvoice']['invoice_number']. '?'));?>
											<?php } ?>
										</li>
										<li>
											<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'view',$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-success view on-load pull-right','escape'=>FALSE,'title'=>'View'));?>
										</li>
										<li>
											<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'delete',$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-danger delete pull-right','escape'=>FALSE,'title'=>'Delete','confirm'=>'Are you sure you want to remove the recurrence for Invoice# '.$acrClientInvoice['AcrClientInvoice']['invoice_number'].'?'));?>
										</li>
									</ul>
								</div>
							</div>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<?php echo $this->Form->end();?>
				<div class="row">
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
												'url' => array('controller'=>'acr_client_recurring_invoices','action'=>'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate),
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
	</div>
</div>
<!-- inline scripts related to this page -->

<script type="text/javascript">
	jQuery(function($) {
		$(".chosen-select").chosen();
	});
	$(document).ready(function() {
		$('.date-picker').datepicker({
			autoclose : true
		}).next().on(ace.click_event, function() {
			$(this).prev().focus();
		});
	});

	$(document).ready(function() {
		var flag = 0;
		var count = 0;
		$('th .ace').change(function() {
			if (count != 0)
				count = 0;
			if (flag == 0) {
				$('.magin-delete-all .deleteicon').fadeIn('slow');
				flag = 1;
			} else {
				$('.magin-delete-all .deleteicon').fadeOut('slow');
				flag = 0;
			}
		});
		$('td .ace').change(function() {
			if (flag == 0) {
				var x = $(this).prop("checked");
				if (x == true) {
					count += 1;
				} else {
					count -= 1;
				}

				if (count > 0)
					$('.magin-delete-all .deleteicon').fadeIn('slow');
				else if (count <= 0 && flag == 0) {
					$('.magin-delete-all .deleteicon').fadeOut('slow');
				}
			}
		});
	});

</script>
<script type="text/javascript">
			
			$(document).ready(function(){
				check();				
				$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				if($('.selectpicker').length){
	   		      $('.selectpicker').selectpicker({
			       });
    	         }
    	         $('.popup-cancel').click(function(){
    	         	$('.close').trigger('click');
    	         });				
			});
				
				
	$(document).ready(function(){
		// Tooltip for action button	
   $( ".edit" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	$( ".delete" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	$( ".view" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
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
$('body').on('change','.selectitem',function(){
	var thisvalue = $('.selectitem option:selected').text();
	$('.dispalycommon').find('.input .form-control').val('');
	$('.displayifnumber').find('.input .form-control').val('');
	if (thisvalue=="Amount")
	   {
	   	 $('.dispalycommon').hide();
	   	 $('.displayifnumber').show();
	   }
	   else{
	   	   $('.dispalycommon').show();
	   	   $('.displayifnumber').hide();
	   }
});

});


function check(){
	var thisvalue = $('.selectitem option:selected').text();
	if (thisvalue=="Amount")
	   {  
	   	 $('.dispalycommon').hide();	
	   	 $('.displayifnumber').show();
	   }
	   
}	

</script>
<?php echo $this->Js->writeBuffer();?>