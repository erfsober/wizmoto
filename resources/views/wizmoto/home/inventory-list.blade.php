@extends('master')
@section('content')

    <div class="boxcar-wrapper">

        <!-- Main Header-->
        <header class="boxcar-header header-style-v1 style-two inner-header bb-0">
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
                                        <input type="search" placeholder="Search Scooters, Motorbikes, Bikes..." class="show-search" name="search" tabindex="2" value="" aria-required="true" required="">
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
                    <span class="fa fa-times"></span>
                </button>

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
                        </li>
                    @endif

                </ul>
            </div>
        </header>
        <!-- End header-section -->

        <section class="inventory-pager style-1">
            <div class="boxcar-container">
                <form class="inventory-form">
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
                    <div class="form_boxes line-r">
                        <div class="drop-menu">
                            <div class="select">
                                <span>Any Price</span>
                                <i class="fa fa-angle-down"></i>
                            </div>
                            <input type="hidden" name="gender">
                            <ul class="dropdown" style="display: none;">
                                <li>200$</li>
                                <li>300$</li>
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
                            <i class="flaticon-search"></i>Search 9451 Ride
                        </button>
                    </div>
                </form>
            </div>
        </section><!--inventory-pager end-->
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
                            <!-- Vehicle Search Group -->
                            <div class="vehicle-search-group" data-group="0">
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                        <label>Brand</label>
                                        <div class="drop-menu" id="brand-dropdown">
                                            <div class="select">
                                                <span>Select Brand</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="brand_id[]" class="brand_id_input">
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
                                                <span>Select Model</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="vehicle_model_id[]" class="vehicle_model_id_input">
                                            <ul class="dropdown" style="display: none;" id="model-select">
        
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form_boxes v2">
                                        <label>Version</label>
                                        <div class="drop-menu active">
                                            <input type="text" name="version_model[]" placeholder="Enter version">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="remove-vehicle-group" title="Remove this vehicle">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                            
                            <!-- Add Vehicle Button - Outside the box -->
                            <div class="col-lg-12">
                                <div class="add-vehicle-group">
                                    <button type="button" class="add-vehicle-btn">
                                        <i class="fa fa-plus"></i>
                                        Add another vehicle
                                    </button>
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
        <!-- cars-section-three -->
        <section class="cars-section-four v1 layout-radius">
            <div class="boxcar-container">
                <div class="boxcar-title-three wow fadeInUp">
                    <ul class="breadcrumb">
                        <li>
                            <a href="{{route("home")}}">Home</a>
                        </li>
                        <li><span>MotorBike for Sale</span>
                        </li>
                    </ul>
                    <h2>New and Used MotorBike For Sale</h2>
                </div>

                <div class="row wow fadeInUp">
                    @foreach($advertisements as $advertisement)
                        @php
                            $image= $advertisement->getMedia('covers')->first();
                        @endphp
                            <!-- car-block-four -->
                        <div class="car-block-four col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image">
                                        <a href="{{ $image?->getUrl('preview') }}" data-fancybox="gallery-{{ $advertisement->id }}">
                                            <img
                                                src="{{ $image?->getUrl('thumb') }}"
                                                srcset="
                   {{ $image?->getUrl('thumb') }} 300w,
                    {{ $image?->getUrl('preview') }} 800w
                "
                                                sizes="(max-width: 600px) 300px, 800px"
                                                loading="lazy"
                                                alt="{{ $advertisement->title ?? 'Advertisement Image' }}">
                                        </a>
                                    </figure>
                                </div>
                                <div class="content-box">
                                    <h6 class="title">
                                        <a href="{{ route('advertisements.show', $advertisement->id) }}">{{$advertisement->brand?->name}}{{' '}}{{$advertisement->vehicleModel?->name}}</a>
                                    </h6>
                                    <div class="text">{{$advertisement->version_model}}</div>
                                    <ul>
                                        <li>
                                            <i class="flaticon-gasoline-pump"></i> {{ $advertisement->fuelType?->name ?? 'N/A' }}
                                        </li>
                                        <li>
                                            <i class="flaticon-speedometer"></i>{{ $advertisement->mileage ? number_format($advertisement->mileage) . ' miles' : 'N/A' }}
                                        </li>
                                        <li>
                                            <i class="flaticon-gearbox"></i> {{ $advertisement->motor_change ?? 'N/A' }}
                                        </li>
                                    </ul>
                                    <div class="btn-box">
                                        <span>${{$advertisement->final_price}}</span>

                                        <a href="{{ route('advertisements.show', $advertisement->id) }}" class="details">View Details
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                <g clip-path="url(#clip0_601_4346)">
                                                    <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="#405FF2"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_601_4346">
                                                        <rect width="14" height="14" fill="white"/>
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

                <div class="pagination-sec">
                    <nav aria-label="Page navigation example">
                        @if ($advertisements->hasPages())
                            <ul class="pagination">
                                <li class="page-item {{ $advertisements->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $advertisements->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.57983 5.99989C2.57983 5.7849 2.66192 5.56987 2.82573 5.4059L7.98559 0.24617C8.31382 -0.0820565 8.84598 -0.0820565 9.17408 0.24617C9.50217 0.574263 9.50217 1.10632 9.17408 1.43457L4.60841 5.99989L9.17376 10.5654C9.50185 10.8935 9.50185 11.4256 9.17376 11.7537C8.84566 12.0821 8.31366 12.0821 7.98544 11.7537L2.82555 6.59404C2.66176 6.42999 2.57983 6.21495 2.57983 5.99989Z" fill="#050B20"/>
                                            </svg>
                                        </span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                @foreach ($advertisements->links()->elements[0] ?? [] as $page => $url)
                                    <li class="page-item {{ $page == $advertisements->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ !$advertisements->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $advertisements->nextPageUrl() }}" aria-label="Next">
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
                                {{ $advertisements->firstItem() }}-{{ $advertisements->lastItem() }}
                                              of {{ $advertisements->total() }}
                            </div>
                        @endif
                    </nav>
                </div>
            </div>
        </section>
        <!-- End shop section two -->


    </div><!-- End Page Wrapper -->

    @include('wizmoto.partials.footer')

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let groupCounter = 0;
    
    // Add new vehicle group
    $(document).on('click', '.add-vehicle-btn', function() {
        groupCounter++;
        const originalGroup = $('.vehicle-search-group').first();
        const newGroup = originalGroup.clone();
        
        // Update group data attribute
        newGroup.attr('data-group', groupCounter);
        
        // Clear form values
        newGroup.find('input[type="hidden"]').val('');
        newGroup.find('input[type="text"]').val('');
        newGroup.find('.select span').text('Select Brand');
        newGroup.find('.model-dropdown .select span').text('Select Model');
        
        // Add remove button for all groups
        newGroup.append(`
            <button type="button" class="remove-vehicle-group" title="Remove this vehicle">
                <i class="fa fa-times"></i>
            </button>
        `);
        
        // Update background for additional groups
        newGroup.css({
            'background': '#f9f9f9',
            'border': '1px solid #e0e0e0'
        });
        
        // Insert before the "Add another vehicle" button
        $('.add-vehicle-group').parent().before(newGroup);
        
        // Initialize dropdown functionality for new group
        initializeDropdowns(newGroup);
    });
    
    // Remove vehicle group
    $(document).on('click', '.remove-vehicle-group', function() {
        $(this).closest('.vehicle-search-group').fadeOut(300, function() {
            $(this).remove();
        });
    });
    
    // Initialize dropdown functionality
    function initializeDropdowns(container) {
        // Brand dropdown click handler
        container.find('#brand-dropdown').on('click', function(e) {
            e.stopPropagation();
            const $dropdown = $(this).find('.dropdown');
            
            // Close other dropdowns
            $('.dropdown').not($dropdown).hide();
            
            $dropdown.toggle();
        });
        
        // Brand selection handler
        container.find('#brand-dropdown .dropdown').on('click', 'li', function(e) {
            e.stopPropagation();
            const brandId = $(this).data('id');
            const brandName = $(this).text();
            
            $(this).closest('#brand-dropdown').find('.select span').text(brandName);
            $(this).closest('#brand-dropdown').find('input[type="hidden"]').val(brandId);
            $(this).closest('.dropdown').hide();
            
            // Load models for selected brand
            loadModels(container, brandId);
        });
        
        // Model dropdown click handler
        container.find('#model-dropdown').on('click', function(e) {
            e.stopPropagation();
            const $dropdown = $(this).find('.dropdown');
            
            // Close other dropdowns
            $('.dropdown').not($dropdown).hide();
            
            $dropdown.toggle();
        });
        
        // Model selection handler
        container.find('#model-dropdown .dropdown').on('click', 'li', function(e) {
            e.stopPropagation();
            const modelId = $(this).data('id');
            const modelName = $(this).text();
            
            $(this).closest('#model-dropdown').find('.select span').text(modelName);
            $(this).closest('#model-dropdown').find('input[type="hidden"]').val(modelId);
            $(this).closest('.dropdown').hide();
        });
    }
    
    // Load models for selected brand
    function loadModels(container, brandId) {
        const $modelDropdown = container.find('#model-dropdown .dropdown');
        const $modelSelect = container.find('#model-dropdown .select span');
        const $modelInput = container.find('.vehicle_model_id_input');
        
        // Reset model selection
        $modelSelect.text('Select Model');
        $modelInput.val('');
        $modelDropdown.empty();
        
        // Show loading
        $modelSelect.text('Loading...');
        $modelDropdown.html('<li>Loading models...</li>');
        
        // Use the same route as create advertisement page
        let url = "{{ route('vehicle-models.get-models-based-on-brand', ':brandId') }}";
        url = url.replace(':brandId', brandId);
        
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(models) {
                $modelDropdown.empty();
                
                if (Object.keys(models).length === 0) {
                    $modelDropdown.append('<li>No models available</li>');
                } else {
                    // The response is an object with id as key and name as value
                    $.each(models, function(modelId, modelName) {
                        $modelDropdown.append('<li data-id="' + modelId + '">' + modelName + '</li>');
                    });
                }
                $modelSelect.text('Select Model');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching models:', error);
                $modelDropdown.html('<li>Error loading models</li>');
                $modelSelect.text('Select Model');
            }
        });
    }
    
    // Close dropdowns when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.drop-menu').length) {
            $('.dropdown').hide();
        }
    });
    
    // Initialize first group
    initializeDropdowns($('.vehicle-search-group').first());
});
</script>
@endpush
