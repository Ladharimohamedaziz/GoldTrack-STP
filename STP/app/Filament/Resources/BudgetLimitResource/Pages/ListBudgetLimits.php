<?php

namespace App\Filament\Resources\BudgetLimitResource\Pages;

use App\Filament\Resources\BudgetLimitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBudgetLimits extends ListRecords
{
    protected static string $resource = BudgetLimitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
