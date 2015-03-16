
<td id = "td-inventoryUpdateSelect-<?php echo $rowId?>">
	<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
		<div class="col-sm-10 marginleftrightzero paddingleftrightzero ">
										<?php
											echo $this->Form->input('AcrClientInvoice.inventory.'.$rowId, array (
												'id' => 'inventory-'.$rowId,
												'class' => 'select_inventory',
												'div' => false,
												'label' => false, 'class'=>'chosen-select',
												'options' => array (
													'' => 'Select inventory',
													'-1'=>'Non Inventory',
													$inventoryList
												),'default'=>$inventoryId
											));
											$this->Js->get('#inventory-'.$rowId)->event('change', $this->Js->request(array (
												'controller' => 'acr_client_invoices',
												'action' => 'getInventoryDetails',$rowId
											), array (
												'update' => '#inventoryUpdateSelect-'.$rowId,
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
										 $this->Js->get('#inventory-'.$rowId)->event('change', $this->Js->request(array (
																	'controller' => 'acr_client_invoices',
																	'action' => 'calculateTotal',$rowId
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
	</div>
</td>
<td>
	<div class="form-group marginleftrightzero margin-bottom-zero">
		<?php echo $this->Form->input('AcrClientInvoice.description.'.$rowId,array('rows'=>'3','div'=>false,'label'=>false,'class'=>'col-sm-12 tabletextarea','type'=>'textarea','placeholder'=>'Inventory description','value'=>$inventoryDesc));?>
	</div>
</td>
<td>
	<div class="form-group marginleftrightzero margin-bottom-zero">
		<?php echo $this->Form->input('AcrClientInvoice.quantity.'.$rowId,array('id'=>'quantity-'.$rowId,'div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control quantityy width50 textright','type'=>'number',/*'id'=>'spinner1',*/'value'=>$inventoryQuantity));
				   $this->Js->get('#quantity-'.$rowId)->event('change', $this->Js->request(array (
						'controller' => 'acr_client_invoices',
						'action' => 'getLineTotal',$rowId
					), array (
						'update' => '#lineTotal-'.$rowId,
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
			 $this->Js->get('#quantity-'.$rowId)->event('change', $this->Js->request(array (
					'controller' => 'acr_client_invoices',
					'action' => 'calculateTotal',$rowId
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
		<?php echo $this->Form->hidden('AcrClientInvoice.unitTypeofInventory.'.$rowId,array('value'=>$inventoryUnitType));?>
	</div>
</td>
<td>
	<div class="form-group marginleftrightzero margin-bottom-zero">
		<?php echo $this->Form->input('AcrClientInvoice.unit_rate.'.$rowId,array('id'=>'rate-'.$rowId,'div'=>false,'label'=>false,'class'=>'col-sm-10 form-control unitpricee','type'=>'number','value'=>$inventoryRate));
				   $this->Js->get('#rate-'.$rowId)->event('keyup', $this->Js->request(array (
						'controller' => 'acr_client_invoices',
						'action' => 'getLineTotal',$rowId
					), array (
						'update' => '#lineTotal-'.$rowId,
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
			 $this->Js->get('#rate-'.$rowId)->event('keyup', $this->Js->request(array (
					'controller' => 'acr_client_invoices',
					'action' => 'calculateTotal',$rowId
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
		<?php echo $this->Form->input('AcrClientInvoice.discount_percent.'.$rowId,array('id'=>'discount-'.$rowId,'div'=>false,'label'=>false,'class'=>'col-sm-10 form-control discountt','type'=>'float', 'max'=>"100"));
				   $this->Js->get('#discount-'.$rowId)->event('keyup', $this->Js->request(array (
						'controller' => 'acr_client_invoices',
						'action' => 'getLineTotal',$rowId
					), array (
						'update' => '#lineTotal-'.$rowId,
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
			 $this->Js->get('#discount-'.$rowId)->event('keyup', $this->Js->request(array (
					'controller' => 'acr_client_invoices',
					'action' => 'calculateTotal',$rowId
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
	<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
		<div class="col-sm-12 marginleftrightzero paddingleftrightzero">
			<?php echo $this->Form->input('AcrClientInvoice.tax_inventory.'.$rowId,array('id'=>'tax-'.$rowId,'div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 chosen-select','options'=>array(''=>'Select Tax',$taxList),'selected'=>$taxId));
					   $this->Js->get('#tax-'.$rowId)->event('change', $this->Js->request(array (
						'controller' => 'acr_client_invoices',
						'action' => 'calculateTotal',$rowId
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
	<div class="form-group marginleftrightzero margin-bottom-zero" id = "lineTotal-<?php echo $rowId;?>">
		<?php echo $this->Form->input('AcrClientInvoice.line_total.'.$rowId,array('div'=>false,'label'=>false,'class'=>'amounttoal col-xs-10 col-sm-5 form-control','type'=>'text','disabled'=>'disabled','value'=>$inventoryRate))?>
		<?php echo $this->Form->hidden('AcrClientInvoice.line_total_hidden.'.$rowId,array('value'=>$inventoryRate));?>
	</div>
		<!--Popup add  -->
<div class="modal fade" id="addnewunittype-<?php echo $rowId?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog addunittype">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title" id="myModalLabel"><?php echo __('Add Unit Type');?></h1>
			</div>
			<?php /*echo $this->Form->create('addInventory',array('id'=>'addInventory','role'=>'form','class'=>'form-horizontal popup'));*/?>
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="addtype-wrapper">
							<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> </label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.name',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','id'=>'orm-field-1','Placeholder'=>'Inventory name'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.description',array('div'=>false,'label'=>false,'type'=>'textarea','class'=>'form-control col-xs-10 col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory'));?>
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
							<?php echo $this->Form->input('addInventory.list_price',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 width70 col-sm-5 form-control unitpricee','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
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
						<?php echo $this->Form->input('addInventory.current_stock',array('div'=>false,'label'=>false,'type'=>'number','class'=>'form-control col-xs-10 col-sm-5','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
					</div>
				</div>
						</div>
					</div>
				</div>
				<div class="modal-footer paddingright8">
					<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info','url' => array('controller'=>'inventories','action'=>'addInventory',$rowId),'escape'=>false,'update' => '#td-inventoryUpdateSelect-'.$rowId));?>
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
</td>


<?php echo $this->Js->writeBuffer();?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".chosen-select").chosen();
	});
	
</script>
