<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse ($this->suspiciousUsers as $user)
            <div class="border p-4 rounded-xl shadow bg-white dark:bg-gray-900">
                <h2 class="font-semibold text-lg text-gray-900 dark:text-white">
                    {{ $user->name }} ({{ $user->email }})
                </h2>

                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Aantal auto's: {{ $user->cars->count() }}
                </p>

                <ul class="mt-2 text-xs text-gray-500 dark:text-gray-400 list-disc list-inside">
                    @php
                        $reasons = [];
                        if (empty($user->phone)) $reasons[] = 'Geen telefoonnummer';
                        if ($user->cars->filter(fn($car) => $car->production_year && $car->production_year < now()->year - 10 && $car->mileage < 50000)->isNotEmpty()) $reasons[] = 'Oud maar lage kilometerstand';
                        if ($user->cars->filter(fn($car) => $car->created_at->isToday() && $car->sold_at && $car->sold_at->isToday() && $car->price > 10000)->count() > 3) $reasons[] = 'Snelle verkoop > €10.000';
                        if ($user->cars->every(fn($car) => $car->price < 1000)) $reasons[] = 'Enkel auto\'s < €1000';
                        if ($user->cars->every(fn($car) => $car->tags->isEmpty())) $reasons[] = 'Geen tags gebruikt';
                        if ($user->cars->where('created_at', '>=', now()->subYear())->isEmpty()) $reasons[] = 'Geen nieuwe auto\'s in laatste jaar';
                    @endphp

                    @foreach ($reasons as $reason)
                        <li>{{ $reason }}</li>
                    @endforeach
                </ul>
            </div>
        @empty
            <p class="text-gray-600 dark:text-gray-400 col-span-full">
                Geen opvallende aanbieders gevonden.
            </p>
        @endforelse
    </div>
</x-filament::page>
