<?php

namespace App\Filament\Resources\Leads;

use App\Filament\Resources\Leads\Pages\ListLeads;
use App\Models\Lead;
use Filament\Schemas;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'درخواست‌ها';

    protected static ?string $modelLabel = 'درخواست';

    protected static ?string $pluralModelLabel = 'درخواست‌ها';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Schemas\Components\TextInput::make('name')
                    ->label('نام')
                    ->required()
                    ->maxLength(100),
                Schemas\Components\TextInput::make('phone')
                    ->label('شماره تماس')
                    ->required()
                    ->maxLength(24),
                Schemas\Components\TextInput::make('email')
                    ->label('ایمیل')
                    ->email()
                    ->maxLength(255),
                Schemas\Components\Select::make('service')
                    ->label('خدمت درخواستی')
                    ->options(Lead::SERVICES)
                    ->required(),
                Schemas\Components\Textarea::make('details')
                    ->label('درباره پروژه')
                    ->rows(3)
                    ->maxLength(5000),
                Schemas\Components\Select::make('status')
                    ->label('وضعیت پیگیری')
                    ->options(Lead::STATUSES)
                    ->default('new'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('شماره تماس')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('ایمیل')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('service')
                    ->label('خدمت درخواستی')
                    ->formatStateUsing(fn (string $state): string => Lead::SERVICES[$state] ?? $state)
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('details')
                    ->label('درباره پروژه')
                    ->wrap()
                    ->limit(100)
                    ->tooltip(fn (Lead $record): string => $record->details),
                Tables\Columns\SelectColumn::make('status')
                    ->label('وضعیت پیگیری')
                    ->options(Lead::STATUSES)
                    ->selectablePlaceholder(false),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ثبت')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('service')
                    ->label('خدمت درخواستی')
                    ->options(Lead::SERVICES),
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت پیگیری')
                    ->options(Lead::STATUSES),
                Tables\Filters\Filter::make('created_at')
                    ->label('بازهٔ تاریخ ثبت')
                    ->form([
                        DatePicker::make('from')->label('از تاریخ')->native(false),
                        DatePicker::make('until')->label('تا تاریخ')->native(false),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['from'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '>=', $date))
                        ->when($data['until'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('created_at', '<=', $date))),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('هنوز درخواستی ثبت نشده است');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeads::route('/'),
        ];
    }
}
