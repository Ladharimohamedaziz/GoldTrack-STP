<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\UserMenuItem;
use App\Filament\Pages\Chatbot;
use Filament\Facades\Filament;

use Filament\Navigation\MenuItem;



use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;

class AdminPanelProvider extends PanelProvider
{
    public function boot(): void {}
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->profile()
            // ->brandTheme('resources/css/filament/admin/theme.css')
            ->userMenuItems([
            'profile' => MenuItem::make('profile')
                ->label(fn () => \Illuminate\Support\Facades\Auth::user()?->name ?? 'Profile'),
        ])
            ->path('admin')
            // ->favicon('https://www.google.com/favicon.ico')
            ->path('admin')
            ->authMiddleware(['auth'])
            ->middleware([
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            ])
            ->authMiddleware(['auth']) // bich ta7mi beha 
            ->font('Poppins')
            ->brandLogo(asset('GoldTrackWhite.png'))
            ->brandLogoHeight('3rem')
            ->colors([
                'primary' => '#C8AA6E',
                'secondary' => '#4ade80',
                'success' => '#4ade80',
                'danger' => '#f87171',
                'warning' => '#facc15',
                'info' => '#60a5fa',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([])
            ->widgets([
                \App\Filament\Widgets\FinancialCards::class,
                \App\Filament\Widgets\MonthlyFinanceChart::class,
                \App\Filament\Widgets\CategoryBudgetChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}