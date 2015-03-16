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
		<li class="active">
			Manage Roles
		</li>
	</ul><!-- .breadcrumb -->
	</div>

	<div class="page-content">
		<div class="page-header">
			
			<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600 mobiletext-center">Manage Roles </div>
			<?php if($permission['_create'] == '1'):?>
			<div class="col-lg-8 col-md-7 col-sm-8 col-xs-8 no-padding-left no-padding-right width-after-600">
				<?php echo $this->Html->link('<i class="icon-plus"></i>Add New Role',array('controller'=>'usergroups','action'=>'addUsergroup'),array('class'=>'btn btn-sm btn-success pull-right addbutton width-after-400 addinvoice','escape'=>FALSE));?>
			</div>
			<?php endif;?>
		</div>
		<!-- /.page-header -->
		<div class="row">
			<div class="col-xs-12">
				<div class="table table-striped table-bordered table-hover editable-table">
				<?php echo $this->Form->create('User',array('url'=>array('controller'=>'usergroups','action'=>'deleteACAll'),'id'=>'User','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'on-edit')));?>
					<div class="table-header">
						Roles
					</div>
					<div  class="row magin-delete-all">
		                 <?php 
		                 	if($permission['_delete'] == '1') {
								echo $this->Form->submit('delete_selected.png',array('url'=>array('action'=>'manageUsergroup'),'class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected','escape'=>FALSE,'onclick'=>"return confirm('Are you sure you want to delete selected user roles and it\'s users ?')"));
							}
						 ?>
		            </div> 
					<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
						<thead>
							<tr>
								<th class="width10"><label>
									<input class="ace" type="checkbox">
									<span class="lbl"></span> </label></th>
								<th class="width400"><?php echo $this->Paginator->sort('Aro.alias','Role');?></th>
								<th class="width500">Number of Users</th>
								<th class="width100">Action</th>
							</tr>
						</thead>

						<tbody>
							<?php foreach($usergroups as $usergroup):?>
							<tr>
								<td>
									<span class=""> 
										<label>
											<?php
												if($permission['_delete'] == '1' && $adminUsergroup['Aro']['id'] != $usergroup['Aro']['id']) {
													echo $this->Form->checkbox('delete.'.$usergroup['Aro']['id'],array('class'=>'ace delete-m-row'));
												} 
											?>
											<span class="lbl"></span> 
										</label> 
									</span>
								</td>
								<td>
									<span class="on-load"><?php echo $usergroup['Aro']['alias'];?></span>
								</td>
								<td class="padding-left6">
									<span class="on-load"><?php echo $usergroup['users_count'];?></span>
								</td>
								<td>
									<div class="btn-group hidden-xs hidden-sm visible-md visible-lg">
										<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',
												array('action' => 'viewUsergroup', $usergroup['Aro']['id']), array('escape'=>FALSE,'class'=>'btn btn-xs btn-success view on-load','title'=>'View')); ?>
										<?php if($permission['_update'] == '1'):?>
											<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',
												array('action' => 'editUsergroup', $usergroup['Aro']['id']), array('escape'=>FALSE,'class'=>'btn btn-xs btn-info edit on-load','title'=>'Edit')); ?>
										<?php endif;?>
										<?php if($permission['_delete'] == '1' && $adminUsergroup['Aro']['id'] != $usergroup['Aro']['id']):?>
											<?php if($usergroup['users_count'] > 0){ $msg = $usergroup['users_count'].' users will be deleted along with '.$usergroup['Aro']['alias'].' role! Are you sure want to delete ?'; } else {$msg = 'Are you sure you want to delete '.$usergroup['Aro']['alias'].' role ?';}?>
											<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',
												array('action' => 'delete', $usergroup['Aro']['id']), array('escape'=>FALSE,'title'=>'Delete','class'=>'btn btn-xs btn-danger delete on-load'), __($msg)); ?>
										<?php endif;?>
									</div>
									
										<div class="visible-xs visible-sm hidden-md hidden-lg">
										<div class="inline position-relative">
											<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
												<i class="icon-cog icon-only bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-only-icon  pull-right dropdown-caret dropdown-close">
																						
												<li>
													<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',
												array('action' => 'viewUsergroup', $usergroup['Aro']['id']), array('escape'=>FALSE,'class'=>'btn btn-xs btn-success view on-load','title'=>'View')); ?>
												</li>
												<li>
													<?php if($permission['_update'] == '1'):?>
											<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',
												array('action' => 'editUsergroup', $usergroup['Aro']['id']), array('escape'=>FALSE,'class'=>'btn btn-xs btn-info edit on-load','title'=>'Edit')); ?>
										<?php endif;?>
												</li>
												<li>
												<?php if($permission['_delete'] == '1' && $adminUsergroup['Aro']['id'] != $usergroup['Aro']['id']):?>
											<?php if($usergroup['users_count'] > 0){ $msg = $usergroup['users_count'].' users will be deleted along with '.$usergroup['Aro']['alias'].' role! Are you sure want to delete ?'; } else {$msg = 'Are you sure you want to delete '.$usergroup['Aro']['alias'].' role ?';}?>
											<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',
												array('action' => 'delete', $usergroup['Aro']['id']), array('escape'=>FALSE,'class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete'), __($msg)); ?>
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
					<?php echo $this->Form->end(); ?>
				</div>
				
				
					<div class="row clear col-xs-12 paginationmaindiv">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 paginationText">
							<div id="sample-table-2_info" class="dataTables_info">
								<?php echo $this->Paginator->counter(array('format' => __('Showing {:start} to {:end} of {:count} entries')));?>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 paginationNumber">
							<div class="dataTables_paginate paging_bootstrap">
								<ul class="pagination">
									<?php
										$this->Paginator->options(array(
						 					//'update' => '#content',
											'evalScripts' => true,
											'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),
		    								'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false)),
											'url' => array('action'=>'manageUsergroup')
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
			$(".chosen-select").chosen();
		});
	</script>
	<script type="text/javascript">
	$(document).ready(function(){
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
	<?php echo $this->Js->writeBuffer();?>