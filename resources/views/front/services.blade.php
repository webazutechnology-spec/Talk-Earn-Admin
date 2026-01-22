@extends('front.layouts.app')

@section('content')

    <!-- Page Header Section Start -->
    <div class="page-header bg-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Page Header Box Start -->
                    <div class="page-header-box">
                        <h1 class="text-anime-style-3" data-cursor="-opaque">Our Team</h1>
                        <nav class="wow fadeInUp">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Professional's & Team</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- Page Header Box End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header Section End -->

    <!-- Page Team Start -->
    <div class="page-team">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item wow fadeInUp">
                        <!-- team Image Start -->
                        <div class="team-image">
                            <a href="team-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/team-1.jpg') }}" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- team Image End -->
                        
                        <!-- Team Item Body Start -->
                        <div class="team-item-body">
                            <!-- Team Item Content Start -->
                            <div class="team-item-content">
                                <h3><a href="team-single.html">Cameron Williamson</a></h3>
                                <p>Front-End Development Specialist</p>
                            </div>
                            <!-- Team Item Content End -->                          
                        </div>
                        <!-- Team Item Body End -->                         
                    </div>
                    <!-- Team Item End -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item wow fadeInUp" data-wow-delay="0.2s">
                        <!-- team Image Start -->
                        <div class="team-image">
                            <a href="team-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/team-2.jpg') }}" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- team Image End -->

                        <!-- Team Item Body Start -->
                        <div class="team-item-body">
                            <!-- Team Item Content Start -->
                            <div class="team-item-content">
                                <h3><a href="team-single.html">Marvin McKinney</a></h3>
                                <p>backend Development Specialist</p>
                            </div>
                            <!-- Team Item Content End -->
                        </div>
                        <!-- Team Item Body End -->
                    </div>
                    <!-- Team Item End -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item wow fadeInUp" data-wow-delay="0.4s">
                        <!-- team Image Start -->
                        <div class="team-image">
                            <a href="team-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/team-3.jpg') }}" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- team Image End -->

                        <!-- Team Item Body Start -->
                        <div class="team-item-body">
                            <!-- Team Item Content Start -->
                            <div class="team-item-content">
                                <h3><a href="team-single.html">Savannah Nguyen</a></h3>
                                <p>UI/UX Lead Designer</p>
                            </div>
                            <!-- Team Item Content End -->
                        </div>
                        <!-- Team Item Body End -->
                    </div>
                    <!-- Team Item End -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item wow fadeInUp" data-wow-delay="0.6s">
                        <!-- team Image Start -->
                        <div class="team-image">
                            <a href="team-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/team-4.jpg') }}" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- team Image End -->

                        <!-- Team Item Body Start -->
                        <div class="team-item-body">
                            <!-- Team Item Content Start -->
                            <div class="team-item-content">
                                <h3><a href="team-single.html">Leslie Alexander</a></h3>
                                <p>Database Administrator</p>
                            </div>
                            <!-- Team Item Content End -->
                        </div>
                        <!-- Team Item Body End -->
                    </div>
                    <!-- Team Item End -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item wow fadeInUp" data-wow-delay="0.8s">
                        <!-- team Image Start -->
                        <div class="team-image">
                            <a href="team-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/team-5.jpg') }}" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- team Image End -->

                        <!-- Team Item Body Start -->
                        <div class="team-item-body">
                            <!-- Team Item Content Start -->
                            <div class="team-item-content">
                                <h3><a href="team-single.html">Darlene Robertson</a></h3>
                                <p>DevOps Engineer</p>
                            </div>
                            <!-- Team Item Content End -->                         
                        </div>
                        <!-- Team Item Body End -->
                    </div>
                    <!-- Team Item End -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item wow fadeInUp" data-wow-delay="1s">
                        <!-- team Image Start -->
                        <div class="team-image">
                            <a href="team-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/team-6.jpg') }}" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- team Image End -->

                        <!-- Team Item Body Start -->
                        <div class="team-item-body">
                            <!-- Team Item Content Start -->
                            <div class="team-item-content">
                                <h3><a href="team-single.html">Marvin McKinney</a></h3>
                                <p>Content Manager</p>
                            </div>
                            <!-- Team Item Content End -->                           
                        </div>
                        <!-- Team Item Body End -->
                    </div>
                    <!-- Team Item End -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item wow fadeInUp" data-wow-delay="1.2s">
                        <!-- team Image Start -->
                        <div class="team-image">
                            <a href="team-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/team-7.jpg') }}" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- team Image End -->

                        <!-- Team Item Body Start -->
                        <div class="team-item-body">
                            <!-- Team Item Content Start -->
                            <div class="team-item-content">
                                <h3><a href="team-single.html">Kathryn Murphy</a></h3>
                                <p>Digital Marketing Specialist</p>
                            </div>
                            <!-- Team Item Content End -->
                         
                        </div>
                        <!-- Team Item Body End -->
                    </div>
                    <!-- Team Item End -->
                </div>

                <div class="col-xl-3 col-md-6">
                    <!-- Team Item Start -->
                    <div class="team-item wow fadeInUp" data-wow-delay="1.4s">
                        <!-- team Image Start -->
                        <div class="team-image">
                            <a href="team-single.html" data-cursor-text="View">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/images/team-8.jpg') }}" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- team Image End -->

                        <!-- Team Item Body Start -->
                        <div class="team-item-body">
                            <!-- Team Item Content Start -->
                            <div class="team-item-content">
                                <h3><a href="team-single.html">Arlene McCoy</a></h3>
                                <p>Security Analyst</p>
                            </div>
                            <!-- Team Item Content End -->                           
                        </div>
                        <!-- Team Item Body End -->
                    </div>
                    <!-- Team Item End -->
                </div>
            </div>
        </div>
    </div>
    <!-- Page Team End -->
@endsection
@push('scripts')

@endpush