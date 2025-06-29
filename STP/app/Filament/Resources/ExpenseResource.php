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
use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\Pages\ListExpenses;
use App\Filament\Resources\ExpenseResource\Pages\CreateExpense;
use App\Filament\Resources\ExpenseResource\Pages\EditExpense;



class ExpenseResource extends Resource
{
    protected static ?string $model = \App\Models\Expense::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Hidden::make('user_id')
                ->default(fn() => Filament::auth()->id())
                ->dehydrated(),
            Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),
            Select::make('budget_limit_id')
                ->relationship('budgetLimit', 'name')
                ->required(),
            TextInput::make('name')->required(),
            // TextInput::make('amount')->numeric()->required(),
            TextInput::make('amount')
                ->numeric()
                ->required()
                ->label('Amount')
                ->helperText('Do not exceed the allowed budget.')
                ->rules(function (\Filament\Forms\Get $get) {
                    return [
                        function (string $attribute, $value, \Closure $fail) use ($get) {
                            $budgetLimitId = $get('budget_limit_id');
                            $budget = \App\Models\BudgetLimit::find($budgetLimitId);

                            if (! $budget) return;

                            $totalExpenses = \App\Models\Expense::where('budget_limit_id', $budgetLimitId)->sum('amount');

                            if (($totalExpenses + $value) > $budget->amount) {
                                $fail("⚠️ You are over your limit! Max: {$budget->amount}, Current: {$totalExpenses}");
                            }
                        }
                    ];
                }),

            DatePicker::make('start_date')->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('category.name')->label('Category'),
                TextColumn::make('budgetLimit.name')->label('Budget'),
                TextColumn::make('amount')->money('TND'),
                TextColumn::make('start_date')->date(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
