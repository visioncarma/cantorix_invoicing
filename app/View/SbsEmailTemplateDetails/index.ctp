<?php echo $this->Session->flash();?>
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>
	<?php $homeLink = $this->Breadcrumb->getLink('Home');?>
	<ul class="breadcrumb">
		<li>
			<?php echo $this->Html->link('<i class="icon-home home-icon"></i>Home',"$homeLink",array('escape'=>FALSE));?>
		</li>
		<li>
			<?php echo $this->Html->link(__('Settings'),array('controller'=>'subscribers','action'=>'changeSubscription'));?>
		</li>
		<li class="active">
			Manage Email Templates
		</li>
	</ul>
	<!-- .breadcrumb -->
</div>
<div class="page-content">
	<div class="page-header">
		<div class="headernew col-lg-4 col-md-5 col-sm-4 col-xs-4 width-after-600">
			Email Templates
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive tableexpense">
				<div class="table-header">
					Manage Email Templates
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 roles-table-wrapper-inner">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding borderbottom sales-table">
				<?php if($sbsEmailTemplateDetails){_?>
				<?php foreach($sbsEmailTemplateDetails as $key=>$val):?>
					<?php if($val):?>
				<table class="table table-striped roles-table">
					<tr>
						<td class="title_role bold rowwidth200px textleft">
							<?php echo "Templates";?>
							<?php /*echo $this->Js->link('Templates',array('controller'=>'SbsEmailTemplateDetails','action'=>'index','Template',$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));*/?>
						</td>
						<td class="title bold rowwidth200px textleft">
							<?php echo "Status";?>
							<?php /*echo $this->Js->link('Status',array('controller'=>'SbsEmailTemplateDetails','action'=>'index','Status',$sortingOrder,"null",$customerName,$bucketFilter,$min,$max),array('update'=>'#pageContent'));*/?>
						</td>
						<td class="title width-80-new bold">
							<?php echo "Actions"?>
						</td>
					</tr>
					<tr>
						<td class="title_role rowwidth200px textleft"><?php echo $val['SbsEmailTemplateDetail']['template_name'];?></td>
						<td class="title rowwidth200px textleft color_green">
							<?php echo $val['SbsEmailTemplateDetail']['status'];?>
						</td>
						<td class="title width-80-new" >
							
							<?php if($permission['_read'] == '1'):?>
							<div class="btn-group">
								<?php echo $this->Html->link('<i class="icon-zoom-in bigger-120"></i>',array('controller'=>'SbsEmailTemplateDetails','action'=>'view',$val['SbsEmailTemplateDetail']['id']),array('class'=>'btn btn-xs btn-success edit on-load','data-original-title'=>'View','escape'=>FALSE));?>
							</div>
							<?php endif; ?>
							<?php if($permission['_update'] == '1'):?>
							<div class="btn-group">
							
								<?php echo $this->Html->link('<i class="icon-edit bigger-120"></i>',array('controller'=>'SbsEmailTemplateDetails','action'=>'add',$val['SbsEmailTemplateDetail']['id']),array('class'=>'btn btn-xs btn-info edit on-load','data-original-title'=>'Edit','escape'=>FALSE));?>
							</div>
							<?php endif; ?>
						</td>
						
					</tr>
				</table>
				<?php endif;?>
				<?php endforeach; ?>
				<?php }else{ ?>
					<div style = "font:Arial;font-size:100%;font-style: oblique;font-weight: bold;font-variant: small-caps;color:red; padding-bottom: 2%;padding-left: 30%;padding-top: 2%;">No email templates available</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<!-- inline scripts related to this page -->

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

		//for alternative row colors

		$('.roles-table input[type="checkbox"]').click(function() {
			select_each_row_mobile($(this));
		});
	});

</script>
<?php echo $this->Js->writeBuffer();?>