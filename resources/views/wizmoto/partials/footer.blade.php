<footer class="boxcar-footer footer-style-one cus-st-1">
    <div class="footer-top">
        <div class="boxcar-container">
            <div class="right-box">
                <div class="top-left wow fadeInUp">

                </div>
                <div class="subscribe-form wow fadeInUp" data-wow-delay="100ms">

                </div>
            </div>
        </div>
    </div>
    <div class="widgets-section">
        <div class="boxcar-container">
            <div class="row">
                <!-- Footer COlumn -->
                <div class="footer-column-two col-lg-9 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="footer-widget links-widget wow fadeInUp">
                                <h4 class="widget-title">Useful Links</h4>
                                <div class="widget-content">
                                    <ul class="user-links style-two">
                                        <li><a href="{{ route('about.index') }}">About Us</a></li>
                                        <li><a href="{{ route('blogs.index') }}">Blog</a></li>
                                        <li><a href="{{ route('faq.index') }}">FAQs</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="footer-widget links-widget wow fadeInUp" data-wow-delay="100ms">
                                <h4 class="widget-title">Quick Links</h4>
                                <div class="widget-content">
                                    <ul class="user-links style-two">
                                        <li><a href="#">Help center</a></li>
                                        <li><a href="#">How it works</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="footer-widget links-widget wow fadeInUp" data-wow-delay="200ms">
                                <h4 class="widget-title">Our Brands</h4>
                                <div class="widget-content">
                                    <ul class="user-links style-two">
                                        @foreach ($popularBrands as $brand)
                                            <li><a href="{{ route('inventory.list', ['brand' => $brand->id]) }}">
                                                    {{ $brand->name }}
                                                </a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="footer-widget links-widget wow fadeInUp" data-wow-delay="300ms">
                                <h4 class="widget-title">Vehicles Type</h4>
                                <div class="widget-content">
                                    <ul class="user-links style-two">
                                        @foreach ($vehicleTypes as $type)
                                            <li><a
                                                    href="{{ route('inventory.list', ['type' => $type->id]) }}">{{ $type->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer column -->
                <div class="footer-column col-lg-3 col-md-12 col-sm-12">
                    <div class="footer-widget social-widget wow fadeInUp" data-wow-delay="400ms">

                        <div class="widget-content">

                            <div class="social-icons">
                                <h6 class="title">Connect With Us</h6>
                                <ul>
                                    <li><a href="{{ $socialMedia['facebook'] }}"><i class="fab fa-facebook"></i></a>
                                    </li>
                                    <li><a href="{{ $socialMedia['twitter'] }}"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="{{ $socialMedia['instagram'] }}"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li><a href="{{ $socialMedia['youtube'] }}"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Footer Bottom -->
    <div class="footer-bottom">
        <div class="boxcar-container">
            <div class="inner-container">
                <div class="copyright-text wow fadeInUp">© <a href="#">2025 Wizmoto.com. All rights reserved.</a>
                </div>

                <ul class="footer-nav wow fadeInUp" data-wow-delay="200ms">
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Notice</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
