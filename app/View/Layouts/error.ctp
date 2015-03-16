<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Cantorix');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $this->Html->charset(); ?>
<meta charset="utf-8" />
<?php 
	echo '<title>'.$cakeDescription.':'.$title_for_layout.'</title>';
	echo $this->Html->meta('favicon.ico','/favicon.ico',array('type'=>'icon'));		
	echo $this->Html->css(array('bootstrap.min','font-awesome.min','ace-fonts','ace.min','template','template_dashboard'));
?>
</head>
<body class="whitebgg errorpage">
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
												<?php echo $this->fetch('content'); ?>
											</div>
											<!-- /widget-body -->
										</div>
										<!-- /signup-box -->
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
			window.jQuery || document.write("<script src='<?php echo $this->webroot.'js/' ; ?>jquery-2.0.3.min.js'>"+"<"+"/script>");
	</script>

	

	<!-- <![endif]-->

	<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
	<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='<?php echo $this->webroot.'js/' ; ?>jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
	<!--custom select box js---->
	<!-- inline scripts related to this page -->

</body>
</html>
<style>
html,body,.container {
	height: 100%;
}
</style>
