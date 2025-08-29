@extends('master')
@section('body-class', 'body')
@section('main-div', 'v2')
@section('content')
    <header class="boxcar-header header-style-ten">
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
                        <div class="btn-box">

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
                                                <a href="{{ route('provider.dashboard') }}">Dashboard</a>
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
                        <a href="#" class="haeder-img">
                            <img src="{{ $provider->getFirstMediaUrl('image','thumb') ?: asset('wizmoto/images/resource/header-img.png') }}" alt="Header Image" style="width: 50px; height: 50px;      border-radius: 50%;  object-fit: cover; ">
                        </a>
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

    <!-- dashboard-widget -->
    <section class="dashboard-widget">
        <div class="right-box">
            <div class="side-bar">
                <ul class="nav-list">
                    <li>
                        <a href="{{route('dashboard.my-advertisements')}}">
                            <img src="{{asset("wizmoto/images/icons/dash2.svg")}}" alt="">My Listings
                        </a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.create-advertisement')}}">
                            <img src="{{asset("wizmoto/images/icons/dash3.svg")}}" alt="">Add Listings
                        </a>
                    </li>
                    <li>
                        <a href="{{route('dashboard.profile')}}">
                            <img src="{{asset("wizmoto/images/icons/dash7.svg")}}" alt="">My Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('provider.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <img src="{{asset("wizmoto/images/icons/dash8.svg")}}" alt="">
                            Logout
                        </a>
                </ul>
            </div>
            @yield('dashboard-content')

        </div>
    </section>
@endsection
