<?php debug($date_format); ?>
<?php debug($fromDate);?>
<?php debug($toDate);?>
<?php echo $this -> Html -> css(array('print.css'), 'stylesheet', array('media' => 'print')); ?>
<?php $this -> CurrencySymbol -> getAllCurrencies(); ?>
<?php 
	$dbFormat = array("d", "M", "Y");
	$scriptFormat   = array("dd", "mm", "yyyy");
?>
<?php echo $this -> Session -> flash(); ?>

<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<?php $homeLink = $this->Breadcrumb->getLink('Home');
	$reportsLink =  $this->Breadcrumb->getLink('Reports');?>	
	<ul class="breadcrumb">
		<li>
			<?php echo $this -> Html -> link('<i class="icon-home home-icon"></i>Home', "$homeLink", array('escape' => FALSE)); ?>
		</li>
		<li>
			<?php echo $this->Html->link('Reports',$reportsLink);?>
		</li>
		<li class="active">
			Customer Sales
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-12 col-sm-12 col-xs-12 width-after-600">
			Customer Sales
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600">
			<div class=" widthauto paddingleftrightzero pull-right padding-right-3-480 width50p mobile_100">
				<div class="btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100">
					<?php $fromDatePass = date('Y-m-d',strtotime($fromDate));
						  $toDatePass	= date('Y-m-d',strtotime($toDate));
					?>
					<?php echo $this -> Html -> link('Export to PDF', array('controller' => 'reports', 'action' => 'salesPdf', 'ex_pdf', $organizationName, $filterAction, $min, $max, $fromDatePass, $toDatePass), array('class' => 'report-button', 'confirm' => 'Click on "Ok" to start the export.')); ?>
					<i class="icon-caret-down icon-on-right"></i>
				</div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p mobile_100 buttonrightwidth ">
				<div class="btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400 mobile_100">
					<?php echo $this -> Html -> link('Export to Excel', array('controller' => 'reports', 'action' => 'salesExcel', 'ex_excel', $organizationName, $filterAction, $min, $max, $fromDatePass, $toDatePass), array('class' => 'report-button', 'confirm' => 'Click on "Ok" to start the export.')); ?>
			    <i class="icon-caret-down icon-on-right"></i>
			    </div>
			</div>	
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 clear400 buttonrightwidth mobile_100">
				<div class="btn btn-sm pull-right printbutton mobile_100">
					<a href="javascript:void()" onclick="window.print()">Print <i class="icon-print icon-on-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row filterrow">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive tableexpense">
				<div class="table-header">
					Customer Sales Report
				</div>
				<?php echo $this -> Form -> create('sales', array('id' => 'sales', 'url' => array('controller' => 'Reports', 'action' => 'salesReport'))); ?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="col-lg-2 form-group filed-left margin-bottom-zero no-padding-left no-padding-right max-height max-width width-full-480 filter-select-width-new form-filter-field mobile_100 choosen_width">						
						<?php
						if ($organizationName && ($organizationName != "null")) {
							echo $this -> Form -> input('orgName', array('label' => false, 'placeholder' => 'Customer Name', 'id' => "", 'data-live-search' => 'true', 'class' => "form-control invdrop",'data-placeholder'=>"Customer Name", 'options' => array('' => '', $listCustomer), 'default' => $organizationName));
						} else {
							echo $this -> Form -> input('orgName', array('label' => false, 'placeholder' => 'Customer Name', 'id' => "", 'data-live-search' => 'true', 'class' => "form-control invdrop",'data-placeholder'=>"Customer Name", 'options' => array('' => '', $listCustomer)));
						}
						?>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">							
							<?php echo $this -> Form -> input('filterAction', array('label' => false, 'class' => 'form-control invdrop selectitem','data-placeholder'=>"Select Filter Option", 'options' => array('' => 'Select Filter Option', 'no_of_invoice' => 'No Of Invoice', 'no_item_sold' => 'Item Sold', 'sales' => 'Sales', 'tax' => 'Tax', 'total_sales' => 'Total Sales'), 'default' => $filterAction)); ?>
						</div>
					</div>
					<div class="col-lg-2 form-group filed-left margin-bottom-zero no-padding-left no-padding-right minimumValue width-full-480 mobile_100">						
						<?php
						if ($min && ($min != "null")) {
							echo $this -> Form -> input('min', array('label' => false, 'placeholder' => 'Min Value', 'id' => "min_customer", 'class' => "form-control", 'value' => $min));
						} else {
							echo $this -> Form -> input('min', array('label' => false, 'placeholder' => 'Min Value', 'id' => "min_customer", 'class' => "form-control"));
						}
						?>
					</div>
					<div class="col-lg-2 form-group filed-left margin-bottom-zero no-padding-left no-padding-right maximumValue width-full-480 mobile_100">						
						<?php
						if ($max && ($max != "null")) {
							echo $this -> Form -> input('max', array('label' => false, 'placeholder' => 'Max Value', 'id' => "max_customer", 'class' => "form-control", 'value' => $max));
						} else {
							echo $this -> Form -> input('max', array('label' => false, 'placeholder' => 'Max Value', 'id' => "max_customer", 'class' => "form-control"));
						}
						?>
					</div>
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">						
						<?php echo $this -> Form -> input('fromDate', array('div' => false, 'label' => false, 'placeholder' => 'From Date', 'id' => "id-date-picker-2", 'class' => "form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format), 'default' => date($date_format, strtotime($fromDate)), 'readonly' => 'readonly', 'style' => 'cursor:default'));?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">	
						<?php echo $this -> Form -> input('toDate', array('div' => false, 'label' => false, 'placeholder' => 'To', 'id' => "id-date-picker-1", 'class' => "form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format), 'default' => date($date_format, strtotime($toDate)), 'readonly' => 'readonly', 'style' => 'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					
					<div class="form-group filed-left margin-bottom-zero mobile_100">						
						<?php echo $this -> Js -> submit('Filter', array('div' => false, 'class' => 'btn btn-sm btn-primary filter-btn filterbutton mobile_100', 'url' => array('controller' => 'Reports', 'action' => 'salesReport'), 'escape' => false, 'update' => '#pageContent','before' => $this->Js->get('#loading1')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading1')->effect('fadeOut', array('buffer' => false)))); ?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">						
						<?php echo $this -> Js -> link('Reset', array('controller' => 'Reports', 'action' => 'salesReport'), array('class' => 'btn btn-sm btn-primary filter-btn mobile_100', 'update' => '#pageContent')); ?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading1','style'=>'display:none;float: right;margin-right: 10%;'));?>
				</div>
				<?php echo $this -> Form -> end(); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
			 <?php $i = 0; ?>
					<?php foreach($invoiceData as $value) { ?>
				<table class="table table-striped roles-table parent-table">
					<tr>
						<td class="title_role bold rowwidth200px printname textleft">
							<?php echo $this -> Js -> link('Customer Name', array('controller' => 'Reports', 'action' => 'salesReport', 'Customer Name', $sortingOrder, $organizationName, $filterAction, $min, $max, $fromDate, $toDate), array('update' => '#pageContent')); ?>
						</td>
						<td class="title bold rowwidth120px printinvoice textright">
							<?php echo $this -> Js -> link('No Invoices', array('controller' => 'Reports', 'action' => 'salesReport', 'No Invoices', $sortingOrder, $organizationName, $filterAction, $min, $max, $fromDate, $toDate), array('update' => '#pageContent')); ?>
						</td>
						<td class="title bold rowwidth120px printsold textright">
							<?php echo $this -> Js -> link('No Item Sold', array('controller' => 'Reports', 'action' => 'salesReport', 'No Item Sold', $sortingOrder, $organizationName, $filterAction, $min, $max, $fromDate, $toDate), array('update' => '#pageContent')); ?>
						</td>
						<td class="title bold rowwidth120px printitem textright">
							<?php echo $this -> Js -> link('Sales', array('controller' => 'Reports', 'action' => 'salesReport', 'Sales', $sortingOrder, $organizationName, $filterAction, $min, $max, $fromDate, $toDate), array('update' => '#pageContent')); ?>
						</td>
						<td class="title bold rowwidth120px printitem textright">
							<?php echo $this -> Js -> link('Tax', array('controller' => 'Reports', 'action' => 'salesReport', 'Tax', $sortingOrder, $organizationName, $filterAction, $min, $max, $fromDate, $toDate), array('update' => '#pageContent')); ?>
						</td>
						<td class="title bold rowwidth120px printitem textright">
							<?php echo $this -> Js -> link('Total Sales', array('controller' => 'Reports', 'action' => 'salesReport', 'Total Sales', $sortingOrder, $organizationName, $filterAction, $min, $max, $fromDate, $toDate), array('update' => '#pageContent')); ?>
						</td>
					</tr>
					
						
												<?php if($value):?>
													<?php
													if ($i % 2 == 0) {
														$class = "even-strip";
													} else {
														$class = '';
													}
												?>
											<tr class="<?php echo $class; ?>">
												<td class="title_role rowwidth200px printname textleft"><?php echo $this -> Html -> link($value['AcrClient']['organization_name'], array('action' => 'index', $value['AcrClientInvoice']['acr_client_id'])); ?></td>
												<td class="title rowwidth120px printinvoice textright"><?php echo $value['AcrClientInvoice']['count_id']; ?></td>
												<td class="title rowwidth120px printsold textright"><?php echo $value['AcrClientInvoice']['sold-items']; ?></td>
												<td class="title rowwidth120px printitem textright"><?php echo $this -> Number -> format($value['AcrClientInvoice']['sum_sub_total'], array('places' => '2', 'before' => '', 'escape' => false, 'decimals' => '.', 'thousands' => ',')); ?></td>
												<td class="title rowwidth120px printitem textright"><?php echo $this -> Number -> format($value['AcrClientInvoice']['sum_tax_total'], array('places' => '2', 'before' => '', 'escape' => false, 'decimals' => '.', 'thousands' => ',')); ?></td>
												<td class="title rowwidth120px printitem textright"><?php echo $this -> Number -> format($value['AcrClientInvoice']['sum_func_currency_total'], array('places' => '2', 'before' => '', 'escape' => false, 'decimals' => '.', 'thousands' => ',')); ?></td>
											</tr>
											<?php
												$finalDetails['total-invoices'] = $finalDetails['total-invoices'] + $value['AcrClientInvoice']['count_id'];
												$finalDetails['total-sold'] = $finalDetails['total-sold'] + $value['AcrClientInvoice']['sold-items'];
												$finalDetails['total-sales'] = $finalDetails['total-sales'] + $value['AcrClientInvoice']['sum_sub_total'];
												$finalDetails['total-taxes'] = $finalDetails['total-taxes'] + $value['AcrClientInvoice']['sum_tax_total'];
												$finalDetails['total-total-sales'] = $finalDetails['total-total-sales'] + $value['AcrClientInvoice']['sum_func_currency_total'];
											 ?>
											 <?php $i++; ?>
											 <?php endif; ?>
					
					 
				</table>
				 <?php } ?>
				<table class="table table-striped newtotal1 roles-table">
					<tr>
						<td class="title_role bold rowwidth200px printname textleft">
							Customer Name
						</td>
						<td class="title bold rowwidth120px printinvoice textright">
							No Invoices
						</td>
						<td class="title bold rowwidth120px printsold textright">
							No Item Sold
						</td>
						<td class="title bold rowwidth120px printitem textright">
							Sales
						</td>
						<td class="title bold rowwidth120px printitem textright">
							Tax
						</td>
						<td class="title bold rowwidth120px printitem textright">
							Total Sales
						</td>
					</tr>
					
					<tr class="even-strip">
						<td class="title_role rowwidth200px textleft"><b>Total</b></td>
						<td class="title rowwidth120px  textright"><b><?php echo $finalDetails['total-invoices']; ?></b></td>
						<td class="title rowwidth120px textright"><b><?php echo $finalDetails['total-sold']; ?></b></td>
						<td class="title rowwidth120px textright"><b><?php echo $this -> Number -> format($finalDetails['total-sales'], array('places' => '2', 'before' => '', 'escape' => false, 'decimals' => '.', 'thousands' => ',')); ?></b></td>
						<td class="title rowwidth120px textright"><b><?php echo $this -> Number -> format($finalDetails['total-taxes'], array('places' => '2', 'before' => '', 'escape' => false, 'decimals' => '.', 'thousands' => ',')); ?></b></td>
						<td class="title rowwidth120px textright"><b><?php echo $this -> Number -> format($finalDetails['total-total-sales'], array('places' => '2', 'before' => '', 'escape' => false, 'decimals' => '.', 'thousands' => ',')); ?></b></td>
					</tr>
					
				</table>	
										
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
				<span class="pull-right">
					All amounts displayed in <span style="color:red; font-weight: bold;"><?php echo $subscriberCurrencyCode; ?></span>
				</span>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
		
		
		//table mobile view script//
		if ($('.roles-table-wrapper-inner').length) {
			var winsize = 1;
			if ($('.roles-table').length) {
				var i = 1;
				$('.roles-table').each(function() {
					$(this).addClass("role-table-" + i);
					i++;
				});
			}
			$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");

			$changeTableView = function() {
				$(".table").each(function() {
					var $this = $(this);
					var newrows = [];
					$this.find("tr").each(function() {
						var i = 0;
						$(this).find("td").each(function() {
							i++;
							if (newrows[i] === undefined) {
								newrows[i] = $("<tr></tr>");
							}
							newrows[i].append($(this));
						});
					});
					$this.find("tr").remove();
					$.each(newrows, function() {
						$this.append(this);
					});
				});

			};

			if ($(window).width() < 992) {
				$changeTableView();
				winsize = 0;
			}

			$(window).on("resize", function() {

				if (Math.floor($(window).width() / 992) != winsize) {
					$changeTableView();
					winsize = Math.floor($(window).width() / 992);
				}
				if ($(window).width() > 992) {
					$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");
				}
			});
		}
		//table mobile view script//

		//for alternative row colors
		var i = 0;
		$('.even-strip').each(function() {
			if (i % 2 != 0) {
				$(this).addClass("coloredrow");
			}
			i++;
		});

		//for alternative row colors

		$('.roles-table input[type="checkbox"]').click(function() {
			select_each_row_mobile($(this));
		});
	});

</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.date-picker').datepicker({
			autoclose : true
		}).next().on(ace.click_event, function() {
			$(this).prev().focus();
		});
		if ($('.selectpicker').length) {
			$('.selectpicker').selectpicker({
			});
		}

		$('#min_customer').attr("disabled", true);
		$('#max_customer').attr("disabled", true);

		$(document).ajaxSuccess(function() {

			$('#min_customer').attr("disabled", false);
			$('#max_customer').attr("disabled", false);

		});

	});

	$(window).load(function() {
		$('#salesFilterAction').on('change', function() {
			var selectfilter = $(this).children(':selected').val();
			console.log(selectfilter);
			if (selectfilter != '') {
				$('#min_customer').attr("disabled", false);
				$('#max_customer').attr("disabled", false);
			} else {
				$('#min_customer').attr("disabled", true);
				$('#max_customer').attr("disabled", true);
			}
		});
	}); 
</script>
<script>
	function arPrint() {
		window.print();
	}
</script>
<?php echo $this -> Js -> writeBuffer(); ?>