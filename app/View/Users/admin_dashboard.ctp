<?php echo $this -> Html -> css(array('print.css'), 'stylesheet', array('media' => 'print')); ?>
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
					<a href="#"><?php echo __('Home'); ?></a>
				</li>
				<li  class="active">
					<?php echo __('Dashboard'); ?>
				</li>

			</ul><!-- .breadcrumb -->
</div>
<div class="page-content dashboarddd">
	        <div class="row marginleftrightzero no-padding-right no-padding-left printshow">
		        <div class="col-lg-11 col-md-11 col-sm-8 col-xs-12 no-padding-right no-padding-left">	
		          <h2 class="lighter blue"> <?php echo __('Current Month Results'); ?></h1> <!-- /.page-header -->
		        </div>	
		        <div class="col-lg-1 col-md-1 col-sm-4 col-xs-12 no-padding-right no-padding-left paddingadmindb">
					<div class="btn btn-sm pull-right printbutton">
						<a href="javascript:void()" onclick="window.print()">Print <i class="icon-print icon-on-right"></i></a>
					</div>
				</div>
	        </div>			
			<div class="row">
				<div class="col-xs-12 col-lg-12 col-md-12 col-sm-12">
			<?php $dynamicClass = 1;?>
					<?php foreach($allPlan as $planId => $planName):?>
						<?php if($dynamicClass == "1"){
							$classDiv1 = "col-lg-4 col-md-6 nopaddingleft margintop15 printadminwidth";
						}elseif($dynamicClass == "2"){
							$classDiv1 = "col-lg-4 col-xs-12 col-md-6 col-sm-6 margintop15 printadminwidth";
						}elseif($dynamicClass == "3"){
							$classDiv1 = "col-lg-4 col-xs-12 col-md-6 col-sm-6 nopaddingright margintop15 printadminwidth";
						}?>
						
						<div class="<?php echo $classDiv1;?>">
						
						<div class="dashboard-box ">
							<div class="padding10 width100 left">

								<div class="width20 left">
									<?php if($dynamicClass == "1"){ ?>
										<div class="bggreen dashwidthheight">
									<?php }elseif($dynamicClass == "2"){ ?>
										<div class="bgblue colorblue dashwidthheight">
									<?php }elseif($dynamicClass == "3"){ ?>
										<div class="bgorange dashwidthheight">
									<?php }?>
										<?php echo $this->Html->link($this -> Html -> image('monitor.png', array('class' => 'imgalignn')),array('controller'=>'Subscribers','action'=>'index',$planId),array('escape'=>false));?>
										<?php /*echo $this -> Html -> image('monitor.png', array('class' => 'imgalignn'));*/ ?>
									</div>
								</div>

								<div class="width60 left">
									<h2 class="nomargin"><?php echo $this->Html->link($getSubscriptionCount[$planName],array('controller'=>'Subscribers','action'=>'index',$planId),array('escape'=>false));?></h2>
									<div>
										<?php echo $this->Html->link($planName,array('controller'=>'Subscribers','action'=>'index',$planId),array('escape'=>false));?>
									</div>
								</div>
								<?php if($getSubscriptionGrowth[$planName]['Growth'] == "up"){ ?>
									<div class="width20 right">
										<div class="percentt right">
											<div class="green">
												<?php if($getSubscriptionGrowth[$planName]['val']){?>
												<?php echo $getSubscriptionGrowth[$planName]['val'].'%';?>
												<?php } else{echo "0%";} ?>
											</div>
											<?php echo $this->Html->link($this -> Html -> image('arrowup.png'),array('controller'=>'Subscribers','action'=>'index',$planId),array('escape'=>false));?>
											<?php /*echo $this -> Html -> image('arrowup.png'); */?>
										</div>

									</div>
								<?php }else{ ?>
									<div class="width20 right">
										<div class="percentt right">
											<div class="red">
												<?php if($getSubscriptionGrowth[$planName]['val']){?>
												<?php echo $getSubscriptionGrowth[$planName]['val'].'%';?>
												<?php } else{echo "0%";} ?>
											</div>
											<?php echo $this->Html->link($this -> Html -> image('arrowdown.png'),array('controller'=>'Subscribers','action'=>'index',$planId),array('escape'=>false));?>
										</div>

									</div>
								<?php }?>
							</div>
						</div>
					</div>
					<?php $dynamicClass++;?>
				<?php endforeach;?>
					<div class="col-lg-4  col-xs-12 col-md-6 col-sm-6 margintop15 nopaddingleft printadminwidth">
						<div class="dashboard-box ">
							<div class="padding10 width100 left">

								<div class="width20 left">
									<div class="bgyellow dashwidthheight">
										<?php echo $this->Html->link($this -> Html -> image('dollar_d.png', array('class' => 'imgalignn left20')),array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Paid"),array('escape'=>false));?>
										<?php /*echo $this -> Html -> image('monitor.png', array('class' => 'imgalignn'));*/ ?>
									</div>
								</div>

								<div class="width60 left">
									<h2 class="nomargin"> <?php echo $this->Html->link($getSubscriptionCount['Paid Subscription'],array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Paid")); ?> </h2>
									<div>
										<?php echo $this->Html->link('Paid Subscription',array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Paid")); ?>
									</div>
								</div>

								<?php if($growthPercentageOther['Paid Subscription']['Growth'] == "up"){ ?>
									<div class="width20 right">
										<div class="percentt right">
											<div class="green">
												<?php if($growthPercentageOther['Paid Subscription']['val']){?>
												<?php echo $growthPercentageOther['Paid Subscription']['val'].'%';?>
												<?php } else{echo "0%";} ?>
											</div>
											<?php echo $this->Html->link($this -> Html -> image('arrowup.png'),array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Paid"),array('escape'=>false));?>
										</div>

									</div>
								<?php }else{ ?>
									<div class="width20 right">
										<div class="percentt right">
											<div class="red">
												<?php if($growthPercentageOther['Paid Subscription']['val']){?>
												<?php echo $growthPercentageOther['Paid Subscription']['val'].'%';?>
												<?php } else{echo "0%";} ?>
											</div>
											<?php echo $this->Html->link($this -> Html -> image('arrowdown.png'),array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Paid"),array('escape'=>false));?>
										</div>

									</div>
								<?php }?>

							</div>

						</div>
					</div>
					<div class="col-lg-4 col-xs-12 col-md-6 col-sm-6 margintop15 printadminwidth">
						<div class="dashboard-box ">
							<div class="padding10 width100 left">

								<div class="width20 left">
									<div class="bgblue dashwidthheight">
										<?php echo $this->Html->link($this -> Html -> image('clock_d.png', array('class' => 'imgalignn')),array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Due"),array('escape'=>false));?>
										<?php /*echo $this -> Html -> image('monitor.png', array('class' => 'imgalignn')); */?>
									</div>
								</div>

								<div class="width60 left">
									<h2 class="nomargin"><?php echo $this->Html->link($getSubscriptionCount['Due Subscription'],array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Due"),array('escape'=>false));?></h2>
									<div>
										<?php echo $this->Html->link('Due Subscription',array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Due"),array('escape'=>false));?>
									</div>
								</div>

								<?php if($growthPercentageOther['Due Subscription']['Growth'] == "up"){ ?>
									<div class="width20 right">
										<div class="percentt right">
											<div class="green">
												<?php if($growthPercentageOther['Due Subscription']['val']){?>
												<?php echo $growthPercentageOther['Due Subscription']['val'].'%';?>
												<?php } else{echo "0%";} ?>
											</div>
											<?php echo $this->Html->link($this -> Html -> image('arrowup.png'),array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Due"),array('escape'=>false));?>
										</div>

									</div>
								<?php }else{ ?>
									<div class="width20 right">
										<div class="percentt right">
											<div class="red">
												<?php if($growthPercentageOther['Due Subscription']['val']){?>
												<?php echo $growthPercentageOther['Due Subscription']['val'].'%';?>
												<?php } else{echo "0%";} ?>
											</div>
											<?php echo $this->Html->link($this -> Html -> image('arrowdown.png'),array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Due"),array('escape'=>false));?>
											<?php /*echo $this -> Html -> image('arrowdown.png');*/ ?>
										</div>

									</div>
								<?php }?>

							</div>
						</div>
					</div>

					<div class="col-lg-4  col-xs-12 col-md-6 col-sm-6 margintop15 nopaddingright printadminwidth">
						<div class="dashboard-box ">

							<div class="padding10 width100 left">

								<div class="width20 left">
									<div class="bgorange dashwidthheight colorred">
										<?php echo $this->Html->link($this -> Html -> image('error_d.png', array('class' => 'imgalignn top12')),array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Cancel"),array('escape'=>false));?>
										<?php /*echo $this -> Html -> image('monitor.png', array('class' => 'imgalignn')); */?>
									</div>
								</div>

								<div class="width60 left">
									<h2 class="nomargin"> <?php echo $this->Html->link($getSubscriptionCount['Cancel Subscription'],array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Cancel")); ?> </h2>
									<div>
										<?php echo $this->Html->link(__('Cancel Subscription'),array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Cancel")); ?>
									</div>
								</div>

								<?php if($growthPercentageOther['Cancel Subscription']['Growth'] == "up"){ ?>
									<div class="width20 right">
										<div class="percentt right">
											<div class="green">
												<?php if($growthPercentageOther['Cancel Subscription']['val']){?>
												<?php echo $growthPercentageOther['Cancel Subscription']['val'].'%';?>
												<?php } else{echo "0%";} ?>
											</div>
											<?php echo $this->Html->link($this -> Html -> image('arrowup.png'),array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Cancel"),array('escape'=>false));?>
										</div>

									</div>
								<?php }else{ ?>
									<div class="width20 right">
										<div class="percentt right">
											<div class="red">
												<?php if($growthPercentageOther['Cancel Subscription']['val']){?>
												<?php echo $growthPercentageOther['Cancel Subscription']['val'].'%';?>
												<?php } else{echo "0%";} ?>
											</div>
											<?php echo $this->Html->link($this -> Html -> image('arrowdown.png'),array('controller'=>'SubscriberInvoices','action'=>'index',"Subscription Filter","Cancel"),array('escape'=>false));?>
										</div>

									</div>
								<?php }?>

							</div>
						</div>
					</div>

				</div>
			</div><h3 class="bold blue"><?php echo __('Subscribers');?></h3>
			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->

					<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive scrollautoo">
								<!--<table class="table table-striped table-bordered table-hover rt rt1" >-->
								<table class="table table-striped table-bordered table-hover " >	
									<thead>
										<tr >

											<th class="black col-lg-3 col-md-3 col-sm-3"><?php echo __('Subscriber Type');?></th>
											<?php for($i=0;$i<=5;$i++){ ?>
												<?php if($i>0){$class = " blue";}else{ $class = "blue";}?>
												<th class="<?php echo $class?> dashboardsubscribe" ><?php echo date("M-y",strtotime( date( 'Y-m-01' )." -$i months"))?></th>
											<?php }?>
											
										</tr>
									</thead>

									<tbody>
										<tr >
											<td> <?php echo __('Previous Month subscribers');?> </td>
											<?php for($i=0;$i<=5;$i++){ ?>
												<?php if($i%2>0){$class = "";}?>
												<td class = "<?php echo $class?> dashboardsubscribe"><?php echo $getSixMonthData[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Previous Month Subscribers']?></td>
											<?php }?>
											
										</tr>

										<tr >
											<td> <?php echo __('New Subscribers');?> </td>
											<?php for($i=0;$i<=5;$i++){ ?>
												<?php if($i%2>0){$class = "";}?>
												<td class = "<?php echo $class?> dashboardsubscribe"><?php echo $getSixMonthData[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['New Subscribers']?></td>
											<?php }?>
											
										</tr>

										<tr >
											<td> <?php echo __('Cancelled Subscribers');?> </td>
											<?php for($i=0;$i<=5;$i++){ ?>
												<?php if($i%2>0){$class = "";}?>
												<td class = "<?php echo $class?> dashboardsubscribe"><?php if($getSixMonthData[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['CancelledInvoiceCount']) { echo $getSixMonthData[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['CancelledInvoiceCount'];} else{ echo "0";}?></td>
											<?php }?>
										</tr>
										<tr >
											<td class="bold"> <?php echo __('Total');?> </td>
											<?php for($i=0;$i<=5;$i++){ ?>
												<?php if($i%2>0){$class = "";}?>
													<?php $total = $getSixMonthData[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Previous Month Subscribers'] + $getSixMonthData[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['New Subscribers'] - $getSixMonthData[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['CancelledInvoiceCount'];?>
												<td class = "bold <?php echo $class?> dashboardsubscribe"><?php if($total>=0){echo $total;} else{ echo "0";}?></td>
											<?php }?>
										</tr>
									</tbody>
								</table>
							</div><!-- /.table-responsive -->
						</div><!-- /span -->
					</div><!-- /row -->
				</div>
			</div><h3 class="bold blue"><?php echo __('Subscriptions');?></h3>
			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->

					<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive scrollautoo">
								<!--<table class="table table-striped table-bordered table-hover rt rt1">-->
								<table class="table table-striped table-bordered table-hover " >	
									<thead>
										<tr>

											<th class="black col-lg-3 col-md-3 col-sm-3"><?php echo __('Subscriber Type');?></th>
											<?php for($i=0;$i<=5;$i++){ ?>
												<?php if($i>0){$class = "blue dashboardsubscribe";}else{ $class = "blue dashboardsubscribe";}?>
												<th class="<?php echo $class?>"><?php echo date("M-y",strtotime( date( 'Y-m-01' )." -$i months"))?></th>
											<?php }?>
											
										</tr>
									</thead>

									<tbody>
										<?php foreach($getSixMonthSubscriberPerSubscription as $planType => $valueArray):?>
											<?php $row= 0;?>
											<tr >
												<?php if($planType == "Total"){$classBold = "bold"; $set = 1;}?>
												<td class = "<?php echo $classBold?>"> <?php echo $planType;?> </td>
												<?php foreach($valueArray as $key=>$value): ?>
													<?php if($set){$classBold = "bold";}?>
													<?php if($row%2>0){$class = "";} ?>
													<td class = "<?php echo $classBold;?> dashboardsubscribe"> <?php echo $value;?></td>
													<?php $row++;?>
												<?php endforeach;?>
												
											</tr>
										<?php endforeach;?>
									</tbody>
								</table>
							</div><!-- /.table-responsive -->
						</div><!-- /span -->
					</div><!-- /row -->
				</div>
			</div><h3 class="bold blue"><?php echo __('Revenue');?></h3>
			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->

					<div class="row">
						<div class="col-xs-12">
							<div class="table-responsive scrollautoo">
								<!--<table class="rt1 table table-striped table-bordered table-hover rt rt1" >-->
								<table class="table table-striped table-bordered table-hover " >
									<thead>
										<tr>

											<th class="cf black col-lg-3 col-sm-3 col-md-3"><?php echo __('Subscriber Type');?></th>
											<?php for($i=0;$i<=5;$i++){ ?>
												<?php if($i>0){$class = "blue dashboardprice";}else{ $class = "blue dashboardprice";}?>
												<th class="<?php echo $class?> paddingright50"><?php echo date("M-y",strtotime( date( 'Y-m-01' )." -$i months"))?></th>
											<?php }?>
											
										</tr>
									</thead>

									<tbody>
										<tr >
											<td class="width160px"> <?php echo __('Paid Subscriptions'); ?></td>
											<?php for($i=0;$i<=5;$i++){ ?>
												<?php if($i%2>0){$class = "dashboardprice";}?>
												<td class = "<?php echo $class?> paddingright50">
													<?php if($getRevenueDetails[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Subscription']){ 
																			echo $this->Number->currency($getRevenueDetails[date("Y-M", strtotime("-$i months"))]['Subscription'],$adminSetting['CpnSetting']['currency_code']);
														  }else{
																			  echo $this->Number->currency("0",$adminSetting['CpnSetting']['currency_code']);
														  }?>
												</td>
											<?php }?>
										</tr>

										<tr>
											<td> <?php echo __('Due Subscriptions'); ?></td>
											<?php for($i=0;$i<=5;$i++){ ?>
												<?php if($i%2>0){$class = "dashboardprice";}?>
												<td class = "<?php echo $class?> paddingright50"><?php if($getRevenueDetails[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Due Subscription']){echo $this->Number->currency($getRevenueDetails[date("Y-M", strtotime("-$i months"))]['Due Subscription'],$adminSetting['CpnSetting']['currency_code']);}else{  echo $this->Number->currency("0",$adminSetting['CpnSetting']['currency_code']);}?></td>
											<?php }?>
										</tr>
										<tr >
											<td class="bold"> <?php echo __('Total'); ?></td>
											<?php for($i=0;$i<=5;$i++){ ?>
												<?php if($i%2>0){$class = "dashboardprice";}?>
												<td class = "bold <?php echo $class?> paddingright50"><?php if($getRevenueDetails[date("Y-M",strtotime( date( 'Y-m-01' )." -$i months"))]['Total']){echo $this->Number->currency($getRevenueDetails[date("Y-M", strtotime("-$i months"))]['Total'],$adminSetting['CpnSetting']['currency_code']);}else{ echo $this->Number->currency("0",$adminSetting['CpnSetting']['currency_code']);}?></td>
											<?php }?>
										</tr>
									</tbody>
								</table>
							</div><!-- /.table-responsive -->
						</div><!-- /span -->
					</div><!-- /row -->
				</div>
			</div>
		</div><!-- /.col -->

<script type = "text/javascript">
	/*function arPrint() {
		window.print();
	}*/
</script>	
