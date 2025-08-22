<?php

namespace App\Filament\Exports;

use App\Models\Expense;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;

class ExpenseExporter extends Exporter
{
    protected static ?string $model = Expense::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label(__('lang.Name')),
            ExportColumn::make('amount')->label(__('lang.Amount')),
            ExportColumn::make('start_date')->label(__('lang.Start Date')),

            ExportColumn::make('category.name')
                ->label(__('lang.Category')),

            ExportColumn::make('budgetLimit.name')
                ->label(__('lang.Budget')),
        ];
    }

    public static function getCompletedNotificationBody(\Filament\Actions\Exports\Models\Export $export): string
    {
        $body = 'Your expense export has completed and '
            . number_format($export->successful_rows)
            . ' ' . str('row')->plural($export->successful_rows)
            . ' exported.';

        return $body;
    }
}
