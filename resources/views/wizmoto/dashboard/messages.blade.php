@extends('wizmoto.dashboard.master')
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
                                        @forelse($conversations as $guestId => $conversation)
                                            @php
                                                $guest = $conversation->first()->guest;
                                                $lastMessage = $conversation->sortByDesc('created_at')->first();
                                            @endphp
                                            <li class="contact-item" data-guest-id="{{ $guestId }}">
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
                                                            @if ($conversation->where('read', false)->count() > 0)
                                                                <span
                                                                    class="count bg-success">{{ $conversation->where('read', false)->count() }}</span>
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
            let currentGuestId = null;
            let currentGuest = null;
            let allConversations = @json($conversations);
            let refreshInterval;

            // Initialize the page
            initializePage();

            function initializePage() {
                // Bind event handlers
                bindEvents();

                // Load initial conversations
                loadConversations();

                // Start Pusher listeners for real-time messages
                startPusherListeners();
            }

            function bindEvents() {
                // Handle conversation selection
                $(document).on('click', '.conversation-link', function(e) {
                    e.preventDefault();
                    const guestId = $(this).closest('.contact-item').data('guest-id');
                    if (guestId) {
                        selectConversation(guestId);
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

            function selectConversation(guestId) {
                currentGuestId = guestId;

                // Remove active class from all contacts
                $('.contact-item').removeClass('active');
                // Add active class to selected contact
                $(`.contact-item[data-guest-id="${guestId}"]`).addClass('active');

                // Show loading state
                showChatLoading();

                // Load conversation messages
                loadConversation(guestId);
            }

            function showChatLoading() {
                $('#chat-messages').html(`
              <div class="text-center py-5">
                  <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                  </div>
                  <p class="text-muted mt-2">Loading conversation...</p>
              </div>
          `);
            }

            function loadConversation(guestId) {
                $.ajax({
                    url: `/dashboard/conversations/${guestId}`,
                    method: 'GET',
                    timeout: 10000,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        console.log('AJAX Response received:', response);
                        if (response.success) {
                            console.log('Response is successful, displaying conversation');
                            currentGuest = response.guest;
                            displayConversation(response.messages, response.guest);

                            // Show chat header and footer
                            $('#chat-header').fadeIn();
                            $('#chat-footer').fadeIn();

                            // Ensure the no-chat-selected div is hidden
                            $('#no-chat-selected').hide();
                        } else {
                            console.log('Response success is false');
                            showChatError('Failed to load conversation');
                        }
                    },
                    error: function(xhr, status, error) {
                        if (status === 'timeout') {
                            showChatError('Request timed out. Please try again.');
                        } else {
                            showChatError('Failed to load conversation. Please try again.');
                        }
                    }
                });
            }

            function displayConversation(messages, guest) {
                console.log('Displaying conversation:', {
                    messages: messages,
                    guest: guest
                });

                const chatMessages = $('#chat-messages');
                chatMessages.empty();

                // Make sure the chat area is visible
                $('#no-chat-selected').hide();

                // Update header with fade effect
                $('#guest-name').fadeOut(200, function() {
                    $(this).text(guest.name).fadeIn(200);
                });
                $('#guest-email').fadeOut(200, function() {
                    $(this).text(guest.display_email).fadeIn(200);
                });
                $('#guest-avatar').fadeOut(200, function() {
                    $(this).text(guest.name.charAt(0).toUpperCase()).fadeIn(200);
                });

                if (!messages || messages.length === 0) {
                    console.log('No messages to display');
                    chatMessages.html(
                        '<div class="text-center py-4"><p class="text-muted">No messages yet. Start the conversation!</p></div>'
                    );
                    return;
                }

                console.log('Creating message elements for', messages.length, 'messages');

                // Create message elements immediately (remove animation for now to debug)
                messages.forEach((message, index) => {
                    console.log('Creating message element:', index, message);
                    console.log('Message properties:', Object.keys(message));
                    console.log('Message sender_type:', message.sender_type);
                    console.log('Message content:', message.message);

                    const messageDiv = createMessageElement(message, guest);
                    console.log('Message element created:', messageDiv.html());
                    chatMessages.append(messageDiv);
                });

                // If no messages were created, add a test message to verify display
                if (messages.length > 0 && chatMessages.children().length === 0) {
                    console.log('No message elements found, adding test message');
                    const testDiv = $(
                        '<div style="background: yellow; padding: 20px; margin: 10px; border: 2px solid red;">TEST MESSAGE - If you see this, display is working!</div>'
                    );
                    chatMessages.append(testDiv);
                }

                console.log('Final chat messages HTML:', chatMessages.html());

                // Scroll to bottom
                scrollToBottom();
                console.log('Conversation displayed successfully');
            }

            function createMessageElement(message, guest) {
                console.log('Creating message element for:', message);

                const isGuest = message.sender_type === 'guest';
                const wrapperClass = isGuest ? 'justify-content-start' : 'justify-content-end reply';
                const senderInitial = guest.name.charAt(0).toUpperCase();
                const senderName = isGuest ? senderInitial : 'You';
                const senderImage = isGuest ?
                    'wizmoto/images/resource/candidate-3.png' :
                    'wizmoto/images/resource/candidate-6.png';
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

            function sendMessage() {
                const message = $('#message-input').val().trim();
                if (!message || !currentGuestId) {
                    if (!currentGuestId) {
                        swal.fire({
                            toast: true,
                            title: 'Warning',
                            text: 'Please select a conversation first',
                            icon: 'warning',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                            });
                        return;
                    }
                   
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
                    url: '/dashboard/messages',
                    method: 'POST',
                    data: {
                        guest_id: currentGuestId,
                        message: message,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'Message Sent!') {
                            $('#message-input').val('');
                            sendingIndicator.remove();
                            // Reload conversation to show new message
                            loadConversation(currentGuestId);
                            swal.fire({
                                toast: true,
                                title: 'Message sent successfully!',
                                text: 'Your message has been sent successfully!',
                                icon: 'success',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            sendingIndicator.remove();
                            swal.fire({
                                toast: true,
                                title: 'Failed to send message',
                                text: 'Failed to send message',
                                icon: 'error',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error sending message:', error);
                        sendingIndicator.remove();

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

            function scrollToBottom() {
                const chatMessages = $('#chat-messages');
                chatMessages.animate({
                    scrollTop: chatMessages[0].scrollHeight
                }, 500);
            }

            function showChatError(message) {
                $('#chat-messages').html(`
              <div class="text-center py-4">
                  <i class="fa fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                  <p class="text-muted">${message}</p>
                  <button class="btn btn-sm btn-outline-primary" onclick="loadConversation(${currentGuestId})">Try Again</button>
              </div>
          `);
            }

            function loadConversations() {
                // This is already loaded server-side, but we can add dynamic updates here
                updateConversationCounts();
            }

            function filterConversations(searchTerm) {
                const contacts = $('.contact-item');
                const term = searchTerm.toLowerCase();

                contacts.each(function() {
                    const contact = $(this);
                    const guestName = contact.find('.user_info span').text().toLowerCase();
                    const guestEmail = contact.find('.user_info p').text().toLowerCase();
                    const lastMessage = contact.find('.user_info p:last-child').text().toLowerCase();

                    const matches = guestName.includes(term) ||
                        guestEmail.includes(term) ||
                        lastMessage.includes(term);

                    contact.toggle(matches);
                });
            }

            function updateConversationCounts() {
                // Update unread counts if needed
                $('.contact-item').each(function() {
                    const guestId = $(this).data('guest-id');
                    // You can add unread count logic here
                });
            }

            function startPusherListeners() {
                const provider = @json($provider);
                if (!provider) return;

                // Listen for new messages on provider's private channel (secure)
                window.Echo.private(`provider.${provider.id}`)
                    .listen('MessageSent', (e) => {
                        console.log('New message received:', e);
                        
                        // Add the new message to current chat if it's the same guest
                        if (currentGuestId && currentGuestId == e.guest_id) {
                            addMessageToChat(e);
                        }
                        
                        // Update conversation list
                        updateConversationList(e);
                    });
            }

            function addMessageToChat(messageData) {
                const chatMessages = $('#chat-messages');
                const messageElement = createDashboardMessageElement(messageData);
                chatMessages.append(messageElement);
                chatMessages.scrollTop(chatMessages[0].scrollHeight);
            }

            function createDashboardMessageElement(message) {
                const isProvider = message.sender_type === 'provider';
                const wrapperClass = isProvider ? 'justify-content-end reply' : 'justify-content-start';
                const senderName = isProvider ? 'You' : (message.guest ? message.guest.name : 'Guest');
                const senderImage = isProvider ? 
                    'wizmoto/images/resource/candidate-3.png' : 
                    'wizmoto/images/resource/candidate-6.png';
                const timeFormatted = new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                return $(`
                    <div class="d-flex ${wrapperClass} mb-2">
                        <div class="img_cont_msg">
                            <img src="${senderImage}" alt="" class="rounded-circle user_img_msg">
                            <div class="name">${senderName} <span class="msg_time">${timeFormatted}</span></div>
                        </div>
                        <div class="msg_cotainer">
                            ${message.message}
                        </div>
                    </div>
                `);
            }

            function updateConversationList(messageData) {
                // Update the last message in conversation list
                const contactItem = $(`.contact-item[data-guest-id="${messageData.guest_id}"]`);
                if (contactItem.length) {
                    const messageText = contactItem.find('.user_info p');
                    const timeSpan = contactItem.find('.info');
                    
                    messageText.text(messageData.message.substring(0, 30) + (messageData.message.length > 30 ? '...' : ''));
                    timeSpan.text('Just now');
                    
                    // Move this conversation to the top
                    contactItem.prependTo('.contacts');
                }
            }

            function refreshConversations() {
                // Update timestamps dynamically
                $('.contact-item .info').each(function() {
                    const originalTimestamp = $(this).data('original-timestamp');
                    if (originalTimestamp) {
                        $(this).text(formatMessageTime(originalTimestamp));
                    }
                });
            }

            // Store original timestamps for dynamic updates
            $('.contact-item').each(function() {
                const timestamp = $(this).data('timestamp');
                if (timestamp) {
                    $(this).find('.info').data('original-timestamp', timestamp);
                }
            });

            // Real-time messaging with Pusher - no cleanup needed
        });
    </script>
@endpush
