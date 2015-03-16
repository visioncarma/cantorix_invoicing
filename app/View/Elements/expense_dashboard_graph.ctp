<?php $final = $this->requestAction('/Users/dashboardExpenseGraph/');?>
<?php $colorArray = array('#EA878C','#8270AE','#74C7F1','#C9DB89','#F2B771','#EE8768','#7B9CD1','#81BD87','#BBB15A','#F1A170');?>
<script type="text/javascript">
	var chart;var emptyval = null;
	$(document).ready(function() {
		var expense = [];
		<?php foreach($final['expenses'] as $key => $value) {?>
			expense.push({name:'<?php echo $value['AcpVendor']['vendor_name'];?>',color : '<?php echo $colorArray[$key];?>',y:<?php echo round($value['AcpExpense']['amount'],2);?>});
		<?php }?>
		for(i=expense.length;i<10;i++) {
			
			expense.push({name:' ',y:emptyval});
		} 
		chart2 = new Highcharts.Chart({
			chart : {
				height: 400,
				renderTo : 'container3',
				defaultSeriesType : 'bar',
				backgroundColor : '#F1F1F1',
				margin : [0, 0, 0, 0]
			},
			credits : {
				enabled : false
			},
			legend : {
				enabled : false
			},
			title : {
				text : ''
			},
			xAxis : {
				pointPlacement : 'on',
				type : 'category',
				gridLineWidth : 1,
				gridLineColor : '#ffffff',

				labels : {
					rotation : 0,
					align : 'left',
					x : 20,
					style : {
						fontSize : '12px',
						fontFamily : 'Verdana, sans-serif',
						color : '#000'
					}
				}
			},
			yAxis : {
				min : 1,
				gridLineWidth : 0,
				title : {
					text : ''
				},
				labels : {
					enabled : false
				}
			},
			legend : {
				enabled : false
			},
			tooltip : {
				enabled : false

			},
			series : [{
				name : 'Population',
				pointPadding : 0,
				groupPadding : 0,
				borderWidth : 1,
				//minPointLength : 100,
				data : expense,
				dataLabels : {
					enabled : true,
					rotation : 0,
					color : '#000',
					align : 'left',
					x : 50,
					y : 1,
					style : {
						fontSize : '12px',
						fontFamily : 'Verdana, sans-serif',
						fontWeight : 'bold'
					},
                    formatter: function () {
                        return Highcharts.numberFormat(this.y,2);
                    }
				}
			}]
		});
	});

</script>