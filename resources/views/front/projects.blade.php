@extends('front.layouts.app')

@section('content')
	<!-- Page Header Start -->
	<div class="page-header parallaxie">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime">Client Review</h1>
						<nav class="wow fadeInUp" data-wow-delay="0.25s">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript:;">></a></li>
								<li class="breadcrumb-item active" aria-current="page">Reviews</li>
							</ol>
						</nav>
					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Page Header End -->

	<!-- Our Projects Page Start -->
	<div class="our-projects">
		<div class="container">
			<div class="row">

				@foreach ($data as $item)
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

			<div class="row">
				<div class="col-md-12">
					<!-- Post Pagination Start -->
					<div class="post-pagination wow fadeInUp" data-wow-delay="1.50s">
                        {{ $data->links('pagination::bootstrap-4') }}
                    </div>
					{{-- <div class="post-pagination wow fadeInUp" data-wow-delay="1.5s">
						<ul class="pagination">
							<li><a href="#"><i class="fa-solid fa-arrow-left-long"></i></a></li>
							<li class="active"><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#"><i class="fa-solid fa-arrow-right-long"></i></a></li>
						</ul>
					</div> --}}
					<!-- Post Pagination End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Our Projects Page End -->
@endsection
@push('scripts')

@endpush