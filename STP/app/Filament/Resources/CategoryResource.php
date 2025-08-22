<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\FileUpload;
use Filament\Tables;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions;
use App\Filament\Resources\CategoryResource\Pages;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;

class CategoryResource extends Resource
{

    protected static ?string $model = \App\Models\Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack'; // Categories

 public static function getNavigationLabel(): string
    {
        return __('lang.Categories');
    }
    public static function getModelLabel(): string
    {
        return __('lang.Categories');
    }

    public static function getPluralModelLabel(): string
    {
        return __('lang.Categories'); // plural
    }

    
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
             Hidden::make('user_id')
            ->default(fn() => auth()->guard('web')->check() ? auth()->guard('web')->id() : null)
            ->dehydrated(),
            TextInput::make('name')->label(__('lang.goal_fields.name'))->required(),
            // TextInput::make('icon')->label('Icon Path')->nullable(),
            FileUpload::make('icon')->label(__('lang.goal_fields.Icon'))
                ->image()
                ->disk('public')
                ->directory('category-icons'),
            Select::make('type')->options(['incomes' => 'Incomes', 'expenses' => 'Expenses'])->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('lang.goal_fields.name'))->searchable(),
                TextColumn::make('type'),
                // TextColumn::make('icon'),
                ImageColumn::make('Icon')->label(__('lang.goal_fields.Icon'))
                    ->disk('public')
                    ->circular(),
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
        ->where('user_id', auth()->guard('web')->check() ? auth()->guard('web')->id() : 0);
}

    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
