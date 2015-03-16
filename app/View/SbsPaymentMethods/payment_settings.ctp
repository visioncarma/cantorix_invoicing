 
 <script type="text/javascript">
 	try{ace.settings.check('main-container' , 'fixed')}catch(e){}
 </script>
<?php echo $this->Session->flash();?>
<?php echo $this->Form->create('PaymentSettings');?>
       <?php $homeLink = $this->Breadcrumb->getLink('Home');
             $paymentsLink =  $this->Breadcrumb->getLink('Settings');?>	
        <div class="breadcrumbs" id="breadcrumbs"> 
          <script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>
          <ul class="breadcrumb">
            <li>
			    <?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
			</li>
		   	<li>
		   			<?php echo $this->Html->link('Settings',$paymentsLink);?>
			</li>					
			<li class="active">Payment Gateway Setup</li>
          </ul>
          <!-- .breadcrumb --> 
        </div>
        <div class="page-content">
          <div class="page-header">
            <h1 class=" width-auto font-size-h1-480">Payment Gateway Setup</h1> 
          </div>
          <!-- /.page-header -->
          <div class="row">
            <div class="col-xs-12">
              <p>The one that you selected will be used for all payment transactions</p>
                
                
                 
         <?php   foreach($final_pay as $key=>$value){ ?>
           	
                   <div class="accordian">
                     <div class="accordian-leef">
                          <div class="leef-check">
                               <label>
                                   <i class="middle icon-plus" data-icon-show="icon-plus" data-icon-hide="icon-minus"></i>
                               </label>
                          </div>
                          
                          <div class="leef-check-text"> <?php echo $payment_methods[$key];?></div>
	                      <?php  if(!empty($values_present[$key])){?>
	                          <div class="success-flag" style="display:block">
	                         	   <i class="icon-ok white"></i>
	                          </div>	
	                      <?php }else{?>
	                         <div class="success-flag">
	                         	  <i class="icon-ok white"></i>
	                         </div>
	                      
	                      <?php }?>
                    </div>                   
                    
                  
                    
                    <div class="leef-open">
                         
                            <?php foreach ($value as $k=>$v):?> 
                                  <div class="form-group">
				                       <label class="col-lg-2 col-md-3 col-sm-4 col-xs-12 control-label no-padding-right"><?php echo $v;?><sup class="redstar">&lowast;</sup></label>
				                              <div class="col-lg-3 col-md-3 col-sm-7 col-xs-12">
				                                    <?php echo $this->Form->input('attribute_values'.'.'.$key.'.'.$k,array('div'=>FALSE,'label'=>FALSE,'value'=>$values_present[$key][$k]));?>  
                             
				                              </div>
				                              <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 no-padding-left no-padding-right hideinsmall">
				                                 <!--  <span class="help-button" data-content="More details." data-placement="right" data-trigger="hover" data-rel="popover" data-original-title="" title="">?</span>-->
				                              </div>
				                  </div> <br />
	                      <?php endforeach;?>     
	                        
	                        <div class="space-4"></div>
	                          
	                        <div class="form-group">
	                         <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-3 col-sm-offset-4">
	                              <div class="activecheck">
	                                  <label>
	                                  
	                                       <?php 
	                                         $checked = false;
	                                       if($find_active_methods[$key]){
	                                       	   $checked = true;
	                                       }
	                                       
	                                       echo $this->Form->input('check_box'.'.'.$key,array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace setactive','checked'=>$checked));?>
	                                     	                                      

	                                      <span class="lbl"></span>
	                                  </label>
	                              </div>
	                              <div class="activetext">
	                                  <label>
	                                    Set as default payment gateway
	                                  </label>                          
	                              </div>
	                              <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 no-padding-right">
	                                <!--<span class="help-button" data-content="More details." data-placement="right" data-trigger="hover" data-rel="popover" data-original-title="" title="">?</span>-->
	                              </div>                        
	                        </div>
	                        </div>
	                        <div class="space-4"></div>
	                        <div class="form-group">
	                         <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 col-lg-offset-2 col-md-offset-3 col-sm-offset-4 footerbutton">
	                          <?php  if($permission['_update'] == 1 || $permission['_create'] == 1) 
	                                 echo $this->Form->button('<i class="icon-ok bigger-110" ></i>Save',array('class'=>'btn btn-info forgetval button_mobile','escape'=>false,'update' => '#pageContent'));
                               ?>
	                          <?php  if($permission['_update'] == 1 || $permission['_create'] == 1){ ?>
	                          	  <button class="btn btn-inverse button_mobile" type="reset"> <i class="icon-undo bigger-110"></i> Reset </button>
	                          <?php } ?> 
	                          
	                         </div> 
	                        </div>  
	                      
                   </div>
                    
 
                    
                    
                    
                </div>
                
                <?php  }?>
                
                
                
                
                
            </div>
          </div>
        </div>
        <!-- /.page-content --> 
      
     
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a> 
    
 
 

<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo $this->webroot.'js/';?>jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]--> 

<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]--> 

<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo $this->webroot.'js/';?>jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script> 

<script type="text/javascript">
$(document).ready(function(){
	
	$("#PaymentSettings").validate({
	   ignore: [],
	 	    onkeyup: false,
			rules: {
				'data[PaymentSettings][attribute_values]':{ 
				   required : true,
				   orgExist :true
				}
			},
			messages: {
				 'data[PaymentSettings][attribute_values]': "Please select the payment term",
			 }
	    	
    
    });
	
	
	
	  $('body').on('click','.accordian-leef',function(){
		  $('.leef-open').not($(this).siblings('.leef-open')).slideUp();
		  $('.leef-check i').not($(this).find('.leef-check i')).removeClass('icon-minus');
		  $(this).siblings('.leef-open').slideToggle();
		  $(this).find('.leef-check i').toggleClass('icon-minus');
	  });
	  
	  if($('.setactive').is(":checked"))
		{
			$(this).parents('.leef-open').siblings('.accordian-leef').find('.success-flag').fadeIn();
		}
		else{
			$(this).parents('.leef-open').siblings('.accordian-leef').find('.success-flag').fadeOut();
		}
		$('body').on('click','.setactive',function(){
		if($('.setactive').is(":checked"))
		{
			$(this).parents('.leef-open').siblings('.accordian-leef').find('.success-flag').fadeIn();
		}
		else{
			$(this).parents('.leef-open').siblings('.accordian-leef').find('.success-flag').fadeOut();
		}
	  });
	  
});
</script>
<?php echo $this->Form->end();?>
<?php echo $this->Js->writeBuffer();?>       
 