<div class="widget-box transparent">
	<div class="widget-header widget-header-flat marginbottom2p position-relative">
		<h3 class="lighter"> Top Ten Expenses </h3>
		<div class="widget-toolbar">
			<a href="#" data-action="collapse"> <i class="icon-chevron-up"></i> </a>
		</div>
		<div class="form-group col-lg-5 col-md-5 col-sm-6 col-xs-4 position-absolute dashboard_drop_pos choosen_width">
			<?php
			echo $this -> Form -> input('Dashboard.expenseGraph', array('label'=>FALSE,'div'=>FALSE,'id' => 'expenseFGraph', 'class' => 'form-control invdrop', 'data-placeholder' => 'Fiscal Year', 'options' => array('Current Month' => 'This Month', 'Previous Month' => 'Last Month', 'Current Calendar' => 'This Calendar Year', 'Previous Calendar' => 'Previous Calendar Year', 'Current Financial' => 'This Financial Year', 'Previous Financial' => 'Previous Financial Year')));
			$this -> Js -> get('#expenseFGraph') -> event('change', $this -> Js -> request(array('action' => 'dashboardExpenseGraph', $subscriberID), array('update' => '#expenseGraph', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
			?>
		</div>
	</div>
	<div class="widget-body">
		<div class="widget-main padding-4">
			<div id="container3" style="height:auto;width:100%;float:left"><?php echo $this->element('expense_dashboard_graph');?></div>
		</div>
	</div>
</div>
<script type="text/javascript">
	jQuery(function($) {
		
		if($('.selectpicker').length){
		   		 $('.selectpicker').selectpicker({
			});    	
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