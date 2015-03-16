<div class="row marginleftrightzero borderon">
	<div class="row marginleftrightzero">
		<span class="left bold">Subtotal</span>
		<span class="right bold">
			<?php $options = array('zero'=>'0.00','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before')?>
			<?php echo $this->Number->currency($subTotal,$defaultCurrencyCode,$options);?>
			<?php echo $this->Form->hidden('AcrClientInvoice.subTotal',array('value'=>$subTotal))?>
			<?php /*echo $subTotal*/ ?>
		</span>
	</div>
	<?php foreach($taxArray as $key=>$val):?>
	<div class="row marginleftrightzero ">
		<span class="left"><?php echo $val['taxName'];?></span>
		<span class="right">
			<?php echo $this->Number->currency($val['taxAmount'],$defaultCurrencyCode,$options);?>
			<?php echo $this->Form->hidden('AcrClientInvoice.taxValue.'.$key,array('value'=>$val['taxAmount']))?>
		</span>
	</div>
	<?php endforeach; ?>
</div>
<div class="row marginleftrightzero borderon">
	<div class="row marginleftrightzero">
		<span class="left bold">Total</span>
	</div>
	<div class="row marginleftrightzero">
		<span class="left">In Invoice Currency</span>
		<span class="right bold statusopn"><?php echo $this->Number->currency($invoicedCurrencyAmount,$invoicedCurrencyCode,$options);?></span>
		<?php echo $this->Form->hidden('AcrClientInvoice.invoicetotal',array('value'=>$invoicedCurrencyAmount))?>
	</div>
</div>
<div class="row marginleftrightzero ">
	<div class="row marginleftrightzero">
		<span class="left bold">Total</span>
	</div>
	<div class="row marginleftrightzero">
		<span class="left">In Subscriber Currency</span>
		<span class="right  bold statusopn">
			<?php echo $this->Form->hidden('AcrClientInvoice.subscribertotal',array('value'=>$product))?>
			<?php echo $this->Number->currency($finalProduct,$defaultCurrencyCode,$options);?>
		</span>
	</div>
</div>
