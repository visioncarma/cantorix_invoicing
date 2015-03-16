
<div class="breadcrumbs" id="breadcrumbs"> 
  <script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
  </script>
  <ul class="breadcrumb">
    <li> <i class="icon-home home-icon"></i> <a href="#">Home</a> </li>
    <li><a href="#">Reports</a> </li>
    <li><a href="#">Tax</a> </li>
    <li class="active">Tax Summary</li>
  </ul>
</div>

<div class="page-content">
      <div class="page-header">
       <div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			<?php echo __('Tax Summary');?>
		</div>
		
	    <div class="col-lg-8 col-md-7 col-sm-8 col-xs-8 no-padding-left no-padding-right width-after-600">
	          
			  <div class="widthauto paddingleftrightzero pull-right padding-right-3 padding-right-3-480 width50p clear-420 margin-top-10-420">
					<?php echo $this->Html->link('Export to PDF <i class="icon-caret-down icon-on-right"></i>',array('controller'=>'','action'=>''),array('class'=>'btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400','escape'=>FALSE));?>
			  </div>
			  <?php //if(($showAddButton) && ($permission['_create'] == '1')){?>
			     <div class="widthauto paddingleftrightzero pull-right padding-right-3 width50p margin-top-10-420">
					<?php echo $this->Html->link('Export to Excel<i class="icon-caret-down icon-on-right"></i>',array('controller'=>'','action'=>''),array('class'=>'btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400','escape'=>FALSE));?>
				</div>
			  <?php //} ?>
	       </div>
     </div>
     <div class="row">
         <div class="col-xs-12">
              <div class="table-responsive overflow-visible">
                <div class="table-header">Customer Sales Report</div>
                 <div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-100-480">						
						<?php echo $this->Form->input('groupType',array('label'=>false,'class'=>'form-control selectpicker selectitem','data-placeholder'=>'Group Type','options'=>array(''=>'Group Type','sales'=>'Sales','expenses'=>'Expenses')));?>
					</div>
					<div class="input-group form-group custom-datepicker width-100-480">
						<?php echo $this->Form->input('fromDate',array('div'=>false,'label'=>false, 'placeholder'=>'From', 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="input-group form-group custom-datepicker width-100-480">
						<?php echo $this->Form->input('toDate',array('div'=>false,'label'=>false, 'placeholder'=>'To', 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero">						
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn filter_btn_new','url' => array('controller'=>'Taxes','action' => 'tax_summary'),'escape'=>false,'update' => '#pageContent'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Js->link('Reset',array('controller'=>'Taxes','action'=>'tax_summary'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new','update'=>'#pageContent'));?>
					</div>
				</div>
                <table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
                  <thead>
                    <tr>
                      
                      <th class="width45p">Group Type</th>
                      <th class="width45p hidden-480">Tax Code</th>
                      <th class="width45p hidden-480">Tax Name</th>
                      <th class="width45p hidden-480">Tax Percentage</th>
                      <th class="width45p">Tax Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $i=0; foreach($final as $key=>$value): $i++; debug($final);?>
                  	<tr>
                     
                      <td><span><?php echo $value['SbsSubscriberPaymentTerm']['term']; ?></span>
                      <td class="hidden-480"><span class="right-aligned-amt"><?php echo $value['SbsSubscriberPaymentTerm']['no_of_days']; ?></span></td>    
                       
                       
                    </tr>
                   <?php endforeach;?>   
                   <?php $l=0; foreach($final1 as $key1=>$value1): $l++; debug($final1);?>
                  	<tr>
                     
                      <td><span><?php echo $value['SbsSubscriberPaymentTerm']['term']; ?></span>
                      <td class="hidden-480"><span class="right-aligned-amt"><?php echo $value['SbsSubscriberPaymentTerm']['no_of_days']; ?></span></td>    
                       
                       
                    </tr>
                   <?php endforeach;?>   
                   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <?php echo $this->Form->end();?> 	 
</div>

  

<script type="text/javascript">
	window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>


<script type="text/javascript">
	if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script> 



<?php echo $this->Js->writeBuffer();?>  
