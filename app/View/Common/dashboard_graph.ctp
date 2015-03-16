<?php echo $this->fetch('sidebar'); ?>
<script type="text/javascript">
	$(function() {
		var xcategories = [];
		<?php foreach($monthArray as $month) {?>
			xcategories.push('<?php echo $month;?>');
		<?php }?>
		
		var payments = [11095.9, 10095.2, 12095.7, 14358.5, 13611.9, 15215.2, 16217.0, 18516.6, 17514.2, 18610.3, 20636.6, 21584.8];
		var expences = [5154, 5329.9, 5699.5, 8114.5, 6118.4, 7121.5, 5000, 5000, 5000.3, 5118.3, 6113.9, 6919.6];
		var invoices = [21521.9, 22953.2, 22453.7, 23026.5, 23926.9, 24226.2, 24826.0, 24326.6, 26626.2, 27026.3, 26826.6, 28226.8];
		var chart = new Highcharts.Chart({
			chart : {
				renderTo : 'container1',
				type : 'line'
			},
			credits : {
				enabled : false
			},
			title : {
				text : ''
			},
			subtitle : {
				text : ''
			},
			xAxis : {
				gridLineColor : '#E5E5E5',
				gridLineWidth : 1,
				labels : {
					formatter : function() {
						return xcategories[this.value];
					}
				},
				tickmarkPlacement : 'between',
				title : {
					enabled : false
				},
				startOnTick : true,
				endOnTick : true,
				minPadding : 0,
				maxPadding : 0,

			},
			yAxis : {
				gridLineColor : '#E5E5E5',
				min : 5000,
				title : {
					text : ''
				}
			},
			plotOptions : {
				line : {
					dataLabels : {
						enabled : false
					},
					enableMouseTracking : true
				}
			},
			tooltip : {
				backgroundColor : '#000',
				borderColor : '#000',
				formatter : function() {
					return this.y;
				},
				style : {
					color : '#fff',
					fontSize : '12',
					padding : '6'
				}
			},

			series : [{
				name : 'Payments',
				color : '#6DB46E',
				data : payments,
				marker : {
					lineWidth : 2,
					fillColor : '#fff',
					radius : 4,
					lineColor : '#6DB46E',
					symbol : 'circle',
					states : {
						hover : {
							radiusPlus : 0,
							lineWidthPlus : 0
						}
					}
				}
			}, {
				name : 'Expenses',
				color : '#D53233',
				data : expences,
				marker : {
					lineWidth : 2,
					fillColor : '#fff',
					radius : 4,
					lineColor : '#D53233',
					symbol : 'circle',
					states : {
						hover : {
							radiusPlus : 0,
							lineWidthPlus : 0
						}
					}
				}
			}, {
				name : 'Invoices',
				color : '#6C9BC9',
				data : invoices,
				marker : {
					lineWidth : 2,
					fillColor : '#fff',
					radius : 4,
					lineColor : '#6C9BC9',
					symbol : 'circle',
					states : {
						hover : {
							radiusPlus : 0,
							lineWidthPlus : 0
						}
					}
				}
			}]
		});
	}); 
</script>