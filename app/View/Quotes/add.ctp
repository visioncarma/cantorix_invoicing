<?php echo $this -> Session -> flash(); ?>
<?php if(!$rowId){$rowId = 1;}?>
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
			<?php echo $this -> Html -> link('<i class="icon-home home-icon"></i>Home', "$homeLink", array('escape' => FALSE)); ?>
		</li>
		<li>
			<?php echo $this -> Html -> link('Quotes', array('action' => 'index')); ?>
		</li>
		<li class="active">
			Add Quote
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 > Add New Quote </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i> Back', array('action' => 'index',$customer, $min, $max, $status, '?'=>array('from' => $from, 'to' => $to), 'page:'.$page), array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right addbutton')); ?>
		</div>
	</div>
	<!-- /.page-header -->
	<?php echo $this->Form->create('AcrClientInvoice',array('id'=>'SlsQuotation','class'=>'form-horizontal formdetails','role'=>'form','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control')));?>
		<div class="row marginleftrightzero">
			<div class="col-lg-8 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Quote No<em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('quote_no',array('placeholder'=>'Quote No','value'=>$quoteNumber,'class'=>'form-control'));?>
						
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Purchase Order No.#</label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('purchase_order_no',array('placeholder'=>'Purchase order no','class'=>'form-control'));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Quote Description</label>
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('quote_description',array('placeholder'=>'Description','class'=>'form-control'));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Customer<em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero labelerror countrybilling max-height max-width">
							<?php echo $this->Form->input('acr_client_id',array('id'=>'customerID','data-live-search' => 'true','class'=>'selectitem form-control','data-placeholder'=>'Select a Customers','options'=>array(''=>'',$customers)));?>
							
						</div>
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
							
							echo $this -> Form -> hidden('defaultCurrencyId', array('value' => $defaultCurrency));
							echo $this -> Form -> hidden('defaultCurrencyCodee', array('value' => $defaultCurrencyCode));
							echo $this -> Form -> hidden('invoice_currency_code', array('value' => $defaultCurrencyCode));
							echo $this -> Form -> hidden('conversionValue',array('value'=>1));
							
						?>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Currency</label>
						<div id="currencyUpdatee" class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero countrybilling max-height max-width choosen_width">
							<?php echo $this->Form->input('cpn_currency_id',array('id'=>'currencySelect','options'=>array(''=>'Select Currency',$currencyList),'default'=>$defaultCurrency,'data-live-search' => 'true', 'class'=>'invdrop form-control','data-placeholder'=>"Currency List",'disabled'=>TRUE));
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
						<div id="invoiceCurrency"> </div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Issue Date</label>
						<div class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero">
							
							 <div class="input-group custom-datepicker">
							
								<?php echo $this->Form->input('issueDate',array('label'=>false,'div'=>false,'class'=>'form-control date-picker','data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$settings['SbsSubscriberSetting']['date_format']),'default'=>date($settings['SbsSubscriberSetting']['date_format'])));?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
								
							</div> 
							
							
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero">Expiry Date</label>
						<div class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker">
								<?php echo $this->Form->input('expiryDate',array('label'=>false,'div'=>false,'class'=>'form-control date-picker','data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$settings['SbsSubscriberSetting']['date_format'])));?>
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
						<th class="width120">Tax</th>
						<th class="width120">Amount</th>
						<th class="width65">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr id ="inventoryUpdateSelect-1">
						<td id = "td-inventoryUpdateSelect-1">
							
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<div class="col-sm-10 marginleftrightzero paddingleftrightzero countrybilling max-height max-width">
								<?php echo $this -> Form -> input('AcrClientInvoice.inventory.1', array('id' => 'inventory-1', 'div' => false, 'data-live-search'=>'true','data-placeholder'=>"Select inventory",'label' => false, 'class'=>'invdrop form-control','options' => array('' => '','-1'=>'Non Inventory Item', $inventoryList)));
							$this -> Js -> get('#inventory-1') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getInventoryDetails', 1), array('update' => '#inventoryUpdateSelect-1', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
							?>
							<?php
									 $this->Js->get('#inventory-1')->event('change', $this->Js->request(array (
											'controller' => 'acr_client_invoices',
											'action' => 'calculateTotal',1
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
								<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select"  data-toggle="modal" data-target="#addnewunittype-<?php echo $rowId;?>">
								<i class="icon-plus"></i>
							</div>
							</div>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.description.1', array('rows'=>2,'div' => false, 'label' => false, 'class' => 'col-sm-12 tabletextarea', 'type' => 'textarea', 'placeholder' => 'Inventory description', 'readonly' => 'readonly')); ?>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.quantity.1', array('div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5 form-control textright', 'type' => 'text', 'id' => 'spinner1', 'readonly' => 'readonly')); ?>
							<label class="quotemeasurement"></label>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.unit_rate.1', array('div' => false, 'label' => false, 'class' => 'col-sm-10 form-control textright', 'type' => 'text', 'readonly' => 'readonly')); ?>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.discount_percent.1', array('div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5 form-control discountMax black textright', 'type' => 'text', 'readonly' => 'readonly')); ?>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<div class="col-sm-12 marginleftrightzero paddingleftrightzero countrybilling choosen_width">
								<?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.1', array('div' => false, 'label' => false, 'class' => 'form-comtrol invdrop', 'data-placeholder'=>"Select Tax", 'options' => array('' => '', $taxList), 'readonly' => 'readonly')); ?>
							</div>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this->Form->input('AcrClientInvoice.line_total.1',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control textright black','type'=>'text','disabled'=>'disabled','readonly'=>'readonly'))
							?>
						</div></td>
						<td class="textcenter">
							<a href="#" class="textdecoration_none">
								&nbsp;
							</a>
						</td>
						<!--Popup add  -->
							<div class="modal fade" id="addnewunittype-<?php echo $rowId;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
												<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> <em style="color:#ff0000;">∗</em></label>
												<div class="col-sm-8">
													<?php echo $this->Form->input('addInventory.name-',array('div'=>false,'label'=>false,'autocomplete'=>'off','class'=>'col-xs-10 env-name col-sm-5 form-control','type'=>'text','id'=>'form-field-1','Placeholder'=>'Inventory name'));?>
													<p class="popup-error1">Please enter inventory name.</p>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?> </label>
												<div class="col-sm-8">
													<?php echo $this->Form->input('addInventory.description-',array('div'=>false,'label'=>false,'autocomplete'=>'off','type'=>'textarea','rows'=>'2','class'=>'form-control col-xs-10 env-desc col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory','maxlength'=>'55'));?>
													
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?> <em style="color:#ff0000;">∗</em></label>
												<div class="col-sm-8">
													<span>
												    	<?php echo $this->Form->hidden('addInventory.currency-',array('value'=>$defaultCurrency));?>
														<?php echo $this->Form->input('addInventory.code-',array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'form-control width30 col-xs-10 col-sm-5','value'=>$defaultCurrencyCode,'readonly'=>'readonly'))?>
													</span>
													<span>
														<?php echo $this->Form->input('addInventory.list_price-',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 price-field env-price width70 col-sm-5 form-control','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
														
													</span>
													<p class="popup-error2">Please enter inventory price.</p>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
												<div class="col-sm-8 choosen_width">
													<?php echo $this->Form->input('addInventory.tax_inventory-',array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5  invdrop','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList)));?>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
												<div class="col-sm-8 choosen_width" id ="unit-type">
													<?php echo $this->Form->input('addInventory.unitType-',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select Unite Type", 'options'=>array(''=>'',$unitTypeList)));?>
												</div>
												
											</div>
											<div class="space-4"></div>
											<div class="form-group" >
												<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
												<div class="col-sm-8">
													<label>
														<?php echo $this->Form->checkbox('addInventory.track-',array('div'=>false,'label'=>false,'class'=>'ace','id'=>'inventoryCheckBox'));?>
														<span class="lbl"></span> </label>
													<label class="maillabel">Yes</label>
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group currentstock" style="display: none;">
												<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?>  <em style="color:#ff0000;">∗</em></label>
												<div class="col-sm-8">
													<?php echo $this->Form->input('addInventory.current_stock-',array('div'=>false,'label'=>false,'autocomplete'=>'off','type'=>'text','class'=>'form-control env-qty col-xs-10 col-sm-5','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
												<p class="popup-error3">Please enter current Stock.</p>
												</div>
											</div>
													</div>
												</div>
											</div>
											<div class="modal-footer paddingright8">
											<?php 
											
											echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit4','url' => array('controller'=>'inventories','action'=>'addInventory'),'escape'=>false,'update' => '#td-inventoryUpdateSelect-1','tag'=>'<i class="icon-ok bigger-110"></i>'));
											?>
												<!--<button class="btn btn-info" type="button">
													<i class="icon-ok bigger-110"></i>
													Submit
												</button>-->		
												<button class="btn close-popup btn-inverse" type="button">
												    Cancel
												</button>
											</div>
											
											
											<script>
											$(document).ready(function() {
														// Remove Tax Items
												$(".invdrop option:contains('|--')").remove();
												$('#addnewunittype-<?php echo $rowId;?>').on('show.bs.modal', function (e) {
												  		$('.env-name, .env-price, .env-desc, .env-qty').val('');
												  		$('.popup-error1, .popup-error2, .popup-error3').hide();
													});
													$( ".env-name, .env-price, .env-qty" ).focus(function() {
														$('.popup-error1, .popup-error2, .popup-error3').hide();
													});
													
													$('.close-submit4').click(function(evt){
												    	 var value7 = $.trim($(".env-name").val());
												    	 if(value7.length === 0) {
												    	 	$('.popup-error1').show();
												    	 	evt.preventDefault();
													        $('#field').value();
												    	 }							
													   
													     var value9 = $.trim($(".env-price").val());
												    	 if(value9.length === 0) {
												    	 	$('.popup-error2').show();
												    	 	evt.preventDefault();
													        $('#field').value();
												    	 }
												    	 
												    	 if ($('#inventoryCheckBox').is(':checked')) {
												    	 var value10 = $.trim($(".env-qty").val());
												    	 if(value10.length === 0) {
												    	 	$('.popup-error3').show();
												    	 	evt.preventDefault();
													        $('#field').value();
												    	 }
												    	 }
												     	$('#addnewunittype-<?php echo $rowId;?>').modal('hide');
												    });
													});				
												</script>
										<?php /*echo $this->form->end();*/?>
									</div>
								</div>
							</div>
							<!--end of pop-->
							
					</tr>
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
			<div id="calculateFinal" class="col-sm-4 no-padding-right pull-right no-padding-left subtotal newsubtotal">
				<div class="row marginleftrightzero borderon">
					<div class="row marginleftrightzero">
						<span class="left bold">Subtotal</span>
						<span class="right bold">0.00</span>
					</div>
				</div>
				<div class="row marginleftrightzero borderon">
					<div class="row marginleftrightzero">
						<span class="left bold">Total</span>
					</div>
					<div class="row marginleftrightzero">
						<span class="left">In Quotation Currency</span>
						<span class="right">0.00</span>
					</div>
				</div>
				<div class="row marginleftrightzero ">
					<div class="row marginleftrightzero">
						<span class="left bold">Total</span>
					</div>
					<div class="row marginleftrightzero">
						<span class="left">In Subscriber Currency</span>
						<span class="right">0.00</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row marginleftrightzero borderblue"></div>
		<div class="row marginleftrightzero paddingbottom20 paddingtop25">
			<div class="row marginleftrightzero">
				<div class="form-group marginleftrightzero">
					<label  class="col-xs-12 col-sm-3 col-lg-2 control-label marginleftrightzero paddingleftrightzero">Terms and Conditions</label>
					<div class="col-xs-12 col-sm-3 col-lg-10 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->textarea('terms',array('class'=>'termsandconditions','value'=>$termsAndConditions));?>
					</div>
				</div>
			</div>
			<div class="row marginleftrightzero">
				<div class="form-group marginleftrightzero">
					<label  class="col-xs-12 col-sm-3 col-lg-2 control-label marginleftrightzero paddingleftrightzero">Customer Note</label>
					<div class="col-xs-12 col-sm-3 col-lg-10 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->textarea('notes',array('class'=>'termsandconditions','value'=>$defaultNotes));?>
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
						<?php echo $this->Form->input('AcrClientInvoice.custom_field.'.$customFieldID);?>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
		<?php endif;?>
		
<!--Popup mail items  -->
<div class="modal fade" id="mail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						<div class="form-group filed-left margin-bottom-zero drop-down">
							<?php echo $this->Form->input('email_template',array('class'=>'form-control selectpicker','data-placeholder'=>'Email Templates','options'=>array('quote_product_classic'=>'Product Classic','quote_product_modern'=>'Product Modern','quote_service_classic'=>'Service Classic','quote_service_modern'=>'Service Modern')));?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-success addbutton left marginleftzero  marginright4 padding0 sendnow" title="Preview" data-toggle="modal" data-target="#preview">
						<i class="icon-zoom-in bigger-110"></i> Preview
				 </button> 
				 	<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright4 padding0','url' => array('controller'=>'quotes','action'=>'preview'),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'));?>
					<?php //echo $this->Js->submit('<i class="icon-zoom-in bigger-110"></i> Preview',array('url'=>array('action'=>'preview'),'update'=>'#preview-template','escape'=>FALSE,/*'style' =>'display:none;',*/'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright14'));?>
					<?php //echo $this->Form->button('<i class="icon-zoom-in bigger-110"></i> Preview',array('data-toggle'=>"modal", 'data-target'=>"#preview",'escape'=>FALSE,'class'=>'btn btn-info left marginleftzero marginright14','type'=>'submit', 'name' => 'quotation_status', 'value' => 'Open'));?>
					<?php echo $this->Form->button('<i class="icon-share-alt bigger-110"></i> Send',array('escape'=>FALSE,'class'=>'btn btn-info left marginleftzero marginright4 padding0','type'=>'submit', 'name' => 'quotation_status', 'value' => 'Open'));?>
					<?php echo $this->Form->button('<i class="icon-remove bigger-110"></i> Cancel',array('escape'=>FALSE,'class'=>'btn left marginleftzero popup-cancel marginright4 padding0','type'=>'button'));?>
				</div>
				</div>
		<!--	</form> -->
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
					
					<?php echo $this->Form->button('<i class="icon-save bigger-110"></i> Save Quote',array('escape'=>FALSE,'class'=>'btn btn-info saveQuote','type'=>'submit', 'name' => 'quotation_status', 'value' => 'Draft'));?>
					<?php echo $this->Html->link('<i class="icon-undo bigger-110"></i> Reset',array('action'=>'add',$customer, $min, $max, $status, '?'=>array('from' => $from, 'to' => $to), $page),array('class'=>'btn btn-inverse','escape'=>FALSE));?>
					
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
<?php //echo $this->Html->css(array('jquery-ui-new'));?>
<?php //echo $this->Html->script(array('jquery-ui'));?>
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
		
	});
	
	$(document).ready(function(){
	
		
		//alert("s");
		$('body').on('click','.selectitem .dropdown-menu li',function(){
	      var thisvalue = $('.selectitem .btn .filter-option').text();
			if (thisvalue=="Customer")
			   {
			   	 $(this).parents('.btn-group').siblings('label.error').show();
			   }
			   else{
			   	  $(this).parents('.btn-group').siblings('label.error').hide();
			   }
         });	
			if($('.selectpicker').length){
	   		      $('.selectpicker').selectpicker({
			       });
    	   
    	         }
		$('.sendnow').click(function(){
			$('.previewpopup').trigger('click')
		});
		
		<?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
			$protocol_final = 'https';
		} else {
		  	$protocol_final = 'http';
		} ?>
		
		
		$.validator.addMethod("checkQuoteNoAvailability",function(value,element){				
			var x= $.ajax({
			    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>quotes/checkQuotationNo/<?php echo $subscriberID;?>",
			    type: 'POST',
			    async: false,
			    data: $("#SlsQuotation").serialize()
			 }).responseText;	 	
			 if(x=="true") return false;
			 else return true;
		},"Quote no already exist.");
		
		
		
		$.validator.setDefaults({ ignore: ":hidden:not(select)" });
		$("#SlsQuotation").validate({
			onkeyup: false,
			rules: {
				'data[AcrClientInvoice][quote_no]' : {
					required : true,
					checkQuoteNoAvailability : true
				},
				'data[AcrClientInvoice][acr_client_id]': { 
				   required : true,
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
					required : 'Please enter quote no.',
					checkEmailAvailability : "Quote no already exist."
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
		/*$('.saveQuote').click(function(e){			
				 	$("#SlsQuotation").validate().element('#conversionValue');
				    e.preventDefault();
		});*/		
	});	
	
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$('.close-popup').click(function(){
			
	     	$('.close').trigger('click');
	    });  
	    
	    $('.sendPopup').click(function(){
	     	$('.close').trigger('click');
	    });
	    
	    
	    /*$('.close-submit').click(function(){
	     	$('.form-control').val('');
	     	$( "#addInventoryTrack" ).prop( "checked", false );
	     	
	    });*/
	    
        if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 
		var rowcount=2;
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
<script type="text/javascript">
	$(document).ready(function(){
	 
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
	  });
	});

$('body').on('click','#inventoryCheckBox',function(){
	if($('#inventoryCheckBox').is(":checked")) {
		$('.currentstock').show();
	} else {
		$('.currentstock').hide();
	}
});

</script>
<?php echo $this->Js->writeBuffer();?>