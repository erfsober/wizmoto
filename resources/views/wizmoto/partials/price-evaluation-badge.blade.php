@php
    $raw = trim(($value ?? $advertisement->price_evaluation ?? $newAdvertisement->price_evaluation ?? $relatedAd->price_evaluation ?? ''));
    // Map internal values to labels and filled circle counts
    $mapToData = [
        'Super Price' => ['label' => 'Top offer', 'filledCircles' => 5],
        'Great Price' => ['label' => 'Good', 'filledCircles' => 4],
        'Good Price'  => ['label' => 'Fair', 'filledCircles' => 3],
        'ND'          => ['label' => 'No rating', 'filledCircles' => 0],
        ''            => ['label' => 'No rating', 'filledCircles' => 0],
    ];
    $result = $mapToData[$raw] ?? $mapToData[''];
    $label = $result['label'];
    $filledCircles = $result['filledCircles'];
    $totalCircles = 5;

    // AutoScout-style color palette (matching AutoScout24 exact colors)
    $palette = [
        'Super Price' => ['#0E5C2F', '#D5F2E3'], // deep green on light green background
        'Great Price' => ['#1F7A3E', '#E3F7EB'], // green on light green background
        'Good Price'  => ['#8A6D00', '#FFF3CD'], // amber on light yellow background
        'ND'          => ['#6C757D', '#E9ECEF'], // gray on light gray background
        ''            => ['#6C757D', '#E9ECEF'], // gray on light gray background
    ];
    [$filledColor, $emptyColor] = $palette[$raw] ?? $palette[''];
@endphp
<div class="price-evaluation-badge" style="display:inline-flex;align-items:center;gap:6px;padding:6px 12px;border-radius:16px;background-color:{{ $emptyColor }};margin-left:8px;white-space:nowrap;box-shadow:0 1px 2px rgba(0,0,0,0.05);">
    <strong style="font-size:13px;font-weight:600;line-height:1.2;color:{{ $filledColor }};margin-right:2px;">{{ $label }}</strong>
    <div style="display:inline-flex;align-items:center;gap:3px;">
        @for($i = 1; $i <= $totalCircles; $i++)
            <i style="width:6px;height:6px;border-radius:50%;background-color:{{ $i <= $filledCircles ? $filledColor : 'rgba(108,117,125,0.25)' }};display:inline-block;"></i>
        @endfor
    </div>
</div>



