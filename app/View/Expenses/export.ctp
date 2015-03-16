<?php if(!$export):?>

<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php $page = $this->Paginator->current('AcpExpense');?>
<?php echo $this->Session->flash();?>
<?php $homeLink = $this->Breadcrumb->getLink('Home');?>
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
			Export Expenses
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">  Export Expenses </div>
		<div class="col-lg-6 col-sm-12 col-md-12  col-xs-12 paddingleftrightzero pull-right">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>	
		</div>
	</div>
	<div class="row">
		<?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive tableexpense">
				<div class="table-header">
					Expenses List
				</div>
				<div class="row margin-twenty-zero expensemargin">
					<div class="col-lg-1 col-md-12 col-sm-12 col-xs-12 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-100-480">
						<?php echo $this->Form->input('expense_no',array('placeholder'=>'Expense No', 'class'=>'form-control'));?>
					</div>
					<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-100-480 margin-top-15-480">
						<?php echo $this->Form->input('vendor_name',array('placeholder'=>'Vendor Name', 'class'=>'form-control'));?>
					</div>
					<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 form-group filed-left margin-bottom-zero no-padding-left no-padding-right clear-600 margin-top-15-600 width-100-480">
						<?php echo $this->Form->input('customer_name',array('placeholder'=>'Customer Name', 'class'=>'form-control'));?>
					</div>
					<div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field clear-1300 margin-top-15-1300 width-100-480 mobile_100">
						<div class="input select choosen_width">
							<?php echo $this->Form->input('status',array('placeholder'=>'Status', 'class'=>'form-control invdrop selectitem','data-placeholder'=>"Status",'options'=>array(''=>'','Billable'=>'Billable','Billed'=>'Billed','Non Billable'=>'Non Billable')));?>
						</div>
					</div>
					<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 form-group input-group custom-datepicker no-padding-left no-padding-right clear-820 margin-top-15-820 width-100-480 datewidth">
						<?php echo $this->Form->input('from_date',array('placeholder'=>'From', 'class'=>'form-control date-picker','id'=>'id-date-picker-1','data-date-format'=>str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format'])));?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12  form-group input-group custom-datepicker no-padding-left no-padding-right clear-1100 margin-top-15-1100 width-100-480 datewidth">
						<?php echo $this->Form->input('to_date',array('placeholder'=>'To', 'class'=>'form-control date-picker','id'=>'id-date-picker-2','data-date-format'=>str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format'])));?>
						<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
					</div>
					
					<div class="form-group filed-left margin-bottom-zero margin-top-15-1300 clear-620 mobile_100">
						<?php echo $this->Form->submit('Export',array('class'=>'btn btn-sm btn-primary filter-btn mobile_100','type'=>'submit'));?>
					</div>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>


<?php else:?>
<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
  //declare the xls helper
  $xls= new xlsHelper();
 
  //input the export file name
  $xls->setHeader('Expenses'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Expenses');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('Expense Date');
  $xls->writeString('Category');
  $xls->writeString('Vendor Name');
  $xls->writeString('Reference No');
  $xls->writeString('Customer Name');
  $xls->writeString('Currency Code');
  $xls->writeString('Status');
  $xls->writeString('Item Name');
  $xls->writeString('Expense Desc');
  $xls->writeString('Quantity');
  $xls->writeString('Item Price');
  $xls->writeString('Tax Group');
  $xls->writeString('Tax');
  $xls->writeString('Item Total');
  $xls->writeString('Sub Total');
  $xls->writeString('Tax Total');
  $xls->writeString('Total');
  $xls->writeString('Notes');
 if($expenseFields){
  	foreach($expenseFields as $key => $field):
  		$xls->writeString($field);
  	endforeach;
  }
  $xls->closeRow();
   
  //rows for data
  foreach ($expenses as $expense):
    $xls->openRow();
    $xls->writeString(date($settings['SbsSubscriberSetting']['date_format'],strtotime($expense['AcpExpense']['date'])));
    $xls->writeString($expense['AcpExpenseCategory']['category_name']);
	$xls->writeString($expense['AcpVendor']['vendor_name']);
	$xls->writeString($expense['AcpExpense']['expense_no']);
	$xls->writeString($expense['AcrClient']['organization_name']);
	$xls->writeString($defaultCurrencyCode);
	$xls->writeString($expense['AcpExpense']['status']);
	$xls->writeString($expense['InvInventory']['name']);
	$xls->writeString($expense['AcpInventoryExpense']['inventory_description']);
	$xls->writeString($expense['AcpInventoryExpense']['quantity']);
	$xls->writeString(round($expense['AcpInventoryExpense']['cost_price'],2));
	$xls->writeString($expense['SbsSubscriberTaxGroup']['group_name']);
	$xls->writeString($expense['SbsSubscriberTax']['name']);
	$xls->writeString(round($expense['AcpInventoryExpense']['total_amount'],2));
	$xls->writeString(round($expense['AcpExpense']['sub_total'],2));
	$xls->writeString(round($expense['AcpExpense']['tax_total'],2));
	$xls->writeString(round($expense['AcpExpense']['amount'],2));
	$xls->writeString($expense['AcpExpense']['notes']);
    foreach($expenseFields as $fieldId => $fieldVal) {
    	foreach ($expense['CustomValues'] as $customValue) {
			if($customValue['AcpExpenseCustomFieldValue']['acp_expense_custom_field_id'] == $fieldId) {
	    		$xls->writeString($customValue['AcpExpenseCustomFieldValue']['data']);
	    	}
		}
	}
    $xls->closeRow();
	endforeach;
  
  
  	$xls->addXmlFooter();
  
  
  exit();
?>
<?php endif;?>

<script type="text/javascript">
	$(document).ready(function() {
		/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
		
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