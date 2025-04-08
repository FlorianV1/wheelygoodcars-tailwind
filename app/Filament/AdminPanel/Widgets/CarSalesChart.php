<?php

namespace App\Filament\AdminPanel\Widgets;

use App\Models\Car;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CarSalesChart extends ChartWidget
{
    protected static ?string $heading = 'Verkoop per dag';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $startDate = now()->subDays(14);

        $sales = Car::whereNotNull('sold_at')
            ->where('sold_at', '>=', $startDate)
            ->get()
            ->groupBy(fn ($car) => Carbon::parse($car->sold_at)->format('Y-m-d'));

        $labels = collect();
        $values = collect();

        for ($date = $startDate; $date <= now(); $date->addDay()) {
            $formatted = $date->format('Y-m-d');
            $labels->push($formatted);
            $values->push($sales->has($formatted) ? $sales[$formatted]->count() : 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Aantal verkocht',
                    'data' => $values,
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getPollingInterval(): ?string
    {
        return '10s';
    }
}
