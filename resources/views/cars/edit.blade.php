<x-app-layout>
    <h1 class="text-2xl font-bold text-blue-800 mb-4">Auto bewerken</h1>

    <form method="POST" action="{{ route('cars.update', $car) }}" class="bg-white p-6 rounded shadow" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700">Vraagprijs</label>
            <input type="number" name="price" value="{{ old('price', $car->price) }}" class="w-full border border-gray-300 rounded p-2">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Kleur</label>
            <input type="text" name="color" value="{{ old('color', $car->color) }}" class="w-full border border-gray-300 rounded p-2">
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('cars.index') }}" class="text-blue-600 hover:underline">← Terug</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Opslaan</button>
        </div>
    </form>
</x-app-layout>
