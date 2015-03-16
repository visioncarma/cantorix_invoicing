<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
?>
<?php 
	$dbFormat = array("d", "M", "Y");
	$scriptFormat   = array("dd", "mm", "yyyy");
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
			<?php echo $this -> Html -> link('Recurring Invoices', array('controller' => 'acr_client_recurring_invoices', 'action' => 'index'), array('div' => false, 'escape' => false)); ?>
		</li>
		<li class="active">
			<?php echo __('Edit Recurring Invoice');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 > <?php echo __('Edit Recurring Invoice');?> </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i>Back', array('action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$page), array('class' => 'btn btn-sm btn-success pull-right addbutton', 'escape' => FALSE)); ?>
		</div>

	</div>
	<!-- /.page-header -->
	<?php echo $this->Form->create('AcrClientInvoice',array('class'=>'form-horizontal formdetails','role'=>'form'));?>
		<?php echo $this->Form->hidden('invoiceId',array('value'=>$invoiceData['AcrClientInvoice']['id']));?>
		<?php echo $this->Form->hidden('recurrenceId',array('value'=>$acrClientRecurringInvoice['AcrClientRecurringInvoice']['id']));?>
		<?php echo $this->Form->hidden('last_invoice_date',array('value'=>$acrClientRecurringInvoice['AcrClientRecurringInvoice']['last_invoice_date']));?>
		<div class="row marginleftrightzero">
			<div class="col-lg-8 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Invoice No');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero" id = "invoiceNumber">
							<?php echo $this->Form->input('invoice_number',array('id'=>'invNumber','div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','placeholder'=>'Invoice no.','value'=>$invoiceData['AcrClientInvoice']['invoice_number']));
										 $this->Js->get('#invNumber')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'invoiceNumberExist'), array( 'update'=>'#invoiceNumber', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
							?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Purchase Order No.');?> #</label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('purchase_order_no',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','placeholder'=>'Purchase order no.','value'=>$invoiceData['AcrClientInvoice']['purchase_order_no']))?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Invoice Description');?></label>
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('invoice_description',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','placeholder'=>'Invoice description','value'=>$invoiceData['AcrClientInvoice']['description']))?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Customer');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero countrybilling max-height max-width labelerror choosen_width">
							
							<?php echo $this->Form->input('acr_client_id',array('id'=>'clientId','div'=>false,'label'=>false,'options'=>array(''=>'',$customer),'data-live-search' => 'true','class'=>'form-control invdrop','data-placeholder'=>"Select Customer",'default'=>$invoiceData['AcrClientInvoice']['acr_client_id']));
								  $this->Js->get('#clientId')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'customerInfo'), array( 'update'=>'#customerInfo', 'async'=>false, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
							?>
							<?php
								$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getClientCurrency'), array('update' => '#currencyDiv', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true))))); 
							?>
							<?php
								$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getDefaultPaymentTerm'), array('update' => '#paymentTerm', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true))))); 
							?>
							<?php 
								$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'findEndDate'), array('update' => '#dueDateUpdate', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
							?>
							<?php
								$this->Js->get('#clientId')->event('change', $this->Js->request(array (
									        'controller' => 'acr_client_invoices',
									        'action' => 'calculateTotal'
								       ), array (
									       'update' => '#calculateFinal',
									       'async' => false,
									       'dataExpression' => true,
									       'method' => 'post',
									       'data' => $this->Js->serializeForm(array (
									             'isForm' => false,
									             'inline' => true
								            ))
							           )));	
							?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero" id = "currencyDiv">
					<div class="form-group  marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Currency');?></label>
						<div class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero countrybilling max-height max-width choosen_width">
							
							<?php echo $this->Form->hidden('defaultCurrencyId',array('value'=>$defaultCurrency));?>
							<?php echo $this->Form->input('cpn_currency_id',array('id'=>'invoiceCurrencySelect','div'=>false,'label'=>false,'data-placeholder'=>"Select Currency",'options'=>array(''=>'',$currencyList),'default'=>$invoicedCurrency,'data-live-search' => 'true','class'=>'form-control invdrop','disabled'=>'disabled'));
										$this->Js->get('#invoiceCurrencySelect')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'currencyInfo'), array( 'update'=>'#invoiceCurrency', 'async'=>false, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
							?>
							
							<?php
							$this->Js->get('#invoiceCurrencySelect')->event('change', $this->Js->request(array (
									'controller' => 'acr_client_invoices',
									'action' => 'calculateTotal'
							), array (
									'update' => '#calculateFinal',
									'async' => true,
									'dataExpression' => true,
									'method' => 'post',
									'data' => $this->Js->serializeForm(array (
											'isForm' => false,
											'inline' => true
									))
							)));	
						?>
						</div>
						
						<div id = "invoiceCurrency">
							<?php if($defaultCurrencyCode != $invoiceData['AcrClientInvoice']['invoice_currency_code']):?>
							<div class="col-xs-12 col-sm-2 col-lg-2  paddingleftrightzero">
								<sapn class="conversion">
									<?php echo '1 '.$invoiceData['AcrClientInvoice']['invoice_currency_code'];?>
								</sapn>
							</div>
							<div class="col-xs-12 col-sm-1 col-lg-2 marginleftrightzero paddingleftrightzero">
								<?php echo $this->Form->input('conversionValue',array('id'=>'conversionValue','div'=>false,'label'=>false,'type'=>'text','class'=>'form-control specialborder','placeholder'=>'Enter conversion value','value'=>$invoiceData['AcrClientInvoice']['exchange_rate']));
											 $this->Js->get('#conversionValue')->event('change', $this->Js->request(array (
									        'controller' => 'acr_client_invoices',
									        'action' => 'calculateTotal'
								       ), array (
									       'update' => '#calculateFinal',
									       'async' => true,
									       'dataExpression' => true,
									       'method' => 'post',
									       'data' => $this->Js->serializeForm(array (
									             'isForm' => false,
									             'inline' => true
								            ))
							           )));	
								
								?>
							</div>
							<div class="col-xs-12 col-sm-2 col-lg-1 marginleftrightzero paddingleftrightzero">
								<sapn class="conversion" >
									<?php echo $defaultCurrencyCode;?>
								</sapn>
							</div>
							<?php endif; ?>
						</div>
						
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Issue Date');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker">
								<?php echo $this->Form->input('invoiced_date',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control date-picker','data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $dateFormat),'readonly'=>'readonly','value'=>date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date']))))?>
								
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Terms');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero choosen_width" id = "paymentTerm">
							<?php echo $this->Form->input('sbs_subscriber_payment_term_id',array('id'=>'paymentTems','div'=>false,'label'=>false,'options'=>array(''=>'',$paymentTerm),'class'=>'form-control invdrop','data-placeholder'=>"Select term",'default'=>$invoiceData['AcrClientInvoice']['sbs_subscriber_payment_term_id']));
										$this->Js->get('#paymentTems')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'findEndDate'), array( 'update'=>'#dueDateUpdate', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
							?>
						</div>
					</div>
				</div>
				
				
				
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Recurring Period');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero countrybilling choosen_width">
							<?php echo $this->Form->input('AcrClientInvoice.recurring_period',array('div'=>false,'label'=>false,'class'=>'invdrop form-control','data-placeholder'=>"Select",'options'=>array(''=>'','Day'=>'Day','Week'=>'Week','Month'=>'Month','Year'=>'Year'),'default'=>$acrClientRecurringInvoice['AcrClientRecurringInvoice']['billing_period']));?>
						</div>
					</div>
				</div>
				
				
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Recurring Frequency');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero" id = "invoiceNumber">
							<?php echo $this->Form->input('AcrClientInvoice.recurring_frequency',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','placeholder'=>'Recurring Frequency','value'=>$acrClientRecurringInvoice['AcrClientRecurringInvoice']['billing_frequency']));?>
											
						</div>
					</div>
				</div>
				
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Start Date');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker">
								<?php echo $this->Form->input('AcrClientInvoice.start_date',array('label'=>false,'div'=>false,'id'=>'start-date','class'=>'form-control date-picker','type'=>'text','data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $dateFormat),'readonly'=>'readonly','style'=>'cursor:default','value'=>date($dateFormat,strtotime($acrClientRecurringInvoice['AcrClientRecurringInvoice']['invoice_start_date']))));?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div>
						</div>
					</div>
				</div>	
		
                <div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('End Date');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker">
								<?php echo $this->Form->input('AcrClientInvoice.end_date',array('div'=>false,'label'=>false,'class'=>'form-control date-picker','id'=>'end-date','type'=>'text','data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $dateFormat),'readonly'=>'readonly','style'=>'cursor:default','value'=>date($dateFormat,strtotime($acrClientRecurringInvoice['AcrClientRecurringInvoice']['invoice_end_date']))))?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div>
						</div>
					</div>
				</div>	
				
		
				
				
				
				
			</div>
			<div class="col-lg-4 no-padding-right  no-padding-left" id ="customerInfo">
				<div class="widget-box">
					<div class="widget-header">
						<h5><?php echo __('Invoice to');?></h5>
					</div>

					<div class="widget-body">
						<div class="widget-main paddingleftrightzero">
							<div class="form-horizontal">
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												<?php echo __('Contact Name');?>
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php if($contactPersonName){echo $contactPersonName;}else{ echo '<font color ="red"> Not Available</font>';}?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												<?php echo __('Contact Surname');?>
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php if($contactSurName){echo $contactSurName;}else{ echo '<font color ="red"> Not Available</font>';}?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												<?php echo __('Contact Email');?>
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php if($contactEmail){echo $contactEmail;}else{ echo '<font color ="red"> Not Available</font>';}?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												<?php echo __('Mobile');?>
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php if($contactMobile){echo $contactMobile;}else{ echo '<font color ="red"> Not Available</font>';}?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group  marginleftrightzero borderline">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												<?php echo __('Home Phone');?>
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php if($contactHomePhone){echo $contactHomePhone;}else{ echo '<font color ="red"> Not Available</font>';}?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group  marginleftrightzero lastrow">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												<?php echo __('Work Phone');?>
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php if($contactWorkPhone){echo $contactWorkPhone;}else{ echo '<font color ="red"> Not Available</font>';}?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		
			
		</div>
		<div class="row marginleftrightzero">
			<table id="quote-table" class="table table-striped table-bordered table-hover editable-table margin-bottom-zero">
				<thead>
					<tr class="borderblue">
						<th class="width180"><?php echo __('Item');?></th>
						<th class="width300"><?php echo __('Item Description');?></th>
						<th class="width65"><?php echo __('Qty');?></th>
						<th class="width120"><?php echo __('Unit Price');?></th>
						<th class="width120"><?php echo __('Discount %');?></th>
						<th class="width150"><?php echo __('Tax');?></th>
						<th class="width120"><?php echo __('Amount');?></th>
						<th class="width65"><?php echo __('Action'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($invoiceDetail as $detailKey => $detailVal):?>
					<?php echo $this->Form->hidden('AcrClientInvoice.inventory_Old.'.$detailVal['AcrInvoiceDetail']['id'],array('value'=>$detailVal['AcrInvoiceDetail']['id']));?>
					<tr id ="inventoryUpdateSelect-<?php echo $detailVal['AcrInvoiceDetail']['id']?>">
							<td id = "td-inventoryUpdateSelect-<?php echo $detailVal['AcrInvoiceDetail']['id'];?>">
								<div class="form-group marginleftrightzero margin-bottom-zero">
									<div class="col-sm-10 marginleftrightzero paddingleftrightzero countrybilling max-height max-width choosen_width">
										
										<?php echo $this->Form->input('AcrClientInvoice.inventory.'.$detailVal['AcrInvoiceDetail']['id'],array('id'=>'inventory-'.$detailVal['AcrInvoiceDetail']['id'],'data-live-search'=>'true','div'=>false,'label'=>false,'class'=>'invdrop form-control','data-placeholder'=>"Select inventory",'options'=>array(''=>'','-1'=>'Non Inventory Item',$inventoryList),'default'=>$detailVal['AcrInvoiceDetail']['inv_inventory_id']));
													$this->Js->get('#inventory-'.$detailVal['AcrInvoiceDetail']['id'])->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'getInventoryDetails',$detailVal['AcrInvoiceDetail']['id'],$detailVal['AcrInvoiceDetail']['id']), array( 'update'=>'#inventoryUpdateSelect-'.$detailVal['AcrInvoiceDetail']['id'], 'async'=>false, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
										?>
										<?php
											 $this->Js->get('#inventory-'.$detailVal['AcrInvoiceDetail']['id'])->event('change', $this->Js->request(array (
													'controller' => 'acr_client_invoices',
													'action' => 'calculateTotal',$detailVal['AcrInvoiceDetail']['id']
												), array (
													'update' => '#calculateFinal',
													'async' => true,
													'dataExpression' => true,
													'method' => 'post',
													'data' => $this->Js->serializeForm(array (
													'isForm' => false,
													'inline' => true
												))
											)));	
										?>
									</div>
									<div class="col-sm-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
										<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select"  data-toggle="modal" data-target="#addnewunittype-<?php echo $detailVal['AcrInvoiceDetail']['id']?>">
											<i class="icon-plus"></i>
										</div>
										
										
										
										
									</div>
								</div>
							</td>
							<td>
								<div class="form-group marginleftrightzero margin-bottom-zero">
									<?php echo $this->Form->input('AcrClientInvoice.description.'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'col-sm-12 tabletextarea','type'=>'textarea','rows'=>'2','placeholder'=>'Inventory description','value'=>$detailVal['AcrInvoiceDetail']['inventory_description']));?>
								</div>
							</td>
							<td>
								<div class="form-group marginleftrightzero margin-bottom-zero">
									<?php echo $this->Form->hidden('AcrClientInvoice.quantity_old.'.$detailVal['AcrInvoiceDetail']['id'],array('value'=>$detailVal['AcrInvoiceDetail']['quantity']));?>
									<?php echo $this->Form->input('AcrClientInvoice.quantity.'.$detailVal['AcrInvoiceDetail']['id'],array('id'=>'quantity-'.$detailVal['AcrInvoiceDetail']['id'],'div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control text-right','type'=>'text','value'=>$detailVal['AcrInvoiceDetail']['quantity']));
											   $this->Js->get('#quantity-'.$detailVal['AcrInvoiceDetail']['id'])->event('change', $this->Js->request(array (
												'controller' => 'acr_client_invoices',
												'action' => 'getLineTotal',$detailVal['AcrInvoiceDetail']['id']
											), array (
												'update' => '#lineTotal-'.$detailVal['AcrInvoiceDetail']['id'],
												'async' => false,
												'dataExpression' => true,
												'method' => 'post',
												'data' => $this->Js->serializeForm(array (
												'isForm' => false,
												'inline' => true
											))
										)));
									?>
									<?php
											 $this->Js->get('#quantity-'.$detailVal['AcrInvoiceDetail']['id'])->event('change', $this->Js->request(array (
													'controller' => 'acr_client_invoices',
													'action' => 'calculateTotal',$detailVal['AcrInvoiceDetail']['id']
												), array (
													'update' => '#calculateFinal',
													'async' => true,
													'dataExpression' => true,
													'method' => 'post',
													'data' => $this->Js->serializeForm(array (
													'isForm' => false,
													'inline' => true
												))
											)));	
										?>
									<label class="quotemeasurement"><?php echo $inventoryUnitType;?></label>
								</div>
							</td>
							<td>
								<div class="form-group marginleftrightzero margin-bottom-zero">
									<?php echo $this->Form->input('AcrClientInvoice.unit_rate.'.$detailVal['AcrInvoiceDetail']['id'],array('id'=>'rate-'.$detailVal['AcrInvoiceDetail']['id'],'div'=>false,'label'=>false,'class'=>'col-sm-10 form-control textright','type'=>'text','value'=>$detailVal['AcrInvoiceDetail']['unit_rate']));
												$this->Js->get('#rate-'.$detailVal['AcrInvoiceDetail']['id'])->event('change', $this->Js->request(array (
													'controller' => 'acr_client_invoices',
													'action' => 'getLineTotal',$detailVal['AcrInvoiceDetail']['id']
												), array (
													'update' => '#lineTotal-'.$detailVal['AcrInvoiceDetail']['id'],
													'async' => false,
													'dataExpression' => true,
													'method' => 'post',
													'data' => $this->Js->serializeForm(array (
													'isForm' => false,
													'inline' => true
												))
											)));
									?>
									<?php
											 $this->Js->get('#rate-'.$detailVal['AcrInvoiceDetail']['id'])->event('change', $this->Js->request(array (
													'controller' => 'acr_client_invoices',
													'action' => 'calculateTotal',$detailVal['AcrInvoiceDetail']['id']
												), array (
													'update' => '#calculateFinal',
													'async' => true,
													'dataExpression' => true,
													'method' => 'post',
													'data' => $this->Js->serializeForm(array (
													'isForm' => false,
													'inline' => true
												))
											)));	
										?>
								</div>
							</td>
							<td>
								<div class="form-group marginleftrightzero margin-bottom-zero">
									<?php echo $this->Form->input('AcrClientInvoice.discount_percent.'.$detailVal['AcrInvoiceDetail']['id'],array('id'=>'discount-'.$detailVal['AcrInvoiceDetail']['id'],'div'=>false,'label'=>false,'class'=>'col-sm-10 form-control black textright','type'=>'text','onkeyup'=>'this.value = minmax(this.value, 0, 100)','value'=>$detailVal['AcrInvoiceDetail']['discount_percent']));
												$this->Js->get('#discount-'.$detailVal['AcrInvoiceDetail']['id'])->event('change', $this->Js->request(array (
													'controller' => 'acr_client_invoices',
													'action' => 'getLineTotal',$detailVal['AcrInvoiceDetail']['id']
												), array (
													'update' => '#lineTotal-'.$detailVal['AcrInvoiceDetail']['id'],
													'async' => false,
													'dataExpression' => true,
													'method' => 'post',
													'data' => $this->Js->serializeForm(array (
													'isForm' => false,
													'inline' => true
												))
											)));
									?>
									<?php
											 $this->Js->get('#discount-'.$detailVal['AcrInvoiceDetail']['id'])->event('change', $this->Js->request(array (
													'controller' => 'acr_client_invoices',
													'action' => 'calculateTotal',$detailVal['AcrInvoiceDetail']['id']
												), array (
													'update' => '#calculateFinal',
													'async' => true,
													'dataExpression' => true,
													'method' => 'post',
													'data' => $this->Js->serializeForm(array (
													'isForm' => false,
													'inline' => true
												))
											)));	
										?>
								</div>
							</td>
							<td>
								<div class="form-group marginleftrightzero margin-bottom-zero">
									<div class="col-sm-12 marginleftrightzero paddingleftrightzero countrybilling choosen_width">
										<?php if($detailVal['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']){
													$defaultTaxId = $detailVal['SbsSubscriberTaxGroup']['group_name'].'-'.$detailVal['SbsSubscriberTaxGroup']['id'];
												}elseif($detailVal['AcrInvoiceDetail']['sbs_subscriber_tax_id']){
													$defaultTaxId = $detailVal['AcrInvoiceDetail']['sbs_subscriber_tax_id'];
												}else{
													$defaultTaxId = null;
												}?>
										<?php echo $this->Form->input('AcrClientInvoice.tax_inventory.'.$detailVal['AcrInvoiceDetail']['id'],array('id'=>'tax-'.$detailVal['AcrInvoiceDetail']['id'],'div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList),'default'=>$defaultTaxId));
													$this->Js->get('#tax-'.$detailVal['AcrInvoiceDetail']['id'])->event('change', $this->Js->request(array (
														'controller' => 'acr_client_invoices',
														'action' => 'calculateTotal',$detailVal['AcrInvoiceDetail']['id']
													), array (
														'update' => '#calculateFinal',
														'async' => true,
														'dataExpression' => true,
														'method' => 'post',
														'data' => $this->Js->serializeForm(array (
														'isForm' => false,
														'inline' => true
													))
												)));	
										
										?>
									</div>
								</div>
							</td>
							<td>
								<div class="form-group marginleftrightzero margin-bottom-zero" id = "lineTotal-<?php echo $detailVal['AcrInvoiceDetail']['id'];?>">
									<?php echo $this->Form->input('AcrClientInvoice.line_total.'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control textright black','type'=>'text','disabled'=>'disabled','value'=>$detailVal['AcrInvoiceDetail']['line_total']));?>
								</div>
							</td>
							<td class="textcenter">
								&nbsp;
								<?php 	
								echo $this -> Js -> link('<i style="color:#F00;" class="icon-trash bigger-120"></i>',
									array('controller' => 'acr_client_invoices', 'action' => 'deleteRow',$detailVal['AcrClientInvoice']['id'],$detailVal['AcrInvoiceDetail']['id']),
									array('id'=>'link-'.$detailVal['AcrInvoiceDetail']['id'],'class'=>'textdecoration_none deleteinvocerow','escape' => FALSE, 'update' => '#inventoryUpdateSelect-'.$detailVal['AcrInvoiceDetail']['id'],'title'=>'Delete Item','confirm'=>'Are you sure you want to remove this item?',
										'success'=>	$this->Js->request(array (
																								'controller' => 'acr_client_invoices',
																								'action' => 'calculateTotalAfterDelete',$detailVal['AcrInvoiceDetail']['id']
											 												), array (
																								'update' => '#calculateFinal',
																								'async' => false,
																								'dataExpression' => true,
																								'method' => 'post',
																								'data' => $this->Js->serializeForm(array (
																								'isForm' => false,
																								'inline' => true
																							))
																						))
									
									
									));
								?>
								
</td>
<script type="text/javascript" >
function minmax(value, min, max) 
	{
	    if(parseInt(value) < 0 || isNaN(value)) 
	        return 0; 
	    else if(parseInt(value) > 100) 
	        return 100; 
	    else return value;
	}

	$(document).ready(function() {
	var pquantityy = $('#quantity-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').val();
	var pdiscountt = $('#discount-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').val();
	var prate = $('#rate-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').val();
	
	
	$("input#quantity-<?php echo $detailVal['AcrInvoiceDetail']['id']?>").keypress(function(event) { return isNumber(event) });
	$("input#rate-<?php echo $detailVal['AcrInvoiceDetail']['id']?>").keypress(function(event) { return isNumber(event) });
	$("input#discount-<?php echo $detailVal['AcrInvoiceDetail']['id']?>").keypress(function(event) { return isNumber(event) });
	
	
	$('input#quantity-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').on('blur',function(e){
			if($('#quantity-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').val() === "") {
				alert("Field can't be empty.");
				$('#quantity-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').val(pquantityy);
			}
		});
		
			$('input#rate-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').on('blur',function(e){
			if($('#rate-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').val() === "") {
				alert("Field can't be empty.");
				$('#rate-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').val(prate);
			}
		});

		function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode != 45 && charCode != 8 && (charCode != 46 || $(this).val().indexOf('.') != -1) && 
                (charCode < 48 || charCode > 57)) {
            alert("Field must be numeric.");
            return false;
        	
    	} else {
    		return true;
    	} 
    	}
    	
		$(".chosen-select").chosen();
		if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 
	});
	</script>
</tr>
<!--Popup add  -->
<div class="modal fade" id="addnewunittype-<?php echo $detailVal['AcrInvoiceDetail']['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog addunittype">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title" id="myModalLabel"><?php echo __('Add Inventory');?></h1>
			</div>
			<?php /*echo $this->Form->create('addInventory',array('id'=>'addInventory','role'=>'form','class'=>'form-horizontal popup'));*/?>
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="addtype-wrapper">
							<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?><em style="color:#ff0000;">&lowast;</em> </label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.editName-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'col-xs-10 env-name'.$detailVal['AcrInvoiceDetail']['id'].' col-sm-5 form-control','type'=>'text','id'=>'orm-field-1','Placeholder'=>'Inventory name'));?>
						<p class="popup-error1">Please enter inventory name.</p>
						
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.editDescription-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'type'=>'textarea','rows'=>'2','class'=>'form-control col-xs-10 col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory'));?>
						
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?><em style="color:#ff0000;">&lowast;</em></label>
					<div class="col-sm-8">
						<span>
					    	<?php echo $this->Form->hidden('editCurrency-'.$detailVal['AcrInvoiceDetail']['id'],array('value'=>$defaultCurrency));?>
							<?php echo $this->Form->input('addInventory.editCode-'.$detailVal['AcrInvoiceDetail']['id'],array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'form-control width30 col-xs-10 col-sm-5','value'=>$defaultCurrencyCode,'readonly'=>'readonly'))?>
						</span>
						<span>
							<?php echo $this->Form->input('addInventory.editList_price-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 env-price'.$detailVal['AcrInvoiceDetail']['id'].' width70 col-sm-5 form-control','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
						</span>
						<p class="popup-error2">Please enter inventory price.</p>
						<p class="popup-error4">Only numbers allowed</p>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
					<div class="col-sm-8 choosen_width">
						<?php echo $this->Form->input('addInventory.editTax_inventory-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 invdrop form-control','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
					<div class="col-sm-8 choosen_width" id ="unit-type">
						<?php echo $this->Form->input('addInventory.editUnitType-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop form-control','data-placeholder'=>"Select Unit Type",'options'=>array(''=>'',$unitTypeList)));?>
					</div>
					
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
					<div class="col-sm-8">
						<label>
							<?php echo $this->Form->checkbox('addInventory.editTrack-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'ace checkBoxClick'));?>
							<span class="lbl"></span> </label>
						<label class="maillabel">Yes</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group currentstock" style="display: none;">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> </label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.editCurrent_stock-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control env-qty'.$detailVal['AcrInvoiceDetail']['id'].' col-xs-10 col-sm-5','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
						<p class="popup-error3">Please enter current Stock.</p>
					</div>
				</div>
						</div>
					</div>
				</div>
				<div class="modal-footer paddingright8">
					<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit-now','url' => array('controller'=>'inventories','action'=>'addInventory',$detailVal['AcrInvoiceDetail']['id']),'escape'=>false,'update' => '#td-inventoryUpdateSelect-'.$detailVal['AcrInvoiceDetail']['id']));?>
					
					<button class="btn close-popup btn-inverse" type="button">						
						Cancel
					</button>
					
					
					<script>
				$(document).ready(function(){
					$(".invdrop option:contains('|--')").remove();
					$('#addnewunittype-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').on('show.bs.modal', function (e) {
						
					  		$('.env-name<?php echo $detailVal['AcrInvoiceDetail']['id']?>, .env-price<?php echo $detailVal['AcrInvoiceDetail']['id']?>, .env-qty<?php echo $detailVal['AcrInvoiceDetail']['id']?>').val('');
					  		$('.currentstock').hide();
					  		$('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
					  		$('#addInventoryEditTrack-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').attr('checked', false); // Unchecks it
					  		
					  		
						});
						$( ".env-name<?php echo $detailVal['AcrInvoiceDetail']['id']?>, .env-price<?php echo $detailVal['AcrInvoiceDetail']['id']?>, .env-qty<?php echo $detailVal['AcrInvoiceDetail']['id']?>" ).focus(function() {
							$('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
						});
						
						$('.close-submit-now').click(function(evt){
					    	 
					    	 var value7 = $.trim($(".env-name<?php echo $detailVal['AcrInvoiceDetail']['id']?>").val());
					    	 if(value7.length === 0) {
					    	// if(value7.length === 0) {
					    	 	$('.popup-error1').show();
					    	 	evt.preventDefault();
						        $('#field').value();
					    	 }							
						   
						     var value9=$.trim($(".env-price<?php echo $detailVal['AcrInvoiceDetail']['id']?>").val());
					    	 if(value9.length === 0) {
					    	 	$('.popup-error2').show();
					    	 	evt.preventDefault();
						        $('#field').value();
					    	 }
					    	 var value9 = $.trim($(".env-price<?php echo $detailVal['AcrInvoiceDetail']['id']?>").val());
					    	 if(!$.isNumeric(value9)) {
						    	// if(value7.length === 0) {
						    	 	$('.popup-error4').show();
						    	 	evt.preventDefault();
							        $('#field').value();
						    	 }	
					    	 				    	 
					    	 
					    	 if ($('#addInventoryEditTrack-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').is(':checked')) {
					    	 var value10 = $.trim($(".env-qty<?php echo $detailVal['AcrInvoiceDetail']['id']?>").val());
					    	 if(value10.length === 0) {
					    	 	$('.popup-error3').show();
					    	 	evt.preventDefault();
						        $('#field').value();
					    	 }
					    	 }
					     	$('#addnewunittype-<?php echo $detailVal['AcrInvoiceDetail']['id']?>').modal('hide');
					    });
						});				
					</script>
					
					
					
				</div>
			<?php /*echo $this->form->end();*/?>
		</div>
	</div>
</div>
<!--end of pop-->
					<?php $randomIdStart = $detailVal['AcrInvoiceDetail']['id'] + 1;?>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
		<div class="row marginleftrightzero paddingbottom20">
			<div class="col-sm-8 no-padding-right no-padding-left paddingtop15">
				<div class="btn btn-sm btn-success pull-left addbutton addunitpadding add-row">
					<i class="icon-plus"></i>
				</div>
				<label class="addcontact">Add More</label>
			</div>
			<div class="col-sm-4 no-padding-right no-padding-left subtotal" id = "calculateFinal">
				<div class="row marginleftrightzero borderon">
					<div class="row marginleftrightzero">
						<span class="left bold"><?php echo __('Subtotal');?></span>
						<span class="right bold">
							<?php echo $this->Number->currency($detailVal['AcrClientInvoice']['sub_total'],$defaultCurrencyCode);?>
							<?php echo $this->Form->hidden('AcrClientInvoice.subTotal',array('value'=>$invoiceData['AcrClientInvoice']['sub_total']))?>
						</span>
					</div>
					<?php foreach($taxArray as $key=>$val):?>
						<div class="row marginleftrightzero ">
							<span class="left"><?php echo $val['taxName'];?></span>
							<span class="right">
								<?php echo $this->Number->currency($val['taxAmount'],$defaultCurrencyCode);?>
								<?php echo $this->Form->hidden('AcrClientInvoice.taxValue.'.$key,array('value'=>$val['taxAmount']))?>
							</span>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="row marginleftrightzero borderon">
					<div class="row marginleftrightzero">
						<span class="left bold">Total</span>
					</div>
					<div class="row marginleftrightzero">
						<span class="left">In Invoice Currency</span>
						<span class="right bold statusopn"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code']);?></span>
						<?php echo $this->Form->hidden('AcrClientInvoice.invoicetotal',array('value'=>$invoiceData['AcrClientInvoice']['invoice_total']))?>
					</div>
				</div>
				<div class="row marginleftrightzero ">
					<div class="row marginleftrightzero">
						<span class="left bold">Total</span>
					</div>
					<div class="row marginleftrightzero">
						<span class="left">In Subscriber Currency</span>
						<span class="right  bold statusopn"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['func_currency_total'],$defaultCurrencyCode);?></span>
						<?php echo $this->Form->hidden('AcrClientInvoice.subscribertotal',array('value'=>$invoiceData['AcrClientInvoice']['func_currency_total']))?>
					</div>
				</div>
			</div>
		</div>
		<div class="row marginleftrightzero borderblue"></div>
		<div class="row marginleftrightzero paddingbottom20 paddingtop25">
			<div class="row marginleftrightzero">
				<div class="form-group marginleftrightzero">
					<label  class="col-sm-2 control-label marginleftrightzero paddingleftrightzero">Terms and Conditions</label>
					<div class="col-sm-10 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->input('terms',array('div'=>false,'label'=>false,'class'=>'termsandconditions','type'=>'textarea','value'=>$invoiceData['AcrClientInvoice']['term_conditions']))?>
					</div>
				</div>
			</div>
			<div class="row marginleftrightzero">
				<div class="form-group marginleftrightzero">
					<label  class="col-sm-2 control-label marginleftrightzero paddingleftrightzero">Customer Note</label>
					<div class="col-sm-10 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->input('note',array('div'=>false,'label'=>false,'class'=>'termsandconditions','type'=>'textarea','value'=>$invoiceData['AcrClientInvoice']['notes']))?>
					</div>
				</div>
			</div>
		</div>
		<?php if($getCustomFields):?>
		<div class="row marginleftrightzero paddingbottom20">
			<div class="row marginleftrightzero additionalinfo paddingbottom10">
				<h5><?php echo __('Additional Information');?></h5>
			</div>
			<div class="row marginleftrightzero">
				<?php foreach($getCustomFields as $fieldId=>$fieldVal):?>
					<div class="form-group marginleftrightzero paddingtop15">
						<label  class="col-sm-2 control-label marginleftrightzero paddingleftrightzero"><?php echo $fieldVal;?></label>
						<div class="col-sm-4 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('AcrClientInvoice.customField.'.$fieldId,array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'text','placeholder'=>$fieldVal,'value'=>$getCustomFieldsVal[$fieldId]));?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
		<div class="row marginleftrightzero paddingbottom20">
			<div class="clearfix form-actions margintopzero paddingtopzero no-padding-left no-padding-right">
				<div class="col-md-offset-3 col-md-6">
					<?php /*echo  $this->Form->button(__('<i class="icon-share-alt bigger-110"></i> Send Now'),array('url'=>array('controller'=>'acr_client_invoices','action'=>'edit',$detailVal['AcrInvoiceDetail']['id']),'div'=>false,'class' => 'btn btn-info','name'=>'Send Now','value'=>'1'));*/?>
					<!--button class="btn btn-info" title="Mail" data-toggle="modal" data-target="#mail">
						<i class="icon-share-alt bigger-110"></i> Send Now
					</button-->
	        			<?php echo  $this->Form->button(__('<i class="icon-save bigger-110"></i> Save Recurring Invoice'),array('url'=>array('controller'=>'acr_client_recurring_invoices','action'=>'edit',$detailVal['AcrInvoiceDetail']['id']),'div'=>false,'class' => 'btn btn-info saveQuote','name'=>'Save Invoice','value'=>'1'));?>
					
					<div class="btn btn-inverse anchaorcolor">
						<?php echo $this->Html->link('<i class="icon-remove bigger-110"></i> Cancel',array('action'=>'index'),array('escape'=>FALSE));?>
					</div>
				</div>
			</div>
		</div>
		<!--Popup mail items  -->
		<div class="modal fade" id="mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog model-quotes">
					 <div class="modal-content">
						 <div class="modal-header page-header">
							 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
								  <h1 class="modal-title bold" id="myModalLabel"><?php echo __('Send Invoice');?></h1>
						 </div>
						 <?php /*echo $this->Form->create('MailTemplate',array('class'=>'form-horizontal popup','role'=>'form','id'=>'MailTemplate'));*/?>
							<div class="modal-body">
								<div class="model-body-inner-content">
								    <div class="form-group login-form-group">
								         <p><?php echo __('Please select the Template to continue');?></p>
								    </div>
								    <div class="form-group filed-left margin-bottom-zero drop-down">
								    	<?php echo $this->Form->input('template',array('div'=>false,'label'=>false,'class'=>'chosen-select','data-placeholder'=>'Email Template','options'=>array('sent_invoice'=>'Classic Product Template','sent_invoice_modern'=>'Modern Product Template','sent_invoice_service_classic'=>'Classic Service Template','sent_invoice_service_modern'=>'Modern Service Template')));?>
								    </div>
								 </div>
							</div>
							<div class="modal-footer">
								 <!--button class="btn btn-success addbutton left marginleftzero marginright14" type="button"> <i class="icon-zoom-in bigger-110"></i> Preview </button-->
								  <?php echo  $this->Form->button(__('<i class="icon-share-alt bigger-110"></i> Send Now'),array('url'=>array('controller'=>'acr_client_recurring_invoices','action'=>'edit',$detailVal['AcrInvoiceDetail']['id']),'div'=>false,'class' => 'btn btn-info','name'=>'Send Now','value'=>'1'));?>
								  <button class="btn left marginleftzero popup-cancel" type="button"> <i class="icon-remove bigger-110"></i> Cancel </button>
							</div>
					</div>
			</div>
		</div>
<!--end of pop--> 
	<?php echo $this->Form->end(); ?>
</div>

<!-- inline scripts related to this page -->
<script type="text/javascript" >
$('body').on('click','.checkBoxClick',function(){
			
	if($('.checkBoxClick').is(":checked"))
	{
		
		$('.currentstock').show();
	}
	else{
		$('.currentstock').hide();
	}
});
	$(document).ready(function() {
        if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 
		$('#start-date').change(function(){
        	$(this).valid()
		});
		$("#AcrClientInvoiceEditForm").validate({
			ignore:[],
			rules : {
				'data[AcrClientInvoice][recurring_invoice_no]' : {
					required : true
				},
				'data[AcrClientInvoice][acr_client_id]' : {
					required : true
				},
				'data[AcrClientInvoice][sbs_subscriber_payment_term_id]' : {
					required : true
				},
				'data[AcrClientInvoice][recurring_period]' : {
					required : true
				},
				'data[AcrClientInvoice][conversionValue]':{
					required : true,
					number	 : true
				},
				'data[AcrClientInvoice][recurring_frequency]':{
					required : true,
					number	 : true
				},
				'data[AcrClientInvoice][start_date]' : {
					required : true
				},
				'data[AcrClientInvoice][end_date]' : {
					required : true
				}
			},
			messages : {
				'data[AcrClientInvoice][recurring_invoice_no]' : {
					required : 'Please enter invoice number.',
					number : 'Invoice number should be numeric'
				},
				'data[AcrClientInvoice][acr_client_id]' : {
					required : 'Please select a client.'
				},
				'data[AcrClientInvoice][sbs_subscriber_payment_term_id]' : {
					required : 'Please select a payment term.'
				},
				'data[AcrClientInvoice][recurring_period]' : {
					required : 'Please select a recurring period.'
				},
				'data[AcrClientInvoice][conversionValue]':{
					required : 'Please enter a conversion value.',
					number   : 'Conversion value should be numeric.'
				},
				'data[AcrClientInvoice][recurring_frequency]':{
					required : 'Please enter a frequency',
					number	 : 'Frequency should be numeric.'
				},
				'data[AcrClientInvoice][start_date]' : {
					required : 'Please select a start date.'
				},
				'data[AcrClientInvoice][end_date]' : {
					required : 'Please select a end date.'
				},
			}
		});

		$('.date-picker').datepicker({
			autoclose : true

		}).next().on(ace.click_event, function() {
			$(this).prev().focus();
		});

	}); 
</script>
<script type="text/javascript">
$(function() {
	$( "#clientId" ).change(function() {
		$('.labelerror .error').hide();
	});

	var config = {
	  '#clientId' : {search_contains:true},
	  '.invdrop' : {search_contains:true}
	}
	for (var selector in config) {
	  $(selector).chosen(config[selector]);
	}
});

	$(document).ready(function(){
	$('.close-popup').click(function(){
		$('.close').trigger('click');
	});
	
	
	$('.close-submit').click(function(){
     	$('.close').trigger('click');
     	//$('.form-control').val('');
     	$( "#addInventoryTrack" ).prop( "checked", false );
    });
    
    
var rowcount='<?php echo $randomIdStart;?>';
$('body').on('click','.addcontact',function(){
$( ".add-row" ).trigger( "click" );
});
$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
$(this).prev().focus();
});



$('body').on('click','.add-row',function(){
	
var d = new Date();
var n = d.getTime();

$.ajax({
		type: "POST",
		dataType: 'html',
		cache: false,
		url: "<?php echo $this->webroot; ?>acr_client_invoices/addmore?rowcount="+rowcount,
		data: {
			rowcount: rowcount,
		},
		success: function (data) {               
                  $('#quote-table tbody').append(data).fadeIn('slow');
        }
	})
    rowcount++;
});

$('body').on('click','.remove-row',function(){
$(this).parents('tr').remove();
rowcount--;
});
});
var goup;
$scrollup=function(){	
     var scrollHeight=$('.error:visible:first').css('top');
	 $('html, body').animate({scrollTop: scrollHeight}, "slow");
	 if($('.error').length>0){
	  clearInterval(goup);
     }			 
	}
	$(document).ready(function(){
	$('body').on('click','.saveQuote',function(){
	   goup =setInterval( $scrollup,1);
	  });
	});
</script>

<?php echo $this->Js->writeBuffer();?>
