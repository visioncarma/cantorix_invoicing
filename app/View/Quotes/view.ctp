<?php $homeLink = $this -> Breadcrumb -> getLink('Home'); ?>
<?php $this->CurrencySymbol->getAllCurrencies();?>
<?php
	if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
	  $protocol_final = 'https';
	}else{
	  $protocol_final = 'http';
	}
	$http_hostname = $_SERVER['SERVER_NAME'];
	$webroot_name = $this->webroot;
	$imgLink = "$protocol_final".'://'."$http_hostname/";
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
		<div class="col-lg-2 col-sm-2 col-xs-4 margintop5 paddingleftrightzero textright pull-left">
			<label>Status :</label>
			<label  class="bold"><?php echo $quote['SlsQuotation']['status'];?></label>
		</div>
		<div class="col-lg-1 paddingleftrightzero pull-right">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i> Back', array('action' => 'index', $customer, $min, $max, $status, '?'=>array('from'=>$from, 'to'=>$to), 'page:'.$page), array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right addbutton')); ?>
		</div>

	</div>
	<!-- /.page-header -->

	<div class="paddingbottom20 borderbottom clearfix">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 quote_extra_padding0">
			<div class="row paddingleftrightzero marginleftrightzero viewlogosize">
				 <?php if(!empty($settings['SbsSubscriberSetting']['invoice_logo'])) { ?>
                  		<img src="<?php echo $imgLink.$settings['SbsSubscriberSetting']['invoice_logo'];?>" alt="Logo"/>
                  <?php } else { ?>
                  		<img src="<?php echo $imgLink.$webroot_name.'/img/logo.png';?>" alt="Cantorix Logo"/>	
                  <?php }?>
                  <?php if(!empty($settings['SbsSubscriberSetting']['text_logo'])) {
                  	echo '<div>'.$settings['SbsSubscriberSetting']['text_logo'].'</div>';
                  }?>
			</div>
		</div>
		<div class="col-lg-4 ccol-md-6 col-sm-6 col-xs-12 quote_no quote_extra_padding pull-right">
			<div class="row paddingleftrightzero marginleftrightzero align-right mobiletext-center">
				<div class="Quoteid quoteview">
					<div class="mB10">
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
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingleftrightzero marginleftrightzero paddingtop15">
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
		<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 paddingleftrightzero marginleftrightzero pull-right">
			<div class="row paddingleftrightzero marginleftrightzero paddingtop15">
				<div class="divquote mobile_floatn">
					<span class="bold textright">Quoted To:</span>
					<span class="font18 bluetext textright"><?php echo $quote['AcrClient']['client_name'];?></span>
					<?php if(!empty($quote['AcrClient']['billing_address_line1'])):?>
					<span class="textright"><?php echo $quote['AcrClient']['billing_address_line1'];?></span>
					<?php endif;?>
					<?php if(!empty($quote['AcrClient']['billing_address_line2'])):?>
					<span class="textright"><?php echo $quote['AcrClient']['billing_address_line2'];?></span>
					<?php endif;?>
					<?php if(!empty($quote['AcrClient']['billing_city'])):?>
					<span class="textright"><?php echo $quote['AcrClient']['billing_city'];?></span>
					<?php endif;?>
					<?php if(!empty($quote['AcrClient']['billing_state'])):?>
					<span class="textright"><?php echo $quote['AcrClient']['billing_state'];?></span>
					<?php endif;?>
					<?php if(!empty($quote['AcrClient']['billing_country'])):?>
					<span class="textright"><?php echo $quote['AcrClient']['billing_country'];?></span>
					<?php endif;?>
					<?php if(!empty($quote['AcrClient']['billing_zip'])):?>
					<span class="textright"><?php echo $quote['AcrClient']['billing_zip'];?></span>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero margintop20 paddingbottom20 new_table_responsive">
		<div class="paddingleftrightzero marginleftrightzero">
			<div class="expiryheader colorblack">
				<div class="date-row">
					Date
				</div>
				<div class="expirydate">
					Expiry Date
				</div>
				<div class="po textcenter">
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
				<div class="po textcenter">
					<?php echo $quote['SlsQuotation']['purchase_order_no'];?>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="table-small-view new_table_small_view new_table_small_view_new view_responsive margintop15">
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"> Date </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['issue_date']));?>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"> Expiry Date </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php if(!empty($quote['SlsQuotation']['expiry_date'])) {echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($quote['SlsQuotation']['expiry_date']));} else { echo '--';}?>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"> PO # </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo $quote['SlsQuotation']['purchase_order_no'];?>
			    </div>
			</div>
		</div>
	</div>
	
	
	<div class="row paddingleftrightzero marginleftrightzero margintop20 new_table_responsive">
		<div class="paddingleftrightzero marginleftrightzero item-description-table">
			<div class="expiryheader">
				<div class="itemdesc newitemdesc">
					Item
				</div>
				<div class="newdescription">
					Description
				</div>
				<div class="qty newqty text-right">
					Qty
				</div>
				<div class="price newprice text-right">
					Unit Price
				</div>
				<div class="discound text-right newdiscound">
					Discount %
				</div>
				<div class="amount text-right newamount">
					Amount
				</div>
			</div>
			<?php foreach($quoteProducts as $quoteProduct):?>
			<div class="expiryrow borderbottom">
				<div class="itemdesc newitemdesc">
					<?php if(empty($quoteProduct['InvInventory']['name'])) echo "&nbsp;"; else echo $quoteProduct['InvInventory']['name'];?>
				</div>
				<div class="newdescription">
					<?php if(!empty($quoteProduct['SlsQuotationProduct']['inventory_description'])) echo $quoteProduct['SlsQuotationProduct']['inventory_description']; else echo "&nbsp;";?>
				</div>
				<div class="qty newqty text-right">
					<span class=""><?php echo $quoteProduct['SlsQuotationProduct']['quantity'];?></span>
					<span class="box"><?php /*echo $unitTypeList[$quoteProduct['InvInventory']['inv_inventory_unit_type_id']];*/?></span>
				</div>
				<div class="price newprice text-right">
					<?php echo $this->Number->currency($quoteProduct['SlsQuotationProduct']['unit_rate'],'');?>
				</div>
				<div class="discound text-right newdiscound">
					<?php if(!empty($quoteProduct['SlsQuotationProduct']['discount_percent'])) {echo $quoteProduct['SlsQuotationProduct']['discount_percent'].'%';} else { echo '0%';};?>
				</div>
				<div class="amount text-right newamount">
					<?php echo $this->Number->currency($quoteProduct['SlsQuotationProduct']['line_total'],'');?>
				</div>
			</div>
			<?php endforeach;?>
		</div>
	</div>
	
	<!-- only for mobile -->
	<?php foreach($quoteProducts as $quoteProduct):?>
			<div class="table-small-view new_table_small_view new_table_small_view_new view_responsive margintop15">
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Item');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<?php if(empty($quoteProduct['InvInventory']['name'])) echo "&nbsp;"; else echo $quoteProduct['InvInventory']['name'];?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Description');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<?php if(!empty($quoteProduct['SlsQuotationProduct']['inventory_description'])) echo $quoteProduct['SlsQuotationProduct']['inventory_description']; else echo "&nbsp;";?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"><?php echo __('Qty');?></div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<span class=""><?php echo $quoteProduct['SlsQuotationProduct']['quantity'];?></span>
							<span class="box"><?php /*echo $unitTypeList[$quoteProduct['InvInventory']['inv_inventory_unit_type_id']];*/?></span>
						</div>
						
						
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Unit Price #');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero ">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php echo $this->Number->currency($quoteProduct['SlsQuotationProduct']['unit_rate'],'');?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Discount %');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero ">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php if(!empty($quoteProduct['SlsQuotationProduct']['discount_percent'])) {echo $quoteProduct['SlsQuotationProduct']['discount_percent'].'%';} else { echo '0%';};?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Amount');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero ">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php echo $this->Number->currency($quoteProduct['SlsQuotationProduct']['line_total'],'');?>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<?php endforeach;?>
		  <!-- end only for mobile -->
	
	
	<div class="row marginleftrightzero paddingbottom20 credit_note_style">
		<div class="col-sm-5 col-xs-12 no-padding-right no-padding-left subtotal pull-right view_quote_subtota ">
			<div class="row marginleftrightzero borderon quoteView paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left bold">Subtotal</span>
					<span class="right bold"><?php echo $this->Number->currency($quote['SlsQuotation']['sub_total'],$defaultCurrencyInfo['CpnCurrency']['code']);?></span>
				</div>
				<?php foreach($taxCalcuations as $tax):?>
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left"><?php echo $tax['taxName'];?></span>
					<span class="right"><?php echo $this->Number->currency($tax['taxAmount'],$defaultCurrencyInfo['CpnCurrency']['code']);?></span>
				</div>
				<?php endforeach;?>
			</div>
			<div class="row marginleftrightzero borderon quoteView paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left bold">Total</span>
				</div>
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left">In Quotation Currency</span>
					<span class="right"><?php echo $this->Number->currency($quote['SlsQuotation']['invoice_amount'],$quote['SlsQuotation']['invoice_currency_code']);?></span>
				</div>
			</div>
			<div class="row marginleftrightzero quoteView paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left bold">Total</span>
				</div>
				<div class="row marginleftrightzero padding_left_zero_subtotal">
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
	<?php if(!empty($customFields)):?>
	<div class="row marginleftrightzero paddingbottom20">
		<div class="row marginleftrightzero additionalinfo paddingbottom10">
			<h5>Additional Information</h5>
		</div>
		<div class="row marginleftrightzero">
			<?php foreach($customFields as $customFieldID => $customField):?>
			<div class="form-group marginleftrightzero paddingtop15">
				<label  class="col-md-5 col-sm-6 control-label marginleftrightzero paddingleftrightzero"><?php echo $customField;?></label>
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