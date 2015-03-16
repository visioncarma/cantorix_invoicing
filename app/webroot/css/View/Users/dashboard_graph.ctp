
<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 paddingtop2p">
	<div class="widget-box transparent">
		<div class="widget-header widget-header-flat marginbottom2p position-relative">
			<h3 class="lighter"> <?php echo $text;?> Year Analysis </h3>
			<span class="coloroffblack"><i class="icon-double-angle-right"></i> </span>
			<h4 class="lighter coloroffblack"> <?php echo $text2;?> Year Snapshot </h4>
			<div class="form-group col-lg-2 col-md-4 col-xs-6 position-absolute dashboard_drop_pos getlost topCustomer">
				<?php echo $this->Form->input('Dashboard.graphFiscalYear',array('label'=>FALSE,'div'=>FALSE,'id'=>'graph11','class'=>'form-control selectpicker','data-placeholder'=>'Fiscal Year','options'=>array('Current Calendar'=>'This Calendar Year','Previous Calendar'=>'Previous Calendar Year','Current Financial'=>'This Financial Year','Previous Financial'=>'Previous Financial Year')));?>
				<?php $this->Js->get('#graph11')->event('change', $this->Js->request(array (
												'controller' => 'users',
												'action' => 'dashboardGraph',$subscriberID
											), array (
												'update' => '#yearlyGraph',
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
			<div class="widget-toolbar">
				<a href="#" data-action="collapse"> <i class="icon-chevron-up"></i> </a>
			</div>
		</div>
		<div class="widget-body">
			<div class="widget-main padding-4">
				<div>
					<div id="container1" style="height:auto;width:100%;float:left">
						<?php echo $this->element('client_dashboard_graph');?>
					</div>
				</div>
			</div><!-- /widget-main -->
		</div><!-- /widget-body -->
	</div><!-- /widget-box -->
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".chosen-select").chosen();
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
<?php echo $this->Js->writeBuffer();?>