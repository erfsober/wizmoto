@extends('master')
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
                        <div class="layout-search style1">
                            <form action="{{ route('inventory.list') }}" method="GET">
                                <div class="search-box">
                                    <svg class="icon" width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.29301 1.2876C3.9872 1.2876 1.29431 3.98048 1.29431 7.28631C1.29431 10.5921 3.9872 13.2902 7.29301 13.2902C8.70502 13.2902 10.0036 12.7954 11.03 11.9738L13.5287 14.4712C13.6548 14.5921 13.8232 14.6588 13.9979 14.657C14.1725 14.6552 14.3395 14.5851 14.4631 14.4617C14.5867 14.3382 14.6571 14.1713 14.6591 13.9967C14.6611 13.822 14.5947 13.6535 14.474 13.5272L11.9753 11.0285C12.7976 10.0006 13.293 8.69995 13.293 7.28631C13.293 3.98048 10.5988 1.2876 7.29301 1.2876ZM7.29301 2.62095C9.87824 2.62095 11.9584 4.70108 11.9584 7.28631C11.9584 9.87153 9.87824 11.9569 7.29301 11.9569C4.70778 11.9569 2.62764 9.87153 2.62764 7.28631C2.62764 4.70108 4.70778 2.62095 7.29301 2.62095Z"
                                            fill="white" />
                                    </svg>
                                    <input type="search" placeholder="Search Scooters, Motorbikes, Bikes..."
                                        class="show-search" name="search" tabindex="2" value=""
                                        aria-required="true" required="">
                                </div>
                            </form>
                        </div>
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
                                <li class="current-dropdown">
                                    <a class="box-account" href="{{ route('blogs.index') }}">
                                        Blog
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

        <div id="nav-mobile"></div>
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
                                        <div class="row">
                                            <div class="contacts_column col-xl-4 col-lg-5 col-md-12 col-sm-12 chat"
                                                id="chat_contacts">
                                                <div class="card contacts_card">
                                                    <div class="card-header">
                                                        <div class="search-box-one">
                                                            <form method="post" action="#" id="search-form">
                                                                <div class="form-group">
                                                                    <span class="icon">
                                                                        <img src="{{ asset('wizmoto/images/icons/search.svg') }}"
                                                                            alt="" />
                                                                    </span>
                                                                    <input type="search" name="search-field"
                                                                        id="search-input" value=""
                                                                        placeholder="Search conversations..."
                                                                        required="">
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
                                                            <li class="contact-item"
                                                                data-provider-id="{{ $provider->id }}">
                                                                <a href="#" class="conversation-link">
                                                                    <div class="d-flex bd-highlight">
                                                                        <div class="img_cont">
                                                                            <div
                                                                                class="rounded-circle user_img bg-primary text-white d-flex align-items-center justify-content-center">
                                                                                {{ strtoupper(substr($provider->full_name, 0, 1)) }}
                                                                            </div>
                                                                        </div>
                                                                        <div class="user_info">
                                                                            <span>{{ $provider->full_name }}</span>
                                                                            <p>{{ $lastMessage ? Str::limit($lastMessage->message, 30) : 'No messages yet' }}
                                                                            </p>
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
                                            <div class=" col-xl-8 col-lg-7 col-md-12 col-sm-12 chat">
                                                <div class="card message-card">
                                                    <div class="card-header msg_head" id="chat-header"
                                                        style="display: none;">
                                                        <div class="d-flex bd-highlight">
                                                            <div class="img_cont">
                                                                <div id="guest-avatar"
                                                                    class="rounded-circle user_img bg-primary text-white d-flex align-items-center justify-content-center"
                                                                    style="width: 40px; height: 40px; font-size: 18px;">
                                                                    G
                                                                </div>
                                                            </div>
                                                            <div class="user_info">
                                                                <span id="guest-name">Select a conversation</span>
                                                                <p id="guest-email">Click on a contact to start chatting
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div class="btn-box">
                                                            <button class="dlt-chat" id="delete-conversation"
                                                                style="display: none;">Delete
                                                                Conversation</button>
                                                            <button class="toggle-contact"><span
                                                                    class="fa fa-bars"></span></button>
                                                        </div>
                                                    </div>

                                                    <div class="card-body msg_card_body" id="chat-messages">
                                                        <div class="text-center py-5" id="no-chat-selected">
                                                            <i class="fa fa-comments fa-3x text-muted mb-3"></i>
                                                            <h5 class="text-muted">Select a conversation</h5>
                                                            <p class="text-muted">Click on a contact from the list to view
                                                                messages</p>
                                                        </div>
                                                    </div>

                                                    <div class="card-footer" id="chat-footer" style="display: none;">
                                                        <div class="form-group mb-0">
                                                            <textarea class="form-control type_msg" id="message-input" placeholder="Type a message..." rows="2"></textarea>
                                                            <button type="button"
                                                                class="theme-btn btn-style-one submit-btn"
                                                                id="send-message-btn">
                                                                <span class="text-dk">Send Message</span>
                                                                <span class="text-mb">Send</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                                    height="14" viewBox="0 0 14 14" fill="none">
                                                                    <g clip-path="url(#clip0_601_692)">
                                                                        <path
                                                                            d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z"
                                                                            fill="white"></path>
                                                                    </g>
                                                                    <defs>
                                                                        <clipPath id="clip0_601_692">
                                                                            <rect width="14" height="14"
                                                                                fill="white"></rect>
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
    </section>

    @include('wizmoto.partials.footer')
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            // Get data from backend
            let currentProviderId = '{{ $provider->id ?? '' }}';
            let currentGuest = @json($guest);
            let currentProvider = @json($provider);
            let currentConversation = @json($conversation);
            const urlParams = new URLSearchParams(window.location.search);
            const guestToken = urlParams.get('guest_token') || '{{ $guestToken ?? '' }}';

            // After setting global variables
            window.guestToken = guestToken;
            window.guestId = currentGuest?.id;
            window.conversationId = currentConversation?.id;

            console.log('Global tokens set:', {
                guestToken: window.guestToken,
                guestId: window.guestId,
                conversationId: window.conversationId
            });

            // Now initialize Echo
            window.initEcho({ guestToken, guestId: currentGuest?.id });

            console.log('Echo initialized', window.guestToken, window.guestId);

            // Initialize the page
            initializePage();

            function initializePage() {
                // Validate required parameters
                if (!conversationId || !guestToken) {
                    showChatError('Invalid conversation link. Missing required parameters.');
                    return;
                }

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
            }

            function loadConversation() {
                if (!conversationId || !guestToken) {
                    showChatError('Invalid conversation parameters');
                    return;
                }

                // Show loading state
                showLoadingState();

                $.ajax({
                    url: '/chat/guest/messages',
                    method: 'POST',
                    data: {
                        conversation_id: conversationId,
                        guest_token: guestToken,
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
                        if (xhr.status === 403) {
                            showChatError('Access denied. Invalid or expired conversation link.');
                        } else if (xhr.status === 404) {
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
                    $('#guest-avatar').fadeOut(200, function() {
                        $(this).attr('src', provider.avatar || '/wizmoto/images/default-avatar.png').fadeIn(
                            200);
                    });
                }
            }

            function sendMessage() {
                const message = $('#message-input').val().trim();
                if (!message) return;

                if (!conversationId || !guestToken) {
                    alert('Invalid conversation parameters');
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
                    data: {
                        conversation_id: conversationId,
                        message: message,
                        guest_token: guestToken,
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
                                conversation_id: conversationId
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
                        if (xhr.status === 403) {
                            errorMessage += 'Invalid or expired conversation link.';
                        } else if (xhr.status === 404) {
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
                if (!currentGuest || !conversationId || !guestToken) return;

                // Check if Echo is available
                if (typeof window.Echo === 'undefined') {
                    console.log('Echo not loaded yet, retrying in 1 second...');
                    setTimeout(startPusherListeners, 1000);
                    return;
                }


                // Listen for messages on the conversation channel
                window.Echo.private(`conversation.${conversationId}`)
                    .listen('.MessageSent', (e) => {
                            console.log(e.user, e.conversation, e.message);
                        console.log('📨 New message received via secure Pusher:', e);

                        // Only add message if it's not from current guest (to avoid duplicates)
                        if (e.sender_type !== 'guest') {
                            addMessageToChat(e);
                        }
                    })
                    .error((error) => {
                        console.error('❌ Failed to subscribe to conversation channel:', error);
                        if (error.status === 403) {
            console.error('🚫 Authentication Failed (403)');
            console.log('Conversation ID:', conversationId);
            console.log('Guest Token:', window.guestToken);
            console.log('Guest ID:', window.guestId);
            console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.content);
            
            // Additional debug info
            console.log('Current URL:', window.location.href);
            console.log('Echo Instance:', window.Echo);
        }
        
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
                const senderImage = isGuest ?
                    '{{ asset('wizmoto/images/resource/candidate-6.png') }}' :
                    '{{ asset('wizmoto/images/resource/candidate-3.png') }}';
                const timeFormatted = formatMessageTime(message.created_at);

                const messageDiv = $(`
<div class="d-flex ${wrapperClass} mb-2">
  <div class="img_cont_msg">
    <img src="${senderImage}" alt="" class="rounded-circle user_img_msg">
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
