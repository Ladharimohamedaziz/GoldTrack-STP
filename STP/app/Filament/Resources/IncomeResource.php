<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Models\Income;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Imports\ExpenseImporter;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFileFormat;

// use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;


use App\Filament\Imports\IncomeImporter;

use App\Filament\Exports\IncomeExporter;
class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    // protected static ?string $navigationGroup = 'Finance Management';
    




//   protected static ?string $navigationGroup = null;

//     // override getHeading() بطريقة non-static
//     public function getHeading(): ?string
//     {
//         return __('lang.finance_management');
//     }



    
    // public static function getNavigationLabel(): string
    // {
    //     return __('lang.income');
    // }
    // public static function getModelLabel(): string
    // {
    //     return __('lang.incomes');
    // }


public static function getNavigationLabel(): string
{
    return __('lang.incomes'); // النص بالعربي مباشرة، مثلا "المداخيل"
}

public static function getModelLabel(): string
{
    return __('lang.incomes'); // النص المفرد بالعربي، مثلا "مصروف"
}

public static function getPluralModelLabel(): string
    {
        return __('lang.incomes'); // plural
    }

    // public static function getNavigationGroup(): ?string
    // {
    //     return __('lang.finance_management');
    // }



    // public static function getPluralModelLabel(): string
    // {
    //     return __('lang.incomes');
    // }
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Hidden::make('user_id')
                // ->default(fn () => Filament::auth()->id())
                ->default(fn() => auth()->guard('web')->id())
                ->dehydrated(),
            Select::make('category_id')
                ->label(__('lang.goal_fields.Category'))
                ->relationship(
                    name: 'category',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn($query) => $query
                        ->where('type', 'incomes')
                        ->where('user_id', Filament::auth()->id())
                )
                ->required(),
            TextInput::make('source')
                ->required()
                ->maxLength(255),
            TextInput::make('amount')
                ->label(__('lang.goal_fields.amount'))
                ->numeric()
                ->required(),
            DatePicker::make('received_date')
                ->label(__('lang.goal_fields.received_date'))
                ->default(now())
                ->required(),
        ]);
    }
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->headerActions([
            ImportAction::make()
                ->importer(IncomeImporter::class),
            ExportAction::make()
                ->exporter(IncomeExporter::class)
                ->formats([
                    ExportFormat::Csv,
                    ]),
])


            ->columns([
                TextColumn::make('source')->searchable(),
                TextColumn::make('amount')
                    ->label(__('lang.goal_fields.amount'))
                    ->money('TND', true),
                TextColumn::make('received_date')
                    ->label(__('lang.goal_fields.received_date'))
                    ->date(),
                TextColumn::make('category.name')
                    ->label(__('lang.goal_fields.Category'))
            ])->actions([
                Tables\Actions\EditAction::make(),
            ])->bulkActions([
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
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
        ];
    }
}
