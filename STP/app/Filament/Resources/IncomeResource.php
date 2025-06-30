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

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Finance Management';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Hidden::make('user_id')
                ->default(fn () => Filament::auth()->id())
                ->dehydrated(),

            Select::make('category_id')
                ->label('Category')
                ->relationship(
                    name: 'category',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query
                        ->where('type', 'incomes')
                        ->where('user_id', Filament::auth()->id())
                )
                ->required(),

            TextInput::make('source')
                ->required()
                ->maxLength(255),

            TextInput::make('amount')
                ->numeric()
                ->required(),

            DatePicker::make('received_date')->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('source')->searchable(),
            TextColumn::make('amount')->money('TND', true),
            TextColumn::make('received_date')->date(),
            TextColumn::make('category.name')->label('Category'),
        ])->actions([
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
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
