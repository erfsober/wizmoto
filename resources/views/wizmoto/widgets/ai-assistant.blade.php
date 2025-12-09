<!-- AI Support Welcome Alert -->
<div id="ai-support-alert" class="ai-support-alert">
    <div class="ai-support-alert-content">
        <div class="ai-support-alert-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
            </svg>
        </div>
        <div class="ai-support-alert-text">
            <h4>🤖 {{ __('messages.ai_support_available') }}</h4>
        </div>
        <button id="ai-support-alert-close" class="ai-support-alert-close">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" fill="currentColor"/>
            </svg>
        </button>
    </div>
</div>

<!-- AI Assistant Widget -->
<div id="ai-assistant-widget" class="ai-assistant-widget">
    <!-- Chat Toggle Button -->
        <div id="ai-assistant-toggle" class="ai-assistant-toggle">
        <div class="ai-assistant-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
            </svg>
        </div>
        <div class="ai-assistant-pulse"></div>
    </div>

    <!-- Chat Window -->
    <div id="ai-assistant-chat" class="ai-assistant-chat">
        <!-- Chat Header -->
        <div class="ai-assistant-header">
            <div class="ai-assistant-avatar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
                </svg>
            </div>
            <div class="ai-assistant-info">
                <h4>{{ __('messages.super_ai') }}</h4>
                <span class="ai-status">{{ __('messages.online') }}</span>
            </div>
            <button id="ai-assistant-close" class="ai-assistant-close">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z" fill="currentColor"/>
                </svg>
            </button>
        </div>

        <!-- Chat Messages -->
        <div id="ai-assistant-messages" class="ai-assistant-messages">
            <div class="ai-message ai-message-welcome">
                <div class="ai-message-avatar">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
                    </svg>
                </div>
                <div class="ai-message-content">
                    <p>{{ __('messages.ai_welcome_message_1') }}</p>
                    <p>{{ __('messages.ai_welcome_message_2') }}</p>
                    <p>{{ __('messages.ai_welcome_message_3') }}</p>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="ai-assistant-input-container">
            <div class="ai-assistant-input-wrapper">
                <input type="text" id="ai-assistant-input" placeholder="{{ __('messages.ask_me_anything') }}" maxlength="500">
                <button id="ai-assistant-send" class="ai-assistant-send">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" fill="currentColor"/>
                    </svg>
                </button>
            </div>
            
            <!-- Quick Questions -->
            <div class="ai-quick-questions">
                <div class="ai-question-item" data-question="{{ __('messages.how_search_vehicles') }}">
                    <span>🔍 {{ __('messages.how_search_vehicles') }}</span>
                </div>
                <div class="ai-question-item" data-question="{{ __('messages.what_pricing_options') }}">
                    <span>💰 {{ __('messages.what_pricing_options') }}</span>
                </div>
                <div class="ai-question-item" data-question="{{ __('messages.how_contact_seller') }}">
                    <span>📞 {{ __('messages.how_contact_seller') }}</span>
                </div>
                <div class="ai-question-item" data-question="{{ __('messages.how_list_vehicle') }}">
                    <span>📝 {{ __('messages.how_list_vehicle') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* AI Support Alert Styles */
.ai-support-alert {
    position: fixed;
    bottom: 90px; /* Align bottom with widget bottom */
    right: 90px; /* Position to the left of AI widget icon (20px widget position + 60px icon width + 10px gap) */
    z-index: 10000;
    max-width: 300px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    transform: translateX(20px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    /* Prevent text wrapping that might make it appear bigger */
    white-space: nowrap;
}

.ai-support-alert.show {
    transform: translateX(0);
    opacity: 1;
}

.ai-support-alert-content {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 20px;
    color: white;
    position: relative;
}

.ai-support-alert-icon {
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.ai-support-alert-text h4 {
    margin: 0 0 4px 0;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.2;
}

.ai-support-alert-text p {
    margin: 0;
    font-size: 12px;
    opacity: 0.9;
    line-height: 1.3;
}

.ai-support-alert-close {
    position: absolute;
    top: 8px;
    right: 8px;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: background 0.2s;
    opacity: 0.7;
}

.ai-support-alert-close:hover {
    background: rgba(255, 255, 255, 0.1);
    opacity: 1;
}

/* Desktop: Ensure alert appears beside widget, not above */
@media (min-width: 769px) {
    .ai-support-alert {
        bottom: 90px !important; /* Align bottom edge with widget bottom */
        right: 90px !important; /* Position to the left of widget icon (20px + 60px + 10px gap) */
        top: auto !important;
        margin-bottom: 0 !important;
    }
}

/* AI Quick Questions Styles */
.ai-quick-questions {
    padding: 12px 0 0 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-top: 8px;
    margin-right: 0;
    padding-right: 10px; /* Space for scrollbar */
    max-height: 100px; /* Smaller height to show first message and make scrollable */
    overflow-y: auto;
    overflow-x: hidden;
    /* Custom scrollbar */
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f7fafc;
    /* Make container smaller to prevent scrollbar overlap */
    box-sizing: border-box;
}

.ai-quick-questions::-webkit-scrollbar {
    width: 6px;
}

.ai-quick-questions::-webkit-scrollbar-track {
    background: #f7fafc;
    border-radius: 3px;
}

.ai-quick-questions::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 3px;
}

.ai-quick-questions::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}

.ai-question-item {
    background: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 8px 10px; /* Slightly reduced padding to make box smaller */
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 12px; /* Readable font size */
    font-weight: 500;
    color: #212529; /* Darker for better contrast */
    display: flex;
    align-items: center;
    margin: 0;
    width: calc(100% - 10px); /* Make slightly smaller to accommodate scrollbar */
    box-sizing: border-box;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    flex-shrink: 0; /* Prevent shrinking in scrollable container */
    line-height: 1.4; /* Better line spacing */
}

.ai-question-item:hover {
    background: #e9ecef;
    border-color: #667eea;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
}

.ai-question-item span {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
}

/* AI Assistant Widget Styles */
.ai-assistant-widget {
    position: fixed;
    bottom: 90px;
    right: 20px;
    z-index: 10000; /* Above support chat (9999) */
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.ai-assistant-toggle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
    transition: all 0.3s ease;
    position: relative;
}

.ai-assistant-toggle:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
}

.ai-assistant-icon {
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ai-assistant-pulse {
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    border-radius: 50%;
    background: rgba(102, 126, 234, 0.3);
    animation: ai-pulse 2s infinite;
}

@keyframes ai-pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    100% {
        transform: scale(1.4);
        opacity: 0;
    }
}

.ai-assistant-chat {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 450px; /* Bigger width */
    height: 510px; /* Bigger height */
    max-height: 500px;
    background: white;
    border-radius: 12px; /* Match support chat */
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(0, 0, 0, 0.05);
    display: none;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.08);
    z-index: 10001;
}

.ai-assistant-chat.active {
    display: flex;
    animation: ai-slide-up 0.3s ease;
}

/* Hide support chat widget when AI chat is active */
body.ai-chat-active .support-chat-widget {
    display: none !important;
    opacity: 0 !important;
    pointer-events: none !important;
    z-index: 1 !important;
    visibility: hidden !important;
}



/* Support chat widget should be above widget icons */
.support-chat-widget.show {
    z-index: 10002 !important; /* Above AI assistant widget (10000) and support bot icons */
}

/* Lower widget z-index and disable pointer events when modals are open */
body.modal-open .ai-assistant-widget,
body.modal-open .ai-assistant-toggle {
    pointer-events: none !important; /* Don't block modal interactions */
}

body.modal-open #support-bot,
body.modal-open #chat-widget {
    z-index: 1000 !important; /* Lower than modals */
}

body.modal-open .support-chat-widget {
    z-index: 1000 !important; /* Lower than modals */
}

@keyframes ai-slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.ai-assistant-header {
    padding: 10px 40px; /* Match support chat */
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    gap: 12px;
}

.ai-assistant-avatar {
    width: 32px;
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.ai-assistant-info h4 {
    margin: 0;
    font-size: 16px; /* Match support chat */
    font-weight: 600;
}

.ai-status {
    font-size: 12px; /* Match support chat */
    opacity: 0.9; /* Match support chat */
}

.ai-assistant-close {
    margin-left: auto;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: background 0.2s;
}

.ai-assistant-close:hover {
    background: rgba(255, 255, 255, 0.1);
}

.ai-assistant-messages {
    flex: 1;
    padding: 10px 40px 10px; /* Minimal top padding to show first message */
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 0; /* Match support chat */
    min-height: 0; /* Ensure flex child can shrink */
}

.ai-message {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    margin-bottom: 12px; /* Add margin between messages */
}

.ai-message:last-child {
    margin-bottom: 0; /* Remove margin from last message */
}

.ai-message-avatar {
    width: 24px;
    height: 24px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 2px;
}

.ai-message-avatar svg {
    color: white;
}

.ai-message-content {
    background: #f1f3f4; /* Match support chat */
    padding: 10px 14px; /* Better padding for readability */
    border-radius: 18px; /* Match support chat */
    max-width: 80%;
    font-size: 13px; /* Readable font size */
    line-height: 1.5; /* Better line spacing */
    color: #212529; /* Darker for better contrast */
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1); /* Match support chat */
}

.ai-message-content p {
    margin: 0 0 8px 0; /* Better spacing */
    font-size: 15px; /* Readable font size */

}

.ai-message-content p:last-child {
    margin-bottom: 0;
}

.ai-message-welcome {
    margin-top: 0; /* Ensure welcome message is at top */
}

.ai-message-welcome .ai-message-content {
    font-size: 8px; /* Smaller font for welcome message on desktop */
    padding: 6px 10px; /* Smaller padding */
    line-height: 1; /* Tighter line spacing */
}

.user-message {
    flex-direction: row-reverse;
}

.user-message .ai-message-content {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.user-message .ai-message-avatar {
    background: #e9ecef;
}

.user-message .ai-message-avatar svg {
    color: #667eea;
}

.ai-assistant-input-container {
    padding: 20px; /* Match support chat */
    border-top: 1px solid #e0e0e0; /* Match support chat */
    background: white; /* Match support chat */
}

.ai-assistant-input-wrapper {
    display: flex;
    gap: 8px;
    margin-bottom: 12px;
}

.ai-assistant-input-wrapper input {
    flex: 1;
    padding: 12px 16px; /* Match support chat */
    border: 1px solid #e0e0e0; /* Match support chat */
    border-radius: 25px; /* Match support chat */
    font-size: 14px; /* Match support chat */
    outline: none;
    transition: border-color 0.2s;
}

.ai-assistant-input-wrapper input::placeholder {
    font-size: 12px; /* Smaller placeholder font */
    color: #999;
}

.ai-assistant-input-wrapper input:focus {
    border-color: #667eea;
}

.ai-assistant-input-wrapper input:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.ai-assistant-send:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.ai-assistant-send {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
}

.ai-assistant-send:hover {
    transform: scale(1.05);
}


.ai-typing {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 8px 0;
}

.ai-typing-dot {
    width: 6px;
    height: 6px;
    background: #667eea;
    border-radius: 50%;
    animation: ai-typing 1.4s infinite;
}

.ai-typing-dot:nth-child(2) {
    animation-delay: 0.2s;
}

.ai-typing-dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes ai-typing {
    0%, 60%, 100% {
        transform: translateY(0);
    }
    30% {
        transform: translateY(-10px);
    }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .ai-message-content p {
        font-size: 13px; /* Readable font size */
    }
    .ai-support-alert {
        bottom: 75px !important; /* Align with AI widget button (same as widget bottom on mobile) */
        right: 77px !important; /* Position to the left of AI widget icon (15px widget + 52px icon + 10px gap) */
        left: auto !important;
        top: auto !important;
        max-width: 320px !important; /* Wider width to fit text in one line */
        width: auto !important;
        min-width: 250px !important; /* Minimum width to ensure text fits */
        margin: 0 !important;
        transform: translateX(20px) !important;
        position: fixed !important;
        white-space: nowrap !important; /* Keep text in one line */
    }
    
    .ai-support-alert.show {
        transform: translateX(0) !important;
    }
    
    .ai-support-alert-content {
        padding: 8px 12px !important; /* Increased padding */
        gap: 8px !important; /* Increased gap */
        min-height: auto !important;
        height: auto !important;
        display: flex !important;
        align-items: center !important;
    }
    
    .ai-support-alert-icon {
        width: 24px !important; /* Increased icon size */
        height: 24px !important;
        flex-shrink: 0 !important;
    }
    
    .ai-support-alert-icon svg {
        width: 14px !important;
        height: 14px !important;
    }
    
    .ai-support-alert-text {
        flex: 1 !important;
        min-width: 0 !important;
        overflow: hidden !important;
    }
    
    .ai-support-alert-text h4 {
        font-size: 11px !important; /* Increased text size */
        margin: 0 !important;
        line-height: 1.2 !important;
        padding: 0 !important;
        white-space: nowrap !important; /* Keep text in one line */
        overflow: visible !important;
    }
    
    .ai-support-alert-text p {
        display: none !important; /* Hide paragraph on mobile */
    }
    
    .ai-support-alert-close {
        width: 20px !important;
        height: 20px !important;
        top: 4px !important;
        right: 4px !important;
        padding: 2px !important;
        flex-shrink: 0 !important;
    }
    
    .ai-support-alert-close svg {
        width: 10px !important;
        height: 10px !important;
    }
    
    .ai-quick-questions {
        padding: 8px 0 0 0;
        gap: 6px;
        max-height: 90px; /* Smaller height to show first message and make scrollable */
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .ai-question-item {
        font-size: 12px; /* Readable font size */
        padding: 8px 12px; /* Better padding for readability */
        flex-shrink: 0;
        color: #212529; /* Darker for better contrast */
        line-height: 1.4;
    }
    
  

    .support-bot {
            bottom: calc(56px + 80px) !important; /* Above sticky button (56px) + AI widget space (60px + 20px gap) */
        }
        
        /* Support chat widget - position above sticky button */
        .support-chat-widget {
            bottom: calc(56px + 80px) !important; /* Above sticky button (56px) + AI widget space (60px + 20px gap) */
        }
        
        /* AI assistant widget - position above support bot */
        .ai-assistant-widget {
            bottom: calc(56px + 20px) !important; /* Above sticky button (56px) + gap (20px) */
            right: 15px !important;
        }
    .ai-assistant-chat {
        position: fixed;
        left: 15px;
        right: 15px;
        bottom: calc(56px + 20px); /* 56px button height + 20px gap */
        width: calc(100vw - 30px);
        max-width: 450px; /* Bigger width */
        height: 500px; /* Bigger height */
        max-height: 500px;
        border-radius: 12px; /* Match support chat */
        margin: 0 auto;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(0, 0, 0, 0.05);
        z-index: 30;
    }
    
    .ai-assistant-toggle {
        width: 56px;
        height: 56px;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
    }
    
    .ai-assistant-header {
        padding: 10px 40px; /* Match support chat */
        border-radius: 12px 12px 0 0;
    }
    
    .ai-assistant-avatar {
        width: 28px;
        height: 28px;
    }
    
    .ai-assistant-info h4 {
        font-size: 13px;
    }
    
    .ai-status {
        font-size: 10px;
    }
    
    .ai-assistant-messages {
        padding: 10px 20px 10px; /* Minimal top padding to show first message */
        gap: 0;
    }
    
    .ai-message-content {
        padding: 10px 14px; /* Better padding for readability */
        font-size: 12px; /* Smaller font size for mobile */
        max-width: 85%;
        line-height: 1.4;
        color: #212529; /* Darker for better contrast */
    }
    
    .ai-message-welcome .ai-message-content {
        font-size: 9px; /* Smaller font for welcome message */
        padding: 7px 11px; /* Smaller padding */
        line-height: 1; /* Tighter line spacing */
    }
    
    .ai-assistant-input-container {
        padding: 15px; /* Match support chat mobile */
    }
    
    .ai-assistant-input-wrapper {
        margin-bottom: 10px;
    }
    
    .ai-assistant-input-wrapper input {
        padding: 10px 14px;
        font-size: 13px; /* Smaller input font */
    }
    
    .ai-assistant-input-wrapper input::placeholder {
        font-size: 10px; /* Smaller placeholder font for mobile */
    }
    
    .ai-assistant-send {
        width: 36px;
        height: 36px;
        min-width: 36px;
        min-height: 36px;
    }
    
    .ai-assistant-close {
        min-width: 32px;
        min-height: 32px;
        padding: 6px;
    }
    
    .ai-question-item {
        min-height: 40px;
        touch-action: manipulation;
    }
}

/* Extra small mobile devices */
@media (max-width: 480px) {
    .ai-assistant-chat {
        height: 500px; /* Bigger height */
        max-height: 500px;
    }
    
    .ai-assistant-widget {
        bottom: 75px !important; /* Position above support bot (15px + 50px height + 10px gap) */
        right: 15px !important; /* Same as support bot - vertically aligned */
    }
    
    .ai-assistant-toggle {
        width: 52px;
        height: 52px;
    }
    
    .ai-assistant-header {
        padding: 10px 14px;
    }
    
    .ai-assistant-messages {
        padding: 8px 15px 10px; /* Minimal top padding to show first message */
    }
    
    .ai-message-content {
        font-size: 11px; /* Smaller font size for very small screens */
        padding: 8px 12px; /* Better padding for readability */
        line-height: 1.1;
        color: #212529; /* Darker for better contrast */
    }
    
    .ai-message-welcome .ai-message-content {
        font-size: 8px; /* Smaller font for welcome message on very small screens */
        padding: 6px 9px; /* Smaller padding */
        line-height: 1.2; /* Tighter line spacing */
    }
    
    .ai-assistant-input-container {
        padding: 10px 14px;
    }
    
    .ai-quick-questions {
        max-height: 80px; /* Smaller height to show first message and make scrollable */
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .ai-question-item {
        font-size: 11px; /* Readable font size */
        padding: 7px 10px; /* Better padding for readability */
        flex-shrink: 0;
        color: #212529; /* Darker for better contrast */
        line-height: 1.4;
    }
}

/* Lock background scroll when chat is open on mobile */
@media (max-width: 768px) {
    body.ai-chat-open {
        overflow: hidden;
        touch-action: none;
    }

    /* Move or hide other floating widgets to avoid overlapping AI chat */
    body.ai-chat-open #support-bot,
    body.ai-chat-open #chat-widget {
        opacity: 0;
        pointer-events: none;
        transform: translateY(40px);
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    
    /* Hide support chat widget when AI chat is active on mobile */
    body.ai-chat-open .support-chat-widget {
        display: none !important;
        opacity: 0 !important;
        pointer-events: none !important;
        z-index: 1 !important;
    }
}
</style>

<script>
    // Function to extract page-specific data for AI context
    function getPageSpecificData() {
        const pageData = {
            vehicle_info: {},
            filters: {},
            user_location: {},
            search_results: {}
        };

        // Extract vehicle information if on advertisement page
        if (window.location.pathname.includes('/advertisements/')) {
            const vehicleInfo = {
                title: document.querySelector('h1')?.textContent || '',
                price: document.querySelector('.price')?.textContent || '',
                year: document.querySelector('[data-year]')?.getAttribute('data-year') || '',
                brand: document.querySelector('[data-brand]')?.getAttribute('data-brand') || '',
                model: document.querySelector('[data-model]')?.getAttribute('data-model') || '',
                mileage: document.querySelector('[data-mileage]')?.getAttribute('data-mileage') || '',
                fuel_type: document.querySelector('[data-fuel]')?.getAttribute('data-fuel') || '',
                location: document.querySelector('[data-location]')?.getAttribute('data-location') || ''
            };
            pageData.vehicle_info = vehicleInfo;
        }

        // Extract filter information if on inventory page
        if (window.location.pathname.includes('/inventory')) {
            const filters = {};
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(input => {
                const name = input.name;
                const value = input.value;
                if (!filters[name]) filters[name] = [];
                filters[name].push(value);
            });
            pageData.filters = filters;
        }

        // Extract search results count
        const resultsCount = document.querySelector('.results-count')?.textContent || 
                           document.querySelector('[data-results-count]')?.getAttribute('data-results-count') || '';
        if (resultsCount) {
            pageData.search_results.count = resultsCount;
        }

        return pageData;
    }

document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit for all elements to be ready
    setTimeout(() => {
    const toggle = document.getElementById('ai-assistant-toggle');
    const chat = document.getElementById('ai-assistant-chat');
    const close = document.getElementById('ai-assistant-close');
    const input = document.getElementById('ai-assistant-input');
    const send = document.getElementById('ai-assistant-send');
    const messages = document.getElementById('ai-assistant-messages');

        // AI Support Alert elements
        const aiAlert = document.getElementById('ai-support-alert');
        const aiAlertClose = document.getElementById('ai-support-alert-close');
        
        // If AI alert exists, show it immediately for testing
        if (aiAlert) {
            
            // Force show the alert with inline styles for testing
            aiAlert.style.display = 'block';
            aiAlert.style.opacity = '1';
            aiAlert.style.position = 'fixed';
            aiAlert.style.zIndex = '10000';
            aiAlert.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
            aiAlert.style.color = 'white';
            aiAlert.style.padding = '0';
            aiAlert.style.borderRadius = '12px';
            aiAlert.style.boxShadow = '0 8px 32px rgba(102, 126, 234, 0.3)';
            aiAlert.style.fontFamily = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
            
            // Function to update alert styles
            const updateAlertStyles = () => {
                if (window.innerWidth <= 768) {
                    // Mobile: beside widget, smaller size
                    aiAlert.style.bottom = '75px';
                    aiAlert.style.right = '77px';
                    aiAlert.style.left = 'auto';
                    aiAlert.style.maxWidth = '320px';
                    aiAlert.style.minWidth = '250px';
                    aiAlert.style.width = 'auto';
                    aiAlert.style.whiteSpace = 'nowrap';
                    aiAlert.style.transform = 'translateX(0)';
                } else {
                    // Desktop: beside widget
                    aiAlert.style.bottom = '90px';
                    aiAlert.style.right = '90px';
                    aiAlert.style.left = 'auto';
                    aiAlert.style.maxWidth = '300px';
                    aiAlert.style.minWidth = 'auto';
                    aiAlert.style.width = 'auto';
                    aiAlert.style.transform = 'translateX(0)';
                }
            };
            
            // Set initial styles
            updateAlertStyles();
            
            // Update on resize
            window.addEventListener('resize', updateAlertStyles);
            
            // Make sure the content is visible
            const alertContent = aiAlert.querySelector('.ai-support-alert-content');
            if (alertContent) {
                alertContent.style.display = 'flex';
                alertContent.style.alignItems = 'center';
                
                // Mobile vs Desktop padding
                if (window.innerWidth <= 768) {
                    alertContent.style.gap = '8px';
                    alertContent.style.padding = '8px 12px';
                } else {
                alertContent.style.gap = '12px';
                alertContent.style.padding = '16px 20px';
                }
                alertContent.style.position = 'relative';
                console.log('✅ Alert content found and styled');
                
                // Style the text elements
                const alertText = alertContent.querySelector('.ai-support-alert-text');
                if (alertText) {
                    alertText.style.flex = '1';
                    alertText.style.minWidth = '0';
                    if (window.innerWidth <= 768) {
                        alertText.style.paddingRight = '20px'; // Smaller space for close button on mobile
                    } else {
                        alertText.style.paddingRight = '30px';
                    }
                }
                
                const alertTitle = alertContent.querySelector('h4');
                if (alertTitle) {
                    alertTitle.style.margin = '0';
                    alertTitle.style.fontWeight = '600';
                    alertTitle.style.lineHeight = '1.2';
                    if (window.innerWidth <= 768) {
                        alertTitle.style.fontSize = '11px';
                    } else {
                        alertTitle.style.fontSize = '14px';
                    }
                }
                
                // Hide paragraph on mobile
                const alertParagraph = alertContent.querySelector('p');
                if (alertParagraph && window.innerWidth <= 768) {
                    alertParagraph.style.display = 'none';
                }
                
                // Style the icon
                const alertIcon = alertContent.querySelector('.ai-support-alert-icon');
                if (alertIcon) {
                    alertIcon.style.background = 'rgba(255, 255, 255, 0.2)';
                    alertIcon.style.borderRadius = '50%';
                    alertIcon.style.display = 'flex';
                    alertIcon.style.alignItems = 'center';
                    alertIcon.style.justifyContent = 'center';
                    alertIcon.style.flexShrink = '0';
                    if (window.innerWidth <= 768) {
                        alertIcon.style.width = '24px';
                        alertIcon.style.height = '24px';
                    } else {
                        alertIcon.style.width = '32px';
                        alertIcon.style.height = '32px';
                    }
                }
                
                // Style the close button
                const closeBtn = alertContent.querySelector('.ai-support-alert-close');
                if (closeBtn) {
                    closeBtn.style.position = 'absolute';
                    closeBtn.style.background = 'none';
                    closeBtn.style.border = 'none';
                    closeBtn.style.color = 'white';
                    closeBtn.style.cursor = 'pointer';
                    closeBtn.style.borderRadius = '4px';
                    closeBtn.style.opacity = '0.8';
                    closeBtn.style.display = 'flex';
                    closeBtn.style.alignItems = 'center';
                    closeBtn.style.justifyContent = 'center';
                    closeBtn.style.transition = 'all 0.2s ease';
                    if (window.innerWidth <= 768) {
                        closeBtn.style.top = '4px';
                        closeBtn.style.right = '4px';
                        closeBtn.style.padding = '2px';
                        closeBtn.style.width = '20px';
                        closeBtn.style.height = '20px';
                    } else {
                        closeBtn.style.top = '6px';
                        closeBtn.style.right = '6px';
                        closeBtn.style.padding = '6px';
                        closeBtn.style.width = '24px';
                        closeBtn.style.height = '24px';
                    }
                    
                    // Add hover effect
                    closeBtn.addEventListener('mouseenter', function() {
                        this.style.background = 'rgba(255, 255, 255, 0.1)';
                        this.style.opacity = '1';
                    });
                    
                    closeBtn.addEventListener('mouseleave', function() {
                        this.style.background = 'none';
                        this.style.opacity = '0.8';
                    });
                }
            }
            
            aiAlert.classList.add('show');
            
            // Hide after 10 seconds (increased from 5 seconds)
            setTimeout(() => {
                aiAlert.style.display = 'none';
            }, 10000);
        } else {
            // Create a simple fallback alert
            const fallbackAlert = document.createElement('div');
            fallbackAlert.innerHTML = '🤖 {{ __('messages.ai_support_available') }}';
            fallbackAlert.style.cssText = `
                position: fixed;
                bottom: 160px;
                right: 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 16px 20px;
                border-radius: 12px;
                z-index: 10000;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
                font-size: 14px;
                font-weight: 600;
                box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
                max-width: 320px;
                min-width: 280px;
            `;
            document.body.appendChild(fallbackAlert);
            
            setTimeout(() => {
                fallbackAlert.remove();
            }, 5000);
        }
        
        // Continue with the rest of the initialization
        initializeAIAssistant();
    }, 1000); // Wait 1 second for everything to load
    
    function initializeAIAssistant() {
        const toggle = document.getElementById('ai-assistant-toggle');
        const chat = document.getElementById('ai-assistant-chat');
        const close = document.getElementById('ai-assistant-close');
        const input = document.getElementById('ai-assistant-input');
        const send = document.getElementById('ai-assistant-send');
        const messages = document.getElementById('ai-assistant-messages');
        const aiAlert = document.getElementById('ai-support-alert');
        const aiAlertClose = document.getElementById('ai-support-alert-close');


    let isOpen = false;
    
    // AI Support Alert functionality
    function showAISupportAlert() {
        // Check if user has already seen the alert today
        const today = new Date().toDateString();
        const lastShown = localStorage.getItem('ai-support-alert-shown');
        const hasInteractedWithAI = localStorage.getItem('ai-assistant-interacted') === 'true';
        
        // For testing: Show alert on every page refresh
        // Comment out the condition below to always show the alert
        if (aiAlert) {
            setTimeout(() => {
                aiAlert.classList.add('show');
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    hideAISupportAlert();
                }, 5000);
            }, 2000); // Show after 2 seconds delay
        }
        
        // Original logic (commented out for testing):
        // if (lastShown !== today && !hasInteractedWithAI && aiAlert) {
        //     setTimeout(() => {
        //         aiAlert.classList.add('show');
        //         setTimeout(() => {
        //             hideAISupportAlert();
        //         }, 10000);
        //     }, 2000);
        // }
    }
    
    function hideAISupportAlert() {
        if (aiAlert) {
            aiAlert.classList.remove('show');
            // Ensure hidden even if inline styles were applied
            aiAlert.style.opacity = '0';
            aiAlert.style.transform = 'translateY(20px)';
            aiAlert.style.display = 'none';
            localStorage.setItem('ai-support-alert-shown', new Date().toDateString());
        }
    }
    
    // Show AI support alert on page load
    showAISupportAlert();
    
        // Close alert when close button is clicked
        if (aiAlertClose) {
            aiAlertClose.addEventListener('click', hideAISupportAlert);
        }
        
        // Handle question clicks in chat window
        const questionItems = document.querySelectorAll('.ai-question-item');
        console.log('Found question items:', questionItems.length);
        
        questionItems.forEach((item, index) => {
            console.log(`Question ${index + 1}:`, item.textContent);
            item.addEventListener('click', function() {
                const question = this.getAttribute('data-question');
                console.log('Clicked question:', question);
                if (question) {
                    // Set the question in the input
                    const input = document.getElementById('ai-assistant-input');
                    if (input) {
                        input.value = question;
                       
                        
                        // Send the message
                        setTimeout(() => {
                            const sendBtn = document.getElementById('ai-assistant-send');
                            if (sendBtn) {
                                sendBtn.click();
                            }
                        }, 100);
                    }
                }
            });
        });
    
    // Toggle chat and handle AI alert
    if (toggle) {
        toggle.addEventListener('click', function() {
            // Hide AI alert and mark as interacted
            hideAISupportAlert();
            localStorage.setItem('ai-assistant-interacted', 'true');

    // Toggle chat
        isOpen = !isOpen;
        chat.classList.toggle('active', isOpen);
        // Add/remove body class for CSS targeting
        if (isOpen) {
            document.body.classList.add('ai-chat-active');
        } else {
            document.body.classList.remove('ai-chat-active');
        }
        if (isOpen) {
            // Close support chat if it's open
            const supportChat = document.querySelector('.support-chat-widget');
            if (supportChat && supportChat.classList.contains('show')) {
                // Use jQuery if available (support bot uses jQuery)
                if (typeof $ !== 'undefined' && $.fn.removeClass) {
                    $('.support-chat-widget').removeClass('show');
                    $('body').removeClass('chat-modal-open');
                } else {
                    // Fallback to vanilla JS
                    supportChat.classList.remove('show');
                    document.body.classList.remove('chat-modal-open');
                }
                // Also trigger support bot's close function if available
                if (window.supportBot && typeof window.supportBot.closeChatModal === 'function') {
                    window.supportBot.closeChatModal();
                }
            }
            
            // Don't auto-focus input (like support bot behavior)
            // input.focus();
            if (window.innerWidth <= 768) {
                document.body.classList.add('ai-chat-open');
            }
            // Scroll messages to top to show first message (with small delay to ensure DOM is updated)
            setTimeout(() => {
                if (messages) {
                    messages.scrollTop = 0;
                }
            }, 50);
        }
    });
    }

    // Close chat
    close.addEventListener('click', function() {
        isOpen = false;
        chat.classList.remove('active');
        document.body.classList.remove('ai-chat-active');
        if (window.innerWidth <= 768) {
            document.body.classList.remove('ai-chat-open');
        }
    });
    
    // Close chat when clicking outside
    document.addEventListener('click', function(event) {
        // Only close if chat is open
        if (!isOpen) return;
        
        // Don't close if clicking inside the chat widget or toggle button
        const aiWidget = document.getElementById('ai-assistant-widget');
        const clickedElement = event.target;
        
        // Don't close if clicking on modals, dropdowns, or other interactive elements
        if (clickedElement.closest('.modal') || 
            clickedElement.closest('.dropdown-menu') ||
            clickedElement.closest('.select2-container') ||
            clickedElement.closest('.support-chat-widget')) {
            return;
        }
        
        // Check if click is outside the widget
        if (aiWidget && !aiWidget.contains(clickedElement)) {
            // Also check if it's not the toggle button
            if (toggle && !toggle.contains(clickedElement)) {
                isOpen = false;
                chat.classList.remove('active');
                document.body.classList.remove('ai-chat-active');
                if (window.innerWidth <= 768) {
                    document.body.classList.remove('ai-chat-open');
                }
            }
        }
    });

    // Send message
    function sendMessage() {
        const message = input.value.trim();
        if (!message) return;

        // Mark AI as interacted when user sends a message
        localStorage.setItem('ai-assistant-interacted', 'true');
        hideAISupportAlert();
        
        // Hide quick questions after user starts chatting
        const quickQuestions = document.querySelector('.ai-quick-questions');
        if (quickQuestions) {
            quickQuestions.style.display = 'none';
        }

        // Disable input and send button to prevent multiple submissions
        input.disabled = true;
        send.disabled = true;

        // Add user message
        addMessage(message, 'user');
        input.value = '';

        // Hide any existing typing indicator first
        hideTyping();

        // Show typing indicator
        showTyping();

        // Set a timeout to hide typing indicator after 10 seconds (fallback)
        const typingTimeout = setTimeout(() => {
            hideTyping();
            input.disabled = false;
            send.disabled = false;
        }, 10000);

        // Send to Enhanced AI
        fetch('/api/ai/enhanced/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ 
                message: message,
                context: {
                    page: window.location.pathname,
                    page_title: document.title,
                    current_url: window.location.href,
                    user_preferences: {},
                    page_data: getPageSpecificData()
                }
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            clearTimeout(typingTimeout); // Clear the timeout
            hideTyping();
            addMessage(data.response || '{{ __('messages.ai_generic_error') }}', 'ai');
            // Re-enable input and send button
            input.disabled = false;
            send.disabled = false;
            // input.focus();
        })
        .catch(error => {
            clearTimeout(typingTimeout); // Clear the timeout
            hideTyping();
            addMessage('{{ __('messages.ai_generic_error') }}', 'ai');
            // Re-enable input and send button
            input.disabled = false;
            send.disabled = false;
            // input.focus();
        });
    }

    // Send button click
    send.addEventListener('click', sendMessage);

    // Enter key press
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });



    // Add message to chat
    function addMessage(text, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `ai-message ${type}-message`;
        
        const avatar = document.createElement('div');
        avatar.className = 'ai-message-avatar';
        avatar.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/></svg>';
        
        const content = document.createElement('div');
        content.className = 'ai-message-content';
        content.innerHTML = `<p>${text}</p>`;
        
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(content);
        
        messages.appendChild(messageDiv);
        messages.scrollTop = messages.scrollHeight;
    }

    // Show typing indicator
    function showTyping() {
        // Remove any existing typing indicator first
        hideTyping();
        
        const typingDiv = document.createElement('div');
        typingDiv.className = 'ai-message ai-typing';
        typingDiv.id = 'typing-indicator';
        
        const avatar = document.createElement('div');
        avatar.className = 'ai-message-avatar';
        avatar.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/></svg>';
        
        const content = document.createElement('div');
        content.className = 'ai-message-content';
        content.innerHTML = '<div class="ai-typing"><div class="ai-typing-dot"></div><div class="ai-typing-dot"></div><div class="ai-typing-dot"></div></div>';
        
        typingDiv.appendChild(avatar);
        typingDiv.appendChild(content);
        
        messages.appendChild(typingDiv);
        messages.scrollTop = messages.scrollHeight;
    }

    // Hide typing indicator
    function hideTyping() {
        const typing = document.getElementById('typing-indicator');
        if (typing) {
            typing.remove();
        }
    }
    
    // Ensure first message is visible on initial load
    if (messages) {
        setTimeout(() => {
            messages.scrollTop = 0;
        }, 100);
    }
    
    // Ensure first question is visible on initial load
    const quickQuestions = document.querySelector('.ai-quick-questions');
    if (quickQuestions) {
        setTimeout(() => {
            quickQuestions.scrollTop = 0;
        }, 100);
    }
    
    // Function to close AI chat
    function closeAIChat() {
        if (isOpen) {
            isOpen = false;
            chat.classList.remove('active');
            document.body.classList.remove('ai-chat-active');
            if (window.innerWidth <= 768) {
                document.body.classList.remove('ai-chat-open');
            }
        }
    }
    
    // Make closeAIChat globally accessible so support bot can call it
    window.closeAIAssistantChat = closeAIChat;
    
    // Listen for custom event to close AI chat (from support bot)
    document.addEventListener('ai-chat-close', function() {
        closeAIChat();
    });
    
    // Also listen for jQuery event if jQuery is available
    if (typeof $ !== 'undefined') {
        $(document).on('ai-chat-close', function() {
            closeAIChat();
        });
    }
    
    // Watch for support chat opening and close AI chat
    const supportChat = document.querySelector('.support-chat-widget');
    if (supportChat) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    // Check if support chat just got the 'show' class
                    if (supportChat.classList.contains('show') && isOpen) {
                        // Support chat opened, close AI chat
                        closeAIChat();
                    }
                }
            });
        });
        
        observer.observe(supportChat, {
            attributes: true,
            attributeFilter: ['class'],
            attributeOldValue: true
        });
        
        // Also check periodically for support chat opening (fallback)
        setInterval(function() {
            if (supportChat.classList.contains('show') && isOpen) {
                closeAIChat();
            }
        }, 200);
    }
    
    // Also hook into support bot's openChatModal if available
    if (window.supportBot && typeof window.supportBot.openChatModal === 'function') {
        const originalOpenChatModal = window.supportBot.openChatModal;
        window.supportBot.openChatModal = function() {
            // Close AI chat if open
            closeAIChat();
            // Call original function
            return originalOpenChatModal.apply(this, arguments);
        };
    }
    } // End of initializeAIAssistant function
});
</script>
