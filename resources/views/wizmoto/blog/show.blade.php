@extends('master')
@section('content')
    @include('wizmoto.partials.inner-header')

    <!-- blog section five -->
    <section class="blog-section-five layout-radius">
        <div class="boxcar-container">
            <div class="boxcar-title wow fadeInUp">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{route("home")}}">{{ __('messages.home') }}</a>
                    </li>
                    <li><span>{{ __('messages.blog') }}</span></li>
                </ul>
                <h2>{{$blogPost->localized_title}}</h2>
                {{--            <ul class="post-info">--}}
                {{--                <li><img src="images/resource/ali-tufan.png"></li>--}}
                {{--                <li><a href="#" title="">Ali Tufan</a></li>--}}
                {{--                <li><a href="#" title="">News</a></li>--}}
                {{--                <li>April 20, 2023</li>--}}
                {{--            </ul>--}}
            </div>
        </div>
        <div class="right-box">
            <div class="large-container">
                <div class="content-box">
                    <figure class="outer-image">
                        <img
                            src="{{ $blogPost->getFirstMediaUrl('images', 'large')}}"
                            alt="{{ $blogPost->localized_title }}">
                    </figure>
                    <div class="right-box-two">
                        <h4 class="title">{{ $blogPost->localized_title }}</h4>
                        <div class="text">
                            {!! $blogPost->localized_body !!}
                        </div>

                        <div class="ruls-sec">

                            @if($previous)
                                <div class="content-box">
                                    <h6 class="title">
                                        <i class="fa-solid fa-angle-left"></i> {{ __('messages.previous_post') }}
                                    </h6>
                                    <div class="text">
                                        <a href="{{ route('blogs.show', $previous->slug) }}">
                                            {{ $previous->localized_title }}
                                        </a>
                                    </div>
                                </div>
                            @endif

                            @if($next)
                                <div class="content-box v2">
                                    <h6 class="title">
                                        {{ __('messages.next_post') }}
                                        <i class="fa-solid fa-angle-right"></i>
                                    </h6>
                                    <div class="text">
                                        <a href="{{ route('blogs.show', $next->slug) }}">
                                            {{ $next->localized_title }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="reviews">
                            <h4 class="title">{{ __('messages.customer_reviews') }}</h4>
                            @foreach($blogPost->reviews as $review)
                                <div class="content-box">
                                    <div class="auther-name">
                                        <span>{{ strtoupper(Str::substr($review->name, 0, 1)) }}.{{ strtoupper(Str::substr(explode(' ', $review->name)[1] ?? '', 0, 1)) }}</span>
                                        <h6 class="name">{{ $review->name }}</h6>
                                        <small>{{ $review->created_at->format('F d, Y') }}</small>
                                    </div>
                                    <div class="rating-list">
                                        <ul class="list">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <li>
                                                    <i class="fa fa-star {{ $i <= $review->stars ? '' : 'gray' }}"></i>
                                                </li>
                                            @endfor

                                        </ul>
                                    </div>
                                    <div class="text">{{$review->comment}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <form class="row" action="{{route("reviews.store")}}" method="POST">
                            <div class="Reply-sec">
                                <h6 class="title">{{ __('messages.leave_reply') }}</h6>
                                <div class="text">{{ __('messages.email_privacy_notice') }}</div>
                                <div class="right-box">
                                    <div class="rating-list">
                                        <div class="list-box">
                                            <span>{{ __('messages.rate_post') }}</span>
                                            <ul class="list">
                                                <li>
                                                    <i class="fa fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa fa-star"></i>
                                                </li>
                                            </ul>
                                            <input type="hidden" name="stars" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @csrf
                            <input type="hidden" name="type" value="blog">
                            <input type="hidden" name="id" value="{{ $blogPost->id }}">
                            <div class="col-lg-6">
                                <div class="form_boxes">
                                    <label>{{ __('messages.name') }}</label>
                                    <input type="text" name="name" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form_boxes">
                                    <label>{{ __('messages.email') }}</label>
                                    <input type="email" name="email" placeholder="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form_boxes v2">
                                    <label>{{ __('messages.comment') }}</label>
                                    <textarea name="comment" placeholder="" required=""></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-submit">
                                    <button type="submit" class="theme-btn">{{ __('messages.post_comment') }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewbox="0 0 14 14" fill="none">
                                            <g clip-path="url(#clip0_711_3214)">
                                                <path d="M13.6106 0H5.05509C4.84013 0 4.66619 0.173943 4.66619 0.388901C4.66619 0.603859 4.84013 0.777802 5.05509 0.777802H12.6719L0.113453 13.3362C-0.0384687 13.4881 -0.0384687 13.7342 0.113453 13.8861C0.189396 13.962 0.288927 14 0.388422 14C0.487917 14 0.587411 13.962 0.663391 13.8861L13.2218 1.3277V8.94447C13.2218 9.15943 13.3957 9.33337 13.6107 9.33337C13.8256 9.33337 13.9996 9.15943 13.9996 8.94447V0.388901C13.9995 0.173943 13.8256 0 13.6106 0Z" fill="white"></path>
                                            </g>
                                            <defs>
                                                <clippath id="clip0_711_3214">
                                                    <rect width="14" height="14" fill="white"></rect>
                                                </clippath>
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
        <!-- blog section -->
        <div class="blog-section">
            <div class="boxcar-container">
                <div class="boxcar-title wow fadeInUp">
                    <h2>{{ __('messages.latest_blog_posts') }}</h2>
                </div>
                <div class="row">
                    <!-- blog-block -->
                    @foreach($latestBlogs as $blog)
                        <div class="blog-block col-lg-4 col-md-6 col-sm-12">
                            <div class="inner-box wow fadeInUp">
                                <div class="image-box">
                                    <figure class="image">
                                        <a href="{{ route('blogs.show', $blog->slug) }}">
                                            <img
                                                src="{{ $blog->getFirstMediaUrl('images', 'medium')}}"
                                                alt="{{ $blog->localized_title }}">
                                        </a>
                                    </figure>
                                </div>
                                <div class="content-box">
                                    <ul class="post-info">
                                        <li>{{ $blog->author_name ?? 'Admin' }}</li>
                                        <li>{{ $blog->created_at->format('F d, Y') }}</li>
                                    </ul>
                                    <h6 class="title">
                                        <a href="{{ route('blogs.show', $blog->slug) }}" title="{{ $blog->localized_title }}">
                                            {{ Str::limit($blog->localized_title, 70) }}
                                        </a>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    <!-- blog-block -->
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End blog-section -->
    </section>

    @include('wizmoto.partials.footer')

@endsection
@push('styles')
    <style>
        .rating-list .list li i.gray {
            color: #ccc; /* gray for empty stars */
        }

        .Reply-sec .list li i {
            color: #ccc; /* default gray */
            cursor: pointer;
        }

        .Reply-sec .list li.hovered i,
        .list li.selected i {
            color: #ffb400; /* gold for hover/selected */
        }

    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function () {
            const $stars = $('.rating-list .list-box .list li');

            $stars.on('mouseenter', function () {
                const index = $(this).index();
                $(this).siblings().addBack().each(function (i) {
                    $(this).toggleClass('hovered', i <= index);
                });
            }).on('mouseleave', function () {
                $(this).siblings().addBack().removeClass('hovered');
            });

            $stars.on('click', function () {
                const index = $(this).index();
                const $list = $(this).closest('.list');
                $list.children().each(function (i) {
                    $(this).toggleClass('selected', i <= index);
                });
                // Set hidden input value
                $(this).closest('.list-box').find('input[name="stars"]').val(index + 1);
            });
        });

    </script>
@endpush
