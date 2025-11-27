<?php

namespace App\Filament\Resources\Advertisements\Pages;

use App\Filament\Resources\Advertisements\AdvertisementResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Notifications\Notification;

class EditAdvertisement extends EditRecord
{
    protected static string $resource = AdvertisementResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Advertisement of ' . optional($this->record->provider)->full_name ?? 'Unknown Provider';
    }


    protected function getHeaderActions(): array
    {
        return [
            Action::make('manage_media')
                ->label('Manage Images')
                ->icon('heroicon-o-photo')
                ->color('info')
                ->form([
                    SpatieMediaLibraryFileUpload::make('media')
                        ->collection('covers')
                        ->multiple()
                        ->reorderable()
                        ->appendFiles()
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->maxSize(5120)
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                        ->openable()
                        ->previewable()
                        ->downloadable()
                        ->deletable()
                        ->moveFiles()
                        ->preserveFilenames()
                        ->label('Advertisement Images')
                        ->helperText('Upload and manage images for this advertisement. You can drag and drop to reorder them.')
                        ->columnSpanFull(),
                ])
                ->fillForm(function () {
                    return [
                        'media' => $this->record->getMedia('covers')->map(fn ($media) => $media->getUrl())->toArray(),
                    ];
                })
                ->action(function (array $data) {
                    // Clear existing media
                    $this->record->clearMediaCollection('covers');
                    
                    // Add new media
                    if (isset($data['media']) && is_array($data['media'])) {
                        foreach ($data['media'] as $file) {
                            $this->record->addMediaFromDisk($file)
                                ->toMediaCollection('covers');
                        }
                    }
                    
                    Notification::make()
                        ->title('Images updated successfully')
                        ->success()
                        ->send();
                })
                ->modalHeading('Manage Advertisement Images')
                ->modalDescription('Upload, reorder, and manage images for this advertisement.')
                ->modalSubmitActionLabel('Save Images')
                ->modalWidth('4xl'),
            DeleteAction::make(),
        ];
    }
}
