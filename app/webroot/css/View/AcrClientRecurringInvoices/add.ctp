<?php
$homeLink = $this -> Breadcrumb -> getLink('Home');
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
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('recurring_invoice_no',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'text','placeholder'=>'Invoice No.','value'=>$invoiceNumber));?>
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
						<div class="col-xs-12 col-sm-3 col-lg-6  margin-bottom-zero form-filter-field nopadding">
							<?php echo $this -> Form -> input('acr_client_id', array('id' => 'clientId', 'div' => false, 'label' => false, 'options' => array('' => 'Select Customer', $customer), 'class'=>'form-control selectpicker','data-placeholder' => "Customer List"));
									   $this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'customerInfo'), array('update' => '#customerInfo', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
							?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group  marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Currency');?></label>
						<div class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero countrybilling">
							<?php echo $this -> Form -> input('cpn_currency_id', array('id' => 'invoiceCurrencySelect', 'div' => false, 'label' => false, 'options' => array('' => 'Select Currency', $currencyList), 'default' => $defaultCurrency, 'class'=>'form-control selectpicker','data-placeholder' => "Currency List"));
									   $this -> Js -> get('#invoiceCurrencySelect') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'currencyInfo'), array('update' => '#invoiceCurrency', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
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
						<div class="col-xs-12 col-sm-3 col-lg-2  paddingleftrightzero">
							<sapn class="conversion">
								<?php echo $this -> Form -> hidden('defaultCurrencyId', array('value' => $defaultCurrency)); ?>
								<?php echo '1 ' . $defaultCurrencyCode; ?>
							</sapn>
						</div>
						<div class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('conversionValue',array('id'=>'conversionValue','div'=>false,'label'=>false,'type'=>'text','class'=>'form-control specialborder','placeholder'=>'Enter conversion value','value'=>'1'));
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
						<div class="col-xs-12 col-sm-3 col-lg-1 marginleftrightzero paddingleftrightzero">
							<sapn class="conversion" id ="invoiceCurrency">
								<?php echo $defaultCurrencyCode; ?>
							</sapn>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group  marginleftrightzero ">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Terms');?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this -> Form -> input('sbs_subscriber_payment_term_id', array('id' => 'paymentTems', 'div' => false, 'label' => false, 'options' => array('' => 'Select Term', $paymentTerm), 'class' => 'form-control selectpicker','data-placeholder' => "Select term"));
									   $this -> Js -> get('#paymentTems') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'findEndDate'), array('update' => '#dueDateUpdate', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
						    ?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 no-padding-right  no-padding-left" id = "customerInfo">
				<div class="widget-box margintopzero">
					<div class="widget-header">
						<h5>Invoice email to</h5>
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

			<div class="col-lg-4 no-padding-right  no-padding-left pull-right">
				<div class="widget-box margintopzero">
					<div class="widget-header">
						<h5><?php echo __('Recurring Invoice Settings');?></h5>
					</div>

					<div class="widget-body">
						<div class="widget-main paddingleftrightzero">
							<div class="form-horizontal">
								<div class="form-group  marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-6 control-label no-padding-right  " >
												<?php echo __('Recurring Period');?>
											</div>
											<div class="col-sm-4 control-label no-padding-right bold no-padding-left">
												<?php echo $this->Form->input('recurring_period',array('div'=>false,'label'=>false,'class'=>'form-control selectpicker','options'=>array(''=>'Select','Day'=>'Day','Week'=>'Week','Month'=>'Month','Year'=>'Year')));?>
												
											</div>
										</div>
									</div>
								</div>
								<div class="form-group marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-6 control-label no-padding-right  " >
												<?php echo __('Recurring Frequency');?>
											</div>
											<div class="col-sm-4 control-label no-padding-right bold no-padding-left " >
												<?php echo $this->Form->input('recurring_frequency',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','placeholder'=>'Recurring Frequency'));?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-4 control-label no-padding-right  " >
												<?php echo __('Start Date');?><em style="color:#ff0000;">&lowast;</em>
											</div>
											<div class="col-sm-6 control-label no-padding-right bold no-padding-left realstart" >
												<div class="input-group custom-datepicker widtherror errorwidgetlabeldate relative widtherrornew">
													<?php echo $this->Form->input('start_date',array('label'=>false,'div'=>false,'id'=>'start-date','class'=>'form-control date-picker','type'=>'text','data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default'));?>
													<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 no-padding-right no-padding-left">
											<div class="col-sm-4 control-label no-padding-right  " >
												<?php echo __('End Date');?>
											</div>
											<div class="col-sm-6 control-label no-padding-right bold no-padding-left " >
												<div class="input-group custom-datepicker widtherror widtherrornew">
													<?php echo $this->Form->input('end_date',array('div'=>false,'label'=>false,'class'=>'form-control date-picker','id'=>'end-date','type'=>'text','data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default'))?>
													<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
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
					<tr id ="inventoryUpdateSelect-1">
						<td id = "td-inventoryUpdateSelect-1">
						<div class="form-group  marginleftrightzero margin-bottom-zero">
							<div class="col-sm-10 marginleftrightzero paddingleftrightzero countrybilling">
								<?php echo $this -> Form -> input('AcrClientInvoice.inventory.1', array('id' => 'inventory-1', 'div' => false, 'label' => false, 'class'=>'form-control selectpicker','options' => array('' => 'Select inventory', $inventoryList)));
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
								<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select" data-toggle="modal" data-target="#addnewunittype-1">
									<i class="icon-plus"></i>
								</div>
							</div>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.description.1', array('div' => false, 'label' => false, 'class' => 'col-sm-12 tabletextarea', 'type' => 'textarea','rows'=>'3', 'placeholder' => 'Inventory description', 'readonly' => 'readonly')); ?>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.quantity.1', array('div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5 form-control', 'type' => 'text', 'id' => 'spinner1', 'readonly' => 'readonly')); ?>
							<label class="quotemeasurement">Kg</label>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.unit_rate.1', array('div' => false, 'label' => false, 'class' => 'col-sm-10 form-control', 'type' => 'text', 'readonly' => 'readonly')); ?>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this -> Form -> input('AcrClientInvoice.discount_percent.1', array('div' => false, 'label' => false, 'class' => 'col-sm-10 form-control', 'type' => 'number','max'=>"100", 'readonly' => 'readonly')); ?>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<div class="col-sm-12 marginleftrightzero paddingleftrightzero countrybilling">
								<?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.1', array('div' => false, 'label' => false, 'class' => 'form-control selectpicker', 'options' => array('' => 'Select Tax', $taxList), 'readonly' => 'readonly')); ?>
							</div>
						</div></td>
						<td>
						<div class="form-group marginleftrightzero margin-bottom-zero">
							<?php echo $this->Form->input('AcrClientInvoice.line_total.1',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','disabled'=>'disabled','readonly'=>'readonly'))?>
						</div></td>
					</tr>
					<!--Popup add  -->
						<div class="modal fade" id="addnewunittype-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog addunittype">
								<div class="modal-content">
									<div class="modal-header page-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
											<i class="icon-remove"></i>
										</button>
										<h1 class="modal-title" id="myModalLabel"><?php echo __('Add Unit Type');?></h1>
									</div>
										<div class="modal-body">
											<div class="model-body-inner-content">
												<div class="addtype-wrapper">
													<div class="form-group marginleftrightzero">
											<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> </label>
											<div class="col-sm-8 nopaddingleft nopaddingright">
												<?php echo $this->Form->input('addInventory.name',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','id'=>'orm-field-1','Placeholder'=>'Inventory name'));?>
											</div>
										</div>
										<div class="space-4"></div>
										<div class="form-group marginleftrightzero">
											<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
											<div class="col-sm-8 nopaddingleft nopaddingright">
												<?php echo $this->Form->input('addInventory.description',array('div'=>false,'label'=>false,'type'=>'textarea','class'=>'form-control col-xs-10 col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory'));?>
											</div>
										</div>
										<div class="space-4"></div>
										<div class="form-group marginleftrightzero">
											<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?></label>
											<div class="col-sm-8 nopaddingleft nopaddingright">
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
										<div class="form-group marginleftrightzero">
											<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
											<div class="col-sm-8 nopaddingleft nopaddingright countrybilling">
												<?php echo $this->Form->input('addInventory.tax_inventory',array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 selectpicker','options'=>array(''=>'Select Tax',$taxList)));?>
											</div>
										</div>
										<div class="space-4"></div>
										<div class="form-group marginleftrightzero">
											<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
											<div class="col-sm-8 nopaddingleft nopaddingright" id ="unit-type">
												<?php echo $this->Form->input('addInventory.unitType',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control selectpicker','options'=>array(''=>'Select Unit Type',$unitTypeList)));?>
											</div>
											
										</div>
										<div class="space-4"></div>
										<div class="form-group marginleftrightzero">
											<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
											<div class="col-sm-8 nopaddingleft nopaddingright">
												<label>
													<?php echo $this->Form->checkbox('addInventory.track',array('div'=>false,'label'=>false,'class'=>'ace'));?>
													<span class="lbl"></span> </label>
												<label class="maillabel">Yes</label>
											</div>
										</div>
										<div class="space-4"></div>
										<div class="form-group marginleftrightzero">
											<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> </label>
											<div class="col-sm-8 nopaddingleft nopaddingright">
												<?php echo $this->Form->input('addInventory.current_stock',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control col-xs-10 col-sm-5','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
											</div>
										</div>
												</div>
											</div>
										</div>
										<div class="modal-footer paddingright8">
											<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit','url' => array('controller'=>'inventories','action'=>'addInventory',1),'escape'=>false,'update' => '#td-inventoryUpdateSelect-1'));?>
											<!--<button class="btn btn-info" type="button">
												<i class="icon-ok bigger-110"></i>
												Submit
											</button>-->		
											<button class="btn close-popup btn-inverse" type="button">
												Cancel
											</button>
										</div>
								</div>
							</div>
						</div>
					<!--end of pop-->
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
						<?php echo $this->Form->input('AcrClientInvoice.terms',array('div'=>false,'label'=>false,'class'=>'termsandconditions','type'=>'textarea'))
					?>
					</div>
				</div>
			</div>
			<div class="row marginleftrightzero">
				<div class="form-group marginleftrightzero">
					<label  class="col-xs-12 col-sm-3 col-lg-2 control-label marginleftrightzero paddingleftrightzero">Customer Note</label>
					<div class="col-xs-12 col-sm-3 col-lg-10 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->input('AcrClientInvoice.note',array('div'=>false,'label'=>false,'class'=>'termsandconditions','type'=>'textarea'))
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
					<?php echo $this -> Form -> button(__('<i class="icon-save bigger-110"></i> Save Invoice'), array('url' => array('controller' => 'acr_client_recurring_invoices', 'action' => 'add'), 'div' => false, 'class' => 'btn btn-info', 'name' => 'Save Invoice', 'value' => '1')); ?>
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

<!--Popup add  -->
<div class="modal fade newmodel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog addunittype">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title" id="myModalLabel"><?php echo __('Add Unit Type');?></h1>
			</div>
			<?php /*echo $this->Form->create('addInventory',array('id'=>'addInventory','role'=>'form','class'=>'form-horizontal popup'));*/?>
				<div class="modal-body aaaaaa">
					<div class="model-body-inner-content">
						<div class="addtype-wrapper">
							<div class="form-group marginleftrightzero">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> </label>
					<div class="col-sm-8 nopaddingleft nopaddingright">
						<?php echo $this->Form->input('addInventory.name',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','id'=>'orm-field-1','Placeholder'=>'Inventory name'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group marginleftrightzero">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
					<div class="col-sm-8 nopaddingleft nopaddingright ">
						<?php echo $this->Form->input('addInventory.description',array('div'=>false,'label'=>false,'type'=>'textarea','class'=>'form-control col-xs-10 col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group marginleftrightzero">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?></label>
					<div class="col-sm-8 nopaddingleft nopaddingright">
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
				<div class="form-group marginleftrightzero">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
					<div class="col-sm-8 nopaddingleft nopaddingright countrybilling">
						<?php echo $this->Form->input('addInventory.tax_inventory',array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 selectpicker','options'=>array(''=>'Select Tax',$taxList)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group marginleftrightzero">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
					<div class="col-sm-8 nopaddingleft nopaddingright countrybilling" id ="unit-type">
						<?php echo $this->Form->input('addInventory.unitType',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control selectpicker','options'=>array(''=>'Select Unit Type',$unitTypeList)));?>
					</div>
					
				</div>
				<div class="space-4"></div>
				<div class="form-group marginleftrightzero">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
					<div class="col-sm-8 nopaddingleft nopaddingright">
						<label>
							<?php echo $this->Form->checkbox('addInventory.track',array('div'=>false,'label'=>false,'class'=>'ace'));?>
							<span class="lbl"></span> </label>
						<label class="maillabel">Yes</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group marginleftrightzero">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> </label>
					<div class="col-sm-8 nopaddingleft nopaddingright">
						<?php echo $this->Form->input('addInventory.current_stock',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control col-xs-10 col-sm-5','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
					</div>
				</div>
						</div>
					</div>
				</div>
				<div class="modal-footer paddingright8">
					<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info','url' => array('controller'=>'inventories','action'=>'addInventory',$rowId),'escape'=>false,'update' => '#td-inventoryUpdateSelect-1'));?>
					<!--<button class="btn btn-info" type="button">
						<i class="icon-ok bigger-110"></i>
						Submit
					</button>-->		
					<button class="btn close-popup btn-inverse" type="button">						
						Cancel
					</button>
				</div>
			<?php /*echo $this->form->end();*/?>
		</div>
	</div>
</div>
<!--end of pop-->
<!-- /.page-content -->

<!-- inline scripts related to this page -->
<script type="text/javascript" >
	$(document).ready(function() {
		$('.close-popup').click(function(){
	     	$('.close').trigger('click');
	    });
	    $('.close-submit').click(function(){
	     	$('.close').trigger('click');
	     	$('.form-control').val('');
	     	$( "#addInventoryTrack" ).prop( "checked", false );
	    });
        if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 
		$("#AcrClientInvoiceAddForm").validate({
			rules : {
				'data[AcrClientInvoice][invoice_number]' : {
					required : true
				},
				'data[AcrClientInvoice][acr_client_id]' : {
					required : true
				},
				'data[AcrClientInvoice][sbs_subscriber_payment_term_id]' : {
					required : true

				},
				'data[AcrClientInvoice][start_date]' : {
					required : true

				}
			},
			messages : {
				'data[AcrClientInvoice][name]' : {
					required : 'Please enter invoice number.',
					number : 'Invoice number should be numeric'
				},
				'data[AcrClientInvoice][acr_client_id]' : {
					required : 'Please select a client.'
				},
				'data[AcrClientInvoice][sbs_subscriber_payment_term_id]' : {
					required : 'Please select a payment term.'
				},
				'data[AcrClientInvoice][start_date]' : {
					required : 'Please enter a start date.'
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
</script>
<?php echo $this -> Js -> writeBuffer(); ?>
