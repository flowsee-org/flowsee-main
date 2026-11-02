<?php

namespace App\Filament\Resources\CaseStudies;

use App\Filament\Resources\CaseStudies\Pages;
use App\Models\CaseStudy;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class CaseStudyResource extends Resource
{
    protected static ?string $model = CaseStudy::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'کیس‌استادی‌ها';

    protected static ?string $modelLabel = 'کیس‌استادی';

    protected static ?string $pluralModelLabel = 'کیس‌استادی‌ها';

    protected static string|\UnitEnum|null $navigationGroup = 'محتوای سایت';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\Section::make('اطلاعات کیس‌استادی')
                    ->schema([
                        Schemas\Components\Select::make('project_id')
                            ->label('پروژه')
                            ->relationship('project', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Schemas\Components\TextInput::make('title')
                            ->label('عنوان')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, Schemas\Set $set) => $set('slug', Str::slug($state, '-'))),
                        Schemas\Components\TextInput::make('slug')
                            ->label('اسلاگ')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Schemas\Components\TextInput::make('lead')
                            ->label('لید')
                            ->maxLength(500),
                        Schemas\Components\TextInput::make('eyebrow')
                            ->label('ابرو')
                            ->maxLength(255),
                        Schemas\Components\TextInput::make('client_name')
                            ->label('نام کارفرما')
                            ->maxLength(255),
                        Schemas\Components\TextInput::make('industry')
                            ->label('صنعت')
                            ->maxLength(255),
                        Schemas\Components\TextInput::make('services_provided')
                            ->label('خدمات ارائه‌شده')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Schemas\Components\Section::make('تصویر کاور')
                    ->schema([
                        Schemas\Components\FileUpload::make('cover_image')
                            ->label('تصویر کاور')
                            ->image()
                            ->directory('case-studies/covers')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->saveUploadedFileUsing(function ($file, $record) {
                                $filename = 'case-cover-' . time() . '.webp';
                                $path = $file->storeAs('case-studies/covers', $filename, 'public');
                                self::convertToWebP($path);
                                return $path;
                            }),
                        Schemas\Components\TextInput::make('cover_caption')
                            ->label('کپشن کاور')
                            ->maxLength(500),
                    ]),

                Schemas\Components\Section::make('سئو')
                    ->schema([
                        Schemas\Components\TextInput::make('meta_title')
                            ->label('عنوان متا')
                            ->maxLength(255),
                        Schemas\Components\Textarea::make('meta_description')
                            ->label('توضیحات متا')
                            ->rows(2)
                            ->maxLength(500),
                        Schemas\Components\ColorPicker::make('theme_color')
                            ->label('رنگ تم')
                            ->default('#012233'),
                    ])
                    ->columns(2),

                Schemas\Components\Section::make('بخش‌های کیس‌استادی')
                    ->schema([
                        Schemas\Components\Repeater::make('sections')
                            ->label('بخش‌ها')
                            ->relationship('sections')
                            ->schema([
                                Schemas\Components\TextInput::make('title')
                                    ->label('عنوان بخش')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $state, Schemas\Set $set) => $set('slug', Str::slug($state, '-'))),
                                Schemas\Components\TextInput::make('slug')
                                    ->label('اسلاگ')
                                    ->required()
                                    ->maxLength(255),
                                Schemas\Components\Textarea::make('lead')
                                    ->label('لید بخش')
                                    ->rows(2)
                                    ->maxLength(1000),
                                Schemas\Components\TextInput::make('eyebrow')
                                    ->label('ابرو')
                                    ->maxLength(255),
                                Schemas\Components\TextInput::make('index_label')
                                    ->label('برچسب شاخص')
                                    ->maxLength(10),
                                Schemas\Components\FileUpload::make('band_image')
                                    ->label('تصویر بند')
                                    ->image()
                                    ->directory('case-studies/bands')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->maxSize(5120)
                                    ->saveUploadedFileUsing(function ($file, $record) {
                                        $filename = 'band-' . time() . '.webp';
                                        $path = $file->storeAs('case-studies/bands', $filename, 'public');
                                        self::convertToWebP($path);
                                        return $path;
                                    }),
                                Schemas\Components\TextInput::make('band_caption')
                                    ->label('کپشن بند')
                                    ->maxLength(500),
                                Schemas\Components\TextInput::make('sort_order')
                                    ->label('ترتیب')
                                    ->numeric()
                                    ->default(0),

                                Schemas\Components\Repeater::make('steps')
                                    ->label('مراحل')
                                    ->relationship('steps')
                                    ->schema([
                                        Schemas\Components\TextInput::make('title')
                                            ->label('عنوان مرحله')
                                            ->required()
                                            ->maxLength(255),
                                        Schemas\Components\Textarea::make('description')
                                            ->label('توضیحات')
                                            ->rows(2)
                                            ->maxLength(500),
                                        Schemas\Components\TextInput::make('step_number')
                                            ->label('شماره مرحله')
                                            ->maxLength(10),
                                        Schemas\Components\TextInput::make('sort_order')
                                            ->label('ترتیب')
                                            ->numeric()
                                            ->default(0),
                                    ])
                                    ->columns(2)
                                    ->addable()
                                    ->deletable()
                                    ->reorderable(),

                                Schemas\Components\Repeater::make('images')
                                    ->label('تصاویر گالری')
                                    ->relationship('images')
                                    ->schema([
                                        Schemas\Components\FileUpload::make('path')
                                            ->label('تصویر')
                                            ->image()
                                            ->directory('case-studies/gallery')
                                            ->visibility('public')
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                            ->maxSize(5120)
                                            ->saveUploadedFileUsing(function ($file, $record) {
                                                $filename = 'gallery-' . time() . '-' . Str::random(6) . '.webp';
                                                $path = $file->storeAs('case-studies/gallery', $filename, 'public');
                                                self::convertToWebP($path);
                                                return $path;
                                            }),
                                        Schemas\Components\TextInput::make('caption')
                                            ->label('کپشن')
                                            ->maxLength(500),
                                        Schemas\Components\TextInput::make('alt')
                                            ->label('متن جایگزین')
                                            ->maxLength(255),
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
                                    ->reorderable(),
                            ])
                            ->columns(2)
                            ->addable()
                            ->deletable()
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),

                Schemas\Components\Section::make('پالت رنگ')
                    ->schema([
                        Schemas\Components\Repeater::make('colors')
                            ->label('رنگ‌ها')
                            ->relationship('colors')
                            ->schema([
                                Schemas\Components\TextInput::make('name')
                                    ->label('نام رنگ')
                                    ->required()
                                    ->maxLength(255),
                                Schemas\Components\ColorPicker::make('hex')
                                    ->label('کد رنگ')
                                    ->required(),
                                Schemas\Components\TextInput::make('sort_order')
                                    ->label('ترتیب')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns(3)
                            ->addable()
                            ->deletable()
                            ->reorderable(),
                    ]),

                Schemas\Components\Section::make('تنظیمات')
                    ->schema([
                        Schemas\Components\Toggle::make('is_published')
                            ->label('منتشرشده')
                            ->default(true),
                    ]),
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
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('project.name')
                    ->label('پروژه')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('اسلاگ')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('منتشرشده')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('project_id')
                    ->label('پروژه')
                    ->relationship('project', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('منتشرشده'),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCaseStudies::route('/'),
            'create' => Pages\CreateCaseStudy::route('/create'),
            'view' => Pages\ViewCaseStudy::route('/{record}'),
            'edit' => Pages\EditCaseStudy::route('/{record}/edit'),
        ];
    }

    protected static function convertToWebP(string $path): void
    {
        $fullPath = storage_path('app/public/' . $path);
        if (! file_exists($fullPath)) {
            return;
        }
        try {
            $image = ImageManager::usingDriver(Driver::class)->read($fullPath);
            $encoded = $image->encodeUsingFormat(Format::WEBP, quality: 85);
            file_put_contents($fullPath, (string) $encoded);
        } catch (\Exception $e) {
            // If conversion fails, keep original
        }
    }
}
