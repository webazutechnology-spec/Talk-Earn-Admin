@extends('front.layouts.app')

@section('content')
	<!-- Page Header Start -->
	<div class="page-header parallaxie">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime">{{ $blog->title }}</h1>
						<div class="post-single-meta wow fadeInUp" data-wow-delay="0.25s">
							<ul>
								<li>{{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }}</li>
								<li>{{ $blog->category->name ?? 'No Category' }}</li>
							</ul>
						</div>
					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Page Header End -->

	<!-- Single Post Page Start -->
	<div class="page-single-post">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Post Featured Image Start -->
					<div class="post-featured-image wow fadeInUp" data-wow-delay="0.25s">
						<figure class="image-anime">
							<img src="{{ asset('images/blog/' . $blog->image) }}" onerror="this.onerror=null;this.src='{{ asset('images/image-not-found.png') }}';" alt="{{ $blog->title }}">
						</figure>
					</div>
					<!-- Post Featured Image Start -->

					<!-- Post Content Start -->
					<div class="post-content">
						{!! $blog->content !!}
					</div>
					<!-- Post Content End -->
				</div>
			</div>
		</div>		
	</div>
	<!-- Single Post Page End -->

	<!-- Related Post Section Start -->
	<div class="related-posts">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Section Title Start -->
					<div class="section-title">
						<h3 class="wow fadeInUp">Recent Articles</h3>
						<h2 class="text-anime">You may also like this article</h2>
					</div>
					<!-- Section Title End -->
				</div>
			</div>

			<div class="row gy-4">
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
		</div>
	</div>
	<!-- Related Post Section End -->
@endsection
@push('scripts')

@endpush