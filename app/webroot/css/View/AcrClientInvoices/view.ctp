<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
        <li>								
			<?php echo $this->Html->link('Invoices', array('controller' => 'acr_client_invoices', 'action' => 'index'), array('div' => false,'escape' => false)); ?>
		</li>
		<li class="active"><?php echo __('View Invoice');?></li>
	</ul>
</div>

<div class="page-content">
	<div class="page-header">
		<h1 class="viewquote"> <?php echo __('View Invoice');?> <span class="header-span"> <i class="icon-double-angle-right"></i> <?php echo __($invoiceData['AcrClient']['organization_name']);?></span></h1>
		<div class="col-lg-1 paddingleftrightzero width13">
			<label><?php echo __('Status :');?></label>
			<label  class="bold"><?php echo __($invoiceData['AcrClientInvoice']['status']);?></label>
		</div>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index'),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
		</div>

	</div>
	<!-- /.page-header -->

	<div class="row paddingleftrightzero marginleftrightzero paddingbottom20 borderbottom">
		<div class="col-lg-6 paddingleftrightzero marginleftrightzero paddingtop15">
			<div class="row paddingleftrightzero marginleftrightzero ">
				<?php echo $this->Html->image('logo.png',array('alt'=>'Logo'));?>
			</div>
		</div>
		
				
		
		<div class="col-lg-6 paddingleftrightzero marginleftrightzero ">
		<?php if(($available)):?>
		    <div class="row paddingleftrightzero marginleftrightzero marginnewclickhere bold">
					<?php echo ' A credit of <span class="bold bluetext">'.$this->Number->currency($available,$subscriberCurrencyCode,$options).'</span> is available';?>
					<?php echo $this->Js->link('Click Here',array('controller'=>'AcrClientInvoices','action'=>'availCredit',$invoiceData['AcrClientInvoice']['id'],$available),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new pull-right marginleft10p','update'=>'#pageContent','confirm'=>'Are you sure that you want to use credit of '.$this->Number->currency($available,$subscriberCurrencyCode,$options).' ?'));?>
				</div>
			<?php endif;?>
			<div class="row paddingleftrightzero marginleftrightzero ">
				<div class="Quoteid">
					<div>
						<?php echo __('INVOICE');?>
					</div>
					<div>
						<label class="invoiceLabel"><?php echo __('Inv#');?></label>
						<label class="bold"><?php echo $invoiceData['AcrClientInvoice']['invoice_number'];?></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero paddingbottom20 ">
		<div class="col-lg-6 paddingleftrightzero marginleftrightzero paddingtop15">
			<div class="row paddingleftrightzero marginleftrightzero ">
				<div class="divfrom">
					<span class="bold"><?php echo __('From:');?></span>
					<span class="font18 colorblueText"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></span>
					<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1']){ ?>
						<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></span>
					<?php } ?>
					<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2']){ ?>
						<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></span>
					<?php } ?>
					<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city']){ ?>
						<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></span>
					<?php } ?>
					<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state']){ ?>
						<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></span>
					<?php } ?>
					<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country']){ ?>
						<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></span>
					<?php } ?>
					<?php if($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip']){ ?>
						<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></span>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-lg-6 paddingleftrightzero marginleftrightzero ">
			<div class="row paddingleftrightzero marginleftrightzero paddingtop15">
				<div class="divquote">
					<span class="bold"><?php echo __('Invoice To:');?></span>
					<span class="font18 colorblueText"><?php echo $invoiceData['AcrClient']['client_name']?></span>
					<span><?php echo $invoiceData['AcrClient']['organization_name']?></span>
					<span><?php echo $invoiceData['AcrClient']['billing_address_line1']?></span>
					<span><?php echo $invoiceData['AcrClient']['billing_address_line2']?></span>
					<span><?php echo $invoiceData['AcrClient']['billing_city']?></span>
					<span><?php echo $invoiceData['AcrClient']['billing_state']?></span>
					<span><?php echo $invoiceData['AcrClient']['billing_country']?></span>
					<span><?php echo $invoiceData['AcrClient']['billing_zip']?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero margintop20 paddingbottom20">
		<div class="col-lg-12 paddingleftrightzero marginleftrightzero">
			<div class="expiryheader colorblack">
				<div class="po">
					<?php echo __('Date');?>
				</div>
				<div class="po">
					<?php echo __('Terms');?>
				</div>
				<div class="po">
					<?php echo __('Expiry Date');?>
				</div>
				<div class="po">
					<?php echo __('PO #');?>
				</div>
			</div>
			<div class="expiryrow">
				<div class="date-row po">
					<?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date']));?>
				</div>
				<div class="po">
					<?php echo $invoiceData['SbsSubscriberPaymentTerm']['term'];?>
				</div>
				<div class="po">
					<?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date']));?>
				</div>
				<div class="po"><?php echo $invoiceData['AcrClientInvoice']['purchase_order_no'];?></div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero margintop20">
		<div class="col-lg-12 paddingleftrightzero marginleftrightzero item-description-table">
			<div class="expiryheader">
				<div class="itemdesc">
					<?php echo __('Item');?>
				</div>
				<div class="qty textcenter">
					<?php echo __('Qty');?>
				</div>
				<div class="price">
					<?php echo __('Unit Price');?>
				</div>
				<div class="discound">
					<?php echo __('Discount %');?>
				</div>
				<div class="amount textright">
					<?php echo __('Amount');?>
				</div>
			</div>
			<?php foreach($invoiceDetail as $slno =>$detail):?>
				<div class="expiryrow borderbottom">
					<div class="itemdesc">
						<?php echo $detail['InvInventory']['name'];?>
					</div>
					<div class="qty textcenter">
						<?php echo $detail['AcrInvoiceDetail']['quantity'];?>
					</div>
					<div class="price ">
						<?php echo $this->Number->currency($detail['AcrInvoiceDetail']['unit_rate'],$subscriberCurrencyCode,$options);?>
					</div>
					<div class="discound">
						<?php if($detail['AcrInvoiceDetail']['discount_percent']){echo $detail['AcrInvoiceDetail']['discount_percent'];}else{echo "--";}?>
					</div>
					<div class="amount textright">
						<?php echo $detail['AcrInvoiceDetail']['line_total'];?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php $options = array('zero'=>'Nil','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
	<div class="row marginleftrightzero paddingbottom20">
		<div class="col-sm-4 no-padding-right no-padding-left subtotal pull-right">
			<div class="row marginleftrightzero borderon">
				<div class="row marginleftrightzero">
					<span class="left bold"><?php echo __('Subtotal');?></span>
					<span class="right bold"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['sub_total'],$subscriberCurrencyCode,$options);?></span>
				</div>
				<?php foreach($taxArray as $taxCount=>$taxVal):?>
					<div class="row marginleftrightzero ">
						<span class="left"><?php echo $taxVal['taxName'];?></span>
						<span class="right"><?php echo $this->Number->currency($taxVal['taxAmount'],$subscriberCurrencyCode,$options);?></span>
					</div>
				<?php endforeach; ?>
				
			</div>
			<div class="row marginleftrightzero borderon">
				<div class="row marginleftrightzero">
					<span class="left bold"><?php echo __('Total');?></span>
				</div>
				<div class="row marginleftrightzero">
					<span class="left"><?php echo __('In Invoice Currency');?></span>
					<span class="right statusopn bold"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$clientCurrencyCode,$options);?></span>
				</div>
			</div>

			<div class="row marginleftrightzero borderon">
				<div class="row marginleftrightzero">
					<span class="left bold"><?php echo __('Total');?></span>
				</div>
				<div class="row marginleftrightzero">
					<span class="left"><?php echo __('In Subscriber Currency');?></span>
					<span class="right statusopn bold"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['func_currency_total'],$subscriberCurrencyCode,$options);?></span>
				</div>
			</div>

			<div class="row marginleftrightzero borderon">
				<div class="row marginleftrightzero">
					<span class="left"><?php echo __('Payments');?></span>
					<span class="right"><?php echo $this->Number->currency($paidAmount,$clientCurrencyCode,$options);?></span>
				</div>
			</div>

			<div class="row marginleftrightzero borderon">
				<div class="row marginleftrightzero">
					<span class="left bold"><?php echo __('Balance Due');?></span>
				</div>
				<div class="row marginleftrightzero">
					<span class="left"><?php echo __('In Invoice Currency');?></span>
					<span class="right due bold"><?php echo $this->Number->currency($dueAmount,$clientCurrencyCode,$options);?></span>
				</div>
			</div>

			<!--div class="row marginleftrightzero">
				<div class="row marginleftrightzero">
					<span class="left bold">Balance Due</span>
				</div>
				<div class="row marginleftrightzero">
					<span class="left">In Subscriber Currency</span>
					<span class="right due bold">$ 68.99</span>
				</div>
			</div-->

		</div>
	</div>
	<?php if($getPaymentForInvoice):?>
	<div class="row marginleftrightzero  paddingtop15">
		<div class="row marginleftrightzero additionalinfo">
			<h5 class="no-border-bottom"><?php echo __('Payments History');?></h5>
		</div>
	</div>
	<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
		<thead>
			<tr>
				<th class="width200"><?php echo __('Invoice No');?></th>
				<th class="width200"><?php echo __('Payment Date');?></th>
				<th class="width200"><?php echo __('Payment Type');?></th>
				<th class="width200"><?php echo __('Payment Reference');?></th>
				<th class="width200"><?php echo __('Note');?></th>
				<th class="width150"><?php echo __('Payment Amount');?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($getPaymentForInvoice as $key=>$paymentDetail):?>
			<tr>
				<td><span class="on-load"><?php echo $paymentDetail['AcrClientInvoice']['invoice_number']?></span></td>
				<td><span class="on-load"><?php echo date($dateFormat,strtotime($paymentDetail['AcrInvoicePaymentDetail']['payment_date']));?></span></td>
				<td><span class="on-load"><?php echo $paymentDetail['CpnPaymentMethod']['payment_option_name'];?></span></td>
				<td><span class="on-load"><?php echo $paymentDetail['AcrInvoicePaymentDetail']['reference_no'];?></span></td>
				<td><span class="on-load statusconverttoinvoice"><?php echo $paymentDetail['AcrInvoicePaymentDetail']['notes'];?></span></td>
				<td><span class="on-load "><?php echo $this->Number->currency($paymentDetail['AcrInvoicePaymentDetail']['paid_amount'],$clientCurrencyCode,$options);?></span></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<?php endif;?>
	<?php if($getCredit):?>
	<div class="row marginleftrightzero  paddingtop15">
		<div class="row marginleftrightzero additionalinfo">
			<h5 class="no-border-bottom"><?php echo __('Credit Notes');?></h5>
		</div>
	</div>
	<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
		<thead>
			<tr>
				<th class="width200"><?php echo __('Credit Note No');?></th>
				<th class="width200"><?php echo __('Credit Date');?></th>
				<th class="width200"><?php echo __('Credit');?></th>
				<th class="width200"><?php echo __('Invoice Number');?></th>
			</tr>
		</thead>
		<tbody>
		<?php $slNo = 1;?>
		<?php foreach($getCredit as $keyId=>$creditVal): ?>
			<tr>
				<td><span class="on-load"><?php echo $slNo;?></span></td>
				<td><span class="on-load"><?php echo date($dateFormat,strtotime($creditVal['AcrClientCreditnote']['date_created']));?></span></td>
				<td><span class="on-load "><?php echo $this->Number->currency($creditVal['AcrClientCreditnote']['amount'],$subscriberCurrencyCode,$options);?></span></td>
				<td><span class="on-load "><?php echo $invoiceData['AcrClientInvoice']['invoice_number']?></span></td>
			</tr>
		<?php $slNo++;?>
		<?php endforeach;?>
		</tbody>
	</table>
	<?php endif;?>
	<?php if($invoiceData['AcrClientInvoice']['term_conditions']):?>
	<div class="row marginleftrightzero  paddingtop15">
		<div class="row marginleftrightzero additionalinfo">
			<h5 class="no-border-bottom"><?php echo __('Terms and Conditions');?></h5>
		</div>
	</div>
	<div class="row marginleftrightzero">
		<div class="row marginleftrightzero additionalinfo ">
			<p class="termsandconditions">
				<?php echo $invoiceData['AcrClientInvoice']['term_conditions']?>
			</p>
		</div>
	</div>
	<?php endif;?>
	<?php if($invoiceData['AcrClientInvoice']['notes']):?>
	<div class="row marginleftrightzero  paddingtop15">
		<div class="row marginleftrightzero additionalinfo">
			<h5 class="no-border-bottom"><?php echo __('Additional Notes');?></h5>
		</div>
	</div>
	<div class="row marginleftrightzero">
		<div class="row marginleftrightzero additionalinfo ">
			<p class="termsandconditions">
				<?php echo $invoiceData['AcrClientInvoice']['notes']?>
			</p>
		</div>
	</div>
	<?php endif;?>
	<?php if($getCustomFields):?>
		<div class="row marginleftrightzero paddingbottom20">
			<div class="row marginleftrightzero additionalinfo paddingbottom10">
				<h5><?php echo __('Additional Information');?></h5>
			</div>
			<div class="row marginleftrightzero">
				<?php foreach($getCustomFields as $fieldId=>$fieldVal):?>
					<div class="form-group marginleftrightzero paddingtop15">
						<label  class="col-sm-2 control-label marginleftrightzero paddingleftrightzero"><?php echo $fieldVal;?></label>
						<div class="col-sm-4 marginleftrightzero paddingleftrightzero">
							<?php echo $getCustomFieldsVal[$fieldId];?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
</div>
<!-- /.page-content -->
<?php echo $this->Js->writeBuffer();?>