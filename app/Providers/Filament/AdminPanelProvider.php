<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')

            // Gate: hanya boleh diakses user yang is_admin = true
            ->authGuard('web')
            ->authorize(fn () => auth()->check() && auth()->user()->is_admin)

            ->login() // setup login page
            ->passwordReset() // setup reset password page

            ->colors([
                'primary' => Color::Amber,
            ])

            // Navigation (Filament auto detect resources later)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')

            // Widgets
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')

            ->assets([])

            // Middleware standar
            ->middleware([
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ])

            ->authMiddleware([
                \Filament\Http\Middleware\Authenticate::class,
            ]);
    }
}
