<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Category;
use App\Models\Expense;
use App\Models\BudgetLimit;
use Illuminate\Support\Facades\Auth;

class CategoryBudgetChart extends ChartWidget
{
    protected static ?string $heading = 'Dépenses par Budget';

    protected function getData(): array
    {
      $categories = Category::with('expenses.budgetLimit')
    ->where('user_id', auth()->guard('web')->check() ? auth()->guard('web')->id() : null)
    ->get();

        $labels = [];
        $spent = [];
        $limits = [];

        foreach ($categories as $category) {
            // Prendre le premier budget limit utilisé par cette catégorie
            $budgetNames = $category->expenses->map(function ($expense) {
                return optional($expense->budgetLimit)->name;
            })->filter()->unique();

            // S'il y a plusieurs budgets liés à cette catégorie
            $label = $budgetNames->count() === 1
                ? $budgetNames->first()
                : $category->name . ' ' . $budgetNames->implode(', ') . '';

            $labels[] = $label;

            $totalSpent = $category->expenses->sum('amount');
            $spent[] = $totalSpent;

            $limit = $category->expenses->map(function ($expense) {
                return optional($expense->budgetLimit)->amount ?? 0;
            })->unique()->sum();
            $limits[] = $limit;
        }
        return [
            'datasets' => [
                [
                    'label' => 'Dépensé',
                    'data' => $spent,
                    'backgroundColor' => 'rgba(255, 205, 86, 0.8)', // Jaune
                ],
                [
                    'label' => 'Limite du budget',
                    'data' => $limits,
                    'backgroundColor' => 'rgba(75, 192, 75, 0.6)',
                    'borderColor' => 'rgba(75, 192, 80, 1)',
                ],
            ],
            'labels' => $labels,
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
