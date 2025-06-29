<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class BudgetChart extends ChartWidget
{
    protected static ?string $heading = 'Traffic by Device';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Spending',
                    'data' => [12, 19, 3, 5, 2, 3],
                    'backgroundColor' => ['#4ade80', '#facc15', '#f87171', '#60a5fa', '#c084fc', '#f87171'],
                ],
            ],
            'labels' => ['M', 'T', 'W', 'T', 'F', 'S'],
        ];
    }
    protected function getType(): string
    {
        return 'bar';
    }
}
