<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5" id = "td-inventoryUpdateSelect-<?php echo $rowId?>">
	<div class="col-xs-5 bold font13">
		Item
	</div>
	<div class="col-xs-7 font13  mobileClientName">
		<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
			<div class="col-xs-10 marginleftrightzero paddingleftrightzero choosen_width">
				<?php
											echo $this->Form->input('AcrClientInvoice.inventory.'.$rowId, array (
												'id' => 'inventory-'.$rowId,
												'class' => 'select_inventory',
												'data-live-search'=>true,
												'div' => false,
												'label' => false, 'class'=>'invdrop form-control',
												'data-placeholder'=>'Select Inventory',
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
			<div class="col-xs-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
				<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select" data-toggle="modal" data-target="#addnewunittype">
					<i class="icon-plus"></i>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>
<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
	<div class="col-xs-5 bold font13">
		Item Description
	</div>
	<div class="col-xs-7 font13  mobileClientName">
		<div class="form-group marginleftrightzero margin-bottom-zero">
			<?php 
			if($inventoryDesc){
			}else{
				$inventoryDesc = '';
			}
		?>
		<?php echo $this->Form->input('AcrClientInvoice.description.'.$rowId,array('rows'=>'2','div'=>false,'label'=>false,'class'=>'col-xs-10','type'=>'textarea','autocomplete'=>'off','placeholder'=>'Inventory description','maxlength'=>'56','value'=>$inventoryDesc));?>
		</div>
	</div>
</div>
<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
	<div class="col-xs-5 bold font13"> Qty </div>
		<div class="col-xs-7 font13  mobileClientName"> 
			<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
				<?php
			if(!$inventoryQuantity){
				$inventoryQuantity = '';
			} 
		?>
		<?php echo $this->Form->input('AcrClientInvoice.quantity.'.$rowId,array('id'=>'quantity-'.$rowId,'div'=>false,'label'=>false,'class'=>'form-control inputwidth text-right','type'=>'text',/*'id'=>'spinner1',*/'value'=>$inventoryQuantity));
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
			</div>
			<div class="col-xs-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
				<label class="quotemeasurement"><?php echo $inventoryUnitType;?></label>
				<?php echo $this->Form->hidden('AcrClientInvoice.unitTypeofInventory.'.$rowId,array('value'=>$inventoryUnitType));?>
			</div>
		</div>
</div>
<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
	<div class="col-xs-5 bold font13"> Unit Price </div>
	<div class="col-xs-7 font13  mobileClientName"> 
		<div class="form-group marginleftrightzero margin-bottom-zero">
			<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
				<?php if(!$inventoryRate){
			$inventoryRate = '';
		}?>
		<?php echo $this->Form->input('AcrClientInvoice.unit_rate.'.$rowId,array('id'=>'rate-'.$rowId,'div'=>false,'label'=>false,'class'=>'form-control inputwidth text-right','type'=>'text','value'=>$inventoryRate));
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
		</div>
	</div>
</div>
<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
	<div class="col-xs-5 bold font13"> Discount % </div>
	<div class="col-xs-7 font13  mobileClientName"> 
		<div class="form-group marginleftrightzero margin-bottom-zero">
			<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
				<?php echo $this->Form->input('AcrClientInvoice.discount_percent.'.$rowId,array('id'=>'discount-'.$rowId,'div'=>false,'label'=>false,'class'=>'form-control inputwidth text-right','onkeyup'=>'this.value = minmax(this.value, 0, 100)','value'=>'','type'=>'text'));
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
		</div>
	</div>
</div>
<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
	<div class="col-xs-5 bold font13">Tax </div>
	<div class="col-xs-7 font13  mobileClientName"> 
		<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
			<div class="col-xs-10 marginleftrightzero paddingleftrightzero chossen_select">
				<?php if(!$taxId){$taxId = '';}?>
			<?php echo $this->Form->input('AcrClientInvoice.tax_inventory.'.$rowId,array('id'=>'tax-'.$rowId,'div'=>false,'label'=>false,'class'=>'invdrop','data-placeholder'=>"Select Tax",'options'=>array(''=>'Select Tax',$taxList),'selected'=>$taxId));
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
	</div>
</div>
<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
	<div class="col-xs-5 bold font13">Amount </div>
		<div class="col-xs-7 font13  mobileClientName"> 
			<div class="form-group marginleftrightzero margin-bottom-zero">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero " id = "lineTotal-<?php echo $rowId?>">
					<?php echo $this->Form->input('AcrClientInvoice.line_total.'.$rowId,array('div'=>false,'label'=>false,'class'=>'form-control inputwidth text-right','type'=>'text','disabled'=>'disabled','value'=>$inventoryRate))?>
					<?php echo $this->Form->hidden('AcrClientInvoice.line_total_hidden.'.$rowId,array('value'=>$inventoryRate));?>
					<?php echo $this -> Form -> hidden('AcrClientInvoice.product_id.'.$rowId,array('value'=>$invoiceDetailId));?>
				</div>
	        </div>
		</div>
</div>
<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13">Action </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group marginleftrightzero margin-bottom-zero">
								
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
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
								</div>
	                        </div>
						</div>
					</div>
<script type="text/javascript">
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