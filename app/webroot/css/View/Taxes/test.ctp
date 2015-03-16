<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>CantoriX</title>
		<meta name="description" content="overview &amp; stats" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!-- basic styles -->

		<link href="assets/css/bootstrap.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="assets/css/font-awesome.min.css" />
		<!--[if IE 7]>
		  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!-- page specific plugin styles -->
        <link rel="stylesheet" href="assets/css/jquery-ui-1.10.3.full.min.css" />
		<!-- Needed for tabs -->

		<!-- fonts -->

		<link rel="stylesheet" href="assets/css/ace-fonts.css" />

		<!-- ace styles -->
 
		<link rel="stylesheet" href="assets/css/ace.min.css" />
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href="assets/css/template.css" />
        <link rel="stylesheet" href="assets/css/template_dashboard.css" />
        <link rel="stylesheet" href="assets/css/chosen.css" />
        <!--<link rel="stylesheet" href="assets/css/ui.jqgrid.css" />-->
        
		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->

		<script src="assets/js/ace-extra.min.js"></script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

		<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="navbar navbar-default headerbg nav_header_border" id="navbar">	
			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						 <img src="assets/images/logo_cantorix.png"  alt="Logo"/>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->
				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="assets/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									Welcome, Jason
								</span>
								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="#">
										<i class="icon-cog"></i>
										Settings
									</a>
								</li>
								<li>
									<a href="#">
										<i class="icon-user"></i>
										Profile
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="#">
										<i class="icon-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>
        <div class="full_container">
		   <div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>

				<div class="sidebar" id="sidebar">
					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
					</script>
					<ul class="nav nav-list">
						<li>
							<a href="index.html">
								<i class="icon-dashboard"></i>
								<span class="menu-text"> Dashboard </span>
							</a>
						</li>
						<li >
							<a href="#" class="dropdown-toggle">
								<i class="icon-desktop"></i>
								<span class="menu-text">Customers</span>
								<b class="arrow icon-angle-down"></b>
							</a>                            
							<ul class="submenu">								
                                <li >
									<a href="#">
										<i class="icon-double-angle-right"></i>
										Manage Customers
									</a>
								</li>
							</ul>
						</li>
                        <li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list-alt"></i>
								<span class="menu-text"> Quotes </span>

								<b class="arrow icon-angle-down"></b>
							</a>
						</li>
                         <li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-file-alt"></i>
								<span class="menu-text"> Invoices </span>

								<b class="arrow icon-angle-down"></b>
							</a>
						</li>
                         <li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-list"></i>
								<span class="menu-text"> Expenses </span>

								<b class="arrow icon-angle-down"></b>
							</a>
						</li>
                         <li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-tag"></i>
								<span class="menu-text"> Items(Inventry)</span>

								<b class="arrow icon-angle-down"></b>
							</a>
						</li>
                         <li>
							<a href="#" class="dropdown-toggle">
								<i class="icon-edit"></i>
								<span class="menu-text"> Reports </span>

								<b class="arrow icon-angle-down"></b>
							</a>
						</li>
                        
                        <li class="active">
							<a href="#" class="dropdown-toggle">
								<i class="icon-cogs"></i>
								<span class="menu-text"> Settings </span>
								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu">
							    <li >
									<a href="#">
										<i class="icon-double-angle-right"></i>
										Change Subscription
									</a>
								</li>
								<li >
									<a href="#">
										<i class="icon-double-angle-right"></i>
										Organization Profile
									</a>
								</li>
								<li>
									<a href="#">
										<i class="icon-double-angle-right"></i>
										Security
									</a>
								</li>
								<li >
									<a href="#">
										<i class="icon-double-angle-right"></i>
										Currencies
									</a>
								</li>
                                <li class="active">
									<a href="#">
										<i class="icon-double-angle-right"></i>
										Taxes
									</a>
								</li>
								<li >
									<a href="#">
										<i class="icon-double-angle-right"></i>
										Online Payment Settings
									</a>
								</li>
								<li >
									<a href="#">
										<i class="icon-double-angle-right"></i>
										Preferences
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.nav-list -->

					<div class="sidebar-collapse" id="sidebar-collapse">
						<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
					</div>

					<script type="text/javascript">
						try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
					</script>
				</div>

				<div class="main-content">
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
						</script>

						<ul class="breadcrumb">
							<li>
								<i class="icon-home home-icon"></i>
								<a href="#">Home</a>
							</li>
                            <li>								
								<a href="#">Settings</a>
							</li>
							<li class="active">Manage Tax</li>
						</ul><!-- .breadcrumb -->
					</div>

					<div class="page-content">
						<div class="page-header noborder">
							<h1>
								Manage Taxes							
							</h1>
                          
						</div>
                        <!-- /.page-header -->
                          <div class="row">
									
							<div id="tabs">
									<ul>
										<li class="addtaxes">

										<a href="#tabs-1" class="bold"><i class="taxicon"></i> <br/> Taxes</a>
										</li>

										<li class="addtaxgroups">
										<a href="#tabs-2" class="bold"><i class="taxicongroup"></i><br/>Tax Groups</a>
										</li>
										<li class="pull-right addtax buttomposition">
										 <button class="btn btn-sm btn-success pull-right addbutton ">
												<i class="icon-plus"></i>
												Add Tax	
										  </button>
										</li>
										<li class="pull-right addtaxgroup buttomposition">
										 <button class="btn btn-sm btn-success pull-right addbutton ">
												<i class="icon-plus"></i>
												Add Tax Group	
										  </button>
										</li>
									</ul>
									<div id="tabs-1">									
                                         <div class="table-header">Users List</div>
											<div class="row margin-twenty-zero">
                                            	
                                                    <div class="form-group filed-left margin-bottom-zero">
                                                        <input id="form-field-1"  type="text" placeholder="Tax Name" />
                                                    </div>
                                               		<div class="form-group filed-left margin-bottom-zero">
                                                        <input id="form-field-1"  type="text" placeholder="Tax Code" />
                                                    </div>                                                    
                                                	<div class="form-group filed-left margin-bottom-zero">
                                                        <button class="btn btn-sm btn-primary filter-btn">Filter</button>
                                                    </div>
                                            </div>
                                            
                                            <table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table">
												<thead>
													<tr>
                                                    	<th>	
                                                        	<label>
                                                                <input class="ace" type="checkbox">
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </th>													
														<th>Tax Name</th>
														<th>Tax Code</th>
														<th>Percentage</th>
														<th>Action</th>
													</tr>
												</thead>
                                                
												<tbody>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT123</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">12%</span>
                                                            <select class="on-edit"  data-placeholder="Role">
                                                                <option value="">Persentage</option>
                                                                <option value="1">Role 1</option>
                                                                <option value="2">Role 2</option>
                                                                <option value="3">Role 3</option>
                                                            </select>
                                                        </td>														
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewuser">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT123</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">12%</span>
                                                            <select class="on-edit"  data-placeholder="Role">
                                                                <option value="">Persentage</option>
                                                                <option value="1">Role 1</option>
                                                                <option value="2">Role 2</option>
                                                                <option value="3">Role 3</option>
                                                            </select>
                                                        </td>														
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewuser">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT123</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">12%</span>
                                                            <select class="on-edit"  data-placeholder="Role">
                                                                <option value="">Percentage</option>
                                                                <option value="1">Role 1</option>
                                                                <option value="2">Role 2</option>
                                                                <option value="3">Role 3</option>
                                                            </select>
                                                        </td>														
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewuser">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT123</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">12%</span>
                                                            <select class="on-edit"  data-placeholder="Role">
                                                                <option value="">Persentage</option>
                                                                <option value="1">Role 1</option>
                                                                <option value="2">Role 2</option>
                                                                <option value="3">Role 3</option>
                                                            </select>
                                                        </td>														
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewuser">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT123</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">12%</span>
                                                            <select class="on-edit"  data-placeholder="Role">
                                                                <option value="">Persentage</option>
                                                                <option value="1">Role 1</option>
                                                                <option value="2">Role 2</option>
                                                                <option value="3">Role 3</option>
                                                            </select>
                                                        </td>														
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewuser">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT123</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">12%</span>
                                                            <select class="on-edit"  data-placeholder="Role">
                                                                <option value="">Persentage</option>
                                                                <option value="1">Role 1</option>
                                                                <option value="2">Role 2</option>
                                                                <option value="3">Role 3</option>
                                                            </select>
                                                        </td>														
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewuser">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT123</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">12%</span>
                                                            <select class="on-edit"  data-placeholder="Role">
                                                                <option value="">Persentage</option>
                                                                <option value="1">Role 1</option>
                                                                <option value="2">Role 2</option>
                                                                <option value="3">Role 3</option>
                                                            </select>
                                                        </td>														
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewuser">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">VAT123</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
                                                        </td>
														<td>
                                                        	<span class="on-load">12%</span>
                                                            <select class="on-edit"  data-placeholder="Role">
                                                                <option value="">Percentage</option>
                                                                <option value="1">Role 1</option>
                                                                <option value="2">Role 2</option>
                                                                <option value="3">Role 3</option>
                                                            </select>
                                                        </td>														
														<td>
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewuser">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													
													
                                                    
                                                 </tbody>
                                            </table>
                                            <div class="row">
                                            	<div class="col-sm-6">
                                                	<div id="sample-table-2_info" class="dataTables_info">Showing 1 to 10 of 23 entries</div>
                                                </div>
                                                <div class="col-sm-6">
                                                	<div class="dataTables_paginate paging_bootstrap">
                                                    	<ul class="pagination">
                                                        	<li class="prev disabled">
                                                                <a href="#">
                                                                	<i class="icon-double-angle-left"></i>
                                                                </a>
                                                            </li>
                                                            <li class="active">
                                                            	<a href="#">1</a>
                                                            </li>
                                                            <li>
                                                            	<a href="#">2</a>
                                                            </li>
                                                            <li>
                                                            	<a href="#">3</a>
                                                            </li>
                                                            <li class="next">
                                                                <a href="#">
                                                                	<i class="icon-double-angle-right"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        
									</div>

									<div id="tabs-2">
								
                                         <div class="table-header">Users List 2</div>
											<div class="row margin-twenty-zero">
                                            	
                                                    <div class="form-group filed-left margin-bottom-zero">
                                                        <input id="form-field-1"  type="text" placeholder="Group Name" />
                                                    </div>
                                               		<div class="form-group filed-left margin-bottom-zero">
                                                        <input id="form-field-1"  type="text" placeholder="Tax Name" />
                                                    </div>                                                    
                                                	<div class="form-group filed-left margin-bottom-zero">
                                                        <button class="btn btn-sm btn-primary filter-btn">Filter</button>
                                                    </div>
                                            </div>
                                            
                                            <table id="sample-table-1" class="table table-striped table-bordered table-hover editable-table taxtable">
												<thead>
													<tr>
                                                    	<th>	
                                                        	<label>
                                                                <input class="ace" type="checkbox">
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </th>													
														<th>Group Name</th>
														<th>Tax</th>
														<th>Compounded</th>
														<th>Action</th>
													</tr>
												</thead>
                                                
												<tbody>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">Group 1</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
														    <p class="mange_group_tax_p">
														    <i class="icon-double-angle-right" style="color: #C86139;"></i>
                                                        	<span class="on-load">Service Tax(14.55%)</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p >
															<p class="mange_group_tax_p">
															<i class="icon-double-angle-right" style="color: #C86139;"></i>
                                                        	<span class="on-load">Service Tax(14.55%)</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
                                                        </td>
														<td>
														    <p class="mange_group_tax_p">
                                                        	<span class="on-load bold due">No</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
															<p class="mange_group_tax_p">
                                                        	<span class="on-load bold paid">Yes</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
                                                        </td>														
														<td class="vertcal_align_middle">
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewgruop">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">Group 2</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
														    <p class="mange_group_tax_p">
														    <i class="icon-double-angle-right" style="color: #C86139;"></i>
                                                        	<span class="on-load">Service Tax(14.55%)</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p >
															<p class="mange_group_tax_p">
															<i class="icon-double-angle-right" style="color: #C86139;"></i>
                                                        	<span class="on-load">Service Tax(14.55%)</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
															<p class="mange_group_tax_p">
															<i class="icon-double-angle-right" style="color: #C86139;"></i>
                                                        	<span class="on-load">Service Tax(14.55%)</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
                                                        </td>
														<td>
														    <p class="mange_group_tax_p">
                                                        	<span class="on-load bold due">No</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
															<p class="mange_group_tax_p">
                                                        	<span class="on-load bold paid">Yes</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
															<p class="mange_group_tax_p">
                                                        	<span class="on-load bold paid">Yes</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
                                                        </td>														
														<td class="vertcal_align_middle">
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewgruop">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">Group 3</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
														    <p class="mange_group_tax_p">
														    <i class="icon-double-angle-right" style="color: #C86139;"></i>
                                                        	<span class="on-load">Service Tax(14.55%)</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p >
															<p class="mange_group_tax_p">
															<i class="icon-double-angle-right" style="color: #C86139;"></i>
                                                        	<span class="on-load">Service Tax(14.55%)</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
                                                        </td>
														<td>
														    <p class="mange_group_tax_p">
                                                        	<span class="on-load bold due">No</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
															<p class="mange_group_tax_p">
                                                        	<span class="on-load bold paid">Yes</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
                                                        </td>														
														<td class="vertcal_align_middle">
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewgruop">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													<tr>
                                                    	<td>	
                                                        	<span class="">
                                                                <label>
                                                                    <input class="ace delete-m-row" type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                             </span>   
                                                        </td>
														<td>
                                                        	<span class="on-load">Group 4</span>
                                                            <input type="text" placeholder="Name" class="on-edit" />
                                                        </td>
														<td>
														    <p class="mange_group_tax_p">
														    <i class="icon-double-angle-right" style="color: #C86139;"></i>
                                                        	<span class="on-load">Service Tax(14.55%)</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p >
															<p class="mange_group_tax_p">
															<i class="icon-double-angle-right" style="color: #C86139;"></i>
                                                        	<span class="on-load">Service Tax(14.55%)</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
                                                        </td>
														<td>
														    <p class="mange_group_tax_p">
                                                        	<span class="on-load bold due">No</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
															<p class="mange_group_tax_p">
                                                        	<span class="on-load bold paid">Yes</span>
                                                            <input type="text" placeholder="Email" class="on-edit" />
															</p>
                                                        </td>														
														<td class="vertcal_align_middle">
															<div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
																<a href="javascript:void(0)" class="save-row on-edit" style="display:none;">
                                                                    <button class="btn btn-xs submit" title="submit">
                                                                        <i class="icon-ok bigger-120"></i>
                                                                    </button>
                                                                    <button class="btn btn-xs close-action" title="close">
                                                                        <i class="icon-remove bigger-120"></i>
                                                                    </button>
                                                                </a>
                                                                <button class="btn btn-xs btn-success view on-load" title="view" data-toggle="modal" data-target="#viewgruop">
																	<i class="icon-zoom-in bigger-120"></i>
																</button>
                                                                
																<button class="btn btn-xs btn-info edit edit-row on-load" title="edit">
																	<i class="icon-edit bigger-120"></i>
																</button>

																<button class="btn btn-xs btn-danger delete on-load delete-row" title="delete">
																	<i class="icon-trash bigger-120"></i>
																</button>
															</div>
															
														</td>
													</tr>
													
                                                 </tbody>
                                            </table>
                                            <div class="row">
                                            	<div class="col-sm-6">
                                                	<div id="sample-table-2_info" class="dataTables_info">Showing 1 to 10 of 23 entries</div>
                                                </div>
                                                <div class="col-sm-6">
                                                	<div class="dataTables_paginate paging_bootstrap">
                                                    	<ul class="pagination">
                                                        	<li class="prev disabled">
                                                                <a href="#">
                                                                	<i class="icon-double-angle-left"></i>
                                                                </a>
                                                            </li>
                                                            <li class="active">
                                                            	<a href="#">1</a>
                                                            </li>
                                                            <li>
                                                            	<a href="#">2</a>
                                                            </li>
                                                            <li>
                                                            	<a href="#">3</a>
                                                            </li>
                                                            <li class="next">
                                                                <a href="#">
                                                                	<i class="icon-double-angle-right"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            
                                      
							</div>


</div>

                          </div>  
                          
                                                                                                    
					</div><!-- /.page-content -->
				</div><!-- /.main-content -->
			</div><!-- /.main-container-inner -->

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->       
        </div>
        <div id="footer" class="footer">         
            <div class="col-md-6 pull-left paddingtb">  © Copyright CantoriX 2014, All Rights Reserved. </div>
             <div class="col-md-6 pull-left text-right paddingtb">Powered by  <a target="_blank" href="http://colorcuboid.com/">   <img alt="Color Cuboid" src="assets/images/colorcuboid.png">     ColorCuboid Designs </a></div>
        </div>

<!--Popup veiw  -->
<div class="modal fade" id="viewuser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header page-header">       
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
         <h1 class="modal-title" id="myModalLabel">View Tax</h1>    
      </div>
      <form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
      <div class="modal-body">
         <div class="model-body-inner-content">  
         			           
                  <div class="form-group login-form-group">
                    <label class="col-sm-4 no-padding-top">Tax Name </label>    
                    <div class="col-sm-8">
                      <p class="bold">VAT</p>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 no-padding-top"> Tax Code </label>   
                    <div class="col-sm-8">
                      <p class="bold">VAT123</p>
                    </div>
                  </div> 
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 no-padding-top"> Percentage</label>   
                    <div class="col-sm-8">
                      <p class="bold">12.00%</p>
                    </div>
                  </div>                    
          </div>
      </div>
      <div class="modal-footer">           
      </div>
      </form>
    </div>
  </div>
</div>
<!--end of pop-->  
<!--Popup veiw group  -->
<div class="modal fade" id="viewgruop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header page-header">       
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>   
         <h1 class="modal-title" id="myModalLabel">View Tax Group</h1>    
      </div>
      <form class="form-horizontal popup" role="form" id="addnewcurrency" method="POST">
      <div class="modal-body">
         <div class="model-body-inner-content">  
         			           
                  <div class="form-group login-form-group">
                    <label class="col-sm-4 no-padding-top">Group Name </label>    
                    <div class="col-sm-8">
                      <p class="bold">Group 1</p>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 no-padding-top"> Taxes </label>   
                    <div class="col-sm-8">
                      <p class="bold">Service Tax (14.55%)</p>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 no-padding-top"></label>   
                    <div class="col-sm-8">
                      <p>Priority <span class="bold">1</span></p>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 no-padding-top"></label>   
                    <div class="col-sm-8">
                      <p>Coumbounded <span class="bold due">No</span></p>
                    </div>
                  </div>  				  
				   <div class="form-group login-form-group"> 
                    <label class="col-sm-4 no-padding-top"> Taxes </label>   
                    <div class="col-sm-8">
                      <p class="bold">Service Tax (14.55%)</p>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 no-padding-top"></label>   
                    <div class="col-sm-8">
                      <p >Priority <span class="bold">2</span></p>
                    </div>
                  </div>
                  <div class="form-group login-form-group"> 
                    <label class="col-sm-4 no-padding-top"></label>   
                    <div class="col-sm-8">
                      <p >Coumbounded <span class="bold paid">Yes</span></p>
                    </div>
                  </div> 
                                                            
                                             
          </div>
      </div>
      <div class="modal-footer">
           
      </div>
      </form>
    </div>
  </div>
</div>
<!--end of pop-->              
		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/typeahead-bs2.min.js"></script>

		<!-- page specific plugin scripts -->

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->

		
		<script src="assets/js/jquery-ui-1.10.3.full.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
                <script src="assets/js/jquery.slimscroll.min.js"></script>
		<script src="assets/js/jquery.easy-pie-chart.min.js"></script>
		<script src="assets/js/jquery.sparkline.min.js"></script>
                <script src="assets/js/flot/jquery.flot.min.js"></script>
                <script src="assets/js/flot/jquery.flot.pie.min.js"></script>
		<script src="assets/js/flot/jquery.flot.resize.min.js"></script>
		<script src="assets/js/chosen.jquery.min.js"></script>
                <script src="assets/js/admin_dashboard_js.js"></script>
                <script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			
			jQuery(function($) {
				jQuery(".chosen-select").chosen();
				
			});
			
			$(document).ready(function(){
				$( "#tabs" ).tabs();
				$('.ui-tabs-nav .ui-state-default.ui-corner-top').click(function(){					
				 if($(this).hasClass('addtaxes'))
				 { 
				   $('.addtax').css('display','block');
				   $('.addtaxgroup').css('display','none');
				 }
				 else
				 {
				  $('.addtaxgroup').css('display','block');
				  $('.addtax').css('display','none');
				 }
				});
			})
			
			
		</script>
        
	</body>
</html>