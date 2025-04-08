<?php

namespace App\Filament\AdminPanel\Pages;

use Filament\Pages\Page;
use App\Models\User;
use App\Models\Car;
use Illuminate\Support\Carbon;

class OpvallendeAanbieders extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static string $view = 'filament.admin-panel.pages.opvallende-aanbieders';
    protected static ?string $title = 'Opvallende Aanbieders';
    protected static ?string $navigationGroup = 'Beheer';

    public $suspiciousUsers;

    public function mount(): void
    {
        $this->suspiciousUsers = User::with(['cars' => fn ($q) => $q->withTrashed()->with('tags')])->get()->filter(function ($user) {
            $cars = $user->cars;

            $noPhone = empty($user->phone);

            $ageMileageMismatch = $cars->filter(fn ($car) =>
                $car->production_year && $car->production_year < now()->year - 10 &&
                $car->mileage && $car->mileage < 50000
            )->isNotEmpty();

            $rapidSales = $cars->filter(fn ($car) =>
                    $car->created_at->isToday() &&
                    $car->sold_at && $car->sold_at->isToday() &&
                    $car->price > 10000
                )->count() > 3;

            $onlyCheap = $cars->isNotEmpty() && $cars->every(fn ($car) => $car->price < 1000);

            $noTags = $cars->every(fn ($car) => $car->tags->isEmpty());

            $noRecentActivity = $cars->where('created_at', '>=', now()->subYear())->isEmpty();

            return $noPhone || $ageMileageMismatch || $rapidSales || $onlyCheap || $noTags || $noRecentActivity;
        });
    }
}
