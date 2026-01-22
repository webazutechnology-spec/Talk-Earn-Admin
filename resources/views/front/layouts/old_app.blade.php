<!DOCTYPE html>
<html lang="zxx">

<head>
	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="Durgesh Verma">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Page Title -->
	<title>{{ config('app.name') }}</title>
	<!-- Favicon Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/config/'.config('app.auth_logo')) }}">
	<!-- Google Fonts css-->
	<link rel="preconnect" href="https://fonts.googleapis.com/">
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&amp;family=Rubik:wght@400;500&amp;display=swap" rel="stylesheet">
	<!-- Bootstrap css -->
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
	<!-- SlickNav css -->
	<link href="{{ asset('assets/css/slicknav.min.css') }}" rel="stylesheet">
	<!-- Swiper css -->
	<link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
	<!-- Font Awesome icon css-->
	<link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" media="screen">
	<!-- Animated css -->
	<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
	<!-- Magnific css -->
	<link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">
	<!-- Main custom css -->
	<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" media="screen">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<style>
    /* 1. The Fixed Button Wrapper */
    .whatsapp-btn-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999; /* Ensures it stays on top of other elements */
    }

    /* 2. The Link Button Styling */
    .whatsapp-btn {
        background-color: #25d366; /* WhatsApp Green */
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
    }

    /* 3. Hover Effects */
    .whatsapp-btn:hover {
        transform: scale(1.1); /* Slight zoom on hover */
        box-shadow: 2px 4px 15px rgba(0, 0, 0, 0.3);
    }

    /* 4. The Icon (SVG) Sizing */
    .whatsapp-icon {
        width: 35px;
        height: 35px;
        fill: white;
    }

    /* 5. Optional: Pulse Animation to grab attention */
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(37, 211, 102, 0); }
        100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
    }
    
    .whatsapp-btn-container {
        animation: pulse 2s infinite;
        border-radius: 50%;
    }
	</style>
</head>

<body class="tt-magic-cursor">

	<!-- Preloader Start -->
	<div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="{{ asset('images/config/'.config('app.auth_logo')) }}" alt="" style="filter: brightness(0) invert(1);"></div>
		</div>
	</div>
	<!-- Preloader End -->

	<!-- Magic Cursor Start -->
	<div id="magic-cursor">
		<div id="ball"></div>
	</div>
	<!-- Magic Cursor End -->

	<!-- Topbar Section Start -->
	<div class="topbar wow fadeInUp">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<!-- Topbar Contact Information Start -->
					<div class="topbar-contact-info">
						<ul>
							<li><a href="#"><i class="fa-solid fa-envelope"></i> {{ config('app.email_account') }}</a></li>
							<li><a href="#"><i class="fa-solid fa-phone"></i> {{ config('app.contact_us') }}</a></li>
						</ul>
					</div>
					<!-- Topbar Contact Information End -->
				</div>

				<div class="col-md-4">
					<!-- Topbar Social Links Start -->
					<div class="header-social-links">
						<ul>
							@if(config('app.facebook_url'))
								<li>
									<a href="{{ config('app.facebook_url') }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
								</li>
							@endif

							@if(config('app.twitter_url'))
								<li>
									<a href="{{ config('app.twitter_url') }}" target="_blank"><i class="fa-brands fa-twitter"></i></a>
								</li>
							@endif

							@if(config('app.linkedin_url'))
								<li>
									<a href="{{ config('app.linkedin_url') }}" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
								</li>
							@endif

							@if(config('app.instagram_url'))
								<li>
									<a href="{{ config('app.instagram_url') }}" target="_blank"><i class="fa-brands fa-instagram"></i></a>
								</li>
							@endif

								<li>
									<a href="javascript:;" href="https://wa.me/91{{ config('app.whatsapp') }}?text=Hello%20{{ config('app.name') }},%20I%20saw%20your%20website..." target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
								</li>
						</ul>
					</div>
					<!-- Topbar Social Links End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Topbar Section End -->

	<!-- Header Start -->
	<header class="main-header">
		<div class="header-sticky">
			<nav class="navbar navbar-expand-lg">
				<div class="container">
					<!-- Logo Start -->
					<a class="navbar-brand" href="{{ url('/') }}">
						<img src="{{ asset('images/config/'.config('app.logo')) }}" alt="Logo" style="width: 165px;">
					</a>
					<!-- Logo End -->

					<!-- Main Menu start -->
					<div class="collapse navbar-collapse main-menu">
						<ul class="navbar-nav mr-auto" id="menu">
							<li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
							<li class="nav-item"><a class="nav-link" href="{{ route('about-us') }}">About us</a></li>
							<li class="nav-item"><a class="nav-link" href="{{ route('our-services') }}">Services</a></li>
							<li class="nav-item"><a class="nav-link" href="{{ route('our-projects') }}">Review</a></li>
							<li class="nav-item"><a class="nav-link" href="{{ route('blog-list') }}">Blogs</a></li>
							<li class="nav-item"><a class="nav-link" href="{{ route('contact-us') }}">Contact</a></li>
							<li class="nav-item highlighted-menu"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
						</ul>
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

	<!-- Footer Ticker Start -->
	<div class="footer-ticker">
		<div class="scrolling-ticker">
            <div class="scrolling-ticker-box">
                <div class="scrolling-content">
                    <span>Generate Your Own Power</span>
					<span>{{ config('app.name') }}</span>
					<span>Heal the World</span>
					<span>Efficiency & Power</span>
					<span>24*7 Support</span>
                </div>

                <div class="scrolling-content">
                    <span>Generate Your Own Power</span>
					<span>{{ config('app.name') }}</span>
					<span>Heal the World</span>
					<span>Efficiency & Power</span>
					<span>24*7 Support</span>
                </div>
            </div>
        </div>
	</div>
	<!-- Footer Ticker End -->

	<!-- Footer Start -->
	<footer class="main-footer">
		<!-- Footer Contact Start -->
		<div class="footer-contact">
			<div class="container">
				<div class="row">
					<div class="col-lg-4">
						<!-- Footer Contact Box Start -->
						<div class="footer-contact-box wow fadeInUp" data-wow-delay="0.25s">
							<div class="contact-icon-box">
								<img src="{{ asset('assets/images/icon-email.svg') }}" alt="">
							</div>

							<div class="footer-contact-info">
								<h3>Support & Email</h3>
								<p>{{ config('app.email_account') }}</p>
							</div>
						</div>
						<!-- Footer Contact Box End -->
					</div>

					<div class="col-lg-4">
						<!-- Footer Contact Box Start -->
						<div class="footer-contact-box wow fadeInUp" data-wow-delay="0.5s">
							<div class="contact-icon-box">
								<img src="{{ asset('assets/images/icon-phone.svg') }}" alt="">
							</div>

							<div class="footer-contact-info">
								<h3>Customer Support</h3>
								<p>{{ config('app.contact_us') }}</p>
							</div>
						</div>
						<!-- Footer Contact Box End -->
					</div>

					<div class="col-lg-4">
						<!-- Footer Contact Box Start -->
						<div class="footer-contact-box wow fadeInUp" data-wow-delay="0.75s">
							<div class="contact-icon-box">
								<img src="{{ asset('assets/images/icon-location.svg') }}" alt="">
							</div>

							<div class="footer-contact-info">
								<h3>Our Location</h3>
								<p>{{ config('app.address') }}</p>
							</div>
						</div>
						<!-- Footer Contact Box End -->
					</div>
				</div>
			</div>
		</div>
		<!-- Footer Contact End -->

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Mega Footer Start -->
					<div class="mega-footer">
						<div class="row">
							<div class="col-lg-3 col-md-12">
								<!-- Footer About Start -->
								<div class="footer-about">
									<figure class="logo-box">
										<img src="{{ asset('images/config/'.config('app.logo')) }}" alt="" style="filter: brightness(0) invert(1);">
									</figure>
									<p>{{ config('app.name') }} is a long established fact that a reader will be distracted by the readable content of a page when.</p>
								</div>
								<!-- Footer About End -->

								<!-- Footer Social Link Start -->
								<div class="footer-social-links">
									<ul>
										@if(config('app.facebook_url'))
											<li>
												<a href="{{ config('app.facebook_url') }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
											</li>
										@endif

										@if(config('app.twitter_url'))
											<li>
												<a href="{{ config('app.twitter_url') }}" target="_blank"><i class="fa-brands fa-twitter"></i></a>
											</li>
										@endif

										@if(config('app.linkedin_url'))
											<li>
												<a href="{{ config('app.linkedin_url') }}" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
											</li>
										@endif

										@if(config('app.instagram_url'))
											<li>
												<a href="{{ config('app.instagram_url') }}" target="_blank"><i class="fa-brands fa-instagram"></i></a>
											</li>
										@endif

											<li>
												<a href="javascript:;" href="https://wa.me/91{{ config('app.whatsapp') }}?text=Hello%20{{ config('app.name') }},%20I%20saw%20your%20website..." target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
											</li>
									</ul>
								</div>
								<!-- Footer Social Link End -->
							</div>

							<div class="col-lg-3 col-md-4">
								<!-- Footer Links Start -->
								<div class="footer-links">
									<h2>Quick Links</h2>
									<ul>
										<li><a href="{{ route('home') }}">Home</a></li>
										<li><a href="{{ route('about-us') }}">About Us</a></li>
										<li><a href="{{ route('our-services') }}">Services</a></li>
										<li><a href="{{ route('blog-list') }}">Blog</a></li>
										<li><a href="{{ route('contact-us') }}">Contact Us</a></li>
									</ul>
								</div>
								<!-- Footer Links End -->
							</div>

							<div class="col-lg-3 col-md-4">
								<!-- Footer Links Start -->
								<div class="footer-links">
									<h2>Services</h2>
									<ul>
										<li><a href="{{ route('home') }}#have-questions">Have Questions</a></li>
										<li><a href="{{ route('home') }}#why-choose-us">Why Choose Us</a></li>
										<li><a href="{{ route('request-send') }}">Savings Calculator</a></li>
										<li><a href="{{ route('request-send') }}">Send Request</a></li>
										<li><a href="{{ route('home') }}#client-review">Client Review</a></li>
									</ul>
								</div>
								<!-- Footer Links End -->
							</div>

							<div class="col-lg-3 col-md-4">
								<!-- Footer Links Start -->
								<div class="footer-links">
									<h2>Useful Links</h2>
									<ul>
										<li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
										<li><a href="{{ route('terms') }}">Term & Conditions</a></li>
										<li><a href="{{ route('terms') }}">Warranty</a></li>
										<li><a href="{{ route('contact-us') }}">Support</a></li>
										<li><a href="{{ route('privacy-policy') }}">Damage Policy</a></li>
									</ul>
								</div>
								<!-- Footer Links End -->
							</div>
						</div>
					</div>
					<!-- Mega Footer End -->

					<!-- Copyright Footer Start -->
					<div class="footer-copyright">
						<div class="row">
							<div class="col-md-12">
								<!-- Footer Copyright Content Start -->
								<div class="footer-copyright-text">
									<p>Copyright © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
								</div>
								<!-- Footer Copyright Content End -->
							</div>
						</div>
					</div>
					<!-- Copyright Footer End -->
				</div>
			</div>
		</div>
	</footer>
	<!-- Footer End -->


	<div class="whatsapp-btn-container">
        <a class="whatsapp-btn" href="https://wa.me/91{{ config('app.whatsapp') }}?text=Hello%20{{ config('app.name') }},%20I%20saw%20your%20website..." target="_blank">
            <svg class="whatsapp-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                <path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/>
            </svg>
        </a>
    </div>

	<!-- Jquery Library File -->
	<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
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
	<script src="{{ asset('assets/js/splitType.js') }}"></script>
	<script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
	<!-- Wow js file -->
	<script src="{{ asset('assets/js/wow.js') }}"></script>
	<!-- Main Custom js file -->
	<script src="{{ asset('assets/js/function.js') }}"></script>
	{{-- <script src="{{ asset('assets/js/theme-panel.js') }}"></script> --}}

	@stack('scripts')
</body>

</html>