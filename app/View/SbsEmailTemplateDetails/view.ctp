<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<?php $homeLink = $this->Breadcrumb->getLink('Home');?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Settings'),array('controller'=>'subscribers','action'=>'changeSubscription'));?>
		</li>
		<li class="active">
			View Template
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1> View Email Template </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i> Back', array('action' => 'index'), array('class' => 'btn btn-sm btn-success pull-right addbutton', 'escape' => FALSE)); ?>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="container">
		<div class="row">
			<div class="view_email_wrap">

				<div class="form-group mb-10 clearfix">
					<div class="col-md-2 col-sm-3 col-sx-12 paddingleftrightzero">
						<strong>From:</strong>
					</div>
					<div class="col-md-10 col-sm-9 col-sx-12">
						<?php echo h($sbsEmailTemplateDetail['SbsEmailTemplateDetail']['from_email_address']); ?>
					</div>
				</div>

				<div class="form-group clearfix">
					<div class="col-md-2 col-sm-3 col-sx-12 paddingleftrightzero">
						<strong> Email Subject:</strong>
					</div>
					<div class="col-md-10 col-sm-9 col-sx-12">
						<?php echo h($sbsEmailTemplateDetail['SbsEmailTemplateDetail']['subject']); ?>
					</div>
				</div>

				<div class="form-group clearfix">
					<div class="col-md-10 email_body_field">
						<pre><?php echo h($sbsEmailTemplateDetail['SbsEmailTemplateDetail']['body_content']); ?></pre>
					</div>
				</div>

			</div>
		</div>
	</div>

</div><!-- /.page-content -->
