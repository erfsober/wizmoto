<?php

namespace App\Filament\Resources\Admins\Pages;

use App\Filament\Resources\Admins\AdminResource;
use App\Models\Admin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends Page implements HasSchemas
{
    use InteractsWithRecord;
    use InteractsWithSchemas;

    protected static string $resource = AdminResource::class;

    public  string $view = 'filament.resources.admins.pages.change-password';

    public ?array $data = [];

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function schema(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('current_password')
                    ->label('Current Password')
                    ->password()
                    ->required()
                    ->rule(function () {
                        return function (string $attribute, $value, \Closure $fail) {
                            if (!Hash::check($value, $this->record->password)) {
                                $fail('The current password is incorrect.');
                            }
                        };
                    }),
                TextInput::make('password')
                    ->label('New Password')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->same('passwordConfirmation')
                    ->validationMessages([
                        'same' => 'The password and confirmation password do not match.',
                    ]),
                TextInput::make('passwordConfirmation')
                    ->label('Confirm New Password')
                    ->password()
                    ->required()
                    ->minLength(8),
            ]);
    }

    public function save(): void
    {
        $data = $this->getSchemaData();

        $this->record->update([
            'password' => Hash::make($data['password']),
        ]);

        Notification::make()
            ->title('Password updated successfully')
            ->success()
            ->send();

        $this->resetSchemaData();
    }
}
