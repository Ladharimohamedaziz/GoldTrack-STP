<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentColor;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}
    public function boot(): void
    {
        FilamentColor::register([
            'primary' => '#16a34a',
        ]);
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['ar', 'en', 'fr']); 
        });
    }
}
