<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>
		@stack('styles')
		<style>
			.form-required:after {
			  content:"*";
			  color:red;
			}
		
			#toast-container > .toast-success {
				
				background-color: #4BB543;
				color: white;
			}
		
			#toast-container > .toast-warning {
				
				background-color: #ff9900;
				color: white;
			}
			
			#toast-container > .toast-error {
				
				background-color: #F32013;
				color: white;
			}
		
			.main-sidebar-header .desktop-logo {
				display: flex;
				align-items: center;
			}
			.main-sidebar-header .desktop-logo .logo-img {
				height: 36px;
				width: 36px;
				object-fit: contain;
			}
			.main-sidebar-header .desktop-logo .logo-text {
				margin-left: 10px;
				font-weight: 700;
				font-size: 15px;
				line-height: 1.2;
				white-space: nowrap;
			}
			.main-sidebar-header .desktop-logo.logo-light .logo-text { color: #1a2b4a; }
			.main-sidebar-header .desktop-logo.logo-dark .logo-text { color: #fff; }
			.main-sidebar-header .desktop-logo .logo-text .text-accent { color: #0074d9; }
			.main-sidebar-header .logo-icon.mobile-logo img.logo-icon {
				height: 2.8rem;
				width: 2.8rem;
				object-fit: contain;
			}
			.responsive-logo img.logo-1,
			.responsive-logo img.dark-logo-1 {
				height: 2.5rem;
				width: auto;
				max-width: 150px;
				object-fit: contain;
			}
			.responsive-logo img.logo-2,
			.responsive-logo img.dark-logo-2 {
				height: 2.5rem;
				width: 2.5rem;
				object-fit: contain;
			}
		</style>
		<!-- Title -->
		<title>  Student Portal </title>

		<!-- Favicon -->
		<link rel="icon" href="{{asset('assets/img/logo/small_logo.png')}}" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">

		<!--  Right-sidemenu css -->
		<link href="{{asset('assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
		{{-- datatables --}}
		<link href="{{asset('/assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

		<!-- P-scroll bar css-->
		<link href="{{asset('assets/plugins/perfect-scrollbar/p-scrollbar.css')}}" rel="stylesheet" />

		<!--  Left-Sidebar css -->
		<link rel="stylesheet" href="{{asset('assets/css/sidemenu.css')}}">

		<!--- Style css --->
		<link href="{{asset('assets/css/style.css')}}" rel="stylesheet">

		<!--- Dark-mode css --->
		<link href="{{asset('assets/css/style-dark.css')}}" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="{{asset('assets/css/skin-modes.css')}}" rel="stylesheet" />

		<!--- Animations css-->
		<link href="{{asset('assets/css/animate.css')}}" rel="stylesheet">
	
		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
		<link href="{{asset('assets/css/bootstrap-select.min.css')}}" rel="stylesheet">
		<!-- <link href="{{asset('assets/css/summernote.min.css')}}" rel="stylesheet"> -->
		<link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet">


		<script>
			(function(){var t=localStorage.getItem('theme');if(t==='dark')document.documentElement.classList.add('dark-theme-pending');})();
		</script>
	</head>

	<body class="main-body app sidebar-mini">
		<script>
			if(document.documentElement.classList.contains('dark-theme-pending')){document.body.classList.add('dark-theme');document.documentElement.classList.remove('dark-theme-pending');}
		</script>

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<!-- main-sidebar -->
			<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
			<aside class="app-sidebar sidebar-scroll">
				<div class="main-sidebar-header active">
					<a class="desktop-logo logo-light active" href="index.html"><img src="{{asset('assets/img/logo/small_logo.png')}}" class="logo-img" alt="logo"><span class="logo-text">The Student <span class="text-accent">Portal</span></span></a>
					<a class="desktop-logo logo-dark active" href="index.html"><img src="{{asset('assets/img/logo/small_logo_dark.png')}}" class="logo-img" alt="logo"><span class="logo-text">The Student <span class="text-accent">Portal</span></span></a>
					<a class="logo-icon mobile-logo icon-light active" href="index.html"><img src="{{asset('assets/img/logo/small_logo.png')}}" class="logo-icon" alt="logo"></a>
					<a class="logo-icon mobile-logo icon-dark active" href="index.html"><img src="{{asset('assets/img/logo/small_logo_dark.png')}}" class="logo-icon" alt="logo"></a>
				</div>
				<div class="main-sidemenu">
					<div class="app-sidebar__user clearfix">
						<div class="dropdown user-pro-body">
							<div class="">
								<img alt="user-img" class="avatar avatar-xl brround" src="{{asset('uploads/teacher_avatars/').'/'.Auth::user()->avatar}}"><span class="avatar-status profile-status bg-green"></span>
							</div>
							<div class="user-info">
								<h4 class="font-weight-semibold mt-3 mb-0 text-capitalize	">{{Auth::user()->name}}</h4>
								<span class="mb-0 text-muted">Admin</span>
							</div>
						</div>
					</div>
					<ul class="side-menu">
						<li class="side-item side-item-category">Main</li>
						<li class="slide">
							<a class="side-menu__item" href="{{route('home')}}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">Index</span></a>
						
						</li>
						<li class="side-item side-item-category">Managment</li>
						<li class="slide">
							<a class="side-menu__item" href="{{route('all-schools')}}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon"  viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v4H5zm10 10h4v4h-4zM5 15h4v4H5zM16.66 4.52l-2.83 2.82 2.83 2.83 2.83-2.83z" opacity=".3"/><path d="M16.66 1.69L11 7.34 16.66 13l5.66-5.66-5.66-5.65zm-2.83 5.65l2.83-2.83 2.83 2.83-2.83 2.83-2.83-2.83zM3 3v8h8V3H3zm6 6H5V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm8-2v8h8v-8h-8zm6 6h-4v-4h4v4z"/></svg><span class="side-menu__label">Schools</span></a>
						</li>

					</ul>
				</div>
			</aside>
			<!-- main-sidebar -->

			<!-- main-content -->
			<div class="main-content app-content">

				<!-- main-header -->
				<div class="main-header sticky side-header nav nav-item">
					<div class="container-fluid">
						<div class="main-header-left ">
							<div class="responsive-logo">
								<a href="index.html"><img src="{{asset('assets/img/logo/small_logo.png')}}" class="logo-1" alt="logo"></a>
								<a href="index.html"><img src="{{asset('assets/img/logo/small_logo_dark.png')}}" class="dark-logo-1" alt="logo"></a>
								<a href="index.html"><img src="{{asset('assets/img/logo/small_logo.png')}}" class="logo-2" alt="logo"></a>
								<a href="index.html"><img src="{{asset('assets/img/logo/small_logo_dark.png')}}" class="dark-logo-2" alt="logo"></a>
							</div>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>
							<div class="main-header-center ml-3 d-sm-none d-md-none d-lg-block">
								<input class="form-control" placeholder="Search for anything..." type="search"> <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
							</div>
						</div>
						<div class="main-header-right">
						
							<div class="nav nav-item  navbar-nav-right ml-auto">
								<div class="nav-link" id="bs-example-navbar-collapse-1">
									<form class="navbar-form" role="search">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Search">
											<span class="input-group-btn">
												<button type="reset" class="btn btn-default">
													<i class="fas fa-times"></i>
												</button>
												<button type="submit" class="btn btn-default nav-link resp-btn">
													<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
												</button>
											</span>
										</div>
									</form>
								</div>
								
								<div class="dropdown nav-item main-header-notification">
									<a class="new nav-link" href="#">
									<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class=" pulse"></span></a>
									<div class="dropdown-menu">
										<div class="menu-header-content bg-primary text-left">
											<div class="d-flex">
												<h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">Notifications</h6>
												<span class="badge badge-pill badge-warning ml-auto my-auto float-right">Mark All Read</span>
											</div>
											<p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4 unread Notifications</p>
										</div>
										<div class="main-notification-list Notification-scroll">
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-pink">
													<i class="la la-file-alt text-white"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">New files available</h5>
													<div class="notification-subtext">10 hour ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
											<a class="d-flex p-3" href="#">
												<div class="notifyimg bg-purple">
													<i class="la la-gem text-white"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">Updates Available</h5>
													<div class="notification-subtext">2 days ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-success">
													<i class="la la-shopping-basket text-white"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">New Order Received</h5>
													<div class="notification-subtext">1 hour ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-warning">
													<i class="la la-envelope-open text-white"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">New review received</h5>
													<div class="notification-subtext">1 day ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-danger">
													<i class="la la-user-check text-white"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">22 verified registrations</h5>
													<div class="notification-subtext">2 hour ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-primary">
													<i class="la la-check-circle text-white"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">Project has been approved</h5>
													<div class="notification-subtext">4 hour ago</div>
												</div>
												<div class="ml-auto" >
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
										</div>
										<div class="dropdown-footer">
											<a href="">VIEW ALL</a>
										</div>
									</div>
								</div>
								<div class="nav-item main-header-notification">
									<a class="new nav-link theme-toggle" href="#">
										<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs theme-icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
										<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs theme-icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="4.22" x2="19.78" y2="5.64"></line></svg>
									</a>
								</div>
								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
									<a class="nav-link pr-0" data-toggle="sidebar-right" data-target=".sidebar-right">
										<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
									</a>
									<div class="dropdown-menu">
										<div class="main-header-profile bg-primary p-3">
											<div class="d-flex wd-100p">
												<div class="main-img-user"><img alt="" src="{{asset('uploads/teacher_avatars/').'/'.Auth::user()->avatar}}" class=""></div>
												<div class="ml-3 my-auto">
													<h6>{{Auth::user()->name}}</h6><span>Admin</span>
												</div>
											</div>
										</div>
				
										<a class="dropdown-item" href="{{ route('logout') }}"><i class="bx  bx-cog"></i>Edit profile</a>
										<a class="dropdown-item" href="{{ route('logout') }}"
											onclick="event.preventDefault();document.getElementById('logout-form').submit();">
											<i class="bx bx-log-out"></i>Logout
										</a>
									</div>
								</div>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
									@csrf
								</form>
							
							</div>
						</div>
					</div>
				</div>
				<!-- /main-header -->

				<!-- container -->
				<div class="container-fluid">

					<!-- row -->
					
            			@yield('content')
					<!-- row closed -->
				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

			<!-- Footer opened -->
			<div class="main-footer ht-40">
				<div class="container-fluid pd-t-0-f ht-100p">
					<!-- <span>Copyright © 2020 <a href="#">Valex</a>. Designed by <a href="https://www.spruko.com/">Spruko</a> All rights reserved.</span> -->
				</div>
			</div>
			<!-- Footer closed -->

		</div>
		<!-- End Page -->
		<div class="modal" id="please_wait">
			<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
				<div class="modal-content tx-size-sm">
				<div class="modal-body tx-center pd-y-20 pd-x-20">
					{{-- <i class="  lh-1 mg-t-20 d-inline-block"></i> --}}
					<img src="{{asset('assets/img/loader.svg')}}"  width="50" height="50" alt="Please wait">
					<br>
					<p class="mg-b-20 mg-x-20 mt-2"> Please Wait</p>
				</div>
				</div>
			</div>
		</div>
		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

		<!-- JQuery min js -->
		<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
		
		<!-- Global AJAX Setup for CSRF Token -->
		<script>
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		</script>

		<!-- Bootstrap Bundle js -->
		<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

		<!-- Ionicons js -->
		<script src="{{asset('assets/plugins/ionicons/ionicons.js')}}"></script>

		<!-- Moment js -->
		<script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

		<!-- P-scroll js -->
		<script src="{{asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
		<script src="{{asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>

		<!-- Sticky js -->
		<script src="{{asset('assets/js/sticky.js')}}"></script>

		<!-- eva-icons js -->
		<script src="{{asset('assets/js/eva-icons.min.js')}}"></script>

		<!-- Rating js-->
		<script src="{{asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
		<script src="{{asset('assets/plugins/rating/jquery.barrating.js')}}"></script>

		<!-- Sidebar js -->
		<script src="{{asset('assets/plugins/side-menu/sidemenu.js')}}"></script>

		<!-- Right-sidebar js -->
		<script src="{{asset('assets/plugins/sidebar/sidebar.js')}}"></script>
		<script src="{{asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>

		<!-- custom js -->
		<script src="{{asset('assets/js/custom.js')}}"></script>

		{{-- axios --}}
		<script src="{{asset('assets/js/axios.min.js')}}"></script>
		
		<!-- Configure Axios with CSRF Token -->
		<script>
			axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
			axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
		</script>
	
		{{-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> --}}
		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>

		<script src="{{asset('assets/js/bootstrap-select.js')}}"></script>
		<script src="{{asset('assets/js/summernote.js')}}"></script>
		<script src="{{asset('assets/js/sweetalert.js')}}"></script>
		<script src="{{asset('assets/js/toastr.js')}}"></script>
	  <script>
	$(document).ready(function() {
		$('.summernote').summernote({
		height: 200,
		codemirror: { // codemirror options
			theme: 'monokai'
		}
		});
	});
	
	</script>



		@stack('javascript');

		<script>
		(function(){
			var toggle = document.querySelector('.theme-toggle');
			var moon = toggle ? toggle.querySelector('.theme-icon-moon') : null;
			var sun = toggle ? toggle.querySelector('.theme-icon-sun') : null;
			function applyIcon(){
				if(!moon||!sun) return;
				var isDark = document.body.classList.contains('dark-theme');
				moon.style.display = isDark ? 'none' : '';
				sun.style.display = isDark ? '' : 'none';
			}
			applyIcon();
			if(toggle){
				toggle.addEventListener('click', function(e){
					e.preventDefault();
					document.body.classList.toggle('dark-theme');
					localStorage.setItem('theme', document.body.classList.contains('dark-theme') ? 'dark' : 'light');
					applyIcon();
				});
			}
		})();
		</script>
	</body>
</html>