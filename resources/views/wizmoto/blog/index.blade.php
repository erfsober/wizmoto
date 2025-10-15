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
                        <a href="{{ route("home") }}">
                            <img src="{{asset("wizmoto/images/logo.png")}}" alt="" title="Boxcar">
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
                        <a href="{{route("dashboard.create-advertisement")}}" class="header-btn-two btn-anim">Sell</a>
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

    @include('wizmoto.partials.mobile-menu')
</header>
<!-- End header-section -->

<!-- blog section -->
<section class="blog-section v1 layout-radius">
    <div class="boxcar-container">
        <div class="boxcar-title wow fadeInUp">
            <ul class="breadcrumb">
                <li><a href="{{route('home')}}">Home</a></li>
                <li><span>Blogs</span></li>
            </ul>
            <h2>Blog List</h2>
        </div>
        <nav class="wow fadeInUp" data-wow-delay="100ms">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Blogs</button>
          </div>
        </nav>
        <div class="tab-content wow fadeInUp" data-wow-delay="200ms" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row">
                    @foreach($blogPosts as $blog)
                    <!-- blog-block -->
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
                                </h6>   </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="pagination-sec">
            <nav aria-label="Page navigation example">
                @if ($blogPosts->hasPages())
                    <ul class="pagination">
                        <li class="page-item {{ $blogPosts->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $blogPosts->previousPageUrl() }}" aria-label="Previous">
                                <span aria-hidden="true">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.57983 5.99989C2.57983 5.7849 2.66192 5.56987 2.82573 5.4059L7.98559 0.24617C8.31382 -0.0820565 8.84598 -0.0820565 9.17408 0.24617C9.50217 0.574263 9.50217 1.10632 9.17408 1.43457L4.60841 5.99989L9.17376 10.5654C9.50185 10.8935 9.50185 11.4256 9.17376 11.7537C8.84566 12.0821 8.31366 12.0821 7.98544 11.7537L2.82555 6.59404C2.66176 6.42999 2.57983 6.21495 2.57983 5.99989Z" fill="#050B20"/>
                                    </svg>
                                </span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        @foreach ($blogPosts->links()->elements[0] ?? [] as $page => $url)
                            <li class="page-item {{ $page == $blogPosts->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$blogPosts->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $blogPosts->nextPageUrl() }}" aria-label="Next">
                                <span aria-hidden="true">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_2880_6407)">
                                            <path d="M9.42017 6.00011C9.42017 6.2151 9.33808 6.43013 9.17427 6.5941L4.01441 11.7538C3.68618 12.0821 3.15402 12.0821 2.82592 11.7538C2.49783 11.4257 2.49783 10.8937 2.82592 10.5654L7.39159 6.00011L2.82624 1.43461C2.49815 1.10652 2.49815 0.574382 2.82624 0.246315C3.15434 -0.0820709 3.68634 -0.0820709 4.01457 0.246315L9.17446 5.40596C9.33824 5.57001 9.42017 5.78505 9.42017 6.00011Z" fill="#050B20"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2880_6407">
                                                <rect width="12" height="12" fill="white" transform="translate(12 12) rotate(-180)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                    <div class="text">Showing results
                        {{ $blogPosts->firstItem() }}-{{ $blogPosts->lastItem() }}
                                      of {{ $blogPosts->total() }}
                    </div>
                @endif
            </nav>
        </div>
    </div>
</section>


@include('wizmoto.partials.footer')

@endsection
