@extends('front.layouts.app')

@section('content')

<!-- Hero Section Start -->
<div class="hero bg-section dark-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<!-- Hero Content Start -->
				<div class="hero-content">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Smart. Simple. Seamless.</h3>
						<h1 class="text-anime-style-3" data-cursor="-opaque">Experience the future in your hands</h1>
						<!-- <p class="wow fadeInUp" data-wow-delay="0.2s">Experience the future in your hands with technology crafted to elevate your everyday life. Designed for comfort, speed, and seamless connectivity.</p> -->
					</div>
					<!-- Section Title End -->
					{{-- 
					<!-- App Download Buttons Start -->
					<div class="app-download-buttons wow fadeInUp" data-wow-delay="0.4s">
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
					--}}
					<!-- Hero Icon Boxes Start -->
					<div class="hero-icon-boxes">
						<!-- Hero Icon Box 1 Start -->
						<div class="hero-icon-box-1">
							<!-- Hero Icon Start -->
							<div class="hero-icon hero-icon-1">
								<img src="{{ asset('assets/images/icon-hero-1.png') }}" alt="">
							</div>
							<!-- Hero Icon End -->
							
							<!-- Hero Icon Start -->
							<div class="hero-icon hero-icon-2">
								<img src="{{ asset('assets/images/icon-hero-2.png') }}" alt="">
							</div>
							<!-- Hero Icon End -->
						</div>
						<!-- Hero Icon Box 1 End -->
						
						<!-- Hero Icon Box 2 Start -->
						<div class="hero-icon-box-2">
							<!-- Hero Icon Start -->
							<div class="hero-icon hero-icon-3">
								<img src="{{ asset('assets/images/icon-hero-3.png') }}" alt="">
							</div>
							<!-- Hero Icon End -->
							
							<!-- Hero Icon Start -->
							<div class="hero-icon hero-icon-4">
								<img src="{{ asset('assets/images/icon-hero-4.png') }}" alt="">
							</div>
							<!-- Hero Icon End -->
						</div>
						<!-- Hero Icon Box 2 End -->
					</div> 
					<!-- Hero Icon Boxes End -->

					<!-- Hero Image Box Start -->
					<div class="hero-image-box mt-0">
						<!-- Hero Rating Box Start -->
						{{-- 
						<div class="hero-rating-box">
							<div class="hero-rating-star">
								<i class="fa fa-solid fa-star"></i>
								<i class="fa fa-solid fa-star"></i>
								<i class="fa fa-solid fa-star"></i>
								<i class="fa fa-solid fa-star"></i>
								<i class="fa fa-solid fa-star"></i>
							</div>
							<div class="hero-rating-counter">
								<h2><span class="counter">4.8</span> <sub>App Rating</sub></h2>
							</div>
						</div>
						--}}
						<!-- Hero Rating Box End -->

						<!-- Satisfied Client Box Start -->
						{{-- 
						<div class="satisfied-client-box">
							<!-- Satisfied Client header Start -->
							<div class="satisfied-client-header">
								<p>Total Download App</p>
								<h2><span class="counter">1.5</span>m+</h2>
							</div>
							<!-- Satisfied Client header End -->

							<!-- Satisfied client Body Start -->
							<div class="satisfied-client-body">
								<!-- Satisfy Client Images Start -->
								<div class="satisfy-client-images">
									<div class="satisfy-client-image">
										<figure class="image-anime">
											<img src="{{ asset('assets/images/author-1.jpg') }}" alt="">
										</figure>
									</div>
									<div class="satisfy-client-image">
										<figure class="image-anime">
											<img src="{{ asset('assets/images/author-2.jpg') }}" alt="">
										</figure>
									</div>
									<div class="satisfy-client-image">
										<figure class="image-anime">
											<img src="{{ asset('assets/images/author-3.jpg') }}" alt="">
										</figure>
									</div>
									<div class="satisfy-client-image">
										<figure class="image-anime">
											<img src="{{ asset('assets/images/author-4.jpg') }}" alt="">
										</figure>
									</div>
								</div>
								<!-- Satisfy Client Images End --> 
								
								<!-- Satisfied Client Buton Start -->
								<div class="satisfied-client-btn">
									<a href="#"><img src="{{ asset('assets/images/icon-download-primary.svg') }}" alt=""></a>
								</div>
								<!-- Satisfied Client Buton End -->
							</div>
							<!-- Satisfied client Body End -->
						</div>
						--}}
						<!-- Satisfied Client Box End -->

						<!-- Hero Image Start -->
						<div class="hero-image">
							<figure>
								<img src="{{ asset('assets/images/hero-image.png') }}" alt="">
							</figure>
						</div>
						<!-- Hero Image End -->
					</div>
					<!-- Hero Image Box End -->
				</div>
				<!-- Hero Content End -->
			</div>
		</div>
	</div>
</div>
<!-- Hero Section End -->

<!-- About Us Section Start -->
<div class="about-us">
	<div class="container">
		<div class="row">
			<div class="col-xl-6">
				<!-- About Us Image Box Start -->
				<div class="about-us-image-box wow fadeInUp" data-wow-delay="0.2s">
					<!-- About Us Image Start -->
					<div class="about-us-image">
						<figure class="image-anime">
							<img src="{{ asset('assets/images/about-us-image.png') }}" alt="">
						</figure>
					</div>
					<!-- About Us Image End -->

					<!-- Customer Support Box Start -->
					<div class="customer-support-box">
						<div class="customer-support-content">
							<div class="customer-support-title">
								<h3>Need Help? Just Tap Support.</h3>
							</div>
							<div class="icon-box">
								<img src="{{ asset('assets/images/icon-headset.svg') }}" alt="">
							</div>
						</div>
					</div>
					<!-- Customer Support Box End -->

					<!-- App Download Circle Box Start -->
					<div class="app-download-circle-box">
						<div class="app-download-circle">
							<a href="#"><img src="{{ asset('assets/images/app-download-circle.svg') }}" alt=""></a>
						</div>
					</div>
					<!-- App Download Circle Box End -->
				</div>
				<!-- About Us Image Box End -->
			</div>

			<div class="col-xl-6">
				<!-- About Us Content Box Start -->
				<div class="about-us-content-box">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">About apps</h3>
						<h2 class="text-anime-style-3" data-cursor="-opaque">Simplifying technology through smart app innovations</h2>
						<p class="wow fadeInUp" data-wow-delay="0.2s">We believe in making technology effortless and accessible our team focuses on creating smart, intuitive apps that simplify everyday tasks, enhance productivity.</p>
					</div>
						<!-- Section Title End -->

					<!-- About Body Item List Start -->
					<div class="about-us-body wow fadeInUp" data-wow-delay="0.4s">
						<!-- About Body Item Start -->
						<div class="about-us-body-item">
							<div class="icon-box">
								<img src="{{ asset('assets/images/icon-about-body-item-1.svg') }}" alt="">
							</div>
							<div class="about-us-body-item-content">
								<h3>Cutting-Edge Technology</h3>
								<p>Built using the latest tools and frameworks for optimal performance.</p>
							</div>
						</div>
						<!-- About Body Item End -->

						<!-- About Body Item Start -->
						<div class="about-us-body-item">
							<div class="icon-box">
								<img src="{{ asset('assets/images/icon-about-body-item-2.svg') }}" alt="">
							</div>
							<div class="about-us-body-item-content">
								<h3>24/7 Support</h3>
								<p>Always available to assist and improve your app experience.</p>
							</div>
						</div>
						<!-- About Body Item End -->
					</div>
					<!-- About Body Item List End -->

					<!-- App Download Buttons Start -->
					<div class="app-download-buttons about-us-footer wow fadeInUp" data-wow-delay="0.6s">
						<!-- App Download Button Start -->
						<div class="app-download-btn">
							<a href="#"><img src="{{ asset('assets/images/icon-play-store.svg') }}" alt=""></a>
						</div>
						<!-- App Download Button End -->

						<!-- About Us Button Start -->
						<div class="about-us-btn">
							<a href="about.html" class="btn-default">More About Us</a>  
						</div>
						<!-- About Us Button End -->
					</div>
					<!-- App Download Buttons End -->
				</div>
				<!-- About Us Content Box End -->
			</div>
		</div>
	</div>
</div>
<!-- About Us Section End -->

<!-- Key Features Section Start -->
<div class="key-features bg-section">
	<div class="container">
		<div class="row section-row align-items-center">
			<div class="col-xl-7">
				<!-- Section Title Start -->
				<div class="section-title">
					<h3 class="wow fadeInUp">Key Features</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Comprehensive app features tailored to your vision</h2>
				</div>
					<!-- Section Title End -->
			</div>

			<div class="col-xl-5">
				<!-- Section Title Content Start -->
				<div class="section-title-content wow fadeInUp" data-wow-delay="0.2s">
					<p>We provide end-to-end app development services designed to match your unique goals and ideas. </p>
				</div>
				<!-- Section Title Content End -->
			</div>
		</div>

		<div class="row">
			<div class="col-xl-3 col-md-6">
				<!-- Key Features Item Start -->
				<div class="key-features-item wow fadeInUp">
					<div class="icon-box">
						<img src="{{ asset('assets/images/icon-features-1.svg') }}" alt="">
					</div>
					<div class="key-features-item-content">
						<div class="key-features-item-title">
							<h3>Mobile App Development</h3>
						</div>
						<div class="key-features-item-btn">
							<a href="contact.html" class="readmore-btn">View Details</a>
						</div>
					</div>
				</div>
				<!-- Key Features Item End -->
			</div>

			<div class="col-xl-3 col-md-6">
				<!-- Key Features Item Start -->
				<div class="key-features-item wow fadeInUp" data-wow-delay="0.2s">
					<div class="icon-box">
						<img src="{{ asset('assets/images/icon-features-2.svg') }}" alt="">
					</div>
					<div class="key-features-item-content">
						<div class="key-features-item-title">
							<h3>UI/UX Design</h3>
						</div>
						<div class="key-features-item-btn">
							<a href="contact.html" class="readmore-btn">View Details</a>
						</div>
					</div>
				</div>
				<!-- Key Features Item End -->
			</div>

			<div class="col-xl-3 col-md-6">
				<!-- Key Features Item Start -->
				<div class="key-features-item wow fadeInUp" data-wow-delay="0.4s">
					<div class="icon-box">
						<img src="{{ asset('assets/images/icon-features-3.svg') }}" alt="">
					</div>
					<div class="key-features-item-content">
						<div class="key-features-item-title">
							<h3>Web App Development</h3>
						</div>
						<div class="key-features-item-btn">
							<a href="contact.html" class="readmore-btn">View Details</a>
						</div>
					</div>
				</div>
				<!-- Key Features Item End -->
			</div>

			<div class="col-xl-3 col-md-6">
				<!-- Key Features Item Start -->
				<div class="key-features-item wow fadeInUp" data-wow-delay="0.6s">
					<div class="icon-box">
						<img src="{{ asset('assets/images/icon-features-4.svg') }}" alt="">
					</div>
					<div class="key-features-item-content">
						<div class="key-features-item-title">
							<h3>App Maintenance</h3>
						</div>
						<div class="key-features-item-btn">
							<a href="contact.html" class="readmore-btn">View Details</a>
						</div>
					</div>
				</div>
				<!-- Key Features Item End -->
			</div>

			<div class="col-xl-3 col-md-6">
				<!-- Key Features Item Start -->
				<div class="key-features-item wow fadeInUp" data-wow-delay="0.8s">
					<div class="icon-box">
						<img src="{{ asset('assets/images/icon-features-5.svg') }}" alt="">
					</div>
					<div class="key-features-item-content">
						<div class="key-features-item-title">
							<h3>App Testing & Quality</h3>
						</div>
						<div class="key-features-item-btn">
							<a href="contact.html" class="readmore-btn">View Details</a>
						</div>
					</div>
				</div>
				<!-- Key Features Item End -->
			</div>

			<div class="col-xl-3 col-md-6">
				<!-- Key Features Item Start -->
				<div class="key-features-item wow fadeInUp" data-wow-delay="1s">
					<div class="icon-box">
						<img src="{{ asset('assets/images/icon-features-6.svg') }}" alt="">
					</div>
					<div class="key-features-item-content">
						<div class="key-features-item-title">
							<h3>App Store Optimization</h3>
						</div>
						<div class="key-features-item-btn">
							<a href="contact.html" class="readmore-btn">View Details</a>
						</div>
					</div>
				</div>
				<!-- Key Features Item End -->
			</div>

			<div class="col-xl-3 col-md-6">
				<!-- Key Features Item Start -->
				<div class="key-features-item wow fadeInUp" data-wow-delay="1.2s">
					<div class="icon-box">
						<img src="{{ asset('assets/images/icon-features-7.svg') }}" alt="">
					</div>
					<div class="key-features-item-content">
						<div class="key-features-item-title">
							<h3>Backend Development</h3>
						</div>
						<div class="key-features-item-btn">
							<a href="contact.html" class="readmore-btn">View Details</a>
						</div>
					</div>
				</div>
				<!-- Key Features Item End -->
			</div>

			<div class="col-xl-3 col-md-6">
				<!-- Key Features Item Start -->
				<div class="key-features-item wow fadeInUp" data-wow-delay="1.4s">
					<div class="icon-box">
						<img src="{{ asset('assets/images/icon-features-8.svg') }}" alt="">
					</div>
					<div class="key-features-item-content">
						<div class="key-features-item-title">
							<h3>Integration Services</h3>
						</div>
						<div class="key-features-item-btn">
							<a href="contact.html" class="readmore-btn">View Details</a>
						</div>
					</div>
				</div>
				<!-- Key Features Item End -->
			</div>

			<div class="col-xl-12">
				<!-- Section Footer Text Start -->
				<div class="section-footer-text wow fadeInUp" data-wow-delay="0.2s">
					<p><span>Free</span>Let's make something great work together. <a href="contact.html">Get Free Quote</a></p>
				</div>
				<!-- Section Footer Text End -->
			</div>
		</div>
	</div>
</div>
<!-- Key Features Section End -->

<!-- Our Benefits Section Start -->
<div class="our-benefits">
	<div class="container">
		<div class="row section-row">
			<div class="col-lg-12">
				<!-- Section Title Start -->
				<div class="section-title section-title-center">
					<h3 class="wow fadeInUp">App Benefits</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Discover powerful features that simplify your life</h2>
				</div>
				<!-- Section Title End -->
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<!-- Benefits Item List Start -->
				<div class="benefits-item-list">
					<!-- Benefits Item Start -->
					<div class="benefits-item wow fadeInUp">
						<!-- Benefits Item Content Start -->
						<div class="benefits-item-content">
							<h3>Smart Notifications</h3>
							<p>Stay updated with personalized alerts and reminders.</p>
						</div>
						<!-- Benefits Item Content End -->

						<!-- Benefits Item Image Start -->
						<div class="benefits-item-image">
							<figure>
								<img src="{{ asset('assets/images/benefits-item-image-1.png') }}" alt="">
							</figure>
						</div>
						<!-- Benefits Item Image End -->
					</div>
					<!-- Benefits Item End -->  

					<!-- Benefits Item Start -->
					<div class="benefits-item wow fadeInUp" data-wow-delay="0.2s">
						<!-- Benefits Item Content Start -->
						<div class="benefits-item-content">
							<h3>Customizable Settings</h3>
							<p>Tailor the app experience to match your preferences.</p>
						</div>
						<!-- Benefits Item Content End -->

						<!-- Benefits Item Image Start -->
						<div class="benefits-item-image">
							<figure>
								<img src="{{ asset('assets/images/benefits-item-image-2.png') }}" alt="">
							</figure>
						</div>
						<!-- Benefits Item Image End -->
					</div>
					<!-- Benefits Item End -->  

					<!-- Benefits Item Start -->
					<div class="benefits-item wow fadeInUp" data-wow-delay="0.4s">
						<!-- Benefits Item Content Start -->
						<div class="benefits-item-content">
							<h3>24/7 Support</h3>
							<p>Get instant help from our friendly and supportive support team.</p>
						</div>
						<!-- Benefits Item Content End -->

						<!-- Benefits Item Image Start -->
						<div class="benefits-item-image">
							<figure>
								<img src="{{ asset('assets/images/benefits-item-image-3.png') }}" alt="">
							</figure>
						</div>
						<!-- Benefits Item Image End -->
					</div>
					<!-- Benefits Item End -->  
				</div>
				<!-- Benefits Item List End -->
			</div>

			<div class="col-lg-12">
				<!-- Section Footer Text Start -->
				<div class="section-footer-text wow fadeInUp" data-wow-delay="0.2s"> 
					<p>Join our team and help weave innovation, quality, and success together worldwide.</p>
					<ul>
						<li><span class="counter">4.9</span>/5</li>
						<li>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
						</li>
						<li>Our 4200 Review</li>
					</ul>
				</div>
				<!-- Section Footer Text End -->
			</div>
		</div>
	</div>
</div>
<!-- Our Benefits Section End -->

<!-- Why Choose Us Section Start -->
<div class="why-choose-us bg-section dark-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<!-- Why Choose Us Content Start -->
				<div class="why-choose-us-content">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Why Choose Us</h3>
						<h2 class="text-anime-style-3" data-cursor="-opaque">Your reliable partner for seamless app experiences</h2>
					</div>
					<!-- Section Title End -->

					<!-- Why Choose Us Button Start -->
					<div class="why-choose-us-btn wow fadeInUp" data-wow-delay="0.2s">
						<a href="contact.html" class="btn-default btn-highlighted">Start Your Journey</a>
					</div>
					<!-- Why Choose Us Button End -->

					<!-- Why Choose Us Image Start -->
					<div class="why-choose-us-image">
						<figure>
							<img src="{{ asset('assets/images/why-choose-us-image.png') }}" alt="">
						</figure>
					</div>
					<!-- Why Choose Us Image End -->
				</div>
				<!-- Why Choose Us Content End -->
			</div>
		</div>
	</div>
</div> 
<!-- Why Choose Us Section End -->

<!-- How It Works Section Start -->
<div class="how-it-work">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-xl-6">
				<!-- How It Work Content Start -->
				<div class="how-it-work-content">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">How It Works</h3>
						<h2 class="text-anime-style-3" data-cursor="-opaque">Experience innovation through three easy steps</h2>
					</div> 
					<!-- Section Title End -->

					<!-- How It Work Item List Start -->
					<div class="how-it-works-Item-List">
						<!-- How Work Item Start -->
						<div class="how-work-item wow fadeInUp" data-wow-delay="0.2s">
							<!-- How It Work Number Start -->
							<div class="how-it-work-number">
								<h3>01</h3>
							</div>
							<!-- How It Work Number End -->

							<!-- How Work Item Content Start -->
							<div class="how-work-item-content">
								<h3>Download the App</h3>
								<p>Get from the App Store or Google Play installation takes just a few seconds.</p>
							</div>
							<!-- How Work Item Content End -->
						</div>
						<!-- How Work Item End -->

						<!-- How Work Item Start -->
						<div class="how-work-item wow fadeInUp" data-wow-delay="0.4s">
							<!-- How It Work Number Start -->
							<div class="how-it-work-number">
								<h3>02</h3>
							</div>
							<!-- How It Work Number End -->

							<!-- How Work Item Content Start -->
							<div class="how-work-item-content">
								<h3>Create Your Account</h3>
								<p>Get from the App Store or Google Play installation takes just a few seconds.</p>
							</div>
							<!-- How Work Item Content End -->
						</div>
						<!-- How Work Item End -->

						<!-- How Work Item Start -->
						<div class="how-work-item wow fadeInUp" data-wow-delay="0.6s">
							<!-- How It Work Number Start -->
							<div class="how-it-work-number">
								<h3>03</h3>
							</div>
							<!-- How It Work Number End -->

							<!-- How Work Item Content Start -->
							<div class="how-work-item-content">
								<h3>Explore and Enjoy</h3>
								<p>Get from the App Store or Google Play installation takes just a few seconds.</p>
							</div>
							<!-- How Work Item Content End -->
						</div>
						<!-- How Work Item End -->

						<!-- How Work Item Start -->
						<div class="how-work-item wow fadeInUp" data-wow-delay="0.8s">
							<!-- How It Work Number Start -->
							<div class="how-it-work-number">
								<h3>04</h3>
							</div>
							<!-- How It Work Number End -->

							<!-- How Work Item Content Start -->
							<div class="how-work-item-content">
								<h3>Work Smarter, Not Harder</h3>
								<p>Get from the App Store or Google Play installation takes just a few seconds.</p>
							</div>
							<!-- How Work Item Content End -->
						</div>
						<!-- How Work Item End -->
					</div>
					<!-- How It Work Item List End -->
				</div>
				<!-- How It Work Content End -->
			</div>

			<div class="col-xl-6">
				<!-- How It Work Image Box Start -->
				<div class="how-it-work-image-box wow fadeInUp" data-wow-delay="0.2s">
					<!-- How It Work Image Box 1 Start -->
					<div class="how-it-work-image box-1">
						<figure>
							<img src="{{ asset('assets/images/how-it-work-image-1.png') }}" alt="">
						</figure>
					</div>
					<!-- How It Work Image Box 1 End -->

					<!-- How It Work Image Box 2 Start -->
					<div class="how-it-work-image box-2">
						<figure>
							<img src="{{ asset('assets/images/how-it-work-image-2.png') }}" alt="">
						</figure>
					</div>
					<!-- How It Work Image Box 2 End -->
				</div>
				<!-- How It Work Image Box End -->
			</div>
		</div>
	</div> 
</div>
<!-- How It Works Section End -->

<!-- Our Key Fact Section Start -->
<div class="our-key-fact bg-section">
	<div class="container">
		<div class="row section-row">
			<div class="col-lg-12">
				<!-- Section Title Start -->
				<div class="section-title section-title-center">
					<h3 class="wow fadeInUp">Our Key Fact</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Trusted by thousands powered by smart innovation</h2>
				</div>
				<!-- Section Title End -->
			</div>
		</div>

		<div class="row">
			<div class="col-xl-4 col-md-6">
				<!-- Key Fact Item Start -->
				<div class="key-fact-item wow fadeInUp">
					<!-- Key Fact Item Image Start -->
					<div class="key-fact-item-image">
						<figure>
							<img src="{{ asset('assets/images/key-fact-item-1.jpg') }}" alt="">
						</figure>
					</div>
					<!-- Key Fact Item Image End -->

					<!-- Key Fact Item Body Start -->
					<div class="key-fact-item-body">
						<!-- Key Fact Item Counter Start -->
						<div class="key-fact-item-counter">
							<h2><span class="counter">2500</span>+</h2>
						</div>
						<!-- Key Fact Item Counter End -->

						<!-- Key Fact Item Content Start -->
						<div class="key-fact-item-content">
							<h3>Tools & Platforms Integrated</h3>
							<p>We ensure your application runs smoothly with consistent uptime every month.</p>
						</div>
						<!-- Key Fact Item Content End -->
					</div>
					<!-- Key Fact Item Body End -->
				</div>
				<!-- Key Fact Item End -->
			</div>

			<div class="col-xl-4 col-md-6">
				<!-- Key Fact Item Start -->
				<div class="key-fact-item wow fadeInUp" data-wow-delay="0.2s">
					<!-- Key Fact Item Image Start -->
					<div class="key-fact-item-image">
						<figure>
							<img src="{{ asset('assets/images/key-fact-item-2.jpg') }}" alt="">
						</figure>
					</div>
					<!-- Key Fact Item Image End -->

					<!-- Key Fact Item Body Start -->
					<div class="key-fact-item-body">
						<!-- Key Fact Item Counter Start -->
						<div class="key-fact-item-counter">
							<h2><span class="counter">99.9</span>%</h2>
						</div>
						<!-- Key Fact Item Counter End -->

						<!-- Key Fact Item Content Start -->
						<div class="key-fact-item-content">
							<h3>Uptime Guaranteed Month</h3>
							<p>We ensure your application runs smoothly with consistent uptime every month.</p>
						</div>
						<!-- Key Fact Item Content End -->
					</div>
					<!-- Key Fact Item Body End -->
				</div>
				<!-- Key Fact Item End -->
			</div>

			<div class="col-xl-4 col-md-6">
				<!-- Key Fact Item Start -->
				<div class="key-fact-item wow fadeInUp" data-wow-delay="0.4s">
					<!-- Key Fact Item Image Start -->
					<div class="key-fact-item-image">
						<figure>
							<img src="{{ asset('assets/images/key-fact-item-3.jpg') }}" alt="">
						</figure>
					</div>
					<!-- Key Fact Item Image End -->

					<!-- Key Fact Item Body Start -->
					<div class="key-fact-item-body">
						<!-- Key Fact Item Counter Start -->
						<div class="key-fact-item-counter">
							<h2><span class="counter">24</span>/7</h2>
						</div>
						<!-- Key Fact Item Counter End -->

						<!-- Key Fact Item Content Start -->
						<div class="key-fact-item-content">
							<h3>Customer Support Availability</h3>
							<p>We ensure your application runs smoothly with consistent uptime every month.</p>
						</div>
						<!-- Key Fact Item Content End -->
					</div>
					<!-- Key Fact Item Body End -->
				</div>
				<!-- Key Fact Item End -->
			</div>
		</div>

		<div class="col-lg-12">
			<!-- Section Footer Text Start -->
			<div class="section-footer-text wow fadeInUp" data-wow-delay="0.4s">
				<p><span>Free</span>Let's make something great work together.<a href="contact.html"> Get Free Quote</a></p>
			</div>  
			<!-- Section Footer Text End -->
		</div>
	</div>
</div>
<!-- Our Key Fact Section End -->

<!-- Our Pricing Section Start -->
<div class="our-pricing">
	<div class="container">
		<div class="row section-row">
			<div class="col-lg-12">
				<!-- Section Title Start -->
				<div class="section-title section-title-center">
					<h3 class="wow fadeInUp">Pricing Plan</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Simple plan packed with powerful app features</h2>
				</div>
				<!-- Section Title End -->
			</div>
		</div>  

		<div class="row">
			<div class="col-xl-4 col-md-6">
				<!-- Pricing Item Start -->
				<div class="pricing-item wow fadeInUp">
					<!-- Pricing Item Header Start -->
					<div class="pricing-item-header">
						<!-- Pricing Item Box Start -->
						<div class="pricing-item-header-box">
							<div class="icon-box">
								<img src="{{ asset('assets/images/icon-pricing-1.svg') }}" alt="">
							</div>
							<div class="pricing-item-content">
								<h3>Basic Plan</h3>
								<p>Individuals and first-time users</p>
							</div>
						</div>
						<!-- Pricing Item Box End -->

						<!-- Pricing Price Start -->
						<div class="pricing-item-price">
							<h2>$19<sub>/per month</sub></h2>
						</div>
						<!-- Pricing Price End -->
					</div>
					<!-- Pricing Item Header Start -->

					<!-- Pricing Item Body Start -->
					<div class="pricing-item-body">
						<!-- Pricing Item List Start -->
						<div class="pricing-item-list">
							<h3>What Included Features:</h3>
							<ul>
								<li>Access to essential app features</li>
								<li>Regular updates and improvements</li>
								<li>Customizable settings and integrations</li>
								<li>API & advanced integration support</li>
							</ul>
						</div>
						<!-- Pricing Item List End -->

						<!-- Pricing Item Btn Start -->
						<div class="pricing-item-btn">
							<a href="contact.html" class="btn-default">Get Started</a>
						</div>
						<!-- Pricing Item Btn End -->
					</div>
					<!-- Pricing Item Body End -->
				</div>
				<!-- Pricing Item End -->
			</div>

			<div class="col-xl-4 col-md-6">
				<!-- Pricing Item Start -->
				<div class="pricing-item wow fadeInUp" data-wow-delay="0.2s">
					<!-- Pricing Item Header Start -->
					<div class="pricing-item-header">
						<!-- Pricing Item Box Start -->
						<div class="pricing-item-header-box">
							<div class="icon-box">
								<img src="{{ asset('assets/images/icon-pricing-2.svg') }}" alt="">
							</div>
							<div class="pricing-item-content">
								<h3>Pro Plan</h3>
								<p>Individuals and first-time users</p>
							</div>
						</div>
						<!-- Pricing Item Box End -->

						<!-- Pricing Price Start -->
						<div class="pricing-item-price">
							<h2>$29<sub>/per month</sub></h2>
						</div>
						<!-- Pricing Price End -->
					</div>
					<!-- Pricing Item Header Start -->

					<!-- Pricing Item Body Start -->
					<div class="pricing-item-body">
						<!-- Pricing Item List Start -->
						<div class="pricing-item-list">
							<h3>What Included Features:</h3>
							<ul>
								<li>Access to essential app features</li>
								<li>Regular updates and improvements</li>
								<li>Customizable settings and integrations</li>
								<li>API & advanced integration support</li>
							</ul>
						</div>
						<!-- Pricing Item List End -->

						<!-- Pricing Item Btn Start -->
						<div class="pricing-item-btn">
							<a href="contact.html" class="btn-default">Get Started</a>
						</div>
						<!-- Pricing Item Btn End -->
					</div>
					<!-- Pricing Item Body End -->
				</div>
				<!-- Pricing Item End -->
			</div>

			<div class="col-xl-4 col-md-6">
				<!-- Pricing Item Start -->
				<div class="pricing-item wow fadeInUp" data-wow-delay="0.4s">
					<!-- Pricing Item Header Start -->
					<div class="pricing-item-header">
						<!-- Pricing Item Box Start -->
						<div class="pricing-item-header-box">
							<div class="icon-box">
								<img src="{{ asset('assets/images/icon-pricing-3.svg') }}" alt="">
							</div>
							<div class="pricing-item-content">
								<h3>Enterprise Plan</h3>
								<p>Individuals and first-time users</p>
							</div>
						</div>
						<!-- Pricing Item Box End -->

						<!-- Pricing Price Start -->
						<div class="pricing-item-price">
							<h2>$39<sub>/per month</sub></h2>
						</div>
						<!-- Pricing Price End -->
					</div>
					<!-- Pricing Item Header Start -->

					<!-- Pricing Item Body Start -->
					<div class="pricing-item-body">
						<!-- Pricing Item List Start -->
						<div class="pricing-item-list">
							<h3>What Included Features:</h3>
							<ul>
								<li>Access to essential app features</li>
								<li>Regular updates and improvements</li>
								<li>Customizable settings and integrations</li>
								<li>API & advanced integration support</li>
							</ul>
						</div>
						<!-- Pricing Item List End -->

						<!-- Pricing Item Btn Start -->
						<div class="pricing-item-btn">
							<a href="contact.html" class="btn-default">Get Started</a>
						</div>
						<!-- Pricing Item Btn End -->
					</div>
					<!-- Pricing Item Body End -->
				</div>
				<!-- Pricing Item End -->
			</div>

			<div class="col-lg-12">
				<!-- Pricing Benefits List Start -->
				<div class="pricing-benefit-list wow fadeInUp" data-wow-delay="0.4s">
					<ul>
						<li><img src="{{ asset('assets/images/icon-pricing-benefit-1.svg') }}" alt="">Get 30 day free trial</li>
						<li><img src="{{ asset('assets/images/icon-pricing-benefit-2.svg') }}" alt="">No any hidden fees pay</li>
						<li><img src="{{ asset('assets/images/icon-pricing-benefit-3.svg') }}" alt="">You can cancel anytime</li>
					</ul>
				</div>
				<!-- Pricing Benefits List End -->
			</div>
		</div>
	</div>
</div>
<!-- Our Pricing Section End -->

<!-- Our Social Apps Section Start -->
<div class="our-social-apps bg-section dark-section">
	<div class="container-fluid">
		<div class="row section-row">
			<div class="col-lg-12">
				<!-- Section Title Start -->
				<div class="section-title section-title-center">
					<h3 class="wow fadeInUp">Social Apps</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Boost efficiency with seamless integration support</h2>
				</div>
				<!-- Section Title End -->
			</div>
		</div>

		<div class="row no-gutters">
			<div class="col-lg-12">
				<!-- Social App Slider Start -->
				<div class="social-app-slider">
					<div class="swiper">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-1.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>
							
							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-2.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>
							
							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-3.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>
							
							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-4.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>
							
							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-5.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>
							
							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-6.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>
							
							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-1.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>
							
							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-2.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>

							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-3.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>

							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-4.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>
							
							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-5.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>
							
							<div class="swiper-slide">
								<!-- Social App Item Start -->
								<div class="social-app-item">
									<div class="icon-box">
										<img src="{{ asset('assets/images/icon-social-app-6.svg') }}" alt="">
									</div>
								</div>
								<!-- Social App Item End -->
							</div>
						</div>
					</div>
				</div>
				<!-- Social App Slider End -->
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<!-- Social Apps Footer Start -->
				<div class="social-app-footer">
					<!-- Section Footer Text Start -->
					<div class="section-footer-text wow fadeInUp" data-wow-delay="0.2s"> 
						<p>Join our team and help weave innovation, quality, and success together worldwide.</p>
						<ul>
							<li><span class="counter">4.9</span>/5</li>
							<li>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
							</li>
							<li>Our 4200 Review</li>
						</ul>
					</div>
					<!-- Section Footer Text End -->
					
					<!-- App Download Buttons Start -->
					<div class="app-download-buttons wow fadeInUp" data-wow-delay="0.4s">
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
				<!-- Social Apps Footer End -->
			</div>
		</div>
	</div> 
</div>
<!-- Our Social Apps Section End -->

<!-- Our Interface Section Start -->
<div class="our-interface">
	<div class="container">
		<div class="row section-row">
			<div class="col-lg-12">
				<!-- Section Title Start -->
				<div class="section-title section-title-center">
					<h3 class="wow fadeInUp">Awesome Interface</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Preview the app through detailed screen displays</h2>
				</div>
				<!-- Section Title End -->
			</div>
		</div>

		<div class="row">
			<!-- Our Interface Slider Start -->
			<div class="our-interface-slider">
				<div class="swiper">
					<div class="swiper-wrapper" data-cursor-text="Drag">
						<!-- Company Support Logo Start -->
						<div class="swiper-slide">
							<div class="interface-slider-image">
								<img src="{{ asset('assets/images/interface-slider-image-1.png') }}" alt="">
							</div>
						</div>
						<!-- Comapany Support Logo End -->

						<!-- Company Support Logo Start -->
						<div class="swiper-slide">
							<div class="interface-slider-image">
								<img src="{{ asset('assets/images/interface-slider-image-2.png') }}" alt="">
							</div>
						</div>
						<!-- Comapany Support Logo End -->

						<!-- Company Support Logo Start -->
						<div class="swiper-slide">
							<div class="interface-slider-image">
								<img src="{{ asset('assets/images/interface-slider-image-3.png') }}" alt="">
							</div>
						</div>
						<!-- Comapany Support Logo End -->

						<!-- Company Support Logo Start -->
						<div class="swiper-slide">
							<div class="interface-slider-image">
								<img src="{{ asset('assets/images/interface-slider-image-4.png') }}" alt="">
							</div>
						</div>
						<!-- Comapany Support Logo End -->

						<!-- Company Support Logo Start -->
						<div class="swiper-slide">
							<div class="interface-slider-image">
								<img src="{{ asset('assets/images/interface-slider-image-5.png') }}" alt="">
							</div>
						</div>
						<!-- Comapany Support Logo End -->

						<!-- Company Support Logo Start -->
						<div class="swiper-slide">
							<div class="interface-slider-image">
								<img src="{{ asset('assets/images/interface-slider-image-6.png') }}" alt="">
							</div>
						</div>
						<!-- Comapany Support Logo End -->

						<!-- Company Support Logo Start -->
						<div class="swiper-slide">
							<div class="interface-slider-image">
								<img src="{{ asset('assets/images/interface-slider-image-7.png') }}" alt="">
							</div>
						</div>
						<!-- Comapany Support Logo End -->

						<!-- Company Support Logo Start -->
						<div class="swiper-slide">
							<div class="interface-slider-image">
								<img src="{{ asset('assets/images/interface-slider-image-8.png') }}" alt="">
							</div>
						</div>
						<!-- Comapany Support Logo End -->

						<!-- Company Support Logo Start -->
						<div class="swiper-slide">
							<div class="interface-slider-image">
								<img src="{{ asset('assets/images/interface-slider-image-9.png') }}" alt="">
							</div>
						</div>
						<!-- Comapany Support Logo End -->
					</div>
					<div class="interface-pagination"></div>
				</div>
			</div>
			<!-- Our Interface Slider End -->
		</div>
	</div>
</div>
<!-- Our Interface Section End -->

<!-- Testimonials Section Start -->
<div class="our-testimonials bg-section">
	<div class="container">
		<div class="row">
			<div class="col-xl-6">
				<!-- Testimonial Image Box Start -->
				<div class="testimonial-image-box">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Testimonials</h3>
						<h2 class="text-anime-style-3" data-cursor="-opaque">Hear what our satisfied users say about us</h2>
						<p class="wow fadeInUp" data-wow-delay="0.2s">Discover how APPZEN is making a difference for users worldwide real stories, real results — see why thousands trust.</p>
					</div>
					<!-- Section Title End -->

					<!-- Testimonial Image Start -->
					<div class="testimonial-image">
						<figure>
							<img src="{{ asset('assets/images/testimonial-image.png') }}" alt="">
						</figure>
					</div>
					<!-- Testimonial Image End -->
				</div>
				<!-- Testimonial Image Box End -->
			</div>

			<div class="col-xl-6">
				<!-- Testimonial Content Box Start -->
				<div class="testimonial-content-box">
					<!-- Testimonial Client Review Box Start -->
					<div class="testimonial-client-review-box">
						<!-- Testimonial Rating Box Start -->
						<div class="testimonial-review-item testimonial-rating-box wow fadeInUp">
							<!-- Testimonial Rating Star Start -->
							<div class="testimonial-rating-star">
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>
								<i class="fa-solid fa-star"></i>  
							</div>
							<!-- Testimonial Rating Star End -->

							<!-- Testimonial Rating Content Start -->
							<div class="testimonial-rating-content">
								<h2><span class="counter">4.8</span></h2>
								<p>User Average Rating</p>
							</div>
							<!-- Testimonial Rating Content End -->

							<!-- Testimonial Rating Image Start -->
							<div class="testimonial-rating-image">
								<img src="images/google-logo.svg" alt="">
							</div>
							<!-- Testimonial Rating Image End -->
						</div>
						<!-- Testimonial Rating Box End -->

						<!-- Testimonial Client Box Start -->
						<div class="testimonial-review-item testimonial-client-box wow fadeInUp" data-wow-delay="0.2s">
							<!-- Satisfy Client Images Start -->
							<div class="satisfy-client-images">
								<div class="satisfy-client-image">
									<figure class="image-anime">
										<img src="{{ asset('assets/images/author-1.jpg') }}" alt="">
									</figure>
								</div>
								<div class="satisfy-client-image">
									<figure class="image-anime">
										<img src="{{ asset('assets/images/author-2.jpg') }}" alt="">
									</figure>
								</div>
								<div class="satisfy-client-image">
									<figure class="image-anime">
										<img src="{{ asset('assets/images/author-3.jpg') }}" alt="">
									</figure>
								</div>
								<div class="satisfy-client-image">
									<figure class="image-anime">
										<img src="{{ asset('assets/images/author-4.jpg') }}" alt="">
									</figure>
								</div>
							</div>
							<!-- Satisfy Client Images End --> 

							<!-- Testimonial Rating Content Start -->
							<div class="testimonial-rating-content">
								<h2><span class="counter">1.5</span>m</h2>
								<p>Installations this Application</p>
							</div>
							<!-- Testimonial Rating Content End -->

							<!-- Testimonial Social Icons Start-->
							<div class="testimonial-social-icons">
								<ul>
									<li><a href="#"><i class="fa-brands fa-google-play"></i></a></li>
									<li><a href="#"><i class="fa-brands fa-app-store-ios"></i></a></li>
								</ul>
							</div>
							<!-- Testimonial Social Icons End -->
						</div>
						<!-- Testimonial Client Box End -->
					</div>
					<!-- Testimonial Client Review Box End -->

					<!-- Testimonial Slider Start -->
					<div class="testimonial-slider">
						<div class="swiper">
							<div class="swiper-wrapper" data-cursor-text="Drag">
								<!-- Testimonial Slide Start -->
								<div class="swiper-slide">
									<div class="testimonial-item">
										<!-- Testimonial Item Header Start -->
										<div class="testimonial-item-header">
											<div class="testimonial-item-rating">
												<i class="fa fa-solid fa-star"></i>
												<i class="fa fa-solid fa-star"></i>
												<i class="fa fa-solid fa-star"></i>
												<i class="fa fa-solid fa-star"></i>
												<i class="fa fa-solid fa-star"></i>
											</div>
											<div class="testimonial-item-content">
												<h3>“A user-friendly app with world-class support.”</h3>
												<p>“The best thing about [App Name] is how easy it is to get started. Within minutes, I was up and running with all the features I needed. I’ve contacted support twice, and both times the response was immediate and helpful. The team genuinely listens to feedback & rolls out updates regularly. It's rare to find a app that balance performance, design, and customer care so well.!”</p>
											</div>
										</div>
										<!-- Testimonial Item Header End -->

										<!-- Testimonial Item Author Start -->
										<div class="testimonial-item-author">
											<div class="testimonial-author-image">
												<figure class="image-anime">
													<img src="{{ asset('assets/images/author-3.jpg') }}" alt="">
												</figure>
											</div>
											<div class="testimonial-author-content">
												<h3>Sophia L</h3>
												<p>Digital Marketer</p>
											</div>
										</div>
										<!-- Testimonial Item Author End -->
									</div>
								</div>
								<!-- Testimonial Slide End -->

								<!-- Testimonial Slide Start -->
								<div class="swiper-slide">
									<div class="testimonial-item">
										<!-- Testimonial Item Header Start -->
										<div class="testimonial-item-header">
											<div class="testimonial-item-rating">
												<i class="fa fa-solid fa-star"></i>
												<i class="fa fa-solid fa-star"></i>
												<i class="fa fa-solid fa-star"></i>
												<i class="fa fa-solid fa-star"></i>
												<i class="fa fa-solid fa-star"></i>
											</div>
											<div class="testimonial-item-content">
												<h3>“A user-friendly app with world-class support.”</h3>
												<p>“The best thing about [App Name] is how easy it is to get started. Within minutes, I was up and running with all the features I needed. I’ve contacted support twice, and both times the response was immediate and helpful. The team genuinely listens to feedback & rolls out updates regularly. It's rare to find a app that balance performance, design, and customer care so well.!”</p>
											</div>
										</div>
										<!-- Testimonial Item Header End -->

										<!-- Testimonial Item Author Start -->
										<div class="testimonial-item-author">
											<div class="testimonial-author-image">
												<figure class="image-anime">
													<img src="{{ asset('assets/images/author-3.jpg') }}" alt="">
												</figure>
											</div>
											<div class="testimonial-author-content">
												<h3>Sophia L</h3>
												<p>Digital Marketer</p>
											</div>
										</div>
										<!-- Testimonial Item Author End -->
									</div>
								</div>
								<!-- Testimonial Slide End -->
							</div>
							<div class="testimonial-btn">
								<div class="testimonial-button-prev"></div>
								<div class="testimonial-button-next"></div>
							</div>
						</div>
					</div>
					<!-- Testimonial Slider End -->
				</div>
				<!-- Testimonial Content Box End -->
			</div>

			<div class="col-lg-12">
				<!-- Comapany Support Slider Box Start -->
				<div class="company-supports-slider-box">
					<!-- Comapany Support Content Start -->
					<div class="company-supports-content wow fadeInUp" data-wow-delay="0.2s">
						<hr>
						<p><span>550+</span> Company Using our Application</p>
						<hr>
					</div>
					<!-- Comapany Support Content End -->

					<!-- Comapany Support Slider Start -->
					<div class="company-supports-slider">
						<div class="swiper">
							<div class="swiper-wrapper">
								<!-- Company Support Logo Start -->
								<div class="swiper-slide">
									<div class="company-supports-logo">
										<img src="{{ asset('assets/images/company-supports-logo-1.svg') }}" alt="">
									</div>
								</div>
								<!-- Comapany Support Logo End -->

								<!-- Company Support Logo Start -->
								<div class="swiper-slide">
									<div class="company-supports-logo">
										<img src="{{ asset('assets/images/company-supports-logo-2.svg') }}" alt="">
									</div>
								</div>
								<!-- Comapany Support Logo End -->

								<!-- Company Support Logo Start -->
								<div class="swiper-slide">
									<div class="company-supports-logo">
										<img src="{{ asset('assets/images/company-supports-logo-3.svg') }}" alt="">
									</div>
								</div>
								<!-- Comapany Support Logo End -->

								<!-- Company Support Logo Start -->
								<div class="swiper-slide">
									<div class="company-supports-logo">
										<img src="{{ asset('assets/images/company-supports-logo-4.svg') }}" alt="">
									</div>
								</div>
								<!-- Comapany Support Logo End -->

								<!-- Company Support Logo Start -->
								<div class="swiper-slide">
									<div class="company-supports-logo">
										<img src="{{ asset('assets/images/company-supports-logo-5.svg') }}" alt="">
									</div>
								</div>
								<!-- Comapany Support Logo End -->

								<!-- Company Support Logo Start -->
								<div class="swiper-slide">
									<div class="company-supports-logo">
										<img src="{{ asset('assets/images/company-supports-logo-1.svg') }}" alt="">
									</div>
								</div>
								<!-- Comapany Support Logo End -->

								<!-- Company Support Logo Start -->
								<div class="swiper-slide">
									<div class="company-supports-logo">
										<img src="{{ asset('assets/images/company-supports-logo-3.svg') }}" alt="">
									</div>
								</div>
								<!-- Comapany Support Logo End -->
							</div>
						</div>
					</div>
					<!-- Comapany Support Slider End -->
				</div>
				<!-- Comapany Support Slider Box End -->
			</div>
		</div>
	</div>
</div>
<!-- Testimonials Section End -->

<!-- Our Blog Section Start -->
<div class="our-blog">
	<div class="container">
		<div class="row section-row">
			<div class="col-lg-12">
				<!-- Section Title Start -->
				<div class="section-title section-title-center">
					<h3 class="wow fadeInUp">Latest Blog</h3>
					<h2 class="text-anime-style-3" data-cursor="-opaque">Insights, updates, and innovations from our experts</h2>
				</div>
				<!-- Section Title End -->
			</div>
		</div>

		<div class="row">
			<div class="col-xl-4 col-md-6">
				<!-- Post Item Start -->
				<div class="post-item wow fadeInUp">
					<!-- Post Featured Image Start-->
					<div class="post-featured-image">
						<a href="blog-single.html" data-cursor-text="View">
							<figure class="image-anime">
								<img src="{{ asset('assets/images/post-1.jpg') }}" alt="">
							</figure>
						</a>
					</div>
					<!-- Post Featured Image End -->

					<!-- Post Item Body Start -->
					<div class="post-item-body">
						<!-- Post Item Content Start -->
						<div class="post-item-content">
							<h2><a href="blog-single.html">Building Apps That Users Truly Love</a></h2>
							<p>Go behind the scenes with our design and development team.</p>
						</div>
						<!-- Post Item Content End -->

						<!-- Post Item Readmore Button Start-->
						<div class="post-item-btn">
							<a href="blog-single.html" class="readmore-btn">read more</a>
						</div>
						<!-- Post Item Readmore Button End-->
					</div>
					<!-- Post Item Body End -->
				</div>
				<!-- Post Item End -->
			</div>

			<div class="col-xl-4 col-md-6">
				<!-- Post Item Start -->
				<div class="post-item wow fadeInUp" data-wow-delay="0.2s">
					<!-- Post Featured Image Start-->
					<div class="post-featured-image">
						<a href="blog-single.html" data-cursor-text="View">
							<figure class="image-anime">
								<img src="{{ asset('assets/images/post-2.jpg') }}" alt="">
							</figure>
						</a>
					</div>
					<!-- Post Featured Image End -->

					<!-- Post Item Body Start -->
					<div class="post-item-body">
						<!-- Post Item Content Start -->
						<div class="post-item-content">
							<h2><a href="blog-single.html">The Future of App Innovation in 2025</a></h2>
							<p>Go behind the scenes with our design and development team.</p>
						</div>
						<!-- Post Item Content End -->

						<!-- Post Item Readmore Button Start-->
						<div class="post-item-btn">
							<a href="blog-single.html" class="readmore-btn">read more</a>
						</div>
						<!-- Post Item Readmore Button End-->
					</div>
					<!-- Post Item Body End -->
				</div>
				<!-- Post Item End -->
			</div>

			<div class="col-xl-4 col-md-6">
				<!-- Post Item Start -->
				<div class="post-item wow fadeInUp" data-wow-delay="0.4s">
					<!-- Post Featured Image Start-->
					<div class="post-featured-image">
						<a href="blog-single.html" data-cursor-text="View">
							<figure class="image-anime">
								<img src="{{ asset('assets/images/post-3.jpg') }}" alt="">
							</figure>
						</a>
					</div>
					<!-- Post Featured Image End -->

					<!-- Post Item Body Start -->
					<div class="post-item-body">
						<!-- Post Item Content Start -->
						<div class="post-item-content">
							<h2><a href="blog-single.html">How  Boosts Everyday Productivity</a></h2>
							<p>Go behind the scenes with our design and development team.</p>
						</div>
						<!-- Post Item Content End -->

						<!-- Post Item Readmore Button Start-->
						<div class="post-item-btn">
							<a href="blog-single.html" class="readmore-btn">read more</a>
						</div>
						<!-- Post Item Readmore Button End-->
					</div>
					<!-- Post Item Body End -->
				</div>
				<!-- Post Item End -->
			</div>
		</div>
	</div>
</div>
<!-- Our Blog Section End -->

@endsection
@push('scripts')

@endpush