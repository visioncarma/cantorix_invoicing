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
			<li class="active">Profile</li>
		</ul><!-- .breadcrumb -->
	</div>

	<div class="page-content">
		<div class="page-header">
			<h1>
				User Profile							
			</h1>
            <div class="col-lg-2 paddingleftrightzero">
              <?php if($user_detail['User']['user_type'] == 'Subscriber'){
              	       echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('controller'=>'users','action'=>'dashboard'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));
              	     }else{
              	     	echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('controller'=>'users','action'=>'adminDashboard'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));
              	     }?>
            </div>
		</div>
        
          <div class="row paddingtop100">
                    <div class="col-lg-2 col-sm-3 col-md-6 col-xs-7"> 
                    <div class="profilethumpnail profile-picture">
                    	<?php if($user_detail['User']['profile_picture_path']){?>
                      <img class="img-responsive" src="<?php echo $this->webroot.'/'.$user_detail['User']['profile_picture_path'];?>"  alt="profilepic"/>
                      <?php }else{
                      	echo $this->Html->image('profile_pic.jpg',array('class'=>'nav-user-photo'));
                      }?>
                      <!--<img class="img-responsive"  src="<?php echo 'http://'.$_SERVER['SERVER_NAME'].'/'.$this->webroot;?>img/profile_pic.jpg"  alt="profilepic"/>-->
                    </div>                                          									
                    </div>
                    
					<div class="col-lg-10 col-xs-12 paddingleft3"> 
                      <div class="row marginleftrightzero paddingbottom20">
                         <div class="profilename">
                            <h3><?php echo $user_detail['User']['firstname'].' '.$user_detail['User']['lastname']; ?></h3>
                         </div>
                      </div>
                      <div class="row marginleftrightzero">
                      	<div class="col-lg-12 col-xs-12  paddingleftrightzero">
                      		
                      	 <div class="row marginleftrightzero">
                      	 	 <div class="col-lg-12 col-xs-12 paddingleftrightzero">
	                         <div class="col-lg-2 col-xs-12 col-sm-4 paddingleftrightzero">
	                           <div class="profileitem profileitem_wrapper">
	                               Username
	                           </div>
	                         </div> 
	                         <div class="col-lg-9 col-xs-12 paddingleftrightzero width-80 marginleftprofile  col-sm-4">
	                           <div class="profileitem profileitem_wrapper bold">
	                               <?php echo $user_detail['User']['username']; ?>
	                           </div> 
	                         </div>
	                         </div>	
                          </div>
                          
                          <div class="row marginleftrightzero">
                          	 <div class="col-lg-12 col-xs-12  paddingleftrightzero">
	                         <div class="col-lg-2 col-xs-12 col-sm-4 paddingleftrightzero">
	                           <div class="profileitem profileitem_wrapper">
	                               Email Address
	                           </div>
	                         </div> 
	                         <div class="col-lg-9 col-sm-4 col-xs-12 paddingleftrightzero width-80 marginleftprofile">
	                           <div class="profileitem profileitem_wrapper bold">
                                 <?php echo $user_detail['User']['email']; ?>
                               </div>
	                         </div>
	                         </div>	
                          </div>
                           <?php if($user_detail['User']['user_type'] == 'Subscriber'){ ?>
                          
                          <div class="row marginleftrightzero">
                          	 <div class="col-lg-12 col-xs-12 paddingleftrightzero">
	                         <div class="col-lg-2 col-xs-12 col-sm-4 paddingleftrightzero">
	                           <div class="profileitem profileitem_wrapper">
	                                Company Name
	                           </div>
	                         </div> 
	                         <div class="col-lg-9 col-sm-4 col-xs-12 paddingleftrightzero width-80 marginleftprofile">
	                            <div class="profileitem profileitem_wrapper bold">
		                              <?php echo $subscriber_id_details['SbsSubscriberOrganizationDetail']['organization_name']; ?>
		                         </div>
	                         </div>
	                         </div>	
                          </div>
                          
                          
                          
                           <div class="row marginleftrightzero">
                           	 <div class="col-lg-12 col-xs-12 paddingleftrightzero">
	                         <div class="col-lg-2 col-xs-12 col-sm-4 paddingleftrightzero">
	                           <div class="profileitem profileitem_wrapper">
	                                Subscription Type
	                           </div>
	                         </div> 
	                         <div class="col-lg-9 col-sm-4 col-xs-12 paddingleftrightzero width-80 marginleftprofile">
	                           <div class="profileitem profileitem_wrapper bold">
		                             <?php echo $subscriber_id_details['CpnSubscriptionPlan']['type']; ?>
		                       </div>
	                         </div>
	                         </div>	
                          </div>                          
                           <?php } ?>                      
                        
                      </div>
                    </div>
                      <div class="row marginleftrightzero paddingtop5">
                       <div class="col-xs-12 col-lg-2 col-sm-6 paddingtop5 paddingleftrightzero"> 
                       	
                         <!--<a class="btn btn-sm btn-success selectfile" href="User_Profile_Page_Edit.html">Edit Profile Details</a>-->
                         <?php echo $this->Html->link('Edit Profile Details',array('controller'=>'subscribers','action'=>'edit_profile'),array('class'=>'btn btn-sm btn-success selectfile edit-userprofile-width','escape'=>FALSE));?>
                          <?php //echo $this->Html->link('Edit Profile Details',array('controller'=>'subscribers','action'=>'edit_profile'),array('class'=>'btn btn-sm btn-success selectfile','escape'=>FALSE));?>
                       </div>
                       <div class="col-xs-12 col-lg-2 col-sm-6 paddingtop5 paddingleftrightzero"> 
                         <button class="  col-xs-12 col-lg-12 col-sm-12 btn btn-sm btn-success selectfile" data-toggle="modal" data-target="#changepassword">Change Password</button>
                       </div>  
                      </div>    									
                    </div>
          </div>
          
                                                                                    
	</div><!-- /.page-content -->



<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
<i class="icon-double-angle-up icon-only bigger-110"></i>
</a>
		
        
        
        

<div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header page-header">       
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
         <h1 class="modal-title" id="myModalLabel">Change Password</h1>    
      </div>
     <div class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
     <?php echo $this->Form->create('User',array('url'=>array('controller'=>'subscribers','action'=>'change_password')));?>
      <div class="modal-body">
         <div class="model-body-inner-content">   
         	      <div class="pm" style="display:none;">
                  	<p>passwords mismatch</p>
                  </div>    
                  <div class="form-group login-form-group">
                    <label class="col-sm-4 control-label">Current Password </label>    
                    <div class="col-sm-8 addcurrency_popup_input">
                      <?php echo $this->Form->input('current_password',array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control c1','type'=>'password'));?>  
                      <span class="image_placement"></span>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label"> New Password </label>   
                    <div class="col-sm-8 addcurrency_popup_input">
                      <!--<input type="text" class="form-control" name="currencyname" placeholder="">-->
                      <?php echo $this->Form->input('new_password',array('id'=>'newpassword','div'=>FALSE,'label'=>FALSE,'class'=>'form-control c2','type'=>'password'));?>  
                      <span class="image_placement"></span>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label"> Confirm Password </label>   
                    <div class="col-sm-8 addcurrency_popup_input">
                      <!--<input type="text" class="form-control" name="currencyname" placeholder="">-->
                      <?php echo $this->Form->input('confirm_password',array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control c3','type'=>'password'));?>  
                      <span class="image_placement"></span>
                    </div>
                  </div>                     
          </div>
      </div>
      <div class="modal-footer">
               
            <?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('class'=>'btn btn-info','escape'=>false));?>
            
             <span class="btn popup-cancel">
                <i class="icon-remove bigger-110"></i>
                Cancel
            </span>
       </div>
      <?php echo $this->Form->end();?>   	
      </div>
    </div>
  </div>
</div>
		
<!--change password---->

		

<script type="text/javascript">
	if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script type="text/javascript">
	jQuery(function($) {
		$(".chosen-select").chosen();
        $('#spinner1').ace_spinner({value:0,min:0,max:200,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
		.on('change', function(){});		
	});
</script>

<script type="text/javascript">
  $(document).ready(function(){ 
	  $("#UserUserProfileForm").validate({
		 onkeyup: false,
		 rules: {           
			'data[User][current_password]': { 
				required : true,
				password_mach :true
				
				
			},			
			'data[User][new_password]':{
				required : true,
				minlength:7
			},
			'data[User][confirm_password]':{
				required : true,
				equalTo: "#newpassword",
				minlength:7
			}
			
		 },
		 messages:{			 
			 'data[User][current_password]': {
				required : 'Please enter current password',
				password_mach : 'Sorry! Your current password is incorrect'
			},			
			
			'data[User][new_password]':{
				required : 'Please enter new password'	
			},
			'data[User][confirm_password]':{
				
				required : 'Please enter confirm password',		
				equalTo: 'New Password and Confirm Password mismatch.'
			}
			
		 }
	});	
	
	 $.validator.addMethod("password_mach",function(value,element){			
		 var x= $.ajax({
		    url: "/cantorix/subscribers/passowrd_check",
		    type: 'GET',
		    async: false,
		    data: "current_password=" + value +"&checking=true",
		 }).responseText;	
		 if(x=="1"){
		 	return true;
		 }else{
		 	return false;
		 } 
	},"Sorry, this DB name is not available");
  });
	</script>  	
    