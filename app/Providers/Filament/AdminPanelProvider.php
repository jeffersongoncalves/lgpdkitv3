<?php

namespace App\Providers\Filament;

use AchyutN\FilamentLogViewer\FilamentLogViewer;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use JeffersonGoncalves\Filament\Admin\AdminPlugin;
use JeffersonGoncalves\Filament\Admin\Pages\Auth\Login;
use JeffersonGoncalves\Filament\Lgpd\LgpdPlugin;
use JeffersonGoncalves\Filament\LgpdAuditLog\LgpdAuditLogPlugin;
use JeffersonGoncalves\Filament\LgpdConsent\LgpdConsentPlugin;
use JeffersonGoncalves\Filament\LgpdDsar\LgpdDsarPlugin;
use JeffersonGoncalves\Filament\LgpdIncidents\LgpdIncidentsPlugin;
use JeffersonGoncalves\Filament\LgpdMinors\LgpdMinorsPlugin;
use JeffersonGoncalves\Filament\LgpdRecords\LgpdRecordsPlugin;
use JeffersonGoncalves\Filament\LgpdRetention\LgpdRetentionPlugin;
use JeffersonGoncalves\Filament\LgpdRipd\LgpdRipdPlugin;
use JeffersonGoncalves\Filament\LgpdTakedown\LgpdTakedownPlugin;
use JeffersonGoncalves\Filament\LgpdVendors\LgpdVendorsPlugin;
use JeffersonGoncalves\Filament\Pwa\FilamentPwaPlugin;
use JeffersonGoncalves\Filament\SecurityHeaders\SecurityHeadersPlugin;
use JeffersonGoncalves\Filament\User\UserPlugin;
use JeffersonGoncalves\SecurityHeaders\Middleware\SecurityHeaders;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->authGuard('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandLogo(fn () => Vite::asset(config('lgpdkit.logo')))
            ->brandLogoHeight(fn () => request()->is('admin/login', 'admin/password-reset/*') ? '121px' : '50px')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->defaultThemeMode(config('lgpdkit.theme_mode', ThemeMode::Dark))
            ->discoverClusters(in: app_path('Filament/Admin/Clusters'), for: 'App\\Filament\\Admin\\Clusters')
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                SecurityHeaders::class,
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
            ])
            ->navigationGroups([
                __('User'),
                __('Management'),
                __('LGPD'),
                __('Settings'),
            ])
            ->plugins([
                SecurityHeadersPlugin::make()
                    ->navigationGroup(fn (): string => __('Settings')),
                AdminPlugin::make(),
                LgpdPlugin::make()
                    ->navigationGroup('LGPD'),
                LgpdConsentPlugin::make()
                    ->navigationGroup('LGPD'),
                LgpdDsarPlugin::make()
                    ->navigationGroup('LGPD'),
                LgpdRetentionPlugin::make()
                    ->navigationGroup('LGPD'),
                LgpdAuditLogPlugin::make()
                    ->navigationGroup('LGPD'),
                LgpdIncidentsPlugin::make()
                    ->navigationGroup('LGPD'),
                LgpdRecordsPlugin::make()
                    ->navigationGroup('LGPD'),
                LgpdVendorsPlugin::make()
                    ->navigationGroup('LGPD'),
                LgpdRipdPlugin::make()
                    ->navigationGroup('LGPD'),
                LgpdMinorsPlugin::make()
                    ->navigationGroup('LGPD'),
                LgpdTakedownPlugin::make()
                    ->navigationGroup('LGPD'),
                UserPlugin::make(),
                FilamentPwaPlugin::make(),
                FilamentLogViewer::make()
                    ->navigationGroup(__('Settings')),
                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle(__('My Profile'))
                    ->setNavigationLabel(__('My Profile'))
                    ->setNavigationGroup(__('Group Profile'))
                    ->setIcon('heroicon-o-user')
                    ->setSort(10)
                    ->shouldRegisterNavigation(false)
                    ->shouldShowEmailForm()
                    ->shouldShowSanctumTokens()
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm(),
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn (): string => __('My Profile'))
                    ->url(fn (): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle'),
            ])
            ->unsavedChangesAlerts()
            ->passwordReset()
            ->profile()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s');
    }
}
