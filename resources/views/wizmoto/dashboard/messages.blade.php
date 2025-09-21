@extends('wizmoto.dashboard.master')

@push('chat-config')
<script>
    // Global chat configuration for provider dashboard
    window.CHAT_CONFIG = {
        type: 'provider',
        provider: @json($provider ?? null),
        conversations: @json($conversations ?? null),
        urls: {
            sendMessage: '{{ route("dashboard.send-provider-message") }}',
            getConversation: '{{ route("dashboard.conversation.show", ":uuid") }}'
        }
    };

    // Log configuration state for debugging
    console.log('🔧 Provider dashboard configuration loaded:', {
        hasProvider: !!window.CHAT_CONFIG.provider,
        conversationCount: window.CHAT_CONFIG.conversations ? window.CHAT_CONFIG.conversations.length : 0
    });
</script>
@endpush

@section('dashboard-content')
    <div class="content-column">
        <div class="inner-column">
            <div class="list-title">
                <h3 class="title">Messages</h3>
            </div>
            <div class="chat-widget">
                <div class="widget-content">
                    <div class="row">
                        <div class="contacts_column col-xl-4 col-lg-5 col-md-12 col-sm-12 chat" id="chat_contacts">
                            <div class="card contacts_card">
                                <div class="card-header">
                                    <div class="search-box-one">
                                        <form method="post" action="#" id="search-form">
                                            <div class="form-group">
                                                <span class="icon">
                                                    <img src="images/icons/search.svg" alt="" />
                                                </span>
                                                <input type="search" name="search-field" id="search-input" value=""
                                                    placeholder="Search conversations..." required="">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body contacts_body">
                                    <ul class="contacts">
                                        @forelse($conversations as $conversation)
                                            @php
                                                $guest = $conversation->guest;
                                                $lastMessage = $conversation->messages->sortByDesc('created_at')->first();
                                            @endphp
                                            <li class="contact-item" data-conversation-uuid="{{ $conversation->uuid }}">
                                                <a href="#" class="conversation-link">
                                                    <div class="d-flex bd-highlight">
                                                        <div class="img_cont">
                                                            @if ($guest->avatar)
                                                                <img src="{{ $guest->avatar }}"
                                                                    class="rounded-circle user_img" alt="">
                                                            @else
                                                                <div
                                                                    class="rounded-circle user_img bg-primary text-white d-flex align-items-center justify-content-center">
                                                                    {{ strtoupper(substr($guest->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="user_info">
                                                            <span>{{ $guest->name }}</span>
                                                            <p>{{ $lastMessage ? Str::limit($lastMessage->message, 30) : 'No messages yet' }}
                                                            </p>
                                                        </div>
                                                        <span class="info">
                                                            {{ $lastMessage ? $lastMessage->created_at->diffForHumans() : '' }}
                                                            @if ($conversation->messages->where('read', false)->count() > 0)
                                                                <span
                                                                    class="count bg-success">{{ $conversation->messages->where('read', false)->count() }}</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>

                                        @empty
                                            <li class="text-center py-4">
                                                <p class="text-muted mb-0">No conversations yet</p>
                                                <small class="text-muted">Messages from customers will appear here</small>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class=" col-xl-8 col-lg-7 col-md-12 col-sm-12 chat">
                            <div class="card message-card">
                                <div class="card-header msg_head" id="chat-header" style="display: none;">
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
                                            <p id="guest-email">Click on a contact to start chatting</p>
                                        </div>
                                    </div>

                                    <div class="btn-box">
                                        <button class="dlt-chat" id="delete-conversation" style="display: none;">Delete
                                            Conversation</button>
                                        <button class="toggle-contact"><span class="fa fa-bars"></span></button>
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
                                        <textarea class="form-control type_msg" id="message-input" placeholder="Type a message..." rows="2"></textarea>
                                        <button type="button" class="theme-btn btn-style-one submit-btn"
                                            id="send-message-btn">
                                            <span class="text-dk">Send Message</span>
                                            <span class="text-mb">Send</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                viewBox="0 0 14 14" fill="none">
                                                <g clip-path="url(#clip0_601_692)">
                                                    <path
                                                        d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z"
                                                        fill="white"></path>
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
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    // Get data from global configuration
    const config = window.CHAT_CONFIG;
    if (!config || !config.provider) {
        console.error('❌ Provider configuration not found');
        showChatError('Provider configuration not found. Please refresh the page.');
        return;
    }


    let currentProviderId = config.provider.id;
    let allConversations = config.conversations;
    let currentConversationUuid = null;
    let currentGuest = null;
    let refreshInterval;

    // Start with no conversation selected
    let currentChannel = null;

    

    // Initialize the page
    initializePage();

    function initializePage() {
        // Bind event handlers
        bindEvents();

        // Load initial conversations
        loadConversations();
    }

    function bindEvents() {
        // Handle conversation selection
        $(document).on('click', '.conversation-link', function(e) {
            e.preventDefault();
            const conversationUuid = $(this).closest('.contact-item').data('conversation-uuid');
            if (conversationUuid) {
                selectConversation(conversationUuid);
            }
        });

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

        // Handle search
        $('#search-input').on('input', function() {
            filterConversations($(this).val());
        });

        // Handle search form submission
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            filterConversations($('#search-input').val());
        });
    }

    function loadConversations() {
        // Conversations are already loaded from backend
        console.log('📋 Loaded conversations:', allConversations);
    }

    function selectConversation(conversationUuid) {
        currentConversationUuid = conversationUuid;
        currentConversationAccessToken = null; // Will be set when conversation loads
        currentGuest = null;

        // Remove active class from all contacts
        $('.contact-item').removeClass('active');
        
        // Add active class to selected contact
        $(`.contact-item[data-conversation-uuid="${conversationUuid}"]`).addClass('active');

        // Show loading state
        showChatLoading();

        // Load conversation messages
        loadConversation(conversationUuid);
    }

    function showChatLoading() {
        $('#chat-messages').html(`
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="text-muted mt-2">Loading conversation...</p>
            </div>
        `);
    }

    function loadConversation(conversationUuid) {
        // Find the conversation by UUID
        const conversation = allConversations.find(conv => conv.uuid === conversationUuid);
        if (!conversation) {
            showChatError('Conversation not found');
            return;
        }
        
        $.ajax({
            url: `/dashboard/conversations/${conversationUuid}`,
            method: 'GET',
            timeout: 10000,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                console.log('📨 Conversation loaded successfully');
                if (response.success) {
                    // Store access token for API calls
                    currentConversationAccessToken = response.conversation.access_token;
                    
                    currentGuest = response.guest;
                    displayConversation(response.messages, response.guest);

                    // Show chat header and footer
                    $('#chat-header').fadeIn();
                    $('#chat-footer').fadeIn();
                    $('#no-chat-selected').hide();

                    // Subscribe to this conversation's channel
                    subscribeToConversation(conversationUuid);
                } else {
                    showChatError('Failed to load conversation');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading conversation:', xhr.responseText);
                if (xhr.status === 404) {
                    showChatError('Conversation not found');
                } else if (status === 'timeout') {
                    showChatError('Request timed out. Please try again.');
                } else {
                    showChatError('Failed to load conversation. Please try again.');
                }
            }
        });
    }

    function subscribeToConversation(conversationUuid) {
        console.log('subscribeToConversation', conversationUuid);
        
        // Check if initEcho function is available
        if (typeof window.initEcho !== 'function') {
            console.log('Echo not loaded yet, retrying in 1 second...');
            setTimeout(() => subscribeToConversation(conversationUuid), 1000);
            return;
        }

        // Unsubscribe from previous channel if exists
        if (currentChannel && window.Echo) {
            console.log('🔌 Unsubscribing from previous channel');
            window.Echo.leaveChannel(`conversation.${currentChannel}`);
            currentChannel = null;
        }

        // Initialize Echo for public channels
        if (!window.initEcho({})) {
            console.error('❌ Failed to initialize Echo');
            showChatError('Failed to initialize chat. Please try again.');
            return;
        }

        currentChannel = conversationUuid;

        // Listen for messages on the public conversation channel
        window.Echo.channel(`conversation.${conversationUuid}`)
            .listen('.MessageSent', (e) => {
                console.log('📨 New message received via public channel:', e);
                
                // Add the new message to current chat
                addMessageToChat(e);
                
                // Update conversation list
                updateConversationList(e);
            })
            .error((error) => {
                console.error('❌ Failed to subscribe to conversation channel:', error);
                showChatError('Lost connection to chat. Please try again.');
                currentChannel = null;
            });
    }

    function displayConversation(messages, guest) {
        const chatMessages = $('#chat-messages');
        chatMessages.empty();

        // Update guest info in header
        $('#guest-name').text(guest.name);
        $('#guest-email').text(guest.email);

        if (!messages || messages.length === 0) {
            chatMessages.html(
                '<div class="text-center py-4"><p class="text-muted">No messages yet. Start the conversation!</p></div>'
            );
            return;
        }

        // Create message elements
        messages.forEach((message, index) => {
            const messageDiv = createMessageElement(message);
            chatMessages.append(messageDiv);
        });

        // Scroll to bottom
        scrollToBottom();
    }

    function sendMessage() {
        const message = $('#message-input').val().trim();
        if (!message || !currentConversationUuid) {
            if (!currentConversationUuid) {
                swal.fire({
                    toast: true,
                    title: 'Warning',
                    text: 'Please select a conversation first',
                    icon: 'warning',
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
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
            url: '/dashboard/send-provider-message',
            method: 'POST',
            data: {
                access_token: currentConversationAccessToken,
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
                        sender_type: 'provider',
                        created_at: new Date().toISOString(),
                        guest_id: currentGuest?.id,
                        provider_id: currentProviderId,
                        conversation_id: response.data.conversation_id
                    };
                    addMessageToChat(sentMessage);
                } else {
                    swal.fire({
                        toast: true,
                        title: 'Failed to send message',
                        text: response.message || 'Failed to send message',
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error sending message:', xhr.responseText);
                $('.msg_cotainer.sending').parent().remove();

                if (status === 'timeout') {
                    swal.fire({
                        toast: true,
                        title: 'Message sending timed out. Please try again.',
                        text: 'Message sending timed out. Please try again.',
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    swal.fire({
                        toast: true,
                        title: 'Failed to send message. Please try again.',
                        text: 'Failed to send message. Please try again.',
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            },
            complete: function() {
                // Re-enable send button
                sendBtn.prop('disabled', false);
                sendBtn.find('.text-dk').text('Send Message');
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
        const isProvider = message.sender_type === 'provider';
        const wrapperClass = isProvider ? 'justify-content-end reply' : 'justify-content-start';
        const senderName = isProvider ? 'You' : (message.guest ? message.guest.name : 'Guest');
        const timeFormatted = new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        // For provider messages, try to use provider image or fallback to initials
        let avatarHtml;
        if (isProvider) {
            // Provider messages - try image first, then initials
            const providerImage = (window.CHAT_CONFIG && window.CHAT_CONFIG.provider && window.CHAT_CONFIG.provider.avatar) ? window.CHAT_CONFIG.provider.avatar : null;
            if (providerImage) {
                avatarHtml = `<img src="${providerImage}" alt="" class="rounded-circle user_img_msg" style="width: 40px; height: 40px; object-fit: cover;">`;
            } else {
                const initials = 'P'; // Provider initials
                avatarHtml = `<div class="rounded-circle user_img_msg bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">${initials}</div>`;
            }
        } else {
            // Guest messages - always use initials
            const initials = message.guest ? message.guest.name.charAt(0).toUpperCase() : 'G';
            avatarHtml = `<div class="rounded-circle user_img_msg bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px; font-weight: bold;">${initials}</div>`;
        }

        return $(`
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
    }

    function updateConversationList(messageData) {
        // Update the conversation list with new message
        // You can add logic here to update the last message preview
        console.log('📋 Updating conversation list with new message');
    }

    function filterConversations(searchTerm) {
        const contacts = $('.contact-item');
        
        if (!searchTerm.trim()) {
            contacts.show();
            return;
        }

        const term = searchTerm.toLowerCase();
        contacts.each(function() {
            const contact = $(this);
            const guestName = contact.find('.user_info span').text().toLowerCase();
            const lastMessage = contact.find('.user_info p').text().toLowerCase();
            
            const matches = guestName.includes(term) || lastMessage.includes(term);
            contact.toggle(matches);
        });
    }

    function showChatError(message) {
        $('#chat-messages').html(`
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

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
</script>
@endpush
