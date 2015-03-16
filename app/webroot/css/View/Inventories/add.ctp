<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
?>
<?php echo $this->Session->flash();?>

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
			<?php echo $this->Html->link('Inventory', array('controller' => 'inventories', 'action' => 'index'), array('div' => false,'escape' => false)); ?>
		</li>
		<li class="active">
			<?php echo __('Add New Items');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1> <?php echo __('Add New Items');?> </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i> Back', array('controller' => 'inventories', 'action' => 'index'), array('div' => false,'class'=>'btn btn-sm btn-success pull-right addbutton','escape' => false)); ?>
		</div>
	</div>
	<!-- /.page-header -->
	
	<div class="row">
		<div class="col-xs-12">
			<?php echo $this->Form->create('InvInventory',array('class'=>'form-horizontal','role'=>'form','id'=>'InvInventory','url'=>array('controller'=>'inventories','action'=>'add'))); ?>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> </label>
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<?php echo $this->Form->input('name',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','id'=>'orm-field-1','Placeholder'=>'Inventory name'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
					<div class="col-xs-12 col-sm-5 col-lg-4">
						<?php echo $this->Form->input('description',array('div'=>false,'label'=>false,'type'=>'textarea', 'rows'=>"2",'class'=>'col-xs-3 col-sm-5 itemdescription form-control', 'id'=>'form-field-2','Placeholder'=>'Description of the inventory'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?></label>
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<span>
							<?php echo $this->Form->hidden('currency',array('value'=>$defaultCurrency['CpnCurrency']['id']));?>
							<?php echo $this->Form->input('code',array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 col-sm-5 form-control','style'=>'width:20%','value'=>$defaultCurrency['CpnCurrency']['code'],'readonly'=>'readonly'))?>
						</span>
						<span>
							<?php echo $this->Form->input('list_price',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 col-sm-5 form-control','style'=>'width:80%','Placeholder'=>'Inventory price'));?>
						</span>
						
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
					<div class="col-sm-5 col-xs-12 col-lg-3 labelerror countrybilling">
						<?php echo $this->Form->input('tax_inventory',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control selectpicker scroll-height','options'=>array(''=>'Select Tax',$list)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
					<div class="col-sm-5 col-xs-12 col-lg-3 labelerror countrybilling selectOption" id ="unit-type">
						<?php echo $this->Form->input('unitType',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control selectpicker scroll-height','options'=>array(''=>'Select Unit Type',$unitTypeList)));?>
					</div>
					<div class="col-sm-3 col-xs-12 paddingtop5smallview">
						<button class="btn btn-sm btn-success pull-left addbutton addunitpadding cleardata" data-toggle="modal" data-target="#addnewunittype">
							<i class="icon-plus"></i>
						</button>
						<label class="addcontact"><?php echo __('Add Unit Type');?></label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
					<div class="col-sm-3 col-xs-12 col-lg-3">
						<label>
							<?php echo $this->Form->checkbox('track',array('div'=>false,'label'=>false,'class'=>'ace'));?>
							<span class="lbl"></span> </label>
						<label class="maillabel">Yes</label>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-3 col-xs-12 col-lg-2 control-label no-padding-right" for="form-field-1"> <?php echo __('Current Stock');?> </label>
					<div class="col-sm-5 col-xs-12 col-lg-3">
						<?php echo $this->Form->input('current_stock',array('div'=>false,'label'=>false,'type'=>'text','class'=>'col-xs-10 col-sm-5 form-control','id'=>'form-field-4','Placeholder'=>'Quantity of inventory  in stock'));?>
					</div>
				</div>
				<?php if($customFields):?>
				<div class="col-sm-12 contactdetails paddingleftrightzero">
					<h5 class="width-100"><?php echo __('Additional Information');?></h5>
				</div>
				<?php foreach($customFields as $fieldId=>$fieldValue):?>
				<div class="form-group">
					<label class="col-sm-3 col-xs-12 col-lg-2 control-label no-padding-right" for="form-field-1"> <?php echo $fieldValue;?> </label>
					<div class="col-sm-5 col-xs-12 col-lg-3">
						<?php echo $this->Form->input('customField'.$fieldId,array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-5','class'=>'col-xs-10 col-sm-5 form-control'));?>
					</div>
				</div>
				<?php endforeach;?>
				<?php endif; ?>
				 <div class="clearfix form-actions margintopzero paddingtopzero addformbutton">
							<div class="col-md-offset-2 col-md-4">
	                     <?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Save',array('class'=>'btn btn-info','escape'=>false));?>
					
						<button class="btn btn-inverse" type="reset">
							<i class="icon-undo bigger-110"></i> Reset
						</button>
					</div>
				</div>
				<?php echo $this->Form->end();?>
		</div>
	</div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a>
<!-- /.main-container -->
<!--Popup add  -->
<div class="modal fade" id="addnewunittype" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title" id="myModalLabel"><?php echo __('Add Unit Type');?></h1>
			</div>
			<?php echo $this->Form->create('unitType',array('id'=>'addnewcurrency','role'=>'form','class'=>'form-horizontal popup'));?>
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="addtype-wrapper">
							<div class="form-group login-form-group">
								<label class="col-sm-3 control-label"><?php echo __('Unit Type');?> </label>
								<div class="col-sm-9 nopaddingleft nopaddingright">
									<?php echo $this->Form->input('unit_type.1',array('div'=>false,'label'=>false,'class'=>'form-control','autocomplete'=>'off','type'=>'text'));?>
								</div>
								<!--div class="col-sm-1 paddingleftrightzero">
									<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype">
										<i class="icon-plus"></i>
									</div>
								</div-->
							</div>
							<!--div class="form-group login-form-group">
								<label class="col-sm-3 control-label"> <?php echo __('Unit Type');?> </label>
								<div class="col-sm-8">
									<?php echo $this->Form->input('unit_type.2',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'text'));?>
								</div>
							</div>
							<div class="form-group login-form-group">
								<label class="col-sm-3 control-label"> <?php echo __('Unit Type');?> </label>
								<div class="col-sm-8">
									<?php echo $this->Form->input('unit_type.3',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'text'));?>
								</div>
							</div-->
						</div>
					</div>
				</div>
				<div class="modal-footer paddingright5p relative">
					<div class="canceicon">
					<button class="btn close-popup btn-inverse" type="button">
						<i class="icon-remove bigger-110"></i>
						Cancel
					</button>
					</div>
					<div class="saveicon">
					<i class="icon-ok iconpopupok mobile-fix"></i>
					<?php echo $this->Js->submit('Save', array('div'=>false,'class'=>'btn btn-info padrightleft popsubmit','autocomplete'=>'off','url' => array('controller'=>'inventories','action'=>'addUnit'),'escape'=>false,'update' => '#unit-type'));?>
				</div>
					<!--<button class="btn btn-info" type="button">
						<i class="icon-ok bigger-110"></i>
						Submit
					</button>-->
					
				</div>
			<?php echo $this->form->end();?>
		</div>
	</div>
</div>
<!--end of pop-->

<!-- inline scripts related to this page -->

<script type="text/javascript">
	jQuery(function($) {
		$('.close-popup').click(function(){
		   $('.close').trigger('click');
		});
		
		$('.popsubmit').click(function(){
		   $('.close').trigger('click');
		});
		if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
        } 
	});
	$(document).ready(function() {
		$('body').on('click', '.addmoreunittype', function() {
			$('.addtype-wrapper').append('<div class="form-group login-form-group"><label class="col-sm-3 control-label">Unit Type </label><div class="col-sm-8"><input type="text" class="form-control" name="" ></div><div class="col-sm-1 paddingleftrightzero"><i class="icon-trash bigger-120 popup-trash"></i></div></div>');
		});
		$('body').on('click', '.popup-trash', function() {
			$(this).parents('.form-group.login-form-group').remove();
		});
		
		$('.cleardata').click(function(){
			$('#unit_type1').val('');
		});
	});

</script>

<script type="text/javascript" >

	$(document).ready(function(){
	 $("#InvInventory").validate({
	 	    onkeyup: false,
			rules: {
				'data[InvInventory][name]': { 
				   required : true
			     },			
				'data[InvInventory][list_price]': { 
				   required : true,
				   number	: true
			     },	
			     'data[InvInventory][current_stock]' : {
			     	required : true,
			     	number	 : true
			     },
			     'data[InvInventory][currency]' : {
			     	required : true
			     }
			},
			messages: {
				'data[InvInventory][name]':  { 
				   required : 'Please enter inventory name.'
			     },	
				'data[InvInventory][list_price]':  { 
				   required : 'Please enter price for inventory.',
				   number	: 'Price should be number.'
			     },	
			     'data[InvInventory][current_stock]' : {
			     	required : 'Please enter stock quantity.',
			     	number	 : 'stock quantity should be number.'
			     },
			      'data[InvInventory][currency]' : {
			     	required : 'Please select a currency.'
			     }
			}
		});
		
		
		
		
		 $("#addnewcurrency").validate({
			rules: {
				'#eunit_type1': { 
				   required : true
			     }
			},
			messages: {
				'#unit_type1':  { 
				   required : 'Please enter the unit type.'
			     }
			}
		});
		
});
</script>
<?php echo $this->Js->writeBuffer();?>  
