<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ Cookie::get('theme_style', 'light-theme') }}">  {{-- dark-theme , minimal-theme, light-theme --}}
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
	<!--favicon-->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/config/'.config('app.auth_logo')) }}">
	<!--plugins-->
	<link rel="stylesheet" href="{{ asset('admin/assets/plugins/notifications/css/lobibox.min.css') }}" />
	<link href="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet"/>
	<link href="{{ asset('admin/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('admin/assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('admin/assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ asset('admin/assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/css/dark-theme.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin/assets/css/semi-dark.css') }}" />
	<link rel="stylesheet" href="{{ asset('admin/assets/css/header-colors.css') }}" />
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="{{ asset('images/config/'.config('app.logo')) }}" class="logo-icon toggle-icon" alt="logo icon">
					<img src="{{ asset('images/config/'.config('app.auth_logo')) }}" class="logo-icon toggle-icons" alt="logo icon">
				</div>
				{{-- <div>
					<h4 class="logo-text">{{ config('app.name') }}</h4>
				</div> --}}
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			@php
				$roleId = Auth::user()->role_id;

				$modules = \App\Models\Module::forRole($roleId)
							->whereNull('parent_id')
							->with(['children' => function ($q) use ($roleId) {
								$q->forRole($roleId)->orderBy('order');
							}])->orderBy('order', 'asc')->get();
			@endphp
			<ul class="metismenu" id="menu">
				@foreach ($modules as $module)
				<li>
					<a href="{{ $module->view_url != 'javascript:void(0)' ? route($module->view_url) : 'javascript:void(0)' }}" class="{{ $module->children->isNotEmpty() ? 'has-arrow' : '' }}">
						<div class="parent-icon">
							{{-- <i class="bx bx-category"></i> --}}
							<i class="{{ $module->icon }}"></i>
						</div>
						<div class="menu-title">{{ $module->name }}</div>
					</a>
					@if ($module->children->isNotEmpty())
					<ul>
						@foreach ($module->children as $child)
						<li> 
							<a href="{{ $child->view_url != 'javascript:void(0)' ? route($child->view_url) : 'javascript:void(0)' }}">
								<i class="bx bx-right-arrow-alt"></i>{{ $child->name }}
							</a>
						</li>
						@endforeach
					</ul>
					@endif
				</li>
                @endforeach
				<li>
					<a class="text-danger" style="text-decoration: none; background-color: rgb(255 16 5 / 10%);" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" >
						<div class="parent-icon"><i class="bx bx-log-out-circle"></i></div>
						<div class="menu-title">Logout</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand gap-3">
					<div class="mobile-toggle-menu"><i class="bx bx-menu"></i>
					</div>

					{{-- <div class="search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
						<a href="avascript:;" class="btn d-flex align-items-center"><i class="bx bx-search"></i>Search</a>
					 </div> --}}
					  <div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center gap-1">
							{{-- <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
								<a class="nav-link" href="avascript:;"><i class="bx bx-search"></i>
								</a>
							</li> --}}
							<li class="nav-item dark-mode d-none d-sm-flex">
								<a class="nav-link dark-mode-icon" href="javascript:;"><i class="bx bx-moon"></i>
								</a>
							</li>
							<li class="nav-item dropdown dropdown-app">
								{{-- <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown" href="javascript:;"><i class="bx bx-grid-alt"></i></a>
								<div class="dropdown-menu dropdown-menu-end">
									<div class="row row-cols-3 g-3 p-3">
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-cosmic text-white"><i class='bx bx-group'></i>
											</div>
											<div class="app-title">Teams</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-burning text-white"><i class='bx bx-atom'></i>
											</div>
											<div class="app-title">Projects</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-lush text-white"><i class='bx bx-shield'></i>
											</div>
											<div class="app-title">Tasks</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-kyoto text-dark"><i class='bx bx-notification'></i>
											</div>
											<div class="app-title">Feeds</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-blues text-dark"><i class='bx bx-file'></i>
											</div>
											<div class="app-title">Files</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto bg-gradient-moonlit text-white"><i class='bx bx-filter-alt'></i>
											</div>
											<div class="app-title">Alerts</div>
										</div>
									</div>
								</div> --}}
							</li>

							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" data-bs-toggle="dropdown">
									@php
										$unreadCount = auth()->user()->unreadNotifications->count();
									@endphp
									
									@if($unreadCount > 0)
										<span class="alert-count">{{ $unreadCount }}</span>
									@endif
									<i class="bx bx-bell"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Notifications</p>
											<p class="msg-header-badge">{{ $unreadCount }} New</p>
										</div>
									</a>
									<div class="header-notifications-list ps">
										@forelse(auth()->user()->unreadNotifications as $notification)
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify bg-light-primary text-primary">
													<i class="{{ $notification->data['icon'] ?? 'bx bx-message-detail' }}"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">{{ $notification->data['title'] ?? 'New Notification' }}<span class="msg-time float-end">{{ $notification->created_at->diffForHumans() }}</span></h6>
													<p class="msg-info">{{ Str::limit($notification->data['message'] ?? '', 40) }}</p>
												</div>
											</div>
										</a>
										@empty
											<a class="dropdown-item" href="javascript:;">
												<div class="d-flex align-items-center">
													<div class="flex-grow-1 text-center">
														<p class="msg-info mb-0">No new notifications</p>
													</div>
												</div>
											</a>
										@endforelse
										
										<div class="ps__rail-x" style="left: 0px; bottom: 0px;">
											<div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
										</div>
										<div class="ps__rail-y" style="top: 0px; right: 0px;">
											<div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
										</div>
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer d-flex">
											<a href="{{ route('notifications') }}" class="btn btn-primary w-100 me-2">View All</a>
											<a href="{{ route('notifications.markAll') }}" class="btn btn-primary w-100">Mark Read</a>
										</div>
									</a>
								</div>
							</li>
							{{-- <li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative show" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="true"> <span class="alert-count">8</span>
									<i class="bx bx-shopping-bag"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end show" data-bs-popper="static">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">My Cart</p>
											<p class="msg-header-badge">10 Items</p>
										</div>
									</a>
									<div class="header-message-list ps">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="assets/images/products/11.png" class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="assets/images/products/02.png" class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="assets/images/products/03.png" class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="assets/images/products/04.png" class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="assets/images/products/05.png" class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="assets/images/products/06.png" class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="assets/images/products/07.png" class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="assets/images/products/08.png" class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center gap-3">
												<div class="position-relative">
													<div class="cart-product rounded-circle bg-light">
														<img src="assets/images/products/09.png" class="" alt="product image">
													</div>
												</div>
												<div class="flex-grow-1">
													<h6 class="cart-product-title mb-0">Men White T-Shirt</h6>
													<p class="cart-product-price mb-0">1 X $29.00</p>
												</div>
												<div class="">
													<p class="cart-price mb-0">$250</p>
												</div>
												<div class="cart-product-cancel"><i class="bx bx-x"></i>
												</div>
											</div>
										</a>
									<div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
									<a href="javascript:;">
										<div class="text-center msg-footer">
											<div class="d-flex align-items-center justify-content-between mb-3">
												<h5 class="mb-0">Total</h5>
												<h5 class="mb-0 ms-auto">$489.00</h5>
											</div>
											<button class="btn btn-primary w-100">Checkout</button>
										</div>
									</a>
								</div>
							</li> --}}
						</ul>
					</div>
					<div class="user-box dropdown px-3">
						@php
							$profile = 'images/user-1.svg';
							if (auth()->user()->gender == 'Female') {
								$profile = 'images/user-2.svg';
							}
						@endphp
						<a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="{{ asset('images/profile/' . auth()->user()->image) }}" onerror="this.onerror=null;this.src='{{ asset($profile) }}';" class="user-img" alt="user avatar">
							<div class="user-info">
								<p class="user-name mb-0">{{ Auth::user()->name }}</p>
								<p class="designattion mb-0">{{ Auth::user()->roles->name }}</p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item d-flex align-items-center" href="{{ route('dashboard') }}"><i class="bx bx-home-circle fs-5"></i><span>Dashboard</span></a>
							</li>
							<li><a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}"><i class="bx bx-user fs-5"></i><span>Profile</span></a>
							</li>
							<li><a class="dropdown-item d-flex align-items-center" href="{{ route('security') }}"><i class="bx bx-cog fs-5"></i><span>Security</span></a>
							</li>
							<li><a class="dropdown-item d-flex align-items-center" href="{{ route('login-activity') }}"><i class="bx bx-network-chart fs-5"></i><span>Login Activity</span></a>
							</li>
							<li><a class="dropdown-item d-flex align-items-center" href="{{ route('activity-log') }}"><i class="bx bx-vector fs-5"></i><span>Activity Log</span></a>
							</li>
							<li><div class="dropdown-divider mb-0"></div></li>
							<li>
								<a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class='bx bx-log-out-circle'></i><span>Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
                @yield('content')
            </div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		  <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © {{ date('Y') }}. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->

	<!-- search modal -->
    <div class="modal" id="SearchModal" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down">
		  <div class="modal-content">
			<div class="modal-header gap-2">
			  <div class="position-relative popup-search w-100">
				<input class="form-control form-control-lg ps-5 border border-3 border-primary" type="search" placeholder="Search">
				<span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-4"><i class='bx bx-search'></i></span>
			  </div>
			  <button type="button" class="btn-close d-md-none" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="search-list">
				   <p class="mb-1">Html Templates</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action active align-items-center d-flex gap-2 py-1"><i class='bx bxl-angular fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vuejs fs-4'></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-magento fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-shopify fs-4'></i>eCommerce Html Templates</a>
				   </div>
				   <p class="mb-1 mt-3">Web Designe Company</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-windows fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-dropbox fs-4' ></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-opera fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-wordpress fs-4'></i>eCommerce Html Templates</a>
				   </div>
				   <p class="mb-1 mt-3">Software Development</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-mailchimp fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-zoom fs-4'></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-sass fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vk fs-4'></i>eCommerce Html Templates</a>
				   </div>
				   <p class="mb-1 mt-3">Online Shoping Portals</p>
				   <div class="list-group">
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-slack fs-4'></i>Best Html Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-skype fs-4'></i>Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-twitter fs-4'></i>Responsive Html5 Templates</a>
					  <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vimeo fs-4'></i>eCommerce Html Templates</a>
				   </div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
    <!-- end search modal -->



	<!-- Bootstrap JS -->
	<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/chartjs/js/Chart.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/select2/js/select2.min.js') }}"></script>
	{{-- <script src="{{ asset('admin/assets/js/index.js') }}"></script> --}}
	
	<!--notification js -->
	<script src="{{ asset('admin/assets/plugins/notifications/js/lobibox.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/notifications/js/notifications.min.js') }}"></script>

	<!--app JS-->
	<script src="{{ asset('admin/assets/js/app.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	@stack('scripts')
	
	<script>
		@if (session('success'))
			Lobibox.notify('success', {
				pauseDelayOnHover: true,
				size: 'mini',
				rounded: true,
				delayIndicator: false,
				icon: 'bx bx-check-circle',
				continueDelayOnInactiveTab: false,
				position: 'top right',
				msg: "{{ session('success') }}"
			});

		@elseif (session('error'))
			Lobibox.notify('error', {
				pauseDelayOnHover: true,
				size: 'mini',
				rounded: true,
				delayIndicator: false,
				icon: 'bx bx-x-circle',
				continueDelayOnInactiveTab: false,
				position: 'top right',
				msg: "{{ session('error') }}"
			});

		@elseif (session('warning'))
			Lobibox.notify('warning', {
				pauseDelayOnHover: true,
				size: 'mini',
				rounded: true,
				delayIndicator: false,
				icon: 'bx bx-error',
				continueDelayOnInactiveTab: false,
				position: 'top right',
				msg: "{{ session('warning') }}"
			});

		@elseif (session('info'))
			Lobibox.notify('info', {
				pauseDelayOnHover: true,
				size: 'mini',
				rounded: true,
				delayIndicator: false,
				icon: 'bx bx-info-circle',
				continueDelayOnInactiveTab: false,
				position: 'top right',
				msg: "{{ session('info') }}"
			});
		@endif


		$(function () {
			$('[data-bs-toggle="popover"]').popover();
			$('[data-bs-toggle="tooltip"]').tooltip();
		})

		
        function getStates(countryId, selectedStateId = null, stateSelectId = '#state') {
            const $stateSelect = $(stateSelectId);

            $stateSelect.empty();
            $stateSelect.html('<option disabled selected>Loading...</option>');
            $stateSelect.trigger('change');
            const isSelectedValid = selectedStateId !== null && selectedStateId !== undefined && selectedStateId !== '';

            $.ajax({
                url: "{{ route('get-states', ':id') }}".replace(':id', countryId),
                method: 'GET',
                success: function(data) {

                    $stateSelect.empty();

                    if (!isSelectedValid) {
                        $stateSelect.append('<option disabled selected>Select State</option>');
                    }

                    data.forEach(function(state) {
                        const isSelected = isSelectedValid && state.id == selectedStateId;
                        const option = new Option(state.name, state.id, isSelected, isSelected);
                        $stateSelect.append(option);
                    });

                    $stateSelect.trigger('change');
                },
                error: function(xhr, status, error) {
                    $stateSelect.empty();
                    $stateSelect.trigger('change');
                }
            });
        }


        function getCities(stateId, selectedCityId = null, citySelectId = '#city') {
            const $citySelect = $(citySelectId);

            $citySelect.empty();
            $citySelect.html('<option disabled selected>Loading...</option>');
            $citySelect.trigger('change');
            const isSelectedValid = selectedCityId !== null && selectedCityId !== undefined && selectedCityId !== '';

            $.ajax({
                url: "{{ route('get-cities', ':id') }}".replace(':id', stateId),
                method: 'GET',
                success: function(data) {
                    $citySelect.empty();

                    if (!isSelectedValid) {
                        $citySelect.append('<option disabled selected>Select City</option>');
                    }

                    data.forEach(function(city) {
                        const isSelected = isSelectedValid && state.id == selectedCityId;
                        const option = new Option(city.name, city.id, isSelected, isSelected);
                        $citySelect.append(option);
                    });
                    $citySelect.trigger('change');
                },
                error: function(xhr, status, error) {
                    $citySelect.empty();
                    $citySelect.trigger('change');
                }
            });
        }

		
		function setupImageUpload(inputId, cardId, previewId) {
			const input = document.getElementById(inputId);
			const card = document.getElementById(cardId);
			const preview = document.getElementById(previewId);

			card.addEventListener("click", () => input.click());
			preview.addEventListener("click", () => input.click());
			input.addEventListener("change", () => {
				let file = input.files[0];
				if (file) {
					preview.src = URL.createObjectURL(file);
					preview.style.display = "block";
					card.style.display = "none";
				}
			});
			preview.addEventListener("change", () => {
				let file = input.files[0];
				if (file) {
					preview.src = URL.createObjectURL(file);
					preview.style.display = "block";
					card.style.display = "none";
				}
			});
		}
		
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>


<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/9.22.0/firebase-app.js";
    import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.22.0/firebase-messaging.js";

    // 1. Get Config from Laravel
    const firebaseConfig = {
        apiKey: "{{ config('services.firebase.api_key') }}",
        authDomain: "{{ config('services.firebase.auth_domain') }}",
        projectId: "{{ config('services.firebase.project_id') }}",
        storageBucket: "{{ config('services.firebase.storage_bucket') }}",
        messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
        appId: "{{ config('services.firebase.app_id') }}"
    };

    // 2. Initialize Firebase Main App
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    // 3. Request Permission & Generate Token
    function requestPermission() {
        console.log('Requesting permission...');
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
                console.log('Notification permission granted.');

                // --- DEBUG: Check VAPID Key ---
                const vapidKey = "{{ config('services.firebase.vapid_key') }}";
                console.log("-----------------------------");
                console.log("CHECKING VAPID KEY...");
                // Key should start with 'B' and be approx 88 chars long
                console.log("Key:", vapidKey); 
                console.log("Length:", vapidKey.length);
                console.log("-----------------------------");

                if (!vapidKey || vapidKey.length < 50) {
                    console.error("ERROR: Your VAPID Key looks invalid or empty. Check .env file.");
                    return;
                }

                // --- FIX: Register Service Worker Manually with Config ---
                // We pass the config as URL params so the SW can read them
                const params = new URLSearchParams(firebaseConfig).toString();
                const swUrl = `/firebase-messaging-sw.js?${params}`;

                navigator.serviceWorker.register(swUrl)
                .then((registration) => {
                    console.log('Service Worker registered successfully.');

                    // Get Token using the specific SW registration and VAPID Key
                    return getToken(messaging, { 
                        vapidKey: vapidKey, 
                        serviceWorkerRegistration: registration 
                    });
                })
                .then((currentToken) => {
                    if (currentToken) {
                        console.log('Token generated:', currentToken);
                        // Save token to database
                        saveTokenToServer(currentToken);
                    } else {
                        console.log('No registration token available. Request permission to generate one.');
                    }
                }).catch((err) => {
                    console.error('An error occurred while retrieving token.', err);
                });

            } else {
                console.log('Unable to get permission to notify.');
            }
        });
    }

    // 4. Send Token to Backend
    function saveTokenToServer(token) {
        fetch('/fcm/token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ token: token })
        }).then(response => {
            if (response.ok) {
                console.log('Token saved to server.');
            } else {
                console.error('Failed to save token to server.');
            }
        });
    }

    // 5. Handle Foreground Messages (When user is on the site)
    onMessage(messaging, (payload) => {
        console.log('Message received. ', payload);
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: '/logo.png' // Ensure you have a logo.png in public folder
        };
        
        // You can use a custom toast library here (like Toastr or SweetAlert)
        alert(title + ": " + options.body);
    });

    // Run the logic
    requestPermission();
</script>
</body>

</html>