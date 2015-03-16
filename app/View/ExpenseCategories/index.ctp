<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php $page = $this->Paginator->current('AcpExpenseCategory');?>
<?php echo $this->Session->flash();?>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
	$expensesLink =  $this->Breadcrumb->getLink('Expenses');
if($categoryName) {
	$url = array('action'=>'index',$categoryName);
} else {
	$url = array('action'=>'index');
}
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link('Expenses',$expensesLink);?>
		</li>
		<li class="active">
			Manage Expense Categories
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Manage Expense Categories
		</div>
		
		<?php if($permission['_create'] == '1'):?>
		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-8 no-padding-left no-padding-right width-after-600">
			<a class="btn btn-sm btn-success pull-right addbutton width-after-400 "  data-target="#addcategory" data-toggle="modal" href="#"> <i class="icon-plus"></i> Add Expense Category </a>
		</div>
		<?php endif;?>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive tableexpense">
				<div class="table-header">
					Expense Categories List
				</div>
				<div class="row margin-twenty-zero expensemargin">
					<div class="form-group filed-left margin-bottom-zero width-full-480">
						<?php echo $this->Form->input('category_name',array('placeholder'=>'Category Name', 'class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->submit('Filter',array('url'=>array('action'=>'index'),'class'=>'btn btn-sm btn-primary filter-btn mobile_100','type'=>'submit','update'=>'#pageContent'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Html->link('Reset',array('action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn form-control mobile_100','title'=>'Reset filtered result'));?>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end();?>
	</div>
	<div class="row">
		<?php echo $this->Form->create('ExpenseCategory',array('url'=>array('controller'=>'expense_categories','action'=>'deleteAll')));?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom5">
					<div class="select-all-mobile select-all select-all-expanse">
						<div>
							<input class="ace" type="checkbox"/>
							<span class="lbl"> &nbsp;&nbsp; Select All</span> 
						</div>
					</div>
					<div class="delete-all-trash">
						<?php 
		                 	if($permission['_delete'] == '1') {
								echo $this->Form->submit('delete_selected.png',array('class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected','onclick'=>"return confirm('Are you sure you want to delete selected expense categories ?')"));
							}
						?>
					</div>
				</div>
				
				<?php foreach($expenseCategories as $expenseCategory):?>
				<table class="table table-striped roles-table">
					<tr>
						<td class="select-all width-30-new"><label>
							<input class="ace" type="checkbox"/>
							<span class="lbl"></span> </label></td>
						<td class="title_role bold width-150-new resized"><?php echo $this->Paginator->sort('category_name','Category Name',array('url'=>$url));?></td>
						<td class="title bold width-600-new resized"><?php echo $this->Paginator->sort('description','Description',array('url'=>$url));?></td>
						<td class="title bold action width-120-new">Action</td>
						<td class="title select-each-mobile bold">Select</td>
					</tr>
					<tr class="even-strip">
						<td class="select-each width-30-new"><label>
							<?php
								if($permission['_delete'] == '1') {
									echo $this->Form->checkbox('ExpenseCategory.Delete.'.$expenseCategory['AcpExpenseCategory']['id'],array('class'=>'ace'));
								}
							?>
							<span class="lbl"></span> </label></td>
						<td class="title_role width-150-new resized"><?php echo $expenseCategory['AcpExpenseCategory']['category_name'];?></td>
						<td class="title width-600-new resized"><?php echo $expenseCategory['AcpExpenseCategory']['description'];?></td>
						<td class="title width-120-new">
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">	
							
								<?php if($permission['_read'] == '1'):?>
								<button id="<?php echo $expenseCategory['AcpExpenseCategory']['id'];?>" class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewCategory">
									<i class="icon-zoom-in bigger-120"></i>
								</button>
								<?php endif;?>
								<?php if($permission['_update'] == '1'):?>
								<button id="E<?php echo $expenseCategory['AcpExpenseCategory']['id'];?>" class="btn btn-xs btn-info edit on-load" title="Edit" data-toggle="modal" data-target="#editCategory">
									<i class="icon-edit bigger-120"></i>
								</button>
								<?php endif;?>
								<?php if($permission['_delete'] == '1'):?>
									<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('action' => 'delete', $expenseCategory['AcpExpenseCategory']['id'],$categoryName,$page), array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete Expense category ?')); ?>
								<?php endif;?>
							</div>
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>
									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
										<li>
											<?php if($permission['_read'] == '1'):?>
											<button id="<?php echo $expenseCategory['AcpExpenseCategory']['id'];?>" class="btn btn-xs btn-success view on-load" title="View" data-toggle="modal" data-target="#viewCategory">
												<i class="icon-zoom-in bigger-120"></i>
											</button>
											<?php endif;?>
										</li>
										<li>
											<?php if($permission['_update'] == '1'):?>
											<button id="E<?php echo $expenseCategory['AcpExpenseCategory']['id'];?>" class="btn btn-xs btn-info edit on-load" title="Edit" data-toggle="modal" data-target="#editCategory">
												<i class="icon-edit bigger-120"></i>
											</button>
											<?php endif;?>
										</li>
										<li>
											<?php if($permission['_delete'] == '1'):?>
												<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>',array('action' => 'delete', $expenseCategory['AcpExpenseCategory']['id'],$categoryName,$page), array('class'=>'btn btn-xs btn-danger delete on-load anchorbutton','title'=>'Delete','escape'=>FALSE), __('Are you sure want to delete Expense category ?')); ?>
											<?php endif;?>
										</li>
									</ul>
								</div>	
							</div>		
						</td>
						<td class="select-each-mobile select-each"><label>
							<input class="ace" type="checkbox"/>
							<span class="lbl"></span> </label>
						</td>
					</tr>
				</table>
				<?php endforeach;?>
				
			</div>
		</div>
		<?php echo $this->Form->end();?>
	</div>
	<div class="row paddingtop25">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div id="sample-table-2_info" class="dataTables_info">
				<?php echo $this->Paginator->counter(array('format' => __('Showing {:start} to {:end} of {:count} entries')));?>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="dataTables_paginate paging_bootstrap">
				<ul class="pagination">
					<?php
						$this->Paginator->options(array(
                            'update' => '#pageContent',
                            'evalScripts' => TRUE,
                            'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),
                            'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false)),
                            'url' => $url
                        ));
                        echo $this->Paginator->first('<i class="icon-double-angle-left"></i>', array('escape'=>false,'tag' => 'li','title'=>'First'), array('escape'=>false,'tag'=>'li','title'=>'First')); 
						echo $this->Paginator->prev('<i class="icon-angle-left"></i>', array('escape'=>false,'tag' => 'li','title'=>'Previous'), '',array('escape'=>false,'tag'=>'li','style'=>'display:none;'));
						echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentClass'=>'active','currentTag'=>'a'));
						echo $this->Paginator->next('<i class="icon-angle-right"></i>', array('escape'=>false,'tag' => 'li','title'=>'Next'),'<a href="#"><i class="icon-double-angle-right"></i></a>', array('escape'=>false,'tag'=>'li','style'=>'display:none;'));
						echo $this->Paginator->last('<i class="icon-double-angle-right"></i>', array('escape'=>false,'tag' => 'li','title'=>'Last'), array('escape'=>false,'tag'=>'li','title'=>'Last'));
                        echo $this->Html->image('loding.gif', array('id'=>'loading','style'=>'display:none;float: right;margin-right: -18px;padding-top: 4px;'));
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- /.page-content -->
		<?php if($permission['_create'] == '1'):?>
		<!--add new category---->
		<div class="modal fade" id="addcategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog model-dialog-new">
				<div class="modal-content">
					<div class="modal-header page-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							<i class="icon-remove"></i>
						</button>
						<h1 class="modal-title" id="myModalLabel">Add New Expense Category</h1>
					</div>
					<?php echo $this->Form->create('AcpExpenseCategory',array('url'=>array('controller'=>'expense_categories','action'=>'index'),'class'=>'form-horizontal popup','id'=>'ExpenseCategoryNew','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control')));?>
						<div class="modal-body">
							<div class="model-body-inner-content">
								<div class="form-group login-form-group">
									<label class="col-sm-4 control-label">Category Name<sup class="redstar">&lowast;</sup></label>
									<div class="col-sm-8 addcurrency_popup_input no-padding-left no-padding-right">
										<?php echo $this->Form->input('category_name',array('placeholder'=>'Category Name','autocomplete'=>'off'));?>
									</div>
								</div>
								<div class="form-group login-form-group">
									<label class="col-sm-4 control-label"> Description </label>
									<div class="col-sm-8 addcurrency_popup_input no-padding-left no-padding-right">
										<?php echo $this->Form->input('description',array('placeholder'=>'Description','rows'=>'2','autocomplete'=>'off','maxlength'=>'55'));?>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('class'=>'btn btn-info','type'=>'submit'));?>       
            				<?php echo $this->Form->button('<i class="icon-undo bigger-110"></i>Reset',array('class'=>'btn btn-inverse','type'=>'reset'));?>
						</div>
					<?php echo $this->Form->end();?>
				</div>
			</div>
		</div>
		<!--add new category---->
		<?php endif;?>
		<?php if($permission['_read'] == '1'):?>
		<div class="modal fade" id="viewCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
		<?php endif;?>
		<?php if($permission['_update'] == '1'):?>
		<div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
		<?php endif;?>
<?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
		$protocol_final = 'https';
	} else {
	  	$protocol_final = 'http';
	} ?>
<script type="text/javascript">
	$(function(){
		
		$('.view').click(function() {
			var categoryID = $(this).attr('id');
			$.ajax({
			    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>expense_categories/view/"+categoryID,
			    type: 'GET',
			    async: false,
			    success:function(result){
      				$("#viewCategory").html(result);
      			}
		 	})
		});
		
		$('.edit').click(function() {
			var editID = $(this).attr('id');
			var editCategoryID = editID.substr(1);
			$.ajax({
			    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>expense_categories/edit/"+editCategoryID+"/<?php echo $categoryName;?>/<?php echo $page;?>",
			    type: 'GET',
			    async: false,
			    success:function(result){
      				$("#editCategory").html(result);
      			}
		 	})
		});
		
		
		$("#ExpenseCategoryNew").validate({
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
			    url: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>expense_categories/validateCategory/",
			    type: 'POST',
			    async: false,
			    data: $("#ExpenseCategoryNew").serialize()
		 	}).responseText;	 	
			if(x=="false") return false;
			else return true;
		});	
	});

			deleteselected = function() {
				//alert($('.roles-table input[type="checkbox"]:checked').length);
				if ($('.roles-table input[type="checkbox"]:checked').length > 0) {
					$('.delete-all-trash').fadeIn();
				} else {
					$('.delete-all-trash').fadeOut();

				}
			}; 
			select_each_row_mobile = function(that) {
				if ((that).is(":checked")) {
					$(that).parents('table').find('.select-each input[type="checkbox"]').prop('checked', true);
				} else {
					$(that).parents('table').find('.select-each input[type="checkbox"]').prop('checked', false);
				}
			}

			$(document).ready(function() {
				//table mobile view script//
				if ($('.roles-table-wrapper-inner').length) {
					var winsize = 1;
					if ($('.roles-table').length) {
						var i = 1;
						$('.roles-table').each(function() {
							$(this).addClass("role-table-" + i);
							i++;
						});
					}
					$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");

					$changeTableView = function() {
						$(".table").each(function() {
							var $this = $(this);
							var newrows = [];
							$this.find("tr").each(function() {
								var i = 0;
								$(this).find("td").each(function() {
									i++;
									if (newrows[i] === undefined) {
										newrows[i] = $("<tr></tr>");
									}
									newrows[i].append($(this));
								});
							});
							$this.find("tr").remove();
							$.each(newrows, function() {
								$this.append(this);
							});
						});

					};

					if ($(window).width() < 992) {
						$changeTableView();
						winsize = 0;
					}

					$(window).on("resize", function() {

						if (Math.floor($(window).width() / 992) != winsize) {
							$changeTableView();
							winsize = Math.floor($(window).width() / 992);
						}
						if ($(window).width() > 992) {
							$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");
						}
					});
				}
				//table mobile view script//

				//for alternative row colors
				var i = 0;
				$('.even-strip').each(function() {
					if (i % 2 != 0) {
						$(this).addClass("coloredrow");
					}
					i++;
				});

				//for alternative row colors

				$('.roles-table input[type="checkbox"]').click(function() {
					select_each_row_mobile($(this));
				});

				//delete all trash fadein and fadeout

				//select all check boxes
				$('.select-all-mobile input[type="checkbox"]').click(function() {
					if ($(this).is(":checked")) {
						$('.roles-table .select-all').find('input[type="checkbox"]').prop('checked', true);
					} else {
						$('.roles-table .select-all').find('input[type="checkbox"]').prop('checked', false);
					}
				});

				$('.select-all input[type="checkbox"]').click(function() {
					if ($(this).is(":checked")) {
						$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
						$('.select-each').find('input[type="checkbox"]').prop('checked', true);
						$('.select-all').find('input[type="checkbox"]').prop('checked', true);
					} else {
						$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', false);
						$('.select-each').find('input[type="checkbox"]').prop('checked', false);
						$('.select-all').find('input[type="checkbox"]').prop('checked', false);
					}
					deleteselected();
				});

				$('.select-each input[type="checkbox"]').click(function() {
					if ($(this).find('input[type="checkbox"]').prop('checked', true)) {
						if ($('.select-all').find('input[type="checkbox"]').prop('checked', true)) {
							$('.select-all').find('input[type="checkbox"]').prop('checked', false);
							$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', false);
						}
					}
					if ($('.select-each input[type="checkbox"]').length == $('.select-each input[type="checkbox"]:checked').length) {
						$('.select-all').find('input[type="checkbox"]').prop('checked', true);
						$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
					}
					deleteselected();
				});

				$('.select-each-mobile input[type="checkbox"]').click(function() {
					if ($('.select-each-mobile input[type="checkbox"]').length == $('.select-each-mobile input[type="checkbox"]:checked').length) {
						$('.select-all').find('input[type="checkbox"]').prop('checked', true);
						$('.select-all-mobile').find('input[type="checkbox"]').prop('checked', true);
					}
					deleteselected();
				});

			});

		</script>
		
<?php echo $this->Js->writeBuffer();?>