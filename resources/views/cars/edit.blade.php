<x-app-layout>
    <h1 class="text-2xl font-bold mb-6 text-blue-800">Auto bewerken</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <form id="car-form" method="POST" action="{{ route('cars.update', $car) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full" style="width: 100%"></div>
                </div>
                <div class="flex justify-between mt-1 text-xs text-gray-500">
                    <span>Details</span>
                    <span>Tags</span>
                </div>
            </div>

            <!-- Step 1: Car Details -->
            <div id="step-1" class="step">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2">Kenteken</label>
                        <input type="text" name="license_plate" value="{{ $car->license_plate }}" disabled class="w-full border border-gray-300 rounded p-2 bg-gray-100">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Merk</label>
                        <input type="text" name="brand" value="{{ $car->brand }}" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Model</label>
                        <input type="text" name="model" value="{{ $car->model }}" class="w-full border border-gray-300 rounded p-2" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Zitplaatsen</label>
                        <input type="number" name="seats" value="{{ $car->seats }}" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Aantal deuren</label>
                        <input type="number" name="doors" value="{{ $car->doors }}" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Jaar van productie</label>
                        <input type="number" name="production_year" value="{{ $car->production_year }}" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Kleur</label>
                        <input type="text" name="color" value="{{ $car->color }}" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Kilometerstand</label>
                        <input type="number" name="mileage" value="{{ $car->mileage }}" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Massa rijklaar</label>
                        <input type="number" name="weight" value="{{ $car->weight }}" class="w-full border border-gray-300 rounded p-2">
                    </div>

                    <div>
                        <label class="block text-gray-700 mb-2">Vraagprijs</label>
                        <div class="flex">
                            <span class="bg-gray-100 border border-gray-300 rounded-l p-2 text-center">€</span>
                            <input type="number" name="price" value="{{ $car->price }}" step="0.01" class="w-full border border-gray-300 rounded-r p-2" required>
                        </div>
                    </div>

                    <div>
                        <label for="image" class="block text-gray-700 mb-2">Nieuwe afbeelding uploaden (optioneel)</label>
                        <input type="file" name="image" class="w-full border border-gray-300 rounded p-2">
                    </div>
                </div>
            </div>

            <!-- Step 2: Tags -->
            <div class="mt-6">
                <label class="block text-gray-700 mb-2">Tags bewerken</label>
                <div class="flex flex-wrap gap-2 mb-4">
                    @php
                        $predefinedTags = ['sportief', 'zuinig', 'elektrisch', 'gezinswagen', 'nieuwstaat', 'automaat', 'offroad'];
                        $carTagNames = $car->tags->pluck('name')->toArray();
                    @endphp

                    @foreach($predefinedTags as $tag)
                        <button
                            type="button"
                            class="tag-btn px-3 py-1 rounded border border-blue-300 hover:bg-blue-100 {{ in_array($tag, $carTagNames) ? 'bg-blue-500 text-white' : '' }}"
                        >
                            {{ $tag }}
                        </button>
                    @endforeach
                </div>

                <div id="selected-tags" class="flex flex-wrap gap-2 mb-4">
                    @foreach ($carTagNames as $tag)
                        <span class="px-3 py-1 rounded bg-blue-500 text-white">{{ $tag }}</span>
                    @endforeach
                </div>

                <input type="hidden" id="tags-input" name="tags" value='@json($carTagNames)'>
            </div>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('cars.my') }}" class="text-blue-600 hover:underline">← Terug</a>
                <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Opslaan</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let selectedTags = JSON.parse(document.getElementById('tags-input').value || '[]');

            document.querySelectorAll('.tag-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const tag = this.textContent.trim();

                    if (selectedTags.includes(tag)) {
                        selectedTags = selectedTags.filter(t => t !== tag);
                        this.classList.remove('bg-blue-500', 'text-white');
                    } else {
                        selectedTags.push(tag);
                        this.classList.add('bg-blue-500', 'text-white');
                    }

                    updateSelectedTags();
                });
            });

            function updateSelectedTags() {
                const container = document.getElementById('selected-tags');
                container.innerHTML = '';
                selectedTags.forEach(tag => {
                    const tagEl = document.createElement('span');
                    tagEl.textContent = tag;
                    tagEl.className = 'px-3 py-1 rounded bg-blue-500 text-white';
                    container.appendChild(tagEl);
                });

                document.getElementById('tags-input').value = JSON.stringify(selectedTags);
            }
        });
    </script>
</x-app-layout>
