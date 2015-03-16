<?php echo $this->Session->flash();?>
<div class="pull-right  bottommarginn newaddtax">
	<?php if($permission['_create'] == 1) echo $this->Js->link('<i class="icon-plus"></i>Add Tax Group', array('controller' => 'tax_groups', 'action' => 'add_group'), array('class'=>'btn btn-sm btn-success pull-right addbutton','escape' => FALSE, 'update' => '#tabs-1'));?>
</div>
<div class="table-header">Tax Groups</div>
<?php echo $this->Form->create('SbsSubscriberTaxGroup'); ?>  
<div class="row margin-twenty-zero">                        	
    <div class="form-group filed-left margin-bottom-zero width-100-480">
        <?php echo $this -> Form -> input('group_name', array('class'=>'tgroupname mobile_100','type' => 'text', 'label' => false, 'div' => false, 'placeholder' => 'Group Name')); ?>
    </div>
	<div id="filtergrp" class="form-group filed-left margin-bottom-zero mobile_100">
		<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn taxgrpfilter mobile_100','url' => array('controller'=>'tax_groups','action' => 'index'),'escape'=>false,'update' => '#tabs-1','before' => $this->Js->get('#loading2')->effect('fadeIn', array('buffer' => false)),
                            	    'complete' => $this->Js->get('#loading2')->effect('fadeOut', array('buffer' => false))));?>
    </div>
    <div class="form-group filed-left margin-bottom-zero mobile_100">
		<?php echo $this->Js->link('Reset',array('controller'=>'tax_groups','action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','update' => '#tabs-1','before' => $this->Js->get('#loading2')->effect('fadeIn', array('buffer' => false)),
                            	  'complete' => $this->Js->get('#loading2')->effect('fadeOut', array('buffer' => false))));?>
	</div>
	<?php echo $this->Html->image('loding.gif', array('id'=>'loading2','style'=>'display:none;float: right;margin-right: 50%;'));?>
</div>
 
<?php echo $this->Form->end(); ?>
<?php echo $this -> Form -> create('SbsSubscriberTaxGroup'); ?>  
		<table id="sample-table-1" class="updatehide table table-striped table-bordered table-hover editable-table taxtable">
		<thead>
		<tr>
			<th>Group Name</th>		
			<?php //echo $this->Paginator->options(array('update'=>'#tabs-1','url'=>array('controller'=>'tax_groups', 'action'=>'index')));?>	
			<!--<th><?php echo $this->Paginator->sort('group_name','Group Name',array('url'=>$url,'lock'=>TRUE));?></th>-->
			<th class="hidden-480">Tax</th>
			<th class="hidden-480">Compounded</th>
			<th >Action</th>
		</tr>
		</thead>
		
		<tbody>
		
		<?php $l=0; foreach($sbsSubscriberTaxGroups as $key1=>$value1):$l++; ?>	
		<?php $checkgroup = $this -> requestAction('tax_groups/taxGroupUsed', array('pass' => array($value1['SbsSubscriberTaxGroup']['id']))); ?>
		
		<?php
			if ($taxname1) {
				$groupMappings = $this -> requestAction('taxes/getTaxByGroupId', array('pass' => array($value1['SbsSubscriberTaxGroup']['id'], $taxname1)));
			} else {
				$groupMappings = $this -> requestAction('taxes/getTaxByGroupId', array('pass' => array($value1['SbsSubscriberTaxGroup']['id'])));
			}
		 ?>
		      
		<tr id ="tr1-<?php echo $value1['SbsSubscriberTaxGroup']['id']; ?>">
		 
			<td>
		    	<span class="on-load"><?php echo $value1['SbsSubscriberTaxGroup']['group_name']; ?></span>
		    </td>
			<td class="hidden-480">
			<?php $t=0; foreach($groupMappings as $key2=>$value2): $t++; ?>
			    <p class="mange_group_tax_p">
			    <i class="icon-double-angle-right" style="color: #C86139;"></i>
		    	<span class="on-load"><?php echo $activeTaxes[$value2['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']]; ?>(<?php echo number_format((float)$activeTaxPercents[$value2['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']], 2, '.', ''); ?>%)</span>
		        </p>
			 <?php endforeach; ?>  	
		    </td>
			<td class="hidden-480">
			<?php $t1=0; foreach($groupMappings as $key3=>$value3): $t1++; ?>
			    <p class="mange_group_tax_p">
		    	<span class="on-load bold due"><?php
					if ($value3['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y') { echo "Yes";
					} else { echo "No";
					};
		            ?></span>
		        <?php $compounded = array('Y' => 'Yes', 'N' => 'No');?>
				</p>
				
			<?php endforeach; ?>  	
				
		    </td>	
		
			<td class="vertcal_align_middle">
			   
				<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
					<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
		                
		                 <?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn','url' => array('controller'=>'tax_groups','action' => 'edit_group',$value1['SbsSubscriberTaxGroup']['id']),'escape'=>false,'update' => '#tr-'.$value1['SbsSubscriberTaxGroup']['id'], 'title' => 'Save', 'id' => 'submit-' . $value1['SbsSubscriberTaxGroup']['id']));?>
		                <div class="btn btn-xs close-action" title="Cancel">
		                    <i class="icon-remove bigger-120"></i>
		                </div>
		            </a>
		            <?php if($permission['_read'] == 1){ ?>
		            <div class="btn btn-xs btn-success view on-load btn-fixed" title="View" data-toggle="modal" data-target="#viewgruop<?php echo $l; ?>">
						<i class="icon-zoom-in bigger-120"></i>
					</div>
		            <?php } ?>
		            
		            <?php if($permission['_update'] == 1){ ?>
		           
					<div class="btn btn-xs btn-info edit on-load btn-fixed" title="Edit" data-toggle="modal" data-target="#editgroup<?php echo $l; ?>">
						<i class="icon-edit bigger-120"></i>
					</div>
					<?php } ?>
					
					
					  <?php if($permission['_delete'] == 1){ 
								if($checkgroup == 'No') echo $this->Js->link('<button class="btn btn-xs btn-danger delete on-load" title="Delete"><i class="icon-trash bigger-120"></i></button>',
								array('action' => 'delete_group',$value1['SbsSubscriberTaxGroup']['id']), array('confirm'=>'Are you sure you want to delete the tax group?','escape'=>FALSE,'update'=>'#flashmsg00, #tr1-'.$value1['SbsSubscriberTaxGroup']['id'])); 
											
						} ?>
		           
				</div>
				
					<div class="visible-xs visible-sm hidden-md hidden-lg">
						<div class="inline position-relative">
							<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
								<i class="icon-cog icon-only bigger-110"></i>
							</button>

							<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
								<li> 
									
									 <?php if($permission['_read'] == 1){ ?>
						            <div class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewgruop<?php echo $l; ?>">
										<i class="icon-zoom-in bigger-120"></i>
									</div>
						            <?php } ?>
								</li>
								<li>
									
									<?php if($permission['_update'] == 1){ ?>
		           
										<div class="btn btn-xs btn-info edit on-load" title="Edit" data-toggle="modal" data-target="#editgroup<?php echo $l; ?>">
											<i class="icon-edit bigger-120"></i>
										</div>
										<?php } ?>
									 </li>
								<li> 
								
								 <?php if($permission['_delete'] == 1){ 
										if($checkgroup == 'No') echo $this->Js->link('<button class="btn btn-xs btn-danger delete on-load padding13" title="Delete"><i class="icon-trash bigger-120"></i></button>',
										array('action' => 'delete_group',$value1['SbsSubscriberTaxGroup']['id']), array('confirm'=>'Are you sure you want to delete the tax group?','escape'=>FALSE,'class'=>'paddingzero','update'=>'#flashmsg00,#tr1-'.$value1['SbsSubscriberTaxGroup']['id'])); 
													
								 } ?>
		           	
								</li>
								
							</ul>
						</div>
					</div>
				
			</td>
			
		</tr>
								
								
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
												<div class="col-sm-8 nopaddingmobile">
													<p class="bold"><?php echo $value1['SbsSubscriberTaxGroup']['group_name']; ?></p>
												</div>
		                                </div>
		                               <?php $v=0; foreach($groupMappings as $key4=>$value4): $v++; ?> 
		                               <?php debug($value4);?>
		                               <div class="form-group login-form-group"> 
		                                    <label class="col-sm-4 no-padding-top">Taxes </label>   
												 <div class="col-sm-8 nopaddingmobile">
													 <p class="bold"><?php echo $activeTaxes[$value4['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']]; ?>(<?php echo number_format((float)$activeTaxPercents[$value4['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id']], 2, '.', ''); ?>%)</p>
												  </div>
		                               </div>
		                               <div class="form-group login-form-group"> 
		                                    <label class="col-sm-4 no-padding-top"></label>   
												<div class="col-sm-8 nopaddingmobile">
												  <p>Priority <span class="bold"><?php echo $value4['SbsSubscriberTaxGroupMapping']['priority']; ?></span></p>
												</div>
		                               </div>
									   <div class="form-group login-form-group"> 
											<label class="col-sm-4 no-padding-top"></label>   
												<div class="col-sm-8 nopaddingmobile">
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
		          </div>
		      </div>
		  </div>
		</div>
			
				
 <?php endforeach; ?>   
 </tbody>
    <?php $pages = $this -> Paginator -> current('SbsSubscriberTaxGroup'); ?>
   </table>
<?php echo $this -> Form -> end(); ?>
        <?php if($sbsSubscriberTaxGroups) { ?>       
          
       <div class="row clear col-xs-12 paginationmaindiv extrapaddinglefttaxonly">
		<div class="col-sm-6">
			<div id="sample-table-2_info" class="dataTables_info">
				<?php echo $this -> Paginator -> counter(array('format' => __('Showing {:start} to {:end} of {:count} entries'), 'model' => 'SbsSubscriberTaxGroup')); ?>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="dataTables_paginate paging_bootstrap">
				<ul class="pagination gp">
					<?php
					$url = array('controller' => 'tax_groups', 'action' => 'index',$taxGroupName);
					$this -> Paginator -> options(array('update' => '#tabs-1', 'evalScripts' => true, 'url' => $url));
					echo $this -> Paginator -> prev('<i class="icon-double-angle-left"></i>', array('escape' => false, 'tag' => 'li', 'model' => 'SbsSubscriberTaxGroup'), '<a href="#"><i class="icon-double-angle-left"></i></a>', array('escape' => false, 'tag' => 'li'));
					echo $this -> Paginator -> numbers(array('separator' => '', 'tag' => 'li', 'currentClass' => 'active', 'currentTag' => 'a', 'model' => 'SbsSubscriberTaxGroup'));
					echo $this -> Paginator -> next('<i class="icon-double-angle-right"></i>', array('escape' => false, 'tag' => 'li', 'model' => 'SbsSubscriberTaxGroup'), '<a href="#"><i class="icon-double-angle-right"></i></a>', array('escape' => false, 'tag' => 'li'));
					?>
				</ul>
			</div>
		</div>
	</div>
	<?php } ?>
	

<?php $l=0; foreach($sbsSubscriberTaxGroups as $key1=>$value1):$l++; ?>					
   <?php $checkgroup = $this -> requestAction('tax_groups/taxGroupUsed', array('pass' => array($value1['SbsSubscriberTaxGroup']['id'])));   ?>  
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
			                   <div class="table-responsive table-responsive-custom table_fixed_new">
			                     <div class="row margin-twenty-zero">
			                        <div class="form-group margin-bottom-zero nopaddingleft nopaddingright">
			                            <label class="col-sm-2 control-label no-padding-right">Group Name</label>
			                             <?php echo $this->Form->input('group'.$value1['SbsSubscriberTaxGroup']['id'],array('id'=>'group_name'.$value1['SbsSubscriberTaxGroup']['id'],'type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'left mobile_100','value'=>$groupList[$value1['SbsSubscriberTaxGroup']['id']]));?>  
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
										<?php $groupTaxList = $this->requestAction('taxes/getTaxByGroupId', array('pass' => array($value1['SbsSubscriberTaxGroup']['id']))); ?>
										<?php $checkgroupTaxList = $this->requestAction('taxes/getTaxByGroupIdForCheck', array('pass' => array($value1['SbsSubscriberTaxGroup']['id']))); ?>
										
										
										<?php $i=0; foreach($groupTaxList as $key=>$value): $i++;  ?>
											<tr>
			                                	<td>
													<label>
														<span class="lbl"></span>
													</label>
													<span class="taxname"><?php echo $value['SbsSubscriberTax']['name']; ?></span>
												</td>
			                                	<td>	
			                                    	
			                                    	<?php if($checkgroup == 'No'){
			                                    		       echo $this->Form->input('priority.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'].'/'.$value['SbsSubscriberTaxGroupMapping']['id'],array('type'=>'text','id'=>'priority'.$i.$l,'div'=>FALSE,'label'=>FALSE,'class'=>'input-mini col-xs-10 col-sm-5 for_prio','value'=>$value['SbsSubscriberTaxGroupMapping']['priority'],'onkeypress' => "return isNumber(event)"));
			                                    	      }else{
			                                    	      	   	echo $value['SbsSubscriberTaxGroupMapping']['priority'];
			                                    	      }
			                                    	 ?>   
			                                    </td>
												<td>
			                                    	<span>
			                                            <label>
			                                             
			                                                <?php 
			                                                   if($checkgroup == 'No'){
			                                                   	      if($value['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
			                                                	          echo $this->Form->input('compounded.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'],array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'validinput ace view all','checked'=>'checked'));
				                                                      }else{
				                                                      	  if($checkgroupTaxList){
				                                                      	  	  echo $this->Form->input('compounded.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'],array('type'=>'checkbox','div'=>FALSE,'disabled'=>'disabled','label'=>FALSE,'class'=>'validinput ace view all'));
				                                                      	  }else{
				                                                      	  	   echo $this->Form->input('compounded.'.$value['SbsSubscriberTaxGroupMapping']['sbs_subscriber_tax_id'],array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'validinput ace view all'));
				                                                      	  } 
				                                                      	 
				                                                      }
															   }else{
															   	    if($value['SbsSubscriberTaxGroupMapping']['compounded'] == 'Y'){
															   	    	   echo "Yes";
			                                                	          }else{
				                                                      	   echo "No";	
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
                            <div class="col-sm-12 col-xs-12">
                                <div class="right-inner-addon right-inner-addonnew">
                                <div class="btn popup-cancel pull-right marginleft2" type="button">
					                Cancel
					             </div>	
                                 <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info pull-right close-pop','url' => array('controller'=>'tax_groups','action'=>'edit_group',$value1['SbsSubscriberTaxGroup']['id']),'escape'=>false,'update' => '#tr1-'.$value1['SbsSubscriberTaxGroup']['id'],'id' => 'submit1-'.$value1['SbsSubscriberTaxGroup']['id']));?>
                                </div>
                            </div>
                          </div> 
                          
	              </div>
	          </div>
	      </div>
	  </div>
	</div>
 <?php echo $this->Form->end();?> 
<?php endforeach; ?>   
 	
<style>
	
	.emptysearch{
		color: #DF4040;
	 }
</style>
<script>
	$(document).ready(function(){
		
        $('.modal').on('shown.bs.modal', function(){
            //$(this).removeData('bs.modal');
            //alert();
        });
    
    
    $("#sample-table-1 input.validinput").change(function(){
		if($(this).is(':checked')) {
			var currentvalue = parseInt($(this).parents('tr').find('input[type="text"]').val());
			var get_count = $('#sample-table-1 input[type="text"]').length;
			for (var i = 1; i <= get_count; i++) {
				var fieldvalue = parseInt($('#priority'+i+'1').val());
				if(currentvalue < fieldvalue) {
					$('#priority'+i+'1').addClass('redborder');
				}
				
			}
		}else {
			var get_count = $('#sample-table-1 input[type="text"]').length;
			for (var i = 1; i <= get_count; i++) {
				$('#priority'+i+'1').removeClass('redborder');
			}
		}
	});	
	
	$("#sample-table-1 .input-mini").change(function(){		
			if ($('input.validinput').is(':checked')) {
			var currentvalue = parseInt($(this).parents('tr').find('input[type="text"]').val());
			var get_count = $('#sample-table-1 input[type="text"]').length;
			
			for (var i = 1; i <= get_count; i++) {
				var fieldvalue = parseInt($('#priority'+i+'1').val());
				if(currentvalue < fieldvalue) {
					$('#priority'+i+'1').addClass('redborder');
				}else {
					$('#priority'+i+'1').removeClass('redborder');
				}
				
			}
		}else {
			var get_count = $('#sample-table-1 input[type="text"]').length;
			for (var i = 1; i <= get_count; i++) {
			}
		}
			
	});	
    
    
		$(".close-pop").click(function(evt){
			var hasclasstrue = $("#sample-table-1 input[type='text']").hasClass("redborder");
			if(hasclasstrue == true) {
				alert('Compound tax must always be the highest priority.');
				evt.preventDefault();
				$('#field').value();
			}
		});
		
		
		
	});
</script>
<script type="text/javascript">
var tt_pls=null;	
$(document).ready(function(){
	   
$('.for_prio').click(function() {
    tt_pls=$('#'+this.id).val();
    
});
});	

function isNumber(evt) {

  var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        {
            alert("Please enter only numbers.");
            return false;
         }
         return true;
  
}

$(document).ready(function(){
	   
$('.all').click(function() {
    $('.all').not(this).attr('disabled', $(this).is(':checked'));
});
});	
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
	
	
	
});
		
});
</script>
<?php echo $this->Js->writeBuffer(); ?>  
