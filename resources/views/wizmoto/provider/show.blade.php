﻿@extends('master')
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
                            <a href="{{ route('dashboard.create-advertisement') }}" class="header-btn-two btn-anim">Add
                                Listing</a>
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

        <div id="nav-mobile"></div>
    </header>
    <!-- End header-section -->

    <!-- dealership-section -->
    <section class="dealer-ship-section-two layout-radius">
        <div class="barnd-box">
            <div class="boxcar-container">
                <div class="boxcar-title-three">
                    <ul class="breadcrumb">
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li><span>Seller</span></li>
                    </ul>
                    <h2>{{ $provider->full_name }}</h2>
                </div>
                <div class="row">
                    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="brand-box">
                                <div class="image-box pb-5">
                                    <img src="{{ $provider->getFirstMediaUrl('image', 'thumb') }}"
                                        alt="{{ $provider->name }}">
                                </div>
                                @if ($provider->show_info_in_advertisement)
                                    <div class="content-box">
                                        <h3 class="title pb-5">
                                            {{ $provider->title ?? $provider->first_name . ' ' . $provider->last_name }}
                                        </h3>
                                        <ul class="contact-list">
                                            @if ($provider->address || $provider->city || $provider->zip_code)
                                                <li>
                                                    <span class="icon">
                                                        <svg width="26" height="26" viewBox="0 0 26 26"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M12.9997 4.0625C8.67846 4.0625 5.14551 7.64734 5.14551 12.1068C5.14551 14.3555 6.04492 16.8458 7.51665 18.7689C8.99219 20.697 10.9451 21.9375 12.9997 21.9375C15.0542 21.9375 17.0071 20.697 18.4827 18.7689C19.9545 16.8458 20.8538 14.3555 20.8538 12.1068C20.8538 7.64734 17.3209 4.0625 12.9997 4.0625ZM3.52051 12.1068C3.52051 6.78329 7.74795 2.4375 12.9997 2.4375C18.2514 2.4375 22.4788 6.78329 22.4788 12.1068C22.4788 14.7496 21.4382 17.5809 19.7732 19.7564C18.112 21.9271 15.7316 23.5625 12.9997 23.5625C10.2677 23.5625 7.88736 21.9271 6.22618 19.7564C4.56119 17.5809 3.52051 14.7496 3.52051 12.1068Z"
                                                                fill="#050B20"></path>
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M9.47852 11.375C9.47852 9.43051 11.0549 7.85419 12.9993 7.85419C14.9438 7.85419 16.5202 9.43051 16.5202 11.375C16.5202 13.3195 14.9438 14.8959 12.9993 14.8959C11.0549 14.8959 9.47852 13.3195 9.47852 11.375ZM12.9993 9.47919C11.9523 9.47919 11.1035 10.328 11.1035 11.375C11.1035 12.4221 11.9523 13.2709 12.9993 13.2709C14.0464 13.2709 14.8952 12.4221 14.8952 11.375C14.8952 10.328 14.0464 9.47919 12.9993 9.47919Z"
                                                                fill="#E1E1E1"></path>
                                                        </svg>
                                                    </span>
                                                    {{ $provider->address ?? '' }}
                                                    {{ $provider->village ? ', ' . $provider->village : '' }}
                                                    {{ $provider->city ? ', ' . $provider->city : '' }}
                                                    {{ $provider->zip_code ?? '' }}
                                                </li>
                                            @endif
                                            @if ($provider->email && $provider->email_verified_at)
                                                <li>
                                                    <!-- <i class="fa-solid fa-envelope"></i> -->
                                                    <span class="icon">
                                                        <svg width="26" height="26" viewBox="0 0 26 26"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M12.7584 14.5869C12.0336 14.5869 11.3111 14.3474 10.7065 13.8686L5.84779 9.95128C5.49787 9.66962 5.44371 9.1572 5.72429 8.80837C6.00704 8.46062 6.51837 8.40537 6.86721 8.68595L11.7216 12.5989C12.3316 13.0821 13.1906 13.0821 13.8049 12.5946L18.6106 8.68812C18.9594 8.4032 19.4707 8.45737 19.7546 8.8062C20.0373 9.15395 19.9842 9.66528 19.6365 9.94912L14.8221 13.8621C14.2133 14.3453 13.4853 14.5869 12.7584 14.5869Z"
                                                                fill="#E1E1E1" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M18.0469 21.6667C18.0491 21.6645 18.0578 21.6667 18.0643 21.6667C19.3003 21.6667 20.3967 21.2247 21.2373 20.3851C22.2134 19.4134 22.7497 18.0169 22.7497 16.4537V9.01335C22.7497 5.9876 20.7715 3.79169 18.0469 3.79169H7.41076C4.68617 3.79169 2.70801 5.9876 2.70801 9.01335V16.4537C2.70801 18.0169 3.24534 19.4134 4.22034 20.3851C5.06101 21.2247 6.15842 21.6667 7.39342 21.6667H18.0469ZM7.39017 23.2917C5.71859 23.2917 4.22576 22.685 3.07309 21.5367C1.78934 20.2562 1.08301 18.4514 1.08301 16.4537V9.01335C1.08301 5.1101 3.80326 2.16669 7.41076 2.16669H18.0469C21.6544 2.16669 24.3747 5.1101 24.3747 9.01335V16.4537C24.3747 18.4514 23.6683 20.2562 22.3846 21.5367C21.233 22.6839 19.7391 23.2917 18.0643 23.2917H7.39017Z"
                                                                fill="#050B20" />
                                                        </svg>

                                                    </span>
                                                    {{ $provider->email }}
                                                </li>
                                            @endif
                                            @if ($provider->phone)
                                                <li>
                                                    <!-- <i class="fa-solid fa-phone"></i> -->
                                                    <span class="icon">
                                                        <svg width="26" height="26" viewBox="0 0 26 26"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M23.5121 10.9886C23.1037 10.9886 22.7527 10.6821 22.7061 10.2671C22.2944 6.6098 19.4528 3.77147 15.7955 3.36522C15.3502 3.31538 15.0285 2.91455 15.0783 2.46822C15.1271 2.02297 15.5268 1.69038 15.9753 1.75105C20.3921 2.24072 23.8241 5.66838 24.3202 10.0851C24.3712 10.5315 24.0494 10.9333 23.6042 10.9832C23.5738 10.9864 23.5424 10.9886 23.5121 10.9886Z"
                                                                fill="#E1E1E1" />
                                                            <path
                                                                d="M19.6762 11.0003C19.2949 11.0003 18.9558 10.7316 18.88 10.3438C18.568 8.74044 17.3319 7.50435 15.7307 7.19344C15.2898 7.10785 15.0027 6.6821 15.0883 6.24119C15.1739 5.80027 15.6105 5.51319 16.0406 5.59877C18.295 6.03644 20.0359 7.77627 20.4747 10.0318C20.5602 10.4738 20.2732 10.8995 19.8333 10.9851C19.7803 10.9949 19.7283 11.0003 19.6762 11.0003Z"
                                                                fill="#E1E1E1" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M8.1053 17.8102C13.2111 22.917 16.6106 24.256 18.7578 24.256C19.8173 24.256 20.5734 23.9299 21.0772 23.5681C21.0999 23.5551 23.4313 22.1294 23.8397 19.9714C24.0325 18.9585 23.7509 17.9564 23.0272 17.0724C20.0459 13.453 18.527 13.791 16.85 14.6068C15.8198 15.1116 15.0062 15.5038 12.7084 13.2082C10.412 10.9108 10.8081 10.0971 11.3096 9.067C12.1265 7.39 12.4625 5.8708 8.84197 2.8873C7.96013 2.16689 6.96455 1.88522 5.95272 2.0748C3.82613 2.47239 2.39397 4.7658 2.39397 4.7658C1.2543 6.36589 0.480802 10.1868 8.1053 17.8102ZM6.28422 3.66514C6.37955 3.64997 6.4738 3.6413 6.56697 3.6413C6.99163 3.6413 7.40113 3.80705 7.80955 4.14289C10.7291 6.54786 10.3597 7.30621 9.84839 8.35595C9.08031 9.93437 8.67838 11.4749 11.559 14.3576C14.4429 17.2404 15.9844 16.8384 17.5607 16.0682L17.5633 16.0669C18.6117 15.5573 19.3697 15.1888 21.7716 18.1049C22.1822 18.6054 22.3393 19.1059 22.2504 19.6334C22.0457 20.8468 20.6352 21.9334 20.2084 22.1977C18.6798 23.2875 14.9997 22.4068 9.25363 16.6619C3.5098 10.9169 2.62797 7.23689 3.7568 5.6498C3.98213 5.28255 5.07305 3.86989 6.28422 3.66514Z"
                                                                fill="#050B20" />
                                                        </svg>

                                                    </span>
                                                    {{ $provider->phone }}
                                                </li>
                                            @endif
                                        </ul>

                                    </div>
                                @endif
                            </div>
                            <div class="location-box">
                                <h4 class="title">Location</h4>
                                <div class="text">
                                    {{-- Show full address --}}
                                    {{ $provider->address ?? '' }}
                                    {{ $provider->village ? ', ' . $provider->village : '' }}
                                    {{ $provider->city ? ', ' . $provider->city : '' }}
                                    {{ $provider->zip_code ?? '' }}
                                </div>
                                <a target="_blank"
                                    href="https://www.google.com/maps/search/?api=1&query={{ urlencode($provider->address . ' ' . $provider->city . ' ' . $provider->zip_code) }}"
                                    class="brand-btn">Get Directions
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
                                <div class="goole-iframe">
                                    <iframe
                                        src="https://maps.google.com/maps?width=100%25&height=600&hl=en&q={{ urlencode($provider->address . ' ' . $provider->city . ' ' . $provider->zip_code) }}&t=&z=14&ie=UTF8&iwloc=B&output=embed"
                                        width="100%" height="300" style="border:0;" allowfullscreen=""
                                        loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            </div>

                            @if ($provider->reviews->count() !== 0)
                                <div class="reviews">
                                    <h4 class="title">Customer Reviews</h4>
                                    @foreach ($provider->reviews as $review)
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
                                                            <i
                                                                class="fa fa-star {{ $i <= $review->stars ? '' : 'gray' }}"></i>
                                                        </li>
                                                    @endfor

                                                </ul>
                                            </div>
                                            <div class="text">{{ $review->comment }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <form class="row" action="{{ route('reviews.store') }}" method="POST">
                                <div class="Reply-sec">
                                    <h6 class="title">Leave a Reply</h6>
                                    <div class="text">Your email address will not be published. Required fields are
                                        marked *</div>
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
                                <input type="hidden" name="type" value="provider">
                                <input type="hidden" name="id" value="{{ $provider->id }}">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewbox="0 0 14 14" fill="none">
                                                <g clip-path="url(#clip0_711_3214)">
                                                    <path
                                                        d="M13.6106 0H5.05509C4.84013 0 4.66619 0.173943 4.66619 0.388901C4.66619 0.603859 4.84013 0.777802 5.05509 0.777802H12.6719L0.113453 13.3362C-0.0384687 13.4881 -0.0384687 13.7342 0.113453 13.8861C0.189396 13.962 0.288927 14 0.388422 14C0.487917 14 0.587411 13.962 0.663391 13.8861L13.2218 1.3277V8.94447C13.2218 9.15943 13.3957 9.33337 13.6107 9.33337C13.8256 9.33337 13.9996 9.15943 13.9996 8.94447V0.388901C13.9995 0.173943 13.8256 0 13.6106 0Z"
                                                        fill="white"></path>
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
                    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12">
                        <div class="side-bar">
                            <a href="#" id="initiate-chat-btn" class="message" data-bs-toggle="modal"
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- cars-section-three -->
            <div class="cars-section-three">
                <div class="boxcar-container">
                    <nav class="wow fadeInUp" data-wow-delay="100ms">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true">Products</button>
                        </div>
                    </nav>
                    <div class="tab-content wow fadeInUp" data-wow-delay="200ms" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="row car-slider-three" data-preview="4">
                                @foreach ($advertisements as $advertisement)
                                    @php
                                        $image = $advertisement->getMedia('covers')->first();
                                    @endphp
                                    <!-- car-block-four -->
                                    <div
                                        class="car-block-three col-lg-3 col-md-6 col-sm-12 slick-slide slick-current slick-active">
                                        <div class="inner-box">
                                            <div class="image-box">
                                                <figure class="image">
                                                    <a href="{{ $image?->getUrl('preview') }}"
                                                        data-fancybox="gallery-{{ $advertisement->id }}">
                                                        <img src="{{ $image?->getUrl('thumb') }}"
                                                            srcset="
                   {{ $image?->getUrl('thumb') }} 300w,
                    {{ $image?->getUrl('preview') }} 800w
                "
                                                            sizes="(max-width: 600px) 300px, 800px" loading="lazy"
                                                            alt="{{ $advertisement->title ?? 'Advertisement Image' }}">
                                                    </a>
                                                </figure>
                                            </div>
                                            <div class="content-box">
                                                <h6 class="title">
                                                    <a
                                                        href="{{ route('advertisements.show', $advertisement->id) }}">{{ $advertisement->brand?->name }}{{ ' ' }}{{ $advertisement->vehicleModel?->name }}</a>
                                                </h6>
                                                <div class="text">{{ $advertisement->version_model }}</div>
                                                <ul>
                                                    <li>
                                                        <i class="flaticon-gasoline-pump"></i>
                                                        {{ $advertisement->fuelType?->name ?? 'N/A' }}
                                                    </li>
                                                    <li>
                                                        <i
                                                            class="flaticon-speedometer"></i>{{ $advertisement->mileage ? number_format($advertisement->mileage) . ' miles' : 'N/A' }}
                                                    </li>
                                                    <li>
                                                        <i class="flaticon-gearbox"></i>
                                                        {{ $advertisement->motor_change ?? 'N/A' }}
                                                    </li>
                                                </ul>
                                                <div class="btn-box">
                                                    <span>€{{ $advertisement->final_price }}</span>

                                                    <a href="{{ route('advertisements.show', $advertisement->id) }}"
                                                        class="details">View Details
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" viewBox="0 0 14 14" fill="none">
                                                            <g clip-path="url(#clip0_601_4346)">
                                                                <path
                                                                    d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z"
                                                                    fill="#405FF2" />
                                                            </g>
                                                            <defs>
                                                                <clipPath id="clip0_601_4346">
                                                                    <rect width="14" height="14" fill="white" />
                                                                </clipPath>
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
                </div>
            </div>
            <!-- End shop section two -->
        </div>
    </section>
    <!-- End dealership-section -->

    <!-- Contact Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">💬 Contact {{ $provider->full_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="contact-form" class="inventroy-widget">
                        <p class="text-muted mb-4">Send a message to inquire about this dealer. Your email will be kept
                            private.</p>

                        <form id="initiate-contact-form" method="POST" action="{{ route('chat.initiate') }}">
                            @csrf
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
                            <p class="mb-3">Your message has been sent to {{ $provider->full_name }}.</p>
                            <div class="alert alert-success">
                                <strong>Your conversation link:</strong><br>
                                <span id="conversation-link" class="text-break"></span>
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
        .rating-list .list li i.gray {
            color: #ccc;
            /* gray for empty stars */
        }

        .Reply-sec .list li i {
            color: #ccc;
            /* default gray */
            cursor: pointer;
        }

        .Reply-sec .list li.hovered i,
        .list li.selected i {
            color: #ffb400;
            /* gold for hover/selected */
        }
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
                            const providerId = {{ $provider->id }};

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
                                                $('#conversation-link').text(response.conversation_link);

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

                        // Pre-fill email if previously used
                        const savedEmail = localStorage.getItem('guest_email_' + {{ $provider->id }});
                        if (savedEmail) {
                            $('#guest-email').val(savedEmail);
                        }
                    });
    </script>
@endpush
