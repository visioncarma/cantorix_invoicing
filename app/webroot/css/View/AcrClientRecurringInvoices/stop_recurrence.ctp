<td><span class=""> <label>
	<?php echo $this->Form->checkbox('deleteAll.'.$acrClientInvoice['AcrClientRecurringInvoice']['id'],array('div'=>false,'label'=>false,'class'=>'ace delete-m-row'));?>
	<span class="lbl"></span> </label> </span></td>
							<td><span class="on-load statusopn"><?php echo $acrClientInvoice['AcrClientInvoice']['invoice_number'];?></span>
							</td>
							<td><span class="on-load"><?php echo date("$dateFormat",strtotime($acrClientInvoice['AcrClientRecurringInvoice']['invoice_start_date']));?></span>
							</td>
							<td><span class="on-load"><?php echo date("$dateFormat",strtotime($acrClientInvoice['AcrClientRecurringInvoice']['invoice_end_date']));?></span>
							</td>
							<td><span class="on-load"><?php $options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
									<?php echo $this->Number->currency($acrClientInvoice['AcrClientInvoice']['invoice_total'],$acrClientInvoice['AcrClientInvoice']['invoice_currency_code'],$options);?></span>
							</td>
							<td id = "td-<?php echo $acrClientInvoice['AcrClientRecurringInvoice']['id']?>"><span class="on-load "><?php echo $acrClientInvoice['AcrClientRecurringInvoice']['status'];?></span>
							</td>
							<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<div class="pull-right">
									<div class="inline position-relative">
										<button class="btn btn-minier btn-warning dropdown-toggle" data-toggle="dropdown">
											<i class="icon-caret-down bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
											<li>
												<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'view',$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-success view on-load pull-right','escape'=>FALSE,'title'=>'View'));?>
											</li>
											<li>
												<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'delete',$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-danger delete on-load delete-row pull-right','escape'=>FALSE,'title'=>'Delete','confirm'=>'Are you sure you want to remove the recurrence for Invoice# '.$acrClientInvoice['AcrClientInvoice']['invoice_number'].'?'));?>
											</li>
										</ul>
									</div>
								</div>
								<?php if($acrClientInvoice['AcrClientRecurringInvoice']['status']=='Active'){?>
								<?php

echo $this->Js->link('<i class=" icon-circle  bigger-120"></i>', array (
	'controller' => 'acr_client_recurring_invoices',
	'action' => 'stopRecurrence',
	$acrClientInvoice['AcrClientRecurringInvoice']['id']
), array (
	'class' => 'btn btn-xs btn-danger edit edit-row on-load pull-right',
	'escape' => FALSE,
	'update' => '#tr-' . $acrClientInvoice['AcrClientRecurringInvoice']['id'],
	'title' => 'Stop Recurrence',
	'confirm' => 'Do you want to stop recurrence for Invoice# ' . $acrClientInvoice['AcrClientInvoice']['invoice_number'] . '?'
));
?>
								<?php } ?>
								<?php

echo $this->Js->link('<i class="icon-save bigger-120"></i>', array (
	'controller' => 'acr_client_recurring_invoices',
	'action' => 'generateInvoice',
	$acrClientInvoice['AcrClientRecurringInvoice']['id']
), array (
	'class' => 'btn btn-xs btn-pink edit edit-row on-load pull-right',
	'escape' => FALSE,
	'update' => '#flashMessage',
	'title' => 'Generate Invoice',
	'confirm' => 'Do you want to generate invoice for this recurrence?'
));
?>
								<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'acr_client_recurring_invoices','action'=>'edit',$acrClientInvoice['AcrClientInvoice']['id'],$acrClientInvoice['AcrClientRecurringInvoice']['id'],$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$pages),array('class'=>'btn btn-xs btn-info edit on-load pull-right','escape'=>FALSE,'title'=>'Edit'));?>
								
							</div></td>