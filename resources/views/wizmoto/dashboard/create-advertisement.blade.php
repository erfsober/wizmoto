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
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Motor Details</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <form class="row" action="{{ route('dashboard.store-advertisement') }}" method="POST" id="advertisementForm">
                            @csrf
                            {{--Vehicle data--}}
                            <h6>Vehicle data</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>Brand</label>
                                    <div class="drop-menu" id="brand-dropdown">
                                        <div class="select">
                                            <span>Select Brand</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="brand_id" id="brand_id_input">
                                        <ul class="dropdown" style="display: none;">
                                            @foreach($brands as $brand)
                                                <li data-id="{{ $brand->id }}">{{$brand->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
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
                                        <input type="text" name="version">
                                    </div>
                                </div>
                            </div>
                            <hr class="my-5"/>
                            {{--Characteristics--}}
                            <h6>Characteristics</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>Brand</label>
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
                            <div class="form-column col-lg-12">
                                <div class="form_boxes">
                                    <label>Exterior color</label>
                                    <div class="color-picker">
                                        @foreach($vehicleColors as $color)
                                            <div class="color-item">
                                                <input type="radio"
                                                       id="color-{{ $color->id }}"
                                                       name="bodyColor"
                                                       value="{{ $color->name }}">
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
                                            <li>Used</li>
                                            <li>Era</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Mileage</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="Mileage" placeholder="Km">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Registration Month</label>
                                        <div class="drop-menu" id="registration-month-dropdown">
                                            <div class="select">
                                                <span>Select Month</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="registration_month">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach(range(1,12) as $m)
                                                    <li>{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</li>
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
                                                <span>Select Year</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="registration_year">
                                            <ul class="dropdown" style="display: none;">
                                                @php
                                                    $currentYear = date('Y');
                                                @endphp
                                                @for($y = $currentYear; $y >= 1990; $y--)
                                                    <li>{{ $y }}</li>
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
                                                <span>Select Month</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="next_review_month">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach(range(1,12) as $m)
                                                    <li>{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</li>
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
                                                <span>Select Year</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="next_review_year">
                                            <ul class="dropdown" style="display: none;">
                                                @php
                                                    $currentYear = date('Y');
                                                @endphp
                                                @for($y = $currentYear; $y >= 1990; $y--)
                                                    <li>{{ $y }}</li>
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
                                                <span>Select Month</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="last_service_month">
                                            <ul class="dropdown" style="display: none;">
                                                @foreach(range(1,12) as $m)
                                                    <li>{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</li>
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
                                                <span>Select Year</span>
                                                <i class="fa fa-angle-down"></i>
                                            </div>
                                            <input type="hidden" name="last_service_year">
                                            <ul class="dropdown" style="display: none;">
                                                @php
                                                    $currentYear = date('Y');
                                                @endphp
                                                @for($y = $currentYear; $y >= 1990; $y--)
                                                    <li>{{ $y }}</li>
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
                                        @foreach($equipments as $equipment)
                                            <label class="contain">
                                                {{ $equipment->name }}
                                                <input type="checkbox" name="equipments[]" value="{{ $equipment->id }}">
                                                <span class="checkmark"></span>
                                            </label>
                                        @endforeach
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
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Power Kw</label>
                                    <div class="drop-menu active">
                                        <input name="motor_power_kw" type="number" maxlength="4" placeholder="ex. 88">
                                    </div>
                                </div>
                            </div>

                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Power Cv</label>
                                    <div class="drop-menu active">
                                        <input name="motor_power_cv" type="number" maxlength="4" placeholder="ex. 120">
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
                                        <label>Displacement</label>
                                        <div class="drop-menu" id="motor-displacement-dropdown">
                                            <input type="text" name="motor_displacement" placeholder="Engine displacement in cc">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-column col-lg-6">
                                    <div class="form_boxes">
                                        <label>Empty Weight</label>
                                        <div class="drop-menu" id="motor-empty-weight-dropdown">
                                            <input type="text" name="motor_empty_weight" placeholder="Empty weight in kg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Environment--}}
                            <h6>Environment</h6>
                            <div class="form-column col-lg-6">
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
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Combined fuel consumption</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="combined_fuel_consumption" maxlength="5">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Combined cycle CO2 emissions</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="co2_emissions" maxlength="14">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>Emissions class</label>
                                    <div class="drop-menu" id="motor-change-dropdown">
                                        <div class="select">
                                            <span>Select Emissions class</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="fuel_type_id">
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
                            <div class=" gallery-sec style1" id="media" >
                                <div class="right-box-three">
                                    <h6 class="title">Gallery</h6>
                                    <div class="gallery-box">
                                        <div class="inner-box">
                                            <div class="image-box">
                                                <img src="{{asset("wizmoto/images/resource/list2-1.png")}}">
                                                <div class="content-box">
                                                    <ul class="social-icon">
                                                        <li>
                                                            <a href="#">
                                                                <img src="{{asset("wizmoto/images/resource/delet.svg")}}">
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="uplode-box">
                                                <div class="content-box">
                                                    <a href="#">
                                                        <img src="{{asset("wizmoto/images/resource/uplode.svg")}}">
                                                        <span>Upload</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text">You can upload a maximum of 50 images. Please only upload images in JPEG or PNG format</div>
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
                                    <div class="drop-menu" id="brand-dropdown">
                                        <div class="select">
                                            <span>Select International prefix</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="international_prefix" id="international_prefix_input">
                                        <ul class="dropdown" style="display: none;">
                                            @foreach($internationalPrefixes as $internationalPrefix)
                                                <li data-id="{{ $internationalPrefix }}">{{$brand->name}}</li>
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
                                    <button type="submit" class="theme-btn">Submit <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                            <g clip-path="url(#clip0_711_3214)">
                                                <path d="M13.6106 0H5.05509C4.84013 0 4.66619 0.173943 4.66619 0.388901C4.66619 0.603859 4.84013 0.777802 5.05509 0.777802H12.6719L0.113453 13.3362C-0.0384687 13.4881 -0.0384687 13.7342 0.113453 13.8861C0.189396 13.962 0.288927 14 0.388422 14C0.487917 14 0.587411 13.962 0.663391 13.8861L13.2218 1.3277V8.94447C13.2218 9.15943 13.3957 9.33337 13.6107 9.33337C13.8256 9.33337 13.9996 9.15943 13.9996 8.94447V0.388901C13.9995 0.173943 13.8256 0 13.6106 0Z" fill="white"></path>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_711_3214">
                                                    <rect width="14" height="14" fill="white"></rect>
                                                </clipPath>
                                            </defs>
                                        </svg>
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

        $(document).on('click', '.drop-menu ul.dropdown li', function (e) {
            e.stopPropagation();

            let $dropdown = $(this).closest('.drop-menu');
            let selectedText = $(this).text().trim();
            let selectedId = $(this).data('id') || '';

            // Update only the clicked dropdown's span + hidden input
            $dropdown.find('.select span').first().text(selectedText);
            $dropdown.find('input[type="hidden"]').val(selectedId).trigger('change');

            // Close that dropdown only
            $dropdown.find('ul.dropdown').hide();
        });

    </script>
@endpush
