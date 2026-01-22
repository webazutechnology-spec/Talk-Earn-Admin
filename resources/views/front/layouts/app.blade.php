<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Durgesh Verma">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Page Title -->
    <title>{{ config('app.name') }}</title>
	<!-- Favicon Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/config/'.config('app.auth_logo')) }}">
	<!-- Google Fonts Css-->
	<link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,100..900;1,100..900&amp;display=swap" rel="stylesheet">
	<!-- Bootstrap Css -->
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
	<!-- SlickNav Css -->
	<link href="{{ asset('assets/css/slicknav.min.css') }}" rel="stylesheet">
	<!-- Swiper Css -->
	<link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
	<!-- Font Awesome Icon Css-->
	<link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" media="screen">
	<!-- Animated Css -->
	<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <!-- Magnific Popup Core Css File -->
	<link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
	<!-- Mouse Cursor Css File -->
	<link rel="stylesheet" href="{{ asset('assets/css/mousecursor.css') }}">
	<!-- Main Custom Css -->
	<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" media="screen">
</head>
<body>

    <!-- Preloader Start -->
	<div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="{{ asset('assets/images/hero-image.png') }}" alt=""></div>
		</div>
	</div>
	<!-- Preloader End -->

    <!-- Header Start -->
	<header class="main-header">
		<div class="header-sticky bg-section">
			<nav class="navbar navbar-expand-lg">
				<div class="container">
					<!-- Logo Start -->
					<a class="navbar-brand" href="{{ url('/') }}">
						<img src="{{ asset('images/config/'.config('app.logo')) }}" style="width: 250px;" alt="Logo">
					</a>
					<!-- Logo End -->

                    <!-- Main Menu Start -->
                    <div class="collapse navbar-collapse main-menu">
                        <div class="nav-menu-wrapper">
                            <ul class="navbar-nav mr-auto" id="menu">
                                <li class="nav-item submenu"><a class="nav-link" href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('about-us') }}">About Us</a>
                                <li class="nav-item"><a class="nav-link" href="{{ route('our-team') }}">Professional's</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('blog-list') }}">Blog</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('contact-us') }}">Contact Us</a></li>
                            </ul>
                        </div>
                        
                        <!-- Header Btn Start -->
                        <div class="header-btn">
                            <a href="contact.html" class="btn-default btn-highlighted">Download the App</a>
                        </div>
                        <!-- Header Btn End -->
                    </div>
					<!-- Main Menu End -->
					<div class="navbar-toggle"></div>
				</div>
			</nav>
			<div class="responsive-menu"></div>
		</div>
	</header>
	<!-- Header End -->

	@yield('content')

    <!-- Footer Start -->
    <footer class="main-footer bg-section dark-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Footer Header Start -->
                    <div class="footer-header">
                        <!-- Section Title Start -->
                        <div class="section-title">
                            <h2 class="text-anime-style-3" data-cursor="-opaque">Download the app today!</h2>
                            <p>Download the app today to enjoy seamless performance, smart features</p>
                        </div>
                        <!-- Section Title End -->

                        <!-- App Download Buttons Start -->
                        <div class="app-download-buttons">
                            <!-- App Download Button Start -->
                            <div class="app-download-btn">
                                <a href="#"><img src="{{ asset('assets/images/icon-app-store.svg') }}" alt=""></a>
                            </div>
                            <!-- App Download Button End -->
                            
                            <!-- App Download Button Start -->
                            <div class="app-download-btn">
                                <a href="#"><img src="{{ asset('assets/images/icon-play-store.svg') }}" alt=""></a>
                            </div>
                            <!-- App Download Button End -->
                        </div>
                        <!-- App Download Buttons End -->
                    </div>
                    <!-- Footer Header End -->                  
                </div>

                <div class="col-lg-4">
                    <!-- About Footer Start -->
                    <div class="about-footer">
                        <!-- Footer Logo Start -->
                        <div class="footer-logo">
                            <img src="{{ asset('images/config/'.config('app.logo')) }}" alt="">
                        </div>
                        <!-- Footer Logo End -->
    
                        <!-- About Footer Content Start -->
                        <div class="about-footer-content">
                            <p>Empowering your digital journey innovative, user-friendly solutions designed to make everyday life smarter, simpler.</p>
                        </div>           
                        <!-- About Footer Content End -->
                    </div>
                    <!-- About Footer End -->
                </div>

                <div class="col-lg-8">
                    <!-- Footer Links Box Start -->
                    <div class="footer-links-box">
                        <!-- Footer Links Start -->
                        <div class="footer-links">
                            <h3>Quick Links</h3>
                            <ul>
                                <li><a href="{{url('/')}}">Home</a></li>
                                <li><a href="{{url('about-us')}}">About Us</a></li>
                                <li><a href="{{url('features')}}">features</a></li>
                                <li><a href="{{url('blog')}}">latest blog</a></li>
                                <li><a href="{{url('contact-us')}}">Contact Us</a></li>
                            </ul>
                        </div>
                        <!-- Footer Links End -->
    
                        <!-- Footer Links Start -->
                        <div class="footer-links">
                            <h3>Support</h3>
                            <ul>
                                <li><a href="#">Help Center</a></li>
                                <li><a href="{{url('faqs')}}">FAQs</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Refund Policy</a></li>
                            </ul>
                        </div>
                        <!-- Footer Links End -->

                        <!-- Footer Links Start -->
                        <div class="footer-links footer-contact-links">
                            <h3>Get In touch</h3>
                            <ul>
                                <li><img src="{{ asset('assets/images/icon-location-accent.svg') }}" alt="">123 Innovation Street, Tech, USA</li>
                                <li><img src="{{ asset('assets/images/icon-phone-accent.svg') }}" alt=""><a href="tel:123456789">+1 (123) 456-789</a></li>
                                <li><img src="{{ asset('assets/images/icon-mail-accent.svg') }}" alt=""><a href="mailto:info@dominname.com">info@dominname.com</a></li>
                            </ul>
                        </div>
                        <!-- Footer Links End -->
                    </div>
                    <!-- Footer Links Box End -->
                </div>
            </div>
        </div>

        <!-- Footer Copyright Section Start -->
        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Footer Copyright Start -->
                        <div class="footer-copyright-box">
                            <!-- Footer Copyright Text Start -->
                            <div class="footer-copyright-text">
                                <p>Copyright © 2025 All Rights Reserved.</p>
                            </div>
                            <!-- Footer Copyright Text Start -->
                            
                            <!-- Footer Social List Start -->
                            <div class="footer-social-list">
                                <ul>
                                    <li><a href="#">Facebook</a></li>
                                    <li><a href="#">Twitter</a></li>
                                    <li><a href="#">Instagram</a></li>
                                    <li><a href="#">LinkedIn</a></li>
                                </ul>
                            </div>
                            <!-- Footer Social List End -->
                        </div>
                        <!-- Footer Copyright End -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Copyright Section End -->
    </footer>
    <!-- Footer End -->

    <!-- Jquery Library File -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Circle Progress Js File -->
    <script src="{{ asset('assets/js/circle-progress.min.js') }}"></script>
    <!-- Bootstrap js file -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- Validator js file -->
    <script src="{{ asset('assets/js/validator.min.js') }}"></script>
    <!-- SlickNav js file -->
    <script src="{{ asset('assets/js/jquery.slicknav.js') }}"></script>
    <!-- Swiper js file -->
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
    <!-- Counter js file -->
    <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <!-- Magnific js file -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- SmoothScroll -->
    <script src="{{ asset('assets/js/SmoothScroll.js') }}"></script>
    <!-- Parallax js -->
    <script src="{{ asset('assets/js/parallaxie.js') }}"></script>
    <!-- MagicCursor js file -->
    <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
    <script src="{{ asset('assets/js/magiccursor.js') }}"></script>
    <!-- Text Effect js file -->
    <script src="{{ asset('assets/js/SplitText.min.js') }}"></script>
    <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
    <!-- YTPlayer js File -->
    <script src="{{ asset('assets/js/jquery.mb.YTPlayer.min.js') }}"></script>
    <!-- Wow js file -->
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <!-- Main Custom js file -->
    <script src="{{ asset('assets/js/function.js') }}"></script>
</body>
</html>