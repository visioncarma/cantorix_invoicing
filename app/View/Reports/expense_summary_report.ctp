<?php echo $this->Html->css(array('print.css'), 'stylesheet', array('media' => 'print')); ?>
<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php 
		$dbFormat = array("d", "M", "Y");
		$scriptFormat   = array("dd", "mm", "yyyy");
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
	$reportsLink =  $this->Breadcrumb->getLink('Reports');?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Reports',$reportsLink);?>
		</li>
		<li class="active">
			Expense Summary Report
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Expense Summary
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600">
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 padding-right-3-480 width50p margin-top-10-420 buttonrightwidth ">
				<div class="btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100">
					<?php echo $this->Html->link('Export to PDF',array('controller'=>'reports','action'=>'expensePdf',$sortBy,$sortingOrder,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount,$data_from_date,$data_to_date),array('class'=>'report-button','confirm'=>'Click on "Ok" to start the export.'));?>
					<!--i class="icon-caret-down icon-on-right"></i-->
				</div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<?php echo $this->Html->link('Export to Excel',array('controller'=>'reports','action'=>'expenseExcel',$sortBy,$sortingOrder,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount,$data_from_date,$data_to_date),array('class'=>'btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400 mobile_100','confirm'=>'Click on "Ok" to start the export.'));?>
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
					Expense Summary Report
				</div>
				<?php echo $this->Form->create('expense_summary_report',array('id'=>'expense','url'=>array('controller'=>'Reports','action'=>'expenseSummaryReport')));?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">
							<?php echo $this->Form->input('customer_name',array('label'=>false, 'data-live-search'=>'true', 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Customer Name",'options'=>array(''=>'Customer Name', $organizations),'default'=>$data_customer_name));?>
						 
						</div>
					</div>
					
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">
							<?php echo $this->Form->input('expense_status',array('label'=>false, 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Expense Status",'options'=>array(''=>'Expense Status',$expense_status_list),'default'=>$data_status));?>
						</div>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">
							<?php echo $this->Form->input('expense_category_id',array('label'=>false, 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Expense Category", 'options'=>array(''=>'Expense Category',$expense_categories),'default'=>$data_category_id));?>
						</div>
					</div>
					<div class="col-lg-1 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-full-480 mobile_100">
						 
						  <?php  
						  if($data_min_amount=='null'){
						  	$data_min_amount ='';
						  }else{
						  	$data_min_amount=$data_min_amount;
						  }
						  
						  echo $this->Form->input('min_amount',array('label'=>false, 'placeholder'=>'Min Amount', 'id'=>"min_amount", 'class'=>"form-control" ,'default'=>$data_min_amount));?>
						 
						 
					</div>
					<div class="col-lg-1 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-full-480 mobile_100">
						<?php  
						
						
						 if($data_max_amount=='null'){
						  	$data_max_amount ='';
						  }else{
						  	$data_max_amount=$data_max_amount;
						  }
						
						 
							echo $this->Form->input('max_amount',array('label'=>false, 'placeholder'=>'Max Amount', 'id'=>"max_amount", 'class'=>"form-control",'default'=>$data_max_amount));
					 
						?>
					</div>
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">						
						<?php echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"id-date-picker-1", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format),'readonly'=>'readonly','style'=>'cursor:default','value'=>date($date_format,strtotime(date('Y-m-01'))))); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">						
						<?php echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"id-date-picker-1", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format),'readonly'=>'readonly','style'=>'cursor:default','value'=>date($date_format,strtotime(date('Y-m-d'))))); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn mobile_100','url' => array('controller'=>'Reports','action' => 'expenseSummaryReport'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading1')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading1')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'Reports','action'=>'expenseSummaryReport'),array('class'=>'btn btn-sm btn-primary filter-btn mobile_100','update'=>'#pageContent'));?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading1','style'=>'display:none;float: right;margin-right: 10%;'));?>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
	
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom5">		 
				<?php foreach($expenseReport as $key=>$val):?>	 
				<table class="table table-striped roles-table">
					<tr>
						<td class="title_role bold rowwidth120px  textleft">
							<?php echo $this->Js->link('Status',array('controller'=>'Reports','action'=>'expenseSummaryReport','Status',$sortingOrder,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount),array('update'=>'#pageContent'));?>
						</td>
						<td class="title_role bold rowwidth120px  textleft">
							<?php echo $this->Js->link('Expense Date',array('controller'=>'Reports','action'=>'expenseSummaryReport','Expense_Date',$sortingOrder,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount),array('update'=>'#pageContent'));?>
						</td>
						<td class="title_role bold rowwidth120px  textleft">
							<?php echo $this->Js->link('Ref No',array('controller'=>'Reports','action'=>'expenseSummaryReport','Ref_No',$sortingOrder,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount),array('update'=>'#pageContent'));?>
						</td>
						<td class="title_role bold rowwidth120px  textleft">
							<?php echo $this->Js->link('Customer Name',array('controller'=>'Reports','action'=>'expenseSummaryReport','Customer Name',$sortingOrder,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount),array('update'=>'#pageContent'));?>
						</td>
						<td class="title_role bold rowwidth120px  textleft">
							<?php echo $this->Js->link('Category',array('controller'=>'Reports','action'=>'expenseSummaryReport','Category',$sortingOrder,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount),array('update'=>'#pageContent'));?>
						</td>
						<td class="title bold rowwidth120px textright">
							<?php echo $this->Js->link('Expense Amount',array('controller'=>'Reports','action'=>'expenseSummaryReport','Expense_Amount',$sortingOrder,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount),array('update'=>'#pageContent'));?>
						</td>
						<td class="title bold rowwidth120px textright">
							<?php echo $this->Js->link('Tax Amount',array('controller'=>'Reports','action'=>'expenseSummaryReport','Tax_Amount',$sortingOrder,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount),array('update'=>'#pageContent'));?>
						</td>
						<td class="title bold rowwidth120px textright">
							<?php echo $this->Js->link('Expense Amount (Incl Tax)',array('controller'=>'Reports','action'=>'expenseSummaryReport','Expense_Amount_Incltax',$sortingOrder,$data_customer_name,$data_status,$data_category_id,$data_min_amount,$data_max_amount),array('update'=>'#pageContent'));?>
						</td>
					</tr>
			 
			 
					<tr class="even-strip">
						<td class="title_role rowwidth120px textleft">
						<?php
						$status =$val['status'];
					 
						if($status =='Billable'){
						   $color = '#7AA7C9'; 
						}elseif($status =='Billed'){
						  $color = '#69AA2C';	
						}else{
						  $color = '#2B2B2B';
						} 
						 ?>
						
						<span style="color:<?php echo $color;?>;">
						      <?php echo $val['status'];?>
						</span>
						
						</td>
						<td class="title_role rowwidth120px textleft"><?php echo date($date_format,strtotime($val['expense_date'])); ?></td>
						<td class="title_role rowwidth120px textleft"><?php echo $val['ref_no'];?></td>
                        <td class="title_role rowwidth120px textleft"><?php echo $val['customer_name'];?></td>						 
						<td class="title_role rowwidth120px textleft"><?php echo $val['category'];?></td>		
						 
						<td class="title rowwidth120px textright"><?php echo $this->Number->format($val['expense_amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
					    <td class="title rowwidth120px textright"><?php echo $this->Number->format($val['tax_amount'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
					    <td class="title rowwidth120px textright"><?php echo $this->Number->format($val['expense_amount_incl_tax'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
					</tr>
				
				
				
				</table>
			 <?php endforeach; ?>
				
					<table class="table table-striped newtotal1 roles-table">
                        <tr>
                          	<td class="title_role bold rowwidth120px  textleft">
								
							</td>
							<td class="title_role bold rowwidth120px  textleft">
								Total
							</td>
							<td class="title_role bold rowwidth120px  textleft">
								
							</td>
							<td class="title_role bold rowwidth120px  textleft">
								
							</td>
							<td class="title_role bold rowwidth120px  textleft">
								
							</td>
							<td class="title bold rowwidth120px textright">
								
							</td>
							<td class="title bold rowwidth120px textright">
								
							</td>
							<td class="title bold rowwidth120px textright">
								Total
							</td>
                      	</tr>
                      <tr class="even-strip">
                          
                            <td class="title_role bold rowwidth120px  textleft">
								
							</td>
							<td class="title_role bold rowwidth120px  textleft">
								Total
							</td>
							<td class="title_role bold rowwidth120px  textleft">
								
							</td>
							<td class="title_role bold rowwidth120px  textleft">
								
							</td>
							<td class="title_role bold rowwidth120px  textleft">
								
							</td>
							<td class="title bold rowwidth120px textright">
								
							</td>
							<td class="title bold rowwidth120px textright">
								
							</td>
							<td class="title bold rowwidth120px textright">
								<?php echo $this->Number->format($total_amount,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?>
							</td>
                      </tr>
           </table>
           
          
           
           
               </div>
			</div>
		</div>
	
	
	
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 allamount">
			All Amounts Displayed in <span class="red bold"><?php echo $subscriberCurrencyCode;?></span>
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

$('.newtotal1').find('tr:first').addClass("hidden-row");
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
					$('.newtotal1').find('tr:last').removeClass("hidden-row");
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

		/*$('.roles-table input[type="checkbox"]').click(function() {
			select_each_row_mobile($(this));
		});*/
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
		$('#agingAge-past').on('change', function(){
			var selectfilter = $(this).children(':selected').val();
			console.log(selectfilter);
			if(selectfilter == 'total'){
				$('#min_customer').attr("disabled", false);
				$('#max_customer').attr("disabled", false);
			}
			else{
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
<?php echo $this->Js->writeBuffer();?>