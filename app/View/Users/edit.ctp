<?php $this->Form->inputDefaults(array('div'=>FALSE,'label'=>FALSE,'class'=>'on-edit'));?>
<?php if($actionnnn != 'view'):?>
<td class="width10">
	<span class=""> 
		<label>
			<input class="ace delete-m-row" type="checkbox">
			
			<span class="lbl"></span> 
		</label> 
	</span>
</td>
<?php endif;?>
<td class="width120">
	<span class="on-load"><?php echo $user['User']['username'];?></span>
	<?php if($permission['_update'] == '1'):?>
		<?php echo $this->Form->input('User.'.$user['User']['id'].'.username',array('id'=>'username'.$user['User']['id'],'placeholder'=>'User Name','value'=>$user['User']['username'],'disabled'=>'disabled'));?>
		<?php echo $this->Form->hidden('User.'.$user['User']['id'].'.username',array('value'=>$user['User']['username']));?>
	<?php endif;?>
</td>
<td class="width120">
	<span class="on-load wordwrap"><?php echo $user['User']['email'];?></span>
	
	<?php if($permission['_update'] == '1'):?>
		<?php echo $this->Form->input('User.'.$user['User']['id'].'.email',array('id'=>'em'.$user['User']['id'],'placeholder'=>'Email','value'=>$user['User']['email'],'disabled'=>'disabled'));?>
		<?php echo $this->Form->hidden('User.'.$user['User']['id'].'.email',array('value'=>$user['User']['email']));?>
	<?php endif;?>
	
</td>
<td class="width120">
	<span class="on-load"><?php echo $usergroups[$user['usergroup_details']['Aro']['id']];?></span>
	<span class="on-edit inlinerole">
	<?php if($permission['_update'] == '1'):?>
		<?php echo $this->Form->input('User.'.$user['User']['id'].'.aro_id',array('class'=>'selectpicker','options'=>array($usergroups),'placeholder'=>'Role','data-placeholder'=>'Role','default'=>$user['usergroup_details']['Aro']['id']));?>
	<?php endif;?>
	</span>
</td>
<td class="width120">
	<span class="on-load"><?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?></span>
	<span class="on-edit inlineedit">
	<?php if($permission['_update'] == '1'):?>
		<?php echo $this->Form->input('User.'.$user['User']['id'].'.active',array('class'=>'selectpicker','data-placeholder'=>'Active','options'=>array('Y'=>'Yes','N'=>'No'),'default'=>$user['User']['active']));?>
	<?php endif;?>
	</span>
</td>

<td class="width120">
	<div class="btn-group">
		<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
			
			<?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn','url' => array('controller'=>'users','action' => 'edit',$user['User']['id'],$subsID,$actionnnn),'escape'=>false,'update' => '#tr-'.$user['User']['id'], 'title' => 'Save','id' => 'submit-'.$user['User']['id']));?>
			<!--<button class="btn btn-xs submit" title="Save" type="submit">
				<i class="icon-ok bigger-120"></i>
			</button> -->
			<button class="btn btn-xs close-action" title="Cancel" type="reset">
				<i class="icon-remove bigger-120"></i>
			</button> 
		</a>
		<?php if($actionnnn != 'view'):?>
		<button class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewuser<?php echo $user['User']['id'];?>">
			<i class="icon-zoom-in bigger-120"></i>
		</button>
		<?php endif;?>
		<?php if($permission['_update'] == '1'):?>
			<a class="btn btn-xs btn-info edit edit-row on-load" title="Edit">
				<i class="icon-edit bigger-120"></i>
			</a>
		<?php endif;?>
		<?php if($actionnnn != 'view' && $permission['_delete'] == 1):?>
		<?php echo $this->Form->postLink('<i class="icon-trash bigger-120"></i>',
					array('action' => 'delete', $user['User']['id'],$subsID), array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete user ?')); ?>
		<?php endif;?>
		<?php if($actionnnn == 'view' && $permission['_delete'] == 1):?>
			<?php echo $this->Js->link('<i class="icon-trash bigger-120"></i>',
						array('controller'=>'usergroups','action' => 'deleteUser',$id,$user['User']['id'],$subscriberID,$page), array('update'=>'#pageContent','class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE,'confirm'=>'Are you sure want to delete user?')); ?>		
		
		<?php endif;?>
		
	</div>
</td>
<!--Popup veiw  -->
						<div class="modal fade" id="viewuser<?php echo $user['User']['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog addcurrencymodel">
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
													<label class="col-sm-3 no-padding-top"> First Name </label>
													<div class="col-sm-9">
														<p class="bold">
															<?php echo $user['User']['firstname'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top"> Last Name </label>
													<div class="col-sm-9">
														<p class="bold">
															<?php echo $user['User']['lastname'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top"> Email </label>
													<div class="col-sm-9">
														<p class="bold">
															<?php echo $user['User']['email'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top"> Role</label>
													<div class="col-sm-9">
														<p class="bold">
															<?php echo $user['usergroup_details']['Aro']['alias'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top">User Name </label>
													<div class="col-sm-9">
														<p class="bold">
															<?php echo $user['User']['username'];?>
														</p>
													</div>
												</div>
												<div class="form-group login-form-group">
													<label class="col-sm-3 no-padding-top">Active</label>
													<div class="col-sm-9">
														<p class="bold">
															<?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?>
														</p>
													</div>
												</div>

											</div>
										</div>
										<div class="modal-footer">

										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end of pop-->
<?php echo $this->Js->writeBuffer();?>
<script type="text/javascript">
    $(document).ready(function(){ 
       	if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	} 
    	});
    	</script>   