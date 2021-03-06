<?php echo $this -> Session -> flash(); ?>
<?php echo $this -> Html -> css(array('jquery-ui'));?>
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
			Edit Expenses
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<h1 > Edit Expenses </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<?php echo $this->Html->link('<i class="icon-arrow-left icon-on-left"></i>Back',array('action'=>'index',$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,$page),array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right addbutton'));?>
		</div>

	</div>
	<!-- /.page-header -->
	<?php echo $this -> Form -> create('AcpExpense',array('class'=>'form-horizontal formdetails','role'=>'form','id'=>'Expenses','enctype'=>'multipart/form-data','type'=>'file','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE,'class'=>'form-control')));?>
	<?php 
		echo $this -> Form -> hidden('id',array('value'=>$id));
		echo $this -> Form -> hidden('AcpInventoryExpenseID',array('value'=>$currentExpenseDetails['AcpInventoryExpense']['id']));
	?>
		<div class="row marginleftrightzero">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 paddingleftrightzero">
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-lg-2 col-md-2 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Expense Date<em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 marginleftrightzero paddingleftrightzero">
							<div class="input-group custom-datepicker expense-width datewidth">
								<?php echo $this->Form->input('expenseDate',array('class'=>'form-control date-picker','data-date-format'=>str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format']),'default'=>date($settings['SbsSubscriberSetting']['date_format'],strtotime($currentExpenseDetails['AcpExpense']['date']))));?>
								<span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
							</div>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown expense-drop heightauto">
						<label  class="col-lg-2 col-md-2 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Category<em style="color:#ff0000;">&lowast;</em></label>
						<div id="categoryUpdate" class="col-lg-3 col-md-3 col-sm-5 col-xs-12 marginleftrightzero paddingleftrightzero labelerror expansecatogry choosen_width">
							<?php echo $this->Form->input('acp_expense_categories',array('options'=>array(''=>'',$expenseCategories),'data-placeholder'=>'Select Categories','data-live-search'=>'TRUE','class'=>'invdrop','default'=>$currentExpenseDetails['AcpExpense']['acp_expense_category_id']));?>
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 padding-767 nopadding addCat">
							<div class="btn btn-sm btn-success pull-left addbutton addunitpadding-new add-row" data-target="#addcategory" data-toggle="modal">
								<i class="icon-plus"></i>
							</div>
							<label class="addcontact">Add Category</label>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-lg-2 col-md-2 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Reference No<em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 marginleftrightzero paddingleftrightzero">
							<?php echo $this->Form->input('reference_no',array('placeholder'=>'Reference No','value'=>$currentExpenseDetails['AcpExpense']['expense_no']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-lg-2 col-md-2 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Currency</label>
						<div class="col-lg-1 col-md-1 col-sm-2 col-xs-12 marginleftrightzero paddingleftrightzero">
							<?php 
							     echo $this->Form->input('currency_code',array('placeholder'=>'Reference No','value'=>$defaultCurrencyCode,'disabled'=>'disabled'));
                                 echo $this->Form->hidden('currency_code',array('value'=>$defaultCurrencyCode));
							?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group marginleftrightzero">
						<label  class="col-lg-2 col-md-2 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Vendor Name<em style="color:#ff0000;">&lowast;</em></label>
						<div class="col-sm-3 col-md-3 col-sm-5 col-xs-12 marginleftrightzero paddingleftrightzero ui-widget">
							<?php echo $this->Form->input('vendor_name',array('placeholder'=>'Vendor Name','id' => 'autocomplete','value'=>$currentExpenseDetails['AcpVendor']['vendor_name']));?>
						</div>
					</div>
				</div>
				<div class="row marginleftrightzero">
					<div class="form-group filed-left drop-down marginleftrightzero form-dropdown expense-drop heightauto">
						<label  class="col-lg-2 col-md-2 col-sm-4 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Customer Name</label>
						<div class="col-lg-3 col-md-3 col-sm-5 col-xs-12 marginleftrightzero paddingleftrightzero choosen_width">
							<?php echo $this->Form->input('acr_client_id',array('options'=>array(''=>'',$customers),'id'=>'clientDropdown','data-placeholder'=>'Select Customer','class'=>'form-control invdrop','data-live-search'=>TRUE,'default'=>$currentExpenseDetails['AcpExpense']['acr_client_id']));?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner no-padding-left no-padding-right borderblue">
			<div class="row marginleftrightzero borderbottom">
				<table class="table table-striped roles-table addexpansetabel newaddexpansetable">
					<tr>
						<td class="title_role bold width-120-new">Item<em style="color:#ff0000;">&lowast;</em></td>
						<td class="title bold width-150-new">Expense Description</td>
						<td class="title bold width-30-new">Qty<em style="color:#ff0000;">&lowast;</em></td>
						<td class="title bold width-100-new">Unit Amount<em style="color:#ff0000;">&lowast;</em></td>
						<td class="title bold width-80-new">Tax</td>
						<td class="title bold width-80-new">Amount</td>
					</tr>
					<tr>
						<td class="title_role ewidth120 expansedrop">
						<div class="form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero">
							<div id="td-inventoryUpdateSelect-1" class="col-md-11 col-sm-11 marginleftrightzero paddingleftrightzero labelerror expansecatogry countrybilling max-height max-width">
								<?php if(empty($currentExpenseDetails['AcpInventoryExpense']['inv_inventory_id'])) $currentExpenseDetails['AcpInventoryExpense']['inv_inventory_id'] = 'Non-Inventory';?>
								<?php echo $this->Form->input('items',array('options'=>array(''=>'','Non-Inventory'=>'Non-Inventory',$inventoryList),'data-placeholder'=>'Item','class'=>'invdrop','default'=>$currentExpenseDetails['AcpInventoryExpense']['inv_inventory_id'],'id'=>'inventoryItem'));
                                $this -> Js -> get('#inventoryItem') -> event('change', 
                                    $this -> Js -> request(array('action' => 'inventoryDesc'), 
                                        array('update' => '#description', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => TRUE, 'inline' => true)))
                                    )
                                );
                                $this -> Js -> get('#inventoryItem') -> event('change', 
                                    $this -> Js -> request(array('action' => 'inventoryTax'), 
                                        array('update' => '#tax_inventory', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => TRUE, 'inline' => true)))
                                    )
                                );
                                $this -> Js -> get('#inventoryItem') -> event('change', 
                                        $this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateGrandTotal'), 
                                            array('update' => '#grandTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
                                        )
                                    );
								?>
							</div>
							<div class="col-md-1 col-sm-1 marginleftrightzero paddingleftrightzero paddinglefttop4">
								<div class="btn btn-sm btn-success pull-left addbutton addunitpadding addmoreunittype additem-to-select"  data-toggle="modal" data-target="#addnewunittype-1">
								<i class="icon-plus"></i>
							</div>
							</div>
						</div></td>
						<td class="title width-180-new">
						<div id="description" class="col-lg-12 col-md-12 col-sm-12 col-xs-10 form-group marginleftrightzero margin-bottom-zero paddingleftrightzero">
							<?php echo $this->Form->textarea('inventory_description',array('class'=>'tabletextarea form-control','rows'=>'2','value'=>$currentExpenseDetails['AcpInventoryExpense']['inventory_description']));?>
						</div></td>
						<td class="title width-30-new">
						<div class="col-lg-8 col-md-12 col-sm-12 col-xs-10 form-group marginleftrightzero margin-bottom-zero paddingleftrightzero">
							<?php echo $this->Form->input('qty',array('value'=>$currentExpenseDetails['AcpInventoryExpense']['quantity'],'class'=> 'text-right form-control'));?>
							<?php 
								$this -> Js -> get('#AcpExpenseQty') -> event('change', 
									$this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateGrandTotal'), 
										array('update' => '#grandTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
									)
								);
								$this -> Js -> get('#AcpExpenseQty') -> event('change', 
									$this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateLineTotal'), 
										array('update' => '#lineTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
									)
								);
							?>
							<!--<label class="quotemeasurement">Kg</label>-->
						</div></td>
						<td class="title width-100-new">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10 form-group marginleftrightzero margin-bottom-zero paddingleftrightzero">
							<?php echo $this->Form->input('unit_amount',array('value'=>$currentExpenseDetails['AcpInventoryExpense']['cost_price'], 'class'=> 'text-right form-control'));?>
							<?php 
								$this -> Js -> get('#AcpExpenseUnitAmount') -> event('change', 
									$this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateGrandTotal'), 
										array('update' => '#grandTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
									)
								);
								$this -> Js -> get('#AcpExpenseUnitAmount') -> event('change', 
									$this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateLineTotal'), 
										array('update' => '#lineTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
									)
								);
							?>
						</div></td>
						<td class="title width-130-new">
						<div  id="tax_inventory" class="col-lg-12 col-md-12 col-sm-12 col-xs-10 form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero paddingleftrightzero expenseradiomargin expanse_tax_width">
							<div class="marginleftrightzero paddingleftrightzero ">
								<?php echo $this -> Form -> input('tax_inventory', array('id'=>'tax_inventory','div' => false, 'label' => false, 'class' => 'invdrop','data-placeholder'=>"Select Tax", 'options' => array('' => '', $taxList),'default'=>$taxID)); ?>
								<?php 
									$this -> Js -> get('#tax_inventory') -> event('change', 
										$this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateGrandTotal'), 
											array('update' => '#grandTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
										)
									);
									$this -> Js -> get('#tax_inventory') -> event('change', 
										$this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateLineTotal'), 
											array('update' => '#lineTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
										)
									);
								?>
							</div>
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-10 form-group filed-left drop-down marginleftrightzero form-dropdown margin-bottom-zero paddingleftrightzero expenseradiomargin heightauto">
							<div class="marginleftrightzero paddingleftrightzero">
								<div class="radio expenseradio" id="firstRadio">
									<label>
										<input id="taxinc" class="ace taxinc" type="radio" name="data[AcpExpense][tax_inclusive]" value="tax included">
										<span class="lbl">Tax Included</span>
									</label>
								</div>
								<div class="radio expenseradio" id="secondRadio">
									<label>
										<input id="taxinc" class="ace taxinc" type="radio" name="data[AcpExpense][tax_inclusive]" value="tax excluded">
										<span class="lbl">Excluded</span>
									</label>
								</div>
							</div>
							<?php 
								$this -> Js -> get('.taxinc') -> event('change', 
									$this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateGrandTotal'), 
										array('update' => '#grandTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
									)
								);
								$this -> Js -> get('.taxinc') -> event('change', 
									$this -> Js -> request(array('controller' => 'expenses', 'action' => 'calculateLineTotal'), 
										array('update' => '#lineTotal', 'async' => false, 'dataExpression' => true, 'method' => 'post', 'data' => $this -> Js -> serializeForm(array('isForm' => false, 'inline' => true)))
									)
								);
							?>
						</div>
						</td>
						<td class="title width-80-new textright">
						<div id="lineTotal" class="col-lg-12 col-md-12 col-sm-12 col-xs-10 form-group marginleftrightzero margin-bottom-zero paddingleftrightzero">
							<input type="text"  class="form-control" disabled="disabled"/>
							
						</div></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="row marginleftrightzero paddingbottom20">
			<div id="grandTotal" class="col-lg-4 col-md-6 col-sm-8 col-xs-12 no-padding-right no-padding-left subtotal pull-right subtotalfix">
				<div class="row marginleftrightzero borderon">
					<div class="row marginleftrightzero">
						<span class="left bold">Subtotal</span>
						<span class="right bold">0.00</span>
					</div>
					
				</div>
				<div class="row marginleftrightzero borderon">
					<div class="row marginleftrightzero">
						<span class="left bold">Total</span>
						<span class="right bold statusopn">0.00</span>
					</div>
				</div>
			</div>
		</div>
		<div class="row marginleftrightzero paddingbottom20 paddingtop25">
			<div class="row marginleftrightzero">
				<div class="form-group marginleftrightzero">
					<label  class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label marginleftrightzero paddingleftrightzero">Notes</label>
					<div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 marginleftrightzero paddingleftrightzero">
						<!--<textarea class="form-control" maxlength="55"></textarea>-->
						<?php echo $this->Form->textarea('notes',array('maxlenght'=>'55','class'=>'form-control','value'=>$currentExpenseDetails['AcpExpense']['notes']));?>
					</div>
				</div>
			</div>
			
			<div class="form-group marginleftrightzero">
					<label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right marginleftrightzero paddingleftrightzero">Attach Receipt</label>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 marginleftrightzero paddingleftrightzero">
					<label class="custLabel">
						<input type="file" name="file" id="exampleInputFile"/>
						Browse
					</label>
					<p class="help-block">Type of file: pdf, jpeg, gif or png</p>
					<div class="display-thumbnail">
						<img id="img_prev" src="" alt="" width="112" />
						<a class="close-it"></a>
						<span class="file-size"><strong></strong></span>
						<a class="btn btn-rmv">Remove file</a>
						<span class="current_file_size"> Bytes</span>
					</div>
					</div>
				</div>
			<?php if($currentExpenseDetails['AcpExpense']['reciept_upload']){ ?>
				<?php $path_explode=explode('/',$currentExpenseDetails['AcpExpense']['reciept_upload']);
                    foreach ($path_explode as $keyValue => $fileNameandFolder) {
                        $fileNameDisplay = $fileNameandFolder;
                    }
				?> 
				       
				     <div class="form-group marginleftrightzero">  
				       <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right marginleftrightzero paddingleftrightzero" >&nbsp;</label>
				       <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 marginleftrightzero paddingleftrightzero">
					       <div class="old" style="display:block;">
	                            <a style= "color:#49A5D2" target="_blank" href="<?php echo $currentExpenseDetails['AcpExpense']['reciept_upload']; ?>"><?php echo $fileNameDisplay;?></a>
	                            <?php echo $this->Html->link($this->Html->image('delete_selected.png',array('class' => 'deleteicon delete','title'=>'Delete Receipt')),'/expenses/delete_receipt/'.$currentExpenseDetails['AcpExpense']['id'].'/'.$expenseNo.'/'.$vendorName.'/'.$customerName.'/'.$fromDate.'/'.$toDate.'/'.$status.'/'.$page,array('escape' => false,'confirm' => 'Are you sure you want to delete the receipt ?'));?>
	                       </div>
	                   </div>    
                     </div>  
               <?php } ?>
		</div>
		
		<?php if(!empty($customFields)):?>
		<div class="row marginleftrightzero paddingbottom20">
			<div class="row marginleftrightzero additionalinfo paddingbottom10">
				<h5>Additional Information</h5>
			</div>
			<div class="row marginleftrightzero">
				<?php foreach($customFields as $customFieldID => $customField):?>
				<div class="form-group marginleftrightzero paddingtop15">
					<label  class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label marginleftrightzero paddingleftrightzero"><?php echo $customField['AcpExpenseCustomField']['field_name'];?></label>
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 marginleftrightzero paddingleftrightzero">
						<?php echo $this->Form->input('AcpExpense.custom_field.'.$customField['AcpExpenseCustomField']['id'].'.value',array('value'=>$customField['AcpExpenseCustomFieldValue']['data']));?>
						<?php echo $this->Form->hidden('AcpExpense.custom_field.'.$customField['AcpExpenseCustomField']['id'].'.id',array('value'=>$customField['AcpExpenseCustomFieldValue']['id']));?>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
		<?php endif;?>
		<div class="imageerror">
            	  <?php echo $this->Form->hidden('Imageupload',array('value'=>'true','class'=>'checkupload')); ?>   
        </div>
		<div class="row marginleftrightzero paddingbottom20 footerbutton">
			<div class="col-lg-offset-3 col-lg-6 col-md-offset-0 col-md-12 col-sm-offset-0 col-sm-12 col-xs-12 no-padding-left no-padding-right">
				<button class="btn btn-info button_mobile" type="submit">
					<i class="icon-ok bigger-110"></i> Save & Close
				</button>
				<?php 
				if($currentExpenseDetails['AcpExpense']['acr_client_id']) {
				    $block = 'inline-block';
				} else {
				    $block = 'none';
				}
				echo $this->Form->button('<i class="icon-save bigger-110"></i> Convert to Invoice',array('id'=>'convertToInvoice','style'=>'display: '.$block.';','escape'=>FALSE,'class'=>'btn btn-info margin-top-15-340 button_mobile','type'=>'submit', 'name' => 'data[AcpExpense][ConvertToInvoice]', 'value' => 'ConvertToInvoice'));?>
				<?php echo $this->Html->link('<i class="icon-remove bigger-110"></i> Cancel',array('action'=>'index',$expenseNo,$vendorName,$customerName,'?'=>array('fromDate'=>$fromDate,'toDate'=>$toDate),$status,'page:'.$page),array('class'=>'btn btn-inverse button_mobile','escape'=>FALSE));?>
			</div>
		</div>
	<?php echo $this->Form->end();?>
</div>
<!-- /.page-content -->



<!--add new category---->
<div class="modal fade" id="addcategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog model-dialog-new">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title" id="myModalLabel">Add New Expense Category</h1>
			</div>
			<?php echo $this->Form->create('AcpExpenseCategory',array('url'=>array('controller'=>'expense_categories','action'=>'add'),'class'=>'form-horizontal popup','role'=>'form','id'=>'ExpenseCategoryNew','inputDefaults'=>array('div'=>FALSE,'label'=>FALSE),'update'=>'#inventory'));?>
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="form-group login-form-group">
							<label class="col-sm-4 control-label">Category Name<sup class="redstar">&lowast;</sup></label>
							<div class="col-sm-8 addcurrency_popup_input no-padding-left no-padding-right">
								<?php echo $this->Form->input('category_name',array('placeholder'=>'Category Name','autocomplete'=>'off', 'class'=>'width100'));?>
							</div>
						</div>
						<div class="form-group login-form-group">
							<label class="col-sm-4 control-label"> Description </label>
							<div class="col-sm-8 addcurrency_popup_input no-padding-left no-padding-right">
								<?php echo $this->Form->input('description',array('placeholder'=>'Description','rows'=>'2','autocomplete'=>'off','maxlength'=>'55','class'=>'width100'));?>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit-Inv close-submit','url' => array('controller'=>'expense_categories','action'=>'add'),'escape'=>false,'update' => '#categoryUpdate','tag'=>'<i class="icon-ok bigger-110"></i>'));
					?>
					<!-- <button class="btn btn-info" type="submit">
						<i class="icon-ok bigger-110"></i>
						Submit
					</button> -->
					<button class="btn btn-inverse close-submit" type="button">
						<i class="icon-remove bigger-110"></i>
						Cancel
					</button>
				</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>
</div>
<!--add new category---->

<!--Popup add  -->
<div class="modal fade" id="addnewunittype-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog addunittype">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
				<h1 class="modal-title" id="myModalLabel"><?php echo __('Add Inventory');?></h1>
			</div>
			<?php echo $this->Form->create('addInventory',array('id'=>'addInventory','role'=>'form','class'=>'form-horizontal popup'));?>
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="addtype-wrapper">
							<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Name');?> </label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.name',array('div'=>false,'label'=>false,'autocomplete'=>'off','class'=>'col-xs-10 col-sm-5 form-control','type'=>'text','id'=>'orm-field-1','Placeholder'=>'Inventory name'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('Description');?></label>
					<div class="col-sm-8">
						<?php echo $this->Form->input('addInventory.description',array('div'=>false,'label'=>false,'autocomplete'=>'off','type'=>'textarea','rows'=>'2','class'=>'form-control col-xs-10 col-sm-5 itemdescription','id'=>'form-field-2','Placeholder'=>'Description of the inventory','maxlength'=>'55'));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"><?php echo __('List Price');?></label>
					<div class="col-sm-8">
						<span>
					    	<?php echo $this->Form->hidden('addInventory.currency',array('value'=>$defaultCurrency));?>
							<?php echo $this->Form->input('addInventory.code',array('label'=>false,'div'=>false,'type'=>'text','id'=>'form-field-3','class'=>'form-control width30 col-xs-10 col-sm-5','value'=>$defaultCurrencyCode,'readonly'=>'readonly'))?>
						</span>
						<span>
							<?php echo $this->Form->input('addInventory.list_price',array('div'=>false,'label'=>false,'type'=>'text','id'=>'form-field-3','class'=>'col-xs-10 width70 col-sm-5 form-control','style'=>'width:37%','Placeholder'=>'Inventory price'));?>
						</span>
						
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo 'Tax/Tax Group';?> </label>
					<div class="col-sm-8 choosen_width">
						<?php echo $this->Form->input('addInventory.tax_inventory',array('div'=>false,'label'=>false,'class'=>'form-control col-xs-10 col-sm-5 invdrop','data-placeholder'=>"Select Tax",'options'=>array(''=>'',$taxList)));?>
					</div>
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Unit Type');?> </label>
					<div class="col-sm-8 choosen_width" id ="unit-type">
						<?php echo $this->Form->input('addInventory.unitType',array('div'=>false,'label'=>false,'class'=>'col-xs-10 col-sm-5 form-control invdrop','data-placeholder'=>"Select Unit Type",'options'=>array(''=>'',$unitTypeList)));?>
					</div>
					
				</div>
				<div class="space-4"></div>
				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="form-field-1"> <?php echo __('Track Item Quantities');?></label>
					<div class="col-sm-8">
						<label>
							<?php echo $this->Form->checkbox('addInventory.track',array('div'=>false,'label'=>false,'class'=>'ace'));?>
							<span class="lbl"></span> </label>
						<label class="maillabel">Yes</label>
					</div>
				</div>
				<div class="space-4"></div>
				
						</div>
					</div>
				</div>
				<div class="modal-footer paddingright8">
					<?php echo $this->Js->submit('Submit', array('div'=>false,'class'=>'btn btn-info close-submit close-submit-inventory','url' => array('controller'=>'inventories','action'=>'addInventoryFromExpense'),'escape'=>false,'update' => '#td-inventoryUpdateSelect-1','tag'=>'<i class="icon-ok bigger-110"></i>'));?>
					
					<!--<button class="btn btn-info" type="button">
						<i class="icon-ok bigger-110"></i>
						Submit
					</button>-->		
					<button class="btn close-submit-Inv btn-inverse" type="button">
					    Cancel
					</button>
				</div>
			<?php echo $this->form->end();?>
		</div>
	</div>
</div>
<!--end of pop-->
<?php if(isset($_SERVER['HTTPS'] )  && $_SERVER['HTTPS'] != 'off' ){
    $protocol_final = 'https';
} else {
    $protocol_final = 'http';
} ?>
<!-- inline scripts related to this page --> 
<?php echo $this->Html->script(array('jquery-ui-1.10.3.full.min.js','View/Expenses/add.js','upload/load-image.all.min.js','upload/jquery.fileupload.js','upload/jquery.fileupload-process.js','upload/jquery.fileupload-image.js','upload/jquery.fileupload-process.js','upload/jquery.fileupload-image.js','upload/jquery.fileupload-validate.js','upload/jquery.fileupload-ui.js'));?>
<?php echo $this->Html->script('jquery.autosize.input.min.js'); ?>
<?php echo $this->Html->script('jquery.removableFileUpload.js'); ?>
<script type="text/javascript">
$(function() {
	$( "#clientDropdown" ).change(function() {
		$('.labelerror .error').hide();
	});

	var config = {
	  '#clientDropdown' : {search_contains:true},
	  '.invdrop' : {search_contains:true}
	}
	for (var selector in config) {
	  $(selector).chosen(config[selector]);
	}
});
$(window).load(function(){
   
	<?php if($currentExpenseDetails['AcpExpense']['tax_included'] == 'Y'){ ?>
		setTimeout(function() {
        	$( "#firstRadio label input").trigger("click");
    	},100);
	<?php } else {?>
		setTimeout(function() {
        	$( "#secondRadio label input").trigger("click");
    	},100);
	<?php }?>
});


/**From Settings**/
$(document).ready(function(){
	
	/* choosen select*/
		var config = {
			  
			  '.invdrop' : {search_contains:true}
			}
			for (var selector in config) {
			  $(selector).chosen(config[selector]);
		}
	/* choosen select*/
	
	
	$('.select-dropdown>ul a').on('click', function(){    
		$('.btn-select').html($(this).html() + '<span class="caret"></span>');    
	});
	
	$('#exampleInputFile').change(function() {
		var inputvalue = $(this).val().split('\\').pop();
		var f=this.files[0]
    	var size=(f.size);
    	$('.current_file_size').text(inputvalue);
    	$('.file-size').text(size+ ' Bytes');
	});
	$('.close-it, .btn-rmv').click(function(){
		$(".display-thumbnail").hide();
		$('#exampleInputFile').empty(); 
	});
	
	$('.display-thumbnail input[type=file]').removableFileUpload();
	$('.close-submit').click(function(){
     	$('#addcategory').modal('hide');
    });
	$('.selectpicker').selectpicker().change(function(){
       	$(this).valid()
	});
	
	
	
	$("#Expenses").validate({
		ignore: [],
		onkeyup: false,
		rules: {
			'data[AcpExpense][expenseDate]' : {
				required : true
			},
			'data[AcpExpense][acp_expense_categories]': { 
			   required : true
		     },
		     'data[AcpExpense][reference_no]' : {
		     	required : true
		     },
		     'data[AcpExpense][vendor_name]' : {
		     	required : true
		     },	
		     'data[AcpExpense][items]' : {
		    	required : true
		     },
		     'data[AcpExpense][qty]' : {
		     	required : true,
		     	number: true
		     },
		     'data[AcpExpense][unit_amount]' : {
		     	required : true,
		     	number: true
		     }
		},
		messages: {
			'data[AcpExpense][expenseDate]' : {
				required : 'Please select expense date.'
			},
			'data[AcpExpense][acp_expense_categories]':  { 
			   required : 'Please select expense category.'
		     },	
		     'data[AcpExpense][reference_no]':  { 
			   required : 'Please enter reference no.'
		     },
		     'data[AcpExpense][vendor_name]' : {
		     	required : 'Please enter vendor name.'
		     },
		     'data[AcpExpense][items]' : {
		     	required : 'Please select an item.'
		     },
		     'data[AcpExpense][qty]' : {
		     	required : 'Please enter quantity.',
		     	number: 'Please enter valid number'
		     },
		     'data[AcpExpense][unit_amount]' : {
		     	required : 'Please enter unit amount.',
		     	number: 'Please enter valid number'
		     }
		}
	});
});
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#img_prev');
				var checkerror =$(".checkupload").val();	
                if(checkerror == 'false'){
                	$('.display-thumbnail').hide();
                }else{
                	$('.display-thumbnail').show();
                	$('.old').hide();
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#exampleInputFile").change(function(){
        readURL(this);
	});
	$('#exampleInputFile').bind('change', function() { });
	
	$('body').on("change","#exampleInputFile",function(){
    		var f=this.files[0]
    		
    		var type=(f.type);
    		var size=(f.size);
    		if((type != 'image/jpg') && (type != 'image/jpeg') && (type != 'image/png') && ( (type != 'image/gif')) && (type != 'application/pdf')){
            	alert('Type of file: pdf, jpeg, gif or png');
            	$(".display-thumbnail").hide();
            	$(".checkupload").val('false');
            	return false;
            }
            $(".checkupload").val('true');
            $(".display-thumbnail").show();
            return true;
          
     });
	
	
/**From Settings**/

		$(".invdrop option:contains('|--')").remove();
		$('.close-submit').click(function(){
	     	$('#addcategory').modal('hide');
	    });
	    $('.close-submit-Inv').on( "click", "", function() {
			$('#addnewunittype-1').modal('hide');
		});
		$('.close-submit-inventory').click(function(){
	     	$('#addnewunittype-1').modal('hide');
	    });
		$('#clientDropdown').change(function(){
			var val = $(this).val();
			if(!val.trim()) {
				$('#convertToInvoice').hide();
			} else {
				$('#convertToInvoice').show();
			}
		});
	    
          /*  jQuery(function($) {
		        $('#spinner1').ace_spinner({value:1,min:1,max:200,step:1, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
				.on('change', function(){});
			}); */
			jQuery(function($) {
				$(".chosen-select").chosen();
			});
			$(document).ready(function(){
				if($('.selectpicker').length){
		   $('.selectpicker').selectpicker({
		   });
		}	
			$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
$(this).prev().focus();
});
			});
			
//table mobile view script//
</script>
<script type="text/javascript">
$(document).ready(function(){
//table mobile view script//	
	 if($('.roles-table-wrapper-inner').length)
		{
			var winsize = 1;
			if($('.roles-table').length)
			{
				var i=1;
				$('.roles-table').each(function(){
					$(this).addClass("role-table-"+i);
					i++;
				});
			}
			$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");
			
				$changeTableView = function(){
					$(".table").each(function() {
						var $this = $(this);
						var newrows = [];
						$this.find("tr").each(function(){
							var i = 0;
							$(this).find("td").each(function(){
								i++;
								if(newrows[i] === undefined) { newrows[i] = $("<tr></tr>"); }
								newrows[i].append($(this));
							});
						});
						$this.find("tr").remove();
						$.each(newrows, function(){
							$this.append(this);
						});
					});
					
				};
			
			if($(window).width()<1025)
			{
				$changeTableView();
				winsize = 0;
			}
			
			$(window).on("resize", function(){
				
				if(Math.floor($(window).width()/1025)!=winsize)
				{
					$changeTableView();
					winsize = Math.floor($(window).width()/1025);
				}
				if($(window).width()>992)
				{
					$('.roles-table').not('.role-table-1').find('tr:first').addClass("hidden-row");
				}
			});	
		}
//table mobile view script//
});
(function($) {
  $('#autocomplete').autocomplete({
        source: "<?php echo $protocol_final.'://'.$_SERVER['SERVER_NAME'].$this->webroot;?>Expenses/add.json"
  });
})(jQuery);
</script>
<style type="text/css">
	.ui-helper-hidden-accessible {
    display: none;
}
</style>
<?php echo $this->Js->writeBuffer();?>