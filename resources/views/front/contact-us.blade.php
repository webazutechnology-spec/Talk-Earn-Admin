@extends('front.layouts.app')

@section('content')
	<!-- Page Header Start -->
	<div class="page-header parallaxie">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime">Contact us</h1>
						<nav class="wow fadeInUp" data-wow-delay="0.25s">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript:;">></a></li>
								<li class="breadcrumb-item active" aria-current="page">Contact us</li>
							</ol>
						</nav>
					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Page Header End -->

	<!-- Contact Information Section Start -->
	<div class="contact-information">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Contact Details</h3>
						<h2 class="text-anime">Happy to Answer All Your Questions</h2>
					</div>
					<!-- Section Title End -->
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<!-- Contact Info Item Start -->
					<div class="contact-info-item wow fadeInUp" data-wow-delay="0.25s">
						<div class="contact-image">
							<figure class="image-anime">
								<img src="{{ asset('assets/images/location-img.jpg') }}" alt="">
							</figure>
						</div>

						<div class="contact-info-content">
							<h3>Our Addresses:</h3>
							<p>{{ config('app.address') }}</p>
						</div>

						<div class="contact-icon">
							<img src="{{ asset('assets/images/icon-location.svg') }}" alt="">
						</div>
					</div>
					<!-- Contact Info Item End -->
				</div>

				<div class="col-lg-3 col-md-6">
					<!-- Contact Info Item Start -->
					<div class="contact-info-item wow fadeInUp" data-wow-delay="0.5s">
						<div class="contact-image">
							<figure class="image-anime">
								<img src="{{ asset('assets/images/email-img.jpg') }}" alt="">
							</figure>
						</div>

						<div class="contact-info-content">
							<h3>Emails:</h3>
							<p>{{ config('app.email_account') }}<br> .</p>
						</div>

						<div class="contact-icon">
							<img src="{{ asset('assets/images/icon-mail.svg') }}" alt="">
						</div>
					</div>
					<!-- Contact Info Item End -->
				</div>

				<div class="col-lg-3 col-md-6">
					<!-- Contact Info Item Start -->
					<div class="contact-info-item wow fadeInUp" data-wow-delay="0.75s">
						<div class="contact-image">
							<figure class="image-anime">
								<img src="{{ asset('assets/images/phone-img.jpg') }}" alt="">
							</figure>
						</div>

						<div class="contact-info-content">
							<h3>Phones:</h3>
							<p>{{ config('app.contact_us') }}<br>{{ config('app.whatsapp') }}</p>
						</div>

						<div class="contact-icon">
							<img src="{{ asset('assets/images/icon-phone.svg') }}" alt="">
						</div>
					</div>
					<!-- Contact Info Item End -->
				</div>

				<div class="col-lg-3 col-md-6">
					<!-- Contact Info Item Start -->
					<div class="contact-info-item wow fadeInUp" data-wow-delay="1.0s">
						<div class="contact-image">
							<figure class="image-anime">
								<img src="{{ asset('assets/images/follow-img.jpg') }}" alt="">
							</figure>
						</div>

						<div class="contact-info-content">
							<h3>Follow Us:</h3>
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

						<div class="contact-icon">
							<img src="{{ asset('assets/images/icon-follow.svg') }}" alt="">
						</div>
					</div>
					<!-- Contact Info Item End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Contact Information Section End -->

	<!-- Google Map & Contact Form Section Start -->
	<div class="google-map-form">
		<div class="google-map">
			<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d56481.31329163797!2d-82.30112043759952!3d27.776444959332093!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sUnited%20States%20solar!5e0!3m2!1sen!2sin!4v1706008331370!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-lg-6 offset-lg-6">
					<div class="contact-form-box">
						<!-- Section Title Start -->
						<div class="section-title">
							<h3 class="wow fadeInUp">Contact Now</h3>
							<h2 class="text-anime">Get In Touch With Us</h2>
						</div>
						<!-- Section Title End -->

						<!-- Contact Form start -->
						<div class="contact-form wow fadeInUp" data-wow-delay="0.75s">

                            <form id="contactForm" action="{{ route('contact.submit') }}" method="POST" data-toggle="validator">
                                @csrf

                                <div class="row">

                                    <!-- Name -->
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="text" 
                                            name="name" 
                                            class="form-control"
                                            value="{{ old('name') }}"
                                            placeholder="Name" required>
                                        <div class="help-block with-errors"></div>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="email" 
                                            name="email" 
                                            class="form-control"
                                            value="{{ old('email') }}"
                                            placeholder="Email" required>
                                        <div class="help-block with-errors"></div>
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="text" 
                                            name="phone" 
                                            class="form-control"
                                            value="{{ old('phone') }}"
                                            placeholder="Phone" required
                                            pattern="[6-9]{1}[0-9]{9}"
                                            title="Enter a valid 10-digit Indian mobile number starting with 6–9">
                                        <div class="help-block with-errors"></div>
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Subject -->
                                    <div class="form-group col-md-6 mb-4">
                                        <input type="text" 
                                            name="subject" 
                                            class="form-control"
                                            value="{{ old('subject') }}"
                                            placeholder="Subject" required>
                                        <div class="help-block with-errors"></div>
                                        @error('subject')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Message -->
                                    <div class="form-group col-md-12 mb-4">
                                        <textarea name="message" 
                                                class="form-control" 
                                                rows="4"
                                                placeholder="Write a Message" required>{{ old('message') }}</textarea>
                                        <div class="help-block with-errors"></div>
                                        @error('message')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn-default">Submit Now</button>
                                        <div id="messageSubmit" class="h3 text-left hidden"></div>
                                        @if(session('success'))
                                            <div class="h3 text-success">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </form>

						</div>
						<!-- Contact Form end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Google Map & Contact Form Section End -->
	
@endsection
@push('scripts')

@endpush