<?php $counts = $this->Paginator->params();?>
<?php $pages = $this->Paginator->current('InvInventory');?>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
?>
<?php echo $this->Session->flash();?>
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
		<li class="active">
			<?php echo __('Inventory');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 class="managecustomer manageinventory"> <?php echo __('Manage Inventory');?> </h1>
		<div class="col-lg-6 col-sm-12 col-md-12  col-xs-12 paddingleftrightzero pull-right">
			<?php if($permission['_create'] == '1'):?>
				<?php echo $this->Html->link('<i class="icon-plus"></i> Add Items',array('controller'=>'inventories','action'=>'add'),array('class'=>'btn btn-sm btn-success pull-right addbutton marginleft2','escape'=>FALSE));?>
		    <?php endif;?>
			<!--button class="btn btn-sm btn-success pull-right manageinventoryexport marginleft2" data-toggle="modal" data-target="#exportitem">
				Export Items <i class="icon-caret-down icon-on-right"></i>
			</button-->
			<?php echo $this->Html->link('Export Items <i class="icon-caret-down icon-on-right"></i>',array('controller'=>'inventories','action'=>'exportItems'),array('class'=>'btn btn-sm btn-success pull-right manageinventoryexport marginleft2','escape'=>FALSE));?>		
			<?php if($permission['_create'] == '1'):?>
				<?php echo $this->Html->link('Import Items <i class="icon-caret-down icon-on-right"></i>',array('controller'=>'inventories','action'=>'show_excel'),array('class'=>'btn btn-sm btn-success pull-right importbutton','escape'=>FALSE));?>
			<?php endif;?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll">
				<div class="table-header">
					<?php echo __('Inventory List');?>
				</div>
				<?php echo $this->Form->create('InventoryFilter',array('id'=>'InventoryFilter','url'=>array('controller'=>'inventories','action'=>'index')));?>
				<div class="row margin-twenty-zero">
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-4 col-lg-2 nopadding">
						<?php echo $this->Form->input('item_name',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-filter-field-1','placeholder'=>'Item Name','class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-4 col-lg-2 nopadding">
						<?php echo $this->Form->input('price_min',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-filter-field-2','placeholder'=>'Minimum Price','class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-4 col-lg-2 nopadding">
						<?php echo $this->Form->input('price_max',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-filter-field-2','placeholder'=>'Maximum Price','class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-4 nopadding col-lg-2">
						<?php echo $this->Form->input('quantity',array('div'=>false,'label'=>false,'options'=>array(''=>'Select stock-wise','in-stock'=>'In Stock','out-stock'=>'Out Of Stock'),'class'=>'form-control selectpicker'))?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Js->submit('Filter', array('div'=>false,'class'=>'btn btn-sm btn-primary filter-btn taxgrpfilter form-control','url' => array('controller'=>'inventories','action' => 'index'),'escape'=>false,'update' => '#pageContent'));?>
					</div>
				</div>
				<?php echo $this->Form->end();?>
				<?php echo $this->Form->create('InvInventory');?>
				 <div  class="row magin-delete-all">
                 <span class="deleteicon delete" title="Delete All"><i class="icon-trash bigger-120" style="color:#B74635;"></i></span>
                </div> 
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<th><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label></th>
							<th><?php echo __('Item Name');?></th>
							<th class="discr_width"><?php echo __('Description');?></th>
							<th><?php echo __('Price');?></th>
							<th><?php echo __('Onhand');?></th>
							<th><?php echo __('Action');?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($invInventories as $invInventory):?>
						<tr id = "tr-<?php echo $invInventory['InvInventory']['id'];?>">
							<td><span class=""> <label>
									<input class="ace delete-m-row" type="checkbox">
									<span class="lbl"></span> </label> </span>
							</td>
							<td>
								<span class="on-load">
									<?php echo $invInventory['InvInventory']['name'];?>
								</span></td>
							<td><span class="on-load"><?php echo $invInventory['InvInventory']['description'];?></span>
							</td>
							<td>
								<span class="on-load">
									<?php $options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before')?>
									<?php echo $this->Number->currency($invInventory['InvInventory']['list_price'],$invInventory['CpnCurrency']['code'],$options);?>
								</span>
								<?php $price = $this->Number->currency($invInventory['InvInventory']['list_price'],$invInventory['CpnCurrency']['code'],$options);?></td>
							<td>
								<span class="on-load">
									<?php if($invInventory['InvInventory']['current_stock']){
												echo $invInventory['InvInventory']['current_stock'];
											}else{
											 echo "Out Of Stock";
											 }
									?>
								</span>
								</td>
							<td>
							<div class="btn-group visible-md visible-lg hidden-sm hidden-xs">
								
								<div class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewuser-<?php echo $invInventory['InvInventory']['id'];?>">
									<i class="icon-zoom-in bigger-120"></i>
								</div>
								
								<?php if($permission['_update'] == 1):?>
									<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'inventories','action'=>'editInventory',$invInventory['InvInventory']['id'],$pages,$itemName,$minPrice,$maxPrice,$inHand),array('class'=>'btn btn-xs btn-info edit on-load ','title'=>'Edit','escape'=>FALSE));?>
								<?php endif;?>
								<?php if($permission['_delete'] == 1):?>
									<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('controller'=>'inventories','action'=>'delete',$invInventory['InvInventory']['id'],$pages,$itemName,$minPrice,$maxPrice,$inHand),array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure you want to remove '.$invInventory['InvInventory']['name'].' from the system?'));?>
								<?php endif;?>
							</div>
							
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>
									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
										<li>
											<div class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewuser-<?php echo $invInventory['InvInventory']['id'];?>">
												<i class="icon-zoom-in bigger-120"></i>
											</div>
										</li>
										<li>
											<?php if($permission['_update'] == 1):?>
												<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'inventories','action'=>'editInventory',$invInventory['InvInventory']['id'],$pages,$itemName,$minPrice,$maxPrice,$inHand),array('class'=>'btn btn-xs btn-info edit on-load paddinglr3','title'=>'Edit','escape'=>FALSE));?>
											<?php endif;?>
										</li>
										<li>
											<?php if($permission['_delete'] == 1):?>
												<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('controller'=>'inventories','action'=>'delete',$invInventory['InvInventory']['id'],$pages,$itemName,$minPrice,$maxPrice,$inHand),array('class'=>'btn btn-xs btn-danger delete on-load paddinglr3','title'=>'Delete','escape'=>FALSE), __('Are you sure you want to remove '.$invInventory['InvInventory']['name'].' from the system?'));?>
											<?php endif;?>
										</li>
									</ul>
								</div>
							</div>
							</td>
							<div class="modal fade" id="viewuser-<?php echo $invInventory['InvInventory']['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									     <div class="modal-dialog">
									          <div class="modal-content">
									               <div class="modal-header page-header">       
									                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
									                    <h1 class="modal-title" id="myModalLabel"><?php echo __('View Inventory');?></h1>    
									               </div>
												   <div class="form-horizontal popup">
													    <div class="modal-body">
													          <div class="model-body-inner-content">  
														           <div class="form-group login-form-group">
																         <label class="col-sm-4 no-padding-top"><?php echo __('Item Name');?> </label>    
																         <div class="col-sm-8">
																		    <p class="bold wordwrap"><?php echo $invInventory['InvInventory']['name'];?></p>
																		 </div>
																   </div>
																   <div class="form-group login-form-group"> 
																		<label class="col-sm-4 no-padding-top"> <?php echo __('Description');?> </label>   
																		<div class="col-sm-8">
																		  <p class="bold wordwrap"><?php echo $invInventory['InvInventory']['description']; ?></p>
																		</div>
																  </div> 
																  <div class="form-group login-form-group"> 
																		<label class="col-sm-4 no-padding-top"> <?php echo __('Price');?></label>   
																		<div class="col-sm-8">
																			 <p class="bold">
																			  	<?php $options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before')?>
																				<?php echo $this->Number->currency($invInventory['InvInventory']['list_price'],$invInventory['CpnCurrency']['code'],$options);?>
																			 </p>
																		</div>
																  </div> 
																   <div class="form-group login-form-group"> 
																		<label class="col-sm-4 no-padding-top"> <?php echo __('On hand');?></label>   
																		<div class="col-sm-8">
																			 <p class="bold">
																			  	<?php if($invInventory['InvInventory']['current_stock']){
																							echo $invInventory['InvInventory']['current_stock'];
																						}else{
											 												echo "Out Of Stock";
																						 }
																				?>
																			 </p>
																		</div>
																  </div>
																  <div class="form-group login-form-group"> 
																		<label class="col-sm-4 no-padding-top"> <?php echo __('Tax/Tax Group');?></label>   
																		<div class="col-sm-8">
																			 <p class="bold">
																			  	<?php if($invInventory['InvInventory']['sbs_subscriber_tax_group_id']){
																			  				
																							echo $invInventory['SbsSubscriberTaxGroup']['group_name'];
																						}elseif($invInventory['InvInventory']['sbs_subscriber_tax_id']){
											 												echo $invInventory['SbsSubscriberTax']['name'];
																						 }else{
																						 	echo "-NA-";
																						 }
																				?>
																			 </p>
																		</div>
																  </div> 
																  <div class="form-group login-form-group"> 
																		<label class="col-sm-4 no-padding-top"> <?php echo __('Track Quantity');?></label>   
																		<div class="col-sm-8">
																			 <p class="bold">
																			  	<?php if($invInventory['InvInventory']['track_quantity']=='Y'){
																							echo "On";
																						}else{
																						 	echo "OFF";
																						 }
																				?>
																			 </p>
																		</div>
																  </div> 
																  <?php if($customFields):?>
																  <div class="col-sm-12 contactdetails paddingleft15">
																		<h5 class="paddingleft20 width-auto" style="font-weight:normal;"><?php echo __('Additional Information');?></h5>
																  </div>
																  <?php endif;?>
																	<?php foreach($customFields as $fieldId=>$fieldValue):?>
																		<div class="col-sm-12 form-group">
																			<label class="col-sm-4 control-label"> <?php echo $fieldValue;?> </label>
																			<div class="col-sm-8">
																				<?php echo $customValue[$invInventory['InvInventory']['id']][$fieldId];?>
																			</div>
																		</div>
																	<?php endforeach;?>                  
															  </div>
													     </div>
													  <!--<div class="modal-footer"></div>     -->      
													</div>
									         </div>
									     </div>
									</div>
						</tr>
						
						<?php endforeach;?>
					</tbody>
				</table>
				<?php echo $this->Form->end();?>
				
			
			</div>
			
			
			<!-- Only mobile -->
						<div class="table-small-view wordwrap">
                          <div class="row marginleftrightzero nopaddingleft nopaddingright borderfull header-small-view paddingtopbottom5">
                               <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                    <div class="col-xs-12">
                                        <!--span class="pull-left">
                                        <label>
                                            <input class="ace" type="checkbox">
                                            <span class="lbl"></span>
                                        </label>
                                     </span>
                                     <span  class="row magin-delete-all">
                                         <span class="deleteicon delete pull-right" title="Delete All">
                                          <i class="icon-trash bigger-120" style="color:#d15b47;"></i>
                                         </span> 
                                     </span-->
                                     </div>
                                </div>
                          </div>
                          <?php echo $this->Form->create('InvInventory');?>
                          <?php $slno = null;?>
						 <?php foreach($invInventories as $invInventory):?>
						 
                          <div class="row marginleftrightzero nopaddingleft nopaddingright borderfull paddingtopbottom5 contentrow borderbottom" id ="tr-<?php echo $invInventory['InvInventory']['id'];?>">
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-6">
                                     <span class="pull-left">
                                        <label>
                                            <input class="ace" type="checkbox">
                                            <span class="lbl"></span>
                                        </label>
                                     </span> 
                                </div>
                                <div class="col-xs-6">
                                    <div class="pull-right">
										<div class="inline position-relative">
											<button class="btn btn-minier btn-info dropdown-toggle" data-toggle="dropdown">
												<i class="icon-cog icon-only bigger-120"></i>
											</button>
											<?php if($permission['_update'] == 1 || $permission['_delete'] == 1):?>
											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
														<li>
															<?php if($permission['_update'] == 1):?>
																<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'inventories','action'=>'editInventory',$invInventory['InvInventory']['id'],$pages,$itemName,$minPrice,$maxPrice,$inHand),array('class'=>'btn btn-xs btn-info edit edit-row on-load on-edit','title'=>'Edit','escape'=>FALSE));?>
															<?php endif;?>
														</li>
	
														<li>
															<?php if($permission['_delete'] == 1):?>
																<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('controller'=>'inventories','action'=>'delete',$invInventory['InvInventory']['id'],$pages,$itemName,$minPrice,$maxPrice,$inHand),array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure you want to remove '.$invInventory['InvInventory']['name'].' from the system?'));?>
															<?php endif;?>
														</li>
													</ul>	
											<?php endif;?>
											
										</div>
									</div>
                                </div>
                             </div>
                             
                             
								
								
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Item Name
                                </div>
                                <div class="col-xs-7 font13 wordwrap">
                                	<span class="on-load"><?php echo $invInventory['InvInventory']['name'];?></span>
								<?php echo $this->Form->input($invInventory['InvInventory']['id'].'.name',array('div'=>false,'label'=>false,'class'=>'on-edit','value'=>$invInventory['InvInventory']['name'],'placeholder'=>'Inventory Name'));?>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Description
                                </div>
                                <div class="col-xs-7 font13">
                                	<span class="on-load"><?php echo $invInventory['InvInventory']['description'];?>&nbsp;</span>
								<?php echo $this->Form->input($invInventory['InvInventory']['id'].'.description',array('div'=>false,'label'=>false,'class'=>'on-edit','value'=>$invInventory['InvInventory']['description'],'placeholder'=>'Description'));?>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Price
                                </div>
                                <div class="col-xs-7 font13">
                                	<span class="on-load">
									<?php $options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before')?>
									<?php echo $this->Number->currency($invInventory['InvInventory']['list_price'],$invInventory['CpnCurrency']['code'],$options);?>
								</span>
								<?php $price = $this->Number->currency($invInventory['InvInventory']['list_price'],$invInventory['CpnCurrency']['code'],$options);?>
								<?php echo $this->Form->input($invInventory['InvInventory']['id'].'.list_price',array('div'=>false,'label'=>false,'type'=>'text','class'=>'on-edit','value'=>$invInventory['InvInventory']['list_price'],'placeholder'=>'Inventory Price'));?>
                                </div>
                             </div>
                              <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Onhand
                                </div>
                                <div class="col-xs-7 font13">
                                	<span class="on-load">
									<?php if($invInventory['InvInventory']['current_stock']){
												echo $invInventory['InvInventory']['current_stock'];
											}else{
											 echo "Out Of Stock";
											 }
									?>
								</span>
								<?php echo $this->Form->input($invInventory['InvInventory']['id'].'.current_stock',array('div'=>false,'label'=>false,'class'=>'on-edit','type'=>'text','value'=>$invInventory['InvInventory']['current_stock'],'placeholder'=>'Inventory Stock'));?>
                                </div>
                             </div>
                             
                               <div class="col-xs-4 pull-right">
                              		<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
										<?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn','url' => array('controller'=>'inventories','action' => 'edit',$invInventory['InvInventory']['id']),'escape'=>false,'update' => '#tr-'.$invInventory['InvInventory']['id'], 'title' => 'Save', 'id' => 'submit-'.$invInventory['InvInventory']['id']));?>
										<div class="btn btn-xs close-action" title="Cancel">
											<i class="icon-remove bigger-120"></i>
										</div> 
									</a>
                              </div>
                          </div>  
                          <?php endforeach?>
                                                    
                           <div class="row marginleftrightzero nopaddingleft nopaddingright borderfullrevert borderbottom header-small-view paddingtopbottom5">
                               <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                    <div class="col-xs-12">
                                        <span class="pull-left">
                                        <label>
                                            <input class="ace" type="checkbox">
                                            <span class="lbl"></span>
                                        </label>
                                     </span>
                                     <span  class="row magin-delete-all">
                                         <span class="deleteicon delete pull-right" title="Delete All">
                                          <i class="icon-trash bigger-120" style="color:#d15b47;"></i>
                                         </span> 
                                     </span>
                                     </div>
                                </div>
                          </div>                                      
                        </div>
						<?php echo $this->Form->end();?>
   						<!-- Only mobile -->		
				
				
						
				<div class="row clear col-xs-12 paginationmaindiv">
                   <div class="col-sm-6">
                      <div id="sample-table-2_info" class="dataTables_info">
	                     	<?php
								echo $this->Paginator->counter(array(
									'format' => __('showing <span>{:start}</span> to <span>{:end}</span> of {:count}')
								));
							?>
                     	</div>
                      </div>
	                      <div class="col-sm-6">
	                           <div class="dataTables_paginate paging_bootstrap">
	                                <ul class="pagination">
	                                	<?php
											$this->Paginator->options(array(
		     									'update' => '#pageContent',
												'evalScripts' => true,
												'url' => array('controller'=>'inventories','action'=>'index',$itemName,$minPrice,$maxPrice,$inHand),
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
					
		</div>
	</div>
</div>
<?php echo $this->Js->writeBuffer();?>
<!-- /.page-content -->

<!--Popup export items  -->
<!--div class="modal fade" id="exportitem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog model-inventory">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title bold" id="myModalLabel">Export to Excel</h1>
			</div>
			<form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="form-group login-form-group">
							<p>
								Export Selected Items to Excel.
							</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-info" type="button">
						<i class="icon-ok bigger-110"></i> Export
					</button>
					&nbsp; &nbsp; &nbsp;
					<button class="btn" type="button">
						<i class="icon-remove bigger-110"></i> Cancel
					</button>
				</div>
			</form>
		</div>
	</div>
</div-->
<!--end of pop-->
<!--Popup delete items  -->
<!--div class="modal fade" id="deleteitem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog model-inventory">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title bold" id="myModalLabel">Delete</h1>
			</div>
			<form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="form-group login-form-group">
							<p>
								Are you sure you want to delete 'Cooler'?
							</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger" type="button">
						<i class="icon-trash bigger-110"></i> Delete
					</button>
					&nbsp; &nbsp; &nbsp;
					<button class="btn" type="button">
						<i class="icon-remove bigger-110"></i> Cancel
					</button>
				</div>
			</form>
		</div>
	</div>
</div-->
<!--end of pop-->

<!-- inline scripts related to this page -->

<script type="text/javascript">
	jQuery(function($) {
		$(".chosen-select").chosen();
	}); 
</script>
<script type="text/javascript" >

	$(document).ready(function(){
	 $("#InvInventory").validate({
	 	    onkeyup: false,
			rules: {
				'data[InvInventory][name]': { 
				   required : true
			     },			
				'data[InvInventory][list_price]': { 
				   required : true,
				   number	: true
			     },	
			     'data[InvInventory][current_stock]' : {
			     	required : true,
			     	number	 : true
			     }
			},
			messages: {
				'data[InvInventory][name]':  { 
				   required : 'Please enter inventory name.'
			     },	
				'data[InvInventory][list_price]':  { 
				   required : 'Please enter price for inventory.',
				   number	: 'Price should be number.'
			     },	
			     'data[InvInventory][current_stock]' : {
			     	required : 'Please enter stock quantity.',
			     	number	 : 'stock quantity should be number.'
			     }
			}
		});
		
		
});
$(document).ready(function(){
    	if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});
    	
    	}
    	
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
