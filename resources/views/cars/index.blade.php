<x-app-layout>
    <h1 class="text-2xl font-bold text-blue-800 mb-4">Auto's te koop</h1>

    <form method="GET" class="mb-4 flex gap-2">
        <input name="search" value="{{ request('search') }}" placeholder="Zoek op merk of model" class="p-2 border rounded w-full" />
        <select name="tag" class="p-2 border rounded">
            <option value="">-- Tags --</option>
            @foreach ($tags as $tag)
                <option value="{{ $tag->name }}" {{ request('tag') == $tag->name ? 'selected' : '' }}>{{ $tag->name }}</option>
            @endforeach
        </select>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Zoeken</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($cars as $car)
            <div class="border rounded-lg shadow p-4 {{ $loop->index % 5 === 0 ? 'col-span-2' : '' }}">
                <h2 class="text-xl font-semibold text-blue-800">{{ $car->brand }} {{ $car->model }}</h2>
                <p>Kenteken: {{ $car->license_plate }}</p>
                <p>Prijs: €{{ number_format($car->price, 2, ',', '.') }}</p>
                <p>KM-stand: {{ number_format($car->mileage, 0, ',', '.') }} km</p>

                <div class="mt-2 flex gap-1 flex-wrap">
                    @foreach ($car->tags as $tag)
                        <span class="badge bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $tag->name }}</span>
                    @endforeach
                </div>

                <a href="{{ route('cars.show', $car) }}" class="inline-block mt-4 text-blue-600 hover:underline">Bekijk details</a>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $cars->links() }}
    </div>
</x-app-layout>
