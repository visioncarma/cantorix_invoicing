<?php echo $this -> Html -> css(array('print.css'), 'stylesheet', array('media' => 'print')); ?>
<?php 
		$dbFormat = array("d", "M", "Y");
		$scriptFormat   = array("dd", "mm", "yyyy");
?>
<?php $this->CurrencySymbol->getAllCurrencies();
	if(is_null($orgName))
	{
		$orgName = 'null';
	}
	if(is_null($filterAction))
	{
		$filterAction = 'null';
	}
	if(is_null($min))
	{
		$min = 'null';
	}
	if(is_null($max))
	{
		$max = 'null';
	}
	if(is_null($toDate))
	{
		$toDate = 'null';
	}
?>

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
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Reports',"$reportsLink");?>
		</li>
		<li class="active">
			Customer Balance Report
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Customer Balances
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600">			
			
			<div class=" widthauto paddingleftrightzero pull-right padding-right-3 padding-right-3-480 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<div class="btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100">
					<?php echo $this->Html->link('Export to PDF',array('controller'=>'reports','action'=>'custBalPdf', 'ex_pdf', $orgName, $filterAction, $min, $max, $toDate),array('class'=>'report-button'));?>
					<i class="icon-caret-down icon-on-right"></i>
				</div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<div class="btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400 mobile_100">
					<?php echo $this->Html->link('Export to Excel',array('controller'=>'reports','action'=>'custBalExcel','ex_excel', $orgName, $filterAction, $min, $max, $toDate),array('class'=>'report-button'));?>
			    <i class="icon-caret-down icon-on-right"></i>
			    </div>
			</div>			
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<div class="btn btn-sm pull-right printbutton col-xs-12">
					<a class = "report-button" href="javascript:void()" onclick="arPrint()">Print <i class="icon-print icon-on-right"></i></a>
				</div>
			</div>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive tableexpense">
				<div class="table-header">
					Customer Balances Report
				</div>
				<?php echo $this->Form->create('CustomerBalance',array('id'=>'CustomerBalance','url'=>array('controller'=>'Reports','action'=>'customerBalance')));?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="col-lg-2 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-full-480 filter-select-width-new form-filter-field mobile_100 choosen_width">						
						<?php if($orgName== 'null'){$orgNameVal = '';}else{$orgNameVal = $orgName;} 
						echo $this->Form->input('orgName', array('label'=>false, 'data-live-search'=>'true', 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Customer Name", 'options'=>array(''=>'Customer Name', $organizations)));					
						// echo $this->Form->input('orgName',array('label'=>false, 'placeholder'=>'Customer Name', 'id'=>"", 'value'=>$orgNameVal, 'class'=>"form-control"));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100 choosen_width">
						<div class="input select">							
							<?php echo $this->Form->input('filterAction',array('label'=>false, 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Invoice Balance",'options'=>array('invoice_balance'=>'Invoice Balance','credit_balance'=>'Credit Balance','balance'=>'Balance'),'default'=>$filterAction));?>
						</div>
					</div>
					<div class="col-lg-2 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-full-480 mobile_100">						
						<?php if($min == 'null'){$minVal = '';}else{$minVal = $min;} echo $this->Form->input('min',array('label'=>false, 'placeholder'=>'Min Amount', 'id'=>"", 'value'=>$minVal, 'class'=>"form-control"));?>
					</div>
					<div class="col-lg-2 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-full-480 mobile_100">						
						<?php if($max == 'null'){$maxVal = '';}else{$maxVal = $max;} echo $this->Form->input('max',array('label'=>false, 'placeholder'=>'Max Amount', 'id'=>"", 'value'=>$maxVal, 'class'=>"form-control"));?>
					</div>
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">						
						<?php if($toDate){$toDateVal = date($date_format,strtotime($toDate));} echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"id-date-picker-1", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format), 'default'=>$toDateVal, 'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">						
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn mobile_100','url' => array('controller'=>'Reports','action' => 'customerBalance'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading1')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading1')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">						
						<?php echo $this->Js->link('Reset',array('controller'=>'Reports','action'=>'customerBalance'),array('class'=>'btn btn-sm btn-primary filter-btn mobile_100','update'=>'#pageContent'));?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading1','style'=>'display:none;float: right;margin-right: 6%;'));?>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
				<?php foreach($final_array as $key=>$value) { ?>
				<table class="table table-striped roles-table">
					<tr>
						<td class="title_role bold rowwidth120px textleft"><?php echo $this->Js->link('Customer Name',array('controller'=>'reports','action'=>'customerBalance','null', $orgName, $filterAction, $min, $max, $toDate, $sortingOrder, 'Customer Name'),array('update'=>'#pageContent'));?></td>
						<td class="title bold rowwidth200px textright"><?php echo $this->Js->link('Invoice Balance',array('controller'=>'reports','action'=>'customerBalance','null', $orgName, $filterAction, $min, $max, $toDate, $sortingOrder, 'Invoice Balance'),array('update'=>'#pageContent'));?></td>
						<td class="title bold rowwidth200px textright"><?php echo $this->Js->link('Credit Balance',array('controller'=>'reports','action'=>'customerBalance','null', $orgName, $filterAction, $min, $max, $toDate, $sortingOrder, 'Credit Balance'),array('update'=>'#pageContent'));?></td>
						<td class="title bold rowwidth200px textright"><?php echo $this->Js->link('Balance',array('controller'=>'reports','action'=>'customerBalance','null', $orgName, $filterAction, $min, $max, $toDate, $sortingOrder, 'Balance'),array('update'=>'#pageContent'));?></td>
					</tr>
					<?php $options = array('zero'=>'0.00');?> 
					<tr class="even-strip">
						<td class="title_role rowwidth120px textleft"><?php echo $value['organizationName'];?></td>
						<td class="title rowwidth200px textright"><?php echo $this->Number->currency($value['invoiceBalance'],$value['custCrncyCode']);?></td>
						<td class="title rowwidth200px textright"><?php echo $this->Number->currency($value['creditBalance'], $value['custCrncyCode']);?></td>
						<td class="title rowwidth200px textright"><?php echo $this->Number->currency($value['balance'],$value['custCrncyCode']);?></td>
					</tr>					
				</table>
				<?php } ?>							
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
	}); 
</script>
<script>
	function arPrint() {
		window.print();
	}
</script>
<?php echo $this->Js->writeBuffer();?>