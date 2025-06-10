<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\LoginCustom;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Enums\ThemeMode;
use Nuxtifyts\DashStackTheme\DashStackThemePlugin;
use Awcodes\LightSwitch\LightSwitchPlugin;
use TomatoPHP\FilamentMenus\FilamentMenus\FilamentMenusPlugin;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use DiogoGPinto\AuthUIEnhancer\AuthUIEnhancerPlugin;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Blade;
use Orion\FilamentBackup\BackupPlugin;
use Orion\FilamentGreeter\GreeterPlugin;
use Orion\FilamentFeedback\FeedbackPlugin;
use Orion\FilamentSettings\SettingsPlugin;
use Orion\FilamentSupport\FilamentSupportPlugin;
use Asmit\ResizedColumn\ResizedColumnPlugin;
use CWSPS154\UsersRolesPermissions\UsersRolesPermissionsPlugin;
use Filament\Widgets\Widget;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()

            /* Lightswitch */
            ->plugins([
                LightSwitchPlugin::make(),
                ResizedColumnPlugin::make()->preserveOnDB(),
            ])

            /* Icon Replacement */
            // ->plugin(\Filafly\PhosphorIconReplacement::make())

            /* Dash UI */
            ->plugin(DashStackThemePlugin::make())
            ->id('admin')
            ->path('admin')
            ->login(LoginCustom::class)

            /* Menus */
            ->passwordReset()
            ->registration() // Enable registration
            ->spa()
            ->profile(isSimple: false)
            ->sidebarFullyCollapsibleOnDesktop()
            ->maxContentWidth(MaxWidth::Full)
            ->brandLogo(asset('images/aiweb.png'))
            ->favicon(asset('images/aiweb.png'))
            ->brandName('Audemars')
            ->font('Poppins')
            ->defaultThemeMode(ThemeMode::Light)
            ->colors([
                'primary' => Color::Yellow,
                // 'danger' => Color::Rose,
                // 'gray' => Color::Gray,
                // 'info' => Color::Blue,
                // 'success' => Color::Emerald,
                // 'warning' => Color::Orange,
            ])

            /* Vite */
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ])

            /* Theme */
            ->middleware([
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class
            ])
            ->tenantMiddleware([
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class
            ])
        ;
    }
}
