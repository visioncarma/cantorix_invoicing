<?php echo $this->Html->script('jquery.autosize.input.min.js'); ?>
<?php echo $this->Html->script('jquery.removableFileUpload.js'); ?>
<?php echo $this->Html->script('ace.min.js'); ?>

<?php
	if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
	  $protocol_final = 'https';
	}else{
	  $protocol_final = 'http';
	}
	$http_hostname = $_SERVER['SERVER_NAME'];
	$webroot_name = $this->webroot;
	$imgLink = "$protocol_final".'://'."$http_hostname/";
?>

<?php echo $this->Session->flash();?>	

<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript" src="">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
    <?php $homeLink = $this->Breadcrumb->getLink('Home');
	      $settings = $this->Breadcrumb->getLink('Settings'); ?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		
		<li class="active">
			<?php echo __('General Settings');?>
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
      <?php echo $this->Form->create('SbsSubscriberSetting',array('class'=>'form-horizontal formdetails','role'=>'form','type'=>'file')); ?>
		   
		    <div class="form-group filed-left marginleftrightzero drop-down form-dropdown clearfix">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Date Format</label>
					<div class="col-lg-3 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						<div class="select-dropdown noleft positionRelativeselect countrybilling max-height max-width choosen_width">
						  <?php $date_formats=array('Y-m-d'=>'YYYY-MM-DD','Y/m/d'=>'YYYY/MM/DD','d-m-Y'=>'DD-MM-YYYY','d/m/Y'=>'DD/MM/YYYY',/*'d M Y'=>'DD M YYYY',*/'m/d/Y'=>'MM/DD/YYYY'/*,'M d Y'=>'M DD YYYY'*/,'Ymd'=>'YYYYMMDD');
						        echo $this->Form->input('date_format',array('div'=>false,'label'=>false,'class'=>'invdrop','data-placeholder'=>"Date Format"
						        , 'options'=>array(''=>'',$date_formats),'value'=>$get_subscriber_settings['SbsSubscriberSetting']['date_format']));?>
						</div>
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Select date format to be followed for entire subscriber modules." class="help-button blue_back">?</span>
					</div>
				</div>
               
               <div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Logo Upload</label>
					<div class="col-lg-9 col-md-3 col-sm-7 col-xs-12">
					<label class="custLabel">
						<input type="file" name="file" id="exampleInputFile"/>
						Browse
					</label>
					<p class="help-block">Dimension: 100px x 45px Maximum file size:100MB Type of file: jpeg</p>
					<div class="display-thumbnail">
						<img id="img_prev" src="" alt="" width="112" />
						<a class="close-it"></a>
						<span class="file-size"><strong></strong></span>
						<a class="btn btn-rmv">Remove file</a>
						<span class="current_file_size"> Bytes</span>
					</div>
					
					<?php if($get_subscriber_settings['SbsSubscriberSetting']['invoice_logo']){ ?>
						<div class="display-thumbnail old" style="display:block;">
						  <img src="<?php echo $imgLink.$get_subscriber_settings['SbsSubscriberSetting']['invoice_logo'];?>" alt="Logo"/>
					   </div>
					   <?php echo $this->Html->link($this->Html->image('delete_selected.png',array('class' => 'deleteicon delete','title'=>'Delete Logo')),'/subscription_plans/delete_logo/'.$get_subscriber_settings['SbsSubscriberSetting']['id'] ,array('escape' => false,'confirm' => 'Are you sure you want to delete the logo ?'));?>
					
					<?php } ?>
					</div>
				</div>
				 
				<div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Lines per Page</label>
					<div class="col-lg-1 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						
						<?php echo $this->Form->input('lines_per_page',array('id'=>'pageId','type'=>'text','label'=>false,'div'=>false,'class'=>'resizeit form-control','onkeyup'=>'this.value = minmax(this.value, 0, 50)','value'=>$get_subscriber_settings['SbsSubscriberSetting']['lines_per_page']));?>
						<span class="maxminerror"></span>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter page number to be used for displaying the records per page for entire subscriber module(min 1 and max 50)" class="help-button blue_back">?</span>
					</div>
				</div>
		   
				<div class="form-group filed-left marginleftrightzero drop-down form-dropdown clearfix">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Time Zone</label>
					<div class="col-lg-3 col-md-3 col-sm-7 col-xs-12 countrybilling max-height max-width no-padding-right choosen_width">
							<?php echo $this->Form->input('time_zone',array('label'=>false,'data-live-search'=>'true', 'div'=>false,'class'=>'invdrop','data-placeholder'=>"Select Time"
							, 'options'=>array(''=>'',$time_zones),'value'=>$get_org_detail['SbsSubscriberOrganizationDetail']['time_zone']));?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Select timezone." class="help-button blue_back">?</span>
					</div>
				</div>
				
				<div class="form-group filed-left marginleftrightzero drop-down form-dropdown clearfix relative">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Send Recurring Invoice automatically</label>
					<div class="col-lg-2 col-md-3 col-sm-7 col-xs-12 no-padding-right labelerror choosen_width">
							
							<?php echo $this->Form->input('recurring_status',array('label'=>false,'div'=>false,'class'=>'invdrop','data-placeholder'=>"Select"
							, 'options'=>array('Sent'=>'Yes','Draft'=>'No'),'value'=>$get_subscriber_settings['SbsSubscriberSetting']['recurring_status']));?>
					</div>
					
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Select recurring invoice." class="help-button blue_back">?</span>
					</div>
                </div>
		   
				<div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Invoice Number Prefix</label>
					<div class="col-lg-2 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						
						<?php echo $this->Form->input('invoice_number_prefix',array('label'=>false,'div'=>false,'class'=>'form-control','value'=>$get_subscriber_settings['SbsSubscriberSetting']['invoice_number_prefix']));?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter invoice number prefix like INV-." class="help-button blue_back">?</span>
					</div>
				</div>
				
				
				<div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Invoice Starting Sequence Number</label>
					<div class="col-lg-2 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						<?php if(is_numeric($get_subscriber_settings['SbsSubscriberSetting']['invoice_sequence_number'])){
							 echo $this->Form->input('invoice_sequence_number',array('label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$get_subscriber_settings['SbsSubscriberSetting']['invoice_sequence_number']));
						}else{
							echo $this->Form->input('invoice_sequence_number',array('label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)"));
						}
						?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter invoice starting sequence number like 001 which will be combined with prefix to get invoice no. to be started with 'INV-001..'." class="help-button blue_back">?</span>
					</div>
				</div>
				
				
				<div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Recurring Invoice Number Prefix</label>
					<div class="col-lg-2 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						<!--<input class="form-control" type="text">-->
						<?php echo $this->Form->input('recurring_invoice_format',array('label'=>false,'div'=>false,'class'=>'form-control','value'=>$get_subscriber_settings['SbsSubscriberSetting']['recurring_invoice_format']));?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter recurring invoice number prefix like R-INV-" class="help-button blue_back">?</span>
					</div>
				</div>
				
				<div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Quote Number Prefix</label>
					<div class="col-lg-2 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						<!--<input class="form-control" type="text">-->
						<?php echo $this->Form->input('quote_number_prefix',array('label'=>false,'div'=>false,'class'=>'form-control','value'=>$get_subscriber_settings['SbsSubscriberSetting']['quote_number_prefix']));?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter quote number prefix like QTE-." class="help-button blue_back">?</span>
					</div>
				</div>
				
				<div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Quote Starting Sequence Number</label>
					<div class="col-lg-2 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						<?php if(is_numeric($get_subscriber_settings['SbsSubscriberSetting']['invoice_sequence_number'])){
							 echo $this->Form->input('quote_sequence_number',array('label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$get_subscriber_settings['SbsSubscriberSetting']['quote_sequence_number']));
						}else{
							echo $this->Form->input('quote_sequence_number',array('label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)"));
						} ?>
						<?php //echo $this->Form->input('quote_sequence_number',array('label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$get_subscriber_settings['SbsSubscriberSetting']['quote_sequence_number']));?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter quote starting sequence number like 001 which will be combined with prefix to get quote no. to be started with 'QTE-001..'." class="help-button blue_back">?</span>
					</div>
				</div>
				
				<div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Credit Note Prefix</label>
					<div class="col-lg-2 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						<?php echo $this->Form->input('credit_note_prefix',array('label'=>false,'div'=>false,'class'=>'form-control','value'=>$get_subscriber_settings['SbsSubscriberSetting']['credit_note_prefix']));?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter credit note number prefix like CTE-." class="help-button blue_back">?</span>
					</div>
				</div>
				
				<div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Credit Note Starting Sequence Number</label>
					<div class="col-lg-2 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						<?php echo $this->Form->input('credit_note_sequence_number',array('label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$get_subscriber_settings['SbsSubscriberSetting']['credit_note_sequence_number']));?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter credit note starting sequence number like 001 which will be combined with prefix to get quote no. to be started with 'CTE-001..'." class="help-button blue_back">?</span>
					</div>
				</div>
				
				<div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Late Payment Reminder Days</label>
					<div class="col-lg-1 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						<?php echo $this->Form->input('late_payment_reminder_days',array('type'=>'text','label'=>false,'div'=>false,'class'=>'resizeit form-control','onkeypress' => "return isNumberKey(event)",'value'=>$get_subscriber_settings['SbsSubscriberSetting']['late_payment_reminder_days']));?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter no. of days after due date when late payment reminder has to be sent ." class="help-button blue_back">?</span>
					</div>
				</div>
				<div class="form-group marginleftrightzero">
                    <label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right  ">Customer Notes</label>

                    <div class="col-sm-5 col-xs-12 col-lg-4 no-padding-right">
                        <?php echo $this->Form->input('notes',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billadd1 form-control blacktext','value'=>$get_subscriber_settings['SbsSubscriberSetting']['notes']));?>  
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter customer notes." class="help-button blue_back">?</span>
					</div>
                </div>
                
                <div class="form-group marginleftrightzero">
                    <label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right  ">Terms and Conditions</label>

                    <div class="col-sm-5 col-xs-12 col-lg-4 no-padding-right">
                        <?php echo $this->Form->input('terms_conditions',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 blacktext billadd1 form-control','value'=>$get_subscriber_settings['SbsSubscriberSetting']['terms_conditions']));?>  
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter terms and conditions." class="help-button blue_back">?</span>
					</div>
                </div>
				
				<div class="form-group marginleftrightzero">
                    <label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right  ">Email Signature</label>

                    <div class="col-sm-5 col-xs-12 col-lg-4 no-padding-right">
                        <?php $str = $get_subscriber_settings['SbsSubscriberSetting']['email_signature'];
									
                           echo $this->Form->input('email_signature',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billadd1 blacktext form-control','value'=>$get_subscriber_settings['SbsSubscriberSetting']['email_signature']));?>  
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter email signature." class="help-button blue_back">?</span>
					</div>
                </div>
				
				
				<div class="form-group marginleftrightzero">
					<label class="col-lg-3 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right">Define Aging Buckets</label>
					<div class="col-lg-1 col-md-3 col-sm-7 col-xs-12 no-padding-right">
						<!--<input class="form-control aging_buckets" type="text" name="aging_buckets"  id="aging_buckets" value="4">-->
						<?php echo $this->Form->input('aging_bucket',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control aging_buckets','id'=>"aging_buckets",'default'=>'4','readonly'=>'readonly','disabled'=>'disabled'));?>
					</div>
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
					<span title="" data-original-title="" data-rel="popover" data-trigger="hover" data-placement="right" data-content="Enter 4 aging buckets." class="help-button blue_back">?</span>
					</div>
				</div>
			
				<div class="form-group marginleftrightzero">
					<div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
						<table class="table">
						  <thead>
							<tr>
							  <th>Bucket</th>
							  <th>Name</th>
							  <th>Start</th>
							  <th>End</th>
							</tr>
						  </thead>
						  <tbody>
						 <?php if($aging_bucket_details){ ?>
						 	
						 	  <tr>
							  <td>
							   1
							  </td>
							  <td>
							  	<?php echo $this->Form->hidden('edit_id.'.'1',array('value'=>$aging_bucket_details[0]['SbsAgingBucket']['id']));?>
							  	<?php echo $this->Form->input('edit_name.'.'1',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','value'=>$aging_bucket_details[0]['SbsAgingBucket']['bucket']));?>
							  </td>
							  <td>
							  	  <?php echo $this->Form->input('edit_from_day.'.'1',array('id'=>'start1','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$aging_bucket_details[0]['SbsAgingBucket']['from_day'],'readonly'=>'readonly'));?>
							  </td>
							  <td>
							  	 <?php echo $this->Form->input('edit_to_day.'.'1',array('id'=>'end1','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$aging_bucket_details[0]['SbsAgingBucket']['to_day']));?>
							  </td>
						   </tr>
						   
						   <tr>
							  <td>
							   2
							  </td>
							  <td>
							  	<?php echo $this->Form->hidden('edit_id.'.'2',array('value'=>$aging_bucket_details[1]['SbsAgingBucket']['id']));?>
							  	<?php echo $this->Form->input('edit_name.'.'2',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','value'=>$aging_bucket_details[1]['SbsAgingBucket']['bucket']));?>
							  </td>
							  <td>
							  	  <?php echo $this->Form->input('edit_from_day.'.'2',array('id'=>'start2','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$aging_bucket_details[1]['SbsAgingBucket']['from_day'],'readonly'=>'readonly'));?>
							  </td>
							  <td>
							  	 <?php echo $this->Form->input('edit_to_day.'.'2',array('id'=>'end2','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$aging_bucket_details[1]['SbsAgingBucket']['to_day']));?>
							  </td>
						   </tr>
						   
						   <tr>
							  <td>
							   3
							  </td>
							  <td>
							  	<?php echo $this->Form->hidden('edit_id.'.'3',array('value'=>$aging_bucket_details[2]['SbsAgingBucket']['id']));?>
							  	<?php echo $this->Form->input('edit_name.'.'3',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','value'=>$aging_bucket_details[2]['SbsAgingBucket']['bucket']));?>
							  </td>
							  <td>
							  	  <?php echo $this->Form->input('edit_from_day.'.'3',array('id'=>'start3','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$aging_bucket_details[2]['SbsAgingBucket']['from_day'],'readonly'=>'readonly'));?>
							  </td>
							  <td>
							  	 <?php echo $this->Form->input('edit_to_day.'.'3',array('id'=>'end3','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$aging_bucket_details[2]['SbsAgingBucket']['to_day']));?>
							  </td>
						   </tr>
						   
						   <tr>
							  <td>
							   4
							  </td>
							  <td>
							  	<?php echo $this->Form->hidden('edit_id.'.'4',array('value'=>$aging_bucket_details[3]['SbsAgingBucket']['id']));?>
							  	<?php echo $this->Form->input('edit_name.'.'4',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','value'=>$aging_bucket_details[3]['SbsAgingBucket']['bucket']));?>
							  </td>
							  <td>
							  	  <?php echo $this->Form->input('edit_from_day.'.'4',array('id'=>'start4','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$aging_bucket_details[3]['SbsAgingBucket']['from_day'],'readonly'=>'readonly'));?>
							  </td>
							  <td>
							  	 <?php echo $this->Form->input('edit_to_day.'.'4',array('id'=>'end4','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'value'=>$aging_bucket_details[3]['SbsAgingBucket']['to_day']));?>
							   </td>
						   </tr>
						 	
						 <?php } else{ ?>
						 	
						 	<tr>
							  <td>
							   1
							  </td>
							  <td>
							  	<?php echo $this->Form->input('name.'.'1',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','default'=>'0-30 days'));?>
							  </td>
							  <td>
							  	  <?php echo $this->Form->input('from_day.'.'1',array('id'=>'start1','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'default'=>'0','readonly'=>'readonly'));?>
							  </td>
							  <td>
							  	 <?php echo $this->Form->input('to_day.'.'1',array('id'=>'end1','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'default'=>'30'));?>
							  </td>
						   </tr>
						   
						   <tr>
							  <td>
							   2
							  </td>
							  <td>
							  	<?php echo $this->Form->input('name.'.'2',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','default'=>'31-60 days'));?>
							  </td>
							  <td>
							  	  <?php echo $this->Form->input('from_day.'.'2',array('id'=>'start2','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'default'=>'31','readonly'=>'readonly'));?>
							  </td>
							  <td>
							  	 <?php echo $this->Form->input('to_day.'.'2',array('id'=>'end2','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'default'=>'60'));?>
							  </td>
						   </tr>
						   
						   <tr>
							  <td>
							   3
							  </td>
							  <td>
							  	<?php echo $this->Form->input('name.'.'3',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','default'=>'61-90 days'));?>
							  </td>
							  <td>
							  	  <?php echo $this->Form->input('from_day.'.'3',array('id'=>'start3','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'default'=>'61','readonly'=>'readonly'));?>
							  </td>
							  <td>
							  	 <?php echo $this->Form->input('to_day.'.'3',array('id'=>'end3','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'default'=>'90'));?>
							  </td>
						   </tr>
						   
						   <tr>
							  <td>
							   4
							  </td>
							  <td>
							  	<?php echo $this->Form->input('name.'.'4',array('type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','default'=>'90+ days'));?>
							  </td>
							  <td>
							  	  <?php echo $this->Form->input('from_day.'.'4',array('id'=>'start4','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'default'=>'91','readonly'=>'readonly'));?>
							  </td>
							  <td>
							  	 <?php echo $this->Form->input('to_day.'.'4',array('id'=>'end4','type'=>'text','label'=>false,'div'=>false,'class'=>'form-control','onkeypress' => "return isNumberKey(event)",'default'=>NULL));?>
							  </td>
						   </tr>
						 	
						 	
						 	
						 <?php } ?>	 
						 
							
							
						   </tbody>
						</table>
					</div>
			</div>	
			
           <div class="row marginleftrightzero paddingbottom20">
              <div class="clearfix form-actions margintopzero paddingtopzero no-padding-left no-padding-right">
                  <div class="col-md-offset-3 col-md-6 footerbutton">
                    <!--<button class="btn btn-info" type="button"> <i class="icon-check-sign bigger-110"></i> Submit </button>-->
                    <?php if($permission['_update'] == 1) echo $this->Form->button('<i class="icon-ok bigger-110"></i>Update',array('type'=>'submit','class'=>'btn btn-info button_mobile'));?>
                    
                  </div>
                </div>
            </div>
            <div class="imageerror">
            	  <?php echo $this->Form->hidden('Imageupload',array('value'=>'true','class'=>'checkupload')); ?>   
            </div>
        
		<?php echo $this->Form->end();?>
</div>
      
<script type="text/javascript">
	window.jQuery || document.write("<script src='<?php echo $this->webroot.'js/';?>jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>


<script type="text/javascript">
	if("ontouchend" in document) document.write("<script src='<?php echo $this->webroot.'js/';?>jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script> 

<script type="text/javascript">
$(document ).ready(function() {
   $("#end1" ).keyup(function() {
      var end1val= $("#end1").val();
      if(end1val !=''){
      	 $("#start2").val(parseInt(end1val)+1);
      	 $("#start2").prop("readonly",true);
      }else{
      	 $("#start2").val('');
      	 $("#start2").prop("readonly",false);
      }
   });
   
   $("#end2" ).keyup(function() {
   	  
   	  
   	  var end2val= $("#end2").val();
      if(end2val !=''){
      	 $("#start3").val(parseInt(end2val)+1);
      	 $("#start3").prop("readonly",true);
      }else{
      	 $("#start3").val('');
      	 $("#start3").prop("readonly",false);
      }
   });
    $("#end3" ).keyup(function() {
      var end3val= $("#end3").val();
      if(end3val !=''){
      	 $("#start4").val(parseInt(end3val)+1);
      	 $("#start4").prop("readonly",true);
      }else{
      	  $("#start4").val('');
      	  $("#start4").prop("readonly",false);
      }
   });
});

function minmax(value, min, max) 
{
    if(parseInt(value) < 1 || isNaN(value)) 
        return 1;
    else if(parseInt(value) > 50) 
        return 50;
    else return value;
}

</script>

<script type="text/javascript">

jQuery(function($) {
	$(".chosen-select").chosen();
});
$(document).ready(function(){
	
	/* choosen select*/
		var config = {
			  
			  '.invdrop' : {search_contains:true}
			}
			for (var selector in config) {
			  $(selector).chosen(config[selector]);
		}
	/* choosen select*/
	
	$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});
	 
	$('body').on('click','.add-row',function(){	
			var d = new Date();
		    var n = d.getTime();				
			var content='<tr><td><div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero"><div class="col-sm-10 marginleftrightzero paddingleftrightzero "><select class="chosen-select"  data-placeholder="Item"><option>Apple</option><option>Orange</option><option>Grapes</option></select></div><div class="col-sm-2 marginleftrightzero paddingleftrightzero paddinglefttop4"><div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select"><i class="icon-plus"></i></div></div></div></td><td><div class="form-group marginleftrightzero margin-bottom-zero"><textarea class="col-sm-12 tabletextarea"></textarea></div></td><td><div class="form-group marginleftrightzero margin-bottom-zero"><input type="text" class="col-xs-10 col-sm-5 form-control" id="spinner'+n+'"/></div></td><td><div class="form-group marginleftrightzero margin-bottom-zero"><input type="text"  class="col-sm-10 form-control"/></div></td><td><div class="form-group marginleftrightzero margin-bottom-zero"><input type="text"  class=" col-xs-10 col-sm-5 form-control"/></div></td><td><div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero"><div class="col-sm-12 marginleftrightzero paddingleftrightzero"><select class="chosen-select"  data-placeholder="None"><optgroup label="Taxes"><option>GST[10%]</option><option>PST[15%]</option></optgroup><optgroup label="TAx Group"><option>Test Tax Group1[15%]</option><option>Test Tax Group2[25%]</option><option>Test Tax Group3[35%]</option></optgroup></select></div></div></td><td><div class="form-group marginleftrightzero margin-bottom-zero"><input type="text"  class="col-xs-10 col-sm-5 form-control" disabled="disabled"/></div><i class="icon-trash bigger-110 remove-row"></td></tr>';
			$('#quote-table tbody').append(content).fadeIn('slow');
			$(".chosen-select").chosen();
		    $('#spinner'+n).ace_spinner({value:1,min:1,max:200,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
		    .on('change', function(){});
	});
	
	if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	}  
	
});

$('body').on('click','.remove-row',function(){
  $(this).parents('tr').remove();
});
$(document).ready(function(){

 	$("#SbsSubscriberSettingGeneralSettingForm").validate({
 		 ignore: [], 
		 rules: {           
			"data[SbsSubscriberSetting][date_format]": {
				required : true
			},			
			
			"data[SbsSubscriberSetting][lines_per_page]":{
				required : true
				
			},
			"data[SbsSubscriberSetting][time_zone]":{
				required : true
				
			},
			"data[SbsSubscriberSetting][recurring_status]":{
				required : true
				
			},
			"data[SbsSubscriberSetting][invoice_sequence_number]":{
				required : true
				
			},
			"data[SbsSubscriberSetting][invoice_number_prefix]":{
				required : true,
				
			},
			"data[SbsSubscriberSetting][recurring_invoice_format]":{
				required : true
				
			},
			"data[SbsSubscriberSetting][quote_number_prefix]":{
				required : true
				
			},
			"data[SbsSubscriberSetting][quote_sequence_number]":{
				required : true,
				
			},
			 "data[SbsSubscriberSetting][credit_note_prefix]":{
				required : true
				
		 	 },
		 	
		 	  
			
			<?php if($aging_bucket_details){ 
					  for($i=1; $i <= 4 ;$i++){ ?>
						"data[edit_name][<?php echo $i;?>]":{
							required : true
						},
						"data[edit_from_day][<?php echo $i;?>]":{
							required : true
						},
						
						<?php if($i < 4){ ?>
						"data[edit_to_day][<?php echo $i;?>]":{
							required : true
						},
						<?php } ?>
				
			         <?php } 
			   }else{
			   	    for($i=1; $i <= 4 ;$i++){ ?>
						"data[name][<?php echo $i;?>]":{
							required : true
						},
						"data[from_day][<?php echo $i;?>]":{
							required : true
						},
						
						<?php if($i < 4){ ?>
						"data[to_day][<?php echo $i;?>]":{
							required : true
						},
						<?php } ?>
				
			         <?php } 
			   } ?>
			
			 "data[SbsSubscriberSetting][credit_note_sequence_number]":{
				required : true
				
		 	 }
		 	  
		 },
		 messages:{			 
			 "data[SbsSubscriberSetting][date_format]":{
				required: "Please select date format"				
		 	 },
			 
		    "data[SbsSubscriberSetting][lines_per_page]":{
				required: "Please enter lines per page"
				
		    },
		     "data[SbsSubscriberSetting][time_zone]":{
				required: "Please select time zone"
				
		 	 },
		 	  "data[SbsSubscriberSetting][recurring_status]":{
				required: "Please select recurring status"
				
		 	 },
		 	  "data[SbsSubscriberSetting][invoice_sequence_number]":{
				required: "Please enter the invoice number prefix"
				
		 	 },
		 	  "data[SbsSubscriberSetting][invoice_number_prefix]":{
				required: "Please enter the invoice starting sequence number"
				
		 	 },
		 	 "data[SbsSubscriberSetting][recurring_invoice_format]":{
				required: "Please enter the recurring invoice number prefix"
				
			},
		 	  "data[SbsSubscriberSetting][quote_number_prefix]":{
				required: "Please enter the quote number prefix"
				
		 	 },
		 	 "data[SbsSubscriberSetting][quote_sequence_number]":{
				required: "Please enter the quote starting sequence number"
				
		 	 },
		 	 "data[SbsSubscriberSetting][credit_note_prefix]":{
				required: "Please enter the credit note prefix"
				
		 	 },
		 	
		 	 
		 	 <?php if($aging_bucket_details){ 
					  for($i=1; $i <= 4 ;$i++){ ?>
						"data[edit_name][<?php echo $i;?>]":{
							required : "Please enter bucket name"
						},
						"data[edit_from_day][<?php echo $i;?>]":{
							required : "Please enter from day"
						},
						
						<?php if($i < 4){ ?>
						"data[edit_to_day][<?php echo $i;?>]":{
							required : "Please enter to day"
						},
						
						<?php } ?>
				
			         <?php } 
			   }else{
			   	    for($i=1; $i <= 4 ;$i++){ ?>
						"data[name][<?php echo $i;?>]":{
							required : "Please enter bucket name"
						},
						"data[from_day][<?php echo $i;?>]":{
							required : "Please enter from day"
						},
						
						<?php if($i < 4){ ?>
						"data[to_day][<?php echo $i;?>]":{
							required : "Please enter to day"
						},
						
						<?php } ?>
				
			         <?php }
			   } ?>
			    "data[SbsSubscriberSetting][credit_note_sequence_number]":{
				required: "Please enter the credit note starting sequence number"
				
		 	 }
		 	  
		 	 
		 }
	});	

});


$(document).ready(function(){
	
	
	$('.select-dropdown>ul a').on('click', function(){    
		$('.btn-select').html($(this).html() + '<span class="caret"></span>');    
	});
	
	$('#exampleInputFile').change(function() {
		var inputvalue = $(this).val().split('\\').pop();
		
		var f=this.files[0]
    	var size=(f.size);
    	$('.current_file_size').text(inputvalue);
    	$('.file-size').text(size+ ' Bytes');
		
	});
	$('.close-it, .btn-rmv').click(function(){
		$(".display-thumbnail").hide();
		$('#exampleInputFile').empty(); 
	});
	
	$('.display-thumbnail input[type=file]').removableFileUpload();
});



function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#img_prev').attr('src', e.target.result);
                var checkerror =$(".checkupload").val();	
                if(checkerror == 'false'){
                	$('.display-thumbnail').hide();
                }else{
                	$('.display-thumbnail').show();
                	$('.old').hide();
                }
			}
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#exampleInputFile").change(function(){
        readURL(this);
		
    });
  
  
  
  $('body').on("change","#exampleInputFile",function(){
    		var f=this.files[0]
    		var type=(f.type);
    		var size=(f.size);
    		
    		if((type != 'image/jpg') && (type != 'image/jpeg')){
            	alert('Type of file: jpeg');
            	$(".checkupload").val('false');
            	$(".display-thumbnail").hide();	
            	return false;
            }
            if(size > '104857600'){
            	alert('Upload image size should be less than or equal to 100mb');
            	$(".checkupload").val('false');
            	$(".display-thumbnail").hide();	
            	return false;
            }
            
            $(".checkupload").val('true');
            $(".display-thumbnail").show();
            return true;
            
     });
var _URL = window.URL;
     
 $("#exampleInputFile").change(function (e) {
 	
    var file, img;
    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
        	if(this.width > 100){
        		alert('Image width should not be greater than 100px');
        		$(".checkupload").val('false');
        		$(".display-thumbnail").hide();
        		return false;
        		
        	}
        	if(this.height > 45){
        		alert('Image height should not be greater than 45px');
        		$(".checkupload").val('false');
        		$(".display-thumbnail").hide();
        		return false;
        	}
        	
        	$(".checkupload").val('true');
        	$(".display-thumbnail").show();
            return true;
            
        };
        img.src = _URL.createObjectURL(file);
    }
}); 
</script>

<style>
	.close-it {
	    position:absolute;
	    height: 40px;$('.cb').prop('checked', false);
	    width: 40px;
	    line-height: 29px;
	    padding: 0;
		background: url('../img/spritemap.png') -268px -123px;
	    cursor: hand;
		top:0px;
		right:-10px;
		margin-top:-12px;
	}
	.blue_back{
		background-color:#2679B5;
	}
</style>

