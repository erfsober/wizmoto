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
                        <!-- Main Menu -->
                        <nav class="main-menu navbar-expand-lg">
                            <div class="navbar-header">
                                <!-- Toggle Button -->      
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="navbar-collapse collapse clearfix">
                                <ul class="navigation clearfix">
                                    <li><a href="{{ route('home') }}">Home</a></li>
                                  
                                </ul>
                            </div>
                        </nav>
                        <!-- Main Menu End-->
                    </div>

                    <div class="right-box">
                        @if(auth('provider')->check())
                            <a href="{{ route('dashboard.my-advertisements') }}" title="" class="box-account"> 
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
                                <span>Dashboard</span>
                            </a>
                        @else
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
                                <span>Account</span>
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

    <!-- cars-section-three -->
    <section class="cars-section-thirteen layout-radius">
        <div class="boxcar-container">
            <div class="boxcar-title-three wow fadeInUp">
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><span>Filtered List</span></li>
                </ul>
                <h2>What Kind of Motorcycle Should I Get?</h2>
                
                <!-- Selected Filters Bar -->
                <div class="selected-filters-bar" id="selected-filters-bar" style="display: none;">
                    <div class="selected-filters-container">
                        <div class="selected-filters-label">
                            <i class="fa fa-filter"></i>
                            <span>Active Filters:</span>
                        </div>
                        <div class="selected-filters-list" id="selected-filters-list">
                            <!-- Selected filters will be dynamically added here -->
                        </div>
                        <div class="selected-filters-actions">
                            <button type="button" class="clear-all-filters-btn">
                                <i class="fa fa-times"></i> Clear All
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="quick-filters-container">
                <ul class="service-list">
                 
                </ul>
                </div>
            </div>
            <div class="row">
                <div class="wrap-sidebar-dk side-bar col-xl-3 col-md-12 col-sm-12">
                    <div class="sidebar-handle">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.75 4.50903C13.9446 4.50903 12.4263 5.80309 12.0762 7.50903H2.25C1.83579 7.50903 1.5 7.84482 1.5 8.25903C1.5 8.67324 1.83579 9.00903 2.25 9.00903H12.0762C12.4263 10.715 13.9446 12.009 15.75 12.009C17.5554 12.009 19.0737 10.715 19.4238 9.00903H21.75C22.1642 9.00903 22.5 8.67324 22.5 8.25903C22.5 7.84482 22.1642 7.50903 21.75 7.50903H19.4238C19.0737 5.80309 17.5554 4.50903 15.75 4.50903ZM15.75 6.00903C17.0015 6.00903 18 7.00753 18 8.25903C18 9.51054 17.0015 10.509 15.75 10.509C14.4985 10.509 13.5 9.51054 13.5 8.25903C13.5 7.00753 14.4985 6.00903 15.75 6.00903Z" fill="#050B20"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.25 12.009C6.44461 12.009 4.92634 13.3031 4.57617 15.009H2.25C1.83579 15.009 1.5 15.3448 1.5 15.759C1.5 16.1732 1.83579 16.509 2.25 16.509H4.57617C4.92634 18.215 6.44461 19.509 8.25 19.509C10.0554 19.509 11.5737 18.215 11.9238 16.509H21.75C22.1642 16.509 22.5 16.1732 22.5 15.759C22.5 15.3448 22.1642 15.009 21.75 15.009H11.9238C11.5737 13.3031 10.0554 12.009 8.25 12.009ZM8.25 13.509C9.5015 13.509 10.5 14.5075 10.5 15.759C10.5 17.0105 9.5015 18.009 8.25 18.009C6.9985 18.009 6 17.0105 6 15.759C6 14.5075 6.9985 13.509 8.25 13.509Z" fill="#050B20"/>
                        </svg>
                        Show Filter 
                    </div>
                    <div class="inventory-sidebar">
                        <div class="inventroy-widget widget-location">
                            <div class="row">
                                <!-- Main Data & Location Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">Main Data & Location</h6>
                                    </div>
                                    <div class="filter-section-content">
                                        <div class="row">
                                            <!-- Vehicle Search Group -->
                                            <div class="vehicle-search-group" data-group="0">
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                        <label>Vehicle Category</label>
                                        <div class="drop-menu" id="advertisement-type-dropdown">
                                            <div class="select">
                                                <span>Select Category</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="advertisement_type" class="advertisement_type_input">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach ($advertisementTypes as $type)
                                                    <li data-id="{{ $type->id }}">{{ $type->title }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
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
                                                                @foreach ($brands as $brand)
                                                                    <li data-id="{{ $brand->id }}">{{ $brand->name }}
                                                                    </li>
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
                                                            <input type="hidden" name="vehicle_model_id[]"
                                                                class="vehicle_model_id_input">
                                                            <ul class="dropdown" style="display: none;" id="model-select">
    
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form_boxes v2">
                                                        <label>Version</label>
                                                        <div class="drop-menu active">
                                                            <input type="text" name="version_model[]"
                                                                placeholder="Enter version">
                                            </div>
                                        </div>
                                    </div>
                                                <button type="button" class="remove-vehicle-group"
                                                    title="Remove this vehicle">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                </div>
    
                                            <!-- Add Vehicle Button - Outside the box -->
                                            <div class="col-lg-12 mb-5">
                                                <div class="add-vehicle-group">
                                                    <button type="button" class="add-vehicle-btn">
                                                        <i class="fa fa-plus"></i>
                                                        Add another vehicle
                                                    </button>
                                                </div>
                                            </div>
    
                                            <!-- Body Work -->
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                                    <label>Body Work</label>
                                                    <div class="drop-menu" id="body-dropdown">
                                            <div class="select">
                                                            <span>Select Body Work</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="vehicle_body_id">
                                            <ul class="dropdown" style="display: none;">
                                                            @foreach ($vehicleBodies as $vehicleBody)
                                                                <li data-id="{{ $vehicleBody->id }}">{{ $vehicleBody->name }}
                                                                </li>
                                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
    
                                            <!-- Fuel Type -->
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                                    <label>Fuel Type</label>
                                                    <div class="drop-menu" id="fuel-dropdown">
                                            <div class="select">
                                                            <span>Select</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="fuel_type_id">
                                            <ul class="dropdown" style="display: none;">
                                                            @foreach ($fuelTypes as $fuelType)
                                                                <li data-id="{{ $fuelType->id }}">{{ $fuelType->name }}</li>
                                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
    
                                            <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>Register Year</label>
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
                                                            @for ($y = $currentYear; $y >= 1990; $y--)
                                                                <li data-id="{{ $y }}">{{ $y }}</li>
                                                            @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>Register Year</label>
                                                    <div class="drop-menu" id="registration-year-to-dropdown">
                                            <div class="select">
                                                            <span>To</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="registration_year_to">
                                            <ul class="dropdown" style="display: none;">
                                                            @php
                                                                $currentYear = date('Y');
                                                            @endphp
                                                            @for ($y = $currentYear; $y >= 1990; $y--)
                                                                <li data-id="{{ $y }}">{{ $y }}</li>
                                                            @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
    
                                            <!-- Mileage -->
                                            <div class="col-lg-6">
                                                <div class="form_boxes v2">
                                                    <label>Mileage From</label>
                                                    <div class="drop-menu active">
                                                        <input type="text" name="mileage_from" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form_boxes v2">
                                                    <label>Mileage To</label>
                                                    <div class="drop-menu active">
                                                        <input type="text" name="mileage_to" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
    
                                            <!-- Power -->
                                <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>Power(CV)</label>
                                                    <div class="drop-menu" id="power-cv-from-dropdown">
                                            <div class="select">
                                                            <span>From</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="power_cv_from">
                                            <ul class="dropdown" style="display: none;">
                                                            @for ($cv = 10; $cv <= 500; $cv += 10)
                                                                <li data-id="{{ $cv }}">{{ $cv }} CV</li>
                                                            @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                            <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>Power(CV)</label>
                                                    <div class="drop-menu" id="power-cv-to-dropdown">
                                            <div class="select">
                                                            <span>To</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="power_cv_to">
                                            <ul class="dropdown" style="display: none;">
                                                            @for ($cv = 10; $cv <= 500; $cv += 10)
                                                                <li data-id="{{ $cv }}">{{ $cv }} CV</li>
                                                            @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
    
                                            <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>Power(KW)</label>
                                                    <div class="drop-menu" id="power-kw-from-dropdown">
                                            <div class="select">
                                                            <span>From</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="power_kw_from">
                                            <ul class="dropdown" style="display: none;">
                                                            @for ($kw = 5; $kw <= 400; $kw += 5)
                                                                <li data-id="{{ $kw }}">{{ $kw }} KW</li>
                                                            @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>Power(KW)</label>
                                                    <div class="drop-menu" id="power-kw-to-dropdown">
                                                        <div class="select">
                                                            <span>To</span>
                                                            <i class="fa fa-angle-down"></i>
                                                    </div>
                                                        <input type="hidden" name="power_kw_to">
                                                        <ul class="dropdown" style="display: none;">
                                                            @for ($kw = 5; $kw <= 400; $kw += 5)
                                                                <li data-id="{{ $kw }}">{{ $kw }} KW</li>
                                                            @endfor
                                                        </ul>
                                                </div>
                                            </div>
                                                    </div>
    
                                            <!-- Transmission (Multi-select) -->
                                <div class="col-lg-12">
                                                <div class="form_boxes">
                                                    <label>Transmission</label>
                                                    <div class="multi-select-container">
                                                        <div class="selected-options">
                                                            <!-- Selected options will appear here -->
                                                        </div>
                                                        <div class="multi-select-dropdown">
                                                            <div class="multi-select-list">
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="motor_change[]"
                                                                        value="Manual">
                                                <span class="checkmark"></span>
                                                                    Manual
                                            </label>
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="motor_change[]"
                                                                        value="Automatic">
                                                <span class="checkmark"></span>
                                                                    Automatic
                                            </label>
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="motor_change[]"
                                                                        value="Semi-automatic">
                                                <span class="checkmark"></span>
                                                                    Semi-automatic
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                        </div>
                                    </div>
    
                                            <!-- Number of Cylinders -->
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                                    <label>Number of Cylinders</label>
                                                    <div class="drop-menu" id="cylinders-dropdown">
                                            <div class="select">
                                                            <span>Select Cylinders</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="cylinders">
                                            <ul class="dropdown" style="display: none;">
                                                            <li data-id="1">1 Cylinder</li>
                                                            <li data-id="2">2 Cylinders</li>
                                                            <li data-id="3">3 Cylinders</li>
                                                            <li data-id="4">4 Cylinders</li>
                                                            <li data-id="6">6 Cylinders</li>
                                                            <li data-id="8">8 Cylinders</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
    
                                            <!-- Engine Displacement Range -->
                                            <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>Displacement From (cc)</label>
                                                    <input type="text" name="motor_displacement_from" placeholder="">
                                            </div>
                                        </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>Displacement To (cc)</label>
                                                    <input type="text" name="motor_displacement_to" placeholder="">
                                    </div>
                                </div>
    
                                            <!-- Price Range -->
                                            <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>Price From ($)</label>
                                                    <input type="text" name="price_from" placeholder="">
                                            </div>
                                        </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>Price To ($)</label>
                                                    <input type="text" name="price_to" placeholder="">
                                    </div>
                                </div>
    
                                            <!-- Vehicle Conditions -->
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                                    <label>Vehicle Conditions</label>
                                                    <div class="multi-select-container">
                                                        <div class="selected-options">
                                                            <!-- Selected options will appear here -->
                                            </div>
                                                        <div class="multi-select-dropdown">
                                                            <div class="multi-select-list">
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="vehicle_category[]"
                                                                        value="Used">
                                                <span class="checkmark"></span>
                                                                    Used
                                            </label>
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="vehicle_category[]"
                                                                        value="Era">
                                                <span class="checkmark"></span>
                                                                    Era
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                                            <!-- Village/City -->
                                            <div class="col-lg-12">
                                                <div class="form_boxes">
                                                    <label>Village/City</label>
                                                    <div class="drop-menu" id="city-dropdown">
                                        <div class="select">
                                                            <span>Select City</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                                        <input type="hidden" name="city_id">
                                        <ul class="dropdown" style="display: none;">
                                                            <li data-id="1">New York</li>
                                                            <li data-id="2">Los Angeles</li>
                                                            <li data-id="3">Chicago</li>
                                                            <li data-id="4">Houston</li>
                                                            <li data-id="5">Phoenix</li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
    
                                            <!-- Postal Code -->
                                            <div class="col-lg-12">
                                                <div class="form_boxes v2">
                                                    <label>Postal Code</label>
                                                    <div class="drop-menu active">
                                                        <input type="text" name="postal_code" placeholder="">
                                </div>
                                                </div>
                                            </div>
    
                                            <!-- Radius -->
                                            <div class="col-lg-12">
                                                <div class="form_boxes v2">
                                                    <label>Search Radius (km)</label>
                                                    <div class="drop-menu active">
                                                        <input type="text" name="search_radius" placeholder="">
                                                </div>
                                            </div>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                            
                                <!-- Equipment Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">Equipment</h6>
                                    </div>
                                    <div class="filter-section-content">
                                        <div class="col-lg-12">
                                            <div class="equipment-container">
                                                <div class="equipment-list" id="equipment-list">
                                                    @foreach ($equipments->take(10) as $equipment)
                                                        <label class="equipment-item">
                                                            <input type="checkbox" name="equipments[]"
                                                                value="{{ $equipment->id }}">
                                                            <span class="checkmark"></span>
                                                            {{ $equipment->name }}
                                                        </label>
                                                    @endforeach
                                </div>
                                                @if ($equipments->count() > 10)
                                                    <div class="equipment-toggle">
                                                        <button type="button" class="btn btn-outline-primary show-more-equipment" 
                                                                data-loaded="10" data-total="{{ $equipments->count() }}">
                                                            <i class="fa fa-plus"></i>
                                                            Show more equipment ({{ $equipments->count() - 10 }} more)
                                                        </button>
                            </div>
                                                @endif
                        </div>
                                </div>
                                                </div>
                                            </div>
    
                                <!-- Exteriors Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">Exteriors</h6>
                                                </div>
                                    <div class="filter-section-content">
                                        <div class="col-lg-12">
                                            <div class="form_boxes">
                                                <label>Body Color</label>
                                                <div class="color-list">
                                                    @foreach ($vehicleColors as $color)
                                                        <label class="checkbox-item"
                                                            style="--box-color: {{ $color->hex_code }}">
                                                            <input type="checkbox" name="color_ids[]"
                                                                value="{{ $color->id }}">
                                                            <span class="checkmark"></span>
                                                            {{ $color->name }}
                                                        </label>
                                                    @endforeach
                                            </div>
                                            </div>
                                                </div>
                                                
                                        <div class="col-lg-12">
    
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="is_metallic_paint" value="1">
                                                <span class="checkmark"></span>
                                                Metallic Paint
                                            </label>
                                                
                                            </div>
                                        </div>
                                    </div>
    
    
                                <!-- Vehicle Conditions Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">Vehicle Conditions</h6>
                                                </div>
                                    <div class="filter-section-content">
    
    
                                        <div class="col-lg-12">
                                            <div class="form_boxes">
                                                <label>Previous Owners</label>
                                                <div class="previous-owners-container">
                                                    <div class="owners-options">
                                                        <label class="owners-option">
                                                            <input type="radio" name="previous_owners_filter"
                                                                value="any">
                                                            <span class="radio-mark"></span>
                                                            Any
                                                        </label>
                                                        <label class="owners-option">
                                                            <input type="radio" name="previous_owners_filter"
                                                                value="1">
                                                            <span class="radio-mark"></span>
                                                            1 Owner
                                                        </label>
                                                        <label class="owners-option">
                                                            <input type="radio" name="previous_owners_filter"
                                                                value="2">
                                                            <span class="radio-mark"></span>
                                                            2 Owners
                                                        </label>
                                                        <label class="owners-option">
                                                            <input type="radio" name="previous_owners_filter"
                                                                value="3">
                                                            <span class="radio-mark"></span>
                                                            3+ Owners
                                                        </label>
                                            </div>
                                        </div>
                                    </div>
                                            </div>
    
    
                                                </div>
                                            </div>
    
                                <!-- Environment Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">Environment</h6>
                                                </div>
                                    <div class="filter-section-content">
                                        <div class="col-lg-12">
                                            <div class="form_boxes">
                                                <label>Emission Class</label>
                                                <div class="multi-select-container">
                                                    <div class="selected-options"></div>
                                                    <div class="multi-select-dropdown">
                                                        <div class="multi-select-list">
                                                            @php
                                                                $emissionsClasses = [
                                                                    'Euro 1',
                                                                    'Euro 2',
                                                                    'Euro 3',
                                                                    'Euro 4',
                                                                    'Euro 5',
                                                                    'Euro 6',
                                                                ];
                                                            @endphp
                                                            @foreach ($emissionsClasses as $emissionsClass)
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="emissions_class[]"
                                                                        value="{{ $emissionsClass }}">
                                                                    <span class="checkmark"></span>
                                                                    {{ $emissionsClass }}
                                                                </label>
                                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                            </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>Emissions From</label>
                                                    <input type="text" name="co2_emissions_from" class=""
                                                        placeholder="" >
                                </div>
                            </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>Emissions To</label>
                                                    <input type="text" name="co2_emissions_to" placeholder=""
                                                        >
                        </div>
                                </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>Fuel Consumption From</label>
                                                    <input type="text" name="fuel_consumption_from" placeholder=""
                                                        >
                                                </div>
                                            </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>Fuel Consumption To</label>
                                                    <input type="text" name="fuel_consumption_to" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                            </div>
    
                                <!-- More Information Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">More Information</h6>
                                                </div>
                                    <div class="filter-section-content">
                                        <div class="col-lg-12">
                                            <div class="form_boxes">
                                                <label>Online From</label>
                                                <div class="drop-menu" id="online-from-dropdown">
                                                    <div class="select">
                                                        <span>Select Period</span>
                                                        <i class="fa fa-angle-down"></i>
                                            </div>
                                                    <input type="hidden" name="online_from_period">
                                                    <ul class="dropdown" style="display: none;">
                                                        <li data-id="1">1 day</li>
                                                        <li data-id="2">2 days</li>
                                                        <li data-id="3">3 days</li>
                                                        <li data-id="7">1 week</li>
                                                        <li data-id="14">2 weeks</li>
                                                        <li data-id="30">1 month</li>
                                                        <li data-id="90">3 months</li>
                                                        <li data-id="180">6 months</li>
                                                        <li data-id="365">1 year</li>
                                        </ul>
                                    </div>
                                            </div>
                                    </div>
    
                                        <div class="col-lg-6">
                                            <div class="">
                                                <label class="checkbox-item">
                                                    <input type="checkbox" name="tax_deductible" value="1">
                                                    <span class="checkmark"></span>
                                                    VAT Deductible
                                                </label>
                                </div>
                            </div>
                        </div>
                                </div>
                                                </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
                                                
                                            </div>
                    </div><!--widget end-->
                                        </div>
                <div class="col-xl-9 col-md-12 col-sm-12">
                    <div class="right-box">
                        <div class="text-box">
                            <div class="text" id="pagination-info">
                                @if($advertisements->count() > 0)
                                    Showing {{ $advertisements->firstItem() }} to {{ $advertisements->lastItem() }} of {{ $advertisements->total() }} vehicles
                                @else
                                    No vehicles found
                                @endif
                                    </div>
                                            </div>
                        <!-- service-block-thirteen -->
                        <div class="service-block-thirteen" id="vehicle-cards-container">
                            <!-- Loading indicator -->
                            <div id="loading-indicator" style="display: none; text-align: center; padding: 50px;">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                    </div>
                                <p>Loading vehicles...</p>
                                </div>
                            
                            @include('wizmoto.home.partials.vehicle-cards')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shop section two -->
    @include('wizmoto.partials.footer')

@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            // Only initialize on inventory list page
            if (!$('.inventory-sidebar').length) {
                return;
            }
            
            console.log('jQuery loaded, document ready');
            console.log('Quick filter elements found:', $('.quick-filter').length);
            
            let groupCounter = 0;

            // Add new vehicle group
            $(document).on('click', '.add-vehicle-btn', function() {
                groupCounter++;
                const originalGroup = $('.vehicle-search-group').first();
                const newGroup = originalGroup.clone();

                // Update group data attribute
                newGroup.attr('data-group', groupCounter);

                // Update IDs to be unique
                newGroup.find('#brand-dropdown').attr('id', `brand-dropdown-${groupCounter}`);
                newGroup.find('#model-dropdown').attr('id', `model-dropdown-${groupCounter}`);

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

                // Keep the same styling as the original group
                // No need to change background color

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
                container.find('[id^="brand-dropdown"]').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');

                    // Close other dropdowns
                    $('.dropdown').not($dropdown).hide();

                    $dropdown.toggle();
                });

                // Brand selection handler
                container.find('[id^="brand-dropdown"] .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const brandId = $(this).data('id');
                    const brandName = $(this).text();
                    const $brandDropdown = $(this).closest('[id^="brand-dropdown"]');

                    $brandDropdown.find('.select span').text(brandName);
                    $brandDropdown.find('input[type="hidden"]').val(brandId);
                    
                    console.log('Brand dropdown updated:');
                    console.log('- Display text:', $brandDropdown.find('.select span').text());
                    console.log('- Hidden input value:', $brandDropdown.find('input[type="hidden"]').val());
                    $(this).closest('.dropdown').hide();

                    // Load models for selected brand
                    loadModels(container, brandId);
                    
                    // Update selected filters bar
                    console.log('Brand selected in existing handler:', brandName);
                    console.log('Calling updateSelectedFiltersBar immediately...');
                    updateSelectedFiltersBar();
                    console.log('Also calling with timeout...');
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for brand...');
                    updateVehicleCards();
                });

                // Model dropdown click handler
                container.find('[id^="model-dropdown"]').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');

                    // Close other dropdowns
                    $('.dropdown').not($dropdown).hide();

                    $dropdown.toggle();
                });

                // Model selection handler
                container.find('[id^="model-dropdown"] .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const modelId = $(this).data('id');
                    const modelName = $(this).text();
                    const $modelDropdown = $(this).closest('[id^="model-dropdown"]');

                    $modelDropdown.find('.select span').text(modelName);
                    $modelDropdown.find('input[type="hidden"]').val(modelId);
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    console.log('Model selected in existing handler:', modelName);
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for model...');
                    updateVehicleCards();
                });
            }

            // Load brands for selected advertisement type (single)
            function loadBrandsForAdvertisementType(advertisementTypeId) {
                console.log('Loading brands for advertisement type:', advertisementTypeId);
                
                const $brandDropdown = $('#brand-dropdown .dropdown');
                const $brandSelect = $('#brand-dropdown .select span');
                const $brandInput = $('#brand-dropdown input[type="hidden"]');

                // Reset brand selection
                $brandSelect.text('Select Brand');
                $brandInput.val('');
                $brandDropdown.empty();

                if (!advertisementTypeId) {
                    console.log('No advertisement type selected, showing all brands');
                    // Load all brands
                    loadAllBrands();
                    return;
                }

                // Make AJAX request to get brands for this advertisement type
                $.ajax({
                    url: '{{ route("inventory.list") }}',
                    method: 'GET',
                    data: { 
                        advertisement_type: advertisementTypeId,
                        get_brands_only: true // Flag to indicate we only want brands
                    },
                    success: function(response) {
                        console.log('Brands loaded successfully:', response);
                        
                        if (response.brands && response.brands.length > 0) {
                            // Populate brand dropdown with filtered brands
                            response.brands.forEach(function(brand) {
                                $brandDropdown.append(`
                                    <li data-id="${brand.id}">${brand.name}</li>
                                `);
                            });
                            console.log('Brand dropdown populated with', response.brands.length, 'brands');
                        } else {
                            $brandDropdown.append('<li>No brands available for this category</li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading brands:', error);
                        $brandDropdown.append('<li>Error loading brands</li>');
                    }
                });
            }

            // Load all brands (when no category is selected)
            function loadAllBrands() {
                const $brandDropdown = $('#brand-dropdown .dropdown');
                const brands = @json($brands);
                
                $brandDropdown.empty();
                brands.forEach(function(brand) {
                    $brandDropdown.append(`
                        <li data-id="${brand.id}">${brand.name}</li>
                    `);
                });
                console.log('All brands loaded:', brands.length);
            }

            // Load models for selected brand
            function loadModels(container, brandId) {
                const $modelDropdown = container.find('[id^="model-dropdown"] .dropdown');
                const $modelSelect = container.find('[id^="model-dropdown"] .select span');
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
                                $modelDropdown.append('<li data-id="' + modelId + '">' +
                                    modelName + '</li>');
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

            // Initialize all dropdowns in the page
            initializeAllDropdowns();
            
            // Initialize brand dropdown with all brands
            loadAllBrands();

            // Function to initialize all dropdowns
            function initializeAllDropdowns() {
                // Advertisement Type dropdown
                $('#advertisement-type-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#advertisement-type-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const advertisementTypeId = $(this).data('id');
                    const advertisementTypeName = $(this).text();
                    const $advertisementTypeDropdown = $(this).closest('#advertisement-type-dropdown');

                    console.log('Advertisement type clicked:', advertisementTypeId, advertisementTypeName);

                    $advertisementTypeDropdown.find('.select span').text(advertisementTypeName);
                    $advertisementTypeDropdown.find('input[type="hidden"]').val(advertisementTypeId);
                    $(this).closest('.dropdown').hide();
                    
                    // Clear brand and model selections when category changes
                    $('#brand-dropdown .select span').text('Select Brand');
                    $('#brand-dropdown input[type="hidden"]').val('');
                    $('#model-dropdown .select span').text('Select Model');
                    $('#model-dropdown input[type="hidden"]').val('');
                    
                    // Load brands for selected advertisement type
                    console.log('About to call loadBrandsForAdvertisementType with:', advertisementTypeId);
                    loadBrandsForAdvertisementType(advertisementTypeId);
                    
                    // Update selected filters bar
                    console.log('Advertisement type selected:', advertisementTypeName);
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // NOTE: Advertisement type is NOT used for filtering vehicles - only for loading brands
                });
                // Body Work dropdown
                $('#body-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#body-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const bodyId = $(this).data('id');
                    const bodyName = $(this).text();
                    $(this).closest('#body-dropdown').find('.select span').text(bodyName);
                    $(this).closest('#body-dropdown').find('input[type="hidden"]').val(bodyId);
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    console.log('Body selected:', bodyName);
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for body...');
                    updateVehicleCards();
                });

                // Fuel Type dropdown
                $('#fuel-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#fuel-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const fuelId = $(this).data('id');
                    const fuelName = $(this).text();
                    $(this).closest('#fuel-dropdown').find('.select span').text(fuelName);
                    $(this).closest('#fuel-dropdown').find('input[type="hidden"]').val(fuelId);
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    console.log('Fuel selected:', fuelName);
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for fuel...');
                    updateVehicleCards();
                });

                // Year From dropdown
                $('#year-from-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#year-from-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const year = $(this).data('id');
                    const yearText = $(this).text();
                    $(this).closest('#year-from-dropdown').find('.select span').text(yearText);
                    $(this).closest('#year-from-dropdown').find('input[type="hidden"]').val(year);
                    $(this).closest('.dropdown').hide();
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for year from...');
                    updateVehicleCards();
                });

                // Year To dropdown
                $('#year-to-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#year-to-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const year = $(this).data('id');
                    const yearText = $(this).text();
                    $(this).closest('#year-to-dropdown').find('.select span').text(yearText);
                    $(this).closest('#year-to-dropdown').find('input[type="hidden"]').val(year);
                    $(this).closest('.dropdown').hide();
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for year to...');
                    updateVehicleCards();
                });

                // Registration Year To dropdown
                $('#registration-year-to-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#registration-year-to-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const year = $(this).data('id');
                    const yearText = $(this).text();
                    $(this).closest('#registration-year-to-dropdown').find('.select span').text(yearText);
                    $(this).closest('#registration-year-to-dropdown').find('input[type="hidden"]').val(year);
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    console.log('Year To selected:', yearText);
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for registration year to...');
                    updateVehicleCards();
                });
                
                // Registration Year From dropdown li click handler
                $('#registration-year-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const year = $(this).data('id');
                    const yearText = $(this).text();
                    $(this).closest('#registration-year-dropdown').find('.select span').text(yearText);
                    $(this).closest('#registration-year-dropdown').find('input[type="hidden"]').val(year);
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    console.log('Year From selected:', yearText);
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for registration year from...');
                    updateVehicleCards();
                });

                // City dropdown
                $('#city-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#city-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const cityId = $(this).data('id');
                    const cityName = $(this).text();
                    $(this).closest('#city-dropdown').find('.select span').text(cityName);
                    $(this).closest('#city-dropdown').find('input[type="hidden"]').val(cityId);
                    $(this).closest('.dropdown').hide();
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for city...');
                    updateVehicleCards();
                });

                // Cylinders dropdown
                $('#cylinders-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#cylinders-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const cylindersId = $(this).data('id');
                    const cylindersText = $(this).text();
                    $(this).closest('#cylinders-dropdown').find('.select span').text(cylindersText);
                    $(this).closest('#cylinders-dropdown').find('input[type="hidden"]').val(cylindersId);
                    $(this).closest('.dropdown').hide();
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for cylinders...');
                    updateVehicleCards();
                });

                // Power CV From dropdown
                $('#power-cv-from-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#power-cv-from-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const cv = $(this).data('id');
                    const cvText = $(this).text();
                    $(this).closest('#power-cv-from-dropdown').find('.select span').text(cvText);
                    $(this).closest('#power-cv-from-dropdown').find('input[type="hidden"]').val(cv);
                    $(this).closest('.dropdown').hide();
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for power CV from...');
                    updateVehicleCards();
                });

                // Power CV To dropdown
                $('#power-cv-to-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#power-cv-to-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const cv = $(this).data('id');
                    const cvText = $(this).text();
                    $(this).closest('#power-cv-to-dropdown').find('.select span').text(cvText);
                    $(this).closest('#power-cv-to-dropdown').find('input[type="hidden"]').val(cv);
                    $(this).closest('.dropdown').hide();
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for power CV to...');
                    updateVehicleCards();
                });

                // Power KW From dropdown
                $('#power-kw-from-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#power-kw-from-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const kw = $(this).data('id');
                    const kwText = $(this).text();
                    $(this).closest('#power-kw-from-dropdown').find('.select span').text(kwText);
                    $(this).closest('#power-kw-from-dropdown').find('input[type="hidden"]').val(kw);
                    $(this).closest('.dropdown').hide();
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for power KW from...');
                    updateVehicleCards();
                });

                // Power KW To dropdown
                $('#power-kw-to-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#power-kw-to-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const kw = $(this).data('id');
                    const kwText = $(this).text();
                    $(this).closest('#power-kw-to-dropdown').find('.select span').text(kwText);
                    $(this).closest('#power-kw-to-dropdown').find('input[type="hidden"]').val(kw);
                    $(this).closest('.dropdown').hide();
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for power KW to...');
                    updateVehicleCards();
                });

                // Multi-select functionality
                $('.multi-select-item input[type="checkbox"]').on('change', function() {
                    const $container = $(this).closest('.multi-select-container');
                    const $selectedOptions = $container.find('.selected-options');
                    const $checkbox = $(this);
                    const value = $checkbox.val();
                    const text = $checkbox.closest('.multi-select-item').text().trim();

                    if ($checkbox.is(':checked')) {
                        // Add selected option
                        const optionHtml = `
                    <div class="selected-option" data-value="${value}">
                        ${text}
                        <span class="remove-option">&times;</span>
                    </div>
                `;
                        $selectedOptions.append(optionHtml);
                    } else {
                        // Remove selected option
                        $selectedOptions.find(`[data-value="${value}"]`).remove();
                    }
                });

                // Remove selected option
                $(document).on('click', '.remove-option', function() {
                    const $option = $(this).closest('.selected-option');
                    const value = $option.data('value');

                    // Uncheck the corresponding checkbox
                    $(`input[value="${value}"]`).prop('checked', false);

                    // Remove the option
                    $option.remove();
                });

                // Equipment "Show more" functionality
                $('.show-more-equipment').on('click', function(e) {
                    e.preventDefault();
                    const $this = $(this);
                    const $equipmentList = $('#equipment-list');
                    
                    // Show loading state
                    $this.prop('disabled', true);
                    $this.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    
                    // Get current loaded count and total
                    const currentLoaded = parseInt($this.data('loaded'));
                    const total = parseInt($this.data('total'));
                    const nextOffset = currentLoaded;
                    
                    // Make AJAX request
                    $.ajax({
                        url: '{{ route("equipment.load-more") }}',
                        method: 'GET',
                        data: {
                            offset: nextOffset,
                            limit: 10
                        },
                        success: function(response) {
                            // Append new equipment items
                            $equipmentList.append(response.html);
                            
                            // Update button data
                            $this.data('loaded', response.nextOffset);
                            
                            // Update button text or hide if no more items
                            if (response.hasMore) {
                                const remaining = total - response.nextOffset;
                                $this.html('<i class="fa fa-plus"></i> Show more equipment (' + remaining + ' more)');
                            } else {
                                $this.hide(); // Hide button if no more items
                            }
                            
                            // Re-enable button
                            $this.prop('disabled', false);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading more equipment:', error);
                            $this.html('<i class="fa fa-plus"></i> Show more equipment');
                            $this.prop('disabled', false);
                            alert('Error loading more equipment. Please try again.');
                        }
                    });
                });

                // Online From dropdown
                $('#online-from-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#online-from-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const period = $(this).data('id');
                    const text = $(this).text();

                    $(this).closest('.drop-menu').find('.select span').text(text);
                    $(this).closest('.drop-menu').find('input[type="hidden"]').val(period);
                    $(this).closest('.dropdown').hide();
                    
                    // Trigger vehicle cards update
                    console.log('Triggering updateVehicleCards for online from...');
                    updateVehicleCards();
                });
            }

            // Function to collect all filter values (global scope)
            function collectFilterValues() {
                    const filters = {};
                    
                    console.log('Collecting filter values...');
                    
                    // Advertisement Type is NOT used for filtering - only for loading brands
                    
                    // Brand filters
                    const brandIds = [];
                    $('.brand_id_input').each(function() {
                        if ($(this).val()) {
                            brandIds.push($(this).val());
                        }
                    });
                    if (brandIds.length > 0) {
                        filters.brand_id = brandIds;
                        console.log('Brand IDs:', brandIds);
                    }
                    
                    // Model filters
                    const modelIds = [];
                    $('.vehicle_model_id_input').each(function() {
                        if ($(this).val()) {
                            modelIds.push($(this).val());
                        }
                    });
                    if (modelIds.length > 0) {
                        filters.vehicle_model_id = modelIds;
                        console.log('Model IDs:', modelIds);
                    }

                    // Version filters
                    const versions = [];
                    $('input[name="version_model[]"]').each(function() {
                        if ($(this).val()) {
                            versions.push($(this).val());
                        }
                    });
                    if (versions.length > 0) {
                        filters.versions = versions;
                    }

                    // Body work
                    if ($('input[name="vehicle_body_id"]').val()) {
                        filters.vehicle_body_id = $('input[name="vehicle_body_id"]').val();
                    }

                    // Fuel type
                    if ($('input[name="fuel_type_id"]').val()) {
                        filters.fuel_type_id = $('input[name="fuel_type_id"]').val();
                    }

                    // Registration year
                    if ($('input[name="registration_year_from"]').val()) {
                        filters.registration_year_from = $('input[name="registration_year_from"]').val();
                    }
                    if ($('input[name="registration_year_to"]').val()) {
                        filters.registration_year_to = $('input[name="registration_year_to"]').val();
                    }

                    // Mileage
                    if ($('input[name="mileage_from"]').val()) {
                        filters.mileage_from = $('input[name="mileage_from"]').val();
                    }
                    if ($('input[name="mileage_to"]').val()) {
                        filters.mileage_to = $('input[name="mileage_to"]').val();
                    }

                    // Power CV
                    if ($('input[name="power_cv_from"]').val()) {
                        filters.power_cv_from = $('input[name="power_cv_from"]').val();
                    }
                    if ($('input[name="power_cv_to"]').val()) {
                        filters.power_cv_to = $('input[name="power_cv_to"]').val();
                    }

                    // Power KW
                    if ($('input[name="power_kw_from"]').val()) {
                        filters.power_kw_from = $('input[name="power_kw_from"]').val();
                    }
                    if ($('input[name="power_kw_to"]').val()) {
                        filters.power_kw_to = $('input[name="power_kw_to"]').val();
                    }

                    // Transmission
                    const transmissions = [];
                    $('input[name="motor_change[]"]:checked').each(function() {
                        transmissions.push($(this).val());
                    });
                    if (transmissions.length > 0) {
                        filters.motor_change = transmissions;
                    }

                    // Cylinders
                    if ($('input[name="cylinders"]').val()) {
                        filters.cylinders = $('input[name="cylinders"]').val();
                    }

                    // Engine displacement
                    if ($('input[name="motor_displacement_from"]').val()) {
                        filters.motor_displacement_from = $('input[name="motor_displacement_from"]').val();
                    }
                    if ($('input[name="motor_displacement_to"]').val()) {
                        filters.motor_displacement_to = $('input[name="motor_displacement_to"]').val();
                    }

                    // Price
                    if ($('input[name="price_from"]').val()) {
                        filters.price_from = $('input[name="price_from"]').val();
                    }
                    if ($('input[name="price_to"]').val()) {
                        filters.price_to = $('input[name="price_to"]').val();
                    }

                    // Vehicle conditions
                    const vehicleCategories = [];
                    $('input[name="vehicle_category[]"]:checked').each(function() {
                        vehicleCategories.push($(this).val());
                    });
                    if (vehicleCategories.length > 0) {
                        filters.vehicle_category = vehicleCategories;
                    }

                    if ($('input[name="damaged_vehicle"]:checked').length > 0) {
                        filters.damaged_vehicle = 1;
                    }
                    if ($('input[name="coupon_documentation"]:checked').length > 0) {
                        filters.coupon_documentation = 1;
                    }

                    // City
                    if ($('input[name="city_id"]').val()) {
                        filters.city_id = $('input[name="city_id"]').val();
                    }

                    // Postal code
                    if ($('input[name="postal_code"]').val()) {
                        filters.postal_code = $('input[name="postal_code"]').val();
                    }

                    // Search radius
                    if ($('input[name="search_radius"]').val()) {
                        filters.search_radius = $('input[name="search_radius"]').val();
                    }

                    // Equipment
                    const equipmentIds = [];
                    $('input[name="equipments[]"]:checked').each(function() {
                        equipmentIds.push($(this).val());
                    });
                    if (equipmentIds.length > 0) {
                        filters.equipments = equipmentIds;
                    }

                    // Colors
                    const colorIds = [];
                    $('input[name="color_ids[]"]:checked').each(function() {
                        colorIds.push($(this).val());
                    });
                    if (colorIds.length > 0) {
                        filters.color_ids = colorIds;
                    }

                    // Metallic paint
                    if ($('input[name="is_metallic_paint"]:checked').length > 0) {
                        filters.is_metallic_paint = 1;
                    }

                    // Previous owners
                    if ($('input[name="previous_owners_filter"]:checked').val()) {
                        filters.previous_owners_filter = $('input[name="previous_owners_filter"]:checked').val();
                    }

                    // Emissions class
                    const emissionsClasses = [];
                    $('input[name="emissions_class[]"]:checked').each(function() {
                        emissionsClasses.push($(this).val());
                    });
                    if (emissionsClasses.length > 0) {
                        filters.emissions_class = emissionsClasses;
                    }

                    // CO2 emissions
                    if ($('input[name="co2_emissions_from"]').val()) {
                        filters.co2_emissions_from = $('input[name="co2_emissions_from"]').val();
                    }
                    if ($('input[name="co2_emissions_to"]').val()) {
                        filters.co2_emissions_to = $('input[name="co2_emissions_to"]').val();
                    }

                    // Fuel consumption
                    if ($('input[name="fuel_consumption_from"]').val()) {
                        filters.fuel_consumption_from = $('input[name="fuel_consumption_from"]').val();
                    }
                    if ($('input[name="fuel_consumption_to"]').val()) {
                        filters.fuel_consumption_to = $('input[name="fuel_consumption_to"]').val();
                    }

                    // Online from
                    if ($('input[name="online_from_period"]').val()) {
                        filters.online_from_period = $('input[name="online_from_period"]').val();
                    }

                    // VAT deductible
                    if ($('input[name="tax_deductible"]:checked').length > 0) {
                        filters.tax_deductible = 1;
                    }

                    return filters;
                }

            // Function to update vehicle cards (global scope)
            function updateVehicleCards() {
                console.log('updateVehicleCards called');
                const filters = collectFilterValues();
                console.log('Collected filters:', filters);
                
                // Show loading indicator
                $('#loading-indicator').show();
                $('.inner-box').hide();

                // Make AJAX request
                $.ajax({
                    url: '{{ route("inventory.list") }}',
                    method: 'GET',
                    data: filters,
                    success: function(response) {
                        console.log('AJAX success, updating cards');
                        // Update the vehicle cards container with new content
                        $('#vehicle-cards-container').html(response.html);
                        
                        // Update pagination info from the response
                        updatePaginationInfo(response.pagination);
                        
                        // Hide loading indicator
                        $('#loading-indicator').hide();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error filtering vehicles:', error);
                        $('#loading-indicator').hide();
                        $('.inner-box').show();
                        
                        // Show error message
                        alert('Error loading vehicles. Please try again.');
                    }
                });
            }

            // Function to update pagination info (global scope)
            function updatePaginationInfo(pagination) {
                console.log('Updating pagination info:', pagination);
                const $paginationInfo = $('#pagination-info');
                
                if (pagination.total > 0) {
                    $paginationInfo.text(`Showing ${pagination.first_item} to ${pagination.last_item} of ${pagination.total} vehicles`);
                } else {
                    $paginationInfo.text('No vehicles found');
                }
            }

            // Dynamic filtering functionality
            function initializeDynamicFiltering() {
                // Debounce function to limit API calls
                function debounce(func, wait) {
                    let timeout;
                    return function executedFunction(...args) {
                        const later = () => {
                            clearTimeout(timeout);
                            func(...args);
                        };
                        clearTimeout(timeout);
                        timeout = setTimeout(later, wait);
                    };
                }

                // Debounced update function (wait 500ms after last change)
                const debouncedUpdate = debounce(updateVehicleCards, 500);

                // Bind events to all filter inputs
                $('.inventory-sidebar').on('change', 'input, select', debouncedUpdate);
                $('.inventory-sidebar').on('click', '.dropdown li', function() {
                    // Small delay to allow the dropdown value to be set
                    setTimeout(debouncedUpdate, 100);
                });

                // Bind events to text inputs with a longer delay
                $('.inventory-sidebar').on('input', 'input[type="text"], input[type="number"]', debouncedUpdate);
            }

            // Initialize dynamic filtering
            initializeDynamicFiltering();

            // Dynamic pagination functionality
            function initializeDynamicPagination() {
                // Handle pagination clicks
                $(document).on('click', '.pagination .page-link', function(e) {
                    e.preventDefault();
                    
                    const url = $(this).attr('href');
                    if (!url || url === '#') return;
                    
                    // Show loading indicator
                    $('#loading-indicator').show();
                    $('.inner-box').hide();
                    
                    // Extract page number from URL
                    const urlParams = new URLSearchParams(url.split('?')[1]);
                    const page = urlParams.get('page') || 1;
                    
                    // Get current filter values
                    const filters = collectFilterValues();
                    filters.page = page;
                    
                    // Make AJAX request
                    $.ajax({
                        url: '{{ route("inventory.list") }}',
                        method: 'GET',
                        data: filters,
                        success: function(response) {
                            // Update the vehicle cards container with new content
                            $('#vehicle-cards-container').html(response.html);
                            
                            // Update pagination info from the response
                            updatePaginationInfo(response.pagination);
                            
                            // Hide loading indicator
                            $('#loading-indicator').hide();
                            
                            // Scroll to top of results
                            $('html, body').animate({
                                scrollTop: $('#vehicle-cards-container').offset().top - 100
                            }, 500);
                            
                            // Update URL without page reload
                            updateURL(filters);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading page:', error);
                            $('#loading-indicator').hide();
                            $('.inner-box').show();
                            
                            // Show error message
                            alert('Error loading page. Please try again.');
                        }
                    });
                });
            }

            // Function to update URL without page reload
            function updateURL(filters) {
                const url = new URL(window.location);
                
                // Clear existing parameters
                url.search = '';
                
                // Add filter parameters
                Object.keys(filters).forEach(key => {
                    if (filters[key] !== null && filters[key] !== undefined && filters[key] !== '') {
                        if (Array.isArray(filters[key])) {
                            filters[key].forEach(value => {
                                url.searchParams.append(key + '[]', value);
                            });
                        } else {
                            url.searchParams.set(key, filters[key]);
                        }
                    }
                });
                
                // Update URL without page reload
                window.history.pushState({}, '', url);
            }

            // Initialize dynamic pagination
            initializeDynamicPagination();

            // Quick filter functionality
            function initializeQuickFilters() {
                console.log('Initializing quick filters...');
                
                $(document).on('click', '.quick-filter', function(e) {
                    e.preventDefault();
                    console.log('Quick filter clicked!', $(this).text());
                    
                    const filterType = $(this).data('filter');
                    const filterValue = $(this).data('value');
                    
                    console.log('Filter type:', filterType, 'Value:', filterValue);
                    
                    // Apply the quick filter based on type
                    applyQuickFilter(filterType, filterValue);
                    
                    // Add visual feedback
                    $(this).addClass('active');
                    setTimeout(() => {
                        $(this).removeClass('active');
                    }, 200);
                });
            }

            // Apply quick filter based on type and value
            function applyQuickFilter(filterType, filterValue) {
                console.log('Applying quick filter:', filterType, filterValue);
                
                switch(filterType) {
                    case 'body':
                        // Find the body type in the dropdown and select it
                        const bodyDropdown = $('#body-dropdown');
                        const bodyOption = bodyDropdown.find(`li:contains("${filterValue}")`);
                        if (bodyOption.length) {
                            const bodyId = bodyOption.data('id');
                            bodyDropdown.find('.select span').text(filterValue);
                            bodyDropdown.find('input[type="hidden"]').val(bodyId);
                        }
                        break;
                        
                    case 'transmission':
                        // Check the transmission checkbox
                        $(`input[name="motor_change[]"][value="${filterValue}"]`).prop('checked', true);
                        break;
                        
                    case 'price':
                        if (filterValue === '5000-10000') {
                            $('input[name="price_from"]').val('5000');
                            $('input[name="price_to"]').val('10000');
                        } else if (filterValue === 'great-price') {
                            // Define great price as under $15,000
                            $('input[name="price_to"]').val('15000');
                        }
                        break;
                        
                    case 'year':
                        if (filterValue === '2020+') {
                            // Set the registration year dropdown to 2020
                            const yearDropdown = $('#registration-year-dropdown');
                            yearDropdown.find('.select span').text('2020');
                            yearDropdown.find('input[type="hidden"]').val('2020');
                        }
                        break;
                        
                    case 'drive':
                        // This would need to be mapped to your actual drive type field
                        // For now, we'll add it as a custom filter
                        break;
                        
                    case 'mileage':
                        if (filterValue === '0-75000') {
                            $('input[name="mileage_to"]').val('75000');
                        } else if (filterValue === '0-50000') {
                            $('input[name="mileage_to"]').val('50000');
                        }
                        break;
                        
                    case 'fuel':
                        // Find the fuel type in the dropdown and select it
                        const fuelDropdown = $('#fuel-dropdown');
                        const fuelOption = fuelDropdown.find(`li:contains("${filterValue}")`);
                        if (fuelOption.length) {
                            const fuelId = fuelOption.data('id');
                            fuelDropdown.find('.select span').text(filterValue);
                            fuelDropdown.find('input[type="hidden"]').val(fuelId);
                        }
                        break;
                }
                
                console.log('Triggering vehicle cards update...');
                // Trigger the filter update
                updateVehicleCards();
            }

            // Initialize quick filters
            console.log('About to initialize quick filters...');
            initializeQuickFilters();
            console.log('Quick filters initialized');

            // Clear all filters functionality
            function initializeClearFilters() {
                $(document).on('click', '.clear-filters-btn', function(e) {
                    e.preventDefault();
                    
                    // Clear all form inputs
                    $('.inventory-sidebar input[type="text"]').val('');
                    $('input[type="number"]').val('');
                    $('input[type="checkbox"]').prop('checked', false);
                    $('input[type="radio"]').prop('checked', false);
                    
                    // Reset dropdowns
                    $('.drop-menu .select span').each(function() {
                        const originalText = $(this).closest('.drop-menu').find('label').text();
                        if (originalText.includes('Select')) {
                            $(this).text(originalText);
                        } else {
                            $(this).text('Select ' + originalText);
                        }
                    });
                    $('input[type="hidden"]').val('');
                    
                    // Reset multi-select containers
                    $('.selected-options').empty();
                    
                    // Trigger filter update
                    updateVehicleCards();
                    
                    // Show feedback
                    $(this).addClass('active');
                    setTimeout(() => {
                        $(this).removeClass('active');
                    }, 200);
                });
            }

            // Initialize clear filters
            initializeClearFilters();

            // Function to update the selected filters bar (global scope)
            function updateSelectedFiltersBar() {
                    console.log('=== updateSelectedFiltersBar called ===');
                    const selectedFilters = collectSelectedFilters();
                    const $bar = $('#selected-filters-bar');
                    const $list = $('#selected-filters-list');
                    
                    console.log('Selected filters count:', Object.keys(selectedFilters).length);
                    console.log('Selected filters:', selectedFilters);
                    
                    // Clear existing filters
                    $list.empty();
                    
                    if (Object.keys(selectedFilters).length === 0) {
                        console.log('No filters selected, hiding bar');
                        $bar.hide();
                        return;
                    }
                    
                    console.log('Showing filters bar with', Object.keys(selectedFilters).length, 'filters');
                    // Show the bar
                    $bar.show();
                    
                    // Add each selected filter
                    Object.keys(selectedFilters).forEach(filterKey => {
                        const filter = selectedFilters[filterKey];
                        let $filterTag;
                        
                        if (filter.type === 'multi-select') {
                            // For multi-select filters (like transmission, brands, etc.)
                            $filterTag = $(`
                                <div class="selected-filter-tag multi-select" data-filter-key="${filterKey}">
                                    <span class="filter-name">${filter.name}:</span>
                                    <div class="filter-values-box">
                                        ${filter.values.map(value => `
                                            <span class="filter-value-item">${value}</span>
                                        `).join('')}
                            </div>
                                    <button type="button" class="remove-filter-btn" data-filter-key="${filterKey}">
                                        <i class="fa fa-times"></i>
                                    </button>
                    </div>
                            `);
                        } else {
                            // For single value and range filters
                            $filterTag = $(`
                                <div class="selected-filter-tag" data-filter-key="${filterKey}">
                                    <span class="filter-name">${filter.name}:</span>
                                    <span class="filter-value">${filter.value}</span>
                                    <button type="button" class="remove-filter-btn" data-filter-key="${filterKey}">
                                        <i class="fa fa-times"></i>
                                    </button>
                </div>
                            `);
                        }
                        
                        $list.append($filterTag);
                    });
                }
                
            // Function to collect currently selected filters (global scope)
            function collectSelectedFilters() {
                    console.log('Collecting selected filters...');
                    const filters = {};
                    
                    // Brand filters - create individual filter for each brand
                    console.log('Checking brand inputs...');
                    console.log('Found brand inputs:', $('input[name="brand_id[]"]').length);
                    
                    $('input[name="brand_id[]"]').each(function() {
                        const brandId = $(this).val();
                        console.log('Brand input found, ID:', brandId);
                        
                        if (brandId && brandId.trim() !== '') {
                            const $brandDropdown = $(this).closest('[id^="brand-dropdown"]');
                            const brandName = $brandDropdown.find('.select span').text().trim();
                            console.log('Brand name from dropdown:', brandName);
                            if (brandName && !brandName.includes('Select')) {
                                // Create individual filter for each brand
                                filters[`brand_${brandId}`] = {
                                    name: 'Brand',
                                    value: brandName,
                                    type: 'single',
                                    brandId: brandId
                                };
                                console.log('Added individual brand filter:', brandName);
                            }
                        }
                    });
                    
                    // Model filters - create individual filter for each model
                    $('input[name="vehicle_model_id[]"]').each(function() {
                        const modelId = $(this).val();
                        if (modelId && modelId.trim() !== '') {
                            const $modelDropdown = $(this).closest('[id^="model-dropdown"]');
                            const modelName = $modelDropdown.find('.select span').text().trim();
                            if (modelName && !modelName.includes('Select')) {
                                // Create individual filter for each model
                                filters[`model_${modelId}`] = {
                                    name: 'Model',
                                    value: modelName,
                                    type: 'single',
                                    modelId: modelId
                                };
                            }
                        }
                    });
                    
                    // Fuel type filter
                    const fuelTypeId = $('input[name="fuel_type_id"]').val();
                    if (fuelTypeId && fuelTypeId.trim() !== '') {
                        const fuelTypeName = $('#fuel-dropdown .select span').text().trim();
                        if (fuelTypeName && !fuelTypeName.includes('Select')) {
                            filters[`fuel_type_${fuelTypeId}`] = {
                                name: 'Fuel Type',
                                value: fuelTypeName,
                                type: 'single',
                                fuelTypeId: fuelTypeId
                            };
                        }
                    }
                    
                    // Price range
                    const priceFrom = $('input[name="price_from"]').val();
                    const priceTo = $('input[name="price_to"]').val();
                    if (priceFrom || priceTo) {
                        let priceValue = '';
                        if (priceFrom && priceTo) {
                            priceValue = `$${priceFrom} - $${priceTo}`;
                        } else if (priceFrom) {
                            priceValue = `From $${priceFrom}`;
                        } else if (priceTo) {
                            priceValue = `Up to $${priceTo}`;
                        }
                        filters.price = {
                            name: 'Price',
                            value: priceValue,
                            type: 'range'
                        };
                    }
                    
                    // Body type
                    const bodyType = $('#body-dropdown .select span').text();
                    if (bodyType && !bodyType.includes('Select')) {
                        filters.body = {
                            name: 'Body Type',
                            value: bodyType,
                            type: 'single'
                        };
                    }
                    
                    
                    // Registration year (From and To)
                    const regYearFrom = $('#registration-year-dropdown .select span').text();
                    const regYearTo = $('#registration-year-to-dropdown .select span').text();
                    
                    if ((regYearFrom && !regYearFrom.includes('From') && !regYearFrom.includes('Select')) || 
                        (regYearTo && !regYearTo.includes('To') && !regYearTo.includes('Select'))) {
                        
                        let yearValue = '';
                        if (regYearFrom && !regYearFrom.includes('From') && !regYearFrom.includes('Select') && 
                            regYearTo && !regYearTo.includes('To') && !regYearTo.includes('Select')) {
                            yearValue = `${regYearFrom} - ${regYearTo}`;
                        } else if (regYearFrom && !regYearFrom.includes('From') && !regYearFrom.includes('Select')) {
                            yearValue = `From ${regYearFrom}`;
                        } else if (regYearTo && !regYearTo.includes('To') && !regYearTo.includes('Select')) {
                            yearValue = `Up to ${regYearTo}`;
                        }
                        
                        if (yearValue) {
                            filters.year = {
                                name: 'Year',
                                value: yearValue,
                                type: 'range'
                            };
                        }
                    }
                    
                    // Mileage
                    const mileageFrom = $('input[name="mileage_from"]').val();
                    const mileageTo = $('input[name="mileage_to"]').val();
                    if (mileageFrom || mileageTo) {
                        let mileageValue = '';
                        if (mileageFrom && mileageTo) {
                            mileageValue = `${mileageFrom} - ${mileageTo} miles`;
                        } else if (mileageFrom) {
                            mileageValue = `From ${mileageFrom} miles`;
                        } else if (mileageTo) {
                            mileageValue = `Up to ${mileageTo} miles`;
                        }
                        filters.mileage = {
                            name: 'Mileage',
                            value: mileageValue,
                            type: 'range'
                        };
                    }
                    
                    // Transmission
                    const selectedTransmissions = [];
                    $('input[name="motor_change[]"]:checked').each(function() {
                        selectedTransmissions.push($(this).val());
                    });
                    if (selectedTransmissions.length > 0) {
                        filters.transmission = {
                            name: 'Transmission',
                            values: selectedTransmissions,
                            type: 'multi-select'
                        };
                    }
                    
                    // Vehicle condition
                    const selectedConditions = [];
                    $('input[name="advertisement_type_id[]"]:checked').each(function() {
                        const conditionName = $(this).closest('label').text().trim();
                        selectedConditions.push(conditionName);
                    });
                    if (selectedConditions.length > 0) {
                        filters.condition = {
                            name: 'Condition',
                            values: selectedConditions,
                            type: 'multi-select'
                        };
                    }
                    
                    // Equipment
                    const selectedEquipment = [];
                    $('input[name="equipments[]"]:checked').each(function() {
                        const equipmentName = $(this).closest('label').text().trim();
                        selectedEquipment.push(equipmentName);
                    });
                    if (selectedEquipment.length > 0) {
                        filters.equipment = {
                            name: 'Equipment',
                            values: selectedEquipment,
                            type: 'multi-select'
                        };
                    }
                    
                    // Color
                    const selectedColors = [];
                    $('input[name="color_ids[]"]:checked').each(function() {
                        const colorName = $(this).closest('label').text().trim();
                        selectedColors.push(colorName);
                    });
                    if (selectedColors.length > 0) {
                        filters.color = {
                            name: 'Color',
                            values: selectedColors,
                            type: 'multi-select'
                        };
                    }
                    
                    // Vehicle Category
                    const selectedCategories = [];
                    $('input[name="vehicle_category[]"]:checked').each(function() {
                        const categoryName = $(this).closest('label').text().trim();
                        selectedCategories.push(categoryName);
                    });
                    if (selectedCategories.length > 0) {
                        filters.category = {
                            name: 'Category',
                            values: selectedCategories,
                            type: 'multi-select'
                        };
                    }
                    
                    // Emissions Class
                    const selectedEmissions = [];
                    $('input[name="emissions_class[]"]:checked').each(function() {
                        const emissionName = $(this).closest('label').text().trim();
                        selectedEmissions.push(emissionName);
                    });
                    if (selectedEmissions.length > 0) {
                        filters.emissions = {
                            name: 'Emissions',
                            values: selectedEmissions,
                            type: 'multi-select'
                        };
                    }
                    
                    // Version Model
                    const versionModel = $('input[name="version_model[]"]').val();
                    if (versionModel && versionModel.trim() !== '') {
                        filters.version = {
                            name: 'Version',
                            value: versionModel,
                            type: 'single'
                        };
                    }
                    
                    // Power CV
                    const powerCvFrom = $('input[name="power_cv_from"]').val();
                    const powerCvTo = $('input[name="power_cv_to"]').val();
                    if (powerCvFrom || powerCvTo) {
                        let powerCvValue = '';
                        if (powerCvFrom && powerCvTo) {
                            powerCvValue = `${powerCvFrom} - ${powerCvTo} CV`;
                        } else if (powerCvFrom) {
                            powerCvValue = `From ${powerCvFrom} CV`;
                        } else if (powerCvTo) {
                            powerCvValue = `Up to ${powerCvTo} CV`;
                        }
                        filters.powerCv = {
                            name: 'Power CV',
                            value: powerCvValue,
                            type: 'range'
                        };
                    }
                    
                    // Power KW
                    const powerKwFrom = $('input[name="power_kw_from"]').val();
                    const powerKwTo = $('input[name="power_kw_to"]').val();
                    if (powerKwFrom || powerKwTo) {
                        let powerKwValue = '';
                        if (powerKwFrom && powerKwTo) {
                            powerKwValue = `${powerKwFrom} - ${powerKwTo} KW`;
                        } else if (powerKwFrom) {
                            powerKwValue = `From ${powerKwFrom} KW`;
                        } else if (powerKwTo) {
                            powerKwValue = `Up to ${powerKwTo} KW`;
                        }
                        filters.powerKw = {
                            name: 'Power KW',
                            value: powerKwValue,
                            type: 'range'
                        };
                    }
                    
                    // Motor Displacement
                    const displacementFrom = $('input[name="motor_displacement_from"]').val();
                    const displacementTo = $('input[name="motor_displacement_to"]').val();
                    if (displacementFrom || displacementTo) {
                        let displacementValue = '';
                        if (displacementFrom && displacementTo) {
                            displacementValue = `${displacementFrom} - ${displacementTo} L`;
                        } else if (displacementFrom) {
                            displacementValue = `From ${displacementFrom} L`;
                        } else if (displacementTo) {
                            displacementValue = `Up to ${displacementTo} L`;
                        }
                        filters.displacement = {
                            name: 'Displacement',
                            value: displacementValue,
                            type: 'range'
                        };
                    }
                    
                    // Fuel Consumption
                    const consumptionFrom = $('input[name="fuel_consumption_from"]').val();
                    const consumptionTo = $('input[name="fuel_consumption_to"]').val();
                    if (consumptionFrom || consumptionTo) {
                        let consumptionValue = '';
                        if (consumptionFrom && consumptionTo) {
                            consumptionValue = `${consumptionFrom} - ${consumptionTo} L/100km`;
                        } else if (consumptionFrom) {
                            consumptionValue = `From ${consumptionFrom} L/100km`;
                        } else if (consumptionTo) {
                            consumptionValue = `Up to ${consumptionTo} L/100km`;
                        }
                        filters.consumption = {
                            name: 'Fuel Consumption',
                            value: consumptionValue,
                            type: 'range'
                        };
                    }
                    
                    // Special filters
                    const specialFilters = [];
                    if ($('input[name="is_metallic_paint"]:checked').length > 0) {
                        specialFilters.push('Metallic Paint');
                    }
                    if ($('input[name="tax_deductible"]:checked').length > 0) {
                        specialFilters.push('Tax Deductible');
                    }
                    if (specialFilters.length > 0) {
                        filters.special = {
                            name: 'Special',
                            values: specialFilters,
                            type: 'multi-select'
                        };
                    }
                    
                    console.log('Collected filters:', filters);
                    return filters;
                }
                
                // Handle remove individual filter
                $(document).on('click', '.remove-filter-btn', function(e) {
                    e.preventDefault();
                    const filterKey = $(this).data('filter-key');
                    removeFilter(filterKey);
                    updateSelectedFiltersBar();
                    updateVehicleCards();
                });
                
                // Handle clear all filters
                $(document).on('click', '.clear-all-filters-btn', function(e) {
                    e.preventDefault();
                    clearAllFilters();
                    updateSelectedFiltersBar();
                    updateVehicleCards();
                });
                
            // Function to remove a specific filter (global scope)
            function removeFilter(filterKey) {
                    // Handle individual brand removal (brand_123 format)
                    if (filterKey.startsWith('brand_')) {
                        const brandId = filterKey.replace('brand_', '');
                        // Find and clear the specific brand input
                        $(`input[name="brand_id[]"][value="${brandId}"]`).val('');
                        // Reset the dropdown display
                        $('#brand-dropdown .select span').text('Select Brand');
                        return;
                    }
                    
                    // Handle individual model removal (model_123 format)
                    if (filterKey.startsWith('model_')) {
                        const modelId = filterKey.replace('model_', '');
                        // Find and clear the specific model input
                        $(`input[name="vehicle_model_id[]"][value="${modelId}"]`).val('');
                        // Reset the dropdown display
                        $('#model-dropdown .select span').text('Select Model');
                        return;
                    }
                    
                    // Handle individual fuel type removal (fuel_type_123 format)
                    if (filterKey.startsWith('fuel_type_')) {
                        const fuelTypeId = filterKey.replace('fuel_type_', '');
                        // Clear the fuel type input
                        $('input[name="fuel_type_id"]').val('');
                        // Reset the dropdown display
                        $('#fuel-dropdown .select span').text('Select');
                        return;
                    }
                    
                    // Handle advertisement type removal (advertisement_type_123 format)
                    if (filterKey.startsWith('advertisement_type_')) {
                        // Remove the advertisement_type parameter from URL
                        const url = new URL(window.location);
                        url.searchParams.delete('advertisement_type');
                        window.location.href = url.toString();
                        return;
                    }
                    
                    switch(filterKey) {
                        case 'brands':
                            // Remove all brands
                            $('#brand-dropdown .select span').text('Select Brand');
                            $('#brand-dropdown input[type="hidden"]').val('');
                            break;
                        case 'models':
                            // Remove all models
                            $('#model-dropdown .select span').text('Select Model');
                            $('#model-dropdown input[type="hidden"]').val('');
                            break;
                        case 'price':
                            $('input[name="price_from"]').val('');
                            $('input[name="price_to"]').val('');
                            break;
                        case 'body':
                            $('#body-dropdown .select span').text('Select Body Work');
                            $('#body-dropdown input[type="hidden"]').val('');
                            break;
                        case 'fuel':
                            $('#fuel-dropdown .select span').text('Select Fuel Type');
                            $('#fuel-dropdown input[type="hidden"]').val('');
                            break;
                        case 'year':
                            $('#registration-year-dropdown .select span').text('From');
                            $('#registration-year-dropdown input[type="hidden"]').val('');
                            $('#registration-year-to-dropdown .select span').text('To');
                            $('#registration-year-to-dropdown input[type="hidden"]').val('');
                            break;
                        case 'mileage':
                            $('input[name="mileage_from"]').val('');
                            $('input[name="mileage_to"]').val('');
                            break;
                        case 'transmission':
                            $('input[name="motor_change[]"]:checked').prop('checked', false);
                            break;
                        case 'condition':
                            $('input[name="advertisement_type_id[]"]:checked').prop('checked', false);
                            break;
                        case 'equipment':
                            $('input[name="equipments[]"]:checked').prop('checked', false);
                            break;
                        case 'color':
                            $('input[name="color_ids[]"]:checked').prop('checked', false);
                            break;
                        case 'category':
                            $('input[name="vehicle_category[]"]:checked').prop('checked', false);
                            break;
                        case 'emissions':
                            $('input[name="emissions_class[]"]:checked').prop('checked', false);
                            break;
                        case 'version':
                            $('input[name="version_model[]"]').val('');
                            break;
                        case 'powerCv':
                            $('input[name="power_cv_from"]').val('');
                            $('input[name="power_cv_to"]').val('');
                            break;
                        case 'powerKw':
                            $('input[name="power_kw_from"]').val('');
                            $('input[name="power_kw_to"]').val('');
                            break;
                        case 'displacement':
                            $('input[name="motor_displacement_from"]').val('');
                            $('input[name="motor_displacement_to"]').val('');
                            break;
                        case 'consumption':
                            $('input[name="fuel_consumption_from"]').val('');
                            $('input[name="fuel_consumption_to"]').val('');
                            break;
                        case 'special':
                            $('input[name="damaged_vehicle"]:checked').prop('checked', false);
                            $('input[name="coupon_documentation"]:checked').prop('checked', false);
                            $('input[name="is_metallic_paint"]:checked').prop('checked', false);
                            $('input[name="tax_deductible"]:checked').prop('checked', false);
                            break;
                    }
                }
                
            // Function to clear all filters (global scope)
            function clearAllFilters() {
                    $('.inventory-sidebar input[type="text"]').val('');
                    $('input[type="number"]').val('');
                    $('input[type="checkbox"]').prop('checked', false);
                    $('input[type="radio"]').prop('checked', false);
                    
                    // Reset dropdowns
                    $('.drop-menu .select span').each(function() {
                        const originalText = $(this).closest('.drop-menu').find('label').text();
                        if (originalText.includes('Select')) {
                            $(this).text(originalText);
                        } else {
                            $(this).text('Select ' + originalText);
                        }
                    });
                    $('input[type="hidden"]').val('');
                    
                    // Reset multi-select containers
                    $('.selected-options').empty();
                }
                
                // Update the bar whenever filters change
                $(document).on('change', '.inventory-sidebar input, .inventory-sidebar select', function() {
                    console.log('Filter changed:', $(this).attr('name'), $(this).val());
                    setTimeout(updateSelectedFiltersBar, 100);
                });
                
                // Also listen for clicks on dropdown items
                $(document).on('click', '.inventory-sidebar .dropdown li', function() {
                    console.log('Dropdown item clicked:', $(this).text());
                    setTimeout(updateSelectedFiltersBar, 100);
                });
                
                // Listen for checkbox changes
                $(document).on('change', '.inventory-sidebar input[type="checkbox"]', function() {
                    console.log('Checkbox changed:', $(this).attr('name'), $(this).is(':checked'));
                    setTimeout(updateSelectedFiltersBar, 100);
                });
                
                // Listen for text input changes
                $(document).on('input', '.inventory-sidebar input[type="text"], .inventory-sidebar input[type="number"]', function() {
                    console.log('Text input changed:', $(this).attr('name'), $(this).val());
                    setTimeout(updateSelectedFiltersBar, 100);
                });
                
                // Note: Individual dropdown handlers are already set up in the existing code above
                
            // Selected Filters Bar functionality
            function initializeSelectedFiltersBar() {
                // Initial update
                console.log('Running initial updateSelectedFiltersBar...');
                updateSelectedFiltersBar();
                
                // Test function - call it after 2 seconds to see if it works
                setTimeout(function() {
                    console.log('=== TEST: Calling updateSelectedFiltersBar after 2 seconds ===');
                    updateSelectedFiltersBar();
                }, 2000);
            }

            // Initialize selected filters bar
            initializeSelectedFiltersBar();
            
            // Pre-fill filters from URL parameters
            prefillFiltersFromURL();
            
            // Function to pre-fill filters from URL parameters
            function prefillFiltersFromURL() {
                const urlParams = new URLSearchParams(window.location.search);
                console.log('Pre-filling filters from URL parameters:', Object.fromEntries(urlParams));
                
                // Pre-fill brand filter
                const brandId = urlParams.get('brand_id');
                if (brandId) {
                    const brandName = getBrandNameById(brandId);
                    if (brandName) {
                        $('#brand-dropdown .select span').text(brandName);
                        $('#brand-dropdown input[type="hidden"]').val(brandId);
                    }
                }
                
                // Pre-fill model filter
                const modelId = urlParams.get('vehicle_model_id');
                if (modelId) {
                    const modelName = getModelNameById(modelId);
                    if (modelName) {
                        $('#model-dropdown .select span').text(modelName);
                        $('#model-dropdown input[type="hidden"]').val(modelId);
                    }
                }
                
                // Pre-fill fuel type filter
                const fuelTypeId = urlParams.get('fuel_type_id');
                if (fuelTypeId) {
                    const fuelTypeName = getFuelTypeNameById(fuelTypeId);
                    if (fuelTypeName) {
                        $('#fuel-dropdown .select span').text(fuelTypeName);
                        $('#fuel-dropdown input[type="hidden"]').val(fuelTypeId);
                    }
                }
                
                // Pre-fill advertisement type filter
                const advertisementTypeId = urlParams.get('advertisement_type');
                console.log('Advertisement type ID from URL:', advertisementTypeId);
                if (advertisementTypeId) {
                    const advertisementTypeName = getAdvertisementTypeNameById(advertisementTypeId);
                    console.log('Advertisement type name:', advertisementTypeName);
                    if (advertisementTypeName) {
                        console.log('Adding advertisement type to filters...');
                        // Add to selected filters bar
                        addAdvertisementTypeToFilters(advertisementTypeId, advertisementTypeName);
                    } else {
                        console.log('Advertisement type name not found for ID:', advertisementTypeId);
                    }
                } else {
                    console.log('No advertisement_type parameter found in URL');
                }
                
                // Update selected filters bar after pre-filling
                setTimeout(updateSelectedFiltersBar, 500);
            }
            
            // Helper functions to get names by ID
            function getBrandNameById(id) {
                const brands = @json($brands);
                const brand = brands.find(b => b.id == id);
                return brand ? brand.name : null;
            }
            
            function getModelNameById(id) {
                const models = @json($vehicleModels);
                const model = models.find(m => m.id == id);
                return model ? model.name : null;
            }
            
            function getFuelTypeNameById(id) {
                const fuelTypes = @json($fuelTypes);
                const fuelType = fuelTypes.find(f => f.id == id);
                return fuelType ? fuelType.name : null;
            }
            
            function getAdvertisementTypeNameById(id) {
                const advertisementTypes = @json($advertisementTypes);
                console.log('All advertisement types:', advertisementTypes);
                console.log('Looking for ID:', id, 'Type:', typeof id);
                const advertisementType = advertisementTypes.find(a => a.id == id);
                console.log('Found advertisement type:', advertisementType);
                return advertisementType ? advertisementType.title : null;
            }
            
            function addAdvertisementTypeToFilters(advertisementTypeId, advertisementTypeName) {
                console.log('addAdvertisementTypeToFilters called with:', advertisementTypeId, advertisementTypeName);
                
                const $bar = $('#selected-filters-bar');
                const $list = $('#selected-filters-list');
                
                console.log('Filters bar element:', $bar.length);
                console.log('Filters list element:', $list.length);
                
                // Show the filters bar if it's hidden
                $bar.show();
                
                const $filterTag = $(`
                    <div class="selected-filter-tag" data-filter-key="advertisement_type_${advertisementTypeId}">
                        <span class="filter-name">Type:</span>
                        <span class="filter-value">${advertisementTypeName}</span>
                        <button type="button" class="remove-filter-btn" data-filter-key="advertisement_type_${advertisementTypeId}">
                            <i class="fa fa-times"></i>
                        </button>
                </div>
                `);
                
                console.log('Created filter tag:', $filterTag);
                $list.append($filterTag);
                console.log('Appended filter tag to list');
                
                // Add click handler for removal
                $filterTag.find('.remove-filter-btn').on('click', function() {
                    const url = new URL(window.location);
                    url.searchParams.delete('advertisement_type');
                    window.location.href = url.toString();
                });
            }
        });
    </script>
    
    <style>
        /* Dynamic Pagination Styles - AutoScout24 Style */
        .pagination-sec {
            margin-top: 30px;
            padding: 20px 0;
            border-top: 1px solid #e0e0e0;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            margin-bottom: 15px;
        }
        
        .page-item {
            list-style: none;
        }
        
        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            background: #fff;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .page-link:hover {
            background: #f8f9fa;
            border-color: #007bff;
            color: #007bff;
        }
        
        .page-item.active .page-link {
            background: #007bff;
            border-color: #007bff;
            color: #fff;
        }
        
        .page-item.disabled .page-link {
            background: #f8f9fa;
            color: #6c757d;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .pagination-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .pagination-info .text {
            color: #666;
            font-size: 14px;
        }
        
        .pagination-info .page-info {
            color: #999;
            font-size: 13px;
        }
        
        /* Loading indicator styles */
        #loading-indicator {
            text-align: center;
            padding: 50px 20px;
        }
        
        .spinner-border {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            border: 0.25em solid currentColor;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spinner-border 0.75s linear infinite;
        }
        
        @keyframes spinner-border {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive pagination */
        @media (max-width: 768px) {
            .pagination {
                flex-wrap: wrap;
                gap: 3px;
            }
            
            .page-link {
                min-width: 35px;
                height: 35px;
                padding: 6px 8px;
                font-size: 14px;
            }
            
            .pagination-info {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Quick Filter Styles */
        .quick-filters-container {
            margin-top: 20px;
        }

        .service-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .filter-actions {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }


    

       

        .service-list li {
            list-style: none;
        }

        .service-list .quick-filter {
            display: inline-block;
            padding: 8px 16px;
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            color: #495057;
            text-decoration: none;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

      
        /* Responsive quick filters */
        @media (max-width: 768px) {
            .service-list {
                gap: 8px;
            }
            
            .service-list .quick-filter {
                padding: 6px 12px;
                font-size: 13px;
            }
        }

        /* Equipment Show More Button */
        .equipment-toggle {
            text-align: center;
            margin-top: 15px;
        }

        .show-more-equipment {
            padding: 8px 20px;
            border: 2px solid #000000;
            background: #fff;
            color: #030303;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }



        .show-more-equipment:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }


        .equipment-item input[type="checkbox"] {
            margin-right: 8px;
        }

        /* Loading animation */
        .fa-spinner.fa-spin {
            animation: fa-spin 1s infinite linear;
        }

        @keyframes fa-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Selected Filters Bar - AutoScout24 Style */
        .selected-filters-bar {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }

        .selected-filters-container {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .selected-filters-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #6c757d;
            white-space: nowrap;
            font-size: 14px;
        }

        .selected-filters-label i {
            color: #6c757d;
            font-size: 16px;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .selected-filters-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            flex: 1;
        }

        .selected-filter-tag {
            display: inline-flex;
            align-items: center;
            background: #ffffff;
            color: #495057;
            padding: 6px 10px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 500;
            gap: 6px;
            margin: 3px;
            border: 1px solid #dee2e6;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .selected-filter-tag.multi-select {
            background: #ffffff;
            padding: 8px 12px;
            border-radius: 18px;
        }

        .selected-filter-tag .filter-name {
            font-weight: 600;
            white-space: nowrap;
        }

        .selected-filter-tag .filter-value {
            font-weight: 400;
        }

        .filter-values-box {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            align-items: center;
        }

        .filter-value-item {
            background: #dee2e6;
            color: #495057;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 500;
            white-space: nowrap;
            border: 1px solid #ced4da;
        }

        .remove-filter-btn {
            background: none;
            border: none;
            color: #6c757d;
            padding: 2px 4px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
        }

        .remove-filter-btn:hover {
            background: #dee2e6;
            color: #495057;
        }

        .selected-filters-actions {
            margin-left: auto;
        }

        .clear-all-filters-btn {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 12px;
            background: #6c757d;
            color: #fff;
            border: 1px solid #6c757d;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: 500;
        }

        .clear-all-filters-btn:hover {
            background: #5a6268;
            border-color: #545b62;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .selected-filters-container {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .selected-filters-actions {
                margin-left: 0;
                width: 100%;
            }
            
            .clear-all-filters-btn {
                width: 100%;
                justify-content: center;
            }
            
            .selected-filters-list {
                width: 100%;
            }
        }
    </style>
@endpush