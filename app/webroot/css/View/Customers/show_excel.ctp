<?php echo $this->Session->flash();?>
  <div class="breadcrumbs" id="breadcrumbs">
		<script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>

		<ul class="breadcrumb">
			<li>
				<i class="icon-home home-icon"></i>
				 <?php echo $this->Html->link('Home', array('controller' => 'Users', 'action' => 'dashboard'), array('div' => false,'escape' => false)); ?>
			</li>
            <li>								
				<?php echo $this->Html->link('Customers', array('controller' => 'Customers', 'action' => 'index'), array('div' => false,'escape' => false)); ?>
			</li>
			<li class="active">Import Customers From Excel</li>
		</ul>
	</div>
<?php if($showAddButton){?>
	<div class="page-content">
		<div class="page-header">
			<h1>
				Import Customers From Excel				
			</h1>
            <div class="col-lg-2 paddingleftrightzero">
               <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
            </div>
		</div>
        <!-- page-header -->
 <div class="row">
 <div class="col-xs-12 margin20">
   <div class="showExcel">
			<span><?php echo __('Download Excel format:');?></span>
		
			<span class="downloadlink">
				<?php echo $this->Html->link(__('Excel Format'),array('action'=>'downloadLink'))?>
			</span>
  </div>
 </div>
 </div>       
 <div class="row importrow">
	<div class="col-xs-12">
	<div class="import-wrapper">
	<form id = "fileupload" name = "Import-Form" enctype="multipart/form-data" method="post" type = "file">		
		<div class="row content-row margin-twenty-zero">
			<div class="col-md-12 padding-zero add-detail-wrapper col-xs-12">

				<div class="row content-row">
					<div class="bt-form-field-row">
					    <span class="bt-form-label-wrap show-excel onlyexcel col-xs-12"> <label><?php echo __('Import Excel file');?></label> </span>
						<span class="bt-form-value-wrap excelbrowse col-xs-12">
							<input type="file" name="file" id="file" class="form-control browse-button inputfile">
							<span class="col-xs-12 bt-form-label-wrap show-excel onlyexcel onlyxls"> <label><?php echo __('.xls file only');?></label> </span>
						</span>
						<div class="excelimportbutton col-xs-12">
							<input type="Submit" name="Import" value = "<?php echo __('Import'); ?>" class="btn btn-primary" style="padding-top:2px;padding-bottom:2px;">
						</div>
					    
					</div>
				</div>
			</div>
		</div>
	</form>
	
	<?php if($fileUploadSuccess):?>
         <?php if($clientInformationSuccessCount){?>
	<?php echo '<span class="recordsimported">'.$clientInformationSuccessCount." Records imported from Client Information".'</span>';?>
    <?php }else{
	echo '<span class="recordsimported">'."Zero Records imported from Client Information".'</span>';
}?>

<?php if($errorMessage):?>
		<div class="col-lg-12 importdata">
		    			<button type="button" class="btn btn-primary toggle-btn"><?php echo __('Client Information');?></button>
		        			<div class="school-company-container">
		        				<table class="table table-hover table-condensed manage-company">
						  			<thead>
										<tr>
											<th class="company-name">
												<?php echo __('Client Sl No');?>
											</th>
											<th >
												<?php echo __('Client Name');?>
											</th>
											<th >
												<?php echo __('Organization Name');?>
											</th>
											<th >
												<?php echo __('Error Message');?>
											</th>
										</tr>
						  			</thead>
								<?php foreach($errorMessage as $key=>$val){?>
									<tr>
										<td>	
											<?php echo $val['Client Sl No'];?>
										</td>
										<td>	
											<?php echo $val['Client Name'];?>
										</td>
										<td>	
											<?php echo $val['Organization Name'];?>
										</td>
										<td>	
											<?php echo $val['Error Message'];?>
										</td>
									</tr>	
								<?php	}
								?>
						</table>
		        </div>
		    </div>
	
<?php endif;?>
<?php if($clientContactInformation){?>
	<?php echo '<span class="recordsimported"> '.$clientContactInformation." Client contacts imported".'</span>';?>
<?php }else{
	echo '<span class="recordsimported">'."Zero Client contacts imported".'</span>';
}?>
<?php if($contactError):?>
		<div class="col-lg-12 importdata">
		    			<button type="button" class="btn btn-primary toggle-btn"><?php echo __('Client Contact');?></button>
		        			<div class="school-company-container">
		        				<table class="table table-hover table-condensed manage-company">
						  			<thead>
										<tr>
											<th class="company-name">
												<?php echo __('Client Sl No');?>
											</th>
											<th >
												<?php echo __('Contact Name');?>
											</th>
											<th >
												<?php echo __('Contact Email');?>
											</th>
											<th >
												<?php echo __('Mobile');?>
											</th>
											<th >
												<?php echo __('Error Message');?>
											</th>
										</tr>
						  			</thead>
								<?php foreach($contactError as $key1=>$val1){?>
									<tr>
										<td>	
											<?php echo $val1['Client Sl No'];?>
										</td>
										<td>	
											<?php echo $val1['Contact Name'];?>
										</td>
										<td>	
											<?php echo $val1['Contact Email'];?>
										</td>
										<td>	
											<?php echo $val1['Mobile'];?>
										</td>
										<td>	
											<?php echo $val1['Error Message'];?>
										</td>
									</tr>	
								<?php	}
								?>
						</table>
		        </div>
		    </div>
	
<?php endif;?>
<?php endif ;?>
	
	
	
	
	</div>
</div>
</div>
</div>
<?php }else{ ?>
	<div class="page-content">
		<div class="page-header">
			<h1>
				Import Customers From Excel				
			</h1>
            <div class="col-lg-2 paddingleftrightzero">
               <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
            </div>
		</div>
		<div class="row">
			<?php echo $this->Session->flash();?>
		</div>
	</div>
<?php } ?>

<script type="text/javascript">

  $(document).ready(function(){
  	  
	  $("#fileupload").validate({
		 rules: {           
			"file": {
				required : true
			}
		 },
		 messages:{			 
			 "file":{
				required: "Please select a xls file to upload"
		 	 }
		 }
	 });	
}); 
</script>