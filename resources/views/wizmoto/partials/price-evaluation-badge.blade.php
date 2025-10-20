@php
    $raw = trim(($value ?? $advertisement->price_evaluation ?? $newAdvertisement->price_evaluation ?? $relatedAd->price_evaluation ?? ''));
    // Map internal values to AutoScout-style labels
    $mapToAutoscout = [
        'Super Price' => 'Top offer',
        'Great Price' => 'Good price',
        'Good Price'  => 'Fair price',
        'ND'          => 'No rating',
        ''            => 'No rating',
    ];
    $label = $mapToAutoscout[$raw] ?? 'No rating';

    // AutoScout-style color palette
    $palette = [
        'Top offer'  => ['#0E5C2F', '#D5F2E3'], // deep green on light green
        'Good price' => ['#1F7A3E', '#E3F7EB'], // green
        'Fair price' => ['#8A6D00', '#FFF3CD'], // amber/yellow
        'Slightly overpriced' => ['#8a4b08', '#FFE5D0'], // orange (not used yet)
        'Overpriced' => ['#842029', '#F8D7DA'], // red (not used yet)
        'No rating'  => ['#6C757D', '#E9ECEF'], // gray
    ];
    [$textColor, $bgColor] = $palette[$label] ?? $palette['No rating'];
@endphp
<span style="display:inline-flex;gap:6px;align-items:center;padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;line-height:1;color:{{ $textColor }};background:{{ $bgColor }};margin-left:8px;white-space:nowrap;">
    <span style="width:8px;height:8px;border-radius:50%;background:{{ $textColor }};display:inline-block"></span>
    {{ $label }}
</span>



