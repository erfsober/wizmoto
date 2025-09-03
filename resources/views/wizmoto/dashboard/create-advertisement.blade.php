@extends('wizmoto.dashboard.master')
@section('dashboard-content')
    <div class="content-column">
        <div class="inner-column">
            <div class="list-title">
                <h3 class="title">Create advertisement</h3>
            </div>
            <div class="form-box">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Vehicle Details</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form class="row" action="{{ route('dashboard.store-advertisement') }}" method="POST" id="advertisementForm">
                            @csrf
                            <input type="hidden" name="provider_id" value="{{$provider->id}}">
                            {{--Vehicle data--}}
                            <h6>Vehicle data</h6>
                            <div class="form-column col-lg-12">
                                <span class="error-text text-red-600 text-sm mt-1 block"></span>
                                <div class="form_boxes">
                                    <label>Sell</label>
                                    <div class="drop-menu" id="advertisement-type-dropdown">
                                        <div class="select">
                                            <span>Select What you want to sell</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="advertisement_type_id" id="advertisement_type_id_input">
                                        <ul class="dropdown" style="display: none;">
                                            @foreach($advertisementTypes as $advertisementType)
                                                <li data-id="{{ $advertisementType->id }}">{{$advertisementType->title}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <span class="error-text text-red-600 text-sm mt-1 block"></span>
                                <div class="form_boxes">
                                    <label>Brand</label>
                                    <div class="drop-menu" id="brand-dropdown">
                                        <div class="select">
                                            <span>Select Brand</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="brand_id" id="brand_id_input">
                                        <ul class="dropdown" style="display: none;">
                                            {{--                                            @foreach($brands as $brand)--}}
                                            {{--                                                <li data-id="{{ $brand->id }}">{{$brand->name}}</li>--}}
                                            {{--                                            @endforeach--}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <span class="error-text text-red-600 text-sm mt-1 block"></span>
                                <div class="form_boxes">
                                    <label>Model</label>
                                    <div class="drop-menu" id="model-dropdown">
                                        <div class="select">
                                            <span>Select</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="vehicle_model_id" id="vehicle_model_id_input">
                                        <ul class="dropdown" style="display: none;" id="model-select">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Version</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="version_model">
                                    </div>
                                </div>
                            </div>
                            <hr class="my-5"/>
                            {{--Characteristics--}}
                            <h6>Characteristics</h6>
                            <div class="form-column col-lg-6">
                                <span class="error-text text-red-600 text-sm mt-1 block"></span>
                                <div class="form_boxes">
                                    <label>BodyWork</label>
                                    <div class="drop-menu" id="vehicle_body-dropdown">
                                        <div class="select">
                                            <span>Select BodyWork</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="vehicle_body_id">
                                        <ul class="dropdown" style="display: none;">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-12">
                                <div class="form_boxes">
                                    <label>Exterior color</label>
                                    <div class="color-picker">
                                        @foreach($vehicleColors as $color)
                                            <div class="color-item">
                                                <input type="radio"
                                                       id="color-{{ $color->id }}"
                                                       name="color_id"
                                                       value="{{ $color->id }}">
                                                <label for="color-{{ $color->id }}" class="color-circle"
                                                       style="background-color: {{ $color->hex_code }}"></label>
                                                <span class="color-label">{{ $color->name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="cheak-box">
                                    <label class="contain">Metallic Paint
                                        <input type="checkbox" name="is_metallic_paint">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <hr class="my-5"/>
                            {{-- State--}}
                            <h6>State</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>Vehicle Category</label>
                                    <div class="drop-menu" id="vehicle-category-dropdown">
                                        <div class="select">
                                            <span>Select Vehicle Category</span>
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
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Mileage(Km)</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="mileage" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Registration Month</label>
                                        <div class="drop-menu" id="registration-month-dropdown">
                                            <div class="select">
                                                <span>Selection</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="registration_month">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach(range(1,12) as $m)
                                                    <li data-id="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Registration Year</label>
                                        <div class="drop-menu" id="registration-year-dropdown">
                                            <div class="select">
                                                <span>Selection</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="registration_year">
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
                            </div>
                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Next review Year</label>
                                        <div class="drop-menu" id="next-review-dropdown">
                                            <div class="select">
                                                <span>Selection</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="next_review_month">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach(range(1,12) as $m)
                                                    <li data-id="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Next review Year</label>
                                        <div class="drop-menu" id="next-review-year-dropdown">
                                            <div class="select">
                                                <span>Selection</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="next_review_year">
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
                            </div>
                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Last Service Year</label>
                                        <div class="drop-menu" id="last-service-dropdown">
                                            <div class="select">
                                                <span>Selection</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="last_service_month">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach(range(1,12) as $m)
                                                    <li data-id="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Last Service Year</label>
                                        <div class="drop-menu" id="last-service-year-dropdown">
                                            <div class="select">
                                                <span>Selection</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="last_service_year">
                                            <ul class="dropdown" style="display: none;">
                                                @php
                                                    $currentYear = date('Y');
                                                @endphp
                                                @for($y = $currentYear; $y >= 1990; $y--)
                                                    <li data-id="{{$y}}">{{ $y }}</li>
                                                @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="btn-box">
                                    <label>Previous Owners</label>
                                    <div class="number" style="padding: 10px">
                                        <span class="minus">-</span>
                                        <input type="text" value="1" name="previous_owners">
                                        <span class="plus">+</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-12 my-5">
                                <div class="cheak-box">
                                    <label class="contain">Coupon Documentation
                                        <input type="checkbox" name="coupon_documentation">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-column col-lg-12 mb-5">
                                <div class="cheak-box">
                                    <label class="contain">Damaged Vehicle
                                        <input type="checkbox" name="damaged_vehicle">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <hr class="my-5"/>
                            {{-- Equipment--}}
                            <h6>Equipment</h6>
                            <div class="form-column col-lg-12 mb-5">
                                <div class="cheak-box">
                                    <div class="equipment-list" style="display: flex; flex-wrap: wrap; gap: 40px;">

                                    </div>
                                </div>
                            </div>
                            <hr class="my-5"/>

                            {{-- Motor--}}
                            <h6>Motor</h6>
                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Change</label>
                                        <div class="drop-menu" id="motor-change-dropdown">
                                            <div class="select">
                                                <span>Selection</span>
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
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Power Kw</label>
                                    <div class="drop-menu active">
                                        <input name="motor_power_kw" type="number"  placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Power Cv</label>
                                    <div class="drop-menu active">
                                        <input name="motor_power_cv" type="number"  placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="form-column col-lg-6 mb-5">
                                <div class="btn-box">
                                    <label>Marches</label>
                                    <div class="number" style="padding: 10px">
                                        <span class="minus">-</span>
                                        <input type="text" value="1" name="motor_marches">
                                        <span class="plus">+</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-column col-lg-6 mb-5">
                                <div class="btn-box">
                                    <label>Cylinders</label>
                                    <div class="number" style="padding: 10px">
                                        <span class="minus">-</span>
                                        <input type="text" value="1" name="motor_cylinders">
                                        <span class="plus">+</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Displacement (cc)</label>
                                        <div class="drop-menu" id="motor-displacement-dropdown">
                                            <input type="text" name="motor_displacement" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Empty Weight (KG)</label>
                                        <div class="drop-menu" id="motor-empty-weight-dropdown">
                                            <input type="text" name="motor_empty_weight" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Environment--}}
                            <h6>Environment</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>Fuel type</label>
                                    <div class="drop-menu" id="fuel-type-dropdown">
                                        <div class="select">
                                            <span>Select Fuel type</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="fuel_type_id">
                                        <ul class="dropdown" style="display: none;">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Combined fuel consumption</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="combined_fuel_consumption" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Combined cycle CO2 emissions</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="co2_emissions">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>Emissions class</label>
                                    <div class="drop-menu" id="emissions_class-dropdown">
                                        <div class="select">
                                            <span>Selection</span>
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
                            {{--Photo--}}
                            <h6>Photo</h6>
                            <div class="gallery-sec style1" id="media">
                                <div id="gallery-overlay" class="gallery-overlay" style="display:none;">
                                    <span class="lnr-icon-spinner spinner" style="font-size: 52px"></span>
                                </div>
                                <div class="right-box-three">
                                    <h6 class="title">Gallery
                                    </h6>
                                    <div class="gallery-box">
                                        <div class="inner-box" id="preview-container">

                                            <div class="uplode-box">
                                                <div class="content-box">
                                                    <a href="#" id="uploadTrigger">
                                                        <img src="{{asset('wizmoto/images/resource/uplode.svg')}}">
                                                        <span>Upload</span>
                                                    </a>
                                                    <input type="file" name="images[]" id="fileInput" multiple style="display:none">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text">You can upload a maximum of 5 images. Please only upload images in JPEG or PNG format</div>
                                    </div>
                                </div>
                            </div>
                            {{--Vehicle description--}}
                            <h6>Vehicle description</h6>
                            <div class="form-column col-lg-12">
                                <div class="form_boxes v2">
                                    <label>Vehicle description</label>
                                    <div class="drop-menu active">
                                        <textarea name="description" placeholder=""></textarea>
                                    </div>
                                </div>
                            </div>
                            {{--price--}}
                            <h6>Final Price</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Final Price</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="final_price">
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
                            <div class="form-column col-lg-12">
                                <div class="cheak-box">
                                    <label class="contain">Price Negotiable
                                        <input type="checkbox" name="price_negotiable">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <hr class="mt-5">
                            {{--price--}}
                            <h6>Contact</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>ZIP Code</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="zip_code">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>City</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="city">
                                    </div>
                                </div>
                            </div>

                            <div class="form-column col-lg-4">
                                <div class="form_boxes">
                                    <label>International prefix</label>
                                    <div class="drop-menu" id="international-prefix-dropdown">
                                        <div class="select">
                                            <span>Select International prefix</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="international_prefix" id="international_prefix_input">
                                        <ul class="dropdown" style="display: none;">
                                            @foreach($internationalPrefixes as $internationalPrefix)
                                                <li data-id="{{ $internationalPrefix }}">{{$internationalPrefix}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-4">
                                <div class="form_boxes v2">
                                    <label>Prefix</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="prefix">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-4">
                                <div class="form_boxes v2">
                                    <label>Telephone</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="telephone">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-12">
                                <div class="cheak-box">
                                    <label class="contain">Display your phone number in your listing as a contact option?
                                        <input type="checkbox" name="show_phone">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-submit">
                                    <button type="submit" class="theme-btn">Submit
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <g clip-path="url(#clip0_711_3214)">
                                                <path d="M13.6106 0H5.05509C4.84013 0 4.66619 0.173943 4.66619 0.388901C4.66619 0.603859 4.84013 0.777802 5.05509 0.777802H12.6719L0.113453 13.3362C-0.0384687 13.4881 -0.0384687 13.7342 0.113453 13.8861C0.189396 13.962 0.288927 14 0.388422 14C0.487917 14 0.587411 13.962 0.663391 13.8861L13.2218 1.3277V8.94447C13.2218 9.15943 13.3957 9.33337 13.6107 9.33337C13.8256 9.33337 13.9996 9.15943 13.9996 8.94447V0.388901C13.9995 0.173943 13.8256 0 13.6106 0Z" fill="white"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_711_3214">
                                                    <rect width="14" height="14" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <span class="lnr-icon-spinner spinner" style="display:none;"></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        /* Spinner animation */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .lnr-icon-spinner.spinner {
            display: inline-block;
            animation: spin 1s linear infinite;
            font-size: 16px; /* adjust size to match your button */
            margin-left: 8px; /* optional spacing */
        }

        .input-error,
        .drop-menu-error {
            border: 1px solid #dc2626 !important; /* red border */
            border-radius: 4px;
            padding: 10px; /* adjust as needed */
        }

        /* Error message below form box */
        .error-text {
            font-size: 0.875rem; /* small */
            color: #dc2626; /* red */
            display: block;
            margin-top: 4px;
        }

        #preview-container {
            align-items: center;
        }

        /* Wrapper for each uploaded image */
        #preview-container .image-box {
            position: relative;
            width: 180px; /* fixed width */
            height: 180px; /* fixed height */
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 8px;
            background: #f5f5f5; /* background for better look */
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Image scaling nicely inside box */
        #preview-container .image-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover; /* fills box without distortion */
            border-radius: 6px;
        }

        #preview-container .image-box .content-box {

            top: 20%;
            left: 80%;
        }

        .color-picker {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 40px; /* horizontal and vertical gaps */
            width: 100%; /* or any width that fits two items side by side */

        }

        .color-item {
            flex: 1 1 45%; /* flex-grow:1, flex-shrink:1, flex-basis:50% */
            display: flex;
            align-items: center;
            width: 50%; /* two items per row */
            gap: 10px;
        }

        .color-picker input[type="radio"] {
            display: none;
        }

        .color-circle {
            position: relative;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: inline-block;
            z-index: 1;
            border: 2px solid #999;
        }

        .color-circle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 12px; /* inner circle size */
            height: 12px;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .color-picker input[type="radio"]:checked + .color-circle::after {
            opacity: 1;
        }

        .color-label {
            font-size: 14px;
            user-select: none;
        }
    /*    loading*/
        .gallery-sec {
            position: relative; /* container for overlay */
        }

        .gallery-overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(255,255,255,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }
    </style>
@endpush
@push('scripts')
    <script>

        $('#brand-dropdown ul.dropdown').on('click', 'li', function () {
            let brandId = $(this).data('id');
            loadModels(brandId);
        });

        // Handle brand selection
        function loadModels(brandId) {
            let url = "{{ route('vehicle-models.get-models-based-on-brand', ':brandId') }}";
            url = url.replace(':brandId', brandId);

            $('#model-dropdown .select span').text('Select');
            $('#vehicle_model_id_input').val('');
            $('#model-dropdown ul.dropdown').empty();

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (models) {

                    let $modelDropdown = $('#model-dropdown ul.dropdown');
                    $modelDropdown.empty();

                    if (models.length === 0) {
                        $modelDropdown.append('<li>No models available</li>');
                    } else {
                        $.each(models, function (index, model) {

                            $modelDropdown.append('<li data-id="' + index + '">' + model + '</li>');
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching models:', error);
                }
            });
        }


        $('#advertisement-type-dropdown ul.dropdown').on('click', 'li', function () {
            let advertisementTypeId = $(this).data('id');
            loadAdvertisementData(advertisementTypeId);
        });

        function loadAdvertisementData(adTypeId) {
            let url = "{{ route('vehicle-models.get-data', ':id') }}";
            url = url.replace(':id', adTypeId);

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (data) {

                    // ------------------------
                    // Populate Brand Dropdown
                    // ------------------------
                    let $brandDropdown = $('#brand-dropdown ul.dropdown');
                    $brandDropdown.empty();
                    $('#brand-dropdown .select span').text('Select Brand');
                    $('#brand_id_input').val('');

                    if (data.brands.length === 0) {
                        $brandDropdown.append('<li>No brands available</li>');
                    } else {
                        $.each(data.brands, function (index, brand) {
                            $brandDropdown.append('<li data-id="' + brand.id + '">' + brand.name + '</li>');
                        });
                    }

                    // ------------------------
                    // Populate Vehicle Body Dropdown
                    // ------------------------
                    let $bodyDropdown = $('#vehicle_body-dropdown ul.dropdown');
                    $bodyDropdown.empty();
                    $('#vehicle_body-dropdown .select span').text('Select BodyWork');
                    $('input[name="vehicle_body_id"]').val('');

                    if (data.vehicleBodies.length === 0) {
                        $bodyDropdown.append('<li>No BodyWorks available</li>');
                    } else {
                        $.each(data.vehicleBodies, function (index, body) {
                            $bodyDropdown.append('<li data-id="' + body.id + '">' + body.name + '</li>');
                        });
                    }

                    // ------------------------
                    // Populate Equipments
                    // ------------------------
                    let $equipmentList = $('.equipment-list');
                    $equipmentList.empty();
                    $.each(data.equipments, function (index, equipment) {
                        let equipmentItem = `
                    <label class="contain">
                        ${equipment.name}
                        <input type="checkbox" name="equipments[]" value="${equipment.id}">
                        <span class="checkmark"></span>
                    </label>`;
                        $equipmentList.append(equipmentItem);
                    });

                    // ------------------------
                    // Populate Fuel Types Dropdown
                    // ------------------------
                    let $fuelDropdown = $('#fuel-type-dropdown ul.dropdown');
                    $fuelDropdown.empty();
                    $('#fuel-type-dropdown .select span').text('Select Fuel type');
                    $('input[name="fuel_type_id"]').val('');

                    if (data.fuelTypes.length === 0) {
                        $fuelDropdown.append('<li>No Fuel types available</li>');
                    } else {
                        $.each(data.fuelTypes, function (index, fuel) {
                            $fuelDropdown.append('<li data-id="' + fuel.id + '">' + fuel.name + '</li>');
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching advertisement data:', error);
                }
            });
        }

    </script>
    <script>
        $(document).ready(function () {
            const selectedFiles = [];

            // Upload button
            $("#uploadTrigger").click(function (e) {
                e.preventDefault();
                $("#fileInput").click();
                if (selectedFiles.length === 4) {
                    $(".uplode-box").hide(); // hide upload box
                }
            });

            // File select
            $("#fileInput").on("change", function (e) {
                if (selectedFiles.length >= 5) {
                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        title: 'You can upload a maximum of 5 images.',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return;
                }

                Array.from(this.files).forEach(file => {
                    selectedFiles.push(file);
                    const reader = new FileReader();
                    $("#media").addClass("loading");
                    $("#media .gallery-overlay").show();

                    let index = selectedFiles.length - 1;

                    reader.onload = function (event) {
                        const div = $(`
                    <div class="image-box" data-index="${index}">
                        <img src="${event.target.result}" alt="preview" data-filename="${file.name}" alt="${file.name}">
                        <div class="content-box">
                            <ul class="social-icon">
                                <li>
                                    <a href="#" class="delete-btn">
                                        <img src="{{ asset('wizmoto/images/resource/delet.svg') }}">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <input type="hidden" name="images_order[]" value="${file.name}">
                    </div>
                `);

                        $("#preview-container").find(".uplode-box").before(div);
                    };
                    $("#media").removeClass("loading");
                    $("#media .gallery-overlay").hide();                    reader.readAsDataURL(file);
                });
                $(this).val("");
            });

            // Delete handler
            $("#preview-container").on("click", ".delete-btn", function (e) {
                e.preventDefault();
                const box = $(this).closest(".image-box");
                const index = box.data("index");
                box.remove();

                // Remove the file from array
                selectedFiles.splice(index, 1);
                if (selectedFiles.length < 5) {
                    $(".uplode-box").show(); // show upload box again
                }
                // Re-sync indexes on remaining previews
                $("#preview-container .image-box").each(function (i) {
                    $(this).attr("data-index", i);
                });
            });

            // Make images sortable but **upload box fixed**
            $("#preview-container").sortable({
                items: ".image-box",        // only image boxes are draggable
                cancel: ".uplode-box",      // upload box cannot be dragged
                placeholder: "image-box-placeholder",
                tolerance: "pointer",       // makes drag smooth
                helper: "clone",            // avoids element sticking
                start: function (e, ui) {
                    ui.placeholder.height(ui.item.height());
                    ui.placeholder.width(ui.item.width());
                }
            }).disableSelection();

            $("#advertisementForm").submit(function (e) {
                e.preventDefault();
                const btn = $(this).find("button[type='submit']");
                btn.prop('disabled', true);
                btn.contents().filter(function () {
                    return !$(this).hasClass('spinner');
                }).hide();
                btn.find(".spinner").show();
                const formData = new FormData(this);

                $("#preview-container .image-box").each(function() {
                    const filename = $(this).find("img").data("filename"); // ✅ get actual file name
                    const file = selectedFiles.find(f => f.name ===filename); // ✅ find corresponding file
                    if (file) {
                        formData.append('images[]', file); // ✅ append in the correct order
                    }
                });

                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        btn.contents().show();
                        btn.find(".spinner").hide();
                        btn.prop('disabled', false);
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'advertisement created successfully!',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    },
                    error: function (xhr) {
                        btn.contents().show();
                        btn.find(".spinner").hide();
                        btn.prop('disabled', false);
                        $('.error-text').text('');
                        $('.input-error, .drop-menu-error').removeClass('input-error drop-menu-error');

                        if (xhr.status === 422) {
                            showValidationErrors(xhr.responseJSON.errors);

                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong!',
                                text: 'Please try again later.'
                            });
                        }
                    }
                });
            });
        });

        function showValidationErrors(errors) {
            // Clear previous
            $('.error-text').text('');
            $('.input-error, .drop-menu-error').removeClass('input-error drop-menu-error');

            for (let field in errors) {
                let $input = $('[name="' + field + '"]');
                let $formBox = $input.closest('.form_boxes');

                // Show error message below form box
                // $formBox.closest('.form-column').find('.error-text').text(errors[field][0]);
                Swal.fire({
                    toast: true,
                    icon: 'error',
                    title: errors[field][0],
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                // Highlight form box
                if ($input.attr('type') === 'hidden') {
                    $formBox.addClass('drop-menu-error'); // dropdowns
                } else {
                    $formBox.addClass('input-error');     // text inputs
                }
            }

            // Scroll to first error
            let $firstError = $('.input-error, .drop-menu-error').first();
            if ($firstError.length) {
                $('html, body').animate({
                    scrollTop: $firstError.offset().top - 50
                }, 500);
            }
        }

    </script>

@endpush
