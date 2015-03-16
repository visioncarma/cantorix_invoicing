<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try {
			ace.settings.check('breadcrumbs', 'fixed')
		} catch(e) {
		}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="icon-home home-icon"></i>
			<a href="#">Home</a>
		</li>
		<li>
			<a href="#">Settings</a>
		</li>
		<li class="active">
			Subscription Plans
		</li>
	</ul><!-- .breadcrumb -->
</div>

<div class="page-content">
	<div class="page-header">
		<h1> Manage Subscription Plans </h1>
		<div class="col-lg-2 paddingleftrightzero">
			<a class="btn btn-sm btn-success pull-right addbutton" href="#"> <i class="icon-plus"></i> Add New Plan </a>
		</div>
	</div>
	<!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<div class="table-header">
					Subscription Plans List
				</div>
				<table id="sample-table-1" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>Plan Type</th>
							<th class="hidden-480">Validity</th>
							<th >No of Staff</th>
							<th> No of Clients </th>
							<th>Cost</th>
							<th class="hidden-480">No of Invoices</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>Free</td>
							<td class="hidden-480">30 days</td>
							<td >0</td>
							<td>0</td>
							<td>0</td>
							<td class="hidden-480">Unlimited</td>
							<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">

								<button class="btn btn-xs btn-info edit" title="edit">
									<i class="icon-edit bigger-120"></i>
								</button>

								<button class="btn btn-xs btn-danger delete" title="delete">
									<i class="icon-trash bigger-120"></i>
								</button>
							</div>
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="icon-edit bigger-120"></i> </span> </a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="icon-trash bigger-120"></i> </span> </a>
										</li>
									</ul>
								</div>
							</div></td>
						</tr>

						<tr>
							<td>Standard</td>
							<td class="hidden-480">-</td>
							<td >3</td>
							<td>500</td>
							<td>$125</td>
							<td class="hidden-480">Unlimited</td>
							<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
								<button class="btn btn-xs btn-info edit" title="edit">
									<i class="icon-edit bigger-120"></i>
								</button>

								<button class="btn btn-xs btn-danger delete" title="delete">
									<i class="icon-trash bigger-120"></i>
								</button>
							</div>
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="icon-edit bigger-120"></i> </span> </a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="icon-trash bigger-120"></i> </span> </a>
										</li>
									</ul>
								</div>
							</div></td>
						</tr>

						<tr>
							<td>Unlimited</td>
							<td class="hidden-480">-</td>
							<td >Unlimited</td>
							<td>Unlimited</td>
							<td>Unlimited</td>
							<td class="hidden-480">Unlimited</td>
							<td>
							<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">

								<button class="btn btn-xs btn-info edit" title="edit">
									<i class="icon-edit bigger-120"></i>
								</button>

								<button class="btn btn-xs btn-danger delete" title="delete">
									<i class="icon-trash bigger-120"></i>
								</button>
							</div>
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="inline position-relative">
									<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
										<i class="icon-cog icon-only bigger-110"></i>
									</button>

									<ul class="dropdown-menu dropdown-only-icon dropdown-yellow pull-right dropdown-caret dropdown-close">

										<li>
											<a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="icon-edit bigger-120"></i> </span> </a>
										</li>

										<li>
											<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="icon-trash bigger-120"></i> </span> </a>
										</li>
									</ul>
								</div>
							</div></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div><!-- /.page-content -->

<!-- inline scripts related to this page -->

<script type="text/javascript">
	jQuery(function($) {
		$(".edit").tooltip({
			show : {
				effect : "slideDown",
				delay : 250
			}
		});
		$(".delete").tooltip({
			show : {
				effect : "slideDown",
				delay : 250
			}
		});

		$('.easy-pie-chart.percentage').each(function() {
			var $box = $(this).closest('.infobox');
			var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
			var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
			var size = parseInt($(this).data('size')) || 50;
			$(this).easyPieChart({
				barColor : barColor,
				trackColor : trackColor,
				scaleColor : false,
				lineCap : 'butt',
				lineWidth : parseInt(size / 10),
				animate : /msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase()) ? false : 1000,
				size : size
			});
		})

		$('.sparkline').each(function() {
			var $box = $(this).closest('.infobox');
			var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
			$(this).sparkline('html', {
				tagValuesAttribute : 'data-values',
				type : 'bar',
				barColor : barColor,
				chartRangeMin : $(this).data('min') || 0
			});
		});

		var placeholder = $('#piechart-placeholder').css({
			'width' : '90%',
			'min-height' : '150px'
		});
		var data = [{
			label : "social networks",
			data : 38.7,
			color : "#68BC31"
		}, {
			label : "search engines",
			data : 24.5,
			color : "#2091CF"
		}, {
			label : "ad campaigns",
			data : 8.2,
			color : "#AF4E96"
		}, {
			label : "direct traffic",
			data : 18.6,
			color : "#DA5430"
		}, {
			label : "other",
			data : 10,
			color : "#FEE074"
		}]
		function drawPieChart(placeholder, data, position) {
			$.plot(placeholder, data, {
				series : {
					pie : {
						show : true,
						tilt : 0.8,
						highlight : {
							opacity : 0.25
						},
						stroke : {
							color : '#fff',
							width : 2
						},
						startAngle : 2
					}
				},
				legend : {
					show : true,
					position : position || "ne",
					labelBoxBorderColor : null,
					margin : [-30, 15]
				},
				grid : {
					hoverable : true,
					clickable : true
				}
			})
		}

		drawPieChart(placeholder, data);

		/**
		 we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
		 so that's not needed actually.
		 */
		placeholder.data('chart', data);
		placeholder.data('draw', drawPieChart);

		var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
		var previousPoint = null;

		placeholder.on('plothover', function(event, pos, item) {
			if (item) {
				if (previousPoint != item.seriesIndex) {
					previousPoint = item.seriesIndex;
					var tip = item.series['label'] + " : " + item.series['percent'] + '%';
					$tooltip.show().children(0).text(tip);
				}
				$tooltip.css({
					top : pos.pageY + 10,
					left : pos.pageX + 10
				});
			} else {
				$tooltip.hide();
				previousPoint = null;
			}

		});

		var d1 = [];
		for (var i = 0; i < Math.PI * 2; i += 0.5) {
			d1.push([i, Math.sin(i)]);
		}

		var d2 = [];
		for (var i = 0; i < Math.PI * 2; i += 0.5) {
			d2.push([i, Math.cos(i)]);
		}

		var d3 = [];
		for (var i = 0; i < Math.PI * 2; i += 0.2) {
			d3.push([i, Math.tan(i)]);
		}

		var sales_charts = $('#sales-charts').css({
			'width' : '100%',
			'height' : '220px'
		});
		$.plot("#sales-charts", [{
			label : "Domains",
			data : d1
		}, {
			label : "Hosting",
			data : d2
		}, {
			label : "Services",
			data : d3
		}], {
			hoverable : true,
			shadowSize : 0,
			series : {
				lines : {
					show : true
				},
				points : {
					show : true
				}
			},
			xaxis : {
				tickLength : 0
			},
			yaxis : {
				ticks : 10,
				min : -2,
				max : 2,
				tickDecimals : 3
			},
			grid : {
				backgroundColor : {
					colors : ["#fff", "#fff"]
				},
				borderWidth : 1,
				borderColor : '#555'
			}
		});

		$('#recent-box [data-rel="tooltip"]').tooltip({
			placement : tooltip_placement
		});
		function tooltip_placement(context, source) {
			var $source = $(source);
			var $parent = $source.closest('.tab-content')
			var off1 = $parent.offset();
			var w1 = $parent.width();

			var off2 = $source.offset();
			var w2 = $source.width();

			if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2))
				return 'right';
			return 'left';
		}


		$('.dialogs,.comments').slimScroll({
			height : '300px'
		});

		//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
		//so disable dragging when clicking on label
		var agent = navigator.userAgent.toLowerCase();
		if ("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
			$('#tasks').on('touchstart', function(e) {
				var li = $(e.target).closest('#tasks li');
				if (li.length == 0)
					return;
				var label = li.find('label.inline').get(0);
				if (label == e.target || $.contains(label, e.target))
					e.stopImmediatePropagation();
			});

		$('#tasks').sortable({
			opacity : 0.8,
			revert : true,
			forceHelperSize : true,
			placeholder : 'draggable-placeholder',
			forcePlaceholderSize : true,
			tolerance : 'pointer',
			stop : function(event, ui) {//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
				$(ui.item).css('z-index', 'auto');
			}
		});
		$('#tasks').disableSelection();
		$('#tasks input:checkbox').removeAttr('checked').on('click', function() {
			if (this.checked)
				$(this).closest('li').addClass('selected');
			else
				$(this).closest('li').removeClass('selected');
		});

	})
</script>














<!--<div class="cpnSubscriptionPlans index">
	<h2><?php echo __('Cpn Subscription Plans'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('validity'); ?></th>
			<th><?php echo $this->Paginator->sort('no_of_staffs'); ?></th>
			<th><?php echo $this->Paginator->sort('no_of_clients'); ?></th>
			<th><?php echo $this->Paginator->sort('no_of_invoices'); ?></th>
			<th><?php echo $this->Paginator->sort('cost'); ?></th>
			<th><?php echo $this->Paginator->sort('deletion_days'); ?></th>
			<th><?php echo $this->Paginator->sort('archieve_days'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($cpnSubscriptionPlans as $cpnSubscriptionPlan): ?>
	<tr>
		<td><?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['id']); ?>&nbsp;</td>
		<td><?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['type']); ?>&nbsp;</td>
		<td><?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['validity']); ?>&nbsp;</td>
		<td><?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_staffs']); ?>&nbsp;</td>
		<td><?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_clients']); ?>&nbsp;</td>
		<td><?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['no_of_invoices']); ?>&nbsp;</td>
		<td><?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['cost']); ?>&nbsp;</td>
		<td><?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['deletion_days']); ?>&nbsp;</td>
		<td><?php echo h($cpnSubscriptionPlan['CpnSubscriptionPlan']['archieve_days']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $cpnSubscriptionPlan['CpnSubscriptionPlan']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cpnSubscriptionPlan['CpnSubscriptionPlan']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cpnSubscriptionPlan['CpnSubscriptionPlan']['id']), null, __('Are you sure you want to delete # %s?', $cpnSubscriptionPlan['CpnSubscriptionPlan']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Cpn Subscription Plan'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Sbs Subscribers'), array('controller' => 'sbs_subscribers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sbs Subscriber'), array('controller' => 'sbs_subscribers', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
