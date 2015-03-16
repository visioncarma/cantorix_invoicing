<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
						<div class="col-sm-10 marginleftrightzero paddingleftrightzero ">
							
							<?php echo $this -> Form -> input('AcrClientInvoice.inventory.'.$rowId, array('id' => 'inventory-'.$rowId, 'div' => false, 'label' => false, 'class'=>'chosen-select','options' => array('' => 'Select inventory', $inventoryList),'default'=>$newInventory));
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
						<div class="col-sm-2 marginleftrightzero paddingleftrightzero paddinglefttop4">
							<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select"  data-toggle="modal" data-target="#addnewunittype-<?php echo $rowId;?>">
								<i class="icon-plus"></i>
							</div>
						</div>
					</div>
<script type="text/javascript">
	jQuery(function($) {
		$(".chosen-select").chosen();
	});
</script>
<?php echo $this -> Js -> writeBuffer(); ?>