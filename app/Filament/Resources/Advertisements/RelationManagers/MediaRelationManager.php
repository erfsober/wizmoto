<?php

namespace App\Filament\Resources\Advertisements\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaRelationManager extends RelationManager
{
    protected static string $relationship = 'media';

    protected static ?string $title = 'Advertisement Images';

    protected static ?string $modelLabel = 'Image';

    protected static ?string $pluralModelLabel = 'Images';

    protected static ?string $recordTitleAttribute = 'name';

    // Form method removed - using inline forms in actions instead

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('collection_name', 'covers'))
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('media')
                    ->label('Image')
                    ->collection('covers')
                    ->conversion('thumb')
                    ->size(80)
                    ->square()
                    ->defaultImageUrl(url('/wizmoto/images/logo.png')),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('File Name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                
                Tables\Columns\TextColumn::make('file_size')
                    ->label('Size')
                    ->formatStateUsing(fn ($state) => $state ? number_format($state / 1024, 1) . ' KB' : 'N/A')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('mime_type')
                    ->label('Type')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('mime_type')
                    ->label('File Type')
                    ->options([
                        'image/jpeg' => 'JPEG',
                        'image/png' => 'PNG',
                        'image/gif' => 'GIF',
                        'image/webp' => 'WebP',
                    ]),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Upload Images')
                    ->form([
                        Forms\Components\SpatieMediaLibraryFileUpload::make('media')
                            ->collection('covers')
                            ->multiple()
                            ->required()
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
                            ->label('Select Images to Upload')
                            ->helperText('Upload multiple images for this advertisement. You can drag and drop to reorder them.')
                            ->columnSpanFull(),
                    ])
                    ->using(function (array $data, $record) {
                        // Handle the file upload through the owner record
                        if (isset($data['media']) && is_array($data['media'])) {
                            foreach ($data['media'] as $file) {
                                $record->addMediaFromDisk($file, 'public')
                                    ->toMediaCollection('covers');
                            }
                        }
                        return $record;
                    })
                    ->createAnother(false),
            ])
            ->actions([
                ViewAction::make()
                    ->modalContent(fn (Media $record) => view('filament.components.media-preview', [
                        'media' => $record,
                        'conversions' => [
                            'thumb' => $record->getUrl('thumb'),
                            'preview' => $record->getUrl('preview'),
                            'square' => $record->getUrl('square'),
                            'card' => $record->getUrl('card'),
                            'original' => $record->getUrl(),
                        ]
                    ]))
                    ->modalHeading('Image Preview & Conversions'),
                
                EditAction::make()
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('File Name')
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('alt_text')
                            ->label('Alt Text')
                            ->maxLength(500)
                            ->rows(2)
                            ->helperText('Alternative text for accessibility'),
                    ]),
                
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Delete Image')
                    ->modalDescription('Are you sure you want to delete this image? This action cannot be undone.')
                    ->modalSubmitActionLabel('Delete Image'),
            ])
            // Bulk actions removed due to import issues
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column')
            ->paginated([10, 25, 50])
            ->emptyStateHeading('No Images')
            ->emptyStateDescription('Upload images to showcase this advertisement.')
            ->emptyStateIcon('heroicon-o-photo');
    }
}
