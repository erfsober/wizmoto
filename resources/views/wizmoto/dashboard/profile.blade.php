@extends('wizmoto.dashboard.master')
@section('dashboard-content')
<div class="content-column">
    <div class="inner-column">
        <div class="list-title">
            <h3 class="title">Profile</h3>
            <div class="text">Lorem ipsum dolor sit amet, consectetur.</div>
        </div>
        <div class="gallery-sec">
            <div class="right-box-three">
                <h6 class="title">Gallery</h6>
                <div class="gallery-box">
                    <div class="inner-box">
                        <div class="image-box">
                            <img src="images/resource/list2-4.png">
                            <div class="content-box">
                                <ul class="social-icon">
                                    <li><a href="#"><img src="images/resource/delet.svg"></a></li>
                                    <li><a href="#"><img src="images/resource/delet1-1.svg"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="uplode-box">
                            <div class="content-box">
                                <a href="#">
                                    <img src="images/resource/uplode.svg">
                                    <span>Upload</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text">Max file size is 1MB, Minimum dimension: 330x300 And Suitable files are .jpg & .png</div>
                </div>
            </div>
            <div class="form-sec">
                <form class="row">
                    <div class="col-lg-4">
                        <div class="form_boxes">
                            <label>First Name</label>
                            <input name="name" type="text" placeholder="Ali">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_boxes">
                            <label>Last Name</label>
                            <input name="last-name" type="text" placeholder="Tufan">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_boxes">
                            <label>Email</label>
                            <input name="email" type="email" placeholder="creativelayers088@gmail.com">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_boxes">
                            <label>Phone</label>
                            <input name="phone" type="number" placeholder="+77">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_boxes">
                            <label>Whatsapp</label>
                            <input name="whatsapp" type="number" placeholder="+98">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form_boxes">
                            <label>Website</label>
                            <input name="website" type="text" placeholder="www.creativelayers.net">
                        </div>
                    </div>
                </form>
            </div>
            <div class="right-box-three v2">
                <h6 class="title">Photos</h6>
                <div class="gallery-box">
                    <div class="inner-box">
                        <div class="image-box">
                            <img src="images/resource/list2-1.png">
                            <div class="content-box">
                                <ul class="social-icon">
                                    <li><a href="#"><img src="images/resource/delet.svg"></a></li>
                                    <li><a href="#"><img src="images/resource/delet1-1.svg"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="image-box">
                            <img src="images/resource/list2-2.png">
                            <div class="content-box">
                                <ul class="social-icon">
                                    <li><a href="#"><img src="images/resource/delet.svg"></a></li>
                                    <li><a href="#"><img src="images/resource/delet1-1.svg"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="image-box">
                            <img src="images/resource/list2-3.png">
                            <div class="content-box">
                                <ul class="social-icon">
                                    <li><a href="#"><img src="images/resource/delet.svg"></a></li>
                                    <li><a href="#"><img src="images/resource/delet1-1.svg"></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="uplode-box">
                            <div class="content-box">
                                <a href="#">
                                    <img src="images/resource/uplode.svg">
                                    <span>Upload</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="text">Max file size is 1MB, Minimum dimension: 330x300 And Suitable files are .jpg & .png</div>
                </div>
            </div>
            <div class="map-sec-two">
                <div class="form-sec-two">
                    <form class="row">
                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Friendly Address</label>
                                <input type="text" name="address" placeholder="ali tufan">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Map Location</label>
                                <input type="text" name="map-location" placeholder="Map Location">
                            </div>
                        </div>
                        <div class="map-box">
                            <div class="goole-iframe">
                                <iframe src="https://maps.google.com/maps?width=100%25&height=600&hl=en&q=1%20Grafton%20Street,%20Dublin,%20Ireland+(My%20Business%20Name)&t=&z=14&ie=UTF8&iwloc=B&output=embed">
                                </iframe>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Longitude</label>
                                <div class="drop-menu">
                                    <div class="select">
                                        <span>33</span>
                                    </div>
                                    <input type="hidden" name="gender">
                                    <ul class="dropdown" style="display: none;">
                                        <li>33</li>
                                        <li>33</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form_boxes">
                                <label>Video Link</label>
                                <input type="text" name="video-link" placeholder="#">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form_boxes">
                                <label>Description</label>
                                <textarea name="text" placeholder="Lorem Ipsum Dolar Sit Amet"></textarea>
                            </div>
                        </div>
                        <div class="form-submit">
                            <button type="submit" class="theme-btn">Save Profile<img src="images/arrow.svg" alt="">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
