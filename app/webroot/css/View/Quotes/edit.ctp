<?php echo $this -> Session -> flash(); ?>
<?php $homeLink = $this -> Breadcrumb -> getLink('Home'); ?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<ul class="breadcrumb">
		<li>
			<?php echo $this -> Html -> link('<i class="icon-home home-icon"></i>Home', "$homeLink", array('escape' => FALSE,'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false)))); ?>
		</li>
		<li>
			<?php echo $this -> Html -> link('Quotes', array('action' => 'index')); ?>
		</li>
		<li class="active">
			Edit Quote
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 > Edit Quotes </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i> Back', array('action' => 'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page), array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right addbutton')); ?>
		</div>
	</div>
	<!-- /.page-header -->
	<?php echo $this->Form->create('AcrClientInvoice',array('id'=>'SlsQuotation','url'=>array('controller'=>'quotes','action'=>'edit',$subscriberID,$id,$customer, $min, $max, $status, $from, $to, $page),'class'=>'form-horizontal formdetails','role'=>'form','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control')));?>
		<div class="row marginleftrightzero">
			<div class="col-lg-8 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Quotes No<em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('quote_no',array('placeholder'=>'Quote No','value'=>$quote['SlsQuotation']['quotation_no'],'id'=>'form-field-1'));?>
							<label for="form-field-1" class="error"></label>
							<?php echo $this->Form->input('id',array('value'=>$quote['SlsQuotation']['id']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Purchase Order No.#</label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('purchase_order_no',array('placeholder'=>'Purchase order no','value'=>$quote['SlsQuotation']['purchase_order_no']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Quote Description</label>
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('quote_description',array('placeholder'=>'Description','value'=>$quote['SlsQuotation']['description']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Customer<em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero labelerror">
							<?php echo $this->Form->input('acr_client_id',array('id'=>'customerID','class'=>'selectpicker form-control selectitem','data-placeholder'=>'Customers','options'=>array(''=>'Customer',$customers),'default'=>$quote['SlsQuotation']['acr_client_id']));?>
							
						</div>
						<?php $this->Js->get('#customerID')->event('change',$this->Js->request(array('action'=>'customerDetails'), array( 'update'=>"#updateCustomerDetail", 'async'=>true, 'dataExpression'=>true, 'method'=>'post',
	              					'data'=>$this->Js->serializeForm(array('isForm'=>true,'inline'=>true))
							)));?>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Currency</label>
						<div class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('cpn_currency_id',array('id'=>'currencySelect','options'=>array(''=>'Select Currency',$currencyList),'default'=>$subscriberCurrencyIDD,'class'=>'selectpicker form-control','data-placeholder'=>"Currency List"));
								$this->Js->get('#currencySelect')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'currencyInfo'), array( 'update'=>'#invoiceCurrency', 'async'=>true, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>true,'inline'=>true)))));
								
								$this->Js->get('#currencySelect')->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',1), array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,
										'method' => 'post',
										'data' => $this->Js->serializeForm(array (
										'isForm' => false,
										'inline' => true
									))
								)));
							?>
						</div>
						<div class="col-xs-12 col-sm-3 col-lg-2  paddingleftrightzero">
							<sapn class="conversion">
								<?php echo $this -> Form -> hidden('defaultCurrencyId', array('value' => $defaultCurrency)); ?>
								<?php echo '1 '.$defaultCurrencyCode.' =';?>
								<?php echo $this -> Form -> hidden('defaultCurrencyCodee', array('value' => $defaultCurrencyCode)); ?>
							</sapn>
						</div>
						<div class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('conversionValue',array('maxlength'=>4,'id'=>'conversionValue','class'=>'form-control specialborder','placeholder'=>'Conversion Rate','value'=>$quote['SlsQuotation']['exchange_rate']));?>
							<?php $this->Js->get('#conversionValue')->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',1), array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,
										'method' => 'post',
										'data' => $this->Js->serializeForm(array (
										'isForm' => false,
										'inline' => true
									))
								)));?>
						</div>
						<div class="col-xs-12 col-sm-3 col-lg-1 marginleftrightzero paddingleftrightzero">
							<span class="conversion" id="invoiceCurrency">
								<?php echo $quote['SlsQuotation']['invoice_currency_code'];?>
								<?php echo $this -> Form -> hidden('invoice_currency_code', array('value' => $quote['SlsQuotation']['invoice_currency_code'])); ?>
							</span>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Issue Date<em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							
							 <div class="input-group custom-datepicker">
								<?php echo $this->Form->input('issueDate',array('div'=>false,'class'=>'form-control date-picker','data-date-format'=>str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format']),'default'=>date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['issue_date']))));?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div> 
							
							
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Expiry Date</label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker">
								<?php
									if(!empty($quote['SlsQuotation']['expiry_date'])) {
										echo $this->Form->input('expiryDate',array('class'=>'form-control date-picker','data-date-format'=>str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format']),'default'=>date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['expiry_date']))));
									} else {
										echo $this->Form->input('expiryDate',array('class'=>'form-control date-picker','data-date-format'=>str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format'])));
									}
									
								?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="updateCustomerDetail" class="col-lg-4 no-padding-right  no-padding-left">
				<div class="widget-box">
					<div class="widget-header">
						<h5>Quote email to</h5>
					</div>

					<div class="widget-body">
						<div class="widget-main paddingleftrightzero">
							<div class="form-horizontal">
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												Contact Name
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php echo $customerDetails['AcrClientContact']['name'];?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												Contact Surname
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php echo $customerDetails['AcrClientContact']['sur_name'];?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												Contact Email
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php echo $customerDetails['AcrClientContact']['email'];?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												Mobile
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php echo $customerDetails['AcrClientContact']['mobile'];?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group  marginleftrightzero borderline">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												Home Phone
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php echo $customerDetails['AcrClientContact']['home_phone'];?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group  marginleftrightzero lastrow">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-5 control-label no-padding-right  " >
												Work Phone
											</div>
											<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
												<?php echo $customerDetails['AcrClientContact']['work_phone'];?>
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
						<th class="width180">Item</th>
						<th class="width300">Item Description</th>
						<th class="width120">Qty</th>
						<th class="width120">Unit Price</th>
						<th class="width120">Discount %</th>
						<th class="width150">Tax</th>
						<th class="width150">Amount</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach($quoteProducts as $product):
						$i++;
						
						?>
					<tr id ="inventoryUpdateSelect-<?php echo $i;?>">
						<td id = "td-inventoryUpdateSelect-<?php echo $i;?>">
						<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
							<div class="col-sm-10 marginleftrightzero paddingleftrightzero countrybilling">
								<?php echo $this -> Form -> input('AcrClientInvoice.inventory.'.$i, array('default'=>$product['SlsQuotationProduct']['inv_inventory_id'],'id' => 'inventory-'.$i, 'div' => false, 'label' => false, 'class'=>'selectpicker form-control','options' => array('' => 'Select inventory','-1'=>'Non Inventory Item', $inventoryList)));
							$this -> Js -> get('#inventory-'.$i) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getInventoryDetails', $i), array('update' => '#inventoryUpdateSelect-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
							?>
							<?php
									 $this->Js->get('#inventory-'.$i)->event('change', $this->Js->request(array (
											'controller' => 'acr_client_invoices',
											'action' => 'calculateTotal',$i
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
							<?php echo $this -> Form -> hidden('AcrClientInvoice.line_total_hidden.'.$i,array('value'=>$product['SlsQuotationProduct']['line_total']));
							echo $this -> Form -> hidden('AcrClientInvoice.product_id.'.$i,array('value'=>$product['SlsQuotationProduct']['id']));
							?>
							</div>
							<div class="col-sm-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
								<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select"  data-toggle="modal" data-target="#addnewunittype-<?php echo $i;?>">
								<i class="icon-plus"></i>
							</div>
							</div>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.description.'.$i, array('rows'=>2,'value'=>$product['SlsQuotationProduct']['inventory_description'],'div' => false, 'label' => false, 'class' => 'col-sm-12 tabletextarea', 'type' => 'textarea', 'placeholder' => 'Inventory description')); ?>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.quantity.'.$i, array('id'=>'quantity-'.$i,'value'=>$product['SlsQuotationProduct']['quantity'],'div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5 form-control width50 textright', 'type' => 'text')); ?>
							<label class="quotemeasurement"><?php echo $unitTypeList[$inventoryUnitTypeList[$product['SlsQuotationProduct']['inv_inventory_id']]];?></label>
							<?php echo $this->Form->hidden('AcrClientInvoice.unitTypeofInventory.'.$i,array('value'=>$unitTypeList[$inventoryUnitTypeList[$product['SlsQuotationProduct']['inv_inventory_id']]]));?>
							<?php
									$this -> Js -> get('#quantity-'.$i) -> event('keyup', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
									 $this->Js->get('#quantity-'.$i)->event('keyup', $this->Js->request(array (
											'controller' => 'acr_client_invoices',
											'action' => 'calculateTotal',$i
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
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.unit_rate.'.$i, array('id'=>'unit_rate-'.$i,'value'=>$product['SlsQuotationProduct']['unit_rate'],'div' => false, 'label' => false, 'class' => 'col-sm-10 form-control', 'type' => 'text')); ?>
							<?php
									$this -> Js -> get('#unit_rate-'.$i) -> event('keyup', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
									 $this->Js->get('#unit_rate-'.$i)->event('keyup', $this->Js->request(array (
											'controller' => 'acr_client_invoices',
											'action' => 'calculateTotal',$i
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
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.discount_percent.'.$i, array('id'=>'discount_percent-'.$i,'value'=>$product['SlsQuotationProduct']['discount_percent'],'div' => false, 'label' => false, 'class' => 'col-sm-10 form-control', 'type' => 'text')); ?>
							<?php
									$this -> Js -> get('#discount_percent-'.$i) -> event('keyup', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
									 $this->Js->get('#discount_percent-'.$i)->event('keyup', $this->Js->request(array (
											'controller' => 'acr_client_invoices',
											'action' => 'calculateTotal',$i
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
						</div></td>
						<td>
						<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
							<div class="col-sm-12 marginleftrightzero paddingleftrightzero countrybilling">
								<?php if(!empty($product['SlsQuotationProduct']['sbs_subscriber_tax_group_id'])):
									$taxGroupID = $taxGroupNames[$product['SlsQuotationProduct']['sbs_subscriber_tax_group_id']].'-'.$product['SlsQuotationProduct']['sbs_subscriber_tax_group_id'];
								?>
								<?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.'.$i, array('id'=>'tax_inventory-a'.$i,'default'=>$taxGroupID,'div' => false, 'label' => false, 'class' => 'selectpicker form-control', 'options' => array('' => 'Select Tax', $taxList))); ?>
								<?php elseif(!empty($product['SlsQuotationProduct']['sbs_subscriber_tax_id'])):?>
								<?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.'.$i, array('id'=>'tax_inventory-a'.$i,'default'=>$product['SlsQuotationProduct']['sbs_subscriber_tax_id'],'div' => false, 'label' => false, 'class' => 'selectpicker form-control', 'options' => array('' => 'Select Tax', $taxList))); ?>
								<?php endif;?>
								<?php
									$this -> Js -> get('#tax_inventory-a'.$i) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
									 $this->Js->get('#tax_inventory-a'.$i)->event('change', $this->Js->request(array (
											'controller' => 'acr_client_invoices',
											'action' => 'calculateTotal',$i
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
						</div></td>
						<td>
						<div id="lineTotal-<?php echo $i;?>" class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this->Form->input('AcrClientInvoice.line_total.'.$i,array('value'=>$product['SlsQuotationProduct']['line_total'],'div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','disabled'=>'disabled','readonly'=>'readonly'));
							?>
						</div></td>
						
							
					</tr>
					<!--Popup add  Inventory-->
					<div class="modal fade popupbind" id="addnewunittype-<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
											<?php echo $this->Form->input('addInventory.name',array('div'=>false,'autocomplete'=>'off','label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','id'=>'orm-field-1','Placeholder'=>'Inventory name'));?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('addInventory.description',array('div'=>false,'label'=>false,'autocomplete'=>'off','type'=>'textarea','class'=>'form-control col-xs-10 col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory'));?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?></label>
										<div class="col-sm-8">
											<span>
										    	<?php echo $this->Form->hidden('addInventory.currency',array('value'=>$defaultCurrency));?>
												<?php echo $this->Form->input('addInventory.code',array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'form-control width30 col-xs-10 col-sm-5','value'=>$defaultCurrencyCode,'readonly'=>'readonly'))?>
											</span>
											<span>
												<?php echo $this->Form->input('addInventory.list_price',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 width70 col-sm-5 form-control','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
											</span>
											
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('addInventory.tax_inventory',array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5','options'=>array(''=>'Select Tax',$taxList)));?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
										<div class="col-sm-8" id ="unit-type">
											<?php echo $this->Form->input('addInventory.unitType',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','options'=>array(''=>'Select Unit Type',$unitTypeList)));?>
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
											<?php echo $this->Form->input('addInventory.current_stock',array('div'=>false,'autocomplete'=>'off','label'=>false,'type'=>'text','class'=>'form-control col-xs-10 col-sm-5','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
										</div>
									</div>
											</div>
										</div>
									</div>
									<div class="modal-footer paddingright8">
										<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit','url' => array('controller'=>'inventories','action'=>'addInventory',$i),'escape'=>false,'update' => '#td-inventoryUpdateSelect-'.$i));?>
										<!--<button class="btn btn-info" type="button">
											<i class="icon-ok bigger-110"></i>
											Submit
										</button>-->		
										<button class="btn close-popup" type="button">
											<i class="icon-remove bigger-110"></i>
											Cancel
										</button>
									</div>
								<?php /*echo $this->form->end();*/?>
							</div>
						</div>
					</div>
					<!--end of pop-->
		
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
			<div class="col-sm-4 no-padding-right no-padding-left subtotal" id="calculateFinal">
				<div class="row marginleftrightzero borderon">
					<div class="row marginleftrightzero">
						<span class="left bold">Subtotal</span>
						<span class="right bold"><?php echo $this->Number->currency($quote['SlsQuotation']['sub_total'], $defaultCurrencyCode); ?></span>
						<?php echo $this->Form->hidden('subTotal',array('value'=>$quote['SlsQuotation']['sub_total']));?>
					</div>
					<?php foreach($taxCalcuations as $key=>$val):?>
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
						<span class="left">In Quotation Currency</span>
						<span class="right"><?php echo $this->Number->currency($quote['SlsQuotation']['invoice_amount'], $quote['SlsQuotation']['invoice_currency_code']); ?></span>
						<?php echo $this->Form->hidden('invoicetotal',array('value'=>$quote['SlsQuotation']['invoice_amount']));?>
						<?php echo $this->Form->hidden('invoice_currency_code',array('value'=>$quote['SlsQuotation']['invoice_currency_code']));?>
					</div>
				</div>
				<div class="row marginleftrightzero ">
					<div class="row marginleftrightzero">
						<span class="left bold">Total</span>
					</div>
					<div class="row marginleftrightzero">
						<span class="left">In Subscriber Currency</span>
						<span class="right"><?php echo $this->Number->currency($quote['SlsQuotation']['func_estimate_total'], $defaultCurrencyCode); ?></span>
						<?php echo $this->Form->hidden('subscribertotal',array('value'=>$quote['SlsQuotation']['func_estimate_total']));?>
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
						<?php echo $this->Form->textarea('terms',array('value'=>$quote['SlsQuotation']['term_conditions'],'class'=>'termsandconditions'));?>
					</div>
				</div>
			</div>
			<div class="row marginleftrightzero">
				<div class="form-group marginleftrightzero">
					<label  class="col-xs-12 col-sm-3 col-lg-2 control-label marginleftrightzero paddingleftrightzero">Customer Note</label>
					<div class="col-xs-12 col-sm-3 col-lg-10 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->textarea('notes',array('value'=>$quote['SlsQuotation']['notes'],'class'=>'termsandconditions'));?>
					</div>
				</div>
			</div>
		</div>
		<?php if(!empty($customFields)):?>
		<div class="row marginleftrightzero paddingbottom20">
			<div class="row marginleftrightzero additionalinfo paddingbottom10">
				<h5>Additional Information</h5>
			</div>
			<div class="row marginleftrightzero">
				<?php foreach($customFields as $customFieldID => $customField):?>
				<div class="form-group marginleftrightzero paddingtop15">
					<label  class="col-xs-12 col-sm-3 col-lg-2 control-label marginleftrightzero paddingleftrightzero"><?php echo $customField;?></label>
					<div class="col-xs-12 col-sm-3 col-lg-4 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->hidden('AcrClientInvoice.custom_field_id.'.$customFieldID,array('value'=>$customFieldValueIDS[$customFieldID]));?>
						<?php echo $this->Form->input('AcrClientInvoice.custom_field.'.$customFieldID,array('value'=>$customFieldValues[$customFieldID]));?>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
		<?php endif;?>
		
		
	
				
		
		<!--Popup mail items  -->
<div class="modal fade popupbind" id="mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog model-quotes">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title bold" id="myModalLabel">Send Quote</h1>
			</div>
			<!--<form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST"> --> 
			<div class="form-horizontal popup">	
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="form-group login-form-group">
							<p>
								Please select the Template to continue
							</p>
						</div>
						<div class="form-group filed-left margin-bottom-zero drop-down errorfix">
							<?php echo $this->Form->input('email_template',array('class'=>'form-control selectpicker','data-placeholder'=>'Email Templates','options'=>array(''=>'Select Email Template','quote_product_classic'=>'Product Classic','quote_product_modern'=>'Product Modern','quote_service_classic'=>'Service Classic','quote_service_modern'=>'Service Modern')));?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-success addbutton left marginleftzero marginright14 sendnow" title="Preview" data-toggle="modal" data-target="#preview">
						<i class="icon-zoom-in bigger-110"></i> Preview
				 </button> 
				 	<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright14','url' => array('controller'=>'quotes','action'=>'preview'),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'));?>
					<?php echo $this->Form->button('<i class="icon-share-alt bigger-110"></i> Send',array('escape'=>FALSE,'class'=>'btn btn-info left marginleftzero marginright14 sendPopup','type'=>'submit', 'name' => 'quotation_status', 'value' => 'Open'));?>
					<?php echo $this->Form->button('<i class="icon-remove bigger-110"></i> Cancel',array('escape'=>FALSE,'class'=>'btn left marginleftzero popup-cancel','type'=>'button'));?>
					
				
				</div>
			</div>	
			<!--</form>  -->
		</div>
	</div>
</div>
<!--end of pop-->







		
		
		
		<div class="row marginleftrightzero paddingbottom20">
			<div class="clearfix form-actions margintopzero paddingtopzero no-padding-left no-padding-right">
				<div class="col-md-offset-3 col-md-6">
					<button class="btn btn-info" title="Send Now" data-toggle="modal" data-target="#mail">
						<i class="icon-share-alt bigger-110"></i> Send Now
					</button>
					
					<?php echo $this->Form->button('<i class="icon-save bigger-110"></i> Update Quote',array('escape'=>FALSE,'class'=>'btn btn-info','type'=>'submit', 'name' => 'quotation_status', 'value' => 'Draft'));?>
					<?php echo $this->Html->link('<i class="icon-remove bigger-110"></i> Cancel',array('action'=>'index',$customer, $min, $max, $status, $from, $to, 'page:'.$page),array('class'=>'btn btn-inverse','escape'=>FALSE));?>
					
				</div>
			</div>
		</div>
		
</div>
<!-- /.page-content -->






<!--Popup preview items  -->
<div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div id="preview-template" class="modal-dialog model-quotes">
		
	</div>
</div>
<!--end of pop-->
<script type="text/javascript">
	jQuery(function($) {
		        if($('.selectpicker').length){
	   		      $('.selectpicker').selectpicker({
			       });
    	   
    	         }
	});
	$(document).ready(function(){
		$('body').on('click','.selectitem .dropdown-menu li',function(){
			//console.log("just entered");
			//alert("hi");
	      var thisvalue = $('.selectitem .btn .filter-option').text();
			if (thisvalue=="Customer")
			   {
			   	console.log("entered in if true");
			   	 $(this).parents('.btn-group').siblings('label.error').show();
			   }
			   else{
			   	console.log("entered in if false");
			   	  $(this).parents('.btn-group').siblings('label.error').hide();
			   }
         });	
		$('.sendnow').click(function(){
			$('.previewpopup').trigger('click')
		});
		 $('.close-submit').click(function(){
	     	$('.popupbind').modal('hide');
	     	$('.form-control').val('');
	     	$( "#addInventoryTrack" ).prop( "checked", false );
	    });
	    
	    
	     $('.selectpicker').selectpicker().change(function(){
	        	$(this).valid()
			});
		  
		$("#SlsQuotation").validate({
			onkeyup: false,
			rules: {
				'data[AcrClientInvoice][quote_no]' : {
					required : true,
					checkQuoteNoAvailability : true
				},
				'data[AcrClientInvoice][acr_client_id]': { 
				   required : true
			     },	
			     'data[AcrClientInvoice][issueDate]' : {
			    	required : true
			     },
			     'data[AcrClientInvoice][email_template]' : {
			     	required : true
			     }
			},
			messages: {
				'data[AcrClientInvoice][quote_no]' : {
					required : 'Please enter quote no'
				},
				'data[AcrClientInvoice][acr_client_id]':  { 
				   required : 'Please select a customer.'
			     },	
			     'data[AcrClientInvoice][issueDate]' : {
			     	required : 'Please enter invoice date.'
			     },
			     'data[AcrClientInvoice][email_template]' : {
			     	required : 'Please select email template.'
			     }
			}
		});
		<?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
			$protocol_final = 'https';
		} else {
		  	$protocol_final = 'http';
		} ?>
		$.validator.addMethod("checkQuoteNoAvailability",function(value,element){				
			var x= $.ajax({
			    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>quotes/checkQuotationNo/<?php echo $quote['SlsQuotation']['quotation_no'];?>",
			    type: 'POST',
			    async: false,
			    data: $("#form-field-1").serialize()
			 }).responseText;	 	
			 if(x=="true") return false;
			 else return true;
		},"Quote no already exist.");
		
		
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		var rowcount=<?php echo $i+1;?>;
$('body').on('click','.addcontact',function(){
$( ".add-row" ).trigger( "click" );
});
$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
$(this).prev().focus();
});


$('.sendPopup').click(function(){
			     	$('.popupbind').modal('hide');
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
<script type="text/javascript">
	$(document).ready(function(){
	    $('#conversionValue').keyup(function () {
	    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
	       this.value = this.value.replace(/[^0-9\.]/g, '');
	    }
	    var str = this.value;
	    if(/^[a-zA-Z0-9- ]*$/.test(str) == false) {
    		$(this).attr( "maxlength", "7" );
		} else {
			$(this).attr( "maxlength", "4" );
		}
	});
	
	$('#AcrClientInvoiceIssueDate').datepicker();
    $('#AcrClientInvoiceExpiryDate').datepicker();
	$("#AcrClientInvoiceIssueDate").on("dp.change",function (e) {
       $('#AcrClientInvoiceExpiryDate').data("DatePicker").setMinDate(e.date);
    });
    $("#AcrClientInvoiceExpiryDate").on("dp.change",function (e) {
       $('#AcrClientInvoiceIssueDate').data("DatePicker").setMaxDate(e.date);
    });
	

});
</script>
<?php echo $this->Js->writeBuffer();?>