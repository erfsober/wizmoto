<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminResource;
use App\Models\Admin;
use Filament\Actions\DeleteAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('changePassword')
                ->label('Change Password')
                ->icon('heroicon-o-key')
                ->color('info')
                ->url(fn (Admin $record): string => route('filament.admin.resources.admins.change-password', $record->id))
                ->openUrlInNewTab(),
           
        ];
    }

    // SpatieMediaLibraryFileUpload handles the media library integration automatically
    // No need for custom handleRecordUpdate or mutateFormDataBeforeFill methods
}
