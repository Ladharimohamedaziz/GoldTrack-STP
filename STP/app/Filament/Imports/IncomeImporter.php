<?php

namespace App\Filament\Imports;

use App\Models\Income;
use App\Models\Category;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;



class IncomeImporter extends Importer
{
    protected static ?string $model = Income::class;

    public static function getColumns(): array
    {
        return [
            // ImportColumn::make('name')->rules(['required', 'string']),
            ImportColumn::make('source')->rules(['required', 'string']),
            ImportColumn::make('amount')->rules(['required', 'numeric']),
            ImportColumn::make('received_date')->rules(['required', 'date']),
            ImportColumn::make('category_name')
                ->relationship('category', 'name')
                ->rules(['required', 'string']),
        ];
    }
    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your income import has completed and '
            . number_format($import->successful_rows)
            . ' ' . str('row')->plural($import->successful_rows)
            . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount)
                . ' ' . str('row')->plural($failedRowsCount)
                . ' failed to import.';
        }
        return $body;
    }
    public function resolveRecord(): ?Income
    {
        $categoryId = Category::where('name', $this->data['category_name'])->first()?->id;

        $income = new Income([
            'user_id' => auth()->guard('web')->id() ?? 1,
            // 'name' => $this->data['name'],
            'source' => $this->data['source'],
            'amount' => $this->data['amount'],
            'received_date' => $this->data['received_date'],
            'category_id' => $categoryId,
        ]);
        $income->save(); // حفظ مباشر
        return $income;
    }
}
