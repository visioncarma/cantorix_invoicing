<?php echo $this -> Session -> flash(); ?>
<?php $homeLink = $this -> Breadcrumb -> getLink('Home'); ?>
<?php 
	$dbFormat = array("d", "M", "Y");
	$scriptFormat   = array("dd", "mm", "yyyy");
?>
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
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i> Back', array('action' => 'index',$customer, $min, $max, $status, '?' => array('from' => $from, 'to' => $to), 'page:'.$page), array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right addbutton')); ?>
		</div>
	</div>
	<!-- /.page-header -->
	<?php echo $this->Form->create('AcrClientInvoice',array('id'=>'SlsQuotation','url'=>array('controller'=>'quotes','action'=>'edit',$subscriberID,$id,$customer, $min, $max, $status, '?' => array('from' => $from, 'to' => $to), $page),'class'=>'form-horizontal formdetails','role'=>'form','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control')));?>
		<div class="row marginleftrightzero">
			<div class="col-lg-8 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Quote No<em style="color:#ff0000;">&lowast;</em></label>
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
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero labelerror countrybilling max-height max-width choosen_width">
							<?php echo $this->Form->input('acr_client_id',array('id'=>'customerID','data-live-search' => 'true', 'class'=>'invdrop form-control selectitem','data-placeholder'=>'Select Customer','options'=>array(''=>'',$customers),'default'=>$quote['SlsQuotation']['acr_client_id']));?>
						</div>
						<?php /*$this->Js->get('#customerID')->event('change',$this->Js->request(array('action'=>'customerDetails'), array( 'update'=>"#updateCustomerDetail", 'async'=>true, 'dataExpression'=>true, 'method'=>'post',
	              					'data'=>$this->Js->serializeForm(array('isForm'=>true,'inline'=>true))
							)));*/?>
							
						<?php $this->Js->get('#customerID')->event('change',$this->Js->request(array('action'=>'customerDetails'), array( 'update'=>"#updateCustomerDetail", 'async'=>FALSE, 'dataExpression'=>true, 'method'=>'post',
	              					'data'=>$this->Js->serializeForm(array('isForm'=>true,'inline'=>true))
							)));
							$this->Js->get('#customerID')->event('change',$this->Js->request(array('action'=>'customerCurrency'), array( 'update'=>"#currencyUpdatee", 'async'=>FALSE, 'dataExpression'=>true, 'method'=>'post',
	              					'data'=>$this->Js->serializeForm(array('isForm'=>true,'inline'=>true))
							)));
							$this->Js->get('#customerID')->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'currencyInfo'), 
								array( 'update'=>'#invoiceCurrency', 'async'=>FALSE, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>FALSE,'inline'=>true)))));
							$this->Js->get('#customerID')->event('change', $this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotal',1), 
								array ('update' => '#calculateFinal','async' => true,'dataExpression' => true,
										'method' => 'post',
										'data' => $this->Js->serializeForm(array (
										'isForm' => false,
										'inline' => true
									))
								)));
						?>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Currency Code</label>
						<div id="currencyUpdatee" class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero countrybilling max-height max-width choosen_width">
							<?php 
							     echo $this->Form->input('cpn_currency_id',array('id'=>'currencySelect','options'=>array(''=>'Select Currency',$currencyList),'default'=>$subscriberCurrencyIDD,'data-live-search' => 'true', 'class'=>'invdrop form-control','data-placeholder'=>"Currency List",'disabled'=>TRUE));
                                 echo $this->Form->hidden('cpn_currency_id',array('value'=>$subscriberCurrencyIDD));
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
						<div id="invoiceCurrency">
						<?php if ($defaultCurrencyCode != $quote['SlsQuotation']['invoice_currency_code']){?>
						<div class="col-xs-12 col-sm-3 col-lg-2  paddingleftrightzero">
							<sapn class="conversion">
								<?php echo $this -> Form -> hidden('defaultCurrencyId', array('value' => $defaultCurrency)); ?>
								<?php echo '1 '.$quote['SlsQuotation']['invoice_currency_code'].' =';?>
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
							<span class="conversion">
								<?php echo $defaultCurrencyCode;?>
								<?php echo $this -> Form -> hidden('invoice_currency_code', array('value' => $quote['SlsQuotation']['invoice_currency_code'])); ?>
							</span>
						</div>
						<?php } else {?>
							<?php echo $this -> Form -> hidden('defaultCurrencyId', array('value' => $defaultCurrency)); ?>
							<?php echo $this -> Form -> hidden('invoice_currency_code', array('value' => $defaultCurrency)); ?>
						<?php }?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Issue Date<em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							
							 <div class="input-group custom-datepicker">
								<?php echo $this->Form->input('issueDate',array('div'=>false,'class'=>'form-control date-picker','data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$settings['SbsSubscriberSetting']['date_format']),'default'=>date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['issue_date']))));?>
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
										echo $this->Form->input('expiryDate',array('class'=>'form-control date-picker','data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$settings['SbsSubscriberSetting']['date_format']),'default'=>date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['expiry_date']))));
									} else {
										echo $this->Form->input('expiryDate',array('class'=>'form-control date-picker','data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$settings['SbsSubscriberSetting']['date_format']),));
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
						<h5>Quote to</h5>
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
						<th class="width65">Qty</th>
						<th class="width120">Unit Price</th>
						<th class="width90plus">Discount %</th>
						<th class="width150">Tax</th>
						<th class="width120">Amount</th>
						<th class="width65">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=0; foreach($quoteProducts as $product):
						$i++;
						
						?>
					<tr id ="inventoryUpdateSelect-<?php echo $i;?>">
						<td id = "td-inventoryUpdateSelect-<?php echo $i;?>">
						<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
							<div class="col-sm-10 marginleftrightzero paddingleftrightzero countrybilling max-height max-width">
								<?php echo $this -> Form -> input('AcrClientInvoice.inventory.'.$i, array('default'=>$product['SlsQuotationProduct']['inv_inventory_id'],'id' => 'inventory-'.$i, 'div' => false, 'label' => false, 'data-live-search'=>'true','class'=>'invdrop form-control','data-placeholder'=>"Select inventory",'options' => array('' => '','-1'=>'Non Inventory Item', $inventoryList)));
							$this -> Js -> get('#inventory-'.$i) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getInventoryDetails', $i,$product['SlsQuotationProduct']['id'],TRUE,TRUE), array('update' => '#inventoryUpdateSelect-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
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
							<?php echo $this -> Form -> input('AcrClientInvoice.quantity.'.$i, array('id'=>'quantity-'.$i,'value'=>$product['SlsQuotationProduct']['quantity'],'div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5 form-control textright','type'=>'text')); ?>
							<label class="quotemeasurement"><?php echo $unitTypeList[$inventoryUnitTypeList[$product['SlsQuotationProduct']['inv_inventory_id']]];?></label>
							<?php echo $this->Form->hidden('AcrClientInvoice.unitTypeofInventory.'.$i,array('value'=>$unitTypeList[$inventoryUnitTypeList[$product['SlsQuotationProduct']['inv_inventory_id']]]));?>
							<?php
									$this -> Js -> get('#quantity-'.$i) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
									 $this->Js->get('#quantity-'.$i)->event('change', $this->Js->request(array (
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
							<?php echo $this -> Form -> input('AcrClientInvoice.unit_rate.'.$i, array('id'=>'unit_rate-'.$i,'value'=>$product['SlsQuotationProduct']['unit_rate'],'div' => false, 'label' => false, 'class' => 'col-sm-10 form-control textright','type'=>'text')); ?>
							<?php
									$this -> Js -> get('#unit_rate-'.$i) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
									 $this->Js->get('#unit_rate-'.$i)->event('change', $this->Js->request(array (
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
							<?php echo $this -> Form -> input('AcrClientInvoice.discount_percent.'.$i, array('id'=>'discount_percent-'.$i,'value'=>$product['SlsQuotationProduct']['discount_percent'],'div' => false, 'label' => false, 'class' => 'col-sm-10 form-control black textright','onkeyup'=>'this.value = minmax(this.value, 0, 100)','type'=>"text")); ?>
							<?php
									$this -> Js -> get('#discount_percent-'.$i) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getLineTotal', $i), array('update' => '#lineTotal-'.$i, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
									 $this->Js->get('#discount_percent-'.$i)->event('change', $this->Js->request(array (
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
							<div class="col-sm-12 marginleftrightzero paddingleftrightzero countrybilling max-width max-height choosen_width">
								<?php if(!empty($product['SlsQuotationProduct']['sbs_subscriber_tax_group_id'])):
									$taxGroupID = $taxGroupNames[$product['SlsQuotationProduct']['sbs_subscriber_tax_group_id']].'-'.$product['SlsQuotationProduct']['sbs_subscriber_tax_group_id'];
								?>
								<?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.'.$i, array('id'=>'tax_inventory-a'.$i,'default'=>$taxGroupID,'div' => false, 'label' => false, 'class' => 'invdrop form-control','data-placeholder'=>"Select Tax", 'options' => array('' => '', $taxList))); ?>
								<?php elseif(!empty($product['SlsQuotationProduct']['sbs_subscriber_tax_id'])):?>
								<?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.'.$i, array('id'=>'tax_inventory-a'.$i,'default'=>$product['SlsQuotationProduct']['sbs_subscriber_tax_id'],'div' => false, 'label' => false, 'class' => 'invdrop form-control','data-placeholder'=>"Select Tax", 'options' => array('' => '', $taxList))); ?>
								<?php else:?>
								<?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.'.$i, array('id'=>'tax_inventory-a'.$i,'div' => false, 'label' => false, 'class' => 'invdrop form-control','data-placeholder'=>"Select Tax", 'options' => array('' => '', $taxList))); ?>
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
							<?php echo $this->Form->input('AcrClientInvoice.line_total.'.$i,array('value'=>$product['SlsQuotationProduct']['line_total'],'div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control textright black','type'=>'text','disabled'=>'disabled','readonly'=>'readonly'));
							?>
						</div></td>
						<td class="textleft">
							<?php 
								echo $this -> Js -> link('<i style="color:#F00;" class="icon-trash bigger-120"></i>', 
									array('controller' => 'quotes', 'action' => 'deleteRow',$i,$product['SlsQuotationProduct']['id']),
									array('id'=>'link-'.$i,'class'=>'textdecoration_none deleteinvocerow','escape' => FALSE, 'update' => '#inventoryUpdateSelect-'.$i,'title'=>'Delete Item','confirm'=>'Are you sure you want to remove this item?',
									'success'=>$this->Js->request(array ('controller' => 'acr_client_invoices','action' => 'calculateTotalAfterDelete',$i), array (
																			'update' => '#calculateFinal',
																			'async' => TRUE,
																			'dataExpression' => true,
																			'method' => 'post',
																			'data' => $this->Js->serializeForm(array (
																			'isForm' => false,
																			'inline' => true
																		))
																	))));
							
							?>
							</td>
						
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
											<?php echo $this->Form->input('addInventory.name.'.$i,array('div'=>false,'autocomplete'=>'off','label'=>false,'class'=>'col-xs-10 col-sm-5 env-name'.$i.' form-control','type'=>'text','id'=>'orm-field-1','Placeholder'=>'Inventory name'));?>
										<p class="popup-error1">Please enter inventory name.</p>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('addInventory.description.'.$i,array('div'=>false,'label'=>false,'autocomplete'=>'off','type'=>'textarea','rows'=>'2','class'=>'form-control col-xs-10 col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory'));?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?></label>
										<div class="col-sm-8">
											<span>
										    	<?php echo $this->Form->hidden('addInventory.currency.'.$i,array('value'=>$defaultCurrency));?>
												<?php echo $this->Form->input('addInventory.code.'.$i,array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'form-control width30 col-xs-10 col-sm-5','value'=>$defaultCurrencyCode,'readonly'=>'readonly'))?>
											</span>
											<span>
												<?php echo $this->Form->input('addInventory.list_price.'.$i,array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 env-price'.$i.' width70 col-sm-5 form-control','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
												<p class="popup-error2">Please enter inventory price.</p>
												<p class="popup-error3">Only numbers allowed</p>
											</span>
											
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
										<div class="col-sm-8 choosen_width">
											<?php echo $this->Form->input('addInventory.tax_inventory.'.$i,array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 invdrop','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList)));?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
										<div class="col-sm-8 choosen_width" id ="unit-type">
											<?php echo $this->Form->input('addInventory.unitType.'.$i,array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select Unit Type", 'options'=>array(''=>'',$unitTypeList)));?>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
										<div class="col-sm-8">
											<label>
												<?php echo $this->Form->checkbox('addInventory.track.'.$i,array('id'=>'inventoryCheckBox','div'=>false,'label'=>false,'class'=>'ace checkboxclass'));?>
												<span class="lbl"></span> </label>
											<label class="maillabel">Yes</label>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group currentstock" style="display: none;">
										<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> </label>
										<div class="col-sm-8">
											<?php echo $this->Form->input('addInventory.current_stock.'.$i,array('div'=>false,'autocomplete'=>'off','label'=>false,'type'=>'text','class'=>'form-control env-qty'.$i.' col-xs-10 col-sm-5','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
											<p class="popup-error4">Please enter current Stock.</p>
										</div>
									</div>
											</div>
										</div>
									</div>
									<div class="modal-footer paddingright8">
										<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit'.$i,'url' => array('controller'=>'inventories','action'=>'addInventoryFromEditQuote',$i),'escape'=>false,'update' => '#td-inventoryUpdateSelect-'.$i));?>
										<!--<button class="btn btn-info" type="button">
											<i class="icon-ok bigger-110"></i>
											Submit
										</button>-->		
										<button class="btn close-submit btn-inverse" type="button">
											<i class="icon-remove bigger-110"></i>
											Cancel
										</button>
									</div>
									<script>
									$(document).ready(function(){
										$(".invdrop option:contains('|--')").remove();
										$('#addnewunittype-<?php echo $i;?>').on('show.bs.modal', function (e) {
									  		$('.env-name<?php echo $i;?>, .env-price<?php echo $i;?>, env-qty<?php echo $i;?>').val('');
									  		$('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
									  		$('.currentstock').hide();
									  		$('.checkboxclass').attr('checked', false); // Unchecks it
										});
										
										$('.env-name<?php echo $i;?>, .env-price<?php echo $i;?>, .env-qty<?php echo $i;?>').focus(function() {
											$('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
										});
										
										$('.close-submit<?php echo $i;?>').click(function(evt){
										 var value<?php echo $i;?> = $.trim($(".env-name<?php echo $i;?>").val());
											 if(value<?php echo $i;?>.length === 0) {
											 	$('.popup-error1').show();
											 	evt.preventDefault();
										        $('#field').value();
											 }
										 
									     var value6 = $.trim($(".env-price<?php echo $i;?>").val());
											 if(value6.length === 0) {
											 	$('.popup-error2').show();
											 	evt.preventDefault();
										        $('#field').value();
											 }
									    	 
										 var value6 = $.trim($(".env-price<?php echo $i;?>").val());
										 if(!$.isNumeric(value6)) {
											// if(value7.length === 0) {
											 	$('.popup-error3').show();
											 	evt.preventDefault();
										        $('#field').value();
											 }	
										 if ($('#inventoryCheckBox').is(':checked')) {
											 var value10 = $.trim($(".env-qty<?php echo $i;?>").val());
												 if(value10.length === 0) {
												 	$('.popup-error4').show();
												 	evt.preventDefault();
											        $('#field').value();
												 }
											 }
									 	$('#addnewunittype-<?php echo $i;?>').modal('hide');
									    });
									});				
									</script>
									<?php /*echo $this->form->end();*/?>
							</div>
						</div>
					</div>
					<!--end of pop-->
					<script type="text/javascript">

						$(document).ready(function() {
						var pquantityy = $('#quantity-<?php echo $i;?>').val();
						var punit_rate = $('#unit_rate-<?php echo $i;?>').val();
						var pdiscountt = $('#discount_percent-<?php echo $i;?>').val();
												
						$("input#quantity-<?php echo $i;?>").keypress(function(event) { return isNumber(event) });
						$("input#discount_percent-<?php echo $i;?>").keypress(function(event) { return isNumber(event) });
						$("input#unit_rate-<?php echo $i;?>").keypress(function(event) { return isNumber(event) });
						
						
						$('input#quantity-<?php echo $i;?>').on('blur',function(e){
								if($('#quantity-<?php echo $i;?>').val() === "") {
									alert("Field can't be empty.");
									$('#quantity-<?php echo $i;?>').val(pquantityy);
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
							//$(".chosen-select").chosen();
							if($('.selectpicker').length){
						   		 $('.selectpicker').selectpicker({
								});    	
					    	} 
						});	
						$(function(){
							$('.close-submit').click(function(){
						     	$('#addnewunittype-<?php echo $i;?>').modal('hide');
						    });
						});
					</script>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
		<div class="row marginleftrightzero paddingbottom20">
			<div class="col-sm-7 no-padding-right no-padding-left paddingtop15 marginright45new">
				<div class="btn btn-sm btn-success pull-left addbutton addunitpadding add-row">
					<i class="icon-plus"></i>
				</div>
				<label class="addcontact">Add More</label>
			</div>
			<div class="col-sm-4 no-padding-right pull-right no-padding-left subtotal newsubtotal" id="calculateFinal">
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
						<span class="left">In Invoice Currency</span>
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
						<?php echo $this->Form->hidden('subscribertotalEditQuote',array('value'=>$quote['SlsQuotation']['func_estimate_total']));?>
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
							<?php echo $this->Form->input('email_template',array('class'=>'form-control selectpicker','data-placeholder'=>'Email Templates','options'=>array('quote_product_classic'=>'Product Classic','quote_product_modern'=>'Product Modern','quote_service_classic'=>'Service Classic','quote_service_modern'=>'Service Modern')));?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-success addbutton left marginleftzero  marginright4 padding0 sendnow" title="Preview" data-toggle="modal" data-target="#preview">
						<i class="icon-zoom-in bigger-110"></i> Preview
				 </button> 
				 	<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright14','url' => array('controller'=>'quotes','action'=>'preview'),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'));?>
					<?php echo $this->Form->button('<i class="icon-share-alt bigger-110"></i> Send',array('escape'=>FALSE,'class'=>'btn btn-info left marginleftzero marginright4 padding0','type'=>'submit', 'name' => 'quotation_status', 'value' => 'Open'));?>
					<?php echo $this->Form->button('<i class="icon-remove bigger-110"></i> Cancel',array('escape'=>FALSE,'class'=>'btn left marginleftzero popup-cancel marginright4 padding0','type'=>'button'));?>
					
				
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
					
					<?php echo $this->Form->button('<i class="icon-save bigger-110"></i> Update Quote',array('escape'=>FALSE,'class'=>'btn btn-info saveQuote','type'=>'submit', 'name' => 'quotation_status', 'value' => 'Draft'));?>
					<?php echo $this->Html->link('<i class="icon-remove bigger-110"></i> Cancel',array('action'=>'index',$customer, $min, $max, $status, '?' => array('from' => $from, 'to' => $to), 'page:'.$page),array('class'=>'btn btn-inverse','escape'=>FALSE));?>
					
				</div>
			</div>
		</div>
		
</div>
<!-- /.page-content -->

<!--Popup preview items  -->
<div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
$(function() {
		$( "#customerID" ).change(function() {
			$('.labelerror .error').hide();
		});

		var config = {
		  '#customerID' : {search_contains:true},
		  '.invdrop' : {search_contains:true}
		}
		for (var selector in config) {
		  $(selector).chosen(config[selector]);
		}
		
		//$( "#customerID" ).selectmenu();
		//$( "#inventory-1" ).selectmenu();
		//$( "#number" )
		//.selectmenu()
		//.selectmenu( "menuWidget" )
		//.addClass( "overflow" );
	});
	
function minmax(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) > 100) 
        return 100; 
    else return value;
}
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
	     	$('#addnewunittype-1').modal('hide');
	    });
		
		 /*$('.close-submit').click(function(){
	     	$('.popupbind').modal('hide');
	     	$('.form-control').val('');
	     	$( "#addInventoryTrack" ).prop( "checked", false );
	    });*/
	   
	    $('.popup-cancel').click(function(){
			$('.popupbind').modal('hide');
		});
	    
	     $('.selectpicker').selectpicker().change(function(){
	        	$(this).valid()
		});
		
		$.validator.setDefaults({ ignore: ":hidden:not(select)" });  
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
			     'data[AcrClientInvoice][conversionValue]' : {
			    	required : true
			     }
			     
			},
			messages: {
				'data[AcrClientInvoice][quote_no]' : {
					required : 'Please enter quote no',
					checkQuoteNoAvailability : 'Quote no already exist.'
				},
				'data[AcrClientInvoice][acr_client_id]':  { 
				   required : 'Please select a customer.'
			     },	
			     'data[AcrClientInvoice][issueDate]' : {
			     	required : 'Please enter invoice date.'
			     },	
			     'data[AcrClientInvoice][conversionValue]' : {
			     	required : 'Please enter Conversion Rates.'
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
	   
	   if ($('#inventoryCheckBox').is(':checked')) {
		 var value13 = $.trim($(".env-qty-<?php echo $rowId;?>").val());
		 if(value13.length === 0) {
			 	$('.popup-error4').show();
				evt.preventDefault();
				$('#field').value();
		 	}
		 }   
	  });
	  
	});
	
					
$('body').on('click','.checkboxclass',function(){
	if($(this).is(":checked")) {
		$(this).parent().parent().parent().next().next().show();
	} else {
		$(this).parent().parent().parent().next().next().hide();
	}
});

</script>
<?php echo $this->Js->writeBuffer();?>