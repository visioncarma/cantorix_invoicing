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
		<li>
			<?php echo $this->Html->link('Organization Profile',array('action'=>'organisationProfile'));?>
		</li>
		<li class="active">
			Update Organization Details
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 >Update Organization Details</h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i> Back',array('action'=>'organisationProfile'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
		</div>

	</div>
	<!-- /.page-header -->
	<?php echo $this->Form->create('OrganisationProfile',array('class'=>'form-horizontal formdetails','role'=>'form','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control')));?>
	<!--<form class="form-horizontal formdetails" role="form"> -->
		
		<div class="row marginleftrightzero paddingbottom20">
					<div class="col-sm-offset-3  col-lg-offset-2 col-md-offset-3 col-md-7 col-lg-3 col-xs-12 paddingleftrightzero footerbutton">
						<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('escape'=>FALSE,'class'=>'btn btn-info button_mobile','type'=>'submit'));?>
						<?php echo $this->Html->link('<i class="icon-remove bigger-110"></i> Cancel',array('action'=>'organisationProfile'),array('class'=>'btn btn-inverse button_mobile','escape'=>FALSE));?>
					</div>
		</div>
		<div class="row marginleftrightzero">
			<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-3 col-lg-2 col-xs-12 col-md-3 control-label marginleftrightzero paddingleftrightzero">Organization Name</label>
						<div class="col-sm-3 col-lg-2 col-xs-12 col-md-3 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('organisation_name',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['organization_name']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-3 col-md-3 col-lg-2 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Home Currency</label>
						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 marginleftrightzero paddingleftrightzero countrybilling">
							<?php 
								if(empty($inventory) && empty($invoice) && empty($quote) && empty($expense)) {
									echo $this->Form->input('cpn_currency_id',array('options'=>array($currencyList),'default'=>$final['currency']['CpnCurrency']['id'],'class'=>'selectpicker form-control'));
							 	} else {
							 		echo $currencyList[$final['currency']['CpnCurrency']['id']];
							 	}
							?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Language</label>
						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 marginleftrightzero paddingleftrightzero choosen_width">
							<?php echo $this->Form->input('cpn_language_id',array('options'=>array($languageList),'default'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['cpn_language_id'],'class'=>'invdrop form-control'));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Financial Year</label>
						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 marginleftrightzero paddingleftrightzero choosen_width">
							<?php echo $this->Form->input('cpn_financial_id',array('options'=>array($financialYearList),'default'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['cpn_financial_year_id'],'class'=>'invdrop form-control'));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label marginleftrightzero paddingleftrightzero">VAT Number</label>
						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('vat_no',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['vat_no']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Registration Number</label>
						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('reg_no',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['reg_no']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="col-sm-12 col-md-12 col-xs-12 col-lg-12 contactdetails paddingleftrightzero">
						<h5>Billing Address</h5>
					</div>
				</div>
				<div class="row marginleftrightzero">

					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Address Line1 </label>

						<div class="col-sm-3 col-lg-3 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('billing_address_line1',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['billing_address_line1']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero"> Address Line2 </label>

						<div class="col-sm-3 col-lg-3 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('billing_address_line2',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['billing_address_line2']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero"> Country </label>
						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero countrybilling choosen_width">
							<?php echo $this->Form->input('billing_country_code',array('options'=>array(''=>'',$countryList),'default'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['billing_country_code'],'data-placeholder'=>"Select Country",'class'=>'invdrop form-control','data-live-search' => 'true'));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > City </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('billing_city',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['billing_city']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Proviance/State </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('billing_state',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['billing_state']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero"> Postal/ZipCode </label>

						<div class="col-sm-3 col-lg-1 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('billing_zip',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['billing_zip']));?>
						</div>
					</div>

				</div>
				<div class="row marginleftrightzero">
					<div class="col-sm-12 col-md-12 col-xs-12 col-lg-12 contactdetails paddingleftrightzero">
						<h5>Shipping Address</h5>
						<div class="col-lg-6 paddingtop5 col-xs-12 marginleftrightzero paddingleftrightzero">
							<label>
								<input id="identitcal" class="ace" type="checkbox">
								<span class="lbl"></span> </label>
							<label class="maillabel sameasbilling">Same as Billing Address</label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero disabledinput">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Address Line1 </label>

						<div class="col-sm-3 col-lg-3 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('shipping_address_line1',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['shipping_address_line1']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero disabledinput">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Address Line2 </label>

						<div class="col-sm-3 col-lg-3 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('shipping_address_line2',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['shipping_address_line2']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero optionselect">
					<div class="form-group marginleftrightzero disabledinput">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Country </label>
						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero countrybilling choosen_width">
							<?php echo $this->Form->input('shipping_country_code',array('options'=>array(''=>'',$countryList),'default'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['shipping_country_code'],'data-placeholder'=>"Select counrty",'class'=>'invdrop form-control','data-live-search' => 'true'));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero disabledinput">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero"> City </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('shipping_city',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['shipping_city']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero disabledinput">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Proviance/State </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('shipping_state',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['shipping_state']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero disabledinput">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Postal/ZipCode </label>

						<div class="col-sm-3 col-lg-1 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('shipping_zip',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['shipping_zip']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="col-sm-12 col-md-12 col-xs-12 col-lg-12 contactdetails paddingleftrightzero"></div>
				</div>
				<!-- <div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Tax Name </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<input type="text"  class="form-control" />
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Tax Number </label>

						<div class="col-sm-3 col-lg-1 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<input type="text"   class="form-control" />
						</div>
					</div>
				</div> -->
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero"> Website </label>
						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('website',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['website']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Business Phone </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('phone',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['phone']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Business Fax </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('fax',array('value'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['fax']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Time Zone </label>
						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('time_zone',array('options'=>array($final['time_zones']),'default'=>$final['organisationDetail']['SbsSubscriberOrganizationDetail']['time_zone'],'class'=>'selectpicker form-control','data-live-search' => 'true'));?>
						</div>
						<div class="col-lg-4 paddingtop5 col-xs-12 ">
							<label>
								<input class="ace" type="checkbox">
								<span class="lbl"></span> </label>
							<label class="maillabel sameasbilling">Daylight Saving</label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="col-sm-12 col-md-12 col-xs-12 col-lg-12 contactdetails paddingleftrightzero">
						<h5>Primary Contact Details</h5>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Contact First Name </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('first_name',array('value'=>$final['adminUserDetails']['User']['firstname']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Contact Last Name </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('last_name',array('value'=>$final['adminUserDetails']['User']['lastname']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Home Phone </label>
						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('home_phone',array('value'=>$final['adminUserDetails']['User']['home_phone']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero"> Mobile </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('primary_mobile',array('value'=>$final['adminUserDetails']['User']['mobile']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Contact Email </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('email',array('value'=>$final['adminUserDetails']['User']['email']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label class="col-sm-3 col-lg-2 col-md-3 col-xs-12 control-label paddingleftrightzero marginleftrightzero" > Username </label>

						<div class="col-sm-3 col-lg-2 col-md-3 col-xs-12 paddingleftrightzero marginleftrightzero">
							<?php echo $this->Form->input('username',array('value'=>$final['adminUserDetails']['User']['username']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="col-sm-12 col-md-12 col-xs-12 col-lg-12 contactdetails paddingleftrightzero"></div>
				</div>
				<div class="row marginleftrightzero">
					<div class="col-sm-offset-3  col-lg-offset-2 col-md-offset-3 col-md-7 col-lg-3 col-xs-12 paddingleftrightzero footerbutton">
						<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('escape'=>FALSE,'class'=>'btn btn-info button_mobile','type'=>'submit'));?>
						<?php echo $this->Html->link('<i class="icon-remove bigger-110"></i> Cancel',array('action'=>'organisationProfile'),array('class'=>'btn btn-inverse button_mobile','escape'=>FALSE));?>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- /.page-content -->
<script type="text/javascript">
	$(function(){
		
		/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
		
		
		if ($('.selectpicker').length) {
			$('.selectpicker').selectpicker({
			});
		}
		$('#OrganisationProfileShippingCountryCode').val($('#OrganisationProfileBillingCountryCode').val());
		$('#OrganisationProfileBillingCountryCode').on("change",function(){
			$('#OrganisationProfileShippingCountryCode').val($(this).val());
		});
		
		
		//$('#OrganisationProfileBillingCountryCode option:selected').attr('rel');
		
		
		$( "input#identitcal" ).on( "click", function(){
			if($(this).is(':checked')) {
				$('.disabledinput input , .disabledinput select').prop('readonly','readonly');
				var addr1 = $("input[name='data[OrganisationProfile][billing_address_line1]']").val();
				$("input[name='data[OrganisationProfile][shipping_address_line1]']").val(addr1);
				
				var addr2 = $("input[name='data[OrganisationProfile][billing_address_line2]']").val();
				$("input[name='data[OrganisationProfile][shipping_address_line2]']").val(addr2);
				
				var country = $("select[name='data[OrganisationProfile][billing_country_code]']").val();
				$('.optionselect .bootstrap-select span.filter-option').text($('#OrganisationProfileShippingCountryCode option:selected').text());
				
				var city = $("input[name='data[OrganisationProfile][billing_city]']").val();
				$("input[name='data[OrganisationProfile][shipping_city]']").val(city);
				
				var state = $("input[name='data[OrganisationProfile][billing_state]']").val();
				$("input[name='data[OrganisationProfile][shipping_state]']").val(state);
				
				var zip = $("input[name='data[OrganisationProfile][billing_zip]']").val();
				$("input[name='data[OrganisationProfile][shipping_zip]']").val(zip);
				
			} else {
				$('.disabledinput input , .disabledinput select').prop('readonly',false);
				$("input[name='data[OrganisationProfile][shipping_address_line1]']").val('');
				$("input[name='data[OrganisationProfile][shipping_address_line2]']").val('');
				$("input[name='data[OrganisationProfile][shipping_city]']").val('');
				$("input[name='data[OrganisationProfile][shipping_state]']").val('');
				$("input[name='data[OrganisationProfile][shipping_zip]']").val('');
				$("input[name='data[OrganisationProfile][shipping_country_code]']").val('');
				$('.optionselect .bootstrap-select span.filter-option').text('');
			}
		});
		
		$("#OrganisationProfileUpdateOrganisationDetailsForm").validate({
			onkeyup: false,
			rules: {
				'data[OrganisationProfile][email]' : {
					required : true,
					checkEmailAvailability : true
				},
				'data[OrganisationProfile][username]' : { 
				 	checkUserNameAvailability : true
			     }
			},
			messages: {
				'data[OrganisationProfile][email]' : {
					required : 'Email cannot be empty.'
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
				url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>subscribers/checkAdminEmail/<?php echo $final['adminUserDetails']['User']['id']?>",
			   	type: 'POST',
			    async: false,
			    data: $("#OrganisationProfileUpdateOrganisationDetailsForm").serialize()
			 }).responseText;	 	
			 if(x=="true") return false;
			 else return true;
		},"Email already exit.");
		
		$.validator.addMethod("checkUserNameAvailability",function(value,element){				
			var x= $.ajax({
				url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>subscribers/checkAdminUsername/<?php echo $final['adminUserDetails']['User']['id']?>",
			   	type: 'POST',
			    async: false,
			    data: $("#OrganisationProfileUpdateOrganisationDetailsForm").serialize()
			 }).responseText;	 	
			 if(x=="true") return false;
			 else return true;
		},"User Name already exit.");
		
	});
</script>
<?php echo $this->Js->writeBuffer();?>