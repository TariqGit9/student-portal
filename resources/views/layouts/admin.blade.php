<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
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
			.selectpicker-custome-color{
				
					color: #242f48;
					background-color: #e9e7f5;
					border-color: #e9e7f5;
				

			}
		</style>
		<!-- Title -->
		<title> {{$school_info->name}} Student Portal </title>

		<!-- Favicon -->
		<link rel="icon" href="{{asset('assets/img/brand/favicon.png')}}" type="image/x-icon"/>

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

		<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
	
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
		 -->
		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
		<link href="{{asset('assets/css/bootstrap-select.min.css')}}" rel="stylesheet">
		<!-- <link href="{{asset('assets/css/summernote.min.css')}}" rel="stylesheet"> -->
		<link href="{{asset('assets/css/toastr.min.css')}}" rel="stylesheet">



	</head>

	<body class="main-body app sidebar-mini">

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
					<a class="desktop-logo logo-light active" href="index.html"><img src="{{asset('assets/img/brand/logo.png')}}" class="main-logo" alt="logo"></a>
					<a class="desktop-logo logo-dark active" href="index.html"><img src="{{asset('assets/img/brand/logo-white.png')}}" class="main-logo dark-theme" alt="logo"></a>
					<a class="logo-icon mobile-logo icon-light active" href="index.html"><img src="{{asset('assets/img/brand/favicon.png')}}" class="logo-icon" alt="logo"></a>
					<a class="logo-icon mobile-logo icon-dark active" href="index.html"><img src="{{asset('assets/img/brand/favicon-white.png')}}" class="logo-icon dark-theme" alt="logo"></a>
				</div>
				<div class="main-sidemenu">
					<div class="app-sidebar__user clearfix">
						<div class="dropdown user-pro-body">
							<div class="">
								<img alt="user-img" class="avatar avatar-xl brround" src="{{asset('uploads/teacher_avatars/').'/default.webp'}}"><span class="avatar-status profile-status bg-green"></span>
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
						<li class="slide">
							<a class="side-menu__item" href="{{route('all-branches')}}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 9h14V5H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5S7.83 8.5 7 8.5 5.5 7.83 5.5 7 6.17 5.5 7 5.5zM5 19h14v-4H5v4zm2-3.5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5z" opacity=".3"/><path d="M20 13H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1v-6c0-.55-.45-1-1-1zm-1 6H5v-4h14v4zm-12-.5c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5-1.5.67-1.5 1.5.67 1.5 1.5 1.5zM20 3H4c-.55 0-1 .45-1 1v6c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zm-1 6H5V5h14v4zM7 8.5c.83 0 1.5-.67 1.5-1.5S7.83 5.5 7 5.5 5.5 6.17 5.5 7 6.17 8.5 7 8.5z"/></svg><span class="side-menu__label">School Branch</span></a>
						</li>
						<li class="side-item side-item-category">User Managment</li>
						<li class="slide">
							<a class="side-menu__item" href="{{route('all-teachers')}}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"/><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/></svg><span class="side-menu__label">Teachers</span></a>
						</li>
						<li class="slide">
							<a class="side-menu__item"  href="{{route('all-students')}}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon"  viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm3.5 4c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5zm-7 0c.83 0 1.5.67 1.5 1.5S9.33 11 8.5 11 7 10.33 7 9.5 7.67 8 8.5 8zm3.5 9.5c-2.33 0-4.32-1.45-5.12-3.5h1.67c.7 1.19 1.97 2 3.45 2s2.76-.81 3.45-2h1.67c-.8 2.05-2.79 3.5-5.12 3.5z" opacity=".3"/><circle cx="15.5" cy="9.5" r="1.5"/><circle cx="8.5" cy="9.5" r="1.5"/><path d="M12 16c-1.48 0-2.75-.81-3.45-2H6.88c.8 2.05 2.79 3.5 5.12 3.5s4.32-1.45 5.12-3.5h-1.67c-.69 1.19-1.97 2-3.45 2zm-.01-14C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/></svg><span class="side-menu__label">Students</span></a>
						
						</li>

						<li class="side-item side-item-category">Genral Managment</li>
						<li class="slide">
							<a class="side-menu__item"  href="{{route('classes')}}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3"/><path d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z"/></svg><span class="side-menu__label">Classes</span></a>
						
						</li>
						<li class="slide">
							<a class="side-menu__item" href="{{route('grades')}}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon"  viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v4H5zm10 10h4v4h-4zM5 15h4v4H5zM16.66 4.52l-2.83 2.82 2.83 2.83 2.83-2.83z" opacity=".3"/><path d="M16.66 1.69L11 7.34 16.66 13l5.66-5.66-5.66-5.65zm-2.83 5.65l2.83-2.83 2.83 2.83-2.83 2.83-2.83-2.83zM3 3v8h8V3H3zm6 6H5V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm8-2v8h8v-8h-8zm6 6h-4v-4h4v4z"/></svg><span class="side-menu__label">Grades</span></a>
						</li>
						<li class="slide">
							<a class="side-menu__item"  href="{{route('subjects')}}"><svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" class="side-menu__icon" viewBox="0 0 24 24" ><g><rect fill="none"/></g><g><g/><g><path d="M21,5c-1.11-0.35-2.33-0.5-3.5-0.5c-1.95,0-4.05,0.4-5.5,1.5c-1.45-1.1-3.55-1.5-5.5-1.5S2.45,4.9,1,6v14.65 c0,0.25,0.25,0.5,0.5,0.5c0.1,0,0.15-0.05,0.25-0.05C3.1,20.45,5.05,20,6.5,20c1.95,0,4.05,0.4,5.5,1.5c1.35-0.85,3.8-1.5,5.5-1.5 c1.65,0,3.35,0.3,4.75,1.05c0.1,0.05,0.15,0.05,0.25,0.05c0.25,0,0.5-0.25,0.5-0.5V6C22.4,5.55,21.75,5.25,21,5z M3,18.5V7 c1.1-0.35,2.3-0.5,3.5-0.5c1.34,0,3.13,0.41,4.5,0.99v11.5C9.63,18.41,7.84,18,6.5,18C5.3,18,4.1,18.15,3,18.5z M21,18.5 c-1.1-0.35-2.3-0.5-3.5-0.5c-1.34,0-3.13,0.41-4.5,0.99V7.49c1.37-0.59,3.16-0.99,4.5-0.99c1.2,0,2.4,0.15,3.5,0.5V18.5z"/><path d="M11,7.49C9.63,6.91,7.84,6.5,6.5,6.5C5.3,6.5,4.1,6.65,3,7v11.5C4.1,18.15,5.3,18,6.5,18 c1.34,0,3.13,0.41,4.5,0.99V7.49z" opacity=".3"/></g><g><path d="M17.5,10.5c0.88,0,1.73,0.09,2.5,0.26V9.24C19.21,9.09,18.36,9,17.5,9c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,10.69,16.18,10.5,17.5,10.5z"/><path d="M17.5,13.16c0.88,0,1.73,0.09,2.5,0.26V11.9c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,13.36,16.18,13.16,17.5,13.16z"/><path d="M17.5,15.83c0.88,0,1.73,0.09,2.5,0.26v-1.52c-0.79-0.15-1.64-0.24-2.5-0.24c-1.28,0-2.46,0.16-3.5,0.47v1.57 C14.99,16.02,16.18,15.83,17.5,15.83z"/></g></g></svg><span class="side-menu__label">Subjects</span></a>
							
							{{-- <ul class="slide-menu">
								<li><a class="slide-item" href="chart-morris.html">Morris Charts</a></li>
								<li><a class="slide-item" href="chart-flot.html">Flot Charts</a></li>
								<li><a class="slide-item" href="chart-chartjs.html">ChartJS</a></li>
								<li><a class="slide-item" href="chart-echart.html">Echart</a></li>
								<li><a class="slide-item" href="chart-sparkline.html">Sparkline</a></li>
								<li><a class="slide-item" href="chart-peity.html">Chart-peity</a></li>
							</ul> --}}
						</li>
						<li class="slide">
							<a class="side-menu__item"   href="{{route('marks-types')}}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h15v3H5zm12 5h3v9h-3zm-7 0h5v9h-5zm-5 0h3v9H5z" opacity=".3"/><path d="M20 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h15c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM8 19H5v-9h3v9zm7 0h-5v-9h5v9zm5 0h-3v-9h3v9zm0-11H5V5h15v3z"/></svg><span class="side-menu__label">Result Types</span></a>
						
						</li>



						<li class="side-item side-item-category ">Complaints</li>
						<li class="slide ">
							<a class="side-menu__item" data-toggle="slide" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M15 11V4H4v8.17l.59-.58.58-.59H6z" opacity=".3"/><path d="M21 6h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1zm-5 7c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1H3c-.55 0-1 .45-1 1v14l4-4h10zM4.59 11.59l-.59.58V4h11v7H5.17l-.58.59z"/></svg><span class="side-menu__label">Complaints</span> <i class="angle fe fe-chevron-down"></i></a>
							<ul class="slide-menu">
								<li><a class="slide-item" href="{{route('teacher-complaints')}}">Teacher Complaint</a></li>
								<li><a class="slide-item" href="{{route('teacher-complaints')}}">Student Complaint</a></li>
							</ul>
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
								<a href="index.html"><img src="{{asset('assets/img/brand/logo.png')}}" class="logo-1" alt="logo"></a>
								<a href="index.html"><img src="{{asset('assets/img/brand/logo-white.png')}}" class="dark-logo-1" alt="logo"></a>
								<a href="index.html"><img src="{{asset('assets/img/brand/favicon.png')}}" class="logo-2" alt="logo"></a>
								<a href="index.html"><img src="{{asset('assets/img/brand/favicon.png')}}" class="dark-logo-2" alt="logo"></a>
							</div>
							<div class="app-sidebar__toggle" data-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>
							<div class="ml-3 d-sm-none d-md-none d-lg-block">
								{{-- <input class="" placeholder="Search for anything..." type="search"> <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button> --}}
								<select  id="school_branches" class="form-control selectpicker active remove_active" name= "school_branches">
									@foreach( Session::get('all_branches') as $branch)
										<option value="{{$branch->school_unique_id}}" @if( $branch->id == Session::get('school_id') ) selected @endif >{{$branch->name}}</option>
									@endforeach
								</select>
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
								
								<div class="dropdown nav-item main-header-notification ">
									<a class="new nav-link" href="#">
									<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg><span class=" pulse"></span></a>
									<div class="dropdown-menu">
										<div class="menu-header-content bg-primary text-left">
											<div class="d-flex">
												<h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">Notifications</h6>
												<span class="badge badge-pill badge-warning ml-auto my-auto float-right">Mark All Read</span>
											</div>
											<p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">You have 4 unread Notifications</p>
										</div>
										<div class="main-notification-list Notification-scroll ps">
											<a class="d-flex p-3 border-bottom" href="#">
												<div class="notifyimg bg-pink">
													<i class="la la-file-alt text-white"></i>
												</div>
												<div class="ml-3">
													<h5 class="notification-label mb-1">New files available</h5>
													<div class="notification-subtext">10 hour ago</div>
												</div>
												<div class="ml-auto">
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
												<div class="ml-auto">
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
												<div class="ml-auto">
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
												<div class="ml-auto">
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
												<div class="ml-auto">
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
												<div class="ml-auto">
													<i class="las la-angle-right text-right text-muted"></i>
												</div>
											</a>
										<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
										<div class="dropdown-footer">
											<a href="">VIEW ALL</a>
										</div>
									</div>
								</div>


								<div class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
								</div>
								<div class="dropdown main-profile-menu nav nav-item nav-link">
									<a class="profile-user d-flex" href=""><img alt="" src="{{asset('uploads/teacher_avatars/').'/default.webp'}}"></a>
									<div class="dropdown-menu">
										<div class="main-header-profile bg-primary p-3">
											<div class="d-flex wd-100p">
												<div class="main-img-user"><img alt="" src="{{asset('uploads/teacher_avatars/').'/default.webp'}}" class=""></div>
												<div class="ml-3 my-auto">
													<h6>{{Auth::user()->name}}</h6><span>Admin</span>
												</div>
											</div>
										</div>
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#UserPasswordModal"><i class="bx  bx-key"></i>Edit Password</a>

										<a class="dropdown-item" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bx bx-log-out"></i> Sign Out</a>
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
		<div class="modal fade" id="UserPasswordModal" tabindex="-1" role="dialog" aria-labelledby="PasswordModalTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title" id="exampleModalLongTitle">Change <span id="student_name_pass"></span>'s Password</h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<form autocomplete="off">
				<div class="modal-body">
					<div class="form-group col ">
						<label class="bmd-label-floating form-required">Current Password </label>
						<div class="input-group mb-3">
							<input type="password" class="form-control"  id="current_password" name="current_password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
						</div>
				  	</div>
					<div class="form-group col ">
						<label class="bmd-label-floating form-required">New Password </label>
						<div class="input-group mb-3">
							<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
						</div>
				  	</div>
					<div class="form-group col ">
						<label class="bmd-label-floating form-required">Confirm New Password </label>
						<div class="input-group mb-3">
							<input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
						</div>
				  	</div>
				</div>
			</form>
				<div class="modal-footer">
				  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  <button type="button" class="btn btn-primary save_user_password">Save changes</button>
				</div>
			  </div>
			</div>
		  </div>
		  <span class= "sidebar-right Notification-scroll chat-scroll"></span>
		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

		<!-- JQuery min js -->
		<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>

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

		<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
		<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
		<!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->

		{{-- axios --}}
		<script src="{{asset('assets/js/axios.min.js')}}"></script>
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
		setTimeout(function () {
			$('.filter-option-inner-inner').addClass('text-dark');
    }, 1000);
	
		
	});

	$(document).on('click', '.save_user_password', function() {
	
		var current_password=  $('#current_password').val();
		var new_password=  $('#new_password').val();
		var confirm_new_password=  $('#confirm_new_password').val();
		if(! new_password == confirm_new_password){
			toastr.warning('Warning!', "Password does not match",{
					"positionClass": "toast-bottom-right"
			})  
			return;
		}
		var passw=   /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
		if(new_password.match(passw)) 
		{ 
		
		}else{
			toastr.warning('Warning!', "Password must contain at least one numeric digit and a uppercase character and atleast 8 characters",{
					"positionClass": "toast-bottom-right"
			})  
			return;	
		}

		if(confirm_new_password != null && confirm_new_password.length >= 8){
			axios.post("{{route('change-user-password')}}", {
				current_password: current_password , new_password: new_password,  confirm_new_password: confirm_new_password
			}).then(function(response) {
				if(response.data.success==true){
					toastr.success('Success!', 'Password Updated Successfully',{
					"positionClass": "toast-bottom-right"
					})
				}else{
					toastr.error('Error!', 'Current Password is Wrong',{
					"positionClass": "toast-bottom-right"
					})
				}
			$('#UserPasswordModal').modal('hide');

			}); 
		}else{
			toastr.warning('Warning!', "Password must have 8 characters",{
					"positionClass": "toast-bottom-right"
			})  
		
		}


	});

	


	$(document).on('change', '#school_branches', function() {
		var branch=  $('#school_branches').val();
		axios.post("{{route('change-school-branch')}}", {
			branch: branch
			}).then(function(response) {
				if(response.data.success){
					toastr.success('Success!', 'Branch Changed Successfully',{
					"positionClass": "toast-bottom-right"
					})
					setTimeout(function () {
						window.location.href = "{{ route('home')}}";
					}, 1000);
				}else{
					toastr.error('Error!', 'Invlaid Branch Requested ',{
					"positionClass": "toast-bottom-right"
					})
					window.location.href = "{{ route('home')}}";
				}
			});
	});




	</script>



		@stack('javascript');
	</body>
</html>