<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
       
    }
    public function boot(): void
    {
        FilamentColor::register([
        'primary' => '#16a34a', 
    ]);
    }
}

