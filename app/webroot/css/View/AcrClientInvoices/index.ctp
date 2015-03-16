<?php $counts = $this->Paginator->params();?>
<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php $page = $this->Paginator->current('AcrClientInvoice');?>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
?>
<div id ="session">
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
		<li class="active">
			<?php echo __('Invoices');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 class="managecustomer manageinventory invoice_header"><?php echo __('Manage Invoices');?> </h1>
		<?php if(($showAddButton) && ($permission['_create'] == '1')){?>
			<div class="col-lg-2 paddingleftrightzero managecustomeradd manageitemimport addpayment pull-right invoice_new">
				<?php echo $this->Html->link('<i class="icon-plus"></i> Add New Invoice',array('action'=>'add'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
			</div>
		<?php } ?>
		<div class="col-lg-2 paddingleftrightzero manageitemimport importinvoice pull-right invoice_export">
			<!--div class="btn btn-sm btn-success pull-right manageinventoryexport">
				Export Invoices <i class="icon-caret-down icon-on-right"></i>
			</div-->
			<?php echo $this->Html->link('Export Items <i class="icon-caret-down icon-on-right"></i>',array('controller'=>'AcrClientInvoices','action'=>'exportInvoices'),array('class'=>'btn btn-sm btn-success pull-right manageinventoryexport','escape'=>FALSE));?>		
		</div>
		
		<?php if(($showAddButton) && ($permission['_create'] == '1')){?>
			<div class="col-lg-2 paddingleftrightzero manageitemimport importinvoice pull-right invoice_import">
				<?php echo $this->Html->link('Import Invoices <i class="icon-caret-down icon-on-right"></i>',array('controller'=>'AcrClientInvoices','action'=>'showExcel'),array('class'=>'btn btn-sm btn-success pull-right importbutton','escape'=>FALSE));?>
			</div>
		<?php } ?>

	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<div class="table-header">
					<?php echo __('Invoices List');?>
					
				</div>
				<?php echo $this->Form->create('InvoiceFilter',array('id'=>'InvoiceFilter','url'=>array('controller'=>'AcrClientInvoices','action'=>'index')));?>
				<div class="row margin-twenty-zero">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field">						
						<?php echo $this->Form->input('filterAction',array('label'=>false,'class'=>'form-control selectpicker selectitem','data-placeholder'=>'Status','options'=>array(''=>'Filter By','invoice_number'=>'Invoice Number','customer_name'=>'Customer Name','amount'=>'Amount')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero widthinput150 dispalycommon">						
						<?php echo $this->Form->input('filterValue',array('label'=>false, 'placeholder'=>'Enter', 'id'=>"", 'class'=>"form-control")); ?>
					</div>
					<div class="form-group filed-left margin-bottom-zero widthinput150 displayifnumber">
						<div class="form-group margin-bottom-zero inpuwidth70 left marginright10">						     
						    <?php echo $this->Form->input('filterValue1',array('label'=>false, 'placeholder'=>'Min', 'id'=>"", 'class'=>"form-control")); ?>
						</div>
						<div class="form-group margin-bottom-zero inpuwidth70 left">						    
						     <?php echo $this->Form->input('filterValue2',array('label'=>false, 'placeholder'=>'Max', 'id'=>"", 'class'=>"form-control"));?>
						</div>     
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field">						
						<?php echo $this->Form->input('isRecurring',array('label'=>false, 'class'=>'form-control selectpicker','data-placeholder'=>'Status','options'=>array('All'=>'All Invoices','Y'=>'Recurring Invoices')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field">												
						<?php echo $this->Form->input('status',array('label'=>false, 'class'=>'form-control selectpicker','data-placeholder'=>'Status','options'=>array(''=>'Status','Draft'=>'Draft','Sent'=>'Sent','Paid'=>'Paid','Marked as paid'=>'Marked as paid','Canceled'=>'Canceled')));?>
					</div>
					<div class="input-group custom-datepicker">
						<?php echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="input-group custom-datepicker">
						<?php echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero">						
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn filter_btn_new','url' => array('controller'=>'AcrClientInvoices','action' => 'index'),'escape'=>false,'update' => '#pageContent'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Js->link('Reset',array('controller'=>'AcrClientInvoices','action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new','update'=>'#pageContent'));?>
					</div>
				</div>
				<?php echo $this->Form->end();?>
				<div  class="row magin-delete-all">
					<span class="deleteicon delete" title="Delete All"> <i class="icon-trash bigger-120" style="color:#d15b47;"></i> </span>
				</div>
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<th class="width10"><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label></th>
							<th class="width200"><?php echo __('Invoice No');?></th>
							<th class="width200"><?php echo __('Customer Name');?></th>
							<th class="width200"><?php echo __('Invoice Date');?></th>
							<th class="width200"><?php echo __('Amount');?></th>
							<th class="width200"><?php echo __('Status');?></th>
							<th class="width150"><?php echo __('Action');?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($acrClientInvoices as $acrClientInvoice):?>
						<tr id = "tr-<?php echo $acrClientInvoice['AcrClientInvoice']['id']?>">
							<td><span class=""> <label>
									<input class="ace delete-m-row" type="checkbox">
									<span class="lbl"></span> </label> </span></td>
							<td><span class="on-load statusopn">
								 <?php echo $this->Html->link($acrClientInvoice['AcrClientInvoice']['invoice_number'],array('controller'=>'acr_client_invoices','action'=>'view',$acrClientInvoice['AcrClientInvoice']['id']),array('escape'=>FALSE,'title'=>'View'));?>
								</span>							
							</td>
							<td><span class="on-load"><?php echo $acrClientInvoice['AcrClient']['client_name'];?></span>
							</td>
							<td><span class="on-load"><?php echo date($dateFormat,strtotime($acrClientInvoice['AcrClientInvoice']['invoiced_date']));?></span>							
							</td>
							<td>
								<span class="on-load">
									<?php $options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
									<?php echo $this->Number->currency($acrClientInvoice['AcrClientInvoice']['invoice_total'],$acrClientInvoice['AcrClientInvoice']['invoice_currency_code']);?>
								</span>
							</td>
							<td id = "td-<?php echo  $acrClientInvoice['AcrClientInvoice']['id'];?>"><span class="on-load "><?php echo $acrClientInvoice['AcrClientInvoice']['status'];?></span>
							</td>
							<td>
							<div class="btn-group visible-md visible-lg hidden-sm hidden-xs">
								<div class="pull-right">
									<div class="inline position-relative">
										<button class="btn btn-minier btn-warning dropdown-toggle" data-toggle="dropdown">
											<i class="icon-caret-down bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
											<li>
												<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'view',$acrClientInvoice['AcrClientInvoice']['id']),array('class'=>'btn btn-xs btn-success view on-load pull-right','escape'=>FALSE,'title'=>'View'));?>
											</li>											
											<li id ="li-<?php echo $acrClientInvoice['AcrClientInvoice']['id']; ?>">	
												<?php if($acrClientInvoice['AcrClientInvoice']['pdf_generated']=="Yes"){
														echo $this->Html->link('<i class="icon-save bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'downloadLink',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['invoice_number']),array('class'=>'btn btn-xs delete on-load pull-right','escape'=>FALSE,'title'=>'Download PDF'));
													}else{
														echo $this -> Js -> link(' <i class="icon-fighter-jet bigger-120"></i>', 
															array('controller' => 'acr_client_invoices', 'action' => 'savePdf',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['invoice_number']),
												    		array('escape' => FALSE, 'update' => '#li-'.$acrClientInvoice['AcrClientInvoice']['id'],'title'=>'Save Pdf','confirm'=>'A pdf of the invoice will be generated and saved in the system,so that you can download.'));
													}								
												?>
											</li>
											<?php if(($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") && ($permission['_delete'] == '1') ){?>
												<li>
													<?php
														if(($acrClientInvoice['AcrClientInvoice']['status'] =="Marked as paid") || ($acrClientInvoice['AcrClientInvoice']['status'] =="Paid")) {
															echo $this -> Js -> link('<i class="icon-trash bigger-120"></i>', 
																 array('controller' => 'acr_client_invoices', 'action' => 'cancelInvoice',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),
												    			 array('escape' => FALSE, 'update' => '#session','title'=>'Cancel Invoice','confirm'=>'Are you sure to Cancel the selected Invoice ?'));
														}else{
															echo $this -> Js -> link('<i class="icon-trash bigger-120"></i>', 
																 array('controller' => 'acr_client_invoices', 'action' => 'cancelInvoice',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),
												    			 array('escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientInvoice']['id'],'title'=>'Cancel Invoice','confirm'=>'Are you sure to Cancel the selected Invoice ?'));
														}
													?>
												</li>		
											<?php } ?>									
										</ul>
									</div>
								</div>
								<!--button class="btn btn-xs edit on-load pull-right" title="Send Invoice" data-toggle="modal" data-target="#mail-<?php echo $acrClientInvoice['AcrClientInvoice']['id']?>"> <i class=" icon-envelope-alt  bigger-120"></i> </button-->
								<?php if(($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") ){?>
								<button class="btn btn-xs edit  on-load pull-right mail-popup" title="Send Invoice" data-toggle="modal" data-target="#M<?php echo $acrClientInvoice['AcrClientInvoice']['id'];?>">
										<i class="icon-envelope-alt  bigger-120"></i>
								</button>
								<?php } ?>
								
								<?php 
								if($acrClientInvoice['AcrClientInvoice']['status'] == "Sent"){
									echo $this->Html->link('<i class="icon-credit-card  bigger-120"></i>',array('controller'=>'acr_invoice_payment_details','action'=>'add',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),array('class'=>'btn btn-xs btn-success delete on-load pull-right','escape'=>FALSE,'title'=>'Capture Payment'));
								}
								?>
								<?php if(($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") && ($acrClientInvoice['AcrClientInvoice']['status'] !="Marked as paid") && ($acrClientInvoice['AcrClientInvoice']['status'] !="Paid") && ($permission['_update'] == '1')){?>
									<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'edit',$acrClientInvoice['AcrClientInvoice']['id']),array('class'=>'btn btn-xs btn-info edit on-load pull-right','escape'=>FALSE,'title'=>'Edit'));?>
								<?php } ?>
							</div>
					<!---MObile View -->		
							<div class="visible-xs visible-sm hidden-md hidden-lg">
									<div class="inline position-relative">
										<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
											<i class="icon-cog icon-only bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
											<li>
												<?php if(($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") ){?>
												<button class="btn btn-xs edit  on-load pull-right mail-popup" title="Send Invoice" data-toggle="modal" data-target="#M<?php echo $acrClientInvoice['AcrClientInvoice']['id'];?>">
														<i class="icon-envelope-alt  bigger-120"></i>
												</button>
												<?php } ?>
											</li>
											<li>
												<?php 
													if($acrClientInvoice['AcrClientInvoice']['status'] == "Sent"){
														echo $this->Html->link('<i class="icon-credit-card  bigger-120"></i>',array('controller'=>'acr_invoice_payment_details','action'=>'add',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),array('class'=>'btn btn-xs btn-success delete on-load pull-right','escape'=>FALSE,'title'=>'Capture Payment'));
													}
												?>
											</li>
											<li>
												<?php if(($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") && ($acrClientInvoice['AcrClientInvoice']['status'] !="Marked as paid") && ($acrClientInvoice['AcrClientInvoice']['status'] !="Paid") && ($permission['_update'] == '1')){?>
													<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'edit',$acrClientInvoice['AcrClientInvoice']['id']),array('class'=>'btn btn-xs btn-info edit on-load pull-right paddinglr3','escape'=>FALSE,'title'=>'Edit'));?>
												<?php } ?>
											</li>
											
											<li>
												<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'view',$acrClientInvoice['AcrClientInvoice']['id']),array('class'=>'btn btn-xs btn-success view on-load pull-right paddinglr3','escape'=>FALSE,'title'=>'View'));?>
											</li>
											
											<li id ="li-<?php echo $acrClientInvoice['AcrClientInvoice']['id']; ?>">	
												<?php if($acrClientInvoice['AcrClientInvoice']['pdf_generated']=="Yes"){
														echo $this->Html->link('<i class="icon-save bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'downloadLink',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['invoice_number']),array('class'=>'btn btn-xs delete on-load pull-right','escape'=>FALSE,'title'=>'Download PDF'));
													}else{
														echo $this -> Js -> link(' <i class="icon-fighter-jet bigger-120"></i>', 
															array('controller' => 'acr_client_invoices', 'action' => 'savePdf',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['invoice_number']),
												    		array('escape' => FALSE, 'update' => '#li-'.$acrClientInvoice['AcrClientInvoice']['id'],'title'=>'Save Pdf','confirm'=>'A pdf of the invoice will be generated and saved in the system,so that you can download.'));
													}								
												?>
											</li>
											<?php if(($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") && ($permission['_delete'] == '1') ){?>
												<li>
													<?php
														if(($acrClientInvoice['AcrClientInvoice']['status'] =="Marked as paid") || ($acrClientInvoice['AcrClientInvoice']['status'] =="Paid")) {
															echo $this -> Js -> link('<i class="icon-trash bigger-120"></i>', 
																 array('controller' => 'acr_client_invoices', 'action' => 'cancelInvoice',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),
												    			 array('escape' => FALSE, 'update' => '#session','title'=>'Cancel Invoice','confirm'=>'Are you sure to Cancel the selected Invoice ?'));
														}else{
															echo $this -> Js -> link('<i class="icon-trash bigger-120"></i>', 
																 array('controller' => 'acr_client_invoices', 'action' => 'cancelInvoice',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),
												    			 array('escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientInvoice']['id'],'title'=>'Cancel Invoice','confirm'=>'Are you sure to Cancel the selected Invoice ?'));
														}
													?>
												</li>		
											<?php } ?>	
											
											
										</ul>
									</div>
							</div>
							<!-- end of mobile view -->
							</td>
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
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
	                                	   
		                                	if($filterAction || $filterValue || $filterValue1 || $filterValue2 || $isRecurring || $status || $fromDate || $toDate ) {
												$url = array('action'=>'index',$filterAction, $filterValue, $filterValue1, $filterValue2, $isRecurring, $status, $fromDate, $toDate, $page);
											} else {
												$url = array('action'=>'index');
											}
											$this->Paginator->options(array(
		     									'update' => '#pageContent',
												'evalScripts' => true,
												'url' => $url,
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
<div id="view_dialog"></div>
<!--Popup mail items  -->
<div class="modal fade mail" id="M<?php echo $acrClientInvoice['AcrClientInvoice']['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog model-quotes">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
				<h1 class="modal-title bold" id="myModalLabel"><?php echo __('Send Invoice');?></h1>
			</div>
			<div class="form-horizontal popup">
			<?php echo $this->Form->create('MailTemplate',array('class'=>'form-horizontal popup','role'=>'form','id'=>'MailTemplate-'.$acrClientInvoice['AcrClientInvoice']['id'],'url'=>array('controller'=>'acr_client_invoices','action'=>'reminder')));?>
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="form-group login-form-group">
							<p><?php echo __('Please select the Template to continue');?></p>
						</div>
						<div id="mail-field" class="form-group filed-left margin-bottom-zero drop-down">
						
							<?php /*echo $this->Form->hidden('invoiceId',array('value'=>$acrClientInvoice['AcrClientInvoice']['id']));*/?>
							<?php echo $this->Form->input('template',array('div'=>false,'label'=>false,'class'=>'form-control selectpicker','data-placeholder'=>'Email Template','options'=>array('sent_invoice'=>'Classic Product Template','sent_invoice_modern'=>'Modern Product Template','sent_invoice_service_classic'=>'Classic Service Template','sent_invoice_service_modern'=>'Modern Service Template')));?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!--button class="btn btn-success addbutton left marginleftzero marginright14" type="button"> <i class="icon-zoom-in bigger-110"></i> Preview </button-->
					<?php echo $this -> Form -> button(__('<i class="icon-share-alt bigger-110"></i> Send Now'), array('controller' => 'acr_client_invoices', 'action' => 'reminder', 'div' => false, 'class' => 'btn btn-info left marginleftzero marginright4 padding0')); ?>
				 	<button class="btn btn-success addbutton left marginleftzero marginright4 padding0 sendnow" title="Send Now" data-toggle="modal" data-target="#preview-<?php echo $acrClientInvoice['AcrClientInvoice']['id']?>">
						<i class="icon-zoom-in bigger-110"></i> Preview
					</button> 
					<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright6 padding0','url' => array('controller'=>'AcrClientInvoices','action'=>'previewSend'),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'));?>
					<button class="btn left btn-inverse marginleftzero popup-cancel marginright4 padding0" type="button"> <i class="icon-remove bigger-110"></i> Cancel </button>
				</div>
			<?php echo $this->Form->end();?>
			</div>	
			
		</div>
	</div>
</div>

<div class="modal fade" id="preview-<?php echo $acrClientInvoice['AcrClientInvoice']['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div id="preview-template" class="modal-dialog model-quotes">
	</div>
</div>
<!--end of pop--> 
<script type="text/javascript">
			
			$(document).ready(function(){
				$('.sendnow').click(function(){
					$('.previewpopup').trigger('click')
				});
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
    	         
    	         $('.mail-popup').click(function(){
						var thisid=$(this).attr('data-target');
	 					var thislength=thisid.length;
	 					thisid=thisid.slice(2,thislength);
	 					$('.modal.fade.mail').attr('id','M'+thisid);
	 					$('#mail-field').append("<input name='data[MailTemplate][invoiceId]' type='hidden' value='"+thisid+"'/>");
	 			});
	 			$('.previewbtn').click(function(){
					$('.previewpopup').trigger('click');
				});			
			});
				
				
	$(document).ready(function(){
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