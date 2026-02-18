<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login - The Student Portal</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{asset('assets/img/logo/small_logo.png')}}"/>
	<link rel="stylesheet" type="text/css" href="{{asset('auth-assets/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('auth-assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<style>
		@font-face { font-family: Ubuntu-Regular; src: url('{{asset('auth-assets/fonts/ubuntu/Ubuntu-Regular.ttf')}}'); }
		@font-face { font-family: Ubuntu-Bold; src: url('{{asset('auth-assets/fonts/ubuntu/Ubuntu-Bold.ttf')}}'); }

		* { margin: 0; padding: 0; box-sizing: border-box; }
		body, html { height: 100%; font-family: Ubuntu-Regular, sans-serif; }

		.auth-container {
			display: flex;
			min-height: 100vh;
		}

		/* ---- Left: Form Side ---- */
		.auth-form-side {
			flex: 1;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 40px 30px;
			background: #fff;
		}

		.auth-form-wrapper {
			width: 100%;
			max-width: 400px;
		}

		.auth-form-wrapper h2 {
			font-family: Ubuntu-Bold, sans-serif;
			font-size: 28px;
			color: #1a2b4a;
			margin-bottom: 6px;
		}

		.auth-form-wrapper .auth-subtitle {
			color: #6b7c93;
			font-size: 15px;
			margin-bottom: 32px;
		}

		.auth-form-wrapper label {
			font-family: Ubuntu-Bold, sans-serif;
			font-size: 13px;
			color: #1a2b4a;
			margin-bottom: 6px;
			display: block;
		}

		.auth-form-wrapper .form-input {
			width: 100%;
			height: 48px;
			padding: 0 16px;
			font-family: Ubuntu-Regular, sans-serif;
			font-size: 15px;
			color: #333;
			background: #f5f7fa;
			border: 1px solid #e1e5eb;
			border-radius: 8px;
			outline: none;
			transition: border-color 0.2s;
		}

		.auth-form-wrapper .form-input:focus {
			border-color: #0074d9;
			background: #fff;
		}

		.auth-form-wrapper .form-input.is-invalid {
			border-color: #e53e3e;
		}

		.auth-form-wrapper .form-group {
			margin-bottom: 20px;
		}

		.auth-form-wrapper .auth-btn {
			width: 100%;
			height: 48px;
			font-family: Ubuntu-Bold, sans-serif;
			font-size: 16px;
			color: #fff;
			background: #0074d9;
			border: none;
			border-radius: 8px;
			cursor: pointer;
			transition: background 0.2s;
		}

		.auth-form-wrapper .auth-btn:hover {
			background: #005fb3;
		}

		.auth-form-wrapper .auth-link {
			display: inline-block;
			margin-top: 16px;
			font-size: 14px;
			color: #0074d9;
			text-decoration: none;
		}

		.auth-form-wrapper .auth-link:hover {
			text-decoration: underline;
			color: #005fb3;
		}

		.auth-form-wrapper .auth-error {
			color: #e53e3e;
			font-size: 13px;
			margin-top: 4px;
		}

		.auth-form-wrapper .auth-note {
			font-size: 13px;
			color: #6b7c93;
			margin-top: 12px;
			line-height: 1.5;
		}

		.auth-form-wrapper .auth-note strong {
			color: #e53e3e;
		}

		.auth-form-wrapper .alert-success {
			background: #f0fff4;
			border: 1px solid #c6f6d5;
			color: #276749;
			padding: 12px 16px;
			border-radius: 8px;
			font-size: 14px;
			margin-bottom: 20px;
		}

		/* ---- Right: Brand Side ---- */
		.auth-brand-side {
			flex: 1;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			padding: 60px 40px;
			position: relative;
			overflow: hidden;
			background: linear-gradient(135deg, rgba(0, 80, 150, 0.92), rgba(0, 116, 217, 0.88));
		}

		.auth-brand-side::before {
			content: "";
			position: absolute;
			inset: 0;
			background: url('{{asset('auth-assets/images/bg-01.jpg')}}') center/cover no-repeat;
			z-index: -1;
		}

		.auth-brand-logo {
			width: 100px;
			height: 100px;
			object-fit: contain;
			margin-bottom: 24px;
			filter: drop-shadow(0 4px 12px rgba(0,0,0,0.3));
		}

		.auth-brand-title {
			font-family: Ubuntu-Bold, sans-serif;
			font-size: 32px;
			color: #fff;
			text-align: center;
			margin-bottom: 8px;
		}

		.auth-brand-title .accent {
			color: #7ec8f8;
		}

		.auth-brand-tagline {
			font-size: 16px;
			color: rgba(255,255,255,0.8);
			text-align: center;
			max-width: 320px;
			line-height: 1.6;
		}

		/* ---- Mobile ---- */
		@media (max-width: 768px) {
			.auth-container {
				flex-direction: column-reverse;
			}

			.auth-brand-side {
				padding: 36px 24px;
				min-height: auto;
			}

			.auth-brand-logo {
				width: 64px;
				height: 64px;
				margin-bottom: 12px;
			}

			.auth-brand-title {
				font-size: 22px;
				margin-bottom: 4px;
			}

			.auth-brand-tagline {
				font-size: 13px;
			}

			.auth-form-side {
				padding: 32px 24px;
			}
		}
	</style>
</head>
<body>

	<div class="auth-container">
		<div class="auth-form-side">
			@yield('content')
		</div>
		<div class="auth-brand-side">
			<img src="{{asset('assets/img/logo/small_logo_dark.png')}}" class="auth-brand-logo" alt="The Student Portal">
			<h1 class="auth-brand-title">The Student <span class="accent">Portal</span></h1>
			<p class="auth-brand-tagline">Manage your academic journey in one place — grades, attendance, and more.</p>
		</div>
	</div>

	<script src="{{asset('auth-assets/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('auth-assets/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('auth-assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
</body>
</html>
