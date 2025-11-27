<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Schema;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('title_en')
                    ->label('Title (English)')
                    ->columnSpanFull(),
                Textarea::make('summary')
                    ->label('Summary/Excerpt')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('summary_en')
                    ->label('Summary/Excerpt (English)')
                    ->rows(3)
                    ->columnSpanFull(),
                Select::make('blog_category_id')
                    ->label('Category')
                    ->relationship('blogCategory', 'title')
                    ->required()
                    ->searchable()
                    ->preload(),
                SpatieMediaLibraryFileUpload::make('images')
                    ->label('Featured Image')
                    ->collection('images')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->columnSpanFull()
                    ->helperText('Upload a featured image for this blog post'),
                RichEditor::make('body')
                    ->label('Content')
                    ->default(null)
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
                RichEditor::make('body_en')
                    ->label('Content (English)')
                    ->default(null)
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
                TextInput::make('author_name')
                    ->label('Author Name')
                    ->default(null),
                TextInput::make('slug')
                    ->label('URL Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->rules(['alpha_dash'])
                    ->helperText('Used in the URL (e.g., "my-blog-post")'),
                Toggle::make('published')
                    ->label('Published')
                    ->default(false),
                TextInput::make('views')
                    ->label('View Count')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->helperText('This will be automatically updated'),
            ]);
    }
}
