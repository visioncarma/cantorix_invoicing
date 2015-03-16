<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php $page = $this->Paginator->current('AcpExpense');?>
<?php echo $this->Session->flash();?>
<?php $homeLink = $this->Breadcrumb->getLink('Home');

if($expenseNo || $vendorName || $customerName || $fromDate || $toDate || $status) {
	$url = array('action'=>'index',$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status);
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
			<?php echo $this->Html->link('Expenses',array('controller'=>'expenses','action'=>'index'));?>
		</li>
		<li class="active">
			Manage Expenses
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">

	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Manage Expenses
		</div>
		<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600">
			<?php if($permission['_create'] == '1'):?>
			<div class="widthauto paddingleftrightzero pull-right buttonrightwidth padding-right-3-480 mobile_100">
				<?php echo $this->Html->link('<i class="icon-plus"></i> Add Expense',array('action'=>'add'),array('class'=>'btn btn-sm btn-success pull-right addbutton width-after-400 mobile_100','escape'=>FALSE));?>
			</div>
			<div class="widthauto paddingleftrightzero pull-right padding-right-3-480 width50p margin-top-10-420 buttonrightwidth mobile_100">
				<?php echo $this->Html->link('Export Expenses <i class="icon-caret-down icon-on-right"></i>',array('action'=>'export'),array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right manageinventoryexport paddingbutton width-after-400 mobile_100'));?>
			</div>
			<div class="widthauto paddingleftrightzero pull-right width50p margin-top-10-420 buttonrightwidth mobile_100">
				<?php echo $this->Html->link('Import Expenses <i class="icon-caret-down icon-on-right"></i>',array('action'=>'import'),array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right importbutton paddingbutton width-after-400 mobile_100
				'));?>
			</div>
			<?php endif;?>
		</div>
	</div>

	<!-- /.page-header -->
	<div class="row">
		<?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive tableexpense">
				<div class="table-header">
					Expenses List
				</div>
				<div class="row margin-twenty-zero expensemargin">
					<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-100-480">
						<?php echo $this->Form->input('expense_no',array('placeholder'=>'Reference No', 'class'=>'form-control'));?>
					</div>
					<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-100-480 margin-top-15-480">
						<?php echo $this->Form->input('vendor_name',array('placeholder'=>'Vendor Name', 'class'=>'form-control'));?>
					</div>
					<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 form-group filed-left margin-bottom-zero no-padding-left no-padding-right clear-600 margin-top-15-600 width-100-480">
						<?php echo $this->Form->input('customer_name',array('placeholder'=>'Customer Name', 'class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field clear-1300 margin-top-15-1300 width-100-480 margintopzero mobile_100">
						<div class="input select choosen_width">
							<?php echo $this->Form->input('status',array('placeholder'=>'Status', 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Status",'options'=>array(''=>'Status','Billable'=>'Billable','Billed'=>'Billed','Non Billable'=>'Non Billable')));?>
						</div>
					</div>
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right clear-820 margin-top-15-820 width-100-480 margintopzero datewidth">
						<?php echo $this->Form->input('from_date',array('placeholder'=>'From', 'class'=>'form-control date-picker','id'=>'id-date-picker-1','data-date-format'=>str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format'])));?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="col-lg-2 form-group input-group custom-datepicker no-padding-left no-padding-right clear-600 margin-top-15-1100 width-100-480 margintopzero datewidth">
						<?php echo $this->Form->input('to_date',array('placeholder'=>'To', 'class'=>'form-control date-picker','id'=>'id-date-picker-2','data-date-format'=>str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format'])));?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					
					<div class="form-group filed-left margin-bottom-zero margin-top-15-1300 clear-620 margintopzero mobile_100">
						<?php echo $this->Js->submit('Filter',array('url'=>array('action'=>'index'),'class'=>'btn btn-sm btn-primary filter-btn filterwidth mobile_100','type'=>'submit','update'=>'#pageContent'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero margin-top-15-1300 margintopzero mobile_100">
						<?php echo $this->Html->link('Reset',array('action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn filterwidth mobile_100','title'=>'Reset filtered result'));?>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end();?>
	</div>
	<div class="row">
		<?php echo $this->Form->create('ExpenseCategory',array('url'=>array('controller'=>'expenses','action'=>'deleteAll')));?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom5">
					<div class="select-all-mobile select-all">
						<label>
							<input class="ace" type="checkbox"/>
							<span class="lbl">Select All</span> </label>
					</div>
					<div class="delete-all-trash">
						<?php 
		                 	if($permission['_delete'] == '1') {
								echo $this->Form->submit('delete_selected.png',array('class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected','onclick'=>"return confirm('Are you sure you want to delete selected expenses ?')"));
							}
						?>
					</div>
				</div>
				<?php foreach($expenses as $expense):?>
				<table class="table table-striped roles-table tabletlandscape">
					<tr>
						<td class="select-all width-30-new"><label>
							<input class="ace" type="checkbox"/>
							<span class="lbl"></span> </label></td>
						<td class="title_role bold width-120-new"><?php echo $this->Paginator->sort('expense_no','Reference No',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold width-150-new"><?php echo $this->Paginator->sort('AcpVendor.vendor_name','Vendor Name',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold width-120-new"><?php echo $this->Paginator->sort('AcrClient.organization_name','Customer Name',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold width-100-new"><?php echo $this->Paginator->sort('date','Date',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold width-80-new"><?php echo $this->Paginator->sort('status','Status',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold width-150-new textright padding-right-25"><?php echo $this->Paginator->sort('amount','Expense Amount',array('url'=>$url,'lock'=>TRUE));?></td>
						<td class="title bold action width-120-new">Action</td>
						<td class="title select-each-mobile bold">Select</td>
					</tr>
					<tr class="even-strip">
						<td class="select-each width-30-new"><label>
							<?php
								if($permission['_delete'] == '1') {
									echo $this->Form->checkbox('Expense.Delete.'.$expense['AcpExpense']['id'],array('class'=>'ace'));
								}
							?>
							<span class="lbl"></span> </label></td>
						<td class="title_role ewidth120 width-120-new expenseNO"><?php echo $expense['AcpExpense']['expense_no'];?></td>
						<td class="title width-150-new"><?php echo $expense['AcpVendor']['vendor_name'];?></td>
						<td class="title width-120-new"><?php echo $expense['AcrClient']['organization_name'];?></td>
						<td class="title width-100-new"><?php str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format']);echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($expense['AcpExpense']['date']));?></td>
						<td class="title width-80-new">
							<?php
								if($expense['AcpExpense']['status'] == 'Billable') {
									echo '<span style="color:#2C83B8">Billable</span>';
								} elseif($expense['AcpExpense']['status'] == 'Billed') {
									echo '<span style="color:#6D9944">Billed</span>';
								} else {
									echo '<span style="color:#000000">'.$expense['AcpExpense']['status'];'</span>';
								}
							?>
						</td>
						<td class="title width-150-new textright padding-right-25"><?php echo $this->Number->currency($expense['AcpExpense']['amount'], $defaultCurrencyInfo['CpnCurrency']['code']);?></td>
						<td class="title width-120-new">
						<!--<button class="btn btn-xs btn-pink view on-load" title="Covert To Invoice" >
							<i class="icon-columns bigger-120"></i>
						</button> -->
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<?php if($permission['_update'] == '1' && $expense['AcpExpense']['status'] == 'Billable'):?>
									<button class="btn btn-xs btn-pink view on-load convertInvoice" title="Convert To Invoice" data-toggle="modal" data-target="#C<?php echo $expense['AcpExpense']['id'];?>">
										<i class="icon-columns bigger-120"></i>
									</button>
								<?php endif;?>
								<?php if($permission['_update'] == '1' && $expense['AcpExpense']['status'] != 'Billed'):?>
									<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit',$expense['AcpExpense']['id'],$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,$page),array('title'=>'Edit','escape'=>FALSE,'class'=>'btn btn-xs btn-info edit on-load'));?>
								<?php endif;?>
								<div class="inline position-relative">
									<button class="btn btn-minier btn-warning dropdown-toggle expbutton" data-toggle= "dropdown">
										<i class="icon-caret-down bigger-120"></i>
									</button>
									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close newdropdown_font">
										<?php if($permission['_read'] == '1'):?>
										<li>
											<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$expense['AcpExpense']['id'],$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,$page),array('escape'=>FALSE,'title'=>'View','class'=>'btn btn-xs btn-success view on-load anchorbutton'));?>
										</li>
										<?php endif;?>
										<?php if($permission['_delete'] == '1'):?>
										<li>
											<button class="btn btn-xs btn-danger delete on-load deleteQuote" title="Delete" data-toggle="modal" data-target="#D<?php echo $expense['AcpExpense']['id'];?>">
												<i class="icon-trash bigger-120"></i>
											</button>
										</li>
										<?php endif;?>
									</ul>
								</div>
							</div>
							
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>
									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
										<li>
											<?php if($permission['_update'] == '1' && $expense['AcpExpense']['status'] == 'Billable'):?>
												<button class="btn btn-xs btn-pink view on-load convertInvoice" title="Convert To Invoice" data-toggle="modal" data-target="#C<?php echo $expense['AcpExpense']['id'];?>">
													<i class="icon-columns bigger-120"></i>
												</button>
											<?php endif;?>
										</li>
										<li>
											<?php if($permission['_update'] == '1' && $expense['AcpExpense']['status'] != 'Billed'):?>
												<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit',$expense['AcpExpense']['id'],$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,$page),array('title'=>'Edit','escape'=>FALSE,'class'=>'btn btn-xs btn-info edit on-load anchorbutton'));?>
											<?php endif;?>
										</li>
										<?php if($permission['_read'] == '1'):?>
										<li>
											<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$expense['AcpExpense']['id'],$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,$page),array('escape'=>FALSE,'title'=>'View','class'=>'btn btn-xs btn-success view on-load anchorbutton'));?>
										</li>
										<?php endif;?>
										<?php if($permission['_delete'] == '1'):?>
										<li>
											<button class="btn btn-xs btn-danger delete on-load deleteQuote" title="Delete" data-toggle="modal" data-target="#D<?php echo $expense['AcpExpense']['id'];?>">
												<i class="icon-trash bigger-120"></i>
											</button>
										</li>
										<?php endif;?>
									</ul>	
								</div>	
							</div>	
						
						
						
						</td>
						<td class="select-each-mobile select-each"><label>
							<?php
								if($permission['_delete'] == '1') {
									echo $this->Form->checkbox('Expense.Delete.'.$expense['AcpExpense']['id'],array('class'=>'ace'));
								}
							?>
							<span class="lbl"></span> </label></td>
					</tr>
				</table>
				<?php endforeach;?>
			</div>
		</div>
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
<!-- inline scripts related to this page -->

<!--Popup Delete  -->
<div class="modal fade delete"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modaldialogcancel475">
		<div class="modal-content">
			<div class="modelinsidesubscriber">
				 <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button> 

				<div class="form-horizontal popup" >
					<div class="modal-body">
						<div class="model-body-inner-content">
							<div>
								<h3 class="bolder red 22pfont center"> Delete Expense </h3>
								<div class="center 14pfont paddingbottom">
									You are about to delete expense #<span class="quotepopno"></span>.<br />Are you sure want to delete ?
								</div>
								<div class="space-12"></div>

								<div class="paddingleftrightzero padingleftneed buttoncenter">
									<?php echo $this->Html->link('Delete',array('action'=>'delete',$expense['AcpExpense']['id'],$expenseNo,$vendorName,$customerName,$fromDate,$toDate,$status,$page),array('class'=>'btn btn-sm paddingbtn-sm-ok btn-danger delete on-load deleteLink','escape'=>FALSE));?>
									<button class="btn btn-sm btn-danger" data-dismiss="modal">
										Cancel
									</button>
								</div>
								<div class="space-6"></div>
								<p> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<!--end of pop-->


<!--Popup Convert to invoice-->
<div class="modal fade first"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modaldialogcancel475">
		<div class="modal-content">
			<div class="modelinsidesubscriber">
				<button class="close" aria-hidden="true" data-dismiss="modal" type="button">
					<i class="icon-remove"></i>
				</button>

				<form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
					<div class="modal-body">
						<div class="model-body-inner-content">
							<div>
								<h3 class="bolder red 22pfont center"> Convert to Invoice </h3>
								<div class="center 14pfont paddingbottom">
									You are about to convert expense #<span class="quotepopno"><?php echo $value['AcrClient']['client_name'];?></span> to an invoice.
								</div>
								<div class="space-12"></div>

								<div class="paddingleftrightzero padingleftneed buttoncenter">
									<?php echo $this->Html->link('Ok',array('action'=>'convertToInvoice'),array('class'=>'btn btn-sm paddingbtn-sm-ok btn-danger delete on-load convertToInvoiceLink','escape'=>FALSE));?>
									<button class="btn btn-sm btn-danger" data-dismiss="modal">
										Cancel
									</button>
								</div>
								<div class="space-6"></div>
								<p> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;</p>
							</div>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
<!--end of Popup Convert to invoice pop up-->



<script type="text/javascript">
	deleteselected = function() {
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
		
		/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
		
		$('.deleteQuote').click(function(){
			quoteno = $(this).parents('tr').find('td.expenseNO').text();
			$('.quotepopno').text(quoteno);
	 		var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(2,thislength);
	 		$('.modal.fade.delete').attr('id','D'+thisid);
	 		$('.deleteLink').attr('href',"<?php echo $this->webroot.'expenses/delete/';?>"+thisid+"<?php echo '/'.$expenseNo.'/'.$vendorName.'/'.$customerName.'/'.$fromDate.'/'.$toDate.'/'.$status.'/'.$page;?>");
	 	});
		
		$('.convertInvoice').click(function(){
			quoteno = $(this).parents('tr').find('td.expenseNO').text();
	 		$('.quotepopno').text(quoteno);
	 		var thisid=$(this).attr('data-target');
	 		var thislength=thisid.length;
	 		thisid=thisid.slice(2,thislength);
	 		$('.modal.fade.first').attr('id','C'+thisid);
	 		$('.convertToInvoiceLink').attr('href',"<?php echo $this->webroot.'expenses/convertToInvoice/';?>"+thisid+"<?php echo '/0/'.$expenseNo.'/'.$vendorName.'/'.$customerName.'/'.$fromDate.'/'.$toDate.'/'.$status.'/'.$page;?>");
	 	});
		
		
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
<script type="text/javascript">
	$(document).ready(function() {
		$('.date-picker').datepicker({
			autoclose : true
		}).next().on(ace.click_event, function() {
			$(this).prev().focus();
		});
		if ($('.selectpicker').length) {
			$('.selectpicker').selectpicker({
			});
		}
	}); 
</script>
<?php echo $this->Js->writeBuffer();?>