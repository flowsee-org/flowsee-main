<?php

namespace App\Filament\Resources\SiteSettings;

use App\Filament\Resources\SiteSettings\Pages;
use App\Models\SiteSetting;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'تنظیمات سایت';

    protected static ?string $modelLabel = 'تنظیم';

    protected static ?string $pluralModelLabel = 'تنظیمات سایت';

    protected static string|\UnitEnum|null $navigationGroup = 'محتوای سایت';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\TextInput::make('key')
                    ->label('کلید')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->disabled(fn (?SiteSetting $record) => $record !== null),
                Schemas\Components\Textarea::make('value')
                    ->label('مقدار')
                    ->rows(3)
                    ->maxLength(5000)
                    ->columnSpanFull(),
                Schemas\Components\Select::make('type')
                    ->label('نوع')
                    ->options([
                        'string' => 'متن',
                        'integer' => 'عدد',
                        'boolean' => 'بولین',
                        'json' => 'JSON',
                    ])
                    ->default('string')
                    ->disabled(fn (?SiteSetting $record) => $record !== null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('کلید')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('مقدار')
                    ->limit(50)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع')
                    ->badge(),
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
            ->defaultSort('key', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
