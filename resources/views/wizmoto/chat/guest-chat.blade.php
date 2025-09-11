@extends('wizmoto.partials.head')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Chat with {{ $provider->full_name }}</h4>
                    <small class="text-muted">{{ $provider->email }}</small>
                </div>
                <div class="card-body">
                    <!-- Chat Messages Container -->
                    <div id="chat-messages" class="chat-messages mb-3" style="height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 15px;">
                        <!-- Messages will be loaded here -->
                    </div>

                    <!-- Guest Info Form (shown initially) -->
                    <div id="guest-form" class="mb-3">
                        <h5>Contact {{ $provider->full_name }}</h5>
                        <form id="initiate-chat-form">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form_boxes">
                                        <label>Your Name *</label>
                                        <input type="text" id="guest-name" placeholder="" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form_boxes">
                                        <label>Your Email *</label>
                                        <input type="email" id="guest-email" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form_boxes">
                                        <label>Phone (Optional)</label>
                                        <input type="tel" id="guest-phone" placeholder="+39 123 456 7890">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form_boxes v2">
                                        <label>Message *</label>
                                        <textarea id="initial-message" placeholder="Write your message..." required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-submit">
                                <button type="submit" class="theme-btn">Send Message</button>
                            </div>
                        </form>
                    </div>

                    <!-- Chat Form (shown after initial contact) -->
                    <div id="chat-form" class="d-none">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form_boxes">
                                    <input type="text" id="message-input" placeholder="Type your message...">
                                </div>
                            </div>
                        </div>
                        <div class="form-submit">
                            <button class="theme-btn" id="send-message">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let guestToken = null;
let providerId = {{ $provider->id }};

// Initialize chat form
document.getElementById('initiate-chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('guest-name').value;
    const email = document.getElementById('guest-email').value;
    const message = document.getElementById('initial-message').value;

    fetch('/chat/initiate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            provider_id: providerId,
            name: name,
            email: email,
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            guestToken = data.guest_token;
            document.getElementById('guest-form').classList.add('d-none');
            document.getElementById('chat-form').classList.remove('d-none');
            loadMessages();
            
            // Store token in localStorage for future visits
            localStorage.setItem('guest_token_' + providerId, guestToken);
        } else {
            alert('Error: ' + Object.values(data.errors).join(', '));
        }
    });
});

// Send message
document.getElementById('send-message').addEventListener('click', function() {
    sendMessage();
});

document.getElementById('message-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

function sendMessage() {
    const message = document.getElementById('message-input').value.trim();
    if (!message || !guestToken) return;

    fetch('/chat/guest/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            provider_id: providerId,
            message: message,
            guest_token: guestToken
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message-input').value = '';
            loadMessages();
        }
    });
}

function loadMessages() {
    if (!guestToken) return;

    fetch(`/chat/guest/messages?provider_id=${providerId}&guest_token=${guestToken}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayMessages(data.messages);
            }
        });
}

function displayMessages(messages) {
    const container = document.getElementById('chat-messages');
    container.innerHTML = '';

    messages.forEach(msg => {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message mb-2 ${msg.sender_type === 'guest' ? 'text-end' : 'text-start'}`;
        
        const senderName = msg.sender_type === 'guest' ? msg.guest.name : msg.provider.full_name;
        const messageClass = msg.sender_type === 'guest' ? 'bg-primary text-white' : 'bg-light';
        
        messageDiv.innerHTML = `
            <div class="d-inline-block p-2 rounded ${messageClass}" style="max-width: 70%;">
                <strong>${senderName}:</strong><br>
                ${msg.message}
                <br><small class="text-muted">${new Date(msg.created_at).toLocaleString()}</small>
            </div>
        `;
        
        container.appendChild(messageDiv);
    });

    container.scrollTop = container.scrollHeight;
}

// Check if guest already has a token for this provider
window.addEventListener('load', function() {
    const savedToken = localStorage.getItem('guest_token_' + providerId);
    if (savedToken) {
        guestToken = savedToken;
        document.getElementById('guest-form').classList.add('d-none');
        document.getElementById('chat-form').classList.remove('d-none');
        loadMessages();
    }
});

// Auto-refresh messages every 5 seconds
setInterval(function() {
    if (guestToken) {
        loadMessages();
    }
}, 5000);
</script>
@endsection
