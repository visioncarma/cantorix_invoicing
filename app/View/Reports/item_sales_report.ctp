<?php echo $this->Html->css(array('print.css'), 'stylesheet', array('media' => 'print')); ?>
<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php echo $this->Session->flash();?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<?php $homeLink = $this->Breadcrumb->getLink('Home');
		  $reportsLink = $this->Breadcrumb->getLink('Reports');
	?>
	<?php 
		$dbFormat = array("d", "M", "Y");
		$scriptFormat   = array("dd", "mm", "yyyy");
	?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Reports',"$reportsLink");?>
		</li>
		<li class="active">
			Item Sales
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Item Sales
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600">
			<div class=" widthauto paddingleftrightzero pull-right padding-right-3 padding-right-3-480 width50p margin-top-10-420 buttonrightwidth mobile_100 ">
				<div class="btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100">
					<?php $fromDatePass = date('Y-m-d',strtotime($fromDate));
						  $toDatePass	= date('Y-m-d',strtotime($toDate));
					?>
					<?php echo $this->Html->link('Export to PDF',array('controller'=>'reports','action'=>'itemSalesPdf','ex_pdf',$sortBy,$sortingOrder,$itemName,$filterAction,$min,$max,$fromDatePass,$toDatePass),array('class'=>'report-button','confirm'=>'Click on "Ok" to start the export.'));?>
					<!--i class="icon-caret-down icon-on-right"></i-->
				</div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<?php echo $this->Html->link('Export to Excel',array('controller'=>'reports','action'=>'itemSalesExcel','ex_excel',$sortBy,$sortingOrder,$itemName,$filterAction,$min,$max,$fromDatePass,$toDatePass),array('class'=>' importbutton btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400 mobile_100','confirm'=>'Click on "Ok" to start the export.'));?>
			    <!--i class="icon-caret-down icon-on-right"></i-->
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<div class="btn btn-sm pull-right printbutton col-xs-12">
					<a href="javascript:void()" onclick="arPrint()">Print <i class="icon-print icon-on-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive tableexpense">
				<div class="table-header">
					Item Sales Report
				</div>
				<?php echo $this->Form->create('item-sale',array('id'=>'item-sale))','url'=>array('controller'=>'Reports','action'=>'itemSalesReport')));?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select max-width max-height choosen_width">
							<?php echo $this->Form->input('item-name',array('label'=>false, 'placeholder'=>'Item Name', 'id'=>"item-name",'data-live-search'=>'true', 'class'=>"form-control invdrop selectitem",'data-placeholder'=>"Select Item",'options'=>array(''=>'Select Item',$soldItem),'default'=>$itemName));?>
						</div>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">
							<?php echo $this->Form->input('filterAction',array('label'=>false, 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Select Filter Option",'options'=>array(''=>'Select Filter Option','item-sold'=>'# Items','Amount'=>'Amount','avgSale'=>'Average Price'),'default'=>$filterAction));?>
						</div>
					</div>
					<div class="col-lg-1 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-full-480 mobile_100">
						<?php 
						if($min && ($min!=0)){
							echo $this->Form->input('min',array('label'=>false, 'placeholder'=>'Min Value', 'id'=>"min_customer", 'class'=>"form-control",'value'=>$min));
						}else{
							echo $this->Form->input('min',array('label'=>false, 'placeholder'=>'Min Value', 'id'=>"min_customer", 'class'=>"form-control"));
						}
						?>
					</div>
					<div class="col-lg-1 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-full-480 mobile_100">
						<?php 
							if($max && ($max!=0)){
								echo $this->Form->input('max',array('label'=>false, 'placeholder'=>'Max Value', 'id'=>"max_customer", 'class'=>"form-control",'value'=>$max));
							}else{
								echo $this->Form->input('max',array('label'=>false, 'placeholder'=>'Max Value', 'id'=>"max_customer", 'class'=>"form-control"));
							}
						?>
					</div>
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">
						<?php echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From Date', 'id'=>"id-date-picker-1", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format), 'default'=>date($date_format,strtotime(date('Y-m-01'))), 'readonly'=>'readonly','style'=>'cursor:default','value'=>date($date_format,strtotime($fromDate)))); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">
						<?php echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"id-date-picker-2", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format), 'default'=>date($date_format), 'readonly'=>'readonly','style'=>'cursor:default','value'=>date($date_format,strtotime($toDate)))); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn mobile_100','url' => array('controller'=>'Reports','action' => 'itemSalesReport'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading1')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading1')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'Reports','action'=>'itemSalesReport'),array('class'=>'btn btn-sm btn-primary filter-btn mobile_100','update'=>'#pageContent'));?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading1','style'=>'display:none;float: right;margin-right: 10%;'));?>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom sales-table">
				<?php
					$i=1;
					$totalItemSold = count($itemData) ;
				?>
				<?php foreach($itemData as $key=>$val):?>
				<table class="table table-striped roles-table">
					<tr>
						<td class="title_role bold rowwidth120px  textleft">
							<?php echo $this->Js->link('Item Name',array('controller'=>'Reports','action'=>'itemSalesReport','Item Name',$sortingOrder,$itemName,$filterAction,$min,$max,$fromDate,$toDate),array('update'=>'#pageContent'));?>
						</td>
						<td class="title bold rowwidth200px textleft">Item Description</td>
						<td class="title bold rowwidth120px textright">
							<?php echo $this->Js->link('# Items',array('controller'=>'Reports','action'=>'itemSalesReport','# Items',$sortingOrder,$itemName,$filterAction,$min,$max,$fromDate,$toDate),array('update'=>'#pageContent'));?>
						</td>
						<td class="title bold rowwidth120px textright">
							<?php echo $this->Js->link('Amount',array('controller'=>'Reports','action'=>'itemSalesReport','Amount',$sortingOrder,$itemName,$filterAction,$min,$max,$fromDate,$toDate),array('update'=>'#pageContent'));?>
						</td>
						<td class="title bold rowwidth120px textright">
							<?php echo $this->Js->link('Average Price',array('controller'=>'Reports','action'=>'itemSalesReport','Average Price',$sortingOrder,$itemName,$filterAction,$min,$max,$fromDate,$toDate),array('update'=>'#pageContent'));?>
						</td>
					</tr>
					<tr class="even-strip">
						<td class="title_role rowwidth120px textleft"><?php echo $val['Inventory Name'];?></td>
						<td class="title rowwidth200px textleft"><?php echo $val['Inventory Description']?></td>
						<td class="title rowwidth120px textright"><?php echo $val['# Item'];?></td>
						<td class="title rowwidth120px textright"><?php echo $this->Number->format($val['Amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
						<td class="title rowwidth120px textright"><?php echo $this->Number->format($val['Average Price'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
					</tr>
					<?php $i++;?>
				</table>
				<?php endforeach; ?>
					<table class="table table-striped roles-table fixtotal">
                        <tr>
                           <td class="title_role bold rowwidth120px  textleft">Item Name</td>
                           <td class="title bold rowwidth200px textleft rowwanish"></td>
                           <td class="title bold rowwidth120px textright"># Items</td>
                           <td class="title bold rowwidth120px textright">Amount</td>
                           <td class="title bold rowwidth120px textright">Average Price</td>    
                      </tr>
                      <tr class="even-strip">
                           <td class="title_role rowwidth120px textleft bold">Total</td>
                           <td class="title rowwidth200px textright  bold"></td>
                           <td class="title rowwidth120px textright bold"><?php echo $total['Total Sold Item'];?></td>
                           <td class="title rowwidth120px textright bold"><?php echo $this->Number->format($total['Total Amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
                           <td class="title rowwidth120px textright bold"><?php echo $this->Number->format($total['Total Average Price'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
                      </tr>
                </table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 allamount">
			All Amounts Displayed in <span style="color:red; font-weight: bold;"><?php echo $subscriberCurrencyCode;?></span>
		</div>
	</div>
</div>

<!-- inline scripts related to this page -->

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
		$('#item-saleFilterAction').on('change', function(){
			var selectfilter = $(this).children(':selected').val();
			console.log(selectfilter);
			if(selectfilter == ''){
				$('#min_customer').attr("disabled", true);
				$('#max_customer').attr("disabled", true);
			}
			else{
				$('#min_customer').attr("disabled", false);
				$('#max_customer').attr("disabled", false);
			}
		});
		$(document).ajaxSuccess(function(){
			
				$('#min_customer').attr("disabled", false);
				$('#max_customer').attr("disabled", false);
				
			
		
		});
	}); 
</script>
<script>
	function arPrint() {
		window.print();
	}
</script>
<?php echo $this->Js->writeBuffer();?>