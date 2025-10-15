<div id="nav-mobile">
    <ul>
        <!-- Home Link -->
        <li>
            <a href="{{ route('home') }}">
                <i class="fa fa-home"></i> Home
            </a>
        </li>
        
        <!-- Inventory List Link -->
        <li>
            <a href="{{ route('inventory.list') }}">
                <i class="fa fa-motorcycle"></i> Browse Bikes
            </a>
        </li>
               <li>
                   <a href="{{ route('dashboard.create-advertisement') }}">
                       <i class="fa fa-motorcycle"></i> Sell
                   </a>
               </li>
        
        <!-- Blog Link -->
        <li>
            <a href="{{ route('blogs.index') }}">
                <i class="fa fa-newspaper"></i> Blog
            </a>
        </li>
        
        <!-- About Us Link -->
        <li>
            <a href="{{ route('about.index') }}">
                <i class="fa fa-info-circle"></i> About Us
            </a>
        </li>
        
        <!-- FAQ Link -->
        <li>
            <a href="{{ route('faq.index') }}">
                <i class="fa fa-question-circle"></i> FAQ
            </a>
        </li>
        
        <li class="divider" style="border-top: 1px solid rgba(255,255,255,0.1); margin: 10px 0;"></li>
        
        @if(!Auth::guard('provider')->check())
            <li>
                <a href="{{ route('provider.auth') }}">
                    <i class="fa fa-sign-in"></i> Sign In
                </a>
            </li>
        @else
            <li>
                <a href="{{ route('dashboard.profile') }}">
                    <i class="fa fa-tachometer"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard.my-advertisements') }}">
                    <i class="fa fa-list"></i> My Listings
            </a>
            </li>
            <li>
                <a href="{{ route('dashboard.messages') }}">
                    <i class="fa fa-envelope"></i> Messages
                </a>
            </li>
            <li>
                <a href="{{ route('provider.logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
            </li>

            <form id="logout-form-mobile" action="{{ route('provider.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endif
    </ul>
</div>
