<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Student Portal - Complete School Management System</title>
    <link rel="icon" type="image/png" href="{{asset('assets/img/logo/small_logo.png')}}"/>
    <link rel="stylesheet" href="{{asset('auth-assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('auth-assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <style>
        @font-face { font-family: Ubuntu-Regular; src: url('{{asset('auth-assets/fonts/ubuntu/Ubuntu-Regular.ttf')}}'); }
        @font-face { font-family: Ubuntu-Bold; src: url('{{asset('auth-assets/fonts/ubuntu/Ubuntu-Bold.ttf')}}'); }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Ubuntu-Regular, sans-serif; color: #333; overflow-x: hidden; }

        /* ===== NAVBAR ===== */
        .landing-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 5%; background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px); box-shadow: 0 1px 10px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }
        .landing-nav.scrolled { padding: 10px 5%; box-shadow: 0 2px 20px rgba(0,0,0,0.1); }
        .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .nav-brand img { width: 40px; height: 40px; object-fit: contain; }
        .nav-brand span { font-family: Ubuntu-Bold, sans-serif; font-size: 20px; color: #1a2b4a; }
        .nav-brand .accent { color: #0074d9; }
        .nav-links { display: flex; align-items: center; gap: 32px; }
        .nav-links a { text-decoration: none; font-size: 15px; color: #4a5568; transition: color 0.2s; }
        .nav-links a:hover { color: #0074d9; }
        .btn-login {
            padding: 10px 28px; background: #0074d9; color: #fff !important;
            border-radius: 8px; font-family: Ubuntu-Bold, sans-serif; font-size: 14px;
            transition: all 0.2s; border: none;
        }
        .btn-login:hover { background: #005fb3; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,116,217,0.3); }
        .mobile-toggle { display: none; background: none; border: none; font-size: 24px; color: #1a2b4a; cursor: pointer; }

        /* ===== HERO ===== */
        .hero {
            min-height: 100vh; display: flex; align-items: center;
            padding: 120px 5% 80px;
            background: linear-gradient(135deg, #f8faff 0%, #e8f0fe 100%);
            position: relative; overflow: hidden;
        }
        .hero::after {
            content: ""; position: absolute; right: -200px; top: -200px;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(0,116,217,0.08) 0%, transparent 70%);
        }
        .hero-content { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: 60px; width: 100%; }
        .hero-text { flex: 1; position: relative; z-index: 1; }
        .hero-badge {
            display: inline-block; padding: 6px 16px; background: rgba(0,116,217,0.1);
            color: #0074d9; border-radius: 20px; font-size: 13px;
            font-family: Ubuntu-Bold, sans-serif; margin-bottom: 20px;
        }
        .hero-text h1 {
            font-family: Ubuntu-Bold, sans-serif; font-size: 48px;
            color: #1a2b4a; line-height: 1.2; margin-bottom: 20px;
        }
        .hero-text h1 .highlight { color: #0074d9; }
        .hero-text p { font-size: 18px; color: #6b7c93; line-height: 1.7; margin-bottom: 32px; max-width: 520px; }
        .hero-buttons { display: flex; gap: 16px; flex-wrap: wrap; }
        .btn-primary-landing {
            padding: 14px 32px; background: #0074d9; color: #fff;
            border-radius: 10px; font-family: Ubuntu-Bold, sans-serif;
            font-size: 16px; text-decoration: none; transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 8px; border: none;
        }
        .btn-primary-landing:hover { background: #005fb3; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,116,217,0.3); color: #fff; text-decoration: none; }
        .btn-secondary-landing {
            padding: 14px 32px; background: #fff; color: #1a2b4a;
            border: 2px solid #e1e5eb; border-radius: 10px;
            font-family: Ubuntu-Bold, sans-serif; font-size: 16px;
            text-decoration: none; transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-secondary-landing:hover { border-color: #0074d9; color: #0074d9; transform: translateY(-2px); text-decoration: none; }
        .hero-visual { flex: 1; position: relative; z-index: 1; }
        .hero-card {
            background: #fff; border-radius: 20px; padding: 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            transform: rotate(2deg);
        }
        .hero-card-header { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .hero-card-dot { width: 12px; height: 12px; border-radius: 50%; }
        .dot-red { background: #ff5f56; }
        .dot-yellow { background: #ffbd2e; }
        .dot-green { background: #27c93f; }
        .hero-card-row {
            display: flex; align-items: center; gap: 14px;
            padding: 14px 16px; background: #f8faff; border-radius: 10px;
            margin-bottom: 10px;
        }
        .hero-card-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: Ubuntu-Bold, sans-serif; font-size: 14px; color: #fff;
        }
        .hero-card-info { flex: 1; }
        .hero-card-name { font-family: Ubuntu-Bold, sans-serif; font-size: 14px; color: #1a2b4a; }
        .hero-card-sub { font-size: 12px; color: #6b7c93; }
        .hero-card-grade {
            padding: 4px 12px; border-radius: 6px;
            font-family: Ubuntu-Bold, sans-serif; font-size: 13px;
        }
        .grade-a { background: #e6ffed; color: #22863a; }
        .grade-b { background: #fff8e1; color: #e67e22; }
        .grade-ap { background: #e8f0fe; color: #0074d9; }

        /* ===== STATS ===== */
        .stats {
            padding: 60px 5%;
            background: #fff;
        }
        .stats-grid {
            max-width: 1000px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 32px;
        }
        .stat-item { text-align: center; }
        .stat-number {
            font-family: Ubuntu-Bold, sans-serif; font-size: 36px; color: #0074d9;
        }
        .stat-label { font-size: 14px; color: #6b7c93; margin-top: 4px; }

        /* ===== FEATURES ===== */
        .features {
            padding: 100px 5%;
            background: #fff;
        }
        .section-header { text-align: center; margin-bottom: 60px; }
        .section-header h2 {
            font-family: Ubuntu-Bold, sans-serif; font-size: 36px;
            color: #1a2b4a; margin-bottom: 12px;
        }
        .section-header p { font-size: 17px; color: #6b7c93; max-width: 560px; margin: 0 auto; line-height: 1.6; }
        .features-grid {
            max-width: 1200px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px;
        }
        .feature-card {
            padding: 36px 28px; background: #f8faff;
            border-radius: 16px; transition: all 0.3s;
            border: 1px solid transparent;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.08);
            border-color: rgba(0,116,217,0.15);
        }
        .feature-icon {
            width: 56px; height: 56px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin-bottom: 20px; color: #fff;
        }
        .feature-card h3 { font-family: Ubuntu-Bold, sans-serif; font-size: 18px; color: #1a2b4a; margin-bottom: 10px; }
        .feature-card p { font-size: 14px; color: #6b7c93; line-height: 1.7; }

        /* ===== ROLES ===== */
        .roles {
            padding: 100px 5%;
            background: linear-gradient(135deg, #f8faff 0%, #e8f0fe 100%);
        }
        .roles-grid {
            max-width: 900px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px;
        }
        .role-card {
            background: #fff; border-radius: 16px; padding: 32px 24px;
            text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: all 0.3s; border: 2px solid transparent;
        }
        .role-card:hover { transform: translateY(-4px); border-color: #0074d9; }
        .role-icon {
            width: 64px; height: 64px; border-radius: 50%; margin: 0 auto 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; color: #fff;
        }
        .role-card h3 { font-family: Ubuntu-Bold, sans-serif; font-size: 17px; color: #1a2b4a; margin-bottom: 8px; }
        .role-card p { font-size: 13px; color: #6b7c93; line-height: 1.6; }

        /* ===== WHY US ===== */
        .why-us {
            padding: 100px 5%;
            background: #fff;
        }
        .why-grid {
            max-width: 900px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;
        }
        .why-item {
            display: flex; gap: 16px; padding: 24px;
            background: #f8faff; border-radius: 12px;
        }
        .why-check {
            width: 32px; height: 32px; border-radius: 50%;
            background: #e6ffed; color: #22863a;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0; margin-top: 2px;
        }
        .why-item h4 { font-family: Ubuntu-Bold, sans-serif; font-size: 15px; color: #1a2b4a; margin-bottom: 4px; }
        .why-item p { font-size: 13px; color: #6b7c93; line-height: 1.5; }

        /* ===== CTA ===== */
        .cta {
            padding: 80px 5%;
            background: linear-gradient(135deg, rgba(0, 80, 150, 0.95), rgba(0, 116, 217, 0.9));
            text-align: center; position: relative; overflow: hidden;
        }
        .cta::before {
            content: ""; position: absolute; inset: 0;
            background: url('{{asset('auth-assets/images/bg-01.jpg')}}') center/cover no-repeat;
            z-index: 0; opacity: 0.15;
        }
        .cta-content { position: relative; z-index: 1; }
        .cta h2 { font-family: Ubuntu-Bold, sans-serif; font-size: 34px; color: #fff; margin-bottom: 14px; }
        .cta p { font-size: 17px; color: rgba(255,255,255,0.8); margin-bottom: 32px; max-width: 500px; margin-left: auto; margin-right: auto; }
        .btn-cta {
            padding: 14px 40px; background: #fff; color: #0074d9;
            border-radius: 10px; font-family: Ubuntu-Bold, sans-serif;
            font-size: 16px; text-decoration: none; transition: all 0.2s;
            display: inline-block;
        }
        .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.2); color: #005fb3; text-decoration: none; }

        /* ===== FOOTER ===== */
        .landing-footer {
            padding: 40px 5%; background: #1a2b4a;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 16px;
        }
        .footer-brand { display: flex; align-items: center; gap: 10px; }
        .footer-brand img { width: 32px; height: 32px; }
        .footer-brand span { font-family: Ubuntu-Bold, sans-serif; font-size: 16px; color: #fff; }
        .footer-brand .accent { color: #7ec8f8; }
        .footer-copy { font-size: 13px; color: rgba(255,255,255,0.5); }

        /* ===== MOBILE ===== */
        @media (max-width: 992px) {
            .hero-content { flex-direction: column; text-align: center; }
            .hero-text p { margin-left: auto; margin-right: auto; }
            .hero-buttons { justify-content: center; }
            .hero-visual { max-width: 420px; width: 100%; }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
            .roles-grid { grid-template-columns: repeat(2, 1fr); }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-links.open {
                display: flex; flex-direction: column; position: absolute;
                top: 100%; left: 0; right: 0; background: #fff;
                padding: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);
                gap: 16px;
            }
            .mobile-toggle { display: block; }
            .hero-text h1 { font-size: 32px; }
            .hero-text p { font-size: 16px; }
            .section-header h2 { font-size: 28px; }
            .features-grid { grid-template-columns: 1fr; }
            .roles-grid { grid-template-columns: 1fr; }
            .why-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
            .stat-number { font-size: 28px; }
            .hero-card { padding: 24px; }
            .landing-footer { flex-direction: column; text-align: center; }
        }

        /* ===== PRICING ===== */
        .pricing {
            padding: 100px 5%;
            background: linear-gradient(135deg, #f8faff 0%, #e8f0fe 100%);
        }
        .pricing-grid {
            max-width: 1000px; margin: 0 auto;
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px;
            align-items: stretch;
        }
        .pricing-card {
            background: #fff; border-radius: 16px; padding: 40px 28px;
            text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: all 0.3s; border: 2px solid transparent;
            display: flex; flex-direction: column;
        }
        .pricing-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.1); }
        .pricing-card.featured {
            border-color: #0074d9;
            box-shadow: 0 8px 30px rgba(0,116,217,0.15);
            position: relative;
        }
        .pricing-badge {
            position: absolute; top: -14px; left: 50%; transform: translateX(-50%);
            background: #0074d9; color: #fff; padding: 5px 20px;
            border-radius: 20px; font-family: Ubuntu-Bold, sans-serif;
            font-size: 12px; white-space: nowrap;
        }
        .pricing-icon {
            width: 56px; height: 56px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px; font-size: 24px; color: #fff;
        }
        .pricing-card h3 { font-family: Ubuntu-Bold, sans-serif; font-size: 20px; color: #1a2b4a; margin-bottom: 6px; }
        .pricing-card .pricing-desc { font-size: 13px; color: #6b7c93; margin-bottom: 24px; }
        .pricing-price {
            font-family: Ubuntu-Bold, sans-serif; font-size: 42px; color: #1a2b4a;
            margin-bottom: 4px; line-height: 1;
        }
        .pricing-price .currency { font-size: 22px; vertical-align: top; position: relative; top: 6px; }
        .pricing-price .period { font-size: 15px; font-family: Ubuntu-Regular, sans-serif; color: #6b7c93; }
        .pricing-price-label { font-size: 13px; color: #6b7c93; margin-bottom: 24px; }
        .pricing-features { list-style: none; padding: 0; margin: 0 0 28px; flex: 1; }
        .pricing-features li {
            padding: 8px 0; font-size: 14px; color: #4a5568;
            border-bottom: 1px solid #f0f0f0;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .pricing-features li:last-child { border-bottom: none; }
        .pricing-features li i { color: #22863a; font-size: 13px; }
        .pricing-btn-free {
            display: inline-block; padding: 12px 32px;
            background: #f0f7ff; color: #0074d9; border: 2px solid #0074d9;
            border-radius: 10px; font-family: Ubuntu-Bold, sans-serif;
            font-size: 14px; text-decoration: none; transition: all 0.2s;
        }
        .pricing-btn-free:hover { background: #0074d9; color: #fff; text-decoration: none; }
        .pricing-btn-primary {
            display: inline-block; padding: 12px 32px;
            background: #0074d9; color: #fff; border: 2px solid #0074d9;
            border-radius: 10px; font-family: Ubuntu-Bold, sans-serif;
            font-size: 14px; text-decoration: none; transition: all 0.2s;
        }
        .pricing-btn-primary:hover { background: #005fb3; border-color: #005fb3; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,116,217,0.3); color: #fff; text-decoration: none; }
        .pricing-note {
            text-align: center; max-width: 600px; margin: 40px auto 0;
            font-size: 14px; color: #6b7c93; line-height: 1.6;
        }

        @media (max-width: 768px) {
            .pricing-grid { grid-template-columns: 1fr; max-width: 400px; }
        }

        /* ===== SMOOTH SCROLL ===== */
        html { scroll-behavior: smooth; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="landing-nav" id="navbar">
        <a href="#" class="nav-brand">
            <img src="{{asset('assets/img/logo/small_logo.png')}}" alt="The Student Portal">
            <span>The Student <span class="accent">Portal</span></span>
        </a>
        <button class="mobile-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')">
            <i class="fa fa-bars"></i>
        </button>
        <div class="nav-links">
            <a href="#features">Features</a>
            <a href="#roles">Who It's For</a>
            <a href="#pricing">Pricing</a>
            <a href="#why">Why Us</a>
            <a href="{{ route('login') }}" class="btn-login">Login</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero" id="hero">
        <div class="hero-content">
            <div class="hero-text">
                <span class="hero-badge">Complete School Management</span>
                <h1>Manage Your School <span class="highlight">Smarter</span>, Not Harder</h1>
                <p>A powerful, easy-to-use portal that brings students, teachers, and administrators together. Track marks, attendance, fees and more — all in one place.</p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn-primary-landing">
                        Get Started <i class="fa fa-arrow-right"></i>
                    </a>
                    <a href="#features" class="btn-secondary-landing">
                        Explore Features <i class="fa fa-chevron-down"></i>
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-card">
                    <div class="hero-card-header">
                        <span class="hero-card-dot dot-red"></span>
                        <span class="hero-card-dot dot-yellow"></span>
                        <span class="hero-card-dot dot-green"></span>
                    </div>
                    <div class="hero-card-row">
                        <div class="hero-card-avatar" style="background:#0074d9;">A</div>
                        <div class="hero-card-info">
                            <div class="hero-card-name">Ahmed Khan</div>
                            <div class="hero-card-sub">Class 10-A &middot; Mathematics</div>
                        </div>
                        <span class="hero-card-grade grade-a">A+</span>
                    </div>
                    <div class="hero-card-row">
                        <div class="hero-card-avatar" style="background:#e67e22;">S</div>
                        <div class="hero-card-info">
                            <div class="hero-card-name">Sara Ali</div>
                            <div class="hero-card-sub">Class 10-A &middot; Science</div>
                        </div>
                        <span class="hero-card-grade grade-ap">A</span>
                    </div>
                    <div class="hero-card-row">
                        <div class="hero-card-avatar" style="background:#22863a;">M</div>
                        <div class="hero-card-info">
                            <div class="hero-card-name">M. Usman</div>
                            <div class="hero-card-sub">Class 10-A &middot; English</div>
                        </div>
                        <span class="hero-card-grade grade-b">B+</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="stats">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number" data-count="6">6+</div>
                <div class="stat-label">Core Modules</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">3</div>
                <div class="stat-label">User Roles</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100%</div>
                <div class="stat-label">Web Based</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Access Anywhere</div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features" id="features">
        <div class="section-header">
            <h2>Everything Your School Needs</h2>
            <p>From marks to fees, attendance to announcements — manage it all from one powerful dashboard.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon" style="background: linear-gradient(135deg, #0074d9, #00a8ff);">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <h3>Student Marks Record</h3>
                <p>Record and track student marks for every subject and exam. Generate report cards and monitor academic progress over time.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: linear-gradient(135deg, #22863a, #28a745);">
                    <i class="fa fa-calendar-check-o"></i>
                </div>
                <h3>Attendance Tracking</h3>
                <p>Daily attendance management for every class. Teachers mark attendance effortlessly, and parents can view records instantly.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: linear-gradient(135deg, #e67e22, #f39c12);">
                    <i class="fa fa-money"></i>
                </div>
                <h3>Fees Management</h3>
                <p>Complete fee collection and tracking system. Generate fee challans, track payments, and view detailed financial reports.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: linear-gradient(135deg, #e74c3c, #ff6b6b);">
                    <i class="fa fa-bell"></i>
                </div>
                <h3>Noticeboard</h3>
                <p>In-app notification system for announcements. Admins and teachers can broadcast important updates with expiry dates.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: linear-gradient(135deg, #6c5ce7, #a29bfe);">
                    <i class="fa fa-users"></i>
                </div>
                <h3>Class Management</h3>
                <p>Organize students into classes and sections. Assign teachers, manage subjects, and handle class-level operations with ease.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: linear-gradient(135deg, #00b894, #55efc4);">
                    <i class="fa fa-bar-chart"></i>
                </div>
                <h3>Reports & Analytics</h3>
                <p>Comprehensive reports for marks, attendance, and fee collection. Visual charts and downloadable data at your fingertips.</p>
            </div>
        </div>
    </section>

    <!-- Who It's For -->
    <section class="roles" id="roles">
        <div class="section-header">
            <h2>Built for Everyone in School</h2>
            <p>Different dashboards tailored for each user role with the tools they need most.</p>
        </div>
        <div class="roles-grid">
            <div class="role-card">
                <div class="role-icon" style="background: linear-gradient(135deg, #0074d9, #00a8ff);">
                    <i class="fa fa-cogs"></i>
                </div>
                <h3>Admin</h3>
                <p>Full control over your school — manage classes, teachers, students, fees, marks, attendance, and reports.</p>
            </div>
            <div class="role-card">
                <div class="role-icon" style="background: linear-gradient(135deg, #22863a, #28a745);">
                    <i class="fa fa-book"></i>
                </div>
                <h3>Teacher</h3>
                <p>Mark attendance, enter student marks, view class lists, and send notifications to students effortlessly.</p>
            </div>
            <div class="role-card">
                <div class="role-icon" style="background: linear-gradient(135deg, #e67e22, #f39c12);">
                    <i class="fa fa-user"></i>
                </div>
                <h3>Student</h3>
                <p>View your marks, attendance records, fee status, and school announcements — all in one easy-to-use dashboard.</p>
            </div>
        </div>
    </section>

    <!-- Why Us -->
    <section class="why-us" id="why">
        <div class="section-header">
            <h2>Why Choose The Student Portal?</h2>
            <p>Simple, affordable, and built with schools in mind.</p>
        </div>
        <div class="why-grid">
            <div class="why-item">
                <div class="why-check"><i class="fa fa-check"></i></div>
                <div>
                    <h4>Easy to Use</h4>
                    <p>Clean, intuitive interface that anyone can use. No technical knowledge needed — just login and go.</p>
                </div>
            </div>
            <div class="why-item">
                <div class="why-check"><i class="fa fa-check"></i></div>
                <div>
                    <h4>Mobile Friendly</h4>
                    <p>Access from any device — phone, tablet, or computer. Works beautifully on all screen sizes.</p>
                </div>
            </div>
            <div class="why-item">
                <div class="why-check"><i class="fa fa-check"></i></div>
                <div>
                    <h4>Secure & Reliable</h4>
                    <p>Role-based access control ensures data privacy. Each user only sees what they need to see.</p>
                </div>
            </div>
            <div class="why-item">
                <div class="why-check"><i class="fa fa-check"></i></div>
                <div>
                    <h4>Multi-School Support</h4>
                    <p>Manage multiple school branches from a single platform. Perfect for school networks and chains.</p>
                </div>
            </div>
            <div class="why-item">
                <div class="why-check"><i class="fa fa-check"></i></div>
                <div>
                    <h4>Real-time Notifications</h4>
                    <p>Keep everyone informed with in-app announcements and the built-in noticeboard system.</p>
                </div>
            </div>
            <div class="why-item">
                <div class="why-check"><i class="fa fa-check"></i></div>
                <div>
                    <h4>Dark & Light Mode</h4>
                    <p>Comfortable viewing in any lighting condition with a built-in theme switcher.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="pricing" id="pricing">
        <div class="section-header">
            <h2>Simple, Transparent Pricing</h2>
            <p>No hidden fees, no surprises. Admin and teacher accounts are completely free — you only pay per student.</p>
        </div>
        <div class="pricing-grid">
            <div class="pricing-card">
                <div class="pricing-icon" style="background: linear-gradient(135deg, #0074d9, #00a8ff);">
                    <i class="fa fa-cogs"></i>
                </div>
                <h3>Admin</h3>
                <p class="pricing-desc">Full school management access</p>
                <div class="pricing-price">Free</div>
                <p class="pricing-price-label">Always free</p>
                <ul class="pricing-features">
                    <li><i class="fa fa-check"></i> Unlimited admin accounts</li>
                    <li><i class="fa fa-check"></i> Full dashboard access</li>
                    <li><i class="fa fa-check"></i> Manage classes & students</li>
                    <li><i class="fa fa-check"></i> Fee collection & reports</li>
                    <li><i class="fa fa-check"></i> Send notifications</li>
                </ul>
                <a href="{{ route('login') }}" class="pricing-btn-free">Get Started</a>
            </div>
            <div class="pricing-card featured">
                <span class="pricing-badge">Per Student</span>
                <div class="pricing-icon" style="background: linear-gradient(135deg, #e67e22, #f39c12);">
                    <i class="fa fa-user"></i>
                </div>
                <h3>Student</h3>
                <p class="pricing-desc">Complete student portal access</p>
                <div class="pricing-price"><span class="currency">Rs</span> 30 <span class="period">/mo</span></div>
                <p class="pricing-price-label">per student, per month</p>
                <ul class="pricing-features">
                    <li><i class="fa fa-check"></i> View marks & report cards</li>
                    <li><i class="fa fa-check"></i> Attendance records</li>
                    <li><i class="fa fa-check"></i> Fee status & history</li>
                    <li><i class="fa fa-check"></i> Noticeboard access</li>
                    <li><i class="fa fa-check"></i> Mobile friendly</li>
                </ul>
                <a href="{{ route('login') }}" class="pricing-btn-primary">Get Started</a>
            </div>
            <div class="pricing-card">
                <div class="pricing-icon" style="background: linear-gradient(135deg, #22863a, #28a745);">
                    <i class="fa fa-book"></i>
                </div>
                <h3>Teacher</h3>
                <p class="pricing-desc">Class & student management</p>
                <div class="pricing-price">Free</div>
                <p class="pricing-price-label">Always free</p>
                <ul class="pricing-features">
                    <li><i class="fa fa-check"></i> Unlimited teacher accounts</li>
                    <li><i class="fa fa-check"></i> Mark attendance</li>
                    <li><i class="fa fa-check"></i> Enter student marks</li>
                    <li><i class="fa fa-check"></i> View class lists</li>
                    <li><i class="fa fa-check"></i> Send notifications</li>
                </ul>
                <a href="{{ route('login') }}" class="pricing-btn-free">Get Started</a>
            </div>
        </div>
        <p class="pricing-note">
            <i class="fa fa-info-circle"></i> &nbsp;For a school with 500 students, that's just <strong>Rs 15,000/month</strong> — less than Rs 1 per student per day for a complete digital school management system.
        </p>
    </section>

    <!-- CTA -->
    <section class="cta">
        <div class="cta-content">
            <h2>Ready to Transform Your School?</h2>
            <p>Join schools already using The Student Portal to simplify their management.</p>
            <a href="{{ route('login') }}" class="btn-cta">Login to Your Portal <i class="fa fa-arrow-right"></i></a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="landing-footer">
        <div class="footer-brand">
            <img src="{{asset('assets/img/logo/small_logo_dark.png')}}" alt="The Student Portal">
            <span>The Student <span class="accent">Portal</span></span>
        </div>
        <div class="footer-copy">&copy; {{ date('Y') }} The Student Portal. All rights reserved.</div>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            var nav = document.getElementById('navbar');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
