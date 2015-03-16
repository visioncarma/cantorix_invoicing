<?php echo $this->Session->flash();
      $homeLink = $this->Breadcrumb->getLink('Home');
	  $settings = $this->Breadcrumb->getLink('Settings');
?>	
<?php if(!$typename) $typename=0; ?>

<?php $url = array('action'=>'inventory_unit_type',$typename);?> 

<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript" src="">
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
		
		<li class="active">
			<?php echo __('Manage Unit Types');?>
		</li>
	</ul>
</div>

<div class="page-content">
      <div class="page-header">
        <h1 class=" width-auto font-size-h1-480">Manage Unit Types</h1>
        <?php if($permission['_create'] == '1') { ?>
		        <div class=" width-auto pull-right"> 
		        	 <a class="btn btn-sm btn-success pull-right addbutton add-button-480" data-target="#addnewtype" data-toggle="modal"> <i class="icon-plus"></i> Add Unit Type</a>
		        </div>
        <?php } ?>
       </div>
         
		<!--add new type---->
		<div class="modal fade" id="addnewtype" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog specialwidth">
		    <div class="modal-content">
		      <div class="modal-header page-header">       
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
		         <h1 class="modal-title" id="myModalLabel">Add New Unit Type</h1>    
		      </div>
		      
		      <?php echo $this->Form->create('AddInvInventoryUnitType',array('url'=>array('controller'=>'inventories','action'=>'add_unit_type')));?>  
		      <div class="form-horizontal popup" role="form" id="addnewtype" method="POST">
		      <div class="modal-body">
		         <div class="model-body-inner-content">             
		                  <div class="form-group login-form-group">
		                    <label class="col-sm-5 control-label">Unit Type Name<sup style="color:#ff0000;font-size:13px">&lowast;</sup></label>    
		                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
		                       <?php echo $this->Form->input('type_name',array('type'=>'text','autocomplete'=>'off','div'=>FALSE,'label'=>FALSE,'class'=>'form-control'));?>
		                    </div>
		                  </div>
		           </div>
		      </div>
		      <div class="modal-footer special_color">
		            <?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('class'=>'btn btn-info ','escape'=>false));?>
					&nbsp; 
		            <button class="btn btn-inverse" type="reset">
		                <i class="icon-undo bigger-110"></i>
		                Reset
		            </button>
		      </div>
		      		      
		      </div>
		      <?php echo $this->Form->end();?> 	
		    </div>
		  </div>
		</div>
		<!--add type---->
		
	<?php echo $this->Form->create('InvInventoryUnitType');?>   
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="table-responsive tableexpense">
            <div class="table-header">Unit Types List</div>
             <div class="row margin-twenty-zero expensemargin">
              <div class="col-lg-2 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-100-480 margin-top-15-480">
                 <?php echo $this->Form->input('unit_type_name',array('class'=>'tName','type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Unit Type Name')); ?>
              </div>
              <div class="form-group filed-left margin-bottom-zero margin-top-15-1300 clear-620">
                <?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn taxfilter','url' => array('controller'=>'inventories','action' => 'inventory_unit_type'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading2')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading2')->effect('fadeOut', array('buffer' => false))));?>
              </div>
              <div class="form-group filed-left margin-bottom-zero">
					<?php echo $this->Js->link('Reset',array('controller'=>'inventories','action'=>'inventory_unit_type'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new','update' => '#pageContent','before' => $this->Js->get('#loading2')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading2')->effect('fadeOut', array('buffer' => false))));?>
				</div> 
              <?php echo $this->Html->image('loding.gif', array('id'=>'loading2','style'=>'display:none;float: right;margin-right: 50%;'));?>
            </div>
           </div>
         </div>
       </div>
        <?php echo $this->Form->end();?> 	
		
        
       <?php echo $this->Form->create('InvInventoryUnitType',array('url' =>'/inventories/delete_selected_unit_type'));?>    
       <div class="row">
            <div class="col-xs-12">
              <div class="table-responsive overflow-visible">
             
               
                <div class="row magin-delete-all hidden-480">
                 <?php 
                 	if($permission['_delete'] == '1') {
						echo $this->Form->submit('delete_selected.png',array('class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected','onclick'=>"return confirm('Are you sure you want to delete selected unit types?')"));
					}
				?>
                </div>
                <table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
                  <thead>
                    <tr>
                      <th class="width-30-new"> 
                      	  <?php if($permission['_delete'] == '1') { ?>	
                           <label>
                              <input class="ace" type="checkbox">
                              <span class="lbl"></span>
                           </label>
                           <?php } ?>
                      </th>
                      <th class="width45p"><?php echo $this->Paginator->sort('type_name','Unit Type Name',array('url'=>$url,'lock'=>TRUE));?></th>
                      <th class="width9p">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  	
                  <?php $i=0; foreach($invInventoryUnitTypes as $key=>$value): $i++; ?>
                  <?php $checkUnitType=$this->requestAction('inventories/checkUnitType/'.$value['InvInventoryUnitType']['id']);?>
                  	
                  	<tr id = "tr-<?php echo $value['InvInventoryUnitType']['id']?>">
                      <td>
                        <label>
                         
                          <?php if(!$checkUnitType) echo $this->Form->checkbox('Delete.'.$value['InvInventoryUnitType']['id'],array('class'=>'ace',' type'=>'checkbox'));?>                 
                          <span class="lbl"></span> </label>
                        </span></td>
                        
                       
                      
                      <td><span><?php echo $value['InvInventoryUnitType']['type_name']; ?></span>
                      
                     
                        <td>
                            <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                <?php if($permission['_update'] == 1){ ?>
                               
								<button id="E<?php echo $value['InvInventoryUnitType']['id'];?>" class="btn btn-xs btn-info edit on-load" title="Edit" data-toggle="modal" data-target="#editterm<?php echo $i; ?>">
									<i class="icon-edit bigger-120"></i>
								</button>
								<?php } ?>
								 <?php if($permission['_delete'] == 1){ ?>
								 <?php if(!$checkUnitType) echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('action' => 'delete_unit_type', $value['InvInventoryUnitType']['id'],$typename,$this->Paginator->current()), array('class'=>'btn btn-xs btn-danger view','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete Unit Type ?')); ?>
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
                                            <button id="E<?php echo $value['InvInventoryUnitType']['id'];?>" class="btn btn-xs btn-info edit on-load" title="Edit" data-toggle="modal" data-target="#editterm<?php echo $i; ?>">
												<i class="icon-edit bigger-120"></i>
											</button>
											<?php } ?>
                                        </li>
    
                                        <li class="adjust-button">
                                            <?php if($permission['_delete'] == 1){ ?>
                                                <?php if(!$checkUnitType) echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('action' => 'delete_unit_type', $value['InvInventoryUnitType']['id'],$typename,$this->Paginator->current()), array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete Unit Type ?')); ?>
								          <?php } ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                   <?php endforeach;?>   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <?php echo $this->Form->end();?> 	
       
       <div class="row clear col-xs-12 paginationmaindiv">
			<div class="col-sm-6">
				<div id="sample-table-2_info" class="dataTables_info">
					<?php echo $this->Paginator->counter(array('format' => __('Showing {:start} to {:end} of {:count} entries')));?>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="dataTables_paginate paging_bootstrap">
					<ul class="pagination">
						<?php
							$url = array('controller'=>'inventories','action'=>'inventory_unit_type',$page,$typename);
							$this->Paginator->options(array(
			 					'update' => '#pageContent',
								'evalScripts' => true,
								'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),
    							'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false)),
								'url' => $url
							)); 
							echo $this->Paginator->first('<i class="icon-double-angle-left"></i>', array('escape'=>false,'tag' => 'li','title'=>'First'), array('escape'=>false,'tag'=>'li','title'=>'First')); 
								echo $this->Paginator->prev('<i class="icon-angle-left"></i>', array('escape'=>false,'tag' => 'li','title'=>'Previous'), '',array('escape'=>false,'tag'=>'li','style'=>'display:none;'));
								echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentClass'=>'active','currentTag'=>'a'));
								echo $this->Paginator->next('<i class="icon-angle-right"></i>', array('escape'=>false,'tag' => 'li','title'=>'Next'),'<a href="#"><i class="icon-double-angle-right"></i></a>', array('escape'=>false,'tag'=>'li','style'=>'display:none;'));
								echo $this->Paginator->last('<i class="icon-double-angle-right"></i>', array('escape'=>false,'tag' => 'li','title'=>'Last'), array('escape'=>false,'tag'=>'li','title'=>'Last'));
								echo $this->Html->image('loding.gif', array('id'=>'loading','style'=>'display:none;float: right;margin-right: -18px;padding-top: 4px;'));
						?>
					</ul>
				</div>
			</div>
		</div> 
</div>
 

        
<?php $i=0; foreach($invInventoryUnitTypes as $key=>$value): $i++; ?>
<div class="modal fade" id="editterm<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog specialwidth">
    <div class="modal-content">
      <div class="modal-header page-header">       
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
         <h1 class="modal-title" id="myModalLabel">Edit Unit Type</h1>    
      </div>
      <?php echo $this->Form->create('EditSInvInventoryUnitType',array('url' =>'/inventories/edit_unit_type/'.$value['InvInventoryUnitType']['id'].'/'.$typename.'/'.$this->Paginator->current()));?>   
      
      <div class="form-horizontal popup" role="form" id="addnewterm" method="POST">
      <div class="modal-body">
         <div class="model-body-inner-content">             
                  <div class="form-group login-form-group">
                    <label class="col-sm-5 control-label">Unit Type Name<sup style="color:#ff0000;font-size:13px">&lowast;</sup></label>    
                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
                     <?php echo $this->Form->input('type_name.'.$value['InvInventoryUnitType']['id'],array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'form-control','value'=>$value['InvInventoryUnitType']['type_name']));?>
                     
                    </div>
                  </div>
          </div>
      </div>
      <div class="modal-footer special_color">
            <?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('class'=>'btn btn-info','type'=>'submit'));?>       
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
 <?php endforeach;?>   



<script type="text/javascript">
$(document).ready(function(){
		 
	    var flag=0;
	    var count=0;
	 	$('th .ace').change(function(){
	 		if(count!=0)
	 		   count=0;
	 		if(flag==0){
	 		    $('.magin-delete-all .deleteicon').fadeIn('slow');
	 		    flag=1;
	 		}
	 		else{
	 			 $('.magin-delete-all .deleteicon').fadeOut('slow');
	 			 flag=0;
	 		}
	 	});
	 	$('td .ace').change(function(){
	 		if(flag==0){
	 		  var x=$(this).prop("checked");
	 		  if(x==true){		 		
	 		  	count+=1;
	 		  }
	 		  else{	 		  	
	 		  	count-=1;
	 		  }
	 		  
	 		 
	 		  if(count>0 )
	 		    $('.magin-delete-all .deleteicon').fadeIn('slow');
	 		  else if(count<=0&&flag==0){ 	 		  	
	 			 $('.magin-delete-all .deleteicon').fadeOut('slow');	 			
	 		  }
	 		 }
	 	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){

	$('.close-pop , .popup-cancel').click(function(){
		$('.close').trigger('click');
	});	
	
	
	$("#AddInvInventoryUnitTypeInventoryUnitTypeForm").validate({
		 rules: {
            "data[AddInvInventoryUnitType][type_name]":{
				required : true
			},
           
		 },
		  messages:{
			 "data[AddInvInventoryUnitType][type_name]":{
				required: "Please enter unit type name"				
		 	 },
			 
		  }
	});	
});
</script>

<?php echo $this->Js->writeBuffer();?>  
