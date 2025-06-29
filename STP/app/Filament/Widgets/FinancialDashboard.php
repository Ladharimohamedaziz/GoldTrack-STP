<?php


namespace App\Filament\Widgets;

use App\Models\Budget;
use App\Models\Expense;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class FinancialDashboard extends BaseWidget
{
    protected function getCards(): array
    {
    
        $totalIncome = Budget::sum('amount');

    
        $totalExpenses = Expense::sum('amount');


        $netBalance = $totalIncome - $totalExpenses;

        return [
            Card::make('Total Income', '$' . number_format($totalIncome, 2))
                ->description('This month')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Card::make('Total Expenses', '$' . number_format($totalExpenses, 2))
                ->description('This month')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger'),

            Card::make('Net Balance', '$' . number_format($netBalance, 2))
                ->description('Remaining')
                ->color('primary'),
        ];
    }
}

