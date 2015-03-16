<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Invoices',array('controller'=>'AcrClientInvoices','action'=>'index'));?>
		</li>
		<li class="active">
			<?php echo __('Export Invoices')?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 class="managecustomer manageinventory"> <?php echo __('Export Invoices');?> </h1>
		<div class="col-lg-6 col-sm-12 col-md-12  col-xs-12 paddingleftrightzero pull-right">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i>Back', array('action' => 'index'), array('class' => 'btn btn-sm btn-success pull-right addbutton', 'escape' => FALSE)); ?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<div class="table-header">
					<?php echo __('Export Invoices');?>
				</div>
				<?php echo $this->Form->create('InvoiceFilter',array('id'=>'InvoiceFilter','url'=>array('controller'=>'Reports','action'=>'export')));?>
				<div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-100-480 mobile_100">						
						<?php echo $this->Form->input('filterAction',array('label'=>false,'class'=>'form-control selectpicker selectitem','data-placeholder'=>'Status','options'=>array(''=>'Filter By','invoice_number'=>'Invoice Number','customer_name'=>'Customer Name','amount'=>'Amount')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero dispalycommon filterenter width-100-480 mobile_100">						
						<?php echo $this->Form->input('filterValue',array('label'=>false, 'placeholder'=>'Enter', 'id'=>"", 'class'=>"form-control")); ?>
					</div>
					<div class="form-group filed-left margin-bottom-zero widthinput150 displayifnumber mobile_100">
						<div class="form-group margin-bottom-zero inpuwidth70 left marginright10">						     
						    <?php echo $this->Form->input('filterValue1',array('label'=>false, 'placeholder'=>'Min', 'id'=>"", 'class'=>"form-control")); ?>
						</div>
						<div class="form-group margin-bottom-zero inpuwidth70 left">						    
						     <?php echo $this->Form->input('filterValue2',array('label'=>false, 'placeholder'=>'Max', 'id'=>"", 'class'=>"form-control"));?>
						</div>     
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-100-480 mobile_100">						
						<?php echo $this->Form->input('isRecurring',array('label'=>false, 'class'=>'form-control selectpicker','data-placeholder'=>'Status','options'=>array('All'=>'All Invoices','Y'=>'Recurring Invoices')));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field width-100-480 mobile_100">												
						<?php echo $this->Form->input('status',array('label'=>false, 'class'=>'form-control selectpicker','data-placeholder'=>'Status','options'=>array(''=>'Status','Draft'=>'Draft','Sent'=>'Sent','Paid'=>'Paid','Marked as paid'=>'Marked as paid','Canceled'=>'Canceled')));?>
					</div>
					<div class="input-group form-group custom-datepicker width-100-480 datewidth">
						<?php echo $this->Form->input('fromDate',array('label'=>false, 'placeholder'=>'From', 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="input-group form-group custom-datepicker width-100-480 datewidth">
						<?php echo $this->Form->input('toDate',array('label'=>false, 'placeholder'=>'To', 'id'=>"", 'class'=>"form-control date-picker", 'data-date-format'=>"dd-mm-yyyy",'readonly'=>'readonly','style'=>'cursor:default')); ?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">						
						<?php echo $this->Js->submit('Export', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','url' => array('controller'=>'Reports','action' => 'export'),'escape'=>false,'update' => '#pageContent'));?>
					</div>
					
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
			
			$(document).ready(function(){
				
				check();				
				$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				if($('.selectpicker').length){
	   		      $('.selectpicker').selectpicker({
			       });
    	         }
			});
				
				
	$(document).ready(function(){
	    var flag=0;
	    var count=0;
	 	$('th .ace').change(function(){
	 		if(count!=0)
	 		   count=0;
	 		if(flag==0){
	 		    $('.magin-delete-all .deleteicon').fadeIn('slow');
	 		    flag=1;
	 		}
	 		else{
	 			 $('.magin-delete-all .deleteicon').fadeOut('slow');
	 			 flag=0;
	 		}
	 	});
	 	$('td .ace').change(function(){
	 		if(flag==0){
	 		  var x=$(this).prop("checked");
	 		  if(x==true){		 		
	 		  	count+=1;
	 		  }
	 		  else{	 		  	
	 		  	count-=1;
	 		  }
	 		  
	 		 
	 		  if(count>0 )
	 		    $('.magin-delete-all .deleteicon').fadeIn('slow');
	 		  else if(count<=0&&flag==0){ 	 		  	
	 			 $('.magin-delete-all .deleteicon').fadeOut('slow');	 			
	 		  }
	 		 }
});	
$('body').on('change','.selectitem',function(){
	var thisvalue = $('.selectitem option:selected').text();
	$('.dispalycommon').find('.input .form-control').val('');
	$('.displayifnumber').find('.input .form-control').val('');
	if (thisvalue=="Amount")
	   {
	   	 $('.dispalycommon').hide();
	   	 $('.displayifnumber').show();
	   }
	   else{
	   	   $('.dispalycommon').show();
	   	   $('.displayifnumber').hide();
	   }
});

});


function check(){
	var thisvalue = $('.selectitem option:selected').text();
	if (thisvalue=="Amount")
	   {  
	   	 $('.dispalycommon').hide();	
	   	 $('.displayifnumber').show();
	   }
	   
}	

</script>