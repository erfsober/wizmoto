@extends('master')
@section('content')
@include('wizmoto.partials.inner-header')

<section class="faq-inner-section layout-radius">
    @foreach($faqs as $category => $categoryFaqs)
        <!-- faq-section -->
        <div class="faqs-section {{ $loop->first ? 'pt-0' : '' }}">
            <div class="inner-container">
                <!-- FAQ Column -->
                <div class="faq-column wow fadeInUp" data-wow-delay="400ms">
                    <div class="inner-column">
                        <div class="boxcar-title text-center">
                            <h2 class="title">{{ ucfirst($category) }}</h2>
                        </div>
                        <ul class="widget-accordion wow fadeInUp">
                            @foreach($categoryFaqs as $index => $faq)
                                <!--Block-->
                                <li class="accordion block {{ $index == 0 ? 'active-block' : '' }}">
                                    <div class="acc-btn {{ $index == 0 ? 'active' : '' }}">
                                        {{ $faq->localized_question }}
                                        <div class="icon fa fa-plus"></div>
                                    </div>
                                    <div class="acc-content {{ $index == 0 ? 'current' : '' }}">
                                        <div class="content">
                                            <div class="text">{{ $faq->localized_answer }}</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End faqs-section -->
    @endforeach
</section>

@include('wizmoto.partials.footer')

@endsection