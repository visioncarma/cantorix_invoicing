<?php echo $this->Session->flash();?>
<?php /*$showAddButton = 1;*/?>

  <div class="breadcrumbs" id="breadcrumbs">
		<script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>

		<ul class="breadcrumb">
			<li>
				<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
			</li>
            <li>								
				<?php echo $this->Html->link('Expenses',array('action'=>'index'));?>
			</li>
			<li class="active">Import Expenses From Excel</li>
		</ul>
	</div>

	<div class="page-content">
		<div class="page-header">
			<h1>
				Import Expenses From Excel				
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
				<?php echo $this->Html->link(__('Excel Format'),array('action'=>'downloadSampleSheet'))?>
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
         <?php if($invoiceImportCount){?>
	<?php echo '<span class="recordsimported">'.$invoiceImportCount." Expenses imported".'</span>';?>
    <?php }else{
	echo '<span class="recordsimported" style="color:red;">'."Zero Records imported from Expense Information".'</span>';
}?>
<?php endif ;?>
<?php if($errorMessage):?>
		<div class="page-header">
								<h1 class="bold">
									<?php echo __('Expense Information :');?>
								</h1>
					           
							</div>
		<div class="col-lg-12 importdata">
		    			<!--<button type="button" class="btn btn-primary toggle-btn" disabled><?php echo __('Expense Information');?></button>-->
		        			
		        			
		        			
		        			<div class="school-company-container">
		        				<table class="table table-hover table-condensed manage-company">
						  			<thead>
										<tr>
											<th class="company-name">
												<?php echo __('Reference Number');?>
											</th>
											<th >
												<?php echo __('Expense Date');?>
											</th>
											<th >
												<?php echo __('Error Message');?>
											</th>
											
										</tr>
						  			</thead>
								<?php foreach($errorMessage as $key=>$val){?>
									<tr>
										<td>	
											<?php echo $val['Reference Number'];?>
										</td>
										<td>	
											<?php echo date($dateFormat,strtotime($val['Expense Date']));?>
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
</div>
</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#fileupload").validate({ rules: { file: { required:true } }, messages: { file: { required:'Select a file to import.'} } });
	});
</script>