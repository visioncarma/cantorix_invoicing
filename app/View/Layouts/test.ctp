
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
			<?php echo $cakeDescription ?>:
			<?php echo $title_for_layout; ?>
		</title>	
		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />	
			
		<?php
			echo $this->Html->meta('favicon.ico','/favicon.ico',array('type'=>'icon'));	
			echo $this->Html->css(array('bootstrap.min','font-awesome.min','ace-fonts','ace.min','ace-rtl','ace-skins','template','bootstrap-select','template_dashboard','chosen','customresponsive.css','datepicker.css'));
		?>
		<?php
	   		echo $this->Html->script(array('jquery-2.0.3.min.js','jquery-ui-1.10.3.custom.min.js','bootstrap.min.js','typeahead-bs2.min.js','ace-elements.min.js','ace.min.js','jquery.validate.min.js','ace-extra.min.js','chosen.jquery.min.js','bootstrap-select.js','bootstrap-datepicker.min.js','jquery.placeholder.js'));
		?>
		<script type="text/javascript" src="">
			window.jQuery || document.write("<script src=<?php $this->webroot."jquery-2.0.3.min.js"?>>"+"<"+"/script>");
		</script>
		<!--<script type="text/javascript" src="">
			if("ontouchend" in document) document.write("<script src=<?php echo $this->webroot ?>"jquery.mobile.custom.min.js">""</script>");
		</script>-->
		
		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		
	</head>
	<body>
		<?php $menus = $this->Session->read('Auth.User.Menus');?>
		<div class="navbar navbar-default headerbg nav_header_border" id="navbar">	
			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<?php 
						$homeLink = $this->Breadcrumb->getLink('Home');
					?>
					<?php echo $this->Html->link($this->Html->image('logo_cantorix.png',array('alt'=>'logo')),"$homeLink",array('escape'=>FALSE));?>
					<!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<?php $profile_pic=$this->requestAction('subscribers/getuserpic');?>
								<?php if($profile_pic['User']['profile_picture_path']){?>
								<img class="nav-user-photo" src="<?php echo $this->webroot.'/'.$profile_pic['User']['profile_picture_path'];?>"  alt="profilepic"/>
								<?php }else{
									echo $this->Html->image('avatar2.png',array('class'=>'nav-user-photo'));
								} ?>
								<span class="user-info">
									Welcome, <?php echo $profile_pic['User']['firstname']; ?>
								</span>
								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								
								<li>
									<?php echo $this->Html->link('<i class="icon-user"></i>Profile',array('controller'=>'subscribers','action'=>'user_profile'),array('escape'=>FALSE));?>
								</li>
								<li class="divider"></li>
								<li>
									<?php echo $this->Html->link('<i class="icon-off"></i>Logout',array('controller'=>'users','action'=>'logout'),array('escape'=>FALSE));?>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>
        <div class="full_container">
		   <div class="main-container" id="main-container">
			<script type="text/javascript" src="">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<div class="sidebar" id="sidebar">
					<script type="text/javascript" src="">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>
					<ul class="nav nav-list">
						<?php foreach($menus['Menus'] as $topMenu):?>
							<?php $appendthis=NULL; $aClass=NULL;
								if(!empty($topMenu['childMenu'])){
									$appendthis = '<b class="arrow icon-angle-down"></b>';
									$aClass = "dropdown-toggle";
							}?>
							<?php if($topMenu['Aco']['alias'] == 'Dashboard') {?>
								<li class="<?php echo $dashboardActive;?>">
									<?php echo $this->Html->link('<i class="icon-dashboard"></i><span class="menu-text">'.$topMenu['Aco']['alias'].'</span>'.$appendthis,$topMenu['Aco']['url'],array('escape'=>FALSE,'class'=>$aClass));?>
									<?php if(!empty($topMenu['childMenu'])):?>
										<ul class="submenu">
										<?php foreach($topMenu['childMenu'] as $childMenu):?>
											<li class="active">
												<?php echo $this->Html->link('<i class="icon-double-angle-right"></i>'.$childMenu['Aco']['alias'],$childMenu['Aco']['url'],array('escape'=>FALSE));?>
											</li>
										<?php endforeach;?>
										</ul>
									<?php endif;?>
								</li>
							<?php }?>
							<?php if($topMenu['Aco']['alias'] == 'Manage Subscription') {?>
								<li class="<?php echo $subscriptionActive;?>">
									<?php echo $this->Html->link('<i class="icon-list"></i><span class="menu-text">'.$topMenu['Aco']['alias'].'</span>'.$appendthis,$topMenu['Aco']['url'],array('escape'=>FALSE,'class'=>$aClass));?>
									<?php if(!empty($topMenu['childMenu'])):?>
										<ul class="submenu">
										<?php foreach($topMenu['childMenu'] as $childMenu): $childActive=NULL;?>
											<?php if($childMenu['Aco']['alias'] == $menuActive) {
												$childActive = 'active';
											}?>
											<li class="<?php echo $childActive;?>">
												<?php echo $this->Html->link('<i class="icon-double-angle-right"></i>'.$childMenu['Aco']['alias'],$childMenu['Aco']['url'],array('escape'=>FALSE));?>
											</li>
										<?php endforeach;?>
										</ul>
									<?php endif;?>
								</li>
							<?php }?>
							<?php if($topMenu['Aco']['alias'] == 'Settings') {?>
								<li class="<?php echo $settingsActive;?>">
									<?php echo $this->Html->link('<i class="icon-cogs"></i><span class="menu-text">'.$topMenu['Aco']['alias'].'</span>'.$appendthis,"#",array('escape'=>FALSE,'class'=>$aClass));?>
									<?php if(!empty($topMenu['childMenu'])):?>
										<ul class="submenu">
										<?php foreach($topMenu['childMenu'] as $childMenu): $childActive=NULL;?>
											<?php if($childMenu['Aco']['alias'] == $menuActive) {
												$childActive = 'active';
											}?>
											<li class="<?php echo $childActive;?>">
												<?php echo $this->Html->link('<i class="icon-double-angle-right"></i>'.$childMenu['Aco']['alias'],$childMenu['Aco']['url'],array('escape'=>FALSE));?>
											</li>
										<?php endforeach;?>
										</ul>
									<?php endif;?>
								</li>
							<?php }?>
						<?php endforeach;?>
						</ul>
						</li>
					</ul><!-- /.nav-list -->
					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>
					<script type="text/javascript" src="">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>

				<div class="main-content" id = "content">
						<?php echo $this->Session->flash(); ?>
						<?php echo $this->fetch('content'); ?>
				</div><!-- /.main-content -->
			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->       
        </div>
        <div id="footer" class="footer">         
            <div class="col-md-12 pull-left paddingtb col-lg-6 col-sm-12 col-xs-12">  <?php echo "© Copyright CantoriX 2014, All Rights Reserved.";?> </div>           
        </div>
	</body>
</html>