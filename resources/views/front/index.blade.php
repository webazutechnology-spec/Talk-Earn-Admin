@extends('front.layouts.app')

@section('content')
    
	<!-- Hero Section Start -->
	<div class="hero hero-slider">
		<div class="hero-slider-layout1">
			<div class="swiper">
				<div class="swiper-wrapper">
					<!-- Hero Slide Start -->
					<div class="swiper-slide">
						<div class="hero-slide">
							<!-- Slider Image Start -->
							<div class="hero-slider-image">
								<img src="{{ asset('images/banner/banner_2.jpg') }}" alt="">
							</div>
							<!-- Slider Image End -->
						</div>
					</div>
					<!-- Hero Slide End -->

					<!-- Hero Slide Start -->
					<div class="swiper-slide">
						<div class="hero-slide">
							<!-- Slider Image Start -->
							<div class="hero-slider-image">
								<img src="{{ asset('images/banner/banner-1.png') }}" alt="">
							</div>
							<!-- Slider Image End -->
						</div>
					</div>
					<!-- Hero Slide End -->

					<!-- Hero Slide Start -->
					<div class="swiper-slide">
						<div class="hero-slide">
							<!-- Slider Image Start -->
							<div class="hero-slider-image">
								<img src="{{ asset('images/banner/banner-2.png') }}" alt="">
							</div>
							<!-- Slider Image End -->
						</div>
					</div>
					<!-- Hero Slide End -->
				</div>

				<div class="hero-button-prev"></div>
				<div class="hero-button-next"></div>
			</div>  
		</div>		
	</div>
	<!-- Hero Section End -->


	<!-- About Layout 2 Section Start -->
	<div class="about-layout2">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<!-- About Image Slider Start -->
					<div class="about-image-slider">
						<!-- About Carousel Start -->
						<div class="about-carousel">
							<div class="swiper">
								<div class="swiper-wrapper">
									<!-- About Slide Start -->
									<div class="swiper-slide">
										<div class="about-image">
											<figure class="image-anime">
												<img src="{{ asset('assets/images/1.png') }}" alt="">
											</figure>
										</div>
									</div>
									<!-- About Slide End -->

									<!-- About Slide Start -->
									<div class="swiper-slide">
										<div class="about-image">
											<figure class="image-anime">
												<img src="{{ asset('assets/images/2.png') }}" alt="">
											</figure>
										</div>
									</div>
									<!-- About Slide End -->
									<!-- About Slide Start -->
									<div class="swiper-slide">
										<div class="about-image">
											<figure class="image-anime">
												<img src="{{ asset('assets/images/3.png') }}" alt="">
											</figure>
										</div>
									</div>
									<!-- About Slide End -->
									<!-- About Slide Start -->
									<div class="swiper-slide">
										<div class="about-image">
											<figure class="image-anime">
												<img src="{{ asset('assets/images/4.png') }}" alt="">
											</figure>
										</div>
									</div>
									<!-- About Slide End -->
								</div>
								
								<div class="about-button-prev"></div>
								<div class="about-button-next"></div>
							</div>
						</div>
						<!-- About Carousel End -->

						<!-- About Overlay Content Start -->
						<div class="about-layout2-overlay-content">
							<div class="row no-gap">
								<div class="col-md-6">
									<!-- About Overlay Item Start -->
									<div class="about-overaly-item">
										<div class="icon-box">
											<img src="{{ asset('assets/images/icon-domestic.svg') }}" alt="">
										</div>

										<h3>Domestic Installation</h3>
									</div>
									<!-- About Overlay Item End -->
								</div>

								<div class="col-md-6">
									<!-- About Overlay Item Start -->
									<div class="about-overaly-item about-overaly-item-active">
										<div class="icon-box">
											<img src="{{ asset('assets/images/icon-commercial.svg') }}" alt="">
										</div>

										<h3>Commercial Installation</h3>
									</div>
									<!-- About Overlay Item End -->
								</div>
							</div>
						</div>
						<!-- About Overlay Content End -->
					</div>
					<!-- About Image Slider End -->
				</div>

				<div class="col-lg-6">
					<!-- About Layout 2 Content Start -->
					<div class="about-layout2-content">
						<!-- Section Title Start -->
						<div class="section-title">
							<h3 class="wow fadeInUp">About Us</h3>
							<h2 class="text-anime">About {{ config('app.name') }}</h2>
						</div>
						<!-- Section Title End -->

						<!-- About Body Start  -->
						<div class="about-body wow fadeInUp" data-wow-delay="0.25s">
							<p>Kundan Solar is a trusted solar energy company providing reliable rooftop solar solutions for homes and businesses. We specialize in end-to-end solar services, including site survey, system design, installation, net-metering, and government subsidy support. Our goal is to make clean and affordable solar energy accessible while helping customers significantly reduce their electricity bills. With a strong focus on quality workmanship and long-term performance, we ensure every solar system is designed for maximum efficiency and durability. Backed by an experienced technical team and transparent processes, Kundan Solar delivers solar solutions that create real savings and long-lasting value.</p>


						</div>
						<!-- About Body End  -->

						<!-- About Stats Start -->
						<div class="about-stats">
							<div class="row">
								<div class="col-md-6">
									<!-- About Stats Item Start -->
									<div class="about-stats-item wow fadeInUp" data-wow-delay="0.5s">
										<div class="icon-box">
											<img src="{{ asset('assets/images/icon-capicity.svg') }}" alt="">
										</div>

										<div class="about-stats-content">
											<h3><span class="counter">500</span>+</h3>
											<p>Installed Solar Systems</p>
										</div>
									</div>
									<!-- About Stats Item End -->
								</div>

								<div class="col-md-6">
									<!-- About Stats Item Start -->
									<div class="about-stats-item wow fadeInUp" data-wow-delay="0.75s">
										<div class="icon-box">
											<img src="{{ asset('assets/images/icon-customer.svg') }}" alt="">
										</div>

										<div class="about-stats-content">
											<h3><span class="counter">10,00</span>+</h3>
											<p>Happy Customers</p>
										</div>
									</div>
									<!-- About Stats Item End -->
								</div>
							</div>
						</div>
						<!-- About Stats End -->

						<!-- About Footer Start -->
						<div class="about-footer wow fadeInUp" data-wow-delay="1s">
							<a href="#" class="btn-default">Read More About</a>
						</div>
						<!-- About Footer End -->
					</div>
					<!-- About Layout 2 Content End -->
				</div>
			</div>
		</div>
	</div>
	<!-- About Layout 2 Section End -->

	<!-- Features Layout 2 Section Start -->
	<div class="features-layout2 pt-0">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="features-layout2-box">
						<div class="row no-gap">

							<div class="col-md-4">
								<!-- Features Item Start -->
								<div class="features-item2 wow fadeInUp" data-wow-delay="0.25s">
									<div class="features-header">
										<div class="icon-box">
											<img src="{{ asset('assets/images/icon-feature-3.svg') }}" alt="">
										</div>
			
										<h3>24*7 Support</h3>
									</div>
			
									<div class="features-desc">
										<p>From site survey to installation and after-sales support, our team is always available to assist you. We provide continuous guidance for maintenance, performance monitoring, and government approvals whenever you need help.</p>
									</div>
								</div>
								<!-- Features Item End -->
							</div>
			
							<div class="col-md-4">
								<!-- Features Item Start -->
								<div class="features-item2 features-active">
									<div class="features-header">
										<div class="icon-box">
											<img src="{{ asset('assets/images/icon-feature-2.svg') }}" alt="">
										</div>
			
										<h3>High Quality Work</h3>
									</div>
			
									<div class="features-desc">
										<p>Our expert team follows professional engineering practices for system design, panel alignment, wiring, and installation. This ensures maximum power generation, long system life, and the best return on your solar investment.</p>
									</div>
								</div>
								<!-- Features Item End -->
							</div>
							
							<div class="col-md-4">
								<!-- Features Item Start -->
								<div class="features-item2 wow fadeInUp" data-wow-delay="0.25s">
									<div class="features-header">
										<div class="icon-box">
											<img src="{{ asset('assets/images/icon-feature-1.svg') }}" alt="">
										</div>
			
										<h3>Trust & Warrenty</h3>
									</div>
			
									<div class="features-desc">
										<p>We use high-quality solar panels and inverters backed by manufacturer warranties and industry standards. Every installation is completed with safety checks and long-term reliability in mind, ensuring peace of mind for our customers.</p>
									</div>
								</div>
								<!-- Features Item End -->
							</div>

						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
	<!-- Features Layout 2 Section End -->

	<!-- Our Services Section Start -->
	<div class="our-services">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Our Services</h3>
						<h2 class="text-anime">Best Solar Solutions for Renewable Energy</h2>
					</div>
					<!-- Section Title End -->
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<!-- Services Slider Start -->
					<div class="services-slider">
						<div class="swiper">
							<div class="swiper-wrapper">

								<!-- Service Slide Start -->
								<div class="swiper-slide">
									<div class="service-item">
										<div class="service-image">
											<figure>
												<img src="{{ asset('assets/images/service-2.jpg') }}" alt="">
											</figure>

											<div class="service-icon">
												<img src="{{ asset('assets/images/icon-service-2.svg') }}" alt="">
											</div>
										</div>

										<div class="service-content">
											<h3>Energy Saving Devices</h3>
											<p>Smart solar solutions designed to reduce electricity bills and improve energy efficiency for homes and businesses.</p>
										</div>
									</div>
								</div>
								<!-- Service Slide End -->

								<!-- Service Slide Start -->
								<div class="swiper-slide">
									<div class="service-item">
										<div class="service-image">
											<figure>
												<img src="{{ asset('assets/images/service-3.jpg') }}" alt="">
											</figure>

											<div class="service-icon">
												<img src="{{ asset('assets/images/icon-service-3.svg') }}" alt="">
											</div>
										</div>

										<div class="service-content">
											<h3>Solar Rooftop Solutions</h3>
											<p>Complete rooftop solar installation with system design, subsidy support, and hassle-free net-metering approvals.</p>
										</div>
									</div>
								</div>
								<!-- Service Slide End -->

								<!-- Service Slide Start -->
								<div class="swiper-slide">
									<div class="service-item">
										<div class="service-image">
											<figure>
												<img src="{{ asset('assets/images/service-1.jpg') }}" alt="">
											</figure>

											<div class="service-icon">
												<img src="{{ asset('assets/images/icon-service-1.svg') }}" alt="">
											</div>
										</div>

										<div class="service-content">
											<h3>Solar Maintenance</h3>
											<p>Regular cleaning and inspection to maintain high performance, safety, and long-term efficiency of your solar system.</p>
										</div>
									</div>
								</div>
								<!-- Service Slide End -->
								
								<!-- Service Slide Start -->
								<div class="swiper-slide">
									<div class="service-item">
										<div class="service-image">
											<figure>
												<img src="{{ asset('assets/images/service-2.jpg') }}" alt="">
											</figure>

											<div class="service-icon">
												<img src="{{ asset('assets/images/icon-service-2.svg') }}" alt="">
											</div>
										</div>

										<div class="service-content">
											<h3>Residential Solar Installation</h3>
											<p>Affordable rooftop solar systems for homes designed to reduce electricity bills and provide long-term savings.</p>
										</div>
									</div>
								</div>
								<!-- Service Slide End -->
							</div>

							<div class="swiper-pagination"></div>
						</div>
					</div>
					<!-- Services Slider End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Our Services Section End -->

	<!-- Our Process Section Start -->
	<div class="our-process">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Our Latest Process</h3>
						<h2 class="text-anime">Our Work Process</h2>
					</div>
					<!-- Section Title End -->
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<!-- Step Item Start -->
					<div class="step-item step-1 wow fadeInUp" data-wow-delay="0.25s">
						<div class="step-header">
							<div class="step-icon">
								<figure>
									<img src="{{ asset('assets/images/icon-step-1.svg') }}" alt="">
								</figure>
								<span class="step-no">01</span>
							</div>
						</div>

						<div class="step-content">
							<h3>Site Survey & Planning</h3>
							<p>We start with a detailed rooftop inspection and energy assessment to understand your electricity needs and plan the most efficient solar system.</p>
						</div>
					</div>
					<!-- Step Item End -->
				</div>

				<div class="col-md-4">
					<!-- Step Item Start -->
					<div class="step-item step-2 wow fadeInUp" data-wow-delay="0.5s">
						<div class="step-header">
							<div class="step-icon">
								<figure>
									<img src="{{ asset('assets/images/icon-step-2.svg') }}" alt="">
								</figure>
								<span class="step-no">02</span>
							</div>
						</div>

						<div class="step-content">
							<h3>System Design & Approval</h3>
							<p>Our experts design a customized solar solution and handle all documentation, including subsidy and net-metering approvals.</p>
						</div>
					</div>
					<!-- Step Item End -->
				</div>

				<div class="col-md-4">
					<!-- Step Item Start -->
					<div class="step-item wow fadeInUp" data-wow-delay="0.75s">
						<div class="step-header">
							<div class="step-icon">
								<figure>
									<img src="{{ asset('assets/images/icon-step-3.svg') }}" alt="">
								</figure>
								<span class="step-no">03</span>
							</div>
						</div>

						<div class="step-content">
							<h3>Solar Installation & Activation</h3>
							<p>The solar system is installed by trained professionals and activated after testing to ensure safe, smooth, and optimal performance.</p>
						</div>
					</div>
					<!-- Step Item End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Our Process Section End -->

	<!-- Intro Video Section Start -->
	{{-- <div class="intro-video">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="intro-video-box">
						<div class="video-image">
							<img src="{{ asset('assets/images/video-bg.jpg') }}" alt="">
						</div>

						<div class="video-play-button">
							<a href="https://www.youtube.com/watch?v=Y-x0efG1seA" class="popup-video">
								<img src="{{ asset('assets/images/play.svg') }}" alt="">
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> --}}
	<!-- Intro Video Section End -->

	<!-- Our Sklii Section Start -->
	<div class="our-skills">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Energy Progress</h3>
						<h2 class="text-anime">Best Solar Solution for Your Energy Needs</h2>
						<p class="wow fadeInUp" data-wow-delay="0.25s">Kundan Solar provides reliable and cost-effective rooftop solar solutions designed to maximize energy generation and long-term savings. Our systems are engineered to reduce electricity bills, increase energy independence, and support a cleaner, sustainable future for homes and businesses.</p>
					</div>
					<!-- Section Title End -->
				</div>

				<div class="col-lg-6">
					<div class="skills-box">
						<!-- Skill Item Start -->
						<div class="skillbar" data-percent="95%">
							<div class="skill-data">
								<div class="title">Solar Rooftop Systems</div>
								<div class="count">95%</div>
							</div>
							<div class="skill-progress">
								<div class="count-bar"></div>
							</div>
						</div>
						<!-- Skill Item End -->

						<!-- Skill Item Start -->
						<div class="skillbar" data-percent="80%">
							<div class="skill-data">
								<div class="title">Hybrid Solar Solutions</div>
								<div class="count">80%</div>
							</div>
							<div class="skill-progress">
								<div class="count-bar"></div>
							</div>
						</div>
						<!-- Skill Item End -->

						<!-- Skill Item Start -->
						<div class="skillbar" data-percent="70%">
							<div class="skill-data">
								<div class="title">Energy Optimization & Savings</div>
								<div class="count">70%</div>
							</div>
							<div class="skill-progress">
								<div class="count-bar"></div>
							</div>
						</div>
						<!-- Skill Item End -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Our Sklii Section End -->

	<!-- Infobar Section Start -->
	<div class="infobar">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="cta-box">
						<div class="row align-items-center">
							<div class="col-lg-4">
								<!-- CTA Image Start -->
								<div class="cta-image">
									<figure class="image-anime">
										<img src="{{ asset('assets/images/cta-image.jpg') }}" alt="">
									</figure>
								</div>
								<!-- CTA Image End -->
							</div>

							<div class="col-lg-8" id="have-questions">
								<!-- CTA Content Start -->
								<div class="cta-content">
									<div class="phone-icon">
										<figure>
											<img src="{{ asset('assets/images/icon-cta-phone.svg') }}" alt="">
										</figure>
									</div>									
									<h3 class="text-anime">Have Questions? <span>Call Us</span> {{ config('app.contact_us') }}</h3>
									<p class="wow fadeInUp" data-wow-delay="0.25s">Our solar experts are here to guide you with site survey, system selection, installation, subsidy support, and after-sales assistance. Get clear answers and expert advice before switching to solar.</p>
								</div>
								<!-- CTA Content End -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Infobar Section End -->

	<!-- Why Choose us Section Start -->
	<div class="why-choose-us" id="why-choose-us">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Why Choose Us</h3>
						<h2 class="text-anime">Providing Reliable Solar Energy Solutions</h2>
					</div>
					<!-- Section Title End -->
				</div>
			</div>

			<div class="row">
				<div class="col-lg-3 col-md-6">
					<!-- Why Choose Item Start -->
					<div class="why-choose-item wow fadeInUp" data-wow-delay="0.25s">
						<div class="why-choose-image">
							<img src="{{ asset('assets/images/whyus-1.jpg') }}" alt="">
						</div>

						<div class="why-choose-content">
							<div class="why-choose-icon">
								<img src="{{ asset('assets/images/icon-whyus-1.svg') }}" alt="">
							</div>

							<h3>Efficiency & Power</h3>
							<p>Our solar systems are designed to deliver maximum power output with high efficiency, ensuring long-term savings and consistent energy performance.</p>
						</div>
					</div>
					<!-- Why Choose Item End -->
				</div>

				<div class="col-lg-3 col-md-6">
					<!-- Why Choose Item Start -->
					<div class="why-choose-item wow fadeInUp" data-wow-delay="0.5s">
						<div class="why-choose-image">
							<img src="{{ asset('assets/images/whyus-2.jpg') }}" alt="">
						</div>

						<div class="why-choose-content">
							<div class="why-choose-icon">
								<img src="{{ asset('assets/images/icon-whyus-2.svg') }}" alt="">
							</div>

							<h3>Trust & Warranty</h3>
							<p>We use certified solar panels and inverters backed by manufacturer warranties, ensuring reliability, safety, and peace of mind for every customer.</p>
						</div>
					</div>
					<!-- Why Choose Item End -->
				</div>

				<div class="col-lg-3 col-md-6">
					<!-- Why Choose Item Start -->
					<div class="why-choose-item wow fadeInUp" data-wow-delay="0.75s">
						<div class="why-choose-image">
							<img src="{{ asset('assets/images/whyus-3.jpg') }}" alt="">
						</div>

						<div class="why-choose-content">
							<div class="why-choose-icon">
								<img src="{{ asset('assets/images/icon-whyus-3.svg') }}" alt="">
							</div>

							<h3>High Quality Work</h3>
							<p>Our experienced team follows professional installation standards, ensuring durable systems, clean workmanship, and optimal system performance.</p>
						</div>
					</div>
					<!-- Why Choose Item End -->
				</div>

				<div class="col-lg-3 col-md-6">
					<!-- Why Choose Item Start -->
					<div class="why-choose-item wow fadeInUp" data-wow-delay="1.0s">
						<div class="why-choose-image">
							<img src="{{ asset('assets/images/whyus-4.jpg') }}" alt="">
						</div>

						<div class="why-choose-content">
							<div class="why-choose-icon">
								<img src="{{ asset('assets/images/icon-whyus-4.svg') }}" alt="">
							</div>

							<h3>24*7 Support</h3>
							<p>From consultation to after-sales service, our support team is always available to assist with maintenance, performance monitoring, and guidance.</p>
						</div>
					</div>
					<!-- Why Choose Item End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Why Choose us Section End -->

	<!-- Counter Section Start -->
	<div class="stat-counter">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<!-- Counter Item Start -->
					<div class="counter-item">
						<div class="counter-icon">
							<img src="{{ asset('assets/images/icon-project.svg') }}" alt="">
						</div>

						<div class="counter-content">
							<h3><span class="counter">500</span>+</h3>
							<p>Project Done</p>
						</div>
					</div>
					<!-- Counter Item End -->
				</div>

				<div class="col-lg-3 col-md-6">
					<!-- Counter Item Start -->
					<div class="counter-item">
						<div class="counter-icon">
							<img src="{{ asset('assets/images/icon-happy-clients.svg') }}" alt="">
						</div>

						<div class="counter-content">
							<h3><span class="counter">10,00</span>+</h3>
							<p>Happy Clients</p>
						</div>
					</div>
					<!-- Counter Item End -->
				</div>

				<div class="col-lg-3 col-md-6">
					<!-- Counter Item Start -->
					<div class="counter-item">
						<div class="counter-icon">
							<img src="{{ asset('assets/images/icon-award.svg') }}" alt="">
						</div>

						<div class="counter-content">
							<h3><span class="counter">100</span>%</h3>
							<p>Quality-Focused Installations</p>
						</div>
					</div>
					<!-- Counter Item End -->
				</div>

				<div class="col-lg-3 col-md-6">
					<!-- Counter Item Start -->
					<div class="counter-item">
						<div class="counter-icon">
							<img src="{{ asset('assets/images/icon-ratting.svg') }}" alt="">
						</div>

						<div class="counter-content">
							<h3><span class="counter">4.8</span>*</h3>
							<p>Customer Satisfaction Rating</p>
						</div>
					</div>
					<!-- Counter Item End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Counter Section End -->

							<style>
						
							.tabs { 
								display: flex; 
								background: #f8f9fa; 
								border-radius: 36px; 
								border: 0.2px solid #439f58;
							}
							.tab-btn { 
								flex: 1; 
								padding: 15px; 
								text-align: 
								center; 
								cursor: pointer; 
								border: none; 
								background: none; 
								font-size: 1em; 
								font-weight: 500; 
								color: #666; 
								transition: all 0.3s; 
							}
							.tab-btn.active { 
								color: #399a50;
								border: 2px solid #399a50;
								background: #399a5021;
								border-radius: 28px;
								margin: 11px;
								padding: 2px;
								box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
							}
							.tab-content { display: none; padding-top: 20px; }
							.tab-content.active { display: block; animation: fadeIn 0.3s; }

							input::-webkit-outer-spin-button,
							input::-webkit-inner-spin-button {
							-webkit-appearance: none;
							margin: 0;
							}

							/* Firefox */
							input[type=number] {
							-moz-appearance: textfield;
							}
						</style>
						
	<!-- Solar Calculator Section Start -->
	<div class="solar-calculator">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Solar Calculator Form Start -->
					<div class="calculator-box wow fadeInUp">
						<div class="row">
							<div class="col-lg-3">
								<!-- Section Title Start -->
								<div class="section-title">
									<h3>Solar Calculator</h3>
									<h2>Your Solar Savings Calculator</h2>
								</div>
								<!-- Section Title End -->
							</div>

							<div class="col-lg-9">
								<!-- Solar Form Start -->
								<div class="solar-form">
									



		<div class="tabs">
			<button class="tab-btn active" onclick="switchTab('residential')">Residential</button>
			<button class="tab-btn" onclick="switchTab('commercial')">Commercial</button>
			<button class="tab-btn" onclick="switchTab('industrial')">Industrial</button>
		</div>
        <!-- RESIDENTIAL TAB -->
        <div id="residential" class="tab-content active">
            <div class="alert alert-info p-1">
                💡 For homes: Enter your monthly electricity bill or consumption to calculate required solar system size
            </div>
            <form id="residentialForm">
                <div class="row">
                    <div class="form-group col-md-4 mb-2">
                        <label>State</label>
                        <select id="res_state" class="form-control" name="state" required>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Monthly Electricity Bill (₹)</label>
                        <input type="number" class="form-control" id="res_bill" name="monthly_bill" step="100" placeholder="e.g., 3000">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>OR Monthly Consumption (kWh)</label>
                        <input type="number" class="form-control" id="res_consumption" name="monthly_consumption" step="10" placeholder="e.g., 400">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Available Rooftop Area (sq.ft)</label>
                        <input type="number" class="form-control" id="res_area" name="rooftop_area" step="10" placeholder="e.g., 500">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Desired System Capacity (kW)</label>
                        <input type="number" class="form-control" id="res_capacity" name="desired_capacity" step="0.5" placeholder="e.g., 5">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Panel Wattage</label>
                        <select name="panel_wattage" class="form-control" required>
                            <option value="330">330W</option>
                            <option value="550">550W</option>
                            <option value="600">600W</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn-default mt-4" onclick="calculate('residential')">Calculate Savings →</button>
            </form>
            <div id="residentialResults" class="results"></div>
        </div>

        <!-- COMMERCIAL TAB -->
        <div id="commercial" class="tab-content">
            <div class="alert alert-info p-1">
                🏢 For shops, offices, malls: Higher consumption = Faster returns on investment
            </div>
            <form id="commercialForm">
                <div class="row">
                    <div class="form-group col-md-4 mb-2">
                        <label>State</label>
                        <select id="com_state" class="form-control" name="state" required>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Monthly Electricity Bill (₹)</label>
                        <input type="number" class="form-control" id="com_bill" name="monthly_bill" step="100" placeholder="e.g., 50000">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>OR Monthly Consumption (kWh)</label>
                        <input type="number" class="form-control" id="com_consumption" name="monthly_consumption" step="10" placeholder="e.g., 5000">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Available Rooftop Area (sq.ft)</label>
                        <input type="number" class="form-control" id="com_area" name="rooftop_area" step="100" placeholder="e.g., 5000">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Desired System Capacity (kW)</label>
                        <input type="number" class="form-control" id="com_capacity" name="desired_capacity" step="1" placeholder="e.g., 50">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Panel Wattage</label>
                        <select name="panel_wattage" class="form-control" required>
                            <option value="330">330W</option>
                            <option value="550">550W (Recommended)</option>
                            <option value="600">600W</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn-default mt-4" onclick="calculate('commercial')">Calculate Savings →</button>
            </form>
            <div id="commercialResults" class="results"></div>
        </div>

        <!-- INDUSTRIAL TAB -->
        <div id="industrial" class="tab-content">
            <div class="alert alert-info p-1">
                🏭 For factories, warehouses, manufacturing: Massive ROI through open-access solar + tax benefits
            </div>
            <form id="industrialForm">
                <div class="row">
                    <div class="form-group col-md-4 mb-2">
                        <label>State</label>
                        <select id="ind_state" name="state" class="form-control" required>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Monthly Electricity Bill (₹)</label>
                        <input type="number" class="form-control" id="ind_bill" name="monthly_bill" step="1000" placeholder="e.g., 500000">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>OR Monthly Consumption (kWh)</label>
                        <input type="number" class="form-control" id="ind_consumption" name="monthly_consumption" step="100" placeholder="e.g., 50000">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Available Rooftop Area (sq.ft)</label>
                        <input type="number" class="form-control" id="ind_area" name="rooftop_area" step="1000" placeholder="e.g., 50000">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Desired System Capacity (kW) - Max 500 kW</label>
                        <input type="number" class="form-control" id="ind_capacity" name="desired_capacity" step="10" min="100" max="500" placeholder="e.g., 250">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label>Panel Wattage</label>
                        <select name="panel_wattage" class="form-control" required>
                            <option value="330">330W</option>
                            <option value="550">550W</option>
                            <option value="600">600W (Recommended)</option>
                        </select>
                    </div>
                </div>
                <button type="button" class="btn-default mt-4" onclick="calculate('industrial')">Calculate ROI & Benefits →</button>
            </form>
            <div id="industrialResults" class="results"></div>
        </div>

									{{-- <form id="solarForm" action="#" method="POST" data-toggle="validator">
										<div class="row">
											<div class="form-group col-md-6 mb-3">
												<select name="category" class="form-control" id="category" required >
													<option value="">Category</option>
													<option>Residential</option>
													<option>Commercial</option>
												</select>
												<div class="help-block with-errors"></div>
											</div>

											<div class="form-group col-md-6 mb-3">
												<input type="text" name="name" class="form-control" id="name" placeholder="Full Name" required >
												<div class="help-block with-errors"></div>
											</div>
			
			
											<div class="form-group col-md-6 mb-3">
												<input type="email" name ="email" class="form-control" id="email" placeholder="Email" required >
												<div class="help-block with-errors"></div>
											</div>
			
											<div class="form-group col-md-6 mb-3">
												<input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" required >
												<div class="help-block with-errors"></div>
											</div>
			
											<div class="form-group col-md-6 mb-3">
												<input type="text" name="bill" class="form-control" id="bill" placeholder="our Average Monthly Bill?" required >
												<div class="help-block with-errors"></div>
											</div>

											<div class="form-group col-md-6 mb-3">
												<input type="text" name="capacity" class="form-control" id="capacity" placeholder="Required Solar Plant Capacity (in kW)" required >
												<div class="help-block with-errors"></div>
											</div>
			
											<div class="col-md-12">
												<button type="submit" class="btn-default">Calculate</button>
												<div id="msgSubmit" class="h3 text-left hidden"></div>
											</div>
										</div>
									</form> --}}
								</div>
								<!-- Solar Form End -->
							</div>
						</div>
					</div>
					<!-- Solar Calculator Form End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Solar Calculator Section End -->

	<!-- Latest News Section Start -->
	<div class="latest-news">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Recent Articles</h3>
						<h2 class="text-anime">Our Latest News</h2>
					</div>
					<!-- Section Title End -->
				</div>
			</div>

			<div class="row">
                @foreach ($blogs as $item)
                <div class="col-lg-4 col-md-6">
                    <!-- Blog Item Start -->
                    <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">

                        <div class="post-featured-image">
                            <figure class="image-anime">
                                <img src="{{ asset('images/blog/' . $item->image) }}" onerror="this.onerror=null;this.src='{{ asset('images/image-not-found.png') }}';" alt="{{ $item->title }}">
                            </figure>
                        </div>

                        <div class="post-item-body">
                            <h2>
                                <a href="{{ route('blog-details', $item->slug) }}">
                                    {{ $item->title }}
                                </a>
                            </h2>

                            <div class="post-meta">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i class="fa-regular fa-calendar-days"></i>
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
                                            <i class="fa-solid fa-tag"></i>
                                            {{ $item->category->name ?? 'No Category' }}
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="btn-readmore">
                                <a href="{{ route('blog-details', $item->slug) }}" class="btn-default">Read More</a>
                            </div>
                        </div>

                    </div>
                    <!-- Blog Item End -->
                </div>
                @endforeach
			</div>
		</div>
	</div>
	<!-- Latest News Section End -->

	<!-- Latest Projects Layout 3 Start -->
	<div class="latest-post-layout3" id="client-review">
		<div class="container">
			<div class="row align-items-center section-title-row">
				<div class="col-lg-6">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Recent</h3>
						<h2 class="text-anime">Client Review</h2>
					</div>
					<!-- Section Title End -->
				</div>

				<div class="col-lg-6">
					<!-- Section Description Start -->
					<div class="section-description wow fadeInUp" data-wow-delay="0.2s">
						<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
					</div>
					<!-- Section Description End -->
				</div>
			</div>

			<div class="row">
				@foreach ($reviews as $item)
				<div class="col-lg-4 col-md-6">
					<!-- Project Item Start -->
					<div class="project-item wow fadeInUp" data-wow-delay="0.25s">
						<div class="project-image" style="background: #000000;">
							{{-- <figure> --}}
								<iframe src="{{$item->url}}" frameborder="0" height="300" width="100%"></iframe>
							{{-- </figure> --}}
						</div>

						<div class="project-content">
							<h2><a href="#">{{$item->title}}</a></h2>
						</div>

						{{-- <div class="project-link">
							<a href="{{ route('') }}"><img src="{{ asset('assets/images/icon-link.svg') }}" alt=""></a>
						</div> --}}
					</div>
					<!-- Project Item End -->
				</div>
				@endforeach
				</div>
			</div>
		</div>
	</div>
	<!-- Latest Projects Layout 3 End -->

<style>
	.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}
.modal-content-box {
    background: #fff;
    max-width: 900px;
    width: 95%;
    max-height: 90vh;
    overflow-y: auto;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    padding: 25px;
    position: relative;
}
.modal-close {
    position: absolute;
    top: 8px;
    right: 12px;
    border: none;
    background: transparent;
    font-size: 24px;
    cursor: pointer;
}

</style>
	<div id="resultModal" class="modal-overlay" style="display:none;">
		<div class="modal-content-box">
			<button class="modal-close" onclick="closeResultModal()">×</button>
			<div id="resultModalBody"></div>
		</div>
	</div>


@endsection
@push('scripts')
<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById(tab).classList.add('active');
    event.target.classList.add('active');
}

async function calculate(category) {
    const formId = category + 'Form';
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    
    const data = {
        category: category,
        monthly_bill: formData.get('monthly_bill') || null,
        monthly_consumption: formData.get('monthly_consumption') || null,
        rooftop_area: formData.get('rooftop_area') || null,
        desired_capacity: formData.get('desired_capacity') || null,
        state: formData.get('state'),
        panel_wattage: formData.get('panel_wattage'),
        consumer_type: formData.get('consumer_type') || null,
    };

    try {
		console.log( document.querySelector('meta[name="csrf-token"]')?.content);
        const response = await fetch('/calculate', {
            method: 'POST',
            headers: {
				'Content-Type': 'application/json',
				'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) throw new Error('Calculation failed');

        const result = await response.json();
        displayResults(category, result);
    } catch (error) {
        alert('Error: ' + error.message);
    }
}

function closeResultModal() {
    const modal = document.getElementById('resultModal');
    modal.style.display = 'none';
}

// Optional: close when clicking outside content
document.addEventListener('click', function (e) {
    const modal = document.getElementById('resultModal');
    if (!modal) return;
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});


function displayResults(category, data) {
    const modal = document.getElementById('resultModal');
    const body = document.getElementById('resultModalBody');

    let badgeClass = 'badge-success';
    let badgeText = '✓ Good';

    if (data.payback_period_months > 60) {
        badgeClass = 'badge-warning';
        badgeText = '⚠ Longer ROI';
    }

    let industrialBenefits = '';
    if (data.industrial_benefits) {
        industrialBenefits = `
            <div class="result-card">
                <h3>Tax Depreciation (40%)</h3>
                <div class="value">₹${formatNumber(data.industrial_benefits.tax_depreciation)}</div>
            </div>
            <div class="result-card">
                <h3>Additional Benefits</h3>
                <div class="unit">✓ Electricity Duty Waiver</div>
                <div class="unit">✓ Net Metering Enabled</div>
            </div>
        `;
    }

    body.innerHTML = `
        <h2>📊 Your Solar System Analysis</h2>
        <div class="result-grid">
            <div class="result-card">
                <h3>System Capacity</h3>
                <div class="value">${formatNumber(data.system_capacity_kw)}</div>
                <div class="unit">kW</div>
                <span class="badge ${badgeClass}">${badgeText}</span>
            </div>
            <div class="result-card">
                <h3>Solar Panels Required</h3>
                <div class="value">${formatNumber(data.panel_count)}</div>
                <div class="unit">${data.panel_wattage}W panels</div>
            </div>
            <div class="result-card">
                <h3>Rooftop Area Needed</h3>
                <div class="value">${formatNumber(data.area_required_sqft)}</div>
                <div class="unit">sq.ft (${formatNumber(data.area_required_sqm)} sq.m)</div>
            </div>
            <div class="result-card">
                <h3>Annual Generation</h3>
                <div class="value">${formatNumber(data.annual_generation_kwh)}</div>
                <div class="unit">kWh/year</div>
            </div>
            <div class="result-card">
                <h3>Installation Cost</h3>
                <div class="value">₹${formatNumber(data.installation_cost)}</div>
                <div class="unit">Total Cost</div>
            </div>
            <div class="result-card">
                <h3>Central Subsidy</h3>
                <div class="value">₹${formatNumber(data.central_subsidy)}</div>
                <div class="unit">Government Grant</div>
            </div>
            <div class="result-card">
                <h3>State Subsidy</h3>
                <div class="value">₹${formatNumber(data.state_subsidy || 0)}</div>
                <div class="unit">Additional Support</div>
            </div>
            <div class="result-card">
                <h3>Effective Cost</h3>
                <div class="value">₹${formatNumber(data.effective_cost || data.installation_cost)}</div>
                <div class="unit">After Subsidies</div>
            </div>
            <div class="result-card">
                <h3>Monthly Savings</h3>
                <div class="value">₹${formatNumber(data.monthly_savings)}</div>
                <div class="unit">Bill Reduction</div>
            </div>
            <div class="result-card">
                <h3>Payback Period</h3>
                <div class="value">${formatNumber(data.payback_period_months)}</div>
                <div class="unit">months</div>
            </div>
            <div class="result-card">
                <h3>25-Year Savings</h3>
                <div class="value">₹${formatNumber(data.savings_25_years)}</div>
                <div class="unit">Total Benefit</div>
            </div>
            <div class="result-card">
                <h3>Annual CO₂ Reduction</h3>
                <div class="value">${formatNumber(data.co2_reduction_annual)}</div>
                <div class="unit">kg/year (🌱 eco-friendly)</div>
            </div>
            ${industrialBenefits}
        </div>
    `;

    modal.style.display = 'flex';
}

function formatNumber(num) {
    if (num >= 1000000) return (num / 1000000).toFixed(2) + 'M';
    if (num >= 1000) return (num / 1000).toFixed(2) + 'K';
    return Number(num).toFixed(2);
}
</script>
@endpush