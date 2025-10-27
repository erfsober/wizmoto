@php
$currentLocale = app()->getLocale();
$availableLocales = [
    'en' => 'English',
    'it' => 'Italiano'
];
@endphp

<div class="language-switcher-wrapper">
    <div class="language-dropdown-container">
        <button class="language-btn" type="button">
            <i class="fa fa-globe"></i>
            <span>{{ strtoupper($currentLocale) }}</span>
            <i class="fa fa-angle-down"></i>
        </button>
        <ul class="language-dropdown">
            @foreach($availableLocales as $locale => $label)
                <li class="{{ $locale === $currentLocale ? 'active' : '' }}">
                    <a href="{{ route('locale.switch', $locale) }}">
                        {{ $label }}
                        @if($locale === $currentLocale)
                            <i class="fa fa-check"></i>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<style>
.language-switcher-wrapper {
    position: relative;
    margin-left: 15px;
    margin-right: 15px;
    display: inline-flex;
    align-items: center;
    vertical-align: middle;
    height: 100%;
}

.language-dropdown-container {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
}

.language-btn {
    background: transparent;
    border: none;
    color: white;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 6px;
    transition: all 0.3s ease;
    font-size: 15px;
    line-height: 1;
    white-space: nowrap;
    height: 100%;
}

.language-btn:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.language-btn i.fa-globe {
    font-size: 16px;
}

.language-btn span {
    font-weight: 500;
}

.language-btn i.fa-angle-down {
    font-size: 12px;
    transition: transform 0.2s ease;
}

.language-dropdown-container:hover .language-btn i.fa-angle-down {
    transform: rotate(180deg);
}

.language-dropdown {
    position: absolute;
    top: calc(100% + 5px);
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    list-style: none;
    padding: 8px 0;
    min-width: 140px;
    z-index: 1000;
    display: none;
    margin: 0;
}

.language-dropdown.show {
    display: block;
    animation: slideDown 0.2s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.language-dropdown li {
    margin: 0;
}

.language-dropdown li a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 16px;
    color: #333;
    text-decoration: none;
    transition: all 0.2s ease;
    font-weight: 400;
}

.language-dropdown li.active a {
    color: #405FF2;
    font-weight: 600;
    background-color: rgba(64, 95, 242, 0.05);
}

.language-dropdown li:not(.active) a:hover {
    background-color: #f5f5f5;
    color: #405FF2;
}

.language-dropdown li a i.fa-check {
    color: #405FF2;
    font-size: 12px;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .language-switcher-wrapper {
        margin-right: 10px;
    }
    
    .language-btn {
        padding: 6px 10px;
        font-size: 14px;
    }
    
    .language-btn i.fa-globe {
        font-size: 14px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const langBtn = document.querySelector('.language-btn');
    const langDropdown = document.querySelector('.language-dropdown');
    
    if (langBtn && langDropdown) {
        // Toggle dropdown
        langBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            langDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.language-switcher-wrapper')) {
                langDropdown.classList.remove('show');
            }
        });
    }
});
</script>

