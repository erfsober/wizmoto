@extends('wizmoto.partials.head')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4>💬 Continue Your Conversation</h4>
                    <p class="mb-0">Chat with {{ $provider->full_name }}</p>
                </div>
                <div class="card-body">
                    <!-- Chat Messages Container -->
                    <div id="chat-messages" class="chat-messages mb-3" style="height: 400px; overflow-y: auto; border: 1px solid #ddd; padding: 15px;">
                        <!-- Messages will be loaded here -->
                    </div>

                    <!-- Chat Form -->
                    <div id="chat-form">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form_boxes">
                                    <input type="text" id="message-input" placeholder="Type your message..." maxlength="1000">
                                </div>
                            </div>
                        </div>
                        <div class="form-submit">
                            <button class="theme-btn" id="send-message">
                                <i class="fa fa-paper-plane"></i> Send
                            </button>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            💡 Your email is kept private. <button class="btn btn-link btn-sm p-0" id="share-contact">Share your contact details</button>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let guestEmail = '{{ $guest->email }}';
let providerId = {{ $provider->id }};
let guestId = {{ $guest->id }};

// Load conversation messages on page load
window.addEventListener('load', function() {
    loadMessages();
});

// Load messages
function loadMessages() {
    fetch(`/chat/guest/messages?provider_id=${providerId}&guest_email=${encodeURIComponent(guestEmail)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayMessages(data.messages);
            }
        })
        .catch(error => {
            console.error('Error loading messages:', error);
        });
}

function displayMessages(messages) {
    const container = document.getElementById('chat-messages');
    container.innerHTML = '';

    if (messages.length === 0) {
        container.innerHTML = '<p class="text-center text-muted mt-5">No messages yet. Start the conversation!</p>';
        return;
    }

    messages.forEach(msg => {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message mb-3 ${msg.sender_type === 'guest' ? 'text-end' : 'text-start'}`;

        let senderName, messageClass;
        if (msg.sender_type === 'guest') {
            senderName = 'You';
            messageClass = 'bg-primary text-white';
        } else if (msg.sender_type === 'provider') {
            senderName = msg.provider.full_name;
            messageClass = 'bg-light';
        } else {
            senderName = 'System';
            messageClass = 'bg-warning text-dark';
        }

        messageDiv.innerHTML = `
            <div class="d-inline-block p-3 rounded ${messageClass}" style="max-width: 70%;">
                <strong>${senderName}:</strong><br>
                ${msg.message}
                <br><small class="text-muted">${new Date(msg.created_at).toLocaleString()}</small>
            </div>
        `;

        container.appendChild(messageDiv);
    });

    container.scrollTop = container.scrollHeight;
}

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
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();
    if (!message) return;

    // Disable send button
    const sendBtn = document.getElementById('send-message');
    sendBtn.disabled = true;
    sendBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

    fetch('/chat/guest/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            provider_id: providerId,
            message: message,
            guest_email: guestEmail
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            messageInput.value = '';
            loadMessages();
        } else {
            alert('Error: ' + Object.values(data.errors).join(', '));
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        alert('Error sending message. Please try again.');
    })
    .finally(() => {
        // Re-enable send button
        sendBtn.disabled = false;
        sendBtn.innerHTML = '<i class="fa fa-paper-plane"></i> Send';
    });
}

// Share contact details
document.getElementById('share-contact').addEventListener('click', function() {
    if (confirm('Share your contact details with the dealer? This will reveal your email and phone number.')) {
        fetch('/chat/guest/share-email', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                provider_id: providerId,
                guest_email: guestEmail
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Contact details shared successfully!');
                loadMessages();
            } else {
                alert('Error sharing contact details');
            }
        });
    }
});

// Auto-refresh messages every 10 seconds
setInterval(function() {
    loadMessages();
}, 10000);
</script>
@endsection
