<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			 <?php echo $this -> Html -> link('Home', array('controller' => '', 'action' => 'index'), array('div' => false, 'escape' => false)); ?>
		</li>
        <li>								
			<?php echo $this -> Html -> link('Subscribers', array('controller' => 'subscribers', 'action' => 'index'), array('div' => false, 'escape' => false)); ?>
		</li>
		<li class="active">View Subscriber</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			View Subscriber
            <span class="header-span">
                <i class="icon-double-angle-right"></i>
                <?php echo $subscriberDetail['SbsSubscriber']['fullname']; ?>
            </span>								
		</h1>
        <div class="col-lg-2 paddingleftrightzero">
             <?php echo $this->Js->link('<i class="icon-arrow-left icon-on-left"></i>Back', array('action' => 'index',$plan,$company,$subscriberName,'page:'.$page), array('update'=>'#content','class' => 'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
        </div>
	</div>
    <!-- /.page-header -->
        <div class="row subscriber_view">
				<div class="col-xs-12">
				  <div class="manage_customer_view_left">
                   <div class="col-xs-12">
                      <div class="form-horizontal" >
                            <div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Organization Name </label>            
                                <label class="col-sm-9 control-label no-padding-right bold no-padding-left " ><?php if($subscriberDetail['SbsSubscriberOrganizationDetail']['organization_name']) {echo $subscriberDetail['SbsSubscriberOrganizationDetail']['organization_name'];} else { echo 'N/A';} ?></label>
                            </div>
                            <!--<div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Language </label>            
                                <label class="col-sm-9 control-label no-padding-right bolder no-padding-left " ><?php echo $subscriberDetail['CpnLanguage']['language']; ?></label>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Send Invoices By </label>            
                                <label class="col-sm-9 control-label no-padding-right bolder no-padding-left " > Email </label>
                            </div> -->
                            <div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Business Phone </label>            
                                <label class="col-sm-9 control-label no-padding-right bolder no-padding-left " ><?php if($subscriberDetail['SbsSubscriberOrganizationDetail']['phone']) {echo $subscriberDetail['SbsSubscriberOrganizationDetail']['phone'];} else { echo 'N/A';} ?></label>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Business Tax </label>            
                                <label class="col-sm-9 control-label no-padding-right bolder no-padding-left " ><?php if($subscriberDetail['SbsSubscriberOrganizationDetail']['fax']){echo $subscriberDetail['SbsSubscriberOrganizationDetail']['fax'];} else {echo 'N/A';} ?></label>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Status </label>            
                                <label class="col-sm-9 control-label no-padding-right bolder no-padding-left paid" >
                                       <?php echo $subscriberDetail['SbsSubscriber']['status'];?>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Plan Type </label>           
                                <label class="col-sm-9 control-label no-padding-right bolder no-padding-left"><?php if($subscriberDetail['CpnSubscriptionPlan']['type']) {echo $subscriberDetail['CpnSubscriptionPlan']['type'];} else { echo 'N/A';} ?></label>
                            </div>						
                      </div>
                   </div>
                   <div class="col-xs-12 contactdetails paddingleftrightzero customerdetails">
                        <h5>Contact details</h5>
                   </div>
                   <div class="col-xs-12">
                      <div class="form-horizontal" >
                            <div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Contact Name </label>            
                                <label class="col-sm-9 control-label no-padding-right bold no-padding-left " ><?php if($subscriberDetail['SbsSubscriber']['name']) {echo $subscriberDetail['SbsSubscriber']['name'];} else { echo 'N/A';} ?></label>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Contact Surname </label>            
                                <label class="col-sm-9 control-label no-padding-right bold no-padding-left " ><?php if($subscriberDetail['SbsSubscriber']['surname']) {echo $subscriberDetail['SbsSubscriber']['surname'];} else { echo 'N/A'; } ?></label>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Contact Email </label>            
                                <label class="col-sm-9 control-label no-padding-right bolder no-padding-left " ><?php if($subscriberDetail['User']['email']) {echo $subscriberDetail['User']['email'];} else {echo 'N/A'; } ?></label>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Mobile </label>            
                                <label class="col-sm-9 control-label no-padding-right bolder no-padding-left " ><?php if($subscriberDetail['SbsSubscriber']['mobile']) {echo $subscriberDetail['SbsSubscriber']['mobile'];} else {echo 'N/A';} ?></label>
                            </div>
                            <div class="form-group ">
                                <label class="col-sm-3 control-label no-padding-right no-padding-left " > Home Phone </label>            
                                <label class="col-sm-9 control-label no-padding-right bolder no-padding-left " ><?php if($subscriberDetail['SbsSubscriber']['home_phone']) {echo $subscriberDetail['SbsSubscriber']['home_phone'];} else { echo 'N/A';} ?></label>
                            </div>
                      </div>
                   </div>
                   
				   
				   </div>
				   <div class="manage_customer_view_right">
                   <div class="col-xs-12 widgetpadding">
				     <div class="widget-box">
						<div class="widget-header">
							<h5>Account Details</h5>
						</div>

						<div class="widget-body">
							<div class="widget-main">
							  <div class="form-group">
                                <label class="col-sm-6 col-md-3 control-label no-padding-right no-padding-left " > Amount Due </label>            
                                <label class="col-sm-6 col-md-9 control-label no-padding-right bold no-padding-left " >$<?php if(!empty($amount_due['0']['balance'])) { $yyy = explode('.', $amount_due['0']['balance']);if($yyy['1']) echo $amount_due['0']['balance']; else echo $amount_due['0']['balance'].'.00';} else {echo '0.00';} ?></label>
                              </div> 
							</div>
						</div>
					</div>
					
					 <div class="widget-box">
						<div class="widget-header">
							<h5>Billing Address</h5>
						</div>

						<div class="widget-body">
							<div class="widget-main paddingleftrightzero">
							<div class="form-horizontal">
							 <?php if(!empty($subscriberDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'])):?>
							  <div class="form-group  marginleftrightzero">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['billing_address_line1']; ?></label>
                              </div>
                              <?php endif;?>
                              <?php if(!empty($subscriberDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'])):?>
							  <div class="form-group  marginleftrightzero">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['billing_address_line2']; ?></label>
                              </div>
                              <?php endif;?>
                              <?php if(!empty($subscriberDetail['SbsSubscriberOrganizationDetail']['billing_city']) || !empty($subscriberDetail['SbsSubscriberOrganizationDetail']['billing_state'])):?>
							  <div class="form-group  marginleftrightzero">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['billing_city']; ?>,<?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['billing_state']; ?></label>
                              </div>
                               <?php endif;?>
                              <?php if(!empty($subscriberDetail['SbsSubscriberOrganizationDetail']['billing_country'])):?>
							  <div class="form-group  marginleftrightzero">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['billing_country']; ?></label>
                              </div>
                               <?php endif;?>
                              <?php if(!empty($subscriberDetail['SbsSubscriberOrganizationDetail']['billing_zip'])):?>
							  <div class="form-group  marginleftrightzero lastrow">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['billing_zip']; ?></label>
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
								<?php if(!empty($subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_address_line1'])):?>
							  <div class="form-group  marginleftrightzero">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_address_line1']; ?></label>
                              </div>
                               <?php endif;?>
                              <?php if(!empty($subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_address_line2'])):?>
							  <div class="form-group  marginleftrightzero">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_address_line2']; ?></label>
                              </div>
                               <?php endif;?>
                              <?php if(!empty($subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_city']) || !empty($subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_state'])):?>
							  <div class="form-group  marginleftrightzero">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_city']; ?> ,<?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_state']; ?></label>
                              </div>
                               <?php endif;?>
                              <?php if(!empty($subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_country'])):?>
							  <div class="form-group  marginleftrightzero">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_country']; ?></label>
                              </div>
                               <?php endif;?>
                              <?php if(!empty($subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_zip'])):?>
							  <div class="form-group  marginleftrightzero lastrow">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $subscriberDetail['SbsSubscriberOrganizationDetail']['shipping_zip']; ?></label>
                              </div>
                              <?php endif;?>
							 </div> 
							</div>
						</div>
					</div>
					</div>										
                   </div>     									
                </div>
      </div>
</div>
<?php echo $this->Js->writeBuffer();?>