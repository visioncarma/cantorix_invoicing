<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
	$settings = $this->Breadcrumb->getLink('Settings');
	
?>
<div id ="session">
	<?php echo $this->Session->flash();?>
</div>
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
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		<li>
			<a href="#">Preferences</a>
		</li>
		<li class="active">
			<?php echo __('Custom Field Configuration');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 > <?php echo __('Custom Field Configuration');?> </h1>

	</div>
	<!-- /.page-header -->
	<?php echo $this->Form->create('CustomField',array('class'=>'form-horizontal formdetails margintopzero','role'=>'form'));?>
	<form class="form-horizontal formdetails margintopzero" role="form">
		<div class="row marginleftrightzero">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero ">
				<div class="row marginleftrightzero borderbottom">
					<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero">
						<p class="module-configuration">
							<?php echo "A maximum of 5 custom fields can be configured for each of the following modules:";?>
						</p>
						<ul class="modules_list">
							<li>
								<?php echo __('CUSTOMERS');?>
							</li>
							<li>
								<?php echo __('INVOICES & QUOTATIONS');?>
							</li>
							<li>
								<?php echo __('EXPENSES');?>
							</li>
							<li>
								<?php echo __('INVENTORIES');?>
							</li>
						</ul>
						<p class="module-configuration">
							To do this you have to select a module from the "Select Module" drop down.
						</p>
						<p class="module-configuration">
							Once this is done enter a Name for Field 1 in the "Field Name" box.</br>
							<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style = "height: 10%;padding-left: 0;padding-right: 0;padding-top: 0;width: 65%;">
							To add additional fields click on the <div class="btn btn-sm btn-success addbutton addunitpadding addmoreunittype  additem-to-select addfield"><i class="icon-plus"></i></div> sign and the above steps.
							</div>
						</p>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 paddingleftrightzero">
						<div data-target="#viewuser" data-toggle="modal">
							<?php echo $this->Html->image('custom_field_preview.jpg',array('class'=>'pointer','alt'=>'preview'))?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero borderbottom paddingtop25">
					<div class="form-group marginleftrightzero">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero ">
							<label  class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label marginleftrightzero paddingleftrightzero"><?php echo __('Select Module');?></label>
							<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 marginleftrightzero paddingleftrightzero labelerror choosen_width">
								<?php $options = array(''=>'Select Module','AcrClientCustomField'=>'Customers','AcpExpenseCustomField'=>'Expenses','InvInventoryCustomField'=>'Inventories','AcrInvoiceCustomField'=>'Invoices & Quotations'/*,'AcrInvoicePaymentDetailCustomField'=>'Payment'*/);?>
								<?php echo $this->Form->input('CustomField.module',array('id'=>'Module','div'=>false,'label'=>false,'class'=>'invdrop selectitem form-control','data-placeholder'=>'Module Name','options'=>$options));
										   $this -> Js -> get('#Module') -> event('change', $this -> Js -> request(array('controller' => 'CustomFields', 'action' => 'listFields'), array('update' => '#fieldInfo', 'async' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))));
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero borderbottom paddingtop25">
					<div class="form-group marginleftrightzero content-parent" id = "fieldInfo">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero paddingtopbottom5 added-area" >
								<label  class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label marginleftrightzero paddingleftrightzero label-row-update"><?php echo __('Field Name');?></label>
								<div class="col-lg-3 col-md-4 col-sm-12 col-xs-10 marginleftrightzero paddingleftrightzero">
									<?php echo $this->Form->input('CustomField.field.1',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control'))?>
								</div>
								<?php if($permission['_create'] == '1'):?>
								<div class="col-lg-2 col-md-2 col-sm-12 col-xs-2  paddingtop5">
									<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype  additem-to-select addfield">
										<i class="icon-plus"></i>
									</div>
								</div>
								<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row marginleftrightzero paddingbottom20 paddingtop25">
			<div class="clearfix form-actions margintopzero paddingtopzero no-padding-left no-padding-right">
				<div class="col-md-offset-2 col-md-6 footerbutton">
					<?php if(($permission['_create'] == '1') || ($permission['_update'] == '1')):?>
					<?php echo $this -> Form -> button('<i class="icon-save bigger-110"></i> Submit', array('url' => array('controller' => 'CustomFields', 'action' => 'add'), 'div' => false, 'class' => 'btn btn-info button_mobile')); ?>
					<?php endif; ?>
					<?php echo $this->Html->link('<i class="icon-undo bigger-110"></i> Reset',array('controller'=>'CustomFields','action'=>'add'),array('class'=>'btn btn-inverse button_mobile','escape'=>false))?>
					
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /.page-content -->

<!-- basic scripts -->
<!--Popup veiw  -->
<div class="modal fade" id="viewuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:60%;height:60%;">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
			</div>
			<div class="form-horizontal popup">
				<div class="modal-body" style="width:100%;float:left;max-width:100%;">
					<div class="model-body-inner-content">
						<?php echo $this->Html->image('Custom_Field_Configuration_popup.jpg',array('class'=>'img-responsive','alt'=>'preview'));?>
					</div>
				</div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
</div>
<!--end of pop-->

<script type="text/javascript">
	if ("ontouchend" in document)
		document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
</script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/typeahead-bs2.min.js"></script>
<script>
	$(document).ready(function(){
		/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
		
		
		$('body').on('click','.selectitem .dropdown-menu li',function(){
			console.log("just entered");
			//alert("hi");
	      var thisvalue = $('.selectitem .btn .filter-option').text();
			if (thisvalue=="Select Module")
			   {
			   	console.log("entered in if true");
			   	 $(this).parents('.btn-group').siblings('label.error').show();
			   }
			   else{
			   	console.log("entered in if false");
			   	  $(this).parents('.btn-group').siblings('label.error').hide();
			   }
         });	 
		 $("#CustomFieldAddForm").validate({
		 	ignore: [],
		 	rules: {				
				'data[CustomField][module]':{ 
				   required : true
				}
		  },
		  messages: {
				'data[CustomField][module]': {
				    required : 'Please select the module'
			     }
	     }
	  });
		countMyLabels();
		if ($('.selectpicker').length) {
			$('.selectpicker').selectpicker({
			});
		}
		$('body').on('click', '.paddingdelete', function() {
			$(this).parents('.col-lg-12.added-area').remove();
			countMyLabels();
		});
		$('body').on('click', '.addfield', function(){
			console.log($('.added-area').length);
			if($('.added-area').length<5){
			var content = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero paddingtopbottom5 added-area"><label  class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label marginleftrightzero paddingleftrightzero label-row-update">Field Name</label><div class="col-lg-3 col-md-4 col-sm-12 col-xs-10 marginleftrightzero paddingleftrightzero"><input type="text" class="form-control"/></div><div class="col-lg-2 col-md-2 col-sm-12 col-xs-2  paddingtop5"><div class="btn btn-sm btn-danger pull-left paddingdelete padding04"><i class="icon-trash"></i></div></div></div>';
            $(this).parents('.content-parent').append(content);	
            countMyLabels();
            }
            else{
            	alert("You can not enter more than five custom fields");
            }
            	
		});
	
	function countLabels(){
		
	}
	function countMyLabels(){
			var labelCount=1;
			$('.label-row-update').each(function(){
				//$(this).text("Field "+labelCount);
				$(this).siblings('div').find('input.form-control').attr('name','CustomField[field]['+labelCount+']');
				labelCount++;
			});
			
	}
	//function addingLabel(){
	//	    var labelCounted=$('.label-row-update').length;		   
	//	    return labelCounted;
	//} 
	});
</script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
<script src="assets/js/excanvas.min.js"></script>
<![endif]-->

<!-- inline scripts related to this page -->

<!-- inline scripts related to this page -->
<?php echo $this -> Js -> writeBuffer(); ?>
