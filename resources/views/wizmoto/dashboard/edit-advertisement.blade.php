@extends('wizmoto.dashboard.master')
@section('dashboard-content')
    <div class="content-column">
        <div class="inner-column">
            <div class="list-title">
                <h3 class="title">{{ __('messages.edit_advertisement') }}</h3>
            </div>
            <div class="form-box">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">{{ __('messages.vehicle_details') }}</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form class="row" action="{{ route('dashboard.update-advertisement') }}" method="POST"
                            id="advertisementForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                            <input type="hidden" name="advertisement_id" value="{{ $advertisement->id }}">
                            {{-- Vehicle data --}}
                            <h6>{{ __('messages.vehicle_data') }}</h6>
                            <div class="form-column col-lg-12">
                                <span class="error-text text-red-600 text-sm mt-1 block"></span>
                                <div class="form_boxes">
                                    <label>{{ __('messages.sell') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu" id="advertisement-type-dropdown">
                                        <div class="select">
                                            <span
                                                class="selected">{{ old('advertisement_type_id', $advertisement->advertisementType->title ?? 'Selection') }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="advertisement_type_id" id="advertisement_type_id_input"
                                            value="{{ old('advertisement_type_id', $advertisement->advertisement_type_id ?? '') }}">
                                        <ul class="dropdown" style="display: none;">
                                            @foreach ($advertisementTypes as $advertisementType)
                                                <li data-id="{{ $advertisementType->id }}">{{ $advertisementType->title }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <span class="error-text text-red-600 text-sm mt-1 block"></span>
                                <div class="form_boxes">
                                    <label>{{ __('messages.brand') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu searchable-dropdown" id="brand-dropdown">
                                        <div class="select">
                                            <span
                                                class="selected">{{ old('brand_id', $advertisement->brand->name ?? 'Selection') }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="brand_id" id="brand_id_input"
                                            value="{{ old('brand_id', $advertisement->brand_id ?? '') }}">
                                        <ul class="dropdown" style="display: none;">
                                            @foreach ($brands as $brand)
                                                <li data-id="{{ $brand->id }}">{{ $brand->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <span class="error-text text-red-600 text-sm mt-1 block"></span>
                                <div class="form_boxes">
                                    <label>{{ __('messages.model') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu searchable-dropdown" id="model-dropdown">
                                        <div class="select">
                                            <span
                                                class="selected">{{ old('vehicle_model_id', $advertisement->vehicleModel->name ?? 'Selection') }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="vehicle_model_id" id="vehicle_model_id_input"
                                            value="{{ old('vehicle_model_id', $advertisement->vehicle_model_id ?? '') }}">
                                        <ul class="dropdown" style="display: none;" id="model-select">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.version') }}</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="version_model"
                                            value="{{ old('version_model', $advertisement->version_model ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="my-5" />
                            {{-- Characteristics --}}
                            <h6>{{ __('messages.characteristics') }}</h6>
                            <div class="form-column col-lg-6">
                                <span class="error-text text-red-600 text-sm mt-1 block"></span>
                                <div class="form_boxes">
                                    <label>{{ __('messages.body_work') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu" id="vehicle_body-dropdown">
                                        <div class="select">
                                            <span
                                                class="selected">{{ old('vehicle_body_id', $advertisement->vehicleBody->localized_name ?? __('messages.selection')) }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="vehicle_body_id"
                                            value="{{ old('vehicle_body_id', $advertisement->vehicle_body_id ?? '') }}">
                                        <ul class="dropdown" style="display: none;">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-12">
                                <div class="form_boxes">
                                    <label>{{ __('messages.exterior_color') }}</label>
                                    <div class="color-picker">
                                        @foreach ($vehicleColors as $color)
                                            <div class="color-item">
                                                <input type="radio" id="color-{{ $color->id }}" name="color_id"
                                                    value="{{ $color->id }}"
                                                    {{ $advertisement->color_id == $color->id ? 'checked' : '' }}>
                                                <label for="color-{{ $color->id }}" class="color-circle"
                                                    style="background-color: {{ $color->hex_code }}"></label>
                                                <span class="color-label">{{ $color->localized_name }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="cheak-box">
                                    <label class="contain">{{ __('messages.metallic_paint') }}
                                        <input type="checkbox" name="is_metallic_paint"
                                            {{ $advertisement->is_metallic_paint ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <hr class="my-5" />
                            {{-- State --}}
                            <h6>{{ __('messages.state') }}</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>{{ __('messages.vehicle_category_field') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu" id="vehicle-category-dropdown">
                                        <div class="select">
                                            <span
                                                class="selected">{{ old('vehicle_category', $advertisement->vehicle_category ?? 'Selection') }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="vehicle_category"
                                            value="{{ old('vehicle_category', $advertisement->vehicle_category ?? '') }}">
                                        <ul class="dropdown" style="display: none;">
                                            <li data-id="Used">Used</li>
                                            <li data-id="Era">Era</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.mileage') }}(Km) <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu active">
                                        <input type="text" name="mileage" placeholder=""
                                            value="{{ old('mileage', $advertisement->mileage ?? '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>{{ __('messages.registration_month') }} <span style="color: #ef4444;">*</span></label>
                                        <div class="drop-menu" id="registration-month-dropdown">
                                            <div class="select">
                                                <span
                                                    class="selected">{{ old('registration_month', $advertisement->registration_month ?? 'Selection') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="registration_month"
                                                value="{{ old('registration_month', $advertisement->registration_month ?? '') }}">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach (range(1, 12) as $m)
                                                    <li data-id="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                                        {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>{{ __('messages.registration_year') }} <span style="color: #ef4444;">*</span></label>
                                        <div class="drop-menu" id="registration-year-dropdown">
                                            <div class="select">
                                                <span
                                                    class="selected">{{ old('registration_year', $advertisement->registration_year ?? 'Selection') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="registration_year"
                                                value="{{ old('registration_year', $advertisement->registration_year) }}">
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
                            </div>
                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Next review Year</label>
                                        <div class="drop-menu" id="next-review-dropdown">
                                            <div class="select">
                                                <span
                                                    class="selected">{{ old('next_review_month', $advertisement->next_review_month ?? 'Selection') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="next_review_month"
                                                value="{{ old('next_review_month', $advertisement->next_review_month) }}">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach (range(1, 12) as $m)
                                                    <li data-id="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                                        {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</li>
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
                                                <span
                                                    class="selected">{{ old('next_review_year', $advertisement->next_review_year ?? 'Selection') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="next_review_year"
                                                value="{{ old('next_review_year', $advertisement->next_review_year) }}">
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
                            </div>
                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Last Service Year</label>
                                        <div class="drop-menu" id="last-service-dropdown">
                                            <div class="select">
                                                <span
                                                    class="selected">{{ old('last_service_month', $advertisement->last_service_month ?? 'Selection') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="last_service_month"
                                                value="{{ old('last_service_month', $advertisement->last_service_month) }}">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach (range(1, 12) as $m)
                                                    <li data-id="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                                        {{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</li>
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
                                                <span
                                                    class="selected">{{ old('last_service_year', $advertisement->last_service_year ?? 'Selection') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="last_service_year"
                                                value="{{ old('last_service_year', $advertisement->last_service_year) }}">
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
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="btn-box">
                                    <label>{{ __('messages.previous_owners') }}</label>
                                    <div class="number" style="padding: 10px">
                                        <span class="minus">-</span>
                                        <input type="text" name="previous_owners"
                                            value="{{ old('previous_owners', $advertisement->previous_owners ?? 1) }}">
                                        <span class="plus">+</span>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-5" />
                            {{-- Equipment --}}
                            <h6>{{ __('messages.equipment') }}</h6>
                            <div class="form-column col-lg-12 mb-5">
                                <div class="cheak-box">
                                    <div class="equipment-list-inventory row g-4" >
                                        @foreach ($equipments as $equipment)
                                        <div class="equipment-item-list col-3" style="display: flex;
            align-items: center;
            gap: 10px;">
                                            <label class="contain">
                                                {{ $equipment->localized_name }}
                                                <input type="checkbox" name="equipments[]" value="{{ $equipment->id }}"
                                                    {{ $advertisement->equipments->pluck('id')->contains($equipment->id) ? 'checked' : '' }}>
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <hr class="my-5" />

                            {{-- Motor --}}
                            <h6>{{ __('messages.motor') }}</h6>
                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>{{ __('messages.change') }}</label>
                                        <div class="drop-menu" id="motor-change-dropdown">
                                            <div class="select">
                                                <span
                                                    class="selected">{{ old('motor_change', $advertisement->motor_change ?? 'Selection') }}</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="motor_change"
                                                value="{{ old('motor_change', $advertisement->motor_change) }}">
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
                                    <label>{{ __('messages.power_kw_field') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu active">
                                        <input name="motor_power_kw" type="number" maxlength="4" placeholder=""
                                            value="{{ old('motor_power_kw', $advertisement->motor_power_kw) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.power_cv_field') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu active">
                                        <input name="motor_power_cv" type="number" maxlength="4" placeholder=""
                                            value="{{ old('motor_power_cv', $advertisement->motor_power_cv) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-column col-lg-6 mb-5">
                                <div class="btn-box">
                                    <label>{{ __('messages.marches') }}</label>
                                    <div class="number" style="padding: 10px">
                                        <span class="minus">-</span>
                                        <input type="text"
                                            value="{{ old('motor_marches', $advertisement->motor_marches ?? 1) }}"
                                            name="motor_marches">
                                        <span class="plus">+</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-column col-lg-6 mb-5">
                                <div class="btn-box">
                                    <label>{{ __('messages.cylinders') }}</label>
                                    <div class="number" style="padding: 10px">
                                        <span class="minus">-</span>
                                        <input type="text"
                                            value="{{ old('motor_cylinders', $advertisement->motor_cylinders ?? 1) }}"
                                            name="motor_cylinders">
                                        <span class="plus">+</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>{{ __('messages.displacement_cc') }}</label>
                                        <div class="drop-menu" id="motor-displacement-dropdown">
                                            <input type="text" name="motor_displacement" placeholder=""
                                                value="{{ old('motor_displacement', $advertisement->motor_displacement) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>{{ __('messages.empty_weight_kg') }}</label>
                                        <div class="drop-menu" id="motor-empty-weight-dropdown">
                                            <input type="text" name="motor_empty_weight" placeholder=""
                                                value="{{ old('motor_empty_weight', $advertisement->motor_empty_weight) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Environment --}}
                            <h6>{{ __('messages.environment') }}</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>{{ __('messages.fuel_type') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu" id="fuel-type-dropdown">
                                        <div class="select">
                                            <span
                                                class="selected">{{ old('fuel_type_id', $advertisement->fuelType->name) }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="fuel_type_id"
                                            value="{{ old('fuel_type_id', $advertisement->fuel_type_id) }}">
                                        <ul class="dropdown" style="display: none;">

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.combined_fuel_consumption') }}</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="combined_fuel_consumption" maxlength="5"
                                            value="{{ old('combined_fuel_consumption', $advertisement->combined_fuel_consumption) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.combined_cycle_co2') }}</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="co2_emissions" maxlength="14"
                                            value="{{ old('co2_emissions', $advertisement->co2_emissions) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>{{ __('messages.emissions_class') }}</label>
                                    <div class="drop-menu" id="emissions_class-dropdown">
                                        <div class="select">
                                            <span
                                                class="selected">{{ old('emissions_class', $advertisement->emissions_class ?? 'Selection') }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="emissions_class"
                                            value="{{ old('emissions_class', $advertisement->emissions_class) }}">
                                        <ul class="dropdown" style="display: none;">
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
                                                <li data-id="{{ $emissionsClass }}">{{ $emissionsClass }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- Photo --}}
                            <h6>{{ __('messages.photo') }}</h6>
                            <div class="gallery-sec style1" id="media">
                                <div class="right-box-three">
                                    <h6 class="title">{{ __('messages.gallery') }}</h6>
                                    <div class="gallery-box">
                                        <div class="inner-box" id="preview-container">
                                            @if (!empty($advertisement->getMedia('covers')))
                                                @foreach ($advertisement->getMedia('covers') as $image)
                                                    <div class="image-box" data-id="{{ $image->id }}"
                                                        data-filename="{{ $image->file_name }}"
                                                        data-token="existing:{{ $image->id }}">
                                                        <img src="{{ $image->getUrl() }}" alt="Preview"
                                                            style="max-width: 200px; border-radius: 6px;">

                                                        <div class="content-box">
                                                            <ul class="social-icon">
                                                                <li>
                                                                    <a href="#" class="delete-btn">
                                                                        <img
                                                                            src="{{ asset('wizmoto/images/resource/delet.svg') }}">
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <input type="hidden" name="images_order" id="images_order_input">
                                            @endif

                                            <div class="uplode-box"
                                                style="display: @if ($advertisement->getMedia('covers')->count() < 5) block @else none @endif">
                                                <div class="content-box">
                                                    <label for="fileInput" id="uploadTrigger">
                                                        <img src="{{ asset('wizmoto/images/resource/uplode.svg') }}">
                                                        <span>{{ __('messages.upload') }}</span>
                                                    </label>
                                                    <input type="file" name="images[]" id="fileInput" multiple
                                                        style="display:none">
                                                    <span class="lnr-icon-spinner spinner" style="display:none;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text">{{ __('messages.upload_instructions') }}</div>
                                    </div>
                                </div>
                            </div>
                            {{-- Vehicle description --}}
                            <h6>{{ __('messages.vehicle_description') }}</h6>
                            <div class="form-column col-lg-12">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.vehicle_description') }}</label>
                                    <div class="drop-menu active">
                                        <textarea name="description" placeholder="">{{ old('description', $advertisement->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            {{-- price --}}
                            <h6>{{ __('messages.final_price') }}</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.final_price') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu active">
                                        <input type="text" name="final_price"
                                            value="{{ old('final_price', $advertisement->final_price) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-12">
                                <div class="cheak-box">
                                    <label class="contain">{{ __('messages.deductible_vat') }}
                                        <input type="checkbox" name="tax_deductible"
                                            {{ $advertisement->tax_deductible ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-column col-lg-12">
                                <div class="cheak-box">
                                    <label class="contain">{{ __('messages.price_negotiable') }}
                                        <input type="checkbox" name="price_negotiable"
                                            {{ $advertisement->price_negotiable ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <hr class="my-5"/>
                            {{-- Vehicle Condition --}}
                            <h6>{{ __('messages.vehicle_condition') }}</h6>
                            <div class="form-column col-lg-6">
                                <div class="cheak-box">
                                    <label class="contain">{{ __('messages.service_history_available') }}
                                        <input type="checkbox" name="service_history_available" value="1" {{ $advertisement->service_history_available ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="cheak-box">
                                    <label class="contain">{{ __('messages.warranty_available') }}
                                        <input type="checkbox" name="warranty_available" value="1" {{ $advertisement->warranty_available ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <hr class="my-5"/>
                            {{-- Technical Specs --}}
                            <h6>{{ __('messages.technical_specifications') }}</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>{{ __('messages.drive_type') }}</label>
                                    <div class="drop-menu" id="drive-type-dropdown">
                                        <div class="select">
                                            <span class="selected">{{ old('drive_type', $advertisement->drive_type ?? __('messages.select_drive_type')) }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="drive_type" id="drive_type_input" value="{{ old('drive_type', $advertisement->drive_type) }}">
                                        <ul class="dropdown" style="display: none;">
                                            <li data-id="Chain">Chain</li>
                                            <li data-id="Belt">Belt</li>
                                            <li data-id="Shaft">Shaft</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.tank_capacity_liters') }}</label>
                                    <div class="drop-menu active">
                                        <input type="number" name="tank_capacity_liters" step="0.01" min="0" max="100" value="{{ old('tank_capacity_liters', $advertisement->tank_capacity_liters) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.seat_height_mm') }}</label>
                                    <div class="drop-menu active">
                                        <input type="number" name="seat_height_mm" min="0" max="2000" value="{{ old('seat_height_mm', $advertisement->seat_height_mm) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.top_speed_kmh') }}</label>
                                    <div class="drop-menu active">
                                        <input type="number" name="top_speed_kmh" min="0" max="500" value="{{ old('top_speed_kmh', $advertisement->top_speed_kmh) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.torque_nm') }}</label>
                                    <div class="drop-menu active">
                                        <input type="number" name="torque_nm" min="0" max="10000" value="{{ old('torque_nm', $advertisement->torque_nm) }}">
                                    </div>
                                </div>
                            </div>

                            <hr class="my-5"/>
                            {{-- Sales Features --}}
                            <h6>{{ __('messages.sales_features') }}</h6>
                            <div class="form-column col-lg-4">
                                <div class="cheak-box">
                                    <label class="contain">{{ __('messages.financing_available') }}
                                        <input type="checkbox" name="financing_available" value="1" {{ $advertisement->financing_available ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-column col-lg-4">
                                <div class="cheak-box">
                                    <label class="contain">{{ __('messages.trade_in_possible') }}
                                        <input type="checkbox" name="trade_in_possible" value="1" {{ $advertisement->trade_in_possible ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="form-column col-lg-4">
                                <div class="cheak-box">
                                    <label class="contain">{{ __('messages.available_immediately') }}
                                        <input type="checkbox" name="available_immediately" value="1" {{ $advertisement->available_immediately ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <hr class="my-5"/>
                            {{-- Contact --}}
                            <h6>{{ __('messages.contact') }}</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.zip_code') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu active">
                                        <input type="text" name="zip_code"
                                            value="{{ old('zip_code', $advertisement->zip_code) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.country') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu searchable-dropdown" id="country-dropdown">
                                        <div class="select">
                                            <span>{{ $advertisement->city ? __('messages.select_country') : __('messages.select_country') }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="country_id" id="country_id_input" value="{{ $advertisement->city ?? '' }}">
                                        <ul class="dropdown" style="display: none;">
                                            @foreach($countries as $country)
                                                <li data-id="{{ $country->id }}">{{ $country->name }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.city') }} <span style="color: #ef4444;">*</span></label>
                                    <div class="drop-menu searchable-dropdown" id="city-dropdown">
                                        <div class="select">
                                            <span>{{ $advertisement->city ?? __('messages.select_city') }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="city" id="city_input" value="{{ old('city', $advertisement->city ?? '') }}">
                                        <ul class="dropdown" id="cities-list" style="display: none;">
                                            <li class="placeholder">{{ __('messages.please_select_country_first') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="form-column col-lg-4">
                                <div class="form_boxes">
                                    <label>{{ __('messages.international_prefix') }}</label>
                                    <div class="drop-menu" id="international-prefix-dropdown">
                                        <div class="select">
                                            <span
                                                class="selected">{{ old('international_prefix', $advertisement->international_prefix ?? '+39') }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="international_prefix" id="international_prefix_input"
                                            value="{{ old('international_prefix', $advertisement->international_prefix ?? '+39') }}">
                                        <ul class="dropdown" style="display: none;">
                                            @foreach ($internationalPrefixes as $internationalPrefix)
                                                <li data-id="{{ $internationalPrefix }}">{{ $internationalPrefix }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-4">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.prefix') }}</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="prefix"
                                            value="{{ old('prefix', $advertisement->prefix) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-4">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.telephone') }}</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="telephone"
                                            value="{{ old('telephone', $advertisement->telephone) }}"
                                            pattern="[0-9]{8}" maxlength="8" placeholder="" >
                                    </div>
                                </div>
                            </div>

                            <div class="form-column col-lg-12">
                                <div class="cheak-box">
                                    <label class="contain">{{ __('messages.display_phone_number') }}?
                                        <input type="checkbox" name="show_phone"
                                            {{ $advertisement->show_phone ? 'checked' : '' }}>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-submit">
                                    <button type="submit" class="theme-btn">{{ __('messages.submit') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 14 14" fill="none">
                                            <g clip-path="url(#clip0_711_3214)">
                                                <path
                                                    d="M13.6106 0H5.05509C4.84013 0 4.66619 0.173943 4.66619 0.388901C4.66619 0.603859 4.84013 0.777802 5.05509 0.777802H12.6719L0.113453 13.3362C-0.0384687 13.4881 -0.0384687 13.7342 0.113453 13.8861C0.189396 13.962 0.288927 14 0.388422 14C0.487917 14 0.587411 13.962 0.663391 13.8861L13.2218 1.3277V8.94447C13.2218 9.15943 13.3957 9.33337 13.6107 9.33337C13.8256 9.33337 13.9996 9.15943 13.9996 8.94447V0.388901C13.9995 0.173943 13.8256 0 13.6106 0Z"
                                                    fill="white"></path>
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
            font-size: 16px;
            /* adjust size to match your button */
            margin-left: 8px;
            /* optional spacing */
        }

        .input-error,
        .drop-menu-error {
            border: 1px solid #dc2626 !important;
            /* red border */
            border-radius: 4px;
            padding: 10px;
            /* adjust as needed */
        }

        /* Error message below form box */
        .error-text {
            font-size: 0.875rem;
            /* small */
            color: #dc2626;
            /* red */
            display: block;
            margin-top: 4px;
        }

        #preview-container {
            align-items: center;
        }

        /* Wrapper for each uploaded image */
        #preview-container .image-box {
            position: relative;
            width: 180px;
            /* fixed width */
            height: 180px;
            /* fixed height */
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 8px;
            background: #f5f5f5;
            /* background for better look */
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Image scaling nicely inside box */
        #preview-container .image-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            /* fills box without distortion */
            border-radius: 6px;
        }

        #preview-container .image-box .content-box {

            top: 20%;
            left: 80%;
        }

        .color-picker {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 40px;
            /* horizontal and vertical gaps */
            width: 100%;
            /* or any width that fits two items side by side */

        }

        .color-item {
          
            /* flex-grow:1, flex-shrink:1, flex-basis:50% */
            display: flex;
            align-items: center;

            /* two items per row */
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
            width: 12px;
            /* inner circle size */
            height: 12px;
            border-radius: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .color-picker input[type="radio"]:checked+.color-circle::after {
            opacity: 1;
        }

        .color-label {
            font-size: 14px;
            user-select: none;
        }

        /* Search box in dropdown */
        .search-box {
            padding: 8px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .search-box input {
            width: 100%;
            padding: 8px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        .search-box input:focus {
            outline: none;
            border-color: #667eea;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            // On page load, if advertisement type is selected, load its data
            var currentAdTypeId = $('#advertisement_type_id_input').val();
            var currentBrandId = $('#brand_id_input').val();
            
            if (currentAdTypeId) {
                loadAdvertisementData(currentAdTypeId, function() {
                    // After brands are loaded, if there's a selected brand, load its models
                    if (currentBrandId) {
                        loadModels(currentBrandId);
                    }
                });
            }
        });

        $('#brand-dropdown ul.dropdown').on('click', 'li', function() {
            let brandId = $(this).data('id');
            loadModels(brandId);
        });

        // Handle brand selection
        function loadModels(brandId) {
            let url = "{{ route('vehicle-models.get-models-based-on-brand', ':brandId') }}";
            url = url.replace(':brandId', brandId);
            
            // Store current selected model
            var currentModelId = $('#vehicle_model_id_input').val();
            var currentModelName = $('#model-dropdown .select span').text();

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(models) {

                    let $modelDropdown = $('#model-dropdown ul.dropdown');
                    $modelDropdown.empty();

                    if (models.length === 0) {
                        $modelDropdown.append('<li>No models available</li>');
                        $('#model-dropdown .select span').text('Select');
                        $('#vehicle_model_id_input').val('');
                    } else {
                        // Convert models object to array with id and name
                        let modelsArray = Object.entries(models).map(([id, name]) => ({id: id, name: name}));
                        
                        $.each(models, function(index, model) {
                            $modelDropdown.append('<li data-id="' + index + '">' + model + '</li>');
                        });
                        
                        // Restore selected model if it exists in the loaded data
                        if (currentModelId && models[currentModelId]) {
                            $('#vehicle_model_id_input').val(currentModelId);
                            $('#model-dropdown .select span').text(currentModelName);
                        } else {
                            $('#model-dropdown .select span').text('Select');
                            $('#vehicle_model_id_input').val('');
                        }
                    }
                    
                    // Reinitialize searchable dropdown for model after AJAX load
                    if (typeof initializeSearchableDropdowns === 'function') {
                        initializeSearchableDropdowns();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching models:', error);
                }
            });
        }


        $('#advertisement-type-dropdown ul.dropdown').on('click', 'li', function() {
            let advertisementTypeId = $(this).data('id');
            loadAdvertisementData(advertisementTypeId);
        });


        // Handle drive type dropdown
        $('#drive-type-dropdown ul.dropdown').on('click', 'li', function() {
            let driveType = $(this).data('id');
            $('#drive-type-dropdown .select span').text($(this).text());
            $('#drive_type_input').val(driveType);
            $('#drive-type-dropdown ul.dropdown').hide();
        });

        function loadAdvertisementData(adTypeId, callback) {
            let url = "{{ route('vehicle-models.get-data', ':id') }}";
            url = url.replace(':id', adTypeId);
            
            // Store current values to preserve them
            var currentBrandId = $('#brand_id_input').val();
            var currentBrandName = $('#brand-dropdown .select span').text();
            var currentFuelTypeId = $('input[name="fuel_type_id"]').val();
            var currentFuelTypeName = $('#fuel-type-dropdown .select span').text();
            var currentBodyId = $('input[name="vehicle_body_id"]').val();
            var currentBodyName = $('#vehicle_body-dropdown .select span').text();

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(data) {

                    // ------------------------
                    // Populate Brand Dropdown
                    // ------------------------
                    let $brandDropdown = $('#brand-dropdown ul.dropdown');
                    $brandDropdown.empty();

                    if (data.brands.length === 0) {
                        $brandDropdown.append('<li>No brands available</li>');
                        $('#brand-dropdown .select span').text('Select Brand');
                        $('#brand_id_input').val('');
                    } else {
                        $.each(data.brands, function(index, brand) {
                            $brandDropdown.append('<li data-id="' + brand.id + '">' + brand.name +
                                '</li>');
                        });
                        
                        // Restore selected brand if it exists in the loaded data
                        if (currentBrandId && data.brands.find(b => b.id == currentBrandId)) {
                            $('#brand_id_input').val(currentBrandId);
                            $('#brand-dropdown .select span').text(currentBrandName);
                        } else {
                            $('#brand-dropdown .select span').text('Select Brand');
                            $('#brand_id_input').val('');
                        }
                    }
                    
                    // Reinitialize searchable dropdown for brand after AJAX load
                    if (typeof initializeSearchableDropdowns === 'function') {
                        initializeSearchableDropdowns();
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
                        $.each(data.vehicleBodies, function(index, body) {
                            $bodyDropdown.append('<li data-id="' + body.id + '">' + body.name +
                                '</li>');
                        });
                        
                        // Restore selected vehicle body if it exists in the loaded data
                        if (currentBodyId && data.vehicleBodies.find(b => b.id == currentBodyId)) {
                            $('input[name="vehicle_body_id"]').val(currentBodyId);
                            $('#vehicle_body-dropdown .select span').text(currentBodyName);
                        } else {
                            $('#vehicle_body-dropdown .select span').text('Select BodyWork');
                            $('input[name="vehicle_body_id"]').val('');
                        }
                    }

                    // ------------------------
                    // Populate Equipments
                    // ------------------------
                    let $equipmentList = $('.equipment-list-inventory');
                    $equipmentList.empty();
                    
                    // Get currently selected equipment IDs
                    let selectedEquipmentIds = @json($advertisement->equipments->pluck('id')->toArray());
                    
                    $.each(data.equipments, function(index, equipment) {
                        let isChecked = selectedEquipmentIds.includes(equipment.id) ? 'checked' : '';
                        let equipmentItem = `
                    <div class="equipment-item-list col-3" style="display: flex;
            align-items: center;
            gap: 10px;">
                    <label class="contain">
                        ${equipment.name}
                        <input type="checkbox" name="equipments[]" value="${equipment.id}" ${isChecked}>
                        <span class="checkmark"></span>
                    </label>
                    </div>`;
                        $equipmentList.append(equipmentItem);
                    });

                    // ------------------------
                    // Populate Fuel Types Dropdown
                    // ------------------------
                    let $fuelDropdown = $('#fuel-type-dropdown ul.dropdown');
                    $fuelDropdown.empty();

                    if (data.fuelTypes.length === 0) {
                        $fuelDropdown.append('<li>No Fuel types available</li>');
                        $('#fuel-type-dropdown .select span').text('Select Fuel type');
                        $('input[name="fuel_type_id"]').val('');
                    } else {
                        $.each(data.fuelTypes, function(index, fuel) {
                            $fuelDropdown.append('<li data-id="' + fuel.id + '">' + fuel.name +
                                '</li>');
                        });
                        
                        // Restore selected fuel type if it exists in the loaded data
                        if (currentFuelTypeId && data.fuelTypes.find(f => f.id == currentFuelTypeId)) {
                            $('input[name="fuel_type_id"]').val(currentFuelTypeId);
                            $('#fuel-type-dropdown .select span').text(currentFuelTypeName);
                        } else {
                            $('#fuel-type-dropdown .select span').text('Select Fuel type');
                            $('input[name="fuel_type_id"]').val('');
                        }
                    }
                    
                    // Call callback if provided (for chaining)
                    if (typeof callback === 'function') {
                        callback();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching advertisement data:', error);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            const deleteIconUrl = "{{ asset('wizmoto/images/resource/delet.svg') }}";

            const selectedFiles = [];

            function updateImagesOrder() {
                const order = $("#preview-container .image-box").map(function() {
                    return $(this).data("token");
                }).get();
                $("#images_order_input").val(JSON.stringify(order));
            }

            // File select event handler
            $("#fileInput").on("change", function(e) {
                const currentImageCount = $("#preview-container .image-box").length;
                const newFilesCount = this.files.length;

                if (currentImageCount + newFilesCount > 5) {
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

                let processedFiles = 0;
                const totalFiles = this.files.length;

                Array.from(this.files).forEach(file => {
                    selectedFiles.push(file);
                    const reader = new FileReader();
                    let index = selectedFiles.length - 1;

                    reader.onload = function(event) {
                        const div = $(`
                            <div class="image-box" data-index="${index}" data-token="new:${file.name}">
                                <img src="${event.target.result}" alt="preview" data-filename="${file.name}">
                                <div class="content-box">
                                    <ul class="social-icon">
                                        <li>
                                            <a href="#" class="delete-btn">
                                            <img src="${deleteIconUrl}">                                 
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        `);

                        $("#preview-container .uplode-box").before(div);
                        updateImagesOrder();
                        
                        // Increment processed files counter
                        processedFiles++;
                        
                        // Check if all files have been processed
                        if (processedFiles === totalFiles) {
                            const finalCount = $("#preview-container .image-box").length;
                            console.log("After ADDING, image count is:", finalCount);
                            
                            // After adding the new images, check the new total count.
                            if ($("#preview-container .image-box").length >= 4) {
                                $(".uplode-box").hide();
                            }
                        }
                    };

                    reader.readAsDataURL(file);
                });

                // Clear the file input to allow re-selecting the same file if needed
                $(this).val("");
            });

            // Delete handler
            $("#preview-container").on("click", ".delete-btn", function(e) {
                e.preventDefault();
                const box = $(this).closest(".image-box");
                const token = box.data("token");

                // If it's a "new" file, find and remove it from our tracking array
                if (token && token.startsWith("new:")) {
                    const filename = token.replace("new:", "");
                    const fileIndex = selectedFiles.findIndex(f => f.name === filename);
                    if (fileIndex > -1) {
                        selectedFiles.splice(fileIndex, 1);
                    }
                }

                box.remove();

                // **FIX 2: Logic to show the upload box again moved here**
                if ($("#preview-container .image-box").length < 5) {
                    $(".uplode-box").show();
                }

                updateImagesOrder();
            });

            // Make images sortable
            $("#preview-container").sortable({
                items: ".image-box",
                cancel: ".uplode-box",
                placeholder: "image-box-placeholder",
                tolerance: "pointer",
                helper: "clone",
                start: function(e, ui) {
                    ui.placeholder.height(ui.item.height());
                    ui.placeholder.width(ui.item.width());
                },
                update: function() {
                    updateImagesOrder();
                }
            }).disableSelection();

            // Form submission
            $("#advertisementForm").submit(function(e) {
                e.preventDefault();
                const btn = $(this).find("button[type='submit']");
                btn.prop('disabled', true);
                btn.find(".spinner").show();
                btn.contents().not('.spinner').hide();

                const formData = new FormData(this);

                // Update the final order one last time before submitting
                updateImagesOrder();

                // Append only the NEW files to the form data
                const newFileTokens = JSON.parse($("#images_order_input").val() || '[]').filter(t => t
                    .startsWith("new:"));
                newFileTokens.forEach(token => {
                    const filename = token.replace("new:", "");
                    const file = selectedFiles.find(f => f.name === filename);
                    if (file) {
                        formData.append('images[]', file, file.name);
                    }
                });

                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // ... your success handler
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'Advertisement updated successfully!',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        btn.prop('disabled', false);
                        btn.find(".spinner").hide();
                        btn.contents().not('.spinner').show();
                    },
                    error: function(xhr) {
                        // ... your error handler
                        if (xhr.status === 422) {
                            showValidationErrors(xhr.responseJSON.errors);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Something went wrong!',
                                text: 'Please try again later.'
                            });
                        }
                        btn.prop('disabled', false);
                        btn.find(".spinner").hide();
                        btn.contents().not('.spinner').show();
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
                    $formBox.addClass('input-error'); // text inputs
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

    <script>
        // Handle country dropdown
        $('#country-dropdown .select').on('click', function(e) {
            e.stopPropagation();
        });

        $('#country-dropdown ul.dropdown').on('click', 'li', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            let id = $(this).data('id');
            let name = $(this).text().trim();
            
            if (id) {
                $('#country_id_input').val(id);
                $('#country-dropdown .select span').text(name);
                $('#country-dropdown .dropdown').hide();
                
                // Load cities
                loadCities(id);
            }
        });

        // Handle city dropdown
        $('#city-dropdown .select').on('click', function(e) {
            e.stopPropagation();
            
            // Check if we have cities loaded and need to add search box
            let $cityDropdown = $('#cities-list');
            if ($cityDropdown.find('.dropdown-search').length === 0 && $cityDropdown.find('li[data-id]').length > 0) {
                // Add search box if not exists and we have cities
                $cityDropdown.prepend(`
                    <li class="dropdown-search" style="position: sticky; top: 0; background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%); padding: 12px; border-bottom: 2px solid #e9ecef; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                        <div style="position: relative; display: flex; align-items: center;">
                            <i class="fa fa-search" style="position: absolute; left: 12px; color: #6c757d; font-size: 14px; pointer-events: none;"></i>
                            <input type="text" placeholder="Type to search..." class="dropdown-search-input" style="width: 100%; padding: 10px 12px 10px 38px; border: 2px solid #dee2e6; border-radius: 8px; font-size: 14px; outline: none; transition: all 0.3s ease; background: white;" onclick="event.stopPropagation();">
                        </div>
                    </li>
                `);
                
                // Add search functionality
                $cityDropdown.find('.dropdown-search-input').on('keyup', function(e) {
                    e.stopPropagation();
                    let search = $(this).val().toLowerCase();
                    $cityDropdown.find('li[data-id]').each(function() {
                        let text = $(this).text().toLowerCase();
                        $(this).toggle(text.indexOf(search) > -1);
                    });
                });
            }
        });

        $('#city-dropdown ul.dropdown').on('click', 'li', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Skip placeholder items
            if ($(this).hasClass('placeholder') || !$(this).data('id')) {
                return;
            }
            
            let name = $(this).text().trim();
            
            if (name) {
                $('#city_input').val(name);
                $('#city-dropdown .select span').text(name);
                $('#city-dropdown .dropdown').hide();
            }
        });

        function loadCities(countryId) {
            if (!countryId) {
                $('#cities-list').html('<li class="placeholder">Please select a country first</li>');
                $('#city-dropdown .select span').text('Select City');
                $('#city_input').val('');
                return;
            }

            $('#cities-list').html('<li>Loading cities...</li>');
            $('#city-dropdown .select span').text('Loading...');
            $('#city_input').val('');

            $.ajax({
                url: '{{ route("get-cities") }}',
                method: 'GET',
                data: { country_id: countryId },
                success: function (response) {
                    let citiesHtml = '';
                    if (response.cities && response.cities.length > 0) {
                        response.cities.forEach(function (city) {
                            citiesHtml += '<li data-id="' + city.id + '">' + city.name + '</li>';
                        });
                        $('#city-dropdown .select span').text('Select City');
                    } else {
                        citiesHtml = '<li>No cities found</li>';
                        $('#city-dropdown .select span').text('No cities available');
                    }
                    $('#cities-list').html(citiesHtml);
                },
                error: function () {
                    $('#cities-list').html('<li>Error loading cities</li>');
                    $('#city-dropdown .select span').text('Select City');
                }
            });
        }
    </script>
@endpush
