@extends('front.layouts.app')

@section('content')
	<!-- Page Header Start -->
	<div class="page-header parallaxie">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<!-- Page Header Box Start -->
					<div class="page-header-box">
						<h1 class="text-anime">{{ $data->title }}</h1>
						<nav class="wow fadeInUp" data-wow-delay="0.25s">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li> 
								<li class="breadcrumb-item"><a href="javascript:;">></a></li>
								<li class="breadcrumb-item active" aria-current="page">{{ $data->title }}</li>
							</ol>
						</nav>
					</div>
					<!-- Page Header Box End -->
				</div>
			</div>
		</div>
	</div>
	<!-- Page Header End -->
	<!-- Counter Section Start -->
	<div class="our-process" style="padding-top: 40px;">
		<div class="container">
			<div class="section-title">
				<h2 class="text-anime">
					<div class="line" style="display: block; text-align:center; width:100%;">
						@foreach(explode(' ', $data->title) as $word)
							<div class="word" style="display:inline-block;">
								@foreach(str_split($word) as $char)
									<div class="char"
										style="display:inline-block; opacity:1; visibility:inherit; transform:translate(0,0);">
										{{ $char }}
									</div>
								@endforeach
							</div>
							{{-- space between words --}}
							&nbsp;
						@endforeach
					</div>
				</h2>
			</div>
			<div>
				{!! $data->desc !!}
			</div>
		</div>
	</div>
@endsection
@push('scripts')

@endpush