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
	if(is_null($docType))
	{
		$docType = 'null';
	}
	if(is_null($docNo))
	{
		$docNo = 'null';
	}
	if(is_null($fromDate))
	{
		$fromDate = 'null';
	}
	if(is_null($toDate))
	{
		$toDate = 'null';
	}
	
	$options = array('zero'=>'0.00');	
	$orgname =	$final['orgname'];	
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
			Customer Statement Report
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Customer Statements
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600">
			<div class=" widthauto paddingleftrightzero pull-right padding-right-3 padding-right-3-480 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<div class="btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100">
					<?php echo $this->Html->link('Export to PDF',array('controller'=>'reports','action'=>'custStatementPdf', 'ex_pdf', $orgName, $docType, $docNo, $fromDate, $toDate),array('class'=>'report-button'));?>
				    <i class="icon-caret-down icon-on-right"></i>
				</div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<div class="btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400 mobile_100">
					<?php echo $this->Html->link('Export to Excel',array('controller'=>'reports','action'=>'custStatementExcel','ex_excel', $orgName, $docType, $docNo, $fromDate, $toDate),array('class'=>'report-button'));?>
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
					<?php if($orgname) {echo $orgname;} else { echo 'Customer Statements Report';} ?>
				</div>
				<?php echo $this->Form->create('CustomerStatement',array('id'=>'CustomerStatement','url'=>array('controller'=>'Reports','action'=>'customerStatement')));?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">
							<?php echo $this->Form->input('orgName',array('label'=>false, 'data-live-search'=>'true', 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Customer Name",'options'=>array(''=>'Customer Name', $organizations)));?>
						</div>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">						
							<?php echo $this->Form->input('docType',array('label'=>false, 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Document Type",'options'=>array(''=>'Document Type', 'invoice'=>'Invoice', 'payment'=>'Payment', 'credit'=>'Credit')));?>
						</div>
					</div>
					<div class="col-lg-2 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-full-480 mobile_100">						
						<?php echo $this->Form->input('docNo',array('label'=>false, 'placeholder'=>'Document No', 'id'=>"", 'class'=>"form-control"));?>
					</div>					
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">						
						<?php echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"id-date-picker-1", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format), 'default' => date($date_format, strtotime($fromDate)), 'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>					
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">						
						<?php echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"id-date-picker-1", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format), 'default' => date($date_format, strtotime($toDate)), 'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>					
					<div class="form-group filed-left margin-bottom-zero mobile_100">						
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn mobile_100','url' => array('controller'=>'Reports','action' => 'customerStatement'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading1')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading1')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">						
						<?php echo $this->Js->link('Reset',array('controller'=>'Reports','action'=>'customerStatement'),array('class'=>'btn btn-sm btn-primary filter-btn mobile_100','update'=>'#pageContent'));?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading1','style'=>'display:none;float: right;margin-right: 10%;'));?>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
	<?php if($final) { ?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 initialbalancerow no-padding-left no-padding-right">
				<div class="initialbalanceamt bold">
					<?php echo $this->Number->currency($init_bal_due,'',$options); ?>
				</div>
				<div class="initialbalance bold newinitialbalance balancepadding">
					Initial Balance Due (<?php $prev_date = date($date_format, strtotime($fromDate .' -1 day'));
					 echo 'As of '.$prev_date; ?>)
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	
	<?php if($final) { $initial_balance_due = $init_bal_due; ?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
				<?php foreach($final as $key1=>$value1) { 
					foreach($value1 as $key=>$value) {?>
				<table class="table table-striped roles-table mobile_customer">
					<tr>
						<td class="title_role bold rowwidth120px printdate textleft">Date<?php // echo $this->Js->link('Date',array('controller'=>'reports','action'=>'customerStatement','null', $orgName, $docType, $docNo, $fromDate, $toDate, $sortingOrder),array('update'=>'#pageContent'));?></td>
						<td class="title bold rowwidth120px printtype textleft">Document Type</td>
						<td class="title bold rowwidth120px printdoc textleft">Document No</td>
						<td class="title bold rowwidth200px printdesc textleft">Description</td>
						<td class="title bold rowwidth120px printamnt textright">Amount</td>
						<td class="title bold rowwidth120px printblnce textright">Balance Due</td>
					</tr>
					<?php
						if($value['doc_type'] == 'Payment' || $value['doc_type'] == 'Credit') {
							$bal_due   = $initial_balance_due - $value['amount'];
							$initial_balance_due = $bal_due;						
						} 
						if($value['doc_type'] == 'Invoice' || $value['doc_type'] == 'Credit Reversal') {
							$bal_due   = $initial_balance_due + $value['amount'];
							$initial_balance_due = $bal_due;
						}						
					?>																				
					<tr class="even-strip">
						<td class="title_role rowwidth120px printdate textleft"><?php echo date($date_format,strtotime($key1)); ?></td>
						<td class="title rowwidth120px printtype textleft"><?php echo $value['doc_type']; ?></td>
						<td class="title rowwidth120px printdoc textleft"><?php echo $value['doc_no']; ?></td>
						<td class="title rowwidth200px printdesc textleft"><?php if($value['doc_type'] == 'Payment') echo $value['doc_type']. ' Ref No: '.$value['doc_no'].', '. $orgname; 						
																	   else echo $value['doc_type']. ' No: '.$value['doc_no'].', '. $orgname; 
						?></td>
						<?php if($value['doc_type'] == 'Payment' || $value['doc_type'] == 'Credit') $paid = 'paid'; else $paid = '';?>
						<td class="title rowwidth120px printamnt textright <?php echo $paid; ?>"><?php if($paid == 'paid') echo '-'.$this->Number->currency($value['amount'],'',$options);
																							 else echo $this->Number->currency($value['amount'],'',$options);	
						 ?></td>
						<td class="title rowwidth120px printblnce textright"><?php echo $this->Number->currency($bal_due,'',$options); ?></td>
					</tr>
				</table>
				<?php  
					}
				} ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 initialbalancerow no-padding-left no-padding-right">
				<div class="initialbalanceamt bold"></div>
				<div class="initialbalance bold newinitialbalance"></div>
			</div>
		</div>
	</div>
	<?php if($final) { ?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 initialbalancerow no-padding-left no-padding-right">
				<div class="initialbalanceamt bold cust_amt_width">
					
				</div>
				<div class="initialbalance bold balancepadding">
					<?php ?>Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   <?php echo $this->Number->currency($final['totalAmount'],'',$options);?>     
				</div>
			</div>
		</div>
	</div>
	<?php } ?>
	<?php if($final) { ?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 allamount">
			All Amounts Displayed in <span style="color:red; font-weight: bold;"><?php echo $customerCurrencyCode; ?></span>
		</div>
	</div>
	<?php } ?>
	<?php if(!$final):?>
		<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<center>Please Select the <font color = "red"><b>Customer Name</b></font>  to list the data.</center>
		</div>
	</div>
		<?php endif;?>
</div>

<script type="text/javascript">

$(document).ready(function(){
	
	/* choosen select*/
		var config = {
			  
			  '.invdrop' : {search_contains:true}
			}
			for (var selector in config) {
			  $(selector).chosen(config[selector]);
		}
	/* choosen select*/
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
<script>
	function arPrint() {
		window.print();
	}
</script>
<?php echo $this->Js->writeBuffer();?>