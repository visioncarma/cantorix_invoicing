<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
	
?>
<?php echo $this->Session->flash();?>
<?php echo $this->Form->create('AcrClient');?>
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
			<li class="active">Add Customer</li>
		</ul>
	</div>

	<div class="page-content addCustomer">
		<div class="page-header">
			<h1>
				Add Customer								
			</h1>
            <div class="col-lg-2 paddingleftrightzero">
               <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
            </div>
		</div>
		<?php if($showAddButton == 'true'){ ?>
			
        
            <div class="row">
					<div class="col-xs-12">
					
                      <div class="form-horizontal customerform" role="form">
                      	
                      	 	<div class="clearfix form-actions margintopzero addformbutton padding0 addUC-btn">
							<div class="col-md-offset-2 col-md-4">
								
								<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Save',array('class'=>'btn btn-info forgetval','escape'=>false));?>

								
								<button class="btn btn-inverse" type="reset">
									<i class="icon-undo bigger-110"></i>
									Reset
								</button>
							</div>
							</div>
							
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Organization Name  <em class="red" >&lowast;</em>  </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                   <?php echo $this->Form->input('organization_name',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>
                                  
                                </div>
                            </div>
					        <!--<div class="space-4"></div>-->
							<div class="form-group relative">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Currency Code <em class="red" >&lowast;</em> </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3 labelerror">
                                  <?php echo $this->Form->input('cpn_currency_id',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-sm-5 col-xs-12 col-lg-3 form-control selectpicker selectitem','options'=>array(''=>'Select',$currencies),'value'=>$defaultCurrenyId));?>                                                 
							    </div>
                            </div>
					        <!--<div class="space-4"></div>-->
							<div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Language </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('cpn_language_id',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control selectpicker','options'=>array(''=>'Select',$languages),'value'=>$defaultLanguageId));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Website</label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                   <?php echo $this->Form->input('website',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
					        <!--<div class="space-4"></div>-->
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Send Invoices By</label>        
                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <label>
                                        <?php echo $this->Form->input('send_invoice_byEmail',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace email1','checked'=>'checked'));?>                     
                                           <span class="lbl"></span>
                                     </label>
                                     <label class="maillabel">Email</label>
                                     
                                </div>
                            </div>
                            
                             <div class="form-group relative">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Payment Terms <em class="red" >&lowast;</em> </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3 labelerror">
                                    <?php echo $this->Form->input('sbs_subscriber_payment_term_id',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control selectpicker selectitem','options'=>array(''=>'Select',$payment_terms),'default'=>$paymentTermDefault['SbsSubscriberPaymentTerm']['id']));?>  
                                </div>
                            </div>
                           
					        <!--<div class="space-4"></div>		-->								
					        <div class="col-sm-12 contactdetails paddingleftrightzero">
                              <h5>Contact Details</h5>
                            </div>
					        <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Contact Name <em class="red" >&lowast;</em> </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('Contact1.name',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Contact Surname <em class="red" >&lowast;</em> </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                   <?php echo $this->Form->input('Contact1.sur_name',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Contact Email <em class="red" >&lowast;</em> </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('Contact1.email',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Mobile</label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                   <?php echo $this->Form->input('Contact1.mobile',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Home Phone </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('Contact1.home_phone',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Work Phone </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                     <?php echo $this->Form->input('Contact1.work_phone',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Primary</label>        
                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <label>
                                          <?php echo $this->Form->input('Contact1.is_primary',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace ace1','checked'=>'checked'));?>  
                                           <span class="lbl"></span>
                                     </label>
                                     <span class="help-button customer-help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="select to make it your primary contact">?</span>
                                     
                                </div>
                            </div>  
                            <div class="newcontactadd"></div>  
                            
                            <div class="col-sm-12 borderline col-xs-12"></div>
                            <div class="col-sm-12 paddingtopbottom2 col-xs-12 nopaddingleft nopaddingright">
                               <!-- <div class="col-sm-5 nopaddingleft nopaddingright"></div>-->
                                <div class="col-sm-2 nopaddingleft nopaddingright">
                                <a class="btn btn-sm btn-success pull-left addbutton">
                                          <i class="icon-plus"></i>                                               
                                </a>
                                <label class="addcontact">Add Contact</label>
                            </div>
                            </div>
                            <div class="col-sm-12 borderline col-xs-12 marginbottom3"></div>                                            
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Business Phone </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                     <?php echo $this->Form->input('business_phone',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Business Fax </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                     <?php echo $this->Form->input('business_fax',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
                            
                            <div class="widget-box collapsed">
                            	
                            <div class="widget-header">
                             <h4 class="blue">More Customer Details</h4>
                            <div class="widget-toolbar">
								<a href="#" data-action="collapse">
									<i class="icon-chevron-down"></i>
								</a>

								
							</div>
							</div>
													
                            <div class="widget-body">
							<div class="widget-main">
                            	
                            <div class="col-sm-12 contactdetails paddingleftrightzero">
                              <h5>Billing Address</h5>
                            </div>
					        <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Address Line1 </label>

                                <div class="col-sm-5 col-xs-12 col-lg-4">
                                    <?php echo $this->Form->input('billing_address_line1',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billadd1 form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Address Line2 </label>

                                <div class="col-sm-5 col-xs-12 col-lg-4">
                                     <?php echo $this->Form->input('billing_address_line2',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billadd2 form-control'));?>  
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> City </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('billing_city',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billcity form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Province/State </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('billing_state',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billstate form-control'));?>  
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Country </label>        
                                <div class="col-sm-5 col-xs-12 col-lg-3 countrybilling max-height max-width">
                                    <?php echo $this->Form->input('billing_country',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billcountry form-control selectpicker','options'=>array(''=>'Select',$countries)));?>  
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Postal/ZipCode </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                   <?php echo $this->Form->input('billing_zip',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 billzip form-control'));?>  
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

                                <div class="col-sm-5 col-xs-12 col-lg-4">
                                    <?php echo $this->Form->input('shiping_address_line1',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipadd1 form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Address Line2 </label>

                                <div class="col-sm-5 col-xs-12 col-lg-4">
                                    <?php echo $this->Form->input('shipping_address_line2',array('rows'=>'3','div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipadd2 form-control'));?>  
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> City </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('shipping_city',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipcity form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Province/State </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('shipping_state',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipstate form-control'));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Country </label>        
                                <div class="col-sm-5 col-xs-12 col-lg-3 countrybilling max-height max-width">
                                   <?php echo $this->Form->input('shipping_country',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipcountry form-control selectpicker','options'=>array(''=>'Select',$countries)));?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right" for="form-field-1"> Postal/ZipCode </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('shipping_zip',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 shipzip form-control'));?>  
                                </div>
                            </div>
                            <div class="col-sm-12 borderline marginbottom3 col-xs-12"></div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Status </label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('status',array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace ace-switch ace-switch-5','checked'=>"checked"));?>    
                                    <span class="lbl"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Notes </label>

                                <div class="col-sm-5 col-xs-12 col-lg-4">
                                    <?php echo $this->Form->textarea('notes',array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
                            <?php if($field_names){ ?>
                            <div class="col-sm-12 contactdetails paddingleftrightzero additionalinfo col-sx-12">
                              <h5>Additional Information</h5>
                            </div>
                            <?php } ?>
                            <?php foreach($field_names as $key=>$value): ?>
					        <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"><?php echo $value; ?></label>

                                <div class="col-sm-5 col-xs-12 col-lg-3">
                                    <?php echo $this->Form->input('FieldValue.'.$key,array('div'=>FALSE,'label'=>FALSE,'class'=>'col-xs-12 col-sm-5 form-control'));?>  
                                </div>
                            </div>
                            <?php endforeach;?> 
                                                                     
                            <?php echo $this->Form->hidden('getcount',array('div'=>FALSE,'label'=>FALSE,'class'=>'forvalue'));?>
                           
                           </div> 
                           </div>
                            </div>
                           <!-- collapse ends -->
                           
                           
                            <div class="clearfix form-actions margintopzero paddingtopzero addformbutton">
							<div class="col-md-offset-2 col-md-4">
								
								<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Save',array('class'=>'btn btn-info forgetval','escape'=>false));?>

								
								<button class="btn btn-inverse" type="reset">
									<i class="icon-undo bigger-110"></i>
									Reset
								</button>
							</div>
							</div>
                       </div>  
                       <?php echo $this->Form->end();?>   									
                    </div>
          </div>
         <?php } ?> 
</div>
<style>
  .additionalinfo h5 {
      border-bottom: none ! important;
   }
</style>


<script type="text/javascript">

$(document).ready(function(){
	var tttt=0;
	<?php $ch=0;?>
	$('.forgetval').click(function(){
		
		tttt = $('.forvalue').val();
		var tt1=parseInt(tttt)+2;
		document.cookie = "df="+tt1;
	   
		<?php $df = $_COOKIE['df']; ?>
		
		 $("#AcrClientAddForm").validate({
		 	ignore: [],
	 	    onkeyup: false,
			rules: {
				
				'data[AcrClient][organization_name]':{ 
				   required : true,
				   orgExist :true
				},
				'data[AcrClient][sbs_subscriber_payment_term_id]': "required",
				'data[Contact1][name]': "required",
				'data[Contact1][sur_name]': "required",
				'data[Contact1][email]':{
					required : true,
					email	 : true,
					email2	 : true
				} ,
				"data[Contact1][mobile]": { 
					//required : true,
					digits: true
					
				},
				"data[Contact1][home_phone]": { 
					//required : true,
					digits: true
					
				},
				"data[Contact1][work_phone]": { 
					//required : true,
					digits: true
					
				},
				<?php for($i=2; $i <= $df ;$i++){ ?>
				'data[Contact<?php echo $i?>][name]': "required",
				'data[Contact<?php echo $i?>][sur_name]': "required",
				'data[Contact<?php echo $i?>][email]':{
					required : true,
					email	 : true,
					email3	 : true
				} ,
				'data[Contact<?php echo $i?>][mobile]':{
					digits: true
				} ,
				'data[Contact<?php echo $i?>][home_phone]':{
					digits: true
				} ,
				'data[Contact<?php echo $i?>][work_phone]':{
					digits: true
				} ,
				<?php } ?>
				'data[AcrClient][cpn_currency_id]': "required"
			    
			},
			messages: {
				
				
				'data[AcrClient][organization_name]': {
				    required : 'Please enter organization name',
				    orgExist : 'Sorry! organisation name already exists'
			     },
			     
				
			    'data[AcrClient][sbs_subscriber_payment_term_id]': "Please select the payment term",
				'data[Contact1][name]': "Please enter name",
				'data[Contact1][sur_name]': "Please enter surname",
				'data[Contact1][email]':{
					required: "<?php echo __('Please enter email');?>",
					email	: "<?php echo __('Please enter valid email');?>",
					email2	: "<?php echo __('Email already exists');?>"
				},
			     "data[Contact1][mobile]": {
				    digits : "Please enter digits",
			     },
			     "data[Contact1][home_phone]": {
				    digits : "Please enter digits",
			     },
			     "data[Contact1][work_phone]": {
				    digits : "Please enter digits",
			     },
				<?php for($i=2; $i <= $df ;$i++){ ?>
				'data[Contact<?php echo $i; ?>][name]': "Plese enter contact name",
				'data[Contact<?php echo $i; ?>][sur_name]': "Plese enter surname",
						
				'data[Contact<?php echo $i; ?>][email]':{
					required: "<?php echo __('Please enter email');?>",
					email	: "<?php echo __('Please enter valid email');?>",
					email3 :  "<?php echo __('Email already exists');?>"
				},
				'data[Contact<?php echo $i?>][mobile]':{
					digits: "Please enter digits",
				} ,
				'data[Contact<?php echo $i?>][home_phone]':{
					digits: "Please enter digits",
				} ,
				'data[Contact<?php echo $i?>][work_phone]':{
					digits: "Please enter digits",
				} ,
				<?php } ?>
				'data[AcrClient][cpn_currency_id]': "Please select currency"
				
			}
		});
	  	
	 });
	 
	
		
		$.validator.addMethod("orgExist",function(value,element){			
		 var x= $.ajax({
		    url: "/cantorix/customers/orgcheck",
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
	
	
		$.validator.addMethod("email2",function(value,element){			
		 var x= $.ajax({
		    url: "/cantorix/customers/EmailExist",
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
	
	$.validator.addMethod("email3",function(value,element){			
		 var x= $.ajax({
		    url: "/cantorix/customers/EmailExist",
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
	$('body').on('change','.selectitem',function(){
	var thisvalue = $('.selectitem option:selected').text();
	if (thisvalue=="Select")
	   {
	   	 $(this).next('.error').show();
	   }
	   else{
	   	  $(this).next('.error').hide();
	   }
    });	 
});	 
</script>

<script type="text/javascript">
jQuery(function($) {
		$(".chosen-select").chosen();
	});
$(document).ready(function(){
	 var a=1;
	 var a1=0;
	 $('.addbutton').click(function(){
		   a++;
		   a1++;
		   $('.forvalue').val(a1);
		   $('.newcontactadd').append('<div class="col-sm-12 contactdetails paddingleftrightzero"><h5>Contact '+a1+' Details</h5></div><div class="form-group"><label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Contact Name <em class="red">∗</em> </label><div class="col-xs-12 col-sm-3 col-lg-3"><input type="text" class="col-xs-12 col-sm-5 form-control" name="data[Contact'+a+'][name]"></div></div><div class="form-group"><label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Contact Surname <em class="red">∗</em> </label><div class="col-xs-12 col-sm-3 col-lg-3"><input type="text" class="col-xs-12 col-sm-5 form-control" name="data[Contact'+a+'][sur_name]"></div></div><div class="form-group"><label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Contact Email <em class="red">∗</em> </label><div class="col-xs-12 col-sm-3 col-lg-3"><input type="text"  class="col-xs-12 col-sm-5 form-control" name="data[Contact'+a+'][email]"></div></div><div class="form-group"><label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Mobile </label><div class="col-xs-12 col-sm-3 col-lg-3"><input type="text" class="col-xs-12 col-sm-5 form-control" name="data[Contact'+a+'][mobile]"></div></div><div class="form-group"><label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Home Phone </label><div class="col-xs-12 col-sm-3 col-lg-3"><input type="text"  class="col-xs-12 col-sm-5 form-control" name="data[Contact'+a+'][home_phone]"></div></div><div class="form-group"><label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right"> Work Phone </label><div class="col-xs-12 col-sm-3 col-lg-3"><input type="text" class="col-xs-12 col-sm-5 form-control" name="data[Contact'+a+'][work_phone]"></div></div><div class="form-group"><label class="col-xs-12 col-sm-3 col-lg-2 control-label no-padding-right">Primary</label><div class="col-xs-12 col-sm-3 col-lg-3"><label><input id="Contact'+a+'IsPrimary_" type="hidden" value="0" name="data[Contact'+a+'][is_primary]"><input type="checkbox"  id="Contact'+a+'IsPrimary" class="ace ace2" name="data[Contact'+a+'][is_primary]"><span class="lbl"></span> </label> <span class="help-button customer-help-button" data-rel="popover" data-trigger="hover" data-placement="right" data-content="select to make it your primary contact" >?</span></div></div>');
		   jQuery(function($) {
		         $('[data-rel=popover]').popover({container:'body'});				
	       })
	 });
	 
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
	       
	 });
</script>

<script type="text/javascript">
$(document).ready(function(){
	 if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
     } 
	 $('.snail').click(function(e) {
		 $(".email1").attr("checked", false); 
	});	
	
	$('.email1').click(function(e) {
		 $(".snail").attr("checked", false); 
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
		     $('#AcrClientShipingAddressLine1').siblings('label.error').fadeOut();
		     $('#AcrClientShippingAddressLine2').siblings('label.error').fadeOut();
		     $('#AcrClientShippingCountry').siblings('label.error').fadeOut();
		     $('#AcrClientShippingCity').siblings('label.error').fadeOut();
		     $('#AcrClientShippingState').siblings('label.error').fadeOut();
		     $('#AcrClientShippingZip').siblings('label.error').fadeOut();
		     
		     $(".shipadd1").attr("readonly", "readonly"); 
		     $(".shipadd2").attr("readonly", "readonly"); 
		     $(".shipcity").attr("readonly", "readonly"); 
		     $(".shipstate").attr("readonly", "readonly"); 
		     $(".shipzip").attr("readonly", "readonly"); 
		     //$(".billzip").attr("readonly", "readonly"); 
	 	}else {
	 		 $(".shipadd1").val('');
		     $(".shipadd2").val('');
			 $(".shipcountry").val('');
		     $(".shipstate").val('');
		     $(".shipcity").val('');
		     $(".shipzip").val('');
		     
		     $(".billadd1").attr("readonly", false); 
		     $(".billadd2").attr("readonly", false); 
		     $(".billcountry").attr("readonly",false); 
		     $(".billstate").attr("readonly", false); 
		     $(".billcity").attr("readonly", false); 
		     $(".billzip").attr("readonly", false);
		     $('#AcrClientShipingAddressLine1').siblings('label.error').fadeIn();
		     $('#AcrClientShippingAddressLine2').siblings('label.error').fadeIn();
		     $('#AcrClientShippingCountry').siblings('label.error').fadeIn();
		     $('#AcrClientShippingCity').siblings('label.error').fadeIn();
		     $('#AcrClientShippingState').siblings('label.error').fadeIn();
		     $('#AcrClientShippingZip').siblings('label.error').fadeIn(); 
		     
		     
		     $(".shipadd1").attr("readonly", false); 
		     $(".shipadd2").attr("readonly", false); 
		     $(".shipcity").attr("readonly", false); 
		     $(".shipstate").attr("readonly", false); 
		     $(".shipzip").attr("readonly", false);
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
	