<?php echo $this->Html->script(array('fuelux.spinner.min.js'));?>
<?php echo $this->Session->flash();?>

<!--div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="#">Home</a>
		</li>
        <li>								
			<a href="#">Settings</a>
		</li>
		<li>								
			<a href="#">Tax Settings</a>
		</li>
		<li class="active">Add Tax Group</li>
	</ul><!-- .breadcrumb -->
<!--/div-->

<div class="page-content">
	<!--div class="page-header">
		<h1>
			Add Tax Group								
		</h1>
        <!--div class="col-lg-2 paddingleftrightzero">
               <?php /*echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('controller'=>'taxes','action'=>'index'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));*/?>
            </div>
	</div-->
    <!-- /.page-header -->
        <div class="row">
				<div class="col-xs-12">
                 <?php echo $this->Form->create('SbsSubscriberTaxGroup');?>  
                   <div class="table-responsive table-responsivenoscroll ">
                     <div class="row margin-twenty-zero">
                        <div class="form-group margin-bottom-zero">
                            <label class="col-sm-2 control-label no-padding-right col-xs-12">Group Name</label>
                             <?php echo $this->Form->input('group_name',array('id'=>'group_name','type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'left'));?>  
                        </div>
                     </div>
                     <h3 class="header smaller lighter blue bold">Select Tax</h3>
                     
						<table id="sample-table-1" class="table table-striped table-bordered table-hover table_fixed_new mobiletax">
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
                                    	<!--<input type="text" class="input-mini col-xs-10 col-sm-5" id="spinner1" />-->
                                    	<?php echo $this->Form->input('priority.'.$key,array('id'=>'priority'.$i,'type'=>'text','div'=>FALSE,'label'=>FALSE,'class'=>'input-mini col-xs-10 col-sm-5'));?>   
                                    </td>
									<td>
                                    	<span>
                                            <label>
                                                <!--<input class="ace view" type="checkbox">-->
                                                <?php echo $this->Form->input('compounded.'.$key,array('type'=>'checkbox','div'=>FALSE,'label'=>FALSE,'class'=>'ace view'));?>    
                                                <span class="lbl"></span>
                                            </label>
                                         </span>
                                    </td>
								</tr>
								<?php endforeach;?>   
							</tbody>
                        </table>
                        <div class="row">
                        	
                            <div class="col-sm-12 col-sx-12 marginbottom20 margintop15">
                            	<button class="btn pull-right margin-left-15" type="reset">
                                    <i class="icon-undo bigger-110"></i>
                                    Reset
                                </button>
                                <div class=" pull-right">
                                	
                                 <?php echo $this->Js->submit('Submit', array('id'=>'add_promo','div'=>false,'class'=>'btn btn-info pull-right','url' => array('controller'=>'tax_groups','action'=>'add_group'),'escape'=>false,'update' => '#tabs-1'));?>
                                <?php /*echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('class'=>'btn btn-info pull-right','escape'=>false));*/?>
                               </div>
                            </div>
                        </div> 
                    </div>
                    <?php echo $this->Form->end();?>  								
                </div>
      </div>
      
                                                                                
</div><!-- /.page-content -->

<script type="text/javascript">
	jQuery(function($) {
		
		$(".chosen-select").chosen();
		<?php for($i=1;$i<=$count;$i++){ ?>
			$('#spinner<?php echo $i; ?>').attr("disabled","disabled");
			$('#spinner<?php echo $i; ?>').ace_spinner({value:0,min:0,max:200,step:1, editable:false,btn_up_class:'btn-info' , btn_down_class:'btn-info'})
		.on('change', function(){});
		<?php } ?>
				
	});
</script>	

<script type="text/javascript">
$(document).ready(function(){
	
	 
	 $("#SbsSubscriberTaxGroupAddGroupForm").validate({
	 	    onkeyup: false,
			rules: {
				'data[SbsSubscriberTaxGroup][group_name]': {
					required : true,
				    groupcheck1 :true
				}
				
			},
			messages: {
				
				'data[SbsSubscriberTaxGroup][group_name]': {
					required : "Please enter group name",
					groupcheck1 : "Group name already exists"
				}
				
			}
		});
		
		$.validator.addMethod("groupcheck1",function(value,element){			
		 var x= $.ajax({
		    url: "/cantorix/tax_groups/groupcheck",
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
	
	
	
	$('#add_promo').click(function () {
        	 var group_name=$("#group_name").val();
        	 //var discountval=$("#discount").val();
       	     
        	
      		 
		   $.ajax({
		       type:"POST",
		       beforeSend:function(){
		       		
		       		if(!group_name){
		       			stopEvent();
		       		}
		       }
			});
	    });
});	
</script>
<?php echo $this->Js->writeBuffer();?>  	
				