<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>CantoriX</title>
		<meta name="description" content="Access Deined" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php echo $this->Html->css(array('ace.min','template','ace-fonts','font-awesome.min','bootstrap.min'));?>
		<?php echo $this->Html->script(array(''));?>
	</head>
	<body  class="whitebgg errorpage">
		<div class="container">
			<div class="row vertical-center-row">
				<div class="col-lg-12">
					<div class="full_container">
						<div class="container">
							<div class="row paddingtb40">
								<div class="col-xs-12">
									<!--signup box starts-->
									<div class="login-container login-container-message">
										<div class="position-relative">
											<div class="signup-box widget-box no-border login-box visible widget-box no-border">
												<div class="widget-body errormessagecolor">
													<div class="widget-main">
														<h1 class="bold largerr">Oop's ! </h2>
														<div class="font15">
															Detected, you are trying something wrong!
														</div>
														<div class="font15">
															Go back , or head on over to the Dashboard and try again later
														</div>
														<div class="margintop20">
															
															<?php echo $this->Html->link('<i class="icon-arrow-left"></i>Go Back',$this->request->referer(),array('class'=>'btn btn-grey newbtn','escape'=>FALSE));?>
															<?php echo $this->Html->link('<i class="icon-dashboard"></i>Landing Page',array('controller'=>'users','action'=>'login'),array('class'=>'btn btn-primary','escape'=>FALSE));?>
															<!--<a class="btn btn-primary" href="#"> <i class="icon-dashboard"></i> Dashboard </a> -->
														</div>
														<div class="margintop20">

															Please report any broken links to the <a href="mailto:admin@cantorix.com?subject=Problem in access!">Cantorix Help Team</a>
														</div>
													</div>
												</div><!-- /widget-body -->
											</div><!-- /signup-box -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.main-container -->
		<!-- basic scripts -->
		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo $this->webroot.'js/';?>jquery-2.0.3.min.js'>" + "<" + "/script>");
		</script>

		
		<script type="text/javascript">
			if ("ontouchend" in document)
				document.write("<script src='<?php echo $this->webroot.'js/';?>jquery.mobile.custom.min.js'>" + "<" + "/script>");
		</script>
		<!--custom select box js---->
		<!-- inline scripts related to this page -->
	</body>
</html>
<style>
	html, body, .container {
		height: 100%;
	}

</style>