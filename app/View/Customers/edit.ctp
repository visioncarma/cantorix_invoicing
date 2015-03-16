<?php echo $this->Session->flash();?>
<?php echo $this->Form->create('AcrClient');?>

	<div class="breadcrumbs" id="breadcrumbs">
		<script type="text/javascript">
			try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
		</script>

		<ul class="breadcrumb">
			<li>
				<i class="icon-home home-icon"></i>
				 <?php echo $this->Html->link('Home', array('controller' => '', 'action' => 'index'), array('div' => false,'escape' => false)); ?>
			</li>
            <li>								
				<?php echo $this->Html->link('Customers', array('controller' => 'customers', 'action' => 'index'), array('div' => false,'escape' => false)); ?>
			</li>
			<li class="active">Edit Customer</li>
		</ul>
	</div>

	<div class="page-content editCustomer">
		<div class="page-header">
			<h1>
				Edit Customer								
			</h1>
            <div class="col-lg-2 col-xs-2 paddingleftrightzero">
               <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index',$org,$client,$eml,$st,'page:'.$page),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
            </div>
		</div>
        <!-- page-header -->
            <div class="row">
					<div class="col-xs-12">
					
                      <div class="form-horizontal customerform" role="form">
                      	
                      		 <!--<div class="clearfix form-actions margintopzero paddingtopzero editformbutton">
							<div class="col-md-offset-2 col-md-2">
								<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Update',array('class'=>'btn btn-info forgetval','escape'=>false));?>
                            </div>
							</div>-->
							
							<div class="form-group">
                                <!--<label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">&nbsp; </label>-->

                                <div class="col-xs-12 col-sm-4 col-lg-3 col-md-offset-2 footerbutton">
                                   <?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Update',array('class'=>'btn btn-info forgetval button_mobile','escape'=>false));?>
                                	<div class="btn btn-inverse colorproblem button_mobile">
										<!--<a href="#"><i class="icon-remove bigger-110"></i> Cancel</a>-->
										<?php echo $this->Html->link('Cancel',array('controller'=>'customers','action'=>'index'),array('class'=>'icon-remove bigger-110'));?>
									</div>
                                </div>
                            </div>
							
							<div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Organization Name <em class="red" >&lowast;</em>  </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                   <?php echo $this->Form->input('organization_name',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$client_detail['AcrClient']['organization_name']));?>  
                                </div>
                            </div>
					        <!--<div class="space-4"></div>-->
							<div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Currency Code <em class="red" >&lowast;</em>  </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3 countrybilling max-height max-width choosen_width">
                                  <?php if($clientInvoice == 'Exists'){ 
                                  	        echo $this->Form->input('cpn_currency_id',array('div'=>FALSE,'label'=>FALSE,'data-live-search' => 'true','class'=>'col-sm-5 col-xs-12 col-lg-3 form-control invdrop selectitem ','data-placeholder'=>"Select a Currency", 'disabled'=>"disabled",'options'=>array(''=>'',$currencies),'value'=>$client_detail['AcrClient']['cpn_currency_id']));
                                        }else{ 
                                        	echo $this->Form->input('cpn_currency_id',array('div'=>FALSE,'label'=>FALSE,'data-live-search' => 'true','class'=>'col-sm-5 col-xs-12 col-lg-3 form-control invdrop selectitem ','data-placeholder'=>"Select a Currency", 'options'=>array(''=>'',$currencies),'value'=>$client_detail['AcrClient']['cpn_currency_id']));
                                        } 
                                  
                                  ?>                                                 
							    </div>
                            </div>
					        <!--<div class="space-4"></div>-->
							<div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Language </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3 countrybilling max-height max-width choosen_width">
                                    <?php echo $this->Form->input('cpn_language_id',array('div'=>FALSE,'label'=>FALSE,'data-live-search' => 'true','class'=>'col-sm-5 col-xs-12 col-lg-3 form-control invdrop selectitem ','data-placeholder'=>"Select a Language", 'options'=>array(''=>'',$languages),'value'=>$client_detail['AcrClient']['cpn_language_id']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Website</label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                   <?php echo $this->Form->input('website',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$client_detail['AcrClient']['website']));?>  
                                </div>
                            </div>
					        <!--<div class="space-4"></div>-->
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2  control-label no-padding-right">Send Invoices By</label>        
                                <div class="col-xs-12 col-sm-3 col-lg-3">
                                    <label>
                                        <?php if($client_detail['AcrClient']['send_invoice_by'] == 'email'){
                                        	     echo $this->Form->input('send_invoice_byEmail',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace email1','checked'=>'checked'));
                                              }else{
                                              	echo $this->Form->input('send_invoice_byEmail',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace email2'));
                                              }
                                        
                                         ?>                     
                                         <span class="lbl"></span>
                                     </label>
                                     <label class="maillabel">Email</label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Payment Terms <em class="red" >&lowast;</em>  </label>
 
                                <div class="col-xs-12 col-sm-5 col-lg-3 choosen_width">
                                    <?php echo $this->Form->input('sbs_subscriber_payment_term_id',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-sm-5 col-xs-12 col-lg-3 form-control invdrop selectitem ','data-placeholder'=>"Select a Payment Terms", 'options'=>array(''=>'',$payment_terms),'default'=>$client_detail['AcrClient']['sbs_subscriber_payment_term_id']));?>  
                                </div>
                            </div>
                           
                            <?php $c=0; foreach($client_contact_details as $key1=>$value1): $c++; ?>
                            <?php echo $this->Form->hidden('Edit.'.'Contact'.$c.'.'.'contactid',array('value'=>$value1['AcrClientContact']['id']));?> 
					        <div class="space-4"></div>										
					        <div class="col-sm-12 contactdetails paddingleftrightzero">
                              <h5>Contact <?php echo $c; ?> Details</h5>
                            </div>
                           
					        <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2  control-label no-padding-right">Contact Name <em class="red" >&lowast;</em>  </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                    <?php echo $this->Form->input('Edit.'.'Contact'.$c.'.'.'name',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$value1['AcrClientContact']['name']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2  control-label no-padding-right">Contact Surname <em class="red" >&lowast;</em>  </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                   <?php echo $this->Form->input('Edit.'.'Contact'.$c.'.'.'sur_name',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$value1['AcrClientContact']['sur_name']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Contact Email <em class="red" >&lowast;</em>  </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                    <?php echo $this->Form->input('Edit.'.'Contact'.$c.'.'.'email',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$value1['AcrClientContact']['email']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2  control-label no-padding-right">Mobile</label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                   <?php echo $this->Form->input('Edit.'.'Contact'.$c.'.'.'mobile',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$value1['AcrClientContact']['mobile'],'onkeypress' => "return isNumberKey(event)"));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2  control-label no-padding-right"> Home Phone </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                    <?php echo $this->Form->input('Edit.'.'Contact'.$c.'.'.'home_phone',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$value1['AcrClientContact']['home_phone'],'onkeypress' => "return isNumberKey(event)"));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2  control-label no-padding-right"> Work Phone </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                     <?php echo $this->Form->input('Edit.'.'Contact'.$c.'.'.'work_phone',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$value1['AcrClientContact']['work_phone'],'onkeypress' => "return isNumberKey(event)"));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-3 col-sm-3 col-lg-2 control-label no-padding-right">Primary</label>        
                                <div class="col-xs-9 col-sm-3 col-lg-3">
                                    <label>
                                          <?php if($value1['AcrClientContact']['is_primary'] == 'Y'){
                                          	  echo $this->Form->input('Edit.'.'Contact'.$c.'.'.'is_primary',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace primarycheck','checked'=>'checked')); 
                                          }else{
                                          	  echo $this->Form->input('Edit.'.'Contact'.$c.'.'.'is_primary',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace primarycheck'));
                                          } ?>
                                          <span class="lbl"></span>
                                     </label>
                                     <span class="help-button customer-help-button blue_back" data-rel="popover" data-trigger="hover" data-placement="right" data-content="select to make it your primary contact">?</span>
                                     
                                </div>
                            </div>  
                            <?php endforeach;?>
                             
                            <div class="newcontactadd"></div>  
                            
                            <div class="col-sm-12 borderline col-xs-12"></div>
                             <div class="col-sm-12 paddingtopbottom2 col-xs-12 nopaddingleft nopaddingright">
                                <!--<div class="col-sm-5 nopaddingleft nopaddingright"></div>-->
                                <div class="col-sm-3 nopaddingleft nopaddingright">
                                <a class="btn btn-sm btn-success pull-left addbutton">
                                          <i class="icon-plus"></i>                                               
                                </a>
                                <label class="addcontact">Add Contact</label>
                            </div>
                            </div>
                            <div class="col-sm-12 borderline marginbottom3 col-xs-12"></div>                                            
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right col-xs-12">Business Phone </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                     <?php echo $this->Form->input('business_phone',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$client_detail['AcrClient']['business_phone']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Business Fax </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                     <?php echo $this->Form->input('business_fax',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$client_detail['AcrClient']['business_fax']));?>  
                                </div>
                            </div>
                             <div class="col-sm-12 borderline marginbottom3 col-xs-12"></div>  
                             <!-- collapse ends -->
                             
                             
                              <div class="col-sm-12 paddingtopbottom2 col-xs-12 nopaddingleft nopaddingright">
                               <!-- <div class="col-sm-5 nopaddingleft nopaddingright"></div>-->
                                <div class="col-sm-4 nopaddingleft nopaddingright">
                                <a class="btn btn-sm btn-success pull-left addmorebutton">
                                          <i class="icon-plus"></i>                                               
                                </a>
                                <label class="addcontact">Update More Customer Details</label>
                            </div>
                            </div>  
                             
                           
							 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 showdetails">		
								
                            <div class="col-sm-12 contactdetails paddingleftrightzero">
                              <h5>Billing Address</h5>
                            </div>
					        <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Address Line1 </label>

                                <div class="col-xs-12 col-sm-5 col-lg-4">
                                    <?php echo $this->Form->input('billing_address_line1',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billadd1 form-control','value'=>$client_detail['AcrClient']['billing_address_line1']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Address Line2 </label>

                                <div class="col-xs-12 col-sm-5 col-lg-4">
                                     <?php echo $this->Form->input('billing_address_line2',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billadd2 form-control','value'=>$client_detail['AcrClient']['billing_address_line2']));?>  
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> City </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                    <?php echo $this->Form->input('billing_city',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billcity form-control','value'=>$client_detail['AcrClient']['billing_city']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Province/State </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                    <?php echo $this->Form->input('billing_state',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billstate form-control','value'=>$client_detail['AcrClient']['billing_state']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Country </label>        
                                <div class="col-xs-12 col-sm-5 col-lg-3 countrybilling max-height max-width">
                                	
                                    <?php echo $this->Form->input('billing_country',array('div'=>FALSE,'data-live-search'=>'true','label'=>FALSE,'class'=>'col-sm-5 col-xs-12 col-lg-3 form-control selectpicker selectitem billcountry','options'=>array(''=>'Select',$countries),'default'=>$client_detail['AcrClient']['billing_country']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Postal/ZipCode </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                   <?php echo $this->Form->input('billing_zip',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billzip form-control','value'=>$client_detail['AcrClient']['billing_zip']));?>  
                                </div>
                            </div>
                            <div class="col-sm-12 contactdetails paddingleftrightzero">
                              <h5>Shipping Address</h5>
                              <div class="col-lg-6 paddingtop5 nopaddingright nopaddingleft">
                                   <label>
                                             <?php echo $this->Form->input('shipping_address',array('id'=>'shipaddress','type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace newclass'));?>    
                                               <span class="lbl"></span>
                                         </label>
                                   <label class="maillabel sameasbilling">Same as Billing Address</label>
                               </div>
                            </div>
					        <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Address Line1 </label>

                                <div class="col-xs-12 col-sm-5 col-lg-4">
                                    <?php echo $this->Form->input('shiping_address_line1',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipadd1 form-control','value'=>$client_detail['AcrClient']['shiping_address_line1']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Address Line2 </label>

                                <div class="col-xs-12 col-sm-5 col-lg-4">
                                    <?php echo $this->Form->input('shipping_address_line2',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipadd2 form-control','value'=>$client_detail['AcrClient']['shipping_address_line2']));?>  
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> City </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                    <?php echo $this->Form->input('shipping_city',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipcity form-control','value'=>$client_detail['AcrClient']['shipping_city']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Province/State </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                    <?php echo $this->Form->input('shipping_state',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipstate form-control','value'=>$client_detail['AcrClient']['shipping_state']));?>  
                                </div>
                            </div>
                            <div class="form-group optionselect">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Country </label>        
                                <div class="col-xs-12 col-sm-5 col-lg-3 countrybilling max-height max-width">
                                   <?php echo $this->Form->input('shipping_country',array('div'=>FALSE,'data-live-search'=>'true','label'=>FALSE,'class'=>'col-sm-5 col-xs-12 col-lg-3 form-control selectpicker selectitem shipcountry ','options'=>array(''=>'Select',$countries),'value'=>$client_detail['AcrClient']['shipping_country']));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right" for="form-field-1"> Postal/ZipCode </label>

                                <div class="col-xs-12 col-sm-5 col-lg-3">
                                    <?php echo $this->Form->input('shipping_zip',array('id'=>'form-field-1','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipzip form-control','value'=>$client_detail['AcrClient']['shipping_zip']));?>  
                                </div>
                            </div>
                            <div class="col-sm-12 borderline marginbottom3 col-xs-12"></div>
                           
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right col-xs-12"> Status  </label>

                                <div class="col-xs-12 col-sm-3 col-lg-3">
                                    <?php if($client_detail['AcrClient']['status'] == 'active'){
                                    	     echo $this->Form->input('status',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace ace-switch ace-switch-5 form-control','checked'=>"checked"));
                                          }else{
                                          	
                                          	 if($restrict_status){
                                          	 	 echo $this->Form->input('status',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace ace-switch ace-switch-5 restrict'));
                                          	 }else{
                                          	 	 echo $this->Form->input('status',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace ace-switch ace-switch-5'));
                                          	 }
                                             	
                                          }
                                    ?> 
                                       
                                    <span class="lbl"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Notes </label>

                                <div class="col-xs-12 col-sm-5 col-lg-4">
                                    <?php echo $this->Form->textarea('notes',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$client_detail['AcrClient']['notes']));?>  
                                </div>
                            </div>
                            <?php if($field_names){ ?>
                            <div class="col-sm-12 contactdetails paddingleftrightzero additionalinfo">
                              <h5>Additional Information</h5>
                            </div>
                            <?php foreach($field_names as $key=>$value): ?>
					        <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"><?php echo $value; ?></label>
                                
                                <?php if($fieldValues[$key]){ ?>
                                	 <div class="col-xs-12 col-sm-5 col-lg-3">
	                                    <?php echo $this->Form->input('FieldValue.'.$key,array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control','value'=>$fieldValues[$key]));?>  
	                                </div>
                                <?php }else{ ?>
                                	 <div class="col-xs-12 col-sm-5 col-lg-3">
	                                    <?php echo $this->Form->input('AddFieldValue.'.$key,array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
	                                </div>
                                <?php } ?>
                               
                            </div>
                            <?php endforeach;?> 
                            <?php } ?>                                         
                            <?php echo $this->Form->hidden('getcount',array('div'=>FALSE,'label'=>FALSE,'class'=>'forvalue'));?>
                            </div>
                            <div class="col-sm-12 borderline col-xs-12"></div>
                           <!-- </div> 
                           </div>
                            </div>-->
                           <!-- collapse ends -->
                           
                          
							<div class="form-group">
                                <!--<label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">&nbsp; </label>-->

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-actions margintopzero paddingtopzero addformbutton paddingtop25">
                                	<div class="col-md-offset-2 col-md-4 footerbutton">
	                                   <?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Update',array('class'=>'btn btn-info forgetval button_mobile','escape'=>false));?>
	                                	<div class="btn btn-inverse colorproblem button_mobile">
											<!--<a href="#"><i class="icon-remove bigger-110"></i> Cancel</a>-->
											<?php echo $this->Html->link('Cancel',array('controller'=>'customers','action'=>'index'),array('class'=>'icon-remove bigger-110'));?>
										</div>
									</div>
                                </div>
                            </div>
							
                       </div>  
                       <?php echo $this->Form->end();?>   									
                    </div>
          </div>
</div><!-- page-content -->
<style>
  .additionalinfo h5 {
      border-bottom: none ! important;
   }
</style>
<script type="text/javascript">
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : evt.keyCode
    //if (charCode > 31 && (charCode < 48 || charCode > 57))
    //Allows numbers and Special symbols
    if(charCode > 31 &&  charCode > 64)
        {
            alert("Please enter only numbers.");
            return false;
         }
         return true;
}



$(document).ready(function(){
	
	/* choosen select*/
	var config = {
		  
		  '.invdrop' : {search_contains:true}
		}
		for (var selector in config) {
		  $(selector).chosen(config[selector]);
	}
	/* choosen select*/
	
	
	 $(".restrict").attr('readonly', 'true');
var tttt=0;
	<?php $ch=0;?>
	$('.forgetval').click(function(){
		
		tttt = $('.forvalue').val();
		var tt1=parseInt(tttt)+2;
		document.cookie = "df="+tt1;
	   
		<?php $df = $_COOKIE['df']; ?>
		 
	 $("#AcrClientEditForm").validate({
	 	 onkeyup: false,
			rules: {
				'data[AcrClient][organization_name]': { 
				   required : true,
				   orgExist :true
				 },
				'data[AcrClient][sbs_subscriber_payment_term_id]': "required",
				<?php $c1=0; foreach($client_contact_details as $key11=>$value11){ $c1++; ?>
				   
					'data[Edit][Contact<?php echo $c1?>][email]':{
						required : true,
						email	 : true,
						email3	 : true
					},
					'data[Edit][Contact<?php echo $c1?>][name]':"required",
					'data[Edit][Contact<?php echo $c1?>][sur_name]':"required",
					
					
				<?php }?>
				
				<?php for($i=$edit_count+1; $i <= $df ;$i++){ ?>
					
				'data[Add][Contact<?php echo $i?>][name]': "required",
				'data[Add][Contact<?php echo $i?>][sur_name]': "required",
				'data[Add][Contact<?php echo $i?>][email]':{
					required : true,
					email	 : true,
					email2	 : true
					
				} ,
				
				<?php } ?>		
				'data[AcrClient][cpn_currency_id]': "required"
				
				
				
			},
			messages: {
				'data[AcrClient][organization_name]':{
				    required : 'Please enter organization name.',
				    orgExist : 'Sorry! organisation name already exists.'
			     },
				'data[AcrClient][sbs_subscriber_payment_term_id]': "Please select the payment term.",
				<?php $c11=0; foreach($client_contact_details as $key11=>$value11){  $c11++; ?>
					
					'data[Edit][Contact<?php echo $c11?>][email]':{
						required: "<?php echo __('Please enter email.');?>",
						email	: "<?php echo __('Please enter valid email.');?>",
						email3	: "<?php echo __('Email already exists.');?>"
						
					},
					'data[Edit][Contact<?php echo $c11?>][name]':"Please enter contact name.",
					'data[Edit][Contact<?php echo $c11?>][sur_name]':"Please enter contact surname.",
					
					
				<?php } ?>
				
				<?php for($i=$edit_count+1; $i <= $df ;$i++){ ?>
				'data[Add][Contact<?php echo $i; ?>][name]': "Plese enter contact name.",
				'data[Add][Contact<?php echo $i; ?>][sur_name]': "Plese enter contact surname.",
				'data[Add][Contact<?php echo $i; ?>][email]':{
					required: "<?php echo __('Please enter email.');?>",
					email	: "<?php echo __('Please enter valid email.');?>",
					email2	: "<?php echo __('Email already exists.');?>"
					
				},
				
				<?php } ?>	
				'data[AcrClient][cpn_currency_id]': "Please select currency."
			}
		});
	  	
	 });
	 <?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
		$protocol_final = 'https';
	} else {
	  	$protocol_final = 'http';
	} ?>
		$.validator.addMethod("orgExist",function(value,element){			
		 var x= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>customers/orgExist/<?php echo $id; ?>",
		    type: 'GET',
		    async: false,
		    data: "organization_name=" + value +"&checking=true",
		 }).responseText;	
		 if(x=="1"){
		 	return true;
		 }else{
		 	return false;
		 } 
	},"Sorry, this DB name is not available");
	
	$.validator.addMethod("email3",function(value,element){			
		 var x= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>customers/EmailExistCheck/<?php echo $id; ?>",
		    type: 'GET',
		    async: false,
		    data: "email=" + value +"&checking=true",
		 }).responseText;	
		 if(x=="1"){
		 	return true;
		 }else{
		 	return false;
		 } 
	},"Sorry, this DB name is not available");
	
	 $.validator.addMethod("email2",function(value,element){			
		 var x= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>customers/EmailExistTest",
		    type: 'GET',
		    async: false,
		    data: "email=" + value +"&checking=true",
		 }).responseText;	
		 if(x=="1"){
		 	return true;
		 }else{
		 	return false;
		 } 
	},"Sorry, this DB name is not available");
	
});
</script>

<script type="text/javascript">
$(document).ready(function(){
	
	
	
	
     var a = <?php echo $edit_count; ?>;
	 var a1 = <?php echo $edit_count; ?>;
	 $('.addbutton').click(function(){
		   a++;
		   a1++;
		   $('.forvalue').val(a1);
		   $('.newcontactadd').append('<div class="col-sm-12 col-xs-12 paddingleftrightzero newaddedcontact"><div class="col-sm-12 contactdetails paddingleftrightzero"><h5>Contact '+a1+' Details</h5></div><div class="form-group"><label class="col-sm-3 col-xs-12 col-lg-2 control-label no-padding-right"> Contact Name <em class="red">∗</em> </label><div class="col-xs-12 col-sm-5 col-lg-3"><input type="text" class="col-xs-12 col-sm-5 form-control" name="data[Add][Contact'+a+'][name]"></div></div><div class="form-group"><label class="col-sm-3 col-xs-12 col-lg-2 control-label no-padding-right"> Contact Surname <em class="red">∗</em> </label><div class="col-xs-12 col-sm-5 col-lg-3"><input type="text" class="col-xs-12 col-sm-5 form-control" name="data[Add][Contact'+a+'][sur_name]"></div></div><div class="form-group"><label class="col-sm-3 col-xs-12 col-lg-2 control-label no-padding-right"> Contact Email <em class="red">∗</em> </label><div class="col-xs-12 col-sm-5 col-lg-3"><input type="text" class="col-xs-12 col-sm-5 form-control" name="data[Add][Contact'+a+'][email]"></div></div><div class="form-group"><label class="col-sm-3 col-xs-12 col-lg-2 control-label no-padding-right"> Mobile </label><div class="col-xs-12 col-sm-5 col-lg-3"><input type="text" class="col-xs-12 col-sm-5 form-control" name="data[Add][Contact'+a+'][mobile]" onkeypress= "return isNumberKey(event)"></div></div><div class="form-group"><label class="col-sm-3 col-xs-12 col-lg-2 control-label no-padding-right" > Home Phone </label><div class="col-xs-12 col-sm-5 col-lg-3"><input type="text" class="col-xs-12 col-sm-5 form-control" name="data[Add][Contact'+a+'][home_phone]" onkeypress= "return isNumberKey(event)"></div></div><div class="form-group"><label class="col-sm-3 col-xs-12 col-lg-2 control-label no-padding-right"> Work Phone </label><div class="col-xs-12 col-sm-5 col-lg-3"><input type="text" class="col-xs-12 col-sm-5 form-control" name="data[Add][Contact'+a+'][work_phone]" onkeypress= "return isNumberKey(event)"></div></div><div class="form-group"><label class="col-sm-3 col-xs-12 col-lg-2 control-label no-padding-right">Primary</label><div class="col-sm-5 col-xs-9"><label><input id="Contact'+a+'IsPrimary_" type="hidden" value="0" name="data[Add][Contact'+a+'][is_primary]"><input type="checkbox"  id="Contact'+a+'IsPrimary" class="ace primarycheck" name="data[Add][Contact'+a+'][is_primary]"><span class="lbl"></span> </label> <span class="help-button customer-help-button blue_back" data-rel="popover" data-trigger="hover" data-placement="right" data-content="select to make it your primary contact" >?</span></div></div><div class="form-group"><label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Delete Contact</label><div class="col-sm-5 col-xs-12 col-lg-3"><i class="icon-trash bigger-120 red delete pointer deletecontact" title="Delete Contact" data-original-title="delete"></i></div></div></div></div>');
		   $( ".delete" ).tooltip({
		    show: {
			effect: "slideDown",
			delay: 250
		   }
		   });
		   $('[data-rel=popover]').popover({container:'body'});	
	 });	       
	       
	  $('body').on('click','.deletecontact',function(){
	  	$(this).parents('.newaddedcontact').fadeOut();
	  	$(this).parents('.newaddedcontact').remove();
	  });     
	       
});
$('body').on('click','.primarycheck',function(){
		$('.primarycheck').prop('checked',false);
		$(this).prop('checked',true)
	});
</script>

<script type="text/javascript">
$(document).ready(function(){
	
	
	$('.addmorebutton').click(function(){
		$('.showdetails').slideToggle();
	});
	
	
	
    if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
     } 
	
	$('.snail1').click(function(e) {
		 
		 $(".email1").attr("checked", false); 
		 $(".email2").attr("checked", false); 
	});	
	
	$('.snail').click(function(e) {
		 
		 $(".email1").attr("checked", false); 
		 $(".email2").attr("checked", false); 
	});	
	
	$('.email2').click(function(e) {
		 
		 $(".snail").attr("checked", false); 
		 $(".snail1").attr("checked", false); 
	});
	
	$('.email1').click(function(e) {
		 
		 $(".snail").attr("checked", false); 
		 $(".snail1").attr("checked", false); 
	});	
	
	 $('.newclass').click(function(e) {
	 	
	 	if(this.checked){
	 		
	 		 var badd1 = $(".billadd1").val();
		     var badd2 = $(".billadd2").val();
		     var bcountry = $(".billcountry").val();
		     var bstate = $(".billstate").val();
		     var bcity = $(".billcity").val();
		     var bzip = $(".billzip").val();
		     
		     $(".shipadd1").val(badd1);
		     $(".shipadd2").val(badd2);
			 $(".shipcountry").val(bcountry);
		     $(".shipstate").val(bstate);
		     $(".shipcity").val(bcity);
		     $(".shipzip").val(bzip);
		     
		     $(".billadd1").attr("readonly", false); 
		     $(".billadd2").attr("readonly", false); 
		     $(".billcountry").attr("readonly", false); 
		     $(".billstate").attr("readonly", false); 
		     $(".billcity").attr("readonly", false); 
		     $(".billzip").attr("readonly", false); 
		     
		    $(".shipadd1").attr("readonly", "readonly"); 
		     $(".shipadd2").attr("readonly", "readonly"); 
		     $(".shipcity").attr("readonly", "readonly"); 
		     $(".shipstate").attr("readonly", "readonly"); 
		     $(".shipzip").attr("readonly", "readonly"); 
		     //$(".billzip").attr("readonly", "readonly");
		     var country = $("select[name='data[AcrClient][billing_country]']").val();
				$('.optionselect .bootstrap-select span.filter-option').text($('.shipcountry option:selected').text());
				$(".shipcountry").attr("disabled", "disabled");  
	 	}else {
	 		 $(".shipadd1").val('<?php echo $client_detail['AcrClient']['shiping_address_line1']; ?>');
		     $(".shipadd2").val('<?php echo $client_detail['AcrClient']['shipping_address_line2']; ?>');
			 $(".shipcountry").val('<?php echo $client_detail['AcrClient']['shipping_country']; ?>');
		     $(".shipstate").val('<?php echo $client_detail['AcrClient']['shipping_state']; ?>');
		     $(".shipcity").val('<?php echo $client_detail['AcrClient']['shipping_city']; ?>');
		     $(".shipzip").val('<?php echo $client_detail['AcrClient']['shipping_zip']; ?>');
		     
		     $(".billadd1").attr("readonly", false); 
		     $(".billadd2").attr("readonly", false); 
		     $(".billcountry").attr("readonly",false); 
		     $(".billstate").attr("readonly", false); 
		     $(".billcity").attr("readonly", false); 
		     $(".billzip").attr("readonly", false); 
		     
		      $(".shipadd1").attr("readonly", false); 
		     $(".shipadd2").attr("readonly", false); 
		     $(".shipcity").attr("readonly", false); 
		     $(".shipstate").attr("readonly", false); 
		     $(".shipzip").attr("readonly", false);
		     $(".shipcountry").removeAttr("disabled");
	 	}
	 	
	  });
});
</script>
<script type="text/javascript">
	jQuery(function($) {
		$('[data-rel=popover]').popover({container:'body'});				
	})
</script>
<?php echo $this->Js->writeBuffer();?>       
<style>
	.blue_back{
		background-color:#2679B5;
	}
</style>
	