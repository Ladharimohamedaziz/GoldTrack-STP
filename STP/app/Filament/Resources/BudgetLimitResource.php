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
     public static function getNavigationLabel(): string
    {
        return __('lang.expense_limit');
    }
    public static function getModelLabel(): string
    {
        return __('lang.expense_limit');
    }


public static function getPluralModelLabel(): string
    {
        return __('lang.expense_limits'); // plural
    }
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Hidden::make('user_id')
                ->default(fn() => auth()->guard('web')->id()) 
                ->dehydrated(), 
            TextInput::make('name')->label(__('lang.goal_fields.name'))->required(),
            Select::make('period')->label(__('lang.goal_fields.period'))->options(['month' => 'Monthly', 'year' => 'Yearly'])->required(),
            TextInput::make('amount')->label(__('lang.goal_fields.amount'))->numeric()->required()->prefix('TND'),
        ]);
    }
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('lang.goal_fields.name'))->searchable(),
                TextColumn::make('period')->label(__('lang.goal_fields.period'))->searchable(),
                TextColumn::make('amount')->label(__('lang.goal_fields.amount'))->money('TND'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

      public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->guard('web')->id());
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
