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
		<div class="headernew col-lg-8"> <?php echo __('View Invoice');?> <span class="header-span"> <i class="icon-double-angle-right"></i> <?php echo __($invoiceData['AcrClient']['organization_name']);?></span></div>
		<div class="col-lg-2 paddingleftrightzero">
			<label><?php echo __('Status :');?></label>
			<label  class="bold"><?php echo __($invoiceData['AcrClientInvoice']['status']);?></label>
		</div>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index',$filterAction, $filterValue, $filterValue1, $filterValue2, $isRecurring, $status, $fromDate, $toDate, $page),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
		</div>

	</div>
	<!-- /.page-header -->

	<div class="row paddingleftrightzero marginleftrightzero paddingbottom20 borderbottom">
		<div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 paddingleftrightzero marginleftrightzero paddingtop15">
			<div class="row paddingleftrightzero marginleftrightzero viewlogosize">
				<?php /*echo $this->Html->image('logo.png',array('alt'=>'Logo'));*/?>
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
		
				
		
		<div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 paddingleftrightzero marginleftrightzero ">
		
			<div class="row paddingleftrightzero marginleftrightzero textright mobiletext-center">
				<div class="Quoteid viewInvoice">
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
		<div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 paddingleftrightzero marginleftrightzero paddingtop15">
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
		<div class="col-lg-6 col-xs-12 col-sm-6 col-md-6 paddingleftrightzero marginleftrightzero ">
			<div class="row paddingleftrightzero marginleftrightzero paddingtop15">
				<div class="divquote mobile_floatn">
					<span class="bold textright"><?php echo __('Invoice To:');?></span>
					<span class="font18 colorblueText textright"><?php echo $invoiceData['AcrClient']['client_name']?></span>
					<span class="textright"><?php echo $invoiceData['AcrClient']['organization_name']?></span>
					<span class="textright"><?php echo $invoiceData['AcrClient']['billing_address_line1']?></span>
					<span class="textright"><?php echo $invoiceData['AcrClient']['billing_address_line2']?></span>
					<span class="textright"><?php echo $invoiceData['AcrClient']['billing_city']?></span>
					<span class="textright"><?php echo $invoiceData['AcrClient']['billing_state']?></span>
					<span class="textright"><?php echo $invoiceData['AcrClient']['billing_country']?></span>
					<span class="textright"><?php echo $invoiceData['AcrClient']['billing_zip']?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="row paddingleftrightzero marginleftrightzero margintop20 paddingbottom20 new_table_responsive">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero marginleftrightzero">
			<div class="expiryheader colorblack">
				<div class="po">
					<?php echo __('Date');?>
				</div>
				<div class="po">
					<?php echo __('Terms');?>
				</div>
				<div class="po">
					<?php echo __('Due Date');?>
				</div>
				<div class="po text-center">
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
				<div class="po text-center"><?php echo $invoiceData['AcrClientInvoice']['purchase_order_no'];?></div>
			</div>
		</div>
	</div>
	
	<!-- only for mobile -->
	<div class="table-small-view new_table_small_view new_table_small_view_new view_responsive margintop15 new_table_responsive">
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"> Date </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['invoiced_date']));?>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"> Terms </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo $invoiceData['SbsSubscriberPaymentTerm']['term'];?>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"> Due Date </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo date($dateFormat,strtotime($invoiceData['AcrClientInvoice']['due_date']));?>
			    </div>
			</div>
		</div>
		<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
			<div class="col-xs-5 bold font13"> PO # </div>
			<div class="col-xs-7 font13 mobileClientName nopaddingright">
				<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right"> 
					<?php echo $invoiceData['AcrClientInvoice']['purchase_order_no'];?>
			    </div>
			</div>
		</div>
	</div>
	<!-- end only for mobile -->
	
	 
	
	<div class="row paddingleftrightzero marginleftrightzero margintop20 new_table_responsive">
		<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 paddingleftrightzero marginleftrightzero item-description-table">
			<div class="expiryheader">
				<div class="itemdesc newitemdesc">
					<?php echo __('Item');?>
				</div>
				<div class="newdescription">
					<?php echo __('Description');?>
				</div>
				<div class="qty newqty text-right">
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
			<?php foreach($invoiceDetail as $slno =>$detail):?>
				<div class="expiryrow borderbottom">
					<div class="itemdesc newitemdesc">
						<?php if($detail['InvInventory']['name']){
							echo $detail['InvInventory']['name'];
						}else{
							echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						}
						?>
					</div>
					<div class="newdescription">
						<?php 
						if($detail['AcrInvoiceDetail']['inventory_description']){
							echo $detail['AcrInvoiceDetail']['inventory_description'];
						}else{
							echo "---";
						}
						 ?>
					</div>
					<div class="qty newqty text-right">
						<?php if($detail['AcrInvoiceDetail']['quantity']){
							echo $detail['AcrInvoiceDetail']['quantity'];
						}else{
							echo "---";
						}
						?>
					</div>
					<div class="price newprice text-right">
						<?php echo $this->Number->currency($detail['AcrInvoiceDetail']['unit_rate'],'',$options);?>
					</div>
					<div class="discound text-right newdiscound">
						<?php if($detail['AcrInvoiceDetail']['discount_percent']){echo $detail['AcrInvoiceDetail']['discount_percent'];}else{echo "--";}?>
					</div>
					<div class="amount text-right newamount">
						<?php echo $this->Number->format($detail['AcrInvoiceDetail']['line_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	
	
	<!-- only for mobile -->
	<?php foreach($invoiceDetail as $slno =>$detail):?>
			<div class="table-small-view new_table_small_view new_table_small_view_new view_responsive margintop15">
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Item');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<?php if($detail['InvInventory']['name']){
								echo $detail['InvInventory']['name'];
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
							if($detail['AcrInvoiceDetail']['inventory_description']){
								echo $detail['AcrInvoiceDetail']['inventory_description'];
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
							<?php if($detail['AcrInvoiceDetail']['quantity']){
								echo $detail['AcrInvoiceDetail']['quantity'];
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
								<?php echo $this->Number->currency($detail['AcrInvoiceDetail']['unit_rate'],'',$options);?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Discount %');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php if($detail['AcrInvoiceDetail']['discount_percent']){echo $detail['AcrInvoiceDetail']['discount_percent'];}else{echo "--";}?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Amount');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php echo $this->Number->format($detail['AcrInvoiceDetail']['line_total'],array('places'=>'2','before'=>'','escape'=>false,'decimals'=>'.','thousands'=>','));?>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<?php endforeach;?>
		  <!-- end only for mobile -->
	
	
	<?php $options = array('zero'=>'Nil','places'=>'2','thousands'=>',','decimals'=>'.','wholeSymbol'=> '','wholePosition'=> 'before');?> 
	<div class="row marginleftrightzero paddingbottom20 credit_note_style">
		<div class="col-sm-5 col-xs-12 no-padding-right no-padding-left subtotal pull-right">
			<div class="row marginleftrightzero borderon paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left bold"><?php echo __('Subtotal');?></span>
					<span class="right bold"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['sub_total'], $subscriberCurrencyCode);?></span>
				</div>
				<?php foreach($taxArray as $taxCount=>$taxVal):?>
					<div class="row marginleftrightzero padding_left_zero_subtotal">
						<span class="left"><?php echo $taxVal['taxName'];?></span>
						<span class="right"><?php echo $this->Number->currency($taxVal['taxAmount'],$subscriberCurrencyCode);?></span>
					</div>
				<?php endforeach; ?>
				
			</div>
			<div class="row marginleftrightzero borderon paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left bold"><?php echo __('Total');?></span>
				</div>
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left"><?php echo __('In Invoice Currency');?></span>
					<span class="right statusopn bold"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['invoice_total'],$clientCurrencyCode);?></span>
				</div>
			</div>

			<div class="row marginleftrightzero borderon paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left bold"><?php echo __('Total');?></span>
				</div>
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left"><?php echo __('In Subscriber Currency');?></span>
					<span class="right statusopn bold"><?php echo $this->Number->currency($invoiceData['AcrClientInvoice']['func_currency_total'],$subscriberCurrencyCode);?></span>
				</div>
			</div>

			<div class="row marginleftrightzero borderon paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left"><?php echo __('Payments');?></span>
					<span class="right"><?php echo $this->Number->currency($paidAmount,$clientCurrencyCode);?></span>
				</div>
			</div>

			<div class="row marginleftrightzero borderon paddinglr12 padding-right5">
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left bold"><?php echo __('Balance Due');?></span>
				</div>
				<div class="row marginleftrightzero padding_left_zero_subtotal">
					<span class="left"><?php echo __('In Invoice Currency');?></span>
					<span class="right due bold"><?php echo $this->Number->currency($dueAmount,$clientCurrencyCode);?></span>
				</div>
			</div>
		</div>
	</div>
	<?php if($getPaymentForInvoice):?>
	<div class="row marginleftrightzero  paddingtop15">
		<div class="row marginleftrightzero additionalinfo">
			<h5 class="no-border-bottom"><?php echo __('Payments History');?></h5>
		</div>
	</div>
	<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table view_desktop">
		<thead>
			<tr>
				<th class="width200"><?php echo __('Invoice No');?></th>
				<th class="width200"><?php echo __('Payment Date');?></th>
				<th class="width200"><?php echo __('Payment Type');?></th>
				<th class="width200"><?php echo __('Payment Reference');?></th>
				<th class="width200"><?php echo __('Note');?></th>
				<th class="width150 textright"><?php echo __('Payment Amount');?></th>
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
				<td class="textright"><span class="on-load "><?php echo $this->Number->currency($paymentDetail['AcrInvoicePaymentDetail']['paid_amount'],$clientCurrencyCode);?></span></td>
			</tr>
			<?php $ttotalPaymentRecorded += $paymentDetail['AcrInvoicePaymentDetail']['paid_amount']?>
			<?php endforeach;?>
			
			
			<tr>
				<td><span class="on-load"></span></td>
				<td><span class="on-load"></span></td>
				<td><span class="on-load"></span></td>
				<td><span class="on-load"></span></td>
				<td><span class="on-load bold">Total</span></td>
				<td class="textright"><span class="on-load bold"><?php echo $this->Number->currency($ttotalPaymentRecorded,$clientCurrencyCode);?></span></td>
			</tr>
		</tbody>
	</table>
	
	
	<!--   start table part   -->
			<?php foreach($getPaymentForInvoice as $key=>$paymentDetail):?>
				<div class="table-small-view  new_table_small_view new_table_small_view_new show_inmobile" id = "inventoryUpdateSelect-1">
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Invoice No </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero" id = "td-inventoryUpdateSelect-1">
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero " >
									<?php echo $paymentDetail['AcrClientInvoice']['invoice_number']?>
								</div>
								
							</div>	
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Payment Date </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group marginleftrightzero margin-bottom-zero">
								<?php echo date($dateFormat,strtotime($paymentDetail['AcrInvoicePaymentDetail']['payment_date']));?>
							</div>
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Payment Type </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
								<?php echo $paymentDetail['CpnPaymentMethod']['payment_option_name'];?>
							</div>
							
							
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Payment Reference</div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group marginleftrightzero margin-bottom-zero">
								
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
									<?php echo $paymentDetail['AcrInvoicePaymentDetail']['reference_no'];?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Note </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group marginleftrightzero margin-bottom-zero">
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
									<?php echo $paymentDetail['AcrInvoicePaymentDetail']['notes'];?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13">Payment Amount </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
								
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero ">
									<?php echo $this->Number->currency($paymentDetail['AcrInvoicePaymentDetail']['paid_amount'],$clientCurrencyCode);?>
								</div>
							</div>
						</div>
					</div>
				</div>

		<?php $ttotalPaymentRecorded += $paymentDetail['AcrInvoicePaymentDetail']['paid_amount']?>
		<?php endforeach;?>

		<div class="table-small-view  new_table_small_view new_table_small_view_new show_inmobile" id = "inventoryUpdateSelect-1">
					<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
						<div class="col-xs-5 bold font13"> Total </div>
						<div class="col-xs-7 font13  mobileClientName"> 
							<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero" id = "td-inventoryUpdateSelect-1">
								<div class="col-xs-10 marginleftrightzero paddingleftrightzero " >
									<?php echo $this->Number->currency($ttotalPaymentRecorded,$clientCurrencyCode);?>
								</div>
								
							</div>	
						</div>
					</div>
		</div>  
			
		<!--   End table part   -->
	
	
	
	
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
<!-- /.page-content -->

<script type="text/javascript">
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

		
	});
</script>

<?php echo $this->Js->writeBuffer();?>