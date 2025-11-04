@extends('master')
@section('content')
@include('wizmoto.partials.inner-header')

    <!-- cars-section-three -->
    <section class="cars-section-thirteen layout-radius">
        <div class="boxcar-container">
            <div class="boxcar-title-three wow fadeInUp">
                <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li><span>{{ __('messages.filtered_list') }}</span></li>
                </ul>
                <h2>{{ __('messages.what_kind_motorcycle') }}</h2>
                
                <!-- Selected Filters Bar -->
                <div class="selected-filters-bar" id="selected-filters-bar" style="display: none;">
                    <div class="selected-filters-container">
                        <div class="selected-filters-label">
                            <i class="fa fa-filter"></i>
                            <span>{{ __('messages.active_filters') }}:</span>
                        </div>
                        <div class="selected-filters-list" id="selected-filters-list">
                            <!-- Selected filters will be dynamically added here -->
                        </div>
                        <div class="selected-filters-actions">
                            <button type="button" class="clear-all-filters-btn">
                                <i class="fa fa-times"></i> {{ __('messages.clear_all') }}
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
                        {{ __('messages.show_filter') }} 
                    </div>
                    <div class="inventory-sidebar">
                        <div class="inventroy-widget widget-location">
                            <div class="row">
                                <!-- Main Data & Location Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">{{ __('messages.main_data_location') }}</h6>
                                    </div>
                                    <div class="filter-section-content">
                                        <div class="row">
                                            <!-- Vehicle Search Group -->
                                            <div class="vehicle-search-group" data-group="0">
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                        <label>{{ __('messages.vehicle_category') }}</label>
                                        <div class="drop-menu" id="advertisement-type-dropdown">
                                            <div class="select">
                                                <span>{{ __('messages.select_category') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="advertisement_type" class="advertisement_type_input">
                                            <ul class="dropdown" style="display: none;">
                                                <li data-id="">{{ __('messages.any_category') }}</li>
                                                @foreach ($advertisementTypes as $type)
                                                    <li data-id="{{ $type->id }}">{{ $type->localized_title }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                                        <label>{{ __('messages.brand') }}</label>
                                                        <div class="drop-menu searchable-dropdown" id="brand-dropdown">
                                            <div class="select">
                                                                <span>{{ __('messages.any_brands') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                            <input type="hidden" name="brand_id[]" class="brand_id_input">
                                            <ul class="dropdown" style="display: none;">
                                                                <li data-id="" class="clear-option">{{ __('messages.any_brands') }}</li>
                                                                @foreach ($brands as $brand)
                                                                    <li data-id="{{ $brand->id }}">{{ $brand->localized_name }}
                                                                    </li>
                                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                                        <label>{{ __('messages.model') }}</label>
                                                        <div class="drop-menu searchable-dropdown" id="model-dropdown">
                                            <div class="select">
                                                                <span>{{ __('messages.any_model') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                            <input type="hidden" name="vehicle_model_id[]"
                                                                class="vehicle_model_id_input">
                                                            <ul class="dropdown" style="display: none;" id="model-select">
                                                                <li data-id="" class="clear-option">{{ __('messages.any_model') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form_boxes v2">
                                                        <label>{{ __('messages.version') }}</label>
                                                        <div class="drop-menu active">
                                                            <input type="text" name="version_model[]"
                                                                placeholder="{{ __('messages.enter_version') }}">
                                            </div>
                                        </div>
                                    </div>
                                                <button type="button" class="remove-vehicle-group first-group-remove"
                                                    title="{{ __('messages.remove_this_vehicle') }}" style="display: none;">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                </div>
    
                                            <!-- Add Vehicle Button - Outside the box -->
                                            <div class="col-lg-12 mb-5">
                                                <div class="add-vehicle-group">
                                                    <button type="button" class="add-vehicle-btn">
                                                        <i class="fa fa-plus"></i>
                                                        {{ __('messages.add_another_vehicle') }}
                                                    </button>
                                                </div>
                                            </div>
    
                                            <!-- Body Work -->
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                                    <label>{{ __('messages.body_work') }}</label>
                                                    <div class="drop-menu searchable-dropdown" id="body-dropdown">
                                            <div class="select">
                                                            <span>{{ __('messages.any_body_work') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="vehicle_body_id">
                                            <ul class="dropdown" style="display: none;">
                                                            <li data-id="" class="clear-option">{{ __('messages.any_body_work') }}</li>
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
                                                    <label>{{ __('messages.fuel_type') }}</label>
                                                    <div class="drop-menu searchable-dropdown" id="fuel-dropdown">
                                            <div class="select">
                                                            <span>{{ __('messages.any_fuel_type') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="fuel_type_id">
                                            <ul class="dropdown" style="display: none;">
                                                            <li data-id="" class="clear-option">{{ __('messages.any_fuel_type') }}</li>
                                                            @foreach ($fuelTypes as $fuelType)
                                                                <li data-id="{{ $fuelType->id }}">{{ $fuelType->localized_name }}</li>
                                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
    
                                            <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>{{ __('messages.register_year') }}</label>
                                                    <div class="drop-menu" id="registration-year-dropdown">
                                            <div class="select">
                                                            <span>{{ __('messages.from') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="registration_year_from">
                                            <ul class="dropdown" style="display: none;">
                                                            <li data-id="">{{ __('messages.any_year') }}</li>
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
                                                    <label>{{ __('messages.register_year') }}</label>
                                                    <div class="drop-menu" id="registration-year-to-dropdown">
                                            <div class="select">
                                                            <span>{{ __('messages.to') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="registration_year_to">
                                            <ul class="dropdown" style="display: none;">
                                                            <li data-id="">{{ __('messages.any_year') }}</li>
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
                                                    <label>{{ __('messages.mileage_from') }}</label>
                                                    <div class="drop-menu active">
                                                        <input type="text" name="mileage_from" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form_boxes v2">
                                                    <label>{{ __('messages.mileage_to') }}</label>
                                                    <div class="drop-menu active">
                                                        <input type="text" name="mileage_to" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
    
                                            <!-- Power -->
                                <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>{{ __('messages.power_cv') }}</label>
                                                    <div class="drop-menu" id="power-cv-from-dropdown">
                                            <div class="select">
                                                            <span>{{ __('messages.from') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="power_cv_from">
                                            <ul class="dropdown" style="display: none;">
                                                            <li data-id="">{{ __('messages.any') }}</li>
                                                            @for ($cv = 10; $cv <= 500; $cv += 10)
                                                                <li data-id="{{ $cv }}">{{ $cv }} {{ __('messages.cv') }}</li>
                                                            @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                            <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>{{ __('messages.power_cv') }}</label>
                                                    <div class="drop-menu" id="power-cv-to-dropdown">
                                            <div class="select">
                                                            <span>{{ __('messages.to') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="power_cv_to">
                                            <ul class="dropdown" style="display: none;">
                                                            <li data-id="">{{ __('messages.any') }}</li>
                                                            @for ($cv = 10; $cv <= 500; $cv += 10)
                                                                <li data-id="{{ $cv }}">{{ $cv }} {{ __('messages.cv') }}</li>
                                                            @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>{{ __('messages.power_kw') }}</label>
                                                    <div class="drop-menu" id="power-kw-from-dropdown">
                                            <div class="select">
                                                            <span>{{ __('messages.from') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="power_kw_from">
                                            <ul class="dropdown" style="display: none;">
                                                            <li data-id="">{{ __('messages.any') }}</li>
                                                            @for ($kw = 5; $kw <= 400; $kw += 5)
                                                                <li data-id="{{ $kw }}">{{ $kw }} KW</li>
                                                            @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>{{ __('messages.power_kw') }}</label>
                                                    <div class="drop-menu" id="power-kw-to-dropdown">
                                                        <div class="select">
                                                            <span>{{ __('messages.to') }}</span>
                                                            <i class="fa fa-angle-down"></i>
                                                    </div>
                                                        <input type="hidden" name="power_kw_to">
                                                        <ul class="dropdown" style="display: none;">
                                                            <li data-id="">{{ __('messages.any') }}</li>
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
                                                    <label>{{ __('messages.transmission') }}</label>
                                                    <div class="multi-select-container">
                                                        <div class="selected-options">
                                                            <!-- Selected options will appear here -->
                                                        </div>
                                                        <div class="multi-select-dropdown">
                                                            <div class="multi-select-list">
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="motor_change[]"
                                                                        value="manual">
                                                <span class="checkmark"></span>
                                                                    {{ __('messages.manual') }}
                                            </label>
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="motor_change[]"
                                                                        value="automatic">
                                                <span class="checkmark"></span>
                                                                    {{ __('messages.automatic') }}
                                            </label>
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="motor_change[]"
                                                                        value="semi-automatic">
                                                <span class="checkmark"></span>
                                                                    {{ __('messages.semi_automatic') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                        </div>
                                    </div>
    
                                            <!-- Number of Cylinders -->
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                                    <label>{{ __('messages.number_of_cylinders') }}</label>
                                                    <div class="drop-menu" id="cylinders-dropdown">
                                            <div class="select">
                                                            <span>{{ __('messages.select_cylinders') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                                        <input type="hidden" name="cylinders">
                                            <ul class="dropdown" style="display: none;">
                                                            <li data-id="">{{ __('messages.any') }}</li>
                                                            <li data-id="1">1 {{ __('messages.cylinder') }}</li>
                                                            <li data-id="2">2 {{ __('messages.cylinders') }}</li>
                                                            <li data-id="3">3 {{ __('messages.cylinders') }}</li>
                                                            <li data-id="4">4 {{ __('messages.cylinders') }}</li>
                                                            <li data-id="6">6 {{ __('messages.cylinders') }}</li>
                                                            <li data-id="8">8 {{ __('messages.cylinders') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
    
                                            <!-- Engine Displacement Range -->
                                            <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>{{ __('messages.displacement_from') }}</label>
                                                    <input type="text" name="motor_displacement_from" placeholder="">
                                            </div>
                                        </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>{{ __('messages.displacement_to') }}</label>
                                                    <input type="text" name="motor_displacement_to" placeholder="">
                                    </div>
                                </div>
    
                                            <!-- Price Range -->
                                            <div class="col-lg-6">
                                    <div class="form_boxes">
                                                    <label>{{ __('messages.price_from') }} ($)</label>
                                                    <input type="text" name="price_from" placeholder="">
                                            </div>
                                        </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>{{ __('messages.price_to') }} ($)</label>
                                                    <input type="text" name="price_to" placeholder="">
                                    </div>
                                </div>
    
                                            <!-- Vehicle Conditions -->
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                                    <label>{{ __('messages.vehicle_conditions') }}</label>
                                                    <div class="multi-select-container">
                                                        <div class="selected-options">
                                                            <!-- Selected options will appear here -->
                                            </div>
                                                        <div class="multi-select-dropdown">
                                                            <div class="multi-select-list">
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="vehicle_category[]"
                                                                        value="used">
                                                <span class="checkmark"></span>
                                                                    {{ __('messages.used') }}
                                            </label>
                                                                <label class="multi-select-item">
                                                                    <input type="checkbox" name="vehicle_category[]"
                                                                        value="era">
                                                <span class="checkmark"></span>
                                                                    {{ __('messages.era') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                                            <!-- Village/City -->
                                            <div class="col-lg-12">
                                                <div class="form_boxes">
                                                    <label>{{ __('messages.village_city') }}</label>
                                                    <div class="drop-menu" id="city-dropdown">
                                        <div class="select">
                                                            <span>{{ __('messages.select_city') }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                                        <input type="hidden" name="city">
                                        <ul class="dropdown" style="display: none;">
                                                            <li data-id="">{{ __('messages.any_city') }}</li>
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
                                                    <label>{{ __('messages.zip_code') }}</label>
                                                    <div class="drop-menu active">
                                                        <input type="text" name="zip_code" placeholder="">
                                </div>
                                                </div>
                                            </div>
    
                                            <!-- Radius -->
                                            <div class="col-lg-12">
                                                <div class="form_boxes v2">
                                                    <label>{{ __('messages.search_radius') }} (km)</label>
                                                    <div class="drop-menu active">
                                                        <input type="text" name="search_radius" placeholder="">
                                                </div>
                                            </div>
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                            
                                <!-- Seller Type Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">{{ __('messages.seller_type') }}</h6>
                                    </div>
                                    <div class="filter-section-content">
                                        <div class="col-lg-12">
                                            @foreach(\App\Enums\SellerTypeEnum::getOptions() as $value => $label)
                                                <div class="checkbox-container">
                                                    <div class="contain">
                                                        <input type="checkbox" name="seller_type[]" value="{{ $value }}" id="seller_type_{{ $value }}">
                                                        <span class="checkmark"></span>
                                                        <label for="seller_type_{{ $value }}">{{ $label }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Price Evaluation (AutoScout-style) -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">{{ __('messages.price_evaluation') }}</h6>
                                    </div>
                                    <div class="filter-section-content">
                                        <div class="checkbox-container">
                                            <div class="contain">
                                                <input type="checkbox" name="price_eval[]" value="Super Price" id="price_eval_super" data-label="{{ __('messages.top_offer') }}" aria-label="{{ __('messages.top_offer') }}">
                                                <span class="checkmark"></span>
                                                <label for="price_eval_super" title="{{ __('messages.top_offer') }}">
                                                    <span style="display:inline-block;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;color:#0E5C2F;background:#D5F2E3;">{{ __('messages.top_offer') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="checkbox-container">
                                            <div class="contain">
                                                <input type="checkbox" name="price_eval[]" value="Great Price" id="price_eval_great" data-label="{{ __('messages.good_price') }}" aria-label="{{ __('messages.good_price') }}">
                                                <span class="checkmark"></span>
                                                <label for="price_eval_great" title="{{ __('messages.good_price') }}">
                                                    <span style="display:inline-block;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;color:#1F7A3E;background:#E3F7EB;">{{ __('messages.good_price') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="checkbox-container">
                                            <div class="contain">
                                                <input type="checkbox" name="price_eval[]" value="Good Price" id="price_eval_good" data-label="{{ __('messages.fair_price') }}" aria-label="{{ __('messages.fair_price') }}">
                                                <span class="checkmark"></span>
                                                <label for="price_eval_good" title="{{ __('messages.fair_price') }}">
                                                    <span style="display:inline-block;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;color:#8A6D00;background:#FFF3CD;">{{ __('messages.fair_price') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="checkbox-container">
                                            <div class="contain">
                                                <input type="checkbox" name="price_eval[]" value="ND" id="price_eval_nd" data-label="{{ __('messages.no_rating') }}" aria-label="{{ __('messages.no_rating') }}">
                                                <span class="checkmark"></span>
                                                <label for="price_eval_nd" title="{{ __('messages.no_rating') }}">
                                                    <span style="display:inline-block;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;color:#6C757D;background:#E9ECEF;">{{ __('messages.no_rating') }}</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vehicle Condition Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">{{ __('messages.vehicle_condition') }}</h6>
                                    </div>
                                    <div class="filter-section-content">
                                        <div class="col-lg-12">
                                            <div class="checkbox-container">
                                                <div class="contain">
                                                    <input type="checkbox" name="service_history_available" id="service_history_available">
                                                    <span class="checkmark"></span>
                                                    <label for="service_history_available">{{ __('messages.service_history_available') }}</label>
                                                </div>
                                            </div>
                                            <div class="checkbox-container">
                                                <div class="contain">
                                                    <input type="checkbox" name="warranty_available" id="warranty_available">
                                                    <span class="checkmark"></span>
                                                    <label for="warranty_available">{{ __('messages.warranty_available') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Technical Specifications Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">{{ __('messages.technical_specifications') }}</h6>
                                    </div>
                                    <div class="filter-section-content row">
                                        <div class="col-lg-12">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.drive_type') }}</label>
                                                <div class="drop-menu" id="drive-type-dropdown">
                                                    <div class="select">
                                                        <span>{{ __('messages.select_drive_type') }}</span>
                                                        <i class="fa fa-angle-down"></i>
                                                    </div>
                                                    <input type="hidden" name="drive_type" class="drive_type_input">
                                                    <ul class="dropdown" style="display: none;">
                                                        <li data-value="">{{ __('messages.any') }} {{ __('messages.drive_type') }}</li>
                                                        <li data-value="chain">{{ __('messages.chain') }}</li>
                                                        <li data-value="belt">{{ __('messages.belt') }}</li>
                                                        <li data-value="shaft">{{ __('messages.shaft') }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.tank_capacity_from') }}</label>
                                                <div class="drop-menu active">
                                                    <input type="text" name="tank_capacity_from" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.tank_capacity_to') }}</label>
                                                <div class="drop-menu active">
                                                    <input type="text" name="tank_capacity_to" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.seat_height_from') }}</label>
                                                <div class="drop-menu active">
                                                    <input type="text" name="seat_height_from" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.seat_height_to') }}</label>
                                                <div class="drop-menu active">
                                                    <input type="text" name="seat_height_to" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.top_speed_from') }}</label>
                                                <div class="drop-menu active">
                                                    <input type="text" name="top_speed_from" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.top_speed_to') }}</label>
                                                <div class="drop-menu active">
                                                    <input type="text" name="top_speed_to" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.torque_from') }}</label>
                                                <div class="drop-menu active">
                                                    <input type="text" name="torque_from" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.torque_to') }}</label>
                                                <div class="drop-menu active">
                                                    <input type="text" name="torque_to" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sales Features Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">{{ __('messages.sales_features') }}</h6>
                                    </div>
                                    <div class="filter-section-content">
                                        <div class="col-lg-12">
                                            <div class="checkbox-container">
                                                <div class="contain">
                                                    <input type="checkbox" name="financing_available" id="financing_available">
                                                    <span class="checkmark"></span>
                                                    <label for="financing_available">{{ __('messages.financing_available') }}</label>
                                                </div>
                                            </div>
                                            <div class="checkbox-container">
                                                <div class="contain">
                                                    <input type="checkbox" name="trade_in_possible" id="trade_in_possible">
                                                    <span class="checkmark"></span>
                                                    <label for="trade_in_possible">{{ __('messages.trade_in_possible') }}</label>
                                                </div>
                                            </div>
                                            <div class="checkbox-container">
                                                <div class="contain">
                                                    <input type="checkbox" name="available_immediately" id="available_immediately">
                                                    <span class="checkmark"></span>
                                                    <label for="available_immediately">{{ __('messages.available_immediately') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                            
                                <!-- Equipment Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">{{ __('messages.equipment') }}</h6>
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
                                                            {{ $equipment->localized_name }}
                                                        </label>
                                                    @endforeach
                                </div>
                                                @if ($equipments->count() > 10)
                                                    <div class="equipment-toggle">
                                                        <button type="button" class="btn btn-outline-primary show-more-equipment" 
                                                                data-loaded="10" data-total="{{ $equipments->count() }}">
                                                            <i class="fa fa-plus"></i>
                                                            {{ __('messages.show_more_equipment', ['count' => 10]) }}
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
                                        <h6 class="title">{{ __('messages.characteristics') }}</h6>
                                                </div>
                                    <div class="filter-section-content">
                                        <div class="col-lg-12">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.exterior_color') }}</label>
                                                <div class="color-list">
                                                    @foreach ($vehicleColors as $color)
                                                        <label class="checkbox-item"
                                                            style="--box-color: {{ $color->hex_code }}">
                                                            <input type="checkbox" name="color_ids[]"
                                                                value="{{ $color->id }}">
                                                            <span class="checkmark"></span>
                                                            {{ $color->localized_name }}
                                                        </label>
                                                    @endforeach
                                            </div>
                                            </div>
                                                </div>
                                                
                                        <div class="col-lg-12">
    
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="is_metallic_paint" value="1">
                                                <span class="checkmark"></span>
                                                {{ __('messages.metallic_paint') }}
                                            </label>
                                                
                                            </div>
                                        </div>
                                    </div>
    
    
                                <!-- Vehicle Conditions Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">{{ __('messages.vehicle_conditions') }}</h6>
                                                </div>
                                    <div class="filter-section-content">
    
    
                                        <div class="col-lg-12">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.previous_owners') }}</label>
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
                                                <label>{{ __('messages.emissions_class') }}</label>
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
                                                    <label>{{ __('messages.co2_emissions_from') }}</label>
                                                    <input type="text" name="co2_emissions_from" class=""
                                                        placeholder="" >
                                </div>
                            </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>{{ __('messages.co2_emissions_to') }}</label>
                                                    <input type="text" name="co2_emissions_to" placeholder=""
                                                        >
                        </div>
                                </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>{{ __('messages.fuel_consumption_from') }}</label>
                                                    <input type="text" name="fuel_consumption_from" placeholder=""
                                                        >
                                                </div>
                                            </div>
    
                                            <div class="col-lg-6">
                                                <div class="form_boxes">
                                                    <label>{{ __('messages.fuel_consumption_to') }}</label>
                                                    <input type="text" name="fuel_consumption_to" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                            </div>
    
                                <!-- More Information Section -->
                                <div class="filter-section">
                                    <div class="filter-section-header">
                                        <h6 class="title">{{ __('messages.more_information') }}</h6>
                                                </div>
                                    <div class="filter-section-content">
                                        <div class="col-lg-12">
                                            <div class="form_boxes">
                                                <label>{{ __('messages.online_from') }}</label>
                                                <div class="drop-menu" id="online-from-dropdown">
                                                    <div class="select">
                                                        <span>{{ __('messages.select_period') }}</span>
                                                        <i class="fa fa-angle-down"></i>
                                            </div>
                                                    <input type="hidden" name="online_from_period">
                                                    <ul class="dropdown" style="display: none;">
                                                        <li data-id="">{{ __('messages.any_time') }}</li>
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
                                                    {{ __('messages.deductible_vat') }}
                                                </label>
                                </div>
                            </div>
                        </div>
                                </div>
                                                </div>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
                                                
                                            </div>
                    </div><!--widget end-->

                    <!-- Mobile Search/Show Results Button -->
                    <div class="mobile-show-results-btn d-lg-none" style="padding: 16px 20px; border-top: 1px solid #e0e0e0; background: white;">
                        <button type="button" class="btn btn-secondary w-100 mb-2" id="mobile-close-sidebar-btn" style="padding: 10px; font-size: 14px; font-weight: 600; border-radius: 8px; background: #f0f0f0; color: #333; border: none;">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary w-100" id="mobile-show-results-btn" style="padding: 14px; font-size: 16px; font-weight: 600; border-radius: 8px; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span id="mobile-results-text">{{ __('messages.show') }} <span id="mobile-results-count">{{ $advertisements->total() }}</span> {{ __('messages.results') }}</span>
                        </button>
                    </div>
                                        </div>
                <div class="col-xl-9 col-md-12 col-sm-12">
                    <div class="right-box">
                        <!-- Mobile Selected Filters Bar (Autoscout24 Style) -->
                        <div class="mobile-selected-filters-bar d-lg-none" style="margin-bottom: 16px;">
                            <div class="mobile-filters-header" style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <button type="button" class="mobile-filter-toggle-btn" id="mobile-filter-toggle-top" style="display: flex; align-items: center; gap: 8px; padding: 10px 16px; background: #405FF2; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.75 4.50903C13.9446 4.50903 12.4263 5.80309 12.0762 7.50903H2.25C1.83579 7.50903 1.5 7.84482 1.5 8.25903C1.5 8.67324 1.83579 9.00903 2.25 9.00903H12.0762C12.4263 10.715 13.9446 12.009 15.75 12.009C17.5554 12.009 19.0737 10.715 19.4238 9.00903H21.75C22.1642 9.00903 22.5 8.67324 22.5 8.25903C22.5 7.84482 22.1642 7.50903 21.75 7.50903H19.4238C19.0737 5.80309 17.5554 4.50903 15.75 4.50903ZM15.75 6.00903C17.0015 6.00903 18 7.00753 18 8.25903C18 9.51054 17.0015 10.509 15.75 10.509C14.4985 10.509 13.5 9.51054 13.5 8.25903C13.5 7.00753 14.4985 6.00903 15.75 6.00903Z" fill="white"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.25 12.009C6.44461 12.009 4.92634 13.3031 4.57617 15.009H2.25C1.83579 15.009 1.5 15.3448 1.5 15.759C1.5 16.1732 1.83579 16.509 2.25 16.509H4.57617C4.92634 18.215 6.44461 19.509 8.25 19.509C10.0554 19.509 11.5737 18.215 11.9238 16.509H21.75C22.1642 16.509 22.5 16.1732 22.5 15.759C22.5 15.3448 22.1642 15.009 21.75 15.009H11.9238C11.5737 13.3031 10.0554 12.009 8.25 12.009ZM8.25 13.509C9.5015 13.509 10.5 14.5075 10.5 15.759C10.5 17.0105 9.5015 18.009 8.25 18.009C6.9985 18.009 6 17.0105 6 15.759C6 14.5075 6.9985 13.509 8.25 13.509Z" fill="white"/>
                                    </svg>
                                    <span>{{ __('messages.filters') }}</span>
                                    <span class="mobile-filter-badge" id="mobile-filter-badge-top" style="background: white; color: #405FF2; padding: 2px 8px; border-radius: 12px; font-size: 12px; font-weight: 700; display: none;">0</span>
                                </button>
                                <div class="mobile-results-count-text" style="flex: 1; font-size: 14px; color: #666;">
                                    <span id="mobile-total-results">{{ $advertisements->total() }}</span> {{ __('messages.results') }}
                                </div>
                            </div>
                            
                            <!-- Selected Filters Tags - HIDDEN as per user request -->
                            <div class="mobile-selected-filters-tags" id="mobile-selected-filters-tags" style="display: none;">
                                <!-- Dynamic filter tags will be added here -->
                            </div>
                        </div>

                        <div class="text-box">
                            <div class="text" id="pagination-info">
                                @if($advertisements->count() > 0)
                                    {{ __('messages.showing_results') }} {{ $advertisements->firstItem() }} {{ __('messages.to') }} {{ $advertisements->lastItem() }} {{ __('messages.of') }} {{ $advertisements->total() }} {{ __('messages.vehicles') }}
                                @else
                                    {{ __('messages.no_vehicles_found') }}
                                @endif
                                    </div>
                                            </div>
                        <!-- service-block-thirteen -->
                        <div class="service-block-thirteen" id="vehicle-cards-container">
                            <!-- Loading indicator -->
                            <div id="loading-indicator" style="display: none; text-align: center; padding: 50px;">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">{{ __('messages.loading') }}...</span>
                                    </div>
                                <p>{{ __('messages.loading_vehicles') }}...</p>
                                </div>
                            
                            @include('wizmoto.home.partials.vehicle-cards', ['advertisements' => $advertisements])
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shop section two -->

    <!-- Sidebar Backdrop -->
    <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

    @include('wizmoto.partials.footer')

@endsection
@push('scripts')
    <script>
        // Function to handle URL parameters and pre-select filters
        function handleURLParameters() {
            const urlParams = new URLSearchParams(window.location.search);
            
            // Handle advertisement_type parameter
            const advertisementTypeId = urlParams.get('advertisement_type');
            
            if (advertisementTypeId) {
                // Wait for the page to be fully loaded
                setTimeout(() => {
                    const $advertisementTypeDropdown = $('#advertisement-type-dropdown');
                    const $option = $advertisementTypeDropdown.find(`li[data-id="${advertisementTypeId}"]`);
                    
                    if ($option.length) {
                        const advertisementTypeName = $option.text();
                        
                        $advertisementTypeDropdown.find('.select span').text(advertisementTypeName);
                        $advertisementTypeDropdown.find('input[type="hidden"]').val(advertisementTypeId).trigger('change');
                        
                        // Load brands and fuel types for this advertisement type
                        loadBrandsForAdvertisementType(advertisementTypeId);
                        loadFuelTypesForAdvertisementType(advertisementTypeId);
                        
                        // Update the active filters bar
                        setTimeout(() => {
                            updateSelectedFiltersBar();
                        }, 200);
                        
                        // Trigger server-side filtering for the pre-selected category
                        setTimeout(() => {
                            updateVehicleCards();
                        }, 500);
                    }
                }, 1000);
            }
            
            // Handle brand_id parameter
            const brandId = urlParams.get('brand_id');
            if (brandId) {
                // Wait a bit for brands to load, then select the brand
                setTimeout(() => {
                    const $brandDropdown = $('#brand-dropdown');
                    const $option = $brandDropdown.find(`li[data-id="${brandId}"]`);
                    
                    if ($option.length) {
                        const brandName = $option.text();
                        $brandDropdown.find('.select span').text(brandName);
                        $brandDropdown.find('input[type="hidden"]').val(brandId).trigger('change');
                        
                        // Update the active filters bar
                        setTimeout(() => {
                            updateSelectedFiltersBar();
                        }, 200);
                    }
                }, 1500);
            }
            
            // Handle vehicle_model_id parameter
            const modelId = urlParams.get('vehicle_model_id');
            if (modelId) {
                // Wait a bit for models to load, then select the model
                setTimeout(() => {
                    const $modelDropdown = $('#model-dropdown');
                    const $option = $modelDropdown.find(`li[data-id="${modelId}"]`);
                    
                    if ($option.length) {
                        const modelName = $option.text();
                        $modelDropdown.find('.select span').text(modelName);
                        $modelDropdown.find('input[type="hidden"]').val(modelId).trigger('change');
                        
                        // Update the active filters bar
                        setTimeout(() => {
                            updateSelectedFiltersBar();
                        }, 200);
                    }
                }, 2000);
            }
        }

        $(document).ready(function() {
            // Only initialize on inventory list page
            if (!$('.inventory-sidebar').length) {
                return;
            }
            
            // Handle URL parameters to pre-select filters
            handleURLParameters();
            
            let groupCounter = 0;
            let sidebarAnimating = false;

            // ========================================
            // MOBILE AUTOSCOUT24-STYLE FUNCTIONALITY
            // ========================================
            
            // Mobile filter toggle - bottom sheet behavior (only top button)
            $(document).on('click', '#mobile-filter-toggle-top', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                
                // Prevent multiple rapid clicks during animation
                if (sidebarAnimating) {
                    return;
                }
                
                const $sidebar = $('.wrap-sidebar-dk');
                const isActive = $sidebar.hasClass('active');
                
                
                sidebarAnimating = true;
                
                if (isActive) {
                    // Close sidebar
                    $sidebar.removeClass('active');
                    $('#sidebar-backdrop').removeClass('active');
                    $('body').removeClass('sidebar-open').css('overflow', '');
                } else {
                    // Open sidebar
                    $sidebar.addClass('active');
                    $('#sidebar-backdrop').addClass('active');
                    $('body').addClass('sidebar-open').css('overflow', 'hidden');
                }
                
                // Allow next click after animation completes (300ms)
                setTimeout(function() {
                    sidebarAnimating = false;
                }, 350);
            });

            // Close sidebar when clicking backdrop or close button
            function closeSidebar() {
                if (sidebarAnimating) return;
                
                sidebarAnimating = true;
                $('.wrap-sidebar-dk').removeClass('active');
                $('#sidebar-backdrop').removeClass('active');
                $('body').removeClass('sidebar-open').css('overflow', '');
                
                setTimeout(function() {
                    sidebarAnimating = false;
                }, 350);
            }

            $('#sidebar-backdrop').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebar();
            });

            $(document).on('click', '#mobile-close-sidebar-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeSidebar();
            });

            // Mobile filter sections - accordion behavior
            $('.filter-section-header').on('click', function() {
                const $section = $(this).closest('.filter-section');
                $section.toggleClass('collapsed');
            });

            // Update mobile filter count badge and selected filter tags
            function updateMobileFilterCount() {
                let count = 0;
                const $tagsContainer = $('#mobile-selected-filters-tags');
                $tagsContainer.empty();
                
                // Track selected filters
                const selectedFilters = [];
                
                // Check brand selections
                $('.brand_id_input').each(function() {
                    const val = $(this).val();
                    if (val) {
                        const text = $(this).closest('.vehicle-search-group').find('[id^="brand-dropdown"] .select span').text();
                        if (text && text !== '{{ __('messages.any_brands') }}' && text !== '{{ __('messages.select_brand') }}') {
                            selectedFilters.push({type: 'brand', value: val, text: text, input: $(this)});
                            count++;
                        }
                    }
                });
                
                // Check model selections
                $('.vehicle_model_id_input').each(function() {
                    const val = $(this).val();
                    if (val) {
                        const text = $(this).closest('.vehicle-search-group').find('[id^="model-dropdown"] .select span').text();
                        if (text && text !== '{{ __('messages.any_model') }}' && text !== '{{ __('messages.select_model') }}') {
                            selectedFilters.push({type: 'model', value: val, text: text, input: $(this)});
                            count++;
                        }
                    }
                });
                
                // Check other filters
                const filterMap = {
                    'vehicle_body_id': '{{ __('messages.body_work') }}',
                    'fuel_type_id': '{{ __('messages.fuel_type') }}',
                    'seller_type': '{{ __('messages.seller_type') }}',
                    'drive_type': '{{ __('messages.drive_type') }}'
                };
                
                Object.keys(filterMap).forEach(function(name) {
                    const $input = $('input[name="' + name + '"]');
                    if ($input.val()) {
                        const text = $input.closest('.drop-menu').find('.select span').text();
                        if (text && !text.includes('{{ __('messages.any') }}') && !text.includes('{{ __('messages.select') }}')) {
                            selectedFilters.push({type: name, value: $input.val(), text: text, input: $input});
                            count++;
                        }
                    }
                });
                
                // Check checkbox filters - count each individually
                // Equipment
                $('input[name="equipments[]"]:checked').each(function() {
                    count++;
                });
                
                // Colors
                $('input[name="color_ids[]"]:checked').each(function() {
                    count++;
                });
                
                // Transmission
                $('input[name="motor_change[]"]:checked').each(function() {
                    count++;
                });
                
                // Vehicle Categories
                $('input[name="vehicle_category[]"]:checked').each(function() {
                    count++;
                });
                
                // Emissions Classes
                $('input[name="emissions_class[]"]:checked').each(function() {
                    count++;
                });
                
                // Conditions
                $('input[name="advertisement_type_id[]"]:checked').each(function() {
                    count++;
                });
                
                // Seller Types
                $('input[name="seller_type[]"]:checked').each(function() {
                    count++;
                });
                
                // Price Evaluation
                $('input[name="price_eval[]"]:checked').each(function() {
                    count++;
                });

                // Update badge
                const $badge = $('#mobile-filter-badge-top');
                if (count > 0) {
                    $badge.text(count).show();
                } else {
                    $badge.hide();
                }
                
                // Create filter tags
                selectedFilters.forEach(function(filter) {
                    const $tag = $('<div>', {
                        class: 'mobile-filter-tag',
                        style: 'display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: #f0f0f0; border-radius: 20px; font-size: 13px; color: #333;'
                    });
                    
                    $tag.append($('<span>').text(filter.text));
                    
                    const $removeBtn = $('<button>', {
                        type: 'button',
                        style: 'background: none; border: none; color: #666; padding: 0; cursor: pointer; display: flex; align-items: center; font-size: 16px;',
                        html: '&times;'
                    });
                    
                    $removeBtn.on('click', function() {
                        // Clear the filter
                        filter.input.val('').trigger('change');
                        const anyLabelMap = {
                            brand: '{{ __('messages.any_brands') }}',
                            model: '{{ __('messages.any_model') }}',
                            vehicle_body_id: '{{ __('messages.any_body_work') }}',
                            fuel_type_id: '{{ __('messages.any_fuel_type') }}',
                            drive_type: '{{ __('messages.any_drive_type') }}'
                        };
                        const anyLabel = anyLabelMap[filter.type] || '{{ __('messages.any') }}';
                        filter.input.closest('.drop-menu').find('.select span').text(anyLabel);
                        
                        // Update UI
                        updateMobileFilterCount();
                        if ($(window).width() <= 991) {
                            updateMobileResultsCount();
                        }
                        
                        // Reload page to show results
                        window.location.reload();
                    });
                    
                    $tag.append($removeBtn);
                    $tagsContainer.append($tag);
                });
            }

            // Update filter count on any change
            $('.inventory-sidebar').on('change', 'input, select', function() {
                updateMobileFilterCount();
            });

            // Initialize filter sections as collapsed on mobile
            if ($(window).width() <= 991) {
                $('.filter-section').addClass('collapsed');
                // Keep first section open
                $('.filter-section').first().removeClass('collapsed');
            }

            // Handle window resize
            $(window).on('resize', function() {
                if ($(window).width() > 991) {
                    $('.wrap-sidebar-dk').removeClass('active');
                    $('#sidebar-backdrop').removeClass('active');
                    $('body').removeClass('sidebar-open').css('overflow', '');
                    $('.filter-section').removeClass('collapsed');
                } else {
                    // Re-collapse on mobile
                    if (!$('.filter-section').first().hasClass('collapsed')) {
                        $('.filter-section').not(':first').addClass('collapsed');
                    }
                }
            });

            // Mobile sort button (placeholder - can be enhanced)
            $('#mobile-sort-toggle').on('click', function() {
                // You can add a sort modal/dropdown here
                alert('{{ __('messages.sort_functionality_to_be_implemented') }}');
            });

            // Auto-close sidebar after applying filters (optional)
            $('.inventory-sidebar form').on('submit', function() {
                if ($(window).width() <= 991) {
                    setTimeout(function() {
                        $('.wrap-sidebar-dk').removeClass('active');
                        $('#sidebar-backdrop').removeClass('active');
                        $('body').removeClass('sidebar-open').css('overflow', '');
                    }, 300);
                }
            });

            // Initialize mobile filter count
            updateMobileFilterCount();

            // Mobile Show Results button - update count based on filters
            function updateMobileResultsCount() {
                const serverTotal = {{ $advertisements->total() }};
                
                
                // Collect filters like updateVehicleCards does
                const filters = collectFilterValues();
                
                // Check if any filters are applied
                const hasFilters = Object.keys(filters).some(key => {
                    const value = filters[key];
                    return value !== '' && value !== null && value !== undefined;
                });
                
                if (!hasFilters) {
                    // No filters, use server total
                    $('#mobile-total-results').text(serverTotal);
                    $('#mobile-results-count').text(serverTotal);
                    $('#mobile-results-text').html(`{{ __('messages.show') }} <span id="mobile-results-count">${serverTotal}</span> {{ __('messages.results') }}${serverTotal !== 1 ? 's' : ''}`);
                    $('#mobile-show-results-btn').prop('disabled', serverTotal === 0);
                    return;
                }
                
                // Has filters, get count via AJAX
                $.ajax({
                    url: '{{ route("home.get-advertisement-count") }}',
                    method: 'GET',
                    data: filters,
                    success: function(response) {
                        const count = response.count !== undefined ? response.count : serverTotal;
                        
                        $('#mobile-total-results').text(count);
                        $('#mobile-results-count').text(count);
                        
                        if (count === 0) {
                            $('#mobile-results-text').html('{{ __('messages.no_results_found') }}');
                            $('#mobile-show-results-btn').prop('disabled', true);
                        } else {
                            $('#mobile-results-text').html(`{{ __('messages.show') }} <span id="mobile-results-count">${count}</span> {{ __('messages.results') }}${count !== 1 ? 's' : ''}`);
                            $('#mobile-show-results-btn').prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to get count:', error);
                        // Fallback to server total
                        $('#mobile-total-results').text(serverTotal);
                        $('#mobile-results-count').text(serverTotal);
                        $('#mobile-results-text').html(`{{ __('messages.show') }} <span id="mobile-results-count">${serverTotal}</span> {{ __('messages.results') }}${serverTotal !== 1 ? 's' : ''}`);
                        $('#mobile-show-results-btn').prop('disabled', serverTotal === 0);
                    }
                });
            }

            // Update count when filters change - ALL inputs
            $('.inventory-sidebar').on('change', 'input, select, textarea', function() {
                if ($(window).width() <= 991) {
                    updateMobileFilterCount();
                    setTimeout(function() {
                        updateMobileResultsCount();
                    }, 100);
                }
            });
            
            // Also trigger on text input (for price, mileage, etc) - debounced
            $('.inventory-sidebar').on('input', 'input[type="text"], input[type="number"]', function() {
                if ($(window).width() <= 991) {
                    clearTimeout(window.mobileInputDebounce);
                    window.mobileInputDebounce = setTimeout(function() {
                        updateMobileFilterCount();
                        updateMobileResultsCount();
                    }, 500);
                }
            });

            // Also update on dropdown clicks (for custom dropdowns)
            $(document).on('click', '.inventory-sidebar .dropdown li', function() {
                if ($(window).width() <= 991) {
                    setTimeout(function() {
                        updateMobileFilterCount();
                        
                        // Check if there are any active filters
                        const hasFilters = $('.inventory-sidebar input[type="hidden"]').filter(function() {
                            return $(this).val() !== '' && $(this).val() !== null;
                        }).length > 0;
                        
                        if (hasFilters) {
                            updateMobileResultsCount();
                        } else {
                            // No filters, use server total directly
                            const serverTotal = {{ $advertisements->total() }};
                            $('#mobile-total-results').text(serverTotal);
                            $('#mobile-results-count').text(serverTotal);
                            $('#mobile-results-text').html(`{{ __('messages.show') }} <span id="mobile-results-count">${serverTotal}</span> {{ __('messages.results') }}${serverTotal !== 1 ? 's' : ''}`);
                            $('#mobile-show-results-btn').prop('disabled', false);
                        }
                    }, 300);
                }
            });

            // Mobile Show Results button click - apply filters and close sidebar
            $('#mobile-show-results-btn').on('click', function() {
                if (sidebarAnimating) return;
                
                sidebarAnimating = true;
                
                
                // Apply filters using the existing updateVehicleCards function
                updateVehicleCards();
                
                // Close the sidebar
                $('.wrap-sidebar-dk').removeClass('active');
                $('#sidebar-backdrop').removeClass('active');
                $('body').removeClass('sidebar-open').css('overflow', '');
                
                setTimeout(function() {
                    sidebarAnimating = false;
                }, 350);
                
                // Scroll to top of results
                setTimeout(function() {
                    if ($('.mobile-selected-filters-bar').length) {
                        $('html, body').animate({
                            scrollTop: $('.mobile-selected-filters-bar').offset().top - 80
                        }, 300);
                    }
                }, 400);
            });

            // Initialize mobile results count - ALWAYS set server total first
            const initialTotal = {{ $advertisements->total() }};
            
            // Set values immediately for all screen sizes
            $('#mobile-total-results').text(initialTotal);
            $('#mobile-results-count').text(initialTotal);
            
            if (initialTotal > 0) {
                $('#mobile-results-text').html(`{{ __('messages.show') }} <span id="mobile-results-count">${initialTotal}</span> {{ __('messages.results') }}${initialTotal !== 1 ? 's' : ''}`);
                $('#mobile-show-results-btn').prop('disabled', false);
            } else {
                $('#mobile-results-text').html('{{ __('messages.no_results_found') }}');
                $('#mobile-show-results-btn').prop('disabled', true);
            }
            
            if ($(window).width() <= 991) {
                updateMobileFilterCount();
                
                // Only call AJAX if there are active filters with actual values
                const hasFilters = $('.inventory-sidebar input[type="hidden"]').filter(function() {
                    const val = $(this).val();
                    return val !== '' && val !== null && val !== undefined;
                }).length > 0;
                
                
                if (hasFilters) {
                    setTimeout(function() {
                        updateMobileResultsCount();
                    }, 500);
                }
            }

            // Debug: Check if elements exist

            // ========================================
            // END MOBILE FUNCTIONALITY
            // ========================================

            // Add new vehicle group
            $(document).on('click', '.add-vehicle-btn', function() {
                groupCounter++;
                const originalGroup = $('.vehicle-search-group').first();
                const newGroup = originalGroup.clone(false); // Clone WITHOUT events to avoid conflicts

                // Update group data attribute
                newGroup.attr('data-group', groupCounter);

                // Update IDs to be unique
                newGroup.find('#advertisement-type-dropdown').attr('id', `advertisement-type-dropdown-${groupCounter}`);
                newGroup.find('#brand-dropdown').attr('id', `brand-dropdown-${groupCounter}`);
                newGroup.find('#model-dropdown').attr('id', `model-dropdown-${groupCounter}`);
                
                // Remove any existing dropdown-search elements from cloned group
                newGroup.find('.dropdown-search').remove();
                newGroup.find('.no-results-message').remove();

                // Clear form values
                newGroup.find('input[type="hidden"]').val('').trigger('change');
                newGroup.find('input[type="text"]').val('').trigger('change');
                
                // Reset all dropdown texts
                newGroup.find('#advertisement-type-dropdown-' + groupCounter + ' .select span').text('Select Category');
                newGroup.find('#brand-dropdown-' + groupCounter + ' .select span').text('Any Brand');
                newGroup.find('#model-dropdown-' + groupCounter + ' .select span').text('Any Model');
                
                // Clear model dropdown options
                newGroup.find('#model-dropdown-' + groupCounter + ' .dropdown').html('<li data-id="" class="clear-option">Any Model</li>');

                // Remove the cloned hidden button from first group
                newGroup.find('.remove-vehicle-group').remove();
                
                // Add visible remove button for cloned groups
                newGroup.append(`
            <button type="button" class="remove-vehicle-group" title="{{ __('messages.remove_this_vehicle') }}">
                <i class="fa fa-times"></i>
            </button>
        `);

                // Insert before the "Add another vehicle" button
                $('.add-vehicle-group').parent().before(newGroup);

                // Initialize dropdown functionality for new group
                initializeDropdowns(newGroup);
                
                // Reinitialize searchable dropdown for the cloned group
                if (typeof initializeSearchableDropdowns === 'function') {
                    initializeSearchableDropdowns();
                }
            });

            // Remove vehicle group
            $(document).on('click', '.remove-vehicle-group', function() {
                $(this).closest('.vehicle-search-group').fadeOut(300, function() {
                    $(this).remove();
                });
            });

            // Initialize dropdown functionality
            function initializeDropdowns(container) {
                // Advertisement Type dropdown click handler for cloned groups
                container.find('[id^="advertisement-type-dropdown"]').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });
                
                // Advertisement Type selection handler for cloned groups
                container.find('[id^="advertisement-type-dropdown"] .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const advertisementTypeId = $(this).data('id');
                    const advertisementTypeName = $(this).text();
                    const $advertisementTypeDropdown = $(this).closest('[id^="advertisement-type-dropdown"]');
                    const $container = $(this).closest('.vehicle-search-group');

                    $advertisementTypeDropdown.find('.select span').text(advertisementTypeName);
                    $advertisementTypeDropdown.find('input[type="hidden"]').val(advertisementTypeId).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Clear ONLY this group's brand and model (not affecting other groups)
                    $container.find('[id^="brand-dropdown"] .select span').text('Any Brand');
                    $container.find('[id^="brand-dropdown"] input[type="hidden"]').val('').trigger('change');
                    $container.find('[id^="model-dropdown"] .select span').text('Any Model');
                    $container.find('[id^="model-dropdown"] input[type="hidden"]').val('').trigger('change');
                    
                    // Note: For now, advertisement type doesn't trigger brand reload in cloned groups
                    // Each group works independently
                });
                
                // Only add selection handlers (searchable dropdown handles click/toggle)
                // Brand selection handler
                container.find('[id^="brand-dropdown"] .dropdown').on('click', 'li:not(.dropdown-search):not(.no-results-message)', function(e) {
                    e.stopPropagation();
                    
                    // Skip if this is the search input area
                    if ($(this).hasClass('dropdown-search') || $(this).find('.dropdown-search-input').length > 0) {
                        return;
                    }
                    
                    const brandId = $(this).data('id');
                    const brandName = $(this).text().trim();
                    const $brandDropdown = $(this).closest('[id^="brand-dropdown"]');
                    const $modelDropdown = container.find('[id^="model-dropdown"]');

                    $brandDropdown.find('.select span').text(brandName);
                    $brandDropdown.find('input[type="hidden"]').val(brandId).trigger('change');
                    
                    $(this).closest('.dropdown').hide();

                    // If "Any Brand" selected, clear models
                    if (!brandId || brandId === '') {
                        $modelDropdown.find('.select span').text('Any Model');
                        $modelDropdown.find('input[type="hidden"]').val('').trigger('change');
                        $modelDropdown.find('.dropdown').html('<li data-id="" class="clear-option">Any Model</li>');
                    } else {
                        // Load models for selected brand
                        loadModels(container, brandId);
                    }
                    
                    // Update selected filters bar
                    updateSelectedFiltersBar();
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // Update mobile filter count and results immediately
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        
                        // If no brand selected (Any Brand), use server total directly
                        if (!brandId || brandId === '') {
                            const serverTotal = {{ $advertisements->total() }};
                            $('#mobile-total-results').text(serverTotal);
                            $('#mobile-results-count').text(serverTotal);
                            $('#mobile-results-text').html(`{{ __('messages.show') }} <span id="mobile-results-count">${serverTotal}</span> {{ __('messages.results') }}${serverTotal !== 1 ? 's' : ''}`);
                            $('#mobile-show-results-btn').prop('disabled', false);
                        } else {
                            // Has brand, delay results count to ensure form is updated
                            setTimeout(function() {
                                updateMobileResultsCount();
                            }, 100);
                        }
                    }
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
                    updateVehicleCards();
                });

                // Model selection handler
                container.find('[id^="model-dropdown"] .dropdown').on('click', 'li:not(.dropdown-search):not(.no-results-message)', function(e) {
                    e.stopPropagation();
                    
                    // Skip if this is the search input area
                    if ($(this).hasClass('dropdown-search') || $(this).find('.dropdown-search-input').length > 0) {
                        return;
                    }
                    
                    const modelId = $(this).data('id');
                    const modelName = $(this).text().trim();
                    const $modelDropdown = $(this).closest('[id^="model-dropdown"]');

                    $modelDropdown.find('.select span').text(modelName);
                    $modelDropdown.find('input[type="hidden"]').val(modelId).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // Update mobile filter count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        updateMobileResultsCount();
                    }
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
                    updateVehicleCards();
                });
            }

            // Load brands for selected advertisement type (single)
            function loadBrandsForAdvertisementType(advertisementTypeId) {
                const $brandDropdown = $('#brand-dropdown .dropdown');
                const $brandSelect = $('#brand-dropdown .select span');
                const $brandInput = $('#brand-dropdown input[type="hidden"]');

                // Reset brand selection
                $brandSelect.text('Loading brands...');
                $brandInput.val('').trigger('change');
                $brandDropdown.empty();

                if (!advertisementTypeId) {
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
                        if (response.brands && response.brands.length > 0) {
                            // Populate brand dropdown with filtered brands
                            response.brands.forEach(function(brand) {
                                $brandDropdown.append(`
                                    <li data-id="${brand.id}">${brand.name}</li>
                                `);
                            });
                            $brandSelect.text('Select Brand');
                        } else {
                            $brandDropdown.append('<li>No brands available for this category</li>');
                            $brandSelect.text('No brands available');
                        }
                        
                        // Reinitialize searchable dropdown for brand dropdown
                        if (typeof initializeSearchableDropdowns === 'function') {
                            initializeSearchableDropdowns();
                        }
                    },
                    error: function(xhr, status, error) {
                        $brandSelect.text('Error loading brands');
                        $brandDropdown.append('<li>Error loading brands</li>');
                    }
                });
            }

            // Load fuel types for specific advertisement type
            function loadFuelTypesForAdvertisementType(advertisementTypeId) {
                
                const $fuelDropdown = $('#fuel-dropdown .dropdown');
                const $fuelSelect = $('#fuel-dropdown .select span');
                const $fuelInput = $('#fuel-dropdown input[type="hidden"]');

                // Reset fuel type selection
                $fuelSelect.text('Select Fuel Type');
                $fuelInput.val('').trigger('change');
                $fuelDropdown.empty();

                if (!advertisementTypeId) {
                    // Load all fuel types
                    loadAllFuelTypes();
                    return;
                }

                // Make AJAX request to get fuel types for this advertisement type
                $.ajax({
                    url: '{{ route("inventory.list") }}',
                    method: 'GET',
                    data: { 
                        advertisement_type: advertisementTypeId,
                        get_fuel_types_only: true // Flag to indicate we only want fuel types
                    },
                    success: function(response) {
                        
                        if (response.fuel_types && response.fuel_types.length > 0) {
                            // Populate fuel type dropdown with filtered fuel types
                            response.fuel_types.forEach(function(fuelType) {
                                $fuelDropdown.append(`
                                    <li data-id="${fuelType.id}">${fuelType.name}</li>
                                `);
                            });
                        } else {
                            $fuelDropdown.append('<li>No fuel types available for this category</li>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading fuel types:', error);
                        $fuelDropdown.append('<li>Error loading fuel types</li>');
                    }
                });
            }

            // Load all fuel types (when no category is selected)
            function loadAllFuelTypes() {
                const $fuelDropdown = $('#fuel-dropdown .dropdown');
                const fuelTypes = @json($fuelTypes);
                
                $fuelDropdown.empty();
                fuelTypes.forEach(function(fuelType) {
                    $fuelDropdown.append(`
                        <li data-id="${fuelType.id}">${fuelType.name}</li>
                    `);
                });
            }

            // Load all brands (when no category is selected)
            function loadAllBrands() {
                const $brandDropdown = $('#brand-dropdown .dropdown');
                const brands = @json($brands);
                
                $brandDropdown.empty();
                
                // Add "Any Brand" option first
                $brandDropdown.append(`<li data-id="" class="clear-option">Any Brand</li>`);
                
                brands.forEach(function(brand) {
                    $brandDropdown.append(`
                        <li data-id="${brand.id}">${brand.name}</li>
                    `);
                });
                
                // Reinitialize searchable dropdown for brand dropdown
                if (typeof initializeSearchableDropdowns === 'function') {
                    initializeSearchableDropdowns();
                }
            }

            // Load models for selected brand
            function loadModels(container, brandId) {
                const $modelDropdown = container.find('[id^="model-dropdown"] .dropdown');
                const $modelSelect = container.find('[id^="model-dropdown"] .select span');
                const $modelInput = container.find('.vehicle_model_id_input');

                // Reset model selection
                $modelSelect.text('Select Model');
                $modelInput.val('').trigger('change');
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
                        
                        // Add "Any Model" option first
                        $modelDropdown.append('<li data-id="" class="clear-option">Any Model</li>');

                        if (Object.keys(models).length === 0) {
                            $modelDropdown.append('<li>No models available</li>');
                        } else {
                            // The response is an object with id as key and name as value
                            $.each(models, function(modelId, modelName) {
                                $modelDropdown.append('<li data-id="' + modelId + '">' +
                                    modelName + '</li>');
                            });
                        }
                        $modelSelect.text('Any Model');
                        
                        // Reinitialize searchable dropdown for model dropdown
                        if (typeof initializeSearchableDropdowns === 'function') {
                            initializeSearchableDropdowns();
                        }
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

            // Initialize searchable dropdown functionality FIRST (before custom handlers)
            if (typeof initializeSearchableDropdowns === 'function') {
                initializeSearchableDropdowns();
            }
            
            // Initialize first group
            initializeDropdowns($('.vehicle-search-group').first());

            // Initialize all dropdowns in the page
            initializeAllDropdowns();
            
            // Initialize brand dropdown with all brands
            loadAllBrands();
            
            // Initialize fuel type dropdown with all fuel types
            loadAllFuelTypes();

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

                    $advertisementTypeDropdown.find('.select span').text(advertisementTypeName);
                    $advertisementTypeDropdown.find('input[type="hidden"]').val(advertisementTypeId).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Clear brand, model, and fuel type selections when category changes
                    $('#brand-dropdown .select span').text('Select Brand');
                    $('#brand-dropdown input[type="hidden"]').val('').trigger('change');
                    $('#model-dropdown .select span').text('Select Model');
                    $('#model-dropdown input[type="hidden"]').val('').trigger('change');
                    $('#fuel-dropdown .select span').text('Select Fuel Type');
                    $('#fuel-dropdown input[type="hidden"]').val('').trigger('change');
                    
                    // Load brands and fuel types for selected advertisement type
                    loadBrandsForAdvertisementType(advertisementTypeId);
                    loadFuelTypesForAdvertisementType(advertisementTypeId);
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // Trigger server-side filtering when advertisement type changes
                    setTimeout(() => {
                        updateVehicleCards();
                    }, 300);
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
                    $(this).closest('#body-dropdown').find('input[type="hidden"]').val(bodyId).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
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
                    $(this).closest('#fuel-dropdown').find('input[type="hidden"]').val(fuelId).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
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
                    $(this).closest('#year-from-dropdown').find('input[type="hidden"]').val(year).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
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
                    $(this).closest('#year-to-dropdown').find('input[type="hidden"]').val(year).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
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
                    $(this).closest('#registration-year-to-dropdown').find('input[type="hidden"]').val(year).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
                    updateVehicleCards();
                });
                
                // Registration Year From dropdown li click handler
                $('#registration-year-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const year = $(this).data('id');
                    const yearText = $(this).text();
                    $(this).closest('#registration-year-dropdown').find('.select span').text(yearText);
                    $(this).closest('#registration-year-dropdown').find('input[type="hidden"]').val(year).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 200);
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
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
                    $(this).closest('#city-dropdown').find('input[type="hidden"]').val(cityName).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 100);
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
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
                    $(this).closest('#cylinders-dropdown').find('input[type="hidden"]').val(cylindersId).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 100);
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    
                    // Trigger vehicle cards update
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
                    $(this).closest('#power-cv-from-dropdown').find('input[type="hidden"]').val(cv).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 100);
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
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
                    $(this).closest('#power-cv-to-dropdown').find('input[type="hidden"]').val(cv).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 100);
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
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
                    $(this).closest('#power-kw-from-dropdown').find('input[type="hidden"]').val(kw).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 100);
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
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
                    $(this).closest('#power-kw-to-dropdown').find('input[type="hidden"]').val(kw).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    // Update selected filters bar
                    setTimeout(updateSelectedFiltersBar, 100);
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
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
                    $(this).closest('.drop-menu').find('input[type="hidden"]').val(period).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
                    updateVehicleCards();
                });

                // Seller Type checkboxes - trigger vehicle cards update
                $('input[name="seller_type[]"]').on('change', function() {
                    updateVehicleCards();
                });

                // Drive Type dropdown
                $('#drive-type-dropdown').on('click', function(e) {
                    e.stopPropagation();
                    const $dropdown = $(this).find('.dropdown');
                    $('.dropdown').not($dropdown).hide();
                    $dropdown.toggle();
                });

                $('#drive-type-dropdown .dropdown').on('click', 'li', function(e) {
                    e.stopPropagation();
                    const driveTypeValue = $(this).data('value');
                    const driveTypeName = $(this).text();
                    const $driveTypeDropdown = $(this).closest('#drive-type-dropdown');

                    $driveTypeDropdown.find('.select span').text(driveTypeName);
                    $driveTypeDropdown.find('input[type="hidden"]').val(driveTypeValue).trigger('change');
                    $(this).closest('.dropdown').hide();
                    
                    
                    // Update mobile count
                    if ($(window).width() <= 991) {
                        updateMobileFilterCount();
                        setTimeout(updateMobileResultsCount, 100);
                    }
                    // Trigger vehicle cards update
                    updateVehicleCards();
                });
            }

            // Function to collect all filter values (global scope)
            function collectFilterValues() {
                    const filters = {};
                    
                    // Advertisement Type filter
                    const advertisementTypeId = $('input[name="advertisement_type"]').val();
                    if (advertisementTypeId && advertisementTypeId.trim() !== '') {
                        filters.advertisement_type = advertisementTypeId;
                    }
                    
                    // Brand filters
                    const brandIds = [];
                    $('.brand_id_input').each(function() {
                        if ($(this).val()) {
                            brandIds.push($(this).val());
                        }
                    });
                    if (brandIds.length > 0) {
                        filters.brand_id = brandIds;
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
                    if ($('input[name="city"]').val()) {
                        filters.city = $('input[name="city"]').val();
                    }

                    // Postal code
                    if ($('input[name="zip_code"]').val()) {
                        filters.zip_code = $('input[name="zip_code"]').val();
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

                    // Seller Type
                    if ($('input[name="seller_type"]').val()) {
                        filters.seller_type = $('input[name="seller_type"]').val();
                    }

                    // Price Evaluation
                    const priceEval = [];
                    $('input[name="price_eval[]"]:checked').each(function() {
                        priceEval.push($(this).val());
                    });
                    if (priceEval.length > 0) {
                        filters.price_eval = priceEval;
                    }

                    // Vehicle Condition
                    if ($('input[name="service_history_available"]:checked').length > 0) {
                        filters.service_history_available = true;
                    }
                    if ($('input[name="warranty_available"]:checked').length > 0) {
                        filters.warranty_available = true;
                    }

                    // Technical Specifications
                    if ($('input[name="drive_type"]').val()) {
                        filters.drive_type = $('input[name="drive_type"]').val();
                    }
                    if ($('input[name="tank_capacity_from"]').val()) {
                        filters.tank_capacity_from = $('input[name="tank_capacity_from"]').val();
                    }
                    if ($('input[name="tank_capacity_to"]').val()) {
                        filters.tank_capacity_to = $('input[name="tank_capacity_to"]').val();
                    }
                    if ($('input[name="seat_height_from"]').val()) {
                        filters.seat_height_from = $('input[name="seat_height_from"]').val();
                    }
                    if ($('input[name="seat_height_to"]').val()) {
                        filters.seat_height_to = $('input[name="seat_height_to"]').val();
                    }
                    if ($('input[name="top_speed_from"]').val()) {
                        filters.top_speed_from = $('input[name="top_speed_from"]').val();
                    }
                    if ($('input[name="top_speed_to"]').val()) {
                        filters.top_speed_to = $('input[name="top_speed_to"]').val();
                    }
                    if ($('input[name="torque_from"]').val()) {
                        filters.torque_from = $('input[name="torque_from"]').val();
                    }
                    if ($('input[name="torque_to"]').val()) {
                        filters.torque_to = $('input[name="torque_to"]').val();
                    }

                    // Sales Features
                    if ($('input[name="financing_available"]:checked').length > 0) {
                        filters.financing_available = true;
                    }
                    if ($('input[name="trade_in_possible"]:checked').length > 0) {
                        filters.trade_in_possible = true;
                    }
                    if ($('input[name="available_immediately"]:checked').length > 0) {
                        filters.available_immediately = true;
                    }

                    return filters;
                }

            // Function to update vehicle cards (global scope)
            function updateVehicleCards() {
                const filters = collectFilterValues();
                
                // Show loading indicator
                $('#loading-indicator').show();
                $('.inner-box').hide();

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
                
                $(document).on('click', '.quick-filter', function(e) {
                    e.preventDefault();
                    
                    const filterType = $(this).data('filter');
                    const filterValue = $(this).data('value');
                    
                    
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
                
                switch(filterType) {
                    case 'body':
                        // Find the body type in the dropdown and select it
                        const bodyDropdown = $('#body-dropdown');
                        const bodyOption = bodyDropdown.find(`li:contains("${filterValue}")`);
                        if (bodyOption.length) {
                            const bodyId = bodyOption.data('id');
                            bodyDropdown.find('.select span').text(filterValue);
                            bodyDropdown.find('input[type="hidden"]').val(bodyId).trigger('change');
                        }
                        break;
                        
                    case 'transmission':
                        // Check the transmission checkbox
                        $(`input[name="motor_change[]"][value="${filterValue}"]`).prop('checked', true);
                        break;
                        
                    case 'price':
                        if (filterValue === '5000-10000') {
                            $('input[name="price_from"]').val('5000').trigger('change');
                            $('input[name="price_to"]').val('10000').trigger('change');
                        } else if (filterValue === 'great-price') {
                            // Define great price as under $15,000
                            $('input[name="price_to"]').val('15000').trigger('change');
                        }
                        break;
                        
                    case 'year':
                        if (filterValue === '2020+') {
                            // Set the registration year dropdown to 2020
                            const yearDropdown = $('#registration-year-dropdown');
                            yearDropdown.find('.select span').text('2020');
                            yearDropdown.find('input[type="hidden"]').val('2020').trigger('change');
                        }
                        break;
                        
                    case 'drive':
                        // This would need to be mapped to your actual drive type field
                        // For now, we'll add it as a custom filter
                        break;
                        
                    case 'mileage':
                        if (filterValue === '0-75000') {
                            $('input[name="mileage_to"]').val('75000').trigger('change');
                        } else if (filterValue === '0-50000') {
                            $('input[name="mileage_to"]').val('50000').trigger('change');
                        }
                        break;
                        
                    case 'fuel':
                        // Find the fuel type in the dropdown and select it
                        const fuelDropdown = $('#fuel-dropdown');
                        const fuelOption = fuelDropdown.find(`li:contains("${filterValue}")`);
                        if (fuelOption.length) {
                            const fuelId = fuelOption.data('id');
                            fuelDropdown.find('.select span').text(filterValue);
                            fuelDropdown.find('input[type="hidden"]').val(fuelId).trigger('change');
                        }
                        break;
                }
                
                // Trigger the filter update
                updateVehicleCards();
            }

            // Initialize quick filters
            initializeQuickFilters();

            // Clear all filters functionality
            function initializeClearFilters() {
                $(document).on('click', '.clear-all-filters-btn', function(e) {
                    e.preventDefault();
                    clearAllFilters();
                    updateSelectedFiltersBar();
                    updateVehicleCards();
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
                    const selectedFilters = collectSelectedFilters();
                    const $bar = $('#selected-filters-bar');
                    const $list = $('#selected-filters-list');
                    
                    
                    // Clear existing filters
                    $list.empty();
                    
                    if (Object.keys(selectedFilters).length === 0) {
                        $bar.hide();
                        return;
                    }
                    
                    // Show the bar
                    $bar.show();
                    
                    // Add each selected filter
                    Object.keys(selectedFilters).forEach(filterKey => {
                        const filter = selectedFilters[filterKey];
                        let $filterTag;
                        
                        if (filter.type === 'multi-select') {
                            // For multi-select filters (like transmission, brands, etc.)
                            // Ensure values is an array
                            const values = Array.isArray(filter.values) ? filter.values : 
                                          Array.isArray(filter.value) ? filter.value : [filter.value];
                            
                            $filterTag = $(`
                                <div class="selected-filter-tag multi-select" data-filter-key="${filterKey}">
                                    <span class="filter-name">${filter.name}:</span>
                                    <div class="filter-values-box">
                                        ${values.map(value => `
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
                    const filters = {};
                    const selectText = '{{ __('messages.select') }}';
                    const anyText = '{{ __('messages.any') }}';
                    const fromText = '{{ __('messages.from') }}';
                    const toText = '{{ __('messages.to') }}';
                    
                    // Advertisement Type filter
                    const advertisementTypeId = $('input[name="advertisement_type"]').val();
                    if (advertisementTypeId && advertisementTypeId.trim() !== '') {
                        const advertisementTypeName = $('#advertisement-type-dropdown .select span').text().trim();
                        if (advertisementTypeName && !advertisementTypeName.includes(selectText) && !advertisementTypeName.includes(anyText)) {
                            filters[`advertisement_type_${advertisementTypeId}`] = {
                                name: 'Category',
                                value: advertisementTypeName,
                                type: 'single',
                                advertisementTypeId: advertisementTypeId
                            };
                        }
                    }
                    
                    // Brand filters - create individual filter for each brand
                    
                    $('input[name="brand_id[]"]').each(function() {
                        const brandId = $(this).val();
                        
                        if (brandId && brandId.trim() !== '') {
                            const $brandDropdown = $(this).closest('[id^="brand-dropdown"]');
                            const brandName = $brandDropdown.find('.select span').text().trim();
                            const selectText = '{{ __('messages.select') }}';
                            const anyText = '{{ __('messages.any') }}';
                            if (brandName && !brandName.includes(selectText) && !brandName.includes(anyText)) {
                                // Create individual filter for each brand
                                filters[`brand_${brandId}`] = {
                                    name: 'Brand',
                                    value: brandName,
                                    type: 'single',
                                    brandId: brandId
                                };
                            }
                        }
                    });
                    
                    // Model filters - create individual filter for each model
                    $('input[name="vehicle_model_id[]"]').each(function() {
                        const modelId = $(this).val();
                        if (modelId && modelId.trim() !== '') {
                            const $modelDropdown = $(this).closest('[id^="model-dropdown"]');
                            const modelName = $modelDropdown.find('.select span').text().trim();
                            const selectText = '{{ __('messages.select') }}';
                            const anyText = '{{ __('messages.any') }}';
                            if (modelName && !modelName.includes(selectText) && !modelName.includes(anyText)) {
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
                        const selectText = '{{ __('messages.select') }}';
                        const anyText = '{{ __('messages.any') }}';
                        if (fuelTypeName && !fuelTypeName.includes(selectText) && !fuelTypeName.includes(anyText)) {
                            filters[`fuel_type_${fuelTypeId}`] = {
                                name: '{{ __('messages.fuel_type') }}',
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
                    if (bodyType && !bodyType.includes('{{ __('messages.select') }}') && !bodyType.includes('{{ __('messages.any') }}')) {
                        filters.body = {
                            name: '{{ __('messages.body_work') }}',
                            value: bodyType,
                            type: 'single'
                        };
                    }
                    
                    // City
                    const city = $('#city-dropdown .select span').text();
                    if (city && !city.includes('{{ __('messages.select') }}') && !city.includes('{{ __('messages.any') }}')) {
                        filters.city = {
                            name: '{{ __('messages.city') }}',
                            value: city,
                            type: 'single'
                        };
                    }
                    
                    // Registration year (From and To)
                    const regYearFrom = $('#registration-year-dropdown .select span').text();
                    const regYearTo = $('#registration-year-to-dropdown .select span').text();
                    
                    if ((regYearFrom && !regYearFrom.includes(fromText) && !regYearFrom.includes(selectText)) || 
                        (regYearTo && !regYearTo.includes(toText) && !regYearTo.includes(selectText))) {
                        
                        let yearValue = '';
                        if (regYearFrom && !regYearFrom.includes(fromText) && !regYearFrom.includes(selectText) && 
                            regYearTo && !regYearTo.includes(toText) && !regYearTo.includes(selectText)) {
                            yearValue = `${regYearFrom} - ${regYearTo}`;
                        } else if (regYearFrom && !regYearFrom.includes(fromText) && !regYearFrom.includes(selectText)) {
                            yearValue = fromText + ' ' + regYearFrom;
                        } else if (regYearTo && !regYearTo.includes(toText) && !regYearTo.includes(selectText)) {
                            yearValue = toText + ' ' + regYearTo;
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
                    
                    // Transmission - individual items
                    $('input[name="motor_change[]"]:checked').each(function() {
                        const transmissionValue = $(this).val();
                        const transmissionName = $(this).closest('label').text().trim();
                        filters[`transmission_${transmissionValue}`] = {
                            name: 'Transmission',
                            value: transmissionName,
                            type: 'single',
                            inputName: 'motor_change[]',
                            inputValue: transmissionValue
                        };
                    });
                    
                    // Vehicle condition - individual items
                    $('input[name="advertisement_type_id[]"]:checked').each(function() {
                        const conditionValue = $(this).val();
                        const conditionName = $(this).closest('label').text().trim();
                        filters[`condition_${conditionValue}`] = {
                            name: 'Condition',
                            value: conditionName,
                            type: 'single',
                            inputName: 'advertisement_type_id[]',
                            inputValue: conditionValue
                        };
                    });
                    
                    // Equipment - individual items
                    $('input[name="equipments[]"]:checked').each(function() {
                        const equipmentValue = $(this).val();
                        const equipmentName = $(this).closest('label').text().trim();
                        filters[`equipment_${equipmentValue}`] = {
                            name: 'Equipment',
                            value: equipmentName,
                            type: 'single',
                            inputName: 'equipments[]',
                            inputValue: equipmentValue
                        };
                    });
                    
                    // Color - individual items
                    $('input[name="color_ids[]"]:checked').each(function() {
                        const colorValue = $(this).val();
                        const colorName = $(this).closest('label').text().trim();
                        filters[`color_${colorValue}`] = {
                            name: 'Color',
                            value: colorName,
                            type: 'single',
                            inputName: 'color_ids[]',
                            inputValue: colorValue
                        };
                    });
                    
                    // Vehicle Category - individual items
                    $('input[name="vehicle_category[]"]:checked').each(function() {
                        const categoryValue = $(this).val();
                        const categoryName = $(this).closest('label').text().trim();
                        filters[`category_${categoryValue}`] = {
                            name: 'Category',
                            value: categoryName,
                            type: 'single',
                            inputName: 'vehicle_category[]',
                            inputValue: categoryValue
                        };
                    });
                    
                    // Emissions Class - individual items
                    $('input[name="emissions_class[]"]:checked').each(function() {
                        const emissionValue = $(this).val();
                        const emissionName = $(this).closest('label').text().trim();
                        filters[`emissions_${emissionValue}`] = {
                            name: 'Emissions',
                            value: emissionName,
                            type: 'single',
                            inputName: 'emissions_class[]',
                            inputValue: emissionValue
                        };
                    });
                    
                    // Version Model
                    const versionModel = $('input[name="version_model[]"]').val();
                    if (versionModel && versionModel.trim() !== '') {
                        filters.version = {
                            name: 'Version',
                            value: versionModel,
                            type: 'single'
                        };
                    }
                    
                    // Cylinders
                    const cylinders = $('#cylinders-dropdown .select span').text();
                    if (cylinders && !cylinders.includes(selectText) && !cylinders.includes(anyText)) {
                        filters.cylinders = {
                            name: 'Cylinders',
                            value: cylinders,
                            type: 'single'
                        };
                    }
                    
                    // Previous Owners
                    const previousOwners = $('input[name="previous_owners_filter"]:checked').val();
                    if (previousOwners && previousOwners !== 'any') {
                        let previousOwnersValue = '';
                        if (previousOwners === '1') {
                            previousOwnersValue = '1 Owner';
                        } else if (previousOwners === '2') {
                            previousOwnersValue = '2 Owners';
                        } else if (previousOwners === '3') {
                            previousOwnersValue = '3+ Owners';
                        }
                        filters.previousOwners = {
                            name: 'Previous Owners',
                            value: previousOwnersValue,
                            type: 'single'
                        };
                    }
                    
                    // Zip Code
                    const zipCode = $('input[name="zip_code"]').val();
                    if (zipCode && zipCode.trim() !== '') {
                        filters.zipCode = {
                            name: 'Postal Code',
                            value: zipCode,
                            type: 'single'
                        };
                    }
                    
                    // Search Radius
                    const searchRadius = $('input[name="search_radius"]').val();
                    if (searchRadius && searchRadius.trim() !== '') {
                        filters.searchRadius = {
                            name: 'Search Radius',
                            value: `${searchRadius} km`,
                            type: 'single'
                        };
                    }
                    
                    // Emission Class
                    const emissionClasses = [];
                    $('input[name="emissions_class[]"]:checked').each(function() {
                        emissionClasses.push($(this).next('label').text().trim());
                    });
                    if (emissionClasses.length > 0) {
                        filters.emissionClass = {
                            name: 'Emission Class',
                            value: emissionClasses.join(', '),
                            type: 'multi'
                        };
                    }
                    
                    // Online From Period
                    const onlineFromPeriod = $('#online-from-dropdown .select span').text();
                    if (onlineFromPeriod && !onlineFromPeriod.includes('{{ __('messages.select') }}')) {
                        filters.onlineFromPeriod = {
                            name: '{{ __('messages.online_from') }}',
                            value: onlineFromPeriod,
                            type: 'single'
                        };
                    }
                    
                    // CO2 Emissions
                    const co2EmissionsFrom = $('input[name="co2_emissions_from"]').val();
                    const co2EmissionsTo = $('input[name="co2_emissions_to"]').val();
                    if (co2EmissionsFrom || co2EmissionsTo) {
                        let co2EmissionsValue = '';
                        if (co2EmissionsFrom && co2EmissionsTo) {
                            co2EmissionsValue = `${co2EmissionsFrom} - ${co2EmissionsTo} g/km`;
                        } else if (co2EmissionsFrom) {
                            co2EmissionsValue = `From ${co2EmissionsFrom} g/km`;
                        } else if (co2EmissionsTo) {
                            co2EmissionsValue = `To ${co2EmissionsTo} g/km`;
                        }
                        filters.co2Emissions = {
                            name: 'CO2 Emissions',
                            value: co2EmissionsValue,
                            type: 'range'
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
                    
                    // Seller Type - individual items
                    $('input[name="seller_type[]"]:checked').each(function() {
                        const sellerTypeValue = $(this).val();
                        const sellerTypeName = $(this).closest('label').text().trim() || $(this).next('label').text().trim();
                        filters[`seller_type_${sellerTypeValue}`] = {
                            name: 'Seller Type',
                            value: sellerTypeName,
                            type: 'single',
                            inputName: 'seller_type[]',
                            inputValue: sellerTypeValue
                        };
                    });
                    
                    // Price Evaluation - individual items
                    $('input[name="price_eval[]"]:checked').each(function() {
                        const priceEvalValue = $(this).val();
                        let priceEvalLabel = '';
                        switch(priceEvalValue) {
                            case 'Super Price':
                                priceEvalLabel = 'Top offer';
                                break;
                            case 'Great Price':
                                priceEvalLabel = 'Good price';
                                break;
                            case 'Good Price':
                                priceEvalLabel = 'Fair price';
                                break;
                            case 'ND':
                                priceEvalLabel = 'No rating';
                                break;
                            default:
                                priceEvalLabel = priceEvalValue;
                        }
                        filters[`price_eval_${priceEvalValue}`] = {
                            name: 'Price evaluation',
                            value: priceEvalLabel,
                            type: 'single',
                            inputName: 'price_eval[]',
                            inputValue: priceEvalValue
                        };
                    });
                    
                    // Vehicle Condition
                    const serviceHistory = $('input[name="service_history_available"]:checked').length > 0;
                    const warranty = $('input[name="warranty_available"]:checked').length > 0;
                    
                    if (serviceHistory) {
                        filters.serviceHistory = {
                            name: '{{ __('messages.service_history') }}',
                            value: '{{ __('messages.available') }}',
                            type: 'single'
                        };
                    }
                    if (warranty) {
                        filters.warranty = {
                            name: '{{ __('messages.warranty') }}',
                            value: '{{ __('messages.available') }}',
                            type: 'single'
                        };
                    }
                    
                    // Drive Type
                    const driveType = $('#drive-type-dropdown .select span').text();
                    if (driveType && !driveType.includes(selectText) && !driveType.includes(anyText)) {
                        filters.driveType = {
                            name: '{{ __('messages.drive_type') }}',
                            value: driveType,
                            type: 'single'
                        };
                    }
                    
                    // Tank Capacity
                    const tankCapacityFrom = $('input[name="tank_capacity_from"]').val();
                    const tankCapacityTo = $('input[name="tank_capacity_to"]').val();
                    if (tankCapacityFrom || tankCapacityTo) {
                        let tankCapacityValue = '';
                        if (tankCapacityFrom && tankCapacityTo) {
                            tankCapacityValue = `${tankCapacityFrom} - ${tankCapacityTo} L`;
                        } else if (tankCapacityFrom) {
                            tankCapacityValue = `From ${tankCapacityFrom} L`;
                        } else if (tankCapacityTo) {
                            tankCapacityValue = `To ${tankCapacityTo} L`;
                        }
                        filters.tankCapacity = {
                            name: 'Tank Capacity',
                            value: tankCapacityValue,
                            type: 'range'
                        };
                    }
                    
                    // Seat Height
                    const seatHeightFrom = $('input[name="seat_height_from"]').val();
                    const seatHeightTo = $('input[name="seat_height_to"]').val();
                    if (seatHeightFrom || seatHeightTo) {
                        let seatHeightValue = '';
                        if (seatHeightFrom && seatHeightTo) {
                            seatHeightValue = `${seatHeightFrom} - ${seatHeightTo} mm`;
                        } else if (seatHeightFrom) {
                            seatHeightValue = `From ${seatHeightFrom} mm`;
                        } else if (seatHeightTo) {
                            seatHeightValue = `To ${seatHeightTo} mm`;
                        }
                        filters.seatHeight = {
                            name: 'Seat Height',
                            value: seatHeightValue,
                            type: 'range'
                        };
                    }
                    
                    // Top Speed
                    const topSpeedFrom = $('input[name="top_speed_from"]').val();
                    const topSpeedTo = $('input[name="top_speed_to"]').val();
                    if (topSpeedFrom || topSpeedTo) {
                        let topSpeedValue = '';
                        if (topSpeedFrom && topSpeedTo) {
                            topSpeedValue = `${topSpeedFrom} - ${topSpeedTo} km/h`;
                        } else if (topSpeedFrom) {
                            topSpeedValue = `From ${topSpeedFrom} km/h`;
                        } else if (topSpeedTo) {
                            topSpeedValue = `To ${topSpeedTo} km/h`;
                        }
                        filters.topSpeed = {
                            name: 'Top Speed',
                            value: topSpeedValue,
                            type: 'range'
                        };
                    }
                    
                    // Torque
                    const torqueFrom = $('input[name="torque_from"]').val();
                    const torqueTo = $('input[name="torque_to"]').val();
                    if (torqueFrom || torqueTo) {
                        let torqueValue = '';
                        if (torqueFrom && torqueTo) {
                            torqueValue = `${torqueFrom} - ${torqueTo} Nm`;
                        } else if (torqueFrom) {
                            torqueValue = `From ${torqueFrom} Nm`;
                        } else if (torqueTo) {
                            torqueValue = `To ${torqueTo} Nm`;
                        }
                        filters.torque = {
                            name: 'Torque',
                            value: torqueValue,
                            type: 'range'
                        };
                    }
                    
                    // Sales Features
                    const financing = $('input[name="financing_available"]:checked').length > 0;
                    const tradeIn = $('input[name="trade_in_possible"]:checked').length > 0;
                    const availableImmediately = $('input[name="available_immediately"]:checked').length > 0;
                    
                    if (financing) {
                        filters.financing = {
                            name: '{{ __('messages.financing') }}',
                            value: '{{ __('messages.available') }}',
                            type: 'single'
                        };
                    }
                    if (tradeIn) {
                        filters.tradeIn = {
                            name: '{{ __('messages.trade_in') }}',
                            value: '{{ __('messages.possible') }}',
                            type: 'single'
                        };
                    }
                    if (availableImmediately) {
                        filters.availableImmediately = {
                            name: '{{ __('messages.available') }}',
                            value: '{{ __('messages.immediately') }}',
                            type: 'single'
                        };
                    }
                    
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
                        $(`input[name="brand_id[]"][value="${brandId}"]`).val('').trigger('change');
                        // Reset the dropdown display
                        $('#brand-dropdown .select span').text('Select Brand');
                        return;
                    }
                    
                    // Handle individual model removal (model_123 format)
                    if (filterKey.startsWith('model_')) {
                        const modelId = filterKey.replace('model_', '');
                        // Find and clear the specific model input
                        $(`input[name="vehicle_model_id[]"][value="${modelId}"]`).val('').trigger('change');
                        // Reset the dropdown display
                        $('#model-dropdown .select span').text('Select Model');
                        return;
                    }
                    
                    // Handle individual fuel type removal (fuel_type_123 format)
                    if (filterKey.startsWith('fuel_type_')) {
                        const fuelTypeId = filterKey.replace('fuel_type_', '');
                        // Clear the fuel type input
                        $('input[name="fuel_type_id"]').val('').trigger('change');
                        // Reset the dropdown display
                        $('#fuel-dropdown .select span').text('Select');
                        return;
                    }
                    
                    // Handle advertisement type removal (advertisement_type_123 format)
                    if (filterKey.startsWith('advertisement_type_')) {
                        // Clear the advertisement type dropdown
                        $('#advertisement-type-dropdown .select span').text('Select Category');
                        $('#advertisement-type-dropdown input[type="hidden"]').val('').trigger('change');
                        
                        // Clear brand, model, and fuel type selections when category changes
                        $('#brand-dropdown .select span').text('Any Brand');
                        $('#brand-dropdown input[type="hidden"]').val('').trigger('change');
                        $('#model-dropdown .select span').text('Any Model');
                        $('#model-dropdown input[type="hidden"]').val('').trigger('change');
                        $('#fuel-dropdown .select span').text('Select Fuel Type');
                        $('#fuel-dropdown input[type="hidden"]').val('').trigger('change');
                        
                        // Reload all brands and fuel types
                        loadAllBrands();
                        loadAllFuelTypes();
                        return;
                    }
                    
                    // Handle individual transmission removal (transmission_123 format)
                    if (filterKey.startsWith('transmission_')) {
                        const transmissionValue = filterKey.replace('transmission_', '');
                        $(`input[name="motor_change[]"][value="${transmissionValue}"]`).prop('checked', false).trigger('change');
                        return;
                    }
                    
                    // Handle individual condition removal (condition_123 format)
                    if (filterKey.startsWith('condition_')) {
                        const conditionValue = filterKey.replace('condition_', '');
                        $(`input[name="advertisement_type_id[]"][value="${conditionValue}"]`).prop('checked', false).trigger('change');
                        return;
                    }
                    
                    // Handle individual equipment removal (equipment_123 format)
                    if (filterKey.startsWith('equipment_')) {
                        const equipmentValue = filterKey.replace('equipment_', '');
                        $(`input[name="equipments[]"][value="${equipmentValue}"]`).prop('checked', false).trigger('change');
                        return;
                    }
                    
                    // Handle individual color removal (color_123 format)
                    if (filterKey.startsWith('color_')) {
                        const colorValue = filterKey.replace('color_', '');
                        $(`input[name="color_ids[]"][value="${colorValue}"]`).prop('checked', false).trigger('change');
                        return;
                    }
                    
                    // Handle individual category removal (category_123 format)
                    if (filterKey.startsWith('category_')) {
                        const categoryValue = filterKey.replace('category_', '');
                        $(`input[name="vehicle_category[]"][value="${categoryValue}"]`).prop('checked', false).trigger('change');
                        return;
                    }
                    
                    // Handle individual emissions removal (emissions_123 format)
                    if (filterKey.startsWith('emissions_')) {
                        const emissionsValue = filterKey.replace('emissions_', '');
                        $(`input[name="emissions_class[]"][value="${emissionsValue}"]`).prop('checked', false).trigger('change');
                        return;
                    }
                    
                    // Handle individual seller type removal (seller_type_123 format)
                    if (filterKey.startsWith('seller_type_')) {
                        const sellerTypeValue = filterKey.replace('seller_type_', '');
                        $(`input[name="seller_type[]"][value="${sellerTypeValue}"]`).prop('checked', false).trigger('change');
                        return;
                    }
                    
                    // Handle individual price evaluation removal (price_eval_VALUE format)
                    if (filterKey.startsWith('price_eval_')) {
                        const priceEvalValue = filterKey.replace('price_eval_', '');
                        $(`input[name="price_eval[]"][value="${priceEvalValue}"]`).prop('checked', false).trigger('change');
                        return;
                    }
                    
                    switch(filterKey) {
                        case 'brands':
                            // Remove all brands
                            $('#brand-dropdown .select span').text('Select Brand');
                            $('#brand-dropdown input[type="hidden"]').val('').trigger('change');
                            break;
                        case 'models':
                            // Remove all models
                            $('#model-dropdown .select span').text('Select Model');
                            $('#model-dropdown input[type="hidden"]').val('').trigger('change');
                            break;
                        case 'price':
                            $('input[name="price_from"]').val('').trigger('change');
                            $('input[name="price_to"]').val('').trigger('change');
                            break;
                        case 'body':
                            $('#body-dropdown .select span').text('Any Body Work');
                            $('#body-dropdown input[type="hidden"]').val('').trigger('change');
                            break;
                        case 'city':
                            $('#city-dropdown .select span').text('{{ __('messages.any_city') }}');
                            $('#city-dropdown input[type="hidden"]').val('').trigger('change');
                            break;
                        case 'fuel':
                            $('#fuel-dropdown .select span').text('Select Fuel Type');
                            $('#fuel-dropdown input[type="hidden"]').val('').trigger('change');
                            break;
                        case 'year':
                            $('#registration-year-dropdown .select span').text('From');
                            $('#registration-year-dropdown input[type="hidden"]').val('').trigger('change');
                            $('#registration-year-to-dropdown .select span').text('To');
                            $('#registration-year-to-dropdown input[type="hidden"]').val('').trigger('change');
                            break;
                        case 'mileage':
                            $('input[name="mileage_from"]').val('').trigger('change');
                            $('input[name="mileage_to"]').val('').trigger('change');
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
                        case 'emissionClass':
                            $('input[name="emissions_class[]"]:checked').prop('checked', false);
                            break;
                        case 'version':
                            $('input[name="version_model[]"]').val('').trigger('change');
                            break;
                        case 'cylinders':
                            $('input[name="cylinders"]').val('').trigger('change');
                            $('#cylinders-dropdown .select span').text('Select Cylinders');
                            break;
                        case 'onlineFromPeriod':
                            $('#online-from-dropdown .select span').text('{{ __('messages.select_period') }}');
                            $('#online-from-dropdown input[type="hidden"]').val('').trigger('change');
                            break;
                        case 'co2Emissions':
                            $('input[name="co2_emissions_from"]').val('').trigger('change');
                            $('input[name="co2_emissions_to"]').val('').trigger('change');
                            break;
                        case 'previousOwners':
                            $('input[name="previous_owners_filter"][value="any"]').prop('checked', true);
                            break;
                        case 'zipCode':
                            $('input[name="zip_code"]').val('').trigger('change');
                            break;
                        case 'searchRadius':
                            $('input[name="search_radius"]').val('').trigger('change');
                            break;
                        case 'powerCv':
                            $('input[name="power_cv_from"]').val('').trigger('change');
                            $('input[name="power_cv_to"]').val('').trigger('change');
                            $('#power-cv-from-dropdown .select span').text('From');
                            $('#power-cv-to-dropdown .select span').text('To');
                            break;
                        case 'powerKw':
                            $('input[name="power_kw_from"]').val('').trigger('change');
                            $('input[name="power_kw_to"]').val('').trigger('change');
                            $('#power-kw-from-dropdown .select span').text('From');
                            $('#power-kw-to-dropdown .select span').text('To');
                            break;
                        case 'displacement':
                            $('input[name="motor_displacement_from"]').val('').trigger('change');
                            $('input[name="motor_displacement_to"]').val('').trigger('change');
                            break;
                        case 'consumption':
                            $('input[name="fuel_consumption_from"]').val('').trigger('change');
                            $('input[name="fuel_consumption_to"]').val('').trigger('change');
                            break;
                        case 'special':
                            $('input[name="damaged_vehicle"]:checked').prop('checked', false);
                            $('input[name="coupon_documentation"]:checked').prop('checked', false);
                            $('input[name="is_metallic_paint"]:checked').prop('checked', false);
                            $('input[name="tax_deductible"]:checked').prop('checked', false);
                            break;
                        case 'sellerType':
                            $('input[name="seller_type[]"]:checked').prop('checked', false);
                            break;
                        case 'serviceHistory':
                            $('input[name="service_history_available"]:checked').prop('checked', false);
                            break;
                        case 'warranty':
                            $('input[name="warranty_available"]:checked').prop('checked', false);
                            break;
                        case 'driveType':
                            $('#drive-type-dropdown .select span').text('Select Drive Type');
                            $('#drive-type-dropdown input[type="hidden"]').val('').trigger('change');
                            break;
                        case 'tankCapacity':
                            $('input[name="tank_capacity_from"]').val('').trigger('change');
                            $('input[name="tank_capacity_to"]').val('').trigger('change');
                            break;
                        case 'seatHeight':
                            $('input[name="seat_height_from"]').val('').trigger('change');
                            $('input[name="seat_height_to"]').val('').trigger('change');
                            break;
                        case 'topSpeed':
                            $('input[name="top_speed_from"]').val('').trigger('change');
                            $('input[name="top_speed_to"]').val('').trigger('change');
                            break;
                        case 'torque':
                            $('input[name="torque_from"]').val('').trigger('change');
                            $('input[name="torque_to"]').val('').trigger('change');
                            break;
                        case 'financing':
                            $('input[name="financing_available"]:checked').prop('checked', false);
                            break;
                        case 'tradeIn':
                            $('input[name="trade_in_possible"]:checked').prop('checked', false);
                            break;
                        case 'availableImmediately':
                            $('input[name="available_immediately"]:checked').prop('checked', false);
                            break;
                    }
                }
                
            // Function to clear all filters (global scope)
            function clearAllFilters() {
                    $('.inventory-sidebar input[type="text"]').val('').trigger('change');
                    $('input[type="number"]').val('').trigger('change');
                    $('input[type="checkbox"]').prop('checked', false);
                    $('input[type="radio"]').prop('checked', false);
                    
                    const selectLabel = '{{ __('messages.select') }}';
                    const fromText = '{{ __('messages.from') }}';
                    const toText = '{{ __('messages.to') }}';
                    
                    // Reset dropdowns
                    $('.drop-menu .select span').each(function() {
                        const originalText = $(this).closest('.drop-menu').find('label').text();
                        if (originalText) {
                            $(this).text(selectLabel + ' ' + originalText);
                        }
                    });
                    $('input[type="hidden"]').val('').trigger('change');
                    
                    // Reset specific dropdowns that use From/To
                    $('#power-cv-from-dropdown .select span').text(fromText);
                    $('#power-cv-to-dropdown .select span').text(toText);
                    $('#power-kw-from-dropdown .select span').text(fromText);
                    $('#power-kw-to-dropdown .select span').text(toText);
                    $('#registration-year-dropdown .select span').text(fromText);
                    $('#registration-year-to-dropdown .select span').text(toText);
                    
                    // Reset multi-select containers
                    $('.selected-options').empty();
                    
                    // Reset previous owners to "any"
                    $('input[name="previous_owners_filter"][value="any"]').prop('checked', true);
                }
                
                // Update the bar whenever filters change
                $(document).on('change', '.inventory-sidebar input, .inventory-sidebar select', function() {
                    setTimeout(updateSelectedFiltersBar, 100);
                });
                
                // Also listen for clicks on dropdown items
                $(document).on('click', '.inventory-sidebar .dropdown li', function() {
                    setTimeout(updateSelectedFiltersBar, 100);
                    // Also update vehicle cards when dropdown items are clicked
                    setTimeout(updateVehicleCards, 200);
                });
                
                // Listen for checkbox changes
                $(document).on('change', '.inventory-sidebar input[type="checkbox"]', function() {
                    setTimeout(updateSelectedFiltersBar, 100);
                    // Also update vehicle cards when checkboxes change
                    setTimeout(updateVehicleCards, 200);
                });
                
                // Handle custom checkbox clicks
                $(document).on('click', '.inventory-sidebar .contain', function(e) {
                    e.preventDefault();
                    const $checkbox = $(this).find('input[type="checkbox"]');
                    if ($checkbox.length) {
                        $checkbox.prop('checked', !$checkbox.prop('checked'));
                        $checkbox.trigger('change');
                    }
                });
                
                // Listen for text input changes
                $(document).on('input', '.inventory-sidebar input[type="text"], .inventory-sidebar input[type="number"]', function() {
                    setTimeout(updateSelectedFiltersBar, 100);
                    // Also update vehicle cards when text inputs change
                    setTimeout(updateVehicleCards, 200);
                });
                
                // Note: Individual dropdown handlers are already set up in the existing code above
                
            // Selected Filters Bar functionality
            function initializeSelectedFiltersBar() {
                // Initial update
                updateSelectedFiltersBar();
                
                // Test function - call it after 2 seconds to see if it works
                setTimeout(function() {
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
                
                // Pre-fill brand filter (handle both single value and array)
                const brandIds = urlParams.getAll('brand_id[]').length > 0 
                    ? urlParams.getAll('brand_id[]') 
                    : (urlParams.get('brand_id') ? [urlParams.get('brand_id')] : []);
                
                if (brandIds.length > 0) {
                    const brandId = brandIds[0];
                    const brandName = getBrandNameById(brandId);
                    if (brandName) {
                        // Update display text
                        $('#brand-dropdown .select span').text(brandName);
                        // Update hidden input value
                        $('#brand-dropdown .brand_id_input').val(brandId);
                    }
                }
                
                // Pre-fill model filter (handle both single value and array)
                const modelIds = urlParams.getAll('vehicle_model_id[]').length > 0 
                    ? urlParams.getAll('vehicle_model_id[]') 
                    : (urlParams.get('vehicle_model_id') ? [urlParams.get('vehicle_model_id')] : []);
                
                if (modelIds.length > 0) {
                    const modelId = modelIds[0];
                    const modelName = getModelNameById(modelId);
                    if (modelName) {
                        // Update display text
                        $('#model-dropdown .select span').text(modelName);
                        // Update hidden input value
                        $('#model-dropdown input[name="vehicle_model_id[]"]').val(modelId);
                    }
                }
                
                // Pre-fill fuel type filter
                const fuelTypeId = urlParams.get('fuel_type_id');
                if (fuelTypeId) {
                    const fuelTypeName = getFuelTypeNameById(fuelTypeId);
                    if (fuelTypeName) {
                        $('#fuel-dropdown .select span').text(fuelTypeName);
                        $('input[name="fuel_type_id"]').val(fuelTypeId);
                    }
                }
                
                // Pre-fill advertisement type filter
                const advertisementTypeId = urlParams.get('advertisement_type');
                if (advertisementTypeId) {
                    const advertisementTypeName = getAdvertisementTypeNameById(advertisementTypeId);
                    if (advertisementTypeName) {
                        // Add to selected filters bar
                        addAdvertisementTypeToFilters(advertisementTypeId, advertisementTypeName);
                    }
                }
                
                // Update selected filters bar after pre-filling
                setTimeout(function() {
                    updateSelectedFiltersBar();
                }, 100);
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
                const advertisementType = advertisementTypes.find(a => a.id == id);
                return advertisementType ? advertisementType.title : null;
            }
            
            function addAdvertisementTypeToFilters(advertisementTypeId, advertisementTypeName) {
                
                const $bar = $('#selected-filters-bar');
                const $list = $('#selected-filters-list');
                
                
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
                
                $list.append($filterTag);
                
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
        .pagination-mobile { display: none; }
        .pagination-desktop { display: flex; }
        
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
        
        /* Clean Vehicle Cards Layout */
        #vehicle-cards-container .service-block-thirteen {
            margin-bottom: 25px;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .title {
            text-align: left;
            line-height: 1.3;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .text {
            text-align: left;
            line-height: 1.4;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .inspection-sec {
            justify-content: flex-start;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .ul-cotent {
            justify-content: flex-start;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two {
            text-align: right;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two .title {
            text-align: right;
        }
        
        /* Fix View Details Button */
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two .button {
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }
        
        /* Fix Price Justification */
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
        }
        
        /* Restore Original Price and Button Position */
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .title {
            text-align: left;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two {
            text-align: right;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two .title {
            text-align: right;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two .button {
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }
        
        /* Improve Equipment List Styling */
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .ul-cotent {
            margin-top: 15px;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .ul-cotent li a {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            color: #495057;
            font-size: 13px;
            padding: 6px 12px;
            border-radius: 20px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .ul-cotent li a:hover {
            background: #e9ecef;
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-1px);
        }
        
        /* Improve Price Styling */
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two .title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 8px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        /* Keep Original Button Styling */
        #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two .button {
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
        }
        
        /* Simple Mobile Responsive Fixes */
        @media (max-width: 991px) {
            #vehicle-cards-container .service-block-thirteen .inner-box .image-box .fair-price-overlay {
                top: 8px;
                left: 8px;
            }
            
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box {
                padding: 30px 20px 10px;
            }
        }
        
        @media (max-width: 767px) {
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box {
                padding: 25px 15px 10px;
            }
            
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .title {
                font-size: 22px;
            }
            /* Hide secondary text to reduce clutter on small screens */
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .text {
                display: none;
            }
            
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .inspection-sec {
                gap: 10px 14px;
                flex-wrap: wrap;
            }
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .inspection-sec .icon svg {
                width: 16px;
                height: 16px;
            }
            
            /* Equipment chips: horizontal scroll, compact */
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .ul-cotent {
                flex-wrap: nowrap;
                overflow-x: auto;
                gap: 8px;
                -webkit-overflow-scrolling: touch;
            }
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .ul-cotent::-webkit-scrollbar { display: none; }
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box .ul-cotent li a {
                font-size: 12px;
                padding: 5px 10px;
                white-space: nowrap;
            }
            
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two .title {
                font-size: 24px;
            }
            
            #vehicle-cards-container .service-block-thirteen .inner-box .right-box .content-box-two .button {
                min-width: 100px;
                width: 100%;
                font-size: 14px;
                padding: 10px 20px;
            }
            
            #vehicle-cards-container .service-block-thirteen .inner-box .image-box .fair-price-overlay {
                top: 10px;
                left: 10px;
            }
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
                justify-content: flex-start;
                flex-wrap: nowrap;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                gap: 3px;
                scrollbar-width: none; /* Firefox */
            }
            .pagination::-webkit-scrollbar { display: none; } /* WebKit */
            .pagination-desktop { display: none; }
            .pagination-mobile { display: flex; }
            
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

        /* ========================================
           AUTOSCOUT24-STYLE MOBILE LAYOUT
           (Layout Only - No Style Changes)
           ======================================== */
        @media (max-width: 991px) {
            /* Sidebar becomes bottom sheet */
            .wrap-sidebar-dk {
                position: fixed !important;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                background: white;
                box-shadow: 0 -4px 12px rgba(0,0,0,0.15);
                border-radius: 16px 16px 0 0;
                max-height: 80vh;
                overflow: hidden;
                transform: translateY(100%);
                transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
                will-change: transform;
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .wrap-sidebar-dk.active {
                transform: translateY(0) !important;
                overflow-y: auto;
            }

            /* Force sidebar to be visible on mobile */
            .side-bar.wrap-sidebar-dk {
                display: block !important;
                visibility: visible !important;
            }

            /* Sidebar handle - hidden on mobile */
            .sidebar-handle {
                display: none !important;
            }

            /* Inventory sidebar scrolling */
            .inventory-sidebar {
                display: flex !important;
                flex-direction: column !important;
                height: 100% !important;
                max-height: 80vh !important;
                overflow: visible !important;
            }

            /* Filter content area - scrollable */
            .inventory-sidebar .inventroy-widget {
                flex: 1 !important;
                overflow-y: auto !important;
                padding: 20px !important;
            }

            /* Fix dropdown positioning - don't push content */
            .inventory-sidebar .select {
                position: relative !important;
            }

            .inventory-sidebar .select .dropdown {
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                right: 0 !important;
                z-index: 100 !important;
                margin-top: 4px !important;
                max-height: 250px !important;
                overflow-y: auto !important;
            }

            /* Prevent scroll on dropdown open */
            .inventory-sidebar .select.active {
                overflow: visible !important;
            }

            /* Ensure dropdown overlays content */
            .inventory-sidebar .inventroy-widget {
                position: relative !important;
                z-index: 1 !important;
            }

            /* Mobile show results button - sticky at bottom */
            .mobile-show-results-btn {
                flex-shrink: 0 !important;
                position: sticky !important;
                bottom: 0 !important;
                z-index: 11 !important;
                box-shadow: 0 -2px 8px rgba(0,0,0,0.1) !important;
                display: block !important;
                margin-top: auto !important;
            }

            #mobile-show-results-btn {
                background: #405FF2 !important;
                border: none !important;
                transition: all 0.2s ease;
            }

            #mobile-show-results-btn:hover:not(:disabled) {
                background: #3651d9 !important;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(64, 95, 242, 0.3);
            }

            #mobile-show-results-btn:disabled {
                background: #6c757d !important;
                cursor: not-allowed;
                opacity: 0.6;
            }

            #mobile-results-count {
                font-weight: 700;
            }

            /* Filter sections - accordion */
            .filter-section {
                border-bottom: 1px solid #e0e0e0;
                margin-bottom: 0;
            }

            .filter-section-header {
                padding: 16px 0;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .filter-section-header::after {
                content: '▼';
                font-size: 12px;
                color: #666;
                transition: transform 0.3s;
            }

            .filter-section.collapsed .filter-section-header::after {
                transform: rotate(-90deg);
            }

            .filter-section-content {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }

            .filter-section:not(.collapsed) .filter-section-content {
                max-height: 2000px;
                padding-bottom: 16px;
            }

            /* Right content area */
            .col-xl-9 {
                width: 100%;
            }

            /* Results list - single column */
            .service-block-thirteen {
                display: grid;
                grid-template-columns: 1fr;
                gap: 16px;
            }

            /* Mobile selected filters bar at top */
            .mobile-selected-filters-bar {
                background: white;
                padding: 12px;
                border-radius: 8px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }

            .mobile-filter-toggle-btn:hover {
                background: #3651d9 !important;
            }

            .mobile-filter-tag {
                animation: slideInTag 0.2s ease;
            }

            @keyframes slideInTag {
                from {
                    opacity: 0;
                    transform: scale(0.8);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            /* Backdrop for sidebar */
            .sidebar-backdrop {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                background: rgba(0,0,0,0.5) !important;
                z-index: 999 !important;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.35s;
                pointer-events: none;
            }

            .sidebar-backdrop.active {
                opacity: 1 !important;
                visibility: visible !important;
                pointer-events: auto !important;
            }

            /* Prevent body scroll when sidebar open */
            body.sidebar-open {
                overflow: hidden;
                position: fixed;
                width: 100%;
            }

            /* Hide mobile elements on desktop */
            .sidebar-backdrop {
                display: none;
            }
        }

        /* Show mobile elements only on mobile */
        @media (max-width: 991px) {
            .sidebar-backdrop {
                display: block !important;
            }
        }
    </style>
    @include('wizmoto.partials.badge-styles')
@endpush