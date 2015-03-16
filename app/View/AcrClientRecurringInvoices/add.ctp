<?php
if(!$rowId){$rowId = 1;}
?>
<?php
$homeLink = $this -> Breadcrumb -> getLink('Home');
?>
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
			<?php echo $this -> Html -> link('Recurring Invoices', array('controller' => 'acr_client_recurring_invoices', 'action' => 'index'), array('div' => false, 'escape' => false)); ?>
		</li>
		<li class="active">
			<?php echo __('Add Recurring Invoice');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 > <?php echo __('Add New Recurring Invoice');?> </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i>Back', array('action' => 'index'), array('class' => 'btn btn-sm btn-success pull-right addbutton', 'escape' => FALSE)); ?>
		</div>

	</div>
	<!-- /.page-header -->
	<?php echo $this->Form->create('AcrClientInvoice',array('class'=>'form-horizontal formdetails','role'=>'form'));?>
		<div class="row marginleftrightzero">
			<div class="col-lg-8 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Recurring No');?></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero" id = "invoiceNumber">
							<?php echo $this->Form->input('recurring_invoice_no',array('id'=>'invNumber','div'=>false,'label'=>false,'class'=>'form-control','type'=>'text','placeholder'=>'Invoice No.','value'=>$invoiceNumber));?>
							<?php $this -> Js -> get('#invNumber') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_recurring_invoices', 'action' => 'invoiceNumberExist'), array('update' => '#invoiceNumber', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('PO #');?></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('purchase_order_no',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'text','placeholder'=>'Purchase Order No.'));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Invoice Description');?></label>
						<div class="col-xs-12 col-sm-4 col-lg-6 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('invoice_description',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'text','placeholder'=>'Description of the Invoice'));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero ">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Customer');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-6  margin-bottom-zero form-filter-field nopadding positionRelativeselect countrybilling max-height max-width labelerror choosen_width">
							<?php echo $this -> Form -> input('acr_client_id', array('id' => 'clientId', 'div' => false, 'label' => false, 'options' => array('' => '', $customer),  'data-live-search' => 'true', 'class'=>'form-control invdrop','data-placeholder' => "Select Customer"));
								  $this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'customerInfo'), array('update' => '#customerInfo', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
							?>
							<?php
								$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getClientCurrency'), array('update' => '#currencyDiv', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true))))); 
							?>
							<?php
								$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getDefaultPaymentTerm'), array('update' => '#paymentTerm', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true))))); 
							?>
							<?php 
								$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'findEndDate'), array('update' => '#dueDateUpdate', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
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
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero countrybilling max-height max-width choosen_width">
							<?php echo $this -> Form -> input('cpn_currency_id', array('id' => 'invoiceCurrencySelect', 'div' => false, 'label' => false, 'options' => array('' => '', $currencyList), 'default' => $defaultCurrency, 'data-live-search' => 'true',  'class'=>'form-control invdrop','data-placeholder' => "Currency List",'disabled'=>'disabled'));
									   $this -> Js -> get('#invoiceCurrencySelect') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'currencyInfo'), array('update' => '#invoiceCurrency', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
						    ?>
						    <?php
							           $this->Js->get('#invoiceCurrencySelect')->event('change', $this->Js->request(array (
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
				<div class="row marginleftrightzero">
					<div class="form-group  marginleftrightzero ">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Terms');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero positionRelativeselect choosen_width" id = "paymentTerm">
							<?php echo $this -> Form -> input('sbs_subscriber_payment_term_id', array('id' => 'paymentTems', 'div' => false, 'label' => false, 'options' => array('' => '', $paymentTerm), 'class' => 'form-control invdrop','data-placeholder' => "Select Term"));
									   $this -> Js -> get('#paymentTems') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'findEndDate'), array('update' => '#dueDateUpdate', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
						    ?>
						</div>
					</div>
				</div>
				
				
				<div class="row marginleftrightzero">
					<div class="form-group  marginleftrightzero ">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Recurring Period');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero positionRelativeselect choosen_width">
							<?php echo $this->Form->input('recurring_period',array('div'=>false,'label'=>false,'class'=>'form-control invdrop','data-placeholder'=>"Select",'options'=>array(''=>'','Day'=>'Day','Week'=>'Week','Month'=>'Month','Year'=>'Year')));?>
												
						</div>
					</div>
				</div>
				
				
				
				<div class="row marginleftrightzero">
					<div class="form-group  marginleftrightzero ">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Recurring Frequency');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero positionRelativeselect">
							<?php echo $this->Form->input('recurring_frequency',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','placeholder'=>'Recurring Frequency'));?>
										
						</div>
					</div>
				</div>
				
				
				
				<div class="row marginleftrightzero">
					<div class="form-group  marginleftrightzero ">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Start Date');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero positionRelativeselect">
							                    <div class="input-group custom-datepicker widtherror errorwidgetlabeldate relative widtherrornew">
													<?php echo $this->Form->input('start_date',array('label'=>false,'div'=>false,'id'=>'start-date','class'=>'form-control date-picker','type'=>'text','data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $dateFormat),'readonly'=>'readonly','style'=>'cursor:default'));?>
													<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
												</div>
						</div>
					</div>
				</div>
				
				
				<div class="row marginleftrightzero">
					<div class="form-group  marginleftrightzero ">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('End Date');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero positionRelativeselect">
							    <div class="input-group custom-datepicker widtherror errorwidgetlabeldate relative widtherrornew">
													<?php echo $this->Form->input('end_date',array('div'=>false,'label'=>false,'class'=>'form-control date-picker','id'=>'end-date','type'=>'text','data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $dateFormat),'readonly'=>'readonly','style'=>'cursor:default'))?>
													<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
								</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="col-lg-4 no-padding-right  no-padding-left" id = "customerInfo">
				<div class="widget-box margintopzero">
					<div class="widget-header">
						<h5>Invoice to</h5>
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
					<tr id ="inventoryUpdateSelect-1">
						<td id = "td-inventoryUpdateSelect-1">
						<div class="form-group  marginleftrightzero margin-bottom-zero">
							<div class="col-sm-10 marginleftrightzero paddingleftrightzero countrybilling max-height max-width">
								<?php echo $this -> Form -> input('AcrClientInvoice.inventory.1', array('id' => 'inventory-1', 'div' => false, 'label' => false, 'data-live-search'=>'true','class'=>'form-control invdrop','data-placeholder'=>"Select inventory",'options' => array('' => '','-1'=>'Non Inventory Item', $inventoryList)));
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
								<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select" data-toggle="modal" data-target="#addnewunittype-<?php echo $rowId;?>">
									<i class="icon-plus"></i>
								</div>
							</div>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.description.1', array('div' => false, 'label' => false, 'class' => 'col-sm-12 tabletextarea','maxlength'=>'55', 'type' => 'textarea','rows'=>'2', 'placeholder' => 'Inventory description', 'readonly' => 'readonly')); ?>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.quantity.1', array('div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5 form-control', 'type' => 'text', 'id' => 'spinner1', 'readonly' => 'readonly')); ?>
							<label class="quotemeasurement"></label>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.unit_rate.1', array('div' => false, 'label' => false, 'class' => 'col-sm-10 form-control textright', 'type' => 'text', 'readonly' => 'readonly')); ?>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.discount_percent.1', array('div' => false, 'label' => false, 'class' => 'col-sm-10 form-control black textright', 'type' => 'text', 'readonly' => 'readonly')); ?>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<div class="col-sm-12 marginleftrightzero paddingleftrightzero countrybilling choosen_width">
								<?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.1', array('div' => false, 'label' => false, 'class' => 'form-control invdrop', 'data-placeholder'=>"Select Tax",'options' => array('' => '', $taxList), 'readonly' => 'readonly')); ?>
							</div>
						</div></td>
						<td>
							<div class="form-group marginleftrightzero margin-bottom-zero">
								<?php echo $this->Form->input('AcrClientInvoice.line_total.1',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','disabled'=>'disabled','readonly'=>'readonly'))?>
							</div>
						</td>
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
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="addtype-wrapper">
							<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> <em style="color:#ff0000;">&lowast;</em></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.name-',array('div'=>false,'label'=>false,'class'=>'col-xs-10 env-name'.$rowId.' col-sm-5 form-control','autocomplete'=>'off','type'=>'text','id'=>'orm-field-1','Placeholder'=>'Inventory name'));?>
						<p class="popup-error1">Please enter inventory name.</p>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.description-',array('div'=>false,'label'=>false,'rows'=>'2','type'=>'textarea','class'=>'form-control env-desc col-xs-10 col-sm-5 itemdescription','id'=>'form-field-2','autocomplete'=>'off','Placeholder'=>'Description of the inventory'));?>
					
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?><em style="color:#ff0000;">&lowast;</em></label>
					<div class="col-sm-8">
						<span>
					    	<?php echo $this->Form->hidden('addInventory.currency-',array('value'=>$defaultCurrency));?>
							<?php echo $this->Form->input('addInventory.code-',array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'form-control width30 col-xs-10 col-sm-5','value'=>$defaultCurrencyCode,'readonly'=>'readonly'))?>
						</span>
						<span>
							<?php echo $this->Form->input('addInventory.list_price-',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 width70 env-price'.$rowId.' col-sm-5 form-control','autocomplete'=>'off','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
						</span>
						<p class="popup-error2">Please enter inventory price.</p>
						<p class="popup-error4">Only numbers allowed</p>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group" >
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
					<div class="col-sm-8 max-height max-width choosen_width">
						<?php echo $this->Form->input('addInventory.tax_inventory-',array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 invdrop','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
					<div class="col-sm-8 choosen_width" id ="unit-type">
						<?php echo $this->Form->input('addInventory.unitType-',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select Unit Type",'options'=>array(''=>'',$unitTypeList)));?>
					</div>
					
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
					<div class="col-sm-8">
						<label>
							<?php echo $this->Form->checkbox('addInventory.track-',array('div'=>false,'label'=>false,'class'=>'ace checkBoxClick'));?>
							<span class="lbl"></span> </label>
						<label class="maillabel">Yes</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group currentstock" style="display: none;">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> <em style="color:#ff0000;">&lowast;</em></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.current_stock-',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control env-qty'.$rowId.' col-xs-10 col-sm-5','id'=>'form-field-4','autocomplete'=>'off','Placeholder'=>'Quantity of inventory  in stock'));?>
						<p class="popup-error3">Please enter current Stock.</p>
					</div>
				</div>
						</div>
					</div>
				</div>
				<div class="modal-footer paddingright8">
					<?php echo $this->Js->submit('Submit', array('id'=>'jsSubmit-','div'=>false,'class'=>'btn btn-info close-submit5','url' => array('controller'=>'inventories','action'=>'addInventory'),'escape'=>false,'update' => '#td-inventoryUpdateSelect-1'));?>
					
					<button class="btn close-popup btn-inverse" type="button">
						Cancel
					</button>
				</div>
				
				
				
				<script>
				$(document).ready(function(){
					  $(".invdrop option:contains('|--')").remove();
						$('#addnewunittype-<?php echo $rowId;?>').on('show.bs.modal', function (e) {
					  		$('.env-name<?php echo $rowId;?>, .env-price<?php echo $rowId;?>, .env-qty<?php echo $rowId;?>').val('');
					  		$('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
					  		$('#addInventoryTrack-').attr('checked', false); // Unchecks it
						});
						$( ".env-name<?php echo $rowId;?>, .env-price<?php echo $rowId;?>, .env-qty<?php echo $rowId;?>" ).focus(function() {
							$('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
						});
						
						$('.close-submit5').click(function(evt){
					    	 var value10 = $.trim($(".env-name<?php echo $rowId;?>").val());
					    	 if(value10.length === 0) {
					    	 	$('.popup-error1').show();
					    	 	evt.preventDefault();
						        $('#field').value();
					    	 }
							
						   
						     var value12 = $.trim($(".env-price<?php echo $rowId;?>").val());
					    	 if(value12.length === 0) {
					    	 	$('.popup-error2').show();
					    	 	evt.preventDefault();
						        $('#field').value();
					    	 }
					    	 
					    	 var value12 = $.trim($(".env-price<?php echo $rowId;?>").val());
					    	 if(!$.isNumeric(value12)) {
					    	// if(value7.length === 0) {
					    	 	$('.popup-error4').show();
					    	 	evt.preventDefault();
						        $('#field').value();
						    }
						    
					    	 if ($('#addInventoryTrack-').is(':checked')) {
					    	 var value13 = $.trim($(".env-qty<?php echo $rowId;?>").val());
					    	 if(value13.length === 0) {
					    	 	$('.popup-error3').show();
					    	 	evt.preventDefault();
						        $('#field').value();
					    	 }
					    	 }
					    	 
					     	$('#addnewunittype-<?php echo $rowId;?>').modal('hide');
					    });
						});				
					</script>
		</div>
	</div>
</div>
<!--end of pop-->
					</tr>
				
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
			<div class="col-sm-4 no-padding-right no-padding-left subtotal newsubtotal" id = "calculateFinal">
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
						<span class="left">In Invoice Currency</span>
						<span class="right bold statusopn">0.00</span>
					</div>
				</div>
				<div class="row marginleftrightzero ">
					<div class="row marginleftrightzero">
						<span class="left bold">Total</span>
					</div>
					<div class="row marginleftrightzero">
						<span class="left">In Subscriber Currency</span>
						<span class="right  bold statusopn">0.00</span>
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
						<?php echo $this->Form->input('AcrClientInvoice.terms',array('div'=>false,'label'=>false,'class'=>'termsandconditions','type'=>'textarea','value'=>$termsAndConditions))
					?>
					</div>
				</div>
			</div>
			<div class="row marginleftrightzero">
				<div class="form-group marginleftrightzero">
					<label  class="col-xs-12 col-sm-3 col-lg-2 control-label marginleftrightzero paddingleftrightzero">Customer Note</label>
					<div class="col-xs-12 col-sm-3 col-lg-10 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->input('AcrClientInvoice.note',array('div'=>false,'label'=>false,'class'=>'termsandconditions','type'=>'textarea','value'=>$defaultNotes))
					?>
					</div>
				</div>
			</div>
		</div>
		<?php if($getCustomFields):
	?>
	<div class="row marginleftrightzero paddingbottom20">
		<div class="row marginleftrightzero additionalinfo paddingbottom10">
			<h5><?php echo __('Additional Information'); ?></h5>
		</div>
		<div class="row marginleftrightzero">
			<?php foreach($getCustomFields as $fieldId=>$fieldVal):
			?>
			<div class="form-group marginleftrightzero paddingtop15">
				<label  class="col-xs-12 col-sm-3 col-lg-2 control-label marginleftrightzero paddingleftrightzero"><?php echo $fieldVal; ?></label>
				<div class="col-xs-12 col-sm-3 col-lg-4 marginleftrightzero paddingleftrightzero">
					<?php echo $this -> Form -> input('AcrClientInvoice.customField.' . $fieldId, array('div' => false, 'label' => false, 'class' => 'form-control', 'type' => 'text', 'placeholder' => $fieldVal)); ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>
		<div class="row marginleftrightzero paddingbottom20">
			<div class="clearfix form-actions margintopzero paddingtopzero no-padding-left no-padding-right">
				<div class="col-md-offset-3 col-md-6">
					<!--button class="btn btn-info" title="Mail" data-toggle="modal" data-target="#mail">
						<i class="icon-share-alt bigger-110"></i> Send Now
					</button-->
					<?php echo $this -> Form -> button(__('<i class="icon-save bigger-110"></i> Save Recurring Invoice'), array('url' => array('controller' => 'acr_client_recurring_invoices', 'action' => 'add'), 'div' => false, 'class' => 'btn btn-info saveQuote', 'name' => 'Save Invoice', 'value' => '1')); ?>
					<button class="btn btn-inverse" type="reset">
						<i class="icon-undo bigger-110"></i> Reset
					</button>
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
								  <?php echo $this -> Form -> button(__('<i class="icon-share-alt bigger-110"></i> Send Now'), array('controller' => 'acr_client_invoices', 'action' => 'add', 'div' => false, 'class' => 'btn btn-info left marginleftzero marginright14', 'name' => 'Send Now', 'value' => '1')); ?>
								  <button class="btn left marginleftzero popup-cancel" type="button"> <i class="icon-remove bigger-110"></i> Cancel </button>
							</div>
					</div>
			</div>
		</div>
<!--end of pop--> 
	<?php echo $this->Form->end();?>
</div>

<!-- /.page-content -->

<!-- inline scripts related to this page -->
<script type="text/javascript" >
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
		$('.close-popup').click(function(){
	     	$('.close').trigger('click');
	    });
	    $('.close-submit').click(function(){
	     	$('.close').trigger('click');
	     	//$('.form-control').val('');
	     	$( "#addInventoryTrack" ).prop( "checked", false );
	    });
        if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 
    	
    	$('.selectpicker').selectpicker().change(function(){
        	$(this).valid()
		});
		$('#start-date').change(function(){
        	$(this).valid()
		});
		$("#AcrClientInvoiceAddForm").validate({
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
				},
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
				}
				
			}
		});

		$('.date-picker').datepicker({
			autoclose : true,
		}).next().on(ace.click_event, function() {
			$(this).prev().focus();
		});

	}); 
</script>
<script type="text/javascript">
	$(document).ready(function(){
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
<?php echo $this -> Js -> writeBuffer(); ?>
