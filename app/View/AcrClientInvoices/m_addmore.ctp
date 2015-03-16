<?php
if(!$rowId){$rowId = 1;}
?>
<div class="table-small-view  new-table-small  new_table_small_view new_table_small_view_new new-table-small" id ="inventoryUpdateSelect-<?php echo $rowId;?>">
	<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
		<div class="col-xs-5 bold font13"> Item </div>
		<div class="col-xs-7 font13  mobileClientName"> 
			<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero" id = "td-inventoryUpdateSelect-<?php echo $rowId?>">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero choosen_width" >
					<?php echo $this->Form->input('AcrClientInvoice.inventory.'.$rowId,array('id'=>'inventory-'.$rowId,'div'=>false,'label'=>false,'data-live-search'=>'true','class'=>'invdrop form-control','data-placeholder'=>"Select Inventory",'options'=>array(''=>'','-1'=>'Non Inventory Item',$inventoryList)));
													$this->Js->get('#inventory-'.$rowId)->event('change',$this->Js->request(array('controller'=>'acr_client_invoices','action'=>'getInventoryDetails',$rowId), array( 'update'=>'#inventoryUpdateSelect-'.$rowId, 'async'=>false, 'dataExpression'=>true, 'method'=>'post', 'data'=>$this->Js->serializeForm(array('isForm'=>false,'inline'=>true)))));
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
				<div class="col-xs-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
					<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select" data-toggle="modal" data-target="#addnewunittype-<?php echo $rowId?>">
						<i class="icon-plus"></i>
					</div>
				</div>
				<?php endif; ?>	
			</div>	
		</div>
	</div>
	<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
		<div class="col-xs-5 bold font13"> Item Description </div>
		<div class="col-xs-7 font13  mobileClientName"> 
			<div class="form-group marginleftrightzero margin-bottom-zero">
				<?php echo $this->Form->input('AcrClientInvoice.description.'.$rowId,array('rows'=>'2','div'=>false,'label'=>false,'class'=>'col-xs-10','type'=>'textarea','placeholder'=>'Inventory description','readonly'=>'readonly'));?>
			</div>
		</div>
	</div>
	<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
		<div class="col-xs-5 bold font13"> Qty </div>
		<div class="col-xs-7 font13  mobileClientName"> 
			<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
				<?php echo $this->Form->input('AcrClientInvoice.quantity.'.$rowId,array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control text-right','type'=>'text','id'=>'spinner1','readonly'=>'readonly'));?>
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
					<?php echo $this->Form->input('AcrClientInvoice.unit_rate.'.$rowId,array('div'=>false,'label'=>false,'class'=>'col-sm-10 form-control','type'=>'text','readonly'=>'readonly'));?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
		<div class="col-xs-5 bold font13"> Discount % </div>
			<div class="col-xs-7 font13  mobileClientName"> 
				<div class="form-group marginleftrightzero margin-bottom-zero">
					<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
						<?php echo $this->Form->input('AcrClientInvoice.discount_percent.'.$rowId,array('div'=>false,'label'=>false,'class'=>'col-sm-10 form-control','type'=>'text','readonly'=>'readonly'));?>
					</div>
				</div>
			</div>
	</div>
	<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
		<div class="col-xs-5 bold font13">Tax </div>
			<div class="col-xs-7 font13  mobileClientName"> 
				<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
					<div class="col-xs-10 marginleftrightzero paddingleftrightzero choosen_width">
						<?php echo $this->Form->input('AcrClientInvoice.tax_inventory.'.$rowId,array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList),'readonly'=>'readonly'));?>
					</div>
				</div>
			</div>
	</div>
	
	<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
		<div class="col-xs-5 bold font13">Amount </div>
		<div class="col-xs-7 font13  mobileClientName"> 
			<div class="form-group marginleftrightzero margin-bottom-zero">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero " id = "lineTotal-<?php echo $rowId?>">
					<?php echo $this->Form->input('AcrClientInvoice.line_total.'.$rowId,array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control text-right','type'=>'text','disabled'=>'disabled','readonly'=>'readonly'))?>
				</div>
	        </div>
		</div>
	</div>
	<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
		<div class="col-xs-5 bold font13">Action </div>
		<div class="col-xs-7 font13  mobileClientName"> 
			<div class="form-group marginleftrightzero margin-bottom-zero">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
					<a href="javascript:void(0);" class="textdecoration_none deleteinvocerow padding-left10">
						<i class="icon-trash bigger-120" style="color:#F00;"></i>
					</a>
				</div>
	        </div>
		</div>
	</div>
</div>
<!--Popup add  -->
<div class="modal fade popupbind" id="addnewunittype-<?php echo $rowId?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> <em style="color:#ff0000;">∗</em></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.name-'.$rowId,array('div'=>false,'label'=>false,'class'=>'col-xs-10 env-name-'.$rowId.' col-sm-5 form-control','type'=>'text','id'=>'form-field-1','autocomplete'=>'off','Placeholder'=>'Inventory name'));?>
						<p class="popup-error1">Please enter inventory name.</p>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.description-'.$rowId,array('div'=>false,'label'=>false,'rows'=>'2','type'=>'textarea','class'=>'form-control col-xs-10 env-desc-'.$rowId.' col-sm-5 itemdescription','id'=>'form-field-2','autocomplete'=>'off','Placeholder'=>'Description of the inventory','maxlength'=>'55'));?>
						
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
							<?php echo $this->Form->input('addInventory.list_price-'.$rowId,array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 env-price-'.$rowId.' width70 col-sm-5 form-control','autocomplete'=>'off','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
							<p class="popup-error3">Please enter inventory price.</p>
							<p class="popup-error4">Only numbers allowed</p>
						</span>
						
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
					<div class="col-sm-8 max-width max-height choosen_width">
						<?php echo $this->Form->input('addInventory.tax_inventory-'.$rowId,array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 invdrop','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
					<div class="col-sm-8 choosen_width" id ="unit-type">
						<?php echo $this->Form->input('addInventory.unitType-'.$rowId,array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select Unit Type",'options'=>array(''=>'',$unitTypeList)));?>
					</div>
					
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
					<div class="col-sm-8 addmorepopup">
						<label>
							<?php echo $this->Form->checkbox('addInventory.track-'.$rowId,array('div'=>false,'label'=>false,'class'=>'checkBoxClick ace addmoreID'));?>
							<span class="lbl"></span> </label>
						<label class="maillabel">Yes</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group currentstock" style="display: none;">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> <em style="color:#ff0000;">∗</em></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.current_stock-'.$rowId,array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control env-qty-'.$rowId.' col-xs-10 col-sm-5','id'=>'form-field-4','autocomplete'=>'off','Placeholder'=>'Quantity of inventory  in stock'));?>
						<p class="popup-error2">Please enter current Stock.</p>
					</div>
				</div>
			</div>
		</div>
					
				</div>
				<div class="modal-footer paddingright8">
					<?php echo $this->Js->submit('Submit', array('id'=>'jsSubmit-'.$rowId,'div'=>false,'class'=>'btn btn-info close-submit2','url' => array('controller'=>'inventories','action'=>'addInventory',$rowId),'escape'=>false,'update' => '#td-inventoryUpdateSelect-'.$rowId));?>
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
				  		$('#addInventoryTrack-<?php echo $rowId;?>').attr('checked', false); // Unchecks it
					});
					$( ".env-name-<?php echo $rowId;?>, .env-price-<?php echo $rowId;?>, .env-qty-<?php echo $rowId;?>" ).focus(function() {
						$('.popup-error1, .popup-error2, .popup-error3, .popup-error4').hide();
					});
					
					$('.close-submit2').click(function(evt){
				    	 //alert('Works');
				    	 var value10 = $.trim($(".env-name-<?php echo $rowId;?>").val());
				    	 if(value10.length === 0) {
				    	 	$('.popup-error1').show();
				    	 	evt.preventDefault();
					        $('#field').value();
				    	 }
												   
					     var value12 = $.trim($(".env-price-<?php echo $rowId;?>").val());
				    	 if(value12.length === 0) {
				    	 	$('.popup-error3').show();
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
					    
				    	 if ($('#addInventoryTrack-<?php echo $rowId;?>').is(':checked')) {
				    	 var value13 = $.trim($(".env-qty-<?php echo $rowId;?>").val());
				    	 if(value13.length === 0) {
				    	 	$('.popup-error2').show();
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
<script type="text/javascript">
function minmax(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0;
    else if(parseInt(value) > 100) 
        return 0;
    else return value;
}

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
		
	/* choosen select*/
		var config = {
			  
			  '.invdrop' : {search_contains:true}
			}
			for (var selector in config) {
			  $(selector).chosen(config[selector]);
		}
	/* choosen select*/
		
	var pquantityy = $('#quantity-<?php echo $rowId?>').val();
	var pdiscountt = $('#discount-<?php echo $rowId?>').val();
	var prate = $('#rate-<?php echo $rowId?>').val();
	
	
	$("input#quantity-<?php echo $rowId?>").keypress(function(event) { return isNumber(event) });
	$("input#rate-<?php echo $rowId?>").keypress(function(event) { return isNumber(event) });
	$("input#discount-<?php echo $rowId?>").keypress(function(event) { return isNumber(event) });
	
	$('input#quantity-<?php echo $rowId?>').on('blur',function(e){
		if($('#quantity-<?php echo $rowId?>').val() === "") {
			alert("Field can't be empty.");
			$('#quantity-<?php echo $rowId?>').val(pquantityy);
		}
		});
	
		$('input#rate-<?php echo $rowId?>').on('blur',function(e){
		if($('#rate-<?php echo $rowId?>').val() === "") {
			alert("Field can't be empty.");
			$('#rate-<?php echo $rowId?>').val(prate);
		}
	});
	
		function isNumber(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && 
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
    	
    	$('.textdecoration_none').click(function(){
    	  $(this).parents('#inventoryUpdateSelect-<?php echo $rowId;?>').remove();
        });
	});
</script>
<?php echo $this -> Js -> writeBuffer(); ?>