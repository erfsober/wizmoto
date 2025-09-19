<x-filament-panels::page>
    <div class="space-y-6">
        <div style="margin-bottom: 20px;">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                Change Password for {{ $this->record->name }}
            </h2>
        </div>

        <form wire:submit="save">
            {{ $this->schema }}

            <div class="flex justify-end space-x-3 pt-6 mt-6" style="margin-top: 20px;">
                <x-filament::button
                    type="button"
                    color="gray"
                    wire:click="$dispatch('close-modal')"
                >
                    Cancel
                </x-filament::button>
                
                <x-filament::button
                    type="submit"
                    color="primary"
                >
                    Update Password
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>