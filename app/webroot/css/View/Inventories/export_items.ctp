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
		<li class="active">
			<?php echo $this->Html->link('Inventory',array('controller'=>'Inventories','action'=>'index'));?>
		</li>
		<li class="active">
			<?php echo __('Export Inventory');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 class="managecustomer manageinventory"> <?php echo __('Export Inventory');?> </h1>
		<div class="col-lg-6 col-sm-12 col-md-12  col-xs-12 paddingleftrightzero pull-right">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i> Back', array('controller' => 'inventories', 'action' => 'index'), array('div' => false,'class'=>'btn btn-sm btn-success pull-right addbutton','escape' => false)); ?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll">
				<div class="table-header">
					<?php echo __('Export Inventory');?>
				</div>
				<?php echo $this->Form->create('InventoryFilter',array('id'=>'InventoryFilter','url'=>array('controller'=>'inventories','action'=>'export')));?>
				<div class="row margin-twenty-zero">
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-lg-2 nopadding">
						<?php echo $this->Form->input('item_name',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-filter-field-1','placeholder'=>'Item Name','class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-lg-2 nopadding">
						<?php echo $this->Form->input('price_min',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-filter-field-2','placeholder'=>'Minimum Price','class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-lg-2 nopadding">
						<?php echo $this->Form->input('price_max',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-filter-field-2','placeholder'=>'Maximum Price','class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 nopadding col-lg-2">
						<?php echo $this->Form->input('quantity',array('div'=>false,'label'=>false,'options'=>array(''=>'Select stock-wise','in-stock'=>'In Stock','out-stock'=>'Out Of Stock'),'class'=>'form-control selectpicker'))?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Js->submit('Export', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn taxgrpfilter form-control','url' => array('controller'=>'inventories','action' => 'export'),'escape'=>false,'update' => '#pageContent'));?>
					</div>
				</div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	 if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
     } 
});     
</script>
