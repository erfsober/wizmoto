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
                <h4>Super AI</h4>
                <span class="ai-status">Online</span>
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
                    <p>Hi! I'm your virtual assistant 🤖</p>
                    <p>I'll help you find the perfect vehicle, answer questions about our platform, and assist with any inquiries you might have.</p>
                    <p>What can I help you with today?</p>
                </div>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="ai-assistant-input-container">
            <div class="ai-assistant-input-wrapper">
                <input type="text" id="ai-assistant-input" placeholder="Ask me anything about vehicles..." maxlength="500">
                <button id="ai-assistant-send" class="ai-assistant-send">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" fill="currentColor"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* AI Assistant Widget Styles */
.ai-assistant-widget {
    position: fixed;
    bottom: 90px;
    right: 20px;
    z-index: 9998;
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
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
    display: none;
    flex-direction: column;
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.08);
}

.ai-assistant-chat.active {
    display: flex;
    animation: ai-slide-up 0.3s ease;
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
    padding: 16px 20px;
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
    font-size: 16px;
    font-weight: 600;
}

.ai-status {
    font-size: 12px;
    opacity: 0.8;
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
    padding: 20px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.ai-message {
    display: flex;
    gap: 12px;
    align-items: flex-start;
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
    background: #f8f9fa;
    padding: 12px 16px;
    border-radius: 18px;
    max-width: 80%;
    font-size: 14px;
    line-height: 1.4;
}

.ai-message-content p {
    margin: 0 0 8px 0;
}

.ai-message-content p:last-child {
    margin-bottom: 0;
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
    padding: 16px 20px;
    border-top: 1px solid #e9ecef;
    background: #f8f9fa;
}

.ai-assistant-input-wrapper {
    display: flex;
    gap: 8px;
    margin-bottom: 12px;
}

.ai-assistant-input-wrapper input {
    flex: 1;
    padding: 12px 16px;
    border: 1px solid #e9ecef;
    border-radius: 24px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
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
    .ai-assistant-widget {
        bottom: 75px;
        right: 15px;
    }
    
    .ai-assistant-chat {
        width: calc(100vw - 30px);
        height: calc(100vh - 100px);
        bottom: 145px;
        right: 0;
        margin: 0 auto;
    }
    
    .ai-assistant-toggle {
        width: 50px;
        height: 50px;
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
    console.log('AI Assistant Widget loaded!');
    
    const toggle = document.getElementById('ai-assistant-toggle');
    const chat = document.getElementById('ai-assistant-chat');
    const close = document.getElementById('ai-assistant-close');
    const input = document.getElementById('ai-assistant-input');
    const send = document.getElementById('ai-assistant-send');
    const messages = document.getElementById('ai-assistant-messages');

    console.log('AI Assistant elements found:', {
        toggle: !!toggle,
        chat: !!chat,
        close: !!close,
        input: !!input,
        send: !!send,
        messages: !!messages
    });

    let isOpen = false;

    // Toggle chat
    toggle.addEventListener('click', function() {
        isOpen = !isOpen;
        chat.classList.toggle('active', isOpen);
        if (isOpen) {
            input.focus();
        }
    });

    // Close chat
    close.addEventListener('click', function() {
        isOpen = false;
        chat.classList.remove('active');
    });

    // Send message
    function sendMessage() {
        const message = input.value.trim();
        if (!message) return;

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
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('AI Response:', data);
            clearTimeout(typingTimeout); // Clear the timeout
            hideTyping();
            addMessage(data.response || 'Sorry, I encountered an error. Please try again.', 'ai');
            // Re-enable input and send button
            input.disabled = false;
            send.disabled = false;
            input.focus();
        })
        .catch(error => {
            console.error('AI Assistant Error:', error);
            clearTimeout(typingTimeout); // Clear the timeout
            hideTyping();
            addMessage('Sorry, I encountered an error. Please try again.', 'ai');
            // Re-enable input and send button
            input.disabled = false;
            send.disabled = false;
            input.focus();
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
        console.log('Showing typing indicator');
        
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
            console.log('Hiding typing indicator');
            typing.remove();
        } else {
            console.log('No typing indicator found to hide');
        }
    }
});
</script>
