<div id="categoryUpdate" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginleftrightzero paddingleftrightzero">
	<?php echo $this->Form->input('AcpExpense.acp_expense_categories',array('options'=>array(''=>'Categories',$expenseCategories),'default'=>$lastInsertID,'data-placeholder'=>'Categories','class'=>'form-control selectpicker','div'=>FALSE,'label'=>FALSE));?>
</div>
<script type="text/javascript">
	jQuery(function($) {
		$('.selectpicker').selectpicker().change(function(){
          	$(this).valid()
	    });
	});
</script>