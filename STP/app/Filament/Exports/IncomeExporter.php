<?php

namespace App\Filament\Exports;

use App\Models\Income;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Models\Export;

class IncomeExporter extends Exporter
{
    protected static ?string $model = Income::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('source')->label('Source'),
            ExportColumn::make('amount')->label('Amount'),
            ExportColumn::make('received_date')->label('Received Date'),
            ExportColumn::make('category.name')->label('Category'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'Your income export has completed and '
            . number_format($export->successful_rows)
            . ' ' . str('row')->plural($export->successful_rows)
            . ' exported.';
    }
}
