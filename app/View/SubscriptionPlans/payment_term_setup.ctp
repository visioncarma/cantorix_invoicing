<?php echo $this->Session->flash();
      $homeLink = $this->Breadcrumb->getLink('Home');
	  $settings = $this->Breadcrumb->getLink('Settings');
?>	

<?php $url = array('action'=>'payment_term_setup');?> 
	
     
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
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		
		<li class="active">
			<?php echo __('Payment Terms Setup');?>
		</li>
	</ul>
</div>
<div class="page-content">
      <div class="page-header">
        <div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600"> Payment Terms List  </div>
        <?php if($permission['_create'] == '1') { ?>
        <div class=" col-lg-8 col-md-7 col-sm-8 col-xs-8 no-padding-left no-padding-right width-after-600"> 
        	 <a class="btn btn-sm btn-success pull-right addbutton width-after-400 " data-target="#addnewterm" data-toggle="modal"> <i class="icon-plus"></i> Add New Term </a>
        </div>
        <?php } ?>
       </div>
         
		<!--add new Term---->
		<div class="modal fade" id="addnewterm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog specialwidth">
		    <div class="modal-content">
		       
		      <div class="modal-header page-header">       
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
		         <h1 class="modal-title" id="myModalLabel">Add New Payment Term</h1>    
		      </div>
		      
		      <?php //echo $this->Form->create('AddSbsSubscriberPaymentTerm');?>  
		      
		      <?php echo $this->Form->create('AddSbsSubscriberPaymentTerm',array('url'=>array('controller'=>'subscription_plans','action'=>'add_payment_term')));?>  
		      <div class="form-horizontal popup" role="form" id="addnewterm" method="POST">
		      <div class="modal-body">
		         <div class="model-body-inner-content">             
		                  <div class="form-group login-form-group">
		                    <label class="col-sm-5 control-label">Payment Term Name<sup style="color:#ff0000;font-size:13px">&lowast;</sup></label>    
		                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
		                      
		                      <?php echo $this->Form->input('term',array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'form-control paymentterm','autocomplete'=>'off'));?>
		                        
		                    </div>
		                  </div>
		                  <div class="form-group login-form-group"> 
		                    <label class="col-sm-5 control-label"> No of Days<sup style="color:#ff0000;font-size:13px">&lowast;</sup> </label>   
		                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
		                      <!--<input type="text" class="form-control" name="paymenttermdays">-->
		                      <?php echo $this->Form->input('no_of_days',array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'form-control noofdays','autocomplete'=>'off'));?>  
		                      
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
		<!--add term---->
        
       <?php echo $this->Form->create('SbsSubscriberPaymentTerm',array('url' =>'/subscription_plans/delete_all'));?>    
       <div class="row">
            <div class="col-xs-12">
              <div class="table-responsive overflow-visible">
                <div class="table-header">Payment Terms Setup</div>
               
                <div class="row magin-delete-all hidden-480">
                 <?php 
                 	if($permission['_delete'] == '1') {
						echo $this->Form->submit('delete_selected.png',array('class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected','onclick'=>"return confirm('Are you sure you want to delete selected payment terms ?')"));
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
                      <th class="width45p"><?php echo $this->Paginator->sort('term','Payment Term Name',array('url'=>$url,'lock'=>TRUE));?></th>
                      <th class="width45p hidden-480"><?php echo $this->Paginator->sort('no_of_days','No of Days',array('url'=>$url,'lock'=>TRUE));?></th>
                      <th class="width45p hidden-480"><?php echo $this->Paginator->sort('is_default','Default',array('url'=>$url,'lock'=>TRUE));?></th>
                      <th class="width9p">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $i=0; foreach($subscriber_payment_detail as $key=>$value): $i++; ?>
                  	<?php $checkPayment=$this->requestAction('subscription_plans/checkPaymentTerm/'.$value['SbsSubscriberPaymentTerm']['id']);?>
                  	
                    <tr id = "tr-<?php echo $value['SbsSubscriberPaymentTerm']['id']?>">
                      <td>
                        <label>
                          <!--<input class="ace delete-m-row" type="checkbox">-->
                          <?php if($checkPayment =='notexist') echo $this->Form->checkbox('Delete.'.$value['SbsSubscriberPaymentTerm']['id'],array('class'=>'ace',' type'=>'checkbox'));?>                 
                          <span class="lbl"></span> </label>
                        </span></td>
                      <td><span><?php echo $value['SbsSubscriberPaymentTerm']['term']; ?></span>
                      <td class="hidden-480"><span class="right-aligned-amt"><?php echo $value['SbsSubscriberPaymentTerm']['no_of_days']; ?></span></td>    
                      <td class="hidden-480">
                      	  <span class="right-aligned-amt">
                      	      <?php if($value['SbsSubscriberPaymentTerm']['is_default'] =='Y'){
                      	      	      echo "Yes";
                      	            }else{
                      	              echo "No";
                      	            }
                      	       ?>
                      	  </span></td>    
                        <td>
                            <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                <?php if($permission['_update'] == 1){ ?>
                                
								<button id="E<?php echo $value['SbsSubscriberPaymentTerm']['id'];?>" class="btn btn-xs btn-info edit on-load" title="Edit" data-toggle="modal" data-target="#editterm<?php echo $i; ?>">
									<i class="icon-edit bigger-120"></i>
								</button>
								<?php } ?>
								 <?php if($permission['_delete'] == 1){ ?>
								 <?php if($checkPayment =='notexist') echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('action' => 'delete_payment_term', $value['SbsSubscriberPaymentTerm']['id'],$this->Paginator->current()), array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete Payment Term ?')); ?>
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
                                            <button id="E<?php echo $value['SbsSubscriberPaymentTerm']['id'];?>" class="btn btn-xs btn-info edit on-load" title="Edit" data-toggle="modal" data-target="#editterm<?php echo $i; ?>">
												<i class="icon-edit bigger-120"></i>
											</button>
											<?php } ?>
                                        </li>
    
                                        <li class="adjust-button">
                                            <?php if($permission['_delete'] == 1){ ?>
                                             <?php if($checkPayment =='notexist') echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('action' => 'delete_payment_term', $value['SbsSubscriberPaymentTerm']['id'],$this->Paginator->current()), array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete Payment Term ?')); ?>
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
</div>

       <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 no-padding-left no-padding-right pagination_container">
			<div class="col-sm-6 no-padding-left no-padding-right margin020 paginationText">
				<div id="sample-table-2_info" class="dataTables_info">
					<?php echo $this->Paginator->counter(array('format' => __('Showing {:start} to {:end} of {:count} entries')));?>
				</div>
			</div>
			<div class="col-sm-6 no-padding-left margin020  no-padding-right paginationNumber">
				<div class="dataTables_paginate paging_bootstrap">
					<ul class="pagination">
						<?php
							
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
        
<?php $i=0; foreach($subscriber_payment_detail as $key=>$value): $i++; ?>
	<?php $checkPayment=$this->requestAction('subscription_plans/checkPaymentTerm/'.$value['SbsSubscriberPaymentTerm']['id']);?>
		<script>
		$(document).ready(function() {
			$('#editterm<?php echo $i; ?>').on('show.bs.modal', function (e) {
			  		$('.popup-error1, .popup-error2').hide();
				});
				$( ".epaymenttern-<?php echo $i; ?>, .enoofdays-<?php echo $i; ?>" ).focus(function() {
					$('.popup-error1, .popup-error2').hide();
				});
				
				$('.close-pop3').click(function(evt) {
			    	 value18 = $(".epaymenttern-<?php echo $i; ?>").val();
			    	 
			    	 if(value18.length === 0) {
			    	 	$('.popup-error1').show();
			    	 	evt.preventDefault();
				        $('#field').value();
			    	 }							
				   
				     var value19 = $.trim($(".enoofdays-<?php echo $i; ?>").val());
			    	 if(value19.length === 0) {
			    	 	$('.popup-error2').show();
			    	 	evt.preventDefault();
				        $('#field').value();
			    	 }
			    	 
			     	$('#editterm<?php echo $i; ?>').modal('hide');
			    });
				});				
			</script>
			<div class="modal fade" id="editterm<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog specialwidth">
			    <div class="modal-content">
			      <div class="modal-header page-header">       
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
			         <h1 class="modal-title" id="myModalLabel">Edit Payment Term</h1>    
			      </div>
			      
			      <?php echo $this->Form->create('EditSbsSubscriberPaymentTerm',array('url' =>'/subscription_plans/edit_payment_term/'.$value['SbsSubscriberPaymentTerm']['id'].'/'.$this->Paginator->current(),'id'=>'EditSbsSubscriberPaymentTerm'.$i));?>   
			      <div class="form-horizontal popup" role="form" id="addnewterm" method="POST">
			      <div class="modal-body">
			         <div class="model-body-inner-content">             
			                  <div class="form-group login-form-group">
			                    <label class="col-sm-5 control-label">Payment Term Name <sup style="color:#ff0000;font-size:13px">&lowast;</sup></label>    
			                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
			                     <?php echo $this->Form->input('term.'.$value['SbsSubscriberPaymentTerm']['id'],array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'form-control epaymenttern-'.$i.'','autocomplete'=>'off','value'=>$value['SbsSubscriberPaymentTerm']['term']));?>
			                     <p class="popup-error1">Please enter payment term.</p> 
			                    </div>
			                  </div>
			                  <div class="form-group login-form-group"> 
			                    <label class="col-sm-5 control-label"> No of Days<sup style="color:#ff0000;font-size:13px">&lowast;</sup> </label>   
			                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
			                      <?php if($checkPayment =='notexist') { 
			                      	      echo $this->Form->input('no_of_days.'.$value['SbsSubscriberPaymentTerm']['id'],array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'form-control enoofdays-'.$i.'','autocomplete'=>'off','value'=>$value['SbsSubscriberPaymentTerm']['no_of_days']));
			                            }else{
			                              echo $this->Form->input('no_of_days.'.$value['SbsSubscriberPaymentTerm']['id'],array('type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'form-control enoofdays-'.$i.'','autocomplete'=>'off','value'=>$value['SbsSubscriberPaymentTerm']['no_of_days']));
			                            }
			                       
			                       ?> 
			                       <p class="popup-error2">Please enter no of days.</p>
			                    </div>
			                  </div> 
			                  <div class="form-group login-form-group"> 
			                    <label class="col-sm-5 control-label">Default<sup style="color:#ff0000;font-size:13px">&lowast;</sup> </label>   
			                    <div class="col-sm-7 addcurrency_popup_input paddingleftrightzero">
			                       <?php if($value['SbsSubscriberPaymentTerm']['is_default'] == 'Y'){
			                       	          echo $this->Form->checkbox('is_default.'.$value['SbsSubscriberPaymentTerm']['id'],array('type'=>'checkbox','checked'=>'checked'));
			                            }else{
			                            	  echo $this->Form->checkbox('is_default.'.$value['SbsSubscriberPaymentTerm']['id'],array('type'=>'checkbox'));
			                            }
			                            ?>                      
			                    </div>
			                  </div> 
			                 
			          </div>
			      </div>
			      <div class="modal-footer special_color">
			            <?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('class'=>'close-pop3 btn btn-info','type'=>'submit'));?> 
			            <?php //echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-pop3','url' => array('action'=>'edit_payment_term',$value['SbsSubscriberPaymentTerm']['id'],$i),'escape'=>false,'update' => '#tr-'.$value['SbsSubscriberPaymentTerm']['id'], 'title' => 'Save', 'id' => 'submit-'.$value['SbsSubscriberPaymentTerm']['id']));?>
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

	$('.popup-cancel').click(function(){
		$('.close').trigger('click');
	});
	
	
	$("#AddSbsSubscriberPaymentTermPaymentTermSetupForm").validate({
		 rules: {
            "data[AddSbsSubscriberPaymentTerm][term]":{
				required : true
			},
            "data[AddSbsSubscriberPaymentTerm][no_of_days]": {
				required : true,
				digits : true
			}
		 },
		  messages:{
			 "data[AddSbsSubscriberPaymentTerm][term]":{
				required: "Please enter payment term"				
		 	 },
			 "data[AddSbsSubscriberPaymentTerm][no_of_days]":{
				required: "Please enter no of days",
				digits: "Please enter numeric values only"				
		 	 }
		  }
	});	
});
</script>

<?php echo $this->Js->writeBuffer();?>  
