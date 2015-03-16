<?php $counts = $this->Paginator->params();?>
<?php $pages = $this->Paginator->current('CpnCurrency');?>
<?php echo $this->Session->flash();?>
<?php 
	$homeLink = $this->Breadcrumb->getLink('Home');
	$settings = $this->Breadcrumb->getLink('Settings');
	
?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript" src="">
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
			<?php echo $this->Html->link('Settings',"$settings");?>
		</li>
		<li class="active">
			<?php echo __('Currency Settings');?>
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600"> Manage Currency </div>
		<div class="col-lg-8 col-md-7 col-sm-8 col-xs-8 no-padding-left no-padding-right width-after-600">
			<div class="widthauto paddingleftrightzero pull-right buttonrightwidth padding-right-3-480 ">
				<?php if($permission['_create'] == 1):?>
					<button class="btn btn-sm btn-success pull-right addbutton width-after-400" data-toggle="modal" data-target="#addnewcurrency">
						<i class="icon-plus"></i>
						Add New Currency
					</button>
				<?php endif;?>
				
			</div>
		</div>	
	</div>
	<!-- /.page-header -->
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive table-responsivenoscroll">
				<div class="table-header">
					<?php echo __('Currency List');?>
				</div>
				<div class="row margin-twenty-zero filterdivmob">
				<?php echo $this->Form->create('filterCurrency',array('id'=>'filterCurrencyId'));?>                                            	    
                    <div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-sm-4 nopadding col-lg-2 choosen_width admin_choosen">
                    	<?php echo $this->Form->input('filterCurrency.filterBy',array('label'=>false,'class'=>'form-control invdrop','div'=>false,'data-placeholder'=>"Filter By",'options'=>array(''=>'','name'=>'Currency Name','code'=>'Currency Code')));?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero form-filter-field col-xs-12 col-sm-4 col-lg-2 nopadding">
                     	<?php echo $this->Form->input('filterCurrency.value',array('label'=>false,'div'=>false,'type'=>'text','class'=>'form-control','placeholder'=>'Enter Value'));?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero clearlefttrespon mobile_100">
                     	<?php echo $this->Form->button('Filter',array('type'=>'submit','class'=>'btn btn-sm btn-primary filter-btn form-control mobile_100',array('controller'=>'Currencies','action'=>'index')));?>
                     </div>
                     <div class="form-group filed-left margin-bottom-zero mobile_100">
						<?php echo $this->Js->link('Reset',array('controller'=>'Currencies','action'=>'index'),array('class'=>'btn btn-sm btn-primary filter-btn filter_btn_new mobile_100','update'=>'#content'));?>
					</div>
                   <?php echo $this->Form->end();?>
                 </div>
                 <?php echo $this->Form->create('editCurrency',array('class'=>'custom-form-sl','role'=>'form','id'=>'editCurrency'));?>
					<?php echo $this->Form->hidden('editCurrency.page',array('value'=>$pages));?>
					<?php echo $this->Form->hidden('editCurrency.filterBy',array('value'=>$filterBy));?>
					<?php echo $this->Form->hidden('editCurrency.filterValue',array('value'=>$value));?>
                <?php if($permission['_delete'] == 1):?>
                <div  class="row magin-delete-all hidden-480">
                 <span class="deleteicon delete" title="Delete Selected">
                 	<?php /*echo $this->Form->submit('delete_selected.png',array('url' => array('controller'=>'Currencies','action' => 'deleteAll'),'class'=>'deleteicon delete','type'=>'submit','title'=>'Delete Selected','onclick'=>"return confirm('Are you sure you want to remove the selected currencies?')"));*/?>
                 	<?php echo $this->Js->submit('delete_selected.png', array('div'=>false,'id'=>'click_img','url' => array('controller'=>'Currencies','action' => 'deleteAll'),'type'=>'submit','escape'=>false,'update' => '#content','confirm'=>'Are you sure you want to remove the selected currencies?'));?>
                 </span>
                </div> 
                <?php endif;?>
                
				<table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
					<thead>
						<tr>
							<?php if($permission['_delete'] == 1):?>
							<th class="center"><label>
								<?php echo $this->Form->checkbox('deleteAll.All',array('div'=>false,'label'=>false,'class'=>'ace delete-m-row'));?>
								<span class="lbl"></span> </label></th>
							<?php endif; ?>
							<th><?php echo $this->Paginator->sort('code','Currency Code',array('update'=>'#content','data'=>array('filterBy'=>$filterBy,'value'=>$value))); ?></th>
							<th ><?php echo $this->Paginator->sort('name','Currency Name',array('update'=>'#content','data'=>array('filterBy'=>$filterBy,'value'=>$value))); ?></th>
							<?php if($permission['_update'] == 1 || $permission['_delete'] == 1):?>
								<th><?php echo __('Actions');?></th>
							<?php endif;?>
						</tr>
					</thead>

					<tbody>
					<?php $slno = null;?>
					<?php foreach ($cpnCurrencies as $cpnCurrency): ?>
					
						<?php $slno++;?>
						<tr>
							<?php if($permission['_delete'] == 1):?>
							<td class="center"><label>
								<?php echo $this->Form->checkbox('deleteAll.'.$cpnCurrency['CpnCurrency']['id'],array('div'=>false,'label'=>false,'class'=>'ace delete-m-row'));?>
								<span class="lbl"></span> </label></td>
							<?php endif;?>
							
							
							
							
							<td>
								<span class="on-load cname-load"><?php echo h($cpnCurrency['CpnCurrency']['code']); ?></span>
								<?php echo $this->Form->input('editCurrency.code.'.$cpnCurrency['CpnCurrency']['id'],array('div'=>false,'label'=>false,'type'=>'text','maxlength'=>'3','minlength'=>'3','class'=>'on-edit currency_code'.$cpnCurrency['CpnCurrency']['id'].' cname-edit width100 ','placeholder'=>'Currency Code','value'=>$cpnCurrency['CpnCurrency']['code']));?>
							</td>
							
							
							<td >
								<span class="on-load ccode-load"><?php echo h($cpnCurrency['CpnCurrency']['name']); ?>&nbsp;</span>
								<?php echo $this->Form->input('editCurrency.name.'.$cpnCurrency['CpnCurrency']['id'],array('div'=>false,'label'=>false,'type'=>'text','class'=>'on-edit ccode-edit width100','placeholder'=>'Currency Name','value'=>$cpnCurrency['CpnCurrency']['name']));?>
							</td>
							
							
							
							
							
							<?php if($permission['_update'] == 1 || $permission['_delete'] == 1):?>
							<td>
								<div class="visible-md visible-lg  btn-group">
									<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
										<?php echo $this->Form->button('<i class="icon-ok bigger-120"></i>',array('type'=>'submit','class'=>'btn btn-xs submit','title'=>'Save','id'=>'submit-'.$cpnCurrency['CpnCurrency']['id']));?>
										<div class="btn btn-xs close-action" title="Close">
											<i class="icon-remove bigger-120"></i>
										</div> 
									</a>
									<?php if($permission['_update'] == 1):?>
										<a class="btn btn-xs btn-info edit edit-row on-load" title="Edit" >
											<i class="icon-edit bigger-120"></i>
										</a>
									<?php endif;?>
									<?php if($permission['_delete'] == 1):?>
										<?php /*echo $this->Form->postLink('<button class="btn btn-xs btn-danger delete delete-row on-load" title="delete"><i class="icon-trash bigger-120"></i></button>',btn btn-xs btn-danger delete on-load array('controller'=>'Currencies','action' => 'delete', $cpnCurrency['CpnCurrency']['id']),array('id'=>'#sd'.$cpnCurrency['CpnCurrency']['id'],'escape'=>false),__('Are you sure you want to delete  %s?', $cpnCurrency['CpnCurrency']['name']));*/ ?>
										<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>', array('action' => 'delete', $cpnCurrency['CpnCurrency']['id'],$pages,$filterBy,$value),array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>false),__('Are you sure you want to delete # %s?', $cpnCurrency['CpnCurrency']['name'])); ?>
									<?php endif;?>
								</div>
								
								<div class="visible-xs visible-sm hidden-md hidden-lg">
									<div class="inline position-relative">
										<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
											<i class="icon-cog icon-only bigger-110"></i>
										</button>
	
										<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
	
											<li>
												<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
										<?php echo $this->Form->button('<i class="icon-ok bigger-120"></i>',array('type'=>'submit','class'=>'btn btn-xs submit','title'=>'Save','id'=>'submit-'.$cpnCurrency['CpnCurrency']['id']));?>
										<div class="btn btn-xs close-action" title="Close">
											<i class="icon-remove bigger-120"></i>
										</div> 
											</a>
											</li>
	
											<li>
												<?php if($permission['_update'] == 1):?>
										<a class="btn btn-xs btn-info edit edit-row on-load" title="Edit" >
											<i class="icon-edit bigger-120"></i>
										</a>
									<?php endif;?>
											</li>
											
												<li>
											<?php if($permission['_delete'] == 1):?>
										<?php /*echo $this->Form->postLink('<button class="btn btn-xs btn-danger delete delete-row on-load" title="delete"><i class="icon-trash bigger-120"></i></button>',btn btn-xs btn-danger delete on-load array('controller'=>'Currencies','action' => 'delete', $cpnCurrency['CpnCurrency']['id']),array('id'=>'#sd'.$cpnCurrency['CpnCurrency']['id'],'escape'=>false),__('Are you sure you want to delete  %s?', $cpnCurrency['CpnCurrency']['name']));*/ ?>
										<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>', array('action' => 'delete', $cpnCurrency['CpnCurrency']['id'],$pages,$filterBy,$value),array('class'=>'btn btn-xs btn-danger delete on-load','title'=>'Delete','escape'=>false),__('Are you sure you want to delete # %s?', $cpnCurrency['CpnCurrency']['name'])); ?>
									<?php endif;?>
											</li>
										</ul>
									</div>
								</div>
							</td>
							<?php endif;?>
						</tr>	
						
						<script type="text/javascript">
						$(document).ready(function(){
							$('.currency_code<?php echo $cpnCurrency['CpnCurrency']['id'];?>').keyup(function() {
						        $(this).val($(this).val().toUpperCase());
						    });
							//$('.currency_code<?php echo $cpnCurrency['CpnCurrency']['id'];?>').on('input', function() {
							   //var codevalue = $.trim($('#editCurrencyCode<?php echo $cpnCurrency['CpnCurrency']['id'];?>').val());
							   
							   //alert('Text1 changed!');
							//});


							$('body').on('click', '#submit-<?php echo $cpnCurrency['CpnCurrency']['id'];?>', function(evt){
									var svalue = $.trim($('#editCurrencyCode<?php echo $cpnCurrency['CpnCurrency']['id'];?>').val());
									if(svalue.length === 0) {	
										alert("Field can't be empty");	
										$(this).parents('tr').removeClass('highlighted');
										$(this).parents('tr').addClass('highlighted2');
										$(this).parents('tr').find('.cname-edit').show();
										evt.preventDefault();
										$('#field').value();					
									}
									
									var svalue2 = $.trim($('#editCurrencyName<?php echo $cpnCurrency['CpnCurrency']['id'];?>').val());
									if(svalue2.length === 0) {	
										alert("Field can't be empty");	
										$(this).parents('tr').removeClass('highlighted');
										$(this).parents('tr').addClass('highlighted2');
										$(this).parents('tr').find('.ccode-edit').show();
										evt.preventDefault();
										$('#field').value();					
									}
								});
							});
														
								$.validator.addMethod("lettersonly", function(value, element) {
								  return this.optional(element) || /^[a-z\s]+$/i.test(value);
								}, "Please enter only Alphabets"); 
								 $.validator.addMethod('correncycode', function(value) {            
								               var cc =  /^[A-Z]+$/ 
								                return value.match(cc);
								            }, 'Invalid Currency Code ');
								  $(document).ready(function(){
								  	
									  $("#editCurrency").validate({
										 rules: {           
											"data[CpnCurrency][code][<?php echo $cpnCurrency['CpnCurrency']['id']?>]": {
												required : true,
												correncycode: true
											},			
											"data[CpnCurrency][name][<?php echo $cpnCurrency['CpnCurrency']['id']?>]":{
												required : true,
												lettersonly : true
											}
										 },
										 messages:{			 
											 "data[CpnCurrency][code][<?php echo $cpnCurrency['CpnCurrency']['id']?>]":{
												required: "Please enter the Currency Code"
										 	 },
											 "data[CpnCurrency][name][<?php echo $cpnCurrency['CpnCurrency']['id']?>]":{
												required: "Please enter the Currency Name"		 	 }
										 }
									});	
								  });
					</script>	
					<?php endforeach;?>
					
					</tbody>
				</table>
				
				 
              <?php echo $this->Form->end();?>
		
							
               
                
           </div>
           
           			<!-- Only mobile -->
			<!--<div class="table-small-view wordwrap">
                          <div class="row marginleftrightzero nopaddingleft nopaddingright borderfull header-small-view paddingtopbottom5">
                               <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                    <div class="col-xs-12">
                                        
                                     </div>
                                </div>
                          </div>
                          <?php $slno = null;?>
						  <?php foreach ($cpnCurrencies as $cpnCurrency): ?>
						  <?php echo $this->Form->create('editCurrency',array('class'=>'custom-form-sl','role'=>'form','id'=>'editCurrency'));?>
						  <?php echo $this->Form->hidden('editCurrency.page',array('value'=>$pages));?>
						  <?php echo $this->Form->hidden('editCurrency.filterBy',array('value'=>$filterBy));?>
						  <?php echo $this->Form->hidden('editCurrency.filterValue',array('value'=>$value));?>
						  <?php $slno++;?>
                          <div class="row marginleftrightzero nopaddingleft nopaddingright borderfull paddingtopbottom5 contentrow borderbottom">
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-6">
                                     <span class="pull-left">
                                        <label>
                                            <input class="ace" type="checkbox">
                                            <span class="lbl"></span>
                                        </label>
                                     </span> 
                                </div>
                                <div class="col-xs-6">
                                    <div class="pull-right">
										<div class="inline position-relative">
											
												
									
											<button class="btn btn-minier btn-info dropdown-toggle" data-toggle="dropdown">
												<i class="icon-cog icon-only bigger-120"></i>
											</button>
											<?php if($permission['_update'] == 1 || $permission['_delete'] == 1):?>
											<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">
														
														<li>
														
									
															<?php if($permission['_update'] == 1):?>
															<a class="btn btn-xs btn-info edit edit-row" title="Edit" >
																<i class="icon-edit bigger-120"></i>
															</a>
														<?php endif;?>
														</li>
	
														<li>
														<?php if($permission['_delete'] == 1):?>
												<?php  ?>
												<?php echo $this->Html->link('<i class="icon-trash bigger-120"></i>', array('action' => 'delete', $cpnCurrency['CpnCurrency']['id'],$pages,$filterBy,$value),array('class'=>'btn btn-xs btn-danger delete','title'=>'Delete','escape'=>false),__('Are you sure you want to delete # %s?', $cpnCurrency['CpnCurrency']['name'])); ?>
											<?php endif;?>
														</li>
													</ul>	
											<?php endif;?>
											
										</div>
									</div>
                                </div>
                             </div>
                             
                             
								
								
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Currency Code
                                </div>
                                <div class="col-xs-7 font13 wordwrap">
                                	<span class="on-load"><?php echo h($cpnCurrency['CpnCurrency']['code']); ?></span>
								<?php echo $this->Form->input('editCurrency.code.'.$cpnCurrency['CpnCurrency']['id'],array('div'=>false,'label'=>false,'type'=>'text','class'=>'on-edit','placeholder'=>'Currency Code','value'=>$cpnCurrency['CpnCurrency']['code']));?>
                                </div>
                             </div>
                             <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                <div class="col-xs-5 bold font13">
                                   Currency Name
                                </div>
                                <div class="col-xs-7 font13">
                                	<span class="on-load"><?php echo h($cpnCurrency['CpnCurrency']['name']); ?>&nbsp;</span>
								<?php echo $this->Form->input('editCurrency.name.'.$cpnCurrency['CpnCurrency']['id'],array('div'=>false,'label'=>false,'type'=>'text','class'=>'on-edit','placeholder'=>'Currency Name','value'=>$cpnCurrency['CpnCurrency']['name']));?>
                                </div>
                             </div>
                             
                               <div class="col-xs-4 pull-right">
                              		<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
										<?php echo $this->Form->button('<i class="icon-ok bigger-120"></i>',array('type'=>'submit','class'=>'btn btn-xs submit','title'=>'Save','id'=>'submit-'.$cpnCurrency['CpnCurrency']['id']));?>
										<div class="btn btn-xs close-action" title="Close">
											<i class="icon-remove bigger-120"></i>
										</div> 
									</a>
                              </div>
                          </div>  
                          <?php endforeach?>
                                                    
                           <div class="row marginleftrightzero nopaddingleft nopaddingright borderfullrevert borderbottom header-small-view paddingtopbottom5">
                               <div class="col-xs-12 marginleftrightzero nopaddingleft nopaddingright paddingtopbottom5">
                                    <div class="col-xs-12">
                                        <span class="pull-left">
                                        <label>
                                            <input class="ace" type="checkbox">
                                            <span class="lbl"></span>
                                        </label>
                                     </span>
                                     <span  class="row magin-delete-all">
                                         <span class="deleteicon delete pull-right" title="Delete All">
                                          <i class="icon-trash bigger-120" style="color:#d15b47;"></i>
                                         </span> 
                                     </span>
                                     </div>
                                </div>
                          </div>                                      
                    </div> -->
						
   <!-- Only mobile -->		
   
   			<!-- pagination -->
   			
   			<div class="row clear col-xs-12 paginationmaindiv">
                   <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 paginationText">
                      <div id="sample-table-2_info" class="dataTables_info">
	                     	<?php
								echo $this->Paginator->counter(array(
									'format' => __('showing <span>{:start}</span> to <span>{:end}</span> of {:count}')
								));
							?>
                     	</div>
                      </div>
                      <?php
                      	
						if($counts['count']>1):
                      ?>
	                      <div class="col-sm-6 col-xs-12 col-sm-6 col-md-6 col-lg-6 paginationNumber">
	                           <div class="dataTables_paginate paging_bootstrap">
	                                <ul class="pagination">
	                                	<?php
											$this->Paginator->options(array(
		     									'update' => '#content',
												'evalScripts' => true,
												'url' => array('controller'=>'Currencies','action'=>'index',$filterBy,$value),
												'before' => $this->Js->get('#loading')->effect('fadeIn', array('buffer' => false)),
		    									'complete' => $this->Js->get('#loading')->effect('fadeOut', array('buffer' => false))
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
                     <?php endif;?>
                </div>				
           
           <!-- pagination -->
           
		</div>
	</div>
</div><!-- /.page-content -->




 <!--add new currency---->
 
<div class="modal fade" id="addnewcurrency" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header page-header">       
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
         <h1 class="modal-title" id="myModalLabel"><?php echo __('Add Currency');?></h1>    
      </div>
      
      <?php echo $this->Form->create('CpnCurrency',array('id' => 'addnewcurrency12'))?>
     
      <div class="form-horizontal popup">
      <div class="modal-body margintop38">
         <div class="model-body-inner-content">             
                  <div class="form-group login-form-group">
                    <label class="col-sm-4 control-label col-sx-12"><?php echo __('Currency Code');?> </label>    
                    <div class="col-sm-8 ssh_keys_popup_input col-sx-12 nopaddingmobile">
                    	<?php echo $this->Form->input('code',array('div'=>false,'label'=>false,'type'=>'text','maxlength'=>'3','minlength'=>'3','class'=>'form-control','placeholder'=>'For example ZAR, USD etc'));?>
                      
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 control-label col-sx-12"> <?php echo __('Currency Name');?> </label>   
                    <div class="col-sm-8 ssh_keys_popup_input col-sx-12 nopaddingmobile">
                    	<?php echo $this->Form->input('name',array('div'=>false,'label'=>false,'class'=>'form-control','type'=>'text','placeholder'=>'For example SouthAfrica Rand'))?>
                      	
                    </div>
                  </div> 
                  <!--<div class="form-group login-form-group text-right"> 
                  <?php /*echo $this->Form->input('billing_currency',array('div'=>false,'label'=>false,'type'=>'checkbox','class'=>'ace'));*/?>
                    <span class="lbl">
                        <?php /*echo __('Admin Pannel Billing Currency');*/?>
                    </span>  
                  </div> -->                                  
                                             
          </div>
      </div>
      <div class="modal-footer modal-footerleftalign">
      		<?php echo $this->Form->button('<i class="icon-ok bigger-110"></i>Submit',array('type'=>'submit','class'=>'btn btn-info'));?>
            &nbsp; &nbsp; &nbsp;
            <div class="btn popup-cancel btn-inverse" type="button">
                <i class="icon-remove bigger-110"></i>
                Cancel
            </div>
      </div>     
      </div>
     
      <?php echo $this->Form->end();?>
    </div>
  </div>
</div>
<!--add new currency---->

<script type="text/javascript">
$('.submit').click(function(){
	var cname=$(this).parents('tr').find('.cname-edit').val();
	$(this).parents('tr').find('.cname-edit').siblings('span').text(cname);
	var ccode=$(this).parents('tr').find('.ccode-edit').val();
	$(this).parents('tr').find('.ccode-edit').siblings('span').text(ccode);
})

$('.edit').click(function(){
	var cname=$(this).parents('tr').find('.cname-load').text();
	$(this).parents('tr').find('.cname-load').siblings('.cname-edit').val(cname);
	var ccode=$(this).parents('tr').find('.ccode-load').text();
	$(this).parents('tr').find('.ccode-load').siblings('.ccode-edit').val(ccode);
})


$.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, "Please enter only Alphabets"); 
 
 $.validator.addMethod('correncycode', function(value) {            
       var cc =  /^[A-Z]+$/ 
        return value.match(cc);
    }, 'Currency code should be in capital letters ');
            

  $(document).ready(function(){
	  $("#addnewcurrency12").validate({
		 rules: {           
			"data[CpnCurrency][code]": {
				required : true,
				correncycode: true
			},			
			"data[CpnCurrency][name]":{
				required : true,
				lettersonly : true
			}
		 },
		 messages:{			 
			 "data[CpnCurrency][code]":{
				required: "Please enter the Currency Code"
		 	 },
			 "data[CpnCurrency][name]":{
				required: "Please enter the Currency Name"	
		 	 }
		 }
	 });
}); 
</script>


<script type="text/javascript">
    $(document).ready(function(){ 
    	
    	/* choosen select*/
			var config = {
				  
				  '.invdrop' : {search_contains:true}
				}
				for (var selector in config) {
				  $(selector).chosen(config[selector]);
			}
		/* choosen select*/
    	
       $('.popup-cancel').click(function(){
          $('.close').trigger('click');
       });	
    	
       $('#CpnCurrencyCode').val('');
       $('#CpnCurrencyName').val('');
     
    	//Select all for checkbox for table
			$('table th input:checkbox').on('click' , function(){
				var that = this;
				$(this).closest('table').find('tr > td:first-child input:checkbox')
				.each(function(){
					this.checked = that.checked;
					$(this).closest('tr').toggleClass('selected');
				});					
			});
    	if($('.selectpicker').length){
	   		 $('.selectpicker').selectpicker({
			});    	
    	}    	
	    var flag=0;
	    var count=0;
	 	$('th .ace').change(function(){
	 		if(count!=0)
	 		   count=0;
	 		if(flag==0){
	 		    $('.magin-delete-all .deleteicon').fadeIn('slow');
	 		    flag=1;
	 		}
	 		else{
	 			 $('.magin-delete-all .deleteicon').fadeOut('slow');
	 			 flag=0;
	 		}
	 	});
	 	$('td .ace').change(function(){
	 		
	 		if(flag==0){
	 		          var x=$(this).prop("checked");
			 		  if(x==true){	
			 		 	
			 		  	count+=1;
			 		  }
			 		  else{	 		  	
			 		  	count-=1;
			 		  }
	 		  
			 		  if(count>0 )
			 		    $('.magin-delete-all .deleteicon').fadeIn('slow');
			 		  else if(count<=0&&flag==0){ 	 		  	
			 			 $('.magin-delete-all .deleteicon').fadeOut('slow');	 			
			 		  }
	 		 }
	 	});	 		
	 	});
</script>
<!--/** for responsive **/-->
<script type="text/javascript">
$(document).ready(function(){
var flag=0;
var count=0;
$('.row.header-small-view .ace').change(function(){
	if(count!=0)
	   count=0;
	if(flag==0){
	    $('.magin-delete-all .deleteicon').fadeIn('slow');
	    flag=1;
	}
	else{
		 $('.magin-delete-all .deleteicon').fadeOut('slow');
		 flag=0;
	}
});
$('.contentrow.row .ace').change(function(){
	if(flag==0){
	  var x=$(this).prop("checked");
	  if(x==true){		 		
	  	count+=1;
	  }
	  else{	 		  	
	  	count-=1;
	  }
	  if(count>0 )
	    $('.magin-delete-all .deleteicon').fadeIn('slow');
	  else if(count<=0&&flag==0){ 	 		  	
		 $('.magin-delete-all .deleteicon').fadeOut('slow');	 			
	  }
	 
	 }
 });
 });
         
 $(document).ready(function(){
    $('.header-small-view input:checkbox').on('click' , function(){
		var that = this;
		$(this).parents('.row').siblings('.row').find('input:checkbox')
		.each(function(){
			this.checked = that.checked;
		});
    });
});
</script>
<?php echo $this->Js->writeBuffer();?>