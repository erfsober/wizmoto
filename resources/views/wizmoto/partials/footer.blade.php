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
                                <h4 class="widget-title">{{ __('messages.useful_links') }}</h4>
                                <div class="widget-content">
                                    <ul class="user-links style-two">
                                        <li><a href="{{ route('about.index') }}">{{ __('messages.about_us') }}</a></li>
                                        <li><a href="{{ route('blogs.index') }}">{{ __('messages.blog') }}</a></li>
                                        <li><a href="{{ route('faq.index') }}">{{ __('messages.faqs') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="footer-widget links-widget wow fadeInUp" data-wow-delay="100ms">
                                <h4 class="widget-title">{{ __('messages.popular_models') }}</h4>
                                <div class="widget-content">
                                    <ul class="user-links style-two">
                                        @foreach ($popularModels as $model)
                                            <li><a href="{{ route('inventory.list') }}?vehicle_model_id={{ $model->id }}">
                                                {{ $model->brand ? $model->brand->localized_name . ' ' : '' }}{{ $model->localized_name }}
                                            </a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="footer-widget links-widget wow fadeInUp" data-wow-delay="200ms">
                                <h4 class="widget-title">{{ __('messages.popular_brands') }}</h4>
                                <div class="widget-content">
                                    <ul class="user-links style-two">
                                        @foreach ($popularBrands as $brand)
                                            <li><a href="{{ route('inventory.list') }}?brand_id={{ $brand->id }}">
                                                    {{ $brand->localized_name }}
                                                </a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="footer-widget links-widget wow fadeInUp" data-wow-delay="300ms">
                                <h4 class="widget-title">{{ __('messages.vehicles_type') }}</h4>
                                <div class="widget-content">
                                    <ul class="user-links style-two">
                                        @foreach ($vehicleTypes as $type)
                                            <li><a href="{{ route('inventory.list') }}?advertisement_type={{ $type->id }}">{{ $type->localized_title }}</a>
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
                                <h6 class="title">{{ __('messages.connect_with_us') }}</h6>
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
                <div class="copyright-text wow fadeInUp"><a href="#">{{ __('messages.copyright') }}</a>
                </div>

                <ul class="footer-nav wow fadeInUp" data-wow-delay="200ms">
                    <li><a href="#">{{ __('messages.terms_conditions') }}</a></li>
                    <li><a href="#">{{ __('messages.privacy_notice') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
