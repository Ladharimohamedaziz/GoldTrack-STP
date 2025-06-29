<?php

namespace App\Filament\Resources\BudgetLimitResource\Pages;

use App\Filament\Resources\BudgetLimitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBudgetLimit extends EditRecord
{
    protected static string $resource = BudgetLimitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
