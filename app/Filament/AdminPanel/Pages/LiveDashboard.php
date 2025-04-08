<?php

namespace App\Filament\AdminPanel\Pages;

use App\Models\Car;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Carbon;

class LiveDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $title = 'Live Dashboard';
    protected static string $view = 'filament.admin-panel.pages.live-dashboard';
    protected static ?string $navigationGroup = 'Dashboard';

    public function getViewData(): array
    {
        $today = Carbon::today();

        $totalCars = Car::count();
        $totalSold = Car::whereNotNull('sold_at')->count();
        $carsToday = Car::whereDate('created_at', $today)->count();
        $viewsToday = Car::whereDate('updated_at', $today)->sum('views');
        $totalUsers = User::count();
        $avgCarsPerUser = $totalUsers > 0 ? number_format($totalCars / $totalUsers, 2) : 0;

        return [
            'stats' => [
                'Totaal aanbod' => $totalCars,
                'Verkocht' => $totalSold,
                'Vandaag aangeboden' => $carsToday,
                'Aanbieders' => $totalUsers,
                'Views vandaag' => $viewsToday,
                'Gemiddeld per aanbieder' => $avgCarsPerUser,
            ],
        ];
    }

}
