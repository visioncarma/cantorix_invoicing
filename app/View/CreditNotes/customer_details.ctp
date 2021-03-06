<div class="widget-box">
	<div class="widget-header">
		<h5><?php echo __('Credit Note To'); ?></h5>
	</div>

	<div class="widget-body">
		<div class="widget-main paddingleftrightzero">
			<div class="form-horizontal">
				<div class="form-group borderline marginleftrightzero">
					<div class="row marginleftrightzero">
						<div class="col-sm-12 no-padding-right no-padding-left">
							<div class="col-sm-5 control-label no-padding-right  " >
								<?php echo __('Contact Name'); ?>
							</div>
							<div class="col-sm-7 control-label no-padding-right bold no-padding-left " >
								<?php
								if ($contactPersonName) {
									echo $contactPersonName;
								} else {
									 echo '--';
								}
							?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group borderline marginleftrightzero">
					<div class="row marginleftrightzero">
						<div class="col-sm-12 no-padding-right no-padding-left">
							<div class="col-sm-5 control-label no-padding-right  " >
								<?php echo __('Contact Surname'); ?>
							</div>
							<div class="col-sm-7 control-label no-padding-right bold no-padding-left " >
								<?php
								if ($contactSurName) {
									 echo $contactSurName;
								} else {
									 echo '--';
								}
							?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group borderline marginleftrightzero">
					<div class="row marginleftrightzero">
						<div class="col-sm-12 no-padding-right no-padding-left">
							<div class="col-sm-5 control-label no-padding-right  " >
								<?php echo __('Contact Email'); ?>
							</div>
							<div class="col-sm-7 control-label no-padding-right bold no-padding-left wordwrap" >
								<?php
								if ($contactEmail) {
									 echo $contactEmail;
								} else {
									 echo '--';
								}
							?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group borderline marginleftrightzero">
					<div class="row marginleftrightzero">
						<div class="col-sm-12 no-padding-right no-padding-left">
							<div class="col-sm-5 control-label no-padding-right  " >
								<?php echo __('Mobile'); ?>
							</div>
							<div class="col-sm-7 control-label no-padding-right bold no-padding-left " >
								<?php
								if ($contactMobile) {
									echo $contactMobile;
								} else {
									echo '--';
								}
							?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group  marginleftrightzero borderline">
					<div class="row marginleftrightzero">
						<div class="col-sm-12 no-padding-right no-padding-left">
							<div class="col-sm-5 control-label no-padding-right  " >
								<?php echo __('Home Phone'); ?>
							</div>
							<div class="col-sm-7 control-label no-padding-right bold no-padding-left " >
								<?php
								if ($contactHomePhone) {
									echo $contactHomePhone;
								} else {
									echo '--';
								}
							?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group  marginleftrightzero lastrow">
					<div class="row marginleftrightzero">
						<div class="col-sm-12 no-padding-right no-padding-left">
							<div class="col-sm-5 control-label no-padding-right  " >
								<?php echo __('Work Phone'); ?>
							</div>
							<div class="col-sm-7 control-label no-padding-right bold no-padding-left " >
								<?php
								if ($contactWorkPhone) {
									echo $contactWorkPhone;
								} else {
									echo '--';
								}
							?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>