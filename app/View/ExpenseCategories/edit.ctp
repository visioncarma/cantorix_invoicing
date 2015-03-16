<!--Edit category---->
<div class="modal-dialog model-dialog-new">
	<div class="modal-content">
		<div class="modal-header page-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
				<i class="icon-remove"></i>
			</button>
			<h1 class="modal-title" id="myModalLabel">Edit Expense Category</h1>
		</div>
		<?php echo $this -> Form -> create('AcpExpenseCategory', array('url' => array('controller' => 'expense_categories', 'action' => 'edit',$category['AcpExpenseCategory']['id'],$categoryName,$page), 'class' => 'form-horizontal popup', 'id' => 'UpdateExpenseCategory', 'inputDefaults' => array('div' => FALSE, 'label' => FALSE, 'class' => 'form-control'))); ?>
		<div class="modal-body">
			<div class="model-body-inner-content">
				<div class="form-group login-form-group">
					<label class="col-sm-4 control-label">Category Name<sup class="redstar">&lowast;</sup></label>
					<div class="col-sm-8 addcurrency_popup_input no-padding-left no-padding-right">
						<?php echo $this -> Form -> input('id',array('value'=>$category['AcpExpenseCategory']['id']));?>
						<?php echo $this -> Form -> input('category_name', array('placeholder' => 'Category Name','autocomplete'=>'off','value'=>$category['AcpExpenseCategory']['category_name'])); ?>
					</div>
				</div>
				<div class="form-group login-form-group">
					<label class="col-sm-4 control-label"> Description </label>
					<div class="col-sm-8 addcurrency_popup_input no-padding-left no-padding-right">
						<?php echo $this -> Form -> input('description', array('placeholder' => 'Description','rows'=>'2','autocomplete'=>'off','maxlength'=>'55','value'=>$category['AcpExpenseCategory']['description'])); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<?php echo $this -> Form -> button('<i class="icon-ok bigger-110"></i>Submit', array('class' => 'btn btn-info', 'type' => 'submit')); ?>
			
			<button class="btn btn-inverse popup-cancel" type="button">
			<i class="icon-remove bigger-110"></i>
			Cancel
			</button>
		</div>
		<?php echo $this -> Form -> end(); ?>
	</div>
</div>
<!--Edit category---->
<?php 
	if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
		$protocol_final = 'https';
	} else {
	  	$protocol_final = 'http';
	} 
?>
<script type="text/javascript">
	$(function(){
		
		$('.popup-cancel').click(function(){
			$('.close').trigger('click');
		});
		
		
		$("#UpdateExpenseCategory").validate({
		  	onkeyup: false,
		  	ignore:[],
			 rules: {           
				'data[AcpExpenseCategory][category_name]' : {
					required : true,
					checkAvailability : true
				}
			 },
		 	 messages:{
			 	'data[AcpExpenseCategory][category_name]' : {
			 		required : "Category name cannot be empty.",
			 		checkAvailability : "Category already exist." 
			 	}
			 }
		});
		
	$.validator.addMethod("checkAvailability",function(value,element){				
		var x = $.ajax({
			    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>expense_categories/validateCategory/<?php echo $category['AcpExpenseCategory']['id']?>",
			    type: 'POST',
			    async: false,
			    data: $("#UpdateExpenseCategory").serialize()
		 	}).responseText;	 	
			if(x=="false") return false;
			else return true;
		});	
	});
</script>
