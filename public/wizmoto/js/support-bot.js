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
            
            // Close panel when clicking outside
            $(document).on('click', function(e) {
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
            
            const message = encodeURIComponent('Hello! I need help with my inquiry.');
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
            const conversationId = $('#chat-conversation-id').val();
            const sendButton = $('#chat-send-button');
            
            // Validate
            if (!message || !conversationId) return;
            
            // Check if already sending
            if (sendButton.prop('disabled')) return;
            
            // Disable form and clear input immediately
            sendButton.prop('disabled', true);
            sendButton.html('<i class="fas fa-spinner fa-spin"></i>');
            const originalMessage = message;
            messageInput.val('');
            
            // Message will be added via Echo broadcast - no optimistic UI
            
            $.ajax({
                url: '/support-chat/send',
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    message: originalMessage,
                    conversation_id: conversationId
                },
                timeout: 10000, // 10 second timeout
                success: function(response) {
                    if (response.success) {
                        console.log('✅ Message sent successfully:', response.message);
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
            const messageHtml = `
                <div class="chat-message ${senderType}" data-message-id="${message.id}">
                    <div class="chat-message-content">
                        <div class="chat-message-text">${message.message}</div>
                        <div class="chat-message-time">
                            ${new Date(message.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'})}
                        </div>
                    </div>
                </div>
            `;
            
            $('#chat-messages .no-messages').remove();
            $('#chat-messages').append(messageHtml);
            this.scrollChatToBottom();
        },
        
        loadChatMessages: function() {
            const conversationId = $('#chat-conversation-id').val();
            if (!conversationId) return;
            
            $.ajax({
                url: '/support-chat/messages',
                method: 'GET',
                data: {
                    conversation_id: conversationId
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
            
            // Use Pusher/Echo for all environments (same as guest and provider chat)
            this.initializeSupportEcho();
            
            // Wait for Echo to be ready
            setTimeout(function() {
                if (typeof window.Echo !== 'undefined') {
                    console.log('✅ Listening for messages on conversation.' + conversationUuid);
                    
                    // Listen for new messages on this conversation using UUID
                    window.Echo.channel('conversation.' + conversationUuid)
                        .listen('.MessageSent', function(e) {
                            console.log('📩 New message received via Pusher:', e);
                            
                            // Add all messages (both guest and supporter)
                            const message = {
                                id: e.id,
                                message: e.message,
                                sender_type: e.sender_type,
                                created_at: e.created_at
                            };
                            supportBot.addMessageToChat(message, e.sender_type);
                        })
                        .error(function(error) {
                            console.error('❌ Pusher channel error:', error);
                        });
                    
                    console.log('🔔 Pusher listener attached successfully');
                } else {
                    console.error('❌ Echo still not available after initialization');
                }
            }, 500);
        },
        
        initializeSupportEcho: function() {
            console.log('🔄 Checking Echo availability for support bot');
            
            // Wait for Echo to be available (max 5 seconds)
            let attempts = 0;
            const maxAttempts = 50; // 5 seconds max
            
            const checkEcho = () => {
                attempts++;
                if (typeof window.Echo !== 'undefined') {
                    console.log('✅ Echo is available for support bot');
                    return;
                }
                
                if (attempts >= maxAttempts) {
                    console.log('⏰ Echo timeout - using polling fallback');
                    return;
                }
                
                console.log('⏳ Waiting for Echo to be available... (' + attempts + '/' + maxAttempts + ')');
                setTimeout(checkEcho, 100);
            };
            
            checkEcho();
        },
        
        
        disconnectRealtime: function() {
            const conversationUuid = this.conversationUuid;
            if (conversationUuid && typeof window.Echo !== 'undefined') {
                console.log('🔌 Disconnecting from conversation.' + conversationUuid);
                window.Echo.leaveChannel('conversation.' + conversationUuid);
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