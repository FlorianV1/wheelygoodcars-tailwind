<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Car;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'sportief', 'zuinig', 'elektrisch', 'gezinswagen', 'nieuwstaat',
            'automaat', 'offroad', 'hybride', 'compact', 'luxueus',
            'occasion', 'budget', 'robuust', 'luxe', 'eco',
            'diesel', 'benzine', 'suv', 'hatchback', 'sedan'
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(['name' => $tagName]);
        }

        $users = User::factory(150)->create();

        $totalCars = 250;
        $userCount = $users->count();

        $carsPerUser = intdiv($totalCars, $userCount);
        $extraCars = $totalCars % $userCount;

        foreach ($users as $index => $user) {
            $carCount = $carsPerUser + ($index < $extraCars ? 1 : 0); // Spread extras evenly
            Car::factory($carCount)->create(['user_id' => $user->id])->each(function ($car) {
                // Attach 1–4 random tags
                $tagIds = Tag::inRandomOrder()->take(rand(1, 4))->pluck('id');
                $car->tags()->attach($tagIds);
            });
        }
    }
}
