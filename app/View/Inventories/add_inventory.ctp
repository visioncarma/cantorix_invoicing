<?php
if(!$rowId){$rowId = 1;}
?><div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
						<div class="col-sm-10 col-xs-10 marginleftrightzero paddingleftrightzero countrybilling max-height max-width">
							
							<?php echo $this -> Form -> input('AcrClientInvoice.inventory.'.$rowId, array('id' => 'inventory-'.$rowId, 'div' => false, 'label' => false,'data-live-search'=>true, 'class'=>'selectpicker form-control','options' => array('' => 'Select inventory','-1'=>'Non Inventory Item', $inventoryList)));
							$this -> Js -> get('#inventory-'.$rowId) -> event('change', $this -> Js -> request(array('controller' => 'acr_client_invoices', 'action' => 'getInventoryDetails', $rowId), array('update' => '#inventoryUpdateSelect-'.$rowId, 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
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
						<div class="col-sm-2 col-xs-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
							<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select"  data-toggle="modal" data-target="#addnewunittype-<?php echo $rowId?>">
								<i class="icon-plus"></i>
							</div>
						</div>
					</div>
					<script>
				$(document).ready(function() {
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
					
<script type="text/javascript">
	jQuery(function($) {
		if($('.selectpicker').length){
 		      $('.selectpicker').selectpicker({
		       });
	   
	         }
	});
</script>
<?php echo $this -> Js -> writeBuffer(); ?>