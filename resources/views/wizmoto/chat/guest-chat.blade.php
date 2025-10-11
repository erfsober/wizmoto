@extends('master')

@push('chat-config')
<script>
    // Global chat configuration - Available before any JavaScript loads
    window.CHAT_CONFIG = {
        type: 'guest',
        provider: @json($provider ?? null),
        guest: @json($guest ?? null),
        conversation: @json($conversation ?? null),
        conversationUuid: '{{ $conversationUuid ?? "" }}',
        accessToken: '{{ $conversation->access_token ?? "" }}',
        urls: {
            sendMessage: '{{ route("chat.guest.send") }}',
            getMessages: '{{ route("chat.guest.messages") }}'
        }
    };

    // Set conversation UUID in cookie for persistence (1 year expiration)
    if (window.CHAT_CONFIG.conversationUuid) {
        const expirationDate = new Date();
        expirationDate.setFullYear(expirationDate.getFullYear() + 1); // 1 year from now
        
        document.cookie = `conversation_uuid=${window.CHAT_CONFIG.conversationUuid}; expires=${expirationDate.toUTCString()}; path=/; SameSite=Lax`;
        
        console.log('🍪 Conversation UUID saved to cookie:', window.CHAT_CONFIG.conversationUuid);
    }

    // Helper function to get UUID from cookie
    window.getConversationUuid = function() {
        const cookies = document.cookie.split(';');
        for (let cookie of cookies) {
            const [name, value] = cookie.trim().split('=');
            if (name === 'conversation_uuid') {
                return value;
            }
        }
        return null;
    };

    // Log configuration state for debugging
    console.log('🔧 Guest chat configuration loaded:', {
        hasProvider: !!window.CHAT_CONFIG.provider,
        hasGuest: !!window.CHAT_CONFIG.guest,
        hasConversation: !!window.CHAT_CONFIG.conversation,
        conversationUuid: window.CHAT_CONFIG.conversationUuid,
        cookieUuid: window.getConversationUuid()
    });
</script>
@endpush

@section('content')
<!-- Main Header-->
<header class="boxcar-header header-style-v1 style-two inner-header cus-style-1">
    <div class="header-inner">
        <div class="inner-container">
            <!-- Main box -->
            <div class="c-box">
                <div class="logo-inner">
                    <div class="logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('wizmoto/images/logo.png') }}" alt="" title="Boxcar">
                        </a>
                    </div>
                    @include('wizmoto.partials.live-search', ['class' => 'style1'])
                </div>

                <!--Nav Box-->
                <div class="nav-out-bar">
                    <nav class="nav main-menu">
                        <ul class="navigation" id="navbar">
                            <li class="current-dropdown current">
                                    <a class="box-account" href="{{ route('home') }}">
                                    Home
                                </a>
                            </li>
                                @if (Auth::guard('provider')->check())
                                <li class="current-dropdown">
                                    <span>
                                        {{ Auth::guard('provider')->user()->username }}
                                        <i class="fa-solid fa-angle-down"></i>
                                    </span>
                                    <ul class="dropdown">
                                        <li>
                                            <a href="{{ route('dashboard.profile') }}">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('provider.logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                    <form id="logout-form" action="{{ route('provider.logout') }}" method="POST"
                                        style="display: none;">
                                    @csrf
                                </form>
                            @endif
                        </ul>
                    </nav>
                    <!-- Main Menu End-->
                </div>

                <div class="right-box">
                        @if (!Auth::guard('provider')->check())
                        <a href="{{ route('provider.auth') }}" title="" class="box-account">
                            <div class="icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_147_6490)">
                                            <path
                                                d="M7.99998 9.01221C3.19258 9.01221 0.544983 11.2865 0.544983 15.4161C0.544983 15.7386 0.806389 16.0001 1.12892 16.0001H14.871C15.1935 16.0001 15.455 15.7386 15.455 15.4161C15.455 11.2867 12.8074 9.01221 7.99998 9.01221ZM1.73411 14.8322C1.9638 11.7445 4.06889 10.1801 7.99998 10.1801C11.9311 10.1801 14.0362 11.7445 14.2661 14.8322H1.73411Z"
                                                fill="white" />
                                            <path
                                                d="M7.99999 0C5.79171 0 4.12653 1.69869 4.12653 3.95116C4.12653 6.26959 5.86415 8.15553 7.99999 8.15553C10.1358 8.15553 11.8735 6.26959 11.8735 3.95134C11.8735 1.69869 10.2083 0 7.99999 0ZM7.99999 6.98784C6.50803 6.98784 5.2944 5.62569 5.2944 3.95134C5.2944 2.3385 6.43231 1.16788 7.99999 1.16788C9.54259 1.16788 10.7056 2.36438 10.7056 3.95134C10.7056 5.62569 9.49196 6.98784 7.99999 6.98784Z"
                                                fill="white" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_147_6490">
                                                <rect width="16" height="16" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            Sign in
                        </a>
                    @endif
                    <div class="btn">
                            <a href="{{ route('dashboard.create-advertisement') }}" class="header-btn-two btn-anim">Add
                                Listing</a>
                    </div>
                    <div class="mobile-navigation">
                        <a href="#nav-mobile" title="">
                                <svg width="22" height="11" viewBox="0 0 22 11" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="22" height="2" fill="white" />
                                    <rect y="9" width="22" height="2" fill="white" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu  -->
        </div>
    </div>

    <!-- Header Search -->
    <div class="search-popup">
        <span class="search-back-drop"></span>
        <button class="close-search">
            <span class="fa fa-times"></span></button>

        <div class="search-inner">
            <form method="post" action="index.html">
                <div class="form-group">
                    <input type="search" name="search-field" value="" placeholder="Search..." required="">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Header Search -->

    @include('wizmoto.partials.mobile-menu')
</header>
<!-- End header-section -->
<!-- blog section -->
<section class="blog-section v1 layout-radius">
    <div class="boxcar-container">
        <div class="boxcar-title wow fadeInUp">
            <ul class="breadcrumb">
                    <li><a href="{{ route('home') }}">Home</a></li>
                <li><span>Messages</span></li>
            </ul>
            <h2>Messages</h2>
        </div>
        <nav class="wow fadeInUp" data-wow-delay="100ms">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
                        type="button" role="tab" aria-controls="nav-home" aria-selected="true">Messages</button>
          </div>
        </nav>
        <div class="tab-content wow fadeInUp" data-wow-delay="200ms" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row">
                    <div class="content-column">
                        <div class="inner-column">
                            <div class="list-title">
                                <h3 class="title">Messages</h3>
                            </div>
                            <div class="chat-widget">
                                <div class="widget-content">
                                    <div class="row chat-container">
                                        <!-- Mobile Toggle Button -->
                                        <div class="col-12 d-lg-none mb-3">
                                            <button class="mobile-contacts-btn" id="mobile-toggle-contacts">
                                                <i class="fa fa-comments me-2"></i>
                                                <span class="btn-text">Show Contacts</span>
                                                <i class="fa fa-chevron-right ms-auto"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Contacts Sidebar -->
                                        <div class="contacts_column col-xl-4 col-lg-5 col-12 chat" id="chat_contacts">
                                            <div class="card contacts_card">
                                                <div class="card-header">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h5 class="mb-0">Messages</h5>
                                                        <button class="btn btn-sm btn-outline-light d-lg-none" id="close-contacts-btn">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <div class="search-box-one">
                                                        <form method="post" action="#" id="search-form">
                                                            <div class="form-group">
                                                                <span class="icon">
                                                                    <img src="{{ asset('wizmoto/images/icons/search.svg') }}" alt="" />
                                                                </span>
                                                                <input type="search" name="search-field" id="search-input" value=""
                                                                    placeholder="Search conversations..." required="">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="card-body contacts_body">
                                                    <ul class="contacts">
                                                        @php
                                                            $provider = $conversation->first()->provider;
                                                            $lastMessage = $conversation
                                                                ->messages()
                                                                ->orderByDesc('created_at')
                                                                ->first();
                                                        @endphp
                                                        <li class="contact-item" data-provider-id="{{ $provider->id }}">
                                                            <a href="#" class="conversation-link">
                                                                <div class="d-flex bd-highlight">
                                                                    <div class="img_cont">
                                                                        <div class="rounded-circle user_img bg-primary text-white d-flex align-items-center justify-content-center">
                                                                            {{ strtoupper(substr($provider->full_name, 0, 1)) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="user_info">
                                                                        <span>{{ $provider->full_name }}</span>
                                                                        <p>{{ $lastMessage ? Str::limit($lastMessage->message, 30) : 'No messages yet' }}</p>
                                                                    </div>
                                                                    <span class="info">
                                                                        {{ $lastMessage ? $lastMessage->created_at->diffForHumans() : '' }}
                                                                    </span>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Chat Area -->
                                        <div class="col-xl-8 col-lg-7 col-12 chat" id="chat-area">
                                            <div class="card message-card">
                                                <div class="card-header msg_head" id="chat-header" style="display: none;">
                                                    <div class="d-flex bd-highlight">
                                                        <div class="img_cont">
                                                            <div id="guest-avatar" class="rounded-circle user_img bg-primary text-white d-flex align-items-center justify-content-center"
                                                                style="width: 40px; height: 40px; font-size: 18px;">
                                                                G
                                                            </div>
                                                        </div>
                                                        <div class="user_info">
                                                            <span id="guest-name">Select a conversation</span>
                                                            <p id="guest-email">Click on a contact to start chatting</p>
                                                        </div>
                                                    </div>
                                                    <div class="btn-box">
                                                        <button class="dlt-chat" id="delete-conversation" style="display: none;">Delete Conversation</button>
                                                        <button class="toggle-contact d-lg-none"><span class="fa fa-bars"></span></button>
                                                    </div>
                                                </div>

                                                <div class="card-body msg_card_body" id="chat-messages">
                                                    <div class="text-center py-5" id="no-chat-selected">
                                                        <i class="fa fa-comments fa-3x text-muted mb-3"></i>
                                                        <h5 class="text-muted">Select a conversation</h5>
                                                        <p class="text-muted">Click on a contact from the list to view messages</p>
                                                    </div>
                                                </div>

                                                <div class="card-footer" id="chat-footer" style="display: none;">
                                                    <div class="form-group mb-0">
                                                        <div class="message-input-container">
                                                            <textarea class="form-control type_msg" id="message-input" 
                                                                placeholder="Type a message..." rows="2"></textarea>
                                                            <button type="button" class="theme-btn btn-style-one submit-btn" id="send-message-btn">
                                                                <span class="text-dk">Send Message</span>
                                                                <span class="text-mb">Send</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                                    <g clip-path="url(#clip0_601_692)">
                                                                        <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="white"></path>
                                                                    </g>
                                                                    <defs>
                                                                        <clipPath id="clip0_601_692">
                                                                            <rect width="14" height="14" fill="white"></rect>
                                                                        </clipPath>
                                                                    </defs>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('wizmoto.partials.footer')
@endsection

@push('styles')
<style>
/* Simple Mobile Chat Styles */
@media (max-width: 991.98px) {
    /* Mobile contacts button - Modern design */
    .mobile-contacts-btn {
        width: 100%;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        border-radius: 12px;
        padding: 16px 20px;
        color: white;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-bottom: 15px;
    }
    
    .mobile-contacts-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .mobile-contacts-btn:hover::before {
        left: 100%;
    }
    
    .mobile-contacts-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    }
    
    .mobile-contacts-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 10px rgba(0, 123, 255, 0.3);
    }
    
    .mobile-contacts-btn i {
        font-size: 18px;
        transition: transform 0.3s ease;
    }
    
    .mobile-contacts-btn:hover i:last-child {
        transform: translateX(3px);
    }
    
    .mobile-contacts-btn .btn-text {
        flex: 1;
        text-align: left;
        margin-left: 8px;
    }
    
    /* Hide contacts by default on mobile */
    .contacts_column {
        position: fixed;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100vh;
        z-index: 1050;
        background: white;
        transition: left 0.3s ease;
        overflow-y: auto;
    }
    
    .contacts_column.show {
        left: 0;
    }
    
    /* Chat area takes full width on mobile */
    #chat-area {
        width: 100%;
        padding: 0;
    }
    
    /* Message input container */
    .message-input-container {
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }
    
    .message-input-container textarea {
        flex: 1;
        resize: none;
        min-height: 40px;
        max-height: 120px;
    }
    
    .message-input-container button {
        flex-shrink: 0;
        height: 40px;
        padding: 8px 16px;
        white-space: nowrap;
    }
    
    /* Hide desktop text, show mobile text */
    .text-dk {
        display: none;
    }
    
    .text-mb {
        display: inline;
    }
    
    /* Message bubbles */
    .msg_cotainer {
        max-width: 85%;
        word-wrap: break-word;
    }
    
    /* Contact items */
    .contact-item {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }
    
    .contact-item .user_info span {
        font-size: 16px;
        font-weight: 600;
    }
    
    .contact-item .user_info p {
        font-size: 14px;
        margin: 4px 0 0 0;
        color: #666;
    }
    
    .contact-item .info {
        font-size: 12px;
        color: #999;
    }
    
    /* Search box */
    .search-box-one {
        padding: 15px;
    }
    
    .search-box-one input {
        font-size: 16px; /* Prevents zoom on iOS */
    }
}

@media (min-width: 992px) {
    /* Desktop styles */
    .text-dk {
        display: inline;
    }
    
    .text-mb {
        display: none;
    }
    
    .message-input-container {
        display: block;
    }
    
    .message-input-container textarea {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .message-input-container button {
        width: 100%;
    }
}

/* Overlay for mobile contacts */
@media (max-width: 991.98px) {
    .contacts-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1040;
        display: none;
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
    }
    
    .contacts-overlay.show {
        display: block;
    }
    
    /* Ensure page colors don't change when overlay is active */
    body.contacts-open {
        background-color: #f8f9fa !important;
        color: #333 !important;
    }
    
    /* Prevent any color changes to main content */
    .blog-section,
    .boxcar-container,
    .chat-widget,
    .widget-content,
    .chat-container,
    .row,
    .col-12,
    .col-xl-8,
    .col-lg-7 {
        background-color: inherit !important;
        color: inherit !important;
    }
    
    /* Ensure no yellow tinting or color changes */
    * {
        filter: none !important;
        -webkit-filter: none !important;
    }
    
    /* Keep original page background */
    body {
        background-color: #f8f9fa !important;
        color: #333 !important;
    }
    
    /* Ensure chat area maintains proper colors */
    #chat-area {
        background-color: #f8f9fa !important;
    }
    
    .message-card {
        background-color: white !important;
    }
}

/* Mobile close button styling */
@media (max-width: 991.98px) {
    #close-contacts-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Get data from backend
    let currentProviderId = '{{ $provider->id ?? '' }}';
    let currentGuest = @json($guest);
    let currentProvider = @json($provider);
    let currentConversation = @json($conversation);

    // Initialize Echo for public channel
    console.log('🔐 Initializing chat with session-based security');

    // Initialize Echo for public channel
    const initEcho = () => {
        // Check if initEcho function is available
        if (typeof window.initEcho !== 'function') {
            console.log('⏳ Waiting for initEcho function to be available...');
            setTimeout(initEcho, 100);
            return;
        }

        // Initialize Echo for public channel
        if (!window.initEcho({})) {
            console.error('❌ Failed to initialize Echo');
            showChatError('Failed to initialize chat. Please refresh the page.');
            return;
        }

        // Listen for Echo events
        window.addEventListener('echoConnected', function(e) {
            console.log('✅ Echo connected successfully');
            initializePage();
        });

        window.addEventListener('echoError', function(e) {
            console.error('❌ Echo error:', e.detail);
            showChatError('Lost connection to chat. Please refresh the page.');
        });
    };

    initEcho();

    // Listen for custom events from Echo
    window.addEventListener('messageSent', function(e) {
        const messageData = e.detail;
        if (messageData.sender_type !== 'guest') {
            addMessageToChat(messageData);
        }
    });

    window.addEventListener('echoError', function(e) {
        console.error('❌ Echo error:', e.detail);
        showChatError('Lost connection to chat. Please refresh the page.');
    });

    // Initialize the page
    initializePage();

    function initializePage() {
        // Validate required parameters
        if (!currentConversation) {
            showChatError('Conversation not found.');
            return;
        }

        // Set current provider from conversation
        currentProviderId = currentConversation.provider_id;
        currentProvider = currentConversation.provider;

        // Bind event handlers
        bindEvents();

        // Load conversation messages
        loadConversation();

        // Start Pusher listeners for real-time messages
        startPusherListeners();
    }

    function bindEvents() {
        // Handle send message
        $('#send-message-btn').on('click', function() {
            sendMessage();
        });

        $('#message-input').on('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Mobile toggle functionality
        $('#mobile-toggle-contacts').on('click', function() {
            toggleMobileContacts();
        });

        // Close mobile contacts when clicking the close button
        $('#close-contacts-btn').on('click', function() {
            closeMobileContacts();
        });

        // Close mobile contacts when clicking outside
        $(document).on('click', '.contacts-overlay', function() {
            closeMobileContacts();
        });

        // Auto-resize textarea
        $('#message-input').on('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        // Close mobile contacts when a contact is selected
        $('.contact-item').on('click', function() {
            if ($(window).width() < 992) {
                closeMobileContacts();
            }
        });
    }

    function toggleMobileContacts() {
        const contactsColumn = $('#chat_contacts');
        const isVisible = contactsColumn.hasClass('show');
        
        if (isVisible) {
            closeMobileContacts();
        } else {
            openMobileContacts();
        }
    }

    function openMobileContacts() {
        // Add body class to prevent color changes
        $('body').addClass('contacts-open');
        
        // Add overlay
        $('body').append('<div class="contacts-overlay show"></div>');
        
        // Show contacts
        $('#chat_contacts').addClass('show');
        
        // Update button text and icon
        $('#mobile-toggle-contacts').html(`
            <i class="fa fa-times me-2"></i>
            <span class="btn-text">Hide Contacts</span>
            <i class="fa fa-chevron-left ms-auto"></i>
        `);
    }

    function closeMobileContacts() {
        // Remove body class
        $('body').removeClass('contacts-open');
        
        // Remove overlay
        $('.contacts-overlay').remove();
        
        // Hide contacts
        $('#chat_contacts').removeClass('show');
        
        // Update button text and icon
        $('#mobile-toggle-contacts').html(`
            <i class="fa fa-comments me-2"></i>
            <span class="btn-text">Show Contacts</span>
            <i class="fa fa-chevron-right ms-auto"></i>
        `);
    }

    function loadConversation() {
        // Get access token from config
        const accessToken = window.CHAT_CONFIG.accessToken;
        if (!accessToken) {
            showChatError('Conversation not found. Please refresh the page.');
            return;
        }

        // Show loading state
        showLoadingState();

        $.ajax({
            url: '/chat/guest/messages',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                access_token: window.CHAT_CONFIG.accessToken,
                _token: '{{ csrf_token() }}'
            },
            timeout: 10000,
            success: function(response) {
                if (response.success) {
                    displayMessages(response.messages);
                    updateProviderInfo(response.provider);

                    // Show chat header and footer
                    $('#chat-header').fadeIn();
                    $('#chat-footer').fadeIn();
                    $('#no-chat-selected').hide();
                } else {
                    showChatError(response.message || 'Failed to load conversation');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading conversation:', xhr.responseText);
                if (xhr.status === 404) {
                    showChatError('Conversation not found.');
                } else {
                    showChatError('Failed to load conversation. Please try again.');
                }
            }
        });
    }

            function displayMessages(messages) {
        const chatMessages = $('#chat-messages');
        chatMessages.empty();

                if (messages && messages.length > 0) {
                    messages.forEach(function(message) {
                        const messageElement = createMessageElement(message);
                        chatMessages.append(messageElement);
                    });
                    scrollToBottom();
                } else {
                    chatMessages.html(
                        '<div class="text-center text-muted py-4">No messages yet. Start the conversation!</div>'
                    );
                }
            }

            function updateProviderInfo(provider) {
                if (provider) {
                    currentProvider = provider;
        $('#guest-name').fadeOut(200, function() {
                        $(this).text(provider.full_name).fadeIn(200);
        });
        $('#guest-email').fadeOut(200, function() {
                        $(this).text(provider.email).fadeIn(200);
        });
        // Keep the avatar as initials, don't change to image
                }
            }

    function sendMessage() {
        const message = $('#message-input').val().trim();
        if (!message) return;

        // Get access token from config
        const accessToken = window.CHAT_CONFIG.accessToken;
        if (!accessToken) {
            alert('Conversation not found. Please refresh the page.');
            return;
        }

        // Disable send button with visual feedback
        const sendBtn = $('#send-message-btn');
        sendBtn.prop('disabled', true);
        sendBtn.find('.text-dk').text('Sending...');

        // Add sending indicator
        const sendingIndicator = $(
            '<div class="d-flex justify-content-end mb-2"><div class="msg_cotainer sending">Sending...</div></div>'
        );
        $('#chat-messages').append(sendingIndicator);
        scrollToBottom();

        $.ajax({
            url: '/chat/guest/send',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            data: {
                access_token: window.CHAT_CONFIG.accessToken,
                message: message,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#message-input').val('');

                    // Remove sending indicator
                    $('.msg_cotainer.sending').parent().remove();

                    // Add message to chat immediately for better UX
                    const sentMessage = {
                        id: response.data.id,
                        message: message,
                        sender_type: 'guest',
                        created_at: new Date().toISOString(),
                        guest_id: currentGuest.id,
                        provider_id: currentProviderId,
                        conversation_id: currentConversation.id
                    };
                    addMessageToChat(sentMessage);
                } else {
                    alert('Error: ' + (response.message || 'Failed to send message'));
                }
            },
            error: function(xhr, status, error) {
                console.error('Error sending message:', xhr.responseText);
                $('.msg_cotainer.sending').parent().remove();

                let errorMessage = 'Failed to send message. ';
                if (xhr.status === 404) {
                    errorMessage += 'Conversation not found.';
                } else if (xhr.status === 419) {
                    errorMessage += 'CSRF token expired. Please refresh the page.';
                } else {
                    errorMessage += 'Please try again.';
                }
                alert(errorMessage);
            },
            complete: function() {
                // Re-enable send button
                const sendBtn = $('#send-message-btn');
                sendBtn.prop('disabled', false);
                sendBtn.find('.text-dk').text('Send');
            }
        });
    }

    function startPusherListeners() {
        // Check if Echo is available
        if (typeof window.Echo === 'undefined') {
            console.log('Echo not loaded yet, retrying in 1 second...');
            setTimeout(startPusherListeners, 1000);
            return;
        }

        // Get UUID from cookie
        const conversationUuid = window.getConversationUuid();
        if (!conversationUuid) {
            console.error('❌ No conversation UUID available in cookie');
            return;
        }

        console.log('🍪 Using UUID from cookie for Pusher:', conversationUuid);

        window.Echo.channel(`conversation.${conversationUuid}`)
            .listen('.MessageSent', (e) => {
                console.log('📨 New message received via public channel:', e);

                // Only add message if it's not from current guest (to avoid duplicates)
                if (e.sender_type !== 'guest') {
                    addMessageToChat(e);
                }
            })
            .error((error) => {
                console.error('❌ Failed to subscribe to conversation channel:', error);
            });
    }

            function addMessageToChat(messageData) {
                const chatMessages = $('#chat-messages');
                const messageElement = createMessageElement(messageData);
                chatMessages.append(messageElement);
        scrollToBottom();
    }

            function createMessageElement(message) {
        const isGuest = message.sender_type === 'guest';
        const wrapperClass = isGuest ? 'justify-content-end reply' : 'justify-content-start';
        
        // Handle both database messages and Pusher messages
        let senderName, providerName;
        if (message.provider && message.provider.full_name) {
            providerName = message.provider.full_name;
        } else if (currentProvider && currentProvider.full_name) {
            providerName = currentProvider.full_name;
        } else {
            providerName = 'Provider';
        }
        
        senderName = isGuest ? 'You' : providerName;
        const timeFormatted = formatMessageTime(message.created_at);
        
        // For provider messages, try to use provider image or fallback to initials
        let avatarHtml;
        if (isGuest) {
            // Guest messages - always use 'G'
            avatarHtml = `<div class="rounded-circle user_img_msg bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">G</div>`;
        } else {
            // Provider messages - try image first, then initials
            const providerImage = (window.CHAT_CONFIG && window.CHAT_CONFIG.provider && window.CHAT_CONFIG.provider.avatar) ? window.CHAT_CONFIG.provider.avatar : null;
            if (providerImage) {
                avatarHtml = `<img src="${providerImage}" alt="" class="rounded-circle user_img_msg" style="width: 40px; height: 40px; object-fit: cover;">`;
            } else {
                const initials = providerName ? providerName.charAt(0).toUpperCase() : 'P';
                avatarHtml = `<div class="rounded-circle user_img_msg bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">${initials}</div>`;
            }
        }

        const messageDiv = $(`
<div class="d-flex ${wrapperClass} mb-2">
  <div class="img_cont_msg">
    ${avatarHtml}
    <div class="name">${senderName} <span class="msg_time">${timeFormatted}</span></div>
  </div>
  <div class="msg_cotainer">
    ${escapeHtml(message.message)}
  </div>
</div>
`);

        return messageDiv;
    }

    function formatMessageTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diffInMinutes = Math.floor((now - date) / (1000 * 60));

        if (diffInMinutes < 1) return 'Just now';
        if (diffInMinutes < 60) return `${diffInMinutes}m ago`;

        const diffInHours = Math.floor(diffInMinutes / 60);
        if (diffInHours < 24) return `${diffInHours}h ago`;

        const diffInDays = Math.floor(diffInHours / 24);
        if (diffInDays < 7) return `${diffInDays}d ago`;

        return date.toLocaleDateString();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

            function showLoadingState() {
                const chatMessages = $('#chat-messages');
                chatMessages.html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="text-muted mt-2">Loading conversation...</p>
            </div>
        `);
            }

            function showChatError(message) {
        const chatMessages = $('#chat-messages');
                chatMessages.html(`
          <div class="text-center py-4">
              <i class="fa fa-exclamation-triangle text-warning fa-2x mb-2"></i>
              <p class="text-muted">${message}</p>
              <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">Try Again</button>
          </div>
      `);
    }

            function scrollToBottom() {
        const chatMessages = $('#chat-messages');
                chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }
});
</script>
@endpush
