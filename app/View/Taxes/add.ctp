<?php echo $this->Session->flash();?>	

<?php echo $this->Html->script(array('jquery.flot.min','jquery.flot.pie.min','jquery.flot.resize.min','jquery.mobile.custom.min','jquery-ui-1.10.3.full.min','fuelux.spinner.min.js'));?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>
	<?php $homeLink = $this->Breadcrumb->getLink('Home');
	      $settings = $this->Breadcrumb->getLink('Settings'); ?>	
    <ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
        <li>								
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		<li>								
			<?php echo $this->Html->link('Tax Settings', array('controller' =>'taxes','action' => 'index'), array('div' => false,'escape' => false)); ?>
		</li>
		<li class="active">Add Tax</li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1>
			Add Tax								
		</h1>
         <div class="col-lg-2 paddingleftrightzero">
               <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('controller'=>'taxes','action'=>'index'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
            </div>
	</div>
    
    <div class="row">
		 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 marginleftrightzero">
				<?php echo $this->Form->create('SbsSubscriberTax',array('class'=>'form-horizontal'));?>  
                
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-4 col-lg-2  control-label"> Tax Name </label>

                            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-4">
                                <?php echo $this->Form->input('name',array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control'));?>  
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-4 col-lg-2 control-label no-padding-right"> Tax Code </label>

                            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-4">
                                <?php echo $this->Form->input('code',array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control'));?>  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-4 col-lg-2 control-label no-padding-right"> Percent </label>

                            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-4">
                              <!--<input type="text" class="input-mini col-xs-10 col-sm-5" id="spinner1" />-->
                              <?php echo $this->Form->input('percent',array('div'=>FALSE,'label'=>FALSE,'class'=>'input-mini form-control mobile_100','max'=>'100','onkeypress' => "return isNumberKey(event)"));?> 
                               <?php /*echo $this->Form->input('percent',array('id'=>'spinner1','div'=>FALSE,'label'=>FALSE,'class'=>'input-mini col-xs-10 col-sm-5'));*/?>  
                            </div>
                        </div>											
                        <div class="form-group ">
							<div class="col-xs-12 col-sm-6 col-md-8 col-lg-10 col-lg-offset-2 col-md-offset-2 col-sm-offset-2 col-xs-offset-2 footerbutton">								
	                            <?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('class'=>'btn btn-info button_mobile','escape'=>false));?>
								&nbsp; &nbsp; &nbsp;
								<button class="btn btn-inverse button_mobile" type="reset">
									<i class="icon-undo bigger-110"></i>
									Reset
								</button>
							</div>
					  </div>
                  <?php echo $this->Form->end();?>  							
           </div>
      </div>
</div>
		

<script type="text/javascript">
/*function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : evt.keyCode
    
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        {
            if(charCode !='46'){
            	alert("Please enter only numbers.");
                return false;
            }
            
         }
         return true;
}
*/
function isNumberKey(eventObj)
{
    var keycode;
 
    if(eventObj.keyCode) //For IE
        keycode = eventObj.keyCode;
    else if(eventObj.Which)
        keycode = eventObj.Which;  // For FireFox
    else
        keycode = eventObj.charCode; // Other Browser
 
    if (keycode!=8) //if the key is the backspace key
    {
        if ((keycode<48||keycode>57) && keycode!=46) //if not a number && allow decimal
            return false; // disable key press
        else
            return true; // enable key press
     }        
 }




jQuery(function($) {
	$("#spinner1").attr("disabled","disabled");
	$(".chosen-select").chosen();
    $('#spinner1').ace_spinner({value:0,min:0,max:200,step:1, readonly:true ,editable:false,btn_up_class:'btn-info' , btn_down_class:'btn-info'})
	.on('change', function(){
	});		
});

$(document).ready(function(){
	
	 $('#SbsSubscriberTaxPercent').removeAttr("type");
	 $("#SbsSubscriberTaxAddForm").validate({
	 	    onkeyup: false,
			rules: {
				'data[SbsSubscriberTax][name]': { 
				   required : true,
				   taxnamecheck :true
			     },			
				'data[SbsSubscriberTax][code]': { 
				   required : true,
				   taxcodecheck :true
			     },	
				'data[SbsSubscriberTax][percent]':{
					 required : true,
					 max:100
				} 
			},
			messages: {
				'data[SbsSubscriberTax][name]':  { 
				   required : 'Please enter tax name',
				   taxnamecheck :'Tax name already exists'
			     },	
				'data[SbsSubscriberTax][code]':  { 
				   required : 'Please enter tax code',
				   taxcodecheck :'Tax code already exists'
			     },	
				'data[SbsSubscriberTax][percent]': {
					required : 'Please enter a number',
					max:'Number should be less than or equal to 100'
				}
			}
		});
		<?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
			$protocol_final = 'https';
		} else {
		  	$protocol_final = 'http';
		} ?>
		$.validator.addMethod("taxnamecheck",function(value,element){			
		 var x= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>taxes/taxnamecheck",
		    type: 'GET',
		    async: false,
		    data: "name=" + value +"&checking=true",
		 }).responseText;	
		 if(x=="0"){
		 	return true;
		 }else{
		 	return false;
		 } 
	},"Sorry, this DB name is not available");
	
	$.validator.addMethod("taxcodecheck",function(value,element){			
		 var x= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>taxes/taxcodecheck",
		    type: 'GET',
		    async: false,
		    data: "code=" + value +"&checking=true",
		 }).responseText;	
		 if(x=="0"){
		 	return true;
		 }else{
		 	return false;
		 } 
	},"Sorry, this DB name is not available");
});	



	
</script>			
       
<?php echo $this->Js->writeBuffer();?>  	
