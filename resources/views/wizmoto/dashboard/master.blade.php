@extends('master')
@section('body-class', 'body dashboard-page')
@section('main-div', 'v2')
@section('content')
    <header class="boxcar-header header-style-ten">
        <div class="header-inner">
            <div class="inner-container">
                <!-- Main box -->
                <div class="c-box">
                    <div class="logo-inner">
                        <div class="logo">
                            <a href="{{ route("home") }}">
                                <img src="{{asset("wizmoto/images/logo.png")}}" alt="" title="Wizmoto">
                            </a>
                        </div>
                        <div class="btn-box">
                            @include('wizmoto.partials.live-search', ['class' => 'style1'])
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
                                                   Sell
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
                            @if($provider->getFirstMediaUrl('image','thumb'))
                                <img src="{{ $provider->getFirstMediaUrl('image','thumb') }}" alt="Header Image" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="#666"/>
                                        <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z" fill="#666"/>
                                    </svg>
                                </div>
                            @endif
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

        @include('wizmoto.partials.mobile-menu')
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
                            <img src="{{asset("wizmoto/images/icons/dash3.svg")}}" alt="">Sell
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

