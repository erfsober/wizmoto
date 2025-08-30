@extends('master')
@section('content')
    <header class="boxcar-header header-style-v1 style-two inner-header cus-style-1">
        <div class="header-inner">
            <div class="inner-container">
                <!-- Main box -->
                <div class="c-box">
                    <div class="logo-inner">
                        <div class="logo">
                            <a href="index.html">
                                <img src="images/logo.svg" alt="" title="Boxcar">
                            </a>
                        </div>
                        <div class="layout-search style1">
                            <div class="search-box">
                                <svg class="icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.29301 1.2876C3.9872 1.2876 1.29431 3.98048 1.29431 7.28631C1.29431 10.5921 3.9872 13.2902 7.29301 13.2902C8.70502 13.2902 10.0036 12.7954 11.03 11.9738L13.5287 14.4712C13.6548 14.5921 13.8232 14.6588 13.9979 14.657C14.1725 14.6552 14.3395 14.5851 14.4631 14.4617C14.5867 14.3382 14.6571 14.1713 14.6591 13.9967C14.6611 13.822 14.5947 13.6535 14.474 13.5272L11.9753 11.0285C12.7976 10.0006 13.293 8.69995 13.293 7.28631C13.293 3.98048 10.5988 1.2876 7.29301 1.2876ZM7.29301 2.62095C9.87824 2.62095 11.9584 4.70108 11.9584 7.28631C11.9584 9.87153 9.87824 11.9569 7.29301 11.9569C4.70778 11.9569 2.62764 9.87153 2.62764 7.28631C2.62764 4.70108 4.70778 2.62095 7.29301 2.62095Z" fill="white"/>
                                </svg>
                                <input type="search" placeholder="Search Scooters, Motorbikes, Bikes..." class="show-search" name="name" tabindex="2" value="" aria-required="true" required="">

                            </div>
                            <div class="box-content-search" id="box-content-search">
                                <ul class="box-car-search">
                                    <li>
                                        <a href="inventory-page-single.html" class="car-search-item">
                                            <div class="box-img">
                                                <img src="images/resource/car-search.jpg" alt="img">
                                            </div>
                                            <div class="info">
                                                <p class="name">Audi, Q5 - 2023 C300e AMG Line Night Ed Premium Plus 5dr 9G-Tronic</p>
                                                <span class="price">$399</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="inventory-page-single.html" class="car-search-item">
                                            <div class="box-img">
                                                <img src="images/resource/car-search.jpg" alt="img">
                                            </div>
                                            <div class="info">
                                                <p class="name">Audi, Q5 - 2023 C300e AMG Line Night Ed Premium Plus 5dr 9G-Tronic</p>
                                                <span class="price">$399</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="inventory-page-single.html" class="car-search-item">
                                            <div class="box-img">
                                                <img src="images/resource/car-search.jpg" alt="img">
                                            </div>
                                            <div class="info">
                                                <p class="name">Audi, Q5 - 2023 C300e AMG Line Night Ed Premium Plus 5dr 9G-Tronic</p>
                                                <span class="price">$399</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="inventory-page-single.html" class="car-search-item">
                                            <div class="box-img">
                                                <img src="images/resource/car-search.jpg" alt="img">
                                            </div>
                                            <div class="info">
                                                <p class="name">Audi, Q5 - 2023 C300e AMG Line Night Ed Premium Plus 5dr 9G-Tronic</p>
                                                <span class="price">$399</span>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <a href="inventory-page-single.html" class="btn-view-search">
                                    View Details
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_3114_6864)">
                                            <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="#405FF2"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_3114_6864">
                                                <rect width="14" height="14" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!--Nav Box-->
                    <div class="nav-out-bar">
                        <nav class="nav main-menu">
                            <ul class="navigation" id="navbar">
                                <li class="current-dropdown current">
                                    <a class="box-account" href="{{route('home')}}">
                                        Home
                                    </a>
                                </li>
                                <li class="current-dropdown">
                                    <a class="box-account" href="{{route("blogs.index")}}">
                                        Blog
                                    </a>
                                </li>
                                @if(Auth::guard('provider')->check())
                                    <li class="current-dropdown">
                                        <span>
                                            {{ Auth::guard('provider')->user()->username }}
                                            <i class="fa-solid fa-angle-down"></i>
                                        </span>
                                        <ul class="dropdown">
                                            <li>
                                                <a href="{{ route('dashboard.profile') }}">Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('provider.logout') }}"
                                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Logout
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <form id="logout-form" action="{{ route('provider.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                            </ul>
                        </nav>
                        <!-- Main Menu End-->
                    </div>

                    <div class="right-box">
                        @if(!Auth::guard('provider')->check())
                            <a href="{{ route('provider.auth') }}" title="" class="box-account">
                                <div class="icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_147_6490)">
                                            <path d="M7.99998 9.01221C3.19258 9.01221 0.544983 11.2865 0.544983 15.4161C0.544983 15.7386 0.806389 16.0001 1.12892 16.0001H14.871C15.1935 16.0001 15.455 15.7386 15.455 15.4161C15.455 11.2867 12.8074 9.01221 7.99998 9.01221ZM1.73411 14.8322C1.9638 11.7445 4.06889 10.1801 7.99998 10.1801C11.9311 10.1801 14.0362 11.7445 14.2661 14.8322H1.73411Z" fill="white"/>
                                            <path d="M7.99999 0C5.79171 0 4.12653 1.69869 4.12653 3.95116C4.12653 6.26959 5.86415 8.15553 7.99999 8.15553C10.1358 8.15553 11.8735 6.26959 11.8735 3.95134C11.8735 1.69869 10.2083 0 7.99999 0ZM7.99999 6.98784C6.50803 6.98784 5.2944 5.62569 5.2944 3.95134C5.2944 2.3385 6.43231 1.16788 7.99999 1.16788C9.54259 1.16788 10.7056 2.36438 10.7056 3.95134C10.7056 5.62569 9.49196 6.98784 7.99999 6.98784Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_147_6490">
                                                <rect width="16" height="16" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                Sign in
                            </a>
                        @endif
                        <div class="btn">
                            <a href="{{route("dashboard.create-advertisement")}}" class="header-btn-two btn-anim">Add Listing</a>
                        </div>
                        <div class="mobile-navigation">
                            <a href="#nav-mobile" title="">
                                <svg width="22" height="11" viewBox="0 0 22 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="22" height="2" fill="white"/>
                                    <rect y="9" width="22" height="2" fill="white"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu  -->
            </div>
        </div>

        <!-- Header Search -->
        <div class="search-popup">
            <span class="search-back-drop"></span>
            <button class="close-search">
                <span class="fa fa-times"></span></button>

            <div class="search-inner">
                <form method="post" action="index.html">
                    <div class="form-group">
                        <input type="search" name="search-field" value="" placeholder="Search..." required="">
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Header Search -->

        <div id="nav-mobile"></div>
    </header>
    <!-- End header-section -->

    <!-- blog section five -->
    <section class="blog-section-five layout-radius">
        <div class="boxcar-container">
            <div class="boxcar-title wow fadeInUp">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{route("home")}}">Home</a>
                    </li>
                    <li><span>Blog</span></li>
                </ul>
                <h2>{{$blogPost->tilte}}</h2>
                {{--            <ul class="post-info">--}}
                {{--                <li><img src="images/resource/ali-tufan.png"></li>--}}
                {{--                <li><a href="#" title="">Ali Tufan</a></li>--}}
                {{--                <li><a href="#" title="">News</a></li>--}}
                {{--                <li>April 20, 2023</li>--}}
                {{--            </ul>--}}
            </div>
        </div>
        <div class="right-box">
            <div class="large-container">
                <div class="content-box">
                    <figure class="outer-image">
                        <img
                            src="{{ $blogPost->getFirstMediaUrl('images', 'large')}}"
                            alt="{{ $blogPost->title }}">
                    </figure>
                    <div class="right-box-two">
                        <h4 class="title">{{ $blogPost->title }}</h4>
                        <div class="text">
                            {{ $blogPost->body }}
                        </div>

                        <div class="ruls-sec">

                            @if($previous)
                                <div class="content-box">
                                    <h6 class="title">
                                        <i class="fa-solid fa-angle-left"></i> Previous Post
                                    </h6>
                                    <div class="text">
                                        <a href="{{ route('blogs.show', $previous->slug) }}">
                                            {{ $previous->title }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($next)
                                <div class="content-box v2">
                                    <h6 class="title">
                                        Next Post
                                        <i class="fa-solid fa-angle-right"></i>
                                    </h6>
                                    <div class="text">
                                        <a href="{{ route('blogs.show', $next->slug) }}">
                                            {{ $next->title }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="reviews">
                            <h4 class="title">Customer Reviews</h4>
                            @foreach($blogPost->reviews as $review)
                                <div class="content-box">
                                    <div class="auther-name">
                                        <span>{{ strtoupper(Str::substr($review->name, 0, 1)) }}.{{ strtoupper(Str::substr(explode(' ', $review->name)[1] ?? '', 0, 1)) }}</span>
                                        <h6 class="name">{{ $review->name }}</h6>
                                        <small>{{ $review->created_at->format('F d, Y') }}</small>
                                    </div>
                                    <div class="rating-list">
                                        <ul class="list">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <li>
                                                    <i class="fa fa-star {{ $i <= $review->stars ? '' : 'gray' }}"></i>
                                                </li>
                                            @endfor

                                        </ul>
                                    </div>
                                    <div class="text">{{$review->comment}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <form class="row" action="{{route("reviews.store")}}" method="POST">
                            <div class="Reply-sec">
                                <h6 class="title">Leave a Reply</h6>
                                <div class="text">Your email address will not be published. Required fields are marked *</div>
                                <div class="right-box">
                                    <div class="rating-list">
                                        <div class="list-box">
                                            <span>Rate this post</span>
                                            <ul class="list">
                                                <li>
                                                    <i class="fa fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa fa-star"></i>
                                                </li>
                                            </ul>
                                            <input type="hidden" name="stars" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @csrf
                            <input type="hidden" name="type" value="blog">
                            <input type="hidden" name="id" value="{{ $blogPost->id }}">
                            <div class="col-lg-6">
                                <div class="form_boxes">
                                    <label>Name</label>
                                    <input type="text" name="name" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form_boxes">
                                    <label>Email</label>
                                    <input type="email" name="email" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form_boxes v2">
                                    <label>Comment</label>
                                    <textarea name="comment" placeholder="" required=""></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-submit">
                                    <button type="submit" class="theme-btn">Post Comment
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" fill="none">
                                            <g clip-path="url(#clip0_711_3214)">
                                                <path d="M13.6106 0H5.05509C4.84013 0 4.66619 0.173943 4.66619 0.388901C4.66619 0.603859 4.84013 0.777802 5.05509 0.777802H12.6719L0.113453 13.3362C-0.0384687 13.4881 -0.0384687 13.7342 0.113453 13.8861C0.189396 13.962 0.288927 14 0.388422 14C0.487917 14 0.587411 13.962 0.663391 13.8861L13.2218 1.3277V8.94447C13.2218 9.15943 13.3957 9.33337 13.6107 9.33337C13.8256 9.33337 13.9996 9.15943 13.9996 8.94447V0.388901C13.9995 0.173943 13.8256 0 13.6106 0Z" fill="white"></path>
                                            </g>
                                            <defs>
                                                <clippath id="clip0_711_3214">
                                                    <rect width="14" height="14" fill="white"></rect>
                                                </clippath>
                                            </defs>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- blog section -->
        <div class="blog-section">
            <div class="boxcar-container">
                <div class="boxcar-title wow fadeInUp">
                    <h2>Latest Blog Posts</h2>
                </div>
                <div class="row">
                    <!-- blog-block -->
                    @foreach($latestBlogs as $blog)
                        <div class="blog-block col-lg-4 col-md-6 col-sm-12">
                            <div class="inner-box wow fadeInUp">
                                <div class="image-box">
                                    <figure class="image">
                                        <a href="{{ route('blogs.show', $blog->slug) }}">
                                            <img
                                                src="{{ $blog->getFirstMediaUrl('images', 'medium')}}"
                                                alt="{{ $blog->title }}">
                                        </a>
                                    </figure>
                                </div>
                                <div class="content-box">
                                    <ul class="post-info">
                                        <li>{{ $blog->author_name ?? 'Admin' }}</li>
                                        <li>{{ $blog->created_at->format('F d, Y') }}</li>
                                    </ul>
                                    <h6 class="title">
                                        <a href="{{ route('blogs.show', $blog->slug) }}" title="{{ $blog->title }}">
                                            {{ Str::limit($blog->title, 70) }}
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    <!-- blog-block -->
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End blog-section -->
    </section>

    @include('wizmoto.partials.footer')

@endsection
@push('styles')
    <style>
        .rating-list .list li i.gray {
            color: #ccc; /* gray for empty stars */
        }

        .Reply-sec .list li i {
            color: #ccc; /* default gray */
            cursor: pointer;
        }

        .Reply-sec .list li.hovered i,
        .list li.selected i {
            color: #ffb400; /* gold for hover/selected */
        }

    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function () {
            const $stars = $('.rating-list .list-box .list li');

            $stars.on('mouseenter', function () {
                const index = $(this).index();
                $(this).siblings().addBack().each(function (i) {
                    $(this).toggleClass('hovered', i <= index);
                });
            }).on('mouseleave', function () {
                $(this).siblings().addBack().removeClass('hovered');
            });

            $stars.on('click', function () {
                const index = $(this).index();
                const $list = $(this).closest('.list');
                $list.children().each(function (i) {
                    $(this).toggleClass('selected', i <= index);
                });
                // Set hidden input value
                $(this).closest('.list-box').find('input[name="stars"]').val(index + 1);
            });
        });

    </script>
@endpush
