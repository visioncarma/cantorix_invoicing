<td id = "td-inventoryUpdateSelect-<?php echo $rowId?>">
	<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
		<div class="col-sm-10 marginleftrightzero paddingleftrightzero countrybilling max-height max-width">
										<?php
											echo $this->Form->input('AcrClientInvoice.inventory.'.$rowId, array (
												'id' => 'inventory-'.$rowId,
												'class' => 'select_inventory',
												'data-live-search'=>true,
												'div' => false,
												'label' => false, 'class'=>'invdrop form-control',
												'options' => array (
													'' => '',
													'-1'=>'Non Inventory',
													$inventoryList
												),'default'=>$inventoryId
											));
											$this->Js->get('#inventory-'.$rowId)->event('change', $this->Js->request(array (
												'controller' => 'acr_client_invoices',
												'action' => 'getInventoryDetails',$rowId,$invoiceDetailId
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
		<?php if(($inventoryPermission['_create'] == '1') || ($inventoryPermission['_update'] == '1')):?>
		<div class="col-sm-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
			<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select" data-toggle="modal" data-target="#addnewunittype-<?php echo $rowId;?>">
				<i class="icon-plus"></i>
			</div>
		</div>
		<?php endif;?>
	</div>
</td>
<td>
	<div class="form-group marginleftrightzero margin-bottom-zero">
		<?php 
			if($inventoryDesc){
			}else{
				$inventoryDesc = '';
			}
		?>
		<?php echo $this->Form->input('AcrClientInvoice.description.'.$rowId,array('rows'=>'2','div'=>false,'label'=>false,'class'=>'col-sm-12 tabletextarea','type'=>'textarea','autocomplete'=>'off','placeholder'=>'Inventory description','maxlength'=>'56','value'=>$inventoryDesc));?>
	</div>
	
</td>
<td>
	<div class="form-group marginleftrightzero margin-bottom-zero">
		<?php
			if(!$inventoryQuantity){
				$inventoryQuantity = '';
			} 
		?>
		<?php echo $this->Form->input('AcrClientInvoice.quantity.'.$rowId,array('id'=>'quantity-'.$rowId,'div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control quantityy textright','type'=>'text',/*'id'=>'spinner1',*/'value'=>$inventoryQuantity));
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
		<?php if(!$inventoryRate){
			$inventoryRate = '';
		}?>
		<?php echo $this->Form->input('AcrClientInvoice.unit_rate.'.$rowId,array('id'=>'rate-'.$rowId,'div'=>false,'label'=>false,'class'=>'col-sm-10 form-control unitpricee textright','type'=>'text','value'=>$inventoryRate));
				   $this->Js->get('#rate-'.$rowId)->event('change', $this->Js->request(array (
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
			 $this->Js->get('#rate-'.$rowId)->event('change', $this->Js->request(array (
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
		<?php echo $this->Form->input('AcrClientInvoice.discount_percent.'.$rowId,array('id'=>'discount-'.$rowId,'div'=>false,'label'=>false,'class'=>'col-sm-10 form-control discountt black textright','onkeyup'=>'this.value = minmax(this.value, 0, 100)','value'=>'','type'=>'text'));
				   $this->Js->get('#discount-'.$rowId)->event('change', $this->Js->request(array (
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
			 $this->Js->get('#discount-'.$rowId)->event('change', $this->Js->request(array (
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
			<?php if(!$taxId){$taxId = '';}?>
			<?php echo $this->Form->input('AcrClientInvoice.tax_inventory.'.$rowId,array('id'=>'tax-'.$rowId,'div'=>false,'label'=>false,'data-placeholder'=>"Select Tax",'class'=>'col-xs-10 col-sm-5 invdrop form-control','options'=>array(''=>'',$taxList),'selected'=>$taxId));
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
	<div class="form-group marginleftrightzero margin-bottom-zero " id = "lineTotal-<?php echo $rowId;?>">
		<?php echo $this->Form->input('AcrClientInvoice.line_total.'.$rowId,array('div'=>false,'label'=>false,'class'=>'amounttoal col-xs-10 col-sm-5 form-control textright black','type'=>'text','disabled'=>'disabled','value'=>$inventoryRate))?>
		<?php echo $this->Form->hidden('AcrClientInvoice.line_total_hidden.'.$rowId,array('value'=>$inventoryRate));?>
		<?php echo $this -> Form -> hidden('AcrClientInvoice.product_id.'.$rowId,array('value'=>$invoiceDetailId));?>
	</div>
	
</td>
<td class="textleft">
	<!--a href="#" class="textdecoration_none deleteinvocerow" id = "link-<?php echo $rowId;?>">
		<i class="icon-trash bigger-120" style="color:#F00;"></i>
	</a-->
	<?php
	if($invoiceDetailId  && !$quoteFlag){
		echo $this -> Js -> link('<i style="color:#F00;" class="icon-trash bigger-120"></i>',  
				array('controller' => 'acr_client_invoices', 'action' => 'deleteRow1',$rowId,$invoiceDetailId),
				array('id'=>'link-'.$rowId,'class'=>'textdecoration_none deleteinvocerow','escape' => FALSE, 'update' => '#inventoryUpdateSelect-'.$rowId,'title'=>'Delete Item','confirm'=>'Are you sure you want to remove this item?',
				'success'=>  $this->Js->request(array (
													'controller' => 'acr_client_invoices',
													'action' => 'calculateTotalAfterDelete',$rowId
												), array (
													'update' => '#calculateFinal',
													'async' => true,
													'dataExpression' => true,
													'method' => 'post',
													'data' => $this->Js->serializeForm(array (
													'isForm' => false,
													'inline' => true
												))
											))
											));
	} elseif($invoiceDetailId  && $quoteFlag) {
		echo $this -> Js -> link('<i style="color:#F00;" class="icon-trash bigger-120"></i>',   
				array('controller' => 'quotes', 'action' => 'deleteRow',$rowId,$invoiceDetailId),
				array('id'=>'link-'.$rowId,'class'=>'textdecoration_none deleteinvocerow','escape' => FALSE,'update' => '#inventoryUpdateSelect-'.$rowId,'title'=>'Delete Item','confirm'=>'Are you sure you want to remove this item?',
					'success'=>  $this->Js->request(array (
													'controller' => 'acr_client_invoices',
													'action' => 'calculateTotalAfterDelete',$rowId
												), array (
													'update' => '#calculateFinal',
													'async' => true,
													'dataExpression' => true,
													'method' => 'post',
													'data' => $this->Js->serializeForm(array (
													'isForm' => false,
													'inline' => true
												))
											))				
				
				));
	} else {
		echo $this -> Js -> link('<i style="color:#F00;" class="icon-trash bigger-120"></i>',  
				array('controller' => 'acr_client_invoices', 'action' => 'deleteRow1',$rowId),
				array('id'=>'link-'.$rowId,'class'=>'textdecoration_none deleteinvocerow','escape' => FALSE,'update' => '#inventoryUpdateSelect-'.$rowId,'title'=>'Delete Item','confirm'=>'Are you sure you want to remove this item?',
				
					'success'=>  $this->Js->request(array (
													'controller' => 'acr_client_invoices',
													'action' => 'calculateTotalAfterDelete',$rowId
												), array (
													'update' => '#calculateFinal',
													'async' => true,
													'dataExpression' => true,
													'method' => 'post',
													'data' => $this->Js->serializeForm(array (
													'isForm' => false,
													'inline' => true
												))
											))
				
				));
	}	
	?>
	

<?php if(!$hideAddInventory):?>
	<!--Popup add  -->
<div class="modal fade" id="addnewunittype-<?php echo $rowId?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						<?php echo $this->Form->input('addInventory.name-'.$rowId,array('div'=>false,'label'=>false,'class'=>'col-xs-10 env-name-'.$rowId.' col-sm-5 form-control','type'=>'text','id'=>'form-field-1','Placeholder'=>'Inventory name'));?>
						<div class="clearfix"></div>
						<p class="popup-error1">Please enter inventory name.</p>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.description-'.$rowId,array('div'=>false,'label'=>false,'type'=>'textarea','class'=>'form-control col-xs-10 env-desc-'.$rowId.' col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory'));?>
						
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?> <em style="color:#ff0000;">∗</em></label> 
					<div class="col-sm-8">
						<span>
					    	<?php echo $this->Form->hidden('currency-'.$rowId,array('value'=>$defaultCurrency));?>
							<?php echo $this->Form->input('addInventory.code-'.$rowId,array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'form-control width30 col-xs-10 col-sm-5','value'=>$defaultCurrencyCode,'readonly'=>'readonly'))?>
						</span>
						<span>
							<?php echo $this->Form->input('addInventory.list_price-'.$rowId,array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 env-price-'.$rowId.' width70 col-sm-5 form-control unitpricee','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
						</span>
						<p class="popup-error3">Please enter inventory price.</p>
						<p class="popup-error4">Only numbers allowed</p>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
					<div class="col-sm-8 max-width max-height choosen_width">
						<?php echo $this->Form->input('addInventory.tax_inventory-'.$rowId,array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 invdrop','data-placeholder'=>"Select tax",'options'=>array(''=>'',$taxList)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
					<div class="col-sm-8 choosen_width" id ="unit-type">
						<?php echo $this->Form->input('addInventory.unitType-'.$rowId,array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select",'options'=>array(''=>'',$unitTypeList)));?>
					</div>
					
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
					<div class="col-sm-8">
						<label class="floatleft">
							<?php echo $this->Form->checkbox('addInventory.track-'.$rowId,array('div'=>false,'label'=>false,'class'=>'ace checktrack'));?>
							<span class="lbl"></span> </label>
						<label class="maillabel textleft floatleft">Yes</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group currentstock" style="display: none;">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> <em style="color:#ff0000;">∗</em> </label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.current_stock-'.$rowId,array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control col-xs-10 env-qty-'.$rowId.' col-sm-5','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
						<p class="popup-error2">Please enter current Stock.</p>
					</div>
				</div>
						</div>
					</div>
				</div>
				<div class="modal-footer paddingright8">
					<?php echo $this->Js->submit('Submit', array('id'=>'jsSubmit-'.$rowId,'div'=>false,'class'=>'btn btn-info close-submit3','url' => array('controller'=>'inventories','action'=>'addInventory',$rowId),'escape'=>false,'update' => '#td-inventoryUpdateSelect-'.$rowId));?>
					<button class="btn close-popup btn-inverse" type="button">
						<i class="icon-remove bigger-110"></i>
						Cancel
					</button>
				</div>
		
		<script>
		$(document).ready(function(){
		// Remove Tax Items
		$(".invdrop option:contains('|--')").remove();
		$('#addnewunittype-<?php echo $rowId?>').on('show.bs.modal', function (e) {
		  	$('.env-name-<?php echo $rowId?>, .env-desc-<?php echo $rowId?>, .env-price-<?php echo $rowId?>, .env-qty-<?php echo $rowId?>').val('');
		  		
		  		$('#addInventoryTrack-<?php echo $rowId?>').attr('checked', false); // Unchecks it
		  		$('.currentstock').hide();
		  		$('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
			});
			
			$( ".env-name-<?php echo $rowId?>, .env-price-<?php echo $rowId?>, .env-qty-<?php echo $rowId?>" ).focus(function() {
				$('.popup-error1, .popup-error1, .popup-error3, .popup-error4').hide();
			});
			
			
			$('.close-submit3').click(function(evt){
		    	 var value7=$.trim($(".env-name-<?php echo $rowId?>").val());
		    	 if(value7.length === 0) {
		    	 	$('.popup-error1').show();
		    	 	evt.preventDefault();
			        $('#field').value();
		    	 }
	
			     var value9 = $.trim($(".env-price-<?php echo $rowId?>").val());
		    	 if(value9.length === 0) {
		    	 	$('.popup-error3').show();
		    	 	evt.preventDefault();
			        $('#field').value();
		    	 }
		    	 
		    	 var value9 = $.trim($(".env-price-<?php echo $rowId?>").val());
			    	 if(!$.isNumeric(value9)) {
				    	// if(value7.length === 0) {
				    	 	$('.popup-error4').show();
				    	 	evt.preventDefault();
					        $('#field').value();
				     }	
		    	 
		    	 if ($('#addInventoryTrack-<?php echo $rowId?>').is(':checked')) {
		    	 var value10 = $.trim($(".env-qty-<?php echo $rowId?>").val());
		    	 if(value10.length === 0) {
		    	 	$('.popup-error2').show();
		    	 	evt.preventDefault();
			        $('#field').value();
		    	 }
		    	 }

		     	$('#addnewunittype-<?php echo $rowId?>').modal('hide');
		    });
			});				
		</script>
		
			<?php /*echo $this->form->end();*/?>
		</div>
	</div>
</div>
<?php endif;?>
</td>
<!--end of pop-->

<script type="text/javascript">
$(function() {
	var config = {
	  '.invdrop' : {search_contains:true}
	}
	for (var selector in config) {
	  $(selector).chosen(config[selector]);
	}
});
function minmax(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0;
    else if(parseInt(value) > 100) 
        return 0;
    else return value;
}

$('body').on('click','.checktrack',function(){
	if($('.checktrack').is(":checked"))
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
		
	var pquantityy = $('#quantity-<?php echo $rowId?>').val();
	var pdiscountt = $('#discount-<?php echo $rowId?>').val();
	var prate = $('#rate-<?php echo $rowId?>').val();
	
	$("input#quantity-<?php echo $rowId?>").keypress(function(event) { return isNumber(event) });
	$("input#rate-<?php echo $rowId?>").keypress(function(event) { return isNumber(event) });
	$("input#discount-<?php echo $rowId?>").keypress(function(event) { return isNumber(event) });
	
	
	$('input#quantity-<?php echo $rowId?>').on('blur',function(e){
			if($('#quantity-<?php echo $rowId?>').val() === "") {
				alert("Field can't be empty.");
				setTimeout(function() {
			      document.getElementById('#quantity-<?php echo $rowId?>').focus();
			    }, 0);
			    return false;
			}
		});
		
			$('input#rate-<?php echo $rowId?>').on('blur',function(e){
			if($('#rate-<?php echo $rowId?>').val() === "") {
				alert("Field can't be empty.");
				setTimeout(function() {
			      document.getElementById('#rate-<?php echo $rowId?>').focus();
			    }, 0);
			    return false;
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
<?php echo $this->Js->writeBuffer();?>