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
		echo $this->Html->meta('favicon.ico','/favicon.ico',array('type'=>'icon'));		
		echo $this->Html->css(array('bootstrap.min','font-awesome.min','ace-fonts','ace.min','template'));
	?>
	<?php
	   	echo $this->Html->script(array('jquery-2.0.3.min.js','bootstrap.min.js','jquery.validate.min.js','commonjs.js','timezone_detect.js'));
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link('Home', '/'); ?></h1>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer" class="footer">
			<div class="container">
            <div class="col-md-6 pull-left paddingtb">  © Copyright CantoriX 2014, All Rights Reserved. </div>
             <div class="col-md-6 pull-left text-right paddingtb">Powered by  <?php echo $this->Html->link($this->Html->image('colorcuboid.png',array('alt'=>'ColorCuboid Designs')).'ColorCuboid Designs',"http://colorcuboid.com/",array('target'=>'_blank','escape'=>FALSE));?></div>
          </div>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
