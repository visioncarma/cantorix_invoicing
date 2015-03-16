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
			<?php echo $this->Html->link('Roles',array('action'=>'manageUsergroup'));?>
		</li>

		<li class="active">
			Edit Role
		</li>

	</ul><!-- .breadcrumb -->
	
</div>

<div class="page-content">
	<div class="page-header">
		<h1> Edit Role </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index'),array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right addbutton'));?>
		</div>
	</div>
	<!-- /.page-header -->
	<?php echo $this->Form->create('Usergroup',array('id'=>'Usergroup','inputDefaults' => array(
		'label' => false,
        'div' => false
    )));?>
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll">
				<div class="row margin-twenty-zero filterdivmob">
					<div class="form-group margin-bottom-zero role-form-group">
						<label class="col-sm-1 control-label no-padding-right col-xs-12 nopadding" for="form-field-1">Role name</label>
						<?php echo $this->Form->hidden('id',array('id'=>'form-field-1','class'=>'left','value'=>$groupName['Aro']['id']));?>
						<?php 
							if($groupName['Aro']['alias'] == 'Admin') {
								$disabled = TRUE;
							} else {
								$disabled = FALSE;
							}
						?>
						<?php
						if($groupName['Aro']['alias'] == 'Admin') {
							echo $this->Form->hidden('group_name',array('value'=>$groupName['Aro']['alias']));
							echo $this->Form->input('group_name',array('id'=>'form-field-1','class'=>'left','value'=>$groupName['Aro']['alias'],'disabled'=>$disabled));
						} else {
							echo $this->Form->input('group_name',array('id'=>'form-field-1','class'=>'left','value'=>$groupName['Aro']['alias'],'disabled'=>$disabled));
						}
							
						?>
					</div>
				</div>
				<h3 class="header smaller lighter blue bold paddingmobile5">Select Module Access</h3>

				<table id="sample-table-1" class="table table-striped table-bordered table-hover role table_fixed_new">
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
						<?php echo $this->Form->hidden('Permission.'.$menu['Aco']['id'].'.id',array('value'=>$permission[$menu['Aco']['id']]['id']));?>
						<?php $disabled = FALSE;
								if($menu['Aco']['alias'] == 'Settings') {
									if($groupName['Aro']['alias'] == 'Admin') {
										$disabled = TRUE;
										echo $this->Form->hidden('Permission.'.$menu['Aco']['id'].'._read',array('value'=>$permission[$menu['Aco']['id']]['_read']));
										echo $this->Form->hidden('Permission.'.$menu['Aco']['id'].'._create',array('value'=>$permission[$menu['Aco']['id']]['_create']));
										echo $this->Form->hidden('Permission.'.$menu['Aco']['id'].'._update',array('value'=>$permission[$menu['Aco']['id']]['_update']));
										echo $this->Form->hidden('Permission.'.$menu['Aco']['id'].'._delete',array('value'=>$permission[$menu['Aco']['id']]['_delete']));
									} else {
										$disabled = FALSE;
									}
								}
							?>
						<tr id="parent-<?php echo $menu['Aco']['id'];?>" class="parent">
							<td class="bold"><?php echo $menu['Aco']['alias'];?></td>
							<td>
								<span> 
									<label>
										<?php echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._read',array('class'=>'ace view','checked'=>$permission[$menu['Aco']['id']]['_read'],'disabled'=>$disabled));?>
										<span class="lbl"></span> 
									</label> 
								</span>
							</td>
							<td>
								<span> 
									<label>
										<?php echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._create',array('class'=>'ace create','checked'=>$permission[$menu['Aco']['id']]['_create'],'disabled'=>$disabled));?>
										<span class="lbl"></span>
									</label>
								</span>
							</td>
							
							<td>
								<span> 
									<label>
										<?php echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._update',array('class'=>'ace update','checked'=>$permission[$menu['Aco']['id']]['_update'],'disabled'=>$disabled));?>
										<span class="lbl"></span> 
									</label> 
								</span>
							</td>
							<td>
								<span> 
									<label>
										<?php echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._delete',array('class'=>'ace admin','checked'=>$permission[$menu['Aco']['id']]['_delete'],'disabled'=>$disabled));?>
										<span class="lbl"></span> 
									</label> 
								</span>
							</td>
						</tr>
						<?php foreach($menu['Child'] as $childMenu):?>
						<?php echo $this->Form->hidden('Permission.'.$childMenu['Aco']['id'].'.id',array('value'=>$permission[$childMenu['Aco']['id']]['id']));?>
						<tr class="child" id="parent-<?php echo $menu['Aco']['id'];?>">
							<?php 
								$disabled = FALSE;
								if($childMenu['Aco']['alias'] == 'Roles' || $childMenu['Aco']['alias'] == 'Users') {
									if($groupName['Aro']['alias'] == 'Admin') {
										$disabled = TRUE;
										echo $this->Form->hidden('Permission.'.$childMenu['Aco']['id'].'._read',array('value'=>$permission[$childMenu['Aco']['id']]['_read']));
										echo $this->Form->hidden('Permission.'.$childMenu['Aco']['id'].'._create',array('value'=>$permission[$childMenu['Aco']['id']]['_create']));
										echo $this->Form->hidden('Permission.'.$childMenu['Aco']['id'].'._update',array('value'=>$permission[$childMenu['Aco']['id']]['_update']));
										echo $this->Form->hidden('Permission.'.$childMenu['Aco']['id'].'._delete',array('value'=>$permission[$childMenu['Aco']['id']]['_delete']));
									} else {
										$disabled = FALSE;
									}
								}
							?>
							<td>
								<p class="margin-left-15 margin-bottom-zero">
									<?php echo $childMenu['Aco']['alias'];?>
								</p>
							</td>
							<td>
								<span> 
									<label>
										<?php echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._read',array('class'=>'ace view','checked'=>$permission[$childMenu['Aco']['id']]['_read'],'disabled'=>$disabled));?>
										<span class="lbl"></span> 
									</label> 
								</span>
							</td>
							<td>
								<span> 
									<label>
										<?php echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._create',array('class'=>'ace create','checked'=>$permission[$childMenu['Aco']['id']]['_create'],'disabled'=>$disabled));?>
										<span class="lbl"></span> 
									</label> 
								</span>
							</td>
							
							<td>
								<span> 
									<label>
										<?php echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._update',array('class'=>'ace update','checked'=>$permission[$childMenu['Aco']['id']]['_update'],'disabled'=>$disabled));?>
										<span class="lbl"></span> 
									</label> 
								</span>
							</td>
							<td>
								<span> 
									<label>
										<?php echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._delete',array('class'=>'ace admin','checked'=>$permission[$childMenu['Aco']['id']]['_delete'],'disabled'=>$disabled));?>
										<span class="lbl"></span> 
									</label> 
								</span>
							</td>
						</tr>
						<?php endforeach;?>
						<script type="text/javascript">
							$(document).ready(function() {
					            $('table tr input.admin:checkbox').on('click' , function(){
									var that = this;
									$(this).closest('table tr').find('input:checkbox').each(function(){				
										this.checked = that.checked;																											
									});
												
						        });
						        
						        
						        $('table tr.parent input:checkbox').on('click' , function(){
						            var that = this;
						            var thisclass=$(this).attr('class');
						            thisclass=$.trim(thisclass.slice(3,10));
						            var thisid=$(this).parents('.parent').attr('id');
						            if(thisclass=="admin")
						            {
						            	$('#'+thisid+'.child').find('input:checkbox').each(function(){				
										this.checked = that.checked;
									});	
						            }
						            else
						            {																	
									$('#'+thisid+'.child').find('input.'+thisclass+':checkbox').each(function(){				
										this.checked = that.checked;
									});
						            }													
						        });
						       
						        
						        
						        
						        	
								
								$('table tr.child input.admin:checkbox').on('click' , function(){
									var that = this;
									var thisid=$(this).parents('.child').attr('id');
																	
									$('#'+thisid+'.parent').find('input:checkbox').each(function(){				
										this.checked = that.checked;
									});			
									$(this).closest('table tr.child').find('input:checkbox').each(function(){				
										this.checked = that.checked;
									});			
						        });
						        
						        $('table tr.child input.view:checkbox').on('click' , function(){
									var that = this;
									var thisid=$(this).parents('.child').attr('id');
																	
									$('#'+thisid+'.parent').find('input.view:checkbox').each(function(){				
										this.checked = that.checked;
									});		
											
						        });
						        $('table tr.child input.update:checkbox').on('click' , function(){
									var that = this;
									var thisid=$(this).parents('.child').attr('id');
																	
									$('#'+thisid+'.parent').find('input.update:checkbox').each(function(){				
										this.checked = that.checked;
									});
									$('#'+thisid+'.parent').find('input.view:checkbox').each(function(){				
										this.checked = that.checked;
									});
                                    $(this).closest('table tr.child').find('input.view:checkbox').each(function(){				
										this.checked = that.checked;
									});			
											
						        });
						        $('table tr.child input.create:checkbox').on('click' , function(){
									var that = this;
									var thisid=$(this).parents('.child').attr('id');
																	
									$('#'+thisid+'.parent').find('input.create:checkbox').each(function(){				
										this.checked = that.checked;
									});
									$('#'+thisid+'.parent').find('input.view:checkbox').each(function(){				
										this.checked = that.checked;
									});
                                    $(this).closest('table tr.child').find('input.view:checkbox').each(function(){				
										this.checked = that.checked;
									});			
											
						        });
						   });
						</script>
						<?php endforeach;?>
					</tbody>
				</table>
				<div class="row">

					<div class="col-sm-12 col-xs-12 marginbottomm">
						<?php echo $this->Html->link('<i class="icon-cancel bigger-110"></i>Cancel',array('action'=>'index'),array('class'=>'btn pull-right margin-left-15 btn-inverse','escape'=>FALSE));?>
						<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('type'=>'submit','class'=>'btn btn-info pull-right'));?>
					</div>
				</div>

			</div>
		</div>
	</div>
	<?php //echo $this->Form->end();?>

</div><!-- /.page-content -->
</div><!-- /.main-content -->
<script type="text/javascript">
	$(document).ready(function () {
		$("#Usergroup").validate({
			onkeyup: false,
			rules: {
				'data[Usergroup][group_name]': {
					required: true,
					checkEmailAvailability: true
				}
			},
			messages: {
				'data[Usergroup][group_name]': {
					required : "Please enter role name",
					checkEmailAvailability : "Role already exist"
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
			    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>usergroups/checkSubscribersRole/<?php echo $subscriberID;?>/<?php echo $groupName['Aro']['id'];?>",
			    type: 'POST',
			    async: false,
			    data: $("#Usergroup").serialize()
			 }).responseText;	 	
			 if(x=="true") return false;
			 else return true;
			},"Role already exist! Please try other role name");
		});
			
</script>