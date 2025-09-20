<div class="space-y-6">
    <!-- Original Image -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-3">Original Image</h3>
        <div class="border rounded-lg p-4 bg-gray-50">
            <img src="{{ $conversions['original'] }}" 
                 alt="{{ $media->alt_text ?? $media->name }}" 
                 class="max-w-full h-auto rounded-lg shadow-sm">
        </div>
        <div class="mt-2 text-sm text-gray-600">
            <p><strong>File:</strong> {{ $media->name }}</p>
            <p><strong>Size:</strong> {{ number_format($media->file_size / 1024, 1) }} KB</p>
            <p><strong>Type:</strong> {{ $media->mime_type }}</p>
            @if($media->alt_text)
                <p><strong>Alt Text:</strong> {{ $media->alt_text }}</p>
            @endif
        </div>
    </div>

    <!-- Image Conversions -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-3">Image Conversions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach([
                'thumb' => 'Thumbnail (233x233)',
                'preview' => 'Preview (800x550)',
                'square' => 'Square (280x272)',
                'card' => 'Card (360x240)'
            ] as $conversion => $label)
                <div class="border rounded-lg p-3 bg-white">
                    <h4 class="font-medium text-sm text-gray-700 mb-2">{{ $label }}</h4>
                    <img src="{{ $conversions[$conversion] }}" 
                         alt="{{ $media->alt_text ?? $media->name }} - {{ $label }}" 
                         class="w-full h-auto rounded border">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Download Links -->
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-3">Download</h3>
        <div class="flex flex-wrap gap-2">
            <a href="{{ $conversions['original'] }}" 
               download="{{ $media->name }}"
               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Original
            </a>
            @foreach([
                'thumb' => 'Thumbnail',
                'preview' => 'Preview',
                'square' => 'Square',
                'card' => 'Card'
            ] as $conversion => $label)
                <a href="{{ $conversions[$conversion] }}" 
                   download="{{ pathinfo($media->name, PATHINFO_FILENAME) }}_{{ $conversion }}.{{ pathinfo($media->name, PATHINFO_EXTENSION) }}"
                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</div>
