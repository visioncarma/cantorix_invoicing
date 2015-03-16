<?php echo $this->Html->css(array('print.css'), 'stylesheet', array('media' => 'print')); ?>
  <?php $this->CurrencySymbol->getAllCurrencies();?>
  <?php 
	$dbFormat = array("d", "M", "Y");
	$scriptFormat   = array("dd", "mm", "yyyy");
?>
    <?php echo $this->Session->flash();?>
   <script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
   </script>
     
       
 
   <div class="breadcrumbs" id="breadcrumbs"> 
        <script type="text/javascript">
		        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
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
			Profit and Loss Report
		</li>
	</ul>
   </div>
        <div class="page-content idr">
          
          <div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Profit and Loss Report
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600">
			<div class=" widthauto paddingleftrightzero pull-right padding-right-3 padding-right-3-480 width50p margin-top-10-420 buttonrightwidth  mobile_100">
				<div class="btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100">
					<?php 
					if(empty($revenueType)) $revenueType ='null';
				    if(empty($expenseTax)) $expenseTax ='null';
					echo $this->Html->link('Export to PDF',array('controller'=>'reports','action'=>'profitlossExcel','1',$periodType,$revenueType,$expenseTaxReturn,$financialYear),array('class'=>'report-button ','confirm'=>'Click on "Ok" to start the export.'));?>
				</div>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				
				<?php   
				if(empty($revenueType)) $revenueType ='null';
				if(empty($expenseTax)) $expenseTax ='null';
				 
				echo $this->Html->link('Export to Excel',array('controller'=>'reports','action'=>'profitlossExcel','0',$periodType,$revenueType,$expenseTaxReturn,$financialYear),array('class'=>' importbutton btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400 mobile_100','confirm'=>'Click on "Ok" to start the export.'));?>
			    
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<div class="btn btn-sm pull-right printbutton col-xs-12">
					<a href="javascript:void()" onclick="arPrint()">Print <i class="icon-print icon-on-right"></i></a>
				</div>
			</div>
		</div>
	</div> 
          
           
          
           
          
      <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <div class="table-responsive tableexpense">
                <div class="table-header">Profit and Loss</div>
                
                <?php echo $this->Form->create('profit_loss_report',array('id'=>'profit_loss','url'=>array('controller'=>'Reports','action'=>'profitLossReport')));?>
				
                <div class="row margin-twenty-zero expensemargin">
                          <div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
								<div class="input select choosen_width">
									<?php echo $this->Form->input('period',array('label'=>false, 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Select Period",'options'=>array($periodDropdown),'default'=>'Monthly'));?>
								</div>
						  </div>
							
					     
					     <div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
								<div class="input select choosen_width">
									<?php echo $this->Form->input('revenueType',array('label'=>false, 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Revenue Type",'options'=>array(''=>'Revenue Type',$revenueTypes)));?>
								</div>
						  </div>		
							
						  <div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-full-480 mobile_100">
								<div class="input select choosen_width">
									<?php echo $this->Form->input('expenseTax',array('label'=>false, 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Expense Tax",'options'=>array(''=>'Expense Tax',$expenseTax)));?>
								</div>
						  </div>	
		                   				
							<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right width-full-480 datewidth">						
								<?php if($LastDateofMonth){$toDateVal = date($date_format,strtotime($LastDateofMonth));}  echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"id-date-picker-1", 'class'=>"form-control date-picker",'data-date-format'=>str_ireplace($dbFormat, $scriptFormat, $date_format),'default'=>$toDateVal,'readonly'=>'readonly','style'=>'cursor:default')); ?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div>
		                    
		                   <div class="form-group filed-left margin-bottom-zero mobile_100">
								<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn mobile_100','url' => array('controller'=>'Reports','action' => 'profitLossReport'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading1')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading1')->effect('fadeOut', array('buffer' => false))));?>
							</div>
							<div class="form-group filed-left margin-bottom-zero mobile_100">
								<?php echo $this->Js->link('Reset',array('controller'=>'Reports','action'=>'profitLossReport'),array('class'=>'btn btn-sm btn-primary filter-btn mobile_100','update'=>'#pageContent'));?>
							</div>
							<?php echo $this->Html->image('loding.gif', array('id'=>'loading1','style'=>'display:none;float: right;margin-right: 10%;'));?>
                   </div>
                 <?php echo $this->Form->end();?>
                

                </div>
                </div>
                </div>
				
				        
                <!-- Profit and Loss Report Income-->
                <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                
               
                
                
		                <table class="table table-striped roles-table parent-table">
		                       <tr> 
		                       	 
					                        <td class="title bold textright bluetext mobilehide"><span class="hidethisitem">Income</span></td>
					                    	<td class="title bold textright mobilehide hidethisitem"></td>
					              <?php foreach($finalArray['Sales'] as $key=>$value):?>
					                        <td class="title bold textright"><?php echo $key;?></td>  
					              <?php endforeach;?>
					          </tr>
		              
                
		                    <tr class="mobilehide">
		                        <td class="title bold bluetext" colspan="14">Income</td>
		                    </tr>
		                    
		                    <tr>
		                          <td class="title textright hidethisitem mobilehide"></td>
		                    	  <td class="title rowwidth160px">Sales</td>
		 						 <?php foreach($finalArray['Sales'] as $key=>$value):?>  
		 						  	<td class="title textright rowwidth70px wordwrap">
		 						  		<?php echo $this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?>
		 						    </td>
			                      <?php endforeach;?>     
		                    </tr>
		                </table>
                
                       <table class="table table-striped roles-table parent-table">
                  <tr>
                      <td class="title bold textright mobilehide"></td>
                         <?php foreach($finalArray['Sales'] as $key=>$value):?>
					                        <td class="title bold textright"><?php echo $key;?></td>  
					     <?php endforeach;?>
                    </tr>
                    <tr>
                      <td class="title rowwidth160px">Cost of Goods Sold</td>
                          <?php foreach($finalArray['GoodsSold'] as $key1=>$value1):?>
                        		<td class="title textright rowwidth70px wordwrap">
                        			<?php echo $this->Number->format($value1,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?>
                        		</td>
                          <?php endforeach;?> 
                    </tr>
                </table>
                
                
                
                <table class="table table-striped roles-table parent-table">
                  <tr>
                      <td class="title bold textright mobilehide"></td>
                        <?php foreach($finalArray['Sales'] as $key=>$value):?>
                              <td class="title bold textright"><?php echo $key;?></td>
                        <?php endforeach;?> 
                  </tr>
                  <tr>
                      <td class="title bold rowwidth160px">Gross Profit</td>
                        <?php foreach($finalArray['Total'] as $key=>$value):?>
                        	 <td class="title bold textright rowwidth70px wordwrap">
                        	 	<?php echo $this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?>
                             </td>
                        <?php endforeach;?>
                     </tr>
                </table>

                
                
               

                


                
                 
                </div>
                  </div>
                 </div>
                <!-- /Profit and Loss Report Income-->



                <!-- Profit and Loss Report Income-->
                <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
                                
                <table class="table table-striped roles-table parent-table">
                
                  <tr>
                   <td class="title bold textright bluetext mobilehide"><span class="hidethisitem">Less Expenses</span></td>
                        <td class="title bold textright mobilehide"></td>
                       <?php foreach($finalArray['TotalExpenses'] as $key=>$value):?>
					                        <td class="title bold textright"><?php echo $key;?></td>  
					     <?php endforeach;?>
                    </tr>

                    <tr class="mobilehide">
                      <td class="title bold bluetext" colspan="14">Less Expenses</td>
                    </tr>
 					<?php foreach($expenseCategory as $exp1=>$exp2){ ?>
                    <tr>
                    <td class="title textright hidethisitem mobilehide"></td>
                            
                            <td class="title rowwidth160px"><?php echo $exp2; ?></td>
						
							<?php foreach($lessexp[$exp1] as $lexp1=>$lexp2 ){?>
                         		<td class="title textright rowwidth70px wordwrap">
                         	    <?php 
                         			 if($lexp2 =='-'){
                         			    echo $lexp2;
                         			 }else{
                         			 	echo $this->Number->format($lexp2,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));
                         			 }
                         		?>
                         			 </td>
                         	<?php } ?>
                         	
                    </tr> 
                    <?php } ?> 
                </table>

                 


                <table class="table table-striped roles-table parent-table">
                  <tr>
                         <td class="title bold textright mobilehide"></td>
                        <?php foreach($finalArray['TotalExpenses'] as $key=>$value):?>
					                        <td class="title bold textright"><?php echo $key;?></td>  
					     <?php endforeach;?>
                    </tr>
                    <tr>
                      <td class="title bold rowwidth160px">Total Expenses</td>
                             <?php foreach($finalArray['TotalExpenses'] as $key=>$value){?>
                                    <td class="title bold textright rowwidth70px wordwrap">
                                         <?php echo $this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?>
                                    </td>
                             <?php } ?>
                         	
                    </tr>
                </table>


                <table class="table table-striped roles-table parent-table">
                  <tr>
                      <td class="title bold textright mobilehide"></td>
                        <?php foreach($finalArray['TotalExpenses'] as $key=>$value):?>
					                        <td class="title bold textright"><?php echo $key;?></td>  
					     <?php endforeach;?>
                  </tr>
                    <tr>
                      <td class="title bold rowwidth160px">Net Profit</td>
                        
                         <?php foreach($finalArray['NetProfit'] as $key=>$value){?>
                        		<td class="title bold textright rowwidth70px wordwrap">
                        			 <?php echo $this->Number->format($value,array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?>
                                </td>
                         <?php } ?>
                        
                    </tr>
                </table>

                </div>
                  </div>
                 </div>
                <!-- /Profit and Loss Report Income-->


               

                <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 allamount">
                    All Amounts Displayed in <span class="bold" style="color:red;"><?php echo $subscriberCurrencyCode;?></span>
                </div>
                </div>
          </div>
        <!-- /.page-content --> 
     
    
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> 


 

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

			$('.role-table-c2').find('tr:first').removeClass("hidden-row");

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



		var i=0;
		$('.even-strip').each(function(){
		if(i%2!=0) 
		{
		$(this).addClass("coloredrow");
		}
		i++;
		});

 

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
 