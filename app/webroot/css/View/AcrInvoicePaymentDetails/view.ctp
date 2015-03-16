<?php
    $this->CurrencySymbol->getAllCurrencies(); 
	$homeLink 	 = $this->Breadcrumb->getLink('Home');
	$invoiceLink = $this->Breadcrumb->getLink('Invoices');
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
        <li>								
			<?php echo $this->Html->link('Invoices',"$invoiceLink");?>
		</li>
		<li class="active"><?php echo __('View Payment Details');?></li>
	</ul>
</div>
<div class="page-content">
	<div class="page-header">
		<h1><?php echo __('View Payment Details');?> <span class="header-span"> <i class="icon-double-angle-right"></i> <?php echo __($paymentData['AcrClientInvoice']['invoice_number']);?> </span></h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index', $filterAction, $filterValue, $filterValue1, $filterValue2, $fromDate, $toDate, 'page:'.$page),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?><br />
		</div>

	</div>
	<!-- /.page-header -->
	<div class="form-horizontal left width-100 paddingbottom20 margintopzero">
		<div class="row marginleftrightzero">
			<div class="col-lg-12 paddingleftrightzero">
				<div class="row marginleftrightzero borderline">
					<div class="form-group marginleftrightzero no-margin-bottom paddingtopbottom10">
						<label  class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Invoice No</label>
						<div class="col-sm-9 marginleftrightzero paddingleftrightzero">
							<label  class="col-sm-12 control-label marginleftrightzero paddingleftrightzero bold"><?php echo $paymentData['AcrClientInvoice']['invoice_number'];?></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero borderline">
					<div class="form-group marginleftrightzero no-margin-bottom paddingtopbottom10">
						<label  class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Payment Method</label>
						<div class="col-sm-9 marginleftrightzero paddingleftrightzero">
							<label  class="col-sm-12 control-label marginleftrightzero paddingleftrightzero bold"><?php echo $paymentData['CpnPaymentMethod']['payment_option_name'];?></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero borderline">
					<div class="form-group marginleftrightzero no-margin-bottom paddingtopbottom10">
						<label  class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Receipt Amount</label>
						<div class="col-sm-9 marginleftrightzero paddingleftrightzero">
							<label  class="col-sm-12 control-label marginleftrightzero paddingleftrightzero bold">
								<?php $options = array('places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
								<?php echo $this->Number->currency($paymentData['AcrInvoicePaymentDetail']['paid_amount'],$paymentData['AcrClientInvoice']['invoice_currency_code']);?>
							</label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero borderline">
					<div class="form-group marginleftrightzero no-margin-bottom paddingtopbottom10">
						<label  class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Outstanding Balance</label>
						<div class="col-sm-9 marginleftrightzero paddingleftrightzero">
							<label  class="col-sm-12 control-label marginleftrightzero paddingleftrightzero bold">
								<?php $options = array('places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
					            <?php echo $this->Number->currency($balance_due, $paymentData['AcrClientInvoice']['invoice_currency_code']);?>
							</label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero borderline">
					<div class="form-group marginleftrightzero no-margin-bottom paddingtopbottom10">
						<label  class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Payment Date</label>
						<div class="col-sm-9 marginleftrightzero paddingleftrightzero">
							<label  class="col-sm-12 control-label marginleftrightzero paddingleftrightzero bold">
								<?php $pay_date = strtotime($paymentData['AcrInvoicePaymentDetail']['payment_date']);$payment_date = date($date_format,$pay_date);?>
								<?php echo $payment_date;?></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero borderline">
					<div class="form-group marginleftrightzero no-margin-bottom paddingtopbottom10">
						<label  class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Payment Reference</label>
						<div class="col-sm-9 marginleftrightzero paddingleftrightzero">
							<label  class="col-sm-12 control-label marginleftrightzero paddingleftrightzero bold"><?php echo $paymentData['AcrInvoicePaymentDetail']['reference_no'];?></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero borderline">
					<div class="form-group marginleftrightzero no-margin-bottom paddingtopbottom10">
						<label  class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Notes</label>
						<div class="col-sm-9 marginleftrightzero paddingleftrightzero">
							<label  class="col-sm-12 control-label marginleftrightzero paddingleftrightzero bold"><?php echo $paymentData['AcrInvoicePaymentDetail']['notes'];?></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero borderline">
					<div class="form-group marginleftrightzero no-margin-bottom paddingtopbottom10">
						<label  class="col-sm-3 control-label marginleftrightzero paddingleftrightzero">Payment Status</label>
						<div class="col-sm-9 marginleftrightzero paddingleftrightzero">
							<label  class="col-sm-12 control-label marginleftrightzero paddingleftrightzero bold due"><?php echo $paymentData['AcrClientInvoice']['status'];?></label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row marginleftrightzero paddingtop25 left width-100">
		<div class="row marginleftrightzero additionalinfo">
			<h5 class="no-border-bottom">Payments History</h5>
		</div>
	</div>
	<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
		<thead>
			<tr>
				<th class="width200">Invoice No</th>
				<th class="width200">Date</th>
				<th class="width200">Payment Method</th>
				<th class="width200">Payment Reference</th>
				<th class="width200">Payment Status</th>
				<th class="width150">Payment Amount</th>
			</tr>
		</thead>
		<tbody>			
			<?php foreach($payment_history as $k=>$val){ ?>		
			<tr>
				<td><span class="on-load"><?php echo $val['AcrClientInvoice']['invoice_number']; ?></span></td>
				<td><span class="on-load">
					<?php $pay_date = strtotime($val['AcrInvoicePaymentDetail']['payment_date']);$payment_date = date($date_format,$pay_date);?>
					<?php echo $payment_date; ?></span></td>
				<td><span class="on-load"><?php echo $val['CpnPaymentMethod']['payment_option_name']; ?></span></td>
				<td><span class="on-load"><?php echo $val['AcrInvoicePaymentDetail']['reference_no']; ?></span></td>
				<td><span class="on-load statusconverttoinvoice">Completed</span></td>
				<td class="textright"><span class="on-load ">
					<?php $options = array('places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
					<?php echo $this->Number->currency($val['AcrInvoicePaymentDetail']['paid_amount'],$val['AcrClientInvoice']['invoice_currency_code']);?>
				</span></td>
			</tr>
			<?php } ?>			
		</tbody>
	</table>
</div>
<!-- /.page-content -->
