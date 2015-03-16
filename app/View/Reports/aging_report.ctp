<?php echo $this -> Html -> css(array('print.css'), 'stylesheet', array('media' => 'print')); ?>
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
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Reports',"$reportsLink");?>
		</li>
		<li class="active">
			Account Aging Report
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Account Aging Report
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600 ">
			
			<div class=" widthauto paddingleftrightzero pull-right padding-right-3 padding-right-3-480 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<div class="btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100">
					<?php echo $this->Html->link('Export to PDF',array('controller'=>'reports','action'=>'agingPdf','ex_pdf',$sortBy,$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('class'=>'report-button','confirm'=>'Click on "Ok" to start the export.'));?>
					<!--i class="icon-caret-down icon-on-right"></i-->
				</div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<?php echo $this->Html->link('Export to Excel',array('controller'=>'reports','action'=>'agingExcel','ex_excel',$sortBy,$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('class'=>' importbutton btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400 mobile_100','confirm'=>'Click on "Ok" to start the export.'));?>
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
					Account Aging Report
				</div>
				<?php echo $this->Form->create('aging',array('id'=>'aging','url'=>array('controller'=>'Reports','action'=>'agingReport')));?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">
							<?php echo $this->Form->input('customer-name',array('label'=>false, 'placeholder'=>'Customer Name', 'id'=>"",'data-live-search'=>'true', 'class'=>"form-control invdrop",'data-placeholder'=>"Select Customer Name",'options'=>array(''=>'',$listCustomer)));?>
						</div>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">
							<?php echo $this->Form->input('age-past',array('label'=>false, 'class'=>'form-control invdrop selectitem mobile_100','data-placeholder'=>"Select Filter Option",'options'=>array(''=>'Select Filter Option',$bucketList,'total'=>'Due Total')));?>
						</div>
					</div>
					<div class="col-lg-1 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-full-480 mobile_100">
						<?php echo $this->Form->input('min',array('label'=>false, 'placeholder'=>'Min Value', 'id'=>"min_customer", 'class'=>"form-control"));?>
					</div>
					<div class="col-lg-1 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-full-480 mobile_100">
						<?php echo $this->Form->input('max',array('label'=>false, 'placeholder'=>'Max Value', 'id'=>"max_customer", 'class'=>"form-control"));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn mobile_100','url' => array('controller'=>'Reports','action' => 'agingReport'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading1')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading1')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'Reports','action'=>'agingReport'),array('class'=>'btn btn-sm btn-primary filter-btn mobile_100','update'=>'#pageContent'));?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading1','style'=>'display:none;float: right;margin-right: 35%;'));?>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
	<?php if($agingArray){?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom sales-table">
				
				<?php foreach($agingArray as $key=>$val):?>
					<?php if($val):?>
				<table class="table table-striped roles-table">
					<tr>
						<td class="title_role bold rowwidth120px printcustomer wordwrap">
							<?php echo $this->Js->link('Customer Name',array('controller'=>'Reports','action'=>'agingReport','Customer Name',$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));?>
						</td>
						<td class="title bold rowwidth120px textright printldate">
							<?php echo $this->Js->link('Last Payment Date',array('controller'=>'Reports','action'=>'agingReport','Last Payment Date',$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));?>
						</td>
						<td class="title bold rowwidth120px textright printlamount">
							<?php echo $this->Js->link('Last Payment Amount',array('controller'=>'Reports','action'=>'agingReport','Last Payment Amount',$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));?>
						</td>
						<?php foreach($bucketList as $bucketId=>$bucketValue):?>
						<td class="title bold rowwidth120px textright printdays">
							<?php echo $this->Js->link($bucketValue,array('controller'=>'Reports','action'=>'agingReport','Bucket',$sortingOrder,$bucketValue,$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));?>
						</td>
						<?php endforeach;?>
						<td class="title bold rowwidth120px textright printtamount">
							<?php echo $this->Js->link('Total Due',array('controller'=>'Reports','action'=>'agingReport','Total',$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));?>
						</td>
					</tr>
					<tr class="even-strip">
						<td class="title_role rowwidth120px printcustomer wordwrap"><?php echo $val['organizationName'];?></td>
						<td class="title rowwidth120px textright printldate">
							<?php if($val['lastPaymentDate']){
									 echo date($date_format,strtotime($val['lastPaymentDate']));
								  }else{
							 		echo "--";
								  }?>
						</td>
						<td class="title rowwidth120px textright printlamount wordwrap"><?php echo $this->Number->format($val['Paid'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
						<?php foreach($bucketList as $bucketId1=>$bucketValue1):?>
						<td class="title rowwidth120px textright printdays wordwrap"><?php echo $this->Number->format($val[$bucketValue1],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
						<?php $column[$bucketId1] += $val[$bucketValue1]?>
						<?php endforeach; ?>
						<td class="title rowwidth120px textright bold printtamount wordwrap"><?php echo $this->Number->format($val['rowTotal'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
						<?php $rowTotal += $val['rowTotal'];?>
					</tr>
					<?php $i++;?>
				</table>
				<?php endif;?>
				<?php endforeach; ?>
					<table class="table table-striped roles-table fixtotal ageingreporttable">
                        <tr>
                           <td class="title_role bold rowwidth120px printcustomer wordwrap">Customer Name</td>
                           <td class="title bold rowwidth120px textright printldate"></td>
                           <td class="title bold rowwidth120px textright printlamount wordwrap"></td>
                           <?php foreach($bucketList as $bucketId=>$bucketValue):?>
                           	<td class="title bold rowwidth120px textright printdays wordwrap"><?php echo $bucketValue;?></td>
                           <?php endforeach; ?>
                           <td class="title bold rowwidth120px textright printtamount">Total Due</td>
                      	</tr>
                      <tr class="even-strip">
                           <td class="title_role rowwidth120px  bold printcustomer"></td>
                           <td class="title rowwidth120px textright bold printldate"></td>
                           <td class="title rowwidth120px textright bold printlamount wordwrap">Total</td>
                           <?php foreach($bucketList as $bucketId=>$bucketValue):?>
                     	      <td class="title rowwidth120px textright bold printdays wordwrap"><?php echo $this->Number->format($column[$bucketId],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
                     	  <?php endforeach ;?>
                     	  <td class="title rowwidth120px textright bold printtamount wordwrap"><?php echo $this->Number->format($rowTotal,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
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
	<?php }else{ ?>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom sales-table">
					<table class="table table-striped roles-table">
						<tr>
							<td class="title_role bold rowwidth120px printcustomer wordwrap">
								<?php echo $this->Js->link('Customer Name',array('controller'=>'Reports','action'=>'agingReport','Customer Name',$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));?>
							</td>
							<td class="title bold rowwidth120px textright printldate">
								<?php echo $this->Js->link('Last Payment Date',array('controller'=>'Reports','action'=>'agingReport','Last Payment Date',$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));?>
							</td>
							<td class="title bold rowwidth120px textright printlamount">
								<?php echo $this->Js->link('Last Payment Amount',array('controller'=>'Reports','action'=>'agingReport','Last Payment Amount',$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));?>
							</td>
							<?php foreach($bucketList as $bucketId=>$bucketValue):?>
							<td class="title bold rowwidth120px textright printdays">
								<?php echo $this->Js->link($bucketValue,array('controller'=>'Reports','action'=>'agingReport','Bucket',$sortingOrder,$bucketValue,$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));?>
							</td>
							<?php endforeach;?>
							<td class="title bold rowwidth120px textright printtamount">
								<?php echo $this->Js->link('Total Due',array('controller'=>'Reports','action'=>'agingReport','Total',$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));?>
							</td>
						</tr>
					</table>
					<table class="table table-striped roles-table">
                        <tr>
                           <td class="title_role bold rowwidth120px printcustomer wordwrap">Customer Name</td>
                           <td class="title bold rowwidth120px textright printldate"></td>
                           <td class="title bold rowwidth120px textright printlamount"></td>
                           <?php foreach($bucketList as $bucketId=>$bucketValue):?>
                           	<td class="title bold rowwidth120px textright printdays"><?php echo $bucketValue;?></td>
                           <?php endforeach; ?>
                           <td class="title bold rowwidth120px textright printtamount">Total Due</td>
                      	</tr>
                      	<tr class="even-strip">
                           <td class="title_role rowwidth120px  bold printcustomer"></td>
                           <td class="title rowwidth120px textright bold printldate"></td>
                           <td class="title rowwidth120px textright bold printlamount">Total</td>
                           <?php foreach($bucketList as $bucketId=>$bucketValue):?>
                     	      <td class="title rowwidth120px textright bold printdays"><?php echo $this->Number->format($column[$bucketId],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
                     	  <?php endforeach ;?>
                     	  <td class="title rowwidth120px textright bold printtamount"><?php echo $this->Number->format($rowTotal,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?></td>
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
	<?php }  ?>
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