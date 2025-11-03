@extends('master')
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
                <div class="text">{{ $advertisement->version_model }}</div>
                <div class="content-box">
                    <h3 class="title">€{{ $advertisement->final_price }}</h3>
                    <div class="">
                        @include('wizmoto.partials.price-evaluation-badge', ['value' => $advertisement->price_evaluation])
                    </div>
                </div>
            </div>
            <div class="gallery-sec">
                <div class="row">
                    <div class="image-column item1 col-lg-7 col-md-12 col-sm-12">
                        <div class="inner-column">
                            @php $images = $advertisement->getMedia('covers'); @endphp
                            <div class="image-box">
                                <figure class="image">
                                    <a href="{{ $images->first()->getUrl('preview') }}" data-fancybox="gallery">
                                        <img src="{{ $images->first()->getUrl('preview') }}" alt="">
                                    </a>
                                </figure>
                                <div class="content-box">
                                    <ul class="video-list">
                                        {{--                                        <li><a href="https://www.youtube.com/watch?v=7e90gBu4pas" data-fancybox="gallery2"><img src="images/resource/video1-1.svg">Video</a></li> --}}
                                        {{--                                        <li><a href="#"><img src="images/resource/video1-2.svg">360 View</a></li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 col-sm-12">
                        <div class="row">

                            @foreach ($images->skip(1) as $image)
                                <div class="image-column-two item2 col-6">
                                    <div class="inner-column">
                                        <div class="image-box">
                                            <figure class="image">
                                                <a href="{{ $image->getUrl('preview') }}" data-fancybox="gallery"
                                                    class="fancybox">
                                                    <img src="{{ $image->getUrl('square') }}" loading="lazy"
                                                        alt="">
                                                </a>
                                            </figure>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="inspection-column col-lg-8 col-md-12 col-sm-12">
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
                                                @endif
                                                @if($advertisement->vehicleBody?->name)
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-1.svg') }}">{{ __('messages.body_type') }}
                                                </span>
                                                    {{ $advertisement->vehicleBody->localized_name }}
                                                </li>
                                                @endif
                                                @if($advertisement->vehicleColor?->name)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-11.svg') }}">{{ __('messages.exterior_color_field') }}
                                                    </span>
                                                    {{ $advertisement->vehicleColor->localized_name }}@if ($advertisement->is_metallic_paint) <small>{{ __('messages.metallic') }}</small>@endif
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
                                                @endif
                                                @if($advertisement->mileage)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-2.svg') }}">{{ __('messages.mileage') }}</span>
                                                    {{ number_format($advertisement->mileage) }} km
                                                </li>
                                                @endif
                                                @if($advertisement->previous_owners)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.previous_owners_label') }}
                                                    </span>
                                                    {{ $advertisement->previous_owners }}
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
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Engine Specifications Section --}}
                            @if($advertisement->fuelType?->name || $advertisement->motor_change || $advertisement->motor_displacement || $advertisement->motor_cylinders || $advertisement->motor_power_kw || $advertisement->motor_power_cv || $advertisement->motor_marches || $advertisement->drive_type || $advertisement->motor_empty_weight)
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
                                                @endif
                                                @if($advertisement->motor_change)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-5.svg') }}">{{ __('messages.transmission_label') }}
                                                    </span>
                                                    {{ $advertisement->motor_change }}
                                                </li>
                                                @endif
                                                @if($advertisement->motor_displacement)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.displacement_cc') }}
                                                    </span>
                                                    {{ $advertisement->motor_displacement }} cc
                                                </li>
                                                @endif
                                                @if($advertisement->motor_cylinders)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-10.svg') }}">{{ __('messages.cylinders') }}
                                                    </span>
                                                    {{ $advertisement->motor_cylinders }}
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
                                                @endif
                                                @if($advertisement->motor_marches)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-5.svg') }}">{{ __('messages.number_of_gears') }}
                                                    </span>
                                                    {{ $advertisement->motor_marches }}
                                                </li>
                                                @endif
                                                @if($advertisement->drive_type)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.drive_type') }}
                                                    </span>
                                                    {{ $advertisement->drive_type }}
                                                </li>
                                                @endif
                                                @if($advertisement->motor_empty_weight)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.empty_weight') }}
                                                    </span>
                                                    {{ $advertisement->motor_empty_weight }} {{ __('messages.kg') }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Performance & Efficiency Section --}}
                            @if($advertisement->top_speed_kmh || $advertisement->torque_nm || $advertisement->seat_height_mm || $advertisement->combined_fuel_consumption || $advertisement->co2_emissions || $advertisement->tank_capacity_liters)
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
                                                @endif
                                                @if($advertisement->torque_nm)
                                            <li>
                                                <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.torque_nm') }}
                                                </span>
                                                    {{ $advertisement->torque_nm }} Nm
                                            </li>
                                                @endif
                                                @if($advertisement->seat_height_mm)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-8.svg') }}">{{ __('messages.seat_height_mm') }}
                                                    </span>
                                                    {{ $advertisement->seat_height_mm }} mm
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
                                                @endif
                                                @if($advertisement->co2_emissions)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.co2_emissions_label') }}
                                                    </span>
                                                    {{ $advertisement->co2_emissions }} {{ __('messages.gkm') }}
                                                </li>
                                                @endif
                                                @if($advertisement->tank_capacity_liters)
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-3.svg') }}">{{ __('messages.tank_capacity_label') }}
                                                    </span>
                                                    {{ $advertisement->tank_capacity_liters }} {{ __('messages.l') }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Pricing & Sales Section --}}
                            @if($advertisement->final_price || $advertisement->price_negotiable || $advertisement->financing_available || $advertisement->trade_in_possible)
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
                                                    €{{ number_format($advertisement->final_price, 0, ',', '.') }}
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
                            @endif

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
                                                @endif
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.service_history_available') }}
                                                    </span>
                                                    {{ $advertisement->service_history_available ? __('messages.yes') : __('messages.no') }}
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
                                                    {{ $advertisement->warranty_available ? __('messages.yes') : __('messages.no') }}
                                                </li>
                                                <li>
                                                    <span>
                                                        <img src="{{ asset('wizmoto/images/resource/insep1-4.svg') }}">{{ __('messages.available_immediately') }}
                                                    </span>
                                                    {{ $advertisement->available_immediately ? __('messages.yes') : __('messages.no') }}
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
                        @if($advertisement->description && trim($advertisement->description) !== '')
                        <div class="description-sec">
                            <h4 class="title">{{ __('messages.description') }}</h4>
                            <div class="text two">{{ $advertisement->description }}</div>
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
                <div class="side-bar-column style-1 col-lg-4 col-md-12 col-sm-12">
                    <div class="inner-column">
                        <div class="contact-box">
                            <div class="icon-box">
                                @if($advertisement->provider?->getFirstMediaUrl('image', 'thumb'))
                                    <img src="{{ $advertisement->provider->getFirstMediaUrl('image', 'thumb') }}"
                                        alt="Provider Image"
                                        style="width: 80px; height: 80px; border-radius: 80%; object-fit: cover;">
                                @else
                                    <div style="width: 80px; height: 80px; border-radius: 80%; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" fill="#666"/>
                                            <path d="M12 14C7.58172 14 4 17.5817 4 22H20C20 17.5817 16.4183 14 12 14Z" fill="#666"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="content-box">
                                {{-- Dealer / Provider Name (assuming from provider relation) --}}
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
                                        Chat Via Whatsapp
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
                    <div class="row car-slider-three slider-layout-1" data-preview="4.8">
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
                                                $remainingImages = $images->skip(1)->take(2);
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
                                        <div class="text">{{$relatedAd->version_model}}</div>
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
                                            <span>€{{$relatedAd->final_price}}</span>
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
                    <h5 class="modal-title" id="contactModalLabel">💬 {{ __('messages.contact') }} {{ $advertisement->provider->full_name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="contact-form" class="inventroy-widget">
                        <p class="text-muted mb-4">{{ __('messages.send_message_cta') }}</p>

                        <form id="initiate-contact-form" method="POST" action="{{ route('chat.initiate') }}">
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


                            <div class="form-column col-lg-12">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.message') }} *</label>
                                    <textarea id="contact-message"
                                        placeholder="{{ __('messages.message') }}"
                                        required></textarea>
                                </div>
                            </div>


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
                                        {{ __('messages.send_message') }} <i class="fa fa-paper-plane"></i>
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
    /* Reduce space between related-cars slider arrows and cards on mobile */
    @media (max-width: 768px) {
        .cars-section-three .car-slider-three {
            padding-bottom: 8px !important;
        }
        .cars-section-three .car-slider-three .slick-list {
            padding-bottom: 8px !important;
            margin-bottom: 0 !important;
        }
        .cars-section-three .car-slider-three .slick-prev,
        .cars-section-three .car-slider-three .slick-next {
            top: 50% !important;
            bottom: auto !important;
            transform: translateY(-50%) !important;
            z-index: 2 !important;
        }
        .cars-section-three .car-slider-three .slick-prev {
            left: 0 !important;
            right: auto !important;
        }
        .cars-section-three .car-slider-three .slick-next {
            right: 0 !important;
            left: auto !important;
        }
    }
    </style>
@endpush
@include('wizmoto.partials.badge-styles')
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
                const providerId = {{ $advertisement->provider->id }};

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
</style>
@endpush
