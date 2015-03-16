<?php echo $this -> Html -> css(array('print.css'), 'stylesheet', array('media' => 'print')); ?>
<?php if(!$groupType) $groupType=0;
      if(!$fromDate) $fromDate=date('Y').'-01-01';
	  if(!$toDate) $toDate=date('Y-m-d');

?>	
<?php 
	$dbFormat = array("d", "M", "Y");
	$scriptFormat   = array("dd", "mm", "yyyy");
?>
	 
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript" src="">
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
			<?php echo __('Tax Summary');?>
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
      <div class="page-header">
       <div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			<?php echo __('Tax Summary');?>
		</div>
		
	   <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600">		
			
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 padding-right-3-480 width50p margin-top-10-420 buttonrightwidth ">
				<div class="btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100">
					<?php echo $this->Html->link('Export to PDF',array('controller'=>'reports','action'=>'tax_summary_pdf',$groupType,$fromDate,$toDate,'pdf'),array('class'=>'report-button'));?>
					<i class="icon-caret-down icon-on-right"></i>
				</div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<div class="btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400">
					<?php echo $this->Html->link('Export to Excel',array('controller'=>'reports','action'=>'tax_summary_excel',$groupType,$fromDate,$toDate,'excel'),array('class'=>'report-button'));?>
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
     <div class="row">
         <div class="col-xs-12">
              <div class="table-responsive overflow-visible">
                <div class="table-header">Customer Sales Report</div>
                
                <?php echo $this->Form->create('TaxReport',array('url' =>'/reports/tax_summary'));?>    
                 <div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-100-480 mobile_100 choosen_width">						
						<?php echo $this->Form->input('groupType',array('label'=>false,'class'=>'form-control invdrop selectitem','data-placeholder'=>'Group Type','data-placeholder'=>"Group Type",'options'=>array(''=>'Group Type','Sales'=>'Sales','Expenses'=>'Expenses')));?>
					</div>
					<div class="input-group form-group custom-datepicker width-100-480 datewidth">
						<?php $default_from= date('Y');
						      $from=$default_from.'-01-01';
							  echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format),'readonly'=>'readonly','style'=>'cursor:default','default'=>date($date_format, strtotime($from)))); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="input-group form-group custom-datepicker width-100-480 datewidth">
						<?php $default_to =date('Y-m-d'); 
						     echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format),'readonly'=>'readonly','style'=>'cursor:default','default'=>date($date_format, strtotime($default_to)))); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">						
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','url' => array('controller'=>'reports','action' => 'tax_summary'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'reports','action'=>'tax_summary'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','update'=>'#pageContent','before' => $this->Js->get('#loading2')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading2')->effect('fadeOut', array('buffer' => false))));?>
					</div>
					<?php echo $this->Html->image('loding.gif', array('id'=>'loading2','style'=>'display:none;float: right;margin-right: 50%;'));?>
				</div>
				<?php echo $this->Form->end();?> 	 
                <table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table new_table_responsive">
                  <thead>
                    <tr>
                      
                      <th class="width45p">Group Type</th>
                      <th class="width45p">Tax Code</th>
                      <th class="width45p">Tax Name</th>
                      <th class="width45p text-right">Tax Percentage</th>
                      <th class="width45p text-right">Tax Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if($final){ ?> 	
                  <?php $i=0; foreach($final as $key=>$value): $i++;?>
                  	   <?php $l=0; foreach($value as $key1=>$value1): $l++;?>
                  	   	   
                  	   	   <?php if($value1){ ?>
                  	   	   	
                  	   	  
		                  	<tr>
		                  	  <?php if($l=='1'){ ?>
		                  	  	  <td><span class="right-aligned-amt"><?php echo $key; ?></span></td>    
		                  	  <?php }else{ ?>
		                  	  	   <td><span class="right-aligned-amt"><?php echo str_repeat('&nbsp;', 5); ?></span></td>    
		                  	  <?php } ?>	
		                      <td><span class="right-aligned-amt"><?php echo $value1['code']; ?></span></td>    
		                      <td><span class="right-aligned-amt"><?php echo $value1['name']; ?></span></td>    
		                      <td class="text-right"><span class="right-aligned-amt"><?php echo $value1['percent'].'%'; ?></span></td>    
		                      <td class="text-right"><span class="title width-120-new textright padding-right-25"><?php echo round($value1['amount'],2); ?></span></td>    
		                    </tr>
		                    
                              <?php $total =$value1['amount'];
                                    $total_amount = $total + $total_amount; ?>
                            <?php } ?>        
                         <?php endforeach;?>      
                   
                   <tr>
                  	 <td><span class="right-aligned-amt"><?php echo str_repeat('&nbsp;', 5); ?></span></td>       
                      <td><span class="right-aligned-amt"><?php echo str_repeat('&nbsp;', 5); ?></span></td>      
                      <td><span class="right-aligned-amt"><?php echo str_repeat('&nbsp;', 5); ?></span></td>      
                      <td class="text-right"><span class="right-aligned-amt bold"><?php echo"Total"; ?></span></td>  
                      <td class="text-right"><span class="right-aligned-amt bold"><?php echo round($total_amount,2); ?></span></td>  
                   </tr>
                   <tr>
                   	 <td><span class="right-aligned-amt"><?php echo str_repeat('&nbsp;', 5); ?></span></td> 
                   	 <td><span class="right-aligned-amt"><?php echo str_repeat('&nbsp;', 5); ?></span></td> 
                   	 <td><span class="right-aligned-amt"><?php echo str_repeat('&nbsp;', 5); ?></span></td> 
                   	 <td><span class="right-aligned-amt"><?php echo str_repeat('&nbsp;', 5); ?></span></td> 
                   	 <td><span class="right-aligned-amt"><?php echo str_repeat('&nbsp;', 5); ?></span></td> 
                   </tr>
                   <?php $total=$total_amount=null ; ?>
                   <?php endforeach;?>   
                  <?php } ?> 
                 
                  </tbody>
                </table>
                
                
           <!-- only for mobile -->
	 <?php if($final){ ?> 	
	 	
	 	 <?php $i=0; foreach($final as $key=>$value): $i++;?>
                  	   <?php $l=0; foreach($value as $key1=>$value1): $l++;?>
                  <?php if($value1){ ?>
			<div class="table-small-view new_table_small_view new_table_small_view_new view_responsive margintop15">
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> Group Type </div>
					<div class="col-xs-7 font13  mobileClientName"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
							<?php echo $key; ?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> Tax Code </div>
					<div class="col-xs-7 font13  mobileClientName"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
							<?php echo $value1['code']; ?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13">Tax Name</div>
					<div class="col-xs-7 font13  mobileClientName"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
							<?php echo $value1['name']; ?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> Tax Percentage </div>
					<div class="col-xs-7 font13  mobileClientName"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
								<?php echo $value1['percent'].'%'; ?>
							</div>
						</div>
					</div>
				</div>
				
			   	<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> Tax Amount </div>
					<div class="col-xs-7 font13  mobileClientName"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
								<?php echo round($value1['amount'],2); ?>
							</div>
						</div>
					</div>
				</div>
			</div>	
			
			
			
				 <?php $total =$value1['amount'];
                                    $total_amount = $total + $total_amount; ?>
				 <?php }?> 
	 <?php endforeach;?>  
			
			<!--total view -->
			<div class="table-small-view new_table_small_view new_table_small_view_new view_responsive margintop15">
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> Total </div>
					<div class="col-xs-7 font13  mobileClientName"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
								<?php echo round($total_amount,2); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			 <?php $total=$total_amount=null ; ?>	
			 <?php endforeach;?>      
		 <?php } ?> 	
		  <!-- end only for mobile -->
                
                
              </div>
            </div>
          </div>
          
          
        <?php echo $this->Form->end();?> 	 
        <div class="right">
        	All amounts displayed in <span class="bold" style="color:red;"><?php echo $subscriberCurrencyCode['CpnCurrency']['code']; ?></span>.
        </div>
</div>

<style>
	.bold{
		font-weight:bold;
	}
	.right{
		float:right;
	}
	.red{
		color:red;
	}
</style>  

 

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
	
	            $('.sendnow').click(function(){
					$('.previewpopup').trigger('click')
				});
							
				$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				if($('.selectpicker').length){
	   		      $('.selectpicker').selectpicker({
			       });
    	         }
    	         $('.popup-cancel').click(function(){
    	         	$('.close').trigger('click');
    	         });	
    	         
    	         $('.mail-popup').click(function(){
						var thisid=$(this).attr('data-target');
	 					var thislength=thisid.length;
	 					thisid=thisid.slice(2,thislength);
	 					$('.modal.fade.mail').attr('id','M'+thisid);
	 					$('#mail-field').append("<input name='data[MailTemplate][invoiceId]' type='hidden' value='"+thisid+"'/>");
	 			});
	 			$('.previewbtn').click(function(){
					$('.previewpopup').trigger('click');
				});			
			});
	
</script>
<script>
	function arPrint() {
		window.print();
	}
</script>
<?php echo $this->Js->writeBuffer();?>  
