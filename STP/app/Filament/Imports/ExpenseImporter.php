<?php

namespace App\Filament\Imports;

use App\Models\Expense;
use App\Models\Category;
use App\Models\BudgetLimit;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ExpenseImporter extends Importer
{
    protected static ?string $model = Expense::class;
    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')->rules(['required', 'string']),
            ImportColumn::make('amount')->rules(['required', 'numeric']),
            ImportColumn::make('start_date')->rules(['required', 'date']),
            // نحطوا علاقة بالاسم باش يجيب ID الصحيح
            ImportColumn::make('category_name')
                ->relationship('category', 'name')
                ->rules(['required', 'string']),

            ImportColumn::make('budget_name')
                ->relationship('budgetLimit', 'name')
                ->rules(['required', 'string']),
        ];
    }


    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your expense import has completed and '
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

    public function resolveRecord(): ?Expense
    {

        $categoryId = Category::where('name', $this->data['category_name'])->first()?->id;
        $budgetId = BudgetLimit::where('name', $this->data['budget_name'])->first()?->id;

        $expense = new Expense([
            'user_id' => auth()->guard('web')->id() ?? 1, // المستخدم الحالي أو 1 للمختبر
            'name' => $this->data['name'],
            'amount' => $this->data['amount'],
            'start_date' => $this->data['start_date'],
            'category_id' => $categoryId,
            'budget_limit_id' => $budgetId,
            // 'category_id' => $this->data['category_name'], // سيجيب ID من relationship
            // 'budget_limit_id' => $this->data['budget_name'], // سيجيب ID من relationship
        ]);

    

        // $expense->save(); // force save
        return $expense;
    }
}
