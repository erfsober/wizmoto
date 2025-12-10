@extends('master')
@section('body-class', 'advertisement-show-page')
@section('content')
    @include('wizmoto.partials.inner-header')

    <!-- inventory-section -->
    <section class="inventory-section pb-0 layout-radius">
        <div class="boxcar-container">
            <div class="boxcar-title-three">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('home') }}">{{ __('messages.home') }}</a>
                    </li>
                    <li><span>{{ __('messages.motors_for_sale') }}</span></li>
                </ul>
                <h2>{{ $advertisement->brand?->name }}{{ ' ' }}{{ $advertisement->vehicleModel?->name }}</h2>
                <div class="text">{{ ''}}</div>
                <div class="content-box">
                    <h3 class="title">€ {{ number_format($advertisement->final_price, 0, ',', '.') }}</h3>
                    <div class="">
                        @include('wizmoto.partials.price-evaluation-badge', ['value' => $advertisement->price_evaluation])
                    </div>
                </div>
            </div>
            <div class="gallery-sec">
                @php $images = $advertisement->getMedia('covers'); @endphp
                
                {{-- Main Image and Provider Info Row --}}
                <div class="row gallery-main-row">
                    {{-- Main Image --}}
                    <div class="image-column item1 col-lg-8 col-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="image-box main-image-box">
                                <figure class="image">
                                    <a href="{{ $images->first()->getUrl('preview') }}" data-fancybox="gallery" id="main-image-link">
                                        <img id="main-image" src="{{ $images->first()->getUrl('preview') }}" alt="{{ $advertisement->title ?? 'Advertisement Image' }}" data-preview-url="{{ $images->first()->getUrl('preview') }}">
                                    </a>
                                </figure>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Provider Info Box --}}
                    <div id="contact-message-section" class="side-bar-column style-1 col-lg-4 col-md-12 col-sm-12">
                        <div class="inner-column">
                            <div class="contact-box provider-info-box">
                                <div class="icon-box">
                                    @if($advertisement->provider?->getFirstMediaUrl('image', 'thumb'))
                                        <div class="provider-image-wrapper">
                                            <img src="{{ $advertisement->provider->getFirstMediaUrl('image', 'thumb') }}"
                                                alt="Provider Image">
                                        </div>
                                    @else
                                        <div class="provider-image-wrapper provider-image-placeholder">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="#666"/>
                                                <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z" fill="#666"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="content-box">
                                    {{-- Dealer / Provider Name --}}
                                    <h6 class="title">{{ $advertisement->provider->full_name ?? 'Unknown Dealer' }}</h6>

                                    {{-- Seller Type Badge --}}
                                    @if($advertisement->provider && $advertisement->provider->seller_type)
                                        <div class="seller-type-badge">
                                            <span class="badge badge-{{ $advertisement->provider->seller_type == \App\Enums\SellerTypeEnum::DEALER ? 'primary' : 'secondary' }}">
                                                {{ $advertisement->provider->seller_type->getLabel() }}
                                            </span>
                                        </div>
                                    @endif

                                    {{-- Address --}}
                                    <div class="text">
                                        {{ $advertisement->city ?? '' }}
                                        {{ $advertisement->zip_code ? ', ' . $advertisement->zip_code : '' }}
                                    </div>

                                    {{-- Contact List --}}
                                    <ul class="contact-list">
                                        {{-- Directions --}}
                                        <li>
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($advertisement->city . ' ' . $advertisement->zip_code) }}"
                                                target="_blank">
                                                <div class="image-box">
                                                    <img src="{{ asset('wizmoto/images/resource/phone1-1.svg') }}">
                                                </div>
                                                {{ __('messages.get_directions') }}
                                            </a>
                                        </li>

                                        {{-- Phone (only if allowed) --}}
                                        @if ($advertisement->show_phone && $advertisement->telephone)
                                            <li>
                                                <a
                                                    href="tel:{{ $advertisement->international_prefix }}{{ $advertisement->prefix }}{{ $advertisement->telephone }}">
                                                    <div class="image-box">
                                                        <img src="{{ asset('wizmoto/images/resource/phone1-2.svg') }}">
                                                    </div>
                                                    {{ $advertisement->international_prefix }} {{ $advertisement->prefix }}
                                                    {{ $advertisement->telephone }}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>

                                    {{-- Buttons --}}
                                    <div class="btn-box">
                                        <a href="#" id="initiate-chat-btn" class="side-btn" data-bs-toggle="modal"
                                            data-bs-target="#contactModal">{{ __('messages.send_message') }}
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
                                        @if($advertisement->provider->whatsapp_link)
                                        <a href="{{ $advertisement->provider->whatsapp_link }}" class="side-btn two"
                                            target="_blank">
                                            {{ __('messages.chat_via_whatsapp') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 14 14" fill="none">
                                                <path d="M13.6111 0H5.05558C4.84062 0..." fill="#60C961"></path>
                                            </svg>
                                        </a>
                                        @endif
                                        <a href="{{ route('provider.show', $advertisement->provider_id) }}"
                                            class="side-btn-three">{{ __('messages.view_all_stock_dealer') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 14 14" fill="none">
                                                <path d="M13.6111 0H5.05558C4.84062 0..." fill="#050B20"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Thumbnail Grid Below Main Image --}}
                @if($images->count() > 1)
                <div class="row gallery-thumbnails-row">
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <div class="thumbnail-grid-container">
                            @foreach ($images->skip(1) as $image)
                                @if($image)
                                    @php
                                        try {
                                            $squareUrl = $image->getUrl('square');
                                            $previewUrl = $image->getUrl('preview');
                                        } catch (\Exception $e) {
                                            $squareUrl = null;
                                            $previewUrl = null;
                                        }
                                    @endphp
                                    @if($squareUrl && $previewUrl)
                                <div class="image-column-two item2 thumbnail-item" data-preview-url="{{ $previewUrl }}" data-square-url="{{ $squareUrl }}">
                                    <div class="inner-column">
                                        <div class="image-box thumbnail-box">
                                            <figure class="image">
                                                <a href="{{ $previewUrl }}" data-fancybox="gallery" class="fancybox thumbnail-link">
                                                    <img src="{{ $squareUrl }}" 
                                                        loading="lazy"
                                                        alt="{{ $advertisement->title ?? 'Advertisement Image' }}"
                                                        data-preview-url="{{ $previewUrl }}"
                                                        onerror="this.onerror=null; this.classList.add('broken'); const container = this.closest('.image-column-two'); if(container) { container.classList.add('image-error'); container.style.display='none'; }">
                                                </a>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

            </div>
            <div class="row">
                <div class="inspection-column col-lg-12 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <!-- overview-sec -->
                        <div class="overview-sec">
                            <h4 class="title">{{ __('messages.motor_overview') }}</h4>
                            
                            {{-- Vehicle Information Section --}}
                            <div class="overview-section mb-4">
                                <h5 class="section-title">{{ __('messages.vehicle_information') }}</h5>
                            <div class="row">
                                <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                    <div class="inner-column">
                                        <ul class="list">
                                                @if($advertisement->brand?->name || $advertisement->vehicleModel?->name)
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-1.svg') }}">{{ __('messages.make_model') }}
                                                </span>
                                                    {{ $advertisement->brand?->name ?? '' }} {{ $advertisement->vehicleModel?->name ?? '' }}
                                                    @if($advertisement->version_model)
                                                        <small>({{ $advertisement->version_model }})</small>
                                                    @endif
                                            </li>
                                                @else
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-1.svg') }}">{{ __('messages.make_model') }}
                                                </span>
                                                    {{ __('messages.not_specified') }}
                                            </li>
                                                @endif
                                                @if($advertisement->vehicleBody?->name)
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-1.svg') }}">{{ __('messages.body_type') }}
                                                </span>
                                                    {{ $advertisement->vehicleBody->localized_name ?? __('messages.not_specified') }}
                                                </li>
                                                @else
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-1.svg') }}">{{ __('messages.body_type') }}
                                                </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                                @if($advertisement->vehicleColor?->name)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-11.svg') }}">{{ __('messages.exterior_color_field') }}
                                                    </span>
                                                    {{ $advertisement->vehicleColor->localized_name }}@if ($advertisement->is_metallic_paint) <small>{{ __('messages.metallic') }}</small>@endif
                                            </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-11.svg') }}">{{ __('messages.exterior_color_field') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                                @if($advertisement->registration_month || $advertisement->registration_year)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.first_registration') }}
                                                    </span>
                                                    @if($advertisement->registration_month && $advertisement->registration_year)
                                                        {{ $advertisement->registration_month }}/{{ $advertisement->registration_year }}
                                                    @elseif($advertisement->registration_year)
                                                        {{ $advertisement->registration_year }}
                                                    @endif
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.first_registration') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <ul class="list">
                                                @if($advertisement->vehicle_category)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-7.svg') }}">{{ __('messages.condition') }}
                                                    </span>
                                                    {{ $advertisement->vehicle_category }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-7.svg') }}">{{ __('messages.condition') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                                @if($advertisement->mileage)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-2.svg') }}">{{ __('messages.mileage') }}</span>
                                                    {{ number_format($advertisement->mileage) }} km
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-2.svg') }}">{{ __('messages.mileage') }}</span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                                @if($advertisement->previous_owners)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.previous_owners_label') }}
                                                    </span>
                                                    {{ $advertisement->previous_owners }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.previous_owners_label') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                                @if($advertisement->next_review_month || $advertisement->next_review_year)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.next_inspection') }}
                                                    </span>
                                                    @if($advertisement->next_review_month && $advertisement->next_review_year)
                                                        {{ $advertisement->next_review_month }}/{{ $advertisement->next_review_year }}
                                                    @elseif($advertisement->next_review_year)
                                                        {{ $advertisement->next_review_year }}
                                                    @endif
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.next_inspection') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Engine Specifications Section --}}
                            <div class="overview-section mb-4">
                                <h5 class="section-title">{{ __('messages.engine_specifications') }}</h5>
                                <div class="row">
                                    <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <ul class="list">
                                                @if($advertisement->fuelType?->name)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.fuel_type') }}
                                                    </span>
                                                    {{ $advertisement->fuelType->localized_name }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.fuel_type') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif

                                                @if($advertisement->motor_change)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-5.svg') }}">{{ __('messages.transmission_label') }}
                                                    </span>
                                                    {{ $advertisement->motor_change }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-5.svg') }}">{{ __('messages.transmission_label') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif

                                                @if($advertisement->motor_displacement)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.displacement_cc') }}
                                                    </span>
                                                    {{ $advertisement->motor_displacement }} cc
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.displacement_cc') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif

                                                @if($advertisement->motor_cylinders)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-10.svg') }}">{{ __('messages.cylinders') }}
                                                    </span>
                                                    {{ $advertisement->motor_cylinders }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-10.svg') }}">{{ __('messages.cylinders') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <ul class="list">
                                                @if($advertisement->motor_power_kw || $advertisement->motor_power_cv)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.power_output') }}
                                                    </span>
                                                    @if($advertisement->motor_power_kw)
                                                        {{ $advertisement->motor_power_kw }} kW
                                                        @if($advertisement->motor_power_cv)
                                                            ({{ $advertisement->motor_power_cv }} {{ __('messages.hp') }})
                                                        @endif
                                                    @elseif($advertisement->motor_power_cv)
                                                        {{ $advertisement->motor_power_cv }} {{ __('messages.hp') }}
                                                    @endif
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.power_output') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif

                                                @if($advertisement->motor_marches)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-5.svg') }}">{{ __('messages.number_of_gears') }}
                                                    </span>
                                                    {{ $advertisement->motor_marches }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-5.svg') }}">{{ __('messages.number_of_gears') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif

                                                @if($advertisement->drive_type)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.drive_type') }}
                                                    </span>
                                                    {{ $advertisement->drive_type }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.drive_type') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif

                                                @if($advertisement->motor_empty_weight)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.empty_weight') }}
                                                    </span>
                                                    {{ $advertisement->motor_empty_weight }} {{ __('messages.kg') }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.empty_weight') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Performance & Efficiency Section --}}
                            <div class="overview-section mb-4">
                                <h5 class="section-title">{{ __('messages.performance_efficiency') }}</h5>
                                <div class="row">
                                    <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <ul class="list">
                                                @if($advertisement->top_speed_kmh)
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.top_speed_kmh') }}
                                                </span>
                                                    {{ $advertisement->top_speed_kmh }} {{ __('messages.kmh') }}
                                            </li>
                                                @else
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.top_speed_kmh') }}
                                                </span>
                                                    {{ __('messages.not_specified') }}
                                            </li>
                                                @endif
                                                @if($advertisement->torque_nm)
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.torque_nm') }}
                                                </span>
                                                    {{ $advertisement->torque_nm }} Nm
                                            </li>
                                                @else
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.torque_nm') }}
                                                </span>
                                                    {{ __('messages.not_specified') }}
                                            </li>
                                                @endif
                                                @if($advertisement->seat_height_mm)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.seat_height_mm') }}
                                                    </span>
                                                    {{ $advertisement->seat_height_mm }} mm
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.seat_height_mm') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                        </ul>
                                    </div>
                                </div>
                                    <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <ul class="list">
                                                @if($advertisement->combined_fuel_consumption)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.fuel_consumption') }}
                                                    </span>
                                                    {{ $advertisement->combined_fuel_consumption }} {{ __('messages.l100km') }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.fuel_consumption') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                                @if($advertisement->co2_emissions)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.co2_emissions_label') }}
                                                    </span>
                                                    {{ $advertisement->co2_emissions }} {{ __('messages.gkm') }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.co2_emissions_label') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                                @if($advertisement->emissions_class)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.emissions_class') }}
                                                    </span>
                                                    {{ $advertisement->emissions_class }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.emissions_class') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                                @if($advertisement->tank_capacity_liters)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.tank_capacity_label') }}
                                                    </span>
                                                    {{ $advertisement->tank_capacity_liters }} {{ __('messages.l') }}
                                                </li>
                                                @else
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.tank_capacity_label') }}
                                                    </span>
                                                    {{ __('messages.not_specified') }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Pricing & Sales Section --}}
                            <div class="overview-section mb-4">
                                <h5 class="section-title">{{ __('messages.pricing_sales') }}</h5>
                                <div class="row">
                                <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                    <div class="inner-column">
                                        <ul class="list">
                                                @if($advertisement->final_price)
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.price_field') }}
                                                </span>
                                                    € {{ number_format($advertisement->final_price, 0, ',', '.') }}
                                                    @if($advertisement->tax_deductible)
                                                        <small>({{ __('messages.vat_deductible') }})</small>
                                                    @endif
                                            </li>
                                                @endif
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.price_negotiable') }}
                                                </span>
                                                    {{ $advertisement->price_negotiable ? __('messages.yes') : __('messages.no') }}
                                            </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <ul class="list">
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.financing_available') }}
                                                </span>
                                                    {{ $advertisement->financing_available ? __('messages.yes') : __('messages.no') }}
                                            </li>
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.trade_in_possible') }}
                                                </span>
                                                    {{ $advertisement->trade_in_possible ? __('messages.yes') : __('messages.no') }}
                                            </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Condition & History Section --}}
                            @if($advertisement->last_service_month || $advertisement->last_service_year || $advertisement->service_history_available || $advertisement->warranty_available || $advertisement->available_immediately)
                            <div class="overview-section mb-4">
                                <h5 class="section-title">{{ __('messages.condition_history') }}</h5>
                                <div class="row">
                                    <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <ul class="list">
                                                @if($advertisement->last_service_month || $advertisement->last_service_year)
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.last_service') }}
                                                </span>
                                                    @if($advertisement->last_service_month && $advertisement->last_service_year)
                                                        {{ $advertisement->last_service_month }}/{{ $advertisement->last_service_year }}
                                                    @elseif($advertisement->last_service_year)
                                                        {{ $advertisement->last_service_year }}
                                                    @endif
                                                </li>
                                                @else
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.last_service') }}
                                                </span>
                                                {{ __('messages.not_specified') }}
                                            </li>
                                                @endif
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.service_history_available') }}
                                                    </span>
                                                    @if(!is_null($advertisement->service_history_available))
                                                        {{ $advertisement->service_history_available ? __('messages.yes') : __('messages.no') }}
                                                    @else
                                                        {{ __('messages.not_specified') }}
                                                    @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                    <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <ul class="list">
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.warranty_available') }}
                                                    </span>
                                                    @if(!is_null($advertisement->warranty_available))
                                                        {{ $advertisement->warranty_available ? __('messages.yes') : __('messages.no') }}
                                                    @else
                                                        {{ __('messages.not_specified') }}
                                                    @endif
                                                </li>
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.available_immediately') }}
                                                    </span>
                                                    @if(!is_null($advertisement->available_immediately))
                                                        {{ $advertisement->available_immediately ? __('messages.yes') : __('messages.no') }}
                                                    @else
                                                        {{ __('messages.not_specified') }}
                                                    @endif
                                                </li>
                                            </ul>
                            </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Equipment Section --}}
                            @if($advertisement->equipments && $advertisement->equipments->count() > 0)
                            <div class="overview-section mb-4">
                                <h5 class="section-title">{{ __('messages.equipment_section') }}</h5>
                                <div class="row">
                                    <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <ul class="list">
                                                @foreach($advertisement->equipments as $index => $equipment)
                                                    @if($index % 2 == 0)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-1.svg') }}">{{ $equipment->localized_name }}
                                                    </span>
                                                </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="content-column col-lg-6 col-md-12 col-sm-12">
                                        <div class="inner-column">
                                            <ul class="list">
                                                @foreach($advertisement->equipments as $index => $equipment)
                                                    @if($index % 2 == 1)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-1.svg') }}">{{ $equipment->localized_name }}
                                                    </span>
                                                </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                        <!-- description-sec -->
                        @if($advertisement->localized_description && trim($advertisement->localized_description) !== '')
                        <div class="description-sec">
                            <h4 class="title">{{ __('messages.description') }}</h4>
                            <div class="text two">{{ $advertisement->localized_description }}</div>
                        </div>
                        @endif

                        <div class="location-box">
                            <h4 class="title">{{ __('messages.location') }}</h4>
                            <div class="text">
                                {{ $advertisement->city ?? '' }} {{ $advertisement->zip_code ?? '' }}
                            </div>
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ urlencode($advertisement->city . ' ' . $advertisement->zip_code) }}"
                                target="_blank" class="brand-btn">
                                {{ __('messages.get_directions') }}
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
                            <div class="google-iframe">
                                <iframe
                                    src="https://maps.google.com/maps?width=100%25&height=600&hl=en&q={{ urlencode($advertisement->city . ' ' . $advertisement->zip_code) }}&t=&z=14&ie=UTF8&iwloc=B&output=embed"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cars-section-three -->
        <div class="cars-section-three">
            <div class="boxcar-container">
                <div class="boxcar-title wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                    <h2>{{ __('messages.we_think_also_like') }}</h2>
                    <a href="{{ route('inventory.list', ['type' => $advertisement->advertisement_type_id]) }}" class="btn-title">
                        {{ __('messages.view_all_label') }}<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <g clip-path="url(#clip0_601_243)">
                                <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="#050B20"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_601_243">
                                    <rect width="14" height="14" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </a>
                </div>
        
                @if($relatedAdvertisements->count() > 0)
                    <div class="row car-slider-three slider-layout-1" data-preview="2.8">
                        @foreach($relatedAdvertisements as $index => $relatedAd)
                            <!-- car-block-three -->
                            <div class="box-car car-block-three col-lg-3 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <div class="image-box">
                                        <div class="fair-price-overlay">
                                            @include('wizmoto.partials.price-evaluation-badge', ['value' => $relatedAd->price_evaluation])
                                        </div>
                                        <div class="image-gallery" data-count="{{ $relatedAd->getMedia('covers')->count() }}">
                                            @php
                                                $images = $relatedAd->getMedia('covers');
                                                $firstImage = $images->first();
                                                $remainingImages = $images->skip(1);
                                            @endphp
                                            
                                            @if($firstImage)
                                                <div class="main-image">
                                                    <a href="{{ $firstImage->getUrl('preview') }}" data-fancybox="gallery-{{ $relatedAd->id }}">
                                                        <img
                                                            src="{{ $firstImage->getUrl('card') }}"
                                                            loading="lazy"
                                                            alt="{{ $relatedAd->title ?? 'Advertisement Image' }}">
                                                    </a>
                                                </div>
                                            @endif
                                            
                                            @if($remainingImages->count() > 0)
                                                <div class="thumbnail-images">
                                                    @foreach($remainingImages as $image)
                                                        <a href="{{ $image->getUrl('preview') }}" data-fancybox="gallery-{{ $relatedAd->id }}" class="thumb-link">
                                                    <img
                                                        src="{{ $image->getUrl('card') }}"
                                                        loading="lazy"
                                                        alt="{{ $relatedAd->title ?? 'Advertisement Image' }}">
                                                </a>
                                            @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="content-box">
                                        <h6 class="title">
                                            <a href="{{ route('advertisements.show', $relatedAd->id) }}">{{$relatedAd->brand?->localized_name}}{{' '}}{{$relatedAd->vehicleModel?->localized_name}}</a>
                                        </h6>
                                        <div class="text">€ {{ number_format($relatedAd->final_price, 0, ',', '.') }}</div>
                                        <ul>
                                            <li>
                                                <i class="flaticon-gasoline-pump"></i>{{ $relatedAd->fuelType?->localized_name ?? 'N/A' }}
                                            </li>
                                            <li>
                                                <i class="flaticon-speedometer"></i>{{ $relatedAd->mileage ? number_format($relatedAd->mileage) . ' miles' : 'N/A' }}
                                            </li>
                                            <li>
                                                <i class="flaticon-gearbox"></i> {{ $relatedAd->motor_change ?? 'N/A' }}
                                            </li>
                                        </ul>
                                        <div class="btn-box">
                                            
                                            <a href="{{ route('advertisements.show', $relatedAd->id) }}" class="details">{{ __('messages.view_details') }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" fill="none">
                                                    <g clip-path="url(#clip0_601_4346)">
                                                        <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="#405FF2"></path>
                                                    </g>
                                                    <defs>
                                                        <clippath id="clip0_601_4346">
                                                            <rect width="14" height="14" fill="white"></rect>
                                                        </clippath>
                                                    </defs>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- No Related Ads Fallback -->
                    <div class="text-center py-5">
                        <p class="text-muted mb-4">{{ __('messages.no_similar_vehicles') }}.</p>
                        <a href="{{ route('inventory.list') }}" class="theme-btn btn-style-one">
                            <span>{{ __('messages.browse_all_vehicles') }}</span>
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <!-- End shop section two -->
    </section>
    <!-- End inventory-section -->

    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">{{ __('messages.make_an_offer') ?? 'Make an offer' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="contact-form" class="inventroy-widget">
                        <p class="text-muted mb-4">{{ __('messages.send_message_cta') }}</p>

                        <form id="initiate-contact-form" method="POST" action="{{ route('chat.initiate') }}" novalidate>
                            @csrf
                            <input type="hidden" name="advertisement_id" value="{{ $advertisement->id }}">
                            <div class="form-column col-lg-12">
                                <div class="form_boxes">
                                    <label>{{ __('messages.your_name') }} *</label>
                                    <input type="text" id="guest-name" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-column col-lg-12">
                                <div class="form_boxes">
                                    <label>{{ __('messages.your_email') }} *</label>
                                    <input type="email" id="guest-email" placeholder="" required>
                                </div>
                            </div>


                            <div class="form-column col-lg-12">
                                <div class="form_boxes">
                                    <label>{{ __('messages.phone_optional') }} ({{ __('messages.optional') }})</label>
                                    <input type="tel" id="guest-phone" placeholder="">
                                </div>
                            </div>

                            {{-- Price Offer Section --}}
                            <div class="form-column col-lg-12 mb-4">
                                <div class="offer-section">
                                    <label class="mb-3">{{ __('messages.make_an_offer') ?? 'Make an offer' }}</label>
                                    
                                    @php
                                        $formatPrice = function($price) {
                                            $formatted = number_format($price, 2, ',', '.');
                                            // Remove trailing ,00 but keep other decimals
                                            return preg_replace('/,00$/', '', $formatted);
                                        };
                                    @endphp
                                    
                                    {{-- Product Info --}}
                                    <div class="offer-product-info mb-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($advertisement->getMedia('covers')->first())
                                                <img src="{{ $advertisement->getMedia('covers')->first()->getUrl('thumb') }}" 
                                                     alt="{{ $advertisement->title }}" 
                                                     class="offer-product-image">
                                            @endif
                                            <div class="flex-grow-1">
                                                <div class="offer-product-title">{{ $advertisement->title ?? $advertisement->brand?->name . ' ' . $advertisement->vehicleModel?->name }}</div>
                                                <div class="offer-product-price">Item price: €{{ $formatPrice($advertisement->final_price) }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Offer Options --}}
                                    <div class="offer-options mb-3">
                                        <div class="row g-2">
                                            <div class="col-4">
                                                <div class="offer-option" data-offer-type="percentage" data-offer-value="10">
                                                    <div class="offer-price" id="offer-10-price">€{{ $formatPrice($advertisement->final_price * 0.9) }}</div>
                                                    <div class="offer-discount">10% off</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="offer-option" data-offer-type="percentage" data-offer-value="20">
                                                    <div class="offer-price" id="offer-20-price">€{{ $formatPrice($advertisement->final_price * 0.8) }}</div>
                                                    <div class="offer-discount">20% off</div>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="offer-option active" data-offer-type="custom">
                                                    <div class="offer-price">Custom</div>
                                                    <div class="offer-discount">Set a price</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Custom Price Input --}}
                                    <div class="custom-price-input mb-3" id="custom-price-container">
                                        <div class="input-group">
                                            <span class="input-group-text">€</span>
                                            <input type="number" 
                                                   id="custom-offer-price" 
                                                   class="form-control" 
                                                   step="0.01" 
                                                   min="0.01" 
                                                   max="{{ $advertisement->final_price }}"
                                                   value="{{ number_format($advertisement->final_price, 2, '.', '') }}"
                                                   placeholder="Enter your offer">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Hidden message field - message is auto-generated from offer --}}
                            <input type="hidden" id="contact-message" value="">


                            <div class="alert alert-info">
                                <small>
                                    <i class="fa fa-info-circle"></i>
                                    <strong>{{ __('messages.privacy_notice') }}:</strong> {{ __('messages.email_kept_private') }}
                                </small>
                            </div>

                            <div class="form-submit">
                                <button type="submit" class="theme-btn" id="send-contact-btn"
                                    data-url="{{ route('chat.initiate') }}">
                                    <span class="d-flex align-items-center gap-2">
                                        {{ __('messages.make_an_offer') ?? 'Make an offer' }} <i class="fa fa-paper-plane"></i>
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
                            <h4 class="text-success">{{ __('messages.message_sent_successfully') }}!</h4>
                            <p class="mb-3">{{ __('messages.message_sent_to') }} {{ $advertisement->provider->full_name }}.</p>
                            <div class="alert alert-success">
                                <strong>{{ __('messages.conversation_link') }}:</strong><br>
                                <div class="conversation-link-container mt-2">
                                    <div class="conversation-link-box" id="conversation-link" onclick="selectAndCopyLink()">
                                        <span class="link-text"></span>
                                        <div class="action-buttons">
                                            <button class="action-btn go-btn" id="go-to-conversation-btn" onclick="event.stopPropagation(); goToConversation()" title="Go to conversation">
                                                <i class="fa fa-external-link"></i>
                                            </button>
                                            <button class="action-btn copy-btn" id="copy-link-btn" onclick="event.stopPropagation(); copyToClipboard()" title="Copy to clipboard">
                                                <i class="fa fa-copy"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted">
                                <i class="fa fa-bookmark"></i> <strong>{{ __('messages.bookmark_this_link') }}</strong> {{ __('messages.to_continue_conversation') }}!
                            </p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.close') }}</button>
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
    /* Professional AutoScout-style Gallery Layout */
    .gallery-sec {
        margin-bottom: 30px;
    }
    
    @media (max-width: 768px) {
        .cars-section-three .car-block-three .inner-box .content-box .title {
            font-size: 16px;
        }
        .cars-section-three .car-slider-three .car-block-three {
            margin-left: 0;
            margin-right: 0;
        }
        
        .cars-section-three .car-slider-three .slick-list {
            margin-left: 0;
            margin-right: 0;
        }
        /* Use CSS Grid for reliable ordering */
        .inventory-section .gallery-sec,
        .gallery-sec {
            display: grid !important;
            grid-template-rows: auto auto auto;
            gap: 0;
        }
        
        /* Force order using grid-row */
        .gallery-sec > .gallery-main-row {
            grid-row: 1;
        }
        
        .gallery-sec > .gallery-main-row .image-column {
            grid-row: 1;
            margin-bottom: 12px;
            width: 100%;
            max-width: 100%;
        }
        
        .gallery-sec > .gallery-main-row .side-bar-column {
            grid-row: 3;
            margin-bottom: 0;
            width: 100%;
            max-width: 100%;
        }
        
        .gallery-sec > .gallery-thumbnails-row {
            grid-row: 2;
            margin-top: 0;
            margin-bottom: 20px;
            margin-left: 0;
            margin-right: 0;
        }
        
        /* Override Bootstrap row behavior */
        .gallery-sec > .gallery-main-row.row {
            display: grid !important;
            grid-template-rows: auto auto;
            margin-left: 0;
            margin-right: 0;
            margin-bottom: 0;
        }
        
        .gallery-sec .gallery-thumbnails-row .col-lg-8 {
            padding-left: 0;
            padding-right: 0;
            width: 100%;
            max-width: 100%;
        }
    }
    
    /* Active thumbnail style */
    .gallery-thumbnails-row .image-column-two.thumbnail-item.active .image-box {
        border-color: rgba(64, 95, 242, 0.8);
        box-shadow: 0 4px 12px rgba(64, 95, 242, 0.3);
    }
    
    /* Main Row: Image + Provider Info */
    .gallery-main-row {
        margin-bottom: 24px;
        align-items: stretch;
        gap: 0;
    }
    
    .gallery-main-row > div {
        padding-left: 8px;
        padding-right: 8px;
    }
    
    .gallery-main-row > div:first-child {
        padding-left: 0;
    }
    
    .gallery-main-row > div:last-child {
        padding-right: 0;
    }
    
    @media (min-width: 992px) {
        .gallery-main-row > div:first-child {
            padding-right: 16px;
        }
        
        .gallery-main-row > div:last-child {
            padding-left: 16px;
        }
    }
    
    /* Main Image Box */
    .gallery-sec .main-image-box {
        height: 100%;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        background: #f8f9fa;
        position: relative;
    }
    
    .gallery-sec .main-image-box .image {
        width: 100%;
        height: 100%;
        min-height: 480px;
        max-height: 520px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        padding: 15px;
    }
    
    .gallery-sec .main-image-box .image img {
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 8px;
        display: block;
    }
    
    /* Provider Info Box */
    .gallery-sec .provider-info-box {
        height: 100%;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        background: #fff;
        padding: 26px 22px;
        display: flex;
        flex-direction: column;
        min-height: 480px;
        max-height: 520px;
        border: 1px solid #e9ecef;
    }
    
    .gallery-sec .provider-info-box .icon-box {
        margin-bottom: 18px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .gallery-sec .provider-info-box .provider-image-wrapper {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        flex-shrink: 0;
        object-fit: contain;
    }
    
    .gallery-sec .provider-info-box .provider-image-wrapper.provider-image-placeholder {
        background-color: #f0f0f0;
    }
    
    .gallery-sec .provider-info-box .provider-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
    }
    
    .gallery-sec .provider-info-box .content-box {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .gallery-sec .provider-info-box .content-box .title {
        font-size: 19px;
        font-weight: 600;
        margin-bottom: 10px;
        text-align: center;
        color: #050B20;
        line-height: 1.3;
    }
    
    .gallery-sec .provider-info-box .seller-type-badge {
        text-align: center;
        margin-bottom: 12px;
    }
    
    .gallery-sec .provider-info-box .text {
        text-align: center;
        margin-bottom: 18px;
        color: #666;
        font-size: 14px;
        line-height: 1.4;
    }
    
    .gallery-sec .provider-info-box .contact-list {
        margin-bottom: 18px;
        flex: 1;
        min-height: 0;
    }
    
    .gallery-sec .provider-info-box .contact-list li {
        margin-bottom: 12px;
    }
    
    .gallery-sec .provider-info-box .contact-list li:last-child {
        margin-bottom: 0;
    }
    
    .gallery-sec .provider-info-box .btn-box {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: auto;
        padding-top: 4px;
    }
    
    .gallery-sec .provider-info-box .btn-box .side-btn,
    .gallery-sec .provider-info-box .btn-box .side-btn-two,
    .gallery-sec .provider-info-box .btn-box .side-btn-three {
        width: 100%;
        text-align: center;
        justify-content: center;
        padding: 14px 20px;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .gallery-sec .provider-info-box .btn-box .side-btn:hover,
    .gallery-sec .provider-info-box .btn-box .side-btn-two:hover,
    .gallery-sec .provider-info-box .btn-box .side-btn-three:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Thumbnail Grid - Small thumbnails under main image */
    .gallery-thumbnails-row {
        margin-top: 12px;
    }
    
    .gallery-thumbnails-row .thumbnail-grid-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 4px;
        margin: 0 auto;
        max-width: 100%;
    }
    
    .gallery-thumbnails-row .image-column-two {
        padding: 0;
        margin: 0;
        flex: 0 0 auto;
    }
    
    .gallery-thumbnails-row .image-column-two .inner-column {
        height: 100%;
    }
    
    .gallery-thumbnails-row .image-column-two .image-box {
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        aspect-ratio: 1 / 1;
        background: #f8f9fa;
        cursor: pointer;
        position: relative;
        border: 1px solid #e9ecef;
    }
    
    .gallery-thumbnails-row .image-column-two .image-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        border-color: rgba(64, 95, 242, 0.5);
    }
    
    .gallery-thumbnails-row .image-column-two .image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 0;
    }
    
    .gallery-thumbnails-row .image-column-two .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }
    
    .gallery-thumbnails-row .image-column-two .image-box:hover img {
        transform: scale(1.08);
    }
    
    /* Hide broken images */
    .gallery-thumbnails-row .image-column-two.image-error,
    .gallery-thumbnails-row .image-column-two:has(img.broken) {
        display: none !important;
    }
    
    /* Desktop: 4 small columns - Limited to main image width */
    @media (min-width: 992px) {
        .gallery-thumbnails-row .thumbnail-grid-container {
            justify-content: center;
        }
        
        .gallery-thumbnails-row .image-column-two {
            flex: 0 0 auto;
        }
        
        .gallery-thumbnails-row .image-column-two .image-box {
            width: 120px;
            height: 120px;
            max-width: 120px;
            max-height: 120px;
        }
    }
    
    /* Tablet: 4 columns */
    @media (min-width: 768px) and (max-width: 991px) {
        .gallery-thumbnails-row .thumbnail-grid-container {
            justify-content: center;
        }
        
        .gallery-thumbnails-row .image-column-two {
            flex: 0 0 auto;
        }
        
        .gallery-thumbnails-row .image-column-two .image-box {
            width: 100px;
            height: 100px;
            max-width: 100px;
            max-height: 100px;
        }
    }
    
    /* Mobile Responsive - Additional overrides */
    @media (max-width: 768px) {
        /* Main Row: Stack vertically on mobile */
        .gallery-sec .gallery-main-row.row > div {
            padding-left: 0;
            padding-right: 0;
        }
        
        
        /* Main Image Box - Mobile */
        .gallery-sec .main-image-box {
            margin-bottom: 0;
        }
        
        .gallery-sec .main-image-box .image {
            min-height: 280px;
            max-height: 320px;
            padding: 15px;
        }
        
        .gallery-sec .main-image-box .image img {
            object-fit: contain;
        }
        
        /* Provider Info Box - Mobile */
        .gallery-sec .provider-info-box {
            min-height: auto;
            max-height: none;
            padding: 22px 18px;
        }
        
        .gallery-sec .provider-info-box .content-box .title {
            font-size: 18px;
        }
        
        /* Thumbnail Grid - Mobile: 4 small columns */
        .gallery-thumbnails-row {
            margin-top: 12px;
        }
        
        .gallery-thumbnails-row .thumbnail-grid-container {
            justify-content: center;
            gap: 6px;
        }
        
        .gallery-thumbnails-row .image-column-two {
            flex: 0 0 auto;
            padding: 0;
            margin: 0;
        }
        
        .gallery-thumbnails-row .image-column-two .image-box {
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            width: 80px;
            height: 80px;
            max-width: 80px;
            max-height: 80px;
            border-width: 1px;
        }
        
        .gallery-thumbnails-row .image-column-two .image-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .cars-section-three .car-slider-three {
            padding-bottom: 36px !important; /* room for arrows below */
        }
        .cars-section-three .car-slider-three .slick-list {
            padding-bottom: 36px !important;
            margin-bottom: -36px !important;
        }
        .cars-section-three .car-slider-three .slick-prev,
        .cars-section-three .car-slider-three .slick-next {
            top: auto !important;
            bottom: -12px !important; /* tuck just under cards */
            transform: none !important;
            z-index: 1 !important;
        }
        .cars-section-three .car-slider-three .slick-prev {
            left: 12px !important;
            right: auto !important;
        }
        .cars-section-three .car-slider-three .slick-next {
            right: 12px !important;
            left: auto !important;
        }
        
        /* Increase card height */
        .cars-section-three .car-block-three .inner-box .image-box {
            min-height: 280px;
        }
        .cars-section-three .car-block-three .inner-box .image-box .image-gallery,
        .cars-section-three .car-block-three .inner-box .image-box .image-gallery .main-image,
        .cars-section-three .car-block-three .inner-box .image-box .image-gallery .main-image img {
            min-height: 280px;
            object-fit: cover;
        }
        .cars-section-three .car-block-three .inner-box .content-box {
            min-height: 200px;
        }
    }
    
    /* Image count indicator for related products - applies to all screen sizes */
    .cars-section-three .image-gallery::after {
        content: attr(data-count);
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        z-index: 3;
    }
    /* No extra overrides for overview rows here; use global theme styles */
    </style>
@endpush
@include('wizmoto.partials.badge-styles')
@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle broken images in gallery - hide empty boxes
            $('.gallery-sec .image-column-two.item2 img').on('error', function() {
                const $container = $(this).closest('.image-column-two.item2');
                $container.addClass('image-error').hide();
            });
            
            // Check for images without src or empty src and hide containers
            $('.gallery-sec .image-column-two.item2 img').each(function() {
                const $img = $(this);
                const src = $img.attr('src');
                if (!src || src === '' || src === 'undefined') {
                    $img.closest('.image-column-two.item2').addClass('image-error').hide();
                }
            });
            
            // Remove empty containers that have no visible images
            setTimeout(function() {
                $('.gallery-sec .image-column-two.item2').each(function() {
                    const $container = $(this);
                    const $img = $container.find('img');
                    if ($img.length === 0 || !$img.attr('src') || $img.hasClass('broken')) {
                        $container.addClass('image-error').hide();
                    }
                });
            }, 500);
    
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

            // Price offer functionality
            const originalPrice = {{ $advertisement->final_price }};
            let selectedOfferType = 'custom';
            let selectedOfferValue = originalPrice;
            
            // Translation strings for offer messages
            const offerPrefix = @json(__('messages.offer_message_prefix'));
            const offerDiscount = @json(__('messages.offer_message_discount'));
            const offerFrom = @json(__('messages.offer_message_from'));
            
            // Initialize: Custom is default, so input should be enabled
            $('#custom-offer-price').prop('disabled', false);

            // Handle offer option selection
            $('.offer-option').on('click', function() {
                $('.offer-option').removeClass('active');
                $(this).addClass('active');
                
                selectedOfferType = $(this).data('offer-type');
                
                if (selectedOfferType === 'percentage') {
                    const percentage = $(this).data('offer-value');
                    selectedOfferValue = originalPrice * (1 - percentage / 100);
                    $('#custom-offer-price').val(selectedOfferValue.toFixed(2));
                    // Disable input for percentage options
                    $('#custom-offer-price').prop('disabled', true);
                    $('#custom-price-container .input-group-text').css('background-color', '#f8f9fa').css('opacity', '0.7');
                } else {
                    // Custom - enable input and use current value
                    $('#custom-offer-price').prop('disabled', false);
                    $('#custom-price-container .input-group-text').css('background-color', '#f8f9fa').css('opacity', '1');
                    selectedOfferValue = parseFloat($('#custom-offer-price').val()) || originalPrice;
                }
            });

            // Handle custom price input (only when enabled)
            $('#custom-offer-price').on('input', function() {
                // Only process if input is enabled (custom mode)
                if ($(this).prop('disabled')) {
                    return;
                }
                
                const newValue = parseFloat($(this).val()) || originalPrice;
                if (newValue > originalPrice) {
                    selectedOfferValue = originalPrice;
                    $(this).val(originalPrice.toFixed(2));
                } else {
                    selectedOfferValue = newValue;
                }
            });

            // Handle contact form submission
            $('#initiate-contact-form').on('submit', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const name = $('#guest-name').val().trim();
                const email = $('#guest-email').val().trim();
                const phone = $('#guest-phone').val().trim();
                const providerId = {{ $advertisement->provider->id }};

                // Validate required fields
                if (!name) {
                    swal.fire({
                        toast: true,
                        title: '{{ __('messages.error') ?? 'Error' }}',
                        text: '{{ __('messages.your_name') }} is required',
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#guest-name').focus();
                    return;
                }

                if (!email) {
                    swal.fire({
                        toast: true,
                        title: '{{ __('messages.error') ?? 'Error' }}',
                        text: '{{ __('messages.your_email') }} is required',
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#guest-email').focus();
                    return;
                }

                // Validate email format
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    swal.fire({
                        toast: true,
                        title: '{{ __('messages.error') ?? 'Error' }}',
                        text: 'Please enter a valid email address',
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#guest-email').focus();
                    return;
                }

                // Validate offer price
                if (!selectedOfferValue || selectedOfferValue <= 0) {
                    swal.fire({
                        toast: true,
                        title: '{{ __('messages.error') ?? 'Error' }}',
                        text: 'Please enter a valid offer price',
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $('#custom-offer-price').focus();
                    return;
                }

                // Build offer message (concise format) - using translations
                // Format prices with thousand separators and without trailing zeros
                // e.g., 3861.00 -> 3.861, 4290.00 -> 4.290, 3861.50 -> 3.861,50
                function formatPrice(price) {
                    // Split into integer and decimal parts
                    const parts = price.toFixed(2).split('.');
                    const integerPart = parts[0];
                    const decimalPart = parts[1];
                    
                    // Add thousand separators (dots) to integer part
                    const formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                    
                    // Combine with decimal part (comma as separator)
                    let formatted = formattedInteger + ',' + decimalPart;
                    
                    // Remove trailing ,00 but keep other decimals
                    formatted = formatted.replace(/,00$/, '');
                    return formatted;
                }
                
                let offerMessage = '';
                const offerPriceFormatted = formatPrice(selectedOfferValue);
                const originalPriceFormatted = formatPrice(originalPrice);
                
                if (selectedOfferType === 'percentage') {
                    const percentage = $('.offer-option.active').data('offer-value');
                    offerMessage = `${offerPrefix} €${offerPriceFormatted} (${percentage}% ${offerDiscount} €${originalPriceFormatted})`;
                } else {
                    offerMessage = `${offerPrefix} €${offerPriceFormatted} (${offerFrom} €${originalPriceFormatted})`;
                }

                // Set the hidden message field
                $('#contact-message').val(offerMessage);

                // Disable submit button
                $('#send-contact-btn').prop('disabled', true).html(
                    '<i class="fa fa-spinner fa-spin"></i> {{ __('messages.sending') ?? 'Sending...' }}');

                // Send message via AJAX
                $.ajax({
                    url: $('#send-contact-btn').data('url'),
                    method: 'POST',
                    data: {
                        provider_id: providerId,
                        name: name,
                        email: email,
                        phone: phone,
                        message: offerMessage,
                        advertisement_id: {{ $advertisement->id }},
                        _token: @json(csrf_token())
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            $('#contact-form').addClass('d-none');
                            $('#contact-success').removeClass('d-none');
                            $('#conversation-link .link-text').text(response.conversation_link);

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
                            '<span class="d-flex align-items-center gap-2">{{ __('messages.make_an_offer') ?? 'Make an offer' }} <i class="fa fa-paper-plane"></i></span>');
                    }
                });
            });

            // Reset modal when closed
            $('#contactModal').on('hidden.bs.modal', function() {
                $('#contact-form').removeClass('d-none');
                $('#contact-success').addClass('d-none');
                $('#initiate-contact-form')[0].reset();
                
                // Reset offer selection
                $('.offer-option').removeClass('active');
                $('.offer-option[data-offer-type="custom"]').addClass('active');
                selectedOfferType = 'custom';
                selectedOfferValue = originalPrice;
                $('#custom-offer-price').val(originalPrice.toFixed(2));
                // Enable input for custom mode
                $('#custom-offer-price').prop('disabled', false);
                $('#custom-price-container .input-group-text').css('background-color', '#f8f9fa').css('opacity', '1');
                
                $('#send-contact-btn').prop('disabled', false).html(
                    '<span class="d-flex align-items-center gap-2">{{ __('messages.make_an_offer') ?? 'Make an offer' }} <i class="fa fa-paper-plane"></i></span>');
            });

            // Fix modal blocking issues
            $('#contactModal').on('show.bs.modal', function() {
                // Remove any blocking elements that might prevent clicks
                $('.mm-wrapper__blocker').remove();
                $('.mobile-menu-overlay').remove();
                $('.page-overlay').remove();
                $('.overlay').remove();
                
                // Force enable pointer events on everything
                $('body *').css('pointer-events', 'auto');
                $('body').css('pointer-events', 'auto');
            });

            $('#contactModal').on('shown.bs.modal', function() {
                // Force remove any blocking elements
                $('.mm-wrapper__blocker, .mobile-menu-overlay, .page-overlay, .overlay').remove();
                
                // Force enable all elements
                $('body *').css({
                    'pointer-events': 'auto',
                    'z-index': 'auto'
                });
                
                // Ensure modal is on top
                $(this).css({
                    'z-index': '99999999',
                    'pointer-events': 'auto'
                });
                
                // Ensure modal content is clickable
                $(this).find('*').css({
                    'pointer-events': 'auto',
                    'z-index': 'auto'
                });
                
                // Force focus on first input
                setTimeout(function() {
                    $('#contactModal input:first').focus();
                }, 100);
            });

            // Pre-fill email if previously used
            const savedEmail = localStorage.getItem('guest_email_' + {{ $advertisement->provider->id }});
            if (savedEmail) {
                $('#guest-email').val(savedEmail);
            }
        });

        // Global functions for conversation link
        window.selectAndCopyLink = function() {
            const linkText = $('#conversation-link .link-text').text();
            if (linkText) {
                // Select the text
                if (window.getSelection) {
                    const selection = window.getSelection();
                    const range = document.createRange();
                    range.selectNodeContents(document.querySelector('#conversation-link .link-text'));
                    selection.removeAllRanges();
                    selection.addRange(range);
                }
                
                // Copy to clipboard
                copyToClipboard();
            }
        };

        window.goToConversation = function() {
            const linkText = $('#conversation-link .link-text').text();
            if (linkText) {
                // Open the conversation link in a new tab
                window.open(linkText, '_blank');
            }
        };

        window.copyToClipboard = function() {
            const linkText = $('#conversation-link .link-text').text();
            
            if (linkText) {
                // Try modern clipboard API first
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(linkText).then(function() {
                        showCopySuccess();
                    }).catch(function(err) {
                        console.error('Clipboard API failed:', err);
                        fallbackCopy(linkText);
                    });
                } else {
                    // Fallback for older browsers
                    fallbackCopy(linkText);
                }
            }
        };

        function fallbackCopy(text) {
            try {
                // Create a temporary textarea
                const textArea = document.createElement('textarea');
                textArea.value = text;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                
                const successful = document.execCommand('copy');
                document.body.removeChild(textArea);
                
                if (successful) {
                    showCopySuccess();
                } else {
                    throw new Error('execCommand failed');
                }
            } catch (err) {
                console.error('Fallback copy failed:', err);
                alert('Failed to copy link. Please select and copy manually.');
            }
        }

        function showCopySuccess() {
            const $btn = $('#copy-link-btn');
            const $icon = $btn.find('i');
            
            // Change button appearance
            $btn.addClass('copied');
            $icon.attr('class', 'fa fa-check');
            
            // Show notification
            if (typeof toastr !== 'undefined') {
                toastr.success('Link copied to clipboard!');
            } else {
                // Create a temporary success message
                const $successMsg = $('<div class="copy-success-msg">Copied!</div>');
                $successMsg.css({
                    position: 'absolute',
                    top: '-30px',
                    right: '0',
                    background: '#28a745',
                    color: 'white',
                    padding: '4px 8px',
                    borderRadius: '4px',
                    fontSize: '12px',
                    zIndex: 1000
                });
                
                $btn.parent().css('position', 'relative').append($successMsg);
                
                setTimeout(function() {
                    $successMsg.remove();
                }, 2000);
            }
            
            // Reset button after 2 seconds
            setTimeout(function() {
                $btn.removeClass('copied');
                $icon.attr('class', 'fa fa-copy');
            }, 2000);
        }

        // Initialize image gallery interactions for "We Think You Also Like" cards
        function initializeImageGalleries() {
            // Add click handlers for thumbnail images
            $('.thumb-link').on('click', function(e) {
                e.preventDefault();
                
                const $gallery = $(this).closest('.image-gallery');
                const $mainImage = $gallery.find('.main-image img');
                const $thumbImage = $(this).find('img');
                
                // Swap the main image with the clicked thumbnail
                const mainSrc = $mainImage.attr('src');
                const thumbSrc = $thumbImage.attr('src');
                
                $mainImage.attr('src', thumbSrc);
                $thumbImage.attr('src', mainSrc);
                
                // Update the main image link
                const $mainLink = $gallery.find('.main-image a');
                const thumbHref = $(this).attr('href');
                $mainLink.attr('href', thumbHref);
            });
        }

        // Initialize image galleries when document is ready
        $(document).ready(function() {
            initializeImageGalleries();
        });
    </script>
@endpush

@push('styles')
<style>
.conversation-link-container {
    width: 100%;
}

.conversation-link-box {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    word-break: break-all;
}

.conversation-link-box:hover {
    background: #e9ecef;
    border-color: #007bff;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0,123,255,0.15);
}

.conversation-link-box:active {
    transform: translateY(0);
    box-shadow: 0 1px 4px rgba(0,123,255,0.2);
}

.link-text {
    flex: 1;
    font-family: 'Courier New', monospace;
    font-size: 14px;
    color: #495057;
    line-height: 1.4;
    margin-right: 12px;
    user-select: all;
}

.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
}

.action-btn {
    border: none;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 14px;
    min-width: 40px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.go-btn {
    background: #28a745;
}

.go-btn:hover {
    background: #218838;
    transform: scale(1.05);
}

.go-btn:active {
    transform: scale(0.95);
}

.copy-btn {
    background: #007bff;
}

.copy-btn:hover {
    background: #0056b3;
    transform: scale(1.05);
}

.copy-btn:active {
    transform: scale(0.95);
}

.copy-btn.copied {
    background: #28a745;
}

.copy-btn.copied i {
    transform: scale(1.2);
}

/* Mobile responsiveness */
@media (max-width: 576px) {
    .conversation-link-box {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
    }
    
    .link-text {
        margin-right: 0;
        text-align: center;
    }
    
    .action-buttons {
        justify-content: center;
        gap: 12px;
    }
    
    .action-btn {
        flex: 1;
        max-width: 120px;
    }
}

/* Image Gallery Styles for "We Think You Also Like" Cards */
.image-gallery {
    position: relative;
    overflow: hidden;
}

.thumbnail-images {
    position: absolute;
    bottom: 8px;
    right: 8px;
    display: flex;
    flex-direction: row;
    gap: 4px;
    z-index: 2;
}

.thumb-link {
    display: block;
    width: 50px;
    height: 50px;
    border-radius: 4px;
    overflow: hidden;
    border: 2px solid rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.thumb-link:hover {
    border-color: #405FF2;
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(64, 95, 242, 0.3);
}

.thumb-link img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.main-image {
    position: relative;
    z-index: 1;
}

.main-image img {
    width: 100%;
    height: auto;
    transition: all 0.3s ease;
}

/* Mobile Contact Box Organization */
@media (max-width: 991.98px) {
    /* Contact box container */
    .inventory-section .side-bar-column .inner-column .contact-box {
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    /* Icon box - center on mobile */
    .inventory-section .side-bar-column .inner-column .contact-box .icon-box {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }
    
    /* Content box - better spacing */
    .inventory-section .side-bar-column .inner-column .contact-box .content-box {
        text-align: center;
    }
    
    /* Title */
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
        line-height: 1.3;
    }
    
    /* Seller type badge */
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .seller-type-badge {
        margin: 8px 0 12px 0;
        display: flex;
        justify-content: center;
    }
    
    /* Address text */
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .text {
        font-size: 14px;
        color: #666;
        margin-bottom: 20px;
        line-height: 1.5;
    }
    
    /* Contact list - better organization */
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .contact-list {
        margin: 20px 0;
        padding: 0;
        list-style: none;
        width: 100%;
    }
    
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .contact-list li {
        margin-bottom: 12px;
        width: 100%;
    }
    
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .contact-list li a {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding: 12px 16px;
        background: #f8f9fa;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 14px;
        color: #333;
        width: 100%;
        box-sizing: border-box;
    }
    
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .contact-list li a:hover {
        background: #e9ecef;
        transform: translateY(-1px);
    }
    
    /* Contact list image boxes on mobile */
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .contact-list li a .image-box {
        width: 40px;
        height: 40px;
        min-width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        background: #E9F2FF;
        border-radius: 50%;
        flex-shrink: 0;
    }
    
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .contact-list li a .image-box img {
        width: 20px;
        height: 20px;
        object-fit: contain;
        display: block;
    }
    
    /* Button box - organized layout */
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .btn-box {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 24px;
    }
    
    /* All buttons - consistent styling */
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .btn-box .side-btn,
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .btn-box .side-btn.two,
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .btn-box .side-btn-three {
        width: 100% !important;
        flex: 0 0 auto;
        max-width: 100%;
        box-sizing: border-box;
        padding: 14px 20px !important;
        font-size: 15px !important;
        font-weight: 600 !important;
        border-radius: 10px !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 0 !important;
    }
    
    /* Button SVG icons */
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .btn-box .side-btn svg,
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .btn-box .side-btn.two svg,
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .btn-box .side-btn-three svg {
        flex-shrink: 0;
        margin-left: 0;
    }
    
    /* Side button three - underline link style on mobile */
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .btn-box .side-btn-three {
        background: transparent !important;
        border: none !important;
        text-decoration: underline;
        color: #405FF2 !important;
        padding: 12px !important;
    }
    
    .inventory-section .side-bar-column .inner-column .contact-box .content-box .btn-box .side-btn-three:hover {
        text-decoration: none;
        background: #f8f9fa !important;
    }
}

/* Fix SVG alignment in get directions button - center it vertically */
.inventory-section .inspection-column .inner-column .location-box .brand-btn {
    display: inline-flex;
    align-items: center;
    line-height: 1;
}

.inventory-section .inspection-column .inner-column .location-box .brand-btn svg {
    display: inline-flex;
    align-items: center;
    margin-left: 9px;
    vertical-align: middle;
    flex-shrink: 0;
    position: relative;
    top: 0;
}


/* Contact list image-box - desktop styles */
@media (min-width: 992px) {
.inventory-section .side-bar-column .inner-column .contact-box .content-box .contact-list li a .image-box {
    display: flex;
    align-items: center;
    justify-content: center;
}

.inventory-section .side-bar-column .inner-column .contact-box .content-box .contact-list li a .image-box img {
    display: block;
    margin: 0 auto;
    }
}


.mobile-scroll-to-contact {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    height: 56px;
    border-radius: 0;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: white;
    border: none;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    z-index: 10; 
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 16px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.mobile-scroll-to-contact:hover,
.mobile-scroll-to-contact:active {
    background: linear-gradient(135deg, #128C7E 0%, #25D366 100%);
    box-shadow: 0 -4px 15px rgba(37, 211, 102, 0.5);
}

.mobile-scroll-to-contact svg {
    display: none;
}

@media (max-width: 991px) {
    .mobile-scroll-to-contact {
        display: flex !important;
    }
}

/* Price Offer Section Styles */
.offer-section {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.offer-section label {
    font-weight: 600;
    font-size: 16px;
    color: #050B20;
    display: block;
}

.offer-product-info {
    padding: 12px;
    background: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #e9ecef;
}

.offer-product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e9ecef;
}

.offer-product-title {
    font-size: 14px;
    font-weight: 500;
    color: #050B20;
    margin-bottom: 4px;
    line-height: 1.4;
}

.offer-product-price {
    font-size: 13px;
    color: #666;
}

.offer-options {
    margin-top: 16px;
}

.offer-option {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    background: #fff;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 80px;
}

.offer-option:hover {
    border-color: #405FF2;
    background: #f8f9ff;
}

.offer-option.active {
    border-color: #17a2b8;
    background: #e6f7fa;
    box-shadow: 0 2px 8px rgba(23, 162, 184, 0.2);
}

.offer-price {
    font-size: 16px;
    font-weight: 600;
    color: #050B20;
    margin-bottom: 4px;
}

.offer-discount {
    font-size: 12px;
    color: #666;
}

.custom-price-input {
    margin-top: 12px;
}

.custom-price-input .form-control {
    border: 2px solid #e9ecef;
    border-radius: 6px;
    padding: 10px 12px;
    font-size: 16px;
    transition: all 0.2s ease;
}

.custom-price-input .form-control:focus {
    border-color: #17a2b8;
    box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
}

.custom-price-input .form-control:disabled {
    background-color: #f8f9fa !important;
    cursor: not-allowed !important;
    opacity: 0.7;
    color: #6c757d;
}


.custom-price-input .input-group-text {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-right: none;
    border-radius: 6px 0 0 6px;
    font-weight: 500;
    color: #050B20;
}

.offer-total {
    padding: 12px;
    background: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    font-size: 14px;
}

.offer-total strong {
    color: #050B20;
    font-size: 16px;
}

@media (max-width: 576px) {
    .offer-option {
        min-height: 70px;
        padding: 10px 6px;
    }
    
    .offer-price {
        font-size: 14px;
    }
    
    .offer-discount {
        font-size: 11px;
    }
}
</style>
@endpush

<!-- Mobile Scroll to Contact Button -->
<button id="mobile-scroll-to-contact" class="mobile-scroll-to-contact" title="{{ __('messages.make_an_offer') }}">
    {{ __('messages.make_an_offer') }}
</button>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile button to open contact modal
        const mobileButton = document.getElementById('mobile-scroll-to-contact');
        const contactModal = document.getElementById('contactModal');
        
        if (mobileButton && contactModal) {
            // Add click handler to open modal
            mobileButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Open the contact modal using Bootstrap
                if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modal = new bootstrap.Modal(contactModal);
                    modal.show();
                } else if (typeof $ !== 'undefined' && $.fn.modal) {
                    // Fallback to jQuery Bootstrap modal
                    $(contactModal).modal('show');
                } else {
                    // Fallback: manually show modal
                    contactModal.classList.add('show');
                    contactModal.style.display = 'block';
                    document.body.classList.add('modal-open');
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    document.body.appendChild(backdrop);
                }
            });
        } else if (mobileButton && !contactModal) {
            // Hide button if modal doesn't exist
            mobileButton.style.display = 'none';
        }
        
        // Mobile layout reordering - physically move elements in DOM
        function reorderMobileLayout() {
            const gallerySec = document.querySelector('.gallery-sec');
            const mainRow = document.querySelector('.gallery-main-row');
            const thumbnailsRow = document.querySelector('.gallery-thumbnails-row');
            const sideBarColumn = document.querySelector('.gallery-main-row .side-bar-column');
            
            if (!gallerySec || !mainRow || !thumbnailsRow || !sideBarColumn) {
                return;
            }
            
            if (window.innerWidth <= 768) {
                // Mobile: Move thumbnails INSIDE mainRow, between image and sidebar
                if (!gallerySec.classList.contains('mobile-reordered')) {
                    // Move thumbnails row inside mainRow, before sidebar
                    mainRow.insertBefore(thumbnailsRow, sideBarColumn);
                    gallerySec.classList.add('mobile-reordered');
                }
            } else {
                // Desktop: Move thumbnails back to after mainRow
                if (gallerySec.classList.contains('mobile-reordered')) {
                    gallerySec.insertBefore(thumbnailsRow, mainRow.nextSibling);
                    gallerySec.classList.remove('mobile-reordered');
                }
            }
        }
        
        // Run on load and resize
        reorderMobileLayout();
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(reorderMobileLayout, 100);
        });
        
        // Gallery image swap functionality
        const mainImage = document.getElementById('main-image');
        const mainImageLink = document.getElementById('main-image-link');
        const thumbnailItems = document.querySelectorAll('.thumbnail-item');
        
        if (mainImage && thumbnailItems.length > 0) {
            // Store original main image data
            const originalMainImageSrc = mainImage.src;
            const originalMainImagePreview = mainImage.getAttribute('data-preview-url');
            
            // Function to update active thumbnail
            function updateActiveThumbnail(previewUrl) {
                thumbnailItems.forEach(function(item) {
                    const itemPreviewUrl = item.getAttribute('data-preview-url');
                    if (itemPreviewUrl === previewUrl) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                });
            }
            
            // Add click handler to each thumbnail
            thumbnailItems.forEach(function(thumbnail) {
                const thumbnailImg = thumbnail.querySelector('img');
                const thumbnailLink = thumbnail.querySelector('.thumbnail-link');
                
                if (thumbnailImg && thumbnailLink) {
                    const previewUrl = thumbnail.getAttribute('data-preview-url');
                    
                    // Prevent default fancybox on thumbnail click, swap image instead
                    thumbnailLink.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Swap main image
                        mainImage.src = previewUrl;
                        mainImage.setAttribute('data-preview-url', previewUrl);
                        mainImageLink.href = previewUrl;
                        
                        // Update active state
                        updateActiveThumbnail(previewUrl);
                    });
                }
            });
            
            // Make main image clickable to open preview (fancybox)
            // The fancybox attribute already handles this, but we ensure it works
            if (mainImageLink) {
                // Fancybox will handle the preview automatically
                // No additional code needed
            }
        }
    });
</script>
@endpush
