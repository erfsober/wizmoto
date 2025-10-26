<!-- AI Support Welcome Alert -->
<div id="ai-support-alert" class="ai-support-alert">
    <div class="ai-support-alert-content">
        <div class="ai-support-alert-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" fill="currentColor"/>
            </svg>
        </div>
        <div class="ai-support-alert-text">
            <h4>🤖 AI Support Available!</h4>
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
            
            <!-- Quick Questions -->
            <div class="ai-quick-questions">
                <div class="ai-question-item" data-question="How do I search for vehicles?">
                    <span>🔍 How do I search for vehicles?</span>
                </div>
                <div class="ai-question-item" data-question="What are the pricing options?">
                    <span>💰 What are the pricing options?</span>
                </div>
                <div class="ai-question-item" data-question="How do I contact a seller?">
                    <span>📞 How do I contact a seller?</span>
                </div>
                <div class="ai-question-item" data-question="How do I list my vehicle?">
                    <span>📝 How do I list my vehicle?</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* AI Support Alert Styles */
.ai-support-alert {
    position: absolute;
    bottom: 80px;
    right: 0;
    z-index: 10000;
    max-width: 300px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.ai-support-alert.show {
    transform: translateY(0);
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

/* AI Quick Questions Styles */
.ai-quick-questions {
    padding: 12px 0 0 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-top: 8px;
}

.ai-question-item {
    background: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 8px 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 12px;
    font-weight: 500;
    color: #495057;
    display: flex;
    align-items: center;
    margin: 0;
    width: 100%;
    box-sizing: border-box;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
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
    .ai-support-alert {
        bottom: 70px;
        right: 0;
        left: 0;
        max-width: none;
        margin: 0 15px;
    }
    
    .ai-support-alert-content {
        padding: 14px 16px;
    }
    
    .ai-support-alert-text h4 {
        font-size: 13px;
    }
    
    .ai-support-alert-text p {
        font-size: 11px;
    }
    
    .ai-quick-questions {
        padding: 10px 0 0 0;
        gap: 4px;
    }
    
    .ai-question-item {
        font-size: 11px;
        padding: 6px 10px;
    }
    
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
            aiAlert.style.transform = 'translateY(0)';
            aiAlert.style.position = 'fixed';
            // Responsive positioning
            if (window.innerWidth <= 768) {
                aiAlert.style.bottom = '140px'; // Closer to button on mobile
                aiAlert.style.right = '15px';
                aiAlert.style.left = '15px';
                aiAlert.style.maxWidth = 'none';
            } else {
                aiAlert.style.bottom = '160px'; // Position above the AI assistant button
                aiAlert.style.right = '20px';
            }
            aiAlert.style.zIndex = '10000';
            aiAlert.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
            aiAlert.style.color = 'white';
            aiAlert.style.padding = '0';
            aiAlert.style.borderRadius = '12px';
            aiAlert.style.boxShadow = '0 8px 32px rgba(102, 126, 234, 0.3)';
            aiAlert.style.maxWidth = '320px';
            aiAlert.style.minWidth = '280px';
            aiAlert.style.fontFamily = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
            
            // Make sure the content is visible
            const alertContent = aiAlert.querySelector('.ai-support-alert-content');
            if (alertContent) {
                alertContent.style.display = 'flex';
                alertContent.style.alignItems = 'center';
                alertContent.style.gap = '12px';
                alertContent.style.padding = '16px 20px';
                alertContent.style.position = 'relative';
                console.log('✅ Alert content found and styled');
                
                // Style the text elements
                const alertText = alertContent.querySelector('.ai-support-alert-text');
                if (alertText) {
                    alertText.style.flex = '1';
                    alertText.style.minWidth = '0';
                    alertText.style.paddingRight = '30px'; // Make space for close button
                }
                
                const alertTitle = alertContent.querySelector('h4');
                if (alertTitle) {
                    alertTitle.style.margin = '0 0 4px 0';
                    alertTitle.style.fontSize = '14px';
                    alertTitle.style.fontWeight = '600';
                    alertTitle.style.lineHeight = '1.2';
                }
                
                
                // Style the icon
                const alertIcon = alertContent.querySelector('.ai-support-alert-icon');
                if (alertIcon) {
                    alertIcon.style.width = '32px';
                    alertIcon.style.height = '32px';
                    alertIcon.style.background = 'rgba(255, 255, 255, 0.2)';
                    alertIcon.style.borderRadius = '50%';
                    alertIcon.style.display = 'flex';
                    alertIcon.style.alignItems = 'center';
                    alertIcon.style.justifyContent = 'center';
                    alertIcon.style.flexShrink = '0';
                }
                
                // Style the close button
                const closeBtn = alertContent.querySelector('.ai-support-alert-close');
                if (closeBtn) {
                    closeBtn.style.position = 'absolute';
                    closeBtn.style.top = '6px';
                    closeBtn.style.right = '6px';
                    closeBtn.style.background = 'none';
                    closeBtn.style.border = 'none';
                    closeBtn.style.color = 'white';
                    closeBtn.style.cursor = 'pointer';
                    closeBtn.style.padding = '6px';
                    closeBtn.style.borderRadius = '4px';
                    closeBtn.style.opacity = '0.8';
                    closeBtn.style.width = '24px';
                    closeBtn.style.height = '24px';
                    closeBtn.style.display = 'flex';
                    closeBtn.style.alignItems = 'center';
                    closeBtn.style.justifyContent = 'center';
                    closeBtn.style.transition = 'all 0.2s ease';
                    
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
            
            // Hide after 5 seconds
            setTimeout(() => {
                aiAlert.style.display = 'none';
            }, 5000);
        } else {
            // Create a simple fallback alert
            const fallbackAlert = document.createElement('div');
            fallbackAlert.innerHTML = '🤖 AI Support Available!';
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
                        input.focus();
                        
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
        if (isOpen) {
            input.focus();
        }
    });
    }

    // Close chat
    close.addEventListener('click', function() {
        isOpen = false;
        chat.classList.remove('active');
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
            addMessage(data.response || 'Sorry, I encountered an error. Please try again.', 'ai');
            // Re-enable input and send button
            input.disabled = false;
            send.disabled = false;
            input.focus();
        })
        .catch(error => {
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
    } // End of initializeAIAssistant function
});
</script>
