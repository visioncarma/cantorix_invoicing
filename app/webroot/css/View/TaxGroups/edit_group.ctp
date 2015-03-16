
<?php $groupMappings = $this -> requestAction('taxes/getTaxByGroupId', array('pass' => array($id)));?>
<?php $checkgroup = $this -> requestAction('tax_groups/taxGroupUsed', array('pass' => array($id))); ?>
<td>	
	<span class="">
        <label>
             <?php echo $this -> Form -> input('Delete.' . $id, array('type' => 'checkbox', 'div' => FALSE, 'label' => FALSE, 'class' => 'ace delete-m-row')); ?>
            
            <span class="lbl"></span>
        </label>
     </span>   
</td>
<td>
	<span class="on-load"><?php echo $groupName; ?></span>
</td>
<td>
<?php $t=0; foreach($groupMappings as $key2=>$value2): $t++; ?>
    <p class="mange_group_tax_p">
    <i class="icon-double-angle-right" style="color: #C86139;"></i>
	<span class="on-load"><?php echo $activeTaxes[$value2['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']]; ?>(<?php echo number_format((float)$activeTaxPercents[$value2['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']], 2, '.', ''); ?>%)</span>
    
	</p>
 <?php endforeach; ?>  	
</td>
<td>
<?php $t1=0; foreach($groupMappings as $key3=>$value3): $t1++; ?>
    <p class="mange_group_tax_p">
	<span class="on-load bold due"><?php
		if ($value3['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y') { echo "Yes";
		} else { echo "No";
		};
     ?></span>
    
	</p>
	
<?php endforeach; ?>  	
	
</td>	
                                  							
<td class="vertcal_align_middle">
									   
		<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
			
            <?php //if($permission['_read'] == 1){ ?>
            <div class="btn btn-xs btn-success view on-load btn-fixed" title="View" data-toggle="modal" data-target="#viewgruop">
				<i class="icon-zoom-in bigger-120"></i>
			</div>
            <?php //} ?>
            
            <?php //if($permission['_update'] == 1){ ?>
            
			<div class="btn btn-xs btn-info edit on-load btn-fixed" title="Edit" data-toggle="modal" data-target="#editgroup">
				<i class="icon-edit bigger-120"></i>
			</div>
			<?php //} ?>
			
			<?php //if($permission['_update'] == 1){ 
				if($checkgroup == 'No') echo $this->Js->link('<button class="btn btn-xs btn-danger delete on-load" title="Delete"><i class="icon-trash bigger-120"></i></button>',
				array('action' => 'delete_group',$id), array('confirm'=>'Are you sure you want to delete the tax group?','escape'=>FALSE,'update'=>'#tr1-'.$id)); 
			
            ?>
		</div>
		
		<div class="visible-xs visible-sm hidden-md hidden-lg">
				<div class="inline position-relative">
					<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
						<i class="icon-cog icon-only bigger-110"></i>
					</button>

					<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
						<li> 
							<div class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewgruop<?php echo $l; ?>">
								<i class="icon-zoom-in bigger-120"></i>
							</div>
				           
						</li>
						<li>
							
							<div class="btn btn-xs btn-info edit on-load" title="Edit" data-toggle="modal" data-target="#editgroup<?php echo $l; ?>">
									<i class="icon-edit bigger-120"></i>
							</div>
								
							 </li>
						<li> 
						
						
								<?php if($checkgroup == 'No') echo $this->Js->link('<button class="btn btn-xs btn-danger delete on-load" title="Delete"><i class="icon-trash bigger-120"></i></button>',
								array('action' => 'delete_group',$id), array('confirm'=>'Are you sure you want to delete the tax group?','escape'=>FALSE,'update'=>'#tr1-'.$value1['SbsSubscriberTaxGroup']['id'])); 
								?>			
						
           	
						</li>
						
					</ul>
				</div>
		</div>
										
		<div class="modal fade" id="viewgruop<?php echo $l; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			       <div class="modal-content">
		                <div class="modal-header page-header">       
		                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
		                     <h1 class="modal-title" id="myModalLabel">View Tax Group</h1>    
		                </div>
		                <div class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
		                      <div class="modal-body">
		                           <div class="model-body-inner-content ">  
			                            <div class="form-group login-form-group">
		                                     <label class="col-sm-4 no-padding-top">Group Name </label>    
												<div class="col-sm-8">
													<p class="bold"><?php echo $groupName; ?></p>
												</div>
		                                </div>
		                               <?php $v=0; foreach($groupMappings as $key4=>$value4): $v++; ?> 
		                               
		                               <div class="form-group login-form-group"> 
		                                    <label class="col-sm-4 no-padding-top">Taxes </label>   
												 <div class="col-sm-8">
													 <p class="bold"><?php echo $activeTaxes[$value4['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']]; ?>(<?php echo number_format((float)$activeTaxPercents[$value4['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']], 2, '.', ''); ?>%)</p>
												  </div>
		                               </div>
		                               <div class="form-group login-form-group"> 
		                                    <label class="col-sm-4 no-padding-top"></label>   
												<div class="col-sm-8">
												  <p>Priority <span class="bold"><?php echo $value4['SbsSubscriberTaxGroupMapping']['priority']; ?></span></p>
												</div>
		                               </div>
									   <div class="form-group login-form-group"> 
											<label class="col-sm-4 no-padding-top"></label>   
												<div class="col-sm-8">
												  <p>Compounded <span class="bold due"><?php
													if ($value4['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y') { echo "Yes";
													} else { echo "No";
													};
                                                    ?></span></p>
												</div>
									  </div>  				  
									 <?php endforeach; ?>  	
		                     </div>
		                  </div>
		              <div class="modal-footer"> </div>
		          </div>
		      </div>
		  </div>
		</div>
	 
	   <?php echo $this->Form->create('SbsSubscriberTaxGroup',array('id'=>'SbsSubscriberTaxGroups'.$l));?>  
		      <div class="modal fade" id="editgroup<?php echo $l; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			       <div class="modal-dialog modal-dialog_edittaxgroup">
					    <div class="modal-content">
					         <div class="modal-header page-header">       
						         <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
						         <h1 class="modal-title" id="myModalLabel">Edit Tax Group</h1>    
						    </div>
					        <div class="form-horizontal popup">
					            <div class="modal-body">
					                    <div class="model-body-inner-content ">  
					                        <div class="table-responsive table-responsive-custom">
									               <div class="row margin-twenty-zero">
								                        <div class="form-group margin-bottom-zero nopaddingleft nopaddingright">
								                            <label class="col-sm-2 control-label no-padding-right">Group Name</label>
								                             <?php echo $this->Form->input('group'.$id,array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'left','value'=>$groupName));?>  
								                        </div>
									                 </div>
									                  <h3 class="header smaller lighter blue bold">Taxes</h3>
									                     	<table id="sample-table-1" class="table table-striped table-bordered table-hover">
																<thead>
																	<tr>
									                                	<th class="width300">Tax Name</th>													
																		<th>Priority</th>
																		<th>Compounded</th>
																	</tr>
																</thead>                                                
																<?php $groupTaxList = $this -> requestAction('taxes/getTaxByGroupId', array('pass' => array($id))); ?>
																
																<?php $i=0; foreach($groupTaxList as $key=>$value): $i++; ?>
																	<tr>
									                                	<td>
																			<label>
																				
																				<?php //echo $this->Form->input('sbs_subscriber_tax_id.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'],array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace view','value'=>$value['SbsSubscriberTaxGroupMapping']['id']));?>    
																				<span class="lbl"></span>
																			</label>
																			<span class="taxname"><?php echo $value['SbsSubscriberTax']['name']; ?></span>
																		</td>
									                                	<td>	
									                                    	
									                                    	<?php if($checkgroup == 'No'){
									                                    		       echo $this->Form->input('priority.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'].'/'.$value['SbsSubscriberTaxGroupMapping']['id'],array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'input-mini col-xs-10 col-sm-5','value'=>$value['SbsSubscriberTaxGroupMapping']['priority']));
									                                    	      }else{
									                                    	      	   	echo $value['SbsSubscriberTaxGroupMapping']['priority'];
									                                    	      	   //echo $this->Form->input('priority.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'].'/'.$value['SbsSubscriberTaxGroupMapping']['id'],array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'input-mini col-xs-10 col-sm-5','value'=>$value['SbsSubscriberTaxGroupMapping']['priority']));
									                                    	      }
									                                    	 ?>   
									                                    </td>
																		<td>
									                                    	<span>
									                                            <label>
									                                             
									                                                <?php 
									                                                   if($checkgroup == 'No'){
									                                                   	      if($value['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
									                                                	          echo $this->Form->input('compounded.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'],array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace view','checked'=>'checked'));
										                                                      }else{
										                                                      	  echo $this->Form->input('compounded.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'],array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace view'));
										                                                      }
																					   }else{
																					   	    if($value['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
																					   	    	   echo "Yes";
									                                                	          //echo $this->Form->input('compounded.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'],array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'readonly'=>true,'class'=>'ace view','checked'=>'checked'));
										                                                     }else{
										                                                      	   echo "No";	
										                                                      	  //echo $this->Form->input('compounded.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'],array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'readonly'=>true,'class'=>'ace view'));
										                                                     }
																					   }	
									                                                ?>    
									                                                <span class="lbl"></span>
									                                            </label>
									                                         </span>
									                                    </td>
																	</tr>
											                         <?php endforeach;?>      
													
						                                          </table> 
						                              </div>
			                   		         </div>
				                      </div>
				              <div class="modal-footer"> 
  	                             <div class="row">
                    	                    <div class="col-sm-12">
				                                <div class="right-inner-addon right-inner-addonnew ">
				                                 <div class="btn popup-cancel pull-right marginleft2" type="button">
								                   Cancel
								                 </div>	
				                                 <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info pull-right close-pop','url' => array('controller'=>'tax_groups','action'=>'edit_group',$id),'escape'=>false,'update' => '#tr1-'.$id, 'id' => 'submit1-'.$id));?>
				                                </div>
				                            </div>
                                      </div> 
				              </div>
				          </div>
				      </div>
				  </div>
	    </div>
<?php echo $this->Form->end();?> 
</td>

<script type="text/javascript">

    jQuery(function($) {
	$(".chosen-select").chosen();
    $('#spinner1').ace_spinner({value:0,min:0,max:200,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
	.on('change', function(){
	});
	$(document).ready(function(){
		$('.close-pop , .popup-cancel').click(function(){
		$('.close').trigger('click');
	});		
	 $( ".edit" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	$( ".delete" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	$( ".view" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
})
		
});
</script>
<?php echo $this -> Js -> writeBuffer(); ?>


