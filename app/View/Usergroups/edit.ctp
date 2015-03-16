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
		
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 "> Edit Role</div>
		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-8 no-padding-left no-padding-right ">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index'),array('escape'=>FALSE,'class'=>'btn btn-sm btn-success addbutton floatright'));?>
		</div>
	</div>
	<!-- /.page-header -->
	<?php echo $this->Form->create('Usergroup',array('id'=>'Usergroup','inputDefaults' => array(
		'label' => false,
        'div' => false
    )));?>
    <!--<div class="row">

					<div class="col-sm-12 col-xs-12 marginbottomm">
						<?php echo $this->Html->link('<i class="icon-cancel bigger-110"></i>Cancel',array('action'=>'index'),array('class'=>'btn pull-right margin-left-15 btn-inverse','escape'=>FALSE));?>
						<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Update',array('type'=>'submit','class'=>'btn btn-info pull-right'));?>
					</div>
    </div> -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll">
				<div class="row margin-twenty-zero filterdivmob">
					<div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 form-group margin-bottom-zero role-form-group adjust_error">
						<label class="col-sm-2 col-lg-2 col-xs-4 control-label no-padding-right no-padding-left" for="form-field-1">Role name</label>
						<div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
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
								echo $this->Form->input('group_name',array('id'=>'form-field-1','class'=>'left mobile_100','value'=>$groupName['Aro']['alias'],'disabled'=>$disabled));
							} else {
								echo $this->Form->input('group_name',array('id'=>'form-field-1','class'=>'left mobile_100','value'=>$groupName['Aro']['alias'],'disabled'=>$disabled));
							}
								
							?>
						</div>
					</div>
					<div class="col-sm-6 col-xs-12 col-md-6 col-lg-6 marginbottomm footerbutton">
						<?php echo $this->Html->link('<i class="icon-cancel bigger-110"></i>Cancel',array('action'=>'index'),array('class'=>'btn pull-right margin-left-15 btn-inverse button_mobile','escape'=>FALSE));?>
						<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Update',array('type'=>'submit','class'=>'btn btn-info pull-right button_mobile'));?>
					</div>
					
				</div>
				<h3 class="header smaller lighter blue bold paddingmobile5">Select Module Access</h3>

				<table id="sample-table-1" class="table table-striped table-bordered table-hover role table_fixed_new">
					<thead>
						<tr>
							<th class="width300">Module Name</th>
							<th class="width150">View</th>
							<th class="width150">Create</th><br />
							<th class="width150">Update</th>
							<th class="width150">Admin</th>
						</tr>
					</thead>

					<tbody>
						<?php foreach($menus as $menu):?>
						
						<tr class="parent-<?php echo $menu['Aco']['id'];?>">
							<td class="bold"><?php echo $menu['Aco']['alias'];?>
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
							</td>
							<td>
								<span> 
									<label>
										<?php $checkedClassAdd = NULL;if(($permission[$menu['Aco']['id']]['_create'] == 1) || ($permission[$menu['Aco']['id']]['_update'] == 1) || ($permission[$menu['Aco']['id']]['_delete'] == 1)) $checkedClassAdd='disabledCheckbox';echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._read',array('class'=>'ace view '.$checkedClassAdd,'checked'=>$permission[$menu['Aco']['id']]['_read'],'disabled'=>$disabled));?>
										<span class="lbl"></span> 
									</label> 
								</span>
							</td>
							<td>
								<span> 
									<label>
										<?php $checkedClassAdd = NULL;if($permission[$menu['Aco']['id']]['_delete'] == 1) $checkedClassAdd='disabledCheckbox';echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._create',array('class'=>'ace create '.$checkedClassAdd,'checked'=>$permission[$menu['Aco']['id']]['_create'],'disabled'=>$disabled));?>
										<span class="lbl"></span>
									</label>
								</span>
							</td>
							
							<td>
								<span> 
									<label>
										<?php $checkedClassAdd = NULL;if($permission[$menu['Aco']['id']]['_delete'] == 1) $checkedClassAdd='disabledCheckbox';echo $this->Form->checkbox('Permission.'.$menu['Aco']['id'].'._update',array('class'=>'ace update '.$checkedClassAdd,'checked'=>$permission[$menu['Aco']['id']]['_update'],'disabled'=>$disabled));?>
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
						
						<tr class="child-<?php echo $menu['Aco']['id'];?>">
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
							<?php echo $this->Form->hidden('Permission.'.$childMenu['Aco']['id'].'.id',array('value'=>$permission[$childMenu['Aco']['id']]['id']));?>
							<td>
								<p class="margin-left-15 margin-bottom-zero">
									<?php echo $childMenu['Aco']['alias'];?>
								</p>
							</td>
							<td>
								<span> 
									<label>
										<?php $checkedClassAdd = NULL;if(($permission[$childMenu['Aco']['id']]['_create'] == 1) || ($permission[$childMenu['Aco']['id']]['_update'] == 1) || ($permission[$childMenu['Aco']['id']]['_delete'] == 1)) $checkedClassAdd='disabledCheckbox';echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._read',array('class'=>'ace view '.$checkedClassAdd,'checked'=>$permission[$childMenu['Aco']['id']]['_read'],'disabled'=>$disabled));?>
										<span class="lbl"></span>
									</label> 
								</span>
							</td>
							<td>
								<span> 
									<label>
										<?php $checkedClassAdd = NULL;if($permission[$childMenu['Aco']['id']]['_delete'] == 1) $checkedClassAdd='disabledCheckbox';echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._create',array('class'=>'ace create '.$checkedClassAdd,'checked'=>$permission[$childMenu['Aco']['id']]['_create'],'disabled'=>$disabled));?>
										<span class="lbl"></span> 
									</label> 
								</span>
							</td>
							
							<td>
								<span> 
									<label>
										<?php $checkedClassAdd = NULL;if($permission[$childMenu['Aco']['id']]['_delete'] == 1) $checkedClassAdd='disabledCheckbox';echo $this->Form->checkbox('Permission.'.$childMenu['Aco']['id'].'._update',array('class'=>'ace update '.$checkedClassAdd,'checked'=>$permission[$childMenu['Aco']['id']]['_update'],'disabled'=>$disabled));?>
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
						
						<?php endforeach;?>
					</tbody>
				</table>
				<div class="row">

					<div class="col-sm-12 col-xs-12 marginbottomm footerbutton">
						<?php echo $this->Html->link('<i class="icon-cancel bigger-110"></i>Cancel',array('action'=>'index'),array('class'=>'btn pull-right margin-left-15 btn-inverse button_mobile','escape'=>FALSE));?>
						<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Update',array('type'=>'submit','class'=>'btn btn-info pull-right button_mobile'));?>
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


<!-- Script By Junaid for ROLE CHECKBOX START -->
<script>
$(function(){
	$.fn.parentClick = function(level){
		var childs = $(this).parents("tr").attr("class").replace("parent","child");
		$("."+childs).find('input.'+level).prop("checked",$(this).prop("checked"));
		$(this).siblingParentClick(level);
		$(this).disableSiblingParent(level);
	};
	
	$.fn.checkClickedChild = function(level){
		if($("."+$(this).parents("tr").attr("class")+" input."+level+":checked").length)
		{
			var parents = $(this).parents("tr").attr("class").replace("child","parent");
			$("."+parents).find('input.'+level).prop("checked",true);
		}
	}
	
	$.fn.siblingCheckClickedChild = function(level){
		if($("."+$(this).parents("tr").attr("class")+" input."+level+":checked").length)
		{
			var parents = $(this).parents("tr").attr("class").replace("child","parent");
			$("."+parents).find('input.'+level).prop("checked",true);
		}
	} 
	
	$.fn.childClick = function(level){
		var parents = $(this).parents("tr").attr("class").replace("child","parent");
		if($("."+$(this).parents("tr").attr("class")+" input."+level+":checked").length==0)
		{
			$("."+parents).find('input.'+level).prop("checked",$(this).prop("checked"));
		}
		$(this).checkClickedChild(level);
		$(this).siblingChildClick(level);
		$(this).disableSiblingChild(level);
	};
	
	$.fn.siblingChildClick = function(level){
		var row = $(this).parents("tr").attr("class");
		var parents = $(this).parents("tr").attr("class").replace("child","parent");
		switch (level)
		{
			case "create":
			{
				$(this).parents("tr").find("input.view").prop("checked",$(this).prop("checked"));
				$('.'+parents+" input.view").prop("checked",$(this).prop("checked"));
				$(this).checkClickedChild("view");
				break;
			}
			case "update":
			{
				$(this).parents("tr").find("input.view").prop("checked",$(this).prop("checked"));
				$('.'+parents+" input.view").prop("checked",$(this).prop("checked"));
				$(this).checkClickedChild("view");
				break;
			}
			case "admin":
			{
				$(this).parents("tr").find("input.view").prop("checked",$(this).prop("checked"));
				$(this).parents("tr").find("input.create").prop("checked",$(this).prop("checked"));
				$(this).parents("tr").find("input.update").prop("checked",$(this).prop("checked"));
				$('.'+parents+" input.view").prop("checked",$(this).prop("checked"));
				$('.'+parents+" input.create").prop("checked",$(this).prop("checked"));
				$('.'+parents+" input.update").prop("checked",$(this).prop("checked"));
				$(this).checkClickedChild("view");
				$(this).checkClickedChild("create");
				$(this).checkClickedChild("update");
				break;
			}
			
		}
	}
	
	$.fn.siblingParentClick = function(level){
		var row = $(this).parents("tr").attr("class");
		var childs = $(this).parents("tr").attr("class").replace("parent","child");
		switch (level)
		{
			case "create":
			{
				$('.'+row+" input.view").prop("checked",$(this).prop("checked"));
				$('.'+childs+" input.view").prop("checked",$(this).prop("checked"));
				break;
			}
			case "update":
			{
				$('.'+row+" input.view").prop("checked",$(this).prop("checked"));
				$('.'+childs+" input.view").prop("checked",$(this).prop("checked"));
				break;
			}
			case "admin":
			{
				$('.'+row+" input.view").prop("checked",$(this).prop("checked"));
				$('.'+row+" input.create").prop("checked",$(this).prop("checked"));
				$('.'+row+" input.update").prop("checked",$(this).prop("checked"));
				$('.'+childs+" input.view").prop("checked",$(this).prop("checked"));
				$('.'+childs+" input.create").prop("checked",$(this).prop("checked"));
				$('.'+childs+" input.update").prop("checked",$(this).prop("checked"));
				break;
			}
			
		}
	}
	
	$.fn.disableSiblingChild = function(level){
		var row = $(this).parents("tr").attr("class");
		var parents = $(this).parents("tr").attr("class").replace("child","parent");
		switch (level)
		{
			case "create":
			{
				if($(this).prop("checked"))
					$(this).parents("tr").find("input.view").addClass("disabledCheckbox");
				else
					$(this).parents("tr").find("input.view").removeClass("disabledCheckbox");
					
				if($("."+$(this).parents("tr").attr("class")+" input.view:checked").length)
				{
					var parents = $(this).parents("tr").attr("class").replace("child","parent");
					$("."+parents).find('input.view').addClass("disabledCheckbox");
				}
				else
				{
					var parents = $(this).parents("tr").attr("class").replace("child","parent");
					$("."+parents).find('input.view').removeClass("disabledCheckbox");
				}
				break;
			}
			case "update":
			{
				if($(this).prop("checked"))
					$(this).parents("tr").find("input.view").addClass("disabledCheckbox");
				else
					$(this).parents("tr").find("input.view").removeClass("disabledCheckbox");
				if($("."+$(this).parents("tr").attr("class")+" input.view:checked").length)
				{
					var parents = $(this).parents("tr").attr("class").replace("child","parent");
					$("."+parents).find('input.view').addClass("disabledCheckbox");
				}
				else
				{
					var parents = $(this).parents("tr").attr("class").replace("child","parent");
					$("."+parents).find('input.view').removeClass("disabledCheckbox");
				}
				break;
			}
			case "admin":
			{
				if($(this).prop("checked"))
					{
						$(this).parents("tr").find("input.view").addClass("disabledCheckbox");
						$(this).parents("tr").find("input.create").addClass("disabledCheckbox");
						$(this).parents("tr").find("input.update").addClass("disabledCheckbox");
					}
				else
					{
						$(this).parents("tr").find("input.view").removeClass("disabledCheckbox");
						$(this).parents("tr").find("input.create").removeClass("disabledCheckbox");
						$(this).parents("tr").find("input.update").removeClass("disabledCheckbox");
					}
				if($("."+$(this).parents("tr").attr("class")+" input.view:checked").length)
					{
						var parents = $(this).parents("tr").attr("class").replace("child","parent");
						$("."+parents).find('input.view').addClass("disabledCheckbox");
					}
				else
					{
						var parents = $(this).parents("tr").attr("class").replace("child","parent");
						$("."+parents).find('input.view').removeClass("disabledCheckbox");
					}
				if($("."+$(this).parents("tr").attr("class")+" input.create:checked").length)
					{
						var parents = $(this).parents("tr").attr("class").replace("child","parent");
						$("."+parents).find('input.create').addClass("disabledCheckbox");
					}
				else
					{
						var parents = $(this).parents("tr").attr("class").replace("child","parent");
						$("."+parents).find('input.create').removeClass("disabledCheckbox");
					}
				if($("."+$(this).parents("tr").attr("class")+" input.update:checked").length)
					{
						var parents = $(this).parents("tr").attr("class").replace("child","parent");
						$("."+parents).find('input.update').addClass("disabledCheckbox");
					}
				else
					{
						var parents = $(this).parents("tr").attr("class").replace("child","parent");
						$("."+parents).find('input.update').removeClass("disabledCheckbox");
					}
				break;
			}
			
		}
	}
	
	$.fn.disableSiblingParent = function(level){
		var row = $(this).parents("tr").attr("class");
		var childs = $(this).parents("tr").attr("class").replace("parent","child");
		switch (level)
		{
			case "create":
			{
				if($(this).prop("checked"))
				{
					$('.'+row+" input.view").addClass("disabledCheckbox");
					$('.'+childs+" input.view").addClass("disabledCheckbox");
				}
				else
				{
					$('.'+row+" input.view").removeClass("disabledCheckbox");
					$('.'+childs+" input.view").removeClass("disabledCheckbox");
				}
				break;
			}
			case "update":
			{
				if($(this).prop("checked"))
				{
					$('.'+row+" input.view").addClass("disabledCheckbox");
					$('.'+childs+" input.view").addClass("disabledCheckbox");
				}
				else
				{
					$('.'+row+" input.view").removeClass("disabledCheckbox");
					$('.'+childs+" input.view").removeClass("disabledCheckbox");
				}
				break;
			}
			case "admin":
			{
				if($(this).prop("checked"))
				{
					$('.'+row+" input.view").addClass("disabledCheckbox");
					$('.'+childs+" input.view").addClass("disabledCheckbox");
					$('.'+row+" input.create").addClass("disabledCheckbox");
					$('.'+childs+" input.create").addClass("disabledCheckbox");
					$('.'+row+" input.update").addClass("disabledCheckbox");
					$('.'+childs+" input.update").addClass("disabledCheckbox");
				}
				else
				{
					$('.'+row+" input.view").removeClass("disabledCheckbox");
					$('.'+childs+" input.view").removeClass("disabledCheckbox");
					$('.'+row+" input.create").removeClass("disabledCheckbox");
					$('.'+childs+" input.create").removeClass("disabledCheckbox");
					$('.'+row+" input.update").removeClass("disabledCheckbox");
					$('.'+childs+" input.update").removeClass("disabledCheckbox");
				}
				break;
			}
			
		}
	}
	
	$.fn.checkView = function(level){
		if($(this).parents("tr").find('input.create').prop("checked")||$(this).parents("tr").find('input.update').prop("checked")||$(this).parents("tr").find('input.admin').prop("checked"))
			{
				$(this).parents("tr").find('input.view').prop("checked",true).addClass("disabledCheckbox");
				var parents = $(this).parents("tr").attr("class").replace("child","parent");
				$("."+parents).find('input.view').prop("checked",true).addClass("disabledCheckbox");
			}
	};
	
	$.fn.checkViewParents = function(level){
		if($(this).parents("tr").find('input.create').prop("checked")||$(this).parents("tr").find('input.update').prop("checked")||$(this).parents("tr").find('input.admin').prop("checked"))
			{
				$(this).parents("tr").find('input.view').prop("checked",true).addClass("disabledCheckbox");
				var childs = $(this).parents("tr").attr("class").replace("parent","child");
				$("."+childs).find('input.view').prop("checked",true).addClass("disabledCheckbox");
			}
	};
	
	$('tr[class^="parent"] input.view').on("click",function(){
		if(!$(this).hasClass("disabledCheckbox")){$(this).parentClick("view")};
	});
	$('tr[class^="parent"] input.create').on("click",function(){
		if(!$(this).hasClass("disabledCheckbox")){$(this).parentClick("create");$(this).checkViewParents("create");};
		
	});
	$('tr[class^="parent"] input.update').on("click",function(){
		if(!$(this).hasClass("disabledCheckbox")){$(this).parentClick("update");$(this).checkViewParents("update");};
		
	});
	$('tr[class^="parent"] input.admin').on("click",function(){
		if(!$(this).hasClass("disabledCheckbox")){$(this).parentClick("admin");$(this).checkViewParents("admin");};
		
	});
	
	$('tr[class^="child"] input.view').on("click",function(){
		if(!$(this).hasClass("disabledCheckbox")){$(this).childClick("view")};
	});
	$('tr[class^="child"] input.create').on("click",function(){
		if(!$(this).hasClass("disabledCheckbox")){$(this).childClick("create");$(this).checkView("create");};
		
	});
	$('tr[class^="child"] input.update').on("click",function(){
		if(!$(this).hasClass("disabledCheckbox")){$(this).childClick("update");$(this).checkView("update");};
		
	});
	$('tr[class^="child"] input.admin').on("click",function(){
		if(!$(this).hasClass("disabledCheckbox")){$(this).childClick("admin");$(this).checkView("admin");};
		
	});
	
	$('body').on("click",".disabledCheckbox", function(){
		return false;
	});
});
</script>