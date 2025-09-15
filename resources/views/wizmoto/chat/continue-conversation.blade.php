@extends('master')
@section('content')
<!-- Main Header-->
<header class="boxcar-header header-style-v1 style-two inner-header cus-style-1">
    <div class="header-inner">
        <div class="inner-container">
            <!-- Main box -->
            <div class="c-box">
                <div class="logo-inner">
                    <div class="logo">
                        <a href="{{ route("home") }}">
                            <img src="{{asset("wizmoto/images/logo.png")}}" alt="" title="Boxcar">
                        </a>
                    </div>
                    <div class="layout-search style1">
                        <form action="{{ route('inventory.list') }}" method="GET">
                            <div class="search-box">
                                <svg class="icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.29301 1.2876C3.9872 1.2876 1.29431 3.98048 1.29431 7.28631C1.29431 10.5921 3.9872 13.2902 7.29301 13.2902C8.70502 13.2902 10.0036 12.7954 11.03 11.9738L13.5287 14.4712C13.6548 14.5921 13.8232 14.6588 13.9979 14.657C14.1725 14.6552 14.3395 14.5851 14.4631 14.4617C14.5867 14.3382 14.6571 14.1713 14.6591 13.9967C14.6611 13.822 14.5947 13.6535 14.474 13.5272L11.9753 11.0285C12.7976 10.0006 13.293 8.69995 13.293 7.28631C13.293 3.98048 10.5988 1.2876 7.29301 1.2876ZM7.29301 2.62095C9.87824 2.62095 11.9584 4.70108 11.9584 7.28631C11.9584 9.87153 9.87824 11.9569 7.29301 11.9569C4.70778 11.9569 2.62764 9.87153 2.62764 7.28631C2.62764 4.70108 4.70778 2.62095 7.29301 2.62095Z" fill="white"/>
                                </svg>
                                <input type="search" placeholder="Search Scooters, Motorbikes, Bikes..." class="show-search" name="search" tabindex="2" value="" aria-required="true" required="">
                            </div>
                        </form>
                    </div>
                </div>

                <!--Nav Box-->
                <div class="nav-out-bar">
                    <nav class="nav main-menu">
                        <ul class="navigation" id="navbar">
                            <li class="current-dropdown current">
                                <a class="box-account" href="{{route('home')}}">
                                    Home
                                </a>
                            </li>
                            <li class="current-dropdown">
                                <a class="box-account" href="{{route("blogs.index")}}">
                                    Blog
                                </a>
                            </li>
                            @if(Auth::guard('provider')->check())
                                <li class="current-dropdown">
                                    <span>
                                        {{ Auth::guard('provider')->user()->username }}
                                        <i class="fa-solid fa-angle-down"></i>
                                    </span>
                                    <ul class="dropdown">
                                        <li>
                                            <a href="{{ route('dashboard.profile') }}">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('provider.logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <form id="logout-form" action="{{ route('provider.logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endif
                        </ul>
                    </nav>
                    <!-- Main Menu End-->
                </div>

                <div class="right-box">
                    @if(!Auth::guard('provider')->check())
                        <a href="{{ route('provider.auth') }}" title="" class="box-account">
                            <div class="icon">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_147_6490)">
                                        <path d="M7.99998 9.01221C3.19258 9.01221 0.544983 11.2865 0.544983 15.4161C0.544983 15.7386 0.806389 16.0001 1.12892 16.0001H14.871C15.1935 16.0001 15.455 15.7386 15.455 15.4161C15.455 11.2867 12.8074 9.01221 7.99998 9.01221ZM1.73411 14.8322C1.9638 11.7445 4.06889 10.1801 7.99998 10.1801C11.9311 10.1801 14.0362 11.7445 14.2661 14.8322H1.73411Z" fill="white"/>
                                        <path d="M7.99999 0C5.79171 0 4.12653 1.69869 4.12653 3.95116C4.12653 6.26959 5.86415 8.15553 7.99999 8.15553C10.1358 8.15553 11.8735 6.26959 11.8735 3.95134C11.8735 1.69869 10.2083 0 7.99999 0ZM7.99999 6.98784C6.50803 6.98784 5.2944 5.62569 5.2944 3.95134C5.2944 2.3385 6.43231 1.16788 7.99999 1.16788C9.54259 1.16788 10.7056 2.36438 10.7056 3.95134C10.7056 5.62569 9.49196 6.98784 7.99999 6.98784Z" fill="white"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_147_6490">
                                            <rect width="16" height="16" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            Sign in
                        </a>
                    @endif
                    <div class="btn">
                        <a href="{{route("dashboard.create-advertisement")}}" class="header-btn-two btn-anim">Add Listing</a>
                    </div>
                    <div class="mobile-navigation">
                        <a href="#nav-mobile" title="">
                            <svg width="22" height="11" viewBox="0 0 22 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="22" height="2" fill="white"/>
                                <rect y="9" width="22" height="2" fill="white"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu  -->
        </div>
    </div>

    <!-- Header Search -->
    <div class="search-popup">
        <span class="search-back-drop"></span>
        <button class="close-search">
            <span class="fa fa-times"></span></button>

        <div class="search-inner">
            <form method="post" action="index.html">
                <div class="form-group">
                    <input type="search" name="search-field" value="" placeholder="Search..." required="">
                    <button type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Header Search -->

    <div id="nav-mobile"></div>
</header>
<!-- End header-section -->

<!-- blog section -->
<section class="blog-section v1 layout-radius">
    <div class="boxcar-container">
        <div class="boxcar-title wow fadeInUp">
            <ul class="breadcrumb">
                <li><a href="{{route('home')}}">Home</a></li>
                <li><span>Continue Conversation</span></li>
            </ul>
            <h2>Continue Your Conversation</h2>
        </div>
        <nav class="wow fadeInUp" data-wow-delay="100ms">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Chat with {{ $provider->full_name }}</button>
          </div>
        </nav>
        <div class="tab-content wow fadeInUp" data-wow-delay="200ms" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row">
                    <div class="content-column">
                        <div class="inner-column">
                            <div class="list-title">
                                <h3 class="title">Messages</h3>
                            </div>
                            <div class="chat-widget">
                                <div class="widget-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card message-card">
                                                <div class="card-header msg_head">
                                                    <div class="d-flex bd-highlight">
                                                        <div class="img_cont">
                                                            <div class="rounded-circle user_img bg-primary text-white d-flex align-items-center justify-content-center"
                                                                style="width: 40px; height: 40px; font-size: 18px;">
                                                                {{ strtoupper(substr($provider->full_name, 0, 1)) }}
                                                            </div>
                                                        </div>
                                                        <div class="user_info">
                                                            <span>{{ $provider->full_name }}</span>
                                                            <p>{{ $provider->email }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body msg_card_body" id="chat-messages" style="height: 400px; overflow-y: auto;">
                                                    <!-- Messages will be loaded here -->
                                                </div>

                                                <div class="card-footer">
                                                    <div class="form-group mb-0">
                                                        <textarea class="form-control type_msg" id="message-input" placeholder="Type a message..." rows="2"></textarea>
                                                        <button type="button" class="theme-btn btn-style-one submit-btn" id="send-message">
                                                            <span class="text-dk">Send Message</span>
                                                            <span class="text-mb">Send</span>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                                                                <g clip-path="url(#clip0_601_692)">
                                                                    <path d="M13.6109 0H5.05533C4.84037 0 4.66643 0.173943 4.66643 0.388901C4.66643 0.603859 4.84037 0.777802 5.05533 0.777802H12.6721L0.113697 13.3362C-0.0382246 13.4881 -0.0382246 13.7342 0.113697 13.8861C0.18964 13.962 0.289171 14 0.388666 14C0.488161 14 0.587656 13.962 0.663635 13.8861L13.222 1.3277V8.94447C13.222 9.15943 13.3959 9.33337 13.6109 9.33337C13.8259 9.33337 13.9998 9.15943 13.9998 8.94447V0.388901C13.9998 0.173943 13.8258 0 13.6109 0Z" fill="white"></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_601_692">
                                                                        <rect width="14" height="14" fill="white"></rect>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('wizmoto.partials.footer')
@endsection

@push('scripts')
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
        container.innerHTML = '<div class="text-center py-4"><p class="text-muted">No messages yet. Start the conversation!</p></div>';
        return;
    }

    messages.forEach(msg => {
        const isGuest = msg.sender_type === 'guest';
        const wrapperClass = isGuest ? 'justify-content-end reply' : 'justify-content-start';
        const senderInitial = isGuest ? 'You' : '{{ strtoupper(substr($provider->full_name, 0, 1)) }}';
        const senderName = isGuest ? 'You' : '{{ $provider->full_name }}';
        const timeFormatted = formatMessageTime(msg.created_at);

        const messageDiv = document.createElement('div');
        messageDiv.className = `d-flex ${wrapperClass} mb-2`;
        
        messageDiv.innerHTML = `
            <div class="img_cont_msg">
                <img src="${isGuest ? 'wizmoto/images/resource/candidate-6.png' : 'wizmoto/images/resource/candidate-3.png'}" alt="" class="rounded-circle user_img_msg">
                <div class="name">${senderName} <span class="msg_time">${timeFormatted}</span></div>
            </div>
            <div class="msg_cotainer">
                ${escapeHtml(msg.message)}
            </div>
        `;

        container.appendChild(messageDiv);
    });

    container.scrollTop = container.scrollHeight;
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

// Send message
document.getElementById('send-message').addEventListener('click', function() {
    sendMessage();
});

document.getElementById('message-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
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
    sendBtn.querySelector('.text-dk').textContent = 'Sending...';

    // Add sending indicator
    const sendingIndicator = document.createElement('div');
    sendingIndicator.className = 'd-flex justify-content-end mb-2';
    sendingIndicator.innerHTML = '<div class="msg_cotainer sending">Sending...</div>';
    document.getElementById('chat-messages').appendChild(sendingIndicator);

    scrollToBottom();

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
            sendingIndicator.remove();
            loadMessages();
        } else {
            sendingIndicator.remove();
            alert('Error: ' + Object.values(data.errors).join(', '));
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
        sendingIndicator.remove();
        alert('Error sending message. Please try again.');
    })
    .finally(() => {
        // Re-enable send button
        sendBtn.disabled = false;
        sendBtn.querySelector('.text-dk').textContent = 'Send Message';
    });
}

function scrollToBottom() {
    const chatMessages = document.getElementById('chat-messages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
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
@endpush
@endsection
