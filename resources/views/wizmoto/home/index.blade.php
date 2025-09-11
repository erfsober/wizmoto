@php use App\Models\AdvertisementType; @endphp
@extends('master')

@section('content')
    <!-- Main Header-->
    <header class="boxcar-header header-style-v1 header-default">
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
                        <div class="layout-search">
                            <div class="search-box">
                                <svg class="icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.29301 1.2876C3.9872 1.2876 1.29431 3.98048 1.29431 7.28631C1.29431 10.5921 3.9872 13.2902 7.29301 13.2902C8.70502 13.2902 10.0036 12.7954 11.03 11.9738L13.5287 14.4712C13.6548 14.5921 13.8232 14.6588 13.9979 14.657C14.1725 14.6552 14.3395 14.5851 14.4631 14.4617C14.5867 14.3382 14.6571 14.1713 14.6591 13.9967C14.6611 13.822 14.5947 13.6535 14.474 13.5272L11.9753 11.0285C12.7976 10.0006 13.293 8.69995 13.293 7.28631C13.293 3.98048 10.5988 1.2876 7.29301 1.2876ZM7.29301 2.62095C9.87824 2.62095 11.9584 4.70108 11.9584 7.28631C11.9584 9.87153 9.87824 11.9569 7.29301 11.9569C4.70778 11.9569 2.62764 9.87153 2.62764 7.28631C2.62764 4.70108 4.70778 2.62095 7.29301 2.62095Z" fill="white"/>
                                </svg>
                                <input type="search" placeholder="Search Scooter, Motorbike, Bicycle" class="show-search" name="name" tabindex="2" value="" aria-required="true" required="">
                            </div>
                            <div class="box-content-search" id="box-content-search">
                                <ul class="box-car-search">
                                    <li>
                                        <a href="inventory-page-single.html" class="car-search-item">
                                            <div class="box-img">
                                                <img src="images/resource/car-search.jpg" alt="img">
                                            </div>
                                            <div class="info">
                                                <p class="name">Scooter - Vespa Primavera 125cc 2023</p>
                                                <span class="price">$25/day</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="inventory-page-single.html" class="car-search-item">
                                            <div class="box-img">
                                                <img src="images/resource/car-search.jpg" alt="img">
                                            </div>
                                            <div class="info">
                                                <p class="name">Electric Monopattino - Xiaomi Pro 2</p>
                                                <span class="price">$10/day</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="inventory-page-single.html" class="car-search-item">
                                            <div class="box-img">
                                                <img src="images/resource/car-search.jpg" alt="img">
                                            </div>
                                            <div class="info">
                                                <p class="name">Mountain Bicycle - Trek Marlin 7</p>
                                                <span class="price">$15/day</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="inventory-page-single.html" class="car-search-item">
                                            <div class="box-img">
                                                <img src="images/resource/car-search.jpg" alt="img">
                                            </div>
                                            <div class="info">
                                                <p class="name">Motorbike - Yamaha MT-07</p>
                                                <span class="price">$35/day</span>
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
                                    <a class="box-account" href="{{route('blogs.index')}}">
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
                                <span class="icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_147_6490)">
                                            <path d="M7.99998 9.01221C3.19258 9.01221 0.544983 11.2865 0.544983 15.4161C0.544983 15.7386 0.806389 16.0001 1.12892 16.0001H14.871C15.1935 16.0001 15.455 15.7386 15.455 15.4161C15.455 11.2867 12.8074 9.01221 7.99998 9.01221ZM1.73411 14.8322C1.9638 11.7445 4.06889 10.1801 7.99998 10.1801C11.9311 10.1801 14.0362 11.7445 14.2661 14.8322H1.73411Z" fill="white"></path>
                                            <path d="M7.99999 0C5.79171 0 4.12653 1.69869 4.12653 3.95116C4.12653 6.26959 5.86415 8.15553 7.99999 8.15553C10.1358 8.15553 11.8735 6.26959 11.8735 3.95134C11.8735 1.69869 10.2083 0 7.99999 0ZM7.99999 6.98784C6.50803 6.98784 5.2944 5.62569 5.2944 3.95134C5.2944 2.3385 6.43231 1.16788 7.99999 1.16788C9.54259 1.16788 10.7056 2.36438 10.7056 3.95134C10.7056 5.62569 9.49196 6.98784 7.99999 6.98784Z" fill="white"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_147_6490">
                                                <rect width="16" height="16" fill="white"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                Sign in
                            </a>
                        @endif
                        <div class="btn">
                            <a href="{{route("dashboard.create-advertisement")}}" class="header-btn-two">Add Listing</a>
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
                        <input type="search" name="search-field" value="" placeholder="Search Scooters, Motorbikes, Bikes..." required="">
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Header Search -->

        <div id="nav-mobile">
            <ul>
                <li>
                    @if(!Auth::guard('provider')->check())
                        <a href="{{ route('provider.auth') }}" title="" class="box-account">
                            <span class="icon">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_147_6490)">
                                        <path d="M7.99998 9.01221C3.19258 9.01221 0.544983 11.2865 0.544983 15.4161C0.544983 15.7386 0.806389 16.0001 1.12892 16.0001H14.871C15.1935 16.0001 15.455 15.7386 15.455 15.4161C15.455 11.2867 12.8074 9.01221 7.99998 9.01221ZM1.73411 14.8322C1.9638 11.7445 4.06889 10.1801 7.99998 10.1801C11.9311 10.1801 14.0362 11.7445 14.2661 14.8322H1.73411Z" fill="white"></path>
                                        <path d="M7.99999 0C5.79171 0 4.12653 1.69869 4.12653 3.95116C4.12653 6.26959 5.86415 8.15553 7.99999 8.15553C10.1358 8.15553 11.8735 6.26959 11.8735 3.95134C11.8735 1.69869 10.2083 0 7.99999 0ZM7.99999 6.98784C6.50803 6.98784 5.2944 5.62569 5.2944 3.95134C5.2944 2.3385 6.43231 1.16788 7.99999 1.16788C9.54259 1.16788 10.7056 2.36438 10.7056 3.95134C10.7056 5.62569 9.49196 6.98784 7.99999 6.98784Z" fill="white"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_147_6490">
                                            <rect width="16" height="16" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                            Sign in
                        </a>
                @else
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
                    </li>
            </ul>
        </div>
    </header>

    <!-- End header-section -->

    <!-- BANNER SECTION -->
    <section class="boxcar-banner-section-v1">
        <div class="container">
            <div class="banner-content">
                <h2 class="wow fadeInUp" data-wow-delay="100ms">Find Your Perfect Ride</h2>
                <div class="form-tabs">
                    <ul class="form-tabs-list wow fadeInUp" data-wow-delay="200ms">
                    </ul>
                    <div class="form-tab-content">
                        <div class="form-tab-content wow fadeInUp" data-wow-delay="300ms">
                            <div class="form-tab-pane current" id="tab-1">
                                <form action="{{route("inventory.list")}}" method="GET">
                                    @csrf
                                    <div class="form_boxes line-r">
                                        <div class="drop-menu">
                                            <div class="select">
                                                <span>Any Brands</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="brand_id">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach($brands as $brand)
                                                    <li>{{ $brand->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form_boxes line-r">
                                        <div class="drop-menu">
                                            <div class="select">
                                                <span>Any Models</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="vehicle_model_id">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach($vehicleModels as $model)
                                                    <li>{{ $model->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form_boxes line-r">
                                        <div class="drop-menu">
                                            <div class="select">
                                                <span>Any Fuel Type</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="fuel_type_id">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach($fuelTypes as $fuelType)
                                                    <li>{{ $fuelType->name }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form_boxes">
                                        <a href="#" title="" class="filter-popup">
                                            <img src="{{asset("wizmoto/images/icons/filter.svg")}}" alt=""/> More Filters
                                        </a>
                                    </div>
                                    <div class="form-submit">
                                        <button type="submit" class="theme-btn">
                                            <i class="flaticon-search"></i>Search 9451 Rides
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <span class="wow fadeInUp" data-wow-delay="400ms">Or Browse Featured Types</span>
                        <ul class="model-links">
                            @foreach(AdvertisementType::all() as $at)
                                <li>
                                    <a href="{{ route('inventory.list', ['advertisement_type' => $at->id]) }}" title="">
                                        {{ $at->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BANNER SECTION END -->


    <!-- cars-section-three -->
    <section class="cars-section-three">
        <div class="boxcar-container">
            <div class="boxcar-title wow fadeInUp">
                <h2>Explore All Vehicles</h2>
                <a href="{{route("inventory.list")}}" class="btn-title">View All
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" fill="none">
                        <g clip-path="url(#clip0_601_243)">
                            <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="#050B20"></path>
                        </g>
                        <defs>
                            <clippath id="clip0_601_243">
                                <rect width="14" height="14" fill="white"></rect>
                            </clippath>
                        </defs>
                    </svg>
                </a>
            </div>
            <nav class="wow fadeInUp" data-wow-delay="100ms">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">New Advertisement</button>
                </div>
            </nav>
        </div>

        <div class="tab-content wow fadeInUp" data-wow-delay="200ms" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row car-slider-three slider-layout-1" data-preview="4.8">
                    @foreach($newAdvertisements as $newAdvertisement)
                        <div class="box-car car-block-three col-lg-3 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <div class="image-box">
                                    <div class="slider-thumb">
                                        @foreach ($newAdvertisement->getMedia('covers')->take(3) as $image)
                                            <a href="{{ $image->getUrl('preview') }}" data-fancybox="gallery-{{ $newAdvertisement->id }}">
                                                <img
                                                    src="{{ $image->getUrl('card') }}"
                                                    loading="lazy"
                                                    alt="{{ $newAdvertisement->title ?? 'Advertisement Image' }}">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="content-box">
                                    <h6 class="title">
                                        <a href="{{ route('advertisements.show', $newAdvertisement->id) }}">{{$newAdvertisement->brand?->name}}{{' '}}{{$newAdvertisement->vehicleModel?->name}}</a>
                                    </h6>
                                    <div class="text">{{$newAdvertisement->version_model}}</div>
                                    <ul>
                                        <li>
                                            <i class="flaticon-gasoline-pump"></i>{{ $newAdvertisement->fuelType?->name ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <i class="flaticon-speedometer"></i>{{ $newAdvertisement->mileage ? number_format($newAdvertisement->mileage) . ' miles' : 'N/A' }}
                                        </li>
                                        <li>
                                            <i class="flaticon-gearbox"></i> {{ $newAdvertisement->motor_change ?? 'N/A' }}
                                        </li>
                                    </ul>
                                    <div class="btn-box">
                                        <span>${{$newAdvertisement->final_price}}</span>
                                        <a href="{{ route('advertisements.show', $newAdvertisement->id) }}" class="details">View Details
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" fill="none">
                                                <g clip-path="url(#clip0_601_4346)">
                                                    <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="#405FF2"></path>
                                                </g>
                                                <defs>
                                                    <clippath id="clip0_601_4346">
                                                        <rect width="14" height="14" fill="white"></rect>
                                                    </clippath>
                                                </defs>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- End shop section two -->



 
    <!-- End Fun Fact Section-->
    <!-- why choose us section -->
    <section class="why-choose-us-section">
        <div class="boxcar-container">
            <div class="boxcar-title wow fadeInUp">
                <h2 class="title">Why Choose Us?</h2>
            </div>
            <div class="row">
                <!-- choose-us-block -->
                <div class="choose-us-block col-lg-3 col-md-6 col-sm-12">
                    <div class="inner-box wow fadeInUp">
                        <div class="icon-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="51" height="60" viewbox="0 0 51 60" fill="none">
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
                        <div class="icon-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewbox="0 0 60 60" fill="none">
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
                        <div class="icon-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewbox="0 0 60 60" fill="none">
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
                        <div class="icon-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewbox="0 0 60 60" fill="none">
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
    </section>
    <!-- End why choose us section -->




    <!-- boxcar-testimonial-section -->
    <section class="boxcar-testimonial-section home1">
        <div class="boxcar-container">
            <div class="boxcar-title wow fadeInUp">
                <h2>What our customers say</h2>
                <div class="text">Rated 4.7 / 5 based on 28,370 reviews Showing our 4 & 5 star reviews</div>
            </div>
            <div class="testimonial-slider-two">
                <div class="testimonial-slide-two">
                    <div class="row">
                        <div class="image-column col-lg-4 col-md-12 col-sm-12">
                            <div class="inner-column wow fadeInUp">
                                <div class="image-box">
                                    <figure class="image">
                                        <img src="images/resource/test-1.jpg" alt="">
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="content-column col-lg-8 col-md-12 col-sm-12">
                            <div class="inner-column wow fadeInUp" data-wow-delay="100ms">
                                <ul class="rating">
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
                                    <span>4.8</span>
                                </ul>
                                <h6 class="title">Ali TUFAN</h6>
                                <span>Designer</span>
                                <div class="text">I'd suggest Macklin Motors Nissan Glasgow South to
                                                  a friend because I had great service from my salesman Patrick
                                                  and all of the team.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slide-two">
                    <div class="row">
                        <div class="image-column col-lg-4 col-md-12 col-sm-12">
                            <div class="inner-column wow fadeInUp">
                                <div class="image-box">
                                    <figure class="image">
                                        <img src="images/resource/test-1.jpg" alt="">
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="content-column col-lg-8 col-md-12 col-sm-12">
                            <div class="inner-column wow fadeInUp" data-wow-delay="100ms">
                                <ul class="rating">
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
                                    <span>4.8</span>
                                </ul>
                                <h6 class="title">Ali TUFAN</h6>
                                <span>Designer</span>
                                <div class="text">I'd suggest Macklin Motors Nissan Glasgow South to
                                                  a friend because I had great service from my salesman Patrick
                                                  and all of the team.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End boxcar-testimonial-section -->

    <!-- blog section -->
    <section class="blog-section">
        <div class="boxcar-container">
            <div class="boxcar-title wow fadeInUp">
                <h2>Latest Blog Posts</h2>
            </div>
            <div class="row">
                @forelse($latestPosts as $index => $post)
                    <!-- blog-block -->
                    <div class="blog-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box wow fadeInUp" data-wow-delay="{{ $index * 100 }}ms">
                            <div class="image-box">
                                <figure class="image">
                                    <a href="{{ route('blogs.show', $post->slug) }}">
                                        @if($post->getFirstMediaUrl('images', 'medium'))
                                        <img
                                        src="{{ $post->getFirstMediaUrl('images', 'medium')}}"
                                        alt="{{ $post->title }}">
                                        @else
                                            <img src="{{ asset('wizmoto/images/resource/blog-1.jpg') }}" alt="{{ $post->title }}">
                                        @endif
                                    </a>
                                </figure>
                                <span class="date">{{ $post->category->name ?? 'news' }}</span>
                            </div>
                            <div class="content-box">
                                <ul class="post-info">
                                    <ul class="post-info">
                                        <li>{{ $post->author_name ?? 'Admin' }}</li>
                                        <li>{{ $post->created_at->format('F d, Y') }}</li>
                                    </ul>
                                </ul>
                                <h6 class="title">
                                    <a href="{{ route('blogs.show', $post->slug) }}" title="{{ $post->title }}">
                                        {{ Str::limit($post->title, 60) }}
                                    </a>
                                </h6>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Fallback when no posts exist -->
                    <div class="col-12 text-center">
                        <p class="text-muted">No blog posts available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- End blog-section -->

    <!-- blog-section-two -->
    <section class="blog-section-two pt-0 section-radius-bottom bg-white">
        <div class="boxcar-container">
            <div class="row">
                <!-- blog-blockt-two -->
                <div class="blog-blockt-two col-lg-6 col-md-6 col-sm-12">
                    <div class="inner-box wow fadeInUp">
                        <h3 class="title">Are You Looking
                            <br>For a Motorcycle ?</h3>
                        <div class="text">We are committed to providing our customers with exceptional service.</div>
                        <a href="pricing.html" class="read-more">Get Started
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" fill="none">
                                <g clip-path="url(#clip0_601_692)">
                                    <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="white"></path>
                                </g>
                                <defs>
                                    <clippath id="clip0_601_692">
                                        <rect width="14" height="14" fill="white"></rect>
                                    </clippath>
                                </defs>
                            </svg>
                        </a>
                        <div class="hover-img">
                            <svg xmlns="http://www.w3.org/2000/svg" width="110" height="110" viewbox="0 0 110 110" fill="none">
                                <path d="M43.1686 14.8242C36.3829 14.8242 30.2324 18.8167 27.4699 25.0145L16.292 50.093C9.59105 50.5534 4.29688 56.1314 4.29688 62.9492V75.8398C4.29688 81.7725 9.10637 86.582 15.0391 86.582H17.9835C17.9994 85.7553 18.0204 84.9288 18.0469 84.1023C17.3476 82.6768 16.9533 81.0745 16.9533 79.3796L16.7578 71.7578C16.7578 66.1212 17.9046 60.9441 22.0885 60.1012C24.0773 59.7006 25.7424 58.3456 26.5573 56.4876L40.3605 25.0145C43.1228 18.8167 49.2733 14.8242 56.0592 14.8242H43.1686Z" fill="#CEE1F2"></path>
                                <path d="M94.9609 86.582C100.894 86.582 105.703 81.7725 105.703 75.8398V62.9492C105.703 55.8299 99.9318 50.0586 92.8125 50.0586L79.5736 24.2505C76.6474 18.4688 70.7184 14.8242 64.2383 14.8242H43.1686C36.3829 14.8242 30.2324 18.8167 27.4699 25.0145L16.292 50.093C9.59105 50.5534 4.29688 56.1314 4.29688 62.9492V75.8398C4.29688 81.7725 9.10637 86.582 15.0391 86.582" stroke="#405FF2" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M38.0269 95.1758C42.7731 95.1758 46.6207 91.3282 46.6207 86.582C46.6207 81.8358 42.7731 77.9883 38.0269 77.9883C33.2807 77.9883 29.4332 81.8358 29.4332 86.582C29.4332 91.3282 33.2807 95.1758 38.0269 95.1758Z" stroke="#405FF2" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M63.1641 86.582H49.8433" stroke="#405FF2" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M71.9727 95.1758C76.7189 95.1758 80.5664 91.3282 80.5664 86.582C80.5664 81.8358 76.7189 77.9883 71.9727 77.9883C67.2265 77.9883 63.3789 81.8358 63.3789 86.582C63.3789 91.3282 67.2265 95.1758 71.9727 95.1758Z" stroke="#405FF2" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M51.5608 66.8164L63.5304 55.2099C65.9362 52.8587 64.2729 48.7712 60.9101 48.7712H49.9475C46.5786 48.7712 44.9182 44.6705 47.3367 42.3234L59.7328 30.293" stroke="#FF5CF3" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <!-- blog-blockt-two -->
                <div class="blog-blockt-two col-lg-6 col-md-6 col-sm-12">
                    <div class="inner-box two wow fadeInUp" data-wow-delay="100ms">
                        <h3 class="title">Do You Want to
                            <br>Sell a Motorcycle ?</h3>
                        <div class="text">We are committed to providing our customers with exceptional service.</div>
                        <a href="pricing.html" class="read-more">Get Started
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" fill="none">
                                <g clip-path="url(#clip0_601_692)">
                                    <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="white"></path>
                                </g>
                                <defs>
                                    <clippath id="clip0_601_692">
                                        <rect width="14" height="14" fill="white"></rect>
                                    </clippath>
                                </defs>
                            </svg>
                        </a>
                        <div class="hover-img">
                            <svg xmlns="http://www.w3.org/2000/svg" width="110" height="110" viewbox="0 0 110 110" fill="none">
                                <path d="M17.1875 84.2276V25.7724C17.1875 13.9118 26.779 4.29688 38.6109 4.29688H25.5664C13.7008 4.29688 4.08203 13.9156 4.08203 25.7812V84.2188C4.08203 96.0841 13.7008 105.703 25.5664 105.703H38.6109C26.779 105.703 17.1875 96.0882 17.1875 84.2276Z" fill="#CEE1F2"></path>
                                <path d="M72.4023 104.506C70.1826 105.281 67.7967 105.703 65.3125 105.703H25.7812C13.9156 105.703 4.29688 96.0841 4.29688 84.2188V25.7812C4.29688 13.9156 13.9156 4.29688 25.7812 4.29688H65.3125C77.1779 4.29688 86.7969 13.9156 86.7969 25.7812V48.3398M54.7852 82.2852H71.1133M21.4844 82.0703L25.4341 86.1614C27.1343 87.8681 29.8912 87.8681 31.5915 86.1614L39.7461 77.7734" stroke="#405FF2" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M105.047 70.0629C100.32 68.2247 97.1951 67.9622 94.8535 67.9622C90.5029 67.9622 87.0117 71.489 87.0117 75.8398C87.0117 80.1906 90.9148 83.7175 96.6917 83.7175C101.681 83.7175 105.703 87.2444 105.703 91.5952C105.703 95.9458 101.961 99.4729 97.6106 99.4729C95.5763 99.4729 91.0458 98.8124 86.582 97.038M96.6797 67.9622V61.0156M96.6797 99.4727V105.703M57.793 57.793V59.5117M34.1602 57.793V59.5117" stroke="#FF5CF4" stroke-width="5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M68.5352 36.7383H68.1835C68.1734 36.7146 68.1661 36.6902 68.1557 36.6667L64.3038 28.1203C64.3002 28.1123 64.2967 28.1046 64.2931 28.0966C62.5023 24.1867 58.9291 21.3217 54.734 20.4329C52.2427 19.9053 49.1996 19.5508 45.8829 19.5508C42.6308 19.5508 39.6816 19.8928 37.2649 20.402C33.0507 21.2902 29.4639 24.1577 27.6706 28.0728C27.6669 28.0807 27.6635 28.0887 27.6598 28.0966L23.7974 36.6665C23.7869 36.6899 23.7798 36.7144 23.7697 36.7381H23.418C21.0448 36.7381 19.1211 38.6618 19.1211 41.0349C19.1211 43.4081 21.0448 45.3318 23.418 45.3318V49.303C23.418 54.8137 27.8339 59.2969 33.2617 59.2969H58.6912C64.1193 59.2969 68.5352 54.8137 68.5352 49.3032V45.332C70.9083 45.332 72.832 43.4083 72.832 41.0352C72.832 38.662 70.9083 36.7383 68.5352 36.7383ZM35.4885 31.6415C36.1541 30.1969 37.4799 29.1393 39.0369 28.8112C40.6093 28.4799 42.9015 28.1445 45.8831 28.1445C48.9326 28.1445 51.3212 28.4945 52.953 28.8402C54.4951 29.167 55.811 30.2227 56.4755 31.6654L58.7617 36.7383H33.1914L35.4885 31.6415ZM35.0195 53.0664C32.1718 53.0664 29.8633 50.7579 29.8633 47.9102C29.8633 45.0624 32.1718 42.7539 35.0195 42.7539C37.8673 42.7539 40.1758 45.0624 40.1758 47.9102C40.1758 50.7579 37.8673 53.0664 35.0195 53.0664ZM56.9336 53.0664C54.0858 53.0664 51.7773 50.7579 51.7773 47.9102C51.7773 45.0624 54.0858 42.7539 56.9336 42.7539C59.7813 42.7539 62.0898 45.0624 62.0898 47.9102C62.0898 50.7579 59.7813 53.0664 56.9336 53.0664Z" fill="#FF5CF4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog-section-two -->

    <div class="wrap-fixed-sidebar">
        <div class="sidebar-backdrop"></div>
        <div class="widget-sidebar-filter">
            <div class="fixed-sidebar-title">
                <h3>More Filter</h3>
                <a href="#" title="" class="close-filters">
                    <img src="{{asset("wizmoto/images/icons/close.svg")}}" alt=""/>
                </a>
            </div>
            <div class="inventory-sidebar">
                <div class="inventroy-widget widget-location">
                    <div class="row ">
                        <h6 class="title">Main Data</h6>
                        <div class="col-lg-12">
                            <div class="form_boxes">
                                <label>Brand</label>
                                <div class="drop-menu" id="brand-dropdown">
                                    <div class="select">
                                        <span>Select Brand</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="brand_id" id="brand_id_input">
                                    <ul class="dropdown" style="display: none;">
                                        @foreach($brands as $brand)
                                            <li data-id="{{ $brand->id }}">{{$brand->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form_boxes">
                                <label>Model</label>
                                <div class="drop-menu" id="model-dropdown">
                                    <div class="select">
                                        <span>Select</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="vehicle_model_id" id="vehicle_model_id_input">
                                    <ul class="dropdown" style="display: none;" id="model-select">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form_boxes v2">
                                <label>Version</label>
                                <div class="drop-menu active">
                                    <input type="text" name="version_model">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form_boxes">
                                <label>BodyWork</label>
                                <div class="drop-menu" id="brand-dropdown">
                                    <div class="select">
                                        <span>Select BodyWork</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="vehicle_body_id">
                                    <ul class="dropdown" style="display: none;">
                                        @foreach($vehicleBodies as $vehicleBody)
                                            <li data-id="{{ $vehicleBody->id }}">{{$vehicleBody->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form_boxes">
                                <label>Fuel type</label>
                                <div class="drop-menu" id="motor-change-dropdown">
                                    <div class="select">
                                        <span>Select Fuel type</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="fuel_type_id">
                                    <ul class="dropdown" style="display: none;">
                                        @foreach($fuelTypes as $fuelType)
                                            <li data-id="{{ $fuelType->id }}">{{$fuelType->name}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Registration Year</label>
                                <div class="drop-menu" id="registration-year-dropdown">
                                    <div class="select">
                                        <span>From</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="registration_year_from">
                                    <ul class="dropdown" style="display: none;">
                                        @php
                                            $currentYear = date('Y');
                                        @endphp
                                        @for($y = $currentYear; $y >= 1990; $y--)
                                            <li data-id="{{ $y }}">{{ $y }}</li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Registration Year</label>
                                <div class="drop-menu" id="registration-year-dropdown">
                                    <div class="select">
                                        <span>To</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="registration_year_to">
                                    <ul class="dropdown" style="display: none;">
                                        @php
                                            $currentYear = date('Y');
                                        @endphp
                                        @for($y = $currentYear; $y >= 1990; $y--)
                                            <li data-id="{{ $y }}">{{ $y }}</li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form_boxes">
                                <label>Vehicle Condition</label>
                                <div class="drop-menu" id="vehicle-category-dropdown">
                                    <div class="select">
                                        <span>Select Vehicle Condition</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="vehicle_category">
                                    <ul class="dropdown" style="display: none;">
                                        <li data-id="Used">Used</li>
                                        <li data-id="Era">Era</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Mileage</label>
                                <div class="drop-menu">
                                    <div class="select">
                                        <span>From</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="mileage_from">
                                    <ul class="dropdown" style="display: none;">
                                        @php
                                            $step = 1500; // step size in km
                                            $maxMileage = 150000; // maximum mileage to show
                                        @endphp
                                        @for ($mileage = 1000; $mileage <= $maxMileage; $mileage += $step)
                                            <li data-id="{{ $mileage }}">{{ number_format($mileage) }} km</li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Mileage</label>
                                <div class="drop-menu">
                                    <div class="select">
                                        <span>To</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="mileage_to">
                                    <ul class="dropdown" style="display: none;">
                                        @php
                                            $step = 1500; // step size in km
                                            $maxMileage = 150000; // maximum mileage to show
                                        @endphp
                                        @for ($mileage = 1000; $mileage <= $maxMileage; $mileage += $step)
                                            <li data-id="{{ $mileage }}">{{ number_format($mileage) }} km</li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form_boxes v2">
                                <label>Power Kw</label>
                                <div class="drop-menu active">
                                    <input name="motor_power_kw" type="number" maxlength="4" placeholder="ex. 88">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form_boxes v2">
                                <label>Power Cv</label>
                                <div class="drop-menu active">
                                    <input name="motor_power_cv" type="number" maxlength="4" placeholder="ex. 120">
                                </div>
                            </div>
                        </div>
                        <h6 class="title">Equipment</h6>
                        <div class="col-lg-12">
                            <div class="equipment-list categories-box border-none-bottom">
                                @foreach($equipments as $equipment)
                                    <label class="contain">
                                        {{ $equipment->name }}
                                        <input type="checkbox" name="equipments[]" value="{{ $equipment->id }}">
                                        <span class="checkmark"></span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <h6 class="title">Exteriors</h6>
                        <div class="col-lg-12">
                            <div class="form_boxes">
                                <label>Exterior color</label>
                                <div class="color-list categories-box border-none-bottom">
                                    @foreach($vehicleColors as $color)
                                        <label class="contain" style="--box-color: {{ $color->hex_code }}">
                                            <span class="color-name">{{$color->name}}</span>
                                            <input type="checkbox" name="color_ids[]" value="{{ $color->id }}">
                                            <span class="checkmark"></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="contain">Metallic Paint
                                <input type="checkbox" name="is_metallic_paint">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <h6 class="title">Vehicle conditions</h6>
                        <div class="col-lg-6">
                            <div class="btn-box">
                                <label>Previous Owners</label>
                                <div class="number" style="padding: 10px">
                                    <span class="minus">-</span>
                                    <input type="text" value="1" name="previous_owners">
                                    <span class="plus">+</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 my-5">
                            <div class="cheak-box">
                                <label class="contain">Coupon Documentation
                                    <input type="checkbox" name="coupon_documentation">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-5">
                            <div class="cheak-box">
                                <label class="contain">Damaged Vehicle
                                    <input type="checkbox" name="damaged_vehicle">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="form_boxes">
                                <label>Change</label>
                                <div class="drop-menu" id="motor-change-dropdown">
                                    <div class="select">
                                        <span>Select Change</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="motor_change">
                                    <ul class="dropdown" style="display: none;">
                                        <li data-id="Manual">Manual</li>
                                        <li data-id="Automatic">Automatic</li>
                                        <li data-id="Semi-automatic">Semi-automatic</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="btn-box">
                                <label>Marches</label>
                                <div class="number" style="padding: 10px">
                                    <span class="minus">-</span>
                                    <input type="text" value="1" name="motor_marches">
                                    <span class="plus">+</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 ">
                            <div class="btn-box">
                                <label>Cylinders</label>
                                <div class="number" style="padding: 10px">
                                    <span class="minus">-</span>
                                    <input type="text" value="1" name="motor_cylinders">
                                    <span class="plus">+</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Displacement</label>
                                <div class="drop-menu" id="motor-displacement-dropdown">
                                    <input type="text" name="motor_displacement" placeholder="Engine displacement in cc">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Empty Weight</label>
                                <div class="drop-menu" id="motor-empty-weight-dropdown">
                                    <input type="text" name="motor_empty_weight" placeholder="Empty weight in kg">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form_boxes v2">
                                <label>Combined fuel consumption</label>
                                <div class="drop-menu active">
                                    <input type="text" name="combined_fuel_consumption" maxlength="5">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Emissions class</label>
                                <div class="drop-menu" id="motor-change-dropdown">
                                    <div class="select">
                                        <span>Select Emissions class</span>
                                        <i class="fa fa-angle-down"></i>
                                    </div>
                                    <input type="hidden" name="emissions_class">
                                    <ul class="dropdown" style="display: none;">
                                        @php
                                            $emissionsClasses=[
                                                'Euro 1',
                                                'Euro 2',
                                                'Euro 3',
                                                'Euro 4',
                                                'Euro 5',
                                                'Euro 6',
];
                                        @endphp
                                        @foreach($emissionsClasses as $emissionsClass)
                                            <li data-id="{{ $emissionsClass }}">{{$emissionsClass}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-column col-lg-12">
                            <div class="cheak-box">
                                <label class="contain">Deductible VAT
                                    <input type="checkbox" name="tax_deductible">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>

                        {{--                        price--}}
                        <div class="col-lg-12">
                            <div class="price-box">
                                <h6 class="title">Price</h6>
                                <form class="row g-0">
                                    <div class="form-column col-lg-6">
                                        <div class="form_boxes">
                                            <label>Min price</label>
                                            <div class="drop-menu">
                                                <!-- <input type="text" id="slider-range-value1" name="gender"> -->
                                                <span id="slider-range-value1"></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-column v2 col-lg-6">
                                        <div class="form_boxes">
                                            <label>Max price</label>
                                            <div class="drop-menu">
                                                <span id="slider-range-value2"></span>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="widget-price">

                                    <div id="slider-val"></div>
                                    <div class="slider-labels">
                                        <input type="hidden" name="min-value" value="">
                                        <input type="hidden" name="max-value" value="">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div><!--widget end-->
            </div>
        </div>

    </div>

    @include('wizmoto.partials.footer')

@endsection

@push('styles')
    <style>
        .color-list {
            display: flex;
            flex-wrap: wrap; /* allow multiple rows */
            gap: 12px;
        }

        .color-list .contain {
            position: relative;
            padding-left: 30px; /* keep your checkbox spacing */
            cursor: pointer;
            display: inline-block; /* keep your original display */
            margin: 6px;
            user-select: none;
            font-size: 14px;
            vertical-align: middle; /* fix vertical alignment of text */
        }

        .color-list .contain input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .color-list .checkmark {
            position: absolute;
            top: 4px;
            left: 0;
            height: 20px;
            width: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 4px;
            background-color: var(--box-color, #fff);
            transition: all 0.2s ease;
            box-shadow: inset 0 0 0 2px #fff; /* inner padding */
        }

        .color-list .contain input:checked ~ .checkmark {
            background-color: var(--box-color, #fff);
        }

        .color-list .checkmark::after {
            content: "";
            position: absolute;
            display: none;
            left: 6px;
            top: 2px;
            width: 6px;
            height: 12px;
            border: solid #b7b7b7;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .color-list .contain input:checked ~ .checkmark::after {
            display: block;
        }

    </style>
@endpush

