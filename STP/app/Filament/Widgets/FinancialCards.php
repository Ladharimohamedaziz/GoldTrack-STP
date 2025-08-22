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
        // نجيب الـ user الحالي
        $userId = auth()->guard('web')->check() ? auth()->guard('web')->id() : null;

        // إجمالي الدخل
        $income = Income::where('user_id', $userId)
            ->where('received_date', '>=', now()->subYears(3))
            ->sum('amount');

        // إجمالي المصاريف
        $expenses = Expense::where('user_id', $userId)
            ->sum('amount');

        // صافي الربح
        $netProfit = $income - $expenses;

        // إجمالي الأهداف المالية
        $goal = Goal::where('user_id', $userId)
            ->sum('amount');

        // تحديد الألوان حسب القيمة
        $netProfitColor = match (true) {
            $netProfit < 0 => 'danger',
            $netProfit === 0 => 'primary',
            $netProfit > 0 => 'success',
        };

        $incomeColor = $income > 0 ? 'success' : ($income === 0 ? 'primary' : 'danger');
        $expensesColor = $expenses > 0 ? 'success' : ($expenses === 0 ? 'primary' : 'danger');

        // أيقونات صافي الربح
        $netProfitIcon = match ($netProfitColor) {
            'success' => 'heroicon-o-check-circle',
            'primary' => 'heroicon-o-information-circle',
            'danger' => 'heroicon-o-x-circle',
        };

        return [
            Stat::make('Total Income', number_format($income, 2) .__('lang.currency'))
                ->icon('heroicon-o-banknotes')
                
                ->color($incomeColor)
                ->label(__('lang.Total Income'))
                // ->description('Sur 3 ans')
                ->descriptionIcon('heroicon-o-banknotes'),

            Stat::make('Total Expenses', number_format($expenses, 2).__('lang.currency'))
                ->icon('heroicon-o-credit-card')
                ->color($expensesColor)
                ->description('Toutes les dépenses')
                ->description(__('lang.toutes les dépenses'))
                ->label(__('lang.Total Expenses'))
                ->descriptionIcon('heroicon-o-credit-card'),

            Stat::make('Net Profit', number_format($netProfit, 2).__('lang.currency'))
                ->icon($netProfitIcon)    
            ->color($netProfitColor)
                ->label(__('lang.Net Profit'))
                ->description('Revenu net')
                ->description(__('lang.Revenu net'))
                ->descriptionIcon($netProfitIcon),

            Stat::make('Goal', number_format($goal, 2) .__('lang.currency'))
                ->icon('heroicon-o-flag')
                ->description('Objectifs financiers')
                ->description(__('lang.Objectifs financiers'))
                ->color('info')
                ->label(__('lang.Goal'))    
                ->descriptionIcon('heroicon-o-flag'),
        ];
    }
}
