<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSales = Sale::count();
        $totalRevenue = Sale::sum('total_amount');
        $averageOrderValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        return [
            Stat::make(__('filament.resources.customers.plural_label'), Customer::count())
                ->description(__('filament.resources.customers.description'))
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make(__('filament.resources.sales.plural_label'), $totalSales)
                ->description(__('filament.resources.sales.description'))
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            Stat::make(__('filament.resources.sales.total_revenue'), number_format($totalRevenue, 2))
                ->description(__('filament.resources.sales.total_revenue_description'))
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

        ];
    }
} 