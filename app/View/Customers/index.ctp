<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
?>
<?php echo $this->Session->flash();?>
<?php $page = $this->Paginator->current('AcrClient');?>
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
			<?php echo $this->Html->link('Customers', array('controller' => 'customers', 'action' => 'index'), array('div' => false,'escape' => false)); ?>
		</li>
		<li class="active">
			Manage Customers
		</li>
	</ul><!-- .breadcrumb -->
</div>
<?php 
	if($organization || $client || $email || $status) {
		$url = array('action'=>'index',$organization,$client,$email,$status,$page);
	} else {
		$url = array('action'=>'index');
	}
?>
<div class="page-content">
	<div class="page-header">
		<h1 class="managecustomer"> Manage Customers </h1>
		<?php if($permission['_create'] == 1 && $showAddButton){?>
		<div class="col-lg-6 col-sm-12 col-md-12  col-xs-12 paddingleftrightzero pull-right manage_customer">		
			<?php echo $this->Html->link('<i class="icon-plus"></i>Add Customer',array('action'=>'add'),array('class'=>'ipadmargin col-lg-4 col-xs-12 col-sm-12 col-md-4 btn btn-sm btn-success pull-right addbutton marginleft2 paddingnewadd','escape'=>FALSE));?>
		
			<?php echo $this->Html->link('<i class="icon-caret-down icon-on-right"></i>Import Customer',array('action'=>'show_excel'),array('class'=>'ipadmargin col-xs-12 col-lg-4 col-sm-12 col-md-4 btn btn-sm btn-success pull-right importbutton','escape'=>FALSE));?>
			
	   </div>
		<?php }?>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll overflowvisible tablehidemobilee">
				<div class="table-header">
					Customers List
				</div>
				<div class="row margin-twenty-zero filterdivmob">
					<?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
					<div class="form-group margin-bottom-zero col-xs-12 col-lg-2 col-md-12 col-sm-12 nopaddingmobile nopaddingleft nopaddingright paddingipad">
						<?php echo $this->Form->input('organization_name',array('class'=>'col-xs-12 form-control','placeholder'=>'Organisation Name'));?>
					</div>
					<div class="form-group margin-bottom-zero col-xs-12 col-lg-2 col-md-12 col-sm-12 nopaddingmobile nopaddingleft paddingright">
						<?php echo $this->Form->input('client_name',array('class'=>'col-xs-12 form-control','placeholder'=>'Customer Name'));?>
					</div>
					<div class="form-group margin-bottom-zero col-xs-12 col-lg-2 col-md-12 col-sm-12 nopaddingmobile nopaddingleft nopaddingright paddingipad">
						<?php echo $this->Form->input('email1',array('class'=>'col-xs-12 form-control','placeholder'=>'Contact Email'));?>
					</div>
					<!--<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->input('status',array('class'=>'chosen-select','data-placeholder'=>'Status','options'=>array('--Status--','active'=>'Active','inactive'=>'Inactive')));?>
						                           
					</div>-->
					
					<div class="form-group margin-bottom-zero form-filter-field col-xs-12 nopaddingmobile col-lg-2 col-md-12 col-sm-12 nopaddingleft paddingright choosen_width">                    	                    	
<?php echo $this->Form->input('status',array('class'=>'form-control invdrop col-xs-12 ','data-placeholder'=>'Select a Status','options'=>array('Select a Status','active'=>'Active','inactive'=>'Inactive')));?>                    	
                     </div>
					
					<div class="form-group filed-left margin-bottom-zero clearlefttrespon mobile_100">
						<?php echo $this->Js->submit('Filter',array('url'=>array('action'=>'index'),'class'=>'btn btn-sm btn-primary filter-btn form-control mobile_100','type'=>'submit','update'=>'#pageContent'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Html->link('Reset',array('action'=>'index',),array('class'=>'btn btn-sm btn-primary filter-btn form-control mobile_100','title'=>'Reset filtered result'));?>
					</div>
					<?php echo $this->Form->end();?>
				</div>
				<?php echo $this->Form->create('Client',array('url'=>array('controller'=>'Customers','action'=>'deleteAllCustomers'),'inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'on-edit')));?>			
				<div  class="row magin-delete-all hidden-480">
                 <?php 
                 	if($permission['_delete'] == '1') {
						echo $this->Form->submit('delete_selected.png',array('class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected','onclick'=>"return confirm('Are you sure you want to delete selected customers ?')"));
					}
				?>
                </div> 
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<th><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label></th>
							<th class="hidden-md visible-lg visible-sm  visible-xs btn-group"> <div ><?php echo $this->Paginator->sort('organization_name','Organisation Name',array('url'=>$url,'lock'=>TRUE));?></div></th>
							<th><div class="visible-md visible-lg visible-sm hidden-xs btn-group"><?php echo $this->Paginator->sort('client_name','Customer Name',array('url'=>$url,'lock'=>TRUE));?></div></th>
							<th><div class="visible-md visible-lg hidden-sm hidden-xs btn-group"> <?php echo $this->Paginator->sort('AcrClientContact.email','Contact Email',array('url'=>$url,'lock'=>TRUE));?></div></th>
							<th><div class="visible-md visible-lg visible-sm hidden-xs btn-group"><?php echo $this->Paginator->sort('business_phone','Business Phone',array('url'=>$url,'lock'=>TRUE));?> </div></th>
							<th><div class="visible-md visible-lg visible-sm hidden-xs btn-group"> <?php echo $this->Paginator->sort('status','Active',array('url'=>$url,'lock'=>TRUE));?> </div></th>
							<th><div class="visible-md visible-lg visible-sm visible-xs btn-group"> Action </div> </th>
						</tr>
					</thead>
					<tbody>
						
						<?php foreach($clients as $value){?>
						<tr>
							<td>
								<span class=""> 
									<label>
										<?php echo $this->Form->checkbox('Client.id.'.$value['AcrClient']['id'],array('label'=>FALSE,'div'=>FALSE,'class'=>'ace delete-m-row'));?>
										<span class="lbl"></span>
									</label>
								</span>
							</td>
							<?php //echo $this->Form->end();?>
							<td class="hidden-md">
								<span class="on-load clientname"><?php echo $value['AcrClient']['organization_name'];?></span>
							</td>
							<td>
								<div class="visible-md visible-lg visible-sm hidden-xs btn-group "><span class="on-load"><?php echo $value['AcrClientContact']['name'].' '.$value['AcrClientContact']['sur_name'];?></span></div>
							</td>
							
							<td>
								<div class="visible-md visible-lg hidden-sm hidden-xs btn-group"><span class="on-load"><?php echo $value['AcrClientContact']['email'];?></span></div>
							</td>
							<td>
								<div class="visible-md visible-lg visible-sm hidden-xs btn-group"><span class="on-load"><?php echo $value['AcrClient']['business_phone'];?></span></div>
							</td>
							<td>
								<div class="visible-md visible-lg hidden-sm visible-sm  btn-group"><span class="on-load" style="text-transform:capitalize;"><?php echo $value['AcrClient']['status'];?></span></div>
							</td>
							<td>
								<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<?php if($permission['_read'] == 1){
									echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$value['AcrClient']['id'],$subscriberID,$organization,$client,$email,$status,$page),array('class'=>'btn btn-xs btn-success view on-load','title'=>'View','escape'=>FALSE));
								} ?>
								<?php if($permission['_update'] == 1){
									echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit',$value['AcrClient']['id'],$subscriberID,$organization,$client,$email,$status,$page),array('class'=>'btn btn-xs btn-info edit on-load','title'=>'Edit','escape'=>FALSE));
								}?>
								<?php if($permission['_delete'] == 1){ ?>
									<?php //echo $this->Form->postLink('<i class="icon-trash bigger-120"></i>',array('action'=>'delete',$value['AcrClient']['id'],$organization,$client,$email,$status,$page),array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('If there is an invoice for the client,client will be made inactive otherwise client will be removed from the system.'));?>
									<button data-target="#deleteCustomer<?php echo $value['AcrClient']['id']?>" data-toggle="modal" class="btn btn-xs btn-danger delete on-load deletecustomer" title="Delete Customer">
										<i class="icon-trash bigger-120"></i>
									</button>
									
								<?php }?>
								</div>
								<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
										<li>
											<?php if($permission['_read'] == 1){
												echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$value['AcrClient']['id'],$subscriberID,$organization,$client,$email,$status,$page),array('class'=>'btn btn-xs btn-success view on-load padding1','title'=>'View','escape'=>FALSE));
												} ?>
										</li>

										<li>
											<?php if($permission['_update'] == 1){
											echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit',$value['AcrClient']['id'],$subscriberID,$organization,$client,$email,$status,$page),array('class'=>'btn btn-xs btn-info edit on-load padding1','title'=>'Edit','escape'=>FALSE));
											}?>
										</li>
										<?php if($permission['_delete'] == 1){?>
										<li>
											<button id="<?php echo $value['AcrClient']['id'];?>" data-target="#deleteCustomer" data-toggle="modal" class="btn btn-xs btn-danger delete on-load deletecustomer" title="Delete Customer">
												<i class="icon-trash bigger-120"></i>
											</button>
										</li>
										<?php }?>
									</ul>
								</div>
							</div>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<?php //echo $this->Form->end();?>
				


			</div>
			
			<!-- Only mobile -->
		
					<div class="table-small-view wordwrap">
                        <div class="row marginleftrightzero nopaddingleft nopaddingright borderfull header-small-view paddingtopbottom5">
                               <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                    <div class="col-xs-12">
                                        <span class="pull-left">
                                        <label>
                                            <input class="ace" type="checkbox">
                                            <span class="lbl"></span>
                                        </label>
                                     </span>
                                     <span  class="row magin-delete-all">
                                     	<?php 
						                 	if($permission['_delete'] == '1') {
												echo $this->Form->submit('delete_selected.png',array('class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected','onclick'=>"return confirm('Are you sure you want to delete selected customers ?')"));
											}
										?>
                                         <!--<span class="deleteicon delete pull-right" title="Delete All">
                                          <i class="icon-trash bigger-120" style="color:#d15b47;"></i>
                                         </span> --> 
                                     </span>
                                     </div>
                                </div>
                          </div>
                          <?php foreach($clients as $value){?>
                          <div class="row marginleftrightzero nopaddingleft nopaddingright borderfull paddingtopbottom5 contentrow borderbottom">
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5 parenttCLASS">
                                <div class="col-xs-6">
                                     <span class="pull-left">
                                        <label>
                                           <?php echo $this->Form->checkbox('Client.id.'.$value['AcrClient']['id'],array('label'=>FALSE,'div'=>FALSE,'class'=>'ace delete-m-row'));?>
                                            <span class="lbl"></span>
                                        </label>
                                     </span> 
                                </div>
                                <div class="col-xs-6">
                                    <div class="pull-right">
										<!--<div class="inline position-relative">
											<button class="btn btn-minier btn-info dropdown-toggle" data-toggle="dropdown">
												<i class="icon-cog icon-only bigger-120"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
												<li>
													<?php 
														if($permission['_read'] == 1){
															echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$value['AcrClient']['id'],$subscriberID,$organization,$client,$email,$status,$page),array('class'=>'btn btn-xs btn-success view on-load padding1','title'=>'View','escape'=>FALSE));
														} 	
													?>												
												</li>

												<li>
													<?php 
														if($permission['_update'] == 1){
															echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit',$value['AcrClient']['id'],$subscriberID,$organization,$client,$email,$status,$page),array('class'=>'btn btn-xs btn-info edit on-load padding1','title'=>'Edit','escape'=>FALSE));
														}
													?>
												</li>

												<?php if($permission['_delete'] == 1){?>
													<li>
														<button id="<?php echo $value['AcrClient']['id'];?>" data-target="#deleteCustomer<?php echo $value['AcrClient']['id']?>" data-toggle="modal" class="btn btn-xs btn-danger delete on-load deletecustomer" title="Delete Customer">
															<i class="icon-trash bigger-120"></i>
														</button>
													</li>
												<?php }?>
											</ul>
										</div> -->
									</div>
                                </div>
                             </div>
                             
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Organisation Name
                                </div>
                                <div class="col-xs-7 font13 wordwrap mobileClientName">
                                   <?php echo $value['AcrClient']['organization_name'];?>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Customer Name
                                </div>
                                <div class="col-xs-7 font13">
                                   <?php echo $value['AcrClient']['client_name'];?>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Contact Email
                                </div>
                                <div class="col-xs-7 font13">
                                   <?php echo $value['Contact']['AcrClientContact']['email'];?>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Business Phone
                                </div>
                                <div class="col-xs-7 font13">
                                   <?php echo $value['AcrClient']['business_phone'];?>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Active
                                </div>
                                <div class="col-xs-7 font13" style="text-transform:capitalize;">
                                   <?php echo $value['AcrClient']['status'];?>
                                </div>
                             </div>
                             
                              <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Action
                                </div>
                                <div class="col-xs-7 font13" style="text-transform:capitalize;">
                                  <div class="inline position-relative">
											<button class="btn btn-minier btn-info dropdown-toggle" data-toggle="dropdown">
												<i class="icon-cog icon-only bigger-120"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
												<li>
													<?php 
														if($permission['_read'] == 1){
															echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$value['AcrClient']['id'],$subscriberID,$organization,$client,$email,$status,$page),array('class'=>'btn btn-xs btn-success view on-load padding1','title'=>'View','escape'=>FALSE));
														} 	
													?>												
												</li>

												<li>
													<?php 
														if($permission['_update'] == 1){
															echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit',$value['AcrClient']['id'],$subscriberID,$organization,$client,$email,$status,$page),array('class'=>'btn btn-xs btn-info edit on-load padding1','title'=>'Edit','escape'=>FALSE));
														}
													?>
												</li>

												<?php if($permission['_delete'] == 1){?>
													<li>
														<button id="<?php echo $value['AcrClient']['id'];?>" data-target="#deleteCustomer<?php echo $value['AcrClient']['id']?>" data-toggle="modal" class="btn btn-xs btn-danger delete on-load deletecustomer" title="Delete Customer">
															<i class="icon-trash bigger-120"></i>
														</button>
													</li>
												<?php }?>
											</ul>
										</div>
                                </div>
                             </div>
                             
                          </div>  
                          
                          <?php }?>
                         
                          
                          
                           <!--<div class="row marginleftrightzero nopaddingleft nopaddingright borderfullrevert borderbottom header-small-view paddingtopbottom5">
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
                          </div>   -->                                   
                        </div>
                        
                        
                                            <!-- Only mobile -->
                                            
                                            
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
		
		
                                            
	</div>
</div><!-- /.page-content -->

	<!--Popup add  -->
									<div class="modal fade first"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									  <div class="modal-dialog">
									    <div class="modal-content">
									      <div class="modelinsidesubscriber">
									       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button> 
									      <form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
									      <div class="modal-body">
									         <div class="model-body-inner-content">  
									         	<div>
												 <h3 class="bolder red 22pfont center"> Delete Customer </h3>
												 <div class="center 14pfont paddingbottom">
												 	You are about to delete <span class="clientpopname">'<?php echo $value['AcrClient']['organization_name'];?>'</span>'.
												 </div>
												 <div class="space-12"></div>
												 
												 <div class="paddingleftrightzero padingleftneed buttoncenter">
														 	<button data-target="#deleteConfirmCustomer" data-toggle="modal" data-dismiss="modal" class="btn btn-sm paddingbtn-sm-ok btn-danger delete on-load okpopup">
																Ok
															</button>
												 		&nbsp;&nbsp;&nbsp;
												  			<button class="btn btn-sm btn-danger" data-dismiss="modal">
																Cancel
												   			</button>
												  
												</div>
												 <div class="space-6"></div>
												<p class="font13">
													<span class="bolder font13"> Please note: </span> If any invoices or quotes exist for this client then the client will be made inactive
												</p>
									            </div>			
									          </div>
									      </div>
									     
									        </form>
										  </div>
									    </div>
									  </div>
									 
									</div>
									<!--end of pop--> 
									
									
									
									 <!--Popup add  -->
									<div class="modal fade second" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									  <div class="modal-dialog ">
									    <div class="modal-content">
									      <div class="modelinsidesubscriber">
									       <!--<div class="pull-right"> <?php /*echo $this->Html->image('close_icon.png',array('class'=>'pointer','data-dismiss'=>'modal'));*/?> </div> --> 
									       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button> 
      
									      <form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
									      <div class="modal-body">
									         <div class="model-body-inner-content">  
									         	<div>
												 <h3 class="bolder red 22pfont center"> Confirm Delete</h3>
												 <div class="center 14pfont paddingbottom">
												 	You are about to delete <span class="clientpopname">''</span>.
												 	 
												 </div>
												 <div class="space-12"></div>
												 
												 <div class="paddingleftrightzero padingleftneed buttoncenter">
													<?php echo $this->Html->link('Delete',array('#'),array('class'=>'btn btn-sm btn-danger delete on-load paddingbtn-sm'));?>
													&nbsp;&nbsp;&nbsp;
													<button class="btn btn-sm btn-danger delete on-load" data-dismiss="modal">
														Cancel
											   		</button>
												</div>
												 <div class="space-6"></div>
												<p>
													<span class="bolder">&nbsp;&nbsp;&nbsp;&nbsp; </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												</p>
									            </div>			
									          </div>
									      </div>
									     
									        </form>
										  </div>
									    </div>
									  </div>
									</div>
									<!--end of pop--> 
									



<?php if($ajax){?>
	<script type="text/javascript">
		jQuery(function($) {
			//$(".chosen-select").chosen();
			
		});
	</script>
<?php }?>
<script type="text/javascript">
	
     $('table th input:checkbox').on('click' , function(){ 
		var that = this;
		$(this).closest('table').find('tr > td:first-child input:checkbox')
		.each(function(){
			this.checked = that.checked;
			$(this).closest('tr').toggleClass('selected');
		});
	});
</script>	
<script type="text/javascript">

 	/*$(document).click(function(event) {
 		
		if ( !$(event.target).hasClass('sbHolder') && !$(event.target).parents().hasClass('sbHolder')) {
			
			   $(".custom_select").selectbox('close'); 
		    }
	});*/
	
	 $(document).ready(function(){
	 	/*$(".custom_select").selectbox();*/
	 	var config = {
			  
			  '.invdrop' : {search_contains:true}
			}
			for (var selector in config) {
			  $(selector).chosen(config[selector]);
			}
	 	
	 	var clientname;
	 	$('.deletecustomer').click(function(){
	 		clientname = $(this).parents('tr').find('td span.clientname').text();
	 		if (!clientname.trim()) {
	 			clientname = $(this).parents('.parenttCLASS').next().children('.mobileClientName').text();
	 		}
	 		$('.clientpopname').text(clientname);
	 		var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(15,thislength);
	 		$('.modal.fade.first').attr('id','deleteCustomer'+thisid);
	 		$('.okpopup').attr('data-target','#deleteConfirmCustomer'+thisid);
	 	});
	 	$('.okpopup').click(function(){
	 		var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(22,thislength);
            $('.modal.fade.second').attr('id','deleteConfirmCustomer'+thisid);
	 		$('.btn.btn-sm.btn-danger.delete.on-load.paddingbtn-sm').attr('href',"<?php echo $this->webroot.'customers/delete/'.$subscriberID.'/';?>"+thisid+"<?php echo '/'.$organization.'/'.$client.'/'.$email.'/'.$status.'/'.$page;?>");
	 	});
	 	
	 	if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});
    	
    	}
    	
    	$('td .ace').change(function(){
    	 if($(this).prop('checked')==true)	
    		$(this).parents('tr').addClass('highlighted');
    	 else
    	    $(this).parents('tr').removeClass('highlighted');
    	});
    	
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

/** for responsive **/

$(document).ready(function(){
var flag=0;
var count=0;
$('.row.header-small-view .ace').change(function(){
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
$('.contentrow.row .ace').change(function(){
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
         
 $(document).ready(function(){
 $('.header-small-view input:checkbox').on('click' , function(){
		var that = this;
		$(this).parents('.row').siblings('.row').find('input:checkbox')
		.each(function(){
			this.checked = that.checked;
		});
			
});
	
});
/** for responsive **/
</script>

<?php echo $this->Js->writeBuffer();?>