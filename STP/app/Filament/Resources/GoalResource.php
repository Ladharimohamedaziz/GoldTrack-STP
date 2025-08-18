<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoalResource\Pages;

use App\Filament\Resources\GoalResource\Pages\ListGoals;
use App\Filament\Resources\GoalResource\Pages\CreateGoal;
use App\Filament\Resources\GoalResource\Pages\EditGoal;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

use Filament\Facades\Filament;

class GoalResource extends Resource
{
    protected static ?string $model = \App\Models\Goal::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';

    public static function getNavigationLabel(): string
    {
        return __('lang.goal');
    }
    public static function getModelLabel(): string
    {
        return __('lang.goal');
    }


    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            // Hidden::make('user_id')
            //     // ->default(fn() => Filament::auth()->id())
            //     ->default(fn() => auth()->guard('web')->id()) 
            //     ->dehydrated(),
            Hidden::make('user_id')
                ->default(fn() => auth()->guard('web')->check() ? auth()->guard('web')->id() : null)
                ->dehydrated(),

            TextInput::make('name')
                ->label(__('lang.goal_fields.name'))
                ->required(),
            TextInput::make('note')->nullable(),
            TextInput::make('amount')
                ->label(__('lang.goal_fields.amount'))
                ->numeric()->prefix('TND')->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('lang.goal_fields.name'))
                    ->searchable(),
                TextColumn::make('amount')->label(__('lang.goal_fields.amount'))
                    ->money('TND')
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
        // dd(auth()->guard('web')->id());

        return parent::getEloquentQuery()
            ->where('user_id', auth()->guard('web')->id());
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGoals::route('/'),
            'create' => Pages\CreateGoal::route('/create'),
            'edit' => Pages\EditGoal::route('/{record}/edit'),
        ];
    }
}
