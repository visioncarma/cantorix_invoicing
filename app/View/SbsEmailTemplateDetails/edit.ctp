<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="#">Home</a>
		</li>
		<li>
			<a href="#">Settings</a>
		</li>
		<li>
			<a href="#">Preferences</a>
		</li>
		<li>
			<a href="#">Configure Email</a>
		</li>
		<li class="active">
			Edit Template
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1> Edit Email Template </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i> Back', array('action' => 'index'), array('class' => 'btn btn-sm btn-success pull-right addbutton', 'escape' => FALSE)); ?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="container">
		<div class="row">
			<?php echo $this->Form->create('report-writer',array('id'=>'report-writer','class'=>'form-horizontal edit_email_template','role'=>'form'));?>
				<div class="form-group">

					<label class="col-md-2 col-sm-3 col-sx-12" for="form-field-1"> Template Name </label>

					<div class="col-md-5 col-sm-9 col-sx-12">
						<?php
								echo $this->Form->hidden('templateId',array('value'=>$id));
								echo $this->Form->input('email_template_name',array('id'=>'form-field-5','label'=>false,'div'=>false,'type'=>'text','value'=>$templateName)) ;
						?>
					</div>

				</div>
				<div class="form-group">

					<label class="col-md-2 col-sm-3 col-sx-12" for="form-field-1"> From Email Template </label>

					<div class="col-md-5 col-sm-9 col-sx-12">
						<?php
								echo $this->Form->input('from_email_address',array('id'=>'form-field-1','label'=>false,'div'=>false,'type'=>'text','value'=>$organizationMail)) ;
						?>
					</div>

				</div>
				<div class="form-group email_body_wrap">

					<label class="col-md-2 col-sm-3 col-sx-12" for="form-field-1"> Email Subject </label>

					<div class="col-md-6 col-sm-7 col-sx-12">
						<?php
									echo $this->Form->input('email_subject',array('id'=>'email_subject','label'=>false,'div'=>false,'type'=>'textarea','rows'=>'4','value'=>$subject)) ;
						?>
					</div>

					<div class="col-md-2 col-sm-2 col-sx-12 input_cret_item">
						<input type="text" id="email_body_item_field2"  value="Insert value">
						<b class="caret input_cret"></b>

						<div id="email_body_items2" class="email_body_items2 clearfix" style="display:none;">
							<!-- <a href="#" class="close_it">Close it</a> -->
							<button type="button" class="icon-remove close_it2"></button>
							<div class="col-md-6 col-xs-6">
								<span class="labelstrong">Invoice Section1</span>
								<div class="tags_select3">
									<ul>
										<?php foreach($leftWing as $key=>$val):?>
										<li>
											<a href="#"><?php echo $val;?></a>
										</li>
										<?php endforeach;?>
									</ul>
								</div>
							</div>
							<div class="col-md-6 col-xs-6" id="p">
								<span class="labelstrong">Customer Section1</span>
								<div class="tags_select4">
									<ul>
										<?php foreach($rightWing as $rightKey=>$rightVal):?>
										<li>
											<a href="#"><?php echo $rightVal;?></a>
										</li>
										<?php endforeach;?>
									</ul>
								</div>
							</div>
						</div>
					</div>

				</div>
				<div class="form-group email_body_wrap">
					<hr>
					<label class="col-md-7 col-sm-10 col-sx-12 labelstrong" for="form-field-1"> Email Body </label>

					<div class="col-md-2 col-sm-2 col-sx-12 pull-right input_cret_item">
						<input type="text" id="email_body_item_field" value="Insert value">
						<b class="caret input_cret"></b>
						<div id="email_body_items" class="email_body_items"  style="display:none;">
							<button type="button" class="icon-remove close_it"></button>
							<div class="col-md-6 col-xs-6">
								<span class="labelstrong">Invoice Section</span>
								<div class="tags_select1">
									<ul>
										<?php foreach($leftWing as $key=>$val):?>
										<li>
											<a href="#"><?php echo $val;?></a>
										</li>
										<?php endforeach;?>
									</ul>
								</div>
							</div>
							<div class="col-md-6 col-xs-6">
								<span class="labelstrong  mtm-20">Customer Section</span>
								<div class="tags_select2">
									<ul>
										<?php foreach($rightWing as $rightKey=>$rightVal):?>
										<li>
											<a href="#"><?php echo $rightVal;?></a>
										</li>
										<?php endforeach;?>
									</ul>
								</div>
							</div>
						</div>

					</div>

					<div class="col-xs-12 mt-20">
						<?php  
							if($myelement){
									$myelement = str_replace('<pre>', '', $myelement);
									$myelement = str_replace('</pre>', '', $myelement);
									echo $this->Form->textarea('myelement', array('id'=>'email_body','rows'=>'10','value'=>$myelement));
							}else{
									echo $this->Form->textarea('myelement', array('id'=>'email_body','rows'=>'10'));
							}
						?>			
					</div>

				</div>

				<div class="clearfix form-actions margintopzero paddingtopzero">
					<div class="pull-right paddingleft30">
						<?php echo  $this->Form->button(__('<i class="icon-ok bigger-110"></i>Save Template'),array('url'=>array('controller'=>'report_writer_templates','action'=>'add',$status,$page),'div'=>false,'class'=>'btn btn-info','escape'=>false));?>
						<!--button class="btn btn-info" type="button">
							<i class="icon-ok bigger-110"></i>
							Save Template
						</button-->
						<button class="btn" type="reset">
							<i class="icon-undo bigger-110"></i>
							Reset
						</button>
					</div>
				</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>

</div><!-- /.page-content -->

<!-- inline scripts related to this page -->

<script type="text/javascript">
	jQuery(function($) {
		$(".chosen-select").chosen();
		$('#spinner1').ace_spinner({
			value : 0,
			min : 0,
			max : 200,
			step : 1,
			btn_up_class : 'btn-info',
			btn_down_class : 'btn-info'
		}).on('change', function() {
		});
	}); 
</script>
<div>

