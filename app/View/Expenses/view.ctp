<?php 
	$homeLink = $this -> Breadcrumb -> getLink('Home');
	$expensesLink = $this->Breadcrumb->getLink('Expenses'); 
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
			<?php echo $this -> Html -> link('<i class="icon-home home-icon"></i>Home', "$homeLink", array('escape' => FALSE)); ?>
		</li>
		<li>
			<?php echo $this->Html->link('Expenses',"$expensesLink");?>
		</li>
		<li>
			<?php echo $this->Html->link('Manage Expenses',array('action'=>'index'));?>
		</li>
		<li class="active">
			View Expenses
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 > <?php if(!empty($expenseDetails['AcrClient']['organization_name'])) { echo $expenseDetails['AcrClient']['organization_name'];} else { echo '&nbsp;';} ?> </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i> Back',array('action'=>'index',$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,'page:'.$page),array('class'=>'btn btn-sm btn-success pull-right addbutton','escape'=>FALSE));?>
		</div>
	</div>
	<!-- /.page-header -->
	<form class="form-horizontal formdetails" role="form" id="fileupload">
		<div class="row marginleftrightzero">
			<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero margin0">
						<label  class="col-lg-5 col-md-5 col-sm-4 col-xs-5 control-label marginleftrightzero paddingleftrightzero">Expense Date</label>
						<div class="col-lg-5 col-md-5 col-sm-4 col-xs-7 marginleftrightzero paddingleftrightzero">
							<label class="control-label"><strong><?php str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format']);echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($expenseDetails['AcpExpense']['date']));?></strong></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown expense-drop margin0">
						<label  class="col-lg-5 col-md-5 col-sm-4 col-xs-5 control-label marginleftrightzero paddingleftrightzero">Category</label>
						<div class="col-lg-5 col-md-5 col-sm-4 col-xs-7 marginleftrightzero paddingleftrightzero">
							<label class="control-label"><strong><?php echo $expenseDetails['AcpExpenseCategory']['category_name'];?></strong></label>
						</div>

					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero margin0">
						<label  class="col-lg-5 col-md-5 col-sm-4 col-xs-5 control-label marginleftrightzero paddingleftrightzero">Reference No</label>
						<div class="col-lg-5 col-md-5 col-sm-4 col-xs-7 marginleftrightzero paddingleftrightzero">
							<label class="control-label"><strong><?php echo $expenseDetails['AcpExpense']['expense_no'];?></strong></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero margin0">
						<label  class="col-lg-5 col-md-5 col-sm-4 col-xs-5 control-label marginleftrightzero paddingleftrightzero">Currency</label>
						<div class="col-lg-5 col-md-5 col-sm-4 col-xs-7 marginleftrightzero paddingleftrightzero">
							<label class="control-label"><strong><?php echo $defaultCurrencyInfo['CpnCurrency']['code'];?></strong></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero margin0">
						<label  class="col-lg-5 col-md-5 col-sm-4 col-xs-5 control-label marginleftrightzero paddingleftrightzero">Vendor Name</label>
						<div class="col-sm-5 col-md-5 col-sm-4 col-xs-7 marginleftrightzero paddingleftrightzero">
							<label class="control-label"><strong><?php echo $expenseDetails['AcpVendor']['vendor_name'];?></strong></label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown expense-drop">
						<label  class="col-lg-5 col-md-5 col-sm-4 col-xs-5 control-label marginleftrightzero paddingleftrightzero">Customer Name</label>
						<div class="col-lg-5 col-md-5 col-sm-4 col-xs-7 marginleftrightzero paddingleftrightzero">
							<label class="control-label"><strong><?php echo $expenseDetails['AcrClient']['organization_name'];?></strong></label>
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 paddingleftrightzero">
				<div class="widget-box">
					<div class="widget-header">
						<h5>Attachment</h5>
					</div>
					<div class="thumb_outer">
						<?php
							if(empty($expenseDetails['AcpExpense']['reciept_upload'])) :
								echo 'No attachments found';
							else:
						?>
						<div class="inv_thumbnail">
							
								<span class="preview">
									<?php $path_explode=explode('/',$expenseDetails['AcpExpense']['reciept_upload']);
									 foreach ($path_explode as $keyValue => $fileNameandFolder) {
                                        $fileNameDisplay = $fileNameandFolder;
                                    }?> 
									<?php //$parram = (string)$expenseDetails['AcpExpense']['reciept_upload'];echo $this->Html->link('<i class="icon-pdf-new"></i>',array('action'=>'downloadFile','?'=>array('url'=>$parram)),array('escape'=>FALSE));?>
									 <a style= "color:#49A5D2" target="_blank" href="<?php echo $expenseDetails['AcpExpense']['reciept_upload']; ?>"><?php echo $fileNameDisplay;?></a>
								</span>
								
							
						</div>
						<?php endif;?>
					</div>
				</div>
			</div>

		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner no-padding-left no-padding-right borderblue new_table_responsive">
			<div class="row marginleftrightzero borderbottom">
				<table class="table table-striped roles-table expanse-table">
					<tr>
						<td class="title_role bold width-120-new view-header">Item</td>
						<td class="title bold width-150-new view-header">Expense Description</td>
						<td class="title bold width-80-new view-header">Qty</td>
						<td class="title bold width-100-new view-header paddingright70 textright">Unit Amount</td>
						<td class="title bold width-80-new view-header">Tax</td>
						<td class="title bold width-150-new view-header padding-right-34-new text-right">Amount</td>
					</tr>
					<tr>
						<td class="title_role ewidth120 width-150-new">
						<div class=" filed-left  marginleftrightzero  margin-bottom-zero width100">
							<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 marginleftrightzero paddingleftrightzero ">
								<span><?php echo $expenseProducts['InvInventory']['name'];?></span>
							</div>
						</div></td>
						<td class="title width-150-new">
						<div class=" filed-left  marginleftrightzero  margin-bottom-zero width100">
						
								<?php echo $expenseProducts['AcpInventoryExpense']['inventory_description'];?>
						
						</div></td>
						<td class="title width-80-new">
						<div class=" filed-left  marginleftrightzero  margin-bottom-zero width100">
							<span><?php echo $expenseProducts['AcpInventoryExpense']['quantity'];?></span>
						</div></td>
						<td class="title width-100-new paddingright70 textright">
						<div class=" filed-left  marginleftrightzero  margin-bottom-zero width100">
							<span><?php echo $this->Number->currency($expenseProducts['AcpInventoryExpense']['cost_price'],' ');?></span>
						</div></td>
						<td class="title width-150-new">
						<div class=" filed-left  marginleftrightzero  margin-bottom-zero width100">
							<div class="marginleftrightzero paddingleftrightzero">
								<?php if($expenseDetails['AcpExpense']['tax_included'] == 'Y') {
									echo 'Tax Included';
								} else {
									echo 'Tax Excluded';
								}?>
							</div>
						</div></td>
						<td class="title width-150-new  text-right padding-right-34-new">
						<div class=" filed-left  marginleftrightzero  margin-bottom-zero width100">
							<span><?php echo $this->Number->currency($expenseProducts['AcpInventoryExpense']['total_amount'], ' ');?></span>
						</div></td>
					</tr>
				</table>
			</div>
		</div>
		
		<!-- only for mobile -->
	
			<div class="table-small-view new_table_small_view new_table_small_view_new view_responsive margintop15">
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Item');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<?php echo $expenseProducts['InvInventory']['name'];?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Expense Description');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<?php echo $expenseProducts['AcpInventoryExpense']['inventory_description'];?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"><?php echo __('Qty');?></div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						
						<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
							<?php echo $expenseProducts['AcpInventoryExpense']['quantity'];?>
						</div>
						
						
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Unit Amount');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php echo $this->Number->currency($expenseProducts['AcpInventoryExpense']['cost_price'],' ');?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('TAX');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class=" marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php if($expenseDetails['AcpExpense']['tax_included'] == 'Y') {
									echo 'Tax Included';
								} else {
									echo 'Tax Excluded';
								}?>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
					<div class="col-xs-5 bold font13"> <?php echo __('Amount');?> </div>
					<div class="col-xs-7 font13  mobileClientName nopaddingright"> 
						<div class="form-group marginleftrightzero margin-bottom-zero">
							
							<div class="col-xs-10 marginleftrightzero paddingleftrightzero text-right">
								<?php echo $this->Number->currency($expenseProducts['AcpInventoryExpense']['total_amount'], ' ');?>
							</div>
						</div>
					</div>
				</div>
			</div>	
			
		  <!-- end only for mobile -->
		
		
		
		<div class="row marginleftrightzero paddingbottom20 expanse-subtotal">
			<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12 no-padding-right no-padding-left subtotal pull-right">
				<div class="row marginleftrightzero borderon">
					<div class="row marginleftrightzero">
						<span class="left bold">Subtotal</span>
						<span class="right bold"><?php echo $this->Number->currency($expenseDetails['AcpExpense']['sub_total'],$defaultCurrencyInfo['CpnCurrency']['code']);?></span>
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
						<span class="right bold statusopn"><?php echo $this->Number->currency($expenseDetails['AcpExpense']['amount'],$defaultCurrencyInfo['CpnCurrency']['code']);?></span>
					</div>
				</div>
			</div>
		</div>

		<div class="row marginleftrightzero paddingbottom20">
			<div class="row marginleftrightzero additionalinfo-2 paddingbottom10">
				<h5>Notes</h5>
			</div>
			<div class="row marginleftrightzero">
				<p>
					<?php echo $expenseDetails['AcpExpense']['notes'];?>
				</p>

			</div>
		</div>

		<div class="row marginleftrightzero paddingbottom20">
			<div class="row marginleftrightzero additionalinfo-2 paddingbottom10">
				<h5>Additional Information</h5>
			</div>
			<div class="row marginleftrightzero">
				<?php foreach($customFields as $detail):?>
				<div class="form-group marginleftrightzero margin0">
					<label  class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label marginleftrightzero paddingleftrightzero"><?php echo $detail['AcpExpenseCustomField']['field_name'];?></label>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 marginleftrightzero paddingleftrightzero">
						<label class="control-label"><strong><?php echo $detail['AcpExpenseCustomFieldValue']['data'];?></strong></label>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>

	</form>
</div>
<!-- /.page-content -->
