/**
 * Searchable Dropdown Plugin
 * Add 'searchable-dropdown' class to any .drop-menu to enable search functionality
 */

function initializeSearchableDropdowns(containerSelector = '') {
    const selector = containerSelector ? `${containerSelector} .drop-menu` : '.drop-menu';
    
    $(selector).each(function() {
        const $dropdown = $(this);
        const $select = $dropdown.find('.select');
        const $dropdownList = $dropdown.find('.dropdown, ul.dropdown');
        const $hiddenInput = $dropdown.find('input[type="hidden"]');
        const hasSearchEnabled = $dropdown.hasClass('searchable-dropdown');
        
        // Only add search if enabled and not already added
        if (hasSearchEnabled && !$dropdownList.find('.dropdown-search').length) {
            $dropdownList.prepend(`
                <li class="dropdown-search" style="position: sticky; top: 0; background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%); padding: 12px; border-bottom: 2px solid #e9ecef; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                    <div style="position: relative; display: flex; align-items: center;">
                        <i class="fa fa-search" style="position: absolute; left: 12px; color: #6c757d; font-size: 14px; pointer-events: none;"></i>
                        <input type="text" placeholder="Type to search..." class="dropdown-search-input" style="width: 100%; padding: 10px 12px 10px 38px; border: 2px solid #dee2e6; border-radius: 8px; font-size: 14px; outline: none; transition: all 0.3s ease; background: white;" onclick="event.stopPropagation();">
                        <i class="fa fa-times-circle dropdown-clear-search" style="position: absolute; right: 12px; color: #6c757d; font-size: 16px; cursor: pointer; display: none; transition: all 0.2s ease;" onclick="event.stopPropagation();"></i>
                    </div>
                    <div class="search-results-count" style="margin-top: 8px; font-size: 12px; color: #6c757d; display: none;">
                        <span class="results-text"></span>
                    </div>
                </li>
            `);
            
            const $searchInput = $dropdownList.find('.dropdown-search-input');
            const $clearBtn = $dropdownList.find('.dropdown-clear-search');
            const $resultsCount = $dropdownList.find('.search-results-count');
            
            // Focus/blur effects
            $searchInput.on('focus', function() {
                $(this).css({
                    'border-color': '#405FF2',
                    'box-shadow': '0 0 0 3px rgba(64, 95, 242, 0.1)'
                });
            }).on('blur', function() {
                $(this).css({
                    'border-color': '#dee2e6',
                    'box-shadow': 'none'
                });
            });
            
            // Search functionality
            $searchInput.on('keyup', function(e) {
                e.stopPropagation();
                const searchTerm = $(this).val().toLowerCase();
                let visibleCount = 0;
                
                if (searchTerm.length > 0) {
                    $clearBtn.fadeIn(200);
                } else {
                    $clearBtn.fadeOut(200);
                }
                
                $dropdownList.find('.no-results-message').remove();
                
                $dropdownList.find('li:not(.dropdown-search):not(.clear-option)').each(function() {
                    const text = $(this).text().toLowerCase();
                    if (text.includes(searchTerm)) {
                        $(this).fadeIn(150);
                        visibleCount++;
                    } else {
                        $(this).fadeOut(150);
                    }
                });
                
                if (searchTerm.length > 0) {
                    const totalCount = $dropdownList.find('li:not(.dropdown-search):not(.clear-option)').length;
                    
                    if (visibleCount === 0) {
                        $dropdownList.append(`
                            <li class="no-results-message" style="padding: 20px; text-align: center; color: #6c757d; background: #f8f9fa; border-top: 1px solid #e9ecef;">
                                <i class="fa fa-search" style="font-size: 24px; color: #adb5bd; margin-bottom: 8px;"></i>
                                <p style="margin: 8px 0 4px 0; font-weight: 500; color: #495057;">No results found</p>
                                <p style="margin: 0; font-size: 12px;">Try different keywords</p>
                            </li>
                        `);
                        $resultsCount.fadeOut(200);
                    } else {
                        $resultsCount.find('.results-text').html(`<i class="fa fa-check-circle" style="color: #28a745; margin-right: 4px;"></i> Found ${visibleCount} of ${totalCount} items`);
                        $resultsCount.fadeIn(200);
                    }
                } else {
                    $resultsCount.fadeOut(200);
                }
            });
            
            // Clear button
            $clearBtn.on('click', function(e) {
                e.stopPropagation();
                $searchInput.val('').trigger('keyup').focus();
            });
            
            $clearBtn.on('mouseenter', function() {
                $(this).css('color', '#dc3545');
            }).on('mouseleave', function() {
                $(this).css('color', '#6c757d');
            });
            
            // Keyboard navigation
            let currentFocusIndex = -1;
            $searchInput.on('keydown', function(e) {
                const $visibleItems = $dropdownList.find('li:not(.dropdown-search):not(.no-results-message):visible');
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    currentFocusIndex = Math.min(currentFocusIndex + 1, $visibleItems.length - 1);
                    updateKeyboardFocus($visibleItems, currentFocusIndex, $dropdownList);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    currentFocusIndex = Math.max(currentFocusIndex - 1, 0);
                    updateKeyboardFocus($visibleItems, currentFocusIndex, $dropdownList);
                } else if (e.key === 'Enter' && currentFocusIndex >= 0) {
                    e.preventDefault();
                    $visibleItems.eq(currentFocusIndex).trigger('click');
                } else if (e.key === 'Escape') {
                    $dropdownList.slideUp(200);
                }
            });
            
            $searchInput.on('input', function() {
                currentFocusIndex = -1;
                $dropdownList.find('li').removeClass('keyboard-focus');
            });
        }
        
        // Handle dropdown toggle
        $select.off('click.searchable');
        $select.on('click.searchable', function(e) {
            e.stopPropagation();
            
            // Close other dropdowns
            $(selector).find('.dropdown, ul.dropdown').not($dropdownList).hide();
            
            if ($dropdownList.is(':visible')) {
                $dropdownList.slideUp(200);
            } else {
                if (hasSearchEnabled) {
                    const $searchInput = $dropdownList.find('.dropdown-search-input');
                    const $clearBtn = $dropdownList.find('.dropdown-clear-search');
                    const $resultsCount = $dropdownList.find('.search-results-count');
                    
                    $searchInput.val('');
                    $clearBtn.hide();
                    $resultsCount.hide();
                    $dropdownList.find('li:not(.dropdown-search)').show();
                    $dropdownList.find('.no-results-message').remove();
                    
                    $dropdownList.slideDown(250, function() {
                        $searchInput.focus();
                    });
                } else {
                    $dropdownList.slideDown(200);
                }
            }
        });
    });
    
    // Close dropdowns when clicking outside
    $(document).off('click.searchable').on('click.searchable', function(e) {
        if (!$(e.target).closest('.drop-menu').length) {
            $('.drop-menu .dropdown, .drop-menu ul.dropdown').hide();
        }
    });
}

// Helper function for keyboard navigation
function updateKeyboardFocus($items, index, $dropdownList) {
    $items.removeClass('keyboard-focus');
    if (index >= 0 && index < $items.length) {
        const $item = $items.eq(index);
        $item.addClass('keyboard-focus');
        
        const itemTop = $item.position().top;
        const dropdownScrollTop = $dropdownList.scrollTop();
        const dropdownHeight = $dropdownList.height();
        
        if (itemTop < 0) {
            $dropdownList.scrollTop(dropdownScrollTop + itemTop - 10);
        } else if (itemTop > dropdownHeight - 40) {
            $dropdownList.scrollTop(dropdownScrollTop + itemTop - dropdownHeight + 50);
        }
    }
}

// Auto-initialize on document ready (except on home page which has custom init)
$(document).ready(function() {
    // Don't auto-init if home page has its own initialization
    if (!$('.boxcar-banner-section-v1').length) {
        initializeSearchableDropdowns();
    }
});

