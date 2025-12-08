<style>
    /* Fair Price Badge Over Image - Shared Styles */
    .car-block-three .inner-box .image-box,
    #vehicle-cards-container .service-block-thirteen .inner-box .image-box {
        position: relative;
    }
    
    .car-block-three .inner-box .image-box .fair-price-overlay,
    #vehicle-cards-container .service-block-thirteen .inner-box .image-box .fair-price-overlay {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 5;
    }
    
    /* Override global span rule .car-block-three .inner-box .image-box span - use more specific selector */
    .car-block-three .inner-box .image-box .fair-price-overlay .price-evaluation-badge,
    #vehicle-cards-container .service-block-thirteen .inner-box .image-box .fair-price-overlay .price-evaluation-badge {
        margin-left: 0 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        position: static !important;
        top: auto !important;
        left: auto !important;
        padding: 6px 12px !important;
        border-radius: 16px !important;
        white-space: nowrap !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
        /* Override global span styles */
        font-size: inherit !important;
        font-weight: inherit !important;
    }
    
    /* Override for all spans inside badge - prevent global .image-box span rule from affecting them */
    .car-block-three .inner-box .image-box .fair-price-overlay .price-evaluation-badge span,
    #vehicle-cards-container .service-block-thirteen .inner-box .image-box .fair-price-overlay .price-evaluation-badge span {
        position: static !important;
        top: auto !important;
        left: auto !important;
        background-color: transparent !important;
        padding: 0 !important;
        border-radius: 0 !important;
        font-weight: inherit !important;
        color: inherit !important;
    }
    
    /* Restore text label styling */
    .car-block-three .inner-box .image-box .fair-price-overlay .price-evaluation-badge > span:first-of-type {
        font-size: 13px !important;
        font-weight: 600 !important;
        line-height: 1.2 !important;
    }
    
    /* Ensure circles are displayed correctly */
    .car-block-three .inner-box .image-box .fair-price-overlay .price-evaluation-badge > span:last-of-type > span,
    #vehicle-cards-container .service-block-thirteen .inner-box .image-box .fair-price-overlay .price-evaluation-badge > span:last-of-type > span {
        width: 6px !important;
        height: 6px !important;
        min-width: 6px !important;
        border-radius: 50% !important;
        display: inline-block !important;
        flex-shrink: 0 !important;
    }
    
    /* Home Page Specific - Bottom Left Position */
    .car-slider-three .car-block-three .inner-box .image-box .fair-price-overlay {
        top: auto;
        bottom: 12px;
    }
    
    /* Vehicle Cards - Top Right Position on Desktop */
    @media (min-width: 992px) {
        #vehicle-cards-container .service-block-thirteen .inner-box .image-box .fair-price-overlay {
            top: 12px;
            left: auto;
            right: 12px;
        }
        
        /* Show desktop layout, hide mobile layout */
        .vehicle-card-desktop {
            display: block;
        }
        .vehicle-card-mobile {
            display: none;
        }
    }
    
    /* Mobile Responsive */
    @media (max-width: 991px) {
        /* General car-block-three rule - exclude vehicle-card-mobile */
        .car-block-three:not(.vehicle-card-mobile) .inner-box .image-box .fair-price-overlay,
        #vehicle-cards-container .service-block-thirteen .inner-box .image-box .fair-price-overlay {
            top: 8px;
            left: 8px;
        }
        
        .car-slider-three .car-block-three .inner-box .image-box .fair-price-overlay {
            bottom: 8px;
        }
        
        /* Vehicle Cards Mobile - Bottom Left Position - Target element with both classes */
        .vehicle-card-mobile.car-block-three .inner-box .image-box .fair-price-overlay {
            top: auto !important;
            bottom: 8px !important;
            left: 8px !important;
            right: auto !important;
        }
        
        /* Vehicle Cards Mobile - Match home page card styles exactly */
        .vehicle-card-mobile.car-block-three {
            margin: 0 14px !important;
        }
        
        .vehicle-card-mobile.car-block-three .inner-box .content-box {
            padding: 15px 27px 11px !important;
            margin-top: -9px !important;
            position: relative !important;
            border-radius: 0 0 16px 16px !important;
            border: 1px solid var(--Border, #E1E1E1) !important;
            border-top: 0 !important;
        }
        
        .vehicle-card-mobile.car-block-three .inner-box .image-box .image {
            border-radius: 15px 15px 0px 0px !important;
        }
        
        /* Hide desktop layout, show mobile layout */
        .vehicle-card-desktop {
            display: none;
        }
        .vehicle-card-mobile {
            display: block;
        }
    }
    
    @media (max-width: 767px) {
        /* General car-block-three rule - exclude vehicle-card-mobile */
        .car-block-three:not(.vehicle-card-mobile) .inner-box .image-box .fair-price-overlay,
        #vehicle-cards-container .service-block-thirteen .inner-box .image-box .fair-price-overlay {
            top: 10px;
            left: 10px;
        }
        
        .car-slider-three .car-block-three .inner-box .image-box .fair-price-overlay {
            bottom: 10px;
        }
        
        /* Vehicle Cards Mobile - Bottom Left Position - Target element with both classes */
        .vehicle-card-mobile.car-block-three .inner-box .image-box .fair-price-overlay {
            top: auto !important;
            bottom: 10px !important;
            left: 10px !important;
            right: auto !important;
        }
        
        /* Vehicle Cards Mobile - Match home page card styles exactly on small screens */
        .vehicle-card-mobile.car-block-three {
            margin: 0 !important;
        }
        
        .vehicle-card-mobile.car-block-three .inner-box .content-box {
            padding: 15px 27px 11px !important;
            margin-top: -9px !important;
            position: relative !important;
            border-radius: 0 0 16px 16px !important;
            border: 1px solid var(--Border, #E1E1E1) !important;
            border-top: 0 !important;
        }
        
        .vehicle-card-mobile.car-block-three .inner-box .image-box .image {
            border-radius: 15px 15px 0px 0px !important;
        }
    }
</style>

