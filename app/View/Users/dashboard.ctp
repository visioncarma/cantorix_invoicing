<?php echo $this->Session->flash();?>
<div class="breadcrumbs clientbreadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<?php $homeLink = $this->Breadcrumb->getLink('Home');?>
	<ul class="breadcrumb clientbreadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li  class="active">
			Dashboard
		</li>
	</ul><!-- .breadcrumb -->

	<ul class="clientstatistics">
		<li>
			<span class="font13 item-black">Invoices</span>
			<span class="font13">:</span>
			<span class="bluetext bold font13"><span class="colorbalck cpadding"><?php echo $topFinal['invoicesCount'];?></span><span class="colorbalck cpadding">/</span><span class="cpadding"><?php if($topFinal['currentPlanDetails']['CpnSubscriptionPlan']['no_of_invoices'] == -1) echo 'Unlimited';else echo $topFinal['currentPlanDetails']['CpnSubscriptionPlan']['no_of_invoices'];?></span></span>
		</li>
		<li>
			<span class="font13 item-black">Created Users</span>
			<span class="font13">:</span>
			<span class="bluetext bold font13"><span class="colorbalck cpadding"><?php echo $topFinal['staffsCount'];?></span><span class="colorbalck cpadding">/</span><span class="cpadding"><?php if($topFinal['currentPlanDetails']['CpnSubscriptionPlan']['no_of_staffs'] == -1) echo 'Unlimited';else echo $topFinal['currentPlanDetails']['CpnSubscriptionPlan']['no_of_staffs'];?></span></span>
		</li>
		<li>
			<span class="font13 item-black">Customers</span>
			<span class="font13">:</span>
			<span class="bluetext bold font13"><span class="colorbalck cpadding"><?php echo $topFinal['customersCount'];?></span><span class="colorbalck cpadding">/</span><span class="cpadding"><?php if($topFinal['currentPlanDetails']['CpnSubscriptionPlan']['no_of_clients'] == -1) echo 'Unlimited';else echo $topFinal['currentPlanDetails']['CpnSubscriptionPlan']['no_of_clients'];?></span></span>
		</li>
		<li>
			<span class="font13 item-black">Current Plan</span>
			<span class="font13">:</span>
			<span class="bluetext bold font13"><?php echo $topFinal['currentPlanDetails']['CpnSubscriptionPlan']['type']?></span>
		</li>
	</ul><!-- . -->
</div>
<div class="page-content clientdashboard">
	<!--<div class="page-header clientdashboard">
		<h1 class="lighter clientdashboardsubheader defaultcolor">Welcome to</h1>
		<h2 class="lighter defaultcolor clientdashboardheader">CantoriX Client Dashboard</h2>
	</div> --><!-- /.page-header -->
	<?php echo $this->Form->create('Dashboard',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)))?>
	<div class="row">
		<div class=" col-lg-12 col-sm-12 col-md-12 col-xs-12 paddingtop1p">
			<div class=" col-lg-6 col-sm-6 col-md-6 col-xs-12  no-padding-left paddingleftrightimp marginbottomimp currentMonth">
				<div class="current-month-snapshot">
					<h3 class="snapshot-title">Current month snapshot</h3>
					<ul class="snapshot-list">
						<li class="snopshot-list-border-right">
							<span>Total Invoices</span>
							<span class="font21 blue"><?php echo $this->Number->currency($row1Left['totalInvoices'][0]['total'],'');?></span>
						</li>
						<li class="snopshot-list-border-right">
							<span>Total Payments</span>
							<span class="font21 green"><?php echo $this->Number->currency($row1Left['totalPayments'],'');?></span>
						</li>
						<li>
							<span>Total Expenses</span>
							<span class="font21 red"><?php echo $this->Number->currency($row1Left['totalExpenses'][0]['total'],'');?></span>
						</li>
					</ul>
				</div>
			</div>
			<div class=" col-lg-6 col-sm-6 col-md-6 col-xs-12  no-padding-right paddingleftrightimp marginbottomimp receivables">
				<div class="current-month-snapshot">
					<h3 class="snapshot-title">Receivables Analysis</h3>
					<ul class="snapshot-list">
						<li class="snopshot-list-border-right">
							<span>Total Receivables</span>
							<span class="font21 blue"><?php echo $this->Number->currency($row1Right['totalRecievable'],'');?></span>
						</li>
						<li class="snopshot-list-border-right">
							<span>Total Due</span>
							<span class="font21 red"><?php echo $this->Number->currency($row1Right['totalDue'],'');?></span>
						</li>
						<li>
							<span>Total Overdue</span>
							<span class="font21 red"><?php echo $this->Number->currency($row1Right['totalOverDue'],'');?></span>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--first widget-->

	<div id="yearlyGraph" class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 paddingtop2p">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-flat marginbottom2p position-relative">
					
					
	<div class="col-lg-6 col-md-4 col-sm-3 col-xs-12">
		<h3 class="lighter"> Current Calendar Year Analysis <span class="coloroffblack"><i class="icon-double-angle-right"></i> </span> <span class="lighter coloroffblack"> Current Year Snapshot </span> </h3>
	</div>
					
					<div class="form-group col-lg-3 col-md-4 col-sm-3 col-xs-11  dashboard_drop_pos topCustomer no-padding-right no-padding-left choosen_width">
						<?php echo $this->Form->input('graphFiscalYear',array('id'=>'graph-Fiscal-Year','class'=>'form-control invdrop','data-placeholder'=>'Fiscal Year','options'=>array('Current Calendar'=>'This Calendar Year','Previous Calendar'=>'Previous Calendar Year','Current Financial'=>'This Financial Year','Previous Financial'=>'Previous Financial Year'),'default'=>'Current Financial'));?>
						<?php $this->Js->get('#graph-Fiscal-Year')->event('change', $this->Js->request(array ('action' => 'dashboardGraph',$subscriberID), array ('update' => '#yearlyGraph','async' => true,'dataExpression' => true,
										'method' => 'post',
										'data' => $this->Js->serializeForm(array (
										'isForm' => false,
										'inline' => true
									))
								))); ?>
					</div>
					
					<div class="widget-toolbar toggle-icon-fixed-width">
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
	</div>
	<!--second widget-->

	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 paddingtop1p">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-flat marginbottom2p">
					<h3 class="lighter"> Unpaid Invoices </h3>
					<div class="widget-toolbar">
						<a href="#" data-action="collapse"> <i class="icon-chevron-up"></i> </a>
					</div>
				</div>
				<div class="widget-body">
					<div class="widget-main padding-4">
						<div>
							<div class=" col-lg-4 col-sm-4 col-md-4 col-xs-12  no-padding-left paddingleftrightimp marginbottomimp">
								<div class="current-month-snapshot">
									<h3 class="snapshot-title">Current</h3>
									<ul class="snapshot-list">
										<li class="snopshot-list-border-right">
											<span>Total Current</span>
											<span class="font21 blue"><?php echo $this->Number->currency($row3Left['totalCurrent'],'');?></span>
										</li>
										<li>
											<span>Total Due</span>
											<span class="font21 red"><?php echo $this->Number->currency($row3Left['totaldue'],'');?></span>
										</li>
									</ul>
								</div>
							</div>
							<div class=" col-lg-8 col-sm-8 col-md-8 col-xs-12  no-padding-right paddingleftrightimp marginbottomimp">
								<div class="current-month-snapshot paddingonehalf">
									<h3 class="snapshot-title">Overdue</h3>
									<?php if(!empty($row3Right['agingBucketsLabel'])):?>
									<ul class="snapshot-list">
										<li class="snopshot-list-border-right">
											<span><?php echo $row3Right['agingBucketsLabel'][0]['SbsAgingBucket']['bucket'];?></span>
											<span class="font21 red"><?php echo $this->Number->currency($row3Right['agingBucket0'],'');?></span>
										</li>
										<li class="snopshot-list-border-right">
											<span><?php echo $row3Right['agingBucketsLabel'][1]['SbsAgingBucket']['bucket'];?></span>
											<span class="font21 red"><?php echo $this->Number->currency($row3Right['agingBucket1'],'');?></span>
										</li>
										<li class="snopshot-list-border-right">
											<span><?php echo $row3Right['agingBucketsLabel'][2]['SbsAgingBucket']['bucket'];?></span>
											<span class="font21 red"><?php echo $this->Number->currency($row3Right['agingBucket2'],'');?></span>
										</li>
										<li>
											<span><?php echo $row3Right['agingBucketsLabel'][3]['SbsAgingBucket']['bucket'];?></span>
											<span class="font21 red"><?php echo $this->Number->currency($row3Right['agingBucket3'],'');?></span>
										</li>
									</ul>
									<?php else:?>
										<span style="padding-left:305px">Please define aging buckets</span><br />
										<span style="padding-left:319px">(Settings->General Settings)</span>
									<?php endif;?>
								</div>
							</div>
						</div>
					</div><!-- /widget-main -->
				</div><!-- /widget-body -->
			</div><!-- /widget-box -->
		</div>
	</div>
	<!--second widget-->

	<div class="row">
		<div id="customerGraph" class="col-lg-6 col-sm-6 col-md-6 col-xs-12 paddingtop2p">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-flat marginbottom2p position-relative">
					<h3 class="lighter"> Top Ten Customers </h3>
					<div class="form-group col-lg-5 col-md-5 col-sm-6 col-xs-4 position-absolute dashboard_drop_pos  topCustomer choosen_width">
						<?php 
							echo $this->Form->input('customerGraph',array('id'=>'customerFGraph','class'=>'form-control invdrop','data-placeholder'=>'Fiscal Year','options'=>array('Current Month'=>'This Month','Previous Month'=>'Last Month','Current Calendar'=>'This Calendar Year','Previous Calendar'=>'Previous Calendar Year','Current Financial'=>'This Financial Year','Previous Financial'=>'Previous Financial Year')));
							$this->Js->get('#customerFGraph')->event('change', $this->Js->request(array ('action' => 'dashboardCustomerGraph',$subscriberID), array ('update' => '#customerGraph','async' => true,'dataExpression' => true,'method' => 'post',
											'data' => $this->Js->serializeForm(array ('isForm' => false,'inline' => true))
									)));
							?>
					</div>
					<div class="widget-toolbar">
						<a href="#" data-action="collapse"> <i class="icon-chevron-up"></i> </a>
					</div>
				</div>
				<div class="widget-body">
					<div class="widget-main padding-4">
						<div id="container2" style="height:auto;width:100%;float:left">
							<?php echo $this->element('customer_dashboard_graph');?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="expenseGraph" class="col-lg-6 col-sm-6 col-md-6 col-xs-12 paddingtop2p">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-flat marginbottom2p position-relative">
					<h3 class="lighter"> Top Ten Expenses </h3>
					<div class="widget-toolbar">
						<a href="#" data-action="collapse"> <i class="icon-chevron-up"></i> </a>
					</div>
					<div class="form-group col-lg-5 col-md-5 col-sm-6 col-xs-4 position-absolute dashboard_drop_pos choosen_width">
						<?php 
							echo $this->Form->input('expenseGraph',array('id'=>'expenseFGraph','class'=>'form-control invdrop','data-placeholder'=>'Fiscal Year','options'=>array('Current Month'=>'This Month','Previous Month'=>'Last Month','Current Calendar'=>'This Calendar Year','Previous Calendar'=>'Previous Calendar Year','Current Financial'=>'This Financial Year','Previous Financial'=>'Previous Financial Year')));
							$this->Js->get('#expenseFGraph')->event('change', $this->Js->request(array ('action' => 'dashboardExpenseGraph',$subscriberID), array ('update' => '#expenseGraph','async' => true,'dataExpression' => true,'method' => 'post',
								'data' => $this->Js->serializeForm(array ('isForm' => false,'inline' => true))
							)));
							?>
					</div>
				</div>
				<div class="widget-body">
					<div class="widget-main padding-4">
						<div id="container3" style="height:auto;width:100%;float:left">
							<?php echo $this->element('expense_dashboard_graph');?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div><!-- /.page-content -->

<?php echo $this->Html->script(array('highcharts.js','jquery.easy-pie-chart.min.js','jquery.slimscroll.min.js','jquery.sparkline.min.js','jquery.ui.touch-punch.min.js','flot/jquery.flot.min.js','flot/jquery.flot.pie.min.js'));?>
<script type="text/javascript">
	jQuery(function($) {
		$(".chosen-select").chosen();
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


<!-- inline scripts related to this page -->
<?php echo $this->Js->writeBuffer();?>