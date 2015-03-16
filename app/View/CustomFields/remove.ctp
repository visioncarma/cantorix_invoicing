<?php if(count($getCustomFields) == 4){ ?>
	<div class="col-lg-12 paddingleftrightzero paddingtopbottom5" >
		<label  class="col-sm-2 control-label marginleftrightzero paddingleftrightzero">Field <?php echo $i;?></label>
			<div class="col-sm-3 marginleftrightzero paddingleftrightzero">
				<?php echo $this->Form->input('CustomField.field.1',array('div'=>false,'label'=>false,'type'=>'text','class'=>'form-control'))?>
			</div>
			<div class="col-sm-1  paddingtop5">
				<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype  additem-to-select addfield">
					<i class="icon-plus"></i>
				</div>
			</div>
	</div>
<?php }?>
<?php echo $this -> Js -> writeBuffer(); ?>