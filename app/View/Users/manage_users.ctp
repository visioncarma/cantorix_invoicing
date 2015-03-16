<?php echo $this->Session->flash();?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
	$settings = $this->Breadcrumb->getLink('Settings');
	if($userName || $emailId || $role) {
		$url = array('action'=>'manageUsers',0,$userName,$emailId,$role);
	} else {
		$url = array('action'=>'manageUsers');
	}
?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		<li class="active">
			Manage Users
		</li>
	</ul><!-- .breadcrumb -->
</div>





<div class="page-content">
			<div class="page-header">
				<h1 class="usermanagement"> User Management </h1>
				<?php if($permission['_create'] == '1'):?>
				<div class="col-lg-2 paddingleftrightzero mobiletop">
					<button class="btn btn-sm btn-success pull-right addbutton" data-toggle="modal" data-target="#addnewuser">
						<i class="icon-plus"></i>
						Add New User
					</button>
				</div>
				<?php endif;?>
			</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
				<div class="table-responsive filterdivmob overflowvisible tablehidemobilee" >
				<div class="table-header">
					Users List
				</div>
				<div class="row margin-twenty-zero">
					<?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-sm-4 nopadding col-lg-2">
						<?php echo $this->Form->input('username',array('class'=>'form-control','placeholder'=>'User Name'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-sm-4  nopadding col-lg-2">
						<?php echo $this->Form->input('email1',array('class'=>'form-control','placeholder'=>'Email'));?>
					</div>
					
                    
                    <div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-sm-3  nopadding col-lg-2 choosen_width admin_choosen">                    	                    	
                    	
                    	
                    	<?php echo $this->Form->input('role',array('class'=>'form-control invdrop','data-placeholder'=>'Role','options'=>array(''=>'',$admin_roles)));?>                    	
                     </div>
                     
					<div class="form-group filed-left margin-bottom-zero clearlefttrespon">
						<?php echo $this->Form->submit('Filter',array('url'=>array('action'=>'manageUsers'),'class'=>'btn btn-sm btn-primary filter-btn form-control','type'=>'submit'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero resetbutton">
						<?php echo $this->Html->link('Reset',array('action'=>'manageUsers'),array('class'=>'btn btn-sm btn-primary filter-btn form-control','title'=>'Reset filtered result'));?>
					</div>
					<?php echo $this->Form->end();?>
				</div>
				
				<?php echo $this->Form->create('User',array('url'=>array('controller'=>'users','action'=>'manageUsers'),'id'=>'User','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'on-edit')));?>
				<div  class="row magin-delete-all hidden-480">
				<?php
					if($permission['_delete'] == '1') {
						echo $this->Form->submit('delete_selected.png',array('url'=>array('action'=>'manageUsers'),'class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected', 'name' => 'DeleteSelected', 'value' => 'DeleteSelected','escape'=>FALSE,'onclick'=>"return confirm('Are you sure you want to delete selected users ?')", 'update'=>'#content'));
					}
				?>
                </div> 
                <table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table ">
					<thead>
						<tr>
							<th><label>
								<input class="ace delete-m-row" type="checkbox">
								<span class="lbl"></span> </label></th>
							<th class="hidden-xs"><?php echo $this->Paginator->sort('username','User Name',array('url'=>$url,'lock'=>TRUE));?></th>
							<th><?php echo $this->Paginator->sort('email','Email',array('url'=>$url,'lock'=>TRUE));?></th>
							<th class="hidden-xs"><?php echo $this->Paginator->sort('Aro.alias','Role',array('url'=>$url,'lock'=>TRUE));?></th>
							<th class="hidden-xs"><?php echo $this->Paginator->sort('active','Status',array('url'=>$url,'lock'=>TRUE)); ?></th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($users as $user):?>
							<?php echo $this->Form->hidden($user['User']['id'].'.id',array('value'=>$user['User']['id']));?>
							<tr id="tr-<?php echo $user['User']['id'];?>">
								<td>
										<span class="">
											<?php if($adminUser['Aro']['foreign_key'] != $user['User']['id']):?> 
											<label>
													<?php echo $this->Form->checkbox($user['User']['id'].'.delete',array('class'=>'ace'));?>
													<span class="lbl"></span> 
												</label>
											<?php endif;?> 
										</span>
								</td>
								<td class="hidden-xs">
										<span class="on-load"><?php echo $user['User']['username'];?></span>
										<?php if($permission['_update'] == '1'):?>
											<?php echo $this->Form->input($user['User']['id'].'.username',array('id'=>'username'.$user['User']['id'],'placeholder'=>'User Name','value'=>$user['User']['username'],'disabled'=>'disabled'));?>
											<?php echo $this->Form->hidden($user['User']['id'].'.username',array('value'=>$user['User']['username']));?>
										<?php endif;?>
								</td>
								<td >
									<span class="on-load"><?php echo $user['User']['email'];?></span>
									<?php if($permission['_update'] == '1'):?>
										<?php echo $this->Form->input($user['User']['id'].'.email',array('id'=>'em'.$user['User']['id'],'placeholder'=>'Email','value'=>$user['User']['email'],'disabled'=>'disabled'));?>
										<?php echo $this->Form->hidden($user['User']['id'].'.email',array('value'=>$user['User']['email']));?>
									<?php endif;?>
								</td>
								<td class="hidden-xs">
									<span class="on-load"><?php echo $user['usergroup_details']['Aro']['alias'];?></span>
									<?php if($permission['_update'] == '1'):?>
										<?php echo $this->Form->input($user['User']['id'].'.aro_id',array('options'=>array($admin_roles),'placeholder'=>'Role','data-placeholder'=>'Role','default'=>$user['usergroup_details']['Aro']['id']));?>
									<?php endif;?>
								</td>
								<td class="hidden-xs">
									<span class="on-load"><?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?></span>
									<?php if($permission['_update'] == '1'):?>
										<?php echo $this->Form->input($user['User']['id'].'.active',array('class'=>'on-edit','data-placeholder'=>'Active','options'=>array('Y'=>'Yes','N'=>'No'),'default'=>$user['User']['active']));?>
									<?php endif;?>
								</td>
								<td>
									<div class="btn-group">
										
										<?php if($permission['_update'] == '1' && $adminUser['Aro']['foreign_key'] != $user['User']['id']):?>
										<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
											<?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn','url' => array('controller'=>'users','action' => 'editUser',$user['User']['id']),'escape'=>false,'update' => '#tr-'.$user['User']['id'], 'title' => 'Save','id' => 'submit-'.$user['User']['id']));?>
											<button class="btn btn-xs close-action" title="Cancel" type="reset">
												<i class="icon-remove bigger-120"></i>
											</button> 
										</a>
										<?php endif;?>
										<button class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewuser<?php echo $user['User']['id'];?>">
											<i class="icon-zoom-in bigger-120"></i>
										</button>
										<?php if($permission['_update'] == '1' && $adminUser['Aro']['foreign_key'] != $user['User']['id']):?>
											<a class="btn btn-xs btn-info edit edit-row on-load" title="Edit">
												<i class="icon-edit bigger-120"></i>
											</a>
										<?php endif;?>
										
										
										<?php if($permission['_delete'] == '1' && $adminUser['Aro']['foreign_key'] != $user['User']['id']):?>
										<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',
													array('action' => 'deleteUser', $user['User']['id']), array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete user ?')); ?>
										<?php endif;?>
										
									</div>
									<!--Popup veiw  -->
									<div class="modal fade" id="viewuser<?php echo $user['User']['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header page-header">
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
															<i class="icon-remove"></i>
														</button>
														<h1 class="modal-title" id="myModalLabel">View User</h1>
												</div>
												<div class="form-horizontal popup">
														<div class="modal-body">
															<div class="model-body-inner-content">
																<div class="form-group login-form-group">
																	<label class="col-sm-3 no-padding-top wordwrap"> First Name </label>
																	<div class="col-sm-9">
																		<p class="bold wordwrap">
																			<?php echo $user['User']['firstname'];?>
																		</p>
																	</div>
																</div>
																<div class="form-group login-form-group">
																	<label class="col-sm-3 no-padding-top wordwrap"> Last Name </label>
																	<div class="col-sm-9">
																		<p class="bold wordwrap">
																			<?php echo $user['User']['lastname'];?>
																		</p>
																	</div>
																</div>
																<div class="form-group login-form-group">
																	<label class="col-sm-3 no-padding-top wordwrap"> Email </label>
																	<div class="col-sm-9">
																		<p class="bold wordwrap">
																			<?php echo $user['User']['email'];?>
																		</p>
																	</div>
																</div>
																<div class="form-group login-form-group">
																	<label class="col-sm-3 no-padding-top wordwrap"> Role</label>
																	<div class="col-sm-9">
																		<p class="bold wordwrap">
																			<?php echo $user['usergroup_details']['Aro']['alias'];?>
																		</p>  
																	</div>
																</div>
																<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top wordwrap">User Name </label>
													<div class="col-sm-9">
														<p class="bold wordwrap">
															<?php echo $user['User']['username'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top wordwrap">Active</label>
													<div class="col-sm-9">
														<p class="bold wordwrap">
															<?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?>
														</p>
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
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				<?php echo $this->Form->end();?>
				</div>
				
					<!-- Only mobile -->
				<div class="table-small-view wordwrap">
				<?php echo $this->Form->create('User',array('url'=>array('controller'=>'users','action'=>'manageUsers'),'id'=>'User','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'on-edit')));?>
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
	                      
	                          <?php $slno = null;?>
						  <?php foreach ($users as $user): ?>
						  <?php echo $this->Form->hidden($user['User']['id'].'.id',array('value'=>$user['User']['id']));?>
                          <div class="row marginleftrightzero nopaddingleft nopaddingright borderfull paddingtopbottom5 contentrow borderbottom">
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-6">
                                     <span class="pull-left">
                                     <?php if($adminUser['Aro']['foreign_key'] != $user['User']['id']):?> 
                                        <label>
                                            <?php echo $this->Form->checkbox($user['User']['id'].'.delete',array('class'=>'ace'));?>
                                            <span class="lbl"></span>
                                        </label>
                                     <?php endif;?>
                                     </span> 
                                </div>
                                <div class="col-xs-6">
                                    <div class="pull-right">
										<div class="inline position-relative">
											
											<!--Popup veiw  -->
						<div class="modal fade" id="viewusermobile<?php echo $user['User']['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header page-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
											<i class="icon-remove"></i>
										</button>
										<h1 class="modal-title" id="myModalLabel">View User</h1>
									</div>
									<div class="form-horizontal popup">
										<div class="modal-body">
											<div class="model-body-inner-content">
												
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top wordwrap"> First Name </label>
													<div class="col-sm-9">
														<p class="bold wordwrap">
															<?php echo $user['User']['firstname'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top wordwrap"> Last Name </label>
													<div class="col-sm-9">
														<p class="bold wordwrap">
															<?php echo $user['User']['lastname'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top wordwrap"> Email </label>
													<div class="col-sm-9">
														<p class="bold wordwrap">
															<?php echo $user['User']['email'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top wordwrap"> Role</label>
													<div class="col-sm-9">
														<p class="bold wordwrap">
															<?php echo $user['usergroup_details']['Aro']['alias'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top wordwrap">User Name </label>
													<div class="col-sm-9">
														<p class="bold wordwrap">
															<?php echo $user['User']['username'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top wordwrap">Active</label>
													<div class="col-sm-9">
														<p class="bold wordwrap">
															<?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?>
														</p>
													</div>
												</div>

											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
						<!--end of pop-->	
									
											<button class="btn btn-minier btn-info dropdown-toggle" data-toggle="dropdown">
												<i class="icon-cog icon-only bigger-120"></i>
											</button>
											
											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
														<li>
															<a class="btn btn-xs btn-success view on-load on-edit" title="View" data-toggle="modal" data-target="#viewusermobile<?php echo $user['User']['id'];?>">												
																<i class="icon-zoom-in bigger-120"></i>												
															</a>
														</li>
											
														<li>
															<?php if($permission['_update'] == '1' && $adminUser['Aro']['foreign_key'] != $user['User']['id']):?>
															<a class="btn btn-xs btn-info edit edit-row" title="Edit" >
																<i class="icon-edit bigger-120"></i>
															</a>
														<?php endif;?>
														</li>
	
														<li>
														<?php if($permission['_delete'] == '1' && $adminUser['Aro']['foreign_key'] != $user['User']['id']):?>
												<?php /*echo $this->Form->postLink('<button class="btn btn-xs btn-danger delete delete-row on-load" title="delete"><i class="icon-trash bigger-120"></i></button>',btn btn-xs btn-danger delete on-load array('controller'=>'Currencies','action' => 'delete', $cpnCurrency['CpnCurrency']['id']),array('id'=>'#sd'.$cpnCurrency['CpnCurrency']['id'],'escape'=>false),__('Are you sure you want to delete  %s?', $cpnCurrency['CpnCurrency']['name']));*/ ?>
												<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>', array('action' => 'delete', $cpnCurrency['CpnCurrency']['id'],$pages,$filterBy,$value),array('class'=>'btn btn-xs btn-danger delete','title'=>'Delete','escape'=>false),__('Are you sure you want to delete # %s?', $cpnCurrency['CpnCurrency']['name'])); ?>
											<?php endif;?>
														</li>
													</ul>	
											
											
										</div>
									</div>
                                </div>
                             </div>
                             
                             
								
								
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   User Name
                                </div>
                                <div class="col-xs-7 font13 wordwrap">
                                	<span class="on-load"><?php echo $user['User']['username'];?></span>
									<?php if($permission['_update'] == '1'):?>
										<?php echo $this->Form->input($user['User']['id'].'.username',array('id'=>'username'.$user['User']['id'],'placeholder'=>'User Name','value'=>$user['User']['username'],'disabled'=>'disabled'));?>
										<?php echo $this->Form->hidden($user['User']['id'].'.username',array('value'=>$user['User']['username']));?>
									<?php endif;?>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Email
                                </div>
                                <div class="col-xs-7 font13">
                                	<span class="on-load"><?php echo $user['User']['email'];?></span>
									<?php if($permission['_update'] == '1'):?>
										<?php echo $this->Form->input($user['User']['id'].'.email',array('id'=>'em'.$user['User']['id'],'placeholder'=>'Email','value'=>$user['User']['email'],'disabled'=>'disabled'));?>
										<?php echo $this->Form->hidden($user['User']['id'].'.email',array('value'=>$user['User']['email']));?>
									<?php endif;?>
                                </div>
                             </div>
                             
                               <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Role
                                </div>
                                <div class="col-xs-7 font13">
                                	<span class="on-load"><?php echo $user['usergroup_details']['Aro']['alias'];?></span>
									<?php if($permission['_update'] == '1'):?>
										<?php echo $this->Form->input($user['User']['id'].'.aro_id',array('options'=>array($admin_roles),'placeholder'=>'Role','data-placeholder'=>'Role','default'=>$user['usergroup_details']['Aro']['id']));?>
									<?php endif;?>
                                </div>
                             </div>
                             
                               <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Active
                                </div>
                                <div class="col-xs-7 font13">
                                	<span class="on-load"><?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?></span>
									<?php if($permission['_update'] == '1'):?>
										<?php echo $this->Form->input($user['User']['id'].'.active',array('class'=>'on-edit','data-placeholder'=>'Active','options'=>array('Y'=>'Yes','N'=>'No'),'default'=>$user['User']['active']));?>
									<?php endif;?>
                                </div>
                             </div>
                             
                             
                               <div class="col-xs-4 pull-right">
                              		<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
										<?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn','url' => array('controller'=>'users','action' => 'editUser',$user['User']['id']),'escape'=>false,'update' => '#tr-'.$user['User']['id'], 'title' => 'Save','id' => 'submit-'.$user['User']['id']));?>
										<div class="btn btn-xs close-action" title="Close">
											<i class="icon-remove bigger-120"></i>
										</div> 
									</a>
                              </div>
                          </div>  
                          <?php endforeach;?>
                                                    
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
                                     <?php
										if($permission['_delete'] == '1') {
											echo $this->Form->submit('delete_selected.png',array('url'=>array('action'=>'manageUsers'),'class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected', 'name' => 'DeleteSelected', 'value' => 'DeleteSelected','escape'=>FALSE,'onclick'=>"return confirm('Are you sure you want to delete selected users ?')", 'update'=>'#content'));
										}
									 ?>
                                     </span>
                                     </div>
                                </div>
                          </div>
                          <?php echo $this->Form->end();?>                                      
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
										'evalScripts' => TRUE,
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
	</div>

</div><!-- /.page-content -->

<!--Popup add  -->
<div class="modal fade" id="addnewuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header page-header">       
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
         <h1 class="modal-title" id="myModalLabel">Add New User</h1>    
      </div>      
      	<?php echo $this->Form->create('UserNew',array('url'=>array('controller'=>'users','action'=>'manageUsers'),'inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control'),'id'=>'asdfg','class'=>'form-horizontal popup'));?>
      <div class="modal-body">
         <div class="model-body-inner-content">  
         			<div class="form-group login-form-group"> 
                    	<p>Each user you add will receive an email inviting them to log in.</p>
                  	</div>            
                  <div class="form-group login-form-group">
                    <label class="col-sm-4 control-label col-sx-11 nopadding">Role </label>    
                    <div class="col-sm-8 col-sx-11 nopadding fullselect labelerror choosen_width">
                    	<?php echo $this->Form->input('role_id',array('class'=>'selectitem invdrop','data-placeholder'=>"Select Role",'options'=>array(''=>'',$admin_roles)));?>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label col-sx-11 nopadding"> First Name </label>   
                    <div class="col-sm-8 col-sx-11 nopadding">
                    	<?php echo $this->Form->input('firstname',array('placeholder'=>'First Name','autocomplete'=>'off'));?>
                    </div>
                  </div> 
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label col-sx-11 nopadding"> Last Name </label>   
                    <div class="col-sm-8 col-sx-11 nopadding">
                    	<?php echo $this->Form->input('lastname',array('placeholder'=>'Last Name' ,'autocomplete'=>'off'));?>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label col-sx-11 nopadding"> Email </label>   
                    <div class="col-sm-8 col-sx-11 nopadding">
                      <?php echo $this->Form->input('email',array('id'=>'email','placeholder'=>'Email','autocomplete'=>'off'));?>
                      <label for="form-field-1" class="error"></label>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label col-sx-11 nopadding"> User Name </label>   
                    <div class="col-sm-8 col-sx-11 nopadding">
                    	<?php echo $this->Form->input('username',array('placeholder'=>'User Name','autocomplete'=>'off'));?>
                    	<label for="form-field-1" class="error"></label>
                    </div>
                  </div>
                                                            
                                             
          </div>
      </div>
      <div class="modal-footer">
      		<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('class'=>'btn btn-info','type'=>'submit'));?>
            &nbsp; &nbsp; &nbsp;
            <?php echo $this->Form->button('<i class="icon-remove bigger-110"></i>Reset',array('class'=>'btn btn-inverse','type'=>'reset'));?>
      </div>
     <?php echo $this->Form->end(); ?>
    </div>
  </div>
</div>
<!--end of pop--> 


<script type="text/javascript">
jQuery(function($) {
	    $('body').on('click','.selectitem .dropdown-menu li',function(){
	      var thisvalue = $('.selectitem .btn .filter-option').text();
			if (thisvalue=="Select Role")
			   {
			   	 $(this).parents('.btn-group').siblings('label.error').show();
			   }
			   else{
			   	  $(this).parents('.btn-group').siblings('label.error').hide();
			   }
         });	
		//$(".chosen-select").chosen();
		 if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});
    	}
	});

	$(document).ready(function(){
		/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
		
		
	  $("#asdfg").validate({
	  	onkeyup: false,
	  	ignore:[],
		 rules: {           
			'data[UserNew][role_id]' : {
				required : true
			},
			'data[UserNew][firstname]' : {
				required : true
			},
			'data[UserNew][email]': {
				required : true,
				email    : true,
				checkEmailAvailability : true
			},
			"data[UserNew][username]" : {
				checkUserNameAvailability: true
			}
		 },
	 	 messages:{
		 	'data[UserNew][role_id]' : {
		 		required : "Please select any role" 
		 	},	 
			'data[UserNew][firstname]' : {
				required : "Please enter first name" 
			},
			'data[UserNew][email]': {
				required : "Please enter email!",
				email    : "Please enter valid email!",
				checkEmailAvailability : "Email already exist."
			},
			"data[UserNew][username]" : {
				checkUserNameAvailability : "User name already exist."
			}
		 }
	});
	<?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
			$protocol_final = 'https';
		} else {
		  	$protocol_final = 'http';
		} ?>
	$.validator.addMethod("checkEmailAvailability",function(value,element){				
		var x= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>users/validateUserEmail/add",
		    type: 'POST',
		    async: false,
		    data: $("#asdfg").serialize()
		 }).responseText;	 	
		 if(x=="false") return false;
		 else return true;
		});
		
	$.validator.addMethod("checkUserNameAvailability",function(value,element){				
		var y= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>users/checkUserNameAvailability/",
		    type: 'POST',
		    async: false,
		    data: $("#asdfg").serialize()
		 }).responseText;	 	
		 if(y=="false") return false;
		 else return true;
		});
 		
 });
</script>


<script type="text/javascript">
    $(document).ready(function(){ 
    	//Select all for checkbox for table
			$('table th input:checkbox').on('click' , function(){
				var that = this;
				$(this).closest('table').find('tr > td:first-child input:checkbox')
				.each(function(){
					this.checked = that.checked;
					$(this).closest('tr').toggleClass('selected');
				});					
			});
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
<!--/** for responsive **/-->
<script type="text/javascript">
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
</script>	
<?php echo $this->Js->writeBuffer();?>