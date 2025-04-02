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
        \App\Models\User::factory(150)->create()->each(function ($user) {
            Car::factory(rand(1, 5))->create([
                'user_id' => $user->id,
            ])->each(function ($car) {
                $tags = Tag::inRandomOrder()->take(rand(1, 4))->pluck('id');
                $car->tags()->attach($tags);
            });
        });

        $tags = ['sportief', 'zuinig', 'elektrisch', 'gezinswagen', 'nieuwstaat', 'automaat', 'offroad', 'hybride', 'compact', 'luxueus', 'occasion', 'budget', 'robuust', 'luxe', 'eco', 'diesel', 'benzine', 'suv', 'hatchback', 'sedan'];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(['name' => $tagName]);
        }
    }
}
