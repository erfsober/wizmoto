<h2>Reply from {{ $provider->full_name }}</h2>

<p><strong>Regarding:</strong> {{ $advertisement->title ?? 'Your Inquiry' }}</p>

<div style="background: #f8f9fa; padding: 15px; border-left: 4px solid #28a745;">
    <p><strong>{{ $provider->full_name }} replied:</strong></p>
    <p>{{ $providerMessage->message }}</p>
</div>

<h3>Dealer Contact:</h3>
<ul>
    <li><strong>Name:</strong> {{ $provider->full_name }}</li>
    <li><strong>Email:</strong> {{ $provider->email }}</li>
    @if($provider->phone)
        <li><strong>Phone:</strong> {{ $provider->phone }}</li>
    @endif
</ul>

<p>
    <a href="{{ $conversationLink }}" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none;">
        Continue Conversation
    </a>
</p>

<footer style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-top: 1px solid #ddd;">
    <p style="color: #666; font-size: 12px;">
        This email was sent by Wizmoto Marketplace.<br>
        To manage your email preferences, visit your account settings.<br>
        © 2024 Wizmoto. All rights reserved.
    </p>
</footer>