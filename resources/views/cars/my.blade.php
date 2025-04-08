<x-app-layout>
    <h1 class="text-2xl font-bold text-blue-800 mb-4">Mijn aanbod</h1>

    <div class="overflow-x-auto bg-white shadow rounded-lg p-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-medium text-blue-800">Kenteken</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-blue-800">Merk / Model</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-blue-800">Prijs</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-blue-800">Status</th>
                <th class="px-4 py-2 text-left text-sm font-medium text-blue-800">Acties</th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
            @foreach ($cars as $car)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 whitespace-nowrap">{{ $car->license_plate }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">{{ $car->brand }} {{ $car->model }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">€{{ number_format($car->price, 2, ',', '.') }}</td>
                    <td class="px-4 py-2 whitespace-nowrap">
                        @if ($car->isSold())
                            <span class="text-red-500 font-medium">Verkocht</span>
                        @else
                            <span class="text-green-500 font-medium">Beschikbaar</span>
                        @endif
                    </td>

                    <td class="px-4 py-2 whitespace-nowrap space-x-1">
                        {{-- Bewerken --}}
                        <a href="{{ route('cars.edit', $car) }}"
                           class="inline-block text-sm bg-green-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                            ✏️ Bewerken
                        </a>
                        <a href="{{ route('cars.pdf', $car) }}"
                           class="inline-block text-sm bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">
                            📄 Genereer PDF
                        </a>

                        {{-- Verwijderen --}}
                        <form method="POST" action="{{ route('cars.destroy', $car) }}"
                              class="inline-block"
                              onsubmit="return confirm('Weet je zeker dat je deze auto wilt verwijderen?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                🗑️ Verwijder
                            </button>
                        </form>

                        {{-- Status updaten --}}
                        <form method="POST" action="{{ route('cars.updateStatus', $car) }}" class="inline-block">
                            @csrf
                            <button class="text-sm bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                @if ($car->isSold())
                                    🔁 Markeer als beschikbaar
                                @else
                                    ✅ Markeer als verkocht
                                @endif
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
