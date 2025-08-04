@extends('wizmoto.dashboard.master')
@section('dashboard-content')
    <div class="content-column">
        <div class="inner-column">
            <div class="list-title">
                <h3 class="title">Create advertisement</h3>
                <div class="text">Lorem ipsum dolor sit amet, consectetur.</div>
            </div>
            <div class="form-box">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Car Details</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form class="row">
                            <div class="form-column col-lg-6">
                                <div class="form_boxes">
                                    <label>Type</label>
                                    {{-- bootstrap select --}}
                                    <div class="drop-menu active">
                                        <select name="type" class="form-select">
                                            <option value="car">Car</option>
                                            <option value="bike">Bike</option>
                                            <option value="truck">Truck</option>
                                            <option value="scooter">Scooter</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Title</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="title">
                                    </div>
                                </div>
                            </div>
                            <div class="form-column col-lg-6">
                                <div class="form_boxes v2">
                                    <label>Price</label>
                                    <div class="drop-menu active">
                                        <input type="text" name="price">
                                    </div>
                                </div>
                            </div>

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
