<div class="btn-group bootstrap-select form-control selectitem  dropup choosen_width  expanse_choosen">
    <?php echo $this -> Form -> input('AcpExpense.tax_inventory', array('id'=>'tax_inventory','div' => false, 'label' => false, 'class' => 'invdrop', 'options' => array('' => 'Select Tax', $taxList),'default'=>$taxID)); ?>
    <?php 
        $this -> Js -> get('#tax_inventory') -> event('change', 
            $this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateGrandTotal'), 
                array('update' => '#grandTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
            )
        );
        $this -> Js -> get('#tax_inventory') -> event('change', 
            $this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateLineTotal'), 
                array('update' => '#lineTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
            )
        );
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(".invdrop option:contains('|--')").remove();
        
        if($('.selectpicker').length){
            $('.selectpicker').selectpicker({ });
        } 
        
        /* choosen select*/
		var config = {
			  
			  '.invdrop' : {search_contains:true}
			}
			for (var selector in config) {
			  $(selector).chosen(config[selector]);
		}
	/* choosen select*/  
    });
</script>
<?php echo $this->Js->writeBuffer();?>