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
 * @author        Ganesh
 */

$cakeDescription = __d('cake_dev', 'CantoriX');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<meta charset="utf-8" />
	<title>
		<?php //$title_for_layout = 'Login Page - Ace Admin'; 
		?>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>	
	<meta name="description" content="User login page" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />		
	<?php
		echo $this->Html->meta('favicon.ico');		
		echo $this->Html->css(array('bootstrap.min','font-awesome.min','ace-fonts','ace.min','template','customresponsive','bootstrap-select'));
	?>
	<?php
	   	echo $this->Html->script(array('jquery-2.0.3.min.js','bootstrap.min.js','jquery.validate.min.js','commonjs.js','timezone_detect.js','bootstrap-select.js'));
	?>
</head>
<body>
	<div id="container">		
	    <div id="header" role="navigation" class="navbar navbar-default navbar-fixed-top headerbg nav_header_border">
         	<div class="container">
       			  <div clas="logonew">
       			  	<?php echo $this->Html->link($this->Html->image("logo.png",array('alt'=>'logo')),array('controller'=>'users','action'=>'login'),array('escape'=>FALSE));?>                  	
                  </div>
       		</div>            
        </div>  
		
		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		
		
	</div>
	<div id="footer" class="footer">
			<div class="container">
            <div class="col-md-12 pull-left paddingtb col-lg-6 col-sm-12 col-xs-12">  © Copyright CantoriX 2014, All Rights Reserved. </div>             
          </div>
		</div>
	<script type="text/javascript">
		if("ontouchend" in document) document.write("<script src='<?php echo $this->webroot.'js/';?>jquery.mobile.custom.min.js'>"+"<"+"/script>");
	</script>
	<script type="text/javascript">
		window.jQuery || document.write("<script src='<?php echo $this->webroot.'js/';?>jquery-2.0.3.min.js'>"+"<"+"/script>");
	</script>
</body>
</html>