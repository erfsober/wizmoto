<h2>New Message from {{ $guest->name }}</h2>

<p><strong>About:</strong> {{ $advertisement->title ?? 'General Inquiry' }}</p>

<div style="background: #f8f9fa; padding: 15px; border-left: 4px solid #007bff;">
    <p><strong>Message:</strong></p>
    <p>{{ $message->message }}</p>
</div>

<h3>Contact Details:</h3>
<ul>
    <li><strong>Name:</strong> {{ $guest->name }}</li>
    <li><strong>Email:</strong> {{ $guest->email }}</li>
    @if($guest->phone)
        <li><strong>Phone:</strong> {{ $guest->phone }}</li>
    @endif
</ul>

<p>
    <a href="{{ route('dashboard.messages') }}" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none;">
        Reply via Dashboard
    </a>
</p>
<footer style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-top: 1px solid #ddd;">
    <p style="color: #666; font-size: 12px;">
        This email was sent by Wizmoto Marketplace.<br>
        To manage your email preferences, visit your account settings.<br>
        © 2024 Wizmoto. All rights reserved.
    </p>
</footer>