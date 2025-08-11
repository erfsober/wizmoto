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
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Car Details</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <form class="row" action="{{ route('dashboard.store-advertisement') }}" method="POST" id="advertisementForm">
                            @csrf
                            {{--Vehicle data--}}
                            <h6>Vehicle data</h6>
                            <div class="form-column col-lg-12">
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
                            <div class="form-column col-lg-12">
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
                            <div class="form-column col-lg-12">
                                <div class="form_boxes v2">
                                    <label>Version</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="version">
                                    </div>
                                </div>
                            </div>

                            {{--Characteristics--}}
                            <h6>Characteristics</h6>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Address</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="price">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Phone</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-12">
                                <div class="form_boxes v2">
                                    <label>Description</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="description">
                                    </div>
                                </div>
                            </div>
                            {{--specifications--}}
                            @php
                                $specifications = [
                                    "Engine Type",
                                    "Engine Displacement (cc)",
                                    "Motor Power",
                                    "Top Speed",
                                    "Fuel Type",
                                    "Battery Type",
                                    "Battery Capacity",
                                    "Range per Charge",
                                    "Range per Tank",
                                    "Charging Time",
                                    "Weight",
                                    "Brake Type",
                                    "Transmission",
                                    "Cylinders",
                                    "Suspension Type",
                                    "Suspension",
                                    "Wheel Size",
                                    "Seat Height",
                                    "Storage Capacity",
                                    "License Requirement",
                                    "License Category",
                                    "Frame Material",
                                    "Gear System",
                                    "Tire Size",
                                    "Tire Type",
                                    "Handlebar Type",
                                    "Pedal Assist Levels",
                                    "Throttle Mode",
                                    "Top Assisted Speed",
                                    "Display/Control Panel",
                                    "Removable Battery",
                                    "Fuel Tank Capacity",
                                    "Frame Type",
                                    "Foldable Design",
                                    "Weight Limit",
                                    "Lighting System",
                                    "App Connectivity"
                                ];
                            @endphp
                            @foreach ($specifications as $spec)
                                <div class="form-column col-lg-3">

                                    <div class="form_boxes v2 mb-3">
                                        <label>{{ $spec }}</label>
                                        <div class="drop-menu active">
                                            <input type="text" name="specifications[{{ $spec }}]">
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                            <div class="form-column col-lg-12">
                                <div class="">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
            let selectedId   = $(this).data('id') || '';

            // Update only the clicked dropdown's span + hidden input
            $dropdown.find('.select span').first().text(selectedText);
            $dropdown.find('input[type="hidden"]').val(selectedId).trigger('change');

            // Close that dropdown only
            $dropdown.find('ul.dropdown').hide();
        });
    </script>
@endpush
