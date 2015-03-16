<?php echo $this->Form->input('InvInventory.unitType',array('div'=>false,'label'=>false,'class'=>'col-sm-12 form-control selectpicker','options'=>array(''=>'Select Unit Type',$unitTypeList)));?>
<script type="text/javascript">
	$(document).ready(function(){
		if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
        } 
	})
</script>
