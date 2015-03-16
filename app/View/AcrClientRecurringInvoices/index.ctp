<?php $counts = $this->Paginator->params();?>
<?php $pages = $this->Paginator->current('AcrClientRecurringInvoice');?>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
?>
<?php 
	$dbFormat = array("d", "M", "Y");
	$scriptFormat   = array("dd", "mm", "yyyy");
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
			<?php echo $this->Html->link('Invoices',array('action'=>'index'),array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo __('Recurring Invoices');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 class="widthauto col-xs-12 managecustomer"><?php echo __('Recurring Invoices');?></h1>
		<div class="col-lg-8 col-md-12 col-xs-12 paddingleftrightzero pull-right">
			<?php if($permission['_create'] == '1'){?>
				<?php echo $this->Html->link('<i class="icon-plus"></i>Add New Recurring Invoice',array('action'=>'add'),array('class'=>'col-lg-4 col-xs-12 col-sm-4 col-md-4 btn btn-sm btn-success pull-right addbutton mobile_100','escape'=>FALSE));?>
			<?php } ?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<div class="table-header">
					<?php echo __('Recurring Invoice List');?>
				</div>
				<?php echo $this->Form->create('InvoiceFilter',array('id'=>'InvoiceFilter','url'=>array('controller'=>'AcrClientRecurringInvoices','action'=>'index')));?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100 choosen_width">						
						<?php echo $this->Form->input('filterAction',array('label'=>false,'class'=>'form-control invdrop selectitem','data-placeholder'=>'Filter By','options'=>array(''=>'Filter By','invoice_number'=>'Invoice Number','amount'=>'Amount')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero widthinput150 dispalycommon width-full-480 mobile_100">	
						<?php if($filterValue && ($filterValue != "null")){
							echo $this->Form->input('filterValue',array('label'=>false, 'placeholder'=>'Enter', 'id'=>"", 'class'=>"form-control", 'value'=>$filterValue));
						}else{
							echo $this->Form->input('filterValue',array('label'=>false, 'placeholder'=>'Enter', 'id'=>"", 'class'=>"form-control"));
						}?>					
					</div>
					<div class="form-group filed-left margin-bottom-zero widthinput150 displayifnumber width-full-480 mobile_100">
						<div class="form-group margin-bottom-zero inpuwidth70 left marginright10">	
							<?php if($filterValue1 && ($filterValue1 !=0)){
								echo $this->Form->input('filterValue1',array('label'=>false, 'placeholder'=>'Min', 'id'=>"", 'class'=>"form-control", 'value'=>$filterValue1));
							}else{
								echo $this->Form->input('filterValue1',array('label'=>false, 'placeholder'=>'Min', 'id'=>"", 'class'=>"form-control"));
							}?>					     
						</div>
						<div class="form-group margin-bottom-zero inpuwidth70 left">		
							<?php if($filterValue2 && ($filterValue2 != 0)){
								echo $this->Form->input('filterValue2',array('label'=>false, 'placeholder'=>'Max', 'id'=>"", 'class'=>"form-control", 'value'=>$filterValue2));
							}else{
								echo $this->Form->input('filterValue2',array('label'=>false, 'placeholder'=>'Max', 'id'=>"", 'class'=>"form-control"));
							}?>				    
						</div>     
					</div>
					<!--div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field">						
						<?php /*echo $this->Form->input('isRecurring',array('label'=>false, 'class'=>'form-control selectpicker','data-placeholder'=>'Status','options'=>array('N'=>'All Invoices','Y'=>'Recurring Invoices')));*/?>
					</div-->
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100 choosen_width">												
						<?php echo $this->Form->input('status',array('label'=>false, 'class'=>'form-control invdrop','data-placeholder'=>'Status','options'=>array(''=>'Status','Active'=>'Active','Inactive'=>'Inactive')));?>
					</div>
					<div class="input-group custom-datepicker invoicedate width-full-480 datewidth">
						<?php if($fromDate){
							echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$dateFormat),'readonly'=>'readonly','style'=>'cursor:default', 'value'=>date($dbFormat,strtotime($fromDate))));
						}else{
							echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$dateFormat),'readonly'=>'readonly','style'=>'cursor:default'));
						}?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="input-group custom-datepicker invoicedate width-full-480 datewidth">
						<?php if($toDate){
							echo $this->Form->input('toDate',array('label'=>false, 'placeholder'=>'To', 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$dateFormat),'readonly'=>'readonly','style'=>'cursor:default', 'value'=>date($dbFormat,strtotime($toDate))));
						}else{
							echo $this->Form->input('toDate',array('label'=>false, 'placeholder'=>'To', 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$dateFormat),'readonly'=>'readonly','style'=>'cursor:default'));
						}?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">						
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','url' => array('controller'=>'AcrClientRecurringInvoices','action' => 'index'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading1')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading1')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'AcrClientRecurringInvoices','action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','update'=>'#pageContent'));?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading1','style'=>'display:none;float: right;margin-right: 10%'));?>
				</div>
				
				
				<?php echo $this->Form->end();?>
				<?php echo $this->Form->create('AcrClientRecuringInvoice');?>
			
			</div>
		</div>
	</div>			
	<div class="row">	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">			
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom5">
					<div class="select-all-mobile select-all">
						<div>
							<input class="ace" type="checkbox"/>
							<span class="lbl">&nbsp; Select All</span> 
						</div>
					</div>
					<div  class="delete-all-trash">
						<span class="deleteicon delete" title="Delete Selected"> 
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
								$url = array('action'=>'index',$filterAction, $filterValue, $filterValue1, $filterValue2, $isRecurring, $status, $fromDate, $toDate, $page);
							?>
							<?php echo $this->Js->submit('delete_selected.png', array('div'=>false,'url' => array('controller'=>'AcrClientRecurringInvoices','action' => 'deleteAll'),'type'=>'submit','escape'=>false,'update' => '#pageContent','confirm'=>'Are you sure you want to remove the selected recurrence'));?>
						</span>
					</div>
				</div>
				<?php foreach($acrClientInvoices as $acrClientInvoice):?>
				<table id="sample-table-1" class="table table-striped roles-table">
										
					<tr>
							<td class="select-all width-30-new">
								<label>
									<input class="ace" type="checkbox"/>
									<span class="lbl"></span> 
								</label>
							</td>
							<td class="title_role bold width-120-new">
								<?php echo $this->Paginator->sort('AcrClientInvoice.invoice_number','Invoice No',array('update'=>'#pageContent','url'=>$url));?>
							</td>
							<td class="title bold width-120-new">
								<?php echo $this->Paginator->sort('AcrClientRecurringInvoice.invoice_start_date','Start Date',array('update'=>'#pageContent','url'=>$url));?>
							</td>
							
							<td class="title bold width-80-new">
								<?php echo $this->Paginator->sort('AcrClientRecurringInvoice.invoice_end_date','End Date',array('update'=>'#pageContent','url'=>$url));?>
							</td>
							
							<td class="title bold width-100-new textright">
								<?php echo $this->Paginator->sort('AcrClientInvoice.invoice_total','Amount',array('update'=>'#pageContent','url'=>$url));?>
							</td>
							<td class="title bold width-80-new">
								<?php echo __('Status');?>
							</td>
							
							<td class="title bold action width-120-new">Action</td>
							<td class="title select-each-mobile bold">Select</td>
						</tr>
						
					
					
					
					
						<tr id = "tr-<?php echo $acrClientInvoice['AcrClientRecurringInvoice']['id']?>" class="even-strip">
							<td class="select-each width-30-new">
								
									<label>
										<?php echo $this->Form->checkbox('deleteAll.'.$acrClientInvoice['AcrClientRecurringInvoice']['id'],array('div'=>false,'label'=>false,'class'=>'ace delete-m-row'));?>
									<span class="lbl"></span> 
									</label> 
								
							</td>
							<td class="title_role ewidth120 width-120-new expenseNO">
								<span class="on-load statusopn">
									<?php echo $acrClientInvoice['AcrClientInvoice']['invoice_number'];?>
								</span>
							</td>
							<td class="title width-120-new">
								<span class="on-load">
									<?php echo date("$dateFormat",strtotime($acrClientInvoice['AcrClientRecurringInvoice']['invoice_start_date']));?>
								</span>
							</td>
							<td class="title width-80-new">
								<span class="on-load">
									<?php echo date("$dateFormat",strtotime($acrClientInvoice['AcrClientRecurringInvoice']['invoice_end_date']));?>
								</span>
							</td>
							<td class="title width-100-new textright">
								<span class="on-load">
									<?php echo $this->Number->currency($acrClientInvoice['AcrClientInvoice']['invoice_total'],$acrClientInvoice['AcrClientInvoice']['invoice_currency_code']);?>
								</span>
							</td>
							<td id = "td-<?php echo $acrClientInvoice['AcrClientRecurringInvoice']['id']?>" class="title width-80-new">
								<span class="on-load ">
									<?php echo $acrClientInvoice['AcrClientRecurringInvoice']['status'];?>
								</span>
							</td>
							<td class="title width-120-new desktopadding7cent">
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<div class="pull-right">
									<div class="inline position-relative">
										<button class="btn btn-minier btn-warning dropdown-toggle" data-toggle="dropdown">
											<i class="icon-caret-down bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
											<?php if($permission['_read'] == '1'):?>
											<li>
												<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'view',$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-success view on-load pull-right','escape'=>FALSE,'title'=>'View'));?>
											</li>
											<?php endif; ?>
											<?php if($permission['_delete'] =='1'):?>
											<li>
												<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'delete',$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-danger delete pull-right','escape'=>FALSE,'title'=>'Delete','confirm'=>'Are you sure you want to remove the recurrence for Invoice# '.$acrClientInvoice['AcrClientInvoice']['invoice_number'].'?'));?>
											</li>
											<?php endif; ?>
										</ul>
									</div>
								</div>
								<?php if($permission['_update'] == '1'): ?>
								<?php if($acrClientInvoice['AcrClientRecurringInvoice']['status']=='Active'){?>
								<?php echo $this -> Js -> link('<i class=" icon-stop  bigger-120"></i>', 
													array('controller' => 'acr_client_recurring_invoices', 'action' => 'stopRecurrence',$acrClientInvoice['AcrClientRecurringInvoice']['id']),
												    array('class'=>'btn btn-xs btn-danger edit edit-row on-load pull-right','escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientRecurringInvoice']['id'],'title'=>'Stop Recurrence','confirm'=>'Do you want to stop recurrence for Invoice# '. $acrClientInvoice['AcrClientInvoice']['invoice_number']. '?'));?>
								<?php }else{
												echo $this -> Js -> link('<i class="icon-play bigger-120"></i>', 
													array('controller' => 'acr_client_recurring_invoices', 'action' => 'startRecurrence',$acrClientInvoice['AcrClientRecurringInvoice']['id']),
												    array('class'=>'btn btn-xs btn-danger edit edit-row on-load pull-right','escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientRecurringInvoice']['id'],'title'=>'Start Recurrence','confirm'=>'Do you want to start recurrence for Invoice# '. $acrClientInvoice['AcrClientInvoice']['invoice_number']. '?'));
								} ?>
								<?php endif; ?>
								<?php if($permission['_create'] == '1'):?>
								<?php echo $this -> Js -> link('<i class="icon-save bigger-120"></i>', 
													array('controller' => 'acr_client_recurring_invoices', 'action' => 'generateInvoice',$acrClientInvoice['AcrClientRecurringInvoice']['id']),
												    array('class'=>'btn btn-xs btn-pink edit edit-row on-load pull-right','escape' => FALSE, 'update' => '#flashMessage','title'=>'Generate Invoice','confirm'=>'Do you want to generate invoice for this recurrence?'));?>
								<?php endif;?>
								<?php if($permission['_update'] == '1'):?>
								<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'edit',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-info edit on-load pull-right','escape'=>FALSE,'title'=>'Edit'));?>
								<?php endif;?>
							</div>
							
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>
									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
										<?php if($permission['_update'] == '1'):?>
										<li>
											<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'edit',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-info edit on-load pull-right','escape'=>FALSE,'title'=>'Edit'));?>
										</li>
										<?php endif;?>
										<?php if($permission['_create'] == '1'):?>
										<li>
											<?php echo $this -> Js -> link('<i class="icon-save bigger-120"></i>', 
													array('controller' => 'acr_client_recurring_invoices', 'action' => 'generateInvoice',$acrClientInvoice['AcrClientRecurringInvoice']['id']),
												    array('class'=>'btn btn-xs btn-pink edit edit-row on-load pull-right','escape' => FALSE, 'update' => '#flashMessage','title'=>'Generate Invoice','confirm'=>'Do you want to generate invoice for this recurrence?'));?>
										</li>
										<?php endif;?>
										<?php if($permission['_update'] == '1'): ?>
										<li>
											<?php if($acrClientInvoice['AcrClientRecurringInvoice']['status']=='Active'){?>
											<?php echo $this -> Js -> link('<i class=" icon-stop  bigger-120"></i>', 
													array('controller' => 'acr_client_recurring_invoices', 'action' => 'stopRecurrence',$acrClientInvoice['AcrClientRecurringInvoice']['id']),
												    array('class'=>'btn btn-xs btn-danger edit edit-row on-load pull-right','escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientRecurringInvoice']['id'],'title'=>'Stop Recurrence','confirm'=>'Do you want to stop recurrence for Invoice# '. $acrClientInvoice['AcrClientInvoice']['invoice_number']. '?'));?>
											<?php }else{
												echo $this -> Js -> link('<i class=" icon-stop  bigger-120"></i>', 
													array('controller' => 'acr_client_recurring_invoices', 'action' => 'startRecurrence',$acrClientInvoice['AcrClientRecurringInvoice']['id']),
												    array('class'=>'btn btn-xs btn-danger edit edit-row on-load pull-right','escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientRecurringInvoice']['id'],'title'=>'Start Recurrence','confirm'=>'Do you want to start recurrence for Invoice# '. $acrClientInvoice['AcrClientInvoice']['invoice_number']. '?'));
											} ?>
										</li>
										<?php endif;?>
										<?php if($permission['_read'] == '1'): ?>
										<li>
											<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'view',$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-success view on-load pull-right','escape'=>FALSE,'title'=>'View'));?>
										</li>
										<?php endif;?>
										<?php if($permission['_delete'] == '1'): ?>
										<li>
											<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'delete',$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-danger delete pull-right','escape'=>FALSE,'title'=>'Delete','confirm'=>'Are you sure you want to remove the recurrence for Invoice# '.$acrClientInvoice['AcrClientInvoice']['invoice_number'].'?'));?>
										</li>
										<?php endif;?>
									</ul>
								</div>
							</div>
							</td>
							
							<td class="select-each-mobile select-each">
								<label>
									<?php echo $this->Form->checkbox('deleteAll.'.$acrClientInvoice['AcrClientRecurringInvoice']['id'],array('div'=>false,'label'=>false,'class'=>'ace delete-m-row'));?>
									<span class="lbl"></span> 
								</label> 
							</td>
							
						</tr>
						<?php endforeach; ?>
					
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
		
		/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
		
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
<script type="text/javascript">
deleteselected = function() {
		//alert($('.roles-table input[type="checkbox"]:checked').length);
		if ($('.roles-table input[type="checkbox"]:checked').length > 0) {
			$('.delete-all-trash').fadeIn();
		} else {
			$('.delete-all-trash').fadeOut();

		}
	};
	select_each_row_mobile = function(that) {
		if ((that).is(":checked")) {
			$(that).parents('table').find('.select-each input[type="checkbox"]').prop('checked', true);
		} else {
			$(that).parents('table').find('.select-each input[type="checkbox"]').prop('checked', false);
		}
	}
    
$(document).ready(function(){
	//table mobile view script//
		if ($('.roles-table-wrapper-inner').length) {
			var winsize = 1;
			if ($('.roles-table').length) {
				var i = 1;
				$('.roles-table').each(function() {
					$(this).addClass("role-table-" + i);
					i++;
				});
			}
			$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");

			$('#applycredit').on('show.bs.modal', function(e) {
				//$(this).find('tr:first').removeClass("hidden-row");
				$(this).find('table:first').addClass("popuptable");
				$('.popuptable').find('tr:first').removeClass("hidden-row");
			});

			$changeTableView = function() {
				$(".table").each(function() {
					var $this = $(this);
					var newrows = [];
					$this.find("tr").each(function() {
						var i = 0;
						$(this).find("td").each(function() {
							i++;
							if (newrows[i] === undefined) {
								newrows[i] = $("<tr></tr>");
							}
							newrows[i].append($(this));
						});
					});
					$this.find("tr").remove();
					$.each(newrows, function() {
						$this.append(this);
					});
				});

			};

			if ($(window).width() < 992) {
				$changeTableView();
				winsize = 0;
			}

			$(window).on("resize", function() {

				if (Math.floor($(window).width() / 992) != winsize) {
					$changeTableView();
					winsize = Math.floor($(window).width() / 992);
				}
				if ($(window).width() > 992) {
					$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");
					$('.popuptable').find('tr:first').removeClass("hidden-row");
				}
			});
		}
		//table mobile view script//
		
		
		//for alternative row colors
		var i = 0;
		$('.even-strip').each(function() {
			if (i % 2 != 0) {
				$(this).addClass("coloredrow");
			}
			i++;
		});

		//for alternative row colors

		$('.roles-table input[type="checkbox"]').click(function() {
			select_each_row_mobile($(this));
		});
		
		
		//delete all trash fadein and fadeout

		//select all check boxes
		$('.select-all-mobile input[type="checkbox"]').click(function() {
			if ($(this).is(":checked")) {
				$('.roles-table .select-all').find('input[type="checkbox"]').prop('checked', true);
			} else {
				$('.roles-table .select-all').find('input[type="checkbox"]').prop('checked', false);
			}
		});

		$('.select-all input[type="checkbox"]').click(function() {
			if ($(this).is(":checked")) {
				$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
				$('.select-each').find('input[type="checkbox"]').prop('checked', true);
				$('.select-all').find('input[type="checkbox"]').prop('checked', true);
			} else {
				$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', false);
				$('.select-each').find('input[type="checkbox"]').prop('checked', false);
				$('.select-all').find('input[type="checkbox"]').prop('checked', false);
			}
			deleteselected();
		});

		$('.select-each input[type="checkbox"]').click(function() {
			if ($(this).find('input[type="checkbox"]').prop('checked', true)) {
				if ($('.select-all').find('input[type="checkbox"]').prop('checked', true)) {
					$('.select-all').find('input[type="checkbox"]').prop('checked', false);
					$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', false);
				}
			}
			if ($('.select-each input[type="checkbox"]').length == $('.select-each input[type="checkbox"]:checked').length) {
				$('.select-all').find('input[type="checkbox"]').prop('checked', true);
				$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
			}
			deleteselected();
		});

		$('.select-each-mobile input[type="checkbox"]').click(function() {
			if ($('.select-each-mobile input[type="checkbox"]').length == $('.select-each-mobile input[type="checkbox"]:checked').length) {
				$('.select-all').find('input[type="checkbox"]').prop('checked', true);
				$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
			}
			deleteselected();
		});

});	
</script>

<?php echo $this->Js->writeBuffer();?>