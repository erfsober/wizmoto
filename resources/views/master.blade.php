<!DOCTYPE html>
<html lang="en">
@include('wizmoto.partials.head')
@stack('styles')
<body class="@yield('body-class')">

<div class="boxcar-wrapper @yield('main-div')">
    @yield('content')
</div>

<!-- Support Bot Widget -->
<div id="support-bot" class="support-bot">
    <div class="support-bot-toggle" id="support-bot-toggle">
        <i class="fas fa-comments"></i>
        <span class="support-bot-badge" id="support-bot-badge">1</span>
    </div>
    <div class="support-bot-panel" id="support-bot-panel">
        <div class="support-bot-header">
            <h4>Need Help?</h4>
            <button class="support-bot-close" id="support-bot-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="support-bot-content">
            <p>How can we help you today?</p>
            <div class="support-bot-options">
                <button class="support-option" data-action="whatsapp">
                    <i class="fab fa-whatsapp"></i>
                    <span>WhatsApp Chat</span>
                </button>
                <button class="support-option" data-action="internal-chat">
                    <i class="fas fa-comments"></i>
                    <span>Live Support Chat</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Chat Widget -->
<div id="chat-widget" class="support-chat-widget">
    <div class="support-chat-widget-content">
        <div class="support-chat-widget-header">
            <div class="chat-header-info">
                <div class="chat-avatar">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="chat-header-text">
                    <h4>Live Support</h4>
                    <span class="chat-status">Online</span>
                </div>
            </div>
            <button class="support-chat-widget-close" id="chat-widget-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="support-chat-widget-body">
            <div class="chat-messages" id="chat-messages">
                <div class="no-messages">
                    <p>Start a conversation with our support team!</p>
                </div>
            </div>
            
            <div class="typing-indicator" id="typing-indicator">
                <span>Support is typing...</span>
            </div>
        </div>
        
        <div class="support-chat-widget-footer">
            <form id="chat-message-form">
                @csrf
                <input type="hidden" name="conversation_id" id="chat-conversation-id">
                <div class="chat-input-group">
                    <input 
                        type="text" 
                        name="message" 
                        class="chat-message-input" 
                        placeholder="Type your message here..."
                        id="chat-message-input"
                        required
                    >
                    <button type="submit" class="chat-send-button" id="chat-send-button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- AI Assistant Widget -->
@include('wizmoto.widgets.ai-assistant')

@stack('before-scripts')
@include('wizmoto.partials.scripts')
@stack('scripts')
</body>
