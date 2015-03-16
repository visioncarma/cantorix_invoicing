<?php
if(!$rowId){$rowId = 1;}
?>
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
			<?php echo $this -> Html -> link('<i class="icon-home home-icon"></i>Home', "$homeLink", array('escape' => FALSE)); ?>
		</li>
		<li>
			<?php echo $this -> Html -> link('Invoices', $this -> request -> referer(), array('div' => false, 'escape' => false)); ?>
		</li>
		<li class="active">
			<?php echo __('Add Invoice'); ?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1 > <?php echo __('Add New Invoice'); ?> </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i>Back', array('action' => 'index'), array('class' => 'btn btn-sm btn-success pull-right addbutton', 'escape' => FALSE)); ?>
		</div>
	</div>
	<!-- page heaqder-->
	<?php echo $this -> Form -> create('AcrClientInvoice', array('class' => 'form-horizontal formdetails', 'role' => 'form')); ?>
	<div class="row marginleftrightzero">
			<div class="col-lg-8 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Invoice No'); ?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero" id = "invoiceNumber">
							<?php echo $this -> Form -> input('invoice_number', array('id' => 'invNumber', 'div' => false, 'label' => false, 'type' => 'text','autocomplete'=>'off', 'class' => 'form-control', 'placeholder' => 'Invoice no.','value'=>$invoiceNumber));
									   $this -> Js -> get('#invNumber') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'invoiceNumberExist'), array('update' => '#invoiceNumber', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
							?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Purchase Order No.'); ?> #</label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('purchase_order_no',array('div'=>false,'label'=>false,'type'=>'text','autocomplete'=>'off','class'=>'form-control','placeholder'=>'Purchase order no.'))?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Invoice Description'); ?></label>
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('invoice_description',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','autocomplete'=>'off','placeholder'=>'Invoice description'))?>
						</div>
					</div>
				</div>
				<?php if(($invoiceData['AcrClientInvoice']['status'] == "Draft") || ($invoiceData['AcrClientInvoice']['status'] == "Open")):?>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Invoice Status'); ?></label>
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero choosen_width">
							<?php echo $this -> Form -> input('invoice_status', array('div' => false, 'label' => false, 'class' => 'invdrop form-control', 'data-placeholder' => "Select Status", 'options' => array('' => '', 'Draft' => 'Draft', 'Open' => 'Open'), 'default' => $invoiceData['AcrClientInvoice']['status'])); ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero relative">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Customer'); ?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-6 marginleftrightzero paddingleftrightzero labelerror countrybilling max-height max-width choosen_width">
							
							<?php echo $this -> Form -> input('acr_client_id', array('id' => 'clientId', 'div' => false, 'label' => false, 'options' => array('' => '', $customer),'data-live-search' => 'true',  'class'=>'form-control invdrop','data-placeholder' => "Select Customer"));
								   $this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'customerInfo'), array('update' => '#customerInfo', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));?>
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
						<?php
								$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getClientCurrency'), array('update' => '#currencyDiv', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true))))); 
						?>
						<?php
								$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getDefaultPaymentTerm'), array('update' => '#paymentTerm', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true))))); 
						?>
						<?php 
							$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'findEndDate'), array('update' => '#dueDateUpdate', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
						?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero" id = "currencyDiv">
					<div class="form-group  marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Currency Code'); ?></label>
						<div class="col-xs-12 col-sm-3 col-lg-2 marginleftrightzero paddingleftrightzero countrybilling max-height max-width choosen_width">
							<?php echo $this -> Form -> input('cpn_currency_id', array('id' => 'invoiceCurrencySelect', 'div' => false, 'label' => false, 'options' => array('' => '', $currencyList), 'default' => $defaultCurrency, 'data-live-search' => 'true', 'class'=>'form-control invdrop','data-placeholder' => "Select Currency",'disabled'=>'disabled'));
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
						<?php
								$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getClientCurrency'), array('update' => '#currencyDiv', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true))))); 
						?>
						<?php
								$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getDefaultPaymentTerm'), array('update' => '#paymentTerm', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true))))); 
						?>
						<?php 
							$this -> Js -> get('#clientId') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'findEndDate'), array('update' => '#dueDateUpdate', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
						?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Issue Date'); ?><em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker datewidth">
								
								<?php 
									$dbFormat = array("d", "M", "Y");
									$scriptFormat   = array("dd", "mm", "yyyy");
								?>
								<?php echo $this->Form->input('AcrClientInvoice.invoiced_date',array('id'=>'invoice-date','div'=>false,'label'=>false,'type'=>'text', 'class'=>'form-control date-picker','data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $settings['SbsSubscriberSetting']['date_format']),'default'=>date($dateFormat,strtotime(date('Y-m-d')))));?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
								<?php $this -> Js -> get('#invoice-date') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'findEndDate'), array('update' => '#dueDateUpdate', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true))))); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero relative">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Terms'); ?> <em style="color:#ff0000;">∗</em></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero labelerror choosen_width" id = "paymentTerm">
							<?php echo $this -> Form -> input('sbs_subscriber_payment_term_id', array('id' => 'paymentTems', 'div' => false, 'label' => false, 'options' => array('' => '', $paymentTerm), 'class'=>'form-control invdrop','data-placeholder' => "Select Terms"));
									   $this -> Js -> get('#paymentTems') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'findEndDate'), array('update' => '#dueDateUpdate', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
							?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero" >
					<div class="form-group marginleftrightzero">
						<label  class="col-xs-12 col-sm-3 col-lg-3 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Expiry Date'); ?></label>
						<div class="col-xs-12 col-sm-3 col-lg-3 marginleftrightzero paddingleftrightzero" id ="dueDateUpdate">
						<?php echo $this->Form->input('due_date',array('div'=>false,'label'=>false,'autocomplete'=>'off','type'=>'text','class'=>'form-control','disabled'=>'disabled'))
						?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 no-padding-right  no-padding-left" id ="customerInfo">
				<div class="widget-box">
					<div class="widget-header">
						<h5>Invoice to</h5>
					</div>
	
					<div class="widget-body">
						<div class="widget-main paddingleftrightzero">
							<div class="form-horizontal">
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
											<div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
												Contact Name
											</div>
											<div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " ></div>
										</div>
									</div>
								</div>
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
											<div class="col-sm-5 col-xs-5 no-padding-right  " >
												Contact Surname
											</div>
											<div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " ></div>
										</div>
									</div>
								</div>
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
											<div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
												Contact Email
											</div>
											<div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " ></div>
										</div>
									</div>
								</div>
								<div class="form-group borderline marginleftrightzero">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
											<div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
												Mobile
											</div>
											<div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " >
	
											</div>
										</div>
									</div>
								</div>
								<div class="form-group  marginleftrightzero borderline">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
											<div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
												Home Phone
											</div>
											<div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " >
	
											</div>
										</div>
									</div>
								</div>
								<div class="form-group  marginleftrightzero lastrow">
									<div class="row marginleftrightzero">
										<div class="col-sm-12 col-xs-12 no-padding-right no-padding-left">
											<div class="col-sm-5 col-xs-5 control-label no-padding-right  " >
												Work Phone
											</div>
											<div class="col-sm-7 col-xs-7 control-label no-padding-right bold no-padding-left " >
	
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
		
		
		<!--   start table part   -->
			
				<div class="table-small-view new-table-small new_table_small_view new_table_small_view_new" id = "inventoryUpdateSelect-1">
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Item </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero" id = "td-inventoryUpdateSelect-1">
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero choosen_width" >
									<?php echo $this -> Form -> input('AcrClientInvoice.inventory.1', array('id' => 'inventory-1', 'div' => false, 'data-live-search'=>'true','label' => false, 'class'=>'form-control invdrop','options' => array('' => 'Select inventory','-1'=>'Non Inventory Item',$inventoryList)));
											   $this -> Js -> get('#inventory-1') -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getInventoryDetails', 1), array('update' => '#inventoryUpdateSelect-1', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
									?>
									<?php
										$this->Js->get('#inventory-1')->event('change', $this->Js->request(array (
											'controller' => 'acr_client_invoices',
											'action' => 'calculateTotal',1
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
								<?php if(($inventoryPermission['_create'] == '1') || ($inventoryPermission['_update'] == '1')):?>
								<div class="col-xs-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
									<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select" data-toggle="modal" data-target="#addnewunittype-<?php echo $rowId;?>">
										<i class="icon-plus"></i>
									</div>
								</div>
								<?php endif;?>	
							</div>	
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Item Description </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group marginleftrightzero margin-bottom-zero">
								<?php echo $this -> Form -> input('AcrClientInvoice.description.1', array('div' => false, 'label' => false, 'class' => 'col-xs-10', 'type' => 'textarea','rows'=>'2', 'placeholder' => 'Inventory description', 'readonly' => 'readonly')); ?>
							</div>
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Qty </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
								<?php echo $this -> Form -> input('AcrClientInvoice.quantity.1', array('div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5 form-control text-right', 'type' => 'text', 'id' => 'spinner1','autocomplete'=>'off', 'readonly' => 'readonly')); ?>
							</div>
							<div class="col-xs-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
								<label class="quotemeasurement"></label>
							</div>
							
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Unit Price </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group marginleftrightzero margin-bottom-zero">
								
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
									<?php echo $this -> Form -> input('AcrClientInvoice.unit_rate.1', array('div' => false, 'label' => false, 'class' => 'col-sm-10 form-control text-right', 'type' => 'text','autocomplete'=>'off', 'readonly' => 'readonly')); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Discount % </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group marginleftrightzero margin-bottom-zero">
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
									<?php echo $this -> Form -> input('AcrClientInvoice.discount_percent.1', array('div' => false, 'label' => false, 'class' => 'col-sm-10 form-control discountMax black text-right', 'autocomplete'=>'off','type' => 'text','readonly' => 'readonly')); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13">Tax </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
								
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero choosen_width">
									<?php echo $this -> Form -> input('AcrClientInvoice.tax_inventory.1', array('div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select Tax", 'options' => array('' => '', $taxList), 'readonly' => 'readonly')); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13">Amount </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group marginleftrightzero margin-bottom-zero">
								
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
									<?php echo $this->Form->input('AcrClientInvoice.line_total.1',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control text-right','type'=>'text','autocomplete'=>'off','disabled'=>'disabled','readonly'=>'readonly'))
									?>
								</div>
	                        </div>
						</div>
					</div>
					
				</div>


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
						<?php echo $this->Form->input('addInventory.editName-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'col-xs-10 env-name-'.$rowId.' col-sm-5 form-control','type'=>'text','id'=>'orm-field-1','autocomplete'=>'off','Placeholder'=>'Inventory name'));?>
						<p class="popup-error1">Please enter inventory name.</p>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.editDescription-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'type'=>'textarea','rows'=>'2','class'=>'form-control col-xs-10 env-desc-'.$detailVal['AcrInvoiceDetail']['id'].' col-sm-5 itemdescription','id'=>'form-field-2','autocomplete'=>'off','Placeholder'=>'Description of the inventory'));?>
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
							<?php echo $this->Form->input('addInventory.editList_price-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 env-price-'.$rowId.' width70 col-sm-5 form-control','autocomplete'=>'off','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
						</span>
						<p class="popup-error2">Please enter inventory price.</p>
						<p class="popup-error4">Only numbers allowed</p>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
					<div class="col-sm-8 max-height max-width choosen_width">
						<?php echo $this->Form->input('addInventory.editTax_inventory-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 invdrop ','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
					<div class="col-sm-8 choosen_width" id ="unit-type">
						<?php echo $this->Form->input('addInventory.editUnitType-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select Unit Type",'options'=>array(''=>'',$unitTypeList)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
					<div class="col-sm-8">
						<label>
							<?php echo $this->Form->checkbox('editTrack-'.$rowId,array('div'=>false,'label'=>false,'class'=>'ace checkBoxClick'));?>
							<span class="lbl"></span> </label>
						<label class="maillabel">Yes</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group currentstock" style="display: none;">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> <em style="color:#ff0000;">&lowast;</em> </label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.editCurrent_stock-'.$detailVal['AcrInvoiceDetail']['id'],array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control env-qty-'.$rowId.' col-xs-10 col-sm-5','id'=>'form-field-4','autocomplete'=>'off','Placeholder'=>'Quantity of inventory  in stock'));?>
						<p class="popup-error3">Please enter current Stock.</p>
					</div>
				</div>
						</div>
					</div>
				</div>
				<div class="modal-footer paddingright8">
					<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit2','url' => array('controller'=>'inventories','action'=>'addInventory'),'escape'=>false,'update' => '#td-inventoryUpdateSelect-1'));?>
					<button class="btn close-popup btn-inverse" type="button">
						Cancel
					</button>
				</div>
				
				<script>
				$(document).ready(function(){
					$(".invdrop option:contains('|--')").remove();
					$('#addnewunittype-<?php echo $rowId;?>').on('show.bs.modal', function (e) {
				  		$('.env-name-<?php echo $rowId;?>, .env-price-<?php echo $rowId;?>, .env-qty-<?php echo $rowId;?>').val('');
				  		$('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
				  		$('.currentstock').hide();
				  		$('#AcrClientInvoiceEditTrack-<?php echo $rowId;?>').attr('checked', false); // Unchecks it
					});
					$( ".env-name-<?php echo $rowId;?>, .env-price-<?php echo $rowId;?>, .env-qty-<?php echo $rowId;?>" ).focus(function() {
						$('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
					});
					
					$('.close-submit2').click(function(evt){
				    	 var value10 = $.trim($(".env-name-<?php echo $rowId;?>").val());
				    	 if(value10.length === 0) {
				    	 	$('.popup-error1').show();
				    	 	evt.preventDefault();
					        $('#field').value();
				    	 }
												   
					     var value12 = $.trim($(".env-price-<?php echo $rowId;?>").val());
				    	 if(value12.length === 0) {
				    	 	$('.popup-error2').show();
				    	 	evt.preventDefault();
					        $('#field').value();
				    	 }
				    	 
				    	 var value12 = $.trim($(".env-price-<?php echo $rowId;?>").val());
				    	 if(!$.isNumeric(value12)) {
				    	// if(value7.length === 0) {
				    	 	$('.popup-error4').show();
				    	 	evt.preventDefault();
					        $('#field').value();
					    }
					    
				    	 if ($('#AcrClientInvoiceEditTrack-<?php echo $rowId;?>').is(':checked')) {
				    	 var value13 = $.trim($(".env-qty-<?php echo $rowId;?>").val());
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
<div id="newappend"></div>
		  
			
		<!--   End table part   -->
		
		
		<!--start of subtotal area -->
		<div class="row marginleftrightzero paddingbottom20 credit_note_style">
			<div class="col-sm-8 no-padding-right no-padding-left paddingtop15 marginright45new">
				<div class="btn btn-sm btn-success pull-left addbutton addunitpadding add-row">
					<i class="icon-plus"></i>
				</div>
				<label class="addcontact">Add More</label>
			</div>
               <div class="col-sm-12 col-xs-12 col-md-12 no-padding-right no-padding-left subtotal" id = "calculateFinal"> 
                <div class="row marginleftrightzero borderon padding_right5 padding_left_zero_subtotal">
                 <div class="row marginleftrightzero padding_right5 padding_left12_subtotal_row padding_right11_subtotal_row">
                   <span class="left bold">Subtotal</span>
                   <span class="right bold">0.00</span>
                 </div>
                 
                </div> 
                <div class="row marginleftrightzero borderon padding_right5 padding_left_zero_subtotal">
                 <div class="row marginleftrightzero padding_left12_subtotal_row padding_right11_subtotal_row">
                   <span class="left bold">Total</span>
                 </div>
                 <div class="row marginleftrightzero padding_right5 padding_left12_subtotal_row padding_right11_subtotal_row">
                   <span class="left">In Invoice Currency</span>
                   <span class="right bold statusopn">0.00</span>
                 </div>
                </div>
                <div class="row marginleftrightzero padding_right5 padding_left_zero_subtotal">
                 <div class="row marginleftrightzero padding_right5 padding_left12_subtotal_row padding_right11_subtotal_row">
                   <span class="left bold">Total</span>
                 </div>
                 <div class="row marginleftrightzero padding_right5 padding_left12_subtotal_row padding_right11_subtotal_row">
                   <span class="left">In Subscriber Currency</span>
                   <span class="right  bold statusopn">0.00</span>
                 </div>
                </div>
              </div>
           </div>
           
           <!--end of subtotal area -->
            
            <div class="row marginleftrightzero borderblue paddingbottom20 linewidth">
           	</div>
           
           <div class="row marginleftrightzero paddingbottom20 paddingtop25">
           		<div class="row marginleftrightzero">
           			<div class="form-group marginleftrightzero">
           				<label class="col-sm-2 control-label marginleftrightzero paddingleftrightzero">Terms and Conditions</label>
           				<div class="col-sm-10 marginleftrightzero paddingleftrightzero">
           					<?php echo $this->Form->input('AcrClientInvoice.terms',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'textarea','value'=>$termsAndConditions))?>
           				</div>
           			</div>
           		</div>
           		<div class="row marginleftrightzero">
           			<div class="form-group marginleftrightzero">
           				<label class="col-sm-2 control-label marginleftrightzero paddingleftrightzero">Customer Note</label>
           				<div class="col-sm-10 marginleftrightzero paddingleftrightzero">
           					<?php echo $this->Form->input('AcrClientInvoice.note',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'textarea','value'=>$defaultNotes))?>
           				</div>
           			</div>
           		</div>
           </div>
		   <?php if($getCustomFields):?>
		   <div class="row marginleftrightzero paddingbottom20">
		   		<div class="row marginleftrightzero additionalinfo paddingbottom10">
		   			<h5>Additional Information</h5>
		   		</div>
		   		<div class="row marginleftrightzero">
		   			<?php foreach($getCustomFields as $fieldId=>$fieldVal):?>
		   			<div class="form-group marginleftrightzero paddingtop15">
		   				<label class="col-sm-2 control-label marginleftrightzero paddingleftrightzero"><?php echo $fieldVal;?></label>
		   				<div class="col-sm-4 marginleftrightzero paddingleftrightzero">
		   					<?php echo $this->Form->input('AcrClientInvoice.customField.'.$fieldId,array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'text','placeholder'=>$fieldVal,'value'=>$getCustomFieldsVal[$fieldId]));?>
		   				</div>
		   			</div>
		   			<?php endforeach;?>
		   		</div>
		   </div>
		   <?php endif; ?>
		
		   <div class="row marginleftrightzero paddingbottom20 footerbutton">
			<div class="clearfix form-actions margintopzero paddingtopzero no-padding-left no-padding-right">
				<div class="col-md-offset-3 col-md-6">
					<button class="btn btn-info button_mobile" title="Mail" data-toggle="modal" data-target="#mail">
						<i class="icon-share-alt bigger-110"></i> Send Now
					</button>
					<?php echo $this -> Form -> button(__('<i class="icon-save bigger-110"></i> Save Invoice'), array('url' => array('controller' => 'acr_client_invoices', 'action' => 'add'), 'div' => false, 'class' => 'btn btn-info saveQuote button_mobile', 'name' => 'Save Invoice', 'value' => '1')); ?>
					<button class="btn btn-inverse button_mobile" type="reset">
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
						<div class="form-horizontal popup">	
							<div class="modal-body">
								<div class="model-body-inner-content">
								    <div class="form-group login-form-group">
								         <p><?php echo __('Please select the Template to continue');?></p>
								    </div>
								    <div class="form-group filed-left margin-bottom-zero drop-down choosen_width">
								    	<?php echo $this->Form->input('template',array('div'=>false,'label'=>false,'class'=>'form-control invdrop','data-placeholder'=>'Email Template','options'=>array('sent_invoice'=>'Classic Product Template','sent_invoice_modern'=>'Modern Product Template','sent_invoice_service_classic'=>'Classic Service Template','sent_invoice_service_modern'=>'Modern Service Template')));?>
								    </div>
								 </div>
							</div>
							<div class="modal-footer">
								 <!--button class="btn btn-success addbutton left marginleftzero marginright14" type="button"> <i class="icon-zoom-in bigger-110"></i> Preview </button-->
								  <?php echo  $this->Form->button(__('<i class="icon-share-alt bigger-110"></i> Send Now'),array('url'=>array('controller'=>'acr_client_invoices','action'=>'edit',$detailVal['AcrInvoiceDetail']['id']),'div'=>false,'class' => 'btn btn-info left marginleftzero marginright4 padding0 close-submit','name'=>'Send Now','value'=>'1'));?>
								  <button class="btn btn-success addbutton left marginleftzero  marginright4 padding0 sendnow" style="font-size:13px;" title="Send Now" data-toggle="modal" data-target="#preview">
									<i class="icon-zoom-in bigger-110"></i> Preview
				 				  </button> 
				 				  <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright4 padding0','style'=>'font-size:13px;','url' => array('controller'=>'AcrClientInvoices','action'=>'preview'),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'));?>
								  <button class="btn left marginleftzero popup-cancel marginright4 padding0" style="font-size:13px;" type="button"> <i class="icon-remove bigger-110"></i> Cancel </button>
							</div>
						</div>	
					</div>
			</div>
		</div>
<!--end of pop-->
		
		<?php echo $this -> Form -> end(); ?>
	
	
	
</div>	
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
	jQuery(function($) {
		$(".chosen-select").chosen();
	});
	$(document).ready(function() {
		$('.date-picker').datepicker({
			autoclose : true
		}).next().on(ace.click_event, function() {
			$(this).prev().focus();
		});
		if ($('.selectpicker').length) {
			$('.selectpicker').selectpicker({
			});
		}
		
		/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
	}); 
</script>

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
		
		$('.selectpicker').selectpicker().change(function(){
        	$(this).valid()
		});
		
		$("#AcrClientInvoiceAddForm").validate({
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
		
		//$('.date-picker').datepicker('update');

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
                  $('#newappend').append(data).fadeIn('slow');
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