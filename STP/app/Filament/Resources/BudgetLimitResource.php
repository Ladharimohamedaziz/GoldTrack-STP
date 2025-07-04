<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Tables;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions;

use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\BudgetLimitResource\Pages;
use App\Filament\Resources\BudgetLimitResource\Pages\ListBudgetLimits;
use App\Filament\Resources\BudgetLimitResource\Pages\CreateBudgetLimit;
use App\Filament\Resources\BudgetLimitResource\Pages\EditBudgetLimit;

class BudgetLimitResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar'; // Budget Limit
    protected static ?string $model = \App\Models\BudgetLimit::class;
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Hidden::make('user_id')
                ->default(fn() => Filament::auth()->id())
                ->dehydrated(),
            TextInput::make('name')->required(),
            Select::make('period')->options(['month' => 'Monthly', 'year' => 'Yearly'])->required(),
            TextInput::make('amount')->numeric()->required()->prefix('TND'),
        ]);
    }
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('period'),
                TextColumn::make('amount')->money('TND'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBudgetLimits::route('/'),
            'create' => Pages\CreateBudgetLimit::route('/create'),
            'edit' => Pages\EditBudgetLimit::route('/{record}/edit'),
        ];
    }
}
