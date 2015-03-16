<?php $this->CurrencySymbol->getAllCurrencies();?>

<?php echo $this->Session->flash();?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<?php $homeLink = $this->Breadcrumb->getLink('Home');?>	
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Reports',array('action'=>'index'),array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Customer',array('action'=>'index'),array('escape'=>FALSE));?>
		</li>
		<li class="active">
			Customer Statements
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Customer Statements
		</div>
		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-8 no-padding-left no-padding-right width-after-600">
			<div class=" widthauto paddingleftrightzero pull-right padding-right-3-480 width50p">
				<div class="btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400">
					<?php echo $this->Html->link('Export to PDF',array('controller'=>'reports','action'=>'custStatementPdf', 'ex_pdf', $orgName, $filterAction, $min, $max, $toDate),array('class'=>'report-button'));?>
				    <i class="icon-caret-down icon-on-right"></i>
				</div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p">
				<div class="btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400">
					<?php echo $this->Html->link('Export to Excel',array('controller'=>'reports','action'=>'custStatementExcel','ex_excel', $orgName, $filterAction, $min, $max, $toDate),array('class'=>'report-button'));?>
			    <i class="icon-caret-down icon-on-right"></i>
			    </div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 clear400 buttonrightwidth">
				<div class="btn btn-sm pull-right printbutton">
					Print <i class="icon-print icon-on-right"></i>
				</div>
			</div>
		</div>		
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive tableexpense">
				<div class="table-header">
					Customer Statements Report
				</div>
				<?php echo $this->Form->create('CustomerStatement',array('id'=>'CustomerStatement','url'=>array('controller'=>'Reports','action'=>'customerStatement')));?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field">
						<div class="input select">
							<select class="form-control selectpicker selectitem">
								<option value="">Customer Name</option>
								<option value="1">Invoice Balance</option>
								<option value="2">Balance</option>
							</select>
						</div>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field">
						<div class="input select">
							<select class="form-control selectpicker selectitem">
								<option value="">Document Type</option>
								<option value="1">Invoice Balance</option>
								<option value="2">Balance</option>
							</select>
						</div>
					</div>
					<div class="col-lg-2 form-group filed-left margin-bottom-zero no-padding-left no-padding-right">
						<input  class="form-control" i  type="text" placeholder="Document No" />
					</div>
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right">
						<input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy"                        Placeholder="From"/>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					
					
					
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right">
						<input class="form-control date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy"                        Placeholder="To"/>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero">						
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn','url' => array('controller'=>'Reports','action' => 'customerStatement'),'escape'=>false,'update' => '#pageContent'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">						
						<?php echo $this->Js->link('Reset',array('controller'=>'Reports','action'=>'customerStatement'),array('class'=>'btn btn-sm btn-primary filter-btn','update'=>'#pageContent'));?>
					</div>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">

				<table class="table table-striped roles-table">
					<tr>
						<td class="title_role bold rowwidth120px textleft">Date</td>
						<td class="title bold rowwidth120px ">Document Type</td>
						<td class="title bold rowwidth120px ">Document No</td>
						<td class="title bold rowwidth200px ">Description</td>
						<td class="title bold rowwidth120px textright">Amount</td>
						<td class="title bold rowwidth120px textright">Balance Due</td>
					</tr>
					<tr class="even-strip">
						<td class="title_role rowwidth120px ">20 Sep 2014</td>
						<td class="title rowwidth120px ">Invoice</td>
						<td class="title rowwidth120px ">INV-213</td>
						<td class="title rowwidth200px ">Integrated Multi RefNo:2134</td>
						<td class="title rowwidth120px textright">123.43</td>
						<td class="title rowwidth120px textright">123.43</td>
					</tr>
				</table>
				<table class="table table-striped roles-table">
					<tr>
						<td class="title_role bold rowwidth120px textleft">Date</td>
						<td class="title bold rowwidth120px textright">Document Type</td>
						<td class="title bold rowwidth120px textright">Document No</td>
						<td class="title bold rowwidth200px textright">Description</td>
						<td class="title bold rowwidth120px textright">Amount</td>
						<td class="title bold rowwidth120px textright">Balance Due</td>
					</tr>
					<tr class="even-strip">
						<td class="title_role rowwidth120px ">20 Sep 2014</td>
						<td class="title rowwidth120px ">Credit</td>
						<td class="title rowwidth120px ">CR-213</td>
						<td class="title rowwidth200px ">Integrated Multi RefNo:2134</td>
						<td class="title rowwidth120px textright paid">-123.43</td>
						<td class="title rowwidth120px textright">123.43</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 initialbalancerow no-padding-left no-padding-right">
				<div class="initialbalanceamt">
					0.00
				</div>
				<div class="initialbalance">
					Initial Balance Due
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 initialbalancerow no-padding-left no-padding-right">
				<div class="initialbalanceamt bold">
					7500.00
				</div>
				<div class="initialbalance bold">
					Total&nbsp;&nbsp;&nbsp;&nbsp;7500.00
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 allamount">
			All Amounts Displayed in <span class="due">USD</span>
		</div>
	</div>
</div>

<script type="text/javascript">

$(document).ready(function(){
//table mobile view script//	
	 if($('.roles-table-wrapper-inner').length)
		{
			var winsize = 1;
			if($('.roles-table').length)
			{
				var i=1;
				$('.roles-table').each(function(){
					$(this).addClass("role-table-"+i);
					i++;
				});
			}
			$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");
			
				$changeTableView = function(){
					$(".table").each(function() {
						var $this = $(this);
						var newrows = [];
						$this.find("tr").each(function(){
							var i = 0;
							$(this).find("td").each(function(){
								i++;
								if(newrows[i] === undefined) { newrows[i] = $("<tr></tr>"); }
								newrows[i].append($(this));
							});
						});
						$this.find("tr").remove();
						$.each(newrows, function(){
							$this.append(this);
						});
					});
					
				};
			
			if($(window).width()<992)
			{
				$changeTableView();
				winsize = 0;
			}
			
			$(window).on("resize", function(){
				
				if(Math.floor($(window).width()/992)!=winsize)
				{
					$changeTableView();
					winsize = Math.floor($(window).width()/992);
				}
				if($(window).width()>992)
				{
					$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");
				}
			});	
		}
//table mobile view script//
			
		
//for alternative row colors
		var i=0;
		$('.even-strip').each(function(){
		if(i%2!=0) 
		{
		$(this).addClass("coloredrow");
		}
		i++;
		});

//for alternative row colors

$('.roles-table input[type="checkbox"]').click(function(){
	select_each_row_mobile($(this));
});
});

</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
	   if($('.selectpicker').length){
		   $('.selectpicker').selectpicker({
		   });
		}			
   });
</script>
<?php echo $this->Js->writeBuffer();?>