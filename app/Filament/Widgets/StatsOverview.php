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
            Stat::make('Total Customers', Customer::count())
                ->description('Total registered customers')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Sales', $totalSales)
                ->description('Total number of sales')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'),

            Stat::make('Total Revenue', number_format($totalRevenue, 2))
                ->description('Total revenue from sales')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

        ];
    }
} 