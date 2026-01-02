@extends('front.layouts.app')

@section('content')
	<!-- Page Header Start -->
	<div class="page-header parallaxie">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime">Our Blog</h1>
						<nav class="wow fadeInUp" data-wow-delay="0.25s">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
								<li class="breadcrumb-item"><a href="javascript:;">></a></li>
								<li class="breadcrumb-item active" aria-current="page">Blog</li>
							</ol>
						</nav>
					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Page Header End -->

	<!-- Blog Archive Page Start -->
	<div class="page-blog-archive">
		<div class="container">
			<div class="row">
                @foreach ($data as $item)
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

			<div class="row">
				<div class="col-md-12">
					<!-- Post Pagination Start -->
                    <div class="post-pagination wow fadeInUp" data-wow-delay="1.50s">
                        {{ $data->links('pagination::bootstrap-4') }}
                    </div>
					{{-- <div class="post-pagination wow fadeInUp" data-wow-delay="1.50s">
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
	<!-- Blog Archive Page End -->
	
@endsection
@push('scripts')

@endpush