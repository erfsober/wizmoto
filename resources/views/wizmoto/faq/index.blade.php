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
                            <img src="images/logo.svg" alt="" title="Boxcar">
                        </a>
                    </div>
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

<section class="faq-inner-section layout-radius">
    @foreach($faqs as $category => $categoryFaqs)
        <!-- faq-section -->
        <div class="faqs-section {{ $loop->first ? 'pt-0' : '' }}">
            <div class="inner-container">
                <!-- FAQ Column -->
                <div class="faq-column wow fadeInUp" data-wow-delay="400ms">
                    <div class="inner-column">
                        <div class="boxcar-title text-center">
                            <h2 class="title">{{ ucfirst($category) }}</h2>
                        </div>
                        <ul class="widget-accordion wow fadeInUp">
                            @foreach($categoryFaqs as $index => $faq)
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
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End faqs-section -->
    @endforeach
</section>

@include('wizmoto.partials.footer')

@endsection