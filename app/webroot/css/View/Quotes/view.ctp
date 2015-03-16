<?php $homeLink = $this -> Breadcrumb -> getLink('Home'); ?>
<?php $this->CurrencySymbol->getAllCurrencies();?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<ul class="breadcrumb">
		<li>
			<?php echo $this -> Html -> link('<i class="icon-home home-icon"></i>Home', "$homeLink", array('escape' => FALSE,'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false)))); ?>
		</li>
		<li>
			<?php echo $this -> Html -> link('Quotes', array('action' => 'index')); ?>
		</li>
		<li class="active">
			View Quotes
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 class="viewquote"> View Quotes <span class="header-span"> <i class="icon-double-angle-right"></i> <?php echo $quote['AcrClient']['client_name'];?> </span></h1>
		<div class="col-lg-1 paddingleftrightzero width13">
			<label>Status :</label>
			<label  class="bold"><?php echo $quote['SlsQuotation']['status'];?></label>
		</div>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this -> Js -> link('<i class="icon-arrow-left icon-on-left"></i> Back', array('action' => 'index', $customer, $min, $max, $status, $from, $to, 'page:'.$page), array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right addbutton','update'=>'#pageContent')); ?>
		</div>

	</div>
	<!-- /.page-header -->

	<div class="row paddingleftrightzero marginleftrightzero paddingbottom20 borderbottom">
		<div class="col-lg-6 paddingleftrightzero marginleftrightzero paddingtop15">
			<div class="row paddingleftrightzero marginleftrightzero ">
				<?php if(!empty($settings['SbsSubscriberSetting']['invoice_logo'])) {?>
				<img src="<?php echo $settings['SbsSubscriberSetting']['invoice_logo'];?>" alt="Logo"/>
				
				<?php } else { ?>
					<?php echo $this->Html->image('logo.png',array('alt'=>'Cantorix Logo'));?>
				<?php }?>
			</div>
		</div>
		<div class="col-lg-6 paddingleftrightzero marginleftrightzero ">
			<div class="row paddingleftrightzero marginleftrightzero ">
				<div class="Quoteid">
					<div>
						QUOTE
					</div>
					<div>
						<label>Quote#</label>
						<label class="bold"><?php echo $quote['SlsQuotation']['quotation_no'];?></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero paddingbottom20 ">
		<div class="col-lg-6 paddingleftrightzero marginleftrightzero paddingtop15">
			<div class="row paddingleftrightzero marginleftrightzero ">
				<div class="divfrom">
					<span class="bold">From:</span>
					<span class="font18 bluetext"><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['organization_name'];?></span>
					<?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'])):?>
					<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line1'];?></span>
					<?php endif;?>
                    <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'])):?>
					<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_address_line2'];?></span>
					<?php endif;?>
                    <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'])):?>
					<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_city'];?></span>
					<?php endif;?>
                    <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'])):?>
					<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_state'];?></span>
					<?php endif;?>
                    <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'])):?>
					<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_country'];?></span>
					<?php endif;?>
                    <?php if(!empty($organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'])):?>
					<span><?php echo $organisationDetails['SbsSubscriberOrganizationDetail']['billing_zip'];?></span>
					<?php endif;?>
				</div>
			</div>
		</div>
		<div class="col-lg-6 paddingleftrightzero marginleftrightzero ">
			<div class="row paddingleftrightzero marginleftrightzero paddingtop15">
				<div class="divquote">
					<span class="bold">Quoted To:</span>
					<span class="font18 bluetext"><?php echo $quote['AcrClient']['client_name'];?></span>
					<?php if(!empty($quote['AcrClient']['billing_address_line1'])):?>
					<span><?php echo $quote['AcrClient']['billing_address_line1'];?></span>
					<?php endif;?>
					<?php if(!empty($quote['AcrClient']['billing_address_line2'])):?>
					<span><?php echo $quote['AcrClient']['billing_address_line2'];?></span>
					<?php endif;?>
					<?php if(!empty($quote['AcrClient']['billing_city'])):?>
					<span><?php echo $quote['AcrClient']['billing_city'];?></span>
					<?php endif;?>
					<?php if(!empty($quote['AcrClient']['billing_state'])):?>
					<span><?php echo $quote['AcrClient']['billing_state'];?></span>
					<?php endif;?>
					<?php if(!empty($quote['AcrClient']['billing_country'])):?>
					<span><?php echo $quote['AcrClient']['billing_country'];?></span>
					<?php endif;?>
					<?php if(!empty($quote['AcrClient']['billing_zip'])):?>
					<span><?php echo $quote['AcrClient']['billing_zip'];?></span>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero margintop20 paddingbottom20">
		<div class="paddingleftrightzero marginleftrightzero">
			<div class="expiryheader colorblack">
				<div class="date-row">
					Date
				</div>
				<div class="expirydate">
					Expiry Date
				</div>
				<div class="po">
					PO #
				</div>
			</div>
			<div class="expiryrow">
				<div class="date-row">
					<?php echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['issue_date']));?>
				</div>
				<div class="expirydate">
					<?php if(!empty($quote['SlsQuotation']['expiry_date'])) {echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['expiry_date']));} else { echo '--';}?>
				</div>
				<div class="po">
					<?php echo $quote['SlsQuotation']['purchase_order_no'];?>
				</div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero margintop20">
		<div class="paddingleftrightzero marginleftrightzero item-description-table">
			<div class="expiryheader">
				<div class="itemdesc">
					Item
				</div>
				<div class="qty textcenter">
					Qty
				</div>
				<div class="price textright pricefix">
					Unit Price
				</div>
				<div class="discound discountfix">
					Discount %
				</div>
				<div class="amount textright">
					Amount
				</div>
			</div>
			<?php foreach($quoteProducts as $quoteProduct):?>
			<div class="expiryrow borderbottom">
				<div class="itemdesc">
					<?php if(empty($quoteProduct['InvInventory']['name'])) echo 'Non Inventory Item'; else echo $quoteProduct['InvInventory']['name'];?>
				</div>
				<div class="qty textcenter">
					<span class=""><?php echo $quoteProduct['SlsQuotationProduct']['quantity'];?></span>
					<span class="box"> [1] </span>
				</div>
				<div class="price textright pricefix">
					<?php echo $this->Number->currency($quoteProduct['SlsQuotationProduct']['unit_rate'],$defaultCurrencyInfo['CpnCurrency']['code']);?>
				</div>
				<div class="discound discountfix">
					<?php if(!empty($quoteProduct['SlsQuotationProduct']['discount_percent'])) {echo $quoteProduct['SlsQuotationProduct']['discount_percent'].'%';} else { echo '0%';};?>
				</div>
				<div class="amount textright">
					<?php echo $this->Number->currency($quoteProduct['SlsQuotationProduct']['line_total'],$defaultCurrencyInfo['CpnCurrency']['code']);?>
				</div>
			</div>
			<?php endforeach;?>
		</div>
	</div>
	<div class="row marginleftrightzero paddingbottom20">
		<div class="col-sm-4 no-padding-right no-padding-left subtotal pull-right">
			<div class="row marginleftrightzero borderon">
				<div class="row marginleftrightzero">
					<span class="left bold">Subtotal</span>
					<span class="right bold"><?php echo $this->Number->currency($quote['SlsQuotation']['sub_total'],$defaultCurrencyInfo['CpnCurrency']['code']);?></span>
				</div>
				<?php foreach($taxCalcuations as $tax):?>
				<div class="row marginleftrightzero ">
					<span class="left"><?php echo $tax['taxName'];?></span>
					<span class="right"><?php echo $this->Number->currency($tax['taxAmount'],$defaultCurrencyInfo['CpnCurrency']['code']);?></span>
				</div>
				<?php endforeach;?>
			</div>
			<div class="row marginleftrightzero borderon">
				<div class="row marginleftrightzero">
					<span class="left bold">Total</span>
				</div>
				<div class="row marginleftrightzero">
					<span class="left">In Quotation Currency</span>
					<span class="right"><?php echo $this->Number->currency($quote['SlsQuotation']['invoice_amount'],$quote['SlsQuotation']['invoice_currency_code']);?></span>
				</div>
			</div>
			<div class="row marginleftrightzero ">
				<div class="row marginleftrightzero">
					<span class="left bold">Total</span>
				</div>
				<div class="row marginleftrightzero">
					<span class="left">In Subscriber Currency</span>
					<span class="right"><?php echo $this->Number->currency($quote['SlsQuotation']['func_estimate_total'],$defaultCurrencyInfo['CpnCurrency']['code']);?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="row marginleftrightzero paddingbottom10 borderbottom"></div>
	<div class="row marginleftrightzero  paddingtop15">
		<div class="row marginleftrightzero additionalinfo">
			<h5 class="no-border-bottom">Terms and Conditions</h5>
		</div>
	</div>
	<div class="row marginleftrightzero">
		<div class="row marginleftrightzero additionalinfo ">
			<p class="termsandconditions">
				<?php if(!empty($quote['SlsQuotation']['term_conditions'])) echo $quote['SlsQuotation']['term_conditions']; else echo 'NA';?>
			</p>
		</div>
	</div>
	<?php if(!empty($quote['SlsQuotation']['notes'])):?>
	<div class="row marginleftrightzero  paddingtop15">
		<div class="row marginleftrightzero additionalinfo">
			<h5 class="no-border-bottom">Additional Notes</h5>
		</div>
	</div>
	
	<div class="row marginleftrightzero">
		<div class="row marginleftrightzero additionalinfo ">
			<p class="termsandconditions">
				<?php echo $quote['SlsQuotation']['notes'];?>
			</p>
		</div>
	</div>
	<?php endif;?>
	<?php if(!empty($customFields)):?>
	<div class="row marginleftrightzero paddingbottom20">
		<div class="row marginleftrightzero additionalinfo paddingbottom10">
			<h5>Additional Information</h5>
		</div>
		<div class="row marginleftrightzero">
			<?php foreach($customFields as $customFieldID => $customField):?>
			<div class="form-group marginleftrightzero paddingtop15">
				<label  class="col-sm-2 control-label marginleftrightzero paddingleftrightzero"><?php echo $customField;?></label>
				<div class="col-sm-4 marginleftrightzero paddingleftrightzero">
					<?php if($customValues[$customFieldID]) echo $customValues[$customFieldID]; else echo 'NA';?>
				</div>
			</div>
			<?php endforeach;?>
		</div>
	</div>
	<?php endif;?>
</div>
<!-- /.page-content -->
<?php echo $this->Js->writeBuffer();?>