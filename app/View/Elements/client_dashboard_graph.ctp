<?php $final = $this->requestAction('/Users/dashboardGraph/');?>
<script type="text/javascript">
	$(function() {
		var xcategories = [];
		var invoices	= [];
		var payments 	= [];
		var expences    = [];
		<?php foreach($final['monthArray'] as $key => $month) {?>
			xcategories.push('<?php echo $month;?>');
			<?php if(empty($final['invoiceArray'][$key][0]['total'])) $final['invoiceArray'][$key][0]['total'] = 0;?>
			invoices.push(<?php echo round($final['invoiceArray'][$key][0]['total'],2);?>);
			payments.push(<?php echo round($final['paymentArray'][$key],2);?>);
			expences.push(<?php echo round($final['expenseArray'][$key][0]['total'],2);?>);
		<?php }?>
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
				min : 0,
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
					return Highcharts.numberFormat(this.y, 2);
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