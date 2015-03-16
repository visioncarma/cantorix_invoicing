<?php echo $this->Session->flash();?>
<?php $page = $this->Paginator->current('User');?>
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
?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		<li>
			<?php echo $this->Html->link('Manage Roles',array('action'=>'manageUsergroup'));?>
		</li>

		<li class="active">
			View Role
		</li>

	</ul><!-- .breadcrumb -->

</div>

<div class="page-content">
	<div class="page-header">
		<h1> View Role <span class="header-span"><i class="icon-double-angle-right"></i><?php echo $groupName['Aro']['alias'];?></span></h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'manageUsergroup'),array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right addbutton'));?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll">

				<div class="table-header">
					Module Access
				</div>

				<table id="sample-table-1" class="table table-striped table-bordered table-hover table_fixed_new">
					<thead>
						<tr>
							<th class="width300">Module Name</th>
							<th class="width150">View</th>
							<th class="width150">Create</th>
							<th class="width150">Update</th>
							<th class="width150">Admin</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($menus as $menu):?>
						<tr>
							<td class="bold"><?php echo $menu['Aco']['alias'];?></td>
							<td><span> <label>
									<?php echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._read',array('class'=>'ace','checked'=>$permission[$menu['Aco']['id']]['_read'],'disabled'=>'disabled'));?>
									<span class="lbl"></span> </label> </span></td>
							<td><span> <label>
									<?php echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._create',array('class'=>'ace','checked'=>$permission[$menu['Aco']['id']]['_create'],'disabled'=>'disabled'));?>
									<span class="lbl"></span> </label> </span></td>
							
							<td><span> <label>
									<?php echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._update',array('class'=>'ace','checked'=>$permission[$menu['Aco']['id']]['_update'],'disabled'=>'disabled'));?>
									<span class="lbl"></span> </label> </span></td>
							<td><span> <label>
									<?php echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._delete',array('class'=>'ace','checked'=>$permission[$menu['Aco']['id']]['_delete'],'disabled'=>'disabled'));?>
									<span class="lbl"></span> </label> </span></td>
						</tr>
						<?php foreach($menu['Child'] as $childMenu):?>
						<tr>
							<td>
							<p class="margin-left-15 margin-bottom-zero">
								<?php echo $childMenu['Aco']['alias'];?>
							</p></td>
							<td><span> <label>
									<?php echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._read',array('class'=>'ace','checked'=>$permission[$childMenu['Aco']['id']]['_read'],'disabled'=>'disabled'));?>
									<span class="lbl"></span> </label> </span></td>
							<td><span> <label>
									<?php echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._create',array('class'=>'ace','checked'=>$permission[$childMenu['Aco']['id']]['_create'],'disabled'=>'disabled'));?>
									<span class="lbl"></span> </label> </span></td>
							
							<td><span> <label>
									<?php echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._update',array('class'=>'ace','checked'=>$permission[$childMenu['Aco']['id']]['_update'],'disabled'=>'disabled'));?>
									<span class="lbl"></span> </label> </span></td>
							<td><span> <label>
									<?php echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._delete',array('class'=>'ace','checked'=>$permission[$childMenu['Aco']['id']]['_delete'],'disabled'=>'disabled'));?>
									<span class="lbl"></span> </label> </span></td>
						</tr>
						<?php endforeach;?>
						<?php endforeach;?>
					</tbody>
				</table>
				</div>
							
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="table-header">
					Role Users
				</div>
				<?php echo $this->Form->create('User',array('url'=>array('controller'=>'usergroups','action'=>'edit',$id,$user['User']['id']),'inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'on-edit')));?>
				<div class="table-responsive tablemobile_overflowhidd">	
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table table_fixed_new role_User_view">
					<thead>
						<tr>
							<th>User Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Active</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($users as $user): $i++;debug($i);?>
							<?php echo $this->Form->hidden($user['User']['id'].'.id',array('value'=>$user['User']['id']))?>
						<tr id="tr-<?php echo $user['User']['id'];?>">
							<td>
								<span class="on-load"><?php echo $user['User']['username'];?></span>
								<?php if($user['User']['id'] != $adminUser['Aro']['foreign_key']):?>
								<?php echo $this->Form->input($user['User']['id'].'.user_name',array('placeholder'=>'User Name','value'=>$user['User']['username'],'disabled'=>'disabled','class'=>'on-edit width100'));?>
								<?php echo $this->Form->hidden($user['User']['id'].'.username',array('value'=>$user['User']['username']));?>
								<?php endif;?>
							</td>
							<td>
								<span class="on-load"><?php echo $user['User']['email'];?></span>
								<?php if($user['User']['id'] != $adminUser['Aro']['foreign_key']):?>
								<?php echo $this->Form->input($user['User']['id'].'.email',array('placeholder'=>'Email','value'=>$user['User']['email'],'disabled'=>'disabled','class'=>'on-edit width100'));?>
								<?php echo $this->Form->hidden($user['User']['id'].'.email',array('value'=>$user['User']['email']));?>
								<?php endif;?>
							</td>
							<td class="dropdownuser">
								<span class="on-load"><?php echo $groupName['Aro']['alias'];?></span>
								<?php if($user['User']['id'] != $adminUser['Aro']['foreign_key']):?>
								<?php echo $this->Form->input($user['User']['id'].'.aro_id',array('class'=>'on-edit width100 selectpicker','data-placeholder'=>'Role','options'=>array($user_groups),'default'=>$groupName['Aro']['id']));?>
								<?php endif;?>
							</td>
							<td class="dropdownuser"><span class="on-load"><?php if($user['User']['active'] == 'Y') {echo 'Yes';} else { echo 'No'; }?></span>
								<?php if($user['User']['id'] != $adminUser['Aro']['foreign_key']):?>
								<?php echo $this->Form->input($user['User']['id'].'.active',array('class'=>'on-edit width100 selectpicker','data-placeholder'=>'Role','options'=>array('Y'=>'Yes','N'=>'No'),'default'=>$user['User']['active']));?>
								<?php endif;?>
							</td>
							<td>
								<div class="btn-group visible-md visible-lg">
									<?php if($user['User']['id'] != $adminUser['Aro']['foreign_key']):?>
									<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
										<?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn','url' => array('controller'=>'users','action' => 'editUser',$user['User']['id'],'view'),'escape'=>false,'update' => '#tr-'.$user['User']['id'], 'title' => 'Save','id' => 'submit-'.$user['User']['id']));?>
										<button class="btn btn-xs close-action" title="close" type="reset">
											<i class="icon-remove bigger-120"></i>
										</button> 
									</a>
									<?php endif;?>
									<?php if($userPermission['_update'] == 1 && $user['User']['id'] != $adminUser['Aro']['foreign_key']):?>
										<a class="btn btn-xs btn-info edit edit-row on-load" title="Edit">
											<i class="icon-edit bigger-120"></i>
										</a>
									<?php endif;?>
									
									<?php if($userPermission['_delete'] == 1 && $user['User']['id'] != $adminUser['Aro']['foreign_key']):?>
										<?php echo $this->Js->link('<i class="icon-trash bigger-120"></i>',
													array('controller'=>'usergroups','action' => 'deleteUser',$id,$user['User']['id'],0,$page), array('update'=>'#content','class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE,'confirm'=>'Are you sure want to delete user?')); ?>		
									<?php endif;?>
									
								</div>
								<div class="visible-xs visible-sm hidden-md hidden-lg">
									<div class="inline position-relative">
										<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
											<i class="icon-cog icon-only bigger-110"></i>
										</button>
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
											<li>
												<?php if($user['User']['id'] != $adminUser['Aro']['foreign_key']):?>
													<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
														<?php echo $this->Js->submit('', array('div'=>false,'class'=>'save-row submit greennn','url' => array('controller'=>'users','action' => 'editUser',$user['User']['id'],'view'),'escape'=>false,'update' => '#tr-'.$user['User']['id'], 'title' => 'Save','id' => 'submit-'.$user['User']['id']));?>
														<button class="btn btn-xs close-action" title="close" type="reset">
															<i class="icon-remove bigger-120"></i>
														</button> 
													</a>
												<?php endif;?>
											</li>
											<li>
												<?php if($userPermission['_update'] == 1 && $user['User']['id'] != $adminUser['Aro']['foreign_key']):?>
													<a class="btn btn-xs btn-info edit edit-row on-load" title="Edit">
														<i class="icon-edit bigger-120"></i>
													</a>
												<?php endif;?>
											</li>
											<li>
												<?php if($userPermission['_delete'] == 1 && $user['User']['id'] != $adminUser['Aro']['foreign_key']):?>
													<?php echo $this->Js->link('<i class="icon-trash bigger-120"></i>',
																array('controller'=>'usergroups','action' => 'deleteUser',$id,$user['User']['id'],0,$page), array('update'=>'#content','class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE,'confirm'=>'Are you sure want to delete user?')); ?>		
												<?php endif;?>
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
				<?php echo $this->Form->end();?>
			</div>
			</div>
			
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
									$url = array('action'=>'viewUsergroup',$id);
									$this->Paginator->options(array(
					 					'update' => '#content',
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

<script type="text/javascript">
jQuery(function($) {
	if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});
    	
    	}
	
});
</script>
<?php echo $this->Js->writeBuffer();?>