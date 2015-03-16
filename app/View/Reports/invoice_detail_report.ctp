<?php echo $this->Html->css(array('print.css'), 'stylesheet', array('media' => 'print')); ?>
  <?php $this->CurrencySymbol->getAllCurrencies();
  	$options = array('zero'=>'0.00');	?>
<?php 
	$dbFormat = array("d", "M", "Y");
	$scriptFormat   = array("dd", "mm", "yyyy");
?>
    <?php echo $this->Session->flash();?>
   <script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>
    
        <?php $homeLink = $this->Breadcrumb->getLink('Home');
           $reportsLink = $this->Breadcrumb->getLink('Reports');?>	
        <div class="breadcrumbs" id="breadcrumbs"> 
          <script type="text/javascript">
				 try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		  </script>
		  <ul class="breadcrumb">
				<li>
					    <?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
				</li>
				<li>
						<?php echo $this->Html->link('Reports',$reportsLink);?>
				</li>
				<li class="active">
					Invoice Detail Report
				</li>
			</ul>
        </div>
                
        <div class="page-content invoice_details_report">
          <div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Invoice Detail Report
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600">
			<div class=" widthauto paddingleftrightzero pull-right padding-right-3 padding-right-3-480 width50p margin-top-10-420 buttonrightwidth  ">
				<div class="btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100">
					<?php echo $this->Html->link('Export to PDF',array('controller'=>'reports','action'=>'invoicedetailPdf',$data_customer_name,$data_status,$data_from_date,$data_to_date),array('class'=>'report-button','confirm'=>'Click on "Ok" to start the export.'));?>
					<!--i class="icon-caret-down icon-on-right"></i-->
				</div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<?php echo $this->Html->link('Export to Excel',array('controller'=>'reports','action'=>'invoiceExcel',$data_customer_name,$data_status,$data_from_date,$data_to_date),array('class'=>'importbutton btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400 mobile_100','confirm'=>'Click on "Ok" to start the export.'));?>
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
          <div class="row mB20">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive tableexpense">
				<div class="table-header">
					Invoice Detail Report
				</div>
				<?php echo $this->Form->create('invoice_detail_report',array('id'=>'expense','url'=>array('controller'=>'Reports','action'=>'invoiceDetailReport')));?>
				<div class="row margin-twenty-zero expensemargin">
					
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">
							<?php echo $this->Form->input('customer_name',array('label'=>false, 'data-live-search'=>'true', 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Customer Name",'options'=>array(''=>'Customer Name', $organizations),'default'=>$data_customer_name));?>
						 
						</div>
					</div>
					 
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
						<div class="input select choosen_width">
						 <?php echo $this->Form->input('expense_status',array('label'=>false, 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Invoice Status",'options'=>array(''=>'Invoice Status',$invoice_status_list)));?>
						</div>
					</div>
					
                    <div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">						
						<?php echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"id-date-picker-1", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format),'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>					
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">						
						<?php echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"id-date-picker-1", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format),'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
                    
					 
					 
					 
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn mobile_100','url' => array('controller'=>'Reports','action' => 'invoiceDetailReport'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading1')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading1')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'Reports','action'=>'invoiceDetailReport'),array('class'=>'btn btn-sm btn-primary filter-btn mobile_100','update'=>'#pageContent'));?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading1','style'=>'display:none;float: right;margin-right: 10%;'));?>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
                </div>
				
				
				
				
		<?php  foreach($final_invoice as $key1=>$value1):   ?>
		
		<div class="page-header">
	            	<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600"><?php echo $key1;?></div>
	          	</div>
		    	<?php  foreach($value1 as $key=>$value): ?>
				
                
                <div class="row">
	                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
	                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
	                                
	                <table class="table table-striped roles-table parent-table">
	                	<tr>
	                    	<td class="title_role bold rowwidth120px textleft">Invoice #</td>
	                        <td class="title bold rowwidth120px ">Invoice Date</td>
	                        <td class="title bold rowwidth120px ">Invoice Status</td>
	                        <td class="title bold rowwidth200px ">Item Description</td>
	                        <td class="title bold rowwidth120px textright">Tax Code</td>
	                        <td class="title bold rowwidth120px textright">Unit Cost</td>
	                        <td class="title bold rowwidth120px textright">Quantity</td>
	                        <td class="title bold rowwidth120px textright">Amount</td>    
	                    </tr>
	                    
	                    <?php   $loop=0;$total_amount = null;$paid_amount =null;
	                          
	                           foreach($value['invoice_details'] as $k=>$v):$loop++;?>
			                    <tr class="even-strip">
			                    	<?php if($loop ==1){?>
			                    		
				                    	<td class="title_role rowwidth120px "><?php echo $value['invoice_number'];?></td>
				                        <td class="title rowwidth120px "><?php echo date($date_format,strtotime( $value['invoice_date'])); ?></td>
				                        <?php 
				                            if($value['invoice_status'] == 'Draft'){
				                            	 $color = '#000';
				                            }elseif($value['invoice_status']=='Sent'){
				                            	$color = '#F00';
				                            }elseif($value['invoice_status']=='Paid'){
				                            	$color = '#8BA870';
				                            }elseif($value['invoice_status']=='Canceled'){
				                            	$color = '#000';
				                            }else{
				                            	$color = '#000';
				                            }
				                        
				                        ?>
				                         <td class="title rowwidth120px" style="color:<?php echo $color?>";><?php echo $value['invoice_status'];?></td>
				                        <?php }else{?>
				                        <td class="title_role rowwidth120px "></td>
				                        <td class="title rowwidth120px "></td>
				                        <td class="title rowwidth120px "></td>	
			                        	
			                        <?php }?>			
			                    	
			                        <td class="title rowwidth200px "><?php echo $v['item_description'];?></td>
			                        <td class="title rowwidth120px textright"><?php echo $v['tax_code'];?></td>
			                        <td class="title rowwidth120px textright"><?php echo $this->Number->currency($v['unit_cost'],'',$options); ?></td>
			                        <td class="title rowwidth120px textright"><?php echo $this->Number->currency($v['quantity'],'',$options); ?></td>
			                        <td class="title rowwidth120px textright"><?php echo $this->Number->currency($v['amount'],'',$options); ?></td>
			                        <?php $total_amount +=$v['amount'];
			                               $paid_amount = $v['paid_amount'];
			                           
			                        ?>
			                        
			                    </tr>
	                    <?php endforeach;?>
	                    <?php if(empty($paid_amount)){
	                    	$paid_amount = '0.00';
	                    } ?>
	                    
	                </table>                   
	             </div>
	           </div>
             </div>
                 
      <?php if(!empty($value['invoice_details'])):?>  
             <div class="row mB20">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right coloredrow">
                    <div class="initialbalanceamt">
                   
                      <?php echo $value['currency_code'].' '.$this->Number->currency($total_amount,'',$options); /*$this->Number->format($total_amount,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','))*/;?>
                    </div>
                    <div class="initialbalance">
                      Sub Total
                    </div>
					<div class="clearfix"></div>
                     <div class="initialbalanceamt">
                        <?php echo  $value['currency_code'].' '.$this->Number->currency($value['tax_total'],'',$options);/*$this->Number->format($value['tax_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','))*/;?>
                    </div>
                    <div class="initialbalance">
                      Taxes
                    </div>
                    <div class="clearfix"></div>
                     <div class="initialbalanceamt bold">
                       <?php echo $value['currency_code'].' '.$this->Number->currency(($total_amount+$value['tax_total']),'',$options);/*$this->Number->format($total_amount+$value['tax_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','))*/;?>
                    </div>
                    <div class="initialbalance bold">
                      Invoice Total
                    </div>
                    <div class="clearfix"></div>
                     <div class="initialbalanceamt">
                      <?php echo $value['currency_code'].' '.$this->Number->currency($paid_amount,'',$options);/*$this->Number->format($paid_amount,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','))*/;?>
                        
                    </div>
                    <div class="initialbalance">
                      Paid
                    </div>

                    <div class="clearfix"></div>
                     <div class="initialbalanceamt bold">
                       <?php 
                       $balence = $total_amount+$value['tax_total']-$paid_amount;
                       if($balence < '0'){
                       	  $balencee == '0';
                       }else{
                       	 $balencee = $balence;
                       }
                       echo $value['currency_code'].' '.$this->Number->currency($balencee,'',$options);/*$this->Number->format(($total_amount+$value['tax_total'])-$paid_amount,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));*/?>
                    </div>
                    <div class="initialbalance bold">
                      	Balance
                    </div>
                </div>  
                </div>
                </div> 
             <?php endif;?>
             <?php endforeach;?> 
      <?php endforeach;?>          
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
		/*var i = 0;
		$('.even-strip').each(function() {
			if (i % 2 != 0) {
				$(this).addClass("coloredrow");
			}
			i++;
		});*/

		//for alternative row colors

		/*$('.roles-table input[type="checkbox"]').click(function() {
			select_each_row_mobile($(this));
		});*/
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

<script type="text/javascript">
	function arPrint() {
		window.print();
	}
</script>
 
<?php echo $this->Js->writeBuffer();?>