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
		<div class="col-lg-2 col-sm-2 col-xs-4 paddingleftrightzero ">
			<label><?php echo __('Status :');?></label>
			<label  class="bold"><?php echo __($invoiceData['AcrClientInvoice']['status']);?></label>
		</div>
		<div class="col-lg-1 paddingleftrightzero">
			<?php echo $this -> Html -> link('<i class="icon-arrow-left icon-on-left"></i>Back', array('action' => 'index',$filterAction,$filterValue,$filterValue1,$filterValue2,$isRecurring,$status,$fromDate,$toDate,$page), array('class' => 'btn btn-sm btn-success pull-right addbutton', 'escape' => FALSE)); ?>
		</div>

	</div>
	<!-- /.page-header -->

	<div class="row paddingleftrightzero marginleftrightzero paddingbottom20 borderbottom">
		<div class="col-lg-6 col-xs-12 col-md-6 col-sm-6 paddingleftrightzero marginleftrightzero paddingtop15">
			<div class="row paddingleftrightzero marginleftrightzero mobiletext-center">
				<?php echo $this->Html->image('logo.png',array('alt'=>'logo'))?>
			</div>
		</div>
		<div class="col-lg-6 col-xs-12 col-md-6 col-sm-6 paddingleftrightzero marginleftrightzero ">
			<div class="row paddingleftrightzero marginleftrightzero text-right mobiletext-center">
				<div class="Quoteid viewInvoice viewrecurring">
					<div>
						<?php echo __('RECURRING INVOICE');?>
					</div>
					<div>
						<label class="invoiceLabel"><?php echo __('Invoice Number');?></label>
						<label class="bold"><?php echo $invoiceData['AcrClientInvoice']['invoice_number'];?></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero paddingbottom20 ">
		<div class="col-lg-6 col-xs-12 col-md-6 col-sm-6 paddingleftrightzero marginleftrightzero paddingtop15">
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
		<div class="col-lg-6 col-xs-12 col-md-6 col-sm-6 paddingleftrightzero marginleftrightzero ">
			<div class="row paddingleftrightzero marginleftrightzero paddingtop15">
				<div class="divquote mobile_floatn">
					<span class="bold text-right"><?php echo __('Invoice To:');?></span>
					<span class="font18 colorblueText text-right"><?php echo $invoiceData['AcrClient']['client_name']?></span>
					<span class="text-right"><?php echo $invoiceData['AcrClient']['organization_name']?></span>
					<span class="text-right"><?php echo $invoiceData['AcrClient']['billing_address_line1']?></span>
					<span class="text-right"><?php echo $invoiceData['AcrClient']['billing_address_line2']?></span>
					<span class="text-right"><?php echo $invoiceData['AcrClient']['billing_city']?></span>
					<span class="text-right"><?php echo $invoiceData['AcrClient']['billing_state']?></span>
					<span class="text-right"><?php echo $invoiceData['AcrClient']['billing_country']?></span>
					<span class="text-right"><?php echo $invoiceData['AcrClient']['billing_zip']?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero margintop20 paddingbottom20 new_table_responsive">
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
					<div class="frequencywidth"><?php echo $acrClientRecurringInvoice['AcrClientRecurringInvoice']['billing_frequency'];?></div>
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
	
	<!-- only for mobile -->
	<div class="table-small-view new_table_small_view new_table_small_view_new view_responsive margintop15 new_table_responsive">
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"> <?php echo __('Next Invoice Date');?> </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo date($dateFormat,strtotime($acrClientRecurringInvoice['AcrClientRecurringInvoice']['next_invoice_date']));?>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"> <?php echo __('Last Invoice Date');?></div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo date($dateFormat,strtotime($acrClientRecurringInvoice['AcrClientRecurringInvoice']['last_invoice_date']));?>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"> <?php echo __('Recurring Period');?> </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo $acrClientRecurringInvoice['AcrClientRecurringInvoice']['billing_period'];?>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"><?php echo __('Frequency');?> </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo $acrClientRecurringInvoice['AcrClientRecurringInvoice']['billing_frequency'];?>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"><?php echo __('Start Date');?> </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo date($dateFormat,strtotime($acrClientRecurringInvoice['AcrClientRecurringInvoice']['invoice_start_date']));?>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"><?php echo __('End Date');?> </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo date($dateFormat,strtotime($acrClientRecurringInvoice['AcrClientRecurringInvoice']['invoice_end_date']));?>
			    </div>
			</div>
		</div>
	</div>
	<!-- end only for mobile -->
	
	<div class="row paddingleftrightzero marginleftrightzero margintop20 new_table_responsive">
		<div class="paddingleftrightzero marginleftrightzero item-description-table">
			<div class="expiryheader">
				<div class="itemdesc newitemdesc">
					<?php echo __('Item');?>
				</div>
				<div class="newdescription">
					<?php echo __('Description');?>
				</div>
				<div class="qty textcenter newqty">
					<?php echo __('Qty');?>
				</div>
				<div class="price newprice text-right">
					
					<?php echo __('Unit Price');?>
				</div>
				<div class="discound text-right newdiscound">
					<?php echo __('Discount %');?>
				</div>
				<div class="amount text-right newamount">
					<?php echo __('Amount');?>
				</div>
			</div>
			<?php foreach($invoiceDetail as $key=>$invoicedetailValue):?>
				<div class="expiryrow borderbottom">
					<div class="itemdesc newitemdesc">
						<?php if($invoicedetailValue['InvInventory']['name']){
							echo $invoicedetailValue['InvInventory']['name'];
						}else{
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						}
						?>
					</div>
					<div class="newdescription">
						<?php 
						if($invoicedetailValue['AcrInvoiceDetail']['inventory_description']){
							echo $invoicedetailValue['AcrInvoiceDetail']['inventory_description'];
						}else{
							echo "---";
						}
						 ?>
					</div>
					<div class="qty textcenter newqty">
						<div class="qtywidth"><?php if($invoicedetailValue['AcrInvoiceDetail']['quantity']){
							echo $invoicedetailValue['AcrInvoiceDetail']['quantity'];
						}else{
							echo "---";
						}
						?></div>
					</div>
					<div class="price newprice text-right">
							<?php echo $this->Number->currency($invoicedetailValue['AcrInvoiceDetail']['unit_rate'],'',$options);?>
				
					</div>
					<div class="discound text-right newdiscound">
						<?php if($invoicedetailValue['AcrInvoiceDetail']['discount_percent']){echo $invoicedetailValue['AcrInvoiceDetail']['discount_percent'];}else{echo "--";}?>
					</div>
					<div class="amount text-right newamount">
						<?php echo $this->Number->format($invoicedetailValue['AcrInvoiceDetail']['line_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?>
					</div>
				</div>
			<?php endforeach;?>
		</div>
	</div>
	
	<!-- only for mobile -->
	<?php foreach($invoiceDetail as $key=>$invoicedetailValue):?>
			<div class="table-small-view new_table_small_view new_table_small_view_new view_responsive margintop15">
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Item');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<?php if($invoicedetailValue['InvInventory']['name']){
									echo $invoicedetailValue['InvInventory']['name'];
								}else{
									echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
								}
							?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Description');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<?php 
								if($invoicedetailValue['AcrInvoiceDetail']['inventory_description']){
									echo $invoicedetailValue['AcrInvoiceDetail']['inventory_description'];
								}else{
									echo "---";
								}
							 ?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"><?php echo __('Qty');?></div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<?php if($invoicedetailValue['AcrInvoiceDetail']['quantity']){
									echo $invoicedetailValue['AcrInvoiceDetail']['quantity'];
								}else{
									echo "---";
								}
							?>
						</div>
						
						
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Unit Price #');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php echo $this->Number->currency($invoicedetailValue['AcrInvoiceDetail']['unit_rate'],'',$options);?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Discount %');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php if($invoicedetailValue['AcrInvoiceDetail']['discount_percent']){echo $invoicedetailValue['AcrInvoiceDetail']['discount_percent'];}else{echo "--";}?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Amount');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php echo $this->Number->format($invoicedetailValue['AcrInvoiceDetail']['line_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<?php endforeach;?>
		  <!-- end only for mobile -->
	
	
	<div class="row marginleftrightzero paddingbottom20 credit_note_style">
		<div class="col-sm-5 col-xs-12  no-padding-right no-padding-left subtotal pull-right view_quote_subtotal">
			<div class="row marginleftrightzero borderon quoteView paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
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
			<div class="row marginleftrightzero borderon quoteView paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left bold"><?php echo __('Total');?></span>
				</div>
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left"><?php echo __('In Invoice Currency');?></span>
					<span class="right statusopn bold"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$invoiceData['AcrClientInvoice']['invoice_currency_code'],$options);?></span>
				</div>
			</div>

			<div class="row marginleftrightzero quoteView paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left bold"><?php echo __('Total');?></span>
				</div>
				<div class="row marginleftrightzero padding_left_zero_subtotal">
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
					<div class="row marginleftrightzero paddingtop15">
						<label  class="col-sm-3 col-md-3 control-label marginleftrightzero paddingleftrightzero"><?php echo $fieldVal;?></label>
						<div class="col-sm-9 col-md-9 marginleftrightzero paddingleftrightzero">
							<?php echo $getCustomFieldsVal[$fieldId];?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
</div>

<!-- inline scripts related to this page -->
