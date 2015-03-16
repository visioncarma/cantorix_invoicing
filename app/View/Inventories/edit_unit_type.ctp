 <?php $checkUnitType=$this->requestAction('inventories/checkUnitType/'.$id);?>
<td>
	<label>
	    <?php if(!$checkUnitType) echo $this->Form->checkbox('Delete.'.$id,array('class'=>'ace',' type'=>'checkbox'));?>                 
	    <span class="lbl"></span> </label>
	</span>
</td>
<td>
	<span>
		<?php echo $unitTypeDetail['InvInventoryUnitType']['type_name']; ?>
	</span>
</td>	
<td>
	    <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
	        <?php if($permission['_update'] == 1){ ?>
	        <a href="javascript:void(0);"> 
	        <button class="btn btn-xs btn-info view" title="Edit" data-toggle="modal" data-target="#editterm<?php echo $i; ?>">
				<i class="icon-edit bigger-120"></i>
			</button>
			</a>
			<?php } ?>
			<?php if($permission['_delete'] == 1){ ?>
			<?php if(!$checkUnitType) echo $this->Js->link('<button class="btn btn-xs btn-danger view" title="Delete"><i class="icon-trash bigger-120"></i></button>',
				       array('action' => 'delete_unit_type',$id), array('confirm'=>'Are you sure you want to delete the unit type?','escape'=>FALSE,'update'=>'#tr-'.$id)); 
								
			 ?>
			<?php } ?>			
					
	    </div>
		
		<div class="visible-xs visible-sm hidden-md hidden-lg">
		        <div class="inline position-relative">
		            <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
		                <i class="icon-cog icon-only bigger-110"></i>
		            </button>
		
		            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
		                <li>
		                <?php if($permission['_update'] == 1){ ?>	
		                   <a class="tooltip-success" title="Edit" data-toggle="modal" data-target="#editterm<?php echo $i; ?>" href="javascript:void(0);"> 
		                       <span class="green">
		                          <i class="icon-edit bigger-120"></i>
		                       </span>
							</a>
							<?php } ?>
		                </li>
		
		                <li>
		                    <?php if($permission['_delete'] == 1){ ?>
		                    <?php if(!$checkUnitType) echo $this->Js->link('<button class="btn btn-xs btn-danger view" title="Delete"><i class="icon-trash bigger-120"></i></button>',
								       array('action' => 'delete_unit_type',$id), array('confirm'=>'Are you sure you want to delete the unit type ?','escape'=>FALSE,'update'=>'#tr-'.$id)); 
												
							?>
							<?php } ?>
		                </li>
		            </ul>
		        </div>
		    </div>
		    
		    <div class="modal fade" id="editterm<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	
				<div class="modal-dialog specialwidth">
				    <div class="modal-content">
				      <div class="modal-header page-header">       
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
				         <h1 class="modal-title" id="myModalLabel">Edit Unit Type</h1>    
				      </div>
				      <?php echo $this->Form->create('EditInvInventoryUnitType',array('id'=>'EditInvInventoryUnitType'.$i));?>  
				      <div class="form-horizontal popup" role="form" id="addnewterm" method="POST">
				      <div class="modal-body">
				         <div class="model-body-inner-content">             
				                  <div class="form-group login-form-group">
				                    <label class="col-sm-5 control-label">Unit Type Name <sup style="color:#ff0000;font-size:13px">&lowast;</sup></label>    
				                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
				                     <?php echo $this->Form->input('type_name.'.$id,array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'form-control','value'=>$unitTypeDetail['InvInventoryUnitType']['type_name']));?> 
				                     
				                    </div>
				                  </div>
				                  
				                                 
				          </div>
				      </div>
				      <div class="modal-footer special_color">
				            
				             <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-pop','url' => array('action'=>'edit_unit_type',$id,$i),'escape'=>false,'update' => '#tr-'.$id, 'title' => 'Save', 'id' => 'submit-'.$id));?>
				            &nbsp; 
				            <button class="popup-cancel btn btn-inverse" type="reset">
				                <i class="icon-remove bigger-110"></i>
				                Cancel
				            </button>
				      </div>
				      

				      </div>
				      <?php echo $this->Form->end();?> 	
				    </div>
				  </div>
           </div>
</td>

<script type="text/javascript">
//$(function(){
  //  $('input[type=checkbox]').prop("checked", false);
//});
$(document).ready(function(){
	$('.close-pop , .popup-cancel').click(function(){
		$('.close').trigger('click');
	});	
})
</script>
<?php echo $this->Js->writeBuffer();?>  