<?php echo $this->Form->input('AcpExpense.items',array('options'=>array(''=>'Items','Non-Inventory'=>'Non-Inventory',$inventoryList),'default'=>$newInventory,'data-placeholder'=>'Item','class'=>'form-control selectpicker','label'=>FALSE,'div'=>FALSE));?>
<script type="text/javascript">
	$(document).ready(function(){
			if($('.selectpicker').length) {
		   		$('.selectpicker').selectpicker({});
		}
	});
</script>