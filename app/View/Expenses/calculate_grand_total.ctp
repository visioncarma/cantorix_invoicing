<div class="row marginleftrightzero borderon">
	<div class="row marginleftrightzero">
		<span class="left bold">Subtotal</span>
		<span class="right bold"><?php echo $this->Number->currency($final['subTotal'], $final['currency_code']);?></span>
	</div>
	<?php $final['taxTotal']=0;foreach($final['tax'] as $taxID => $taxDetails) {?>
	<div class="row marginleftrightzero ">
		<span class="left"><?php echo $taxDetails['taxName'];?></span>
		<span class="right"><?php echo $this->Number->currency($taxDetails['taxAmount'], $final['currency_code']);$final['taxTotal']+=$taxDetails['taxAmount'];?></span>
	</div>
	<?php }?>
</div>
<div class="row marginleftrightzero borderon">
	<div class="row marginleftrightzero">
		<span class="left bold">Total</span>
		<span class="right bold statusopn"><?php echo $this->Number->currency($final['total'], $final['currency_code']);?></span>
	</div>
</div>
<?php 
	echo $this->Form->hidden('AcpExpense.subTotal',array('value'=>$final['subTotal']));
	echo $this->Form->hidden('AcpExpense.taxtotal',array('value'=>$final['taxTotal']));
	echo $this->Form->hidden('AcpExpense.total',array('value'=>$final['total']));
?>