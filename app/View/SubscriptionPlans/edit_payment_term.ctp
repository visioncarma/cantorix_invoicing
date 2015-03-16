<?php $checkPayment=$this->requestAction('subscription_plans/checkPaymentTerm/'.$id);?> 

 <td>
	<label>
	  <?php if($checkPayment =='notexist') echo $this->Form->checkbox('Delete.'.$id,array('class'=>'ace',' type'=>'checkbox'));?>                 
	  <span class="lbl"></span> </label>
	</span>
</td>
<td>
	<span>
		<?php echo $payment_term_info['SbsSubscriberPaymentTerm']['term']; ?>
	</span>
</td>	
	<td class="hidden-480">
		 <span class="right-aligned-amt">
		 	<?php echo $payment_term_info['SbsSubscriberPaymentTerm']['no_of_days']; ?>
		 </span>
	</td>    
	<td class="hidden-480">
		  <span class="right-aligned-amt">
		      <?php if($payment_term_info['SbsSubscriberPaymentTerm']['is_default'] =='Y'){
		      	      echo "Yes";
		            }else{
		              echo "No";
		            }
		       ?>
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
			<?php if($checkPayment =='notexist') echo $this->Js->link('<button class="btn btn-xs btn-danger view" title="Delete"><i class="icon-trash bigger-120"></i></button>',
				       array('action' => 'delete_payment_term',$id), array('confirm'=>'Are you sure you want to delete the payment term ?','escape'=>FALSE,'update'=>'#tr-'.$id)); 
								
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
		                    <?php if($checkPayment =='notexist') echo $this->Js->link('<button class="btn btn-xs btn-danger view" title="Delete"><i class="icon-trash bigger-120"></i></button>',
								       array('action' => 'delete_payment_term',$id), array('confirm'=>'Are you sure you want to delete the payment term ?','escape'=>FALSE,'update'=>'#tr-'.$id)); 
												
							?>
							<?php } ?>
		                </li>
		            </ul>
		        </div>
		    </div>
		    
		    <div class="modal fade" id="editterm<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<script>
		$(document).ready(function() {
			$('#editterm<?php echo $i; ?>').on('show.bs.modal', function (e) {
			  		$('.popup-error1, .popup-error2').hide();
				});
				$( ".epaymenttern-<?php echo $i; ?>, .enoofdays-<?php echo $i; ?>" ).focus(function() {
					$('.popup-error1, .popup-error2').hide();
				});
				
				$('.close-pop2').click(function(evt) {
			    	 value18 = $(".epaymenttern-<?php echo $i; ?>").val();
			    	 
			    	 if(value18.length === 0) {
			    	 	$('.popup-error1').show();
			    	 	evt.preventDefault();
				        $('#field').value();
			    	 }							
				   
				     var value9 = $.trim($(".enoofdays-<?php echo $i; ?>").val());
			    	 if(value9.length === 0) {
			    	 	$('.popup-error2').show();
			    	 	evt.preventDefault();
				        $('#field').value();
			    	 }
			    	 
			     	$('#editterm<?php echo $i; ?>').modal('hide');
			    });
				});				
			</script>
				  <div class="modal-dialog specialwidth">
				    <div class="modal-content">
				      <div class="modal-header page-header">       
				        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
				         <h1 class="modal-title" id="myModalLabel">Edit Payment Term</h1>    
				      </div>
				      <?php echo $this->Form->create('EditSbsSubscriberPaymentTerm',array('id'=>'EditSbsSubscriberPaymentTerm'.$i));?>  
				      <div class="form-horizontal popup" role="form" id="addnewterm" method="POST">
				      <div class="modal-body">
				         <div class="model-body-inner-content">             
				                  <div class="form-group login-form-group">
				                    <label class="col-sm-5 control-label">Payment Term Name <sup style="color:#ff0000;font-size:13px">&lowast;</sup></label>    
				                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
				                     <?php echo $this->Form->input('term.'.$id,array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'form-control epaymenttern-'.$i.'','value'=>$payment_term_info['SbsSubscriberPaymentTerm']['term']));?> 
				                     <p class="popup-error1">Please enter payment term.</p>
				                    </div>
				                  </div>
				                  <div class="form-group login-form-group"> 
				                    <label class="col-sm-5 control-label">No of Days<sup style="color:#ff0000;font-size:13px">&lowast;</sup> </label>   
				                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
				                      <?php if($checkPayment =='notexist') {
				                      	    	  echo $this->Form->input('no_of_days.'.$id,array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'form-control noofdays','value'=>$payment_term_info['SbsSubscriberPaymentTerm']['no_of_days']));
				                      	    }else{
				                      	    	 echo $this->Form->input('no_of_days.'.$id,array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'form-control noofdays','value'=>$payment_term_info['SbsSubscriberPaymentTerm']['no_of_days'],'readonly'=>'readonly'));
				                      	    }
				                      	?> 
				                    </div>
				                  </div>  
				                  <div class="form-group login-form-group"> 
				                    <label class="col-sm-5 control-label">Default<sup style="color:#ff0000;font-size:13px">&lowast;</sup> </label>   
				                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
				                       <?php if($payment_term_info['SbsSubscriberPaymentTerm']['is_default'] == 'Y'){ 
				                       	          echo $this->Form->checkbox('is_default.'.$id,array('type'=>'checkbox','checked'=>'checked'));
				                            }else{
				                            	  echo $this->Form->checkbox('is_default.'.$id,array('type'=>'checkbox','checked'=>false));
				                            }
				                            ?>                      
				                    </div>
				                  </div>                   
				          </div>
				      </div>
				      <div class="modal-footer special_color">
				            
				             <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-pop2','url' => array('action'=>'edit_payment_term',$id,$i),'escape'=>false,'update' => '#tr-'.$id, 'title' => 'Save', 'id' => 'submit-'.$id));?>
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