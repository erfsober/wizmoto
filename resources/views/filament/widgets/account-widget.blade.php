<x-filament-widgets::widget>
    <x-filament::section>
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="flex-shrink: 0;">
                @if($avatar)
                    <img 
                        src="{{ $avatar }}" 
                        alt="{{ $name }}" 
                        style="height: 32px; width: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #e5e7eb;"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                    >
                    <div style="height: 32px; width: 32px; border-radius: 50%; background-color: #f3f4f6; display: none; align-items: center; justify-content: center;">
                        <svg style="height: 16px; width: 16px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @else
                    <div style="height: 32px; width: 32px; border-radius: 50%; background-color: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                        <svg style="height: 16px; width: 16px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            
            <div style="flex: 1; min-width: 0;">
                <p style="font-size: 14px; font-weight: 500; color: #111827; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ $name }}
                </p>
                <p style="font-size: 14px; color: #6b7280; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ $email }}
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
