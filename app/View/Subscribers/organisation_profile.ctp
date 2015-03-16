<?php echo $this->Session->flash();?>
<?php 
	$homeLink = $this -> Breadcrumb -> getLink('Home');
	$settingsLink = $this->Breadcrumb->getLink('Settings'); 
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<ul class="breadcrumb">
		<li>
			<?php echo $this -> Html -> link('<i class="icon-home home-icon"></i>Home', "$homeLink", array('escape' => FALSE)); ?>
		</li>
		<li>
			<?php echo $this->Html->link('Settings',"$settingsLink");?>
		</li>
		<li class="active">
			Organization Details
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1> View Organization Details <span class="header-span"> <i class="icon-double-angle-right"></i> <?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['organization_name'];?> </span></h1>
		<?php if($permission['_delete'] == 1):?>
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 paddingleftrightzero">
				<?php echo $this->Html->link('<i class="icon-edit bigger-110"></i>Edit Details',array('action'=>'updateOrganisationDetails'),array('escape'=>FALSE,'class'=>'btn btn-info pull-right'));?>
			</div>
	   <?php endif;?>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 no-padding-left small-window-no-padding-right">
				<div class="form-horizontal left width100per">
					<div class="form-group paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero" > Organization Name </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold wordwrap" > <?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['organization_name'];?> </label>
					</div>
					<div class="form-group paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero " >Home Currency</label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold" > <?php echo $currency['CpnCurrency']['code'];?> </label>
					</div>
					<div class="form-group  paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero " > Language </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold" > <?php echo $organisationDetail['CpnLanguage']['language'];?> </label>
					</div>
					<div class="form-group  paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero " > Financial year </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold" > <?php echo $organisationDetail['CpnFinancialYear']['from_month'].' - '.$organisationDetail['CpnFinancialYear']['to_month'];?> </label>
					</div>
					<div class="form-group  paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero " > VAT Number</label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold" > <?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['vat_no'])) echo $organisationDetail['SbsSubscriberOrganizationDetail']['vat_no']; else echo '--';?> </label>
					</div>
					<div class="form-group  paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero " > Registration Number</label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold" > <?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['reg_no'])) echo $organisationDetail['SbsSubscriberOrganizationDetail']['reg_no']; else echo '--';?> </label>
					</div>
					<div class="form-group  paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero " >Website </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold" > <?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['website'])) echo $organisationDetail['SbsSubscriberOrganizationDetail']['website']; else echo '--';?> </label>
					</div>
					<div class="form-group paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero  " > Business Phone </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold " > <?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['phone'])) echo $organisationDetail['SbsSubscriberOrganizationDetail']['phone']; else echo '--';?> </label>
					</div>
					<div class="form-group paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero  " > Business Fax </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold " > <?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['fax'])) echo $organisationDetail['SbsSubscriberOrganizationDetail']['fax']; else echo '--';?> </label>
					</div>
					<div class="form-group paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero  " > Time Zone </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold " ><?php echo $time_zones[$organisationDetail['SbsSubscriberOrganizationDetail']['time_zone']];?></label>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contactdetails customerdetails paddingleftrightzero">
					<h5>Primary Contact</h5>
				</div>
				<div class="form-horizontal left width100per">
					<div class="form-group  paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero" > Contact First Name </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold wordwrap" > <?php if(!empty($adminUserDetails['User']['firstname'])) echo $adminUserDetails['User']['firstname']; else echo '--';?></label>
					</div>
					<div class="form-group  paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero " >Contact Last Name</label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold" > <?php if(!empty($adminUserDetails['User']['lastname'])) echo $adminUserDetails['User']['lastname']; else echo '--';?> </label>
					</div>
					<div class="form-group paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero  " > Home Phone </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold " > <?php if(!empty($adminUserDetails['User']['home_phone'])) echo $adminUserDetails['User']['home_phone']; else echo '--';?> </label>
					</div>
					<div class="form-group paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero  " > Mobile </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold " > <?php if(!empty($adminUserDetails['User']['mobile'])) echo $adminUserDetails['User']['mobile']; else echo '--';?> </label>
					</div>
					<div class="form-group paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero  " > Contact Email </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold " ><?php if(!empty($adminUserDetails['User']['email'])) echo $adminUserDetails['User']['email']; else echo '--';?></label>
					</div>
					<div class="form-group paddingleftrightzero marginleftrightzero marginbottom10">
						<label class="col-lg-5 col-md-5 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero  " > Username </label>
						<label class="col-lg-7 col-md-7 col-sm-6 col-xs-6 control-label marginleftrightzero paddingleftrightzero bold " ><?php if(!empty($adminUserDetails['User']['username'])) echo $adminUserDetails['User']['username']; else echo '--';?></label>
					</div>
				</div>
			</div>
			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 no-padding-right small-window-no-padding-left">
				<div class="col-xs-12 no-padding-right small-window-no-padding-left">
					<div class="widget-box">
						<div class="widget-header">
							<h5>Billing Address</h5>
						</div>

						<div class="widget-body">
							<div class="widget-main paddingleftrightzero">
								<div class="form-horizontal">
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'])):?>
									<div class="form-group  marginleftrightzero marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></label>
									</div>
									<?php endif;?>
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'])):?>
									<div class="form-group  marginleftrightzero marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></label>
									</div>
									<?php endif;?>
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['billing_city'])):?>
									<div class="form-group  marginleftrightzero marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['billing_city'];?></label>
									</div>
									<?php endif;?>
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['billing_state'])):?>
									<div class="form-group  marginleftrightzero marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['billing_state'];?></label>
									</div>
									<?php endif;?>
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['billing_country'])):?>
									<div class="form-group  marginleftrightzero marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['billing_country'];?></label>
									</div>
									<?php endif;?>
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'])):?>
									<div class="form-group  marginleftrightzero lastrow marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];?></label>
									</div>
									<?php endif;?>
								</div>
							</div>
						</div>
					</div>
					<div class="widget-box">
						<div class="widget-header">
							<h5>Shipping Address</h5>
						</div>

						<div class="widget-body">
							<div class="widget-main paddingleftrightzero">
								<div class="form-horizontal">
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['shipping_address_line1'])):?>
									<div class="form-group  marginleftrightzero marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['shipping_address_line1'];?></label>
									</div>
									<?php endif;?>
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['shipping_address_line2'])):?>
									<div class="form-group  marginleftrightzero marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['shipping_address_line2'];?></label>
									</div>
									<?php endif;?>
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['shipping_city'])):?>
									<div class="form-group  marginleftrightzero marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['shipping_city'];?></label>
									</div>
									<?php endif;?>
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['shipping_state'])):?>
									<div class="form-group  marginleftrightzero marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['shipping_state'];?></label>
									</div>
									<?php endif;?>
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['shipping_country'])):?>
									<div class="form-group  marginleftrightzero marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['shipping_country'];?></label>
									</div>
									<?php endif;?>
									<?php if(!empty($organisationDetail['SbsSubscriberOrganizationDetail']['shipping_zip'])):?>
									<div class="form-group  marginleftrightzero lastrow marginbottom10">
										<label class="col-sm-12 control-label no-padding-right no-padding-left wordwrap" ><?php echo $organisationDetail['SbsSubscriberOrganizationDetail']['shipping_zip'];?></label>
									</div>
									<?php endif;?>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contactdetails customerdetails paddingleftrightzero paddingtop25"></div>
			<?php if($permission['_delete'] == 1):?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero paddingtop25">
				<?php echo $this->Html->link('<i class="icon-edit bigger-110"></i>Edit Details',array('action'=>'updateOrganisationDetails'),array('escape'=>FALSE,'class'=>'btn btn-info pull-right'));?>
			</div>
			<?php endif;?>
		</div>
	</div>
</div><!-- /.page-content -->