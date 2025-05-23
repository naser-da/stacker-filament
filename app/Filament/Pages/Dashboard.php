<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?int $navigationSort = -2;

    protected static string $view = 'filament.pages.dashboard';

    public static function getNavigationLabel(): string
    {
        return __('filament.navigation.dashboard');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    public function shouldShowFilamentCard(): bool
    {
        return false;
    }
} 