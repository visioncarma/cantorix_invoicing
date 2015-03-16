<?php $taxChange=$this->requestAction('taxes/taxPercentChange/'.$taxIdDetails['SbsSubscriberTax']['id']);?>
<td>
  <span class="on-load"><?php echo $taxIdDetails['SbsSubscriberTax']['name']; ?></span>
</td>

<td class="hidden-480">
  <span class="on-load"><?php echo $taxIdDetails['SbsSubscriberTax']['code']; ?></span>
</td>

<td>
  <span class="on-load taxpercentageright"><?php echo number_format((float)$taxIdDetails['SbsSubscriberTax']['percent'], 2, '.', ''); ?>%</span>
</td>	
													
<td>
	<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
		
         <?php if($permission['_read'] == 1){ ?>
              <div class="btn btn-xs btn-success view buttonadjust on-load" title="view" data-toggle="modal" data-target="#viewuser<?php echo $i; ?>">
					<i class="icon-zoom-in bigger-120"></i>
			</div>
         <?php } ?>
          <?php if($permission['_update'] == 1){ ?>
			
			<div class="btn btn-xs btn-info edit buttonadjust on-load" title="view" data-toggle="modal" data-target="#edituser<?php echo $i; ?>">
					<i class="icon-edit bigger-120"></i>
			</div>
          <?php } ?>
         <?php if($permission['_update'] == 1){ 
				if($taxChange) echo $this->Js->link('<button class="btn btn-xs btn-danger delete on-load" title="Delete"><i class="icon-trash bigger-120"></i></button>',
				array('action' => 'delete',$id), array('confirm'=>'Are you sure you want to delete the tax ?','escape'=>FALSE,'update'=>'#tr-'.$id)); 
		  } ?>
	</div>
	
	<div class="visible-sm visible-xs btn-group">
			<div class="inline position-relative">
			<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
			<i class="icon-cog icon-only bigger-110"></i>
			</button>

		<ul class="dropdown-menu dropdown-only-icon pull-right dropdown-caret dropdown-close">
			<li>
			 <?php if($permission['_read'] == 1){ ?>
             <a class="btn btn-xs btn-success view on-load adjustanchor" title="View" data-toggle="modal" data-target="#viewuser<?php echo $i; ?>" href="javascript:void(0);"> 
                <i class="icon-zoom-in bigger-120"></i>
			 </a>
            <?php } ?>
			</li>
			<li> 
			
			<?php if($permission['_update'] == 1){ ?>	
             <a class="btn btn-xs btn-info edit on-load adjustanchor" title="Edit" data-toggle="modal" data-target="#edituser<?php echo $i; ?>" href="javascript:void(0);"> 
               <i class="icon-edit bigger-120"></i>
			 </a>
            <?php } ?>
			</li>
			
			<li class="adjust-button">
				<?php if($permission['_delete'] == 1){ 
			        if($taxChange) echo $this->Js->link('<button class="btn btn-xs btn-danger delete on-load" title="Delete"><i class="icon-trash bigger-120"></i></button>',
					array('action' => 'delete',$id), array('confirm'=>'Are you sure you want to delete the tax ?','escape'=>FALSE,'update'=>'#tr-'.$value['SbsSubscriberTax']['id'])); 
					
			  
			  } ?>
			</li>
			
            </ul>
           
             </div>
	</div>
	
	<!--Popup veiw  -->     
	<div class="modal fade" id="viewuser<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		     <div class="modal-dialog">
		          <div class="modal-content">
		               <div class="modal-header page-header">       
		                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
		                    <h1 class="modal-title" id="myModalLabel">View Tax</h1>    
		               </div>
					   <div class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
						    <div class="modal-body">
						          <div class="model-body-inner-content">  
							           <div class="form-group login-form-group">
									         <label class="col-sm-4 no-padding-top">Tax Name </label>    
									         <div class="col-sm-8">
											    <p class="bold"><?php echo $taxIdDetails['SbsSubscriberTax']['name']; ?></p>
											 </div>
									   </div>
									   <div class="form-group login-form-group"> 
											<label class="col-sm-4 no-padding-top"> Tax Code </label>   
											<div class="col-sm-8">
											  <p class="bold"><?php echo $taxIdDetails['SbsSubscriberTax']['code']; ?></p>
											</div>
									  </div> 
									  <div class="form-group login-form-group"> 
											<label class="col-sm-4 no-padding-top"> Percentage</label>   
											<div class="col-sm-8">
											  <p class="bold"><?php echo number_format((float)$taxIdDetails['SbsSubscriberTax']['percent'], 2, '.', ''); ?>%</p>
											</div>
									  </div>                    
								  </div>
						     </div>
						  <div class="modal-footer"></div>           
						</div>
		         </div>
		     </div>
		</div>
		
	<!--end of pop-->  
								
   <!--Popup Edit  -->
   <?php echo $this->Form->create('SbsSubscriberTax',array('id'=>'SbsSubscriberTaxes'.$i));?>
	<div class="modal fade" id="edituser<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		 <div class="modal-dialog">
		       <div class="modal-content">
	               <div class="modal-header page-header">       
	                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
	                    <h1 class="modal-title" id="myModalLabel">Edit Tax</h1>    
	               </div>
					  
				   <div class="form-horizontal popup">
						 <div class="modal-body margintop38">
                                  <div class="model-body-inner-content"> 
									
					                <div class="form-group">
			                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Tax Name </label>
			                           
			                            <div class="col-sm-8">
			                            	
			                                <?php echo $this->Form->input('tax_name.'.$id,array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-10 col-sm-5 form-control','value'=>$taxIdDetails['SbsSubscriberTax']['name']));?>  
			                            </div>
			                        </div>	
			                        <div class="form-group">
			                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Tax Code </label>
			
			                            <div class="col-sm-8">
			                            	
			                                <?php echo $this->Form->input('tax_code.'.$id,array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-10 col-sm-5 form-control','value'=>$taxIdDetails['SbsSubscriberTax']['code']));?>  
			                            </div>
			                        </div>
			                        <div class="form-group">
			                            <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> Percent </label>
			
			                            <div class="col-sm-8">
			                             
			                              <?php if($taxChange){
			                              	        echo $this->Form->input('tax_percent.'.$id,array('div'=>FALSE,'label'=>FALSE,'class'=>'input-mini col-xs-10 col-sm-5 form-control','value'=>$taxIdDetails['SbsSubscriberTax']['percent'],'onkeypress' => "return isNumberKey(event)"));
										        }else{
										  	        echo $this->Form->input('tax_percent.'.$id,array('div'=>FALSE,'label'=>FALSE,'readonly'=>true,'class'=>'form-control input-mini col-xs-10 col-sm-5','value'=>$taxIdDetails['SbsSubscriberTax']['percent']));
										        } ?>
			                             
			                            </div>
			                        </div>
			                        
					               <div class="modal-footer">
			                                 <div class="row">
						                            <div class="col-sm-12 col-xs-12">
						                                <div class="right-inner-addon right-inner-addonnew">
						                                <div class="btn popup-cancel pull-right marginleft2" type="button">
											                Cancel
											             </div>	
						                                 <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info pull-right close-pop','url' => array('controller'=>'taxes','action'=>'edit',$id),'escape'=>false,'update' => '#tr-'.$id, 'title' => 'Save', 'id' => 'submit-'.$id));?>
						                                </div>
						                            </div>
			                                  </div> 
				                 </div>
					           </div>
					      </div>
			         </div>
		        </div> 
		     </div>
		</div>
		
		<!--end of pop-->  
</td>

<script type="text/javascript">
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        {
            if(charCode !='46'){
            	alert("Please enter only numbers.");
                return false;
            }
         }
         return true;
}
$(document).ready(function(){
	$('.close-pop , .popup-cancel').click(function(){
		$('.close').trigger('click');
	});	
})
</script>
	

<?php echo $this->Js->writeBuffer(); ?> 