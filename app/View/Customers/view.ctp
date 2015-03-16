<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
        <li>								
			<?php echo $this->Html->link('Customers', array('controller' => 'customers', 'action' => 'index'), array('div' => false,'escape' => false)); ?>
		</li>
		<li class="active">View Customer</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			View Customer
            <span class="header-span">
                <i class="icon-double-angle-right"></i>
                <?php echo $client_detail['AcrClient']['client_name']; ?>
            </span>								
		</h1>
        <div class="col-lg-2 paddingleftrightzero">
             <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index',$org,$client,$eml,$st,'page:'.$page),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
        </div>
	</div>
    <!-- /.page-header -->
        <div class="row">
				<div class="col-xs-12 customer_view">
				  <div class="manage_customer_view_left">
                   <div class="col-xs-12">
                      <div class="form-horizontal" >
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Organization Name </label>            
                                <label class="col-sm-8 control-label no-padding-right bold no-padding-left " ><?php echo $client_detail['AcrClient']['organization_name']; ?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Currency Code </label>            
                                <label class="col-sm-8 control-label no-padding-right bold no-padding-left " ><?php echo $client_detail['CpnCurrency']['code']; ?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Language </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $client_detail['CpnLanguage']['language']; ?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Send Invoices By </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " > 
                                    <?php if($client_detail['AcrClient']['send_invoice_by'] == 'email'){
                                    	      echo "Email";
                                          
                                          } else{
                                          	  echo "Snail Mail";
                                          }
                                    ?>
                                </label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Business Phone </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $client_detail['AcrClient']['business_phone']; ?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Business Tax </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $client_detail['AcrClient']['business_fax']; ?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Status </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left paid" >
                                       <?php if($client_detail['AcrClient']['status'] == 'active'){
                                       	        echo "Active";
                                             }else{
                                             	echo "Inactive";
                                             } ?>
                                </label>
                            </div>
                             <?php if($client_detail['AcrClient']['notes']){ ?>
                            	   <div class="form-group marginbottom5">
                                     <label class="col-sm-4 control-label no-padding-right no-padding-left " >Notes</label>           
                                     <label class="col-sm-8 control-label no-padding-right bolder no-padding-left"><?php echo $client_detail['AcrClient']['notes']; ?></label>
                                 </div>	
                            <?php } ?>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Payment Terms </label>           
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left"><?php echo $paymentTerm['SbsSubscriberPaymentTerm']['term']; ?></label>
                            </div>	
                           
                             	
                            				
                      </div>
                   </div>
                   <div class="col-xs-12 contactdetails paddingleftrightzero customerdetails">
                        <h5>Primary Contact</h5>
                   </div>
                   <div class="col-xs-12">
                      <div class="form-horizontal" >
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Contact Name </label>            
                                <label class="col-sm-8 control-label no-padding-right bold no-padding-left " ><?php echo $primary_client_contact['AcrClientContact']['name'];?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Contact Surname </label>            
                                <label class="col-sm-8 control-label no-padding-right bold no-padding-left " ><?php echo $primary_client_contact['AcrClientContact']['sur_name'];?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Contact Email </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $primary_client_contact['AcrClientContact']['email'];?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Mobile </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $primary_client_contact['AcrClientContact']['mobile'];?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Home Phone </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $primary_client_contact['AcrClientContact']['home_phone'];?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Work Phone </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $primary_client_contact['AcrClientContact']['work_phone'];?></label>
                            </div>                                                								
                      </div>
                   </div>
                   
                     <?php $i=0; foreach($client_contact_details as $key=>$value): 
                           if($value['AcrClientContact']['is_primary'] == 'N'){ $i++; ?>
                           	
                          
				    <div class="col-xs-12 contactdetails paddingleftrightzero customerdetails">
                        <h5>Contact <?php echo $i; ?> Details</h5>
                   </div>
                   <div class="col-xs-12">
                      <div class="form-horizontal" >
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Contact Name </label>            
                                <label class="col-sm-8 control-label no-padding-right bold no-padding-left " ><?php echo $value['AcrClientContact']['name']; ?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Contact Surname </label>            
                                <label class="col-sm-8 control-label no-padding-right bold no-padding-left " ><?php echo $value['AcrClientContact']['sur_name']; ?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Contact Email </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $value['AcrClientContact']['email']; ?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Mobile </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $value['AcrClientContact']['mobile']; ?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Home Phone </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $value['AcrClientContact']['home_phone']; ?></label>
                            </div>
                            <div class="form-group marginbottom5">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " > Work Phone </label>            
                                <label class="col-sm-8 control-label no-padding-right bolder no-padding-left " ><?php echo $value['AcrClientContact']['work_phone']; ?></label>
                            </div>                                                								
                      </div>
                   </div>
                    <?php } ?>
                   <?php endforeach;?> 
                   
                   <?php if($field_names){  ?>
				   <div class="col-xs-12 contactdetails paddingleftrightzero customerdetails">
                        <h5>Additional Information</h5>
                   </div>
                   
                   <div class="col-xs-12">
                      <div class="form-horizontal" >
                      
                            <?php $f=0; foreach($field_names as $k=>$v): $f++; ?>
                            <div class="form-group ">
                                <label class="col-sm-4 control-label no-padding-right no-padding-left " ><?php echo $v; ?></label>            
                                <label class="col-sm-8 control-label no-padding-right bold no-padding-left " ><?php echo $fieldValues[$k]; ?></label>
                            </div>
							<?php endforeach;?> 
							                                       								
                      </div>
                   </div>
                   <?php } ?>
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
                                <label class="col-sm-5 control-label no-padding-right no-padding-left " > Amount Due </label>            
                                <label class="col-sm-7 control-label no-padding-right bold no-padding-left"><?php echo $this->Number->currency($amount_due,$client_detail['CpnCurrency']['code']);?></label>
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
							<?php if(!empty($client_detail['AcrClient']['billing_address_line1'])):?>
							  <div class="form-group  marginleftrightzero marginbottom5">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $client_detail['AcrClient']['billing_address_line1']; ?></label>
                              </div>
                             <?php endif;?>
                             <?php if(!empty($client_detail['AcrClient']['billing_address_line2'])):?>
							  <div class="form-group  marginleftrightzero marginbottom5">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo  $client_detail['AcrClient']['billing_address_line2']; ?></label>
                              </div>
                              <?php endif;?>
                              <?php if(!empty($client_detail['AcrClient']['billing_city']) || !empty($client_detail['AcrClient']['billing_state'])):?>
							  <div class="form-group  marginleftrightzero marginbottom5">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php if(!empty($client_detail['AcrClient']['billing_city'])){echo  $client_detail['AcrClient']['billing_city']; ?>, <?php }?><?php echo $client_detail['AcrClient']['billing_state'] ; ?></label>
                              </div>
                              <?php endif;?>
                              <?php if(!empty($client_detail['AcrClient']['billing_country'])):?>
							  <div class="form-group  marginleftrightzero marginbottom5">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $client_detail['AcrClient']['billing_country'] ; ?></label>
                              </div>
                              <?php endif;?>
                              <?php if(!empty($client_detail['AcrClient']['billing_zip'])):?>
							  <div class="form-group  marginleftrightzero lastrow marginbottom5">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $client_detail['AcrClient']['billing_zip'] ; ?></label>
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
								<?php if(!empty($client_detail['AcrClient']['shiping_address_line1'])):?>
							  <div class="form-group  marginleftrightzero marginbottom5">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $client_detail['AcrClient']['shiping_address_line1']; ?></label>
                              </div>
                              <?php endif;?>
                              <?php if(!empty($client_detail['AcrClient']['shipping_address_line2'])):?>
							  <div class="form-group  marginleftrightzero marginbottom5">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $client_detail['AcrClient']['shipping_address_line2']; ?></label>
                              </div>
                              <?php endif;?>
                              <?php if(!empty($client_detail['AcrClient']['shipping_city']) || !empty($client_detail['AcrClient']['shipping_state'])):?>
							  <div class="form-group  marginleftrightzero marginbottom5">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php if(!empty($client_detail['AcrClient']['shipping_city'])) {echo $client_detail['AcrClient']['shipping_city']; ?> ,<?php }?><?php echo $client_detail['AcrClient']['shipping_state']; ?></label>
                              </div>
                              <?php endif;?>
                              <?php if(!empty($client_detail['AcrClient']['shipping_country'])):?>
							  <div class="form-group  marginleftrightzero marginbottom5">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $client_detail['AcrClient']['shipping_country']; ?></label>
                              </div>
                              <?php endif;?>
                              <?php if(!empty($client_detail['AcrClient']['shipping_zip'])):?>
							  <div class="form-group  marginleftrightzero lastrow">                                                               
                                <label class="col-sm-12 control-label no-padding-right no-padding-left " ><?php echo $client_detail['AcrClient']['shipping_zip']; ?></label>
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


        
	