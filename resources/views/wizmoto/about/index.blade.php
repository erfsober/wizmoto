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
                    @include('wizmoto.partials.live-search', ['class' => 'style1'])
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
        <button class="close-search"><span class="fa fa-times"></span></button>

        <div class="search-inner">
            <form method="post" action="index.html">
                <div class="form-group">
                    <input type="search" name="search-field" value="" placeholder="Search..." required="">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Header Search -->

    <div id="nav-mobile"></div>
</header>
<!-- End header-section -->

<!-- about-inner-one -->
<section class="about-inner-one layout-radius">
    <div class="upper-box">
        <div class="boxcar-container">
            <div class="row wow fadeInUp">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="boxcar-title">
                        <ul class="breadcrumb">
                            <li><a href="{{ route('home') }}">Home</a></li>
                <li><span>About Us</span></li>
                        </ul>
                        <h2>About Us</h2>
                        <div class="text">{{ $aboutSections->where('section', 'mission')->first()?->title ?? 'We Value Our Clients And Want Them To Have A Nice Experience' }}</div>

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="content-box">
                        @foreach($aboutSections as $section)
                            <div class="text">{{ $section->content }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
 

    <!-- why choose us section -->
    <div class="why-choose-us-section">
        <div class="boxcar-container">
            <div class="boxcar-title wow fadeInUp">
                <h2 class="title">Why Choose Us?</h2>
            </div>
            <div class="row">
                <!-- choose-us-block -->
                <div class="choose-us-block col-lg-3 col-md-6 col-sm-12">
                    <div class="inner-box wow fadeInUp">
                        <div class="icon-box"><svg xmlns="http://www.w3.org/2000/svg" width="51" height="60" viewbox="0 0 51 60" fill="none">
                            <g clip-path="url(#clip0_24_628)">
                                <path d="M22.9688 52.9676C22.9688 52.732 22.827 52.5195 22.6096 52.4289C20.0682 51.3695 18.2812 48.8627 18.2812 45.9375V23.4375C18.2812 20.5123 20.0682 18.0054 22.6096 16.9461C22.827 16.8555 22.9688 16.6429 22.9688 16.4074V16.4062H18.2812C14.398 16.4062 11.25 19.5543 11.25 23.4375V45.9375C11.25 49.8207 14.398 52.9688 18.2812 52.9688H22.9688V52.9676Z" fill="#EEF1FB"></path>
                                <path d="M23.3708 41.3167L36.6292 28.0583" stroke="#FF5CF4" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M30 21.0938L44.0625 2.34375" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M15.9375 2.34375L25.3895 12.9483" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M48.75 30V23.4375C48.75 19.5543 45.602 16.4062 41.7188 16.4062H38.0747C36.4508 13.6159 33.4612 11.7188 30 11.7188C26.5388 11.7188 23.5493 13.6159 21.9253 16.4062H18.2812C14.398 16.4062 11.25 19.5543 11.25 23.4375V45.9375C11.25 49.8207 14.398 52.9688 18.2812 52.9688H21.9253C23.5492 55.7591 26.5388 57.6562 30 57.6562C33.4612 57.6562 36.4507 55.7591 38.0747 52.9688H41.7188C45.602 52.9688 48.75 49.8207 48.75 45.9375V39.375" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                            <defs>
                                <clippath id="clip0_24_628">
                                <rect width="51" height="60" fill="white"></rect>
                                </clippath>
                            </defs>
                            </svg>
                        </div>
                        <div class="content-box">
                            <h6 class="title">Special Financing Offers</h6>
                            <div class="text">Our stress-free finance department that can find financial solutions to save you money.</div>
                        </div>
                    </div>
                </div>
                <!-- choose-us-block -->
                <div class="choose-us-block col-lg-3 col-md-6 col-sm-12">
                    <div class="inner-box wow fadeInUp" data-wow-delay="100ms">
                        <div class="icon-box"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewbox="0 0 60 60" fill="none">
                            <path d="M30 2.34375V7.03125" stroke="#FF5CF4" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M48.75 2.34375L44.0625 7.03125" stroke="#FF5CF4" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M15.4738 36.6607C14.3072 35.4056 13.5938 33.7236 13.5938 31.875C13.5938 30.7464 13.8596 29.68 14.3323 28.7347L19.0198 19.3597C20.1732 17.0529 22.5579 15.4688 25.3125 15.4688H18.2812C15.5266 15.4688 13.142 17.0529 11.9885 19.3597L7.30102 28.7347C6.8284 29.68 6.5625 30.7464 6.5625 31.875C6.5625 33.7236 7.27594 35.4056 8.44254 36.6607L26.5658 56.1592C27.4218 57.0802 28.6436 57.6562 30 57.6562C31.3564 57.6562 32.5782 57.0802 33.4342 56.1593L33.5156 56.0716L15.4738 36.6607Z" fill="#EEF1FB"></path>
                            <path d="M48.0115 19.3597L52.699 28.7347C53.1716 29.6798 53.4375 30.7464 53.4375 31.875C53.4375 33.7236 52.7241 35.4057 51.5575 36.6608L33.4342 56.1593C32.5782 57.0802 31.3564 57.6562 30 57.6562C28.6436 57.6562 27.4218 57.0802 26.5658 56.1593L8.44254 36.6608C7.27594 35.4057 6.5625 33.7236 6.5625 31.875C6.5625 30.7464 6.8284 29.6798 7.30102 28.7347L11.9885 19.3597C13.142 17.0528 15.5266 15.4688 18.2812 15.4688H41.7188C44.4734 15.4688 46.858 17.0528 48.0115 19.3597Z" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M11.25 2.34375L15.9375 7.03125" stroke="#FF5CF4" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M17.3849 29.5312H42.6151" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M25.3125 24.8438L30 29.5312L34.6875 24.8438" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M30 43.5938V29.7306" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        <div class="content-box">
                            <h6 class="title">Trusted Motorcycle Dealership</h6>
                            <div class="text">Our stress-free finance department that can find financial solutions to save you money.</div>
                        </div>
                    </div>
                </div>
                <!-- choose-us-block -->
                <div class="choose-us-block col-lg-3 col-md-6 col-sm-12">
                    <div class="inner-box wow fadeInUp" data-wow-delay="200ms">
                        <div class="icon-box"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewbox="0 0 60 60" fill="none">
                            <g clip-path="url(#clip0_24_681)">
                            <path d="M8.75576 36.7478L35.3054 10.198C37.136 8.36741 40.104 8.36741 41.9346 10.198L36.8955 5.15894C35.0649 3.32837 32.097 3.32837 30.2664 5.15894L3.71671 31.7087C1.88613 33.5393 1.88613 36.5073 3.71671 38.3378L8.75576 43.3768C6.92518 41.5462 6.92518 38.5783 8.75576 36.7478Z" fill="#EEF1FB"></path>
                            <path d="M50.1537 18.4171C51.9843 20.2477 51.9843 23.2157 50.1537 25.0463L23.6039 51.5959C21.7734 53.4265 18.8054 53.4265 16.9748 51.5959L3.71671 38.3378C1.88613 36.5072 1.88613 33.5392 3.71671 31.7086L30.2664 5.15894C32.097 3.32836 35.0649 3.32836 36.8955 5.15894L43.5247 11.7881L52.9689 2.34387" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M18.9633 31.0458C18.7631 32.4554 19.2051 33.9388 20.2894 35.0231C22.12 36.8537 25.088 36.8537 26.9186 35.0231C28.7492 33.1926 28.7492 30.2246 26.9186 28.394C25.088 26.5634 25.088 23.5954 26.9186 21.7648C28.7492 19.9342 31.7172 19.9342 33.5478 21.7648C34.6321 22.8491 35.0741 24.3325 34.8739 25.7421" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M16.9749 38.3378L20.2894 35.0232" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M33.5476 21.765L36.8621 18.4504" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M43.5938 57.6562L57.6563 43.5937" stroke="#FF5CF4" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </g>
                            <defs>
                            <clippath id="clip0_24_681">
                            <rect width="60" height="60" fill="white"></rect>
                            </clippath>
                            </defs>
                            </svg>
                        </div>
                        <div class="content-box">
                            <h6 class="title">Transparent Pricing</h6>
                            <div class="text">Our stress-free finance department that can find financial solutions to save you money.</div>
                        </div>
                    </div>
                </div>
                <!-- choose-us-block -->
                <div class="choose-us-block col-lg-3 col-md-6 col-sm-12">
                    <div class="inner-box wow fadeInUp" data-wow-delay="300ms">
                        <div class="icon-box"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewbox="0 0 60 60" fill="none">
                            <path d="M23.5465 4.45312C19.8452 4.45312 16.4904 6.63082 14.9836 10.0114L8.88656 23.6906C5.23148 23.9418 2.34375 26.9843 2.34375 30.7031V36.0938C2.34375 39.3298 4.96711 41.9531 8.20312 41.9531H9.80918C9.81785 41.5022 9.82934 41.0514 9.84375 40.6005C9.4623 39.823 9.24727 38.949 9.24727 38.0245L9.14062 33.8672C9.14062 30.7927 9.76617 29.6094 12.0483 29.1497C13.1331 28.9311 14.0413 28.192 14.4858 27.1786L22.0148 10.0114C23.5215 6.63082 26.8764 4.45312 30.5777 4.45312H23.5465Z" fill="#EEF1FB"></path>
                            <path d="M8.20312 41.9531C4.96711 41.9531 2.34375 39.3298 2.34375 36.0938V30.7031C2.34375 26.9843 5.23148 23.9418 8.88656 23.6906L14.9836 10.0114C16.4903 6.63082 19.8451 4.45312 23.5465 4.45312H34.2217C37.7441 4.45312 40.9692 6.4275 42.5711 9.56461L45.5859 15.4688M57.6562 30.7031C57.6562 26.8199 54.5082 23.6719 50.625 23.6719H18.6328M28.2422 15.4688V4.57031M32.4609 41.9531H27.1873M20.742 37.2656C18.1532 37.2656 16.0545 39.3643 16.0545 41.9531C16.0545 44.5419 18.1532 46.6406 20.742 46.6406C23.3307 46.6406 25.4295 44.5419 25.4295 41.9531C25.4295 39.3643 23.3309 37.2656 20.742 37.2656Z" stroke="#405FF2" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M57.6562 41.6016C57.6562 46.0997 54.0098 49.8047 49.5117 49.8047C45.0136 49.8047 41.3672 46.1583 41.3672 41.6602C41.3672 37.162 45.0722 33.5156 49.5703 33.5156M43.5352 48.1055L36.0938 55.5469" stroke="#FF5CF3" stroke-width="3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        <div class="content-box">
                            <h6 class="title">Expert Motorcycle Service</h6>
                            <div class="text">Our stress-free finance department that can find financial solutions to save you money.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

    <!-- brand section -->
    <div class="boxcar-brand-section">
        <div class="boxcar-container">
            <div class="boxcar-title">
                <h2 class="wow fadeInUp">Explore Our Premium Brands</h2>
                <a href="#" class="btn-title">Show All Brands<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" fill="none"><g clip-path="url(#clip0_601_3199)"><path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="#050B20"></path></g><defs><clippath id="clip0_601_3199"><rect width="14" height="14" fill="white"></rect></clippath></defs></svg></a>
            </div>
            <div class="row">
                @foreach($popularBrands->take(6) as $index => $brand)
                    <!-- cars-block -->
                    <div class="cars-block col-lg-2 col-md-6 col-sm-6">
                        <div class="inner-box wow fadeInUp" data-wow-delay="{{ $index * 100 }}ms">
                            <div class="image-box">
                                <figure class="image">
                                    <a href="{{ route('inventory.list', ['brand' => $brand->id]) }}">
                                        @if($brand->hasMedia('logo'))
                                        <img src="{{ $brand->getFirstMediaUrl('logo', 'thumb') }}" alt="{{ $brand->name }}">
                                    @else
                                        <img src="{{ asset('wizmoto/images/resource/brand-' . (($index % 6) + 1) . '.png') }}" alt="{{ $brand->name }}">
                                    @endif
                                    </a>
                                </figure>
                            </div>
                            <div class="content-box">
                                <h6 class="title">
                                    <a href="{{ route('inventory.list', ['brand' => $brand->id]) }}">{{ $brand->name }}</a>
                                </h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- End brand section -->

    <!-- boxcar-testimonial-section-four -->
    <div class="boxcar-testimonial-section-four v1 pt-0">
        <div class="large-container">
            <div class="right-box">
                <div class="boxcar-title">
                    <h2>What our customers say</h2>
                    <div class="text">Rated 4.7  / 5 based on 28,370 reviews Showing our 4 & 5 star reviews</div>
                </div>
                <div class="row stories-slider">
                    <!-- testimonial-block-four -->
                    <div class="testimonial-block-four col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <figure class="icon"><a href="#"><img src="images/resource/comas.png" alt=""></a></figure>
                            <h6 class="title">Great Work</h6>
                            <div class="text"> “Amazing design, easy to customize and a design quality 
                            superlative account on its cloud platform for 
                            the optimized performance. And we didn’t on our original designs.”</div>
                            <div class="auther-info">
                                <figure class="image"><a href="#"><img src="images/resource/test-auther-1.jpg" alt=""></a></figure>
                                <h6 class="name">Leslie Alexander</h6>
                                <span>Nintendo</span>
                            </div>
                        </div>
                    </div>
                    <!-- testimonial-block-four -->
                    <div class="testimonial-block-four col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <figure class="icon"><a href="#"><img src="images/resource/comas.png" alt=""></a></figure>
                            <h6 class="title">Awesome Design</h6>
                            <div class="text"> “Amazing design, easy to customize and a design quality 
                            superlative account on its cloud platform for 
                            the optimized performance. And we didn’t on our original designs.”</div>
                            <div class="auther-info">
                                <figure class="image"><a href="#"><img src="images/resource/test-auther-2.jpg" alt=""></a></figure>
                                <h6 class="name">Floyd Miles</h6>
                                <span>Bank of America</span>
                            </div>
                        </div>
                    </div>
                    <!-- testimonial-block-four -->
                    <div class="testimonial-block-four col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <figure class="icon"><a href="#"><img src="images/resource/comas.png" alt=""></a></figure>
                            <h6 class="title">Perfect Quality</h6>
                            <div class="text"> “Amazing design, easy to customize and a design quality 
                            superlative account on its cloud platform for 
                            the optimized performance. And we didn’t on our original designs.”</div>
                            <div class="auther-info">
                                <figure class="image"><a href="#"><img src="images/resource/test-auther-3.jpg" alt=""></a></figure>
                                <h6 class="name">Dianne Russell</h6>
                                <span>Facebook</span>
                            </div>
                        </div>
                    </div>
                    <!-- testimonial-block-four -->
                    <div class="testimonial-block-four col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <figure class="icon"><a href="#"><img src="images/resource/comas.png" alt=""></a></figure>
                            <h6 class="title">Great Work</h6>
                            <div class="text"> “Amazing design, easy to customize and a design quality 
                            superlative account on its cloud platform for 
                            the optimized performance. And we didn’t on our original designs.”</div>
                            <div class="auther-info">
                                <figure class="image"><a href="#"><img src="images/resource/test-auther-1.jpg" alt=""></a></figure>
                                <h6 class="name">Leslie Alexander</h6>
                                <span>Nintendo</span>
                            </div>
                        </div>
                    </div>
                    <!-- testimonial-block-four -->
                    <div class="testimonial-block-four col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <figure class="icon"><a href="#"><img src="images/resource/comas.png" alt=""></a></figure>
                            <h6 class="title">Awesome Design</h6>
                            <div class="text"> “Amazing design, easy to customize and a design quality 
                            superlative account on its cloud platform for 
                            the optimized performance. And we didn’t on our original designs.”</div>
                            <div class="auther-info">
                                <figure class="image"><a href="#"><img src="images/resource/test-auther-2.jpg" alt=""></a></figure>
                                <h6 class="name">Floyd Miles</h6>
                                <span>Bank of America</span>
                            </div>
                        </div>
                    </div>
                    <!-- testimonial-block-four -->
                    <div class="testimonial-block-four col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box">
                            <figure class="icon"><a href="#"><img src="images/resource/comas.png" alt=""></a></figure>
                            <h6 class="title">Perfect Quality</h6>
                            <div class="text"> “Amazing design, easy to customize and a design quality 
                            superlative account on its cloud platform for 
                            the optimized performance. And we didn’t on our original designs.”</div>
                            <div class="auther-info">
                                <figure class="image"><a href="#"><img src="images/resource/test-auther-3.jpg" alt=""></a></figure>
                                <h6 class="name">Dianne Russell</h6>
                                <span>Facebook</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End boxcar-testimonial-section-four -->

<!-- faq-section -->
<div class="faqs-section pt-0">
    <div class="inner-container">
        <!-- FAQ Column -->
        <div class="faq-column wow fadeInUp" data-wow-delay="400ms">
            <div class="inner-column">
                <div class="boxcar-title text-center">
                    <h2 class="title">See Frequently Asked Questions</h2>
                </div>
                <ul class="widget-accordion wow fadeInUp">
                    @if(isset($recentFaqs))
                        @foreach($recentFaqs->take(5) as $index => $faq)
                            <!--Block-->
                            <li class="accordion block {{ $index == 0 ? 'active-block' : '' }}">
                                <div class="acc-btn {{ $index == 0 ? 'active' : '' }}">
                                    {{ $faq->question }}
                                    <div class="icon fa fa-plus"></div>
                                </div>
                                <div class="acc-content {{ $index == 0 ? 'current' : '' }}">
                                    <div class="content">
                                        <div class="text">{{ $faq->answer }}</div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <!-- Fallback static content if no FAQs -->
                        <li class="accordion block active-block">
                            <div class="acc-btn active">How can I contact Wizmoto support?<div class="icon fa fa-plus"></div></div>
                            <div class="acc-content current">
                                <div class="content">
                                    <div class="text">You can contact our support team through the contact form, email us directly, or visit our FAQ page for instant answers.</div>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End faqs-section -->
</section>


@include('wizmoto.partials.footer')

@endsection