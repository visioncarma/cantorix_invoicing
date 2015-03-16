<div id="flashmsg00"></div>
<?php echo $this->Html->css(array('chosen.css')); ?>
<?php if(!$tname) $tname=0; 
	  if(!$tcode) $tcode=0; 
	  if(!$tname) $taxname1=0; 
	  if(!$tname) $groupname=0; 
?>

<?php echo $this->Session->flash();?>		
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
	 <?php $homeLink = $this->Breadcrumb->getLink('Home');
	       $settings = $this->Breadcrumb->getLink('Settings'); ?>	
    <ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
        <li>								
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		<li class="active">Manage Tax</li>
	</ul><!-- breadcrumb -->
</div>

<div class="page-content taxlist" >
	<div class="page-header noborder">
		<h1>
			Manage Taxes							
		</h1>
    </div>
    
    <div class="row taxscreen">
    	<div class="col-xs-12">
    		
		<div id="tabs" class="custom-tab">
				<ul class=" customtablist">
					<li id="fortax" class="addtaxes active" >
                        <?php echo $this->Js->link('<i class="taxicon"></i>Taxes', array (
													'controller' => 'taxes',
													'action' => 'index'
												), array (
													
													'div' => false,
													'update' => '#pageContent',
													'escape'=>false
												));
										?>
					</li>

					<li id="forgrp"  class="addtaxgroups">
					
					 	<?php echo $this->Js->link('<i class="taxicongroup"></i>Tax Groups', array (
													'controller' => 'tax_groups',
													'action' => 'index'
												), array (
													
													'div' => false,
													'update' => '#tabs-1',
													'escape'=>false
												));
										?>
				 </li>
					
				</ul>
				
				
				
				<div id="tabs-1">
					<div class="pull-right  bottommarginn newaddtax">
					   <?php if($permission['_create'] == 1) echo $this->Html->link('<i class="icon-plus"></i>Add Tax',array('controller'=>'taxes','action'=>'add'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
					</div>
					
				   								
                     <div class="table-header">Tax List</div>
                     <?php echo $this->Form->create('SbsSubscriberTax');?>  
						<div class="row margin-twenty-zero">
                        	
                                <div class="form-group filed-left margin-bottom-zero width-100-480">
                                 <?php echo $this->Form->input('name',array('class'=>'tName form-control','type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Tax Name')); ?>
                                </div>
                           		<div class="form-group filed-left margin-bottom-zero width-100-480">
                                  <?php echo $this->Form->input('code',array('class'=>'tCode form-control','type'=>'text','label'=>false,'div'=>false,'placeholder'=>'Tax Code')); ?>
                                </div>                                                    
                            	<div class="form-group filed-left margin-bottom-zero mobile_100">
                            		<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn taxfilter mobile_100','url' => array('controller'=>'taxes','action' => 'index'),'escape'=>false,'update' => '#pageContent','before' => $this->Js->get('#loading2')->effect('fadeIn', array('buffer' => false)),
                            	                       'complete' => $this->Js->get('#loading2')->effect('fadeOut', array('buffer' => false))));?>
                            	</div>
                            	<div class="form-group filed-left margin-bottom-zero mobile_100">
									<?php echo $this->Js->link('Reset',array('controller'=>'taxes','action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','update' => '#pageContent','before' => $this->Js->get('#loading2')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading2')->effect('fadeOut', array('buffer' => false))));?>
								</div>
								<?php echo $this->Html->image('loding.gif', array('id'=>'loading2','style'=>'display:none;float: right;margin-right: 40%;'));?>
                        </div>
                        
                        <?php echo $this->Form->end();?>
                        <div id="toshow" class="emptysearch" style="display:none;">
      	                      <p>Please select the search term.</p>
                        </div>
                        <?php echo $this->Form->create('SbsSubscriberTax',array('url'=>array('controller'=>'taxes','action'=>'multi_tax_delete','delete')));?> 
                       	<div class="row rightfloatdelet" style="display:none;">
                       		<div class="form-group filed-left margin-bottom-zero">
                            <?php  echo $this->Form->submit('Delete',array('class'=>'btn btn-sm btn-primary filter-btn','div'=>false));?>
                        	</div>                                            		
                       	</div>
                        <?php echo $this->Form->end();?>
                         <?php echo $this->Form->create('SbsSubscriberTax',array('url'=>array('controller'=>'taxes','action'=>'edit',$value['SbsSubscriberTax']['id'])));?>
                        <table id="sample-table-1" class="updatehide table table-striped table-bordered table-hover editable-table">
							<thead>
								<tr>
                                														
									<!--<th>Tax Name</th>-->
									<th>Tax name</th>
									<th class="hidden-480">Tax Code</th>
									<th>Tax Percentage</th>
									<th>Action</th>
								</tr>
							</thead>
                            
							<tbody>
							<?php $i=0; foreach($sbsSubscriberTaxes as $key=>$value): $i++; ?>
								<?php $taxChange=$this->requestAction('taxes/taxPercentChange/'.$value['SbsSubscriberTax']['id']);?>
								
								<tr id = "tr-<?php echo $value['SbsSubscriberTax']['id']?>">
                                	
                                     
                                    
									<td>
                                    	<span class="on-load"><?php echo $value['SbsSubscriberTax']['name']; ?></span>
                                    </td>
									<td class="hidden-480">
                                    	<span class="on-load"><?php echo $value['SbsSubscriberTax']['code']; ?></span>
                                    </td>
									<td>
                                    	<span class="on-load taxpercentageright"><?php echo number_format((float)$value['SbsSubscriberTax']['percent'], 2, '.', '');?>%</span>
                                        
                                    </td>														
									<td>
										<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
											
                                            <?php if($permission['_read'] == 1){ ?>
                                            <a href="javascript:void(0);"> 
                                            <button class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewuser<?php echo $i; ?>">
												<i class="icon-zoom-in bigger-120"></i>
											</button>
											</a>
                                            <?php } ?>
                                            
                                            <?php if($permission['_update'] == 1){ ?>
                                            <a href="javascript:void(0);"> 
                                            <button class="btn btn-xs btn-info edit on-load" title="Edit" data-toggle="modal" data-target="#edituser<?php echo $i; ?>">
												<i class="icon-edit bigger-120"></i>
											</button>
											</a>
                                             <?php } ?>
                                             
											<?php if($permission['_delete'] == 1){ 
											        if($taxChange) echo $this->Js->link('<button class="btn btn-xs btn-danger delete on-load" title="Delete"><i class="icon-trash bigger-120"></i></button>',
													array('action' => 'delete',$value['SbsSubscriberTax']['id']), array('confirm'=>'Are you sure you want to delete the tax ?','escape'=>FALSE,'update'=>'#flashmsg00, #tr-'.$value['SbsSubscriberTax']['id'])); 
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
                                          <!--   <a class="btn btn-xs btn-success view on-load adjustanchor" title="View" data-toggle="modal" data-target="#viewuser<?php echo $i; ?>"> 
                                            
												<i class="icon-zoom-in bigger-120"></i>
											</a>-->
												<div class="btn btn-xs btn-success view on-load adjustanchor" title="View" data-toggle="modal" data-target="#viewuser<?php echo $i; ?>">
													<i class="icon-zoom-in bigger-120"></i>
												</div>
											
											
                                            <?php } ?>
											</li>
											<li> 
												 <?php if($permission['_update'] == 1){ ?>
                                            <!-- <a class="btn btn-xs btn-info edit on-load adjustanchor" title="Edit" data-toggle="modal" data-target="#edituser<?php echo $i; ?>" href="javascript:void(0);"> 
                                            
												<i class="icon-edit bigger-120"></i>
											</a>-->
											<div class="btn btn-xs btn-info edit on-load adjustanchor" title="Edit" data-toggle="modal" data-target="#edituser<?php echo $i; ?>">
												<i class="icon-edit bigger-120"></i>
											</div>
											
                                             <?php } ?>
											</li>
											<li class="adjust-button">
												<?php if($permission['_delete'] == 1){ 
											        if($taxChange) echo $this->Js->link('<button class="btn btn-xs btn-danger delete" title="Delete"><i class="icon-trash bigger-120"></i></button>',
													array('action' => 'delete',$value['SbsSubscriberTax']['id']), array('confirm'=>'Are you sure you want to delete the tax ?','escape'=>FALSE,'update'=>'#flashmsg00, #tr-'.$value['SbsSubscriberTax']['id'])); 
													
											 } ?>
											</li>
											
                                            </ul>
                                           
                                             </div>
										</div>
									</td>
									 
								</tr>
								
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
													          <div class="model-body-inner-content ">  
														           <div class="form-group login-form-group">
																         <label class="col-sm-4 no-padding-top">Tax Name </label>    
																         <div class="col-sm-8">
																		    <p class="bold"><?php echo $value['SbsSubscriberTax']['name']; ?></p>
																		 </div>
																   </div>
																   <div class="form-group login-form-group"> 
																		<label class="col-sm-4 no-padding-top"> Tax Code </label>   
																		<div class="col-sm-8">
																		  <p class="bold"><?php echo $value['SbsSubscriberTax']['code']; ?></p>
																		</div>
																  </div> 
																  <div class="form-group login-form-group"> 
																		<label class="col-sm-4 no-padding-top"> Percentage</label>   
																		<div class="col-sm-8">
																		  <p class="bold"><?php echo number_format((float)$value['SbsSubscriberTax']['percent'], 2, '.', ''); ?>%</p>
																		</div>
																  </div>                    
															  </div>
													     </div>
													</div>
									         </div>
									     </div>
									</div>
								<!--end of pop-->  
								
								
									
							   <?php endforeach;?>   
                             </tbody>
                        </table>
                        <?php echo $this->Form->end();?>
                  <?php $pages = $this->Paginator->current('SbsSubscriberTax');?>
                 <?php if($sbsSubscriberTaxes) { ?>      
                 <div class="row clear col-xs-12 paginationmaindiv extrapaddinglefttaxonly">
					<div class="col-sm-6">
						<div id="sample-table-2_info" class="dataTables_info">
							<?php echo $this->Paginator->counter(array('format' => __('Showing {:start} to {:end} of {:count} entries'),'model'=>'SbsSubscriberTax'));?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="dataTables_paginate paging_bootstrap">
							<ul class="pagination">
								<?php
									
									$url = array('controller'=>'taxes','action'=>'index',$taxname,$taxcode);
									$this->Paginator->options(array(
					 					'update' => '#pageContent',
										'evalScripts' => true,
										'url' => $url,
										'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),
		    							'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false))
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
				<?php } ?>
				
				
	<?php $i=0; foreach($sbsSubscriberTaxes as $key=>$value): $i++; ?>
		 <?php echo $this->Form->create('SbsSubscriberTax',array('id'=>'SbsSubscriberTaxes'.$i));?>  
								<?php $taxChange=$this->requestAction('taxes/taxPercentChange/'.$value['SbsSubscriberTax']['id']);?>				
									<!--Popup Edit  -->
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
												                            <label class="col-sm-4 control-label no-padding-right col-xs-12" for="form-field-1"> Tax Name </label>
												
												                            <div class="col-sm-8 col-xs-12 nopaddingmobile">
												                                <?php echo $this->Form->input('tax_name.'.$value['SbsSubscriberTax']['id'],array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$value['SbsSubscriberTax']['name']));?>  
												                            </div>
												                        </div>	
												                        <div class="form-group">
												                            <label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-1"> Tax Code </label>
												
												                            <div class="col-sm-8 col-xs-12 nopaddingmobile">
												                                <?php echo $this->Form->input('tax_code.'.$value['SbsSubscriberTax']['id'],array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$value['SbsSubscriberTax']['code']));?>  
												                            </div>
												                        </div>
												                        <div class="form-group">
												                            <label class="col-sm-4 col-xs-12 control-label no-padding-right" for="form-field-1"> Percent </label>
												
												                            <div class="col-sm-8 col-xs-12 nopaddingmobile">
												                              
												                              <?php if($taxChange){
												                              	           echo $this->Form->input('tax_percent.'.$value['SbsSubscriberTax']['id'],array('div'=>FALSE,'label'=>FALSE,'class'=>'input-mini col-xs-12 col-sm-5 form-control','value'=>$value['SbsSubscriberTax']['percent'],'onkeypress' => "return isNumberKey(event)"));
																					 }else{
																					  	   echo $this->Form->input('tax_percent.'.$value['SbsSubscriberTax']['id'],array('div'=>FALSE,'label'=>FALSE,'class'=>'input-mini col-xs-12 col-sm-5 form-control','readonly'=>true,'value'=>$value['SbsSubscriberTax']['percent']));
																					 }  
																				  ?> 
												                             
												                            </div>
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
														                                 <?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-pop','url' => array('controller'=>'taxes','action'=>'edit',$value['SbsSubscriberTax']['id']),'escape'=>false,'update' => '#tr-'.$value['SbsSubscriberTax']['id'], 'title' => 'Save', 'id' => 'submit-'.$value['SbsSubscriberTax']['id']));?>
														                                </div>
														                            </div>
											                                  </div> 
												                 </div>
												                   
												                  
										         </div>
									        </div> 
									     </div>
									</div>
		
		<?php echo $this->Form->end();?> <!--end of pop-->  
 <?php endforeach;?>   				
				
				
				
               </div>
      </div>
      
      </div>
   </div>  
</div><!-- page-content -->


<style>
	.emptysearch{
		color: #DF4040;
	 }
	 
</style>
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
$(function() {
	$(".chosen-select").chosen();
    $('#spinner1').ace_spinner({value:0,min:0,max:200,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
	.on('change', function(){
	});		
});

$("#tabs li a").click(function(){
	
	
	
	var parentli = $(this).parent().attr('id');
	
	if(parentli == "fortax")
	{
		$(this).parent().addClass("active");
		$(this).parent().next().removeClass("active");
	}
	else if(parentli == "forgrp")
	{
		$(this).parent().addClass("active");
		$(this).parent().prev().removeClass("active");
	}
})

$(document).ready(function(){
	$('.close-pop').click(function(){
		$('.close').trigger('click');
	});	
	$('.close-pop , .popup-cancel').click(function(){
		$('.close').trigger('click');
	});
	 $( ".edit" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
	/*$( ".delete" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});*/
	$( ".view" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});
})

</script>

<?php echo $this->Js->writeBuffer();?>