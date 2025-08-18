<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Income;
use App\Models\Expense;
use Carbon\Carbon;

class MonthlyFinanceChart extends ChartWidget
{
    protected static ?string $heading = 'Revenue vs Expenses (Monthly)';

    protected function getData(): array
    {
        // 🗓 Generate the last 12 months
        $months = collect(range(11, 0))->map(function ($i) {
            return Carbon::now()->startOfMonth()->subMonths($i);
        });

        // 👤 user actuel
        $userId = auth()->guard('web')->check() ? auth()->guard('web')->id() : null;

        // 📊 Income data per month
        $incomeData = $months->map(function ($monthCarbon) use ($userId) {
            $startOfMonth = $monthCarbon->format('Y-m-d');
            $endOfMonth = $monthCarbon->copy()->endOfMonth()->format('Y-m-d');

            return Income::where('user_id', $userId)
                        ->whereBetween('received_date', [$startOfMonth, $endOfMonth])
                        ->sum('amount');
        });

        // 📊 Expense data per month
        $expenseData = $months->map(function ($monthCarbon) use ($userId) {
            $startOfMonth = $monthCarbon->format('Y-m-d');
            $endOfMonth = $monthCarbon->copy()->endOfMonth()->format('Y-m-d');

            return Expense::where('user_id', $userId)
                        ->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                        ->sum('amount');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $incomeData,
                    'backgroundColor' => 'rgba(75, 192, 75, 0.6)',
                    'borderColor' => 'rgba(75, 192, 80, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Expenses',
                    'data' => $expenseData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.6)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $months->map(fn($monthCarbon) => $monthCarbon->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}
