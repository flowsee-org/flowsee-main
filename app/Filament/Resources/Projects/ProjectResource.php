<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages;
use App\Models\Project;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'پروژه‌ها';

    protected static ?string $modelLabel = 'پروژه';

    protected static ?string $pluralModelLabel = 'پروژه‌ها';

    protected static string|\UnitEnum|null $navigationGroup = 'محتوای سایت';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\Section::make('اطلاعات پروژه')
                    ->schema([
                        Schemas\Components\TextInput::make('name')
                            ->label('نام پروژه')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, Schemas\Set $set) => $set('slug', Str::slug(state: $state, language: 'en'))),
                        Schemas\Components\TextInput::make('slug')
                            ->label('اسلاگ')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Schemas\Components\Textarea::make('description')
                            ->label('توضیحات')
                            ->rows(3)
                            ->maxLength(2000)
                            ->columnSpanFull(),
                        Schemas\Components\Select::make('service_id')
                            ->label('دسته‌بندی خدمت')
                            ->relationship('service', 'title')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Schemas\Components\TextInput::make('asset_id')
                            ->label('شناسه فایل')
                            ->maxLength(255)
                            ->nullable(),
                    ])
                    ->columns(2),

                Schemas\Components\Section::make('تصویر کاور')
                    ->schema([
                        Schemas\Components\FileUpload::make('cover_image')
                            ->label('تصویر کاور')
                            ->image()
                            ->directory('projects/covers')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                            ->maxSize(5120)
                            ->saveUploadedFileUsing(function ($file, $record) {
                                $filename = Str::slug($record->name ?? 'project') . '-' . time() . '.webp';
                                $path = $file->storeAs('projects/covers', $filename, 'public');

                                $fullPath = storage_path('app/public/' . $path);
                                if (file_exists($fullPath)) {
                                    try {
                                        $image = ImageManager::usingDriver(Driver::class)->read($fullPath);
                                        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: 85);
                                        file_put_contents($fullPath, (string) $encoded);
                                    } catch (\Exception $e) {
                                        // If conversion fails, keep original
                                    }
                                }

                                return $path;
                            })
                            ->helperText('حداکثر ۵ مگابایت. فرمت‌های مجاز: JPG, PNG, WebP, GIF. تصویر به WebP تبدیل می‌شود.'),
                    ]),

                Schemas\Components\Section::make('گالری تصاویر مودال')
                    ->schema([
                        Schemas\Components\Repeater::make('gallery_images')
                            ->label('تصاویر گالری')
                            ->relationship('galleryImages')
                            ->schema([
                                Schemas\Components\FileUpload::make('path')
                                    ->label('تصویر')
                                    ->image()
                                    ->directory('projects/gallery')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif'])
                                    ->maxSize(5120)
                                    ->saveUploadedFileUsing(function ($file, $record) {
                                        $filename = 'gallery-' . time() . '-' . Str::random(8) . '.webp';
                                        $path = $file->storeAs('projects/gallery', $filename, 'public');

                                        $fullPath = storage_path('app/public/' . $path);
                                        if (file_exists($fullPath)) {
                                            try {
                                        $image = ImageManager::usingDriver(Driver::class)->read($fullPath);
                                        $encoded = $image->encodeUsingFormat(Format::WEBP, quality: 85);
                                        file_put_contents($fullPath, (string) $encoded);
                                            } catch (\Exception $e) {
                                                // If conversion fails, keep original
                                            }
                                        }

                                        return $path;
                                    }),
                                Schemas\Components\TextInput::make('caption')
                                    ->label('کپشن')
                                    ->maxLength(500)
                                    ->nullable(),
                                Schemas\Components\TextInput::make('alt')
                                    ->label('متن جایگزین')
                                    ->maxLength(255)
                                    ->nullable(),
                                Schemas\Components\Select::make('layout')
                                    ->label('چیدمان')
                                    ->options([
                                        'full' => 'تمام‌عرض',
                                        'half' => 'نیمه',
                                        'third' => 'یک‌سوم',
                                    ])
                                    ->default('full'),
                                Schemas\Components\TextInput::make('sort_order')
                                    ->label('ترتیب')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns(2)
                            ->addable()
                            ->deletable()
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),

                Schemas\Components\Section::make('تنظیمات')
                    ->schema([
                        Schemas\Components\Toggle::make('is_featured')
                            ->label('ویژه')
                            ->default(false),
                        Schemas\Components\Toggle::make('has_case_study')
                            ->label('دارای کیس‌استادی')
                            ->default(false),
                        Schemas\Components\Toggle::make('is_active')
                            ->label('فعال')
                            ->default(true),
                        Schemas\Components\TextInput::make('sort_order')
                            ->label('ترتیب نمایش')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('کاور')
                    ->disk('public')
                    ->size(60),
                Tables\Columns\TextColumn::make('name')
                    ->label('نام پروژه')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('اسلاگ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service.title')
                    ->label('دسته‌بندی خدمت')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('ویژه')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_case_study')
                    ->label('کیس‌استادی')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('ترتیب')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('دسته‌بندی خدمت')
                    ->relationship('service', 'title'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('ویژه'),
                Tables\Filters\TernaryFilter::make('has_case_study')
                    ->label('دارای کیس‌استادی'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('فعال'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
