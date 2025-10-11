<div class="layout-search {{ $class ?? '' }}">
    <div class="search-box">
        <svg class="icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.29301 1.2876C3.9872 1.2876 1.29431 3.98048 1.29431 7.28631C1.29431 10.5921 3.9872 13.2902 7.29301 13.2902C8.70502 13.2902 10.0036 12.7954 11.03 11.9738L13.5287 14.4712C13.6548 14.5921 13.8232 14.6588 13.9979 14.657C14.1725 14.6552 14.3395 14.5851 14.4631 14.4617C14.5867 14.3382 14.6571 14.1713 14.6591 13.9967C14.6611 13.822 14.5947 13.6535 14.474 13.5272L11.9753 11.0285C12.7976 10.0006 13.293 8.69995 13.293 7.28631C13.293 3.98048 10.5988 1.2876 7.29301 1.2876ZM7.29301 2.62095C9.87824 2.62095 11.9584 4.70108 11.9584 7.28631C11.9584 9.87153 9.87824 11.9569 7.29301 11.9569C4.70778 11.9569 2.62764 9.87153 2.62764 7.28631C2.62764 4.70108 4.70778 2.62095 7.29301 2.62095Z" fill="white"/>
        </svg>
        <input type="search" placeholder="Search..." class="show-search header-live-search-input" name="search" tabindex="2" value="" autocomplete="off">
    </div>
    <div class="box-content-search header-live-search-results" style="display: none;">
        <ul class="box-car-search header-live-search-list">
            <!-- Results will be loaded here via AJAX -->
        </ul>
    </div>
</div>

@once
@push('scripts')
<script>
$(document).ready(function() {
    // Initialize live search for all header search boxes
    initializeHeaderLiveSearch();
    
    function initializeHeaderLiveSearch() {
        let searchTimeout;
        const $searchInputs = $('.header-live-search-input');
        
        $searchInputs.each(function() {
            const $searchInput = $(this);
            const $searchResults = $searchInput.closest('.layout-search').find('.header-live-search-results');
            const $resultsList = $searchResults.find('.header-live-search-list');
            
            // Handle input changes
            $searchInput.on('keyup', function() {
                clearTimeout(searchTimeout);
                const searchTerm = $(this).val().trim();
                
                if (searchTerm.length < 2) {
                    $searchResults.hide();
                    return;
                }
                
                // Debounce search
                searchTimeout = setTimeout(function() {
                    performLiveSearch(searchTerm, $resultsList, $searchResults);
                }, 300);
            });
            
            // Handle Enter key - redirect to inventory list with search
            $searchInput.on('keypress', function(e) {
                if (e.which === 13) { // Enter key
                    e.preventDefault();
                    const searchTerm = $(this).val().trim();
                    if (searchTerm) {
                        window.location.href = '{{ route("inventory.list") }}?search=' + encodeURIComponent(searchTerm);
                    }
                }
            });
        });
        
        // Close search results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.layout-search').length) {
                $('.header-live-search-results').hide();
            }
        });
        
        // Perform live search via AJAX
        function performLiveSearch(searchTerm, $resultsList, $searchResults) {
            $.ajax({
                url: '{{ route("home.live-search") }}',
                method: 'GET',
                data: { search: searchTerm },
                beforeSend: function() {
                    $resultsList.html('<li style="padding: 20px; text-align: center; color: #666;">Searching...</li>');
                    $searchResults.show();
                },
                success: function(response) {
                    if (response.results && response.results.length > 0) {
                        let html = '';
                        response.results.forEach(function(item) {
                            html += `
                                <li>
                                    <a href="${item.url}" class="car-search-item">
                                        <div class="box-img">
                                            <img src="${item.image}" alt="${item.title}" onerror="this.src='{{ asset('wizmoto/images/logo.png') }}'">
                                        </div>
                                        <div class="info">
                                            <p class="name">${item.title}</p>
                                            <span class="price">${item.price}</span>
                                        </div>
                                    </a>
                                </li>
                            `;
                        });
                        $resultsList.html(html);
                        $searchResults.show();
                    } else {
                        $resultsList.html('<li style="padding: 20px; text-align: center; color: #999;">No results found</li>');
                        $searchResults.show();
                    }
                },
                error: function() {
                    $resultsList.html('<li style="padding: 20px; text-align: center; color: red;">Error loading results</li>');
                    $searchResults.show();
                }
            });
        }
    }
});
</script>
@endpush
@endonce

