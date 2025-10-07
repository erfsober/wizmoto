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
                                <form action="{{ route('inventory.list') }}" method="GET">
                                <div class="search-box">
                                    <svg class="icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.29301 1.2876C3.9872 1.2876 1.29431 3.98048 1.29431 7.28631C1.29431 10.5921 3.9872 13.2902 7.29301 13.2902C8.70502 13.2902 10.0036 12.7954 11.03 11.9738L13.5287 14.4712C13.6548 14.5921 13.8232 14.6588 13.9979 14.657C14.1725 14.6552 14.3395 14.5851 14.4631 14.4617C14.5867 14.3382 14.6571 14.1713 14.6591 13.9967C14.6611 13.822 14.5947 13.6535 14.474 13.5272L11.9753 11.0285C12.7976 10.0006 13.293 8.69995 13.293 7.28631C13.293 3.98048 10.5988 1.2876 7.29301 1.2876ZM7.29301 2.62095C9.87824 2.62095 11.9584 4.70108 11.9584 7.28631C11.9584 9.87153 9.87824 11.9569 7.29301 11.9569C4.70778 11.9569 2.62764 9.87153 2.62764 7.28631C2.62764 4.70108 4.70778 2.62095 7.29301 2.62095Z" fill="white"/>
                                    </svg>
                                    <input type="search" placeholder="Search ..." class="show-search" name="search" tabindex="2" value="" aria-required="true" required="">
                                </div>
                                </form>
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
                                                <a href="{{ route('provider.dashboard') }}">Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="{{route('dashboard.my-advertisements')}}">
                                                  My Listings
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('dashboard.create-advertisement')}}">
                                                   Add Listings
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{route('dashboard.profile')}}">
                                                    My Profile
                                                </a>
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
                            <img src="{{ $provider->getFirstMediaUrl('image','thumb') }}" alt="Header Image" style="width: 50px; height: 50px;      border-radius: 50%;  object-fit: cover; ">
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
                        <a href="{{route('dashboard.messages')}}">
                            <img src="{{asset("wizmoto/images/icons/dash6.svg")}}" alt="">Messages
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('provider.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <img src="{{asset("wizmoto/images/icons/dash8.svg")}}" alt="">
                            Logout
                        </a>
                        </li>
                </ul>
            </div>
            @yield('dashboard-content')

        </div>
    </section>
@endsection

