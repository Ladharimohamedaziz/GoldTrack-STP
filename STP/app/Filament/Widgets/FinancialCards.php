<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Goal;

class FinancialCards extends BaseWidget
{
    protected function getStats(): array
    {
        $income = Income::where('received_date', '>=', now()->subYears(3))->sum('amount');
        $expenses = Expense::sum('amount');
        $netProfit = $income - $expenses;
        $goal = Goal::sum('amount');
     
        $netProfitColor = match (true) {
            $netProfit < 0 => 'danger',
            $netProfit === 0 => 'primary',
            $netProfit >= 1 => 'success',
            default => 'warning',
        };

        $incomeColor = match (true) {
            $income < 0 => 'danger',
            $income === 0 => 'primary',
            $income >= 1 => 'success',
            default => 'warning',
        };


        $expensesColor = match (true) {
            $expenses < 0 => 'danger',
            $expenses === 0 => 'primary',
            $expenses >= 1 => 'success',
            default => 'warning',
        };

        $netProfitIcon = match ($netProfitColor) {
            'success' => 'heroicon-o-check-circle',
            'primary' => 'heroicon-o-information-circle',
            'danger' => 'heroicon-o-x-circle',
            'warning' => 'heroicon-o-exclamation-triangle',
        };

        return [
            Stat::make('Total Income', number_format($income, 2) . ' TND')
                ->color($incomeColor)
                ->description('Sur 1 ans')
                ->descriptionIcon('heroicon-o-banknotes'),

            Stat::make('Total Expenses', number_format($expenses, 2) . ' TND')
                ->color($expensesColor)
                ->description('Toutes les dépenses')
                ->descriptionIcon('heroicon-o-credit-card'),

            Stat::make('Net Profit', number_format($netProfit, 2) . ' TND')
                ->color($netProfitColor)
                ->description('Revenu net')
                ->descriptionIcon($netProfitIcon),

            Stat::make('Goal', number_format($goal, 2) . ' TND')
                ->description('Objectifs financiers')
                ->descriptionIcon('heroicon-o-flag'),

       
        ];
    }
}


// namespace App \Filament\Widgets;

// use Filament\Widgets\StatsOverviewWidget as BaseWidget;
// use Filament\Widgets\StatsOverviewWidget\Stat;
// use App\Models\Income;
// use App\Models\Expense;
// use App\Models\Goal; 

// class FinancialCards extends BaseWidget
// {
//     protected function getStats(): array
//     {
//         $income = Income::where('received_date', '>=', now()->subYears(3))->sum('amount');
//         $expenses = Expense::sum('amount');
//         $netProfit = $income - $expenses;
//         $goal = Goal::sum('amount');


//         return [
//             Stat::make('Total Income ', number_format($income, 2) . ' TND'),
//             Stat::make('Total Expenses', number_format($expenses, 2) . ' TND'),
//             Stat::make('Net Profit', number_format($netProfit, 2) . ' TND')
//                 ->color($netProfit >= 0 ? 'success' : 'danger'),
//             Stat::make('Goal', number_format($goal, 2) . ' TND'),
//         ];
//     }
// }
