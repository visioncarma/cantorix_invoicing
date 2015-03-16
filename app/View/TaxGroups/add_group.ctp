<?php echo $this->Html->script(array('fuelux.spinner.min.js'));?>
<?php echo $this->Session->flash();?>

<div class="page-content">
	 <div class="row">
				<div class="col-xs-12">
                 <?php echo $this->Form->create('SbsSubscriberTaxGroup');?>  
                   <div class="table-responsive table-responsivenoscroll ">
                     <div class="row margin-twenty-zero">
                        <div class="form-group margin-bottom-zero">
                            <label class="col-sm-2 control-label no-padding-right col-xs-12">Group Name</label>
                             <?php echo $this->Form->input('group_name',array('id'=>'group_name','type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'left mobile_100'));?>  
                        </div>
                     </div>
                     <h3 class="header smaller lighter blue bold">Select Tax</h3>
                     
						<table id="sample-table-1" class="table table-striped table-bordered table-hover table_fixed_new mobiletax tax_groptable">
							<thead>
								<tr>
                                	<th>Tax Name</th>													
									<th>Priority</th>
									<th>Compounded</th>
								</tr>
							</thead>                                                
							<tbody>
							<?php $i=0; foreach($taxList as $key=>$value): $i++; ?>
								<tr>
                                	<td>
										<label>
											<?php echo $this->Form->input('sbs_subscriber_tax_id.'.$key,array('id'=>'tax'.$i,'type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace view'));?>    
											<span class="lbl"></span>
										</label>
										<span class="taxname"><?php echo $value; ?></span>
									</td>
                                	<td>	
                                    	<?php echo $this->Form->input('priority.'.$key,array('id'=>'priority'.$i,'type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'input-mini col-xs-10 col-sm-5','onkeypress' => "return isDuplicate(event)"));?>   
                                    </td>
									<td>
                                    	<span>
                                            <label>
                                                <!--<input class="ace view" type="checkbox">-->
                                                <?php echo $this->Form->input('compounded.'.$key,array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'validinput ace view all'));?>    
                                                <span class="lbl"></span>
                                            </label>
                                         </span>
                                    </td>
								</tr>
								<?php endforeach;?>   
							</tbody>
                        </table>
                       
                        <div class="row col-xs-12 col-sm-3" style="float:right;">
							 <div class="col-sm-12 col-xs-12 marginbottom20 margintop15 footerbutton" style="display:block;">
	                           
	                            <?php echo $this->Js->submit('Submit',array('url'=>array('controller'=>'tax_groups','action'=>'add_group'),'id'=>"form",'class'=>'btn btn-info add_promo button_mobile','title'=>'Add','update'=>'#tabs-1','div'=>false,'before' => $this->Js->get('#loading2')->effect('fadeIn', array('buffer' => false))));?>
								&nbsp; &nbsp; &nbsp;
								<button class="btn btn-inverse button_mobile" type="reset">
									<i class="icon-undo bigger-110"></i>
									Reset
								</button>
							</div>
					  </div>
					  <?php echo $this->Html->image('loding.gif', array('id'=>'loading2','style'=>'display:none;float: right;margin-right: 50%;'));?>
                    </div>
                    <?php echo $this->Form->end();?>  								
                </div>
      </div>
 <!--<a class="btn btn-inverse1 button_mobile">
									<i class="icon-undo bigger-110"></i>
									Reset
					</a>     -->
                                                                                
</div><!-- /.page-content -->
<style>
	label.error{
		margin-left:160px;
	}
</style>
	
<?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
	$protocol_final = 'https';
} else {
  	$protocol_final = 'http';
} ?>
<script type="text/javascript">


function isDuplicate(evt) {

$('input[type="text"]').change(function() {
	
	var $current = $(this);
	
    $('input[type="text"]').each(function() {
        if ($(this).val() == $current.val() && $(this).attr('id') != $current.attr('id'))
        {   
        	if($(this).val() != ''){
        		alert('Duplicate priority found!');
        		$current.val('');
        		return false;
        	}
        }
        /*if($(this).val() < $current.val() && $(this).attr('id') != $current.attr('id')){
         	if($current.attr('id') != 'group_name'){
         		 if($(this).val() != ''){
		         		if($('.all').is(':disabled')){
		         		   
		         		    alert('Compounded tax should have highest priority');
		         		    $current.val('');
		        		    return false;
		         	    }
		         	    
		         	    
		         	}
         	}
        }*/
        return true;

    });

  });
  
   var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        {
            alert("Please enter only numbers.");
            return false;
         }
         return true;
  
}
   
$(document).ready(function(){
	$('.all').click(function() {
	    $('.all').not(this).attr('disabled', $(this).is(':checked'));
	});
	
	$(".tax_groptable input.validinput").change(function(){
		if($(this).is(':checked')) {
			var currentvalue = parseInt($(this).parents('tr').find('input[type="text"]').val());
			var get_count = $('.tax_groptable input[type="text"]').length;
			for (var i = 1; i <= get_count; i++) {
				var fieldvalue = parseInt($('#priority'+i).val());
				if(currentvalue < fieldvalue) {
					$('#priority'+i).addClass('redborder');
				}
			}
		}else {
			var get_count = $('.tax_groptable input[type="text"]').length;
			for (var i = 1; i <= get_count; i++) {
				$('#priority'+i).removeClass('redborder');
			}
		}
	});	
	
	$("#sample-table-1 .input-mini").change(function(){
		
			if ($('input.validinput').is(':checked')) {
			var currentvalue = parseInt($(this).parents('tr').find('input[type="text"]').val());
			var get_count = $('.tax_groptable input[type="text"]').length;
			
			for (var i = 1; i <= get_count; i++) {
				var fieldvalue = parseInt($('#priority'+i).val());
				if(currentvalue < fieldvalue) {
					$('#priority'+i).addClass('redborder');
				}else {
					$('#priority'+i).removeClass('redborder');
				}
				
			}
		}else {
			var get_count = $('.tax_groptable input[type="text"]').length;
			for (var i = 1; i <= get_count; i++) {
			}
		}
			
	});	
		
	
	$(".add_promo").click(function(evt){
		var hasclasstrue = $("#sample-table-1 input[type='text']").hasClass("redborder");
		console.log(hasclasstrue);
		if(hasclasstrue == true) {
			alert('Compound tax must always be the highest priority.');
			evt.preventDefault();
			$('#field').value();
		}
	});
	
	
});
$(document).ready(function(){
	
	 
	 $("#SbsSubscriberTaxGroupAddGroupForm").validate({
	 	    onkeyup: false,
			rules: {
				'data[SbsSubscriberTaxGroup][group_name]': {
					groupcheck2 : true,
				    groupcheck1 :true
				    
				}
				
			},
			messages: {
				
				'data[SbsSubscriberTaxGroup][group_name]': {
					groupcheck2 : "Please enter group name",
					groupcheck1 : "Group name already exists"
					
				}
				
			}
		});
		
		$.validator.addMethod("groupcheck2",function(value,element){			
		 var x1= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>tax_groups/groupcheckempty",
		    type: 'GET',
		    async: false,
		    data: "group_name=" + value +"&checking=true",
		 }).responseText;	
		 if(x1=="1"){
		 	return true;
		 }else{
		 	return false;
		 } 
	},"Sorry, this DB name is not available");
		
		$.validator.addMethod("groupcheck1",function(value,element){			
		 var x= $.ajax({
		    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>tax_groups/groupcheck",
		    type: 'GET',
		    async: false,
		    data: "group_name=" + value +"&checking=true",
		 }).responseText;	
		 if(x=="1"){
		 	return true;
		 }else{
		 	return false;
		 } 
	},"Sorry, this DB name is not available");
	
	
	
	$('.add_promo').click(function () {
        	   var group_name=$("#group_name").val();
        	
      		  	
      		  	var x= $.ajax({
				    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>tax_groups/groupcheck",
				    type: 'GET',
				    async: false,
				    data: "group_name=" + group_name +"&checking=true",
				 }).responseText;	
				 
				 var x1= $.ajax({
				    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>tax_groups/groupcheckempty",
				    type: 'GET',
				    async: false,
				    data: "group_name=" + group_name +"&checking=true",
				 }).responseText;	  
        	
       		 
		   $.ajax({
		       type:"POST",
		       beforeSend:function(){
		       		if(x=="0" || x1=='0'){
		       			if(x=='0'){
		       				alert("Tax Group already exists");
		       			}
		       			if(x1=='0'){
		       				alert("Please enter tax group");
		       			}
		       			stopEvent();
		       		}
		       		
		       }
			});
	    });
	
});	
</script>
<?php echo $this->Js->writeBuffer();?>  	
				