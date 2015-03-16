<?php $counts = $this->Paginator->params();?>
<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php 
	$dbFormat = array("d", "M", "Y");
	$scriptFormat   = array("dd", "mm", "yyyy");
?>
<?php $page = $this->Paginator->current('AcrClientInvoice');?>
<?php 
    $permissionCreditNotes = $this->Session->read('Auth.AllPermissions.Manage Credits');
	$homeLink = $this->Breadcrumb->getLink('Home');
	if($filterAction || $filterValue || $filterValue1 || $filterValue2 || $isRecurring || $status || $fromDate || $toDate ) {
												$url = array('action'=>'index',$filterAction, $filterValue, $filterValue1, $filterValue2, $isRecurring, $status, $fromDate, $toDate, $page);
											} else {
												$url = array('action'=>'index');
											}
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
		<li>
			<?php echo $this->Html->link('Invoices',array('action'=>'index'),array('escape'=>FALSE));?>
		</li>
		<li class="active">
			<?php echo __('Invoices');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			<?php echo __('Manage Invoices');?>
		</div>
		
	    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-8 no-padding-left no-padding-right width-after-600">
	          <?php if(($showAddButton) && ($permission['_create'] == '1')){?>
			     <div class="widthauto paddingleftrightzero pull-right buttonrightwidth padding-right-3-480 mobile_100">
				    <?php echo $this->Html->link('<i class="icon-plus"></i> Add New Invoice',array('action'=>'add'),array('class'=>'btn btn-sm btn-success pull-right addbutton width-after-400 mobile_100','escape'=>FALSE));?>
			     </div>
	          <?php } ?>
			  <div class="widthauto paddingleftrightzero pull-right padding-right-3-480 width50p margin-top-10-420 buttonrightwidth mobile_100">
					<?php echo $this->Html->link('Export Invoices <i class="icon-caret-down icon-on-right"></i>',array('controller'=>'AcrClientInvoices','action'=>'exportInvoices'),array('class'=>'btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100','escape'=>FALSE));?>
			  </div>
			  <?php if(($showAddButton) && ($permission['_create'] == '1')){?>
			     <div class="widthauto paddingleftrightzero pull-right width50p margin-top-10-420 buttonrightwidth mobile_100">
					<?php echo $this->Html->link('Import Invoices <i class="icon-caret-down icon-on-right"></i>',array('controller'=>'AcrClientInvoices','action'=>'showExcel'),array('class'=>'btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400 mobile_100','escape'=>FALSE));?>
				</div>
			  <?php } ?>
	       </div>
		</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<div class="table-header">
					<?php echo __('Invoices List');?>
					
				</div>
				<?php echo $this->Form->create('InvoiceFilter',array('id'=>'InvoiceFilter','url'=>array('controller'=>'AcrClientInvoices','action'=>'index')));?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-100-480 mobile_100 choosen_width">						
						<?php echo $this->Form->input('filterAction',array('label'=>false,'class'=>'form-control invdrop selectitem abc','data-placeholder'=>'Filter By','options'=>array(''=>'Filter By','invoice_number'=>'Invoice Number','customer_name'=>'Customer Name','amount'=>'Amount')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero dispalycommon filterenter width-100-480 mobile_100">						
						<?php echo $this->Form->input('filterValue',array('label'=>false, 'placeholder'=>'Enter', 'id'=>"", 'class'=>"form-control")); ?>
					</div>
					<div class="form-group filed-left margin-bottom-zero widthinput150 displayifnumber mobile_100">
						<div class="form-group margin-bottom-zero inpuwidth70 left marginright10">						     
						    <?php 
						    	if($filterValue1 && ($filterValue1!="null")){
						    		echo $this->Form->input('filterValue1',array('label'=>false, 'placeholder'=>'Min', 'id'=>"", 'class'=>"form-control",'value'=>$filterValue1));
						    	}else{
						    		echo $this->Form->input('filterValue1',array('label'=>false, 'placeholder'=>'Min', 'id'=>"", 'class'=>"form-control",'value'=>''));
						    	}
						    ?>
						</div>
						<div class="form-group margin-bottom-zero inpuwidth70 left">						    
						     <?php 
						     	if($filterValue2 && ($filterValue2!="null")){
						     		echo $this->Form->input('filterValue2',array('label'=>false, 'placeholder'=>'Max', 'id'=>"", 'class'=>"form-control",'value'=>$filterValue2));
								}else{
									echo $this->Form->input('filterValue2',array('label'=>false, 'placeholder'=>'Max', 'id'=>"", 'class'=>"form-control",'value'=>''));
								}	
						     ?>
						</div>     
					</div>
					
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-100-480 mobile_100 choosen_width">												
						<?php echo $this->Form->input('status',array('label'=>false, 'class'=>'form-control invdrop','data-placeholder'=>'Status','options'=>array(''=>'Status','Canceled'=>'Canceled','Draft'=>'Draft', 'Open'=>'Open','Paid'=>'Paid','Partially Paid'=>'Partially Paid','Sent'=>'Sent')));?>
					</div>
					<div class="input-group form-group custom-datepicker width-100-480 datewidth">
						<?php echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$dateFormat),'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="input-group form-group custom-datepicker width-100-480 datewidth">
						<?php echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$dateFormat),'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">						
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','url' => array('controller'=>'AcrClientInvoices','action' => 'index'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading1')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading1')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'AcrClientInvoices','action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','update'=>'#pageContent'));?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading1','style'=>'display:none;float: right;margin-right: -18px;padding-top: 4px;'));?>
				</div>
				<?php echo $this->Form->end();?>
          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom5">				
				<?php foreach($acrClientInvoices as $acrClientInvoice):?>
                 <table class="table table-striped roles-table tabletlandscape">
					<tr>
						<td class="title_role bold width-120-new">
							<?php echo $this->Paginator->sort('AcrClientInvoice.invoice_number','Invoice No',array('update'=>'#pageContent','url'=>$url));?>
						</td>
						<td class="title bold width-150-new">
							<?php echo $this->Paginator->sort('AcrClient.organization_name','Customer Name',array('update'=>'#pageContent','url'=>$url));?>
						</td>
						<td class="title bold width-120-new">
							<?php echo $this->Paginator->sort('AcrClientInvoice.invoiced_date','Invoice Date',array('update'=>'#pageContent','url'=>$url));?>
						</td>
						<td class="title bold width-120-new textright padding-right-25">
							<?php echo $this->Paginator->sort('AcrClientInvoice.invoice_total','Amount',array('update'=>'#pageContent','url'=>$url));?>
						</td>
						<td class="title bold width-120-new textright padding-right-25">
							<?php echo __('Balance');?>
							<?php /*echo $this->Paginator->sort('AcrInvoicePaymentDetail.paid_amount','Balance',array('update'=>'#pageContent','url'=>$url));*/?>
						</td>
						<td class="title bold width-120-new "><?php echo __('Status');?></td>
						<td class="title bold action width-100-new"><?php echo __('Action');?></td>
					</tr>
					
					<tr class="even-strip" id = "tr-<?php echo $acrClientInvoice['AcrClientInvoice']['id']?>">
						<td class="title_role width-120-new">
						   <span class="statusopn">
								 <?php echo $this->Html->link($acrClientInvoice['AcrClientInvoice']['invoice_number'],array('controller'=>'acr_client_invoices','action'=>'view',$acrClientInvoice['AcrClientInvoice']['id']),array('escape'=>FALSE,'title'=>'View'));?>
						  </span>	
						</td>
						<td class="title width-150-new">
						<?php if($acrClientInvoice['AcrClient']['organization_name']){
								echo $acrClientInvoice['AcrClient']['organization_name'];
							}else{
								echo $acrClientInvoice['AcrClient']['client_name'];
							} ?>
						</td>
						<td class="title width-120-new">
						<?php echo date($dateFormat,strtotime($acrClientInvoice['AcrClientInvoice']['invoiced_date']));?>
						</td>
						<td class="title width-120-new textright padding-right-25">
						<?php $options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
									<?php echo $this->Number->currency($acrClientInvoice['AcrClientInvoice']['invoice_total'],$acrClientInvoice['AcrClientInvoice']['invoice_currency_code']);?>
						</td>
						<td class="title width-120-new textright padding-right-25">
							
							<?php if($acrClientInvoice['AcrInvoicePaymentDetail']){?>
								<?php $paidAmount = 0;?>
							<?php $balance = 0;?>
							<?php	foreach($acrClientInvoice['AcrInvoicePaymentDetail'] as $ind=>$indexValue){
									if(($indexValue['is_deleted'] == "no") && ($indexValue['paid_amount'])){
										$paidAmount += $indexValue['paid_amount'];
									}
								}
									$balance = $acrClientInvoice['AcrClientInvoice']['invoice_total'] - $paidAmount;
									if($balance <0){
										$balance += 0.00;
									}
								?>
								<?php }else{
									$balance = $acrClientInvoice['AcrClientInvoice']['invoice_total'];
								}?>
									<?php echo $this->Number->currency($balance,$acrClientInvoice['AcrClientInvoice']['invoice_currency_code']);?>
						</td>
						<?php if($acrClientInvoice['AcrClientInvoice']['status'] == "Sent"){
							$colorClass = "due";
						}elseif($acrClientInvoice['AcrClientInvoice']['status'] == "Paid" || ($acrClientInvoice['AcrClientInvoice']['status'] == "Marked as paid")|| ($acrClientInvoice['AcrClientInvoice']['status'] == "Partially Paid")){
							$colorClass = "paid";
						}elseif($acrClientInvoice['AcrClientInvoice']['status'] == "Draft"){
							$colorClass = "cancelled";
						}elseif($acrClientInvoice['AcrClientInvoice']['status'] == "Open"){
							$colorClass = "open";
						}elseif($acrClientInvoice['AcrClientInvoice']['status'] == "Canceled"){
							$colorClass = "cancelled";
						}?>
						<td class="title width-120-new <?php echo $colorClass;?>">
							<?php 
								echo $acrClientInvoice['AcrClientInvoice']['status'];
							?>
						</td>
						
						<td class="title width-100-new">
						<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								
								
								<?php 
								if(($acrClientInvoice['AcrClientInvoice']['status'] == "Sent") || ($acrClientInvoice['AcrClientInvoice']['status'] == "Open")|| ($acrClientInvoice['AcrClientInvoice']['status'] == "Partially Paid")){
									echo $this->Html->link('<i class="icon-credit-card  bigger-120"></i>',array('controller'=>'acr_invoice_payment_details','action'=>'add',$acrClientInvoice['AcrClientInvoice']['id']),array('class'=>'btn btn-xs btn-success delete on-load','escape'=>FALSE,'title'=>'Capture Payment'));
								}
								?>
								<?php if(($permission['_update'] == '1') && ($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") && ($acrClientInvoice['AcrClientInvoice']['status'] !="Marked as paid") && ($acrClientInvoice['AcrClientInvoice']['status'] !="Paid") && ($permission['_update'] == '1')){?>
									<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'edit',$acrClientInvoice['AcrClientInvoice']['id'],$filterAction, $filterValue, $filterValue1, $filterValue2, $isRecurring, $status, $fromDate, $toDate, $page),array('class'=>'btn btn-xs btn-info edit on-load','escape'=>FALSE,'title'=>'Edit'));?>
								<?php } ?>
								
								
								
								
								<!--button class="btn btn-xs edit on-load pull-right" title="Send Invoice" data-toggle="modal" data-target="#mail-<?php echo $acrClientInvoice['AcrClientInvoice']['id']?>"> <i class=" icon-envelope-alt  bigger-120"></i> </button-->
								<?php if(($permission['_update'] == '1') &&($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") ){?>
								<button class="btn btn-xs edit  on-load mail-popup" title="Send Invoice" data-toggle="modal" data-target="#M<?php echo $acrClientInvoice['AcrClientInvoice']['id'];?>">
										<i class="icon-envelope-alt  bigger-120"></i>
								</button>
								<?php } ?>
								
								
								
								
								<div>
									<div class="inline position-relative">
										<button class="btn btn-minier btn-warning dropdown-toggle" data-toggle="dropdown">
											<i class="icon-caret-down bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
											<li>
												<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'view',$acrClientInvoice['AcrClientInvoice']['id'],$filterAction, $filterValue, $filterValue1, $filterValue2, $isRecurring, $status, $fromDate, $toDate, $page),array('class'=>'btn btn-xs btn-success view on-load pull-right padding_zero','escape'=>FALSE,'title'=>'View'));?>
											</li>
											<?php if(($acrClientInvoice['AcrClientInvoice']['status'] =="Sent" || $acrClientInvoice['AcrClientInvoice']['status'] =="Partially Paid" || $acrClientInvoice['AcrClientInvoice']['status'] =="Open") && ($permissionCreditNotes['_update'] == '1')):?>
                                                <li class="apply_button">
                                                    <?php echo $this->Html->link('C',array('controller'=>'CreditNotes','action'=>'add',TRUE,base64_encode($acrClientInvoice['AcrClientInvoice']['id']),base64_encode($acrClientInvoice['AcrClientInvoice']['acr_client_id']),'?'=>array('filterAction'=>$filterAction, 'filterValue'=>$filterValue, 'filterValue1'=>$filterValue1, 'filterValue2'=>$filterValue2, 'isRecurring'=>$isRecurring, 'status'=>$status, 'fromDate'=>$fromDate, 'toDate'=>$toDate, 'page'=>$page)),array('class'=>'btn btn-xs btn-pink view on-load convertInvoice','title'=>'Create Credit Note'));?>
                                               
                                               		<?php
                                               			/*
														   echo $this -> Js -> link('C', 
																															array('controller' => 'CreditNotes', 'action' => 'add',TRUE,$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['acr_client_id'],'?'=>array('filterAction'=>$filterAction, 'filterValue'=>$filterValue, 'filterValue1'=>$filterValue1, 'filterValue2'=>$filterValue2, 'isRecurring'=>$isRecurring, 'status'=>$status, 'fromDate'=>$fromDate, 'toDate'=>$toDate, 'page'=>$page)),
																															array('escape' => FALSE, 'update' => '#pageContent','class'=>'btn btn-xs btn-pink view on-load convertInvoice','title'=>'Create Credit Note')); */
														   
                                               		?>
                                                </li>
                                            <?php endif;?>											
											<li id ="li-<?php echo $acrClientInvoice['AcrClientInvoice']['id']; ?>">	
												<?php 
														echo $this->Html->link('<i class="icon-save bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'downloadOnlyPdf',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['invoice_number']),array('class'=>'btn btn-xs delete on-load pull-right padding_zero','escape'=>FALSE,'title'=>'Download PDF','confirm'=>'Click Ok to download the pdf.'));
												?>
											</li>
											<?php if(($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") && ($permission['_delete'] == '1') ){?>
												<li>
													<?php
														if(($acrClientInvoice['AcrClientInvoice']['status'] =="Marked as paid") || ($acrClientInvoice['AcrClientInvoice']['status'] =="Paid")) {
															echo $this -> Js -> link('<i class="icon-trash bigger-120"></i>', 
																 array('controller' => 'acr_client_invoices', 'action' => 'cancelInvoice',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),
												    			 array('escape' => FALSE, 'update' => '#session','class'=>'btn btn-xs btn-danger delete pull-right padding_zero','title'=>'Cancel Invoice','confirm'=>'Are you sure to Cancel the selected Invoice ?'));
														}else{
															echo $this -> Js -> link('<i class="icon-trash bigger-120"></i>', 
																 array('controller' => 'acr_client_invoices', 'action' => 'cancelInvoice',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),
												    			 array('escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientInvoice']['id'],'class'=>'btn btn-xs btn-danger delete pull-right padding_zero','title'=>'Cancel Invoice','confirm'=>'Are you sure to Cancel the selected Invoice ?'));
														}
													?>
												</li>		
											<?php } ?>
																				
										</ul>
									</div>
								</div>
								
							</div>
							
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>
									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
										<li>
											<?php 
											if(($acrClientInvoice['AcrClientInvoice']['status'] == "Sent") || ($acrClientInvoice['AcrClientInvoice']['status'] == "Open")|| ($acrClientInvoice['AcrClientInvoice']['status'] == "Partially Paid")){
												echo $this->Html->link('<i class="icon-credit-card  bigger-120"></i>',array('controller'=>'acr_invoice_payment_details','action'=>'add',$acrClientInvoice['AcrClientInvoice']['id']),array('class'=>'btn btn-xs btn-success delete on-load padding_zero','escape'=>FALSE,'title'=>'Capture Payment'));
											}
											?>
											<?php if(($permission['_update'] == '1') && ($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") && ($acrClientInvoice['AcrClientInvoice']['status'] !="Marked as paid") && ($acrClientInvoice['AcrClientInvoice']['status'] !="Paid") && ($permission['_update'] == '1')){?>
												<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'edit',$acrClientInvoice['AcrClientInvoice']['id'],$filterAction, $filterValue, $filterValue1, $filterValue2, $isRecurring, $status, $fromDate, $toDate, $page),array('class'=>'btn btn-xs btn-info edit on-load padding_zero','escape'=>FALSE,'title'=>'Edit'));?>
											<?php } ?>
										</li>
										<li>
											<?php if(($permission['_update'] == '1') &&($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") ){?>
											<button class="btn btn-xs edit  on-load mail-popup padding02" title="Send Invoice" data-toggle="modal" data-target="#M<?php echo $acrClientInvoice['AcrClientInvoice']['id'];?>">
													<i class="icon-envelope-alt  bigger-120"></i>
											</button>
											<?php } ?>
										</li>
										<li>
												<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'view',$acrClientInvoice['AcrClientInvoice']['id'],$filterAction, $filterValue, $filterValue1, $filterValue2, $isRecurring, $status, $fromDate, $toDate, $page),array('class'=>'btn btn-xs btn-success view on-load pull-right padding_zero','escape'=>FALSE,'title'=>'View'));?>
											</li>
											<?php if(($acrClientInvoice['AcrClientInvoice']['status'] =="Sent" || $acrClientInvoice['AcrClientInvoice']['status'] =="Partially Paid" || $acrClientInvoice['AcrClientInvoice']['status'] =="Open") && ($permissionCreditNotes['_update'] == '1')):?>
                                                <li class="apply_button">
                                                    <?php echo $this->Html->link('C',array('controller'=>'CreditNotes','action'=>'add',TRUE,$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['acr_client_id'],'?'=>array('filterAction'=>$filterAction, 'filterValue'=>$filterValue, 'filterValue1'=>$filterValue1, 'filterValue2'=>$filterValue2, 'isRecurring'=>$isRecurring, 'status'=>$status, 'fromDate'=>$fromDate, 'toDate'=>$toDate, 'page'=>$page)),array('class'=>'btn btn-xs btn-pink view on-load convertInvoice','title'=>'Create Credit Note'));?>
                                                </li>
                                            <?php endif;?>											
											<li id ="li-<?php echo $acrClientInvoice['AcrClientInvoice']['id']; ?>">	
												<?php 
														echo $this->Html->link('<i class="icon-save bigger-120"></i>',array('controller'=>'acr_client_invoices','action'=>'downloadOnlyPdf',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['invoice_number']),array('class'=>'btn btn-xs delete on-load pull-right padding_zero','escape'=>FALSE,'title'=>'Download PDF','confirm'=>'Click Ok to download the pdf.'));
												?>
											</li>
											<?php if(($acrClientInvoice['AcrClientInvoice']['status'] !="Canceled") && ($permission['_delete'] == '1') ){?>
												<li>
													<?php
														if(($acrClientInvoice['AcrClientInvoice']['status'] =="Marked as paid") || ($acrClientInvoice['AcrClientInvoice']['status'] =="Paid")) {
															echo $this -> Js -> link('<i class="icon-trash bigger-120"></i>', 
																 array('controller' => 'acr_client_invoices', 'action' => 'cancelInvoice',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),
												    			 array('escape' => FALSE, 'update' => '#session','class'=>'btn btn-xs btn-danger delete pull-right padding_zero','title'=>'Cancel Invoice','confirm'=>'Are you sure to Cancel the selected Invoice ?'));
														}else{
															echo $this -> Js -> link('<i class="icon-trash bigger-120"></i>', 
																 array('controller' => 'acr_client_invoices', 'action' => 'cancelInvoice',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientInvoice']['status']),
												    			 array('escape' => FALSE, 'update' => '#tr-'.$acrClientInvoice['AcrClientInvoice']['id'],'class'=>'btn btn-xs btn-danger delete pull-right padding_zero','title'=>'Cancel Invoice','confirm'=>'Are you sure to Cancel the selected Invoice ?'));
														}
													?>
												</li>		
											<?php } ?>
									</ul>
								</div>
							</div>
					</td>
					</tr>
             </table>
		<?php endforeach;?>
		</div>
		</div>
		</div>
			<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 no-padding-left no-padding-right pagination_container">
                   <div class="col-sm-6 no-padding-left no-padding-right margin020 paginationText">
                      <div id="sample-table-2_info" class="dataTables_info">
	                     	<?php
								echo $this->Paginator->counter(array(
									'format' => __('showing <span>{:start}</span> to <span>{:end}</span> of {:count}')
								));
							?>
                     	</div>
                      </div>
	                      <div class="col-sm-6 no-padding-left no-padding-right paginationNumber">
	                           <div class="paging_bootstrap">
	                                <ul class="pagination no-padding-left no-padding-right pull-right">
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
				<?php echo $this->Form->hidden('filterAction',array('value'=>$filterAction));?>
				<?php echo $this->Form->hidden('filterValue',array('value'=>$filterValue));?>
				<?php echo $this->Form->hidden('filterValue1',array('value'=>$filterValue1));?>
				<?php echo $this->Form->hidden('filterValue2',array('value'=>$filterValue2));?>
				<?php echo $this->Form->hidden('isRecurring',array('value'=>$isRecurring));?>
				<?php echo $this->Form->hidden('status',array('value'=>$status));?>
				<?php echo $this->Form->hidden('fromDate',array('value'=>$fromDate));?>
				<?php echo $this->Form->hidden('toDate',array('value'=>$toDate));?>
				<?php echo $this->Form->hidden('page',array('value'=>$page));?>
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
					<button class="btn btn-success addbutton left marginleftzero marginright4 padding0 sendnow" title="Send Now" data-toggle="modal" data-target="#preview-<?php echo $acrClientInvoice['AcrClientInvoice']['id']?>">
						<i class="icon-zoom-in bigger-110"></i> Preview
					</button>
					<?php echo $this -> Form -> button(__('<i class="icon-share-alt bigger-110"></i> Send'), array('controller' => 'acr_client_invoices', 'action' => 'reminder', 'div' => false, 'class' => 'btn btn-info left marginleftzero marginright4 padding0')); ?>
				 	
					<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright6 padding0','url' => array('controller'=>'AcrClientInvoices','action'=>'previewSend'),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'));?>
					<button class="btn left btn-inverse marginleftzero popup-cancel marginright4 padding0" type="button"> <i class="icon-remove bigger-110"></i> Cancel </button>
				</div>
			<?php echo $this->Form->end();?>
			</div>	
			
		</div>
	</div>
</div>


<!--Popup preview items  -->
<div class="modal fade" id="preview-<?php echo $acrClientInvoice['AcrClientInvoice']['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div  class="modal-dialog model-quotes" style="width:927px;">
		 <div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
			</div>
			<div id="preview-template" style="float:left;width:100%;">
				
			</div>
		</div>	
	 </div>
</div>
<!--end of pop-->

<script type="text/javascript">
			$(document).ready(function(){
				
				/* choosen select*/
						var config = {
							  
							  '.invdrop' : {search_contains:true}
							}
							for (var selector in config) {
							  $(selector).chosen(config[selector]);
						}
					/* choosen select*/
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
});



</script>

<?php echo $this->Js->writeBuffer();?>