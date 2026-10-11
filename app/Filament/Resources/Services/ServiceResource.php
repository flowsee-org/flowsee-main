<?php

namespace App\Filament\Resources\Services;

use App\Filament\Resources\Services\Pages;
use App\Models\Service;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'خدمات';

    protected static ?string $modelLabel = 'خدمت';

    protected static ?string $pluralModelLabel = 'خدمات';

    protected static string|\UnitEnum|null $navigationGroup = 'محتوای سایت';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\TextInput::make('title')
                    ->label('عنوان خدمت')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $state, Schemas\Set $set) => $set('slug', Str::slug($state, '-'))),
                Schemas\Components\TextInput::make('slug')
                    ->label('اسلاگ')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Schemas\Components\Textarea::make('description')
                    ->label('توضیحات')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),
                Schemas\Components\TextInput::make('icon')
                    ->label('آیکون')
                    ->maxLength(255)
                    ->helperText('نام کلاس آیکون یا مسیر SVG'),
                Schemas\Components\TextInput::make('sort_order')
                    ->label('ترتیب نمایش')
                    ->numeric()
                    ->default(0),
                Schemas\Components\Toggle::make('is_highlighted')
                    ->label('برجسته')
                    ->default(false),
                Schemas\Components\Toggle::make('is_active')
                    ->label('فعال')
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('اسلاگ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('توضیحات')
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\IconColumn::make('is_highlighted')
                    ->label('برجسته')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('ترتیب')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_highlighted')
                    ->label('برجسته'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('فعال'),
            ])
            ->actions([
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
