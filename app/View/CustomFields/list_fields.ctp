<?php $i = 1; ?>
<?php foreach($getCustomFields as $key=>$val): ?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero paddingtopbottom5 added-area" id = "removeRow-<?php echo $key;?>">
	<label  class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Field Name</label>
		<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 marginleftrightzero paddingleftrightzero">
			<?php echo $this->Form->input('CustomField.fieldOld.'.$key,array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control','value'=>$val)); ?>
		</div>
		<?php if($permission['_delete'] == '1'):?>
		<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12  paddingtop5">
		<?php echo $this -> Js -> link('<div class="btn btn-sm btn-danger pull-left paddingdelete"><i class="icon-trash bigger-120"></i></div>', 
																 array('controller' => 'CustomFields', 'action' => 'remove',$key,$module),
												    			 array('escape' => FALSE, 'update' => '#removeRow-'.$key,'title'=>'Remove','confirm'=>'Field will be deleted permanently.Are you sure you want to delete?'));?>
		</div>
		<?php endif; ?>
</div>
<?php $i++;?>
<?php endforeach;?>
<?php if($i<=5){ ?>
<?php if($permission['_create'] == '1'):?>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero paddingtopbottom5 added-area" >
		<label  class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Field Name</label>
			<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 marginleftrightzero paddingleftrightzero">
				<?php echo $this->Form->input('CustomField.field.1',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control'))?>
			</div>
			
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12  paddingtop5">
				<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype  additem-to-select addfield">
					<i class="icon-plus"></i>
				</div>
			</div>
			
	</div>
	<?php endif; ?>
<?php }?>

<?php echo $this -> Js -> writeBuffer(); ?>