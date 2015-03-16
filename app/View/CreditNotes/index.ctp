<?php 
    $homeLink       = $this->Breadcrumb->getLink('Home');
    $url            = array($customerName,$creditNo,$status,$min,$max,'?'=>array('fromFilter'=>$from,'toFilter'=>$to));
    $dbFormat       = array("d", "M", "Y");
    $scriptFormat   = array("dd", "mm", "yyyy");
    $page           = $this->Paginator->current();
?>
<?php echo $this->Session->flash();?>
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
            <?php echo $this->Html->link('Invoices',array('controller'=>'acr_client_invoices','action'=>'index'),array('escape'=>FALSE));?>
        </li>
        <li class="active">
            Manage Credits
        </li>
    </ul>
    <!-- .breadcrumb -->
</div>
<div class="page-content">
    <div class="page-header">
        <div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
            Manage Credits
        </div>
        <?php if($permission['_create'] == '1'):?>
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 no-padding-left no-padding-right width-after-600">
            <div class="widthauto paddingleftrightzero pull-right clear400 buttonrightwidth padding-right-3-480 margin-bottom-10-400 mobile_100">
                <?php echo $this->Html->link('<i class="icon-plus"></i> Add New Credit',array('action'=>'add'/*, 0, 0, 0, $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter'=>$from,'toFilter'=>$to), $page*/),array('escape'=>FALSE,'class'=>'btn btn-sm btn-success pull-right addbutton addbutton-480 mobile_100'));?>
            </div>
        </div>
        <?php endif;?>
    </div>
    <!-- /.page-header -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive tableexpense">
                <div class="table-header">
                    Credits List
                </div>
                <div class="row margin-twenty-zero expensemargin">
                    <?php echo $this->Form->create('Filter',array('inputDefaults'=>array('div'=>FALSE,'label'=>FALSE)));?>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 form-group filed-left margin-bottom-zero no-padding-left no-padding-right width-100-480 margin-top-15-480">
                        <?php echo $this->Form->input('customerName',array('placeholder'=>'Customer Name','class'=>'form-control'));?>
                    </div>
                    <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12 form-group filed-left margin-bottom-zero no-padding-left no-padding-right clear-600 margin-top-15-600 width-100-480">
                        <?php echo $this->Form->input('creditNo',array('placeholder'=>'Credit Note #','class'=>'form-control'));?>
                    </div>
                    <div class="form-group filed-left margin-bottom-zero filter-select-width-new form-filter-field clear-1300 margin-top-15-600 width-100-480 mobile_100">
                        <div class="input select adjustchoosen">
                            <?php echo $this->Form->input('status',array('options'=>array(''=>'Select a Status','Open'=>'Open','Partially Applied'=>'Partially Applied','Applied'=>'Applied','Void'=>'Void'),'data-placeholder'=>"Select a Status",'class'=>'form-control invdrop'));?>
                        </div>
                    </div>
                    <div class="form-group filed-left margin-bottom-zero minimumValue width-100-480 mobile_100">
                        <?php echo $this->Form->input('minAmount',array('placeholder'=>'Min Amount','class'=>'form-control')); ?>
                    </div>
                    <div class="form-group filed-left margin-bottom-zero maximumValue width-100-480 mobile_100">
                        <?php echo $this->Form->input('maxAmount',array('placeholder'=>'Max Amount','class'=>'form-control')); ?>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 form-group input-group custom-datepicker no-padding-left no-padding-right  margin-top-15-1100 width-100-480 datewidth">
                        <?php echo $this->Form->input('from',array('id'=>"id-date-picker-1",'class'=>'form-control date-picker','placeholder'=>'From','data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$settings['SbsSubscriberSetting']['date_format']),));?>
                        <span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
                    </div>
                    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 form-group input-group custom-datepicker no-padding-left no-padding-right  margin-top-15-1100 width-100-480 datewidth">
                        <?php echo $this->Form->input('to',array('id'=>"id-date-picker-1",'class'=>'form-control date-picker','placeholder'=>'To','data-date-format'=>str_ireplace($dbFormat, $scriptFormat,$settings['SbsSubscriberSetting']['date_format'])));?>
                        <span class="input-group-addon"> <i class="icon-calendar bigger-110"></i> </span>
                    </div>
                    <div class="form-group filed-left margin-bottom-zero mobile_100">
                        <div class="form-group filed-left margin-bottom-zero clearlefttrespon mobile_100">
                            <?php echo $this->Js->submit('Filter',array('url'=>array('controller'=>'credit_notes','action'=>'index'),'class'=>'btn btn-sm btn-primary filter-btn form-control mobile_100','type'=>'submit','update'=>'#pageContent'));?>
                        </div>
                        <div class="form-group filed-left margin-bottom-zero mobile_100">
                            <?php echo $this->Html->link('Reset',array('action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn form-control mobile_100','title'=>'Reset filtered result'));?>
                        </div>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
    <?php echo $this->Form->create('CreditNote',array('url'=>array('controller'=>'CreditNotes','action'=>'deleteAll')));?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding margin-bottom5">
                    <div class="select-all-mobile select-all">
                        <div>
                            <input class="ace" type="checkbox"/>
                            <span class="lbl">&nbsp; Select All</span>
                        </div>
                    </div>
                    <div class="delete-all-trash">
                        <?php 
                            if($permission['_delete'] == '1') {
                                echo $this->Form->submit('delete_selected.png',array('class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected','onclick'=>"return confirm('Are you sure you want to delete selected credit notes ?')"));
                            }
                        ?>
                    </div>
                </div>
                <?php foreach($creditNotes as $creditNote):?>
                <table class="table table-striped roles-table tabletlandscape">
                    <tr>
                        <td class="select-all width-30-new">
                            <label>
                                <input class="ace" type="checkbox"/>
                                <span class="lbl"></span> 
                            </label>
                        </td>
                        <td class="title_role bold width-80-new"><?php echo $this->Paginator->sort('credit_no','Credit Note#',array('url'=>$url,'lock'=>TRUE));?></td>
                        <td class="title bold width-80-new"><?php echo $this->Paginator->sort('date_created','Credit Date',array('url'=>$url,'lock'=>TRUE));?></td>
                        <td class="title bold width-80-new textright padding-right-25"><?php echo $this->Paginator->sort('reference_no','Reference#',array('url'=>$url,'lock'=>TRUE));?></td>
                        <td class="title bold width-150-new"><?php echo $this->Paginator->sort('AcrClient.organization_name','Customer Name',array('url'=>$url,'lock'=>TRUE));?></td>
                        <td class="title bold width-80-new"><?php echo $this->Paginator->sort('status','Status',array('url'=>$url,'lock'=>TRUE));?></td>
                        <td class="title bold width-120-new textright padding-right-25"><?php echo $this->Paginator->sort('amount','Amount',array('url'=>$url,'lock'=>TRUE));?></td>
                        <td class="title bold width-120-new textright padding-right-25"><?php echo $this->Paginator->sort('balance_amount','Balance',array('url'=>$url,'lock'=>TRUE));?></td>
                        <td class="title bold action width-150-new">Action</td>
                        <td class="title select-each-mobile bold">Select</td>
                    </tr>
                    
                    <tr class="even-strip">
                        <td class="select-each width-30-new"><label>
                            <?php
                                if(($permission['_delete'] == '1') && (empty($creditNote['AcrClientCreditnote']['acr_client_invoice_id'])) && ($creditNote['AcrClientCreditnote']['status'] == 'Open' || $creditNote['AcrClientCreditnote']['status'] == 'Void')) {
                                    echo $this->Form->checkbox('CreditNote.Delete.'.$creditNote['AcrClientCreditnote']['id'],array('class'=>'ace'));
                                }
                            ?>
                            <span class="lbl"></span> </label></td>
                        <td class="title_role ewidth120 width-80-new"><?php echo $this->Html->link($creditNote['AcrClientCreditnote']['credit_no'],array('action'=>'view',$creditNote['AcrClientCreditnote']['id'],$customerName,$creditNo,$status,$min,$max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page), array('title'=>'View','escape'=>FALSE));?></td>
                        <td class="title width-80-new"><?php str_ireplace('y', 'yyyy', $settings['SbsSubscriberSetting']['date_format']);echo date($settings['SbsSubscriberSetting']['date_format'],strtotime($creditNote['AcrClientCreditnote']['date_created']));?></td>
                        <td class="title width-80-new textright padding-right-25"><?php echo $creditNote['AcrClientCreditnote']['reference_no'];?></td>
                        <td class="title width-150-new"><?php echo $creditNote['AcrClient']['organization_name'];?></td>
                        <?php $statusClass = NULL;
                        if($creditNote['AcrClientCreditnote']['status'] == 'Open'){
                            $statusClass = 'bluetext';
                        } elseif($creditNote['AcrClientCreditnote']['status'] == 'Partially Applied') {
                            $statusClass = 'greentext';
                        } else {
                            $statusClass = 'blacktext';
                        }?>
                        <td class="title width-80-new <?php echo $statusClass;?>"><?php echo $creditNote['AcrClientCreditnote']['status'];?></td>
                        <td class="title width-120-new textright padding-right-25"><?php $code = $currencyList[$creditNote['AcrClient']['cpn_currency_id']];echo $this->Number->currency($creditNote['AcrClientCreditnote']['amount'],$code);?></td>
                        <td class="title width-120-new textright padding-right-25"><?php echo $this->Number->currency($creditNote['AcrClientCreditnote']['balance_amount'], $code);?></td>
                        <td class="title width-150-new">
                         <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                            <?php if($permission['_read'] == '1'):?>
                                <?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$creditNote['AcrClientCreditnote']['id'],$customerName,$creditNo,$status,$min,$max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page), array('class'=>'btn btn-xs btn-success view','title'=>'View','escape'=>FALSE));?>
                           <?php endif;?>
                           <?php if($permission['_update'] == '1'):?>
                               <?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit', $creditNote['AcrClientCreditnote']['id'], $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page), array('class'=>'btn btn-xs btn-info edit','title'=>'Edit','escape'=>FALSE));?>
                        <?php endif;?>
                        <?php if($permission['_create'] == '1' && $creditNote['AcrClientCreditnote']['status'] != 'Void' && $creditNote['AcrClientCreditnote']['status'] != 'Applied'):?>
                        <button id="a-<?php echo $creditNote['AcrClientCreditnote']['id'];?>" class="btn btn-xs apply edit purple" title="Apply to Invoice" data-toggle="modal" data-target="#applycredit">
                            <i class="icon-paste bigger-120"></i>
                        </button>
                        <?php echo $this->Js->link('Apply Credit',array('action'=>'applyCredit', $creditNote['AcrClientCreditnote']['id'], $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page), array('class'=>'applyCreditLink','update'=>'#applyCreditUpdate','style'=>'display: none'));?>
                        <?php endif;?>
                        <?php if($permission['_update'] == '1') { ?>
                        
						<button class="btn btn-xs edit  on-load mail-popup" title="Send Credit" data-toggle="modal" data-target="#sendCredit<?php echo $creditNote['AcrClientCreditnote']['id']; ?>">
								<i class="icon-envelope-alt  bigger-120"></i>
						</button>
						
						<?php } ?>
                        <?php if($permission['_delete'] == '1' && empty($creditNote['AcrClientCreditnote']['acr_client_invoice_id']) && ($creditNote['AcrClientCreditnote']['status'] == 'Open')):?>
                            <button id="<?php echo $creditNote['AcrClientCreditnote']['id'];?>" data-target="#deleteCredit" data-toggle="modal" class="btn btn-xs btn-danger delete on-load deletecredit" title="Delete Credit">
                                <i class="icon-trash bigger-120"></i>
                            </button>
                        <?php endif;?>
                        
                        <?php if($permission['_delete'] == '1' && empty($creditNote['AcrClientCreditnote']['acr_client_invoice_id']) && ($creditNote['AcrClientCreditnote']['status'] != 'Open')):?>
                            <button id="<?php echo $creditNote['AcrClientCreditnote']['id'];?>" data-target="#deleteWarning" data-toggle="modal" class="btn btn-xs btn-danger delete on-load deleteWarning" title="Delete Credit">
                                <i class="icon-trash bigger-120"></i>
                            </button>
                        <?php endif;?>
                        </div>
                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                        	<div class="inline position-relative">
                        		<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
									<i class="icon-cog icon-only bigger-110"></i>
								</button>
								<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close ipadfix">
									<li>
										<?php if($permission['_read'] == '1'):?>
			                                <?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('action'=>'view',$creditNote['AcrClientCreditnote']['id'],$customerName,$creditNo,$status,$min,$max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page), array('class'=>'btn btn-xs btn-success view curomeranchor','title'=>'View','escape'=>FALSE));?>
			                           <?php endif;?>
									</li>
									<li>
										 <?php if($permission['_update'] == '1'):?>
				                               <?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('action'=>'edit', $creditNote['AcrClientCreditnote']['id'], $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page), array('class'=>'btn btn-xs btn-info edit curomeranchor','title'=>'Edit','escape'=>FALSE));?>
				                        <?php endif;?>
									</li>
									<li>
										<?php if($permission['_create'] == '1' && $creditNote['AcrClientCreditnote']['status'] != 'Void' && $creditNote['AcrClientCreditnote']['status'] != 'Applied'):?>
				                        <button id="a-<?php echo $creditNote['AcrClientCreditnote']['id'];?>" class="btn btn-xs apply edit purple" title="Apply to Invoice" data-toggle="modal" data-target="#applycredit">
				                            <i class="icon-paste bigger-120"></i>
				                        </button>
				                        <?php echo $this->Js->link('Apply Credit',array('action'=>'applyCredit', $creditNote['AcrClientCreditnote']['id'], $customerName, $creditNo, $status, $min, $max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page), array('class'=>'applyCreditLink','update'=>'#applyCreditUpdate','style'=>'display: none'));?>
				                        <?php endif;?>
									</li>
									<li>
											<?php if(($permission['_update'] == '1') ){?>
											<button class="btn btn-xs edit  on-load mail-popup padding02" title="Send Credit" data-toggle="modal" data-target="#sendCredit<?php echo $creditNote['AcrClientCreditnote']['id'];?>">
													<i class="icon-envelope-alt  bigger-120"></i>
											</button>
											<?php } ?>
										</li>
									<li>
										<?php if($permission['_delete'] == '1' && empty($creditNote['AcrClientCreditnote']['acr_client_invoice_id']) && ($creditNote['AcrClientCreditnote']['status'] == 'Open')):?>
				                            <button id="<?php echo $creditNote['AcrClientCreditnote']['id'];?>" data-target="#deleteCredit" data-toggle="modal" class="btn btn-xs btn-danger delete on-load deletecredit" title="Delete Credit">
				                                <i class="icon-trash bigger-120"></i>
				                            </button>
				                        <?php endif;?>
									</li>
									<li>
										<?php if($permission['_delete'] == '1' && empty($creditNote['AcrClientCreditnote']['acr_client_invoice_id']) && ($creditNote['AcrClientCreditnote']['status'] != 'Open')):?>
				                            <button id="<?php echo $creditNote['AcrClientCreditnote']['id'];?>" data-target="#deleteWarning" data-toggle="modal" class="btn btn-xs btn-danger delete on-load deleteWarning" title="Delete Credit">
				                                <i class="icon-trash bigger-120"></i>
				                            </button>
				                        <?php endif;?>
                        
									</li>
								</ul>
                        	</div>
                        </div>
                        </td>
                        <td class="select-each-mobile select-each">
                            <label>
                                <?php if(($permission['_delete'] == '1') && (empty($creditNote['AcrClientCreditnote']['acr_client_invoice_id'])) && (($creditNote['AcrClientCreditnote']['status'] == 'Open') || ($creditNote['AcrClientCreditnote']['status'] == 'Void'))) {
                                    echo $this->Form->checkbox('CreditNote.Delete.'.$creditNote['AcrClientCreditnote']['id'],array('class'=>'ace'));
                                }?>
                                <span class="lbl"></span> 
                            </label>
                        </td>
                        
                        
                    </tr>
                </table>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end();?>
    <div class="row paddingtop25">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div id="sample-table-2_info" class="dataTables_info">
                <?php echo $this->Paginator->counter(array('format' => __('Showing {:start} to {:end} of {:count} entries')));?>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="dataTables_paginate paging_bootstrap">
                <ul class="pagination">
                    <?php
                        $this->Paginator->options(array(
                            'update' => '#pageContent',
                            'evalScripts' => TRUE,
                            'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),
                            'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false)),
                            'url' => $url
                        ));
                        echo $this->Paginator->first('<i class="icon-double-angle-left"></i>', array('escape'=>false,'tag' => 'li','title'=>'First'), array('escape'=>false,'tag'=>'li','title'=>'First')); 
                        echo $this->Paginator->prev('<i class="icon-angle-left"></i>', array('escape'=>false,'tag' => 'li','title'=>'Previous'), '',array('escape'=>false,'tag'=>'li','style'=>'display:none;'));
                        echo $this->Paginator->numbers(array('separator' => '','tag'=>'li','currentClass'=>'active','currentTag'=>'a'));
                        echo $this->Paginator->next('<i class="icon-angle-right"></i>', array('escape'=>false,'tag' => 'li','title'=>'Next'),'<a href="#"><i class="icon-double-angle-right"></i></a>', array('escape'=>false,'tag'=>'li','style'=>'display:none;'));
                        echo $this->Paginator->last('<i class="icon-double-angle-right"></i>', array('escape'=>false,'tag' => 'li','title'=>'Last'), array('escape'=>false,'tag'=>'li','title'=>'Last'));
                        echo $this->Html->image('loding.gif', array('id'=>'loading','style'=>'display:none;float: right;margin-right: -18px;padding-top: 4px;'));
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /.page-content -->

<!--Apply Credit note pop up---->
<div class="modal fade creditpop" id="applycredit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog model-dialog-new">
        <div class="modal-content">
            <div id="applyCreditUpdate">
                
            </div>
        </div>
    </div>
</div>
<!--end of Apply Credit note pop up----->



<!--Popup Delete Pop up-->
<div class="modal fade first" id="deleteWarning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modelinsidesubscriber">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
                    <div class="modal-body">
                        <div class="model-body-inner-content">
                            <div>
                                <h3 class="bolder red 22pfont center"> Delete Credit Note </h3>
                                <div class="center 14pfont paddingbottom">
                                    <span class="bolder font13"> Please note: </span> This credit note has been used. Please unapply credits to perform delete.
                                </div>
                                <div class="space-12"></div>
                                <div class="paddingleftrightzero padingleftneed buttoncenter">
                                    <button data-dismiss="modal" class="btn btn-sm btn-danger">
                                        &nbsp;&nbsp;&nbsp;&nbsp;Ok&nbsp;&nbsp;&nbsp;&nbsp;
                                    </button>
                                    &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-sm btn-danger" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                                <div class="space-6"></div>
                                <p class="font13">
                                     &nbsp;
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end of Popup Delete Pop up-->






<!--Popup Delete Pop up-->
<div class="modal fade first" id="deleteCredit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modelinsidesubscriber">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
                    <div class="modal-body">
                        <div class="model-body-inner-content">
                            <div>
                                <h3 class="bolder red 22pfont center"> Delete Credit Note </h3>
                                <div class="center 14pfont paddingbottom">
                                    You are about to delete credit note# <span class="creditNoPopUp"></span>
                                </div>
                                <div class="space-12"></div>
                                <div class="paddingleftrightzero padingleftneed buttoncenter">
                                    <button data-target="#deleteConfirmCustomer" data-toggle="modal" data-dismiss="modal" class="btn btn-sm paddingbtn-sm-ok btn-danger delete on-load okpopup">
                                        Ok
                                    </button>
                                    &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-sm btn-danger" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                                <div class="space-6"></div>
                                <p class="font13">
                                    &nbsp;&nbsp;
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end of Popup Delete Pop up-->


<!--Popup Confirm delete-->
<div id="deleteConfirmCustomer" class="modal fade second" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modelinsidesubscriber">
                <!--<div class="pull-right"> <?php /*echo $this->Html->image('close_icon.png',array('class'=>'pointer','data-dismiss'=>'modal'));*/?> </div> -->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="icon-remove"></i>
                </button>
                <form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
                    <div class="modal-body">
                        <div class="model-body-inner-content">
                            <div>
                                <h3 class="bolder red 22pfont center"> Confirm Delete</h3>
                                <div class="center 14pfont paddingbottom">
                                    You are about to delete credit note# <span class="creditNoPopUp">''</span>
                                </div>
                                <div class="space-12"></div>
                                <div class="paddingleftrightzero padingleftneed buttoncenter">
                                    <?php echo $this->Html->link('Delete',array('#'),array('class'=>'btn btn-sm btn-danger delete on-load paddingbtn-sm deleteCreditNote'));
                                    ?>
                                    &nbsp;&nbsp;&nbsp;
                                    <button class="btn btn-sm btn-danger delete on-load" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                                <div class="space-6"></div>
                                <p>
                                    <span class="bolder">&nbsp;&nbsp;&nbsp;&nbsp; </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end of Popup Confirm delete-->


<?php foreach($creditNotes as $creditNote):?>
<!--Popup mail items  -->
<div class="modal fade mail" id="sendCredit<?php echo $creditNote['AcrClientCreditnote']['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	
	<div class="modal-dialog model-quotes">
		<div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
				<h1 class="modal-title bold" id="myModalLabel"><?php echo __('Send Credit');?></h1>
			</div>
			<div class="form-horizontal popup">
			<?php echo $this->Form->create('MailTemplate',array('class'=>'form-horizontal popup','role'=>'form','id'=>'MailTemplate-'.$creditNote['AcrClientCreditnote']['id'],'url'=>array('controller'=>'credit_notes','action'=>'NewSendEmailCreditNote',$creditNote['AcrClientCreditnote']['id'],$customerName,$creditNo,$status,$min,$max, '?'=>array('fromFilter' => $from, 'toFilter' => $to), $page)));?>
				
				<div class="modal-body">
					<div class="model-body-inner-content">
						<div class="form-group login-form-group">
							<p><?php echo __('Please select the Template to continue');?></p>
						</div>
						<div id="mail-field" class="form-group filed-left margin-bottom-zero drop-down">
						
							<?php echo $this->Form->input('template',array('div'=>false,'label'=>false,'class'=>'form-control selectpicker','data-placeholder'=>'Email Template','options'=>array('new_credit_product_classic'=>'Product Classic','new_credit_product_modern'=>'Product Modern','new_credit_service_classic'=>'Service Classic','new_credit_service_modern'=>'Service Modern')));?>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					 <button id="<?php echo $creditNote['AcrClientCreditnote']['id'];?>" class="btn btn-success addbutton left marginleftzero  marginright4 padding0 sendnow" title="preview" data-toggle="modal" data-target="#preview<?php echo $creditNote['AcrClientCreditnote']['id']; ?>">
                        <i class="icon-zoom-in bigger-110"></i> Preview
                    </button> 
					<?php echo $this->Form->button(__('<i class="icon-share-alt bigger-110"></i> Send'), array('controller' => 'credit_notes', 'action' => 'NewSendEmailCreditNote',$creditNote['AcrClientCreditnote']['id'], 'div' => false, 'class' => 'btn btn-info left marginleftzero marginright4 padding0')); ?>
				 	
					<?php echo $this->Js->submit('Submit', array('id'=>'trigger1'.$creditNote['AcrClientCreditnote']['id'],'div'=>false,'class'=>'previewpopup btn btn-success addbutton left marginleftzero marginright4 padding0','url' => array('controller'=>'CreditNotes','action'=>'preview_send',$creditNote['AcrClientCreditnote']['id']),'style'=>'display:none;','escape'=>false,'update' => '#preview-template'.$creditNote['AcrClientCreditnote']['id']));?>
					<button class="btn left btn-inverse marginleftzero popup-cancel marginright4 padding0" type="button"> <i class="icon-remove bigger-110"></i> Cancel </button>
				</div>
			<?php echo $this->Form->end();?>
			</div>	
			
		</div>
	</div>
</div>

<!--Popup preview items  -->
<div class="modal fade" id="preview<?php echo $creditNote['AcrClientCreditnote']['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div  class="modal-dialog model-quotes" style="width:927px;">
		 <div class="modal-content">
			<div class="modal-header page-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<i class="icon-remove"></i>
				</button>
			</div>
			<div id="preview-template<?php echo $creditNote['AcrClientCreditnote']['id']; ?>" style="float:left;width:100%;">
				
			</div>
		</div>	
	 </div>
</div>
<!--end of pop-->
 <?php endforeach;?>

<script type="text/javascript">

    $(document).ready(function(){
       $('.sendnow').click(function(){
          $('.previewpopup').trigger('click');
        	
	  });
	  
	 $('.deletecredit').click(function() {
            var creditID = $(this).parents().siblings( '.title_role').text();
            $('.creditNoPopUp').text(creditID);
            var thisid = $(this).attr('id');
            $('.deleteCreditNote').attr('href',"<?php echo $this->webroot.'CreditNotes/delete/';?>"+thisid+"<?php echo '/'.$customerName.'/'.$creditNo.'/'.$status.'/'.$min.'/'.$max.'/'.'page:'.$page.'?fromFilter='.$from.'&toFilter='.$to;?>");
       }); 
    });




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
		
		
		/* choosen select*/
						var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
	    
	    $('.apply').click(function(){
	       $(this).siblings('.applyCreditLink').trigger('click');
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
			$('.selectpicker').selectpicker({ });
		}
		$(".chosen-select").chosen();
		
		$('.popup-cancel').click(function(){
	     	$('.close').trigger('click');
	    });
	});
</script>

<?php echo $this->Js->writeBuffer();?>