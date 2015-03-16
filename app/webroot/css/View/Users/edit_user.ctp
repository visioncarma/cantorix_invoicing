<?php $this->Form->inputDefaults(array('div'=>FALSE,'label'=>FALSE,'class'=>'on-edit'));?>
<?php if($action != 'view'):?>
<td>
	<span class=""> 
		<label>
			<input class="ace delete-m-row" type="checkbox">
			
			<span class="lbl"></span> 
		</label> 
	</span>
</td>
<?php endif;?>
<td>
	<span class="on-load"><?php echo $user['User']['username'];?></span>
	<?php if($permission['_update'] == '1'):?>
		<?php echo $this->Form->input('User.'.$user['User']['id'].'.username',array('id'=>'username'.$user['User']['id'],'placeholder'=>'User Name','value'=>$user['User']['username'],'disabled'=>'disabled'));?>
		<?php echo $this->Form->hidden('User.'.$user['User']['id'].'.username',array('value'=>$user['User']['username']));?>
	<?php endif;?>
</td>
<td>
	<span class="on-load"><?php echo $user['User']['email'];?></span>
	<?php if($permission['_update'] == '1'):?>
		<?php echo $this->Form->input('User.'.$user['User']['id'].'.email',array('id'=>'em'.$user['User']['id'],'placeholder'=>'Email','value'=>$user['User']['email'],'disabled'=>'disabled'));?>
		<?php echo $this->Form->hidden('User.'.$user['User']['id'].'.email',array('value'=>$user['User']['email']));?>
	<?php endif;?>
</td>
<td>
	<span class="on-load"><?php echo $usergroups[$user['usergroup_details']['Aro']['id']];?></span>
	<?php if($permission['_update'] == '1'):?>
		<?php echo $this->Form->input('User.'.$user['User']['id'].'.aro_id',array('options'=>array($usergroups),'placeholder'=>'Role','data-placeholder'=>'Role','default'=>$user['usergroup_details']['Aro']['id']));?>
	<?php endif;?>
</td>
<td>
	<span class="on-load"><?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?></span>
	<?php if($permission['_update'] == '1'):?>
		<?php echo $this->Form->input('User.'.$user['User']['id'].'.active',array('class'=>'on-edit','data-placeholder'=>'Active','options'=>array('Y'=>'Yes','N'=>'No'),'default'=>$user['User']['active']));?>
	<?php endif;?>
</td>

<td>
	<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
		<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
			
			<?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn','url' => array('controller'=>'users','action' => 'editUser',$user['User']['id'],$action),'escape'=>false,'update' => '#tr-'.$user['User']['id'], 'title' => 'Save','id' => 'submit-'.$user['User']['id']));?>
			<button class="btn btn-xs close-action" title="Cancel" type="reset">
				<i class="icon-remove bigger-120"></i>
			</button> 
		</a>
		<?php if($action != 'view'):?>
		<button class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewuser<?php echo $user['User']['id'];?>">
			<i class="icon-zoom-in bigger-120"></i>
		</button>
		<?php endif;?>
		<?php if($permission['_update'] == '1'):?>
			<a class="btn btn-xs btn-info edit edit-row on-load" title="Edit">
				<i class="icon-edit bigger-120"></i>
			</a>
		<?php endif;?>
		<?php if($action != 'view' && $permission['_delete'] == 1):?>
		<?php echo $this->Form->postLink('<i class="icon-trash bigger-120"></i>',
					array('action' => 'deleteUser', $user['User']['id']), array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete user ?')); ?>
		<?php endif;?>
		<?php if($action == 'view' && $permission['_delete'] == 1):?>
			<?php echo $this->Js->link('<i class="icon-trash bigger-120"></i>',
						array('controller'=>'usergroups','action' => 'deleteUser',$id,$user['User']['id'],$page), array('update'=>'#content','class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE,'confirm'=>'Are you sure want to delete user?')); ?>		
		
		<?php endif;?>
		
	</div>
</td>
<?php echo $this->Js->writeBuffer();?>