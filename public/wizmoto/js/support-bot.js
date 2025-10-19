$(document).ready(function() {
    // Support Bot Functionality
    const supportBot = {
        whatsappNumber: null, // Will be loaded from settings
        
        init: function() {
            this.loadSettings();
            this.bindEvents();
            this.hideBadgeAfterDelay();
        },
        
        loadSettings: function() {
            // Load WhatsApp number from settings
            $.ajax({
                url: '/api/settings/whatsapp-number',
                method: 'GET',
                success: function(response) {
                    if (response.success && response.value) {
                        supportBot.whatsappNumber = response.value;
                    }
                },
                error: function() {
                    console.error('Failed to load WhatsApp number from settings');
                }
            });
        },
        
        bindEvents: function() {
            // Toggle support panel
            $('#support-bot-toggle').on('click', function(e) {
                e.preventDefault();
                $('#support-bot-panel').toggleClass('active');
            });
            
            // Close support panel
            $('#support-bot-close').on('click', function(e) {
                e.preventDefault();
                $('#support-bot-panel').removeClass('active');
            });
            
            // Handle support options
            $('.support-option').on('click', function(e) {
                e.preventDefault();
                const action = $(this).data('action');
                supportBot.handleAction(action);
            });
            
            // Close panel when clicking outside (but not when modal is open)
            $(document).on('click', function(e) {
                // Don't interfere if Bootstrap modal is open
                if ($('body').hasClass('modal-open')) {
                    return;
                }
                if (!$(e.target).closest('#support-bot').length) {
                    $('#support-bot-panel').removeClass('active');
                }
            });
        },
        
        handleAction: function(action) {
            switch(action) {
                case 'whatsapp':
                    this.openWhatsApp();
                    break;
                case 'internal-chat':
                    this.openInternalChat();
                    break;
            }
            // Close panel after action
            $('#support-bot-panel').removeClass('active');
        },
        
        openWhatsApp: function() {
            if (!this.whatsappNumber) {
                console.error('WhatsApp number not loaded from settings');
                this.showSupportUnavailableAlert();
                return;
            }
            
            const message = encodeURIComponent('Hello! I need help about WizMoto.');
            const whatsappUrl = `https://wa.me/${this.whatsappNumber}?text=${message}`;
            window.open(whatsappUrl, '_blank');
        },
        
        showSupportUnavailableAlert: function() {
            Swal.fire({
                icon: 'warning',
                title: 'Support Unavailable',
                text: 'WhatsApp support is currently unavailable. Please try again later or use our Live Support Chat.',
                confirmButtonText: 'Try Live Chat',
                showCancelButton: true,
                cancelButtonText: 'Close',
                confirmButtonColor: '#405FF2',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'support-alert-popup',
                    title: 'support-alert-title',
                    content: 'support-alert-content'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.openInternalChat();
                }
            });
        },
        
        openInternalChat: function() {
            // Open floating chat modal
            this.openChatModal();
        },
        
        openChatModal: function() {
            // Don't open if Bootstrap modal is already open
            if ($('body').hasClass('modal-open')) {
                console.log('Bootstrap modal is open, skipping support chat');
                return;
            }
            
            // Show the support chat widget
            $('.support-chat-widget').addClass('show');
            
            // Prevent body scroll and ensure modal is interactive
            $('body').addClass('chat-modal-open');
            
            // Initialize chat if not already done
            if (!this.chatInitialized) {
                this.initializeChat();
                this.chatInitialized = true;
            }
        },
        
        closeChatModal: function() {
            $('.support-chat-widget').removeClass('show');
            $('body').removeClass('chat-modal-open');
            // Disconnect from real-time channel
            this.disconnectRealtime();
        },
        
        initializeChat: function() {
            // Bind chat events first
            this.bindChatEvents();
            
            // Get or create conversation (this will initialize real-time when done)
            this.getOrCreateConversation();
        },
        
        getOrCreateConversation: function() {
            $.ajax({
                url: '/support-chat/init',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#chat-conversation-id').val(response.conversation_id);
                        supportBot.conversationUuid = response.conversation_uuid;
                        supportBot.loadChatMessages();
                        
                        // Set up minimal CHAT_CONFIG for initEcho to work
                        if (!window.CHAT_CONFIG) {
                            window.CHAT_CONFIG = {
                                type: 'support',
                                conversationUuid: response.conversation_uuid
                            };
                        }
                        
                        // Initialize real-time messaging after conversation is created
                        supportBot.initializeRealtime();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ Failed to initialize chat:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        responseText: xhr.responseText,
                        error: error
                    });
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Chat Error',
                        text: 'Failed to initialize chat. Please refresh the page and try again.',
                        confirmButtonColor: '#405FF2',
                        timer: 5000
                    });
                }
            });
        },
        
        bindChatEvents: function() {
            // Close widget
            $('#chat-widget-close').on('click', function() {
                supportBot.closeChatModal();
            });
            
            // Send message
            $('#chat-message-form').on('submit', function(e) {
                e.preventDefault();
                supportBot.sendChatMessage();
            });
        },
        
        sendChatMessage: function() {
            const messageInput = $('#chat-message-input');
            const message = messageInput.val().trim();
            const conversationUuid = this.conversationUuid;
            const sendButton = $('#chat-send-button');
            
            // Validate
            if (!message || !conversationUuid) return;
            
            // Check if already sending
            if (sendButton.prop('disabled')) return;
            
            // Disable form and clear input immediately
            sendButton.prop('disabled', true);
            sendButton.html('<i class="fas fa-spinner fa-spin"></i>');
            const originalMessage = message;
            messageInput.val('');
            
            // Add message immediately for better UX (optimistic UI)
            const tempId = 'temp_' + Date.now();
            const tempMessage = {
                id: tempId,
                message: originalMessage,
                sender_type: 'guest',
                created_at: new Date().toISOString()
            };
            this.addMessageToChat(tempMessage, 'guest');
            
            $.ajax({
                url: '/support-chat/send',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    message: originalMessage,
                    conversation_uuid: conversationUuid
                },
                timeout: 10000, // 10 second timeout
                success: function(response) {
                    if (response.success) {
                        console.log('✅ Message sent successfully:', response.message);
                        
                        // Replace temporary message with real message
                        const tempMessage = $(`[data-message-id="${tempId}"]`);
                        if (tempMessage.length) {
                            tempMessage.attr('data-message-id', response.message.id);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ Error sending message:', {
                        status: xhr.status,
                        statusText: xhr.statusText,
                        responseText: xhr.responseText,
                        error: error
                    });
                    
                    // Restore message on error
                    messageInput.val(originalMessage);
                    
                    // Show specific error message
                    let errorMessage = 'Failed to send message. ';
                    if (xhr.status === 0) {
                        errorMessage += 'Network error - please check your connection.';
                    } else if (xhr.status === 404) {
                        errorMessage += 'Chat service not found.';
                    } else if (xhr.status === 500) {
                        errorMessage += 'Server error. Please try again.';
                    } else if (status === 'timeout') {
                        errorMessage += 'Request timed out. Please try again.';
                    } else {
                        errorMessage += 'Please try again.';
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        confirmButtonColor: '#405FF2',
                        timer: 5000
                    });
                },
                complete: function() {
                    // Re-enable button
                    sendButton.prop('disabled', false);
                    sendButton.html('<i class="fas fa-paper-plane"></i>');
                    messageInput.focus();
                }
            });
        },
        
        addMessageToChat: function(message, senderType) {
            console.log('🔍 Adding message to chat:', message, 'senderType:', senderType);
            
            // Properly alternate message sides
            const isGuest = senderType === 'guest';
            const wrapperClass = isGuest ? 'message-right' : 'message-left';
            
            // Get sender name
            const senderName = isGuest ? 'You' : 'Support';
            const timeFormatted = new Date(message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            
            const messageHtml = `
                <div class="message-wrapper ${wrapperClass}" data-message-id="${message.id}">
                    <div class="message-content">
                        <div class="message-header">
                            <span class="sender-name">${senderName}</span>
                            <span class="message-time">${timeFormatted}</span>
                        </div>
                        <div class="message-bubble">
                            ${message.message}
                        </div>
                    </div>
                </div>
            `;
            
            $('#chat-messages .no-messages').remove();
            $('#chat-messages').append(messageHtml);
            this.scrollChatToBottom();
            
            console.log('🔍 Message added to chat, total messages:', $('#chat-messages .message-wrapper').length);
        },
        
        loadChatMessages: function() {
            const conversationUuid = this.conversationUuid;
            if (!conversationUuid) return;
            
            $.ajax({
                url: '/support-chat/messages',
                method: 'GET',
                data: {
                    conversation_uuid: conversationUuid
                },
                success: function(response) {
                    if (response.success && response.messages.length > 0) {
                        $('#chat-messages .no-messages').remove();
                        response.messages.forEach(function(message) {
                            supportBot.addMessageToChat(message, message.sender_type);
                        });
                    }
                }
            });
        },
        
        scrollChatToBottom: function() {
            const messagesContainer = $('#chat-messages');
            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
        },
        
        initializeRealtime: function() {
            const conversationUuid = this.conversationUuid;
            if (!conversationUuid) {
                console.error('Conversation UUID not available');
                return;
            }
            
            // Use the same Echo initialization pattern as guest chat
            this.initializeSupportEcho();
        },
        
        initializeSupportEcho: function() {
            console.log('🔄 Initializing Echo for support bot');
            
            // Check if initEcho function is available
            if (typeof window.initEcho === 'undefined') {
                console.log('⏳ Waiting for initEcho to be available...');
                setTimeout(() => this.initializeSupportEcho(), 1000);
                return;
            }

            // Initialize Echo using the proper function
            if (window.initEcho()) {
                console.log('✅ Echo initialized successfully, starting listeners');
                this.startPusherListeners();
            } else {
                console.error('❌ Failed to initialize Echo');
            }
        },
        
        startPusherListeners: function() {
            const conversationUuid = this.conversationUuid;
            if (!conversationUuid) {
                console.error('❌ No conversation UUID available for support bot');
                return;
            }

            console.log('🍪 Using UUID for support bot Pusher:', conversationUuid);

            window.Echo.channel(`conversation.${conversationUuid}`)
                .listen('.MessageSent', (e) => {
                    console.log('📨 New message received via support bot Pusher:', e);
                    console.log('📨 Listening on channel:', `conversation.${conversationUuid}`);
                    console.log('📨 Message sender type:', e.sender_type);
                    console.log('📨 Message conversation UUID:', e.conversation_uuid);

                    // Check if message already exists (avoid duplicates)
                    const existingMessage = $(`[data-message-id="${e.id}"]`);
                    if (existingMessage.length > 0) {
                        console.log('📨 Message already exists, skipping duplicate');
                        return;
                    }

                    // Only add provider messages via Pusher (guest messages are added optimistically)
                    if (e.sender_type === 'provider') {
                        console.log('📨 Adding provider message to support chat');
                        const message = {
                            id: e.id,
                            message: e.message,
                            sender_type: e.sender_type,
                            created_at: e.created_at
                        };
                        this.addMessageToChat(message, e.sender_type);
                    } else {
                        console.log('📨 Ignoring non-provider message in support bot');
                    }
                })
                .error((error) => {
                    console.error('❌ Failed to subscribe to support bot conversation channel:', error);
                });
        },
        
        
        disconnectRealtime: function() {
            const conversationUuid = this.conversationUuid;
            if (conversationUuid && typeof window.Echo !== 'undefined') {
                console.log('🔌 Disconnecting from conversation.' + conversationUuid);
                window.Echo.leaveChannel(`conversation.${conversationUuid}`);
            }
        },
        
        hideBadgeAfterDelay: function() {
            // Hide badge after 5 seconds
            setTimeout(function() {
                $('#support-bot-badge').fadeOut();
            }, 5000);
        },
        
        showBadge: function() {
            $('#support-bot-badge').fadeIn();
        }
    };
    
    // Initialize support bot
    supportBot.init();
    
    // Optional: Show badge on page load (you can customize this)
    // supportBot.showBadge();
});