<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript" src="">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>

	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link(__('<i class="icon-home home-icon"></i>Home'),array('controller'=>'Users','action'=>'Dashboard'),array('escape'=>false));?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Settings'),array('controller'=>'SubscriptionPlans','action'=>'index'));?>
			
		</li>
		<li class="active">
			<?php echo $this->Html->link(__('Subscription Plans'),array('controller'=>'SubscriptionPlans','action'=>'index'));?>
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1> <?php echo __('Manage Subscription Plans');?> </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php if($permission['_create'] == 1):?>
				<?php $countOfPlan = count($cpnSubscriptionPlans);?>
				<?php if($countOfPlan<3):?>
					<?php echo $this->Html->link('<i class="icon-plus"></i>Add New Plan', array('action' => 'add'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>false)); ?>
				<?php endif ;?>
			<?php endif; ?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll scrollautoo">
				<div class="table-header">
					<?php echo __('Subscription Plans List');?>
				</div>
				<table id="sample-table-1" class="table table-striped table-bordered table-hover rt rt1">
					<thead>
						<tr>
							<th><?php echo $this->Paginator->sort('type','Plan Type'); ?></th>
							<th ><?php echo $this->Paginator->sort('validity','Validity'); ?></th>
							<th ><?php echo $this->Paginator->sort('no_of_staffs','No of Staff'); ?></th>
							<th><?php echo $this->Paginator->sort('no_of_clients','No of Clients'); ?>  </th>
							<th><?php echo $this->Paginator->sort('cost','Cost'); ?></th>
							<th ><?php echo $this->Paginator->sort('no_of_invoices','No of Invoices'); ?></th>
							<?php if($permission['_update'] == 1 || $permission['_delete'] == 1):?>
							<th>
								<?php echo __('Actions'); ?>
							</th>
							<?php endif;?>
						</tr>
					</thead>

					<tbody>
						<?php foreach ($cpnSubscriptionPlans as $cpnSubscriptionPlan): ?>
							<tr>
								<td><?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['type']); ?></td>
								<td >
									<?php if($cpnSubscriptionPlan['CpnSubscriptionPlan']['validity']<0){
										echo "Unlimited";
									}else{
										echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['validity']." Days");
									}?>
								</td>
								<td >
									<?php if($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_staffs']< 0 ){
										echo "Unlimited";
									}else{
										echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_staffs']);
									}?>
								</td>
								<td>
									<?php if($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_clients']<0){
										echo "Unlimited";
									}else{
										echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_clients']);
									}?>
								</td>
								<td>
									<?php echo  number_format((float)$cpnSubscriptionPlan['CpnSubscriptionPlan']['cost'], 2, '.', '');?>
								</td>
								<td >
									<?php if($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_invoices']<0){
										echo "Unlimited";
									}else{
										echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_invoices']);
									}?>
								</td>
								<td>
									<div class="visible-md visible-lg visible-sm visible-xs btn-group">
										<?php if($permission['_update'] == 1):?>
												<?php echo $this->Form->postLink('<button class="btn btn-xs btn-info edit" title="Edit"><i class="icon-edit bigger-120"></i></button>', array('action' => 'edit', $cpnSubscriptionPlan['CpnSubscriptionPlan']['id']),array('escape'=>false)); ?>
										<?php endif;?>
										<?php if($permission['_delete'] == 1):?>
											<?php echo $this->Form->postLink('<button class="btn btn-xs btn-danger delete" title="Delete"><i class="icon-trash bigger-120"></i></button>', array('action' => 'delete', $cpnSubscriptionPlan['CpnSubscriptionPlan']['id']),array('escape'=>false), __('Are you sure you want to delete  %s plan?', $cpnSubscriptionPlan['CpnSubscriptionPlan']['type'])); ?>
										<?php endif;?>
									</div>
									
								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div><!-- /.page-content -->

<!-- inline scripts related to this page -->

<script type="text/javascript">
	jQuery(function($) {
		$(".edit").tooltip({
			show : {
				effect : "slideDown",
				delay : 250
			}
		});
		$(".delete").tooltip({
			show : {
				effect : "slideDown",
				delay : 250
			}
		});
	})
</script>
