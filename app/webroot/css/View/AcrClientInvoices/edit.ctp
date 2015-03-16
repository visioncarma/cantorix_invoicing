<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
?>
<?php $this->CurrencySymbol->getAllCurrencies();?>
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
			<?php echo $this->Html->link('Invoices', array('controller' => 'acr_client_invoices', 'action' => 'index'), array('div' => false,'escape' => false)); ?>
		</li>
		<li class="active">
			<?php echo __('Edit Invoice');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 > <?php echo __('Edit Invoice');?> </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
		</div>

	</div>
	<!-- /.page-header -->
	<?php echo $this->Form->create('AcrClientInvoice',array('class'=>'form-horizontal formdetails','role'=>'form'));?>
		<?php echo $this->Form->hidden('invoiceId',array('value'=>$invoiceData['AcrClientInvoice']['id']));?>
		<div class="row marginleftrightzero">
			<div class="col-lg-8 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Invoice No');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero" id = "invoiceNumber">
							<?php echo $this->Form->input('invoice_number',array('id'=>'invNumber','div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','placeholder'=>'Invoice no.','value'=>$invoiceData['AcrClientInvoice']['invoice_number']));
										 $this->Js->get('#invNumber')->event('keyup',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'invoiceNumberExist'), array( 'update'=>'#invoiceNumber', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
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
					<div class="form-group marginleftrightzero relative">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Customer');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero labelerror">
							
							<?php echo $this->Form->input('acr_client_id',array('id'=>'clientId','div'=>false,'label'=>false,'options'=>array(''=>'Select Customer',$customer),'class'=>'selectpicker form-control','data-placeholder'=>"Customer List",'default'=>$invoiceData['AcrClientInvoice']['acr_client_id']));
									   $this->Js->get('#clientId')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'customerInfo'), array( 'update'=>'#customerInfo', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
							?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group  marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Currency');?></label>
						<div class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('cpn_currency_id',array('id'=>'invoiceCurrencySelect','div'=>false,'label'=>false,'options'=>array(''=>'Select Currency',$currencyList),'default'=>$defaultCurrency,'class'=>'form-control selectpicker','default'=>$invoicedCurrency));
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
						<div class="col-xs-12 col-sm-2 col-lg-2  paddingleftrightzero">
							<sapn class="conversion">
								<?php echo $this->Form->hidden('defaultCurrencyId',array('value'=>$defaultCurrency));?>
								<?php echo '1 '.$defaultCurrencyCode;?>
							</sapn>
						</div>
						<div class="col-xs-12 col-sm-1 col-lg-2 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('conversionValue',array('id'=>'conversionValue','div'=>false,'label'=>false,'type'=>'text','class'=>'form-control specialborder','placeholder'=>'Enter conversion value','value'=>$invoiceData['AcrClientInvoice']['exchange_rate']));
										 $this->Js->get('#conversionValue')->event('keyup', $this->Js->request(array (
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
							<sapn class="conversion" id ="invoiceCurrency">
								<?php echo $invoiceData['AcrClientInvoice']['invoice_currency_code'];?>
							</sapn>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Issue Date');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker">
								<?php echo $this->Form->input('AcrClientInvoice.invoiced_date',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control date-picker','data-date-format'=>'dd-mm-yyyy','readonly'=>'readonly','value'=>date('M d,Y',strtotime($invoiceData['AcrClientInvoice']['invoiced_date']))))?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Terms');?></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('sbs_subscriber_payment_term_id',array('id'=>'paymentTems','div'=>false,'label'=>false,'options'=>array(''=>'Select Term',$paymentTerm),'class'=>'form-control selectpicker','data-placeholder'=>"Select term",'default'=>$invoiceData['AcrClientInvoice']['sbs_subscriber_payment_term_id']));
										$this->Js->get('#paymentTems')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'findEndDate'), array( 'update'=>'#dueDateUpdate', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
							?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero" >
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Expiry Date');?></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero" id ="dueDateUpdate">
						<?php if($invoiceData['AcrClientInvoice']['due_date']){
							echo $this->Form->input('due_date',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','disabled'=>'disabled','value'=>date('M d,Y',strtotime($invoiceData['AcrClientInvoice']['due_date']))));
						}else{
							echo $this->Form->input('due_date',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','disabled'=>'disabled','value'=>date($dateFormat,strtotime(date('Y-m-d')))));
						}?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 no-padding-right  no-padding-left" id ="customerInfo">
				<div class="widget-box">
					<div class="widget-header">
						<h5><?php echo __('Invoice email to');?></h5>
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
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left " >
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
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left " >
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
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left " >
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
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left " >
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
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left " >
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
						<th class="width120"><?php echo __('Qty');?></th>
						<th class="width120"><?php echo __('Unit Price');?></th>
						<th class="width120"><?php echo __('Discount %');?></th>
						<th class="width150"><?php echo __('Tax');?></th>
						<th class="width150"><?php echo __('Amount');?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($invoiceDetail as $detailKey => $detailVal):?>
					<?php echo $this->Form->hidden('AcrClientInvoice.inventory_Old.'.$detailVal['AcrInvoiceDetail']['id'],array('value'=>$detailVal['AcrInvoiceDetail']['id']));?>
					<tr id ="inventoryUpdateSelect-<?php echo $detailVal['AcrInvoiceDetail']['id']?>">
							<td id = "td-inventoryUpdateSelect-<?php echo $detailVal['AcrInvoiceDetail']['id'];?>">
								<div class="form-group  marginleftrightzero margin-bottom-zero">
									<div class="col-sm-10 marginleftrightzero paddingleftrightzero ">
										
										<?php echo $this->Form->input('AcrClientInvoice.inventory.'.$detailVal['AcrInvoiceDetail']['id'],array('id'=>'inventory-'.$detailVal['AcrInvoiceDetail']['id'],'div'=>false,'label'=>false,'class'=>'selectpicker form-control','options'=>array(''=>'Select inventory','-1'=>'Non Inventory Item',$inventoryList),'default'=>$detailVal['AcrInvoiceDetail']['inv_inventory_id']));
													$this->Js->get('#inventory-'.$detailVal['AcrInvoiceDetail']['id'])->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'getInventoryDetails',$detailVal['AcrInvoiceDetail']['id']), array( 'update'=>'#inventoryUpdateSelect-'.$detailVal['AcrInvoiceDetail']['id'], 'async'=>false, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
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
									<?php echo $this->Form->input('AcrClientInvoice.description.'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'col-sm-12 tabletextarea','type'=>'textarea','rows'=>'3','placeholder'=>'Inventory description','value'=>$detailVal['InvInventory']['description']));?>
								</div>
							</td>
							<td>
								<div class="form-group marginleftrightzero margin-bottom-zero">
									<?php echo $this->Form->hidden('AcrClientInvoice.quantity_old.'.$detailVal['AcrInvoiceDetail']['id'],array('value'=>$detailVal['AcrInvoiceDetail']['quantity']));?>
									<?php echo $this->Form->input('AcrClientInvoice.quantity.'.$detailVal['AcrInvoiceDetail']['id'],array('id'=>'quantity-'.$detailVal['AcrInvoiceDetail']['id'],'div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'number','value'=>$detailVal['AcrInvoiceDetail']['quantity']));
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
									<?php echo $this->Form->input('AcrClientInvoice.unit_rate.'.$detailVal['AcrInvoiceDetail']['id'],array('id'=>'rate-'.$detailVal['AcrInvoiceDetail']['id'],'div'=>false,'label'=>false,'class'=>'col-sm-10 form-control','type'=>'text','value'=>$detailVal['AcrInvoiceDetail']['unit_rate']));
												$this->Js->get('#rate-'.$detailVal['AcrInvoiceDetail']['id'])->event('keyup', $this->Js->request(array (
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
											 $this->Js->get('#rate-'.$detailVal['AcrInvoiceDetail']['id'])->event('keyup', $this->Js->request(array (
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
									<?php echo $this->Form->input('AcrClientInvoice.discount_percent.'.$detailVal['AcrInvoiceDetail']['id'],array('id'=>'discount-'.$detailVal['AcrInvoiceDetail']['id'],'div'=>false,'label'=>false,'class'=>'col-sm-10 form-control','type'=>'float','max'=>"100", 'value'=>$detailVal['AcrInvoiceDetail']['discount_percent']));
												$this->Js->get('#discount-'.$detailVal['AcrInvoiceDetail']['id'])->event('keyup', $this->Js->request(array (
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
											 $this->Js->get('#discount-'.$detailVal['AcrInvoiceDetail']['id'])->event('keyup', $this->Js->request(array (
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
									<div class="col-sm-12 marginleftrightzero paddingleftrightzero countrybilling">
										<?php if($detailVal['AcrInvoiceDetail']['sbs_subscriber_tax_group_id']){
													$defaultTaxId = $detailVal['SbsSubscriberTaxGroup']['group_name'].'-'.$detailVal['SbsSubscriberTaxGroup']['id'];
												}elseif($detailVal['AcrInvoiceDetail']['sbs_subscriber_tax_id']){
													$defaultTaxId = $detailVal['AcrInvoiceDetail']['sbs_subscriber_tax_id'];
												}else{
													$defaultTaxId = null;
												}?>
										<?php echo $this->Form->input('AcrClientInvoice.tax_inventory.'.$detailVal['AcrInvoiceDetail']['id'],array('id'=>'tax-'.$detailVal['AcrInvoiceDetail']['id'],'div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control selectpicker','options'=>array(''=>'Select Tax',$taxList),'default'=>$defaultTaxId));
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
									<?php echo $this->Form->input('AcrClientInvoice.line_total.'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','disabled'=>'disabled','value'=>$detailVal['AcrInvoiceDetail']['line_total']));?>
								</div>
							</td>
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
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> </label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.name',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','id'=>'orm-field-1','autocomplete'=>'off','Placeholder'=>'Inventory name'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.description',array('div'=>false,'label'=>false,'type'=>'textarea','class'=>'form-control col-xs-10 col-sm-5 itemdescription','id'=>'form-field-2','autocomplete'=>'off','Placeholder'=>'Description of the inventory'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?></label>
					<div class="col-sm-8">
						<span>
					    	<?php echo $this->Form->hidden('currency',array('value'=>$defaultCurrency));?>
							<?php echo $this->Form->input('addInventory.code',array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'form-control width30 col-xs-10 col-sm-5','value'=>$defaultCurrencyCode,'readonly'=>'readonly'))?>
						</span>
						<span>
							<?php echo $this->Form->input('addInventory.list_price',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 width70 col-sm-5 form-control','autocomplete'=>'off','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
						</span>
						
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.tax_inventory',array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 selectpicker ','options'=>array(''=>'Select Tax',$taxList)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
					<div class="col-sm-8" id ="unit-type">
						<?php echo $this->Form->input('addInventory.unitType',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control selectpicker','options'=>array(''=>'Select Unit Type',$unitTypeList)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
					<div class="col-sm-8">
						<label>
							<?php echo $this->Form->checkbox('addInventory.track',array('div'=>false,'label'=>false,'class'=>'ace'));?>
							<span class="lbl"></span> </label>
						<label class="maillabel">Yes</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> </label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.current_stock',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control col-xs-10 col-sm-5','id'=>'form-field-4','autocomplete'=>'off','Placeholder'=>'Quantity of inventory  in stock'));?>
					</div>
				</div>
						</div>
					</div>
				</div>
				<div class="modal-footer paddingright8">
					<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit2','url' => array('controller'=>'inventories','action'=>'addInventory',$detailVal['AcrInvoiceDetail']['id']),'escape'=>false,'update' => '#td-inventoryUpdateSelect-'.$detailVal['AcrInvoiceDetail']['id']));?>
					<button class="btn close-popup btn-inverse" type="button">
						Cancel
					</button>
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
							<?php $options = array('zero'=>'0.00','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before')?>
							<?php echo $this->Number->currency($detailVal['AcrClientInvoice']['sub_total'],$defaultCurrencyCode,$options);?>
							<?php echo $this->Form->hidden('AcrClientInvoice.subTotal',array('value'=>$invoiceData['AcrClientInvoice']['sub_total']))?>
						</span>
					</div>
					<?php foreach($taxArray as $key=>$val):?>
						<div class="row marginleftrightzero ">
							<span class="left"><?php echo $val['taxName'];?></span>
							<span class="right">
								<?php echo $this->Number->currency($val['taxAmount'],$defaultCurrencyCode,$options);?>
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
						<span class="right bold statusopn"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code'],$options);?></span>
						<?php echo $this->Form->hidden('AcrClientInvoice.invoicetotal',array('value'=>$invoiceData['AcrClientInvoice']['invoice_total']))?>
					</div>
				</div>
				<div class="row marginleftrightzero ">
					<div class="row marginleftrightzero">
						<span class="left bold">Total</span>
					</div>
					<div class="row marginleftrightzero">
						<span class="left">In Subscriber Currency</span>
						<span class="right  bold statusopn"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['func_currency_total'],$defaultCurrencyCode,$options);?></span>
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
					<button class="btn btn-info" title="Mail" data-toggle="modal" data-target="#mail">
						<i class="icon-share-alt bigger-110"></i> Send Now
					</button>
	        			<?php echo  $this->Form->button(__('<i class="icon-save bigger-110"></i> Save Invoice'),array('url'=>array('controller'=>'acr_client_invoices','action'=>'edit',$detailVal['AcrInvoiceDetail']['id']),'div'=>false,'class' => 'btn btn-info','name'=>'Save Invoice','value'=>'1'));?>
						
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
						<div class="form-horizontal popup">	
							<div class="modal-body">
								<div class="model-body-inner-content">
								    <div class="form-group login-form-group">
								         <p><?php echo __('Please select the Template to continue');?></p>
								    </div>
								    <div class="form-group filed-left margin-bottom-zero drop-down">
								    	<?php echo $this->Form->input('template',array('div'=>false,'label'=>false,'class'=>'form-control selectpicker','data-placeholder'=>'Email Template','options'=>array('sent_invoice'=>'Classic Product Template','sent_invoice_modern'=>'Modern Product Template','sent_invoice_service_classic'=>'Classic Service Template','sent_invoice_service_modern'=>'Modern Service Template')));?>
								    </div>
								 </div>
							</div>
							<div class="modal-footer">
								 <!--button class="btn btn-success addbutton left marginleftzero marginright14" type="button"> <i class="icon-zoom-in bigger-110"></i> Preview </button-->
								  <?php echo  $this->Form->button(__('<i class="icon-share-alt bigger-110"></i> Send Now'),array('url'=>array('controller'=>'acr_client_invoices','action'=>'edit',$detailVal['AcrInvoiceDetail']['id']),'div'=>false,'class' => 'btn btn-info left marginleftzero marginright4 padding0 close-submit','name'=>'Send Now','value'=>'1'));?>
								  <button class="btn btn-success addbutton left marginleftzero  marginright4 padding0 sendnow" title="Send Now" data-toggle="modal" data-target="#preview">
									<i class="icon-zoom-in bigger-110"></i> Preview
				 				  </button> 
				 				  <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright4 padding0','url' => array('controller'=>'AcrClientInvoices','action'=>'preview'),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'));?>
								  <button class="btn left marginleftzero popup-cancel marginright4 padding0" type="button"> <i class="icon-remove bigger-110"></i> Cancel </button>
							</div>
						</div>	
					</div>
			</div>
		</div>
<!--end of pop--> 
	<?php echo $this->Form->end(); ?>
</div>
<!--Popup preview items  -->
<div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div id="preview-template" class="modal-dialog model-quotes">
		
	</div>
</div>
<!--end of pop-->
<!-- inline scripts related to this page -->
<script type="text/javascript" >
	$(document).ready(function() {
		if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 
		$('.close-popup').click(function(){
		  $('.close').trigger('click');
	    });	 
	    $('.close-submit').click(function(){
	     	$('#addnewunittype-317').modal('hide');
	    });  
	    
	    $('.close-submit2').click(function(){
	     	$('#addnewunittype-318').modal('hide');
	    });
	    
		$('.sendnow').click(function(){
			$('.previewpopup').trigger('click')
		});
		$("#AcrClientInvoiceEditForm").validate({
			ignore: [],
			rules : {
				'data[AcrClientInvoice][invoice_number]' : {
					required : true
				},
				'data[AcrClientInvoice][acr_client_id]' : {
					required : true
				},
				'data[AcrClientInvoice][invoiced_date]' : {
					required : true
				},
				'data[AcrClientInvoice][sbs_subscriber_payment_term_id]':{
					required : true
				},
				'data[AcrClientInvoice][conversionValue]':{
					required : true,
					number	 : true
				},
				'data[AcrClientInvoice][invoice_number]':{
					required : true
				}
			},
			messages : {
				'data[AcrClientInvoice][name]' : {
					required : 'Please enter invoice number.',
					number : 'Invoice number should be numeric'
				},
				'data[AcrClientInvoice][acr_client_id]' : {
					required : 'Please select a customer.'
				},
				'data[AcrClientInvoice][invoiced_date]' : {
					required : 'Please enter invoice date.'
				},
				'data[AcrClientInvoice][sbs_subscriber_payment_term_id]':{
					required : 'Please select a payment term.'
				},
				'data[AcrClientInvoice][conversionValue]':{
					required : 'Please enter a conversion value.',
					number   : 'Conversion value should be numeric.'
				},
				'data[AcrClientInvoice][invoice_number]':{
					required : 'Please enter a invoice number.'
				}
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
	$(document).ready(function(){
	
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
</script>

<?php echo $this->Js->writeBuffer();?>
