<!DOCTYPE html>

<html lang="en" >
	<head>
		<meta charset="utf-8" />
		<title>PDLS V2</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta id="csrf-token" name="csrf-token" content="{{ csrf_token() }}">
	
		<script src="../node_modules/template/app/js/webfont.js"></script>
		<script>
			var myVar = setInterval(myTimer, 1000);
			
			function myTimer() {
				var d = new Date();
				var txt_date = d.toLocaleDateString('default', { month: 'short', day: 'numeric', year: 'numeric'});
				var txt_time = d.toLocaleTimeString();
				document.getElementById("txt_date_time").innerHTML = txt_date + ' ' + txt_time;
			}

			// WebFont.load({
			// 	google: {"families":["Montserrat:300,400,500,600,700","Roboto:300,400,500,600,700"]},
			// 	active: function() {
			// 		sessionStorage.fonts = true;
			// 		sessionStorage.fonts = true;
			// 	}
			// });
		</script>
		<link rel="stylesheet" href="../public/css/nunito_menu.css">
		<link rel="stylesheet" href="../public/css/montserrat_label.css">
		<link rel="stylesheet" href="../public/css/montserrat_small.css">
		<link rel="stylesheet" href="../public/css/montserrat_table.css">
		<link rel="stylesheet" href="../public/css/montserrat_body.css">
		<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="../node_modules/template/vendors/base/vendors.bundle.css" type="text/css" />
		<link rel="stylesheet" href="../node_modules/template/demo/demo4/base/style.bundle.css" type="text/css" />
		<link rel="stylesheet" href="../node_modules/template/assets/datepicker/datepicker3.css">
		<link rel="stylesheet" href="../node_modules/timepicker/css/gijgo.min.css">
		{{-- <link rel="stylesheet" href="../node_modules/toggle/css/toggle.min.css"> --}}	
		<link rel="stylesheet" href="../node_modules/template/assets/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="../node_modules/template/assets/css/buttons.dataTables.min.css">
		<link rel="stylesheet" href="../node_modules/template/assets/css/fixedColumns.bootstrap4.min.css">
		<link rel="stylesheet" href="../node_modules/pace/pace_corner_indicator.css">
		<link rel="stylesheet" href="../node_modules/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="../node_modules/animate/css/animate.min.css">
		<link rel="shortcut icon" href="{{ asset('icons/logo.png') }}">
		<style>

		.fade-in {
		animation: fadeIn ease 1s;
		-webkit-animation: fadeIn ease 1s;
		-moz-animation: fadeIn ease 1s;
		-o-animation: fadeIn ease 1s;
		-ms-animation: fadeIn ease 1s;
		}
		@keyframes fadeIn {
		0% {opacity:0;}
		100% {opacity:1;}
		}

		@-moz-keyframes fadeIn {
		0% {opacity:0;}
		100% {opacity:1;}
		}

		@-webkit-keyframes fadeIn {
		0% {opacity:0;}
		100% {opacity:1;}
		}

		@-o-keyframes fadeIn {
		0% {opacity:0;}
		100% {opacity:1;}
		}

		@-ms-keyframes fadeIn {
		0% {opacity:0;}
		100% {opacity:1;}
		}

		input,select,.btn
		{
			cursor:text;
			transition: transform .1s;
		}
		input:hover ,select:hover, .btn:hover
		{
			box-shadow: 0 4px 5px 0 rgba(191, 222, 255, 0.2), 0 6px 20px 0 rgba(191, 222, 255, 0.19);
			border: 1px solid #5C5962!important;
			transform: scale(1.08); 
		}

		/* .dataTables_info 
		{
			font-size:11px;
		} */
		.dataTables_filter input
		{
			font-family: custom-font-body!important;
			border-radius:5px;
		}
		.dataTables_filter input:hover 
		{
			box-shadow: 0 4px 5px 0 rgba(191, 222, 255, 0.2), 0 6px 20px 0 rgba(191, 222, 255, 0.19)!important;
			border: 1px solid #5C5962!important;
			transform: scale(1.00)!important;; 
		}
		.border-purple
		{
			box-shadow: 0 4px 5px 0 rgba(191, 222, 255, 0.2), 0 6px 20px 0 rgba(191, 222, 255, 0.19);
			border: 1px solid #384AD7!important;	
		}
		h2, h3, h4, h5, p
		{
			font-family: custom-font-label !important;
		}
		span, tspan, small
		{
			font-family: custom-font-small !important;
		}
		table, th, thead
		{
			font-family: custom-font-table !important;
		}
		tbody, td
		{
			font-family: custom-font-body !important;
			cursor:cell;
		}
		/* .thead-dark
		{
			background-color: red!important;
		} */

		.thead-dark th 
		{
		/* background-image: linear-gradient(#127AD0, #1B8BD4); */
		/* background-color:#3F7FAD!important;
		border:0px; */
		}

		/* .table-hover tbody tr:hover td, .table-hover tbody tr:hover th 
		{
		background-color: #E0F3FA;
		} */
		.border-dark
		{
			padding:15px; 
			padding-top:20px!important; 
			border-radius:10px;
			box-shadow: 0 4px 5px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
			border: 1px solid #3F3F3F!important;
			margin:10px;
		}
		label, select, .btn
		{
			font-family: custom-font-body !important;
		}
		a
		{
			font-family: custom-font;
			letter-spacing: 0.5px;
		}
		input[type="text"], input[type="file"]
		{
			font-family: custom-font-body !important;
		}
		.swal2-popup {
			font-family: custom-font-label !important;
		}
		.swal2-styled.swal2-cancel
		{
			font-family: custom-font-body !important;
		}
		.swal2-styled.swal2-confirm
		{
			font-family: custom-font-body !important;
		}
		.toast-info
		{
			font-family: custom-font-label !important;
		}
		.toast-error
		{
			font-family: custom-font-label !important;
		}
		.toast-success
		{
			font-family: custom-font-label !important;
		}
		.toast-warning
		{
			font-family: custom-font-label !important;
		}
		.dataTables_wrapper 
		{
			font-family: custom-font-small !important;
		}
		
		.accordion {
			color: #005acf;
			cursor: pointer;
			padding: 12px;
			width: 100%;
			border: none;
			text-align: left;
			outline: none;
			font-size: 15px;
			transition: 0.1s;
		}
		.active, .accordion:hover {
			background-color: #ccc; 
		}
		.panel {
			display: none;
			overflow: hidden;
		}
		.navbar-nav .nav-item > .nav-link.active  {
			color:white;
			background-color: white;
		}
		.loader {
		position: fixed;
		left: 0px;
		top: 0px;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background: url("{{ asset('icons/pulse.gif') }}")
					50% 50% no-repeat rgba(255,255,255, 0.01);;
		}
		.buttonDownload:after {
			width: 0;
			height: 0;
			margin-left: 3px;
			margin-top: -7px;
		
			border-style: solid;
			border-width: 4px 4px 0 4px;
			border-color: transparent;
			border-top-color: inherit;
			
			animation: downloadArrow 2s linear infinite;
			animation-play-state: paused;
		}
		</style>
		@yield('custom-head')
	</head>

	<body style="background-image: url(../node_modules/template/app/media/img/bg/new_bg2.png);"  class="m-page--boxed m-header--fixed m-aside--offcanvas-default">
		<div class="loader" style="background-color: #ffffff;opacity: 0.5; filter: alpha(opacity=50);"></div>
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<!-- begin::Header -->
			<header class="m-grid__item	m-grid m-grid--desktop m-grid--hor-desktop  m-header ">
				<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--hor-desktop m-container m-container--responsive m-container--xxxl">
					<div class="m-grid__item m-grid__item--fluid m-grid m-grid--desktop m-grid--ver-desktop m-header__wrapper" >
						<!-- begin::Brand -->
						<div class="m-grid__item m-brand">
							<div class="m-stack m-stack--ver m-stack--general m-stack--inline">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="" class="m-brand__logo-wrapper">
										{{-- <img alt="" src="../node_modules/template/demo/demo4/media/img/logo/logo.png"/> --}}
										<img alt="" src="../node_modules/template/app/media/img/bg/logo_.png" width="100%" height="100%">
									</a>
								</div>
							</div>
						</div>
						<!-- end::Brand -->                                        					
						<!-- begin::Topbar -->
						<div class="m-grid__item m-grid__item--fluid m-header-head" id="m_header_nav">
							<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-topbar__nav-wrapper">
									<ul class="m-topbar__nav m-nav m-nav--inline">
										<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="hover">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__username m--hidden-tablet m--hidden-mobile">
													<h5  id="txt_date_time" style="margin-top: 1%;" class="m-link"></h5>
												</span>
											</a>
										</li>
										{{-- <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" data-dropdown-toggle="click" data-dropdown-persistent="true">
											<a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
												<span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
												<span class="m-nav__link-icon">
													<span class="m-nav__link-icon-wrapper">
														<i class="flaticon-music-2"></i>
													</span>
												</span>
											</a>
										</li> --}}
										<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" data-dropdown-toggle="hover">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__welcome m--hidden-tablet m--hidden-mobile">
													<h4> Hello, &nbsp; </h4>
												</span>
												<span class="m-topbar__username m--hidden-tablet m--hidden-mobile m--padding-right-15">
													<span class="m-link">
													<h4> {{ Auth::user()['first_name'] }} &nbsp;(<span id="spn_nav_area_code">{{ Session::get('area_code') }}</span>)</h4>
												</span>
												</span>
												<span class="m-topbar__userpic">
													
													@if(Auth::user()['employee_number']=='000000')
													<img src="{{ asset('icons/default_user.png') }}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
													@else
													<img src="{{ Auth::user()['photo'] }}" class="m--img-rounded m--marginless m--img-centered" alt=""/>
													@endif
												</span>
											</a>
											<div class="m-dropdown__wrapper" style="width:250px">
												<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
												<div class="m-dropdown__inner">
													<div class="m-dropdown__header m--align-center" style="background-color:white; background-size: cover; padding-top: 15px; padding-bottom: 0px">
														<div class="m-card-user m-card-user--skin-dark">
															<div class="m-card-user__pic">
																{{-- <img src="assets/app/media/img/users/user4.jpg" class="m--img-rounded m--marginless" alt=""/> --}}
															</div>
															<div class="m-card-user__details">
																<span class="m-card-user__name m--font-weight-500" style="color: gray;">
																	<input type="hidden" id="lbl_employee_number" value="{{Auth::user()['employee_number']}}">
																		<label>{{Auth::user()['first_name']." ".Auth::user()['last_name']}} &nbsp;(<span id="spn_name_area_code">{{ Session::get('area_code') }}</span>)</label>
																</span>
																<span class="m-card-user__email m--font-weight-500" style="color: gray;">
																	<label>{{Auth::user()['position']}}</label>
																</span><br>
																<a href="" class="m-card-user__email m--font-weight-300 m-link" style="color: blue;">
																@if(Auth::user()['email']==null)
																	<label>Account has no email-address.</label>
																@else
																	<label><small>{{Auth::user()['email']}}</small></label>
																@endif
																</a>
															</div>
														</div>
													</div>
													<input type="hidden" id="txt_area_code" value="{{ Session::get('area_code') }}">
													<input type="hidden" id="txt_user_id" value="{{Auth::user()['id']}}">
													<input type="hidden" id="txt_username" value="{{Auth::user()['first_name']." ".Auth::user()['last_name']}}">		
													<input type="hidden" id="txt_support" value="{{Auth::user()['support']}}">					
													<div class="m-dropdown__body" style="padding-top: 0px; padding-bottom: 15px">
														<div class="m-dropdown__content">
															<ul class="m-nav m-nav--skin-light">
																<li class="m-nav__section m--hide">
																	<span class="m-nav__section-text" style="color: black">
																		Admin
																	</span>
																</li>
																<li class="m-nav__separator m-nav__separator--fit"></li>
																<li class="m-nav__item" style="padding-top: 0px; padding-bottom: 0px">
																	<center>
																		<a href="{{ route('logout') }}" class="m-nav__link">
																			
																			<i class="m-nav__link-icon flaticon-profile-1"></i>
																			<span class="m-nav__link-title">
																				<span class="m-nav__link-wrap">
																					<span class="m-nav__link-text">
																						<label>Log Out</label>
																					</span>
																				</span>
																			</span>
																		</a>
																	</center>
																</li>
																
																{{-- <li class="m-nav__separator m-nav__separator--fit"></li>
																<li class="m-nav__item">
																	<a href="{{ route('logout') }}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
																		<label>Logout</label>
																	</a>
																</li> --}}
															</ul>
														</div>
													</div>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<!-- end::Topbar -->
					</div>
				</div>
			</header>
			<!-- end::Header -->
			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid m-grid--hor m-container m-container--responsive m-container--xxxl">
				<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor-desktop m-grid--desktop m-body" style="box-shadow: 0px 0px 20px black;">
					<div class="m-grid__item m-body__nav" style="padding-left: 0px;padding-right: 0px;">
						<div class="m-stack m-stack--ver m-stack--desktop" style="box-shadow: 0px 0px 20px lightgray;padding-left: 32px;padding-right: 0px;">
							<!-- begin::Horizontal Menu -->
							<div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
								<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
									<i class="la la-close"></i>
								</button>
								<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
									<nav class="navbar" style="margin-top: 18px;">
									<ul class="m-menu__nav  m-menu__nav--submenu-arrow navbar-nav">
										<li class="m-menu__item  m-menu__item nav-item" data-redirect="true" aria-haspopup="true" id="dashboard">
											<a  href="{{ url('dashboard') }}" class="m-menu__link nav-link">
												<span class="m-menu__item-here"></span>
												<h3 class="m-menu__link-text">
													<b>DASHBOARD</b>
												</h3>
											</a>	
										</li>
										<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="hover" aria-haspopup="true" id="monitoring" style="display: none">
											<a  href="#" class="m-menu__link m-menu__toggle">
												<span class="m-menu__item-here"></span>
												<h3 class="m-menu__link-text">
													<b>MONITORING</b>
												</h3>
												<i class="m-menu__hor-arrow la la-angle-down"></i>
												<i class="m-menu__ver-arrow la la-angle-right"></i>
											</a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left" style="width:250px;">
												<span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav navbar-nav">
													<li class="m-menu__item nav-item"  data-redirect="true" aria-haspopup="true" id="master_data" style="display: none">
														<a  href="{{ url('master-data') }}" class="m-menu__link nav-link">
															<i class="m-menu__link-icon flaticon-chat-1"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Master Data
															</span>
														</a>
													</li>
													<li class="m-menu__item"  data-redirect="true" aria-haspopup="true" id="lead_time_data" style="display: none">
														<a  href="{{ url('leadtime-data') }}" class="m-menu__link">
															<i class="m-menu__link-icon flaticon-graphic-1"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Lead Time Data
															</span>
														</a>
													</li>
													<li class="m-menu__item"  data-redirect="true" aria-haspopup="true" id="monitoring_report" style="display: none">
														<a  href="{{ url('monitoring-report') }}" class="m-menu__link">
															<i class="m-menu__link-icon flaticon-clipboard"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Monitoring Report
															</span>
														</a>
													</li>
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="parts_status" style="display: none">
														<a  href="{{ url('parts-status') }}" class="m-menu__link ">
															<i class="m-menu__link-icon flaticon-user"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Parts Status
															</span>
														</a>
													</li>
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="delivery_data" style="display: none">
														<a  href="{{ url('delivery-data') }}" class="m-menu__link ">
															<i class="m-menu__link-icon flaticon-map"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Delivery Data
															</span>
														</a>
													</li>
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="forecast" style="display: none">
														<a  href="{{ url('forecast') }}" class="m-menu__link ">
															<i class="m-menu__link-icon flaticon-diagram"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Forecast
															</span>
														</a>
													</li>
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="picker" style="display: none">
														<a  href="{{ url('picker') }}" class="m-menu__link ">
															<i class="m-menu__link-icon flaticon-list"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Picker
															</span>
														</a>
													</li>
												</ul>
											</div>
										</li>
										<li class="m-menu__item  m-menu__item nav-item" data-redirect="true" aria-haspopup="true" id="reprint_docu" style="display: none">
											<a  href="{{ url('reprint') }}" class="m-menu__link nav-link">
												<span class="m-menu__item-here"></span>
												<h3 class="m-menu__link-text">
													<b>REPRINT DOCUMENTS</b>
												</h3>
											</a>	
										</li>
										<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="hover" data-redirect="true" aria-haspopup="true" id="irregularity" style="display: none">
											<a  href="#" class="m-menu__link m-menu__toggle">
												<span class="m-menu__item-here"></span>
												<h3 class="m-menu__link-text">
													<b>PARTS W/ IRREGULARITY</b>
												</h3>
												<i class="m-menu__hor-arrow la la-angle-down"></i>
												<i class="m-menu__ver-arrow la la-angle-right"></i>
											</a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left" style="width:200px">
												<span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav">
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="create" style="display: none">
														<a  href="{{ url('irreg-create') }}" class="m-menu__link ">
															<i class="m-menu__link-icon flaticon-chat-1"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Create
															</span>
														</a>
													</li>
													<li class="m-menu__item"  data-redirect="true" aria-haspopup="true" id="update" style="display: none">
														<a  href="{{ url('irreg-update') }}" class="m-menu__link">
															<i class="m-menu__link-icon flaticon-graphic-1"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Update
															</span>
														</a>
													</li>
												</ul>
											</div>
										</li>
										<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="hover" data-redirect="true" aria-haspopup="true" id="reports" style="display: none">
											<a  href="#" class="m-menu__link m-menu__toggle">
												<span class="m-menu__item-here"></span>
												<h3 class="m-menu__link-text">
													<b>REPORTS</b>
												</h3>
												<i class="m-menu__hor-arrow la la-angle-down"></i>
												<i class="m-menu__ver-arrow la la-angle-right"></i>
											</a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left" style="width:250px">
												<span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav">
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="leadtime_report" style="display: none">
														<a  href="{{ url('lead-time-report') }}" class="m-menu__link ">
															<i class="m-menu__link-icon flaticon-diagram"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Lead Time Report
															</span>
														</a>
													</li>
													<li class="m-menu__item"  data-redirect="true" aria-haspopup="true" id="overall_graph" style="display: none">
														<a  href="{{ url('overall-graph-report') }}" class="m-menu__link">
															<i class="m-menu__link-icon flaticon-graphic-2"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Overall Graph Report
															</span>
														</a>
													</li>
													<li class="m-menu__item"  data-redirect="true" aria-haspopup="true" id="pallet_report" style="display: none">
														<a  href="{{ url('pallet-report') }}" class="m-menu__link">
															<i class="m-menu__link-icon flaticon-map"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Pallet Report
															</span>
														</a>
													</li>
												</ul>
											</div>
										</li>
										<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="hover" aria-haspopup="true" id="transactions" style="display: none">
											<a  href="{{ url('#') }}" class="m-menu__link m-menu__toggle">
												<span class="m-menu__item-here"></span>
												<h3 class="m-menu__link-text">
													<b>TRANSACTIONS</b>
												</h3>
												<i class="m-menu__hor-arrow la la-angle-down"></i>
												<i class="m-menu__ver-arrow la la-angle-right"></i>
											</a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left" style="width:200px">
												<span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav">
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true"  onclick="$('#mod_checking_main').modal('show');" id="checking" style="display: none">
														<a href="#checking" class="m-menu__link">
															<i class="m-menu__link-icon flaticon-chat-1"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Checking
															</span>
														</a>
													</li>
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="palletizing" style="display: none">
														<a href="palletizing" class="m-menu__link">
															<i class="m-menu__link-icon flaticon-map"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Palletizing
															</span>
														</a>
													</li>
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="parts_for_dr" style="display: none">
														<a href="#mod_parts_for_dr" class="m-menu__link" onclick="$('#mod_parts_for_dr').modal('show'); PARTS_FOR_DR_MAKING.load();">
															<i class="m-menu__link-icon flaticon-graphic-1"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Parts For DR
															</span>
														</a>
													</li>
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="update_delivery" style="display: none">
														<a href="update-delivery" class="m-menu__link">
															<i class="m-menu__link-icon flaticon-users"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Update Delivery
															</span>
														</a>
													</li>
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="receiving" style="display: none">
															<a href="receiving" class="m-menu__link">
																<i class="m-menu__link-icon flaticon-download"></i>
																<span class="m-menu__link-text" style="font-family:custom-font-body">
																	Receiving
																</span>
															</a>
														</li>
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="remarks" style="display: none">
														<a href="#mod_remarks" class="m-menu__link" onclick="$('#mod_remarks').modal('show')">
															<i class="m-menu__link-icon flaticon-clipboard"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Remarks
															</span>
														</a>
													</li>
												</ul>
											</div>
										</li>
										<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="hover" data-redirect="true" aria-haspopup="true" id="managements" style="display: none">
											<a  href="#" class="m-menu__link m-menu__toggle">
												<span class="m-menu__item-here"></span>
												<h3 class="m-menu__link-text">
													<b>MANAGEMENTS</b>
												</h3>
												<i class="m-menu__hor-arrow la la-angle-down"></i>
												<i class="m-menu__ver-arrow la la-angle-right"></i>
											</a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left" style="width:250px">
												<span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav">
													<li class="m-menu__item "  data-redirect="true" aria-haspopup="true" id="user_mngt">
														<a  href="{{ url('users') }}" class="m-menu__link m-menu__toggle">
															<i class="m-menu__link-icon flaticon-users"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																User Management
															</span>
														</a>
													</li>
													<li class="m-menu__item"  data-redirect="true" aria-haspopup="true" id="email_mngt">
														<a href="#mod_email_mngt" class="m-menu__link" onclick="$('#mod_email_mngt').modal('show');">
															<i class="m-menu__link-icon flaticon-user"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Email Management
															</span>
														</a>
													</li>
													<li class="m-menu__item"  data-redirect="true" aria-haspopup="true" id="area_code_mngt">
														<a href="#mod_area_code" class="m-menu__link" onclick="$('#mod_area_code').modal('show');">
															<i class="m-menu__link-icon flaticon-user"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Area Code
															</span>
														</a>
													</li>
													<li class="m-menu__item"  data-redirect="true" aria-haspopup="true" id="destination_mngt">
														<a href="#mod_destination" class="m-menu__link" onclick="$('#mod_destination').modal('show');">
															<i class="m-menu__link-icon flaticon-map"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Destination
															</span>
														</a>
													</li>
													<li class="m-menu__item"  data-redirect="true" aria-haspopup="true" id="delivery_type_mngt">
														<a href="#mod_delivery_type" class="m-menu__link" onclick="$('#mod_delivery_type').modal('show');">
															<i class="m-menu__link-icon flaticon-clipboard"></i>
															<span class="m-menu__link-text" style="font-family:custom-font-body">
																Delivery Type
															</span>
														</a>
													</li>
												</ul>
											</div>
										</li>
										@if(Auth::user()['employee_number']=='000000')
										<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  data-menu-submenu-toggle="hover" data-redirect="true" aria-haspopup="true" id="guest-code" style="display:inline-flex">
											<a  href="#" class="m-menu__link m-menu__toggle">
												<span class="m-menu__item-here"></span>
												<h3 class="m-menu__link-text">
													<b>AREA CODE</b>
												</h3>
												<i class="m-menu__hor-arrow la la-angle-down"></i>
												<i class="m-menu__ver-arrow la la-angle-right"></i>
											</a>
											<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left" style="width:250px">
												<span class="m-menu__arrow m-menu__arrow--adjust"></span>
												<ul class="m-menu__subnav" id="guest-code-li">
													
												</ul>
											</div>
										</li>
										@endif
									</ul>
								</nav>
								</div>
							</div>
							<!-- end::Horizontal Menu -->                                                                        
						</div>
                    </div>
                    <!--Begin::Main Portlet-->
					@yield('content-page')
					@include('Transactions.parts_for_dr_making')
					@include('Transactions.remarks')
					@include('Transactions.checking')
					@include('Admin.Managements.area_code_management')
					@include('Admin.Managements.email_mngt')
					@include('Admin.Managements.delivery_type_management')
					@include('Admin.Managements.payout_area_management')
					@include('Admin.Managements.destination_management')
					@include('Admin.tracking')
                    <!--End::Main Portlet-->		
                </div>
            	</div>
        	</div>
    		</div>
		</div><br>
		<!-- begin::Body -->

		<!-- begin::Footer -->
			<audio id=notification>
				<source src={{ asset('sound/tone_rough.mp3') }}>
			</audio>
			<audio id=notification_success>
				<source src={{ asset('sound/appointed.mp3') }}>
			</audio>
			<footer class="m-grid__item		m-footer ">
				<div class="m-container m-container--responsive m-container--xxl">
					<div class="m-footer__wrapper">
						<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
							<div class="m-stack__item m-stack__item--center m-stack__item--middle m-stack__item--last">
								{{-- <span class="m-footer__copyright" style="color: black;background-color: white;box-shadow: 0px 0px 20px black;padding-left: 32px;padding-right: 32px;">
									{{-- <b><label>© Copyright 2020. All right reserved. Template by <a href="https://keenthemes.com/">Keenthemes</a></label></b> 
								</span> --}}
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>
	    <!-- begin::Scroll Top -->
		<div class="m-scroll-top m-scroll-top--skin-top" data-toggle="m-scroll-top" data-scroll-offset="500" data-scroll-speed="300">
			<i class="la la-arrow-up"></i>
		</div>
		<!-- end::Scroll Top -->	
		
		<!-- jquery latest version -->
		<script src="../node_modules/jquery/dist/jquery.min.js"></script>
		<!-- bootstrap 4 js -->
		<script src="../node_modules/popper.js/dist/popper.min.js"></script>
		{{-- <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script> --}}
		<script src="../node_modules/template/assets/js/owl.carousel.min.js"></script>
		<script src="../node_modules/moment/moment.js"></script>
		<script src="../node_modules/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    	<!-- other scripts -->
		<script src="../node_modules/template/vendors/base/vendors.bundle.js" type="text/javascript"></script>
		<script src="../node_modules/template/demo/demo4/base/scripts.bundle.js" type="text/javascript"></script>
		<script src="../node_modules/template/app/js/dashboard.js" type="text/javascript"></script>
		<script src="../node_modules/axios/dist/axios.min.js"></script>
		<script src="../node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
		<script src="../node_modules/gasparesganga-jquery-loading-overlay/dist/loadingoverlay.min.js"></script>
		<script src="../node_modules/template/assets/datepicker/bootstrap-datepicker.js"></script>
		<script src="../node_modules/template/assets/js/jquery.dataTables.min.js"></script>
		<script src="../node_modules/template/assets/js/dataTables.bootstrap4.min.js"></script>
		<script src="../node_modules/template/assets/js/dataTables.buttons.min.js"></script>
		<script src="../node_modules/template/assets/js/jquery.dataTables.rowGrouping.js"></script>
		<script src="../node_modules/template/assets/js/dataTables.fixedColumns.min.js"></script>
		
		<script src="../node_modules/template/assets/js/buttons.flash.min.js"></script>
		<script src="../node_modules/template/assets/js/buttons.html5.min.js"></script>
		<script src="../node_modules/template/assets/js/buttons.print.min.js"></script>
		<script src="../node_modules/pace/pace.min.js"></script>
		<script src="../node_modules/fontawesome/js/fontawesome.min.js"></script>
		<!-- Managements scripts -->
		<script src="../public/scripts/template.js" defer></script>
		<script src="../public/scripts/Transactions/checking.js"></script>
		<script src="../public/scripts/Admin/Managements/area_code_management.js"></script>
		<script src="../public/scripts/Admin/Managements/email_mngt.js"></script>
		<script src="../public/scripts/Admin/Managements/delivery_type_management.js"></script>
		<script src="../public/scripts/Admin/Managements/payout_area_management.js"></script>
		<script src="../public/scripts/Admin/Managements/destination_management.js"></script>
		<script src="../public/scripts/Transactions/parts_for_dr_making.js"></script>
		<script src="../public/scripts/Transactions/remarks.js"></script>
 
	

		
		<script>

			const _TOKEN = $('#csrf-token').attr('content');
	
			const swal_options = {
				title: 'Are you sure?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes',
				cancelButtonText: 'No',
				allowOutsideClick: false
			};
	
			const instance = axios.create({
				baseURL: 'http://10.164.30.173/pdls-v2/server/public/api/',
				headers: {
					'APP-KEY': 'ABCDEFGHIJK'
				}
			});

			const local = axios.create({
				baseURL: 'http://10.164.30.173/pdls-v2/client/public/api/',
			});
			
			$('.datepicker_day').datepicker({
				format: 'yyyy-mm-dd',
				startView: "day",
				startDate: '01/01/1996',
				minViewMode: "day",
				autoclose: true,
			});


			$('.datepicker_month').datepicker({
				format: "yyyy-mm",
				startView: "months", 
				minViewMode: "months",
				autoclose: true,
			});

			$('.datepicker_year').datepicker({
				format: "yyyy",
				startView: "years", 
				minViewMode: "years",
				autoclose: true,
			});

			function onlyNumberKey(evt) 
			{ 
				// Only ASCII charactar in that range allowed 
				var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
				if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
				return false; 
				return true; 
			} 
			//current date
			var today = new Date();
			m = (today.getMonth() + 1).toString().padStart(2, "0");
			d = today.getDate().toString().padStart(2, "0");
			var date_today = today.getFullYear() +'-'+ m +'-'+ d;
			var month_today = today.getFullYear() +'-'+ m;
			var year_today = today.getFullYear();

			var d_l = new Date();
			var day = d_l.getDay(),
				diff = d_l.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday
		
			var first_week  = new Date(d_l.setDate(diff));
			first_week = first_week.toISOString().substr(0,10);

			var last_week = new Date(first_week);
			last_week.setDate(last_week.getDate() + 4); //number  of days to add.
			last_week = last_week.toISOString().substr(0,10);
	
			var first_date_month = new Date(today.getFullYear(), today.getMonth(), 2);
			var last_date_month = new Date(today.getFullYear(), today.getMonth() + 1, 1);
			first_date_month = first_date_month.toISOString().substr(0,10);
			last_date_month = last_date_month.toISOString().substr(0,10);
			 
			var user_id        = $('#txt_user_id').val();
			var user_name      = $('#txt_username').val();
			var support_status = $('#txt_support').val();
			var area_code      = localStorage['area_code'];
			
			$('.timepicker').timepicker({
				uiLibrary: 'bootstrap4',
			});

			$('.navbar-nav .nav-link').click(function(){
				$('.navbar-nav .nav-link').removeClass('active');
				$(this).addClass('active');
			})

			window.paceOptions = {
			startOnPageLoad: false
			}

			
			Pace.on('start', function(){
				$('.loader').show();
				
			})
			
			Pace.start();
			Pace.on("done", function(){
				$('.loader').hide();
			
			});

		</script>
		@yield('custom-script')
	</body>
</html>
