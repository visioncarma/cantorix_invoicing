<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
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
			<?php echo $this -> Html -> link('Recurring Invoices', array('controller' => 'acr_client_recurring_invoices', 'action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$page), array('div' => false, 'escape' => false)); ?>
		</li>
		<li class="active">
			<?php echo __('View Invoice Recurrence Details');?>
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 class="viewquote"> <?php echo __('View Invoice Recurrence Details');?> <span class="header-span"> <i class="icon-double-angle-right"></i> <?php echo $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['organization_name'];?> </span></h1>
		<div class="col-lg-1 paddingleftrightzero width13">
			<label><?php echo __('Status :');?></label>
			<label  class="bold"><?php echo __($invoiceData['AcrClientInvoice']['status']);?></label>
		</div>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i>Back', array('action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$page), array('class' => 'btn btn-sm btn-success pull-right addbutton', 'escape' => FALSE)); ?>
		</div>

	</div>
	<!-- /.page-header -->

	<div class="row paddingleftrightzero marginleftrightzero paddingbottom20 borderbottom">
		<div class="col-lg-6 paddingleftrightzero marginleftrightzero paddingtop15">
			<div class="row paddingleftrightzero marginleftrightzero ">
				<?php echo $this->Html->image('logo.png',array('alt'=>'logo'))?>
			</div>
		</div>
		<div class="col-lg-6 paddingleftrightzero marginleftrightzero ">
			<div class="row paddingleftrightzero marginleftrightzero ">
				<div class="Quoteid">
					<div>
						<?php echo __('RECURRING INVOICE');?>
					</div>
					<div>
						<label><?php echo __('Invoice Number');?></label>
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
					<span class="font18 colorblueText"><?php echo $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['organization_name'];?></span>
					<span><?php echo $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['organization_name'];?></span>
					<span><?php echo $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></span>
					<span><?php echo $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></span>
					<span><?php echo $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_city'];?></span>
					<span><?php echo $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_state'];?></span>
					<span><?php echo $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_country'];?></span>
					<span><?php echo $subscriberOrganisationDetail['SbsSubscriberOrganizationDetail']['billing_zip'];?></span>
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
		<div class="paddingleftrightzero marginleftrightzero">
			<div class="expiryheader colorblack">
				<div class="po width15p">
					<?php echo __('Next Invoice Date');?>
				</div>
				<div class="po width15p">
					<?php echo __('Last Invoice Date');?>
				</div>
				<div class="po width15p">
					<?php echo __('Recurring Period');?>
				</div>
				<div class="po width15p">
					<?php echo __('Frequency');?>
				</div>
				<div class="po width20p">
					<?php echo __('Start Date');?>
				</div>
				<div class="po width20p">
					<?php echo __('End Date');?>
				</div>
			</div>
			<div class="expiryrow">
				<div class="date-row width15p">
					<?php echo date($dateFormat,strtotime($acrClientRecurringInvoice['AcrClientRecurringInvoice']['next_invoice_date']));?>
				</div>
				<div class="expirydate width15p">
					<?php echo date($dateFormat,strtotime($acrClientRecurringInvoice['AcrClientRecurringInvoice']['last_invoice_date']));?>
				</div>
				<div class="expirydate width15p">
					<?php echo $acrClientRecurringInvoice['AcrClientRecurringInvoice']['billing_period'];?>
				</div>
				<div class="expirydate width15p">
					<?php echo $acrClientRecurringInvoice['AcrClientRecurringInvoice']['billing_frequency'];?>
				</div>
				<div class="expirydate width20p">
					<?php echo date($dateFormat,strtotime($acrClientRecurringInvoice['AcrClientRecurringInvoice']['invoice_start_date']));?>
				</div>
				<div class="expirydate width20p">
					<?php echo date($dateFormat,strtotime($acrClientRecurringInvoice['AcrClientRecurringInvoice']['invoice_end_date']));?>
				</div>
				<div class="po"></div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero margintop20">
		<div class="paddingleftrightzero marginleftrightzero item-description-table">
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
			<?php foreach($invoiceDetail as $key=>$invoicedetailValue):?>
				<div class="expiryrow borderbottom">
					<div class="itemdesc">
						<?php echo $invoicedetailValue['InvInventory']['name'];?>
					</div>
					
					<div class="qty textcenter">
						<?php echo $invoicedetailValue['AcrInvoiceDetail']['quantity'];?>
					</div>
					<div class="price">
						<?php $options = array('zero'=>'Free','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
						<?php echo $this->Number->currency($invoicedetailValue['AcrInvoiceDetail']['unit_rate'],$defaultCurrency,$options);?>
					</div>
					<div class="discound">
						<?php echo $invoicedetailValue['AcrInvoiceDetail']['discount_percent'];?>
					</div>
					<div class="amount textright">
						<?php echo $this->Number->currency($invoicedetailValue['AcrInvoiceDetail']['line_total'],$defaultCurrency,$options);?>
					</div>
				</div>
			<?php endforeach;?>
		</div>
	</div>
	<div class="row marginleftrightzero paddingbottom20">
		<div class="col-sm-4 no-padding-right no-padding-left subtotal pull-right">
			<div class="row marginleftrightzero borderon">
				<div class="row marginleftrightzero">
					<span class="left bold"><?php echo __('Subtotal');?></span>
					<span class="right bold"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['sub_total'],$defaultCurrency,$options);?></span>
				</div>
				<?php foreach($taxArray as $taxCount=>$taxVal):?>
					<div class="row marginleftrightzero ">
						<span class="left"><?php echo $taxVal['taxName'];?></span>
						<span class="right"><?php echo $this->Number->currency($taxVal['taxAmount'],$defaultCurrency,$options);?></span>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="row marginleftrightzero borderon">
				<div class="row marginleftrightzero">
					<span class="left bold"><?php echo __('Total');?></span>
				</div>
				<div class="row marginleftrightzero">
					<span class="left"><?php echo __('In Invoice Currency');?></span>
					<span class="right statusopn bold"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code'],$options);?></span>
				</div>
			</div>

			<div class="row marginleftrightzero">
				<div class="row marginleftrightzero">
					<span class="left bold"><?php echo __('Total');?></span>
				</div>
				<div class="row marginleftrightzero">
					<span class="left"><?php echo __('In Subscriber Currency');?></span>
					<span class="right statusopn bold"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['func_currency_total'],$defaultCurrency,$options);?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="row marginleftrightzero paddingbottom10 borderbottom"></div>
	<?php if($invoiceData['AcrClientInvoice']['term_conditions']):?>
	<div class="row marginleftrightzero  paddingtop15">
		<div class="row marginleftrightzero additionalinfo">
			<h5 class="no-border-bottom"><?php echo __('Terms and Conditions');?></h5>
		</div>
	</div>
	<div class="row marginleftrightzero">
		<div class="row marginleftrightzero additionalinfo ">
			<p class="termsandconditions">
				<?php echo $invoiceData['AcrClientInvoice']['term_conditions'];?>
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
				<?php echo $invoiceData['AcrClientInvoice']['notes'];?>
			</p>
		</div>
	</div>
	<?php endif; ?>
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

<!-- inline scripts related to this page -->
