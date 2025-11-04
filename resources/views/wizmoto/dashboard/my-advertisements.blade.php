@extends('wizmoto.dashboard.master')
@section('dashboard-content')
    <div class="content-column">
        <div class="inner-column">
            <div class="list-title">
                <h3 class="title">{{ __('messages.my_listings') }}</h3>
            </div>
            <div class="my-listing-table wrap-listing">
                <div class="cart-table" >
                        <div class="title-listing" id="search-area">
                            <div class="box-ip-search">
                                <span class="icon">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.29301 0.287598C2.9872 0.287598 0.294312 2.98048 0.294312 6.28631C0.294312 9.59211 2.9872 12.2902 6.29301 12.2902C7.70502 12.2902 9.00364 11.7954 10.03 10.9738L12.5287 13.4712C12.6548 13.5921 12.8232 13.6588 12.9979 13.657C13.1725 13.6552 13.3395 13.5851 13.4631 13.4617C13.5867 13.3382 13.6571 13.1713 13.6591 12.9967C13.6611 12.822 13.5947 12.6535 13.474 12.5272L10.9753 10.0285C11.7976 9.00061 12.293 7.69995 12.293 6.28631C12.293 2.98048 9.59882 0.287598 6.29301 0.287598ZM6.29301 1.62095C8.87824 1.62095 10.9584 3.70108 10.9584 6.28631C10.9584 8.87153 8.87824 10.9569 6.29301 10.9569C3.70778 10.9569 1.62764 8.87153 1.62764 6.28631C1.62764 3.70108 3.70778 1.62095 6.29301 1.62095Z" fill="#050B20"/>
                                    </svg>
                                </span>
                                <input type="text" placeholder="{{ __('messages.search_motors') }}" id="searchInput">
                            </div>
                            <div class="text-box v1">
                                <div class="form_boxes v3">
                                    <small>{{ __('messages.sort_by') }}</small>
                                    <div class="drop-menu">
                                        <div class="select">
                                            <span>{{ __('messages.newest') }}</span>
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="sort" id="sortInput" value="newest">
                                        <ul class="dropdown" style="display: none;">
                                            <li data-id="newest">{{ __('messages.newest') }}</li>
                                            <li data-id="oldest">{{ __('messages.oldest') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <table>
                        <thead>
                        <tr>
                            <th>{{ __('messages.make') }}</th>
                            <th>{{ __('messages.brand') }}</th>
                            <th>{{ __('messages.price_evaluation') }}</th>
                            <th>{{ __('messages.year') }}</th>
                            <th>{{ __('messages.transmission') }}</th>
                            <th>{{ __('messages.fuel_type') }}</th>
                            <th>{{ __('messages.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($advertisements as $advertisement)
                            @php $images = $advertisement->getMedia('covers'); @endphp
                            <tr class="advertisement-item">
                                <td>
                                    <div class="shop-cart-product">
                                        <div class="shop-product-cart-img">
                                            <img src="{{ $images->first()?->getUrl('square') }}" alt="">
                                        </div>
                                        <div class="shop-product-cart-info">
                                                <h3>
                                                <a href="#" title="">{{$advertisement->brand?->localized_name}}{{' '}}{{$advertisement->vehicleModel?->localized_name}}</a>
                                            </h3>
                                            <p>{{$advertisement->version_model}}</p>
                                            <div class="price">
                                                <span>€{{$advertisement->final_price}} @include('wizmoto.partials.price-evaluation-badge', ['value' => $advertisement->price_evaluation])</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="{{ __('messages.brand') }}">
                                    <span>{{$advertisement->brand->localized_name}}</span>
                                </td>
                                <td data-label="{{ __('messages.price_evaluation') }}">
                                    <span>@include('wizmoto.partials.price-evaluation-badge', ['value' => $advertisement->price_evaluation])</span>
                                </td>
                                <td data-label="{{ __('messages.year') }}">
                                    <span>{{$advertisement->register_year}}</span>
                                </td>
                                <td data-label="{{ __('messages.transmission') }}">
                                    <span>{{$advertisement->motor_change}}</span>
                                </td>
                                <td data-label="{{ __('messages.fuel_type') }}">
                                    <span>{{$advertisement->fuelType->localized_name}}</span>
                                </td>
                                <td >
                                    <div class="actions">
                                        <a href="#" class="remove-cart-item action-btn remove" data-id="{{ $advertisement->id }}" data-url="{{ route('dashboard.delete-advertisement') }}">
                                            <img src="{{asset("wizmoto/images/icons/remove.svg")}}" alt="">
                                         
                                        </a>
                                        <a href="{{route("dashboard.edit-advertisement", $advertisement->id )}}" class="edit-cart-item action-btn edit" target="_blank">
                                            <img src="{{asset("wizmoto/images/icons/edit.svg")}}" alt="">
                                           
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-sec">
                        <nav aria-label="Page navigation example">
                            @if ($advertisements->hasPages())
                                <ul class="pagination">
                                    {{-- Previous Page Link --}}
                                    <li class="page-item {{ $advertisements->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $advertisements->previousPageUrl() }}" aria-label="Previous">
                                            <span aria-hidden="true">
                                                {{-- your SVG left arrow --}}
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M2.57983 5.99992C2.57983 5.78493 2.66192 5.5699
                                2.82573 5.40593L7.98559 0.2462C8.31382 -0.082026
                                8.84598 -0.082026 9.17408 0.2462C9.50217 0.574293
                                9.50217 1.10635 9.17408 1.4346L4.60841 5.99992L9.17376
                                10.5654C9.50185 10.8935 9.50185 11.4256 9.17376 11.7537C8.84566
                                12.0821 8.31366 12.0821 7.98544 11.7537L2.82555 6.59407C2.66176
                                6.43002 2.57983 6.21498 2.57983 5.99992Z" fill="#050B20"/>
                                                </svg>
                                            </span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>

                                    {{-- Pagination Elements --}}
                                    @foreach ($advertisements->links()->elements[0] ?? [] as $page => $url)
                                        <li class="page-item {{ $page == $advertisements->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    <li class="page-item {{ !$advertisements->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $advertisements->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">
                                                {{-- your SVG right arrow --}}
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_2968_14909)">
                                                        <path d="M9.42017 6.00008C9.42017 6.21507 9.33808 6.4301
                                    9.17427 6.59407L4.01441 11.7538C3.68618 12.082 3.15402
                                    12.082 2.82592 11.7538C2.49783 11.4257 2.49783 10.8936
                                    2.82592 10.5654L7.39159 6.00008L2.82624 1.43458C2.49815
                                    1.10649 2.49815 0.574352 2.82624 0.246285C3.15434 -0.0821014
                                    3.68634 -0.0821014 4.01457 0.246285L9.17446 5.40593C9.33824
                                    5.56998 9.42017 5.78502 9.42017 6.00008Z" fill="#050B20"/>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_2968_14909">
                                                            <rect width="12" height="12" fill="white"
                                                                  transform="translate(12 12) rotate(-180)"/>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                            </span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="text">
                                    {{ __('messages.showing_results') }}
                                    {{ $advertisements->firstItem() }}-{{ $advertisements->lastItem() }}
                                    {{ __('messages.of') }} {{ $advertisements->total() }}
                                </div>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        /* Hide mobile-only action labels by default (desktop) */
        .my-listing-table .action-label { display: none; }
        /* My Advertisements - Mobile Card Layout */
        @media (max-width: 767px) {
            .my-listing-table table,
            .my-listing-table thead,
            .my-listing-table tbody,
            .my-listing-table th,
            .my-listing-table td,
            .my-listing-table tr { display: block; width: 100%; }

            .my-listing-table thead { display: none; }

            .my-listing-table tbody .advertisement-item {
                border: 1px solid #e9ecef;
                border-radius: 10px;
                margin-bottom: 14px;
                overflow: hidden;
                background: #fff;
            }

            .my-listing-table tbody .advertisement-item td {
                border: none;
                padding: 10px 12px;
            }

            .my-listing-table .shop-cart-product {
                display: flex;
                gap: 12px;
            }
            .my-listing-table .shop-product-cart-img img {
                width: 110px; height: 110px; object-fit: cover; border-radius: 8px;
            }
            .my-listing-table .shop-product-cart-info h3 { font-size: 18px; margin: 0 0 4px; }
            .my-listing-table .shop-product-cart-info p { font-size: 13px; color: #6c757d; margin: 0 0 6px; }
            .my-listing-table .shop-product-cart-info .price span { font-weight: 700; font-size: 16px; }

            .my-listing-table tbody .advertisement-item td[data-label]:before {
                content: attr(data-label);
                display: block;
                font-size: 12px;
                color: #6c757d;
                margin-bottom: 4px;
            }

            .my-listing-table tbody .advertisement-item td[data-label] span { font-size: 14px; }

            .my-listing-table tbody .advertisement-item td:last-child { padding-top: 0; }
            .my-listing-table tbody .advertisement-item td:last-child .actions {
                display: flex;
                gap: 8px;
                width: 100%;
                align-items: center;
                justify-content: center;
                flex-wrap: nowrap;
            }
            .my-listing-table .action-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                padding: 10px 10px;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                background: #fff;
                width: auto;
                box-sizing: border-box;
                white-space: nowrap;
                text-align: center;
            }
            .my-listing-table .action-btn img {
                width: 18px;
                height: 18px;
                display: block;
                flex: 0 0 18px;
            }
            .my-listing-table .action-label {
                display: inline-block;
                font-size: 14px;
                color: #050B20;
                line-height: 1.2;
                margin-left: 0 !important;
                white-space: normal; /* allow wrapping */
                word-break: break-word;
                flex: 1 1 auto;
            }
            /* no two-column fallback; keep stacked for consistency */
            .my-listing-table .action-btn.remove { border-color: #ffe0e0; background: #fff5f5; }
            .my-listing-table .action-btn.edit { border-color: #e0e7ff; background: #f5f7ff; }

            /* Search/sort stack nicely */
            #search-area { display: grid; gap: 10px; }
            #search-area .text-box.v1 { justify-content: start; }
        }
    </style>
@endpush
@push('scripts')
    <script>

        $(document).ready(function() {
            // Function to update URL and reload page
            function applyFilters() {
                let url = window.location.pathname; // keep base url only
                let params = new URLSearchParams(window.location.search);

                let search = $('#searchInput').val().trim();
                let sort = $('#sortInput').val();



                if (search.length > 0) {
                    params.set('search', search);
                } else {
                    params.delete('search');
                }

                if (sort && sort.length > 0) {
                    params.set('sort', sort);
                } else {
                    params.delete('sort');
                }
                // Reload page with proper query string
                window.location.href = url + '?' + params.toString();
            }
            // Trigger search on input
            $('#searchInput').on('keypress', function(e) {
                if (e.key === 'Enter') {
                    applyFilters();
                }
            });
            // Trigger sort change
            $('#sortInput').on('change', applyFilters);
        });
        $(document).on('click', '.remove-cart-item', function(e) {
            e.preventDefault();

            let $btn = $(this);
            let adId = $btn.data('id');
            let url = $btn.data('url');


            if (!adId) return;

            Swal.fire({
                title: '{{ __('messages.are_you_sure') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '{{ __('messages.yes_delete') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            id: adId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                $btn.closest('.advertisement-item').remove(); // remove the container from DOM
                                Swal.fire({
                                    toast: true,
                                    icon: 'success',
                                    title: response.message,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                toast: true,
                                icon: 'error',
                                title: xhr.responseJSON?.error || 'Something went wrong',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    });
                }
            });
        });


    </script>
@endpush
