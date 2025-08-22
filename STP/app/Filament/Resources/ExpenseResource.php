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
use App\Filament\Imports\ExpenseImporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use App\Filament\Exports\ExpenseExporter;
use Filament\Actions\Exports\Enums\ExportFormat;

class ExpenseResource extends Resource
{
    protected static ?string $model = \App\Models\Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function getNavigationLabel(): string
    {
        return __('lang.Expense');
    }
    public static function getModelLabel(): string
    {
        return __('lang.Expense');
    }

    public static function getPluralModelLabel(): string
    {
        return __('lang.expenses'); // plural
    }


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Hidden::make('user_id')
                // ->default(fn() => Filament::auth()->id())
                ->default(fn() => auth()->guard('web')->id())
                ->dehydrated(),
            Select::make('category_id')->label(__('lang.goal_fields.Category'))

                ->relationship('category', 'name')
                ->required(),
            Select::make('budget_limit_id')->label(__('lang.goal_fields.budget_limit'))
                ->relationship('budgetLimit', 'name')
                ->required(),
            TextInput::make('name')->label(__('lang.goal_fields.name'))->required(),
            // TextInput::make('amount')->numeric()->required(),
            TextInput::make('amount')->label(__('lang.goal_fields.amount'))
                ->prefix('TND')
                ->numeric()
                ->required()
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

            DatePicker::make('start_date')->label(__('lang.goal_fields.start_date'))->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->headerActions([
                ImportAction::make()
                    ->importer(ExpenseImporter::class),
                ExportAction::make()
                    ->exporter(ExpenseExporter::class)
                    ->formats([
                        ExportFormat::Csv,

                    ])
                    // ->queue(),
            ])



            ->columns([
                TextColumn::make('name')->label(__('lang.goal_fields.name'))
                    ->searchable(),
                TextColumn::make('category.name')->label(__('lang.goal_fields.Category')),
                TextColumn::make('budgetLimit.name')->label(__('lang.goal_fields.budget_limit')),
                TextColumn::make('amount')->label(__('lang.goal_fields.amount'))->money('TND'),
                TextColumn::make('start_date')->label(__('lang.goal_fields.start_date'))->date(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
