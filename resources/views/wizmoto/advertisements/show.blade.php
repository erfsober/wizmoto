@extends('master')
@section('content')
    <!-- Main Header-->
    <header class="boxcar-header header-style-v1 style-two inner-header cus-style-1">
        <div class="header-inner">
            <div class="inner-container">
                <!-- Main box -->
                <div class="c-box">
                    <div class="logo-inner">
                        <div class="logo">
                            <a href="index.html">
                                <img src="images/logo.svg" alt="" title="Wizmoto">
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
                                    <a class="box-account" href="#">
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

    <!-- inventory-section -->
    <section class="inventory-section pb-0 layout-radius">
        <div class="boxcar-container">
            <div class="boxcar-title-three">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{route("home")}}">Home</a>
                    </li>
                    <li><span>Motors for Sale</span></li>
                </ul>
                <h2>{{$advertisement->brand?->name}}{{' '}}{{$advertisement->vehicleModel?->name}}</h2>
                <div class="text">{{$advertisement->version_model}}</div>
                <div class="content-box">
                    <h3 class="title">${{$advertisement->final_price}}</h3>
                </div>
            </div>
            <div class="gallery-sec">
                <div class="row">
                    <div class="image-column item1 col-lg-7 col-md-12 col-sm-12">
                        <div class="inner-column">
                            @php $images = $advertisement->getMedia('covers'); @endphp
                            <div class="image-box">
                                <figure class="image">
                                    <a href="{{ $images->first()->getUrl('preview') }}" data-fancybox="gallery">
                                        <img src="{{ $images->first()->getUrl('preview') }}" alt="">
                                    </a>
                                </figure>
                                <div class="content-box">
                                    <ul class="video-list">
                                        {{--                                        <li><a href="https://www.youtube.com/watch?v=7e90gBu4pas" data-fancybox="gallery2"><img src="images/resource/video1-1.svg">Video</a></li>--}}
                                        {{--                                        <li><a href="#"><img src="images/resource/video1-2.svg">360 View</a></li>--}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div class="row">

                            @foreach($images->skip(1) as $image)
                                <div class="image-column-two item2 col-6">
                                    <div class="inner-column">
                                        <div class="image-box">
                                            <figure class="image">
                                                <a href="{{ $image->getUrl('preview') }}" data-fancybox="gallery" class="fancybox">
                                                    <img src="{{ $image->getUrl('square') }}"
                                                         srcset="{{ $image->getUrl('square') }} 300w, {{ $image->getUrl('preview') }} 800w"
                                                         loading="lazy"
                                                         alt="">
                                                </a>
                                            </figure>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="inspection-column col-lg-8 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- overview-sec -->
                        <div class="overview-sec">
                            <h4 class="title">Motor Overview</h4>
                            <div class="row">
                                {{-- Left Column --}}
                                <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                    <div class="inner-column">
                                        <ul class="list">
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-1.svg') }}">Body
                                                </span>
                                                {{ $advertisement->vehicleBody?->name ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-11.svg') }}">Color
                                                </span>
                                                {{ $advertisement->vehicleColor?->name ?? 'N/A' }}
                                                @if($advertisement->is_metallic_paint)
                                                    <small>(Metallic)</small>
                                                @endif
                                            </li>

                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">Fuel Type
                                                </span>
                                                {{ $advertisement->fuelType?->name ?? 'N/A' }}
                                            </li>

                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-5.svg') }}">Transmission
                                                </span>
                                                {{ $advertisement->motor_change ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">Engine Size
                                                </span>
                                                {{ $advertisement->motor_displacement ? $advertisement->motor_displacement . ' cc' : 'N/A' }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Right Column --}}
                                <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                    <div class="inner-column">
                                        <ul class="list">
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-7.svg') }}">Condition
                                                </span>
                                                {{ $advertisement->vehicle_category ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-2.svg') }}">Mileage
                                                </span>
                                                {{ $advertisement->mileage ? number_format($advertisement->mileage) . ' miles' : 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}"> Registration Year
                                                </span>
                                                {{ $advertisement->registration_year ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}"> Last Service Year
                                                </span>
                                                {{ $advertisement->last_service_year ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-10.svg') }}">Cylinders
                                                </span>
                                                {{ $advertisement->motor_cylinders ?? 'N/A' }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- description-sec -->
                        <div class="description-sec">
                            <h4 class="title">Description</h4>
                            <div class="text two">{{$advertisement->description}}</div>
                        </div>

                        <div class="location-box">
                            <h4 class="title">Location</h4>
                            <div class="text">
                                {{ $advertisement->city ?? '' }} {{ $advertisement->zip_code ?? '' }}
                            </div>
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($advertisement->city . ' ' . $advertisement->zip_code) }}" target="_blank" class="brand-btn">
                                Get Directions
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewbox="0 0 15 14" fill="none">
                                    <g clip-path="url(#clip0_881_14440)">
                                        <path d="M14.1111 0H5.55558C5.34062 0 5.16668 0.173943 5.16668 0.388901C5.16668 0.603859 5.34062 0.777802 5.55558 0.777802H13.1723L0.613941 13.3362C0.46202 13.4881 0.46202 13.7342 0.613941 13.8861C0.689884 13.962 0.789415 14 0.88891 14C0.988405 14 1.0879 13.962 1.16388 13.8861L13.7222 1.3277V8.94447C13.7222 9.15943 13.8962 9.33337 14.1111 9.33337C14.3261 9.33337 14.5 9.15943 14.5 8.94447V0.388901C14.5 0.173943 14.3261 0 14.1111 0Z" fill="#405FF2"></path>
                                    </g>
                                    <defs>
                                        <clippath id="clip0_881_14440">
                                            <rect width="14" height="14" fill="white" transform="translate(0.5)"></rect>
                                        </clippath>
                                    </defs>
                                </svg>
                            </a>
                            <div class="google-iframe">
                                <iframe src="https://maps.google.com/maps?width=100%25&height=600&hl=en&q={{ urlencode($advertisement->city . ' ' . $advertisement->zip_code) }}&t=&z=14&ie=UTF8&iwloc=B&output=embed"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="side-bar-column style-1 col-lg-4 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="contact-box">
                            <div class="icon-box">
                                <img src="{{ $advertisement->provider?->getFirstMediaUrl('image','thumb') }}" alt="Header Image" style="width: 80px; height: 80px;      border-radius: 80%;  object-fit: cover; ">

                            </div>
                            <div class="content-box">
                                {{-- Dealer / Provider Name (assuming from provider relation) --}}
                                <h6 class="title">{{ $advertisement->provider->full_name ?? 'Unknown Dealer' }}</h6>

                                {{-- Address --}}
                                <div class="text">
                                    {{ $advertisement->city ?? '' }}
                                    {{ $advertisement->zip_code ? ', ' . $advertisement->zip_code : '' }}
                                </div>

                                {{-- Contact List --}}
                                <ul class="contact-list">
                                    {{-- Directions --}}
                                    <li>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($advertisement->city . ' ' . $advertisement->zip_code) }}" target="_blank">
                                            <div class="image-box">
                                                <img src="{{ asset('wizmoto/images/resource/phone1-1.svg') }}">
                                            </div>
                                            Get Directions
                                        </a>
                                    </li>

                                    {{-- Phone (only if allowed) --}}
                                    @if($advertisement->show_phone && $advertisement->telephone)
                                        <li>
                                            <a href="tel:{{ $advertisement->international_prefix }}{{ $advertisement->prefix }}{{ $advertisement->telephone }}">
                                                <div class="image-box">
                                                    <img src="{{ asset('wizmoto/images/resource/phone1-2.svg') }}">
                                                </div>
                                                {{ $advertisement->international_prefix }} {{ $advertisement->prefix }} {{ $advertisement->telephone }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>

                                {{-- Buttons --}}
                                <div class="btn-box">
{{--                                    <a href="{{ route('dealer.message', $advertisement->provider_id) }}" class="side-btn">Message Dealer--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">--}}
{{--                                            <path d="M13.6111 0H5.05558C4.84062 0..." fill="white"></path>--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}

                                    <a href="https://wa.me/{{ $advertisement->provider->whatsapp }}" class="side-btn two" target="_blank">
                                        Chat Via Whatsapp
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path d="M13.6111 0H5.05558C4.84062 0..." fill="#60C961"></path>
                                        </svg>
                                    </a>

                                    <a href="{{ route('provider.show', $advertisement->provider_id) }}" class="side-btn-three">View all stock at this dealer
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <path d="M13.6111 0H5.05558C4.84062 0..." fill="#050B20"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cars-section-three -->
        <div class="cars-section-three">
        </div>
        <!-- End shop section two -->
    </section>
    <!-- End inventory-section -->

    @include('wizmoto.partials.footer')

@endsection

@push('styles')
    <style>

    </style>

@endpush
