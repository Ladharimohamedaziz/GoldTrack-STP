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
        // 🗓 Generate the last 12 months (starting with the oldest month first for chronological order)
        // We get Carbon instances for the start of each month.
        $months = collect(range(11, 0))->map(function ($i) {
            return Carbon::now()->startOfMonth()->subMonths($i);
        });

        // 📊 Income data per month
        $incomeData = $months->map(function ($monthCarbon) {
            // $monthCarbon is already the start of the month (e.g., 2024-01-01)
            $startOfMonth = $monthCarbon->format('Y-m-d');
            // Use copy() to avoid modifying the original Carbon instance in $months
            $endOfMonth = $monthCarbon->copy()->endOfMonth()->format('Y-m-d');

            return Income::whereBetween('received_date', [$startOfMonth, $endOfMonth])->sum('amount');
        });

        // 📊 Expense data per month
        $expenseData = $months->map(function ($monthCarbon) {
            // $monthCarbon is already the start of the month
            $startOfMonth = $monthCarbon->format('Y-m-d');
            // Use copy() to avoid modifying the original Carbon instance in $months
            $endOfMonth = $monthCarbon->copy()->endOfMonth()->format('Y-m-d');

            // !!! IMPORTANT: VERIFY THE DATE FIELD FOR EXPENSES !!!
            // If 'start_date' is not the actual transaction/paid date, change it here.
            // For example: 'transaction_date' or 'paid_at'
            return Expense::whereBetween('start_date', [$startOfMonth, $endOfMonth])->sum('amount');
        });

        // Uncomment this section for debugging if your chart isn't showing data correctly
        /*
        logger([
            'months_generated' => $months->map(fn($month) => $month->format('Y-m'))->toArray(),
            'incomeData_sum' => $incomeData->toArray(),
            'expenseData_sum' => $expenseData->toArray(),
        ]);
        */

        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $incomeData,
                    'backgroundColor' => 'rgba(75, 192, 75, 0.6)', // Vert clair

                    'borderColor' => 'rgba(75, 192, 80, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Expenses',
                    'data' => $expenseData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.6)', // Red
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
            ],
            // Format labels for display (e.g., "Jan 2024", "Feb 2024")
            'labels' => $months->map(fn($monthCarbon) => $monthCarbon->format('M Y'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // This specifies it's a bar chart
    }

    // --- Optional: Add chart options for better presentation ---
    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true, // Crucial for bar charts to accurately compare values
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