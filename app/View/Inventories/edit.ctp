

							<td><span class=""> <label>
									<input class="ace delete-m-row" type="checkbox">
									<span class="lbl"></span> </label> </span>
							</td>
							<td>
								<span class="on-load">
									<?php echo $invInventory['InvInventory']['name'];?>
								</span>
								<?php echo $this->Form->input('InvInventory.'.$invInventory['InvInventory']['id'].'.name',array('div'=>false,'label'=>false,'class'=>'on-edit','value'=>$invInventory['InvInventory']['name'],'placeholder'=>'Inventory Name'));?>
							</td>
							<td><span class="on-load"><?php echo $invInventory['InvInventory']['description'];?></span>
								<?php echo $this->Form->input('InvInventory.'.$invInventory['InvInventory']['id'].'.description',array('div'=>false,'label'=>false,'class'=>'on-edit','value'=>$invInventory['InvInventory']['description'],'placeholder'=>'Description'));?>
							</td>
							<td>
								<span class="on-load">
									<?php $options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before')?>
									<?php echo $this->Number->currency($invInventory['InvInventory']['list_price'],$invInventory['CpnCurrency']['code'],$options);?>
								</span>
								<?php $price = $this->Number->currency($invInventory['InvInventory']['list_price'],$invInventory['CpnCurrency']['code'],$options);?>
								<?php echo $this->Form->input('InvInventory.'.$invInventory['InvInventory']['id'].'.list_price',array('div'=>false,'label'=>false,'type'=>'text','class'=>'on-edit','value'=>$invInventory['InvInventory']['list_price'],'placeholder'=>'Inventory Price'));?>
							</td>
							<td>
								<span class="on-load">
									<?php if($invInventory['InvInventory']['current_stock']){
												echo $invInventory['InvInventory']['current_stock'];
											}else{
											 echo "Out Of Stock";
											 }
									?>
								</span>
								<?php echo $this->Form->input('InvInventory.'.$invInventory['InvInventory']['id'].'.current_stock',array('div'=>false,'label'=>false,'class'=>'on-edit','type'=>'text','value'=>$invInventory['InvInventory']['current_stock'],'placeholder'=>'Inventory Stock'));?>
							</td>
							<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
								<?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn','url' => array('controller'=>'inventories','action' => 'edit',$invInventory['InvInventory']['id']),'escape'=>false,'update' => '#tr-'.$invInventory['InvInventory']['id'], 'title' => 'Save', 'id' => 'submit-'.$invInventory['InvInventory']['id']));?>
								<!--<button class="btn btn-xs submit" title="submit">
									<i class="icon-ok bigger-120"></i>
								</button-->
								<div class="btn btn-xs close-action" title="Cancel">
									<i class="icon-remove bigger-120"></i>
								</div> </a>
								<div class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewuser<?php echo $invInventory['InvInventory']['id'];?>">
									<i class="icon-zoom-in bigger-120"></i>
								</div>
								<div class="btn btn-xs btn-info edit edit-row on-load" title="Edit">
									<i class="icon-edit bigger-120"></i>
								</div>
								<!--button class="btn btn-xs btn-danger delete on-load delete-row" title="Delete" data-toggle="modal" data-target="#deleteitem">
									<i class="icon-trash bigger-120"></i>
								</button-->
								<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('controller'=>'inventories','action'=>'delete',$invInventory['InvInventory']['id'],$pages,$itemName,$minPrice,$maxPrice,$inHand),array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure you want to remove '.$invInventory['InvInventory']['name'].' from the system?'));?>
								
							</div></td>
							
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
											<?php/* if($permission['_update'] == 1 || $permission['_delete'] == 1):*/?>
											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
														
														<li>
															<?php /*if($permission['_update'] == 1):*/?> 
																<a class="btn btn-xs btn-info edit edit-row on-load on-edit" title="Edit" >
																	<i class="icon-edit bigger-120"></i>
																</a>
															<?php /*endif;*/?>
														</li>
	
														<li>
															<?php /*if($permission['_delete'] == 1):*/?>
																<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('controller'=>'inventories','action'=>'delete',$invInventory['InvInventory']['id'],$pages,$itemName,$minPrice,$maxPrice,$inHand),array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure you want to remove '.$invInventory['InvInventory']['name'].' from the system?'));?>
															<?php /*endif;*/?>
														</li>
													</ul>	
											<?php /*endif;*/?>
											
										</div>
									</div>
                                </div>
                             </div>
                             
                             
								
								
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Item Name
                                </div>
                                <div class="col-xs-7 font13 wordwrap">
                                	<span class="on-load">
									<?php echo $invInventory['InvInventory']['name'];?>
								</span>
								<?php echo $this->Form->input('InvInventory.'.$invInventory['InvInventory']['id'].'.name',array('div'=>false,'label'=>false,'class'=>'on-edit','value'=>$invInventory['InvInventory']['name'],'placeholder'=>'Inventory Name'));?>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Description
                                </div>
                                <div class="col-xs-7 font13">
                                	<span class="on-load"><?php echo $invInventory['InvInventory']['description'];?></span>
								<?php echo $this->Form->input('InvInventory.'.$invInventory['InvInventory']['id'].'.description',array('div'=>false,'label'=>false,'class'=>'on-edit','value'=>$invInventory['InvInventory']['description'],'placeholder'=>'Description'));?>
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
								<?php echo $this->Form->input('InvInventory.'.$invInventory['InvInventory']['id'].'.list_price',array('div'=>false,'label'=>false,'type'=>'text','class'=>'on-edit','value'=>$invInventory['InvInventory']['list_price'],'placeholder'=>'Inventory Price'));?>
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
								<?php echo $this->Form->input('InvInventory.'.$invInventory['InvInventory']['id'].'.current_stock',array('div'=>false,'label'=>false,'class'=>'on-edit','type'=>'text','value'=>$invInventory['InvInventory']['current_stock'],'placeholder'=>'Inventory Stock'));?>
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
							
							
							
							
							<div class="modal fade" id="viewuser<?php echo $invInventory['InvInventory']['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									     <div class="modal-dialog">
									          <div class="modal-content">
									               <div class="modal-header page-header">       
									                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
									                    <h1 class="modal-title" id="myModalLabel"><?php echo __('View Inventory');?></h1>    
									               </div>
												   <div class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
													    <div class="modal-body">
													          <div class="model-body-inner-content">  
														           <div class="form-group login-form-group">
																         <label class="col-sm-4 no-padding-top"><?php echo __('Item Name');?> </label>    
																         <div class="col-sm-8">
																		    <p class="bold"><?php echo $invInventory['InvInventory']['name'];?></p>
																		 </div>
																   </div>
																   <div class="form-group login-form-group"> 
																		<label class="col-sm-4 no-padding-top"> <?php echo __('Description');?> </label>   
																		<div class="col-sm-8">
																		  <p class="bold"><?php echo $invInventory['InvInventory']['description']; ?></p>
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
															  </div>
													     </div>
													  <div class="modal-footer"></div>           
													</div>
									         </div>
									     </div>
									</div>
<?php echo $this->Js->writeBuffer();?>