@extends('wizmoto.dashboard.master')
@section('dashboard-content')
    <div class="content-column">
        <div class="inner-column">
            <div class="list-title">
                <h3 class="title">Profile</h3>
            </div>
            <div class="form-box">
                <form action="{{route('dashboard.update-profile')}}" method="POST" class="row" id="profileForm">
                    @csrf
                    <div class="gallery-sec">
                        <div class="right-box-three">
                            <h6 class="title">Gallery</h6>
                            <div class="gallery-box">
                                <div class="inner-box" id="preview-container">
                                    @if(!empty($provider->getFirstMediaUrl('image')))
                                        <div class="image-box">
                                            <img src="{{ $provider->getFirstMediaUrl('image') }}" alt="Preview" style="max-width: 200px; border-radius: 6px;">
                                            <div class="content-box">
                                                <ul class="social-icon">
                                                    <li>
                                                        <a href="#" class="delete-btn">
                                                            <img src="{{asset("wizmoto/images/resource/delet.svg")}}">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="uplode-box" style="{{ $provider->getFirstMedia('image') ? 'display:none;' : '' }}">
                                            <div class="content-box">
                                                <a href="#" id="uploadTrigger">
                                                    <img src="{{asset('wizmoto/images/resource/uplode.svg')}}">
                                                    <span>Upload</span>
                                                </a>
                                                <input type="file" name="image" id="fileInput" multiple style="display:none">
                                            </div>
                                        </div>

                                    @endif
                                </div>
                                <div class="text">You can upload a maximum of 1 image. Please only upload images in JPEG or PNG format</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-column col-lg-4">
                        <div class="form_boxes">
                            <label>Title</label>
                            <div class="drop-menu" id="title-dropdown">
                                <div class="select">
                                    <span>Selection</span>
                                    <i class="fa fa-angle-down"></i>
                                </div>
                                <input type="hidden" name="title">
                                <ul class="dropdown" style="display: none;">
                                    @php
                                        $titles = [
                                        'Mr','Lady'
                                     ];
                                    @endphp
                                    @foreach($titles as $title)
                                        <li data-id="{{ $title }}">{{$title}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-column col-lg-4">
                        <div class="form_boxes">
                            <label>First Name</label>
                            <input name="first_name" type="text" placeholder="" value="{{$provider->first_name}}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_boxes">
                            <label>Last Name</label>
                            <input name="last_name" type="text" placeholder="" value="{{$provider->last_name}}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_boxes">
                            <label>Email</label>
                            <input name="email" type="email" placeholder="" value="{{$provider->email}}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_boxes">
                            <label>Phone</label>
                            <input name="phone" type="number" placeholder="" value="{{$provider->phone}}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_boxes">
                            <label>Whatsapp</label>
                            <input name="whatsapp" type="number" placeholder="" value="{{$provider->whatsapp}}">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form_boxes">
                            <label>Street and house number</label>
                            <input type="text" name="address" placeholder="" value="{{$provider->address}}">
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form_boxes">
                            <label>Village</label>
                            <div class="drop-menu" id="motor-change-dropdown">
                                <div class="select">
                                    <span class="selected">{{ old('village', $provider->village ?? 'Selection') }}</span>
                                    <i class="fa fa-angle-down"></i>
                                </div>
                                <input type="hidden" name="village" value="{{ old('village', $provider->village ?? '') }}">
                                <ul class="dropdown" style="display: none;">
                                    @php
                                        $countries = [
                                         'Austria',
                                         'Belgium',
                                          'France',
                                         'Germany',
                                          'Italy',
                                          'Luxembourg',
                                         'Netherlands',
                                          'Spain',
                                     ];
                                    @endphp
                                    @foreach($countries as $country)
                                        <li data-id="{{ $country }}">
                                            {{$country}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <div class="form_boxes">
                            <label>Zip CODE</label>
                            <input type="text" name="zip_code" placeholder="" value="{{$provider->zip_code}}">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form_boxes">
                            <label>City</label>
                            <input type="text" name="city" placeholder="" value="{{$provider->city}}">
                        </div>
                    </div>
                    <div class="form-column col-lg-12 mb-5">
                        <div class="cheak-box">
                            <label class="contain">Show in advertising
                                <input type="checkbox" name="show_info_in_advertisement">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="theme-btn">Save Profile<img src="{{asset("wizmoto/images/arrow.svg")}}" alt="">
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>

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
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function () {
            const selectedFiles = [];

            // Upload button click
            $("#uploadTrigger").click(function (e) {
                e.preventDefault();
                $("#fileInput").click();
            });

            // File select
            $("#fileInput").on("change", function (e) {
                if (selectedFiles.length > 0) {
                    alert("You can upload only one image.");
                    $(this).val("");
                    return;
                }

                const file = this.files[0]; // only first file
                selectedFiles.push(file);

                const reader = new FileReader();
                reader.onload = function (event) {
                    const div = $(`
                <div class="image-box" data-index="0">
                    <img src="${event.target.result}" alt="preview">
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
                    $(".uplode-box").hide(); // hide upload box
                };

                reader.readAsDataURL(file);
                $(this).val("");
            });

            // Delete image
            $("#preview-container").on("click", ".delete-btn", function (e) {
                e.preventDefault();
                const box = $(this).closest(".image-box");
                box.remove();
                selectedFiles.splice(0, 1); // only one image

                if (selectedFiles.length === 0) {
                    $(".uplode-box").show(); // show upload box again
                }
            });

            // Sortable images (upload box stays fixed)
            $("#preview-container").sortable({
                items: ".image-box",
                cancel: ".uplode-box",
                placeholder: "image-box-placeholder",
                tolerance: "pointer",
                helper: "clone",
                start: function (e, ui) {
                    ui.placeholder.height(ui.item.height());
                    ui.placeholder.width(ui.item.width());
                }
            }).disableSelection();

            // Form submit via AJAX
            $("#profileForm").submit(function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                selectedFiles.forEach(file => {
                    formData.append('image', file);
                });

                $("#preview-container .image-box").each(function (i) {
                    formData.append(`images_order[${i}]`, $(this).find("img").attr("alt"));
                });

                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr("method"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            title: 'Profile updated successfully!',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    },
                    error: function (xhr) {
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

    </script>
@endpush
