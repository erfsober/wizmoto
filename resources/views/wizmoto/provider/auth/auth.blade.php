@extends('master')
@section('content')
    <!-- Main Header-->
    <header class="boxcar-header header-style-v1 style-two inner-header cus-style-1">
        <div class="header-inner">
            <div class="inner-container">
                <!-- Main box -->
                <div class="c-box">
                    <div class="logo-inner">
                        <div class="logo"><a href="{{ route("home") }}"><img src="{{asset("wizmoto/images/logo.png")}}" alt="" title="Wizmoto"></a></div>
                        @include('wizmoto.partials.live-search', ['class' => 'style1'])
                    </div>

                    <!--Nav Box-->
                    <div class="nav-out-bar">
                        <nav class="nav main-menu">
                            <ul class="navigation" id="navbar">
                                <li class="current-dropdown">
                                    <a class="box-account" href="{{route('home')}}">
                                        Home
                                    </a>
                                </li>
                                <li class="current-dropdown">
                                    <a class="box-account" href="#">
                                        Blog
                                    </a>
                                </li>
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
                            <a href="{{route("dashboard.create-advertisement")}}" class="header-btn-two btn-anim">Sell</a>
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
            <button class="close-search"><span class="fa fa-times"></span></button>

            <div class="search-inner">
                <form method="post" action="index.html">
                    <div class="form-group">
                        <input type="search" name="search-field" value="" placeholder="Search..." required="">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Header Search -->

        @include('wizmoto.partials.mobile-menu')
    </header>    <!-- End header-section -->

    <!-- login-section -->
    <section class="login-section layout-radius">
        <div class="inner-container">
            <div class="right-box">
                <div class="form-sec">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="false">Sign in</button>
                            <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="true">Register</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="form-box">
                                <form id="login-form" method="POST" action="{{ route('provider.login') }}" class="active">
                                    @csrf
                                    
                                    @if(session('toast_error') || $errors->any())
                                        <div class="alert-box error-alert">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM11 15H9V13H11V15ZM11 11H9V5H11V11Z" fill="#dc3545"/>
                                            </svg>
                                            <div class="alert-text">
                                                <strong>Login failed.</strong>
                                                <p>
                                                    {{ session('toast_error') ?? $errors->first() }}
                                                    @if(session('suggest_register'))
                                                        <span class="register-suggestion">
                                                            Don't have an account? 
                                                            <a href="#" id="switch-to-register" class="register-link">Register here</a>
                                                        </span>
                                                    @else
                                                        If the problem persists, please contact our support team.
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="form_boxes">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="" required>
                                    </div>
                                    <div class="form_boxes">
                                        <label>Password</label>
                                        <input type="password" name="password" placeholder="" required>
                                    </div>
                                    <div class="btn-box">
                                        <label class="contain">Remember
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                        <a href="{{ route('provider.password.request') }}" class="pasword-btn">Forgotten password?</a>
                                    </div>
                                    <div class="form-submit">
                                        <button type="submit" class="theme-btn">Login <img src="images/arrow.svg" alt="">
                                        </button>
                                    </div>
                                </form>
                                <div class="btn-box-two">
                                    <span>OR</span>
                                    <div class="social-btns">
                                        <a href="{{route("provider.auth.apple") }}" class="fb-btn"><i class="fa-brands fa-apple"></i>Continue Apple</a>
                                        <a href="{{ route("provider.auth.google") }}" class="fb-btn two"><i class="fa-brands fa-google"></i>Continue Google</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="form-box two">
                                <form id="register-form" method="POST" action="{{ route('provider.register') }}">
                                    @csrf
                                    
                                    @if($errors->any() && !session('toast_error'))
                                        <div class="alert-box error-alert">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM11 15H9V13H11V15ZM11 11H9V5H11V11Z" fill="#dc3545"/>
                                            </svg>
                                            <div class="alert-text">
                                                <strong>Registration failed.</strong>
                                                <p>{{ $errors->first() }} Please check your information and try again.</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="form_boxes">
                                        <label>Username</label>
                                        <input type="text" name="username" value="{{ old('username') }}" placeholder="" required>
                                    </div>
                                    <div class="form_boxes">
                                        <label>Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="" required>
                                    </div>
                                    <div class="form_boxes">
                                        <label>Password</label>
                                        <input type="password" name="password" placeholder="" required>
                                    </div>
                                    <div class="form-submit">
                                        <button type="submit" class="theme-btn">Register <img src="images/arrow.svg" alt="">
                                        </button>
                                    </div>
                                    <div class="btn-box">
                                        <label class="contain">I accept the privacy policy
                                            <input type="checkbox" checked="checked"  name="privacy_policy">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </form>
                                <div class="btn-box-two">
                                    <span>OR</span>
                                    <div class="social-btns">
                                        <a href="{{route("provider.auth.apple") }}" class="fb-btn"><i class="fa-brands fa-apple"></i>Continue Apple</a>
                                        <a href="{{ route("provider.auth.google") }}" class="fb-btn two"><i class="fa-brands fa-google"></i>Continue Google</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End login-section -->

    @include('wizmoto.partials.footer')

@endsection

@push('scripts')
    <script>
        // Auto-switch to correct tab when there are errors
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there are errors and which form they're for
            @if(session('toast_error') || ($errors->any() && old('email') && !old('username')))
                // Login errors - show login tab
                const loginTab = document.getElementById('nav-home-tab');
                const loginPane = document.getElementById('nav-home');
                const registerTab = document.getElementById('nav-profile-tab');
                const registerPane = document.getElementById('nav-profile');
                
                if (loginTab && loginPane) {
                    // Activate login tab
                    loginTab.classList.add('active');
                    loginPane.classList.add('show', 'active');
                    // Deactivate register tab
                    registerTab.classList.remove('active');
                    registerPane.classList.remove('show', 'active');
                }
            @elseif($errors->any() && old('username'))
                // Register errors - show register tab (already default, but ensure it)
                const registerTab = document.getElementById('nav-profile-tab');
                const registerPane = document.getElementById('nav-profile');
                const loginTab = document.getElementById('nav-home-tab');
                const loginPane = document.getElementById('nav-home');
                
                if (registerTab && registerPane) {
                    // Activate register tab
                    registerTab.classList.add('active');
                    registerPane.classList.add('show', 'active');
                    // Deactivate login tab
                    loginTab.classList.remove('active');
                    loginPane.classList.remove('show', 'active');
                }
            @endif

            // Handle "Register here" link click
            const switchToRegisterLink = document.getElementById('switch-to-register');
            if (switchToRegisterLink) {
                switchToRegisterLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Get the email from login form and transfer to register form
                    const loginEmail = document.querySelector('#login-form input[name="email"]').value;
                    const registerEmail = document.querySelector('#register-form input[name="email"]');
                    if (registerEmail && loginEmail) {
                        registerEmail.value = loginEmail;
                    }
                    
                    // Switch to register tab
                    const registerTab = document.getElementById('nav-profile-tab');
                    if (registerTab) {
                        registerTab.click();
                        
                        // Focus on username field
                        setTimeout(function() {
                            const usernameInput = document.querySelector('#register-form input[name="username"]');
                            if (usernameInput) {
                                usernameInput.focus();
                            }
                        }, 100);
                    }
                });
            }
        });

        // Success toast notifications only (like Autoscout24 style)
        @if(session('toast_success'))
            Swal.fire({
                toast: true,
                icon: 'success',
                title: '{{ session('toast_success') }}',
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: 'colored-toast'
                }
            });
        @endif

        @if(session('status'))
            Swal.fire({
                toast: true,
                icon: 'success',
                title: '{{ session('status') }}',
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: 'colored-toast'
                }
            });
        @endif
    </script>
    <style>
        /* Autoscout24-style inline error alerts */
        .alert-box {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            background-color: #fff5f5;
            border: 1px solid #feb2b2;
        }

        .alert-box.error-alert svg {
            flex-shrink: 0;
            margin-top: 2px;
        }

        .alert-text {
            flex: 1;
        }

        .alert-text strong {
            display: block;
            color: #c53030;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .alert-text p {
            color: #742a2a;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
        }

        .register-suggestion {
            display: block;
            margin-top: 8px;
            font-weight: 500;
        }

        .register-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .register-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Success toast styling */
        .colored-toast.swal2-icon-success {
            background-color: #28a745 !important;
        }

        .colored-toast .swal2-title {
            color: white;
            font-size: 15px;
        }

        .colored-toast .swal2-icon {
            border-color: white;
            color: white;
        }
    </style>
@endpush
