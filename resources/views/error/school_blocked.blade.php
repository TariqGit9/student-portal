<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- Favicon -->
		<link rel="icon" href="{{asset('assets/img/logo/small_logo.png')}}" type="image/x-icon"/>

		<!-- Title -->
		<title>School Unavailable - Student Portal</title>

		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

		<style>
			* { margin: 0; padding: 0; box-sizing: border-box; }
			body {
				font-family: 'Inter', sans-serif;
				min-height: 100vh;
				display: flex;
				align-items: center;
				justify-content: center;
				background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
				padding: 20px;
			}
			.blocked-container {
				background: #fff;
				border-radius: 20px;
				box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
				max-width: 520px;
				width: 100%;
				padding: 50px 40px;
				text-align: center;
			}
			.logos {
				display: flex;
				align-items: center;
				justify-content: center;
				gap: 20px;
				margin-bottom: 35px;
			}
			.logo-img {
				width: 70px;
				height: 70px;
				object-fit: contain;
				border-radius: 14px;
			}
			.school-logo-img {
				width: 70px;
				height: 70px;
				object-fit: contain;
				border-radius: 50%;
				border: 2px solid #e9ecef;
			}
			.logo-divider {
				width: 1px;
				height: 50px;
				background: #dee2e6;
			}
			.icon-wrapper {
				width: 80px;
				height: 80px;
				background: #fff3f3;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				margin: 0 auto 25px;
			}
			.icon-wrapper svg {
				width: 40px;
				height: 40px;
				color: #e74c3c;
			}
			h1 {
				font-size: 22px;
				font-weight: 700;
				color: #2d3436;
				margin-bottom: 12px;
			}
			.message {
				font-size: 15px;
				color: #636e72;
				line-height: 1.6;
				margin-bottom: 30px;
			}
			.school-name {
				font-weight: 600;
				color: #2d3436;
			}
			.logout-btn {
				display: inline-block;
				padding: 12px 36px;
				background: #6c5ce7;
				color: #fff;
				border: none;
				border-radius: 10px;
				font-size: 15px;
				font-weight: 600;
				text-decoration: none;
				cursor: pointer;
				transition: all 0.2s ease;
			}
			.logout-btn:hover {
				background: #5a4bd1;
				transform: translateY(-1px);
				box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
			}
			.footer-text {
				margin-top: 30px;
				font-size: 12px;
				color: #b2bec3;
			}
		</style>
	</head>

	<body>
		<div class="blocked-container">
			<div class="logos">
				<img src="{{asset('assets/img/logo/small_logo.png')}}" class="logo-img" alt="Student Portal">
				@if(Auth::check() && Auth::user()->school && Auth::user()->school->avatar)
					<div class="logo-divider"></div>
					<img src="{{asset('uploads/school_avatars/' . Auth::user()->school->avatar)}}" class="school-logo-img" alt="{{ Auth::user()->school->name ?? 'School' }}">
				@endif
			</div>

			<div class="icon-wrapper">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
					<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
				</svg>
			</div>

			<h1>School Temporarily Unavailable</h1>
			<p class="message">
				@if(Auth::check() && Auth::user()->school)
					<span class="school-name">{{ Auth::user()->school->name }}</span> is currently not available.
				@else
					Your school is currently not available.
				@endif
				<br>Please contact your school administration for more information.
			</p>

			<a href="{{ route('logout') }}" class="logout-btn"
				onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
				Back to Login
			</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
				@csrf
			</form>

			<p class="footer-text">The Student Portal</p>
		</div>
	</body>
</html>
