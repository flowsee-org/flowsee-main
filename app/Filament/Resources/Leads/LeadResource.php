<?php

namespace App\Filament\Resources\Leads;

use App\Filament\Resources\Leads\Pages\ListLeads;
use App\Models\Lead;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LeadResource extends Resource
{
    protected static ?string $model = Lead::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'درخواست‌ها';

    protected static ?string $modelLabel = 'درخواست';

    protected static ?string $pluralModelLabel = 'درخواست‌ها';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('نام')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('شماره تماس')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('email')
                    ->label('ایمیل')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('service')
                    ->label('خدمت درخواستی')
                    ->formatStateUsing(fn (string $state): string => Lead::SERVICES[$state] ?? $state)
                    ->badge()
                    ->sortable(),
                TextColumn::make('details')
                    ->label('درباره پروژه')
                    ->wrap()
                    ->limit(100)
                    ->tooltip(fn (Lead $record): string => $record->details),
                SelectColumn::make('status')
                    ->label('وضعیت پیگیری')
                    ->options(Lead::STATUSES)
                    ->selectablePlaceholder(false),
                TextColumn::make('created_at')
                    ->label('تاریخ ثبت')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('service')
                    ->label('خدمت درخواستی')
                    ->options(Lead::SERVICES),
                SelectFilter::make('status')
                    ->label('وضعیت پیگیری')
                    ->options(Lead::STATUSES),
                Filter::make('created_at')
                    ->label('بازهٔ تاریخ ثبت')
                    ->schema([
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
