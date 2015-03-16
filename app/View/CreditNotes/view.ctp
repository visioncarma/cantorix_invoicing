<?php $homeLink   = $this->Breadcrumb->getLink('Home');?>
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
            <?php echo $this->Html->link('Invoices',array('controller'=>'acr_client_invoices','action'=>'index'));?>
        </li>
        <li>
           <?php echo $this->Html->link('Manage Credits',array('action'=>'index'));?>
        </li>
        <li class="active">
            View Credits Note
        </li>
    </ul>
    <!-- .breadcrumb -->
</div>
<div class="page-content">
    <div class="page-header">
        <div class="headernew col-lg-8 col-md-8 col-sm-4 col-xs-12">
            View Credits Note <span class="header-span"> <i class="icon-double-angle-right"></i><?php echo $creditNote['AcrClientCreditnote']['credit_no'];?></span>
        </div>
        <div class="col-lg-1 col-md-1 col-xs-12 paddingleftrightzero pull-right">
            <?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index', $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter'=>$from, 'toFilter'=>$to), 'page:'.$page),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
        </div>
        <div class="col-lg-2 col-md-1 col-xs-12 paddingleftrightzero  pull-right vewstatus">
            <label  class="bold green_color pull-right"><?php echo $creditNote['AcrClientCreditnote']['status'];?></label>
            <label class="pull-right">Status : &nbsp; </label>
        </div>
    </div>
    <!-- /.page-header -->
    <div class="row paddingleftrightzero marginleftrightzero paddingbottom20 ">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingleftrightzero marginleftrightzero paddingtop15 ">
            <div class="row paddingleftrightzero marginleftrightzero viewcreditNote">
                <div class="row marginleftrightzero">
                    <div class="form-group marginleftrightzero">
                        <div class="col-xs-6 col-sm-6 col-lg-3 col-md-6">
                            Credit No
                        </div>
                        <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                            <span class="bold"><?php echo $creditNote['AcrClientCreditnote']['credit_no'];?></span>
                        </div>
                    </div>
                </div>
                <div class="row marginleftrightzero">
                    <div class="form-group marginleftrightzero">
                        <div class="col-xs-6 col-sm-6 col-lg-3 col-md-6">
                            Credit Date
                        </div>
                        <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                            <span class="bold"><?php echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($creditNote['AcrClientCreditnote']['date_created']));?></span>
                        </div>
                    </div>
                </div>
                <div class="row marginleftrightzero">
                    <div class="form-group marginleftrightzero">
                        <div class="col-xs-6 col-sm-6 col-lg-3 col-md-6">
                            Reference#
                        </div>
                        <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                            <span class="bold"><?php echo $creditNote['AcrClientCreditnote']['reference_no'];?></span>
                        </div>
                    </div>
                </div>
                <div class="row marginleftrightzero">
                    <div class="form-group marginleftrightzero">
                        <div class="col-xs-6 col-sm-6 col-lg-3 col-md-6">
                            Customer Name
                        </div>
                        <div class="col-xs-6 col-sm-6 col-lg-6 col-md-6">
                            <span class="bold"><?php echo $creditNote['AcrClient']['organization_name'];?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 paddingleftrightzero marginleftrightzero ">
            <div class="row paddingleftrightzero marginleftrightzero paddingtop15">
                <div class="divquote mobile_floatn">
                    <span class="bold text-right">Credit Note To:</span>
                    <span class="font18  text-right"><?php echo $creditNote['AcrClient']['client_name'];?></span>
                    <span class="text-right"><?php echo $creditNote['AcrClient']['billing_address_line1'];?></span>
                    <span class="text-right"><?php echo $creditNote['AcrClient']['billing_address_line2'];?></span>
                    <span class="text-right"><?php echo $creditNote['AcrClient']['billing_city'];?></span>
                    <span class="text-right"><?php echo $creditNote['AcrClient']['billing_state'];?></span>
                    <span class="text-right"><?php echo $creditNote['AcrClient']['billing_country'];?></span>
                    <span class="text-right"><?php echo $creditNote['AcrClient']['billing_zip'];?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row paddingleftrightzero marginleftrightzero margintop20 new_table_responsive">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero marginleftrightzero item-description-table">
            <div class="expiryheader">
                <div class="itemdesc">
                    Item Description
                </div>
                <div class="qty text-right">
                    Qty
                </div>
                <div class="price text-right">
                    Unit Price
                </div>
                <div class="discound text-right">
                    Discound %
                </div>
                <div class="amount text-right">
                    Amount
                </div>
            </div>
            <?php foreach($productDetails as $productDetail):?>
            <div class="expiryrow borderbottom">
                <div class="itemdesc">
                    <?php
                        if(empty($productDetail['AcrClientCreditnoteProduct']['inventory_description'])) {
                            echo '&nbsp;';
                        } else {
                            echo $productDetail['AcrClientCreditnoteProduct']['inventory_description'];    
                        }
                    ?>
                </div>
                <div class="qty text-right">
                    <?php echo $productDetail['AcrClientCreditnoteProduct']['quantity'];?>
                </div>
                <div class="price text-right">
                    <?php echo $this->Number->currency($productDetail['AcrClientCreditnoteProduct']['unit_rate'],'');?>
                </div>
                <div class="discound text-right">
                    <?php if(!empty($productDetail['AcrClientCreditnoteProduct']['discount_percent'])) {
                        echo $productDetail['AcrClientCreditnoteProduct']['discount_percent'],'%';
                    } else {
                        echo "&nbsp;";
                    } ?>
                </div>
                <div class="amount text-right">
                    <?php echo $this->Number->currency($productDetail['AcrClientCreditnoteProduct']['line_total'],'');?>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    
    
    <!-- only for mobile -->
	 <?php foreach($productDetails as $productDetail):?>
			<div class="table-small-view new_table_small_view new_table_small_view_new view_responsive margintop15">
				
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Item Description');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<?php
		                        if(empty($productDetail['AcrClientCreditnoteProduct']['inventory_description'])) {
		                            echo '&nbsp;';
		                        } else {
		                            echo $productDetail['AcrClientCreditnoteProduct']['inventory_description'];    
		                        }
		                    ?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"><?php echo __('Qty');?></div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<span class=""> <?php echo $productDetail['AcrClientCreditnoteProduct']['quantity'];?></span>
							<span class="box"><?php /*echo $unitTypeList[$quoteProduct['InvInventory']['inv_inventory_unit_type_id']];*/?></span>
						</div>
						
						
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Unit Price');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								 <?php echo $this->Number->currency($productDetail['AcrClientCreditnoteProduct']['unit_rate'],'');?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Discount %');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php if(!empty($productDetail['AcrClientCreditnoteProduct']['discount_percent'])) {
			                        echo $productDetail['AcrClientCreditnoteProduct']['discount_percent'],'%';
			                    } else {
			                        echo "&nbsp;";
			                    } ?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Amount');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php echo $this->Number->currency($productDetail['AcrClientCreditnoteProduct']['line_total'],'');?>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<?php endforeach;?>
		  <!-- end only for mobile -->
    
    
    <div class="row marginleftrightzero paddingbottom20">
        <div class="col-sm-4 col-xs-12 no-padding-right no-padding-left subtotal pull-right">
            <div class="row marginleftrightzero borderon no-padding-left">
                <div class="row marginleftrightzero padding_right5">
                    <span class="left bold">Subtotal</span>
                    <span class="right bold"><?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['func_sub_total'],$defaultCurrencyInfo['CpnCurrency']['code']);?></span>
                </div>
                <?php foreach($taxes as $tax):?>
                <div class="row marginleftrightzero padding_right5">
                    <span class="left"><?php echo $tax['taxName'];?></span>
                    <span class="right"><?php echo $this->Number->currency($tax['taxAmount'],$defaultCurrencyInfo['CpnCurrency']['code']);?></span>
                </div>
                <?php endforeach;?>
            </div>
            <div class="row marginleftrightzero borderon no-padding-left">
                <div class="row marginleftrightzero padding_right5">
                    <span class="left bold">Total</span>
                </div>
                <div class="row marginleftrightzero padding_right5">
                    <span class="left">In Credit Currency</span>
                    <span class="right statusopn bold"><?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['amount'],$creditNote['AcrClientCreditnote']['client_currency_code']);?></span>
                </div>
            </div>

            <div class="row marginleftrightzero borderon no-padding-left">
                <div class="row marginleftrightzero padding_right5">
                    <span class="left bold">Total</span>
                </div>
                <div class="row marginleftrightzero padding_right5">
                    <span class="left">In Subscriber Currency</span>
                    <span class="right statusopn bold"><?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['func_total'],$defaultCurrencyInfo['CpnCurrency']['code']);?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="row marginleftrightzero  paddingtop15">
        <div class="row marginleftrightzero additionalinfo">
            <div class="headernew col-lg-6 col-md-8 col-sm-4 col-xs-12">
                <h5 class="no-border-bottom">Invoice Credited</h5>
            </div>
            <div class="col-lg-3 col-md-2 col-xs-12 col-sm-3 pull-right">
                <label class="bold pull-right"><?php echo $this->Number->currency(($creditNote['AcrClientCreditnote']['amount'] - $creditNote['AcrClientCreditnote']['balance_amount']),$creditNote['AcrClientCreditnote']['client_currency_code']);?></label>
                <label class="pull-right">Total Applied :&nbsp; </label>
            </div>
            <div class="col-lg-3 col-md-2 col-xs-12 col-sm-3 pull-right">
                <label class="bold pull-right"><?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['balance_amount'],$creditNote['AcrClientCreditnote']['client_currency_code']);?></label>
                <label class="pull-right">Credit Balance :&nbsp; </label>
            </div>
        </div>
    </div>
    <div class="roles-table-wrapper-inner">
        <?php foreach($paymentHistory as $paymentDetail):?>
        <table id="sample-table-1" class="table table-striped roles-table">
            <tr>
                <td class="width-120-new bold">Date</td>
                <td class="width-120-new bold ">Invoice Number</td>
                <td class="width-120-new bold textright">Invoice Amount</td>
                <td class="width-120-new bold textright">Credit Applied</td>
                <td class="width-120-new bold textright padding-right-25">Invoice Balance</td>
            </tr>
            <tr>
                <td class="width-120-new mobile_text_right"><?php echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($paymentDetail['AcrInvoicePaymentDetail']['payment_date']));?></td>
                <td class="width-120-new mobile_text_right"><?php echo $paymentDetail['AcrClientInvoice']['invoice_number'];?></td>
                <td class="width-120-new textright mobile_text_right"><?php echo $this->Number->currency($paymentDetail['AcrClientInvoice']['invoice_total'],$creditNote['AcrClientCreditnote']['client_currency_code']);?></td>
                <td class="width-120-new textright mobile_text_right"><?php echo $this->Number->currency($paymentDetail['AcrInvoicePaymentDetail']['paid_amount'],$creditNote['AcrClientCreditnote']['client_currency_code']);?></td>
                <td class="width-120-new textright padding-right-25 mobile_text_right"><?php echo $this->Number->currency(($paymentDetail['AcrClientInvoice']['invoice_total'] - $paymentDetail['OverAllPayment']['0']['paid_amount']),$paymentDetail['AcrClientInvoice']['invoice_currency_code']);?></td>
            </tr>
        </table>
        <?php endforeach;?>
    </div>
</div><!-- /.page-content -->
<!-- inline scripts related to this page -->
<script type="text/javascript">
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
        
        $('.apply').click(function(){
           $(this).next().trigger('click');
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

            $('#applycredit').on('show.bs.modal', function(e) {
                //$(this).find('tr:first').removeClass("hidden-row");
                $(this).find('table:first').addClass("popuptable");
                $('.popuptable').find('tr:first').removeClass("hidden-row");
            });

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
                    $('.popuptable').find('tr:first').removeClass("hidden-row");
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
        $(".chosen-select").chosen();

    });

</script>
<?php echo $this->Js->writeBuffer();?>