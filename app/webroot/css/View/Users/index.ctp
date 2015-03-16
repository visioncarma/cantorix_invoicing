<?php echo $this->Session->flash();?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript" src="">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
	$settings = $this->Breadcrumb->getLink('Settings');
?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		<li class="active">
			Users
		</li>
	</ul><!-- .breadcrumb -->
</div>





<div class="page-content">
			<div class="page-header">
				<h1> User Management </h1>
				<?php if($showAddButton && $permission['_create'] == 1):?>
				<div class="col-lg-2 paddingleftrightzero">
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
			<div class="table-responsive table-responsivenoscroll tablehidemobilee">
				<div class="table-header">
					Users List
				</div>
				<div class="row margin-twenty-zero filterdivmob">
					<?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
					
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-lg-2 col-sm-3 nopadding">
						<?php echo $this->Form->input('username',array('class'=>'form-control','placeholder'=>'User Name'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-lg-2  col-sm-3  nopadding">
						<?php echo $this->Form->input('email1',array('class'=>'form-control','placeholder'=>'Email'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 nopadding  col-sm-3  col-lg-2">
						<?php echo $this->Form->input('role',array('class'=>'form-control selectpicker','data-placeholder'=>'Role','options'=>array(''=>'--Role--',$usergroups)));?>	
                    </div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Js->submit('Filter',array('url'=>array('controller'=>'users','action'=>'index'),'class'=>'btn btn-sm btn-primary filter-btn form-control','type'=>'submit','update'=>'#pageContent'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero resetbutton">
						<?php echo $this->Js->link('Reset',array('controller'=>'users','action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn form-control','update'=>'#pageContent','title'=>'Reset filtered result'));?>
					</div>
					<?php echo $this->Form->end();?>
				</div>
			
				<?php echo $this->Form->create('User',array('url'=>array('controller'=>'users','action'=>'index'),'id'=>'User','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'on-edit')));?>
				 <div  class="row magin-delete-all hidden-480">
                 <span class="deleteicon delete" title="Delete All"><i class="icon-trash bigger-120" style="color:#B74635;"></i></span>
                </div>
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<th><label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label></th>
							<th>User Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Active</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($users as $user):?>
						<?php echo $this->Form->hidden($user['User']['id'].'.id',array('value'=>$user['User']['id']));?>
						<tr id="tr-<?php echo $user['User']['id'];?>">
							
						<td>
							<span class=""> 
								<label>
									<input class="ace delete-m-row" type="checkbox">
									
									<span class="lbl"></span> 
								</label> 
							</span>
						</td>
						<td>
							<span class="on-load"><?php echo $user['User']['username'];?></span>
							<?php if($permission['_update'] == '1'):?>
								<?php echo $this->Form->input($user['User']['id'].'.username',array('id'=>'username'.$user['User']['id'],'placeholder'=>'User Name','value'=>$user['User']['username'],'disabled'=>'disabled'));?>
								<?php echo $this->Form->hidden($user['User']['id'].'.username',array('value'=>$user['User']['username']));?>
							<?php endif;?>
						</td>
						<td>
							<span class="on-load"><?php echo $user['User']['email'];?></span>
							<?php if($permission['_update'] == '1'):?>
								<?php echo $this->Form->input($user['User']['id'].'.email',array('id'=>'em'.$user['User']['id'],'placeholder'=>'Email','value'=>$user['User']['email'],'disabled'=>'disabled'));?>
								<?php echo $this->Form->hidden($user['User']['id'].'.email',array('value'=>$user['User']['email']));?>
							<?php endif;?>
						</td>
							
						<td>
							<span class="on-load"><?php echo $user['usergroup_details']['Aro']['alias'];?></span>
							<?php if($permission['_update'] == '1'):?>
							<span class="on-edit inlineeditselectpick">	<?php echo $this->Form->input($user['User']['id'].'.aro_id',array('class'=>'selectpicker ','options'=>array($usergroups),'placeholder'=>'Role','data-placeholder'=>'Role','default'=>$user['usergroup_details']['Aro']['id']));?></span>
							<?php endif;?>
						</td>
						<td>
							<span class="on-load"><?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?></span>
							<?php if(($permission['_update'] == '1' && $showAddButton) || $planDetails['CpnSubscriptionPlan']['no_of_staffs'] == count($users)):?>
								<span class="on-edit inlineeditselectpick"> <?php echo $this->Form->input($user['User']['id'].'.active',array('class'=>'selectpicker','data-placeholder'=>'Active','options'=>array('Y'=>'Yes','N'=>'No'),'default'=>$user['User']['active']));?> </span>
							<?php elseif($permission['_update'] == '1' && !$showAddButton):?>
								<span class="on-edit inlineeditselectpick"> <?php echo $this->Form->input($user['User']['id'].'.active',array('class'=>'selectpicker','data-placeholder'=>'Active','options'=>array('Y'=>'Yes','N'=>'No'),'default'=>$user['User']['active'],'disabled'=>TRUE));?> </span>
							<?php endif;?>
						</td>
						<td>
								<div class="visible-md visible-lg visible-sm hidden-xs btn-group">
									<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
										<?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn','url' => array('controller'=>'users','action' => 'edit',$user['User']['id'],$subscriberID),'escape'=>false,'update' => '#tr-'.$user['User']['id'], 'title' => 'Save','id' => 'submit-'.$user['User']['id']));?>
										<button class="btn btn-xs close-action" title="Cancel" type="reset">
											<i class="icon-remove bigger-120"></i>
										</button> 
									</a>
									<button class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewuser<?php echo $user['User']['id'];?>">
										<i class="icon-zoom-in bigger-120"></i>
									</button>
									<?php if($permission['_update'] == '1' && $adminUser['User']['id'] !=$user['User']['id']):?>
										<a class="btn btn-xs btn-info edit edit-row on-load" title="Edit">
											<i class="icon-edit bigger-120"></i>
										</a>
									<?php endif;?>									
									<?php if($permission['_delete'] == '1' && $adminUser['User']['id'] !=$user['User']['id']):?>
									<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('action' => 'delete', $user['User']['id'],$subscriberID), array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete user ?')); ?>
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
													<label class="col-sm-3 col-xs-5 no-padding-top"> First Name </label>
													<div class="col-sm-9 col-xs-7">
														<p class="bold">
															<?php echo $user['User']['firstname'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top col-xs-5"> Last Name </label>
													<div class="col-sm-9 col-xs-7">
														<p class="bold">
															<?php echo $user['User']['lastname'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top col-xs-5"> Email </label>
													<div class="col-sm-9 col-xs-7 wordwrap">
														<p class="bold">
															<?php echo $user['User']['email'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top col-xs-5"> Role</label>
													<div class="col-sm-9 col-xs-7">
														<p class="bold">
															<?php echo $user['usergroup_details']['Aro']['alias'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top col-xs-5">User Name </label>
													<div class="col-sm-9 col-xs-7">
														<p class="bold">
															<?php echo $user['User']['username'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top col-xs-5">Active</label>
													<div class="col-sm-9 col-xs-7">
														<p class="bold">
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
                                         <span class="deleteicon delete pull-right" title="Delete All">
                                          <i class="icon-trash bigger-120" style="color:#d15b47;"></i>
                                         </span> 
                                     </span>
                                     </div>
                                </div>
                          </div>
                          <?php foreach($users as $user){?>
                          <div class="row marginleftrightzero nopaddingleft nopaddingright borderfull paddingtopbottom5 contentrow borderbottom">
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
													<label class="col-sm-3 col-xs-5 no-padding-top"> First Name </label>
													<div class="col-sm-9 col-xs-7">
														<p class="bold">
															<?php echo $user['User']['firstname'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top col-xs-5"> Last Name </label>
													<div class="col-sm-9 col-xs-7">
														<p class="bold">
															<?php echo $user['User']['lastname'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top col-xs-5"> Email </label>
													<div class="col-sm-9 col-xs-7 wordwrap">
														<p class="bold">
															<?php echo $user['User']['email'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top col-xs-5"> Role</label>
													<div class="col-sm-9 col-xs-7">
														<p class="bold">
															<?php echo $user['usergroup_details']['Aro']['alias'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top col-xs-5">User Name </label>
													<div class="col-sm-9 col-xs-7">
														<p class="bold">
															<?php echo $user['User']['username'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top col-xs-5">Active</label>
													<div class="col-sm-9 col-xs-7">
														<p class="bold">
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
                                    	<div class="inline position-relative">
                                    		
                                    		
                                    		<button class="btn btn-minier btn-info dropdown-toggle" data-toggle="dropdown">
												<i class="icon-cog icon-only bigger-120"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
												<li>
													<a href="javascript:void(0)" class="btn btn-xs btn-success view on-load"  title="View" data-toggle="modal" data-target="#viewusermobile<?php echo $user['User']['id'];?>">
													
														<i class="icon-zoom-in bigger-120"></i>
													
													</a>
											
												</li>

												<li>
													<?php if($permission['_update'] == '1' && $adminUser['User']['id'] !=$user['User']['id']):?>
													<a class="btn btn-xs btn-info edit edit-row on-load" title="Edit">
														<i class="icon-edit bigger-120"></i>
													</a>
													<?php endif;?>
												</li>

												<li>
													<?php if($permission['_delete'] == '1' && $adminUser['User']['id'] !=$user['User']['id']):?>
													<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',
																array('action' => 'delete', $user['User']['id'],$subscriberID), array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete user ?')); ?>
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
                                  <span class="on-load">  <?php echo $user['User']['username'];?> </span>
                                   <?php echo $this->Form->input($user['User']['id'].'.username',array('div'=>false,'label'=>false,'type'=>'text','class'=>'on-edit','placeholder'=>'Username','disabled'=>'disabled','value'=> $user['User']['username']))?>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                      Email
                                </div>
                                <div class="col-xs-7 font13">
                                	  <span class="on-load">  <?php echo $user['User']['email']; ?> </span>
                                	   <?php echo $this->Form->input($user['User']['email'].'.email',array('div'=>false,'label'=>false,'type'=>'text','class'=>'on-edit','placeholder'=>'email','disabled'=>'disabled','value'=> $user['User']['email']))?>                                   
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Role
                                </div>
                                <div class="col-xs-7 font13">
                                	<span class="on-load">  <?php echo  $user['usergroup_details']['Aro']['alias']; ?> </span>
                                  <span class="on-edit oneditnew inlineeditselectpick">     <?php echo $this->Form->input($user['User']['id'].'.aro_id',array('class'=>'selectpicker','options'=>array($usergroups),'placeholder'=>'Role','data-placeholder'=>'Role','default'=>$user['usergroup_details']['Aro']['id']));?> </span>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Active
                                </div>
                                <div class="col-xs-7 font13">
                                  <span class="on-load">   <?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?> </span>
                                  <span class="on-edit oneditnew inlineeditselectpick">    <?php echo $this->Form->input($user['User']['id'].'.active',array('class'=>'selectpicker ','data-placeholder'=>'Active','options'=>array('Y'=>'Yes','N'=>'No'),'default'=>$user['User']['active']));?></span>
                                </div>
                             </div>
                             
                             <div class="col-xs-4 pull-right">
								<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
									<?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn bgwhitee ','url' => array('controller'=>'users','action' => 'edit',$user['User']['id'],$subscriberID),'escape'=>false,'update' => '#tr-'.$user['User']['id'], 'title' => 'Save','id' => 'submit-'.$user['User']['id']));?>
									<button class="btn btn-xs close-action" title="Cancel" type="reset">
										<i class="icon-remove bigger-120"></i>
									</button> 
								</a>
								
								
							</div>
                          </div>  
                          
                          <?php }?>
                         
                          
                          
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
									if($userName || $emailId || $role) {
										$url = array('action'=>'index',0,$userName,$emailId,$role);
									} else {
										$url = array('action'=>'index');
									}
									$this->Paginator->options(array(
					 					'update' => '#pageContent',
										'evalScripts' => TRUE,
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

<?php if($showAddButton):?>
<!--Popup add  -->
<div class="modal fade" id="addnewuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header page-header">       
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
         <h1 class="modal-title" id="myModalLabel">Add New User</h1>    
      </div>      
      	<?php echo $this->Form->create('UserNew',array('url'=>array('controller'=>'users','action'=>'index'),'inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control'),'id'=>'NewUser','class'=>'form-horizontal popup'));?>
      <div class="modal-body">
         <div class="model-body-inner-content">  
         			<div class="form-group login-form-group"> 
                    	<p>Each user you add will receive an email inviting them to log in.</p>
                  	</div>            
                  <div class="form-group login-form-group">
                    <label class="col-sm-4 control-label">Role </label>    
                    <div class="col-sm-8 margin-bottom-zero form-filter-field  nopadding nopaddingleft nopaddingright no-border">
                    	<?php echo $this->Form->input('role_id',array('class'=>'form-control selectpicker','options'=>array(''=>'--Role--',$usergroups)));?>
                    </div>
                  </div>
                  <div class="form-group login-form-group "> 
                    <label class="col-sm-4 control-label"> First Name </label>   
                    <div class="col-sm-8 nopaddingleft nopaddingright">
                    	<?php echo $this->Form->input('firstname',array('placeholder'=>'First Name', 'autocomplete'=>"off"));?>
                    </div>
                  </div> 
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label"> Last Name </label>   
                    <div class="col-sm-8 nopaddingleft nopaddingright">
                    	<?php echo $this->Form->input('lastname',array('placeholder'=>'Last Name', 'autocomplete'=>"off"));?>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label"> Email </label>   
                    <div class="col-sm-8 nopaddingleft nopaddingright">
                      <?php echo $this->Form->input('email',array('id'=>'email','placeholder'=>'Email', 'autocomplete'=>"off"));?>
						<label for="form-field-1" class="error"></label>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label"> User Name </label>   
                    <div class="col-sm-8 nopaddingleft nopaddingright">
                    	<?php echo $this->Form->input('username',array('placeholder'=>'User Name', 'autocomplete'=>"off"));?>
                    	<label for="form-field-1" class="error"></label>
                    </div>
                  </div>
                                                            
                                             
          </div>
      </div>
      <div class="modal-footer">
      		<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('class'=>'btn btn-info','type'=>'submit'));?>       
            <?php echo $this->Form->button('<i class="icon-undo bigger-110"></i>Reset',array('class'=>'btn btn-inverse','type'=>'reset'));?>
      </div>
     <?php $this->Form->end(); ?>
    </div>
  </div>
</div>
<!--end of pop--> 


<script type="text/javascript">
jQuery(function($) {
		$(".chosen-select").chosen();
	});

	$(document).ready(function(){
		
		$('.selectpicker').selectpicker().change(function(){
        	$(this).valid()
		});
		
	  $("#NewUser").validate({
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
				checkEmailAvailability: true
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
				checkUserNameAvailability : "User Name already exist."
			}
		 }
	});	
	<?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
		$protocol_final = 'https';
	} else {
	  	$protocol_final = 'http';
	} ?>
	$.validator.addMethod("checkEmailAvailability",function(value,element){				
		var x = $.ajax({
			    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>users/validateUserEmail/add",
			    type: 'POST',
			    async: false,
			    data: $("#NewUser").serialize()
		 	}).responseText;	 	
			if(x=="false") return false;
			else return true;
		});
		
	$.validator.addMethod("checkUserNameAvailability",function(value,element){				
		var y= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>users/checkUserNameAvailability/",
		    type: 'POST',
		    async: false,
		    data: $("#NewUser").serialize()
		 }).responseText;	 	
		 if(y=="false") return false;
		 else return true;
		});	
		
 });
</script>
<?php endif;?>

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