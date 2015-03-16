<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
?>
<?php
	if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
	  $protocol_final = 'https';
	}else{
	  $protocol_final = 'http';
	}
	$http_hostname = $_SERVER['SERVER_NAME'];
	$webroot_name = $this->webroot;
	$imgLink = "$protocol_final".'://'."$http_hostname/";
?>
<?php echo $this->Form->create('User',array('url'=>array('controller'=>'subscribers','action'=>'edit_profile'),'enctype'=>'multipart/form-data','type'=>'file'));?>
	

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
          <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('controller'=>'subscribers','action'=>'user_profile'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
        </div>
	</div>
    <!-- /.page-header -->      
      <div class="row paddingtop100">
      	       
                <div class="col-lg-2 col-sm-3 col-md-6 col-xs-7"> 
                <div class="profilethumpnail profile-picture" style="cursor:pointer">
                	<?php if($user_detail['User']['profile_picture_path']){?>
                		
                	<img id="imgprvw" class="img-responsive" src="<?php echo $imgLink.$webroot_name.$user_detail['User']['profile_picture_path'];?>"  alt="profilepic"/>
                  	<?php }else{ echo $this->Html->image('profile_pic.jpg',array('id'=>'imgprvw','class'=>'img-responsive'));}?>
                  <div class="uploadprofilepicture">Update Profile Picture</div>
                </div>
               
                <div class="profilethumpnail profile-picture" style="display:none;">
                  <!--<input type="file"/> -->
                  <input type="file" name="file" id="file" onchange="showimagepreview(this)"/>
                </div>
                  <div id="toshow" class="sizeerrormsg" style="display:none;">
      	                      <p>The file you selected exceeds 500 KB. Please select another file.</p>
                  </div>
                  <div id="toshow1" class="typeerrormsg" style="display:none;">
                            	<p>The file you selected is not a valid image file. Please select another file.</p>
                  </div>    									
                </div>
                
                	<div class="col-lg-10 col-sm-9 col-md-6 col-xs-12 paddingleft3">
                      <div class="row marginleftrightzero">
                      	<div class="col-lg-12 col-xs-12  paddingleftrightzero">
                         <div class="row marginleftrightzero">
                      	 	 <div class="col-lg-12 col-xs-12 paddingleftrightzero">
	                         <div class="col-lg-2 col-xs-12 col-sm-4 paddingleftrightzero">
	                           <div class="profileitem profileitem_wrapper">
	                               First Name
	                           </div>
	                         </div> 
	                         <div class="col-lg-3 col-xs-12 paddingleftrightzero marginleftprofile  col-sm-4">
	                           <div class="profileitem profileitem_wrapper bold">
	                               <?php echo $this->Form->input('firstname',array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control','type'=>'text','value'=>$user_detail['User']['firstname']));?>
	                           </div> 
	                         </div>
	                         </div>	
                          </div>
                          
                          <div class="row marginleftrightzero">
                      	 	 <div class="col-lg-12 col-xs-12 paddingleftrightzero">
	                         <div class="col-lg-2 col-xs-12 col-sm-4 paddingleftrightzero">
	                           <div class="profileitem profileitem_wrapper">
	                               Last Name
	                           </div>
	                         </div> 
	                         <div class="col-lg-3 col-xs-12 paddingleftrightzero marginleftprofile  col-sm-4">
	                           <div class="profileitem profileitem_wrapper bold">
	                               <?php echo $this->Form->input('lastname',array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control','type'=>'text','value'=>$user_detail['User']['lastname']));?>
	                           </div> 
	                         </div>
	                         </div>	
                          </div>		
                      		
                      	 <div class="row marginleftrightzero">
                      	 	 <div class="col-lg-12 col-xs-12 paddingleftrightzero">
	                         <div class="col-lg-2 col-xs-12 col-sm-4 paddingleftrightzero">
	                           <div class="profileitem profileitem_wrapper">
	                               Username
	                           </div>
	                         </div> 
	                         <div class="col-lg-3 col-xs-12 paddingleftrightzero  marginleftprofile  col-sm-4">
	                           <div class="profileitem profileitem_wrapper bold">
	                               <?php echo $this->Form->input('username',array('id'=>'username','div'=>FALSE,'label'=>FALSE,'class'=>'form-control','type'=>'text','value'=>$user_detail['User']['username']));?>
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
	                         <div class="col-lg-3 col-sm-4 col-xs-12 paddingleftrightzero  marginleftprofile">
	                           <div class="profileitem profileitem_wrapper bold">
                                 <?php echo $this->Form->input('email',array('id'=>'emailval','div'=>FALSE,'label'=>FALSE,'class'=>'form-control','type'=>'text','value'=>$user_detail['User']['email']));?>
                               </div>
	                         </div>
	                         </div>	
                          </div>
                           <?php if($user_detail['User']['user_type'] == 'Subscriber'){ ?>
                          
                          <div class="row marginleftrightzero">
                          	 <div class="col-lg-12 col-xs-12 col-sm-12 paddingleftrightzero">
	                         <div class="col-lg-2 col-xs-12 col-sm-4 paddingleftrightzero">
	                           <div class="profileitem profileitem_wrapper">
	                                Company Name
	                           </div>
	                         </div> 
	                         <div class="col-lg-3 col-xs-12 col-sm-4 paddingleftrightzero marginleftprofile">
	                            <div class="profileitem profileitem_wrapper bold">
		                              <?php echo $subscriber_id_details['SbsSubscriberOrganizationDetail']['organization_name']; ?>
		                         </div>
	                         </div>
	                         </div>	
                          </div>
                           <div class="row marginleftrightzero">
                           	 <div class="col-lg-12 col-xs-12 col-sm-12 paddingleftrightzero">
	                         <div class="col-lg-2 col-xs-12 col-sm-4 paddingleftrightzero">
	                           <div class="profileitem profileitem_wrapper">
	                                Subscription Type
	                           </div>
	                         </div> 
	                         <div class="col-lg-3 col-xs-12 col-sm-4 paddingleftrightzero marginleftprofile">
	                           <div class="profileitem profileitem_wrapper bold">
		                             <?php echo $subscriber_id_details['CpnSubscriptionPlan']['type']; ?>
		                       </div>
	                         </div>
	                         </div>	
                          </div>                          
                           <?php } ?>                      
                        
                      </div>
                    </div>
                      <div class="row marginleftrightzero paddingtop5 ">
                       <div class="col-xs-12 col-lg-6 col-sm-9 paddingtop5 paddingleftrightzero paddingright5"> 
                              <div id="my_form_id" class="col-xs-2 paddingtop5 paddingleftrightzero profile-save-button-width pull-left"> 
                                       <!--<a class="btn btn-sm btn-success selectfile" href="#">SaveProfile Details</a>-->
                                  <?php echo $this->Form->submit('Save Profile Details',array('class'=>'btn btn-sm btn-success selectfile','escape'=>FALSE));?>
                              </div> 
                       	 </div>  
                      </div>    									
                    </div>
      </div>
</div>
				
<?php echo $this->Form->end();?>
<style>
	.readonlyemail{
		clear: both;
	    color: #DF4040;
	    float: left;
	    font-size: 12px;
	    font-weight: normal;
	    padding-left: 1px;
	    padding-top: 3px;
	}
	.readonlyusername{
		clear: both;
	    color: #DF4040;
	    float: left;
	    font-size: 12px;
	    font-weight: normal;
	    padding-left: 1px;
	    padding-top: 3px;
	}
	.sizeerrormsg{
		
	    clear: both;
	    color: #DF4040;
	    float: left;
	    font-size: 13px;
	    font-weight: normal;
	    padding-left: 1px;
	    padding-top: 3px;
	   
	}
	.typeerrormsg{
		
	    clear: both;
	    color: #DF4040;
	    float: left;
	    font-size: 13px;
	    font-weight: normal;
	    padding-left: 1px;
	    padding-top: 3px;
	   
	}
	.validemail{
		clear: both;
	    color: #DF4040;
	    float: left;
	    font-size: 12px;
	    font-weight: normal;
	    padding-left: 1px;
	    padding-top: 3px;
	}
	
	
</style>	

<script type="text/javascript">
$(document).ready(function(){ 
	
	  $("#UserEditProfileForm").validate({
		 rules: {           
			'data[User][firstname]': { 
				required : true,
				
			},
			
			'data[User][email]': { 
				required : true,
				email : true
				
			},
			'data[User][username]':{
				required : true,
				usernameexist : true
			}
			
			
		 },
		 messages:{			 
			 'data[User][firstname]': {
				required : 'Please enter first name.'
			},	
			
			'data[User][email]': {
				required : 'Please enter email',
				email: 'please enter valid email.'
			},		
			'data[User][username]':{
				required : 'Please enter Username',	
				usernameexist : 'Username already exists.'
			}
			
			
		 }
	});	
	<?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
		$protocol_final = 'https';
	} else {
	  	$protocol_final = 'http';
	} ?>
	$.validator.addMethod("emailexist",function(value,element){			
		 var x= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>subscribers/emailexist",
		    type: 'GET',
		    async: false,
		    data: "email=" + value +"&checking=true",
		 }).responseText;	
		 if(x=="0"){
		 	return true;
		 }else{
		 	return false;
		 } 
	},"Sorry, this DB name is not available");
	
	$.validator.addMethod("usernameexist",function(value,element){			
		 var x= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>subscribers/usernameexist",
		    type: 'GET',
		    async: false,
		    data: "username=" + value +"&checking=true",
		 }).responseText;	
		 if(x=="0"){
		 	return true;
		 }else{
		 	return false;
		 } 
	},"Sorry, this DB name is not available");
  });
</script>  	

 <script type="text/javascript">
	function showimagepreview(input) {
	if (input.files && input.files[0]) {
	var filerdr = new FileReader();
	
	filerdr.onload = function(e) {
		
	var f=input.files[0]
	var size=(f.size);
	var type=(f.type);
	
	// Checking file size (500KB)
	if(size > '512000'){
    	$(".sizeerrormsg").css('display','block');
    }else{
    	$(".sizeerrormsg").css('display','none');
    }
    
   
    
    
    
    var orgimgg = $('#imgprvw').prop('src');
    
    //alert(type);
    
    if((type != 'image/jpg') && (type != 'image/jpeg') && (type != 'image/png') && (type != 'image/gif')){
	
	
	$('.profilethumpnail').find('#imgprvw').attr('src',orgimgg)
	
	$(".typeerrormsg").css('display','block');
       	return false;
    }
    
    else
    {
    	$(".typeerrormsg").css('display','none');
    	$('#imgprvw').attr('src', e.target.result);
    }
                    
	
	}
	filerdr.readAsDataURL(input.files[0]);
	}
	}
</script>	


<script type="text/javascript">
$(document).ready(function () {
	
	var userval = "<?php echo $user_detail['User']['username']; ?>";
	var emval = "<?php echo $user_detail['User']['email']; ?>";
	
	$('#username').keyup(function(){
    	 var userval1 = $("#username").val();
         if(userval != userval1){
         	
         	 $(".readonlyemail").css('display','block');
         	 $("#emailval").attr("readonly", "readonly"); 
         }else{
         	$(".readonlyemail").css('display','none');
         	$("#emailval").attr("readonly", false); 
         }
    });
    $('#emailval').keyup(function(){
    	
    	 var emval1 = $("#emailval").val();
    	 if(emval != emval1){
    	 	 $(".readonlyusername").css('display','block');
    	 	$("#username").attr("readonly", "readonly"); 
            
         }else{
         	 $(".readonlyusername").css('display','none');
         	$("#username").attr("readonly", false); 
         }
    });
 

    	
    	/*$('body').on("change","#file",function(){
    		var f=this.files[0]
    		var size=(f.size);
    		var type=(f.type);
    		
    		
    		if(size > '512000'){
            	$(".sizeerrormsg").css('display','block');
            }else{
            	$(".sizeerrormsg").css('display','none');
            }
            
           
            
            var orgimgg = $('#imgprvw').prop('src');
            
          
            
            if((type != 'image/jpg') && (type != 'image/jpeg') && (type != 'image/png') && (type != 'image/gif')){
            	console.log("error");
            	
            	$('.profilethumpnail').find('#imgprvw').attr('src',orgimgg)
            	
            
            	
            	$(".typeerrormsg").css('display','block');
            	
       
            	
            	return false;
            }else{
            	$(".typeerrormsg").css('display','none');
            }
     });*/
 
     $("input[type=submit]").click(function(){
	  if($('#toshow').css('display') == 'block') {
		        $(".sizeerrormsg").css('display','block');
		        return false;
		    } else {
		       return true;
		    }
	 });
	
	 $("input[type=submit]").click(function(){
	  if($('#toshow1').css('display') == 'block') {
		        $(".typeerrormsg").css('display','block');
		        return false;
		    } else {
		       return true;
		    }
	 });
	
	
});
</script>


<script type="text/javascript">
	jQuery(function($) {
		var selectedfile
		$('.profile-picture').mouseover(function(){
			$('.uploadprofilepicture').css('display','block');
		});
		$('.profile-picture').mouseout(function(){
			$('.uploadprofilepicture').css('display','none');
		});
		$('.profile-picture').on('click', function() {
			$('.profile-picture input')[0].click();
			selectedfile=$('.profile-picture input').val();					
		});
		
	});
</script>
    