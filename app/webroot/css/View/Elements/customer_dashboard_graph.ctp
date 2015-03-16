<?php $final = $this->requestAction('/Users/dashboardCustomerGraph/');?>
<script type="text/javascript">
	var chart;
	var customer = [];
	<?php foreach($final['customerInvoice'] as $key => $value) {?>
		customer.push({name:'<?php echo $value['AcrClient']['client_name'];?>',y:<?php echo round($value[0]['total'],2);?>});
	<?php }?>
	for(i=customer.length;i<10;i++) {
		customer.push({name:'--',y:0});
	} 
	$(document).ready(function() {
		chart2 = new Highcharts.Chart({
			chart : {
				renderTo : 'container2',
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
					x : 10,

					style : {
						fontSize : '13px',
						fontFamily : 'Verdana, sans-serif',
						color : '#fff'
					}
				}
			},
			yAxis : {
				min : 0,
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
				color : '#74A4D4',
				data : customer,
				dataLabels : {
					enabled : true,
					rotation : 0,
					color : '#000',
					align : 'left',
					x : 50,
					y : 0,
					style : {
						fontSize : '13px',
						fontFamily : 'Verdana, sans-serif',
						fontWeight : 'bold'
					}
				}
			}]
		});
	}); 
</script>