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
                        @include('wizmoto.partials.live-search', ['class' => 'style1'])
                    </div>

                    <!--Nav Box-->
                    <div class="nav-out-bar">
                        <nav class="nav main-menu">
                            <ul class="navigation" id="navbar">
                                <li class="current-dropdown current">
                                    <a class="box-account" href="{{ route('home') }}">
                                        Home
                                    </a>
                                </li>
                                @if (Auth::guard('provider')->check())
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

                                    <form id="logout-form" action="{{ route('provider.logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                @endif

                            </ul>
                        </nav>
                        <!-- Main Menu End-->
                    </div>

                    <div class="right-box">
                        @if (!Auth::guard('provider')->check())
                            <a href="{{ route('provider.auth') }}" title="" class="box-account">
                                <div class="icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_147_6490)">
                                            <path
                                                d="M7.99998 9.01221C3.19258 9.01221 0.544983 11.2865 0.544983 15.4161C0.544983 15.7386 0.806389 16.0001 1.12892 16.0001H14.871C15.1935 16.0001 15.455 15.7386 15.455 15.4161C15.455 11.2867 12.8074 9.01221 7.99998 9.01221ZM1.73411 14.8322C1.9638 11.7445 4.06889 10.1801 7.99998 10.1801C11.9311 10.1801 14.0362 11.7445 14.2661 14.8322H1.73411Z"
                                                fill="white" />
                                            <path
                                                d="M7.99999 0C5.79171 0 4.12653 1.69869 4.12653 3.95116C4.12653 6.26959 5.86415 8.15553 7.99999 8.15553C10.1358 8.15553 11.8735 6.26959 11.8735 3.95134C11.8735 1.69869 10.2083 0 7.99999 0ZM7.99999 6.98784C6.50803 6.98784 5.2944 5.62569 5.2944 3.95134C5.2944 2.3385 6.43231 1.16788 7.99999 1.16788C9.54259 1.16788 10.7056 2.36438 10.7056 3.95134C10.7056 5.62569 9.49196 6.98784 7.99999 6.98784Z"
                                                fill="white" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_147_6490">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                Sign in
                            </a>
                        @endif
                        <div class="btn">
                            <a href="{{ route('dashboard.create-advertisement') }}" class="header-btn-two btn-anim">Sell</a>
                        </div>
                        <div class="mobile-navigation">
                            <a href="#nav-mobile" title="">
                                <svg width="22" height="11" viewBox="0 0 22 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="22" height="2" fill="white" />
                                    <rect y="9" width="22" height="2" fill="white" />
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

        @include('wizmoto.partials.mobile-menu')
    </header>
    <!-- End header-section -->

    <!-- inventory-section -->
    <section class="inventory-section pb-0 layout-radius">
        <div class="boxcar-container">
            <div class="boxcar-title-three">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li><span>Motors for Sale</span></li>
                </ul>
                <h2>{{ $advertisement->brand?->name }}{{ ' ' }}{{ $advertisement->vehicleModel?->name }}</h2>
                <div class="text">{{ $advertisement->version_model }}</div>
                <div class="content-box">
                    <h3 class="title">${{ $advertisement->final_price }}</h3>
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
                                        {{--                                        <li><a href="https://www.youtube.com/watch?v=7e90gBu4pas" data-fancybox="gallery2"><img src="images/resource/video1-1.svg">Video</a></li> --}}
                                        {{--                                        <li><a href="#"><img src="images/resource/video1-2.svg">360 View</a></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div class="row">

                            @foreach ($images->skip(1) as $image)
                                <div class="image-column-two item2 col-6">
                                    <div class="inner-column">
                                        <div class="image-box">
                                            <figure class="image">
                                                <a href="{{ $image->getUrl('preview') }}" data-fancybox="gallery"
                                                    class="fancybox">
                                                    <img src="{{ $image->getUrl('square') }}" loading="lazy"
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
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-1.svg') }}">Body Type
                                                </span>
                                                {{ $advertisement->vehicleBody?->name ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-11.svg') }}">Exterior Color
                                                </span>
                                                {{ $advertisement->vehicleColor?->name ?? 'N/A' }}
                                                @if ($advertisement->is_metallic_paint)
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
                                                    <img
                                                        src="{{ asset('wizmoto/images/resource/insep1-5.svg') }}">Transmission
                                                </span>
                                                {{ $advertisement->motor_change ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">Displacement
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
                                                    <img
                                                        src="{{ asset('wizmoto/images/resource/insep1-7.svg') }}">Condition
                                                </span>
                                                {{ $advertisement->vehicle_category ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-2.svg') }}">Mileage
                                                </span>
                                                {{ $advertisement->mileage ? number_format($advertisement->mileage) . ' km' : 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">
                                                    First Registration
                                                </span>
                                                {{ $advertisement->registration_year ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">Last Service
                                                </span>
                                                {{ $advertisement->last_service_year ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <span>
                                                    <img
                                                        src="{{ asset('wizmoto/images/resource/insep1-10.svg') }}">Cylinders
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
                            <div class="text two">{{ $advertisement->description }}</div>
                        </div>

                        <div class="location-box">
                            <h4 class="title">Location</h4>
                            <div class="text">
                                {{ $advertisement->city ?? '' }} {{ $advertisement->zip_code ?? '' }}
                            </div>
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($advertisement->city . ' ' . $advertisement->zip_code) }}"
                                target="_blank" class="brand-btn">
                                Get Directions
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                    viewbox="0 0 15 14" fill="none">
                                    <g clip-path="url(#clip0_881_14440)">
                                        <path
                                            d="M14.1111 0H5.55558C5.34062 0 5.16668 0.173943 5.16668 0.388901C5.16668 0.603859 5.34062 0.777802 5.55558 0.777802H13.1723L0.613941 13.3362C0.46202 13.4881 0.46202 13.7342 0.613941 13.8861C0.689884 13.962 0.789415 14 0.88891 14C0.988405 14 1.0879 13.962 1.16388 13.8861L13.7222 1.3277V8.94447C13.7222 9.15943 13.8962 9.33337 14.1111 9.33337C14.3261 9.33337 14.5 9.15943 14.5 8.94447V0.388901C14.5 0.173943 14.3261 0 14.1111 0Z"
                                            fill="#405FF2"></path>
                                    </g>
                                    <defs>
                                        <clippath id="clip0_881_14440">
                                            <rect width="14" height="14" fill="white"
                                                transform="translate(0.5)"></rect>
                                        </clippath>
                                    </defs>
                                </svg>
                            </a>
                            <div class="google-iframe">
                                <iframe
                                    src="https://maps.google.com/maps?width=100%25&height=600&hl=en&q={{ urlencode($advertisement->city . ' ' . $advertisement->zip_code) }}&t=&z=14&ie=UTF8&iwloc=B&output=embed"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="side-bar-column style-1 col-lg-4 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="contact-box">
                            <div class="icon-box">
                                @if($advertisement->provider?->getFirstMediaUrl('image', 'thumb'))
                                    <img src="{{ $advertisement->provider->getFirstMediaUrl('image', 'thumb') }}"
                                        alt="Provider Image"
                                        style="width: 80px; height: 80px; border-radius: 80%; object-fit: cover;">
                                @else
                                    <div style="width: 80px; height: 80px; border-radius: 80%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="#666"/>
                                            <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z" fill="#666"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="content-box">
                                {{-- Dealer / Provider Name (assuming from provider relation) --}}
                                <h6 class="title">{{ $advertisement->provider->full_name ?? 'Unknown Dealer' }}</h6>

                                {{-- Seller Type Badge --}}
                                @if($advertisement->provider && $advertisement->provider->seller_type)
                                    <div class="seller-type-badge">
                                        <span class="badge badge-{{ $advertisement->provider->seller_type == \App\Enums\SellerTypeEnum::DEALER ? 'primary' : 'secondary' }}">
                                            {{ $advertisement->provider->seller_type->getLabel() }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Address --}}
                                <div class="text">
                                    {{ $advertisement->city ?? '' }}
                                    {{ $advertisement->zip_code ? ', ' . $advertisement->zip_code : '' }}
                                </div>

                                {{-- Contact List --}}
                                <ul class="contact-list">
                                    {{-- Directions --}}
                                    <li>
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($advertisement->city . ' ' . $advertisement->zip_code) }}"
                                            target="_blank">
                                            <div class="image-box">
                                                <img src="{{ asset('wizmoto/images/resource/phone1-1.svg') }}">
                                            </div>
                                            Get Directions
                                        </a>
                                    </li>

                                    {{-- Phone (only if allowed) --}}
                                    @if ($advertisement->show_phone && $advertisement->telephone)
                                        <li>
                                            <a
                                                href="tel:{{ $advertisement->international_prefix }}{{ $advertisement->prefix }}{{ $advertisement->telephone }}">
                                                <div class="image-box">
                                                    <img src="{{ asset('wizmoto/images/resource/phone1-2.svg') }}">
                                                </div>
                                                {{ $advertisement->international_prefix }} {{ $advertisement->prefix }}
                                                {{ $advertisement->telephone }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>

                                {{-- Buttons --}}
                                <div class="btn-box">
                                    <a href="#" id="initiate-chat-btn" class="side-btn" data-bs-toggle="modal"
                                        data-bs-target="#contactModal">Send Message
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                            viewbox="0 0 15 14" fill="none">
                                            <g clip-path="url(#clip0_881_16253)">
                                                <path
                                                    d="M14.1111 0H5.55558C5.34062 0 5.16668 0.173943 5.16668 0.388901C5.16668 0.603859 5.34062 0.777802 5.55558 0.777802H13.1723L0.613941 13.3362C0.46202 13.4881 0.46202 13.7342 0.613941 13.8861C0.689884 13.962 0.789415 14 0.88891 14C0.988405 14 1.0879 13.962 1.16388 13.8861L13.7222 1.3277V8.94447C13.7222 9.15943 13.8962 9.33337 14.1111 9.33337C14.3261 9.33337 14.5 9.15943 14.5 8.94447V0.388901C14.5 0.173943 14.3261 0 14.1111 0Z"
                                                    fill="white"></path>
                                            </g>
                                            <defs>
                                                <clippath id="clip0_881_16253">
                                                    <rect width="14" height="14" fill="white"
                                                        transform="translate(0.5)"></rect>
                                                </clippath>
                                            </defs>
                                        </svg>
                                    </a>
                                    @if($advertisement->provider->whatsapp_link)
                                    <a href="{{ $advertisement->provider->whatsapp_link }}" class="side-btn two"
                                        target="_blank">
                                        Chat Via Whatsapp
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 14 14" fill="none">
                                            <path d="M13.6111 0H5.05558C4.84062 0..." fill="#60C961"></path>
                                        </svg>
                                    </a>
                                    @endif
                                    <a href="{{ route('provider.show', $advertisement->provider_id) }}"
                                        class="side-btn-three">View all stock at this dealer
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 14 14" fill="none">
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
            <div class="boxcar-container">
                <div class="boxcar-title wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                    <h2>We Think You Also Like</h2>
                    <a href="{{ route('inventory.list', ['type' => $advertisement->advertisement_type_id]) }}" class="btn-title">
                        View All<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <g clip-path="url(#clip0_601_243)">
                                <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="#050B20"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_601_243">
                                    <rect width="14" height="14" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                </div>
        
                @if($relatedAdvertisements->count() > 0)
                    <div class="row car-slider-three slider-layout-1" data-preview="4.8">
                        @foreach($relatedAdvertisements as $index => $relatedAd)
                            <!-- car-block-three -->
                            <div class="box-car car-block-three col-lg-3 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <div class="image-gallery" data-count="{{ $relatedAd->getMedia('covers')->count() }}">
                                            @php
                                                $images = $relatedAd->getMedia('covers');
                                                $firstImage = $images->first();
                                                $remainingImages = $images->skip(1)->take(2);
                                            @endphp
                                            
                                            @if($firstImage)
                                                <div class="main-image">
                                                    <a href="{{ $firstImage->getUrl('preview') }}" data-fancybox="gallery-{{ $relatedAd->id }}">
                                                        <img
                                                            src="{{ $firstImage->getUrl('card') }}"
                                                            loading="lazy"
                                                            alt="{{ $relatedAd->title ?? 'Advertisement Image' }}">
                                                    </a>
                                                </div>
                                            @endif
                                            
                                            @if($remainingImages->count() > 0)
                                                <div class="thumbnail-images">
                                                    @foreach($remainingImages as $image)
                                                        <a href="{{ $image->getUrl('preview') }}" data-fancybox="gallery-{{ $relatedAd->id }}" class="thumb-link">
                                                            <img
                                                                src="{{ $image->getUrl('card') }}"
                                                                loading="lazy"
                                                                alt="{{ $relatedAd->title ?? 'Advertisement Image' }}">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="content-box">
                                        <h6 class="title">
                                            <a href="{{ route('advertisements.show', $relatedAd->id) }}">{{$relatedAd->brand?->name}}{{' '}}{{$relatedAd->vehicleModel?->name}}</a>
                                        </h6>
                                        <div class="text">{{$relatedAd->version_model}}</div>
                                        <ul>
                                            <li>
                                                <i class="flaticon-gasoline-pump"></i>{{ $relatedAd->fuelType?->name ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <i class="flaticon-speedometer"></i>{{ $relatedAd->mileage ? number_format($relatedAd->mileage) . ' miles' : 'N/A' }}
                                            </li>
                                            <li>
                                                <i class="flaticon-gearbox"></i> {{ $relatedAd->motor_change ?? 'N/A' }}
                                            </li>
                                        </ul>
                                        <div class="btn-box">
                                            <span>${{$relatedAd->final_price}}</span>
                                            <a href="{{ route('advertisements.show', $relatedAd->id) }}" class="details">View Details
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
                @else
                    <!-- No Related Ads Fallback -->
                    <div class="text-center py-5">
                        <p class="text-muted mb-4">No similar vehicles available at the moment.</p>
                        <a href="{{ route('inventory.list') }}" class="theme-btn btn-style-one">
                            <span>Browse All Vehicles</span>
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <!-- End shop section two -->
    </section>
    <!-- End inventory-section -->

    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">💬 Contact {{ $advertisement->provider->full_name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="contact-form" class="inventroy-widget">
                        <p class="text-muted mb-4">Send a message to inquire about this dealer. Your email will be kept
                            private.</p>

                        <form id="initiate-contact-form" method="POST" action="{{ route('chat.initiate') }}">
                            @csrf
                            <input type="hidden" name="advertisement_id" value="{{ $advertisement->id }}">
                            <div class="form-column col-lg-12">
                                <div class="form_boxes">
                                    <label>Your Name *</label>
                                    <input type="text" id="guest-name" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-column col-lg-12">
                                <div class="form_boxes">
                                    <label>Your Email *</label>
                                    <input type="email" id="guest-email" placeholder="" required>
                                </div>
                            </div>


                            <div class="form-column col-lg-12">
                                <div class="form_boxes">
                                    <label>Phone (Optional)</label>
                                    <input type="tel" id="guest-phone" placeholder="">
                                </div>
                            </div>


                            <div class="form-column col-lg-12">
                                <div class="form_boxes v2">
                                    <label>Message *</label>
                                    <textarea id="contact-message"
                                        placeholder="Hi, I'm interested in your motorcycles. Can you provide more information about availability and pricing?"
                                        required></textarea>
                                </div>
                            </div>


                            <div class="alert alert-info">
                                <small>
                                    <i class="fa fa-info-circle"></i>
                                    <strong>Privacy Notice:</strong> Your email will be kept private until you choose to
                                    share it with the dealer.
                                </small>
                            </div>

                            <div class="form-submit">
                                <button type="submit" class="theme-btn" id="send-contact-btn"
                                    data-url="{{ route('chat.initiate') }}">
                                    <span class="d-flex align-items-center gap-2">
                                        Send Message <i class="fa fa-paper-plane"></i>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="contact-success" class="d-none">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="fa fa-check-circle text-success" style="font-size: 3rem;"></i>
                            </div>
                            <h4 class="text-success">Message Sent Successfully!</h4>
                            <p class="mb-3">Your message has been sent to {{ $advertisement->provider->full_name }}.</p>
                            <div class="alert alert-success">
                                <strong>Your conversation link:</strong><br>
                                <div class="conversation-link-container mt-2">
                                    <div class="conversation-link-box" id="conversation-link" onclick="selectAndCopyLink()">
                                        <span class="link-text"></span>
                                        <div class="action-buttons">
                                            <button class="action-btn go-btn" id="go-to-conversation-btn" onclick="event.stopPropagation(); goToConversation()" title="Go to conversation">
                                                <i class="fa fa-external-link"></i>
                                            </button>
                                            <button class="action-btn copy-btn" id="copy-link-btn" onclick="event.stopPropagation(); copyToClipboard()" title="Copy to clipboard">
                                                <i class="fa fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted">
                                <i class="fa fa-bookmark"></i> <strong>Bookmark this link</strong> to continue the
                                conversation later!
                            </p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('wizmoto.partials.footer')
@endsection

@push('styles')
    <style>

    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
    
            const $stars = $('.rating-list .list-box .list li');

            $stars.on('mouseenter', function() {
                const index = $(this).index();
                $(this).siblings().addBack().each(function(i) {
                    $(this).toggleClass('hovered', i <= index);
                });
            }).on('mouseleave', function() {
                $(this).siblings().addBack().removeClass('hovered');
            });

            $stars.on('click', function() {
                const index = $(this).index();
                const $list = $(this).closest('.list');
                $list.children().each(function(i) {
                    $(this).toggleClass('selected', i <= index);
                });
                // Set hidden input value
                $(this).closest('.list-box').find('input[name="stars"]').val(index + 1);
            });

            // Handle contact form submission
            $('#initiate-contact-form').on('submit', function(e) {
                e.preventDefault();

                const name = $('#guest-name').val();
                const email = $('#guest-email').val();
                const phone = $('#guest-phone').val();
                const message = $('#contact-message').val();
                const providerId = {{ $advertisement->provider->id }};

                // Disable submit button
                $('#send-contact-btn').prop('disabled', true).html(
                    '<i class="fa fa-spinner fa-spin"></i> Sending...');

                // Send message via AJAX
                $.ajax({
                    url: $('#send-contact-btn').data('url'),
                    method: 'POST',
                    data: {
                        provider_id: providerId,
                        name: name,
                        email: email,
                        phone: phone,
                        message: message,
                        _token: @json(csrf_token())
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            $('#contact-form').addClass('d-none');
                            $('#contact-success').removeClass('d-none');
                            $('#conversation-link .link-text').text(response.conversation_link);

                            // Store email in localStorage for future use
                            localStorage.setItem('guest_email_' + providerId, email);

                            // Show success notification
                            swal.fire({
                                toast: true,
                                title: 'Message sent successfully!',
                                text: 'Your message has been sent successfully!',
                                icon: 'success',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                        } else {
                            // Show errors
                            let errors = '';
                            $.each(response.errors, function(key, value) {
                                errors += value.join(', ') + '\n';
                            });
                            swal.fire({
                                toast: true,
                                title: 'Error',
                                text: errors,
                                icon: 'error',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                        }
                    },
                    error: function(xhr) {

                        swal.fire({
                            toast: true,
                            title: 'Error',
                            text: 'Failed to send message. Please try again.',
                            icon: 'error',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    },
                    complete: function() {
                        // Re-enable submit button
                        $('#send-contact-btn').prop('disabled', false).html(
                            '<i class="fa fa-paper-plane"></i> Send Message');
                    }
                });
            });

            // Reset modal when closed
            $('#contactModal').on('hidden.bs.modal', function() {
                $('#contact-form').removeClass('d-none');
                $('#contact-success').addClass('d-none');
                $('#initiate-contact-form')[0].reset();
                $('#send-contact-btn').prop('disabled', false).html(
                    '<i class="fa fa-paper-plane"></i> Send Message');
            });

            // Fix modal blocking issues
            $('#contactModal').on('show.bs.modal', function() {
                // Remove any blocking elements that might prevent clicks
                $('.mm-wrapper__blocker').remove();
                $('.mobile-menu-overlay').remove();
                $('.page-overlay').remove();
                $('.overlay').remove();
                
                // Force enable pointer events on everything
                $('body *').css('pointer-events', 'auto');
                $('body').css('pointer-events', 'auto');
            });

            $('#contactModal').on('shown.bs.modal', function() {
                // Force remove any blocking elements
                $('.mm-wrapper__blocker, .mobile-menu-overlay, .page-overlay, .overlay').remove();
                
                // Force enable all elements
                $('body *').css({
                    'pointer-events': 'auto',
                    'z-index': 'auto'
                });
                
                // Ensure modal is on top
                $(this).css({
                    'z-index': '99999999',
                    'pointer-events': 'auto'
                });
                
                // Ensure modal content is clickable
                $(this).find('*').css({
                    'pointer-events': 'auto',
                    'z-index': 'auto'
                });
                
                // Force focus on first input
                setTimeout(function() {
                    $('#contactModal input:first').focus();
                }, 100);
            });

            // Pre-fill email if previously used
            const savedEmail = localStorage.getItem('guest_email_' + {{ $advertisement->provider->id }});
            if (savedEmail) {
                $('#guest-email').val(savedEmail);
            }
        });

        // Global functions for conversation link
        window.selectAndCopyLink = function() {
            const linkText = $('#conversation-link .link-text').text();
            if (linkText) {
                // Select the text
                if (window.getSelection) {
                    const selection = window.getSelection();
                    const range = document.createRange();
                    range.selectNodeContents(document.querySelector('#conversation-link .link-text'));
                    selection.removeAllRanges();
                    selection.addRange(range);
                }
                
                // Copy to clipboard
                copyToClipboard();
            }
        };

        window.goToConversation = function() {
            const linkText = $('#conversation-link .link-text').text();
            if (linkText) {
                // Open the conversation link in a new tab
                window.open(linkText, '_blank');
            }
        };

        window.copyToClipboard = function() {
            const linkText = $('#conversation-link .link-text').text();
            
            if (linkText) {
                // Try modern clipboard API first
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(linkText).then(function() {
                        showCopySuccess();
                    }).catch(function(err) {
                        console.error('Clipboard API failed:', err);
                        fallbackCopy(linkText);
                    });
                } else {
                    // Fallback for older browsers
                    fallbackCopy(linkText);
                }
            }
        };

        function fallbackCopy(text) {
            try {
                // Create a temporary textarea
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                
                const successful = document.execCommand('copy');
                document.body.removeChild(textArea);
                
                if (successful) {
                    showCopySuccess();
                } else {
                    throw new Error('execCommand failed');
                }
            } catch (err) {
                console.error('Fallback copy failed:', err);
                alert('Failed to copy link. Please select and copy manually.');
            }
        }

        function showCopySuccess() {
            const $btn = $('#copy-link-btn');
            const $icon = $btn.find('i');
            
            // Change button appearance
            $btn.addClass('copied');
            $icon.attr('class', 'fa fa-check');
            
            // Show notification
            if (typeof toastr !== 'undefined') {
                toastr.success('Link copied to clipboard!');
            } else {
                // Create a temporary success message
                const $successMsg = $('<div class="copy-success-msg">Copied!</div>');
                $successMsg.css({
                    position: 'absolute',
                    top: '-30px',
                    right: '0',
                    background: '#28a745',
                    color: 'white',
                    padding: '4px 8px',
                    borderRadius: '4px',
                    fontSize: '12px',
                    zIndex: 1000
                });
                
                $btn.parent().css('position', 'relative').append($successMsg);
                
                setTimeout(function() {
                    $successMsg.remove();
                }, 2000);
            }
            
            // Reset button after 2 seconds
            setTimeout(function() {
                $btn.removeClass('copied');
                $icon.attr('class', 'fa fa-copy');
            }, 2000);
        }

        // Initialize image gallery interactions for "We Think You Also Like" cards
        function initializeImageGalleries() {
            // Add click handlers for thumbnail images
            $('.thumb-link').on('click', function(e) {
                e.preventDefault();
                
                const $gallery = $(this).closest('.image-gallery');
                const $mainImage = $gallery.find('.main-image img');
                const $thumbImage = $(this).find('img');
                
                // Swap the main image with the clicked thumbnail
                const mainSrc = $mainImage.attr('src');
                const thumbSrc = $thumbImage.attr('src');
                
                $mainImage.attr('src', thumbSrc);
                $thumbImage.attr('src', mainSrc);
                
                // Update the main image link
                const $mainLink = $gallery.find('.main-image a');
                const thumbHref = $(this).attr('href');
                $mainLink.attr('href', thumbHref);
            });
        }

        // Initialize image galleries when document is ready
        $(document).ready(function() {
            initializeImageGalleries();
        });
    </script>
@endpush

@push('styles')
<style>
.conversation-link-container {
    width: 100%;
}

.conversation-link-box {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    word-break: break-all;
}

.conversation-link-box:hover {
    background: #e9ecef;
    border-color: #007bff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
}

.conversation-link-box:active {
    transform: translateY(0);
    box-shadow: 0 1px 4px rgba(0,123,255,0.2);
}

.link-text {
    flex: 1;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    color: #495057;
    line-height: 1.4;
    margin-right: 12px;
    user-select: all;
}

.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
}

.action-btn {
    border: none;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 14px;
    min-width: 40px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.go-btn {
    background: #28a745;
}

.go-btn:hover {
    background: #218838;
    transform: scale(1.05);
}

.go-btn:active {
    transform: scale(0.95);
}

.copy-btn {
    background: #007bff;
}

.copy-btn:hover {
    background: #0056b3;
    transform: scale(1.05);
}

.copy-btn:active {
    transform: scale(0.95);
}

.copy-btn.copied {
    background: #28a745;
}

.copy-btn.copied i {
    transform: scale(1.2);
}

/* Mobile responsiveness */
@media (max-width: 576px) {
    .conversation-link-box {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    
    .link-text {
        margin-right: 0;
        text-align: center;
    }
    
    .action-buttons {
        justify-content: center;
        gap: 12px;
    }
    
    .action-btn {
        flex: 1;
        max-width: 120px;
    }
}

/* Image Gallery Styles for "We Think You Also Like" Cards */
.image-gallery {
    position: relative;
    overflow: hidden;
}

.thumbnail-images {
    position: absolute;
    bottom: 8px;
    right: 8px;
    display: flex;
    flex-direction: row;
    gap: 4px;
    z-index: 2;
}

.thumb-link {
    display: block;
    width: 50px;
    height: 50px;
    border-radius: 4px;
    overflow: hidden;
    border: 2px solid rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.thumb-link:hover {
    border-color: #405FF2;
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(64, 95, 242, 0.3);
}

.thumb-link img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.main-image {
    position: relative;
    z-index: 1;
}

.main-image img {
    width: 100%;
    height: auto;
    transition: all 0.3s ease;
}
</style>
@endpush
