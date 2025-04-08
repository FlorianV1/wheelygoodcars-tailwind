<x-app-layout>
    <div class="max-w-5xl mx-auto bg-white px-6 md:px-10 py-10 rounded-xl shadow-lg grid gap-10 text-gray-800">

        {{-- Titel --}}
        <div class="text-center space-y-1">
            <h1 class="text-3xl md:text-4xl font-extrabold text-blue-800">
                {{ $car->brand }} {{ $car->model }}
            </h1>
            <p class="text-sm text-gray-500 tracking-widest">
                Kenteken: {{ $car->license_plate }}
            </p>
        </div>

        {{-- Afbeelding (compact en gecentreerd) --}}
        @if($car->image)
            <div class="flex justify-center">
                <img src="{{ asset('storage/' . $car->image) }}"
                     alt="Afbeelding van {{ $car->brand }} {{ $car->model }}"
                     class="w-full max-w-md h-64 object-cover rounded-lg shadow-sm">
            </div>
        @endif

        {{-- Info in 2 kolommen --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm md:text-base">
            @php
                $info = [
                    'Prijs' => '€' . number_format($car->price, 2, ',', '.'),
                    'KM-stand' => number_format($car->mileage, 0, ',', '.') . ' km',
                    'Kleur' => $car->color ?? '–',
                    'Bouwjaar' => $car->production_year ?? '–',
                    'Zitplaatsen' => $car->seats ?? '–',
                    'Deuren' => $car->doors ?? '–',
                    'Gewicht' => $car->weight ? $car->weight . ' kg' : '–',
                    'Weergaven' => $car->views,
                ];
            @endphp

            @foreach($info as $label => $value)
                <div class="flex justify-between items-center px-4 py-2 border border-gray-100 rounded">
                    <span class="text-gray-600 font-medium">{{ $label }}:</span>
                    <span class="text-right">{{ $value }}</span>
                </div>
            @endforeach
        </div>

        {{-- Tags --}}
        @if($car->tags->count())
            <div>
                <h2 class="text-sm text-gray-500 mb-1">Tags:</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($car->tags as $tag)
                        <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Actieknoppen --}}
        <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center border-t pt-8 pb-4">

            {{-- Link terug --}}
            <a href="{{ url()->previous() }}" class="text-sm text-blue-600 hover:underline">
                ← Terug naar overzicht
            </a>

            {{-- Knoppen rechts --}}
            <div class="flex flex-wrap gap-2 md:gap-4 justify-start md:justify-end">
                <button class="bg-green-600 text-white px-5 py-2 rounded-md hover:bg-green-700 transition text-sm">
                    🚗 Koop deze auto
                </button>

                @auth
                    <a href="{{ route('cars.pdf', $car) }}"
                       class="inline-block mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                       target="_blank">
                        📄 Genereer PDF
                    </a>
                @if(auth()->id() === $car->user_id)
                        <a href="{{ route('cars.edit', $car) }}"
                           class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition text-sm">
                            ✏️ Bewerken
                        </a>

                        <form method="POST" action="{{ route('cars.destroy', $car) }}"
                              onsubmit="return confirm('Weet je zeker dat je deze auto wilt verwijderen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 text-white px-5 py-2 rounded-md hover:bg-red-600 transition text-sm">
                                🗑️ Verwijderen
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>

        {{-- Toast Pop-up --}}
        <script>
            setTimeout(() => {
                const toast = document.createElement('div');
                toast.innerText = "10 mensen bekeken deze auto vandaag!";
                toast.className = "fixed bottom-6 right-6 bg-blue-700 text-white px-5 py-3 rounded-xl shadow-xl animate-fade-in";
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 5000);
            }, 10000);
        </script>

        <style>
            @keyframes fade-in {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fade-in 0.5s ease-out;
            }
        </style>
    </div>
</x-app-layout>
