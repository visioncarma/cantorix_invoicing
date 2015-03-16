<?php echo $this->Session->flash();?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript" src="">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="#">Home</a>
		</li>
		<li>
			<a href="#">Settings</a>
		</li>
		<li class="active">
			Manage Users
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1> User Management</h1>
		<div class="col-lg-2 paddingleftrightzero">
			<button class="btn btn-sm btn-success pull-right addbutton" data-toggle="modal" data-target="#addnewuser">
				<i class="icon-plus"></i>
				Add New User
			</button>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<div class="table-header">
					Users List
				</div>
				<div class="row margin-twenty-zero">
					<?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->input('username',array('placeholder'=>'Username'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->input('email1',array('placeholder'=>'Email'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->input('role',array('options'=>array(''=>'--Select--',$admin_roles),'class'=>'chosen-select'));?>	
                    </div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Form->button('Filter',array('class'=>'btn btn-sm btn-primary filter-btn','type'=>'submit','update'=>'#content'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero">
						<?php echo $this->Js->link('Reset',array('controller'=>'users','action'=>'manageUsers'),array('class'=>'btn btn-sm btn-primary filter-btn','update'=>'#content'));?>
					</div>
					<?php echo $this->Form->end();?>
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
							<?php echo $this->Form->create('User'.$user['User']['id'],array('url'=>array('controller'=>'users','action'=>'manageUsers',$user['User']['id']),'id'=>'User'.$user['User']['id'],'inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'on-edit')));?>
						<?php echo $this->Form->hidden('id',array('value'=>$user['User']['id']));?>
						<tr>
							
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
									<?php echo $this->Form->input('username',array('id'=>'username'.$user['User']['id'],'placeholder'=>'User Name','value'=>$user['User']['username'],'disabled'=>'disabled'));?>
									
								<?php endif;?>
							</td>
							<td>
								<span class="on-load"><?php echo $user['User']['email'];?></span>
								<?php if($permission['_update'] == '1'):?>
									<?php echo $this->Form->input('email',array('id'=>'em'.$user['User']['id'],'placeholder'=>'Email','value'=>$user['User']['email'],'disabled'=>'disabled'));?>
								<?php endif;?>
							</td>
							<td>
								<span class="on-load"><?php echo $user['usergroup_details']['Aro']['alias'];?></span>
								<?php if($permission['_update'] == '1'):?>
									<?php echo $this->Form->input('aro_id',array('options'=>array($usergroups),'placeholder'=>'Role','data-placeholder'=>'Role','default'=>$user['usergroup_details']['Aro']['id']));?>
								<?php endif;?>
							</td>
							<td>
								<span class="on-load"><?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?></span>
								<?php if($permission['_update'] == '1'):?>
									<?php echo $this->Form->input('active',array('class'=>'on-edit','data-placeholder'=>'Active','options'=>array('Y'=>'Yes','N'=>'No'),'default'=>$user['User']['active']));?>
								<?php endif;?>
							</td>
							
							<td>
								<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
									<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
										<?php echo $this->Js->submit('<i class="icon-ok bigger-120"></i>',array('tag'=>'button','div'=>FALSE,'class'=>'btn btn-xs submit','title'=>'Save','escape'=>FALSE));?>
										<button class="btn btn-xs close-action" title="Cancel" type="reset">
											<i class="icon-remove bigger-120"></i>
										</button> 
									</a>
									<button class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewuser<?php echo $user['User']['id'];?>">
										<i class="icon-zoom-in bigger-120"></i>
									</button>
									<?php if($permission['_update'] == '1'):?>
										<a class="btn btn-xs btn-info edit edit-row on-load" title="Edit">
											<i class="icon-edit bigger-120"></i>
										</a>
									<?php endif;?>
									<?php echo $this->Form->end();?>
									<?php if($permission['_delete'] == '1'):?>
										<?php echo $this->Form->postLink('<button class="btn btn-xs btn-danger delete on-load" title="Delete"><i class="icon-trash bigger-120"></i></button>',
												array('action' => 'deleteUser', $user['User']['id']), array('escape'=>FALSE), __('Are you sure want to delete user ?')); ?>
									<?php endif;?>
								</div>
							</td>
						</tr>
						<script type="text/javascript" src="">
							$(document).ready(function () {
								$("#User<?php echo $user['User']['id']?>").validate({
									rules: {
										'data[User<?php echo $user['User']['id']?>][email]': {
											required : true,
											email    : true	
										}
									},
									messages: {
										'data[User<?php echo $user['User']['id']?>][email]': {
											required : "Please enter email!",
											email    : "Please enter valid email!"	
										}
									}
								});
							});
						</script>
						
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
									<form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
										<div class="modal-body">
											<div class="model-body-inner-content">

												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top">User Name </label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $user['User']['username'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> Email </label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $user['User']['email'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"> Role</label>
													<div class="col-sm-8">
														<p class="bold">
															<?php echo $user['usergroup_details']['Aro']['alias'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-4 no-padding-top"><?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?></label>
													<div class="col-sm-8">
														<p class="bold">
															Yes
														</p>
													</div>
												</div>

											</div>
										</div>
										<div class="modal-footer">

										</div>
									</form>
								</div>
							</div>
						</div>
						<!--end of pop-->
						
						<?php endforeach;?>
					</tbody>
				</table>
				<div class="row">
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
										$url = array('action'=>'manageUsers',0,$userName,$emailId,$role);
									} else {
										$url = array('action'=>'manageUsers');
									}
									$this->Paginator->options(array(
					 					'update' => '#content',
										'evalScripts' => true,
										'url' => $url
									)); 
									echo $this->Paginator->prev('<i class="icon-double-angle-left"></i>', array('escape'=>false,'tag' => 'li'),'<a href="#"><i class="icon-double-angle-left"></i></a>', array('escape'=>false,'tag'=>'li'));
									echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentClass'=>'active','currentTag'=>'a'));
									echo $this->Paginator->next('<i class="icon-double-angle-right"></i>', array('escape'=>false,'tag' => 'li'),'<a href="#"><i class="icon-double-angle-right"></i></a>', array('escape'=>false,'tag'=>'li'));
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
      	<?php echo $this->Form->create('UserNew',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control'),'id'=>'asdfg','class'=>'form-horizontal popup'));?>
      <div class="modal-body">
         <div class="model-body-inner-content">  
         			<div class="form-group login-form-group"> 
                    	<p>Each user you add will receive an email inviting them to log in.</p>
                  	</div>            
                  <div class="form-group login-form-group">
                    <label class="col-sm-4 control-label">Role </label>    
                    <div class="col-sm-8">
                    	<?php echo $this->Form->input('role_id',array('options'=>array(''=>'--Select--',$usergroups)));?>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label"> First Name </label>   
                    <div class="col-sm-8">
                    	<?php echo $this->Form->input('firstname',array('placeholder'=>'First Name'));?>
                    </div>
                  </div> 
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label"> Last Name </label>   
                    <div class="col-sm-8">
                    	<?php echo $this->Form->input('lastname',array('placeholder'=>'Last Name'));?>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label"> Email </label>   
                    <div class="col-sm-8">
                      <?php echo $this->Form->input('email',array('id'=>'email','placeholder'=>'Email'));?>
                      <?php $this->Js->get('#email')->event('change',$this->Js->request(
          		     			array('controller'=>'users','action'=>'validateUserEmail','add	'), 
          		     			array('update'=>"#username-error", 'async'=>true, 'dataExpression'=>true, 'method'=>'post',
          							'data'=>$this->Js->serializeForm(array('isForm'=>true,'inline'=>true
								)))));
	              		?>
						<div id="username-error"></div>
                    </div>
                  </div>
                                                            
                                             
          </div>
      </div>
      <div class="modal-footer">
      		<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('class'=>'btn btn-info','type'=>'submit'));?>
            &nbsp; &nbsp; &nbsp;
            <?php echo $this->Form->button('<i class="icon-remove bigger-110"></i>Reset',array('class'=>'btn','type'=>'reset'));?>
      </div>
     <?php $this->Form->end(); ?>
    </div>
  </div>
</div>
<!--end of pop--> 


<script type="text/javascript" src="">
	$(document).ready(function(){
	  $("#asdfg").validate({
		 rules: {           
			'data[UserNew][role_id]' : {
				required : true
			},
			'data[UserNew][firstname]' : {
				required : true
			},
			'data[UserNew][email]': {
				required : true,
				email    : true
			},
			"data[UserNew][lastname]" : {
				required  : true
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
				email    : "Please enter valid email!"	
			},
			"data[UserNew][lastname]" : {
				required : "Please enter last name"
			}
		 }
	});	
  });
</script>


  
<script type="text/javascript">
jQuery(function($) {
	$(".chosen-select").chosen();
});
</script>
<?php echo $this->Js->writeBuffer();?>
