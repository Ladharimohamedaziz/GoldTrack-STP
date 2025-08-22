<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Profile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'filament.pages.profile';

    public function getUser()
    {
        return Auth::user();
    }
}
